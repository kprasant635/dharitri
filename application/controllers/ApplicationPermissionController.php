<?php
class ApplicationPermissionController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->load->model('ApplicationPermission');
    }

    public function userList(){
        // echo "<pre/>";
        // print_r($this->session->userdata);exit;
        $usercode = $this->session->userdata('user_code');
        $user_desig_code = '';
        if($this->session->userdata('user_desig_code') == 'DC'){
            $csql = "";
            $user_desig_code = ['ADC', 'DDA'];
        }
        if($this->session->userdata('user_desig_code') == 'ADC'){
            $csql = "";
            $user_desig_code = ['CO', 'ADA'];
        }
        if($this->session->userdata('user_desig_code') == 'CO'){
            $user_desig_code =['AST','CDA'];
            $dis_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $csql = " AND lg.dist_code='".$dis_code."' AND lg.subdiv_code='".$subdiv_code."' AND lg.cir_code='".$cir_code."'";
        }
        $desig_list = "'" . implode("','", $user_desig_code) . "'";
        $sql = "SELECT u.user_code, u.username, u.user_desig_code, lg.permission_allowed FROM users u INNER JOIN loginuser_table lg ON u.user_code = lg.user_code and lg.dist_code=u.dist_code and lg.subdiv_code=u.subdiv_code and lg.cir_code=u.cir_code WHERE lg.dis_enb_option='E' AND (u.user_desig_code IN ($desig_list) OR lg.created_by='".$usercode."') ".$csql."";
        $users = $this->db->query($sql)->result_array();

        foreach($users as $key => $user){
            $users[$key]['desg'] = $this->db->query("Select user_desig_as from master_user_designation where user_desig_code = '".$user['user_desig_code']."'")->row()->user_desig_as;
        }
        
        $data['users'] = $users;
        
        $data['_view'] = 'userpermission/user_list';
        $this->load->view('layouts/main', $data);
    }

    public function userPermission($user_code){
        $data['user'] = $this->db->where('user_code', $user_code)->get('users')->row_array();
        $data['applications'] = $this->db->where('status', 1)->get('applications')->result_array();
        $data['user_code'] = $user_code;

        $data['_view'] = 'userpermission/user_permission';
        $this->load->view('layouts/main', $data);
    }

    public function getApplicationServices($user_code, $app_id){
        $services = $this->db->where('status', 1)->where('app_id', $app_id)->get('application_services')->result_array();
        $html = '';
        if(!empty($services)){            
            $html .= '<table id="datatable" class="datatable table table-stripped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll"> All</th>
                </tr>
                </thead>
                <tbody>';
                    $cnt = 0;
                    foreach($services as $service){
                        $cnt++;
                        $permission = $this->ApplicationPermission->getPermission($this->db, $user_code, $app_id, $service['id']);
                        $checked = "";
                        if(!empty($permission)){
                            $checked = "checked";
                        }
                        $html .= '<tr>
                            <td>'.$cnt.'</td>
                            <td>'.$service['name'].'</td>
                            <td><input type="checkbox" class="checkBoxD selectMark" value="'.$service['id'].'" id="'.$service['id'].'" name="service_id[]" '.$checked.'></td>
                        </tr>';
                    }
                $html .= '</tbody>
            </table>            
            <div class="d-flex justify-content-center">
                <input type="hidden" id="app_id" name="app_id" value="'.$app_id.'" />
                <input type="hidden" id="user_code" name="user_code" value="'.$user_code.'" />
                <button class="btn btn-success permission_save_btn" type="submit"> Save <i class="fa fa-check-square-o"></i> </button>
            </div>';
        }
        return response_json(['success' => true, 'html' => $html], 200);
    }

    public function storePermission(){
        $user_code = $this->input->post('user_code');
        $app_id = $this->input->post('app_id');
        $service_ids = $this->input->post('service_id');
        $write_access = $this->input->post('write_access');
        $read_access = $this->input->post('read_access');

        if (empty($service_ids)){
            return response_json(['success' => false, 'message' => "Please check at least one service."], 200);
        }
        if (!isset($user_code)){
            return response_json(['success' => false, 'message' => "User not found."], 200);
        }
        if (!isset($app_id)){
            return response_json(['success' => false, 'message' => "Application not found."], 200);
        }
        if(!empty($service_ids)){
            $permission = $this->db->where('user_code', $user_code)->where('app_id', $app_id)->get('application_permissions')->row_array();
            if(!empty($permission)){
                $this->db->where('user_code', $permission['user_code']);
                $this->db->where('app_id', $permission['app_id']);
                $this->db->delete('application_permissions');
            }

            foreach($service_ids as $service_id){
                try{
                    $this->ApplicationPermission->store($this->db, $user_code, $app_id, $service_id);
                } catch(Exception $e){
                    return response_json(['success' => false, 'message' => $e->getMessage()], 403);
                }
            }

            return response_json(['success' => true, 'message' => "Permission saved successfully."], 200);
        }

    }

    public function storePermissionForRccm(){
        $user_code = $this->input->post('user_code');
        $app_id = 1;
        $service_id = 0;
        $permission = $this->db->where('user_code', $user_code)->where('app_id', $app_id)->get('application_permissions')->row_array();
        if(!empty($permission)){
            return response_json(['success' => false, 'message' => "Permission already given."], 200);
        } else{
            $this->db->trans_begin();
            try{
                $this->ApplicationPermission->store($this->db, $user_code, $app_id, $service_id);
            } catch(Exception $e){
                $this->db->trans_rollback();
                return response_json(['success' => false, 'message' => $e->getMessage()], 403);
            }

            $this->db->trans_commit();

            return response_json(['success' => true, 'message' => "Permission saved successfully."], 200);
        }
    }

    public function revertPermissionForRccm(){
        $user_code = $this->input->post('user_code');
        $app_id = 1;
        $service_id = 0;
        $permission = $this->db->where('user_code', $user_code)->where('app_id', $app_id)->get('application_permissions')->row_array();
        if(!empty($permission)){
            $this->db->trans_begin();
            try{
                $this->ApplicationPermission->revert($this->db, $user_code, $app_id, $service_id);
            } catch(Exception $e){
                $this->db->trans_rollback();
                return response_json(['success' => false, 'message' => $e->getMessage()], 403);
            }

            $this->db->trans_commit();
            return response_json(['success' => true, 'message' => "Permission successfully revoked."], 200);
        } else{
            return response_json(['success' => false, 'message' => "Permission not found."], 200);
        }
    }
}