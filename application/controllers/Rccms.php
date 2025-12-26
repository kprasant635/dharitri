<?php


class Rccms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('AES');
        $this->dbswitch();
        $this->load->model('rccms/rccmsModel');
        //prasant added for rccms json demo file access
        $this->load->model('rccms/Case_model');
        $this->load->model('rccms/CaseLand_model');
        $this->load->model('rccms/Pattadar_model');
        $this->load->model('rccms/StrikePattadar_model');
        $this->load->model('rccms/UnstrikePattadar_model');
        $this->load->model('rccms/AreaChange_model');
        $this->load->model('rccms/PattaTypeChange_model');
        $this->load->model('rccms/OtherRemarks_model');
        $this->load->model('rccms/LandWorkflowModel');
        $this->load->model('rccms/LandClassChange_model');
    }

    private function json_response($data)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    //db switch method
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

    public function landing_page()
    {
        $api_url = "https://129.154.254.176/rccms_stage_backend/v1/caseStatus/getAllDisposedApplications";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apiKey: RCCMS-DEMO',
                'Accept: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Default values
        $data['api_response'] = [];
        $cases = [];

        if ($response !== false) {

            $decoded = json_decode($response, true);

            // Ensure data key exists
            if (isset($decoded['data']) && is_array($decoded['data'])) {

                $data['api_response'] = $decoded['data'];

                foreach ($decoded['data'] as $row) {

                    $cases[] = [
                        'applicationId' => $row['applicationId'] ?? '',
                        'district' => trim(
                            ($row['landDetails'][0]['districtNameAs'] ?? '') .
                            (
                                !empty($row['landDetails'][0]['districtNameAs'])
                                ? ' (' . $row['landDetails'][0]['districtNameEng'] . ')'
                                : ''
                            )
                        ) ?: '-',
                        'village_name' => trim(
                            ($row['landDetails'][0]['villNameAs'] ?? '') .
                            (
                                !empty($row['landDetails'][0]['villNameEng'])
                                ? ' (' . $row['landDetails'][0]['villNameEng'] . ')'
                                : ''
                            )
                        ) ?: '-',
                        'circle' => trim(
                            ($row['landDetails'][0]['cirNameAs'] ?? '') .
                            (
                                !empty($row['landDetails'][0]['cirNameEng'])
                                ? ' (' . $row['landDetails'][0]['cirNameEng'] . ')'
                                : ''
                            )
                        ) ?: '-',
                    ];
                }
            }
        }

        // print_r($cases);
        // exit;

        // Pass to view
        $data['cases'] = $cases;
        $data['_view'] = 'rccms/landing_page';

        $this->load->view('layouts/main', $data);
    }



    public function search_case()
    {
        $case_number = $this->input->post('case_number');

        if (!empty($case_number)) {
            // $api_url = "https://129.154.254.176/rccms_stage_backend/v1/caseStatus/getApplication?applicationId=" . urlencode($case_number);
            $api_url = "http://10.254.119.85:8082/v1/caseStatus/getApplication?applicationId=" . urlencode($case_number);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'apiKey: RCCMS-DEMO',
                    'Accept: application/json'
                ),
                CURLOPT_SSL_VERIFYPEER => false, // Add this
                CURLOPT_SSL_VERIFYHOST => false  // Add this
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                $data['api_response'] = null;
            } else {
                $data['api_response'] = $response;
            }

            curl_close($curl);


        } else {
            $data['api_response'] = ['error' => 'Case number is required'];
        }


        print_r($data['api_response']);
        exit;


        $data['_view'] = 'rccms/landing_page';
        $this->load->view('layouts/main', $data);
    }
    // demo json files accessing function by prasant
    public function demo_json_access($file_name)
    {

        if ($this->session->userdata('user_desig_code') != "CO") {
            echo json_encode("Not Authorised!!");
            exit;
        }


        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');

        $api_data = $this->Case_model->get_by_case_id($file_name);
        $api_data = json_decode($api_data->api_data, true); // true = array
        // print_r($api_data); 
        // exit;
        $data['all_data'] = $api_data['data'];
        $data['land_details'] = $api_data['data']['landDetails'];
        $data['caseNature'] = $api_data['data']['caseNature'];
        $data['caseNature'] = $data['caseNature']['caseNatureName'];
        $data['caseHistory'] = $api_data['data']['caseHistory'];
        $data['caseStatus'] = $api_data['data']['caseStatus'];


        $data['mouza_list'] = $this->rccmsModel->getAllMouzas($dist_code, $subdiv_code, $cir_code);
        $data['gender'] = get_gender();
        $data['relation'] = get_relation();
        $data['pattatype'] = get_pattatype();
        $data['landclass'] = get_lanclass();
        $data['districtCode'] = Barak_Vally_Distcode;

        
        // print_r( $data['land_details'][0]['pattaType']);
        // exit;
        $data['_view'] = 'rccms/case_details';
        $this->load->view('layouts/main', $data);
    }



    public function show_rccms_details($case_id)
    {
        //***************cheching-user-designation**********/
        if ($this->session->userdata('user_desig_code') != "CO") {
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');

        $api_data = $this->Case_model->get_by_case_id($case_id);
        // $api_data = json_decode($api_data->api_data, true); // true = array
        // print_r($api_data); 
        // exit;
        $data['all_data'] = $api_data['data'];
        $data['land_details'] = $api_data['data']['landDetails'];
        $data['caseNature'] = $api_data['data']['caseNature'];
        $data['caseNature'] = $data['caseNature']['caseNatureName'];
        $data['caseHistory'] = $api_data['data']['caseHistory'];
        $data['caseStatus'] = $api_data['data']['caseStatus'];


        $data['mouza_list'] = $this->rccmsModel->getAllMouzas($dist_code, $subdiv_code, $cir_code);
        $data['gender'] = get_gender();
        $data['relation'] = get_relation();
        $data['pattatype'] = get_pattatype();
        $data['landclass'] = get_lanclass();
        $data['districtCode'] = Barak_Vally_Distcode;

        $data['_view'] = 'rccms/case_details';
        $this->load->view('layouts/main', $data);
    }

    public function get_lots_by_mouza()
    {
        // Get the mouza_pargona_code from POST data
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->post('mouza_pargona_code');
        $lots = $this->rccmsModel->getAllLots($dist_code, $subdiv_code, $cir_code, $mouza_code);
        echo json_encode($lots);

    }

    public function get_villages_by_lot()
    {
        // Get the mouza_pargona_code from POST data
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $villages = $this->rccmsModel->getAllVillages($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
        echo json_encode($villages);
    }

    public function validate_village()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $rccms_village_code = $this->input->post('rccms_vill_code');

        //for testing*********
        $rccms_village_code = '284079';
        // $rccms_village_code ='284079';
        //for testing*********

        $dhar_mouza_code = $this->input->post('mouza');
        $dhar_lot_no = $this->input->post('lot');
        $dhar_village_code = $this->input->post('village');
        $dhar_lgd_code = $this->rccmsModel->getDharitreeLgdCode($dist_code, $subdiv_code, $cir_code, $dhar_mouza_code, $dhar_lot_no, $dhar_village_code);
        // var_dump($dhar_lgd_code);
        // exit;
        if (trim($dhar_lgd_code) == $rccms_village_code) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }


    //prasant added function rccms file save
    public function save_case()
    {

        $raw = file_get_contents('php://input');
        $post = json_decode($raw, true);

        if (empty($post['case_id']) || empty($post['lands']) || !is_array($post['lands'])) {
            return $this->_json(['status' => false, 'msg' => 'Invalid payload']);
        }

        $case_db_id = $this->Case_model->get_by_case_id($post['case_id']);

        print_r($post);
        exit;

        $this->db->trans_begin();





        // 2. Insert lands (DAG-wise) and map index -> land_id
        $land_ids = [];
        foreach ($post['lands'] as $index => $land) {
            if (empty($land['dag_no']) || empty($land['patta_no']))
                continue;
            $land_ids[$index] = $this->CaseLand_model->insert([
                'case_id' => $case_db_id->sl,
                'dag_no' => $land['dag_no'],
                'patta_no' => $land['patta_no'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->all_userdata()['user_code'],
                'created_ip' => $this->session->all_userdata()['ip_address'],
                'updated_ip' => $this->session->all_userdata()['ip_address'],
                'status' => 'pending',
                'forwarded_to' => null,
                'remarks' => null,
                'last_updated' => date('Y-m-d H:i:s'),
            ]);

            $this->LandWorkflowModel->insertWorkflow([
                'land_id' => $land_ids[$index]['insert_id'],
                'status' => 'pending',
                'assigned_to' => $this->session->all_userdata()['user_code'],
                'forwarded_to' => null,
                'action_type' => 'assigned',
                'remarks' => 'Land created & assigned during case creation',
                'created_ip' => $this->session->all_userdata()['ip_address'],
                'created_by' => $this->session->all_userdata()['user_code'],
                'created_at' => date('Y-m-d H:i:s')
            ]);



        }

        //       $this->db->trans_commit();
        // echo json_encode(['status' => true, 'msg' => 'Lands inserted', 'land_ids' => $land_ids]);
        // exit;

        // 3. Pattadars (table data)
        if (!empty($post['pattadars']) && is_array($post['pattadars'])) {
            foreach ($post['pattadars'] as $index => $rows) {
                if (!isset($land_ids[$index]) || !is_array($rows))
                    continue;
                foreach ($rows as $r) {
                    if (empty($r['name']))
                        continue;
                    $this->Pattadar_model->insert([
                        'land_id' => $land_ids[$index]['insert_id'],
                        'name' => $r['name'],
                        'guardian_name' => isset($r['guardian']) ? $r['guardian'] : null,
                        'gender' => isset($r['gender']) ? $r['gender'] : null,
                        'relation' => isset($r['relation']) ? $r['relation'] : null,
                        'address' => isset($r['address']) ? $r['address'] : null,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }





        // 4. Strike pattadars
        if (!empty($post['strike']) && is_array($post['strike'])) {
            foreach ($post['strike'] as $index => $s) {
                if (!isset($land_ids[$index]))
                    continue;
                if (empty($s['selected']) || !is_array($s['selected']))
                    continue;

                $reason = isset($s['reason']) ? $s['reason'] : null;
                foreach ($s['selected'] as $p_id) {
                    $this->StrikePattadar_model->insert([
                        'land_id' => (int) $land_ids[$index]['insert_id'],
                        'pattadar_id' => (int) $p_id,
                        'reason' => $reason,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }




        // 4.1. UN-Strike pattadars
        if (!empty($post['unstrike']) && is_array($post['unstrike'])) {

            foreach ($post['unstrike'] as $index => $s) {
                if (!isset($land_ids[$index]))
                    continue;
                if (empty($s['selected']) || !is_array($s['selected']))
                    continue;

                $reason = isset($s['reason']) ? $s['reason'] : null;
                foreach ($s['selected'] as $p_id) {
                    $this->UnstrikePattadar_model->insert([
                        'land_id' => (int) $land_ids[$index]['insert_id'],
                        'pattadar_id' => (int) $p_id,
                        'reason' => $reason,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }




        // 5. Area change
        if (!empty($post['area_change']) && is_array($post['area_change'])) {
            foreach ($post['area_change'] as $index => $a) {
                if (!isset($land_ids[$index]))
                    continue;
                if (empty($a))
                    continue;

                $this->AreaChange_model->insert([
                    'land_id' => $land_ids[$index]['insert_id'],
                    'bigha' => isset($a['bigha']) ? (int) $a['bigha'] : 0,
                    'katha' => isset($a['katha']) ? (int) $a['katha'] : 0,
                    'lessa' => isset($a['lessa']) ? (int) $a['lessa'] : 0,
                    'gonda' => isset($a['gonda']) ? (int) $a['gonda'] : 0,
                    'chatak' => isset($a['chatak']) ? (int) $a['chatak'] : 0,
                    'reason' => isset($a['reason']) ? $a['reason'] : null,
                ]);
            }
        }




        // 6. Patta type change
        if (!empty($post['patta_type_change']) && is_array($post['patta_type_change'])) {
            foreach ($post['patta_type_change'] as $index => $p) {
                if (!isset($land_ids[$index]))
                    continue;
                if (empty($p))
                    continue;

                $this->PattaTypeChange_model->insert([
                    'land_id' => $land_ids[$index]['insert_id'],
                    'present_patta_type' => isset($p['present']) ? $p['present'] : null,
                    'requested_patta_type' => isset($p['requested']) ? $p['requested'] : null,
                    'new_patta_no' => isset($p['new_patta_no']) ? $p['new_patta_no'] : null,
                    'reason' => isset($p['reason']) ? $p['reason'] : null,
                ]);
            }
        }


        // ==========================
        // LAND CLASS CHANGE
        // ==========================
        if (!empty($post['land_class_change']) && is_array($post['land_class_change'])) {
            foreach ($post['land_class_change'] as $index => $data) {

                if (!isset($land_ids[$index]))
                    continue;

                $land_class = isset($data['present']) ? (int) $data['present'] : null;
                $reason = $data['reason'] ?? null;

                if ($land_class === null && empty($reason))
                    continue;

                $this->LandClassChange_model->insert([
                    'land_id' => $land_ids[$index]['insert_id'],
                    'land_class_id' => $land_class,
                    'reason' => $reason,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);


            }
        }


        // 7. Other remarks
        // if (!empty($post['remarks']) && is_array($post['remarks'])) {
        //     foreach ($post['remarks'] as $index => $txt) {
        //         if (!isset($land_ids[$index]))
        //             continue;
        //         if ($txt === '' || $txt === null)
        //             continue;

        //         $response = $this->OtherRemarks_model->insert([
        //             'land_id' => (int) $land_ids[$index]['insert_id'],
        //             'remarks' => $txt,
        //         ]);
        //     }
        // }




        if ($this->db->trans_status() === FALSE) {
            return $this->json_response(['status' => false, 'msg' => 'Database Error']);
        }
        $this->db->trans_commit();


        return $this->json_response([
            'status' => true,
            'msg' => 'Case saved successfully',
            'case_db_id' => $case_db_id
        ]);
    }


}
?>