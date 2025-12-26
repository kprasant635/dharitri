<?php
class NrcDocModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->dist_code = $this->session->userdata('dist_code');
        $this->load->library('AES');
    }

    public function getDharCaseNoFromBasu($appl_no) {
        $dhar_no = $this->db->query("SELECT dharitree FROM basundhar_application 
                        WHERE basundhara=?", array($appl_no));
        if($dhar_no->num_rows() <= 0){
            return $dhar_no = '';
        }
        return $dhar_no->row()->dharitree;
    }

    public function getDetailFromSettlementBasic($appl_no) {
        $query = $this->db->query("SELECT * FROM settlement_basic 
                        WHERE applid=?", array($appl_no));
        return $query->row();
    }

    public function getDetailNrcDocuments($case_no) {
        $query = $this->db->query("SELECT * FROM nrc_documents 
                        WHERE case_no=?", array($case_no));
        return $query;
    }

    public function getNrcDocsUploadedByLm($case_no)
    {
        $query = $this->db->query("SELECT * FROM nrc_documents 
                        WHERE case_no=? AND is_final=?", array($case_no, 1));
        return $query;
    }


    //get nrc docs uploaded by citizen
    public function getNrcDocsUploadedByCitizen($appl_no)
    {
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getNrcDocuments");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $appl_no,
            'api_key'        => API_KEY,
            'token'          => $token,
        )));
        $result = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $result;
    }


    public function getRejectedCategoryForNrcUp($case_no)
    {
        return $query = $this->db->query("select distinct(case_no) from rejected_remark a join reject_master b on a.reject_code::varchar = b.reject_code::varchar where b.reject_code in ('358','143', '356', '355', '359', '360', '357') and a.case_no = ?", 
                                    array($case_no))->num_rows();
    }

    public function getFromBasicNotD()
    {
        return $query = $this->db->query("select * from settlement_basic where case_no not in ('D')")->num_rows();
    }




}