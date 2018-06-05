<?php

namespace app\models\ElasticIndexDataLoaders\V6;

use yii\db\Query;
use app\models\Eloquent\Donee;
use app\models\ElasticSearch\ElasticDocument;
use app\models\ElasticIndexDataLoaders\V6\V6Parameter;


class V6DataLoader
{
    	public function resetElasticIndex($client, $index)
      {
            $query = (new Query())->from('donee_info');

            foreach ($query->batch() as $donees) 
            {
                 $body['body']=[];

                        foreach ($donees as $donee)
                        {
                           $formattedDocument = ElasticDocument::formatDocument($donee);
                           $parameters = V6Parameter::generate($donee['donee_id'], $index);
                           $body['body'][] = $parameters;
                           $body['body'][] = $formattedDocument;     
                        }
                         
                        $res = $client->bulk($body);
            }
                return true;       
      }
}

