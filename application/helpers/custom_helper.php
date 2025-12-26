<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// if ( ! function_exists('applicationNumberValidation'))
// {
//     function applicationNumberValidation($applicationNumber)
//     {
//         // if valid, return blank array
//         $returnArr = [];
//         if($applicationNumber != ''){
//             // Only alpha-numeric characters and \- are allowed. Blank space is not allowed
//             $regex = '/^[A-Z0-9\/\-]*$/';
//             if(!preg_match($regex, $applicationNumber)){
//                 $returnArr = [
//                     'message' => 'Application number has illegal characters.'
//                 ];
//             }
//         }else{
//             $returnArr = [
//                 'message' => 'Provide application number.'
//             ];
//         }
//         return $returnArr;
//     }   
// }

// if ( ! function_exists('caseNumberValidation'))
// {
//     function caseNumberValidation($caseNumber, $label = 'Case number')
//     {
//         // if valid, return blank array
//         $returnArr = [];
//         if($caseNumber != ''){
//             // Only alpha-numeric characters and \- are allowed. Blank space is not allowed
//             $regex = '/^[A-Za-z0-9\/\-]*$/';
//             if(!preg_match($regex, $caseNumber)){
//                 $returnArr = [
//                     'message' => $label . ' has illegal characters.'
//                 ];
//             }
//         }else{
//             $returnArr = [
//                 'message' => 'Provide ' . strtolower($label) . '.'
//             ];
//         }
//         return $returnArr;
//     }   
// }

// if ( ! function_exists('isValidQuery'))
// {
//     function isValidQuery($query)
//     {
//        if (strpos($query, ';') !== false)
//        {
//           return array('responseType'=>2, 'status'=>'n');
//        }
//        $notAllowedCommands = array(
//                              'DELETE',
//                              'TRUNCATE',
//                              'DROP',
//                              'USE'
//                              );
//        $query_tmp = explode(" ",$query);
//        $query_arr = array_map('strtoupper', $query_tmp);
//        if(count(array_intersect($notAllowedCommands, $query_arr)) > 0)
//        {
//           return array('responseType'=>2, 'status'=>'n');
//        }
//        else
//        {
//           return array('responseType'=>2, 'status'=>'y');
//        }
//     } 
// }

// if ( ! function_exists('specialCharacterCheckingInInput'))
// {
//     function specialCharacterCheckingInInput($requestString, $except = [], $label = 'Field')
//     {
//         // If you want to escape any special character(s). Pass those character(s) in 2nd parameter in array format
//         $returnArr = [
//             'responseType'=>2, 
//             'status'=>'y',
//             'message' => ''
//         ];
        
//         if($requestString != ''){
//             $regexStr = '!@#$%^&*()_+{}[\]:;<>,.?\/\\|-';
            
//             if(count($except)){
//                 for($i = 0; $i < count($except); $i++){
//                     $regexStr = str_replace($except[$i], '', $regexStr);    
//                 }
//             }
            
//             $regex = '/['. $regexStr .']+/';
            
//             if(preg_match($regex, $requestString)){
//                 $returnArr ['status'] = 'n';
//                 $returnArr ['message'] = $label. ' has illegal characters.';
//             }else{
//                 $returnArr ['message'] = $label. ' is ok.';
//             }
//         }
        
//         return $returnArr;
//     } 
// }

// if ( ! function_exists('proposalNumberValidation'))
// {
//     function proposalNumberValidation($proposalNumber)
//     {
//         // if valid, return blank array
//         $returnArr = [];
//         if($proposalNumber != ''){
//             // Only numeric characters are allowed. Blank space is not allowed
//             $regex = '/^[0-9]*$/';
//             if(!preg_match($regex, $proposalNumber)){
//                 $returnArr = [
//                     'message' => 'Proposal number has illegal characters.'
//                 ];
//             }
//         }else{
//             $returnArr = [
//                 'message' => 'Provide proposal number.'
//             ];
//         }
//         return $returnArr;
//     }   
// }

// if ( ! function_exists('convertArrayToHtmlUlLi'))
// {
//     function convertArrayToHtmlUlLi($requestArr)
//     {
//         // this method will help to convert an array to html <ul><li></li></ul>
//         $html = '';
//         if(count($requestArr)){
//             $html = '<ul>';
//             foreach($requestArr as $sing_request){
//                 $html .= "<li> $sing_request </li>";
//             }
//             $html .= '</ul>';
//         }
//         return $html;
//     } 
// }