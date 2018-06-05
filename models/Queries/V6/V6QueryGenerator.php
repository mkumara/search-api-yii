<?php

namespace app\models\Queries\V6;

class V6QueryGenerator
{
	public static function getQuery($index, $term, $fields, $sourceInclude=[], $location = null, $geoDistance = 10)
    {
    	$query = [
			 'index' => $index,
             'type' => 'all',
             '_source_include' => $sourceInclude,
             'body' => [
             	'size' => 50,
				'query' => [
					'bool' => [
						'should' => [
							'multi_match' => [
								'query' => $term,
								'fields' => $fields
							]
						],					   			
                ]
				]
			]
		];

		if($location != null)
		{
			$query['body']['sort'] = [
										[
		            						"_geo_distance" => 
		            						[
		                					"coords" => $location,
		                					"order" => "asc",
		                					"unit" => "km"
            				
        									]
        				  				],
        				  				 "_score"
        				 
    								];
		}
		
		return $query;
    }
}
