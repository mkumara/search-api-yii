<?php

return [
    'adminEmail' => 'admin@example.com',
    'elasticserver'=> 
    [
    	'version' => 6,
		'hosts' => ['elasticsearch:9200'],
		'donee_index' => 'donees',
		'enable_log' => true,
		'bulk_size' => 100,
		'number_of_shards' => 1,
		'number_of_replicas' => 0,
		'fields_to_search' => ['name','state', 'address', 'city','zip','spelled_state', 'abbreviation', 'synonyms'],
		'fields_to_include' => ['name','state', 'address', 'city','zip','spelled_state', 'donee_type', 'coords'],
		'enable_cache' => true,
		'enable_logging' => true,
		'geo_distance' => 10,
		'results_offset' => 0,
		'results_limit' => 50,
		'cache_duration' => 1E+6, // one week cache expire duration in seconds
    ],

    'synonyms' =>
    [
    	'terms' =>
				[
				"1st" => "1 first ",
				"first" => "1 1st ",
				"2nd" => "2 second ",
				"second" => "2 2nd ",
				"st." => "saint st",
				"saint" => "st. st",
				"mount" => "mt. mt",
				"mt" => "mount"
				],
    ],
    'trigger' =>
    [
    	'recipients' => ['jayantha@givelify.com'],
		'emailSubject' => 'Donee_info buffer trigger failed to execute',
		'emailMessage' => 'Donee_info table has a trigger setup to populate donee_info_buffer table.\n This trigger failed to execute for a long time',
    ]


];
