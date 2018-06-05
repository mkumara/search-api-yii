<?php

namespace app\models\ElasticSearch;

use Illuminate\Support\Facades\Redis;

class SearchCache
{
	public static function available($key)
	{
		$cache = \Yii::$app->cache;
		return $cache->exists($key);
	}

	public static function get($key)
	{
		$cache = \Yii::$app->cache;
		return $cache->get($key);

	}

	public static function set($key, $value)
	{
		$config = \Yii::$app->params['elasticserver'];
		$duration = $config['cache_duration'];
		$cache = \Yii::$app->cache;
		$cache->set($key, $value, $duration);

	}

	public static function makeKey($location, $term)
	{ 	
		$config = \Yii::$app->params['elasticserver'];
		$geoDistance = $config['geo_distance'];
		if($location != null)
		{
			$lonLat = explode(',', $location);
			$long = substr($lonLat[0], 0, (strpos($lonLat[0], '.')+ env('DECIMAL_PALCES_LOCATION', 2) +1 ));
	        $lat = substr($lonLat[1], 0, (strpos($lonLat[1], '.')+ env('DECIMAL_PALCES_LOCATION', 2) + 1));

	       return $long.$lat.$term.$geoDistance;
		}
		else
		{
			 return $term.$geoDistance;
		}
		
	}	
}
