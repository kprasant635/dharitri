<?php class TicketCommonModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    // Ticket system code by Masud Reza (15/07/2024)
    //////////////// *************** **************** ////////////////

    // get all application
    public function getAllApplication()
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('status', 1)
            ->get('ticket_application_types');

        $this->offlineutility->dbSwitchSession();
        return $data->result();

    }

    // check application type
    public function checkApplicationTypeIdExistOrNot($appId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('id',$appId)
            ->get('ticket_application_types');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();

    }

    // check application type with status
    public function checkApplicationTypeIdExistOrNotWithStatus($appId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('id',$appId)
            ->where('status', 1)
            ->get('ticket_application_types');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }








    // get all Service Type with application id
    public function getServiceTypeWithAppId($appId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('status', 1)
            ->where('app_id', $appId)
            ->get('ticket_service_type');

        $this->offlineutility->dbSwitchSession();
        return $data->result();
    }

    // check Service Type
    public function checkTicketServiceTypeExistOrNotWithStatus($appId,$serviceId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('app_id',$appId)
            ->where('id',$serviceId)
            ->where('status', 1)
            ->get('ticket_service_type');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }
















    // get all ticket type
    public function getAllTicketType()
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('status',1)
            ->get('ticket_type');

        $this->offlineutility->dbSwitchSession();
        return $data->result();

    }

    // get all service type with join without status
    public function getAllServiceTypeWithOutStatus()
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $this->db->select('ticket_service_type.*,ticket_application_types.application_name');
        $this->db->from('ticket_service_type');
        $this->db->join('ticket_application_types','ticket_application_types.id = ticket_service_type.app_id');
        $this->db->order_by('ticket_service_type.app_id','asc');
        $ticketCategory = $this->db->get();
        return $ticketCategory->result();
    }

    // check Ticket Type / category
    public function checkTicketCategoryExistOrNotWithStatus($appId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $data = $this->db->select()
            ->where('id',$appId)
            ->where('status', 1)
            ->get('ticket_type');

        $this->offlineutility->dbSwitchSession();
        return $data->num_rows();
    }



    // get document with file id
    public function getTicketDocWithFileId($fileId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $docs = $this->db->select()
            ->where('id',$fileId)
            ->where('status',1)
            ->get('technical_ticket_attachment');

        $this->offlineutility->dbSwitchSession();
        return $docs->row();
    }



    // get comment document  with file id
    public function getTicketCommentDocWithFileId($fileId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $docs = $this->db->select()
            ->where('id',$fileId)
            ->where('status',1)
            ->get('technical_ticket_comment');

        $this->offlineutility->dbSwitchSession();
        return $docs->row();
    }





    // count ticket service wise
    public function countTicketServiceWise($appId,$serId,$dist_code)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        return $this->db->select()
            ->where('t_app_type_id',$appId)
            ->where('t_service_id',$serId)
            ->where('dist_code',$dist_code)
            ->where('status',1)
            ->get('technical_ticket_details')
            ->num_rows();
    }


    // count ticket service wise with sub div
    public function countTicketServiceWiseWithSubDiv($appId,$serId,$dist_code,$subdiv_code)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        return $this->db->select()
            ->where('t_app_type_id',$appId)
            ->where('t_service_id',$serId)
            ->where('dist_code',$dist_code)
            ->where('subdiv_code',$subdiv_code)
            ->where('status',1)
            ->get('technical_ticket_details')
            ->num_rows();
    }


    // count all ticket
    public function countAllTicketForReport()
    {
        if($this->session->userdata('user_desig_code') ==  MB_SUB_DIV_COMM)
        {
            $dist_code    = trim($this->session->userdata('dist_code'));
            $subdiv_code  = trim($this->session->userdata('subdiv_code'));
            $this->db     = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('dist_code',$dist_code)
                ->where('subdiv_code',$subdiv_code)
                ->where('status',1)
                ->get('technical_ticket_details')
                ->num_rows();
        }
        else
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $this->db  = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('dist_code',$dist_code)
                ->where('status',1)
                ->get('technical_ticket_details')
                ->num_rows();
        }

    }

    // count all In Queue ticket
    public function countAllInQueueTicketForReport()
    {
        if($this->session->userdata('user_desig_code') ==  MB_SUB_DIV_COMM)
        {
            $dist_code   = trim($this->session->userdata('dist_code'));
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db    = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_PENDING)
                ->where('pending_with',TICKET_SYSTEM_NIC)
                ->where('status',1)
                ->where('a_status',1)
                ->where('dist_code',$dist_code)
                ->where('subdiv_code',$subdiv_code)
                ->get('technical_ticket_details')
                ->num_rows();
        }
        else
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $this->db  = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_PENDING)
                ->where('pending_with',TICKET_SYSTEM_NIC)
                ->where('status',1)
                ->where('a_status',1)
                ->where('dist_code',$dist_code)
                ->get('technical_ticket_details')
                ->num_rows();
        }

    }


    // count all Closed ticket
    public function countAllClosedTicketForReport()
    {
        if($this->session->userdata('user_desig_code') ==  MB_SUB_DIV_COMM)
        {
            $dist_code   = trim($this->session->userdata('dist_code'));
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_CLOSED)
                ->where('status',1)
                ->where('dist_code',$dist_code)
                ->where('subdiv_code',$subdiv_code)
                ->get('technical_ticket_details')
                ->num_rows();
        }
        else
        {
            $dist_code   = trim($this->session->userdata('dist_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_CLOSED)
                ->where('status',1)
                ->where('dist_code',$dist_code)
                ->get('technical_ticket_details')
                ->num_rows();
        }

    }



    // count all Rejected ticket
    public function countAllRejectedTicketForReport()
    {
        if($this->session->userdata('user_desig_code') ==  MB_SUB_DIV_COMM)
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_REJECTED)
                ->where('status',1)
                ->where('dist_code',$dist_code)
                ->where('subdiv_code',$subdiv_code)
                ->get('technical_ticket_details')
                ->num_rows();

        }
        else
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_REJECTED)
                ->where('status',1)
                ->where('dist_code',$dist_code)
                ->get('technical_ticket_details')
                ->num_rows();

        }
    }


    // count all pending  ticket
    public function countAllPendingTicketForReport()
    {
        if($this->session->userdata('user_desig_code') ==  MB_SUB_DIV_COMM)
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_PENDING)
                ->where('pending_with',TICKET_SYSTEM_NIC)
                ->where('status',1)
                ->where('a_status',0)
                ->where('dist_code',$dist_code)
                ->where('subdiv_code',$subdiv_code)
                ->get('technical_ticket_details')
                ->num_rows();

        }
        else
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_PENDING)
                ->where('pending_with',TICKET_SYSTEM_NIC)
                ->where('status',1)
                ->where('a_status',0)
                ->where('dist_code',$dist_code)
                ->get('technical_ticket_details')
                ->num_rows();
        }

    }



    // count all processing ticket
    public function countAllProcessingTicketForReport()
    {
        if($this->session->userdata('user_desig_code') ==  MB_SUB_DIV_COMM)
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_PENDING)
                ->where('pending_with',TICKET_SYSTEM_NIC)
                ->where('status',1)
                ->where('a_status',2)
                ->where('dist_code',$dist_code)
                ->where('subdiv_code',$subdiv_code)
                ->get('technical_ticket_details')
                ->num_rows();

        }
        else
        {
            $dist_code = trim($this->session->userdata('dist_code'));
            $this->db = $this->load->database('ticket_sys', TRUE);
            return $this->db->select()
                ->where('ticket_status',TICKET_STATUS_PENDING)
                ->where('pending_with',TICKET_SYSTEM_NIC)
                ->where('status',1)
                ->where('a_status',2)
                ->where('dist_code',$dist_code)
                ->get('technical_ticket_details')
                ->num_rows();
        }

    }



    // get service type details with id
    public function getServiceTypeDetailsWithId($serviceId)
    {
        $this->db = $this->load->database('ticket_sys', TRUE);
        $this->db->select('ticket_service_type.*,ticket_application_types.application_name');
        $this->db->from('ticket_service_type');
        $this->db->join('ticket_application_types','ticket_application_types.id = ticket_service_type.app_id');
        $this->db->where('ticket_service_type.id',$serviceId);
        $ticketCategory = $this->db->get();
        return $ticketCategory;
    }



    public function get_client_ip(){
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //if user is from the proxy
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // if user from the share internet
            return $_SERVER['HTTP_CLIENT_IP'];
        }else{
            //if user is from the remote address
            return $_SERVER['REMOTE_ADDR'];
        }

    }

}