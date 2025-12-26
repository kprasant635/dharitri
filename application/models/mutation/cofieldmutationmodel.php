<?php

class COFieldMutationModel extends CI_Model
{

    var $base_query;
    var $dist_code;
    var $subdiv_code;
    var $cir_code;

    public function __construct()
    {
        parent::__construct();
        $location = $this->utilityclass->getLocationFromSession();
        $this->dist_code = $location['dist_code'];
        $this->subdiv_code = $location['subdiv_code'];
        $this->cir_code = $location['cir_code'];
        $db = $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
        $this->base_query =
            "dist_code = '{$this->dist_code}'
             AND subdiv_code = '{$this->subdiv_code}'
             AND cir_code = '{$this->cir_code}'";
        $this->load->model('Escalationmodel');
    }

    public function getPendingFMCases_before_pagination()
    {
        $db = $this->session->userdata('db');
        //$CI = & get_instance();
        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code'";
        $cases = $this->db->query($q, array('01'));
        return $cases;
    }
    public function getPendingFMCasesOLDD($start, $limit, $key = null)
    {
        $db = $this->session->userdata('db');
        //$CI = & get_instance();
        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $casesl = array();
        if ($key) {
            if (ESCALATION_ENABLE == 1) {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";
            } else {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";
            }

            $cases = $this->db->query($q)->result();
        } else {
            if (ESCALATION_ENABLE == 1) {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
            } else {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
            }

            $cases = $this->db->query($q)->result();
        }

        // ESCALATION VIEW FORMAT TO SHOW ZONES
        if (ESCALATION_ENABLE == 1) {
            $caseList = $this->Escalationmodel->getEscaltionViewFormat($cases);
        }


        log_message('error', $this->db->last_query());
        /*foreach ($cases as $c) {
            $q = $this->db->query("select count(consent) from copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($cases, $c);
        }
        return $cases;*/
        $final_cases = array();
        foreach ($cases as $c) {
            $q = $this->db->query("select count(consent) from copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($final_cases, $c);
        }
        return $final_cases;
    }

    public function getPendingFMCases($start, $limit, $key = null)
    {
        //$CI = & get_instance();
        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $casesl = array();
        if ($key) {
            if (ESCALATION_ENABLE == 1) {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and es_flag=0 and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";

                $case_list = $this->db->query($q)->result();
                $q1 = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.es_flag=1 and fmb.lm_note is not null and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";

                $case_list1 = $this->db->query($q1)->result();
                $cases = array_merge($case_list, $case_list1);
            } else {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";
                $cases = $this->db->query($q)->result();
            }
        } else {
            if (ESCALATION_ENABLE == 1) {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and es_flag=0 and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
                $case_list = $this->db->query($q)->result();
                $q1 = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and es_flag=1 and lm_note is not null and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";

                $case_list1 = $this->db->query($q1)->result();
                $cases = array_merge($case_list, $case_list1);

            } else {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
                $cases = $this->db->query($q)->result();
            }


        }

        // ESCALATION VIEW FORMAT TO SHOW ZONES
        if (ESCALATION_ENABLE == 1) {
            $caseList = $this->Escalationmodel->getEscaltionViewFormat($cases);
        }


        log_message('error', $this->db->last_query());
        /*foreach ($cases as $c) {
            $q = $this->db->query("select count(consent) from copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($cases, $c);
        }
        return $cases;*/
        $final_cases = array();
        foreach ($cases as $c) {
            $q = $this->db->query("select count(consent) from copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($final_cases, $c);
        }
        return $final_cases;
    }
    public function getPendingPartitionCases()
    {
        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $q = "select *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' ";


        $cases = $this->db->query($q, array('02'));


        $cases = $this->db->query($q, array('02', $this->dist_code, $this->subdiv_code, $this->cir_code));

        return $cases;
    }

    public function countPendingMutationCases($dist_code, $subdiv_code, $cir_code)
    {
        $db = $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
        $db = $this->session->userdata('db');

        if (ESCALATION_ENABLE == 1) {
            $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and es_flag=0 and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code'";
            $case_list = $this->db->query($q)->result();
            $q1 = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and fmb.date_entry>='$define_date' 
                and fmb.is_dispose is null and fmb.mut_type='01' and es_flag=1 and lm_note is not null and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code'";

            $case_list1 = $this->db->query($q1)->result();
            $cases = array_merge($case_list, $case_list1);
            return count($cases);
        } else {
            return $this->db->query("select count(*) as count from   field_mut_basic where order_passed"
                . " is null and is_dispose is null and date_entry>='$define_date' "
                . "and  mut_type='01' and dist_code=? and "
                . "subdiv_code=? and cir_code=?", array($this->dist_code, $this->subdiv_code, $this->cir_code))->row()->count;
        }




    }

    public function countPendingPartitionCases($dist_code, $subdiv_code, $cir_code)
    {
        $db = $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
        $db = $this->session->userdata('db');
        if (ESCALATION_ENABLE == 1) {
            $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and es_flag=0 and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code'";
            $case_list = $this->db->query($q)->result();
            $q1 = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and es_flag=1 and lm_note is not null and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code'";
            $case_list1 = $this->db->query($q1)->result();
            $cases = array_merge($case_list, $case_list1);

            return count($cases);
        } else {
            $q = "select count(*) as count from   field_mut_basic where order_passed is null "
                . "and is_dispose is null and date_entry>='$define_date'"
                . "and mut_type='02' and dist_code=? and "
                . "subdiv_code=? and cir_code=?";
            // echo $q;
            //echo $this->dist_code;
            return $this->db->query($q, array($this->dist_code, $this->subdiv_code, $this->cir_code))->row()->count;
        }


    }
    public function count_getPendingFMCases()
    {
        $db = $this->session->userdata('db');
        //$CI = & get_instance();
        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $q = "select count(*) as c from field_mut_basic fmb where fmb.order_passed is null and fmb.date_entry>='$define_date' 
and fmb.is_dispose is null and fmb.mut_type='01' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code'  ";
        $cases = $this->db->query($q)->row()->c;
        return $cases;
    }

    public function getSkNote($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1)
    {
        $define_date = define_date;
        $db = $this->session->userdata('db');
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

    public function getSkNoteOfficeMutation($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1)
    {
        $db = $this->session->userdata('db');
        $define_date = define_date;
        $db = $this->session->userdata('db');
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

    // Added by Abhijit -- 2024-04-29
    public function getSkNoteOfficeMutationMultiDag($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1)
    {
        $db = $this->session->userdata('db');
        $define_date = define_date;
        $db = $this->session->userdata('db');
        $q = "select * from   petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and case_no='$case_no' ";
        $data = $this->db->query($q)->row();
        $year_no = year_no;

        $dag_no = $this->db->query("select dag_no as dag_no from   petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and petition_no='$data->petition_no'")->result();

        $skNoteArray = array();
        foreach ($dag_no as $key => $value) {
            $q = "select dag_no,sk_note,dispute,sk_note_date from   petition_lm_note where dist_code = ? and subdiv_code = ? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and petition_no=?";

            $skNoteArray[] = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1, $value->dag_no, $data->petition_no))->row();
            // log_message('error','459 : '.json_encode($this->db->last_query()));
        }

        return $skNoteArray;
    }

    public function count_getPendingFPCases()
    {
        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        $q = "select count(*) as c from field_mut_basic fmb where fmb.order_passed is null and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code'  ";
        $cases = $this->db->query($q)->row()->c;
        return $cases;
    }
    public function getPendingFPCases($start, $limit, $key = null)
    {

        $db = $this->session->userdata('db');
        $append = $this->base_query;
        $define_date = define_date;
        $year_no = year_no;
        if ($key) {
            if (ESCALATION_ENABLE == 1) {

                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  fmb.order_passed is null and es_flag = 0 and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";
                $case_list = $this->db->query($q)->result();

                $q1 = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  fmb.order_passed is null and es_flag= 1 and lm_note is not null and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";
                $case_list1 = $this->db->query($q1)->result();

                $cases = array_merge($case_list, $case_list1);


            } else {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  fmb.order_passed is null and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' and (case_no like '%$key%' or ba.basundhara like '%$key%')  limit 10 offset 0 ";
                $cases = $this->db->query($q)->result();
            }

        } else {




            if (ESCALATION_ENABLE == 1) {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and es_flag=0 and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
                $case_list = $this->db->query($q)->result();


                $q1 = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and es_flag=1 and lm_note is not null and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
                $case_list1 = $this->db->query($q1)->result();

                $cases = array_merge($case_list, $case_list1);

            } else {
                $q = "select distinct on (case_no) *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.order_passed is null and es_flag=0 and fmb.date_entry>='$define_date' and fmb.is_dispose is null and fmb.mut_type='02' and fmb.dist_code='$this->dist_code' and fmb.subdiv_code='$this->subdiv_code' and fmb.cir_code='$this->cir_code' limit $start offset $limit ";
                $cases = $this->db->query($q)->result();
            }

        }

        $final_cases = array();
        foreach ($cases as $c) {
            $q = $this->db->query("select count(consent) from copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($final_cases, $c);
        }
        return $final_cases;
    }
    ///////////////////////////
    function verfiyChecking($case_no)
    {
        $sql = "Select * from petition_basic where case_no=? and mut_type='03' and status='P' ";
        $data = $this->db->query($sql, $case_no);
        if ($data->num_rows() == 0) {
            return 0;
        }
        $result = $data->row_array();
        ////////LM SK Verification Checking///////////
        $sql1 = "Select * from petition_lm_note where dist_code=?  and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and petition_no=? order by note_no ";
        $sql1_result = $this->db->query($sql1, array($result['dist_code'], $result['subdiv_code'], $result['cir_code'], $result['mouza_pargona_code'], $result['lot_no'], $result['vill_townprt_code'], $result['petition_no']));
        if ($sql1_result->num_rows() == 0) {
            return 0;
        }
        $lmnote = $sql1_result->row_array();
        if (empty($lmnote['lm_code'])) {
            return 0;
        }
        if (empty($lmnote['sk_note']) || empty($lmnote['sk_note_date'])) {
            return 0;
        }
        //////////LM SK End here////////////////
        return 1;
    }

    public function fetchTreeData($case_no)
    {
        $sql1 = "select  pdar_name as pat_name_ass,generation_type from field_mut_pattadar where case_no = ? ";
        $owner = $this->db->query($sql1, array($case_no))->row_array();


        $sql = "select pet_id,pdar_id,pet_name,next_of_pdar_id,generation_type as gen from field_mut_petitioner where case_no = ?";
        $mutation = $this->db->query($sql, array($case_no))->result_array();

        if ($owner['generation_type'] == "GGP") {

            //AT FIRST COLLECTING GRAND PARENT LIST
            $treeArray = array();
            foreach ($mutation as $key => $value) {
                if ($value['gen'] == "GP") {
                    // $treeArray['GP'][$key]=array($value['pdar_id']);
                    $treeArray['GP'][$key] = array($value['pet_id']);
                    $treeArray['GP'][$key][] = $value['pet_name'];
                }

            }

            // USING LOOP FINDING PARENT AGAINST GRAND PARENT AND PUSH TO NEWSUBARRAY
            if (!empty($treeArray['GP'])) {
                foreach ($treeArray['GP'] as $key1 => $value) {
                    $parentlist = null;
                    $ff = null;

                    $sql = "select  pet_id,pdar_id,pet_name from field_mut_petitioner
                    where next_of_pdar_id ='$value[0]' and case_no = '$case_no'";
                    $parentlist = $this->db->query($sql)->result_array();
                    // echo "<pre>";
                    // var_dump($parentlist);
                    // echo "<br>";
                    if (isset($parentlist) && !empty($parentlist)) {

                        foreach ($parentlist as $key11 => $value11) {
                            // $ff[$key11] = array($value11['pdar_id']);
                            $ff[$key11] = array($value11['pet_id']);
                            $ff[$key11][] = $value11['pet_name'];
                        }
                        $treeArray['GP'][$key1]['P'] = $ff;
                    }


                    // USING LOOP FINDING APPLICANT AGAINST PARENT AND PUSH TO NEWSUBARRAY
                    if (sizeof($treeArray['GP'][$key1]) > 2) {
                        foreach ($treeArray['GP'][$key1]['P'] as $key2 => $value2) {
                            $applicants = null;
                            $app = null;
                            $sql1 = "select  pet_id,pdar_id,pet_name from field_mut_petitioner
                        where next_of_pdar_id ='$value2[0]' and case_no = '$case_no'";
                            $applicants = $this->db->query($sql1)->result_array();
                            if (isset($applicants) && !empty($applicants)) {
                                foreach ($applicants as $key3 => $value3) {
                                    // $app[$key3] = array($value3['pdar_id']);
                                    $app[$key3] = array($value3['pet_id']);
                                    $app[$key3][] = $value3['pet_name'];
                                }
                                $treeArray['GP'][$key1]['P'][$key2]['A'] = $app;
                            }
                        }

                    }
                }
            }
        } else if ($owner['generation_type'] == "GP") {


            //for tree view in Front End-----
            $treeArray = array();
            //AT FIRST COLLECTING PARENT LIST
            foreach ($mutation as $key => $value) {
                if ($value['gen'] == "P") {
                    // $treeArray['P'][$key]=array($value['pdar_id']);
                    $treeArray['P'][$key] = array($value['pet_id']);
                    $treeArray['P'][$key][] = $value['pet_name'];
                }

            }


            // USING LOOP FINDING APPLICANT AGAINST PARENT AND PUSH TO NEWSUBARRAY
            if (!empty($treeArray['P'])) {
                foreach ($treeArray['P'] as $key1 => $value) {
                    $applicantListGP = null;
                    $newSubArray = null;

                    $sql = "select  pdar_id,pet_name from field_mut_petitioner
                    where next_of_pdar_id ='$value[0]' and case_no = '$case_no'";
                    if ($this->db->query($sql)->num_rows() > 0) {
                        $applicantListGP = $this->db->query($sql)->result_array();

                        if (isset($applicantListGP) && !empty($applicantListGP)) {

                            foreach ($applicantListGP as $key11 => $value11) {
                                // $newSubArray[$key11] = array($value11['pdar_id']);
                                $newSubArray[$key11] = array($value11['pet_id']);
                                $newSubArray[$key11][] = $value11['pet_name'];
                            }
                            $treeArray['P'][$key1]['A'] = $newSubArray;
                        }
                    }


                }
            }

        }

        $json = array(
            'tree' => $treeArray,
            'owner_pattadar' => $owner['pat_name_ass'],
            'generation_type' => $owner['generation_type']
        );
        return $json;
    }



    public function fetchTreeDataOffice($case_no)
    {
        $sqlBasic = "select  petition_no from petition_basic where case_no = ? ";
        $pb = $this->db->query($sqlBasic, array($case_no))->row_array();

        $case_no = $pb['petition_no'];
        $sql1 = "select  pdar_name as pat_name_ass,generation_type from petition_pattadar where petition_no = ? ";
        $owner = $this->db->query($sql1, array($case_no))->row_array();

        $sql = "select pet_id,pdar_id,pet_name,next_of_pdar_id,generation_type as gen from petitioner where petition_no = ?";
        $mutation = $this->db->query($sql, array($case_no))->result_array();

        $treeArray = []; // Added By Abhijit --2024-02-29

        if ($owner['generation_type'] == "GGP") {

            //AT FIRST COLLECTING GRAND PARENT LIST
            $treeArray = array();
            foreach ($mutation as $key => $value) {
                if ($value['gen'] == "GP") {
                    // $treeArray['GP'][$key]=array($value['pdar_id']);
                    $treeArray['GP'][$key] = array($value['pet_id']);
                    $treeArray['GP'][$key][] = $value['pet_name'];
                }

            }

            // USING LOOP FINDING PARENT AGAINST GRAND PARENT AND PUSH TO NEWSUBARRAY
            if (!empty($treeArray['GP'])) {
                foreach ($treeArray['GP'] as $key1 => $value) {
                    $parentlist = null;
                    $ff = null;

                    $sql = "select  pet_id,pdar_id,pet_name from petitioner
                    where next_of_pdar_id ='$value[0]' and case_no = '$case_no'";
                    $parentlist = $this->db->query($sql)->result_array();
                    // echo "<pre>";
                    // var_dump($parentlist);
                    // echo "<br>";
                    if (isset($parentlist) && !empty($parentlist)) {

                        foreach ($parentlist as $key11 => $value11) {
                            // $ff[$key11] = array($value11['pdar_id']);
                            $ff[$key11] = array($value11['pet_id']);
                            $ff[$key11][] = $value11['pet_name'];
                        }
                        $treeArray['GP'][$key1]['P'] = $ff;
                    }


                    // USING LOOP FINDING APPLICANT AGAINST PARENT AND PUSH TO NEWSUBARRAY
                    if (sizeof($treeArray['GP'][$key1]) > 2) {
                        foreach ($treeArray['GP'][$key1]['P'] as $key2 => $value2) {
                            $applicants = null;
                            $app = null;
                            $sql1 = "select pet_id,pdar_id,pet_name from petitioner
                        where next_of_pdar_id ='$value2[0]' and case_no = '$case_no'";
                            $applicants = $this->db->query($sql1)->result_array();
                            if (isset($applicants) && !empty($applicants)) {
                                foreach ($applicants as $key3 => $value3) {
                                    // $app[$key3] = array($value3['pdar_id']);
                                    $app[$key3] = array($value3['pet_id']);
                                    $app[$key3][] = $value3['pet_name'];
                                }
                                $treeArray['GP'][$key1]['P'][$key2]['A'] = $app;
                            }
                        }

                    }
                }
            }
        } else if ($owner['generation_type'] == "GP") {


            //for tree view in Front End-----
            $treeArray = array();
            //AT FIRST COLLECTING PARENT LIST
            foreach ($mutation as $key => $value) {
                if ($value['gen'] == "P") {
                    // $treeArray['P'][$key]=array($value['pdar_id']);
                    $treeArray['P'][$key] = array($value['pet_id']);
                    $treeArray['P'][$key][] = $value['pet_name'];
                }

            }


            // USING LOOP FINDING APPLICANT AGAINST PARENT AND PUSH TO NEWSUBARRAY
            if (!empty($treeArray['P'])) {
                foreach ($treeArray['P'] as $key1 => $value) {
                    $applicantListGP = null;
                    $newSubArray = null;

                    $sql = "select  pdar_id,pet_name from petitioner
                    where next_of_pdar_id ='$value[0]' and case_no = '$case_no'";
                    if ($this->db->query($sql)->num_rows() > 0) {
                        $applicantListGP = $this->db->query($sql)->result_array();

                        if (isset($applicantListGP) && !empty($applicantListGP)) {

                            foreach ($applicantListGP as $key11 => $value11) {
                                // $newSubArray[$key11] = array($value11['pdar_id']);
                                $newSubArray[$key11] = array($value11['pet_id']);
                                $newSubArray[$key11][] = $value11['pet_name'];
                            }
                            $treeArray['P'][$key1]['A'] = $newSubArray;
                        }
                    }


                }
            }

        }

        $json = array(
            'tree' => $treeArray,
            'owner_pattadar' => $owner['pat_name_ass'],
            'generation_type' => $owner['generation_type']
        );
        return $json;
    }

    public function getSkNoteOfficeMutationMultiGen($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1)
    {
        $db = $this->session->userdata('db');
        $define_date = define_date;
        $db = $this->session->userdata('db');
        $q = "select * from   petition_basic where dist_code=? and subdiv_code= ? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and case_no=?";
        $data = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1, $case_no))->row();
        $year_no = year_no;
        $dag_no = $this->db->query("select dag_no as dag_no from   petition_dag_details where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and petition_no=?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1, $data->petition_no))->result();

        $skNoteArray = array();
        foreach ($dag_no as $key => $value) {
            $q = "select dag_no,sk_note,dispute,sk_note_date from   petition_lm_note where dist_code = ? and subdiv_code = ? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and petition_no=?";

            $skNoteArray[] = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1, $value->dag_no, $data->petition_no))->row();
            // log_message('error','459 : '.json_encode($this->db->last_query()));
        }
        return $skNoteArray;
    }

