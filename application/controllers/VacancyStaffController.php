<?php

class VacancyStaffController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();


        $location    = $this->utilityclass->getLocationFromSession();
        $dist_code   = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code    = $location['cir_code'];
        $define_date = define_date;
        $year_no     = year_no;
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('UtilsModel');


    }


    // by Masud Reza 19/01/2024

    // User check
    public function checkLoginUserAuthorization($uCode)
    {
        $process = 1;
        if ($this->session->userdata('user_desig_code') != $uCode)
        {
            $this->session->set_flashdata('message', " You are not authorized !");
            redirect(base_url() . "index.php/Home/index");
        }

        return $process;
    }


    // 1 LRS // 2 LRA


    // get Supervisor Staff page
    public function getVacancyOfLrStaffPageLrs()
    {
        $uCode = MB_ADD_DEPUTY_COMM;
        $this->checkLoginUserAuthorization($uCode);
        $dist_code = trim($this->session->userdata('dist_code'));

        $vacPositionLRS = $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('type', 1)
            ->where('status', 1)
            ->get('vacancy_of_lr');

        $data = [
            'vacPositionLRSS' => $vacPositionLRS->result(),
            'vacPositionLRSCount' => $vacPositionLRS->num_rows(),
        ];

        $data['_view'] = 'VacancyOfStaff/vacancy_of_lrs_staff_view_page';
        $this->load->view('layouts/main', $data);
    }


    // save Supervisor Staff
    public function saveVacancySupervisor()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('open_category', 'Category', 'trim|required');
        $this->form_validation->set_rules('roster_point', 'Roster Point', 'trim|required|min_length[2]|max_length[190]');
        $this->form_validation->set_rules('lr_name', 'Name of LRS', 'trim|required|min_length[2]|max_length[190]');
        $this->form_validation->set_rules('date_of_joining', 'Date of Joining', 'required');
        $this->form_validation->set_rules('date_of_superannuation', 'Date of Superannuation', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLrs");
        }

        $date_of_joining        = $this->input->post('date_of_joining');
        $date_of_superannuation = $this->input->post('date_of_superannuation');

        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_of_joining))
        {
            $this->session->set_flashdata('error', '#MRVR001:  Kindly enter valid Date of Joining');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLrs");
        }
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_of_superannuation))
        {
            $this->session->set_flashdata('error', '#MRVR001:  Kindly enter valid Date of Superannuation');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLrs");
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $subdiv_code     = trim($this->session->userdata('subdiv_code'));
        $user_code       = trim($this->session->userdata('user_code'));
        $type            = 1; // LRS
        $open_category   = trim($this->input->post('open_category'));
        $roster_point    = trim($this->input->post('roster_point'));
        $lr_name         = trim($this->input->post('lr_name'));
        $remarks         = trim($this->input->post('remarks'));

        $insData = [
            'dist_code'              => $dist_code,
            'subdiv_code'            => $subdiv_code,
            'type'                   => $type,
            'open_category'          => $open_category,
            'roster_point'           => $roster_point,
            'lr_name'                => $lr_name,
            'date_of_joining'        => $date_of_joining,
            'date_of_superannuation' => $date_of_superannuation,
            'status'                 => 1,
            'remarks'                => $remarks,
            'created_by'             => $user_desig_code,
            'user_code'              => $user_code,
            'created_at'             => date('Y-m-d h:i:s'),
        ];


        $this->db->trans_begin();
        $saveD = $this->db->insert('vacancy_of_lr', $insData);
        if($saveD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVR002: Insertion failed in vacancy_of_lr ');
            $this->session->set_flashdata('error', '#MRVR001:  There is some problem, Please Contact Administration');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLrs");

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Vacancy of LRS staff successfully submit');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLrs");
        }

    }


    // report download for Supervisor
    public function getVacancyOfLrsStaffReport()
    {
        $uCode = MB_ADD_DEPUTY_COMM;
        $this->checkLoginUserAuthorization($uCode);

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $filename        = time()."_LR_Staff_Supervisor.xlsx";

        $vacPositionLRA = $this->db->select('roster_point,lr_name,open_category,date_of_joining,date_of_superannuation,remarks')
            ->where('dist_code', $dist_code)
            ->where('type', 1)
            ->where('status', 1)
            ->get('vacancy_of_lr')
            ->result();

        $result_array = [];
        $i = 1;
        foreach ($vacPositionLRA as $lra)
        {
            $result_array[] = array(
                $i,
                $lra->roster_point,
                $lra->lr_name,
                $lra->open_category,
                date("d-m-Y", strtotime($lra->date_of_joining)),
                date("d-m-Y", strtotime($lra->date_of_superannuation)),
                $lra->remarks
            );

            $i = $i + 1;
        }


        require_once 'application/libraries/xlsxwriter.class.php';
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);

        $heading['Sl. No.'] = 'string';
        $heading['Roster Point'] = 'string';
        $heading['Name of LRS'] = 'string';
        $heading['Category'] = 'string';
        $heading['Date of Joining'] = 'string';
        $heading['Date of Superannuation'] = 'string';
        $heading['Remarks'] = 'string';

        $styles1 = array( 'font'=>'Arial','font-size'=>14,'font-style'=>'bold', 'fill'=>'#FFFF00',
            'halign'=>'center', 'border'=>'left,right,top,bottom');
        $styles7 = array( 'border'=>'left,right,top,bottom');
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        $writer = new XLSXWriter();
        $writer->setAuthor('Dharitree');
        $writer->writeSheetHeader('Sheet1', $heading,$styles1);
        foreach($result_array as $row)
            $writer->writeSheetRow('Sheet1', (array)$row,$styles7);
        ob_end_clean();
        $writer->writeToStdOut();
        exit(0);

    }






    // get Assistant Staff page
    public function getVacancyOfLrStaffPageLra()
    {
        $uCode = MB_ADD_DEPUTY_COMM;
        $this->checkLoginUserAuthorization($uCode);
        $dist_code = trim($this->session->userdata('dist_code'));

        $vacPositionLRA = $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('type', 2)
            ->where('status', 1)
            ->get('vacancy_of_lr');

        $data = [
            'vacPositionLRAS' => $vacPositionLRA->result(),
            'vacPositionLRACount' => $vacPositionLRA->num_rows(),
        ];

        $data['_view'] = 'VacancyOfStaff/vacancy_of_lra_staff_view_page';
        $this->load->view('layouts/main', $data);
    }


    // save Assistant Staff
    public function saveVacancyAssistant()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('open_category', 'Category', 'trim|required');
        $this->form_validation->set_rules('roster_point', 'Roster Point', 'trim|required|min_length[2]|max_length[190]');
        $this->form_validation->set_rules('lr_name', 'Name of LRS', 'trim|required|min_length[2]|max_length[190]');
        $this->form_validation->set_rules('date_of_joining', 'Date of Joining', 'required');
        $this->form_validation->set_rules('date_of_superannuation', 'Date of Superannuation', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLra");
        }

        $date_of_joining        = $this->input->post('date_of_joining');
        $date_of_superannuation = $this->input->post('date_of_superannuation');

        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_of_joining))
        {
            $this->session->set_flashdata('error', '#MRVR003:  Kindly enter valid Date of Joining');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLra");
        }
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_of_superannuation))
        {
            $this->session->set_flashdata('error', '#MRVR003:  Kindly enter valid Date of Superannuation');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLra");
        }

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $subdiv_code     = trim($this->session->userdata('subdiv_code'));
        $user_code       = trim($this->session->userdata('user_code'));
        $type            = 2; // LRA
        $open_category   = trim($this->input->post('open_category'));
        $roster_point    = trim($this->input->post('roster_point'));
        $lr_name         = trim($this->input->post('lr_name'));
        $remarks         = trim($this->input->post('remarks'));

        $insData = [
            'dist_code'              => $dist_code,
            'subdiv_code'            => $subdiv_code,
            'type'                   => $type,
            'open_category'          => $open_category,
            'roster_point'           => $roster_point,
            'lr_name'                => $lr_name,
            'date_of_joining'        => $date_of_joining,
            'date_of_superannuation' => $date_of_superannuation,
            'status'                 => 1,
            'remarks'                => $remarks,
            'created_by'             => $user_desig_code,
            'user_code'              => $user_code,
            'created_at'             => date('Y-m-d h:i:s'),
        ];

        $this->db->trans_begin();

        $saveD = $this->db->insert('vacancy_of_lr', $insData);
        if($saveD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRVR002: Insertion failed in vacancy_of_lr ');
            $this->session->set_flashdata('error', '#MRVR004:  There is some problem, Please Contact Administration');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLra");

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Vacancy of LRA staff successfully submit');
            redirect(base_url() . "index.php/VacancyStaffController/getVacancyOfLrStaffPageLra");
        }
    }


    // report download for  Assistant
    public function getVacancyOfLraStaffReport()
    {
        $uCode = MB_ADD_DEPUTY_COMM;
        $this->checkLoginUserAuthorization($uCode);

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $filename        = time()."_LR_Staff_Assistant.xlsx";

        $vacPositionLRA = $this->db->select('roster_point,lr_name,open_category,date_of_joining,date_of_superannuation,remarks')
            ->where('dist_code', $dist_code)
            ->where('type', 2)
            ->where('status', 1)
            ->get('vacancy_of_lr')
            ->result();

        $result_array = [];
        $i = 1;
        foreach ($vacPositionLRA as $lra)
        {
            $result_array[] = array(
                $i,
                $lra->roster_point,
                $lra->lr_name,
                $lra->open_category,
                date("d-m-Y", strtotime($lra->date_of_joining)),
                date("d-m-Y", strtotime($lra->date_of_superannuation)),
                $lra->remarks
            );

            $i = $i + 1;
        }


        require_once 'application/libraries/xlsxwriter.class.php';
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);

        $heading['Sl. No.'] = 'string';
        $heading['Roster Point'] = 'string';
        $heading['Name of LRA'] = 'string';
        $heading['Category'] = 'string';
        $heading['Date of Joining'] = 'string';
        $heading['Date of Superannuation'] = 'string';
        $heading['Remarks'] = 'string';

        $styles1 = array( 'font'=>'Arial','font-size'=>14,'font-style'=>'bold', 'fill'=>'#FFFF00',
            'halign'=>'center', 'border'=>'left,right,top,bottom');
        $styles7 = array( 'border'=>'left,right,top,bottom');
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        $writer = new XLSXWriter();
        $writer->setAuthor('Dharitree');
        $writer->writeSheetHeader('Sheet1', $heading,$styles1);
        foreach($result_array as $row)
            $writer->writeSheetRow('Sheet1', (array)$row,$styles7);
        ob_end_clean();
        $writer->writeToStdOut();
        exit(0);

    }










}