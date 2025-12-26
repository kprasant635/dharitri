<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('applicationNumberValidation'))
{
    function applicationNumberValidation($applicationNumber)
    {
        // if valid, return blank array
        $returnArr = [];
        if($applicationNumber != ''){
            // Only alpha-numeric characters and \- are allowed. Blank space is not allowed
            $regex = '/^[A-Z0-9\/\-]*$/';
            if(!preg_match($regex, $applicationNumber)){
                $returnArr = [
                    'message' => 'Application number has illegal characters.'
                ];
            }
        }else{
            $returnArr = [
                'message' => 'Provide application number.'
            ];
        }
        return $returnArr;
    }   
}

if ( ! function_exists('caseNumberValidation'))
{
    function caseNumberValidation($caseNumber, $label = 'Case number')
    {
        // if valid, return blank array
        $returnArr = [];
        if($caseNumber != ''){
            // Only alpha-numeric characters and \- are allowed. Blank space is not allowed
            $regex = '/^[A-Za-z0-9\/\-]*$/';
            if(!preg_match($regex, $caseNumber)){
                $returnArr = [
                    'message' => $label . ' has illegal characters.'
                ];
            }
        }else{
            $returnArr = [
                'message' => 'Provide ' . strtolower($label) . '.'
            ];
        }
        return $returnArr;
    }   
}

if(!function_exists('isValidDeedNo')){
    /**
     * Here we will check
     * 1. Deed no is present or not
     * 2. Whether deed no consists of only special characters or not
     */
    function isValidDeedNo($deed_no){
        $deed_no = trim($deed_no);
        if(strlen($deed_no) == 0){
            return [
                'success' => false,
                'message' => 'Deed no field is required'
            ];
        }
        if(preg_match('/^[^a-zA-Z0-9]+$/', $deed_no)){
            // It has special characters
            return [
                'success' => false,
                'message' => 'Invalid Deed no'
            ];
        }

        return [
            'success' => true,
            'message' => ''
        ];
    }
}

if ( ! function_exists('isValidQuery'))
{
    function isValidQuery($query, $label = '', $next_level_syntaxvalidation = [])
    {
        if(count($next_level_syntaxvalidation) && isset($next_level_syntaxvalidation[$label])){
            $query = terminateTagsExtraSpaces($query);
        }
        
        if (strpos($query, ';') !== false)
        {
            return array('responseType'=>2, 'status'=>'n');
        }
        $notAllowedCommands = array(
                             'DELETE',
                             'TRUNCATE',
                             'DROP',
                             'USE'
                             );
        $query_tmp = explode(" ",$query);
        $query_arr = array_map('strtoupper', $query_tmp);
        if(count(array_intersect($notAllowedCommands, $query_arr)) > 0)
        {
            return array('responseType'=>2, 'status'=>'n');
        }
        else
        {
            return array('responseType'=>2, 'status'=>'y');
        }
    } 
}

if ( ! function_exists('specialCharacterCheckingInInput'))
{
    function specialCharacterCheckingInInput($requestString, $except = [], $label = 'Field')
    {
        // If you want to escape any special character(s). Pass those character(s) in 2nd parameter in array format
        $returnArr = [
            'responseType'=>2, 
            'status'=>'y',
            'message' => ''
        ];
        $requestString = trim($requestString);
        if($requestString != ''){
            // $requestString = trim($requestString);
            // $regexStr = '!@#$%^&*()_+{}[\]:;<>,.?\/\\|-।\'';
            // $regexStr = '!@#$%^&*()_+{}[\]:;<>,.?\/\\|-।\'';
            
            if(count($except)){
                for($i = 0; $i < count($except); $i++){
                    // $regexStr = str_replace($except[$i], '', $regexStr);    
                    $requestString = str_replace($except[$i], '', $requestString); // removing allowed characters from string    
                }
            }
 
            $eng_regex = '/^[A-Za-z0-9\.\s]+$/';
            $bengali_regex = '/^\p{Bengali}[\p{Bengali} _.-]+$/u';
            $mixed_regex = '/^[\p{Bengali} _.A-Za-z0-9\.\ত্‍]+$/u';
            $requestString = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $requestString);
            if(strlen($requestString) <= 0){
                $requestString = ' ';
            }
            
            if(preg_match($bengali_regex, $requestString)){ // Allowing bengali character only without special characters                
                $returnArr['message'] = $label. ' is ok.';
            }else if(preg_match($eng_regex, $requestString)){ // Allowing English character only without special characters
                $returnArr ['message'] = $label. ' is ok.';
            }else if(preg_match($mixed_regex, $requestString)){ // for Bengali and English together with
                $returnArr ['message'] = $label. ' is ok.';
            }else{
                log_message('error', '#ERR_ALLOWED_SPEC_CHAR_PARAM_KEY: PARAM => '. $label .'. Request string after removing allowed characters => ' . $requestString);
                $returnArr ['status'] = 'n';
                $returnArr ['message'] = $label. ' has illegal characters.';
            }

        }
        
        return $returnArr;
    } 
}
// "pdar_father_name":"\\u0981\\u09aa\\u09cd\\u09f0\\u09ab\\u09c1\\u09b2\\u09cd\\u09b2 \\u09b8\\u09f0\\u0995\\u09be\\u09f0  \\u0964
if ( ! function_exists('proposalNumberValidation'))
{
    function proposalNumberValidation($proposalNumber)
    {
        // if valid, return blank array
        $returnArr = [];
        if($proposalNumber != ''){
            // Only numeric characters are allowed. Blank space is not allowed
            $regex = '/^[0-9]*$/';
            if(!preg_match($regex, $proposalNumber)){
                $returnArr = [
                    'message' => 'Proposal number has illegal characters.'
                ];
            }
        }else{
            $returnArr = [
                'message' => 'Provide proposal number.'
            ];
        }
        return $returnArr;
    }   
}

