<?php

ini_set('memory_limit', '-1');

class TestController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('agri_stack_helper'));
        $this->load->model('BhunakshaIntegrationModel');
    }

    public function dbswitch($dist_code)
    {
        //$CI=&get_instance();
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($dist_code == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    



public function sqlToExcel(){
    // $district_codes=['07','15'];
    $district_param = $this->input->get('district_codes'); // Get the URL parameter
    $district_codes = explode(',', $district_param); 
    $this->load->model('UtilsModel');
    
    // Create ZIP in memory
    $zip = new ZipArchive();
    $zip_filename = 'Agricultural_Reports_' . date("d-M-Y-h-i-s-A") . '.zip';
    
    // Create temporary file for ZIP
    $temp_zip = tempnam(sys_get_temp_dir(), 'excel_zip');
    
    if ($zip->open($temp_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        die('Could not create ZIP file');
    }
    
    foreach($district_codes as $dist){
        $this->dbswitch($dist);
        // $sql="select * from chitha_basic limit 10";
$lac=[
1	 =>'Bajali',
2	 =>'Barpeta (SC)',
3	 =>'Bhowanipur-Sorbhog',
4	 =>'Pakabetbari',
5	 =>'Pakabetbari',
6	 =>'Mandia',
7	 =>'Barpeta (SC)',
8	 =>'Chenga',
9	 =>'Bhowanipur-Sorbhog',
10	=>'Bongaigaon?',
11	=>'Srijangram',
12	=>'Barkhetri',
13	=>'Behali(SC)',
14	=>'Biswanath',
15	=>'Gahpur',
16	=>'Sootea',
17	=>'Abhayapuri',
18	=>'Bongaigaon',
19	=>'Sonai',
20	=>'Udharbond',
21	=>'Lakhipur',
22	=>'Narsingpur(SC)',
23	=>'Barkhola',
24	=>'Silchar',
25	=>'Katigora',
26	=>'Algapur',
27	=>'SRIBHUMI North',
28	=>'Mahmora',
29	=>'Sonari',
30	=>'Dalgaon',
31	=>'Mangaldoi',
32	=>'Sipajhar',
33	=>'Dhemaji(ST)',
34	=>'Sissibargaon',
35	=>'Jonai(ST)',
36	=>'Golakganj',
37	=>'Gauripur',
38	=>'Bilasipara',
39	=>'Birsing Jarua',
40	=>'Dhubri',
41	=>'Golakganj *',
42	=>'Khowang',
43	=>'Dibrugarh',
44	=>'Tingkhong',
45	=>'Naharkatia',
46	=>'Duliajan',
47	=>'Chabua-Lahowal',
48	=>'Goalpara West(ST)',
49	=>'Goalpara East',
50	=>'Jaleswar',
51	=>'Dudhnai (ST)',
52	=>'Khumtai',
53	=>'Dergaon',
54	=>'Golaghat',
55	=>'Sarupather',
56	=>'Bokakhat',
57	=>'Algapur-Katlicherra',
58	=>'Hailakandi',
59	=>'Katigora',
60	=>'Barhampur',
61	=>'Binnakandi',
62	=>'Lumding',
63	=>'Hojai',
64	=>'Titabar',
65	=>'Jorhat',
66	=>'Mariani',
67	=>'Teok',
68	=>'Kamalpur',
69	=>'Hajo-Sualkuchi(SC)',
70	=>'Rangia',
71	=>'Boko-Chaygaon(ST)',
72	=>'Chamaria',
73	=>'Palashbari',
74	=>'Dimoria(SC)',
75	=>'Jagiroad(SC)',
76	=>'Jalukbari',
77	=>'Ram Krishna Nagar(SC)',
78	=>'Patharkandi',
79	=>'SRIBHUMI South',
80	=>'Nowboicha(SC)',
81	=>'Lakhimpur',
82	=>'Dhakuakhana(ST)',
83	=>'Ronganadi',
84	=>'Bihpuria',
85	=>'Majuli(ST)',
86	=>'Dergaon',
87	=>'Laharighat',
88	=>'Morigaon',
89	=>'Samaguri',
90	=>'Barhampur',
91	=>'Kaliabor',
92	=>'Nagaon-Batadraba',
93	=>'Dhing',
94	=>'Rupahihat',
95	=>'Raha(SC)',
96	=>'Hojai',
97	=>'Nalbari',
98	=>'Barkhetri',
99	=>'Tihu',
100=>'	Nazira',
101=>'	Sibsagar',
102=>'	Demow',
103=>'	Rangapara',
104=>'	Naduar',
105=>'	Tezpur',
106=>'	Dhekiajuli',
107=>'	Barchalla',
108=>'	Mankachar',
109=>'	Makum',
110=>'	Tinsukia',
111=>'	Doomdooma',
112=>'	Digboi',
113=>'	Sadiya',
114=>'	Margherita',
115=>'	Dispur',
116=>'	New Guwahati',
117=>'	Guwahati Central'
];

        $sql="SELECT sb.dist_code,
                        sb.subdiv_code,
                        sb.cir_code,
                        sb.mouza_pargona_code,
                        sb.lot_no,
                        sb.vill_townprt_code,
                        sb.case_no,
                        Upper(ins_name_co) AS InstituteName,
                        pdar_mobile,
                        lt.lac_id,
                        CASE
                            WHEN ap.co_operative_registered = 'Y' THEN 'Yes'
                            ELSE 'No'
                        END                AS registered,
                        CASE
                            WHEN si.registration_certificate_notice = 'Y' THEN 'Yes'
                            ELSE 'No'
                        END                AS RegistrationNotice_Issued,
                        sb.status
                    FROM   settlement_basic sb
                        JOIN settlement_institution_details si
                            ON sb.case_no = si.case_no
                        JOIN settlement_ap_lmnote ap
                            ON sb.case_no = ap.case_no
                        JOIN settlement_applicant app
                            ON sb.case_no = app.case_no
                        JOIN lac_transactions lt
                        ON sb.dist_code = lt.dist_code
                        AND sb.subdiv_code = lt.subdiv_code
                        AND sb.cir_code = lt.cir_code
                        AND sb.mouza_pargona_code = lt.mouza_pargona_code
                        AND sb.lot_no = lt.lot_no
                        AND sb.vill_townprt_code = lt.vill_townprt_code
                    WHERE  sb.service_code IN ( 45 )
                        AND sb.status IN ( 'M', 'N' )
                        AND si.ins_cat_type_co IN ( '12' )
                        AND app.pdar_type = 'B' 
                    ";
        $data = $this->db->query($sql)->result_array();
        // $results = $query->result_array();
        foreach ($data as &$row) {
            $lac_id = (int) $row['lac_id'];
            $row['lac_name'] = isset($lac[$lac_id]) ? $lac[$lac_id] : 'Unknown';
        }
        unset($row);

        $time = date("d-M-Y-h-i-s-A");
        $file_name = $dist."(Agri-pattadar)".$time.".xlsx";
        
        // Generate Excel content in memory
        $excel_content = $this->generateExcelContent($data);
        
        // Add Excel content to ZIP
        $zip->addFromString($file_name, $excel_content);
    }
    
    $zip->close();
    
    // Download the ZIP file
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.$zip_filename.'"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($temp_zip));
    
    ob_clean();
    flush();
    
    // Output the ZIP file
    readfile($temp_zip);
    
    // Clean up temporary ZIP file
    unlink($temp_zip);
    
    exit;
}

function generateExcelContent($result_array) {
    require_once 'application/libraries/xlsxwriter.class.php';
    
    // Prepare headers
    foreach($result_array[0] as $key=>$head) {
        $final_head[$key]='string';
    }
    
    $styles1 = array( 
        'font'=>'Arial',
        'font-size'=>14,
        'font-style'=>'bold', 
        'fill'=>'#FFFF00',
        'halign'=>'center', 
        'border'=>'left,right,top,bottom'
    );
    $styles7 = array( 'border'=>'left,right,top,bottom');
    
    // Create Excel in memory
    $writer = new XLSXWriter();
    $writer->setAuthor('Dharitree');
    $writer->writeSheetHeader('Sheet1', $final_head, $styles1);
    
    foreach($result_array as $row) {
        $writer->writeSheetRow('Sheet1', (array)$row, $styles7);
    }
    
    // Get Excel content as string
    ob_start();
    $writer->writeToStdOut();
    $excel_content = ob_get_contents();
    ob_end_clean();
    
    return $excel_content;
}

// ALTERNATIVE METHOD: Using temporary files (cleaner approach)
public function sqlToExcelAlternative(){
    $district_codes=['07','15'];
    $this->load->model('UtilsModel');
    
    $zip = new ZipArchive();
    $zip_filename = 'Agricultural_Reports_' . date("d-M-Y-h-i-s-A") . '.zip';
    
    // Create temporary file for ZIP
    $temp_zip = tempnam(sys_get_temp_dir(), 'excel_zip');
    
    if ($zip->open($temp_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        die('Could not create ZIP file');
    }
    
    foreach($district_codes as $dist){
        $sql="select * from chitha_basic limit 10";
        $data = $this->db->query($sql)->result_array();
        $time = date("d-M-Y-h-i-s-A");
        $file_name = $dist."(Agri-pattadar)".$time.".xlsx";
        
        // Create temporary Excel file
        $temp_excel = $this->createTempExcelFile($data);
        
        // Add to ZIP and delete temp file
        $zip->addFile($temp_excel, $file_name);
    }
    
    $zip->close();
    
    // Download the ZIP
    $this->downloadZipFile($temp_zip, $zip_filename);
    
    // Cleanup
    unlink($temp_zip);
}

function createTempExcelFile($result_array) {
    require_once 'application/libraries/xlsxwriter.class.php';
    
    // Create temporary file
    $temp_file = tempnam(sys_get_temp_dir(), 'excel_temp');
    
    foreach($result_array[0] as $key=>$head) {
        $final_head[$key]='string';
    }
    
    $styles1 = array( 
        'font'=>'Arial',
        'font-size'=>14,
        'font-style'=>'bold', 
        'fill'=>'#FFFF00',
        'halign'=>'center', 
        'border'=>'left,right,top,bottom'
    );
    $styles7 = array( 'border'=>'left,right,top,bottom');
    
    $writer = new XLSXWriter();
    $writer->setAuthor('Dharitree');
    $writer->writeSheetHeader('Sheet1', $final_head, $styles1);
    
    foreach($result_array as $row) {
        $writer->writeSheetRow('Sheet1', (array)$row, $styles7);
    }
    
    $writer->writeToFile($temp_file);
    
    return $temp_file;
}

function downloadZipFile($zip_path, $zip_filename) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.$zip_filename.'"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zip_path));
    
    ob_clean();
    flush();
    readfile($zip_path);
    exit;
}

// BONUS: Progress tracking version (if you need to show progress)
public function sqlToExcelWithProgress(){
    // Store progress in session
    $_SESSION['excel_progress'] = 0;
    
    $district_codes=['07','15'];
    $total_districts = count($district_codes);
    $this->load->model('UtilsModel');
    
    $zip = new ZipArchive();
    $zip_filename = 'Agricultural_Reports_' . date("d-M-Y-h-i-s-A") . '.zip';
    $temp_zip = tempnam(sys_get_temp_dir(), 'excel_zip');
    
    if ($zip->open($temp_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        die('Could not create ZIP file');
    }
    
    foreach($district_codes as $index => $dist){
        $sql="select * from chitha_basic limit 10";
        $data = $this->db->query($sql)->result_array();
        $time = date("d-M-Y-h-i-s-A");
        $file_name = $dist."(Agri-pattadar)".$time.".xlsx";
        
        $excel_content = $this->generateExcelContent($data);
        $zip->addFromString($file_name, $excel_content);
        
        // Update progress
        $_SESSION['excel_progress'] = round((($index + 1) / $total_districts) * 100);
    }
    
    $zip->close();
    
    $_SESSION['excel_progress'] = 100;
    
    $this->downloadZipFile($temp_zip, $zip_filename);
    unlink($temp_zip);
}

// AJAX endpoint to check progress
public function getExcelProgress() {
    header('Content-Type: application/json');
    $progress = isset($_SESSION['excel_progress']) ? $_SESSION['excel_progress'] : 0;
    echo json_encode(['progress' => $progress]);
}

}
