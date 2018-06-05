<?php

namespace app\models\ElasticSearch;

use Elasticsearch\ClientBuilder;

class ElasticClient
{

    protected $hosts;
    protected $client;

    public function __construct($hosts)
    {
        $elastic_config = \Yii::$app->params['elasticserver'];
    	$this->hosts = $hosts;
    	$this->client = ClientBuilder::create()           // Instantiate a new ClientBuilder
                        ->setHosts($this->hosts);

        if($elastic_config['enable_log'])
         {
            //Logger adds to response time, so disabled. If it is really needed, eenable it
           // $logger = ClientBuilder::defaultLogger($elastic_config['log_path']);
           // $this->client->setLogger($logger);
         }
     
        $this->client = $this->client->build();              // Build the client object
    }

    public function getClient()
    {
        return $this->client;
    }
	   
}
