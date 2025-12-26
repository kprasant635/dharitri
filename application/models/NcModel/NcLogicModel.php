<?php
class NcLogicModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
        $this->load->model('NcModel/tableModels/SettlementDagDetailsModel');
    }

    public function checkMaxLimitInDag($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $dag_no, $totalAreaLessa){

        $maxLimitInDag = $this->SettlementDagDetailsModel->getMaxLimitInDag($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $dag_no);
        if($maxLimitInDag->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS131141', 'Chitha dag not flagged! Dag No #'.$dag_no);
        }

        $maxLimitInDag = $maxLimitInDag->row()->max_land;
        if($maxLimitInDag < $totalAreaLessa){

            $limiter = in_array($dist_code, json_decode(BARAK_VALLEY)) ? $this->ncutility->Total_Bigha_Katha_Lessa2($maxLimitInDag) : $this->ncutility->Total_Bigha_Katha_Lessa($maxLimitInDag);
            $limiterError = in_array($dist_code, json_decode(BARAK_VALLEY)) ? 'B:'.$limiter[0].'K:'.$limiter[1].'C:'.$limiter[2].'G:'.$limiter[3] : 'B:'.$limiter[0].'K:'.$limiter[1].'L:';

            return $this->ncutility->errorResp('ERRJS151141', 'Maximum area limit exceeded! Dag No #'.$dag_no.'(MAX allowed ('.$limiterError.')');
        }
    }

    public function checkMaxLimit($appliedMaxHome, $appliedMaxAgri, $maxHome, $maxAgri, $isUrban){
        if(strtoupper(trim($isUrban)) == 'Y'){
            if($appliedMaxHome > $maxHome){
                return $this->ncutility->errorResp('ERRJS721141', 'Maximum allowed area exceeded!(Max allowed in Homestead '.$maxHome.')'); 
            }
            if($appliedMaxAgri != 0){
                return $this->ncutility->errorResp('ERRJS731141', 'Agriculture not allowed in urban area!'); 
            }
            if(($appliedMaxAgri + $appliedMaxHome) > ($maxAgri + $maxHome)){
                return $this->ncutility->errorResp('ERRJS021141', 'Maximum allowed area exceeded!(Home + Agri '.($maxHome+$maxAgri).')'); 
            }

        }else{
            if($appliedMaxAgri > $maxAgri){
                return $this->ncutility->errorResp('ERRJS221141', 'Maximum allowed area exceeded!(Max allowed in Agriculture '.$maxAgri.')'); 
            }
            if($appliedMaxHome > $maxHome){
                return $this->ncutility->errorResp('ERRJS321141', 'Maximum allowed area exceeded!(Max allowed in Homestead '.$maxHome.')'); 
            }
            if(($appliedMaxAgri + $appliedMaxHome) > ($maxAgri + $maxHome)){
                return $this->ncutility->errorResp('ERRJS121141', 'Maximum allowed area exceeded!(Home + Agri '.($maxHome+$maxAgri).')'); 
            }
        }
    }


    public function isUrban($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $dag_no){
        $area_name = $this->SettlementDagDetailsModel->getMaxLimitInDag($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $dag_no);

        if($area_name->num_rows() <= 0){
            return $this->ncutility->errorResp('ERRJS81141', 'Chitha dag not flagged! Dag No #'.$dag_no);
        }

        $urbanArray = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
        $ruralArray = array(7,8,9,10,18,19,20,21,22);

        if(in_array($area_name->row()->area_flag, $urbanArray)){
            return 'Y';
        }else{
            return 'N';
        }
    }

}