<?php

namespace app\models\ElasticIndexGenerators\V5;

class V5Mapping
{
    public function getMapping($indexName, $numberOfShards = 1, $numberOfReplicas = 0)
    {
        $index = [
            'index' => self::$indexName,
            'refresh' => 'true',
            'body' => [
                'settings' => [
                    'index' => [
                        'number_of_shards' => $numberOfShards,
                        'number_of_replicas' => $numberOfReplicas
                    ],

                    "analysis" => [
                        "analyzer" => [
                            "my_stopwords_analyzer" => [
                                "type" => "custom",
                                "tokenizer" => "whitespace",
                                "char_filter" => ['my_char_filter'],
                                "filter" => ["en_stop", 'lowercase']
                            ]
                        ],

                        "filter" => [
                            "en_stop" => [
                                "type" => "stop",
                                "stopwords" => "_english_",
                                "ignore_case" => true
                            ]
                        ],

                        "char_filter" => [ // index only words and numbers
                            "my_char_filter" => [
                                "type" => "pattern_replace",
                                "pattern" => "[^\d\w\s]",
                                "replacement" => " ",
                            ],
                         ],
                    ]
                ],
                'mappings' => [
                    'all' => [
                        'properties' => [
                            'name' => [
                                "analyzer" => "my_stopwords_analyzer",
                                'type' => 'text',
                                //"norms" => [ "enabled" => false ],
                                //"index_options" => "docs",
                                //"fielddata" => true,
                                //"store" => true,
                            ],
                            'abbreviation' => [
                                'type' => 'text',
                                //"norms" => [ "enabled" => false ],
                                "index_options" => "docs",
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
                                'index' => false,
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
                                'type' => 'text'
                            ],
                            'unregistered' => [
                                'index' => true,
                                'type' => 'boolean'
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
                        ],
                    ],
                ],
            ],
        ];

      return $index;

    }
}
