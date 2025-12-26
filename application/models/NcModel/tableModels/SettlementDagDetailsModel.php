<?php
class SettlementDagDetailsModel extends CI_Model {

    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }


    public function insert($data){
        return $this->db->insert('settlement_dag_details', $data);
    }

    public function get($ref_id){
        $ref_id = $this->ncutility->getIDs($ref_id);
        if($ref_id == 3){
            return $this->ncutility->errorResp('ERRJS12079', 'Case ID not found!');
        }
        $this->db->where('case_no', $ref_id['case_no']);
        $this->db->from('settlement_dag_details');
        return $this->db->get();
    }

    public function getMaxLimitInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no){
        $this->db->select('spr.max_land, spr.area_flag');
        $this->db->from('chitha_dag_all_flag_details_final cdl');
        $this->db->join('settlement_premium_rate spr', 'cdl.area_flag = spr.paid');
        $this->db->where('cdl.dist_code', $dist_code);
        $this->db->where('cdl.subdiv_code', $subdiv_code);
        $this->db->where('cdl.cir_code', $cir_code);
        $this->db->where('cdl.mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('cdl.lot_no', $lot_no);
        $this->db->where('cdl.vill_townprt_code', $vill_townprt_code);
        $this->db->where('cdl.dag_no', $dag_no);
        return $this->db->get();
    }


    public function checkDagAlreadyExistOrNot($dist_code,$dag_no,$case_no)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('dag_no', $dag_no)
            ->where('case_no', $case_no)
            ->get('settlement_dag_details')
            ->num_rows();
    }


    public function getSelectedDagDetailsWith($dist_code,$dag_no,$case_no)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('dag_no', $dag_no)
            ->where('case_no', $case_no)
            ->get('settlement_dag_details');
    }



    // get reservation area details
    public function getReservationDagDetails($dist_code,$dag_no,$case_no)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('dag_no', $dag_no)
            ->where('case_no', $case_no)
            ->get('settlement_reservation');
    }






}