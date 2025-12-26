<?php
class EkhajanaDoulVerify extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulVerifyModel');
    }

    public function landing_page()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouzadar_report'] = $this->EkhajanaDoulVerifyModel->getMouzadarDoulVerifyReport($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/doul_views/landingPage';
        $this->load->view('layouts/main',$data);
    }

    public function saveCoRemarks()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $dist_code          = $this->input->post('dist_code');
        $subdiv_code        = $this->input->post('subdiv_code');
        $cir_code           = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $vill_townprt_code  = $this->input->post('vill_townprt_code');
        $lot_no             = $this->input->post('lot_no');
        $patta_type_code    = $this->input->post('patta_type_code');
        $patta_no           = $this->input->post('patta_no');
        $co_remarks         = $this->input->post('co_remarks');

        $this->db->trans_begin();
        $check_row = $this->db->query("select co_remarks from ekhajana_mouzadar_doul_verification where dist_code= ? and subdiv_code= ? and cir_code=? 
            and mouza_pargona_code=? and lot_no = ? and vill_townprt_code= ? and patta_type_code= ? and patta_no= ?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,
            $lot_no,$vill_townprt_code,$patta_type_code,$patta_no));

        if ($check_row->num_rows() > 0) {
            $co_remarks_check = $check_row->row()->co_remarks;
            if (!empty($co_remarks_check)) {
                echo json_encode([
                    'status' => 'failed',
                    'msg'    => 'Remarks of this patta has already been submitted, Error-Code : #EKHERUEMDV002'
                ]);
                exit;
            }
        }

        if (trim($co_remarks) === "") {
            echo json_encode([
                'status' => 'failed',
                'msg'    => 'Circle Officer Remarks Field is required'
            ]);
            exit;
        }
        

        $update_data = [
            'co_remarks'         => $co_remarks,
            'co_user_code'       => $this->session->all_userdata()['user_code'],
            'status'             => CIRCLE_OFFICER_FORWARD_DOUL_VERIFY,
            'modified_at'        => date('Y-m-d H:i:s'),
        ];
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->where('patta_type_code', $patta_type_code);
        $this->db->where('patta_no', $patta_no);
        $this->db->update('ekhajana_mouzadar_doul_verification', $update_data);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHERUEMDV001, Error in update, table 'ekhajana_mouzadar_doul_verification'  with query- ". json_encode($this->db->last_query()));
            echo json_encode(['status' => 'failed' ,'msg' => 'Some error occured, Error-Code : #EKHERUEMDV001']);
        }else{
            $this->db->trans_commit();
            echo json_encode(['status' => 'success' ,'msg' => 'Data Updated Succesfully']);
        }
    }
}
?>

