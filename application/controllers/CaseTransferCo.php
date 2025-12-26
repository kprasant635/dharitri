<?php
class CaseTransferCo extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->load->helper('file');
        $this->load->helper('download');
    }


    function index(){
        $dist_code = $this->session->userdata('dist_code');
        $data['circle_list'] = $this->db->query('select * from location where dist_code = ? and subdiv_code != ? and cir_code != ? and mouza_pargona_code = ?', array($dist_code, '00', '00', '00'))->result();

        $data['_view'] = 'transfer/transfer_co';
        $this->load->view('layouts/main', $data);
    }

    function getFromOfficers(){
        $service_code = $this->input->post('service_code');
        $location = $this->input->post('location');

        $expl = explode('_', $location); 

        $dist_code = $expl[0]; 
        $subdiv_code = $expl[1];
        $cir_code = $expl[2];

        $sql = null;

        if($service_code == 'O_03'){
            $mut_type = '03';
            $sql_agg = ' comp_serv_yn is null ';
        }
        else if($service_code == 'OC_03'){
            $mut_type = '03';
            $sql_agg = ' comp_serv_yn = \'Y\' ';
        }
        else if($service_code == 'O_04'){
            $mut_type = '04';
            $sql_agg = ' comp_serv_yn is null ';
        }
        else if($service_code == 'O_01'){
            $mut_type = '01';
            $sql_agg = ' comp_serv_yn is null ';
        }

        //misc_case_basic
        else if($service_code == 'O_06'){
            $misc_case_type = '06';
        }
        else if($service_code == 'O_07'){
            $misc_case_type = '07';
        }

        //field_mut_basic
        else if($service_code == 'F_01'){
            $mut_type = '01';
        }
        else if($service_code == 'F_02'){
            $mut_type = '01';
        }

        //allotment
        else if($service_code == 'O_02'){
            $mut_type = '02';
        }


        if(in_array($service_code, ['O_03', 'O_04', 'OC_03', 'O_01'])){
            //petition_basic
            $sql = $this->db->query("select usr.username, lt.user_code, lt.dist_code, lt.subdiv_code, lt.cir_code from loginuser_table lt join users usr on lt.dist_code = usr.dist_code and lt.subdiv_code = usr.subdiv_code and lt.cir_code = usr.cir_code and lt.user_code = usr.user_code join (
                select dist_code, subdiv_code, cir_code, co_user_code, add_off_name from petition_basic where status not in ('F', 'D') and mut_type = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and $sql_agg group by dist_code, subdiv_code, cir_code, co_user_code, add_off_name 
            ) as pb on pb.dist_code = lt.dist_code and pb.subdiv_code = lt.subdiv_code and pb.cir_code = lt.cir_code and (pb.co_user_code = lt.user_code OR pb.add_off_name = lt.user_code) GROUP BY usr.username, lt.user_code, lt.dist_code, lt.subdiv_code, lt.cir_code", array($mut_type, $dist_code, $subdiv_code, $cir_code));
        }

        if(in_array($service_code, ['O_06', 'O_07'])){
            //misc_case_basic
            $sql = $this->db->query("select usr.username, lt.user_code, lt.dist_code, lt.subdiv_code, lt.cir_code from loginuser_table lt join users usr on lt.dist_code = usr.dist_code and lt.subdiv_code = usr.subdiv_code and lt.cir_code = usr.cir_code and lt.user_code = usr.user_code join (
                select dist_code, subdiv_code, cir_code, add_to_officer from misc_case_basic where status not in ('F', '10') and misc_case_type = ? and dist_code = ? and subdiv_code = ? and cir_code = ? group by dist_code, subdiv_code, cir_code, add_to_officer 
            ) as pb on pb.dist_code = lt.dist_code and pb.subdiv_code = lt.subdiv_code and pb.cir_code = lt.cir_code and pb.add_to_officer = lt.user_code", array($misc_case_type, $dist_code, $subdiv_code, $cir_code));
        }

        if(in_array($service_code, ['F_01', 'F_02'])){
            //field_mut_basic
            $sql = $this->db->query("select usr.username, lt.user_code, lt.dist_code, lt.subdiv_code, lt.cir_code from loginuser_table lt join users usr on lt.dist_code = usr.dist_code and lt.subdiv_code = usr.subdiv_code and lt.cir_code = usr.cir_code and lt.user_code = usr.user_code join (
                select dist_code, subdiv_code, cir_code, add_off_name from field_mut_basic where mut_type = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and is_dispose is null AND order_passed is null group by dist_code, subdiv_code, cir_code, add_off_name 
            ) as pb on pb.dist_code = lt.dist_code and pb.subdiv_code = lt.subdiv_code and pb.cir_code = lt.cir_code and pb.add_off_name = lt.user_code", array($mut_type, $dist_code, $subdiv_code, $cir_code));
        }

        if(in_array($service_code, ['O_02'])){
            //allotment_cert_basic
            $sql = $this->db->query("select usr.username, lt.user_code, lt.dist_code, lt.subdiv_code, lt.cir_code from loginuser_table lt join users usr on lt.dist_code = usr.dist_code and lt.subdiv_code = usr.subdiv_code and lt.cir_code = usr.cir_code and lt.user_code = usr.user_code join (
                select dist_code, subdiv_code, circle_code as cir_code, co_code from allotment_cert_basic where dist_code = ? and subdiv_code = ? and circle_code = ? and status != ? group by dist_code, subdiv_code, cir_code, co_code 
            ) as pb on pb.dist_code = lt.dist_code and pb.subdiv_code = lt.subdiv_code and pb.cir_code = lt.cir_code and pb.co_code = lt.user_code", array($dist_code, $subdiv_code, $cir_code, 'F'));

        }

        if($sql != null && $sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR30: No case(s) found in this circle!'
            ]);
            return false;
        }

        $sql1 = $this->db->query('select lt.user_code, usr.username from loginuser_table lt join users usr on lt.dist_code = usr.dist_code and lt.subdiv_code = usr.subdiv_code and lt.cir_code = usr.cir_code and lt.user_code = usr.user_code where lt.dist_code = ? and lt.subdiv_code = ? and lt.cir_code = ? and lt.mouza_pargona_code = ? and usr.user_desig_code = ? and lt.dis_enb_option = ?', array($dist_code, $subdiv_code, $cir_code, '00', 'CO', 'E'));

        if($sql1->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR78: No user found!'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'data' => $sql != null ? $sql->result() : $sql,
            'data1' => $sql1->result()
        ]);
    }


    function transferCase(){
        $location               = $this->input->post('location');
        $service_code           = $this->input->post('service_code_name');
        $to_user_code           = $this->input->post('to_user_code');
        $from_user_code_array   = $this->input->post('from_user_code');

        if(empty($location) || empty($service_code) || empty($to_user_code) || empty($from_user_code_array)){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR127: Please select all field(s)!'
            ]);
            return false;
        }

        $from_offi_list = "'" . implode("','", $from_user_code_array) . "'";
        
        $l_exp = explode('_', $location);
        $dist_code = $l_exp[0];
        $subdiv_code = $l_exp[1];
        $cir_code = $l_exp[2];


        if($service_code == 'O_03'){
            $mut_type = '03';
            $sql_agg = ' comp_serv_yn is null ';
        }
        else if($service_code == 'OC_03'){
            $mut_type = '03';
            $sql_agg = ' comp_serv_yn = \'Y\' ';
        }
        else if($service_code == 'O_04'){
            $mut_type = '04';
            $sql_agg = ' comp_serv_yn is null ';
        }
        else if($service_code == 'O_01'){
            $mut_type = '01';
            $sql_agg = ' comp_serv_yn is null ';
        }

        //misc_case_basic
        else if($service_code == 'O_06'){
            $misc_case_type = '06';
        }
        else if($service_code == 'O_07'){
            $misc_case_type = '07';
        }

        //field_mut_basic
        else if($service_code == 'F_01'){
            $mut_type = '01';
            $sql_agg = ' comp_serv_yn is null ';
        }
        else if($service_code == 'F_02'){
            $mut_type = '01';
            $sql_agg = ' comp_serv_yn is null ';
        }

        //allotment
        else if($service_code == 'O_02'){
            $mut_type = '02';
        }

        if(in_array($service_code, ['O_03', 'O_04', 'OC_03', 'O_01'])){
            //petition_basic
            $getCasesSql = $this->db->query("select case_no, es_flag from petition_basic where mut_type = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and (co_user_code in ($from_offi_list) or add_off_name in ($from_offi_list)) and status not in ('F', 'D') and year_no >= ? and $sql_agg group by case_no, es_flag", array($mut_type, $dist_code, $subdiv_code, $cir_code, '2017'));
        }

        if(in_array($service_code, ['O_06', 'O_07'])){
            //misc_case_basic
            $getCasesSql = $this->db->query("select misc_case_no as case_no, es_flag from misc_case_basic where misc_case_type = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and add_to_officer in ($from_offi_list) and status not in ('F', '10') and year_no >= ? and add_to_officer is not null group by misc_case_no, es_flag", array($misc_case_type, $dist_code, $subdiv_code, $cir_code, '2017'));
        }

        if(in_array($service_code, ['F_01', 'F_02'])){
            //field_mut_basic
            $getCasesSql = $this->db->query("select case_no, es_flag from field_mut_basic where mut_type = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and add_off_name in ($from_offi_list) and is_dispose is null and order_passed is null and year_no >= ? and add_off_name is not null group by case_no, es_flag", array($mut_type, $dist_code, $subdiv_code, $cir_code, '2017'));
        }

        if(in_array($service_code, ['O_02'])){
            //allotment_cert_basic
            $getCasesSql = $this->db->query("select case_no, es_flag from allotment_cert_basic where dist_code = ? and subdiv_code = ? and circle_code = ? and co_code in ($from_offi_list) and status != ? and year_no >= ? and co_code is not null group by case_no, es_flag", array($dist_code, $subdiv_code, $cir_code, 'F', '2017'));
        }

        ///end of quries
        if($getCasesSql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR83: No case(s) found in this circle!'
            ]);
            return false;
        }

        $cases_result = $getCasesSql->result();

        $this->db->trans_begin();

        foreach($cases_result as $case_row){

            if($case_row->es_flag == 1){
                $sql_esc = $this->db->query('select * from escalation_details where case_no = ? and assigned_to LIKE \'CO%\'', array($case_row->case_no));
                if($sql_esc->num_rows() <= 0){
                    continue;
                }
            }

            ///change in petition_basic
            $from_co_code = null;
            if(in_array($service_code, ['O_03', 'O_04', 'OC_03', 'O_01'])){
                $from_co_code = $this->db->query('select * from petition_basic where case_no = ?', array($case_row->case_no))->row()->add_off_name;
                
                $update_arr = [
                    'co_user_code'  => $to_user_code,
                    'add_off_name'  => $to_user_code,
                ];

                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('case_no', $case_row->case_no);
                $this->db->where_not_in('status', array('F', 'D'));
                $this->db->where('mut_type', $mut_type);
                if($service_code == 'OC_03'){
                    $this->db->where('comp_serv_yn', 'Y');
                }
                $this->db->update('petition_basic', $update_arr);

                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR116: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }

            if(in_array($service_code, ['O_06', 'O_07'])){
                $from_co_code = $this->db->query('select * from misc_case_basic where misc_case_no = ?', array($case_row->case_no))->row()->add_to_officer;

                $update_arr = [
                    'add_to_officer'  => $to_user_code,
                ];

                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('misc_case_no', $case_row->case_no);
                $this->db->where('misc_case_type', $misc_case_type);
                $this->db->where_not_in('status', array('F', '10'));
                $this->db->update('misc_case_basic', $update_arr);

                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR254116: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }

            if(in_array($service_code, ['F_01', 'F_02'])){
                $from_co_code = $this->db->query('select * from field_mut_basic where case_no = ?', array($case_row->case_no))->row()->add_off_name;

                $update_arr = [
                    'add_off_name'  => $to_user_code,
                ];

                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('case_no', $case_row->case_no);
                $this->db->where('mut_type', $mut_type);
                $this->db->where('is_dispose is null');
                $this->db->where('order_passed is null');
                $this->db->update('field_mut_basic', $update_arr);

                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR280116: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }

            if(in_array($service_code, ['O_02'])){
                //allotment_cert_basic
                $from_co_code = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_row->case_no))->row()->co_code;

                $update_arr = [
                    'co_code'  => $to_user_code,
                ];

                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('circle_code', $cir_code);
                $this->db->where('case_no', $case_row->case_no);
                $this->db->where_not_in('status', array('F'));
                $this->db->update('allotment_cert_basic', $update_arr);
                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR321116: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }

            ///change in escalation_details
            if($case_row->es_flag == 1){
                $update_esc_arr = [
                    'assigned_to' => $to_user_code,
                ];
    
                $this->db->where('case_no', $case_row->case_no);
                $this->db->where("assigned_to LIKE 'CO%'");
                $this->db->update('escalation_details', $update_esc_arr);
    
                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR136: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }

            ///insert into proceeding
            $from_name = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $from_co_code)->username;
            $to_name = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $to_user_code)->username;

            $user_name = $this->utilityclass->getSelectedADCName($dist_code, $this->session->userdata('user_code'))->username;


            if(in_array($service_code, ['O_02', 'F_01', 'F_02', 'O_03', 'O_04', 'OC_03', 'O_01'])){

                // non misc
                $proceeding = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding where case_no = ? limit 1", array($case_row->case_no))->result();
                $proceeding_id = $proceeding[0]->proceed + 1;
    
                $proceeding_data_ldu = array(
                    'case_no' => $case_row->case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'co_order' => 'Case pulled by '.$user_name.' from '.$from_name.' and assigned to '.$to_name ,
                    //'note_on_order' => '',
                    //'next_date_of_hearing' => $hearing_date,
                    'status' => 'pending',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code
                );
    
                $insert_pp5 = $this->db->insert('petition_proceeding', $proceeding_data_ldu);
                if($insert_pp5 != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR165: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }
            else if(in_array($service_code, ['O_06', 'O_07'])){

                // misc
                $sql = "SELECT MAX(note_no) AS max_note_no 
                            FROM misc_case_process_reports 
                            WHERE misc_case_no = ?";

                $result = $this->db->query($sql, array($case_row->case_no));
                if ($result->num_rows() > 0) {
                    $note_no = ($result->row()->max_note_no ?? 0) + 1;
                } else {
                    $note_no = 1;
                }

                $misc_case_petition_no = $this->db->query('select * from misc_case_basic where misc_case_no = ?', array($case_row->case_no))->row()->misc_case_petition_no;

                $userdata = array(
                    'dist_code'             => $dist_code,
                    'subdiv_code'           => $subdiv_code,
                    'cir_code'              => $cir_code,
                    'note_no'               => $note_no,
                    'misc_case_no'          => $case_row->case_no,
                    // 'co_fresh_proceeding'   => $co_fresh_proceeding,
                    'process_note'          => 'Case pulled by '.$user_name.' from '.$from_name.' and assigned to '.$to_name ,
                    'note_date'             => date('Y-m-d H:i:s'),
                    'user_code'             => $this->session->userdata('user_code'),
                    'operation'             => 'E',
                    'misc_case_petition_no' => $misc_case_petition_no
                );
    
                $insert4 = $this->db->insert("misc_case_process_reports", $userdata);
                if($insert4 != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '<div id="ERR4411"></div>165: Unable to transfer case no - '.$case_row->case_no
                    ]);
                    return false;
                }
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Case(s) successfully transferred to '.$to_name
        ]);
 
    }
    



















}