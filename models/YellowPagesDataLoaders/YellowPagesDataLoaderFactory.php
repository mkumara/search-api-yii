<?php

namespace app\models\YellowPagesDataLoaders;

use app\models\ElasticIndexDataLoaders\V5\V5DataLoader;
use app\models\YellowPagesDataLoaders\V6\V6DataLoader;
use app\models\Exceptions\VersionNotSupportedException;


class YellowPagesDataLoaderFactory
{

    public static function getLoader($version)
    {
        switch ($version) {
            case '5':
                return new V5DataLoader();
                break;

            case '6':
                return new V6DataLoader();
                break;
            
            default:
                throw new VersionNotSupportedException('This version is not supported yet');
                break;
        }

    }
}
