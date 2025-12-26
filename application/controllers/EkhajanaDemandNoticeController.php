<?php
include 'vendor/mpdf/vendor/autoload.php';
        
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaDemandNoticeController extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->model('eKhajana/DemandNotice/DemandNoticeModel');
        $this->load->model('LAC_model');
        $this->dbswitch();
    }

    //db switch method
    public function dbswitch(){
        //$CI=&get_instance();
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);    
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);    
            } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);       
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);    
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);    
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);    
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);    
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);    
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);    
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);    
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);   
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);   
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);   
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);   
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);   
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);   
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);   
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);   
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);   
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);   
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);   
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);   
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
        }  else if($this->session->userdata('dist_code') == "22"){
            $this->db=$this->load->database('dha41', TRUE);   
        }  else if($this->session->userdata('dist_code') == "23"){
            $this->db=$this->load->database('dha40', TRUE);   
        }
    }

    public function mouzadari() {

        $dist_code = $this->session->userdata['dist_code'];
        $subdiv_code = $this->session->userdata['subdiv_code'];
        $cir_code = $this->session->userdata['cir_code'];

        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;

        $data['mouzas'] = $this->DemandNoticeModel->getMouzas($dist_code, $subdiv_code, $cir_code);

        $data['_view'] = 'e_khajana/mouzadari_demand_notice/mouzadari';
        $this->load->view('layouts/main',$data);
        
    }

    public function index($direct_paying = false) {
        // Get direct_paying from GET parameter if not passed in URL
        $direct_paying = $this->input->get('dp') ?? $direct_paying;
        if($this->session->userdata['user_desig_code'] =='ADC'){
            $direct_paying = true;  
        }else{
            $direct_paying = false;  
        } 
        
        $dist_code = $this->input->get('dist_code') != false ? $this->input->get('dist_code') :  $this->session->userdata['dist_code'];
        $subdiv_code = $this->input->get('subdiv_code') != false ? $this->input->get('subdiv_code') : $this->session->userdata['subdiv_code'];
        $cir_code = $this->input->get('cir_code') != false ? $this->input->get('cir_code') : $this->session->userdata['cir_code'];
        $mouza_pargona_code = $this->input->get('mouza_pargona_code') != false ? $this->input->get('mouza_pargona_code') : false;
        $village_pargona_code = $this->input->get('village_pargona_code') != false ? $this->input->get('village_pargona_code') : false;
        $list = $this->DemandNoticeModel->get_demand_notice_list($dist_code, $subdiv_code, $cir_code,  $mouza_pargona_code, $village_pargona_code, $direct_paying);

        $data['pending_list'] = $list;
        $data['_view'] = 'e_khajana/dp_demand_notice/demand_notice_index';
        $this->load->view('layouts/main',$data);
    }

    public function generateDpDemandNotice() {
        
        $data['dist_code'] = $this->input->post('dist_code');
        $data['subdiv_code'] = $this->input->post('subdiv_code');
        $data['cir_code'] = $this->input->post('cir_code');
        $data['mouza_pargona_code'] = $this->input->post('mouza_pargona_code');
        $data['lot_no'] = $this->input->post('lot_no');
        $data['vill_townprt_code'] = $this->input->post('vill_townprt_code');
        $data['patta_type_code'] = $this->input->post('patta_type_code');
        $data['patta_no'] = $this->input->post('patta_no');
    
        $arrear_details = $this->DemandNoticeModel->getArrearDetailsDpEstate($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        $data['arrear_details'] = $arrear_details;
        $pattadar_rows = array_reverse($this->DemandNoticeModel->getPattadarNames(
            $data['dist_code'], 
            $data['subdiv_code'], 
            $data['cir_code'], 
            $data['mouza_pargona_code'], 
            $data['lot_no'], 
            $data['vill_townprt_code'], 
            $data['patta_type_code'], 
            $data['patta_no']
        ));
        
        $pattadar_names = [];
        $count = 1;
        
        foreach ($pattadar_rows as $row) {
            if ($count > 5) {
                break;
            }
            $pattadar_names[] = "$count $row->pdar_name";
            $count++;
        }
        
        $data['pattadar_names'] = implode(', ', $pattadar_names);

        // Assuming these parameters are passed to the function
        $sql = "select u.username from loginuser_table lut join users u on lut.user_code =u.user_code where lut.dist_code=? and lut.subdiv_code=? and lut.cir_code=? and u.user_desig_code='CO' and lut.dis_enb_option ='E' and lut.user_map='y'";
        $result = $this->db->query($sql, [$data['dist_code'], $data['subdiv_code'], $data['cir_code']])->row();
        $data['circle_officer_name'] = $result->username;

        $data['_view'] = 'e_khajana/dp_demand_notice/demand_notice';
        $this->load->view('layouts/main', $data);
    }

    function downloadNotice() {
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'arial'
        ]);
        
        $data['dist_code'] = $this->input->post('dist_code');
        $data['subdiv_code'] = $this->input->post('subdiv_code');
        $data['cir_code'] = $this->input->post('cir_code');
        $data['mouza_pargona_code'] = $this->input->post('mouza_pargona_code');
        $data['lot_no'] = $this->input->post('lot_no');
        $data['vill_townprt_code'] = $this->input->post('vill_townprt_code');
        $data['patta_type_code'] = $this->input->post('patta_type_code');
        $data['patta_no'] = $this->input->post('patta_no');
    
        $arrear_details = $this->DemandNoticeModel->getArrearDetails($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        $data['arrear_details'] = $arrear_details;

        $pattadar_rows = array_reverse($this->DemandNoticeModel->getPattadarNames(
            $data['dist_code'], 
            $data['subdiv_code'], 
            $data['cir_code'], 
            $data['mouza_pargona_code'], 
            $data['lot_no'], 
            $data['vill_townprt_code'], 
            $data['patta_type_code'], 
            $data['patta_no']
        ));
        
        $pattadar_names = [];
        $count = 1;
        
        foreach ($pattadar_rows as $row) {
            if ($count > 5) {
                break;
            }
            $pattadar_names[] = "$count $row->pdar_name";
            $count++;
        }
        
        // Convert the array to a comma-separated string
        $data['pattadar_names'] = implode(', ', $pattadar_names);

        // Assuming these parameters are passed to the function
        $sql = "select u.username from loginuser_table lut join users u on lut.user_code =u.user_code where lut.dist_code=? and lut.subdiv_code=? and lut.cir_code=? and u.user_desig_code='CO' and lut.dis_enb_option ='E' and lut.user_map='y'";
        $result = $this->db->query($sql, [$data['dist_code'], $data['subdiv_code'], $data['cir_code']])->row();
        $data['circle_officer_name'] = $result->username;

        $data['_view'] = 'e_khajana/dp_demand_notice/demand_notice_download';
        $this->load->view('layouts/main', $data);
        
        $mpdf->SetWatermarkText('Demand Notice');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
    
        // Load view with proper parameters
        $html = $this->load->view('e_khajana/dp_demand_notice/demand_notice_download', ['for_pdf' => true, 'data' => $data], true);
        
        // Add basic PDF styling

        $mpdf->WriteHTML('<style>td{padding:5px;}</style>');
        $mpdf->WriteHTML($html);
        
        $mpdf->Output('demand_notice.pdf', 'D'); // Direct download
    }

    public function generateDpDemandNoticeAssamese() {
        
        $data['dist_code'] = $this->input->post('dist_code');
        $data['subdiv_code'] = $this->input->post('subdiv_code');
        $data['cir_code'] = $this->input->post('cir_code');
        $data['mouza_pargona_code'] = $this->input->post('mouza_pargona_code');
        $data['lot_no'] = $this->input->post('lot_no');
        $data['vill_townprt_code'] = $this->input->post('vill_townprt_code');
        $data['patta_type_code'] = $this->input->post('patta_type_code');
        $data['patta_no'] = $this->input->post('patta_no');
    
        $arrear_details = $this->DemandNoticeModel->getArrearDetails($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        $data['arrear_details'] = $arrear_details;

        $pattadar_rows = $this->DemandNoticeModel->getPattadarNames($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        
        $pattadar_names = [];
        $count = 1;
        
        foreach ($pattadar_rows as $row) {
            if ($count > 5) {
                break;
            }
            $pattadar_names[] = "$count $row->pdar_name";
            $count++;
        }
        
        $data['pattadar_names'] = implode(', ', $pattadar_names);
        $data['_view'] = 'e_khajana/dp_demand_notice/demand_notice_assamese';
        $this->load->view('layouts/main', $data);
    }


    function downloadNoticeAssamese() {
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'freesans' // Supports Indic scripts
        ]);
        
        $data['dist_code'] = $this->input->post('dist_code');
        $data['subdiv_code'] = $this->input->post('subdiv_code');
        $data['cir_code'] = $this->input->post('cir_code');
        $data['mouza_pargona_code'] = $this->input->post('mouza_pargona_code');
        $data['lot_no'] = $this->input->post('lot_no');
        $data['vill_townprt_code'] = $this->input->post('vill_townprt_code');
        $data['patta_type_code'] = $this->input->post('patta_type_code');
        $data['patta_no'] = $this->input->post('patta_no');
    
        $arrear_details = $this->DemandNoticeModel->getArrearDetails($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        $data['arrear_details'] = $arrear_details;

        $pattadar_rows = $this->DemandNoticeModel->getPattadarNames($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        
        $pattadar_names = [];
        $count = 1;
        
        foreach ($pattadar_rows as $row) {
            if ($count > 5) {
                break;
            }
            $pattadar_names[] = "$count $row->pdar_name";
            $count++;
        }
        
        $data['pattadar_names'] = implode(', ', $pattadar_names);
        

        $mpdf->SetWatermarkText('Demand Notice');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
    
        // Load view with proper parameters
        $html = $this->load->view('e_khajana/dp_demand_notice/demand_notice_assamese_download', ['for_pdf' => true, 'data' => $data], true);
        
        // Add basic PDF styling

        $mpdf->WriteHTML('<style>td{padding:5px;} .spacebetween{display:flex;justify-content:space-between;}</style>');
        $mpdf->WriteHTML($html);
        
        $mpdf->Output('demand_notice.pdf', 'D'); // Direct download
    }

    function testAssamese() {
        // Configure mPDF with Assamese font
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'freesans',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);
    
       
        // HTML with proper meta tags and styling
        $html = '
        <html lang="as">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <style>
                body { font-family: freesans; }
                th { font-weight: normal; } /* Disable bold if font lacks bold support */
            </style>
        </head>
        <body>
            <table>
                <tr>
                    <th>অসমীয়া টেক্সট (Header)</th>
                    <td>অসমীয়া টেক্সট (Data)</td>
                </tr>
            </table>
        </body>
        </html>';
    
        $mpdf->WriteHTML($html);
        $mpdf->Output('test.pdf', 'D');
    }

    function getCircles() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        
        $circles = $this->DemandNoticeModel->getCircles($dist_code, $subdiv_code);
        echo json_encode($circles);
    }

    function getMouzas() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        
        $circles = $this->DemandNoticeModel->getCircles($dist_code, $subdiv_code);
        echo json_encode($circles);
    }

    function getVillages() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        
        $circles = $this->DemandNoticeModel->getVillages($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        echo json_encode($circles);
    }

    // ******************************************************

    public function landing_page()
    {
        $dist_code = $this->session->userdata['dist_code'];
        if($this->session->userdata['user_desig_code'] =='ADC'){
            $direct_paying = true;  
        }else{
            $direct_paying = false;  
        } 
        $generate_count = $this->DemandNoticeModel->get_demand_notice_count($dist_code,$direct_paying);
        $data['generate_count'] = $generate_count;
        $view_count = $this->DemandNoticeModel->get_demand_notice_generated_count($dist_code,$direct_paying);
        $data['view_count'] = $view_count;
        $data['_view'] = 'e_khajana/dp_demand_notice/landing_page';
        $this->load->view('layouts/main',$data);
    }

    public function index_directPaying($direct_paying = false) {
        $direct_paying = $this->input->get('dp') ?? $direct_paying;
        if($this->session->userdata['user_desig_code'] =='ADC'){
            $direct_paying = true;  
        }else{
            $direct_paying = false;  
        } 
        $dist_code = $this->session->userdata('dist_code');
        $list = $this->DemandNoticeModel->get_dp_demand_notice_list_by_district($dist_code,$direct_paying);
        $data['pending_list'] = $list;
        $data['_view'] = 'e_khajana/dp_demand_notice/demand_notice_index';
        $this->load->view('layouts/main',$data);
    }

    function downloadDpNotice() {
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'arial'
        ]);
        
        $data['dist_code'] = $dist_code = $this->input->post('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->input->post('subdiv_code');
        $data['cir_code'] = $cir_code = $this->input->post('cir_code');
        $data['mouza_pargona_code'] = $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $data['lot_no'] = $lot_no = $this->input->post('lot_no');
        $data['vill_townprt_code'] = $vill_townprt_code = $this->input->post('vill_townprt_code');
        $data['patta_type_code'] = $patta_type_code =  $this->input->post('patta_type_code');
        $data['patta_no'] = $patta_no =  $this->input->post('patta_no');
    
        $arrear_details = $this->DemandNoticeModel->getArrearDetailsDpEstate($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code'], $data['patta_type_code'], $data['patta_no']);
        $data['arrear_details'] = $arrear_details;

        $pattadar_rows = array_reverse($this->DemandNoticeModel->getPattadarNames(
            $data['dist_code'], 
            $data['subdiv_code'], 
            $data['cir_code'], 
            $data['mouza_pargona_code'], 
            $data['lot_no'], 
            $data['vill_townprt_code'], 
            $data['patta_type_code'], 
            $data['patta_no']
        ));
        
        $pattadar_names = [];
        $count = 1;
        
        foreach ($pattadar_rows as $row) {
            if ($count > 5) {
                break;
            }
            $pattadar_names[] = "$count $row->pdar_name";
            $count++;
        }
        
        // Convert the array to a comma-separated string
        $data['pattadar_names'] = implode(', ', $pattadar_names);

        // Assuming these parameters are passed to the function
        $sql = "select u.username from loginuser_table lut join users u on lut.user_code =u.user_code where lut.dist_code=? and lut.subdiv_code=? and lut.cir_code=? and u.user_desig_code='CO' and lut.dis_enb_option ='E' and lut.user_map='y'";
        $result = $this->db->query($sql, [$data['dist_code'], $data['subdiv_code'], $data['cir_code']])->row();
        $data['circle_officer_name'] = $result->username;

        $data['_view'] = 'e_khajana/dp_demand_notice/demand_notice_download';
        $this->load->view('layouts/main', $data);

        //check whether demand notice has been generated earlier

        $checkDemandGenerated = $this->db->query("select demand_notice_file_path from dp_demand_notice_delivery_docs where dist_code=? 
        and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?",
        array($dist_code, $subdiv_code , $cir_code , $mouza_pargona_code , $lot_no , $vill_townprt_code , $patta_type_code,$patta_no))->row();

        if ($checkDemandGenerated != null) {
            $view_url = base_url('index.php/EkhajanaDemandNoticeController/viewDemandNoticeGenerated');

            echo '
                <div style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f8f9fa;
                ">
                    <div style="
                        padding: 20px;
                        background-color: #fff3cd;
                        color: #856404;
                        border: 1px solid #ffeeba;
                        border-radius: 8px;
                        text-align: center;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    ">
                        <p style="font-size: 18px; font-weight: bold;">
                            Demand Notice has already been generated.
                        </p>
                        <p style="margin-bottom: 20px;">
                            Please click the button below to view and download it from the <strong>View Demand Notice</strong> section.
                        </p>
                        <a href="' . $view_url . '" target="_blank" style="
                            display: inline-block;
                            padding: 10px 25px;
                            background-color:rgb(20, 75, 9);
                            color: #fff;
                            text-decoration: none;
                            border-radius: 5px;
                            font-weight: bold;
                            font-size: 16px;
                        ">View Demand Notice</a>
                    </div>
                </div>
            ';
            exit;
        }

        $mpdf->SetWatermarkText('Demand Notice');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
    
        // Load view with proper parameters
        $html = $this->load->view('e_khajana/dp_demand_notice/demand_notice_download', ['for_pdf' => true, 'data' => $data], true);
        
        // Add basic PDF styling

        $mpdf->WriteHTML('<style>td{padding:5px;}</style>');
        $mpdf->WriteHTML($html);
        
        $mpdf->Output('demand_notice.pdf', 'D'); // Direct download
        // File saving
        $file_name = 'dp_demand_notice_' . $data['dist_code'] . '_' . $data['patta_no'] . '_' . time() . '.pdf';
        $file_path = FCPATH . 'uploads/dp_demand_notices/' . $file_name;

        // Ensure directory exists
        if (!is_dir(FCPATH . 'uploads/dp_demand_notices/')) {
            mkdir(FCPATH . 'uploads/dp_demand_notices/', 0777, true);
        }

        $mpdf->Output($file_path, \Mpdf\Output\Destination::FILE);
        $this->db->trans_begin();
        $tstatus2 = $this->db->insert('dp_demand_notice_delivery_docs', [
            'dist_code'                 => $data['dist_code'],
            'subdiv_code'               => $data['subdiv_code'],
            'cir_code'                  => $data['cir_code'],
            'mouza_pargona_code'        => $data['mouza_pargona_code'],
            'lot_no'                    => $data['lot_no'],
            'vill_townprt_code'         => $data['vill_townprt_code'],
            'patta_type_code'           => $data['patta_type_code'],
            'patta_no'                  => $data['patta_no'],
            'demand_notice_file_path'   => $file_path,
            'created_at'                => date('Y-m-d h:i:s'),
            'user_code'                 => $this->session->all_userdata()['user_code'],
            'status'                    => 'G', // g for generated
            'user_data'                 => json_encode($this->session->all_userdata()), 
            'ip_address'                => $this->session->all_userdata()['ip_address'],
        ]);

        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHDPDEMANDERR001, Error in insert on dp_demand_notice_delivery_docs table with query- ". json_encode($this->db->last_query()));
            echo 'Some error occured, Error-Code : #EKHDPDEMANDERR001';
            exit;
        }
        // update notice generated in arrear table
        $update_data = array(
            'notice_generated' => '1',
            'modified_at' => date('Y-m-d h:i:s')
        ); 
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->where('patta_type_code', $patta_type_code);
        $this->db->where('patta_no', $patta_no);
        $this->db->update('ekhajana_year_wise_arrear_dp_estate', $update_data);
        if($this->db->affected_rows() <= 0){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHDPDEMANDERR002, Error in update  table 'ekhajana_year_wise_arrear_dp_estate' with query- ". json_encode($this->db->last_query()));
             echo 'Some error occured, Error-Code : #EKHDPDEMANDERR002';
            exit;
        }else{
            $this->db->trans_commit();
            force_download($file_path, NULL);
        }
    }

    public function viewDemandNoticeGenerated()
    {
        $dist_code = $this->session->userdata('dist_code');
        $list = $this->DemandNoticeModel->get_dp_demand_notice_generated_by_district($dist_code);
        $data['generated_list'] = $list;
        $data['_view'] = 'e_khajana/dp_demand_notice/generated_dp_demand_notice_list';
        $this->load->view('layouts/main',$data);
    }

    public function viewDemandNotice($demand_id)
    {
        $query = $this->db->query("select demand_notice_file_path from dp_demand_notice_delivery_docs where id=?",array($demand_id))->row();

        if($query != null)
        {
            $file_name = $query->demand_notice_file_path;
            header('Content-type: application/pdf;charset=utf-8');
            echo file_get_contents($file_name); 
        }
    }
}
    

