<?php

define('EKHAJANA_PENDING_LIST_COUNT_API', EKHAJANA_API_BASE.'Ekhajana/getEkhajanaPendingListCount');
define('EKHAJANA_PENDING_LIST_API', EKHAJANA_API_BASE.'Ekhajana/getEkhajanaPendingList');
define('EKHAJANA_PENDING_CASE_DETAILS_API', EKHAJANA_API_BASE.'Ekhajana/getEkhajanaPendingCaseDetails');
define('EKHAJANA_LM_FORAWRDED_API', EKHAJANA_API_BASE.'Ekhajana/lmForward');
define('EKHAJANA_CO_FORAWRDED_API', EKHAJANA_API_BASE.'Ekhajana/coForward');
define('EKHAJANA_PAYMENT_UPDATE_API', EKHAJANA_API_BASE.'Ekhajana/updatePayment');
define('EKHAJANA_DOWNLOAD_DOCUMENT_API',EKHAJANA_API_BASE.'Ekhajana/ekhajanaAttachment');
define('EKHAJANA_CO_REJECTED_API',EKHAJANA_API_BASE.'Ekhajana/coReject');
define('EKHAJANA_DOWNLOAD_DOCUMENT_API_FOR_CO', EKHAJANA_API_BASE.'Ekhajana/downloadDocumentForCo');
define('EKHAJANA_REVERT_CASE_API', EKHAJANA_API_BASE.'Ekhajana/updateRevertDetails');
define('EKHAJANA_PAYMENT_RE_UPDATE_BY_CO_API',EKHAJANA_API_BASE.'Ekhajana/reUpdatePayment');
define('EKHAJANA_CHECK_PAYMENT_STATUS_BEFORE_REUPDATE', EKHAJANA_API_BASE.'Ekhajana/checkPaymentQuerybeforeUpdate');
define('EKHAJANA_LOT_MONDOL_PENDING_LIST_COUNT_API', EKHAJANA_API_BASE.'Ekhajana/getPendingCountForlotMondol_mouzadar');
define('EKHAJANA_PENDING_LIST_API_FOR_MOUZADARI_SYSTEM', EKHAJANA_API_BASE.'Ekhajana/getPendingListForlotMondol_mouzadar');
define('EKHAJANA_PENDING_CASE_DETAILS_API_MOUZADRI_SYSTEM', EKHAJANA_API_BASE.'Ekhajana/getEkhajanaPendingCaseDetails');
define('EKHAJANA_LM_FORAWRDED_API_MOUZADARI_SYSTEM', EKHAJANA_API_BASE.'Ekhajana/updateLMforwardMouzadariSystem');
define('EKHAJANA_LM_FORAWRD_MOUZADARI_SYSTEM', EKHAJANA_API_BASE.'Ekhajana/lmForwardMouzadariSystem');
define('EKHAJANA_DISPOSE_UPDATE_API', EKHAJANA_API_BASE.'Ekhajana/coDisposeCase');
define('EKHAJANA_AADHAAR_PHOTO_FETCH', EKHAJANA_API_BASE.'Ekhajana/getApplicantPhoto');
define('EKHAJANA_API_FOR_DETAIL_CASE_STATUS', EKHAJANA_API_BASE.'EkhajanaReportController/getCaseDetailsStatus');

define('EKHAJANA_API_FOR_CO_COUNT_CIRCLE', EKHAJANA_API_BASE.'EkhajanaReportController/getCircleWiseCount');
define('EKHAJANA_API_FOR_CO_COUNT_LOT', EKHAJANA_API_BASE.'EkhajanaReportController/getLotWiseCount');
define('EKHAJANA_API_FOR_DETAIL_CASE', EKHAJANA_API_BASE.'EkhajanaReportController/getLotWiseCaseDetails');

define('EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API', ILRMS_API_BASE.'DepartmentApi/postDepartmentUser');

define('doul_year_no','2031');

//E-KHAJANA CONSTANTS
define('JAMA_WASIL_STATUS_OFFLINE', 'offline');
define('JAMA_WASIL_STATUS_ONLINE', 'online');
define('JAMA_WASIL_ACTION_MOUZDAR_ENTRY', 'mouzadar_arrear_update');
define('JAMA_WASIL_ACTION_MOUZDAR_ENTRY_UPDATE', 'mouzadar_arrear_new_update');
define('JAMA_WASIL_ACTION_CO_ENTRY', 'co_arrear_update');
define('JAMA_WASIL_ACTION_CO_ENTRY_UPDATE', 'co_arrear_new_update');
define('JAMA_WASIL_ACTION_AST_ENTRY', 'ast_arrear_update');
define('JAMA_WASIL_ACTION_AST_ENTRY_UPDATE', 'ast_arrear_new_update');

define('EKHAJANA_STATUS_LM_FORWARD', 'LM-F');
define('EKHAJANA_STATUS_CO_FORWARD', 'CO-F');
define('EKHAJANA_STATUS_COMPLETED', 'F');
define('EKHAJANA_STATUS_REJECTED', 'R');
//menu active/deactive 
define('EKHAJANA_LM_MENU_ACTIVE', 1);//1 FOR ACTIVE, O FOR DEACTIVE
define('EKHAJANA_CO_MENU_ACTIVE', 1);//1 FOR ACTIVE, O FOR DEACTIVE
define('EKHAJANA_AST_MENU_ACTIVE', 1);//1 FOR ACTIVE, O FOR DEACTIVE

define('EKHAJANA_MOUZDAR_CODE', 'MOU');

