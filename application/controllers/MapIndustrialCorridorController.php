<?php
class MapIndustrialCorridorController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->load->model('mappedDags/MapIndustrialCorridorModel');
        $this->offlineutility->dbSwitchSession();


    }

    public function dbswitchmb2($district)
    {
        //$CI=&get_instance();
        if ($district == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($district == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($district == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($district == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($district == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($district == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($district == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($district == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($district == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($district == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($district == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($district == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($district == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($district == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($district == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($district == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($district == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($district == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($district == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($district == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($district == "25") {
            $this->db = $this->load->database('dha23', true);
        }
    }


    //// ******************* 02-07-2024 / Masud Reza *************************


    // home page for mapping
    public function firstLandingPageMappingInCorridor()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $user_code   = trim($this->session->userdata('user_code'));

        if($userDegCode != MB_CIRCLE_OFFICER)
        {
            $errors = "You are not Authorized !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }

        $mappingDagsListCount = $this->MapIndustrialCorridorModel->countMappedLocationByCo($dist_code,$subdiv_code,$cir_code,$user_code);
        $data['mappingDagsListCount'] = $mappingDagsListCount;

        $data['_view'] = 'MapIndustrial/first_landing_view';
        $this->load->view('layouts/main', $data);

    }


    // get Mapping home page
    public function getMapIndustrialCorridorView()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if($userDegCode != MB_CIRCLE_OFFICER)
        {
            $errors = "You are not Authorized !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }

        $sql="Select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?";
        $mouzaList = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00','00'))->result();

        $data['mouzaList'] = $mouzaList;

        $data['_view'] = 'MapIndustrial/mapping_industrial_corridor_view';
        $this->load->view('layouts/main', $data);
    }


    // generate Mapped Id
    function generateMappedIdSequenceNo()
    {
        $mappedId = $this->db->query("select nextval('mapping_of_industrial_corridor_id_seq') as count ")->row()->count;
        return $mappedId;
    }


    // save mapping dags
    public function submitMappingDags()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dist_code', 'District', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subdiv_code', 'Sub Division', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cir_code', 'Circle', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lot_no', 'Lot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('vill_townprt_code', 'Village', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMapIndustrialCorridorView');
        }

        $d = $this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->session->userdata('cir_code');
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if($userDegCode != MB_CIRCLE_OFFICER)
        {
            $errors = "You are not Authorized !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }

        $dist_code          = trim($this->input->post('dist_code'));
        $subdiv_code        = trim($this->input->post('subdiv_code'));
        $cir_code           = trim($this->input->post('cir_code'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $lot_no             = trim($this->input->post('lot_no'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
        $SelectedDags       = $this->input->post('selectedDags');
        $user_code          = trim($this->session->userdata('user_code'));

        if (empty($SelectedDags))
        {
            $errors = "There is no dags selected ! Please Select dags";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMapIndustrialCorridorView');
        }
        if($dist_code != $d || $subdiv_code != $s || $cir_code != $c)
        {
            $errors = "There is some Problem !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMapIndustrialCorridorView');
        }

        $this->db->trans_begin();
        $todayT = date('Y-m-d h:i:s');
        $ipAdd  = $this->offlineutility->get_client_ip();

        // check Already exist or not
        $mappedLocationCount = $this->MapIndustrialCorridorModel->checkMappedLocation($d,$s,$c,$mouza_pargona_code,$lot_no,$vill_townprt_code);
        if($mappedLocationCount == 0)
        {
            $mappedId = $this->generateMappedIdSequenceNo();
            $mappedLocation = [
                'id'                 => $mappedId,
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'u_type'             => $userDegCode,
                'u_code'             => $user_code,
                'status'             => 1,
                'created_at'         => $todayT,
                'updated_at'         => $todayT,
                'ip'                 => $ipAdd,
            ];
            $insMappedLocation = $this->db->insert('mapping_of_industrial_corridor', $mappedLocation);
            if ($insMappedLocation != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRMIC0001: Insertion failed in mapping_of_industrial_corridor for Case No and query is ' . $this->db->last_query());
                $errors = "#MRMIC0001: There is some problem ! Kindly contact system administrator!";
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/MapIndustrialCorridorController/getMapIndustrialCorridorView');
            }

            foreach ($SelectedDags as $dag)
            {
                $split    = explode("@",$dag);
                $dagNo    = $split[0];
                $dagNoInt = $split[1];

                $mappedDags = [
                    'mapped_id'  => $mappedId,
                    'dag_no'     => $dagNo,
                    'dag_no_int' => $dagNoInt,
                    'status'     => 1,
                    'created_at' => $todayT,
                    'updated_at' => $todayT,
                    'ip'         => $ipAdd,
                ];

                $insMappedDags = $this->db->insert('mapping_of_industrial_corridor_dags', $mappedDags);
                if ($insMappedDags != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRMIC0002: Insertion failed in mapping_of_industrial_corridor_dags for Case No and query is ' . $this->db->last_query());
                    $errors = "#MRMIC0002: There is some problem ! Kindly contact system administrator!";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/MapIndustrialCorridorController/getMapIndustrialCorridorView');
                }
            }
        }
        else
        {
            $mappedLocationDetails = $this->MapIndustrialCorridorModel->getMappedLocation($d,$s,$c,$mouza_pargona_code,$lot_no,$vill_townprt_code);
            $mappedId = $mappedLocationDetails->id;

            foreach ($SelectedDags as $dag)
            {
                $split    = explode("@",$dag);
                $dagNo    = $split[0];
                $dagNoInt = $split[1];

                // check dags already exist or not
                $mappedDagsCount = $this->MapIndustrialCorridorModel->checkMappedDags($mappedId,$dagNo,$dagNoInt);
                if($mappedDagsCount == 0)
                {
                    $mappedDags = [
                        'mapped_id'  => $mappedId,
                        'dag_no'     => $dagNo,
                        'dag_no_int' => $dagNoInt,
                        'status'     => 1,
                        'created_at' => $todayT,
                        'updated_at' => $todayT,
                        'ip'         => $ipAdd,
                    ];

                    $insMappedDags = $this->db->insert('mapping_of_industrial_corridor_dags', $mappedDags);
                    if ($insMappedDags != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRMIC0002: Insertion failed in mapping_of_industrial_corridor_dags for Case No and query is ' . $this->db->last_query());
                        $errors = "#MRMIC0002: There is some problem ! Kindly contact system administrator!";
                        $this->session->set_flashdata('error', $errors);
                        redirect(base_url() .'index.php/MapIndustrialCorridorController/getMapIndustrialCorridorView');
                    }
                }
            }
        }

        $this->db->trans_commit();
        $errors = "Dags Successfully Mapped with Industrial Corridor";
        $this->session->set_flashdata('success', $errors);
        redirect(base_url() .'index.php/MapIndustrialCorridorController/firstLandingPageMappingInCorridor');

    }


    // view mapped location list
    public function getMappedLocationList()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $user_code   = trim($this->session->userdata('user_code'));

        if($userDegCode != MB_CIRCLE_OFFICER)
        {
            $errors = "You are not Authorized !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }

        $mappingDagsList = $this->MapIndustrialCorridorModel->getMappedLocationByCo($dist_code,$subdiv_code,$cir_code,$user_code);
        $data['mappingDagsList'] = $mappingDagsList;

        $data['_view'] = 'MapIndustrial/mapped_location_list_view';
        $this->load->view('layouts/main', $data);
    }



    // get mapped location details
    public function getMappedLocationWithDags()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $mappedId    = trim($this->input->get('mId'));

        if($userDegCode != MB_CIRCLE_OFFICER)
        {
            $errors = "You are not Authorized !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }

        // check data exist or not
        if($this->MapIndustrialCorridorModel->countMappedLocationDetailsById($mappedId,$dist_code,$subdiv_code,$cir_code,$user_code) != 1)
        {
            $errors = "Data not found !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationList');
        }

        $mappedLocDetails = $this->MapIndustrialCorridorModel->getMappedLocationDetailsById($mappedId,$dist_code,$subdiv_code,$cir_code,$user_code);
        $mappedDagList    = $this->MapIndustrialCorridorModel->getMappedDagsListByLocationId($mappedId);

        $mouza = trim($mappedLocDetails->mouza_pargona_code);
        $lot   = trim($mappedLocDetails->lot_no);
        $vill  = trim($mappedLocDetails->vill_townprt_code);

        $dagList = $this->UtilsModel->getDagList($dist_code,$subdiv_code,$cir_code,$mouza,$lot,$vill);

        $mappedDagArray = [];
        foreach ($mappedDagList as $dd)
        {
            $mappedDagArray[] = $dd->dag_no;
        }

        $data['mappedLocDetails'] = $mappedLocDetails;
        $data['mappedDagArray']   = $mappedDagArray;
        $data['mappedDagList']    = $mappedDagList;
        $data['dagList']          = $dagList;

//        dd($data);

        $data['_view'] = 'MapIndustrial/mapped_location_with_dag_details';
        $this->load->view('layouts/main', $data);
    }



    // update mapped dag
    public function updateMappingDags()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mappedLocId', 'Mapping of Industrial Corridor Id', 'trim|required|is_natural|greater_than[-1]|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationList');
        }
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if($userDegCode != MB_CIRCLE_OFFICER)
        {
            $errors = "You are not Authorized !";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }

        $mappedLocId  = trim($this->input->post('mappedLocId'));
        $selectedDags = $this->input->post('selectedDags');
        $user_code    = trim($this->session->userdata('user_code'));

        if (empty($selectedDags))
        {
            $errors = "MRMICU0001 : There is no dags selected ! Please Select dags";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationWithDags?mId='.$mappedLocId);
        }
        if($this->MapIndustrialCorridorModel->countMappedLocationDetailsByIdOnly($mappedLocId) != 1)
        {
            $errors = 'MRMICU0002: Data not found !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationList');
        }

        $mappedLocDetails = $this->MapIndustrialCorridorModel->getMappedLocationDetailsByIdOnly($mappedLocId);
        if($mappedLocDetails->u_code != $user_code)
        {
            $errors = 'MRMICU0002: You are not Authorized for this process !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationList');
        }

        $mappedDagList = $this->MapIndustrialCorridorModel->getMappedDagsListByLocationId($mappedLocId);

        $this->db->trans_begin();
        $todayT = date('Y-m-d h:i:s');
        $ipAdd  = $this->offlineutility->get_client_ip();

        $deletedDagArray   = [];
        $InsertedDagArray  = [];
        $mappedDagInArray  = [];
        $updatedDagInArray = [];
        foreach ($mappedDagList as $dd)
        {
            $mappedDagInArray[] = $dd->dag_no;
        }
        foreach ($selectedDags as $dag)
        {
            $split    = explode("@", $dag);
            $dagNo    = $split[0];
            $dagNoInt = $split[1];
            $updatedDagInArray[]  = $dagNo;
            $updatedDagIntArray[] = $dagNoInt;
        }

        // Insert all new dags
        foreach ($updatedDagInArray as $dgg)
        {
            if(!in_array($dgg,$mappedDagInArray))
            {
                $InsertedDagArray[] = $dgg;
            }
        }
        foreach ($selectedDags as $dag)
        {
            $split    = explode("@", $dag);
            $dagNo    = $split[0];
            $dagNoInt = $split[1];

            if(in_array($dagNo,$InsertedDagArray))
            {
                $mappedDags = [
                    'mapped_id'  => $mappedLocId,
                    'dag_no'     => $dagNo,
                    'dag_no_int' => $dagNoInt,
                    'status'     => 1,
                    'created_at' => $todayT,
                    'updated_at' => $todayT,
                    'ip'         => $ipAdd,
                ];

                // save new dags
                $insMappedDags = $this->db->insert('mapping_of_industrial_corridor_dags', $mappedDags);
                if ($insMappedDags != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRMICU0003: Insertion failed in mapping_of_industrial_corridor_dags for Case No and query is ' . $this->db->last_query());
                    $errors = "#MRMICU0003: There is some problem ! Kindly contact system administrator!";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationWithDags?mId='.$mappedLocId);
                }
            }
        }

        // delete all old dag and insert deleted table
        foreach ($mappedDagInArray as $dggD)
        {
            if(!in_array($dggD,$updatedDagInArray))
            {
                $deletedDagArray[] = $dggD;
            }
        }
        foreach ($mappedDagList as $dggDel)
        {
            if(in_array($dggDel->dag_no,$deletedDagArray))
            {
                $deletedDags = [
                    'mapped_id'  => $dggDel->mapped_id,
                    'dag_no'     => $dggDel->dag_no,
                    'dag_no_int' => $dggDel->dag_no_int,
                    'status'     => $dggDel->status,
                    'created_at' => $dggDel->created_at,
                    'updated_at' => $dggDel->updated_at,
                    'ip'         => $dggDel->ip,
                    'deleted_id' => $dggDel->id,
                    'deleted_at' => $todayT,
                    'deleted_by' => $user_code,
                    'deleted_ip' => $ipAdd,
                ];

                // save deleted dags
                $delMappedDags = $this->db->insert('mapping_of_industrial_corridor_dags_deleted', $deletedDags);
                if ($delMappedDags != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRMICU0004: Insertion failed in mapping_of_industrial_corridor_dags_deleted for Case No and query is ' . $this->db->last_query());
                    $errors = "#MRMICU0004: There is some problem ! Kindly contact system administrator!";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationWithDags?mId='.$mappedLocId);
                }

                // delete the dags
                $deletedRow = $this->db->delete('mapping_of_industrial_corridor_dags', array('id' => $dggDel->id));
                if ($deletedRow != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRMICU0005: Insertion failed in mapping_of_industrial_corridor_dags_deleted for Case No and query is ' . $this->db->last_query());
                    $errors = "#MRMICU0005: There is some problem ! Kindly contact system administrator!";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationWithDags?mId='.$mappedLocId);
                }
            }
        }

        $this->db->trans_commit();
        $errors = "Dags Mapped with Industrial Corridor Successfully Updated ";
        $this->session->set_flashdata('success', $errors);
        redirect(base_url() .'index.php/MapIndustrialCorridorController/getMappedLocationWithDags?mId='.$mappedLocId);

    }



}