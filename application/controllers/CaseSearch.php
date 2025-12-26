<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CaseSearch extends CI_Controller {
    public function __construct() {
        parent::__construct();
        //$this->dbswitch();
    }
     public function dbswitch(){       
         //$CI=&get_instance();
         if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);    
         } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);    
          } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);       
         } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);    
         }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);    
         }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);    
         }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);    
         }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);    
         }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);    
         }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);    
         }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);   
         }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);   
         }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);   
         }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);   
         }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);   
         }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);   
         }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);   
         }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);   
         }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);   
         }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);   
         }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);   
         }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);   
         }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
         }                                                                                                                                                                                                            
}
    public function index() {
          $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($this->input->post());
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            $category = $this->input->post('category');
            $search = $this->input->post('search');
            $type = $this->input->post('casetype');
            $data['fieldoffice'] = $type;
            switch ($category) {
                case '0':
                    $data['results'] = $this->nameSearch($search, $type);
                    //$this->load->view('../views/search/results_with_name', $data);
                    $data['_view'] = 'search/results_with_name';
                    break;
                case '1':
                    $data['results'] = $this->caseNoSearch($search, $type);
                    $data['_view'] = 'search/results';
                    //$this->load->view('../views/search/results', $data);
                    break;
                case '2':
                    $data['results'] = $this->caseNRSearch($search, $type);
                    $data['_view'] = 'search/results';
                    break;
                case '3':
                    $data['results'] = $this->caseMiscSearch($search, $type);
                    //var_dump($data);
                    $data['_view'] = 'search/results';
                    break;
            }
            ///////var_dump($data);
            // $this->load->view('../views/common/bar');
            // $this->load->view('../views/footer');
            //$data['_view'] = 'common/bar';
            $this->load->view('layouts/main',$data);
        } else {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/search/cases');
            // $this->load->view('../views/footer');
            $data['_view'] = 'search/cases';
            $this->load->view('layouts/main',$data);
        }
    }

    function caseMiscSearch($s, $t) {
          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from    misc_case_basic where misc_case_no='$s' ";
        $nr = $this->db->query($q)->row();
        $get_pattadars = "select petition_pdar_name_old as pet_name from    misc_case_first_party where misc_case_no='$s' ";
        $get_pattadars = $this->db->query($get_pattadars)->row();
        if (($nr->lm_note_yn == null) and ($nr->status=='18')) {
            $status = "<label class='label label-info'>PENDING WITH LM</label>";
        } else if (($nr->sk_note_yn == null) and ( $nr->status=='02')) {
            $status = "<label class='label label-info'>PENDING WITH SK</label>";
        } else if (($nr->status == '18') and ($nr->notice_generated_yn==null)) {
            $status = "<label class='label label-success'>Pending with AST for Notice Generation</label>";
        } else if (($nr->status == '1')) {
            $status = "<label class='label label-danger'>Pending with CO</label>";
        }
        else if (($nr->status == '02') and ($nr->sk_note_yn!=null)) {
            $status = "<label class='label label-danger'>Pending with CO</label>";
        }

        else if ($nr->status == '10') {
            $status = "<label class='label label-danger'>Case has been Passed</label>";
        }
        else if ($nr->status == 'L') {

            $status = "<label class='label label-danger'>Case has been Reverted back to LM</label>";
        }
        $remark = "NA";
        $data[] = array(
            'case_no' => $nr->misc_case_no,
            'patta_name' => $get_pattadars,
            'date_registered' => $nr->submission_date,
            'current_status' => $status,
            'remarks' => $remark,
        );
        //var_dump($data);
        return $data;
    }

    function caseNRSearch($s, $t) {
          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from    apcancel_petition_basic where case_no='$s' ";
        $nr = $this->db->query($q)->row();
        $get_pattadars = "select pdar_name as pet_name from    apcancel_petition_pattadar where case_no='$s' ";
        $get_pattadars = $this->db->query($get_pattadars)->result();
        if ($nr->lm_note_yn == null) {
            $status = "<label class='label label-info'>PENDING WITH LM</label>";
        } else if ($nr->sk_note_yn == null) {
            $status = "<label class='label label-info'>PENDING WITH SK</label>";
        } else if (($nr->dc_approval_yn == null)) {
            $status = "<label class='label label-success'>Pending with DC/ADC</label>";
        } else if (($nr->co_chitha_corrected_yn == null) and ( $nr->dc_approval_yn != null)) {
            $status = "<label class='label label-danger'>Pending with CO</label>";
        }
        else if ($nr->order_passed == 'Y') {
            $status = "<label class='label label-danger'>Case has been Passed</label>";
        }
        $remark = "NA";
        $data[] = array(
            'case_no' => $nr->case_no,
            'patta_name' => $get_pattadars,
            'date_registered' => $nr->submission_date,
            'current_status' => $status,
            'remarks' => $remark,
        );
        return $data;
    }

    public function caseNoSearch($s, $t) {
          $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        switch ($t) {
            case 1: // Field Mutation
                $fieldmutation = "select * from    field_mut_basic where case_no = '$s' and mut_type='01' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $fieldmutation = $this->db->query($fieldmutation)->result();
                $data = array();

                foreach ($fieldmutation as $fmute) {
                    $get_pattadars = "select pet_name as pet_name from    field_mut_petitioner where dist_code = '$fmute->dist_code' and subdiv_code = '$fmute->subdiv_code' and "
                            . "cir_code = '$fmute->cir_code' and mouza_pargona_code = '$fmute->mouza_pargona_code' and "
                            . "lot_no = '$fmute->lot_no' and petition_no = '$fmute->petition_no'";
                    $get_pattadars = $this->db->query($get_pattadars)->result();


                    if(($fmute->order_passed==null) and  ($fmute->is_dispose == null))
                    {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                        $remark = "NA";
                    }
    
                    else if (($fmute->order_passed != null) && ($fmute->is_dispose == null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    }  
                    else if ($fmute->is_dispose == 'Y') {
                        $status = "<label class='label label-danger'>REJECTED</label>";
                        $remark = $fmute->dispose_reason;
                    }

                    else if ($fmute->is_dispose == 'L') {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                        $remark = "<label class='label label-info'>Reverted back to LM</label>";
                    }
                     else if ($fmute->is_dispose =='S') {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                        $remark = "<label class='label label-info'>Reverted back to SK</label>";
                    } 
                    else {
                        $remark = "NA";
                    }


                    $data[] = array(
                        'case_no' => $fmute->case_no,
                        'patta_name' => $get_pattadars,
                        'date_registered' => $fmute->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 2: // Field Partition
                $fieldpartition = "select * from    field_mut_basic where case_no = '$s' and mut_type='02' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $fieldpartition = $this->db->query($fieldpartition)->result();
                $data = array();
                foreach ($fieldpartition as $fpart) {
                    $get_pattadars = "select pet_name as pet_name from    field_mut_petitioner where dist_code = '$fpart->dist_code' and subdiv_code = '$fpart->subdiv_code' and "
                            . "cir_code = '$fpart->cir_code' and mouza_pargona_code = '$fpart->mouza_pargona_code' and "
                            . "lot_no = '$fpart->lot_no' and petition_no = '$fpart->petition_no'";
                    $get_pattadars = $this->db->query($get_pattadars)->result();
                    if(($fpart->order_passed==null) and  ($fpart->is_dispose == null))
                    {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                        $remark = "NA";
                    }
    
                    else if (($fpart->order_passed != null) && ($fpart->is_dispose == null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    }  
                    else if ($fpart->is_dispose == 'Y') {
                        $status = "<label class='label label-danger'>REJCTED</label>";
                        $remark = $fpart->dispose_reason;
                    }

                    else if ($fpart->is_dispose == 'L') {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                        $remark = "<label class='label label-info'>Reverted back to LM</label>";
                    }
                     else if ($fpart->is_dispose =='S') {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                        $remark = "<label class='label label-info'>Reverted back to SK</label>";
                    } 
                    else {
                        $remark = "NA";
                    }




                    $data[] = array(
                        'case_no' => $fpart->case_no,
                        'patta_name' => $get_pattadars,
                        'date_registered' => $fpart->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 3: // office mutation
                $officemutation = "select * from    petition_basic where case_no = '$s' and mut_type='03' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $officemutation = $this->db->query($officemutation)->result();
                $data = array();
                foreach ($officemutation as $omut) {
                    $get_pattadars = "select pet_name as pet_name from    petitioner where dist_code = '$omut->dist_code' and subdiv_code = '$omut->subdiv_code' and "
                            . "cir_code = '$omut->cir_code' and mouza_pargona_code = '$omut->mouza_pargona_code' and "
                            . "lot_no = '$omut->lot_no' and petition_no = '$omut->petition_no'";
                    $get_pattadars = $this->db->query($get_pattadars)->result();

                    if (($omut->order_passed != null) && ($omut->status != 'F')) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if (($omut->lm_note_yn == null) && ($omut->not_fresh !=null)) {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                    } else if (($omut->notice_generated_yn == null) && ($omut->not_fresh != null)) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE GENERATION</label>";
                    } else if (($omut->notice_generated_yn == null) && ($omut->not_fresh != null)) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE SERVE</label>";
                    } else if (($omut->sk_comment == null) && ($omut->not_fresh != null)) {
                        $status = "<label class='label label-info'>PENDING WITH SK for REPORT</label>";
                    } 

                    else if (($omut->not_fresh == null) && ($omut->status == null)) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } 
                    else if (($omut->order_passed == null) && ($omut->status != 'F') && ($omut->proceeding_yn!=null)) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } 
                    else if ($omut->status == 'F') {
                        $status = "<label class='label label-danger'>Final Order Passed</label>";
                    }
                    else if ($omut->status == 'D') {
                        $status = "<label class='label label-danger'>Case Rejected</label>";
                    }

                    

                    else if (($omut->proceeding_yn == null) and ($omut->notice_served_yn != null)) {
                        $status = "<label class='label label-danger'>PENDING WITH AST for NOTICE SERVE</label>";
                    }


                    else {
                        $status = "<label class='label label-danger'>UNKOWN</label>";
                    }
                    $remark = "NA";

                    $data[] = array(
                        'case_no' => $omut->case_no,
                        'patta_name' => $get_pattadars,
                        'date_registered' => $omut->submission_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 4: // office partition
                $officepartition = "select * from    petition_basic where case_no = '$s' and mut_type='04' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $officepartition = $this->db->query($officepartition)->result();
                $data = array();
                foreach ($officepartition as $opart) {
                    $get_pattadars = "select pdar_name as pet_name from    petitioner_part where dist_code = '$opart->dist_code' and subdiv_code = '$opart->subdiv_code' and "
                            . "cir_code = '$opart->cir_code' and mouza_pargona_code = '$opart->mouza_pargona_code' and "
                            . "lot_no = '$opart->lot_no' and petition_no = '$opart->petition_no'";
                    $get_pattadars = $this->db->query($get_pattadars)->result();

                    if (($opart->order_passed != null) && ($opart->status != 'F')) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if (($opart->lm_note_yn == null) && ($opart->not_fresh!=null)) {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                    } else if (($opart->byayprak_yn == null) && ($opart->not_fresh!=null)) {
                        $status = "<label class='label label-info'>PENDING WITH LM for Byayprak Report</label>";
                    } else if (($opart->notice_generated_yn == null) && ($opart->not_fresh!=null)) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE GENERATION</label>";
                    } else if (($opart->notice_generated_yn == null) && ($opart->not_fresh!=null)) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE SERVE</label>";
                    } else if (($opart->sk_comment == null) && ($opart->not_fresh!=null)) {
                        $status = "<label class='label label-info'>PENDING WITH SK for REPORT</label>";
                    } else if (($opart->order_passed == null) && ($opart->not_fresh==null)) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } 
                    else if (($opart->order_passed == null) && ($opart->status != 'F') && ($opart->proceeding_yn!=null)
                     && ($opart->pay_notice_gen_yn != null) ) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } 
                    else if (($opart->not_fresh == 'Y') && ($opart->proceeding_yn==null) && ($opart->status == 'P')) {
                        $status = "<label class='label label-info'>PENDING WITH AST for Action taken report</label>";
                    } 
                     else if (($opart->not_fresh == 'Y') && ($opart->proceeding_yn==null) && ($opart->status == 'P') && ($opart->pay_notice_gen_yn == 'Y')) {
                        $status = "<label class='label label-info'>PENDING WITH AST for Payment Confirmation</label>";
                    } 
                    else if ($opart->status == 'F') {
                        $status = "<label class='label label-danger'>Final Order Passed</label>";
                    }
                    else if ($opart->status == 'D') {
                        $status = "<label class='label label-danger'>Case Rejected</label>";
                    }

                    else {
                        $status = "<label class='label label-danger'>UNKOWN</label>";
                    }
                    $remark = "NA";

                    $data[] = array(
                        'case_no' => $opart->case_no,
                        'patta_name' => $get_pattadars,
                        'date_registered' => $opart->submission_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 5://conversion
                $conversion = "select * from    petition_basic where case_no = '$s' and mut_type='01' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $conversion = $this->db->query($conversion)->result();
                $data = array();
                //var_dump($conversion);
                foreach ($conversion as $conv) {
                    $get_pattadars = "select pdar_name as pet_name from    petitioner_part where dist_code = '$conv->dist_code' and subdiv_code = '$conv->subdiv_code' and "
                            . "cir_code = '$conv->cir_code' and mouza_pargona_code = '$conv->mouza_pargona_code' and "
                            . "lot_no = '$conv->lot_no' and petition_no = '$conv->petition_no'";
                    $get_pattadars = $this->db->query($get_pattadars)->result();


                    if (($conv->not_fresh == null)) {
                        $status = "<label class='label label-success'>PENDING WITH CO</label>";
                    }
                    if (($conv->lm_note_yn == null)) {
                        $status = "<label class='label label-success'>PENDING WITH LM</label>";
                    } else if (($conv->not_fresh == 'Y') && ($conv->status == 'P')) {
                        $status = "<label class='label label-success'>PENDING WITH CO</label>";
                    } else if (($conv->not_fresh == 'Y') && ($conv->status == 'R')) {
                        $status = "<label class='label label-success'>REJECTED BY CO</label>";
                    } else if (($conv->not_fresh == 'Y') && ($conv->status == 'W')) {
                        $status = "<label class='label label-success'>PENDING FOR CHITHA UPDATION</label>";
                    } else if (($conv->order_passed == null) && ($conv->not_fresh == 'Y') && ($conv->lm_note_date == null) && ($conv->sk_comment == null)) {
                        $status = "<label class='label label-success'>PENDING WITH LM</label>";
                    } else if (($conv->order_passed == null) && ($conv->not_fresh == 'Y') && ($conv->lm_note_date != null) && ($conv->sk_comment == null)) {
                        $status = "<label class='label label-success'>PENDING WITH SK</label>";
                    } else if (($conv->not_fresh == 'Y') && ($conv->notice_generated_yn == null)) {
                        $status = "<label class='label label-success'>PENDING WITH AST</label>";
                    } else if (($conv->not_fresh == 'Y')) { // && ($conv->proceeding_yn == null)
                        $status = "<label class='label label-success'>PENDING WITH AST</label>";
                    } else if (($conv->not_fresh == 'Y') && ($conv->co_order_conv_premium == 'Y')) {
                        $status = "<label class='label label-success'>PENDING WITH AST</label>";
                    } else if (($conv->not_fresh == 'Y') && ($conv->bo_note_yn == 'Y')) {
                        $status = "<label class='label label-success'>PENDING WITH BO</label>";
                    } else if ($conv->status == 'F') {
                        $status = "<label class='label label-success'>FINAL ORDER PASSED</label>";
                    } else if ($conv->status == 'D') {
                        $status = "<label class='label label-success'>CASE DISPOSED</label>";
                    } else {
                        $status = "<label class='label label-danger'>UNKOWN</label>";
                    }

                    /*
                      if (($conv->order_passed != null) && ($conv->status != 'F')) {
                      $status = "<label class='label label-success'>ORDER PASSED</label>";
                      } else if (($conv->lm_note_yn == null) && ($conv->status == 'P')) {
                      $status = "<label class='label label-info'>PENDING WITH LM</label>";
                      } else if (($conv->notice_generated_yn == null) && ($conv->status != 'F')) {
                      $status = "<label class='label label-info'>PENDING WITH AST for NOTICE GENERATION</label>";
                      } else if (($conv->notice_served_yn == null) && ($conv->status != 'F')) {
                      $status = "<label class='label label-info'>PENDING WITH AST for NOTICE SERVE</label>";
                      } else if (($conv->sk_comment == null) && ($conv->status != 'F')) {
                      $status = "<label class='label label-info'>PENDING WITH SK for REPORT</label>";
                      } else if (($conv->sk_note == null) && ($conv->status != 'F')) {
                      $status = "<label class='label label-info'>PENDING WITH SK</label>";
                      } else if (($conv->order_passed == null) && ($conv->status != 'F')) {
                      $status = "<label class='label label-info'>PENDING WITH CO</label>";
                      } else {
                      $status = "<label class='label label-danger'>UNKOWN</label>";
                      }
                      if ($conv->status == '') {
                      $status = "<label class='label label-danger'>CONTACT HELP DESK</label>";
                      }
                      if ($conv->status == 'F') {
                      $status = "<label class='label label-danger'>Final Order Passed</label>";
                      }
                      if ($conv->status == 'D') {
                      $status = "<label class='label label-danger'>Case Rejected</label>";
                      } */
                    $remark = "NA";

                    $data[] = array(
                        'case_no' => $conv->case_no,
                        'patta_name' => $get_pattadars,
                        'date_registered' => $conv->submission_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 6://reclass
                $reclassification = "select * from    t_reclassification where case_no = '$s' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $reclassification = $this->db->query($reclassification)->row();
                if ($reclassification->co_yn == ' ' or $reclassification->co_yn == null) {
                    $status_R = 'Pending with CO';
                } if ($reclassification->dc_yn == '' or $reclassification->dc_yn == null) {
                    $status_R = 'Pending with DC';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                } 
                
                if ($reclassification->status == 'R') {
                    $status_R = 'Case Has Been Rejected';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }

                if ($reclassification->co_yn == null) {
                    $status_R = 'Pending with CO';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }

                 if ($reclassification->status == 'M') {
                    $status_R = 'Reverted back to LM';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }

                if ($reclassification->status == 'A') {
                    $status_R = 'pending with ADC';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }
                 if ($reclassification->status == 'C') {
                    $status_R = 'Pending with CO';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }

                if ($reclassification->status == 'D') {
                    $status_R = 'Pending with DC';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }

                if ($reclassification->rkg_chitha_updated_yn !=null) {
                    $status_R = 'Case has been passed';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }


                
                $result = array(
                    'case_no' => $reclassification->case_no,
                    'patta_name' => 'NA',
                    'date_registered' => $reclassification->lm_date,
                    'current_status' => $status_R,
                    'remarks' => 'NA',
                );

                break;
            case 7://app cancellation 
                $query = "select * from    field_mut_petitioner where pet_name like '%$s%'";
                break;
            case 8://Citizen
                $query = "select * from    cert_application where cert_no='$s' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'";
                $r = $this->db->query($query)->row();
                $status = $r->status;
                if ($status == 'M') {
                    $status_R = 'Pending with LM';
                    //  echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                } elseif ($status == 'C') {
                    $status_R = 'Pending with CO';
                    // echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                } elseif ($status == 'R') {
                    $status_R = 'Certificate is Ready';
                    //echo "<button type=\"button\" class=\"btn btn-warning\">$status</button>";
                } elseif ($status == 'D') {
                    $status_R = 'Certificate Delivered';
                    //  echo "<button type=\"button\" class=\"btn btn-success\">$status</button>";
                }
                $result = array(
                    'case_no' => $r->cert_no,
                    'patta_name' => $r->appln_name,
                    'date_registered' => $r->apply_date,
                    'current_status' => $status_R,
                    'remarks' => 'NA',
                );
                //var_dump($result);
                break;
        }
        return $result;
    }

    public function nameSearch($s, $t) {
          $db=  $this->session->userdata('db');
        switch ($t) {
            case 1: // Field Mutation with name search
                $fieldmutation = "select * from    field_mut_petitioner where pet_name like '%$s%'";
                $fieldmutation = $this->db->query($fieldmutation)->result();

                foreach ($fieldmutation as $fmute) {
                    $get_basic = "select * from    field_mut_basic where dist_code = '$fmute->dist_code' and subdiv_code = '$fmute->subdiv_code' and "
                            . "cir_code = '$fmute->cir_code' and mouza_pargona_code = '$fmute->mouza_pargona_code' and "
                            . "lot_no = '$fmute->lot_no' and petition_no = '$fmute->petition_no' and case_no = '$fmute->case_no'";
                    $get_basic = $this->db->query($get_basic)->row();
                    if ($get_basic->sk_note == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                    } else if ($get_basic->order_passed == null) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } else if (($get_basic->order_passed != null) && ($get_basic->is_dispose == null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if ($get_basic->is_dispose != null) {
                        $status = "<label class='label label-danger'>REJCTED</label>";
                    }

                    if ($get_basic->is_dispose != null) {
                        $remark = $get_basic->dispose_reason;
                    } else {
                        $remark = "NA";
                    }

                    $data[] = array(
                        'case_no' => $get_basic->case_no,
                        'patta_name' => $fmute->pet_name,
                        'date_registered' => $get_basic->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 2: // Field Partition with name search
                $fieldpartition = "select * from    field_mut_petitioner where pet_name like '%$s%'";
                $fieldpartition = $this->db->query($fieldpartition)->result();

                foreach ($fieldpartition as $fpart) {
                    $get_basic = "select * from    field_mut_basic where dist_code = '$fpart->dist_code' and subdiv_code = '$fpart->subdiv_code' and "
                            . "cir_code = '$fpart->cir_code' and mouza_pargona_code = '$fpart->mouza_pargona_code' and "
                            . "lot_no = '$fpart->lot_no' and petition_no = '$fpart->petition_no' and case_no = '$fpart->case_no'";
                    $get_basic = $this->db->query($get_basic)->row();
                    if ($get_basic->sk_note == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                    } else if ($get_basic->order_passed == null) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } else if (($get_basic->order_passed != null) && ($get_basic->is_dispose == null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if ($get_basic->is_dispose != null) {
                        $status = "<label class='label label-danger'>REJCTED</label>";
                    }

                    if ($get_basic->is_dispose != null) {
                        $remark = $get_basic->dispose_reason;
                    } else {
                        $remark = "NA";
                    }

                    $data[] = array(
                        'case_no' => $get_basic->case_no,
                        'patta_name' => $fpart->pet_name,
                        'date_registered' => $get_basic->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 3: // office mutation with name search
                $officemutation = "select * from    petitioner_part where pdar_name like '%$s%'";
                $officemutation = $this->db->query($officemutation)->result();

                foreach ($officemutation as $omut) {
                    $get_basic = "select * from    petition_basic where dist_code = '$omut->dist_code' and subdiv_code = '$omut->subdiv_code' and "
                            . "cir_code = '$omut->cir_code' and mouza_pargona_code = '$omut->mouza_pargona_code' and "
                            . "lot_no = '$omut->lot_no' and petition_no = '$omut->petition_no'";
                    $get_basic = $this->db->query($get_basic)->row();

                    if (($get_basic->order_passed != null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if ($get_basic->lm_note_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                    } else if ($get_basic->notice_generated_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE GENERATION</label>";
                    } else if ($get_basic->notice_served_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE SERVE</label>";
                    } else if ($get_basic->sk_comment == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK for REPORT</label>";
                    } else if ($get_basic->sk_note == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                    } else if ($get_basic->order_passed == null) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } else {
                        $status = "<label class='label label-danger'>UNKOWN</label>";
                    }

                    $remark = "NA";

                    $data[] = array(
                        'case_no' => $get_basic->case_no,
                        'patta_name' => $omut->pet_name,
                        'date_registered' => $get_basic->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 4: // office partition with name search
                $officepartition = "select * from    petitioner_part where pdar_name like '%$s%'";
                $officepartition = $this->db->query($officepartition)->result();

                foreach ($officepartition as $oprt) {
                    $get_basic = "select * from    petition_basic where dist_code = '$oprt->dist_code' and subdiv_code = '$oprt->subdiv_code' and "
                            . "cir_code = '$oprt->cir_code' and mouza_pargona_code = '$oprt->mouza_pargona_code' and "
                            . "lot_no = '$oprt->lot_no' and petition_no = '$oprt->petition_no'";
                    $get_basic = $this->db->query($get_basic)->row();

                    if (($get_basic->order_passed != null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if ($get_basic->lm_note_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                    } else if ($get_basic->byayprak_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for Byayprak Report</label>";
                    } else if ($get_basic->notice_generated_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE GENERATION</label>";
                    } else if ($get_basic->notice_served_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE SERVE</label>";
                    } else if ($get_basic->sk_comment == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK for REPORT</label>";
                    } else if ($get_basic->sk_note == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                    } else if ($get_basic->order_passed == null) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } else {
                        $status = "<label class='label label-danger'>UNKOWN</label>";
                    }

                    $remark = "NA";

                    $data[] = array(
                        'case_no' => $get_basic->case_no,
                        'patta_name' => $oprt->pet_name,
                        'date_registered' => $get_basic->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 5: // conversion with name search
                $officeconversion = "select * from    petitioner_part where pdar_name like '%$s%'";
                $officeconversion = $this->db->query($officeconversion)->result();

                foreach ($officeconversion as $conv) {
                    $get_basic = "select * from    petition_basic where dist_code = '$conv->dist_code' and subdiv_code = '$conv->subdiv_code' and "
                            . "cir_code = '$conv->cir_code' and mouza_pargona_code = '$conv->mouza_pargona_code' and "
                            . "lot_no = '$conv->lot_no' and petition_no = '$conv->petition_no'";
                    $get_basic = $this->db->query($get_basic)->row();

                    if (($get_basic->order_passed != null)) {
                        $status = "<label class='label label-success'>ORDER PASSED</label>";
                    } else if ($get_basic->lm_note_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH LM</label>";
                    } else if ($get_basic->notice_generated_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE GENERATION</label>";
                    } else if ($get_basic->notice_served_yn == null) {
                        $status = "<label class='label label-info'>PENDING WITH AST for NOTICE SERVE</label>";
                    } else if ($get_basic->sk_comment == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK for REPORT</label>";
                    } else if ($get_basic->sk_note == null) {
                        $status = "<label class='label label-info'>PENDING WITH SK</label>";
                    } else if ($get_basic->order_passed == null) {
                        $status = "<label class='label label-info'>PENDING WITH CO</label>";
                    } else {
                        $status = "<label class='label label-danger'>UNKOWN</label>";
                    }

                    $remark = "NA";

                    $data[] = array(
                        'case_no' => $get_basic->case_no,
                        'patta_name' => $conv->pet_name,
                        'date_registered' => $get_basic->report_date,
                        'current_status' => $status,
                        'remarks' => $remark,
                    );
                }
                $result = $data;
                break;
            case 6://reclass
                $query = "select * from    field_mut_petitioner where pet_name like '%$s%'";
                break;
            case 7://app cancellation 
                $query = "select * from    field_mut_petitioner where pet_name like '%$s%'";
                break;
            case 8:
                $query = "select * from    field_mut_petitioner where pet_name like '%$s%'";
                break;
        }



        return $result;
    }
    ///////////////////////////
   function loginHistory()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        if($this->session->userdata('user_desig_code') == "DC" || $this->session->userdata('user_desig_code') == "ADC" || $this->session->userdata('user_desig_code') == "BO")
        {
            $users=$this->session->userdata('user_code');
            $sql="Select * from login_history_table where client_ip not like '10.177.15.%' 
            and client_ip not like '10.177.0.%' and dist_code=? and user_code=? and status=? order by date_of_creation DESC  limit 50";

            $data['history'] = $this->db->query($sql,
                array($dist_code,$users,'1'))->result_array();
        }

        else if($this->session->userdata('user_desig_code') == "CO" || $this->session->userdata('user_desig_code') == "AST"|| $this->session->userdata('user_desig_code') == "SK")
        {
            $users=$this->session->userdata('user_code');
            $sql="Select * from login_history_table where client_ip not like '10.177.15.%' 
            and client_ip not like '10.177.0.%' and dist_code=? and subdiv_code=? 
            and cir_code=? and user_code=? and status=? order by date_of_creation DESC  limit 50";

            $data['history'] = $this->db->query($sql,
                array($dist_code,$subdiv_code,$cir_code,$users,'1'))->result_array();
        }
        else if($this->session->userdata('user_desig_code') == "LM")
        {
            $users=$this->session->userdata('user_code');
            $sql="Select * from login_history_table where client_ip not like '10.177.15.%' 
            and client_ip not like '10.177.0.%' and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=? and user_code=? and status=? order by date_of_creation DESC  limit 50";

            $data['history'] = $this->db->query($sql,
                array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$users,'1'))->result_array();
        }

        $data['_view'] = 'search/loginHistory';
        $this->load->view('layouts/main', $data);
    }

}
