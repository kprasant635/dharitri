<?php  

define('RECLASS_ID',40);
define('RECLASS_SUITE','RECLS');
define('RECLASS_SERVICE_NAME', 'Offering Reclassification Suite');

define('ENABLE_BUTTON_LM_SUBMIT_RECLS', OPEN);
define('ENABLE_BUTTON_CO_TO_DC_RECLS',OPEN);
define('MEETING_PROPOSAL_DLC_NOTICE_DATE', '2026-01-10 23:59:59');
define('MEETING_PROPOSAL_DLC_NOTICE_DATE_SHOW', '10th January 2026');
define('MEETING_PROPOSAL_DLC_NOTICE_HOLD', OPEN);
define('SEND_PROPOSAL_TO_SDLAC_MEM_BUTTON_RECLS', OPEN);
define('SEND_PROPOSAL_TO_SDLAC_MEM_BUTTON_RECLS_DLC', CLOSE);
define('MEETING_PROPOSAL_DLC_NOTICE_DATE_INPUT', '2026-01-11 00:00:00');

define('REJECTED_REMARK_HEAD_RECLASS', json_encode([
  ['CODE' => 7, 'NAME' => 'LAND NOT FIT FOR RECLASSIFICATION', 'STATUS' => 1],
  ['CODE' => 2, 'NAME' => 'Possession Related issues', 'STATUS' => 1],
  ['CODE' => 3, 'NAME' => 'Identity Mismatch Issues', 'STATUS' => 1],
  ['CODE' => 4, 'NAME' => 'Applicant Ineligibility issues', 'STATUS' => 1],
  //['CODE' => 5, 'NAME' => 'WRONG SERVICE APPLICATION', 'STATUS' => 1],
  ['CODE' => 6, 'NAME' => 'Self declaration issues', 'STATUS' => 1],
]));

define('WETLAND', json_encode(['0160','0106','0177']));
define('NON_AGRI', json_encode(['2','3','4','6','10']));
define('NON_RESIDENTIAL', json_encode(['1','3','4','6','10']));

define('VALIDATION_BYPASS_RECLASS', json_encode([
    ['SERVICE_CODE' => RECLASS_ID, 'REJECTED_CODE' => ['2','3','4','5','6','22','23']]
]));


?>