if ( ! function_exists('convertArrayToHtmlUlLi'))
{
    function convertArrayToHtmlUlLi($requestArr)
    {
        // this method will help to convert an array to html <ul><li></li></ul>
        $html = '';
        if(count($requestArr)){
            $html = '<ul>';
            foreach($requestArr as $sing_request){
                $html .= "<li> $sing_request </li>";
            }
            $html .= '</ul>';
        }
        return $html;
    } 
}

if ( ! function_exists('serviceCodeValidation'))
{
    function serviceCodeValidation($serviceCode, $label = 'Service code')
    {
        // if valid, return blank array
        $validServiceCodes = [SERVICE_OFFICE_MUTATION, SERVICE_FIELD_MUTATION, SERVICE_OFFICE_PARTITION, SERVICE_FIELD_PARTITION, SERVICE_ALLOTMENT, SERVICE_NAME_CORRECT, SERVICE_AREA_CORRECTION, SERVICE_NAME_CANCEL, SERVICE_CONVERSION, SERVICE_MOBILE_UPDATE, SERVICE_RECLASSIFICATION, SERVICE_AUTO_MUTATION];
        $returnArr = [];
        if($serviceCode != ''){
            if(!in_array($serviceCode, $validServiceCodes)){
                $returnArr = [
                    'message' => $label . ' has illegal characters.'
                ];
            }
        }else{
            $returnArr = [
                'message' => 'Provide ' . strtolower($label) . '.'
            ];
        }
        return $returnArr;
    }   
}

if(!function_exists('checkRequestSpecChar')){
    function checkRequestSpecChar($serverVariable, $exceptSpecCharArr = [], $labelArr = [], $next_level_syntaxvalidation = [], $paramSpecificFileExtension = []){
        /**
         * PARAMETER SAMPLE
         * $lableArr will allow you to customize lable name in validation message
         * $exceptSpecCharArr = ['case_no' => ['.',','], 'remarks' => [',', '|']];
         * $labelArr = ['case_no' => 'Case number', 'app_no' => 'Application number'];
         * $next_level_syntaxvalidation = ['co_order' => true, 'remarks' => true]. Set this array to sanitize html tags then validate the sting
         * $paramSpecificFileExtension = ['attachment' => ['pdf', 'xls', 'xlsx'], 'file_upload' => ['jpeg', 'jpg', 'png']] <== that should be the format to pass specific extensions for specific field.
         *                              Else it will accept ['pdf', 'jpeg', 'jpg', 'png', 'xls', 'xlsx', 'csv'] as default
         * 
        */
        // $serverVariable is used for GET/POST or BOTH. Pass $_GET for GET Method, for POST Method Pass $_POST, in case of $_GET and $_POST together pass $_REQUEST as first Param
        $returnArr = [
            'responseType' => 2, 
            'status' => 'y',
            'messages' => '',
            'field_wise_message' => []
        ];

        $errorMessages = [];
        $fieldWiseErrorMessages = [];
        if(count($serverVariable)){
            foreach($serverVariable as $label => $requestVal){
                // $ret = array_iterate($requestVal);
                if(!is_array($requestVal)){
                    $response = syntaxValidationSteps(trim($requestVal), $label, $exceptSpecCharArr, $labelArr, $next_level_syntaxvalidation);
                    if($response['status'] == 'n'){
                        array_push($errorMessages, $response['message']);
                        $fieldWiseErrorMessages[$label] = $response['message'];
                    }
                }else{
                    foreach(array_flatten($requestVal) as $arrKey => $reqVal){
                        $response = syntaxValidationSteps(trim($reqVal), $label, $exceptSpecCharArr, $labelArr, $next_level_syntaxvalidation);
                        if($response['status'] == 'n'){
                            array_push($errorMessages, $response['message']);
                            $fieldWiseErrorMessages[$label] = $response['message'];
                        }
                    }
                }
                
                // $requestVal = trim($requestVal);
                // $except = getAllowedCharactersForInput($label);
                // $inputLabel = getInputLableName($label);
                // if(isset($labelArr[$label])) $inputLabel = $labelArr[$label];

                // if(isset($exceptSpecCharArr[$label])) array_merge($except, $exceptSpecCharArr[$label]);
                // $except = array_unique($except);

                // $response = specialCharacterCheckingInInput($ret, $except, $inputLabel);

                // if($response['status'] == 'n'){
                //     array_push($errorMessages, $response['message']);
                //     $fieldWiseErrorMessages[$label] = $response['message'];
                // }
            }

            if(isset($_FILES) && count($_FILES)){
                $response = checkFileIsValid($paramSpecificFileExtension);
                if($response['status'] == 'n'){
                    array_push($errorMessages, $response['messages']);
                    array_push($fieldWiseErrorMessages, $response['field_wise_message']);
                }
            }

            if(count($errorMessages)){
                $returnArr['status'] = 'n';
                $returnArr['messages'] = convertArrayToHtmlUlLi($errorMessages);
                $returnArr['field_wise_message'] = $fieldWiseErrorMessages;
            }

        }
        
        return $returnArr;
        
    }
    
}

if(!function_exists('syntaxValidationSteps')){
    function syntaxValidationSteps($reqVal, $label, $exceptSpecCharArr, $labelArr, $next_level_syntaxvalidation){
        // log_message('error', ' ########## Checking for label => ' . $label);
        if(count($next_level_syntaxvalidation) && isset($next_level_syntaxvalidation[$label])){
            $reqVal = terminateTagsExtraSpaces($reqVal);
        }
        $except = getAllowedCharactersForInput($label);
        $inputLabel = getInputLableName($label);
        if(isset($labelArr[$label])) $inputLabel = $labelArr[$label];
    
        if(isset($exceptSpecCharArr[$label])) $except = array_merge($except, $exceptSpecCharArr[$label]);
        $except = array_values(array_unique($except));
    
        return specialCharacterCheckingInInput($reqVal, $except, $inputLabel);
    
    }

}

