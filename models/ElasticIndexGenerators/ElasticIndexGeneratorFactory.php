<?php

namespace app\models\ElasticIndexGenerators;

use app\models\ElasticIndexGenerators\V6\V6Generator;
use app\models\ElasticIndexGenerators\V5\V5Generator;
use app\models\Exceptions\VersionNotSupportedException;


class ElasticIndexGeneratorFactory
{

    public static function getGenerator($version)
    {
        switch ($version) {
            case '5':
                return new V5Generator();
                break;

            case '6':
                return new V6Generator();
                break;
            
            default:
                throw new VersionNotSupportedException('This version is not supported yet');
                break;
        }

    }
}
