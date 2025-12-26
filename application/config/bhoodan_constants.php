<?php  

define('BHODDAN_SERVICE_MENU_NAME', 'Bhoodan Lands');
define('BHODDAN_SERVICE_NAME', 'Settlement of unsettled erstwhile Bhoodan/Gramdan Lands');
define('BHODDAN_SERVICE_CODE', 39);
define('BHODDAN_PREFIX', 'SBGL');

define('MEETING_PROPOSAL_SDLAC_NOTICE_BHOODAN_DATE_SHOW', '10th January 2026');
define('MEETING_PROPOSAL_SDLAC_NOTICE_BHOODAN_DATE_INPUT', '2026-02-11 00:00:00');
define('MEETING_PROPOSAL_SDLAC_NOTICE_BHOODAN_DATE', '2026-02-11 23:59:59');


define('VALIDATION_BYPASS_BHOODAN', json_encode([
    ['SERVICE_CODE' => BHODDAN_SERVICE_CODE, 'REJECTED_CODE' => ['502','503', '504', '504', '505', '506', '507', '508', '509', '510', '511', '512', '513', '514', '515', '516', '517', '518', '519', '520']],
]));


define('BHOODAN_ENABLE_AREA_BUTTON', 1);

?>