if(!function_exists('terminateTagsExtraSpaces')){
    function terminateTagsExtraSpaces($reqVal){
        $pattern = '/&[a-z]{3,5};/i';
        $str = preg_replace('/\s+/', ' ', strip_tags($reqVal, ['script']));
        $str = str_replace('‎','',$str);
        return preg_replace($pattern, '', $str);
    }
}


if(!function_exists('checkRequestValidQuery')){
    function checkRequestValidQuery($serverVariable, $labelArr = [], $next_level_syntaxvalidation = []){
        /**
         * PARAMETER SAMPLE
         * $lableArr will allow you to customize lable name in validation message
         * $labelArr = ['case_no' => 'Case number', 'app_no' => 'Application number'];
         * $next_level_syntaxvalidation = ['co_order' => true, 'remarks' => true]. Set this array to sanitize html tags then validate the sting
         * 
        */
        $returnArr = [
            'responseType' => 2, 
            'status' => 'y',
            'messages' => '',
            'field_wise_message' => []
        ];

        $errorMessages = [];
        $fieldWiseErrorMessages = [];
        if(count($serverVariable)){
            foreach($serverVariable as $label => $requestVal){
                // $ret = array_iterate($request);
                $inputLabel = getInputLableName($label);
                if(isset($labelArr[$label])) $inputLabel = $labelArr[$label];

                if(!is_array($requestVal)){
                    $response = isValidQuery($requestVal, $label, $next_level_syntaxvalidation);

                    if($response['status'] == 'n'){
                        
                        array_push($errorMessages, $inputLabel . ' has MALECIOUS QUERY');
                        $fieldWiseErrorMessages[$label] = $inputLabel . ' has MALECIOUS QUERY';
                    }
                }else{
                    foreach(array_flatten($requestVal) as $reqVal){
                        $response = isValidQuery($reqVal, $label, $next_level_syntaxvalidation);

                        if($response['status'] == 'n'){
                            
                            array_push($errorMessages, $inputLabel . ' has MALECIOUS QUERY');
                            $fieldWiseErrorMessages[$label] = $inputLabel . ' has MALECIOUS QUERY';
                        }
                    }
                }

            }

            if(count($errorMessages)){
                $returnArr['status'] = 'n';
                $returnArr['messages'] = convertArrayToHtmlUlLi($errorMessages);
                $returnArr['field_wise_message'] = $fieldWiseErrorMessages;
            }
        }

        return $returnArr;
        
    }

}

if(!function_exists('checkFileIsValid')){
    function checkFileIsValid(){
        $extensions = ['pdf', 'jpeg', 'jpg', 'png', 'xls', 'xlsx', 'csv'];
        $response = [
            'responseType' => 2, 
            'status' => 'y',
            'messages' => '',
            'field_wise_message' => []
        ]; 

        $messages = $field_wise_messages = [];
        foreach($_FILES as $label => $fileField){
            if(is_array($fileField['name'])){
                if(count($fileField['name'])){
                    foreach($fileField['name'] as $key => $fieldName){
                        if($fileField['error'][$key] != 4){
                            $file_size = $fileField['size'][$key];
                            $res = checkFile($fieldName, $file_size, ['-', '_'], $extensions, $label);
                            if($res['status'] == 'n'){
                                $messages[] = $res['message'];
                                $field_wise_messages[] = $res['field_wise_message'];
                            }
                        }
                    }
                }
            }else{
                if($fileField['error'] != 4){
                    $res = checkFile($fileField['name'], $fileField['size'], ['-', '_'], $extensions, $label);
                    if($res['status'] == 'n'){
                        $messages[] = $res['message'];
                        $field_wise_messages[] = $res['field_wise_message'];
                    }
                }
            }
        }

        if(count($messages)){
            $response['status'] = 'n';
            $response['messages'] = implode('. ', $messages);
            $response['field_wise_message'] = $field_wise_messages;
        }

        return $response;
    }
}

if(!function_exists('checkFile')){
    function checkFile($fileFullName, $file_size, $except = ['-', '_'], $extensions, $label){
        $extensions = array_map('strtolower', $extensions);
        $fileNameParts = explode('.', $fileFullName);
        $fileExt = strtolower(end($fileNameParts));
        unset($fileNameParts[count($fileNameParts) - 1]);
        $fileName = implode('.', $fileNameParts);
        $printLabel = getInputLableName($label);

        $response = [
            'responseType' => 2, 
            'status' => 'y',
            'message' => '',
            'field_wise_message' => []
        ]; 
        
        $messages = [];
        $res = specialCharacterCheckingInInput($fileName, $except, $printLabel);
        $response = isValidQuery($fileName, $label);

        if($res['status'] == 'n'){
            $messages[] = $res['message'];
        }

        if($response['status'] == 'n'){
            $messages[] = $printLabel . ' has MALECIOUS QUERY in file name';
        }

        // Checking file name length
        if(!check_string_length_is_valid($fileName)){
            $messages[] = $printLabel . '\'s file name must not be greater than 50 characters.';
        }

        // Checking file extention
        if(!in_array($fileExt, $extensions)){
            $messages[] = $printLabel . ' has invalid file(s).';
        }

        if($file_size > ALLOWED_UPLOAD_FILE_SIZE){
            // $messages[] = $printLabel . ' has invalid file(s).';
            $messages[] = 'Max allowed size is ' . ALLOWED_UPLOAD_FILE_SIZE .' Bytes';
        }


        if(count($messages)){
            $response['status'] = 'n';
            $response['message'] = implode('. ', $messages);
            $response['field_wise_message'] = [$label => implode('. ', $messages)];
        }

        return $response;
    }
}

if(!function_exists('check_string_length_is_valid')){
    function check_string_length_is_valid($str, $length = 50){
        if(strlen($str) > $length){
            return false;
        }

        return true;
    }
}

