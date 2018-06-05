<?php

namespace app\models\YellowPagesDataLoaders\V6;

class V6Parameter
{
	public static function generate($id, $index)
	{

       return [
              'index' => [
                        '_index' => $index,
                        '_type' => 'all',
                        '_id' => $id
                       ]
              ];
	}	
}

