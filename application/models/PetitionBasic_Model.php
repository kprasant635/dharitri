<?php

class PetitionBasic_model extends CI_Model {

    var $table = "petition_basic";
    var $order_column = array("date_entry");
     public function __construct() {
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
     }else if($this->session->userdata('dist_code') == "39"){
        $this->db=$this->load->database('dha39', TRUE);   
     }                                                                                                                                                                                                            
}
    function make_query($clause,$join=false) {
        //$this->db->select("*");
        //$this->db->from($this->table);
        $this->db->select('*,ba.basundhara');
        $this->db->from('petition_basic fmb');
        $this->db->join('basundhar_application ba', 'fmb.case_no=ba.dharitree','left');
        $this->db->join('landsale l', 'fmb.noc_no=l.appno','left');
        if ($join == true) {
            $this->db->join('sro_push_history sph', 'fmb.case_no = sph.case_no', 'left');
        }
        $this->db->where($clause);
        
        if (isset($_POST["search"]["value"])) {
            $s_value = $_POST['search']['value'];
            $query="(fmb.case_no like '%". $s_value."%' OR basundhara  LIKE '%" . $s_value."%' OR application_ref_no  LIKE '%" . $s_value."%')" ;
            $this->db->where($query);
        }

        if (isset($_POST["columns"][2]["search"]["value"])) {
            $s_value =$_POST["columns"][2]["search"]["value"];
            $query="(fmb.case_no like '%". $s_value."%' OR basundhara  LIKE '%" . $s_value."%' OR application_ref_no  LIKE '%" . $s_value."%')" ;
            $this->db->where($query);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('date_entry', 'DESC');
        }
    }

    function make_datatables($clause,$join=false) {
        $this->make_query($clause,$join);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data($clause,$join=false) {
        $this->make_query($clause,$join);
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        return $query->num_rows();
    }

    function get_all_data($clause,$join=false) {
        // $this->db->select("*");
        // $this->db->from($this->table);
        // $this->db->where($clause);
        $this->db->select('fmb.*,l.*');
        $this->db->distinct('fmb.noc_no');
        $this->db->from('petition_basic fmb');
        $this->db->join('landsale l', 'fmb.noc_no=l.appno and fmb.dist_code=l.distcode and fmb.subdiv_code=l.subcode and fmb.cir_code=l.circode','left');
        if($join == true){
            $this->db->join('sro_push_history sph', 'fmb.case_no = sph.case_no', 'left');
        }
        
        $this->db->where($clause);
        return $this->db->count_all_results();
    }
    function make_query_com($clause) {
        $this->db->select('fmb.*,l.*');
        $this->db->distinct('fmb.noc_no');
        $this->db->from('petition_basic fmb');
        $this->db->join('landsale l', 'fmb.noc_no=l.appno and fmb.dist_code=l.distcode and fmb.subdiv_code=l.subcode and fmb.cir_code=l.circode','left');
        $this->db->where($clause);
        $this->db->order_by('date_entry', 'DESC');
       log_message('error',"asdfawd".$this->db->last_query());

        if (isset($_POST["search"]["value"])) {
            $s_value = $_POST['search']['value'];
            // $query="(case_no like '%". $s_value."%')" ;
            $query="(case_no like '%". $s_value."%' or noc_no like '%".$s_value."%')" ;
            $this->db->where($query);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('date_entry', 'DESC');
        }
    }

    function make_datatables_com($clause) {
        $this->make_query_com($clause);

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function make_datatables_com_final($clause) {
        $this->make_query_com_final($clause);

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        

        return $query->result();
    }

    function make_query_com_final($clause) {
        $this->db->select('p.*,sn.nocno');
        $this->db->distinct('p.noc_no');
        $this->db->from('petition_basic p');
        $this->db->join('sro_note sn', 'p.noc_no=sn.nocno and p.dist_code=sn.dist_code and p.subdiv_code=sn.subdiv_code and p.cir_code=sn.cir_code and p.mouza_pargona_code=sn.mouza_pargona_code and p.lot_no=sn.lot_no and p.vill_townprt_code=sn.vill_townprt_code','left');
        $this->db->join('landsale l', 'p.noc_no=l.appno and p.dist_code=l.distcode and p.subdiv_code=l.subcode and p.cir_code=l.circode','left');
        $this->db->where($clause);
        $this->db->order_by('date_entry', 'DESC');
       log_message('error',"asdfawd".$this->db->last_query());
        if (isset($_POST["search"]["value"])) {
            $s_value = $_POST['search']['value'];
            $query="(case_no like '%". $s_value."%' or noc_no like '%".$s_value."%')" ;
            $this->db->where($query);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('date_entry', 'DESC');
        }
    }

    function make_query_final($clause) {
        $this->db->select('p.*,sn.nocno');
        $this->db->distinct('p.noc_no');
        $this->db->from('petition_basic p');
        $this->db->join('sro_note sn', 'p.noc_no=sn.nocno and p.dist_code=sn.dist_code and p.subdiv_code=sn.subdiv_code and p.cir_code=sn.cir_code and p.mouza_pargona_code=sn.mouza_pargona_code and p.lot_no=sn.lot_no and p.vill_townprt_code=sn.vill_townprt_code','left');
        $this->db->join('landsale l', 'p.noc_no=l.appno and p.dist_code=l.distcode and p.subdiv_code=l.subcode and p.cir_code=l.circode','left');
        $this->db->where($clause);
        $this->db->order_by('date_entry', 'DESC');
   

        if (isset($_POST["search"]["value"])) {
            $s_value = $_POST['search']['value'];
            $query="(case_no like '%". $s_value."%')" ;
            $this->db->where($query);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('date_entry', 'DESC');
        }
    }

     function get_filtered_data_final($clause) {
        $this->make_query_final($clause);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data_final($clause) {
        $this->db->select('p.*,sn.nocno');
        $this->db->distinct('p.noc_no');
        $this->db->from('petition_basic p');
        $this->db->join('sro_note sn', 'p.noc_no=sn.nocno and p.dist_code=sn.dist_code and p.subdiv_code=sn.subdiv_code and p.cir_code=sn.cir_code and p.mouza_pargona_code=sn.mouza_pargona_code and p.lot_no=sn.lot_no and p.vill_townprt_code=sn.vill_townprt_code','left');
        $this->db->join('landsale l', 'p.noc_no=l.appno and p.dist_code=l.distcode and p.subdiv_code=l.subcode and p.cir_code=l.circode','left');
        $this->db->where($clause);
        //log_message('error',"AllData001".$this->db->last_query());
        return $this->db->count_all_results();
    }
    public function caseInfoForAuthorization($case_no) {
        $sql = "SELECT * FROM petition_basic WHERE case_no = ?";
        $caseInfo = $this->db->query($sql, array($case_no))->row();
        return $caseInfo;

    }
}
