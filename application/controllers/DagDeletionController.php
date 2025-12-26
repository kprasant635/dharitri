<?php

class DagDeletionController extends CI_Controller
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
        $this->load->model('DagDeletionModel');

    }




    // User check
    public function checkDagDeletionUsers($uCode)
    {
        $process = 1;
        if ($this->session->userdata('user_desig_code') != $uCode)
        {
            $this->session->set_flashdata('message', " You are not authorized !");
            redirect(base_url() . "index.php/Home/index");
        }

        return $process;
    }


    // get village list
    public function getVillageList()
    {
        $data   = [];
        $dis    = $this->input->post('dis');
        $subdiv = $this->input->post('subdiv');
        $cir    = $this->input->post('cir');
        $mza    = $this->input->post('mza');
        $lot    = $this->input->post('lot');

        $this->session->set_userdata('lot_no',$lot);

        $allVillage = $this->UtilsModel->getVillageList($dis,$subdiv,$cir,$mza,$lot);
        $data['test'] = $allVillage;

        echo json_encode($data);
    }


    // get Dag list
    public function getDagList()
    {
        $data   = [];
        $dis    = $this->input->post('dis');
        $subdiv = $this->input->post('subdiv');
        $cir    = $this->input->post('cir');
        $mza    = $this->input->post('mza');
        $lot    = $this->input->post('lot');
        $vill   = $this->input->post('vill');

        $dagList = $this->UtilsModel->getDagList($dis,$subdiv,$cir,$mza,$lot,$vill);

        $data['test'] = $dagList;

        echo json_encode($data);
    }


    // get area details
    public function getAreaDetails()
    {
        $data = [];
        $dis = $this->input->post('dis');
        $this->session->set_userdata('dist_code',$dis);
        $subdiv = $this->input->post('subdiv');
        $cir    = $this->input->post('cir');
        $mza    = $this->input->post('mza');
        $lot    = $this->input->post('lot');
        $vill   = $this->input->post('vill');
        $dag_no = $this->input->post('dag');


        $data = $this->UtilsModel->getAreaDetail($dis,$subdiv,$cir,$mza,$lot,$vill,$dag_no);
        $temp = $data[0]->land_class_code;

        $land_type = $this->db->query("Select land_type,class_code from landclass_code where class_code='$temp'");
        $land_type = $land_type->row();
        $land_type_present = $this->db->query("Select land_type,class_code from landclass_code where class_code!='$temp'");
        $land_type_present = $land_type_present->result();

        $json = array();
        foreach ($data as $object)
        {
            $json = array(
                'bigha'             => trim($object->dag_area_b),
                'katha'             => trim($object->dag_area_k),
                'lessa'             => trim($object->dag_area_lc),
                'ganda'             => trim($object->dag_area_g),
                'kranti'            => trim($object->dag_area_kr),
                'land_type'         => trim($land_type->land_type),
                'land_code'         => trim($land_type->class_code),
                'patta_type_code'   => trim($object->patta_type_code),
                'patta_no'          => trim($object->patta_no),
                'land_type_present' => $land_type_present
            );
        }
        echo json_encode($json);
    }


    // get pattadar details
    public function getAllPattadarInDag()
    {
        $data = [];
        $dis = $this->input->post('dis');
        $this->session->set_userdata('dist_code',$dis);
        $subdiv = $this->input->post('subdiv');
        $cir = $this->input->post('cir');
        $mza = $this->input->post('mza');
        $lot = $this->input->post('lot');
        $vill=$this->input->post('vill');
        $dag_no_int=$this->input->post('dag');


        $f_query = "select patta_no, patta_type_code,dag_no from chitha_basic where dist_code=? and subdiv_code=?
                and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?
                and dag_no_int=?";
        $patta_result = $this->db->query($f_query, array(
            $dis, $subdiv, $cir, $mza,$lot, $vill, $dag_no_int))->result();



        if (!count($patta_result))
        {
            echo "";
            return;
        }
        $patta_no = $patta_result[0]->patta_no;
        $patta_type_code = $patta_result[0]->patta_type_code;
        $dag_no = $patta_result[0]->dag_no;

        $allowDelDag = $dis.'_'.$subdiv.'_'.$cir.'_'.$mza.'_'.$lot.'_'.$vill.'_'.$dag_no;

        if(!in_array($allowDelDag,ALLOW_DAG_DELETION_DIST_TO_DAG))
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'      => 'You are not authorized for this dag'
            ));
            return;

        }

        $where="dist_code = ? 
        and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?
        and vill_townprt_code = ? and patta_type_code = ? and patta_no= ?";

        $s_query="select cp.pdar_id,cp.pdar_name,cp.pdar_father from 
        (select pdar_id,pdar_name,pdar_father from chitha_pattadar where $where  )
        as cp 
        join (select pdar_id from chitha_dag_pattadar where $where and (p_flag != '1' or p_flag is null) and dag_no= ?) as cdp on cp.pdar_id = cdp.pdar_id ";

        $data = $this->db->query($s_query, array(
            $dis, $subdiv, $cir, $mza,
            $lot, $vill, $patta_type_code,trim($patta_no),$dis, $subdiv, $cir, $mza,
            $lot, $vill, $patta_type_code,trim($patta_no),$dag_no
        ))->result();


        echo json_encode($data);
    }


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }



    ////////   LM END  ///////

    // 'W' = Pending deletion request;
    // 'R' = Rejected deletion request;
    // 'F' = Approved deletion request;

    // LM Landing page
    public function FlagIndexLM()
    {
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['mouza_pargona_code'] = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->session->userdata('lot_no');

        $data['pending_count']  = $this->DagDeletionModel->getPendingCountOfDelDagLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,'W');
        $data['approve_count']  = $this->DagDeletionModel->getApprovedCountOfDelDagLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,'F');
        $data['rejected_count'] = $this->DagDeletionModel->getRejectedCountOfDelDagLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,'R');

        $data['_view'] = 'DagDeletion/IndexLM';
        $this->load->view('layouts/main',$data);
    }


    // dag deletion view page
    public function dagDeletionViewPageLm()
    {
        $uCode = 'LM';
        $this->checkDagDeletionUsers($uCode);

        $data = [];
        $data['_view'] = 'DagDeletion/dag_delete_view_page_lm';
        $this->load->view('layouts/main', $data);

    }


    // submit & forward to CO
    public function lmSubmitAndForwardToCo()
    {
        $response  = array('responseType' => 1 ,'msg' => 'Something went wrong');

        $masterKeyFile = array();
        foreach ($_FILES as $key=>$val)
        {
            $masterKeyFile[] = $key;
        }


        $fileCount = $this->input->post('fileCounter');
        // validation for file type and file size
        $validation = array();

        if($this->input->post('chitha_verified')== null)
        {
            $validation[] = array('field' => "chitha_verified", 'message' => "Kindly verify chitha before processing");
        }
        for($i = 1; $i <= $fileCount; $i++)
        {
            $indexFile = 'uploadFile'.$i;
            if(!in_array($indexFile,$masterKeyFile))
            {
                continue;
            }
            if($this->input->post('document'.$i) == null || $this->input->post('document'.$i) == '')
            {
                $validation[] = array('field' => 'document'.$i, 'message' => "Title is missing");
            }
            if($this->input->post('uploadFile'.$i) != 'undefined')
            {

                $name = $_FILES['uploadFile'.$i]['name'];
                $size = $_FILES['uploadFile'.$i]['size'];

                $mime = mime_content_type($_FILES['uploadFile'.$i]['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];

                if($name != NULL)
                {
                    if($ext == NULL)
                    {
                        $validation[] = array('field' => 'uploadFile'.$i, 'message' => "File extension required");
                    }
                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                    {
                        $validation[] = array('field' => 'uploadFile'.$i, 'message' => "Only JPG/PNG/PDF file");
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        $validation[] = array('field' => 'uploadFile'.$i, 'message' => "Maximum 2MB file size");
                    }
                }
                else
                {
                    $validation[] = array('field' => 'uploadFile'.$i, 'message' => "File Name Required");
                }
            }
            else
            {
                $validation[] = array('field' => 'uploadFile'.$i, 'message' => "Title is missing");
            }
        }
        if (sizeof($validation) > 0)
        {
            echo json_encode(array(
                'responseType' => 1,
                'validation'  => $validation,
                'msg' => 'Some field is missing during submission...please check form properly'
            ));
            return false;
        }
        else
        {
            $dist_code          = trim($this->input->post('dist_code'));
            $subdiv_code        = trim($this->input->post('subdiv_code'));
            $cir_code           = trim($this->input->post('cir_code'));
            $lot_no             = trim($this->input->post('lot_no'));
            $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
            $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
            $chitha_verified    = trim($this->input->post('chitha_verified'));
            $dag_no             = trim($this->input->post('dag_no'));
            $reject_code        = trim($this->input->post('reason'));
            $reject_reason      = trim($this->input->post('remarks'));
            $land_class_code    = trim($this->input->post('land_class_code'));
            $patta_no           = trim($this->input->post('patta_no'));
            $patta_type_code    = trim($this->input->post('patta_type_code'));
            $checkVal           = $this->db->query("select * from dag_deleted_record_details where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code =? and dag_no = ?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no))->num_rows();

            if($chitha_verified != 'YES')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'validation'  => $validation,
                    'msg' => 'Some field is missing during submission...please check form properly1'
                ));
                return;
            }
            if($patta_no == '' || $patta_type_code == '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'validation'  => $validation,
                    'msg' => 'Some field is missing during submission...please check form properly2'
                ));
                return;
            }
            if($checkVal > 0)
            {
                $response['msg'] = "Dag Deletion request already done.";
                echo json_encode($response);
                return false;
            }
            if($dag_no == '')
            {
                $response['msg'] = "Kindly select Dag Number";
                echo json_encode($response);
                return false;
            }

            $dagDetails = $this->DagDeletionModel->getAreaDetail($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no);
            $allowed    = $this->DagDeletionModel->dagDeleteQuery($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dagDetails->dag_no);


            $allowDelDag = $dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code.'_'.$dagDetails->dag_no;
            if(!in_array($allowDelDag,ALLOW_DAG_DELETION_DIST_TO_DAG))
            {
                $response['msg'] = "You are not authorized for this dag";
                echo json_encode($response);
                return false;

            }
            if($allowed['response'] != 1 )
            {
                $response['msg'] = ' You cannot Request dag deletion for this dag as its reference is found in  '. $allowed['msg'] .". Please check chitha copy.";
                echo json_encode($response);
                return false;
            }

            $bigha     = $this->input->post('bigha');
            $katha     = $this->input->post('katha');
            $lessa     = $this->input->post('lessa');
            $ganda     = $this->input->post('ganda');
            $kranti    = $this->input->post('kranti');
            $user_code = $this->session->userdata('user_code');
            $case_name = $this->generateDagDelRequestNo();
            if(empty($case_name))
            {
                $response['msg'] = "Network Issue or Session Out. Please try Again";
                echo json_encode($response);
                return false;
            }
            //*******generating petition_no and case_no */
            $request_no=$this->generateDagReqNo();
            $case_no=$case_name.$request_no."/".DAGDEL;

            $insertedArray = array(
                'case_no'            => $case_no,
                'request_no'         => $request_no,
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'dag_no'             => $dag_no,
                'dag_area_b'         => $bigha,
                'dag_area_k'         => $katha,
                'dag_area_lc'        => $lessa,
                'dag_area_g'         => $ganda,
                'dag_area_kr'        => $kranti,
                'user_code'          => $this->session->userdata('user_code'),
                'lm_code'            => $this->session->userdata('user_code'),
                'status'             => 'W',
                'land_class_code'    => $land_class_code,
                'pending_office'     => 'CO',
                'from_office'        => 'LM',
                'creation_date_time' => date('Y-m-d H:i:s'),
                'updation_date_time' => date('Y-m-d H:i:s'),
                'reject_code'        => $reject_code,
                'reject_remarks'     => $reject_reason,
                'chitha_verified'    => $chitha_verified,
                'patta_type_code'    => $patta_type_code,
                'patta_no'           => $patta_no,
                'ip'                 => $this->utilityclass->get_client_ip(),
            );

            $this->db->trans_begin();

            $backup_insertion_lm = $this->db->insert('dag_deleted_record_details', $insertedArray);

            if($backup_insertion_lm != 1){
                $this->db->trans_rollback();
                log_message('error', '#DAGDEL001: Insertion failed in dag_deleted_record_details Case No '.$case_no);
                $response['msg'] = '#DAGDEL001: Registration of Dag Deletion request failed for Request no : '.$case_no;
                echo json_encode($response);
                return false;
            }


            // upload additional file

            for($i = 1; $i <= $fileCount; $i++)
            {

                $indexFile = 'uploadFile'.$i;
                if(!in_array($indexFile,$masterKeyFile))
                {
                    continue;
                }
                $_FILES['file']['name'] = $_FILES['uploadFile'.$i]['name'];
                $_FILES['file']['type'] = $_FILES['uploadFile'.$i]['type'];
                $_FILES['file']['tmp_name'] = $_FILES['uploadFile'.$i]['tmp_name'];
                $_FILES['file']['error'] = $_FILES['uploadFile'.$i]['error'];
                $_FILES['file']['size'] = $_FILES['uploadFile'.$i]['size'];

                $mime = mime_content_type($_FILES['uploadFile'.$i]['tmp_name']);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];

                $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = UPLOAD_MAX_SIZE;;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'   => $case_no,
                        'file_name' => $this->input->post('document'.$i),
                        'user_code' => $this->session->userdata('user_code'),
                        'fetch_file_name' => $this->input->post('document'.$i),
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => UPLOAD_DIR . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => DAGDEL_ID,
                    );

                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        $response['msg'] = '#DAGDEL0089: Registration of Dag Deletion request failed for Request no : '.$case_no;
                        echo json_encode($response);
                        return false;
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#DAGDEL00891: Insertion failed in supportive document RTPS Case No '.$application_no);
                    $response['msg'] = '#DAGDEL00891: Registration of Dag Deletion request failed for Request no : '.$case_no;
                    echo json_encode($response);
                    return false;
                }
            }

            $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed + 1;

            $proceeding_data = array(
                'case_no'         => $case_no,
                'proceeding_id'   => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order'        => "Requested for Dag deletion",
                'note_on_order'   => $reject_reason,
                'status'          => 'W',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d H:i:s'),
                'operation'       => 'E',
                'dist_code'       => $dist_code,
                'subdiv_code'     => $subdiv_code,
                'cir_code'        => $cir_code,
                'user_desig_code' => $this->session->userdata('user_desig_code'),
                'ip'              => $this->utilityclass->get_client_ip(),
                'next_date_of_hearing' => date('Y-m-d H:i:s')
            );
            $proceedingStatus = $this->db->insert("petition_proceeding", $proceeding_data);

            if($proceedingStatus != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#DAGDEL002: Insertion failed in petition_proceeding RTPS Case No '.$case_no);
                $response['msg'] = '#DAGDEL002: Registration of Dag Deletion request failed for Request no : '.$case_no;
                echo json_encode($response);
                return false;
            }

            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                log_message('error', '#DAGDEL003: Insertion failed in petition_proceeding RTPS Case No '.$case_no);
                $response['msg'] = '#DAGDEL003: Registration of Dag Deletion request failed for Request no : '.$case_no;
                echo json_encode($response);
                return false;
            }
            else
            {
                $this->db->trans_commit();
                $response['responseType'] = 2;
                $response['msg'] = '#DAGDEL004: Registration of Dag Deletion request forward to Circle officer for request no : '.$case_no;
                echo json_encode($response);
                return false;
            }
        }
    }


    function generateDagDelRequestNo(){
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }


    function generateDagReqNo(){
        $request_no = $this->db->query("select nextval('dag_deleted_record_details_sl_id_seq') as count ")->row()->count;
        return $request_no;
    }


    // get pending dag delete application for LM
    public function viewPendingRequestDetailsLm()
    {

        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $lot_no             = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $dist_name          = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name       = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name           = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzaname          = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code);
        $lot_name           = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no);

        $data['datas'] = array(
            'dist_code'    => $dist_code,
            'subdiv_code'  => $subdiv_code,
            'cir_code'     => $cir_code,
            'dist_name'    => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name'     => $cir_name,
            'lot_no'       => $lot_no,
            'mouzaname'    => $mouzaname,
            'lot_name'     => $lot_name,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $data['_view'] = 'DagDeletion/request_view_lm';
        $this->load->view('layouts/main', $data);
    }


    // pending case pagination LM
    public function getAllPendingDagDelRequest()
    {
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');


        $status  ='W';
        $results = $this->DagDeletionModel->getDagPendingDeletionRequest($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$start,$length,$order,$searchByCol_0,$searchByCol_1,$status);
        $total_records = count($this->DagDeletionModel->getDagPendingDeletionRequestCount($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$order,$searchByCol_0,$searchByCol_1,$status));

        if (!empty($results)) {
            $data_rows = $results;
            foreach ($data_rows as $key => $rows)
            {

                if($rows->status == 'W')
                {
                    $status =  "<b style='color: #263238'>Pending </b>" ;
                    $viewButt = '<a href="'.base_url(). 'index.php/DagDeletionController/viewDagDeletionAppDetails?case=' . $rows->case_no .'"  
                                class="rezaButt buttPrimary"  target="Application Details" > View </a>';
                }
                elseif($rows->status == 'R')
                {
                    $status =  "<b style='color: #C62828'>Rejected</b>" ;
                    $viewButt = '<a href="'.base_url(). 'index.php/DagDeletionController/viewDagDeletionAppDetails?case=' . $rows->case_no .'"  
                                class="rezaButt buttPrimary"  target="Application Details" > View </a>';
                }
                elseif($rows->status == 'F')
                {
                    $status =  "<b style='color: #1B5E20'>Approved</b>" ;
                    $viewButt = '';
                }
                else
                {
                    $status =  "<b style='color: #C62828'>Unknown</b>" ;
                    $viewButt = '';
                }

                $json[] = array(
                    '<span class=""><strong>' . $rows->case_no. '</strong></span>',
                    $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $rows->vill_townprt_code),
                    $rows->dag_area_b."-B-".$rows->dag_area_k."-K-".$rows->dag_area_lc."-L",
                    $this->utilityclass->getLandClassCode($rows->land_class_code),
                    $status,
                    $rows->pending_office,
                    $viewButt,
                );
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
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


    // get approved dag delete application for LM
    public function viewApproveRequestDetailsLm()
    {
        if ($this->session->userdata('user_desig_code') != "LM")
        {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no       = $this->session->userdata('lot_no');
        $dist_name    = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name     = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzaname    = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code);
        $lot_name     = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no);

        $data['datas'] = array(
            'dist_code'    => $dist_code,
            'subdiv_code'  => $subdiv_code,
            'cir_code'     => $cir_code,
            'dist_name'    => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name'     => $cir_name,
            'lot_no'       => $lot_no,
            'mouzaname'    => $mouzaname,
            'lot_name'     => $lot_name,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $data['_view'] = 'DagDeletion/approve_view_lm';
        $this->load->view('layouts/main', $data);
    }


    // approved case pagination LM
    public function getAllApproveDagDelRequest()
    {
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');


        $status ='F';
        $results = $this->DagDeletionModel->getDagApproveDeletionRequest($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$start,$length,$order,$searchByCol_0,$searchByCol_1,$status);
        $total_records = count($this->DagDeletionModel->getDagApproveDeletionRequestCount($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$order,$searchByCol_0,$searchByCol_1,$status));


        if (!empty($results)) {
            $data_rows = $results;
            foreach ($data_rows as $key => $rows)
            {

                if($rows->status == 'W')
                {
                    $status =  "<b style='color: #263238'>Pending </b>" ;
                    $viewButt = '<a href="'.base_url(). 'index.php/DagDeletionController/viewDagDeletionAppDetails?case=' . $rows->case_no .'"  
                                class="rezaButt buttPrimary"  target="Application Details" > View </a>';
                }
                elseif($rows->status == 'R')
                {
                    $status =  "<b style='color: #C62828'>Rejected</b>" ;
                    $viewButt = '<a href="'.base_url(). 'index.php/DagDeletionController/viewDagDeletionAppDetails?case=' . $rows->case_no .'"  
                                class="rezaButt buttPrimary"  target="Application Details" > View </a>';
                }
                elseif($rows->status == 'F')
                {
                    $status =  "<b style='color: #1B5E20'>Approved</b>" ;
                    $viewButt = '';
                }
                else
                {
                    $status =  "<b style='color: #C62828'>Unknown</b>" ;
                    $viewButt = '';
                }

                $json[] = array(
                    '<span class=""><strong>' . $rows->case_no. '</strong></span>',
                    $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $rows->vill_townprt_code),
                    $rows->dag_area_b."-B-".$rows->dag_area_k."-K-".$rows->dag_area_lc."-L",
                    $this->utilityclass->getLandClassCode($rows->land_class_code),
                    $status,
                    $rows->approved_by,
                    $viewButt,
                );
            }


            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
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


    // get Rejected dag delete application for LM
    public function viewRejectedRequestDetailsLm()
    {
        if ($this->session->userdata('user_desig_code') != "LM")
        {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no       = $this->session->userdata('lot_no');
        $dist_name    = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name     = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzaname    = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code);
        $lot_name     = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no);

        $data['datas'] = array(
            'dist_code'    => $dist_code,
            'subdiv_code'  => $subdiv_code,
            'cir_code'     => $cir_code,
            'dist_name'    => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name'     => $cir_name,
            'lot_no'       => $lot_no,
            'mouzaname'    => $mouzaname,
            'lot_name'     => $lot_name,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $data['_view'] = 'DagDeletion/rejected_view_lm';
        $this->load->view('layouts/main', $data);
    }


    // Rejected case pagination LM
    public function getAllRejectedDagDelRequest()
    {
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');


        $status ='R';
        $results = $this->DagDeletionModel->getDagApproveDeletionRequest($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$start,$length,$order,$searchByCol_0,$searchByCol_1,$status);

        $total_records = count($this->DagDeletionModel->getDagApproveDeletionRequestCount($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$order,$searchByCol_0,$searchByCol_1,$status));


        if (!empty($results)) {
            $data_rows = $results;
            foreach ($data_rows as $key => $rows)
            {

                if($rows->status == 'W')
                {
                    $status =  "<b style='color: #263238'>Pending </b>" ;
                    $viewButt = '<a href="'.base_url(). 'index.php/DagDeletionController/viewDagDeletionAppDetails?case=' . $rows->case_no .'"  
                                class="rezaButt buttPrimary"  target="Application Details" > View </a>';
                }
                elseif($rows->status == 'R')
                {
                    $status =  "<b style='color: #C62828'>Rejected</b>" ;
                    $viewButt = '<a href="'.base_url(). 'index.php/DagDeletionController/viewDagDeletionAppDetails?case=' . $rows->case_no .'"  
                                class="rezaButt buttPrimary"  target="Application Details" > View </a>';
                }
                elseif($rows->status == 'F')
                {
                    $status =  "<b style='color: #1B5E20'>Approved</b>" ;
                    $viewButt = '';
                }
                else
                {
                    $status =  "<b style='color: #C62828'>Unknown</b>" ;
                    $viewButt = '';
                }

                $json[] = array(
                    '<span class=""><strong>' . $rows->case_no. '</strong></span>',
                    $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $rows->vill_townprt_code),
                    $rows->dag_area_b."-B-".$rows->dag_area_k."-K-".$rows->dag_area_lc."-L",
                    $this->utilityclass->getLandClassCode($rows->land_class_code),
                    $status,
                    $rows->approved_by,
                    $viewButt,
                );
            }


            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
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


    // view application details
    public function viewDagDeletionAppDetails()
    {
        $case_no   = trim($this->input->get('case'));
        $dist_code = trim($this->session->userdata('dist_code'));
        $userDesig = trim($this->session->userdata('user_desig_code'));
        $userCode  = trim($this->session->userdata('user_code'));
        $caseRow   = $this->DagDeletionModel->countDagDeletionWithCaseNo($dist_code,$case_no);

        if($caseRow->num_rows() != 1)
        {
            $this->session->set_flashdata('error', 'Dag deletion request not found !');
            redirect(base_url() . "index.php/DagDeletionController/viewPendingRequestDetailsLm");
        }

        $caseDetails = $caseRow->row();
        if($userDesig != 'LM')
        {
            $this->session->set_flashdata('error', 'You Are not authorized !');
            redirect(base_url() . "index.php/DagDeletionController/viewPendingRequestDetailsLm");
        }
        if($caseDetails->lm_code != $userCode)
        {
            $this->session->set_flashdata('error', 'You Are not authorized !');
            redirect(base_url() . "index.php/DagDeletionController/viewPendingRequestDetailsLm");
        }



        $dagDetails = $this->DagDeletionModel->getAreaDetail($caseDetails->dist_code,$caseDetails->subdiv_code,
            $caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code,$caseDetails->dag_no);

        $landType  = $this->DagDeletionModel->getLandTypeName(trim($caseDetails->land_class_code));
        $pattaType = $this->DagDeletionModel->getPattaTypeName(trim($caseDetails->patta_type_code));

        $where="dist_code ='$caseDetails->dist_code' and subdiv_code ='$caseDetails->subdiv_code'
        and cir_code ='$caseDetails->cir_code' and mouza_pargona_code ='$caseDetails->mouza_pargona_code'
        and lot_no ='$caseDetails->lot_no' and vill_townprt_code ='$caseDetails->vill_townprt_code' 
        and patta_type_code ='$caseDetails->patta_type_code' and patta_no='$caseDetails->patta_no'";

        $s_query="select cp.pdar_id,cp.pdar_name,cp.pdar_father from 
        (select pdar_id,pdar_name,pdar_father from chitha_pattadar where $where)
        as cp join (select pdar_id from chitha_dag_pattadar where $where and 
        (p_flag != '1' or p_flag is null) and dag_no='$dagDetails->dag_no') as cdp on cp.pdar_id = cdp.pdar_id ";
        $pattadar = $this->db->query($s_query)->result();

        $documents = $this->DagDeletionModel->getAllSupportiveDocuments($case_no);
        $remarks   = $this->DagDeletionModel->getAllProceedingDagDel($case_no);

        $data = array(
            'caseDetails' => $caseDetails,
            'dagDetails'  => $dagDetails,
            'landType'    => $landType,
            'pattaType'   => $pattaType,
            'pattadars'   => $pattadar,
            'documents'   => $documents,
            'remarks'     => $remarks,
        );

        $data['_view'] = 'DagDeletion/dag_deletion_case_details';
        $this->load->view('layouts/main', $data);

    }


    // decode for showing file
    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }


    // view supportive document
    public function getViewSupportiveDocs()
    {

        $filePath = trim($this->input->get('fileId'));
        if($filePath == '')
        {
            $this->session->set_flashdata('error', 'Documents not found !');
            redirect(base_url() . "index.php/DagDeletionController/viewPendingRequestDetailsLm");
        }

        $mainfile = file_get_contents($filePath);
        $conType  = mime_content_type($filePath);
        $mainfile = base64_encode($mainfile);
        if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
        {
            echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
        }
        else
        {
            header("Content-type: ".$conType);
            echo base64_decode($mainfile);
        }


    }





    ////// common ///////



    // get all pending cases common
    public function FlagIndexCommon()
    {
        $arrayAllow = [MB_CIRCLE_OFFICER, MB_SUB_DIV_COMM, MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM];

        $userDesig = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDesig,$arrayAllow))
        {
            echo json_encode("Not Authorised..!, Please Login With Valid Credentials!");
            exit;
        }

        $dist_code   = $this->session->userdata('dist_code');

        if($userDesig == MB_CIRCLE_OFFICER)
        {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code    = $this->session->userdata('cir_code');
            $data['pending_count'] = $this->DagDeletionModel->getPendingCountOfVillageCO($dist_code,$subdiv_code,$cir_code,'W',MB_CIRCLE_OFFICER);

        }
        elseif ($userDesig == MB_SUB_DIV_COMM)
        {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $data['pending_count'] = $this->DagDeletionModel->getPendingCountOfVillageSDO($dist_code,$subdiv_code,'W',MB_SUB_DIV_COMM);

        }
        elseif ($userDesig == MB_ADD_DEPUTY_COMM)
        {
            $data['pending_count'] = $this->DagDeletionModel->getPendingCountOfVillageAdcDc($dist_code,'W',MB_ADD_DEPUTY_COMM);

        }
        elseif ($userDesig == MB_DEPUTY_COMM)
        {
            $data['pending_count'] = $this->DagDeletionModel->getPendingCountOfVillageAdcDc($dist_code,'W',MB_DEPUTY_COMM);

        }
        else
        {
            $this->session->set_flashdata('message', " There is some problem !");
            redirect(base_url() . "index.php/Home/index");
        }


        $data['_view'] = 'DagDeletion/index_common';
        $this->load->view('layouts/main',$data);
    }


    // get pending dag delete application for Common
    public function viewPendingRequestDetailsCommon()
    {

        $arrayAllow = [MB_CIRCLE_OFFICER, MB_SUB_DIV_COMM, MB_ADD_DEPUTY_COMM, MB_DEPUTY_COMM];
        $userDesig  = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDesig,$arrayAllow))
        {
            echo json_encode("Not Authorised..!, Please Login With Valid Credentials!");
            exit;
        }

        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        if($userDesig == MB_CIRCLE_OFFICER)
        {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code    = $this->session->userdata('cir_code');
            $allCases  = $this->DagDeletionModel->getPendingDagDelCasesCo($dist_code,$subdiv_code,$cir_code,$userDesig);
        }
        if($userDesig == MB_SUB_DIV_COMM)
        {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $allCases  = $this->DagDeletionModel->getPendingDagDelCasesSdo($dist_code,$subdiv_code,$userDesig);
        }
        if($userDesig == MB_ADD_DEPUTY_COMM)
        {
            $allCases  = $this->DagDeletionModel->getPendingDagDelCasesAdcDc($dist_code,$userDesig);
        }
        if($userDesig == MB_DEPUTY_COMM)
        {
            $allCases  = $this->DagDeletionModel->getPendingDagDelCasesAdcDc($dist_code,$userDesig);
        }

        $data = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name,
            'cases'     => $allCases,
        );

        $data['_view'] = 'DagDeletion/request_view_common';
        $this->load->view('layouts/main', $data);
    }


    // view application details
    public function viewDagDeletionAppDetailsCommon()
    {
        $case_no   = trim($this->input->get('case'));
        $dist_code = trim($this->session->userdata('dist_code'));
        $userDesig = trim($this->session->userdata('user_desig_code'));
        $userCode  = trim($this->session->userdata('user_code'));
        $caseRow   = $this->DagDeletionModel->countDagDeletionWithCaseNo($dist_code,$case_no);

        if($caseRow->num_rows() != 1)
        {
            $this->session->set_flashdata('error', 'Dag deletion request not found !');
            redirect(base_url() . "index.php/DagDeletionController/viewPendingRequestDetailsLm");
        }

        $caseDetails = $caseRow->row();

        $dagDetails = $this->DagDeletionModel->getAreaDetail($caseDetails->dist_code,$caseDetails->subdiv_code,
            $caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code,$caseDetails->dag_no);

        $landType  = $this->DagDeletionModel->getLandTypeName(trim($caseDetails->land_class_code));
        $pattaType = $this->DagDeletionModel->getPattaTypeName(trim($caseDetails->patta_type_code));

        $where="dist_code ='$caseDetails->dist_code' and subdiv_code ='$caseDetails->subdiv_code'
        and cir_code ='$caseDetails->cir_code' and mouza_pargona_code ='$caseDetails->mouza_pargona_code'
        and lot_no ='$caseDetails->lot_no' and vill_townprt_code ='$caseDetails->vill_townprt_code' 
        and patta_type_code ='$caseDetails->patta_type_code' and patta_no='$caseDetails->patta_no'";

        $s_query="select cp.pdar_id,cp.pdar_name,cp.pdar_father from 
        (select pdar_id,pdar_name,pdar_father from chitha_pattadar where $where)
        as cp join (select pdar_id from chitha_dag_pattadar where $where and 
        (p_flag != '1' or p_flag is null) and dag_no='$dagDetails->dag_no') as cdp on cp.pdar_id = cdp.pdar_id ";
        $pattadar = $this->db->query($s_query)->result();

        $documents = $this->DagDeletionModel->getAllSupportiveDocuments($case_no);
        $remarks   = $this->DagDeletionModel->getAllProceedingDagDel($case_no);


        $data = array(
            'caseDetails' => $caseDetails,
            'dagDetails'  => $dagDetails,
            'landType'    => $landType,
            'pattaType'   => $pattaType,
            'pattadars'   => $pattadar,
            'documents'   => $documents,
            'remarks'     => $remarks,
            'userDesig'   => $userDesig
        );


        $data['_view'] = 'DagDeletion/dag_deletion_case_details_common';
        $this->load->view('layouts/main', $data);

    }


    // forward the case sdo/adc by co
    public function forwardRequestToAdcSdo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[4000]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#MRDD001178: '.validation_errors()
            ));
            return;
        }
        else
        {
            $case_no   = trim($this->input->post('caseNo'));
            $remarks   = trim($this->input->post('remarks'));
            $dist_code = trim($this->session->userdata('dist_code'));
            $sub_div_c = trim($this->session->userdata('subdiv_code'));
            $user_code = trim($this->session->userdata('user_code'));
            $userDesig = trim($this->session->userdata('user_desig_code'));

            $caseRow   = $this->DagDeletionModel->countDagDeletionWithCaseNo($dist_code,$case_no);
            if($caseRow->num_rows() != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001193: Dag deletion request not found !'
                ));
                return false;
            }

            $caseDetails = $caseRow->row();
            if($caseDetails->status != 'W')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001203: Dag deletion request already processed !'
                ));
                return false;
            }
            if($caseDetails->pending_office != $userDesig)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001211: You are not authorized for this process !'
                ));
                return false;
            }
            if($userDesig != MB_CIRCLE_OFFICER)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001219: You are not authorized for this process !'
                ));
                return false;
            }

            $headQtrCheck = $this->DagDeletionModel->headquarterCheckDagDel($dist_code, $sub_div_c);
            if(trim($headQtrCheck) == 'Y')
            {
                $forwardTo = MB_ADD_DEPUTY_COMM;
            }
            else
            {
                $forwardTo = MB_SUB_DIV_COMM;
            }
            if(!in_array($forwardTo,[MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001237: Forwarding officer not found  !'
                ));
                return false;
            }

            $dagDetails = $this->DagDeletionModel->getAreaDetail($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code,$caseDetails->dag_no);
            $allowDelDag = $caseDetails->dist_code.'_'.$caseDetails->subdiv_code.'_'.$caseDetails->cir_code.'_'.$caseDetails->mouza_pargona_code.'_'.$caseDetails->lot_no.'_'.$caseDetails->vill_townprt_code.'_'.$dagDetails->dag_no;
            if(!in_array($allowDelDag,ALLOW_DAG_DELETION_DIST_TO_DAG))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD00123456: You are not authorized for this dag  !'
                ));
                return false;
            }

            $this->db->trans_begin();

            $updateReq = array(
                'co_code'            => $user_code,
                'pending_office'     => $forwardTo,
                'from_office'        => $userDesig,
                'updation_date_time' => date('Y-m-d h:i:s'),
            );

            $this->db->where('case_no',$case_no);
            $this->db->update('dag_deleted_record_details',$updateReq);
            if($this->db->affected_rows() != 1)
            {
                log_message('error', '#MRDD001259: updating  failed in dag_deleted_record_details and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001259: Forward request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $proceeding = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding where case_no = '$case_no' limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed + 1;

            $proceeding_data = array(
                'case_no'         => $case_no,
                'proceeding_id'   => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order'        => "Request forwarded to ". $forwardTo,
                'note_on_order'   => $remarks,
                'status'          => 'W',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d H:i:s'),
                'operation'       => 'E',
                'dist_code'       => $dist_code,
                'subdiv_code'     => $caseDetails->subdiv_code,
                'cir_code'        => $caseDetails->cir_code,
                'user_desig_code' => $userDesig,
                'ip'              => $this->utilityclass->get_client_ip(),
                'next_date_of_hearing' => date('Y-m-d H:i:s')
            );
            $proceedingStatus = $this->db->insert("petition_proceeding", $proceeding_data);
            if($proceedingStatus != 1)
            {
                log_message('error', '#MRDD001291: insertion  failed in petition_proceeding and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001291: Forward request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Dag Deletion Request successfully Forwarded To '.$forwardTo,
            ));
        }
    }


    // forward the case dc by sdo/adc
    public function forwardRequestToDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[4000]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#MRDD001318: '.validation_errors()
            ));
            return false;
        }
        else
        {
            $case_no   = trim($this->input->post('caseNo'));
            $remarks   = trim($this->input->post('remarks'));
            $dist_code = trim($this->session->userdata('dist_code'));
            $user_code = trim($this->session->userdata('user_code'));
            $userDesig = trim($this->session->userdata('user_desig_code'));

            $caseRow   = $this->DagDeletionModel->countDagDeletionWithCaseNo($dist_code,$case_no);
            if($caseRow->num_rows() != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001335: Dag deletion request not found !'
                ));
                return false;
            }

            $caseDetails = $caseRow->row();
            if($caseDetails->status != 'W')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001345: Dag deletion request already processed !'
                ));
                return false;
            }
            if($caseDetails->pending_office != $userDesig)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001353: You are not authorized for this process !'
                ));
                return false;
            }
            if(!in_array($userDesig,[MB_SUB_DIV_COMM,MB_ADD_DEPUTY_COMM]))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001361: You are not authorized for this process !'
                ));
                return false;
            }

            $dagDetails = $this->DagDeletionModel->getAreaDetail($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code,$caseDetails->dag_no);
            $allowDelDag = $caseDetails->dist_code.'_'.$caseDetails->subdiv_code.'_'.$caseDetails->cir_code.'_'.$caseDetails->mouza_pargona_code.'_'.$caseDetails->lot_no.'_'.$caseDetails->vill_townprt_code.'_'.$dagDetails->dag_no;
            if(!in_array($allowDelDag,ALLOW_DAG_DELETION_DIST_TO_DAG))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD00123456: You are not authorized for this dag  !'
                ));
                return false;
            }

            $this->db->trans_begin();

            $updateReq = array(
                'adc_sdo_code'       => $user_code,
                'pending_office'     => MB_DEPUTY_COMM,
                'from_office'        => $userDesig,
                'updation_date_time' => date('Y-m-d h:i:s'),
            );

            $this->db->where('case_no',$case_no);
            $this->db->update('dag_deleted_record_details',$updateReq);
            if($this->db->affected_rows() != 1)
            {
                log_message('error', '#MRDD001379: updating  failed in dag_deleted_record_details and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001379: Forward request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed + 1;

            $proceeding_data = array(
                'case_no'         => $case_no,
                'proceeding_id'   => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order'        => "Request forwarded to DC",
                'note_on_order'   => $remarks,
                'status'          => 'W',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d H:i:s'),
                'operation'       => 'E',
                'dist_code'       => $dist_code,
                'subdiv_code'     => $caseDetails->subdiv_code,
                'cir_code'        => $caseDetails->cir_code,
                'user_desig_code' => $userDesig,
                'ip'              => $this->utilityclass->get_client_ip(),
                'next_date_of_hearing' => date('Y-m-d H:i:s')
            );
            $proceedingStatus = $this->db->insert("petition_proceeding", $proceeding_data);
            if($proceedingStatus != 1)
            {
                log_message('error', '#MRDD001415: insertion  failed in petition_proceeding and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001415: Forward request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }


            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Dag Deletion Request successfully Forwarded To DC',
            ));

        }
    }


    // Reject the dag deletion request by DC
    public function rejectDeleteRequestByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[4000]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#MRDD001444: '.validation_errors()
            ));
            return false;
        }
        else
        {
            $case_no   = trim($this->input->post('caseNo'));
            $remarks   = trim($this->input->post('remarks'));
            $dist_code = trim($this->session->userdata('dist_code'));
            $user_code = trim($this->session->userdata('user_code'));
            $userDesig = trim($this->session->userdata('user_desig_code'));

            $caseRow   = $this->DagDeletionModel->countDagDeletionWithCaseNo($dist_code,$case_no);
            if($caseRow->num_rows() != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001461: Dag deletion request not found !'
                ));
                return false;
            }

            $caseDetails = $caseRow->row();
            if($caseDetails->status != 'W')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001471: Dag deletion request already processed !'
                ));
                return false;
            }
            if($caseDetails->pending_office != $userDesig)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001479: You are not authorized for this process !'
                ));
                return false;
            }
            if($userDesig != MB_DEPUTY_COMM)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001487: You are not authorized for this process !'
                ));
                return false;
            }

            $this->db->trans_begin();

            $updateReq = array(
                'dc_code'            => $user_code,
                'approved_by'        => $userDesig,
                'approved_u_code'    => $user_code,
                'status'             => 'R',
                'pending_office'     => '',
                'from_office'        => MB_DEPUTY_COMM,
                'updation_date_time' => date('Y-m-d h:i:s'),
                'approved_date_time' => date('Y-m-d h:i:s'),
            );

            $this->db->where('case_no',$case_no);
            $this->db->update('dag_deleted_record_details',$updateReq);
            if($this->db->affected_rows() != 1)
            {
                log_message('error', '#MRDD001513: updating  failed in dag_deleted_record_details and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001513: Reject request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed + 1;

            $proceeding_data = array(
                'case_no'         => $case_no,
                'proceeding_id'   => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order'        => "Request Rejected by DC",
                'note_on_order'   => $remarks,
                'status'          => 'R',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d H:i:s'),
                'operation'       => 'E',
                'dist_code'       => $dist_code,
                'subdiv_code'     => $caseDetails->subdiv_code,
                'cir_code'        => $caseDetails->cir_code,
                'user_desig_code' => $userDesig,
                'ip'              => $this->utilityclass->get_client_ip(),
                'next_date_of_hearing' => date('Y-m-d H:i:s')
            );
            $proceedingStatus = $this->db->insert("petition_proceeding", $proceeding_data);
            if($proceedingStatus != 1)
            {
                log_message('error', '#MRDD001545: insertion  failed in petition_proceeding and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001545: Reject request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Dag Deletion Request successfully Rejected',
            ));

        }
    }


    // Accept the dag deletion request by DC
    public function acceptDeleteRequestByDc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[4000]');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message' => '#MRDD001573: '.validation_errors()
            ));
            return false;
        }
        else
        {
            $case_no   = trim($this->input->post('caseNo'));
            $remarks   = trim($this->input->post('remarks'));
            $dist_code = trim($this->session->userdata('dist_code'));
            $user_code = trim($this->session->userdata('user_code'));
            $userDesig = trim($this->session->userdata('user_desig_code'));

            $caseRow   = $this->DagDeletionModel->countDagDeletionWithCaseNo($dist_code,$case_no);
            if($caseRow->num_rows() != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001590: Dag deletion request not found !'
                ));
                return false;
            }

            $caseDetails = $caseRow->row();
            if($caseDetails->status != 'W')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001600: Dag deletion request already processed !'
                ));
                return false;
            }
            if($caseDetails->pending_office != $userDesig)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001608: You are not authorized for this process !'
                ));
                return false;
            }
            if($userDesig != MB_DEPUTY_COMM)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD001616: You are not authorized for this process !'
                ));
                return false;
            }

            $dagDetails = $this->DagDeletionModel->getAreaDetail($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code,$caseDetails->dag_no);
            $allowDelDag = $caseDetails->dist_code.'_'.$caseDetails->subdiv_code.'_'.$caseDetails->cir_code.'_'.$caseDetails->mouza_pargona_code.'_'.$caseDetails->lot_no.'_'.$caseDetails->vill_townprt_code.'_'.$dagDetails->dag_no;
            if(!in_array($allowDelDag,ALLOW_DAG_DELETION_DIST_TO_DAG))
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message' => '#MRDD00123456: You are not authorized for this dag  !'
                ));
                return false;
            }

            $this->db->trans_begin();

            // delete dag here

            $dagDeleteDetails = $this->DagDeletionModel->isDeletionAllowed(
                $dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code,
                $caseDetails->mouza_pargona_code, $caseDetails->lot_no,$caseDetails->vill_townprt_code,
                $dagDetails->dag_no,$case_no,$caseDetails->patta_type_code,$caseDetails->patta_no);

            $dagDeleteStatus = $dagDeleteDetails['responseType'];
            $dagDeleteMsg    = $dagDeleteDetails['msg'];


            if($dagDeleteStatus != 2)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRBDD03333:'. $dagDeleteMsg,
                ]);
                return false;
            }

            // end dag delete here

            $updateReq = array(
                'dc_code'            => $user_code,
                'approved_by'        => $userDesig,
                'approved_u_code'    => $user_code,
                'status'             => 'F',
                'pending_office'     => '',
                'from_office'        => MB_DEPUTY_COMM,
                'updation_date_time' => date('Y-m-d h:i:s'),
                'approved_date_time' => date('Y-m-d h:i:s'),
            );

            $this->db->where('case_no',$case_no);
            $this->db->update('dag_deleted_record_details',$updateReq);
            if($this->db->affected_rows() != 1)
            {
                log_message('error', '#MRDD001513: updating  failed in dag_deleted_record_details and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001513: Reject request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed + 1;

            $proceeding_data = array(
                'case_no'         => $case_no,
                'proceeding_id'   => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order'        => "Request Accepted by DC",
                'note_on_order'   => $remarks,
                'status'          => 'F',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d H:i:s'),
                'operation'       => 'E',
                'dist_code'       => $dist_code,
                'subdiv_code'     => $caseDetails->subdiv_code,
                'cir_code'        => $caseDetails->cir_code,
                'user_desig_code' => $userDesig,
                'ip'              => $this->utilityclass->get_client_ip(),
                'next_date_of_hearing' => date('Y-m-d H:i:s')
            );
            $proceedingStatus = $this->db->insert("petition_proceeding", $proceeding_data);
            if($proceedingStatus != 1)
            {
                log_message('error', '#MRDD001545: insertion  failed in petition_proceeding and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001545: Reject request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }
            $proceeding_data = array(
                'case_no'         => $case_no,
                'proceeding_id'   => $proceeding_id + 1,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order'        => "Dag Successfully Deleted",
                'note_on_order'   => $remarks,
                'status'          => 'F',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d H:i:s'),
                'operation'       => 'E',
                'dist_code'       => $dist_code,
                'subdiv_code'     => $caseDetails->subdiv_code,
                'cir_code'        => $caseDetails->cir_code,
                'user_desig_code' => $userDesig,
                'ip'              => $this->utilityclass->get_client_ip(),
                'next_date_of_hearing' => date('Y-m-d H:i:s')
            );
            $proceedingStatus = $this->db->insert("petition_proceeding", $proceeding_data);
            if($proceedingStatus != 1)
            {
                log_message('error', '#MRDD001545: insertion  failed in petition_proceeding and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRDD001545: Reject request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message' => 'Dag Deletion Request successfully Accepted & Dag successfully Deleted',
            ));

        }
    }



}