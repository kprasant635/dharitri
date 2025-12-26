<?php

class BhunakshaIntegrationModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('chitha/ChithaModel');
        $this->load->model('propChain/PropChainModel');
    }

    public function insert($savimtva_array){
        if(isset($savimtva_array['is_full_dag']) && $savimtva_array['is_full_dag']==1){
                $status = 2;
        }else{
            $status = 0;
        }
        $data = [
                    'co_user_code' => $this->session->userdata('user_code'),
                    'co_date' => date('Y-m-d H:i:s'),
                    'status'    => $status,
                    'date'      => date('Y-m-d H:i:s'),
                ];

        $mergedData = array_merge($savimtva_array, $data);
        $this->db->where([
            'dag_no'     => $savimtva_array['dag_no'],
            'new_dag_no' => $savimtva_array['new_dag_no'],
            'case_no'    => $savimtva_array['case_no'],
        ]);
        $existing = $this->db->get('bhunaksha_svamitva_cases')->row();
        if (!$existing) {
            $record = $this->db->insert('bhunaksha_svamitva_cases', $mergedData);
        }

        return $record;
    }

    public function generateGisCodeNew($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code)
    {
        $gisCode = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;;

        return $gisCode;
    }

    public function getPendingAssets($id)
    {
        // dd($this->session->userdata);
        $this->db->where([
            'id'     => $id,
        ]);
        $record = $this->db->get('bhunaksha_svamitva_cases')->row();

        // $nocuser = $this->session->userdata('nocuser');
        // $user_name = $this->PropChainModel->getUserName($nocuser);
        $gis_code = $this->generateGisCodeNew($record->dist_code, $record->subdiv_code, $record->cir_code, $record->mouza_pargona_code, $record->lot_no, $record->vill_townprt_code);
        $this->load->helper('url');
        $this->load->helper('jwt', 'jwt_helper');
		$key = BUNAKSHA_SPLIT_SSO_CONS;
        $payload=[
                "user_code"=> $this->session->userdata('user_code'),
                "name"=> $this->utilityclass->getDefinedMondalsName($record->dist_code, $record->subdiv_code, $record->cir_code, $record->mouza_pargona_code, $record->lot_no,$this->session->userdata('user_code'))->lm_name,
                "user_desig_code"=> 'LRA',
                "use_name"=> $this->session->userdata('user_code'),
                "first_login"=> "1",
                "dist_code"=> $record->dist_code,
                "subdiv_code"=> $record->subdiv_code,
                "cir_code"=> $record->cir_code,
                "mouza_pargona_code"=> $record->mouza_pargona_code,
                "lot_no"=> $record->lot_no,
                "location_code"=> $gis_code,
                "plot_no"=> $record->dag_no,
                "new_plot_no"=> $record->new_dag_no,
                "case_no"=> $record->case_no,
                "case_date"=> date('Y-m-d', strtotime($record->mutation_date)),
                "logged_in"=> true,
                "exp"=> time()+300
        ];
        $encod = jwt::encode($payload, $key, 'HS256');
        if(IS_PRODUCTION==0){
            log_message('error',"BHUSPLIT_TOKEN###".$encod);
        }
        $levels = $record->dist_code . ',' . $record->subdiv_code;
        $url = BUNAKSHA_API_LINK."?token=$encod";
       $data = [
            'payload' => $encod,
            // 'status'  => 1,
            'lm_user_code' => $this->session->userdata('user_code'),
            'lm_date' => date('Y-m-d H:i:s'),
        ];
        $where = [
            'dag_no'     => $record->dag_no,
            'new_dag_no' => $record->new_dag_no,
            'case_no'    => $record->case_no,
        ];

        $this->db->where($where);
        $this->db->update('bhunaksha_svamitva_cases', $data);
        return $url;
    }

}
    ?>