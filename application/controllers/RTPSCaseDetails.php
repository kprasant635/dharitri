<?php
class RTPSCaseDetails extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('misreport/MisModel');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');

        $this->load->model('UtilsModel');
    }

    public function summary()
    {
        $data['names']  = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');


        $data['dist']  = $this->MisModel->getDistrictName($dist_code);
        $data['subdiv']  = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $data['circle']  = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);

        $data['mouzalist']  = $this->MisModel->getMouzaList($dist_code, $subdiv_code, $cir_code);


        $data['dist_code']  = $dist_code;
        $data['subdiv_code']  = $subdiv_code;
        $data['cir_code']  = $cir_code;
        $data['mouza_pargona_code']  = $mouza_pargona_code;
        $data['lot_no']  = $lot_no;

        $data['_view'] = 'RTPSCaseDetails/SummaryView';
        $this->load->view('layouts/main', $data);
    }

    function SummaryExcel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = 'https://basundhara.assam.gov.in/rtpsdemo/Reports/getCaseCount';
            $d = $this->session->userdata('dist_code');
            $s = $this->session->userdata('subdiv_code');
            $c = $this->session->userdata('cir_code');
            $from_date = $this->input->post('date_from');
            $to_date   = $this->input->post('date_to');

            if (empty($from_date) || empty($to_date)) {
                die("Please select both Date From and Date To");
            }

            $postData = [
                'd' => $d,
                's' => $s,
                'c' => $c,
                'from_date' => $from_date,
                'to_date'   => $to_date
            ];

            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, $url);
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $postData);
            $excel_data = curl_exec($cURL);
            $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
            curl_close($cURL);

            if ($httpcode != 200) {
                return false;
            }
            $data_array = json_decode($excel_data, true);
            $this->downloadExcel("Summary_" . time() . ".xlsx", $data_array);
        }
    }


    function downloadExcel($filename, $data_array)
    {
        require_once 'application/libraries/Xlsxwriter.class.php';
        ob_end_clean();
        $writer = new XLSXWriter();
        $writer->setAuthor('CodeIgniter Export');

        // Define header
        // $header = [
        //     'District' => 'string',
        //     'Circle'   => 'string',
        //     'Mouza'    => 'string',
        //     'Lot'      => 'string',
        //     'Village'  => 'string',
        //     'Received' => 'integer',
        //     'Delivered' => 'integer',
        //     'Rejected' => 'integer',
        //     'Pending' => 'integer'
        // ];

        $headers = array_fill_keys(array_keys($data_array[0]), 'string');

        $writer->writeSheetHeader('Sheet1', $headers, [
            'font' => 'Times New Roman',
            'font-size' => 12,
            'fill' => '#eee'
        ]);

        // Preprocess and write rows
        foreach ($data_array as $row) {
            $cleanRow = array_map('trim', $row); // remove extra spaces from all fields
            $writer->writeSheetRow('Sheet1', [
                $cleanRow['district'],
                $cleanRow['circle'],
                $cleanRow['mouza'],
                $cleanRow['lot'],
                $cleanRow['village'],
                (int) $cleanRow['received'],
                (int) $cleanRow['delivered'],
                (int) $cleanRow['rejected'],
                (int) $cleanRow['pending']
            ]);
        }

        // Send to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $writer->writeToStdOut();
        exit;
    }
}
