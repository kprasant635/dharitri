<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "login/index";
$route['404_override'] = '';

$route['home'] = 'Home';
$route['Login/(:any)'] = 'login/$1';
$route['home/(:any)'] = 'Home/$1';
$route['cofieldmutation'] = 'COFieldMutation';
$route['cofieldmutation/(:any)'] = 'COFieldMutation/$1';
$route['rtps'] = 'Rtps';
$route['rtps/(:any)'] = 'Rtps/$1';
$route['Jamabandi'] = 'JamaBandi';
$route['Jamabandi/(:any)'] = 'JamaBandi/$1';
$route['JamaeditEntry'] = 'JamaEditEntry';
$route['JamaeditEntry/(:any)'] = 'JamaEditEntry/$1';
$route['jamaeditentry'] = 'JamaEditEntry';
$route['jamaeditentry/(:any)'] = 'JamaEditEntry/$1';
$route['utility'] = 'Utility';
$route['utility/(:any)'] = 'Utility/$1';
$route['skmutation'] = 'SKMutation';
$route['skmutation/(:any)'] = 'SKMutation/$1';
$route['ChithaReport'] = 'chithareport';
$route['ChithaReport/(:any)'] = 'chithareport/$1';
$route['partition/(:any)'] = 'Partition/$1';
$route['partition']='Partition';
$route['allotment/(:any)'] = 'Allotment/$1';
$route['allotment']='Allotment';
$route['backLogMutation/(:any)'] = 'BackLogMutation/$1';
$route['backLogMutation']='BackLogMutation';
$route['chithareport/(:any)']='chithareport/$1';
$route['chithareport']='chithareport';
$route['CitizenController']='citizencontroller';
$route['CitizenController/(:any)']='citizencontroller/$1';
$route['DharitreeApi']='dharitreeApi';
$route['findCases/(:any)']='FindCases/$1';
//************* added on 01/09/2023
$route['searching-data'] = 'SearchingController/loadSearchingViewPage';
$route['load-bhumiputra-view'] = 'BhumiputraController/loadViewPage';
$route['get-bhumiputra-pagination'] = 'BhumiputraController/getBhumiputraPagination';
$route['get-bhumiputra-status-api'] = 'BhumiputraController/getBhumiputraStatusApi';
$route['load-fetched-bhumiputra-data'] = 'BhumiputraController/loadFetchedBhuhmiputraData';
$route['get-bhumiputra-inserted-data'] = 'BhumiputraController/getBhumiputraInsertedData';


//============ added on 04/11/2023 ================
$route['load-bhumiputra-view'] = 'BhumiputraController/loadViewPage';
$route['get-bhumiputra-pagination'] = 'BhumiputraController/getBhumiputraPagination';
$route['get-bhumiputra-status-api'] = 'BhumiputraController/getBhumiputraStatusApi';
$route['load-fetched-bhumiputra-data'] = 'BhumiputraController/loadFetchedBhuhmiputraData';
$route['get-bhumiputra-inserted-data'] = 'BhumiputraController/getBhumiputraInsertedData';

// =========== added by Abhijit on 07-12-2023 ================= 
$route['refresh'] = 'AjaxController/getRefreshedCsrf';
$route['not-whitelisted-param'] = 'AuditController/auditNotWhitelistedParam';

// =========== added by Abhijit on 02-03-2024 ================= 
$route['legacy-data-updation/revert'] = 'LegacyDataUpdation/revertCase';
$route['legacy-data-updation/get-history'] = 'LegacyDataUpdation/getLogs';

// =========== added by Deep on 18-04-2024 ================= 
$route['disposed-cases/get'] = 'disposedCasesReport/districtDetails';
$route['disposed-cases/show'] = 'disposedCasesReport/disposedRejectedCases';
$route['disposed-cases/show/(:any)'] = 'disposedCasesReport/disposedRejectedCases/$1';

$route['get-file'] = 'uploadDocuments/getDocument';

$route['land-classes'] = 'LandclassController/index';
$route['land-class-delete'] = 'LandclassController/destroy';

$route['land-class-groups'] = 'LandclassgroupController/index';
$route['land-class-group/class/update'] = 'LandclassgroupController/updateMap';
$route['land-class-group/class/get-other-suggestion'] = 'LandclassgroupController/getSuggesion';
$route['land-class-group/class-map/freeze'] = 'LandclassgroupController/freezeMapping';
$route['land-class-group/class-map/approve'] = 'LandclassgroupController/adcapproveMapping';
$route['land-class-group/class-map/final-approve'] = 'LandclassgroupController/approveMapping';
$route['land-class-group/class-map/master-setup'] = 'LandclassgroupController/masterIndex';
$route['land-class-group/class-map/master-setup/save'] = 'LandclassgroupController/masterUpdate';

