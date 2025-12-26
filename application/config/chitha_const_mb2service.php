<?php
defined('SETTLEMENT_SVAMITVA')       or define('SETTLEMENT_SVAMITVA', 25);
if(SETTLEMENT_KHAS_LAND_ID=='16'){
	$name='Settlement of Khas and ceiling Surplus land';
}else if(SETTLEMENT_TENANT_ID=='13'){
	$name='Settlement of Occupancy Tenant';
}else if(SETTLEMENT_SPECIAL_CULTIVATORS_ID=='18'){
	$name='Settlement of special cultivators';
}else if(SETTLEMENT_TRIBAL_COMMUNITY_ID=='15'){
	$name='Settlement of hereditary land of Tribal Communities';
}else if(SETTLEMENT_AP_TRANSFER_ID=='14'){
	$name='Settlement of AP transferred land from original AP holder';
}else if(SETTLEMENT_PGR_VGR_LAND_ID=='17'){
	$name='Regularization of settlement of PGR VGR LAND';
}else if(SETTLEMENT_SVAMITVA=='25'){
	$name='Settlement of land in surveyed N.C. village under SVAMITVA';
}
define('MB2_SEVICE_NAME', $name);

// define('CHITHA_UPDATE_ALLOWED', json_encode(['16','18','15','14']));
define('MB3_SERVICES', ['42','25','39','41','44','45','40']);
define('CHITHA_UPDATE_ALLOWED', json_encode(array_merge(['16','18','15','14'], MB3_SERVICES)));
define('BUNAKSHA_API_LINK', "http://129.154.247.103/bhunaksha5/splitSSO");
define('BUNAKSHA_SPLIT_SSO_CONS', "dsgfdsgerhrerbdfbdfberqsdwdwbrebrtbfvrvr3rcwlkjoijwmnbvwjegckencjkwegcyg3cb3kbchj3gc23ckjn2jkldhiu43gdjk43nj43hui4gfkj4fb4jfgy4gf34fj34bfi34gfi");

define('MAP_FOR_PROPERTY_CONTINUE', 0); // 0= show

define('PROPERTY_TYPE_OPTIONS', [
    'Assam Type House',
    'RCC Building',
    'Chali House',
    'No Structure'
]);


define('GOV_NAME_CHANGES_FLOW',['LM','CO','ADC']);
define('JUNK_DAG_FLOW',['LM','CO']);

