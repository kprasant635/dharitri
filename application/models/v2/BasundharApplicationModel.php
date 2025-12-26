<?php
class BasundharApplicationModel extends CI_Model {
    protected $table = 'basundhar_application';

    public function __construct() {
        parent::__construct();
    }
    
    function insertBasundharApplicationInfo($basundhara) {
        $this->db->insert($this->table,$basundhara);
        return ($this->db->affected_rows() != 1) ? 0 : 1;
    }

    public function get_the_application($conditions = [], $selectFields = '*'){
        /**
         * $selectFields can be a string or array. Pass column name(s) in comma(,) separated value or pass an array
         * Eg: $selectFields = 'abc, def, xyz' or $selectFields = ['abc', 'def', 'xyz']
         */
        // 
        if(count($conditions)){
            $this->db->where($conditions);
        }
        return $this->db->select($selectFields)
                        ->get($this->table)
                        ->row();
    }

    public function searchBasundharaLink($case_no){
        $linkAvail = $this->get_the_application(['dharitree' => $case_no], 'basundhara');
        if($linkAvail){
            $linkAvail = $linkAvail->basundhara;
            $caseRtpsBasu = $this->checkRtpsService($linkAvail);
            if($caseRtpsBasu == 'RTPS'){
                $apilink = RTPS_API_LINK;
            }
            else{
                $apilink = API_LINK;
            }
            $url = $apilink . "uploadfileName?case=" . $linkAvail;
            $output = sendCurlRequest($url);
            return $output = json_decode($output);
        }else {
            return false;
        }
    }

    public function searchBasundharaLinkApp($case_no){
        // $sql="Select basundhara from  basundhar_application where dharitree='$case_no' ";
        // $linkAvail=$this->db->query($sql)->row();
        $linkAvail = $this->get_the_application(['dharitree' => $case_no], ['basundhara']);
        if($linkAvail){
            $linkAvail = $linkAvail->basundhara;
            if($linkAvail){
                $url = API_LINK."serviceResponse?application_no=" . $linkAvail ;
                $output = sendCurlRequest($url);
                return $output = json_decode($output);
            }else {
                return false;
            }
        }
    }

    public function checkRtpsService($case){
        // $sql="SELECT basundhara FROM basundhar_application WHERE basundhara=? and (basundhara is not null or basundhara='') ";
        // $dataFound=$this->db->query($sql, $case)->row();
        $dataFound = $this->get_the_application(['basundhara' => $case], ['basundhara']);
        if($dataFound){
            $data = $dataFound->basundhara;
            $var = explode('/', $data);
            $service = $var['0'];
        }else{
            $service = null;
        }
        return $service;
    }

    // private function case_pending_with_co_and_dc($dist_code, $subdiv_code, $cir_code){
    //     return $this->db->where('dist_code', $dist_code)
    //                     ->where('subdiv_code', $subdiv_code)
    //                     ->where('cir_code', $cir_code)
    //                     ->where('co_yn', NULL)
    //                     ->where('dc_yn', NULL)
    //                     ->where("(status != 'R' and status!='M' OR status is null OR status='C')")
    //                     ->get($this->table);
    // }

    function checkExistBasundhar($case){
        $condition = array('dharitree' => $case);
        $this->db->select('basundhara')->from($this->table)->where($condition);
        $dataFound = $this->db->get()->row();
        if($dataFound){
            $dataFound=$dataFound->basundhara;
        }else{
            $dataFound=null;
        }
        return $dataFound;
    }    
    function queryPost($case_no){
        $caseRtpsBasu=$this->checkRtpsService($case_no);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
        $url = $apilink."QueryReturn";
        $curl_post_array = [
            'application' => $case_no,
        ];
        // Requesting CURL here
        $data = sendCurlRequest($url, "POST", $curl_post_array);
        return json_decode($data);
    }

    function getExistingApplicationsByBasundhara($application_no){
       return $this->db->select('COUNT(*) AS app_count')->where(['basundhara'=>$application_no, 'dharitree !='=>'NULL'])->get($this->table)->row();


        // $sql="Select count(*) as c from  basundhar_application where basundhara='$case_basu' and (dharitree!=null or dharitree is not null )";
        // $dataFound=$this->db->query($sql)->row();
        // if($dataFound->c >0){
        //     $dataFound=$dataFound->c;
        // }else{
        //     $dataFound=null;
        // }
        // return $dataFound;
    }

    public function paymentConfirmation($basundhara){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."paymentStatus");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $basundhara,
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return $result;
    }

}
?>