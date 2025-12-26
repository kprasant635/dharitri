<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('DIGITAL_PATTA_PATTA_INFO_DATE_OF_ISSUE', date("d/m/y"));
define('DIGITAL_PATTA_TERMINAL_DATE','30/09/2028');
define('DIGITAL_SIGN_SERVER_TIME_URL','http://localhost/dscapi/getServerTime');

if ($_SERVER['HTTP_HOST'] =='10.177.0.34')
{
    defined('DIGITAL_PATTA_FINAL_UPLOAD_DIR') OR define('DIGITAL_PATTA_FINAL_UPLOAD_DIR', './uploads/digital_patta/');
}
else
{
    defined('DIGITAL_PATTA_FINAL_UPLOAD_DIR') OR define('DIGITAL_PATTA_FINAL_UPLOAD_DIR', 'G:\\uploads\\digital_patta\\');

}
if (is_dir(DIGITAL_PATTA_FINAL_UPLOAD_DIR) === false) {
    mkdir(DIGITAL_PATTA_FINAL_UPLOAD_DIR);
}
define('DIGITAL_PATTA_AADHAAR_NO','NA');
define('DIGITAL_PATTA_AADHAAR','AADHAAR');
define('ENABLE_DIGITAL_PATTA_BATCH_SIGN',3);
define('DIGITAL_PATTA_CHECK_LIMIT',100);
define('DIGITAL_PATTA_MENU',1);
define('SIKRITI_PATRA_GET_SKETCH_URL', 'http://localhost/dharitreeSVN/index.php/dharitreeApi/traceMapAttachment');
define('BASUNDHARA_LIVE_URL', 'http://localhost/rtpsmb');
define('BASUNDHARA_URL', 'http://localhost/rtpsmb2demo');
define('DIGITAL_PATTA_SECRET_KEY','application_libraries123456789');
define('DIGITAL_PATTA_TO_GENERATE' ,array('RTPS/SKCSL/2023/558689','RTPS/SKCSL/2022/374694','RTPS/SKCSL/2022/5045','RTPS/SHLTC/2022/436668','RTPS/SKCSL/2023/1263544','RTPS/SKCSL/2023/850360','RTPS/SKCSL/2023/886819','RTPS/SKCSL/2022/442551','RTPS/SKCSL/2022/215008','RTPS/SKCSL/2022/185321'));
define('DIGITAL_PATTA_CO_MENU_ACTIVE' ,1);
define('DIGITAL_PATTA_TO_EXCLUDE' ,array(
    'RTPS/SKCSL/2022/88368',
    'RTPS/SKCSL/2022/122689',
    'RTPS/SKCSL/2022/93041',
    'RTPS/SKCSL/2022/211321',
    'RTPS/SKCSL/2023/662951',
    'RTPS/SKCSL/2022/133161',
    'RTPS/SKCSL/2022/268994',
    'RTPS/SKCSL/2022/73922',
    'RTPS/SKCSL/2022/419630'
    ));
















?>
