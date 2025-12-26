<?php

class COFieldMutationModel extends CI_Model {

    var $base_query;
    var $dist_code;
    var $subdiv_code;
    var $cir_code;

    public function __construct() {
        parent::__construct();
        $location = $this->utilityclass->getLocationFromSession();
        $this->dist_code = $location['dist_code'];
        $this->subdiv_code = $location['subdiv_code'];
        $this->cir_code = $location['cir_code'];
		$db=  $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
        $this->base_query = "dist_code = '$this->dist_code' and subdiv_code ='$this->subdiv_code'  and cir_code ='$this->cir_code'   ";
    }

    public function getPendingFMCases() {
		     $db=  $this->session->userdata('db');
        //$CI = & get_instance();
		$db=  $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $q = "select * from   field_mut_basic where order_passed is null and date_entry>='$define_date' and is_dispose is null "
                . "and  mut_type='01'  and dist_code='$this->dist_code' and subdiv_code='$this->subdiv_code' "
                . " and cir_code='$this->cir_code' order by date_entry desc ";

        $cases = $this->db->query($q, array('01'));

        //echo $q;
        $cases = $this->db->query($q, array('01'));
        return $cases;
    }

    public function getPendingPartitionCases() {
		$db=  $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $q = "select * from   field_mut_basic where order_passed is null   and date_entry>='$define_date' and is_dispose is null "
                . "and mut_type='02' and " . $append . "  ORDER BY petition_no desc ";


        $cases = $this->db->query($q, array('02'));


        $cases = $this->db->query($q, array('02', $this->dist_code, $this->subdiv_code, $this->cir_code));

        return $cases;
    }

    public function countPendingMutationCases($dist_code, $subdiv_code, $cir_code) {
		     $db=  $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
		$db=  $this->session->userdata('db');
        return $this->db->query("select count(*) as count from   field_mut_basic where order_passed"
                        . " is null and is_dispose is null and date_entry>='$define_date' "
                        . "and  mut_type='01' and dist_code=? and "
                        . "subdiv_code=? and cir_code=?", array($this->dist_code, $this->subdiv_code, $this->cir_code))->row()->count;
    }

    public function countPendingPartitionCases($dist_code, $subdiv_code, $cir_code) {
		     $db=  $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
		$db=  $this->session->userdata('db');
        $q = "select count(*) as count from   field_mut_basic where order_passed is null "
                . "and is_dispose is null and date_entry>='$define_date'"
                . "and mut_type='02' and dist_code=? and "
                . "subdiv_code=? and cir_code=?";
        // echo $q;
        //echo $this->dist_code;
        return $this->db->query($q, array($this->dist_code, $this->subdiv_code, $this->cir_code))->row()->count;
    }

    public function getSkNote($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1) {
        $define_date = define_date;
		$db=  $this->session->userdata('db');
        $q = "select * from   field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and case_no='$case_no' ";
        $data = $this->db->query($q)->row();
        $year_no = year_no;
        
        $q = "select dag_no,sk_note from   field_mut_dag_details d, field_mut_basic b where d.dist_code = b.dist_code and d.subdiv_code = b.subdiv_code and "
                . "d.cir_code = b.cir_code and d.mouza_pargona_code = b.mouza_pargona_code and d.lot_no = b.lot_no and d.vill_townprt_code = b.vill_townprt_code "
                . "and d.case_no=b.case_no and b.dist_code = '$dist_code' and b.subdiv_code = '$subdiv_code' and b.cir_code='$cir_code' and "
                . "b.mouza_pargona_code='$mouza_pargona_code1' and b.lot_no='$lot_no1' and b.vill_townprt_code='$vill_townprt_code1' and "
                . "b.case_no='$case_no' and b.date_entry>='$define_date' ";

        $data = $this->db->query($q, array($case_no, $case_no))->result();
        //var_dump($data);
        return $data;
    }
    
    public function getSkNoteOfficeMutation($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1) {
		     $db=  $this->session->userdata('db');
        $define_date = define_date;
		$db=  $this->session->userdata('db');
        $q = "select * from   petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and case_no='$case_no' ";
        $data = $this->db->query($q)->row();
        $year_no = year_no;
        
        $dag_no = $this->db->query("select dag_no as dag_no from   petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and petition_no='$data->petition_no'")->row()->dag_no; 
        
        $q = "select dag_no,sk_note,dispute,sk_note_date from   petition_lm_note where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and "
                . "dag_no='$dag_no' and petition_no='$data->petition_no' ";

        $data = $this->db->query($q, array($case_no, $case_no))->result();
        return $data;
    }

}