if(!function_exists('array_flatten')){
    function array_flatten($array) { 
        if (!is_array($array)) { 
          return FALSE; 
        } 
        $result = array(); 
        foreach ($array as $key => $value) { 
          if (is_array($value)) { 
            $result = array_merge($result, array_flatten($value)); 
          } 
          else { 
            $result[$key] = $value; 
          } 
        } 
        return $result; 
    }
}

// if(!function_exists('array_iterate')){
//     function array_iterate($arr){
//         if(is_array($arr)){
//             foreach($arr as $key => $val)
//             {
//                 if(is_array($val))
//                 {
//                     array_iterate($val);
//                 }
//                 else{
//                     return trim($val);
//                 }
//             }
//         }else{
//             return trim($arr);
//         }
//     }
// }

if(!function_exists('getAllowedCharactersForInput')){
    function getAllowedCharactersForInput($label){
        $returnCharArr = [];
        if(in_array($label, textareaParamKeys())){
            // $returnCharArr = ['.', ',', '|', '?', "'"];
            // $returnCharArr = ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', ' ঁ', 'ৎ'];
            $returnCharArr = ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ', '&', ' ', '°'];
        }elseif(in_array($label, caseNoParamKeys())){
            $returnCharArr = ['/', '-'];
        }elseif(in_array($label, applicationNoParamKeys())){
            $returnCharArr = ['/', '-'];
        }elseif(in_array($label, deedNoParamKeys())){
            $returnCharArr = ['`', '/', '-', '.', '(', ')', ',', '*', '\\', ':', '#', '$'];
        }elseif(in_array($label, docCertificateNoParamKeys())){
            $returnCharArr = ['/', '.', '-'];   
        }elseif(in_array($label, noSpecialCharacterParamKeys())){
            // For this block, no special character will allowed
            $returnCharArr = [];
        }elseif(in_array($label, dateOrDateTimeParamKeys())){
            $returnCharArr = [':', '-', '/'];
        }elseif(in_array($label, certTypeCombinationParamKeys())){
            // Combination of Assamesse, Number and Hash. Ex Format: 01#পাথৰিঘাট#05
            $returnCharArr = ['#'];
        }elseif(in_array($label, dagNoParamKeys())){
            $returnCharArr = ['`', '.', '/',"'", ',', '(', ')'];
        }elseif(in_array($label, onlyDotAllowedParamKeys())){
            $returnCharArr = ['.'];
        }elseif(in_array($label, areaNameParamKeys())){
            $returnCharArr = ['.', '-'];
        }elseif(in_array($label, orderTypeParamKeys())){
            $returnCharArr = ['_'];
        }elseif(in_array($label, blockchainParamKeys())){            
            $returnCharArr = ['%',',','-','.',':','/','<','>'];
        }elseif(in_array($label, encryptedParamKeys())){            
            $returnCharArr = ['%',',','-','.',':','='];
        }elseif(in_array($label, emailParamKeys())){            
            $returnCharArr = ['@','_','-','.'];
        }elseif(in_array($label, gurdParamKeys())){            
            $returnCharArr = ['(', ')', ',', '-', '/', '\\', 'ঁ'];
        }elseif(in_array($label, fetchFileParamKeys())){            
            $returnCharArr = ['/', '.', '=', '_'];
        }elseif(in_array($label, pattaNoParamKeys())){
            $returnCharArr = ['-', '(', ')', '/', '.','|',' ','।'];
        }elseif(in_array($label, reportSuffixParamKeys())){
            $returnCharArr = ['-', '(', ')', '.', ','];
        }elseif(in_array($label, numericValParamKeys())){
            $returnCharArr = ['-','.'];
        }elseif(in_array($label, pattaTypeParamKeys())){
            $returnCharArr = ['-', ',', '/', ':'];
        }elseif(in_array($label, addressParamKeys())){
            $returnCharArr = ['-', ',', '/', ':'];
        }elseif(in_array($label, basudharaParamKeys())){
            $returnCharArr = [',','.','-', '/'];
        }else{
            $returnCharArr = [',','.','-'];
        }

        return $returnCharArr;
    }
}

if(!function_exists('getInputLableName')){
    function getInputLableName($label){
        $label = ucfirst($label);
        $label = str_replace("_", " ", $label);
        $label = str_replace("-", " ", $label);

        return $label;
    }
}


if ( ! function_exists('refNoValidation'))
{
    function refNoValidation($refNumber, $label = 'Reference number')
    {
        $returnArr = [
            'responseType' => 2, 
            'status' => 'y',
            'message' => ''
        ];

        if($refNumber != ''){
            // Only alpha-numeric characters and \- are allowed. Blank space is not allowed
            $regex = '/^[A-Z0-9\/\-]*$/';
            if(!preg_match($regex, $refNumber)){
                $returnArr ['status'] = 'n';
                $returnArr['message'] = $label . ' has illegal characters.';
            }else{
                $returnArr['message'] = $label . ' is ok.';
            }
        }else{
              $returnArr ['status'] = 'n';
            $returnArr['message'] = 'Provide ' . strtolower($label) . '.';
        }

        return $returnArr;
    }   
}


