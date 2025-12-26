<?php
class SettlementCommon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('UtilsModel');
        $this->load->helper(['form', 'url']);
        $this->dbswitch();

        $method = $this->router->fetch_method();

        if (! in_array($method, VERIFICATION_MODULE_METHODS)) {
            if (HOLD_All_MB2_CASES_STATUS == 1) {
                if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
                    $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                    redirect(base_url() . "index.php/Home/index");
                }
            }
        }
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    // document download method
    public function downloadDocument()
    {
        //$dist_code = $_POST['dist_code'];
        $id = isset($_GET['doc_id']) ? $_GET['doc_id'] : null;
        log_message("error", 'id: ' . $id);
        if (isset($id)) {
            //$result = $this->landMaster->getSupportiveDocument($dist_code,$id);
            $result = $this->db->query("SELECT * FROM supportive_document WHERE id=?", [$id])->row_array();

            //// this need to be remove when api doc made live in revert back
            $case_no_doc  = $result["case_no"];
            $service_name = explode('/', $case_no_doc);
            if ($service_name[4] == 'CONV') {
                $result2 = $this->db->query("SELECT status FROM petition_basic WHERE case_no=?", [$case_no_doc])->row_array();
            } else if ($service_name[4] == 'RECLS') {
                $result2 = $this->db->query("SELECT status FROM reclass_suite_basic WHERE case_no=?", [$case_no_doc])->row_array();
            } else {
                $result2 = $this->db->query("SELECT status FROM settlement_basic WHERE case_no=?", [$case_no_doc])->row_array();
            }

            /////

            log_message("error", 'result: ' . json_encode($result));

            // if((isset($result["api_doc_id"]) && !empty(($result["api_doc_id"]))) && $result2["status"]!='X'){
            //     $api_view_file = $this->SettlementCommonModel->downloadFileFromApiBase($result["api_doc_id"],$result["file_type"]);
            //     if ($api_view_file->status == 2){

            //         if (strtolower($api_view_file->content_type) == 'application/pdf'){
            //             $api_file= base64_decode($api_view_file->base64_data);
            //             header("Content-type: ".$api_view_file->content_type);
            //             echo $api_file;
            //         }else{
            //             echo '<img src="data:'.$api_view_file->content_type.';base64,'.$api_view_file->base64_data.'" />';
            //         }

            //     }else{
            //         return;
            //     }

            // }else{

            $file = $result['file_path'];

            // if (!file_exists($file)) {
            //     $file = UPLOAD_DIR . $result['file_path'];
            // }

            //echo $file;
            log_message('error', file_exists($file));
            if (! file_exists($file)) {
                //***if file not exist hit api and fetch file  */
                $parts = explode("uploads" . UPLOAD_SEPARATOR, $file, 2);
                if (count($parts) > 1) {
                    $path = BACKUP_DIR_34 . "uploads" . UPLOAD_SEPARATOR . $parts[1];
                } else {
                    $path = $file;
                }

                if (! file_exists($path)) {
                    $path = BACKUP_DIR_35 . "uploads" . UPLOAD_SEPARATOR . $parts[1];
                }

                if (! file_exists($path)) {
                    if ((isset($result["api_doc_id"]) && ! empty(($result["api_doc_id"]))) && $result2["status"] != 'X') {
                        $api_view_file = $this->SettlementCommonModel->downloadFileFromApiBase($result["api_doc_id"], $result["file_type"]);

                        if ($api_view_file->status == 2) {
                            $data                                     = "data:'.$api_view_file->content_type.';base64,'.$api_view_file->base64_data.'";
                            list($api_view_file->content_type, $data) = explode(';', $data);
                            list(, $data)                             = explode(',', $data);
                            $data                                     = base64_decode($data);

                            file_put_contents($result['file_path'], $data);

                        } else {
                            echo "No Data Found..";
                            return;
                        }
                    }
                } else {
                    $file = $path;
                }
                // echo "No Data Found..";
                // return;
            }
            log_message("error", 'DOwnloaded file path: ' . json_encode($file));
            $content_type = $result['file_type'];
            //header('Content-Type: application/json;charset=utf-8');
            //header('Content-Type: '.$content_type);
            //header('Content-Length: ' . filesize($file));
            //ob_clean();
            $mainfile = file_get_contents($file);
            $raw_data = base64_encode($mainfile);
            if ($content_type == 'jpeg' || $content_type == 'png' || $content_type == 'jpg' || $content_type == 'image/jpeg' || $content_type == 'image/png' || $content_type == 'image/jpg') {
                echo "<img src = data:" . $this->decodeBase64($raw_data) . ";base64," . $raw_data . ">";
            }
            if ($content_type == 'application/pdf') {
                header("Content-type: application/pdf");
                echo base64_decode($raw_data);
            }

            // }

        } else {
            echo "No Data Found..";
        }
    }

    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file      = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }

    public function apiDagWiseApplication()
    {

        $application_no = $this->input->get('app');
        $dag_no         = $this->input->get('dag');

        $token = $this->utilityclass->createTokenJwt();

        $postRequest = [
            'application_no' => $application_no,
            'api_key'        => API_KEY,
            'token'          => $token,
        ];

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_LINK_MB2 . "getAppDetails");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $output = curl_exec($cURL);

        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType == 3) {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }

        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if ($httpcode != 200) {
            return false;
        }

        // $curl_handle = curl_init();
        // curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getAppDetails");
        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //     'application_no' => $application_no,
        //     'api_key' => API_KEY,
        //     'token' => $token,
        // )));
        // $output = curl_exec($curl_handle);
        // if (isset(json_decode($output)->responseType)) {
        //     if (json_decode($output)->responseType == 3) {
        //         echo json_decode($output)->data . " - Unauthorized access!";
        //         return false;
        //     }
        // }
        // curl_close($curl_handle);

        $output          = json_decode($output);
        $district['app'] = $output->application;

        $dist_code    = $district['app']->dist_code;
        $subdiv_code  = $district['app']->subdiv_code;
        $cir_code     = $district['app']->cir_code;
        $mouza_code   = $district['app']->mouza_code;
        $lot_no       = $district['app']->lot_no;
        $village_code = $district['app']->village_code;
        $dag_no       = $dag_no;
        // var_dump($district['app']); die();

        // $dist_code      = '07';
        // $subdiv_code    = '01';
        // $cir_code       = '01';
        // $mouza_code     = '02';
        // $lot_no         = '06';
        // $village_code   = '10002';
        // $dag_no         = '693';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => API_LINK_MB2 . 'applicantAppliedForSettlementServicesByDagNo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => [
                'dist_code'    => $dist_code,
                'subdiv_code'  => $subdiv_code,
                'cir_code'     => $cir_code,
                'mouza_code'   => $mouza_code,
                'lot_no'       => $lot_no,
                'village_code' => $village_code,
                'dag_no'       => $dag_no,
            ],
        ]);

        $output = curl_exec($curl);
        curl_close($curl);
        $output = json_decode($output);

        // var_dump($output); die();
        $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetailsByDagNo
        ($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $dag_no);

        if ($output->appiledDetails == "" || $output->appiledDetails == null) {
            $this->session->set_flashdata('message', "Data not found!!");
            redirect(base_url() . "index.php/home");

        } else {
            $lmdata['applications'] = $output->appiledDetails;
            $lmdata['service_code'] = $district['app']->service_code;
            $lmdata['chithaArea']   = $chithaDag;
            $lmdata['dag_no']       = $dag_no;
            $lmdata['dist_code']    = $dist_code;
            $lmdata['subdiv_code']  = $subdiv_code;
            $lmdata['cir_code']     = $cir_code;
            $lmdata['mouza_code']   = $mouza_code;
            $lmdata['lot_no']       = $lot_no;
            $lmdata['vill_code']    = $village_code;
        }
        // var_dump($lmdata['service_code']); die();

        // var_dump($lmdata['applications']); die();

        // $lmdata['_view'] = 'SettlementView/include/DagWiseApplicationtView';

        $lmdata['_view'] = 'SettlementView/include/DagWiseApplicationtViewNew';
        $this->load->view('layouts/main', $lmdata);

    }

    public function bhumiPutra()
    {
        $certificate_number = isset($_GET['cer_number']) ? $_GET['cer_number'] : null;

        $ack_number = isset($_GET['ack_number']) ? $_GET['ack_number'] : null;

        if (isset($certificate_number)) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL            => API_LINK_MB2 . 'getBhumiputraCertificateNew',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 100,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => [
                    'certificate_no' => $certificate_number,
                ],
            ]);

            $response = curl_exec($curl);

            $curl_errno = curl_errno($curl);
            $curl_error = curl_error($curl);
            if ($curl_errno > 0) {
                log_message('error', "ERRORNO" . $curl_errno . "ERROR" . $curl_error . "certificate_number" . $certificate_number . "time" . time());
                echo '<center><h1 style="color:red">Connection time out!</h1></center>';
                return;
            }
            curl_close($curl);

            $responsetrue = json_decode($response);

            if ($responsetrue->responseType == 'SUCCESS') {
                $base64data = base64_decode($responsetrue->data, true);
                header("Content-type: application/pdf");
                echo $base64data;
                return;
            } else if ($responsetrue->responseType == 'SUCCESS-STATUS') {
                $ddt = json_decode($responsetrue->data);

                echo '<center>
                            <h3>
                                <u>STATUS</u><br>
                                ' . $ddt->applicantName . '<br>
                                ' . $ddt->caste . '<br>
                                ' . $ddt->status . '<br>
                            </h3>
                        </center>';

                return;
            } else if ($responsetrue->responseType == 'ERROR') {
                log_message('error', "#ERR381: No response from bhumiputra end for certificate no $certificate_number");
                echo '<center><h1 style="color:red">' . $responsetrue->data . '</h1></center>';
                return;
            } else {
                echo '<center><h1 style="color:red">Connection time out!</h1></center>';
                return;
            }

        } elseif (isset($ack_number)) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL            => API_LINK_MB2 . 'getBhumiputraCertificateNew',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 40,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => [
                    'acknowledgement_no' => $ack_number,
                ],
            ]);

            $response   = curl_exec($curl);
            $curl_errno = curl_errno($curl);
            $curl_error = curl_error($curl);
            if ($curl_errno > 0) {
                log_message('error', "ERRORNO" . $curl_errno . "ERROR" . $curl_error . "ack_number" . $ack_number . "time" . time());
                $this->session->set_flashdata('message', "Unable to connect Bhumiputra API  Status");
                redirect('/home');
                // echo "cURL Error ($curl_errno): $curl_error\n";
            }
            curl_close($curl);

            $responsetrue = json_decode($response);

            if ($responsetrue->responseType == 'SUCCESS') {
                $base64data = base64_decode($responsetrue->data, true);
                header("Content-type: application/pdf");
                echo $base64data;
                return;
            } else if ($responsetrue->responseType == 'SUCCESS-STATUS') {
                $ddt = json_decode($responsetrue->data);

                echo '<center>
                            <h3>
                                <u>STATUS</u><br>
                                ' . $ddt->applicantName . '<br>
                                ' . $ddt->caste . '<br>
                                ' . $ddt->status . '<br>
                            </h3>
                        </center>';

                return;
            } else if ($responsetrue->responseType == 'ERROR') {
                log_message('error', "#ERR381: No response from bhumiputra end for certificate no $certificate_number");
                echo '<center><h1 style="color:red">' . $responsetrue->data . '</h1></center>';
                return;
            } else {
                echo '<center><h1 style="color:red">Connection time out!</h1></center>';
                return;
            }

        } else {
            echo '<center><h1 style="color:red">Certificate/Ack Number is required!</h1></center>';
            return;
        }

    }

    // Pagination for co end 14-10-2022 -js-
    // public function pagination()
    // {

    //     if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
    //         $lot_string = $this->caseListUnderMappingLot();
    //     }

    //     $s_code = $this->input->post('service');
    //     $search_term = $this->input->post('search_term');
    //     $remark_cat = $this->input->post('remark_cat');
    //     $reverted = $this->input->post('reverted');
    //     $user_code = $this->session->userdata('user_code');
    //     $payment_status = $this->input->post('payment_status');

    //     $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    //     $lot_no = $this->input->post('lot_no');
    //     $nr_cat = $this->input->post('nr_cat');

    //     $status = $this->input->post('status');
    //     $draw = intval($this->input->post('draw'));
    //     $start = intval($this->input->post('start'));
    //     $length = intval($this->input->post('length'));
    //     $order = $this->input->post('order');

    //     $pagination = $this->input->post('pagination');

    //     $final_verification_report = $this->input->post('final_verification_report');
    //     $co_approved = $this->input->post('co_approved');

    //     $col = 0;
    //     $dir = "";
    //     $search = $this->input->post('search');
    //     $search = $search['value'];

    //     $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    //     $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
    //     $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

    //     $is_cat = $this->input->post('is_category');

    //     // if($status == MB_PAYMENT_NOTICE)
    //     // {
    //     //     if($this->session->userdata('user_desig_code') == MB_CIRCLE_OFFICER)
    //     //     {
    //     //         if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no))
    //     //         {
    //     //             if(isset($lot_string) && $lot_string != null)
    //     //             {
    //     //                 $sqlToCheckGrn = $this->db->query("select * from settlement_basic where status = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)", array(MB_PAYMENT_NOTICE, $this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code')));
    //     //             }
    //     //             else
    //     //             {
    //     //                 $sqlToCheckGrn = $this->db->query("select * from settlement_basic where status = ? and dist_code = ? and subdiv_code = ? and cir_code = ?", array(MB_PAYMENT_NOTICE, $this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code')));
    //     //             }
    //     //         }
    //     //         else
    //     //         {
    //     //             $sqlToCheckGrn = $this->db->query("select * from settlement_basic where status = ? and dist_code = ? and subdiv_code = ? and cir_code = ?", array(MB_PAYMENT_NOTICE, $this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code')));
    //     //         }

    //     //         if($sqlToCheckGrn->num_rows() > 0)
    //     //         {
    //     //             $grnResult = $sqlToCheckGrn->result();

    //     //             foreach($grnResult as $grnRow)
    //     //             {
    //     //                 $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($grnRow->case_no, 1));

    //     //                 if($sqlCheck->num_rows() > 0)
    //     //                 {
    //     //                     $payment_status_check = $this->SettlementMbModel->paymentConfirmation($grnRow->applid);

    //     //                     if(isset($payment_status_check->payment_status))
    //     //                     {
    //     //                         $pay_status = $payment_status_check->payment_status;
    //     //                         if (strtoupper($pay_status)=='Y')
    //     //                         {
    //     //                             $this->db->trans_begin();

    //     //                             $dagsResult = $this->SettlementKhasModel->getSettlementDag($grnRow->case_no);
    //     //                             $isFullPay = 'YES';

    //     //                             if($payment_status_check->total_premium != $payment_status_check->paid_amount)
    //     //                             {
    //     //                                 $isFullPay = 'NO';
    //     //                             }

    //     //                             $insertArr = [
    //     //                                 'is_full_pay' => $isFullPay,
    //     //                                 'total_premium' => $payment_status_check->total_premium,
    //     //                                 'paid_amount' => $payment_status_check->paid_amount,
    //     //                                 'remaining_amount' => $payment_status_check->remaining_amount,
    //     //                                 'tenure' => $payment_status_check->tenure,
    //     //                                 'installment_amount' => $payment_status_check->installment_amount,
    //     //                                 'payment_date' => $payment_status_check->payment_date,
    //     //                                 'grn_no' => $payment_status_check->grn_no,
    //     //                             ];

    //     //                             $this->db->where('case_no', $grnRow->case_no);
    //     //                             $this->db->where('is_final', 1);
    //     //                             $this->db->update('settlement_premium', $insertArr);

    //     //                             if($this->db->affected_rows() != count($dagsResult))
    //     //                             {
    //     //                                 $this->db->trans_rollback();
    //     //                                 $this->session->set_flashdata('message', "#ERR737: Something went wrong! Unable to process...");
    //     //                                 redirect(base_url() . "index.php/Home/index");
    //     //                             }
    //     //                             $this->db->trans_commit();
    //     //                         }
    //     //                     }
    //     //                 }
    //     //             }
    //     //         }
    //     //     }
    //     // }

    //     if (!empty($order)) {
    //         foreach ($order as $o) {
    //             $col = $o['column'];
    //             $dir = $o['dir'];
    //         }
    //     }

    //     if ($dir != "asc" && $dir != 'desc') {
    //         $dir = 'asc';
    //     }

    //     $valid_columns = array(
    //         0 => 'date_entry',
    //         // 1   => 'applid',
    //     );

    //     if (!isset($valid_columns[$col])) {
    //         $order = null;
    //     } else {
    //         $order = $valid_columns[$col];
    //     }

    //     if ($order != null) {
    //         $this->db->order_by($order, $dir);
    //     }

    //     // if(!empty($search)){
    //     //     // $this->db->like($s_terms, $search);
    //     //     $this->db->like('case_no', $search);
    //     // }

    //     if (!empty($searchByCol_0)) {

    //         $this->db->like('a.case_no', strtoupper($searchByCol_0));
    //     }

    //     if (!empty($searchByCol_1)) {

    //         $this->db->like('a.applid', strtoupper($searchByCol_1));
    //     }

    //     if (!empty($searchByCol_3)) {
    //         $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
    //         //$this->db->like('date_entry', $searchByCol_2);
    //     }

    //     $this->db->limit($length, $start);

    //     $this->db->where('a.service_code', $s_code);

    //     if(!empty($remark_cat))
    //     {  //settlement_ap_lmnote, lm_note
    //         $this->db->where('b.lm_note', $remark_cat);
    //     }

    //     if(!empty($mouza_pargona_code))
    //     {
    //         $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
    //     }

    //     if(!empty($mouza_pargona_code) && !empty($lot_no))
    //     {
    //         $this->db->where('a.lot_no', $lot_no);
    //     }

    //     if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
    //         $this->db->where('a.vill_townprt_code', $is_cat);
    //     }

    //     if (trim($reverted) == 'LM'){
    //         $this->db->where('a.pending_officer', MB_LOT_MONDOL);

    //     }
    //     else if (trim($reverted) == 'ADC'){
    //         $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
    //     }
    //     else{

    //         // if ($this->session->userdata('user_desig_code') == 'SK')
    //         // {
    //         //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
    //         // }
    //         // else
    //         // {
    //         //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
    //         //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
    //         // }
    //         $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
    //     }
    //     if ($this->session->userdata('user_desig_code') == 'CO'){
    //         // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
    //         if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
    //             if(isset($lot_string) && $lot_string != null)
    //             {
    //                 $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
    //             }
    //         }

    //         // $this->db->orWhere('a.co_code', null);
    //     }
    //     if ($this->session->userdata('user_desig_code') == 'SK') {
    //         $this->db->where('b.lm_note', '1');
    //         $this->db->where('a.from_office', 'LM');
    //     }

    //     // $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

    //     // if($s_code == 14)
    //     // {
    //     //     if(trim($reverted) == 'LM' and $status =='V'){
    //     //         $this->db->select("distinct(a.case_no),a.service_code, c.new_dag_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry");
    //     //         $this->db->select('(select \'0\') as lm_note');
    //     //     }else{
    //     //         $this->db->select('distinct(a.case_no), c.new_dag_no, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
    //     //     }
    //     // }
    //     // else
    //     // {
    //     if(trim($reverted) == 'LM' and $status =='V'){
    //         $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
    //         $this->db->select('(select \'0\') as lm_note');
    //     }else{
    //         $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
    //     }
    //     //}

    //     if (trim($reverted) != 'ADC'){
    //         $this->db->where('a.status', $status);
    //     }
    //     $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
    //     $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
    //     $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

    //     // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
    //     if(trim($reverted) == 'LM' and $status =='V'){
    //         $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
    //     }else{
    //         $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
    //     }

    //     if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
    //     {
    //         if (trim($reverted) != 'ADC'){
    //             if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

    //             }

    //             else{
    //                 $this->db->where('a.notice_generated_yn', NULL);
    //             }
    //         }
    //     }

    //     // if($s_code == 14 && $status == 'X')
    //     // {
    //     //     $this->db->join('settlement_dag_details c', 'a.case_no = c.case_no');

    //     //     if(!empty($nr_cat))
    //     //     {
    //     //         if(trim($nr_cat) == 'Yes')
    //     //         {
    //     //             $this->db->where('c.new_dag_no is not null');
    //     //         }
    //     //         else
    //     //         {
    //     //             $this->db->where('c.new_dag_no is null');
    //     //         }
    //     //     }
    //     // }

    //     $this->db->from('settlement_basic a');

    //     if($status == MB_PAYMENT_NOTICE)
    //     {
    //         $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
    //         $this->db->where('c.is_final', 1);

    //         if(!empty($payment_status))
    //         {
    //             if(trim($payment_status) == 'paid')
    //             {
    //                 $this->db->where('c.grn_no is not null');
    //             }
    //             elseif(trim($payment_status) == 'unpaid')
    //             {
    //                 $this->db->where('c.grn_no is null');
    //             }
    //         }

    //         if(!empty($final_verification_report))
    //         {
    //             if($final_verification_report == 'Yes')
    //             {
    //                 $this->db->where_in('a.chitha_processing_details', array(1,2));
    //             }
    //             else if($final_verification_report == 'No')
    //             {
    //                 $this->db->where('a.chitha_processing_details', 0);
    //             }
    //             elseif(trim($final_verification_report) == 'land_class_issue'){
    //                 // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
    //                 // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 

    //                 $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

    //             }
    //         }

    //         if(!empty($co_approved))
    //         {
    //             if($co_approved == 'Yes')
    //             {
    //                 $this->db->where('a.chitha_processing_details', 2);
    //             }
    //             else if($co_approved == 'No')
    //             {
    //                 $this->db->where_in('a.chitha_processing_details', array(1,0));
    //             }
    //         }
    //     }

    //     $query = $this->db->get();
    //     // echo $this->db->last_query();

    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result() as $rows) {

    //             // if($s_code == 14)
    //             // {
    //             //     if($rows->new_dag_no == null)
    //             //     {
    //             //         $nr_status = 'No';
    //             //     }
    //             //     else
    //             //     {
    //             //         $nr_status = 'Yes';
    //             //     }
    //             // }

    //             $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

    //             if($revialSql->num_rows() > 0)
    //             {
    //                 $revival_flg_button = '';
    //             }
    //             else
    //             {
    //                 $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
    //             }

    //             $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="'.base_url().'index.php/SettlementCommon/downloadRejectedCases/?service='.$s_code.'">Download Reject Cases</a>';

    //             if(trim($rows->lm_note) == 1)
    //             {
    //                 $lmnoteRemark = 'Recommended';
    //             }
    //             else
    //             {
    //                 $lmnoteRemark = 'Not Recommended';
    //             }

    //             if ($status == MB_PAYMENT_REQUEST) {
    //                 $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
    //                     <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     Generate Payment Notice</a>';

    //                 $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
    //                     <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     Generate Payment Notice</a>';

    //                 $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
    //                     <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     Generate Payment Notice</a>';

    //                 $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
    //                     <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     Payment Notice</a>';

    //                 $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
    //                     <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     Generate Payment Notice</a>';

    //                 $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
    //                     <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     Generate Payment Notice</a>';

    //             } elseif ($status == MB_PAYMENT_NOTICE) {

    //                 if($rows->chitha_processing_details == 1)
    //                 {
    //                     $lm_chitha_report = 'Yes';
    //                 }
    //                 elseif($rows->chitha_processing_details == 2)
    //                 {
    //                     $lm_chitha_report = 'Yes';
    //                 }
    //                 elseif($rows->chitha_processing_details == 0)
    //                 {
    //                     $lm_chitha_report = 'No';
    //                 }

    //                 if($rows->chitha_processing_details == 2)
    //                 {
    //                     $co_approved_status = 'Yes';
    //                 }
    //                 elseif($rows->chitha_processing_details == 1)
    //                 {
    //                     $co_approved_status = 'No';
    //                 }
    //                 elseif($rows->chitha_processing_details == 0)
    //                 {
    //                     $co_approved_status = 'No';
    //                 }

    //                 $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>

    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     write report</a>';

    //                 $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

    //                     <br>

    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

    //                     <br>
    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     write report</a>';

    //                 $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>

    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

    //                     <br>
    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
    //                     write report</a>';

    //                 $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

    //                     <br>
    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

    //                     <br>
    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';

    //                 $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>

    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>
    //                     <br>
    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

    //                     <br>
    //                     <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';

    //                 $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
    //                     <br>

    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

    //                     <br>
    //                     <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

    //                     <br>

    //                     <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';
    //             } else if ($status == MB_ORDER_FOR_CHITHA_UPDATE) {
    //                 $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 View</a>

    //                 <a href="' . base_url() . 'index.php/SettlementMbCo/coFinalOrderUpdate?case_no=' . $rows->case_no . '&dist_code=' . $rows->dist_code . '&subdiv_code=' . $rows->subdiv_code . '&cir_code=' . $rows->cir_code . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you would like to update chitha for this case?\');">Update Chitha</a>

    //                 ';
    //             }
    //             else if (trim($reverted) == 'ADC' or trim($reverted) == 'LM'){
    //                 $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>';
    //                 $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>';
    //                 $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>';
    //                 $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>';
    //                 $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>';
    //                 $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>';

    //             }
    //             else if($status == MB_DISMISS)
    //             {
    //                 $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>'.$revival_flg_button.$download_rejected_cases;
    //                 $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>'.$revival_flg_button.$download_rejected_cases;
    //                 $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>'.$revival_flg_button.$download_rejected_cases;
    //                 $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>  '.$revival_flg_button.$download_rejected_cases;
    //                 $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a> '.$revival_flg_button.$download_rejected_cases;
    //                 $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                 view</a>'.$revival_flg_button.$download_rejected_cases;
    //             }
    //             else
    //             {
    //                 $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';
    //                 $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';
    //                 $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';
    //                 $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';
    //                 $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';
    //                 $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
    //                     write report</a>';

    //                 $tenant_urban_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCoUrban/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';

    //                 $tea_grant_link = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/TeaGrantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

    //                 $institute_link = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/settlementInsCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

    //             }

    //             if($status == MB_PAYMENT_NOTICE)
    //             {
    //                 $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

    //                 if($sqlgrn->num_rows() <= 0)
    //                 {
    //                     $grn_status = '<strong class="text-danger">NOT PAID</strong>';
    //                 }
    //                 else
    //                 {
    //                     if(isset($sqlgrn->row()->grn_no))
    //                     {
    //                         if($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '')
    //                         {
    //                             $grn_status = '<strong class="text-danger">NOT PAID</strong>';
    //                         }
    //                         else
    //                         {
    //                             $grn_status = '<strong class="text-success">PAID</strong>';
    //                         }
    //                     }
    //                     else
    //                     {
    //                         $grn_status = '<strong class="text-danger">NOT PAID</strong>';
    //                     }
    //                 }

    //                 $json[] = array(
    //                     '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
    //                     '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

    //                     $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

    //                     $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

    //                     $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

    //                     // $nr_status,

    //                     // $rows->date_entry,
    //                     // date("Y-m-d", strtotime($rows->date_entry)),

    //                     // $lmnoteRemark,

    //                     $grn_status,
    //                     $lm_chitha_report,
    //                     $co_approved_status,

    //                     (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
    //                 );

    //             }
    //             else
    //             {
    //                 $json[] = array(
    //                     '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
    //                     '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

    //                     $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

    //                     $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

    //                     $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

    //                     // $nr_status,

    //                     // $rows->date_entry,
    //                     date("Y-m-d", strtotime($rows->date_entry)),

    //                     $lmnoteRemark,

    //                     (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : 
    //                         (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : 
    //                         (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : 
    //                         (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link :
    //                         (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : 
    //                         (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : 
    //                         (($s_code == SETTLEMENT_TENANT_URBAN_ID) ? $tenant_urban_link :
    //                         (($s_code == TEA_SERVICE_CODE) ? $tea_grant_link :
    //                         (($s_code == SLIJE_ID) ? $institute_link : ''

    //                     ))))))))),
    //                 );
    //             }

    //         }

    //         $this->db->where('a.service_code', $s_code);

    //         if(!empty($remark_cat))
    //         {  //settlement_ap_lmnote, lm_note
    //             $this->db->where('b.lm_note', $remark_cat);
    //         }

    //         if (trim($reverted) == 'LM'){
    //             $this->db->where('a.pending_officer', MB_LOT_MONDOL);

    //         }
    //         else if (trim($reverted) == 'ADC'){
    //             $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
    //         }
    //         else{

    //             // if ($this->session->userdata('user_desig_code') == 'SK')
    //             // {
    //             //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
    //             // }
    //             // else
    //             // {
    //             //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
    //             //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
    //             // }
    //             $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
    //         }

    //         if ($this->session->userdata('user_desig_code') == 'CO'){
    //             // $this->db->where('a.co_code', $user_code);
    //             // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
    //             if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

    //                 if(isset($lot_string) && $lot_string != null)
    //                 {
    //                     $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
    //                 }
    //             }
    //         }

    //         if ($this->session->userdata('user_desig_code') == 'SK') {
    //             $this->db->where('b.lm_note', '1');
    //             $this->db->where('a.from_office', 'LM');
    //         }

    //         if(!empty($mouza_pargona_code))
    //         {
    //             $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
    //         }

    //         if(!empty($mouza_pargona_code) && !empty($lot_no))
    //         {
    //             $this->db->where('a.lot_no', $lot_no);
    //         }

    //         if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
    //             $this->db->where('a.vill_townprt_code', $is_cat);
    //         }

    //         // $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

    //         // if($s_code == 14 && $status == 'X')
    //         // {
    //         //     $this->db->join('settlement_dag_details c', 'a.case_no = c.case_no');

    //         //     if(!empty($nr_cat))
    //         //     {
    //         //         if(trim($nr_cat) == 'Yes')
    //         //         {
    //         //             $this->db->where('c.new_dag_no is not null');
    //         //         }
    //         //         else
    //         //         {
    //         //             $this->db->where('c.new_dag_no is null');
    //         //         }
    //         //     }
    //         // }

    //         // if($s_code == 14)
    //         // {
    //         //     if(trim($reverted) == 'LM' and $status =='V'){
    //         //         $this->db->select("distinct(a.case_no),a.service_code, c.new_dag_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry");
    //         //         $this->db->select('(select \'0\') as lm_note');
    //         //     }else{
    //         //         $this->db->select('distinct(a.case_no), c.new_dag_no, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
    //         //     }
    //         // }
    //         // else
    //         // {

    //         // if(trim($reverted) == 'LM' and $status =='V'){
    //         //     $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
    //         //     $this->db->select('(select \'0\') as lm_note');
    //         // }else{
    //         //     $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
    //         // }

    //         if(trim($reverted) == 'LM' and $status =='V'){
    //             $this->db->select('distinct(a.case_no)');
    //             $this->db->select('(select \'0\') as lm_note');
    //         }else{
    //             $this->db->select('distinct(a.case_no)');
    //         }

    //         //}

    //         if (trim($reverted) != 'ADC'){
    //             $this->db->where('a.status', $status);
    //         }
    //         $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
    //         $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
    //         $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

    //         // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
    //         if(trim($reverted) == 'LM' and $status =='V'){
    //             $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
    //         }else{
    //             $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
    //         }

    //         if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
    //         {
    //             if (trim($reverted) != 'ADC'){
    //                 if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

    //                 }

    //                 else{
    //                     $this->db->where('a.notice_generated_yn', NULL);
    //                 }
    //             }
    //         }

    //         if($status == MB_PAYMENT_NOTICE)
    //         {
    //             $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
    //             $this->db->where('c.is_final', 1);

    //             if(!empty($payment_status))
    //             {
    //                 if(trim($payment_status) == 'paid')
    //                 {
    //                     $this->db->where('c.grn_no is not null');
    //                 }
    //                 elseif(trim($payment_status) == 'unpaid')
    //                 {
    //                     $this->db->where('c.grn_no is null');
    //                 }

    //             }

    //             if(!empty($final_verification_report))
    //             {
    //                 if($final_verification_report == 'Yes')
    //                 {
    //                     $this->db->where_in('a.chitha_processing_details', array(1,2));
    //                 }
    //                 else if($final_verification_report == 'No')
    //                 {
    //                     $this->db->where('a.chitha_processing_details', 0);
    //                 }
    //                 elseif(trim($final_verification_report) == 'land_class_issue'){
    //                     // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
    //                     // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
    //                     $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

    //                 }
    //             }

    //             if(!empty($co_approved))
    //             {
    //                 if($co_approved == 'Yes')
    //                 {
    //                     $this->db->where('a.chitha_processing_details', 2);
    //                 }
    //                 else if($co_approved == 'No')
    //                 {
    //                     $this->db->where_in('a.chitha_processing_details', array(1,0));
    //                 }
    //             }
    //         }

    //         // $total_records = $this->db->count_all_results('settlement_basic a');
    //         $data=$this->db->get('settlement_basic a');
    //         $total_records = $data->num_rows();
    //         $response = array(
    //             'draw' => $draw,
    //             'recordsTotal' => $total_records,
    //             'recordsFiltered' => $total_records,
    //             'data' => $json,
    //         );

    //         echo json_encode($response);

    //     } else {
    //         $response = array();
    //         $response['sEcho'] = 0;
    //         $response['iTotalRecords'] = 0;
    //         $response['iTotalDisplayRecords'] = 0;
    //         $response['aaData'] = [];
    //         echo json_encode($response);
    //     }
    // }

    public function pagination()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code         = $this->input->post('service');
        $search_term    = $this->input->post('search_term');
        $remark_cat     = $this->input->post('remark_cat');
        $reverted       = $this->input->post('reverted');
        $user_code      = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');
        $sub_date       = $this->input->post('sub_date');


        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $pagination = $this->input->post('pagination');

        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved               = $this->input->post('co_approved');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        // if($status == MB_PAYMENT_NOTICE)
        // {
        //     if($this->session->userdata('user_desig_code') == MB_CIRCLE_OFFICER)
        //     {
        //         if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no))
        //         {
        //             if(isset($lot_string) && $lot_string != null)
        //             {
        //                 $sqlToCheckGrn = $this->db->query("select * from settlement_basic where status = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)", array(MB_PAYMENT_NOTICE, $this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code')));
        //             }
        //             else
        //             {
        //                 $sqlToCheckGrn = $this->db->query("select * from settlement_basic where status = ? and dist_code = ? and subdiv_code = ? and cir_code = ?", array(MB_PAYMENT_NOTICE, $this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code')));
        //             }
        //         }
        //         else
        //         {
        //             $sqlToCheckGrn = $this->db->query("select * from settlement_basic where status = ? and dist_code = ? and subdiv_code = ? and cir_code = ?", array(MB_PAYMENT_NOTICE, $this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code')));
        //         }

        //         if($sqlToCheckGrn->num_rows() > 0)
        //         {
        //             $grnResult = $sqlToCheckGrn->result();

        //             foreach($grnResult as $grnRow)
        //             {
        //                 $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($grnRow->case_no, 1));

        //                 if($sqlCheck->num_rows() > 0)
        //                 {
        //                     $payment_status_check = $this->SettlementMbModel->paymentConfirmation($grnRow->applid);

        //                     if(isset($payment_status_check->payment_status))
        //                     {
        //                         $pay_status = $payment_status_check->payment_status;
        //                         if (strtoupper($pay_status)=='Y')
        //                         {
        //                             $this->db->trans_begin();

        //                             $dagsResult = $this->SettlementKhasModel->getSettlementDag($grnRow->case_no);
        //                             $isFullPay = 'YES';

        //                             if($payment_status_check->total_premium != $payment_status_check->paid_amount)
        //                             {
        //                                 $isFullPay = 'NO';
        //                             }

        //                             $insertArr = [
        //                                 'is_full_pay' => $isFullPay,
        //                                 'total_premium' => $payment_status_check->total_premium,
        //                                 'paid_amount' => $payment_status_check->paid_amount,
        //                                 'remaining_amount' => $payment_status_check->remaining_amount,
        //                                 'tenure' => $payment_status_check->tenure,
        //                                 'installment_amount' => $payment_status_check->installment_amount,
        //                                 'payment_date' => $payment_status_check->payment_date,
        //                                 'grn_no' => $payment_status_check->grn_no,
        //                             ];

        //                             $this->db->where('case_no', $grnRow->case_no);
        //                             $this->db->where('is_final', 1);
        //                             $this->db->update('settlement_premium', $insertArr);

        //                             if($this->db->affected_rows() != count($dagsResult))
        //                             {
        //                                 $this->db->trans_rollback();
        //                                 $this->session->set_flashdata('message', "#ERR737: Something went wrong! Unable to process...");
        //                                 redirect(base_url() . "index.php/Home/index");
        //                             }
        //                             $this->db->trans_commit();
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
            // 1   => 'applid',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        // if(!empty($search)){
        //     // $this->db->like($s_terms, $search);
        //     $this->db->like('case_no', $search);
        // }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if(!empty($sub_date)){
            $this->db->where("CAST(a.submission_date AS TEXT) LIKE", $sub_date . '%');
        }

        if (trim($reverted) == 'LM') {
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);

        } else if (trim($reverted) == 'ADC') {
            $this->db->where_not_in('a.pending_officer', [MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER]);
        } else {

            // if ($this->session->userdata('user_desig_code') == 'SK')
            // {
            //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
            // }
            // else
            // {
            //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
            // }
            $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
        }
        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }

        // $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

        // if($s_code == 14)
        // {
        //     if(trim($reverted) == 'LM' and $status =='V'){
        //         $this->db->select("distinct(a.case_no),a.service_code, c.new_dag_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry");
        //         $this->db->select('(select \'0\') as lm_note');
        //     }else{
        //         $this->db->select('distinct(a.case_no), c.new_dag_no, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
        //     }
        // }
        // else
        // {
        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        } else {
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
        }
        //}

        if (trim($reverted) != 'ADC') {
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        } else {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if ($s_code == 14 && ($status != 'R' && $status != 'X' && $status != 'M' && $status != 'N' && $status != 'D')) {
            if (trim($reverted) != 'ADC') {
                if (($this->session->userdata('user_desig_code') == 'SK' and $status == 'W') || trim($reverted) == 'LM' and $status == 'V') {

                } else {
                    $this->db->where('a.notice_generated_yn', null);
                }
            }
        }

        // if($s_code == 14 && $status == 'X')
        // {
        //     $this->db->join('settlement_dag_details c', 'a.case_no = c.case_no');

        //     if(!empty($nr_cat))
        //     {
        //         if(trim($nr_cat) == 'Yes')
        //         {
        //             $this->db->where('c.new_dag_no is not null');
        //         }
        //         else
        //         {
        //             $this->db->where('c.new_dag_no is null');
        //         }
        //     }
        // }

        $this->db->from('settlement_basic a');

        if ($status == MB_PAYMENT_NOTICE) {
            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);

            if (! empty($payment_status)) {
                if (trim($payment_status) == 'paid') {
                    $this->db->where('c.grn_no is not null');
                } elseif (trim($payment_status) == 'unpaid') {
                    $this->db->where('c.grn_no is null');
                }
            }

            if (! empty($final_verification_report)) {
                if ($final_verification_report == 'Yes') {
                    $this->db->where_in('a.chitha_processing_details', [1, 2]);
                } else if ($final_verification_report == 'No') {
                    $this->db->where('a.chitha_processing_details', 0);
                } elseif (trim($final_verification_report) == 'land_class_issue') {
                    // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                    // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 

                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

                }
            }

            if (! empty($co_approved)) {
                if ($co_approved == 'Yes') {
                    $this->db->where('a.chitha_processing_details', 2);
                } else if ($co_approved == 'No') {
                    $this->db->where_in('a.chitha_processing_details', [1, 0]);
                }
            }
        }

        $query = $this->db->get();
        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                // if($s_code == 14)
                // {
                //     if($rows->new_dag_no == null)
                //     {
                //         $nr_status = 'No';
                //     }
                //     else
                //     {
                //         $nr_status = 'Yes';
                //     }
                // }
                $srobtn = null;
                $sro_check = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? AND status=? AND action=? ORDER BY slno DESC LIMIT 1",
                    [$rows->case_no, 'P', 'F'])->num_rows();

                if($sro_check == 0)
                {
                    $srobtn = '<button title="Re Forward to SRO" class="btn btn-success btn-sm forward_dc_btn" onclick="reforward_to_sro_with_deed_details_adc(\''.$rows->case_no.'\')">Reforward to SRO</button>';
                }


                $institute_link = '';
                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', [$rows->case_no, 1]);

                if ($revialSql->num_rows() > 0) {
                    $revival_flg_button = '';
                } else {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\'' . $rows->case_no . '\',\'' . $rows->service_code . '\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="' . base_url() . 'index.php/SettlementCommon/downloadRejectedCases/?service=' . $s_code . '">Download Reject Cases</a>';

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($status == MB_PAYMENT_REQUEST)
                {
                    $tenant_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_TENANT == OPEN)
                    {
                        $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';
                    }

                    $tribal_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_TENANT == OPEN)
                    {
                        $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';
                    }


                    $ap_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_AP == OPEN)
                    {
                        $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';
                    }


                    $khas_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_KHAS== OPEN)
                    {
                        $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Payment Notice</a>';
                    }

                    $vgr_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_VGR == OPEN)
                    {
                        $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';
                    }


                    $tea_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_TEA == OPEN)
                    {
                        $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';
                    }


                    $bhoddan_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/BhoodanController/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Payment Notice</a>';



                }
                elseif ($status == MB_PAYMENT_NOTICE)
                {

                    if ($rows->chitha_processing_details == 1) {
                        $lm_chitha_report = 'Yes';
                    } elseif ($rows->chitha_processing_details == 2) {
                        $lm_chitha_report = 'Yes';
                    } elseif ($rows->chitha_processing_details == 0) {
                        $lm_chitha_report = 'No';
                    }

                    if ($rows->chitha_processing_details == 2) {
                        $co_approved_status = 'Yes';
                    } elseif ($rows->chitha_processing_details == 1) {
                        $co_approved_status = 'No';
                    } elseif ($rows->chitha_processing_details == 0) {
                        $co_approved_status = 'No';
                    }


                    $tenant_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_TENANT_CON_PAY == OPEN)
                    {
                        $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';
                    }


                    $tribal_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_TENANT_CON_PAY == OPEN)
                    {
                        $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>


                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';
                    }

                    $ap_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_AP_CON_PAY == OPEN)
                    {
                        $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';
                    }

                    $khas_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_KHAS_CON_PAY == OPEN)
                    {
                        $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    }


                    $bhoddan_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';


                    $vgr_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_VGR_CON_PAY == OPEN)
                    {
                        $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>
                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    }


                    $tea_link = '';
                    if(MB2_GENERATE_PAYMENT_NOTICE_PAGE_TEA_CON_PAY == OPEN)
                    {
                        $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>

                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>


                        <br>

                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    }

                }
                else if ($status == MB_ORDER_FOR_CHITHA_UPDATE) {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    View</a>

                    <a href="' . base_url() . 'index.php/SettlementMbCo/coFinalOrderUpdate?case_no=' . $rows->case_no . '&dist_code=' . $rows->dist_code . '&subdiv_code=' . $rows->subdiv_code . '&cir_code=' . $rows->cir_code . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you would like to update chitha for this case?\');">Update Chitha</a>

                    ';
                } else if (trim($reverted) == 'ADC' or trim($reverted) == 'LM') {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';

                    $bhoddan_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';

                }
                else if ($status == MB_DISMISS)
                {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>  ' . $revival_flg_button . $download_rejected_cases;
                    $bhoddan_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>  ' . $revival_flg_button . $download_rejected_cases;

                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a> ' . $revival_flg_button . $download_rejected_cases;
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>' . $revival_flg_button . $download_rejected_cases;
                }
                else
                {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $bhoddan_link = '<a type="button" href="' . base_url() . 'index.php/BhoodanControllerCo/bhoodanCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        Write Report</a>';

                    $tenant_urban_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCoUrban/settlementTenantCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';

                    $tea_grant_link = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/TeaGrantCo?case=' . $this->utilityclass->encryptJwtCase($rows->case_no) . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>&nbsp;'.$srobtn;

                    $institute_link = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/settlementInsCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

                }

                if ($status == MB_PAYMENT_NOTICE) {
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', [$rows->case_no, 1]);

                    if ($sqlgrn->num_rows() <= 0) {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    } else {
                        if (isset($sqlgrn->row()->grn_no)) {
                            if ($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '') {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            } else {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        } else {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }

                    $json[] = [
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        // date("Y-m-d", strtotime($rows->date_entry)),

                        // $lmnoteRemark,

                        $grn_status,
                        $lm_chitha_report,
                        $co_approved_status,

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link :
                            (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link :
                                (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link :
                                    (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link :
                                        (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link :
                                            (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link :
                                                (($s_code == BHODDAN_SERVICE_CODE) ? $bhoddan_link : ''))))))),
                    ];

                } else {
                    $json[] = [
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        date("Y-m-d", strtotime($rows->date_entry)),

                        $lmnoteRemark,

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link :
                            (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link :
                                (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link :
                                    (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link :
                                        (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link :
                                            (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link :
                                                (($s_code == SETTLEMENT_TENANT_URBAN_ID) ? $tenant_urban_link :
                                                    (($s_code == TEA_SERVICE_CODE) ? $tea_grant_link :
                                                        (($s_code == BHODDAN_SERVICE_CODE) ? $bhoddan_link :
                                                            (($s_code == SLIJE_ID) ? $institute_link : ''

                                                            )))))))))),
                    ];
                }

            }

            $this->db->where('a.service_code', $s_code);

            if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM') {
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);

            } else if (trim($reverted) == 'ADC') {
                $this->db->where_not_in('a.pending_officer', [MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER]);
            } else {

                // if ($this->session->userdata('user_desig_code') == 'SK')
                // {
                //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                // else
                // {
                //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
                //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
            }

            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            // $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');

            // if($s_code == 14 && $status == 'X')
            // {
            //     $this->db->join('settlement_dag_details c', 'a.case_no = c.case_no');

            //     if(!empty($nr_cat))
            //     {
            //         if(trim($nr_cat) == 'Yes')
            //         {
            //             $this->db->where('c.new_dag_no is not null');
            //         }
            //         else
            //         {
            //             $this->db->where('c.new_dag_no is null');
            //         }
            //     }
            // }

            // if($s_code == 14)
            // {
            //     if(trim($reverted) == 'LM' and $status =='V'){
            //         $this->db->select("distinct(a.case_no),a.service_code, c.new_dag_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry");
            //         $this->db->select('(select \'0\') as lm_note');
            //     }else{
            //         $this->db->select('distinct(a.case_no), c.new_dag_no, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            //     }
            // }
            // else
            // {

            // if(trim($reverted) == 'LM' and $status =='V'){
            //     $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
            //     $this->db->select('(select \'0\') as lm_note');
            // }else{
            //     $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            // }

            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->select('distinct(a.case_no)');
                $this->db->select('(select \'0\') as lm_note');
            } else {
                $this->db->select('distinct(a.case_no)');
            }

            //}

            if (trim($reverted) != 'ADC') {
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            } else {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if ($s_code == 14 && ($status != 'R' && $status != 'X' && $status != 'M' && $status != 'N' && $status != 'D')) {
                if (trim($reverted) != 'ADC') {
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status == 'W') || trim($reverted) == 'LM' and $status == 'V') {

                    } else {
                        $this->db->where('a.notice_generated_yn', null);
                    }
                }
            }

            if ($status == MB_PAYMENT_NOTICE) {
                $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
                $this->db->where('c.is_final', 1);

                if (! empty($payment_status)) {
                    if (trim($payment_status) == 'paid') {
                        $this->db->where('c.grn_no is not null');
                    } elseif (trim($payment_status) == 'unpaid') {
                        $this->db->where('c.grn_no is null');
                    }

                }

                if (! empty($final_verification_report)) {
                    if ($final_verification_report == 'Yes') {
                        $this->db->where_in('a.chitha_processing_details', [1, 2]);
                    } else if ($final_verification_report == 'No') {
                        $this->db->where('a.chitha_processing_details', 0);
                    } elseif (trim($final_verification_report) == 'land_class_issue') {
                        // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                        // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

                    }
                }

                if (! empty($co_approved)) {
                    if ($co_approved == 'Yes') {
                        $this->db->where('a.chitha_processing_details', 2);
                    } else if ($co_approved == 'No') {
                        $this->db->where_in('a.chitha_processing_details', [1, 0]);
                    }
                }
            }

            // $total_records = $this->db->count_all_results('settlement_basic a');
            $data          = $this->db->get('settlement_basic a');
            $total_records = $data->num_rows();
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function paginationCoFirstBulk()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code         = $this->input->post('service');
        $search_term    = $this->input->post('search_term');
        $remark_cat     = $this->input->post('remark_cat');
        $urbanRural     = $this->input->post('urbanRural');
        $reverted       = $this->input->post('reverted');
        $user_code      = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');
        $sub_date       = $this->input->post('sub_date');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');
        $review_cat         = $this->input->post('review_cat');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

//        dd($urbanRural);

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if($s_code == 16)
        {
            if (! empty($urbanRural))
            {
                if($urbanRural == 1)
                {
                    $this->db->where('p.area_name', 10); // Rural
                }
                elseif ($urbanRural == 2)
                {
                    $this->db->where_not_in('p.area_name', [10]); // Urban
                }
            }
        }


        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if ($review_cat == '1') {
            $this->db->where('a.old_case_no is null');
            $review_stat = 'Normal Case';
        } else {
            $this->db->where('a.old_case_no is not null');
            $review_stat = 'Review Case';
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if (trim($reverted) == 'LM') {
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);

        } else if (trim($reverted) == 'ADC') {
            $this->db->where_not_in('a.pending_officer', [MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER]);
        } else {
            $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
        }
        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }

        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        } else {
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
        }

        if (trim($reverted) != 'ADC') {
            $this->db->where('a.status', $status);
        }


        if(!empty($sub_date))
        {
            $this->db->where("CAST(a.submission_date AS TEXT) LIKE", $sub_date . '%');
        }

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if (trim($reverted) == 'LM' and $status == 'V') {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        } else {
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if($s_code == 16)
        {
            if (! empty($urbanRural))
            {
                $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
            }
        }

        if ($s_code == 14 && ($status != 'R' && $status != 'X' && $status != 'M' && $status != 'N' && $status != 'D')) {
            if (trim($reverted) != 'ADC') {
                if (($this->session->userdata('user_desig_code') == 'SK' and $status == 'W') || trim($reverted) == 'LM' and $status == 'V') {

                } else {
                    $this->db->where('a.notice_generated_yn', null);
                }
            }
        }

        $this->db->from('settlement_basic a');
        $query = $this->db->get();
        //dd($this->db->last_query());

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {

                if (trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . enc_param('case_no', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $json[] = [
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark,

                    $review_stat,

                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                ];

            }

            $this->db->where('a.service_code', $s_code);

            if (! empty($remark_cat)) {
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM') {
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);

            } else if (trim($reverted) == 'ADC') {
                $this->db->where_not_in('a.pending_officer', [MB_LOT_MONDOL, MB_SUPERVISOR_KANANGU, MB_CIRCLE_OFFICER]);
            } else {
                $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }
            if($s_code == 16)
            {
                if (! empty($urbanRural))
                {
                    if($urbanRural == 1)
                    {
                        $this->db->where('p.area_name', 10); // Rural
                    }
                    elseif ($urbanRural == 2)
                    {
                        $this->db->where_not_in('p.area_name', [10]); // Urban

                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
            }

            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
                $this->db->select('(select \'0\') as lm_note');
            } else {
                $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            }

            if (trim($reverted) != 'ADC') {
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            if (trim($reverted) == 'LM' and $status == 'V') {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            } else {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }
            if($s_code == 16)
            {
                if (! empty($urbanRural))
                {
                    $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
                }
            }

            if ($s_code == 14 && ($status != 'R' && $status != 'X' && $status != 'M' && $status != 'N' && $status != 'D')) {
                if (trim($reverted) != 'ADC') {
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status == 'W') || trim($reverted) == 'LM' and $status == 'V') {

                    } else {
                        $this->db->where('a.notice_generated_yn', null);
                    }
                }
            }

            $total_records = $this->db->count_all_results('settlement_basic a');
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    // Pagination for co end for AP Case 03/07/2023 by Masud Reza
    public function paginationForApSecondPreceding()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $curr_date   = date('Y-m-d');
        $s_code      = $this->input->post('service');
        $search_term = $this->input->post('search_term');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $remark_cat = $this->input->post('remark_cat');
        // $reverted = $this->input->post('reverted');
        // $user_code = $this->session->userdata('user_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');

        $notice_date = $this->input->post('notice_date');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
            // 1   => 'applid',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        // if(!empty($search)){
        //     // $this->db->like($s_terms, $search);
        //     $this->db->like('case_no', $search);
        // }

        if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note

            if ($remark_cat == 3) {
                $this->db->where('b.case_no IS NULL');
            } else {
                $this->db->where('b.lm_note', $remark_cat);
            }
        }

        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        if (! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);

        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
        } elseif (($this->session->userdata('user_desig_code') == 'CO') && $status == 'V' && $s_code == 14) {
            $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
            $this->db->where("a.from_office !='DC'");
        } elseif (($this->session->userdata('user_desig_code') == 'AST') && ($status == 'V' or $status == 'v') && $s_code == 14) {
            $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU, 'LM']);
        } else {
            $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
            // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
        }

        $user_code = $this->session->userdata('user_code');

        if ($this->session->userdata('user_desig_code') == 'CO') {
            $this->db->where("(a.co_code = '" . $user_code . "' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        if ($status != 'V' && $status != 'v') {
            $this->db->where('a.status', $status);
        } else {
            // $this->db->where("a.status !='D'");
            // $this->db->where('a.status not in(\'D\',\'X\')');
            if ($this->session->userdata('user_desig_code') == 'AST') {
                $this->db->where("a.status !='D'");
            } else {
                $this->db->where('a.status', 'W');
            }
        }
        if ($status == 'V' && $this->session->userdata('user_desig_code') == 'AST') {
            $this->db->where('a.ast_notice_print_yn is null');
        }
        if ($status == 'v' && $this->session->userdata('user_desig_code') == 'AST') {
            $this->db->where('a.ast_notice_print_yn', 'Y');
        }

        $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.notice_generated_date');

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        if ($s_code == 14) {
            $this->db->where('a.notice_generated_yn', 'Y');

            if ($notice_date == 'already_completed') // greater than 30 days
            {
                $this->db->where("(date(a.notice_generated_date) + INTERVAL '30 days') < ", "$curr_date");
                // + INTERVAL 30 DAY
            } else if ($notice_date == 'tobe_completed_2_days') // to be completed in 2 days
            {
                $newDate = date('Y-m-d', strtotime($curr_date . ' - 2 days'));
                $this->db->where('date(a.notice_generated_date)', $newDate);
            } else if ($notice_date == 'tobe_completed_1_day') // to be completed in 1 day
            {
                $newDate = date('Y-m-d', strtotime($curr_date . ' - 1 day'));
                $this->db->where('date(a.notice_generated_date)', $newDate);
            }
        }

        $this->db->join("settlement_ap_lmnote b", "a.case_no = b.case_no", "LEFT");

        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else if (trim($rows->lm_note) == 2) {
                    $lmnoteRemark = 'Not Recommended';
                } else if ($rows->lm_note == null) {
                    $lmnoteRemark = 'LM Report Not submitted';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($status == MB_PAYMENT_REQUEST) {
                    $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Payment Notice</a>';

                    $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                } elseif ($status == MB_PAYMENT_NOTICE) {
                    $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';

                    $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';

                    $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        write report</a>';

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                } else if ($status == MB_ORDER_FOR_CHITHA_UPDATE) {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    View</a>

                    <a href="' . base_url() . 'index.php/SettlementMbCo/coFinalOrderUpdate?case_no=' . $rows->case_no . '&dist_code=' . $rows->dist_code . '&subdiv_code=' . $rows->subdiv_code . '&cir_code=' . $rows->cir_code . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you would like to update chitha for this case?\');">Update Chitha</a>

                    ';
                } else if (($status == 'V' || $status == 'v') && ($this->session->userdata('user_desig_code') == 'AST')) {
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementAst/settlementApAst?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                } else {
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                }

                $json[] = [

                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),
                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark,
                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),

                ];
            }

            // echo $this->db->last_query();

            if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note

                if ($remark_cat == 3) {
                    $this->db->where('b.case_no IS NULL');
                } else {
                    $this->db->where('b.lm_note', $remark_cat);
                }
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                $this->db->where("(a.co_code = '" . $user_code . "' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->where('a.service_code', $s_code);

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
            } elseif (($this->session->userdata('user_desig_code') == 'CO') && $status == 'V' && $s_code == 14) {
                $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
                $this->db->where("a.from_office !='DC'");
            } elseif (($this->session->userdata('user_desig_code') == 'AST') && ($status == 'V' or $status == 'v') && $s_code == 14) {
                $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU, 'LM']);
            } else {
                $this->db->where('a.pending_officer', [MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU]);
            }

            if ($status != 'V' && $status != 'v') {
                $this->db->where('a.status', $status);
            } else {
                // $this->db->where("a.status !='D'");
                // $this->db->where('a.status not in(\'D\',\'X\')');
                if ($this->session->userdata('user_desig_code') == 'AST') {
                    $this->db->where("a.status !='D'");
                } else {
                    $this->db->where('a.status', 'W');
                }
            }

            if ($status == 'V' && $this->session->userdata('user_desig_code') == 'AST') {
                $this->db->where('a.ast_notice_print_yn is null');
            }
            if ($status == 'v' && $this->session->userdata('user_desig_code') == 'AST') {
                $this->db->where('a.ast_notice_print_yn', 'Y');
            }

            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            if ($s_code == 14) {
                $this->db->where('a.notice_generated_yn', 'Y');
            }
            $this->db->join("settlement_ap_lmnote b", "a.case_no = b.case_no", "LEFT");
            $total_records = $this->db->count_all_results('settlement_basic a');

            $response = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    // Pagination Confirm Payment list for AP Case assistant 06/01/2024 by Masud Reza
    public function paginationAsst()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'AST') {
            $this->session->set_flashdata('message', "#HOMEC250773 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

        $s_code         = $this->input->post('service');
        $search_term    = $this->input->post('search_term');
        $remark_cat     = $this->input->post('remark_cat');
        $reverted       = $this->input->post('reverted');
        $user_code      = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $pagination = $this->input->post('pagination');

        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved               = $this->input->post('co_approved');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details,a.status');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.status', 'N');
        $this->db->where('a.chitha_processing_details', 2);
        $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER]);
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
        $this->db->where('c.is_final', 1);
        $this->db->where('c.grn_no is not null');
        $this->db->from('settlement_basic a');

        $query = $this->db->get();

//         echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', [$rows->case_no, 1]);

                if ($revialSql->num_rows() > 0) {
                    $revival_flg_button = '';
                } else {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\'' . $rows->case_no . '\',\'' . $rows->service_code . '\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="' . base_url() . 'index.php/SettlementCommon/downloadRejectedCases/?service=' . $s_code . '">Download Reject Cases</a>';

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                $tenant_link = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>';

                $tribal_link = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>';

                $ap_link = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>';

                $khas_link = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>';

                $vgr_link = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>';

                $tea_link = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app=' . $this->utilityclass->encryptJwtCase($rows->applid) . '" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>';

                if ($status == MB_PAYMENT_NOTICE) {
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', [$rows->case_no, 1]);

                    if ($sqlgrn->num_rows() <= 0) {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    } else {
                        if (isset($sqlgrn->row()->grn_no)) {
                            if ($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '') {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            } else {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        } else {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }

                    $json[] = [
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                    ];

                } else {
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', [$rows->case_no, 1]);

                    if ($sqlgrn->num_rows() <= 0) {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    } else {
                        if (isset($sqlgrn->row()->grn_no)) {
                            if ($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '') {
                                $lmnoteRemark = '<strong class="text-danger">NOT PAID</strong>';
                            } else {
                                $lmnoteRemark = '<strong class="text-success">PAID</strong>';
                            }
                        } else {
                            $lmnoteRemark = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }
                    $json[] = [
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        date("Y-m-d", strtotime($rows->date_entry)),

                        $lmnoteRemark,

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                    ];
                }

            }

            $this->db->where('a.service_code', $s_code);

            if (! empty($remark_cat)) {
                $this->db->where('b.lm_note', $remark_cat);
            }

            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details,a.status');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.status', 'N');
            $this->db->where('a.chitha_processing_details', 2);
            $this->db->where_in('a.pending_officer', [MB_CIRCLE_OFFICER]);
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);
            $this->db->where('c.grn_no is not null');
            $total_records = $this->db->count_all_results('settlement_basic a');
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function apiAadharWiseApplication()
    {

        $application_no = $this->input->get('app');
        $postRequest    = [
            'application_no' => $application_no,
        ];

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, AADHAR_APPLICATION_API_LINK);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $output = curl_exec($cURL);

        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if ($httpcode != 200) {
            return false;
        }
        $output = json_decode($output);

        log_message('error', 'AADHAAR_DATA: ' . json_encode($output->appiledDetails));

        $lmdata['applications'] = $output->appiledDetails;

//        printf('<pre>');
        //        print_r($lmdata);
        //        die();

        $lmdata['_view'] = 'SettlementView/include/AadharWiseApplicationtView';
        $this->load->view('layouts/main', $lmdata);

    }

    // pagination basundhara end with API -js-
    public function paginationAPI()
    {
        $service = $this->input->post('service');

        $draw       = intval($this->input->post('draw'));
        $start      = intval($this->input->post('start'));
        $length     = intval($this->input->post('length'));
        $order      = $this->input->post('order');
        $occupation = trim($this->input->post('occupation'));

        // $search = $this->input->post('search');
        // $search = $search['value'];

        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);

        $is_cat = $this->input->post('is_category');

        $is_rural = $this->input->post('rural');

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no             = $this->session->userdata('lot_no');
        $ru                 = $this->session->userdata('user_desig_code');

        $curl_handle = curl_init();
        //curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'start'         => $start,
            'length'        => $length,
            'order'         => $order,
            'searchByCol_0' => $searchByCol_0,
            'searchByCol_1' => $searchByCol_1,
            'is_cat'        => $is_cat,
            'is_rural'      => $is_rural,
            'occupation'    => $occupation,
        ]));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        // var_dump($results);

        if (isset($results)) {
            //==============getting the reject_list
            $rejected_data = $this->SettlementCommonModel->getRejectModal($service);
            if ($rejected_data == 'n') {
                $rejected_list = false;
            } else {
                $rejected_list = $rejected_data;
            }

            $data_rows = $results->data_results;

            foreach ($data_rows as $rows) {

                $case_no = $this->utilityclass->getCaseNoByApplId((string) $dist_code, (string) $rows->application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

                $chithaRemarks = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $rejected_list);

                if ($chithaRemarks == true) {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                } else {
                    $chithaFlag = 'No';
                }

                $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenant/settlementTenantRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribal/TribalApplicationRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementAp/settlementApplication?app=' . $rows->application_no . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasLand/applicationKhaslandRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgr/applicationVgrRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCultivator/settlementApplication?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $json[] = [
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $rows->date_submission,
                    $rows->applicant_occupation,
                    $rows->type,
                    '<b>' . $chithaFlag . '</b>',
                    $rows->rurban,

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),

                    (($service == SETTLEMENT_TENANT_ID) ? $tenant_link : (($service == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($service == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($service == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($service == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($service == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                ];
            }

            $total_records = $results->total_records;
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];
            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function viewPendingCases($scode)
    {
        $data['dist_code']    = $this->session->userdata('dist_code');
        $data['subdiv_code']  = $this->session->userdata('subdiv_code');
        $data['cir_code']     = $this->session->userdata('cir_code');
        $data['service_code'] = $scode;

        $curl_handle = curl_init();
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');

        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "SelectListPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$scode");
        // curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/rtpsmb2/Api/SelectListPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$scode");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([]));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        $data['selectList'] = $results;

        $data['_view'] = 'SettlementView/pendingcases_list';
        $this->load->view('layouts/main', $data);

    }

    public function viewPendingCasesAPI()
    {

        $service = $this->input->post('service_code');

        $dist_code   = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code    = $this->input->post('cir_code');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        $is_cat     = $this->input->post('is_category');
        $is_rural   = $this->input->post('rural');
        $pending_at = $this->input->post('pending_at');

        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service");

        // curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/rtpsmb2/Api/viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'start'         => $start,
            'length'        => $length,
            'order'         => $order,
            'searchByCol_0' => $searchByCol_0,
            'searchByCol_1' => $searchByCol_1,
            'is_cat'        => $is_cat,
            'is_rural'      => $is_rural,
            'pending_at'    => $pending_at,
        ]));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        // var_dump($results);
        // die;

        if (isset($results)) {

            $data_rows = $results->data_results;

            foreach ($data_rows as $rows) {

                $sql         = "SELECT * FROM settlement_basic WHERE applid = '$rows->application_no'";
                $result_data = $this->db->query($sql);

                if ($result_data->num_rows() > 0) {
                    $get_case_no = $result_data->row()->case_no;

                    $view_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $get_case_no . '" class="lmreportmut btn-sm btn btn-primary">
                        view</a>';
                } else {
                    $view_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommon/viewBasundharaApplication?app=' . $rows->application_no . '" class="lmreportmut btn-sm btn btn-primary">
                        view</a>';
                }

                $json[] = [
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $rows->date_submission,
                    $rows->rurban,

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),

                    $rows->pending_with_officer,
                    $view_link,
                ];
            }

            $total_records = $results->total_records;
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];
            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function viewBasundharaApplication()
    {
        $application_no = $this->input->get('app');

        $token       = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'application_no' => $application_no,
            'api_key'        => API_KEY,
            'token'          => $token,
        ]));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType == 3) {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);

        $output = json_decode($output);

        $data['application'] = $output->application;
        $data['applicant']   = $output->applicants;
        $data['document']    = $output->documents;
        $data['property']    = $output->property;
        $data['settlements'] = $output->settlements;
        $data['encroachers'] = $output->encroachers;
        $data['owners']      = $output->owners;
        $data['riotee_noks'] = $output->riotee_noks;
        $data['aadhar']      = $output->aadhar;
        $data['nextKin']     = $output->nextKin;

        $data['application'] = $output->application;
        $data['pattaNo']     = $this->utilityclass->getPattaTypeNo($data['application']->dist_code, $data['application']->subdiv_code, $data['application']->cir_code, $data['application']->mouza_code, $data['application']->lot_no, $data['application']->village_code, $data['application']->dag_no);

        // get khatian number
        $d   = $data['application']->dist_code;
        $s   = $data['application']->subdiv_code;
        $c   = $data['application']->cir_code;
        $m   = $data['application']->mouza_code;
        $l   = $data['application']->lot_no;
        $v   = $data['application']->village_code;
        $pno = $data['pattaNo']->patta_no;
        $pc  = $data['pattaNo']->patta_type_code;
        $dag = $data['application']->dag_no;

        $data['bhumi'] = $output->bhumi;

        // if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
        //     $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
        //     redirect(base_url() . "index.php/home");
        // }

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", [$application_no, GEO_TAG_PHOTO]);

        if ($supportive_document_sql == true) {
            if ($supportive_document_sql->num_rows() > 0) {
                $data['geo_tag_doc'] = $supportive_document_sql->result();
            } else {
                $data['geo_tag_doc_empty'] = "Geo tag photo yet to be uploaded.";
            }
        }

        // fetch owner details -js- 05-09-2022

        if ($output->owners == true) {
            foreach ($output->owners as $allapplicants) {

                if ($allapplicants->mobile == null) {
                    $mobile_tenant = "'NA'";
                } else {
                    $mobile_tenant = $allapplicants->mobile;
                }
                $query   = "SELECT pdar_id, pdar_name, pdar_father, $mobile_tenant as mobile FROM chitha_pattadar WHERE dist_code= '$d' AND subdiv_code='$s' AND cir_code='$c' AND lot_no='$l' AND mouza_pargona_code='$m' AND vill_townprt_code='$v' AND trim(patta_no)=trim('$pno') AND patta_type_code='$pc' AND pdar_id='$allapplicants->chitha_pdar_id' ";
                $owner[] = $this->db->query($query)->result();
            }
            $data['owner'] = $owner;
        }

        // echo "<pre>";
        // var_dump($district['owner']);
        // die;

        // fetch riotee noks -js- 05-09-2022
        if ($output->riotee_noks == true) {
            $data['riotee_nok'] = $output->riotee_noks;
        }

        if ($output->selfDeclaration) {
            foreach ($output->selfDeclaration as $selfDec) {
                $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
            }
        }

        if ($output->encroachers == true) {
            foreach ($output->encroachers as $encroacher) {

                $vlb_encroacher  = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                $data['vlb_enc'] = $vlb_encroacher;

                if ($vlb_encroacher == true) {
                    // getting the encroacher details
                    $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                    $vlb_encc[]            = $vlb_encroacher_in_dag;
                } else {
                    $data['empty_err'] = "No Land Bank Details found!!";
                }
            }
            if (isset($vlb_encc)) {
                $data['vlb_enc_details'] = $vlb_encc;
            }
        }

        // for tenant
        if ($output->settlements) {
            foreach ($output->settlements as $settlements) {
                if (isset($settlements->khatian_no) && $settlements->khatian_no) {
                    $data['khatian_no'] = $settlements->khatian_no;
                }
            }
        }
        if ($output->encroachers) {
            //    fetch encroachers -js- 05-09-2022
            foreach ($output->encroachers as $encroacher) {
                if (isset($encroacher->khatian_no) && $encroacher->khatian_no) {
                    $khatian_no = $encroacher->khatian_no;
                    $query      = "SELECT * FROM chitha_tenant WHERE subdiv_code='$s' AND cir_code='$c' AND lot_no='$l' AND mouza_pargona_code='$m' AND vill_townprt_code='$v' AND dag_no ='$encroacher->dag_no' AND khatian_no ='$encroacher->khatian_no' AND tenant_id = '$encroacher->encroacher_id'";
                    $riotee[]   = $this->db->query($query)->result();
                }
            }
            if (isset($riotee) && $riotee) {
                $data['riotee'] = $riotee;
            }
        }

        if (isset($khatian_no) && $khatian_no) {
            $data['riotee_list'] = $this->SettlementTenantModel->getRioteeList($d, $s, $c, $m, $l, $v, $dag, $khatian_no);
        }
        $data['_view'] = 'SettlementView/basundhara_application_view';
        $this->load->view('layouts/main', $data);

    }

    // area update at CO end
    public function areaUpdate()
    {
        $case_no     = $this->input->post('case_no');
        $dags        = $this->SettlementKhasModel->getSettlementDag($case_no);
        $reservation = $this->SettlementVgrModel->getSettlementReservation($case_no);

        $distCode = $this->session->userdata('dist_code');

        $totalDagAreaLessaValidation      = 0;
        $totalAgrAreaLessaValidation      = 0;
        $totalHomeAreaLessaValidation     = 0;
        $appAreaMoreThanDagA              = 0;
        $reserveMoreThanAppArea           = 0;
        $familyMoreThanAppArea            = 0;
        $totalRoadSideAreaLessaValidation = 0;
        $totalFamilyAreaLessaValidation   = 0;

        $service_code = $this->utilityclass->getServiceCode($case_no);

        if ($service_code == SETTLEMENT_TENANT_ID) {
            $redirect_link = 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no;
        } elseif ($service_code == SETTLEMENT_AP_TRANSFER_ID) {
            $redirect_link = 'index.php/SettlementApCo/settlementApCo?case=' . $case_no;
        } elseif ($service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
            $redirect_link = 'index.php/SettlementTribalCo/settlementTribalCo?case=' . $case_no;
        } elseif ($service_code == SETTLEMENT_KHAS_LAND_ID) {
            $redirect_link = 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no;
        } elseif ($service_code == SETTLEMENT_PGR_VGR_LAND_ID) {
            $redirect_link = 'index.php/SettlementVgrCo/settlementVgrCo?case=' . $case_no;
        } elseif ($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
            $redirect_link = 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $case_no;
        }

        if ($service_code != SETTLEMENT_AP_TRANSFER_ID && $service_code != SETTLEMENT_TENANT_ID) {
            // for barak valley
            if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                foreach ($dags as $dag) {
                    $this->form_validation->set_rules('dag_area_b' . $dag->id, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k' . $dag->id, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc' . $dag->id, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('dag_area_g' . $dag->id, 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('dag_area_kr' . $dag->id, 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('home_b' . $dag->id, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('home_k' . $dag->id, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('home_lc' . $dag->id, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('home_g' . $dag->id, 'Applied Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('home_kr' . $dag->id, 'Applied Homestead Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('agri_b' . $dag->id, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('agri_k' . $dag->id, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('agri_lc' . $dag->id, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('agri_g' . $dag->id, 'Applied Agricultural Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('agri_kr' . $dag->id, 'Applied Agricultural Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b' . $dag->id), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k' . $dag->id), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc' . $dag->id), 0);
                    $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g' . $dag->id), 0);

                    $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b' . $dag->id), 0);
                    $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k' . $dag->id), 0);
                    $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc' . $dag->id), 0);
                    $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g' . $dag->id), 0);

                    $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b' . $dag->id), 0);
                    $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k' . $dag->id), 0);
                    $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc' . $dag->id), 0);
                    $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g' . $dag->id), 0);

                    $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                    $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                    $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                    if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation) {
                        $appAreaMoreThanDagA = 1;
                    }

                    $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                    $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                    $totalAgrAreaLessaValidation += $agrAreaLessaValidation;

                }

                if ($reservation == true) {
                    foreach ($reservation as $dagsR) {
                        if ($dagsR->type == 'R') {
                            $this->form_validation->set_rules('reserved_bigha' . $dagsR->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha' . $dagsR->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa' . $dagsR->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda' . $dagsR->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti' . $dagsR->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $dagsR->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $dagsR->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $dagsR->dag_no), 0);
                            $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda' . $dagsR->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;

                        }

                    }

                    foreach ($reservation as $dagsF) {
                        if ($dagsF->type == 'F') {

                            $this->form_validation->set_rules('reserved_bigha_family' . $dagsF->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha_family' . $dagsF->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa_family' . $dagsF->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_ganda_family' . $dagsF->dag_no, 'Reserved Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                            $this->form_validation->set_rules('reserved_kranti_family' . $dagsF->dag_no, 'Reserved Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family' . $dagsF->dag_no), 0);
                            $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family' . $dagsF->dag_no), 0);
                            $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family' . $dagsF->dag_no), 0);
                            $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family' . $dagsF->dag_no), 0);

                            $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation) {
                                $familyMoreThanAppArea = 1;
                            }

                            $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;

                        }
                    }
                }
            } else {
                foreach ($dags as $dagV) {
                    $this->form_validation->set_rules('dag_area_b' . $dagV->id, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k' . $dagV->id, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc' . $dagV->id, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('home_b' . $dagV->id, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('home_k' . $dagV->id, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('home_lc' . $dagV->id, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('agri_b' . $dagV->id, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('agri_k' . $dagV->id, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('agri_lc' . $dagV->id, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b' . $dagV->id), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k' . $dagV->id), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc' . $dagV->id), 0);

                    $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b' . $dagV->id), 0);
                    $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k' . $dagV->id), 0);
                    $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc' . $dagV->id), 0);

                    $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b' . $dagV->id), 0);
                    $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k' . $dagV->id), 0);
                    $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc' . $dagV->id), 0);

                    $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                    $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                    $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                    if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation) {
                        $appAreaMoreThanDagA = 1;
                    }

                    $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                    $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                    $totalAgrAreaLessaValidation += $agrAreaLessaValidation;

                }

                if ($reservation == true) {
                    foreach ($reservation as $dagsRoad) {
                        if ($dagsRoad->type == 'R') {
                            $this->form_validation->set_rules('reserved_bigha' . $dagsRoad->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha' . $dagsRoad->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa' . $dagsRoad->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $dagsRoad->dag_no), 0);
                            $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $dagsRoad->dag_no), 0);
                            $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $dagsRoad->dag_no), 0);

                            $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside;

                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation) {
                                $reserveMoreThanAppArea = 1;
                            }
                            $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                        }
                    }

                    foreach ($reservation as $dagsFamily) {
                        if ($dagsFamily->type == 'F') {

                            $this->form_validation->set_rules('reserved_bigha_family' . $dagsFamily->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                            $this->form_validation->set_rules('reserved_katha_family' . $dagsFamily->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                            $this->form_validation->set_rules('reserved_lessa_family' . $dagsFamily->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                            $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family' . $dagsFamily->dag_no), 0);
                            $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family' . $dagsFamily->dag_no), 0);
                            $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family' . $dagsFamily->dag_no), 0);

                            $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;
                            if ($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation) {
                                $familyMoreThanAppArea = 1;
                            }

                            $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;

                        }
                    }
                }
            }

            if ($this->form_validation->run() == false) {
                $errors = validation_errors();
                $this->session->set_flashdata('message', $errors);
                redirect(base_url() . $redirect_link);
            }

            if ($reserveMoreThanAppArea == 1) {
                $this->session->set_flashdata('message', 'Total roadside reserved area should not be more than total applied area  !');
                redirect(base_url() . $redirect_link);
            }
            if ($familyMoreThanAppArea == 1) {
                $this->session->set_flashdata('message', 'Total family reserved area should not be more than total applied area  !');
                redirect(base_url() . $redirect_link);
            }
            if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0) {
                $this->session->set_flashdata('message', 'Total applied area should not be Zero !');
                redirect(base_url() . $redirect_link);
            }

            if ($appAreaMoreThanDagA == 1) {
                $this->session->set_flashdata('message', 'Total applied area should not be more than total Dag Area !');
                redirect(base_url() . $redirect_link);

            }

            // for barak valley
            if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                if (KHAS_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation) {
                    $this->session->set_flashdata('message', 'Total applied Homestead area should not be more than ' . KHAS_MAX_HOMESTEAD . ' Bigha !');
                    redirect(base_url() . $redirect_link);
                }
                if (KHAS_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation) {
                    $this->session->set_flashdata('message', 'Total applied Agriculture area should not be more than ' . KHAS_MAX_AGRICULTURE . ' Bigha !');
                    redirect(base_url() . $redirect_link);
                }
            } else {
                if (KHAS_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation) {
                    $this->session->set_flashdata('message', 'Total applied Homestead area should not be more than ' . KHAS_MAX_HOMESTEAD . ' Bigha !');
                    redirect(base_url() . $redirect_link);
                }
                if (KHAS_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation) {
                    $this->session->set_flashdata('message', 'Total applied Agriculture area should not be more than ' . KHAS_MAX_AGRICULTURE . ' Bigha !');
                    redirect(base_url() . $redirect_link);
                }
            }

            $this->db->trans_begin();

            $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'CO'")->row()->ct;

            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            $phase_count  = (int) $phase_count + 1;
            $backup_array = [
                'applid'      => $applid_backup,
                'case_no'     => $case_no,
                'from_office' => 'CO',
                'to_office'   => 'CO',
                'status'      => 'E',
                'phase'       => 'CO_' . $phase_count,
                'data'        => json_encode($_POST),
            ];

            $backup_insertion_co = $this->db->insert('settlement_backup_json', $backup_array);
            if ($backup_insertion_co != 1) {
                $this->db->trans_rollback();
                log_message('error', '#BACKUPCO001: Insertion failed in settlement_backup_json RTPS Case No ' . $case_no);

                $this->session->set_flashdata('error_data', "#BACKUPCO001: Registration of Settlement failed for case no : " . $case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            ////settlement_dag_details UPDATE start
            foreach ($dags as $applied_area) {
                $fmd = [
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d G:i:s'),
                ];

                $fmd['home_b']  = $this->input->post('home_b' . $applied_area->id);
                $fmd['home_k']  = $this->input->post('home_k' . $applied_area->id);
                $fmd['home_lc'] = $this->input->post('home_lc' . $applied_area->id);
                $fmd['home_g']  = $this->input->post('home_g' . $applied_area->id);
                $fmd['home_kr'] = $this->input->post('home_kr' . $applied_area->id);

                $fmd['agri_b']  = $this->input->post('agri_b' . $applied_area->id);
                $fmd['agri_k']  = $this->input->post('agri_k' . $applied_area->id);
                $fmd['agri_lc'] = $this->input->post('agri_lc' . $applied_area->id);
                $fmd['agri_g']  = $this->input->post('agri_g' . $applied_area->id);
                $fmd['agri_kr'] = $this->input->post('agri_kr' . $applied_area->id);

                $fmd['fbigha']  = $this->input->post('fbigha' . $applied_area->id);
                $fmd['fkatha']  = $this->input->post('fkatha' . $applied_area->id);
                $fmd['flessa']  = $this->input->post('flessa' . $applied_area->id);
                $fmd['fganda']  = $this->input->post('fganda' . $applied_area->id);
                $fmd['fkranti'] = $this->input->post('fkranti' . $applied_area->id);

                if ($fmd['home_b'] == '' || $fmd['home_b'] == null) {
                    $fmd['home_b'] = 0;
                }
                if ($fmd['home_k'] == '' || $fmd['home_k'] == null) {
                    $fmd['home_k'] = 0;
                }
                if ($fmd['home_lc'] == '' || $fmd['home_lc'] == null) {
                    $fmd['home_lc'] = 0;
                }
                if ($fmd['home_g'] == '' || $fmd['home_g'] == null) {
                    $fmd['home_g'] = 0;
                }
                if ($fmd['home_kr'] == '' || $fmd['home_kr'] == null) {
                    $fmd['home_kr'] = 0;
                }

                if ($fmd['agri_b'] == '' || $fmd['agri_b'] == null) {
                    $fmd['agri_b'] = 0;
                }
                if ($fmd['agri_k'] == '' || $fmd['agri_k'] == null) {
                    $fmd['agri_k'] = 0;
                }
                if ($fmd['agri_lc'] == '' || $fmd['agri_lc'] == null) {
                    $fmd['agri_lc'] = 0;
                }
                if ($fmd['agri_g'] == '' || $fmd['agri_g'] == null) {
                    $fmd['agri_g'] = 0;
                }
                if ($fmd['agri_kr'] == '' || $fmd['agri_kr'] == null) {
                    $fmd['agri_kr'] = 0;
                }

                if ($fmd['fbigha'] == '' || $fmd['fbigha'] == null) {
                    $fmd['fbigha'] = 0;
                }
                if ($fmd['fkatha'] == '' || $fmd['fkatha'] == null) {
                    $fmd['fkatha'] = 0;
                }
                if ($fmd['flessa'] == '' || $fmd['flessa'] == null) {
                    $fmd['flessa'] = 0;
                }
                if ($fmd['fganda'] == '' || $fmd['fganda'] == null) {
                    $fmd['fganda'] = 0;
                }
                if ($fmd['fkranti'] == '' || $fmd['fkranti'] == null) {
                    $fmd['fkranti'] = 0;
                }

                $fmd['s_dag_area_b']  = $fmd['home_b'] + $fmd['agri_b'] + $fmd['fbigha'];
                $fmd['s_dag_area_k']  = $fmd['home_k'] + $fmd['agri_k'] + $fmd['fkatha'];
                $fmd['s_dag_area_lc'] = $fmd['home_lc'] + $fmd['agri_lc'] + $fmd['flessa'];
                $fmd['s_dag_area_g']  = $fmd['home_g'] + $fmd['agri_g'] + $fmd['fganda'];
                $fmd['s_dag_area_kr'] = $fmd['home_kr'] + $fmd['agri_kr'] + $fmd['fkranti'];

                $rezaHome = $fmd['home_b'] + $fmd['home_k'] + $fmd['home_lc'] + $fmd['home_g'] + $fmd['home_kr'];
                $rezaAgri = $fmd['agri_b'] + $fmd['agri_k'] + $fmd['agri_lc'] + $fmd['agri_g'] + $fmd['agri_kr'];

                $landTypeUpdate = 0;
                if ($rezaHome > 0 && $rezaAgri > 0) {
                    $landTypeUpdate = 3;
                } else if ($rezaHome > 0) {
                    $landTypeUpdate = 1;
                } else if ($rezaAgri > 0) {
                    $landTypeUpdate = 2;
                }

                $fmd['land_type'] = $landTypeUpdate;

                $this->db->where('case_no', $case_no);
                $this->db->where('id', $applied_area->id);
                $this->db->update('settlement_dag_details', $fmd);

                // echo $this->db->last_query();
                // die;

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#AREAUPDATE0001: Updation failed in settlement_dag_details Dharitree Case No ' . $case_no);
                    $data = [
                        'error' => "#AREAUPDATE0001: Updation failed for case no : " . $case_no,
                    ];
                    echo json_encode($data);
                    return false;
                }
            }
        } elseif ($service_code == SETTLEMENT_AP_TRANSFER_ID) {

            //for tranfer of AP
            $appAreaMoreThanDagA  = 0;
            $roadsideMoreThanDagA = 0;
            $familyMoreThanDagA   = 0;
            $totalRoadSideRev     = 0;
            $totalFamilyRev       = 0;
            $totalAppArea         = 0;
            // for barak valley
            if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                if ($dagAreaLessaValidation < $appAreaLessaValidation) {
                    $appAreaMoreThanDagA = 1;
                }

                foreach ($reservation as $setl) {
                    if ($setl->type == 'R') {

                        $this->form_validation->set_rules('reserved_bigha' . $setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('reserved_katha' . $setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('reserved_lessa' . $setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('reserved_ganda' . $setl->dag_no, 'Reserved Roadside Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('reserved_kranti' . $setl->dag_no, 'Reserved Roadside Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $setl->dag_no), 0);
                        $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $setl->dag_no), 0);
                        $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $setl->dag_no), 0);
                        $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda' . $setl->dag_no), 0);

                        $dagAreaLessaValidationRoad = ($bighaValidationRoad * 6400) + ($kathaValidationRoad * 320) + ($lessaValidationRoad * 20) + $gandaValidationRoad;

                        if ($appAreaLessaValidation < $dagAreaLessaValidationRoad) {
                            $roadsideMoreThanDagA = 1;
                        }
                        $totalRoadSideRev += $dagAreaLessaValidationRoad;

                    }

                    if ($setl->type == 'F') {
                        $this->form_validation->set_rules('reserved_bigha_family' . $setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('reserved_katha_family' . $setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('reserved_lessa_family' . $setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('reserved_ganda_family' . $setl->dag_no, 'Reserved for Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('reserved_kranti_family' . $setl->dag_no, 'Reserved for Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family' . $setl->dag_no), 0);
                        $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family' . $setl->dag_no), 0);
                        $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family' . $setl->dag_no), 0);
                        $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family' . $setl->dag_no), 0);

                        $dagAreaLessaValidationFamily = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;

                        if ($appAreaLessaValidation < $dagAreaLessaValidationFamily) {
                            $familyMoreThanDagA = 1;
                        }
                        $totalFamilyRev += $dagAreaLessaValidationFamily;
                    }
                }

            } else {
                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                if ($dagAreaLessaValidation < $appAreaLessaValidation) {
                    $appAreaMoreThanDagA = 1;
                }

                foreach ($reservation as $setl) {
                    if ($setl->type == 'R') {

                        $this->form_validation->set_rules('reserved_bigha' . $setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('reserved_katha' . $setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('reserved_lessa' . $setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha' . $setl->dag_no), 0);
                        $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha' . $setl->dag_no), 0);
                        $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa' . $setl->dag_no), 0);

                        $dagAreaLessaValidationRoad = ($bighaValidationRoad * 100) + ($kathaValidationRoad * 20) + $lessaValidationRoad;

                        if ($appAreaLessaValidation < $dagAreaLessaValidationRoad) {
                            $roadsideMoreThanDagA = 1;
                        }
                        $totalRoadSideRev += $dagAreaLessaValidationRoad;

                    }

                    if ($setl->type == 'F') {
                        $this->form_validation->set_rules('reserved_bigha_family' . $setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('reserved_katha_family' . $setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('reserved_lessa_family' . $setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family' . $setl->dag_no), 0);
                        $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family' . $setl->dag_no), 0);
                        $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family' . $setl->dag_no), 0);

                        $dagAreaLessaValidationFamily = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                        if ($appAreaLessaValidation < $dagAreaLessaValidationFamily) {
                            $familyMoreThanDagA = 1;
                        }
                        $totalFamilyRev += $dagAreaLessaValidationFamily;
                    }
                }

            }

            if ($this->form_validation->run() == false) {
                $errors = validation_errors();
                $this->session->set_flashdata('message', $errors);
                return redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
            }
            if ($appAreaLessaValidation == 0) {
                $this->session->set_flashdata('message', 'Total applied area should not be Zero !');
                return redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
            }
            if ($appAreaMoreThanDagA == 1) {
                $this->session->set_flashdata('message', 'Total applied area should not be more than total Dag Area !');
                return redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
            }
            if ($roadsideMoreThanDagA == 1) {
                $this->session->set_flashdata('message', 'Total roadside reserved area should not be more than total applied area !');
                return redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
            }
            if ($familyMoreThanDagA == 1) {
                $this->session->set_flashdata('message', 'Total family reserved area should not be more than total applied area !');
                return redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
            }
            if ($appAreaLessaValidation < $totalRoadSideRev + $totalFamilyRev) {
                $this->session->set_flashdata('message', 'Total reserved area should not be more than total applied area !');
                return redirect(base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $case_no);
            }

            ////settlement_dag_details insert start
            $this->db->trans_begin();

            $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'CO'")->row()->ct;

            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            $phase_count  = (int) $phase_count + 1;
            $backup_array = [
                'applid'      => $applid_backup,
                'case_no'     => $case_no,
                'from_office' => 'CO',
                'to_office'   => 'CO',
                'status'      => 'E',
                'phase'       => 'CO_' . $phase_count,
                'data'        => json_encode($_POST),
            ];

            $backup_insertion_co = $this->db->insert('settlement_backup_json', $backup_array);
            if ($backup_insertion_co != 1) {
                $this->db->trans_rollback();
                log_message('error', '#BACKUPCO001: Insertion failed in settlement_backup_json RTPS Case No ' . $case_no);

                $this->session->set_flashdata('error_data', "#BACKUPCO001: Registration of Settlement failed for case no : " . $case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $fmd = [
                'user_code'   => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d G:i:s'),
            ];

            $fmd['s_dag_area_b']  = $this->input->post('s_dag_area_b');
            $fmd['s_dag_area_k']  = $this->input->post('s_dag_area_k');
            $fmd['s_dag_area_lc'] = $this->input->post('s_dag_area_lc');
            $fmd['s_dag_area_g']  = $this->input->post('s_dag_area_g');
            $fmd['s_dag_area_kr'] = $this->input->post('s_dag_area_kr');

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_dag_details', $fmd);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#UPDATEFAP001: Updation failed in settlement_dag_details Dharitree Case No ' . $case_no);
                $data = [
                    'error' => "#UPDATEFAP001: Updation of Settlement failed for case no : " . $case_no,
                ];
                echo json_encode($data);
                return false;
            }
        } elseif ($service_code == SETTLEMENT_TENANT_ID) {

            // for tenant are update
            // for barak valley
            if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                $this->form_validation->set_rules('total_bigha', 'Total Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('total_Katha', 'Total Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('total_lessa', 'Total Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                $this->form_validation->set_rules('total_ganda', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('total_kranti', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                $bighaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_bigha'), 0);
                $kathaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_Katha'), 0);
                $lessaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_lessa'), 0);
                $gandaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_ganda'), 0);

                $dagAreaLessaValidation     = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                $agrAreaLessaValidation     = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
                $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 6400) + ($kathaValidationTotalLm * 320) + ($lessaValidationTotalLm * 20) + $gandaValidationTotalLm;

                if ($dagAreaLessaValidation < $agrAreaLessaValidation) {
                    $appAreaMoreThanDagA = 1;
                }
                if ($dagAreaLessaValidation < $totalLmEnterAreaValidation) {
                    $lmEnterAreaMoreThanDagA = 1;
                }

            } else {

                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                $bighaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_bigha'), 0);
                $kathaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_Katha'), 0);
                $lessaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_lessa'), 0);

                $dagAreaLessaValidation     = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                $agrAreaLessaValidation     = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
                $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 100) + ($kathaValidationTotalLm * 20) + $lessaValidationTotalLm;

                if ($dagAreaLessaValidation < $agrAreaLessaValidation) {
                    $appAreaMoreThanDagA = 1;
                }
                if ($dagAreaLessaValidation < $totalLmEnterAreaValidation) {
                    $lmEnterAreaMoreThanDagA = 1;
                }
            }

            if ($this->form_validation->run() == false) {

                $errors = validation_errors();
                $this->session->set_flashdata('message', $errors);
                redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no);

            }
            if ($agrAreaLessaValidation == 0) {
                $this->session->set_flashdata('message', 'Total applied area should not be Zero !');
                redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no);
            }
            if ($appAreaMoreThanDagA == 1) {
                $this->session->set_flashdata('message', 'Total applied area should not be more than total Dag Area !');
                redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no);
            }
            if ($lmEnterAreaMoreThanDagA == 1) {
                $this->session->set_flashdata('message', 'Possession of the land found during field visit should not be more than total dag area !');
                redirect(base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $case_no);
            }

            $this->db->trans_begin();

            $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'CO'")->row()->ct;

            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            $phase_count  = (int) $phase_count + 1;
            $backup_array = [
                'applid'      => $applid_backup,
                'case_no'     => $case_no,
                'from_office' => 'CO',
                'to_office'   => 'CO',
                'status'      => 'E',
                'phase'       => 'CO_' . $phase_count,
                'data'        => json_encode($_POST),
            ];

            $backup_insertion_co = $this->db->insert('settlement_backup_json', $backup_array);
            if ($backup_insertion_co != 1) {
                $this->db->trans_rollback();
                log_message('error', '#BACKUPCO001: Insertion failed in settlement_backup_json RTPS Case No ' . $case_no);

                $this->session->set_flashdata('error_data', "#BACKUPCO001: Registration of Settlement failed for case no : " . $case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            //   settlement_dag_details update start
            $fmd = [
                'user_code'   => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d G:i:s'),
            ];

            $fmd['s_dag_area_b']  = $this->input->post('s_dag_area_b');
            $fmd['s_dag_area_k']  = $this->input->post('s_dag_area_k');
            $fmd['s_dag_area_lc'] = $this->input->post('s_dag_area_lc');
            $fmd['s_dag_area_g']  = $this->input->post('s_dag_area_g');
            $fmd['s_dag_area_kr'] = $this->input->post('s_dag_area_kr');

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_dag_details', $fmd);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#SETUP0002: Updation failed in settlement_dag_details Dharitree Case No ' . $case_no);
                $data = [
                    'error' => "#SETUP0002: Registration of Settlement failed for case no : " . $case_no,
                ];
                echo json_encode($data);
                return false;
            }

        }

        ///// road side reserve area start /////
        if ($reservation == true) {
            foreach ($reservation as $reservation_road) {
                if ($reservation_road->type == 'R') {
                    $reservedarea_road = [
                        'bigha'       => $this->input->post('reserved_bigha' . $reservation_road->dag_no),
                        'katha'       => $this->input->post('reserved_katha' . $reservation_road->dag_no),
                        'lessa'       => $this->input->post('reserved_lessa' . $reservation_road->dag_no),
                        'ganda'       => $this->input->post('reserved_ganda' . $reservation_road->dag_no),
                        'kranti'      => $this->input->post('reserved_kranti' . $reservation_road->dag_no),
                        'date_update' => date('Y-m-d h:i:s'),
                    ];

                    $this->db->where('case_no', $case_no);
                    $this->db->where('type', 'R');
                    $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_road->dag_no));
                    $this->db->update('settlement_reservation', $reservedarea_road);

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#RESERVUPD001: Updation failed in settlement_reservation Dharitree Case No ' . $case_no);
                        $data = [
                            'error' => "#RESERVUPD001: Registration of settlement_reservation failed for case no : " . $case_no,
                        ];
                        echo json_encode($data);
                        return false;
                    }
                }

            }

            ///// family reserve area start /////
            foreach ($reservation as $reservation_family) {
                if ($reservation_family->type == 'F') {
                    $reservedarea_family = [

                        'bigha'       => $this->input->post('reserved_bigha_family' . $reservation_family->dag_no),
                        'katha'       => $this->input->post('reserved_katha_family' . $reservation_family->dag_no),
                        'lessa'       => $this->input->post('reserved_lessa_family' . $reservation_family->dag_no),
                        'ganda'       => $this->input->post('reserved_ganda_family' . $reservation_family->dag_no),
                        'kranti'      => $this->input->post('reserved_kranti_family' . $reservation_family->dag_no),
                        'date_update' => date('Y-m-d h:i:s'),
                    ];

                    $this->db->where('case_no', $case_no);
                    $this->db->where('type', 'F');
                    $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_family->dag_no));
                    $this->db->update('settlement_reservation', $reservedarea_family);

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#RESERVUPD002: Updation failed in settlement_reservation Dharitree Case No ' . $case_no);
                        $data = [
                            'error' => "#RESERVUPD002: Registration of settlement_reservation failed for case no : " . $case_no,
                        ];
                        echo json_encode($data);
                        return false;
                    }
                }
            }
        }

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => 'Area revised by CO',
            'status'               => 'X',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'CO',
            'office_to'            => 'CO',
            'task'                 => 'Area updated by CO',
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRAREAUPDATE0O1: Insertion failed in settlement_proceeding for case no :' . $case_no);
            $json = [
                'errorMessage' => "#ERRAREAUPDATE0O1: Failed to forward the case for Case No : " . $case_no,
            ];
            echo json_encode($json);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = [
                'error' => "Error in submitting. Please try Again",
            ];
            return $data;
            exit;
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Area updated successfully # $case_no");
            redirect(base_url() . $redirect_link);
        }

    }

    public function document($doc)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "attachment");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'name' => $doc,
        ]));
        $result       = curl_exec($curl_handle);
        $result       = json_decode($result);
        $output       = $result->raw_data;
        $content_type = $result->mime_type;
        $check        = explode("/", $content_type);
        if ($check[1] == 'pdf') {
            $output = base64_decode($output);
            header('Content-type: application/pdf');
            echo $output;
        } else {
            echo '<img src="data:' . $content_type . ';base64,' . $output . '" />';
        }
    }

    public function documentmb3($doc)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "attachment");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'name' => $doc,
        ]));
        $result       = curl_exec($curl_handle);
        $result       = json_decode($result);
        $output       = $result->raw_data;
        $content_type = $result->mime_type;
        $check        = explode("/", $content_type);
        if ($check[1] == 'pdf') {
            $output = base64_decode($output);
            header('Content-type: application/pdf');
            echo $output;
        } else {
            echo '<img src="data:' . $content_type . ';base64,' . $output . '" />';
        }
    }

    public function viewBeneficiary()
    {
        $case_no = $_GET['case'];

        $bene_sql = $this->db->query("SELECT pdar_id, owner_name, owner_living_status FROM settlement_tenent_beneficiary WHERE case_no = '$case_no' GROUP BY pdar_id, owner_name, owner_living_status");
        if ($bene_sql->num_rows() > 0) {
            $data['data'] = $bene_sql->result();
        }

        $bene_alive = $this->db->query("SELECT * FROM settlement_tenent_beneficiary WHERE case_no = '$case_no' AND owner_living_status = 'YES'");
        if ($bene_alive->num_rows() > 0) {
            $data['data_alive'] = $bene_alive->result();
        }

        $bene_dead = $this->db->query("SELECT * FROM settlement_tenent_beneficiary WHERE case_no = '$case_no' AND owner_living_status = 'NO'");
        if ($bene_dead->num_rows() > 0) {
            $data['data_dead'] = $bene_dead->result();
        }

        // for guardian relation
        $query_for_guar_rel = "select * from master_guard_rel";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row                  = $relation_executation->num_rows;
        if ($row != 0) {
            $data['guar_rel'] = $relation_executation->result();
        }

        $data['_view'] = 'SettlementView/include/beneficiaryDetails';
        $this->load->view('layouts/main', $data);
    }

    public function landBankInsert()
    {

        $this->db->trans_begin();

        $application_no = trim($this->input->post('application_no'));

        $land_bank_avail_sql = $this->db->query("SELECT * FROM land_bank_details WHERE dag_no = ? AND village_uuid = ? ORDER BY id DESC", [trim($this->input->post('v_dag_no')), trim($this->input->post('v_uuid'))]);

        // echo $this->db->last_query();

        if ($land_bank_avail_sql->num_rows() > 0) {

            // allows only if single dag_no and village_id is true in land_bank_details table
            $land_bank_details_id = $land_bank_avail_sql->row()->id;

            // settlement_land_bank_details duplication check
            $settl_query = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND land_bank_details_id = ?", [$application_no, $land_bank_details_id]);

            if ($settl_query->num_rows() > 0) {
                // if exist then data already inserted
                $this->db->trans_rollback();
                $data = [
                    'responseType' => 2,
                    'msg'          => "Encroacher data already inserted for this application numberrrrr !",
                ];
                echo json_encode($data);
                return false;
            }

            $land_bank_update_array = [
                'status'         => LAND_BANK_STATUS_PENDING,
                'modified_at'    => date('Y-m-d H:i:s'),
                'application_no' => $application_no,
            ];

            $this->db->where('id', $land_bank_details_id);
            $this->db->where('dag_no', trim($this->input->post('v_dag_no')));
            $this->db->where('village_uuid', trim($this->input->post('v_uuid')));
            $this->db->update('land_bank_details', $land_bank_update_array);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#LANDBNK0013: Updation failed in land_bank_details Application No ' . $application_no);
                $data = [
                    'responseType' => 2,
                    'msg'          => "#LANDBNK0013: Update fail in Land Bank for case no : " . $application_no,
                ];
                echo json_encode($data);
                return false;
            }

        } else {
            log_message('error', '#LANDBNK00133: Updation failed in land_bank_details Application No ' . $application_no);
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBNK00133: Dag not found for this case no : " . $application_no,
            ];
            echo json_encode($data);
            return false;
        }

        // insertion land_bank_encroacher_details
        $land_bank_encroacher_array = [
            'name'                 => trim($this->input->post('lb_lm_update_form_en_name')),
            'fathers_name'         => trim($this->input->post('lb_lm_update_form_en_father_name')),
            'gender'               => trim($this->input->post('lb_lm_update_form_en_gender')),
            'encroachment_from'    => trim($this->input->post('lb_lm_update_form_en_from_date')),
            'encroachment_to'      => trim($this->input->post('lb_lm_update_form_en_to_date')),
            'landless_indigenous'  => trim($this->input->post('lb_lm_update_form_en_landless_indigenuous')),
            'landless'             => trim($this->input->post('lb_lm_update_form_en_landless')),
            'caste'                => trim($this->input->post('lb_lm_update_form_en_caste')),
            'erosion'              => trim($this->input->post('lb_lm_update_form_en_erosion')),
            'landslide'            => trim($this->input->post('lb_lm_update_form_en_landslide')),
            'type_of_land_use'     => trim($this->input->post('lb_lm_update_form_type_of_land_use')),
            'type_of_encroacher'   => trim($this->input->post('lb_lm_update_form_type_of_encroacher')),
            'created_at'           => date('Y-m-d H:i:s'),
            'land_bank_details_id' => $land_bank_details_id,
            'application_no'       => $application_no,
        ];

        $insert_query_encroacher = $this->db->insert('land_bank_encroacher_details', $land_bank_encroacher_array);

        $land_bank_enc_id = $this->db->insert_id();

        if ($insert_query_encroacher != 1) {

            $this->db->trans_rollback();
            log_message('error', '#LANDBNK0004: Insertion failed in land_bank_encroacher_details RTPS Case No ' . $application_no);
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBNK0004: Insertation failed in Land bank encroacher for case no : " . $application_no,
            ];
            echo json_encode($data);
            return false;
        }

        // insertion in settlement_land_bank_details
        $settlement_land_bank_details_array = [
            'application_no'       => $application_no,
            'land_bank_details_id' => $land_bank_details_id,
            'created_at'           => date('Y-m-d H:i:s'),
            'dag_no'               => trim($this->input->post('v_dag_no')),
            'uuid'                 => trim($this->input->post('v_uuid')),
            'encroacher_id'        => $land_bank_enc_id,
            'enc_name'             => trim($this->input->post('lb_lm_update_form_en_name')),
            'enc_fathers_name'     => trim($this->input->post('lb_lm_update_form_en_father_name')),
            'enc_from_date'        => trim($this->input->post('lb_lm_update_form_en_from_date')),
        ];

        $insert_settlement_land_bank = $this->db->insert('settlement_land_bank_details', $settlement_land_bank_details_array);

        if ($insert_settlement_land_bank != 1) {

            $this->db->trans_rollback();
            log_message('error', '#LANDBNK0005: Insertion failed in land_bank_encroacher_details RTPS Case No ' . $application_no);
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBNK0005:  Insertion failed in settlement land bank for case no : " . $application_no,
            ];
            echo json_encode($data);
            return false;
        }

        // insertion into settlement_applicant
        $sql = $this->db->query("SELECT dharitree FROM basundhar_application WHERE basundhara = ?", [$application_no]);

        if ($sql->num_rows() > 0) {
            $case_no = $sql->row()->dharitree;
        }

        $settlement_applicant_array = [
            'pdar_name'         => trim($this->input->post('lb_lm_update_form_en_name')),
            'pdar_guardian'     => trim($this->input->post('lb_lm_update_form_en_father_name')),
            'period_possession' => trim($this->input->post('lb_lm_update_form_en_from_date')),
            // 'enc_id' => $land_bank_enc_id,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->where('pdar_type', 'EN');
        $this->db->where('dag_no', trim($this->input->post('v_dag_no')));
        $this->db->update('settlement_applicant', $settlement_applicant_array);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#LANDBANK000331: Update fail in Land Bank for case no ' . $case_no);
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBANK000331: Update fail in Land Bank for case no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        if ($this->db->trans_status() === false) {
            var_dump('heelllo');
            die;
        } else {
            $this->db->trans_commit();

            $data = [
                'responseType' => 3,
                'appnData'     => $settlement_land_bank_details_array,
                'msg'          => "Encroacher data successfully inserted...",
            ];
            echo json_encode($data);
        }

    }

    public function getCircle($district)
    {
        $this->dbswitchmb2($district);
        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng
        from location where dist_code='$district' and cir_code!='00' and  mouza_pargona_code='00' and
        vill_townprt_code='00000' and lot_no='00' order by loc_name ");

        $data = $circle->result();
        $json = [];
        foreach ($data as $object) {
            /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
            ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ))
            {
            continue;
            }*/
            $json[] = ['cir_code' => trim($object->cir_code . ',' . $object->subdiv_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng)];
        }
        //var_dump($json);
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getVillage($district, $subdiv, $circle, $rural)
    {
        if ($rural == 'N') {
            $rural = 'R';
        } else if ($rural == 'Y') {
            $rural = 'U';
        }
        /*$district = '07';
        $subdiv = '01';
        $circle = '05';
        $mouza = '06';
        $lot = '05';*/

        $this->dbswitchmb2($district);
        if ($rural == 'R') {
            $village = $this->db->query("select subdiv_code,mouza_pargona_code,lot_no,vill_townprt_code,loc_name
        from location where dist_code='$district' and cir_code='$circle' and subdiv_code='$subdiv' and mouza_pargona_code!='00' and lot_no!='00' and loc_name!='' and rural_urban='R' order by loc_name  ");
            ///$village = $this->db->query("select subdiv_code,mouza_pargona_code,lot_no,vill_townprt_code,loc_name
            //from location where dist_code='$district' and cir_code='$circle' and subdiv_code='$subdiv' and mouza_pargona_code='$mouza' and lot_no='$lot' and loc_name!='' and rural_urban='R' order by loc_name  ");
        } else if ($rural == 'U') {
            $village = $this->db->query("select subdiv_code,mouza_pargona_code,lot_no,vill_townprt_code,loc_name
        from location where dist_code='$district' and cir_code='$circle' and subdiv_code='$subdiv'
        and mouza_pargona_code!='00' and lot_no!='00' and loc_name!='' and rural_urban='U' order by loc_name ");

            //$village = $this->db->query("select subdiv_code,mouza_pargona_code,lot_no,vill_townprt_code,loc_name
            //from location where dist_code='$district' and cir_code='$circle' and subdiv_code='$subdiv' and mouza_pargona_code='$mouza' and lot_no='$lot' and loc_name!='' and rural_urban='U' order by loc_name  ");
        }
        $data = $village->result();
        $json = [];
        foreach ($data as $object) {
            $json[] = ['vill_townprt_code' => trim($object->vill_townprt_code . ',' . $object->subdiv_code . ',' . $object->mouza_pargona_code . ',' . $object->lot_no), 'loc_name' => trim($object->loc_name)];
        }
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getAllDags($district, $subdiv, $circle, $mouza, $lot, $village)
    {

        $this->dbswitchmb2($district);

        $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
            . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle'
        and mouza_Pargona_code='$mouza' and lot_No='$lot' "
            . "and vill_townprt_code='$village' and patta_type_code in
        (select type_code from patta_code where mutation in ('a','i')) and
        (dag_status is null or dag_status !='NR') order by dag_no_int ");

        $data = $dag->result();
        $json = [];
        foreach ($data as $object) {
            $json[] = [
                'dag_no'     => trim($object->dag_no),
                'dag_no_int' => trim($object->dag_no_int),
            ];
        }
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getArea($district, $subdiv, $circle, $mouza, $lot, $village, $dag)
    {
        $json = null;
        $this->dbswitchmb2($district);
        $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,
        patta_type_code from chitha_basic where dist_code=? and cir_code=? and
        subdiv_code=? and vill_townprt_code=? and mouza_pargona_code=?
        and lot_no=? and dag_no_int=?", [$district, $circle, $subdiv, $village, $mouza, $lot, $dag]);
        $data = $area->result();
        $json = [];
        foreach ($data as $object) {
            $type = $this->db->query("select patta_type from patta_code
            where type_code=?", $object->patta_type_code)->row()->patta_type;
            $json = [
                'bigha'      => trim($object->dag_area_b),
                'katha'      => trim($object->dag_area_k),
                'lessa'      => trim($object->dag_area_lc),
                'ganda'      => trim($object->dag_area_g),
                'kranti'     => trim($object->dag_area_kr),
                'patta_no'   => trim($object->patta_no),
                'patta_type' => $type,
                'patta_code' => trim($object->patta_type_code),
            ];
        }
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function addProperty()
    {
        $validation         = null;
        $dist_code          = trim($this->input->post('additional_district'));
        $dist_name          = $this->input->post('additional_district_name');
        $cir_code           = trim($this->input->post('additional_circle'));
        $cir_name           = $this->input->post('additional_circle_name');
        $subdiv_code        = trim($this->input->post('subdiv_code'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
        $lot_no             = trim($this->input->post('lot_no'));
        $bigha              = trim($this->input->post('additional_bigha'));
        $katha              = trim($this->input->post('additional_katha'));
        $lessa              = trim($this->input->post('additional_lessa'));

        if (in_array($dist_code, json_decode(BARAK_VALLEY))) {
            $ganda  = trim($this->input->post('additional_ganda'));
            $kranti = trim($this->input->post('additional_kranti'));
        } else {
            $ganda  = 0;
            $kranti = 0;
        }

        $ref_no = trim($this->input->post('ref_no'));

        $is_additional_urban = trim($this->input->post('is_additional_urban'));
        $additional_village  = trim($this->input->post('additional_village'));
        $additional_dag      = trim($this->input->post('additional_dag'));
        $additional_patta    = trim($this->input->post('additional_patta'));

        $additional_village_code = trim($this->input->post('additional_village_code'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('additional_district', 'District', 'required|numeric|trim|xss_clean');
        $this->form_validation->set_rules('additional_circle', 'Circle', 'required|trim|xss_clean');

        $this->form_validation->set_rules('additional_bigha', 'Bigha', 'required|is_natural|trim|greater_than[-1]|xss_clean');

        if (in_array($dist_code, json_decode(BARAK_VALLEY))) { // for barak valley
            $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[20]');
            $this->form_validation->set_rules('additional_lessa', 'Chatak', 'required|greater_than[-1]|less_than[16]');
            $this->form_validation->set_rules('additional_ganda', 'Ganda', 'required|numeric|greater_than[-1]|less_than[20]');
            $this->form_validation->set_rules('additional_kranti', 'Kranti', 'numeric|greater_than[-1]|less_than[12]');
        } else { // other than barak valley
            $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[5]');
            $this->form_validation->set_rules('additional_lessa', 'Lessa', 'required|greater_than[-1]|less_than[20]');
        }

        if ($this->form_validation->run() == false) {
            $this->form_validation->set_error_delimiters('', '');

            if (form_error('additional_district')) {
                $validation[] = ['field' => 'additional_district', 'message' => form_error('additional_district')];
            }
            if (form_error('additional_circle')) {
                $validation[] = ['field' => 'additional_circle', 'message' => form_error('additional_circle')];
            }
            if (form_error('additional_bigha')) {
                $validation[] = ['field' => 'additional_bigha', 'message' => form_error('additional_bigha')];
            }
            if (form_error('additional_katha')) {
                $validation[] = ['field' => 'additional_katha', 'message' => form_error('additional_katha')];
            }
            if (form_error('additional_lessa')) {
                $validation[] = ['field' => 'additional_lessa', 'message' => form_error('additional_lessa')];
            }
            if (form_error('additional_ganda')) {
                $validation[] = ['field' => 'additional_ganda', 'message' => form_error('additional_ganda')];
            }
            if (form_error('additional_kranti')) {
                $validation[] = ['field' => 'additional_kranti', 'message' => form_error('additional_kranti')];
            }
        }

        if ($validation != null) {
            echo json_encode([
                'responseType' => 1,
                'validation'   => $validation,
            ]);
            return;
        } else {
            $this->db->trans_begin();

            // insertion in backup table
            $backup_array_lm = [
                'applid' => $ref_no,
                'status' => 'I',
                'data'   => json_encode($_POST),
            ];

            $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
            if ($backup_insertion_lm != 1) {
                $this->db->trans_rollback();
                log_message('error', '#BACKUP002: Insertion failed in settlement_backup_json RTPS Case No ' . $ref_no);
                $json = [
                    'responseType' => 3,
                    'message'      => 'Data insertion fail in backup_json',
                ];
                echo json_encode($json);
                return false;
            }

            if ($additional_dag == '' || $additional_dag == null) {
                $this->db->trans_rollback();
                log_message('error', 'Dag not selected');
                $json = [
                    'responseType' => 3,
                    'message'      => 'Please Select Dag',
                ];
                echo json_encode($json);
                return false;
            }

            if ($additional_village_code == '' || $additional_village_code == null) {
                $this->db->trans_rollback();
                log_message('error', 'Village not selected');
                $json = [
                    'responseType' => 3,
                    'message'      => 'Please Select Village',
                ];
                echo json_encode($json);
                return false;
            }

            if ($additional_patta == '' || $additional_patta == null) {
                $this->db->trans_rollback();
                log_message('error', 'Patta is null');
                $json = [
                    'responseType' => 3,
                    'message'      => 'Patta can not be null',
                ];
                echo json_encode($json);
                return false;
            }

            $this->dbswitchmb2($dist_code);

            //uuid from location table
            $query = $this->db->query("SELECT uuid FROM location WHERE dist_code=? AND subdiv_code=?
            AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?",
                [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                    $lot_no, $vill_townprt_code]);
            if ($query->num_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', 'Incorrect location selected. No uuid found' . $this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => 'Incorrect Location selected. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            $this->dbswitch($this->session->userdata('dist_code'));

            //////////////// Save Applicant ///////////////
            $propertyadd = [
                'applid'             => $ref_no,
                'case_no'            => 'NA',
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'bigha'              => $bigha,
                'katha'              => $katha,
                'lessa'              => $lessa,
                'ganda'              => $ganda,
                'kranti'             => $kranti,
                'entry_date'         => date('Y-m-d h:i:s'),
                'is_rural'           => $is_additional_urban,
                'dag_no'             => trim($additional_dag),
                'patta_no'           => $additional_patta,
                'uuid'               => $query->row()->uuid,
                'applied_flag'       => MB_LOT_MONDOL,
                'dist_name'          => trim($dist_name),
                'cir_name'           => trim($cir_name),
                'vill_name'          => trim($additional_village),
            ];

            $this->db->insert('settlement_additional_property', $propertyadd);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $response['status'] = 0;
                echo json_encode(['status' => 0]);
            } else {
                $property_id = $this->db->insert_id();
                $row         = $this->db->select('*')->from('settlement_additional_property')->where('id', (int) $property_id)->get()->row_array();
                $this->db->trans_commit();
                echo json_encode(['status' => 200, 'result' => $row]);
                return;
            }
        }
    }

    public function propertydel()
    {
        $this->db->trans_begin();
        $property_id = $this->input->post('property_id');

        $row = $this->db->select('applid')->from('settlement_additional_property')->where('id', (int) $property_id)->get();
        if ($row->num_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', 'No detail available in settlement_additional_property ' . $this->db->last_query());
            $json = [
                'status'  => 3,
                'message' => 'Nothing to delete !!',
            ];
            echo json_encode($json);
            return false;
        }

        $applid = $row->row()->applid;

        $sql    = "DELETE FROM settlement_additional_property WHERE id='$property_id'";
        $result = $this->db->query($sql);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            $response['status'] = 0;
            echo json_encode(['status' => 0]);
            log_message("error", "#PROP0001 Failed to delete property_id: " . $property_id);
            return;
        } else {
            $this->db->trans_commit();
            $result = $this->db->select('*')->from('settlement_additional_property')->where('applid', $applid)->get();
            echo json_encode(['status' => 200, 'result' => $result->row_array(), 'count' => $result->num_rows()]);
            return;
        }
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

    public function switchDb()
    {

        $applid  = trim($this->input->post('applid'));
        $getData = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", [$applid])->num_rows();
        echo json_encode(['count' => $getData]);
        return;

    }

    public function deleteAllFromProperty()
    {
        $applid = trim($this->input->post('applid'));
        $del    = $this->db->query("DELETE FROM settlement_additional_property WHERE applid=?",
            [$applid]);
        echo json_encode(['status' => 0]);
        return;
    }

    public function checkAdditionalProperty()
    {
        $applid  = trim($this->input->post('applid'));
        $getData = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", [$applid])->num_rows();
        echo json_encode(['status' => $getData]);
        return;
    }

    public function fetchLandBankEncData()
    {

        $case_no = trim($this->input->post('case_no'));
        if ($case_no) {
            $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
        } else {
            $application_no = trim($this->input->post('application_no'));
        }

        $uuid                 = trim($this->input->post('uuid'));
        $dag_no               = trim($this->input->post('dag_no'));
        $enc_id               = trim($this->input->post('enc_id'));
        $land_bank_details_id = trim($this->input->post('land_bank_details_id'));

        $get_land_sql = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND uuid = ? AND dag_no = ? AND encroacher_id = ? AND land_bank_details_id = ?", [$application_no, $uuid, $dag_no, $enc_id, $land_bank_details_id]);

        if ($get_land_sql->num_rows() > 0) {
            $land_bank_details_id = $get_land_sql->row()->land_bank_details_id;
        } else {
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBNK0005:  No Data Found in land bank ! ",
            ];
            echo json_encode($data);
            return false;
        }

        $sql = $this->db->query("SELECT * FROM land_bank_encroacher_details WHERE id = ? AND land_bank_details_id = ? ORDER BY id DESC", [$enc_id, $land_bank_details_id]);

        // echo $this->db->last_query();

        if ($sql->num_rows() > 0) {
            $result = $sql->row();
            echo json_encode($result);
        } else {
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBNK0005:  No Data Found in land bank ! ",
            ];
            echo json_encode($data);
            return false;
        }

    }

    public function updateLandBankEncData()
    {

        $enc_uuid       = $this->input->post('enc_uuid');
        $enc_dag_no     = $this->input->post('enc_dag_no');
        $enc_case_no    = $this->input->post('enc_case_no');
        $edit_riotee_id = $this->input->post('edit_riotee_id');

        $encroacher_id                             = $this->input->post('encroacher_id');
        $enc_application_no                        = $this->input->post('enc_application_no');
        $enc_land_bank_details_id                  = $this->input->post('enc_land_bank_details_id');
        $lb_lm_update_form_en_name                 = $this->input->post('lb_lm_update_form_en_name');
        $lb_lm_update_form_en_father_name          = $this->input->post('lb_lm_update_form_en_father_name');
        $lb_lm_update_form_en_gender               = $this->input->post('lb_lm_update_form_en_gender');
        $lb_lm_update_form_en_from_date            = $this->input->post('lb_lm_update_form_en_from_date');
        $lb_lm_update_form_en_to_date              = $this->input->post('lb_lm_update_form_en_to_date');
        $lb_lm_update_form_en_landless_indigenuous = $this->input->post('lb_lm_update_form_en_landless_indigenuous');
        $lb_lm_update_form_en_landless             = $this->input->post('lb_lm_update_form_en_landless');
        $lb_lm_update_form_en_caste                = $this->input->post('lb_lm_update_form_en_caste');
        $lb_lm_update_form_en_erosion              = $this->input->post('lb_lm_update_form_en_erosion');
        $lb_lm_update_form_en_landslide            = $this->input->post('lb_lm_update_form_en_landslide');
        $lb_lm_update_form_type_of_land_use        = $this->input->post('lb_lm_update_form_type_of_land_use');
        $lb_lm_update_form_type_of_encroacher      = $this->input->post('lb_lm_update_form_type_of_encroacher');

        $this->db->trans_begin();
        //update into settlement_land_bank_details
        $updateSetlArr = [
            'updated_at'       => date('Y-m-d'),
            'enc_name'         => $lb_lm_update_form_en_name,
            'enc_fathers_name' => $lb_lm_update_form_en_father_name,
            'enc_from_date'    => $lb_lm_update_form_en_from_date,
        ];

        $this->db->where('application_no', $enc_application_no);
        $this->db->where('land_bank_details_id', $enc_land_bank_details_id);
        $this->db->where('encroacher_id', $encroacher_id);

        $this->db->update('settlement_land_bank_details', $updateSetlArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#LANDBANK0001: Update fail in Land Bank for application no ' . $enc_application_no);
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBANK0001: Update fail in Land Bank for application no : " . $enc_application_no,
            ];
            echo json_encode($data);
            return false;
        }

        //Update into settlement_applicant
        if ($enc_case_no) {
            $updateSettlAppArr = [
                'pdar_name'         => $lb_lm_update_form_en_name,
                'pdar_guardian'     => $lb_lm_update_form_en_father_name,
                'date_update'       => date('Y-m-d H:i:s'),
                'period_possession' => $lb_lm_update_form_en_from_date,
            ];
            $this->db->where('case_no', $enc_case_no);
            $this->db->where('dag_no', $enc_dag_no);
            // $this->db->where('enc_id', $encroacher_id);
            $this->db->where('pdar_type', 'EN');

            $this->db->update('settlement_applicant', $updateSettlAppArr);

            // echo $this->db->last_query();

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#LANDBANK000333: Update fail in Land Bank for application no ' . $enc_application_no);
                $data = [
                    'responseType' => 2,
                    'msg'          => "#LANDBANK000333: Update fail in Land Bank for application no : " . $enc_application_no,
                ];
                echo json_encode($data);
                return false;
            }
        }

        // Update into land_bank_encroacher_details
        $updateLandBankArr = [
            'name'                => $lb_lm_update_form_en_name,
            'fathers_name'        => $lb_lm_update_form_en_father_name,
            'encroachment_from'   => $lb_lm_update_form_en_from_date,
            'encroachment_to'     => $lb_lm_update_form_en_to_date,
            'landless_indigenous' => $lb_lm_update_form_en_landless_indigenuous,
            'erosion'             => $lb_lm_update_form_en_erosion,
            'landless'            => $lb_lm_update_form_en_landless,
            'modified_at'         => date('Y-m-d'),
            'caste'               => $lb_lm_update_form_en_caste,
            'gender'              => $lb_lm_update_form_en_gender,
            'landslide'           => $lb_lm_update_form_en_landslide,
            'type_of_land_use'    => $lb_lm_update_form_type_of_land_use,
            'type_of_encroacher'  => $lb_lm_update_form_type_of_encroacher,
        ];

        $this->db->where('application_no', $enc_application_no);
        $this->db->where('land_bank_details_id', $enc_land_bank_details_id);
        $this->db->where('id', $encroacher_id);

        $this->db->update('land_bank_encroacher_details', $updateLandBankArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#LANDBANK0003: Update fail in Land Bank for application no ' . $enc_application_no);
            $data = [
                'responseType' => 2,
                'msg'          => "#LANDBANK0003: Update fail in Land Bank for application no : " . $enc_application_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();

        //success response
        $data = [
            'responseType'   => 3,
            'encroacher_id'  => $encroacher_id,
            'edit_riotee_id' => $edit_riotee_id,
            'appnData'       => $updateSettlAppArr,
            'msg'            => "Encroacher data updated successfully...",
        ];
        echo json_encode($data);
    }

    public function totalAppliedAreaZeroCheck()
    {
        return false;
    }

    public function editAreaNotMoreThenAppliedCheck()
    {
        return false;
    }

    public function appAreaMoreThanDagA()
    {
        return false;
    }

    public function cultivationMaxAppliedWithAddPro()
    {
        return false;
    }

    public function cultivationMaxApplied()
    {
        return false;
    }

    public function khasMaxHomestead()
    {
        return false;
    }

    public function khasMaxAgriculture()
    {
        return false;
    }

    public function totalAppliedAdditionalArea()
    {
        return false;
    }

    public function totalAppliedAreaInUrban()
    {
        return false;
    }

    public function updateAreaDetails()
    {
        //****getting the data  */
        $case_no = $this->input->post('area_update_case_no');

        $distCode       = $this->session->userdata('dist_code');
        $service_code   = $this->utilityclass->getServiceCode($case_no);
        $checkUrbanCon  = $this->input->post('area_update_urban_check');
        $land_area_type = $this->input->post('land_area_type');

        $totalHomeAreaLessaValidation = 0;
        $totalAgrAreaLessaValidation  = 0;
        $totalDagAreaLessaValidation  = 0;
        $totalDagAreaAppliedLessa     = 0;
        $appAreaMoreThanDagA          = 0;

        $id     = $this->input->post('area_update_id');
        $dag_no = $this->input->post('area_update_dag_no');

        //******backend validation */
        //***delimiter for not returning <p> tag */
        $this->form_validation->set_error_delimiters('', '');

        $singleAdditionalProToLessa = 0;
        $totalAdditionalProToLessa  = 0;

        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no, $dag_no);

        $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();

        $appliedDags = $this->SettlementCommonModel->getAllAppliedDagsByApplicant($case_no, $dag_no);

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            foreach ($additional_properties as $singleProperty) {
                $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                $totalAdditionalProToLessa += $singleAdditionalProToLessa;
            }

            foreach ($appliedDags as $appliedDag) {
                $appliedBighaAgri = 0;
                $appliedKathaAgri = 0;
                $appliedLessaAgri = 0;
                $appliedGandaAgri = 0;

                $appliedBighaHome = 0;
                $appliedKathaHome = 0;
                $appliedLessaHome = 0;
                $appliedGandaHome = 0;

                $singleAppliedAreaToLessaAgri = 0;
                $singleAppliedAreaToLessaHome = 0;

                $appliedBighaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_bigha, 0);
                $appliedKathaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_katha, 0);
                $appliedLessaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_lessa, 0);
                $appliedGandaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_ganda, 0);

                $appliedBighaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
                $appliedKathaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_katha, 0);
                $appliedLessaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_lessa, 0);
                $appliedGandaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_ganda, 0);

                $singleAppliedAreaToLessaAgri = ($appliedBighaAgri * 6400) + ($appliedKathaAgri * 320) + ($appliedLessaAgri * 20) + $appliedGandaAgri;
                $singleAppliedAreaToLessaHome = ($appliedBighaHome * 6400) + ($appliedKathaHome * 320) + ($appliedLessaHome * 20) + $appliedGandaHome;

                $totalDagAreaAppliedLessa += ($singleAppliedAreaToLessaAgri + $singleAppliedAreaToLessaHome);
            }
        } else {
            foreach ($additional_properties as $singleProperty) {
                $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
                $totalAdditionalProToLessa += $singleAdditionalProToLessa;
            }

            foreach ($appliedDags as $appliedDag) {

                $appliedBighaAgri = 0;
                $appliedKathaAgri = 0;
                $appliedLessaAgri = 0;

                $appliedBighaHome = 0;
                $appliedKathaHome = 0;
                $appliedLessaHome = 0;

                $singleAppliedAreaToLessaAgri = 0;
                $singleAppliedAreaToLessaHome = 0;

                $appliedBighaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_bigha, 0);
                $appliedKathaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_katha, 0);
                $appliedLessaAgri = $this->UtilsModel->defaultValue($appliedDag->applied_area_agri_lessa, 0);

                $appliedBighaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
                $appliedKathaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_katha, 0);
                $appliedLessaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_lessa, 0);

                $singleAppliedAreaToLessaAgri = ($appliedBighaAgri * 100) + ($appliedKathaAgri * 20) + $appliedLessaAgri;
                $singleAppliedAreaToLessaHome = ($appliedBighaHome * 100) + ($appliedKathaHome * 20) + $appliedLessaHome;

                $totalDagAreaAppliedLessa += ($singleAppliedAreaToLessaAgri + $singleAppliedAreaToLessaHome);

            }

        }

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('total_ganda_in_dag', 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('total_kranti_in_dag', 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('enc_bigha_home', 'Encroachment Land Area Homestead (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('enc_katha_home', 'Encroachment Land Area Homestead (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('enc_lessa_home', 'Encroachment Land Area Homestead (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('enc_ganda_home', 'Encroachment Land Area Homestead (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('enc_kranti_home', 'Encroachment Land Area  Homestead(Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('enc_bigha_agriculture', 'Encroachment Land Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('enc_katha_agriculture', 'Encroachment Land Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('enc_lessa_agriculture', 'Encroachment Land Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('enc_ganda_agriculture', 'Encroachment Land Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('enc_kranti_agriculture', 'Encroachment Land Area  Agriculture(Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('settlement_bigha_home', 'Area for Settlement Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('settlement_katha_home', 'Area for Settlement Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('settlement_lessa_home', 'Area for Settlement Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('settlement_ganda_home', 'Area for Settlement Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('settlement_kranti_home', 'Area for Settlement Homestead Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('settlement_bigha_agriculture', 'Area for Settlement Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('settlement_katha_agriculture', 'Area for Settlement Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('settlement_lessa_agriculture', 'Area for Settlement Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('settlement_ganda_agriculture', 'Area for Settlement Agricultural Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('settlement_kranti_agriculture', 'Area for Settlement Agricultural Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);
            $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0);

            $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_bigha_home'), 0);
            $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_katha_home'), 0);
            $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_lessa_home'), 0);
            $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_ganda_home'), 0);

            $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_bigha_agriculture'), 0);
            $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_katha_agriculture'), 0);
            $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_lessa_agriculture'), 0);
            $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_ganda_agriculture'), 0);

            $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
            $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
            $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

            if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation) {
                $appAreaMoreThanDagA = 1;
            }

            $totalDagAreaLessaValidation += $dagAreaLessaValidation;
            $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
            $totalAgrAreaLessaValidation += $agrAreaLessaValidation;
        } else {
            $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('enc_bigha_home', 'Encroachment Land Area Homestead (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('enc_katha_home', 'Encroachment Land Area Homestead (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('enc_lessa_home', 'Encroachment Land Area Homestead (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('enc_bigha_agriculture', 'Encroachment Land Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('enc_katha_agriculture', 'Encroachment Land Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('enc_lessa_agriculture', 'Encroachment Land Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('settlement_bigha_home', 'Area for Settlement Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('settlement_katha_home', 'Area for Settlement Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('settlement_lessa_home', 'Area for Settlement Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('settlement_bigha_agriculture', 'Area for Settlement Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('settlement_katha_agriculture', 'Area for Settlement Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('settlement_lessa_agriculture', 'Area for Settlement Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);

            $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_bigha_home'), 0);
            $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_katha_home'), 0);
            $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('settlement_lessa_home'), 0);

            $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_bigha_agriculture'), 0);
            $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_katha_agriculture'), 0);
            $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('settlement_lessa_agriculture'), 0);

            $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
            $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
            $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

            if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation) {
                $appAreaMoreThanDagA = 1;
            }

            $totalDagAreaLessaValidation += $dagAreaLessaValidation;
            $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
            $totalAgrAreaLessaValidation += $agrAreaLessaValidation;
        }

        $totalEditArea = $totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation;

        $editAreaNotMoreThenApplied = 0;
        if ($totalEditArea > $totalDagAreaAppliedLessa) {
            $editAreaNotMoreThenApplied = 1;
        }

        if (EDIT_AREA_NOT_MORE_THEN_APPLIED_AREA == 1) {
            if ($editAreaNotMoreThenApplied == 1) {
                $this->form_validation->set_rules('editAreaNotMoreThenAppliedCheck', 'Total edit area should not more then total applied area !', 'required|callback_editAreaNotMoreThenAppliedCheck');
            }
        }

        if ($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation == 0) {
            $this->form_validation->set_rules('totalAppliedAreaZeroCheck', 'Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
        }
        if ($appAreaMoreThanDagA == 1) {
            $this->form_validation->set_rules('appAreaMoreThanDagA', 'Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
        }

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            //******FOR SPECIAL CULTIVATORS */
            if ($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
                if (CULTIVATION_MAX_APPLIED * 6400 < $totalAgrAreaLessaValidation) {
                    $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied Agriculture area should not be more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxApplied');
                }
                if (CULTIVATION_MAX_APPLIED * 6400 < $totalAgrAreaLessaValidation + $totalAdditionalProToLessa) {
                    $this->form_validation->set_rules('cultivationMaxAppliedWithAddPro', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxAppliedWithAddPro');
                }
            }

            //******FOR KHASLAND */
            if ($service_code == SETTLEMENT_KHAS_LAND_ID) {

                if (KHAS_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation) {

                    $this->form_validation->set_rules('khasMaxHomestead', 'Total applied Homestead area should not be more than ' . KHAS_MAX_HOMESTEAD . ' Bigha !', 'required|callback_khasMaxHomestead');
                }
                if (KHAS_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation) {
                    $this->form_validation->set_rules('khasMaxAgriculture', 'Total applied Agriculture area should not be more than ' . KHAS_MAX_AGRICULTURE . ' Bigha !', 'required|callback_khasMaxAgriculture');
                }
                if ((KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) * 6400 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
                    $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                }

                // new premium addition
                if ($land_area_type != 10) {
                    $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($land_area_type);
                    if (! empty($maxland_check->max_land)) {
                        if ($maxland_check->max_land == '40') {
                            $maxland_ganda = 2560;
                        } elseif ($maxland_check->max_land == '60') {
                            $maxland_ganda = 3840;
                        }

                        if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                -$maxland_ganda . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    } else {
                        if ((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }
                }

                if ($checkUrbanCon == 'Y') {

                    // new premium addition
                    if ($land_area_type != 10) {
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($land_area_type);
                        if (! empty($maxland_check->max_land)) {
                            if ($maxland_check->max_land == '40') {
                                $maxland_ganda = 2560;
                            } elseif ($maxland_check->max_land == '60') {
                                $maxland_ganda = 3840;
                            }

                            if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                    -$maxland_ganda . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }
                        } else {
                            if ((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                    MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }
                        }
                    }
                }

            }

        } else {
            //******FOR SPECIAL CULTIVATORS */
            if ($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
                if (CULTIVATION_MAX_APPLIED * 100 < $totalAgrAreaLessaValidation) {
                    $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied Agriculture area should not be more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxApplied');
                }
                if (CULTIVATION_MAX_APPLIED * 100 < $totalAgrAreaLessaValidation + $totalAdditionalProToLessa) {
                    $this->form_validation->set_rules('cultivationMaxAppliedWithAddPro', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxAppliedWithAddPro');
                }
            }

            //*****FOR KHASLAND */
            if ($service_code == SETTLEMENT_KHAS_LAND_ID) {
                if (KHAS_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation) {

                    $this->form_validation->set_rules('khasMaxHomestead', 'Total applied Homestead area should not be more than ' . KHAS_MAX_HOMESTEAD . ' Bigha !', 'required|callback_khasMaxHomestead');

                }
                if (KHAS_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation) {

                    $this->form_validation->set_rules('khasMaxAgriculture', 'Total applied Agriculture area should not be more than ' . KHAS_MAX_AGRICULTURE . ' Bigha !', 'required|callback_khasMaxAgriculture');

                }
                if ((KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) * 100 < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
                    $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (KHAS_MAX_HOMESTEAD + KHAS_MAX_AGRICULTURE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                }

                // new premium addition
                if ($land_area_type != 10) {
                    $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($land_area_type);
                    if (! empty($maxland_check->max_land)) {
                        if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                -$maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }
                    } else {
                        if ((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        }

                    }
                }

                if ($checkUrbanCon == 'Y') {

                    // new premium addition
                    if ($land_area_type != 10) {
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($land_area_type);
                        if (! empty($maxland_check->max_land)) {
                            if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                    -$maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }
                        } else {
                            if ((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area in Urban cannot exceed  more than ' .
                                    MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }

                        }
                    }
                }
            }
        }

        if ($this->form_validation->run() == false) {
            $data = [
                'responseType' => 0,
                'msg'          => "#AREAUPDT0001:" . validation_errors() . "#case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();

        //****landType update HOMESTEAD/AGRICULTURE/BOTH */
        $homesteadLandExist = (float) $this->input->post('settlement_bigha_home') + (float) $this->input->post('settlement_katha_home') + (float) $this->input->post('settlement_lessa_home') + (float) $this->input->post('settlement_ganda_home') + (float) $this->input->post('settlement_kranti_home');

        $agricultureLandExist = (float) $this->input->post('settlement_bigha_agriculture') + (float) $this->input->post('settlement_katha_agriculture') + (float) $this->input->post('settlement_lessa_agriculture') + (float) $this->input->post('settlement_ganda_agriculture') + (float) $this->input->post('settlement_kranti_agriculture');

        $landTypeUpdate = 0;
        if ($homesteadLandExist > 0 && $agricultureLandExist > 0) {
            $landTypeUpdate = 3;
        } else if ($homesteadLandExist > 0) {
            $landTypeUpdate = 1;
        } else if ($agricultureLandExist > 0) {
            $landTypeUpdate = 2;
        }

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            //***********actual Encroachment area ***************
            $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

            $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($this->input->post('enc_bigha_agriculture'), $this->input->post('enc_katha_agriculture'), $this->input->post('enc_lessa_agriculture'), $this->input->post('enc_ganda_agriculture'));

            //***********total Actual Encroachment area*****************
            $total_actual_encroachment_area_ganda = (float) $actual_encroachment_area_home_ganda + (float) $actual_encroachment_area_agri_ganda;
            $totalEncroachmentAreaArr             = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
            // **********************************************

            //***********Settlement area that applicant will get settlement on***********
            $total_settlement_ganda_home = $this->utilityclass->Total_ganda($this->input->post('settlement_bigha_home'), $this->input->post('settlement_katha_home'), $this->input->post('settlement_lessa_home'), $this->input->post('settlement_ganda_home'));

            $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($this->input->post('settlement_bigha_agriculture'), $this->input->post('settlement_katha_agriculture'), $this->input->post('settlement_lessa_agriculture'), $this->input->post('settlement_ganda_agriculture'));

            //*****total Settlement area *************/
            $total_settlement_ganda = (float) $total_settlement_ganda_home + (float) $total_settlement_ganda_agri;
            $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

            //*************leftout area homestead**************
            $leftOutAreaHomeGanda = (float) $actual_encroachment_area_home_ganda - (float) $total_settlement_ganda_home;
            $leftOutAreaHomeArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

            //**********Ileftout area agriculture**************
            $leftOutAreaAgriGanda = (float) $actual_encroachment_area_agri_ganda - (float) $total_settlement_ganda_agri;
            $leftOutAreaAgriArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

            //**********Total left out area***************
            $totalLeftOutAreaGanda = (float) $total_actual_encroachment_area_ganda - (float) $total_settlement_ganda;
            $totalLeftOutAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
        } else {
            //********actual Encroachment area**********
            $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

            $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($this->input->post('enc_bigha_agriculture'), $this->input->post('enc_katha_agriculture'), $this->input->post('enc_lessa_agriculture'));

            //***********total Actual Encroachment area*****************
            $total_actual_encroachment_area_lessa = (float) $actual_encroachment_area_home_lessa + (float) $actual_encroachment_area_agri_lessa;
            $totalEncroachmentAreaArr             = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
            // **********************************************

            //*******Settlement area that applicant will get settlement on**********
            $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($this->input->post('settlement_bigha_home'), $this->input->post('settlement_katha_home'), $this->input->post('settlement_lessa_home'));

            $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($this->input->post('settlement_bigha_agriculture'), $this->input->post('settlement_katha_agriculture'), $this->input->post('settlement_lessa_agriculture'));

            //*************Total settlement area */
            $total_settlement_lessa = (float) $total_settlement_lessa_home + (float) $total_settlement_lessa_agri;
            $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

            //****************leftout area homestead**************
            $leftOutAreaHomeLessa = (float) $actual_encroachment_area_home_lessa - (float) $total_settlement_lessa_home;
            $leftOutAreaHomeArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

            //*************leftout area agriculture*****************
            $leftOutAreaAgriLessa = (float) $actual_encroachment_area_agri_lessa - (float) $total_settlement_lessa_agri;
            $leftOutAreaAgriArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

            //**********Total left out area***************
            $totalLeftOutArealessa = (float) $total_actual_encroachment_area_lessa - (float) $total_settlement_lessa;
            $totalLeftOutAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
        }

        //***encroachment area update*/
        $encroachment_area = [
            'homestead'   => [
                'bigha'  => $this->input->post('enc_bigha_home'),
                'katha'  => $this->input->post('enc_katha_home'),
                'lessa'  => $this->input->post('enc_lessa_home'),
                'ganda'  => $this->input->post('enc_ganda_home'),
                'kranti' => $this->input->post('enc_kranti_home'),
            ],

            'agriculture' => [
                'bigha'  => $this->input->post('enc_bigha_agriculture'),
                'katha'  => $this->input->post('enc_katha_agriculture'),
                'lessa'  => $this->input->post('enc_lessa_agriculture'),
                'ganda'  => $this->input->post('enc_ganda_agriculture'),
                'kranti' => $this->input->post('enc_kranti_agriculture'),
            ],
        ];

        $areaUpdateArr = [
            //****total dag area */
            'dag_area_b'         => $this->input->post('total_bigha_in_dag'),
            'dag_area_k'         => $this->input->post('total_katha_in_dag'),
            'dag_area_lc'        => $this->input->post('total_lessa_in_dag'),
            'dag_area_g'         => $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0),
            'dag_area_kr'        => $this->UtilsModel->defaultValue($this->input->post('total_kranti_in_dag'), 0),

            //*****encroachment area */
            'encroachement_area' => json_encode($encroachment_area),

            //*****settlement area */
            'home_b'             => $this->input->post('settlement_bigha_home'),
            'home_k'             => $this->input->post('settlement_katha_home'),
            'home_lc'            => $this->input->post('settlement_lessa_home'),
            'home_g'             => $this->UtilsModel->defaultValue($this->input->post('settlement_ganda_home'), 0),
            'home_kr'            => $this->UtilsModel->defaultValue($this->input->post('settlement_kranti_home'), 0),
            'agri_b'             => $this->input->post('settlement_bigha_agriculture'),
            'agri_k'             => $this->input->post('settlement_katha_agriculture'),
            'agri_lc'            => $this->input->post('settlement_lessa_agriculture'),
            'agri_g'             => $this->UtilsModel->defaultValue($this->input->post('settlement_ganda_agriculture'), 0),
            'agri_kr'            => $this->UtilsModel->defaultValue($this->input->post('settlement_kranti_agriculture'), 0),

            's_dag_area_b'       => $totalSettlementAreaArr[0],
            's_dag_area_k'       => $totalSettlementAreaArr[1],
            's_dag_area_lc'      => $totalSettlementAreaArr[2],
            's_dag_area_g'       => $totalSettlementAreaArr[3],
            's_dag_area_kr'      => 0,

            //****user info update */
            'user_code'          => $this->session->userdata('user_code'),
            'year_no'            => date('Y'),
            'date_entry'         => date('Y-m-d'),
            'land_type'          => $landTypeUpdate,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->where('id', $id);
        $this->db->where('dag_no', $dag_no);
        $this->db->update('settlement_dag_details', $areaUpdateArr);

        // echo $this->db->last_query();
        //*******check if data updated */
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#UPDTAREDTLS0002: Update fail in settlement_dag_details ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#UPDTAREDTLS0002: Update fail in settlement_dag_details : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        //*******insertion in settlement_area_history**************

        $settlementAreaHistoryArr = [
            'created_at'                            => date('Y-m-d'),
            //****encroachment area */
            'actual_encroachment_area_home_bigha'   => $this->input->post('enc_bigha_home'),
            'actual_encroachment_area_home_katha'   => $this->input->post('enc_katha_home'),
            'actual_encroachment_area_home_lessa'   => $this->input->post('enc_lessa_home'),
            'actual_encroachment_area_home_ganda'   => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
            'actual_encroachment_area_home_kranti'  => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),

            'actual_encroachment_area_agri_bigha'   => $this->input->post('enc_bigha_agriculture'),
            'actual_encroachment_area_agri_katha'   => $this->input->post('enc_katha_agriculture'),
            'actual_encroachment_area_agri_lessa'   => $this->input->post('enc_lessa_agriculture'),
            'actual_encroachment_area_agri_ganda'   => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_agriculture'), 0),
            'actual_encroachment_area_agri_kranti'  => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_agriculture'), 0),

            //*****total encroachment area */
            'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
            'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
            'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
            'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
            'total_actual_encroachment_area_kranti' => 0,
            //*******setttlement_area */
            'settlement_area_home_bigha'            => $this->input->post('settlement_bigha_home'),
            'settlement_area_home_katha'            => $this->input->post('settlement_katha_home'),
            'settlement_area_home_lessa'            => $this->input->post('settlement_lessa_home'),
            'settlement_area_home_ganda'            => $this->UtilsModel->defaultValue($this->input->post('settlement_ganda_home'), 0),
            'settlement_area_home_kranti'           => $this->UtilsModel->defaultValue($this->input->post('settlement_kranti_home'), 0),

            'settlement_area_agri_bigha'            => $this->input->post('settlement_bigha_agriculture'),
            'settlement_area_agri_katha'            => $this->input->post('settlement_katha_agriculture'),
            'settlement_area_agri_lessa'            => $this->input->post('settlement_lessa_agriculture'),
            'settlement_area_agri_ganda'            => $this->UtilsModel->defaultValue($this->input->post('settlement_ganda_agriculture'), 0),
            'settlement_area_agri_kranti'           => $this->UtilsModel->defaultValue($this->input->post('settlement_kranti_agriculture'), 0),

            //*****total settlement_area */
            'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
            'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
            'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
            'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
            'total_settlement_area_kranti'          => 0,
            //******leftout area */
            'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
            'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
            'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
            'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
            'leftout_area_home_kranti'              => 0,
            'leftout_area_agri_bigha'               => $leftOutAreaAgriArr[0],
            'leftout_area_agri_katha'               => $leftOutAreaAgriArr[1],
            'leftout_area_agri_lessa'               => $leftOutAreaAgriArr[2],
            'leftout_area_agri_ganda'               => $leftOutAreaAgriArr[3],
            'leftout_area_agri_kranti'              => 0,
            //****total leftout area */
            'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
            'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
            'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
            'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
            'total_leftout_area_kranti'             => 0,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->where('application_no', $application_no);
        $this->db->where('dag_no', $dag_no);
        $this->db->update('settlement_area_history', $settlementAreaHistoryArr);

        //*******check if data updated */
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#UPDTAREDTLS0003: Update fail in settlement_area_history ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#UPDTAREDTLS0003: Update fail in settlement_area_history : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();

        //*****getting the total applied area from db to check if it exceeds any area conditions*/
        $sql = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);

        if ($sql->num_rows() <= 0) {
            $this->db->trans_rollback();
            $data = [
                'responseType' => 0,
                'msg'          => "#FETCH0001: Error in fetching data from settlement_dag_details ! . $case_no",
            ];
            echo json_encode($data);
            return false;
        }

        $fresh_area_details = $sql->result();

        $total_settlement_home_lessa = 0;
        $total_settlement_home_ganda = 0;
        $total_settlement_agri_ganda = 0;
        $total_settlement_agri_lessa = 0;
        foreach ($fresh_area_details as $fresh_area) {

            $settlement_area_home_bigha = (float) $fresh_area->home_b;
            $settlement_area_home_kahta = (float) $fresh_area->home_k;
            $settlement_area_home_lessa = (float) $fresh_area->home_lc;
            $settlement_area_home_ganda = (float) $fresh_area->home_g;

            $settlement_area_agri_bigha = (float) $fresh_area->agri_b;
            $settlement_area_agri_kahta = (float) $fresh_area->agri_k;
            $settlement_area_agri_lessa = (float) $fresh_area->agri_lc;
            $settlement_area_agri_ganda = (float) $fresh_area->agri_g;
            // $settlement_area_kranti = (float)$fresh_area->home_kr;

            if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                //****total settlement area in all dags homestead */
                $total_settlement_home_ganda = $total_settlement_home_ganda + $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa, $settlement_area_home_ganda);

                //****total settlement area in all dags agriculture */
                $total_settlement_agri_ganda = $total_settlement_agri_ganda + $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_kahta, $settlement_area_agri_lessa, $settlement_area_agri_ganda);
            } else {
                //****total settlement area in all dags homestead */
                $total_settlement_home_lessa = $total_settlement_home_lessa + $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa);

                //****total settlement area in all dags agriculture */
                $total_settlement_agri_lessa = $total_settlement_agri_lessa + $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_kahta, $settlement_area_agri_lessa);
            }

        }

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            $total_settlement_area_home_formated = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_home_ganda);

            $total_settlement_area_agri_formated = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_agri_ganda);
        } else {
            $total_settlement_area_home_formated = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_home_lessa);

            $total_settlement_area_agri_formated = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_agri_lessa);
        }

        //**** if data intserted successfully*/
        $data = [
            'responseType'            => 2,
            'totalSettlementAreaHome' => $total_settlement_area_home_formated,
            'totalSettlementAreaAgri' => $total_settlement_area_agri_formated,
            'appnData'                => $areaUpdateArr,
            'msg'                     => "Encroacher data updated successfully...",
        ];
        echo json_encode($data);
    }

    //****update settlement_applicant*** */
    public function updateApplicantDetails()
    {
        //****getting the data  */
        $applicant_d_id = $this->input->post('applicant_d_id');
        $case_no        = $this->input->post('case_no');

        //******backend validation */
        //***delimiter for not returning <p> tag */
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('applicant_d_id', 'Applicant ID', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
        $this->form_validation->set_rules('applicant_d_applicant_name_ass', 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
        $this->form_validation->set_rules('applicant_d_applicant_name_eng', 'Pattadar English Name', 'trim|required|min_length[3]|max_length[70]');
        $this->form_validation->set_rules('applicant_d_guardian_name_ass', 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
        $this->form_validation->set_rules('applicant_d_guardian_name_eng', 'Pattadar English Guardian', 'trim|min_length[3]|required|max_length[70]');
        $this->form_validation->set_rules('applicant_d_relation', 'Pattadar Guardian Relation', 'trim|required');
        $this->form_validation->set_rules('applicant_d_gender', 'Pattadar Gender ', 'trim|required');
        $this->form_validation->set_rules('applicant_d_dob', 'DOB', 'required|max_length[70]');

        if ($this->input->post('applicant_d_is_applicant') == 1) {
            $this->form_validation->set_rules('applicant_d_marital_status', 'Marital Status.', 'trim|required|max_length[10]');
        }
        $this->form_validation->set_rules('applicant_d_mobile', 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('applicant_d_per_address', 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('applicant_d_pre_address', 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');

        if ($this->form_validation->run() == false) {
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPPBACK00012:" . validation_errors() . "#case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();

        if ($this->input->post('applicant_d_is_applicant') == 1) {
            $marital_status = $this->input->post('applicant_d_marital_status');
        } else {
            $marital_status = null;
        }

        $applicantDetailsArr = [
            'pdar_name'         => $this->input->post('applicant_d_applicant_name_ass'),
            'eng_pdar_name'     => $this->input->post('applicant_d_applicant_name_eng'),
            'pdar_guardian'     => $this->input->post('applicant_d_guardian_name_ass'),
            'eng_pdar_guardian' => $this->input->post('applicant_d_guardian_name_eng'),
            'pdar_rel_guar'     => $this->input->post('applicant_d_relation'),
            'pdar_gender'       => $this->input->post('applicant_d_gender'),
            'dob'               => $this->input->post('applicant_d_dob'),
            'marital_status'    => $marital_status,
            'pdar_mobile'       => $this->input->post('applicant_d_mobile'),
            'pdar_add1'         => $this->input->post('applicant_d_per_address'),
            'pdar_add2'         => $this->input->post('applicant_d_pre_address'),
        ];

        $this->db->where('case_no', $case_no);
        $this->db->where('id', $applicant_d_id);
        $this->db->update('settlement_applicant', $applicantDetailsArr);

        //*******check if data updated */
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#SETTLAPP0001: Update fail in settlement_applicant ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPP0001: Update fail in settlement_applicant : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();
        //**** if data intserted successfully*/
        $data = [
            'responseType' => 2,
            'appnData'     => $applicantDetailsArr,
            'msg'          => "Encroacher data updated successfully...",
        ];
        echo json_encode($data);

    }

    public function updateEncroacher()
    {
        $case_no       = $this->input->post('case_no');
        $id            = $this->input->post('riotee_id');
        $enc_id        = $this->input->post('enc_id');
        $enc_name      = $this->input->post('enc_name');
        $enc_father    = $this->input->post('enc_father');
        $enc_from      = $this->input->post('enc_from');
        $enc_land_type = $this->input->post('enc_land_type');
        $this->load->model('NcModel/NcServiceModel');
        $encroacherD = $this->NcServiceModel->getApplicantEncroacher($case_no, $id);
        if (empty($encroacherD) || $encroacherD == null) {
            log_message('error', '#CHANGEENC6424: encroacher not found case no :' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#CHANGEENC6424: encroacher not found case no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }
        $this->db->trans_begin();
        $saveInDeleted = [
            'dist_code'            => $encroacherD->dist_code,
            'subdiv_code'          => $encroacherD->subdiv_code,
            'cir_code'             => $encroacherD->cir_code,
            'mouza_pargona_code'   => $encroacherD->mouza_pargona_code,
            'lot_no'               => $encroacherD->lot_no,
            'vill_townprt_code'    => $encroacherD->vill_townprt_code,
            'year_no'              => $encroacherD->year_no,
            'petition_no'          => $encroacherD->petition_no,
            'dag_no'               => $encroacherD->dag_no,
            'patta_no'             => $encroacherD->patta_no,
            'patta_type_code'      => $encroacherD->patta_type_code,
            'pdar_id'              => $encroacherD->pdar_id,
            'pdar_cron_no'         => $encroacherD->pdar_cron_no,
            'pdar_name'            => $encroacherD->pdar_name,
            'pdar_guardian'        => $encroacherD->pdar_guardian,
            'pdar_rel_guar'        => $encroacherD->pdar_rel_guar,
            'pdar_add1'            => $encroacherD->pdar_add1,
            'pdar_add2'            => $encroacherD->pdar_add2,
            'user_code'            => $encroacherD->user_code,
            'date_entry'           => $encroacherD->date_entry,
            'operation'            => $encroacherD->operation,
            'pdar_gender'          => $encroacherD->pdar_gender,
            'pdar_mother'          => $encroacherD->pdar_mother,
            'striked_out'          => $encroacherD->striked_out,
            'pdar_mobile'          => $encroacherD->pdar_mobile,
            'aadhar_no'            => $encroacherD->aadhar_no,
            'case_no'              => $encroacherD->case_no,
            'i_area_b'             => $encroacherD->i_area_b,
            'i_area_k'             => $encroacherD->i_area_k,
            'i_area_lc'            => $encroacherD->i_area_lc,
            'i_area_g'             => $encroacherD->i_area_g,
            'i_area_kr'            => $encroacherD->i_area_kr,
            'pdar_type'            => $encroacherD->pdar_type,
            'date_update'          => $encroacherD->date_update,
            'inplace_alongwith'    => $encroacherD->inplace_alongwith,
            'riotee_id'            => $encroacherD->riotee_id,
            'khatian_no'           => $encroacherD->khatian_no,
            'enc_id'               => $encroacherD->enc_id,
            'period_possession'    => $encroacherD->period_possession,
            'caste'                => $encroacherD->caste,
            'bpl'                  => $encroacherD->bpl,
            'is_applicant'         => $encroacherD->is_applicant,
            'identity_ref_no'      => $encroacherD->identity_ref_no,
            'identity_type'        => $encroacherD->identity_type,
            'identity_doc_link'    => $encroacherD->identity_doc_link,
            'marital_status'       => $encroacherD->marital_status,
            'dob'                  => $encroacherD->dob,
            'eng_pdar_name'        => $encroacherD->eng_pdar_name,
            'eng_pdar_guardian'    => $encroacherD->eng_pdar_guardian,
            'enc_not_eligible'     => $encroacherD->enc_not_eligible,
            'mask_id'              => $encroacherD->mask_id,
            'encroacher_exist_vlb' => $encroacherD->encroacher_exist_vlb,
            'nc_encroacher'        => $encroacherD->nc_encroacher,
            'deleted_id'           => $encroacherD->id,
            'deleted_by'           => $this->session->userdata('user_code'),
            'deleted_ip'           => $this->input->ip_address(),
            'deleted_at'           => date('Y-m-d h:i:s'),
        ];

        $insertDelHistory = $this->db->insert('settlement_encroacher_deleted', $saveInDeleted);
        if ($insertDelHistory != 1) {
            $this->db->trans_rollback();
            log_message('error', '#CHANGEENC6487: Insertion failed in settlement_encroacher_deleted for case no :' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#MREN00001: Update fail in settlement applicant : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $encroacherUpdateArr = [
            'enc_id'            => $enc_id,
            'pdar_name'         => $enc_name,
            'pdar_guardian'     => $enc_father,
            'period_possession' => $enc_from,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->where('id', $id);
        // $this->db->where('enc_id', $enc_id);
        $this->db->where('pdar_type', 'EN');
        $this->db->update('settlement_applicant', $encroacherUpdateArr);

        // echo $this->db->last_query();

        //*******check if data updated */
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            log_message('error', '#SETTLAPP003301: Update fail in settlement_applicant ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPP003301: Update fail in settlement_applicant : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        //*****delete if data inserted and selected from vlb list */
        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
        $this->db->query('delete from settlement_land_bank_details where application_no = ?', [$application_no]);

        // $this->db->query('delete from land_bank_encroacher_details where application_no = ?', array($application_no));

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => 'LRA update the occupier id ' . $id,
            'status'               => 'W',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'LM',
            'office_to'            => 'CO',
            'task'                 => 'LRA update occupiers',
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            log_message('error', '#SETTLAPP006556: Update fail in settlement_applicant ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPP006556: Update fail  : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();

        //**** if data intserted successfully*/
        $data = [
            'responseType' => 2,
            'appnData'     => $encroacherUpdateArr,
            'msg'          => "Encroacher data updated successfully...",
        ];
        echo json_encode($data);

    }

    //****add settlement_nominee*** */
    public function addFamilyDetails()
    {
        $case_no = $this->input->post('case_no');

        //******backend validation */
        //***delimiter for not returning <p> tag */
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('nominee_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
        $this->form_validation->set_rules('relation', 'Relation', 'trim|required');
        $this->form_validation->set_rules('mobile_no', 'Mobile No.', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[3]|max_length[200]');

        if ($this->form_validation->run() == false) {
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPPBACK00028:" . validation_errors() . "#case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $familyDetailsArr = [
            'case_no'      => $this->input->post('case_no'),
            'nominee_name' => $this->input->post('nominee_name'),
            'address'      => $this->input->post('address'),
            'relation'     => $this->input->post('relation'),
            'mobile_no'    => $this->input->post('mobile_no'),
        ];

        $insFamily                         = $this->db->insert('settlement_nominee', $familyDetailsArr);
        $id                                = $this->db->insert_id();
        $familyDetailsArr['relation_name'] = $this->utilityclass->appRelationbyIDMB2($this->input->post('relation'));
        $familyDetailsArr['id']            = $id;

        if ($insFamily != 1) {
            $this->db->trans_rollback();
            log_message('error', '#SETTLNOM0001: Insert fail in settlement_nominee ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLNOM0001: Update Insert in settlement_nominee : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        //**** if data intserted successfully*/
        $data = [
            'responseType' => 2,
            'appnData'     => $familyDetailsArr,
            'msg'          => "Family data added successfully...",
        ];
        echo json_encode($data);

    }

    // Delete family
    public function delFamilyDetails()
    {
        $this->db->trans_begin();
        $id      = $this->input->post('id');
        $case_no = $this->input->post('case_no');

        //if condition if no id fond or already deleted
        $sql    = "delete from settlement_nominee where id='$id' and case_no='$case_no'";
        $result = $this->db->query($sql);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            $response['status'] = 0;
            echo json_encode(['status' => 0]);
            log_message("error", "#PROP0002 Failed to delete family: " . $id);
            return;
        } else {
            $this->db->trans_commit();

            //get count from table
            $count = $this->db->query("SELECT * FROM settlement_nominee WHERE case_no=?",
                [$case_no])->num_rows();

            $response['status'] = 200;
            echo json_encode(['status' => 200, 'count' => $count]);
            return;
        }
    }

    //****Add settlement_applicant*** */
    public function addApplicantDetails()
    {
        //****getting the data  */
        $case_no = $this->input->post('case_no');

        //******backend validation */
        //***delimiter for not returning <p> tag */
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
        $this->form_validation->set_rules('add_applicant_name_ass', 'Pattadar Name', 'trim|required|min_length[3]|max_length[220]');
        $this->form_validation->set_rules('add_applicant_name_eng', 'Pattadar English Name', 'trim|required|min_length[3]|max_length[220]');
        $this->form_validation->set_rules('add_guardian_name_ass', 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('add_guardian_name_eng', 'Pattadar English Guardian', 'trim|min_length[3]|required|max_length[100]');
        $this->form_validation->set_rules('add_relation', 'Pattadar Guardian Relation', 'trim|required');
        $this->form_validation->set_rules('add_gender', 'Pattadar Gender ', 'trim|required');
        $this->form_validation->set_rules('add_dob', 'DOB', 'required|max_length[70]');
        $this->form_validation->set_rules('add_marital_status', 'Marital Status.', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('add_mobile', 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('add_per_address', 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('add_pre_address', 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');

        if ($this->form_validation->run() == false) {
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPPBACK00013:" . validation_errors() . "#case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();

        $basicData = $this->db->select()->where('case_no', $case_no)->get('settlement_basic')->row();
        //*******pdar_cron number generation */
        $cron_no = $this->SettlementCommonModel->getPdarCronNo($case_no);

        //get count from table
        $count = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? and pdar_type=?",
            [$case_no, 'B'])->num_rows();

        $addApplicantDetailsArr = [
            'dist_code'          => $basicData->dist_code,
            'subdiv_code'        => $basicData->subdiv_code,
            'cir_code'           => $basicData->cir_code,
            'mouza_pargona_code' => $basicData->mouza_pargona_code,
            'lot_no'             => $basicData->lot_no,
            'vill_townprt_code'  => $basicData->vill_townprt_code,
            'user_code'          => $this->session->userdata('user_code'),
            'case_no'            => $case_no,
            'petition_no'        => $basicData->petition_no,
            'operation'          => 'E',
            'dag_no'             => 0,
            'patta_no'           => 0,
            'patta_type_code'    => 0,
            'year_no'            => date('Y'),
            'date_entry'         => date('Y-m-d'),
            'pdar_id'            => '-1',
            'pdar_cron_no'       => $cron_no,
            'pdar_type'          => 'B',
            'is_applicant'       => 0,
            'identity_ref_no'    => null,
            'identity_type'      => null,
            'identity_doc_link'  => null,
            'pdar_name'          => $this->input->post('add_applicant_name_ass'),
            'eng_pdar_name'      => $this->input->post('add_applicant_name_eng'),
            'pdar_guardian'      => $this->input->post('add_guardian_name_ass'),
            'eng_pdar_guardian'  => $this->input->post('add_guardian_name_eng'),
            'pdar_rel_guar'      => $this->input->post('add_relation'),
            'pdar_gender'        => $this->input->post('add_gender'),
            'dob'                => $this->input->post('add_dob'),
            'marital_status'     => $this->input->post('add_marital_status'),
            'pdar_mobile'        => $this->input->post('add_mobile'),
            'pdar_add1'          => $this->input->post('add_per_address'),
            'pdar_add2'          => $this->input->post('add_pre_address'),
        ];

        $addsSetApplicant = $this->db->insert('settlement_applicant', $addApplicantDetailsArr);
        // var_dump($this->db->last_query()); die;
        $id                                      = $this->db->insert_id();
        $addApplicantDetailsArr['relation_name'] = $this->utilityclass->get_relation_id($this->input->post('add_relation'));
        if ($this->input->post('add_gender') == "1") {
            $gender = 'Male';
        } else if ($this->input->post('add_gender') == "2") {
            $gender = 'Female';
        } else if ($this->input->post('add_gender') == "3") {
            $gender = 'Others';
        }
        $addApplicantDetailsArr['id']     = $id;
        $addApplicantDetailsArr['count']  = $count + 1;
        $addApplicantDetailsArr['gender'] = $gender;

        //*******check if data inserted */
        if ($addsSetApplicant != 1) {
            $this->db->trans_rollback();
            log_message('error', '#SETTLAPP00011: Insert failed in settlement_applicant ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#SETTLAPP00011: Insert failed in settlement_applicant : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();
        //**** if data intserted successfully*/
        $data = [
            'responseType' => 2,
            'appnData'     => $addApplicantDetailsArr,
            'msg'          => "Applicant inserted successfully...",
        ];
        echo json_encode($data);

    }

    // Delete applicant
    public function delApplicantDetails()
    {
        $this->db->trans_begin();
        $id      = $this->input->post('id');
        $case_no = $this->input->post('case_no');

        $sql    = "delete from settlement_applicant where id='$id' and case_no='$case_no'";
        $result = $this->db->query($sql);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            $response['status'] = 0;
            echo json_encode(['status' => 0]);
            log_message("error", "#PROP00023 Failed to delete applicant: " . $id);
            return;
        } else {
            $this->db->trans_commit();

            //get count from table
            $count = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=?",
                [$case_no])->num_rows();

            $response['status'] = 200;
            echo json_encode(['status' => 200, 'count' => $count]);
            return;
        }
    }

    public function checkRuralUrban()
    {
        $case_no = $this->input->post('case_no');
        $sql     = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);

        if ($sql->num_rows() > 0) {
            $data = [
                'responseType' => 2,
                'villageName'  => $this->utilityclass->getEnglishVillageName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code, $sql->row()->lot_no, $sql->row()->vill_townprt_code),
                'mouzaName'    => $this->utilityclass->getEnglishMouzaName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code),
                'circleName'   => $this->utilityclass->getEnglishCircleName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code),
                'isUrban'      => $sql->row()->is_urban,
                'area'         => $sql->result(),
            ];
            echo json_encode($data);
        } else {
            $data = [
                'responseType' => 0,
                'msg'          => "#RURAL003344: Case not found against case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }
    }

    public function checkRuralUrbanv2()
    {
        $case_no     = $this->input->post('case_no');
        $sql         = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);
        $reservation = $this->db->query("SELECT * FROM settlement_reservation WHERE case_no = ?", [$case_no]);
        if ($sql->num_rows() > 0) {
            $distCode = $sql->row()->dist_code;
            if (in_array($distCode, json_decode(BARAK_VALLEY))) {
                if ($reservation->num_rows() == 0) {
                    $totalSettlementArea          = $this->utilityclass->Total_ganda($sql->row()->s_dag_area_b, $sql->row()->s_dag_area_k, $sql->row()->s_dag_area_lc, $sql->row()->s_dag_area_g);
                    $converttoBighaKhtaLessaGanda = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalSettlementArea);
                } else {
                    $totalApplied = $this->utilityclass->Total_ganda($sql->row()->s_dag_area_b, $sql->row()->s_dag_area_k, $sql->row()->s_dag_area_lc, $sql->row()->s_dag_area_g);
                    $totalReserve = $this->utilityclass->Total_ganda($reservation->row()->bigha, $reservation->row()->katha, $reservation->row()->lessa, $reservation->row()->ganda);
                    // $totalReserve = $reservation->row()->bigha * 5 * 20 +  $reservation->row()->katha * 20 +  $reservation->row()->lessa;
                    $totalSettlementArea          = $totalApplied - $totalReserve;
                    $converttoBighaKhtaLessaGanda = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalSettlementArea);
                }
                $data = [
                    'responseType' => 2,
                    'villageName'  => $this->utilityclass->getEnglishVillageName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code, $sql->row()->lot_no, $sql->row()->vill_townprt_code),
                    'mouzaName'    => $this->utilityclass->getEnglishMouzaName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code),
                    'circleName'   => $this->utilityclass->getEnglishCircleName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code),
                    'isUrban'      => $sql->row()->is_urban,
                    'area'         => $converttoBighaKhtaLessaGanda[0] . " Bigha " . $converttoBighaKhtaLessaGanda[1] . " Katha " . $converttoBighaKhtaLessaGanda[2] . " Lessa " . $converttoBighaKhtaLessaGanda[3] . " Ganda",
                ];
                echo json_encode($data);
                return;
            } else {
                if ($reservation->num_rows() == 0) {
                    $totalSettlementArea     = $this->utilityclass->Total_Lessa($sql->row()->s_dag_area_b, $sql->row()->s_dag_area_k, $sql->row()->s_dag_area_lc);
                    $converttoBighaKhtaLessa = $this->utilityclass->Total_Bigha_Katha_Lessa($totalSettlementArea);
                } else {
                    $totalApplied = $this->utilityclass->Total_Lessa($sql->row()->s_dag_area_b, $sql->row()->s_dag_area_k, $sql->row()->s_dag_area_lc); //$sql->row()->s_dag_area_b * 5 * 20 +  $sql->row()->s_dag_area_k * 20 +  $sql->row()->s_dag_area_lc;
                    $totalReserve = $this->utilityclass->Total_Lessa($reservation->row()->bigha, $reservation->row()->katha, $reservation->row()->lessa);
                    // $totalReserve = $reservation->row()->bigha * 5 * 20 +  $reservation->row()->katha * 20 +  $reservation->row()->lessa;
                    $totalSettlementArea     = $totalApplied - $totalReserve;
                    $converttoBighaKhtaLessa = $this->utilityclass->Total_Bigha_Katha_Lessa($totalSettlementArea);
                }
                $data = [
                    'responseType' => 2,
                    'villageName'  => $this->utilityclass->getEnglishVillageName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code, $sql->row()->lot_no, $sql->row()->vill_townprt_code),
                    'mouzaName'    => $this->utilityclass->getEnglishMouzaName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code),
                    'circleName'   => $this->utilityclass->getEnglishCircleName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code),
                    'isUrban'      => $sql->row()->is_urban,
                    'area'         => $converttoBighaKhtaLessa[0] . " Bigha " . $converttoBighaKhtaLessa[1] . " Katha " . $converttoBighaKhtaLessa[2] . " Lessa",
                ];
                echo json_encode($data);
                return;
            }
        } else {
            $data = [
                'responseType' => 0,
                'msg'          => "#RURAL003344: Case not found against case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }
    }

    public function getVillName()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->post('subdiv');
        $cir_code    = $this->input->post('circle');
        $mouza_code  = $this->input->post('mouza');
        $lot_no      = $this->input->post('lot');

        //get list of villages from settlement basic
        $query = $this->db->query("SELECT A.dist_code, A.subdiv_code, A.cir_code, A.mouza_pargona_code,
          A.lot_no, A.vill_townprt_code, B.loc_name FROM settlement_basic A
          JOIN location B ON A.uuid=B.uuid
          WHERE A.dist_code=? AND
          A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=?
          GROUP BY
          A.dist_code, A.subdiv_code, A.cir_code, A.mouza_pargona_code, A.lot_no,
          A.vill_townprt_code, B.loc_name",
            [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no])->result();

        echo json_encode([
            'responseType' => 1,
            'location'     => $query,
        ]);
        return;
    }

    //check if already send to SDLAC/CDLAC Member
    public function checkForSdlacStatus()
    {
        $proposal_id = $this->input->post('prop_id');
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');

        $processStatus = $this->db->query("SELECT * FROM settlement_proposal_list
                                    WHERE sdlac_prceed_status " . PROPOSAL_SEND_TO_SDLAC . "
                                    AND dist_code = ? AND id = ? AND subdiv_code = ?
                                    AND created_by = ? ",
            [$dist_code, $proposal_id, $subdiv_code, MB_SUB_DIV_COMM]);

        if ($processStatus->num_rows() == 0) {
            $json = [
                'response' => 1,
                'message'  => 'Already send to SDLAC members',
            ];
            echo json_encode($json);
            return false;
        } else {
            $json = [
                'response' => 2,
            ];
            echo json_encode($json);
            return;
        }
    }

    public function pendingCasesStatus($service_code)
    {

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');

        $user_code = $this->session->userdata('user_code');

        $sql = $this->db->query("SELECT user_desig_code FROM users WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND user_code = ?", [$this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $user_code])->row();

        $user_desig_code = $sql->user_desig_code;

        if (trim($user_desig_code) == 'ADC') {
            $url = API_LINK_MB2 . "pendingCasesByAdc/$dist_code/$service_code";
            // $url = "http://localhost/rtpsmb2/Api/"."pendingCasesByAdc/$dist_code/$service_code" ;

        } elseif (trim($user_desig_code) == 'SDO') {
            $url = API_LINK_MB2 . "pendingCasesBySdo/$dist_code/$subdiv_code/$service_code";
            // $url = "http://localhost/rtpsmb2/Api/"."pendingCasesBySdo/$dist_code/$subdiv_code/$service_code" ;

        } elseif (trim($user_desig_code) == 'DC') {
            $url = API_LINK_MB2 . "pendingCasesByDC/$dist_code/$service_code";
            // $url = "http://localhost/rtpsmb2/Api/"."pendingCasesByDC/$dist_code/$service_code" ;

        }

        // $url = API_LINK_MB2."pendingCasesByAdc/$dist_code/$service_code" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
    }

    public function sdoDash()
    {
        $d           = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB2 . "districtDashboardSdo/$d/$subdiv_code";
        // $url = "http://localhost/rtpsmb2/Api/"."districtDashboardSdo/$d/$subdiv_code" ;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);

        if (! isset($district['output'])) {
            echo "No data found !";
            return false;
        }

        $district['_view'] = 'basundhara/settlement_cases_count_sdo';
        $this->load->view('layouts/main', $district);

    }

    public function adcDash()
    {
        $d           = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB2 . "districtDashboardAdc/$d";
        // $url = "http://localhost/rtpsmb2/Api/"."districtDashboardAdc/$d" ;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);

        // var_dump($output);
        // die;

        if (! isset($district['output'])) {
            echo "No data found !";
            return false;
        }

        $district['_view'] = 'basundhara/settlement_cases_count_adc';
        $this->load->view('layouts/main', $district);

    }

    //check if proposal exceeds the time limit in SDLAC login
    public function checkProposalTimeLimit($dist_code)
    {

        $current_time = strtotime(date('Y-m-d h:i:s'));

        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('expiry_status', 0);
        $expiry_list_row = $this->db->get()->num_rows();

        if ($expiry_list_row > 0) { //check if data exists

            $expiry_list = $this->db->get()->result();

            foreach ($expiry_list as $row) {

                $entry_time = strtotime($row->expiry_hour_start_time);

                $seconds = $current_time - $entry_time;
                $hour    = $seconds / 60 / 60;

                if ($hour > SDLAC_PROPOSAL_EXPIRY_TIME_IN_HOUR) { //update

                    $update = [
                        'sdlac_prceed_status' => AUTO_AGREE_BY_SDLAC_MEMBER_AFTER_SPECIFIED_HOUR,
                        'expiry_status'       => SDLAC_EXPIRY_HOUR_EXCEED_TIME,
                    ];

                    $this->db->where('dist_code', $dist_code);
                    $this->db->where('expiry_status', 0);
                    $this->db->update('settlement_proposal_list', $update);
                }
            }
            return 'y';
        } else {
            return 'n';
        }
    }

    // Delete dag

    public function deleteDagAreaRevert()
    {
        $this->db->trans_begin();
        $id      = $this->input->post('id');
        $case_no = $this->input->post('case_no');
        $dag_no  = $this->input->post('dag_no');

        //********check if LM already added encroacher in VLB  */
        $application_no = $this->db->query("SELECT applid FROM settlement_basic WHERE case_no = ?", [$case_no])->row()->applid;

        $enc_query = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? and dag_no = ?", [$application_no, $dag_no]);

        if ($enc_query->num_rows() > 0) {
            $updateApplicantArr = [
                'pdar_name'     => '',
                'pdar_guardian' => '',
                // 'period_possession' => '',
            ];

            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $dag_no);
            $this->db->where('pdar_type', 'EN');
            $this->db->update('settlement_applicant', $updateApplicantArr);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'ERR3643434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#ERR3643434 Update failed in settlemnt_applicant!: " . $case_no);
                return;
            } else {
                $this->db->query("DELETE FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", [$application_no, $dag_no]);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'ERR3434343333: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#ERR3434343333 Delete failed in settlemnt_land_bank_details!: " . $case_no);
                    return;
                }

                $land_bank_avail_sql = $this->db->query("SELECT id FROM land_bank_details WHERE dag_no = ? AND application_no = ? ORDER BY id DESC", [$dag_no, $application_no]);

                if ($land_bank_avail_sql->num_rows() > 0) {
                    $land_bank_details_id = $land_bank_avail_sql->row()->id;

                    $this->db->query("DELETE FROM land_bank_encroacher_details WHERE land_bank_details_id = ? AND application_no = ?", [$land_bank_details_id, $application_no]);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'status'  => 0,
                            'message' => 'ERR3434343353: Something went wrong! Please contact ADMIN...',
                        ]);
                        log_message("error", "#ERR3434343353 Delete failed in land_bank_encroacher_details!: " . $application_no);
                        return;
                    }

                } else {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'ERR3434333: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#ERR3434333 No data found in land_bank_details!: " . $application_no);
                    return;
                }
            }
        }

        //***********settlement_applicant (Encroacher delete) */

        //***************Delete Trace map copy incase of second proceeding */
        $sqlapplicant = $this->db->query("select * from settlement_applicant where case_no = ? and dag_no = ? and pdar_type = ?", [$case_no, $dag_no, 'EN']);

        if ($sqlapplicant->num_rows() > 0) {
            $insertDeletedApplicant = [
                'case_no'    => $case_no,
                'table_name' => 'settlement_applicant',
                'date_entry' => date('Y-m-d'),
                'dag_no'     => $dag_no,
                'table_data' => json_encode($sqlapplicant->row()),
            ];

            $insertDeletedApplicant = $this->db->insert('settlement_deleted_data', $insertDeletedApplicant);

            if ($insertDeletedApplicant != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'TPROP03003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#TPROP03003434 Insertion failed in settlement_deleted_data: " . $case_no);
                return;
            } else {
                $this->db->query("delete from settlement_applicant where case_no = ? and dag_no = ? and pdar_type = ?", [$case_no, $dag_no, 'EN']);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PROP0003434: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#PROP0003434 Failed to delete encroacher: " . $case_no);
                    return;
                }
            }
        }

        //***************Delete Trace map copy incase of second proceeding */
        $supportiveInsertquery = $this->db->query("SELECT * FROM supportive_document WHERE case_no = ? AND file_name = ? AND dag_no = ?", [$case_no, 'Trace Map Copy', $dag_no]);

        if ($supportiveInsertquery->num_rows() > 0) {
            $insertDeletedJsonArr = [
                'case_no'    => $case_no,
                'table_name' => 'supportive_document',
                'date_entry' => date('Y-m-d'),
                'dag_no'     => $dag_no,
                'file_name'  => 'Trace Map Copy',
                'table_data' => json_encode($supportiveInsertquery->row()),
            ];

            $insertDeletedJson = $this->db->insert('settlement_deleted_data', $insertDeletedJsonArr);

            if ($insertDeletedJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP03003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PROP03003434 Insertion failed in settlement_deleted_data: " . $case_no);
                return;
            } else {
                $this->db->query("DELETE FROM supportive_document WHERE case_no = ? AND file_name = ? AND dag_no = ?", [$case_no, 'Trace Map Copy', $dag_no]);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PROP303434: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#PROP303434 Failed to delete Trace Map Copy : " . $case_no);
                    return;
                }
            }
        }

        ///// delete reservation data ////////
        $sqlReservation = $this->db->query("select * from settlement_reservation where case_no = ? and dag_no = ? and type = ?", [$case_no, $dag_no, 'R']);

        if ($sqlReservation->num_rows() > 0) {
            $insertDeletedReservation = [
                'case_no'          => $case_no,
                'table_name'       => 'settlement_reservation',
                'date_entry'       => date('Y-m-d'),
                'dag_no'           => $dag_no,
                'table_data'       => json_encode($sqlReservation->row()),
                'reservation_type' => 'R',
            ];

            $insertDeletedReserv = $this->db->insert('settlement_deleted_data', $insertDeletedReservation);

            if ($insertDeletedReserv != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'TEEROP03003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#TEEROP03003434 Insertion failed in settlement_deleted_data: " . $case_no);
                return;
            } else {
                $this->db->query("delete from settlement_reservation where case_no = ? and dag_no = ? and type = ?", [$case_no, $dag_no, 'R']);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PROP41003434: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#PROP41003434 Failed to delete reservation: " . $case_no);
                    return;
                }
            }
        }

        ///// delete reservation data end ////////

        //**************settlement_dag_details (dag Delete) */
        $total_home_bigha  = 0;
        $total_home_katha  = 0;
        $total_home_lessa  = 0;
        $total_home_ganda  = 0;
        $total_home_kranti = 0;

        $total_agri_bigha  = 0;
        $total_agri_katha  = 0;
        $total_agri_lessa  = 0;
        $total_agri_ganda  = 0;
        $total_agri_kranti = 0;

        $dagSelectQuery = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? AND dag_no = ?", [$case_no, $dag_no]);

        if ($dagSelectQuery->num_rows() > 0) {
            $insertDeletedJsonArr2 = [
                'case_no'                   => $case_no,
                'table_name'                => 'settlement_dag_details',
                'date_entry'                => date('Y-m-d'),
                'dag_no'                    => $dag_no,
                'settlement_dag_details_id' => $id,
                'table_data'                => json_encode($dagSelectQuery->row()),
            ];

            $insertDeletedJson2 = $this->db->insert('settlement_deleted_data', $insertDeletedJsonArr2);

            if ($insertDeletedJson2 != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP06003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PROP06003434 Insertion failed in settlement_deleted_data: " . $case_no);
                return;
            } else {
                $sql = "delete from settlement_dag_details where id='$id' and case_no='$case_no'";

                $this->db->query("DELETE FROM settlement_dag_details WHERE case_no = ? AND dag_no = ? AND id = ?", [$case_no, $dag_no, $id]);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PRFOP0002: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#PRFOP0002 Failed to delete settlement_dag_details: " . $case_no);
                    return;
                }
            }

            $sqlAreaUpdate = $this->db->query("update settlement_area_history set is_deleted=1 WHERE case_no = ? AND dag_no = ?", [$case_no, $dag_no]);

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $response['status'] = 0;
                echo json_encode(['status' => 0]);
                log_message("error", "#PROP000232 Failed to update area history: " . $case_no);
                return;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                log_message("error", "#PROP0002012 Failed to delete dag: " . $case_no);
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP0002012: Something went wrong! Please contact ADMIN...',
                ]);
                return;
            } else {
                $this->db->trans_commit();
            }

            $sqlDags = $this->SettlementKhasModel->getSettlementDag($case_no);
            foreach ($sqlDags as $all_dags) {
                $total_home_bigha  = $total_home_bigha + $all_dags->home_b;
                $total_home_katha  = $total_home_katha + $all_dags->home_k;
                $total_home_lessa  = $total_home_lessa + $all_dags->home_lc;
                $total_home_ganda  = $total_home_ganda + $all_dags->home_g;
                $total_home_kranti = $total_home_kranti + $all_dags->home_kr;
                $total_agri_bigha  = $total_agri_bigha + $all_dags->agri_b;
                $total_agri_katha  = $total_agri_katha + $all_dags->agri_k;
                $total_agri_lessa  = $total_agri_lessa + $all_dags->agri_lc;
                $total_agri_ganda  = $total_agri_ganda + $all_dags->agri_g;
                $total_agri_kranti = $total_agri_kranti + $all_dags->agri_kr;
            }

            $data = [
                'status'            => 200,
                'total_home_bigha'  => $total_home_bigha,
                'total_home_katha'  => $total_home_katha,
                'total_home_lessa'  => $total_home_lessa,
                'total_home_ganda'  => $total_home_ganda,
                'total_home_kranti' => $total_home_kranti,
                'total_agri_bigha'  => $total_agri_bigha,
                'total_agri_katha'  => $total_agri_katha,
                'total_agri_lessa'  => $total_agri_lessa,
                'total_agri_ganda'  => $total_agri_ganda,
                'total_agri_kranti' => $total_agri_kranti,

            ];
            echo json_encode($data);
        }
    }

    // Insert dag
    public function insertDagArea()
    {
        $this->db->trans_begin();
        $id      = $this->input->post('id');
        $case_no = $this->input->post('case_no');
        $dag_no  = $this->input->post('dag_no');

        //***********settlement_applicant (Encroacher delete undo) */
        $applicantInsertquery = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? AND table_name = ? AND dag_no = ?", [$case_no, 'settlement_applicant', $dag_no]);

        if ($applicantInsertquery->num_rows() > 0) {

            $data = json_decode($applicantInsertquery->row()->table_data);

            $insertApplicantJson = $this->db->insert('settlement_applicant', $data);

            if ($insertApplicantJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRGP233003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PRGP233003434 Insertion failed in settlement_applicant: " . $case_no);
                return;
            }

            $this->db->query("delete from settlement_deleted_data where case_no = ? and dag_no = ? and table_name = ?", [$case_no, $dag_no, 'settlement_applicant']);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP9003434: Something went wrong !',
                ]);
                log_message("error", "#PROP9003434 Failed to delete encroacher: " . $case_no);
                return;
            }
        }

        $total_home_bigha  = 0;
        $total_home_katha  = 0;
        $total_home_lessa  = 0;
        $total_home_ganda  = 0;
        $total_home_kranti = 0;

        $total_agri_bigha  = 0;
        $total_agri_katha  = 0;
        $total_agri_lessa  = 0;
        $total_agri_ganda  = 0;
        $total_agri_kranti = 0;

        $InsertDagquery = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? AND  dag_no = ? AND table_name = ? AND settlement_dag_details_id =?", [$case_no, $dag_no, 'settlement_dag_details', $id]);

        if ($InsertDagquery->num_rows() > 0) {

            $data3 = json_decode($InsertDagquery->row()->table_data);

            $insertDagJson = $this->db->insert('settlement_dag_details', $data3);

            if ($insertDagJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRGE3003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PRGE3003434 Insertion failed in settlement_dag_details: " . $case_no);
                return;
            } else {
                $this->db->query("delete from settlement_deleted_data WHERE case_no = ? AND  dag_no = ? AND table_name = ? AND settlement_dag_details_id =?", [$case_no, $dag_no, 'settlement_dag_details', $id]);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PRDWWOP0002: Something went wrong !',
                    ]);
                    log_message("error", "#PRDWWOP0002 Failed to delete Dag: " . $case_no);
                    return;
                }
            }

            $sqlAreaUpdate = $this->db->query("update settlement_area_history set is_deleted=0 WHERE case_no = ? AND dag_no = ?", [$case_no, $dag_no]);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message("error", "#PRWQP000233 Failed to update area history: " . $case_no);
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRWQP000233: Something went wrong !',
                ]);

                return;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                log_message("error", "#PROP22002014 Failed to insert dag: " . $case_no);
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP22002014: Something went wrong !',
                ]);
                return;
            } else {
                $this->db->trans_commit();
            }
            //  $response['status'] = 200;
            //  echo json_encode(['status' => 200]);
            $sqlAllDags = $this->SettlementKhasModel->getSettlementDag($case_no);
            foreach ($sqlAllDags as $all_dag) {
                $total_home_bigha  = $total_home_bigha + $all_dag->home_b;
                $total_home_katha  = $total_home_katha + $all_dag->home_k;
                $total_home_lessa  = $total_home_lessa + $all_dag->home_lc;
                $total_home_ganda  = $total_home_ganda + $all_dag->home_g;
                $total_home_kranti = $total_home_kranti + $all_dag->home_kr;
                $total_agri_bigha  = $total_agri_bigha + $all_dag->agri_b;
                $total_agri_katha  = $total_agri_katha + $all_dag->agri_k;
                $total_agri_lessa  = $total_agri_lessa + $all_dag->agri_lc;
                $total_agri_ganda  = $total_agri_ganda + $all_dag->agri_g;
                $total_agri_kranti = $total_agri_kranti + $all_dag->agri_kr;
            }
            // $response['status'] = 200;
            // echo json_encode(['status' => 200]);

            $data = [
                'status'            => 200,
                'total_home_bigha'  => $total_home_bigha,
                'total_home_katha'  => $total_home_katha,
                'total_home_lessa'  => $total_home_lessa,
                'total_home_ganda'  => $total_home_ganda,
                'total_home_kranti' => $total_home_kranti,
                'total_agri_bigha'  => $total_agri_bigha,
                'total_agri_katha'  => $total_agri_katha,
                'total_agri_lessa'  => $total_agri_lessa,
                'total_agri_ganda'  => $total_agri_ganda,
                'total_agri_kranti' => $total_agri_kranti,

            ];
            echo json_encode($data);

        }
    }

    public function insertDagAreaRevert()
    {
        $this->db->trans_begin();
        $id      = $this->input->post('id');
        $case_no = $this->input->post('case_no');
        $dag_no  = $this->input->post('dag_no');

        $application_no = $this->db->query("SELECT applid FROM settlement_basic WHERE case_no = ?", [$case_no])->row()->applid;

        //// FOR reserv dag insert /////////

        $reservInsertquery = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? AND dag_no = ? AND table_name = ? AND reservation_type = ?", [$case_no, $dag_no, 'settlement_reservation', 'R']);

        if ($reservInsertquery->num_rows() > 0) {

            $data2 = json_decode($reservInsertquery->row()->table_data);

            $insertReservJson = $this->db->insert('settlement_reservation', $data2);
            // echo $this->db->last_query(); die;

            if ($insertReservJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRGP883003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PRGP883003434 Insertion failed in settlement_reservation: " . $case_no);
                return;
            }

            $this->db->query("delete from settlement_deleted_data where case_no = ? and dag_no = ? and table_name = ? AND reservation_type = ?", [$case_no, $dag_no, 'settlement_reservation', 'R']);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROM903434: Something went wrong !',
                ]);
                log_message("error", "#PROM903434 Failed to delete settlement_deleted_data: " . $case_no);
                return;
            }
        } else {

            $reservationDataCheck = $this->db->query("SELECT * FROM settlement_reservation WHERE case_no = ? AND type = ?", [$case_no, 'R']);
            if ($reservationDataCheck->num_rows() > 0) {
                $patta_no_deleted = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? and dag_no = ? and table_name= ?", [$case_no, $dag_no, 'settlement_applicant'])->row()->table_data;
                $patta_no_del     = json_decode($patta_no_deleted);
                // echo "<pre>";
                // var_dump($patta_no_del->patta_no); die;

                $insertReservationArr = [
                    'dist_code'          => $patta_no_del->dist_code,
                    'subdiv_code'        => $patta_no_del->subdiv_code,
                    'cir_code'           => $patta_no_del->cir_code,
                    'mouza_pargona_code' => $patta_no_del->mouza_pargona_code,
                    'lot_no'             => $patta_no_del->lot_no,
                    'vill_townprt_code'  => $patta_no_del->vill_townprt_code,
                    'dag_no'             => $dag_no,
                    'patta_type_code'    => $patta_no_del->patta_type_code,
                    'patta_no'           => $patta_no_del->patta_no,
                    'bigha'              => 0,
                    'katha'              => 0,
                    'lessa'              => 0,
                    'ganda'              => 0,
                    'kranti'             => 0,
                    'case_no'            => $case_no,
                    'applid'             => $application_no,
                    'lm_code'            => $this->session->userdata('user_code'),
                    'date_entry'         => date('Y-m-d h:i:s'),
                    'date_update'        => date('Y-m-d h:i:s'),
                    'type'               => 'R',
                    'is_deleted'         => 0,

                ];

                $insertReservation = $this->db->insert('settlement_reservation', $insertReservationArr);

                if ($insertReservation != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PROP430034934: Something went wrong !',
                    ]);
                    log_message("error", "#PROP430034934 Insertion faild in settlement_reservation: " . $case_no);
                    return;
                }
            }

        }

        /////// reserv dag insert end ///////////

        //***********settlement_applicant (Encroacher delete undo) */
        $applicantInsertquery = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? AND table_name = ? AND dag_no = ?", [$case_no, 'settlement_applicant', $dag_no]);

        if ($applicantInsertquery->num_rows() > 0) {

            $data = json_decode($applicantInsertquery->row()->table_data);

            $insertApplicantJson = $this->db->insert('settlement_applicant', $data);

            if ($insertApplicantJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRGP033003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PRGP033003434 Insertion failed in settlement_applicant: " . $case_no);
                return;
            }

            $this->db->query("delete from settlement_deleted_data where case_no = ? and dag_no = ? and table_name = ?", [$case_no, $dag_no, 'settlement_applicant']);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP9003434: Something went wrong !',
                ]);
                log_message("error", "#PROP9003434 Failed to delete encroacher: " . $case_no);
                return;
            }
        }

        $supportiveInsertquery = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? AND file_name = ? AND dag_no = ? AND table_name = ?", [$case_no, 'Trace Map Copy', $dag_no, 'supportive_document']);

        if ($supportiveInsertquery->num_rows() > 0) {

            $data2 = json_decode($supportiveInsertquery->row()->table_data);

            $insertSupportiveJson = $this->db->insert('supportive_document', $data2);

            if ($insertSupportiveJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRGP03003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PRGP03003434 Insertion failed in supportive_document: " . $case_no);
                return;
            }

            $this->db->query("delete from settlement_deleted_data where case_no = ? and dag_no = ? and table_name = ? and file_name=?", [$case_no, $dag_no, 'supportive_document', 'Trace Map Copy']);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP903434: Something went wrong !',
                ]);
                log_message("error", "#PROP903434 Failed to delete encroacher: " . $case_no);
                return;
            }
        } else {

            $service_code = $this->db->query("SELECT service_code FROM settlement_basic WHERE case_no = ?", [$case_no])->row()->service_code;

            $insertSupportiveArr = [
                'case_no'         => $case_no,
                'file_name'       => 'Trace Map Copy',
                'user_code'       => $this->session->userdata('user_code'),
                'fetch_file_name' => 'Trace Map Copy',
                'file_type'       => 'NATRACE',
                'file_path'       => 'NATRACE',
                'date_entry'      => date('Y-m-d h:i:s'),
                'mut_type'        => $service_code,
                'dag_no'          => $dag_no,
            ];

            $insertSupportive = $this->db->insert('supportive_document', $insertSupportiveArr);

            if ($insertSupportive != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP00034934: Something went wrong !',
                ]);
                log_message("error", "#PROP00034934 Insertion faild in supportive document: " . $case_no);
                return;
            }
        }

        $total_home_bigha  = 0;
        $total_home_katha  = 0;
        $total_home_lessa  = 0;
        $total_home_ganda  = 0;
        $total_home_kranti = 0;

        $total_agri_bigha  = 0;
        $total_agri_katha  = 0;
        $total_agri_lessa  = 0;
        $total_agri_ganda  = 0;
        $total_agri_kranti = 0;

        $InsertDagquery = $this->db->query("SELECT table_data FROM settlement_deleted_data WHERE case_no = ? AND  dag_no = ? AND table_name = ? AND settlement_dag_details_id =?", [$case_no, $dag_no, 'settlement_dag_details', $id]);

        if ($InsertDagquery->num_rows() > 0) {

            $data3 = json_decode($InsertDagquery->row()->table_data);

            $insertDagJson = $this->db->insert('settlement_dag_details', $data3);

            if ($insertDagJson != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PRGP3003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PRGP3003434 Insertion failed in settlement_dag_details: " . $case_no);
                return;
            } else {
                $this->db->query("delete from settlement_deleted_data WHERE case_no = ? AND  dag_no = ? AND table_name = ? AND settlement_dag_details_id =?", [$case_no, $dag_no, 'settlement_dag_details', $id]);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PRDDOP0002: Something went wrong !',
                    ]);
                    log_message("error", "#PRDDOP0002 Failed to delete Dag: " . $case_no);
                    return;
                }
            }

            $sqlAreaUpdate = $this->db->query("update settlement_area_history set is_deleted=0 WHERE case_no = ? AND dag_no = ?", [$case_no, $dag_no]);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message("error", "#PROP000233 Failed to update area history: " . $case_no);
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP000233: Something went wrong !',
                ]);

                return;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                log_message("error", "#PROP0002014 Failed to insert dag: " . $case_no);
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP0002014: Something went wrong !',
                ]);
                return;
            } else {
                $this->db->trans_commit();
            }

            $sqlAllDags = $this->SettlementKhasModel->getSettlementDag($case_no);
            foreach ($sqlAllDags as $all_dag) {
                $total_home_bigha  = $total_home_bigha + $all_dag->home_b;
                $total_home_katha  = $total_home_katha + $all_dag->home_k;
                $total_home_lessa  = $total_home_lessa + $all_dag->home_lc;
                $total_home_ganda  = $total_home_ganda + $all_dag->home_g;
                $total_home_kranti = $total_home_kranti + $all_dag->home_kr;
                $total_agri_bigha  = $total_agri_bigha + $all_dag->agri_b;
                $total_agri_katha  = $total_agri_katha + $all_dag->agri_k;
                $total_agri_lessa  = $total_agri_lessa + $all_dag->agri_lc;
                $total_agri_ganda  = $total_agri_ganda + $all_dag->agri_g;
                $total_agri_kranti = $total_agri_kranti + $all_dag->agri_kr;
            }

            $data = [
                'status'            => 200,
                'total_home_bigha'  => $total_home_bigha,
                'total_home_katha'  => $total_home_katha,
                'total_home_lessa'  => $total_home_lessa,
                'total_home_ganda'  => $total_home_ganda,
                'total_home_kranti' => $total_home_kranti,
                'total_agri_bigha'  => $total_agri_bigha,
                'total_agri_katha'  => $total_agri_katha,
                'total_agri_lessa'  => $total_agri_lessa,
                'total_agri_ganda'  => $total_agri_ganda,
                'total_agri_kranti' => $total_agri_kranti,

            ];
            echo json_encode($data);
        }

    }

    public function deleteDagArea()
    {
        $this->db->trans_begin();
        $id      = $this->input->post('id');
        $case_no = $this->input->post('case_no');
        $dag_no  = $this->input->post('dag_no');

        //********check if LM already added encroacher in VLB  */
        $application_no = $this->db->query("SELECT applid FROM settlement_basic WHERE case_no = ?", [$case_no])->row()->applid;

        $enc_query = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? and dag_no = ?", [$application_no, $dag_no]);

        if ($enc_query->num_rows() > 0) {
            $updateApplicantArr = [
                'pdar_name'     => '',
                'pdar_guardian' => '',
                // 'period_possession' => '',
            ];

            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $dag_no);
            $this->db->where('pdar_type', 'EN');
            $this->db->update('settlement_applicant', $updateApplicantArr);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'ERR3643434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#ERR3643434 Update failed in settlemnt_applicant!: " . $case_no);
                return;
            } else {
                $this->db->query("DELETE FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", [$application_no, $dag_no]);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'ERR3434343333: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#ERR3434343333 Delete failed in settlemnt_land_bank_details!: " . $case_no);
                    return;
                }

                $land_bank_avail_sql = $this->db->query("SELECT id FROM land_bank_details WHERE dag_no = ? AND application_no = ? ORDER BY id DESC", [$dag_no, $application_no]);

                if ($land_bank_avail_sql->num_rows() > 0) {
                    $land_bank_details_id = $land_bank_avail_sql->row()->id;

                    $this->db->query("DELETE FROM land_bank_encroacher_details WHERE land_bank_details_id = ? AND application_no = ?", [$land_bank_details_id, $application_no]);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'status'  => 0,
                            'message' => 'ERR3434343353: Something went wrong! Please contact ADMIN...',
                        ]);
                        log_message("error", "#ERR3434343353 Delete failed in land_bank_encroacher_details!: " . $application_no);
                        return;
                    }

                } else {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'ERR3434333: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#ERR3434333 No data found in land_bank_details!: " . $application_no);
                    return;
                }
            }
        }

        //***********settlement_applicant (Encroacher delete) */

        //***************Delete Trace map copy incase of second proceeding */
        $sqlapplicant = $this->db->query("select * from settlement_applicant where case_no = ? and dag_no = ? and pdar_type = ?", [$case_no, $dag_no, 'EN']);

        if ($sqlapplicant->num_rows() > 0) {
            $insertDeletedApplicant = [
                'case_no'    => $case_no,
                'table_name' => 'settlement_applicant',
                'date_entry' => date('Y-m-d'),
                'dag_no'     => $dag_no,
                'table_data' => json_encode($sqlapplicant->row()),
            ];

            $insertDeletedApplicant = $this->db->insert('settlement_deleted_data', $insertDeletedApplicant);

            if ($insertDeletedApplicant != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'TPROP03003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#TPROP03003434 Insertion failed in settlement_deleted_data: " . $case_no);
                return;
            } else {
                $this->db->query("delete from settlement_applicant where case_no = ? and dag_no = ? and pdar_type = ?", [$case_no, $dag_no, 'EN']);

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PROP0003434: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#PROP0003434 Failed to delete encroacher: " . $case_no);
                    return;
                }
            }
        }

        //**************settlement_dag_details (dag Delete) */
        $total_home_bigha  = 0;
        $total_home_katha  = 0;
        $total_home_lessa  = 0;
        $total_home_ganda  = 0;
        $total_home_kranti = 0;

        $total_agri_bigha  = 0;
        $total_agri_katha  = 0;
        $total_agri_lessa  = 0;
        $total_agri_ganda  = 0;
        $total_agri_kranti = 0;

        $dagSelectQuery = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? AND dag_no = ?", [$case_no, $dag_no]);

        if ($dagSelectQuery->num_rows() > 0) {
            $insertDeletedJsonArr2 = [
                'case_no'                   => $case_no,
                'table_name'                => 'settlement_dag_details',
                'date_entry'                => date('Y-m-d'),
                'dag_no'                    => $dag_no,
                'settlement_dag_details_id' => $id,
                'table_data'                => json_encode($dagSelectQuery->row()),
            ];

            $insertDeletedJson2 = $this->db->insert('settlement_deleted_data', $insertDeletedJsonArr2);

            if ($insertDeletedJson2 != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP06003434: Something went wrong! Please contact ADMIN...',
                ]);
                log_message("error", "#PROP06003434 Insertion failed in settlement_deleted_data: " . $case_no);
                return;
            } else {
                $sql = "delete from settlement_dag_details where id='$id' and case_no='$case_no'";

                $this->db->query("DELETE FROM settlement_dag_details WHERE case_no = ? AND dag_no = ? AND id = ?", [$case_no, $dag_no, $id]);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status'  => 0,
                        'message' => 'PRFOP0002: Something went wrong! Please contact ADMIN...',
                    ]);
                    log_message("error", "#PRFOP0002 Failed to delete settlement_dag_details: " . $case_no);
                    return;
                }
            }

            $sqlAreaUpdate = $this->db->query("update settlement_area_history set is_deleted=1 WHERE case_no = ? AND dag_no = ?", [$case_no, $dag_no]);

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $response['status'] = 0;
                echo json_encode(['status' => 0]);
                log_message("error", "#PROP000232 Failed to update area history: " . $case_no);
                return;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                log_message("error", "#PROP0002012 Failed to delete dag: " . $case_no);
                echo json_encode([
                    'status'  => 0,
                    'message' => 'PROP0002012: Something went wrong! Please contact ADMIN...',
                ]);
                return;
            } else {
                $this->db->trans_commit();
            }

            $sqlDags = $this->SettlementKhasModel->getSettlementDag($case_no);
            foreach ($sqlDags as $all_dags) {
                $total_home_bigha  = $total_home_bigha + $all_dags->home_b;
                $total_home_katha  = $total_home_katha + $all_dags->home_k;
                $total_home_lessa  = $total_home_lessa + $all_dags->home_lc;
                $total_home_ganda  = $total_home_ganda + $all_dags->home_g;
                $total_home_kranti = $total_home_kranti + $all_dags->home_kr;
                $total_agri_bigha  = $total_agri_bigha + $all_dags->agri_b;
                $total_agri_katha  = $total_agri_katha + $all_dags->agri_k;
                $total_agri_lessa  = $total_agri_lessa + $all_dags->agri_lc;
                $total_agri_ganda  = $total_agri_ganda + $all_dags->agri_g;
                $total_agri_kranti = $total_agri_kranti + $all_dags->agri_kr;
            }

            $data = [
                'status'            => 200,
                'total_home_bigha'  => $total_home_bigha,
                'total_home_katha'  => $total_home_katha,
                'total_home_lessa'  => $total_home_lessa,
                'total_home_ganda'  => $total_home_ganda,
                'total_home_kranti' => $total_home_kranti,
                'total_agri_bigha'  => $total_agri_bigha,
                'total_agri_katha'  => $total_agri_katha,
                'total_agri_lessa'  => $total_agri_lessa,
                'total_agri_ganda'  => $total_agri_ganda,
                'total_agri_kranti' => $total_agri_kranti,

            ];
            echo json_encode($data);
        }
    }

    public function getRejectedReasons()
    {
        $case_no = $this->input->post('case_no');

        $sql = $this->db->query("SELECT * FROM rejected_remark WHERE case_no = ?", [$case_no]);

        if ($sql->num_rows() > 0) {
            $reject_code_array = [];
            foreach ($sql->result() as $remark_code) {
                $reject_code_array[] = $remark_code->reject_code;
            }
            $clist = "'" . implode("','", $reject_code_array) . "'";

            $reject_master_sql = $this->db->query("SELECT * FROM reject_master WHERE reject_code in ($clist)");

            if ($reject_master_sql->num_rows() > 0) {
                echo json_encode([
                    'status' => 2,
                    'data'   => $reject_master_sql->result(),
                ]);
            } else {
                echo json_encode([
                    'status'  => 0,
                    'message' => 'RERRR343444: No data found !',
                ]);
            }

        } else {
            echo json_encode([
                'status'  => 0,
                'message' => 'RERRR43444: No data found !',
            ]);
        }

    }

    // public function finalReject()
    // {
    //     $cases_array = $this->input->post('selectedList');

    //     // $clist = "'" . implode ( "','", $cases_array ) . "'";

    //     $this->db->trans_begin();

    //     $updateArray = [
    //         'status' => MB_DISMISS,
    //     ];
    //     $this->db->where_in('case_no', $cases_array);
    //     $this->db->update('settlement_basic', $updateArray);

    //     if ($this->db->affected_rows() == 0) {
    //         $this->db->trans_rollback();
    //         log_message('error', '#UPD3388: Updation failed in settlement_basic');
    //         $data = array(
    //             'responseType' => 0,
    //             'msg' => "#UPD3388: Failed to process ! Contact admin... ",
    //         );
    //         echo json_encode($data);
    //         return false;

    //     }

    //     //***********proceeding to be incorporated */
    //     foreach($cases_array as $proc_case)
    //     {
    //         //******getting the rejected remarks */
    //         $rejected_sql = $this->db->query("SELECT reject_code FROM rejected_remark WHERE case_no = ?", array($proc_case));

    //         if($rejected_sql->num_rows() > 0)
    //         {
    //             $rejected_result = $rejected_sql->result();

    //             $reject_code_array = array();
    //             foreach($rejected_result as $rejected_res)
    //             {
    //                 $reject_code_array[] = $rejected_res->reject_code;
    //             }

    //             $reject_code_clist = "'" . implode ( "','", $reject_code_array ) . "'";

    //             $sql_for_remark = $this->db->query("SELECT * FROM reject_master WHERE reject_code IN ($reject_code_clist)");

    //             if($sql_for_remark->num_rows() > 0)
    //             {
    //                 $remark_result = $sql_for_remark->result();
    //                 $remark_array = array();

    //                 foreach($remark_result as $remark_res)
    //                 {
    //                     $rejectCodeArray[] = [
    //                         'service_code' => $remark_res->service_code,
    //                         'id' => $remark_res->reject_code,
    //                         'name' => $remark_res->remark
    //                     ];

    //                     $remark_array[] = $remark_res->remark;
    //                 }

    //                 $reject_remarks = implode ( ", ", $remark_array );

    //             }
    //         }

    //         //*******insert into settlement_proceeding */
    //         $sql = "select MAX(proceeding_id) as id from settlement_proceeding where case_no=?";
    //         $res = $this->db->query($sql, array($proc_case));
    //         if ($res->num_rows() > 0)
    //         {
    //             $proceeding_id = $res->row()->id + 1;
    //         }
    //         else
    //         {
    //             $proceeding_id = 1;
    //         }

    //         $proc_values = array(
    //             'case_no'              => $proc_case,
    //             'proceeding_id'        => $proceeding_id,
    //             'date_of_hearing'      => date('Y-m-d h:i:s'),
    //             'next_date_of_hearing' => date('Y-m-d h:i:s'),
    //             'status'               => MB_DISMISS,
    //             'user_code'            => $this->session->userdata('user_code'),
    //             'date_entry'           => date('Y-m-d G:i:s'),
    //             'operation'            => 'E',
    //             'note_on_order'        => $reject_remarks,
    //             'ip'                   => $this->utilityclass->get_client_ip(),
    //             'office_from'          => $this->session->userdata('user_desig_code'),
    //             'office_to'            => '',
    //             'task'                 => 'Rejected by ' . trim($this->session->userdata('user_desig_code')),
    //         );

    //         $proc_insert = $this->db->insert('settlement_proceeding', $proc_values);

    //         if($proc_insert != 1)
    //         {
    //             $this->db->trans_rollback();
    //             $data = array(
    //                 'responseType' => 0,
    //                 'msg' => "#UPD338802: Failed to process ! Contact admin... ",
    //             );
    //             echo json_encode($data);
    //             return false;
    //         }

    //          ////////////// POST Reject status To basundhara ////////////////////
    //         $application_no = $this->SettlementApModel->getSettlementBasicCo($proc_case)->applid;

    //         $rmk = 'Rejected by DC: '.$reject_remarks;
    //         $status = 'R';
    //         $task = MB_DEPUTY_COMM;
    //         $pen = '';
    //         $case = $proc_case;
    //         $rtps_status = $this->SettlementApiModel->postApiBasundharaForRejectedCase2nd($application_no, $case, $rmk, $status, $task, $pen, $rejectCodeArray);
    //         $rtps_status = json_decode($rtps_status);
    //         if (trim($rtps_status) == "n")
    //         {
    //             //*********API hit unsuccessfull data to be inserted in a table */
    //             $rejected_failed_arr = [
    //                 'case_no' => $proc_case,
    //                 'remarks' => json_encode($rejectCodeArray)
    //             ];

    //             $rejected_failed_insert = $this->db->insert('settlement_rejected_falied_api_cases', $rejected_failed_arr);

    //             if($rejected_failed_insert != 1)
    //             {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERREJ0033035: API failed.');
    //                 $json = [
    //                     'responseType' => 0,
    //                     'msg' => '#ERREJ0033035: Unable to process',
    //                 ];
    //                 echo json_encode($json);
    //                 return false;
    //             }

    //             $this->db->trans_rollback();
    //             log_message('error', '#ERREJ003305: API failed.');
    //             $json = [
    //                 'responseType' => 0,
    //                 'msg' => '#ERREJ003305: Unable to process',
    //             ];
    //             echo json_encode($json);
    //             return false;
    //         }
    //         ////////POST to Basundhara End

    //         if($this->db->trans_status() == false)
    //         {
    //             $this->db->trans_rollback();
    //             $json = [
    //                 'responseType' => 0,
    //                 'msg' => '#ERREJ0033058: Unable to process',
    //             ];
    //             echo json_encode($json);
    //             return false;
    //         }
    //         else
    //         {
    //             $this->db->trans_commit();
    //             $json = [
    //                 'responseType' => 2,
    //                 'msg' => 'Successfully rejected...',
    //             ];
    //             echo json_encode($json);
    //         }
    //     }

    // }

    // added on 06/05/2023 for dag change, below methods have to transfer to SettlementCommon Controller
    public function getDagList()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $json = [];

        $district = $this->input->post('dist');
        $subdiv   = $this->input->post('subdiv');
        $circle   = $this->input->post('cir');
        $mouza    = $this->input->post('mouza');
        $lot      = $this->input->post('lot');
        $village  = $this->input->post('vill');
        $service  = $this->input->post('scode');

        if ($service == SETTLEMENT_KHAS_LAND_ID || $service == SETTLEMENT_TRIBAL_COMMUNITY_ID || $service == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
            $dag = $this->db->query(" SELECT distinct on(dag_no_int) trim(cb.dag_no) as dag_no,dag_no_int,
          dag_area_b AS bigha,
          dag_area_k AS katha,
          dag_area_lc AS lessa,
          dag_area_g AS ganda,
          dag_area_kr AS kranti FROM c_land_bank_details cl join chitha_basic cb on
          cl.subdiv_code=cb.subdiv_code and cl.cir_code=cb.cir_code
          and cl.mouza_pargona_code=cb.mouza_pargona_code and cl.lot_no=cb.lot_no
          and cl.vill_townprt_code=cb.vill_townprt_code and trim(cl.dag_no)=trim(cb.dag_no)
          where cl.nature_of_reservation in (7,8) and cb.subdiv_code=? and cb.cir_code=?
          and cb.mouza_pargona_code=?
          and cb.lot_No=? and cb.vill_townprt_code=? and whether_encroached='Y' order by dag_no_int",
                [$subdiv, $circle, $mouza, $lot, $village]);
            $data = $dag->result();
            echo json_encode($data);
            return;
        } else if ($service == SETTLEMENT_PGR_VGR_LAND_ID) {
            $dag = $this->db->query(" SELECT distinct on(dag_no_int) trim(cb.dag_no) as dag_no,dag_no_int,
          dag_area_b AS bigha,
          dag_area_k AS katha,
          dag_area_lc AS lessa,
          dag_area_g AS ganda,
          dag_area_kr AS kranti FROM c_land_bank_details cl join chitha_basic cb on
          cl.subdiv_code=cb.subdiv_code and cl.cir_code=cb.cir_code
          and cl.mouza_pargona_code=cb.mouza_pargona_code and cl.lot_no=cb.lot_no
          and cl.vill_townprt_code=cb.vill_townprt_code and trim(cl.dag_no)=trim(cb.dag_no)
          where cl.nature_of_reservation in (1,2) and cb.subdiv_code=? and cb.cir_code=?
          and cb.mouza_pargona_code=?
          and cb.lot_No=? and cb.vill_townprt_code=? and whether_encroached='Y' order by dag_no_int",
                [$subdiv, $circle, $mouza, $lot, $village]);
            // echo $this->db->last_query();
            $data = $dag->result();
            echo json_encode($data);
            return;
        }
    }

    public function getOccupierList()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $service_code = $this->input->post('scode');
        $dist_code    = $this->input->post('dist');
        $cir_code     = $this->input->post('cir');
        $subdiv_code  = $this->input->post('subdiv');
        $mouza_code   = $this->input->post('mouza');
        $lot_no       = $this->input->post('lot');
        $village_code = $this->input->post('vill');
        $dag          = $this->input->post('dag');
        $is_urban     = $this->input->post('rural_urban');

        $getDagFromChithaByDagInt = $this->db->query("SELECT dag_no FROM chitha_basic
      WHERE dag_no_int = ? AND dist_code=? AND cir_code=? AND subdiv_code=? AND vill_townprt_code=?
      AND mouza_pargona_code=? AND lot_no=?",
            [$dag, $dist_code, $cir_code, $subdiv_code, $village_code, $mouza_code,
                $lot_no])->row()->dag_no;

        $result = $this->db->query("SELECT DISTINCT B.*
      FROM c_land_bank_encroacher_details B JOIN
      c_land_bank_details A ON A.id = B.c_land_bank_details_id WHERE
      A.dist_code=? AND A.cir_code=? AND A.subdiv_code=? AND A.vill_townprt_code=?
      AND A.mouza_pargona_code=? AND A.lot_no=? AND trim(A.dag_no)=?",
            [$dist_code, $cir_code, $subdiv_code, $village_code, $mouza_code,
                $lot_no, trim($getDagFromChithaByDagInt)])->result_array();

        $data = '';
        foreach ($result as $value) {
            $data = $data . '<tr>
        <td>' . $value['name'] . '</td>
        <td>' . $value['fathers_name'] . '</td>
        <td align="center">' . date('d/m/Y', strtotime($value['encroachment_from'])) . '</td>
        <td align="center">
          <input type="radio" id="select_encroacher' . $value['id'] . '"
          value="select_' . $value['id'] . '" name="select_encroacher"
          class="form-check-input"
          onclick="getEncroacherDetail(' . $value['id'] . ')">
        </td>
      </tr>';
        }
        echo json_encode($data);
    }

    //save /dag/occupier/encroacher detail
    public function saveDagDetail()
    {
        $validation   = null;
        $json         = null;
        $barak_valley = json_decode(BARAK_VALLEY);

        $_POST = json_decode(file_get_contents("php://input"), true);

        $case_no                 = $this->input->post('case_no');
        $application_no          = $this->input->post('application_no');
        $district                = $this->input->post('district');
        $subdiv_code             = $this->input->post('subdiv_code');
        $circle                  = $this->input->post('circle');
        $mouza_code              = $this->input->post('mouza_code');
        $lot_no                  = $this->input->post('lot_no');
        $village1                = $this->input->post('village');
        $nature_of_land          = $this->input->post('nature_of_land');
        $service_code            = $this->input->post('service_code');
        $possession_period       = $this->input->post('possession_period');
        $encroacher_id           = $this->input->post('encroacher_id');
        $encroacher_id_available = $this->input->post('encroacher_id_available');
        $dag_no                  = $this->input->post('dag');

        if ($encroacher_id == NOT_AVAILABLE && $encroacher_id_available == NOT_AVAILABLE) {
            log_message('error', '#ERROR4958: No occupier selected, not even check box ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR4958: Select the check box in red sentence if no occupier available in list',
            ];
            echo json_encode($json);
            return;
        }

        $tot_bigha  = $this->UtilsModel->defaultValue($this->input->post('tot_bigha'), 0);
        $tot_katha  = $this->UtilsModel->defaultValue($this->input->post('tot_katha'), 0);
        $tot_lessa  = $this->UtilsModel->defaultValue($this->input->post('tot_lessa'), 0);
        $tot_ganda  = $this->UtilsModel->defaultValue($this->input->post('tot_ganda'), 0);
        $tot_kranti = $this->UtilsModel->defaultValue($this->input->post('tot_kranti'), 0);

        if ($nature_of_land == HOMESTEAD) {

            $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
            $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
            $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
            $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
            $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

            $abigha  = 0;
            $akatha  = 0;
            $alessa  = 0;
            $aganda  = 0;
            $akranti = 0;
        } else if ($nature_of_land == AGRICULTURAL) {
            $hbigha  = 0;
            $hkatha  = 0;
            $hlessa  = 0;
            $hganda  = 0;
            $hkranti = 0;

            $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
            $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
            $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
            $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
            $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);
        } else if ($nature_of_land == BOTH_LAND) {
            $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
            $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
            $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
            $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
            $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

            $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
            $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
            $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
            $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
            $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);
        }

        //////// validation ////////////
        $this->form_validation->set_rules('encroacher_id', 'Occupier Name', 'required|trim');
        $this->form_validation->set_rules('natureof_land', 'Nature of Land', 'required|trim');

        if (in_array($district, $barak_valley)) { // for barak valley{
            if ($nature_of_land == HOMESTEAD) {
                $this->form_validation->set_rules('hlessa', 'Chatak', 'required|trim|xss_clean|less_than[16]');
            } else if ($nature_of_land == AGRICULTURAL) {
                $this->form_validation->set_rules('alessa', 'Chatak', 'required|trim|xss_clean|less_than[16]');
            } else if ($nature_of_land == BOTH_LAND) {
                $this->form_validation->set_rules('hlessa', 'Chatak', 'required|trim|xss_clean|less_than[16]');
                $this->form_validation->set_rules('alessa', 'Chatak', 'required|trim|xss_clean|less_than[16]');
            }
        } else { //other than barak valley
            if ($nature_of_land == HOMESTEAD) {
                $this->form_validation->set_rules('hlessa', 'Lessa', 'required|trim|xss_clean|less_than[20]');
            } else if ($nature_of_land == AGRICULTURAL) {
                $this->form_validation->set_rules('alessa', 'Lessa', 'required|trim|xss_clean|less_than[20]');
            } else if ($nature_of_land == BOTH_LAND) {
                $this->form_validation->set_rules('hlessa', 'Lessa', 'required|trim|xss_clean|less_than[20]');
                $this->form_validation->set_rules('alessa', 'Lessa', 'required|trim|xss_clean|less_than[20]');
            }
        }

        if ($this->form_validation->run() == false) {

            $this->form_validation->set_error_delimiters('', '');
            $validation = [];

            if (form_error('encroacher_id')) {
                $validation[] = ['field' => 'encroacher_id', 'message' => form_error('encroacher_id')];
            }
            if (form_error('nature_of_land')) {
                $validation[] = ['field' => 'nature_of_land', 'message' => form_error('nature_of_land')];
            }
            if (form_error('alessa')) {
                $validation[] = ['field' => 'alessa', 'message' => form_error('alessa')];
            }
            if (form_error('hlessa')) {
                $validation[] = ['field' => 'hlessa', 'message' => form_error('hlessa')];
            }
        }

        if ($validation != null) {
            echo json_encode([
                'responseType' => 1,
                'validation'   => $validation,
            ]);
            return;
        }

        //get dag_no from chitha_basic by dag_no_int
        $getDagFromInt = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code=? AND subdiv_code=?
      AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no_int=?",
            [$district, $subdiv_code, $circle, $mouza_code, $lot_no, $village1, $dag_no]);
        //  echo $this->db->last_query(); die;

        if ($getDagFromInt->num_rows() == 0) {
            log_message('error', '#ERROR5106: No detail found in chitha_basic ' . $this->db->last_query());
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR5106: Something went wrong on selecting Dag.
          Kindly contact system administrator',
            ];
            echo json_encode($json);
            return;
        }

        $getChithaDag = $getDagFromInt->row()->dag_no; // get dag from chitha basic

        if ($encroacher_id_available == AVAILABLE && $encroacher_id_available != NOT_AVAILABLE) { // if encroacher selected from list

            //get encroacher detail
            $encroacherDetail = $this->db->query("SELECT A.* FROM c_land_bank_encroacher_details A
        JOIN c_land_bank_details B ON B.id = A.c_land_bank_details_id
        WHERE A.id=? AND B.dist_code=? AND B.cir_code=? AND B.subdiv_code=? AND B.vill_townprt_code=?
        AND B.mouza_pargona_code=? AND B.lot_no=? AND trim(B.dag_no)=?",
                [$encroacher_id, $district, $circle, $subdiv_code, $village1,
                    $mouza_code, $lot_no, trim($getChithaDag)]);

            if ($encroacherDetail->num_rows() == 0) {
                log_message('error', '#ERROR5128: No detail found in c_land_bank_encroacher_details ' . $this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERROR5128: Something went wrong on selecting occupier. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }
            $enDetail          = $encroacherDetail->row();
            $possession_period = date('Y-m-d', strtotime($enDetail->encroachment_from));

            $encroacher_name        = $enDetail->name;
            $encroacher_father_name = $enDetail->fathers_name;
        } else {
            $encroacher_name        = NO_AVAILABLE_ASSAMESE;
            $encroacher_father_name = NO_AVAILABLE_ASSAMESE;
        }

        //get patta detail from chitha basic
        $pattaDetailFromChitha = $this->db->query("SELECT dag_no, patta_no, patta_type_code FROM
      chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=?
      AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND trim(dag_no)=?",
            [$district, $subdiv_code, $circle, $mouza_code, $lot_no, $village1, trim($getChithaDag)]);
        //echo $this->db->last_query();return;

        if ($pattaDetailFromChitha->num_rows() == 0) {
            log_message('error', '#ERROR5151: No detail found in chitha_basic ' . $this->db->last_query());
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR5151: Something went wrong on selecting Dag. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return;
        }

        $pattaDetail = $pattaDetailFromChitha->row();

        //get patta type name
        $type = $this->db->query("SELECT patta_type, pattatype_eng FROM
      patta_code WHERE type_code=?", [$pattaDetail->patta_type_code])->row();

        //get settlement table name service wise
        // $table = $this->SettlementApplicantModel->selectTable($service_code);

        //completed village code
        $complete_vill_code = $district . '_' . $subdiv_code . '_' . $circle . '_' . $mouza_code . '_' . $lot_no . '_' . $village1;

        //get from settlement table
        /*
          $sameEncrocher = $this->db->query("SELECT * FROM
          $table WHERE pdar_type=? AND encroacher_id=? AND ref_no=?",
          array(ENCROACHER, $encroacher_id, $ref_no));
         */
        $sameEncrocher = $this->db->query("SELECT * FROM
      settlement_applicant WHERE pdar_type=? AND enc_id=? AND case_no=? AND dag_no=? AND enc_id!=?",
            ['EN', $encroacher_id, $case_no, trim($getChithaDag), '-1']);

        $sameDag = $this->db->query("SELECT * FROM
    settlement_dag_details WHERE case_no=? AND dag_no=?",
            [$case_no, trim($getChithaDag)]);

        // echo json_encode($sameEncrocher->num_rows());
        // return;

        $this->db->trans_begin(); //transaction begin

        if ($encroacher_id_available == NO && $encroacher_id == NO) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR5192: No occupier selected, not the default too ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR5192: Select the checkbox in case no occupier available in occupier list',
            ];
            echo json_encode($json);
            return;
        }

        if ($encroacher_id == NO_ENCROACHER && ($possession_period == '' || $possession_period == null)) {
            //if no encroacher available
            $this->db->trans_rollback();
            log_message('error', '#ERROR5211: Possession date not entered for NO OCCUPIER selection for case no ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR5211: Possession date is required',
            ];
            echo json_encode($json);
            return;
        }

        if (in_array($district, $barak_valley)) { // for barak valley
            $total_dag_area     = ($tot_bigha * 6400) + ($tot_katha * 320) + ($tot_lessa * 20) + $tot_ganda;
            $total_dag_in_bigha = ($total_dag_area / 6400);
        } else {                                                                   //other than barak valley
            $total_dag_area     = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa; //total area
            $total_dag_in_bigha = ($total_dag_area / 100);
        }

        //for settlement khas land area validation 1:home, 7:agri
        if ($service_code == SETTLEMENT_KHAS_LAND_ID) {

            if ($nature_of_land == HOMESTEAD) { //should not be more than 1 bigha

                //post data for homestead
                $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
                $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
                $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
                $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
                $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

                $areaHomeTotal = $this->db->query(" SELECT
                            SUM(home_b) AS bigha,
                            SUM(home_k) AS katha,
                            SUM(home_lc) AS lessa,
                            SUM(home_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $bigha = $this->UtilsModel->defaultValue($areaHomeTotal->bigha, 0) + $hbigha;
                $katha = $this->UtilsModel->defaultValue($areaHomeTotal->katha, 0) + $hkatha;
                $lessa = $this->UtilsModel->defaultValue($areaHomeTotal->lessa, 0) + $hlessa;
                $ganda = $this->UtilsModel->defaultValue($areaHomeTotal->ganda, 0) + $hganda;

                if (in_array($district, $barak_valley)) { // for barak valley
                    $total_area = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
                    $in_bigha   = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area = ($bigha * 100) + ($katha * 20) + $lessa;
                    $in_bigha   = ($total_area / 100);
                }

                if ($in_bigha > KHAS_MAX_HOMESTEAD) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . KHAS_MAX_HOMESTEAD . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . KHAS_MAX_HOMESTEAD . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                if (in_array($district, json_decode(BARAK_VALLEY))) { // for barak valley
                    $applied_area     = ($hbigha * 6400) + ($hkatha * 320) + ($hlessa * 20) + $hganda;
                    $in_bigha_applied = ($applied_area / 6400);
                } else { //other than barak valley
                    $applied_area     = ($hbigha * 100) + ($hkatha * 20) + $hlessa;
                    $in_bigha_applied = ($applied_area / 100);
                }

                if ($in_bigha_applied > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                $totalHomestead = $hbigha + $hkatha + $hlessa + $hganda + $hkranti;

                if ($totalHomestead <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR375: Applied area can not be zero(0)
            for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => '#ERROR375: Applied area can not be zero(0)',
                    ];
                    echo json_encode($json);
                    return;
                }
            } else if ($nature_of_land == AGRICULTURAL) { //should not be more than 7 bigha

                //post data for agriculture
                $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
                $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
                $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
                $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
                $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);

                $areaAgriTotal = $this->db->query(" SELECT
                            SUM(agri_b) AS bigha,
                            SUM(agri_k) AS katha,
                            SUM(agri_lc) AS lessa,
                            SUM(agri_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $bigha = $this->UtilsModel->defaultValue($areaAgriTotal->bigha, 0) + $abigha;
                $katha = $this->UtilsModel->defaultValue($areaAgriTotal->katha, 0) + $akatha;
                $lessa = $this->UtilsModel->defaultValue($areaAgriTotal->lessa, 0) + $alessa;
                $ganda = $this->UtilsModel->defaultValue($areaAgriTotal->ganda, 0) + $aganda;

                if (in_array($district, $barak_valley)) { // for barak valley
                    $total_area = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
                    $in_bigha   = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area = ($bigha * 100) + ($katha * 20) + $lessa;
                    $in_bigha   = ($total_area / 100);
                }
                if ($in_bigha > KHAS_MAX_AGRICULTURE) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . KHAS_MAX_AGRICULTURE . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . KHAS_MAX_AGRICULTURE . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                if (in_array($district, $barak_valley)) { // for barak valley
                    $applied_area     = ($abigha * 6400) + ($akatha * 320) + ($alessa * 20) + $aganda;
                    $in_bigha_applied = ($applied_area / 6400);
                } else { //other than barak valley
                    $applied_area     = ($abigha * 100) + ($akatha * 20) + $alessa;
                    $in_bigha_applied = ($applied_area / 100);
                }

                if ($in_bigha_applied > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                $totalAgriculture = $abigha + $akatha + $alessa + $aganda + $akranti;

                if ($totalAgriculture <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR449: Applied area can not be zero(0)
            for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => '#ERROR449: Applied area can not be zero(0)',
                    ];
                    echo json_encode($json);
                    return;
                }
            } else if ($nature_of_land == BOTH_LAND) {
                // homestead starts here
                $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
                $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
                $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
                $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
                $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

                $areaHomeTotal = $this->db->query(" SELECT
                            SUM(home_b) AS bigha,
                            SUM(home_k) AS katha,
                            SUM(home_lc) AS lessa,
                            SUM(home_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $dbBigha = $this->UtilsModel->defaultValue($areaHomeTotal->bigha, 0) + $hbigha;
                $dbKatha = $this->UtilsModel->defaultValue($areaHomeTotal->katha, 0) + $hkatha;
                $dbLessa = $this->UtilsModel->defaultValue($areaHomeTotal->lessa, 0) + $hlessa;
                $dbGanda = $this->UtilsModel->defaultValue($areaHomeTotal->ganda, 0) + $hganda;

                if (in_array($district, $barak_valley)) { // for barak valley
                    $total_area    = ($dbBigha * 6400) + ($dbKatha * 320) + ($dbLessa * 20) + $dbGanda;
                    $in_bigha_home = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area    = ($dbBigha * 100) + ($dbKatha * 20) + $dbLessa;
                    $in_bigha_home = ($total_area / 100);
                }
                if ($in_bigha_home > KHAS_MAX_HOMESTEAD) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . KHAS_MAX_HOMESTEAD . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . KHAS_MAX_HOMESTEAD . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                if ($in_bigha_home > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                // homestead ends here

                // agriculture starts here
                $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
                $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
                $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
                $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
                $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);

                $areaAgriTotal = $this->db->query(" SELECT
                            SUM(agri_b) AS bigha,
                            SUM(agri_k) AS katha,
                            SUM(agri_lc) AS lessa,
                            SUM(agri_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $agriDbBigha = $this->UtilsModel->defaultValue($areaAgriTotal->bigha, 0) + $abigha;
                $agriDbKatha = $this->UtilsModel->defaultValue($areaAgriTotal->katha, 0) + $akatha;
                $agriDbLessa = $this->UtilsModel->defaultValue($areaAgriTotal->lessa, 0) + $alessa;
                $agriDbGanda = $this->UtilsModel->defaultValue($areaAgriTotal->ganda, 0) + $aganda;

                if (in_array($district, $barak_valley)) { // for barak valley
                    $total_area    = ($agriDbBigha * 6400) + ($agriDbKatha * 320) + ($agriDbLessa * 20) + $agriDbGanda;
                    $in_bigha_agri = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area    = ($agriDbBigha * 100) + ($agriDbKatha * 20) + $agriDbLessa;
                    $in_bigha_agri = ($total_area / 100);
                }
                if ($in_bigha_agri > KHAS_MAX_AGRICULTURE) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . KHAS_MAX_AGRICULTURE . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . KHAS_MAX_AGRICULTURE . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                if ($in_bigha_agri > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                // agriculture ends here
            } else {
                $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
                $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
                $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
                $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
                $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

                $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
                $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
                $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
                $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
                $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);
            }
        }

        //for SETTLEMENT_TRIBAL_COMMUNITY area validation 1:home, 7:agri
        if ($service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
            if ($nature_of_land == HOMESTEAD) { //should not be more than 1 bigha

                //post data for homestead
                $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
                $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
                $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
                $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
                $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

                // to check for overall area
                $areaHomeTotal = $this->db->query(" SELECT
                            SUM(home_b) AS bigha,
                            SUM(home_k) AS katha,
                            SUM(home_lc) AS lessa,
                            SUM(home_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $bigha = $this->UtilsModel->defaultValue($areaHomeTotal->bigha, 0) + $hbigha;
                $katha = $this->UtilsModel->defaultValue($areaHomeTotal->katha, 0) + $hkatha;
                $lessa = $this->UtilsModel->defaultValue($areaHomeTotal->lessa, 0) + $hlessa;
                $ganda = $this->UtilsModel->defaultValue($areaHomeTotal->ganda, 0) + $hganda;

                if (in_array($district, BARAK_VALLEY)) { // for barak valley
                    $total_area = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
                    $in_bigha   = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area = ($bigha * 100) + ($katha * 20) + $lessa;
                    $in_bigha   = ($total_area / 100);
                }

                if ($in_bigha > TRIBAL_MAX_HOMESTEAD) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . TRIBAL_MAX_HOMESTEAD . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . TRIBAL_MAX_HOMESTEAD . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                if (in_array($district, BARAK_VALLEY)) { // for barak valley
                    $applied_area     = ($hbigha * 6400) + ($hkatha * 320) + ($hlessa * 20) + $hganda;
                    $in_bigha_applied = ($applied_area / 6400);
                } else { //other than barak valley
                    $applied_area     = ($hbigha * 100) + ($hkatha * 20) + $hlessa;
                    $in_bigha_applied = ($applied_area / 100);
                }

                if ($in_bigha_applied > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                $totalHomestead = $hbigha + $hkatha + $hlessa + $hganda + $hkranti;

                if ($totalHomestead <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR375: Applied area can not be zero(0)
            for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => '#ERROR375: Applied area can not be zero(0)',
                    ];
                    echo json_encode($json);
                    return;
                }
            } else if ($nature_of_land == AGRICULTURAL) { //should not be more than 7 bigha

                //post data for agriculture
                $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
                $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
                $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
                $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
                $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);

                $areaAgriTotal = $this->db->query(" SELECT
                            SUM(agri_b) AS bigha,
                            SUM(agri_k) AS katha,
                            SUM(agri_lc) AS lessa,
                            SUM(agri_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $bigha = $this->UtilsModel->defaultValue($areaAgriTotal->bigha, 0) + $abigha;
                $katha = $this->UtilsModel->defaultValue($areaAgriTotal->katha, 0) + $akatha;
                $lessa = $this->UtilsModel->defaultValue($areaAgriTotal->lessa, 0) + $alessa;
                $ganda = $this->UtilsModel->defaultValue($areaAgriTotal->ganda, 0) + $aganda;

                if (in_array($district, BARAK_VALLEY)) { // for barak valley
                    $total_area = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
                    $in_bigha   = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area = ($bigha * 100) + ($katha * 20) + $lessa;
                    $in_bigha   = ($total_area / 100);
                }
                if ($in_bigha > TRIBAL_MAX_AGRICULTURE) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . TRIBAL_MAX_AGRICULTURE . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . TRIBAL_MAX_AGRICULTURE . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                if (in_array($district, BARAK_VALLEY)) { // for barak valley
                    $applied_area     = ($abigha * 6400) + ($akatha * 320) + ($alessa * 20) + $aganda;
                    $in_bigha_applied = ($applied_area / 6400);
                } else { //other than barak valley
                    $applied_area     = ($abigha * 100) + ($akatha * 20) + $alessa;
                    $in_bigha_applied = ($applied_area / 100);
                }

                if ($in_bigha_applied > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }

                $totalAgriculture = $abigha + $akatha + $alessa + $aganda + $akranti;

                if ($totalAgriculture <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR821: Applied area can not be zero(0)
            for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => '#ERROR821: Applied area can not be zero(0)',
                    ];
                    echo json_encode($json);
                    return;
                }
            } else if ($nature_of_land == BOTH_LAND) {
                // homestead starts here
                $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
                $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
                $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
                $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
                $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

                $areaHomeTotal = $this->db->query(" SELECT
                            SUM(home_b) AS bigha,
                            SUM(home_k) AS katha,
                            SUM(home_lc) AS lessa,
                            SUM(home_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $dbBigha = $this->UtilsModel->defaultValue($areaHomeTotal->bigha, 0) + $hbigha;
                $dbKatha = $this->UtilsModel->defaultValue($areaHomeTotal->katha, 0) + $hkatha;
                $dbLessa = $this->UtilsModel->defaultValue($areaHomeTotal->lessa, 0) + $hlessa;
                $dbGanda = $this->UtilsModel->defaultValue($areaHomeTotal->ganda, 0) + $hganda;

                if (in_array($district, BARAK_VALLEY)) { // for barak valley
                    $total_area    = ($dbBigha * 6400) + ($dbKatha * 320) + ($dbLessa * 20) + $dbGanda;
                    $in_bigha_home = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area    = ($dbBigha * 100) + ($dbKatha * 20) + $dbLessa;
                    $in_bigha_home = ($total_area / 100);
                }
                if ($in_bigha_home > TRIBAL_MAX_HOMESTEAD) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . TRIBAL_MAX_HOMESTEAD . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . TRIBAL_MAX_HOMESTEAD . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                if ($in_bigha_home > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                // homestead ends here

                // agriculture starts here
                $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
                $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
                $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
                $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
                $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);

                $areaAgriTotal = $this->db->query(" SELECT
                            SUM(agri_b) AS bigha,
                            SUM(agri_k) AS katha,
                            SUM(agri_lc) AS lessa,
                            SUM(agri_g) AS ganda
                            FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

                $agriDbBigha = $this->UtilsModel->defaultValue($areaAgriTotal->bigha, 0) + $abigha;
                $agriDbKatha = $this->UtilsModel->defaultValue($areaAgriTotal->katha, 0) + $akatha;
                $agriDbLessa = $this->UtilsModel->defaultValue($areaAgriTotal->lessa, 0) + $alessa;
                $agriDbGanda = $this->UtilsModel->defaultValue($areaAgriTotal->ganda, 0) + $aganda;

                if (in_array($district, BARAK_VALLEY)) { // for barak valley
                    $total_area    = ($agriDbBigha * 6400) + ($agriDbKatha * 320) + ($agriDbLessa * 20) + $agriDbGanda;
                    $in_bigha_agri = ($total_area / 6400);
                } else { //other than barak valley
                    $total_area    = ($agriDbBigha * 100) + ($agriDbKatha * 20) + $agriDbLessa;
                    $in_bigha_agri = ($total_area / 100);
                }
                if ($in_bigha_agri > TRIBAL_MAX_AGRICULTURE) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . TRIBAL_MAX_AGRICULTURE . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . TRIBAL_MAX_AGRICULTURE . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                if ($in_bigha_agri > $total_dag_in_bigha) {
                    $this->db->trans_rollback();
                    log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                if (($in_bigha_agri + $in_bigha_home) > TRIBAL_MAX_AGRICULTURE) {
                    $this->db->trans_rollback();
                    log_message('error', 'Maximum limit to apply for this service is ' . TRIBAL_MAX_AGRICULTURE . ' Bigha for case no ' . $case_no);
                    $json = [
                        'responseType' => 3,
                        'message'      => 'Maximum limit to apply for this service is ' . TRIBAL_MAX_AGRICULTURE . ' Bigha. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return;
                }
                // agriculture ends here
            } else {
                $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
                $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
                $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
                $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
                $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

                $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
                $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
                $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
                $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
                $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);
            }
        }

        //for settlement tea cultivation area validation 35:home+bigha
        if ($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {

            $abigha  = $this->UtilsModel->defaultValue($this->input->post('abigha'), 0);
            $akatha  = $this->UtilsModel->defaultValue($this->input->post('akatha'), 0);
            $alessa  = $this->UtilsModel->defaultValue($this->input->post('alessa'), 0);
            $aganda  = $this->UtilsModel->defaultValue($this->input->post('aganda'), 0);
            $akranti = $this->UtilsModel->defaultValue($this->input->post('akranti'), 0);

            $areaTotal = $this->db->query(" SELECT
                              SUM(agri_b) AS bigha,
                              SUM(agri_k) AS katha,
                              SUM(agri_lc) AS lessa,
                              SUM(agri_g) AS ganda
                              FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

            $bigha = $this->UtilsModel->defaultValue($areaTotal->bigha, 0) + $abigha;
            $katha = $this->UtilsModel->defaultValue($areaTotal->katha, 0) + $akatha;
            $lessa = $this->UtilsModel->defaultValue($areaTotal->lessa, 0) + $alessa;
            $ganda = $this->UtilsModel->defaultValue($areaTotal->ganda, 0) + $aganda;

            if (in_array($district, BARAK_VALLEY)) { // for barak valley
                $total_area = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
                $in_bigha   = ($total_area / 6400);
            } else { //other than barak valley
                $total_area = ($bigha * 100) + ($katha * 20) + $lessa;
                $in_bigha   = ($total_area / 100);
            }
            if ($in_bigha > CULTIVATION_MAX_APPLIED) {
                $this->db->trans_rollback();
                log_message('error', 'Maximum limit to apply for this service is ' . CULTIVATION_MAX_APPLIED . ' Bigha for case no ' . $case_no);
                $json = [
                    'responseType' => 3,
                    'message'      => 'Maximum limit to apply for this service is ' . CULTIVATION_MAX_APPLIED . ' Bigha. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return;
            }

            if (in_array($district, BARAK_VALLEY)) { // for barak valley
                $applied_area     = ($abigha * 6400) + ($akatha * 320) + ($alessa * 20) + $aganda;
                $in_bigha_applied = ($applied_area / 6400);
            } else { //other than barak valley
                $applied_area     = ($abigha * 100) + ($akatha * 20) + $alessa;
                $in_bigha_applied = ($applied_area / 100);
            }

            if ($in_bigha_applied > $total_dag_in_bigha) {
                $this->db->trans_rollback();
                log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                $json = [
                    'responseType' => 3,
                    'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return;
            }

            $totalAgriculture = $abigha + $akatha + $alessa + $aganda + $akranti;

            if ($totalAgriculture <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR685: Applied area can not be zero(0)
          for case no ' . $case_no);
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERROR685: Applied area can not be zero(0)',
                ];
                echo json_encode($json);
                return;
            }
        }

        //for settlement pgr vgr area validation 1:homestead only
        if ($service_code == SETTLEMENT_PGR_VGR_LAND_ID) {

            $hbigha  = $this->UtilsModel->defaultValue($this->input->post('hbigha'), 0);
            $hkatha  = $this->UtilsModel->defaultValue($this->input->post('hkatha'), 0);
            $hlessa  = $this->UtilsModel->defaultValue($this->input->post('hlessa'), 0);
            $hganda  = $this->UtilsModel->defaultValue($this->input->post('hganda'), 0);
            $hkranti = $this->UtilsModel->defaultValue($this->input->post('hkranti'), 0);

            $areaTotal = $this->db->query(" SELECT
                              SUM(mbigha) AS bigha,
                              SUM(mkatha) AS katha,
                              SUM(mlessa) AS lessa,
                              SUM(mganda) AS ganda
                              FROM settlement_dag_details WHERE case_no=?", [$case_no])->row();

            $bigha = $this->UtilsModel->defaultValue($areaTotal->bigha, 0) + $hbigha;
            $katha = $this->UtilsModel->defaultValue($areaTotal->katha, 0) + $hkatha;
            $lessa = $this->UtilsModel->defaultValue($areaTotal->lessa, 0) + $hlessa;
            $ganda = $this->UtilsModel->defaultValue($areaTotal->ganda, 0) + $hganda;

            if (in_array($district, BARAK_VALLEY)) { // for barak valley
                $total_area = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
                $in_bigha   = ($total_area / 6400);
            } else { //other than barak valley
                $total_area = ($bigha * 100) + ($katha * 20) + $lessa;
                $in_bigha   = ($total_area / 100);
            }
            if ($in_bigha > VGR_PGR_MAX_HOME) {
                $this->db->trans_rollback();
                log_message('error', 'Maximum limit to apply for this service is ' . VGR_PGR_MAX_HOME . ' Bigha for case no ' . $case_no);
                $json = [
                    'responseType' => 3,
                    'message'      => 'Maximum limit to apply for this service is ' . VGR_PGR_MAX_HOME . ' Bigha. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return;
            }

            if (in_array($district, BARAK_VALLEY)) { // for barak valley
                $applied_area     = ($hbigha * 6400) + ($hkatha * 320) + ($hlessa * 20) + $hganda;
                $in_bigha_applied = ($applied_area / 6400);
            } else { //other than barak valley
                $applied_area     = ($hbigha * 100) + ($hkatha * 20) + $hlessa;
                $in_bigha_applied = ($applied_area / 100);
            }

            if ($in_bigha_applied > $total_dag_in_bigha) {
                $this->db->trans_rollback();
                log_message('error', 'Applied Area should not be more than described area in dag for case no ' . $case_no);
                $json = [
                    'responseType' => 3,
                    'message'      => 'Applied Area should not be more than described area in dag. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return;
            }

            $totalHomestead = $hbigha + $hkatha + $hlessa + $hganda + $hkranti;

            if ($totalHomestead <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR671: Applied area can not be zero(0)
          for case no ' . $case_no);
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERROR671: Applied area can not be zero(0)',
                ];
                echo json_encode($json);
                return;
            }
        }

        //check if same detail already available settlement table
        if ($sameEncrocher->num_rows() > 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR0001: Already available in settlement applicant for case no ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR0001: Same occupier has already been added. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return;
        }

        //check if same dag already available in settlement dag
        if ($sameDag->num_rows() > 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR00019: Already available in settlement Dag for case no ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR00019: Same Dag has already been added. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return;
        }

        //*******pdar_cron number generation */
        $sql    = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '" . $case_no . "'";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $cron_no = (int) $result->row()->pdar_cron_no + 1;
        } else {
            $cron_no = 1;
        }

        //insert into service settlement table
        $insEncrocher = [

            'dist_code'          => $district,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $village1,
            'user_code'          => $this->session->userdata('user_code'),
            'case_no'            => $case_no,
            'petition_no'        => '000',
            'operation'          => 'E',
            'dag_no'             => $getChithaDag,
            'patta_no'           => $pattaDetail->patta_no,
            'patta_type_code'    => $pattaDetail->patta_type_code,
            'period_possession'  => $possession_period,

            'year_no'            => date('Y'),
            'date_entry'         => date('Y-m-d'),

            'pdar_name'          => $encroacher_name,
            'pdar_guardian'      => $encroacher_father_name,
            'pdar_rel_guar'      => '0',
            'pdar_cron_no'       => (int) $cron_no++,
            'pdar_id'            => -1,
            'pdar_type'          => 'EN',
            'enc_id'             => $encroacher_id,

        ];
        $insertEncrocher = $this->db->insert('settlement_applicant', $insEncrocher);

        // echo $this->db->last_query(); return;
        if ($insertEncrocher != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR0002: Insertion failed in settlement_applicant
        for case no ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR0002: Failed to add occupier detail.
          Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return;
        }

        $encroachment_area = [
            'homestead'   => [
                'bigha'  => $hbigha,
                'katha'  => $hkatha,
                'lessa'  => $hlessa,
                'ganda'  => $hganda,
                'kranti' => $hkranti,
            ],

            'agriculture' => [
                'bigha'  => $abigha,
                'katha'  => $akatha,
                'lessa'  => $alessa,
                'ganda'  => $aganda,
                'kranti' => $akranti,
            ],
        ];

        //************Total Area Calculation  ******************
        if (in_array($district, json_decode(BARAK_VALLEY))) {
            //******for Barak valley */
            $areaHomeLessa = $this->utilityclass->Total_ganda($hbigha, $hkatha, $hlessa, $hganda, $hkranti);
            $areaAgriLessa = $this->utilityclass->Total_ganda($abigha, $akatha, $alessa, $aganda, $akranti);

            $totalAreaGanda = (float) $areaHomeLessa + (float) $areaAgriLessa;

            $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
        } else {
            $areaHomeLessa = $this->utilityclass->Total_Lessa($hbigha, $hkatha, $hlessa);
            $areaAgriLessa = $this->utilityclass->Total_Lessa($abigha, $akatha, $alessa);

            $totalAreaLessa = (float) $areaHomeLessa + (float) $areaAgriLessa;

            $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
        }
        $class = $this->utilityclass->getPattaTypeNo($district, $subdiv_code, $circle, $mouza_code, $lot_no, $village1, $getChithaDag);

        $is_urban = $this->db->query("SELECT rural_urban FROM location WHERE dist_code=? AND subdiv_code=?
            AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?",
            [$district, $subdiv_code, $circle, $mouza_code,
                $lot_no, $village1]);
        $isUrban = $is_urban->row()->rural_urban;

        //////insert in dag_details
        $insDag = [

            'dist_code'           => $district,
            'subdiv_code'         => $subdiv_code,
            'cir_code'            => $circle,
            'mouza_pargona_code'  => $mouza_code,
            'lot_no'              => $lot_no,
            'vill_townprt_code'   => $village1,
            'user_code'           => $this->session->userdata('user_code'),
            'date_entry'          => date('Y-m-d'),
            'case_no'             => $case_no,
            'petition_no'         => '000',
            'year_no'             => date('Y'),
            'new_land_class_code' => $class->land_class_code,
            'dag_no'              => $getChithaDag,
            'patta_no'            => $pattaDetail->patta_no,
            'patta_type_code'     => $pattaDetail->patta_type_code,
            'is_urban'            => $isUrban == 'U' ? 'Y' : 'N',
            'land_type'           => $nature_of_land,
            'revenue'             => 0,
            'operation'           => 'E',
            // 'landmark' => json_encode($landmark),
            'encroachement_area'  => json_encode($encroachment_area),
            'dag_area_b'          => $tot_bigha,
            'dag_area_k'          => $tot_katha,
            'dag_area_lc'         => $tot_lessa,
            'dag_area_g'          => $tot_ganda,
            'dag_area_kr'         => $tot_kranti,
            'home_b'              => $hbigha,
            'home_k'              => $hkatha,
            'home_lc'             => $hlessa,
            'home_g'              => $hganda,
            'home_kr'             => $hkranti,
            'agri_b'              => $abigha,
            'agri_k'              => $akatha,
            'agri_lc'             => $alessa,
            'agri_g'              => $aganda,
            'agri_kr'             => $akranti,
            's_dag_area_b'        => $totalAreaArr[0],
            's_dag_area_k'        => $totalAreaArr[1],
            's_dag_area_lc'       => $totalAreaArr[2],
            's_dag_area_g'        => $totalAreaArr[3],
            's_dag_area_kr'       => 0,

            //   'applicant_id' => 0,
            //   'dist_code' =>  $district,
            //   'subdiv_code' => $subdiv_code,
            //   'cir_code' => $circle,
            //   'mouza_code' =>  $mouza_code,
            //   'lot_no' => $lot_no,
            //   'vill_code' => $village1,
            //   'complete_vill_code' => $complete_vill_code,
            //   'dag_no' => $getChithaDag,
            //   'patta_no' => $pattaDetail->patta_no,
            //   'patta_code' => $pattaDetail->patta_type_code,
            //   'patta_type' => $type->patta_type,
            //   'applied_bigha' => $tot_bigha,
            //   'applied_katha' => $tot_katha,
            //   'applied_lessa' => $tot_lessa,
            //   'applied_ganda' => $tot_ganda,
            //   'applied_kranti' => $tot_kranti,

            //   'name_ass' => $encroacher_name,
            //   'gurdian_name_ass' => $encroacher_father_name,

            //   'mbigha' => $hbigha,
            //   'mkatha' => $hkatha,
            //   'mlessa' => $hlessa,
            //   'mganda' => $hganda,
            //   'mkranti' => $hkranti,

            //   'agri_bigha' => $abigha,
            //   'agri_katha' => $akatha,
            //   'agri_lessa' => $alessa,
            //   'agri_ganda' => $aganda,
            //   'agri_kranti' => $akranti,

            //   'land_type' => $nature_of_land,
            //   'encroacher_id' => $encroacher_id,
            //   'possession_date' => $possession_period,

            //   'is_draft' => DRAFT_YES,
            //   'ip' => $_SERVER['SERVER_ADDR'],
            //   'created_at' => date('Y-m-d h:i:s'),
            //   'updated_at' => date('Y-m-d h:i:s'),
            //   'is_applicant' => 0,
            //   'pdar_type' => ENCROACHER,
        ];
        $insertDag = $this->db->insert('settlement_dag_details', $insDag);
        // echo $this->db->last_query(); die;

        //echo $this->db->last_query(); return;
        if ($insertDag != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR00021: Insertion failed in settleemnt dag details for case no ' . $case_no);
            $json = [
                'responseType' => 3,
                'message'      => '#ERROR00021: Failed to add dag detail.
          Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return;
        }

        //*******insertion in settlement_area_history**************
        if (in_array($district, json_decode(BARAK_VALLEY))) {
            //***********actual Encroachment area ***************
            $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($hbigha, $hkatha, $hlessa, $hganda, $hkranti);
            $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($abigha, $akatha, $alessa, $aganda, $akranti);

            //***********total Actual Encroachment area*****************
            $total_actual_encroachment_area_ganda = (float) $actual_encroachment_area_home_ganda + (float) $actual_encroachment_area_agri_ganda;
            $totalEncroachmentAreaArr             = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
            // **********************************************

            //***********Settlement area that applicant will get settlement on***********
            $total_settlement_ganda_home = $this->utilityclass->Total_ganda($hbigha, $hkatha, $hlessa, $hganda, $hkranti);
            $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($abigha, $akatha, $alessa, $aganda, $akranti);

            //*****total Settlement area *************/
            $total_settlement_ganda = (float) $total_settlement_ganda_home + (float) $total_settlement_ganda_agri;
            $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

            //*************leftout area homestead**************
            $leftOutAreaHomeGanda = (float) $actual_encroachment_area_home_ganda - (float) $total_settlement_ganda_home;
            $leftOutAreaHomeArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

            //**********Ileftout area agriculture**************
            $leftOutAreaAgriGanda = (float) $actual_encroachment_area_agri_ganda - (float) $total_settlement_ganda_agri;
            $leftOutAreaAgriArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

            //**********Total left out area***************
            $totalLeftOutAreaGanda = (float) $total_actual_encroachment_area_ganda - (float) $total_settlement_ganda;
            $totalLeftOutAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);

        } else {
            //********actual Encroachment area**********
            $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($hbigha, $hkatha, $hlessa);
            $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($abigha, $akatha, $alessa);

            //***********total Actual Encroachment area*****************
            $total_actual_encroachment_area_lessa = (float) $actual_encroachment_area_home_lessa + (float) $actual_encroachment_area_agri_lessa;
            $totalEncroachmentAreaArr             = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
            // **********************************************

            //*******Settlement area that applicant will get settlement on**********
            $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($hbigha, $hkatha, $hlessa);
            $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($abigha, $akatha, $alessa);

            //*************Total settlement area */
            $total_settlement_lessa = (float) $total_settlement_lessa_home + (float) $total_settlement_lessa_agri;
            $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

            //****************leftout area homestead**************
            $leftOutAreaHomeLessa = (float) $actual_encroachment_area_home_lessa - (float) $total_settlement_lessa_home;
            $leftOutAreaHomeArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

            //*************leftout area agriculture*****************
            $leftOutAreaAgriLessa = (float) $actual_encroachment_area_agri_lessa - (float) $total_settlement_lessa_agri;
            $leftOutAreaAgriArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

            //**********Total left out area***************
            $totalLeftOutArealessa = (float) $total_actual_encroachment_area_lessa - (float) $total_settlement_lessa;
            $totalLeftOutAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
        }

        $settlementAreaHistoryArr = [
            'application_no'                        => $application_no,
            'case_no'                               => $case_no,
            'dag_no'                                => $getChithaDag,
            // 'uuid' => $district['app']->uuid,
            'created_at'                            => date('Y-m-d'),
            'applied_area_home_bigha'               => $hbigha,
            'applied_area_home_katha'               => $hkatha,
            'applied_area_home_lessa'               => $hlessa,
            'applied_area_home_ganda'               => $hganda,
            'applied_area_home_kranti'              => $hkranti,
            'applied_area_agri_bigha'               => $abigha,
            'applied_area_agri_katha'               => $akatha,
            'applied_area_agri_lessa'               => $alessa,
            'applied_area_agri_ganda'               => $aganda,
            'applied_area_agri_kranti'              => $akranti,
            'actual_encroachment_area_home_bigha'   => $hbigha,
            'actual_encroachment_area_home_katha'   => $hkatha,
            'actual_encroachment_area_home_lessa'   => $hlessa,
            'actual_encroachment_area_home_ganda'   => $hganda,
            'actual_encroachment_area_home_kranti'  => $hkranti,
            'actual_encroachment_area_agri_bigha'   => $abigha,
            'actual_encroachment_area_agri_katha'   => $akatha,
            'actual_encroachment_area_agri_lessa'   => $alessa,
            'actual_encroachment_area_agri_ganda'   => $aganda,
            'actual_encroachment_area_agri_kranti'  => $akranti,
            'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
            'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
            'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
            'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
            'total_actual_encroachment_area_kranti' => 0,
            'settlement_area_home_bigha'            => $hbigha,
            'settlement_area_home_katha'            => $hkatha,
            'settlement_area_home_lessa'            => $hlessa,
            'settlement_area_home_ganda'            => $hganda,
            'settlement_area_home_kranti'           => $hkranti,
            'settlement_area_agri_bigha'            => $abigha,
            'settlement_area_agri_katha'            => $akatha,
            'settlement_area_agri_lessa'            => $alessa,
            'settlement_area_agri_ganda'            => $aganda,
            'settlement_area_agri_kranti'           => $akranti,
            'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
            'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
            'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
            'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
            'total_settlement_area_kranti'          => 0,
            'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
            'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
            'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
            'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
            'leftout_area_home_kranti'              => 0,
            'leftout_area_agri_bigha'               => $leftOutAreaAgriArr[0],
            'leftout_area_agri_katha'               => $leftOutAreaAgriArr[1],
            'leftout_area_agri_lessa'               => $leftOutAreaAgriArr[2],
            'leftout_area_agri_ganda'               => $leftOutAreaAgriArr[3],
            'leftout_area_agri_kranti'              => 0,
            'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
            'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
            'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
            'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
            'total_leftout_area_kranti'             => 0,
        ];

        $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);

        if ($insertSetlArea != 1) {
            $this->db->trans_rollback();
            log_message('error', '#SETLARRHIS00091: Insertion failed in settlement_area_history RTPS Case No ' . $application_no);
            $data = [
                'error' => "#SETLARRHIS00091: Registration of Settlement failed for case no : " . $application_no,
            ];
            echo json_encode($data);
            return false;
        }

        //**************end of settlement_area_history********************

        // new dag insert in basundhara API
        // $status = $this->SettlementApiModel->insertNewDag($uuid, $village1, $application_no, $getChithaDag, $pattaDetail->patta_no, $encroacher_id);
        $status = $this->SettlementApiModel->insertNewDag($application_no, $getChithaDag, $encroacher_id, $pattaDetail->patta_no, $pattaDetail->patta_type_code);
        if (trim($status) != 'y') {
            $this->db->trans_rollback();
            log_message('error', '#DAGINS00094: Unable to insert new dag, RTPS Case No ' . $application_no);
            $data = [
                'error' => "#DAGINS00094: Unable to insert new dag, for case no : " . $application_no,
            ];
            echo json_encode($data);
            return false;
            exit;
        } else {
            $this->db->trans_commit();
            $json = [
                'responseType' => 2,
                'message'      => 'New dag successfully added',
            ];
            echo json_encode($json);
            return;
        }

        // $this->db->trans_commit();
        // $json = [
        //     'responseType' => 2,
        //     'message' => 'New Dag successfully added',
        // ];
        // echo json_encode($json);
        // return;
    }

    // get village list API call for village meeting
    public function getVillageListForVillageMeetingApi()
    {
        if (VLMCC_MEETING_LIVE == 1) {
            $dist_code   = trim($this->session->userdata('dist_code'));
            $subdiv_code = trim($this->session->userdata('subdiv_code'));
            $cir_code    = trim($this->session->userdata('cir_code'));
            $mouza_code  = trim($this->session->userdata('mouza_pargona_code'));
            $lot_no      = trim($this->session->userdata('lot_no'));
            $lm_code     = trim($this->session->userdata('user_code'));
            $us_des_code = trim($this->session->userdata('user_desig_code'));

            if ($us_des_code == 'LM') {
                // get village list from basundhara end (API call)

                $token       = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getVillageNameByLot");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code'    => $cir_code,
                    'mouza_code'  => $mouza_code,
                    'lot_no'      => $lot_no,
                    'api_key'     => API_KEY,
                    'token'       => $token,
                ]));
                $output = curl_exec($curl_handle);
                if (isset(json_decode($output)->responseType)) {
                    curl_close($curl_handle);
                    if (json_decode($output)->responseType == 1) {
                        $this->session->set_flashdata('message', "Error #ERMR006678: Village not found !");
                        redirect(base_url() . "index.php/home");
                    } elseif (json_decode($output)->responseType == 2) {
                        $output              = json_decode($output);
                        $data['villageList'] = $output->data;

                        $data['_view'] = 'SettlementView/settlement_village_meeting';
                        $this->load->view('layouts/main', $data);
                    } else {
                        $this->session->set_flashdata('message', "Error #ERMR006692: There is some problem ! Please contact Administration !");
                        redirect(base_url() . "index.php/home");
                    }
                } else {
                    $this->session->set_flashdata('message', "Error #ERMR006698: There is some problem ! Please contact Administration !");
                    redirect(base_url() . "index.php/home");
                }
            } else {
                $this->session->set_flashdata('message', "Error #ERMR006703: You are not Authorized !");
                redirect(base_url() . "index.php/home");
            }
        } else {
            $this->session->set_flashdata('message', "VLMCC Meeting Template Not Available !");
            redirect(base_url() . "index.php/home");
        }

    }

    // print case list  API call for village meeting
    public function printReportCaseListForVillageMeetingApi()
    {
        $village     = trim($this->input->get('village'));
        $uuid64      = trim($this->input->get('code'));
        $uuid        = base64_decode($uuid64);
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza_code  = trim($this->session->userdata('mouza_pargona_code'));
        $lot_no      = trim($this->session->userdata('lot_no'));
        $us_des_code = trim($this->session->userdata('user_desig_code'));

        if ($us_des_code == 'LM') {
            // get village list from basundhara end (API call)

            $token       = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getCaseDetailServiceWiseByUuid");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                'dist_code'   => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code'    => $cir_code,
                'mouza_code'  => $mouza_code,
                'lot_no'      => $lot_no,
                'uuid'        => $uuid,
                'api_key'     => API_KEY,
                'token'       => $token,
            ]));
            $output = curl_exec($curl_handle);
            if (isset(json_decode($output)->responseType)) {
                curl_close($curl_handle);
                if (json_decode($output)->responseType == 1) {
                    $this->session->set_flashdata('error', "Error #ERMR006749: Village not found !");
                    redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
                } elseif (json_decode($output)->responseType == 2) {
                    $output         = json_decode($output);
                    $data['output'] = $output;

                    $data['dist_name']    = $this->UtilsModel->getDistrictNameByDistCode($dist_code);
                    $data['subDiv_name']  = $this->UtilsModel->getSubDivisionDetailsByDist($dist_code, $subdiv_code);
                    $data['circle_name']  = $this->UtilsModel->getCircleDetailsByDistDivision($dist_code, $subdiv_code, $cir_code);
                    $data['mouza_name']   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($dist_code, $subdiv_code, $cir_code, $mouza_code);
                    $data['lot_name']     = $this->UtilsModel->getLotDetailsNameByDistDivisionCircleMouza($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
                    $data['village_name'] = $village;

                    $data['_view'] = 'SettlementView/settlement_village_meeting_print';
                    $this->load->view('layouts/main', $data);
                } else {
                    $this->session->set_flashdata('error', "Error #ERMR006769: There is some problem ! Please contact Administration !");
                    redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
                }
            } else {
                $this->session->set_flashdata('error', "Error #ERMR006775: There is some problem ! Please contact Administration !");
                redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
            }
        } else {
            $this->session->set_flashdata('error', "Error #ERMR006781: You are not Authorized !");
            redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
        }
    }

    // upload report case list  API call for village meeting
    public function uploadReportCaseListForVillageMeetingApi()
    {
        $village     = trim($this->input->get('village'));
        $uuid64      = trim($this->input->get('code'));
        $uuid        = base64_decode($uuid64);
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza_code  = trim($this->session->userdata('mouza_pargona_code'));
        $lot_no      = trim($this->session->userdata('lot_no'));
        $us_des_code = trim($this->session->userdata('user_desig_code'));

        if ($us_des_code == 'LM') {
            $check = $this->db->query("SELECT count(*) as c FROM vlmc_meeting_list
                    WHERE  uuid=? AND dist_code=? AND subdiv_code=? AND cir_code=?
                    AND mouza_pargona_code=? AND lot_no=?",
                [$uuid, $dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no,
                ])->row()->c;

            $uploadedData = '';
            if ($check != 0) {
                $uploadedData = $this->db->query("SELECT * FROM vlmc_meeting_list
                    WHERE  uuid=? AND dist_code=? AND subdiv_code=? AND cir_code=?
                    AND mouza_pargona_code=? AND lot_no=?",
                    [$uuid, $dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no,
                    ])->row();
            }
            $data['check']        = $check;
            $data['uploadedData'] = $uploadedData;
            $data['uuid']         = $uuid;
            $data['dist_name']    = $this->UtilsModel->getDistrictNameByDistCode($dist_code);
            $data['subDiv_name']  = $this->UtilsModel->getSubDivisionDetailsByDist($dist_code, $subdiv_code);
            $data['circle_name']  = $this->UtilsModel->getCircleDetailsByDistDivision($dist_code, $subdiv_code, $cir_code);
            $data['mouza_name']   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($dist_code, $subdiv_code, $cir_code, $mouza_code);
            $data['lot_name']     = $this->UtilsModel->getLotDetailsNameByDistDivisionCircleMouza($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
            $data['village_name'] = $village;

            $data['_view'] = 'SettlementView/settlement_village_meeting_upload';
            $this->load->view('layouts/main', $data);

        } else {
            $this->session->set_flashdata('error', "Error #ERMR006772: You are not Authorized !");
            redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
        }
    }

    // generate VLMC Meeting Id Sequence No
    public function generateVlmcMeetingIdSequenceNo()
    {
        $meetingId = $this->db->query("select nextval('vlmc_meeting_list_id_seq') as count ")->row()->count;
        return $meetingId;
    }

    // save upload report case list  for village meeting
    public function saveReportCaseListForVillageMeeting()
    {
        $this->load->library('form_validation');

        $meeting_date    = $this->input->post('meeting_date');
        $meeting_venue   = $this->input->post('meeting_venue');
        $uuid            = $this->input->post('uuid');
        $village_code    = trim($this->session->userdata('user_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $subdiv_code     = trim($this->session->userdata('subdiv_code'));
        $cir_code        = trim($this->session->userdata('cir_code'));
        $mouza_code      = trim($this->session->userdata('mouza_pargona_code'));
        $lot_no          = trim($this->session->userdata('lot_no'));
        $lm_code         = trim($this->session->userdata('user_code'));
        $meeting_remarks = $this->input->post('meeting_remarks');

        $this->form_validation->set_rules('meeting_date', 'Meeting Date', 'trim|required');
        $this->form_validation->set_rules('meeting_venue', 'Meeting Venue', 'trim|required|max_length[190]');
        $this->form_validation->set_rules('uuid', 'UUID', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('meeting_remarks', 'Meeting Remarks', 'trim|max_length[245]');
        if ($this->form_validation->run() == false) {
            $json = [
                'response' => 1,
                'message'  => '#ERMR006872:' . validation_errors(),
            ];
            echo json_encode($json);
            return false;
        }

        // check location already exist or not
        $check = $this->db->query("SELECT count(*) as c FROM vlmc_meeting_list
                    WHERE  uuid=? AND dist_code=? AND subdiv_code=? AND cir_code=?
                    AND mouza_pargona_code=? AND lot_no=?  AND vill_townprt_code=?",
            [$uuid, $dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code,
            ])->row()->c;

        if ($check != 0) {
            $json = [
                'response' => 1,
                'message'  => '#ERMR006889: Report already uploaded !',
            ];
            echo json_encode($json);
            return false;
        }

        $generate_meeting_id = $this->generateVlmcMeetingIdSequenceNo();
        $timestamp           = date('mdYhis', time()) . uniqid();
        $dist_name           = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code);
        $distEngName         = substr($dist_name->locname_eng, 0, 3);
        $meetingName         = $distEngName . '/VLMC/' . date("Y") . '/' . $generate_meeting_id;

        if (isset($_FILES['upload_report']['name'])) {
            $config['file_name']     = 'vlmc_report_' . $timestamp;
            $config['upload_path']   = UPLOAD_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = 20000;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (! $this->upload->do_upload('upload_report')) {
                $json = [
                    'response' => 1,
                    'message'  => '#ERMR006916: There is some problem while uploading file',
                ];
                echo json_encode($json);
                return false;
            } else {
                $this->db->trans_begin();
                $data        = ['upload_data' => $this->upload->data()];
                $created_at  = date('Y-m-d h:i:s');
                $meetingSave = [
                    'id'                 => $generate_meeting_id,
                    'meeting_name'       => $meetingName,
                    'meeting_date'       => $meeting_date,
                    'meeting_venue'      => $meeting_venue,
                    'meeting_remarks'    => $meeting_remarks,
                    'meeting_status'     => 1,
                    'upload_file'        => $config['upload_path'] . $data['upload_data']['orig_name'],
                    'created_by'         => $lm_code,
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $lm_code,
                    'uuid'               => $uuid,
                    'created_at'         => $created_at,
                    'updated_at'         => $created_at,
                ];

                $insert = $this->db->insert('vlmc_meeting_list', $meetingSave);
                if ($insert != 1 || $insert != true) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR006950: Insertion failed in vlmc_meeting_list :' . $this->db->last_query());
                    $json = [
                        'response' => 1,
                        'message'  => '#ERMR006953: Meeting report not uploaded. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                $this->db->trans_commit();
                $json = [
                    'response' => 2,
                    'message'  => 'Report successfully uploaded, Under Meeting ID  ' . $meetingName,
                ];
                echo json_encode($json);
                return false;
            }
        } else {
            $json = [
                'response' => 1,
                'message'  => '#ERMR006972: Report not found !',
            ];
            echo json_encode($json);
            return false;
        }
    }

    // generate MPDF
    public function genMPDFCaseListForVillageMeetingApi()
    {

        $village     = trim($this->input->get('village'));
        $uuid64      = trim($this->input->get('code'));
        $uuid        = base64_decode($uuid64);
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mouza_code  = trim($this->session->userdata('mouza_pargona_code'));
        $lot_no      = trim($this->session->userdata('lot_no'));
        $us_des_code = trim($this->session->userdata('user_desig_code'));

        if ($us_des_code == 'LM') {
            // get village list from basundhara end (API call)

            $token       = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getCaseDetailServiceWiseByUuid");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                'dist_code'   => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code'    => $cir_code,
                'mouza_code'  => $mouza_code,
                'lot_no'      => $lot_no,
                'uuid'        => $uuid,
                'api_key'     => API_KEY,
                'token'       => $token,
            ]));
            $output = curl_exec($curl_handle);
            if (isset(json_decode($output)->responseType)) {
                curl_close($curl_handle);
                if (json_decode($output)->responseType == 1) {
                    $this->session->set_flashdata('error', "Error #ERMR006747: Village not found !");
                    redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
                } elseif (json_decode($output)->responseType == 2) {
                    $output       = json_decode($output);
                    $dist_name    = $this->UtilsModel->getDistrictNameByDistCode($dist_code)->loc_name;
                    $subDiv_name  = $this->UtilsModel->getSubDivisionDetailsByDist($dist_code, $subdiv_code)->loc_name;
                    $circle_name  = $this->UtilsModel->getCircleDetailsByDistDivision($dist_code, $subdiv_code, $cir_code)->loc_name;
                    $mouza_name   = $this->UtilsModel->getMouzaDetailsByDistDivisionCircle($dist_code, $subdiv_code, $cir_code, $mouza_code)->loc_name;
                    $lot_name     = $this->UtilsModel->getLotDetailsNameByDistDivisionCircleMouza($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no)->loc_name;
                    $village_name = $village;

                    include 'vendor\mpdf\vendor\autoload.php';
                    $mpdf = new \Mpdf\Mpdf([
                        'default_font_size' => 9,
                        'default_font'      => 'dejavusans',
                        'orientation'       => 'L',
                    ]);
                    $mpdf->SetWatermarkText('DHARITREE');
                    $mpdf->showWatermarkText  = true;
                    $mpdf->watermarkTextAlpha = 0.1;
                    $mpdf->watermark_font     = 'DejaVuSansCondensed';
                    $mpdf->autoScriptToLang   = true;
                    $mpdf->autoLangToFont     = true;
                    ini_set("pcre.backtrack_limit", "500000000");
                    ini_set('memory_limit', '4096M');

                    $html     = '';
                    $html00   = '';
                    $html01   = '';
                    $htmlHead = '';
                    $htmlTag  = '';

                    $htmlTag .= '<h3 style="text-align: center"><u>Applications for VLMCC Meeting</u></h3>';
                    $htmlHead .= '<p><b>Area Details </b></p>';
                    $table = ' <table  border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                        <tr>
                            <td style="width: 20%">District</td>
                            <td style="width: 30%; font-size: 15px"> ' . $dist_name . ' </td>

                            <td style="width: 20%">Sub Division</td>
                            <td style="width: 30%; font-size: 15px"> ' . $subDiv_name . '</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Circle</td>
                            <td style="width: 30%; font-size: 15px"> ' . $circle_name . '</td>

                            <td style="width: 20%">Mouza</td>
                            <td style="width: 30%; font-size: 15px"> ' . $mouza_name . '</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Lot</td>
                            <td style="width: 30%; font-size: 15px"> ' . $lot_name . '</td>

                            <td style="width: 20%">Village</td>
                            <td style="width: 30%; font-size: 15px"> ' . $village_name . '</td>
                        </tr>
                        </tbody>
                    </table>';

                    echo $html01 .= $htmlTag;
                    echo $html00 .= $htmlHead;
                    echo $html .= $table;
                    $mpdf->writeHTML($html01);
                    $mpdf->writeHTML($html00);
                    $mpdf->writeHTML($html);

                    $htmlHead2 = '';
                    $html2     = '';
                    $htmlHead2 .= '<p><br><br><b>Applications</b></p>';
                    $mpdf->writeHTML($htmlHead2);

                    if ($output->settlement_ap != null) {
                        $table2 = '<h4>Settlement of AP Transferred</h4>
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference No. <br> Application No.</th>
                                <th>Settlement Holder Details</th>
                                <th>Area Details</th>
                                <th>' . $this->lang->line('condition_1') . '</th>
                                <th>' . $this->lang->line('condition_2') . '</th>
                                <th>' . $this->lang->line('condition_3') . '</th>
                            </tr>
                            </thead>
                            <tbody>';
                        $i = 0;
                        foreach ($output->settlement_ap as $case) {
                            $i++;
                            $table2 .= '<tr>
                                            <td >' . $i . ' </td>
                                            <td >
                                                ' . $case->ref_no . '
                                                <br>
                                                ' . $case->application_no . '
                                            </td>
                                            <td >
                                                ' . $applicants = implode("<br>", explode(",", $case->name)) . '</td>
                                            <td >
                                                ' . $dags = implode("<br>", explode(",", $case->dag)) . '</td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                    </tr>';
                        }
                        $table2 .= '<tbody></table>';

                        $html2 .= $table2;

                        $mpdf->writeHTML($html2);
                    }

                    $html3 = '';
                    if ($output->settlement_tribal != null) {
                        $table3 = '<br>
                        <h4>Settlement Of Hereditary Land of Tribal Communities</h4>
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference No. <br> Application No.</th>
                                <th>Settlement Holder Details</th>
                                <th>Area Details</th>
                                <th>' . $this->lang->line('condition_1') . '</th>
                                <th>' . $this->lang->line('condition_2') . '</th>
                                <th>' . $this->lang->line('condition_3') . '</th>
                            </tr>
                            </thead>
                            <tbody>';
                        $i = 0;
                        foreach ($output->settlement_tribal as $case) {
                            $i++;
                            $table3 .= '<tr>
                                            <td >' . $i . ' </td>
                                            <td >
                                                ' . $case->ref_no . '
                                                <br>
                                                ' . $case->application_no . '
                                            </td>
                                            <td >
                                                ' . $applicants = implode("<br>", explode(",", $case->name)) . '</td>
                                            <td >
                                                ' . $dags = implode("<br>", explode(",", $case->dag)) . '</td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                    </tr>';
                        }
                        $table3 .= '<tbody></table>';

                        $html3 .= $table3;
                        $mpdf->writeHTML($html3);
                    }

                    $html4 = '';
                    if ($output->settlement_cultivators != null) {
                        $table4 = '<br>
                        <h4>Settlement of Special Cultivators (Tea/Coffee/Rubber)</h4>
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference No. <br> Application No.</th>
                                <th>Settlement Holder Details</th>
                                <th>Area Details</th>
                                <th>' . $this->lang->line('condition_1') . '</th>
                                <th>' . $this->lang->line('condition_2') . '</th>
                                <th>' . $this->lang->line('condition_3') . '</th>
                            </tr>
                            </thead>
                            <tbody>';
                        $i = 0;
                        foreach ($output->settlement_cultivators as $case) {
                            $i++;
                            $table4 .= '<tr>
                                            <td >' . $i . ' </td>
                                            <td >
                                                ' . $case->ref_no . '
                                                <br>
                                                ' . $case->application_no . '
                                            </td>
                                            <td >
                                                ' . $applicants = implode("<br>", explode(",", $case->name)) . '</td>
                                            <td>
                                                ' . $dags = implode("<br>", explode(",", $case->dag)) . '</td>
                                            <td>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                    </tr>';
                        }
                        $table4 .= '<tbody></table>';

                        $html4 .= $table4;
                        $mpdf->writeHTML($html4);
                    }

                    $html5 = '';
                    if ($output->settlement_khas != null) {
                        $table5 = '<br>
                        <h4>Settlement of Khas Land And Ceiling Surplus Land</h4>
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference No. <br> Application No.</th>
                                <th>Settlement Holder Details</th>
                                <th>Area Details</th>
                                <th>' . $this->lang->line('condition_1') . '</th>
                                <th>' . $this->lang->line('condition_2') . '</th>
                                <th>' . $this->lang->line('condition_3') . '</th>
                            </tr>
                            </thead>
                            <tbody>';
                        $i = 0;
                        foreach ($output->settlement_khas as $case) {
                            $i++;
                            $table5 .= '<tr>
                                            <td >' . $i . ' </td>
                                            <td >
                                                ' . $case->ref_no . '
                                                <br>
                                                ' . $case->application_no . '
                                            </td>
                                            <td >
                                                ' . $applicants = implode("<br>", explode(",", $case->name)) . '</td>
                                            <td >
                                                ' . $dags = implode("<br>", explode(",", $case->dag)) . '</td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                    </tr>';
                        }
                        $table5 .= '<tbody></table>';

                        $html5 .= $table5;
                        $mpdf->writeHTML($html5);
                    }

                    $html6 = '';
                    if ($output->settlement_pgr != null) {
                        $table6 = '<br>
                        <h4>Settlement of PGR VGR Land</h4>

                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference No. <br> Application No.</th>
                                <th>Settlement Holder Details</th>
                                <th>Area Details</th>
                                <th>' . $this->lang->line('condition_1') . '</th>
                                <th>' . $this->lang->line('condition_2') . '</th>
                                <th>' . $this->lang->line('condition_3') . '</th>
                            </tr>
                            </thead>
                            <tbody>';
                        $i = 0;
                        foreach ($output->settlement_pgr as $case) {
                            $i++;
                            $table6 .= '<tr>
                                            <td >' . $i . ' </td>
                                            <td >
                                                ' . $case->ref_no . '
                                                <br>
                                                ' . $case->application_no . '
                                            </td>
                                            <td >
                                                ' . $applicants = implode("<br>", explode(",", $case->name)) . '</td>
                                            <td >
                                                ' . $dags = implode("<br>", explode(",", $case->dag)) . '</td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                            <td >
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;Yes
                                                <br>
                                                <input style="pointer-events: none" type="radio" name="condition_1" >&nbsp;No
                                            </td>
                                    </tr>';
                        }
                        $table6 .= '<tbody></table>';

                        $html6 .= $table6;
                        $mpdf->writeHTML($html6);
                    }

                    ob_clean();
                    echo $b64Doc = chunk_split(base64_encode($mpdf->Output('test.pdf', 'I')));

                } else {
                    $this->session->set_flashdata('error', "Error #ERMR006760: There is some problem ! Please contact Administration !");
                    redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
                }
            } else {
                $this->session->set_flashdata('error', "Error #ERMR006766: There is some problem ! Please contact Administration !");
                redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
            }
        } else {
            $this->session->set_flashdata('error', "Error #ERMR006772: You are not Authorized !");
            redirect(base_url() . "index.php/SettlementCommon/getVillageListForVillageMeetingApi");
        }

    }

    public function zonalDetailsCo()
    {
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $sql         = "select
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no='00') as mouza_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code='00000') as lot_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
        v.zone_name, v.subclass_name, v.land_rate, string_agg(distinct(d.dag_no),',') as dag
        from villagewise_zone_info v join dagwise_zone_info d on v.unique_village_code=d.unique_village_code
            and v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
            where d.flag='1' and v.flag='1' and v.subdiv_code ='$subdiv_code' and v.cir_code ='$cir_code'
            group by v.subdiv_code, v.cir_code, v.mouza_pargona_code, v.lot_no, v.vill_code, v.zone_name, v.subclass_name, v.land_rate";
        $zonalDetails = $this->db->query($sql)->result();
        include 'vendor\mpdf\vendor\autoload.php';
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font'      => 'dejavusans',
            'orientation'       => 'L',
        ]);
        $mpdf->SetWatermarkText('DHARITREE');
        $mpdf->showWatermarkText  = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font     = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang   = true;
        $mpdf->autoLangToFont     = true;
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '4096M');
        set_time_limit(0);
        $html    = '';
        $htmlTag = '';
        $htmlTag .= '<h3 style="text-align: center"><u>Dag wise zonal rate</u></h3>';
        $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                    <tr>
                        <th  >Mouza </th>
                        <th >Lot </th>
                        <th >Village </th>
                        <th >Zone </th>
                        <th  >Subclass </th>
                        <th >Zonal Value(Land Rate)</th>
                        <th >Dag No(s)</th>
                    </tr>
                    </thead>
                    <tbody>';
        foreach ($zonalDetails as $details) {
            $table2 .= '<tr>
                        <td >' . $details->mouza_name . '</td>
                        <td>' . $details->lot_name . '</td>
                        <td>' . $details->village_name . '</td>
                        <td>' . $details->zone_name . '</td>
                        <td >' . $details->subclass_name . '</td>
                        <td>' . $details->land_rate . '</td>
                        <td> ' . $details->dag . '</td>
                    </tr>';
        }
        $table3 = '</tbody></table>';
        $table  = $table1 . $table2 . $table3;
        $final  = $htmlTag . $table;
        $mpdf->writeHTML($final);
        // ob_clean();
        $mpdf->Output('test.pdf', 'I');
    }

    public function landCheck()
    {

        $apilink         = API_LINK_MB2;
        $identity_type   = $this->input->post('identity_type');
        $identity_ref_no = $this->input->post('identity_ref_no');
        // $identity_ref_no = '1049917716315004928';

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink . "getBasundharaLandDetail");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'adhar_pan_dl_type' => $identity_type,
            'adhar_pan_dl_no'   => $identity_ref_no,
        ]));
        // return curl_exec($curl_handle);
        $result   = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if ($httpcode != 200) {
            return false;
        }

        $result = json_decode($result);
        // var_dump($result); die;
        // $result->responseType='y';

        if ($result->responseType == 'y') {
            $data = [
                'responseType' => 2,
                'appnData'     => $result,
                'msg'          => "Land Found...",
            ];

        } else {

            $data = [
                'responseType' => 0,
                'appnData'     => $result,
                'msg'          => "Land Not Found...",
            ];
        }

        echo json_encode($data);
    }

    //added on 19062023

    public function viewAdditionalProperty()
    {
        $caseno                           = $this->input->post('applid');
        $checkAdditionalProperty          = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($caseno);
        $availability_additional_property = $checkAdditionalProperty->num_rows();
        if ($availability_additional_property > 0) {
            $property_details = $checkAdditionalProperty->result();
            echo json_encode(['response' => 1, 'property_details' => $property_details]);
        } else {
            echo json_encode(['response' => 1, 'property_details' => null]);
        }
    }

    public function closeAdditionalProperty()
    {
        $caseno                   = $this->input->post('applid');
        $updateAdditionalProperty = [
            'enable_status' => 1,
            'entered_by'    => '',
        ];
        $this->db->where('case_no', $caseno);
        $this->db->where('enable_status', 0);
        $this->db->where('entered_by', $this->session->userdata('user_code'));
        $this->db->update('settlement_additional_property', $updateAdditionalProperty);
        echo json_encode(['response' => 1]);
    }

    public function deleteAdditionalProperty()
    {
        $id     = $this->input->post('id');
        $caseno = $this->input->post('case_no');

        $updateAdditionalProperty = [
            'entered_by'    => $this->session->userdata('user_code'),
            'enable_status' => 0,
        ];
        $this->db->where('id', $id);
        $this->db->update('settlement_additional_property', $updateAdditionalProperty);

        $additionalProperty = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($caseno);
        echo json_encode(['response' => 1, 'property_details' => $additionalProperty->result()]);
    }

    public function changesOnAdditionalProperty()
    {
        echo json_encode(['response' => 1]);
    }

    public function insertAdditionalProperty()
    {
        $validation         = null;
        $dist_code          = trim($this->input->post('additional_district'));
        $dist_name          = $this->input->post('additional_district_name');
        $cir_code           = trim($this->input->post('additional_circle'));
        $cir_name           = $this->input->post('additional_circle_name');
        $subdiv_code        = trim($this->input->post('subdiv_code'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
        $lot_no             = trim($this->input->post('lot_no'));
        $bigha              = trim($this->input->post('additional_bigha'));
        $katha              = trim($this->input->post('additional_katha'));
        $lessa              = trim($this->input->post('additional_lessa'));

        if (in_array($dist_code, json_decode(BARAK_VALLEY))) {
            $ganda  = trim($this->input->post('additional_ganda'));
            $kranti = trim($this->input->post('additional_kranti'));
        } else {
            $ganda  = 0;
            $kranti = 0;
        }

        $case_no = trim($this->input->post('ref_no'));
        $applid  = $this->utilityclass->getApplidFromCaseNo($case_no);

        $is_additional_urban = trim($this->input->post('is_additional_urban'));
        $additional_village  = trim($this->input->post('additional_village'));
        $additional_dag      = trim($this->input->post('additional_dag'));
        $additional_patta    = trim($this->input->post('additional_patta'));

        $additional_village_code = trim($this->input->post('additional_village_code'));
        $is_landless_prop        = $this->input->post('is_landless_prop');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('is_landless', 'Occupied any other land', 'required|trim|xss_clean');
        $this->form_validation->set_rules('additional_district', 'District', 'required|numeric|trim|xss_clean');
        $this->form_validation->set_rules('additional_circle', 'Circle', 'required|trim|xss_clean');

        $this->form_validation->set_rules('additional_bigha', 'Bigha', 'required|is_natural|trim|greater_than[-1]|xss_clean');

        if (in_array($dist_code, json_decode(BARAK_VALLEY))) { // for barak valley
            $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[20]');
            $this->form_validation->set_rules('additional_lessa', 'Chatak', 'required|greater_than[-1]|less_than[16]');
            $this->form_validation->set_rules('additional_ganda', 'Ganda', 'required|numeric|greater_than[-1]|less_than[20]');
            $this->form_validation->set_rules('additional_kranti', 'Kranti', 'numeric|greater_than[-1]|less_than[12]');
        } else { // other than barak valley
            $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[5]');
            $this->form_validation->set_rules('additional_lessa', 'Lessa', 'required|greater_than[-1]|less_than[20]');
        }

        if ($this->form_validation->run() == false) {
            $this->form_validation->set_error_delimiters('', '');

            if (form_error('additional_district')) {
                $validation[] = ['field' => 'additional_district', 'message' => form_error('additional_district')];
            }
            if (form_error('additional_circle')) {
                $validation[] = ['field' => 'additional_circle', 'message' => form_error('additional_circle')];
            }
            if (form_error('additional_bigha')) {
                $validation[] = ['field' => 'additional_bigha', 'message' => form_error('additional_bigha')];
            }
            if (form_error('additional_katha')) {
                $validation[] = ['field' => 'additional_katha', 'message' => form_error('additional_katha')];
            }
            if (form_error('additional_lessa')) {
                $validation[] = ['field' => 'additional_lessa', 'message' => form_error('additional_lessa')];
            }
            if (form_error('additional_ganda')) {
                $validation[] = ['field' => 'additional_ganda', 'message' => form_error('additional_ganda')];
            }
            if (form_error('additional_kranti')) {
                $validation[] = ['field' => 'additional_kranti', 'message' => form_error('additional_kranti')];
            }
        }

        if ($validation != null) {
            echo json_encode([
                'responseType' => 1,
                'validation'   => $validation,
            ]);
            return;
        } else {
            if ($additional_dag == '' || $additional_dag == null) {
                log_message('error', 'Dag not selected');
                $json = [
                    'responseType' => 3,
                    'message'      => 'Please Select Dag',
                ];
                echo json_encode($json);
                return;
            }

            if ($additional_village_code == '' || $additional_village_code == null) {
                log_message('error', 'Village not selected');
                $json = [
                    'responseType' => 3,
                    'message'      => 'Please Select Village',
                ];
                echo json_encode($json);
                return;
            }

            if ($additional_patta == '' || $additional_patta == null) {
                log_message('error', 'Patta is null');
                $json = [
                    'responseType' => 3,
                    'message'      => 'Patta can not be null',
                ];
                echo json_encode($json);
                return;
            }

            $this->dbswitchmb2($dist_code);

            //uuid from location table
            $query = $this->db->query("SELECT uuid FROM location WHERE dist_code=? AND subdiv_code=?
        AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?",
                [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                    $lot_no, $vill_townprt_code]);
            if ($query->num_rows() == 0) {
                log_message('error', 'Incorrect location selected. No uuid found' . $this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => 'Incorrect Location selected. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            $this->dbswitch($this->session->userdata('dist_code'));

            $this->db->trans_begin();

            // insertion in backup table
            $backup_array_lm = [
                'applid' => $applid,
                'status' => 'I',
                'data'   => json_encode($_POST),
            ];
            $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
            if ($backup_insertion_lm != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERR7520: Insertion failed in settlement_backup_json RTPS Case No ' . $applid);
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR7520: Something went wrong. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            //////////////// Save Applicant ///////////////
            $propertyadd = [
                'applid'             => $applid,
                'case_no'            => $case_no,
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'bigha'              => $bigha,
                'katha'              => $katha,
                'lessa'              => $lessa,
                'ganda'              => $ganda,
                'kranti'             => $kranti,
                'entry_date'         => date('Y-m-d h:i:s'),
                'is_rural'           => $is_additional_urban,
                'dag_no'             => trim($additional_dag),
                'patta_no'           => $additional_patta,
                'uuid'               => $query->row()->uuid,
                'entered_by'         => $this->session->userdata('user_code'),
                'is_landless'        => $is_landless_prop,
                'dist_name'          => trim($dist_name),
                'cir_name'           => trim($cir_name),
                'vill_name'          => trim($additional_village),
            ];

            $insProperty = $this->db->insert('settlement_additional_property', $propertyadd);

            if ($insProperty != 1 || $insProperty != true) {
                $this->db->trans_rollback();
                log_message('error', '#ERR7561: Insertion failed in settlement_additional_property' . $this->db->last_query());
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR7561: Something went wrong. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $response['status'] = 0;
                echo json_encode(['status' => 0]);
            } else {
                $property_id = $this->db->insert_id();
                $row         = $this->db->select('*')->from('settlement_additional_property')->where('id', (int) $property_id)->get()->row_array();
                $this->db->trans_commit();
                echo json_encode(['status' => 200, 'result' => $row]);
                return;
            }
        }
    }

    public function deleteAllAdditionalProperty()
    {
        $case_no = trim($this->input->post('case_no'));
        $del     = $this->db->query("DELETE FROM settlement_additional_property WHERE case_no=?",
            [$case_no]);
        echo json_encode(['status' => 0]);
        return;
    }

    public function saveAdditionalPropertyDetail()
    {
        $caseno = $this->input->post('case_no');

        //delete from table which are removed by the user_desig_code
        $deleteProperty = $this->db->query("DELETE FROM settlement_additional_property WHERE
                                enable_status=? and case_no=?", [0, $caseno]);
        echo json_encode(['response' => 1]);
    }

    public function findLand()
    {
        $dist_code       = trim($this->input->post('dist_code'));
        $identity_ref_no = trim($this->input->post('identity_ref_no'));

        if (strlen($dist_code) == 1) {
            $dist_code = sprintf("%02d", $dist_code);
        }

        $result = $this->SettlementCommonModel->fetchPattadarAadharData($dist_code, $identity_ref_no);
        // $result = $this->SettlementCommonModel->fetchPattadarAadharData($dist_code, '54138deafaac552f68e4ffd789759bb3');
        // var_dump($result); die;

        if ($result == null) {
            $data = [
                'responseType' => 0,
                'appnData'     => $result,
                'msg'          => "Land Not Found...",
            ];

        } else {

            $data = [
                'responseType' => 2,
                'appnData'     => $result,
                'msg'          => "Land Found...",
            ];
        }

        echo json_encode($data);

    }

    // pending case details in dashboard for ADC
    public function pendingCaseDetailsDashboardADC()
    {

        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('serviceCode', 'Service Code', 'trim|required');
        $this->form_validation->set_rules('subDivCode', 'Sub Division Code', 'trim|required');
        $this->form_validation->set_rules('cirCode', 'Circle Code', 'trim|required');
        $this->form_validation->set_rules('userType', 'User Type', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'responseType' => 1,
            ]);
            return;
        } else {
            $dist_code   = $this->session->userdata('dist_code');
            $userDCode   = $this->session->userdata('user_desig_code');
            $serviceCode = $this->input->post('serviceCode');
            $subDivCode  = $this->input->post('subDivCode');
            $cirCode     = $this->input->post('cirCode');
            $user_code   = $this->input->post('userType');

            if ($userDCode == MB_ADD_DEPUTY_COMM or $userDCode == MB_SUB_DIV_COMM or $userDCode == MB_DEPUTY_COMM) {
                $distName   = $this->utilityclass->getDistrictName($dist_code);
                $subDivName = $this->utilityclass->getSubDivName($dist_code, $subDivCode);
                $circleName = $this->utilityclass->getCircleName($dist_code, $subDivCode, $cirCode);

                $pendingCaseCount        = 0;
                $rejectedCaseCount       = 0;
                $markedForSDLACCaseCount = 0;
                $casesInProposalCount    = 0;

                if ($serviceCode == 'all') {
                    $serviceName = 'All Service';

                    $pendingCaseCount = $this->db->select()
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_PENDING)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    $rejectedCaseCount = $this->db->select()
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_DISMISS)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    $markedForSDLACCaseCount = $this->db->select()
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_MARK_AS_SDLAC)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    $casesInProposalCount = $this->db->select()
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_SEND_TO_SDLAC)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();
                } else {
                    $pendingCaseCount = $this->db->select()
                        ->where('service_code', $serviceCode)
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_PENDING)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    $rejectedCaseCount = $this->db->select()
                        ->where('service_code', $serviceCode)
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_DISMISS)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    $markedForSDLACCaseCount = $this->db->select()
                        ->where('service_code', $serviceCode)
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_MARK_AS_SDLAC)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    $casesInProposalCount = $this->db->select()
                        ->where('service_code', $serviceCode)
                        ->where('pending_officer', $user_code)
                        ->where('status', MB_SEND_TO_SDLAC)
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subDivCode)
                        ->where('cir_code', $cirCode)
                        ->get('settlement_basic')
                        ->num_rows();

                    if ($serviceCode == SETTLEMENT_TENANT_ID) {
                        $serviceName = 'Settlement Occupancy Tenant';
                    } elseif ($serviceCode == SETTLEMENT_AP_TRANSFER_ID) {
                        $serviceName = 'Settlement AP';
                    } elseif ($serviceCode == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
                        $serviceName = 'Settlement Tribal Community';
                    } elseif ($serviceCode == SETTLEMENT_KHAS_LAND_ID) {
                        $serviceName = 'Settlement Khasland';
                    } elseif ($serviceCode == SETTLEMENT_PGR_VGR_LAND_ID) {
                        $serviceName = 'Settlement PGR/VGR land';
                    } elseif ($serviceCode == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
                        $serviceName = 'Settlement Special Cultivators';
                    }
                }

                echo json_encode([
                    'responseType'            => 2,
                    'userType'                => $user_code,
                    'distName'                => $distName,
                    'subDivName'              => $subDivName,
                    'circleName'              => $circleName,
                    'serviceName'             => $serviceName,
                    'pendingCaseCount'        => $pendingCaseCount,
                    'rejectedCaseCount'       => $rejectedCaseCount,
                    'markedForSDLACCaseCount' => $markedForSDLACCaseCount,
                    'casesInProposalCount'    => $casesInProposalCount,
                ]);

            } else {
                echo json_encode([
                    'responseType' => 2,
                ]);
            }

        }

    }

    public function getAdditionalInputIfAny()
    {
        $reject_code = $this->input->post('reject_code');
        // $reject_key = $this->input->post('reject_key');
        $dag_no_remark = $this->input->post('dag_no_remark');

        $sql = $this->db->query("SELECT chitha_flag, sub_input_type, sub_input_json FROM reject_master WHERE reject_code = ?", [$reject_code]);

        if ($sql->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR3434322: No data found! Contact admin...',

            ]);
        }

        $sub_input_type = $sql->row()->sub_input_type;
        $chitha_flag    = $sql->row()->chitha_flag;

        // 1 -> input box
        // 2 -> Radio input
        // 3 -> Select option
        $inputCon = '';

        if ($chitha_flag != 0) {
            //============================================
            //this is for dagwise appearance

            if ($sub_input_type == 1) {
                $inputCon = '<br>
                <span class="ml-5">
                    <textarea name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..."></textarea>
                <span>';
            }

            if ($sub_input_type == 2) {
                $inputCon = '<br>
                <span class="ml-5">
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" value="YES" checked />
                    <label>Yes</label>
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" value="NO" />
                    <label>No</label>
                </span>';
            }

            if ($sub_input_type == 3) {

                $sub_input_option = $sql->row()->sub_input_json;

                if (isset($sub_input_option)) {
                    if ($sub_input_option) {
                        $sub_input_option_decoded = json_decode($sub_input_option);
                    } else {
                        $sub_input_option_decoded = [];
                    }
                } else {
                    $sub_input_option_decoded = [];
                }

                $options = '';
                foreach ($sub_input_option_decoded as $option) {
                    $options .= '<option value="' . $option->NAME . '">' . $option->NAME . '</option>';
                }

                $inputCon = '<br><span class="ml-5">
                    <select name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" class="col-6 p-1">
                        <option value="">Select...</option>
                        ' . $options . '
                    </select>
                </span>';
            }
        } else {
            //============================================
            //this is for non dagwise appearance

            if ($sub_input_type == 1) {
                $inputCon = '<br>
                <span class="ml-5">
                    <textarea name="sub_rejected_reasons[' . $reject_code . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..."></textarea>
                <span>';
            }

            if ($sub_input_type == 2) {
                $inputCon = '<br>
                <span class="ml-5">
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="YES" checked />
                    <label>Yes</label>
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="NO" />
                    <label>No</label>
                </span>';
            }

            if ($sub_input_type == 3) {

                $sub_input_option = $sql->row()->sub_input_json;

                if (isset($sub_input_option)) {
                    if ($sub_input_option) {
                        $sub_input_option_decoded = json_decode($sub_input_option);
                    } else {
                        $sub_input_option_decoded = [];
                    }
                } else {
                    $sub_input_option_decoded = [];
                }

                $options = '';
                foreach ($sub_input_option_decoded as $option) {
                    $options .= '<option value="' . $option->NAME . '">' . $option->NAME . '</option>';
                }

                $inputCon = '<br><span class="ml-5">
                    <select name="sub_rejected_reasons[' . $reject_code . ']" class="col-6 p-1">
                        <option value="">Select...</option>
                        ' . $options . '
                    </select>
                </span>';
            }
        }

        echo json_encode([
            'responseType' => 2,
            'inputContent' => $inputCon,
            'chithaFlag'   => $chitha_flag,
        ]);
    }

    public function getAdditionalInputIfAnyCODC()
    {
        $reject_code = $this->input->post('reject_code');
        $case_no     = $this->input->post('case_no');

        $dag_no      = $this->input->post('dag_no');
        $chitha_flag = 0;
        $inputCon    = '';

        $lmSql = $this->db->query("SELECT lm_rejected_remarks FROM settlement_ap_lmnote WHERE case_no = ?", [$case_no]);

        if ($lmSql->num_rows() > 0) {
            // echo json_encode([
            //     'responseType' => 0,
            //     'msg' => '#ERR3434362: No data found! Contact admin...',

            // ]);
            // return false;

            $lmRejectedRemarks = json_decode($lmSql->row()->lm_rejected_remarks);

            $sub_rejected_remark = '';

            if ($lmRejectedRemarks) {
                foreach ($lmRejectedRemarks as $lm_rej) {
                    if (isset($lm_rej->reject_code)) {
                        if ($lm_rej->reject_code == $reject_code) {
                            $service_code        = $lm_rej->service_code;
                            $sub_rejected_remark = $lm_rej->sub_rejected_remark;
                        }
                    } else {
                        if ($lm_rej == $reject_code) {
                            $service_code        = '';
                            $sub_rejected_remark = '';
                        }
                    }
                }
            }

            $sql = $this->db->query("SELECT chitha_flag, sub_input_type, sub_input_json FROM reject_master WHERE reject_code = ?", [$reject_code]);

            if ($sql->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERR3434322: No data found! Contact admin...',

                ]);
                return false;
            }

            $sub_input_type = $sql->row()->sub_input_type;

            $chitha_flag = $sql->row()->chitha_flag;

            if ($chitha_flag != 0) {
                // 1 -> input box
                // 2 -> Radio input
                // 3 -> Select option

                if ($sub_input_type == 1) {
                    $inputCon = '<span class="ml-5">
                        <textarea name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..." required>' . $sub_rejected_remark . '</textarea>
                    <span>';
                }

                if ($sub_input_type == 2) {
                    if ($sub_rejected_remark) {
                        $inputCon = '<span class="ml-5">
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no . ']" value="YES" ' . (trim($sub_rejected_remark) == 'YES' ? 'checked' : '') . '   required/>
                            <label>Yes</label>
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no . ']" value="NO" ' . (trim($sub_rejected_remark) == 'NO' ? 'checked' : '') . ' />
                            <label>No</label>
                        </span>';

                    } else {
                        $inputCon = '<span class="ml-5">
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no . ']" value="YES" checked/>
                            <label>Yes</label>
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no . ']" value="NO" />
                            <label>No</label>
                        </span>';
                    }

                }

                if ($sub_input_type == 3) {

                    $sub_input_option = $sql->row()->sub_input_json;

                    if (isset($sub_input_option)) {
                        if ($sub_input_option) {
                            $sub_input_option_decoded = json_decode($sub_input_option);
                        } else {
                            $sub_input_option_decoded = [];
                        }
                    } else {
                        $sub_input_option_decoded = [];
                    }

                    $options = '';
                    foreach ($sub_input_option_decoded as $option) {
                        $options .= '<option value="' . $option->NAME . '" ' . (trim($sub_rejected_remark) == $option->NAME ? 'selected' : '') . '>' . $option->NAME . '</option>';
                    }

                    $inputCon = '<span class="ml-5">
                        <select name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no . ']" class="col-6 p-1" required>
                            <option value="" disabled >Select...</option>
                            ' . $options . '
                        </select>
                    </span>';
                }
            } else {
                // 1 -> input box
                // 2 -> Radio input
                // 3 -> Select option

                if ($sub_input_type == 1) {
                    $inputCon = '<span class="ml-5">
                        <textarea name="sub_rejected_reasons[' . $reject_code . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..." required>' . $sub_rejected_remark . '</textarea>
                    <span>';
                }

                if ($sub_input_type == 2) {
                    if ($sub_rejected_remark) {
                        $inputCon = '<span class="ml-5">
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="YES" ' . (trim($sub_rejected_remark) == 'YES' ? 'checked' : '') . '   required/>
                            <label>Yes</label>
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="NO" ' . (trim($sub_rejected_remark) == 'NO' ? 'checked' : '') . ' />
                            <label>No</label>
                        </span>';

                    } else {
                        $inputCon = '<span class="ml-5">
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="YES" checked/>
                            <label>Yes</label>
                            <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="NO" />
                            <label>No</label>
                        </span>';
                    }

                }

                if ($sub_input_type == 3) {

                    $sub_input_option = $sql->row()->sub_input_json;

                    if (isset($sub_input_option)) {
                        if ($sub_input_option) {
                            $sub_input_option_decoded = json_decode($sub_input_option);
                        } else {
                            $sub_input_option_decoded = [];
                        }
                    } else {
                        $sub_input_option_decoded = [];
                    }

                    $options = '';
                    foreach ($sub_input_option_decoded as $option) {
                        $options .= '<option value="' . $option->NAME . '" ' . (trim($sub_rejected_remark) == $option->NAME ? 'selected' : '') . '>' . $option->NAME . '</option>';
                    }

                    $inputCon = '<span class="ml-5">
                        <select name="sub_rejected_reasons[' . $reject_code . ']" class="col-6 p-1" required>
                            <option value="" disabled >Select...</option>
                            ' . $options . '
                        </select>
                    </span>';
                }
            }
        } else {
            $sql = $this->db->query("SELECT chitha_flag, sub_input_type, sub_input_json FROM reject_master WHERE reject_code = ?", [$reject_code]);

            if ($sql->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERR3434322: No data found! Contact admin...',

                ]);
                return false;
            }

            $sub_input_type = $sql->row()->sub_input_type;

            $chitha_flag = $sql->row()->chitha_flag;
            if ($sub_input_type == 1) {
                $inputCon = '<span class="ml-5">
                        <textarea name="sub_rejected_reasons[' . $reject_code . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..." required></textarea>
                    <span>';
            }

            if ($sub_input_type == 2) {

                $inputCon = '<span class="ml-5">
                        <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="YES" checked/>
                        <label>Yes</label>
                        <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="NO" />
                        <label>No</label>
                    </span>';

            }

            if ($sub_input_type == 3) {

                $sub_input_option = $sql->row()->sub_input_json;

                if (isset($sub_input_option)) {
                    if ($sub_input_option) {
                        $sub_input_option_decoded = json_decode($sub_input_option);
                    } else {
                        $sub_input_option_decoded = [];
                    }
                } else {
                    $sub_input_option_decoded = [];
                }

                $options = '';
                foreach ($sub_input_option_decoded as $option) {
                    $options .= '<option value="' . $option->NAME . '">' . $option->NAME . '</option>';
                }

                $inputCon = '<span class="ml-5">
                        <select name="sub_rejected_reasons[' . $reject_code . ']" class="col-6 p-1" required>
                            <option value="" disabled >Select...</option>
                            ' . $options . '
                        </select>
                    </span>';
            }
        }

        echo json_encode([
            'responseType' => 2,
            'inputContent' => $inputCon,
            'chithaFlag'   => $chitha_flag,
        ]);
    }

    public function getLmReport()
    {
        $case_no  = $this->input->post('case_no');
        $sql      = $this->db->query("SELECT * FROM settlement_ap_lmnote WHERE case_no = ?", [$case_no]);
        $sqldag   = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);
        $sqlbasic = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", [$case_no]);

        if ($sql->num_rows() > 0) {
            $data = [
                'responseType' => 2,
                // 'villageName' => $this->utilityclass->getEnglishVillageName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code, $sql->row()->lot_no, $sql->row()->vill_townprt_code),
                // 'mouzaName' => $this->utilityclass->getEnglishMouzaName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code),
                // 'circleName' => $this->utilityclass->getEnglishCircleName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code),
                'dags'         => $sqldag->result(),
                'lmnotes'      => $sql->row(),
                'basic'        => $sqlbasic->row(),
            ];
            echo json_encode($data);
        } else {
            $data = [
                'responseType' => 0,
                'msg'          => "#LMRPT009897: Case not found against case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }
    }

    public function getSelfDocApi()
    {

        $case_no = $this->input->post('case_no');

        $sql         = "Select basundhara from basundhar_application where dharitree='$case_no' ";
        $basundhara  = $this->db->query($sql)->row();
        $token       = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'application_no' => $basundhara->basundhara,
            'api_key'        => API_KEY,
            'token'          => $token,
        ]));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType == 3) {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $output             = json_decode($output);
        $lmdata['document'] = $output->documents;
        $lmdata['query']    = $output->query;
        $lmdata['property'] = $output->property;
        $lmdata['aadhar']   = $output->aadhar;
        $lmdata['nextKin']  = $output->nextKin;
        // $selfDeclarationDetails=[];
        foreach ($output->selfDeclaration as $selfDec) {
            // $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            $selfDeclarationDetails = json_decode($selfDec->dec_details);
        }
        if ($output) {
            $data = [
                'responseType'           => 2,
                'selfDeclarationDetails' => $selfDeclarationDetails,
                'document'               => $output->documents,
                'aadhar'                 => $output->aadhar,
            ];
            echo json_encode($data);
        } else {
            $data = [
                'responseType' => 0,
                'msg'          => "#LMRPT006887: Case not found against case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }
    }

    public function getLotsFromMouza()
    {
        $dist_code          = $this->input->post('dist_code');
        $subdiv_code        = $this->input->post('subdiv_code');
        $cir_code           = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');

        $user_desig = $this->session->userdata('user_desig_code');

        if (! empty($mouza_pargona_code)) {
            $this->db->select('loc_name, lot_no, vill_townprt_code');
            $this->db->from('location');
            $this->db->where('dist_code', $dist_code);

            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);

            if (! empty($lot_no)) {
                $this->db->where('lot_no =', $lot_no);
                $this->db->where('vill_townprt_code !=', '00000');

            } else {
                $this->db->where('lot_no !=', '00');
                $this->db->where('vill_townprt_code', '00000');
            }

            $query = $this->db->get();
            // echo $this->db->last_query();

            $result = $query->result();

            if (! empty($lot_no)) {
                echo json_encode([
                    'responseType'    => 2,
                    'lot_details'     => '',
                    'village_details' => $result,

                ]);
            } else {
                echo json_encode([
                    'responseType'    => 2,
                    'lot_details'     => $result,
                    'village_details' => '',

                ]);
            }

        } else {
            echo json_encode([
                'responseType'    => 2,
                'lot_details'     => '',
                'village_details' => '',
            ]);
        }

    }

    public function getLotsFromMouzaCo()
    {
        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');

        if (! empty($mouza_pargona_code)) {
            $this->db->select('loc_name, lot_no, vill_townprt_code');
            $this->db->from('location');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);

            if (! empty($lot_no)) {
                $this->db->where('lot_no =', $lot_no);
                $this->db->where('vill_townprt_code !=', '00000');

            } else {
                $this->db->where('lot_no !=', '00');
                $this->db->where('vill_townprt_code', '00000');
            }

            $query  = $this->db->get();
            $result = $query->result();

            if (! empty($lot_no)) {
                echo json_encode([
                    'responseType'    => 2,
                    'lot_details'     => '',
                    'village_details' => $result,

                ]);
            } else {
                echo json_encode([
                    'responseType'    => 2,
                    'lot_details'     => $result,
                    'village_details' => '',

                ]);
            }

        } else {
            echo json_encode([
                'responseType'    => 2,
                'lot_details'     => '',
                'village_details' => '',
            ]);
        }

    }

    public function updateNoticeDetails()
    {
        //****getting the data  */
        $case_no = $this->input->post('notice_case_no');

        $this->db->trans_begin();

        $noticeUpdateArr = [

            'ast_code'              => $this->session->userdata('user_code'),
            'ast_notice_print_date' => date('Y-m-d'),
            'ast_notice_print_yn'   => 'Y',
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $noticeUpdateArr);

        // echo $this->db->last_query();
        //*******check if data updated */
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#UPDTNOT0002: Update fail in settlement_basic ' . $case_no);
            $data = [
                'responseType' => 0,
                'msg'          => "#UPDTNOT0002: Update fail in settlement_basic : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $this->db->trans_commit();

        //**** if data intserted successfully*/
        $data = [
            'responseType' => 2,
            'msg'          => "Notice printed successfully...",
        ];
        echo json_encode($data);
    }

    public function caseListUnderMappingLot()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $user_code   = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql       = "Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data      = $this->db->query($sql, [$dist_code, $subdiv_code, $cir_code]);
        $lot_array = [];
        if ($data->num_rows() > 1) {
            $sql1  = "Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1 = $this->db->query($sql1, [$dist_code, $subdiv_code, $cir_code, $user_code]);

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code . '_' . $value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if (! empty($lot_array) && $lot_array != null) {
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error", "MB: LOT STRING====FOR CIRCLE==D" . $dist_code . "S" . $subdiv_code . "C" . $cir_code . "==" . json_encode($lot_string));
        return $lot_string;
    }

    public function convertLiteral($array)
    {
        $index     = 0;
        $final_str = '';
        foreach ($array as $a) {
            if ($index == 0) {
                $final_str = "'" . $a . "'";
            } else {
                $final_str = $final_str . ",'" . $a . "'";
            }

            $index++;
        }
        return $final_str;
    }

    public function paginationForReGeoTag()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code      = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat  = $this->input->post('remark_cat');
        $reverted    = $this->input->post('reverted');
        $user_code   = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
            // 1   => 'applid',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }

        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,a.re_geotag_status,a.status');

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        $this->db->from('settlement_basic a');
        $this->db->join('supportive_document b', 'a.case_no = b.case_no');
        $query = $this->db->get();

        log_message('error', "Query for Sel=======" . $this->db->last_query());
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $tenant_link = '<a type="button" href="#" onclick="reGeotag(\'' . $rows->case_no . '\',\'' . $rows->applid . '\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                $tribal_link = '<a type="button" href="#" onclick="reGeotag(\'' . $rows->case_no . '\',\'' . $rows->applid . '\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                $ap_link = '<a type="button" href="#" onclick="reGeotag(\'' . $rows->case_no . '\',\'' . $rows->applid . '\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                $khas_link = '<a type="button" href="#" onclick="reGeotag(\'' . $rows->case_no . '\',\'' . $rows->applid . '\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                $vgr_link = '<a type="button" href="#" onclick="reGeotag(\'' . $rows->case_no . '\',\'' . $rows->applid . '\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                $tea_link = '<a type="button" href="#" onclick="reGeotag(\'' . $rows->case_no . '\',\'' . $rows->applid . '\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                if (trim($rows->re_geotag_status) == 1) {
                    $re_geotag_status = 'Requested For Re-Geotag';
                    $tenant_link      = '--';
                    $tribal_link      = '--';
                    $ap_link          = '--';
                    $khas_link        = '--';
                    $vgr_link         = '--';
                    $tea_link         = '--';

                } elseif (trim($rows->re_geotag_status) == 2) {
                    $re_geotag_status = 'Re-Geotag Done';
                } else {
                    $re_geotag_status = 'N/A';
                }
                $status = '<b class="text-warning">On Process</b>';
                if (trim($rows->status) == 'D') {
                    $status = '<b class="text-danger">Rejected</b>';
                }

                $json[] = [
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $status,
                    $re_geotag_status,

                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                ];
            }

            $this->db->where('a.service_code', $s_code);

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            // $this->db->distinct();
            $this->db->select('a.case_no');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->join('supportive_document b', 'a.case_no = b.case_no');
            $this->db->group_by('a.case_no');

            // $query1 = $query->num_rows();
            $this->db->from('settlement_basic a');
            $query = $this->db->get();
            log_message("error", "Count Query==========" . $this->db->last_query());
            $total_records = $query->num_rows();
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function revertCase()
    {
        $case_no = $this->input->post('case_no');

        $pending_officer = $this->input->post('pending_officer');
        $pending_office  = $this->input->post('pending_office');
        $from_office     = $this->session->userdata('user_desig_code');
        $status          = $this->input->post('status');
        $remark_type     = $this->input->post('remark_type');
        $remark          = $this->input->post('remark');
        $task            = $this->input->post('task');

        //****update into settlement_basic */
        $this->db->trans_begin();

        $updateBasicArr = [
            'status'          => $status,
            'user_code'       => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d h:i:s'),
            'from_office'     => $from_office,
            'pending_officer' => $pending_officer,
            'pending_office'  => $pending_office,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateBasicArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR9603: Unable to revert! Something went wrong...',
            ]);
            return false;
        }

        //******insert into settlement_basic */
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_type'            => $remark_type,
            'note_on_order'        => $remark,
            'status'               => 'W',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $from_office,
            'office_to'            => $pending_officer,
            'task'                 => $task,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();

            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR9642: Unable to revert! Something went wrong...',
            ]);
            return false;
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Successfully reverted to ' . $pending_officer,
        ]);
    }

    public function caseRevivalList()
    {
        $case_no      = $this->input->post('case_no');
        $service_code = $this->input->post('service_code');

        //*****getting the revival list */
        $revial_list = json_decode(REVIVAL_REASONS);

        echo json_encode([
            'responseType' => 2,
            'case_no'      => $case_no,
            'service_code' => $service_code,
            'list'         => $revial_list,
        ]);
    }

    public function caseRevival()
    {
        $reason_code  = $this->input->post('reason_code');
        $case_no      = $this->input->post('case_no');
        $service_code = $this->input->post('service_code');

        if (empty($case_no)) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR9778: Something went wrong ! Contact admin...',
            ]);
            return false;
        }
        if (empty($reason_code)) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR9786: Something went wrong ! Contact admin...',
            ]);
            return false;
        }
        if (empty($service_code)) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR9794: Something went wrong ! Contact admin...',
            ]);
            return false;
        }

        $revivalRemarkText = $this->input->post('revivalRemarkText');

        $this->db->trans_begin();

        $sqlCheck = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', [$case_no, 1]);

        if ($sqlCheck->num_rows() > 0) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR9777: This case is already flagged for revival!',
            ]);
            return false;
        }

        $sqlCheck = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', [$case_no, 2]);

        if ($sqlCheck->num_rows() > 0) {
            $updateArr = [
                // 'case_no' => $case_no,
                // 'service_code' => $service_code,
                'revival_status'      => '1',
                'revival_reason_code' => $reason_code,
                'user_code'           => $this->session->userdata('user_code'),
                'req_by'              => $this->session->userdata('user_desig_code'),
                'date_entry'          => date('Y-m-d H:i:s'),
                'remark_text'         => $revivalRemarkText,
            ];

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_revival_flag', $updateArr);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERR9549: Unable to flag this case for revival! Contact admin...',
                ]);
                return false;
            }
        } else {
            $insertArr = [
                'case_no'             => $case_no,
                'service_code'        => $service_code,
                'revival_status'      => '1',
                'revival_reason_code' => $reason_code,
                'user_code'           => $this->session->userdata('user_code'),
                'req_by'              => $this->session->userdata('user_desig_code'),
                'date_entry'          => date('Y-m-d H:i:s'),
                'remark_text'         => $revivalRemarkText,
            ];

            $insert = $this->db->insert('settlement_revival_flag', $insertArr);

            if ($insert != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERR9797: Unable to flag this case for revival! Contact admin...',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Case successfully flagged for revival...',
        ]);

    }

    public function revivalPagination()
    {
        $s_code      = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        // $remark_cat = $this->input->post('remark_cat');
        $reverted  = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');

        $dist_code          = $this->input->post('dist_code');
        $subdiv_code        = $this->input->post('subdiv_code');
        $cir_code           = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');

        $lot_no = $this->input->post('lot_no');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];


        $r_head_filter = $this->input->post('r_head_filter');

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        $this->db->where('a.service_code', $s_code);
        $this->db->where_in('a.from_office', [$this->session->userdata('user_desig_code')]);
        $this->db->select('distinct(a.case_no)');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));

        if ($this->session->userdata('user_desig_code') == 'CO') {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        }
        if ($this->session->userdata('user_desig_code') == 'SDO') {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        }

        $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no');
        $this->db->where('b.req_by', $this->session->userdata('user_desig_code'));
        $this->db->where('b.revival_status = \'1\'');
        $this->db->from('settlement_basic a');
        $this->db->get();
        //***First query */
        $activeQuery1 = $this->db->last_query();

        $this->db->select('distinct(a.case_no)');
        $this->db->from('settlement_basic a');
        $this->db->join('rejected_remark c', 'a.case_no = c.case_no');
        $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no', 'left');
        $this->db->where('a.service_code', $s_code);
        $this->db->where_in('a.from_office', [$this->session->userdata('user_desig_code')]);
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));

        if (! empty($r_head_filter) && $r_head_filter != '10') {
            $this->db->where('c.reject_code', $r_head_filter);
        }

        if ($this->session->userdata('user_desig_code') == 'CO') {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        }
        if ($this->session->userdata('user_desig_code') == 'SDO') {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        }

        $this->db->where_in('c.reject_code', REVIVAL_REJECT_CODE);
        // Execute the main query
        $this->db->get();
        //****second query */
        $activeQuery2 = $this->db->last_query();

        $this->db->distinct()->select('a.case_no, r.revival_reason_code, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry', false);
        $this->db->from('settlement_basic a');
        $this->db->where('a.status', 'D');
        if ($this->session->userdata('user_desig_code') == 'CO') {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        }
        if ($this->session->userdata('user_desig_code') == 'SDO') {
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        }

        $this->db->join('settlement_revival_flag r', 'a.case_no = r.case_no', 'left');

        if (! empty($r_head_filter) && $r_head_filter == '10') {
            $this->db->where("a.case_no IN ($activeQuery1)", null, false);
        } elseif (! empty($r_head_filter) && $r_head_filter != '10') {
            $this->db->where("a.case_no IN ($activeQuery2)", null, false);
        } else {
            $this->db->where("a.case_no IN ($activeQuery1 UNION $activeQuery2)", null, false);
        }

        $this->db->limit($length, $start);

        //***conditions */
        if (! empty($dist_code)) {
            $this->db->where('a.dist_code', $dist_code);
        }
        if (! empty($subdiv_code)) {
            $this->db->where('a.subdiv_code', $subdiv_code);
        }
        if (! empty($cir_code)) {
            $this->db->where('a.cir_code', $cir_code);
        }
        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }
        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }
        $valid_columns = [
            0 => 'date_entry',
        ];
        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }
        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }
        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        // Execute the main query
        $query = $this->db->get();

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $getRejectRemark = $this->db->query("select string_agg(distinct(b.remark),', ') as remark from rejected_remark a join reject_master b on a.reject_code::varchar = b.reject_code::varchar where case_no = ?", [$rows->case_no])->row()->remark;

                $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';
                $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';
                $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';
                $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a> ';
                $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';
                $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                view</a>';

                //*****revival_reason retrieve */

                $revival_reason_code = $rows->revival_reason_code;

                $revival_reason = '';

                foreach (json_decode(REVIVAL_REASONS) as $rr_res) {
                    if ($rr_res->CODE == $revival_reason_code) {
                        $revival_reason = $rr_res->NAME;
                    }
                }

                $json[] = [
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    '<span class="alert-warning"><b>' . $revival_reason . '</b></span>',

                    '<small><b>' . $getRejectRemark . '</b></small>',

                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                ];
            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where_in('a.from_office', [$this->session->userdata('user_desig_code')]);
            $this->db->select('distinct(a.case_no)');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            if ($this->session->userdata('user_desig_code') == 'CO') {
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
                $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            }
            if ($this->session->userdata('user_desig_code') == 'SDO') {
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            }

            $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no');
            $this->db->where('b.req_by', $this->session->userdata('user_desig_code'));
            $this->db->where('b.revival_status = \'1\'');

            $this->db->from('settlement_basic a');
            $this->db->get();
            //***First query */
            $activeQuery1 = $this->db->last_query();

            $this->db->select('distinct(a.case_no)');
            $this->db->from('settlement_basic a');
            $this->db->join('rejected_remark c', 'a.case_no = c.case_no');
            $this->db->join('settlement_revival_flag b', 'a.case_no = b.case_no', 'left');
            $this->db->where('a.service_code', $s_code);
            $this->db->where_in('a.from_office', [$this->session->userdata('user_desig_code')]);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));

            if ($this->session->userdata('user_desig_code') == 'CO') {
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
                $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            }
            if ($this->session->userdata('user_desig_code') == 'SDO') {
                $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            }

            $this->db->where_in('c.reject_code', REVIVAL_REJECT_CODE);
            // Execute the main query
            $this->db->get();
            //****second query */
            $activeQuery2 = $this->db->last_query();

            $this->db->distinct()->select('a.case_no, r.revival_reason_code, a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry', false);
            // $this->db->from('settlement_basic a');
            $this->db->join('settlement_revival_flag r', 'a.case_no = r.case_no', 'left');
            $this->db->where("a.case_no IN ($activeQuery1 UNION $activeQuery2)", null, false);
            // $this->db->get();

            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }
            if (! empty($searchByCol_0)) {

                $this->db->like('a.case_no', strtoupper($searchByCol_0));
            }

            if (! empty($searchByCol_1)) {

                $this->db->like('a.applid', strtoupper($searchByCol_1));
            }

            if (! empty($searchByCol_3)) {
                $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
                //$this->db->like('date_entry', $searchByCol_2);
            }

            $total_records = $this->db->count_all_results('settlement_basic a');
            // echo $this->db->last_query();
            $response = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    // download case list/Area details with proposal id
    public function downloadRejectedCases()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
            }
        }

        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code     = $this->session->userdata('cir_code');
        $service_code = trim($this->input->get('service'));

        $file_name = time() . "_rejected_cases.xlsx";

        $data = $this->db->query("select
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code='00') dist,
			  (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code
			   and cir_code=t1.cir_code and mouza_pargona_code='00') circle,
			 (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no='00') mouza,
		 (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code='00000') lot,
		 (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code=t1.vill_townprt_code) village,
        t1.applid as application_no,t1.case_no, t3.dag_no,
		t3.applied_area, t3.proposed_area,(select note_on_order from settlement_proceeding sp where sp.case_no = t1.case_no order by id desc limit 1) as rejected_remark
        from settlement_basic t1
        left join ( select case_no,string_agg(distinct(dag_no),'-') as dag_no,string_agg(distinct(dag_no || '-area( home: ' || home_b || ' B-'||home_k||' K-'||home_lc ||'L, agri: '||agri_b||'B-'||agri_k||'K-'||agri_lc||'L)'),',') as applied_area, string_agg(distinct(dag_no || '-area( Total_Proposed_area: ' || s_dag_area_b || ' B-'||s_dag_area_k||' K-'||s_dag_area_lc ||'L)'),',') as proposed_area from settlement_dag_details sdd group by case_no) t3 on t1.case_no=t3.case_no
        where status='D' and pull_request =0 and pending_officer='CO' and service_code='$service_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' $lot_bifurcate")->result_array();

        $this->UtilsModel->downloadExcelReport($file_name, $data);

    }

    public function printPaymentNotice()
    {
        $case_no = $this->input->get('case');

        $sql = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', [$case_no, 'PN']);

        if ($sql->num_rows() <= 0) {
            $base64decoded_notice_file = false;
        } else {
            $row = $sql->row();

            $path = $this->SettlementCommonModel->downloadNotice($row->notice_link);
            if ($path == false) {
                echo 'No data found!';
                return;
            }

            $open_notice_file = fopen($path, "r") or die("Unable to open file!");
            $read_notice_file = fread($open_notice_file, filesize($path));
            fclose($open_notice_file);
            // decoding the base64 encoding file variable
            $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        }

        $data          = ['base64_decoded_notice_file' => $base64decoded_notice_file];
        $data['_view'] = 'SettlementView/Co/Tenant/PrintNotice';
        $this->load->view('layouts/main', $data);
    }

    public function verifyLandClassZone()
    {
        if (isset($_GET['case']) && $_GET['case'] != null) {
            $case_no         = $this->input->get('case');
            $data['case_no'] = $case_no;
            //settlement basic details------------

            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

            $get_dag_details    = $this->SettlementKhasModel->getSettlementDag($case_no);
            $sqlforzonal        = "select zone_code,zone_name from zonal_master";
            $zonaldata          = $this->db->query($sqlforzonal)->result();
            $data['zonal_list'] = $zonaldata;

            $sqlforSubclass       = "select subclass_code,subclass_name from subclass_master";
            $subclassData         = $this->db->query($sqlforSubclass)->result();
            $data['subclassData'] = $subclassData;
            // echo "<pre>";
            // var_dump($get_dag_details);
            // die;
            $selectedArray = [];
            if ((! empty($get_settlement_basic) && $get_settlement_basic != null) || (! empty($get_dag_details) && $get_dag_details != null)) {
                //getting land class and zone details-----------
                foreach ($get_dag_details as $key => $value) {

                    $premium_data = $this->db->query("select zonal_valuation,zone_code,subclass_code  FROM settlement_premium  where case_no=? and dag_no = ? and is_final= ?", [$case_no, $value->dag_no, 1])->row();

                    $sql       = "select vz.zone_name,vz.subclass_name,vz.zone_code,vz.subclass_code FROM dagwise_zone_info dz LEFT JOIN villagewise_zone_info vz ON dz.unique_village_code = vz.unique_village_code WHERE dz.flag = '1' AND vz.flag ='1' AND dz.unique_village_code = ? AND dz.dag_no = ? AND vz.zone_code::int = dz.zone_id::int AND vz.subclass_code::int = dz.subclass_id::int";
                    $queryData = $this->db->query($sql, [$get_settlement_basic->uuid, $value->dag_no]);
                    log_message('error', '---------last=========' . $this->db->last_query());
                    if ($queryData->num_rows() > 0) {

                        $rowData           = $queryData->row();
                        $finalZoneCode     = $rowData->zone_code;
                        $finalsubclassCode = $rowData->subclass_code;
                        if ($premium_data->zone_code != null) {
                            $finalZoneCode = $premium_data->zone_code;
                        }
                        if ($premium_data->subclass_code != null) {
                            $finalsubclassCode = $premium_data->subclass_code;
                        }
                        $selectedArray[$key]['dag_no']          = $value->dag_no;
                        $selectedArray[$key]['zone_name']       = $rowData->zone_name;
                        $selectedArray[$key]['zone_code']       = $finalZoneCode;
                        $selectedArray[$key]['subclass_name']   = $rowData->subclass_name;
                        $selectedArray[$key]['subclass_code']   = $finalsubclassCode;
                        $selectedArray[$key]['zonal_valuation'] = $premium_data->zonal_valuation;

                    } else {
                        $this->session->set_flashdata('message', "#ERR111: Zonal information not found! Contact admin...");
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                    // $selectedArray[] = $selectedArray;
                }

            } else {
                $this->session->set_flashdata('message', "#ERR110: some error occured! Contact admin...");
                redirect(base_url() . "index.php/home");
                return false;
            }
            // echo "<pre>";
            // var_dump($selectedArray);
            // die;

            $data['selectedArray'] = $selectedArray;

            $data['_view'] = 'SettlementView/include/verifyLandClassZone';
            $this->load->view('layouts/main', $data);
        }

    }

    public function verifyLandClassZoneSave()
    {
        $case_no           = $this->input->post('case_no');
        $zone_code         = $this->input->post('zonal');
        $subclass_code     = $this->input->post('subclass');
        $zonal_value_htm   = $this->input->post('zonal_value_htm');
        $zonal_value       = $this->input->post('zonal_value_');
        $dag_no            = $this->input->post('dag_no');
        $totalDagsSelected = $this->input->post('selectedArrayCount');

        $basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        if ($basic->service_code == '16') {
            $controller = 'SettlementKhasCo';
        } else if ($basic->service_code == '14') {
            $controller = 'SettlementApCo';
        } else if ($basic->service_code == '15') {
            $controller = 'SettlementTribalCo';
        } else if ($basic->service_code == '18') {
            $controller = 'SettlementTeaCo';
        } else if ($basic->service_code == '17') {
            $controller = 'SettlementVgrCo';
        } else if ($basic->service_code == '13') {
            $controller = 'SettlementTenantCo';
        }

        if (isset($totalDagsSelected) && $totalDagsSelected != null && $totalDagsSelected > 0) {
            $this->db->trans_begin();
            for ($i = 0; $i < $totalDagsSelected; $i++) {
                $zone      = $zone_code[$i];
                $subclass  = $subclass_code[$i];
                $valuation = $zonal_value[$i];
                $dag       = $dag_no[$i];

                if ($valuation == null || $valuation == '0' || $valuation == '0.00') {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR1193221: Incorrect zonal value...Kindly check once");
                    redirect(base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $case_no);
                }

                if ($zone == null || $subclass == null || $dag == null) {
                    $this->db->trans_rollback();
                    redirect(base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $case_no);
                }
                $premium_data = $this->db->query("select zonal_valuation  FROM settlement_premium  where case_no=? and dag_no = ? and is_final=1", [$case_no, $dag])->row();

                if (isset($premium_data) && $premium_data != null) {
                    $old_zonal_value = $premium_data->zonal_valuation;

                    $this->db->query("update settlement_premium set zonal_valuation = ? , zone_code = ? , subclass_code =? , old_zonal_valuation = ?  where case_no=? and dag_no = ? and is_final=?", [$valuation, $zone, $subclass, $old_zonal_value, $case_no, $dag, 1]);
                    log_message('error', '----------' . $this->db->last_query());

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERR119: Something went wrong...");
                        redirect(base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $case_no);
                    }
                } else {
                    $this->session->set_flashdata('message', "#ERR187: Premium data not found...");
                    redirect(base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $case_no);
                }

            }
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR18743: Something went wrong...");
                redirect(base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $case_no);
            } else {
                $this->db->trans_commit();
                redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
            }
        } else {
            $this->session->set_flashdata('message', "#ERR118: Format error ! Kindly fill up correctly...");
            redirect(base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $case_no);
        }

    }

    public function savePaymentNotice()
    {
        $case_no = $this->input->post('case_no');
        $version = $this->input->post('version') ?? null;

        $this->db->trans_begin();

        $noticeAlreadyGeneratedCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', [$case_no, 'PN']);

        $old_notice_link = false;
        if ($noticeAlreadyGeneratedCheck->num_rows() > 0) {
            //******re-generate premium notice first check if payment already done for this case_no */
            $paymentStatusCheck = $this->SettlementApiModel->paymentStatusCheck($case_no);

            if ($paymentStatusCheck['responseType'] != 2) {
                $this->session->set_flashdata('message', "#ERR18435896: Payment already made by citizen for this application # " . $case_no);
                redirect(base_url() . "index.php/home");
            }

            //***getting the old notice link before deleting it */
            $old_notice_link = $noticeAlreadyGeneratedCheck->row()->notice_link;

            //***delete the notice */

            $this->db->query('delete from settlement_notice where case_no = ? and notice_type = ?', [$case_no, 'PN']);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1843444: Unable to process! Something went wrong... # " . $case_no);
                redirect(base_url() . "index.php/home");
            }

            // $this->session->set_flashdata('message', "#ERR1843: Premium notice already generated # ".$case_no);
            // redirect(base_url() . "index.php/home");
        }

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        $timestamp   = date('mdYhis', time()) . uniqid();

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path    = PAYMENT_NOTICE_PATH . $new_case_no . '_' . $timestamp . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text      = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount               = $this->input->post('amount');
        $remark_co            = $this->input->post('remark');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        $case_user_case = $get_settlement_basic->co_code;

        // if($this->session->userdata('user_code') != $case_user_case)
        // {
        //     $this->session->set_flashdata('message', "#ERR2040: Session timeout! Please login and try again # ".$case_no);
        //     redirect(base_url() . "index.php/home");
        // }

        if ($this->session->userdata('user_desig_code') != 'CO') {
            $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # " . $case_no);
            redirect(base_url() . "index.php/home");
        }

        $get_dag_details          = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $district                 = $this->input->post('district');
        $sub_division             = $this->input->post('sub_division');
        $circle                   = $this->input->post('circle');
        $lot_no                   = $this->input->post('lot_no');
        $mouza                    = $this->input->post('mouza');
        $village                  = $this->input->post('village');
        // $petitioner_name = $this->input->post('petitioner_name');
        // $g_name = $this->input->post('g_name');
        // $dag_name = $this->input->post('dag_name');
        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');
        // $data = [
        //    'case_no' => $case_no,
        //    'remark' => $remark,
        //    'get_settlement_basic' => $get_settlement_basic,
        //    'get_dag_details' => $get_dag_details,
        //    'get_settlement_applicant' => $get_settlement_applicant,
        // ];
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM
                           settlement_basic
                           WHERE
                              case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers      = "SELECT * FROM settlement_applicant
                        WHERE
                           case_no = ?
                        AND
                           pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                    'APPLICANT_ID'         => $buyers->id,
                    'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                    'GUARDIAN_NAME'        => $buyers->pdar_guardian,
                ];
        }

        $controller = '';

        if ($get_settlement_basic->service_code == '13') {
            $notice_no  = "MB2/PN/" . date('Y') . "/STENT/" . $service_details->petition_no;
            $controller = 'SettlementTenantCo';
        } elseif ($get_settlement_basic->service_code == '14') {
            $notice_no  = "MB2/PN/" . date('Y') . "/SAPNR/" . $service_details->petition_no;
            $controller = 'SettlementApCo';
        } elseif ($get_settlement_basic->service_code == '15') {
            $notice_no  = "MB2/PN/" . date('Y') . "/STRIB/" . $service_details->petition_no;
            $controller = 'SettlementTribalCo';
        } elseif ($get_settlement_basic->service_code == '16') {
            $notice_no  = "MB2/PN/" . date('Y') . "/SKCSL/" . $service_details->petition_no;
            $controller = 'SettlementKhasCo';
        } elseif ($get_settlement_basic->service_code == '17') {
            $notice_no  = "MB2/PN/" . date('Y') . "/SVGR/" . $service_details->petition_no;
            $controller = 'SettlementVgrCo';
        } elseif ($get_settlement_basic->service_code == '18') {
            $notice_no  = "MB2/PN/" . date('Y') . "/SCULT/" . $service_details->petition_no;
            $controller = 'SettlementTeaCo';
        }

        $insertIntoSettlementNotice = [
            'case_no'                => $case_no,
            'service_code'           => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date'    => date('Y-m-d'),
            'total_amount'           => $amount,
            'sdlac_proposal_id'      => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date'    => $service_details->sdlac_date,
            'applicant_details'      => json_encode($applicant_buyers_json),
            'payment_completed_date' => date('Y-m-d'),
            'notice_no'              => $notice_no,
            'notice_link'            => $base_64_file_path,
            'notice_type'            => 'PN',
            'payment_version'        => $version,
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $this->session->set_flashdata('message', "#KHASPAYAPI0016 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
            return false;
        }

        $updateArr = [
            'status'             => 'N',
            'co_code'            => $this->session->userdata('user_code'),
            'user_code'          => $this->session->userdata('user_code'),
            'pay_notice_gen_yn'  => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update'        => date('Y-m-d h:i:s'),
            'from_office'        => 'CO',
            'pending_officer'    => 'CO',
            'pending_office'     => 'CO',
            'co_notice_link'     => $base_64_file_path,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $this->session->set_flashdata('message', "#KHASPAYAPI0015 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
            return false;
        }

        //****if CO aggress with OLD premium calculation */
        $settlement_premium_insertion = $this->SettlementCommonModel->premiumReCalculation($case_no);

        if ($settlement_premium_insertion != null && $settlement_premium_insertion['status'] == 3) {
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $insertArr = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => 'CO agreed with old dag flag premium calculation',
                'status'               => 'N',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => 'CO',
                'office_to'            => 'CO',
                'task'                 => 'CO agreed with old dag flag premium calculation',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#KHASPAYAPI00145: Insertion failed in settlement_proceeding');
                $this->session->set_flashdata('message', "#KHASPAYAPI00145 Payment notice  could not be generated...");
                redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
                return false;
            }
        }

        //******check if CO aggreed with concession even after caste is general */
        $data['caste']     = $get_settlement_basic->caste;
        $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);

        foreach ($applicants_buyers as $applicant) {
            if ($applicant->is_applicant == 1) {
                $data['if_widow'] = $applicant->marital_status;
            }
        }

        if (! isset($data['if_widow'])) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR151220231026: Marital staus not found! ' . $case_no);
            $this->session->set_flashdata('message', "#ERROR151220231026: Something went wrong! " . $case_no);
            redirect(base_url() . 'index.php/home/index');
        }

        $concenSql = $this->db->query('select concession from settlement_premium where case_no = ? and is_final = ? limit 1', [$case_no, 1]);

        if ($concenSql->num_rows() <= 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERROR151220231155: Something went wrong! Unable to process... ' . $case_no);
            $this->session->set_flashdata('message', "#ERROR151220231155: Something went wrong! Unable to process " . $case_no);
            redirect(base_url() . 'index.php/home/index');
        }

        if ($concenSql->row()->concession == 'YES') {
            if (trim($data['caste']) == '6' && trim($data['if_widow']) != '4') {
                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }
                $insertArr = [
                    'case_no'              => $case_no,
                    'proceeding_id'        => $proceeding_id,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order'        => 'CO agreed with premium concession',
                    'status'               => 'N',
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => 'CO',
                    'office_to'            => 'CO',
                    'task'                 => 'CO agreed with premium concession',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
                    $this->session->set_flashdata('message', "#ERRPN00021 Payment notice  could not be generated...");
                    redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
                    return false;
                }
            }
        }

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $remark_co,
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'CO',
            'office_to'            => 'CO',
            'task'                 => 'Payment Notice Generated',
            'old_file_link'        => $old_notice_link == false ? null : $old_notice_link,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
            $this->session->set_flashdata('message', "#ERRPN00022 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#KHASPAYAPI0013 Payment notice  could be generated...");
            redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
            exit;
        } else {
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;

            /// check full pay
            $is_full_pay      = 'N';
            $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
            if ($premium_tot_data->num_rows() > 0) {
                foreach ($premium_tot_data->result() as $prem_records) {

                    if ($prem_records->area_name == '7' || $prem_records->area_name == '8' || $prem_records->area_name == '9' || $prem_records->area_name == '10') {
                        $is_full_pay = 'N'; //// from now all cases partial payment option available
                    }

                }
            } else {

                log_message('error', '#BACKUP003277: Premium payment type not found. Case No ' . $case_no);

                $this->session->set_flashdata('error_data', "#BACKUP003277: Premium payment type not found for case no : " . $case_no);
            }
            /// check full pay end

            // upload notice API
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                'encoded_file'   => json_decode($htmlstring_text),
                'application_no' => $rtps_case_no,
                'type'           => 'PN',
                'amount'         => $amount,
                'is_full_pay'    => $is_full_pay,
            ]));
            $result = curl_exec($curl_handle);

            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#KHASPAYAPI0011  Payment notice  could not be generated...");
                redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
                exit;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/' . $controller . '/generatePaymentNoticeCo?case=' . $case_no);
            }
            // payment request API
            // $status = $this->SettlementMbModel->paymentRequest($rtps_case_no, $amount);
            // if (trim($status) != 'y') {
            //     $this->db->trans_rollback();
            //     $this->session->set_flashdata('message', "#KHASPAYAPI0012 Payment notice  could not be generated...");
            //     redirect(base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $case_no);
            //     exit;
            // }else {
            //     $this->db->trans_commit();
            //     $this->session->set_flashdata('message', "Payment notice successfully saved...");
            //     redirect(base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $case_no);
            // }
        }
    }

    // bulk Revive case for CO/SDO/ADC
    public function bulkReviveCases()
    {
        $casesArray = $this->input->post('selectMark');

        $this->db->trans_begin();

        if (! $casesArray) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JSMRRC001: No cases selected!',
            ]);
            return false;
        }

        $caseCount = count($casesArray);
        //*****update in settlement_basic bulk */
        $index                  = 0;
        $revivalIndex           = 0;
        $caseArray              = '';
        $caseArrayForRevival    = '';
        $caseInSdlacArray       = [];
        $basic_vgr_revival_flag = 0;
        $is_revived_by          = false;
        $revival_tot_count      = 0;
        foreach ($casesArray as $singleCase) {
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($singleCase);

            if ($get_settlement_basic->service_code == '17') {
                $clusterSql = $this->db->query('select * from settlement_circle_cluster_cases where case_no = ?', [$singleCase]);

                if ($clusterSql->num_rows > 0) {
                    $this->db->query('delete from settlement_circle_cluster_cases where case_no = ?', [$singleCase]);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 0,
                            'msg'          => '#JS110966: Something went wrong!',
                        ]);
                        return false;
                    }
                }

                $checkIfRevertedCSql = $this->db->query('select * from settlement_vgr_pgr_revert_cases where case_no = ?', [$singleCase]);

                if ($checkIfRevertedCSql->num_rows > 0) {
                    $this->db->query('delete from settlement_vgr_pgr_revert_cases where case_no = ?', [$singleCase]);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 0,
                            'msg'          => '#JS1111040: Something went wrong!',
                        ]);
                        return false;
                    }
                }

                $basic_vgr_revival_flag = 1;

                // echo json_encode([
                //     'responseType' => 0,
                //     'msg' => '#JSMRRC10966: This feature is currently not available for VGR/PGR!'
                // ]);
                // return false;
            }

            $sql = $this->db->query('select * from settlement_revival_flag where case_no = ?', [$singleCase]);

            if ($sql->num_rows() > 0) {
                $is_revived_by     = true;
                $revival_tot_count = $revival_tot_count + 1;
            }

            if ($is_revived_by == true) {
                if ($revivalIndex == 0) {
                    $caseArrayForRevival = $caseArrayForRevival . "'" . $singleCase . "'";
                } else {
                    $caseArrayForRevival = $caseArrayForRevival . ",'" . $singleCase . "'";
                }

                $revivalIndex++;
            }

            if ($index == 0) {
                $caseArray = $caseArray . "'" . $singleCase . "'";
            } else {
                $caseArray = $caseArray . ",'" . $singleCase . "'";
            }

            $countCaseInSdlacProposal = $this->SettlementCommonDcModel->countSettlementApplicationByCaseNoInSdlacProList($singleCase);
            if ($countCaseInSdlacProposal != 0) {
                $caseInSdlacArray[] = $singleCase;
            }

            $index++;
        }

        $q2 = "Select case_no, max(proceeding_id)+1 as pro_id from settlement_proceeding WHERE
               case_no in ($caseArray)  group by case_no";

        $allProceeding = $this->db->query($q2)->result();
        $proCount      = count($allProceeding);

        if ($proCount == 0 || $proCount == '') {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JSMRRC002: Something went wrong!',
            ]);
            return false;
        }

        $updateBasic = [
            'vgr_revival_flag' => $basic_vgr_revival_flag,
            'status'           => 'W',
            'date_update'      => date('Y-m-d h:i:s'),
            'from_office'      => 'LM',
            'pending_officer'  => 'CO',
            'pending_office'   => 'CO',
        ];

        // update proceeding
        $proceedingUpdateArray = [];

        $proceedingInsert = [
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $this->session->userdata('user_desig_code'),
            'office_to'            => 'CO',
            'task'                 => 'Revived for review',
            'status'               => 'W',
            'note_on_order'        => 'Revived for review by ' . $this->session->userdata('user_desig_code'),
        ];

        foreach ($allProceeding as $pro) {
            $proceedingInsert['case_no']       = $pro->case_no;
            $proceedingInsert['proceeding_id'] = $pro->pro_id;
            $proceedingUpdateArray[]           = $proceedingInsert;
        }

        // delete SDLAC proposal case
        if (count($caseInSdlacArray) > 0) {
            foreach ($caseInSdlacArray as $sdlacCase) {
                $case_no                = trim($sdlacCase);
                $deleteCase             = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                $insertIntoDeletedTable = [
                    'proposal_id' => $deleteCase->proposal_id,
                    'case_no'     => $deleteCase->case_no,
                    'status'      => $deleteCase->status,
                    'ip'          => $deleteCase->ip,
                    'created_at'  => $deleteCase->created_at,
                    'updated_at'  => $deleteCase->updated_at,
                    'co_submit'   => $deleteCase->co_submit,
                    'deleted_by'  => $this->session->userdata('user_code'),
                ];

                $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                if ($insertDeleteData != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#JSMRRC0022: Insertion failed in settlement_proposal_cases_deleted for case no :' . $case_no);
                    echo json_encode([
                        'responseType' => 0,
                        'msg'          => '#JSMRRC0022: Reverted failed case no #' . $case_no . ' ! Kindly contact system administrator',

                    ]);
                    return;
                }
                $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                if ($deleteProCase != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#JSMRRC0011: Deletion failed in settlement_proposal_cases for case no :' . $case_no);
                    echo json_encode([
                        'responseType' => 0,
                        'msg'          => '#JSMRRC0011: Reverted failed case no #' . $case_no . ' ! Kindly contact system administrator',
                    ]);
                    return false;
                }
            }
        }

        // batch update into settlement_basic
        $update_count = $this->updateBatch('settlement_basic', $updateBasic,
            'case_no', $caseArray);
        if ($caseCount != $update_count) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JSMRRC003: Something went wrong!',
            ]);
            return false;
        }

        if ($revival_tot_count > 0) {
            $revivalArr = [
                'revival_status' => 2,
            ];

            $updateRevivalTable = $this->updateBatch('settlement_revival_flag', $revivalArr, 'case_no', $caseArrayForRevival);

            if ($revival_tot_count != $updateRevivalTable) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#JSMRRC004: Something went wrong!',
                ]);
                return false;
            }
        }

        // batch insert into settlement_proceeding
        $insert_count = $this->db->insert_batch('settlement_proceeding', $proceedingUpdateArray);
        if ($caseCount != $insert_count) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JSMRRC005: Something went wrong!',
            ]);
            return false;
        }

        if ($caseCount > 0) {

            $caseAppUrbanSql = $this->db->query("select string_agg(applid,',') as applids from settlement_basic where case_no in($caseArray)");

            $allAPICasesIds = $caseAppUrbanSql->row()->applids;

            $rmk         = 'Revived for review';
            $status      = 'M';
            $task        = $this->session->userdata('user_desig_code');
            $pen         = MB_CIRCLE_OFFICER;
            $rtps_status = $this->SettlementApiModel->applicationStatusUpdateBulk($allAPICasesIds, 'NA', $rmk, $status, $task, $pen);
            if ($rtps_status != "y") {
                $this->db->trans_rollback();
                log_message('error', '#JSMRRC000: Issue in API Call'
                    . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#JSMRRC000: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Cases successfully revived...',
        ]);
        return false;

    }

    // update batch Query
    public function updateBatch($table, $data, $where_filed, $where_array)
    {
        $sql = "update $table set ";

        foreach ($data as $key => $value) {
            $sql = $sql . ' ' . $key . '=\'' . $value . '\', ';
        }
        $sql = substr(trim($sql), 0, -1);
        $sql = $sql . ' where ' . $where_filed . ' in (' . $where_array . ')';
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function buldRevertToLmFromCo()
    {
        $caseArray = $this->input->post('selectMark');

        $index          = 0;
        $caseStringArr  = '';
        $remark_co_type = '3';
        $caseCount      = count($caseArray);

        foreach ($caseArray as $case_no) {
            if ($index == 0) {
                $caseStringArr = $caseStringArr . "'" . $case_no . "'";
            } else {
                $caseStringArr = $caseStringArr . ",'" . $case_no . "'";
            }

            $index++;
        }

        $q2 = "Select case_no, max(proceeding_id)+1 as pro_id from settlement_proceeding WHERE case_no in ($caseStringArr)  group by case_no";

        $allProceeding = $this->db->query($q2)->result();
        $proCount      = count($allProceeding);

        if ($proCount == 0 || $proCount == '') {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JS00233: Something went wrong!',
            ]);
            return false;
        }

        $proceedingUpdateArray = [];

        $proceedingInsert = [
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $this->session->userdata('user_desig_code'),
            'office_to'            => 'LM',
            'task'                 => 'Reverted Back to LM',
            'status'               => 'R',
            'note_type'            => $remark_co_type,
            'note_on_order'        => 'Reverted Back to LM',
        ];

        foreach ($allProceeding as $pro) {
            $proceedingInsert['case_no']       = $pro->case_no;
            $proceedingInsert['proceeding_id'] = $pro->pro_id;
            $proceedingUpdateArray[]           = $proceedingInsert;
        }

        $this->db->trans_begin();

        // batch update into settlement_basic
        $updateBasicArr = [
            'status'          => 'R',
            'co_code'         => $this->session->userdata('user_code'),
            'date_update'     => date('Y-m-d h:i:s'),
            'from_office'     => 'CO',
            'pending_officer' => 'LM',
            'pending_office'  => 'CO',
        ];

        $update_count = $this->updateBatch('settlement_basic', $updateBasicArr, 'case_no', $caseStringArr);
        if ($caseCount != $update_count) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JSMRRC0033: Something went wrong!',
            ]);
            return false;
        }

        // batch insert into settlement_proceeding
        $insert_count = $this->db->insert_batch('settlement_proceeding', $proceedingUpdateArray);
        if ($caseCount != $insert_count) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#JSMRRC0053: Something went wrong!',
            ]);
            return false;
        }

        if ($caseCount > 0) {
            $caseAppUrbanSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseStringArr)";
            $allAPICasesIds  = $this->db->query($caseAppUrbanSql)->row()->applids;

            $rmk         = 'Reverted to LM';
            $status      = 'M';
            $task        = $this->session->userdata('user_desig_code');
            $pen         = 'LM';
            $rtps_status = $this->SettlementApiModel->applicationStatusUpdateBulk($allAPICasesIds, 'NA', $rmk, $status, $task, $pen);
            if ($rtps_status != "y") {
                $this->db->trans_rollback();
                log_message('error', '#JSMRRC000454: Issue in API Call' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#JSMRRC000454: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Cases successfully reverted...',
        ]);
        return false;

    }

    public function premiumReCalculateCaste()
    {
        $case_no       = $this->input->post('case_no');
        $is_concession = $this->input->post('is_concession');

        $check = $this->SettlementCommonModel->premiumReCalculateInsert($case_no, $is_concession);

        if ($check['status'] != 2) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => $check['message'],
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'msg'          => $check['message'],
        ]);
    }

    public function settlementPremiumInstallment($case_no)
    {
        // $case_no = 'KAM/PAL/2023-24/4415/SKHAS';

        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

        $this->db->trans_begin();

        $premiumTable = $this->SettlementCommonModel->premiumTable($case_no);

        $premiumResult = $premiumTable->result();

        foreach ($premiumResult as $premRow) {
            $dag_noArray[] = $premRow->dag_no;
        }

        $dag_no_agg = implode(",", $dag_noArray);

        if ($premiumTable->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR12093: Something went wrong! Unable to process...',
            ]);
            return false;
        }

        $premiumRow = $premiumTable->row();

        if ($premiumRow->grn_no == null || empty($premiumRow->grn_no)) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR12119: Something went wrong! Unable to process...',
            ]);
            return false;
        }

        if ($premiumRow->final_amount > $premiumRow->paid_amount) {
            $is_full_paid = 0;
        } else {
            $is_full_paid = 1;
        }

        $premiumArray = [
            'case_no'                 => $premiumRow->case_no,
            'application_no'          => $application_no,
            'final_amount'            => $premiumRow->final_amount,
            'paid_amount'             => $premiumRow->paid_amount,
            'remaining_amount'        => $premiumRow->remaining_amount,
            'tenure'                  => $premiumRow->tenure,
            'installment_amount'      => $premiumRow->installment_amount,
            'payment_date'            => $premiumRow->payment_date,
            'grn_no'                  => $premiumRow->grn_no,
            'challen_link'            => $premiumRow->manual_challan_upload_dir,
            'old_dag_no'              => $dag_no_agg,
            'settlement_dag_no'       => null,
            'ekhajana_application_no' => null,
            'is_full_paid'            => $is_full_paid,
            'date_entry'              => date('Y-m-d G:i:s'),
            // 'date_update'               =>
        ];

        $insert = $this->db->insert('settlement_emi_history', $premiumArray);
        if ($insert != 1) {
            $this->db->trans_rollback();

            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR12157: Something went wrong! Unable to process...',
            ]);
            return false;
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Premium successfully inserted to settlement_emi_history table',
        ]);
    }

    public function getNextEmiAmount($case_no)
    {
        $emiTable = $this->SettlementCommonModel->getEmiHistory($case_no);

        if ($emiTable->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR12177: Something went wrong! Unable to process...',
            ]);
            return false;
        }

        $emiResult = $emiTable->result();

        $nextEmi = end($emiResult);

        if ($nextEmi->is_full_paid == 1) {
            echo json_encode([
                'responseType' => 3,
                'msg'          => '#MSG12192: Already fully paid!',
            ]);
            return false;
        } else {
            echo json_encode([
                'responseType'   => 2,
                'emiHistory'     => $emiResult,
                'nextEmiAmount'  => $nextEmi->installment_amount,
                'nextFullAmount' => $nextEmi->remaining_amount,
            ]);
        }

    }

    public function insertEmiInstallment()
    {
        $this->db->trans_begin();
        //****get date from ekhajana */
        $case_no         = $this->input->post('case_no');
        $installmentPaid = $this->input->post('installment_paid');
        $grn_no          = $this->input->post('grn_no');
        $paymentDate     = $this->input->post('payment_date');
        $challenLink     = $this->input->post('challen_link');
        $ekhajanAppNo    = $this->input->post('ekhajana_application_no');

        $emiTable = $this->SettlementCommonModel->getEmiHistory($case_no);

        if ($emiTable->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR12200: Something went wrong! Unable to process...',
            ]);
            return false;
        }

        $emiResult = $emiTable->result();

        foreach ($emiResult as $emiRow) {
            if ($emiRow->is_full_paid == 1) {
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#MSG12213: Already fully paid!',
                ]);
                return false;
            }
        }

        $lastPaid = end($emiResult);

        $remaining_amount = $lastPaid->final_amount - ($lastPaid->remaining_amount + $installmentPaid);

        $is_full_paid = 0;
        if ($remaining_amount >= $lastPaid->final_amount) {
            $is_full_paid = 1;
        }

        $insertArray = [
            'case_no'                 => $case_no,
            'application_no'          => $lastPaid->application_no,
            'final_amount'            => $lastPaid->final_amount,
            'paid_amount'             => $installmentPaid,
            'remaining_amount'        => $remaining_amount,
            'tenure'                  => $lastPaid->tenure,
            'installment_amount'      => $lastPaid->installment_amount,
            'payment_date'            => $paymentDate,
            'grn_no'                  => $grn_no,
            'challen_link'            => $challenLink,
            'old_dag_no'              => $lastPaid->dag_no_agg,
            'settlement_dag_no'       => $lastPaid->settlement_dag_no,
            'ekhajana_application_no' => $ekhajanAppNo,
            'is_full_paid'            => $is_full_paid,
            'date_entry'              => date('Y-m-d G:i:s'),
        ];

        $insert = $this->db->insert('settlement_emi_history', $insertArray);
        if ($insert != 1) {
            $this->db->trans_rollback();

            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR12157: Something went wrong! Unable to process...',
            ]);
            return false;
        }

        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Premium successfully done...',
        ]);
    }

    // public function updateCase()
    // {
    //     $case_no = $this->input->post('case_no');
    //     //*****update settlement_dag_details */
    //     $this->db->trans_begin();
    //     $updateArr = [
    //         's_dag_area_b' => 0,	
    //         's_dag_area_k' => 1,	
    //         's_dag_area_lc' => 11,	
    //         'home_b' => 0,	
    //         'home_k' => 1,	
    //         'home_lc' => 11,	
    //     ];
    //     $this->db->where('case_no', $case_no);
    //     $this->db->update('settlement_dag_details', $updateArr);
    //     if($this->db->affected_rows() != 1)
    //     {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERR12637: Something went wrong! Unable to process...',
    //         ]);
    //         return false;
    //     }

    //     //***udpate settlement_premium */
    //     $gettingPremSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no, 1));
    //     if($gettingPremSql->num_rows() <= 0)
    //     {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERR12649: Something went wrong! Unable to process...',
    //         ]);
    //         return false;
    //     }
    //     $premRow = $gettingPremSql->row();

    //     $updatePremArr = [
    //         'due_amount' => $premRow->due_amount/$premRow->total_lessa * 18,
    //         'final_amount' => $premRow->due_amount/$premRow->total_lessa * 18,
    //         'total_lessa' => 18,
    //     ];

    //     $this->db->where('case_no', $case_no);
    //     $this->db->where('is_final', 1);
    //     $this->db->update('settlement_premium', $updatePremArr);
    //     if($this->db->affected_rows() != 1)
    //     {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERR12654: Something went wrong! Unable to process...',
    //         ]);
    //         return false;
    //     }

    //     //****final area check */
    //     $finalAreaCheck = $this->SettlementCommonModel->finalAreaCheck($case_no);
    //     if($finalAreaCheck['responseType'] != 2)
    //     {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERR12661: Unable to re calculate premium!...'.$finalAreaCheck['msg'],
    //         ]);
    //         return false;
    //     }

    //     //*****To regenerate the premium notice udpate basic status to M */
    //     $updateBasic = [
    //         'status'        => 'M',
    //         'date_update'   => date('Y-m-d H:i:s'),
    //     ];

    //     $this->db->where('case_no', $case_no);
    //     $this->db->update('settlement_basic', $updateBasic);
    //     if($this->db->affected_rows() != 1)
    //     {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERR12693: Something went wrong! Unable to process...',
    //         ]);
    //         return false;
    //     }

    //     //******delete the old premium notice */
    //     $this->db->query('delete from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', array($case_no, 'PN'));
    //     if($this->db->affected_rows() != 1)
    //     {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERR12702: Something went wrong! Unable to process...',
    //         ]);
    //         return false;
    //     }

    //     //*****insert the incident into proceeding */
    //     $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
    //     if ($proceeding_id==null) {
    //         $proceeding_id=1;
    //     }

    //     $insPetProceed = [
    //         'case_no' => $case_no,
    //         'proceeding_id' => $proceeding_id,
    //         'date_of_hearing' => date('Y-m-d h:i:s'),
    //         'next_date_of_hearing' => date('Y-m-d h:i:s'),
    //         'note_on_order' => 'CO udated records due to area and reservation area mis-match',
    //         'status' => 'W',
    //         'user_code' => $this->session->userdata('user_code'),
    //         'date_entry' => date('Y-m-d h:i:s'),
    //         'operation' => 'E',
    //         'ip' => $this->utilityclass->get_client_ip(),
    //         'office_from' => 'CO',
    //         'office_to' => 'CO',
    //         'task' => 'CO updated area and Premium notice re-generated'
    //     ];
    //     $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
    //     if ($insertProceeding != 1) {
    //         $this->db->trans_rollback();
    //         echo json_encode([
    //             'responseType'  => 0,
    //             'msg'           => '#ERRORPP: Something went wrong! Unable to process...',
    //         ]);
    //         return false;
    //     }
    //     $this->db->trans_commit();

    //     echo json_encode([
    //         'responseType'  => 2,
    //         'msg'           => 'Data successfully updated...',
    //     ]);
    // }

    public function getRevenueDetails($case_no)
    {
        $basics = $this->db->query('select * from settlement_basic where case_no = ?', [$case_no]);
        if ($basics->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERRJS100951: Unable to update landclass',
            ]);
            return false;
        }
        $basicRow = $basics->row();

        $urbanArray = [1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17];
        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', [$case_no]);

        if ($getDagsSql->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERRJS33100951: Unable to update landclass',
            ]);
            return false;
        }

        $dagRes = $getDagsSql->result();

        foreach ($dagRes as $dagRow) {

            if ($basicRow->service_code == '14') {
                $dagRow->dag_no = $dagRow->new_dag_no;
            }

            $this->db->trans_begin();
            $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and dag_no = ?', [$case_no, $dagRow->dag_no]);
            if ($getPremSql->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERR1260: Premium not found for this dag!',
                ]);
            }

            $premRow = $getPremSql->row();

            $isUrban = 'Rural';
            if (in_array($premRow->area_name, $urbanArray)) {
                $isUrban = 'Urban';
            }

            $land_class_code_agri = $dagRow->new_land_class_agri;
            $land_class_code_home = $dagRow->new_land_class_home;

            $total_revenue_agri = '';
            $total_revenue_home = '';
            $localTax_agri      = '';
            $localTax_home      = '';

            if (! empty($land_class_code_agri)) {
                $landSqlagri = $this->db->query('select * from revenue_land_class_wise where class_code = ? and ruralurban = ? order by date_entry desc limit 1', [$land_class_code_agri, $isUrban]);

                if ($landSqlagri->num_rows() <= 0) {
                    $total_revenue_agri = 15;
                } else {
                    $landRow = $landSqlagri->row();

                    $dag_revenue_perbigha = (float) $landRow->dag_revenue_perbigha;

                    //***calculating revenue in lessa */
                    if (in_array($basicRow->dist_code, json_decode(BARAK_VALLEY))) {
                        $revenue_in_lessa = $dag_revenue_perbigha / 6400;
                    } else {
                        $revenue_in_lessa = $dag_revenue_perbigha / 100;
                    }

                    //*****total_settlemnet_area in lessa */
                    $total_settlement_area_in_lessa = $premRow->total_lessa;

                    //***calculating total revenue */
                    $total_revenue_agri = $total_settlement_area_in_lessa * $revenue_in_lessa;

                    if ($total_revenue_agri < 15) {
                        $total_revenue_agri = 15;
                    }
                }
                //*****calculating the local tax */
                $localTax_agri = $total_revenue_agri / 4;
            }

            if (! empty($land_class_code_home)) {
                $landSqlahome = $this->db->query('select * from revenue_land_class_wise where class_code = ? and ruralurban = ? order by date_entry desc limit 1', [$land_class_code_home, $isUrban]);

                if ($landSqlahome->num_rows() <= 0) {
                    $total_revenue_home = 15;
                } else {
                    $landRow              = $landSqlahome->row();
                    $dag_revenue_perbigha = (float) $landRow->dag_revenue_perbigha;
                    //***calculating revenue in lessa */
                    if (in_array($basicRow->dist_code, json_decode(BARAK_VALLEY))) {
                        $revenue_in_lessa = $dag_revenue_perbigha / 6400;
                    } else {
                        $revenue_in_lessa = $dag_revenue_perbigha / 100;
                    }

                    //*****total_settlemnet_area in lessa */
                    $total_settlement_area_in_lessa = $premRow->total_lessa;
                    //***calculating total revenue */
                    $total_revenue_home = $total_settlement_area_in_lessa * $revenue_in_lessa;

                    if ($total_revenue_home < 15) {
                        $total_revenue_home = 15;
                    }
                }
                //*****calculating the local tax */
                $localTax_home = $total_revenue_home / 4;
            }

            $total_revenue_agri = $this->UtilsModel->defaultValue($total_revenue_agri, 0);
            $total_revenue_home = $this->UtilsModel->defaultValue($total_revenue_home, 0);
            $localTax_agri      = $this->UtilsModel->defaultValue($localTax_agri, 0);
            $localTax_home      = $this->UtilsModel->defaultValue($localTax_home, 0);
            $updateArr          = [
                // 'new_land_class_home'       => $land_class_code_home,
                // 'new_land_class_agri'       => $land_class_code_agri,
                'new_home_land_revenue'   => $total_revenue_home,
                'new_agri_land_revenue'   => $total_revenue_agri,
                'new_home_land_local_tax' => $localTax_home,
                'new_agri_land_local_tax' => $localTax_agri,
                'new_total_revenue'       => $total_revenue_home + $total_revenue_agri,
                'new_total_tax'           => $localTax_home + $localTax_agri,
            ];

            $this->db->where('case_no', $case_no);
            if ($basicRow->service_code == '14') {
                $this->db->where('new_dag_no', $dagRow->dag_no);
            } else {
                $this->db->where('dag_no', $dagRow->dag_no);
            }
            $this->db->update('settlement_dag_details', $updateArr);

            if ($this->db->affected_rows() != count($dagRes)) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg'          => '#ERRJS900951: Unable to update landclass',
                ]);
                return false;
            }

            ///****Update in chitha */
            $csql = $this->db->query('select * from settlement_basic where case_no = ? and order_passed is not null', [$case_no]);
            if ($csql->num_rows() > 0) {
                $alsql = $this->db->query('select * from chitha_settlement_allottee where ord_no = ? and old_dag = ? limit 1', [$case_no, $dagRow->dag_no]);

                if ($alsql->num_rows() <= 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg'          => '#ERRJS900944451: Unable to update landclass',
                    ]);
                    return false;
                }

                $alRow = $alsql->row();

                $dist_code          = $alRow->dist_code;
                $subdiv_code        = $alRow->subdiv_code;
                $cir_code           = $alRow->cir_code;
                $mouza_pargona_code = $alRow->mouza_pargona_code;
                $lot_no             = $alRow->lot_no;
                $vill_townprt_code  = $alRow->vill_townprt_code;
                $new_dag            = $alRow->new_dag;

                //update in chitha
                $table   = 'chitha_basic';
                $updateC = [
                    'dag_revenue'   => $total_revenue_agri + $total_revenue_home,
                    'dag_local_tax' => $localTax_agri + $localTax_home,
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'dag_no'             => $new_dag,
                ];
                // $this->db->where('dist_code', $dist_code);
                // $this->db->where('subdiv_code', $subdiv_code);
                // $this->db->where('cir_code', $cir_code);
                // $this->db->where('mouza_pargona_code', $mouza_pargona_code);
                // $this->db->where('lot_no', $lot_no);
                // $this->db->where('vill_townprt_code', $vill_townprt_code);
                // $this->db->where('dag_no', $new_dag);
                // $this->db->update('chitha_basic', $updateC);
                $this->Chitha_basic_model->update_table($table, $updateC, $where);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg'          => '#ERRJS333900951: Unable to update landclass',
                    ]);
                    return false;
                }
            }

            // echo $this->db->last_query();
            // echo "<pre>";
            // var_dump($updateArr);

            $this->db->trans_commit();
            echo "success";
        }

    }

    public function partialNoticeList()
    {
        $service_code = $this->input->get('service');
        $status       = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view']       = 'settlement_mb/partial_list';
        $this->load->view('layouts/main', $data);
    }

    public function printPartialNoticeCases()
    {
        $service_code = $this->input->get('service');
        $status       = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view']       = 'settlement_mb/print_partial_list';
        $this->load->view('layouts/main', $data);
    }

    public function paginationPartialList()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code         = $this->input->post('service');
        $search_term    = $this->input->post('search_term');
        $remark_cat     = $this->input->post('remark_cat');
        $reverted       = $this->input->post('reverted');
        $user_code      = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details');
        $this->db->where('a.status', $status);
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.pending_officer', 'CO');
        $this->db->join('settlement_premium sp', 'a.case_no = sp.case_no');
        $this->db->where('sp.is_final', 1);
        $this->db->where('sp.due_amount > sp.paid_amount');
        $this->db->where('sp.grn_no is not null');
        $this->db->where('a.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = a.case_no AND notice_type = \'PNP1\')');
        $this->db->from('settlement_basic a');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $view_case_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $json[] = [
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    $view_case_link,
                ];

            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', 'CO');
            if ($this->session->userdata('user_desig_code') == 'CO') {
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }
            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
            $this->db->where('a.status', $status);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->join('settlement_premium sp', 'a.case_no = sp.case_no');
            $this->db->where('sp.is_final', 1);
            $this->db->where('sp.due_amount > sp.paid_amount');
            $this->db->where('sp.grn_no is not null');
            $this->db->where('a.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = a.case_no AND notice_type = \'PNP1\')');

            $total_records = $this->db->count_all_results('settlement_basic a');
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function printPartialNoticeList()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code         = $this->input->post('service');
        $search_term    = $this->input->post('search_term');
        $remark_cat     = $this->input->post('remark_cat');
        $reverted       = $this->input->post('reverted');
        $user_code      = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');

        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'date_entry',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (! empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details');
        $this->db->where('a.status', $status);
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.pending_officer', 'CO');
        $this->db->join('settlement_premium sp', 'a.case_no = sp.case_no');
        $this->db->where('sp.is_final', 1);
        $this->db->where('sp.due_amount > sp.paid_amount');
        $this->db->where('sp.grn_no is not null');
        $this->db->where('a.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = a.case_no AND notice_type = \'PNP1\')');
        $this->db->from('settlement_basic a');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $view_case_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                <a alt="View application" class="text-white btn btn-sm btn-warning" target="Print Partial Notice" href="' . base_url() . 'index.php/SettlementCommon/printPartialNotice?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Print Partial Notice</a>';

                $json[] = [
                    // $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    $view_case_link,
                ];

            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', 'CO');
            if ($this->session->userdata('user_desig_code') == 'CO') {
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }
            if (! empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
            $this->db->where('a.status', $status);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->join('settlement_premium sp', 'a.case_no = sp.case_no');
            $this->db->where('sp.is_final', 1);
            $this->db->where('sp.due_amount > sp.paid_amount');
            $this->db->where('sp.grn_no is not null');
            $this->db->where('a.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = a.case_no AND notice_type = \'PNP1\')');

            $total_records = $this->db->count_all_results('settlement_basic a');
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];

            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function emiCasesNotice()
    {
        $caseArray = $this->input->post('selectMark');
        $this->db->trans_begin();
        foreach ($caseArray as $case) {
            $resp = $this->generatePremiumNoticeEmi($case, 'PNP1');
            if (json_decode($resp)->responseType != 2) {
                echo $resp;
                return false;
            }
        }
        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg'          => 'Partial Payment notice successfully generated....',
        ]);
    }

    public function generatePremiumNoticeEmi($case_no, $notice_type)
    {
        $basic               = $this->SettlementKhasModel->getSettlementBasic($case_no);
        $pre_res             = $this->SettlementCommonModel->getPremiumData($case_no);
        $applicant           = $this->SettlementCommonModel->getApplicant($case_no);
        $payment_notice_data = $this->SettlementCommonModel->getPaymentNotice($case_no);

        if ($pre_res->num_rows() <= 0) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13055: Unable to process! No premium details found...' . $case_no,
            ]);
        }

        if ($applicant->num_rows() <= 0) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13064: Unable to process! No premium details found...' . $case_no,
            ]);
        }

        if ($payment_notice_data->num_rows() <= 0) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13072: Unable to process! No premium details found...' . $case_no,
            ]);
        }

        $circle_name  = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        $dist_name    = $this->utilityclass->getDistrictName($basic['dist_code']);
        $mouza_name   = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);
        $lot_name     = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);
        $village_name = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

        $prem_row    = $pre_res->row();
        $prem_result = $pre_res->result();

        $is_application_row = $applicant->row();
        $payment_notice_row = $payment_notice_data->row();

        $next_id = $this->db->query("select nextval('settlement_notice_id_seq') as count ")->row()->count;

        $area = '';
        foreach ($prem_result as $prem) {
            $total_lessa  = $prem->total_lessa;
            $dags_array[] = $prem->dag_no;

            if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                $area .= 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0<br>';

                // $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
            } else {
                $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                $area .= 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2] . '<br>';

                // $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
            }
        }

        $dag_string = implode(", ", $dags_array);

        //get submission date
        $date_of_application = date('d/m/Y', strtotime($basic['application_date']));
        if (empty($date_of_application)) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13328: Unable to process! Something went wrong...' . $case_no,
            ]);
        }

        if (($prem_row->due_amount - $prem_row->paid_amount) != $prem_row->remaining_amount) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13341: Unable to process! Something went wrong...' . $case_no,
            ]);
        }

        $remaining_amt = $prem_row->due_amount - $prem_row->paid_amount;

        $print = '<div class="row"><div class="col-md-12 text-center font-weight-bold">অসম চৰকাৰ<br>চক্ৰ বিষয়াৰ কাৰ্য্যলয়, ' . $circle_name . '<br>জিলা - ' . $dist_name . '<br>জাননী</div></div>';

        $print .= '<div class="row">
                        <div class="col-6">No : ' . $next_id . '</div>
                        <div class="col-6 text-right">Dated :' . date('d-m-Y') . '</div>
                    </div>';

        $print .= '<div class="row mt-4">
                        <div class="col-md-12">প্ৰতি <b>' . $is_application_row->pdar_name . '</b> পিতা/ স্বামী <b>' . $is_application_row->pdar_guardian . '</b></div>
                    </div>';

        $print .= '<div class="row">
                        <div class="col-md-12">ঠিকনা: ' . $is_application_row->pdar_add1 . '</div>
                    </div>';

        $print .= '<div class="row mt-4">
                        <div class="col-md-12 text-justify">
                            ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ২.০ ৰ <Settlement of Special Cultivators >সেৱাৰ অধীনত ' . $date_of_application . ' তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ <b>' . $basic['applid'] . '</b> ৰ বিপৰীতে আপোনাৰ দখলত থকা নিম্নোক্ত তপচিলভুক্ত চৰকাৰী ভূমিত ,অসম ভুমি ও ৰাজহ অধিনিয়ম ১৮৮৬ ৰ ৩২(১) ধাৰা অনুযায়ী বন্দৱস্তীৰ প্ৰস্তাৱ দি ' . date('d/m/Y', strtotime($payment_notice_row->payment_notice_date)) . ' তাৰিখৰ  জাননীৰ যোগে ' . $prem_row->due_amount . ' টকাৰ প্ৰিমিয়াম  সম্পূৰ্ণ বা কিস্তি হিচাপে 15 Feb 2024 তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা  হৈছিল ।
                        </div>
                    </div>';

        $tr = '<tr>
                        <th>জিলা</th>
                        <th>ৰাজহ চক্ৰ</th>
                        <th>মৌজা</th>
                        <th>লাট</th>
                        <th>গাওঁ</th>
                        <th>দাগ</th>
                        <th>কালি</th>
                    </tr>';

        $tr .= '<tr>
                        <td>' . $dist_name . '</td>
                        <td>' . $circle_name . '</td>
                        <td>' . $mouza_name . '</td>
                        <td>' . $lot_name . '</td>
                        <td>' . $village_name . '</td>
                        <td>' . $dag_string . '</td>
                        <td>' . $area . '</td>
                    </tr>';

        $print .= '<table class="table table-bordered mt-4">' . $tr . '</table>';

        $print .= '<div class="row mt-4">
                        <div class="col-md-12 text-justify">
                            সেই মৰ্মে আপুনি ৩০ শতাংশ প্ৰিমিয়াম ' . $prem_row->paid_amount . ' টকা জমা দিছে আৰু বাকী থকা ৭০ শতাংশ প্ৰিমিয়াম ' . $remaining_amt . ' টকা নিম্ন উল্লেখিত লিংকত অনলাইন যোগে জমা দিব পাৰিব। সম্পূণ প্ৰিমিয়াম জমা দিয়াৰ পাছত আপুনি ডিজিটেল পট্টা লাভ কৰিব।
                        </div>
                    </div>';

        $print .= '<div class="row mt-4">
                        <div class="col-md-12 text-justify">
                            [Please visit link <b>https://sewasetu.assam.gov.in/iservices/login</b> After login with your Sewa Setu Account click on <b>"Track Progress"</b> against your Application No.]
                        </div>
                    </div>';

        $print .= '<div class="row justify-content-end mt-5">
                        <div class="col-3 text-center">
                        <b>' . $this->utilityclass->getSelectedCOName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $this->session->userdata('user_code'))->username . '</b><br>
                            চক্ৰ বিষয়া<br>
                            ' . $circle_name . '

                        </div>
                    </div>';

        $data    = '<div class="container bg-white shadow" id="print_direct"><div class="px-5 mt-5 mb-5">' . $print . '</div></div>';
        $to_save = base64_encode($data);

        $new_case_no          = str_replace('/', "-", $case_no);
        $timestamp            = date('mdYhis', time()) . uniqid();
        $base_64_file_path    = PARTIAL_PAYMENT_NOTICE_PATH . $new_case_no . '_' . $timestamp . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text      = json_encode($to_save);
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        if (! file_exists($base_64_file_path)) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13622: Unable to process! Something went wrong...' . $case_no,
            ]);
        }

        if ($basic['service_code'] == '13') {
            $notice_no = "MB2/" . $notice_type . "/" . date('Y') . "/STENT/" . $basic['petition_no'];
        } elseif ($basic['service_code'] == '14') {
            $notice_no = "MB2/" . $notice_type . "/" . date('Y') . "/SAPNR/" . $basic['petition_no'];
        } elseif ($basic['service_code'] == '15') {
            $notice_no = "MB2/" . $notice_type . "/" . date('Y') . "/STRIB/" . $basic['petition_no'];
        } elseif ($basic['service_code'] == '16') {
            $notice_no = "MB2/" . $notice_type . "/" . date('Y') . "/SKCSL/" . $basic['petition_no'];
        } elseif ($basic['service_code'] == '17') {
            $notice_no = "MB2/" . $notice_type . "/" . date('Y') . "/SVGR/" . $basic['petition_no'];
        } elseif ($basic['service_code'] == '18') {
            $notice_no = "MB2/" . $notice_type . "/" . date('Y') . "/SCULT/" . $basic['petition_no'];
        } else {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13443: Unable to process! Something went wrong...',
            ]);
        }

        $sql_buyers       = "SELECT * FROM settlement_applicant WHERE case_no = ? AND pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                    'APPLICANT_ID'         => $buyers->id,
                    'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                    'GUARDIAN_NAME'        => $buyers->pdar_guardian,
                ];
        }

        $checkIfAlradyGenerated = $this->SettlementCommonModel->checkNoticeExist($case_no, $notice_type);
        if ($checkIfAlradyGenerated->num_rows() > 0) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13469: Partial payment notice already generated...',
            ]);
        }
        $insertIntoSettlementNotice = [
            'case_no'                => $case_no,
            'service_code'           => $basic['service_code'],
            'case_registration_date' => $date_of_application,
            'payment_notice_date'    => date('Y-m-d'),
            'total_amount'           => $remaining_amt,
            'sdlac_proposal_id'      => $basic['sdlace_proposal_no'],
            'sdlac_proposal_date'    => $basic['sdlac_date'],
            'applicant_details'      => json_encode($applicant_buyers_json),
            'payment_completed_date' => date('Y-m-d'),
            'notice_no'              => $notice_no,
            'notice_link'            => $base_64_file_path,
            'notice_type'            => $notice_type,
        ];

        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13485: Unable to proceed! Something went wrong...',
            ]);
        }
        //insert into proceeding 
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order'        => 'Partial payment notice generated',
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'CO',
            'office_to'            => 'CO',
            'task'                 => 'Partial Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERR13523: Unable to proceed! Something went wrong...',
            ]);
        }
        //API hit not needed for partial notice
        return json_encode([
            'responseType' => 2,
            'msg'          => 'Notice successfully generated...',
        ]);
    }

    public function printPartialNotice()
    {
        $case_no = $this->input->get('case');
        // getting the notice file link
        // $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
        // reading the base64 json file and saving it to a variable
        $sql = $this->SettlementCommonModel->checkNoticeExist($case_no, 'PNP1');

        if ($sql->num_rows() <= 0) {
            echo 'No data found!';
            return;
        }

        $notice_row = $sql->row();

        $open_notice_file = fopen($notice_row->notice_link, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file, filesize($notice_row->notice_link));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data                      = [
            'base64_decoded_notice_file' => $base64decoded_notice_file,
        ];
        $data['_view'] = 'SettlementView/Co/PrintNotice';
        $this->load->view('layouts/main', $data);
    }

    public function RejectedCasesByHeadView()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');

        $data['selectList'] = $this->db->query('select * from location where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code != ? and lot_no != ? and vill_townprt_code != ?', [$dist_code, $subdiv_code, $cir_code, '00', '00', '00000'])->result();

        $data['_view'] = 'SettlementView/Co/rejected_cases_by_head_view';
        $this->load->view('layouts/main', $data);
    }

    public function paginationRejectedReasons()
    {
        $service = $this->input->post('service');
        $draw    = intval($this->input->post('draw'));
        $start   = intval($this->input->post('start'));
        $length  = intval($this->input->post('length'));
        $order   = $this->input->post('order');

        $remark_head = $this->input->post('remark_head');

        $download = $this->input->post('download');

        if (empty($remark_head)) {
            $remark_head = 1;
        }

        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);

        $is_cat = $this->input->post('is_category');

        if (! empty($searchByCol_0)) {
            $this->db->like('sb.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {
            $this->db->like('sb.applid', strtoupper($searchByCol_1));
        }
        if (! empty($is_cat)) {
            $exp = explode('_', $is_cat);

            $dist_code          = $exp[0];
            $subdiv_code        = $exp[1];
            $cir_code           = $exp[2];
            $mouza_pargona_code = $exp[3];
            $lot_no             = $exp[4];
            $vill_townprt_code  = $exp[5];

            $this->db->where('sb.dist_code', $dist_code);
            $this->db->where('sb.subdiv_code', $subdiv_code);
            $this->db->where('sb.cir_code', $cir_code);
            $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('sb.lot_no', $lot_no);
            $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
        }

        $this->db->select('temp.rejected_resons, sb.case_no, sa.pdar_name, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code, sb.applid');
        $this->db->from('settlement_basic sb');
        $this->db->join('settlement_applicant sa', 'sb.case_no = sa.case_no');
        $this->db->join(
            "(SELECT rr.case_no, string_agg(rm.remark, ', ') AS rejected_resons
                FROM rejected_remark rr
                JOIN reject_master rm ON CAST(rr.reject_code AS VARCHAR) = CAST(rm.reject_code AS VARCHAR)
                WHERE rm.remark_head = '" . $remark_head . "'
                GROUP BY rr.case_no
            ) AS temp",
            'sb.case_no = temp.case_no',
            'inner'
        );
        $this->db->where('sb.service_code', $service);
        $this->db->where('sa.is_applicant', '1');
        $this->db->where('sb.status', 'D');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        $results = $query->result();

        if ($service == '16') {
            $service_name = 'Khasland';
        } elseif ($service == '13') {
            $service_name = 'Tenant';
        } elseif ($service == '14') {
            $service_name = 'AP';
        } elseif ($service == '15') {
            $service_name = 'Tribal';
        } elseif ($service == '17') {
            $service_name = 'PGR/VGR';
        } elseif ($service == '18') {
            $service_name = 'Cultivation';
        }

        if ($query->num_rows() > 0) {
            foreach ($results as $rows) {

                $head_name = 'Reark Head';
                foreach (json_decode(REJECTED_REMARK_HEAD) as $r_h) {
                    if ($remark_head == $r_h->CODE) {
                        $head_name = $r_h->NAME;
                    }
                }

                $json[] = [
                    // $rows->case_no,
                    '<span style="font-size:12px"><strong>' . $rows->case_no . '</strong></span>',
                    '<span style="font-size:12px"><strong>' . $rows->applid . '</strong></span>',
                    '<span style="font-size:12px">' . $rows->pdar_name . '</span>',
                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                    $service_name,
                    $head_name,
                    $rows->rejected_resons,
                ];
            }

            if (! empty($is_cat)) {
                $exp = explode('_', $is_cat);

                $dist_code          = $exp[0];
                $subdiv_code        = $exp[1];
                $cir_code           = $exp[2];
                $mouza_pargona_code = $exp[3];
                $lot_no             = $exp[4];
                $vill_townprt_code  = $exp[5];

                $this->db->where('sb.dist_code', $dist_code);
                $this->db->where('sb.subdiv_code', $subdiv_code);
                $this->db->where('sb.cir_code', $cir_code);
                $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
                $this->db->where('sb.lot_no', $lot_no);
                $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
            }
            if (! empty($searchByCol_0)) {
                $this->db->like('sb.case_no', strtoupper($searchByCol_0));
            }

            if (! empty($searchByCol_1)) {
                $this->db->like('sb.applid', strtoupper($searchByCol_1));
            }

            $this->db->select('temp.rejected_resons, sb.case_no, sa.pdar_name, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code, sb.applid');
            $this->db->from('settlement_basic sb');
            $this->db->join('settlement_applicant sa', 'sb.case_no = sa.case_no');
            $this->db->join(
                "(SELECT rr.case_no, string_agg(rm.remark, ', ') AS rejected_resons
                    FROM rejected_remark rr
                    JOIN reject_master rm ON CAST(rr.reject_code AS VARCHAR) = CAST(rm.reject_code AS VARCHAR)
                    WHERE rm.remark_head = '" . $remark_head . "'
                    GROUP BY rr.case_no
                ) AS temp",
                'sb.case_no = temp.case_no',
                'inner'
            );
            $this->db->where('sb.service_code', $service);
            $this->db->where('sa.is_applicant', '1');
            $this->db->where('sb.status', 'D');
            $query2   = $this->db->get();
            $response = [
                'draw'            => $draw,
                'recordsTotal'    => $query2->num_rows(),
                'recordsFiltered' => $query2->num_rows(),
                'data'            => $json,
            ];
            echo json_encode($response);

        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function test()
    {
        $case_no = $this->input->get('case_no');
        $app_no  = $this->input->get('app_no');

        $service_code = $this->input->get('service_code');
        $remark_head  = $this->input->get('remark_head');
        $location     = $this->input->get('location');

        if (! empty($location)) {
            $loc_exp            = explode('_', $location);
            $dist_code          = $loc_exp[0];
            $subdiv_code        = $loc_exp[1];
            $cir_code           = $loc_exp[2];
            $mouza_pargona_code = $loc_exp[3];
            $lot_no             = $loc_exp[4];
            $vill_townprt_code  = $loc_exp[5];

            $this->db->where('sb.dist_code', $dist_code);
            $this->db->where('sb.subdiv_code', $subdiv_code);
            $this->db->where('sb.cir_code', $cir_code);
            $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('sb.lot_no', $lot_no);
            $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
        }

        if (! empty($case_no)) {
            $this->db->like('sb.applid', strtoupper($app_no));
        }
        if (! empty($app_no)) {
            $this->db->like('sb.applid', strtoupper($case_no));
        }

        $this->db->select('sb.case_no');
        $this->db->select('sb.applid');
        $this->db->select('sa.pdar_name');
        $this->db->select("CASE
                            WHEN sb.service_code = 16 THEN 'Khasland'
                            WHEN sb.service_code = 13 THEN 'Tenant'
                            WHEN sb.service_code = 14 THEN 'Ap'
                            WHEN sb.service_code = 15 THEN 'Tribal'
                            WHEN sb.service_code = 17 THEN 'VGR_PGR'
                            WHEN sb.service_code = 18 THEN 'Cultivation'
                        END AS service_name", false);
        $this->db->select("CASE
                            WHEN '" . $remark_head . "' = 1 THEN 'Land Not Settlable'
                            when '" . $remark_head . "' = 2 THEN 'Possession Related issues'
                            when '" . $remark_head . "' = 3 THEN 'Identity Mismatch Issues'
                            when '" . $remark_head . "' = 4 THEN 'Applicant Ineligibility issues'
                            when '" . $remark_head . "' = 5 THEN 'WRONG SERVICE APPLICATION'
                            when '" . $remark_head . "' = 6 THEN 'Self declaration issues'
                        END as remark_head", false);
        $this->db->select("(SELECT locname_eng
                        FROM location
                        WHERE dist_code = sb.dist_code
                            AND subdiv_code = sb.subdiv_code
                            AND cir_code = sb.cir_code
                            AND mouza_pargona_code = sb.mouza_pargona_code
                            AND lot_no = sb.lot_no
                            AND vill_townprt_code = sb.vill_townprt_code
                    ) AS village_name", false);
        $this->db->select('temp.rejected_resons');
        $this->db->from('settlement_basic sb');
        $this->db->join('settlement_applicant sa', 'sb.case_no = sa.case_no');
        $this->db->join(
            "(SELECT rr.case_no, string_agg(rm.remark, ', ') AS rejected_resons
                FROM rejected_remark rr
                JOIN reject_master rm ON CAST(rr.reject_code AS VARCHAR) = CAST(rm.reject_code AS VARCHAR)
                WHERE rm.remark_head = '" . $remark_head . "'
                GROUP BY rr.case_no
            ) AS temp",
            'sb.case_no = temp.case_no',
            'inner'
        );
        $this->db->where('sb.service_code', $service_code);
        $this->db->where('sa.is_applicant', '1');
        $this->db->where('sb.status', 'D');
        $query = $this->db->get();

        $result_array = $query->result_array();
        $this->UtilsModel->downloadExcelReport('rejected_reasons.xls', $result_array);
    }

    public function getSelfDocApiMb3()
    {

        $case_no = $this->input->post('case_no');

        $sql         = "Select basundhara from basundhar_application where dharitree='$case_no' ";
        $basundhara  = $this->db->query($sql)->row();
        $token       = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
            'application_no' => $basundhara->basundhara,
            'api_key'        => API_KEY,
            'token'          => $token,
        ]));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType == 3) {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $output             = json_decode($output);
        $lmdata['document'] = $output->documents;
        $lmdata['query']    = $output->query;
        $lmdata['property'] = $output->property;
        $lmdata['aadhar']   = $output->aadhar;
        $lmdata['nextKin']  = $output->nextKin;
        // $selfDeclarationDetails=[];
        $selfDeclarationDetails = [];
        foreach ($output->selfDeclaration as $selfDec) {
            // $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            $selfDeclarationDetails = json_decode($selfDec->dec_details);
        }
        if ($output) {
            $data = [
                'responseType'           => 2,
                'selfDeclarationDetails' => $selfDeclarationDetails,
                'document'               => $output->documents,
                'aadhar'                 => $output->aadhar,
            ];
            echo json_encode($data);
        } else {
            $data = [
                'responseType' => 0,
                'msg'          => "#LMRPT006887: Case not found against case_no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }
    }

    public function notPaidReGeneratepagination()
    {
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $remark_cat                = $this->input->post('remark_cat');
        $dist_code                 = $this->session->userdata('dist_code');
        $subdiv_code               = $this->session->userdata('subdiv_code');
        $cir_code                  = $this->session->userdata('cir_code');
        $s_code                    = $this->input->post('service');
        $status                    = $this->input->post('status');
        $is_cat                    = $this->input->post('is_category');
        $remark_cat                = $this->input->post('remark_cat');
        $mouza_pargona_code        = $this->input->post('mouza_pargona_code');
        $lot_no                    = $this->input->post('lot_no');
        $nr_cat                    = $this->input->post('nr_cat');
        $payment_status            = $this->input->post('payment_status');
        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved               = $this->input->post('co_approved');
        $sub_date                  = $this->input->post('sub_date');

        $draw                      = intval($this->input->post('draw'));
        $start                     = intval($this->input->post('start'));
        $length                    = intval($this->input->post('length'));
        $order                     = $this->input->post('order');

        $define_date               = define_date;

        $col    = 0;
        $dir    = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        if (! empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = [
            0 => 'settlement_basic.date_entry',
        ];

        if (! isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (! empty($searchByCol_0)) {

            $this->db->like('settlement_basic.case_no', strtoupper($searchByCol_0));
        }

        if (! empty($searchByCol_1)) {

            $this->db->like('settlement_basic.applid', strtoupper($searchByCol_1));
        }

        if (! empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(settlement_basic.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }

        if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
        }

        if (! empty($mouza_pargona_code)) {
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_pargona_code);
        }

        if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
            $this->db->where('settlement_basic.lot_no', $lot_no);
        }

        if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
            $this->db->where('settlement_basic.vill_townprt_code', $is_cat);
        }

        if(!empty($sub_date)){
            $this->db->where("CAST(settlement_basic.submission_date AS TEXT) LIKE", $sub_date . '%');
        }

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no', 'left');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no', 'left');
        $this->db->where('settlement_basic.dist_code', $dist_code );
        $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
        $this->db->where('settlement_basic.cir_code', $cir_code);
        $this->db->where('settlement_basic.status', 'N');
        //$this->db->where_in('settlement_basic.from_office', ['DPT', 'DC']);
        $this->db->where('settlement_basic.pending_officer', 'CO');
        $this->db->where('settlement_basic.service_code', $s_code);
        $this->db->where('settlement_basic.date_entry > ', $define_date);
        $this->db->where('settlement_premium.is_final', 1);
        $this->db->where('settlement_premium.grn_no IS NULL');
        $this->db->where('settlement_basic.review_flag', 0);
        $this->db->where_in('settlement_premium.area_name', [1,2,3,4,5,6,11,12,13,14,15,16,17]);

        $this->db->limit($length, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if (! empty($remark_cat)) { //settlement_ap_lmnote, lm_note
                $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
            }

            if (! empty($mouza_pargona_code)) {
                $this->db->where('settlement_basic.mouza_pargona_code', $mouza_pargona_code);
            }

            if (! empty($mouza_pargona_code) && ! empty($lot_no)) {
                $this->db->where('settlement_basic.lot_no', $lot_no);
            }

            if (! empty($lot_no) && ! empty($mouza_pargona_code) && ! empty($is_cat)) {
                $this->db->where('settlement_basic.vill_townprt_code', $is_cat);
            }

            if(!empty($sub_date)){
                $this->db->where("CAST(settlement_basic.submission_date AS TEXT) LIKE", $sub_date . '%');
            }

            $this->db->select('*');
            $this->db->from('settlement_basic');
            $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no', 'left');
            $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no', 'left');
            $this->db->where('settlement_basic.dist_code', $dist_code );
            $this->db->where('settlement_basic.subdiv_code', $subdiv_code);
            $this->db->where('settlement_basic.cir_code', $cir_code);
            $this->db->where('settlement_basic.status', 'N');
            //$this->db->where_in('settlement_basic.from_office', ['DPT', 'DC']);
            $this->db->where('settlement_basic.pending_officer', 'CO');
            $this->db->where('settlement_basic.service_code', $s_code);
            $this->db->where('settlement_basic.date_entry > ', $define_date);
            $this->db->where('settlement_premium.is_final', 1);
            $this->db->where('settlement_premium.grn_no IS NULL');
            $this->db->where('settlement_basic.review_flag', 0);
            $this->db->where_in('settlement_premium.area_name', [1,2,3,4,5,6,11,12,13,14,15,16,17]);
            $query1 = $this->db->get();

            $total_records = $query1->num_rows();

            foreach($result as $rows) {

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($rows->chitha_processing_details == 1) {
                    $lm_chitha_report = 'Yes';
                } elseif ($rows->chitha_processing_details == 2) {
                    $lm_chitha_report = 'Yes';
                } elseif ($rows->chitha_processing_details == 0) {
                    $lm_chitha_report = 'No';
                }

                if ($rows->chitha_processing_details == 2) {
                    $co_approved_status = 'Yes';
                } elseif ($rows->chitha_processing_details == 1) {
                    $co_approved_status = 'No';
                } elseif ($rows->chitha_processing_details == 0) {
                    $co_approved_status = 'No';
                }

                $khas_link = '';
                $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                <br>
                <a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCoNew?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                Payment Notice New</a>';

                $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', [$rows->case_no, 1]);

                if ($sqlgrn->num_rows() <= 0) {
                    $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                } else {
                    if (isset($sqlgrn->row()->grn_no)) {
                        if ($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '') {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        } else {
                            $grn_status = '<strong class="text-success">PAID</strong>';
                        }
                    } else {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    }
                }


                $json[] = [
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $nr_status,

                    // $rows->date_entry,
                    // date("Y-m-d", strtotime($rows->date_entry)),

                    // $lmnoteRemark,

                    $grn_status,
                    $lm_chitha_report,
                    $co_approved_status,

                    (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : ''),
                ];

                $i++;
            }

            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );
            echo json_encode($response);
        }
        else {
            $response                         = array();
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function notPaidReGeneratepaginationRural()
    {
        // =============================
        //  Access Control
        // =============================
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        if (!in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            return;
        }

        if (defined('LOT_BIFURCATE') && LOT_BIFURCATE == 1 && $user_desig_code == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        // =============================
        //  Inputs
        // =============================
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');

        $remark_cat         = $this->input->post('remark_cat');
        $s_code             = $this->input->post('service');
        $is_cat             = $this->input->post('is_category');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $sub_date           = $this->input->post('sub_date');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $search = $this->input->post('search')['value'] ?? '';

        $define_date = '2024-06-01';

        // =============================
        //  Ordering
        // =============================
        $valid_columns = [
            0 => 'settlement_basic.date_entry',
        ];

        $col = 0;
        $dir = 'asc';

        if (!empty($order)) {
            $col = $order[0]['column'];
            $dir = $order[0]['dir'];
        }

        if (isset($valid_columns[$col])) {
            $this->db->order_by($valid_columns[$col], $dir);
        }

        // =============================
        //  Build Main Query
        // =============================
        $this->db->distinct();
        $this->db->select('settlement_basic.*, settlement_ap_lmnote.lm_note');
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no', 'left');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no', 'left');
        $this->db->where([
            'settlement_basic.dist_code'       => $dist_code,
            'settlement_basic.subdiv_code'     => $subdiv_code,
            'settlement_basic.cir_code'        => $cir_code,
            'settlement_basic.status'          => 'N',
            'settlement_basic.pending_officer' => 'CO',
            'settlement_basic.service_code'    => $s_code,
            'settlement_basic.review_flag'     => 0,
            'settlement_premium.is_final'      => 1,
        ]);
        $this->db->where('settlement_basic.date_entry <', $define_date);
        $this->db->where('settlement_premium.grn_no IS NULL', null, false);
        $this->db->where_in('settlement_premium.area_name', [10]);

        // Optional Filters
        if (!empty($remark_cat)) {
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
        }
        if (!empty($mouza_pargona_code)) {
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_pargona_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('settlement_basic.lot_no', $lot_no);
        }
        if (!empty($is_cat)) {
            $this->db->where('settlement_basic.vill_townprt_code', $is_cat);
        }
        if (!empty($sub_date)) {
            $this->db->like('settlement_basic.submission_date', $sub_date, 'after');
        }

        // Pagination
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // =============================
        //  Safe Error Handling (CI3 + PostgreSQL)
        // =============================
        if (!$query || !($query instanceof CI_DB_result)) {
            $error_code = '';
            $error_msg  = '';

            if (method_exists($this->db, 'error')) {
                $db_error   = $this->db->error();
                $error_code = isset($db_error['code']) ? $db_error['code'] : '';
                $error_msg  = isset($db_error['message']) ? $db_error['message'] : '';
            } else {
                // Fallback for older CI3 versions
                $error_code = $this->db->_error_number();
                $error_msg  = $this->db->_error_message();
            }

            $error_text = ($error_msg !== '') ? $error_msg : 'Unknown database error occurred.';
            log_message('error', 'Query failed in ' . __METHOD__ . ' [' . $error_code . ']: ' . $error_text);

            echo json_encode(['error' => 'Database error: ' . $error_text]);
            return;
        }

        $result = $query->result();

        if (empty($result)) {
            echo json_encode(['error' => 'No records found.']);
            return;
        }

        // =============================
        //  Count Total Records
        // =============================
        $this->db->select('COUNT(DISTINCT settlement_basic.case_no) AS total_records', false);
        $this->db->from('settlement_basic');
        $this->db->join('settlement_ap_lmnote', 'settlement_basic.case_no = settlement_ap_lmnote.case_no', 'left');
        $this->db->join('settlement_premium', 'settlement_basic.case_no = settlement_premium.case_no', 'left');
        $this->db->where([
            'settlement_basic.dist_code'       => $dist_code,
            'settlement_basic.subdiv_code'     => $subdiv_code,
            'settlement_basic.cir_code'        => $cir_code,
            'settlement_basic.status'          => 'N',
            'settlement_basic.pending_officer' => 'CO',
            'settlement_basic.service_code'    => $s_code,
            'settlement_basic.review_flag'     => 0,
            'settlement_premium.is_final'      => 1,
        ]);
        $this->db->where('settlement_basic.date_entry <', $define_date);
        $this->db->where('settlement_premium.grn_no IS NULL', null, false);
        $this->db->where_in('settlement_premium.area_name', [10]);

        if (!empty($remark_cat)) {
            $this->db->where('settlement_ap_lmnote.lm_note', $remark_cat);
        }
        if (!empty($mouza_pargona_code)) {
            $this->db->where('settlement_basic.mouza_pargona_code', $mouza_pargona_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('settlement_basic.lot_no', $lot_no);
        }
        if (!empty($is_cat)) {
            $this->db->where('settlement_basic.vill_townprt_code', $is_cat);
        }
        if (!empty($sub_date)) {
            $this->db->like('settlement_basic.submission_date', $sub_date, 'after');
        }

        $query1 = $this->db->get();

        if (!$query1 || !($query1 instanceof CI_DB_result)) {
            $error_msg = method_exists($this->db, 'error')
                ? $this->db->error()['message']
                : $this->db->_error_message();
            log_message('error', 'Count query failed in ' . __METHOD__ . ': ' . $error_msg);
            echo json_encode(['error' => 'Database error while counting records.']);
            return;
        }

        $total_records = $query1->row()->total_records ?? 0;

        // =============================
        //  Build JSON Data
        // =============================
        $json = [];
        foreach ($result as $row) {

            $lmnoteRemark = (isset($row->lm_note) && trim($row->lm_note) == 1)
                ? 'Recommended' : 'Not Recommended';

            $lm_chitha_report = ($row->chitha_processing_details == 1 || $row->chitha_processing_details == 2)
                ? 'Yes' : 'No';

            $co_approved_status = ($row->chitha_processing_details == 2)
                ? 'Yes' : 'No';

            // Action Links
            $khas_link = '';
            if ($s_code == SETTLEMENT_KHAS_LAND_ID) {
                $khas_link = '
                    <a alt="View application" class="text-white btn btn-sm btn-success" target="_blank" 
                    href="' . base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $row->case_no) . '">
                        <i class="fa fa-lg fa-file-text"></i> Application
                    </a><br>
                    <a href="' . base_url('index.php/SettlementKhasCo/generatePaymentNoticeCoNewRural?case=' . $row->case_no) . '" 
                    class="btn-sm btn btn-primary mt-1">
                        Payment Notice New
                    </a>';
            }

            // GRN Check
            $sqlgrn = $this->db->query(
                'SELECT grn_no FROM settlement_premium WHERE case_no = ? AND is_final = 1 LIMIT 1',
                [$row->case_no]
            );

            $grn_status = ($sqlgrn->num_rows() > 0 && !empty($sqlgrn->row()->grn_no))
                ? '<strong class="text-success">PAID</strong>'
                : '<strong class="text-danger">NOT PAID</strong>';

            $json[] = [
                '<strong>' . $row->case_no . '</strong>',
                '<strong>' . $row->applid . '</strong>',
                $this->utilityclass->getMouzaName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code),
                $this->utilityclass->getLotName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no),
                $this->utilityclass->getVillageName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code),
                $grn_status,
                $lm_chitha_report,
                $co_approved_status,
                $khas_link,
            ];
        }

        // =============================
        //  Final JSON Response
        // =============================
        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $total_records,
            'recordsFiltered' => $total_records,
            'data'            => $json,
        ]);
    }



}
