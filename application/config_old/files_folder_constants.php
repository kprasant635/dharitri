<?php
define('STORAGE_IP','/mnt/Data/dharitree/dev/');
defined('UPLOAD_DIR') OR define('UPLOAD_DIR', STORAGE_IP.'uploads/mb2/');
if (is_dir(UPLOAD_DIR) === false) {
    mkdir(UPLOAD_DIR, 0777, true);
}
defined('UPLOAD_BASE') OR define('UPLOAD_BASE', STORAGE_IP.'uploads/');
defined('BACKUP_DIR') OR define('BACKUP_DIR', STORAGE_IP.'uploads_back_feb224/');
defined('BACKUP_DIR_34') OR define('BACKUP_DIR_34', STORAGE_IP.'34_archieve/');
defined('BACKUP_DIR_35') OR define('BACKUP_DIR_35', STORAGE_IP.'35_archieve/');

define('UPLOAD_MAX_SIZE',  5000000);                     
define('UPLOAD_ALLOW_TYPE', 'jpg|JPG|jpeg|JPEG|png|PNG|pdf|PDF');         
define('UPLOAD_TYPE_VALIDATION',array('JPG','JPEG','PNG','PDF','jpg','jpeg','png','pdf'));
define('EKHAJANA_UPLOAD_MAX_SIZE',  2000000);              // MAX size in BYTES
define('EKHAJANA_UPLOAD_ALLOW_TYPE', 'pdf');              // allow type
define('EKHAJANA_UPLOAD_TYPE_VALIDATION',    array('PDF','pdf')); // allow type validation
define('FILES_TYPE', 'jpeg|jpg|png|pdf');
define('MAX_FILE_SIZE', '1024000');
define('MANUAL_ATTACHMENT', UPLOAD_BASE.'manualattachement/');
define('MANUAL_ATTACHMENT_MISCASE', MANUAL_ATTACHMENT.'miscases/');
define('AADHAAR_PHOTO', UPLOAD_BASE.'aadhaarPhoto/');
define('UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA',  UPLOAD_BASE.'ekhajana/');
define('UPLOAD_MANUAL_CHALAN_DIR',  UPLOAD_BASE.'challan/');
define('DEMAND_SATISFIED_CERTIFICATE_UPLOAD_DIR', UPLOAD_BASE.'demand_satisfied_certificates/');
define('LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_UPLOAD_LOCATION', UPLOAD_BASE.'/land_bank/');
define('NOK_UPLOAD_PATH', UPLOAD_BASE.'NOK_UPLOAD');
define('BS_PARTITION_UPLOAD_DIR',UPLOAD_BASE.'basundhara_dag_change/partition/');
define('DELIVERY_DOCS', UPLOAD_BASE.'delivery/');
define('PAYMENT_NOTICE_PATH', UPLOAD_BASE.'paymentNotice/');
define('CO_NOTICE_PATH', UPLOAD_BASE.'coNotice/');
defined('SEND_TO_SDLAC_NOTICE_PATH') or define('SEND_TO_SDLAC_NOTICE_PATH', UPLOAD_BASE.'dc_to_sdlac_notice/');
defined('GENERAL_NOTICE_PATH_DC') or define('GENERAL_NOTICE_PATH_DC', UPLOAD_BASE.'dc_general_notice/');
define('AADHAAR_UPLOAD_DIR', UPLOAD_BASE.'aadhaar_img/');
define('JB_BASE64_POST_FILE', UPLOAD_BASE.'JB/');
define('SIGNPDF_UPLOAD_DIR', UPLOAD_BASE.'digital_sign_minute/');
define('PROGRESS_DIR', UPLOAD_BASE.'progress/');
defined('DIGITAL_PATTA_FINAL_UPLOAD_DIR') OR define('DIGITAL_PATTA_FINAL_UPLOAD_DIR', UPLOAD_BASE.'digital_patta/');
define('IMAGE_PLACEHOLDER', UPLOAD_BASE.'preview_not_available.png');
define('SNA_DOC_ALLOW_TYPE', 'pdf');
define('SNA_UPLOAD_TYPE_VALIDATION', array('pdf','PDF'));
define('SNA_DOC_MAX_SIZE',  2000000);
define('SNA_DOCUMENT_UPLOAD_PATH', UPLOAD_BASE.'sna/');
define('METHODPAGE_UPLOAD_PATH', UPLOAD_BASE.'methodpagevisit/');
////////////Abhijeet/////////////////////
define('UPLOAD_SEPARATOR', '/');
defined('CERT_BASE_DIR') OR define('CERT_BASE_DIR', UPLOAD_BASE . 'Certificate' . UPLOAD_SEPARATOR); 
defined('ALLOTMENT_BASE_DIR') OR define('ALLOTMENT_BASE_DIR', UPLOAD_BASE . 'allotment' . UPLOAD_SEPARATOR); 
defined('CONVERSION_DOCS_BASE_DIR') OR define('CONVERSION_DOCS_BASE_DIR', UPLOAD_BASE . 'ConversionDocs' . UPLOAD_SEPARATOR); 
defined('CONVERSION_PREMCHALLAN_BASE_DIR') OR define('CONVERSION_PREMCHALLAN_BASE_DIR', CONVERSION_DOCS_BASE_DIR . 'PremChallan' . UPLOAD_SEPARATOR); 
defined('COMPOSITE_BASE_DIR') OR define('COMPOSITE_BASE_DIR', UPLOAD_BASE . 'composite' . UPLOAD_SEPARATOR); 
defined('ADD_PATTADAR_BASE_DIR') OR define('ADD_PATTADAR_BASE_DIR', UPLOAD_BASE . 'AddPattadar'); 
defined('ADD_REMARKS_BASE_DIR') OR define('ADD_REMARKS_BASE_DIR', UPLOAD_BASE . 'AddRemarks'); 
defined('REMOVE_DAG_BASE_DIR') OR define('REMOVE_DAG_BASE_DIR', UPLOAD_BASE . 'RemoveDag'); 
defined('BASE_DIR_34') OR define('BASE_DIR_34', '34' . UPLOAD_SEPARATOR . 'uploads' . UPLOAD_SEPARATOR); 
defined('BASE_DIR_35') OR define('BASE_DIR_35', '35' . UPLOAD_SEPARATOR . 'uploads' . UPLOAD_SEPARATOR);
///////////////Kingshook//////////////////////
defined('TRACE_MAP_BASE_DIR') OR define('TRACE_MAP_BASE_DIR', UPLOAD_BASE . 'tracemap/');
defined('FMUT_BASE_DIR') OR define('FMUT_BASE_DIR', UPLOAD_BASE . 'fieldmutation/');
defined('FPART_BASE_DIR') OR define('FPART_BASE_DIR', UPLOAD_BASE . 'fieldpartition/');
defined('OMUT_BASE_DIR') OR define('OMUT_BASE_DIR', UPLOAD_BASE . 'officemutation/');
defined('OPRAT_BASE_DIR') OR define('OPRAT_BASE_DIR', UPLOAD_BASE . 'officepartition/');
defined('ZONAL_REPORT_BASE_DIR') OR define('ZONAL_REPORT_BASE_DIR', UPLOAD_BASE . 'zonal_reports/');
defined('LDU_DOCS_BASE_DIR') OR define('LDU_DOCS_BASE_DIR', UPLOAD_BASE . 'LDUDocs');
defined('JUNK_DAGS_DELETE_BASE_DIR') OR define('JUNK_DAGS_DELETE_BASE_DIR', UPLOAD_BASE . 'JDDDocs');
/////////////////Utpal///////////////////
define('UPLOAD_BASE_DIFI_SIGN_DELIVER',  UPLOAD_BASE.'digiSignDeliverRTPS');
define('UPLOAD_BASE_GRPPDOCS',  UPLOAD_BASE.'GRPPDocs');
define('UPLOAD_BASE_APPPDOCS',  UPLOAD_BASE.'APPPDocs');
define('UPLOAD_BASE_STPPDOCS',  UPLOAD_BASE.'STPPDocs');
define('UPLOAD_BASE_CERTIFICATE',  UPLOAD_BASE.'Certificate');
define('UPLOAD_BASE_CONVERSIONDOCS',  UPLOAD_BASE.'ConversionDocs');
define('UPLOAD_BASE_FIELDMUT',  UPLOAD_BASE.'fieldmutation');
define('UPLOAD_BASE_FIELDPART',  UPLOAD_BASE.'fieldpartition');
define('UPLOAD_BASE_OFFICEMUT',  UPLOAD_BASE.'officemutation');
define('UPLOAD_BASE_OFFICEPART',  UPLOAD_BASE.'officepartition');
define('UPLOAD_BASE_MISCASE',  UPLOAD_BASE.'miscase');
define('PARTIAL_PAYMENT_NOTICE_PATH', UPLOAD_BASE.'partial_payment_notice/');
define('UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR',  UPLOAD_BASE.'installment_challans/');
////////////////////////////////////////
if (is_dir(UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR) === false) {
    mkdir(UPLOAD_INSTALLMENT_MANUAL_CHALAN_DIR);
}
if (is_dir(METHODPAGE_UPLOAD_PATH) === false) {
    mkdir(METHODPAGE_UPLOAD_PATH);
}
if (is_dir(SNA_DOCUMENT_UPLOAD_PATH) === false) {
    mkdir(SNA_DOCUMENT_UPLOAD_PATH);
}
if (is_dir(DIGITAL_PATTA_FINAL_UPLOAD_DIR) === false) {
    mkdir(DIGITAL_PATTA_FINAL_UPLOAD_DIR);
}