if(!function_exists('isParameterWhitelistedToAuditLib')){
    function isParameterWhitelistedToAuditLib($serverVariable, $generate_log = false){
        
        $response = true;
        $allWhitelistedParams = getAllSystemWhitelistedParams();
        if(count($serverVariable)){
            $is_whitelisted = true;
            $not_whitelsited_param = [];
            $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            foreach($serverVariable as $label => $requestVal){
                if(!in_array($label, $allWhitelistedParams)){
                    $is_whitelisted = false;
                    $response = false;
                    array_push($not_whitelsited_param, $label);
                }
                
            }
            
            if(!$is_whitelisted){
                $err_code = 'ERR_PARAM_NOT_WHITELISTED'. date('ymd') . rand(10, 100000);
                $not_whitelsited_param = implode(', ', $not_whitelsited_param);
                $data = [
                    'not_whitelisted_params' => $not_whitelsited_param,
                    'error_code' => $err_code
                ];
                session_start();
                $_SESSION["audit_notwhitelist_param_err"] = $data;
                if($generate_log){
                    log_message('error', $err_code . ': Request URL => ' . $actual_link . ' Labels => ' . $not_whitelsited_param);
                    // show_audit_error($not_whitelsited_param, 403, $err_code);
                    // return;
                }
                redirect(base_url('index.php/not-whitelisted-param'));
            }

        }

        return $response;

    }
}

if(!function_exists('getAllSystemWhitelistedParams')){
    function getAllSystemWhitelistedParams(){
        return array_merge(textareaParamKeys(), caseNoParamKeys(), applicationNoParamKeys(), noSpecialCharacterParamKeys(), dateOrDateTimeParamKeys(), certTypeCombinationParamKeys(), dagNoParamKeys(), onlyDotAllowedParamKeys(), orderTypeParamKeys(), fetchFileParamKeys(), pattaNoParamKeys(), areaNameParamKeys(), reportSuffixParamKeys(), numericValParamKeys(), pattaTypeParamKeys(), addressParamKeys(), basudharaParamKeys());
    }
}

if(!function_exists('textareaParamKeys')){
    function textareaParamKeys(){
        return ['remarks', 'note_order', 'query', 'sk_note', 'co_report', 'co_order', 'COorder', 'dc_report', 'adc_report', 'remark', 'p1', 'p2', 'lm_report', 'sk_report', 'lm_note', 'lm_note_suffix', 'final_report', 'ord_ref_let_no', 'infavor_of_name', 'lmremark', 'pdar_name', 'guard_rel', 'co_comment', 'purpose', 'lv_copies', 'note', 'report_on_possession', 'notes', 'comment', 'sk_comment', 'holding_reason', 'proceeding1', 'proceeding2', 'lm_comment', 'dc_comment', 'bo_comment', 'lmComment', 'coComment', 'lm_notice', 'sk_notice', 'note_on_order', 'co_notice', 'co_reason_note', 'ref_letter', 'prem_type', 'dc_adc_order', 'bo_notice_predefined', 'reason', 'bo_notice', 'dc_adc_notice', 'selected_box', 'pda_name_new', 'inFavourName','infavourAdd1','guardian_name_eng', 'Co_notice', 'co_name'];
    }
}

if(!function_exists('caseNoParamKeys')){
    function caseNoParamKeys(){
        return ['case_no', 'case_id', 'searchKeyword', 'misc_case_no', 'next_date_of_hearing', 'lm_sign_date', 'sk_sign_date', 'ord_date', 'date_entry', 'date_revenue', 'COOrderdate', 'memonumber', 'COOrderNo', 'FDeedReg', 'SDeedReg', 'TDeedReg', 'date_upto', 'f_install', 's_install', 'caseno', 'noc_no', 'case', 'name', 'order_no', 'refNo', 'slno'];
    }
}

if(!function_exists('applicationNoParamKeys')){
    function applicationNoParamKeys(){
        return ['application_no', 'app', 'cert_no', 'application_ref_no', 'appl', 'appno', 'service_code', 'ld_application_no', 'appl_no'];
    }
}

if(!function_exists('deedNoParamKeys')){
    function deedNoParamKeys(){
        return ['deed_no', 'reg_deed_no','doc_reg_no'];
    }
}

if(!function_exists('docCertificateNoParamKeys')){
    function docCertificateNoParamKeys(){
        return ['certificate_no', 'govtcertificate_no'];
    }
}

if(!function_exists('gurdParamKeys')){
    function gurdParamKeys(){
        return ['inFavourGurd'];
    }
}

if(!function_exists('pattaNoParamKeys')){
    function pattaNoParamKeys(){
        return ['patta_no', 'suggested_patta_no', 'sugg_patta_no', 'old_patta_no', 'pattaNo', 'old_patta','p'];
    }
}

if(!function_exists('reportSuffixParamKeys')){
    function reportSuffixParamKeys(){
        return ['co_report_suffix'];
    }
}

if(!function_exists('noSpecialCharacterParamKeys')){
    function noSpecialCharacterParamKeys(){
        return ['proposal_no', 'official', 'petition_no', 'misc_case_petition_no', 'ord_type_code', 'ord_passby_desig', 'lm_code', 'sk_code', 'ord_passby_sign_yn', 'lm_sign', 'sk_sign', 'co_sign', 'dist_code', 'subdiv_code', 'circle_code', 'mouza_code', 'lot_no', 'vill_code', 'patta_code', 'revenue', 'pdar_id', 'aadhar_no', 'pan_no', 'mobile_no', 'relation', 'COApprove', 'FwdLM', 'RejCO', 'FwdAst', 'land_class', 'suggested_land_class', 'dc_code', 'no_year', 'rev_year', 'bigha', 'katha', 'vill_townprt_code', 'mouza_pargona_code', 'co_code', 'distcode', 'subcode', 'circode', 'COSign', 'add_of_name', 'flag', 'ENABLED_BLOCKCHAIN', 'ENABLED_BLOCKCHAIN_FOR_DIST', 'by_right_of', 'order', 'cir_code', 'rastar_kaijo_b', 'rastar_kaijo_k', 'rastar_kaijo_lc', 'nodir_kaijo_b', 'nodir_kaijo_k', 'nodir_kaijo_lc', 'partial_b', 'partial_k', 'partial_lc', 'whetherOr', 'lm_name', 'conv_b', 'conv_k', 'premium_assesment', 'pattar_mati_hoi_ne', 'dokhol_ase_ne', 'gos_gosoni', 'miyadi_upojugi', 'jati_janajati', 'freedom_fighter', 'widow','SK_code', 'SK_name', 'note_no', 'proceeding_id', 'pdar_cron_no', 'chalan_no', 'c_bigha', 'c_kotha', 'sugg_dag_no', 'old_dag_no', 'land_portion_status', 'bo_code', 'payee_contact_no', 'payee_name', 'paymentBy', 'current_doul_year', 'ek_basic_id', 'dist', 'sro', 'year_no'];
    }
}

