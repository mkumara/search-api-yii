<?php

namespace app\models\ElasticIndexGenerators\V6;

class V6Generator
{
	public function generate($client)
    {
    	$config = \Yii::$app->params['elasticserver'];
        $mapping = (new V6Mapping())->getMapping($config['donee_index'],
    											 $config['number_of_shards'],
    										     $config['number_of_replicas']);
        
        // Create the index with mappings and settings
        return $client->indices()->create( $mapping);

    }
}
