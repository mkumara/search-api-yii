<?php
//need to modify this class if this class is needed by the system 
namespace app\models\GeoCities;

use app\models\ElasticSearch\SearchCache;

class DataLoader
{

	public function loadData($fileName)
	{
		try
		{
			//database 0 is used by elastic search
			SearchCache::changeDB(env('GEO_CITIES_REDIS_STORE_DATABASE', 1));
			//$this->readData($fileName);

			echo SearchCache::getHash('sellersburg_indiana', 'location');

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
		
	}

	private function readData($fileName)
	{

		$names = [
            'country_code' => 0,
            'postal_code' => 1, // zip
            'place_name' => 2, // city
            'admin_name1' => 3, // state
            'admin_code1' => 4, // state code
            'admin_name2' => 5, // county (?)
            'admin_code2' => 6, // county code
            'admin_name3' => 7,
            'admin_code3' => 8,
            'latitude' => 9,
            'longitude' => 10,
            'accuracy' => 11
        ];

		if (($handle = fopen($fileName, "r")) !== FALSE)
		{
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
		    {
		    	if($data[$names['admin_name1']] !='')
		    	{
		    		$key = strtolower($data[$names['place_name']]).'_'.strtolower($data[$names['admin_name1']]);
		    		$value =json_encode([$data[$names['latitude']], $data[$names['longitude']]]);
		    		SearchCache::setHash($key, 'location', $value);
		    	}

		    }
		    fclose($handle);
		}
	}
}
