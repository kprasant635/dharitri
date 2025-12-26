<?php
class FieldMutBasicModel extends CI_Model {
    protected $table = 'field_mut_basic';

    public function __construct() {
        parent::__construct();
    }
    
    function getCasedata($caseNo){
        $condition = '';
        $dataFound = '';
        $ret = $ret = (object)[];
        if(!empty($caseNo)){
            $condition = array('case_no' => $caseNo);
        } else {
            return $ret;
        }
        $this->db->select('*')->from($this->table)->where($condition);
        $dataFound = $this->db->get()->row();
        if($dataFound){
            return $dataFound;
        }else {
            return $ret;
        }
    }

    function get_record_count($request){
        $condition = array();   
        $between = '';
        $service_type = $request['service_type'];
        if(!empty($request)){
            $searchCondition = '';
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code']  ;
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                
                if($service_type == 'name_correction'){
                    $searchCondition = " AND t1.misc_case_no LIKE '%$searchCaseNo%'";
                } else {
                    $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
                }
            }
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
        }
            
        if($service_type == 'field'){
            
            if(!empty($request)){
                if(!empty($to_date) && !empty($fm_date)){
                    $fromDate=date('Y-m-d',strtotime($fm_date));
                    $toDate=date('Y-m-d',strtotime($to_date));
                    $between = " AND (DATE(t1.if_dispose_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
                }
            }
            
            $this->db->select('count(t1.*) as count')
            ->from('field_mut_basic as t1')
            ->where("(t1.is_dispose = 'Y' or t1.order_passed = 'Y') and t1.mut_type = '02' $searchCondition $between", NULL, FALSE)
            ->where($condition);
            $this->db->join('field_part_petitioner as t2', 't1.case_no = t2.case_no', 'LEFT');
            
            $total_count = $this->db->get()->row()->count;
            return $total_count;
            
        } else if($service_type == 'office'){
        
            if(!empty($request)){
                if(!empty($to_date) && !empty($fm_date)){
                    $fromDate=date('Y-m-d',strtotime($fm_date));
                    $toDate=date('Y-m-d',strtotime($to_date));
                    $between = " AND (DATE(t1.date_entry) BETWEEN '". $fromDate. "' and '". $toDate."')";
                }
            }
            
            $this->db->select('count(t1.*) as count')
            ->from('petition_basic as t1')
            ->where("(t1.status = 'F' or t1.status = 'D') and  t1.mut_type = '04' $searchCondition $between", NULL, FALSE);
            $this->db->where($condition);
            $this->db->join('petitioner_part as t2', 't1.case_no = t2.case_no', 'LEFT');
            $this->db->join('petition_lm_note as t3', 't1.case_no = t3.case_no', 'LEFT');
                
            $total_count = $this->db->get()->row()->count;
            return $total_count;
        } else if($service_type == 'field_mut'){
            if(!empty($request)){
                if(!empty($to_date) && !empty($fm_date)){
                    $fromDate=date('Y-m-d',strtotime($fm_date));
                    $toDate=date('Y-m-d',strtotime($to_date));
                    $between = " AND (DATE(t1.if_dispose_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
                }
            }
            
            $this->db->select('count(t1.*) as count')
            ->from('field_mut_basic as t1')
            ->where("(t1.is_dispose = 'Y' or t1.order_passed = 'Y') and t1.mut_type = '01' $searchCondition $between", NULL, FALSE)
            ->where($condition);
            $this->db->join('field_mut_pattadar as t2', 't1.petition_no = t2.petition_no', 'LEFT');
            $this->db->join('rejected_remark as t3', 't1.case_no = t3.case_no', 'LEFT');
            
            $total_count = $this->db->get()->row()->count;
            return $total_count;
        } else if($service_type == 'office_mut') {
            if(!empty($request)){
                if(!empty($to_date) && !empty($fm_date)){
                    $fromDate=date('Y-m-d',strtotime($fm_date));
                    $toDate=date('Y-m-d',strtotime($to_date));
                    $between = " AND (DATE(t1.date_entry) BETWEEN '". $fromDate. "' and '". $toDate."')";
                }
            }
            
            $this->db->select('count(t1.*) as count')
             ->from('petition_basic as t1')
            ->where("(t1.status = 'F' or t1.status = 'D') and  t1.mut_type = '03' $searchCondition $between", NULL, FALSE);
            $this->db->where($condition);
            $this->db->join('petition_pattadar as t2', 't1.petition_no = t2.petition_no', 'LEFT');
            $this->db->join('petition_lm_note as t3', 't3.petition_no = t2.petition_no', 'LEFT');
                
            $total_count = $this->db->get()->row()->count;
            return $total_count;
        }  else if($service_type == 'allotment') {
            
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.circle_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.date_entry) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            $this->db->select('count(t1.*) as count')
            ->from('allotment_cert_basic as t1')
            ->where("t1.status = 'D' $searchCondition $between", NULL, FALSE);
            $this->db->where($condition);
            $this->db->join('allotment_pet_dag as t2', 't1.case_no = t2.case_no', 'LEFT');
            
