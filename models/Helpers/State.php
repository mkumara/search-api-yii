<?php

namespace app\models\Helpers;

class State
{
	
	protected static $states = [
		"AL" => "Alabama", // Ala.
		"AK" => "Alaska", // Alaska
		"AS" => "American Samoa",
		"AZ" => "Arizona", // Ariz.
		"AR" => "Arkansas", // Ark.
		"CA" => "California", // Calif.
		"CO" => "Colorado", // Colo.
		"CT" => "Connecticut", // Conn.
		"DE" => "Delaware", // Del.
		"DC" => "Dist. of Columbia", // D.C.
		"FL" => "Florida", // Fla.
		"GA" => "Georgia", // Ga.
		"GU" => "Guam", // Guam
		"HI" => "Hawaii", // Hawaii
		"ID" => "Idaho", // Idaho
		"IL" => "Illinois", // Ill.
		"IN" => "Indiana", // Ind.
		"IA" => "Iowa", // Iowa
		"KS" => "Kansas", // Kans.
		"KY" => "Kentucky", // Ky.
		"LA" => "Louisiana", // La.
		"ME" => "Maine", // Maine
		"MD" => "Maryland", // Md.
		"MH" => "Marshall Islands",
		"MA" => "Massachusetts", // Mass.
		"MI" => "Michigan", // Mich.
		"FM" => "Micronesia",
		"MN" => "Minnesota", // Minn.
		"MS" => "Mississippi", // Miss.
		"MO" => "Missouri", // Mo.
		"MT" => "Montana", // Mont.
		"NE" => "Nebraska", // Nebr.
		"NV" => "Nevada", // Nev.
		"NH" => "New Hampshire", // N.H.
		"NJ" => "New Jersey", // N.J.
		"NM" => "New Mexico", // N.M.
		"NY" => "New York", // N.Y.
		"NC" => "North Carolina", // N.C.
		"ND" => "North Dakota", // N.D.
		"MP" => "Northern Marianas",
		"OH" => "Ohio", // Ohio
		"OK" => "Oklahoma", // Okla.
		"OR" => "Oregon", // Ore.
		"PW" => "Palau",
		"PA" => "Pennsylvania", // Pa.
		"PR" => "Puerto Rico", // P.R.
		"RI" => "Rhode Island", // R.I.
		"SC" => "South Carolina", // S.C.
		"SD" => "South Dakota", // S.D.
		"TN" => "Tennessee", // Tenn.
		"TX" => "Texas", // Tex.
		"UT" => "Utah", // Utah
		"VT" => "Vermont", // Vt.
		"VA" => "Virginia", // Va.
		"VI" => "Virgin Islands", // V.I.
		"WA" => "Washington", // Wash.
		"WV" => "West Virginia", // W.Va.
		"WI" => "Wisconsin", // Wis.
		"WY" => "Wyoming", // Wyo.
	];

	protected static $neighborStates = [
        'AL' => [ 'FL', 'GA', 'MS', 'TN' ],
        'AK' => [],
        'AZ' => [ 'CA', 'CO', 'NV', 'NM', 'UT' ],
        'AR' => [ 'LA', 'MS', 'MO', 'OK', 'TN', 'TX' ],
        'CA' => [ 'AZ', 'NV', 'OR' ],
        'CO' => [ 'AZ', 'KS', 'NE', 'NM', 'OK', 'UT', 'WY' ],
        'CT' => [ 'MA', 'NY', 'RI' ],
        'DE' => [ 'MD', 'NJ', 'PA' ],
        'FL' => [ 'AL', 'GA' ],
        'GA' => [ 'AL', 'FL', 'NC', 'SC', 'TN' ],
        'HI' => [],
        'ID' => [ 'MT', 'NV', 'OR', 'UT', 'WA', 'WY' ],
        'IL' => [ 'IN', 'IA', 'MI', 'KY', 'MO', 'WI' ],
        'IN' => [ 'IL', 'KY', 'MI', 'OH' ],
        'IA' => [ 'IL', 'MN', 'MO', 'NE', 'SD', 'WI' ],
        'KS' => [ 'CO', 'MO', 'NE', 'OK' ],
        'KY' => [ 'IL', 'IN', 'MO', 'OH', 'TN', 'VA', 'WV'],
        'LA' => [ 'AR', 'MS', 'TX' ],
        'ME' => [ 'NH' ],
        'MD' => [ 'DE', 'PA', 'VA', 'WV' ],
        'MA' => [ 'CT', 'NH', 'NY', 'RI', 'VT' ],
        'MI' => [ 'IL', 'IN', 'MN', 'OH', 'WI' ],
        'MN' => [ 'IA', 'MI', 'ND', 'SD', 'WI' ],
        'MS' => [ 'AL', 'AR', 'LA', 'TN' ],
        'MO' => [ 'AR', 'IL', 'IA', 'KS', 'KY', 'NE', 'OK', 'TN' ],
        'MT' => [ 'ID', 'ND', 'SD', 'WY' ],
        'NE' => [ 'CO', 'IA', 'KS', 'MO', 'SD', 'WY' ],
        'NV' => [ 'AZ', 'CA', 'ID', 'OR', 'UT' ],
        'NH' => [ 'ME', 'MA', 'VT' ],
        'NJ' => [ 'DE', 'NY', 'PA' ],
        'NM' => [ 'AZ', 'CO', 'OK', 'TX', 'UT' ],
        'NY' => [ 'CT', 'MA', 'NJ', 'PA', 'RI', 'VT' ],
        'NC' => [ 'GA', 'SC', 'TN', 'VA' ],
        'ND' => [ 'MN', 'MT', 'SD' ],
        'OH' => [ 'IN', 'KY', 'MI', 'PA', 'WV'  ],
        'OK' => [ 'AR', 'CO', 'KS', 'MO', 'NM', 'TX' ],
        'OR' => [ 'CA', 'ID', 'NV', 'WA' ],
        'PA' => [ 'DE', 'MD', 'NJ', 'NY', 'OH', 'WV' ],
        'RI' => [ 'CT', 'MA', 'NY' ],
        'SC' => [ 'GA', 'NC' ],
        'SD' => [ 'IA', 'MN', 'MT', 'NE', 'ND', 'WY' ],
        'TN' => [ 'AL', 'AR', 'GA', 'KY', 'MS', 'MO', 'NC', 'VA' ],
        'TX' => [ 'AR', 'LA', 'NM', 'OK' ],
        'UT' => [ 'AZ', 'CO', 'ID', 'NV', 'NM', 'WY' ],
        'VT' => [ 'MA', 'NH', 'NY' ],
        'VA' => [ 'KY', 'MD', 'NC', 'TN', 'WV' ],
        'WA' => [ 'ID', 'OR' ],
        'WV' => [ 'KY', 'MD', 'OH', 'PA', 'VA' ],
        'WI' => [ 'IL', 'IA', 'MI', 'MN' ],
        'WY' => [ 'CO', 'ID', 'MT', 'NE', 'SD', 'UT' ],
    ];


    public static function getStateName($state)
    {
    	$abbr = strtoupper($state);
    	if(isset(self::$states[$abbr]))
    	{
    		return self::$states[$abbr];
    	}

    	return "";    	
    }

    public static function getNeighborStates($state)
    {
    	$abbr = strtoupper($state);
    	if(isset(self::$neighborStates[$abbr]))
    	{
    		return self::$neighborStates[$abbr];
    	}

    	return [];   
    }

}
