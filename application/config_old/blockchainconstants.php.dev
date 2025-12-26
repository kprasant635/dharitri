<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




// property chain constants
define('LOC_TYPE_RURAL', 'R');
define('LOC_TYPE_URBAN', 'U');

// bhunaksha api link

define('BHUNAKSHA_URL', 'http://10.177.7.136/bhudemo');
define('BHUNAKSHA_API', BHUNAKSHA_URL . '/Api/index.php/MasterApi/');
define('BHUNAKSHA_API_ULPIN', BHUNAKSHA_URL . '/rest/MapData/getUlpinDetails');
define('BHUNAKSHA_GEOJSON_API', BHUNAKSHA_URL . '/rest/MapInfo/getPlotGeoJSon');
define('BHUNAKSHA_VIEW_MAP', BHUNAKSHA_URL . '/showgeojson.jsp');
define('JWT_KEY', "abcd123haryanasinglesigonapplicationDFFEFSDAFE");


// define('ASSETS_PATH', base_url() . '/assets');
define('BLOCK_CHAIN_LOCATIONS', array('07_01_01_02_01_10004','08_01_01_01_01_10001','08_01_01_01_01_10002','08_01_01_01_01_10003','08_01_01_01_01_10004'));

define('MAX_CHAIN_CREATE', 10); // do not give value more than 100
define('MAX_CHAIN_UPDATE', 10); // do not give value more than 25

if(ENABLED_BLOCKCHAIN_PROD == 1)
{
   // define('PROP_CHAIN_API_NEW_V2', 'https://landhub.assam.gov.in/propertychain/api/v1.2/');
}
else
{
    define('PROP_CHAIN_API_NEW_V2', 'http://10.177.0.37:8080/propertychain/api/v1.2/');
}


define('BULK_ROR_PARAM', 'ror_push');
define('BULK_MAP_PARAM', 'map_push');
define('BULK_UPDATE_PARAM', 'update_push');

define('ASSAM_STATE_CODE', '18');

define('CERTMNEMONIC_MUT', 'MUT');
define('CERTMNEMONIC_PRT', 'PRT');
define('CERTMNEMONIC_ROR', 'ROR');
define('CERTMNEMONIC_MAP', 'MAP');
define('CERTMNEMONIC_RECLASS', 'REC');
define('CERTMNEMONIC_NAMECORR', 'NCR');
define('CERTMNEMONIC_NAMECANCEL', 'NCL');
define('CERTMNEMONIC_CONV', 'CONV');
define('CONVERSION_FULL', 'FULL');
define('CONVERSION_PARTIAL', 'PARTIAL');
define('CERTMNEMONIC_ACPP', 'ALLT');
define('CERTMNEMONIC_LEGACY', 'LEGACY');
define('CERTMNEMONIC_BACKLOG_MUT', 'BLM');
define('CERTMNEMONIC_BACKLOG_PRT', 'BLP');
define('CERTMNEMONIC_BACKLOG_CONV', 'BLC');
define('CERTMNEMONIC_APCANCEL', 'APC');
define('CERTMNEMONIC_SETTM', 'SETT');

define('CERTMNEMONIC_REF_LIST', array(
    CERTMNEMONIC_MUT => 'Mutation',
    CERTMNEMONIC_PRT => 'Partition',
    CERTMNEMONIC_ROR => 'Chitha',
    CERTMNEMONIC_MAP => 'Map',
    CERTMNEMONIC_RECLASS => 'Reclassifiction',
    CERTMNEMONIC_NAMECORR => 'Name Correction',
    CERTMNEMONIC_NAMECANCEL => 'Name Cancellation',
    CERTMNEMONIC_CONV => 'Conversion',
    CERTMNEMONIC_ACPP => 'AC to PP',
    CERTMNEMONIC_LEGACY => 'Legacy Updation',
    CERTMNEMONIC_BACKLOG_MUT => 'Backlog Mutation',
    CERTMNEMONIC_BACKLOG_PRT => 'Backlog Partition',
    CERTMNEMONIC_BACKLOG_CONV => 'Backlog Conversion',
    CERTMNEMONIC_APCANCEL => 'AP Cancellation',
    CERTMNEMONIC_SETTM => 'Settlement',
    'SD' => 'Sale Deed'
));

define('MUT_TYPE_RECLASS', 'RECLASS');
define('MUT_TYPE_OFFPRT', 'OFC_PRT');
define('MUT_TYPE_OFFMUT', 'OFC_MUT');
define('MUT_TYPE_MISC', 'MISC');
define('MUT_TYPE_CONV', 'CONV');
define('MUT_TYPE_ACPP', 'ACPP');
define('MUT_TYPE_LEGACY', 'LEGACY');

define('ENABLED_BLOCKCHAIN_OPTIONAL_PUSH', 0);

define('BULK_PUSH_TRANSACTION_LIMIT', 1);

define('BLOCK_CHAIN_ALLOWED_CIRCLES', json_encode(
    [
       ['10000000005104', 1],['10000000005117',1] 
    ]
));

define('BLOCK_CHAIN_ALLOWED_VILLAGES', json_encode(
    [
       '10000000005158','10000000005394','10000000005355'
    ]
));

define('ALLOW_LANDREVENUE_FOR_BLOCKCHAIN',0);
?>


