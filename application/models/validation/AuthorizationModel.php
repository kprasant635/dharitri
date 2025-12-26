<?php
    class AuthorizationModel extends CI_Model {

        public function __construct() {
            $this->load->model('NameCorrection/NameCorrectionModel');
            $this->load->model('CitizenCentric_Model');
            $this->load->model('PetitionBasic_Model');
            $this->load->model('validation/CheckAccessModel');
        }

//----------------------main function---------------------------------------------
        public function isAuthorized($service_code, $user_desig_code, $data, $event=null) {
            //$user_desig_code is controller function specific & checks for which role (CO, AST, SK, LM etc) the method needs to be authorized.
            //$data can be $_POST, $case_no, $cert_no, $application_no
            if(empty($service_code) || empty($user_desig_code) || empty($data)) {
                return $this->errorResponse('Required Arguments are not sent!');
                exit;
            }

            if(!$this->checkAuthentication($user_desig_code)) {
                //this function is for checking whether session exists, session['user_code'] exists and session['user_desig_code'] matches with the incoming user_desig_code from controller method
                return $this->errorResponse('User not Authenticated!');
                exit;
            }
            $authorized = false;
            if(is_array($data)) {//checks whether incoming $data is a $_POST variable
                $validPostData = $this->checkPostData($data);//this function filters out the raw $_POST data.
                if(!empty($validPostData)) {
                    $authorized = $this->authorizeFromCore($validPostData, $user_desig_code);//final authorization
                }
            }
            else{
                $tableData = $this->getBasicData($service_code, $data);//retrieves table data if $data = $case_no or $cert_no or $application_no
                //RETURNS OBJECT
                if(empty($tableData)) {
                    return $this->errorResponse('Case not found!');
                    exit;
                }
                $validTableData = $this->checkTableData($tableData);//this function filters out the table data and changes to array form
                if(ENABLED_ADVANCED_AUTHORIZATION == 1) {
                    $firstAuthorized = false;
                    if(!empty($validTableData)) {
                        $firstAuthorized=$this->authorizeFromCore($validTableData, $user_desig_code);//first authorization
                    }
                    if($firstAuthorized) {
                        $authorized = $this->checkCaseAccess($service_code, $user_desig_code, $data, $event);
                    }
                }
                else{
                    if(!empty($validTableData)) {
                        $authorized=$this->authorizeFromCore($validTableData, $user_desig_code);//first authorization
                    }
                }
                
                // $response = $this->checkCaseAccess($user_desig_code, $service_code, $case_no, $appl_no);
            }
            if($authorized) {
                return $this->successResponse('User Authorized!!');
                exit;
            }
            else{
                return $this->errorResponse('User Not Authorized!');
                exit;
            }
        }
//-----------------------end of main function----------------------------------------------

//-----------------------configuration------------------------------------------------
        private function getDistCodeOptions() {//includes all possible dist_code key names
            return ['dist_code', 'district_code'];
        }
        private function getSubdivCodeOptions() {//includes all possible subdiv_code key names
            return ['subdiv_code'];
        }
        private function getCirCodeOptions() {//includes all possible cir_code key names
            return ['cir_code', 'circle_code'];
        }
        private function getMouzaCodeOptions() {//includes all possible mouza_pargona_code key names
            return ['mouza_pargona_code', 'mouza_code'];
        }
        private function getLotNoOptions() {//includes all possible lot_no key names
            return ['lot_no'];
        }
        private function authenticationCategories($user_desig_code) {////includes role wise authorization levels
            if(in_array($user_desig_code, ['CO', 'AST', 'SK', 'DEO', 'DA'])) {
                return 'CATEGORY_TILL_CIRCLE';
            }
            else if(in_array($user_desig_code, ['ADC', 'DC', 'BO'])) {
                return 'CATEGORY_TILL_DISTRICT';
            }
            else if (in_array($user_desig_code, ['LM'])) {
                return 'CATEGORY_TILL_LOT';
            }
            else{
                return 'CATEGORY_NOT_ALLOWED';
            }
        }
//-----------------------end of configuration-----------------------------------------

//-----------------------Custom Table Data for Authorization--------------------------
        private function getBasicData($service_code, $case_no) {//return type = object
            $caseInfo = [];
            if($service_code==SERVICE_NAME_CORRECT || $service_code==SERVICE_NAME_CANCEL) {//Name Correction, Name Cancellation
                $caseInfo = $this->NameCorrectionModel->caseInfoForAuthorization($case_no);
            }
            else if($service_code==100) {//ccs services
                $cert_no = $case_no;
                $caseInfo = $this->CitizenCentric_Model->certInfo($cert_no);
            }
            else if($service_code==101) {//RTPS api validation
                $app_no = $case_no;
                $caseInfo = $this->checkApiAuth("serviceResponse?application_no=", $app_no)->application;
            }
            else if($service_code == 102) {
                $app_no = $case_no;
                $caseInfo = $this->checkApiAuthMb3($app_no)->application;
            }
            else if($service_code==SERVICE_CONVERSION) {//Conversion
                $caseInfo = $this->PetitionBasic_Model->caseInfoForAuthorization($case_no);
            }
            return $caseInfo;
        }
//-----------------------end of Custom Table Data for Authorization-------------------

//-----------------------Add your custom service checkAccess function-----------------
        private function checkCaseAccess($service_code, $user_desig_code, $case_no, $event)
        {
            if ($user_desig_code == 'LM')
            {
                return $this->CheckAccessModel->checkLMAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='AST'){
                return $this->CheckAccessModel->checkASTAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='CO'){
                return $this->CheckAccessModel->checkCOAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='SK') {
                return $this->CheckAccessModel->checkSKAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='DEO') {
                return $this->CheckAccessModel->checkDEOAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='DA') {
                return $this->CheckAccessModel->checkDAAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='ADC') {
                return $this->CheckAccessModel->checkADCAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='DC') {
                return $this->CheckAccessModel->checkDCAccess($service_code, $case_no, $event);
            }
            else if($user_desig_code=='BO') {
                return $this->CheckAccessModel->checkBOAccess($service_code, $case_no, $event);
            }
            else{
                return false;
            }
        }        


        // private function checkCaseAccess($service_code, $user_desig_code, $case_no, $event)
        // {
        //     if($service_code==SERVICE_NAME_CORRECT)
        //     {
        //         return $this->CheckAccessModel->nameCorrectionCheck($user_desig_code, $case_no, $event);
        //     }
        //     else if($service_code==SERVICE_NAME_CANCEL)
        //     {
        //         return $this->CheckAccessModel->nameCancellationCheck($user_desig_code, $case_no, $event);
        //     }
        //     else if($service_code==100)
        //     {
        //         return $this->CheckAccessModel->ccsCheck($user_desig_code, $case_no, $event);
        //     }
        //     else if($service_code==101)
        //     {
        //         return $this->CheckAccessModel->rtpsCheck($user_desig_code, $case_no, $event);
        //     }
        //     else if($service_code==SERVICE_CONVERSION)
        //     {
        //         return $this->CheckAccessModel->conversionCheck($user_desig_code, $case_no, $event);
        //     }
        // }
//---------------------end of custom service checkAccess function----------------------

        private function checkAuthentication($user_desig_code) {
            $sessionData = $this->session->all_userdata();
            if($sessionData && $sessionData['user_code'] && $sessionData['user_desig_code']==$user_desig_code) {
                return true;
            }
            else {
                return false;
            }
        }

        private function authorizeFromCore($data, $user_desig_code){
            $authorized = false;
            $sessionData = $this->session->all_userdata();

            $authenticationCategory = $this->authenticationCategories($user_desig_code);

            if ($authenticationCategory=='CATEGORY_TILL_CIRCLE') {
                if($data['dist_code']==$sessionData['dist_code'] && $data['subdiv_code']==$sessionData['subdiv_code'] && $data['cir_code']==$sessionData['cir_code']) {
                    $authorized = true;
                }
            }
            else if ($authenticationCategory=='CATEGORY_TILL_DISTRICT') {
                if($data['dist_code']==$sessionData['dist_code']) {
                    $authorized = true;
                }
            }
            else if ($authenticationCategory=='CATEGORY_TILL_LOT') {
                if($data['dist_code']==$sessionData['dist_code'] && $data['subdiv_code']==$sessionData['subdiv_code'] && $data['cir_code']==$sessionData['cir_code'] && $data['mouza_pargona_code']==$sessionData['mouza_pargona_code'] && $data['lot_no']==$sessionData['lot_no']) {
                    $authorized = true;
                } 
            }

            return $authorized;
        }

        private function checkPostData($post) {
            $distCodeOptions = $this->getDistCodeOptions();
            $subdivCodeOptions = $this->getSubdivCodeOptions();
            $cirCodeOptions = $this->getCirCodeOptions();
            $mouzaCodeOptions = $this->getMouzaCodeOptions();
            $lotNoOptions = $this->getLotNoOptions();
            $validPostData = [];

            foreach ($distCodeOptions as $d) {
                # code...
                if(isset($post[$d])) {
                    $validPostData['dist_code'] = $post[$d];
                    break;
                }
            }
            foreach ($subdivCodeOptions as $s) {
                # code...
                if(isset($post[$s])) {
                    $validPostData['subdiv_code'] = $post[$s];
                    break;
                }
            }
            foreach ($cirCodeOptions as $c) {
                # code...
                if(isset($post[$c])) {
                    $validPostData['cir_code'] = $post[$c];
                    break;
                }
            }
            foreach ($mouzaCodeOptions as $m) {
                # code...
                if(isset($post[$m])) {
                    $validPostData['mouza_pargona_code'] = $post[$m];
                    break;
                }
            }
            foreach ($lotNoOptions as $l) {
                # code...
                if(isset($post[$l])) {
                    $validPostData['lot_no'] = $post[$l];
                    break;
                }
            }
            return $validPostData;
        }

        private function checkTableData($tableData) {
            $distCodeOptions = $this->getDistCodeOptions();
            $subdivCodeOptions = $this->getSubdivCodeOptions();
            $cirCodeOptions = $this->getCirCodeOptions();
            $mouzaCodeOptions = $this->getMouzaCodeOptions();
            $lotNoOptions = $this->getLotNoOptions();
            $validTableData = [];
            foreach($distCodeOptions as $d) {
                if(isset($tableData->$d)) {
                    $validTableData['dist_code'] = $tableData->$d;
                    break;
                }
            }
            foreach ($subdivCodeOptions as $s) {
                # code...
                if(isset($tableData->$s)) {
                    $validTableData['subdiv_code'] = $tableData->$s;
                    break;
                }
            }
            foreach ($cirCodeOptions as $c) {
                # code...
                if(isset($tableData->$c)) {
                    $validTableData['cir_code'] = $tableData->$c;
                    break;
                }
            }
            foreach ($mouzaCodeOptions as $m) {
                # code...
                if(isset($tableData->$m)) {
                    $validTableData['mouza_pargona_code'] = $tableData->$m;
                    break;
                }
            }
            foreach ($lotNoOptions as $l) {
                # code...
                if(isset($tableData->$l)) {
                    $validTableData['lot_no'] = $tableData->$l;
                    break;
                }
            }
            return $validTableData;
        }

        private function errorResponse($message) {
            return array(
                'responseType'=>1,
                'status'=>'n',
                'messages'=>$message
            );
        }

        private function successResponse($message) {
            return array(
                'responseType'=>2,
                'status'=>'y',
                'messages'=>$message
            );
        }
        //RTPS API Auth
        public function checkApiAuth($url, $ref_no) {
            $url = RTPS_API_LINK. $url . $ref_no ;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonOut = json_decode($output);
    
            if(trim($output)=="" || empty($output) || $output==null) {
                return false;
            }
            else{
                return json_decode($output);
            }
            
        }

        public function checkApiAuthMb3($ref_no) {
            $url = API_LINK_MB3."getAppDetails";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'application_no=' . $ref_no);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
             if(trim($output)=="" || empty($output) || $output==null) {
                return false;
            }
            else{
                return json_decode($output);
            }
            
        }

        

    }

    

    // public function checkLMAceess()
    // {
    //     if ($service_code == 'NameCorrection')
    //     {
    //         $sql = "select * from misc_case_basic where stauts='S' and pending_with_officer='LM' and misc_case_no =?";
    //         $data = $this->db->query($sql, array($case_no));
    //         if ($data->num_rows()<=0)
    //         return false;

    //     }
    // }
?>