define('EKHAJANA_MOUZADAR_MENU_ACTIVE', 1);
define('EKHAJANA_AST_MOU_REVERT', 'L');
define('JAMA_WASIL_ACTION_CO_ENTRY_REUPDATE', 'co_arrear_reupdate');
define('EKHAJANA_STATUS_MOU_FORWARD', 'MOU_F');

define('EKHAJANA_STATUS_COMBINE_FORWARD', 'COM_F');
define('EKHAJANA_STATUS_LM_FORWARD_MOUZADARI_SYSTEM', 'MLM_F');
define('EKHAJANA_MOUZADAR_OBJECTION', 'M_OBJ');
define('EKHAJANA_MOUZADAR_CO_ACTIVE', 1);

define('JAMA_WASIL_STATUS_PAID', 'PAID');
define('JAMA_WASIL_STATUS_UNPAID', 'UNPAID');

define('EKHAJANA_GET_PAYMENT_AMOUNT_FOR_CIRCLE',EKHAJANA_API_BASE.'EkhajanaApiController/getEkhajanaAmountReceivedForCircle');
define('EKHAJANA_DC_DEMAND_SATISFY_MENU_ACTIVE',1);

define('EKHAJANA_UPLOAD_MAX_SIZE',  2000000);              // MAX size in BYTES
define('EKHAJANA_UPLOAD_ALLOW_TYPE', 'pdf');              // allow type
define('EKHAJANA_UPLOAD_TYPE_VALIDATION',
    array('PDF','pdf')); // allow type validation

define('UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA', './uploads/ekhajana/');
define('EKHAJANA_CO_REPORT_MENU_ACTIVE',1);

define('EKHAJANA_GET_PAYMENT_AMOUNT_DATE_WISE',EKHAJANA_API_BASE.'EkhajanaApiController/getDateWiseKhajanaAmount');

// TN BRANCH EKHAJANA
define('EKHAJANA_TN_MENU_ACTIVE', 1);
define('EKHAJANA_PENDING_LIST_COUNT_TN_BRANCH_API',EKHAJANA_API_BASE.'EkhajanaDp/pendingCountTn');
define('EKHAJANA_PENDING_LIST_TN_BRANCH_API',EKHAJANA_API_BASE.'EkhajanaDp/pendingListTn');
define('EKHAJANA_PENDING_CASE_DETAILS_DP_ESTATE_API',EKHAJANA_API_BASE.'EkhajanaDp/getEkhajanaPendingCaseDetailsForDpEstate');
define('EKHAJANA_PENDING_LIST_COUNT_DP_ESTATE_FOR_LM',EKHAJANA_API_BASE.'EkhajanaDp/getEkhajanaPendingCountForLm');
define('EKHAJANA_PENDING_LIST_FOR_LM_DP_ESTATE_API',EKHAJANA_API_BASE.'EkhajanaDp/getEkhajanaPendingListForLm');
define('EKHAJANA_PENDING_CASE_DETAILS_LM_FOR_DP_ESTATE_API',EKHAJANA_API_BASE.'EkhajanaDp/getEkhajanaPendingCaseDetailsDpEstate');
// status
define('EKHAJANA_STATUS_LM_FORWARD_DP_ESTATE','LM_DP');
define('EKHAJANA_STATUS_TN_FORWARD_DP_ESTATE','TN_DP');
define('EKHAJANA_STATUS_COMBINE_FORWARD_DP_ESTATE','CM_DP');
define('EKHAJANA_STATUS_CO_FORWARD_DP_ESTATE','DP_CF');
// Api
define('EKHAJANA_LM_FORAWRDED_API_DP_ESTATE_FIRST',EKHAJANA_API_BASE.'EkhajanaDp/updateEkhajanaAfterLmforwardDpEstateFirst');
define('EKHAJANA_LM_FORWARDED_API_DP_ESTATE_SECOND',EKHAJANA_API_BASE.'EkhajanaDp/updateEkhajanaAfterLmforwardDpEstateSecond');
define('EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_FIRST',EKHAJANA_API_BASE.'EkhajanaDp/updateEkhajanaAfterTnforwardDpEstateFirst');
define('EKHAJANA_TN_FORAWRDED_API_DP_ESTATE_SECOND',EKHAJANA_API_BASE.'EkhajanaDp/updateEkhajanaAfterTnforwardDpEstateSecond');
define('EKHAJANA_CO_FORWARD_FOR_DP_EASTAE_API',EKHAJANA_API_BASE.'EkhajanaDp/updateEkhajanaAfterCoforwardDpEstate');
define('EKHAJANA_DISPOSE_DP_ESTATE_UPDATE_API',EKHAJANA_API_BASE.'EkhajanaDp/dpEstateDisposeCase');

define('EKHAJANA_AREEAR_PRE_UPDATED', 'PU'); //PU for Preupdated
define('EKHAJANA_PRE_ARREAR_YEARS', ['2000','2001','2002','2003','2004','2005','2006','2007','2008','2009','2010','2011','2012','2013','2014','2015','2016','2017','2018','2019','2020','2021','2022','2023']);
define('EKHAJANA_AST_PRE_ARREAR_UPDATE',0); 

define('EKHAJANA_LM_DP_ESTATE_SYSTEM',1);
define('EKHAJANA_LM_MOUZADARI_SYSTEM',1);
define('EKHAJANA_CO_MOUZADARI_SYSTEM',1);
define('EKHAJANA_CO_DP_ESTATE_SYSTEM',1);
define('EKHAJANA_NEW_MOUZADAR_DATE','2023-07-01');

?>