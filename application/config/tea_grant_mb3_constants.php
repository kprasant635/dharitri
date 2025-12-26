<?php  

define('TEA_SERVICE_MENU_NAME', 'Tea Grant to Periodic Patta');
define('TEA_SERVICE_NAME', 'Limited Conversion Of Tea Grant Land To Periodic Patta');
define('TEA_SERVICE_CODE', 43);
define('TEA_PREFIX', 'TGPP');

define('GENERAL_NOTICE_PATH_ADC', UPLOAD_BASE.'adc_general_notice/');

define('SRO_REPORT_MANDATE', 1);
define('TEA_EDIT_AREA', 1);

define('TEA_GRANT_MAX_APPLIED', 75); // in bigha

// staging
// define('VALIDATION_BYPASS_TEA_GRANT', json_encode([
//     ['SERVICE_CODE' => TEA_SERVICE_CODE, 'REJECTED_CODE' => ['427','428', '429', '430', '431', '432', '433', '434', '435', '436', '437', '438', '439', '440', '441', '442', '443', '444', '445', '446', '447', '448', '449', '450', '451', '452', '453', '454', '455', '456', '457', '458','459','460','461','462','463','464','465','466','467','468','469','470','471','472']],
// ]));

// define('UPLOAD_DIR_TEA', STORAGE_IP.'dharitree_gitlab/uploads/tea_grant/'); // staging

// production
define('VALIDATION_BYPASS_TEA_GRANT', json_encode([
    ['SERVICE_CODE' => TEA_SERVICE_CODE, 'REJECTED_CODE' => ['485','486', '487', '488', '489', '490', '491', '492', '493', '494', '495', '496', '497', '498', '499', '500', '501']],
]));

define('UPLOAD_DIR_TEA', STORAGE_IP.'uploads/tea_grant/'); // production

if (is_dir(UPLOAD_DIR_TEA) === false) {
    mkdir(UPLOAD_DIR_TEA, 0777, true);
}

define('TEAGRANT_ENABLE_AREA_BUTTON', 1);

define('NGDRS_SRO_PUSH_PROD', 'https://landhub.assam.gov.in/nocApi/dhar_ngdrs/co_query_pd.php');
define('NGDRS_SRO_PUSH_STAGE', 'https://landhub.assam.gov.in/nocApi/dhar_ngdrs/co_query.php');

define('DISABLE_ALL_BUTTON', 0);


?>
