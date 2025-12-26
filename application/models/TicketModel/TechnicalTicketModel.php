<?php class TechnicalTicketModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    // Ticket system code by Masud Reza (15/07/2024)
    //////////////// *************** **************** ////////////////

    // Case no using sequence
    function generateCaseName($dist_code,$subdiv_code,$cir_code)
    {
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }

    // Case no using sequence
    function generateCaseName2($dist_code)
    {
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr from location where dist_code='$dist_code'";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr. "/".$dist_code;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }


    function generateTicketSqNo()
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $sq_no = $this->db->query("select nextval('technical_ticket_details_id_seq') as count ")->row();

        $this->offlineutility->dbSwitchSession();
        return $sq_no->count;
    }




    // count  my pending ticket only CO
    public function countPendingTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,$tStatus)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('user_code',$user_code)
            ->where('created_by',$userDegCode)
            ->where('ticket_status',$tStatus)
            ->where('status',1)
            ->get('technical_ticket_details');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }


    // get all ticket with status only CO
    public function allPendingTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,$tStatus)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.dist_code',$dist_code);
        $this->db->where('technical_ticket_details.subdiv_code',$subdiv_code);
        $this->db->where('technical_ticket_details.cir_code',$cir_code);
        $this->db->where('technical_ticket_details.user_code',$user_code);
        $this->db->where('technical_ticket_details.created_by',$userDegCode);
        $this->db->where('technical_ticket_details.ticket_status',$tStatus);
        $this->db->where('technical_ticket_details.status',1);
        $this->db->order_by('technical_ticket_details.id','asc');
        $data = $this->db->get();

        $this->offlineutility->dbSwitchSession();
        return $data->result();
    }



    // count ticket details by only ticket id
    public function countTicketDetailsByIdOnlyDistAndTid($tId,$distCode)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('ticket_id',$tId)
            ->where('dist_code',$distCode)
            ->where('status',1)
            ->get('technical_ticket_details');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }


    // count ticket details by ticket id
    public function countTicketDetailsById($tId,$distCode,$userCode)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('ticket_id',$tId)
            ->where('dist_code',$distCode)
            ->where('user_code',$userCode)
            ->where('status',1)
            ->get('technical_ticket_details');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }

    // get ticket details by ticket id
    public function getOnlyTicketDetailsById($tId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('ticket_id',$tId)
            ->where('dist_code',trim($this->session->userdata('dist_code')))
            ->where('status',1)
            ->get('technical_ticket_details');

        $this->offlineutility->dbSwitchSession();
        return $data->row();
    }


    // get ticket details by ticket id
    public function getTicketDetailsById($tId,$distCode,$userCode)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.ticket_id',$tId);
        $this->db->where('technical_ticket_details.dist_code',$distCode);
        $this->db->where('technical_ticket_details.user_code',$userCode);
        $this->db->where('technical_ticket_details.status',1);
        $data = $this->db->get();

        $this->offlineutility->dbSwitchSession();
        return $data->row();
    }


    // get ticket details by only ticket id
    public function getTicketDetailsByIdOnlyTid($tId,$distCode)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);

        $this->db->select('technical_ticket_details.*,ticket_service_type.service_name,ticket_application_types.application_name');
        $this->db->from('technical_ticket_details');
        $this->db->join('ticket_application_types','ticket_application_types.id=technical_ticket_details.t_app_type_id');
        $this->db->join('ticket_service_type','ticket_service_type.id=technical_ticket_details.t_service_id');
        $this->db->where('technical_ticket_details.ticket_id',$tId);
        $this->db->where('technical_ticket_details.dist_code',$distCode);
        $this->db->where('technical_ticket_details.status',1);
        $data = $this->db->get();

        $this->offlineutility->dbSwitchSession();
        return $data->row();
    }



    // get ticket history by ticket id
    public function getTicketHistoryById($tId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('ticket_id',$tId)
            ->where('status',1)
            ->order_by('id','desc')
            ->get('technical_ticket_history');

        $this->offlineutility->dbSwitchSession();
        return $data->result();
    }


    // get ticket history by ticket id
    public function getTicketDocumentById($tId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('ticket_id',$tId)
            ->where('status',1)
            ->order_by('id','asc')
            ->get('technical_ticket_attachment');

        $this->offlineutility->dbSwitchSession();
        return $data->result();
    }

    // get ticket Comment by ticket id
    public function getTicketCommentById($tId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('ticket_id',$tId)
            ->where('status',1)
            ->order_by('id','desc')
            ->get('technical_ticket_comment');

        $this->offlineutility->dbSwitchSession();
        return $data->result();
    }




    // count  my pending ticket only CO
    public function countClosedTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,$tStatus)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('user_code',$user_code)
            ->where('created_by',$userDegCode)
            ->where('ticket_status',$tStatus)
            ->where('status',1)
            ->get('technical_ticket_details');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }



    // count  my pending ticket only CO
    public function countRejectedTicketForCo($dist_code,$subdiv_code,$cir_code,$user_code,$userDegCode,$tStatus)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code',$cir_code)
            ->where('user_code',$user_code)
            ->where('created_by',$userDegCode)
            ->where('ticket_status',$tStatus)
            ->where('status',1)
            ->get('technical_ticket_details');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }





}