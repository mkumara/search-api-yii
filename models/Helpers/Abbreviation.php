<?php

namespace app\models\Helpers;

class Abbreviation
{
	public static function  generate($string)
	{
		$abbrs = self::extractAbbreviations($string);

        // find possible abbreviations
        $abbreviation = strtolower(preg_replace('~\b(\w)|.~', '$1', $string));
        $abbrs[] = $abbreviation;

       /* for($i = 1; $i < strlen($abbreviation); $i++){
            $abbrs[] = substr($abbreviation, 0, $i).' '.substr($abbreviation, $i);
        }*/
        return array_unique($abbrs);

	}

	private static function extractAbbreviations($string)
    {
        $extAbbr = [];

        // find abbreviations from characters + dots/spaces
        preg_replace_callback("#\b((?:[A-Za-z][.\s]+(?![A-Za-z]{2}))+)#", function($m) use (&$extAbbr){
            $extAbbr[] = strtoupper(preg_replace("#[.\s]#", '', $m[1]));
        }, $string);

        // 2+ upper case characters are considered as abbreviations
        preg_replace_callback("#\b([A-Z\d]{2,}+)#", function($m) use (&$extAbbr){
            $extAbbr[] = strtoupper(preg_replace("#[.\s]#", '', $m[1]));
        }, $string);

        return array_unique($extAbbr);
    }

		
	
}