    function pushSroNgdrsApi()
    {
        $dharitree = $this->input->get('case_no');
        $basundhara = $this->input->get('app');
        $sql = $this->db->query("select * from field_mut_basic where case_no=?", array($dharitree))->row();

        $deed_no = $sql->reg_deed_no;
        $dist_code = $sql->dist_code;
        $subdiv_code = $sql->subdiv_code;
        $cir_code = $sql->cir_code;
        $mouza_pargona_code = $sql->mouza_pargona_code;
        $lot_no = $sql->lot_no;
        $vill_townprt_code = $sql->vill_townprt_code;
        $location = $dist_code . '_' . $subdiv_code . '_' . $cir_code . '_' . $mouza_pargona_code . '_' . $lot_no . '_' . $vill_townprt_code;

        $user_code = $this->session->userdata('user_code');
        $co_name = $this->db->query("select username from users where user_code=? and dist_code= ? and subdiv_code = ? and cir_code = ?", array($user_code, $dist_code, $subdiv_code, $cir_code))->row();

        $co_name = $co_name->username;


        $sro_history = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'case_no' => $dharitree,
            'deed_no' => $deed_no,
            'status' => 'S',
            'action' => 'F',
            'user_code' => $user_code,
            'date_of_creation' => date('Y-m-d G:i:s'),
            'client_ip' => $this->utilityclass->get_client_ip()
        );
        $sro_push = $this->db->insert('sro_push_history', $sro_history);

        if ($sro_push != 1) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SROPUSH001)");
            redirect(base_url() . "index.php/home");
        } else {

            $slno = $this->db->insert_id();

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, NGDRS_SRO_NOTE_API_POST);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
                "search_value" => $deed_no,
                "dist_code" => $dist_code,
                "co_name" => $co_name,
                "case_no" => $dharitree,
                "location" => $location,
                "slno" => $slno
            )));
            $data = curl_exec($curl_handle);
            return $data;
        }
    }
}
