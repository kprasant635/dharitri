<?php

class SettlementEvictionController extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }


    public function evictionNoticeMenu(){
        
        $data['_view'] = 'SettlementView/EvictionNotice/EvictionNoticeMenu';
        $this->load->view('layouts/main',$data);
    }

    public function evictionNoticeList(){

        $dist_code = $this->session->userdata('dist_code');

        $getCircles = $this->db->query('SELECT dist_code, subdiv_code, cir_code, uuid, loc_name FROM location WHERE dist_code = ? AND subdiv_code != ? AND cir_code != ? AND mouza_pargona_code = ?', array($dist_code, '00', '00', '00'));

        if($getCircles->num_rows() > 0){
            $data['circle_list'] = $getCircles->result();
        }
        else{
            $data['circle_list'] = false;
        }

        $data['_view'] = 'SettlementView/EvictionNotice/EvictionNoticeList';
        $this->load->view('layouts/main',$data);
    }

    public function getlotsByUUID(){
        $circle_uuid = $this->input->post('circle_uuid');
        if($circle_uuid == ''){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR42: Please select circle!'
            ]);
            return false;
        }


        $cirQuery = $this->db->query('select * from location where uuid = ?', array($circle_uuid));
        $loc = $cirQuery->row();

        $dist_code = $loc->dist_code; 
        $subdiv_code = $loc->subdiv_code;
        $cir_code = $loc->cir_code;

        $logQuery = $this->db->query('select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, loc_name, uuid from location where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code != ? and lot_no != ? and vill_townprt_code = ?', array($dist_code, $subdiv_code, $cir_code, '00', '00', '00000'));

        if($logQuery->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR42: No lot found!'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'show' => '1',
            'data' => $logQuery->result()
        ]);
    }

    public function getVillagesByUUID(){

        $lot_uuid = $this->input->post('lot_uuid');

        $lotQuery = $this->db->query('select * from location where uuid = ?', array($lot_uuid));
        $loc = $lotQuery->row();

        $dist_code = $loc->dist_code; 
        $subdiv_code = $loc->subdiv_code;
        $cir_code = $loc->cir_code;
        $mouza_pargona_code = $loc->mouza_pargona_code;
        $lot_no = $loc->lot_no;

        $logQuery = $this->db->query('select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, loc_name, uuid from location where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code != ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, '00000'));

        if($logQuery->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR42: No lot found!'
            ]);
            return false;
        }
        
        echo json_encode([
            'responseType' => 2,
            'show' => '2',
            'data' => $logQuery->result()
        ]);
    }

    public function paginationList(){
        $application_no = $this->input->post('columns')[1]['search']['value'];
        $case_no = $this->input->post('columns')[2]['search']['value'];

        $service_code = $this->input->post('service_code');
        $circle_uuid = $this->input->post('circle_uuid');
        $lot_uuid = $this->input->post('lot_uuid');
        $village_uuid = $this->input->post('village_uuid');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $dist_code = '';
        $subdiv_code = '';
        $cir_code = '';
        $mouza_pargona_code = '';
        $lot_no = '';
        $vill_townprt_code = '';


        if(!empty($circle_uuid)) {
            $slqCicle = $this->db->query('select * from location where uuid = ?', array($circle_uuid));
            $cir_row = $slqCicle->row();
            
            $dist_code = $cir_row->dist_code;
            $subdiv_code = $cir_row->subdiv_code;
            $cir_code = $cir_row->cir_code;
        }

        if(!empty($lot_uuid)) {
            $slqLot = $this->db->query('select * from location where uuid = ?', array($lot_uuid));
            $lot_row = $slqLot->row();
            
            $dist_code = $lot_row->dist_code;
            $subdiv_code = $lot_row->subdiv_code;
            $cir_code = $lot_row->cir_code;
            $mouza_pargona_code = $lot_row->mouza_pargona_code;
            $lot_no = $lot_row->lot_no;
        }

        if(!empty($village_uuid)) {
            $slqVillage = $this->db->query('select * from location where uuid = ?', array($village_uuid));
            $village_row = $slqVillage->row();
            
            $dist_code = $village_row->dist_code;
            $subdiv_code = $village_row->subdiv_code;
            $cir_code = $village_row->cir_code;
            $mouza_pargona_code = $village_row->mouza_pargona_code;
            $lot_no = $village_row->lot_no;
            $vill_townprt_code = $village_row->vill_townprt_code;
        }

        $this->db->select('distinct(sb.case_no), sb.applid, sb.service_code, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');

        $this->db->where('sb.service_code', $service_code);
        $this->db->where('sb.dist_code', $this->session->userdata('dist_code'));

        if(!empty($subdiv_code)) {
            $this->db->where('sb.subdiv_code', $subdiv_code);
        }
        if(!empty($cir_code)){
            $this->db->where('sb.cir_code', $cir_code);
        }
        if(!empty($mouza_pargona_code)){
            $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
        }
        if(!empty($lot_no)){
            $this->db->where('sb.lot_no', $lot_no);
        }
        if(!empty($vill_townprt_code)){
            $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
        }
        if(!empty($case_no)){
            $this->db->like('sb.case_no', strtoupper($case_no));            
        }
        if(!empty($application_no)){
            $this->db->like('sb.applid', strtoupper($application_no));
        }

        $this->db->where('sb.status', 'N');
        $this->db->where('sp.grn_no is null');
        $this->db->where('sp.is_final', 1);
        $this->db->join('settlement_premium sp', 'sp.case_no = sb.case_no');
 
        $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_notice sn WHERE sn.case_no = sb.case_no AND sn.notice_type = \'E1\')', null, false);

        $this->db->limit($length, $start);

        $query = $this->db->get('settlement_basic sb');


        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $service_name = '';
                if($rows->service_code == '13'){
                    $service_name = 'Tenant';
                }if($rows->service_code == '14'){
                    $service_name = 'AP';
                }if($rows->service_code == '15'){
                    $service_name = 'Tribal';
                }if($rows->service_code == '16'){
                    $service_name = 'Khasland';
                }if($rows->service_code == '17'){
                    $service_name = 'VGR/PGR';
                }if($rows->service_code == '18'){
                    $service_name = 'Cultivation';
                }

                $json[] = array(
                    $rows->case_no,
                    '<span style= "font-size:14px;"><strong>' . $rows->applid . '</strong></span>',
                    '<span style= "font-size:14px; white-space: nowrap;"><strong>' . $rows->case_no . '</strong></span>',
                    $service_name,

                    $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    '<button type="button" onclick="evictionNoticeSingle(\''.$rows->case_no.'\')" class="btn btn-sm btn-danger">Eviction Notice</button>'
                );
            }

            $this->db->select('distinct(sb.case_no), sb.applid, sb.service_code, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');

            $this->db->where('sb.service_code', $service_code);
            $this->db->where('sb.dist_code', $this->session->userdata('dist_code'));
    
            if(!empty($subdiv_code)) {
                $this->db->where('sb.subdiv_code', $subdiv_code);
            }
            if(!empty($cir_code)){
                $this->db->where('sb.cir_code', $cir_code);
            }
            if(!empty($mouza_pargona_code)){
                $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
            }
            if(!empty($lot_no)){
                $this->db->where('sb.lot_no', $lot_no);
            }
            if(!empty($vill_townprt_code)){
                $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
            }
            if(!empty($case_no)){
                $this->db->where('sb.case_no', $case_no);
            }
            if(!empty($application_no)){
                $this->db->where('sb.applid', $application_no);
            }
    
            $this->db->where('sb.status', 'N');
            $this->db->where('sp.grn_no is null');
            $this->db->where('sp.is_final', 1);
            $this->db->join('settlement_premium sp', 'sp.case_no = sb.case_no');
             
            $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_notice sn WHERE sn.case_no = sb.case_no AND sn.notice_type = \'E1\')', null, false);

            $query = $this->db->get('settlement_basic sb');
            $total_records = $query->num_rows();

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        }else{
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function generateEvictionNoticeBulk(){
        $caseArray = $this->input->post('selectMark');
 
        foreach ($caseArray as $case_no) {
            return $this->generateEvictionNotice($case_no, false, true);
        }
    }


    public function generateEvictionNotice($case_no=false, $view = false, $nextval = false){

        if($case_no == false){
            $case_no = $this->input->post('case_no');
        }

        if($nextval == false){
            $nextval = $this->input->post('nextval');
            $nextval = ($nextval !== null) ? $nextval : false;
        }

        if($view == false){
            $view = $this->input->post('view');
            $view = ($view !== null) ? $view : false;
        }

        $sql = $this->db->query('select distinct(sb.case_no), sp.area_name, sb.dept_order_no, sb.dept_order_date, sb.service_code, sp.due_amount, sb.applid, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code, sb.application_date from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sp.is_final = ? and sp.grn_no is null and sb.status = ? and sb.case_no = ?', array(1, 'N', $case_no));

        if($sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR282: Unable to process! Something went wrong...'
            ]);
            return false;
        }
        $case_row = $sql->row();
        $dist_name = $this->utilityclass->getDistrictName($case_row->dist_code);
        
        $circle_name = $this->utilityclass->getCircleName($case_row->dist_code, $case_row->subdiv_code, $case_row->cir_code);
        
        $mouza_name = $this->utilityclass->getMouzaName($case_row->dist_code, $case_row->subdiv_code, $case_row->cir_code, $case_row->mouza_pargona_code);
        
        $lot_name = $this->utilityclass->getLotName($case_row->dist_code, $case_row->subdiv_code, $case_row->cir_code, $case_row->mouza_pargona_code, $case_row->lot_no);
        
        $village_name = $this->utilityclass->getVillageName($case_row->dist_code, $case_row->subdiv_code, $case_row->cir_code, $case_row->mouza_pargona_code, $case_row->lot_no, $case_row->vill_townprt_code);

        $case_no = $case_row->case_no;


        $sql_applicant = $this->db->query('select * from settlement_applicant where case_no = ? and is_applicant = ?', array($case_no, 1));

        if($sql_applicant->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        $applicant_row = $sql_applicant->row();

        $sql_notice = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

        if($sql_notice->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR55382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        $notice_row = $sql_notice->row();

        if($case_row->due_amount != $notice_row->total_amount){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR95382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        $dag_sql = $this->db->query("select * from settlement_dag_details where case_no = ?", array($case_no));
        if($dag_sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR45382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        $dag_result = $dag_sql->result();

        foreach($dag_result as $dag_row){
            $dag_nos[] = $dag_row->dag_no;

            $get_area_sql = $this->db->query('select * from settlement_premium where case_no = ? and dag_no = ? and is_final = ?', array($case_no, $dag_row->dag_no, 1));

            if($get_area_sql->num_rows() <= 0){
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR435382: Unable to process! Something went wrong...'
                ]);
                return false;
            }

            $lessa_row = $get_area_sql->row();

            if (in_array($case_row->dist_code, json_decode(BARAK_VALLEY))) {
                $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($lessa_row->total_lessa);
                
                $area_all[] = 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';

            } else {
                $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($lessa_row->total_lessa);

                $area_all[] = 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
            }
        }

        $area = implode(", <br>", $area_all);
        $dag_numbers = implode(", ", $dag_nos);

        $service_name = '';
        $service_short = '';
        if($case_row->service_code == '13'){
            $service_name = 'Settlement of Tenant';
            $service_short = SETTLEMENT_TENANT;
        }
        elseif($case_row->service_code == '14'){
            $service_name = 'Settlement of AP';
            $service_short = SETTLEMENT_AP_TRANSFER;
        }
        elseif($case_row->service_code == '15'){
            $service_name = 'Settlement of Tribal Community';
            $service_short = SETTLEMENT_TRIBAL_COMMUNITY;
        }
        elseif($case_row->service_code == '16'){
            $service_name = 'Settlement of Khasland';
            $service_short = SETTLEMENT_KHAS_LAND;
        }
        elseif($case_row->service_code == '17'){
            $service_name = 'Settlement of VGR/PGR';
            $service_short = SETTLEMENT_PGR_VGR_LAND;
        }
        elseif($case_row->service_code == '18'){
            $service_name = 'Settlement of Cultivation';
            $service_short = SETTLEMENT_SPECIAL_CULTIVATORS;
        }


        if($nextval == false){
            $nextval = $this->db->query("select nextval('settlement_notice_id_seq') as count ")->row()->count;
        }

        $sdlac_sql = $this->db->query('SELECT pml.meeting_date, pml.meeting_name FROM settlement_proposal_cases spc JOIN settlement_proposal_list spl ON spc.proposal_id = spl.id JOIN proposal_meeting_list pml ON pml.id = spl.proposal_meeting_id WHERE spc.case_no = ?', array($case_no));
        if($sdlac_sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR475382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        $sdlac_row = $sdlac_sql->row();

        if(empty($sdlac_row->meeting_date) || empty($sdlac_row->meeting_name)){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR000382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        $dc_name = $this->utilityclass->getNameOfUserByUserCode($this->session->userdata('user_code'));

        $urbanArray = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);

        if(empty($case_row->area_name)){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3000382: Unable to process! Something went wrong...'
            ]);
            return false;
        }

        if(!in_array($case_row->area_name, $urbanArray)){
            //rural cases
            if(empty($case_row->dept_order_no) || empty($case_row->dept_order_date)){
                $ord_no_det = 'আবেদন পৰীক্ষা আৰু চৰজমিন তদন্তৰ অন্তত  উক্ত  তপশীলভুক্ত চৰকাৰী ভূমিত আপোনাৰ দখল থকা দেখা গৈছিল I সেই অনুযায়ী  ভূমি উপদেষ্টা সমিতিৰ <b>'.(new DateTime($sdlac_row->meeting_date))->format('d M Y').'</b> তাৰিখৰ বৈঠকৰ <b>'.$sdlac_row->meeting_name.'</b> নং সিদ্ধান্ত অনুসৰি চৰকাৰী মাটিৰ পট্টনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছিল।';

            }else{
                $ord_no_det = ' আবেদন পৰীক্ষা আৰু চৰজমিন তদন্তৰ অন্তত  উক্ত তপশীলভুক্ত চৰকাৰী ভূমিত আপোনাৰ ভোগদখল থকা দেখা গৈছিল I সেই অনুযায়ী  ভূমি উপদেষ্টা সমিতিৰ <b>'.(new DateTime($sdlac_row->meeting_date))->format('d M Y').'</b> তাৰিখৰ বৈঠকৰ <b>'.$sdlac_row->meeting_name.'</b> নং সিদ্ধান্ত অনুসৰি আৰু ৰাজহ আৰু দুৰ্যোগ ব্যৱস্থাপনা বিভাগ, অসম চৰকাৰৰ <b>'.(new DateTime($case_row->dept_order_date))->format('d M Y').'</b> তাৰিখৰ <b>'.$case_row->dept_order_no.'</b> নং অধিসূচনা অনুসৰি চৰকাৰী মাটিৰ পট্টনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছিল।';
            }

            $notice_content = 
                '<div class="container bg-white shadow pb-3" id="print_direct">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            অসম চৰকাৰ <br>
                            জিলা আয়ুক্তৰ কাৰ্য্যলয়: জিলা – '.$dist_name.'<br>
                            জাননী
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-3">
                            No : '.$nextval.'<input type="hidden" name="nextval" id="nextval" value="'.$nextval.'"><input type="hidden" id="case_no_id" name="case_no" value="'.$case_no.'">
                        </div>
                        <div class="col-9 text-right">
                            Dated : <span style="font-weight:bold;">'.(new DateTime(date('Y-m-d')))->format('d M Y').'</span>
                        </div>
                    </div>

                    <div class="row mt-5 px-5">
                        <div class="col-12 text-justify">
                            প্ৰতি, <b>'.$applicant_row->pdar_name.'</b>  পিতা/ স্বামী <b>'.$applicant_row->pdar_guardian.'</b>
                            <br>
                            ঠিকনা : <b>'.$applicant_row->pdar_add1.'</b>
                            
                            <br><br>

                            ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ২.০ ৰ অধীনত <b>'.$service_name.'</b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভুক্ত চৰকাৰী ভূমিৰ বাবে <b>'.(new DateTime($case_row->application_date))->format('d M Y').'</b> তাৰিখৰ <b>'.$case_row->applid.'</b> নং আবেদন  অনলাইন যোগে দাখিল কৰিছিল।
                            <br><br>

                            <table class="table table-bordered">
                                <tr class="bg-white">
                                    <th>জিলা</th>
                                    <th>ৰাজহ চক্ৰ</th>
                                    <th>মৌজা</th>
                                    <th>লাট</th>
                                    <th>গাওঁ</th>
                                    <th>দাগ</th>
                                    <th>কালি</th>
                                </tr>
                                <tr>
                                    <td>'.$dist_name.'</td>
                                    <td>'.$circle_name.'</td>
                                    <td>'.$mouza_name.'</td>
                                    <td>'.$lot_name.'</td>
                                    <td>'.$village_name.'</td>
                                    <td>'.$dag_numbers.'</td>
                                    <td>'.$area.'</td>
                                </tr>
                            </table>
                            <br>

                            '.$ord_no_det.'

                            <br><br>

                            সেই অনুসৰি,আপোনাৰ দখলত থকা উক্ত তপচিলভুক্ত চৰকাৰী ভূমিত, অসম ভুমি ও ৰাজহ অধিনিয়ম ১৮৮৬ ৰ ৩২(১) ধাৰা অনুযায়ী <b>'.(new DateTime($notice_row->payment_notice_date))->format('d M Y').'</b> তাৰিখৰ  জাননীৰ যোগে আপোনাক বন্দোৱস্তীৰ প্ৰস্তাৱ দি/আগবঢ়াই <b>'.$notice_row->total_amount.'</b> টকাৰ প্ৰিমিয়াম <b>31 Dec, 2023 </b> তাৰিখৰ ভিতৰত পৰিশোধ কৰি উক্ত প্ৰস্তাৱ গ্ৰহণ কৰিবলৈ জনোৱা হৈছিল। কিন্তু নিদ্ধাৰিত সময়সীমাৰ ভিতৰত আপুনি প্ৰিমিয়াম পৰিশোধ কৰি বন্দৱস্তীৰ প্ৰস্তাৱ গ্ৰহণ কৰাত ব্যৰ্থ হৈছে I 

                            <br><br>

                            আকৌ, অসম চৰকাৰৰ <b>31 Jan 2024</b> তাৰিখৰ <b>Ecf No441422/1</b> নং প্ৰকাশিত হোৱা অধিসূচনা যোগে প্ৰিমিয়াম পৰিশোধ কৰি বন্দৱস্তীৰ প্ৰস্তাৱ গ্ৰহণ কৰা চূড়ান্ত সময়সীমা <b>15 Feb 2024</b> তাৰিখলৈকে  বৃদ্ধি কৰা হৈছিল যদিও উপলব্ধ ৰেকৰ্ড অনুসৰি, আপুনি পুনৰবাৰ প্ৰিমিয়াম পৰিশোধ কৰি বন্দৱস্তীৰ প্ৰস্তাৱ গ্ৰহণযোগ্যতাৰ প্ৰমাণ প্ৰদান কৰাত ব্যৰ্থ হৈছে আৰু সেয়েহে সেই অধিসূচনা অনুসৰি উক্ত বন্দৱস্তীৰ প্ৰস্তাৱ বাতিল কৰা হৈছে I


                            <br><br>
                            সেয়েহে মই, নিম্ন স্বাক্ষৰকাৰী, জিলা আয়ুক্ত/বন্দোৱস্তী প্ৰাধিকাৰী, <b>'.$dist_name.'</b> জিলা,এই সিদ্ধান্তত উপনীত হৈছো যে আপুনি স্বেচ্ছামূলক আবেদন কৰা  স্বত্বেও , জিলা প্ৰশাসনৰ পৰা বন্দৱস্তীৰ প্ৰস্তাৱ আগবঢ়োৱাৰ পাছতো, আপুনি  প্ৰিমিয়াম পৰিশোধ কৰি বন্দাৱস্তীৰ বাবে আগ্ৰহী বা ইচ্ছুক নহয় I যাৰ ফলত উক্ত বন্দৱস্তীৰ প্ৰস্তাৱ ইতিমধ্যে বাতিল হৈছে কিন্তু তথাপিও আপুনি উক্ত তপশীলভুক্ত চৰকাৰী ভূমিত বে-আইনী ভাৱে দখল কৰি আছে I 

                            <br><br>

                            সেইবাবে,অসম ভুমি ও ৰাজহ অধিনিয়ম ১৮৮৬ ৰ অন্তৰ্গত বন্দাৱস্তী বিধি  ১৮ (১) অনুসৰি, আপুনি  বে-আইনী ভাৱে উক্ত ভূমিত দখল কৰি থকা হিচাপে উচ্ছেদৰ যোগ্য আৰু সেই অনুসৰি  বন্দাোৱস্তী বিধি  ১৮ (৩)  অন্তৰ্গত মোৰ ওপৰত ন্যস্ত ক্ষমতাৰ অধীনত আপোনাক উক্ত তপশীলভুক্ত চৰকাৰী ভূমিত এই জাননী প্ৰকাশ পোৱাৰ ১৫ দনৰ ভিতৰত  দখল এৰি দিবলৈ জনোৱা হ’ল। অন্যথা বিধি অনুযায়ী উচ্ছেদৰ বাবে ব্যৱস্থা গ্ৰহণ কৰা হ’ব।
                        </div>
                    </div>

                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center mt-5">
                            <b>'.$dc_name.'</b><br>
                            জিলা আয়ুক্ত <br>
                            জিলা - '.$dist_name.'
                        </div>
                    </div>
                </div>';
        }else{
            //urban cases
            $notice_content = 
                '<div class="container bg-white shadow pb-3" id="print_direct">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            অসম চৰকাৰ <br>
                            জিলা আয়ুক্তৰ কাৰ্য্যলয়: জিলা – '.$dist_name.'<br>
                            জাননী
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-3">
                            No : '.$nextval.'<input type="hidden" name="nextval" id="nextval" value="'.$nextval.'"><input type="hidden" id="case_no_id" name="case_no" value="'.$case_no.'">
                        </div>
                        <div class="col-9 text-right">
                            Dated : <span style="font-weight:bold;">'.(new DateTime(date('Y-m-d')))->format('d M Y').'</span>
                        </div>
                    </div>

                    <div class="row mt-5 px-5">
                        <div class="col-12 text-justify">
                            প্ৰতি, <b>'.$applicant_row->pdar_name.'</b>  পিতা/ স্বামী <b>'.$applicant_row->pdar_guardian.'</b>
                            <br>
                            ঠিকনা : <b>'.$applicant_row->pdar_add1.'</b>
                            
                            <br><br>

                            ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ২.০ ৰ অধীনত <b>'.$service_name.'</b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভুক্ত চৰকাৰী ভূমিৰ বাবে <b>'.(new DateTime($case_row->application_date))->format('d M Y').'</b> তাৰিখৰ <b>'.$case_row->applid.'</b> নং আবেদন  অনলাইন যোগে দাখিল কৰিছিল।
                            <br><br>

                            <table class="table table-bordered">
                                <tr class="bg-white">
                                    <th>জিলা</th>
                                    <th>ৰাজহ চক্ৰ</th>
                                    <th>মৌজা</th>
                                    <th>লাট</th>
                                    <th>গাওঁ</th>
                                    <th>দাগ</th>
                                    <th>কালি</th>
                                </tr>
                                <tr>
                                    <td>'.$dist_name.'</td>
                                    <td>'.$circle_name.'</td>
                                    <td>'.$mouza_name.'</td>
                                    <td>'.$lot_name.'</td>
                                    <td>'.$village_name.'</td>
                                    <td>'.$dag_numbers.'</td>
                                    <td>'.$area.'</td>
                                </tr>
                            </table>
                            <br>

                            আবেদন পৰীক্ষা আৰু চৰজমিন তদন্তৰ অন্তত  উক্ত তপশীলভুক্ত চৰকাৰী ভূমিত আপোনাৰ ভোগদখল থকা দেখা গৈছিল I সেই অনুযায়ী  ভূমি উপদেষ্টা সমিতিৰ <b>'.(new DateTime($sdlac_row->meeting_date))->format('d M Y').'</b> তাৰিখৰ বৈঠকৰ <b>'.$sdlac_row->meeting_name.'</b> নং সিদ্ধান্ত অনুসৰি আৰু ৰাজহ আৰু দুৰ্যোগ ব্যৱস্থাপনা বিভাগ, অসম চৰকাৰৰ <b>'.(new DateTime($case_row->dept_order_date))->format('d M Y').'</b> তাৰিখৰ <b>'.$case_row->dept_order_no.'</b> নং অধিসূচনা অনুসৰি চৰকাৰী মাটিৰ পট্টনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছিল।

                            <br><br>

                            সেই অনুসৰি,আপোনাৰ দখলত থকা উক্ত তপচিলভুক্ত চৰকাৰী ভূমিত ,অসম ভুমি ও ৰাজহ অধিনিয়ম ১৮৮৬ ৰ ৩২(১) ধাৰা অনুযায়ী <b>'.(new DateTime($notice_row->payment_notice_date))->format('d M Y').'</b> তাৰিখৰ  জাননীৰ যোগে আপোনাক বন্দোৱস্তীৰ প্ৰস্তাৱ দি/আগবঢ়াই <b>'.$notice_row->total_amount.'</b> টকাৰ প্ৰিমিয়াম সম্পূৰ্ণ বা কিস্তি হিচাপে <b>31 Dec, 2023 </b> তাৰিখৰ ভিতৰত পৰিশোধ কৰি উক্ত প্ৰস্তাৱ গ্ৰহণ কৰিবলৈ জনোৱা হৈছিল। কিন্তু নিদ্ধাৰিত সময়সীমাৰ ভিতৰত আপুনি প্ৰিমিয়াম পৰিশোধ কৰি বন্দৱস্তীৰ প্ৰস্তাৱ গ্ৰহণ কৰাত ব্যৰ্থ হৈছে I 

                            <br><br>

                            আকৌ, অসম চৰকাৰৰ <b>31 Jan 2024</b> তাৰিখৰ <b>Ecf No441422/1</b> নং প্ৰকাশিত হোৱা অধিসূচনা যোগে প্ৰিমিয়াম পৰিশোধ কৰি বন্দৱস্তীৰ প্ৰস্তাৱ গ্ৰহণ কৰা চূড়ান্ত সময়সীমা <b>15 Feb 2024</b> তাৰিখলৈকে  বৃদ্ধি কৰা হৈছিল যদিও উপলব্ধ ৰেকৰ্ড অনুসৰি, আপুনি পুনৰবাৰ প্ৰিমিয়াম পৰিশোধ কৰি বন্দৱস্তীৰ প্ৰস্তাৱ গ্ৰহণযোগ্যতাৰ প্ৰমাণ প্ৰদান কৰাত ব্যৰ্থ হৈছে আৰু সেয়েহে সেই অধিসূচনা অনুসৰি উক্ত বন্দৱস্তীৰ প্ৰস্তাৱ বাতিল কৰা হৈছে I
                            
                            <br><br>
                            সেয়েহে মই, নিম্ন স্বাক্ষৰকাৰী, জিলা আয়ুক্ত/বন্দোৱস্তী প্ৰাধিকাৰী, <b>'.$dist_name.'</b>  জিলা, এই সিদ্ধান্তত উপনীত হৈছো যে আপুনি স্বেচ্ছামূলক আবেদন কৰা  স্বত্বেও , জিলা প্ৰশাসনৰ পৰা বন্দৱস্তীৰ প্ৰস্তাৱ আগবঢ়োৱাৰ পাছতো, আপুনি  প্ৰিমিয়াম পৰিশোধ কৰি বন্দাৱস্তীৰ বাবে আগ্ৰহী বা ইচ্ছুক নহয় I যাৰ ফলত উক্ত বন্দৱস্তীৰ প্ৰস্তাৱ ইতিমধ্যে বাতিল হৈছে কিন্তু তথাপিও আপুনি উক্ত তপশীলভুক্ত চৰকাৰী ভূমিত বে-আইনী ভাৱে দখল কৰি আছে I

                            <br><br>

                           সেইবাবে,অসম ভুমি ও ৰাজহ অধিনিয়ম ১৮৮৬ ৰ অন্তৰ্গত বন্দাৱস্তী বিধি  ১৮ (১) অনুসৰি, আপুনি  বে-আইনী ভাৱে উক্ত ভূমিত দখল কৰি থকা হিচাপে উচ্ছেদৰ যোগ্য আৰু সেই অনুসৰি  বন্দাোৱস্তী বিধি  ১৮ (৩)  অন্তৰ্গত মোৰ ওপৰত ন্যস্ত ক্ষমতাৰ অধীনত আপোনাক উক্ত তপশীলভুক্ত চৰকাৰী ভূমিত এই জাননী প্ৰকাশ পোৱাৰ ১৫ দনৰ ভিতৰত  দখল এৰি দিবলৈ জনোৱা হ’ল। অন্যথা বিধি অনুযায়ী উচ্ছেদৰ বাবে ব্যৱস্থা গ্ৰহণ কৰা হ’ব।

                        </div>
                    </div>

                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center mt-5">
                            <b>'.$dc_name.'</b><br>
                            জিলা আয়ুক্ত <br>
                            জিলা - <b>'.$dist_name.'</b>
                        </div>
                    </div>
                </div>';
        }        

        if($view == true){
            //generate and view notice text
            echo json_encode([
                'responseType' => 2,
                'notice_content' => $notice_content,
                'nextval' => $nextval
            ]);
            return false;
        }
        else{
            //generate and save notice text

            $check_sql = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'E1'));

            if($check_sql->num_rows() > 0){
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR3511: Notice already generated...',
                ]);
                return false;
            }

            $this->db->trans_begin();

            $base64encoded_data = base64_encode($notice_content);
            $file_name = $this->randomFileName();

            $base_64_file_path    = EVICTION_NOTICE_PATH.$file_name.".json";
            $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
            fwrite($file_to_write_base64, $base64encoded_data);
            fclose($file_to_write_base64);

            $notice_no = "MB2/E1/".date('Y')."/".$service_short."/".$nextval;

            $s_notice = [
                'case_no'                     => $case_no,
                'service_code'                => $case_row->service_code,
                'case_registration_date'      => $case_row->application_date,
                'payment_notice_date'         => date('Y-m-d'),
                'notice_no'                   => $notice_no,
                'notice_link'                 => $base_64_file_path,
                'notice_type'                 => 'E1',
                'date_entry'                  => date('Y-m-d H:i:s')
            ];

            $n_insert = $this->db->insert('settlement_notice', $s_notice);
            if($n_insert != 1){
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR511: Unable to save notice! Something went wrong...',
                ]);
                return false;
            }

            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'next_date_of_hearing' => date('Y-m-d H:i:s'),
                'note_type' => 'Eviction Notice',
                'note_on_order' => 'Eviction Notice generated',
                'status' => 'N',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'DC',
                'office_to' => 'DC',
                'task' => 'Eviction Notice generated',
            ];
            
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) 
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR6511: Unable to save notice! Something went wrong...',
                ]);
                return false;
            }

            $this->db->trans_commit();

            echo json_encode([
                    'responseType' => 2,
                    'msg' => 'Notice successfully generated...',
                ]);
            return false;
        }
    }

    function randomFileName()
    {
        $rand = rand(00000,99999);
        $dist_code = $this->session->userdata('dist_code');
        $new_case_no = 'eviction_notice_'.$dist_code.'_'.$rand;

        $sql = $this->db->query('select * from settlement_notice where notice_link = ?', array($new_case_no.'.json'));

        if($sql->num_rows() > 0){
            $this->randomFileName();
        }else{
            return $new_case_no;
        }
    }

    public function printNoticeList(){
        $dist_code = $this->session->userdata('dist_code');

        $getCircles = $this->db->query('SELECT dist_code, subdiv_code, cir_code, uuid, loc_name FROM location WHERE dist_code = ? AND subdiv_code != ? AND cir_code != ? AND mouza_pargona_code = ?', array($dist_code, '00', '00', '00'));

        if($getCircles->num_rows() > 0){
            $data['circle_list'] = $getCircles->result();
        }
        else{
            $data['circle_list'] = false;
        }

        $data['_view'] = 'SettlementView/EvictionNotice/PrintEvictionList';
        $this->load->view('layouts/main',$data);
    }

    public function printPaginationList(){
        $application_no = $this->input->post('columns')[1]['search']['value'];
        $case_no = $this->input->post('columns')[2]['search']['value'];

        $service_code = $this->input->post('service_code');
        $circle_uuid = $this->input->post('circle_uuid');
        $lot_uuid = $this->input->post('lot_uuid');
        $village_uuid = $this->input->post('village_uuid');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $dist_code = '';
        $subdiv_code = '';
        $cir_code = '';
        $mouza_pargona_code = '';
        $lot_no = '';
        $vill_townprt_code = '';


        if(!empty($circle_uuid)) {
            $slqCicle = $this->db->query('select * from location where uuid = ?', array($circle_uuid));
            $cir_row = $slqCicle->row();
            
            $dist_code = $cir_row->dist_code;
            $subdiv_code = $cir_row->subdiv_code;
            $cir_code = $cir_row->cir_code;
        }

        if(!empty($lot_uuid)) {
            $slqLot = $this->db->query('select * from location where uuid = ?', array($lot_uuid));
            $lot_row = $slqLot->row();
            
            $dist_code = $lot_row->dist_code;
            $subdiv_code = $lot_row->subdiv_code;
            $cir_code = $lot_row->cir_code;
            $mouza_pargona_code = $lot_row->mouza_pargona_code;
            $lot_no = $lot_row->lot_no;
        }

        if(!empty($village_uuid)) {
            $slqVillage = $this->db->query('select * from location where uuid = ?', array($village_uuid));
            $village_row = $slqVillage->row();
            
            $dist_code = $village_row->dist_code;
            $subdiv_code = $village_row->subdiv_code;
            $cir_code = $village_row->cir_code;
            $mouza_pargona_code = $village_row->mouza_pargona_code;
            $lot_no = $village_row->lot_no;
            $vill_townprt_code = $village_row->vill_townprt_code;
        }

        $this->db->select('distinct(sb.case_no), sb.applid, sb.service_code, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');

        $this->db->where('sb.service_code', $service_code);
        $this->db->where('sb.dist_code', $this->session->userdata('dist_code'));

        if(!empty($subdiv_code)) {
            $this->db->where('sb.subdiv_code', $subdiv_code);
        }
        if(!empty($cir_code)){
            $this->db->where('sb.cir_code', $cir_code);
        }
        if(!empty($mouza_pargona_code)){
            $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
        }
        if(!empty($lot_no)){
            $this->db->where('sb.lot_no', $lot_no);
        }
        if(!empty($vill_townprt_code)){
            $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
        }
        if(!empty($case_no)){
            $this->db->like('sb.case_no', strtoupper($case_no));            
        }
        if(!empty($application_no)){
            $this->db->like('sb.applid', strtoupper($application_no));
        }

        $this->db->where('sb.status', 'N');
        $this->db->where('sp.grn_no is null');
        $this->db->where('sp.is_final', 1);
        $this->db->join('settlement_premium sp', 'sp.case_no = sb.case_no');
 
        $this->db->where('EXISTS (SELECT 1 FROM settlement_notice sn WHERE sn.case_no = sb.case_no AND sn.notice_type = \'E1\')', null, false);

        $this->db->limit($length, $start);

        $query = $this->db->get('settlement_basic sb');


        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $service_name = '';
                if($rows->service_code == '13'){
                    $service_name = 'Tenant';
                }if($rows->service_code == '14'){
                    $service_name = 'AP';
                }if($rows->service_code == '15'){
                    $service_name = 'Tribal';
                }if($rows->service_code == '16'){
                    $service_name = 'Khasland';
                }if($rows->service_code == '17'){
                    $service_name = 'VGR/PGR';
                }if($rows->service_code == '18'){
                    $service_name = 'Cultivation';
                }

                $json[] = array(
                    $rows->case_no,
                    '<span style= "font-size:14px;"><strong>' . $rows->applid . '</strong></span>',
                    '<span style= "font-size:14px; white-space: nowrap;"><strong>' . $rows->case_no . '</strong></span>',
                    $service_name,

                    $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    '<a alt="Print Notice" class="text-white btn btn-sm btn-success" target="PrintNotice" href="' . base_url() . 'index.php/SettlementEvictionController/printNotice?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Print Notice</a>'
                );
            }

            $this->db->select('distinct(sb.case_no), sb.applid, sb.service_code, sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code');

            $this->db->where('sb.service_code', $service_code);
            $this->db->where('sb.dist_code', $this->session->userdata('dist_code'));
    
            if(!empty($subdiv_code)) {
                $this->db->where('sb.subdiv_code', $subdiv_code);
            }
            if(!empty($cir_code)){
                $this->db->where('sb.cir_code', $cir_code);
            }
            if(!empty($mouza_pargona_code)){
                $this->db->where('sb.mouza_pargona_code', $mouza_pargona_code);
            }
            if(!empty($lot_no)){
                $this->db->where('sb.lot_no', $lot_no);
            }
            if(!empty($vill_townprt_code)){
                $this->db->where('sb.vill_townprt_code', $vill_townprt_code);
            }
            if(!empty($case_no)){
                $this->db->where('sb.case_no', $case_no);
            }
            if(!empty($application_no)){
                $this->db->where('sb.applid', $application_no);
            }
    
            $this->db->where('sb.status', 'N');
            $this->db->where('sp.grn_no is null');
            $this->db->where('sp.is_final', 1);
            $this->db->join('settlement_premium sp', 'sp.case_no = sb.case_no');
             
            $this->db->where('EXISTS (SELECT 1 FROM settlement_notice sn WHERE sn.case_no = sb.case_no AND sn.notice_type = \'E1\')', null, false);

            $query = $this->db->get('settlement_basic sb');
            $total_records = $query->num_rows();

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        }else{
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function printNotice(){
        $case_no = $this->input->get('case');
        // getting the notice file link
        $sql = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'E1'));

        if($sql->num_rows() <= 0){
            echo json_encode([
                'responseType' => 0,
                'msg'           => '#ERR815: Notice not found!'
            ]);
            return false;
        }
        $path = $sql->row()->notice_link;

        // reading the base64 json file and saving it to a variable
        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode($read_notice_file);
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];
        $data['_view'] = 'SettlementView/Co/PrintNotice';
        $this->load->view('layouts/main',$data);
    }

}