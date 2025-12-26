<?php

class AncillaryController extends CI_Controller
{

    private $per_page = 10; // Number of records per page

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->library('pagination');
        $this->load->library('input');
        $this->load->helper('url');
    }

    public function filteredIndex()
    {

        // assigned_officer_id condition is required for counting also lraCount is required

        $userDesig = $this->session->userdata('user_desig_code');

        $menuItems = [

            'first_proceeding' => [
                'label' => '1st Proceeding',
                'visible_to' => ['CO', 'LM'],
                'step' => 1,
                'status' => 'Pending',
                'rereport' => 0,
                'query' => [
                    'table' => 'ancillary_applications',
                    'where' => ['current_step_id' => 1]
                ]
            ],

            'reverted_co' => [
                'label' => 'Reverted by CO',
                'visible_to' => ['LM'],
                'step' => 4,
                'status' => 'Returned',
                'rereport' => 0,
                'query' => [
                    'table' => 'ancillary_application_workflow',
                    'where' => ['step_id' => 4, 'status' => 'Returned']
                ]
            ],

            'second_proceeding' => [
                'label' => 'Second Proceeding',
                'visible_to' => ['CO'],
                'step' => 4,
                'status' => 'Pending',
                'rereport' => 0,
                'query' => [
                    'table' => 'ancillary_applications',
                    'where' => ['current_step_id' => 4]
                ]
            ],

            'rereport_lra' => [
                'label' => 'Re-Report by LRA',
                'visible_to' => ['CO'],
                'step' => 3,
                'status' => 'Completed',
                'rereport' => 1,
                'custom' => 'countReReportLra'
            ],

            'all_cases' => [
                'label' => 'All Cases',
                'visible_to' => null,
                'step' => null,
                'status' => null,
                'rereport' => 0,
                'query' => [
                    'table' => 'ancillary_application_workflow',
                    'where' => ['status' => 'Pending'],
                    'distinct' => 'application_id'
                ]
            ],
        ];

        $filteredMenu = [];
        foreach ($menuItems as $key => $item) {
            if ($item['visible_to'] === null || in_array($userDesig, $item['visible_to'])) {
                $filteredMenu[$key] = $item;
            }
        }

        $counts = [];

        foreach ($filteredMenu as $key => $item) {

            if (isset($item['custom'])) {
                $counts[$key] = $this->{$item['custom']}();
                continue;
            }

            if (isset($item['query']['distinct'])) {
                $this->db->select("COUNT(DISTINCT " . $item['query']['distinct'] . ") AS count");
            } else {
                $this->db->select("COUNT(*) AS count");
            }

            foreach ($item['query']['where'] as $col => $val) {
                $this->db->where($col, $val);
            }

            $row = $this->db->get($item['query']['table'])->row();
            $counts[$key] = $row ? $row->count : 0;
        }

        $sl = 1;
        $data['menuItems'] = [];

        foreach ($filteredMenu as $key => $item) {
            $data['menuItems'][] = [
                'sl_no' => $sl++,
                'label' => $item['label'],
                'count' => $counts[$key],
                'step' => $item['step'],
                'status' => $item['status'],
                'rereport' => $item['rereport'],
                'key' => $key
            ];
        }

        $data['designation'] = $userDesig;
        $data['_view'] = 'ancillary/f_index';

        $this->load->view('layouts/main', $data);
    }



    private function countReReportLra()
    {
        $caseNos = $this->db->select('case_no')
            ->where(['step_id' => 4, 'status' => 'Returned'])
            ->get('ancillary_application_workflow')
            ->result_array();

        if (empty($caseNos)) return 0;

        return $this->db->select('COUNT(DISTINCT application_id) AS count')
            ->where_in('case_no', array_column($caseNos, 'case_no'))
            ->where(['step_id' => 3, 'status' => 'Completed'])
            ->get('ancillary_application_workflow')
            ->row()->count;
    }




    public function index($offset = 0)
    {

        $step = $this->input->get('step');
        $status = $this->input->get('status');
        $reReport = $this->input->get('rereport');

        $data['_view'] = 'ancillary/index';

        $userCode = $this->session->userdata('user_code');
        // var_dump($userCode);
        // die;
        $userDesignation = $this->session->userdata('user_desig_code');

        $currentStepIds = $this->getCurrentStepIds($userDesignation);



        $application_ids_land_details = $this->db->select('application_id')
            ->distinct();

        if ($step == 1 && $status == 'Pending') {
            $application_ids_land_details = $application_ids_land_details->where('current_step_id', $step);
        } else if ($step == 4 && $status == 'Returned') {
            //  $application_ids_land_details = $application_ids_land_details->where('current_step_id', $step);
            $application_ids_land_details = $application_ids_land_details->where_in('current_step_id', array_column($currentStepIds, 'step_order'));
        } else if ($step == 4 && $status == 'Pending') {
            $application_ids_land_details = $application_ids_land_details->where('current_step_id', $step);
        } else if ($reReport == 1) {
            $application_ids_land_details = $application_ids_land_details->where('current_step_id', $step);
        } else {
            $application_ids_land_details = $application_ids_land_details->where_in('current_step_id', array_column($currentStepIds, 'step_order'));
        }


        $application_ids_land_details = $application_ids_land_details->get('ancillary_land_details');





        if (!$application_ids_land_details) {
            $application_ids_land_details = [];
        } else {
            $application_ids_land_details = $application_ids_land_details->result_array();;
        }

        // var_dump($application_ids_land_details);
        // die;

        // Get total rows count
        $total_rows = $this->db->select('*')
            ->where_in('id', array_column($application_ids_land_details, 'application_id'))
            // ->get('ancillary_applications')
            ->count_all('ancillary_applications');

        if (!$application_ids_land_details) {
            $total_rows = 0;
        }


        // Configure pagination
        $config['base_url'] = site_url('AncillaryController/index');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        // var_dump($userCode);

        $applicationIdsDc = $this->db->select('application_id, case_no');


        if ($step == 1 && $status == 'Pending') {
            $applicationIdsDc = $applicationIdsDc->where('assigned_officer_id', $userCode)->where('step_id', $step)->where('status', $status);
        } else if ($step == 4 && $status == 'Returned') {
            $applicationIdsDc = $applicationIdsDc->where('step_id', $step)->where('status', $status);
        } else if ($step == 4 && $status == 'Pending') {
            $applicationIdsDc = $applicationIdsDc->where('step_id', $step)->where('status', $status);
        } else if ($reReport == 1) {
            $applicationIdsDc = $applicationIdsDc->where('step_id', $step)->where('status', $status);
        } else {
            //
        }
        $applicationIdsDc = $applicationIdsDc->get('ancillary_application_workflow');

        if ($applicationIdsDc) {
            $applicationIdsDc = $applicationIdsDc->result_array();
        } else {
            $applicationIdsDc = [];
        }

        // var_dump($applicationIdsDc);
        // die;

        if (!$application_ids_land_details) {
            $applicationIds = [];
        } else {


            $applicationIds = $this->db->select('*')
                ->where_in('application_id', array_column($application_ids_land_details, 'application_id'));

            if ($step == 1 && $status == 'Pending') {
                $applicationIds = $applicationIds->where('step_id', $step)->where('status', $status);
            } else if ($step == 4 && $status == 'Returned') {
                $returnedCheck =  $this->db->select('*')
                    ->where_in('application_id', array_column($application_ids_land_details, 'application_id'))
                    ->where('step_id', $step)->where('status', $status)
                    ->get('ancillary_application_workflow')->num_rows();

                if ($returnedCheck  != 0) {
                    $applicationIds = $applicationIds->where('status', 'Pending');
                }
            } else if ($step == 4 && $status == 'Pending') {
                $applicationIds = $applicationIds->where('step_id', $step)->where('status', $status);
            } else if ($reReport == 1) {
                $returnedCheck =  $this->db->select('*')
                    ->where_in('application_id', array_column($application_ids_land_details, 'application_id'))
                    ->where('step_id', $step)->where('status', $status)
                    ->get('ancillary_application_workflow')->num_rows();

                if ($returnedCheck  != 0) {
                    //change required here
                    $applicationIds = $applicationIds->where('step_id', $step)->where('status', $status);
                }
            } else {
                //
            }

            $applicationIds = $applicationIds->where('assigned_officer_id', $userCode)
                ->get('ancillary_application_workflow');

            if ($applicationIds) {
                $applicationIds = $applicationIds->result_array();
                // var_dump($applicationIds);
            } else {
                $applicationIds = [];
            }
        }


        $land_details = [];
        // var_dump($this->db->last_query());die;
        // Get paginated applications
        $current_step_id = $this->getCurrentStepId($userDesignation);
        if ($userDesignation == 'DC') {
            if (!$applicationIdsDc) {
                $applications = [];
            } else {
                $applications = $this->db->select('*')
                    ->where_in('id', array_column($applicationIdsDc, 'application_id'))
                    // ->where('current_step_id', $current_step_id)
                    ->order_by('current_step_id', 'ASC')
                    ->limit($this->per_page, $offset)
                    ->get('ancillary_applications');

                $land_details = $this->db->select('*')
                    ->where_in('sub_case_no', array_column($applicationIdsDc, 'case_no'))
                    ->get('ancillary_land_details');

                if ($applications) {
                    $applications = $applications->result_array();
                    $land_details = $land_details->result_array();
                } else {
                    $applications = [];
                }
            }
        } else {
            if (!$applicationIds) {
                $applications = [];
            } else {

                $applications = $this->db->select('*')
                    ->where_in('id', array_column($applicationIds, 'application_id'))
                    // ->where('current_step_id', $current_step_id)
                    ->limit($this->per_page, $offset)
                    ->get('ancillary_applications');

                $land_details = $this->db->select('*')
                    ->where_in('sub_case_no', array_column($applicationIds, 'case_no'))
                    ->get('ancillary_land_details');


                if ($applications) {
                    $applications = $applications->result_array();
                    $land_details = $land_details->result_array();
                } else {
                    $applications = [];
                }
            }
        }

        // var_dump($land_details);



        // var_dump($applications);

        // safer: don't use references — build a new array with encrypted_id
        foreach ($applications as $key => $app) {
            $applications[$key]['encrypted_id'] = $this->encryptId($app['id']);
        }

        // build lookup
        $landIndex = [];
        foreach ($land_details as $land) {
            $landIndex[$land['application_id']][] = $land;
        }

        // attach lands
        $mapped_data = [];
        foreach ($applications as $app) {
            $app_id = $app['id'];
            $app['land_details'] = $landIndex[$app_id] ?? [];
            $mapped_data[] = $app;
        }

        // echo '<pre>'; print_r($mapped_data); echo '</pre>';
        // die;


        if (empty($mapped_data)) {
            $data['applications'] = $applications;
        } else {
            $data['applications'] = $mapped_data;
        }



        $this->load->view('layouts/main', $data);
    }

    private function getCurrentStepId($userDesignation)
    {
        $step = $this->db->select('step_order')
            ->from('ancillary_workflow_steps')
            ->where('user_desig', $userDesignation)
            ->where('is_active', '1')
            ->get();

        if (!$step) {
            return 0;
        } else {
            $step = $step->result_array();
            return $step[0]['step_order'];
        }
    }

    private function getCurrentStepIds($userDesignation)
    {
        $step = $this->db->select('step_order')
            ->from('ancillary_workflow_steps')
            ->where('user_desig', $userDesignation)
            ->where('is_active', '1')
            ->get();

        if (!$step) {
            return 0;
        } else {
            return $step->result_array();
        }
    }


    /**
     * Get users for next step based on land details
     * @param array $land_details Array of land details
     * @param string $nextUserDesig Next user designation code
     * @return array Array of user codes
     */
    private function getUsersForNextStep($land_details, $nextUserDesig, $userCode = null)
    {
        $nextUsers = [];
        // var_dump($nextUserDesig);die;

        foreach ($land_details as $land) {


            if ($nextUserDesig == 'CO') {
                $users = $this->db->select('*')
                    ->from('loginuser_table lt')
                    ->join('users u', 'lt.user_code = u.user_code')
                    ->where('lt.dist_code', $land['district_code'])
                    ->where('lt.subdiv_code', $land['subdiv_code'])
                    ->where('lt.cir_code', $land['circle_code'])
                    ->where('lt.mouza_pargona_code', '00')
                    ->where('u.user_desig_code', $nextUserDesig)
                    ->where('lt.dis_enb_option', 'E')
                    ->get()
                    ->result_array();

                // echo 'Loop iteration count: ' . (count($land_details) - array_search($land, $land_details)) . '\n';
                // echo $this->db->last_query();
                // var_dump($users);
            } else  if ($nextUserDesig == 'LM') {
                $sql = "
                    SELECT lt.user_code
                    FROM loginuser_table lt
                    JOIN lm_code u
                    ON lt.dist_code = u.dist_code
                    AND lt.subdiv_code = u.subdiv_code
                    AND lt.cir_code = u.cir_code
                    AND lt.mouza_pargona_code = u.mouza_pargona_code
                    AND lt.lot_no = u.lot_no
                    AND u.lm_code = lt.user_code
                    WHERE lt.dis_enb_option = 'E'
                    AND lt.dist_code = ?
                    AND lt.subdiv_code = ?
                    AND lt.cir_code = ?
                    AND lt.mouza_pargona_code = ?
                    AND lt.lot_no = ?
                ";

                $data = $this->db->query($sql, [$land['district_code'], $land['subdiv_code'], $land['circle_code'], $land['mouza_code'], $land['lot_no']]);
                $users = $data->result_array();
            } else if ($nextUserDesig == 'ADC') {
                $users = $this->db->select('*')
                    ->from('loginuser_table lt')
                    ->join('users u', 'lt.user_code = u.user_code')
                    ->where('lt.dist_code', $land['district_code'])
                    ->where('lt.subdiv_code', '00')
                    ->where('u.user_desig_code', $nextUserDesig)
                    ->where('lt.dis_enb_option', 'E');

                if ($userCode != null) {
                    $users = $users->where('lt.user_code', $userCode);
                }
                $users = $users->get()->result_array();

                // var_dump($this->db->last_query());die;
            } else if ($nextUserDesig == 'DC') {
                $users = $this->db->select('*')
                    ->from('loginuser_table lt')
                    ->join('users u', 'lt.user_code = u.user_code')
                    ->where('lt.dist_code', $land['district_code'])
                    ->where('lt.subdiv_code', '00')
                    ->where('u.user_desig_code', $nextUserDesig)
                    ->where('lt.dis_enb_option', 'E')
                    ->get()
                    ->result_array();

                // var_dump($this->db->last_query());die;
            }



            if (!empty($users)) {
                foreach ($users as $user) {
                    $nextUsers[] = [
                        'user_code' => $user['user_code'],
                        'sub_case_no' => $land['sub_case_no']
                    ];
                }
            }
        }

        // var_dump($nextUsers);die;


        return $nextUsers;
    }

    /**
     * View application details
     * @param string $encrypted_id Encrypted application ID
     */
    public function view($encrypted_id = null)
    {
        try {
            // Decrypt the ID
            $id = $this->decryptId($encrypted_id);

            if (!$id) {
                throw new Exception('Invalid application ID');
            }

            $userDesignation = $this->session->userdata('user_desig_code');
            $userCode = $this->session->userdata('user_code');
            $currentStepId = $this->getCurrentStepId($userDesignation);

            $subStepIncompleteStepId = $currentStepId;

            $application = $this->db->get_where('ancillary_applications', ['id' => $id])->row_array();



            $kycDetails = $this->db->get_where('ancillary_aadhaar_verification', ['ref_no' => $application['rtps_ref_no']]);

            $isKyc = 0;
            if ($kycDetails->num_rows() > 0) {
                $kycDetails = $kycDetails->row_array();
                $isKyc = 1;
            }
            // var_dump($application['id']);die;
            $applicationStepId = $application['current_step_id'];


            // might not work
            if ($currentStepId != $applicationStepId) {
                $currentStepId = $applicationStepId;
            }

            $landDetails = $this->db->select('*')->get_where('ancillary_land_details', ['application_id' => $id])->result_array();


            $landDetailsCurrentStepId = 0;
            foreach ($landDetails as $landDetail) {
                $users = $this->db->select('*')
                    ->from('loginuser_table lt')
                    ->join('users u', 'lt.user_code = u.user_code')
                    ->where('lt.dist_code', $landDetail['district_code'])
                    ->where('lt.subdiv_code', $landDetail['subdiv_code'])
                    ->where('lt.cir_code', $landDetail['circle_code'])
                    ->where('lt.mouza_pargona_code', '00')
                    ->where('u.user_desig_code', $userDesignation)
                    ->where('lt.dis_enb_option', 'E')
                    ->get()
                    ->result_array();

                if (!empty($users)) {
                    foreach ($users as $user) {
                        if ($user['user_code'] == $userCode) {
                            $landDetailsCurrentStepId = $landDetail['current_step_id'];
                        }
                    }
                }
            }



            if ($userDesignation == 'DC') {

                $applicationWorkflow = $this->db->get_where(
                    'ancillary_application_workflow',
                    [
                        'application_id' => $id,
                        'step_id' => $currentStepId,
                        'status' => 'Pending',
                    ]
                )->result_array();
            } else {


                // $flag = false;

                // if($applicationStepId != $currentStepId) {
                //     $flag = true;
                // }

                // if($landDetailsCurrentStepId != $currentStepId) {
                //     $flag = true;
                // } else {
                //     $flag = false;
                // }


                // if($flag) {
                //     throw new Exception('You are not authorized to view this application');
                // }


                $this->db->where([
                    'application_id' => $id,
                    'step_id' => $currentStepId,
                    'status' => 'Pending',
                    'assigned_officer_id' => $userCode
                ]);
                $this->db->order_by('id', 'ASC');
                $applicationWorkflow = $this->db->get('ancillary_application_workflow')->result_array();

                if (empty($applicationWorkflow)) {

                    $this->db->where([
                        'application_id' => $id,
                        'step_id' => $subStepIncompleteStepId,
                        'status' => 'Pending',
                        'assigned_officer_id' => $userCode
                    ]);
                    $this->db->order_by('id', 'ASC');
                    $applicationWorkflow = $this->db->get('ancillary_application_workflow')->result_array();
                }
            }




            // Collect case_no values from workflow
            $case_nos = [];
            if (!empty($applicationWorkflow)) {
                foreach ($applicationWorkflow as $workflow) {
                    if (!empty($workflow['case_no'])) {
                        $case_nos[] = $workflow['case_no'];
                    }
                }
            }
            // var_dump($case_nos);

            // Filter timeline data to only include records matching the collected case numbers
            $applicationWorkflowForTimeline = [];
            if (!empty($case_nos)) {
                $applicationWorkflowForTimeline = $this->db
                    ->where('application_id', $id)
                    ->where_in('case_no', $case_nos)
                    ->order_by('id', 'ASC')
                    ->get('ancillary_application_workflow')
                    ->result_array();
            }

            // var_dump($applicationWorkflowForTimeline);
            // die;

            // var_dump($case_nos);

            $land_details = $this->db->where('application_id', $id)
                ->where_in('sub_case_no', $case_nos)
                ->get('ancillary_land_details');

            // var_dump($case_nos);die;



            if (!empty($land_details)) {
                $land_details = $land_details->result_array();
            } else {
                throw new Exception("You are not authorized to Forward this application.");
            }

            $adcList = [];



            if ($userDesignation == 'CO' && $applicationWorkflow[0]['step_id'] == 4) {
                $adcList = $this->getUsersForNextStep($land_details, 'ADC');
            }

            // var_dump($adcList);die;
            $rtps_ref_no = $application['rtps_ref_no'];
            $land_status = $this->db->get_where('ancillary_land_status', ['rtps_ref_no' => $rtps_ref_no])->result_array();

            // var_dump($application);
            // var_dump($land_details);
            // var_dump($rtps_ref_no);
            // var_dump($land_status);

            $patta_details = [];
            $dag_details = [];
            if (!empty($land_details)) {

                // var_dump($land['id']);

                $land_details_ids = $this->db->select('id')
                    ->where('application_id', $application['id'])
                    ->where_in('sub_case_no', $case_nos)
                    ->get('ancillary_land_details')
                    ->result_array();
            }


            $patta_details = $this->db->select('*')
                ->where_in('land_detail_id', array_column($land_details_ids, 'id'))
                ->get('ancillary_land_patta_numbers')
                ->result_array();
            $dag_details = $this->db->select('*')
                ->where_in('land_detail_id', array_column($land_details_ids, 'id'))
                ->where('purpose IS NOT NULL')
                ->get('ancillary_land_dag_details')
                ->result_array();

            // Map proposed class names to dag details using land_class_groups
            $landClassQuery = "SELECT land_class_code, name FROM land_class_groups";
            $landClassResult = $this->db->query($landClassQuery)->result_array();
            $landClassMap = [];
            foreach ($landClassResult as $class) {
                if (isset($class['land_class_code'])) {
                    $landClassMap[$class['land_class_code']] = $class['name'];
                }
            }

            if (!empty($dag_details) && is_array($dag_details)) {
                foreach ($dag_details as &$dag) {
                    if (!empty($dag['proposed_class']) && isset($landClassMap[$dag['proposed_class']])) {
                        $dag['proposed_class_name'] = $landClassMap[$dag['proposed_class']];
                    } else {
                        $dag['proposed_class_name'] = isset($dag['proposed_class']) ? $dag['proposed_class'] : '';
                    }

                    $uuidRow = $this->db->select('uuid')

                        ->where('dist_code', $dag['district_code'])
                        ->where('subdiv_code', $dag['subdiv_code'])
                        ->where('cir_code', $dag['circle_code'])
                        ->where('mouza_pargona_code', $dag['mouza_code'])
                        ->where('lot_no', $dag['lot_no'])
                        ->where('vill_townprt_code', $dag['village_code'])
                        ->limit(1)
                        ->get('location')
                        ->row_array();

                    $dag['uuid'] = $uuidRow['uuid'] ?? '';
                }
                unset($dag);
            }

            $isLmNote = 0;

            $lmNote = $this->db->select('*')
                ->where_in('case_no', $case_nos)
                ->get('ancillary_lmnote');




            $reservation = $this->db->select('*')
                ->where_in('case_no', $case_nos)
                ->get('ancillary_reservation');



            $premium = $this->db->select('*')
                ->where_in('case_no', $case_nos)
                ->get('ancillary_premium');


            // var_dump($this->db->last_query());
            // die;

            $reservationsView = [];
            // Process LM Note data if exists
            if ($lmNote->num_rows() > 0) {
                $lmNote = $lmNote->row_array();
                $reservations = $reservation->result_array();
                $reservationsView = $reservations;
                $premium = $premium->result_array();
                $isLmNote = 1;

                // Process reservation data to match the view's expected format
                $reservation_details = [];
                foreach ($reservations as $res) {
                    $reservation_details[$res['dag_no']] = [
                        'bigha' => $res['bigha'],
                        'katha' => $res['katha'],
                        'lessa' => $res['lessa'],
                        'ganda' => $res['ganda'],
                        'nature_of_possession' => $res['nature_of_possession'],
                        'reservation_comment' => $res['reservation_comment']
                    ];
                }

                // Merge reservation data with dag_details if available
                if (!empty($dag_details) && is_array($dag_details)) {
                    foreach ($dag_details as &$dag) {
                        $dag_no = $dag['dag_number'] ?? null;
                        if ($dag_no && isset($reservation_details[$dag_no])) {
                            $dag = array_merge($dag, $reservation_details[$dag_no]);
                        }
                    }
                    unset($dag);
                }
            } else {
                // Initialize reservation fields with default values if no LM Note exists
                if (!empty($dag_details) && is_array($dag_details)) {
                    foreach ($dag_details as &$dag) {
                        $dag['bigha'] = '0';
                        $dag['katha'] = '0';
                        $dag['lessa'] = '0';
                        $dag['ganda'] = '0';
                        $dag['nature_of_possession'] = $dag['nature_of_possession'] ?? '';
                        $dag['reservation_comment'] = $dag['reservation_comment'] ?? '';
                    }
                    unset($dag);
                }
                $lmNote = [];
                $isLmNote = 0;
            }

            // var_dump($isLmNote);
            // var_dump($lmNote);
            // die;

            // var_dump($premium);
            // die;

            // var_dump($lmNote);
            // die;
            // var_dump($this->db->last_query());
            // var_dump($patta_details);
            // var_dump($dag_details);
            // die;

            // var_dump($kycDetails);
            // die;
            $data['application'] = $application;
            $data['isKyc'] = $isKyc;
            $data['kycDetails'] = $kycDetails;
            $data['land_details'] = $land_details;
            $data['land_status'] = $land_status;
            $data['patta_details'] = $patta_details;
            $data['dag_details'] = $dag_details;
            $data['applicationWorkflowForTimeline'] = $applicationWorkflowForTimeline;

            $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();

            $data['isLmNote'] = $isLmNote;
            $data['lmNote'] = $lmNote;
            $data['reservation'] = $reservation;
            $data['reservationsView'] = $reservationsView;
            $data['premium'] = $premium;
            // var_dump($application);die;
            // var_dump($land_status);
            // die;

            $data['current_user_desig'] = $userDesignation;
            $data['step_id'] = $applicationWorkflow[0]['step_id'];
            $data['adcList'] = $adcList;
            $data['_view'] = 'ancillary/view';
            $this->load->view('layouts/main', $data);
        } catch (Exception $e) {
            show_error($e->getMessage(), 400);
        }
    }

    /**
     * Simple ID obfuscation for URL
     */
    private function encryptId($id)
    {
        // Simple salt for basic obfuscation
        $salt = 'd4f3a9b6c2e1f0a8b7c6d5e4f3a2b1c0e9f8d7c6b5a4938271605f4e3d2c1b';
        return rtrim(strtr(base64_encode($salt . $id), '+/', '-_'), '=');
    }

    /**
     * Decode obfuscated ID from URL
     */
    private function decryptId($encrypted)
    {
        $salt = 'd4f3a9b6c2e1f0a8b7c6d5e4f3a2b1c0e9f8d7c6b5a4938271605f4e3d2c1b';
        $decoded = base64_decode(str_pad(strtr($encrypted, '-_', '+/'), strlen($encrypted) % 4, '=', STR_PAD_RIGHT));
        return str_replace($salt, '', $decoded);
    }

    /**
     * Revert a case to the previous user in the workflow
     */
    public function previousUser()
    {
        // echo "<pre>";
        //     print_r($this->input->post());
        //     echo "</pre>";
        //     die;
        $this->db->trans_begin();

        try {
            // Check if the request is a POST request
            if ($this->input->server('REQUEST_METHOD') !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Get form data
            $rtps_no = $this->input->post('rtps_no');
            $remarks = $this->input->post('remarks');

            // Validate input
            if (empty($rtps_no) || empty($remarks)) {
                throw new Exception('RTPS number and remarks are required.');
            }

            // Get current user data
            $current_user = $this->session->userdata('user_code');
            $current_user_desig = $this->session->userdata('user_desig_code');

            if (empty($current_user) || empty($current_user_desig)) {
                throw new Exception('User session data not found.');
            }

            // Get current step ID for the user's designation
            $current_step_ids = $this->getCurrentStepIds($current_user_desig);




            // Get application data
            $application = $this->db->select('id, current_step_id')
                ->where('rtps_ref_no', $rtps_no)
                ->get('ancillary_applications')
                ->row();

            if (empty($application)) {
                throw new Exception('Application not found.');
            }

            // Get the previous step in the workflow
            $prevUserData = $this->db->select('*')
                ->where_in('step_order', array_column($current_step_ids, 'step_order'))
                ->where('is_active', '1')
                ->order_by('step_order', 'DESC')
                ->limit(1)
                ->get('ancillary_workflow_steps')
                ->row();

            $current_step_id = $prevUserData->step_order;

            $prevUserData = $this->db->select('*')
                ->where('step_order <', $current_step_id)
                ->where('is_active', '1')
                ->order_by('step_order', 'DESC')
                ->limit(1)
                ->get('ancillary_workflow_steps')
                ->row();


            if (empty($prevUserData)) {
                throw new Exception('No previous step found in the workflow.');
            }

            $prevUserDesig = $prevUserData->user_desig;

            $prevStepOrder = $prevUserData->step_order;
            $application_id = $application->id;

            // Get the case numbers for the current step
            $case_nos = $this->db->select('case_no')
                ->where('application_id', $application_id)
                ->where('step_id', $current_step_id)
                ->where('assigned_officer_id', $current_user)
                ->distinct()  // Add this line to get distinct case_no
                ->get('ancillary_application_workflow')
                ->result_array();

            // var_dump($case_nos);
            // die;

            $previousUserId = $this->db->select('assigned_officer_id')
                ->where('application_id', $application_id)
                ->where('step_id', $prevStepOrder)
                ->get('ancillary_application_workflow')
                ->row_array();


            if (empty($case_nos)) {
                throw new Exception('No workflow records found for this application and step.');
            }

            // Get land details for the current case numbers
            $land_details = $this->db->select('*')
                ->where('application_id', $application_id)
                ->where_in('sub_case_no', array_column($case_nos, 'case_no'))
                ->get('ancillary_land_details');

            if (empty($land_details)) {
                throw new Exception('No land details found for this application.');
            } else {
                $land_details = $land_details->result_array();
            }

            // Update land details with previous step
            $land_details_update_data = [
                'current_step_id' => $prevStepOrder,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('application_id', $application_id);
            $this->db->where_in('sub_case_no', array_column($case_nos, 'case_no'));
            if (!$this->db->update('ancillary_land_details', $land_details_update_data)) {
                throw new Exception('Failed to update land details.');
            }

            // Update application with previous step
            $applicationUpdateData = [
                'current_step_id' => $prevStepOrder,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('id', $application_id);
            if (!$this->db->update('ancillary_applications', $applicationUpdateData)) {
                throw new Exception('Failed to update application status.');
            }

            // Update current workflow step status to 'Returned' with remarks
            $currentWorkflowUpdate = [
                'status' => 'Returned',
                'remarks' => $remarks,
                'completed_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('application_id', $application_id);
            $this->db->where('step_id', $current_step_id);
            $this->db->where('assigned_officer_id', $current_user);
            if (!$this->db->update('ancillary_application_workflow', $currentWorkflowUpdate)) {
                throw new Exception('Failed to update current workflow step status.');
            }

            // Get users for the previous step

            $prevUsers = $this->getUsersForNextStep($land_details, $prevUserDesig);

            if ($prevUserDesig == "ADC") {
                $prevUsers = $this->getUsersForNextStep($land_details, $prevUserDesig, $previousUserId['assigned_officer_id']);
            }

            // var_dump($prevUsers);
            // die;


            if (empty($prevUsers)) {
                throw new Exception('No users found for the previous step.');
            }

            // Create workflow entry for the previous step
            $workflowData = [];
            $now = date('Y-m-d H:i:s');

            // var_dump($case_nos);
            // die;
            foreach ($prevUsers as $prevUser) {
                foreach ($case_nos as $case) {
                    $workflowData[] = [
                        'application_id' => $application_id,
                        'step_id' => $prevStepOrder,
                        'case_no' => $case['case_no'],
                        'assigned_officer_id' => $prevUser['user_code'],
                        'status' => 'Pending',
                        'started_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            if (!empty($workflowData)) {
                if (!$this->db->insert_batch('ancillary_application_workflow', $workflowData)) {
                    throw new Exception('Failed to create workflow entries for the previous step.');
                }
            }

            // Commit transaction
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception('Transaction failed.');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Case has been reverted to the previous user.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error in previousUser: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
        }

        $redirect_url = 'AncillaryController';
        redirect($redirect_url);
    }

    public function nextUser()
    {

        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";
        // die;
        $isNextUserAvailable = $this->input->post('is_user_available');
        $nextAdc = $this->input->post('adc_user');
        $this->db->trans_begin();

        try {
            // Check if the request is a POST request
            if ($this->input->server('REQUEST_METHOD') !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Get form data
            $rtps_no = $this->input->post('rtps_no');
            $remarks = $this->input->post('remarks');

            // Validate input
            if (empty($rtps_no) || empty($remarks)) {
                throw new Exception('RTPS number and remarks are required.');
            }

            // Get current user data
            $current_user = $this->session->userdata('user_code');
            $current_user_desig = $this->session->userdata('user_desig_code');



            if (empty($current_user) || empty($current_user_desig)) {
                throw new Exception('User session data not found.');
            }

            // var_dump($current_user_desig);
            $current_step_id = (int) $this->getCurrentStepId($current_user_desig);


            // var_dump($current_step_id);

            $subStepIncompleteStepId = $current_step_id;

            // var_dump($subStepIncompleteStepId);

            // Get application data
            $application = $this->db->select('id, updated_at, current_step_id')
                ->where('rtps_ref_no', $rtps_no)
                ->get('ancillary_applications')
                ->row();

            if (empty($application)) {
                throw new Exception('Application not found.');
            }

            $applicationCurrentStepId = (int) $application->current_step_id;

            if ($applicationCurrentStepId != $current_step_id) {
                $current_step_id = $applicationCurrentStepId;
            }

            // Get the next step in the workflow
            $nextUserData = $this->db->select('*')
                ->where('step_order >', $current_step_id)
                ->where('is_active', '1')
                ->order_by('step_order', 'ASC')
                ->limit(1)
                ->get('ancillary_workflow_steps')
                ->row();

            if (empty($nextUserData)) {
                $nextUserData = $this->db->select('*')
                    ->where('step_order >', $subStepIncompleteStepId)
                    ->where('is_active', '1')
                    ->order_by('step_order', 'ASC')
                    ->limit(1)
                    ->get('ancillary_workflow_steps')
                    ->row();
            }



            if (empty($nextUserData)) {
                throw new Exception('No next step found in the workflow.');
            }

            $nextUserDesig = $nextUserData->user_desig;
            // var_dump($nextUserDesig);
            // die;
            $nextStepOrder = $nextUserData->step_order;
            // var_dump($nextStepOrder);
            // die;


            $landDetails = $this->db->select('*')->get_where('ancillary_land_details', ['application_id' => $application->id])->result_array();

            $landDetailsCurrentStepId = 0;
            foreach ($landDetails as $landDetail) {
                $users = $this->db->select('*')
                    ->from('loginuser_table lt')
                    ->join('users u', 'lt.user_code = u.user_code')
                    ->where('lt.dist_code', $landDetail['district_code'])
                    ->where('lt.subdiv_code', $landDetail['subdiv_code'])
                    ->where('lt.cir_code', $landDetail['circle_code'])
                    ->where('lt.mouza_pargona_code', '00')
                    ->where('u.user_desig_code', $current_user_desig)
                    ->where('lt.dis_enb_option', 'E')
                    ->get()
                    ->result_array();

                if (!empty($users)) {
                    foreach ($users as $user) {
                        if ($user['user_code'] == $current_user) {
                            $landDetailsCurrentStepId = $landDetail['current_step_id'];
                        }
                    }
                }
            }


            // $flag = false;

            // if($applicationCurrentStepId != $current_step_id) {
            //     $flag = true;
            // }

            // if($landDetailsCurrentStepId != $current_step_id) {
            //     $flag = true;
            // } else {
            //     $flag = false;
            // }


            // // TODO: change required here for pending subcase
            // if($flag)
            // {
            //     throw new Exception("You are not authorized to Forward this application.");
            // }



            $application_id = $application->id;


            // Update current step as completed
            $currentStepWorkflowData = [
                'status' => 'Completed',
                'completed_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('application_id', $application_id);
            $this->db->where('step_id', $current_step_id);
            $this->db->where('assigned_officer_id', $current_user);
            if (!$this->db->update('ancillary_application_workflow', $currentStepWorkflowData)) {
                throw new Exception('Failed to update current workflow step.');
            }

            $case_nos = $this->db->select('case_no')
                ->where('application_id', $application_id)
                ->where('step_id', $current_step_id)
                ->where('assigned_officer_id', $current_user)
                ->get('ancillary_application_workflow')
                ->result_array();

            if (empty($case_nos)) {
                $case_nos = $this->db->select('case_no')
                    ->where('application_id', $application_id)
                    ->where('step_id', $subStepIncompleteStepId)
                    ->where('assigned_officer_id', $current_user)
                    ->get('ancillary_application_workflow')
                    ->result_array();
            }



            // var_dump($current_step_id);
            // var_dump($subStepIncompleteStepId);
            $land_details = $this->db->select('*')
                ->where('application_id', $application_id)
                ->where_in('sub_case_no', array_column($case_nos, 'case_no'))
                ->where_in('current_step_id', $subStepIncompleteStepId)
                ->get('ancillary_land_details');

            if ($land_details->num_rows() == 0) {
                $land_details = $this->db->select('*')
                    ->where('application_id', $application_id)
                    ->where_in('sub_case_no', array_column($case_nos, 'case_no'))
                    ->where_in('current_step_id', $current_step_id)
                    ->get('ancillary_land_details');

                $subStepIncompleteStepId = $current_step_id;
            }

            //     echo $this->db->last_query();
            // var_dump($subStepIncompleteStepId);


            if (empty($land_details)) {
                throw new Exception('No land details found for this application.');
            } else {
                $land_details = $land_details->result_array();
            }

            // var_dump($land_details);
            // die;

            // var_dump($nextStepOrder);
            // die;

            $land_details_update_data = [
                'current_step_id' => $nextStepOrder,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('application_id', $application_id);
            $this->db->where_in('sub_case_no', array_column($case_nos, 'case_no'));
            if (!$this->db->update('ancillary_land_details', $land_details_update_data)) {
                throw new Exception('Failed to update land details.');
            }

            // Update application with next step
            $applicationCurrentStepId = $application->current_step_id;

            if ($applicationCurrentStepId > $nextStepOrder) {
                $applicationUpdateData = [
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $applicationUpdateData = [
                    'current_step_id' => $nextStepOrder,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            $this->db->where('id', $application_id);
            if (!$this->db->update('ancillary_applications', $applicationUpdateData)) {
                throw new Exception('Failed to update application status.');
            }

            $lmNoteUpdateData = [];
            if ($current_user_desig == 'LM') {
                // Collect LM Note inputs from POST
                // Expecting inputs as: lm[possession_since], lm[tribal_belt_block], lm[landslide_prone],
                // lm[wetland], lm[schedule_and_occupation], lm[recommendation]
                // and a dag_items associative array: dag_items[<index>][dag_no|nature_of_possession|reservation_comment]
                $lmInput = $this->input->post('lm');
                $dagItemsInput = $this->input->post('dag_items');
                $premiumInput = $this->input->post('premium');

                // Normalize to arrays
                if (!is_array($lmInput)) {
                    $lmInput = [];
                }
                if (!is_array($dagItemsInput)) {
                    $dagItemsInput = [];
                }

                $lmNoteUpdateData = [
                    'possession_date' => isset($lmInput['possession_since']) ? $lmInput['possession_since'] : null,
                    'is_tribal_belt' => isset($lmInput['tribal_belt_block']) ? $lmInput['tribal_belt_block'] : null,
                    'is_landslide' => isset($lmInput['landslide_prone']) ? $lmInput['landslide_prone'] : null,
                    'is_wetland' => isset($lmInput['wetland']) ? $lmInput['wetland'] : null,
                    'schedule_details' => isset($lmInput['schedule_and_occupation']) ? $lmInput['schedule_and_occupation'] : null,
                    'recommendation' => isset($lmInput['recommendation']) ? $lmInput['recommendation'] : null,
                    'recommendation_remark' => $this->input->post('remarks'),
                    'case_no' => $case_nos[0]['case_no'],
                    'application_id' => $application_id
                ];

                // Check if record exists
                $this->db->where('case_no', $case_nos[0]['case_no']);
                $this->db->where('application_id', $application_id);
                $query = $this->db->get('ancillary_lmnote');

                if ($query->num_rows() > 0) {
                    // Update existing record
                    $this->db->where('case_no', $case_nos[0]['case_no']);
                    $this->db->where('application_id', $application_id);
                    if (!$this->db->update('ancillary_lmnote', $lmNoteUpdateData)) {
                        throw new Exception('Failed to update LRA checklist');
                    }
                } else {
                    // Insert new record
                    if (!$this->db->insert('ancillary_lmnote', $lmNoteUpdateData)) {
                        throw new Exception('Failed to create LRA checklist');
                    }
                }

                // Insert/Update per-DAG reservation entries
                if (!empty($dagItemsInput) && is_array($dagItemsInput)) {
                    foreach ($dagItemsInput as $item) {
                        $dag_no = isset($item['dag_no']) ? $item['dag_no'] : null;
                        $reservationData = [
                            'applid' => $rtps_no,
                            'case_no' => $case_nos[0]['case_no'] ?? null,
                            'dag_no' => $dag_no,
                            'nature_of_possession' => isset($item['nature_of_possession']) ? $item['nature_of_possession'] : null,
                            'reservation_comment' => isset($item['reservation_comment']) ? $item['reservation_comment'] : null,
                            'bigha' => isset($item['reservation_bigha']) ? $item['reservation_bigha'] : null,
                            'katha' => isset($item['reservation_katha']) ? $item['reservation_katha'] : null,
                            'lessa' => isset($item['reservation_lessa']) ? $item['reservation_lessa'] : null,
                            'ganda' => isset($item['reservation_ganda']) ? $item['reservation_ganda'] : null,
                            'lm_code' => $current_user,
                            'date_update' => date('Y-m-d H:i:s'),
                            'dist_code' => isset($item['district_code']) ? $item['district_code'] : null,
                            'subdiv_code' => isset($item['subdiv_code']) ? $item['subdiv_code'] : null,
                            'cir_code' => isset($item['circle_code']) ? $item['circle_code'] : null,
                            'mouza_pargona_code' => isset($item['mouza_code']) ? $item['mouza_code'] : null,
                            'lot_no' => isset($item['lot_no']) ? $item['lot_no'] : null,
                            'vill_townprt_code' => isset($item['village_code']) ? $item['village_code'] : null,
                        ];

                        // Check if record exists
                        $this->db->where('applid', $rtps_no);
                        $this->db->where('dag_no', $dag_no);
                        $query = $this->db->get('ancillary_reservation');

                        if ($query->num_rows() > 0) {
                            // Update existing record
                            $this->db->where('applid', $rtps_no);
                            $this->db->where('dag_no', $dag_no);
                            if (!$this->db->update('ancillary_reservation', $reservationData)) {
                                throw new Exception('Failed to update ancillary reservation for DAG: ' . $dag_no);
                            }
                        } else {
                            // Insert new record
                            $reservationData['date_entry'] = date('Y-m-d H:i:s');
                            if (!$this->db->insert('ancillary_reservation', $reservationData)) {
                                throw new Exception('Failed to insert ancillary reservation for DAG: ' . $dag_no);
                            }
                        }
                    }
                }

                if (!empty($premiumInput) && is_array($premiumInput)) {
                    foreach ($premiumInput as $dag_no => $item) {
                        $case_no = $case_nos[0]['case_no'] ?? null;
                        $premiumData = [
                            'user_code' => $current_user,
                            'case_no' => $case_no,
                            'dag_no' => $dag_no,
                            'zonal_valuation' => $item['zonal_value'] ?? null,
                            'land_type' => $item['area_id'] ?? null,
                            'rate_type' => $item['rate_type'] ?? null,
                            'total_premium' => $this->input->post('premium_total'),
                            'amount_dag' => $item['amount'] ?? null,
                            // 'proposed_class_code' => $item['proposed_class_code'] ?? null,
                            // 'area_id' => $item['area_id'] ?? null,
                            // 'area_cat' => $item['area_cat'] ?? null,
                            // 'land_class_code' => $item['land_class_code'] ?? null,
                        ];

                        // Check if record exists
                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', (string)$dag_no); // Ensure dag_no is treated as string
                        $query = $this->db->get('ancillary_premium');
                        if ($query->num_rows() > 0) {
                            // Update existing record
                            $this->db->where('case_no', $case_no);
                            $this->db->where('dag_no', (string)$dag_no); // Ensure dag_no is treated as string
                            if (!$this->db->update('ancillary_premium', $premiumData)) {
                                throw new Exception('Failed to update ancillary premium for DAG: ' . $dag_no);
                            }
                        } else {
                            // Insert new record
                            $premiumData['date_entry'] = date('Y-m-d H:i:s');
                            // Uncomment if needed
                            // $premiumData['created_on'] = date('Y-m-d H:i:s');
                            if (!$this->db->insert('ancillary_premium', $premiumData)) {
                                throw new Exception('Failed to insert ancillary premium for DAG: ' . $dag_no);
                            }
                        }
                    }
                }

                if (!empty($_FILES['dag_items']['name'])) {

                    $uploadPath = UPLOAD_DIR;
                    if (!is_dir($uploadPath) && !mkdir($uploadPath, 0777, true)) {
                        $this->db->trans_rollback();
                        throw new Exception('Failed to create upload directory');
                    }

                    $uploadSuccess = true;
                    $errorMessage = '';

                    foreach ($_FILES['dag_items']['name'] as $dagNo => $files) {

                        if (isset($files['visit_report'])) {
                            try {
                                $file = $_FILES['dag_items'];

                                $fileData = [
                                    'name'     => $file['name'][$dagNo]['visit_report'],
                                    'type'     => $file['type'][$dagNo]['visit_report'],
                                    'tmp_name' => $file['tmp_name'][$dagNo]['visit_report'],
                                    'error'    => $file['error'][$dagNo]['visit_report'],
                                    'size'     => $file['size'][$dagNo]['visit_report']
                                ];

                                if ($fileData['error'] === UPLOAD_ERR_NO_FILE) {
                                    continue;
                                }

                                if ($fileData['error'] !== UPLOAD_ERR_OK) {
                                    throw new Exception('File upload error: ' . $fileData['error']);
                                }

                                $mime = mime_content_type($fileData['tmp_name']);
                                if (!$mime) {
                                    throw new Exception('Invalid file type');
                                }

                                $exp = explode("/", $mime);
                                $onlyExtension = $exp[1];
                                $fileRename = $this->UUID4() . '.' . $onlyExtension;

                                $config = [
                                    'upload_path'   => $uploadPath,
                                    'allowed_types' => 'pdf|doc|docx|jpg|jpeg|png',
                                    'max_size'      => 10240,
                                    'file_name'     => $fileRename
                                ];

                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);

                                $_FILES['single_file'] = $fileData;

                                if (!$this->upload->do_upload('single_file')) {
                                    throw new Exception('File upload failed: ' . $this->upload->display_errors('', ''));
                                }

                                $uploadData = $this->upload->data();

                                $document = [
                                    'case_no'         => $_POST['case_no'],
                                    'dag_no'          => $dagNo,
                                    'file_name'       => 'FIELD_VISIT',
                                    'user_code'       => $this->session->userdata('user_code'),
                                    'fetch_file_name' => $fileData['name'],
                                    'file_type'       => $fileData['type'],
                                    'file_path'       => $uploadPath . $fileRename,
                                    'date_entry'      => date('Y-m-d H:i:s'),
                                    'mut_type'        => '01'
                                ];

                                if (!$this->db->insert('supportive_document', $document)) {
                                    throw new Exception('Failed to insert document record');
                                }
                            } catch (Exception $e) {
                                $uploadSuccess = false;
                                $errorMessage = 'Error with DAG ' . $dagNo . ' visit report: ' . $e->getMessage();
                                break;
                            }
                        }

                        if (!empty($files['photos'])) {

                            $file = $_FILES['dag_items'];

                            foreach ($files['photos'] as $index => $photoName) {

                                if (empty($photoName)) continue;

                                try {
                                    $fileData = [
                                        'name'     => $file['name'][$dagNo]['photos'][$index],
                                        'type'     => $file['type'][$dagNo]['photos'][$index],
                                        'tmp_name' => $file['tmp_name'][$dagNo]['photos'][$index],
                                        'error'    => $file['error'][$dagNo]['photos'][$index],
                                        'size'     => $file['size'][$dagNo]['photos'][$index]
                                    ];

                                    if ($fileData['error'] === UPLOAD_ERR_NO_FILE) {
                                        continue;
                                    }

                                    if ($fileData['error'] !== UPLOAD_ERR_OK) {
                                        throw new Exception('Photo upload error: ' . $fileData['error']);
                                    }

                                    $mime = mime_content_type($fileData['tmp_name']);
                                    if (!$mime) {
                                        throw new Exception('Invalid photo file type');
                                    }

                                    $exp = explode("/", $mime);
                                    $onlyExtension = $exp[1];
                                    $fileRename = $this->UUID4() . '.' . $onlyExtension;

                                    $config = [
                                        'upload_path'   => $uploadPath,
                                        'allowed_types' => 'jpg|jpeg|png',
                                        'max_size'      => 10240,
                                        'file_name'     => $fileRename
                                    ];

                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);

                                    $_FILES['single_file'] = $fileData;

                                    if (!$this->upload->do_upload('single_file')) {
                                        throw new Exception('Photo upload failed: ' . $this->upload->display_errors('', ''));
                                    }

                                    $uploadData = $this->upload->data();

                                    $document = [
                                        'case_no'         => $_POST['case_no'],
                                        'dag_no'          => $dagNo,
                                        'file_name'       => 'GEO_TAG',
                                        'user_code'       => $this->session->userdata('user_code'),
                                        'fetch_file_name' => $fileData['name'],
                                        'file_type'       => $fileData['type'],
                                        'file_path'       => $uploadPath . $fileRename,
                                        'date_entry'      => date('Y-m-d H:i:s'),
                                        'mut_type'        => '01'
                                    ];

                                    if (!$this->db->insert('supportive_document', $document)) {
                                        throw new Exception('Failed to insert photo record');
                                    }
                                } catch (Exception $e) {
                                    $uploadSuccess = false;
                                    $errorMessage = 'Error with DAG ' . $dagNo . ' photo ' . ($index + 1) . ': ' . $e->getMessage();
                                    break;
                                }
                            }

                            if (!$uploadSuccess) break;
                        }
                    }

                    if (!$uploadSuccess) {
                        $this->db->trans_rollback();
                        throw new Exception($errorMessage);
                    }
                }
            }



            $nextUsers = $this->getUsersForNextStep($land_details, $nextUserDesig);


            // var_dump($nextUsers);die;



            if ($isNextUserAvailable == 1) {
                $nextUsers = $this->getUsersForNextStep($land_details, $nextUserDesig, $nextAdc);
            }

            // var_dump($nextUsers);die;

            if (empty($nextUsers)) {
                throw new Exception('No active officers found for the next step.');
            }

            foreach ($nextUsers as $userData) {
                $nextWorkflowData = [
                    'application_id' => $application_id,
                    'step_id' => $nextStepOrder,
                    'status' => 'Pending',
                    'assigned_officer_id' => $userData['user_code'],
                    'case_no' => $userData['sub_case_no'],
                    'remarks' => $remarks,
                    'started_at' => date('Y-m-d H:i:s'),
                ];
                if (!$this->db->insert('ancillary_application_workflow', $nextWorkflowData)) {
                    throw new Exception('Failed to create workflow for next step.');
                }
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Application has been forwarded successfully.');
        } catch (Exception $e) {

            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
        }

        $redirect_url = 'AncillaryController';
        redirect($redirect_url);
    }

    /**
     * Generate a UUID v4
     * @return string
     */
    private function UUID4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

/* End of file AncillaryController.php */
/* Location: ./application/controllers/AncillaryController.php */
