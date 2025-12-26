<?php

ini_set('memory_limit', '-1');

class GovNameChangeController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('jamabandi/JamabandiModel');
        $this->load->model('mutation/mutationmodel');
    }

    public function getFlowIndex(){
        $user_desig_code = $this->session->userdata('user_desig_code');
        $process_flow = GOV_NAME_CHANGES_FLOW;
        // var_dump($process_flow);
        $key = array_search($user_desig_code, $process_flow);
        if ($key !== false) {
           return $key;
        } else {
            dd("user not authorized");
        }
    }

    public function index(){
        // var_dump($this->session->userdata);die;
        $data['dist_code'] = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $this->session->userdata('cir_code');
        $data['flow_index'] = $this->getFlowIndex();
        // var_dump($this->getFlowIndex());die;
        $data['_view'] = 'GovNameChange/index';
        $this->load->view('layouts/main',$data);
    }


    public function loadTableData() {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $mouza =  $this->input->post('mouza');
        $lot =  $this->input->post('lot');
        $village =  $this->input->post('village');
        $dag =  $this->input->post('dag');

        $index = $this->getFlowIndex();
        if($index==0){
            $sql = "SELECT 
                        cdp.dist_code,
                        cdp.subdiv_code,
                        cdp.cir_code,
                        cdp.mouza_pargona_code,
                        cdp.lot_no,
                        cdp.vill_townprt_code,
                        cdp.dag_no,
                        cp.pdar_name,
                        cp.pdar_father,
                        cdp.patta_no,
                        cdp.patta_type_code,
                        cdp.pdar_id
                    FROM chitha_dag_pattadar cdp
                    JOIN chitha_pattadar cp 
                        ON cdp.pdar_id = cp.pdar_id
                        AND cdp.dist_code = cp.dist_code
                        AND cdp.subdiv_code = cp.subdiv_code
                        AND cdp.cir_code = cp.cir_code
                        AND cdp.mouza_pargona_code = cp.mouza_pargona_code
                        AND cdp.lot_no = cp.lot_no
                        AND cdp.vill_townprt_code = cp.vill_townprt_code
                        AND cdp.patta_no = cp.patta_no and cdp.patta_type_code=cp.patta_type_code
                    WHERE cdp.patta_type_code IN (
                        SELECT type_code 
                        FROM patta_code 
                        WHERE jamabandi = 'n'
                    )
                    AND cdp.p_flag !='1'
                    AND cdp.dist_code = ?
                    AND cdp.subdiv_code = ?
                    AND cdp.cir_code = ?
                    AND cdp.mouza_pargona_code = ?
                    AND cdp.lot_no = ?
                    AND cdp.vill_townprt_code = ?
                    AND cdp.dag_no = ?
                    LIMIT ? OFFSET ?
                ";
        
            $query = $this->db->query($sql, [$dist_code, $subdiv_code, $cir_code, $mouza, $lot, $village,$dag, $length, $start]);
            $result =  $query->result_array();

            $query2 = $this->db->query($sql, [$dist_code, $subdiv_code, $cir_code, $mouza, $lot, $village,$dag, 10000, 0]);
            $total_result = $query2->num_rows();
        }else{
            $forward_index = $index-1;
            $sql = "
                SELECT * 
                FROM gov_name_change cdp 
                WHERE forward_index='$forward_index' and status != 'completed'
            ";

            $conditions = [];
            $params = [];

            if (!empty($dist_code)) {
                $conditions[] = "cdp.dist_code = ?";
                $params[] = $dist_code;
            }
            if (!empty($subdiv_code) && $subdiv_code != '00') {
                $conditions[] = "cdp.subdiv_code = ?";
                $params[] = $subdiv_code;
            }
            if (!empty($cir_code) && $cir_code != '00') {
                $conditions[] = "cdp.cir_code = ?";
                $params[] = $cir_code;
            }

            if (!empty($conditions)) {
                $sql .= " AND " . implode(" AND ", $conditions);
            }
            // For the paginated data
            $sql_with_limit = $sql . " LIMIT ? OFFSET ?";
            $params_with_limit = array_merge($params, [$length, $start]);
            $query = $this->db->query($sql_with_limit, $params_with_limit);
            $result = $query->result_array();
            // echo $this->db->last_query();die;
            $sql_total = $sql;
            $params_total = $params;
            $query2 = $this->db->query($sql_total, $params_total);
            $total_result = $query2->num_rows();
        }

        $data = [];

        foreach ($result as $key => $res) {
            if(isset($res['random_no'])){
                $random_no = $res['random_no'];
            }else{
                $random_no = mt_rand(10000, 99999);
            }

            if($index == 0){
                $button_name = 'Apply';
            }else if($index == count(GOV_NAME_CHANGES_FLOW)-1){
                $button_name = 'Approve';
            }else{
                $button_name = 'Forward';
            }
            if($index == 0){
                $button = '<button class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="openModel(\'' . $res['dist_code'] . '\', \'' . $res['subdiv_code'] . '\', \'' . $res['cir_code'] . '\', \'' . $res['mouza_pargona_code'] . '\', \'' . $res['lot_no'] . '\', \'' . $res['vill_townprt_code'] . '\', \'' . $res['dag_no'] . '\', \'' . $res['patta_no'] . '\', \'' . $res['pdar_id'] . '\', \'' . $res['patta_type_code'] . '\', \'' . $random_no . '\', \'' . $res['pdar_name'] . '\', \'' . $res['pdar_father'] . '\')">'.$button_name.'</button>';
            }else{
                $button = '<button class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="openModel(\'' . $res['dist_code'] . '\', \'' . $res['subdiv_code'] . '\', \'' . $res['cir_code'] . '\', \'' . $res['mouza_pargona_code'] . '\', \'' . $res['lot_no'] . '\', \'' . $res['vill_townprt_code'] . '\', \'' . $res['dag_no'] . '\', \'' . $res['patta_no'] . '\', \'' . $res['pdar_id'] . '\', \'' . $res['patta_type_code'] . '\', \'' . $random_no . '\', \'' . $res['pdar_name'] . '\', \'' . $res['pdar_father'] . '\', \'' . $res['id'] . '\')">'.$button_name.'</button>';
            }
            
            $village = $this->utilityclass->getVillageName($res['dist_code'], $res['subdiv_code'], $res['cir_code'], $res['mouza_pargona_code'], $res['lot_no'],$res['vill_townprt_code']);
            $Dag_no = $res['dag_no'];
            $pdar_name = $res['pdar_name'];
            $father_name = $res['pdar_father'];
            $data[] = [
                $start + $key + 1,       // Sl No
                $village, 
                $Dag_no,
                $pdar_name,
                $father_name,
                $button,
            ];
        }
    
        echo json_encode([
            "draw" => intval($draw),
            "recordsTotal" => $total_result,
            "recordsFiltered" => $total_result,
            "data" => $data
        ]);
    }

    public function saveChanges()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza = $this->input->post('mouza_pargona_code');
        $lot = $this->input->post('lot_no');
        $village = $this->input->post('vill_townport_code');
        $dag = $this->input->post('dag_no');
        $patta_no = $this->input->post('patta_no');
        $pdar_id = $this->input->post('pdar_id');
        $patta_type_code = $this->input->post('patta_type_code');
        $pdar_name = $this->input->post('pdar_name');
        $father_name = $this->input->post('father_name');
        $random_no = $this->input->post('random_no');
        $comment = $this->input->post('comment');
        if(empty($pdar_name) || empty($father_name) || empty($comment)){
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'error',
                        'message' => 'All Fields are mandatory',
                        'data' => 'OK'
                    ]));
                return;
        }
        $index = $this->getFlowIndex();
        $this->db->trans_begin();
        if($index ==0 && $index != (count(GOV_NAME_CHANGES_FLOW)-1)){
            // var_dump("ok");die;
            $app_id = $dist_code.$subdiv_code.$cir_code.$mouza.$lot.$village.$dag.$pdar_id.'-'.$random_no;
            $query = $this->db->get_where('supportive_document', ['case_no' => $app_id]);
            $result = $query->result_array();
            if (empty($result)) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'error',
                        'message' => 'Plz Upload Document',
                        'data' => 'OK'
                    ]));
                return; // or exit;
            }

            $where = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza,
                'lot_no' => $lot,
                'vill_townprt_code' => $village,
                'pdar_id' => $pdar_id,
                'patta_no' => $patta_no,
                'dag_no' => $dag,
                'patta_type_code' => $patta_type_code,
            ];

            $this->db->where($where);
            $this->db->where_in('status', ['initiated', 'forwarded']); // Add this line
            $query = $this->db->get('gov_name_change');
            $row = $query->row_array();

            if (!empty($row)) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'error',
                        'message' => 'Already applied',
                        'data' => 'OK'
                    ]));
                return;
            }



            $comnt = [
                GOV_NAME_CHANGES_FLOW[$index] => [
                    'date' => date('Y-m-d H:i:s'),
                    'comment' => $comment,
                ]
            ];

            $data = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza,
                'lot_no' => $lot,
                'vill_townprt_code' => $village,
                'pdar_id' => $pdar_id,
                'patta_no' => $patta_no,
                'dag_no' => $dag,
                'patta_type_code' => $patta_type_code,
                'pdar_name' => $pdar_name,
                'pdar_father' => $father_name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'initiated',
                'random_no' => $random_no,
                'forward_index' => 0,
                'changes' => json_encode($comnt)
            ];
            $this->db->insert('gov_name_change',$data);
            $this->db->trans_commit();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Data received successfully',
                    'data' => 'OK'
                ]));
            return;
        }else if($index == (count(GOV_NAME_CHANGES_FLOW)-1)){
            // $this->FinalChange($dist_code,$subdiv_code,$cir_code,$mouza,$lot,$village,$dag,$patta_no,$pdar_id,$patta_type_code,$pdar_name,$father_name);
            $data = [
                'status' => 'completed',
                'forward_index' => $index,
            ];
        }else{
            $data = [
                'pdar_name' => $pdar_name,
                'pdar_father' => $father_name,
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'forwarded',
                'random_no' => $random_no,
                'forward_index' => $index,
            ];
        }

        $where = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza,
            'lot_no' => $lot,
            'vill_townprt_code' => $village,
            'pdar_id' => $pdar_id,
            'patta_no' => $patta_no,
            'dag_no' => $dag,
            'patta_type_code' => $patta_type_code,
        ];
        // var_dump($where);
        $this->db->where($where);
        $this->db->where_in('status', ['initiated', 'forwarded']);
        $query = $this->db->get('gov_name_change');
        $row = $query->row_array();
        $previous = json_decode($row['changes'], true);
        $previous[GOV_NAME_CHANGES_FLOW[$index]] = [
                    'date' => date('Y-m-d H:i:s'),
                    'comment' => $comment,
                ];
       
        $data['changes'] = json_encode($previous);
        $this->db->where($where);
        $this->db->update('gov_name_change', $data);
        // echo $this->db->last_query();die;
        $this->db->trans_commit();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => 'OK'
        ]));
        return;
    }


    public function loadDoc()
    {
        $app_id = $this->input->post('app_id');
        $id = $this->input->post('id');
        $query = $this->db->get_where('gov_name_change', ['id' => $id]);
        $app_result = $query->row_array();
        $query = $this->db->get_where('supportive_document', ['case_no' => $app_id]);
        $result = $query->result_array();
        $data = [
            'application' => $app_result,
            'document' => $result,
        ];
        echo json_encode($data);
    }



    public function FinalChange($dist_code,$subdiv_code,$cir_code,$mouza,$lot,$village,$dag,$patta_no,$pdar_id,$patta_type_code,$pdar_name,$father_name)
    {
        $sql2 = "SELECT * from chitha_pattadar 
                WHERE dist_code = ?
                        AND subdiv_code = ?
                        AND cir_code = ?
                        AND mouza_pargona_code = ?
                        AND lot_no = ?
                        AND vill_townprt_code = ?
                        AND pdar_id = ?
                        AND patta_no = ?
                        AND patta_type_code = ?
                        ";
        $query2 = $this->db->query($sql2, [$dist_code, $subdiv_code, $cir_code, $mouza, $lot, $village,$pdar_id,$patta_no,$patta_type_code]);
        $result = $query2->row();
        $data = [
            'case_no' => 'GOV_PDAR_CNG',
            'date' => date('Y-m-d H:i:s'),
            'table_name' => 'chitha_pattadar',
            'data' => json_encode($result),
        ];

        $this->db->insert('archive_data', $data);
        $table = 'chitha_pattadar';
        $params = [
            'pdar_name'   => $pdar_name,
            'pdar_father' => $father_name,
        ];

        $where = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza,
            'lot_no'             => $lot,
            'vill_townprt_code'  => $village,
            'pdar_id'            => $pdar_id,
            'patta_no'           => $patta_no,
            'patta_type_code'    => $patta_type_code,
        ];
        $result = $this->Chitha_basic_model->update_table($table, $params, $where);
        
        return true;
    }


    public function loadDag() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza =  $this->input->post('mouza');
        $lot =  $this->input->post('lot');
        $village =  $this->input->post('village');
        // $dag =  $this->input->post('dag');


        $sql = "SELECT 
                    distinct(dag_no)
                FROM chitha_basic
                WHERE patta_type_code IN (
                    SELECT type_code 
                    FROM patta_code 
                    WHERE jamabandi = 'n'
                )
                AND dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND mouza_pargona_code = ?
                AND lot_no = ?
                AND vill_townprt_code = ?
                ORDER BY dag_no
            ";
    
        $query = $this->db->query($sql, [$dist_code, $subdiv_code, $cir_code, $mouza, $lot, $village]);
        $result =  $query->result_array();
        // echo $this->db->last_query(); die;
        $data ="<option selected disabled>Select Dag No</option>";
        foreach($result as $re){
            $data .= "<option value='" . htmlspecialchars($re['dag_no']) . "'>" . htmlspecialchars($re['dag_no']) . "</option>";
        }

        echo $data; die;
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'dag_no' => $data,
        ]));
    }


}