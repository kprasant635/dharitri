<?php

class PropChainReport extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('chitha/ChithaModel');
        $this->load->model('propChain/PropChainModel');
        $this->load->model('propChain/PropChainCommonModel','propCommon');
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        }
    }

    public function districtDetails()
    {
        $this->dbswitch();
        $counts['_view'] = 'propertyChain/report';
        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $counts['pattatype'] = $pattatype;
        $this->load->view('layouts/main', $counts);
    }

    public function getDags()
    {
        $dist_code = $this->input->post('dist_code', true);
        $subdiv_code = $this->input->post('subdiv_code', true);
        $circle_code = $this->input->post('circle_code', true);
        $mouza_code = $this->input->post('mouza_code', true);
        $lot_no = $this->input->post('lot_no', true);
        $vill_code = $this->input->post('vill_code', true);
        $patta_code = $this->input->post('patta_code', true);
        // print_r($this->input->post());
        // die;
        $this->load->model('chitha/ChithaModel');

        if ($patta_code == 0000) {
            $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        } else {
            $daginfo = $this->ChithaModel->getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_code);
        }

        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no);
        }
        echo json_encode($json);
    }

    public function getPropChainData()
    {
        $dist_code = $this->input->post('dist_code', true);
        $subdiv_code = $this->input->post('subdiv_code', true);
        $circle_code = $this->input->post('circle_code', true);
        $mouza_code = $this->input->post('mouza_code', true);
        $lot_no = $this->input->post('lot_no', true);
        $vill_code = $this->input->post('vill_code', true);
        $dagno = $this->input->post('dag_no', true);
        $ulpin = $this->input->post('ulpin', true);
        $patta_no = $this->input->post('patta_code', true);

        $user_code = $this->session->userdata('user_code');
        $office_code = $this->session->userdata('cir_code');

        // var_dump($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dagno, $patta_no);

        // $location_id = $dist_code . $subdiv_code . $circle_code . $mouza_code . $lot_no . $vill_code;
        // echo $location_id;

        if ($ulpin == 'N' || $ulpin == null) {
            // $ulpin = "";
            $getUlpin = $this->PropChainModel->checkGetUlpin($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $dagno);

            $ulpin = $getUlpin['ulpin'];
        }

        $fetch_data = $this->blockchainutilityclass->fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dagno, $patta_no, $user_code, $office_code, $ulpin);
        // var_dump($ulpin);

        // die;


        echo $fetch_data;
    }


    // public function generatePropertyChain()
    // {
    //     $property_id = $this->input->post('property_id', true);
    //     $property_data = $this->input->post('property_data', true);
    //     $transaction_data = $this->input->post('transaction_data', true);
    //     // $ulpin_flag = $this->input->post('ulpin_flag', true);

    //     // echo "<pre>";
    //     // var_dump($transaction_data);
    //     // die;
    //     $prop_data = json_decode($property_data);
    //     $dist_code = substr($prop_data->location, 0, 2);
    //     $subdiv_code = substr($prop_data->location, 2, 2);
    //     $circle_code = substr($prop_data->location, 4, 2);
    //     $mouza_code = substr($prop_data->location, 6, 2);
    //     $lot_no = substr($prop_data->location, 8, 2);
    //     $vill_code = substr($prop_data->location, 10, 5);


    //     $gis_code = $dist_code . "_" . $subdiv_code . "_" . $circle_code . "_" . $mouza_code . "_" . $lot_no . "_" . $vill_code;

    //     $chain_data['dist_name'] = $this->blockchainutilityclass->getDistrictName($dist_code);
    //     $chain_data['subdiv_name'] = $this->blockchainutilityclass->getSubDivName($dist_code, $subdiv_code);
    //     $chain_data['circile_name'] = $this->blockchainutilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
    //     $chain_data['mouza_name'] = $this->blockchainutilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
    //     $chain_data['lot_name'] = $this->blockchainutilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
    //     $chain_data['vill_name'] = $this->blockchainutilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

    //     $chain_data['location'] = $prop_data->location;
    //     $chain_data['dag_no'] = $prop_data->dagno;
    //     $chain_data['patta_no'] = $prop_data->pattano;
    //     // $chain_data['old_dag_no'] = $prop_data->olddagno;
    //     // $chain_data['old_patta_no'] = $prop_data->oldpattano;
    //     $chain_data['old_dag_no'] = '';
    //     $chain_data['old_patta_no'] = '';

    //     $chain_data['patta_type'] = $prop_data->pattatype;
    //     $chain_data['landclass'] = $prop_data->landclass;
    //     $chain_data['land_type'] = $this->PropChainModel->getLandType($prop_data->landclass);
    //     $chain_data['patta_type_name'] = $this->blockchainutilityclass->getPattaName($prop_data->pattatype);
    //     $chain_data['land_class_name'] = $this->blockchainutilityclass->getLandClassCode($prop_data->landclass);

    //     $chain_data['revenue'] = $prop_data->revenue;
    //     $chain_data['local_tax'] = $prop_data->localtax;
    //     $chain_data['bigha'] = $prop_data->bigha;
    //     $chain_data['katha'] = $prop_data->katha;
    //     $chain_data['lessa'] = $prop_data->lessa;

    //     $pattadar_data = array();
    //     foreach ($prop_data->pid as $pdar) {
    //         $nestedData['pdarid'] = $pdar->pdarid;
    //         $nestedData['pdarname'] = $pdar->pdarname;
    //         $nestedData['pdarfather'] = $pdar->pdarfather;
    //         $nestedData['striked_out'] = $pdar->pdarstrikeout;
    //         $pattadar_data[] = $nestedData;
    //     }

    //     // $property_id = "R-" . $vill_code . '-' . $prop_data->pattano . '-' . $prop_data->dagno . '-' . $prop_data->location;
    //     // $property_id = "R-" . $vill_code . '-' . $prop_data->pattano . '-' . $prop_data->dagno . '-' . $prop_data->location;

    //     $office_code = $this->session->userdata('cir_code');
    //     $user_code = $this->session->userdata('user_code');

    //     $trans_data = array();
    //     foreach ($transaction_data as $key => $trans) {
    //         $nestedData2['case_no'] = $key;
    //         $nestedData2['transaction_datetime'] = date('d-m-Y H:i:s', strtotime($trans['dateTime']));

    //         $certNemRefId = explode(':', $key);
    //         $certmnemonic = $certNemRefId[0];
    //         $refrenceId = $certNemRefId[1];

    //         if ($property_id == null || $property_id == "") {
    //             $property_id = $this->blockchainutilityclass->generatePropertyId("R", $vill_code, $prop_data->pattano, $prop_data->dagno, $prop_data->ulpin);
    //         }

    //         $nestedData2['certmnemonic'] = $certmnemonic;
    //         $nestedData2['stateMnemonic'] = $trans['stateMnemonic'];
    //         $nestedData2['deptMnemonic'] = $trans['deptMnemonic'];
    //         $nestedData2['data'] = $trans['data'];
    //         $nestedData2['transaction'] = $trans['transaction'];
    //         $btn = '';
    //         if ($certmnemonic == "MAP") {
    //             // $btn_id = $prop_data->pattano . $prop_data->dagno;
    //             $btn = '<button class="btn btn-sm btn-primary" id="view_trace_map" onclick="return getTraceMap();"><i class = "fa fa-map-marker"></i> View Map</button>';
    //         } else {
    //             $btn = '<a href="#!" id="view_trans_btn" property-id="' . $property_id . '" prop-data="' . $trans['data'] . '" certmnemonic="' . $certmnemonic . '" reference-id = "' . $refrenceId . '" office-code="' . $office_code . '" user-code="' . $user_code . '" class="btn btn-primary btn-sm float-left modal-show"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a>';
    //         }
    //         $nestedData2['view'] = $btn;
    //         $trans_data[] = $nestedData2;
    //     }

    //     function date_compare($element1, $element2)
    //     {
    //         $datetime1 = strtotime($element1['transaction_datetime']);
    //         $datetime2 = strtotime($element2['transaction_datetime']);
    //         return $datetime2 - $datetime1;
    //     }

    //     usort($trans_data, 'date_compare');

    //     // echo "<pre>";
    //     // var_dump($trans_data);
    //     // die;
    //     // edit for masked property id delete this code when property id is changed(start)
    //     $get_data = explode('-', $property_id);
    //     $ulpin = $get_data[4];
    //     $masked_id = $get_data[0] . '-' . $get_data[1] . '-' . '*******' . substr($ulpin, 7);
    //     $data['masked_property_id'] = $masked_id;
    //     // (end)
    //     $chain_data['pattadar_details'] = $pattadar_data;
    //     $chain_data['transaction_details'] = $trans_data;
    //     $data['location_data'] = $chain_data;
    //     $data['property_id'] = $property_id;
    //     $data['gis_code'] = $gis_code;
    //     // var_dump($data);
    //     $this->load->view('propertyChain/viewPropChain', $data);
    // }

    public function generatePropertyChain()
    {
        $property_id = $this->input->post('property_id', true);
        $property_data = $this->input->post('property_data', true);
        $transaction_data = $this->input->post('transaction_data', true);
        // $ulpin_flag = $this->input->post('ulpin_flag', true);

        // echo "<pre>";
        // var_dump($transaction_data);
        // die;
        $prop_data = json_decode($property_data);
        $dist_code = substr($prop_data->location, 0, 2);
        $subdiv_code = substr($prop_data->location, 2, 2);
        $circle_code = substr($prop_data->location, 4, 2);
        $mouza_code = substr($prop_data->location, 6, 2);
        $lot_no = substr($prop_data->location, 8, 2);
        $vill_code = substr($prop_data->location, 10, 5);


        $gis_code = $dist_code . "_" . $subdiv_code . "_" . $circle_code . "_" . $mouza_code . "_" . $lot_no . "_" . $vill_code;

        $chain_data['dist_name'] = $this->blockchainutilityclass->getDistrictName($dist_code);
        $chain_data['subdiv_name'] = $this->blockchainutilityclass->getSubDivName($dist_code, $subdiv_code);
        $chain_data['circile_name'] = $this->blockchainutilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $chain_data['mouza_name'] = $this->blockchainutilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $chain_data['lot_name'] = $this->blockchainutilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $chain_data['vill_name'] = $this->blockchainutilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $chain_data['location'] = $prop_data->location;
        $chain_data['dag_no'] = $prop_data->dagno;
        $chain_data['patta_no'] = $prop_data->pattano;
        // $chain_data['old_dag_no'] = $prop_data->olddagno;
        // $chain_data['old_patta_no'] = $prop_data->oldpattano;
        $chain_data['old_dag_no'] = '';
        $chain_data['old_patta_no'] = '';

        $chain_data['patta_type'] = $prop_data->pattatype;
        $chain_data['landclass'] = $prop_data->landclass;
        $chain_data['land_type'] = $this->PropChainModel->getLandType($prop_data->landclass);
        $chain_data['patta_type_name'] = $this->blockchainutilityclass->getPattaName($prop_data->pattatype);
        $chain_data['land_class_name'] = $this->blockchainutilityclass->getLandClassCode($prop_data->landclass);

        $chain_data['revenue'] = $prop_data->revenue;
        $chain_data['local_tax'] = $prop_data->localtax;
        $chain_data['bigha'] = $prop_data->bigha;
        $chain_data['katha'] = $prop_data->katha;
        $chain_data['lessa'] = $prop_data->lessa;

        $pattadar_data = array();
        foreach ($prop_data->pid as $pdar) {
            $nestedData['pdarid'] = $pdar->pdarid;
            $nestedData['pdarname'] = $pdar->pdarname;
            $nestedData['pdarfather'] = $pdar->pdarfather;
            $nestedData['striked_out'] = $pdar->pdarstrikeout;
            $pattadar_data[] = $nestedData;
        }

        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $trans_data = array();
        foreach ($transaction_data as $key => $trans) {
            $nestedData2['case_no'] = $key; //reference id
            $nestedData2['transaction_datetime'] = date('d-m-Y H:i:s', strtotime($trans['dateTime']));

            $certNemRefId = explode(':', $key);
            $certmnemonic = $certNemRefId[0];
            $refrenceId = $certNemRefId[1];

            if ($property_id == null || $property_id == "") {
                $property_id = $this->blockchainutilityclass->generatePropertyId("R", $vill_code, $prop_data->pattano, $prop_data->dagno, $prop_data->ulpin);
            }

            $nestedData2['certmnemonic'] = $certmnemonic;
            $nestedData2['stateMnemonic'] = $trans['stateMnemonic'];
            $nestedData2['deptMnemonic'] = $trans['deptMnemonic'];
            $nestedData2['data'] = $trans['data'];
            $nestedData2['transaction'] = $trans['transaction'];
            $btn = '';
            if ($certmnemonic == "MAP") {
                // $btn_id = $prop_data->pattano . $prop_data->dagno;
                $btn = '<button class="btn btn-sm btn-primary" id="view_trace_map" property-id="' . $property_id . '" trans-data="' . $trans['data'] . '" certmnemonic="' . $certmnemonic . '" reference-id = "' . $refrenceId . '" onclick="return getTraceMap();"><i class = "fa fa-map-marker"></i> View Map</button>';
            } else {
                $btn = '<a href="#!" id="view_trans_btn" property-id="' . $property_id . '" prop-data="' . $trans['data'] . '" certmnemonic="' . $certmnemonic . '" reference-id = "' . $refrenceId . '" office-code="' . $office_code . '" user-code="' . $user_code . '" class="btn btn-primary btn-sm float-left modal-show"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a>';
            }
            $nestedData2['view'] = $btn;
            $trans_data[] = $nestedData2;
        }

        function date_compare($element1, $element2)
        {
            $datetime1 = strtotime($element1['transaction_datetime']);
            $datetime2 = strtotime($element2['transaction_datetime']);
            return $datetime2 - $datetime1;
        }

        usort($trans_data, 'date_compare');

        // echo "<pre>";
        // var_dump($trans_data);
        // die;
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!edit for masked property id delete this code when property id is changed(start)!!!!!!!!!!!!!!!!!!!!!!!
        $get_data = explode('-', $property_id);
        $ulpin = $get_data[2];
        $masked_id = $get_data[0] . '-' . $get_data[1] . '-' . '*******' . substr($ulpin, 7);
        $data['masked_property_id'] = $masked_id;
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!(end)!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        $chain_data['pattadar_details'] = $pattadar_data;
        $chain_data['transaction_details'] = $trans_data;

        $data['location_data'] = $chain_data;
        $data['property_id'] = $property_id;
        $data['gis_code'] = $gis_code;

        // check old ulpin
        // var_dump($ulpin);

        $old_ulpin = $this->PropChainModel->checkOldUlpin($ulpin);

        // $old_ulpin = '11';
        if ($old_ulpin != null) {
            // if ($old_ulpin->ulpin == $ulpin) {
            $old_ulpin_btn = '<button id=' . $old_ulpin->dag_no . ' class="btn btn-primary" dist=' . $dist_code . ' subdiv=' . $subdiv_code . ' cir=' . $circle_code . ' mouza=' . $mouza_code . ' lot=' . $lot_no . ' ulpin=' . $old_ulpin->old_ulpin . ' vill=' . $vill_code . ' user-code=' . $user_code . '  office-code=' . $office_code . ' location-id=' . $prop_data->location . ' patta-type-code=' . $old_ulpin->patta_type_code . ' dag-no=' . $old_ulpin->dag_no . ' patta-no=' . $old_ulpin->patta_no . ' onclick="return showChainProperty(' . $old_ulpin->dag_no . ');"><i class ="fa fa-eye">View old Property</i></button>';
            // } else {
            //     $old_ulpin_btn = '<button id=' . $old_ulpin->dag_no . ' class="btn btn-primary" dist=' . $dist_code . ' subdiv=' . $subdiv_code . ' cir=' . $circle_code . ' mouza=' . $mouza_code . ' lot=' . $lot_no . ' ulpin=' . $old_ulpin->ulpin . ' vill=' . $vill_code . ' user-code=' . $user_code . '  office-code=' . $office_code . ' location-id=' . $prop_data->location . ' patta-type-code=' . $old_ulpin->patta_type_code . ' dag-no=' . $old_ulpin->dag_no . ' patta-no=' . $old_ulpin->patta_no . ' onclick="return showChainProperty(' . $old_ulpin->dag_no . ');"><i class ="fa fa-eye">View old Property</i></button>';
            // }


            $data['old_property_id'] = 'R-' . $vill_code . '-' . '*******' . substr($old_ulpin->new_ulpin, 7);

            $data['old_ulpin_btn'] = $old_ulpin_btn;

            // $old_ulpin_btn = '<button id=' . 450 . ' class="btn btn-info text-white" dist=' . $dist_code . ' subdiv=' . $subdiv_code . ' cir=' . $circle_code . ' mouza=' . $mouza_code . ' lot=' . $lot_no . ' ulpin=' . '848Y0KE5KVQ1H0' . ' vill=' . $vill_code . ' user-code=' . $user_code . '  office-code=' . $office_code . ' location-id=' . $prop_data->location . ' patta-type-code=' . 0201 . ' dag-no=' . 450 . ' patta-no=' . 256 . ' onclick="return showChainProperty(' . 450 . ');"><i class ="fa fa-eye">View old Property</i></button>';
            // $data['old_property_id'] = 'R-' . $vill_code . '-' . '*******' . substr($ulpin, 7);
        }
        // echo "<pre>";
        ////////////////////////////////////// for old property get the ror transaction data //////////////////////////////////////////////
        $old_property_flag = false;
        if ($trans_data['0']['certmnemonic'] == 'PRT' || $trans_data['0']['certmnemonic'] == 'ACPP') { // add (||)or condition for other certmnemonic where old property is applicable
            // search the array for ror transaction
            // get the area of the ror transaction 
            // show the area in the property chain chitha
            $old_property_flag = true;
            $array_size = sizeof($trans_data);
            $ror_data = $trans_data[$array_size - 1];
            // $trans_data['certmnemonic'];
            // $trans_data['data'];
            // $trans_data['transaction'];
            // $trans_data['case_no'];
            $get_ref_no = explode(':', $ror_data['case_no']);
            $ror_trans_data = $this->blockchainutilityclass->getPropTransData($office_code, $user_code, $property_id, $ror_data['data'],  $ror_data['certmnemonic'], $get_ref_no[1]);
            $ror_prop_data = json_decode($ror_trans_data->property_data);
            $ror_bigha = $ror_prop_data->bigha;
            $ror_katha = $ror_prop_data->katha;
            $ror_lessa = $ror_prop_data->lessa;
            $ror_ganda = $ror_prop_data->ganda;

            $ror_area = array(
                'bigha' => $ror_bigha,
                'katha' => $ror_katha,
                'lessa' => $ror_lessa,
                'ganda' => $ror_ganda
            );

            $data['ror_area'] = $ror_area;
            // echo "<pre>";
            // var_dump($ror_area);
            // die;
        }
        $data['old_property_flag'] = $old_property_flag;

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->load->view('propertyChain/viewPropChain', $data);
    }

    public function getCaseData()
    {
        $case_no = $this->input->post('case_no');
        $vill_code = $this->input->post('vill_code');
        // $mut_type = $this->input->post('mut_type');

        $get_mut_type = explode('/', $case_no);
        $mut_type = $get_mut_type[4];
        /////////////////////////////////////////////////////////////////////////////////////// 
        if ($mut_type == 'RECLASS') {
            // reclassification
            $mut_case_data = $this->PropChainModel->getMutCaseDataRec($case_no, $vill_code);
        } elseif ($mut_type == 'OMUT' || $mut_type == 'OPART'  || $mut_type == 'CONV-BL' || $mut_type == 'OMUTC' || $mut_type == 'OPARTC' || $mut_type == 'OMUT-BL') {
            // office mutation and partition and backlog conversion
            $mut_case_data = $this->PropChainModel->getMutCaseDataOfc($case_no, $vill_code);
        } elseif ($mut_type == 'MiNC' || $mut_type == 'MiND') {
            // miscelleneous cases like name correction and cancellation
            $mut_case_data = $this->PropChainModel->getMutCaseDataMisc($case_no, $vill_code);
        } elseif ($mut_type == 'CONV') {
            // conversion cases
            $mut_case_data = $this->PropChainModel->getCaseDataConv($case_no, $vill_code);
        } elseif ($mut_type == 'ACPP' || $mut_type == 'STPP') {
            // ac to pp cases
            $mut_case_data = $this->PropChainModel->getCaseDataACPP($case_no, $vill_code);
        } elseif ($mut_type == 'LDU') {
            $mut_case_data = $this->PropChainModel->getLegacyCaseData($case_no);
        } elseif ($mut_type == 'FPART-BL') {
            // backlog field partition
            $mut_case_data = $this->PropChainModel->getCaseDataFpartBL($case_no);
        } elseif ($mut_type == 'OPART-BL') {
            // backlog office partition
            $mut_case_data = $this->PropChainModel->getCaseDataOpartBL($case_no);
        } elseif ($mut_type == 'NR') {
            // ap cancellation
            $mut_case_data = $this->PropChainModel->getApCancelCaseData($case_no);
        } else {
            // field partion, mutation, backlog field mutation 
            $mut_case_data = $this->PropChainModel->getMutCaseData($case_no, $vill_code);
        }

        $dag_no = $mut_case_data->dag_no;
        $patta_type_code = $mut_case_data->patta_type_code;
        $patta_no = $mut_case_data->patta_no;
        if ($mut_type == 'STPP') {
            if ($patta_type_code == null)
                $patta_type_code = '0209';

            if ($patta_no == null)
                $patta_no = '0';
        }



        $data = array(
            'dag_no' => $dag_no,
            'patta_type_code' => $patta_type_code,
            'patta_no' => $patta_no
        );

        echo json_encode($data);
    }

    public function getPropTransData()
    {
        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->input->post('user_code', true);
        $propertyId = $this->input->post('propertyId', true);
        $prop_data = $this->input->post('prop_data', true);
        $certmnemonic = $this->input->post('certmnemonic', true);
        $referenceId = $this->input->post('referenceId', true);

        if ($certmnemonic == 'SD') {
            // sale deed
            $data = $this->PropChainModel->getPropTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);
        } else {
            $get_mut_type = explode('/', $referenceId);
            $mut_type = $get_mut_type[4];

            if ($mut_type == 'FMUT' || $mut_type == 'FPART') {
                $data = $this->PropChainModel->getFieldMutPartTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);
            } elseif ($mut_type == 'OMUT' || $mut_type == 'OPART' || $mut_type == 'OMUTC') {
                $data = $this->PropChainModel->getOfficeMutPartTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);
            } else {
                $data = $this->PropChainModel->getPropTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);
            }
        }

        $this->load->view('propertyChain/viewTransReport', $data);
    }


    function createChainData()
    {
        // var_dump($this->input->post());
        // die;
        $this->PropChainModel->createChainData();
    }

    public function updateMapData()
    {
        $this->PropChainModel->updateMapData();
    }


    public function updateChainMap()
    {
        $property_data = json_decode(base64_decode($this->input->post('property_data')));
        // $property_id = $this->input->post('property_id');
        $prop_sign = $this->input->post('prop_sign');
        $prop_sign_key = $this->input->post('prop_sign_key');
        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $result = $this->blockchainutilityclass->chainUpdateMap($property_data, $prop_sign, $prop_sign_key, $office_code, $user_code);

        if ($result->success == 1) {
            $dist_code = substr($property_data->location, 0, 2);
            $subdiv_code = substr($property_data->location, 2, 2);
            $circle_code = substr($property_data->location, 4, 2);
            $mouza_code = substr($property_data->location, 6, 2);
            $lot_no = substr($property_data->location, 8, 2);
            $vill_code = substr($property_data->location, 10, 5);
            $ulpin = $result->ulpin;
            $dag = $property_data->dagno;
            $patta = $property_data->pattano;
            $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);
            ///////////////// insert into trasaction table/////////////////////////////////////////

            $this->PropChainModel->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $property_id, $result->transaction_id, CERTMNEMONIC_MAP, $ulpin, $user_code, $ulpin);
        }

        echo json_encode($result);
    }

    // function getTraceMap()
    // {
    //     $gis_code = $this->input->post('gis_code');
    //     $plot_no = $this->input->post('plot_no');
    //     $user_code = $this->session->userdata('user_code');

    //     $get_trace_map = $this->blockchainutilityclass->fetchTraceMap($gis_code, $plot_no);


    //     if ($get_trace_map != '') {
    //         if (!is_dir('./assets/trace_map/')) {
    //             mkdir('./assets/trace_map/', '0777', true);
    //         }
    //         $decoded_pdf = base64_decode($get_trace_map);
    //         $filename = $user_code . "testPdf.pdf";
    //         $path = './assets/trace_map/';
    //         $fullPath = $path . $filename;

    //         file_put_contents($fullPath, $decoded_pdf);
    //         // echo "abc";
    //         // $decoded_pdf = base64_decode($get_trace_map);
    //         // $pdf = fopen(base_url() . 'trace_map/test.pdf', 'w');
    //         // fwrite($pdf, $decoded_pdf);
    //         // fclose($pdf);
    //         $data = array('status' => 1, 'msg' => 'Map fetched successfully', 'url' => 'assets/trace_map/' . $user_code . 'testPdf.pdf');
    //         echo json_encode($data);
    //     } else {
    //         // echo "ef";
    //         $data = array('status' => 0, 'msg' => 'Map Not found');
    //         echo json_encode($data);
    //     }
    // }


    public function getTraceMap()
    {
        $gis_code = $this->input->post('gis_code');
        $plot_no = $this->input->post('plot_no');

        $property_id = $this->input->post('property_id', true);
        $trans_data = $this->input->post('trans_data', true);
        $certmnemonic = $this->input->post('certmnemonic', true);
        $reference_id = $this->input->post('reference_id', true);

        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        // echo "<pre>";

        $getMapTrans = $this->PropChainModel->getPropTrans($office_code, $user_code, $property_id, $trans_data, $certmnemonic, $reference_id);
        $property_data = $getMapTrans['trans_data'];
        $getGeoJsonPc = json_decode($property_data->mapcord->coordinates, true);

        $check_geo_json = array_search("type", array_keys($getGeoJsonPc), true);
        // var_dump($check_geo_json);
        // die;
        $state_code = ASSAM_STATE_CODE;
        if ($check_geo_json !== false) {
            $getGeoJson = (object)$getGeoJsonPc;
            $mapflag = true;
            // echo "def";
        } else {
            $getGeoJson = json_decode($this->blockchainutilityclass->getGeoJsonAPI($state_code, $gis_code, $plot_no));
            $mapflag = false;
            // echo "abc";
        }

        // var_dump($mapflag);
        // die;
        if (!empty($getGeoJson->features)) {
            $data = array('status' => 1, 'msg' => 'Map found. You will be redirected to Bhunaksha site', 'data' => $getGeoJson, 'state' => $state_code);
            echo json_encode($data);
        } elseif (empty($getGeoJson->features)) {
            $data = array('status' => 0, 'msg' => 'Map Not found');
            echo json_encode($data);
        } else {
            $data = array('status' => 0, 'msg' => 'Unable to connect to API');
            echo json_encode($data);
        }
    }

    public function mismatchCases($mutation_type)
    {
        $getMismatchCases = $this->PropChainModel->getMismatchCases($mutation_type);
        if ($mutation_type == '01') {
            $mutation_name = 'Field Mutation';
        } elseif ($mutation_type == '02') {
            $mutation_name = 'Field Partition';
        }
        $data['mutation_name'] = $mutation_name;
        $data['mismatchCases'] = $getMismatchCases;
        $data['_view'] = 'propertyChain/misMatchCases';
        $this->load->view('layouts/main', $data);
    }

    public function viewMismatchCase()
    {
        $this->dbswitch();
        $case_no = $this->input->get('case_no', true);
        $dist_code = $this->input->get('dist_code', true);
        $subdiv_code = $this->input->get('subdiv_code', true);
        $cir_code = $this->input->get('cir_code', true);
        $mouza_pargona_code = $this->input->get('mouza_pargona_code', true);
        $lot_no = $this->input->get('lot_no', true);
        $vill_townprt_code = $this->input->get('vill_townprt_code', true);
        $patta_no = $this->input->get('patta_no', true);
        $dag_no = $this->input->get('dag_no', true);
        $dag_area_b = $this->input->get('dag_area_b', true);
        $dag_area_k = $this->input->get('dag_area_k', true);
        $dag_area_lc = $this->input->get('dag_area_lc', true);
        $dag_area_g = $this->input->get('dag_area_g', true);
        $patta_type_code = $this->input->get('patta_type_code', true);
        // echo "<pre>";



        $get_mut_type = explode('/', $case_no);
        $mut_type = $get_mut_type[4];

        $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and dag_no='$dag_no'";


        $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;
        // var_dump($patta_type_code);
        // die;
        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        $chitha_pattadars = array();
        foreach ($pattadar_details as $pattadar_detail) {
            $nestedData = array(
                'pdarid' => $pattadar_detail->pdar_id,
                'pdarname' => $pattadar_detail->pdar_name,
                'pdarfather' => $pattadar_detail->pdar_father,
                'pdarstrikeout' => $pattadar_detail->p_flag
            );
            $chitha_pattadars[] = $nestedData;
        }


        $data['case_no'] = $case_no;
        $data['chitha_data'] = array(
            'dag_no' => $dag_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'landclass_code' => $land_class_code,
            'bigha' => $dag_area_b,
            'katha' => $dag_area_k,
            'lessa' => $dag_area_lc,
            'ganda' => $dag_area_g,
            'pattadars' => $chitha_pattadars
        );


        /////////////////////////////////////////////////////Property chain data//////////////////////////////////////////////////////////
        $user_code = $this->session->userdata('user_code');
        $office_code = $this->session->userdata('cir_code');
        $property_chain_status = null;


        $get_ulpin = $this->PropChainModel->getUlpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);
        // var_dump($get_ulpin);exit;

        $ulpin = $get_ulpin->ulpin;

        $chain_data_encoded = $this->blockchainutilityclass->fetchPropChainData($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $patta_no, $user_code, $office_code, $ulpin);

        $chain_data = json_decode($chain_data_encoded);
        

        $property_chain_status = $chain_data->result;

        $data['property_chain_status'] = $property_chain_status;
        $data['property_id'] = $chain_data->property_id;

        $chain_property_data = json_decode($chain_data->property_data);
        $data['location_no'] = $chain_property_data->location;

        $data['chain_data'] = array(
            'dag_no' => $chain_property_data->dagno,
            'patta_no' => $chain_property_data->pattano,
            'patta_type_code' => $chain_property_data->pattatype,
            'landclass_code' => $chain_property_data->landclass,
            'bigha' => $chain_property_data->bigha,
            'katha' => $chain_property_data->katha,
            'lessa' => $chain_property_data->lessa,
            'pattadars' => $chain_property_data->pid
        );

        $data['error_span'] = '<i class="fa fa-close text-danger"></i>';

        $data['_view'] = 'propertyChain/viewMismatchCase';
        $this->load->view('layouts/main', $data);
    }

    private function mismatchFmFP($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code)
    {
        /////////////////////////////////////////////////////////Chitha data///////////////////////////////////////////////////////////
        $dag_query = "select dag_no, patta_no,patta_type_code, m_dag_area_b, m_dag_area_k, m_dag_area_lc, m_dag_area_g, m_dag_area_kr, dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr from  field_mut_dag_details where case_no='$case_no' ";

        $dag_details = $this->db->query($dag_query)->row();
        $bigha_chain_source = $dag_details->dag_area_b;
        $katha_chain_source = $dag_details->dag_area_k;
        $lessa_chain_source = $dag_details->dag_area_lc;
        $ganda_chain_source = $dag_details->dag_area_g;


        $dag_no = $dag_details->dag_no;
        $patta_no = $dag_details->patta_no;

        $patta_type_code = $dag_details->patta_type_code;
    }

    private function mismatchReclass($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code)
    {
        $dag_query = "select dag_no, patta_no,patta_type_code, m_dag_area_b, m_dag_area_k, m_dag_area_lc, m_dag_area_g, m_dag_area_kr, dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr from  t_reclassification where case_no='$case_no' ";
    }

    public function userChainTransactions()
    {
        $data['_view'] = 'propertyChain/userChainTransactions';
        $this->load->view('layouts/main', $data);
    }

    public function getUserChainTransactions()
    {
        $user_code = $this->session->userdata('user_code');
        $userTransactions = $this->PropChainModel->getUserChainTransactions($user_code);
        $office_code = $this->session->userdata('cir_code');
        // echo "<pre>";
        // var_dump($userTransactions);
        // die;

        $data = array();
        foreach ($userTransactions as $transaction) {
            $location_id = $transaction->dist_code . $transaction->subdiv_code . $transaction->cir_code . $transaction->mouza_pargona_code . $transaction->lot_no . $transaction->vill_townprt_code;
            $patta_type_code = $transaction->patta_type_code;
            $dag_no = $transaction->dag_no;
            $patta_no = $transaction->patta_no;
            $nestedData['reference_id'] = $transaction->reference_id;
            // edit to show only ulpin in property id. delete this code when property id is changed(start)
            $ulpin = $transaction->ulpin;
            $masked_ulpin = '*******' . substr($ulpin, 7);
            $nestedData['property_id'] = 'R-' . $transaction->vill_townprt_code . '-' . $masked_ulpin;
            //end

            // $nestedData['property_id'] = $transaction->property_id;
            $nestedData['datetime'] = date('d-m-Y H:i:s', strtotime($transaction->datetime));

            $mouza_name = $this->blockchainutilityclass->getMouzaName($transaction->dist_code, $transaction->subdiv_code, $transaction->cir_code, $transaction->mouza_pargona_code);
            $lot = $this->blockchainutilityclass->getLotName($transaction->dist_code, $transaction->subdiv_code, $transaction->cir_code, $transaction->mouza_pargona_code, $transaction->lot_no);
            $village_name = $this->blockchainutilityclass->getVillageName($transaction->dist_code, $transaction->subdiv_code, $transaction->cir_code, $transaction->mouza_pargona_code, $transaction->lot_no, $transaction->vill_townprt_code);

            if ($transaction->ulpin != null)
                $ulpin = $transaction->ulpin;
            else
                $ulpin = "N";

            $location = "Mouza: " . $mouza_name . "<br>Lot: " . $lot . "<br>Village: " . $village_name;

            $nestedData['location'] = $location;
            $nestedData['dag'] = $dag_no;
            $button_id = $transaction->slno . $dag_no;
            $btns = '<button id=' . $button_id . ' class="btn btn-primary" dist=' . $transaction->dist_code . ' subdiv=' . $transaction->subdiv_code . ' cir=' . $transaction->cir_code . ' mouza=' . $transaction->mouza_pargona_code . ' lot=' . $transaction->lot_no . ' ulpin=' . $ulpin . ' vill=' . $transaction->vill_townprt_code . ' user-code=' . $user_code . '  office-code=' . $office_code . ' location-id=' . $location_id . ' patta-type-code=' . $patta_type_code . ' dag-no=' . $dag_no . ' patta-no=' . $patta_no . ' onclick="return showChainProperty(' . $button_id . ');"><i class ="fa fa-eye">View Property</i></button>';
            $nestedData['btns'] = $btns;
            $data[] = $nestedData;
        }
        function date_compare1($element1, $element2)
        {
            $datetime1 = strtotime($element1['datetime']);
            $datetime2 = strtotime($element2['datetime']);
            return $datetime2 - $datetime1;
        }
        usort($data, 'date_compare1');

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    public function pendingAssets()
    {
        // echo "<pre>";
        // var_dump($this->session->all_userdata());
        // echo date('Y-m-d');
		$this->PropChainModel->check_n_update_map_flag();
        $data['_view'] = 'propertyChain/pendingAssets';
        $this->load->view('layouts/main', $data);
    }

    // public function getPendingAssets()
    // {
    //     $getAssets = $this->PropChainModel->getPndngAssetCrtnDags();
    //     $user_desig_code = $this->session->userdata('user_desig_code');
    //     $nocuser = $this->session->userdata('nocuser');
    //     $user_name = $this->PropChainModel->getUserName($nocuser);

    //     if (isset($_SERVER['HTTP_CLIENT_IP']))
    //         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    //     else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    //         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //     else if (isset($_SERVER['HTTP_X_FORWARDED']))
    //         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    //     else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
    //         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    //     else if (isset($_SERVER['HTTP_FORWARDED']))
    //         $ipaddress = $_SERVER['HTTP_FORWARDED'];
    //     else if (isset($this->utilityclass->get_client_ip()))
    //         $ipaddress = $this->utilityclass->get_client_ip();

    //     $data = array();
    //     foreach ($getAssets as $asset) {
    //         $mouza_name = $this->blockchainutilityclass->getMouzaName($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code);
    //         $lot = $this->blockchainutilityclass->getLotName($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no);
    //         $village_name = $this->blockchainutilityclass->getVillageName($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no, $asset->vill_townprt_code);
    //         $case_no = $asset->case_no;

    //         $location = "Mouza: " . $mouza_name . "<br>Lot: " . $lot . "<br>Village: " . $village_name;

    //         $partition_area = $asset->p_dag_area_b . '-' . $asset->p_dag_area_k . '-' . $asset->p_dag_area_lc;

    //         $dag_no = $asset->dag_no;
    //         $old_dag_no = $asset->old_dag_no;
    //         if ($asset->map_for_property == 'N') {
    //             $map_status = '<span class="text-danger">No</span>';
    //             $btns = '<button class="btn btn-info text-white create_prop_btn" disabled title="Map Not Generated">&nbsp;Create Property Chain for Dag ' . $dag_no . '</button>';
    //         } elseif ($asset->map_for_property == 'Y') {
    //             $map_status = '<span class="text-success">Yes</span>';
    //             $btns = $this->PropChainModel->getPropCreateBtn($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no, $asset->vill_townprt_code, $asset->dag_no, $asset->patta_no, $asset->patta_type_code, $asset->p_dag_area_b, $asset->p_dag_area_k, $asset->p_dag_area_lc, $asset->p_dag_area_g, $asset->dag_revenue, $asset->dag_local_tax);
    //         }

    //         // redirect to bhunaksha map partition btn
    //         if ($user_desig_code == 'LM') {
    //             $gis_code = $this->blockchainutilityclass->generateGisCode($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no, $asset->vill_townprt_code);


    //             $split_data = array(
    //                 "sub" => "splittoken",
    //                 "userName" => $user_name,
    //                 "levels" => $asset->dist_code . ',' . $asset->subdiv_code,
    //                 "clientIp" => $ipaddress,
    //                 "userGroup" => 'M',
    //                 "gisCode" => $gis_code,
    //                 "plotNo" => $old_dag_no,
    //                 "mutationNo" =>  $case_no,
    //                 "mutationDate" => date('d/m/Y', strtotime($asset->mut_date)),
    //                 "newPlotNo" => $dag_no
    //             );

    //             $encode_split_data = base64_encode(json_encode($split_data));
    //             $split_btn = '<a href="' . base_url() . '/index.php/PropChainReport/bhun_split?data=' . $encode_split_data . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary text-white create_prop_btn"  title="Redirect to bhunaksha map split">&nbsp;Map split for Dag ' . $dag_no . '</a>';

    //             $nestedData['split_btn'] = $split_btn;
    //         }

    //         $old_ulpin = $asset->old_ulpin;
    //         $nestedData['case_no'] = $case_no;
    //         $nestedData['partition_area'] = $partition_area;
    //         $nestedData['location'] = $location;
    //         $nestedData['dag'] = $dag_no;
    //         $nestedData['old_dag'] = $old_dag_no;
    //         $nestedData['map_status'] = $map_status;
    //         $nestedData['old_ulpin'] = $old_ulpin;
    //         $nestedData['btns'] = $btns;

    //         $data[] = $nestedData;
    //     }

    //     // echo "<pre>";
    //     // var_dump($data);
    //     // die;

    //     $json_data = array('data' => $data);

    //     echo json_encode($json_data);
    // }

    public function getPendingAssets()
    {
        $getAssets = $this->PropChainModel->getPndngAssetCrtnDags();
        $user_desig_code = $this->session->userdata('user_desig_code');
        $nocuser = $this->session->userdata('nocuser');
        $user_name = $this->PropChainModel->getUserName($nocuser);

        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($this->utilityclass->get_client_ip()))
            $ipaddress = $this->utilityclass->get_client_ip();

        $data = array();
        foreach ($getAssets as $asset) {
            $mouza_name = $this->blockchainutilityclass->getMouzaName($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code);
            $lot = $this->blockchainutilityclass->getLotName($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no);
            $village_name = $this->blockchainutilityclass->getVillageName($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no, $asset->vill_townprt_code);
            $case_no = $asset->case_no;

            $location = "Mouza: " . $mouza_name . "<br>Lot: " . $lot . "<br>Village: " . $village_name;

            $partition_area = $asset->p_dag_area_b . '-' . $asset->p_dag_area_k . '-' . $asset->p_dag_area_lc;
            $old_ulpin = $asset->old_ulpin;

            $dag_no = $asset->dag_no;
            $old_dag_no = $asset->old_dag_no;
            if ($asset->map_for_property == 'N') {
                $map_status = '<span class="text-danger">No</span>';
                $btns = '<button class="btn btn-info text-white create_prop_btn" disabled title="Map Not Generated">&nbsp;Generate Chitha for Dag ' . $dag_no . '</button>';
            } elseif ($asset->map_for_property == 'Y') {
                $map_status = '<span class="text-success">Yes</span>';
                $bhun = 'Y';
                // $btns = $this->PropChainModel->getPropCreateBtn($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no, $asset->vill_townprt_code, $asset->dag_no, $asset->patta_no, $asset->patta_type_code, $asset->p_dag_area_b, $asset->p_dag_area_k, $asset->p_dag_area_lc, $asset->p_dag_area_g, $asset->dag_revenue, $asset->dag_local_tax, $bhun);
                // $btns = '<button id=' . $asset->vill_townprt_code . $dag_no . ' class="btn btn-info text-white create_prop_btn" dist_code=' . $asset->dist_code . ' subdiv_code=' . $asset->subdiv_code . ' cir_code=' . $asset->cir_code . ' mouza_code=' . $asset->mouza_pargona_code . ' lot_no=' . $asset->lot_no . ' vill_code=' . $asset->vill_townprt_code . ' patta_type_code=' . $asset->patta_type_code . ' dag_no=' . $asset->dag_no . ' title="Goto Chitha to generate" onclick="return generateChitha(' . $asset->vill_townprt_code . $dag_no . ')">&nbsp;Generate Chitha for Dag ' . $dag_no . '</button>';
                $dagint =  $asset->dag_no . '00';
                $btns = '<a class="btn btn-info text-white" href=' . base_url("index.php/chithareport/generateChitha?&chitha_dist_code=" . $asset->dist_code . "&chitha_subdiv_code=" . $asset->subdiv_code . "&chitha_cir_code=" . $asset->cir_code . "&chitha_mouza_pargona_code=" . $asset->mouza_pargona_code . "&chitha_lot_no=" . $asset->lot_no . "&chitha_vill_code=" . $asset->vill_townprt_code . "&patta_code=" . $asset->patta_type_code . "&old_dag_no=" . $old_dag_no . "&dag_no_lower=" . $dagint . "&dag_no_upper=" . $dagint . "&caseno=" . $case_no . "") . '>&nbsp;Generate Chitha for Dag ' . $dag_no . '</a>';
            }

            // redirect to bhunaksha map partition btn
            if ($user_desig_code == 'LM') {
                $gis_code = $this->blockchainutilityclass->generateGisCode($asset->dist_code, $asset->subdiv_code, $asset->cir_code, $asset->mouza_pargona_code, $asset->lot_no, $asset->vill_townprt_code);


                $split_data = array(
                    "sub" => "splittoken",
                    "userName" => $user_name,
                    "levels" => $asset->dist_code . ',' . $asset->subdiv_code,
                    "clientIp" => $ipaddress,
                    "userGroup" => 'M',
                    "gisCode" => $gis_code,
                    "plotNo" => $old_dag_no,
                    "mutationNo" =>  $case_no,
                    "mutationDate" => date('d/m/Y', strtotime($asset->mut_date)),
                    "newPlotNo" => $dag_no,
                    "old_ulpin" => $old_ulpin
                );

                $encode_split_data = base64_encode(json_encode($split_data));
                $split_btn = '<a href="' . base_url() . '/index.php/PropChainReport/bhun_split?data=' . $encode_split_data . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary text-white create_prop_btn"  title="Redirect to bhunaksha map split">&nbsp;Map split for Dag ' . $dag_no . '</a>';

                $nestedData['split_btn'] = $split_btn;
            }

            $nestedData['case_no'] = $case_no;
            $nestedData['partition_area'] = $partition_area;
            $nestedData['location'] = $location;
            $nestedData['dag'] = $dag_no;
            $nestedData['old_dag'] = $old_dag_no;
            $nestedData['map_status'] = $map_status;
            $nestedData['old_ulpin'] = $old_ulpin;
            $nestedData['btns'] = $btns;

            $data[] = $nestedData;
        }

        // echo "<pre>";
        // var_dump($data);
        // die;

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    public function test()
    {

        $geoJson = $this->input->post('mapData');
        $state = $this->input->post('state');

        $data['geoJson'] = json_encode($geoJson);
        $data['state'] = $state;

        $this->load->view('propertyChain/mapTest', array('data' => $data));
    }

    public function propChainMenu()
    {
        $data['_view'] = 'propertyChain/chainMenu';
        $this->load->view('layouts/main', $data);
    }

    public function assetPendInPush()
    {
        $data['_view'] = 'propertyChain/assetPendInPush';
        $this->load->view('layouts/main', $data);
    }

    public function getassetPendInPush()
    {
        $getPendingAssets = $this->PropChainModel->getassetPendInPush();
        $state = ASSAM_STATE_CODE;
        $loc_type = LOC_TYPE_RURAL;

        $property_signature = "base64 encoded signature";
        $property_signer_key = "base64 encoded public key";

        foreach ($getPendingAssets as $asset) {
            $dist_code = $asset->dist_code;
            $subdiv_code = $asset->subdiv_code;
            $cir_code = $asset->cir_code;
            $mouza_code = $asset->mouza_pargona_code;
            $lot_no = $asset->lot_no;
            $village_code = $asset->vill_townprt_code;
            $dag_no = $asset->dag_no;
            $patta_no = $asset->patta_no;

            $gis_code = $this->blockchainutilityclass->generateGisCode($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code);

            $getUlPin = $this->blockchainutilityclass->getGeoJsonAPI($state, $gis_code,  $dag_no);
            $ulpinDetails = json_decode($getUlPin);

            if (!empty($ulpinDetails->features) && $ulpinDetails->features[0]->properties->pniu != null) {
                $ulpin = $ulpinDetails->features[0]->properties->pniu;

                $location_id = $this->blockchainutilityclass->generateLocId($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code);

                $property_id = $this->blockchainutilityclass->generatePropertyId($loc_type, $village_code, $patta_no, $dag_no, $ulpin);

                $land_class_code = $asset->land_class_code;
                $patta_type_code = $asset->patta_type_code;

                $bigha = $asset->dag_area_b;
                $katha = $asset->dag_area_k;
                $lessa = $asset->dag_area_lc;
                $ganda = $asset->dag_area_g;

                $revenue = $asset->dag_revenue;
                $local_tax = $asset->dag_local_tax;

                $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                $old_ulpin = "";

                $getCreateJson = $this->PropChainModel->getCreateDataJson($pattadar_details, $property_id, $property_signature, $property_signer_key, $location_id, $patta_no, $dag_no, $land_class_code, $patta_type_code, $bigha, $katha, $lessa, $ulpin, $old_ulpin, $revenue, $local_tax, $ganda);
            }
        }
    }

    public function test2()
    {
        $url = "https://rtps.assam.gov.in/iservices/rtpsapi/get_noc_payment_status/AS221608A6450167";

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);

        curl_close($ch);

        // Print the return data
        echo "<pre>";
        print_r(json_decode($result, true));
    }

    public function getPattaNo()
    {
        $dist_code = $this->input->post('dist_code', true);
        $subdiv_code = $this->input->post('subdiv_code', true);
        $circle_code = $this->input->post('circle_code', true);
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no', true);
        $vill_code = $this->input->post('vill_code', true);
        $patta_code = $this->input->post('patta_code', true);
        $dag_no = $this->input->post('dag_no', true);

        $get_patta_no = $this->PropChainModel->getPattaNo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no);

        $data['patta_no'] = $get_patta_no->patta_no;


        echo json_encode($data);
    }

    function getSignedJWTForUser()
    {
        // var_dump($_SESSION['credentials']);
        // die;
        $case_no = $this->input->get('case_no');
        $this->load->helper('url');
        $this->load->helper('jwt', 'jwt_helper');
        $ip = $this->utilityclass->get_client_ip();
        $key = "abcd123haryanasinglesigonapplicationDFFEFSDAFE";
        // $key = JWT_KEY;
        //echo "SELECT dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,new_dag_no FROM chitha_col8_order WHERE map_partition is null and order_type_code='02' and case_no = '$case_no' and new_dag_no is not null ";
        // $cases = $this->db->query("SELECT date_entry,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,new_dag_no FROM chitha_col8_order WHERE map_partition is null and order_type_code='02' and case_no = '$case_no' and new_dag_no is not null ")->row_array();
        // $userName = $this->blockchainutilityclass->GetUserName($cases['dist_code'], $cases['subdiv_code'], $cases['cir_code'], $this->session->userdata('user_code'));
        // $giscode = $cases['dist_code'] . "_" . $cases['subdiv_code'] . "_" . $cases['cir_code'] . "_" . $cases['mouza_pargona_code'] . "_" . $cases['lot_no'] . "_" . $cases['vill_townprt_code'];
        // //$giscode='13'."_".'01'."_".'01'."_".'01'."_".'01'."_".'10009';
        // $plot = $cases['dag_no'];

        $payload = array(
            "sub" => "splittoken",
            "UserName" => 'lmbonmaza',
            "levels" => '07' . ',' . '01',
            "Client IP" => '10.177.15.60',
            "User Group" => 'M',
            "gisCode" => '07_01_01_02_01_10004',
            "plotNo" => '55',
            "mutationNo" => 'KAM/UTT/2022-23/15902/FPART',
            "mutationDate" => '28/11/2022',
            "newPlotNo" => '1782'
        );

        $encod = jwt::encode($payload, $key);
        // var_dump($encod);
        // exit;
        // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzcGxpdHRva2VuIiwiVXNlck5hbWUiOiJzYW1hcmVuZHJhazYiLCJsZXZlbHMiOiIwNywwMSIsIkNsaWVudCBJUCI6Ijo6MSIsIlVzZXIgR3JvdXAiOiJNIiwiZ2lzQ29kZSI6IjA3XzAxXzAxXzAyXzAxXzEwMDA0IiwicGxvdE5vIjoiODQiLCJtdXRhdGlvbk5vIjoiS0FNXC9VVFRcLzIwMjItMjNcLzE1ODk0XC9GUEFSVCIsIm11dGF0aW9uRGF0ZSI6IjExXC8wMVwvMjIiLCJuZXdQbG90Tm8iOiIxNzgyIn0.uKYdBbmVANaRUhPZqp3FpR8XssvGNICvVVO7f8CLeiE
        // $url = "http://10.177.0.53/bhunaksha/rest/user/splitsso?state=18&levels=07,01&jwttoken=J0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzcGxpdHRva2VuIiwiVXNlck5hbWUiOiJzYW1hcmVuZHJhazYiLCJsZXZlbHMiOiIxMywwMSIsIkNsaWVudCBJUCI6IjEwLjEuNDMuMjYiLCJVc2VyIEdyb3VwIjoiTSIsImdpc0NvZGUiOiIxM18wMV8wMV8wMV8wMV8xMDAxNCIsInBsb3RObyI6IjEyODMiLCJtdXRhdGlvbk5vIjoiMTIvQ1QvMjAyMSIsIm11dGF0aW9uRGF0ZSI6IjA4LzA3LzIwMjEiLCJuZXdQbG90Tm8iOiIxMDI5MTEifQ._QmgFswcLIhzMydZa1Wy7RXHgh9Yv3CDijaaZiTocII";

        $url = "http://10.177.0.53/bhunaksha/rest/user/splitsso?state=18&levels=07,01&jwttoken=$encod";
        // $url = "http://10.177.7.136/bhudemo/rest/user/splitsso?state=18&levels=07,01&jwttoken=$encod";


        // redirect($url);
        echo "
            <script>
                 window.location.replace('$url');
            </script>
            ";
        exit;
        //window.open('$url');
    }


    public function testSplit()
    {
        // $smsGatewayUrl =  PROP_CHAIN_API . "create.php";

        // $smsGatewayUrl = "http://10.177.0.53/ssobhunaksha/index.php";


        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($this->utilityclass->get_client_ip()))
            $ipaddress = $this->utilityclass->get_client_ip();

        $send_data = array(
            "sub" => "splittoken",
            "userName" => 'lmbonmaza',
            "levels" => '07' . ',' . '01',
            "clientIp" => '10.177.15.167',
            "userGroup" => 'M',
            "gisCode" => '07_01_01_02_01_10004',
            "plotNo" => '55',
            "mutationNo" => 'KAM/UTT/2022-23/15902/FPART',
            "mutationDate" => '28/11/2022',
            "newPlotNo" => '1782'
        );


        $payload = base64_encode(json_encode($send_data));

        redirect("http://localhost/splitsso/index.php?data=" . $payload);

        // echo "<pre>";
        // print_r($payload);
        // die;

        // $url = $smsGatewayUrl;

        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        // $output = curl_exec($ch);
        // curl_close($ch);
        // var_dump($output); 
    }

    // public function bhun_split()
    // {
    //     $split_data = json_decode(base64_decode($this->input->get('data', true)));

    //     $this->load->helper('url');
    //     $this->load->helper('jwt', 'jwt_helper');
    //     // var_dump($split_data);
    //     // die;
    //     $key = "abcd123haryanasinglesigonapplicationDFFEFSDAFE";
    //     $payload = array(
    //         "sub" => $split_data->sub,
    //         "UserName" => $split_data->userName,
    //         "levels" => $split_data->levels,
    //         "Client IP" => $split_data->clientIp,
    //         "User Group" => $split_data->userGroup,
    //         "gisCode" => $split_data->gisCode,
    //         "plotNo" => $split_data->plotNo,
    //         "mutationNo" => $split_data->mutationNo,
    //         "mutationDate" => $split_data->mutationDate,
    //         "newPlotNo" => $split_data->newPlotNo
    //     );
    //     // $payload = array(
    //     //     "sub" => "splittoken",
    //     //     "UserName" => 'lmbonmaza',
    //     //     "levels" => '07' . ',' . '01',
    //     //     "Client IP" => '10.177.15.60',
    //     //     "User Group" => 'M',
    //     //     "gisCode" => '07_01_01_02_01_10004',
    //     //     "plotNo" => '55',
    //     //     "mutationNo" => 'KAM/UTT/2022-23/15902/FPART',
    //     //     "mutationDate" => '28/11/2022',
    //     //     "newPlotNo" => '1782'
    //     // );
    //     $encod = jwt::encode($payload, $key);
    //     // echo $encod;
    //     // die;

    //     $url = "http://10.177.0.53/bhunaksha/rest/user/splitsso?state=18&levels=$split_data->levels&jwttoken=$encod";
    //     // $url = "http://10.177.7.136/bhudemo/rest/user/splitsso?state=18&levels=07,01&jwttoken=$encod";

    //     echo "
    //         <script>
    //              window.location.replace('$url');
    //         </script>
    //         ";
    //     exit;

    //     // redirect($url);
    // }

    public function bhun_split()
    {
        $split_data = json_decode(base64_decode($this->input->get('data', true)));

        $this->load->helper('url');
        $this->load->helper('jwt', 'jwt_helper');
        // echo "<pre>";
        // var_dump($split_data);
        ///!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! for demo !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // update map_for_property to Y
        /*$loc = explode('_', $split_data->gisCode);
        $this->db->where(array('dist_code' => $loc['0'], 'subdiv_code' => $loc['1'], 'cir_code' => $loc['2'], 'mouza_pargona_code' => $loc['3'], 'lot_no' => $loc['4'], 'vill_townprt_code' => $loc['5'], 'dag_no' => $split_data->newPlotNo));
        $this->db->update('chitha_basic', array('map_for_property' => 'Y'));
		*/
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // var_dump($this->db->affected_rows());
        // die;

        //$key = "abcd123haryanasinglesigonapplicationDFFEFSDAFE";
		$key = JWT_KEY;
        $payload = array(
            "sub" => $split_data->sub,
            "UserName" => $split_data->userName,
            "levels" => $split_data->levels,
            "Client IP" => $split_data->clientIp,
			//"Client IP" => '10.177.7.136',
            "User Group" => $split_data->userGroup,
            "gisCode" => $split_data->gisCode,
            "plotNo" => $split_data->plotNo,
            "mutationNo" => $split_data->mutationNo,
            "mutationDate" => $split_data->mutationDate,
            "newPlotNo" => $split_data->newPlotNo
        );
		
		//var_dump($payload);die;
        $encod = jwt::encode($payload, $key);
        // echo $encod;
        // die;

       // $url = BHUNAKSHA_URL."/rest/user/splitsso?state=18&levels=$split_data->levels&jwttoken=$encod";
       $url = "http://10.177.7.136/bhudemo/rest/user/splitsso?state=18&levels=$split_data->levels&jwttoken=$encod";

        echo "
            <script>
                 window.location.replace('$url');
            </script>
            ";
        exit;

        // redirect($url);
    }

    public function dscUpdateTest()
    {
        echo "<pre>";
        var_dump($this->input->post());
        $data = $this->PropChainModel->dscUpdateData();
        return $data;
    }

    public function sendPropChain($case_no)
    {
        // if(isset($case_no)){
        //     $case_no=
        // }
        $cases = $this->PropChainModel->getPropCaseDataformultiDagsDetailsCheck($case_no);


        if(isset($cases) && $cases['multiDag'] == 'Y' && $cases['dagCount'] > 1)
        {
            log_message('error','multiple_dag--------');
            $this->sendPropChainMultipleOrderPass($case_no);
            return;
        }


        $case_data = $this->PropChainModel->getPropCaseData($case_no);
        $decode_data = json_decode($case_data->json_case_data);
        $data['property_data'] = base64_encode(json_encode($decode_data->property_data));
        $data['update_data'] = base64_encode($case_data->json_case_data);
        $data['reference_no'] = $case_data->reference_no;
        $data['case_no'] = $case_data->case_no;
        $data['previous_hash'] = $case_data->previous_hash;
        // echo "<pre>";
        // var_dump($decode_data->property_data);
        // die;
        $data['_view'] = 'dsc/updateChainDsc';
        $this->load->view('layouts/main', $data);
    }

    public function updatePropChainData()
    {
        // echo "<pre>";
        // var_dump($this->input->post());
        // die;
        $certificate = $this->input->post('cert', true);
        $property_signature = $this->input->post('lblSignature', true);
        $property_signer_key = $this->input->post('lblEncryptedKey', true);

        $case_no = $this->input->post('case_no', true);
        $property_data = json_decode(base64_decode($this->input->post('prop_data', true)));
        $chain_update_data = json_decode(base64_decode($this->input->post('update_data', true)), true);
        $reference_no = $this->input->post('reference_no', true);
        //$previous_hash = $this->input->post('previous_hash', true);

        $chain_update_data['certificate'] = $certificate;
        $chain_update_data['property_signature'] = $property_signature;
        $chain_update_data['property_signer_key'] = $property_signer_key;
        //$chain_update_data['previous_hash'] = $previous_hash;

        $dist_code = substr($property_data->location, 0, 2);
        $subdiv_code = substr($property_data->location, 2, 2);
        $circle_code = substr($property_data->location, 4, 2);
        $mouza_code = substr($property_data->location, 6, 2);
        $lot_no = substr($property_data->location, 8, 2);
        $vill_code = substr($property_data->location, 10, 5);

        // echo "<pre>";
        // var_dump($case_no);
        // $prop_chain_update = $this->blockchainutilityclass->propertyChainUpdateApi($chain_update_data);
        // die;
        // var_dump($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $chain_update_data['property_id'], $chain_update_data['certmnemonic'], $chain_update_data['reference_id'], $chain_update_data['user_code'], $property_data->ulpin);
        // die;
        // update flag and time in prop_chain_sent_data
        // $this->db->trans_start();

        //$prop_chain_update = $this->blockchainutilityclass->propertyChainUpdateApi($chain_update_data);
        
        

        $prop_chain_update = new stdClass();
        $prop_chain_update->success = 1;

        $response = array('success' => 0 ,'message' => '#ERROR123 : propertyChain updated wrong!!!');

        //==========certmnemonics====================//
        $certmnemonic = null;
        $certmnemonic_dharitree = null;
        $certmnemonicDetails = $this->propCommon->getPropChainCaseDetails($case_no);
        if(isset($certmnemonicDetails) && !empty($certmnemonicDetails))
        {
            $certmnemonic = $certmnemonicDetails->certmnemonic;
            $certmnemonic_dharitree = $certmnemonicDetails->certmnemonic_dharitree;
        }
        //==========END=============================//


        //update while passing order===========/////////////
        $vill_uuid = null;
        $vill_uuid = $this->blockchainutilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $dag_no  = $property_data->dagno;
        $pattano = $property_data->pattano;

        $x = explode('/',$case_no);
        // $certmnemonic = $x[4];============not used==========
        $this->db->trans_begin();
        $insertAuditData = array(
            'dist_code'   => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code'    => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'      => $lot_no,
            'vill_townprt_code' => $vill_code,
            'village_uuid' => $vill_uuid,
            'patta_no'    => $pattano,
            'dag_no'      => $dag_no,
            'transaction_id' => $case_no,
            'sent_data_json' => json_encode($chain_update_data),
            'response_data_json' => null ,
            'case_no'    => $case_no,
            'is_digitally_signed' => 'Y' ,
            'digitally_signed_date_time' => date('Y-m-d H:i:s') ,
            'created_at' => date('Y-m-d H:i:s') ,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_code'   => $this->session->userdata('user_code'),
            'certmnemonic' => $certmnemonic,
            'certmnemonic_dharitree' => $certmnemonic_dharitree,
        );

        if ($prop_chain_update->success === 1) {


            $insertAuditData['property_chain_status'] = 'N';
            $pc_audit_flag = $this->propCommon->insertPropChainAuditData($insertAuditData);

            if($pc_audit_flag['result'] == false)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1483 : propertyChain not updated=======';

            }
            // $bc_trans_status = $this->propCommon->insertPropChainTransactionSuccessData($insertAuditData);
            $updatedRows = $this->PropChainModel->upd_chain_send_data($case_no, $reference_no, json_encode($chain_update_data), 'N');
            if($updatedRows != 1)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1492 : propertyChain not updated=======';

            }
            // ==================NEED TO UPDATE============
           // $this->PropChainModel->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $chain_update_data['property_id'], $prop_chain_update->transaction_id, $chain_update_data['certmnemonic'], $chain_update_data['reference_id'], $chain_update_data['user_code'], $property_data->ulpin);

            // $this->db->trans_commit();

            $result = $prop_chain_update;
        } elseif ($prop_chain_update->success === 0 || $prop_chain_update->success === 2) {

            $insertAuditData['property_chain_status'] = 'F';

            $pc_audit_flag = $this->propCommon->insertPropChainAuditData($insertAuditData);
            if($pc_audit_flag['result'] == false)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1510 : propertyChain not updated=======';

            }
            // $this->db->trans_rollback();
            $updatedRows = $this->PropChainModel->upd_chain_send_data($case_no, $reference_no, json_encode($chain_update_data), 'F');

            if($updatedRows != 1)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1520 : propertyChain not updated=======';

            }
            // $result = $prop_chain_update;



            // log_message("error", $prop_chain_update->message . ": " . $prop_chain_update->error_msg . ". Error Code: " . $prop_chain_update->error_code);
        } else {
            // $this->db->trans_rollback();

            $insertAuditData['property_chain_status'] = 'F';

            $pc_audit_flag = $this->propCommon->insertPropChainAuditData($insertAuditData);

            if($pc_audit_flag['result'] == false)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1539 : propertyChain not updated=======';

            }
            $updatedRows = $this->PropChainModel->upd_chain_send_data($case_no, $reference_no, json_encode($chain_update_data), 'F');

            if($updatedRows != 1)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1548 : propertyChain not updated=======';

            }
            // $result = array(
            //     'success' => 0,
            //     'message' => 'Property Chain Error',
            //     'error_msg' => 'Unable to update asset in property chain',
            //     'error_code' => '#PROPCHAINCONNERROR0001'
            // );

            // $result = (object)$result;
            // log_message("error", "Unable to connect to property chain. Error Code: #PROPCHAINERROR0001");
        }
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $response['success'] = 0;
            $response['message'] = '#ERRPROP1565 : Something went wrong';
        }
        else
        {
            $this->db->trans_commit();
            $response['success'] = 1;
            $response['message'] = 'propertyChain updated successfully...';
        }

        $updateFlag = $this->propCommon->pushDataToPropChain($certmnemonic);
        log_message('error', '$certmnemonic BLOCK-CHAIN BULK API RESPONSE TYPE '. $updateFlag['responseType']. ' MSG: '.$updateFlag['message']);
        echo json_encode($response);
    }


    // function romanToInt($s)
    // {
    //     $strlength = strlen($s); //check string length
    //     if ($strlength >= 1 && $strlength <= 15) {
    //         if (preg_match("/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/", $s)) {
    //             $map = array(
    //                 'I' => 1,
    //                 'V' => 5,
    //                 'X' => 10,
    //                 'L' => 50,
    //                 'C' => 100,
    //                 'D' => 500,
    //                 'M' => 1000
    //             );
    //             $result = 0;
    //             for ($i = 0; $i < $strlength; $i++) {
    //                 $curr = $map[$s[$i]];

    //                 $next = ($i + 1 <input $strlength) ? $map[$s[$i + 1]] : 0;
    //                 if ($curr >= $next) {
    //                     $result += $curr;
    //                 } else {
    //                     $result -= $curr;
    //                 }
    //             }

    //             echo $result;
    //             return $result;
    //         } else {
    //             echo "Input roman number";
    //             return "Input roman number";
    //         }
    //     } else {
    //         echo "Check input and try again";
    //         return "Check input and try again";
    //     }
    // }

    public function bulkAddAsset()
    {   
        $session_dist = $this->session->userdata('dist_code');
        $session_subdiv = $this->session->userdata('subdiv_code');
        $session_cir = $this->session->userdata('cir_code');
        $data['mouza_list'] = $mouza_list = $this->blockchainutilityclass->getAllMouzaDetails($session_dist,$session_subdiv,$session_cir);
        // echo "<pre>";
        // var_dump($mouza_list);
        // echo "</pre>";
        // exit;
        $data['_view'] = 'propertyChain/bulkAdd/bulkAddIndex';
        $this->load->view('layouts/main', $data);
    }

    public function getBlockChainLocations()
    {
        $locations = BLOCK_CHAIN_LOCATIONS;

        $session_dist = $this->session->userdata('dist_code');
        $session_subdiv = $this->session->userdata('subdiv_code');
        $session_cir = $this->session->userdata('cir_code');

        $villages = array();
        foreach ($locations as $location) {
            $get_loc = explode('_', $location);
            $dist_code = $get_loc[0];
            $subdiv_code = $get_loc[1];
            $cir_code = $get_loc[2];
            $mouza_code = $get_loc[3];
            $lot_no = $get_loc[4];
            $village_code = $get_loc[5];

            $nestedData['location_code'] = $location;

            if ($session_dist == $dist_code && $session_subdiv == $subdiv_code && $session_cir == $cir_code) {
                $nestedData['dist_code'] = $dist_code;
                $nestedData['subdiv_code'] = $subdiv_code;
                $nestedData['cir_code'] = $cir_code;
                $nestedData['mouza_code'] = $mouza_code;
                $nestedData['lot_no'] = $lot_no;
                $nestedData['village_code'] = $village_code;

                $mouza_name = $this->blockchainutilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_code);
                $lot = $this->blockchainutilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
                $village_name = $this->blockchainutilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code);

                $nestedData['mouza_name'] = $mouza_name;
                $nestedData['lot'] = $lot;
                $nestedData['village_name'] = $village_name;

                $villages[] = $nestedData;
            }
        }

        $village_count = sizeof($villages);

        $json_data = json_encode(array(
            'village_count' => $village_count,
            'villages' => $villages
        ));

        echo $json_data;
    }

    public function getAssetToPc()
    {            
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $_POST['mouza_code'];
        $lot_no = $_POST['lot_no'];
        $village_code= $_POST['village_code'];
        $patta_type_code = $_POST['patta_type'];
        $location_code = $dist_code."_".$subdiv_code."_".$cir_code."_".$mouza_code."_".$lot_no."_".$village_code;
        $dags = array();
        $totalData = 0;
        $limit = $this->input->post("length", TRUE);
        $start = $this->input->post("start", TRUE);
        $get_dags = $this->PropChainModel->getAssetToCreatePc($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $limit, $start, $patta_type_code);
        // echo "<pre>";
        // var_dump($get_dags);
        // die;

        $filteredRecords = $get_dags["filtered_rows"];
        $totalData = $get_dags["total_rows"];
        foreach ($get_dags["data"] as $dag) {
            $dag_no = $dag->dag_no;
            $patta_no = $dag->patta_no;
            $bigha = $dag->dag_area_b;
            $katha = $dag->dag_area_k;
            $lessa = $dag->dag_area_lc;
            $ganda = $dag->dag_area_g;
            $patta_type_code = $dag->patta_type_code;
            $landclass_code = $dag->land_class_code;
            if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 1)
            {
                $revenue = $dag->dag_revenue;
                $local_tax = $dag->dag_local_tax;
            }
            else
            {
                $revenue = '0.00';
                $local_tax = '0.00';
            }
            
            if ($dag->old_ulpin == null)
                $old_ulpin = "";
            else
                $old_ulpin = $dag->old_ulpin;
            $check_ulpin = $this->blockchainutilityclass->checkUlpin($location_code, ASSAM_STATE_CODE, $dag_no);

            if ($check_ulpin['success'] == 1) {
                $ulpin = $check_ulpin['ulpin'];
                $params = array(
                    'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $village_code, 'dag_no' => $dag_no, 'patta_no' => $patta_no, 'patta_type_code' => $patta_type_code, 'landclass_code' => $landclass_code, 'bigha' => $bigha, 'katha' => $katha, 'lessa' => $lessa, 'ganda' => $ganda, 'revenue' => $revenue, 'local_tax' => $local_tax, 'ulpin' => $ulpin, 'old_ulpin' => $old_ulpin
                );

                $prop_add_btn = $this->PropChainModel->getPropCreateBtnNew((object)$params);
                $ulpin_status = "<span class='text-success'>Yes</span>";
            } else {
                $prop_add_btn = "<button class='btn btn-info text-white disabled' ><i class='fa fa-upload' style='margin:2px;'></i>&nbsp;Sign Property Chain for Dag $dag_no </button>";
                $ulpin_status = "<span class='text-danger'>No</span>";
            }

            // $select = '<input type="checkbox" id="' . $location_code . '_' . $dag_no . '">';

            $nestedData['dag_no'] = $dag_no;
            $nestedData['ulpin_status'] = $ulpin_status;
            // $nestedData['select'] = $select;
            $nestedData['btn'] = $prop_add_btn;

            $dags[] = $nestedData;
            
        }

        $json_data = array(
            "draw" => $this->input->post('draw', true),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($filteredRecords),
            'data' => $dags
        );

        echo json_encode($json_data);
    }


    public function testhash()
    {

        $data = array(
            'name' => 'Nayan',
            'address' => 'Guwahati'
        );

        $sha_hash = hash('sha512', json_encode($data));

        var_dump(strlen($sha_hash));
    }

    public function get_pending_cases()
    {
        echo "<pre>";
        $ror_data = $this->PropChainModel->get_pending_ror_propchain_data();

        $map_data = $this->PropChainModel->get_pending_map_propchain_data();

        $pending_data = $this->PropChainModel->get_pending_update_propchain_chain();

        var_dump($ror_data, $map_data, $pending_data);
    }

    public function push_prop_chain_asset_bulk($param)
    {
        switch ($param) {
            case BULK_ROR_PARAM:
                $this->PropChainModel->ror_bulk_push();
                break;
            case BULK_MAP_PARAM:
                $this->PropChainModel->map_bulk_push();
                break;
                // case BULK_UPDATE_PARAM:
                //     $this->PropChainModel->update_bulk_push();
                //     break;
            default:
                echo "Invalid Parameter";
                break;
        }
    }

    public function getSignedAssets()
    {
        $data = array();
        if ($this->input->server('REQUEST_METHOD')  == 'POST') {
            $status = $this->input->post('status');
            $get_pending_assets =  $this->PropChainModel->getSignedAssets($status);

            foreach ($get_pending_assets as $row) {
                $nestedData['case_no'] = $row->case_no;
                $nestedData['signed_datetime'] = date('d-m-Y H:i:s', strtotime($row->case_passed_time));
                $sending_status = $row->sending_status;
                $case_no_str = "'".urlencode(base64_encode($row->case_no))."'";
                if ($sending_status == 'N') {
                    if(substr(trim($row->case_no),0,3) == 'MAP' || substr(trim($row->case_no),0,3) == 'ROR'){
                        $nestedData['asset_sign_button'] = '<button class="btn btn-sm btn-warning" disabled><i class="fas fa-file-signature"></i> Asset-Sign</button>';
                    }else{
                        $nestedData['asset_sign_button'] = '<button class="btn btn-sm btn-warning" 
                        onclick="rePushToPropChain('.$case_no_str.')"><i class="fas fa-file-signature"></i> Asset-Sign</button>';
                    }
                    
                    $nestedData['status'] = '<span class="text-warning">Pending</span>';
                    $nestedData['chain_update_time'] = "N/A";
                } elseif ($sending_status == 'F') {
                    $nestedData['asset_sign_button'] = '<button class="btn btn-sm btn-danger" disabled><i class="fas fa-file-signature"></i> Asset-Sign</button>';                                        
                    $nestedData['status'] = '<span class="text-danger">Failed</span>';
                    $nestedData['chain_update_time'] = "N/A";
                } elseif ($sending_status == 'Y') {
                    $nestedData['asset_sign_button'] = '<button class="btn btn-sm btn-secondary disabled"><i class="fas fa-file-signature"></i> Asset-Sign</button>';
                    $nestedData['status'] = '<span class="text-success">Success</span>';
                    $nestedData['chain_update_time'] = date('d-m-Y H:i:s', strtotime($row->prop_chain_update_time));
                }               
                
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_dags_with_ulpin()
    {
        ini_set('memory_limit', -1);

        $this->dbswitch();
        $this->db->select(array('subdiv_code', 'cir_code', 'mouza_pargona_code', 'lot_no', 'vill_townprt_code', 'dag_no', 'patta_no', 'ulpin', 'old_ulpin'));
        $this->db->where('ulpin IS NOT NULL');
        $dags = $this->db->get('chitha_basic')->result();
        echo "<pre>";
        var_dump(json_encode($dags));
        die;
        var_dump($dags);
    }

    //**************************************************************/
    //New Methods 

    //script-validation-callback
    function check_script($str){

        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }

        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }
        
        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }

    //date-validation-callback
    function date_valid($date){
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
            return false;
        
        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);                        
        return checkdate($month, $day, $year);
    }

    public function getLotList(){        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $_POST['mouza_code'];
        $lot_list = $this->db->query("select lot_no,loc_name,locname_eng from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
        and lot_no!='00' and vill_townprt_code='00000'", array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code))->result();
        echo json_encode($lot_list);
    }

    public function getVillageList(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $_POST['mouza_code'];
        $lot_no = $_POST['lot_no'];
        $village_list = $this->db->query("select vill_townprt_code,loc_name,locname_eng,uuid from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
        and lot_no=? and vill_townprt_code!='00000'", array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no))->result();

        $cir_uuid = $this->db->query("select uuid from location where dist_code=? and subdiv_code=? 
         and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?", array($dist_code,$subdiv_code,$cir_code,'00','00','00000'))->row()->uuid;
        $enabledCircles = json_decode(BLOCK_CHAIN_ALLOWED_CIRCLES);
        $enabledLocations =  json_decode(BLOCK_CHAIN_ALLOWED_VILLAGES);
        $circle_enabled = false; 
        $is_complete_circle = false; 
        $enabled_village_list = array();

        foreach($enabledCircles as $enableCircle){
             if(in_array($cir_uuid, $enableCircle)){
                $circle_enabled = true;
                if($enableCircle[1] == 1){
                   //completey allowed circle 
                   $is_complete_circle = true;
                   break;
                }else{
                   $is_complete_circle = false;
                   break;
                }
             }
        }

        if($circle_enabled){
            if($is_complete_circle){
                echo json_encode($village_list);
                exit;
            }else{
                foreach($village_list as $village){
                    if( in_array($village->uuid, $enabledLocations)){
                        array_push($enabled_village_list,$village);
                    }
                }
            }
        }else{
            //returns empty village list 
            echo json_encode($enabled_village_list);
            exit;
        }
        echo json_encode($enabled_village_list);
        exit;
        
    }

    public function getPattaTypes(){
        $sql = "select type_code, patta_type, pattatype_eng from patta_code where jamabandi='y'";
        $query = $this->db->query($sql);
        $patta_type_code = $query->result();
        echo json_encode($patta_type_code);
    }

    public function propChainTest($cert){
        //**************************************************************/
        // testing of dag exists in block chain 
        // $dist_code= '08';
        // $subdiv_code= '01';
        // $cir_code= '01';
        // $mouza_pargona_code= '01';
        // $lot_no = '01';
        // $vill_townprt_code='10001';
        // $dag_no = '500';
        // echo json_encode($this->propCommon->checkDagExistsInPropChain($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,
        // $lot_no,$vill_townprt_code,$dag_no));
        //**************************************************************/
        //testing bulk push in block chain 
        echo "<pre>";
        var_dump($this->propCommon->pushDataToPropChain($cert));
        echo "</pre>";
    }
    //**************************************************************/


    public function sendPropChainMultiple($case_no)
    {
        $data = array();
        $data['dhar_case_no'] = base64_decode(urldecode($case_no));
        $data['certificate'] = $this->PropChainModel->getDscSignCertificate('08');
        log_message('error','dhar_case_no : '.$data['dhar_case_no']);
        $case_data = $this->PropChainModel->getPropCaseDataformultiDags($data['dhar_case_no']);
        $data['case_count'] = sizeof($case_data);

        log_message('error','case_count======='.$data['case_count']);
        
        $data['_view'] = 'dsc/updateChainDscMultiple';
        $this->load->view('layouts/main', $data);
    }

    public function bulkSignForMultipleDags()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $case_no = $_POST['case_no'];
        log_message('error','2015-----------'.$case_no);
        $case_data = $this->PropChainModel->getPropCaseDataformultiDagsDetails($case_no);
        log_message('error','2016case_data'.json_encode($case_data));
        foreach ($case_data as $key => $case_data) 
        {
            $decode_data = json_decode($case_data->json_case_data);
            $data[$key]['property_data'] = base64_encode(json_encode($decode_data->property_data));
            $data[$key]['update_data']   = base64_encode($case_data->json_case_data);
            $data[$key]['reference_no']  = $case_data->reference_no;
            $data[$key]['case_no']       = $case_data->case_no;
            $data[$key]['previous_hash'] = $case_data->previous_hash;
            $data[$key]['case_no'] = $case_no;
        }

        echo json_encode($data);
    }

    public function sendPropChainMultipleOrderPass($case_no)
    {
        $data = array();
        $data['dhar_case_no'] = base64_decode(urldecode($case_no));
        log_message('error','dhar_case_no : '.$data['dhar_case_no']);
        $case_data = $this->PropChainModel->getPropCaseDataformultiDags($data['dhar_case_no']);
        $data['case_count'] = sizeof($case_data);

        $case_data = $case_data[0];
        $decode_data = json_decode($case_data->json_case_data);
        $data['property_data'] = base64_encode(json_encode($decode_data->property_data));
        $data['update_data'] = base64_encode($case_data->json_case_data);
        $data['reference_no'] = $case_data->reference_no;
        $data['case_no'] = $case_data->case_no;
        $data['previous_hash'] = $case_data->previous_hash;
        log_message('error','case_count======='.$data['case_count']);
        $data['_view'] = 'dsc/updateChainDscMultipleOrderPass';
        $this->load->view('layouts/main', $data);
    }

    public function updatePropChainDataMultiple()
    {
        // echo "<pre>";
        // var_dump($this->input->post());
        // die;
        $certificate = $this->input->post('cert', true);
        $property_signature = $this->input->post('lblSignature', true);
        $property_signer_key = $this->input->post('lblEncryptedKey', true);

        $case_no = $this->input->post('case_no', true);
        $property_data = json_decode(base64_decode($this->input->post('prop_data', true)));
        $chain_update_data = json_decode(base64_decode($this->input->post('update_data', true)), true);
        $reference_no = $this->input->post('reference_no', true);
        //$previous_hash = $this->input->post('previous_hash', true);

        $chain_update_data['certificate'] = $certificate;
        $chain_update_data['property_signature'] = $property_signature;
        $chain_update_data['property_signer_key'] = $property_signer_key;
        //$chain_update_data['previous_hash'] = $previous_hash;

        $dist_code = substr($property_data->location, 0, 2);
        $subdiv_code = substr($property_data->location, 2, 2);
        $circle_code = substr($property_data->location, 4, 2);
        $mouza_code = substr($property_data->location, 6, 2);
        $lot_no = substr($property_data->location, 8, 2);
        $vill_code = substr($property_data->location, 10, 5);

        // echo "<pre>";
        // var_dump($case_no);
        // $prop_chain_update = $this->blockchainutilityclass->propertyChainUpdateApi($chain_update_data);
        // die;
        // var_dump($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $chain_update_data['property_id'], $chain_update_data['certmnemonic'], $chain_update_data['reference_id'], $chain_update_data['user_code'], $property_data->ulpin);
        // die;
        // update flag and time in prop_chain_sent_data
        // $this->db->trans_start();

        //$prop_chain_update = $this->blockchainutilityclass->propertyChainUpdateApi($chain_update_data);
        
        

        $prop_chain_update = new stdClass();
        $prop_chain_update->success = 1;

        $response = array('success' => 0 ,'message' => '#ERROR123 : propertyChain updated wrong!!!');

        //==========certmnemonics====================//
        $certmnemonic = null;
        $certmnemonic_dharitree = null;
        $certmnemonicDetails = $this->propCommon->getPropChainCaseDetails($case_no);
        if(isset($certmnemonicDetails) && !empty($certmnemonicDetails))
        {
            $certmnemonic = $certmnemonicDetails->certmnemonic;
            $certmnemonic_dharitree = $certmnemonicDetails->certmnemonic_dharitree;
        }
        //==========END=============================//


        //update while passing order===========/////////////
        $vill_uuid = null;
        $vill_uuid = $this->blockchainutilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $dag_no  = $property_data->dagno;
        $pattano = $property_data->pattano;

        $x = explode('/',$case_no);
        // $certmnemonic = $x[4];============not used==========
        $this->db->trans_begin();
        $insertAuditData = array(
            'dist_code'   => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code'    => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'      => $lot_no,
            'vill_townprt_code' => $vill_code,
            'village_uuid' => $vill_uuid,
            'patta_no'    => $pattano,
            'dag_no'      => $dag_no,
            'transaction_id' => $case_no,
            'sent_data_json' => json_encode($chain_update_data),
            'response_data_json' => null ,
            'case_no'    => $case_no,
            'is_digitally_signed' => 'Y' ,
            'digitally_signed_date_time' => date('Y-m-d H:i:s') ,
            'created_at' => date('Y-m-d H:i:s') ,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_code'   => $this->session->userdata('user_code'),
            'certmnemonic' => $certmnemonic,
            'certmnemonic_dharitree' => $certmnemonic_dharitree,
        );

        if ($prop_chain_update->success === 1) {


            $insertAuditData['property_chain_status'] = 'N';
            $pc_audit_flag = $this->propCommon->insertPropChainAuditData($insertAuditData);

            if($pc_audit_flag['result'] == false)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1483 : propertyChain not updated=======';

            }
            // $bc_trans_status = $this->propCommon->insertPropChainTransactionSuccessData($insertAuditData);
            $updatedRows = $this->PropChainModel->upd_chain_send_data_multiple($case_no, $reference_no, json_encode($chain_update_data), 'N');
            if($updatedRows != 1)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1492 : propertyChain not updated=======';

            }
            // ==================NEED TO UPDATE============
           // $this->PropChainModel->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $chain_update_data['property_id'], $prop_chain_update->transaction_id, $chain_update_data['certmnemonic'], $chain_update_data['reference_id'], $chain_update_data['user_code'], $property_data->ulpin);

            // $this->db->trans_commit();

            $result = $prop_chain_update;
        } elseif ($prop_chain_update->success === 0 || $prop_chain_update->success === 2) {

            $insertAuditData['property_chain_status'] = 'F';

            $pc_audit_flag = $this->propCommon->insertPropChainAuditData($insertAuditData);
            if($pc_audit_flag['result'] == false)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1510 : propertyChain not updated=======';

            }
            // $this->db->trans_rollback();
            $updatedRows = $this->PropChainModel->upd_chain_send_data_multiple($case_no, $reference_no, json_encode($chain_update_data), 'F');

            if($updatedRows != 1)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1520 : propertyChain not updated=======';

            }
            // $result = $prop_chain_update;



            // log_message("error", $prop_chain_update->message . ": " . $prop_chain_update->error_msg . ". Error Code: " . $prop_chain_update->error_code);
        } else {
            // $this->db->trans_rollback();

            $insertAuditData['property_chain_status'] = 'F';

            $pc_audit_flag = $this->propCommon->insertPropChainAuditData($insertAuditData);

            if($pc_audit_flag['result'] == false)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1539 : propertyChain not updated=======';

            }
            $updatedRows = $this->PropChainModel->upd_chain_send_data_multiple($case_no, $reference_no, json_encode($chain_update_data), 'F');

            if($updatedRows != 1)
            {
                // $this->db->trans_rollback();
                $response['success'] = 0;
                $response['message'] = '#ERROR1548 : propertyChain not updated=======';

            }
            // $result = array(
            //     'success' => 0,
            //     'message' => 'Property Chain Error',
            //     'error_msg' => 'Unable to update asset in property chain',
            //     'error_code' => '#PROPCHAINCONNERROR0001'
            // );

            // $result = (object)$result;
            // log_message("error", "Unable to connect to property chain. Error Code: #PROPCHAINERROR0001");
        }
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $response['success'] = 0;
            $response['message'] = '#ERRPROP1565 : Something went wrong';
            $response['complete_status'] = 0;
        }
        else
        {
            $dharCase = $this->PropChainModel->getPropDharCaseNo($case_no);
            $completeCount = $this->PropChainModel->getPropCaseDataCompleteStatus($dharCase->dhar_case_no);
            $complete_status = 0;
            if(sizeof($completeCount)== 0)
            {
                $complete_status = 1;
            }
            $this->db->trans_commit();
            $response['success'] = 1;
            $response['message'] = 'propertyChain updated successfully...';
            $response['complete_status'] = $complete_status;
        }

        $updateFlag = $this->propCommon->pushDataToPropChain($certmnemonic);
        log_message('error', '$certmnemonic BLOCK-CHAIN BULK API RESPONSE TYPE '. $updateFlag['responseType']. ' MSG: '.$updateFlag['message']);
        echo json_encode($response);
    }

}
