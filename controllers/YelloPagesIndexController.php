<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Documentation\APIDocumentation;
use app\models\YellowPagesDataLoaders\YellowPagesDataLoaderFactory;
use app\models\ElasticIndexGenerators\ElasticIndexGeneratorFactory;
use app\models\Exceptions\VersionNotSupportedException;
use app\models\ElasticSearch\ElasticClient;
use Elasticsearch\ClientBuilder;

class YellowPagesIndexController extends Controller
{
    public function resetIndex()
    {
        $index = config('elasticserver.donee_index', 'donees');
        $hosts = config('elasticserver.hosts');

        $client = (new ElasticClient($hosts))->getClient();

        if(!$client->indices()->exists(['index' => config('elasticserver.donee_index', 'donees')]))
        {
            return response()->json(['status' => 'error', 'message' => 'index does not exist']);
        }

        try
        {
             $loader = (new YellowPagesDataLoaderFactory())->getLoader(config('elasticserver.version'));
             $response = $loader->resetElasticIndex($client, $index);
        }
        catch(versionNotSupportedException $e)
        {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

        return response()->json($response);
    }
}
