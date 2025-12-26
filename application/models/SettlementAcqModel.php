<?php
class SettlementAcqModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    // get all settlement basic
    public function getBasicData($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('acquisition_basic');
        return $basic->row_array();
    }

    public function getBasicDataObject($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('acquisition_basic');
        return $basic->row();
    }
    public function getBasicDataObjectDags($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('acquisition_dag_details');
        return $basic->row();
    }

    public function getBasicDataObjectDagsArray($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('acquisition_dag_details');
        return $basic->result();
    }
    public function getObjectionsClaims($case)
    {
        $basic = $this->db->select()
            ->where('application_no',$case)
            ->get('form_y_claims');
        return $basic->result();
    }

    public function insert_compensation($data)
    {
        return $this->db->insert('acq_compensations', $data);
    }

    public function chitha($case_no)
    {
        // Fetch only required columns from acquisition_basic
        $basic = $this->db->select('
                dist_code,
                subdiv_code,
                cir_code,
                mouza_pargona_code,
                lot_no,
                vill_townprt_code,
                case_no,
                applid,
                tea_estate_name,
                status,
                user_code,
                uuid,
                notice_no,
                notice_date,
                mobile_no,
                final_order
            ')
            ->where('case_no', $case_no)
            ->get('acquisition_basic')
            ->row_array();

        // Fetch only required columns from acquisition_dag_details
        $dags = $this->db->select('
                dag_no,
                patta_no,
                patta_type_code,
                bigha,
                katha,
                lessa,
                ganda,
                chatak,
                kranti
            ')
            ->where('case_no', $case_no)
            ->get('acquisition_dag_details')
            ->result_array();

        // Final formatted output
        $data = [
            'case_no'  => $case_no,
            'remarks'  => $basic['final_order'] ?? '',
            'location' => $basic,
            'dags'     => $dags
        ];

        return $data;
    }
    
}