$route['patta-type-groups'] = 'PattacodegroupController/index';
$route['patta-type-group/patta-type/update'] = 'PattacodegroupController/updateMap';
$route['patta-type-group/patta-type-map/freeze'] = 'PattacodegroupController/freezeMapping';
$route['patta-type-group/patta-type-map/approve'] = 'PattacodegroupController/approveMapping';


$route['add-nok'] = 'rtps/addNok';
$route['get-noks'] = 'rtps/getNoks';
$route['delete-noks'] = 'rtps/deleteNok';


$route['rejected-data'] = 'RejectedController/rejectedData';

$route['logs'] = "LogController/index";

//Conversion Routes for Mb3 (Added by Hridayjit)
//CO
$route['mb3_conversion_co'] = 'Home/Mb3ConversionCo';
$route['go_to_co'] = "conversion/CoConversionController/GoToCO";
$route['co_bulk_forward_to_lra'] = "COconversionPartha/CoToLMFD";
$route['co_chitha_not_updated_cases'] = "COconversionPartha/penidngForChithaUpdate";
$route['co_first_proceeding'] = 'conversion/CoConversionController/firstProceeding';
$route['co_first_proceeding_post'] = "conversion/CoConversionController/firstProceedingPost";
$route['co_second_proceeding'] = "conversion/CoConversionController/secondProceeding";
$route['co_second_proceeding_post'] = "conversion/CoConversionController/secondProceedingPost";
$route['co_chitha_update'] = "conversion/CoConversionController/chithaUpdate";

$route['check-query-api'] = "CaseAPI/checkQueryAPI";


//LM
$route['mb3_conversion_lm'] = 'Home/Mb3ConversionLm';
$route['go_to_lm'] = "conversion/LmConversionController/GoToLM";
$route['lm_first_proceeding'] = 'conversion/LmConversionController/lmFirstProceeding';
$route['get_single_pattadar_details'] = 'conversion/LmConversionController/getSinglePattadarDetails';
$route['applicant_submit'] = 'conversion/LmConversionController/applicantSubmit';
$route['applicant_delete'] = 'conversion/LmConversionController/applicantDelete';
$route['calculate_premium/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'conversion/LmConversionController/CalculatePremium/$1/$2/$3/$4/$5/$6/$7/$8';
$route['lm_first_proceeding_post'] = 'conversion/LmConversionController/lmFirstProceedingPost';
$route['calculate_premium_mb3'] = 'conversion/LmConversionController/CalculatePremiumMb3';

//SK
$route['mb3_conversion_sk'] = 'Home/Mb3ConversionSk';
$route['go_to_sk'] = "conversion/SkConversionController/GoToSK";
$route['sk_first_proceeding'] = "conversion/SkConversionController/skFirstProceeding";
$route['sk_first_proceeding_post'] = "conversion/SkConversionController/skFirstProceedingPost";

//AST
$route['mb3_conversion_ast'] = "Home/Mb3ConversionAst";
$route['go_to_ast'] = "conversion/AstConversionController/GoToAST";
$route['ast_premium_notice'] = "conversion/AstConversionController/premiumNotice";
$route['ast_premium_notice_save'] = "conversion/AstConversionController/premiumNoticeSave";
$route['ast_premium_confirm'] = "conversion/AstConversionController/premiumConfirm";
$route['ast_premium_confirm_post'] = "conversion/AstConversionController/premiumConfirmSave";

$route['ReclassSuiteCo'] = "dharitreeApi/ReclassSuiteCo";

$route['co_final_order'] = "conversion/CoConversionController/coFinalOrder";
$route['co_final_order_post'] = "conversion/CoConversionController/coFinalOrderPost";
$route['get_new_dag_patta'] = 'conversion/CoConversionController/getNewDagPattaTypeJSON';
$route['save_premium_notice'] = "conversion/AstConversionController/savePremiumNotice";
$route['checkPaymentRevivalMb3'] = "DharitreeApiMbThree/checkPaymentRevivalMb3";
$route['checkPaymentRevival'] = "dharitreeApi/checkPaymentRevival";

$route['payment_declined_cases'] = "conversion/CoConversionController/paymentDeclinedCases";
$route['payment_declined_cases_post'] = "conversion/CoConversionController/paymentDeclinedCasesPost";
$route['reverted_cases_dc_adc'] = "conversion/CoConversionController/rejectedSecondProceeding";
$route['reverted_cases_dc_adc_post'] = "conversion/CoConversionController/regenerateAfterReject";

$route['get-lra-files'] = "MultipleFileUploadMB3/getLRAFiles";

$route['co_all_cases'] = "conversion/CoConversionController/coAllCases";
$route['delete_conv_doc'] = "conversion/CoConversionController/deleteConvDoc";

$route['registerAcq'] = "dharitreeApi/register";
