<?php

namespace app\models\ElasticIndexGenerators\V6;

class V6Mapping
{
	public function getMapping($indexName, $numberOfShards = 1, $numberOfReplicas = 0)
    {
        $index = [
            'index' => $indexName,
            'body' => [
                'settings' => [
                    'index' => [
                        'number_of_shards' => $numberOfShards,
                        'number_of_replicas' => $numberOfReplicas
                    ],

                    "analysis" => 
                     [
                            "filter" => 
                            [
                                "ngram_filter" => [
                                "type" => "ngram",
                                "min_gram" => 2,
                                "max_gram" => 20
                                 ]
                            ],

                    "analyzer" => 
                    [
                             "ngram_analyzer" =>
                             [
                                 "type" => "custom",
                                 "tokenizer" => "standard",
                            "filter" => 
                             [
                                 "lowercase",
                                 "ngram_filter"
                             ]
                            ]
                     ],
                 /*    "normalizer" => 
                     [
                        "my_normalizer" => 
                        [
                            "type" => "custom",
                            "char_filter" => [],
                            "filter" => ["lowercase", "asciifolding"]
                        ]
                    ]
                    */
                  ]
                ],
                'mappings' => [
                    'all' => [
                        'properties' => [
                            'name' => [
                                "analyzer" => "ngram_analyzer",
                                "search_analyzer" => "standard",
                                'type' => 'text',
                                'boost' => 3,
                            ],
                            'abbreviation' => [
                                'type' => 'text',
                                'index' => true,
                                "analyzer" => "ngram_analyzer",
                                "search_analyzer" => "standard",
                                'boost' => 2,
                            ],
                            'active' => [
                                'index' => true,
                                'type' => 'integer'
                            ],
                            'coords' => [
                                'index' => true,
                                'type' => 'geo_point'
                            ],
                            'phone' => [
                                'index' => true,
                                'type' => 'text'
                            ],
                            'lat' => [
                                'index' => true,
                                'type' => 'text'
                            ],
                            'lon' => [
                                'index' => true,
                                'type' => 'text'
                            ],
                            'yp_id' => [
                                'index' => false,
                                'type' => 'text'
                            ],
                            'donee_id' => [
                                'index' => false,
                                'type' => 'integer'
                            ],
                            'leadid' => [
                                'index' => false,
                                'type' => 'integer'
                            ],
                            'donee_type' => [
                                'index' => true,
                                'type' => 'text',
                                 "analyzer" => "ngram_analyzer",
                                 "search_analyzer" => "standard"
                            ],
                            'unregistered' => [
                                'index' => true,
                                'type' => 'integer'
                            ],
                            'website' => [
                                'index' => false,
                                'type' => 'text'
                            ],
                            'photo' => [
                                'index' => false,
                                'type' => 'text'
                            ],
                            'logo' => [
                                'index' => false,
                                'type' => 'text'
                            ],
                            'address' => [
                                'index' => true,
                                'type' => 'text',
                                 "analyzer" => "ngram_analyzer",
                                 "search_analyzer" => "standard",
                                // "normalizer" => "my_normalizer"
                            ],
                            'city' => [
                                'index' => true,
                                'type' => 'text',
                                 "analyzer" => "ngram_analyzer",
                                 "search_analyzer" => "standard",
                                // "normalizer" => "my_normalizer",
                                 'boost' => 2
                            ],
                            'state' => [
                                'index' => true,
                                'type' => 'text',
                                 "analyzer" => "ngram_analyzer",
                                 "search_analyzer" => "standard",
                                // "normalizer" => "my_normalizer",
                                 'boost' => 2
                            ],
                            'spelled_state' => [
                                'index' => true,
                                'type' => 'text',
                                 "analyzer" => "ngram_analyzer",
                                 "search_analyzer" => "standard",
                                // "normalizer" => "my_normalizer",
                                 'boost' => 2
                            ],
                            'synonyms' => [
                                'index' => true,
                                'type' => 'text',
                                 "analyzer" => "standard",
                                 "search_analyzer" => "standard",
                                 //"normalizer" => "my_normalizer",
                                 'boost' => 2
                            ],
                        ],
                    ],
                ],
            ],
        ];

      return $index;

    }
}
