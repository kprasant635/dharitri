<?php
class Dagflag extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url', 'Language'));
    }


    public function MappingIndexLM($value = '')
    {
        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
            exit;
        }
        $data = array();
        $data['_view'] = 'Dagflag/MappingIndexLM';
        $this->load->view('layouts/main', $data);
    }

    /*** Location Form for lm *****/
    public function locationDetails()
    {
        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);


        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_name' => $lot_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code
        );

        //Area Mapping Mriganka Da
        $villages = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        foreach ($villages as $key => $value) {
            $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $value->vill_townprt_code);

            $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $value->vill_townprt_code);

            $countCheckForAllMappedOrNot = $this->Dagflagmodel->getInsertedCountOfVillage($uuid);

            if ($countCheckForAllMappedOrNot == count($daginfo)) {
                unset($villages[$key]);
            }
        }

        //Dag Flagging Other Dag
        $villagesZonal = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        foreach ($villagesZonal as $key => $value) {
            $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $value->vill_townprt_code);

            $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $value->vill_townprt_code);

            $countCheckForFullFlaggedOrNot = $this->Dagflagmodel->getInsertedDagCountOfVillageOtherFlag($uuid)->num_rows();

            if ($countCheckForFullFlaggedOrNot == count($daginfo)) {
                unset($villagesZonal[$key]);
            }
        }


        $data['villages'] = $villages;
        $sql1 = "Select * from settlement_premium_area order by paid asc";
        $area = $this->db->query($sql1)->result();
        $data['area'] = $area;
        $data['villagesZonal'] = $villagesZonal;
        $sql1 = "Select * from dag_flag_master order by flagid asc";
        $flags = $this->db->query($sql1)->result();
        $data['flags'] = $flags;
        $data['_view'] = 'Dagflag/select_location_for_lm';
        $this->load->view('layouts/main', $data);
    }


    public function updateFullMapping()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_townprt_code');
        $areasel = $this->input->post('areasel');

        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);
        if ($areasel == null || $areasel == '') {
            log_message('error', '#ERMB0106: Mapping Category not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Mapping Category not found']);
            return;
        }
        $this->load->model('chitha/ChithaModel');
        $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking data already exist or not=============
        $countCheckForAllMappedOrNot = $this->Dagflagmodel->getInsertedCountOfVillage($uuid);

        if ($countCheckForAllMappedOrNot > 0) {
            log_message('error', '#ERMB0106: Data Already exist in table name area_dag_flag======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Already mapped with this village']);
        }
        $insertArray = array();

        foreach ($daginfo as $key => $value) {

            $insertArray[] = [
                'dag_no' =>  $value->dag_no,
                'uuid' =>  $uuid,
                'status' =>  'P',
                'created_at' => date('Y-m-d h:i:s'),
                'modified_at' => date('Y-m-d h:i:s'),
                'cat' => $areasel

            ];
        }
        $this->db->trans_begin();
        $this->db->insert_batch('area_dag_flag', $insertArray);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB0106: Insertion error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Mapped Not Done, Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Mapped Successfully']);
        }
    }

    //PARTIAL MAPPING===================
    public function partialmapping()
    {

        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $vill_code = $this->input->get('no');
        $data['vill_name'] = $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code
        );
        // echo $dist_code."-".$subdiv_code."-".$cir_code."-".$mouza_pargona_code."-".$lot_no."-".$vill_code;
        // die;
        $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $data['daginfo'] = $daginfo;
        $sql1 = "Select * from settlement_premium_area order by paid asc";
        $area = $this->db->query($sql1)->result();
        $data['area'] = $area;


        $data['_view'] = 'Dagflag/select_location_for_lm_partial';
        $this->load->view('layouts/main', $data);
    }

    public function getDagslower()
    {
        $this->load->model('chitha/ChithaModel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $data['daginfo'] = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $sql1 = "Select * from settlement_premium_area order by paid asc";
        $area = $this->db->query($sql1)->result();
        $data['area'] = $area;
        // $json = array();
        // foreach ($daginfo as $d) {
        //     $json['dags'][] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        // }
        echo json_encode($data);
    }


    public function partialMappingSubmit()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $selectedDags = $this->input->post('selectedDags');
        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        //checking data already exist or not=============
        $countCheckForAllMappedOrNot = $this->Dagflagmodel->getInsertedCountOfVillage($uuid);

        if ($countCheckForAllMappedOrNot > 0) {
            log_message('error', '#ERMB0106: Data Already exist in table name area_dag_flag======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Already mapped with this village']);
        }


        $dags = explode(',', $selectedDags);
        $insertArray = array();
        foreach ($dags as $key => $value) {
            $cat = explode('@', $value);
            $insertArray[] = [
                'dag_no' =>  $cat[0],
                'uuid' =>  $uuid,
                'status' =>  'P',
                'created_at' => date('Y-m-d h:i:s'),
                'modified_at' => date('Y-m-d h:i:s'),
                'cat' => $cat[1]

            ];
        }
        $this->db->trans_begin();
        $this->db->insert_batch('area_dag_flag', $insertArray);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB0106: Insertion error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Partial Mapping Not Done, Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Partial Mapped Done Successfully']);
        }
    }


    /*** Location Form for CO *****/
    public function locationDetailsCO()
    {
        if ($this->session->userdata('user_desig_code') != "CO") {
            echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
        );

        $villages = $this->Dagflagmodel->getVillageCode($dist_code, $subdiv_code, $cir_code, 'P');
        foreach ($villages as $key => $value) {
            $locationrowData = $this->Dagflagmodel->getLocationFromUUID($value->uuid);
            $villages[$key]->mouza_name = $locationrowData->mouza_name;
            $villages[$key]->lot_no = $locationrowData->lot_no;
            $villages[$key]->lot_name = $locationrowData->lot_name;
            $villages[$key]->village_name = $locationrowData->village_name;
            $villages[$key]->vill_townprt_code = $locationrowData->vill_townprt_code;
        }

        //other flags
        $villagesDagFlag = $this->Dagflagmodel->getVillageCodeForOtherFlag($dist_code, $subdiv_code, $cir_code, 'P');
        foreach ($villagesDagFlag as $key => $value) {
            $locationrowData = $this->Dagflagmodel->getLocationFromUUID($value->uuid);
            $villagesDagFlag[$key]->mouza_name = $locationrowData->mouza_name;
            $villagesDagFlag[$key]->lot_no = $locationrowData->lot_no;
            $villagesDagFlag[$key]->lot_name = $locationrowData->lot_name;
            $villagesDagFlag[$key]->village_name = $locationrowData->village_name;
            $villagesDagFlag[$key]->vill_townprt_code = $locationrowData->vill_townprt_code;
        }



        $data['villages'] = $villages;
        $data['villagesDagFlag'] = $villagesDagFlag;
        $data['_view'] = 'Dagflag/select_location_for_co';
        $this->load->view('layouts/main', $data);
    }

    public function MappingIndex($value = '')
    {
        if ($this->session->userdata('user_desig_code') != "CO") {
            echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
            exit;
        }
        $data = array();
        $data['_view'] = 'Dagflag/MappingIndex';
        $this->load->view('layouts/main', $data);
    }

    //PARTIAL MAPPING===================
    public function viewMappingDetails()
    {
        if ($this->session->userdata('user_desig_code') != "CO") {
            echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $uuid = $this->input->get('no');
        $locationrowData = $this->Dagflagmodel->getLocationFromUUID($uuid);

        $mouza_pargona_code = $locationrowData->mouza_pargona_code;
        $lot_no = $locationrowData->lot_no;
        $vill_code = $locationrowData->vill_townprt_code;

        $data['vill_name'] = $vill_name = $locationrowData->village_name;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code,
            'uuid' => $uuid
        );
        $daginfo = $this->Dagflagmodel->getDagforMapping($uuid, 'P');
        $data['daginfo'] = $daginfo;

        $data['_view'] = 'Dagflag/select_location_for_co_view';
        $this->load->view('layouts/main', $data);
    }

    public function ApproveMapping()
    {
        $this->load->model('Dagflagmodel');
        $uuid = $this->input->post('uuid');
        $remarks = $this->input->post('remarks');
        $user_code = $this->input->post('user_code');

        if (($uuid == null || $uuid == '') && ($remarks == null || $remarks == '')) {
            log_message('error', '#ERMB01098: UUID or remarks not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Validation errors...']);
            return;
        }
        $this->load->model('chitha/ChithaModel');
        // $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking all data count=============
        $countCheckofDags = $this->Dagflagmodel->getInsertedCountOfVillage($uuid);
        $locationrowData  = $this->Dagflagmodel->getLocationFromUUID($uuid);

        $daginfo = $this->Dagflagmodel->getDagforMappingForApprove($uuid, 'P');

        $totalUpdatedCount = 0;
        $this->db->trans_begin();
        foreach ($daginfo as $key => $value) {
            $totalDagCount = count(explode(',', $value->dag_no));
            // $value->dag_no
            // $dags = str_replace(',', "','", $value->dag_no);
            // $dags = preg_replace("/\d+/", "'$0'", $value->dag_no);
            $dags = "'" . implode("','", explode(',', $value->dag_no)) . "'";

            // log_message('error',"ppp======".json_encode($dags));
            $statusChitha = $this->Dagflagmodel->updateChithaMapped($locationrowData->dist_code, $locationrowData->subdiv_code, $locationrowData->cir_code, $locationrowData->mouza_pargona_code, $locationrowData->lot_no, $locationrowData->vill_townprt_code, $dags, $value->cat);


            $statusJama = $this->Dagflagmodel->updateJamaMapped($locationrowData->dist_code, $locationrowData->subdiv_code, $locationrowData->cir_code, $locationrowData->mouza_pargona_code, $locationrowData->lot_no, $locationrowData->vill_townprt_code, $dags, $value->cat);
            // log_message('error',"COUNT===".json_encode($totalDagCount));


            $totalUpdatedCount += $statusChitha;
            if ($statusChitha != $totalDagCount) {

                log_message('error', '#ERMB01000: All dags not not updated Updation error in table name chitha basic======= DAG NO===' . $dags);
                $this->db->trans_rollback();
                echo json_encode(['status' => 'fail', 'msg' => 'Chitha : Approval Failed as some dags mis match, Try again']);

                return;
            }
            // if ($statusJama != $totalDagCount) {
            //     log_message('error', '#ERMB01002: All dags not not updated Updation error in table name Jama Dag======= DAG NO===' . $dags);
            //     $this->db->trans_rollback();
            //     echo json_encode(['status' => 'fail', 'msg' => 'JAMA : Approval Failed as some dags mis match, Try again']);

            //     return;
            // }
        }


        $data = array(
            'status' => 'A',
            'modified_at' => date("Y-m-d h:i:s"),
            'co_code' => $this->session->userdata('user_code'),
            'co_remark' => $remarks
        );

        $this->db->where('uuid', $uuid);
        $this->db->update('area_dag_flag', $data);

        //condition evaluates the completed updated in chitha or not==============
        if ($totalUpdatedCount != $countCheckofDags) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB01001: All dags not updated Updation error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Approval Failed as some dags mis match, Try again']);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB010689: Updation error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Approval Failed Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Approved Successfully']);
        }
    }

    public function approvedListMapping()
    {
        // if ($this->session->userdata('user_desig_code') != "LM") {
        //     echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
        //     exit;
        // }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
        );

        $villages = $this->Dagflagmodel->getVillageCode($dist_code, $subdiv_code, $cir_code, 'A');
        foreach ($villages as $key => $value) {
            $locationrowData = $this->Dagflagmodel->getLocationFromUUID($value->uuid);
            $villages[$key]->mouza_name = $locationrowData->mouza_name;
            $villages[$key]->lot_no = $locationrowData->lot_no;
            $villages[$key]->lot_name = $locationrowData->lot_name;
            $villages[$key]->village_name = $locationrowData->village_name;
            $villages[$key]->vill_townprt_code = $locationrowData->vill_townprt_code;
        }



        //other dag flag
        $villagesDagFlag = $this->Dagflagmodel->getVillageCodeForOtherFlag($dist_code, $subdiv_code, $cir_code, 'A');
        foreach ($villagesDagFlag as $key => $value) {
            $locationrowData = $this->Dagflagmodel->getLocationFromUUID($value->uuid);
            $villagesDagFlag[$key]->mouza_name = $locationrowData->mouza_name;
            $villagesDagFlag[$key]->lot_no = $locationrowData->lot_no;
            $villagesDagFlag[$key]->lot_name = $locationrowData->lot_name;
            $villagesDagFlag[$key]->village_name = $locationrowData->village_name;
            $villagesDagFlag[$key]->vill_townprt_code = $locationrowData->vill_townprt_code;
        }

        $data['villages'] = $villages;
        $data['villagesDagFlag'] = $villagesDagFlag;
        $data['_view'] = 'Dagflag/select_location_for_co_approved';
        $this->load->view('layouts/main', $data);
    }


    public function viewMappingApproved()
    {
        // if($this->session->userdata('user_desig_code') != "CO"){
        //     echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
        //     exit;
        // }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $uuid = $this->input->get('no');
        $locationrowData = $this->Dagflagmodel->getLocationFromUUID($uuid);

        $mouza_pargona_code = $locationrowData->mouza_pargona_code;
        $lot_no = $locationrowData->lot_no;
        $vill_code = $locationrowData->vill_townprt_code;

        $data['vill_name'] = $vill_name = $locationrowData->village_name;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code,
            'uuid' => $uuid
        );
        $daginfo = $this->Dagflagmodel->getDagforMapping($uuid, 'A');
        $data['daginfo'] = $daginfo;

        $data['_view'] = 'Dagflag/select_location_for_co_view_approved';
        $this->load->view('layouts/main', $data);
    }

    public function RevertMapping()
    {
        $this->load->model('Dagflagmodel');
        $uuid = $this->input->post('uuid');
        $remarks = $this->input->post('remarks');
        $user_code = $this->input->post('user_code');

        if (($uuid == null || $uuid == '') && ($remarks == null || $remarks == '')) {
            log_message('error', '#ERMB01098: UUID or remarks not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Validation errors...']);
            return;
        }
        $this->load->model('chitha/ChithaModel');
        // $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking all data count=============
        $countCheckofDags = $this->Dagflagmodel->getInsertedCountOfVillage($uuid);
        $locationrowData  = $this->Dagflagmodel->getLocationFromUUID($uuid);

        // $daginfo = $this->Dagflagmodel->getDagforMappingForApprove($uuid,'P');

        $totalUpdatedCount = 0;
        $this->db->trans_begin();


        $data = array(
            'status' => 'R',
            'modified_at' => date("Y-m-d h:i:s"),
            'co_code' => $this->session->userdata('user_code'),
            'co_remark' => $remarks
        );

        $this->db->where('uuid', $uuid);
        $this->db->update('area_dag_flag', $data);

        //condition evaluates the completed updated in chitha or not==============
        if ($this->db->affected_rows() != $countCheckofDags) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB01001: All dags not updated Updation error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Approval Failed as some dags mis match, Try again']);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB010689: Updation error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Approval Failed Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Mapping against Village ' . $locationrowData->village_name . ' Revert Successfully']);
        }
    }

    /*** Location Form for lm *****/
    public function RevertMappingVillages()
    {
        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code
        );


        $villages = $this->Dagflagmodel->getVillageCodeJSONRevert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagesZonal = $this->Dagflagmodel->getVillageCodeJSONRevertDagFlag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['remark'] = isset($villages[0]->co_remark) ? $villages[0]->co_remark : null;
        // $data['remarkZonal'] = isset($villagesZonal[0]->co_remark) ? $villagesZonal[0]->co_remark : null;
        $sql1 = "Select * from settlement_premium_area order by paid asc";
        $sql2 = "Select * from dag_flag_master order by flagid asc";
        $area = $this->db->query($sql1)->result();
        $flag = $this->db->query($sql2)->result();
        $data['area'] = $area;
        $data['flag'] = $flag;
        $data['villages'] = $villages;
        $data['villagesZonal'] = $villagesZonal;
        $data['_view'] = 'Dagflag/select_location_revert_villages';
        $this->load->view('layouts/main', $data);
    }

    public function updateFullMappingRevert()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_townprt_code');
        $areasel = $this->input->post('areasel');

        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);
        if ($areasel == null || $areasel == '') {
            log_message('error', '#ERMB010077: Mapping Category not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Mapping Category not found']);
            return;
        }
        $this->load->model('chitha/ChithaModel');

        $countCheckofDags = $this->Dagflagmodel->getInsertedCountOfVillage($uuid);
        $this->db->trans_begin();
        $data = array(
            'status'        => 'P',
            'modified_at'   => date("Y-m-d h:i:s"),
            'cat'           => $areasel
        );

        $this->db->where('uuid', $uuid);
        $this->db->update('area_dag_flag', $data);

        //condition evaluates the completed updated in chitha or not==============
        if ($this->db->affected_rows() != $countCheckofDags) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB010078: All dags not updated Updation error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Approval Failed as some dags mis match, Try again']);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB010079: Insertion error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Mapped Not Done, Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Mapped Successfully Again']);
        }
    }

    //PARTIAL MAPPING===================
    public function partialmappingRevert()
    {

        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $vill_code = $this->input->get('no');
        $data['vill_name'] = $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code
        );

        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $this->load->model('chitha/ChithaModel');

        $daginfo = $this->Dagflagmodel->getDagforMapping($uuid, 'R');

        $data['reject_remark'] = $daginfo[0]->co_remark;
        $data['daginfo'] = $daginfo;
        $sql1 = "Select * from settlement_premium_area order by paid asc";
        $area = $this->db->query($sql1)->result();
        $data['area'] = $area;
        $data['_view'] = 'Dagflag/select_location_for_lm_partial_revert';
        $this->load->view('layouts/main', $data);
    }

    public function partialMappingSubmitRevert()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $selectedDags = $this->input->post('selectedDags');
        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $dags = explode(',', $selectedDags);
        $insertArray = array();
        $this->db->trans_begin();
        foreach ($dags as $key => $value) {
            $cat = explode('@', $value);

            $updateData = array(
                'status'        => 'P',
                'modified_at'   => date("Y-m-d h:i:s"),
                'cat'           => $cat[1]
            );
            $Where = array(
                'dag_no' => $cat[0],
                'uuid' =>  $uuid
            );

            $this->db->where($Where);
            $this->db->update('area_dag_flag', $updateData);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB010656: Updation error in table name area_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Partial Mapping Not Done, Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Partial Mapped Done Successfully']);
        }
    }





    public function viewOtherFlaggingApprovedDagList()
    {
        // if ($this->session->userdata('user_desig_code') != "LM") {
        //     echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
        //     exit;
        // }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $uuid = $this->input->get('no');
        $locationrowData = $this->Dagflagmodel->getLocationFromUUID($uuid);

        $mouza_pargona_code = $locationrowData->mouza_pargona_code;
        $lot_no = $locationrowData->lot_no;
        $vill_code = $locationrowData->vill_townprt_code;

        $data['vill_name'] = $vill_name = $locationrowData->village_name;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code,
            'uuid' => $uuid
        );
        $daginfo = $this->Dagflagmodel->getDagListOtherFlag($uuid, 'A');
        $data['daginfo'] = $daginfo;

        $data['_view'] = 'Dagflag/approved_dag_list_other_flag_lm_view';
        $this->load->view('layouts/main', $data);
    }








    public function viewOtherDagFlaggingDetailsPendingCO()
    {
        if ($this->session->userdata('user_desig_code') != "CO") {
            echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $uuid = $this->input->get('no');
        $locationrowData = $this->Dagflagmodel->getLocationFromUUID($uuid);

        $mouza_pargona_code = $locationrowData->mouza_pargona_code;
        $lot_no = $locationrowData->lot_no;
        $vill_code = $locationrowData->vill_townprt_code;

        $data['vill_name'] = $vill_name = $locationrowData->village_name;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code,
            'uuid' => $uuid
        );
        $daginfo = $this->Dagflagmodel->getDagListOtherFlag($uuid, 'P');
        $data['daginfo'] = $daginfo;

        $data['_view'] = 'Dagflag/pending_dag_list_other_flag_co_view';
        $this->load->view('layouts/main', $data);
    }




    public function ApproveZonalDagFlaggingCO()
    {
        $this->load->model('Dagflagmodel');
        $uuid = $this->input->post('uuid');
        $remarks = $this->input->post('remarks');
        $user_code = $this->input->post('user_code');

        if (($uuid == null || $uuid == '') && ($remarks == null || $remarks == '')) {
            log_message('error', '#ERRAPP1000: UUID or remarks not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Validation errors...']);
            return;
        }
        $this->load->model('chitha/ChithaModel');
        // $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking all data count=============
        $countCheckofDags = $this->Dagflagmodel->getInsertedCountOfDagFlagVillage($uuid);

        $locationrowData  = $this->Dagflagmodel->getLocationFromUUID($uuid);

        $daginfo = $this->Dagflagmodel->getZonalDagforFlaggingForApprove($uuid, 'P');


        $totalUpdatedCount = 0;
        $this->db->trans_begin();
        foreach ($daginfo as $key => $value) {
            $totalDagCount = count(explode(',', $value->dag_no));
            // $value->dag_no
            // $dags = str_replace(',', "','", $value->dag_no);
            // $dags = preg_replace("/\d+/", "'$0'", $value->dag_no);
            $dags = "'" . implode("','", explode(',', $value->dag_no)) . "'";

            // log_message('error',"ppp======".json_encode($dags));
            $statusChitha = $this->Dagflagmodel->updateChithaZonalFlagged($locationrowData->dist_code, $locationrowData->subdiv_code, $locationrowData->cir_code, $locationrowData->mouza_pargona_code, $locationrowData->lot_no, $locationrowData->vill_townprt_code, $dags, $value->dag_flag);

            $statusJama = $this->Dagflagmodel->updateJamaZonalFlagged($locationrowData->dist_code, $locationrowData->subdiv_code, $locationrowData->cir_code, $locationrowData->mouza_pargona_code, $locationrowData->lot_no, $locationrowData->vill_townprt_code, $dags, $value->dag_flag);
            // log_message('error',"COUNT===".json_encode($totalDagCount));


            $totalUpdatedCount += $statusChitha;
            if ($statusChitha != $totalDagCount) {

                log_message('error', '#ERRAPP1001: All dags not not updated Updation error in table name chitha basic======= DAG NO===' . $dags);
                $this->db->trans_rollback();
                echo json_encode(['status' => 'fail', 'msg' => 'Chitha : Approval Failed as some dags mis match, Try again']);

                return;
            }
            // if ($statusJama != $totalDagCount) {
            //     log_message('error', '#ERRAPP1002: All dags not not updated Updation error in table name Jama Dag======= DAG NO===' . $dags);
            //     $this->db->trans_rollback();
            //     echo json_encode(['status' => 'fail', 'msg' => 'JAMA : Approval Failed as some dags mis match, Try again']);

            //     return;
            // }
        }

        $data = array(
            'status' => 'A',
            'modified_at' => date("Y-m-d h:i:s"),
            'co_code' => $this->session->userdata('user_code'),
            'co_remark' => $remarks
        );

        $this->db->where('uuid', $uuid);
        $this->db->where('dag_flag IS NOT NULL');
        $this->db->where('status', 'P');
        $this->db->where('rural_urban', NULL);
        $this->db->update('chitha_dag_flag', $data);

        //condition evaluates the completed updated in chitha or not==============
        if ($totalUpdatedCount != $countCheckofDags) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCDF001: All dags not updated Updation error in table name chitha_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Approval Failed as some dags mis match, Try again']);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCDF002: Updation error in table name chitha_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Dags Approval Failed Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Dags Approved Successfully']);
        }
    }


    public function RevertZonalDagFlaggingCO()
    {


        $this->load->model('Dagflagmodel');
        $uuid = $this->input->post('uuid');
        $remarks = $this->input->post('remarks');
        $user_code = $this->input->post('user_code');

        if (($uuid == null || $uuid == '') && ($remarks == null || $remarks == '')) {
            log_message('error', '#ERRREV1000: UUID or remarks not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Validation errors...']);
            return;
        }
        $this->load->model('chitha/ChithaModel');
        // $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking all data count=============
        $countCheckofDags = $this->Dagflagmodel->getInsertedCountOfDagFlagVillage($uuid);


        $locationrowData  = $this->Dagflagmodel->getLocationFromUUID($uuid);

        // $daginfo = $this->Dagflagmodel->getDagforMappingForApprove($uuid,'P');

        $totalUpdatedCount = 0;
        $this->db->trans_begin();


        $data = array(
            'status' => 'R',
            'modified_at' => date("Y-m-d h:i:s"),
            'co_code' => $this->session->userdata('user_code'),
            'co_remark' => $remarks
        );



        $this->db->where('uuid', $uuid);
        $this->db->where('dag_flag IS NOT NULL');
        $this->db->where('rural_urban', NULL);
        $this->db->where('status', 'P');
        $this->db->update('chitha_dag_flag', $data);



        //condition evaluates the completed updated in chitha or not==============
        if ($this->db->affected_rows() != $countCheckofDags) {
            $this->db->trans_rollback();
            log_message('error', '#ERRREV1001: All dags not updated Updation error in table name chitha_dag_flag======= UUID=='  . ($this->db->affected_rows()));
            echo json_encode(['status' => 'fail', 'msg' => 'Revert Failed as some dags mis match, Try again']);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRREV1002: Updation error in table name chitha_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Revert Failed Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Flagging against Village ' . $locationrowData->village_name . ' Revert Successfully']);
        }
    }


    public function updateFullFlaggingOtherFlag()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_townprt_code');
        $otherflagsel = $this->input->post('otherflagsel');
        $user_code = $this->session->userdata('user_code');

        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);
        if ($otherflagsel == null || $otherflagsel == '') {
            log_message('error', '#ERMB0106: Flagging Category not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Flagging Category not found']);
            return;
        }

        $daginfo = $this->Dagflagmodel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking for dag if partially Flagged=============
        $partiallyFlaggedDag = $this->Dagflagmodel->getInsertedDagCountOfVillageOtherFlag($uuid);
        $partiallyFlaggedDagList = $partiallyFlaggedDag->result();
        $countPartiallyFlaggedDag = $partiallyFlaggedDag->num_rows();

        if ($countPartiallyFlaggedDag > 0) {
            //backup already exist partially flagged Dags to chitha_dag_flag_backup
            $backupArray = array();
            foreach ($partiallyFlaggedDagList as $key => $value) {

                $backupArray[] = [
                    'dist_code' => $value->dist_code,
                    'subdiv_code' => $value->subdiv_code,
                    'cir_code' => $value->cir_code,
                    'mouza_pargona_code' => $value->mouza_pargona_code,
                    'lot_no' => $value->lot_no,
                    'vill_townprt_code' => $value->vill_townprt_code,
                    'dag_no' =>  $value->dag_no,
                    'uuid' =>  $value->uuid,
                    'status' =>  $value->status,
                    'lm_code' =>  $user_code,
                    'co_remark' =>  $value->co_remark,
                    'created_at' => $value->created_at,
                    'modified_at' => date('Y-m-d h:i:s'),
                    'dag_flag' => $value->dag_flag,
                ];
            }
            $this->db->trans_begin();
            $this->db->insert_batch('chitha_dag_flag_backup', $backupArray);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', '#ERRDAGBACKUP001: Insertion error in table name chitha_dag_flag_backup');
                echo json_encode(['status' => 'fail', 'msg' => 'Dag Flagging Failed. Kindly Contact System Administrator !!']);
            } else {
                $deletePartiallyFlaggedDag = $this->Dagflagmodel->deletePartialMappingDagOfVillageOtherFlag($uuid);
                if ($deletePartiallyFlaggedDag === FALSE) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRDAGDELETE001: Deletion error in table name chitha_dag_flag');
                    echo json_encode(['status' => 'fail', 'msg' => 'Dag Flagging Failed. Kindly Contact System Administrator !!']);
                } else {
                    $insertArray = array();
                    foreach ($daginfo as $key => $value) {
                        $insertArray[] = [
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $village_code,
                            'dag_no' =>  $value->dag_no,
                            'uuid' =>  $uuid,
                            'status' =>  'P',
                            'created_at' => date('Y-m-d h:i:s'),
                            'modified_at' => date('Y-m-d h:i:s'),
                            'dag_flag' => $otherflagsel,
                        ];
                    }
                    $this->db->insert_batch('chitha_dag_flag', $insertArray);
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRINSERTDAGFLAG001: Insertion error in table name chitha_dag_flag======= UUID==' . $uuid);
                        echo json_encode(['status' => 'fail', 'msg' => 'Full Flagging Not Done, Try again']);
                    } else {
                        $this->db->trans_commit();
                        echo json_encode(['status' => 'success', 'msg' => 'Full Flagging Done Successfully']);
                    }
                }
            }
            //if Partially Flagged Dag Not Exist in chitha_dag_flag
        } else {
            $insertArray = array();

            foreach ($daginfo as $key => $value) {

                $insertArray[] = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $village_code,
                    'dag_no' =>  $value->dag_no,
                    'uuid' =>  $uuid,
                    'status' =>  'P',
                    'created_at' => date('Y-m-d h:i:s'),
                    'modified_at' => date('Y-m-d h:i:s'),
                    'dag_flag' => $otherflagsel,
                ];
            }
            $this->db->trans_begin();
            $this->db->insert_batch('chitha_dag_flag', $insertArray);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', '#ERRINSERTDAG002: Insertion error in table name chitha_dag_flag======= UUID==' . $uuid);
                echo json_encode(['status' => 'fail', 'msg' => 'Full Flagging Not Done, Try again']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => 'success', 'msg' => 'Full Flagging Done Successfully']);
            }
        }
    }


    public function dagFlagCorrectionLM()
    {

        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_code = $this->input->get('no');
        $data['vill_name'] = $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_name' => $lot_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code
        );
        // echo $dist_code."-".$subdiv_code."-".$cir_code."-".$mouza_pargona_code."-".$lot_no."-".$vill_code;
        // die;
        $daginfo = $this->Dagflagmodel->getChithaDagsForFlaggingOtherFlag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $data['daginfo'] = $daginfo;
        $sql1 = "Select * from dag_flag_master where is_active ='A' order by flagid asc";
        $dagflags = $this->db->query($sql1)->result();
        $data['flags'] = $dagflags;


        $data['_view'] = 'Dagflag/dag_selection_for_flagging_lm.php';
        $this->load->view('layouts/main', $data);
    }

    public function dagFlaggingPartialSubmit()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $selectedDags = $this->input->post('selectedDags');
        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $dags = explode(',', $selectedDags);
        $insertArray = array();
        foreach ($dags as $key => $value) {
            $flag = explode('@', $value);
            $insertArray[] = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' =>  $flag[0],
                'uuid' =>  $uuid,
                'status' =>  'P',
                'created_at' => date('Y-m-d h:i:s'),
                'modified_at' => date('Y-m-d h:i:s'),
                'dag_flag' => $flag[1],

            ];
        }
        $this->db->trans_begin();
        $this->db->insert_batch('chitha_dag_flag', $insertArray);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERMB0106: Insertion error in table name chitha_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Dag Flagging Not Done, Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Dag Flagging Done Successfully']);
        }
    }



    public function partialFlaggingRevertLM()
    {

        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $this->load->model('chitha/ChithaModel');
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $vill_code = $this->input->get('no');
        $data['vill_name'] = $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'lot_no' => $lot_no,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_name' => $vill_name,
            'vill_code' => $vill_code
        );

        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $this->load->model('chitha/ChithaModel');

        $daginfo = $this->Dagflagmodel->getDagListOtherFlag($uuid, 'R');

        $data['reject_remark'] = $daginfo[0]->co_remark;
        $data['daginfo'] = $daginfo;

        $sql1 = "Select * from dag_flag_master order by flagid asc";
        $flag = $this->db->query($sql1)->result();
        $data['flag'] = $flag;
        $data['_view'] = 'Dagflag/dag_selection_for_flagging_lm_revert';
        $this->load->view('layouts/main', $data);
    }



    public function partialFlaggingSubmitRevertLM()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $selectedDags = $this->input->post('selectedDags');
        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $dags = explode(',', $selectedDags);
        $insertArray = array();
        $this->db->trans_begin();
        foreach ($dags as $key => $value) {
            $flag = explode('@', $value);

            $updateData = array(
                'status'        => 'P',
                'modified_at'   => date("Y-m-d h:i:s"),
                'dag_flag'           => $flag[1]
            );


            $Where = array(
                'dag_no' => $flag[0],
                'uuid' =>  $uuid,
                // 'dag_flag' => array('IS NOT NULL'),
                'rural_urban' => NULL
            );

            $this->db->where($Where);
            $this->db->update('chitha_dag_flag', $updateData);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRREUPDATELM001: Updation error in table name chitha_dag_flag======= UUID==' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Partial Flagging Not Done, Try again']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => 'Partial Flagging Done Successfully']);
        }
    }




    public function updateFullFlaggingRevertedOtherFlag()
    {
        $this->load->model('Dagflagmodel');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_townprt_code');
        $flagselrevert = $this->input->post('flagselrevert');
        $user_code = $this->session->userdata('user_code');

        $uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        if ($flagselrevert == null || $flagselrevert == '') {
            log_message('error', '#ERMB0106: Flagging Category not found UUID======= ' . $uuid);
            echo json_encode(['status' => 'fail', 'msg' => 'Flagging Category not found']);
            return;
        }

        $daginfo = $this->Dagflagmodel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $village_code);

        //checking for dag if partially Flagged=============
        $partiallyFlaggedDag = $this->Dagflagmodel->getInsertedDagCountOfVillageOtherFlag($uuid);
        $partiallyFlaggedDagList = $partiallyFlaggedDag->result();
        $countPartiallyFlaggedDag = $partiallyFlaggedDag->num_rows();


        if ($countPartiallyFlaggedDag > 0) {
            //backup already exist partially flagged Dags to chitha_dag_flag_backup
            $backupArray = array();
            foreach ($partiallyFlaggedDagList as $key => $value) {

                $backupArray[] = [
                    'dist_code' => $value->dist_code,
                    'subdiv_code' => $value->subdiv_code,
                    'cir_code' => $value->cir_code,
                    'mouza_pargona_code' => $value->mouza_pargona_code,
                    'lot_no' => $value->lot_no,
                    'vill_townprt_code' => $value->vill_townprt_code,
                    'dag_no' =>  $value->dag_no,
                    'uuid' =>  $value->uuid,
                    'status' =>  $value->status,
                    'lm_code' =>  $user_code,
                    'co_remark' =>  $value->co_remark,
                    'created_at' => $value->created_at,
                    'modified_at' => date('Y-m-d h:i:s'),
                    'dag_flag' => $value->dag_flag,
                ];
            }
            $this->db->trans_begin();
            $this->db->insert_batch('chitha_dag_flag_backup', $backupArray);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', '#ERRDAGBACKUPREV001: Insertion error in table name chitha_dag_flag_backup');
                echo json_encode(['status' => 'fail', 'msg' => 'Dag Flagging Failed. Kindly Contact System Administrator !!']);
            } else {
                $deletePartiallyFlaggedDag = $this->Dagflagmodel->deletePartialMappingDagOfVillageOtherFlag($uuid);
                if ($deletePartiallyFlaggedDag === FALSE) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRDAGDELETE001: Deletion error in table name chitha_dag_flag');
                    echo json_encode(['status' => 'fail', 'msg' => 'Dag Flagging Failed. Kindly Contact System Administrator !!']);
                } else {
                    $insertArray = array();
                    foreach ($daginfo as $key => $value) {
                        $insertArray[] = [
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $village_code,
                            'dag_no' =>  $value->dag_no,
                            'uuid' =>  $uuid,
                            'status' =>  'P',
                            'created_at' => date('Y-m-d h:i:s'),
                            'modified_at' => date('Y-m-d h:i:s'),
                            'dag_flag' => $flagselrevert,
                        ];
                    }
                    $this->db->insert_batch('chitha_dag_flag', $insertArray);
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRINSERTDAGFLAG001: Insertion error in table name chitha_dag_flag======= UUID==' . $uuid);
                        echo json_encode(['status' => 'fail', 'msg' => 'Full Flagging Not Done, Try again']);
                    } else {
                        $this->db->trans_commit();
                        echo json_encode(['status' => 'success', 'msg' => 'Full Flagging Done Successfully']);
                    }
                }
            }
            //if Partially Flagged Dag Not Exist in chitha_dag_flag
        } else {
            $insertArray = array();

            foreach ($daginfo as $key => $value) {

                $insertArray[] = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $village_code,
                    'dag_no' =>  $value->dag_no,
                    'uuid' =>  $uuid,
                    'status' =>  'P',
                    'created_at' => date('Y-m-d h:i:s'),
                    'modified_at' => date('Y-m-d h:i:s'),
                    'dag_flag' => $flagselrevert,
                ];
            }
            $this->db->trans_begin();
            $this->db->insert_batch('chitha_dag_flag', $insertArray);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', '#ERRINSERTDAG002: Insertion error in table name chitha_dag_flag======= UUID==' . $uuid);
                echo json_encode(['status' => 'fail', 'msg' => 'Full Flagging Not Done, Try again']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => 'success', 'msg' => 'Full Flagging Done Successfully']);
            }
        }
    }
}
