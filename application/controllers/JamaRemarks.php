<?php

class JamaRemarks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('JamaRemarks_model');
    }

    public function getRemarks15years() {
        $data['_view'] = 'remarks_view';
        $this->load->view('layouts/main', $data);
    }

    public function loadTableData() {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        // var_dump($start);
        // var_dump($length);
        // die;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
    
        $totalRecords = $this->JamaRemarks_model->countAllRemarks($dist_code, $subdiv_code, $cir_code);
        $remarks = $this->JamaRemarks_model->getRemarks15years($dist_code, $subdiv_code, $cir_code, $start, $length);
        // var_dump();
        //dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, patta_type_code, patta_no, rmk_line_no
        $data = [];
        foreach ($remarks as $key => $res) {
            $button = '<button class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="openModel(\'' . $res['dist_code'] . '\', \'' . $res['subdiv_code'] . '\', \'' . $res['cir_code'] . '\', \'' . $res['mouza_pargona_code'] . '\', \'' . $res['lot_no'] . '\', \'' . $res['vill_townprt_code'] . '\', \'' . $res['patta_type_code'] . '\', \'' . $res['patta_no'] . '\', \'' . $res['rmk_line_no'] . '\')">View Remark</button>';
            $circle_name = $this->JamaRemarks_model->getLocName($dist_code, $subdiv_code, $cir_code);
            $mouza_name = $this->JamaRemarks_model->getMouzaName($dist_code, $subdiv_code, $cir_code, $res['mouza_pargona_code']);
            $lot_no = $this->JamaRemarks_model->getLotName($dist_code, $subdiv_code, $cir_code, $res['mouza_pargona_code'], $res['lot_no']);
            $village = $this->JamaRemarks_model->getVillageName($dist_code, $subdiv_code, $cir_code, $res['mouza_pargona_code'], $res['lot_no'],$res['vill_townprt_code']);
            $patta_type = $this->JamaRemarks_model->getPattaName($res['patta_type_code']);
            // var_dump($circle_name);die;
            $data[] = [
                $start + $key + 1,       // Sl No
                $circle_name, 
                $mouza_name,
                $lot_no, 
                $village,
                $patta_type,
                $res['patta_no'],
                $button,
            ];
        }
    
        echo json_encode([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }

    public function getRemark() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townport_code = $this->input->get('vill_townport_code');
        $patta_type_code = $this->input->get('patta_type_code');
        $patta_no = $this->input->get('patta_no');
        $rmk_line_no = $this->input->get('rmk_line_no');
    
        // Call the model function to get the remark
        $remark = $this->JamaRemarks_model->getRemark(
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
            $lot_no, $vill_townport_code, $patta_type_code, $patta_no, $rmk_line_no
        );
    
        $new_text = " অসম চৰকাৰৰ 03-03-2024 তাৰিখৰ ECF 200418  নং অধিসূচনা অনুসৰি বিধি ২৬- A মৰ্মে উক্ত মাটি হস্তান্তৰ কৰিলে উক্ত বন্দবস্তিকাৰী ভুমিহীন হলেও ভৱিষ্যতে পুনৰ চৰকাৰী মাটি বন্দোবস্তিৰ যোগ্য নহব ";
        $updated_remark = str_replace(
            "২০১৯ চনৰ নতুন ভূমিনিতিৰ ১৪.১৩ নং দফা অনুসৰি নতুনকৈ পট্টন হোৱা এই জমী পট্টনৰ তাৰিখৰ পৰা ১৫ বছৰলৈ হস্তান্তৰ কৰিব নোৱাৰিব ।",
            $new_text . " ।",
            $remark
        );

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'remark' => $remark,
            'updated_remark' => $updated_remark
        ]));


        // echo $remark;
    }



    

    public function updateRemarks() {
        $remark = $this->input->post('remark_input');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townport_code = $this->input->post('vill_townport_code');
        $patta_type_code = $this->input->post('patta_type_code');
        $patta_no = $this->input->post('patta_no');
        $rmk_line_no = $this->input->post('rmk_line_no');

        $checkbox = $this->input->post('checkbox');
        if($checkbox != "Yes"){
            $this->session->set_flashdata('error', 'Checkbox must be checked');
            return $this->getRemarks15years();
        }
    
        $backup = $this->JamaRemarks_model->insertIntoBackup($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
        $lot_no, $vill_townport_code, $patta_type_code, $patta_no, $rmk_line_no,$remark);

        $sql = "UPDATE jama_remark 
                SET remark = ? 
                WHERE dist_code = ? 
                  AND subdiv_code = ? 
                  AND cir_code = ? 
                  AND mouza_pargona_code = ? 
                  AND lot_no = ? 
                  AND vill_townprt_code = ? 
                  AND patta_type_code = ? 
                  AND patta_no = ? 
                  AND rmk_line_no = ?";
    
        $this->db->query($sql, [
            $remark,
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no,
            $vill_townport_code,
            $patta_type_code,
            $patta_no,
            $rmk_line_no
        ]);

        // echo $this->db->last_query();
        // die;
        $this->session->set_flashdata('success', 'Successfully updated remark');
        return $this->getRemarks15years();
    }
    
    
    
    
}