if(!function_exists('dateOrDateTimeParamKeys')){
    function dateOrDateTimeParamKeys(){
        return ['next_date_time', 'dob', 'hearing_date', 'lm_date', 'next_date', 'hearingdt', 'next_hear_date', 'orderDate', 'lmSignDate', 'skSignDate', 'coSignDate', 'date_of_entry', 'sk_date_of_entry', 're_hearing_date', 'order_date', 'co_order_date', 'executionDate', 'last_pay_date', 'date_hearing', 'submission_date','date_of_birth'];
    }
}

if(!function_exists('pattaTypeParamKeys')){
    function pattaTypeParamKeys(){
        return ['patta_type', 'new_patta_type'];
    }
}

if(!function_exists('addressParamKeys')){
    function addressParamKeys(){
        return ['address'];
    }
}

if(!function_exists('basudharaParamKeys')){
    function basudharaParamKeys(){
        return ['basundhara'];
    }
}

if(!function_exists('certTypeCombinationParamKeys')){
    function certTypeCombinationParamKeys(){
        return ['cert_type'];
    }
}

if(!function_exists('dagNoParamKeys')){
    function dagNoParamKeys(){
        return ['dagno', 'suggested_dag_no', 'dag', 'dag_no'];
    }
}

if(!function_exists('onlyDotAllowedParamKeys')){
    function onlyDotAllowedParamKeys(){
        return ['cert_fees', 'lessa', 'FDeedVal', 'sDeedVal', 'TDeedVal', 'LandPrice', 'f_ins_rs', 's_ins_rs', 'P_land_rev', 'p_local_tax', 'dag_local_tax', 'dag_revenue', 'each_bigha_rate', 'total_premium', 'conv_lc', 'prem_amt', 'c_lessa', 'amount', 'premium_amount', 'last_local_tax_payment_amount', 'last_revenue_payment_amount', 'current_local_tax', 'current_revenue', 'opening_balance'];
    }
}

if(!function_exists('areaNameParamKeys')){
    function areaNameParamKeys(){
        return ['suggested_dag_area_b', 'suggested_dag_area_k', 'suggested_dag_area_lc', 'suggested_dag_area_g', 'suggested_dag_area_kr', 'dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_kr', 'dag_area_g'];
    }
}

if(!function_exists('numericValParamKeys')){
    function numericValParamKeys(){
        return ['land_rev', 'loc_tax', 'suggested_land_rev', 'suggested_loc_tax', ];
    }
}


if(!function_exists('orderTypeParamKeys')){
    function orderTypeParamKeys(){
        return ['suggested_striked', 'order_type'];
    }
}

if(!function_exists('fetchFileParamKeys')){
    function fetchFileParamKeys(){
        return ['file__path'];
    }
}

if(!function_exists('blockchainParamKeys')){
    function blockchainParamKeys(){
        return ['encoded_case_no','bhuCompareMsg','compareMsg'];
    }
}

if(!function_exists('encryptedParamKeys')){
    function encryptedParamKeys(){
        return ['data','locationsess'];
    }
}

if(!function_exists('emailParamKeys')){
    function emailParamKeys(){
        return ['payee_email'];
    }
}

if(!function_exists('checkRequest')){
    function checkRequest($serverVariable){
        $errorMessagesStr = '';
        $returnArr = [
            'responseType' => 2, 
            'status' => 'y',
            'messages' => '',
            'field_wise_message' => []
        ];

        $response = checkRequestSpecChar($serverVariable);
        if($response['status'] == 'n'){
            $errorMessagesStr .= $response['messages'];

            $returnArr['status'] = 'n';
            $returnArr['messages'] .= $response['messages'];
            $returnArr['field_wise_message'] = $response['field_wise_message'];
        }
        
        $response = checkRequestValidQuery($serverVariable);
        if($response['status'] == 'n'){
            $errorMessagesStr .= $response['messages'];

            $returnArr['status'] = 'n';
            $returnArr['messages'] .= $response['messages'];
            $returnArr['field_wise_message'] = $response['field_wise_message'];
        }
        // KEEP THIS FUNCTION AT THE BOTTOM
        // This method will check only GET param only. And also check is there any special char or malicious query in the param. If it has, it will redirect to CI error page (show_error())
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $errorMessagesStr != '') {
            $response = isParameterWhitelistedToAuditLib($_GET, true);
            if($response){
                show_error($errorMessagesStr, 401);
                return;
            }
        }

        return $returnArr;
        
    }

    checkRequest($_GET);

}

