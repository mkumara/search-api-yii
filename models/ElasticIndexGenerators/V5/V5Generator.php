<?php

namespace app\models\ElasticIndexGenerators\V5;

class V5Generator
{
	public function generate()
    {
        $mapping = (new V5Mapping())->getMapping(config('elasticserver.donee_index', 'donees'),
    											 config('elasticserver.number_of_shards', '1'),
    										     config('elasticserver.number_of_replicas', '0'));
        
        // Create the index with mappings and settings
        return $client->indices()->create( $mapping);

    }
}
