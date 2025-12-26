<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SKMutation extends CI_Controller {

    var $base_query;
    var $defined_date;
    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/skmutationmodel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('mutation/mutationmodel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
		$db=  $this->session->userdata('db');
        $year_no = year_no;
        $this->defined_date = define_date;
        $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' "
                . "and date(date_entry)>='$this->defined_date' ";
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
        $this->load->helper('html');
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('skmutation/index');
        $this->load->view('../views/footer');
    }

    public function getPendingFMCases() {
        $this->dbswitch();
        $this->load->library('pagination');
        $mut_type = $this->input->get('mut');

        if ($mut_type == '01') {
            $cases['cases'] = $this->skmutationmodel->getPendingFMCases($mut_type)->result();
        } else if ($mut_type == '02') {
            $cases['cases'] = $this->skmutationmodel->getPendingFMCases($mut_type)->result();
        }

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/skmutation/cases', $cases);
        // $this->load->view('../views/footer');
		$cases['_view'] = 'skmutation/cases';
		$this->load->view('layouts/main',$cases);
    }

    public function getPendingOfficeCases() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
		$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $mut_type = $this->input->get('mut');
        $config['base_url'] = base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=' . $mut_type;
        if ($mut_type == '01') {
            $c_q = "SELECT count(*) as c from   Petition_basic WHERE status not in ('D','F') and not_fresh='Y' and "
                    . "sk_comment is null and  lm_note_date is not null and "
                    . "order_passed is null and mut_type='01' and $this->base_query";
        } else if ($mut_type == '03') {
            $c_q = "SELECT count(*) as c from   Petition_basic WHERE status not in ('D','F') and not_fresh='Y' and "
                    . "sk_comment is null and  lm_note_date is not null and "
                    . "order_passed is null and es_flag=0 and mut_type='03' and $this->base_query";
        } else if ($mut_type == '04') {
            $c_q = "SELECT count(*) as c from   Petition_basic WHERE status not in ('D','F') and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and "
                    . "sk_comment is null and es_flag=0 and  lm_note_date is not null and "
                    . "order_passed is null and status='P' and mut_type='04' and $this->base_query";
        }
        
        if ($mut_type == '01') {
            $query = "SELECT *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree WHERE  not_fresh='Y' and "
                    . "sk_comment is null and  lm_note_date is not null and "
                    . "order_passed is null and mut_type='$mut_type' and status not in ('D','F') and $this->base_query order by mut_type,Year_no,Petition_no ";
        } else if ($mut_type == '03') {
            $query = "SELECT *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree WHERE  not_fresh='Y' and "
                    . "sk_comment is null and es_flag=0 and  lm_note_date is not null and "
                    . "order_passed is null and mut_type='$mut_type'  and status not in ('D','F') and $this->base_query order by mut_type,Year_no,Petition_no ";
        } else if ($mut_type == '04') {
            $query = "SELECT *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree WHERE  
              status!='D' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  not_fresh='Y' and "
                    . "sk_comment is null and es_flag=0 and  lm_note_date is not null and "
                    . "order_passed is null and mut_type='$mut_type' and status='P' and $this->base_query order by mut_type,Year_no,Petition_no ";

        }

        if ($mut_type == '04') {
            $cases = $this->db->query($query)->result();
            $data['cases'] = $cases;
			$data['_view'] = 'partition/officecases';
			$this->load->view('layouts/main',$data);
        } else {
            $cases = $this->db->query($query)->result();
            $data['cases'] = $cases;
			$data['_view'] = 'skmutation/officecases';
			$this->load->view('layouts/main',$data);
        }
    }

    public function getLMReport() {
        $append = $this->base_query;
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        
        
        $location = $this->db->get_where(" field_mut_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->row();
        
        $q = "select * from    field_mut_pattadar where case_no ='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and " . $append;
        
        $patta = $this->db->query("select * from   field_mut_pattadar where case_no ='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no='$location->petition_no' and $append")->row();

        $petitioner = $this->db->get_where(" field_mut_petitioner", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1 , 'petition_no'=>$location->petition_no))->result();
        
        $dag_details = $this->db->get_where(" field_mut_dag_details", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1 , 'petition_no'=>$location->petition_no))->result();

        $allpattadar = array();
        foreach ($dag_details as $d) {
            $q = "select * from   chitha_pattadar p join 
                 chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                p.pdar_id = d.pdar_id where p.dist_code='$location->dist_code' and p.subdiv_code='$location->subdiv_code' and p.cir_code='$location->cir_code' and
                p.mouza_pargona_code='$location->mouza_pargona_code' and p.vill_townprt_code='$location->vill_townprt_code' 
                and d.lot_no='$location->lot_no' and d.dag_no='$d->dag_no' and TRIM(p.patta_no)=trim('$patta->patta_no') 
                and p.patta_type_code='$patta->patta_type_code' and (d.p_flag!='1' or d.p_flag is null) and d.dag_no='$d->dag_no' and TRIM(d.patta_no)=trim('$d->patta_no') ";
                
            $allpattadar[$d->dag_no] = $this->db->query($q)->result();
        }

        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);
        $transcode = $this->utilityclass->getTransferType($location->trans_code);

        $patta_type_code = $patta->patta_type_code;
        $patta_type = $this->db->get_where(" patta_code", array('type_code' => $patta_type_code))->row()->patta_type;

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'trans_code' => $transcode, 'deedno' => $location->reg_deed_no,
            'possession' => $location->possession_yn, 'dispute' => $location->dispute_yn
        );

        $pattainfo = array(
            'p' => $patta_type
        );

        $sql = "select dag_no,dag_area_b,dag_area_k,dag_area_lc,m_dag_area_b,m_dag_area_k,m_dag_area_lc from   field_mut_dag_details where case_no='$case_no' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and "
                . "petition_no='$location->petition_no' and $append";
        $values = $this->db->query($sql)->result();
        
        $rem = array();
        foreach ($values as $v) {
            $sourcelessa = $v->dag_area_b * 100 + $v->dag_area_k * 20 + $v->dag_area_lc;
            $targetlessa = $v->m_dag_area_b * 100 + $v->m_dag_area_k * 20 + $v->m_dag_area_lc;
            $remaining_lessa = $sourcelessa - $targetlessa;
            $rem_b = floor($remaining_lessa / 100);

            $rem_k = floor(($remaining_lessa - $rem_b * 100) / 20);
            $rem_lc = $remaining_lessa - $rem_b * 100 - $rem_k * 20;

            $left = array('rem_b' => $rem_b, 'rem_k' => $rem_k, 'rem_lc' => $rem_lc);
            $rem[$v->dag_no] = $left;
        }
        $data['location'] = $locations;
        $data['pattadar'] = $location;
        $data['patta'] = $pattainfo;
        $data['case_no'] = $case_no;
        $data['petitioner'] = $petitioner;
        $data['dag'] = $dag_details;
        $data['allpattadar'] = $allpattadar;
        $data['land_rem'] = $rem;
        
        $query="Select remark,date(date_entry) as date_entry from (
                Select remark,date_entry from field_mut_dag_details where case_no='$case_no' union 
                SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc";
        $data['lm_remark']=$this->db->query($query)->result_array(); 
        
        
        $this->load->view('../views/skmutation/lmreport', $data);
        //$this->load->view('../views/footer');
    }

    public function getLMReport1() {
        $append = $this->base_query;
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        
        
        $location = $this->db->get_where(" field_mut_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->row();
        
        $q = "select * from    field_mut_pattadar where case_no ='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and " . $append;
        
        $patta = $this->db->query("select * from   field_mut_pattadar where case_no ='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no='$location->petition_no' and $append")->row();

        $petitioner = $this->db->get_where(" field_mut_petitioner", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1 , 'petition_no'=>$location->petition_no))->result();
        
        $dag_details = $this->db->get_where(" field_mut_dag_details", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1 , 'petition_no'=>$location->petition_no))->result();

        $allpattadar = array();
        foreach ($dag_details as $d) {
            $q = "select * from   chitha_pattadar p join 
                 chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                p.pdar_id = d.pdar_id where p.dist_code='$location->dist_code' and p.subdiv_code='$location->subdiv_code' and p.cir_code='$location->cir_code' and
                p.mouza_pargona_code='$location->mouza_pargona_code' and p.vill_townprt_code='$location->vill_townprt_code' 
                and d.lot_no='$location->lot_no' and d.dag_no='$d->dag_no' and TRIM(p.patta_no)=trim('$patta->patta_no') 
                and p.patta_type_code='$patta->patta_type_code' and (d.p_flag!='1' or d.p_flag is null) and d.dag_no='$d->dag_no' and TRIM(d.patta_no)=trim('$d->patta_no') ";
                
            $allpattadar[$d->dag_no] = $this->db->query($q)->result();
        }

        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);
        $transcode = $this->utilityclass->getTransferType($location->trans_code);

        $patta_type_code = $patta->patta_type_code;
        $patta_type = $this->db->get_where("  patta_code "  , array('type_code' => $patta_type_code))->row()->patta_type;

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'trans_code' => $transcode, 'deedno' => $location->reg_deed_no,
            'possession' => $location->possession_yn, 'dispute' => $location->dispute_yn
        );

        $pattainfo = array(
            'p' => $patta_type
        );

        //#START PLB/////

        $sql = "select dag_no,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g from   field_mut_dag_details where case_no='$case_no' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and "
                . "petition_no='$location->petition_no' and $append";
        $values = $this->db->query($sql)->result();
        
        $rem = array();
       


        foreach ($values as $v) {

            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
            $sourcelessa = $v->dag_area_b * 6400 + $v->dag_area_k * 320 + $v->dag_area_lc * 20 + $v->dag_area_g;
            $targetlessa = $v->m_dag_area_b * 6400 + $v->m_dag_area_k * 320 + $v->m_dag_area_lc * 20 + $v->m_dag_area_g;
            $remaining_lessa = $sourcelessa - $targetlessa;
            $rem_b = floor($remaining_lessa / 6400);

            $rem_k = floor(($remaining_lessa - $rem_b * 6400) / 320);
            $rem_lc = floor(($remaining_lessa - $rem_b * 6400 - $rem_k * 320)/20);
            
            $rem_g = $remaining_lessa - $rem_b * 6400 - $rem_k * 320 - $rem_lc * 20 ;
            $left = array('rem_b' => $rem_b, 'rem_k' => $rem_k, 'rem_lc' => $rem_lc, 'rem_g' => $rem_g);
            $rem[$v->dag_no] = $left;
                
            }
            else
            {
            $sourcelessa = $v->dag_area_b * 100 + $v->dag_area_k * 20 + $v->dag_area_lc;
            $targetlessa = $v->m_dag_area_b * 100 + $v->m_dag_area_k * 20 + $v->m_dag_area_lc;
            $remaining_lessa = $sourcelessa - $targetlessa;
            $rem_b = floor($remaining_lessa / 100);

            $rem_k = floor(($remaining_lessa - $rem_b * 100) / 20);
            $rem_lc = $remaining_lessa - $rem_b * 100 - $rem_k * 20;

            $left = array('rem_b' => $rem_b, 'rem_k' => $rem_k, 'rem_lc' => $rem_lc);
            $rem[$v->dag_no] = $left;
            }
           
        }

        //#END PLB
        $data['location'] = $locations;
        $data['pattadar'] = $location;
        $data['patta'] = $pattainfo;
        $data['case_no'] = $case_no;
        $data['petitioner'] = $petitioner;
        $data['dag'] = $dag_details;
        $data['allpattadar'] = $allpattadar;
        $data['land_rem'] = $rem;

        $query="Select remark,date(date_entry) as date_entry from (
                Select remark,date_entry from field_mut_dag_details where case_no='$case_no' union 
                SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc";
        $data['lm_remark']=$this->db->query($query)->result_array();
       
        if($this->session->userdata('dist_code')=='21')
        {
            $this->load->view('../views/skmutation/lmreportkar', $data);
        }
        else{
            $this->load->view('../views/skmutation/lmreport', $data);
        }

    }

    public function getLMReportPartition() {
        $append = $this->base_query;
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $case_no = $this->input->get('case_no');

        $location = $this->db->get_where(" field_mut_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->row();

        $patta = $this->db->get_where(" field_part_petitioner", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->row();

        $petitioner = $this->db->get_where(" field_part_petitioner", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->result();

        $dag_details = $this->db->get_where(" field_mut_dag_details", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->row();
        
        $q = "select * from   chitha_pattadar p join 
             chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$location->dist_code' and p.subdiv_code='$location->subdiv_code' and p.cir_code='$location->cir_code' and
            p.mouza_pargona_code='$location->mouza_pargona_code' and p.vill_townprt_code='$location->vill_townprt_code' 
            and d.lot_no='$location->lot_no' and d.dag_no='$dag_details->dag_no' and TRIM(p.patta_no)=trim('$patta->patta_no') 
            and p.patta_type_code='$patta->patta_type_code' and (d.p_flag!='1' or d.p_flag is null) ";

        $allpattadar = $this->db->query($q)->result();


        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);
        //$transcode = $this->utilityclass->getTransferType($location->trans_code);

        $patta_type_code = $patta->patta_type_code;
        $patta_type = $this->db->get_where(" patta_code", array('type_code' => $patta_type_code))->row()->patta_type;

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'deedno' => $location->reg_deed_no,
            'possession' => $location->possession_yn, 'dispute' => $location->dispute_yn
        );

        $pattainfo = array(
            'p' => $patta_type
        );

        $sql = "select dag_no,dag_area_b,dag_area_k,dag_area_lc,m_dag_area_b,m_dag_area_k,m_dag_area_lc from   field_mut_dag_details where case_no='$case_no' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and "
                . "petition_no='$location->petition_no' and $append";
        $values = $this->db->query($sql)->row();


        $sourcelessa = $values->dag_area_b * 100 + $values->dag_area_k * 20 + $values->dag_area_lc;
        $targetlessa = $values->m_dag_area_b * 100 + $values->m_dag_area_k * 20 + $values->m_dag_area_lc;


        $remaining_lessa = $sourcelessa - $targetlessa;


        $rem_b = floor($remaining_lessa / 100);

        $rem_k = floor(($remaining_lessa - $rem_b * 100) / 20);
        $rem_lc = $remaining_lessa - $rem_b * 100 - $rem_k * 20;

        $left = array('rem_b' => $rem_b, 'rem_k' => $rem_k, 'rem_lc' => $rem_lc);

        $data['location'] = $locations;
        $data['pattadar'] = $location;
        $data['patta'] = $pattainfo;
        $data['case_no'] = $case_no;
        $data['petitioner'] = $petitioner;
        $data['dag'] = $dag_details;
        $data['allpattadar'] = $allpattadar;
        $data['land_rem'] = $left;

        $query="Select remark,date(date_entry) as date_entry from (
                Select remark,date_entry from field_mut_dag_details where case_no='$case_no' union 
                SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc";
        $data['lm_remark']=$this->db->query($query)->result_array();        
        
        $this->load->view('../views/skmutation/lmreportpartition', $data);
    }

    public function saveReport() {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }   
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
       }
        //xss & security validation ends 
        $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        //$db=  $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $this->db->trans_begin();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $case_no = $this->input->post('case_no');
            $data = array(
                'sk_note' => $this->input->post('sk_note'),
                'sk_note_date' => date('Y-m-d G:i:s'),
                'sk_flag' => 'y'
            );
            //var_dump($data);
            $this->db->where(array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code));
            if ($this->db->update("field_mut_basic", $data)) {

                //////////
            $penUser='CO';
            $rmrk=$this->input->post('sk_note');
            $this->DashboardData($case_no,$penUser,$rmrk);

            ///////

            $proInsert = $this->mutationmodel->proceeding_order($case_no,$rmrk);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#OMUTSKFM001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUTSKFM001)".$case_no);
                redirect(base_url() . "index.php/home");
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                 $this->session->set_flashdata("message","SK Report Submitted Successfully...");
                redirect(base_url() . "index.php/home");
            }
            }
        } else {
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $dag_no = $this->db->get_where("field_mut_dag_details", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code))->result();
            $data['dag_no'] = $dag_no;

            $this->load->helper('html');
            $data['basuCase']=null;
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $data['query']=null;
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            }
            $data['_view'] = 'skmutation/skreport';
            $this->load->view('layouts/main',$data);
        }
    }

    public function writeOfficeReport() {
                //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
              return redirect($_SERVER['HTTP_REFERER']);
        }
       
        //xss & security validation ends 
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dag_sk_note = ($this->input->post('dag_sk_note'));
            $sk_note = ($this->input->post('sk_note'));

            $db=  $this->session->userdata('db');
            $sk_note_date = date('Y-m-d G:i:s');
            $petition_no = $this->input->post('petition_no');
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->post('case_no');

            $this->db->trans_begin();
            for ($i=0; $i < count($dag_sk_note) ; $i++) { 
               $query = "update  petition_lm_note set sk_note=?,sk_note_date=?,user_code=? "
                    . "where dag_no = ? and petition_no=? and $this->base_query ";
                $this->db->query($query, array($sk_note[$i], $sk_note_date, $user_code, $dag_sk_note[$i],$petition_no));


                $query = "update  petition_basic set sk_comment=? where petition_no = ? and $this->base_query and case_no = '$case_no' and date(date_of_order) is null and status='P'";
                $this->db->query($query, array('Y', $petition_no));

                if($this->db->affected_rows()==1){
                    $proInsert = $this->mutationmodel->proceeding_order($case_no,$sk_note[$i]);
                }else{
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Updation failed(#OMUTSK001)".$case_no . "Final Order may be already given");
                    redirect(base_url() . "index.php/home");
                }
                if($proInsert==false || $proInsert===false)
                {
                    log_message('error', "#OMUTSK001:".$this->db->last_query());
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Updation failed(#OMUTSK001)".$case_no);
                    redirect(base_url() . "index.php/home");
                }
            }
        
            // $query = "update  petition_lm_note set sk_note=?,sk_note_date=?,user_code=? "
            //         . "where petition_no=? and $this->base_query ";
            // $this->db->query($query, array($sk_note, $sk_note_date, $user_code, $petition_no));
            

            //////////
            $penUser='CO';
            $rmrk='Report given by SK';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ///////
            ////////////////////
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $rmk='Forwarded to CO';
                $status='M';
                $task='SK';
                $pen='CO';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            }
            ///////////////////

             if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                 $this->session->set_flashdata("message","SK Report Submitted Successfully...");
                redirect(base_url() . "index.php/home");
            }
            // $this->session->set_flashdata('message', 'SK Report Submitted for Office Mutation Case No ' . $case_no);
            // redirect(base_url() . "index.php/home");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $pb = $this->db->query("select petition_no,application_ref_no,applid from   petition_basic where"
                            . " case_no='$case_no' and date(date_of_order) is null and status='P' ");   
            if($pb->num_rows()==0){
                echo json_encode("Undefined Case No");
                return;
            }
            $data['pb']=$pb=$pb->row();
            $petition_no=$pb->petition_no;
            $dags_query = "select * from   petition_dag_details where petition_no=$petition_no and $this->base_query";
            $dags = $this->db->query($dags_query)->result();
            $data['dags'] = $dags;
            $data['petition_no'] = $petition_no;
            $data['case_no'] = $case_no;
            $data['basuCase']=null;
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($pb->application_ref_no){
                $url =RTPS_LINK. "mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output); 
                $data['attachment'] = $output;
            }
            $data['query']=$data['basundharaAttachment']=null;
            if($basundharaExist){
                $data['query']=null;
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            }
            $data['_view'] = 'skmutation/officereport';
            $this->load->view('layouts/main',$data);
        }
    }

     function DashboardData($case_no,$penUser,$rmrk){
            //////////////Update Dashboard Database///////////////////////
                    $this->dbb = $this->load->database('dash', TRUE);
                    $base=array(
                        'pending_with_user' => $penUser,
                        'date_of_update'=>date("Y-m-d h:i:s")
                    );
                    $this->dbb->where('case_no',$case_no);
                    $this->dbb->update('dashboard_data',$base);

                    $this->db->where('case_no',$case_no);
                    $this->db->update('dashboard_data',$base);

                    $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                    if ($ip == true)
                    return;

                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date("Y-m-d h:i:s"),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => $rmrk,
                        'ip_address'=>$this->utilityclass->get_client_ip()
                         );
                    $this->dbb->insert('dashboard_action',$action);
                     $this->db->insert('dashboard_action',$action);
                /////////////////////////////////////
        }

        function DashboardDataFinal($case_no){
            //////////////Update Dashboard Database///////////////////////
                        $this->dbb = $this->load->database('dash', TRUE);
                        $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'F',
                            'remark'=>'Final Order Passed',
                            'date_of_update'=>date("Y-m-d h:i:s")
                        );
                        $this->dbb->where('case_no',$case_no);
                        $this->dbb->update('dashboard_data',$base);

                        $this->db->where('case_no',$case_no);
                        $this->db->update('dashboard_data',$base);

                        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                        if ($ip == true)
                        return;

                        $action= array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_of_action_taken' => date("Y-m-d h:i:s"),
                            'user_designation' => $this->session->userdata('user_desig_code'),
                            'remark' => 'Final Order Passed',
                            'ip_address'=>$this->utilityclass->get_client_ip()
                             );
                        $this->dbb->insert('dashboard_action',$action);
                        $this->db->insert('dashboard_action',$action);
                        
                /////////////////////////////////////
        }

    function DashboardDataReject($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'R',
                            'remark'=>'Case Rejected',
                            'date_of_update'=>date("Y-m-d h:i:s")
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);

                $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                if ($ip == true)
                return;
            
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date('Y-m-d'),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected',
                     );
                $this->dbb->insert('dashboard_action',$action);
            }

}