            $total_count = $this->db->get()->row()->count;
            return $total_count;
        }  else if($service_type == 'area_correction') {
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.status_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            $this->db->select('count(t1.*) as count')
            ->from('t_legacyupdation as t1')
            ->where("t1.status = 'R' $searchCondition $between", NULL, FALSE);
            $this->db->where($condition);
            $total_count = $this->db->get()->row()->count;
            return $total_count;
            
        } else if($service_type == 'land_reclassification'){
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.lm_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            $this->db->select('count(t1.*) as count')
            ->from('t_reclassification as t1')
            ->where("t1.status = 'R' $searchCondition $between", NULL, FALSE);
            $this->db->where($condition);
            $total_count = $this->db->get()->row()->count;
            return $total_count;
        } else if($service_type == 'name_correction'){
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.submission_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            $this->db->select('count(t1.*) as count')
            ->from('misc_case_basic as t1')
            ->where("t1.misc_case_type = '06' and t1.status='F' $searchCondition $between", NULL, FALSE);
            $this->db->where($condition);
            $total_count = $this->db->get()->row()->count;
            return $total_count;
        }
    }
    //FPART
    function getAllRejectedDisposedFpartCases($request=array()){
        
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = '';   
        
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.if_dispose_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
            
        }
        $page = $request['page'];
        
        $this->db->select('t1.*, t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t2.user_code as lmcode')
        ->from('field_mut_basic as t1')
        ->where("(t1.is_dispose = 'Y' or t1.order_passed = 'Y') and t1.mut_type = '02' $searchCondition $between", NULL, FALSE)
        ->where($condition);
        $this->db->join('field_part_petitioner as t2', 't1.case_no = t2.case_no', 'LEFT');
        $this->db->limit($page_limit, $page);
              
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    //OPART
    function getAllRejectedDisposedOpartCases($request=array()){
        
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = '';   
        
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.date_entry) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
        }
        
        $page = $request['page'];
        
        //$this->db->select('t1.*,t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t3.user_code as lm_code')
        $this->db->select('t1.*,t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t3.lm_code as lmcode')
        //$this->db->select('t1.*,t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t2.user_code as lm_code')
        ->from('petition_basic as t1')
        ->where("(t1.status = 'F' or t1.status = 'D') and  t1.mut_type = '04' $searchCondition $between", NULL, FALSE);
        $this->db->where($condition);
        //$this->db->join('field_part_petitioner as t2', 't1.case_no = t2.case_no', 'LEFT');
        $this->db->join('petitioner_part as t2', 't1.case_no = t2.case_no', 'LEFT');
        $this->db->join('petition_lm_note as t3', 't1.case_no = t3.case_no', 'LEFT');
        
        $this->db->limit($page_limit, $page);
        
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
    //FMUT
    function getAllRejectedDisposedFmutCases($request=array()){
        
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = '';   
        
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.if_dispose_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
            
        }
        $page = $request['page'];
        
        //$this->db->select('t1.*, t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t2.user_code as lmcode')
        $this->db->select('t1.*, t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t1.user_code as lmcode, t3.user_code as co_code')
        ->from('field_mut_basic as t1')
        ->where("(t1.is_dispose = 'Y' or t1.order_passed = 'Y') and t1.mut_type = '01' $searchCondition $between", NULL, FALSE)
        ->where($condition);
        $this->db->join('field_mut_pattadar as t2', 't1.petition_no = t2.petition_no', 'LEFT');
        $this->db->join('rejected_remark as t3', 't1.case_no = t3.case_no', 'LEFT');
        
        
        $this->db->limit($page_limit, $page);
              
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
    //OMUT
    function getAllRejectedDisposedOmutCases($request=array()){
        
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = '';   
        
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.date_entry) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
        }
        
        $page = $request['page'];
        
        //$this->db->select('t1.*,t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t2.user_code as lmcode')
        $this->db->select('t1.*,t2.dag_no, t2.patta_no,t2.petition_no, t2.pdar_name, t3.lm_code as lmcode')
        ->from('petition_basic as t1')
        ->where("(t1.status = 'F' or t1.status = 'D') and  t1.mut_type = '03' $searchCondition $between", NULL, FALSE);
        $this->db->where($condition);
        $this->db->join('petition_pattadar as t2', 't1.petition_no = t2.petition_no', 'LEFT');
        $this->db->join('petition_lm_note as t3', 't3.petition_no = t2.petition_no', 'LEFT');
        
        $this->db->limit($page_limit, $page);
        
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
    function getAllRejectedDisposedAllotments($request=array()){
        
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = '';   
        
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.circle_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.date_entry) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
            
        }
        $page = $request['page'];
        
        $this->db->select('t1.*, t2.dag_no, t2.patta_no, t1.name_of_allote as pdar_name')
        ->from('allotment_cert_basic as t1')
        ->where("t1.status = 'D' $searchCondition $between", NULL, FALSE);
        $this->db->where($condition);
        $this->db->join('allotment_pet_dag as t2', 't1.case_no = t2.case_no', 'LEFT');
        
        $this->db->limit($page_limit, $page);
              
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
    function getAllRejectedAreaCorrection($request=array()){
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = ''; 
         
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.status_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
        }
        
        $page = $request['page'];
        $this->db->select('t1.*')
        ->from('t_legacyupdation as t1')
        ->where("t1.status = 'R' $searchCondition $between", NULL, FALSE);
        $this->db->where($condition);
        $this->db->limit($page_limit, $page);
              
        $dataFound = $this->db->get()->result();
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
    function getAllRejectedLandReclassification($request=array()){
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = ''; 
         
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.lm_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.case_no LIKE '%$searchCaseNo%'";
            }
        }
        
        $page = $request['page'];
        $this->db->select('t1.*,t2.user_code as user_code')
        ->from('t_reclassification as t1')
        ->where("t1.status = 'R' $searchCondition $between", NULL, FALSE);
        $this->db->where($condition);
        $this->db->join('petition_proceeding_dc_adc as t2', "t1.case_no = t2.case_no and t2.user_code like 'CO%'", 'LEFT');
        
        $this->db->limit($page_limit, $page);
              
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
    function getAllRejectedNameCorrection($request=array()){
        $condition = '';
        $dataFound = '';
        $condition = array();   
        $between = ''; 
         
        if(!empty($request)){
            $searchCondition = '';
            $page_limit = $request['page_limit'];
            $dist_code = $request['dist_code'];
            $subdiv_code = $request['subdiv_code'];
            $circle_code = $request['circle_code'];
            $mouza_code = $request['mouza_code'];
            $lot_no = $request['lot_no'];
            $vill_code = $request['vill_code'];
            $fm_date = $request['fm-date'];
            $to_date = $request['to-date'];
            $condition = array('t1.dist_code'=>$dist_code,'t1.subdiv_code'=>$subdiv_code,'t1.cir_code'=>$circle_code,'t1.mouza_pargona_code'=>$mouza_code,'t1.lot_no'=>$lot_no,'t1.vill_townprt_code'=>$vill_code); 
            if(!empty($to_date) && !empty($fm_date)){
                $fromDate=date('Y-m-d',strtotime($fm_date));
                $toDate=date('Y-m-d',strtotime($to_date));
                $between = " AND (DATE(t1.submission_date) BETWEEN '". $fromDate. "' and '". $toDate."')";
            }
            
            if(!empty($request['searchCaseNo'])){
                $searchCaseNo = trim($request['searchCaseNo']);
                $searchCondition = " AND t1.misc_case_no LIKE '%$searchCaseNo%'";
            }
        }
        
        $page = $request['page'];
        $this->db->select('t1.*,t1.misc_case_no as case_no,t2.petition_pdar_name_new as pdar_name, t3.user_code as lmcode')
        ->from('misc_case_basic as t1')
        ->where("t1.misc_case_type = '06' and t1.status='F'  $searchCondition $between", NULL, FALSE);
        $this->db->where($condition);
        //$this->db->group_by('t1.misc_case_no');
        $this->db->join('misc_case_first_party as t2', 't1.misc_case_no = t2.misc_case_no', 'LEFT');
        $this->db->join('misc_case_process_reports as t3', "t1.misc_case_no = t3.misc_case_no and t3.operation='l' and t3.note_no='2'", 'LEFT');
        //$this->db->join("misc_case_process_reports t3", "(t1.misc_case_no = t3.misc_case_no) and (t3.operation='l')", "left outer");
        $this->db->limit($page_limit, $page);
              
        $dataFound = $this->db->get()->result();
        
        //print_r($this->db->last_query());
        
        if($dataFound){
            return $dataFound;
        }else {
            return 0;
        }
    }
    
}
  