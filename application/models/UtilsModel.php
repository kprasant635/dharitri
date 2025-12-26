<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UtilsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');

    }


    // ********** code by Masud Reza

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


    function defaultValue($input, $value)
    {
        if (empty($input)) return $value;

        return $input;
    }


    // to get Area Details (Assamese B + K + L)
    public function getAreaDetails($district, $subdiv, $circle, $mouza, $lot, $village, $dag)
    {
        $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no, 
        patta_type_code from chitha_basic where dist_code=? and cir_code=? and 
        subdiv_code=? and vill_townprt_code=? and mouza_pargona_code=? 
        and lot_no=? and dag_no=?", array($district,$circle,$subdiv,$village,$mouza,$lot,$dag));
        $object = $area->row();

        $totalArea = 0;

        if(in_array($district, json_decode(BARAK_VALLEY)))
        {
            $bigha = $this->defaultValue(trim($object->dag_area_b),0);
            $katha = $this->defaultValue(trim($object->dag_area_k),0);
            $lessa = $this->defaultValue(trim($object->dag_area_lc),0);
            $ganda = $this->defaultValue(trim($object->dag_area_g),0);
            $totalArea = ($bigha * 6400) + ($katha * 320)  + ($lessa * 20) + $ganda;
            return $totalArea;
        }
        else
        {
            $bigha = $this->defaultValue(trim($object->dag_area_b),0);
            $katha = $this->defaultValue(trim($object->dag_area_k),0);
            $lessa = $this->defaultValue(trim($object->dag_area_lc),0);
            $totalArea = ($bigha * 100) + ($katha * 20)  + $lessa;
            return $totalArea;

        }

    }



    // get dist name
    public function getDistrictNameByDistCode($distCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code','00')
            ->get('location')
            ->row();

    }

    // get dist name english
    public function getEngDistrictNameByDistCode($distCode)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code',$distCode)
            ->where('subdiv_code','00')
            ->get('location')
            ->row();

    }

    // get subdiv name english
    public function getEngSubdivNameByDistCode($distCode, $subdiv_code)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code', '00')
            ->where('mouza_pargona_code', '00')
            ->where('vill_townprt_code', '00000')
            ->where('lot_no', '00')
            ->get('location')
            ->row();

    }

    // get subdivision details
    public function getSubDivisionDetailsByDist($distCode,$diviCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code','00')
            ->get('location')
            ->row();
    }


    // get circle details
    public function getCircleDetailsByDistDivision($distCode,$diviCode,$circleCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code','00')
            ->get('location')
            ->row();
    }


    // get mouza details
    public function getMouzaDetailsByDistDivisionCircle($distCode,$diviCode,$circleCode,$mouzaCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code',$mouzaCode)
            ->where('lot_no','00')
            ->get('location')
            ->row();
    }


    // get lot details
    public function getLotDetailsNameByDistDivisionCircleMouza($distCode,$diviCode,$circleCode,$mouzaCode,$lotCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code',$mouzaCode)
            ->where('lot_no',$lotCode)
            ->where('vill_townprt_code','00000')
            ->get('location')
            ->row();
    }


    // get village details
    public function getVillageDetailsNameByDistDivisionCircleMouzaLot($distCode,$diviCode,$circleCode,$mouzaCode,$lotCode,$vilCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code',$mouzaCode)
            ->where('lot_no',$lotCode)
            ->where('vill_townprt_code',$vilCode)
            ->get('location')
            ->row();
    }


    // get user name dc
    public function getUserNameDc($distCode)
    {
        $this->db->select('users.username');
        $this->db->from('users');
        $this->db->join('loginuser_table','loginuser_table.user_code = users.user_code');
        $this->db->where('users.dist_code',$distCode );
        $this->db->where('loginuser_table.dist_code',$distCode );
        $this->db->where('users.user_desig_code',MB_DEPUTY_COMM );
        $this->db->where('loginuser_table.dis_enb_option','E' );
        $this->db->order_by('loginuser_table.date_of_creation', 'desc');
        $data = $this->db->get()->row();
        return $data;
    }


    // get english circle name
    public function getEngCircleDetails($distCode, $diviCode, $circleCode)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code', $distCode)
            ->where('subdiv_code', $diviCode)
            ->where('cir_code', $circleCode)
            ->where('mouza_pargona_code', '00')
            ->get('location')
            ->row();
    }

    // get english lot name
    public function getEngLotDetails($distCode, $diviCode, $circleCode, $mouzaCode, $lotCode)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code', $distCode)
            ->where('subdiv_code', $diviCode)
            ->where('cir_code', $circleCode)
            ->where('mouza_pargona_code', $mouzaCode)
            ->where('lot_no', $lotCode)
            ->get('location')
            ->row();
    }


    function downloadExcelReport($filename, $result_array)
    {
        require_once 'application/libraries/xlsxwriter.class.php';
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        // var_dump($result_array[0]);
        //$head_array[] = array_keys($result_array[0]);
        foreach($result_array[0] as $key=>$head)
        {
            $final_head[$key]='string';
        }
        $styles1 = array( 'font'=>'Arial','font-size'=>14,'font-style'=>'bold', 'fill'=>'#FFFF00',
            'halign'=>'center', 'border'=>'left,right,top,bottom');
        $styles7 = array( 'border'=>'left,right,top,bottom');
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //header("Content-Type: application/vnd.ms-excel");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        $writer = new XLSXWriter();
        $writer->setAuthor('Dharitree');
        $writer->writeSheetHeader('Sheet1', $final_head,$styles1);
        foreach($result_array as $row)
            $writer->writeSheetRow('Sheet1', (array)$row,$styles7);
        ob_end_clean();
        $writer->writeToStdOut();
        exit(0);
    }


    // for CO only
    function downloadExcelReportForCoOnly($filename, $result_array)
    {
        require_once 'application/libraries/xlsxwriter.class.php';
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        foreach($result_array[0] as $key=>$head)
        {
            $final_head[$key]='string';
        }
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
        $writer->writeSheetHeader('Sheet1', $final_head,$styles1);
        foreach($result_array as $row)
            $writer->writeSheetRow('Sheet1', (array)$row,$styles7);
        ob_end_clean();
        $writer->writeToStdOut();
        exit(0);

    }


    public function getVillageList($dist,$sub,$circle,$mza,$lot)
    {
        $data = $this->db->select('*')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where('mouza_pargona_code',$mza)
            ->where('lot_no',$lot)
            ->where_not_in('vill_townprt_code','00000')
            ->get('location');

        return $data->result();


    }

    public function getMouzaList($dist,$sub,$circle)
    {
        $data = $this->db->select('*')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where_not_in('mouza_pargona_code','00')
            ->where('lot_no','00')
            ->where('vill_townprt_code','00000')
            ->get('location');

        return $data->result();


    }


    // get dag list
    public function getDagList($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code) {
        $q = ""
            . "Select dag_no, dag_no_int from   Chitha_Basic where "
            . "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
            . "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
            . "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
        $district = $this->db->query($q);
        return $district->result();
    }


    // get area details
    public function getAreaDetail($dist,$sub,$circle,$mza,$lot,$village_code,$dag_no)
    {

        $data = $this->db->select('dag_no,patta_no,patta_type_code,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,land_class_code')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where('mouza_pargona_code',$mza)
            ->where('lot_no',$lot)
            ->where('vill_townprt_code',$village_code)
            ->where('dag_no_int',$dag_no)
            ->get('chitha_basic');

        return $data->result();

    }

    // upload file
    function uploadFile($case_no, $redirectUrl = ''){
        if($redirectUrl == ''){
            $redirectUrl = base_url() . "index.php/home";
        }
        $error_data_messages_arr = [];
        //////////////////////////////////
        if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for($i = 0; $i < $fileCount; $i++)
            {
                $fileText = $this->input->post('fileText')[$i];
                $response = specialCharacterCheckingInInput($fileText, ['-'], 'File text ' . ($i + 1) . ',');
                if($response['status'] == 'n'){
                    array_push($error_data_messages_arr, $response['message']);
                }

                $response = isValidQuery($fileText);
                if($response['status'] == 'n'){
                    array_push($error_data_messages_arr, 'File text ' . ($i + 1) . ', has MALECIOUS QUERY');
                }

                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $ext  = $exp[1];
                    if($name != NULL)
                    {
                        if($ext == NULL)
                        {
                            // todo error show extension missing
                            array_push($error_data_messages_arr, 'File '. ($i + 1) .', Not Supported. Error Code(#FAPL001)');
                            // $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                            // redirect(base_url() . "index.php/home");
                        }
                        if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                        {
                            // todo error show file allow type not match
                            array_push($error_data_messages_arr, 'File '. ($i + 1) .',  Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)');
                            // $this->session->set_flashdata('message', "File  Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                            // redirect(base_url() . "index.php/home");
                        }
                        if($size > UPLOAD_MAX_SIZE)
                        {
                            array_push($error_data_messages_arr, "Maximum 2MB file size for file ". ($i + 1) .". Error Code(#FAPL003)");
                            // $this->session->set_flashdata('message', "Maximum 2MB file size for file. Error Code(#FAPL003)");
                            // redirect(base_url() . "index.php/home");
                        }
                    }
                    else
                    {
                        array_push($error_data_messages_arr, 'File name '. ($i + 1) .' can\'t be empty. Error Code(#FAPL004)');
                        // $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                        // redirect(base_url() . "index.php/home");
                    }
                }
                else{
                    array_push($error_data_messages_arr, 'File '. ($i + 1) .', is required. Error Code(#FAPL005)');
                    // $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                    // redirect(base_url() . "index.php/home");
                }

            }
            if(count($error_data_messages_arr)){
                $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $error_messages);

                redirect($redirectUrl);
            }
        }

        $file_names = [];
        if(isset($_FILES['fileUpload']['name'])){

            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];
                $replaceCase=str_replace("/","-",$case_no);
                $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                $config['upload_path']   = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = UPLOAD_MAX_SIZE;;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    array_push($file_names, MANUAL_ATTACHMENT . $fileRename);
                    $document= array(
                        'case_no'   => $case_no,
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'REC',
                    );
                    // save data in attachment file

                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                    log_message('error',$this->db->last_query());
                    if($addMoreDocQuery != 1)
                    {
                        log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);

                        if(count($file_names)){
                            foreach($file_names as $singlefile_name){
                                unlink($singlefile_name);
                            }
                        }

                        redirect($redirectUrl);
                        return false;
                    }
                }
                else
                {
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);

                    if(count($file_names)){
                        foreach($file_names as $singlefile_name){
                            unlink($singlefile_name);
                        }
                    }

                    redirect($redirectUrl);
                    return false;
                }
            }
        }

        return $file_names;
    }

    // download excel
    function downloadExcelReport_result($filename, $result_array)
    {
        //var_dump($result_array);
        require_once 'application/libraries/xlsxwriter.class.php';
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        $head_array = array_keys($result_array[0][0]);
        foreach($head_array as $head)
        {
            $final_head[$head]='string';
        }
        $styles1 = array( 'font'=>'Arial','font-size'=>14,'font-style'=>'bold', 'fill'=>'#1f19c6',
            'halign'=>'center', 'border'=>'left,right,top,bottom','color'=>'#fff');
        $styles7 = array( 'border'=>'left,right,top,bottom');
        // var_dump($final_head);
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //header("Content-Type: application/vnd.ms-excel");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        $writer = new XLSXWriter();
        $writer->setAuthor('Dharitree');
        $writer->writeSheetHeader('Sheet1', $final_head,$styles1);
        foreach($result_array as $row)
            foreach($row as $r)
                $writer->writeSheetRow('Sheet1', $r,$styles7);
        ob_end_clean();
        $writer->writeToStdOut();
        exit(0);
    }


    // get land type name
    public function getLandTypeName($temp)
    {
        return $this->db->select('land_type,class_code')
            ->where('class_code', $temp)
            ->get('landclass_code')
            ->row();

    }


    // get land type present
    public function getLandTypePresent($temp)
    {
        $data =  $this->db->select('land_type,class_code')
            ->where('class_code !=', $temp)
            ->get('landclass_code');

        return $data->result();

    }

    // get chitha patta details
    public function getChithaPattaDetails($dist,$sub,$circle,$mza,$lot,$village_code,$dag_no)
    {
        $data =  $this->db->select('patta_no,patta_type_code,dag_no')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where('mouza_pargona_code',$mza)
            ->where('lot_no',$lot)
            ->where('vill_townprt_code',$village_code)
            ->where('dag_no_int',$dag_no)
            ->get('chitha_basic');

        return $data->result();
    }


    // get chitha pattadar list
    public function getChithaPattadarList($dis,$subdiv,$cir,$mza,$lot,$vill,$patta_type_code,$patta_no,
                                          $dis2,$subdiv2,$cir2,$mza2,$lot2,$vill2,$patta_type_code2,$patta_no2,$dag_no)
    {
        $where="dist_code = ? 
        and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?
        and vill_townprt_code = ? and patta_type_code = ? and patta_no= ?";

        $s_query="select cp.pdar_id,cp.pdar_name,cp.pdar_father from 
        (select pdar_id,pdar_name,pdar_father from chitha_pattadar where $where  )
        as cp 
        join (select pdar_id from chitha_dag_pattadar where $where and (p_flag != '1' or p_flag is null) and dag_no= ?) as cdp on cp.pdar_id = cdp.pdar_id ";

        $data = $this->db->query($s_query, array(
            $dis, $subdiv, $cir, $mza,$lot, $vill, $patta_type_code,$patta_no,
            $dis2, $subdiv2, $cir2, $mza2,$lot2,$vill2,$patta_type_code2,$patta_no2,$dag_no
        ))->result();

        return $data;
    }

    // get chitha pattadar list from village land bank
    public function getChithaPattadarListFromLandBank($dis,$subdiv,$cir,$mza,$lot,$vill,$dag_no)
    {
        $this->db->select('c_land_bank_encroacher_details.*');
        $this->db->distinct();
        $this->db->from('c_land_bank_details');
        $this->db->join('c_land_bank_encroacher_details','c_land_bank_encroacher_details.c_land_bank_details_id = c_land_bank_details.id');
        $this->db->where('c_land_bank_details.dist_code',$dis);
        $this->db->where('c_land_bank_details.subdiv_code',$subdiv);
        $this->db->where('c_land_bank_details.cir_code',$cir);
        $this->db->where('c_land_bank_details.mouza_pargona_code',$mza);
        $this->db->where('c_land_bank_details.lot_no',$lot);
        $this->db->where('c_land_bank_details.vill_townprt_code',$vill);
        $this->db->where('c_land_bank_details.dag_no',$dag_no);
        $data = $this->db->get()->result();
        return $data;
    }

    // gei all district list
    public function getAllDistrictList()
    {
        $this->db=$this->load->database('db2', TRUE);

        $data = $this->db->select()
            ->get('district_details');


        $this->offlineutility->dbSwitchSession();

        return $data->result();
    }


    // get circle list with db switch
    public function getCircleListByDist($distCode)
    {
        $this->dbswitchmb2($distCode);

        $data = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng
        from location where dist_code=? and cir_code!='00' and  mouza_pargona_code='00' and
        vill_townprt_code='00000' and lot_no='00' order by loc_name ", array($distCode))->result();

        $this->offlineutility->dbSwitchSession();

        return $data;
    }


    public function getAllSubDivName($dist_code)
    {
        $this->dbswitchmb2($dist_code);
        $query = $this->db->query("select dist_code,subdiv_code,locname_eng,loc_name from location where
        dist_code=? and subdiv_code!=? and cir_code=?",array($dist_code,'00','00'))->result();
        return $query;
    }


    // get village list with db switch
    public function getVillageListByUrbanRural($distCode,$subdiv,$circle,$type)
    {
        $this->dbswitchmb2($distCode);

        $village = $this->db->query("select subdiv_code,mouza_pargona_code,lot_no,vill_townprt_code,loc_name
        from location where dist_code=? and subdiv_code=? and cir_code=?
        and mouza_pargona_code!=? and lot_no!=? and loc_name!=? and rural_urban=? order by loc_name",
            array($distCode,$subdiv,$circle,'00','00','',$type))->result();

        $this->offlineutility->dbSwitchSession();

        return $village;
    }

    // get dag list with db switch
    public function getDagListForAdditionalPro($distCode,$subdiv,$circle,$mouza,$lot,$village)
    {
        $this->dbswitchmb2($distCode);

        $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
            . "Dist_code='$distCode' and subdiv_code='$subdiv' and  cir_code='$circle'
        and mouza_Pargona_code='$mouza' and lot_No='$lot' "
            . "and vill_townprt_code='$village' and patta_type_code in
        (select type_code from patta_code where mutation in ('a','i')) and
        (dag_status is null or dag_status !='NR') order by dag_no_int ")->result();

        $this->offlineutility->dbSwitchSession();

        return $dag;
    }


    // get area details list with db switch
    public function getAreaForAdditionalPro($district,$subdiv,$circle,$mouza,$lot,$village,$dag)
    {

        $this->dbswitchmb2($district);

        $json = null;
        $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,
        patta_type_code from chitha_basic where dist_code=? and cir_code=? and
        subdiv_code=? and vill_townprt_code=? and mouza_pargona_code=?
        and lot_no=? and dag_no_int=?", array($district, $circle, $subdiv, $village, $mouza, $lot, $dag))->result();

        $json = array();
        foreach ($area as $object)
        {
            $type = $this->db->query("select patta_type from patta_code where type_code=?", $object->patta_type_code)->row()->patta_type;
            $json = array(
                'bigha'      => trim($object->dag_area_b),
                'katha'      => trim($object->dag_area_k),
                'lessa'      => trim($object->dag_area_lc),
                'ganda'      => trim($object->dag_area_g),
                'kranti'     => trim($object->dag_area_kr),
                'patta_no'   => trim($object->patta_no),
                'patta_type' => $type,
                'patta_code' => trim($object->patta_type_code),
            );
        }

        $this->offlineutility->dbSwitchSession();

        return $json;
    }


    // get village UUID for additional pro
    public function getVillageUuid($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code)
    {
        $this->dbswitchmb2($dist_code);

        $query = $this->db->query("SELECT uuid FROM location WHERE dist_code=? AND subdiv_code=?
            AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?",
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code));

        $data = $query->row()->uuid;

        $this->offlineutility->dbSwitchSession();

        return $data;
    }


    // get additional property with id in array
    public function getAdditionalProperty($id)
    {
        return $this->db->select()
            ->where('id', $id)
            ->get('settlement_additional_property')
            ->row_array();
    }

    // get additional property with id
    public function getAdditionalPropertyId($id)
    {
        return $this->db->select()
            ->where('id', $id)
            ->get('settlement_additional_property');
    }

    // delete additional property with id
    public function deleteAdditionalPropertyId($id)
    {
        return $this->db->select()
            ->where('id', $id)
            ->delete('settlement_additional_property');
    }

    // get additional property with Case
    public function getAdditionalPropertyByCase($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_additional_property');
    }


    public function adcSelect($dist_code) {
        return $this->db->query("SELECT u.username, u.user_desig_code, u.user_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.priv='adm' AND lut.dis_enb_option='E' AND u.dist_code=? AND u.subdiv_code='00' AND u.cir_code='00' AND u.user_desig_code='ADC' ORDER BY lut.date_of_creation DESC", [$dist_code])->result();
    }


}
