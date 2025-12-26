<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HydrocarbonReclass extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('hydrocarbon/HydrocarbonReclass_model', 'hydro_model');
        $this->load->library('pagination');
        $this->load->helper(array('url', 'form'));
        $this->load->model('SettlementModel/SettlementCommonModel');
    }


    public function landHydrocarbon()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $sql2 = "select count(*) as c from hydro_reclass_suite_basic where dist_code=? and
            subdiv_code=? and cir_code=? and status=?";
        $res2 = $this->db->query($sql2,
            array($dist_code, $subdiv_code, $cir_code, 'F'));

        if ($res2->num_rows() > 0) {
            $data['cases_no'] = $res2->row()->c;
        }

        $sql3 = "select count(*) as c from hydro_reclass_suite_basic where dist_code=? and
            subdiv_code=? and cir_code=? and status=?";
        $res3 = $this->db->query($sql3,
            array($dist_code, $subdiv_code, $cir_code, 'P'));
        // echo $this->db->last_query();
        if ($res3->num_rows() > 0) {
            $data['casef_no'] = $res3->row()->c;
        }

        $data['user_desig_code'] = $user_desig_code;

        $data['_view'] = 'hydrocarbon_reclass/land_page';
        $this->load->view('layouts/main', $data);
    }






    // Pending cases listing with pagination
    public function index($offset = 0)
    {
        $limit = 3; // records per page

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');

        // total rows
        $total_rows = $this->hydro_model->count_pending_cases_co($dist_code,$subdiv_code,$cir_code);

        // pagination config
        $config['base_url']    = site_url('HydrocarbonReclass/index');
        $config['total_rows']  = $total_rows;
        $config['per_page']    = $limit;
        $config['uri_segment'] = 3;

        // Bootstrap pagination styling
        $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo; Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        // fetch data
        $data['pending_cases'] = $this->hydro_model->get_pending_cases($limit, $offset,$dist_code,$subdiv_code,$cir_code);
        $data['pagination']    = $this->pagination->create_links();

        // load view
        $data['_view'] = 'hydrocarbon_reclass/index';
        $this->load->view('layouts/main', $data);
    }

    // View application details
    public function view($case_no)
    {
        $encoded = $this->uri->segment(3);
        $application_no = $case_no = base64_decode(urldecode($encoded));
       
        $basic             = $this->hydro_model->getHydroReclassBasic($application_no);
        $applicants_buyers = $this->hydro_model->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->hydro_model->getAllApplicantOwners($application_no);

        //$applicants_dag_details = $this->hydro_model->getAllApplicantDagDetails($application_no);

        $lmdata        = [];
        $dags          = $this->hydro_model->getSettlementDag($application_no);
        $lmnotes       = '';//$this->hydro_model->getSettlementTenantLmNote($application_no);
        $proceedings   = $this->hydro_model->getSettlementProceeding($application_no);
        $dhardocuments = $this->hydro_model->getDocuments($application_no);
        $nominee       = $this->hydro_model->getAllNomineeDetail($application_no);
        $deed_applicant= '';//$this->hydro_model->getAllDeedPattadar($application_no);
        $family_tree   = '';//$this->hydro_model->getAllFamilyTree($application_no);

        $existing_pattadar = '';//$this->hydro_model->getAllExistingPattadar($application_no);

        $lmdata['basic']             = $basic;
        $lmdata['nominee']           = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;

        $lmdata['existing_pattadar'] = $existing_pattadar;
        $lmdata['deed_applicant']    = $deed_applicant;
        $lmdata['family_tree']       = $family_tree;
        //$lmdata['applicants_dag_details'] = $applicants_dag_details;

        $lmdata['checkAdditionalProperty'] = '';
        $applid = $this->hydro_model->getApplidFromCaseNoReclass($application_no);

        $lmdata['dags']          = $dags;
        $lmdata['penalty_dags']  = '';//$penalty_dags;
        $lmdata['lmnotes']       = $lmnotes;
        $lmdata['proceedings']   = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;

        $premium_data = $this->db->query("SELECT sp.*,spa.* FROM settlement_premium sp inner join hydro_reclass_dag_details spa on spa.dag_no=sp.dag_no and spa.case_no=sp.case_no where sp.case_no='$application_no' and is_final=1")->result();


        //echo $this->db->last_query();exit;
        $lmdata['premium_data'] = $premium_data;

        $premium_data_lm = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and user_code like 'M%' and is_final=1")->row();
        $lmdata['premium_data_lm'] = $premium_data_lm;


        $lmdata['premium']     = $this->SettlementCommonModel->getPremium($application_no);
        $lmdata['reservation'] = '';
        $lmdata['additional_property'] = '';//$this->reclassModel->getAdditionalProperty($application_no);

        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($sdoCheckResult) == 'y'){
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';
            }
        }
        else
        {
            $lmdata['sdo_user_check'] = 'y';
        }


        $lmdata['chithaArea']   = '';//$checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = '';//$checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = '';//$checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = '';//$checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= '';//$checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = '';

        $data['application'] = $this->hydro_model->get_case_by_no($case_no);
        //$this->load->view('hydrocarbon_reclass/view', $data);

        $lmdata['_view'] = 'hydrocarbon_reclass/view';
        $this->load->view('layouts/main', $lmdata);
    }

    // Pending cases listing with pagination
    public function indexDC($offset = 0)
    {
        $limit = 3; // records per page

        // total rows
        $total_rows = $this->hydro_model->count_pending_cases();

        // pagination config
        $config['base_url']    = site_url('HydrocarbonReclass/indexDC');
        $config['total_rows']  = $total_rows;
        $config['per_page']    = $limit;
        $config['uri_segment'] = 3;

        // Bootstrap pagination styling
        $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo; Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $dist_code          = $this->session->userdata('dist_code');

        // fetch data
        $data['pending_cases'] = $this->hydro_model->get_pending_cases_dc($limit, $offset,$dist_code);
        $data['pagination']    = $this->pagination->create_links();

        // load view
        $data['_view'] = 'hydrocarbon_reclass/index';
        $this->load->view('layouts/main', $data);
    }


     // Pending cases listing with pagination
    public function partitionCases($offset = 0)
    {
        $limit = 3; // records per page

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');

        // total rows
        $total_rows = $this->hydro_model->count_pending_cases_co_partition($dist_code,$subdiv_code,$cir_code);

        // pagination config
        $config['base_url']    = site_url('HydrocarbonReclass/partitionCases');
        $config['total_rows']  = $total_rows;
        $config['per_page']    = $limit;
        $config['uri_segment'] = 3;

        // Bootstrap pagination styling
        $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo; Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        // fetch data
        $data['pending_cases'] = $this->hydro_model->get_pending_cases_part($limit, $offset,$dist_code,$subdiv_code,$cir_code);
        $data['pagination']    = $this->pagination->create_links();

        // load view
        $data['_view'] = 'hydrocarbon_reclass/partition_view';
        $this->load->view('layouts/main', $data);
    }

     // View application details
    public function viewPartition($case_no)
    {
        $encoded = $this->uri->segment(3);
        $application_no = $case_no = base64_decode(urldecode($encoded));
       
        $basic             = $this->hydro_model->getHydroReclassBasic($application_no);
        $applicants_buyers = $this->hydro_model->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->hydro_model->getAllApplicantOwners($application_no);

        //$applicants_dag_details = $this->hydro_model->getAllApplicantDagDetails($application_no);

        $lmdata        = [];
        $dags          = $this->hydro_model->getSettlementDag($application_no);
        $lmnotes       = '';//$this->hydro_model->getSettlementTenantLmNote($application_no);
        $proceedings   = $this->hydro_model->getSettlementProceeding($application_no);
        $dhardocuments = $this->hydro_model->getDocuments($application_no);
        $nominee       = $this->hydro_model->getAllNomineeDetail($application_no);
        $deed_applicant= '';//$this->hydro_model->getAllDeedPattadar($application_no);
        $family_tree   = '';//$this->hydro_model->getAllFamilyTree($application_no);

        $existing_pattadar = '';//$this->hydro_model->getAllExistingPattadar($application_no);

        $lmdata['basic']             = $basic;
        $lmdata['nominee']           = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;

        $lmdata['existing_pattadar'] = $existing_pattadar;
        $lmdata['deed_applicant']    = $deed_applicant;
        $lmdata['family_tree']       = $family_tree;
        //$lmdata['applicants_dag_details'] = $applicants_dag_details;

        $lmdata['checkAdditionalProperty'] = '';
        $applid = $this->hydro_model->getApplidFromCaseNoReclass($application_no);

        $lmdata['dags']          = $dags;
        $lmdata['penalty_dags']  = '';//$penalty_dags;
        $lmdata['lmnotes']       = $lmnotes;
        $lmdata['proceedings']   = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;

        $premium_data = $this->db->query("SELECT sp.*,spa.* FROM settlement_premium sp inner join hydro_reclass_dag_details spa on spa.dag_no=sp.dag_no and spa.case_no=sp.case_no where sp.case_no='$application_no' and is_final=1")->result();


        //echo $this->db->last_query();exit;
        $lmdata['premium_data'] = $premium_data;

        $premium_data_lm = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and user_code like 'M%' and is_final=1")->row();
        $lmdata['premium_data_lm'] = $premium_data_lm;


        $lmdata['premium']     = $this->SettlementCommonModel->getPremium($application_no);
        $lmdata['reservation'] = '';
        $lmdata['additional_property'] = '';//$this->reclassModel->getAdditionalProperty($application_no);

        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($sdoCheckResult) == 'y'){
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';
            }
        }
        else
        {
            $lmdata['sdo_user_check'] = 'y';
        }


        $lmdata['chithaArea']   = '';//$checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = '';//$checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = '';//$checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = '';//$checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= '';//$checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = '';

        $data['application'] = $this->hydro_model->get_case_by_no($case_no);
        //$this->load->view('hydrocarbon_reclass/view', $data);

        $lmdata['_view'] = 'hydrocarbon_reclass/partition_view_case_details';
        $this->load->view('layouts/main', $lmdata);
    }
}
