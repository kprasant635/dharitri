<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PattaModel extends CI_Model {

    public function __construct() {
        parent::__construct();
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

    public function getPattaTypeByPattaCode() {
        
    }


    public function list(){
        return $this->db->get('patta_code')->result();
    }
    
    public function notMappedList(){
        return $this->db->where('patta_code_group_id IS NULL', null, false)->get('patta_code')->result();
    }

    public function getAllPattaType() {
		     $db=  $this->session->userdata('db');
        $data = $this->db->query("select type_code,patta_type from  patta_code");
        return $data->result();
    }

    public function getDagsByPattaNo($pattano) {
		     $db=  $this->session->userdata('db');
        $data = $this->db->query("select dag_no from  chitha_basic where TRIM(patta_no)=trim('$pattano')");
        return $data;
    }

    public function getDagsByPattaNoConversion($pattano, $patta_type, $dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code) {
        $db=  $this->session->userdata('db');
		$data = $this->db->query("select dag_no from  chitha_basic where TRIM(patta_no)=trim('$pattano') and patta_type_code='$patta_type' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_code' ");
        return $data;
    }

    public function getDagsByPattaNoPattaType($pattano, $pattatype, $case_no) {
		$db=  $this->session->userdata('db');
        $dags = $this->session->userdata('dag_det');

        $in = array();
        if ($dags)
            foreach ($dags as $d) {
                $in[] = $d['dag_no'];
            }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $query = "select dag_no from  chitha_basic where dag_no not in"
                . " ( '" . implode("', '", $in) . "' ) "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
                . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' "
                . "and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$pattano')"
                . " and patta_type_code='$pattatype'";
       
        $data = $this->db->query($query);
        return $data;
    }

    public function getPattadar($pattaNo, $pattaType, $dag_no) {
		     $db=  $this->session->userdata('db');
        $conditions = $this->utilityclass->getLocationFromSession();

        $other = array('patta_no' => trim($pattaNo), 'patta_type_code' => $pattaType);
        $merged = array_merge($conditions, $other);
        $data = $this->db->get_where('chitha_pattadar', $merged);
        return $data;
    }

    public function getPattadarFiltered($offset, $dag_no) {
		     $db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        //$dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $case_no = $this->session->userdata('case_no');
        $patdet = $this->session->userdata('patdet');
        if ($patdet != null) {
            $selections = array();
            foreach ($patdet as $p) {
                array_push($selections, $p['pdar_id']);
            }
        }
        if (isset($selections)) {
            $str = implode(", ", $selections);
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and TRIM(d.dag_no)=trim('$dag_no') and TRIM(p.patta_no)=trim('$pattaNo')  and d.p_flag!='1'
            and p.patta_type_code='$pattaType' and"
                    . " p.pdar_id not in ($str)";
        } else {
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and TRIM(d.dag_no)=trim('$dag_no') and TRIM(p.patta_no)=trim('$pattaNo')  and d.p_flag!='1'
            and p.patta_type_code='$pattaType' ";
        }
        if( $this->session->userdata('ismultiple')==true) {
           
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and TRIM(d.dag_no)=trim('$dag_no') and TRIM(p.patta_no)=trim('$pattaNo')  and d.p_flag='0'
            and p.patta_type_code='$pattaType' ";
             // . " and p.pdar_id not in ($str)";
        }
        
        $data = $this->db->query($q);
       
        return $data;
    }


    public function getPattadarOfficeForMultiGen($case_no) {
        $db=  $this->session->userdata('db');
        $q = "select * from  petition_basic where case_no='$case_no'";
        $data = $this->db->query($q)->row();
        $dist_code = $data->dist_code;
        $subdiv_code = $data->subdiv_code;
        $cir_code = $data->cir_code;
        $mouza_pargona_code = $data->mouza_pargona_code;
        $lot_no = $data->lot_no;
        $vill_townprt_code = $data->vill_townprt_code;
        $petition_no = $data->petition_no;
        $defined = define_date;
        $q = "select * from  petition_dag_details where petition_no='$data->petition_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date(date_entry)>='$defined'";
     
        $data = $this->db->query($q)->result();
        $sellers = array();
        foreach ($data as $key => $value) {

            $dag_no = $value->dag_no;
            $pattaNo = trim($value->patta_no);
            $pattaType = $value->patta_type_code;

            $sql_p="select ''''||string_agg(pdar_id::varchar ,''',''')||'''' as pdar_ids  from  petition_pattadar where petition_no = '$petition_no' and  dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date(date_entry)>='$defined' and dag_no = '$dag_no'";

            $petition_pattadars = $this->db->query($sql_p)->row()->pdar_ids;
            $where_condition="dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and
                mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' 
                and lot_no='$lot_no'  and TRIM(patta_no)='$pattaNo' 
                and patta_type_code='$pattaType'";
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln, d.dag_no from 
                (select pdar_id,pdar_name,pdar_father,pdar_add1,pdar_add2,pdar_add3,pdar_guard_reln from chitha_pattadar where $where_condition) p join 
                (select pdar_id, dag_no from chitha_dag_pattadar where $where_condition and ( p_flag='0' or p_flag is null) and dag_no='$dag_no') d on 
                p.pdar_id = d.pdar_id where p.pdar_id  in ($petition_pattadars) 
                    ";
            $sellers = array_merge($sellers,$this->db->query($q)->result());

            
        }
        return $sellers;
        
    }
    public function getPattadarOffice($case_no) {
		     $db=  $this->session->userdata('db');
        $q = "select * from  petition_basic where case_no='$case_no'";
      
        $data = $this->db->query($q)->row();

        $dist_code = $data->dist_code;
        $subdiv_code = $data->subdiv_code;
        $cir_code = $data->cir_code;
        $mouza_pargona_code = $data->mouza_pargona_code;
        $lot_no = $data->lot_no;
        $vill_townprt_code = $data->vill_townprt_code;
        $petition_no = $data->petition_no;
        $defined = define_date;
        $q = "select * from  petition_dag_details where petition_no='$data->petition_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date(date_entry)>='$defined'";
     
        $data = $this->db->query($q)->row();
        $dag_no = $data->dag_no;
        $pattaNo = trim($data->patta_no);
        $pattaType = $data->patta_type_code;
        $sql_p="select ''''||string_agg(pdar_id::varchar ,''',''')||'''' as pdar_ids  from  petition_pattadar where petition_no = '$petition_no' and  dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date(date_entry)>='$defined'";
        $petition_pattadars = $this->db->query($sql_p)->row()->pdar_ids;

        $where_condition="dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and
            mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' 
            and lot_no='$lot_no'  and TRIM(patta_no)='$pattaNo' 
            and patta_type_code='$pattaType'";
        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from 
            (select pdar_id,pdar_name,pdar_father,pdar_add1,pdar_add2,pdar_add3,pdar_guard_reln from chitha_pattadar where $where_condition) p join 
            (select pdar_id from chitha_dag_pattadar where $where_condition and ( p_flag='0' or p_flag is null) and dag_no='$dag_no') d on 
            p.pdar_id = d.pdar_id where p.pdar_id  in ($petition_pattadars) 
                ";
        $data = $this->db->query($q);

        return $data;
    }

    // Added By Abhijit -- 2024-04-24
    public function getPattadarOfficeMultiDag($case_no) {
		     $db=  $this->session->userdata('db');
        $q = "select * from  petition_basic where case_no='$case_no'";
      
        $data = $this->db->query($q)->row();
        
        $dist_code = $data->dist_code;
        $subdiv_code = $data->subdiv_code;
        $cir_code = $data->cir_code;
        $mouza_pargona_code = $data->mouza_pargona_code;
        $lot_no = $data->lot_no;
        $vill_townprt_code = $data->vill_townprt_code;
        $petition_no = $data->petition_no;
        $defined = define_date;
        $q = "select * from  petition_dag_details where petition_no='$data->petition_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date(date_entry)>='$defined'";
     
        $data = $this->db->query($q)->result();
        
        $pattaNo = trim($data[0]->patta_no);
        $pattaType = $data[0]->patta_type_code;

        $result = [];
        foreach($data as $d){
            $dag_no = $d->dag_no;
            $sql_p="select ''''||string_agg(pdar_id::varchar ,''',''')||'''' as pdar_ids  from  petition_pattadar where petition_no = '$petition_no' and dag_no='$dag_no' and  dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date(date_entry)>='$defined'";
            $petition_pattadars = $this->db->query($sql_p)->row()->pdar_ids;
            
            $where_condition="dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and
                mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' 
                and lot_no='$lot_no'  and TRIM(patta_no)='$pattaNo' 
                and patta_type_code='$pattaType'";
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln, d.dag_no from 
                (select pdar_id,pdar_name,pdar_father,pdar_add1,pdar_add2,pdar_add3,pdar_guard_reln from chitha_pattadar where $where_condition) p join 
                (select pdar_id, dag_no from chitha_dag_pattadar where $where_condition and ( p_flag='0' or p_flag is null) and dag_no='$dag_no') d on 
                p.pdar_id = d.pdar_id where p.pdar_id  in ($petition_pattadars) 
                    ";
            
            $data = $this->db->query($q)->result();

            $result = array_merge($result, $data);
            // array_push($result, $data);
            // $result[] = $data;
        }
        
        return $result;
    }

    public function getPattadars() {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');


        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and TRIM(p.patta_no) = TRIM(d.patta_no) and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo'  and (d.p_flag!='1' or d.p_flag is null)
            and p.patta_type_code='$pattaType'";
        
        $data = $this->db->query($q);

        return $data->result();
        //return $q;
    }

    public function getPattadarFilteredForPartition() {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $case_no = $this->session->userdata('case_no');
        $incompare = null;
        if ($this->session->userdata('pdaridarray')) {
            $incompare = implode(',', array_values($this->session->userdata('pdaridarray')));
            //echo $incompare;
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and d.p_flag!='1'
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' 
            and p.patta_type_code='$pattaType' and p.pdar_id not in($incompare)";
        } else {
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and d.p_flag!='1'
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' 
            and p.patta_type_code='$pattaType'";
        }



       
        $data = $this->db->query($q);
        //var_dump($data->result());
        return $data;
    }

    public function getGuardianName($pdar_id, $dag) {
$db=  $this->session->userdata('db');
        if ($dag == 0) {
            $dag_no = rawurldecode($this->session->userdata('dag_no'));
        } else {
            $dag_no = rawurldecode($dag);
        }

        $pattaNo = TRIM($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
		$patta_type_code = $this->session->userdata('patta_type');

        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln,p.pdar_gender,p.pdar_mother,p.pdar_aadharno,p.pdar_mobile,p.pdar_nrcno,
            p.pdar_pan_no,p.pdar_citizen_no from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' and p.pdar_id='$pdar_id' 
            and p.patta_type_code='$pattaType'";
        
        $data = $this->db->query($q);

        return $data;
    }

    public function getGuardianNameNoSession($pdar_id, $case_no) {
		$db=  $this->session->userdata('db');

        $q = "select * from  petition_basic where case_no='$case_no'";
        $data = $this->db->query($q)->row();

        $dist_code = $data->dist_code;
        $subdiv_code = $data->subdiv_code;
        $cir_code = $data->cir_code;
        $mouza_pargona_code = $data->mouza_pargona_code;
        $lot_no = $data->lot_no;
        $vill_townprt_code = $data->vill_townprt_code;
        $petition_no = $data->petition_no;
        $defined = define_date;
        $q = "select * from  petition_dag_details where petition_no='$data->petition_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and date(date_entry)>='$defined'";
        $data = $this->db->query($q)->row();
        $dag_no = $data->dag_no;
        $pattaNo = trim($data->patta_no);
        $pattaType = $data->patta_type_code;


        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' and p.pdar_id='$pdar_id' 
            and p.patta_type_code='$pattaType'";

        $data = $this->db->query($q);

        return $data;
    }

    public function getPattaDarNameById($pdar_id, $dag_no) {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $q = "select p.pdar_name from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' and p.pdar_id=$pdar_id 
            and p.patta_type_code='$pattaType' limit 1";
        //echo $q;
        $data = $this->db->query($q);

        return $data;
    }

    public function getPattadarForOfficeMutation() {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');


        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' 
            and p.patta_type_code='$pattaType'";
        //echo $q;
        $data = $this->db->query($q);
        //var_dump($data->result());
        return $data;
    }

    public function getAddress1($pdar_id) {
$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo' and p.pdar_id=$pdar_id 
            and p.patta_type_code='$pattaType'";

        $data = $this->db->query($q);

        return $data;
    }

    public function getPattadarsByPattaNo1() {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $q = "select * from  chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
            and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and"
                . " p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no'
            and TRIM(p.patta_no)='$pattaNo' and p.patta_type_code='$pattaType' and p.pdar_id in(
	select pdar_id from  chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
            and p.cir_code='$cir_code' 
        and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$pattaNo' 
        and p.patta_type_code='$pattaType' and p_flag!='1')";

        $data = $this->db->query($q)->result();

        return $data;
    }

    public function getPattadarsByPattaNo() {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $q = "select * from  chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and  
            TRIM(p.patta_no) = TRIM(d.patta_no) and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and TRIM(p.patta_no)='$pattaNo' 
            and p.patta_type_code='$pattaType' and d.p_flag!='1' ";
        //echo $q;
        $data = $this->db->query($q)->result();

        return $data;
    }



}
