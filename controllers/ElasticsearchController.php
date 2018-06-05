<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Documentation\APIDocumentation;
use app\models\ElasticIndexGenerators\V6\V6Mapping;
use app\models\ElasticSearch\ElasticClient;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use app\models\Queries\QueryFactory;
use app\models\ElasticSearch\SearchCache;
use app\models\Loggers\SearchLog;

class ElasticsearchController extends Controller
{
    public function actionIndex()
    {
        return (new APIDocumentation())->getIndexAPIDoc();

    }

    public function actionSearch()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //database 1 is used by geo cities hash
       // SearchCache::changeDB(env('SEARCH_CACHE_DATABASE', 0));
        $term = Yii::$app->getRequest()->getQueryParam('term');

        $location = Yii::$app->getRequest()->getQueryParam('location');

        if (isset($location))
        {
        	$location = $request->get('location');
        }
        else
        {
        	$location = null;
        	//Austin 30.2672° N, 97.7431° W
        	//dallas 32.7767, -96.7970
        } 

        $config = \Yii::$app->params['elasticserver'];
        $hosts = $config['hosts'];

        $redisKey = SearchCache::makeKey($location, $term);

       if( SearchCache::available($redisKey) && $config['enable_cache'])
        {
            $data = json_decode(SearchCache::get($redisKey));
            if($config['enable_logging'])
            {

               \Yii::info(json_encode(['term'=> $term, 'result'=>$data]), 'elasticsearch');
            }
            
            return $data;
        }
        else
        {
            $geoDistance = $config['geo_distance'].'km';

            $offset = $config['results_offset'];
            $limit = $config['results_limit'];        
            $fields = $config['fields_to_search'];
            $source = $config['fields_to_include'];
            $version = $config['version'];
            $index = $config['donee_index'];

            $hosts = $config['hosts'];
            $client = (new ElasticClient($hosts))->getClient();
             
            if(!$client->indices()->exists(['index' => $index]))
            {
                return ['status' => 'error', 'message' => 'index does not exist'];
            }

            $query = (QueryFactory::getGenerator($version))::getQuery($index, $term, $fields, $source, $location, $geoDistance);
            $response = $client->search($query);
            //$responseSorted = $this->sortResults($response['hits'], $location);
            SearchCache::set($redisKey, json_encode($response));

            $data = json_encode($response);
             if($config['enable_logging'])
            {
                \Yii::info(json_encode(['term'=> $term, 'result'=>$data]), 'elasticsearch');
            }

            return $response;

        } 
    }

    private function sortResults($response, $location)
    {
        if( $location == null)
        {
            return $response;
        }

        $hits = $response['hits'];

        usort($hits, function($doneeA, $doneeB) use ($location) {
        $distance1=$this->getDistance($doneeA['_source']['coords'], $location);
        $distance2=$this->getDistance($doneeB['_source']['coords'], $location);

        if($distance1 > $distance2) 
        {
            return 1;
        }
        elseif($distance1 < $distance2) 
        {
            return -1;
        }
        else 
        {
            return 0;
        }        
       });

       $response['hits'] = $hits;

       return $response;
    }   

    private function getDistance($locationA, $locationB)
    {
        $location1 = explode(',', $locationA);
        $location2= explode(',', $locationB);

        $distance = sqrt(pow(($location1[0]-$location2[0]), 2) + pow(($location1[1]-$location2[1]), 2));

        return $distance;
    }
}
