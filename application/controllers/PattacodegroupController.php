<?php
class PattacodegroupController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PattaCodeGroupModel');
        $this->load->model('patta/PattaModel');
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

    // public function dbswitch(){       
    //     //$CI=&get_instance();
    //     if($this->session->userdata('dist_code') == "02"){
    //         $this->db=$this->load->database('dha3', TRUE);    
    //     } else if($this->session->userdata('dist_code') == "05"){
    //         $this->db=$this->load->database('dha1', TRUE);    
    //     } else if($this->session->userdata('dist_code') == "10"){
    //         $this->db=$this->load->database('dha24', TRUE);       
    //     } else if($this->session->userdata('dist_code') == "13"){
    //         $this->db=$this->load->database('dha2', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "17"){
    //         $this->db=$this->load->database('dha4', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "15"){
    //         $this->db=$this->load->database('dha5', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "14"){
    //         $this->db=$this->load->database('dha6', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "07"){
    //         $this->db=$this->load->database('dha7', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "03"){
    //         $this->db=$this->load->database('dha8', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "18"){
    //         $this->db=$this->load->database('dha9', TRUE);    
    //     }  else if($this->session->userdata('dist_code') == "12"){
    //         $this->db=$this->load->database('dha13', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "24"){
    //         $this->db=$this->load->database('dha10', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "06"){
    //         $this->db=$this->load->database('dha11', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "11"){
    //         $this->db=$this->load->database('dha12', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "12"){
    //         $this->db=$this->load->database('dha13', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "16"){
    //         $this->db=$this->load->database('dha14', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "32"){
    //         $this->db=$this->load->database('dha15', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "33"){
    //         $this->db=$this->load->database('dha16', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "34"){
    //         $this->db=$this->load->database('dha17', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "21"){
    //         $this->db=$this->load->database('dha18', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "08"){
    //         $this->db=$this->load->database('dha19', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "35"){
    //         $this->db=$this->load->database('dha20', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "36"){
    //         $this->db=$this->load->database('dha21', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "37"){
    //         $this->db=$this->load->database('dha22', TRUE);   
    //     }  else if($this->session->userdata('dist_code') == "25"){
    //         $this->db=$this->load->database('dha23', TRUE);   
    //     }                                                                                                                                                                                                            
    // }

    // ########## CO Part Start from here ##########
    public function index() {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code == 'ADC'){
            return $this->dcIndex();
        }

        if($user_desig_code == 'DC'){
            return $this->dcIndexNew();
        }
        // dd($this->session->userdata);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $pattacode_groups = $this->PattaCodeGroupModel->list();

        $patta_code_map_security_code = $this->patta_code_map_security_code();
        $this->session->set_userdata('patta_code_map_security_code', $patta_code_map_security_code);

        $check_is_freezed = $this->db->where('user_code', $user_code)
                                    ->where('dist_code', $dist_code)
                                    ->where('subdiv_code', $subdiv_code)
                                    ->where('cir_code', $cir_code)
                                    ->where('is_freezed', 1)
                                    ->get('patta_code_mapping_cases')
                                    ->row();
        
        $already_mapped_cases = $this->db->where('dist_code', $dist_code)
                                            ->where('subdiv_code', $subdiv_code)
                                            ->where('cir_code', $cir_code)
                                            ->where('user_code', $user_code)
                                            ->get('patta_code_mapping_cases')->result();
        
        if(count((array) $already_mapped_cases)){
            $already_added_clss_arr = [];
            foreach($already_mapped_cases as $already_mapped_case){
                array_push($already_added_clss_arr, "'" . $already_mapped_case->patta_type_code . "'");
            }

            $already_added = implode(',', $already_added_clss_arr);
            $pattacodes = $this->db->query("select * from patta_code where type_code not in (" . $already_added . ") and patta_code_group_id IS NULL")->result();
            
        }else{
            $pattacodes = $this->PattaModel->notMappedList();
        }
        
        if(count((array) $pattacode_groups) > 0){
            foreach($pattacode_groups as $pattacode_group){
                $pattacode_group->children = $patta_type_cases = $this->db->where('patta_code_group_id', $pattacode_group->id)
                                                                        ->where('dist_code', $dist_code)
                                                                        ->where('subdiv_code', $subdiv_code)
                                                                        ->where('cir_code', $cir_code)                                                        
                                                                        ->where('user_code', $user_code)
                                                                        ->get('patta_code_mapping_cases')
                                                                        ->result();

                if(count((array) $patta_type_cases)){
                    $pattacodes_arr = [];
                    foreach($patta_type_cases as $patta_type_case){
                        array_push($pattacodes_arr, "'" . $patta_type_case->patta_type_code . "'");
                        
                    }
                    $patta_codes = implode(',', $pattacodes_arr);
                    
                    $mapped_land_classes = $this->db->query("select * from patta_code where type_code in (". $patta_codes . ")")->result();

                    $pattacode_group->children = $mapped_land_classes;
                }

                $pattacode_group->fixed_classes = $this->db->query("select * from patta_code where patta_code_group_id = ?", array($pattacode_group->id))->result();
            }
        }
        
        $data['pattacode_groups'] = $pattacode_groups;
        $data['pattacodes'] = $pattacodes;
        $data['patta_code_map_security_code'] = $patta_code_map_security_code;
        $data['is_freezed'] = $check_is_freezed ? 1 : 0;

        $data['_view'] = 'patta_code_group/index';

        $this->load->view('layouts/main',$data);
    }

    public function updateMap(){
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $group_id = $this->input->post('group_id');
        $type_code = $this->input->post('type_code');

        if(in_array($group_id, ['', 'undefined']) || in_array($type_code, ['', 'undefined']) ){
            return response_json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
        }

        $patta_type_map_case = $this->db->where('user_code', $user_code)
                                    ->where('dist_code', $dist_code)
                                    ->where('subdiv_code', $subdiv_code)
                                    ->where('cir_code', $cir_code)   
                                    ->where('patta_type_code', $type_code)
                                    ->get('patta_code_mapping_cases')
                                    ->row();

        $this->db->trans_begin();
        if($patta_type_map_case){
            if($patta_type_map_case->action_taken_at){
                $this->db->trans_rollback();
                return response_json(['success' => false, 'message' => 'You can\'t update as the action has been taken for the land class']);
            }
            if($patta_type_map_case->is_freezed == 1){
                $this->db->trans_rollback();
                return response_json(['success' => false, 'message' => 'You can\'t update as this section has been freezed.']);
            }

            if($group_id != 0){
                $this->db->where('id', $patta_type_map_case->id)->update('patta_code_mapping_cases', ['patta_code_group_id' => $group_id]);
            }else{
                $this->db->where('id', $patta_type_map_case->id)->delete('patta_code_mapping_cases');
            }
        }else{
            if($group_id != 0){
                $data = [
                    'user_desig_code' => $user_desig_code,
                    'user_code' => $user_code,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'patta_code_group_id' => $group_id,
                    'patta_type_code' => $type_code,
                    'is_freezed' => 0,
                ];
                $this->db->insert('patta_code_mapping_cases', $data);
            }else{
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPTTCDEMAP0004 => ' . $this->db->last_query());
        
                    return response_json(['success' => false, 'message' => '#ERRPTTCDEMAP0004: Something went wrong. Please refresh the page and try again later.']);
                }

            }
        }

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            log_message('error', '#ERRPTTCDEMAP0003 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRPTTCDEMAP0003: Something went wrong. Please try again later.']);
        }

        $this->db->trans_commit();

        return response_json(['success' => true, 'message' => 'Patta type mapping has been done successfully.']);
    }

    public function freezeMapping(){
        $code = $this->input->post('code');
        $session_code = $this->session->userdata('patta_code_map_security_code');
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
                                    ->get('patta_code_mapping_cases')
                                    ->row();

        if($check_is_freezed){
            return response_json(['success' => false, 'message' => 'You have already freezed your mapping']);
        }else{
            $this->db->trans_begin();

            $patta_code_count = $this->db->query("select count(type_code) as count from patta_code where patta_code_group_id IS NULL")->row()->count;
            $mapped_class_count = $this->db->query("select count(id) as count from patta_code_mapping_cases where user_code = ?", array($user_code))->row()->count;
            
            if($patta_code_count == $mapped_class_count){
                $data = [
                            'is_freezed' => 1,
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                $this->db->where('user_code', $user_code)
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)   
                            ->update('patta_code_mapping_cases', $data);

                            
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPTTCDEMAP0002 => ' . $this->db->last_query());
                    
                    return response_json(['success' => false, 'message' => '#ERRPTTCDEMAP0002: Something went wrong. Please try again later.']);
                }
                
                $this->db->trans_commit();

                $this->session->unset_userdata('patta_code_map_security_code');

                return response_json(['success' => true, 'message' => 'Your mapping has been freezed successfully.']);
            }else{
                return response_json(['success' => false, 'message' => 'Please map all the land classes before freezing.']);
            }
        }


    }

    // ########## DC Part start from here ########

    protected function dcIndex(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if(IS_PRODUCTION == CLOSE){
            $all_cos = $this->db->where('dist_code', $dist_code)->where('user_desig_code', 'CO')
            ->where_in('user_code', ['CO34'])->get('users')->result_array();
        }else{
            $all_cos = $this->db->where('dist_code', $dist_code)->where('user_desig_code', 'CO')->get('users')->result_array();
        }


        $pattacode_groups = $this->PattaCodeGroupModel->list_array();
        $pattacodes = $this->PattaModel->list();

        $patta_code_map_security_code = $this->patta_code_map_security_code();
        $this->session->set_userdata('patta_code_map_security_code', $patta_code_map_security_code);


        // $landGroupsArr = [];
        if(count($pattacode_groups) > 0){
            foreach($pattacode_groups as $g_key => $pattacode_group){
                if(count($all_cos)){
                    foreach($all_cos as $key => $co_ins){
                        $patta_code_cases = $this->db->where('user_code', $co_ins['user_code'])
                                                            ->where('patta_code_group_id', $pattacode_group['id'])
                                                            ->where('dist_code', $co_ins['dist_code'])
                                                            ->where('subdiv_code', $co_ins['subdiv_code'])
                                                            ->where('cir_code', $co_ins['cir_code'])   
                                                            ->where('is_freezed', 1)
                                                            ->where('action_taken_at IS NULL', null, false)  
                                                            ->get('patta_code_mapping_cases')
                                                            ->result_array();

                        if(count($patta_code_cases)){
                            $ptta_codes_arr = [];
                            foreach($patta_code_cases as $ptta_code_case){
                                array_push($ptta_codes_arr, "'" . $ptta_code_case['patta_type_code'] . "'");
                            }
                            $ptta_codes = implode(',', $ptta_codes_arr);
                            
                            $mapped_land_classes = $this->db->query("select * from patta_code where type_code in (". $ptta_codes . ")")->result_array();
                            
                            $all_cos[$key]['mapped_cases'] = $mapped_land_classes;
                        }else{
                            $all_cos[$key]['mapped_cases'] = [];
                        }
                        
                    }
                    
                }

                $pattacode_groups[$g_key]['co_patta_codes'] = $all_cos;
                $pattacode_groups[$g_key]['fixed_ptta_codes'] = $this->db->query("select * from patta_code where patta_code_group_id = ?", array($pattacode_group['id']))->result_array();
                
            }
        }
        
        $data['co_count'] = count($all_cos);
        $data['pattacode_groups'] = $pattacode_groups;
        $data['pattacodes'] = $pattacodes;
        $data['patta_code_map_security_code'] = $patta_code_map_security_code;

        $data['_view'] = 'patta_code_group/dc-index';

        $this->load->view('layouts/main',$data);
    }

    public function approveMapping(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $code = $this->input->post('code');
        $group_wise_patta_types = $this->input->post('group');
        $session_code = $this->session->userdata('patta_code_map_security_code');

        if(empty($code)){
            return response_json(['success' => false, 'message' => 'Code is required']);
        }elseif($session_code != $code){
            return response_json(['success' => false, 'message' => 'Please enter the correct code']);
        }

        if(empty($group_wise_patta_types) || count($group_wise_patta_types) == 0){
            return response_json(['success' => false, 'message' => 'Please select the classes before submitting']);
        }

        $pattacodes = $this->PattaModel->notMappedList();
        $patta_type_count = 0;
        foreach($group_wise_patta_types as $group_wise_patta_type){
            $patta_type_count += count($group_wise_patta_type);
        }

        if(count((array) $pattacodes) != $patta_type_count){
            return response_json(['success' => false, 'message' => 'Select all the patta types in order to map']);
        }

        $patta_code_adc_mapping = $this->db->where('dist_code', $dist_code)
                                            ->where('status', 'P')
                                            ->get('patta_code_adc_mapping')->row();

        if($patta_code_adc_mapping){
            return response_json(['success' => false, 'message' => 'Mapping has already been done']);
        }

        $this->db->trans_begin();
        $batch_str = uniqid();
        foreach($group_wise_patta_types as $group_id => $group_wise_patta_type){
            foreach($group_wise_patta_type as $type_code){
                // $this->db->where('type_code', $type_code)->update('patta_code', ['patta_code_group_id' => $group_id]);

                $data = [
                            'batch' => $batch_str,
                            'user_code' => $user_code,
                            'dist_code' => $dist_code,
                            'patta_code_group_id' => $group_id,
                            'patta_code' => $type_code,
                            'status' => 'P',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                $this->db->insert('patta_code_adc_mapping', $data);
                // var_dump($this->db->last_query());
                // die;

                $this->db->where('dist_code', $dist_code)
                            ->where('patta_type_code', $type_code)
                            ->update('patta_code_mapping_cases', ['action_taken_at' => date('Y-m-d H:i:s'), 'action_taken_by' => $user_code]);
            }
        }

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            log_message('error', '#ERRPTTCDEMAP0001 => ' . $this->db->last_query());

            return response_json(['success' => false, 'message' => '#ERRPTTCDEMAP0001: Something went wrong. Please try again later.']);
        }

        $this->db->trans_commit();

        return response_json(['success' => true, 'message' => 'Patta types mapped successfully.']);
    }
    

    protected function dcIndexNew(){
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $mapping_cases = $this->db->where('dist_code', $dist_code)
                                    ->where('status', 'P')
                                    ->get('patta_code_adc_mapping')
                                    ->result();
        
        $pattacode_groups = [];
        if(count((array) $mapping_cases) > 0){
            // $landclass_groups = $this->LandClassGroupModel->list_array();
            $pattacode_groups = $this->PattaCodeGroupModel->list_array();
            // dd($pattacode_groups);die;
            $batch = '';
            if(count( $pattacode_groups) > 0){
                foreach($pattacode_groups as $key => $landclass_group){
                    $group_cases = $this->db->where('dist_code', $dist_code)
                                            ->where('patta_code_group_id', $landclass_group['id'])
                                            ->where('status', 'P')
                                            ->get('patta_code_adc_mapping')
                                            ->result_array();
                    
                    if(count($group_cases) > 0){
                        foreach($group_cases as $grp_key => $group_case){
                            $landclass = $this->db->where('type_code', $group_case['patta_code'])->get('patta_code')->row();
                            // var_dump($landclass);die;
                            $group_cases[$grp_key]['patta_type'] = $landclass->patta_type;
                            $group_cases[$grp_key]['patta_code'] = $landclass->type_code;
                            $group_cases[$grp_key]['patta_code_eng_name'] = $landclass->pattatype_eng;
    
                            if(empty($batch)){
                                $batch = $group_case['batch'];
                            }
                        }
                    }
    
                    $pattacode_groups[$key]['land_classes'] = $group_cases;
                }
            }
        }

        // dd($landclass_groups);

        $land_cls_map_security_code = $this->patta_code_map_security_code();
        $this->session->set_userdata('land_cls_map_security_code', $land_cls_map_security_code);
        
        $data['batch'] = $batch;
        $data['pattacode_groups'] = $pattacode_groups;
        $data['land_cls_map_security_code'] = $land_cls_map_security_code;
        
        $data['_view'] = 'patta_code_group/dc-index-new';

        $this->load->view('layouts/main',$data);
    }

    public function finalApprove(){
       

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
//  dd("ok");
        if(empty($batch)){
            return response_json(['success' => false, 'message' => 'Something went wrong. Please refresh and try again']);
        }

        $mapping_cases = $this->db->where('batch', $batch)
                                    ->where('status', 'P')
                                    ->get('patta_code_adc_mapping')
                                    ->result();
    
        if(count((array) $mapping_cases) == 0){
            return response_json(['success' => false, 'message' => 'No case found']);
        }

        $this->db->trans_begin();
        foreach($mapping_cases as $mapping_case){
            // dd($mapping_case);
            // $this->db->where('class_code', $mapping_case->land_class_code)->update('landclass_code', ['land_class_group_id' => $mapping_case->land_class_group_id]);
            $this->db->where('type_code', $mapping_case->patta_code)->update('patta_code', ['patta_code_group_id' => $mapping_case->patta_code_group_id]);
        }

        $mapcase_count = count((array) $mapping_cases);
        $this->db->where('batch', $batch)->update('patta_code_adc_mapping', ['status' => 'A', 'updated_at' => date('Y-m-d H:i:s')]);

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

    private function patta_code_map_security_code(){
        return rand(10000, 999999);
    }
        
    
}
