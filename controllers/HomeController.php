<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Documentation\APIDocumentation;
use app\models\Exceptions\VersionNotSupportedException;
use app\models\ElasticIndexDataLoaders\ElasticIndexDataLoaderFactory;
use app\models\ElasticIndexGenerators\ElasticIndexGeneratorFactory;
use app\models\Helpers\Synonyms;

class HomeController extends Controller
{
    public function index()
    {
        return (new APIDocumentation())->getIndexAPIDoc();

    }

    public function testSynonyms()
    {
    	return json_encode(Synonyms::generate("1st 2nd "));
    }

    public function test()
    {
    	try{
    	 $generator = (new ElasticIndexGeneratorFactory())->getGenerator(7);
    	}
    	catch(VersionNotSupportedException $e)
    	{
    		return json_encode($e->getMessage());
    	}
    }
}