if(!function_exists('postParamFormValidation')) {
    function postParamFormValidation($post, $rules=[]) { //put this function in controller for post parameter validation and set the rules as 2nd parameter. Eg: postParamSyntaxValidation($_POST, ['application_no'=>'application_no', 'misc_case_no'=>'case_no', 'misc_case_petition_no'=>'digit', 'next_date_of_hearing'=>'date', 'next_date_time'=>'time', 'p1'=>'only_non_special_character', 'date_time_both'=>'datetime'])
        $result = [
            'status'=>'y',
            'message'=>'Post Parameters are OK'
        ];
        if(!empty($rules)) {
            foreach ($rules as $key => $value) {
                # code...
                if($value=='application_no') {
                    $response = applicationNumberValidation($post[$key]);
                    if(!empty($response)) {
                        $result = [
                            'status'=>'n',
                            'message'=>'Application no. has illegal character'
                        ];
                        break;
                    }
                }
                else if($value=='case_no') {
                    $response = caseNumberValidation($post[$key]);
                    if(!empty($response)) {
                        $result = [
                            'status'=>'n',
                            'message'=>'Case No. has illegal character'
                        ];
                        break;
                    }
                }
                else if($value=='digit'){
                    if(!preg_match('/^[0-9]*$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The post parameter is not a digit'
                        ];
                        break;
                    }
                }
                else if($value=='time') {
                    if(!preg_match('/^[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The post parameter is not in time format'
                        ];
                        break;
                    }
                }
                else if($value=='date') {
                    if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $post[$key]) && !preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The post parameter is not in date format'
                        ];
                        break;
                    }
                }
                else if($value=='datetime') {
                    if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}\s[0-9]{2}:[0-9]{2}$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The post parameter is not in datetime format'
                        ];
                        break;
                    }
                }
                else if($value=='char') {
                    if(!preg_match('/^.$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'The post parameter is not in single character format'
                        ];
                        break;
                    }
                }
                else if($value=='2_digit_decimal'){
                    if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?)?$/', $post[$key])) {
                        $result = [
                          'status'=>'n',
                          'message'=>'The parameter does not conform to the required 2 decimal digit number'
                        ];
                        break;
                    }
                }
                else if($value=='3_digit_decimal'){
                  if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?)?$/', $post[$key])) {
                      $result = [
                        'status'=>'n',
                        'message'=>'The parameter does not conform to the required 3 decimal digit number'
                      ];
                      break;
                  }
                }
                else if($value=='4_digit_decimal'){
                  if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?[0-9]?)?$/', $post[$key])) {
                      $result = [
                        'status'=>'n',
                        'message'=>'The parameter does not conform to the required 4 decimal digit number'
                      ];
                      break;
                  }
                }
                else if($value=='katha'){
                    if(!preg_match('/^[0-9]*$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'Katha value must be a digit'
                        ];
                        break;
                    }
                    else{
                        if($post[$key]>=5) {
                            $result = [
                                'status'=>'n',
                                'message'=>'Katha value should not be greater than or equal to 5'
                            ];
                            break;
                        }
                    }
                }
                else if($value=='lessa') {
                    if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?[0-9]?)?$/', $post[$key])) {
                        $result = [
                            'status'=>'n',
                            'message'=>'Lessa value should not have more than 4 decimal digits'
                        ];
                        break;
                    }
                    else{
                        if($post[$key]>=20) {
                            $result = [
                                'status'=>'n',
                                'message'=>'Lessa value should not be greater than or equal to 20'
                            ];
                            break;
                        }
                    }
                }
                else {
      
                }
            }
        }
        
        return $result;
    }
}

if(!function_exists('dump')){
    function dump($val = NULL){
        echo "<pre>";
        print_r($val);
    }
}

if(!function_exists('dd')){
    function dd($val = NULL){
        dump($val);
        // echo "<pre>";
        // print_r($val);
        die;
    }
}

if(!function_exists('sendCurlRequest')){
    function sendCurlRequest($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST = 'GET', $CURLOPT_POSTFIELDS = [], $CURLOPT_TIMEOUT = 30, $CURLOPT_CONNECTTIMEOUT = 10){
        $CURLOPT_SSL_VERIFYHOST = 2; 
        $CURLOPT_RETURNTRANSFER = true; 
        $CURLOPT_SSL_VERIFYPEER = false;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $CURLOPT_URL);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, $CURLOPT_RETURNTRANSFER);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, $CURLOPT_SSL_VERIFYPEER);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, $CURLOPT_CUSTOMREQUEST);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  $CURLOPT_SSL_VERIFYHOST);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $CURLOPT_CONNECTTIMEOUT); // setting 10 seconds 
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, $CURLOPT_TIMEOUT); // setting 30 seconds
        
        if(count($CURLOPT_POSTFIELDS) && $CURLOPT_CUSTOMREQUEST == 'POST'){
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($CURLOPT_POSTFIELDS));
        }
    
        $result = curl_exec($curl_handle);
    
        curl_close($curl_handle);
    
        return $result;
    }
}

if(!function_exists('get_file_location')){
    function get_file_location($directory_path, $file_name, $wrapper_directory = ''){
        $file_path = base_url(IMAGE_PLACEHOLDER);
        if(file_exists($directory_path. '/' . $file_name)){
            $file_path = base_url($directory_path . '/' . $file_name);
        }elseif($wrapper_directory != ''){
            if(file_exists($wrapper_directory . '/' . $directory_path. '/' . $file_name)){
                $file_path = base_url($wrapper_directory . '/' . $directory_path . '/' . $file_name);
            }
        }

        return $file_path;
    }
}

// if(!function_exists('search_file_location')){
//     function search_file_location($full_path){
//         /**
//          * This fn will help to search file in "dharitree/uploads/..", "34/uploads/..", "35/uploads/.." respectively
//          * No need to send upload directory in $directory_path
//          * All docs will come under uploads folder
//          */
        
//         $full_path = str_replace('./', '', $full_path);
        
//         $checkUploadsName = explode('uploads/', $full_path);
        
//         if(count($checkUploadsName) > 1){
//             $full_path = str_replace($checkUploadsName[0] . 'uploads/', '', $full_path);
//         }
        
//         $upload_base = UPLOAD_BASE;
//         $upload_base = str_replace('./', '', $upload_base);
//         $wrapper_directories = [$upload_base, '34/uploads/', '35/uploads/'];

//         foreach ($wrapper_directories as $value) {
//             if(file_exists($value . $full_path)){
//                 $file_path = $value . $full_path;
//                 return $file_path;
//             }
//         }
        
//         if(NEED_PLACEHOLDER_FOR_NOT_EXISTING_FILE == 1){
//             return IMAGE_PLACEHOLDER;
//         }else{
//             return false;
//         }
//     }
// }

