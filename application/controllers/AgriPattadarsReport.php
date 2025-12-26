<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgriPattadarsReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('agripattadars/LandModel');
    }

    public function index() {
        $data['villages'] = $this->LandModel->get_all_village_uuids($this->db);
        $data['_view']='agripattadars/village_list';
        $this->load->view('layouts/main',$data);
    }

    public function download_excel($village_uuid) {
    // Clean any previous output and turn off output buffering
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Start output buffering to capture any unwanted output
    ob_start();
    
    require_once(APPPATH . 'libraries/Xlsxwriter.class.php');
    
    $this->load->model('agripattadars/LandModel');
    $village = $this->LandModel->get_village_name($this->db, $village_uuid);
    $agriDb = $this->load->database('agri_stack', true);
    $records = $this->LandModel->get_patta_records_by_village($this->db, $agriDb, $village_uuid);

    $filename = "report_" . trim($village['village_name_eng']) . "_{$village['village_uuid']}.xlsx";
    
    // Create writer and build Excel content in memory
    $writer = new XLSXWriter();

    $writer->writeSheetRow('Sheet1', [
        "District: " . ($village['district'] ?? ''),
        "Circle: " . ($village['circle'] ?? ''),
        "Mouza: " . ($village['mouza'] ?? ''),
        "Lot: " . ($village['lot'] ?? ''),
        "Village: " . ($village['village_name_asm'] ?? '')
    ], ['font-style' => 'bold', 'font-size' => 12]);

    $writer->writeSheetRow('Sheet1', []); // Blank row
    $writer->writeSheetRow('Sheet1', []); // Blank row
    $writer->writeSheetRow('Sheet1', []); // Blank row

    // Set header
    $headers = [
        'Patta Type' => 'string',
        'Patta No' => 'string',
        'DAG No' => 'integer',
        'Farm ID' => 'string',
        'Farmer ID' => 'string',
        'Pattadar Name' => 'string',
        'Gurdian\'s Name' => 'string'
    ];
    $writer->writeSheetHeader('Sheet1', $headers);
    $writer->writeSheetRow('Sheet1', array_keys($headers), ['font-style' => 'bold']); // actual row
    
    // Write data
    foreach ($records as $r) {
        $writer->writeSheetRow('Sheet1', [
            $r['patta_type'],
            $r['patta_no'],
            $r['dag_no'],
            $r['farm_plot_id'],
            '',
            $r['pdar_name'],
            $r['pdar_father']
        ]);
    }

    // Insert into history table
    $user_code = $this->session->userdata('user_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $ip = $this->input->ip_address();
    $uuid = $village_uuid;
    $village_name = $village['village_name_eng'];
    
    $historyData = [
        'dist_code'    => $dist_code,
        'subdiv_code'  => $subdiv_code,
        'cir_code'     => $cir_code,
        'user_code'    => $user_code,
        'ip'           => $ip,
        'uuid'         => $uuid,
        'village_name' => $village_name,
        'date_time'    => date('Y-m-d H:i:s'),
        'user_agent'   => $this->input->user_agent(),
        'file_name'    => $filename
    ];
    $this->db->insert('download_records_history', $historyData);

    // Clean any output that might have been generated
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set headers BEFORE any output
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        // Ensure no whitespace is sent before the file content
        $writer->writeToStdOut();
        exit;
    }
}
