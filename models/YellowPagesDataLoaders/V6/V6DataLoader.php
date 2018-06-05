<?php

namespace app\models\YellowPaesDataLoaders\V6;

use app\models\Eloquent\YellowPage;
use app\models\ElasticSearch\YPElasticDocument;
use app\models\YellowPaesDataLoaders\V6\V6Parameter;


class V6DataLoader
{
	public function resetElasticIndex($client, $index)
    {
        $bulkSize = config('elasticserver.bulk_size');
        //http://laraveldaily.com/process-big-db-table-with-chunk-method/
        YellowPage::chunk($bulkSize, function($donees) use ($index, $client)
        {
            $body['body']=[];

            foreach ($donees as $donee)
            {
               $formattedDocument = YPElasticDocument::formatDocument($donee);
               $parameters = V6Parameter::generate($donee->donee_id, $index);
               $body['body'][] = $parameters;
               $body['body'][] = $formattedDocument;     
            }
             
            $res = $client->bulk($body);
        });

        return true;       
    }
}