if(!function_exists('search_file_location')){
    function search_file_location($full_path, $should_encrypt = true){
        $ci = &get_instance();
        $ci->load->library('AES');
        /**
         * This fn will help to search file in "dharitree/uploads/..", "34/uploads/..", "35/uploads/.." respectively
         * No need to send upload directory in $directory_path
         * All docs will come under uploads folder
         */
        
        $full_path = str_replace('./', '', $full_path);
        
        $checkUploadsName = explode('uploads/', $full_path);
        
        if(count($checkUploadsName) > 1){
            $full_path = str_replace($checkUploadsName[0] . 'uploads/', '', $full_path);
        }

        // Check whether NFS Server Ip is added as prefix in the file name or not
        // $checkNfsName = explode(NFS_SERVER_IP, $full_path);
        // if(count($checkNfsName) > 1){
        //     $full_path = '\\' . $full_path;
        // }
        
        $upload_base = UPLOAD_BASE;
        $dir34_base = BASE_DIR_34;
        $dir_35_base = BASE_DIR_35;
        $upload_base = str_replace('./', '', $upload_base);
        // $wrapper_directories = [$upload_base, $dir34_base, $upload_base];
        $wrapper_directories = [$upload_base, $dir34_base, $dir_35_base];

        foreach ($wrapper_directories as $value) {
            if(file_exists($value . $full_path)){
                $file_path = $value . $full_path;

                if(NFS_SERVER_IP != ''){
                    $checkNfsName = explode(NFS_SERVER_IP, $file_path);
                    if(count($checkNfsName) > 1){
                        // log_message('error','#123 file_path='.$file_path);
                        //$file = '\\' . $file;
                        $file_path = str_replace('\\'.NFS_SERVER_IP, IP_REPLACER_STRING, $file_path);
                        // log_message('error','#456 file_path='.$file_path);
                    }
                }

                // return get_base64_encoded_data($file_path);
                if($should_encrypt){
                    $aes       = new AES($file_path, ENCRYPTION_KEY);
                    $enc_file_path = $aes->encrypt();
                    
                    $enc_file_path = str_replace("+",AES_PLUS_REPLACER_STRING,$enc_file_path);
                    return $enc_file_path;
                }else{
                    return $file_path;
                }
            }
        }
        
        if(NEED_PLACEHOLDER_FOR_NOT_EXISTING_FILE == 1){
            // return IMAGE_PLACEHOLDER;
            $image_placeholder_path = IMAGE_PLACEHOLDER;
            if(NFS_SERVER_IP != ''){
                $checkNfsName = explode(NFS_SERVER_IP, $image_placeholder_path);
                if(count($checkNfsName) > 1){
                    $image_placeholder_path = str_replace('\\'.NFS_SERVER_IP, IP_REPLACER_STRING, $image_placeholder_path);
                }
            }

            if($should_encrypt){
                $aes       = new AES($image_placeholder_path, ENCRYPTION_KEY);
                $enc_file_path = $aes->encrypt();
                
                $enc_file_path = str_replace("+",AES_PLUS_REPLACER_STRING,$enc_file_path);
                
                return $enc_file_path;
            }else{
                return $image_placeholder_path;
            }
        }else{
            return false;
        }
    }
}

// if(!function_exists('get_base64_encoded_data')){
//     function get_base64_encoded_data($file_path){
//         $file_path_parts = explode('.', $file_path);
//         $extension = strtolower(end($file_path_parts));
//         $file_content = file_get_contents($file_path);
//         $encoded_data = base64_encode($file_content);
//         if(in_array($extension, ['png', 'jpg', 'jpeg', 'webp'])){
//             // header('Content-Type: image/png');
//             return 'data:'. base64_decode($encoded_data) .';base64,' . $file_content;
//         }else{
//             // echo $encoded_data;
//             // dd($encoded_data);
//             // header('Content-Type: application/pdf');
//             return 'data:application/pdf;base64,' . $encoded_data;
//         }

//     }
// }

if(!function_exists('check_nd_get_content_type')){
    function check_nd_get_content_type($content_type, $file){
        $raw_content_type = $content_type;
        $content_type = strtolower($content_type);

        $file_parts = explode('.', $file);
        $extension = strtolower(end($file_parts));

        $content_type_parts = explode('/', $content_type);
        if(count($content_type_parts) > 1){
            $content_type = end($content_type_parts);
        }

        if($content_type != $extension){
            if($extension == 'pdf'){
                return 'application/pdf';
            }else{
                return 'image/' . $extension;
            }
        }

        return $raw_content_type;
        
    }
}

if(!function_exists('response_json')){
    function response_json($data = [], $responseCode = '200'){
        /**
         * Send reponse code = 403 for error and 200 for success
         */
        $ci = &get_instance();

        return $ci->output
                    ->set_status_header($responseCode)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
    }
}

if(!function_exists('check_param_length')){
    function check_param_length($params, $serverVariable){
        /**
         * $params will be like ['co_order' => ['required'], 'dc_code' => ['required']]
         * ===================================== [RULES] =================== [RULES] ====
         * $serverVariable can $_POST or $_GET or $_REQUEST
         */

        // if(config_item('csrf_protection') === TRUE){
        //     // array_push($params, );
        // }

        $valid_param_count = 0;
        $errorMessages = [];
        if(count($params)){
            foreach($params as $param => $rules){
                if(array_search('required', $rules, true)){
                    if(!array_search($param, $serverVariable, true)){
                        if(array_search('file', $rules, true)){
                            // if()
                        }
                        $errorMessages[] = $param . ' is missing.';
                    }
                }else{

                }
            }
        }
    }

    // function match_param_with_incoming_param($params, $serverVariable){
        
    // }
}

if(!function_exists('is_ajax_request')){
    function is_ajax_request(){
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        return $isAjax;
    }
}

