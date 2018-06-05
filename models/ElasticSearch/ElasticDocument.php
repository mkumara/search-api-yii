<?php

namespace app\models\ElasticSearch;

use app\models\Helpers\Abbreviation;
use app\models\Helpers\Synonyms;
use app\models\Helpers\SearchTerm;
use app\models\Helpers\State;

class ElasticDocument
{

    public static function formatDocument($item)
    {
        if (is_array($item))
            $item = (object) $item;

        $state = strtoupper($item->state);
        $spelled_state = State::getStateName($state);

        $abbreviation = implode(" ", Abbreviation::generate($item->name));

        return [
            //'name_city' => $item->name.' of '.$item->city,

            'spelled_state' => $spelled_state,
            'active' => $item->active ? 1 : 0,

            'name' => $item->name,
            'synonyms' => Synonyms::generate($item->name),
            'abbreviation' => $abbreviation,

            'address' => $item->address,
            'city' => $item->city,
            'state' => $item->state,
            'country' => $item->country,
            'zip' => $item->zip,

            // don't index fields below
            'lat' => $item->donee_lat,
            'lon' => $item->donee_lon,

            'coords' => $item->donee_lat.', '.$item->donee_lon,

            'yp_id' => $item->yp_id,
            'leadid' => $item->leadid ? $item->leadid : 0,
            'phone' => $item->phone,
            'donee_id' => $item->donee_id,
            'donee_type' => $item->donee_type,
            'unregistered' => $item->unregistered,
            'website' => $item->website,

            'photo' => $item->photo,
            'logo' => $item->logo,
        ];
    }
	   
}
