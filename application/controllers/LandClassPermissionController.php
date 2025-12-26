<?php
class LandClassPermissionController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
    }

    public function index(){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $get_vill_sql = $this->db->query('select * from location where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code != ? and lot_no != ? and vill_townprt_code != ?', array($dist_code, $subdiv_code, $cir_code, '00', '00', '00000'));

        if($get_vill_sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR25: Something went wrong!'
            ]);
            return false;
        }


        $data = [
            'user_code' => $this->session->userdata('user_code'),
            'village_list' => $get_vill_sql->result(),
        ];
        
        $data['_view'] = 'LandClassPermission/landclass_permission';
        $this->load->view('layouts/main', $data);
    }

    public function menu(){

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $data = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
        ];

        $this->load->view('LandClassPermission/menu', $data);
    }

    public function permissionView(){
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $data = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
        ];


        $check_dag_inserted_sql = $this->db->query("SELECT string_agg(quote_literal(dag_no), ', ') AS dag_list FROM allowed_landclass_master WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));

        $dag_list = null;
        if($check_dag_inserted_sql->num_rows() > 0){
            $dag_list = $check_dag_inserted_sql->row()->dag_list;
        }

        if($dag_list == null){
            $getDagListSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? order by dag_no_int', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));
        }else{
            $getDagListSql = $this->db->query("select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no not in ($dag_list) order by dag_no_int", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));
        }

        $data['error'] = null;

        if($getDagListSql->num_rows() <= 0){
            $data['error'] = 'No dags found for this location!';
        }

        $getLandClassSql = $this->db->query('select * from landclass_code order by class_code_cat asc');
        $data['landclass_error'] = null;
        if($getLandClassSql->num_rows() <= 0){
            $data['landclass_error'] = 'No landclass found!';
        }

        $data['dag_result'] = $getDagListSql->result();
        $data['landclass_result'] = $getLandClassSql->result();

        $this->load->view('LandClassPermission/permission_view', $data);
    }

    public function permissionSave(){
        $loc_arr = $this->input->post('dag_no_arr');
        $landclass_array = $this->input->post('landclass_arr');

        $this->db->trans_begin();

        foreach($loc_arr as $loc_row){
            $expld = explode('_', $loc_row);

            $dist_code = $expld[0];
            $subdiv_code = $expld[1];
            $cir_code = $expld[2];
            $mouza_pargona_code = $expld[3];
            $lot_no = $expld[4];
            $vill_townprt_code = $expld[5];
            $dag_no = $expld[6];

            // check if already inserted in master table

            $master_ch_sql = $this->db->query('select * from allowed_landclass_master where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));

            if($master_ch_sql->num_rows() <= 0){
                //insert into master table
                $master_arr = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'ip' => $this->utilityclass->get_client_ip(),
                    'date_entry' => date('Y-m-d H:i:s')
                ];

                $master_insert = $this->db->insert('allowed_landclass_master', $master_arr);
                if($master_insert != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR135: Unable to save data!'
                    ]);
                    return false;
                }

                $master_id = $this->db->insert_id();

            }else{
                $master_id = $master_ch_sql->row()->id;
            }

            foreach($landclass_array as $landclass_code){
                //check if landclass already inserted in slave
                $slCheckSql = $this->db->query('select * from allowed_landclass_code where allowed_landclass_master_id = ? and landclass_code = ?', array($master_id, $landclass_code));

                if($slCheckSql->num_rows() > 0){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR159: Landclass already exist!'
                    ]);
                    return false;
                }else{
                    //insert into slave table
                    $slave_arr = [
                        'allowed_landclass_master_id' => $master_id,
                        'landclass_code' => $landclass_code,
                        // 'flag' => 
                        'date_entry' => date('Y-m-d H:i:s'),
                        // 'date_update' => 
                    ];

                    $slave_insert = $this->db->insert('allowed_landclass_code', $slave_arr);
                    if($slave_insert != 1){
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 0,
                            'msg' => '#ERR177: Unable to save data!'
                        ]);
                        return false;
                    }
                }
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Data saved successfully...'
        ]);

    }

    public function viewList(){
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $get_mast = $this->db->query('select * from allowed_landclass_master where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));

        $data['error'] = null;
        if($get_mast->num_rows <= 0){
            $data['error'] = 'No data available!';
        }

        $data['dag_list'] = $get_mast->result();

        $this->load->view('LandClassPermission/view_list', $data);
    }

    public function landclassViewInDag(){
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $dag_no = $this->input->post('dag_no');

        $get_mast = $this->db->query('select * from allowed_landclass_master where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));

        $data['error'] = null;
        if($get_mast->num_rows <= 0){
            $data['error'] = 'No data available!';
        }

        $master_id = $get_mast->row()->id;

        $slave_sql = $this->db->query('select * from allowed_landclass_code where allowed_landclass_master_id = ?', array($master_id));
        if($slave_sql->num_rows() <= 0){
            $data['error'] = 'No data available!';
        }

        $data = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'master_id' => $master_id
        ];

        $data['landclass_result'] = $slave_sql->result();
        $this->load->view('LandClassPermission/landclass_in_dag_view', $data);
    }

    public function deleteDag(){
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $dag_no = $this->input->post('dag_no');
        $master_id = $this->input->post('master_id');

        $this->db->trans_begin();

        //insert into archive before deleting

        $fetch_data = $this->db->query('select * from allowed_landclass_code where allowed_landclass_master_id = ?', array($master_id));

        if($fetch_data->num_rows() <= 0){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR282: Something went wrong!'
            ]);
            return false;
        }

        $arc_data = $fetch_data->result();

        $archive_arr = [
            'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 
            'cir_code' => $cir_code, 
            'mouza_pargona_code' => $mouza_pargona_code, 
            'lot_no' => $lot_no, 
            'vill_townprt_code' => $vill_townprt_code, 
            'dag_no' => $dag_no, 
            'arc_data' => json_encode($arc_data),
            'date_entry' => date('Y-m-d H:i:s')
        ];

        $arc_insert = $this->db->insert('allowed_landclass_archived', $archive_arr);
        if($arc_insert != 1){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR306: Something went wrong!'
            ]);
            return false;
        }

        $this->db->query('delete from allowed_landclass_code where allowed_landclass_master_id = ?', array($master_id));
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR264: Something went wrong!'
            ]);
            return false;
        }

        $this->db->query('delete from allowed_landclass_master where id = ?', array($master_id));
        if($this->db->affected_rows() != 1){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR277: Something went wrong!'
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Dag successfully deleted...'
        ]);

    }





}