<?php
namespace app\models\WebSockets;

use app\models\ElasticSearch\ElasticClient;
use app\models\Queries\QueryFactory;
use app\models\ElasticSearch\SearchCache;

class WebSocketResponse
{
    public static function generate($request)
    {
        //database 1 is used by geo cities hash
        SearchCache::changeDB(env('SEARCH_CACHE_DATABASE', 0));
    	$term = $request['term'];

        if (isset($request['location']))
        {
        	$location = $request['location'];
        }
        else
        {
            //Need to decide where to put as default location
            //may be the last known location or most popular location.
            //or a better way of estimating user's location
        	$location = env('DEFAULT_LOCATION'); //this value is only for testing, must be removed in production
        }       

       $redisKey = SearchCache::makeKey($location, $term);

       if( SearchCache::available($redisKey))
        {
            return SearchCache::get($redisKey);
        }
        else
        {
            $geoDistance = env('GEO_DISTANCE', '10').'km';

            $offset=config('elasticserver.results_offset',0);
            $limit=config('elasticserver.results_limit',25);        
            $fields=config('elasticserver.fields_to_search', ['name','state', 'address', 'city','zip','spelled_state','abbreviation']);
            $source = config('elasticserver.fields_to_include', ['name','state', 'address', 'city','zip','spelled_state','abbreviation']);
            $version =config('elasticserver.version',6);
            $index = config('elasticserver.donee_index', 'donees');

            $hosts = config('elasticserver.hosts');
            $client = (new ElasticClient($hosts))->getClient();
             
            if(!$client->indices()->exists(['index' => $index]))
            {
                return json_encode(['status' => 'error', 'message' => 'index does not exist']);
            }

            $query = (QueryFactory::getGenerator($version))::getQuery($index, $term, $fields, $source, $location, $geoDistance);
            $response = $client->search($query);
            SearchCache::set($redisKey, json_encode($response));

            return json_encode($response);

        }       

    }
}
