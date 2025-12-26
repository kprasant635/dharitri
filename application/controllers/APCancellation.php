<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class APCancellation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('APCancellation/APCancellationModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('misreport/MisModel');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
    }
    function physical_path_to_url($physicalPath)
    {

        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists($physicalPath)) {
            $physicalPath = realpath($physicalPath);
        }
        $physicalPath = str_replace('\\', UPLOAD_SEPARATOR, $physicalPath);
        $documentRoot = str_replace('\\', UPLOAD_SEPARATOR, $documentRoot);
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $baseUrl = $protocol . '://' . $host;
        if (strpos($physicalPath, $documentRoot) === 0) {
            $relativePath = substr($physicalPath, strlen($documentRoot));
            return $baseUrl . UPLOAD_SEPARATOR . ltrim($relativePath, UPLOAD_SEPARATOR);
        }
        return false;
    }

    public function testPDF(){
        $t=time();
        $this->genaratePDF(STORAGE_IP,'TestPDF_'.$t.'.pdf','Test','Test only');
        echo STORAGE_IP,'TestPDF_'.$t.'.pdf';
    }

    public function genaratePDF($folder, $file, $content, $watermark = '')
    {
       // require_once(STORAGE_IP . 'vendor/mpdf/vendor/autoload.php');
        
                    // $mpdf=new \Mpdf\Mpdf();

        if (!file_exists($folder)) {
            if (!mkdir($folder, 0777, true)) {
                return json_encode([
                    'status' => 'error',
                    'message' => "Failed to create folder: $folder"
                ]);
            }
        }

        try {
            include 'vendor/mpdf/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->SetWatermarkText($watermark);
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;

            $mpdf->WriteHTML($content);

            $outputPath = $folder . $file;
            $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);

            if (!file_exists($outputPath)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'PDF file was not created.'
                ]);
            }

            $pdfBase64 = base64_encode(file_get_contents($outputPath));

            return json_encode([
                'status' => 'success',
                'data' => $pdfBase64
            ]);
        } catch (\Mpdf\MpdfException $e) {
            log_message('error', '#ERRDB001PDF: ' . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'message' => 'PDF generation error: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            log_message('error', '#ERRDB001PDF: ' . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'message' => 'Unexpected error: ' . $e->getMessage()
            ]);
        }
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

    public function AST()
    {
        $district['names']  = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');


        $district['dist_code']  = $dist_code;
        $district['subdiv_code']  = $subdiv_code;
        $district['cir_code']  = $cir_code;
        $district['mouza_pargona_code']  = $mouza_pargona_code;
        $district['lot_no']  = $lot_no;

        $district['dist']  = $this->MisModel->getDistrictName($dist_code);
        $district['subdiv']  = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $district['circle']  = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $district['mouzalist']  = $this->MisModel->getMouzaList($dist_code, $subdiv_code, $cir_code);

        $district['coname'] = $this->APCancellationModel->getCOName($dist_code, $subdiv_code, $cir_code);


        $sql = $this->db->query("select type_code,patta_type from patta_code where apcancellation='y'");
        $district['eksonapatta'] = $sql->result();
        $year_no = year_no;
        $district['relation'] = $this->APCancellationModel->getRelation();

        $district['_view'] = 'APCancellation/AST';
        $this->load->view('layouts/main', $district);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mouza_code', 'Mouza', 'required');
            $this->form_validation->set_rules('lot_no', 'Lot Number', 'required');
            $this->form_validation->set_rules('vill_code', 'Village', 'required');
            $this->form_validation->set_rules('patta_no', 'Patta Number', 'required|numeric');
            $this->form_validation->set_rules('APC_dag_no', 'Dag Number', 'required|numeric');
            $this->form_validation->set_rules('petitioners_data', 'First Party', 'required');
            $this->form_validation->set_rules('add_off_name', 'Addressing Officer', 'required');

            if ($this->form_validation->run() == FALSE) {
                if (form_error('mouza_code') != "") {
                    echo form_error('mouza_code');
                    $this->form_validation->set_message('mouza_code', 'Mouza must be selected.');
                }
                if (form_error('lot_no') != "") {
                    echo form_error('lot_no');
                    $this->form_validation->set_message('lot_no', 'Lot Number must be selected.');
                }
                if (form_error('vill_code') != "") {
                    echo form_error('vill_code');
                    $this->form_validation->set_message('vill_code', 'Village must be selected.');
                }
                if (form_error('patta_no') != "") {
                    echo form_error('patta_no');
                }
                if (form_error('APC_dag_no') != "") {
                    echo form_error('APC_dag_no');
                }
                if (form_error('petitioners_data') != "") {
                    echo form_error('petitioners_data');
                }
                if (form_error('add_off_name') != "") {
                    echo form_error('add_off_name');
                }
                // Reload form with errors
                $district['_view'] = 'APCancellation/AST';
                $this->load->view('layouts/main', $district);
                return;
            }

            $year_no = year_no;


            $case_name = $this->basundharamodel->genearteCaseName();
            $seq_pet = year_no . '0';
            $case_no['petition_no'] = $petition = $seq_pet . $this->rtpsmodel->genearteApcancelPetitionNo();
            $caseNo = $case_name . $petition . "/NR";

            $petition_no = $petition;


            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');

            $mut_type = $this->input->post('mut_type');

            $date = date("Y-m-d");

            $submission_date = date('Y-m-d G:i:s');
            $patta_type_code = $this->input->post('patta_type_code');
            $patta_no = $this->input->post('patta_no');
            $dag_no = $this->input->post('APC_dag_no');
            // $year_no=year_no;

            $petid = $this->APCancellationModel->getCountPetId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $caseNo);
            $petitioners_data = json_decode($_POST['petitioners_data'], true);
            $add_off_name = $this->input->post('add_off_name');
            $add_off_Desig = $this->input->post('add_off_Desig');
            $user = $this->session->userdata('user_code');

            $countPdarId = $this->APCancellationModel->getCountPdarId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $dag_no, $caseNo, $patta_no, $patta_type_code);

            $PdarName = $this->APCancellationModel->getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $case_no);

            $locationData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code,
            );
            // var_dump($locationData);echo"<hr>";

            $this->db->trans_begin();
            $petition_basic = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition,
                'case_no' => $caseNo,
                'submission_date' => $submission_date,
                'mut_type' => $mut_type,
                'add_off_name' => $add_off_name,
                'add_off_desig' => $add_off_Desig,
                'status' => 'X',
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $status = $this->db->insert("apcancel_petition_basic", $petition_basic);

            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB001AST: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB001AST: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }

            foreach ($petitioners_data as $petitioner) {
                $petitioner_info = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'case_no' => $caseNo,
                    'pet_id' => ++$petid,
                    'pet_name' => $petitioner['name'],
                    'guard_name' => $petitioner['guardian'],
                    'guard_rel' => $petitioner['relation'],
                    'add1' => $petitioner['address1'],
                    'add2' => $petitioner['address2'],
                    'user_code' => $user,
                    'date_entry' => $date,
                    'operation' => 'E'
                );

                $status = $this->db->insert("apcancel_petitioner", $petitioner_info);

                if (!$status) {
                    $db_error = $this->db->_error_message();
                    log_message('error', '#ERRDB002AST: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRDB002AST: AP cancellation transaction failed.");
                    redirect(base_url() . "index.php/home/index");
                    return;
                }
            }

            $CancelDag_info = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $caseNo,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $status = $this->db->insert("apcancel_dag_details", $CancelDag_info);

            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB003AST: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB003AST: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }


            foreach ($PdarName as $pat) {

                if (trim($pat->pdar_guard_reln) == "") {
                    $pat->pdar_guard_reln = "u";
                }

                $CancelDag_pattadar = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'case_no' => $caseNo,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_cron_no' => ++$countPdarId,
                    'pdar_id' => $pat->pdar_id,
                    'pdar_name' => $pat->pdar_name,
                    'pdar_guardian' => $pat->pdar_father,
                    'pdar_rel_guar' => $pat->pdar_guard_reln,
                    'pdar_add1' => $pat->pdar_add1,
                    'pdar_add2' => $pat->pdar_add2,
                    'user_code' => $user,
                    'date_entry' => $date,
                    'operation' => 'E'
                );

                $status = $this->db->insert("apcancel_petition_pattadar", $CancelDag_pattadar);
                if (!$status) {
                    $db_error = $this->db->_error_message();
                    log_message('error', '#ERRDB004AST: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRDB004AST: AP cancellation transaction failed.");
                    redirect(base_url() . "index.php/home/index");
                    return;
                }
            }

            if (!empty($_FILES['documents'])) {
                $i = 0;
                $count = 1;
                foreach ($_FILES['documents']['name'] as $index => $fileData) {
                    $filename = $_FILES['documents']['name'][$index]['file'];
                    $filetype = $_FILES['documents']['type'][$index]['file'];
                    $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                    $error    = $_FILES['documents']['error'][$index]['file'];
                    $filesize = $_FILES['documents']['size'][$index]['file'];
                    $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $caseNo);
                    $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $finalName = $file . '.' . $ext;
                    $_FILES['file'] = [
                        'name' => $finalName,
                        'type' => $filetype,
                        'tmp_name' => $tmpname,
                        'error' => $error,
                        'size' => $filesize
                    ];

                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        $path = $folder;
                    } else {
                        $path = $folder;
                    }

                    $config = [
                        'upload_path' => $folder,
                        'allowed_types' => FILE_TYPE,
                        'max_size' => MAX_SIZE
                    ];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $data = $this->upload->data();
                        $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                        $img = [
                            'case_no' => $caseNo,
                            'user_code' => $user,
                            'file_name' => $_POST['documents'][$i++]['name'],
                            'fetch_file_name' => $file . $data['file_ext'],
                            'file_type' => $data['file_type'],
                            'file_path' => $file_path,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type' => $mut_type,
                            'dag_no' => $dag_no,
                        ];
                        $status = $this->db->insert('supportive_document', $img);
                        if (!$status) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORSD005AST: Uploading insertion failed in supportive_document for case no :' . $caseNo);

                            $json = [
                                'errorMessage' => "#ERRDB005AST: AP Cancellation upload failed for Case No " . $caseNo
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    } else {
                        echo $this->upload->display_errors();
                        log_message('error', '#ERRORUPLOADAP001AST: Uploading insertion failed in supportive_document for case no :' . $caseNo . $this->upload->display_errors());
                    }
                }
            }

            $sql = "update  apcancel_petition_basic set status='P' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "year_no='$year_no' and petition_no='$petition_no' and case_no='$caseNo'"
                . " and mut_type='$mut_type' ";


            $status = $this->db->query($sql);
            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB006AST: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB006AST: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', 'AP cancellation transaction failed. Rolled back.');

                $this->session->set_flashdata('message', "AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
            } else {
                $this->db->trans_commit();

                $this->Dashboard($caseNo);
                $this->session->set_flashdata('message', "Case Number $caseNo Successfully Submitted.");
                redirect(base_url() . "index.php/home/index");
            }
        }
    }

    public function ASTStep1()
    {
        //$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $district['names']  = $this->mutationmodel->getDistricts();
        //var_dump($district);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $district['dist']  = $this->MisModel->getDistrictName($dist_code);
        $district['subdiv']  = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $district['circle']  = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $district['mouzalist']  = $this->MisModel->getMouzaList($dist_code, $subdiv_code, $cir_code);

        //$district['mouza']  = $this->MisModel->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code);
        //$district['lot']  = $this->MisModel->getLotName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);

        // $this->load->view('../views/APCancellation/ASTStep1', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'APCancellation/ASTStep1';
        $this->load->view('layouts/main', $district);

        if (isset($_POST['ASTSTEP1Submit'])) {

            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');

            $locationData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code,
            );
            $this->session->set_userdata($locationData);
            //var_dump($locationData);
            //redirect the page into next step
            redirect(base_url() . "index.php/APCancellation/ASTStep2");
        }
    }

    public function autocompleteForAST2()
    {
        $db =  $this->session->userdata('db');
        $return_arr = array();
        $term = trim($_GET['term']);
        $this->load->helper('html');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $sql = "select distinct(patta_no) AS patta_no from  chitha_basic where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and TRIM(patta_no) LIKE '$term%' "
            . " and patta_type_code IN (select type_code from  patta_code where apcancellation='y')"
            . " ORDER BY patta_no ASC";

        $result = $this->db->query($sql)->result();

        foreach ($result as $res) {
            $return_arr[] =  trim($res->patta_no);
        }
        //var_dump($res);
        echo json_encode($return_arr);
    }

    public function ASTStep2()
    {
        //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');

        $dist_code . " " . $subdiv_code . " " . $cir_code . " " . $mouza_pargona_code . " " . $lot_no . " " . $vill_code;
        //generate year and pettition no 
        $year = year_no;
        $month = date("m");
        // if ($month >= 07) {
        // $year1 = $year + 1;
        // $submission_date =  $year1."-06-30";
        // $date_range = $year . "-" . $year1;
        // } elseif ($month <= 6) {
        // $year1 = $year - 1;
        // $submission_date = $year."-07-01" ;
        // $date_range = $year1 . "-" . $year;
        // }
        //Case no generation starts here
        //        $sql = "SELECT MAX(petition_no) AS petition_no From apcancel_petition_basic WHERE mut_type='0504' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
        //                . " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and submission_date <='$submission_date' ";
        //        
        //       $sql = "SELECT max(petition_no)+1 AS petition_no From  apcancel_petition_basic where dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
        // $petition=$this->db->query($sql)->row()->petition_no;
        // if($petition==null){
        //  $petition=1;
        // }

        // $sql = "SELECT count(petition_no)+1 AS petition_no From  apcancel_petition_basic where dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$year' ";

        //       $result = $this->db->query($sql);
        //       $res = $result->row();
        // $petition_no=$res->petition_no;
        //       //generate petition no
        // if($petition_no==null){
        //  $petition_no=1;
        // }
        // $q="Select dist_abbr,cir_abbr from  location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        // $abbrname=$this->db->query($q)->row();
        // $cir_dist_name=$abbrname->dist_abbr."/".$abbrname->cir_abbr;
        // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        //       $caseNo = $cir_dist_name . "/" . $financialyeardate ."/". $petition_no ."/NR";



        //Case no generation 

        $case_name = $this->basundharamodel->genearteCaseName();
        // $petition=$this->basundharamodel->genearteApcancelPetitionNo();
        // $caseNo=$case_name.$petition."/NR";

        $seq_pet = year_no . '0';
        $case_no['petition_no'] = $petition = $seq_pet . $this->rtpsmodel->genearteApcancelPetitionNo();
        $caseNo = $case_name . $petition . "/NR";

        //find the Circle Officer for the mentioned data
        $data['coname'] = $this->APCancellationModel->getCOName($dist_code, $subdiv_code, $cir_code);
        //find eksona patta
        $data['eksonapatta'] = $this->APCancellationModel->getEksonaPatta();
        //search availabe eksona patta in the desired location
        $data['AvilLand'] = $this->APCancellationModel->checkAbilableEksonaLand($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //var_dump($data);



        // $this->load->view('../views/APCancellation/ASTStep2', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/ASTStep2';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['ASTStep2Submit'])) {

            $mut_type = $this->input->post('mut_type');
            $submission_date1 = $this->input->post('submission_date');
            $submission_date = date("Y-m-d", strtotime($submission_date1));
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type_code = $this->input->post('patta_type_code');
            $user = $this->session->userdata('user_code');

            $patta_info = array(
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code
            );

            $this->session->set_userdata($patta_info);

            $add_off_name = $this->input->post('add_off_name');
            $add_off_Desig = $this->input->post('add_off_Desig');

            $checkavailpattatype = $this->APCancellationModel->checkavailpattatype($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code);




            if ($checkavailpattatype == 0) {
                echo '<script>alert("Opps..! Sorry you have choose a wrong patta no.");</script>';
                redirect('APCancellation/ASTStep2', 'refresh');
            }

            $date = date("Y-m-d");
            //$date_entry = date('Y-m-d G:i:s');
            $petition_basic = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year,
                'petition_no' => $petition,
                'case_no' => $caseNo,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => $mut_type,
                'add_off_name' => $add_off_name,
                'add_off_desig' => $add_off_Desig,
                'status' => 'X',
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $this->session->set_userdata($petition_basic);

            $this->db->insert("apcancel_petition_basic", $petition_basic);

            redirect(base_url() . "index.php/APCancellation/ASTStep3");
        }
    }

    public function ASTStep3()
    {
        //  $db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $year_no = $this->session->userdata('year_no');
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');

        $countPetId['caseno'] = $case_no;

        $countPetId['relation'] = $this->APCancellationModel->getRelation();

        $countPetId['petid'] = $this->APCancellationModel->getCountPetId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);

        // $this->load->view('../views/APCancellation/ASTStep3', $countPetId);
        // $this->load->view('../views/footer');

        $countPetId['_view'] = 'APCancellation/ASTStep3';
        $this->load->view('layouts/main', $countPetId);

        //if the form is submitted
        if (isset($_POST['ASTStep3Submit'])) {
            $pet_id = $this->input->post('pet_id');
            $pet_name = $this->input->post('pet_name');
            $guard_name = $this->input->post('guard_name');
            $guard_rel = $this->input->post('guard_rel');
            $add1 = $this->input->post('add1');
            $add2 = $this->input->post('add2');
            $date = date("Y-m-d");
            $year = year_no;
            $user = $this->session->userdata('user_code');

            $petitioner_info = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'pet_id' => $pet_id,
                'pet_name' => $pet_name,
                'guard_name' => $guard_name,
                'guard_rel' => $guard_rel,
                'add1' => $add1,
                'add2' => $add2,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );
            $this->session->set_userdata($petitioner_info);

            $this->db->insert("apcancel_petitioner", $petitioner_info);

            redirect(base_url() . "index.php/APCancellation/ASTStep3");
        }
    }

    public function ASTStep4()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        //retrieve variable from   session

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type_code = $this->session->userdata('patta_type_code');

        $year_no = year_no;
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');
        $user = $this->session->userdata('user_code');

        $date = date("Y-m-d");

        $dags = $this->APCancellationModel->getAvailDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code);

        $data['dags'] = $dags;
        //retrieve case no from   session variable
        $case_no = $this->session->userdata('case_no');
        $data['caseno'] = $case_no;

        // $this->load->view('../views/APCancellation/ASTStep4', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/ASTStep4';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['dagNoSubmit'])) {
            $dag_no = trim($_POST['dag_no']);

            $CancelDag_info = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );
            $this->session->set_userdata($CancelDag_info);

            $this->db->insert("apcancel_dag_details", $CancelDag_info);

            redirect(base_url() . "index.php/APCancellation/ASTStep5");
        }
    }

    public function ASTStep5()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type_code = $this->session->userdata('patta_type_code');

        $dag_no = $this->session->userdata('dag_no');

        $year_no = year_no;

        $petition_no = $this->session->userdata('petition_no');

        $case_no = $this->session->userdata('case_no');

        $mut_type = $this->session->userdata('mut_type');
        $date = date("Y-m-d");

        $data['caseno'] = $case_no;

        $countPdarId = $this->APCancellationModel->getCountPdarId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $dag_no, $case_no, $patta_no, $patta_type_code);

        $data['pdar_id'] = $countPdarId;
        //get pattadar names from   chitha dag pattadar

        $PdarName = $this->APCancellationModel->getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $case_no);
        $data['pdar_info'] = $PdarName;
        //var_dump( $data['pdar_info']);
        // $this->load->view('../views/APCancellation/ASTStep5', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/ASTStep5';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['ASTStep5Submit'])) {

            //            $pattadar_no = $_POST['pattadar_no'];
            //            $pattadar = $_POST['pattadar'];
            //
            //            $pdar_id = intval($pattadar);
            //            $p = explode("#", $pattadar);
            //            $pdar_name = $p['1'];

            //            $pdar_father = $_POST['pdar_father'];
            //            $pdar_guard_reln = $_POST['pdar_guard_reln'];
            //            $pdar_add1 = $_POST['pdar_add1'];
            //            $pdar_add2 = $_POST['pdar_add2'];

            //var_dump( $data['pdar_info'] );

            foreach ($data['pdar_info']  as $pdar) {

                $pdar_guard_reln1 = $pdar->pdar_guard_reln;
                if ($pdar_guard_reln1 == "") {
                    $pdar_guard_reln = "u";
                }
                $CancelDag_pattadar = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'case_no' => $case_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_cron_no' => $pdar->pdar_id,
                    'pdar_id' =>  $pdar->pdar_id,
                    'pdar_name' =>  $pdar->pdar_name,
                    'pdar_guardian' => $pdar->pdar_father,
                    'pdar_rel_guar' => 'u',
                    'pdar_add1' =>  $pdar->pdar_add1,
                    'pdar_add2' =>  $pdar->pdar_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => $date,
                    'operation' => 'E'
                );
                //  var_dump($CancelDag_pattadar);
                $this->session->set_userdata($CancelDag_pattadar);
                $this->db->insert("apcancel_petition_pattadar", $CancelDag_pattadar);
            }

            $sql = "update  apcancel_petition_basic set status='P' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'"
                . " and mut_type='$mut_type' ";

            $this->db->query($sql);
            /////////////Dashboard/////////////////////
            $this->Dashboard($case_no);


            ////////////////////////////////////
            $this->session->set_flashdata('message', "Successfully Submitted.Case no # $case_no");
            redirect(base_url() . "index.php/home/index");
        }
    }

    //####################################################################################
    //####################################################################################

    public function getPdarData($pdar_id)
    {
        $db =  $this->session->userdata('db');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type_code = $this->session->userdata('patta_type_code');

        $dag_no = $this->session->userdata('dag_no');

        $data = $this->APCancellationModel->getPdarDataJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $pdar_id);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('pdar_id' => $object->pdar_id, 'pdar_name' => $object->pdar_name, 'pdar_father' => $object->pdar_father, 'pdar_add1' => $object->pdar_add1, 'pdar_add2' => $object->pdar_add2, 'pdar_guard_reln' => $object->pdar_guard_reln);
        }
        echo json_encode($json);
    }

    //####################################################################################
    public function LMAPRStep1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        //count the fresh pending AP Cancellation case for LM 
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/APCancellation/LMAPRStep1/';

        //original link
        $data['countAPCase']  =  $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        //var_dump($data);
        $config['total_rows'] = count($data['countAPCase']);

        $config['per_page'] = 5;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->pagination->initialize($config);


        $cases['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforLM1($config["per_page"], $page, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)->result();

        //$cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page)->result();

        $case_array = array();

        foreach ($cases['countAPCaseforCO'] as $c) {

            $q = $this->db->query("select submission_date, case_no, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, year_no, petition_no  from  apcancel_petition_basic "
                . "where status='P' and lm_note_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'")->row();

            array_push($case_array, $c);
        }

        //var_dump($case_array);
        $data['countAPCase'] = $case_array;



        //$data['countAPCase']  = $this->APCancellationModel->getCountAPCasesforLM();

        // $this->load->view('../views/APCancellation/LMAPRStep1', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/LMAPRStep1';
        $this->load->view('layouts/main', $data);
    }

    public function LMAPRStep2()
    {

        $data['_view'] = 'APCancellation/LMAPRStep2';
        $this->load->view('layouts/main', $data);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_townprt_code');

            $year_no = $this->input->post('year_no');
            $petition_no = $this->input->post('petition_no');
            $case_no = $this->input->post('case_no');
            $lm_report = trim($this->input->post('lm_report'));
            $user = $this->session->userdata('user_code');
            $submission_date = $this->input->post('submission_date');
            $date = date("Y-m-d");



            $this->load->library('form_validation');
            $this->form_validation->set_rules('lm_report', 'lm_report', 'required');
            if ($this->form_validation->run() == FALSE) {
                if (form_error('lm_report') != "") {
                    echo form_error('lm_report');
                    $this->form_validation->set_message('lm_report', 'LM report must be provided.');
                }

                redirect(base_url() . "index.php/APCancellation/LMAPRStep2?submission_date=$submission_date&dist_code=$dist_code&subdiv_code=$subdiv_code&cir_code=$cir_code&mouza_pargona_code=$mouza_pargona_code&lot_no=$lot_no&vill_townprt_code=$vill_code&year_no=$year_no&petition_no=$petition_no&case_no=$case_no");
                return;
            }

            $LMData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'lm_report' => $lm_report,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $this->db->trans_begin();

            $status = $this->db->insert("apcancel_petition_lm_note", $LMData);

            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB001LMAPR: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB001LMAPR: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }


            if (!empty($_FILES['documents'])) {
                $i = 0;
                $count = 1;
                foreach ($_FILES['documents']['name'] as $index => $fileData) {
                    $filename = $_FILES['documents']['name'][$index]['file'];
                    $filetype = $_FILES['documents']['type'][$index]['file'];
                    $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                    $error    = $_FILES['documents']['error'][$index]['file'];
                    $filesize = $_FILES['documents']['size'][$index]['file'];
                    $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'LM report';
                    $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $finalName = $file . '.' . $ext;

                    // Create proper $_FILES['file'] array just for this file
                    $_FILES['file'] = [
                        'name' => $finalName,
                        'type' => $filetype,
                        'tmp_name' => $tmpname,
                        'error' => $error,
                        'size' => $filesize
                    ];

                    // Create folder if not exists
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        $path = $folder;
                    } else {
                        $path = $folder;
                    }

                    $config = [
                        'upload_path' => $folder,
                        'allowed_types' => FILE_TYPE,
                        'max_size' => MAX_SIZE
                    ];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $data = $this->upload->data();
                        $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                        $img = [
                            'case_no' => $case_no,
                            'user_code' => $user,
                            'file_name' => $_POST['documents'][$i++]['name'],
                            'fetch_file_name' => $file . $data['file_ext'],
                            'file_type' => $data['file_type'],
                            'file_path' => $file_path, //$path.$file.$data['file_ext'],
                            'date_entry' => date('Y-m-d h:i:s'),
                            // 'mut_type' => $mut_type,
                            // 'dag_no' => $dag_no,
                        ];
                        $status = $this->db->insert('supportive_document', $img);
                        if (!$status) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRDB002LMAPR: Uploading insertion failed in supportive_document for case no :' . $case_no);

                            $json = [
                                'errorMessage' => "#ERRDB002LMAPR: AP Cancellation upload failed for Case No " . $case_no
                            ];
                            echo json_encode($json);
                            return false;
                        }
                        // You can save $uploadData['file_name'], $uploadData['full_path'], etc.
                    } else {
                        echo $this->upload->display_errors();
                        log_message('error', '#ERRORUPLOAD001LMAPR: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                    }
                }
            }

            $Updatesql = "update  apcancel_petition_basic set lm_note_yn='Y', lm_note_date='$date' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";

            $status = $this->db->query($Updatesql);

            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB003LMAPR: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB003LMAPR: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', 'AP cancellation transaction failed. Rolled back.');

                $this->session->set_flashdata('message', "AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
            } else {
                $this->db->trans_commit();

                $this->Dashboard($case_no);
                $this->session->set_flashdata('message', "Lot Mondols Note for Annual Patta Cancellation Submited on Case no # $case_no");
                redirect(base_url() . "index.php/home/index");
            }

            // $penUser="SK";
            // $rmrk='LM submitted his Report';
            // $this->DashboardData($case_no,$penUser,$rmrk);            
            // $this->session->set_flashdata('message',"Lot Mondols Note for Annual Patta Cancellation Submited on Case no # $case_no");
            // redirect(base_url() . "index.php/home/index");
        }
    }

    public function ViewPetition()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        // $data['daginfo'] = $this->APCancellationModel->getDagInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $sql = $this->db->query("select dag_no,patta_no, patta_type_code from apcancel_dag_details where case_no='$case_no'");
        $data['daginfo'] = $sql->result();

        $this->db->where('case_no', $case_no);
        $this->db->order_by('date_entry');
        $this->db->order_by('id');
        $query = $this->db->get('supportive_document');
        $doc_result = $query->result();

        $data['documents']=[];
        if (!empty($doc_result)) {
            foreach ($doc_result as $doc) {
                $doc->file_path = $this->physical_path_to_url($doc->file_path);
            }
            $data['documents'] = $doc_result;
        }

        $data['pattadars'] = $this->APCancellationModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        // $this->load->view('../views/APCancellation/LMViewPetition', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/LMViewPetition';
        $this->load->view('layouts/main', $data);
    }

    //Added by Manashjyoti Deka on 03-06-2025

    public function LMAP()
    {
        $this->load->model('mutation/mutationmodel');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $district['dist_code'] = $dist_code;
        $district['subdiv_code'] = $subdiv_code;
        $district['cir_code'] = $cir_code;
        $district['mouza_pargona_code'] = $mouza_pargona_code;
        $district['lot_no'] = $lot_no;

        $district['dist'] = $this->MisModel->getDistrictName($dist_code);
        $district['subdiv'] = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $district['circle'] = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $district['lot'] = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['villagelist'] = $this->MisModel->getVillageList($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['coname'] = $this->APCancellationModel->getCOName($dist_code, $subdiv_code, $cir_code);
        $sql = $this->db->query("select type_code,patta_type from patta_code where apcancellation='y'");
        $district['eksonapatta'] = $sql->result();
        $year_no = year_no;
        $district['relation'] = $this->APCancellationModel->getRelation();

        $district['_view'] = 'APCancellation/LMAP';
        $this->load->view('layouts/main', $district);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('vill_code', 'Village', 'required');
            $this->form_validation->set_rules('patta_type_code', 'Patta Type', 'required|numeric');
            $this->form_validation->set_rules('patta_no', 'Patta Number', 'required|numeric');
            $this->form_validation->set_rules('APC_dag_no', 'Dag Number', 'required|numeric');
            $this->form_validation->set_rules('petitioners_data', 'First Party', 'required');
            $this->form_validation->set_rules('add_off_name', 'Addressing Officer', 'required');


            if ($this->form_validation->run() == FALSE) {
                if (form_error('vill_code') != "") {
                    echo form_error('vill_code');
                    $this->form_validation->set_message('vill_code', 'Village Code must be selected.');
                }
                if (form_error('patta_type_code') != "") {
                    echo form_error('patta_type_code');
                    $this->form_validation->set_message('patta_type_code', 'Patta type must be selected.');
                }
                if (form_error('patta_no') != "") {
                    echo form_error('patta_no');
                }
                if (form_error('APC_dag_no') != "") {
                    echo form_error('APC_dag_no');
                }
                if (form_error('petitioners_data') != "") {
                    echo form_error('petitioners_data');
                }
                if (form_error('add_off_name') != "") {
                    echo form_error('add_off_name');
                }

                $district['_view'] = 'APCancellation/LMAP';
                $this->load->view('layouts/main', $district);
                return;
            }

            $case_name = $this->basundharamodel->genearteCaseName();
            $petition = $this->basundharamodel->genearteApcancelPetitionNo();
            $case_no = $case_name . $petition . "/NR/SM";
            $petition_no = $petition;

            $date = date("Y-m-d");

            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');

            $mut_type = $this->input->post('mut_type');
            $submission_date = date('Y-m-d G:i:s');
            $patta_type_code = $this->input->post('patta_type_code');
            $patta_no = $this->input->post('patta_no');
            $dag_no = $this->input->post('APC_dag_no');
            $year_no = year_no;

            $petid = $this->APCancellationModel->getCountPetId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);
            $petitioners_data = json_decode($_POST['petitioners_data'], true);
            $add_off_name = $this->input->post('add_off_name');
            $add_off_Desig = $this->input->post('add_off_Desig');
            $user = $this->session->userdata('user_code');



            $countPdarId = $this->APCancellationModel->getCountPdarId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $dag_no, $case_no, $patta_no, $patta_type_code);

            $PdarName = $this->APCancellationModel->getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $case_no);

            $locationData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code,
            );


            $patta_info = array(
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code
            );


            $this->db->trans_begin();

            $petition_basic = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => $mut_type,
                'add_off_name' => $add_off_name,
                'add_off_desig' => $add_off_Desig,
                'status' => 'X',
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $status = $this->db->insert("apcancel_petition_basic", $petition_basic);

            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB001LM: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB001LM: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }

            foreach ($petitioners_data as $petitioner) {
                $petitioner_info = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'case_no' => $case_no,
                    'pet_id' => ++$petid,
                    'pet_name' => $petitioner['name'],
                    'guard_name' => $petitioner['guardian'],
                    'guard_rel' => $petitioner['relation'],
                    'add1' => $petitioner['address1'],
                    'add2' => $petitioner['address2'],
                    'user_code' => $user,
                    'date_entry' => $date,
                    'operation' => 'E'
                );

                $status = $this->db->insert("apcancel_petitioner", $petitioner_info);

                if (!$status) {
                    $db_error = $this->db->_error_message();
                    log_message('error', '#ERRDB002LM: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRDB002LM: AP cancellation transaction failed.");
                    redirect(base_url() . "index.php/home/index");
                    return;
                }
            }

            $CancelDag_info = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $status = $this->db->insert("apcancel_dag_details", $CancelDag_info);

            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB003LM: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB003LM: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }


            foreach ($PdarName as $pat) {

                if (trim($pat->pdar_guard_reln) == "") {
                    $pat->pdar_guard_reln = "u";
                }

                $CancelDag_pattadar = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'case_no' => $case_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_cron_no' => ++$countPdarId,
                    'pdar_id' => $pat->pdar_id,
                    'pdar_name' => $pat->pdar_name,
                    'pdar_guardian' => $pat->pdar_father,
                    'pdar_rel_guar' => $pat->pdar_guard_reln,
                    'pdar_add1' => $pat->pdar_add1,
                    'pdar_add2' => $pat->pdar_add2,
                    'user_code' => $user,
                    'date_entry' => $date,
                    'operation' => 'E'
                );


                // var_dump($CancelDag_pattadar);
                $status = $this->db->insert("apcancel_petition_pattadar", $CancelDag_pattadar);
                if (!$status) {
                    $db_error = $this->db->_error_message();
                    log_message('error', '#ERRDB004LM: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRDB004LM: AP cancellation transaction failed.");
                    redirect(base_url() . "index.php/home/index");
                    return;
                }
            }

            if (!empty($_FILES['documents'])) {
                $i = 0;
                $count = 1;
                foreach ($_FILES['documents']['name'] as $index => $fileData) {
                    $filename = $_FILES['documents']['name'][$index]['file'];
                    $filetype = $_FILES['documents']['type'][$index]['file'];
                    $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                    $error    = $_FILES['documents']['error'][$index]['file'];
                    $filesize = $_FILES['documents']['size'][$index]['file'];
                    $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no);
                    $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $finalName = $file . '.' . $ext;
                    $_FILES['file'] = [
                        'name' => $finalName,
                        'type' => $filetype,
                        'tmp_name' => $tmpname,
                        'error' => $error,
                        'size' => $filesize
                    ];

                    // Create folder if not exists
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        $path = $folder;
                    } else {
                        $path = $folder;
                    }

                    $config = [
                        'upload_path' => $folder,
                        'allowed_types' => FILE_TYPE,
                        'max_size' => MAX_SIZE
                    ];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $data = $this->upload->data();
                        $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                        $img = [
                            'case_no' => $case_no,
                            'user_code' => $user,
                            'file_name' => $_POST['documents'][$i++]['name'],
                            'fetch_file_name' => $file . $data['file_ext'],
                            'file_type' => $data['file_type'],
                            'file_path' => $file_path, //$path.$file.$data['file_ext'],
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type' => $mut_type,
                            'dag_no' => $dag_no,
                        ];
                        $status = $this->db->insert('supportive_document', $img);
                        if (!$status) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRDB005LM: Uploading insertion failed in supportive_document for case no :' . $case_no);

                            $json = [
                                'errorMessage' => "#ERRDB005LM: AP Cancellation upload failed for Case No " . $case_no
                            ];
                            echo json_encode($json);
                            return false;
                        }
                        // You can save $uploadData['file_name'], $uploadData['full_path'], etc.
                    } else {
                        echo $this->upload->display_errors();
                        log_message('error', '#ERRORUPLOAD001LM: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                    }
                }
            }

            $sql = "update  apcancel_petition_basic set status='P' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'"
                . " and mut_type='$mut_type' ";

            $status = $this->db->query($sql);
            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB006LM: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB006LM: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', 'AP cancellation transaction failed. Rolled back.');

                $this->session->set_flashdata('message', "AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
            } else {
                $this->db->trans_commit(); // All good

                $this->Dashboard($case_no);
                $this->session->set_flashdata('message', "Case Number $case_no Successfully Submitted.");
                redirect(base_url() . "index.php/home/index");
            }
        }
    }

    public function getPatta_no()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if (isset($_POST['mouza_pargona_code'])) {
            $mouza_pargona_code = $_POST['mouza_pargona_code'];
        } else {
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        }

        if (isset($_POST['lot_no'])) {
            $lot_no = $_POST['lot_no'];
        } else {
            $lot_no = $this->session->userdata('lot_no');
        }

        $village_id = $_POST['village_id'];
        $patta_type_code = $_POST['patta_type_code'];

        // Run the query
        $sql = "select patta_no from   chitha_basic where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no'  and vill_townprt_code='$village_id' and patta_type_code='$patta_type_code' group by patta_no order by patta_no";
        $query = $this->db->query($sql);

        // Extract just the patta_no values into an array
        $patta_nos = [];
        foreach ($query->result() as $row) {
            $patta_nos[] = $row->patta_no;
        }

        // Return the array as JSON
        header('Content-Type: application/json');
        echo json_encode($patta_nos);
    }

    public function getAvailDags()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if (isset($_POST['mouza_pargona_code'])) {
            $mouza_pargona_code = $_POST['mouza_pargona_code'];
        } else {
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        }

        if (isset($_POST['lot_no'])) {
            $lot_no = $_POST['lot_no'];
        } else {
            $lot_no = $this->session->userdata('lot_no');
        }

        $village_id = $_POST['village_id'];
        $patta_type_code = $_POST['patta_type_code'];
        $patta_no = $_POST['patta_no'];
        // return $this->APCancellationModel->getAvailDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_id, $patta_no, $patta_type_code);
        // echo("select dag_no from chitha_basic where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and  lot_no='$lot_no' and vill_townprt_code='$village_id' and patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'");die;
        $sql = "select dag_no from chitha_basic where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and  lot_no='$lot_no' and vill_townprt_code='$village_id' and patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'";
        $query = $this->db->query($sql);
        $dag_nos = [];
        foreach ($query->result() as $row) {
            $dag_nos[] = $row->dag_no;
        }

        // Return the array as JSON
        header('Content-Type: application/json');
        echo json_encode($dag_nos);
    }

    public function getPdarName()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');


        if (isset($_POST['mouza_pargona_code'])) {
            $mouza_pargona_code = $_POST['mouza_pargona_code'];
        } else {
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        }

        if (isset($_POST['lot_no'])) {
            $lot_no = $_POST['lot_no'];
        } else {
            $lot_no = $this->session->userdata('lot_no');
        }

        $village_id = $_POST['village_id'];
        $patta_type_code = $_POST['patta_type_code'];
        $patta_no = $_POST['patta_no'];
        $dag_no = $_POST['APC_dag_no'];

        // return $this->APCancellationModel->getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $case_no);

        $sql = "select cp.pdar_id, cp.pdar_name, cp.pdar_father, cp.pdar_add1, cp.pdar_add2,cp.pdar_guard_reln from   chitha_dag_pattadar AS cdp JOIN  chitha_pattadar AS cp ON cdp.dist_code=cp.dist_code and cdp.subdiv_code=cp.subdiv_code and cdp.cir_code=cp.cir_code and cdp.mouza_pargona_code=cp.mouza_pargona_code and  cdp.lot_no=cp.lot_no and cdp.vill_townprt_code=cp.vill_townprt_code and TRIM(cdp.patta_no)=TRIM(cp.patta_no) and  cdp.patta_type_code=cp.patta_type_code  and cdp.pdar_id=cp.pdar_id where cdp.dist_code ='$dist_code'  and  cdp.subdiv_code='$subdiv_code' and cdp.cir_code='$cir_code' and  cdp.mouza_pargona_code='$mouza_pargona_code' and  cdp.lot_no='$lot_no' and cdp.vill_townprt_code='$village_id' and  cdp.dag_no='$dag_no' and TRIM(cdp.patta_no)='$patta_no' and cdp.patta_type_code='$patta_type_code' ";
        $query = $this->db->query($sql);
        // $pdar_info = [];
        // foreach ($query->result() as $row) {
        //     $pdar_info[] = $row;

        // }

        $pdar_info = [];
        foreach ($query->result() as $row) {
            $pdar_info[] = [
                'pdar_name' => $row->pdar_name,
                'pdar_father' => $row->pdar_father,
                'pdar_add1' => $row->pdar_add1,
                'pdar_add2' => $row->pdar_add2,
                'pdar_guard_reln' => $this->utilityclass->get_relation($row->pdar_guard_reln), //$this->utilityclass->get_relation($pdar->pdar_guard_reln)
            ];
        }


        // Return the array as JSON
        header('Content-Type: application/json');
        echo json_encode($pdar_info);
    }

    //LM Report on AST's petition
    //###################################################################################################
    //LM SUO-MOTO coding starts here
    public function LMAPStep1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        $this->load->model('mutation/mutationmodel');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $district['dist']  = $this->MisModel->getDistrictName($dist_code);
        $district['subdiv']  = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $district['circle']  = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        //$district['mouzalist']  = $this->MisModel->getMouzaList($dist_code,$subdiv_code,$cir_code);

        $district['mouza']  = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $district['lot']  = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $district['villagelist']  = $this->MisModel->getVillageList($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        // $this->load->view('../views/APCancellation/LMAPStep1', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'APCancellation/LMAPStep1';
        $this->load->view('layouts/main', $district);

        if (isset($_POST['ASTSTEP1Submit'])) {

            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');

            $locationData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code,
            );
            $this->session->set_userdata($locationData);

            //redirect the page into next step
            redirect(base_url() . "index.php/APCancellation/LMAPStep2");
        }
    }

    public function LMAPStep2()
    {
        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');

        //generate year and pettition no 
        $year = year_no;
        $month = date("m");

        //Case no generation starts here
        //        $sql = "SELECT MAX(petition_no) AS petition_no From apcancel_petition_basic WHERE mut_type='0504' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
        //                . " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and submission_date <='$submission_date' ";

        //       $sql = "SELECT max(petition_no)+1 AS petition_no From  apcancel_petition_basic where dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
        // $petition=$this->db->query($sql)->row()->petition_no;
        // if($petition==null){
        //  $petition=1;
        // }

        //       $sql = "SELECT count(petition_no)+1 AS petition_no From  apcancel_petition_basic where dist_code='$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$year' ";

        //       $result = $this->db->query($sql);
        //       $res = $result->row();
        //       //generate petition no
        //       $petition_no=$res->petition_no;
        //       //generate petition no
        // if($petition_no==null){
        //  $petition_no=1;
        // }
        // $q="Select dist_abbr,cir_abbr from   location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        // $abbrname=$this->db->query($q)->row();
        // $cir_dist_name=$abbrname->dist_abbr."/".$abbrname->cir_abbr;
        // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        //       $caseNo = $cir_dist_name . "/" . $financialyeardate ."/". $petition_no ."/NR/SM";
        //Case no generation 
        $case_name = $this->basundharamodel->genearteCaseName();
        $petition = $this->basundharamodel->genearteApcancelPetitionNo();
        $caseNo = $case_name . $petition . "/NR/SM";

        //find the Circle Officer for the mentioned data
        $data['coname'] = $this->APCancellationModel->getCOName($dist_code, $subdiv_code, $cir_code);
        //find eksona patta
        $data['eksonapatta'] = $this->APCancellationModel->getEksonaPatta();
        //search availabe eksona patta in the desired location
        $data['AvilLand'] = $this->APCancellationModel->checkAbilableEksonaLand($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        // $this->load->view('../views/APCancellation/LMAPStep2', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/LMAPStep2';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['ASTStep2Submit'])) {

            $mut_type = $this->input->post('mut_type');
            $submission_date = $this->input->post('submission_date');
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type_code = $this->input->post('patta_type_code');

            $patta_info = array(
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code
            );

            $this->session->set_userdata($patta_info);

            $add_off_name = $this->input->post('add_off_name');
            $add_off_Desig = $this->input->post('add_off_Desig');

            $checkavailpattatype = $this->APCancellationModel->checkavailpattatype($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code);

            if ($checkavailpattatype == 0) {
                echo '<script>alert("Opps..! Sorry you have choose a wrong patta no.");</script>';
                redirect('APCancellation/LMAPStep2', 'refresh');
            }
            $date = date("Y-m-d");
            $user = $this->session->userdata('user_code');
            $petition_basic = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => year_no,
                'petition_no' => $petition,
                'case_no' => $caseNo,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => $mut_type,
                'add_off_name' => $add_off_name,
                'add_off_desig' => $add_off_Desig,
                'status' => 'X',
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $this->session->set_userdata($petition_basic);

            $this->db->insert("apcancel_petition_basic", $petition_basic);
            log_message('error', $this->db->last_query());
            redirect(base_url() . "index.php/APCancellation/LMAPStep3");
        }
    }

    public function LMAPStep3()
    {
        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $year_no = year_no;
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');

        $countPetId['caseno'] = $case_no;

        $countPetId['relation'] = $this->APCancellationModel->getRelation();

        $countPetId['petid'] = $this->APCancellationModel->getCountPetId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);

        // $this->load->view('../views/APCancellation/LMAPStep3', $countPetId);
        // $this->load->view('../views/footer');

        $countPetId['_view'] = 'APCancellation/LMAPStep3';
        $this->load->view('layouts/main', $countPetId);

        //if the form is submitted
        if (isset($_POST['ASTStep3Submit'])) {
            $pet_id = $this->input->post('pet_id');
            $pet_name = $this->input->post('pet_name');
            $guard_name = $this->input->post('guard_name');
            $guard_rel = $this->input->post('guard_rel');
            $add1 = $this->input->post('add1');
            $add2 = $this->input->post('add2');
            $date = date("Y-m-d");
            $year_no = year_no;
            $user = $this->session->userdata('user_code');
            $petitioner_info = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'pet_id' => $pet_id,
                'pet_name' => $pet_name,
                'guard_name' => $guard_name,
                'guard_rel' => $guard_rel,
                'add1' => $add1,
                'add2' => $add2,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );
            $this->session->set_userdata($petitioner_info);
            $this->db->insert("apcancel_petitioner", $petitioner_info);
            log_message('error', $this->db->last_query());
            redirect(base_url() . "index.php/APCancellation/LMAPStep3");
        }
    }

    public function LMAPStep4()
    {
        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        //retrieve variable from   session

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type_code = $this->session->userdata('patta_type_code');

        $year_no = year_no;
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');

        $date = date("Y-m-d");

        $dags = $this->APCancellationModel->getAvailDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code);

        $data['dags'] = $dags;
        //retrieve case no from   session variable
        $case_no = $this->session->userdata('case_no');
        $data['caseno'] = $case_no;
        $user = $this->session->userdata('user_code');

        // $this->load->view('../views/APCancellation/LMAPStep4', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/LMAPStep4';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['dagNoSubmit'])) {
            $dag_no = trim($_POST['dag_no']);

            $CancelDag_info = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );
            $this->session->set_userdata($CancelDag_info);

            $this->db->insert(" apcancel_dag_details", $CancelDag_info);

            redirect(base_url() . "index.php/APCancellation/LMAPStep5");
        }
    }

    public function LMAPStep5()
    {

        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type_code = $this->session->userdata('patta_type_code');

        $dag_no = $this->session->userdata('dag_no');

        $year_no = year_no;

        $petition_no = $this->session->userdata('petition_no');

        $case_no = $this->session->userdata('case_no');

        $mut_type = $this->session->userdata('mut_type');
        $date = date("Y-m-d");

        $data['caseno'] = $case_no;

        $countPdarId = $this->APCancellationModel->getCountPdarId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $dag_no, $case_no, $patta_no, $patta_type_code);

        $data['pdar_id'] = $countPdarId;
        //get pattadar names from   chitha dag pattadar

        $PdarName = $this->APCancellationModel->getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $dag_no, $patta_no, $patta_type_code, $case_no);
        $data['pdar_info'] = $PdarName;

        // $this->load->view('../views/APCancellation/LMAPStep5', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/LMAPStep5';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['ASTStep5Submit'])) {

            $pattadar_no = $_POST['pattadar_no'];
            $pattadar = $_POST['pattadar'];


            $pdar_id = intval($pattadar);
            $p = explode("#", $pattadar);
            $pdar_name = $p['1'];

            $pdar_father = $_POST['pdar_father'];
            $pdar_guard_reln = $_POST['pdar_guard_reln'];
            $pdar_add1 = $_POST['pdar_add1'];
            $pdar_add2 = $_POST['pdar_add2'];
            $user = $this->session->userdata('user_code');
            $CancelDag_pattadar = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'pdar_cron_no' => $pattadar_no,
                'pdar_id' => $pdar_id,
                'pdar_name' => $pdar_name,
                'pdar_guardian' => $pdar_father,
                'pdar_rel_guar' => $pdar_guard_reln,
                'pdar_add1' => $pdar_add1,
                'pdar_add2' => $pdar_add2,
                'user_code' => $user,
                'date_entry' => $date,
                'operation' => 'E'
            );

            $this->session->set_userdata($CancelDag_pattadar);

            $this->db->insert(" apcancel_petition_pattadar", $CancelDag_pattadar);

            $sql = "update  apcancel_petition_basic set status='P' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . "year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'"
                . " and mut_type='$mut_type' ";

            $this->db->query($sql);
            redirect(base_url() . "index.php/home");
        }
    }

    //###################################################################################################
    //LM SUO-MOTO coding starts here

    public function SKAPStep1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/APCancellation/SKAPStep1/';

        //original link
        $data['countAPCase']  =  $this->APCancellationModel->getCountAPCasesforSK();
        //var_dump($data);
        $config['total_rows'] = count($data['countAPCase']);

        $config['per_page'] = 5;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->pagination->initialize($config);


        $cases['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforSK1($config["per_page"], $page)->result();

        //$cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page)->result();

        $case_array = array();

        foreach ($cases['countAPCaseforCO'] as $c) {

            $q = $this->db->query("select submission_date, case_no, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, year_no, petition_no  from   apcancel_petition_basic "
                . " where status='P' and lm_note_yn='Y' and sk_note_yn is null")->row();

            array_push($case_array, $c);
        }

        //var_dump($case_array);
        $data['countAPCaseforSK'] = $case_array;


        //$data['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK();

        // $this->load->view('../views/APCancellation/SKAPStep1', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/SKAPStep1';
        $this->load->view('layouts/main', $data);
    }

    public function SKAPStep2()
    {

        $data['_view'] = 'APCancellation/SKAPStep2';
        $this->load->view('layouts/main', $data);

        if (isset($_POST['FormSubmit'])) {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_townprt_code');

            $submission_date = $this->input->post('submission_date');
            $user = $this->session->userdata('user_code');

            $year_no = $this->input->post('year_no');
            $petition_no = $this->input->post('petition_no');
            $case_no = $this->input->post('case_no');
            $sk_report = $this->input->post('sk_report');
            $date = date("Y-m-d");

            $this->load->library('form_validation');
            $this->form_validation->set_rules('sk_report', 'sk_report', 'required');
            if ($this->form_validation->run() == FALSE) {
                if (form_error('sk_report') != "") {
                    echo form_error('sk_report');
                    $this->form_validation->set_message('sk_report', 'SK report must be provided.');
                }

                redirect(base_url() . "index.php/APCancellation/SKAPStep2?submission_date=$submission_date&dist_code=$dist_code&subdiv_code=$subdiv_code&cir_code=$cir_code&mouza_pargona_code=$mouza_pargona_code&lot_no=$lot_no&vill_townprt_code=$vill_code&year_no=$year_no&petition_no=$petition_no&case_no=$case_no");
                return;
            }

            $this->db->trans_begin();
            if (!empty($_FILES['documents'])) {
                $i = 0;
                $count = 1;
                foreach ($_FILES['documents']['name'] as $index => $fileData) {
                    $filename = $_FILES['documents']['name'][$index]['file'];
                    $filetype = $_FILES['documents']['type'][$index]['file'];
                    $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                    $error    = $_FILES['documents']['error'][$index]['file'];
                    $filesize = $_FILES['documents']['size'][$index]['file'];
                    $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'SK report';
                    $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $finalName = $file . '.' . $ext;

                    // Create proper $_FILES['file'] array just for this file
                    $_FILES['file'] = [
                        'name' => $finalName,
                        'type' => $filetype,
                        'tmp_name' => $tmpname,
                        'error' => $error,
                        'size' => $filesize
                    ];

                    // Create folder if not exists
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        $path = $folder;
                    } else {
                        $path = $folder;
                    }

                    $config = [
                        'upload_path' => $folder,
                        'allowed_types' => FILE_TYPE,
                        'max_size' => MAX_SIZE
                    ];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $data = $this->upload->data();
                        $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                        $img = [
                            'case_no' => $case_no,
                            'user_code' => $user,
                            'file_name' => $_POST['documents'][$i++]['name'],
                            'fetch_file_name' => $file . $data['file_ext'],
                            'file_type' => $data['file_type'],
                            'file_path' => $file_path,
                            'date_entry' => date('Y-m-d h:i:s'),
                            // 'mut_type' => $mut_type,
                            // 'dag_no' => $dag_no,
                        ];
                        $status = $this->db->insert('supportive_document', $img);
                        if (!$status) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRORSD001SK: Uploading insertion failed in supportive_document for case no :' . $case_no);

                            $json = [
                                'errorMessage' => "#ERRORSD001SK: AP Cancellation upload failed for Case No " . $case_no
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    } else {
                        echo $this->upload->display_errors();
                        log_message('error', '#ERRORUPLOAD001SK: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                    }
                }
            }

            $Updatesql1 = "update  apcancel_petition_lm_note set sk_note='$sk_report', sk_note_date='$date' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";

            $status = $this->db->query($Updatesql1);
            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB002SK: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB002SK: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }

            $Updatesql = "update  apcancel_petition_basic set sk_note_yn='Y', sk_note_date='$date' where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";


            $status = $this->db->query($Updatesql);
            if (!$status) {
                $db_error = $this->db->_error_message();
                log_message('error', '#ERRDB003SK: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRDB003SK: AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
                return;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', 'AP cancellation transaction failed. Rolled back.');

                $this->session->set_flashdata('message', "AP cancellation transaction failed.");
                redirect(base_url() . "index.php/home/index");
            } else {
                $this->db->trans_commit();

                $this->Dashboard($case_no);
                $this->session->set_flashdata('message', "Registered Case no # $case_no");
                redirect(base_url() . "index.php/home/index");
            }

            // $penUser="CO";
            // $rmrk='SK submitted his Report';
            // $this->DashboardData($case_no,$penUser,$rmrk);
            // $this->session->set_flashdata('message',"Registered Case no # $case_no");
            // redirect(base_url() . "index.php/home/index");
        }
    }

    public function SKViewPetition()
    {
        //$db=  $this->session->userdata('db');
        //$this->load->helper('html');
        //$this->load->view('../views/header');

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        // $data['daginfo'] = $this->APCancellationModel->getDagInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $sql = $this->db->query("select dag_no,patta_no, patta_type_code from apcancel_dag_details where case_no='$case_no'");
        $data['daginfo'] = $sql->result();

        // $sql = $this->db->query("select file_name,file_path from supportive_document where case_no='$case_no'");
        // $data['documents']= $sql->result();
        $sql = $this->db->query("select file_name,file_path from supportive_document where case_no='$case_no' order by date_entry,id");
        $doc_result = $sql->result();
        foreach ($doc_result as $doc) {
            $doc->file_path = $this->physical_path_to_url($doc->file_path);
        }
        $data['documents'] = $doc_result;

        $data['pattadars'] = $this->APCancellationModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        //$this->load->view('../views/APCancellation/LMViewPetition', $data);
        //$this->load->view('../views/footer');


        $data['_view'] = 'APCancellation/LMViewPetition';
        $this->load->view('layouts/main', $data);
    }

    public function LMNoteView_by_SK()
    {
        //$db=  $this->session->userdata('db');
        //$this->load->helper('html');
        //$this->load->view('../views/header');
        $data = array();
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['lmreport'] = $this->APCancellationModel->getLMReport($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        //$this->load->view('../views/APCancellation/LMNoteView_by_SK', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/LMNoteView_by_SK';
        $this->load->view('layouts/main', $data);
    }

    public function COAPStep1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        //echo base_url();
        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/APCancellation/COAPStep1/';

        //original link
        $data['countAPCaseforCO']  = $this->APCancellationModel->getCountAPCasesforCO();
        //var_dump($data);
        $config['total_rows'] = count($data['countAPCaseforCO']);

        $config['per_page'] = 5;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->pagination->initialize($config);


        $cases['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO1()->result();

        //$cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page)->result();

        $case_array = array();

        foreach ($cases['countAPCaseforCO'] as $c) {

            $q = $this->db->query("select distinct(t1.case_no),t2.patta_no,t2.dag_no, t1.submission_date,  t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no "
                . " from   apcancel_petition_basic AS t1 "
                . " JOIN  apcancel_petition_pattadar AS t2 ON t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code "
                . " and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no "
                . " where t1.status='P' and t1.lm_note_yn='Y' and t1.sk_note_yn='Y' and "
                . " t1.case_no NOT IN (select case_no from   apcancel_petition_proceeding)")->row();

            array_push($case_array, $c);
        }

        //var_dump($case_array);
        $cases['countAPCaseforCO'] = $case_array;

        // $this->load->view('../views/APCancellation/COAPStep1', $cases);
        // $this->load->view('../views/footer');

        $cases['_view'] = 'APCancellation/COAPStep1';
        $this->load->view('layouts/main', $cases);
    }

    public function COAPStep2()
    {


        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');

        $data['countAPCase'] = $this->APCancellationModel->getCountAPCaseCO($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);


        //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);


        $countAPCaseforSK = $this->APCancellationModel->getCountAPCasesforCO();
        $data['countAPCaseforCO'] = $countAPCaseforSK;

        $data['_view'] = 'APCancellation/COAPStep2';
        $this->load->view('layouts/main', $data);
    }

    public function COAPStep2_11()
    {

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $case_no = $this->input->post('case_no');
        $t1 = trim($this->input->post('t1'));
        $t2 = trim($this->input->post('t2'));
        $date_hearing1 = $this->input->post('date_hearing');
        $date_hearing = date("Y-m-d", strtotime($date_hearing1));
        $co_order = $t1 . " " . $date_hearing . " " . $t2;
        $date = date("Y-m-d");
        $user = $this->session->userdata('user_code');
        $COData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'case_no' => $case_no,
            'proceeding_id' => 1, //now only one, if multiple keep in a session and increment after entry
            'co_order' => $co_order,
            'date_hearing' => $date_hearing,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => $date,
            'operation' => 'E'
        );
        $this->db->trans_begin();
        $status = $this->db->insert("apcancel_petition_proceeding", $COData);
        if (!$status) {
            $db_error = $this->db->_error_message();
            log_message('error', '#ERRDB001CO: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRDB001CO: AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
            return;
        }

        if (!empty($_FILES['documents'])) {
            $i = 0;
            $count = 1;
            foreach ($_FILES['documents']['name'] as $index => $fileData) {
                $filename = $_FILES['documents']['name'][$index]['file'];
                $filetype = $_FILES['documents']['type'][$index]['file'];
                $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                $error    = $_FILES['documents']['error'][$index]['file'];
                $filesize = $_FILES['documents']['size'][$index]['file'];
                $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'CO report';
                $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalName = $file . '.' . $ext;

                // Create proper $_FILES['file'] array just for this file
                $_FILES['file'] = [
                    'name' => $finalName,
                    'type' => $filetype,
                    'tmp_name' => $tmpname,
                    'error' => $error,
                    'size' => $filesize
                ];

                // Create folder if not exists
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    $path = $folder;
                } else {
                    $path = $folder;
                }

                $config = [
                    'upload_path' => $folder,
                    'allowed_types' => FILE_TYPE,
                    'max_size' => MAX_SIZE
                ];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                    $img = [
                        'case_no' => $case_no,
                        'user_code' => $user,
                        'file_name' => $_POST['documents'][$i++]['name'],
                        'fetch_file_name' => $file . $data['file_ext'],
                        'file_type' => $data['file_type'],
                        'file_path' => $file_path, //$path.$file.$data['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                    ];
                    $status = $this->db->insert('supportive_document', $img);
                    if (!$status) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORSD001CO: Uploading insertion failed in supportive_document for case no :' . $case_no);

                        $json = [
                            'errorMessage' => "#ERRORSD001CO: AP Cancellation upload failed for Case No " . $case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                } else {
                    echo $this->upload->display_errors();
                    log_message('error', '#ERRORUPLOAD001CO: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                }
            }
        }

        $Updatesql = "update  apcancel_petition_basic set not_fresh='Y',next_date_of_hearing='$date_hearing'  where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . " mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
            . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";
        $status = $this->db->query($Updatesql);
        if (!$status) {
            $db_error = $this->db->_error_message();
            log_message('error', '#ERRDB003CO: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRDB003CO: AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
            return;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'AP cancellation transaction failed. Rolled back.');

            $this->session->set_flashdata('message', "AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
        } else {
            $this->db->trans_commit();

            $this->Dashboard($case_no);
            $this->session->set_flashdata('message', "Notice has been served for Case Number $case_no.");
            redirect(base_url() . "index.php/home/index");
        }

        // $penUser="AST";
        // $rmrk='Notice has been served';
        // $this->DashboardData($case_no,$penUser,$rmrk);
        // redirect(base_url() . "index.php/home/index?msg=success");
    }


    public function SKNoteView_by_CO()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        $data = array();
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['sk_note'] = $this->APCancellationModel->getSKReport($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        // $this->load->view('../views/APCancellation/SKNoteView_by_CO', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/SKNoteView_by_CO';
        $this->load->view('layouts/main', $data);
    }

    //for CO second step 
    public function COAPStep2_1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        //original link
        $data['countNoteHearingAPCaseforCO']  = $this->APCancellationModel->getNoteHearingAPCasesforCO();
        $cases['countAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO1()->result();
        $case_array = array();
        foreach ($cases['countAPCaseforCO'] as $c) {

            $q = $this->db->query("select t1.next_date_of_hearing,t1.submission_date, t1.case_no, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no from   apcancel_petition_basic AS t1 where  t1.notice_generated_yn='Y' and (t1.co_recommendation_yn!='Y' or t1.co_recommendation_yn is null ) ")->row();

            array_push($case_array, $c);
        }

        $cases['countNoteHearingAPCaseforCO'] = $case_array;
        // $this->load->view('../views/APCancellation/COAPStep2_1', $cases);
        // $this->load->view('../views/footer');

        $cases['_view'] = 'APCancellation/COAPStep2_1';
        $this->load->view('layouts/main', $cases);
    }


    public function CO1stProceeding()
    {
        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        //$this->load->view('../views/header');
        $data = array();
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['co1stproceeding'] = $this->APCancellationModel->getco1stproceeding($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //var_dump($data);
        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        // $this->load->view('../views/APCancellation/CO1stProceeding', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'APCancellation/CO1stProceeding';
        $this->load->view('layouts/main', $data);
    }


    public function COAPStep2_2()
    {

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');

        $data['countAPCase'] = $this->APCancellationModel->getCountAPCaseCO2ndStep($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $data['countAPCaseforCO']  = $this->APCancellationModel->getCountAPCasesforCO();


        $data['countNoteHearingAPCaseforCO']  = $this->APCancellationModel->getNoteHearingAPCasesforCO();

        $data['_view'] = 'APCancellation/COAPStep2_2';
        $this->load->view('layouts/main', $data);


        //        if (isset($_POST['FormSubmit'])) {
        //            
        //        }


    }

    public function COAPStep2_21()
    {
        //$db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $submission_date = $this->input->post('submission_date');
        $case_no = $this->input->post('case_no');
        $note_on_order = $this->input->post('note_on_order');
        $next_hearing_date = date('Y-m-d', strtotime($this->input->post('date_of_hearing')));
        $user = $this->session->userdata('user_code');
        //should be added some extra features

        $co_recommendation_yn = $this->input->post('co_recommendation');
        $send_dc_adc = $this->input->post('send_dc_adc');



        $this->load->library('form_validation');
        $this->form_validation->set_rules('note_on_order', 'note_on_order', 'required');
        $this->form_validation->set_rules('date_of_hearing', 'date_of_hearing', 'required');
        if ($this->form_validation->run() == FALSE) {
            if (form_error('note_on_order') != "") {
                echo form_error('note_on_order');
                $this->form_validation->set_message('note_on_order', 'CO\'s Note on Hearing must be provided.');
            }
            if (form_error('date_of_hearing') != "") {
                echo form_error('date_of_hearing');
                $this->form_validation->set_message('date_of_hearing', 'Date of Hearing must be provided.');
            }

            redirect(base_url() . "index.php/APCancellation/COAPStep2_2?submission_date=$submission_date&dist_code=$dist_code&subdiv_code=$subdiv_code&cir_code=$cir_code&mouza_pargona_code=$mouza_pargona_code&lot_no=$lot_no&vill_townprt_code=$vill_code&year_no=$year_no&petition_no=$petition_no&case_no=$case_no");
            return;
        }

        if ($send_dc_adc == 'Y') {
            $co_recommendation_yn = $this->input->post('co_recommendation');
            ///////////////////////////////////////
            $penUser = 'ADC';
            $rmrk = "Forwrded to ADC/DC by CO";
            $this->DashboardData($case_no, $penUser, $rmrk);
        } else {
            $co_recommendation_yn = null;
            /////////////////////////////////////
            $penUser = 'CO';
            $rmrk = "Notice Served by CO.";
            $this->DashboardData($case_no, $penUser, $rmrk);
        }
        //$co_recommendation_yn='Y';
        $co_recommendation_date = date("Y-m-d");

        $this->db->trans_begin();

        //if($co_recommendation=='yes'){
        $Updatesql1 = "update  apcancel_petition_basic set co_recommendation_yn='$co_recommendation_yn',next_date_of_hearing='$next_hearing_date', co_recommendation_date='$co_recommendation_date'  where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . " mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
            . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";

        $status = $this->db->query($Updatesql1);

        if (!$status) {
            $db_error = $this->db->_error_message();
            log_message('error', '#ERRDB001COS2: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRDB001COS2: AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
            return;
        }

        //}
        $q = "Select max(proceeding_id)+1 as id from   apcancel_petition_proceeding where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . " mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
            . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";
        $pro_id = $this->db->query($q)->row()->id;
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'petition_no' => $petition_no,
            'case_no' => $case_no,
            'year_no' => $year_no,
            'proceeding_id' => $pro_id,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date("Y-m-d"),
            'operation' => 'E',
            'co_order' => $note_on_order
        );
        $status = $this->db->insert("apcancel_petition_proceeding", $data);
        if (!$status) {
            $db_error = $this->db->_error_message();
            log_message('error', '#ERRDB002COS2: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRDB002COS2: AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
            return;
        }

        if (!empty($_FILES['documents'])) {
            $i = 0;
            $count = 1;
            foreach ($_FILES['documents']['name'] as $index => $fileData) {
                $filename = $_FILES['documents']['name'][$index]['file'];
                $filetype = $_FILES['documents']['type'][$index]['file'];
                $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                $error    = $_FILES['documents']['error'][$index]['file'];
                $filesize = $_FILES['documents']['size'][$index]['file'];
                $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'CO Hearing Note';
                $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalName = $file . '.' . $ext;

                // Create proper $_FILES['file'] array just for this file
                $_FILES['file'] = [
                    'name' => $finalName,
                    'type' => $filetype,
                    'tmp_name' => $tmpname,
                    'error' => $error,
                    'size' => $filesize
                ];

                // Create folder if not exists
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    $path = $folder;
                } else {
                    $path = $folder;
                }

                $config = [
                    'upload_path' => $folder,
                    'allowed_types' => FILE_TYPE,
                    'max_size' => MAX_SIZE
                ];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                    $img = [
                        'case_no' => $case_no,
                        'user_code' => $user,
                        'file_name' => $_POST['documents'][$i++]['name'],
                        'fetch_file_name' => $file . $data['file_ext'],
                        'file_type' => $data['file_type'],
                        'file_path' => $file_path, //$path.$file.$data['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                    ];
                    $status = $this->db->insert('supportive_document', $img);
                    if (!$status) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORSD001COS2: Uploading insertion failed in supportive_document for case no :' . $case_no);

                        $json = [
                            'errorMessage' => "#ERRORSD001COS2: AP Cancellation upload failed for Case No " . $case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    // You can save $uploadData['file_name'], $uploadData['full_path'], etc.
                } else {
                    echo $this->upload->display_errors();
                    log_message('error', '#ERRORUPLOAD001COS2: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                }
            }
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'AP cancellation transaction failed. Rolled back.');

            $this->session->set_flashdata('message', "AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
        } else {
            $this->db->trans_commit();

            $this->Dashboard($case_no);
            $this->session->set_flashdata('message', "Annual Patta Cancellation Order Status change Successfully !!");
            redirect(base_url() . "index.php/home/index");
        }




        // $this->session->set_flashdata('message', 'Annual Patta Cancellation Order Status change Successfully !!');
        // redirect(base_url() . "index.php/home/index?msg=success");
    }


    public function ASTAPShowCauseStep1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        ////pagination ends here
        $this->load->library('pagination');
        $config['base_url'] = base_url() . '/index.php/APCancellation/ASTAPShowCauseStep1/';
        //original link
        $data['APCaseShowCause']  = $this->APCancellationModel->countAPCaseShowCauseForAST();

        $config['total_rows'] = count($data['APCaseShowCause']);

        $config['per_page'] = 5;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->pagination->initialize($config);


        $cases['ShowCause'] = $this->APCancellationModel->countAPCaseShowCauseForAST1($config["per_page"], $page)->result();

        //$cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page)->result();

        $case_array = array();

        foreach ($cases['ShowCause'] as $c) {

            $q = $this->db->query("select t1.date_hearing, t1.case_no, t1.dist_code, t1.subdiv_code, t1.cir_code, t1.mouza_pargona_code, t1.lot_no, t1.vill_townprt_code, t1.year_no, t1.petition_no "
                . " from   apcancel_petition_proceeding AS t1 JOIN  apcancel_petition_basic AS t2 ON"
                . " t1.dist_code=t2.dist_code and t1.subdiv_code=t2.subdiv_code and t1.cir_code=t2.cir_code and t1.mouza_pargona_code=t2.mouza_pargona_code and "
                . " t1.lot_no=t2.lot_no and t1.vill_townprt_code=t2.vill_townprt_code and t1.case_no=t2.case_no and t1.year_no=t2.year_no"
                . " and t1.petition_no=t2.petition_no"
                . " where t2.notice_generated_yn is null and t1.co_order is not null and t1.note_on_order is null")->row();

            array_push($case_array, $c);
        }

        //var_dump($case_array);
        $data['countAPCaseShowCauseForAST'] = $case_array;
        //pagination ends here

        //$data['countAPCaseShowCauseForAST']=$this->APCancellationModel->countAPCaseShowCauseForAST(); 

        // $this->load->view('../views/APCancellation/ASTAPShowCauseStep1', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/ASTAPShowCauseStep1';
        $this->load->view('layouts/main', $data);
    }
    public function ASTAPShowCauseStep2()
    {

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $date_hearing = $this->input->get('date_hearing');
        $date = date("Y-m-d");

        $this->load->model('misreport/MisModel');
        $data['circlename'] = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $APCaseShowCauseAST = $this->APCancellationModel->getAPCaseShowCauseAST($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no, $date_hearing);
        $data['APCaseShowCauseAST'] = $APCaseShowCauseAST;

        $this->db->trans_begin();
        $Updatesql = "update  apcancel_petition_basic set notice_generated_yn='Y', notice_generated_date='$date'  where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . " mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
            . " petition_no='$petition_no' and case_no='$case_no'";


        $status = $this->db->query($Updatesql);
        if (!$status) {
            $db_error = $this->db->_error_message();
            log_message('error', '#ERRDB001ASTSC: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());

            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRDB001ASTSC: AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $this->db->trans_commit();
        $penUser = "CO";
        $rmrk = 'Notice issued by Assistant';
        $this->DashboardData($case_no, $penUser, $rmrk);
        /////////////////////////

        $q = "SElect add_off_name from   apcancel_petition_basic where subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' ";
        $co_name = $this->db->query($q)->row();

        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $co_name->add_off_name);
        $data['location'] = array(
            'co_name' => $co->username
        );

        $html = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>AP Cancellation Order</title>
        </head>
        <body>
            <div>";
        $html .= "<p style='text-align: center;'><span style='font-size:30px'>অসম চৰকাৰ</span> <br>চক্র বিষয়াৰ কাৰ্যালয়, পলাশবাৰী</p><hr/>
            <p>প্ৰতি  মাননীয়,</p>";
        foreach ($APCaseShowCauseAST as $pdar) {
            // Example data print — adjust as needed
            $html .= "<p style='padding-left:40px;'><span style='color: green;'>{$pdar->pdar_name}</span>,
                {$pdar->pdar_guardian}<br>
                {$pdar->pdar_add1}
            </p>";
            $dag_no = $pdar->dag_no;
            $patta_no = $pdar->patta_no;
        }
        $html .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;এই পাট্টাদ্বাৰৰ পাট্টা  <span style='color: red;'>( দাগ নং :  " . $this->utilityclass->cassnum($dag_no) . "   / পাট্টা নং : " . $this->utilityclass->cassnum($patta_no) . ")</span> বাতিল কৰা উচিত হয় নে নহয় সাপেক্ষে  <strong style='color: red;'><b>" . $case_no . "</b></strong> নং গোচৰৰ  মতে কাৰণ দৰ্শোৱাৰ জাননী জাৰী কৰা হ`ল | পৰবৰ্তী শুনানিৰ তাৰিখ " . $this->utilityclass->cassnum(date('d-m-Y', strtotime($_GET['date_hearing']))) . " নিৰ্ধাৰিত কৰা হল |</p>";

        $html .= "<div ><p style='text-align: right;'><span >হিমাদ্ৰী বৰা <br>পলাশবাৰী , চক্র বিষয়া <br></span></p>";

        $html .= "</div></div>
        </body>
        </html>";



        $folder = UPLOAD_BASE . 'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'Pattadar Showcause Notice' . UPLOAD_SEPARATOR;
        $file = 'APCancellation_order_' . date('Y_m_d_h_i_s') . '.pdf';
        $this->genaratePDF($folder, $file, $html, 'AP Cancellation');

        // redirect(base_url('index.php/APCancellation/ASTAPShowCauseStep1'));

        $data['_view'] = 'APCancellation/ASTAPShowCauseStep2';
        $this->load->view('layouts/main', $data);
    }

    public function COAPStep3_1()
    {
        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $data['getGiveRecommendationforCO'] = $this->APCancellationModel->getGiveRecommendationforCO();
        // $this->load->view('../views/APCancellation/COAPStep3_1', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'APCancellation/COAPStep3_1';
        $this->load->view('layouts/main', $data);
    }
    public function COAPStep3_2()
    {
        $db =  $this->session->userdata('db');
        //$this->load->helper('html');
        //$this->load->view('../views/header');

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        // $data['daginfo'] = $this->APCancellationModel->getDagInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);
        $sql = $this->db->query("select dag_no,patta_no, patta_type_code from apcancel_dag_details where case_no='$case_no'");
        $data['daginfo'] = $sql->result();

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        //$this->load->view('../views/APCancellation/COAPStep3_2', $data);
        //$this->load->view('../views/footer');
        $data['_view'] = 'APCancellation/COAPStep3_2';
        $this->load->view('layouts/main', $data);
    }
    public function SAveCOAPStep3_2()
    {
        $db =  $this->session->userdata('db');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');

        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $case_no = $this->input->post('case_no');
        $co_recommendation = $this->input->post('co_recommendation');

        $co_recommendation_yn = 'Y';
        $co_recommendation_date = date("Y-m-d");

        if ($co_recommendation == 1) {
            $Updatesql = "update  apcancel_petition_basic set co_recommendation_yn='$co_recommendation_yn', co_recommendation_date='$co_recommendation_date'  where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";

            $this->db->query($Updatesql);

            redirect(base_url() . "index.php/home/index?msg=success");
        } else {
            redirect(base_url() . "index.php/home/index");
        }
    }

    public function CONoteOfHearing()
    {
        $db =  $this->session->userdata('db');
        //$this->load->helper('html');
        //$this->load->view('../views/header');
        $data = array();
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['note_on_order'] = $this->APCancellationModel->getCONoteOfHearing($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        //$this->load->view('../views/APCancellation/CONoteOfHearing', $data);
        //$this->load->view('../views/footer');
        $data['_view'] = 'APCancellation/CONoteOfHearing';
        $this->load->view('layouts/main', $data);
    }



    public function COAPStep4_1()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/APCancellation/COAPStep4_1/';

        //original link
        $data['getOrderAPCancellation']  = $this->APCancellationModel->getOrderAPCancellation();
        //var_dump($data);
        $config['total_rows'] = count($data['getOrderAPCancellation']);

        $config['per_page'] = 25;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->pagination->initialize($config);


        $cases['getOrderAPCancellation1'] = $this->APCancellationModel->getOrderAPCancellation1($config["per_page"], $page)->result();
        //$cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page)->result();

        $case_array = array();

        foreach ($cases['getOrderAPCancellation1'] as $c) {

            $q = $this->db->query("select * from   apcancel_petition_basic AS t1 JOIN apcancel_petition_proceeding AS t2 ON t1.case_no=t2.case_no where t1.not_fresh='Y' and t1.status='P' and t1.lm_note_yn='Y'"
                . " and t1.notice_generated_yn='Y' and t1.co_recommendation_yn='Y' "
                . "and t1.dc_approval_yn='Y' and  t1.order_passed is null")->row();

            array_push($case_array, $c);
        }

        //var_dump($case_array);
        $cases['getOrderAPCancellation'] = $case_array;

        //$data['getOrderAPCancellation']=$this->APCancellationModel->getOrderAPCancellation();
        // $this->load->view('../views/APCancellation/COAPStep4_1', $cases);
        // $this->load->view('../views/footer');


        $cases['_view'] = 'APCancellation/COAPStep4_1';
        $this->load->view('layouts/main', $cases);
    }

    public function COAPStep4_2()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        // $data['daginfo'] = $this->APCancellationModel->getDagInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);
        $sql = $this->db->query("select dag_no,patta_no, patta_type_code from apcancel_dag_details where case_no='$case_no'");
        $data['daginfo'] = $sql->result();

        $data['pattadars'] = $this->APCancellationModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        // $this->load->view('../views/APCancellation/COAPStep4_2', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/COAPStep4_2';
        $this->load->view('layouts/main', $data);
    }

    public function DCAPStep1()
    {
        //$db=  $this->session->userdata('db');
        //$this->load->helper('html');
        //$this->load->view('../views/header');


        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/APCancellation/DCAPStep1/';

        //original link
        $data['getDCAPCancellation']  = $this->APCancellationModel->getDCAPCancellationMatter();
        //var_dump($data);

        $cases['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter1()->result();

        //$cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page)->result();

        $case_array = array();

        foreach ($cases['getDCAPCancellation'] as $c) {

            $q = $this->db->query("SELECT t1.submission_date,t1.case_no,t1.dist_code,t1.subdiv_code,t1.cir_code,t1.mouza_pargona_code,t1.lot_no,t1.vill_townprt_code,t1.year_no, t1.petition_no FROM apcancel_petition_basic AS t1 WHERE  t1.not_fresh='Y' and t1.status='P' and t1.lm_note_yn='Y' and t1.notice_generated_yn='Y' and t1.co_recommendation_yn='Y' and t1.dc_approval_yn IS null")->row();

            array_push($case_array, $c);
        }

        //var_dump($case_array);
        $cases['getDCAPCancellation'] = $case_array;

        //$this->load->view('../views/APCancellation/DCAPStep1', $cases);
        //$this->load->view('../views/footer');


        $cases['_view'] = 'APCancellation/DCAPStep1';
        $this->load->view('layouts/main', $cases);
    }
    public function DCAPStep2()
    {

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        $data['DCAPCAse'] = $this->APCancellationModel->getCountAPCaseDC($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);


        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        // $data['daginfo'] = $this->APCancellationModel->getDagInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);
        $sql = $this->db->query("select dag_no,patta_no, patta_type_code from apcancel_dag_details where case_no='$case_no'");
        $data['daginfo'] = $sql->result();

        $data['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellation11($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $user_code = $this->session->userdata('user_code');


        $data['dc'] = $this->utilityclass->dcname($dist_code, $user_code);
        //$this->load->view('../views/APCancellation/DCAPStep2', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/DCAPStep2';
        $this->load->view('layouts/main', $data);
    }

    public function SaveDCAPSTep2()
    {
        $db =  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');

        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $case_no = $this->input->post('case_no');
        $t1 = trim($this->input->post('t1'));
        $t2 = trim($this->input->post('t2'));
        $r1 = addslashes($this->input->post('dc_remark'));
        $dcname = $this->input->post('dc_desig');

        $user = $this->session->userdata('user_code');



        $dc_recommendation = $this->input->post('dc_recommendation');
        $dc_approval_date = date("Y-m-d");
        if ($dc_recommendation == 'Y') {
            $dc_order = $t1 . " " . $dc_approval_date . " " . $t2;
            $remarks = $r1 . "-" . $dcname;

            $this->db->trans_begin();


            $Updatesql = "update  apcancel_petition_basic set dc_order='$dc_order',dc_approval_yn='$dc_recommendation', dc_approval_date='$dc_approval_date',dc_remarks='$remarks'  where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";
        } elseif ($dc_recommendation == 'N') {
            $dc_order = "নথি-পত্ৰ সঠিক নোহোৱাৰ বাবে এই গোচৰটোত সন্মতি নাই ।";
            $Updatesql = "update  apcancel_petition_basic set dc_order='$dc_order',dc_approval_yn='$dc_recommendation', dc_approval_date='$dc_approval_date'  where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . " mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and "
                . " year_no='$year_no' and petition_no='$petition_no' and case_no='$case_no'";
        }
        $status = $this->db->query($Updatesql);
        if (!$status) {
            $db_error = $this->db->_error_message();
            log_message('error', '#ERRDB003DC: ' . $db_error['message'] . ' | Query: ' . $this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRDB003DC: AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
            return;
        }

        if (!empty($_FILES['documents'])) {
            $i = 0;
            $count = 1;
            foreach ($_FILES['documents']['name'] as $index => $fileData) {
                $filename = $_FILES['documents']['name'][$index]['file'];
                $filetype = $_FILES['documents']['type'][$index]['file'];
                $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                $error    = $_FILES['documents']['error'][$index]['file'];
                $filesize = $_FILES['documents']['size'][$index]['file'];
                $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'DC Approval';
                $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalName = $file . '.' . $ext;

                // Create proper $_FILES['file'] array just for this file
                $_FILES['file'] = [
                    'name' => $finalName,
                    'type' => $filetype,
                    'tmp_name' => $tmpname,
                    'error' => $error,
                    'size' => $filesize
                ];

                // Create folder if not exists
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    $path = $folder;
                } else {
                    $path = $folder;
                }

                $config = [
                    'upload_path' => $folder,
                    'allowed_types' => FILE_TYPE,
                    'max_size' => MAX_SIZE
                ];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                    $img = [
                        'case_no' => $case_no,
                        'user_code' => $user,
                        'file_name' => $_POST['documents'][$i++]['name'],
                        'fetch_file_name' => $file . $data['file_ext'],
                        'file_type' => $data['file_type'],
                        'file_path' => $file_path, //$path.$file.$data['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $mut_type,
                        'dag_no' => $dag_no,
                    ];
                    $status = $this->db->insert('supportive_document', $img);
                    if (!$status) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORSD001DC: Uploading insertion failed in supportive_document for case no :' . $case_no);

                        $json = [
                            'errorMessage' => "#ERRORSD001DC: AP Cancellation upload failed for Case No " . $case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    // You can save $uploadData['file_name'], $uploadData['full_path'], etc.
                } else {
                    echo $this->upload->display_errors();
                    log_message('error', '#ERRORUPLOAD001DC: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'AP cancellation transaction failed. Rolled back.');

            $this->session->set_flashdata('message', "AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
        } else {
            $this->db->trans_commit();

            $this->Dashboard($case_no);
            $this->session->set_flashdata('message', "DC passed final order for Case Number $case_no.");
            redirect(base_url() . "index.php/home/index");
        }
        //////////////////////////
        // $penUser='CO';
        // $rmrk='DC passed final order';
        // $this->DashboardData($case_no,$penUser,$rmrk);
        // redirect(base_url() . "index.php/home/index?msg=success");

    }

    public function DCApprovalNote()
    {
        $db =  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = $this->input->get('year_no');
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');

        //find the land type
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['petitioninfo'] = $this->APCancellationModel->getPetinfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        $data['dc_order'] = $this->APCancellationModel->getDCNote($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no);

        //load the MisModel
        $this->load->model('misreport/MisModel');
        $data['locations'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        );

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        // $this->load->view('../views/APCancellation/DCApprovalNote', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'APCancellation/DCApprovalNote';
        $this->load->view('layouts/main', $data);
    }

    public function COApStep4_3()
    {

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no' => $dag_no,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'case_no' => $case_no
        );
        $data['mouza_pargona_code'] = $mouza_pargona_code;
        $data['lot_no'] = $lot_no;
        $data['vill_code'] = $vill_code;
        $data['year_no'] = $year_no;
        $data['petition_no'] = $petition_no;
        $data['dag_no'] = $dag_no;
        $data['orderNo'] = $this->APCancellationModel->getOrderNo();
        $data['case_no'] = $case_no;
        $data['landtype'] = $this->APCancellationModel->getLandTypeCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);

        $user_code = $this->session->userdata('user_code');
        $data['COList'] = $this->APCancellationModel->getCOList($dist_code, $subdiv_code, $cir_code, $user_code);

        $data['COName'] = $this->APCancellationModel->getCOIname($dist_code, $subdiv_code, $cir_code, $user_code);

        $lm = $this->db->query("Select user_code from   apcancel_petition_lm_note where case_no='$case_no'")->row();
        $name_of_lm = $this->db->query("Select * from   lm_code where lm_code = '$lm->user_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code = '$mouza_pargona_code'")->row();
        //echo "Select * from   lm_code where lm_code = '$lm->user_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code = '$mouza_pargona_code'";
        $data['LMList'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lm->user_code);


        $data['SKList'] = $this->APCancellationModel->getSKList($dist_code, $subdiv_code, $cir_code);

        $data['lmcodate'] = $this->APCancellationModel->getLMCODate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);
        $data['name_for_id'] = $this->APCancellationModel->getNameForID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no);

        $data['pattadars'] = $this->APCancellationModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);

        $sql = "select pdar_id,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from apcancel_petition_pattadar where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and  mouza_pargona_code='$mouza_pargona_code' and   lot_no='$lot_no' and vill_townprt_code='$vill_code' and  petition_no='$petition_no' and case_no='$case_no'";

        $data['pattadars']  = $this->db->query($sql)->result();
        $data['relation'] = $this->APCancellationModel->getRelation();
        //var_dump($data['lmcodate']);
        // $this->load->view('../views/APCancellation/COApStep4_3', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/COApStep4_3';
        $this->load->view('layouts/main', $data);
    }

    public function COAPStep4_4()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $user = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $dag_no = $this->input->post('dag_no');
        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $case_no = $this->input->post('case_no');
        $ord_no = $this->input->post('ord_no');
        $ord_date = $this->input->post('ord_date');
        $ord_type_code = $this->input->post('ord_type_code');
        $ord_passby_sign_yn = $this->input->post('ord_passby_sign_yn');
        $ord_on_gl_type = $this->input->post('ord_on_gl_type');
        $ord_passby_desig = $this->input->post('ord_passby_desig');
        $ord_ref_let_no = $this->input->post('ord_ref_let_no');
        $lm_code = $this->input->post('lm_code');
        $lm_sign = $this->input->post('lm_sign');
        $lm_sign_date = $this->input->post('lm_sign_date');
        $sk_code = $this->input->post('sk_code');
        $sk_sign = $this->input->post('sk_sign');
        $sk_sign_date =  $this->input->post('sk_sign_date');
        $co_code = $this->session->userdata('user_code');
        $co_sign = $this->input->post('co_sign');
        $co_sign_date =  $this->input->post('co_sign_date');
        $wrt1 = $this->input->post('wrt1');
        $wrt2 = $this->input->post('wrt2');
        $wrt3 = $this->input->post('wrt3');
        $wrt4 = $this->input->post('wrt4');
        $wrt5 = $this->input->post('wrt5');


        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no' => $dag_no,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'ord_no' => $ord_no,
            'ord_date' => $ord_date,
            'ord_type_code' => $ord_type_code,
            'case_no' => $case_no,
            'ord_on_gl_type' => '0', //$ord_on_gl_type,
            'ord_passby_sign_yn' => $ord_passby_sign_yn,
            'ord_passby_desig' => $ord_passby_desig,
            'ord_ref_let_no' => $ord_ref_let_no,
            'lm_code' => $lm_code,
            'lm_sign_yn' => $lm_sign,
            'lm_sign_date' => $lm_sign_date,
            'sk_code' => $sk_code,
            'sk_sign_yn' => $sk_sign,
            'sk_sign_date' => $sk_sign_date,
            'co_code' => $co_code,
            'co_sign_yn' => $co_sign,
            'co_ord_date' => $co_sign_date,
            'wrt_order1' => $wrt1,
            'wrt_order2' => $wrt2,
            'wrt_order3' => $wrt3,
            'wrt_order4' => $wrt4,
            'wrt_order5' => $wrt5,
            'order_passed' => 'Y',
            'iscorrected_rkg_date' => date('Y-m-d'),
            'date_of_order' => date('Y-m-d')
        );


        $this->db->trans_begin();
        $status = $this->db->insert('apt_chitha_rmk_ordbasic', $userata);
        if (!$status) {
            $this->db->trans_rollback();
            log_message('error', '#ERRORSD001COS2: Database error for case no :' . $case_no . $this->db->error()['message']);

            $json = [
                'errorMessage' => "#ERRORSD001COS2: Database error for Case No " . $case_no
            ];
            echo json_encode($json);
            return false;
        }

        for ($i = 0; $i < count($_POST['pdar_id']); $i++) {
            // $pdar_id = $_POST['pdar_id'][$i];
            if ($_POST['name_for_guar_relation'][$i] == "") {
                $_POST['name_for_guar_relation'][$i] = 'u';
            }

            $userata1 = array(
                'dist_code' => $dist_code,
                'subdiv_code' =>  $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => year_no,
                'petition_no' => $petition_no,
                'ord_no' => $ord_no,
                'ord_date' => $ord_date,
                'ord_ref_let_no' => $ord_ref_let_no,
                //put pdar_id for in place of name_for_id
                'name_for_id' =>  $_POST['pdar_id'][$i],
                'name_for' => $_POST['name_for'][$i], //$this->input->post('name_for'),
                'name_for_guardian' => $_POST['name_for_guardian'][$i], //$this->input->post('name_for_guardian'),
                'name_for_guar_relation' => $_POST['name_for_guar_relation'][$i], //$this->input->post('name_for_guar_relation'),
                'case_type_code' => $this->input->post('case_type_code'),
                //'name_for_land_code'=>'',
                'against_which_order' => $this->input->post('against_which_order'),
                'purpose' =>  $this->input->post('purpose'),
                'isfullconvert' => $this->input->post('conversation_type'),
                'name_for_land_b' => $this->input->post('name_for_land_b'),
                'name_for_land_k' => $this->input->post('name_for_land_k'),
                'name_for_land_lc' => $this->input->post('name_for_land_lc'),
                'name_for_land_g' => 0,
                'name_for_land_kr' => 0
            );
            $status = $this->db->insert("apt_chitha_rmk_other", $userata1);
            if (!$status) {
                $this->db->trans_rollback();
                log_message('error', '#ERRORSD002COS2: Database error for case no :' . $case_no);

                $json = [
                    'errorMessage' => "#ERRORSD002COS2: Database error for Case No " . $case_no
                ];
                echo json_encode($json);
                return false;
            }
        }


        if (!empty($_FILES['documents'])) {
            $i = 0;
            $count = 1;
            foreach ($_FILES['documents']['name'] as $index => $fileData) {
                $filename = $_FILES['documents']['name'][$index]['file'];
                $filetype = $_FILES['documents']['type'][$index]['file'];
                $tmpname  = $_FILES['documents']['tmp_name'][$index]['file'];
                $error    = $_FILES['documents']['error'][$index]['file'];
                $filesize = $_FILES['documents']['size'][$index]['file'];
                $folder = UPLOAD_BASE .  'AP_Cancellation' . UPLOAD_SEPARATOR . $dist_code . UPLOAD_SEPARATOR . str_replace('/', '_', $case_no) . UPLOAD_SEPARATOR . 'CO Final Report';
                $file = 'APC_' . date('Y_m_d_h_i_s') . "_$index";
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalName = $file . '.' . $ext;

                // Create proper $_FILES['file'] array just for this file
                $_FILES['file'] = [
                    'name' => $finalName,
                    'type' => $filetype,
                    'tmp_name' => $tmpname,
                    'error' => $error,
                    'size' => $filesize
                ];

                // Create folder if not exists
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    $path = $folder;
                } else {
                    $path = $folder;
                }

                $config = [
                    'upload_path' => $folder,
                    'allowed_types' => FILE_TYPE,
                    'max_size' => MAX_SIZE
                ];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $file_path = $folder . UPLOAD_SEPARATOR . $finalName;
                    $img = [
                        'case_no' => $case_no,
                        'user_code' => $user,
                        'file_name' => $_POST['documents'][$i++]['name'],
                        'fetch_file_name' => $file . $data['file_ext'],
                        'file_type' => $data['file_type'],
                        'file_path' => $file_path, //$path.$file.$data['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                    ];
                    $status = $this->db->insert('supportive_document', $img);
                    if (!$status) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORSD001DC: Uploading insertion failed in supportive_document for case no :' . $case_no);

                        $json = [
                            'errorMessage' => "#ERRORSD001DC: AP Cancellation upload failed for Case No " . $case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    // You can save $uploadData['file_name'], $uploadData['full_path'], etc.
                } else {
                    echo $this->upload->display_errors();
                    log_message('error', '#ERRORUPLOAD001DC: Uploading insertion failed in supportive_document for case no :' . $case_no . $this->upload->display_errors());
                }
            }
        }

        // $Updatesql = "update  apcancel_petition_basic set order_passed='Y'  where dist_code ='$dist_code'  and "
        //             . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
        //             . " mouza_pargona_code='$mouza_pargona_code' and "
        //             . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and petition_no='$petition_no' and case_no='$case_no'";

        // $status = $this->db->query($Updatesql);
        // if(!$status ){
        //     $this->db->trans_rollback();
        //     log_message('error', '#ERRORSD003COS2: Database error for case no :'. $case_no);

        //     $json = [
        //         'errorMessage'=>"#ERRORSD003COS2: Database error for Case No ".$case_no
        //     ];
        //     echo json_encode($json);
        //     return false;
        // }



        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'AP cancellation transaction failed. Rolled back.');

            $this->session->set_flashdata('message', "AP cancellation transaction failed.");
            redirect(base_url() . "index.php/home/index");
        } else {
            $this->db->trans_commit(); // All good

            redirect(base_url() . "index.php/APCancellation/COAPStep4_6_finish?mouza_pargona_code=$mouza_pargona_code&lot_no=$lot_no&vill_code=$vill_code&dag_no=$dag_no&petition_no=$petition_no&case_no=$case_no");
        }
    }

    public function COAPStep4_5()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_townprt_code');
        $dag_no = $this->session->userdata('dag_no');
        $year_no = year_no;
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');

        $data['name_for_id'] = $this->APCancellationModel->getNameForID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no);

        $data['relation'] = $this->APCancellationModel->getRelation();

        $data['pattadars'] = $this->APCancellationModel->getPattadars11($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);
        //var_dump($data['pattadars']);


        if (isset($_POST['formsubmit'])) {
            $userata = array(
                'dist_code' => $this->session->userdata('dist_code'),
                'subdiv_code' => $this->session->userdata('subdiv_code'),
                'cir_code' => $this->session->userdata('cir_code'),
                'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
                'lot_no' => $this->session->userdata('lot_no'),
                'vill_townprt_code' => $this->session->userdata('vill_townprt_code'),
                'dag_no' => $this->session->userdata('dag_no'),
                'year_no' => year_no,
                'petition_no' => $this->session->userdata('petition_no'),
                'ord_no' => $this->session->userdata('ord_no'),
                'ord_date' => $this->session->userdata('ord_date'),
                'ord_ref_let_no' => $this->session->userdata('ord_ref_let_no'),
                //put pdar_id for in place of name_for_id
                'name_for_id' =>  $this->input->post('pdar_id'),
                'name_for' => $this->input->post('name_for'),
                'name_for_guardian' => $this->input->post('name_for_guardian'),
                'name_for_guar_relation' => $this->input->post('name_for_guar_relation'),
                'case_type_code' => $this->input->post('case_type_code'),
                //'name_for_land_code'=>'',
                'against_which_order' => $this->input->post('against_which_order'),
                'purpose' => $this->input->post('purpose'),
                'isfullconvert' => $this->input->post('conversation_type'),
                'name_for_land_b' => $this->input->post('name_for_land_b'),
                'name_for_land_k' => $this->input->post('name_for_land_k'),
                'name_for_land_lc' => $this->input->post('name_for_land_lc'),
                'name_for_land_g' => 0,
                'name_for_land_kr' => 0
            );

            $this->session->set_userdata($userata);

            $this->db->insert("apt_chitha_rmk_other", $userata);

            redirect(base_url() . "index.php/APCancellation/COAPStep4_5");
            //var_dump($userata);
        }
        //use in the next step

        //var_dump($userata);


        // $this->load->view('../views/APCancellation/COApStep4_5', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/COApStep4_5';
        $this->load->view('layouts/main', $data);
    }

    public function COAPStep4_6_finish()
    {
        // $db=  $this->session->userdata('db');
        //     $this->load->helper('html');
        //     $this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('vill_code');
        $dag_no = $this->input->get('dag_no');
        $year_no = year_no;
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');

        $Updatesql = "update  apcancel_petition_basic set order_passed='Y'  where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . " mouza_pargona_code='$mouza_pargona_code' and "
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and petition_no='$petition_no' and case_no='$case_no'";
        $this->db->query($Updatesql);

        ////////////////
        $this->DashboardDataFinal($case_no);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $data['countAPCase'] = $this->APCancellationModel->getCountAPCaseCO2ndStep($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $year_no, $petition_no, $case_no);

        // $this->load->view('../views/APCancellation/COAPStep4_6_finish',$data);
        // $this->load->view('../views/footer');

        $data['case_no'] = $case_no;
        $data['_view'] = 'APCancellation/COAPStep4_6_finish';
        $this->load->view('layouts/main', $data);
    }

    public function updateChithaApCancel()
    {
        $db =  $this->session->userdata('db');
        $cntDag = 0;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $_GET['case_no'];

        $query = "select * from    apt_chitha_rmk_ordbasic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
         order_passed='Y' and iscorrected_inco is null";
        $apcanelData = $this->db->query($query)->result();
        foreach ($apcanelData as $d) { //Start of the FOR loop
            $case_no = $d->case_no;
            $patta_no_query = "select * from    apcancel_dag_details where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $patta_type_code = $this->db->query($patta_no_query)->row()->patta_type_code;
            $patta_no = $this->db->query($patta_no_query)->row()->patta_no;
            $dist_code = $this->db->query($patta_no_query)->row()->dist_code;
            $subdiv_code = $this->db->query($patta_no_query)->row()->subdiv_code;
            $cir_code = $this->db->query($patta_no_query)->row()->cir_code;
            $mouza_pargona_code = $this->db->query($patta_no_query)->row()->mouza_pargona_code;
            $lot_no = $this->db->query($patta_no_query)->row()->lot_no;
            $dag_no = $this->db->query($patta_no_query)->row()->dag_no;
            $vill_townprt_code = $this->db->query($patta_no_query)->row()->vill_townprt_code;
            $petition_no = $this->db->query($patta_no_query)->row()->petition_no;
            $d = date('Y-m-d G:i:s');
            $sqlCntDags = "SELECT count(dag_no) as cntdag from    chitha_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and
                vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)= trim('$patta_no') ";
            $cntDag = $this->db->query($sqlCntDags)->row();
            if ($cntDag->cntdag == 1) { //If Pdar ID is not exist in other DAG then form the SQL string with Pattadar IDs so that the same may be used for deletion.
                $this->NR_IfThereIsOnlyOneDagIn_A_Patta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $dag_no);
            } else if ($cntDag->cntdag > 1) {
                $this->NR_IfThereAreMoreDagsIn_A_Patta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $dag_no);
            }

            $to_govt_type = "update chitha_basic set patta_type_code='0209',patta_no='0',dag_revenue=0,dag_local_tax=0 "
                . "where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and dag_no='$dag_no' "
                . " ";
            $this->db->query($to_govt_type);

            $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code'";
            $rmk_type_hist_no = $this->db->query($q)->row()->c2;
            if ($rmk_type_hist_no == null) {
                $rmk_type_hist_no = 1;
            }
            $rmk_gen = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'lot_no' => $lot_no,
                'dag_no' => $dag_no,
                'rmk_type_code' => '09',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => 'DC',
                'operation' => 'E',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n'
            );
            $this->db->insert('chitha_rmk_gen', $rmk_gen);
            //var_dump($rmk_gen);
            $dt = date('Y-m-d');
            $update_apt_remark = "update apt_chitha_rmk_ordbasic set iscorrected_inco = 'Y',iscorrected_inco_date='$d' where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and petition_no=$petition_no ";

            $update_apt_basic = "update apcancel_petition_basic set co_chitha_corrected_yn = 'Y',co_chitha_corrected_date='$d' where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and petition_no=$petition_no ";
            $this->db->query($update_apt_remark);
            $this->db->query($update_apt_basic);
            $this->session->set_flashdata('message', "Chitha Updated for Annual Patta Cancellation");
            redirect(base_url() . "index.php/home");
        } //End of foreach Loop
    }

    public function ActionTakenRpt()
    {
        $db =  $this->session->userdata('db');
        set_time_limit(0);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $query = "select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
            . " and mut_type='03' and  date(date_entry)>='2017-02-21' order by date_entry desc";
        $data['partpetition'] = $this->db->query($query)->result();
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('comutation/actiontakenreportPart', $data);
        // $this->load->view('footer');
        $data['_view'] = 'comutation/actiontakenreportPart';
        $this->load->view('layouts/main', $data);
    }


    function RejectOrder()
    {
        $db =  $this->session->userdata('db');
        $case_no = $_GET['case_no'];
        $dist_code = $_GET['dist_code'];
        $subdiv_code = $_GET['subdiv_code'];
        $cir_code = $_GET['cir_code'];
        $data['basic'] = array(
            'caseno' => $case_no
        );
        // $this->load->helper('html');
        //       $this->load->view('../views/header');
        // $this->load->view('../views/APCancellation/reject',$data);
        //       $this->load->view('../views/footer');

        $data['_view'] = 'APCancellation/reject';
        $this->load->view('layouts/main', $data);
    }
    function SaverejectNote()
    {
        $db =  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');
        $year_no = $this->input->post('year_no');
        $petition_no = $this->input->post('petition_no');
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('reject_report');
        $user_code = $this->session->userdata('user_code');
        //print_r($_POST);
        $update = array(
            'status' => 'F',
            'remarks' => $remark,
            'order_passed' => 'Y',
            'date_of_order' => date('Y-m-d'),
            'user_code' => $user_code
        );
        $this->db->where('case_no', $case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $vill_code);
        $this->db->where('year_no', $year_no);
        $this->db->update("apcancel_petition_basic", $update);
        $this->session->set_flashdata('message', "Case has been successfully rejected ##$case_no");
        redirect(base_url() . 'index.php/home/');
    }
    function HearingDate()
    {
        $db =  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $this->session->set_userdata('case_no', $case_no);
        $this->session->set_userdata('mouza_pargona_code', $mouza_pargona_code);
        $this->session->set_userdata('lot_no', $lot_no);
        $this->session->set_userdata('vill_townprt_code', $vill_townprt_code);
        redirect(base_url() . 'index.php/APCancellation/updateProDate');
    }
    function updateProDate()
    {
        $db =  $this->session->userdata('db');
        $this->form_validation->set_rules('update_date', 'Select Date', 'required');
        //$this->form_validation->set_rules('remark', 'Write Remarks', 'required');
        if ($this->form_validation->run() == FALSE) {
            //                $this->load->view('../views/header');
            // $this->load->view('../views/APCancellation/updatenotice');
            // $this->load->view('../views/footer');
            // $this->load->view('../views/footer');
            $data['_view'] = 'APCancellation/updatenotice';
            $this->load->view('layouts/main', $data);
        } else {
            $updateProDate = $this->input->post('update_date');
            $case_no = $this->input->post('case_no');
            //$remark=addslashes($this->input->post('remark'));
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $pb = array(
                'next_date_of_hearing' => date('Y-m-d', strtotime($updateProDate)),
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->update(" apcancel_petition_basic", $pb);
            $this->session->set_flashdata('message', "Date Updated Successfully ## $case_no !!");
            redirect(base_url() . 'index.php/home/index');
        }
    }

    function Dashboard($case_no)
    {
        $this->dbb = $this->load->database('dash', TRUE);
        $sql = "Select pb.*,pd.patta_no,pd.patta_type_code, pd.dag_no from apcancel_petition_basic pb  join apcancel_dag_details pd on pb.case_no=pd.case_no  where pb.case_no='$case_no' ";
        $data = $this->db->query($sql)->row_array();
        $type = 'AP';
        $base = array(
            'dist_code' => $data['dist_code'],
            'subdiv_code' => $data['subdiv_code'],
            'cir_code' => $data['cir_code'],
            'mouza_pargona_code' => $data['mouza_pargona_code'],
            'lot_no' => $data['lot_no'],
            'vill_townprt_code' => $data['vill_townprt_code'],
            'case_no' => $data['case_no'],
            'date_of_reg' => $data['date_entry'],
            'dag_no' => $data['dag_no'],
            'patta_type_code' => $data['patta_type_code'],
            'patta_no' => $data['patta_no'],
            'status' => 'P',
            'pending_with_user' => 'CO',
            'case_type' => $type,
            'date_of_insert' => date("Y-m-d h:i:s")
        );
        $this->dbb->insert('dashboard_data', $base);

        unset($base['dag_no']);
        unset($base['patta_type_code']);
        unset($base['patta_no']);

        $this->db->insert('dashboard_data', $base);

        $sql = "Select pet_name,guard_name,guard_rel from apcancel_petitioner where case_no='$data[case_no]'  ";
        $petitioner = $this->db->query($sql)->result();
        foreach ($petitioner as $key => $value) {
            $applicant = array(
                'case_no' => $data['case_no'],
                'applicant_name' => $value->pet_name,
                'guardian_name' => $value->guard_name,
                'gender' => $value->guard_rel
            );
            $this->dbb->insert('dashboard_applicant', $applicant);
        }
        $action = array(
            'case_no' => $data['case_no'],
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date('Y-m-d'),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Registered By Assistant',
        );
        $this->dbb->insert('dashboard_action', $action);
    }

    function DashboardData($case_no, $penUser, $rmrk)
    {
        //////////////Update Dashboard Database///////////////////////
        $this->dbb = $this->load->database('dash', TRUE);
        $base = array(
            'pending_with_user' => $penUser,
            'date_of_update' => date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no', $case_no);
        $this->dbb->update('dashboard_data', $base);

        $this->db->where('case_no', $case_no);
        $this->db->update('dashboard_data', $base);


        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date('Y-m-d'),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => $rmrk,
        );
        $this->dbb->insert('dashboard_action', $action);
        /////////////////////////////////////
    }
    function DashboardDataFinal($case_no)
    {
        //////////////Update Dashboard Database///////////////////////
        $this->dbb = $this->load->database('dash', TRUE);
        $base = array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user' => 'NA',
            'status' => 'F',
            'remark' => 'Final Order Passed',
            'date_of_update' => date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no', $case_no);
        $this->dbb->update('dashboard_data', $base);
        $this->db->update('dashboard_data', $base);


        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date('Y-m-d'),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Final Order Passed',
        );
        $this->dbb->insert('dashboard_action', $action);
        /////////////////////////////////////
    }

    function regenerateOldNotice()
    {
        $this->load->helper('html');
        $data['_view'] = 'APCancellation/notice_regenerate';
        $this->load->view('layouts/main', $data);
    }

    public function regenerate_showcause_notice()
    {
        if (isset($_POST)) {
            $details = array();
            $case_no = trim($_POST['case_no']);
            $data['case_no'] = $case_no;
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $year_no = year_no;
            $detailsQuery = "select * from apcancel_petition_basic pb"
                . " where pb.case_no = '$case_no'  AND pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.status='P' ";
            //echo $detailsQuery;
            $details = $this->db->query($detailsQuery)->row();
            // $data['details'] = $details;
            // echo $size = count($details);
            // die;
            if ($details) {
                $dist_code = $details->dist_code;
                $subdiv_code = $details->subdiv_code;
                $cir_code = $details->cir_code;
                $lot_no = $details->lot_no;
                $vill_townprt_code = $details->vill_townprt_code;
                $year_no = $details->year_no;
                $petition_no = $details->petition_no;
                $case_no = $details->case_no;
                $mouza_pargona_code = $details->mouza_pargona_code;
                $date_hearing = date('Y-m-d', strtotime($details->next_date_of_hearing));
                $data['date_hearing'] = $date_hearing;
                $date = date("Y-m-d");

                $this->load->model('misreport/MisModel');
                $data['circlename'] = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

                $data['APCaseShowCauseAST'] = $this->APCancellationModel->getAPCaseShowCauseAST($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $year_no, $petition_no, $case_no, $date_hearing);


                $notifyPerson = "Select * from apcancel_petitioner where dist_code ='$dist_code'  and "
                    . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and "
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
                    . " case_no='$case_no' and petition_no = $petition_no ";
                $data['notifyname'] = $this->db->query($notifyPerson)->result();

                /////////////////////////
                $penUser = "CO";
                $rmrk = 'Notice issued by Assistant';
                // $this->DashboardData($case_no,$penUser,$rmrk);
                /////////////////////////

                $q = "select add_off_name from   apcancel_petition_basic where subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' ";
                $co_name = $this->db->query($q)->row();
                //var_dump($co_name);
                //exit;
                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $co_name->add_off_name);
                $data['location'] = array(
                    'co_name' => $co->username
                );

                $data['_view'] = 'APCancellation/regenerate_case_show';
                $this->load->view('layouts/main', $data);
            } else {
                $this->session->set_flashdata('message', 'Case number not Found / Final order have been passed .#' . "$case_no");
                redirect(base_url() . 'index.php/home/index');
            }
        }
    }
}