if (is_dir(DEMAND_SATISFIED_CERTIFICATE_UPLOAD_DIR) === false)
{
    mkdir(DEMAND_SATISFIED_CERTIFICATE_UPLOAD_DIR);
}
if (is_dir(UPLOAD_MANUAL_CHALAN_DIR) === false)
{
    mkdir(UPLOAD_MANUAL_CHALAN_DIR);
}
if (is_dir(DELIVERY_DOCS) === false)
{
    mkdir(DELIVERY_DOCS);
}
if (is_dir(NOK_UPLOAD_PATH) === false)
{
    mkdir(NOK_UPLOAD_PATH);
}
if (is_dir(PAYMENT_NOTICE_PATH) === false)
{
    mkdir(PAYMENT_NOTICE_PATH);
}
if (is_dir(CO_NOTICE_PATH) === false)
{
    mkdir(CO_NOTICE_PATH);
}
if (is_dir(SEND_TO_SDLAC_NOTICE_PATH) === false)
{
    mkdir(SEND_TO_SDLAC_NOTICE_PATH);
}
if (is_dir(JB_BASE64_POST_FILE) === false)
{
    mkdir(JB_BASE64_POST_FILE);
}
if (is_dir(PROGRESS_DIR) === false)
{
    mkdir(PROGRESS_DIR);
}
if (is_dir(UPLOAD_DIR) === false) {
    mkdir(UPLOAD_DIR);
}
if (is_dir(GENERAL_NOTICE_PATH_DC) === false) {
    mkdir(GENERAL_NOTICE_PATH_DC);
}
if (is_dir(AADHAAR_UPLOAD_DIR) === false) {
    mkdir(AADHAAR_UPLOAD_DIR);
}
if (is_dir(AADHAAR_PHOTO) === false) {
    mkdir(AADHAAR_PHOTO);
}
if (is_dir(MANUAL_ATTACHMENT) === false) {
    mkdir(MANUAL_ATTACHMENT);
}
if (is_dir(MANUAL_ATTACHMENT_MISCASE) === false) {
    mkdir(MANUAL_ATTACHMENT_MISCASE);
}
if (is_dir(SIGNPDF_UPLOAD_DIR) === false) {
    mkdir(SIGNPDF_UPLOAD_DIR);
}
if (is_dir(UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA) === false) {
    mkdir(UPLOAD_SUPPORTING_DOC_PATH_EKHAJANA);
}
if (is_dir(PARTIAL_PAYMENT_NOTICE_PATH) === false){
    mkdir(PARTIAL_PAYMENT_NOTICE_PATH);
}
defined('SETTLEMENT_AP_FILES')        OR define('SETTLEMENT_AP_FILES', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "chitha_copy":{"file_name":"chitha_copy","file_details":"Chitha Copy","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_TENANT_FILES')        OR define('SETTLEMENT_TENANT_FILES', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_TENANT_FILES_UPDATE')        OR define('SETTLEMENT_TENANT_FILES_UPDATE', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_TEA_FILES')        OR define('SETTLEMENT_TEA_FILES', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "lr_remark":{"file_name":"lr_remark","file_details":"LR staff remark","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_TEA_FILES_UPDATE')        OR define('SETTLEMENT_TEA_FILES_UPDATE', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "lr_remark":{"file_name":"lr_remark","file_details":"LR staff remark","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');

defined('SETTLEMENT_TRIBAL_FILES') or define('SETTLEMENT_TRIBAL_FILES', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_TRIBAL_FILES_UPDATE') or define('SETTLEMENT_TRIBAL_FILES_UPDATE', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('MULTIPLE_NRC_FILE_UPLOAD_LEGACY_YES') OR define('MULTIPLE_NRC_FILE_UPLOAD_LEGACY_YES', 
    '{"nrc_add_file1":{"file_name":"nrc_add_file1","file_details":"Document first","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file2":{"file_name":"nrc_add_file2","file_details":"Document second","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file3":{"file_name":"nrc_add_file3","file_details":"Linkage_Document_1","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file4":{"file_name":"nrc_add_file4","file_details":"Linkage_Document_2","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file5":{"file_name":"nrc_add_file5","file_details":"Linkage_Document_3","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('MULTIPLE_NRC_FILE_UPLOAD_LEGACY_NO') OR define('MULTIPLE_NRC_FILE_UPLOAD_LEGACY_NO', 
    '{"nrc_add_file1":{"file_name":"nrc_add_file1","file_details":"Document first","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file2":{"file_name":"nrc_add_file2","file_details":"Document second","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file3":{"file_name":"nrc_add_file3","file_details":" Linkage_Document_1","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file4":{"file_name":"nrc_add_file4","file_details":"Linkage_Document_2","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "nrc_add_file5":{"file_name":"nrc_add_file5","file_details":"Linkage_Document_3","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_KHAS_FILES')        OR define('SETTLEMENT_KHAS_FILES', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
defined('SETTLEMENT_KHAS_FILES_UPDATE')        OR define('SETTLEMENT_KHAS_FILES_UPDATE', '{
    "trace_map_copy":{"file_name":"trace_map_copy","file_details":"Trace Map","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "field_report":{"file_name":"field_report","file_details":"Field Report","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"},
    "geo_tag_photo":{"file_name":"geo_tag_photo","file_details":"Geo Tag Photo","required":"0","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');

defined('CONVERSION_CHITHA_DOCUMENT_BASE_DIR') OR define('CONVERSION_CHITHA_DOCUMENT_BASE_DIR', CONVERSION_DOCS_BASE_DIR . 'ChithaDocs' . UPLOAD_SEPARATOR);

defined('ALLOWED_UPLOAD_FILE_SIZE') or define('ALLOWED_UPLOAD_FILE_SIZE', 5242880); // 5MB in bytes
