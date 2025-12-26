<?php

class CentralDiary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->library('form_validation');
        $this->dbswitch();
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
		  // $db=  $this->session->userdata('db');
    //     $this->load->helper('html');
    //     $this->load->view('../views/header');
    //     $this->load->view('../views/diary/index');
    //     $this->load->view('../views/footer');

        $data['_view'] = 'diary/index';
        $this->load->view('layouts/main',$data);
    }

    public function casediaryR() {
		  $db=  $this->session->userdata('db');
        $data = array();
        
        //        end field
        $dist_code = $this->session->userdata('dist_code');
        
        $sdate = $this->input->post('sdate');
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = $this->input->post('edate');
        $edate = date('Y-m-d', strtotime($edate));
        $locationData = array(
            'sdate' => $sdate,
            'edate' => $edate
        );
        $this->session->set_userdata($locationData);
        //        end field
        $dist_code=$this->session->userdata('dist_code');
       // $subdiv_code=$this->session->userdata('subdiv_code');
       // $cir_code=$this->session->userdata('cir_code');
       $q="SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code!='00' and cir_code != '00' and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code = '00000'";
        //echo $q;
        $data['loc']=$values=$this->db->query($q)->result();
        //var_dump($values);
        foreach($values as $v)
        {
        $regOpart = 0;        $disOpart = 0;        $penOpart = 0;        $regOmut = 0;        $disOmut = 0;        $penOmut = 0;
        $regOcon = 0;        $disOcon = 0;        $penOcon = 0;        $deliverOpart = 0;        $deliverOmut = 0;        $deliverOcon = 0;
        $regOpart1 = 0;        $disOpart1 = 0;        $penOpart1 = 0;        $regOmut1 = 0;        $disOmut1 = 0;        $penOmut1 = 0;
        $regOcon1 = 0;        $disOcon1 = 0;        $penOcon1 = 0;        $deliverOpart1 = 0;        $deliverOcon1 = 0;        $deliverOmut1 = 0;
        //        end office
        $regFpart = 0;        $disFpart = 0;        $penFpart = 0;        $deliverFpart = 0;        $regFmut = 0;        $disFmut = 0;
        $penFmut = 0;        $deliverFmut = 0;        $regFpart1 = 0;        $disFpart1 = 0;        $penFpart1 = 0;        $deliverFpart1 = 0;
        $regFmut1 = 0;        $disFmut1 = 0;        $penFmut1 = 0;        $deliverFmut1 = 0;
        
        
        $q = "select * from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and submission_date>='$sdate' and submission_date<='$edate' and (submission_date is not null)";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            //            partition cases
            if ($d->mut_type == '04') {
                $regOpart = $regOpart + 1;
                if (($d->status == 'P') or ( $d->status == null)) {
                    $penOpart = $penOpart + 1;
                } elseif ($d->status == 'D' or $d->status == 'd') {
                    $disOpart = $disOpart + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOpart = $deliverOpart + 1;
                }
            }
            //            end here
            if ($d->mut_type == '03') {
                $regOmut = $regOmut + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOmut = $penOmut + 1;
                }
                if ($d->status == 'D' or $d->status == 'd') {
                    $disOmut = $disOmut + 1;
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    $deliverOmut = $deliverOmut + 1;
                }
            }
            //            mutation end here
            if ($d->mut_type == '01') {
                $regOcon = $regOcon + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOcon = $penOcon + 1;
                }
                if ($d->status == 'D' or $d->status == 'd') {
                    $disOcon = $disOcon + 1;
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    $deliverOcon = $deliverOcon + 1;
                }
            }
            //            conversion end here
        }

        //        without range
        $q = "select * from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' ";
        $data['pbb'] = $pbb = $this->db->query($q)->result();
        foreach ($pbb as $d) {
            //            partition cases
            if ($d->mut_type == '04') {
                $regOpart1 = $regOpart1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOpart1 = $penOpart1 + 1;
                } elseif ($d->status == 'D') {
                    $disOpart1 = $disOpart1 + 1;
                } elseif ($d->status == 'F') {
                    $deliverOpart1 = $deliverOpart1 + 1;
                }
            }
            //            end here
            if ($d->mut_type == '03') {
                $regOmut1 = $regOmut1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOmut1 = $penOmut1 + 1;
                } elseif ($d->status == 'D') {
                    $disOmut1 = $disOmut1 + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOmut1 = $deliverOmut1 + 1;
                }
            }
            //            mutation end here
            if ($d->mut_type == '01') {
                $regOcon1 = $regOcon1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOcon1 = $penOcon1 + 1;
                } elseif ($d->status == 'D' or $d->status == 'd') {
                    $disOcon1 = $disOcon1 + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOcon1 = $deliverOcon1 + 1;
                }
            }
            //            conversion end here
        }


        $data['officepart'][] = array('regopart' => $regOpart, 'penopart' => $penOpart, 'disopart' => $disOpart, 'deliverpart' => $deliverOpart);
        $data['officemut'][] = array('regomut' => $regOmut, 'penomut' => $penOmut, 'disomut' => $disOmut, 'delivermut' => $deliverOmut);
        $data['officecon'][] = array('regocon' => $regOcon, 'penocon' => $penOcon, 'disocon' => $disOcon, 'delivercon' => $deliverOcon);

        $data['officepart1'][] = array('regopart1' => $regOpart1, 'penopart1' => $penOpart1, 'disopart1' => $disOpart1, 'deliverpart1' => $deliverOpart1);
        $data['officemut1'][] = array('regomut1' => $regOmut1, 'penomut1' => $penOmut1, 'disomut1' => $disOmut1, 'delivermut1' => $deliverOmut1);
        $data['officecon1'][] = array('regocon1' => $regOcon1, 'penocon1' => $penOcon1, 'disocon1' => $disOcon1, 'delivercon1' => $deliverOcon1);
        // var_dump($data);
        // field start
        $q = "select * from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' ";
        $Fb = $this->db->query($q)->result();
        foreach ($Fb as $d) {
            if ($d->mut_type == '01') {
                $regFmut1 = $regFmut1 + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFmut1 = $penFmut1 + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFmut1 = $disFmut1 + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFmut1 = $deliverFmut1 + 1;
                }
            }
            if ($d->mut_type == '02') {
                $regFpart1 = $regFpart1 + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFpart1 = $penFpart1 + 1;
                }

                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFpart1 = $disFpart1 + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFpart1 = $deliverFpart1 + 1;
                }
            }
        }
        $q = "select * from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and Report_date >='$sdate' and Report_date <='$edate' and (Report_date is not null)";
        //echo $q;
        $Fb = $this->db->query($q)->result();
        foreach ($Fb as $d) {
            if ($d->mut_type == '01') {
                $regFmut = $regFmut + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFmut = $penFmut + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFmut = $disFmut + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFmut = $deliverFmut + 1;
                }
            }
            if ($d->mut_type == '02') {
                $regFpart = $regFpart + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFpart = $penFpart + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFpart = $disFpart + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFpart = $deliverFpart + 1;
                }
            }
        }
        $data['fieldpart1'][] = array('regopart1' => $regFpart1, 'penopart1' => $penFpart1, 'disopart1' => $disFpart1, 'deliverfpart1' => $deliverFpart1);
        $data['fieldmut1'][] = array('regomut1' => $regFmut1, 'penomut1' => $penFmut1, 'disomut1' => $disFmut1, 'deliverfmut1' => $deliverFmut1);

        $data['fieldpart'][] = array('regopart' => $regFpart, 'penopart' => $penFpart, 'disopart' => $disFpart, 'deliverfpart' => $deliverFpart);
        $data['fieldmut'][] = array('regomut' => $regFmut, 'penomut' => $penFmut, 'disomut' => $disFmut, 'deliverfmut' => $deliverFmut);
        
        }
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/diary/casediaryR', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'diary/casediaryR';
        $this->load->view('layouts/main',$data);
    }
    function casediary(){
		  $db=  $this->session->userdata('db');
       $data = array();
        $regOpart = 0;
        $disOpart = 0;
        $penOpart = 0;
        $regOmut = 0;
        $disOmut = 0;
        $penOmut = 0;
        $regOcon = 0;
        $disOcon = 0;
        $penOcon = 0;
        $deliverOpart = 0;
        $deliverOmut = 0;
        $deliverOcon = 0;
        $regOpart1 = 0;
        $disOpart1 = 0;
        $penOpart1 = 0;
        $regOmut1 = 0;
        $disOmut1 = 0;
        $penOmut1 = 0;
        $regOcon1 = 0;
        $disOcon1 = 0;
        $penOcon1 = 0;
        $deliverOpart1 = 0;
        $deliverOcon1 = 0;
        $deliverOmut1 = 0;
        //        end office
        $regFpart = 0;
        $disFpart = 0;
        $penFpart = 0;
        $deliverFpart = 0;
        $regFmut = 0;
        $disFmut = 0;
        $penFmut = 0;
        $deliverFmut = 0;
        $regFpart1 = 0;
        $disFpart1 = 0;
        $penFpart1 = 0;
        $deliverFpart1 = 0;
        $regFmut1 = 0;
        $disFmut1 = 0;
        $penFmut1 = 0;
        $deliverFmut1 = 0;
        //        end field
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->input->post('sdate');
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = $this->input->post('edate');
        $edate = date('Y-m-d', strtotime($edate));
        $locationData = array(
            'sdate' => $sdate,
            'edate' => $edate
        );
        $this->session->set_userdata($locationData);
        $q = "select * from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and submission_date>='$sdate' and submission_date<='$edate' and (submission_date is not null) and comp_serv_yn is null";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            //            partition cases
            if ($d->mut_type == '04') {
                $regOpart = $regOpart + 1;
                if (($d->status == 'P') or ( $d->status == null)) {
                    $penOpart = $penOpart + 1;
                } elseif ($d->status == 'D' or $d->status == 'd') {
                    $disOpart = $disOpart + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOpart = $deliverOpart + 1;
                }
            }
            //            end here
            if ($d->mut_type == '03') {
                $regOmut = $regOmut + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOmut = $penOmut + 1;
                }
                if ($d->status == 'D' or $d->status == 'd') {
                    $disOmut = $disOmut + 1;
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    $deliverOmut = $deliverOmut + 1;
                }
            }
            //            mutation end here
            if ($d->mut_type == '01') {
                $regOcon = $regOcon + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOcon = $penOcon + 1;
                }
                if ($d->status == 'D' or $d->status == 'd') {
                    $disOcon = $disOcon + 1;
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    $deliverOcon = $deliverOcon + 1;
                }
            }
            //            conversion end here
        }

        //        without range
        $q = "select * from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['pbb'] = $pbb = $this->db->query($q)->result();
        foreach ($pbb as $d) {
            //            partition cases
            if ($d->mut_type == '04') {
                $regOpart1 = $regOpart1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOpart1 = $penOpart1 + 1;
                } elseif ($d->status == 'D') {
                    $disOpart1 = $disOpart1 + 1;
                } elseif ($d->status == 'F') {
                    $deliverOpart1 = $deliverOpart1 + 1;
                }
            }
            //            end here
            if ($d->mut_type == '03') {
                $regOmut1 = $regOmut1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOmut1 = $penOmut1 + 1;
                } elseif ($d->status == 'D') {
                    $disOmut1 = $disOmut1 + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOmut1 = $deliverOmut1 + 1;
                }
            }
            //            mutation end here
            if ($d->mut_type == '01') {
                $regOcon1 = $regOcon1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOcon1 = $penOcon1 + 1;
                } elseif ($d->status == 'D' or $d->status == 'd') {
                    $disOcon1 = $disOcon1 + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOcon1 = $deliverOcon1 + 1;
                }
            }
            //            conversion end here
        }


        $data['officepart'] = array('regopart' => $regOpart, 'penopart' => $penOpart, 'disopart' => $disOpart, 'deliverpart' => $deliverOpart);
        $data['officemut'] = array('regomut' => $regOmut, 'penomut' => $penOmut, 'disomut' => $disOmut, 'delivermut' => $deliverOmut);
        $data['officecon'] = array('regocon' => $regOcon, 'penocon' => $penOcon, 'disocon' => $disOcon, 'delivercon' => $deliverOcon);

        $data['officepart1'] = array('regopart1' => $regOpart1, 'penopart1' => $penOpart1, 'disopart1' => $disOpart1, 'deliverpart1' => $deliverOpart1);
        $data['officemut1'] = array('regomut1' => $regOmut1, 'penomut1' => $penOmut1, 'disomut1' => $disOmut1, 'delivermut1' => $deliverOmut1);
        $data['officecon1'] = array('regocon1' => $regOcon1, 'penocon1' => $penOcon1, 'disocon1' => $disOcon1, 'delivercon1' => $deliverOcon1);
        // var_dump($data);
        // field start
        $q = "select * from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $Fb = $this->db->query($q)->result();
        foreach ($Fb as $d) {
            if ($d->mut_type == '01') {
                $regFmut1 = $regFmut1 + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFmut1 = $penFmut1 + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFmut1 = $disFmut1 + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFmut1 = $deliverFmut1 + 1;
                }
            }
            if ($d->mut_type == '02') {
                $regFpart1 = $regFpart1 + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFpart1 = $penFpart1 + 1;
                }

                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFpart1 = $disFpart1 + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFpart1 = $deliverFpart1 + 1;
                }
            }
        }
        $q = "select * from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Report_date >='$sdate' and Report_date <='$edate' and (Report_date is not null)";
        //echo $q;
        $Fb = $this->db->query($q)->result();
        foreach ($Fb as $d) {
            if ($d->mut_type == '01') {
                $regFmut = $regFmut + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFmut = $penFmut + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFmut = $disFmut + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFmut = $deliverFmut + 1;
                }
            }
            if ($d->mut_type == '02') {
                $regFpart = $regFpart + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFpart = $penFpart + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFpart = $disFpart + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFpart = $deliverFpart + 1;
                }
            }
        }
        $data['fieldpart1'] = array('regopart1' => $regFpart1, 'penopart1' => $penFpart1, 'disopart1' => $disFpart1, 'deliverfpart1' => $deliverFpart1);
        $data['fieldmut1'] = array('regomut1' => $regFmut1, 'penomut1' => $penFmut1, 'disomut1' => $disFmut1, 'deliverfmut1' => $deliverFmut1);

        $data['fieldpart'] = array('regopart' => $regFpart, 'penopart' => $penFpart, 'disopart' => $disFpart, 'deliverfpart' => $deliverFpart);
        $data['fieldmut'] = array('regomut' => $regFmut, 'penomut' => $penFmut, 'disomut' => $disFmut, 'deliverfmut' => $deliverFmut);
        ////////////////////Allotment/////////////////////////
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$sdate' and date(date_entry)<='$edate' and subdiv_code='$subdiv_code' and circle_code='$cir_code' ";
        $data['actopp_tot'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$sdate' and date(date_entry)<='$edate' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  (status ='P'  or status ='R' or status is null  )  ";
        $data['actopp_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$sdate' and date(date_entry)<='$edate' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and status ='F' ";
        $data['actopp_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and  date(date_entry)>='$sdate' and date(date_entry)<='$edate' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and status ='D'";
        $data['actopp_dispose'] = $this->db->query($q)->row();
        ///////////////////NR//////////////////////////
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
        $data['nr_tot'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status ='P' and order_passed is null  ";
        $data['nr_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed ='Y' ";
        $data['nr_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' ";
        $data['nr_dispose'] = $this->db->query($q)->row();
        ///////////////////Reclass//////////////////////////
        // Reclassfication
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$sdate' and date(lm_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['t_reclass_tot'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$sdate' and date(lm_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) ";
        $data['t_reclass_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$sdate' and date(lm_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
        $data['t_reclass_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$sdate' and date(lm_date)<='$edate' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_yn='N' ";
        $data['t_reclass_dispose'] = $this->db->query($q)->row();
        ////////////////////Settlement/////////////////////////
        $q="SELECT
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (CAST(date_entry AS DATE) >= '$sdate' and CAST(date_entry AS DATE) <= '$edate')) AS total,
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status = 'F' and (CAST(date_entry AS DATE) >= '$sdate' and CAST(date_entry AS DATE) <= '$edate')) AS passed,
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status = 'D' and (CAST(date_entry AS DATE) >= '$sdate' and CAST(date_entry AS DATE) <= '$edate')) AS rejected,
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status NOT IN ('D', 'F') and (CAST(date_entry AS DATE) >= '$sdate' and CAST(date_entry AS DATE) <= '$edate')) AS pending";
        $data['settlement'] = $this->db->query($q)->row();
        //////////////////////Composite Service///////////////////////
        $sql="SELECT 
            count(*) FILTER (WHERE status = 'F') as delivered,
            count(*) FILTER (WHERE status = 'P') as pending,
            count(*) FILTER (WHERE status = 'D') as disposed,
            count(*) as total
        from petition_basic where comp_serv_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (CAST(submission_date AS DATE) >= '$sdate' and CAST(submission_date AS DATE) <= '$edate')
        ";
        $data['composite'] = $this->db->query($sql)->row();
        /////////////////////////////////////////////
        //var_dump( $data['nr_tot']);
        // $this->load->view('../views/header');
        // $this->load->view('../views/diary/casediary', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'diary/casediary';
        $this->load->view('layouts/main',$data);
    }

    ///////////////Field Partition
    public function PendingCaseField() {
		  $db=  $this->session->userdata('db');
        // var_dump($this->session->all_userdata());
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='$mut_type' and date_entry >='$sdate' and date_entry<='$edate' and order_passed is null and is_dispose is null   ";
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            $date = new DateTime($p->date_entry);
            $now = new DateTime();
            $data['pendingDays'][] = $date->diff($now)->format("%d days, %m months and %Y years");
            if ($mut_type == 02) {
                 $q = "Select pdar_name as n,pdar_guardian as g, pdar_rel_guar as r from    field_part_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            }  
           
            $data['petipart'][] = $this->db->query($q)->result();

            //All pattadar details
            $sql = "select * from    field_mut_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  petition_no='$p->petition_no' and case_no='$p->case_no' ";
            $data['landarea'][] = $Fdag = $this->db->query($sql)->row();
            //var_dump($Fdag);
            $chithasql = "select * from    chitha_basic where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  ";
            $chithadata = $this->db->query($chithasql)->row();
            $chithadagpattadar = "select pdar_id from    chitha_dag_pattadar where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  and p_flag !='1' ";
            $chithadagpattadardata = $this->db->query($chithadagpattadar)->result();
            //var_dump($chithadagpattadardata);
            //$i = 0;
            foreach ($chithadagpattadardata as $d) {
                $chithapattadar = "select pdar_name,pdar_father,pdar_guard_reln,patta_no from    chitha_pattadar where TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                        . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code' and pdar_id='$d->pdar_id'   ";

                $pattadarname = $this->db->query($chithapattadar)->row();
                $data['pattadarname'][trim($pattadarname->patta_no)][] = array(
                    'pdar_name' => $pattadarname->pdar_name,
                    'pdar_father' => $pattadarname->pdar_father,
                    'pdar_guard_reln' => $pattadarname->pdar_guard_reln
                );
                //var_dump( $data['pattadarname']);
              
            }
        }
        //var_dump($chithapattadar);

        // $this->load->view('../views/header');
        // $this->load->view('../views/diary/fieldpendingcase_datewise', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'diary/fieldpendingcase_datewise';
        $this->load->view('layouts/main',$data);
    }
    /////////////Field Mutation
    
    public function PendingCaseMut() {
		  //$db=  $this->session->userdata('db');
        // var_dump($this->session->all_userdata());
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='$mut_type' and date_entry >='$sdate' and date_entry<='$edate' and order_passed is null and is_dispose is null   ";
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            $date = new DateTime($p->date_entry);
            $now = new DateTime();
            $data['pendingDays'][] = $date->diff($now)->format("%y years, %m months and %d days");
            if ($mut_type == 01) {
                $q = "Select pet_name as n,guard_name as g, guard_rel as r from    field_mut_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g, pdar_rel_guar as r from    field_part_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();

            //All pattadar details
           $sql = "select * from    field_mut_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  petition_no='$p->petition_no' and case_no='$p->case_no' ";
            $data['landarea'][] = $Fdag = $this->db->query($sql)->row();
           // var_dump($Fdag);
            if(sizeof($Fdag)!='0'){
           $chithasql = "select * from    chitha_basic where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  ";
            $chithadata = $this->db->query($chithasql)->row();
            $chithadagpattadar = "select pdar_id from    chitha_dag_pattadar where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  and p_flag !='1' ";
            $chithadagpattadardata = $this->db->query($chithadagpattadar)->result();
            //var_dump($chithadagpattadardata);
            //$i = 0;
            foreach ($chithadagpattadardata as $d) {
                $chithapattadar = "select pdar_name,pdar_father,pdar_guard_reln,patta_no from    chitha_pattadar where TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                        . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code' and pdar_id='$d->pdar_id'   ";

                $pattadarname = $this->db->query($chithapattadar)->row();
                $data['pattadarname'][trim($pattadarname->patta_no)][] = array(
                    'pdar_name' => $pattadarname->pdar_name,
                    'pdar_father' => $pattadarname->pdar_father,
                    'pdar_guard_reln' => $pattadarname->pdar_guard_reln
                );
                //var_dump( $data['pattadarname']);
              
            }
            }  else {
                    $data['landarea'][0]=array(
                        'patta_no'=>0,
                        'dag_no'=>'No Data Found',
                        'm_dag_area_b'=>'No Data Found',
                        'm_dag_area_k'=>'No Data Found',
                        'm_dag_area_lc'=>'No Data Found',);
                
                    $data['pattadarname'][0][] = array(
                    'pdar_name' => null,
                    'pdar_father' => null,
                    'pdar_guard_reln' => null
                );    
            }
        }
        //var_dump($chithapattadar);

        // $this->load->view('../views/header');
        // $this->load->view('../views/diary/mutfieldpendingcase', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'diary/mutfieldpendingcase';
        $this->load->view('layouts/main',$data);
    }
    
    ////////////// Pending Case Office Mutation
    function PendingCaseOMut(){
		 // $db=  $this->session->userdata('db');
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) "
                . "and mut_type='$mut_type' and submission_date >='$sdate' and submission_date<='$edate' ";
        
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            $date = new DateTime($p->date_entry);
            $now = new DateTime();
            $data['pendingDays'][] = $date->diff($now)->format("%y years, %m months and %d days");
            $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petition_pattadar where petition_no='$p->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$p->mouza_pargona_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code'  and patta_type_code='0201'    ";
            $data['petipart'][] = $this->db->query($q)->result();

            //All pattadar details
            $sql = "select * from    petition_dag_details  where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  petition_no='$p->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$p->mouza_pargona_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code'  and patta_type_code='0201'    ";
            $data['landarea'][] = $Fdag = $this->db->query($sql)->row();
            if($Fdag!=null){
            $chithasql = "select * from    chitha_basic where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  ";
            $chithadata = $this->db->query($chithasql)->row();
            $chithadagpattadar = "select pdar_id from    chitha_dag_pattadar where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  and p_flag !='1' ";
            $chithadagpattadardata = $this->db->query($chithadagpattadar)->result();
			
            //var_dump($chithadagpattadardata);
            //$i = 0;
            foreach ($chithadagpattadardata as $d) {
                $chithapattadar = "select pdar_name,pdar_father,pdar_guard_reln,patta_no from    chitha_pattadar where TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                        . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code' and pdar_id='$d->pdar_id'   ";

                $pattadarname = $this->db->query($chithapattadar)->row();
                $data['pattadarname'][trim($pattadarname->patta_no)][] = array(
                    'pdar_name' => $pattadarname->pdar_name,
                    'pdar_father' => $pattadarname->pdar_father,
                    'pdar_guard_reln' => $pattadarname->pdar_guard_reln
                );                       
            }
			}
        }
            // $this->load->view('../views/header');
            // $this->load->view('../views/diary/officependingcase', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'diary/officependingcase';
            $this->load->view('layouts/main',$data);
            }
        ////////////// Pending Case Office Partition
    function PendingCaseOPart(){
		 // $db=  $this->session->userdata('db');
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) "
                . "and mut_type='$mut_type' and submission_date >='$sdate' and submission_date<='$edate' ";
        
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            $date = new DateTime($p->submission_date);
            $now = new DateTime();
            $data['pendingDays'][] = $date->diff($now)->format("%y years, %m months and %d days");
           $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$p->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$p->mouza_pargona_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and patta_type_code='0201' ";
            $data['petipart'][] = $this->db->query($q)->result();

            //All pattadar details
           $sql = "select * from    petition_dag_details  where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$p->mouza_pargona_code' "
                    . "and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and  petition_no='$p->petition_no'  and patta_type_code='0201'       ";
            $data['landarea'][] = $Fdag = $this->db->query($sql)->row();
			if($Fdag!=null){
            $chithasql = "select * from    chitha_basic where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  ";
            $chithadata = $this->db->query($chithasql)->row();
             $chithadagpattadar = "select pdar_id from    chitha_dag_pattadar where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  and p_flag !='1' ";
            $chithadagpattadardata = $this->db->query($chithadagpattadar)->result();
            foreach ($chithadagpattadardata as $d) {
                 $chithapattadar = "select pdar_name,pdar_father,pdar_guard_reln,patta_no from    chitha_pattadar where TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                        . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code' and pdar_id='$d->pdar_id' ";
               
                $pattadarname = $this->db->query($chithapattadar)->row();
                $data['pattadarname'][trim($pattadarname->patta_no)][] = array(
                    'pdar_name' => $pattadarname->pdar_name,
                    'pdar_father' => $pattadarname->pdar_father,
                    'pdar_guard_reln' => $pattadarname->pdar_guard_reln
                );
               // var_dump( $data['pattadarname']);
              
            }
            }
             
        }
            // $this->load->view('../views/header');
            // $this->load->view('../views/diary/officependingcasepart', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'diary/officependingcasepart';
            $this->load->view('layouts/main',$data);
            }
        
        function PendingCaseOCon(){
		//$db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) "
                . "and mut_type='$mut_type' and submission_date >='$sdate' and submission_date<='$edate' ";
        
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            $date = new DateTime($p->submission_date);
            $now = new DateTime();
            $data['pendingDays'][] = $date->diff($now)->format("%y year(s), %m month(s) and %d day(s)");
            $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$p->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$p->mouza_pargona_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' ";
            $data['petipart'][] =$this->db->query($q)->result();
            
            //All pattadar details
             $sql = "select * from    petition_dag_details  where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$p->mouza_pargona_code' "
                    . " and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and  petition_no='$p->petition_no'      ";
            $data['landarea'][] = $Fdag = $this->db->query($sql)->row();
            //var_dump($Fdag);
            $chithasql = "select * from    chitha_basic where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  ";
            $chithadata = $this->db->query($chithasql)->row();
              $chithadagpattadar = "select pdar_id,patta_type_code from    chitha_dag_pattadar where dag_no='$Fdag->dag_no' and TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code'  and p_flag !='1' ";
            $chithadagpattadardata = $this->db->query($chithadagpattadar)->result();
            //var_dump($chithadagpattadardata);
            //$i = 0;
            foreach ($chithadagpattadardata as $d) {
               // var_dump($d);
                $chithapattadar = "select pdar_name,pdar_father,pdar_guard_reln,patta_no from    chitha_pattadar where TRIM(patta_no)=trim('$Fdag->patta_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                        . "and mouza_pargona_code='$Fdag->mouza_pargona_code' and lot_no='$Fdag->lot_no' and vill_townprt_code='$Fdag->vill_townprt_code' and pdar_id='$d->pdar_id' and patta_type_code='$d->patta_type_code'  ";
               
                $pattadarname = $this->db->query($chithapattadar)->row();
                $data['pattadarname'][trim($pattadarname->patta_no)][] = array(
                    'pdar_name' => $pattadarname->pdar_name,
                    'pdar_father' => $pattadarname->pdar_father,
                    'pdar_guard_reln' => $pattadarname->pdar_guard_reln
                );
            }
        }
            // $this->load->view('../views/header');
            // $this->load->view('../views/diary/officependingcasecon', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'diary/officependingcasecon';
            $this->load->view('layouts/main',$data);
            }
        
    

}
