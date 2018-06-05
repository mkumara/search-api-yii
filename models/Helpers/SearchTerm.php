<?php

namespace app\models\Helpers;

class SearchTerm
{
	static public function clean($string)
    {
        return preg_replace("#,\s+(,|$)\s*#", '', $string);
    }
	
}
