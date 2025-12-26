<?php

date_default_timezone_set("Asia/Kolkata");
class LandclassgroupController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LandClassGroupModel');
        $this->load->model('LandClassModel');
        // $this->load->model('conversion/ASTofficeConversionModel');
        // $this->load->model('conversion/COofficeConversionModel');
        // $this->load->model('UtilsModel');
        // $this->load->model('rtps/rtpsmodel');
        $this->load->helper(array('form', 'url'));
        // $this->load->model('Escalationmodel');
        // $this->load->model('basundhara/basundharamodel');
        // $location = $this->utilityclass->getLocationFromSession();
        // $dist_code = $location['dist_code'];
        // $subdiv_code = $location['subdiv_code'];
        // $cir_code = $location['cir_code'];
        // $db=  $this->session->userdata('db');
        // $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and  cir_code = '$cir_code' ";
        // if(ENABLED_BLOCKCHAIN == 1)
        // {
        //     $this->load->model('propChain/PropChainModel');
        //     $this->load->model('propChain/PropChainCommonModel');
        // }
    }

    public function dbswitch($dist_code){       
        //$CI=&get_instance();
        $connection = null;
        if($dist_code == "02"){
            $connection = $this->load->database('dha3', TRUE);    
            // $this->db=$this->load->database('dha3', TRUE);    
        } else if($dist_code == "05"){
            $connection = $this->load->database('dha1', TRUE);    
            // $this->db=$this->load->database('dha1', TRUE);    
        } else if($dist_code == "10"){
            $connection = $this->load->database('dha24', TRUE);       
            // $this->db=$this->load->database('dha24', TRUE);       
        } else if($dist_code == "13"){
            $connection = $this->load->database('dha2', TRUE);    
            // $this->db=$this->load->database('dha2', TRUE);    
        }  else if($dist_code == "17"){
            $connection = $this->load->database('dha4', TRUE);    
            // $this->db=$this->load->database('dha4', TRUE);    
        }  else if($dist_code == "15"){
            $connection = $this->load->database('dha5', TRUE);    
            // $this->db=$this->load->database('dha5', TRUE);    
        }  else if($dist_code == "14"){
            $connection = $this->load->database('dha6', TRUE);    
            // $this->db=$this->load->database('dha6', TRUE);    
        }  else if($dist_code == "07"){
            $connection = $this->load->database('dha7', TRUE);    
            // $this->db=$this->load->database('dha7', TRUE);    
        }  else if($dist_code == "03"){
            $connection = $this->load->database('dha8', TRUE);    
            // $this->db=$this->load->database('dha8', TRUE);    
        }  else if($dist_code == "18"){
            $connection = $this->load->database('dha9', TRUE);    
            // $this->db=$this->load->database('dha9', TRUE);    
        }  else if($dist_code == "12"){
            $connection = $this->load->database('dha13', TRUE);   
            // $this->db=$this->load->database('dha13', TRUE);   
        }  else if($dist_code == "24"){
            $connection = $this->load->database('dha10', TRUE);   
            // $this->db=$this->load->database('dha10', TRUE);   
        }  else if($dist_code == "06"){
            $connection = $this->load->database('dha11', TRUE);   
            // $this->db=$this->load->database('dha11', TRUE);   
        }  else if($dist_code == "11"){
            $connection = $this->load->database('dha12', TRUE);   
            // $this->db=$this->load->database('dha12', TRUE);   
        }  else if($dist_code == "12"){
            $connection = $this->load->database('dha13', TRUE);   
            // $this->db=$this->load->database('dha13', TRUE);   
        }  else if($dist_code == "16"){
            $connection = $this->load->database('dha14', TRUE);   
            // $this->db=$this->load->database('dha14', TRUE);   
        }  else if($dist_code == "32"){
            $connection = $this->load->database('dha15', TRUE);   
            // $this->db=$this->load->database('dha15', TRUE);   
        }  else if($dist_code == "33"){
            $connection = $this->load->database('dha16', TRUE);   
            // $this->db=$this->load->database('dha16', TRUE);   
        }  else if($dist_code == "34"){
            $connection = $this->load->database('dha17', TRUE);   
            // $this->db=$this->load->database('dha17', TRUE);   
        }  else if($dist_code == "21"){
            $connection = $this->load->database('dha18', TRUE);   
            // $this->db=$this->load->database('dha18', TRUE);   
        }  else if($dist_code == "08"){
            $connection = $this->load->database('dha19', TRUE);   
            // $this->db=$this->load->database('dha19', TRUE);   
        }  else if($dist_code == "35"){
            $connection = $this->load->database('dha20', TRUE);   
            // $this->db=$this->load->database('dha20', TRUE);   
        }  else if($dist_code == "36"){
            $connection = $this->load->database('dha21', TRUE);   
            // $this->db=$this->load->database('dha21', TRUE);   
        }  else if($dist_code == "37"){
            $connection = $this->load->database('dha22', TRUE);   
            // $this->db=$this->load->database('dha22', TRUE);   
        }  else if($dist_code == "25"){
            $connection = $this->load->database('dha23', TRUE);   
            // $this->db = $this->load->database('dha23', TRUE);   
        } else if($dist_code == 'auth') {
            $connection = $this->load->database('auth', TRUE);   
        }
        
        return $connection;
    }


    // public function index() {

    //     $landclass_groups = $this->LandClassGroupModel->list();
    //     $landclasses = $this->LandClassModel->notMappedList();

    //     if(count((array) $landclass_groups) > 0){
    //         foreach($landclass_groups as $landclass_group){
    //             $lnd_clsses = $this->db->where('land_class_group_id', $landclass_group->id)->get('landclass_code')->result();
    //             $landclass_group->children = $lnd_clsses;
    //         }
    //     }
        
    //     $data['land_class_groups'] = $landclass_groups;
    //     $data['landclasses'] = $landclasses;

    //     $data['_view'] = 'land_class_group/index';

    //     $this->load->view('layouts/main',$data);
    // }

    // public function updateMap(){
    //     $user_code = $this->session->userdata('user_code');
    //     $group_id = $this->input->post('group_id');
    //     $class_code = $this->input->post('class_code');

    //     if(empty($group_id) || empty($class_code) || $group_id == 0){
    //         return response_json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
    //     }

    //     $this->db->where('class_code', $class_code)->update('landclass_code', ['land_class_group_id' => $group_id]);

    //     return response_json(['success' => true, 'message' => 'Land class mapping has been done successfully.']);
    // }
    // ########## CO Part Start from here ##########
    public function index() {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code == 'ADC'){
            return $this->adcIndex();
            // return $this->adcIndex_old();
        }
        if($user_desig_code == 'DC'){
            return $this->dcIndex();
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $landclass_groups = $this->LandClassGroupModel->list();

        $land_cls_map_security_code = $this->land_cls_map_security_code();
        $this->session->set_userdata('land_cls_map_security_code', $land_cls_map_security_code);

        $check_is_freezed = $this->db->where('user_code', $user_code)
                                    ->where('dist_code', $dist_code)
                                    ->where('subdiv_code', $subdiv_code)
                                    ->where('cir_code', $cir_code)
                                    ->where('is_freezed', 1)
                                    ->get('landclass_mapping_cases')
                                    ->row();
        
        $already_mapped_cases = $this->db->where('dist_code', $dist_code)
                                            ->where('subdiv_code', $subdiv_code)
                                            ->where('cir_code', $cir_code)
                                            ->where('user_code', $user_code)
                                            ->get('landclass_mapping_cases')->result();
        
        if(count((array) $already_mapped_cases)){
            $already_added_clss_arr = [];
            foreach($already_mapped_cases as $already_mapped_case){
                array_push($already_added_clss_arr, "'" . $already_mapped_case->land_class_code . "'");
            }

            $already_added = implode(',', $already_added_clss_arr);
            $landclasses = $this->db->query("select * from landclass_code where class_code not in (" . $already_added . ") and land_class_group_id IS NULL")->result();
            // dd($this->db->last_query());
        }else{
            $landclasses = $this->LandClassModel->notMappedList();
        }

        if(count((array) $landclass_groups) > 0){
            foreach($landclass_groups as $landclass_group){
                $landclass_group->children = $lnd_clsses_cases = $this->db->where('land_class_group_id', $landclass_group->id)
                                                                        ->where('dist_code', $dist_code)
                                                                        ->where('subdiv_code', $subdiv_code)
                                                                        ->where('cir_code', $cir_code)                                                        
                                                                        ->where('user_code', $user_code)
                                                                        ->get('landclass_mapping_cases')
                                                                        ->result();

                if(count((array) $lnd_clsses_cases)){
                    $lndcls_codes_arr = [];
                    foreach($lnd_clsses_cases as $lnd_clsses_case){
                        array_push($lndcls_codes_arr, "'" . $lnd_clsses_case->land_class_code . "'");
                        // array_push($lndcls_codes_arr, $lnd_clsses_case->land_class_code);
                    }
                    $lndcls_codes = implode(',', $lndcls_codes_arr);
                    
                    $mapped_land_classes = $this->db->query("select * from landclass_code where class_code in (". $lndcls_codes . ")")->result();

                    $landclass_group->children = $mapped_land_classes;
                }

                $landclass_group->fixed_classes = $this->db->query("select * from landclass_code where land_class_group_id = ?", array($landclass_group->id))->result();
            }
        }
        
        $data['land_class_groups'] = $landclass_groups;
        $data['landclasses'] = $landclasses;
        $data['land_cls_map_security_code'] = $land_cls_map_security_code;
        $data['is_freezed'] = $check_is_freezed ? 1 : 0;

        $data['_view'] = 'land_class_group/index';

        $this->load->view('layouts/main',$data);
    }

    public function getSuggesion(){
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        // $subdiv_code = $this->session->userdata('subdiv_code');
        // $cir_code = $this->session->userdata('cir_code');

        $group_id = $this->input->post('group_id');
        $class_code = $this->input->post('class_code');

        $other_cos_mappings = $this->db->where('user_code !=', $user_code)
                                        ->where('dist_code', $dist_code)
                                        // ->where('subdiv_code', $subdiv_code)
                                        // ->where('cir_code', $cir_code)   
                                        ->where('land_class_group_id !=', $group_id)
                                        ->where('land_class_code', $class_code)
                                        ->where('is_freezed', 1)
                                        ->get('landclass_mapping_cases')
                                        ->result();

        $landclass_code = $this->db->where('class_code', $class_code)->get('landclass_code')->row();

        $html = '';
        if(count((array) $other_cos_mappings) > 0){
            $html = '<h5 class="text-left">Land Class: ' . $landclass_code->land_type . '</h5>
                    <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Land Class Group</th>
                            <th>CO Name</th>
                            <th>Circle Name</th>
                        </tr>
                    </thead><tbody>';
            foreach($other_cos_mappings as $other_cos_mapping){
                $co = $this->db->where('dist_code', $other_cos_mapping->dist_code)
                                ->where('subdiv_code', $other_cos_mapping->subdiv_code)
                                ->where('cir_code', $other_cos_mapping->cir_code)   
                                // ->where('land_class_code', $other_cos_mapping->land_class_code)
                                ->where('user_code', $other_cos_mapping->user_code)
                                ->where('user_desig_code', 'CO')
                                ->get('users')->row();

                $location = $this->db->where('dist_code', $other_cos_mapping->dist_code)
                                        ->where('subdiv_code', $other_cos_mapping->subdiv_code)
                                        ->where('cir_code', $other_cos_mapping->cir_code)
                                        ->where('mouza_pargona_code', '00') 
                                        ->where('lot_no', '00') 
                                        ->where('vill_townprt_code', '00000')
                                        ->get('location')->row();
                
                $landclassgroup = $this->db->where('id', $other_cos_mapping->land_class_group_id)->get('land_class_groups')->row();
                
                $html .= '<tr>
                            <td>'. $landclassgroup->name .'</td>
                            <td>'. $co->username .'</td>
                            <td>'. $location->loc_name .'</td>
                        </tr>';
                
            }
            $html .= '</tbody></table>';
        }

        return response_json(['success' => true, 'message' => 'Suggestion fetched successfully', 'html' => $html]);
    }

    public function updateMap(){
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $group_id = $this->input->post('group_id');
        $class_code = $this->input->post('class_code');

        if(in_array($group_id, ['', 'undefined']) || in_array($class_code, ['', 'undefined']) ){
            return response_json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
        }

        $land_map_case = $this->db->where('user_code', $user_code)
                                    ->where('dist_code', $dist_code)
                                    ->where('subdiv_code', $subdiv_code)
                                    ->where('cir_code', $cir_code)   
                                    ->where('land_class_code', $class_code)
                                    ->get('landclass_mapping_cases')
                                    ->row();
                                    
        // Check, is there any other CO of this circle has already mapped
        $other_cos = $this->getAllCos([$user_code], $dist_code, $subdiv_code, $cir_code);
        $check_other_co_mapping_status = $this->checkOtherCoOfThisCircleAlreadyMappedOrNot($other_cos);
        if(!$check_other_co_mapping_status['success']){
            return response_json($check_other_co_mapping_status);
        }

        $this->db->trans_begin();
        if($land_map_case){
            if($land_map_case->action_taken_at){
                $this->db->trans_rollback();
                return response_json(['success' => false, 'message' => 'You can\'t update as the action has been taken for the land class']);
            }
            if($land_map_case->is_freezed == 1){
                $this->db->trans_rollback();
                return response_json(['success' => false, 'message' => 'You can\'t update as this section has been freezed.']);
            }

            if($group_id != 0){
                $this->db->where('id', $land_map_case->id)->update('landclass_mapping_cases', ['land_class_group_id' => $group_id]);
            }else{
                $this->db->where('id', $land_map_case->id)->delete('landclass_mapping_cases');
            }
        }else{
            if($group_id != 0){
                $data = [
                    'user_desig_code' => $user_desig_code,
                    'user_code' => $user_code,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'land_class_group_id' => $group_id,
                    'land_class_code' => $class_code,
                    'is_freezed' => 0,
                ];
                $this->db->insert('landclass_mapping_cases', $data);
            }else{
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRLNDCLSMAP0004 => ' . $this->db->last_query());
        
                    return response_json(['success' => false, 'message' => '#ERRLNDCLSMAP0004: Something went wrong. Please refresh the page and try again later.']);
                }

            }
        }

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            log_message('error', '#ERRLNDCLSMAP0003 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRLNDCLSMAP0003: Something went wrong. Please try again later.']);
        }

        $this->db->trans_commit();

        return response_json(['success' => true, 'message' => 'Land class mapping has been done successfully.']);
    }

    public function freezeMapping(){
        $code = $this->input->post('code');
        $session_code = $this->session->userdata('land_cls_map_security_code');
        if(empty($code)){
            return response_json(['success' => false, 'message' => 'Code is required']);
        }elseif($session_code != $code){
            return response_json(['success' => false, 'message' => 'Please enter the correct code']);
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $check_is_freezed = $this->db->where('user_code', $user_code)
                                    ->where('dist_code', $dist_code)
                                    ->where('subdiv_code', $subdiv_code)
                                    ->where('cir_code', $cir_code)   
                                    ->where('is_freezed', 1)
                                    ->get('landclass_mapping_cases')
                                    ->row();

        if($check_is_freezed){
            return response_json(['success' => false, 'message' => 'You have already freezed your mapping']);
        }else{
            // Check, is there any other CO of this circle has already mapped

            $other_cos = $this->getAllCos([$user_code], $dist_code, $subdiv_code, $cir_code);
            $check_other_co_mapping_status = $this->checkOtherCoOfThisCircleAlreadyMappedOrNot($other_cos);
            if(!$check_other_co_mapping_status['success']){
                return response_json($check_other_co_mapping_status);
            }

            $this->db->trans_begin();

            $land_class_count = $this->db->query("select count(class_code) as count from landclass_code where land_class_group_id IS NULL")->row()->count;
            $mapped_class_count = $this->db->query("select count(id) as count from landclass_mapping_cases where user_code = ?", array($user_code))->row()->count;
            
            if($land_class_count == $mapped_class_count){
                $data = [
                            'is_freezed' => 1,
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                $this->db->where('user_code', $user_code)
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)   
                            ->update('landclass_mapping_cases', $data);

                            
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRLNDCLSMAP0002 => ' . $this->db->last_query());
                    
                    return response_json(['success' => false, 'message' => '#ERRLNDCLSMAP0002: Something went wrong. Please try again later.']);
                }
                
                $this->db->trans_commit();

                $this->session->unset_userdata('land_cls_map_security_code');

                return response_json(['success' => true, 'message' => 'Your mapping has been freezed successfully.']);
            }else{
                return response_json(['success' => false, 'message' => 'Please map all the land classes before freezing.']);
            }
        }


    }

    // ########## ADC Part start from here ########
    protected function adcIndex(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if(IS_PRODUCTION == CLOSE){
            // $all_cos = $this->db->where('dist_code', $dist_code)->where('user_desig_code', 'CO')
            // ->where_in('username', ['UAT CO Palashbari', 'Uttar Ghy CO'])->get('users')->result_array();
            $all_cos = $this->getAllCos([], $dist_code);
        }else{
            // $all_cos = $this->db->where('dist_code', $dist_code)->where('user_desig_code', 'CO')->get('users')->result_array();
            $all_cos = $this->getAllCos([], $dist_code);
        }

        $all_cos_groupBy_circle = $this->cosGroupByCircle($all_cos);

        $landclass_groups = $this->LandClassGroupModel->list_array();
        $landclasses = $this->LandClassModel->list();

        $land_cls_map_security_code = $this->land_cls_map_security_code();
        $this->session->set_userdata('land_cls_map_security_code', $land_cls_map_security_code);


        // $landGroupsArr = [];
        if(count($landclass_groups) > 0){
            foreach($landclass_groups as $g_key => $landclass_group){
                if(count($all_cos_groupBy_circle)){
                    foreach($all_cos_groupBy_circle as $key => $circle_wise_cos){
                        $mapped_land_classes = [];
                        if(count($circle_wise_cos['all_cos'])){
                            foreach($circle_wise_cos['all_cos'] as $co_ins){
                                $lnd_clsses_cases = $this->db->where('user_code', $co_ins['user_code'])
                                                                    ->where('land_class_group_id', $landclass_group['id'])
                                                                    ->where('dist_code', $co_ins['dist_code'])
                                                                    ->where('subdiv_code', $co_ins['subdiv_code'])
                                                                    ->where('cir_code', $co_ins['cir_code'])   
                                                                    ->where('is_freezed', 1)
                                                                    ->where('action_taken_at IS NULL', null, false)  
                                                                    ->get('landclass_mapping_cases')
                                                                    ->result_array();
        
                                if(count($lnd_clsses_cases)){
                                    $accepted_co = $co_ins;
                                    $lndcls_codes_arr = [];
                                    foreach($lnd_clsses_cases as $lnd_clsses_case){
                                        array_push($lndcls_codes_arr, "'" . $lnd_clsses_case['land_class_code'] . "'");
                                        // array_push($lndcls_codes_arr, $lnd_clsses_case->land_class_code);
                                    }
                                    $lndcls_codes = implode(',', $lndcls_codes_arr);
                                    
                                    $mapped_land_classes = $this->db->query("select * from landclass_code where class_code in (". $lndcls_codes . ")")->result_array();
                                    
                                    // $circle_wise_cos['all_cos'][$key]['mapped_cases'] = $mapped_land_classes;
                                }
                                
                            }
                            
                        }

                        $all_cos_groupBy_circle[$key]['mapped_cases'] = $mapped_land_classes;
                        $all_cos_groupBy_circle[$key]['accepted_co'] = $accepted_co;
                    }
                }

                $landclass_groups[$g_key]['co_land_class'] = $all_cos_groupBy_circle;
                // $landclass_groups[$g_key]['co_land_class'] = $all_cos;
                $landclass_groups[$g_key]['fixed_classes'] = $this->db->query("select * from landclass_code where land_class_group_id = ?", array($landclass_group['id']))->result_array();
                
            }
        }
        
        $data['co_count'] = count($all_cos);
        $data['land_class_groups'] = $landclass_groups;
        $data['landclasses'] = $landclasses;
        $data['land_cls_map_security_code'] = $land_cls_map_security_code;

        $data['_view'] = 'land_class_group/adc-index';

        $this->load->view('layouts/main',$data);
    }

    protected function adcIndex_old(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if(IS_PRODUCTION == CLOSE){
            // $all_cos = $this->db->where('dist_code', $dist_code)->where('user_desig_code', 'CO')
            // ->where_in('username', ['UAT CO Palashbari', 'Uttar Ghy CO'])->get('users')->result_array();
            $all_cos = $this->getAllCos([], $dist_code);
        }else{
            // $all_cos = $this->db->where('dist_code', $dist_code)->where('user_desig_code', 'CO')->get('users')->result_array();
            $all_cos = $this->getAllCos([], $dist_code);
        }


        $landclass_groups = $this->LandClassGroupModel->list_array();
        $landclasses = $this->LandClassModel->list();

        $land_cls_map_security_code = $this->land_cls_map_security_code();
        $this->session->set_userdata('land_cls_map_security_code', $land_cls_map_security_code);


        // $landGroupsArr = [];
        if(count($landclass_groups) > 0){
            foreach($landclass_groups as $g_key => $landclass_group){
                if(count($all_cos)){
                    foreach($all_cos as $key => $co_ins){
                        $lnd_clsses_cases = $this->db->where('user_code', $co_ins['user_code'])
                                                            ->where('land_class_group_id', $landclass_group['id'])
                                                            ->where('dist_code', $co_ins['dist_code'])
                                                            ->where('subdiv_code', $co_ins['subdiv_code'])
                                                            ->where('cir_code', $co_ins['cir_code'])   
                                                            ->where('is_freezed', 1)
                                                            ->where('action_taken_at IS NULL', null, false)  
                                                            ->get('landclass_mapping_cases')
                                                            ->result_array();

                        if(count($lnd_clsses_cases)){
                            $lndcls_codes_arr = [];
                            foreach($lnd_clsses_cases as $lnd_clsses_case){
                                array_push($lndcls_codes_arr, "'" . $lnd_clsses_case['land_class_code'] . "'");
                                // array_push($lndcls_codes_arr, $lnd_clsses_case->land_class_code);
                            }
                            $lndcls_codes = implode(',', $lndcls_codes_arr);
                            
                            $mapped_land_classes = $this->db->query("select * from landclass_code where class_code in (". $lndcls_codes . ")")->result_array();
                            
                            $all_cos[$key]['mapped_cases'] = $mapped_land_classes;
                        }else{
                            $all_cos[$key]['mapped_cases'] = [];
                        }
                        
                    }
                    
                }

                $landclass_groups[$g_key]['co_land_class'] = $all_cos;
                $landclass_groups[$g_key]['fixed_classes'] = $this->db->query("select * from landclass_code where land_class_group_id = ?", array($landclass_group['id']))->result_array();
                
            }
        }
        
        $data['co_count'] = count($all_cos);
        $data['land_class_groups'] = $landclass_groups;
        $data['landclasses'] = $landclasses;
        $data['land_cls_map_security_code'] = $land_cls_map_security_code;

        $data['_view'] = 'land_class_group/adc-index-old';

        $this->load->view('layouts/main',$data);
    }

    public function adcapproveMapping(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $code = $this->input->post('code');
        $group_wise_classes = $this->input->post('group');
        $session_code = $this->session->userdata('land_cls_map_security_code');
        if(empty($code)){
            return response_json(['success' => false, 'message' => 'Code is required']);
        }elseif($session_code != $code){
            return response_json(['success' => false, 'message' => 'Please enter the correct code']);
        }

        if(empty($group_wise_classes) || count($group_wise_classes) == 0){
            return response_json(['success' => false, 'message' => 'Please select the classes before submitting']);
        }

        // Status will be P => Pass, R => Reject, A => Approved
        $landclass_adc_mapping = $this->db->where('dist_code', $dist_code)
                                            ->where('status', 'P')
                                            ->get('landclass_adc_mapping')->row();

        if($landclass_adc_mapping){
            return response_json(['success' => false, 'message' => 'Mapping has already been done']);
        }

        $landclasses = $this->LandClassModel->notMappedList();
        $land_class_count = 0;
        foreach($group_wise_classes as $group_wise_landclasses){
            $land_class_count += count($group_wise_landclasses);
        }

        if(count((array) $landclasses) != $land_class_count){
            return response_json(['success' => false, 'message' => 'Select all the land classes in order to map']);
        }
        
        $this->db->trans_begin();

        $batch_str = uniqid();
        foreach($group_wise_classes as $group_id => $group_wise_landclasses){
            foreach($group_wise_landclasses as $class_code){
                $data = [
                            'batch' => $batch_str,
                            'user_code' => $user_code,
                            'dist_code' => $dist_code,
                            'land_class_group_id' => $group_id,
                            'land_class_code' => $class_code,
                            'status' => 'P',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                $this->db->insert('landclass_adc_mapping', $data);

                $this->db->where('dist_code', $dist_code)
                            ->where('land_class_code', $class_code)
                            ->update('landclass_mapping_cases', ['action_taken_at' => date('Y-m-d H:i:s'), 'action_taken_by' => $user_code]);
            }
        }

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            log_message('error', '#ERRLNDCLSMAP0001 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRLNDCLSMAP0001: Something went wrong. Please try again later.']);
        }

        $this->db->trans_commit();

        return response_json(['success' => true, 'message' => 'Land classes mapped successfully and forwarded to DC.']);
    }

    private function getAllCos(array $exceptCoUserCodes = [], $dist_code = null, $subdiv_code = null, $cir_code = null): array
    {
        $query = "SELECT * FROM loginuser_table as lt join users as u on lt.dist_code=u.dist_code and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code and lt.user_code=u.user_code where lt.dis_enb_option='E' and u.user_code like 'CO%'";
        
        if(!empty($dist_code)){
            $query .= " and u.dist_code='$dist_code'";
        }
        
        if(!empty($subdiv_code)){
            $query .= " and u.subdiv_code='$subdiv_code'";
        }
        
        if(!empty($cir_code)){
            $query .= " and u.cir_code='$cir_code'";
        }

        if(!empty($exceptCoUserCodes)){
            $exceptCoUserCodesInStrign = [];
            foreach($exceptCoUserCodes as $exceptCoUserCode){
                array_push($exceptCoUserCodesInStrign, "'" . $exceptCoUserCode . "'");
            }
            $not_including_cos = implode(',', $exceptCoUserCodesInStrign);

            $query .= " and u.user_code not in ($not_including_cos)";
        }
        
        $cos = $this->db->query($query)->result_array();

        return $cos;
    }

    private function checkOtherCoOfThisCircleAlreadyMappedOrNot($other_cos): array
    {
        $response = [
            'success' => true,
            'message' => 'All are good to go'
        ];

        if(count($other_cos)){
            foreach($other_cos as $other_co){
                $check_other_co_is_freezed = $this->db->where('user_code', $other_co['user_code'])
                                                        ->where('dist_code', $other_co['dist_code'])
                                                        ->where('subdiv_code', $other_co['subdiv_code'])
                                                        ->where('cir_code', $other_co['cir_code'])   
                                                        ->where('is_freezed', 1)
                                                        ->get('landclass_mapping_cases')
                                                        ->row();
                if($check_other_co_is_freezed){
                    $response['success'] = false;
                    $response['message'] = 'Other CO already freezed this mapping';

                    break;
                }
            }
        }

        return $response;
    }
    
    // ########## DC Part start from here ########

    protected function dcIndex(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $mapping_cases = $this->db->where('dist_code', $dist_code)
                                    ->where('status', 'P')
                                    ->get('landclass_adc_mapping')
                                    ->result();
        
        $landclass_groups = [];
        if(count((array) $mapping_cases) > 0){
            $landclass_groups = $this->LandClassGroupModel->list_array();
            $batch = '';
            if(count( $landclass_groups) > 0){
                foreach($landclass_groups as $key => $landclass_group){
                    $group_cases = $this->db->where('dist_code', $dist_code)
                                            ->where('land_class_group_id', $landclass_group['id'])
                                            ->where('status', 'P')
                                            ->get('landclass_adc_mapping')
                                            ->result_array();
                    
                    if(count($group_cases) > 0){
                        foreach($group_cases as $grp_key => $group_case){
                            $landclass = $this->db->where('class_code', $group_case['land_class_code'])->get('landclass_code')->row();
                            $group_cases[$grp_key]['land_class_name'] = $landclass->land_type;
                            $group_cases[$grp_key]['land_class_eng_name'] = $landclass->landtype_eng;
    
                            if(empty($batch)){
                                $batch = $group_case['batch'];
                            }
                        }
                    }
    
                    $landclass_groups[$key]['land_classes'] = $group_cases;
                }
            }
        }


        $land_cls_map_security_code = $this->land_cls_map_security_code();
        $this->session->set_userdata('land_cls_map_security_code', $land_cls_map_security_code);
        
        $data['batch'] = $batch;
        $data['land_class_groups'] = $landclass_groups;
        $data['land_cls_map_security_code'] = $land_cls_map_security_code;

        $data['_view'] = 'land_class_group/dc-index';

        $this->load->view('layouts/main',$data);
    }
    
    public function approveMapping(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $code = $this->input->post('code');
        $batch = $this->input->post('batch');
        $session_code = $this->session->userdata('land_cls_map_security_code');
        if(empty($code)){
            return response_json(['success' => false, 'message' => 'Code is required']);
        }elseif($session_code != $code){
            return response_json(['success' => false, 'message' => 'Please enter the correct code']);
        }

        if(empty($batch)){
            return response_json(['success' => false, 'message' => 'Something went wrong. Please refresh and try again']);
        }

        $mapping_cases = $this->db->where('batch', $batch)
                                    ->where('status', 'P')
                                    ->get('landclass_adc_mapping')
                                    ->result();
    
        if(count((array) $mapping_cases) == 0){
            return response_json(['success' => false, 'message' => 'No case found']);
        }

        $this->db->trans_begin();
        foreach($mapping_cases as $mapping_case){
            $this->db->where('class_code', $mapping_case->land_class_code)->update('landclass_code', ['land_class_group_id' => $mapping_case->land_class_group_id]);
        }

        $mapcase_count = count((array) $mapping_cases);
        $this->db->where('batch', $batch)->update('landclass_adc_mapping', ['status' => 'A', 'updated_at' => date('Y-m-d H:i:s')]);

        if($this->db->affected_rows() != $mapcase_count){
            $this->db->trans_rollback();
            log_message('error', '#ERRLNDCLSMAP0003 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRLNDCLSMAP0003: Something went wrong. Please try again later.']);
        }

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            log_message('error', '#ERRLNDCLSMAP0002 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRLNDCLSMAP0002: Something went wrong. Please try again later.']);
        }

        $this->db->trans_commit();

        return response_json(['success' => true, 'message' => 'Land classes mapped successfully.']);
    }
    
    private function land_cls_map_security_code(){
        return rand(10000, 999999);
    }

    public function masterIndex(){
        $auth = $this->dbswitch('auth');
        $district_codes = $auth->query("select distinct(dist_code) from central_auth")->result();
        
        $request_dist = $this->input->get('dist_code');
        if(!empty($request_dist)){
            $default_dist_code = $request_dist;
        }else{
            $default_dist_code = $this->session->userdata('dist_code');
        }
        $connection = $this->dbswitch($default_dist_code);
        
        $data['district_codes'] = $district_codes;
        $data['default_dist_code'] = $default_dist_code;
        $data['land_classes'] = $this->LandClassModel->list($connection);
        $data['land_class_groups'] = $this->LandClassGroupModel->list($connection);
        $data['_view'] = 'land_class_group/master-index';

        $this->load->view('layouts/main',$data);
    }

    public function masterUpdate(){
        $dist_code = $this->input->post('dist_code');
        $group_id = $this->input->post('group_id');
        $class_code = $this->input->post('class_code');

        if(empty($group_id) || empty($class_code) || $group_id == 0 || $dist_code == ''){
            return response_json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
        }

        $connection = $this->dbswitch($dist_code);
        
        $this->db->trans_begin();

        $connection->where('class_code', $class_code)->update('landclass_code', ['land_class_group_id' => $group_id]);

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            log_message('error', '#ERRWLDLNDCLSMAP0001 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRWLDLNDCLSMAP0001: Something went wrong. Please try again later.']);
        }

        $this->db->trans_commit();

        return response_json(['success' => true, 'message' => 'Land class mapped successfully']);
    }

    private function cosGroupByCircle($all_cos){
        $groupByCos = [];

        $groupByArray = [];
        if(count($all_cos) > 0){
            foreach($all_cos as $all_co){
                $loc_details = $all_co['dist_code'] . '_' . $all_co['subdiv_code'] . '_' . $all_co['cir_code'];
                if(!isset($groupByArray[$loc_details])){
                    $groupByArray[$loc_details] = [];
                }

                array_push($groupByArray[$loc_details], $all_co);
            }

            foreach($groupByArray as $location => $groupByIns){
                list($dist_code, $subdiv_code, $cir_code) = explode('_', $location);

                $circle_location = $this->db->where('dist_code', $dist_code)
                                            ->where('subdiv_code', $subdiv_code)
                                            ->where('cir_code', $cir_code)
                                            ->where('mouza_pargona_code', '00')
                                            ->where('lot_no', '00')
                                            ->where('vill_townprt_code', '00000')
                                            ->get('location')->row_array();
                $circle_location['all_cos'] = $groupByIns;

                array_push($groupByCos, $circle_location);
            }
        }

        return $groupByCos;
    }
        
    
}
