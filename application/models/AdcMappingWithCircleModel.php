<?php 
    class AdcMappingWithCircleModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function caseListUnderMappingCircleOfADC($flag = null){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $cir_code_check  = 'cir_code';
        if($flag == 'ALLOTMENT'){
            $cir_code_check = 'circle_code';
        }
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========

        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code='00' and dis_enb_option='E' and user_code like 'ADC%'";
        $data=$this->db->query($sql,array($dist_code));
        $circle_array = array();
        if($data->num_rows() > 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$user_code));

            log_message('error','MB002 : ****MAPPING LIST OF USERCODE****'.$user_code.'******LIST****'.json_encode($data1->result()));
            
            foreach ($data1->result() as $key => $value) {
                $circle_array[] = $value->subdiv_code.'_'.$value->cir_code;
            }
            //////////////////
        }
        $circle_mapp_string = null;
        $circle_bifurcate = '';
        if(!empty($circle_array) && $circle_array!=null){
            $circle_mapp_string = $this->convertLiteral($circle_array);
            $circle_bifurcate = "and subdiv_code ||'_' || $cir_code_check in ($circle_mapp_string)";
        }


        log_message("error","MB: CIRCLE STRING====FOR ADC==FLAG==".$flag."=D==".$dist_code."======".json_encode($circle_mapp_string)."===circle_bifurcate==".json_encode($circle_bifurcate));


        
        return $circle_bifurcate;
    }

    public function convertLiteral($array) {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
                $index++;
        }
        return $final_str;
    }

     public function caseListUnderMappingCircleOfADCMb3($flag = null){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $cir_code_check  = 'cir_code';
        if($flag == 'ALLOTMENT'){
            $cir_code_check = 'circle_code';
        }
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========

        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code='00' and dis_enb_option='E' and user_code like 'ADC%'";
        $data=$this->db->query($sql,array($dist_code));
        $circle_array = array();
        if($data->num_rows() > 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$user_code));

            log_message('error','MB002 : ****MAPPING LIST OF USERCODE****'.$user_code.'******LIST****'.json_encode($data1->result()));
            
            foreach ($data1->result() as $key => $value) {
                $circle_array[] = $value->subdiv_code.'_'.$value->cir_code;
            }
            //////////////////
        }
        $circle_mapp_string = null;
        $circle_bifurcate = '';
        if(!empty($circle_array) && $circle_array!=null){
            $circle_mapp_string = $this->convertLiteral($circle_array);
            return $circle_mapp_string;
            // $circle_bifurcate = "and subdiv_code ||'_' || $cir_code_check in ($circle_mapp_string)";
        }


        log_message("error","MB: CIRCLE STRING====FOR ADC==FLAG==".$flag."=D==".$dist_code."======".json_encode($circle_mapp_string)."===circle_bifurcate==".json_encode($circle_bifurcate));


        
        return $circle_bifurcate;
    }
}