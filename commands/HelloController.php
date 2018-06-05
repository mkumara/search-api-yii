<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Elasticsearch\ClientBuilder;
use app\models\ElasticSearch\ElasticClient;
use app\models\Eloquent\Donee;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

       // $index = config('elasticserver.donee_index', 'donees');

      //  $hosts = ['elasticsearch'];//config('elasticserver.hosts');

       // $client = (new ElasticClient($hosts))->getClient();
        //var_dump(Donee::primaryKey());

        \Yii::info('blah', 'elastic');
        
        return ExitCode::OK;
    }
}
