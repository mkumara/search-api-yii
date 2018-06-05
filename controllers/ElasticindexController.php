<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Documentation\APIDocumentation;
use app\models\ElasticIndexDataLoaders\ElasticIndexDataLoaderFactory;
use app\models\ElasticIndexGenerators\ElasticIndexGeneratorFactory;
use app\models\Exceptions\VersionNotSupportedException;
use app\models\ElasticSearch\ElasticClient;
use Elasticsearch\ClientBuilder;

class ElasticindexController extends Controller
{
    public function actionIndex()
    {
        return (new APIDocumentation())->getIndexAPIDoc();

    }

    public function actionCreate()
    {
        $config = \Yii::$app->params['elasticserver'];
    	$hosts = $config['hosts'];
    	$client = (new ElasticClient($hosts))->getClient();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         
    	if($client->indices()->exists(['index' => $config['donee_index']]))
        {
    		return ['status' => 'error', 'message' => 'index already exists'];
        }

        try
        {
        	// Create the index with mappings and settings
            $generator = (new ElasticIndexGeneratorFactory())->getGenerator($config['version']);
    		$response = $generator->generate($client);
        }
        catch(versionNotSupportedException $e)
        {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

		return  $response;
    }

    public function actionDelete()
    {
        $config = \Yii::$app->params['elasticserver'];
    	$hosts = $config['hosts'];
    	$client = (new ElasticClient($hosts))->getClient();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    	if(!$client->indices()->exists(['index' => $config['donee_index']]))
        {
    		return ['status' => 'error', 'message' => 'index does not exist'];
        }

    	$params = ['index' => $config['donee_index']];
        $response = $client->indices()->delete($params);
        return $response;

    }

    public function actionGetindices()
    {
    	$config = \Yii::$app->params['elasticserver'];
        $hosts = $config['hosts'];
    	$client = (new ElasticClient($hosts))->getClient();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = $client->indices();

        return $response;

    }

    public function actionReset()
    {
       
        $config = \Yii::$app->params['elasticserver'];
        $hosts = $config['hosts'];
        $index = $config['donee_index'];

        $client = (new ElasticClient($hosts))->getClient();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(!$client->indices()->exists(['index' => $config['donee_index']]))
        {
            return ['status' => 'error', 'message' => 'index does not exist'];
        }

        try
        {
             $loader = (new ElasticIndexDataLoaderFactory())->getLoader($config['version']);
             $response = $loader->resetElasticIndex($client, $index);
        }
        catch(versionNotSupportedException $e)
        {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return $response;
    }
}
