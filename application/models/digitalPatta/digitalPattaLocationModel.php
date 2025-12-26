<?php
class digitalPattaLocationModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    //db_switch method
    public function dbswitch(){
        //$CI=&get_instance();
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }

    //method to get the geocordinates
    public Function getGeoTagCoOrdinateFromAppNo_old($application_no)
    {
        $query = $this->db->query("select * from supportive_document_mobile where applid=?",array($application_no));
        if($query->num_rows() == 0){
            return "No Data Found";
        }else{
            return $result = $query->result();
        }
    }

    //getting geo cordinates details of the application no
    public function getGeoCordinatesFromAppNo($application_no)
    {
        $query = $this->db->query("select * from supportive_document_mobile where applid=?",array($application_no));
        if($query->num_rows() == 0){
            return "No Data Found";
        }else{
            return $result = $query->row();
        }
    }

    //method to get the district name in englsh
    public function getDistrictNameEng($dist_code)
    {
        $district = $this->db->query("select locname_eng AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }

    //method to get subdiv name in englsh
    public function getSubDivNameEng($dist_code,$subdiv_code)
    {
        $this->dbswitch();
        $subdiv = $this->db->query("select locname_eng AS subdiv from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $subdiv->row()->subdiv;
    }

    //method to get circle name in englsh
    public function getCircleNameEng($dist_code,$subdiv_code,$cir_code)
    {
        $this->dbswitch();
        $circle = $this->db->query("select locname_eng AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $circle->row()->circle;
    }

    //method to get mouza name in englsh
    public function getMouzaNameEng($dist_code, $subdiv_code, $circle_code, $mouza_code)
    {
        $this->dbswitch();
        $mouza = $this->db->query("select locname_eng AS mouza from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

    //method to get lot name in englsh
    public function getLotNameEng($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no)
    {
        $this->dbswitch();
        $lot = $this->db->query("select locname_eng AS lot from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='$lot_no'");
        return $lot->row()->lot;
    }

    //method to get village name in englsh
    public function getVillageNameEng($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code)
    {
        $this->dbswitch();
        $village = $this->db->query("select locname_eng AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");
        return $village->row()->village;
    }

    //method to get measure
    function Total_Bigha_Katha_Lessa($total_lessa)
    {
        $mm = 0;
        if($total_lessa < 0)
        {
            $mm = 1;
            $total_lessa = abs($total_lessa);
        }
        $bigha = $total_lessa / 100;
        $rem_lessa = fmod($total_lessa, 100);
        $katha = $rem_lessa / 20;
        $r_lessa = fmod($rem_lessa, 20);
        $mesaure = array();
        $mesaure[].=($mm==1) ? -floor($bigha): floor($bigha);
        $mesaure[].=($mm==1) ? -floor($katha): floor($katha);
        $mesaure[].=($mm==1) ? -($r_lessa) : $r_lessa;
        $mesaure[].=0;
        return $mesaure;
    }

    //method to get measure
    function get_Hec_Are_CAre($bigha, $katha, $lessa) {
        $total_lesa = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        $centiarr = (10000 / 747) * $total_lesa;
        $hectar = $centiarr / 10000;
        $wholeHector = floor($hectar);      // 1
        $fraction1 = $hectar - $wholeHector; // .25
        $arr = 100 * $fraction1;
        $wholeArr = floor($arr);
        $fraction2 = $arr - $wholeArr;
        $arr2 = $fraction2 * 100;
        $wholeCArr = sprintf('%0.4f', $arr2);
        $hec_are_care = $wholeHector . "-" . $wholeArr . "-" . $wholeCArr;
        // return $hec_are_care;
        return [
            "hec" =>$wholeHector,
            "are" =>$wholeArr,
            "Care" =>$wholeCArr,
        ];
    }


    // method for SqMtr
    function getSqMtrHectorFromAreaNC($bigha, $katha, $lessa, $ganda, $dist_code)
    {
        $applied_b  = $bigha;
        $applied_k  = $katha;
        $applied_lc = $lessa;
        $applied_g  = $ganda;
        //////////////////
        if (in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            $sqrMeter = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g) * 4.1806368;
        }
        else
        {
            $sqrMeter = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc) * 13.37803776;
        }

        return [
            "totalSqMtr" => $sqrMeter
        ];
    }



    //-------- for Bengali version 13/6/18
    function Total_Bigha_Katha_Lessa2($total_ganda)
    {
        $mm = 0;
        if($total_ganda < 0)
        {
            $mm = 1;
            $total_ganda = abs($total_ganda);
        }
        $bigha = $total_ganda / 6400;
        $rem_ganda = $total_ganda % 6400;
        $katha = $rem_ganda / 320;
        $rem_ganda2 = $rem_ganda % 320;
        $chatak = $rem_ganda2/20;
        $rem_ganda3 =  $rem_ganda2%20;
        $mesaure = array();
        $mesaure[].=($mm==1) ? -floor($bigha): floor($bigha);
        $mesaure[].=($mm==1) ? -floor($katha): floor($katha);
        $mesaure[].=($mm==1) ? -floor($chatak): floor($chatak);
        $mesaure[].=($mm==1) ? -(number_format($rem_ganda3,4)) : number_format($rem_ganda3,4);
        return $mesaure;
    }

    //--------for Bengali version 13/6/18
    function get_Hec_Are_CAre2($bigha, $katha, $lessa,$ganda) {
        $total_ganda = $ganda + ($lessa*20) + ($katha * 320) + ($bigha * 6400);
        // $totalAre = round((13.37804/6400)*$total_ganda,5);
        //  $total_lesa = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        $centiarr = (10000 / 747) * $total_ganda;
        $hectar = $centiarr / 10000;
        $wholeHector = floor($hectar);      // 1
        $fraction1 = $hectar - $wholeHector; // .25
        $arr = 100 * $fraction1;
        $wholeArr = floor($arr);
        $fraction2 = $arr - $wholeArr;
        $arr2 = $fraction2 * 100;
        $wholeCArr = round($arr2,2);
        $hec_are_care = $wholeHector . "-" . $wholeArr . "-" . $wholeCArr;
        return $hec_are_care;
    }

    // added on 03/11/2023
    function encryptJwtCase($case_no)
    {
        $CI = & get_instance();
        $CI->output->set_header("Access-Control-Allow-Origin:*");
        $jwt = new JWT();
        $key = DIGITAL_PATTA_SECRET_KEY;
        $payload = $case_no;
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    //method to get chitha allotee details from caSE NO
    public function getChithaAlloteeDetailsFromcaseNo($case_no)
    {

        $query = $this->db->query("Select * from chitha_settlement_allottee where case_no =? ", array($case_no));
        if($query->num_rows() != 0 ){
            return $query->result();
        }else{
            return "NOT-FOUND";
        }
    }

    //method to get chitha basic details from location 
    public function getChithaBasicDetailsFromLocation($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no)
    {
        $query = $this->db->select('*')
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza_pargona_code)
            ->where('lot_no', $lot_no)
            ->where('vill_townprt_code', $vill_townprt_code)
            ->where('patta_type_code', $patta_type_code)
            ->where('patta_no', $patta_no)
            ->where('dag_n_desc is not null')
            ->where('dag_s_desc is not null')
            ->where('dag_w_desc is not null')
            ->where('dag_e_desc is not null')
            ->from('chitha_basic')
            ->get();
        if($query->num_rows() != 0 ){
            return $query->result();
        }else{
            return "NOT-FOUND";
        }
    }

    //method to get the land class from land class code
    public function getLandClassCode($d) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select landtype_eng from landclass_code where class_code='$d'";
        return $CI->db->query($query)->row()->landtype_eng;
    }

    //method to get patta type from patta type code in english
    public function getPattaType($code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $sql = "select pattatype_eng from patta_code where type_code='$code'";
        return $CI->db->query($sql)->row()->pattatype_eng;
    }

    public function getDagSketch($dist_code,$dag_no,$applid)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => SIKRITI_PATRA_GET_SKETCH_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $applid,
                'dag_no' => $dag_no,
                'dist_code' => $dist_code),
        ));
        $response = curl_exec($curl);
        // curl_close($curl);
        // echo "<pre>";
        // var_dump($response);
        // echo "</pre>";
        // exit;
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if(isset($response_obj->responseType) && $response_obj->responseType == 2){
                //echo "<pre>";
                //var_dump($response_obj);
                if(isset($response_obj->status->base64file) && $response_obj->status->base64file !="" && $response_obj->status->base64file !=null){
                    header('Content-Type: '.$response_obj->status->file_type);
                    echo base64_decode($response_obj->status->base64file);
                }else{
                    log_message("error", "#SKSCRLLM0003, Curl Error(Y) In Api ".SIKRITI_PATRA_GET_SKETCH_URL);
                    echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #SKSCRLLM0003");
                }
                //echo "</pre>";
            }else{
                log_message("error", "#SKSCRLLM0001, Curl Error(Y) In Api ".SIKRITI_PATRA_GET_SKETCH_URL);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #SKSCRLLM0001");
            }
        }else{
            log_message("error", "#SKSCRLLM0002, Curl Error(200) In Api ".SIKRITI_PATRA_GET_SKETCH_URL);
            echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #SKSCRLLM0002");
        }
    }

    public function getDigitalPattaVillageList($dist_code, $subdiv_code, $circle_code)
    {
        $sql = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code from  settlement_basic where dist_code = ? and subdiv_code = ? and cir_code =? and digital_patta_offered =?  group by dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $uniqueVill  = $this->db->query($sql, array($dist_code, $subdiv_code, $circle_code,'1'));
        return $uniqueVill->result();
    }


    public function getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code)
    {
        $this->dbswitch();
        $villageCode = $this->db->query("select uuid AS village from location where dist_code ='$dist_code' and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");
        return $villageCode->row()->village;
    }

    public function getLocationByUUID($uuid)
    {
        $sql = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code from  location where uuid =?  group by dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $uniqueVill  = $this->db->query($sql, array($uuid));
        return $uniqueVill->row();
    }

}
?>