<?php

class LACControler extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LAC_model');
    }

    public function index($lac_id = null)
    {
    
        $dist_code = $this->session->userdata['dist_code'];

        $data['districts'] = $this->LAC_model->getDistricts();
        $data['lacs'] = $this->LAC_model->getLAC($dist_code);
        $data['lac_id'] = $lac_id; // Pass the lac_id to view

        $data['_view'] = 'lac/index';
        $this->load->view('layouts/main', $data);
    }

    public function getSubdivisions()
    {
        $dist_code = $this->input->post('dist_code');
        if ($dist_code) {
            $subdivisions = $this->LAC_model->getSubdivisionsByDistrict($dist_code);
            echo json_encode($subdivisions);
        }
    }

    public function getSubdivisionName()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        if ($subdiv_code) {
            $subdivision = $this->LAC_model->getSubdivisionName($dist_code, $subdiv_code);
            echo json_encode($subdivision);
        }
    }

    public function getVillages()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        if ($subdiv_code) {
            $villages = $this->LAC_model->getVillagesBySubdivision($dist_code, $subdiv_code);
            echo json_encode($villages);
        }
    }

    public function getAllVillages()
    {
        $dist_code = $this->input->post('dist_code');
        if ($dist_code) {
            $villages = $this->LAC_model->getAllVillagesByDistrict($dist_code);
            echo json_encode($villages);
        }
    }

    public function process()
    {
        $data = array(
            'lac_id' => $this->input->post('lac'),
            'district_id' => $this->input->post('district'),
            'subdivision_id' => $this->input->post('subdivision'),
            'adc_id' => $this->session->userdata('user_code'),
            'selected_villages' => $this->input->post('villages'),
        );

        

        $response = $this->LAC_model->saveLACMapping($data);

        // var_dump(base_url());
        // die;

        if ($response['success']) {
            $this->session->set_flashdata('success', $response['message']);
            redirect(base_url().'index.php/LACControler');
        } else {
            $this->session->set_flashdata('error', $response['message']);
            redirect(base_url().'index.php/LACControler');
        }
    }

    public function getTempData()
    {
        $lac_id = $this->input->post('lac_id');
        // var_dump($lac_id);
        // die;
        $adc_id = $this->session->userdata('user_code');
        if ($adc_id) {
            // Get the initial data with lac_name
            $data = $this->LAC_model->getTempData($adc_id, $lac_id);

            
            // If there's no data, return empty array
            if (empty($data)) {
                echo json_encode([]);
                return;
            }

            // Get the village details
            $villageDetails = $this->LAC_model->getVillageNamesBulk($data);

            // Map lac_name from original data to the village details
            $result = array_map(function ($village) use ($data) {
               
                // Find matching lac_name from original data
                $matchingLac = array_filter($data, function ($item) use ($village) {
                    return $item['dist_code'] == $village['dist_code'] &&
                        $item['subdiv_code'] == $village['subdiv_code'] &&
                        $item['cir_code'] == $village['cir_code'] &&
                        $item['mouza_code'] == $village['mouza_pargona_code'] &&
                        $item['lot_no'] == $village['lot_no'] &&
                        $item['vill_townprt_code'] == $village['vill_townprt_code'];
                });

                // If we found a match, add lac_name to the village details
                if (!empty($matchingLac)) {
                    $match = reset($matchingLac);
                    $village['lac_name'] = $match['lac_name'] ?? null;
                    $village['lac_id'] = $match['lac_id'] ?? null;
                }

                return $village;
            }, $villageDetails);

            echo json_encode($result);
        }
    }
    public function getVillageName()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        if ($vill_townprt_code) {
            $village = $this->LAC_model->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_townprt_code);
            echo json_encode($village);
        }
    }

    public function finalizeMapping()
    {

        $lac_id = $this->input->post('lac_id');


        $adc_id = $this->session->userdata('user_code');
        if ($adc_id) {
            $result = $this->LAC_model->finalizeLACMapping($adc_id, $_POST['remarks'], $lac_id);
            echo $result ? 1 : 0;
        }
    }

    public function getVillageNamesBulk()
    {
        $village_codes = json_decode($this->input->post('village_codes'), true);

        if (empty($village_codes)) {
            echo json_encode([]);
            return;
        }

        $result = $this->LAC_model->getVillageNamesBulk($village_codes);
        // var_dump($result);
        echo json_encode($result);
    }

    public function getVillageNamesBulkFinalize()
    {
        $village_codes = json_decode($this->input->post('village_codes'), true);

        if (empty($village_codes)) {
            echo json_encode([]);
            return;
        }

        $result = $this->LAC_model->getVillageNamesBulkFinalize($village_codes);
        // var_dump($result);
        echo json_encode($result);
    }


    public function viewSubmited()
    {
        $dist_code = $this->session->userdata['dist_code'];

        $data['finalizeData'] = $this->LAC_model->getLacList($dist_code);


        $data['_view'] = 'lac/view_submitted';
        $this->load->view('layouts/main', $data);
    }

    public function downloadPdf($lac_id)
    {
        // Load the model
        $this->load->model('LAC_model');

        // Get LAC details
        $lac_data = $this->LAC_model->getFinalizeDataByLacId($lac_id, 't');

        if (empty($lac_data)) {
            echo json_encode(['success' => false, 'message' => 'LAC data not found']);
            return;
        }

        // Get village details with names
        $village_codes = [];
        foreach ($lac_data as $row) {
            $village_codes[] = [
                'dist_code' => $row['dist_code'],
                'subdiv_code' => $row['subdiv_code'],
                'cir_code' => $row['cir_code'],
                'mouza_code' => $row['mouza_code'],
                'lot_no' => $row['lot_no'],
                'vill_townprt_code' => $row['vill_townprt_code']
            ];
        }

        $villages = $this->LAC_model->getVillageNamesBulk($village_codes);

        // Load mPDF library
        include 'vendor/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'freesans',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // Prepare data for the view
        $data = [
            'lac_name' => $lac_data[0]['lac_name'],
            'lac_id' => $lac_id,
            'villages' => $villages,
            'generated_date' => date('d/m/Y H:i:s')
        ];

        // Load the view into a variable
        $html = $this->load->view('lac/pdf_template', $data, true);

        // Add watermark
        // $mpdf->SetWatermarkText('LAC ' . $lac_id);
        // $mpdf->showWatermarkText = true;
        // $mpdf->watermarkTextAlpha = 0.1;

        // Write the HTML content
        $mpdf->WriteHTML($html);

        // Output the PDF for download
        $filename = 'LAC_Approval_' . $lac_id . '_' . date('Ymd_His') . '.pdf';
        $mpdf->Output($filename, 'D');
    }

    public function deleteTransaction($id)
    {


        $result = $this->LAC_model->deleteTransaction($id);

        echo $result ? 1 : 0;
    }

    public function lacDataPortToDB($dist_code = null)
    {
        
        $dist_code = $dist_code ;
        
        $db_config = [
            '02' => 'dha3', '05' => 'dha1', '10' => 'dha24', '13' => 'dha2',
            '17' => 'dha4', '15' => 'dha5', '14' => 'dha6', '07' => 'dha7',
            '03' => 'dha8', '18' => 'dha9', '12' => 'dha13', '24' => 'dha10',
            '06' => 'dha11', '11' => 'dha12', '16' => 'dha14', '32' => 'dha15',
            '33' => 'dha16', '34' => 'dha17', '21' => 'dha18', '08' => 'dha19',
            '35' => 'dha20', '36' => 'dha21', '37' => 'dha22', '25' => 'dha23',
            '39' => 'dha39'
        ];
        
        $this->db = $this->load->database($db_config[$dist_code], true);
        
        $this->createLacTransactionsTable();
        
        $auth_db = $this->load->database('auth', true);
        
        if (!$auth_db->table_exists('lac_transactions')) {
            $error = $auth_db->_error_message();
            throw new Exception('Transaction table not found in auth database: ' . ($error ?: 'Unknown error'));
        }
        
        $query = $auth_db->select('*')
                       ->from('lac_transactions t')  
                       ->where('t.dist_code', $dist_code)
                       ->where_in('t.status', ['a', 'f'])
                       ->get();
        
        if ($query === false) {
            $error = $auth_db->_error_message();
            throw new Exception('Query execution failed: ' . ($error ?: 'Unknown error'));
        }
        
        $transactions = $query->result_array();
        
        if (empty($transactions)) {
            echo "<div class='alert alert-info'>No records found to process for district $dist_code</div>";
            return;
        }

        $inserted = 0;
        $this->db->trans_begin();
        
        foreach ($transactions as $trans) {
            $lac_data = [
                'lac_id' => $trans['lac_id'] ?? null,
                'dist_code' => $trans['dist_code'] ?? null,
                'subdiv_code' => $trans['subdiv_code'] ?? null,
                'cir_code' => $trans['cir_code'] ?? null,
                'mouza_pargona_code' => $trans['mouza_pargona_code'] ?? null,
                'lot_no' => $trans['lot_no'] ?? null,
                'vill_townprt_code' => $trans['vill_townprt_code'] ?? null,
                'status' => 't',
                'loc_uuid' => $trans['loc_uuid'] ?? null,
                'adc_id' => $trans['adc_id'] ?? null,
                'dc_id' => $trans['dc_id'] ?? null,
                'adc_remarks' => $trans['adc_remarks'] ?? null
            ];
            
            $this->db->set($lac_data);
            $sql = $this->db->insert_string('lac_transactions', $lac_data);
            $sql .= ' ON CONFLICT (lac_id, loc_uuid, adc_id, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code) ';
            $sql .= 'DO UPDATE SET ';
            
            $update_fields = [];
            foreach (array_keys($lac_data) as $field) {
                if (!in_array($field, ['lac_id', 'loc_uuid', 'adc_id', 'dist_code', 'subdiv_code', 'cir_code', 'mouza_pargona_code', 'lot_no', 'vill_townprt_code'])) {
                    $update_fields[] = "$field = EXCLUDED.$field";
                }
            }
            $sql .= implode(', ', $update_fields);
            
            if (!$this->db->query($sql)) {
                $error = $this->db->_error_message();
                throw new Exception('Failed to insert/update record: ' . ($error ?: 'Unknown error'));
            }
            $inserted++;
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "<div class='alert alert-danger'>Error copying data to lac_transactions table. Please try again.</div>";
        } else {
            $this->db->trans_commit();
            echo "<div class='alert alert-success'>Successfully processed $inserted records into lac_transactions table</div>";
        }
    }
    
    private function createLacTransactionsTable()
    {
        $sequence_sql = "
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_sequences WHERE schemaname = 'public' AND sequencename = 'lac_transactions_id_seq') THEN
                CREATE SEQUENCE public.lac_transactions_id_seq
                    INCREMENT 1
                    START 1
                    MINVALUE 1
                    MAXVALUE 9223372036854775807
                    CACHE 1;
                ALTER SEQUENCE public.lac_transactions_id_seq OWNER TO postgres;
            END IF;
        END $$;";
        
        $this->db->query($sequence_sql);
        
        $create_table_sql = "
        CREATE TABLE IF NOT EXISTS public.lac_transactions (
            id integer NOT NULL DEFAULT nextval('lac_transactions_id_seq'::regclass),
            lac_id bigint NOT NULL,
            dist_code character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            subdiv_code character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            cir_code character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            mouza_pargona_code character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            lot_no character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            vill_townprt_code character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            status character(1) COLLATE pg_catalog.\"default\" DEFAULT 't'::bpchar,
            loc_uuid bigint NOT NULL,
            adc_id character varying(10) COLLATE pg_catalog.\"default\" NOT NULL,
            dc_id character varying(50) COLLATE pg_catalog.\"default\",
            adc_remarks character varying(50) COLLATE pg_catalog.\"default\",
            CONSTRAINT lac_transactions_pkey PRIMARY KEY (id)
        )
        TABLESPACE pg_default;";
        
        if (!$this->db->query($create_table_sql)) {
            $error = $this->db->_error_message();
            throw new Exception('Failed to create table: ' . ($error ?: 'Unknown error'));
        }
        
        $create_index_sql = "
        CREATE UNIQUE INDEX IF NOT EXISTS idx_lac_transactions_unique
            ON public.lac_transactions USING btree
            (lac_id ASC NULLS LAST, loc_uuid ASC NULLS LAST, 
             adc_id COLLATE pg_catalog.\"default\" ASC NULLS LAST, 
             dist_code COLLATE pg_catalog.\"default\" ASC NULLS LAST, 
             subdiv_code COLLATE pg_catalog.\"default\" ASC NULLS LAST, 
             cir_code COLLATE pg_catalog.\"default\" ASC NULLS LAST, 
             mouza_pargona_code COLLATE pg_catalog.\"default\" ASC NULLS LAST, 
             lot_no COLLATE pg_catalog.\"default\" ASC NULLS LAST, 
             vill_townprt_code COLLATE pg_catalog.\"default\" ASC NULLS LAST);";
        
        if (!$this->db->query($create_index_sql)) {
            $error = $this->db->_error_message();
            throw new Exception('Failed to create index: ' . ($error ?: 'Unknown error'));
        }
        
        if (!$this->db->query("ALTER TABLE IF EXISTS public.lac_transactions OWNER TO postgres;")) {
            $error = $this->db->_error_message();
            throw new Exception('Failed to set table owner: ' . ($error ?: 'Unknown error'));
        }
    }
}
