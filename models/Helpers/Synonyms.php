<?php

namespace app\models\Helpers;

class Synonyms
{

	public static function generate($string)
    {
        $config = \Yii::$app->params['synonyms'];
    	$stringLower = strtolower($string);
    	$synonyms = $config['terms'];

        $terms = explode(" ", $stringLower);
        $result = "";

        foreach ($terms as $term) 
        {
        	if (isset($synonyms[$term]))
        	{
        		$result .=$synonyms[$term];
        	}        	
        }

        return $result;
    }	
}
