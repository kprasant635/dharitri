<?php

class LandShareUpdation extends CI_Controller
{

    var $user_code;
    var $config = array();
    var $language;
    var $append = '';
    var $base_query = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        //   $this->dbswitch();
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->load->model('LandShare/LandShareModel');
        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('ZonalInformation/zonalinformationmodel');
        $this->load->model('mutation/mutationmodel');
        //var_dump($this->session->all_userdata());
    }

    // Search/Update Zonal Information by LM
    public function LandShareDagSelect()
    {

        if ($this->session->unset_userdata('vill_code')) {
            $this->session->unset_userdata('patta_no');
            $this->session->unset_userdata('mut_type');
            $this->session->unset_userdata('trans_code');
            $this->session->unset_userdata('patta_type');
            $this->session->unset_userdata('dag_no');
            $this->session->unset_userdata('vill_code');
        }
        $this->session->unset_userdata('appdet');
        $this->session->unset_userdata('dag_det');
        $this->session->unset_userdata('patdet');
        $this->session->unset_userdata('fmb');
        $this->session->unset_userdata('start');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));
        $data = $this->LandShareModel->getVillageForZonalUpdationJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $village['villages'] = $data;

        $village['_view'] = 'LandShareUpdation/land_share_updation';
        $this->load->view('layouts/main', $village);
    }

    public function getDagNumber()
    {
        // POST data 
        $postData = $this->input->post();
        // load model 
        $this->load->model('LandShare/LandShareModel');
        // get data 
        $data = $this->LandShareModel->getDagNumber2($postData);
        echo json_encode($data);
    }

    public function landShareDetails()
    {

        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $circle_code = $this->session->userdata('cir_code');
        $data['mouza_code'] = $mouza_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no');
        $data['vill_code'] =  $vill_code = $this->input->post('vill_code');

        $data['pendinglandsharedetials'] = $this->LandShareModel->getPendingLandShareDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $data['updatedlandsharedetials'] = $this->LandShareModel->getUpdatedLandShareDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $data['revertedlandsharedetials'] = $this->LandShareModel->getRevertedLandShareDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        // var_dump($data['pendinglandsharedetials']);
        $data['_view'] = 'LandShareUpdation/landshare_details';

        $this->load->view('layouts/main', $data);
    }


    //**************************Bidptas Module*****************************/


    // Getting The Land Share Pattadar Details in view Modal
    public function getLandShareDetails()
    {
        $landShareDetailsSearchArr = [

            'dist_code' => $this->session->userdata('dist_code'),
            'subdiv_code' => $this->session->userdata('subdiv_code'),
            'cir_code' => $this->session->userdata('cir_code'),
            'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
            'lot_no' => $this->session->userdata('lot_no'),
            'vill_townprt_code' => trim($_POST['vill_code']),
            'dag_no' => trim($_POST['lb_view_form_dag_no']),
        ];
        $landShareDetailsAll = $this->LandShareModel->getAllLandShareDetailsDagWise($landShareDetailsSearchArr);
        echo json_encode($landShareDetailsAll);
    }

    // Getting Data in LandShare Pattadar Details in view Modal End

    //getting all the master table gender list
    public function getGenderList()
    {
        $gender_list = $this->LandShareModel->getAllGenderList();
        echo $gender_list;
    }

    // getting all the master table caste list
    public function getCasteList()
    {
        $caste_list = $this->LandShareModel->getAllCasteList();
        echo $caste_list;
    }

    // getting all the Filled LandShare Pattadar Details from "land_share_indivisual_details" to be shown in edit modal 
    public function getLandShareDetailsForEdit()
    {
        $landShareDetailsSearchArr = [
            'dist_code' => trim($_POST['dist_code']),
            'subdiv_code' => trim($_POST['subdiv_code']),
            'cir_code' => trim($_POST['circle_code']),
            'mouza_pargona_code' => trim($_POST['mouza_code']),
            'lot_no' => trim($_POST['lot_no']),
            'vill_townprt_code' => trim($_POST['vill_code']),
            'dag_no' => trim($_POST['land_share_update_form_dag_no']),
        ];
        $landShareDetailsAll = $this->LandShareModel->getAllLandShareDetailsDagWise($landShareDetailsSearchArr);
        echo json_encode($landShareDetailsAll);
    }


    // getting all the existing pattadar details from "chitha_pattadar" to be shown in add modal 
    public function getLandShareDetailsForAdd()
    {
        $chithaPattadarDetailsSearchArr = [
            'dist_code' => trim($_POST['dist_code']),
            'subdiv_code' => trim($_POST['subdiv_code']),
            'cir_code' => trim($_POST['circle_code']),
            'mouza_pargona_code' => trim($_POST['mouza_code']),
            'lot_no' => trim($_POST['lot_no']),
            'vill_townprt_code' => trim($_POST['vill_code']),
            'dag_no' => trim($_POST['land_share_add_form_dag_no']),
            'patta_no' => trim($_POST['land_share_add_form_patta_no'])
        ];
        $chithaPattadarDetailsAll = $this->LandShareModel->getAllLandShareDetailsDagWiseForAdd($chithaPattadarDetailsSearchArr);
        echo json_encode($chithaPattadarDetailsAll);
    }



    // Add Land Share Pattadar Details Submit Post Method by LM
    public function landSharePattadarDetailsAdd()
    {
        //*******************Validation-Start******************/    

        $dis_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $_POST['v_vill_townprt_code'] = $_POST['vill_code'];
        $dag_no = $_POST['v_dag_no'] = $_POST['land_share_add_form_dag_no'];
        $dag_area_chitha_bigha = $_POST['v_dag_area_b'] = $_POST['land_share_add_form_dag_area_b'];
        $dag_area_chitha_katha = $_POST['v_dag_area_k'] = $_POST['land_share_add_form_dag_area_k'];
        $dag_area_chitha_lessa = $_POST['v_dag_area_lc'] = $_POST['land_share_add_form_dag_area_lc'];
        $_POST['v_no_of_indivisuals_add_form'] = $_POST['no_of_indivisuals_add_form'];
        $error_msg = array();

        // Dag Area From Input Field (in Bigha, Katha and Lessa )
        $total_share_area_input_bigha = array_sum($_POST['add_share_area_b']);
        $total_share_area_input_katha = array_sum($_POST['add_share_area_k']);
        $total_share_area_input_lessa = array_sum($_POST['add_share_area_lc']);

        // Total Area of the Land From Chitha Basic in Lessa
        if(in_array($dis_code, json_decode(BARAK_VALLEY))){
            $total_dag_area_lessa = floatval((int)($dag_area_chitha_bigha * 6400) + (int)($dag_area_chitha_katha * 320) + $dag_area_chitha_lessa*20);
            $total_share_area_input_lesssa_converted = floatval((int)($total_share_area_input_bigha * 6400) + (int)($total_share_area_input_katha * 320) + $total_share_area_input_lessa*20);
            $max_length_area_for_validate  = '17';
        }else{
            $total_dag_area_lessa = floatval((int)($dag_area_chitha_bigha * 100) + (int)($dag_area_chitha_katha * 20) + $dag_area_chitha_lessa);
            $total_share_area_input_lesssa_converted = floatval((int)($total_share_area_input_bigha * 100) + (int)($total_share_area_input_katha * 20) + $total_share_area_input_lessa);
            $max_length_area_for_validate  = '5';
        }

        

        // Total Dag Area from input field in Lessa
        

        $lb_add_val = [
            [
                'field' => 'v_vill_townprt_code',
                'label' => 'Village-Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'v_dag_no',
                'label' => 'Dag-No',
                'rules' => 'required|callback_check_script|max_length[12]|trim|xss_clean'
            ],
            [
                'field' => 'v_no_of_indivisuals_add_form',
                'label' => 'No-Of-Pattadar',
                'rules' => 'integer|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
        $this->form_validation->set_rules($lb_add_val);
        if ($this->form_validation->run() == FALSE) {
            foreach ($lb_add_val as $rule) {
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        //validation data for Pattadar indivisual's details in Add Form
        $no_of_indivisual = $_POST['no_of_indivisuals_add_form'];
        $pattadar_row_count = 1;
        // if ($no_of_indivisual >= 0) {
        for ($i = 0; $i <= ($no_of_indivisual); $i++) {
            $_POST['v_pattadar_name'] = $_POST['add_pattadar_name'][$i];
            $_POST['v_pattadar_english_name'] = $_POST['add_pattadar_english_name'][$i];
            $_POST['v_pattadar_father_name'] = $_POST['add_pattadar_father_name'][$i];
            $_POST['v_pattadar_father_english_name'] = $_POST['add_pattadar_father_english_name'][$i];
            $_POST['v_pattadar_dob'] = $_POST['add_pattadar_dob'][$i];
            $_POST['v_pattadar_gender'] = $_POST['add_pattadar_gender'][$i];
            $add_share_area_b = $_POST['v_share_area_b'] = $_POST['add_share_area_b'][$i];
            $add_share_area_k = $_POST['v_share_area_k'] = $_POST['add_share_area_k'][$i];
            $add_share_area_lc = $_POST['v_share_area_lc'] = $_POST['add_share_area_lc'][$i];
            $_POST['v_pattadar_id'] = $_POST['add_pattadar_id'][$i];
            $ls_indivisual_val = [
                [
                    'field' => 'v_pattadar_name',
                    'label' => 'Pattadar Name (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                ],
                [
                    'field' => 'v_pattadar_english_name',
                    'label' => 'Pattadar English Name (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                ],
                [
                    'field' => 'v_pattadar_father_name',
                    'label' => 'Pattadar Father Name (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                ],
                [
                    'field' => 'v_pattadar_father_english_name',
                    'label' => 'Pattadar Father English Name (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                ],
                [
                    'field' => 'v_pattadar_dob',
                    'label' => 'Pattadar Date of Birth  (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
                ],
                [
                    'field' => 'v_pattadar_gender',
                    'label' => 'Pattadar Gender (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|callback_check_script|less_than_equal_to[3]|numeric|trim|xss_clean'
                ],
                [
                    'field' => 'v_pattadar_id',
                    'label' => 'Pattadar id (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|integer|trim|xss_clean'
                ],
                [
                    'field' => 'v_share_area_b',
                    'label' => 'Dag Share Area Bigha (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|numeric|greater_than_equal_to[0]|trim|xss_clean'
                ],
                [
                    'field' => 'v_share_area_k',
                    'label' => 'Dag Share Area Katha (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|numeric|less_than['.$max_length_area_for_validate.']|greater_than_equal_to[0]|trim|xss_clean'
                ],
                [
                    'field' => 'v_share_area_lc',
                    'label' => 'Dag Share Area Lessa (Row-' . $pattadar_row_count . ')',
                    'rules' => 'required|numeric|less_than[20]|greater_than_equal_to[0]|trim|xss_clean'
                ],
                
            ];
            $this->form_validation->set_rules($ls_indivisual_val);
            $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
            if ($this->form_validation->run() == FALSE) {
                foreach ($ls_indivisual_val as $rule) {
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }
            }
            //Date of Birth logical validation                 
            $Pattadar_dob = strtotime($_POST['v_pattadar_dob']);
            $date_now = strtotime(date("Y-m-d"));
            if ($Pattadar_dob > $date_now) {
                echo json_encode(
                    [
                        'result' => 'logical_validation_error',
                        'msg' => "'Pattadar DOB' Can't Be Greater Than Today in Row-no " . ((int)$i + 1) . ", Please fill the dates correctly!"
                    ]
                );
                exit;
            }
            // Land Share Input Area Validation
            if ($total_dag_area_lessa < $total_share_area_input_lesssa_converted) {
                echo json_encode(
                    [
                        'result' => 'logical_validation_error',
                        'msg' => "Total Share Area Must Be Less Than or Equal To Original Dag Area(" . $dag_area_chitha_bigha . "-Bigha, " . $dag_area_chitha_katha . "-Katha, " . $dag_area_chitha_lessa . "-Lessa)"
                    ]
                );
                exit;
            }
            //*******************Add Form Validation-End******************/
            $pattadar_row_count++;
        }


        if (count($error_msg) != 0) {
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        $village_uuid = $this->LandShareModel->getVillageUUID(
            trim($dis_code),
            trim($subdiv_code),
            trim($circle_code),
            trim($mouza_code),
            trim($lot_no),
            trim($_POST['vill_code'])
        );

        $insertion_data_for_land_share_details = [
            'dist_code' => $dis_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'village_uuid' => $village_uuid,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no' => $dag_no,
            'share_area_b' => $dag_area_chitha_bigha,
            'share_area_k' => $dag_area_chitha_katha,
            'share_area_lc' => $dag_area_chitha_lessa,
            'created_at' => date('Y-m-d H:i:s'),
            'no_of_indivisual' =>  $no_of_indivisual + '1',
            'flag' => '0',
        ];
        $no_of_indivisual = $_POST['no_of_indivisuals_add_form'];
        $insertion_data_for_indivisual_details_arr = array();
        for ($i = 0; $i <= ($no_of_indivisual); $i++) {
            array_push($insertion_data_for_indivisual_details_arr, [
                'name' => $_POST['add_pattadar_name'][$i],
                'english_name' => $_POST['add_pattadar_english_name'][$i],
                'father_name' => $_POST['add_pattadar_father_name'][$i],
                'father_english_name' => $_POST['add_pattadar_father_english_name'][$i],
                'pdar_dob' => $_POST['add_pattadar_dob'][$i],
                'gender' => $_POST['add_pattadar_gender'][$i],
                'share_area_b' => $_POST['add_share_area_b'][$i],
                'share_area_k' => $_POST['add_share_area_k'][$i],
                'share_area_lc' => $_POST['add_share_area_lc'][$i],
                'share_area_lc' => $_POST['add_share_area_lc'][$i],
                'pdar_id' => $_POST['add_pattadar_id'][$i],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $addFlag = $this->LandShareModel->addLandShareAndIndivisualDetails($insertion_data_for_land_share_details, $insertion_data_for_indivisual_details_arr);
        echo json_encode($addFlag);
    }
    // Add Land Share Details Submit Post Method End


    // land Share Details Re Update Post Method Begin
    public function landShareDetailsReUpdateLM()
    {
        //*******************Validation-Start******************/    
        $dis_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $_POST['v_vill_townprt_code'] = $_POST['vill_code'];
        $dag_no = $_POST['v_dag_no'] = $_POST['land_share_update_form_dag_no'];
        $_POST['no_of_indivisuals_update_form'] = $_POST['no_of_indivisuals_update_form'];
        $dag_area_chitha_bigha = $_POST['v_dag_area_b'] = $_POST['land_share_update_form_dag_area_b'];
        $dag_area_chitha_katha = $_POST['v_dag_area_k'] = $_POST['land_share_update_form_dag_area_k'];
        $dag_area_chitha_lessa = $_POST['v_dag_area_lc'] = $_POST['land_share_update_form_dag_area_lc'];

        // Total Area of the Land From Chitha Basic in Lessa
        $total_dag_area_lessa = floatval((int)($dag_area_chitha_bigha * 100) + (int)($dag_area_chitha_katha * 20) + $dag_area_chitha_lessa);

        // var_dump($total_dag_area_lessa);
        // Dag Area From Input Field (in Bigha, Katha and Lessa )
        $total_share_area_input_bigha = array_sum($_POST['update_share_area_b']);
        $total_share_area_input_katha = array_sum($_POST['update_share_area_k']);
        $total_share_area_input_lessa = array_sum($_POST['update_share_area_lc']);

        // Total Dag Area from input field in Lessa
        $total_share_area_input_lesssa_converted = floatval((int)($total_share_area_input_bigha * 100) + (int)($total_share_area_input_katha * 20) + $total_share_area_input_lessa);

        $error_msg = array();
        $lb_add_val = [
            [
                'field' => 'v_vill_townprt_code',
                'label' => 'Village-Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'v_dag_no',
                'label' => 'Dag-No',
                'rules' => 'required|callback_check_script|max_length[12]|trim|xss_clean'
            ],
            [
                'field' => 'no_of_indivisuals_update_form',
                'label' => 'No-Of-Pattadar',
                'rules' => 'integer|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid', 'Please Fill The %s Correctly!');
        $this->form_validation->set_rules($lb_add_val);
        if ($this->form_validation->run() == FALSE) {
            foreach ($lb_add_val as $rule) {
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }
        }

        //validation data for Pattadar's details
        $no_of_indivisual = $_POST['no_of_indivisuals_update_form'];
        $pattadar_row_count = 1;
        if ($no_of_indivisual > 0) {
            for ($i = 0; $i <= ($no_of_indivisual - 1); $i++) {
                $_POST['v_name'] = $_POST['update_indivisual_name'][$i];
                $_POST['v_english_name'] = $_POST['update_english_name'][$i];
                $_POST['v_father_name'] = $_POST['update_father_name'][$i];
                $_POST['v_father_english_name'] = $_POST['update_father_english_name'][$i];
                $_POST['v_indivisual_dob'] = $_POST['update_indivisual_dob'][$i];
                $_POST['v_gender'] = $_POST['update_en_gender'][$i];
                $_POST['v_update_share_area_b'] = $_POST['update_share_area_b'][$i];
                $_POST['v_update_share_area_k'] = $_POST['update_share_area_k'][$i];
                $_POST['v_update_share_area_lc'] = $_POST['update_share_area_lc'][$i];
                $_POST['v_pattadar_row_id'] = $_POST['pattadar_table_id'][$i];
                $lb_enc_val = [
                    [
                        'field' => 'v_name',
                        'label' => 'Pattadar Name (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_english_name',
                        'label' => 'Pattadar Name in English(Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_father_name',
                        'label' => 'Pattadar Father Name (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_father_english_name',
                        'label' => 'Pattadar Father English Name (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_indivisual_dob',
                        'label' => 'Pattadar Date Of Birth (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|xss_clean'
                    ],
                    [
                        'field' => 'v_pattadar_row_id',
                        'label' => 'Pattadar id (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|integer|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_update_share_area_b',
                        'label' => 'Dag Share Area Bigha (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|numeric|greater_than_equal_to[0]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_update_share_area_k',
                        'label' => 'Dag Share Area Katha (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|numeric|less_than[5]|greater_than_equal_to[0]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_update_share_area_lc',
                        'label' => 'Dag Share Area Lessa (Row-' . $pattadar_row_count . ')',
                        'rules' => 'required|numeric|less_than[20]|greater_than_equal_to[0]|trim|xss_clean'
                    ],
                ];
                $this->form_validation->set_rules($lb_enc_val);
                $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
                $this->form_validation->set_message('date_valid', 'Please Fill The %s Correctly!');
                if ($this->form_validation->run() == FALSE) {
                    foreach ($lb_enc_val as $rule) {
                        if (form_error($rule['field'])) {
                            array_push($error_msg, form_error($rule['field']));
                        }
                    }
                }

                //Date of Birth logical validation                 
                $Pattadar_update_dob = strtotime($_POST['v_indivisual_dob']);
                $date_now = strtotime(date("Y-m-d"));
                if ($Pattadar_update_dob > $date_now) {
                    echo json_encode(
                        [
                            'result' => 'logical_validation_error',
                            'msg' => "'Pattadar DOB' Can't Be Greater Than Today in Row-no " . ((int)$i + 1) . ", Please fill the dates correctly!"
                        ]
                    );
                    exit;
                }
                // Land Share Input Area Validation in Reupdate by LM
                if ($total_dag_area_lessa < $total_share_area_input_lesssa_converted) {
                    echo json_encode(
                        [
                            'result' => 'logical_validation_error',
                            'msg' => "Total Share Area Must Be Less Than or Equal To Original Dag Area(" . $dag_area_chitha_bigha . "-Bigha, " . $dag_area_chitha_katha . "-Katha, " . $dag_area_chitha_lessa . "-Lessa)"
                        ]
                    );
                    exit;
                }
                $pattadar_row_count++;
            }
        }
        if (count($error_msg) != 0) {
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        //*******************Validation-End******************/
        $updation_data_for_land_share_details = [
            'dist_code' => $dis_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no' => $dag_no,
            'modified_at' => date('Y-m-d H:i:s'),
            'no_of_indivisual' =>  $no_of_indivisual,
            'flag' => '0',
        ];

        $no_of_indivisual = $_POST['no_of_indivisuals_update_form'];
        $update_data_for_pattadar_details_arr = array();
        $new_pattadar_insert_data_in_updation_arr = array();
        $existing_pattadar_arr_in_update = array();
        if ((int)$no_of_indivisual > 0) {
            //new Pattadar insert in updation 
            for ($i = 0; $i <= (count($_POST['pattadar_table_id']) - 1); $i++) {
                if ((int)$_POST['pattadar_table_id'][$i] == 00) {
                    array_push($new_pattadar_insert_data_in_updation_arr, [
                        'name' => $_POST['update_indivisual_name'][$i],
                        'english_name' => $_POST['update_english_name'][$i],
                        'gender' => $_POST['update_en_gender'][$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    array_push($update_data_for_pattadar_details_arr, [
                        'existing_id' => $_POST['pattadar_table_id'][$i],
                        'name' => $_POST['update_indivisual_name'][$i],
                        'english_name' => $_POST['update_english_name'][$i],
                        'father_name' => $_POST['update_father_name'][$i],
                        'father_english_name' => $_POST['update_father_english_name'][$i],
                        'gender' => $_POST['update_en_gender'][$i],
                        'share_area_b' => $_POST['update_share_area_b'][$i],
                        'share_area_k' => $_POST['update_share_area_k'][$i],
                        'share_area_lc' => $_POST['update_share_area_lc'][$i],
                        'modified_at' => date('Y-m-d H:i:s')
                    ]);
                    array_push($existing_pattadar_arr_in_update, $_POST['pattadar_table_id'][$i]);
                }
            }
        }
        $updateFlag = $this->LandShareModel->ReupdateLandShareAndPattadarDetails(
            $updation_data_for_land_share_details,
            $new_pattadar_insert_data_in_updation_arr,
            $update_data_for_pattadar_details_arr,
            $existing_pattadar_arr_in_update
        );
        echo json_encode($updateFlag);
    }

    // land Share Details Re Update Post Method End

    //---------------------------Land Share Details at LM Side End------------------------------

    //---------------------------Land Share Details at CO Side Begin------------------------------

    // Pending Land Share Information Details at  CO End
    public function landShareDetails_dc_co()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');

        $data['pendingcount'] = $this->db->query("select count(*) as c from  land_share_details where flag='0' and dist_code ='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row()->c;

        $data['_view'] = 'LandShareUpdation/landshare_details_co';

        $this->load->view('layouts/main', $data);
    }

    // Get List of All Pending Land Share Details  at CO End
    // Newly Added
    public function getPendingLandShareDetails()
    {
        $data['select_range'] = $select_offset = $this->input->post('select_range');
        $data['dag_no_reverted'] = $dag_no_reverted = $this->input->post('dag_no_reverted');
        $data['vill_code_reverted'] =  $vill_code_reverted = $this->input->post('vill_code_reverted');

        $data['getpendingdetails'] = $this->LandShareModel->get_PendingLandShareDetailsCo($select_offset);

        $data['_view'] = 'LandShareUpdation/pendingLandShareDetails_co';

        $this->load->view('layouts/main', $data);
    }

    // Approve Land Share Details by CO requested by LM
    public function approve_LandShare_details($dag_no, $village_uuid)
    {
        $oldData = $this->db->query("SELECT * FROM land_share_details WHERE dag_no=? AND 
            village_uuid=?", array($dag_no, $village_uuid))->row();
        $data = [
            'ip' => $this->utilityclass->get_client_ip(),
            'module_name' => 'Land Share Details',
            'user_code' => $this->session->userdata('user_code'),
            'unique_village_id' => $village_uuid,
            'when_updated' => 'Approved',
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($oldData),
        ];
        $basuInsert = $this->db->insert('land_share_data_backup', $data);
        if ($basuInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT004: Insertion failed in land_share_data_backup for dag no ' . $dag_no);
            return false;
        }

        $this->LandShareModel->LandShareApprove([
            'flag' => 1,
        ], $dag_no, $village_uuid);
        echo json_encode(array(
            "statusCode" => 200
        ));
    }

    //Reject Zonal details by CO requested by LM
    public function reject_LandShare_details($dag_no, $village_uuid)
    {
        $oldData = $this->db->query("SELECT * FROM land_share_details WHERE dag_no=? AND 
            village_uuid=?", array($dag_no, $village_uuid))->row();
        $data = [
            'ip' => $this->utilityclass->get_client_ip(),
            'module_name' => 'Land Share Details',
            'user_code' => $this->session->userdata('user_code'),
            'unique_village_id' => $village_uuid,
            'when_updated' => 'Rejected',
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($oldData),
        ];
        $basuInsert = $this->db->insert('land_share_data_backup', $data);
        if ($basuInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT004: Insertion failed in land_share_data_backup for dag no ' . $dag_no);
            return false;
        }

        $this->LandShareModel->LandShareReject($dag_no, $village_uuid);
        echo json_encode(array(
            "statusCode" => 200
        ));
    }

    // Revert Land Share Details  by CO requested by LM
    public function revert_LandShare_details($dag_no, $village_uuid)
    {
        $oldData = $this->db->query("SELECT * FROM land_share_details WHERE dag_no=? AND 
            village_uuid=?", array($dag_no, $village_uuid))->row();
        $data = [
            'ip' => $this->utilityclass->get_client_ip(),
            'module_name' => 'Land Share Details',
            'user_code' => $this->session->userdata('user_code'),
            'unique_village_id' => $village_uuid,
            'when_updated' => 'Reverted',
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($oldData),
        ];
        $basuInsert = $this->db->insert('land_share_data_backup', $data);
        if ($basuInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT004: Insertion failed in land_share_data_backup for dag no ' . $dag_no);
            return false;
        }

        $this->LandShareModel->LandShareRevert([
            'flag' => 2,
        ], $dag_no, $village_uuid);
        echo json_encode(array(
            "statusCode" => 200
        ));
    }
    // Get LAnd Share Details at view Modal in CO Side
    // Newly Added
    public function getLandShareDetailsatCOSide()
    {
        $data['select_range'] = $select_offset = $this->input->post('select_range');

        $landShareDetailsSearchArr = [
            'village_uuid' => trim($_POST['lb_view_form_vill_code']),
            'dag_no' => trim($_POST['lb_view_form_dag_no']),
        ];
        $landShareDetailsAll = $this->LandShareModel->getAllLandShareDetailsCoSide($landShareDetailsSearchArr, $select_offset);
        echo json_encode($landShareDetailsAll);
    }

    // Approve Land Share Details against selected Dag no By CO
    public function approveLandShareBulk()
    {
        $this->form_validation->set_rules('dag_no', 'Dag No', 'required');
        $dag_no = $this->input->post('dag_no');
        $village_uuid = $this->input->post('village_uuid');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', 'Land Share  Approval  Failed.<br>Please Select Altest One Dag number to Approve');
            redirect(base_url() . "index.php/LandShareUpdation/getPendingLandShareDetails");
        } else {
            for ($i = 0, $k = 0; $i < count($dag_no), $k < count($village_uuid);  $i++, $k++)  {
                $result = $this->db->where(['dag_no' => $dag_no[$i]],
                    ['village_uuid' => $village_uuid[$i]]
                )
                    ->update('land_share_details', [
                    'flag' => '1',
                    'modified_at' => date('Y-m-d H:i:s')
                ]);
            }
            if ($result) {
                $this->session->set_flashdata('message', 'Land Share Details  Successfully Approved.');
                redirect(base_url() . "index.php/LandShareUpdation/getPendingLandShareDetails");
            }
        }
    }
}
