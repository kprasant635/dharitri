<?php

class ZoneInformationController extends CI_Controller
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

        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('ZonalInformation/zonalinformationmodel');
        $this->load->model('mutation/mutationmodel');
        //var_dump($this->session->all_userdata());
    }



    // Search/Update Zonal Information by LM
    public function zonalinformationDetails_dc_lao()
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
        $data = $this->zonalinformationmodel->getVillageForZonalUpdationJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $village['villages'] = $data;

        $village['_view'] = 'ZonalAutoUpdate/SelectVillageForZonalUpdation';
        $this->load->view('layouts/main', $village);
    }
    // Update Zonal Information End

    // Get Dag No from the Chitha_basic table for zonalal Information Update at LM end
    public function getDagdetails()
    {

        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_pargona_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no');
        $data['select'] = $select_village = $this->input->post('vill_code');

        // Get Dag no with Pending Dag Details
        $data['getdagdetails'] = $this->zonalinformationmodel->getPendingDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village);

        // Get Updated Dag no by LM and Send for CO verification (Flag 1)
        // $data['updateddagdetails'] = $this->zonalinformationmodel->getUpdatedDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village);

        // Get Dag no Reverted by CO   (Flag 2)
        // $data['reverteddagdetails'] = $this->zonalinformationmodel->getRevertedDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village);

        $data['getSubclass'] = $this->zonalinformationmodel->getSubclass();

        $data['getZone'] = $this->zonalinformationmodel->getZone();

        $data['getvillageList'] = $this->zonalinformationmodel->getVillagebyLot($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['_view'] = 'ZonalAutoUpdate/ZonalDagDetailsLM';

        $this->load->view('layouts/main', $data);
    }

    // Pending Zonal Information Details at  CO End
    public function zonalinformationDetails_dc_co()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        if ($subdiv_code == '00' || $cir_code == '00' || $mouza_pargona_code != '00' || $lot_no != '00') {

            echo "<p>User Not Authorized</p>";
        } else {
            $data['user_code'] = $user_code = $this->session->userdata('user_code');

            $data['pendingcount'] = $this->db->query("select count(*) as c from  dagwise_zone_info where flag = '0' and dist_code ='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row()->c;

            $sql = "SELECT * FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND user_code='$user_code' AND is_active in ('E','R','A')";


            $data['document'] = $this->db->query($sql)->row();
            $data['document_count'] = $this->db->query($sql)->num_rows();

            $data['_view'] = 'ZonalAutoUpdate/zonalinformation_co';
            $this->load->view('layouts/main', $data);
        }
    }




    //Approve single Zonal Information against a Dag no by CO
    public function approveZoneDetails()
    {
        $dag_no = $this->uri->segment(3);
        $vill_code = $this->uri->segment(4);

        $result = $this->zonalinformationmodel->zonalstatus([
            'flag' => 1,
        ], $dag_no, $vill_code);

        if ($result) {
            $this->session->set_flashdata('Zonal Details Approved Successfully');
        }

        $this->session->set_flashdata('message', 'Zonal Details For Dag No' . $dag_no . ' Successfully Approved.');
        redirect(base_url() . "index.php/ZoneInformationController/getPendingZonalInformation");
    }

    // Approve Zonal Information against selected Dag no By CO
    //Newly Added
    public function approveZonalInformationCO()
    {
        $this->form_validation->set_rules('dag_no', 'Dag No', 'required');
        $dag_no = $this->input->post('dag_no');
        $village_uuid = $this->input->post('village_uuid');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', 'Zonal Information   Approval  Failed.<br>Please Select  Dag number to Approve');
            redirect(base_url() . "index.php/LandShareUpdation/getPendingLandShareDetails");
        } else {
            for ($i = 0, $k = 0; $i < count($dag_no), $k < count($village_uuid); $i++, $k++) {
                $result = $this->db->where(
                    ['dag_no' => $dag_no[$i]],
                    ['village_uuid' => $village_uuid[$i]]
                )
                    ->update('dagwise_zone_info', [
                        'flag' => '1',
                        'modified_at' => date('Y-m-d H:i:s')
                    ]);
            }
            if ($result) {
                $this->session->set_flashdata('message', 'Zonal Information  Successfully Approved.');
                redirect(base_url() . "index.php/ZoneInformationController/getPendingZonalInformation");
            }
        }
    }

    // Revert Zonal details by CO requested by LM
    public function revert_zonaldetails($dag_no, $village_uuid)
    {
        $oldData = $this->db->query("SELECT * FROM dagwise_zone_info WHERE dag_no=? AND 
            unique_village_code=?", array($dag_no, $village_uuid))->row();
        $data = [
            'ip' => $this->utilityclass->get_client_ip(),
            'module_name' => 'Dagwise Zonal',
            'user_code' => $this->session->userdata('user_code'),
            'unique_village_id' => $village_uuid,
            'when_updated' => 'Reverted',
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($oldData),
        ];
        $basuInsert = $this->db->insert('zonal_data_backup', $data);
        if ($basuInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT004: Insertion failed in zonal_data_backup for dag no ' . $dag_no);
            return false;
        }

        $this->zonalinformationmodel->statusCo([
            'flag' => 2,
        ], $dag_no, $village_uuid);
        echo json_encode(array(
            "statusCode" => 200
        ));
    }

    //Reject Zonal details by CO requested by LM
    public function reject_zonaldetails($dag_no, $village_uuid)
    {

        $oldData = $this->db->query("SELECT * FROM dagwise_zone_info WHERE dag_no=? AND 
            unique_village_code=?", array($dag_no, $village_uuid))->row();
        $data = [
            'ip' => $this->utilityclass->get_client_ip(),
            'module_name' => 'Dagwise Zonal',
            'user_code' => $this->session->userdata('user_code'),
            'unique_village_id' => $village_uuid,
            'when_updated' => 'Rejected',
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($oldData),
        ];
        $basuInsert = $this->db->insert('zonal_data_backup', $data);
        if ($basuInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT004: Insertion failed in zonal_data_backup for dag no ' . $dag_no);
            return false;
        }

        $this->zonalinformationmodel->rejectCo($dag_no, $village_uuid);
        echo json_encode(array(
            "statusCode" => 200
        ));
    }


    // Update Zonal Information of  Selected Dag Number By LM
    public function updateZonalInformationLM()
    {
        // Newly Added
        $this->form_validation->set_rules('dist_code', 'District', 'required|greater_than[0]|trim|xss_clean');
        $this->form_validation->set_rules('subdiv_code', 'Subdiv Code', 'required|greater_than[0]|trim||xss_clean');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'required|trim|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('mouza_pargona_code', 'mouza Code', 'required|trim|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'required|trim|greater_than[0]|xss_clean');

        $this->form_validation->set_rules('dag_no', 'Dag No', 'required|xss_clean');
        $this->form_validation->set_rules('zone_name', 'Zone Name', 'required|xss_clean');
        $this->form_validation->set_rules('lclass_name', 'Land Class Type', 'required|xss_clean');


        // Get Post Data
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $dag_no = $this->input->post('dag_no');
        $zone_name = $this->input->post('zone_name');
        $lclass_name = $this->input->post('lclass_name');
        $vill_code = $this->input->post('village_selected');
        $unique_vill_code = $this->input->post('unique_vill_code');

        // Get Session Data
        $dist_code_session = $this->session->userdata('dist_code');
        $subdiv_code_session  = $this->session->userdata('subdiv_code');
        $cir_code_session = $this->session->userdata('cir_code');
        $mouza_pargona_code_session  = $this->session->userdata('mouza_pargona_code');
        $lot_no_session  = $this->session->userdata('lot_no');

        // Get UUID from Form Post
        $post_uuid =  $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        // Get UUID from Session
        $session_uuid =  $this->utilityclass->getVillageUUID($dist_code_session, $subdiv_code_session, $cir_code_session, $mouza_pargona_code_session, $lot_no_session, $vill_code);

        if ($dist_code == '0' || $dist_code == null || empty($dist_code)) {
            $this->session->set_flashdata('message', 'Your session might be Destroyed. Please Login Again');
            redirect(base_url() . "index.php/home");
        }
        if ($post_uuid == null || $session_uuid == null || $post_uuid != $session_uuid) {
            // throw error and return;
            $this->session->set_flashdata('message', 'Failed...!Session Data Mismatch. Please Login Again');
            redirect(base_url() . "index.php/home");
        }
        if ($post_uuid != $unique_vill_code || $session_uuid != $unique_vill_code) {
            // throw error and return;
            $this->session->set_flashdata(
                'message',
                'Failed...!Session Data Mismatch.Please Login Again'
            );
            redirect(base_url() . "index.php/home");
        }
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', 'Zonal Information Update Failed.!</br>Please Select Dag number  and respective Zonal Details to update');
            redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_dc_lao");
        } else {
            $this->db->trans_begin();
            foreach ($dag_no as $key => $value) {
                if (empty($zone_name[$key]) || $zone_name[$key] == '0000') {
                    continue;
                }
                if (empty($lclass_name[$key]) || $lclass_name[$key] == '0000') {
                    continue;
                }
                $insertion_data_for_zonal_value[] = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_code' => $vill_code,
                    'unique_village_code' => $unique_vill_code,
                    'dag_no' =>  $dag_no[$key],
                    'zone_id' =>  $zone_name[$key],
                    'subclass_id' =>  $lclass_name[$key],
                    'created_at' => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s'),
                    'flag' => 0,
                ];
            }
            $result = $this->db->insert_batch('dagwise_zone_info', $insertion_data_for_zonal_value);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message("error", "#LB001, Error in insert, table 'dagwise_zone_info' with data :" . json_encode($insertion_data_for_zonal_value));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB003'];
            } else {
                $this->db->trans_commit();
            }
            if ($result) {
                $this->session->set_flashdata('message', 'Zonal Information sent for CO Verification Successfully');
                redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_dc_lao");
            } else {
                $this->session->set_flashdata('messgae', 'Zonal Information Updation Failed');
                redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_dc_lao");
            }
        }
    }

    //  ReUpdate  Zonal Information against selected Dag no By  LM after Revert Back by CO
    public function ZonalReUpdate($dag_no, $village_uuid)
    {

        $this->form_validation->set_rules('lclass_name_reverted', 'Land Class', 'required');
        $this->form_validation->set_rules('zone_name_reverted', 'Zone Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Zonal Information Re update  Failed.');
            echo json_encode(array(
                "statusCode" => 500
            ));
        } else {
            $this->zonalinformationmodel->reUpdateLM(
                [
                    'flag' => 0,
                    'subclass_id' => $this->input->post('lclass_name_reverted'),
                    'zone_id' => $this->input->post('zone_name_reverted'),
                    'modified_at' => date('Y-m-d H:i:s')
                ],
                $dag_no,
                $village_uuid
            );
            echo json_encode(array(
                "statusCode" => 200
            ));
        }
    }

    // getting all the existing details to be shown in edit modal 
    public function getZonalValueDetailsForEdit()
    {
        //to-do
        //validation 
        $zonalValueDetailsSearchArr = [
            'dist_code' => $this->session->userdata('dist_code'),
            'subdiv_code' => $this->session->userdata('subdiv_code'),
            'cir_code' =>  $this->session->userdata('cir_code'),
            'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
            'lot_no' => $this->session->userdata('lot_no'),
            'vill_code' => trim($_POST['vill_code_reverted']),
            'dag_no' => trim($_POST['dag_no_reverted']),
        ];
        $zonalValueDetailsAll = $this->zonalinformationmodel->getAllZonalDetailsDagWise($zonalValueDetailsSearchArr);
        echo json_encode($zonalValueDetailsAll);
    }
    ////////////30-06-22//////////////////
    public function zonalinformationDetails_villagewise()
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
        $getVillage = $this->zonalinformationmodel->getVillageForZonalUpdationJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $getZone = $this->zonalinformationmodel->getZone();
        $data['villages'] = $getVillage;
        $data['zones'] = $getZone;
        $data['_view'] = 'ZonalUpdateVillagewise/SelectVillageWiseZonalUpdate';
        $this->load->view('layouts/main', $data);
    }

    public function getVillageZoneDetails()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_pargona_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no');
        $data['select'] = $select_village = $this->input->post('vill_code');
        $data['village_type'] = $village_type = $this->utilityclass->getVillageType($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village);

        $data['getSubclass'] = $this->zonalinformationmodel->getSubclassVillageWise($village_type);

        $data['getpendingZone'] = $this->zonalinformationmodel->getPendingZone($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village, $village_type);
        $data['getRevertedZone'] = $this->zonalinformationmodel->getRevertedZone($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village);

        $data['zone_id'] = $zone_id = $this->input->post('zone_id');
        $data['_view'] = 'ZonalUpdateVillagewise/village_wise_zone_details';
        $this->load->view('layouts/main', $data);
    }

    // Add Villgaewise Zonal Details
    public function addVillageWiseZonalDetails()
    {
        // Newly Added
        $this->form_validation->set_rules('dist_code', 'District', 'required|greater_than[0]|trim|xss_clean');
        $this->form_validation->set_rules('subdiv_code', 'Subdiv Code', 'required|greater_than[0]|trim||xss_clean');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'required|trim|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('mouza_pargona_code', 'mouza Code', 'required|trim|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'required|trim|greater_than[0]|xss_clean');


        // Get Post Data
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $zone_code = $this->input->post('zone_code');
        $subclass_code = $this->input->post('subclass_code');
        $zone_name = $this->input->post('zone_name');
        $subclass_name = $this->input->post('subclass_name');
        $land_rate = $this->input->post('land_rate');
        $vill_code = $this->input->post('village_selected');
        $unique_vill_code = $this->input->post('unique_vill_code');


        // Get Session Data
        $dist_code_session = $this->session->userdata('dist_code');
        $subdiv_code_session  = $this->session->userdata('subdiv_code');
        $cir_code_session = $this->session->userdata('cir_code');
        $mouza_pargona_code_session  = $this->session->userdata('mouza_pargona_code');
        $lot_no_session  = $this->session->userdata('lot_no');

        // Get UUID from Form Post
        $post_uuid =  $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        // Get UUID from Session
        $session_uuid =  $this->utilityclass->getVillageUUID($dist_code_session, $subdiv_code_session, $cir_code_session, $mouza_pargona_code_session, $lot_no_session, $vill_code);

        if (
            $dist_code == '0' || $dist_code == null || empty($dist_code)
        ) {
            $this->session->set_flashdata('message', 'Your session might be Destroyed. Please Login Again');
            redirect(base_url() . "index.php/home");
        }
        if ($post_uuid == null || $session_uuid == null || $post_uuid != $session_uuid) {
            // throw error and return;
            $this->session->set_flashdata('message', 'Failed...!Session Data Mismatch. Please Login Again');
            redirect(base_url() . "index.php/home");
        }
        if ($post_uuid != $unique_vill_code || $session_uuid != $unique_vill_code) {
            // throw error and return;
            $this->session->set_flashdata(
                'message',
                'Failed...!Session Data Mismatch.Please Login Again'
            );
            redirect(base_url() . "index.php/home");
        }

        $this->db->trans_begin();
        for ($i = 0; $i < count($subclass_code); $i++) {
            // if (!isset($land_rate[$i]) || $land_rate[$i] == null) {
            // }
            $insertion_data_for_zonal_value[] = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'zone_code' =>  $zone_code,
                'zone_name' =>  $zone_name,
                'vill_code' =>  $vill_code,
                'unique_village_code' => $unique_vill_code,
                'land_rate' => $land_rate[$i],
                'subclass_code' =>  $subclass_code[$i],
                'subclass_name' =>  $subclass_name[$i],
                'created_at' => date('Y-m-d H:i:s'),
                'modified_at' => date('Y-m-d H:i:s'),
                'flag' => 0,
            ];
        }
        $result = $this->db->insert_batch('villagewise_zone_info', $insertion_data_for_zonal_value);

        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            log_message("error", "#LB001, Error in insert, table 'villagewise_zone_info' with data :" . json_encode($insertion_data_for_zonal_value));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB003'];
        } else {
            $this->db->trans_commit();
        }
        if ($result) {
            $this->session->set_flashdata('message', 'Zonal Information sent for CO Verification Successfully');
            redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_villagewise");
        } else {
            $this->session->set_flashdata('messgae', 'Zonal Information Updation Failed');
            redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_villagewise");
        }
    }

    // Pending VillgaeWise Zonal Information Details at  CO End
    public function zonalinformationDetails_villagewise_dc_co()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');

        $data['pendingcount'] = $this->db->query("select distinct  count('vill_code') as c from  villagewise_zone_info where flag='0'  and dist_code ='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row()->c;

        $data['_view'] = 'ZonalUpdateVillagewise/zonalinformation_villagewise_co';

        $this->load->view('layouts/main', $data);
    }

    public function getVillagewisePendingZonalInformation()
    {

        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_pargona_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no');
        $data['select'] = $select_village = $this->input->post('vill_code');

        $pendingFlag = '0';
        $revertedFlag = '2';
        $approvedFlag = '1';
        $sentToADCFlag = '3';
        $revertedByADCFlag = '4';

        $data['getpendingdetails'] = $this->zonalinformationmodel->get_VillageWiseZonalDetailsCo($pendingFlag);
        $data['getreverteddetails'] = $this->zonalinformationmodel->get_VillageWiseZonalDetailsCo($revertedFlag);
        $data['getapproveddetails'] = $this->zonalinformationmodel->get_VillageWiseZonalDetailsCo($approvedFlag);

        $data['revertedByAdc'] = $this->zonalinformationmodel->get_VillageWiseZonalDetailsCo($revertedByADCFlag);
        $data['getZoneWisedetails'] = $this->zonalinformationmodel->get_ZoneWisedetails();

        $data['_view'] = 'ZonalUpdateVillagewise/villagewise_pendingZonalInformation';
        $this->load->view('layouts/main', $data);
    }

    // Approve VillageWise Zonal details by CO requested by LM

    public function approve_Villagewise_zonaldetails($vill_code)
    {
        $where = [
            'flag' => '0',
            'unique_village_code' => $vill_code,
        ];

        $approveCo = $this->zonalinformationmodel->villageWiseStatusCo([
            'flag' => '1',
            'modified_at' => date('Y-m-d H:i:s')
        ], $where);

        if ($approveCo == true) {
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Details  Successfully Approved by CO',
            ));
        } else {
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Zonal Details  Approval Failed',
            ));
            echo $this->db->last_query();
        }
    }


    //Reject Zonal details by CO Villagewise requested by LM
    public function reject_Villagewise_zonaldetails($vill_code)
    {
        $oldData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
            unique_village_code=?", array($vill_code))->result_array();
        $data = [
            'ip' => $this->utilityclass->get_client_ip(),
            'module_name' => 'Villagewise Zonal',
            'user_code' => $this->session->userdata('user_code'),
            'unique_village_id' => $vill_code,
            'when_updated' => 'Rejected',
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($oldData),
        ];
        $this->db->trans_begin();
        $basuInsert = $this->db->insert('zonal_data_backup', $data);
        if ($basuInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT004: Insertion failed in zonal_data_backup ');
            return false;
        }

        $where = [
            'flag' => '0',
            'unique_village_code' => $vill_code,
        ];

        $rejectCo = $this->zonalinformationmodel->villageWiseRejectCo($where);

        if ($rejectCo == true) {
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Details  Successfully Rejected',
            ));
        } else {
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Zonal Details  Rejection Failed',
            ));
            echo $this->db->last_query();
        }
    }

    // getting the data for view modal 
    public function getZoneDetails()
    {
        $zoneDetailsSearchArr =  trim($_POST['zd_view_form_vill_code']);
        $zoneDetailsAll = $this->zonalinformationmodel->getAllzoneDetailsVillageWise($zoneDetailsSearchArr);
        echo json_encode($zoneDetailsAll);
    }


    // Reupdate Villgaewise Zonal Details by LM
    public function reupdateVillageWiseZonalDetails()
    {
        $zonal_values = $_POST['update_land_rate'];
        foreach ($zonal_values as $zonal_value) {
            if ($zonal_value != "") {

                $patern = "/^[0-9.]+$/";
                if (!preg_match($patern, $zonal_value)) {
                    echo json_encode(["error" => "error", "msg" => "please enter only numeric values! Error in value : " . $zonal_value]);
                    exit;
                }
            }
        }

        $unique_village_code = $this->input->post('unique_village_code');
        $vill_code  = $_POST['vill_code'];
        $zone_code =  $_POST['zone_details_update_form_zone_code'];
        $subclass_code = $this->input->post('update_subclass_code');
        $land_rate = $this->input->post('update_land_rate');
        $subclass_code = $this->input->post('update_subclass_code');

        $this->db->trans_begin();
        $updation_data_for_zonal_value = array();
        for ($i = 0; $i < count($subclass_code); $i++) {
            $this->db->where('subclass_code', $subclass_code[$i]);
            $this->db->where('zone_code', $zone_code);
            $this->db->where('unique_village_code', $unique_village_code);
            $result = $this->db->update('villagewise_zone_info', array(
                'land_rate' => $land_rate[$i],
                'flag' => 0,
            ));
        }
        if ($result != 1 || $result != true) {
            $this->db->trans_rollback();
            log_message("error", "#LB001, Error in insert, table 'villagewise_zone_info' with data :" . json_encode($updation_data_for_zonal_value));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LB003'];
        } else {
            $this->db->trans_commit();
            echo json_encode(array(
                "statusCode" => 200
            ));
        }
    }

    // Approve Zonal Information against selected Dag no By CO
    public function reupdateZonalLM()
    {
        $this->form_validation->set_rules('subclass_code', 'subclass_code', 'required');
        $subclass_code = $this->input->post('subclass_code');
        $land_rate = $this->input->post('land_rate');
        $zone_code = $this->input->post('zone_code_reverted');
        $vill_code = $this->input->post('village_selected');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', 'Zonal Information Approval  Failed.<br>Please Select Altest One Dag number to Approve');
            redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_villagewise");
        } else {
            for ($i = 0; $i < count($subclass_code); $i++) {
                $result = $this->db->where([
                    'zone_code' => $zone_code,
                    'vill_code' => $vill_code,
                    'flag' => '2'
                ])
                    ->update('villagewise_zone_info', [
                        'land_rate' => $land_rate[$i], 'flag' => '0'
                    ]);
            }
            if ($result) {
                $this->session->set_flashdata('message', 'Zonal Details  Successfully Approved.');
                redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetails_villagewise");
            }
        }
    }

    // Revert ZonalDetails By CO Villagewise
    public function VillageWiseRevert($vill_code)
    {
        $this->form_validation->set_rules('revert_remarks', 'Revert Remarks', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Zonal Information Revert Failed.');
            echo json_encode(array(
                "statusCode" => 500
            ));
        } else {
            $oldData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
            unique_village_code=?", array($vill_code))->result_array();
            $data = [
                'ip' => $this->utilityclass->get_client_ip(),
                'module_name' => 'Villagewise Zonal',
                'user_code' => $this->session->userdata('user_code'),
                'unique_village_id' => $vill_code,
                'when_updated' => 'Reverted',
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($oldData),
            ];
            $this->db->trans_begin();
            $basuInsert = $this->db->insert('zonal_data_backup', $data);
            if ($basuInsert != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRALOT004: Insertion failed in zonal_data_backup for dag no ' . $vill_code);
                return false;
            }

            $where = [
                'flag' => '0',
                'unique_village_code' => $vill_code,
            ];

            $revertCo = $this->zonalinformationmodel->villageWiseStatusCo(
                [
                    'flag' => 2,
                    'revert_remarks' => $this->input->post('revert_remarks'),
                    'modified_at' => date('Y-m-d H:i:s')
                ],
                $where
            );
            if ($revertCo == true) {
                $this->db->trans_commit();
                echo json_encode(array(
                    'responseType' => 2,
                    'message' => 'Zonal Details  Successfully Reverted to LM',
                ));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => 'Zonal Details  Revert Failed',
                ));
                echo $this->db->last_query();
            }
        }
    }

    public function getZoneDetailsForEdit()
    {

        $zoneDetailsSearchArr = [
            'dist_code' => trim($_POST['dist_code']),
            'subdiv_code' => trim($_POST['subdiv_code']),
            'cir_code' => trim($_POST['circle_code']),
            'mouza_pargona_code' => trim($_POST['mouza_code']),
            'lot_no' => trim($_POST['lot_no']),
            'vill_code' => trim($_POST['vill_code']),
            'zone_code' => trim($_POST['zone_details_update_form_zone_code']),
        ];
        $zonalValueDetailsAll = $this->zonalinformationmodel->getAllZonalDetailsZoneWise($zoneDetailsSearchArr);
        echo json_encode($zonalValueDetailsAll);
    }


    // New Method by Mriganka Da For CO
    public function getPendingZonalInformation()
    {

        // Newly Added
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $pendingFlag = '0';
        $approvedFlag = '1';
        $revertedFlag = '2';

        $villageListPending =  $this->zonalinformationmodel->getVillageUUIDList($dist_code, $subdiv_code, $cir_code, $pendingFlag);
        $villageListApproved =  $this->zonalinformationmodel->getVillageUUIDList($dist_code, $subdiv_code, $cir_code, $approvedFlag);
        $villageListReverted =  $this->zonalinformationmodel->getVillageUUIDList($dist_code, $subdiv_code, $cir_code, $revertedFlag);

        $data['villageListPending'] = $villageListPending;
        $data['villageListApproved'] = $villageListApproved;
        $data['villageListReverted'] = $villageListReverted;

        $data['select_range'] = $select_offset = $this->input->post('select_range');

        $data['getSubclass'] = $this->zonalinformationmodel->getSubclass();
        $data['getZone'] = $this->zonalinformationmodel->getZone();
        // $villagedata 
        $data['getpendingdetails'] = $this->zonalinformationmodel->get_PendingZonalDetailsCo($select_offset);

        $data['getvillageList'] = $this->zonalinformationmodel->getVillagebyCircle($dist_code, $subdiv_code, $cir_code);

        $data['_view'] = 'ZonalAutoUpdate/pendingZonalInformation';
        $this->load->view('layouts/main', $data);
    }


    public function viewPendingCasesZonalDagCO()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $subdiv_code = $this->input->post('subdiv_code_pending');
        $cir_code = $this->input->post('cir_code_pending');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        // $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $village_code = $this->input->post('village_code_pending');
        $pendingFlag = '0';
        $results = $this->zonalinformationmodel->viewZonalDagWiseCO($start, $length, $order, $searchByCol_1, $dist_code, $subdiv_code, $cir_code, $village_code, $pendingFlag);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $dag_no = '<input type="checkbox" class="checkBoxD selectMark" id="dag_no_checkbox' . $rows->dag_no . '" name="selectMark[]" value="' . $rows->dag_no . '@' . $rows->unique_village_code . '">';

                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $revert = '<button type="button" onclick="revertToLm(' . $rows->dag_no . ', ' . $rows->unique_village_code . ')" class="btn btn-sm btn-primary revert-to-lm"><i class="fa fa-clock-rotate-left"></i> Revert Back to LM</button>';
                $reject = '<button type="button" onclick="rejectZonal(' . $rows->dag_no . ', ' . $rows->unique_village_code . ')" value="' . $rows->dag_no . '" class="btn btn-sm btn-danger confirm-reject">Reject</button>';

                $json[] = array(
                    $dag_no,
                    $rows->dag_no,
                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code),
                    $this->utilityclass->getLandClassCode($landClass),
                    $this->utilityclass->getZoneName($rows->zone_id),
                    $this->utilityclass->getSubclassName($rows->subclass_id),
                    $revert . $reject,
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    // Bulk Approve by CO
    public function bulkApproveByCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('dag_no_selected[]', 'Dag Number', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'responseType' => 3,
            ));
        } else {

            $dag_no_selected = $this->input->post('dag_no_selected');

            if (!empty($dag_no_selected)) {
                foreach ($dag_no_selected as $row) {

                    $dag_no = strtok($row, '@');
                    $vill_uuid = strtok('');
                    $updateData = array(
                        'flag' => '1',
                        'modified_at' => date('Y-m-d H:i:s')
                    );

                    $bulkApproveStatus = $this->zonalinformationmodel->updateDagwiiseZoneInfoByCO($dag_no, $vill_uuid, $updateData);
                }
                if ($bulkApproveStatus <= 0) {

                    log_message('error', '#ERRDUPDATE0001: Updation failed in dagwise_zone_info for bulk Approve');
                    log_message('error', $this->db->last_query());

                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#ERRDUPDATE0001: Updation failed in dagwise_zone_info. Kindly contact System Administrator',

                    ));
                    return false;
                } else {
                    $this->session->set_flashdata('message', 'Zonal Details  Successfully Approved');
                    echo json_encode(array(
                        'responseType' => 2,
                        'message' => 'Zonal Details  Successfully Approved ',

                    ));
                }
            }
        }
    }

    // getting the data for ediit modal 
    public function getZoneDetailsForEditCo()
    {
        $zoneDetailsSearchArr =  trim($_POST['zd_edit_form_vill_code_co']);
        $zoneDetailsAll = $this->zonalinformationmodel->getAllzoneDetailsVillageWise($zoneDetailsSearchArr);
        echo json_encode($zoneDetailsAll);
    }


    // Update Zonal Details by CO
    public function zonalInformationUpdateCO()
    {
        $unique_village_code = $this->input->post('zd_edit_form_vill_code_co');
        $unique_village_name = $this->utilityclass->getVillageNameByUUID($unique_village_code);
        $villagewise_zonal_id = $this->input->post('edit_villagewise_zonal_id');
        $input_zonal_values = $this->input->post('edit_land_rate_co');

        $this->db->trans_begin();

        //Get the old zonal value updated by LM
        $zonal_value_old = $this->db->query("SELECT zone_code,subclass_code,zone_name,subclass_name,land_rate FROM 
                villagewise_zone_info WHERE unique_village_code=? AND  flag !='3' ORDER BY id ASC", array($unique_village_code))->result();

        foreach ($zonal_value_old as $old) {
            $zonal_old[] =
                array(
                    'land_rate' => $old->land_rate,
                    'zone_name' => $old->zone_name,
                    'subclass_name' => $old->subclass_name,
                );
        }

        $dbZonalArr = $zonal_old;
        $dbZonalRate = array_column($zonal_old, "land_rate");
        $dbZoneName = array_column($zonal_old, "zone_name");
        $dbSubclassName = array_column($zonal_old, "subclass_name");

        //Get the input zonal value edited by Co
        foreach ($input_zonal_values as $zonal_value) {
            $input_arr[] =
                array(
                    'land_rate' =>  $zonal_value,
                );
        }

        $inputZonalArr = array_column($input_arr, "land_rate");
        $length = min(count($dbZonalArr), count($inputZonalArr)); // Get the minimum length of the arrays

        for ($i = 0; $i < $length; $i++) {
            //Check for numeric only zonal value
            if ($inputZonalArr[$i] != "") {
                $patern = "/^[0-9.]+$/";
                if (!preg_match($patern, $inputZonalArr[$i])) {
                    echo json_encode([
                        "responseType" => "1",
                        "message" => "Please enter only numeric values !!! Error in Zonal value : {$inputZonalArr[$i]} for {$dbZoneName[$i]} and {$dbSubclassName[$i]} "
                    ]);
                    exit;
                }
            }
            //Check for Lesser input zonal values than origin zonal value and sent to ADC for verify
            if ($inputZonalArr[$i] < $dbZonalRate[$i]) {

                $updateArr = [
                    'temp_land_rate' => $input_zonal_values[$i],
                    'flag' => 3,
                    'modified_at' => date('Y-m-d h:i:s'),
                ];
            } elseif ($inputZonalArr[$i] >= $dbZonalRate[$i]) {
                $updateArr = [
                    'land_rate' => $input_zonal_values[$i],
                    'flag' => 1,
                    'modified_at' => date('Y-m-d h:i:s'),
                ];
            }

            $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
                unique_village_code=?", array($unique_village_code))->result_array();
            $data =
                [
                    'ip' => $this->utilityclass->get_client_ip(),
                    'co_user_code' => $this->session->userdata('user_code'),
                    'unique_village_id' => $unique_village_code,
                    'when_updated' => 'Update by CO',
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($oldVillageZonalData),
                    'module_name' => 'Villagewise',

                ];
            $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_co', $data);
            // Insert in zonal_data_co_backup end

            if ($oldVillageZonalDataInsert != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRZONALCOUPDATE004: Insertion failed in zonal_data_backup_co for dag no ');
                echo json_encode(array(
                    'message' => '#Failed to Backup old Zonal Data.',
                ));
                return false;
            }

            $this->db->where('id', $villagewise_zonal_id[$i]);
            $this->db->where('unique_village_code', $unique_village_code);
            $update_data_co_status = $this->db->update('villagewise_zone_info',  $updateArr);
        }

        if ($update_data_co_status != 1 || $update_data_co_status != true) {
            $this->db->trans_rollback();
            log_message("error", "#ZVUCO, Error in Update, table 'villagewise_zone_info' with data :" . json_encode($updateArr));
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUCO: Updation failed in villagewise_zone_info.',
            ));
        } else {
            $this->db->trans_commit();
            echo json_encode([
                "responseType" => "2",
                "message" => "Zonal Value Information  Successfully Updated for village : "
            ]);
        }
    }




    // Newly Added for CO Dagwise Edit

    public function viewApprovedCasesZonalDagCO()
    {
        $dist_code = $this->input->post('dist_code_approved');
        $subdiv_code = $this->input->post('subdiv_code_approved');
        $cir_code = $this->input->post('cir_code_approved');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        // $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $village_code = $this->input->post('village_code_approved');
        $approvedFlag = '1';
        $results = $this->zonalinformationmodel->viewZonalDagWiseCO($start, $length, $order, $searchByCol_0, $dist_code, $subdiv_code, $cir_code, $village_code, $approvedFlag);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {


                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $mouza_name = str_replace(' ', '-', ($this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code)));

                $lot_name = str_replace(' ', '-', ($this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no)));

                $village_name = $this->utilityclass->getVillageNameByUUID($rows->unique_village_code);

                $chitha_class_name = $this->utilityclass->getLandClassCode($landClass);

                $zone_name = str_replace(' ', '-', ($this->utilityclass->getZoneName($rows->zone_id)));

                $subclass_name = str_replace(' ', '-', ($this->utilityclass->getSubclassName($rows->subclass_id)));

                $village_name_string = str_replace(' ', '-', ($village_name));

                $chitha_class_name_string = str_replace(' ', '-', ($chitha_class_name));

                $onclick_modal = "editDagDetailsCo('" . $rows->dag_no . "','" . $rows->unique_village_code . "','" . $mouza_name . "','" . $lot_name . "','" . $village_name_string . "','" . $zone_name . "','" . $subclass_name . "','" . $chitha_class_name_string . "')";
                $edit = "<button class='btn btn-success btn-sm'  onclick=" . $onclick_modal . ">
                                        <i class='fa fa-edit' aria-hidden='true'></i>
                                        Edit & Reapprove
                                    </button>";


                $json[] = array(
                    $rows->dag_no,
                    $village_name,
                    $chitha_class_name,
                    $zone_name,
                    $subclass_name,
                    $edit,
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }





    //  ReUpdate  Dag Details  by CO
    public function updateDagDetailsByCo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dag_no = $this->input->post('dag_no_co_update');
        $unique_village_code = $this->input->post('vill_code_co_update');
        $zone_id = $this->input->post('zone_name_update_co');
        $subclass_id = $this->input->post('lclass_name_update_co');

        $this->form_validation->set_rules('zone_name_update_co', 'Zone Name', 'required');
        $this->form_validation->set_rules('lclass_name_update_co', 'Land Class', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'responseType' => 3,
                'message' => 'Validation Errors !! Please Select Zone & Land Class',
            ));
        } else {
            $this->db->trans_begin();

            // Insert in Zonal_data_co_backup
            $oldDagZonalData = $this->db->query("SELECT * FROM dagwise_zone_info WHERE dag_no = ? AND
                unique_village_code = ?", array($dag_no, $unique_village_code))->result_array();
            $data = [
                'ip' => $this->utilityclass->get_client_ip(),
                'co_user_code' => $this->session->userdata('user_code'),
                'unique_village_id' => $unique_village_code,
                'when_updated' => 'Update by CO',
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($oldDagZonalData),
                'module_name' => 'Dagwise',

            ];
            $oldDagZonalDataInsert = $this->db->insert('zonal_data_backup_co', $data);
            // Insert in zonal_data_co_backup end


            if ($oldDagZonalDataInsert != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRALOT004: Insertion failed in zonal_data_backup_co for dag no ' . $unique_village_code);
                echo json_encode(array(
                    'message' => '#Failed to Backup old Zonal Data.',
                ));
                return false;
            } else {

                $updateData = array(
                    'zone_id' => $zone_id,
                    'subclass_id' => $subclass_id,
                    'modified_at' => date('Y-m-d H:i:s')
                );

                $where = array(
                    'dag_no' => $dag_no,
                    'unique_village_code' => $unique_village_code,
                );

                $update_data_co_status = $this->zonalinformationmodel->updateDagDetailsByCO($updateData, $where);

                if ($update_data_co_status != 1 || $update_data_co_status != true) {
                    $this->db->trans_rollback();
                    log_message("error", "#ZVUCO_DAGWISE, Error in Update, table 'dagwise_zone_info' with data :" . json_encode($updateData));
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#ZVUCO: Updation failed in dagwise_zone_info.',
                    ));
                } else {
                    $this->db->trans_commit();
                    echo json_encode([
                        "responseType" => "2",
                        "message" => "Zonal Details  Successfully Updated for Dag No  : " . $dag_no . "  with Zone:  " . $this->utilityclass->getZoneName($zone_id) . " and SubClass: " .  $this->utilityclass->getSubclassName($subclass_id)
                    ]);
                }
            }
        }
    }



    public function viewRevertedCasesZonalDagCO()
    {
        $dist_code = $this->input->post('dist_code_reverted');
        $subdiv_code = $this->input->post('subdiv_code_reverted');
        $cir_code = $this->input->post('cir_code_reverted');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        // $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $village_code = $this->input->post('village_code_reverted');
        $revertedFlag = '2';
        $results = $this->zonalinformationmodel->viewZonalDagWiseCO($start, $length, $order, $searchByCol_0, $dist_code, $subdiv_code, $cir_code, $village_code, $revertedFlag);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {


                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $village_name = $this->utilityclass->getVillageNameByUUID($rows->unique_village_code);

                $chitha_class_name = $this->utilityclass->getLandClassCode($landClass);

                $zone_name = str_replace(' ', '-', ($this->utilityclass->getZoneName($rows->zone_id)));

                $subclass_name = str_replace(' ', '-', ($this->utilityclass->getSubclassName($rows->subclass_id)));

                $json[] = array(
                    $rows->dag_no,
                    $village_name,
                    $chitha_class_name,
                    $zone_name,
                    $subclass_name,

                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }




    ///////////////////////Get Dag Details at LM end/////////////////////

    public function viewPendingZonalDagLM()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $subdiv_code = $this->input->post('subdiv_code_pending');
        $cir_code = $this->input->post('cir_code_pending');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code_pending');
        $lot_no = $this->input->post('lot_no_pending');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        // $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $village_code = $this->input->post('village_code_pending');
        $pendingFlag = '0';
        $results = $this->zonalinformationmodel->getPendingZonalDagLM($start, $length, $order, $searchByCol_0, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $pendingFlag);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $dag_no = '<input type="checkbox" class="checkBoxD selectMark" id="dag_no_checkbox' . $rows->dag_no . '" name="selectMark[]" value="' . $rows->dag_no . '@' . $rows->unique_village_code . '">';

                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $json[] = array(
                    $dag_no,
                    $rows->dag_no,
                    $rows->dag_no,
                    $rows->dag_no,
                    $this->utilityclass->getLandClassCode($landClass),
                    $this->utilityclass->getZoneName($rows->zone_id),
                    $this->utilityclass->getSubclassName($rows->subclass_id),

                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }




    public function viewUpdatedZonalDagLM()
    {
        $dist_code = $this->input->post('dist_code_approved');
        $subdiv_code = $this->input->post('subdiv_code_approved');
        $cir_code = $this->input->post('cir_code_approved');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code_approved');
        $lot_no = $this->input->post('lot_no_approved');
        $village_code = $this->input->post('vill_code_selected');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        // $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        $updatedFlag = '2';
        $results = $this->zonalinformationmodel->getUpdatedZonalDagLM($start, $length, $order, $searchByCol_0, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $updatedFlag);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $chitha_class_name = $this->utilityclass->getLandClassCode($landClass);

                $patta_details_chitha = $this->utilityclass->pattaNoFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $patta_name = $this->utilityclass->getPattaType($patta_details_chitha->patta_type_code);

                $zone_name = str_replace(' ', '-', ($this->utilityclass->getZoneName($rows->zone_id)));

                $subclass_name = str_replace(' ', '-', ($this->utilityclass->getSubclassName($rows->subclass_id)));

                if ($rows->flag == '0') {

                    $status =
                        "<span class='bg-yellow'><i class='fa fa-spinner' aria-hidden='true'></i> Sent To CO</span>";
                } else if ($rows->flag == '1') {
                    $status = "<span class='bg-success'>Approved by CO<i class='fa fa-check' aria-hidden='true'></i></span>";
                } else {
                    $status = "<span class='bg-danger'>Reverted <i class='fa fa-undo' aria-hidden='true'></i></span>";
                }

                $json[] = array(
                    $rows->dag_no,
                    $patta_details_chitha->patta_no,
                    $patta_name,
                    $chitha_class_name,
                    $zone_name,
                    $subclass_name,
                    $status
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    public function viewRevertedZonalDagLM()
    {
        $dist_code = $this->input->post('dist_code_reverted');
        $subdiv_code = $this->input->post('subdiv_code_reverted');
        $cir_code = $this->input->post('cir_code_reverted');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code_reverted');
        $lot_no = $this->input->post('lot_no_reverted');
        $village_code = $this->input->post('vill_code_selected');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        // $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $revertedFlag = '2';
        $results = $this->zonalinformationmodel->getRevertedZonalDagLM($start, $length, $order, $searchByCol_0, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $revertedFlag);

        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {


                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $mouza_name = str_replace(' ', '-', ($this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code)));

                $lot_name = str_replace(' ', '-', ($this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no)));

                $village_name = $this->utilityclass->getVillageNameByUUID($rows->unique_village_code);

                $chitha_class_name = $this->utilityclass->getLandClassCode($landClass);

                $patta_details_chitha = $this->utilityclass->pattaNoFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $patta_name = $this->utilityclass->getPattaType($patta_details_chitha->patta_type_code);

                $zone_name = str_replace(' ', '-', ($this->utilityclass->getZoneName($rows->zone_id)));

                $subclass_name = str_replace(' ', '-', ($this->utilityclass->getSubclassName($rows->subclass_id)));

                $village_name_string = str_replace(' ', '-', ($village_name));

                $chitha_class_name_string = str_replace(' ', '-', ($chitha_class_name));

                $onclick_modal = "editDagDetailsLM('" . $rows->dag_no . "','" . $rows->unique_village_code . "','" . $mouza_name . "','" . $lot_name . "','" . $village_name_string . "','" . $zone_name . "','" . $subclass_name . "','" . $chitha_class_name_string . "')";

                $edit = "<button class='btn btn-success btn-sm'  onclick=" . $onclick_modal . ">
                                        <i class='fa fa-edit' aria-hidden='true'></i>
                                        Reupdate Zonal Info
                                    </button>";

                $status = "<span class='text-danger'>Reverted <i class='fa fa-undo' aria-hidden='true'></i></span>";


                $json[] = array(
                    $rows->dag_no,
                    $patta_details_chitha->patta_no,
                    $patta_name,
                    $chitha_class_name,
                    $zone_name,
                    $subclass_name,
                    $status,
                    $edit

                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }




    //  ReUpdate  Dag Details  by CO
    public function reupdateDagDetailsByLM()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dag_no = $this->input->post('dag_no_lm_reupdate');
        $unique_village_code = $this->input->post('vill_code_lm_reupdate');
        $zone_id = $this->input->post('zone_name_reupdate_lm');
        $subclass_id = $this->input->post('lclass_name_reupdate_lm');

        $this->form_validation->set_rules('zone_name_reupdate_lm', 'Zone Name', 'required');
        $this->form_validation->set_rules('lclass_name_reupdate_lm', 'Land Class', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'responseType' => 3,
                'message' => 'Please Select Zone & Land Class !!',
            ));
        } else {

            $updateData = array(
                'zone_id' => $zone_id,
                'subclass_id' => $subclass_id,
                'flag' => '0',
                'modified_at' => date('Y-m-d H:i:s')
            );

            $where = array(
                'dag_no' => $dag_no,
                'unique_village_code' => $unique_village_code,

            );

            $reupdate_data_lm_status = $this->zonalinformationmodel->updateDagDetailsByCO($updateData, $where);

            if ($reupdate_data_lm_status != 1 || $reupdate_data_lm_status != true) {

                log_message("error", "#ZVUCO_DAGWISE, Error in Update, table 'dagwise_zone_info' with data :" . json_encode($updateData));
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#ZVUCO: Updation failed in dagwise_zone_info.',
                ));
            } else {
                echo json_encode([
                    "responseType" => "2",
                    "message" => "Zonal Details Reupdated and Sent to CO for Dag No  : " . $dag_no . "  with Zone:  " . $this->utilityclass->getZoneName($zone_id) . " and SubClass: " .  $this->utilityclass->getSubclassName($subclass_id)
                ]);
            }
        }
    }



    // Search Zonal Value  by Dag No

    public function searchZonalValueByDag()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dag_no = $this->input->post('dagNo');
        $village_uuid = trim($this->input->post('villageName'));
        $village_name = $this->utilityclass->getVillageNameByUUID($village_uuid);

        $this->form_validation->set_rules('dagNo', 'Dag Number', 'required');
        $this->form_validation->set_rules('villageName', 'village Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Please Select Village & Enter Dag No.',
            ));
        } else {

            $getZonalDetails = $this->zonalinformationmodel->getZoneSubclassDetails($dag_no, $village_uuid);

            if ($getZonalDetails == NULL) {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => 'Zonal Value missing: Dag no '  . $dag_no . ' of ' . $village_name . ' not entered by LM in Dagwise Zonal Module',
                ));
            } else {

                $zone_id = $getZonalDetails->zone_id;
                $subclass_id = $getZonalDetails->subclass_id;
                $approval_status = $getZonalDetails->flag;

                $zone_name =  $this->utilityclass->getZoneName($zone_id);
                $subclass_name =  $this->utilityclass->getSubclassName($subclass_id);

                if ($approval_status == '0') {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => 'Dag Details Updated by LM, Waiting for CO Approval',
                    ));
                } else if ($approval_status == '1') {
                    $getZonalValue = $this->zonalinformationmodel->getZonalValueDetails($village_uuid, $zone_id, $subclass_id);

                    if ($getZonalValue == NULL) {
                        echo json_encode(array(
                            'responseType' => 1,
                            'message' => 'Zonal Value missing  for ' . $zone_name . '  and ' . $subclass_name . ', Please inform LM to enter Land Rate for ' . $zone_name . ' and  ' . $subclass_name . ' combination for ' . $village_name . ' in Villagewise ZonalInfo module',
                        ));
                    } else {
                        $approval_status_villwise = $getZonalValue[0]->flag;
                        if ($approval_status_villwise == '0') {
                            echo json_encode(array(
                                'responseType' => 1,
                                'message' => 'Villagewise Zonal Details for ' . $zone_name . ' and ' . $subclass_name . ' of village ' . $village_name . ' Updated by LM, Waiting for CO Approval',
                            ));
                        } else if ($approval_status_villwise == '1') {
                            echo json_encode(array(
                                'responseType' => 2,
                                'zonaldetails' => $getZonalValue,
                                'villagename' => $village_name,
                            ));
                        } else if ($approval_status_villwise == '2') {
                            echo json_encode(array(
                                'responseType' => 1,
                                'message' => 'Villagewise Zonal Details for ' . $zone_name . ' and ' . $subclass_name . ' of village ' . $village_name . ' Reverted by CO to LM ',
                            ));
                        } else if ($approval_status_villwise == '3') {
                            echo json_encode(array(
                                'responseType' => 1,
                                'message' => 'Villagewise Zonal Details for ' . $zone_name . ' and ' . $subclass_name . ' of village ' . $village_name . ' sent to ADC for verification ',
                            ));
                        }
                    }
                } else if ($approval_status == '2') {
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => 'Dag Details Reverted by CO for Reupdate',
                    ));
                }
            }
        }
    }





    // Bulk Reject by CO
    public function bulkRejectByCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('dag_no_selected[]', 'Dag Number', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'responseType' => 3,
            ));
        } else {

            $dag_no_selected = $this->input->post('dag_no_selected');

            if (!empty($dag_no_selected)) {
                $this->db->trans_begin();

                foreach ($dag_no_selected as $row) {

                    $dag_no = strtok($row, '@');
                    $vill_uuid = strtok('');

                    $oldZonalData = $this->db->query("SELECT * FROM dagwise_zone_info WHERE dag_no=? AND 
                    unique_village_code=?", array($dag_no, $vill_uuid))->result();
                    $data = [
                        'ip' => $this->utilityclass->get_client_ip(),
                        'module_name' => 'Dagwise Zonal',
                        'user_code' => $this->session->userdata('user_code'),
                        'unique_village_id' => $vill_uuid,
                        'when_updated' => 'Rejected',
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($oldZonalData),
                    ];

                    $zonaldatabackup = $this->db->insert('zonal_data_backup', $data);

                    if ($zonaldatabackup <= 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRRZONALBACKUP: Insert failed in zonal_data_backup for bulk Reject by CO');
                        // log_message('error', $this->db->last_query());
                        echo json_encode(array(
                            'responseType' => 1,
                            'message' => '#ERRRZONALBACKUP: Insert failed in zonal_data_backup for bulk Reject by CO',

                        ));
                        return false;
                    }

                    $bulkRejectStatus = $this->zonalinformationmodel->bulkRejectDagwiseCO($dag_no, $vill_uuid);
                }
                if ($bulkRejectStatus <= 0) {

                    log_message('error', '#ERRREJECTZONALCO: Updation failed in dagwise_zone_info for bulk Reject');
                    // log_message('error', $this->db->last_query());

                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#ERRREJECTZONALCO: Updation failed in dagwise_zone_info. Kindly contact System Administrator',

                    ));
                    return false;
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', 'Zonal Details  Successfully Rejected');
                    echo json_encode(array(
                        'responseType' => 2,
                        'message' => 'Zonal Details  Successfully Rejected ',

                    ));
                }
            }
        }
    }

    // Get Zonal Value Details at ADC End
    public function GetZonalDetailsAdc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $adcPending = '3';
        $approvedFlag = '1';
        $revertedFlag = '2';

        $LocationListPending =  $this->zonalinformationmodel->getAdcVillageUUIDList($dist_code, $adcPending);
        $LocationListApproved =  $this->zonalinformationmodel->getAdcVillageUUIDList($dist_code, $approvedFlag);


        $cirListPending = array_column($LocationListPending, 'cir_code');
        $lotListPending = array_column($LocationListPending, 'lot_no');
        $villListPending = array_column($LocationListPending, 'unique_village_code');

        $cirListApproved = array_column($LocationListApproved, 'cir_code');
        $lotListApproved = array_column($LocationListApproved, 'lot_no');
        $villListApproved = array_column($LocationListApproved, 'unique_village_code');

        $data['cirListPending'] = $cirListPending;
        $data['lotListPending'] = $lotListPending;
        $data['villageListPending'] = $villListPending;


        $data['villageListApproved'] = $villListApproved;

        $data['_view'] = 'ZonalUpdateVillagewise/zonal_details_adc';
        $this->load->view('layouts/main', $data);
    }



    // Pending Zonal Details at ADC End 
    public function viewPendingCasesZonalADC()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        // $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        // $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $cir_code = $this->input->post('cir_code_pending');
        $lot_no = $this->input->post('lot_no_pending');
        $village_code = $this->input->post('village_uuid_pending');
        $zone_select = $this->input->post('zone_select');
        $adcPendingFlag = '3';
        $results = $this->zonalinformationmodel->viewZonalDetailsADC($start, $length, $order, $dist_code, $village_code, $adcPendingFlag);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $circle_name = $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code);

                $lot_name = $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);

                $village_name = $this->utilityclass->getVillageNameByUUID($rows->unique_village_code);

                $zone_name = str_replace(' ', '-', ($this->utilityclass->getZoneName($rows->zone_code)));

                $subclass_name = str_replace(' ', '-', ($this->utilityclass->getSubclassName($rows->subclass_code)));

                $zone = '<span class ="bg-yellow">' . $zone_name . '</span>';

                $subclass = '<span class ="bg-yellow">' . $subclass_name . '</span>';

                $village_name_string = str_replace(' ', '-', ($village_name));

               $approveCO = '<button type="button" onclick="approveByAdc(' . $rows->zone_code . ',' . $rows->subclass_code . ', ' . $rows->unique_village_code . ')" class="btn btn-sm btn-success"><i class="fa fa-clock-rotate-left"></i> Approve CO Value</button>&nbsp;';

                $approveLM = '<button type="button" onclick="rejectByAdc(' . $rows->zone_code . ',' . $rows->subclass_code . ', ' . $rows->unique_village_code . ')" class="btn btn-sm btn-primary"><i class="fa fa-clock-rotate-left"></i> Approve LM Value</button>';

                $revert = '<button type="button" onclick="revertByAdc(' . $rows->zone_code . ',' . $rows->subclass_code . ', ' . $rows->unique_village_code . ')" class="btn btn-sm btn-danger"><i class="fa fa-clock-rotate-left"></i> Revert to CO</button>';


                $json[] = array(
                    $circle_name,
                    $lot_name,
                    $village_name,
                    $zone,
                    $subclass,
                    $rows->land_rate,
                    $rows->temp_land_rate,
                    $approveLM . $approveCO . $revert
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    // Approved Zonal Details at ADC End 
    public function viewApprovedCasesZonalADC()
    {
        $dist_code = $this->input->post('dist_code_approved');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $village_code = $this->input->post('village_uuid_approved');
        $approvedFlag = '1';
        $results = $this->zonalinformationmodel->viewZonalDetailsADC($start, $length, $order, $dist_code, $village_code, $approvedFlag);
        // var_dump($results);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {
                $circle_name = $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code);

                $lot_name = $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);

                $village_name = $this->utilityclass->getVillageNameByUUID($rows->unique_village_code);

                $zone_name = str_replace(' ', '-', ($this->utilityclass->getZoneName($rows->zone_code)));

                $subclass_name = str_replace(' ', '-', ($this->utilityclass->getSubclassName($rows->subclass_code)));

                $zone = '<span class ="bg-success">' . $zone_name . '</span>';

                $subclass = '<span class ="bg-success">' . $subclass_name . '</span>';

                $village_name_string = str_replace(' ', '-', ($village_name));

                $status = "Approved";

                $json[] = array(
                    $circle_name,
                    $lot_name,
                    $village_name,
                    $zone,
                    $subclass,
                    $rows->land_rate,
                    $status

                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    // Approve Villagewise Zonal Details by ADC sent by CO
    public function approveZonaldetailsADC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $zone_code = $this->input->post('zone_code_pending');
        $subclass_code = $this->input->post('subclass_code_pending');
        $vill_code = $this->input->post('uuid_pending');

        $this->db->trans_begin();

        //Get the temp land rate update by CO 
        $zonal_value_co = $this->db->query("SELECT temp_land_rate FROM 
                villagewise_zone_info WHERE unique_village_code='$vill_code' AND  zone_code='$zone_code' AND subclass_code='$subclass_code' AND flag ='3'")->row();

        $temp_land_rate = $zonal_value_co->temp_land_rate;

        $where = [
            'zone_code' => $zone_code,
            'subclass_code' => $subclass_code,
            'unique_village_code' => (string)$vill_code,
        ];

        //insert in zonal_backup_adc
        $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
                unique_village_code='$vill_code'")->result_array();
        $data =
            [
                'ip' => $this->utilityclass->get_client_ip(),
                'adc_user_code' => $this->session->userdata('user_code'),
                'unique_village_id' => $vill_code,
                'when_updated' => 'Approved by ADC',
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($oldVillageZonalData),
                'module_name' => 'Villagewise',

            ];
        $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_adc', $data);
        // Insert in zonal_data_co_backup end

        if ($oldVillageZonalDataInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRZONALADCUPDATE004: Insertion failed in zonal_data_backup_adc');
            echo json_encode(array(
                'message' => '#Failed to Backup old Zonal Data.',
            ));
            return false;
        }

        $adcUpdate = $this->zonalinformationmodel->villageWiseStatusADC([
            'flag' => 1,
            'land_rate' => $temp_land_rate,
            'temp_land_rate' => '',
        ], $where);

        if ($adcUpdate == false || $adcUpdate != 1) {
            $this->db->trans_rollback();
            log_message("error", "#ZVUCO, Error in Update, table 'villagewise_zone_info' with data :");
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in villagewise_zone_info.',
            ));
        } else {
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Value Edited by CO  Approved Successfully',
            ));
        }
    }



    public function approveLMValueZonaldetailsADC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $zone_code = $this->input->post('zone_code_pending');
        $subclass_code = $this->input->post('subclass_code_pending');
        $vill_code = $this->input->post('uuid_pending');

        $where = [
            'zone_code' => $zone_code,
            'subclass_code' => $subclass_code,
            'unique_village_code' => (string)$vill_code,
        ];

        //insert in zonal_backup_adc
        $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
                unique_village_code='$vill_code'")->result_array();
        $data =
            [
                'ip' => $this->utilityclass->get_client_ip(),
                'adc_user_code' => $this->session->userdata('user_code'),
                'unique_village_id' => $vill_code,
                'when_updated' => 'Reject by ADC',
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($oldVillageZonalData),
                'module_name' => 'Villagewise',

            ];
        $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_adc', $data);
        // Insert in zonal_data_co_backup end

        if ($oldVillageZonalDataInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRZONALADCUPDATE004: Insertion failed in zonal_data_backup_adc');
            echo json_encode(array(
                'message' => '#Failed to Backup old Zonal Data.',
            ));
            return false;
        }

        $adcUpdate = $this->zonalinformationmodel->villageWiseStatusADC([
            'flag' => 1,
            'temp_land_rate' => '',
        ], $where);

        if ($adcUpdate == false || $adcUpdate != 1) {
            $this->db->trans_rollback();
            log_message("error", "#ZVUCO, Error in Update, table 'villagewise_zone_info' with data :");
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in villagewise_zone_info.',
            ));
        } else {
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Value Enetered by LM Approved Successfully',
            ));
        }
    }


    public function getPendingVillageZoneDetails()
    {
        $zoneDetailsSearchArr =  trim($_POST['zd_view_form_vill_code']);
        $zoneDetailsAll = $this->zonalinformationmodel->getPendingZoneDetailsVillageWise($zoneDetailsSearchArr);
        echo json_encode($zoneDetailsAll);
    }

    public function getRevertedVillageZoneDetails()
    {
        $zoneDetailsSearchArr =  trim($_POST['zd_view_form_vill_code']);
        $zoneDetailsAll = $this->zonalinformationmodel->getRevertedZoneDetailsVillageWise($zoneDetailsSearchArr);
        echo json_encode($zoneDetailsAll);
    }


    public function viewPendingVillagewiseZonalDetailsCO()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $subdiv_code = $this->input->post('subdiv_code_pending');
        $cir_code = $this->input->post('cir_code_pending');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        // $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $village_code = $this->input->post('village_code_pending');
        $pendingFlag = '0';
        $results = $this->zonalinformationmodel->viewZonalDagWiseCO($start, $length, $order, $searchByCol_1, $dist_code, $subdiv_code, $cir_code, $village_code, $pendingFlag);

        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $dag_no = '<input type="checkbox" class="checkBoxD selectMark" id="dag_no_checkbox' . $rows->dag_no . '" name="selectMark[]" value="' . $rows->dag_no . '@' . $rows->unique_village_code . '">';

                $landClass = $this->utilityclass->classCodeFromChitha($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code, $rows->dag_no);

                $revert = '<button type="button" onclick="revertToLm(' . $rows->dag_no . ', ' . $rows->unique_village_code . ')" class="btn btn-sm btn-primary revert-to-lm"><i class="fa fa-clock-rotate-left"></i> Revert Back to LM</button>';
                $reject = '<button type="button" onclick="rejectZonal(' . $rows->dag_no . ', ' . $rows->unique_village_code . ')" value="' . $rows->dag_no . '" class="btn btn-sm btn-danger confirm-reject">Reject</button>';

                $json[] = array(
                    $dag_no,
                    $rows->dag_no,
                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_code),
                    $this->utilityclass->getLandClassCode($landClass),
                    $this->utilityclass->getZoneName($rows->zone_id),
                    $this->utilityclass->getSubclassName($rows->subclass_id),
                    $revert . $reject,
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    //ADC End
    public function zonalinformationDetailsADC()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['user_code'] = $user_code = $this->session->userdata('user_code');

        if ($subdiv_code != '00' || $cir_code != '00' || $mouza_pargona_code != '00' || $lot_no != '00') {
            echo "<p>User Not Authorized</p>";
        } else {
            $sql = "SELECT * FROM uploaded_report WHERE dist_code ='$dist_code'  AND user_code='$user_code' AND is_active in ('E','R','A')";

            $data['document'] = $this->db->query($sql)->row();
            $data['document_count'] = $this->db->query($sql)->num_rows();

            $data['adcPendingCount'] = $this->db->query("select count(*) as c from  villagewise_zone_info where flag = '3' and dist_code ='$dist_code'")->row()->c;

            $data['_view'] = 'ZonalAutoUpdate/zonalinformation_adc';
            $this->load->view('layouts/main', $data);
        }
    }

    public function viewUploadedReportADC()
    {

        $dist_code = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;

        $data['_view'] = 'ZonalAutoUpdate/upload_report_details_adc';
        $this->load->view('layouts/main', $data);
    }


    // Pending Zonal Details Uploaded Report by CO at ADC end
    public function viewUploadedReportDetailsADC()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $results = $this->zonalinformationmodel->viewZonalDetailsUploadReportADC($start, $length, $order, $dist_code);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $circle_name = $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code);

                $co_name = $this->utilityclass->getSelectedCOName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->user_code);

                $date_upload =  date('d-M-Y', strtotime($rows->date_upload));


                $viewReport = '<a class="btn btn-secondary btn-sm" target="download" href=" ' . base_url() . 'index.php/ZonalByforcationController/viewUploadedReportByCOADC/' . $rows->subdiv_code . '/' . $rows->cir_code . '/' . $rows->user_code . '"><i class="fa fa-eye"></i> view CO Report</a>';

                $approve = '<button type="button" onclick="approveUploadedReporADC(' . "'" . $rows->dist_code . "'" . ',' . "'" . $rows->subdiv_code . "'" . ', ' . "'" . $rows->cir_code . "'" . ', ' . "'" . $rows->user_code . "'" . ' , ' . "'" . $circle_name . "'" . '  )" class="btn btn-sm btn-success"><i class="fa fa-clock-rotate-left"></i> Approve</button>&nbsp;';

                $revert = '<button type="button" onclick="revertUploadedReporADC(' . "'" . $rows->dist_code . "'" . ',' . "'" . $rows->subdiv_code . "'" . ', ' . "'" . $rows->cir_code . "'" . ', ' . "'" . $rows->user_code . "'" . ' , ' . "'" . $circle_name . "'" . '  )" class="btn btn-sm btn-danger"><i class="fa fa-clock-rotate-left"></i> Revert for Reupload</button>&nbsp;';

                if ($rows->is_active == 'E') {
                    $status = $approve . $revert;
                } else if ($rows->is_active == 'A') {
                    $status = '<strong class="text-success">Approved</strong>';
                } else if ($rows->is_active == 'R') {
                    $status = '<strong class="text-danger">Revert for Reupload</strong>';
                }


                $json[] = array(
                    $circle_name,
                    $co_name->username,
                    $viewReport,
                    $date_upload,
                    // $approve . $revert
                    $status
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    // Approve Villagewise Zonal Details by ADC sent by CO
    public function approveZonalUploadReportADC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dist_code = $this->input->post('dist_code_report');
        $subdiv_code = $this->input->post('subdiv_code_report');
        $cir_code = $this->input->post('cir_code_report');
        $co_user_code = $this->input->post('co_user_code_report');

        $updateData = [
            'is_active' => 'A',
            'update_date' => date('Y-m-d H:i:s'),

        ];
        $where = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'user_code' => $co_user_code,
            'is_active' => 'E',
            'report_by' => 'CO',
        ];
        $updateReportADC = $this->db->set($updateData)->where($where)->update('uploaded_report');


        if ($updateReportADC == false || $updateReportADC != 1) {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in uploaded_report.',
            ));
        } else {
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Report by CO Approved Successfully',
            ));
        }
    }



    public function revertZonalUploadReportADC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dist_code = $this->input->post('dist_code_report');
        $subdiv_code = $this->input->post('subdiv_code_report');
        $cir_code = $this->input->post('cir_code_report');
        $co_user_code = $this->input->post('co_user_code_report');

        $updateData = [
            'is_active' => 'R',
            'update_date' => date('Y-m-d H:i:s'),

        ];
        $where = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'user_code' => $co_user_code,
            'is_active' => 'E',
            'report_by' => 'CO',
        ];
        $updateReportADC = $this->db->set($updateData)->where($where)->update('uploaded_report');


        if ($updateReportADC == false || $updateReportADC != 1) {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in uploaded_report.',
            ));
        } else {
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Report by CO Reverted Successfully',
            ));
        }
    }

    //ADC End
    public function zonalinformationDetailsDC()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['user_code'] = $user_code = $this->session->userdata('user_code');

        if ($subdiv_code != '00' || $cir_code != '00' || $mouza_pargona_code != '00' || $lot_no != '00') {

            echo "<p>User Not Authorized</p>";
        } else {
            $sql = "SELECT * FROM uploaded_report WHERE dist_code ='$dist_code'  AND user_code='$user_code' AND is_active in ('E','R','A')";

            $data['document'] = $this->db->query($sql)->row();
            $data['document_count'] = $this->db->query($sql)->num_rows();

            $data['adcPendingCount'] = $this->db->query("select count(*) as c from  villagewise_zone_info where flag = '3' and dist_code ='$dist_code'")->row()->c;

            $data['_view'] = 'ZonalAutoUpdate/zonalinformation_dc';
            $this->load->view('layouts/main', $data);
        }
    }


    public function viewUploadedReportDC()
    {

        $dist_code = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;

        $data['_view'] = 'ZonalAutoUpdate/upload_report_details_dc';
        $this->load->view('layouts/main', $data);
    }


    public function viewUploadedReportDetailsDC()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $results = $this->zonalinformationmodel->viewZonalDetailsUploadReportDC($start, $length, $order, $dist_code);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {


                $circle_name = $this->utilityclass->getCircleName($rows->dist_code, $rows->uploaded_subdiv_adc, $rows->uploaded_circle_adc);


                $district_name = $this->utilityclass->getDistrictName($rows->dist_code);

                $adc_name = $this->utilityclass->getSelectedADCName($rows->dist_code, $rows->user_code);

                $date_upload =  date('d-M-Y', strtotime($rows->date_upload));

                $viewReport = '<a class="btn btn-secondary btn-sm" target="download" href=" ' . base_url() . 'index.php/ZonalByforcationController/viewUploadedReportByADCCircleWise/' . $rows->uploaded_subdiv_adc . '/' . $rows->uploaded_circle_adc . '/' . $rows->user_code . '"><i class="fa fa-eye"></i> view ADC Report</a>';

                $approve = '<button type="button" onclick="approveUploadedReporDC(' . "'" . $rows->dist_code . "'" . ',' . "'" . $rows->uploaded_subdiv_adc . "'" . ', ' . "'" . $rows->uploaded_circle_adc . "'" . ', ' . "'" . $rows->user_code . "'" . ')" class="btn btn-sm btn-success"><i class="fa fa-clock-rotate-left"></i> Approve</button>&nbsp;';

                $revert = '<button type="button" onclick="revertUploadedReporDC(' . "'" . $rows->dist_code . "'" . ',' . "'" . $rows->uploaded_subdiv_adc . "'" . ', ' . "'" . $rows->uploaded_circle_adc . "'" . ', ' . "'" . $rows->user_code . "'" . ')" class="btn btn-sm btn-danger"><i class="fa fa-clock-rotate-left"></i> Revert for Reupload</button>&nbsp;';

                if ($rows->is_active == 'E') {
                    $status = $approve . $revert;
                } else if ($rows->is_active == 'A') {
                    $status = '<strong class="text-success">Approved</strong>';
                } else if ($rows->is_active == 'R') {
                    $status = '<strong class="text-danger">Revert for Reupload</strong>';
                }


                $json[] = array(
                    $circle_name . ' (' . $district_name . ')',
                    $adc_name->username,
                    $viewReport,
                    $date_upload,
                    $status
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    public function approveZonalUploadReportDC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dist_code = $this->input->post('dist_code_report');
        $adc_user_code = $this->input->post('adc_user_code_report');

        $subdiv_code_report = $this->input->post('subdiv_code_report');
        $circle_code_report = $this->input->post('circle_code_report');


        $updateData = [
            'is_active' => 'A',
            'update_date' => date('Y-m-d H:i:s'),

        ];
        $where = [
            'dist_code' => $dist_code,
            'subdiv_code' => '00',
            'cir_code' => '00',
            'mouza_pargona_code' => '00',
            'lot_no' => '00',
            'user_code' => $adc_user_code,
            'uploaded_subdiv_adc' => $subdiv_code_report,
            'uploaded_circle_adc' => $circle_code_report,
            'is_active' => 'E',
            'report_by' => 'ADC',
        ];
        $updateReportDC = $this->db->set($updateData)->where($where)->update('uploaded_report');


        if ($updateReportDC == false || $updateReportDC != 1) {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in uploaded_report.',
            ));
        } else {
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Certification Report by ADC Approved Successfully',
            ));
        }
    }


    public function revertZonalUploadReportDC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dist_code = $this->input->post('dist_code_report');
        $adc_user_code = $this->input->post('adc_user_code_report');

        $subdiv_code_report = $this->input->post('subdiv_code_report');
        $circle_code_report = $this->input->post('circle_code_report');

        $updateData = [
            'is_active' => 'R',
            'update_date' => date('Y-m-d H:i:s'),

        ];
        $where = [
            'dist_code' => $dist_code,
            'subdiv_code' => '00',
            'cir_code' => '00',
            'cir_code' => '00',
            'mouza_pargona_code' => '00',
            'lot_no' => '00',
            'user_code' => $adc_user_code,
            'uploaded_subdiv_adc' => $subdiv_code_report,
            'uploaded_circle_adc' => $circle_code_report,
            'is_active' => 'E',
            'report_by' => 'ADC',
        ];
        $updateReportDC = $this->db->set($updateData)->where($where)->update('uploaded_report');


        if ($updateReportDC == false || $updateReportDC != 1) {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in uploaded_report.',
            ));
        } else {
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Report by ADC Reverted Successfully',
            ));
        }
    }


    public function zonalValueReportLM()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['user_code'] = $user_code = $this->session->userdata('user_code');

        if ($subdiv_code == '00' || $cir_code == '00' || $mouza_pargona_code == '00' || $lot_no == '00') {
            echo "<span class='text-danger'>User Not Authoorized</span>";
        } else {
            $sql = "SELECT * FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND mouza_pargona_code ='$mouza_pargona_code' AND lot_no ='$lot_no' AND user_code='$user_code' AND is_active in ('E','R','A')";

            $data['document'] = $this->db->query($sql)->row();
            $data['document_count'] = $this->db->query($sql)->num_rows();

            $data['_view'] = 'ZonalAutoUpdate/zonalvaluereport_lm';
            $this->load->view('layouts/main', $data);
        }
    }


    public function viewUploadedReportCO()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $data['mouza_pargona_code'] = $mouza_pargona_code;
        $data['lot_no'] = $lot_no;


        $data['_view'] = 'ZonalAutoUpdate/upload_report_details_co_by_lm';
        $this->load->view('layouts/main', $data);
    }




    // Pending Zonal Details Uploaded Report by LM at CO end
    public function viewUploadedReportDetailsCO()
    {
        $dist_code = $this->input->post('dist_code_pending');
        $subdiv_code = $this->input->post('subdiv_code_pending');
        $cir_code = $this->input->post('cir_code_pending');
        // var_dump($cir_code);
        // die;

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $results = $this->zonalinformationmodel->viewZonalDetailsUploadReportCO($start, $length, $order, $dist_code, $subdiv_code, $cir_code);
        if (isset($results)) {
            $data_rows = $results['data_results'];
            foreach ($data_rows as $rows) {

                $lot_name = $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);

                $lm_name = $this->utilityclass->getDefinedMondalsName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->user_code)->lm_name;

                $date_upload =  date('d-M-Y', strtotime($rows->date_upload));

                $viewLMReport = '<a class="btn btn-secondary btn-sm" target="download" href=" ' . base_url() . 'index.php/ZonalByforcationController/viewUploadedReportByLMCO/' . $rows->subdiv_code . '/' . $rows->cir_code . '/'  . $rows->mouza_pargona_code . '/' . $rows->lot_no . '/' . $rows->user_code . '"><i class="fa fa-eye"></i> view LM Report</a>';

                $approve = '<button type="button" onclick="approveUploadedReportByCO(' . "'" . $rows->dist_code . "'" . ',' . "'" . $rows->subdiv_code . "'" . ', ' . "'" . $rows->cir_code . "'" . ', ' . "'" . $rows->mouza_pargona_code . "'" . ', ' . "'" . $rows->lot_no . "'" . ', ' . "'" . $rows->user_code . "'" . ' , ' . "'" . $lot_name . "'" . '  )" class="btn btn-sm btn-success"><i class="fa fa-clock-rotate-left"></i> Approve LM</button>&nbsp;';

                $revert = '<button type="button" onclick="revertUploadedReportByCO(' . "'" . $rows->dist_code . "'" . ',' . "'" . $rows->subdiv_code . "'" . ', ' . "'" . $rows->cir_code . "'" . ', ' . "'" . $rows->mouza_pargona_code . "'" . ', ' . "'" . $rows->lot_no . "'" . ', ' . "'" . $rows->user_code . "'" . ' , ' . "'" . $lot_name . "'" . '  )" class="btn btn-sm btn-danger"><i class="fa fa-clock-rotate-left"></i> Revert for Reupload</button>&nbsp;';

                if ($rows->is_active == 'E') {
                    $status = $approve . $revert;
                } else if ($rows->is_active == 'A') {
                    $status = '<strong class="text-success">Approved</strong>';
                } else if ($rows->is_active == 'R') {
                    $status = '<strong class="text-danger">Revert for Reupload</strong>';
                }


                $json[] = array(
                    $lot_name,
                    $lm_name,
                    $viewLMReport,
                    $date_upload,
                    // $approve . $revert
                    $status
                );
            }
            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    // Approve Villagewise Zonal Details by ADC sent by CO
    public function approveZonalUploadReportCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dist_code = $this->input->post('dist_code_report');
        $subdiv_code = $this->input->post('subdiv_code_report');
        $cir_code = $this->input->post('cir_code_report');
        $mouza_pargona_code = $this->input->post('mouza_code_report');
        $lot_no = $this->input->post('lot_no_report');
        $co_user_code = $this->input->post('co_user_code_report');

        if ($subdiv_code != '00' || $cir_code != '00' || $mouza_pargona_code != '00' || $lot_no != '00') {

            $updateData = [
                'is_active' => 'A',
                'update_date' => date('Y-m-d H:i:s'),

            ];
            $where = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'subdiv_code' => $subdiv_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'is_active' => 'E',
                'report_by' => 'LM',
            ];
            $updateReportCO = $this->db->set($updateData)->where($where)->update('uploaded_report');

            if ($updateReportCO == false || $updateReportCO != 1) {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#ZVUADC: Updation failed in uploaded_report.',
                ));
            } else {
                echo json_encode(array(
                    'responseType' => 2,
                    'message' => 'Zonal Report by LM Approved Successfully',
                ));
            }
        }
    }




    // Approve Villagewise Zonal Details by ADC sent by CO
    public function revertZonalUploadReportCO()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dist_code = $this->input->post('dist_code_report');
        $subdiv_code = $this->input->post('subdiv_code_report');
        $cir_code = $this->input->post('cir_code_report');
        $mouza_pargona_code = $this->input->post('mouza_code_report');
        $lot_no = $this->input->post('lot_no_report');
        $co_user_code = $this->input->post('co_user_code_report');

        $updateData = [
            'is_active' => 'R',
            'update_date' => date('Y-m-d H:i:s'),
        ];
        $where = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'is_active' => 'E',
            'report_by' => 'LM',
        ];
        $updateReportCO = $this->db->set($updateData)->where($where)->update('uploaded_report');


        if ($updateReportCO == false || $updateReportCO != 1) {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in uploaded_report.',
            ));
        } else {
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Report by LM Reverted Successfully',
            ));
        }
    }


    // getting the data for ediit modal 
    public function getMissingZoneDetailsCo()
    {
        $zoneDetailsSearchArr =  trim($_POST['zd_missing_form_vill_code_co']);
        $zoneDetailsAll = $this->zonalinformationmodel->getAllMissingZoneSubclassVillageWise($zoneDetailsSearchArr);
        echo json_encode($zoneDetailsAll);
    }







    public function addMissingZonalCombinationCO()
    {
        $dist_code = $this->input->post('zd_missing_form_dist_code_co');
        $subdiv_code = $this->input->post('zd_missing_form_subdiv_code_co');
        $cir_code = $this->input->post('zd_missing_form_cir_code_co');

        $unique_village_code = $this->input->post('zd_missing_form_vill_code_co');
        $mouza_pargona_code = $this->input->post('zd_missing_form_mouza_code_co');
        $lot_no = $this->input->post('zd_missing_form_lot_no_co');
        $vill_townprt_code = $this->input->post('zd_missing_form_vill_townprt_co');
        // $unique_village_name = $this->utilityclass->getVillageNameByUUID($unique_village_code);
        // $villagewise_zonal_id = $this->input->post('missing_villagewise_zonal_id');
        $input_zonal_values = $this->input->post('missing_land_rate_co');
        $input_zone_codes = $this->input->post('missing_zone_code_co');
        $input_subclass_codes = $this->input->post('missing_subclass_code_co');
        $input_zone_names = $this->input->post('missing_zone_name_co');
        $input_subclass_names = $this->input->post('missing_subclass_name_co');
        $num_rows = $this->input->post('no_of_rows_missing_form');


        $this->form_validation->set_rules('zd_missing_form_dist_code_co', 'Dist Code', 'trim|required');
        $this->form_validation->set_rules('zd_missing_form_subdiv_code_co', 'Subdiv Code', 'trim|required');
        $this->form_validation->set_rules('zd_missing_form_cir_code_co', 'Cir Code', 'trim|required');
        $this->form_validation->set_rules('zd_missing_form_mouza_code_co', 'Mouza Code', 'trim|required');
        $this->form_validation->set_rules('zd_missing_form_lot_no_co', 'Lot Code', 'trim|required');
        $this->form_validation->set_rules('zd_missing_form_vill_code_co', 'Village UUID', 'trim|required');
        $this->form_validation->set_rules('zd_missing_form_vill_townprt_co', 'Village Code', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'responseType' => 3,
                'message' => 'Validation Errors !. Check Form Data',
            ));
        }
        // die;

        $num_rows = $_POST['no_of_rows_missing_form'];
        $insertion_data_for_missing_details_arr = array();
        for ($i = 0; $i < ($num_rows); $i++) {

            $insertion_data_for_missing_details_arr = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_townprt_code,
                'unique_village_code' => $unique_village_code,
                'zone_name' => $_POST['missing_zone_name_co'][$i],
                'subclass_name' => $_POST['missing_subclass_name_co'][$i],
                'zone_code' => $_POST['missing_zone_code_co'][$i],
                'subclass_code' => $_POST['missing_subclass_code_co'][$i],
                'land_rate' => $_POST['missing_land_rate_co'][$i],
                'flag' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'modified_at' => date('Y-m-d H:i:s'),
            ];

            $insertMissingZonal = $this->db->insert('villagewise_zone_info', $insertion_data_for_missing_details_arr);
        }

        if ($insertMissingZonal != true) {
            log_message("error", "#ZVUCO, Error in Update, table 'villagewise_zone_info' with data :" . json_encode($insertMissingZonal));
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUCO: Updation failed in villagewise_zone_info.',
            ));
        } else {
            echo json_encode([
                "responseType" => 2,
                "message" => "Zone Subclass Combination  Successfully Added for village : "
            ]);
        }
    }




    //Revert Zonal Details by ADC to CO
    public function revertZonaldetailsADC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $zone_code = $this->input->post('zone_code_pending');
        $subclass_code = $this->input->post('subclass_code_pending');
        $vill_code = $this->input->post('uuid_pending');

        $where = [
            'zone_code' => $zone_code,
            'subclass_code' => $subclass_code,
            'unique_village_code' => (string)$vill_code,
        ];

        //insert in zonal_backup_adc
        $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
                unique_village_code='$vill_code'")->result_array();


        $data =
            [
                'ip' => $this->utilityclass->get_client_ip(),
                'adc_user_code' => $this->session->userdata('user_code'),
                'unique_village_id' => $vill_code,
                'when_updated' => 'Reverted by ADC',
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($oldVillageZonalData),
                'module_name' => 'Villagewise',

            ];

        $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_adc', $data);

        // Insert in zonal_data_co_backup end

        if ($oldVillageZonalDataInsert != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRZONALADCUPDATE004: Insertion failed in zonal_data_backup_adc');
            echo json_encode(array(
                'message' => '#Failed to Backup old Zonal Data.',
            ));
            return false;
        }

        $adcUpdate = $this->zonalinformationmodel->villageWiseStatusADC([
            'flag' => 4,
        ], $where);

        if ($adcUpdate == false || $adcUpdate != 1) {
            $this->db->trans_rollback();
            log_message("error", "#ZVUCO, Error in Update, table 'villagewise_zone_info' with data :");
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADC: Updation failed in villagewise_zone_info.',
            ));
        } else {
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Zonal Details  Reverted to CO Successfully',
            ));
        }
    }


    // getting the data for ediit modal 
    public function getRevertedDetailsForEditAdcCo()
    {
        $zoneDetailsSearchArr =  trim($_POST['zd_edit_form_vill_code_co_reverted']);
        $zoneDetailsAll = $this->zonalinformationmodel->getZonalDetailsRevertedByAdc($zoneDetailsSearchArr);
        echo json_encode($zoneDetailsAll);
    }

    public function bulkApproveByAdcCo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $allSelectedList = $this->input->post('selectedList');

        if (!empty($allSelectedList)) {

            $this->db->trans_begin();
            foreach ($allSelectedList as $string) {
                $exploded = explode("@", $string);

                $zone_code = $exploded[0];
                $subclass_code = $exploded[1];
                $unique_village_code = $exploded[2];
                $temp_land_rate = $exploded[3];

                //Backup Start
                $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE 
                unique_village_code='$unique_village_code' and zone_code ='$zone_code' and subclass_code ='$subclass_code' ")->result_array();

                $data =
                    [
                        'ip' => $this->utilityclass->get_client_ip(),
                        'adc_user_code' => $this->session->userdata('user_code'),
                        'unique_village_id' => $unique_village_code,
                        'when_updated' => 'Approved CO Value',
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($oldVillageZonalData),
                        'module_name' => 'Villagewise',
                    ];
                $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_adc', $data);
                // Backup end

            }

            if ($oldVillageZonalDataInsert === false) {
                $this->db->trans_rollback();
                log_message('error', '#ERRBACKUPADCZONAL001: Insertion failed in zonal_data_backup_adc for bulk Approve CO Value by ADC');
                log_message('error', $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#ERRBACKUPADCZONAL001: Updation failed. Kindly contact System Administrator',
                ));
                return false;
            } else {
                foreach ($allSelectedList as $string) {
                    $exploded = explode("@", $string);

                    $zone_code = $exploded[0];
                    $subclass_code = $exploded[1];
                    $unique_village_code = $exploded[2];
                    $temp_land_rate = $exploded[3];

                    $updateData = [
                        'flag' => 1,
                        'land_rate' => $temp_land_rate,
                        'temp_land_rate' => '',
                    ];

                    $where = [
                        'zone_code' => $zone_code,
                        'subclass_code' => $subclass_code,
                        'unique_village_code' => $unique_village_code,
                    ];

                    $updateVillagewiseZonal = $this->zonalinformationmodel->updateZonalValueAdc($updateData, $where);
                }
                if ($updateVillagewiseZonal === false || $updateVillagewiseZonal <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRDUPDATEADCZONAL001: Updation failed in villagewise_zone_info for bulk Approve CO Value by ADC');
                    log_message('error', $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#ERRDUPDATEADCZONAL001: Updation failed. Kindly contact System Administrator',
                    ));
                    return false;
                } else {
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message' => 'Zonal Value sent by CO Approved Successfully',
                    ));
                }
            }
        }
    }


    public function bulkApproveByAdcLm()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $allSelectedList = $this->input->post('selectedList');

        if (!empty($allSelectedList)) {

            $this->db->trans_begin();
            foreach ($allSelectedList as $string) {
                $exploded = explode("@", $string);

                $zone_code = $exploded[0];
                $subclass_code = $exploded[1];
                $unique_village_code = $exploded[2];
                $temp_land_rate = $exploded[3];

                //Backup Start
                $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE
                unique_village_code='$unique_village_code' and zone_code ='$zone_code' and subclass_code ='$subclass_code' ")->result_array();

                $data =
                    [
                        'ip' => $this->utilityclass->get_client_ip(),
                        'adc_user_code' => $this->session->userdata('user_code'),
                        'unique_village_id' => $unique_village_code,
                        'when_updated' => 'Approved LM Value',
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($oldVillageZonalData),
                        'module_name' => 'Villagewise',
                    ];
                $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_adc', $data);
                // Backup end

            }

            if ($oldVillageZonalDataInsert === false) {
                $this->db->trans_rollback();
                log_message('error', '#ERRBACKUPADCZONAL002: Insertion failed in zonal_data_backup_adc for bulk Approve LM Value by ADC');
                log_message('error', $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#ERRBACKUPADCZONAL002: Updation failed. Kindly contact System Administrator',
                ));
                return false;
            } else {
                foreach ($allSelectedList as $string) {
                    $exploded = explode("@", $string);

                    $zone_code = $exploded[0];
                    $subclass_code = $exploded[1];
                    $unique_village_code = $exploded[2];
                    $temp_land_rate = $exploded[3];

                    $updateData = [
                        'flag' => 1,
                        'temp_land_rate' => '',
                    ];

                    $where = [
                        'zone_code' => $zone_code,
                        'subclass_code' => $subclass_code,
                        'unique_village_code' => $unique_village_code,
                    ];

                    $updateVillagewiseZonal = $this->zonalinformationmodel->updateZonalValueAdc($updateData, $where);
                }
                if ($updateVillagewiseZonal === false || $updateVillagewiseZonal <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRDUPDATEADCZONAL002: Updation failed in villagewise_zone_info for bulk Approve LM Value by ADC');
                    log_message('error', $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#ERRDUPDATEADCZONAL002: Updation failed. Kindly contact System Administrator',
                    ));
                    return false;
                } else {
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message' => 'Zonal Value entered by LM Approved Successfully',
                    ));
                }
            }
        }
    }




    public function bulkRevertByAdcCo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $allSelectedList = $this->input->post('selectedList');

        if (!empty($allSelectedList)) {

            $this->db->trans_begin();
            foreach ($allSelectedList as $string) {
                $exploded = explode("@", $string);

                $zone_code = $exploded[0];
                $subclass_code = $exploded[1];
                $unique_village_code = $exploded[2];
                $temp_land_rate = $exploded[3];

                //Backup Start
                $oldVillageZonalData = $this->db->query("SELECT * FROM villagewise_zone_info WHERE
                unique_village_code='$unique_village_code' and zone_code ='$zone_code' and subclass_code ='$subclass_code' ")->result_array();

                $data =
                    [
                        'ip' => $this->utilityclass->get_client_ip(),
                        'adc_user_code' => $this->session->userdata('user_code'),
                        'unique_village_id' => $unique_village_code,
                        'when_updated' => 'Reverted CO Value',
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($oldVillageZonalData),
                        'module_name' => 'Villagewise',
                    ];
                $oldVillageZonalDataInsert = $this->db->insert('zonal_data_backup_adc', $data);
                // Backup end

            }

            if ($oldVillageZonalDataInsert === false) {
                $this->db->trans_rollback();
                log_message('error', '#ERRBACKUPADCZONAL003: Insertion failed in zonal_data_backup_adc for bulk Revert CO Value by ADC');
                log_message('error', $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#ERRBACKUPADCZONAL003: Updation failed. Kindly contact System Administrator',
                ));
                return false;
            } else {
                foreach ($allSelectedList as $string) {
                    $exploded = explode("@", $string);

                    $zone_code = $exploded[0];
                    $subclass_code = $exploded[1];
                    $unique_village_code = $exploded[2];
                    $temp_land_rate = $exploded[3];

                    $updateData = [
                        'flag' => 4,
                    ];

                    $where = [
                        'zone_code' => $zone_code,
                        'subclass_code' => $subclass_code,
                        'unique_village_code' => $unique_village_code,
                    ];

                    $updateVillagewiseZonal = $this->zonalinformationmodel->updateZonalValueAdc($updateData, $where);
                }
                if ($updateVillagewiseZonal === false || $updateVillagewiseZonal <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRDUPDATEADCZONAL003: Updation failed in villagewise_zone_info for bulk Revert  by ADC');
                    log_message('error', $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message' => '#ERRDUPDATEADCZONAL003: Updation failed. Kindly contact System Administrator',
                    ));
                    return false;
                } else {
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message' => 'Zonal Value Reverted Successfully',
                    ));
                }
            }
        }
    }




    // Update Zonal Details by CO Reverted by ADC




    public function zonalInformationUpdateRevertedADCCO()
    {

        $unique_village_code = $_POST['zd_edit_form_vill_code_co_reverted'];
        $villagewise_zonal_id = $_POST['edit_villagewise_zonal_id_reverted'];
        $input_co_zonal_values = $_POST['edit_land_rate_co_reverted'];

        $num_rows = $_POST['no_of_rows_update_form_reverted'];


        foreach ($input_co_zonal_values as $zonal_value) {
            $input_arr[] =
                array(
                    'land_rate' =>  $zonal_value,
                );
        }

        $inputZonalArr = array_column($input_arr, "land_rate");

        $updation_data_for_reverted_details_arr = array();
        for ($i = 0; $i < count($villagewise_zonal_id); $i++) {

            $updation_data_for_reverted_details_arr = [
                'temp_land_rate' => $_POST['edit_land_rate_co_reverted'][$i],
                'flag' => 3,
                'modified_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('id', $villagewise_zonal_id[$i]);
            $this->db->where('unique_village_code', $unique_village_code);
            $update_data_co_status = $this->db->update('villagewise_zone_info',  $updation_data_for_reverted_details_arr);
        }

        if ($update_data_co_status != true) {
            log_message("error", "#ZVUADCRVTCO, Error in Update, table 'villagewise_zone_info' with data :");
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#ZVUADCRVTCO: Updation failed in villagewise_zone_info.',
            ));
        } else {
            echo json_encode([
                "responseType" => 2,
                "message" => "Zonal Value Updated Successfully and sent to ADC"
            ]);
        }
    }


    public function multipleReportUploadADC()
    {

        $dist_code = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;

        $results = $this->zonalinformationmodel->uploadedZonalReportDetailsByCo($dist_code);

        $data['results'] = $results;
        $data['_view'] = 'ZonalAutoUpdate/multiple_report_upload_adc';
        $this->load->view('layouts/main', $data);
    }
}
