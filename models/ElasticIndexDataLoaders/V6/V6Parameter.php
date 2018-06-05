<?php

namespace app\models\ElasticIndexDataLoaders\V6;

class V6Parameter
{
  //this will generate parameters for bulk operations
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

  //this will generate parameters for single operations
  public static function generateSingle($id, $index)
  {

       return [
                 'index' => $index,
                 'type' => 'all',
                 'id' => $id
                       
              ];
  } 
}

