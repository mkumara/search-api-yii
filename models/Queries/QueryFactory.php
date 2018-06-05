<?php

namespace app\models\Queries;

use app\models\Queries\V6\V6QueryGenerator;
use app\models\Queries\V5\V5QueryGenerator;
use app\models\Exceptions\VersionNotSupportedException;

class QueryFactory
{
    public static function getGenerator($version)
    {
        switch ($version) {
            case '5':
                return new V5QueryGenerator();
                break;

            case '6':
                return new V6QueryGenerator();
                break;
            
            default:
                throw new VersionNotSupportedException('This version is not supported yet');
                break;
        }
    }
}
