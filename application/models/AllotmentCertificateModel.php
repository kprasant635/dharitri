
<?php
    class AllotmentCertificateModel extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->dbswitch();
            $this->load->model('ChithaUpdateModel');
            $this->load->model('patta/pattamodel');
            $this->load->helper(['form', 'url']);
            $this->load->library('form_validation');
            $this->load->helper('file');
            $this->load->helper('download');
            $this->load->model('Chitha_basic_model');
            $this->load->model('NcModel/NcApiModel');
            $this->load->model('rtps/rtpsmodel');
            $this->load->model('NcModel/NcServiceModel');
            $this->load->model('NcModel/NcCommonModel');
            $this->load->model('ChithaUpdateModel');

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

        public function getChithaDagNos($case_no)
        {
            $query = $this->db->query(
                "SELECT * FROM chitha_institute_allottee WHERE case_no = ?",
                [$case_no]
            );

            if ($query->num_rows() == 0) {
                return null;
            } else {
                return $query->result();
            }
        }

        public function getChithaDagNosByOldDag($case_no, $applied_dag_no)
        {
            $query = $this->db->query(
                "SELECT * FROM chitha_institute_allottee WHERE case_no = ? and applied_dag_no = ?",
                [$case_no, $applied_dag_no]
            );

            if ($query->num_rows() == 0) {
                return null;
            } else {
                return $query->row();
            }
        }

        public function getAllotmentCertificates($dist_code)
        {
            $query = $this->db->query("SELECT * FROM settlement_basic sb WHERE sb.chitha_processing_details = 2 AND sb.order_passed = 'Y' AND sb.co_chitha_corrected_yn = 'Y' AND sb.service_code = '45' AND sb.digital_patta_offered IS NULL AND sb.allot_cert_offered IS NULL  AND EXISTS ( SELECT distinct(case_no) FROM settlement_premium WHERE case_no = sb.case_no AND is_final = 1 AND grn_no IS NOT NULL )");
            // $query = $this->db->query("select cert from dsc_registration_details where dist_code=? and status =? and subdiv_code ='00'", array($dist_code,'ACTIVE'));
            if ($query->num_rows() == 0) {
                return null;
            } else {
                return $query->result();
            }
        }

        public function getAllotmentCertificatesIssued($dist_code)
        {
            $query = $this->db->query("SELECT * FROM settlement_basic sb WHERE sb.chitha_processing_details = 2 AND sb.order_passed = 'Y' AND sb.co_chitha_corrected_yn = 'Y' AND sb.service_code = '45' AND sb.digital_patta_offered IS NULL AND sb.allot_cert_offered = '1'  AND EXISTS ( SELECT distinct(case_no) FROM settlement_premium WHERE case_no = sb.case_no AND is_final = 1 AND grn_no IS NOT NULL )");
            // $query = $this->db->query("select cert from dsc_registration_details where dist_code=? and status =? and subdiv_code ='00'", array($dist_code,'ACTIVE'));
            if ($query->num_rows() == 0) {
                return null;
            } else {
                return $query->result();
            }
        }

        // public function getSettlementCertificates($dist_code)
        // {
        //     $query = $this->db->query("SELECT * FROM settlement_basic sb WHERE sb.chitha_processing_details = 2 AND sb.order_passed = 'Y' AND sb.co_chitha_corrected_yn = 'Y' AND sb.service_code = '45' AND sb.digital_patta_offered IS NULL AND sb.allot_cert_offered IS NULL  AND EXISTS ( SELECT distinct(case_no) FROM settlement_premium WHERE case_no = sb.case_no AND is_final = 1 AND grn_no IS NOT NULL )");
        //     // $query = $this->db->query("select cert from dsc_registration_details where dist_code=? and status =? and subdiv_code ='00'", array($dist_code,'ACTIVE'));
        //     if ($query->num_rows() == 0) {
        //         return null;
        //     } else {
        //         return $query->result();
        //     }
        // }

        // public function getAllCasesAllocatedCertificate_original($start, $length, $order)
        // {

        //     $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
        //     if (! empty($searchByCol_0)) {
        //         $this->db->where('sb.case_no like \'%' . $searchByCol_0 . '%\'');

        //     }
        //     $col = 0;
        //     $dir = "";
        //     if (! empty($order)) {
        //         foreach ($order as $o) {
        //             $col = $o['column'];
        //             $dir = $o['dir'];
        //         }
        //     }
        //     if ($dir != "asc" && $dir != 'desc') {
        //         $dir = 'desc';
        //     }
        //     if ($order != null) {
        //         $this->db->order_by($order, $dir);
        //     }

        //     $this->db->select('*');
        //     $this->db->from('settlement_basic sb');
        //     $this->db->where('sb.chitha_processing_details', 2);
        //     $this->db->where('sb.order_passed', 'Y');
        //     $this->db->where('sb.co_chitha_corrected_yn', 'Y');
        //     $this->db->where('sb.service_code', '45');
        //     $this->db->where('sb.digital_patta_offered IS NULL', null, false);
        //     $this->db->where('sb.allot_cert_offered IS NULL', null, false);
        //     $this->db->where('EXISTS (
        //             SELECT DISTINCT(case_no)
        //             FROM settlement_premium
        //             WHERE case_no = sb.case_no
        //             AND is_final = 1
        //             AND grn_no IS NOT NULL
        //         )', null, false);

        //     $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
        //     if (! empty($searchByCol_0)) {
        //         $this->db->where('sb.case_no like \'%' . $searchByCol_0 . '%\'');

        //     }
        //     $col = 0;
        //     $dir = "";
        //     if (! empty($order)) {
        //         foreach ($order as $o) {
        //             $col = $o['column'];
        //             $dir = $o['dir'];
        //         }
        //     }
        //     if ($dir != "asc" && $dir != 'desc') {
        //         $dir = 'desc';
        //     }
        //     if ($order != null) {
        //         $this->db->order_by($order, $dir);
        //     }

        //     $this->db->select('*');
        //     $this->db->from('settlement_basic sb');
        //     $this->db->where('sb.chitha_processing_details', 2);
        //     $this->db->where('sb.order_passed', 'Y');
        //     $this->db->where('sb.co_chitha_corrected_yn', 'Y');
        //     $this->db->where('sb.service_code', '45');
        //     $this->db->where('sb.digital_patta_offered IS NULL', null, false);
        //     $this->db->where('sb.allot_cert_offered IS NULL', null, false);
        //     $this->db->where('EXISTS (
        //             SELECT DISTINCT(case_no)
        //             FROM settlement_premium
        //             WHERE case_no = sb.case_no
        //             AND is_final = 1
        //             AND grn_no IS NOT NULL
        //         )', null, false);

        //     $this->db->limit($length, $start); // Optional: for pagination
        //     $query = $this->db->get();

        //     // echo $this->db->last_query(); // Debugging: uncomment to see the final SQL

        //     if ($query->num_rows() > 0) {
        //         $data['data_results'] = (DIGITAL_PATTA_OPEN == 1) ? $query->result() : null;

        //         // For counting total records (without limit)
        //         $this->db->select('*');
        //         $this->db->from('settlement_basic sb');
        //         $this->db->where('sb.chitha_processing_details', 2);
        //         $this->db->where('sb.order_passed', 'Y');
        //         $this->db->where('sb.co_chitha_corrected_yn', 'Y');
        //         $this->db->where('sb.service_code', '45');
        //         $this->db->where('sb.digital_patta_offered IS NULL', null, false);
        //         $this->db->where('sb.allot_cert_offered IS NULL', null, false);
        //         $this->db->where('EXISTS (
        //                 SELECT DISTINCT(case_no)
        //                 FROM settlement_premium
        //                 WHERE case_no = sb.case_no
        //                 AND is_final = 1
        //                 AND grn_no IS NOT NULL
        //             )', null, false);

        //         $data['total_records'] = (DIGITAL_PATTA_OPEN == 1) ? $this->db->count_all_results() : 0;

        //         return $data;
        //     }

        // }

        public function getAllCasesAllocatedCertificate($start, $length, $order,  $selectService, $selectVillage, $selectCircle )
        {
            $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
            if (! empty($searchByCol_0)) {
                $this->db->where("sb.case_no LIKE '%" . $searchByCol_0 . "%'");
            }

            $col = 0;
            $dir = "";
            if (! empty($order)) {
                foreach ($order as $o) {
                    $col = $o['column'];
                    $dir = $o['dir'];
                }
            }
            if ($dir != "asc" && $dir != 'desc') {
                $dir = 'desc';
            }
            if ($order != null) {
                $this->db->order_by($order, $dir);
            }

       

            if($selectVillage != null){
                $this->db->where('sb.uuid', $selectVillage);
            }

          

            // Main query
            $this->db->select('sb.*, sid.ins_cat_type_co');
            $this->db->from('settlement_basic sb');
            $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
            $this->db->where('sb.chitha_processing_details', 2);
            $this->db->where('sb.order_passed', 'Y');
            $this->db->where('sb.co_chitha_corrected_yn', 'Y');
            $this->db->where('sb.service_code', '45');
            $this->db->where('sb.is_settlement', 0);
            $this->db->where('sb.digital_patta_offered IS NULL', null, false);
            $this->db->where('sb.allot_cert_offered IS NULL', null, false);
            $this->db->where('EXISTS (
            SELECT 1
            FROM settlement_premium
            WHERE case_no = sb.case_no
            AND is_final = 1
            AND grn_no IS NOT NULL
            )', null, false);
            
            if($selectService != null){
                $this->db->where('sid.ins_cat_type_co', $selectService);
            }

            if($selectCircle != null){
                $getCircleLocationdetails = $this->db->query("SELECT * FROM location WHERE uuid = ?", array($selectCircle));
                if($getCircleLocationdetails->num_rows() > 0){
                    $getCircleLocationdetails = $getCircleLocationdetails->row();
                }else{
                    return "Circle Not Found";
                }

                
                $this->db->where('sb.dist_code', $getCircleLocationdetails->dist_code);
                $this->db->where('sb.subdiv_code', $getCircleLocationdetails->subdiv_code);
                $this->db->where('sb.cir_code', $getCircleLocationdetails->cir_code);
            }

            $this->db->limit($length, $start);
            $query = $this->db->get();

            // echo $this->db->last_query(); // Debugging: uncomment to see the final SQL

            if ($query->num_rows() > 0) {
                $data['data_results'] = (ALLOTMENT_AND_SETTLEMENT == 1) ? $query->result() : null;

                // Count total records without pagination
                $this->db->select('COUNT(*) AS total');
                $this->db->from('settlement_basic sb');
                $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
                $this->db->where('sb.chitha_processing_details', 2);
                $this->db->where('sb.order_passed', 'Y');
                $this->db->where('sb.co_chitha_corrected_yn', 'Y');
                $this->db->where('sb.service_code', '45');
                $this->db->where('sb.is_settlement', 0);
                $this->db->where('sb.digital_patta_offered IS NULL', null, false);
                $this->db->where('sb.allot_cert_offered IS NULL', null, false);
                $this->db->where('EXISTS (
                    SELECT 1
                    FROM settlement_premium
                    WHERE case_no = sb.case_no
                    AND is_final = 1
                    AND grn_no IS NOT NULL
                )', null, false);

                if($selectService != null){
                    $this->db->where('sid.ins_cat_type_co', $selectService);
                }

                if($selectCircle != null){
                    $getCircleLocationdetails = $this->db->query("SELECT * FROM location WHERE uuid = ?", array($selectCircle));
                    if($getCircleLocationdetails->num_rows() > 0){
                        $getCircleLocationdetails = $getCircleLocationdetails->row();
                    }else{
                        return "Circle Not Found";
                    }

                    
                    $this->db->where('sb.dist_code', $getCircleLocationdetails->dist_code);
                    $this->db->where('sb.subdiv_code', $getCircleLocationdetails->subdiv_code);
                    $this->db->where('sb.cir_code', $getCircleLocationdetails->cir_code);
                }

                
                if($selectVillage != null){
                    $this->db->where('sb.uuid', $selectVillage);
                }

                

                $totalQuery            = $this->db->get()->row();
                $data['total_records'] = (DIGITAL_PATTA_OPEN == 1) ? $totalQuery->total : 0;

                return $data;
            } else {
                return null;
            }
        }

        public function getAllCasesAllocatedCertificateIssuedv2($start, $length, $order,  $selectService, $selectVillage, $selectCircle , $selectStatus, $selectCertificate)
        {
            $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
            if (! empty($searchByCol_0)) {
                $this->db->where("sb.case_no LIKE '%" . $searchByCol_0 . "%'");
            }

            $col = 0;
            $dir = "";
            if (! empty($order)) {
                foreach ($order as $o) {
                    $col = $o['column'];
                    $dir = $o['dir'];
                }
            }
            if ($dir != "asc" && $dir != 'desc') {
                $dir = 'desc';
            }
            if ($order != null) {
                $this->db->order_by($order, $dir);
            }

               if($selectVillage != null){
                $this->db->where('sb.uuid', $selectVillage);
            }

          


            // Main query
            $this->db->select('sb.*, sid.ins_cat_type_co, acn.printing_status, acn.id as issued_id, acn.certificate_no');
            $this->db->from('settlement_basic sb');
            $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
            $this->db->join('allotment_certificates_new acn', 'acn.dhar_case_no = sb.case_no', 'left');
            $this->db->where('sb.chitha_processing_details', 2);
            $this->db->where('sb.order_passed', 'Y');
            $this->db->where('sb.co_chitha_corrected_yn', 'Y');
            $this->db->where('sb.service_code', '45');
            $this->db->where('sb.is_settlement', 0);
            $this->db->where('sb.digital_patta_offered IS NULL', null, false);
            $this->db->where('sb.allot_cert_offered', '1');

            $this->db->where('EXISTS (
            SELECT 1
            FROM settlement_premium
            WHERE case_no = sb.case_no
            AND is_final = 1
            AND grn_no IS NOT NULL
            )', null, false);
              
            if($selectService != null){
                $this->db->where('sid.ins_cat_type_co', $selectService);
            }


           if ($selectCertificate != null) {
                $this->db->like('acn.certificate_no', $selectCertificate);
            }



            if(($selectStatus == 1 || $selectStatus == 0) && $selectStatus != null){

                if ($selectStatus == 1) {
                    $this->db->where('acn.printing_status', '1');
                } 
                if ($selectStatus == 0) {
                    $this->db->where('acn.printing_status <>', '1');
                }
            }



            if($selectCircle != null){
                $getCircleLocationdetails = $this->db->query("SELECT * FROM location WHERE uuid = ?", array($selectCircle));
                if($getCircleLocationdetails->num_rows() > 0){
                    $getCircleLocationdetails = $getCircleLocationdetails->row();
                }else{
                    return "Circle Not Found";
                }

                
                $this->db->where('sb.dist_code', $getCircleLocationdetails->dist_code);
                $this->db->where('sb.subdiv_code', $getCircleLocationdetails->subdiv_code);
                $this->db->where('sb.cir_code', $getCircleLocationdetails->cir_code);
            }

            $this->db->order_by('acn.id', 'DESC');
            $this->db->limit($length, $start);

            // order by sb.id desc
            // $this->db->order_by('sb.id', 'DESC');
            
            $query = $this->db->get();
            // echo $this->db->last_query(); // Debugging: uncomment to see the final SQL

            if ($query->num_rows() > 0) {
                $data['data_results'] = (ALLOTMENT_AND_SETTLEMENT == 1) ? $query->result() : null;

                
                // Count total records without pagination
                $this->db->select('COUNT(*) AS total');
                $this->db->from('settlement_basic sb');
                $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
                $this->db->join('allotment_certificates_new acn', 'acn.dhar_case_no = sb.case_no', 'left');
                $this->db->where('sb.chitha_processing_details', 2);
                $this->db->where('sb.order_passed', 'Y');
                $this->db->where('sb.co_chitha_corrected_yn', 'Y');
                $this->db->where('sb.service_code', '45');
                $this->db->where('sb.is_settlement', 0);
                $this->db->where('sb.digital_patta_offered IS NULL', null, false);
                $this->db->where('sb.allot_cert_offered', '1');
                $this->db->where('EXISTS (
                    SELECT 1
                    FROM settlement_premium
                    WHERE case_no = sb.case_no
                    AND is_final = 1
                    AND grn_no IS NOT NULL
                )', null, false);

                if($selectVillage != null){
                    $this->db->where('sb.uuid', $selectVillage);
                }

            if(($selectStatus == 1 || $selectStatus == 0) && $selectStatus != null){

                    if ($selectStatus == 1) {
                        $this->db->where('acn.printing_status', '1');
                    } 
                    if ($selectStatus == 0) {
                        $this->db->where('acn.printing_status <>', '1');
                    }
                }
                

                if($selectCircle != null){
                    $getCircleLocationdetails = $this->db->query("SELECT * FROM location WHERE uuid = ?", array($selectCircle));
                    if($getCircleLocationdetails->num_rows() > 0){
                        $getCircleLocationdetails = $getCircleLocationdetails->row();
                    }else{
                        return "Circle Not Found";
                    }

                    
                    $this->db->where('sb.dist_code', $getCircleLocationdetails->dist_code);
                    $this->db->where('sb.subdiv_code', $getCircleLocationdetails->subdiv_code);
                    $this->db->where('sb.cir_code', $getCircleLocationdetails->cir_code);
                }

                
            
               if ($selectCertificate != null) {
                    $this->db->like('acn.certificate_no', $selectCertificate);
                }



                
                if($selectService != null){
                    $this->db->where('sid.ins_cat_type_co', $selectService);
                }



                $totalQuery            = $this->db->get()->row();
                $data['total_records'] = $totalQuery->total;

                return $data;
            } else {
                return null;
            }
        }

        public function getAllCasesSettlementCertificate($start, $length, $order, $selectService, $selectVillage, $selectCircle )
        {
            $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
            if (! empty($searchByCol_0)) {
                $this->db->where("sb.case_no LIKE '%" . $searchByCol_0 . "%'");
            }

            $col = 0;
            $dir = "";
            if (! empty($order)) {
                foreach ($order as $o) {
                    $col = $o['column'];
                    $dir = $o['dir'];
                }
            }
            if ($dir != "asc" && $dir != 'desc') {
                $dir = 'desc';
            }
            if ($order != null) {
                $this->db->order_by($order, $dir);
            }

            // Main query
            $this->db->select('sb.*, sid.ins_cat_type_co');
            $this->db->from('settlement_basic sb');
            $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
            $this->db->where('sb.chitha_processing_details', 2);
            $this->db->where('sb.order_passed', 'Y');
            $this->db->where('sb.co_chitha_corrected_yn', 'Y');
            $this->db->where('sb.service_code', '45');
            $this->db->where('sb.is_settlement', 1);
            $this->db->where('sb.digital_patta_offered IS NULL', null, false);
            $this->db->where('sb.allot_cert_offered IS NULL', null, false);

              
            if($selectService != null){
                $this->db->where('sid.ins_cat_type_co', $selectService);
            }

              if($selectVillage != null){
                $this->db->where('sb.uuid', $selectVillage);
            }

            $this->db->where('EXISTS (
            SELECT 1
            FROM settlement_premium
            WHERE case_no = sb.case_no
            AND is_final = 1
            AND grn_no IS NOT NULL
            )', null, false);
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query(); // Debugging: uncomment to see the final SQL

            if ($query->num_rows() > 0) {
                $data['data_results'] = (DIGITAL_PATTA_OPEN == 1) ? $query->result() : null;

                // Count total records without pagination
                $this->db->select('COUNT(*) AS total');
                $this->db->from('settlement_basic sb');
                $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
                $this->db->where('sb.chitha_processing_details', 2);
                $this->db->where('sb.order_passed', 'Y');
                $this->db->where('sb.co_chitha_corrected_yn', 'Y');
                $this->db->where('sb.service_code', '45');
                $this->db->where('sb.is_settlement', 1);
                $this->db->where('sb.digital_patta_offered IS NULL', null, false);
                $this->db->where('sb.allot_cert_offered IS NULL', null, false);
                    if($selectService != null){
                $this->db->where('sid.ins_cat_type_co', $selectService);
            }

              if($selectVillage != null){
                $this->db->where('sb.uuid', $selectVillage);
            }
                $this->db->where('EXISTS (
                    SELECT 1
                    FROM settlement_premium
                    WHERE case_no = sb.case_no
                    AND is_final = 1
                    AND grn_no IS NOT NULL
                )', null, false);

                $totalQuery            = $this->db->get()->row();
                $data['total_records'] = (DIGITAL_PATTA_OPEN == 1) ? $totalQuery->total : 0;

                return $data;
            } else {
                return null;
            }
        }

        public function getAllCasesSettlementCertificateIssued($start, $length, $order)
        {
            $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
            if (! empty($searchByCol_0)) {
                $this->db->where("sb.case_no LIKE '%" . $searchByCol_0 . "%'");
            }

            $col = 0;
            $dir = "";
            if (! empty($order)) {
                foreach ($order as $o) {
                    $col = $o['column'];
                    $dir = $o['dir'];
                }
            }
            if ($dir != "asc" && $dir != 'desc') {
                $dir = 'desc';
            }
            if ($order != null) {
                $this->db->order_by($order, $dir);
            }

            // Main query
            $this->db->select('sb.*, sid.ins_cat_type_co');
            $this->db->from('settlement_basic sb');
            $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
            $this->db->where('sb.chitha_processing_details', 2);
            $this->db->where('sb.order_passed', 'Y');
            $this->db->where('sb.co_chitha_corrected_yn', 'Y');
            $this->db->where('sb.service_code', '45');
            $this->db->where('sb.is_settlement', 1);
            $this->db->where('sb.digital_patta_offered IS NULL', null, false);
            $this->db->where('sb.allot_cert_offered', '1');
            $this->db->where('EXISTS (
            SELECT 1
            FROM settlement_premium
            WHERE case_no = sb.case_no
            AND is_final = 1
            AND grn_no IS NOT NULL
            )', null, false);
            $this->db->limit($length, $start);
            $query = $this->db->get();
            // echo $this->db->last_query(); // Debugging: uncomment to see the final SQL

            if ($query->num_rows() > 0) {
                $data['data_results'] = (DIGITAL_PATTA_OPEN == 1) ? $query->result() : null;

                // Count total records without pagination
                $this->db->select('COUNT(*) AS total');
                $this->db->from('settlement_basic sb');
                $this->db->join('settlement_institution_details sid', 'sid.case_no = sb.case_no', 'left');
                $this->db->where('sb.chitha_processing_details', 2);
                $this->db->where('sb.order_passed', 'Y');
                $this->db->where('sb.co_chitha_corrected_yn', 'Y');
                $this->db->where('sb.service_code', '45');
                $this->db->where('sb.is_settlement', 1);
                $this->db->where('sb.digital_patta_offered IS NULL', null, false);
                $this->db->where('sb.allot_cert_offered', '1');
                $this->db->where('EXISTS (
                    SELECT 1
                    FROM settlement_premium
                    WHERE case_no = sb.case_no
                    AND is_final = 1
                    AND grn_no IS NOT NULL
                )', null, false);

                $totalQuery            = $this->db->get()->row();
                $data['total_records'] = (DIGITAL_PATTA_OPEN == 1) ? $totalQuery->total : 0;

                return $data;
            } else {
                return null;
            }
        }

        public function getSettlementBasicDetails($app_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_basic WHERE status=? AND applid=?", ['N', $app_no]);
            if ($query->num_rows() == 0) {
                return "No Data Found";
            } else {
                return $result = $query->row();
            }
        }

        public function getApplidFromCaseNo($case_no)
        {

            $CI = &get_instance();
            $d  = $CI->session->userdata['dist_code'];
            $this->dbswitch($d);
            $applid = $this->db->query("select applid from settlement_basic where case_no ='$case_no'");
            return $applid->row()->applid;
        }

        //getting rtps refernce no
        public function getRtpsRefNo($application_no)
        {

            $ref_no_query = $this->db->select('ref_no')
                ->where('applid', $application_no)
                ->from('settlement_basic')
                ->get();
            if ($ref_no_query->num_rows() > 0) {

                $rtps_no = $ref_no_query->row()->ref_no;

            } else {
                $rtps_no = "NO DATA FOUND";
            }

            return $rtps_no;
        }

        public function getPattaInfo($applno)
        {
            $error_msgs = [];
            //getting settlement basic details
            $settlementBasic = $this->getSettlementBasicDetails($applno);
            if ($settlementBasic != "No Data Found") {
                $settlement_basic_details = $settlementBasic;
            } else {
                $settlement_basic_details = null;
                log_message('error', '#AllocatedCertificate00001,settlement basic details not found for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate00001, SOME ERROR OCCURED, for Case NO .' . $applno . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'applno'       => $applno,
                ];
            }
            $case_no = $settlementBasic->case_no;

            $sb_status = $settlementBasic->status;
            //checking whether status is N or not 
            if (trim($sb_status) != 'N') {
                log_message('error', '#AllocatedCertificate001,settlement basic status is not found to be N for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate001, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking service code 
            if (trim($settlementBasic->service_code) == '' || $settlementBasic->service_code == null) {
                log_message('error', '#AllocatedCertificate002, service code not found in settlement basic for case_no ' . $case_no);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate002, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking dist_code      
            if (trim($settlementBasic->dist_code) == '' || $settlementBasic->dist_code == null) {
                log_message('error', '#AllocatedCertificate003, dist_code not found in settlement basic for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate003, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking subdiv_code
            if (trim($settlementBasic->subdiv_code) == '' || $settlementBasic->subdiv_code == null) {
                log_message('error', '#AllocatedCertificate004, subdiv_code not found in settlement basic for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate004, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking cir_code
            if (trim($settlementBasic->cir_code) == '' || $settlementBasic->cir_code == null) {
                log_message('error', '#AllocatedCertificate005, cir_code not found in settlement basic for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate005, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking mouza_pargona_code
            if (trim($settlementBasic->mouza_pargona_code) == '' || $settlementBasic->mouza_pargona_code == null) {
                log_message('error', '#AllocatedCertificate006, mouza_pargona_code not found in settlement basic for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate006 , SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking lot_no
            if (trim($settlementBasic->lot_no) == '' || $settlementBasic->lot_no == null) {
                log_message('error', '#AllocatedCertificate007, lot_no not found in settlement basic for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate007, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //checking vill_townprt_code
            if (trim($settlementBasic->vill_townprt_code) == '' || $settlementBasic->vill_townprt_code == null) {
                log_message('error', '#AllocatedCertificate008, vill_townprt_code not found in settlement basic for applid ' . $applno);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate008, SOME ERROR OCCURED, for Case NO .' . $case_no . '. PLEASE CONTACT ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //geteting settlement applicant data
            $applicant_data_query = $this->getSettlememtApplicant_data($case_no);
            if ($applicant_data_query != "NOT-FOUND") {
                $settlement_applicant_data = $applicant_data_query;
            } else {
                //if applicant data is not found throw error and return
                $settlement_applicant_data = null;
                log_message('error', '#AllocatedCertificate1009, Applicant detials not found for the case no  ' . $case_no);
                return [
                    'result'       => false,
                    'msg'          => 'ERROR-CODE:#AllocatedCertificate1009, Applicant detials not found ,for Case NO .' . $case_no,
                    'responseType' => 3,
                    'case_no'      => $case_no,
                ];
            }

            //getting digital patta applicant details from chitha_settlement_allottee where is applicant is 1
            // $applicant_query = $this->getApplicantDetails($case_no);
            // if($applicant_query !="NOT-FOUND"){
            //     $applicant_data = $applicant_query;
            // }else{
            //     //if applicant data is not found throw error and return
            //     $applicant_data = null;
            //     log_message('error', '#AllocatedCertificate009, Applicant details not found for the case no  '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate009, Applicant detials not found ,for Case NO .'.$case_no,
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ]; 
            // }

            // //checking settlement_name 
            // if(trim($applicant_query->settlement_name) == "" || $applicant_query->settlement_name == null){
            //     log_message('error', '#AllocatedCertificate0010, settlement_name not found for applicant in chitha settlement allottee for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0010, SOME ERROR OCCURED, for Case NO .'.$case_no.'.  PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking settlement_guardian
            // if(trim($applicant_query->settlement_guardian) == "" || $applicant_query->settlement_guardian == null){
            //     log_message('error', '#AllocatedCertificate0011, settlement_guardian not found for applicant in settlement_allotee for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0011, for Case NO .'.$case_no.'. SOME ERROR OCCURED, PLEASE CONTACT ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking grn_no
            // if(trim($applicant_query->grn_no) == "" || $applicant_query->grn_no == null){
            //     log_message('error', '#AllocatedCertificate0012, grn_no not found for applicant in settlement_allottee for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0012, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking identity type
            // if(trim($applicant_query->identity_type) == "" || $applicant_query->identity_type == null){
            //     log_message('error', '#AllocatedCertificate0013, identity_type not found for applicant in settlement_allottee for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0013, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //getting settlement_applicant details from chitha pattadar
            // $chitha_pattadar_applicant_query = $this->getAllDetailsOfApplicant($case_no);
            // if($chitha_pattadar_applicant_query !="NOT-FOUND"){
            //     $chitha_pattadar_applicant_data = $chitha_pattadar_applicant_query;
            // }else{
            //     $chitha_pattadar_applicant_data = null;
            //     log_message('error', '#AllocatedCertificate0014, Pattadar details not found for the case no  '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0014, Pattadar details not found ,for Case NO .'.$case_no,
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ]; 
            // }

            // // fetching out the location of the new patta
            // $dist_code = $chitha_pattadar_applicant_query->dist_code;
            // $subdiv_code = $chitha_pattadar_applicant_query->subdiv_code;
            // $cir_code = $chitha_pattadar_applicant_query->cir_code;
            // $mouza_pargona_code = $chitha_pattadar_applicant_query->mouza_pargona_code;
            // $lot_no = $chitha_pattadar_applicant_query->lot_no;
            // $vill_townprt_code = $chitha_pattadar_applicant_query->vill_townprt_code;
            // $patta_type_code = $chitha_pattadar_applicant_query->patta_type_code;
            // $patta_no = $chitha_pattadar_applicant_query->patta_no;

            // //checking case_no
            // if(trim($chitha_pattadar_applicant_query->o1_case_no) == "" || $chitha_pattadar_applicant_query->o1_case_no == null){
            //     log_message('error', '#AllocatedCertificate0015, o1_case_no_caste not found for applicant in chitha_pattadar for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0015, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking pdar_caste
            // if(trim($chitha_pattadar_applicant_query->pdar_caste) == "" || $chitha_pattadar_applicant_query->pdar_caste == null){
            //     log_message('error', '#AllocatedCertificate0017, pdar_caste not found for applicant in chitha_pattadar for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0017, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking pdar_add1
            // if(trim($chitha_pattadar_applicant_query->pdar_add1) == "" || $chitha_pattadar_applicant_query->pdar_add1 == null){
            //     log_message('error', '#AllocatedCertificate0018, pdar_add1 not found for applicant in chitha_pattadar for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0018, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking pdar_name
            // if(trim($chitha_pattadar_applicant_query->pdar_name) == "" || $chitha_pattadar_applicant_query->pdar_name == null){
            //     log_message('error', '#AllocatedCertificate0019, pdar_name not found for applicant in chitha_pattadar for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0019, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking patta_no
            // if(trim($chitha_pattadar_applicant_query->patta_no) == "" || $chitha_pattadar_applicant_query->patta_no == null){
            //     log_message('error', '#AllocatedCertificate0020, patta_no not found for applicant in chitha_pattadar for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0020, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //checking dob
            // if(trim($chitha_pattadar_applicant_query->dob) == "" || $chitha_pattadar_applicant_query->dob == null){
            //     log_message('error', '#AllocatedCertificate0021, dob not found for applicant in chitha_pattadar for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0021, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];            
            // }

            // //getting joint applicant details
            // $applicant_details_query = $this->getJointApplicantDetails($case_no);
            // if($applicant_details_query !="NOT-FOUND"){
            //     $joint_applicant_data = $applicant_details_query;
            // }else{
            //     $joint_applicant_data = [];
            // }

            // //geting family details from chitha_nominee_pattadar
            // $family_details_query = $this->getFamilyDetailsFromLocation($dist_code,
            //                                                         $subdiv_code,$cir_code,$mouza_pargona_code,
            //                                                         $lot_no,$vill_townprt_code,
            //                                                         $patta_type_code,$patta_no);
            // if($family_details_query !="NOT-FOUND"){
            //     $family_details = $family_details_query; 
            //     foreach ($family_details_query as $family_detail):
            //         //checking nominee_name
            //         if(trim($family_detail->nominee_name) == "" || $family_detail->nominee_name == null){
            //             log_message('error', '#AllocatedCertificate0025, nominee_name not found in chitha_nominee_pattadar for case_no '. $case_no);
            //             return [
            //                 'result' => false, 
            //                 'msg' => 'ERROR-CODE:#AllocatedCertificate0025, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //                 'responseType' => 3,
            //                 'case_no' => $case_no
            //             ];            
            //         }

            //         //checking nominee_address
            //         if(trim($family_detail->nominee_address) == "" || $family_detail->nominee_address == null){
            //             log_message('error', '#AllocatedCertificate0026, nominee_address not found in chitha_nominee_pattadar for case_no '. $case_no);
            //             return [
            //                 'result' => false, 
            //                 'msg' => 'ERROR-CODE:#AllocatedCertificate0026, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //                 'responseType' => 3,
            //                 'case_no' => $case_no
            //             ];            
            //         }

            //         //checking nominee_relation
            //         if(trim($family_detail->nominee_relation) == "" || $family_detail->nominee_relation == null){
            //             log_message('error', '#AllocatedCertificate0027, nominee_relation not found in chitha_nominee_pattadar for case_no '. $case_no);
            //             return [
            //                 'result' => false, 
            //                 'msg' => 'ERROR-CODE:#AllocatedCertificate0027, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //                 'responseType' => 3,
            //                 'case_no' => $case_no
            //             ];            
            //         }
            //     endforeach;
            // }else{
            //     $family_details = [];
            // }

            // //geting chitha_settlement_allottee details from case no
            // $chitha_allottee_details = $this->getChithaAlloteeDetailsFromcaseNo($case_no);
            // if($chitha_allottee_details !="No Data Found"){
            //     $allotee_details = $chitha_allottee_details; 
            // }else{
            //     $allotee_details = null;
            //     log_message('error', '#AllocatedCertificate0028, chitha settlemet allotee details not found for the case no  '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0028, chitha settlemet allotee details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];
            // }

            // //geting chitha basic details from location
            // $chitha_basic_details = $this->getChithaBasicDetailsFromLocation($dist_code,
            //                                                         $subdiv_code,$cir_code,$mouza_pargona_code,
            //                                                         $lot_no,$vill_townprt_code,
            //                                                         $patta_type_code,$patta_no);
            // if($chitha_basic_details !="NOT-FOUND"){
            //     $chitha_basic = $chitha_basic_details; 
            // }else{
            //     $chitha_basic = null;
            //     log_message('error', '#AllocatedCertificate0029, chitha basic details not found for the case no  '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0029, chitha basic details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];
            // }
            // foreach($chitha_basic_details as $chitha_basic_detail):
            //     //checking chitha_Old_dag no
            //     if(trim($chitha_basic_detail->old_dag_no) == "" || $chitha_basic_detail->old_dag_no == null){

            //         $check_old_dag = $this->AllocatedCertificateDagDetailsModel->checkOldDagNo($case_no,$chitha_basic_detail->dag_no,$chitha_basic_detail->old_dag_no);
            //         if($check_old_dag =="SAME_DAG"){
            //             $chitha_basic_detail->old_dag_no = "N/A";
            //         }else{
            //             $chitha_basic_detail->old_dag_no = '--';
            //             // log_message('error', '#AllocatedCertificate0030, old_dag_no not found in chitha_basic for case_no '. $case_no);
            //             // return [
            //             //     'result' => false, 
            //             //     'msg' => 'ERROR-CODE:#AllocatedCertificate0030, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             //     'responseType' => 3,
            //             //     'case_no' => $case_no
            //             // ]; 
            //         }

            //     }

            //     //checking new dag no
            //     if(trim($chitha_basic_detail->dag_no) == "" || $chitha_basic_detail->dag_no == null){
            //         log_message('error', '#AllocatedCertificate0031, dag_no not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0031, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking old patta no
            //     if(trim($chitha_basic_detail->old_patta_no) == "" || $chitha_basic_detail->old_patta_no == null){
            //         if($settlementBasic->service_code !='13' || $settlementBasic->service_code !='14'){
            //             $chitha_basic_detail->old_patta_no ='0';
            //         }else{
            //             log_message('error', '#AllocatedCertificate0032, old_patta_no not found in chitha_basic for case_no '. $case_no);
            //             return [
            //                 'result' => false, 
            //                 'msg' => 'ERROR-CODE:#AllocatedCertificate0032, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //                 'responseType' => 3,
            //                 'case_no' => $case_no
            //             ];  
            //         }           
            //     }

            //     //checking patta no
            //     if(trim($chitha_basic_detail->patta_no) == "" || $chitha_basic_detail->patta_no == null){
            //         log_message('error', '#AllocatedCertificate0033, patta_no not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0033, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking land_class_code
            //     if(trim($chitha_basic_detail->land_class_code) == "" || $chitha_basic_detail->land_class_code == null){
            //         log_message('error', '#AllocatedCertificate0034, land_class_code not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0034, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking land_class_code
            //     if(trim($chitha_basic_detail->land_class_code) == '0134'){
            //         log_message('error', '#AllocatedCertificate01134, land_class_code not found to be shreni nai in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate01134, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking dag_revenue
            //     if(trim($chitha_basic_detail->dag_revenue) == "" || $chitha_basic_detail->dag_revenue == null || $chitha_basic_detail->dag_revenue == 0){
            //         log_message('error', '#AllocatedCertificate0035, dag_revenue not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0035, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking dag_local_tax
            //     if(trim($chitha_basic_detail->dag_local_tax) == "" || $chitha_basic_detail->dag_local_tax == null || $chitha_basic_detail->dag_local_tax == 0){
            //         log_message('error', '#AllocatedCertificate0036, dag_local_tax not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0036, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking north village
            //     if(trim($chitha_basic_detail->dag_n_desc) == "" || $chitha_basic_detail->dag_n_desc == null){
            //         log_message('error', '#AllocatedCertificate0037, dag_n_desc not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0037, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     $chitha_basic_detail->dag_n_desc = $this->AllocatedCertificateDagDetailsModel->getVillagenameFromLocation($dist_code,
            //                                                                     $subdiv_code,$cir_code,$mouza_pargona_code,
            //                                                                     $lot_no,$vill_townprt_code);

            //     if($chitha_basic_detail->dag_n_desc == "NOT-FOUND"){
            //         log_message('error', '#AllocatedCertificate0138, dag_n_des not found in location for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0138, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];  
            //     }
            //     // ****************************
            //     //checking south village
            //     if(trim($chitha_basic_detail->dag_s_desc) == "" || $chitha_basic_detail->dag_s_desc == null){
            //         log_message('error', '#AllocatedCertificate0038, dag_s_desc not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0038, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }
            //     $chitha_basic_detail->dag_s_desc = $this->AllocatedCertificateDagDetailsModel->getVillagenameFromLocation($dist_code,
            //                                                                     $subdiv_code,$cir_code,$mouza_pargona_code,
            //                                                                     $lot_no,$vill_townprt_code);

            //     if($chitha_basic_detail->dag_s_desc == "NOT-FOUND"){
            //     log_message('error', '#AllocatedCertificate0139, dag_s_des not found in location for case_no '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0139, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //         ];  
            //     }
            //     // ****************************
            //     //checking east village
            //     if(trim($chitha_basic_detail->dag_e_desc) == "" || $chitha_basic_detail->dag_e_desc == null){
            //         log_message('error', '#AllocatedCertificate0039, dag_e_desc not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0039, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }
            //     $chitha_basic_detail->dag_e_desc = $this->AllocatedCertificateDagDetailsModel->getVillagenameFromLocation($dist_code,
            //                                                                     $subdiv_code,$cir_code,$mouza_pargona_code,
            //                                                                     $lot_no,$vill_townprt_code);

            //     if($chitha_basic_detail->dag_e_desc == "NOT-FOUND"){
            //         log_message('error', '#AllocatedCertificate0140, dag_e_des not found in location for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0140, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];  
            //     }
            //     // *********************
            //     //checking west village
            //     if(trim($chitha_basic_detail->dag_w_desc) == "" || $chitha_basic_detail->dag_w_desc == null){
            //         log_message('error', '#AllocatedCertificate0040, dag_w_desc not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0040, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     $chitha_basic_detail->dag_w_desc = $this->AllocatedCertificateDagDetailsModel->getVillagenameFromLocation($dist_code,
            //                                                                     $subdiv_code,$cir_code,$mouza_pargona_code,
            //                                                                     $lot_no,$vill_townprt_code);
            //     if($chitha_basic_detail->dag_w_desc == "NOT-FOUND"){
            //         log_message('error', '#AllocatedCertificate0141, dag_w_desc not found in location for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0141, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];  
            //     }

            //     //checking north dag
            //     if(trim($chitha_basic_detail->dag_n_dag_no) == "" || $chitha_basic_detail->dag_n_dag_no == null){
            //         log_message('error', '#AllocatedCertificate0041, dag_n_dag_no not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0041, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking south dag
            //     if(trim($chitha_basic_detail->dag_s_dag_no) == "" || $chitha_basic_detail->dag_s_dag_no == null){
            //         log_message('error', '#AllocatedCertificate0042, dag_s_dag_no not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0042, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking west dag
            //     if(trim($chitha_basic_detail->dag_w_dag_no) == "" || $chitha_basic_detail->dag_w_dag_no == null){
            //         log_message('error', '#AllocatedCertificate0043, dag_w_dag_no not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0043, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }

            //     //checking east dag
            //     if(trim($chitha_basic_detail->dag_e_dag_no) == "" || $chitha_basic_detail->dag_e_dag_no == null){
            //         log_message('error', '#AllocatedCertificate0044, dag_e_dag_no not found in chitha_basic for case_no '. $case_no);
            //         return [
            //             'result' => false, 
            //             'msg' => 'ERROR-CODE:#AllocatedCertificate0044, SOME ERROR OCCURED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
            //             'responseType' => 3,
            //             'case_no' => $case_no
            //         ];            
            //     }
            // endforeach;

            //geting longitude and latitude details from application_no 
            // $geo_co_ordinate_details = $this->getGeoCordinatesFromAppNo($applno);
            // if($geo_co_ordinate_details !="No Data Found"){
            //     $geo_co_ordinates = $geo_co_ordinate_details; 
            // }else{
            //     $geo_co_ordinates = null;
            //     log_message('error', '#AllocatedCertificate0045, supportive_document_mobile details not found for the case no  '. $case_no);
            //     return [
            //         'result' => false, 
            //         'msg' => 'ERROR-CODE:#AllocatedCertificate0045, geo co-ordinate details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
            //         'responseType' => 3,
            //         'case_no' => $case_no
            //     ];
            // }

            return [
                "result"                   => true,
                'responseType'             => 2,
                "errors"                   => $error_msgs,
                "settlement_applicant"     => $settlement_applicant_data,
                "settlement_basic_details" => $settlement_basic_details,
                // "applicant_data" => $applicant_data,
                // "chitha_pattadar_applicant_data" => $chitha_pattadar_applicant_data,
                // "chitha_settlement_allotee" => $allotee_details,
                // "chitha_basic" => $chitha_basic,
                // "joint_applicant_data" => $joint_applicant_data,
                // "family_details" => $family_details,
                // "co_ordinates" => $geo_co_ordinates,
            ];
        }

        public function getDistrictNameEng($dist_code)
        {
            $district = $this->db->query("select locname_eng AS district from location where dist_code ='$dist_code'  and "
                . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'");
            return $district->row()->district;
        }

        public function checkPartialPaymentStatusInBasundhara($application_no)
        {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL            => CHECK_SETTLEMENT_MB2_PARTIAL_PAYMENT,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => [
                    'application_no' => $application_no,
                ],
            ]);
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($httpcode == 200) {
                //return "curl successfull";
                $response_obj = json_decode($response);
                if ($response_obj->result == "Y") {
                    return ['result' => 'SUCCESS', 'msg' => 'Partial payment fully completed'];
                } else {
                    log_message("error", "#DIGIPPY001, Curl Error(Y) In Api " . CHECK_SETTLEMENT_MB2_PARTIAL_PAYMENT);
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured , Error-Code : #DIGIPPY001'];
                }
            } else {
                log_message("error", "#DIGIPPY002, Curl Error(200) In Api " . CHECK_SETTLEMENT_MB2_PARTIAL_PAYMENT);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #DIGIPPY002'];
            }
        }

        public function getApplicantDetails($case_no)
        {
            $query = $this->db->select('*')
                ->where('is_applicant', 1)
                ->where('case_no', $case_no)
                ->from('chitha_settlement_allottee')
                ->get();

            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }
        }

        public function getSettlememtApplicant_data($case_no)
        {
            $query = $this->db->query("select * from settlement_applicant where is_applicant =1 and case_no=?", [$case_no]);
            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }

        }

        public function getAllDetailsOfApplicant($case_no)
        {
            // $query = $this->db->query("Select * from chitha_pattadar where o1_case_no =? and (pdar_aadharno is not null or pdar_aadharno='' or pdar_pan_no is not null or pdar_pan_no ='' or pdar_nrcno is not null or pdar_nrcno='')",array($case_no));
            $query = $this->db->query("SELECT *
        FROM chitha_pattadar
        WHERE o1_case_no = ? and pdar_occupation is not null
        AND (pdar_aadharno IS NOT NULL OR pdar_aadharno != ''
        or pdar_pan_no is not null or pdar_pan_no !=''
        or pdar_nrcno is not null or pdar_nrcno !='')
        AND (CHAR_LENGTH(pdar_aadharno) > 5 or CHAR_LENGTH(pdar_pan_no) > 5 or char_length(pdar_nrcno) > 5)", [$case_no]);
            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }

        }

        public function getJointApplicantDetails($case_no)
        {
            // $query = $this->db->query("Select * from chitha_pattadar where o1_case_no =? and pdar_aadharno is null and  pdar_pan_no is null and pdar_nrcno is null",array($case_no));
            $query = $this->db->query("SELECT *
        FROM chitha_pattadar
        WHERE o1_case_no = ?
        and (pdar_pan_no is null or pdar_pan_no ='') and (pdar_nrcno  is null or pdar_nrcno ='')
        and (pdar_aadharno ='' or pdar_aadharno is null)", [$case_no]);
            if ($query->num_rows() != 0) {
                return $query->result();
            } else {
                return "NOT-FOUND";
            }
        }

        public function getFamilyDetailsFromLocation($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no)
        {
            $query = $this->db->select('*')
                ->where('dist_code', $dist_code)
                ->where('subdiv_code', $subdiv_code)
                ->where('cir_code', $cir_code)
                ->where('mouza_pargona_code', $mouza_pargona_code)
                ->where('lot_no', $lot_no)
                ->where('vill_townprt_code', $vill_townprt_code)
                ->where('patta_type_code', $patta_type_code)
                ->where('patta_no', $patta_no)
                ->from('chitha_nominee_pattadar')
                ->get();
            if ($query->num_rows() != 0) {
                return $query->result();
            } else {
                return "NOT-FOUND";
            }
        }

        public function getChithaAlloteeDetailsFromcaseNo($case_no)
        {

            $query = $this->db->query("Select * from chitha_settlement_allottee where case_no =? ", [$case_no]);
            if ($query->num_rows() != 0) {
                return $query->result();
            } else {
                return "NOT-FOUND";
            }
        }

        public function getChithaBasicDetailsFromLocation($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no)
        {
            $query = $this->db->select('*')
                ->where('dist_code', $dist_code)
                ->where('subdiv_code', $subdiv_code)
                ->where('cir_code', $cir_code)
                ->where('mouza_pargona_code', $mouza_pargona_code)
                ->where('lot_no', $lot_no)
                ->where('vill_townprt_code', $vill_townprt_code)
                ->where('patta_type_code', $patta_type_code)
                ->where('patta_no', $patta_no)
                ->where('dag_n_desc is not null')
                ->where('dag_s_desc is not null')
                ->where('dag_w_desc is not null')
                ->where('dag_e_desc is not null')
                ->from('chitha_basic')
                ->get();
            if ($query->num_rows() != 0) {
                return $query->result();
            } else {
                return "NOT-FOUND";
            }
        }

        public function getGeoCordinatesFromAppNo($application_no)
        {
            $query = $this->db->query("select * from supportive_document_mobile where applid=?", [$application_no]);
            if ($query->num_rows() == 0) {
                return "No Data Found";
            } else {
                return $result = $query->row();
            }
        }

        public function checkChithaUpdateStatusForPartialPayment($case_no)
        {
            $sql = $this->db->query("SELECT DISTINCT(sp.case_no) FROM settlement_premium sp JOIN chitha_rmk_ordbasic crb ON sp.case_no = crb.ord_no
                                join settlement_basic sb on sb.case_no = crb.case_no join settlement_emi_history seh on seh.case_no = crb.ord_no
                                WHERE seh.chitha_update_status =? and sb.order_passed is not null and sp.due_amount > sp.paid_amount AND sp.grn_no is not null
                                and sp.is_final = ? AND crb.partial_pay_status = ? and sp.case_no = ?", [5, 1, 1, $case_no]);
            if ($sql->num_rows() <= 0) {
                return 'N';
            } else {
                return 'Y';
            }
        }

        public function insertAllAllocatedCertificateDataWithoutPdf($application_no, $rtps_no, $patta_info, $dhar_case_no)
        {
            $query1  = $this->db->query("select distinct dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,uuid,service_code from settlement_basic where applid =?", [$application_no]);
            $result1 = $query1->row();

            $this->db->trans_begin();
            $insert_data = [
                'application_no'     => $application_no,
                'case_no'            => $dhar_case_no,
                'rtps_ref_no'        => $rtps_no,
                'dist_code'          => $result1->dist_code,
                'subdiv_code'        => $result1->subdiv_code,
                'cir_code'           => $result1->cir_code,
                'mouza_pargona_code' => $result1->mouza_pargona_code,
                'lot_no'             => $result1->lot_no,
                'vill_townprt_code'  => $result1->vill_townprt_code,
                'uuid'               => $result1->uuid,
                'service_code'       => $result1->service_code,
                'created_at'         => date('Y-m-d'),
                'modified_at'        => null,
                'status'             => 'P',
                'all_data_json'      => json_encode($patta_info),
                'user_data'          => json_encode($this->session->all_userdata()),
            ];
            $tstatus1 = $this->db->insert('allotment_certificates_new', $insert_data);

            if ($tstatus1 != 1) {
                $this->db->trans_rollback();
                log_message("error", "#EKCOF002, Error in insert on allotment_certificates_new table with query- " . $this->db->last_query());
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCOF002'];
            } else {
                $update_data = [
                    'date_update'        => date('Y-m-d h:i:s'),
                    'allot_cert_offered' => '1',
                ];
                $this->db->where('case_no', $dhar_case_no);
                $this->db->update('settlement_basic', $update_data);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message("error", "#DIGITA_PATTA_SETTLEMENT_BASIC1, Error in update, table 'settlement_basic ' with query- " . json_encode($this->db->last_query()));
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #DIGITA_PATTA_SETTLEMENT_BASIC1'];
                } else {
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'INSERTED SUCCESSFULLYY'];
                }

            }

        }

        public function checkPartialPayment($case_no)
        {
            $sql = $this->db->query("select * from settlement_premium where case_no=? and is_final=? and due_amount > paid_amount", [$case_no, 1]);
            if ($sql->num_rows() <= 0) {
                return 'N';
            } else {
                return 'Y';
            }
        }

        public function getInstitutionDetails($case_no)
        {
            $query = $this->db->query("
        SELECT settlement_institution_details.* , ins_master_category.category_name
        FROM settlement_institution_details
        JOIN ins_master_category
        ON ins_master_category.id::text = settlement_institution_details.ins_cat_type_co
        WHERE settlement_institution_details.case_no = ?", [$case_no]);

            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }
        }

        public function getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code)
        {
            $query = $this->db->query("SELECT uuid FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code]);
            if ($query->num_rows() != 0) {
                return $query->row('uuid');
            } else {
                return "NOT-FOUND";
            }

        }

        public function getLocationDetails($case_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", [$case_no]);

            if ($query->num_rows() != 0) {
                $row = $query->row();

                // Extract codes from the settlement_basic row
                $dist_code    = $row->dist_code;
                $subdiv_code  = $row->subdiv_code;
                $cir_code     = $row->cir_code;
                $mouza_code   = $row->mouza_pargona_code;
                $lot_no       = $row->lot_no;
                $village_code = $row->vill_townprt_code;

                // Prepare and run the location name queries
                $district_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = '00' AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code])->row('locname_eng');

                $subdiv_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code])->row('locname_eng');

                $cir_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code])->row('locname_eng');

                $mouza_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code])->row('locname_eng');

                $lot_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no])->row('locname_eng');

                $village_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code])->row('locname_eng');

                // Merge and return
                return [
                    'settlement'    => $row,
                    'district_name' => $district_name,
                    'subdiv_name'   => $subdiv_name,
                    'cir_name'      => $cir_name,
                    'mouza_name'    => $mouza_name,
                    'lot_name'      => $lot_name,
                    'village_name'  => $village_name,
                ];
            } else {
                return "NOT-FOUND";
            }
        }

        public function getDagDetails($case_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);

            if ($query->num_rows() != 0) {
                $row = $query->result();
                return $row;
            } else {
                return "NOT-FOUND";
            }
        }

        public function getLocationName($dist_code, $subdiv_code = null, $cir_code = null, $mouza_code = null, $lot_no = null, $village_code = null)
        {
            // Construct the base query
            $query = "SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? LIMIT 1";

            // Use default values if codes are not provided
            if (is_null($subdiv_code)) {
                $subdiv_code = '00';
            }

            if (is_null($cir_code)) {
                $cir_code = '00';
            }

            if (is_null($mouza_code)) {
                $mouza_code = '00';
            }

            if (is_null($lot_no)) {
                $lot_no = '00';
            }

            if (is_null($village_code)) {
                $village_code = '00000';
            }

            // Execute the query with parameters
            return $this->db->query($query, [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code])->row('locname_eng');
        }

        public function generateCertificateNumber()
        {
            $year   = date('Y');
            $prefix = 'ACER';

            do {
                $randomNumber  = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT); // 5-digit random number
                $certificateNo = "{$year}/{$prefix}/{$randomNumber}";

                // Check if certificate number already exists
                $query  = $this->db->query("SELECT COUNT(*) as count FROM allotment_certificates_new WHERE certificate_no = ?", [$certificateNo]);
                $exists = $query->row()->count > 0;

            } while ($exists); // Loop until a unique number is found

            return $certificateNo;
        }

        public function getOtherDetails($case_no)
        {
            $getCategory = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", [$case_no]);

            if ($getCategory->num_rows() != 0) {
                $category    = $getCategory->row();
                $category_id = $category->ins_cat_type_co;
                if ($category_id == "12") {
                    $registrationDetails = $this->db->query("SELECT * FROM settlement_ap_lmnote WHERE case_no = ?", [$case_no]);
                    if ($registrationDetails->num_rows() != 0) {
                        $registration      = $registrationDetails->row();
                        $registration_no   = $registration->registration_no;
                        $registration_date = $registration->registration_date;
                        $texttoDb          = "Registration No: " . $registration_no . " Registration Date: " . $registration_date;
                    } else {
                        $texttoDb = "";
                    }

                } else if (in_array($category_id, [8, 9, 10, 11])) {
                    $texttoDb = "Department Name: " . $category->dept_of_co;
                }

                return $texttoDb;

            } else {
                return "NOT-FOUND";
            }
        }

        public function insertCertificateData_old($data)
        {
            try {

                // frist check if certificate number already exists
                $query  = $this->db->query("SELECT COUNT(*) as count FROM allotment_certificates_new WHERE dhar_case_no = ?", [$data['dhar_case_no']]);
                $exists = $query->row()->count > 0;
                if ($exists) {
                    return [
                        'result' => 'SUCCESS',
                        'error'  => 'Certificate number already exists',
                    ];
                }

                $inserted = $this->db->insert('allotment_certificates_new', $data);

                if ($inserted && $this->db->affected_rows() > 0) {
                    return [
                        'result'         => 'SUCCESS',
                        'message'        => 'Certificate data inserted successfully',
                        'certificate_no' => $data['certificate_no'],
                    ];
                } else {
                    // print($this->db->last_query());
                    return [
                        'result' => 'ERROR',
                        'error'  => 'Insert failed. Possible constraint violation or null value in a non-nullable field.',
                    ];
                }
            } catch (Exception $e) {
                return [
                    'result' => 'ERROR',
                    'error'  => $e->getMessage(),
                ];
            }
        }

        public function insertCertificateData($data)
        {
            try {

                // frist check if certificate number already exists
                $query  = $this->db->query("SELECT COUNT(*) as count FROM allotment_certificates_new WHERE dhar_case_no = ?", [$data['dhar_case_no']]);
                $exists = $query->row()->count > 0;
                if ($exists) {
                    return [
                        'result' => 'SUCCESS',
                        'error'  => 'Certificate number already exists',
                    ];
                }

                $inserted = $this->db->insert('allotment_certificates_new', $data);

                if ($inserted && $this->db->affected_rows() > 0) {
                    return [
                        'result'         => 'SUCCESS',
                        'message'        => 'Certificate data inserted successfully',
                        'certificate_no' => $data['certificate_no'],
                    ];
                } else {
                    // print($this->db->last_query());
                    return [
                        'result' => 'ERROR',
                        'error'  => 'Insert failed. Possible constraint violation or null value in a non-nullable field.',
                    ];
                }
            } catch (Exception $e) {
                return [
                    'result' => 'ERROR',
                    'error'  => $e->getMessage(),
                ];
            }
        }

        public function insertSettlementCertificateData($data)
        {
            try {

                // frist check if certificate number already exists
                $query  = $this->db->query("SELECT COUNT(*) as count FROM allotment_certificates_new WHERE dhar_case_no = ?", [$data['dhar_case_no']]);
                $exists = $query->row()->count > 0;
                if ($exists) {
                    return [
                        'result' => 'SUCCESS',
                        'error'  => 'Certificate number already exists',
                    ];
                }

                $inserted = $this->db->insert('allotment_certificates_new', $data);

                if ($inserted && $this->db->affected_rows() > 0) {
                    return [
                        'result'         => 'SUCCESS',
                        'message'        => 'Certificate data inserted successfully',
                        'certificate_no' => $data['certificate_no'],
                    ];
                } else {
                    // print($this->db->last_query());
                    return [
                        'result' => 'ERROR',
                        'error'  => 'Insert failed. Possible constraint violation or null value in a non-nullable field.',
                    ];
                }
            } catch (Exception $e) {
                return [
                    'result' => 'ERROR',
                    'error'  => $e->getMessage(),
                ];
            }
        }

        public function getCertificateData($dhar_case_no)
        {
            $query = $this->db->query("SELECT * FROM allotment_certificates_new WHERE dhar_case_no = ?", [$dhar_case_no]);
            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }
        }

        public function updatePrintStatus($dhar_case_no){
            $query = $this->db->query("UPDATE allotment_certificates_new SET printing_status = 1 WHERE dhar_case_no = ?", [$dhar_case_no]);
            if ($query) {
                return "SUCCESS";
            } else {
                return "ERROR";
            }
        }

        public function getMeetingNo($dhar_case_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_proposal_cases A
		 JOIN settlement_proposal_list B ON B.id=A.proposal_id
		 JOIN proposal_meeting_list C ON C.id=B.proposal_meeting_id
		 WHERE A.case_no = ?", [$dhar_case_no]);

            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }
        }

        public function checkType($case_no)
        {
            $query = $this->db->query("SELECT ins_cat_type_co FROM settlement_institution_details WHERE case_no = ?", [$case_no]);
            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }

        }
        public function getLocationArray($case_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", [$case_no]);

            if ($query->num_rows() != 0) {
                $row = (array) $query->row(); // Convert object to array

                // Remove keys that are not needed (you can either manually list or filter dynamically)
                $allowedKeys = [
                    'dist_code', 'subdiv_code', 'cir_code', 'mouza_pargona_code', 'lot_no',
                    'vill_townprt_code', 'year_no', 'petition_no', 'submission_date',
                    'service_code', 'id', 'ref_no', 'applid', 'user_code', 'date_entry',
                    'ast_code', 'lm_code', 'sk_code', 'co_code', 'adc_code', 'dc_code',
                    'dept_code', 'dept_approval', 'dc_approval', 'sdlac_approval', 'uuid',
                    'sdlac_date', 'sdlace_proposal_no', 'pay_notice_gn_date', 'protected_class',
                    'tribal_belt', 'dept_order_no', 'dept_order_date',
                    'type_of_patta', 'is_occupying_land', 'applied_scheme', 'consideration_code',
                    'consideration_note', 'approve_by', 'is_wed_land', 'lm_note_date', 'period_possession',
                ];

                // Filter only allowed keys
                $filtered_row = array_intersect_key($row, array_flip($allowedKeys));

                // Extract location codes
                $dist_code    = $filtered_row['dist_code'];
                $subdiv_code  = $filtered_row['subdiv_code'];
                $cir_code     = $filtered_row['cir_code'];
                $mouza_code   = $filtered_row['mouza_pargona_code'];
                $lot_no       = $filtered_row['lot_no'];
                $village_code = $filtered_row['vill_townprt_code'];

                // Get names
                $district_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = '00' AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code])->row('locname_eng');
                $subdiv_name   = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code])->row('locname_eng');
                $cir_name      = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code])->row('locname_eng');
                $mouza_name    = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code])->row('locname_eng');
                $lot_name      = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no])->row('locname_eng');
                $village_name  = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code])->row('locname_eng');

                return [
                    'settlement'    => $filtered_row,
                    'district_name' => $district_name,
                    'subdiv_name'   => $subdiv_name,
                    'cir_name'      => $cir_name,
                    'mouza_name'    => $mouza_name,
                    'lot_name'      => $lot_name,
                    'village_name'  => $village_name,
                ];
            } else {
                return ['result' => 'Location not found'];
            }
        }

        public function getDagAreaBYCase($case_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);
            if ($query->num_rows() != 0) {
                $results = $query->result(); // Array of objects
                return $results;
            } else {
                return "NOT-FOUND";
            }
        }

        public function getDagArray($case_no, $applicant_name)
        {
            $query = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);
            if ($query->num_rows() != 0) {
                $results     = $query->result(); // Array of objects
                $finalOutput = [];

                foreach ($results as $rowObj) {
                    $row = (array) $rowObj;

                    // check for exiting dag

                    $dist_code    = $rowObj->dist_code;
                    $sub_div_code = $rowObj->subdiv_code;
                    $cir_code     = $rowObj->cir_code;
                    $mouza_code   = $rowObj->mouza_pargona_code;
                    $lot_no       = $rowObj->lot_no;
                    $vill_code    = $rowObj->vill_townprt_code;
                    $dag          = $rowObj->dag_no;

                    $verifyDag        = $this->ChithaUpdateModel->verifyChithaArea($case_no, $dag, $rowObj->s_dag_area_b, $rowObj->s_dag_area_k, $rowObj->s_dag_area_lc, $rowObj->s_dag_area_g);
                    $clandbankDetails = $this->getLandBankDetails($dist_code, $sub_div_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag, $applicant_name);
                    if ($clandbankDetails) {
                        $row['clandbank_details'] = $clandbankDetails;
                    }

                    if ($verifyDag) {
                        $row['new_dag_no']  = null;
                        $row['is_full_dag'] = 0;
                    } else {
                        $row['new_dag_no']  = $row['dag_no'];
                        $row['is_full_dag'] = 1;
                    }

                    $allowedKeys = [
                        'dag_no', 's_dag_area_b', 's_dag_area_k', 's_dag_area_lc', 's_dag_area_g',
                        's_dag_area_kr', 'dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_g', 'dag_area_kr',
                        'patta_no', 'patta_type_code', 'revenue',
                        // 'govt_land', 'govt_land_type', 'user_code', 'date_entry',
                        // 'operation', 'lm_flag_conv', 'case_no', 'id',
                        'new_dag_no', 'new_patta_no', 'new_patta_type_code',
                        'is_urban', 'new_dag_revenue', 'new_land_class_code', 'new_local_tax',
                        // 'date_update',
                        //  'home_b','home_k', 'home_lc', 'home_g', 'home_kr', 'agri_b', 'agri_k', 'agri_lc', 'agri_g', 'agri_kr',
                        //  'land_type',
                        // 'fbigha', 'fkatha', 'flessa', 'fganda', 'fkranti', 'encroachement_area',
                        // 'nr_bigha','nr_ganda', 'nr_katha', 'nr_kranti', 'nr_lessa',
                        // 'nature_possession',
                        'new_patta_type',
                        'new_land_class_home',
                        // 'new_land_class_agri',
                        'new_possession', 'new_agri_land_revenue',
                        'new_home_land_revenue',
                        //  'new_agri_land_local_tax', 
                        'new_home_land_local_tax',
                        'new_total_revenue',
                        'new_total_tax',
                        // 'nature_of_possession_other',
                        //  'applied_b', 'applied_k', 'applied_lc', 'applied_g',
                        // 'applied_kr', 
                        'ins_proposed_land_class', 'boundary', 'reservation', 'clandbank_details', 'is_full_dag',
                    ];

                    // Decode landmarks
                    $landmark     = json_decode($row['landmark'] ?? '{}', true);
                    $landmarkCode = json_decode($row['landmark_with_code'] ?? '{}', true);

                    // Build boundary
                    $boundary                         = [];
                    $boundary['east']['description']  = $this->getSecondLastItem($landmark['east'] ?? '');
                    $boundary['west']['description']  = $this->getSecondLastItem($landmark['west'] ?? '');
                    $boundary['north']['description'] = $this->getSecondLastItem($landmark['north'] ?? '');
                    $boundary['south']['description'] = $this->getSecondLastItem($landmark['south'] ?? '');

                    $boundary['east']['dag_no']  = $landmarkCode['east']['dag_no'] ?? '';
                    $boundary['west']['dag_no']  = $landmarkCode['west']['dag_no'] ?? '';
                    $boundary['north']['dag_no'] = $landmarkCode['north']['dag_no'] ?? '';
                    $boundary['south']['dag_no'] = $landmarkCode['south']['dag_no'] ?? '';

                    $row['boundary'] = $boundary;

                    $row['new_dag_revenue'] = $row['new_home_land_revenue'];
                    //  'new_agri_land_local_tax', 
                    $row['new_local_tax'] = $row['new_home_land_local_tax'];

                    $row['reservation'] = $this->getReservationArea($case_no, $row['dag_no']);

                    $filtered_row = array_intersect_key($row, array_flip($allowedKeys));
                    // $filtered_row = $row;

                    $finalOutput[] = $filtered_row;
                }

                return $finalOutput;
            } else {
                return ['result' => 'Dag details not found'];
            }
        }

        public function getSecondLastItem($value)
        {
            // If not a string or empty, return as is
            if (! is_string($value) || trim($value) === '') {
                return $value;
            }

            // If no comma, return as is
            if (strpos($value, ',') === false) {
                return $value;
            }

            // Split and clean values
            // $parts = array_map('trim', explode(',', $value));
            // $parts = array_filter($parts, fn($p) => $p !== ''); // remove empty entries
            // $parts = array_values($parts);                      // reindex array

            // Split and clean values
            $parts = array_map('trim', explode(',', $value));
            $parts = array_filter($parts, function ($p) {
                return $p !== '';
            });                            // remove empty entries
            $parts = array_values($parts); // reindex array

            // If at least 2 values exist, return second last
            if (count($parts) >= 2) {
                return $parts[count($parts) - 2];
            }

            // Otherwise return the original string
            return $value;
        }

        public function getPattadarArray($case_no)
        {
            $query = $this->db->query("SELECT authorised_applicant_name, ins_name_co, ins_cat_type_co, purpose_land_allot_co, other_purpose_land_allot_co, venture_type, under_venture_school,
        under_ngo_trust_localbodies, under_charter_activities,
        ins_name_assamese, other_subtype_details_co, ministry_of_co, dept_of_co, dept_of_co_assamese,
        undertaking_board_co FROM settlement_institution_details WHERE case_no = ? ", [$case_no]);

            if (! $query) {
                // Debug error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }

            if ($query->num_rows() != 0) {
                return $query->result_array();
            } else {
                return ['result' => 'Pattadar details not found'];
            }
        }

        public function getReservationArea($case_no, $dag_no)
        {
            $query = $this->db->query("SELECT * FROM settlement_reservation WHERE case_no = ? and dag_no = ? and is_deleted = 0", [$case_no, $dag_no]);

            if (! $query) {
                // Debug error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }

            if ($query->num_rows() != 0) {
                $row = (array) $query->row();

                $allowedKeys  = ['bigha', 'katha', 'lessa', 'ganda', 'kranti'];
                $filtered_row = array_intersect_key($row, array_flip($allowedKeys));
                return $filtered_row;
            } else {
                return ['bigha' => 0, 'katha' => 0, 'lessa' => 0, 'ganda' => 0, 'kranti' => 0];
            }
        }

        public function getPremiumArray($case_no)
        {

            $query = $this->db->query("SELECT grn_no, payment_date, paid_amount, total_premium FROM settlement_premium WHERE case_no = ? and is_final = 1 and grn_no is not null", [$case_no]);

            if (! $query) {
                // Log the database error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }

            if ($query->num_rows() != 0) {
                $row = $query->row();
                return $row;
            } else {
                return ['result' => 'Premium details not found'];
            }
        }

        public function getDataFromApLmNotes($case_no)
        {

            $query = $this->db->query("SELECT * FROM settlement_ap_lmnote WHERE case_no = ?", [$case_no]);

            if (! $query) {
                // Log the database error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }

            if ($query->num_rows() != 0) {
                $row = $query->row();
                return $row;
            } else {
                return ['result' => 'Ap Lm Note details not found'];
            }

        }

        //see_land_bank_details
        //see_land_bank_encrocher

        public function getLandBankDetails($dist_code, $sub_div_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag, $applicant_name)
        {
            $query = $this->db->query("SELECT * FROM c_land_bank_details WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? AND dag_no = ?", [$dist_code, $sub_div_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag]);
            if (! $query) {
                // Debug error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }
            if ($query->num_rows() != 0) {
                $row2 = $query->row();
                // check for the encrocher name
                $encrocher_name = $this->db->query("SELECT name FROM c_land_bank_encroacher_details WHERE c_land_bank_details_id = ?", [$row2->id]);
                if (! $encrocher_name) {
                    $row2->encrocher_name = "";
                    return false;
                }
                if ($encrocher_name->num_rows() != 0) {
                    $row2->encrocher_name = $encrocher_name->row('name');
                    return true;
                }
                return false;
            } else {
                return false;
            }
        }

        //Update Citha

        public function validateDataForCithaUpdate($data)
        {
            if (empty($data)) {
                return ['status' => false, 'message' => "Error: Main data array is empty."];
            }
            // 2. Validate case_no
            if (! isset($data['case_no']) || empty($data['case_no'])) {
                return ['status' => false, 'message' => "Error: case_no is missing or empty."];
            }
            // 3. Check required nested objects/arrays
            $requiredKeys = ['location', 'dag', 'pattadar'];
            foreach ($requiredKeys as $key) {
                if (! isset($data[$key]) || empty($data[$key])) {
                    return ['status' => false, 'message' => "Error: '$key' is missing or empty."];
                }
            }
            // Optional: deeper checks (e.g., inside location['settlement'])
            if (! isset($data['location']['settlement']) || empty($data['location']['settlement'])) {
                return ['status' => false, 'message' => "Error: 'location.settlement' is missing or empty."];
            }
            // Check Service code allowed or not
            $service_code = $data['location']['settlement']['service_code'];
            if (! in_array($service_code, json_decode(CHITHA_UPDATE_ALLOWED))) {
                log_message('error', "UPDATE_Service_NOT_allowed " . $service_code);
                return ['status' => false, 'message' => "Error: Service code not allowed."];
            }
            return ['status' => true, 'message' => "Data is valid."];
        }

        public function genArrayForCithaUpdate($case_no)
        {
            $location_arr        = $this->getLocationArray($case_no);
            $pattadar_arr        = $this->getPattadarArray($case_no);
            $getDataFromApLmNote = $this->getDataFromApLmNotes($case_no);

            foreach ($pattadar_arr as $key => $value) {
                // print_r($value);
                // die;
                $authorised_applicant_name = $value['authorised_applicant_name'];
                $dag_arr                   = $this->getDagArray($case_no, $authorised_applicant_name);
                $data['dag_arr']           = $dag_arr;

                $getCategory = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", [$case_no]);

                if ($getCategory->num_rows() != 0) {
                    $category    = $getCategory->row();
                    $category_id = $category->ins_cat_type_co;
                    if ($category_id == 12) {
                        $registrationDetails = $this->db->query("SELECT * FROM settlement_ap_lmnote WHERE case_no = ?", [$case_no]);
                        if ($registrationDetails->num_rows() != 0) {
                            $registration = $registrationDetails->row();

                            if ($registration->registration_no == '' && $registration->registration_no == null) {
                                echo json_encode(['responseType' => 5, 'msg' => "Error: Registrtaion Details Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                                die;
                            }
                            if ($registration->registration_date == '' && $registration->registration_date == null) {
                                echo json_encode(['responseType' => 5, 'msg' => "Error: Registrtaion Details Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                                die;
                            }
                            $value['registration_no']   = $registration->registration_no;
                            $value['registration_date'] = $registration->registration_date;
                        } else {
                            echo json_encode(['responseType' => 5, 'msg' => "Error: Registrtaion Details Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                            die;
                        }



                        $filepath = $this->db->query("select * from supportive_document where file_name='Registrationdocument' and case_no=?", [$case_no]);
                        if ($filepath->num_rows() != 0) {
                            $filepath = $filepath->row();
                            if($filepath->file_path == '' && $filepath->file_path == null){
                                echo json_encode(['responseType' => 5, 'msg' => "Error: Registration Document Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                                die;
                            }
                        }else{
                             echo json_encode(['responseType' => 5, 'msg' => "Error: Registration Document Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                            die;
                        }

                    } else if (in_array($category_id, [8, 9, 10, 11])) {
                        $value['registration_no']   = null;
                        $value['registration_date'] = null;
                    }

                }

            }
            // $authorised_applicant_name = $pattadar_arr->authorised_applicant_name;
            // $dag_arr                   = $this->getDagArray($case_no, $authorised_applicant_name);

            $premium_arr = $this->getPremiumArray($case_no);
                                                                                                                       // var_dump( $premium_arr );
            $isSettlement = $this->isSettlementorAllotment($pattadar_arr[0]['ins_cat_type_co'], $getDataFromApLmNote); // or use: $this->AllotmentCertificateModel->isSettlement($case_no);
                                                                                                                       // Add the flag into the settlement array

            $ins_cat_type = $this->getInsCatType($pattadar_arr[0]['ins_cat_type_co']);

            $location_arr['settlement']['is_settlement'] = $isSettlement ? 1 : 0;

            // $checkIfIntented = $this->checkIfIntented($value['ins_cat_type_co'], $isSettlement ? 1 : 0);

            // if (empty($dag_arr['new_land_class_home'])) {
            //     echo json_encode(['responseType' => 5, 'msg' => "Error: Land Class Code Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
            //     die;
            // }
            foreach ($dag_arr as $key1 => $value1) {

                $checkIfIntented = $this->checkIfIntented($value['ins_cat_type_co'], $isSettlement ? 1 : 0);

                // if (empty($dag_arr['new_land_class_home'])) {
                //     echo json_encode(['responseType' => 5, 'msg' => "Error: Land Class Code Not Found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                //     die;
                // }

                if ($checkIfIntented) {
                    $landClass_code_original       = $this->getLandClassCodeFromGroups($value1['new_land_class_home']);
                    $value1['new_land_class_code'] = $landClass_code_original;
                } else {
                    $value1['new_land_class_code'] = $value1['new_land_class_home'];
                }
            }

            $location_arr['settlement']['ins_type']         = $ins_cat_type ?? null;
            $alreadyAlloted                                 = $getDataFromApLmNote->already_alloted;
            $location_arr['settlement']['allready_alloted'] = $alreadyAlloted;

            // if (empty($premium_arr->paid_amount) || empty($premium_arr->total_premium)) {
            //     log_message('error', "UPDATE_Missing values in premium data for case no " . $case_no);
            //     return json_encode(['status' => false, 'message' => "Error: Missing payment details. Case No : " . $case_no]);
            // }

            // if ($premium_arr->total_premium >= $premium_arr->paid_amount) {
            //     log_message('error', "UPDATE_Full_amount_NOT_paid " . $premium_arr->total_premium . " For case no " . $case_no);
            //     return json_encode(['status' => false, 'message' => "Error: Full amount is not paid. Case No : " . $case_no]);
            // }

            $location_arr['settlement']['period_possession'] = $dag_arr[0]['new_possession'];
            $dc_details                                      = $this->getDCOrderNO($case_no);
            $location_arr['settlement']['dc_order_no']       = $dc_details[0];
            $location_arr['settlement']['dc_order_date']     = $dc_details[1];

            // GET PURPOSE FROM CONSTANT

            $purpose = $this->getPurposeFromConstant($pattadar_arr[0]['purpose_land_allot_co'], $case_no);
            if (($purpose == '' || empty($purpose))) {
                echo json_encode(['responseType' => 5, 'msg' => "Error: Purpose not found. Case No : " . $case_no, "failed" => [[$case_no]], "passed" => []]);
                die;
            }
            $location_arr['settlement']['purpose']    = $purpose;
            $pattadar_arr[0]['purpose_land_allot_co'] = $purpose;

            $data = [
                'case_no'  => $case_no,
                'location' => $location_arr,
                'pattadar' => $pattadar_arr,
                'dag'      => $dag_arr,
                'premium'  => $premium_arr,
            ];

            // echo "<pre>";
            // print_r($data);
            // die;
            // 1. Fetch existing row
            $existing = $this->db
                ->where('case_no', $case_no)
                ->get('settlement_basic')
                ->row_array();

            if ($existing) {
                // 2. Check if values already match
                if (
                    $existing['co_chitha_corrected_yn'] == 'Y' &&
                    ! empty($existing['co_chitha_corrected_date']) &&
                    $existing['order_passed'] == 'Y' &&
                    ! empty($existing['date_of_order']) &&
                    ! empty($existing['date_update'])
                ) {
                    // // 3. Return error if already updated
                    // return (object) [
                    //     'responseCode' => 1, // Conflict - Already updated
                    //     'error'        => 'This case has already been updated',
                    // ];

                    return json_encode(['responseCode' => 1, 'error' => 'This case has already been updated']);
                }
            }

            // log_message('error', 'genArrayForCithaUpdate 2');
            // log_message('error', 'Generated Data: ' . json_encode($data));

            return $this->settlementChithaUpdatev2($data);

        }

        public function getLandClassCodeFromGroups($id)
        {
            $query = $this->db->query("SELECT land_class_code FROM public.land_class_groups WHERE id = ?", [$id]);
            if (! $query) {
                // Debug error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }
            if ($query->num_rows() != 0) {
                $row = $query->row();
                return $row->land_class_code;
            } else {
                return $id;
            }
        }

        public function checkIfIntented($ins_cat_type_co, $is_settlement)
        {
            if ($ins_cat_type_co == 9 && $is_settlement == 1) {
                return true;
            }

            if ($ins_cat_type_co == 10 || $is_settlement == 11) {
                return true;
            }
            return false;
        }

        public function getPurposeFromConstant($purpose, $case_no)
        {

            if ($purpose == 'other') {
                $purpose_settlement_dag = $this->db->query("SELECT new_other_purpose FROM settlement_dag_details WHERE case_no = ? limit 1", [$case_no])->row_array()['new_other_purpose'];
                if ($purpose_settlement_dag == '' || empty($purpose_settlement_dag)) {
                    return $purpose_settlement_dag;
                } else {
                    $purpose = $purpose_settlement_dag;
                }
            }

            foreach (OTHER_LAND_PURPOSE as $item) {
                if ($item['id'] === $purpose) {
                    return $item['category_name'];
                }
            }

            // If not found, return null or a default value
            return null;
        }

        public function getDCOrderNO($case_no)
        {
            $query = $this->db->query("select meeting_name, digital_sign_date from settlement_proposal_cases a
	join settlement_proposal_list b on b.id=a.proposal_id
	join proposal_meeting_list c on c.id=b.proposal_meeting_id
	where a.case_no in (?)?", [$case_no]);
            if (! $query) {
                // Debug error
                log_message('error', 'Database error: ' . $this->db->_error_message());
                return ['result' => 'Database query failed'];
            }
            if ($query->num_rows() != 0) {
                $row = $query->row();
                return [$row->meeting_name, $row->digital_sign_date];
            } else {
                return false;
            }
        }

        public function getInsCatType($ins_cat_type_co)
        {
            $ins_cat_type = '';
            switch ($ins_cat_type_co) {
                case 8:
                    $ins_cat_type = 'sg';
                    break;
                case 9:
                    $ins_cat_type = 'sgu';
                    break;
                case 10:
                    $ins_cat_type = 'cg';
                    break;
                case 11:
                    $ins_cat_type = 'cgu';
                    break;
                case 12:
                    $ins_cat_type = 'ng';
                    break;
                default:
                    $ins_cat_type = 'unknown';
                    break;
            }
            return $ins_cat_type;
        }

        public function isSettlementorAllotment($ins_cat_type_co, $getDataFromApLmNote)
        {
            $alreadyAlloted = $getDataFromApLmNote->already_alloted;

            if ($ins_cat_type_co == 8) {
                return false;
            }
            if ($ins_cat_type_co == 9 && $alreadyAlloted == 'N') {
                return false;
            }
            if ($ins_cat_type_co == 9 && $alreadyAlloted == 'Y') {
                return true;
            }
            if ($ins_cat_type_co == 10) {
                return false;
            }
            if ($ins_cat_type_co == 11) {
                return true;
            }
            if ($ins_cat_type_co == 12 && $alreadyAlloted == 'N') {
                return false;
            }
            if ($ins_cat_type_co == 12 && $alreadyAlloted == 'Y') {
                return true;
            }

            return false;
        }

        public function settlementChithaUpdatev2($data)
        {
            // echo "<pre>";
            // print_r($data);
            // die();
            $validation = $this->validateDataForCithaUpdate($data);
            // var_dump($validation);
            if ($validation['status'] == false) {
                return json_encode([
                    'responseType' => 1,
                    'error'        => 'VALIDATION-ERROR',
                ]);
            }

            // print_r($data);
            $date               = date('Y-m-d H:i:s');
            $case_no            = $data['case_no'];
            $pattadars          = $data['pattadar'];
            $dags               = $data['dag'];
            $location           = $data['location']['settlement'] ?? [];
            $settlement_details = $data['pattadar']; // Since most nested fields come from $pattadar directly
            $premium            = $data['premium'];
            $user_code          = $this->session->userdata('user_code');

            $applicantData = $this->getSettlememtApplicant_data($case_no);

            // 'rmk_type_hist_no'      =>
            $sp = [
                'dc_code'              => $location['dc_code'] ?? null,
                'dc_order_no'          => $location['dc_order_no'] ?? null,
                'dc_order_date'        => $location['dc_order_date'] ?? null,
                'dept_order_no'        => $location['dept_order_no'] ?? null,
                'dept_order_date'      => $location['dept_order_date'] ?? null,
                'possession_from'      => $location['period_possession'] ?? null,
                'grn_no'               => $premium->grn_no ?? null,
                'payment_date'         => $premium->payment_date ?? null,
                'final_premium_amount' => $premium->total_premium ?? null,
                'paid_amount'          => $premium->paid_amount ?? null,
            ];
            $loc_arr = [
                'dist_code'          => $location['dist_code'],
                'subdiv_code'        => $location['subdiv_code'],
                'cir_code'           => $location['cir_code'],
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no'             => $location['lot_no'],
                'vill_townprt_code'  => $location['vill_townprt_code'],
            ];
            if (! in_array($location['ins_type'], ['sg', 'sgu', 'cg', 'cgu', 'ng'])) {
                return json_encode([
                    'responseType' => 1,
                    'error'        => 'NOT-AUTHORISED-SERVICE',
                ]);
            }
            switch ($location['ins_type']) {
                case 'sg':
                    $new_land_class = '5005'; //"INS_LANDCLASS";
                    $new_patta_type = '1001'; //"AXOM_SARKAR";
                    break;
                case 'sgu':
                    $new_patta_type = '1001'; //"AXOM_SARKAR";
                    $new_land_class = "old_class";
                    if ($location['is_settlement'] == 1) {
                        $new_patta_type = "0203";
                        $new_land_class = "intended"; ///POST LANDCLASS///
                    }
                    break;
                case 'cg':
                    $new_patta_type = '2001';     //"KENDRIYA_SARKAR";
                    $new_land_class = "intended"; ///POST LANDCLASS///
                    break;
                case 'cgu':
                    $new_patta_type = "0203";
                    $new_land_class = "intended"; /////POST LANDCLASS////
                    break;
                case 'ng':
                    $new_patta_type = '1001'; //"AXOM_SARKAR";
                    $new_land_class = "old_class";
                    if ($location['is_settlement'] == 1) {
                        $new_patta_type = "0203";
                        $new_land_class = '5005'; //"INS_LANDCLASS";
                    }
                    break;
            }
            // echo "PP".$new_patta_type;
            if (in_array($location['ins_type'], ['sgu', 'cgu', 'ng'])) {
                if ($location['is_settlement'] == 1) {
                    ////////Generate New PP Patta No/////////////////////0203//////////
                    $new_patta_no = $this->utilityclass->maxpatta($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], '0203');
                } else {
                    $new_patta_no = '0';
                }
            }
            // echo "PP1".$new_patta_type;
            // var_dump($dags);
            $finalDags = $pattadarDags = [];
            foreach ($dags as $dag) {
                // echo $dag['dag_no'];
                $new_dag_no = false;
                $boundary   = $dag['boundary'];
                // var_dump($boundary);
                $road_side_reservation_bigha = 0;
                $road_side_reservation_katha = 0;
                $road_side_reservation_lessa = 0;
                $road_side_reservation_ganda = 0;
                $ord_cron_no                 = 1;
                if (isset($dag['reservation']) &&
                    (
                        (isset($dag['reservation']['bigha']) && $dag['reservation']['bigha'] != 0) ||
                        (isset($dag['reservation']['katha']) && $dag['reservation']['katha'] != 0) ||
                        (isset($dag['reservation']['lessa']) && $dag['reservation']['lessa'] != 0) ||
                        (isset($dag['reservation']['ganda']) && $dag['reservation']['ganda'] != 0)
                    )
                ) {
                    $road_side_reservation_bigha = $dag['reservation']['bigha'];
                    $road_side_reservation_katha = $dag['reservation']['katha'];
                    $road_side_reservation_lessa = $dag['reservation']['lessa'];
                    $road_side_reservation_ganda = $dag['reservation']['ganda'];
                    // $reservation=$this->roadSideReservation($road_side_reservation_bigha,$road_side_reservation_katha,$road_side_reservation_lessa,$road_side_reservation_ganda);
                    ///////////////////////
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " চাতক " . $road_side_reservation_ganda . " গোণ্ডা মিছন বাসুন্ধৰা-3.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    } else {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " লেচা মিছন বাসুন্ধৰা-3.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }
                    $backlog_orders = [
                        'patta_no'        => $dag['patta_no'],
                        'patta_type_code' => $dag['patta_type_code'],
                        'dag_no'          => $dag['dag_no'],
                        'dag_no_int'      => $dag['dag_no'] . '00',
                        'remark'          => addslashes($rmk),
                        'category'        => 2,
                        'date_entry'      => date('Y-m-d'),
                        'user_code'       => $user_code,
                    ];

                    $backlog_orders = (array_merge($loc_arr, $backlog_orders));

                    // merge with loc_arry and backlog_oders before insert
                    $backlog_orders = $this->Chitha_basic_model->insert_table('backlog_orders', $backlog_orders);
                    if ($backlog_orders == 0) {
                        log_message('error', "INSERT_backlog_orders" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }
                /////////////////////////////////////////////
                $is_reservation = $road_side_reservation_bigha + $road_side_reservation_katha + $road_side_reservation_lessa + $road_side_reservation_ganda;
                $oldAreaChitha  = $this->ChithaUpdateModel->areaVerifyInChitha($loc_arr, (string) $dag['dag_no'], (string) $dag['patta_type_code'], (string) $dag['patta_no']);
                if ($oldAreaChitha == 'NA') {
                    return json_encode([
                        'responseType' => 1,
                        'error'        => 'NO-RECORD-FOUND',
                    ]);
                }
                //////////AREA VERIFY//////////////
                $old_bigha = $oldAreaChitha->dag_area_b;
                $old_katha = $oldAreaChitha->dag_area_k;
                $old_lessa = $oldAreaChitha->dag_area_lc;
                $old_gonda = $oldAreaChitha->dag_area_g;
                // echo $old_bigha ."##". $old_katha;
                $applied_b  = $dag['s_dag_area_b'];
                $applied_k  = $dag['s_dag_area_k'];
                $applied_lc = $dag['s_dag_area_lc'];
                $applied_g  = $dag['s_dag_area_g'];
                //////////////////
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $applied          = $applied_b * 6400 + $applied_k * 320 + $applied_lc * 20 + $applied_g;
                    $totalReserveArea = $road_side_reservation_bigha * 6400 + $road_side_reservation_katha * 320 + $road_side_reservation_lessa * 20 + $road_side_reservation_ganda;
                    $areaSubstract    = $this->utilityclass->Total_Bigha_Katha_Lessa2($applied - $totalReserveArea);
                    ///////////////////
                    $totalArea    = $old_bigha * 6400 + $old_katha * 320 + $old_lessa * 20 + $old_gonda;
                    $applied_bb   = $areaSubstract[0];
                    $applied_kk   = $areaSubstract[1];
                    $applied_llc  = $areaSubstract[2];
                    $applied_gg   = $areaSubstract[3];
                    $finalArea    = $applied_bb * 6400 + $applied_kk * 320 + $applied_llc * 20 + $applied_gg;
                    $reminingArea = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalArea - $finalArea);
                    // log_message('error','APPLIED'.$applied."TOTALAREA".$totalArea);
                } else {
                    $applied          = $applied_b * 100 + $applied_k * 20 + $applied_lc;
                    $totalReserveArea = $road_side_reservation_bigha * 100 + $road_side_reservation_katha * 20 + $road_side_reservation_lessa;
                    $areaSubstract    = $this->utilityclass->Total_Bigha_Katha_Lessa($applied - $totalReserveArea);
                    //////////////////
                    $totalArea    = $old_bigha * 100 + $old_katha * 20 + $old_lessa;
                    $applied_bb   = $areaSubstract[0];
                    $applied_kk   = $areaSubstract[1];
                    $applied_llc  = $areaSubstract[2];
                    $applied_gg   = $areaSubstract[3];
                    $finalArea    = $applied_bb * 100 + $applied_kk * 20 + $applied_llc;
                    $reminingArea = $this->utilityclass->Total_Bigha_Katha_Lessa($totalArea - $finalArea);
                    // log_message('error', 'APPLIED' . $applied . "TOTALAREA" . $totalArea . "SUB" . json_encode($areaSubstract));
                }
                if ($finalArea == 0 || $finalArea < 0) {
                    return json_encode([
                        'responseType' => 1,
                        'error'        => 'VERIFY-AREA-FOR-SETTLEMENT',
                    ]);
                }
                $applied_b  = $areaSubstract[0];
                $applied_k  = $areaSubstract[1];
                $applied_lc = $areaSubstract[2];
                $applied_g  = $areaSubstract[3];
                // echo "PP2".$new_patta_type;
                if ($finalArea > $totalArea) {
                    return json_encode([
                        'responseType' => 1,
                        'error'        => 'NO-AREA-LEFT-FOR-SETTLEMENT',
                    ]);
                }
                ///////////IF BOTH AREA SAME OLD DAG=NEW DAG////////////////////
                if (($finalArea != $totalArea) && ($totalArea > $finalArea)) {
                    // echo "NEW-DAG".$new_patta_type;
                    if ($new_dag_no === false) {
                        $new_dag_no = $this->utilityclass->maxdag($loc_arr['dist_code'], $loc_arr['subdiv_code'], $loc_arr['cir_code'], $loc_arr['mouza_pargona_code'], $loc_arr['lot_no'], $loc_arr['vill_townprt_code']);
                    } else {
                        $new_dag_no = $new_dag_no + 1;
                    }

                    $chitha_baic = [
                        'old_dag_no'      => $dag['dag_no'],
                        'dag_no_int'      => $new_dag_no . '00',
                        'dag_no'          => (string) $new_dag_no,
                        'land_class_code' => $new_land_class === 'old_class' ? ($oldAreaChitha->land_class_code ?? null) :
                        ($new_land_class === 'intended' ? ($dag['new_land_class_code'] ?? null) :
                            $new_land_class),
                        'dag_area_b'      => $applied_b,
                        'dag_area_k'      => $applied_k,
                        'dag_area_lc'     => $applied_lc,
                        'dag_area_g'      => $applied_g,
                        'dag_area_kr'     => 0,
                        'dag_revenue'     => $dag['new_dag_revenue'] ?? 0,
                        'dag_local_tax'   => $dag['new_local_tax'] ?? 0,
                        'user_code'       => $user_code,
                        'operation'       => 'I',
                        'date_entry'      => $date,
                        'possession_from' => $location['period_possession'],
                        'dag_n_desc'      => $boundary['north']['description'] ?? '',
                        'dag_s_desc'      => $boundary['south']['description'] ?? '',
                        'dag_e_desc'      => $boundary['east']['description'] ?? '',
                        'dag_w_desc'      => $boundary['west']['description'] ?? '',

                        'dag_n_dag_no'    => $boundary['north']['dag_no'] ?? '',
                        'dag_s_dag_no'    => $boundary['south']['dag_no'] ?? '',
                        'dag_e_dag_no'    => $boundary['east']['dag_no'] ?? '',
                        'dag_w_dag_no'    => $boundary['west']['dag_no'] ?? '',

                    ];
                    $mainchitha_basic = array_merge($loc_arr, $chitha_baic);
                    if (in_array($new_patta_type, ['1001', '2001'])) {
                        $mainchitha_basic['patta_no']        = '0';
                        $mainchitha_basic['patta_type_code'] = $new_patta_type;
                    }
                    if ($location['is_settlement'] == 1) {
                        $mainchitha_basic['patta_no']        = $new_patta_no;
                        $mainchitha_basic['patta_type_code'] = $new_patta_type;
                    }
                    // var_dump($mainchitha_basic);
                    $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);
                    if ($chithaBasic == 0) {
                        log_message('error', "INSERT_CHITHA-NLJIE-001###" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error'        => 'INSERT_CHITHA-NLJIE-001',
                        ]);
                    }
                    ////////////SUBSTRACT OLD AREA///////////////
                    $where = [
                        'dist_code'          => $location['dist_code'],
                        'subdiv_code'        => $location['subdiv_code'],
                        'cir_code'           => $location['cir_code'],
                        'mouza_pargona_code' => $location['mouza_pargona_code'],
                        'lot_no'             => $location['lot_no'],
                        'vill_townprt_code'  => $location['vill_townprt_code'],
                        'dag_no'             => $dag['dag_no'],
                    ];
                    $params = [
                        'dag_area_b'   => $reminingArea[0],
                        'dag_area_k'   => $reminingArea[1],
                        'dag_area_lc'  => $reminingArea[2],
                        'dag_area_g'   => $reminingArea[3],
                        
                        'dag_n_desc'   => $boundary['north']['description'] ?? '',
                        'dag_s_desc'   => $boundary['south']['description'] ?? '',
                        'dag_e_desc'   => $boundary['east']['description'] ?? '',
                        'dag_w_desc'   => $boundary['west']['description'] ?? '',
                        'dag_n_dag_no' => $boundary['north']['dag_no'] ?? '',
                        'dag_s_dag_no' => $boundary['south']['dag_no'] ?? '',
                        'dag_e_dag_no' => $boundary['east']['dag_no'] ?? '',
                        'dag_w_dag_no' => $boundary['west']['dag_no'] ?? '',
                    ];
                    $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                    // log_message('error', "INSERT_CHITHA-AP-002###" . $this->db->last_query());
                    if ($chithaUpdate == 0) {
                        log_message('error', "UPDATE_CHITHA-NLJIE-002#####" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error'        => 'UPDATE_CHITHA-NLJIE-002',
                        ]);
                    }
                    /////////////////////////////
                }
                if ($applied == $totalArea) {
                    $where = [
                        'dist_code'          => $loc_arr['dist_code'],
                        'subdiv_code'        => $loc_arr['subdiv_code'],
                        'cir_code'           => $loc_arr['cir_code'],
                        'mouza_pargona_code' => $loc_arr['mouza_pargona_code'],
                        'lot_no'             => $loc_arr['lot_no'],
                        'vill_townprt_code'  => $loc_arr['vill_townprt_code'],
                        'dag_no'             => $dag['dag_no'],
                    ];
                    $params = [
                        'dag_area_b'      => $applied_b,
                        'dag_area_k'      => $applied_k,
                        'dag_area_lc'     => $applied_lc,
                        'dag_area_g'      => $applied_g,
                        'land_class_code' => $new_land_class === 'old_class' ? ($oldAreaChitha->land_class_code ?? null) :
                        ($new_land_class === 'intended' ? ($dag['new_land_class_code'] ?? null) :
                            $new_land_class),
                        'user_code'       => $user_code,
                        'operation'       => 'U',
                        'date_entry'      => date('Y-m-d'),
                        'possession_from' => $location['period_possession'],
                        'dag_n_desc'      => $boundary['north']['description'] ?? '',
                        'dag_s_desc'      => $boundary['south']['description'] ?? '',
                        'dag_e_desc'      => $boundary['east']['description'] ?? '',
                        'dag_w_desc'      => $boundary['west']['description'] ?? '',

                        'dag_n_dag_no'    => $boundary['north']['dag_no'] ?? '',
                        'dag_s_dag_no'    => $boundary['south']['dag_no'] ?? '',
                        'dag_e_dag_no'    => $boundary['east']['dag_no'] ?? '',
                        'dag_w_dag_no'    => $boundary['west']['dag_no'] ?? '',
                        'dag_revenue'     => $dag['new_dag_revenue'] ?? 0,
                        'dag_local_tax'   => $dag['new_local_tax'] ?? 0,
                    ];
                    if (in_array($new_patta_type, ['1001', '2001'])) {
                        // $params['patta_no'] = '0';
                        $params['patta_type_code'] = $new_patta_type;
                    }
                    if ($location['is_settlement'] == 1) {
                        $params['patta_no']        = $new_patta_no;
                        $params['patta_type_code'] = $new_patta_type;
                    }
                    // var_dump($params,$where);
                    $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                    if ($chithaUpdate == 0) {
                        log_message('error', "UPDATE_CHITHA-NLJIE-002#####" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error'        => 'UPDATE_CHITHA-NLJIE-002',
                        ]);
                    }
                }
                //////////////////////////////////////////////
                if (in_array($new_patta_type, ['1001', '2001'])) {
                    // echo $dag['dag_no'];
                    // echo trim((string) $new_dag_no);
                    $finalDags[] = [
                        [($new_dag_no !== false && trim((string) $dag['dag_no']) !== trim((string) $new_dag_no))
                            ? $new_dag_no
                            : $dag['dag_no'], $new_patta_type],
                    ];
                } else if ($location['is_settlement'] == 1) {
                    $pattadarDags[] = [($new_dag_no !== false && trim((string) $dag['dag_no']) !== trim((string) $new_dag_no))
                        ? $new_dag_no
                        : $dag['dag_no'], $new_patta_type, $new_patta_no];
                }
                // var_dump($finalDags);
                ///////////End of reservation/////////////////
                $rmk_type_hist_no = $this->ChithaUpdateModel->maxHistoryNoOrder($loc_arr, $dag['dag_no']);
                $remark_gen       = [
                    'dag_no'           => $dag['dag_no'],
                    'rmk_type_code'    => '01',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code'        => $user_code,
                    'date_entry'       => date('Y-m-d'),
                    'operation'        => 'I',
                    'jama_updated'     => null,
                    // 'patta_no'         => $dag['new_patta_no'],
                ];
                $chitha_remark_gen_data = (array_merge($loc_arr, $remark_gen));
                $chitha_rmk_gen         = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                if ($chitha_rmk_gen == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_GEN-NLJIE##1111" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error'        => 'INSERT_CHITHA_RMK_GEN-NLJIE##1111',
                    ]);
                }
                //OLD DAG /////////////////
                if ($new_dag_no) {
                    $chitha_remark_gen_data['dag_no'] = (string) $new_dag_no;
                    $chitha_rmk_gen                   = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                    if ($chitha_rmk_gen == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_GEN##INS-NEW##222" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error'        => 'INSERT_CHITHA_RMK_GEN##INS-NEW##222',
                        ]);
                    }
                }

                $order_basic = [
                    'rmk_type_hist_no'   => $rmk_type_hist_no,
                    'ord_no'             => $case_no,
                    'ord_date'           => date('Y-m-d'),
                    'ord_type_code'      => $location['service_code'],
                    'ord_cron_no'        => $ord_cron_no++,
                    'case_no'            => $case_no,
                    'ord_passby_sign_yn' => 'Y',
                    'ord_passby_desig'   => $this->session->userdata('user_desig_code'),
                    'lm_code'            => $location['lm_code'],
                    'lm_sign_yn'         => 'Y',
                    'lm_sign_date'       => $location['lm_note_date'],
                    'co_code'            => $user_code,
                    'co_sign_yn'         => 'Y',
                    'co_ord_date'        => date('Y-m-d'),
                    'user_code'          => $user_code,
                    'date_entry'         => date('Y-m-d'),
                    'operation'          => 'I',
                    'm_dag_area_b'       => $applied_b,
                    'm_dag_area_k'       => $applied_k,
                    'm_dag_area_lc'      => $applied_lc,
                    'm_dag_area_g'       => $applied_g,
                    'm_dag_area_kr'      => 0,
                    'area_left_b'        => '0',
                    'area_left_k'        => '0',
                    'area_left_lc'       => '0',
                    'area_left_g'        => '0',
                    'old_dag_area_b'     => $old_bigha,
                    'old_dag_area_k'     => $old_katha,
                    'old_dag_area_lc'    => $old_lessa,
                    'old_dag_area_g'     => $old_gonda,
                    'rural_urban'        => $location['ins_type'],
                    'full_partial'       => $location['allready_alloted'],
                    'rtps_no'            => $location['applid'],
                    'rtps_app_date'      => $location['date_entry'],
                    'dag_revenue'        => $dag['new_dag_revenue'],
                    'dag_local_tax'      => $dag['new_local_tax'],
                    'ord_impli_flag'     => $location['is_settlement'],
                    'full_dag'           => (!empty($new_dag) || $new_dag !== 0 || $new_dag !== "0") ? 0 : 1,
                    'dag_no'             => $dag['dag_no'],
                ];

                $chitha_rmk_ordbasic_data = (array_merge($loc_arr, $order_basic));
                $chitha_rmk_ordbasic      = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                if ($chitha_rmk_ordbasic == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-old#3333" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error'        => 'INSERT_CHITHA_RMK_ORDBASIC-old#3333',
                    ]);
                }
                if ($new_dag_no) {
                    $chitha_rmk_ordbasic_data['dag_no'] = (string) $new_dag_no;
                    $chitha_rmk_ordbasic                = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                    if ($chitha_rmk_ordbasic == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-NEW##INS##" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error'        => 'INSERT_CHITHA_RMK_ORDBASIC-NEW##INS##',
                        ]);
                    }
                }
                ////////////OLD DAG///////////
                foreach ($pattadars as $key => $pattadar) {
                    // var_dump($pattadar);
                    //craete insertion array
                    $insertaionArray = [
                        'rmk_type_hist_no'         => $rmk_type_hist_no,
                        'case_no'                  => $case_no,
                        'dag_no'                   => $new_dag_no,
                        'applied_dag_no'           => $dag['dag_no'], // Assuming same as `dag_no` if no `applied_dag_no` available
                        'institute_name'           => $pattadar['ins_name_assamese'] ?? '',
                        'institute_name_eng'       => $pattadar['ins_name_co'] ?? '',
                        'registration_status'      => $pattadar['co_operative_registered'] ?? '',
                        'reg_no'                   => $pattadar['registration_no'] ?? '',
                        'reg_date'                 => $pattadar['registration_date'] ?? null,
                        'purpose_land_allotment'   => $pattadar['purpose_land_allot_co'] ?? '',
                        'other_purpose'            => $pattadar['other_purpose_land_allot_co'] ?? '',
                        'venture_status'           => $pattadar['under_venture_school'] ?? '',
                        'venture_type'             => $pattadar['venture_type'] ?? '',
                        'ngo_trust_localbodies'    => $pattadar['under_ngo_trust_localbodies'] ?? '',
                        'under_charter_activities' => $pattadar['under_charter_activities'] ?? '',
                        'reclassification'         => $premium->ins_reclass_amount ?? 0,
                        'govt_nongovt_undertaking' => $pattadar['ins_cat_type_co'] ?? '',
                        'department_name'          => $pattadar['dept_of_co_assamese'] ?? '',
                        'department_name_eng'      => $pattadar['dept_of_co'] ?? '',
                        'undertaking_board'        => $pattadar['undertaking_board_co'] ?? '',
                        'ministry'                 => $pattadar['ministry_of_co'] ?? '',
                        'applied_on_behalf_name'   => $pattadar['authorised_applicant_name'] ?? '',
                        'applied_on_behalf_desg'   => $pattadar['authorised_applicant_desig'] ?? '',
                        'applied_on_behalf_mobile' => $pattadar['authorised_applicant_phone_no'] ?? '',
                        'applied_on_behalf_email'  => $pattadar['authorised_applicant_emailid'] ?? '',
                        'date_entry'               => date('Y-m-d H:i:s'),
                        'user_code'                => $user_code,
                        'new_patta_no'             => $new_patta_no ?? '',
                        'new_patta_type'           => $new_patta_type ?? '',
                    ];
                    $insertaionArray           = (array_merge($loc_arr, $sp, $insertaionArray));
                    $chitha_institute_allottee = $this->Chitha_basic_model->insert_table('chitha_institute_allottee', $insertaionArray);
                    if ($chitha_institute_allottee == 0) {
                        log_message('error', "INSERT_chitha_institute_allottee" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error'        => 'INSERT_chitha_institute_allottee',
                        ]);
                    }
                    ////////////////
                    // print_r($finalDags);

                }
            }
            ////////////////
            $basicUpdate = [
                'co_chitha_corrected_yn'   => 'Y',
                'co_chitha_corrected_date' => date('Y-m-d H:i:s'),
                'order_passed'             => 'Y',
                'is_settlement'            => $location['is_settlement'],
                'date_of_order'            => date('Y-m-d H:i:s'),
                'date_update'              => date('Y-m-d H:i:s'),
            ];
            $where_array = [
                'case_no' => $case_no,
            ];
            $settlement_basic = $this->Chitha_basic_model->update_table('settlement_basic', $basicUpdate, $where_array);
            if ($settlement_basic == 0) {
                log_message('error', "UPDATE_settlement_basic" . $this->db->last_query());
                $this->db->trans_rollback();
                return json_encode([
                    'responseType' => 1,
                    'error'        => 'FAILED_UPDATE-BASIC-NILJE####1178',
                ]);
            }
            //////////////////////////
            // var_dump($finalDags);
            if ($finalDags) {
                foreach ($finalDags as $fullDagData) {
                    if ($fullDagData) {
                        // var_dump($fullDagData);
                        foreach ($fullDagData as $fdp) {
                            $c_d_p = [
                                'pdar_id'         => 1,
                                'patta_no'        => '0',
                                'patta_type_code' => $fdp[1],
                                'dag_no'          => $fdp[0],
                                'dag_por_b'       => 0,
                                'dag_por_k'       => 0,
                                'dag_por_lc'      => 0,
                                'dag_por_g'       => 0,
                                'dag_por_kr'      => 0,
                                'user_code'       => $user_code,
                                'date_entry'      => date('Y-m-d'),
                                'operation'       => 'I',
                                'p_flag'          => '0',
                                'jama_yn'         => 'N',
                            ];
                            $chitha_dag_pattadar = array_merge($loc_arr, $c_d_p);
                            // var_dump($chitha_dag_pattadar);
                            $chitha_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_pattadar);
                            if ($chitha_dag_pattadar == 0) {
                                log_message('error', "INSERT_chitha_dag_pattadar" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return json_encode([
                                    'responseType' => 1,
                                    'error'        => 'INSERT_chitha_dag_pattadar',
                                ]);
                            }
                            ///////////////////////
                            if ($fdp[1] == '1001') {
                                $applicant = 'ৰাজ্য চৰকাৰ';
                            } else {
                                $applicant = 'কেন্দ্ৰীয় চৰকাৰ';
                            }
                            //////////////////
                            $sqlChithaPattadarCount = $this->db->query("Select * from chitha_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=? and pdar_id=1 ", [$loc_arr['dist_code'], $loc_arr['subdiv_code'], $loc_arr['cir_code'], $loc_arr['mouza_pargona_code'], $loc_arr['lot_no'], $loc_arr['vill_townprt_code'], $fdp[1], '0'])->num_rows();
                            if ($sqlChithaPattadarCount == 0) {
                                /////////////////
                                $chitha_pattadar = [
                                    'patta_no'        => '0',
                                    'patta_type_code' => $fdp[1],
                                    'pdar_id'         => 1,
                                    'pdar_name'       => $applicant,
                                    'pdar_father'     => "চৰকাৰ",
                                    'o2_case_no'      => $case_no,
                                    'user_code'       => $user_code,
                                    'date_entry'      => date('Y-m-d'),
                                    'operation'       => 'I',
                                    'jama_yn'         => 'n',
                                    'pdar_guard_reln' => 'u',
                                    'new_pdar_name'   => 'N',
                                ];
                                // var_dump($chitha_pattadar);
                                // echo "<br>chitha_pattadar****************<br>";
                                $chitha_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', array_merge($loc_arr, $chitha_pattadar));
                                if ($chitha_pattadar == 0) {
                                    log_message('error', "INSERT_chitha_pattadar" . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    return json_encode([
                                        'responseType' => 1,
                                        'error'        => 'INSERT_chitha_pattadar',
                                    ]);
                                }
                            }

                        }
                    }
                }
            }
            //////////////////////

            if ($location['is_settlement'] == 1) {
                $this->load->model('ChithaUpdateModel');
                // var_dump($pattadarDags);
                if ($pattadarDags) {
                    $final_pdarId = false;
                    foreach ($pattadarDags as $chitha_pattadar_dag) {
                        if ($final_pdarId === false) {
                            $final_pdarId = $this->ChithaUpdateModel->maxPdarIdFetch($loc_arr, $chitha_pattadar_dag[0], $chitha_pattadar_dag[2], $chitha_pattadar_dag[1]);
                            //////////////////
                            foreach ($pattadars as $key => $pattadar) {
                                $chitha_pattadar_final = [
                                    'patta_no'        => $chitha_pattadar_dag[2],
                                    'patta_type_code' => $chitha_pattadar_dag[1],
                                    'pdar_id'         => $final_pdarId,
                                    'pdar_name'       => $pattadar['ins_name_assamese'] ?? '',
                                    'pdar_father'     => $pattadar['dept_of_co_assamese'] ?? '',
                                    'pdar_name_eng'   => $pattadar['ins_name_co'] ?? '',
                                    'pdar_guard_eng'  => $pattadar['dept_of_co'] ?? '',
                                    'o2_case_no'      => $case_no,
                                    'user_code'       => $user_code,
                                    'date_entry'      => $date,
                                    'operation'       => 'I',
                                    'jama_yn'         => 'n',
                                    'pdar_guard_reln' => 'u',
                                    'new_pdar_name'   => 'N',
                                ];
                                // var_dump($chitha_pattadar_final);
                                $chitha_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', array_merge($loc_arr, $chitha_pattadar_final));
                                if ($chitha_pattadar == 0) {
                                    log_message('error', "INSERT_chitha_pattadar-FINAL###" . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    return json_encode([
                                        'responseType' => 1,
                                        'error'        => 'INSERT_chitha_pattadar-FINAL',
                                    ]);
                                }
                                $pdarid[]     = $final_pdarId;
                                $final_pdarId = $final_pdarId + 1;
                            }
                        }
                        $c_d_p = [
                            'pdar_id'         => $pdarid[0],
                            'patta_no'        => $chitha_pattadar_dag[2],
                            'patta_type_code' => $chitha_pattadar_dag[1],
                            'dag_no'          => $chitha_pattadar_dag[0],
                            'dag_por_b'       => 0,
                            'dag_por_k'       => 0,
                            'dag_por_lc'      => 0,
                            'dag_por_g'       => 0,
                            'dag_por_kr'      => 0,
                            'user_code'       => $user_code,
                            'date_entry'      => $date,
                            'operation'       => 'I',
                            'p_flag'          => '0',
                            'jama_yn'         => 'n',
                        ];
                        $chitha_dag_pattadar_final = array_merge($loc_arr, $c_d_p);
                        // var_dump($chitha_dag_pattadar);
                        $chitha_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_pattadar_final);
                        if ($chitha_dag_pattadar == 0) {
                            log_message('error', "INSERT_chitha_dag_pattadar##FINAL###" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return json_encode([
                                'responseType' => 1,
                                'error'        => 'INSERT_chitha_dag_pattadar##FINAL###',
                            ]);
                        }
                    }
                }
            }
            /////////////////////
            return json_encode([
                'responseType' => 2,
                'data'         => 'SUCCESS',
            ]);
        }

        public function updateSettlementBasicTable($case_no)
        {
            // update data
            $update_data = [
                'allot_cert_offered' => '1',
            ];

            // run update directly on settlement_basic table
            $this->db->where('case_no', $case_no);
            $update_status = $this->db->update('settlement_basic', $update_data);

            if (! $update_status || $this->db->affected_rows() == 0) {
                log_message('error', "FAILED to update settlement_basic for case_no: " . $case_no . " | Query: " . $this->db->last_query());
                return false;
            }

            return true;
        }

        public function getPattaDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_dag_no, $new_dag_no)
        {
            $query = $this->db->query("select dag_revenue, dag_revenue, dag_local_tax, patta_type_code, patta_no, old_patta_no from chitha_basic where
        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?
        and old_dag_no=? and dag_no=?",
                [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,
                    $old_dag_no, $new_dag_no]);
            // die;

            if ($query->num_rows() != 0) {
                return $query->row();
            } else {
                return "NOT-FOUND";
            }
        }


public function getAllVillages($dist_code, $circle_code = null) {
    if ($circle_code === null) {
        $query = $this->db->query(
            "SELECT * FROM location 
             WHERE dist_code = ? 
             AND vill_townprt_code != '00000'",
            [$dist_code]
        );
    } else {

        $getCircle = $this->db->query(
            "SELECT * FROM location 
            WHERE uuid = ? 
            LIMIT 1",
            [$circle_code]
        );

        if ($getCircle->num_rows() === 0) {
            echo json_encode([]);
            return;
        }


        $dist_code = $getCircle->row()->dist_code;
        $sub_div_code = $getCircle->row()->subdiv_code;
        $cir_code = $getCircle->row()->cir_code;


        

        $query = $this->db->query(
            "SELECT * FROM location 
             WHERE dist_code = ?
             AND subdiv_code = ? 
             AND cir_code = ? 
             AND vill_townprt_code != '00000'",
            [$dist_code, $sub_div_code, $cir_code]
        );

    }

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return [];
    }
}

   public function insertOrUpdateCertificateData($data)
    {
        try {
            // Check if record exists with the given dhar_case_no
            $query  = $this->db->query(
                "SELECT COUNT(*) as count 
                FROM allotment_certificates_new 
                WHERE dhar_case_no = ?", 
                [$data['dhar_case_no']]
            );
            $exists = $query->row()->count > 0;

            if ($exists) {
                // Update record
                $this->db->where('dhar_case_no', $data['dhar_case_no']);
                $updated = $this->db->update('allotment_certificates_new', $data);

                if ($updated && $this->db->affected_rows() >= 0) {
                    return [
                        'result'         => 'SUCCESS',
                        'message'        => 'Certificate data updated successfully',
                        'certificate_no' => $data['certificate_no'] ?? null,
                    ];
                } else {
                    return [
                        'result' => 'ERROR',
                        'error'  => 'Update failed. No rows were changed.',
                    ];
                }
            } else {
                // Insert record
                $inserted = $this->db->insert('allotment_certificates_new', $data);

                // print_r($this->db->last_query());
                // die;

                if ($inserted) {
                    return [
                        'result'         => 'SUCCESS',
                        'message'        => 'Certificate data inserted successfully',
                        'certificate_no' => $data['certificate_no'] ?? null,
                    ];
                } else {
                    return [
                        'result' => 'ERROR',
                        'error'  => 'Insert failed. Possible constraint violation or null value in a non-nullable field.',
                    ];
                }
            }
        } catch (Exception $e) {
            return [
                'result' => 'ERROR',
                'error'  => $e->getMessage(),
            ];
        }
    }


    

public function getAllCircles($dist_code, $circle_code = null){
    if ($circle_code === null) {
        $sql = "select * from location where dist_code =?  and "
            . " subdiv_code!='00' and cir_code!='00' and mouza_pargona_code ='00' and "
            . " vill_townprt_code ='00000' and lot_no ='00'";
        $params = [$dist_code];
    } else {
        $sql = "select * from location where dist_code =? and "
            . " subdiv_code!='00' and cir_code =? and mouza_pargona_code ='00' and "
            . " vill_townprt_code ='00000' and lot_no ='00'";
        $params = [$dist_code, $circle_code];
    }
    $query = $this->db->query($sql, $params);

    if ($query === false) {
        // Just log a simple message since error() is not available in PostgreSQL driver
        log_message('error', 'getAllCircles query failed. SQL: ' . $sql);
        return []; // return empty array to avoid crashing
    }

    return $query->num_rows() > 0 ? $query->result() : [];
}


public function getPruposeBycaseNo($case_no){
    $sql = "SELECT purpose_land_allot_co, venture_type, under_venture_school 
            FROM settlement_institution_details 
            WHERE case_no = ?";
    $query = $this->db->query($sql, [$case_no]);

    if ($query && $query->num_rows() > 0) {
        return $query->row();
    } else {
        return [];
    }
}


}