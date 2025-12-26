<?php
class RejectedDataModel extends CI_Model
{

    // dharitree case type
    var $omut    = 'OMUT';
    var $opart   = 'OPART';
    var $conv    = 'CONV';
    var $omutc   = 'OMUTC';
    var $fmut    = 'FMUT';
    var $fpart   = 'FPART';
    var $mind    = 'MIND';
    var $minc    = 'MINC';
    var $reclass = 'RECLASS';
    var $acpp    = 'ACPP';
    var $stpp    = 'STPP';
    var $cert    = 'CERT';
    var $ldu     = 'LDU';
    var $nr      = 'NR';

    function __construct()
    {
        parent::__construct();
        $this->dist_code = $this->session->userdata('dist_code');
        $this->subdiv_code = $this->session->userdata('subdiv_code');
        $this->cir_code = $this->session->userdata('cir_code');
    }

    // get case type from dharitree case no
    public function getCaseTypeFromCaseNo($case_no){
        $arr = explode('/',$case_no);
        $arrCount = count($arr);
        if($arrCount ==5){
            $json = [
                'response'  => 1,
                'case_type' => $arr['4'],
            ];
            return json_encode($json);
        }
        else {
            $json = [
                'response'  => 2,
                'petition' => $arrCount,
            ];
            return json_encode($json);
        }
    }

    // get name of tables by dharitree case type
    public function getTableNameByCaseType($caseType)
    {
        $case_type = strtoupper($caseType);

        $table = 'settlement_basic';

        if($case_type == $this->omut || $case_type == $this->omut || $case_type == $this->conv || $case_type == $this->omutc || $case_type == $this->opart){
            $table = 'petition_basic';
        }
        else if($case_type == $this->fmut || $case_type == $this->fpart){
            $table = 'field_mut_basic';
        }
        else if($case_type == $this->mind || $case_type == $this->minc){
            $table = 'misc_case_basic';
        }
        else if($case_type == $this->reclass){
            $table = 't_reclassification';
        }
        else if($case_type == $this->acpp || $case_type == $this->stpp){
            $table = 'allotment_cert_basic';
        }
        else if($case_type == $this->cert){
            $table = 'cert_application';
        }
        else if($case_type == $this->ldu){
            $table = 't_legacyupdation';
        }
        else if($case_type == $this->nr){
            $table = 'apcancel_petition_basic';
        }
        return $table;
    }

    // get by case no
    public function getCasesByCaseNo($table, $caseNo, $like=null)
    {
        $like = strtoupper($like);

        // var_dump($like);die;

        if(($table == 'petition_basic') || ($table == 'field_mut_basic') || ($table == 'allotment_cert_basic') || ($table == 'settlement_basic'))
        {
            $this->db->select('case_no, date_entry as submission_date');
            if($like==null){
                $this->db->where('case_no', $caseNo);
            }
            else {
                $this->db->where("UPPER(case_no) LIKE '$like'");
            }
        }

        else if($table == 'misc_case_basic'){
            $this->db->select('misc_case_no as case_no, submission_date');
            if($like==null){
                $this->db->where('misc_case_no', $caseNo);
            }
            else {
                $this->db->where("UPPER(misc_case_no) LIKE '$like'");
            }
        }

        else if(($table == 't_legacyupdation') || ($table == 't_reclassification')){
            $this->db->select('case_no, status_date as submission_date');
            if($like==null){
                $this->db->where('case_no', $caseNo);
            }
            else {
                $this->db->where("UPPER(case_no) LIKE '$like'");
            }
            // $this->db->where('case_no', $caseNo);
            // $this->db->where("UPPER(case_no) LIKE '$like'");
        }

        $this->db->where('dist_code', $this->dist_code);
        $data = $this->db->get($table);
        return $data;
    }

    // get dharitree case no from rtps appl no
    public function getDharitreeCaseNoByRtpsNo($applNo)
    {
        $this->db->select('dharitree');
        $this->db->from('basundhar_application');
        $this->db->where('basundhara', $applNo);
        $data = $this->db->get();
        return $data->row()->dharitree;
    }

    public function getTableByService($serviceId) {

        $table = '';
        $like  = '';
        $type  = '';

        if($serviceId == 'OMUT'){
            $table = 'petition_basic';
            // $like = '%OMUT';
            $type = 'OMUT';
        }elseif($serviceId == 'OMUTD'){
            $table = 'petition_basic';
            // $like = '%OMUT';
            $type = 'OMUTD';
        }
        else if($serviceId == 'FMUT'){
            $table = 'field_mut_basic';
            // $like = '%FMUT';
            $type = 'FMUT';
        }else if($serviceId == 'FMUTD'){
            $table = 'field_mut_basic';
            // $like = '%FMUT';
            $type = 'FMUTD';
        }
        else if($serviceId == 'OMUTC'){
            $table = 'petition_basic';
            // $like = '%OMUTC';
            $type = 'OMUTC';
        }
        
        $json = [
            'table' => $table,
            'type'  => $type,
        ];
        return json_encode($json);
    }

    public function getDetailsByServiceName($table, $like, $length, $start) {

        if(($table == 'petition_basic') || ($table == 'field_mut_basic') || ($table == 'allotment_cert_basic') || ($table == 'settlement_basic'))
        {
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where("case_no LIKE '$like'");
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $basic = $this->db->get($table)->result();

            //get total records
            $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                        WHERE case_no LIKE '$like' AND dist_code=?", array($this->dist_code))->num_rows();
        }

        else if($table == 'misc_case_basic'){
            $this->db->select('misc_case_no as case_no, submission_date');
            $this->db->where("misc_case_no LIKE '$like'");
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $basic = $this->db->get($table)->result();

            //get total records
            $total_records = $this->db->query("SELECT misc_case_no as case_no, submission_date FROM $table
                        WHERE misc_case_no LIKE '$like' AND dist_code=?",
                array($this->dist_code))->num_rows();
        }

        else if(($table == 't_reclassification')){
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("case_no LIKE '$like'");
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $basic = $this->db->get($table)->result();

            //get total records
            $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                        WHERE case_no LIKE '$like' AND dist_code=?", array($this->dist_code))->num_rows();
        }

        else if(($table == 't_legacyupdation')){
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("case_no LIKE '$like'");
            $this->db->where('suggested_dag_area_b is not null');
            $this->db->where('suggested_dag_area_k is not null');
            $this->db->where('suggested_dag_area_lc is not null');
            $this->db->where('suggested_dag_area_g is not null');
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $basic = $this->db->get($table)->result();

            //get total records
            $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                        WHERE case_no LIKE '$like' AND dist_code=?
                        AND suggested_dag_area_b is not null AND suggested_dag_area_k is not null
                        AND suggested_dag_area_lc is not null AND suggested_dag_area_g is not null
                        ", array($this->dist_code))->num_rows();
        }

        // $this->db->limit($length, $start);
        // $this->db->where('dist_code', $this->dist_code);
        // $data = $this->db->get($table);
        // return $data;

        $json = [
            'fetchedData'   => $basic,
            'total_records' => $total_records,
        ];

        return json_encode($json);

    }


    public function getDetailsByPetitionNo($table, $caseNo, $like) {

        if(($table == 'petition_basic') || ($table == 'field_mut_basic') || ($table == 'allotment_cert_basic') || ($table == 'settlement_basic'))
        {
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where('petition_no', $caseNo);
            $this->db->where("case_no LIKE '$like'");
        }

        else if($table == 'misc_case_basic'){
            $this->db->select('misc_case_no as case_no, submission_date');
            $this->db->where('misc_case_petition_no', $caseNo);
            $this->db->where("misc_case_no LIKE '$like'");
        }

        else if(($table == 't_reclassification')){
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("case_no LIKE '".'%'.$caseNo.'%'."'");
        }

        else if(($table == 't_legacyupdation')){
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("case_no LIKE '".'%'.$caseNo.'%'."'");
            $this->db->where('suggested_dag_area_b is not null');
            $this->db->where('suggested_dag_area_k is not null');
            $this->db->where('suggested_dag_area_lc is not null');
            $this->db->where('suggested_dag_area_g is not null');
        }

        $this->db->where('dist_code', $this->dist_code);
        $data = $this->db->get($table);
        return $data;
    }

    public function getFetchedDataBetweenDates($serviceName, $appStatus, $pendingOffice, $selectCircle, $fromDate, $toDate, $length, $start) {

        $fromDate = date('Y-m-d', strtotime($fromDate));
        $toDate   = date('Y-m-d', strtotime($toDate));
        $cirCode  = '';
        $status   = '';
        $pending  = '';

        // if no service select
        if($serviceName == null || $serviceName == '') {

            //get data from petition_basic between dates
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $petition_basic = $this->db->get('petition_basic')->result();

            //get data from field_mut_basic between dates
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $field_mut_basic = $this->db->get('field_mut_basic')->result();

            //get data from allotment_cert_basic between dates
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $allotment_cert_basic = $this->db->get('allotment_cert_basic')->result();

            //get data from settlement_basic between dates
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('dist_code', $this->dist_code);
            if($appStatus != '')
            {
                $this->db->where('status', $appStatus);
            }
            if($pendingOffice != '')
            {
                $this->db->where('pending_officer', $pendingOffice);
            }
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $settlement_basic = $this->db->get('settlement_basic')->result();

            //get data from misc_case_basic between dates
            $this->db->select('misc_case_no as case_no, submission_date');
            $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $misc_case_basic = $this->db->get('misc_case_basic')->result();

            //get data from t_legacyupdation between dates
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('suggested_dag_area_b is not null');
            $this->db->where('suggested_dag_area_k is not null');
            $this->db->where('suggested_dag_area_lc is not null');
            $this->db->where('suggested_dag_area_g is not null');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $t_legacyupdation = $this->db->get('t_legacyupdation')->result();

            //get data from t_reclassification between dates
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            $t_reclassification = $this->db->get('t_reclassification')->result();

            $query = array_merge($settlement_basic, $petition_basic, $field_mut_basic, $allotment_cert_basic, $misc_case_basic, $t_legacyupdation, $t_reclassification);

            $finalArray = $this->getSlicingElementFromAnArray($query, $start, $length);

            $json = [
                'fetchedData'   => $finalArray,
                'total_records' => count($query),
            ];

            return json_encode($json);

        }

        // if service selects if($serviceName != null || $serviceName != '')
        else {

            $service = json_decode($this->getTableByService($serviceName));
            $table   = $service->table;

            if($table == 'settlement_basic')
            {
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                $this->db->where("case_no like '$service->like'");
                $this->db->where('dist_code', $this->dist_code);
                if($appStatus != '')
                {
                    $this->db->where('status', $appStatus);
                }
                if($pendingOffice != '')
                {
                    $this->db->where('pending_officer', $pendingOffice);
                }
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($appStatus != '')
                {
                    $status = " AND status = '$appStatus'";
                }
                if($pendingOffice != '')
                {
                    $pending = " AND pending_officer = '$pendingOffice'";
                }
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE date(date_entry) BETWEEN '$fromDate' AND '$toDate' 
                          AND dist_code=? AND case_no like '$service->like' $cirCode $status $pending",
                    array($this->dist_code))->num_rows();
            }

            else if(($table == 'petition_basic') || ($table == 'field_mut_basic') || ($table == 'allotment_cert_basic'))
            {
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE date(date_entry) BETWEEN '$fromDate' AND '$toDate' 
                          AND dist_code=? $cirCode", array($this->dist_code))->num_rows();
            }

            else if($table == 'misc_case_basic')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                $total_records = $this->db->query("SELECT misc_case_no as case_no, submission_date FROM $table
                          WHERE date(submission_date) BETWEEN '$fromDate' AND '$toDate' 
                          AND dist_code=? $cirCode", array($this->dist_code))->num_rows();
            }

            else if(($table == 't_reclassification'))
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                          WHERE date(status_date) BETWEEN '$fromDate' AND '$toDate' 
                          AND dist_code=? $cirCode", array($this->dist_code))->num_rows();

            }

            else if(($table == 't_legacyupdation'))
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('suggested_dag_area_b is not null');
                $this->db->where('suggested_dag_area_k is not null');
                $this->db->where('suggested_dag_area_lc is not null');
                $this->db->where('suggested_dag_area_g is not null');
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                          WHERE date(status_date) BETWEEN '$fromDate' AND '$toDate' 
                          AND dist_code=? 
                          AND suggested_dag_area_b is not null AND suggested_dag_area_k is not null
                          AND suggested_dag_area_lc is not null AND suggested_dag_area_g is not null
                          $cirCode", array($this->dist_code))->num_rows();

            }

            $json = [
                'fetchedData'   => $basic,
                'total_records' => $total_records,
            ];

            return json_encode($json);
        }

    }

    public function getTableWiseRejectData($fromDate, $toDate, $length, $start, $table, $type) {
        // log_message('error','table==========='.$fromDate."===".$toDate."===".$length."===".$start."===".$table."===".$type);
        $cirCode = '';
        $betweenDates = '';

        //if table selects ---------------------------------
        if($table != '' || $table != null) {
            

            if(($table == 'petition_basic'))
            {

                $this->db->select('case_no,mouza_pargona_code,lot_no,dist_code,subdiv_code,cir_code,date_of_order as rejected, date_entry as submission_date');
                $this->db->where('status', 'D');
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('subdiv_code', $this->subdiv_code);
                $this->db->where('cir_code', $this->cir_code);
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                if($type == 'OMUT')
                {
                    $this->db->where('mut_type', '03');
                    $this->db->where('deed_no is null');
                    $this->db->where('comp_serv_yn is null');
                    $mut_type_check = " AND mut_type ='03' and deed_no is null and comp_serv_yn is null";
                }
                if($type == 'OMUTD')
                {
                    $this->db->where('mut_type', '03');
                    $this->db->where('deed_no is not null');
                    $this->db->where('comp_serv_yn is null');
                    $mut_type_check = " AND mut_type ='03' and deed_no is not null and comp_serv_yn is null";
                }
                if($type == 'OMUTC')
                {
                    $this->db->where('mut_type', '03');
                    $this->db->where('comp_serv_yn', 'Y');
                    $mut_type_check = " AND mut_type ='03' and comp_serv_yn='Y'";
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                log_message('error','REJECTQUERY3==========='.$this->db->last_query());
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE status=? AND dist_code=? AND subdiv_code = ? AND cir_code = ?  $betweenDates $mut_type_check",
                    array('D', $this->dist_code,$this->subdiv_code,$this->cir_code))->num_rows();
                log_message('error','REJECTQUERY4==========='.$this->db->last_query());
            }
            else if($table == 'field_mut_basic'){
                $this->db->select('case_no,mouza_pargona_code,lot_no,dist_code,subdiv_code,cir_code,if_dispose_date as rejected ,date_entry as submission_date');
                $this->db->where('is_dispose', 'Y');
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('subdiv_code', $this->subdiv_code);
                $this->db->where('cir_code', $this->cir_code);
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
            
                if($type == 'FMUT')
                {
                    $this->db->where('mut_type', '01');
                    $this->db->where('reg_deed_no is null');
                    $mut_type_check = " AND mut_type ='01' and reg_deed_no is null";
                }
                if($type == 'FMUTD')
                {
                    $this->db->where('mut_type', '01');
                    $this->db->where('reg_deed_no is not null');
                    $mut_type_check = " AND mut_type ='01' and reg_deed_no is not null";
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                // log_message('error','REJECTQUERY1==========='.$this->db->last_query());
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE is_dispose=? AND dist_code=? and subdiv_code=? and cir_code=? $betweenDates $mut_type_check",
                    array('Y', $this->dist_code,$this->subdiv_code,$this->cir_code))->num_rows();
                // log_message('error','REJECTQUERY2==========='.$this->db->last_query());
            }
            

            $json = [
                'fetchedData'   => $basic,
                'total_records' => $total_records,
            ];
            // log_message('error','REJECTQUERY2==========='.json_encode($json));
            return json_encode($json);
        }
        // -------------------------------------------

    }

    public function getTableWiseApproveData($selectCircle, $fromDate, $toDate, $length, $start, $table, $type, $like) {

        $cirCode = '';
        $betweenDates = '';

        //if table selects ---------------------------------
        if($table != '' || $table != null) {

            if(($table == 'petition_basic') || ($table == 'allotment_cert_basic'))
            {
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('status', 'F');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE status=? AND dist_code=? $cirCode $betweenDates",
                    array('F', $this->dist_code))->num_rows();
            }
            else if($table == 'field_mut_basic'){
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('order_passed', 'F');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE order_passed=? AND dist_code=? $cirCode $betweenDates",
                    array('F', $this->dist_code))->num_rows();
            }
            else if($table == 'settlement_basic'){
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('status', 'F');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE status=? AND dist_code=? $cirCode $betweenDates",
                    array('F', $this->dist_code))->num_rows();
            }
            else if($table == 'misc_case_basic'){
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where('status', '10');
                $this->db->where('operation', 's');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT misc_case_no as case_no, submission_date FROM $table
                          WHERE status IN ('10', 's') AND dist_code=? $cirCode $betweenDates",
                    array($this->dist_code))->num_rows();
            }
            else if($table == 't_legacyupdation'){
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where('status', 'D');
                $this->db->where('dist_code', $this->dist_code);

                $this->db->where('suggested_dag_area_b is not null');
                $this->db->where('suggested_dag_area_k is not null');
                $this->db->where('suggested_dag_area_lc is not null');
                $this->db->where('suggested_dag_area_g is not null');

                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $t_legacyupdation = $this->db->get('t_legacyupdation')->result();
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                          WHERE status =? AND dist_code=?
                          AND suggested_dag_area_b is not null AND suggested_dag_area_k is not null
                          AND suggested_dag_area_lc is not null AND suggested_dag_area_g is not null
                          $cirCode $betweenDates",
                    array('D', $this->dist_code))->num_rows();
            }
            else if($table == 't_reclassification'){
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where('status', 'F');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $t_reclassification = $this->db->get('t_reclassification')->result();
                $this->db->limit($length, $start);
                $basic = $this->db->get($table)->result();

                //get total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                          WHERE status =? AND dist_code=? $cirCode $betweenDates",
                    array('F', $this->dist_code))->num_rows();
            }

            $json = [
                'fetchedData'   => $basic,
                'total_records' => $total_records,
            ];

            return json_encode($json);
        }

        // -------------------------------------------
        else {

            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where('status', 'F');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $settlement_basic = $this->db->get('settlement_basic')->result();

            //get data from petition_basic
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where('status', 'F');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $petition_basic = $this->db->get('petition_basic')->result();

            //get data from field_mut_basic
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where('order_passed', 'F');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $field_mut_basic = $this->db->get('field_mut_basic')->result();

            //get data from allotment_cert_basic
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where('status', 'F');
            $this->db->where('chitha_correct_yn', 'Y');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $allotment_cert_basic = $this->db->get('allotment_cert_basic')->result();

            // get data from misc_case_basic
            $this->db->select('misc_case_no as case_no, submission_date');
            $this->db->where('status', '10');
            $this->db->where('operation', 's');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
            }
            $misc_case_basic = $this->db->get('misc_case_basic')->result();


            //get data from t_legacyupdation
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where('status', 'D');
            $this->db->where('dist_code', $this->dist_code);
            $this->db->where('suggested_dag_area_b is not null');
            $this->db->where('suggested_dag_area_k is not null');
            $this->db->where('suggested_dag_area_lc is not null');
            $this->db->where('suggested_dag_area_g is not null');
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
            }
            $t_legacyupdation = $this->db->get('t_legacyupdation')->result();

            //get data from t_reclassification
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where('status', 'F');
            $this->db->where('dist_code', $this->dist_code);
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
            }
            $t_reclassification = $this->db->get('t_reclassification')->result();

            $query = array_merge($settlement_basic, $petition_basic, $field_mut_basic, $allotment_cert_basic, $misc_case_basic, $t_legacyupdation, $t_reclassification);

            $finalArray = $this->getSlicingElementFromAnArray($query, $start, $length);

            $json = [
                'fetchedData'   => $finalArray,
                'total_records' => count($query),
            ];

            return json_encode($json);
        }
    }

    public function getSearchedDataByApplicationStatus($appStatus, $fromDate, $toDate, $length, $start, $table, $type) {

        $cirCode = '';
        $betweenDates = '';
        if($appStatus == 'REJECT') {

            $data = json_decode($this->getTableWiseRejectData($fromDate, $toDate, $length, $start, $table, $type));

            $fetchedData = $data->fetchedData;
            $total_records = $data->total_records;
        }

        $finalArr = [
            'fetchedData'   => $fetchedData,
            'total_records' => $total_records
        ];

        return json_encode($finalArr);
    }


    public function getDataByPendingOfficer($table, $service_type, $pendingOffice, $selectCircle, $fromDate, $toDate, $length, $start, $like) {

        $cirCode = '';
        $betweenDates = '';

        //get pending data from field_mut_basic
        if($table == 'field_mut_basic') {

            if($pendingOffice == 'LM'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('is_dispose', 'L');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE is_dispose=? AND dist_code=? $cirCode $betweenDates", array('L', $this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'SK'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('is_dispose', 'S');
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE is_dispose=? AND dist_code=? $cirCode $betweenDates", array('S', $this->dist_code))->num_rows();

            }

            else if($pendingOffice == 'CO'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('is_dispose', null);
                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE is_dispose IS NULL AND dist_code=? $cirCode $betweenDates", array($this->dist_code))->num_rows();
            }
        }

        //get pending data from petition_basic (OFFICE MUTATION)
        else if($table == 'petition_basic' && $service_type == 'OMUT') {

            if($pendingOffice == 'LM')
            {
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('mut_type', '03');
                $this->db->where("case_no like '%OMUT%'");

                $this->db->where('lm_note_yn', null);
                $this->db->where('not_fresh is not null');

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OMUT%' AND lm_note_yn IS NULL AND not_fresh IS NOT NULL $cirCode $betweenDates", array('03',$this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'AST'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('mut_type', '03');
                $this->db->where("case_no like '%OMUT%'");

                $this->db->where("((notice_generated_yn is null and not_fresh is not null) or (proceeding_yn is null and notice_served_yn is not null))");

                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OMUT%' AND (notice_generated_yn is null and not_fresh is not null) or (proceeding_yn is null and notice_served_yn is not null) $cirCode $betweenDates", array('03',$this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'SK'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('mut_type', '03');
                $this->db->where('sk_comment is null and not_fresh is not null');
                $this->db->where("case_no like '%OMUT%'");

                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OMUT%' AND sk_comment is null and not_fresh is not null $cirCode $betweenDates", array('03',$this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'CO'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('mut_type', '03');
                $this->db->where("case_no like '%OMUT%'");

                $this->db->where("((not_fresh is null and status is null) or (order_passed is null and status != 'F' and proceeding_yn is not null and not_fresh is null))");

                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OMUT%' AND ((not_fresh is null and status is null) or (order_passed is null and status != 'F' and proceeding_yn is not null and not_fresh is null)) $cirCode $betweenDates", array('03',$this->dist_code))->num_rows();
            }
        }

        //get pending data from petition_basic (OFFICE PARTITION)
        else if($table == 'petition_basic' && $service_type == 'OPART') {

            if($pendingOffice == 'AST')
            {
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('mut_type', '04');
                $this->db->where("case_no like '%OPART%'");

                $this->db->where("(notice_generated_yn is null and not fresh is not null) OR (not_fresh='Y' and proceeding_yn is null and status='P') OR (not_fresh='Y' and proceeding_yn is null and status='P' and pay_notice_gen_yn = 'Y')");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OPART%' AND (notice_generated_yn is null and not fresh is not null) OR (not_fresh='Y' and proceeding_yn is null and status='P') OR (not_fresh='Y' and proceeding_yn is null and status='P' and pay_notice_gen_yn = 'Y') $cirCode $betweenDates", array('04',$this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'LM')
            {

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('mut_type', '04');
                $this->db->where("case_no like '%OPART%'");

                $this->db->where("(lm_note_yn is null and not_fresh is not null) OR (byayprak_yn is null and not_fresh is not null)");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OPART%' AND (lm_note_yn is null and not_fresh is not null) OR (byayprak_yn is null and not_fresh is not null) $cirCode $betweenDates", array('04',$this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'SK'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('mut_type', '04');
                $this->db->where("case_no like '%OPART%'");
                $this->db->where('dist_code', $this->dist_code);
                $this->db->where('sk_comment is null and not_fresh is not null');

                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OPART%' AND sk_comment is null AND not_fresh is not null $cirCode $betweenDates", array('04',$this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'CO'){

                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where('mut_type', '04');
                $this->db->where("case_no like '%OPART%'");
                $this->db->where('dist_code', $this->dist_code);

                $this->db->where("((order_passed is null and not_fresh is null) or (order_passed is null and status != 'F' and proceeding_yn is not null and pay_notice_gen_yn is not null))");

                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE mut_type=? AND dist_code=? AND case_no LIKE '%OPART%' AND ((order_passed is null and not_fresh is null) or (order_passed is null and status != 'F' and proceeding_yn is not null and pay_notice_gen_yn is not null)) $cirCode $betweenDates", array('04',$this->dist_code))->num_rows();
            }
        }

        //get pending data from misc_case_basic (NAME CORRECTION)
        else if($table == 'misc_case_basic' && strtoupper($service_type) == 'MINC') {

            if($pendingOffice == 'LM')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where("UPPER(status) in ('18','L')");
                $this->db->where("lm_note_yn", null);
                $this->db->where("UPPER(misc_case_no) like '%MINC%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT misc_case_no as case_no, submission_date FROM $table
                            WHERE dist_code=? AND UPPER(misc_case_no) LIKE '%MINC%' AND 
                              UPPER(status) IN ('18','L') AND lm_note_yn IS NULL
                                $cirCode $betweenDates", array($this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'CO')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where("status in ('1','02')");
                $this->db->where('UPPER(operation)', 'S');
                $this->db->where("sk_note_yn is not null");
                $this->db->where("lm_note_yn is not null");
                $this->db->where("UPPER(misc_case_no) like '%MINC%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT misc_case_no, submission_date FROM $table
                            WHERE dist_code=? AND UPPER(misc_case_no) LIKE '%MINC%' AND 
                              UPPER(status) IN ('1','02') AND UPPER(operation)='S'
                               AND sk_note_yn IS NOT NULL AND lm_note_yn IS NOT NULL
                                $cirCode $betweenDates", array($this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'SK')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where('status', '02');
                $this->db->where('sk_note_yn', null);
                $this->db->where('UPPER(operation)','L');
                $this->db->where("UPPER(misc_case_no) like '%MINC%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }

                $total_records = $this->db->query("SELECT misc_case_no, submission_date FROM $table
                            WHERE dist_code=? AND UPPER(misc_case_no) LIKE '%MINC%' AND 
                              status='02' AND UPPER(operation)='L'
                                AND sk_note_yn IS NULL $cirCode $betweenDates",
                    array($this->dist_code))->num_rows();
            }
        }

        //get pending data from misc_case_basic (NAME DELETION)
        else if($table == 'misc_case_basic' && strtoupper($service_type) == 'MIND') {

            if($pendingOffice == 'LM')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where("UPPER(status) in ('18','L')");
                $this->db->where("lm_note_yn", null);
                $this->db->where("UPPER(misc_case_no) like '%MIND%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT misc_case_no as case_no, submission_date FROM $table
                            WHERE dist_code=? AND UPPER(misc_case_no) LIKE '%MIND%' AND 
                              UPPER(status) IN ('18','L') AND lm_note_yn IS NULL
                                $cirCode $betweenDates", array($this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'CO')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where("status in ('01','02')");
                $this->db->where('UPPER(operation)', 'E');
                $this->db->where("sk_note_yn is not null");
                $this->db->where("lm_note_yn is not null");
                $this->db->where("UPPER(misc_case_no) like '%MIND%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT misc_case_no, submission_date FROM $table
                            WHERE dist_code=? AND UPPER(misc_case_no) LIKE '%MIND%' AND 
                              UPPER(status) IN ('01','02') AND UPPER(operation)='E'
                               AND sk_note_yn IS NOT NULL AND lm_note_yn IS NOT NULL
                                $cirCode $betweenDates", array($this->dist_code))->num_rows();
            }

            else if($pendingOffice == 'SK')
            {
                $this->db->select('misc_case_no as case_no, submission_date');
                $this->db->where('status', '02');
                $this->db->where('sk_note_yn', null);
                $this->db->where('UPPER(operation)','L');
                $this->db->where("UPPER(misc_case_no) like '%MIND%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(submission_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(submission_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT misc_case_no, submission_date FROM $table
                            WHERE dist_code=? AND UPPER(misc_case_no) LIKE '%MIND%' AND 
                              status='02' AND UPPER(operation)='L'
                                AND sk_note_yn IS NULL $cirCode $betweenDates",
                    array($this->dist_code))->num_rows();
            }
        }

        //get pending data from t_reclassification (RECLASSIFICATION)
        else if($table == 't_reclassification' && strtoupper($service_type) == 'RECLASS') {

            if($pendingOffice == 'CO')
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where("status is null or UPPER(status) = 'C'");
                $this->db->where('UPPER(lm_yn)', 'Y');
                $this->db->where("UPPER(case_no) like '%RECLASS%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                            WHERE dist_code=? AND UPPER(case_no) LIKE '%RECLASS%' AND 
                              (status is null or UPPER(status) = 'C') AND UPPER(lm_yn)=?
                                $cirCode $betweenDates", array($this->dist_code, 'Y'))->num_rows();
            }

            else if($pendingOffice == 'ADC')
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where("UPPER(status)", 'A');
                $this->db->where('UPPER(lm_yn)', 'Y');
                $this->db->where("UPPER(case_no) like '%RECLASS%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }

                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                            WHERE dist_code=? AND UPPER(case_no) LIKE '%RECLASS%' AND 
                              UPPER(status)=? AND UPPER(lm_yn)=?
                                $cirCode $betweenDates", array($this->dist_code, 'A', 'Y'))->num_rows();
            }

            else if($pendingOffice == 'DC')
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where("UPPER(status)", 'D');
                $this->db->where('UPPER(lm_yn)', 'Y');
                $this->db->where("UPPER(case_no) like '%RECLASS%'");

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }

                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                            WHERE dist_code=? AND UPPER(case_no) LIKE '%RECLASS%' AND 
                              UPPER(status)=? AND UPPER(lm_yn)=?
                                $cirCode $betweenDates", array($this->dist_code, 'D', 'Y'))->num_rows();
            }
        }

        //get pending data from t_legacyupdation (AREA CORRECTION)
        else if($table == 't_legacyupdation' && strtoupper($service_type) == 'LDU') {

            if($pendingOffice == 'CO')
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where('UPPER(status)','P');
                $this->db->where('lm_note is not null');
                $this->db->where('co_note', null);
                $this->db->where("UPPER(case_no) like '%LDU%'");

                $this->db->where('suggested_dag_area_b is not null');
                $this->db->where('suggested_dag_area_k is not null');
                $this->db->where('suggested_dag_area_lc is not null');
                $this->db->where('suggested_dag_area_g is not null');

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }
                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                            WHERE dist_code=? AND UPPER(case_no) LIKE '%LDU%' AND 
                              UPPER(status)=? AND lm_note IS NOT NULL AND co_note IS NULL

                              AND suggested_dag_area_b is not null AND suggested_dag_area_k is not null
                              AND suggested_dag_area_lc is not null AND suggested_dag_area_g is not null

                                $cirCode $betweenDates", array($this->dist_code, 'P'))->num_rows();
            }

            else if($pendingOffice == 'ADC')
            {
                $this->db->select('case_no, status_date as submission_date');
                $this->db->where('UPPER(status)','P');
                $this->db->where('lm_note is not null');
                $this->db->where('co_note is not null');
                $this->db->where("UPPER(case_no) like '%LDU%'");

                $this->db->where('suggested_dag_area_b is not null');
                $this->db->where('suggested_dag_area_k is not null');
                $this->db->where('suggested_dag_area_lc is not null');
                $this->db->where('suggested_dag_area_g is not null');

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(status_date) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(status_date) BETWEEN '$fromDate' AND '$toDate'";
                }

                $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                            WHERE dist_code=? AND UPPER(case_no) LIKE '%LDU%' AND 
                              UPPER(status)=? AND lm_note IS NOT NULL AND co_note IS NOT NULL

                              AND suggested_dag_area_b is not null AND suggested_dag_area_k is not null
                              AND suggested_dag_area_lc is not null AND suggested_dag_area_g is not null

                                $cirCode $betweenDates", array($this->dist_code, 'P'))->num_rows();
            }
        }

        else if($table == 'settlement_basic') {
            if($pendingOffice == 'LM' || $pendingOffice == 'SK' || $pendingOffice == 'DC' || $pendingOffice == 'ADC' || $pendingOffice == 'CO' || $pendingOffice == 'SDO')
            {
                $this->db->select('case_no, date_entry as submission_date');
                $this->db->where("case_no like '$like'");

                $this->db->where("pending_officer", $pendingOffice);

                $this->db->where('dist_code', $this->dist_code);
                if($selectCircle != '')
                {
                    $this->db->where('cir_code', $selectCircle);
                }
                if($fromDate != '' && $toDate != '')
                {
                    $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
                }
                $this->db->limit($length, $start);
                $fetchedData = $this->db->get($table)->result();

                // for getting total records
                if($selectCircle != '')
                {
                    $cirCode = " AND cir_code = '$selectCircle'";
                }
                if($fromDate != '' && $toDate != '')
                {
                    $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
                }

                $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                            WHERE case_no like '$like' AND pending_officer=? AND dist_code=? $cirCode $betweenDates", array($pendingOffice, $this->dist_code))->num_rows();
            }
        }

        $finalArr = [
            'fetchedData'   => $fetchedData,
            'total_records' => $total_records
        ];
        return json_encode($finalArr);
    }

    public function getDataByCircleSelect($selectCircle, $table, $fromDate, $toDate, $like, $length, $start) {

        $cirCode      = '';
        $betweenDates = '';

        if(($table == 'petition_basic') || ($table == 'field_mut_basic') || ($table == 'allotment_cert_basic') || ($table == 'settlement_basic'))
        {
            $this->db->select('case_no, date_entry as submission_date');
            $this->db->where("case_no LIKE '$like'");
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $fetchedData = $this->db->get($table)->result();

            // for getting total records
            if($selectCircle != '')
            {
                $cirCode = " AND cir_code = '$selectCircle'";
            }
            if($fromDate != '' && $toDate != '')
            {
                $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
            }
            $total_records = $this->db->query("SELECT case_no, date_entry as submission_date FROM $table
                          WHERE dist_code=? AND case_no LIKE '$like' $cirCode $betweenDates",
                array($this->dist_code))->num_rows();
        }

        else if($table == 'misc_case_basic'){
            $this->db->select('misc_case_no as case_no, submission_date');
            $this->db->where("misc_case_no LIKE '$like'");
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $fetchedData = $this->db->get($table)->result();

            // for getting total records
            if($selectCircle != '')
            {
                $cirCode = " AND cir_code = '$selectCircle'";
            }
            if($fromDate != '' && $toDate != '')
            {
                $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
            }
            $total_records = $this->db->query("SELECT misc_case_no as case_no, submission_date FROM $table
                          WHERE dist_code=? AND case_no LIKE '$like' $cirCode $betweenDates",
                array($this->dist_code))->num_rows();

        }

        else if(($table == 't_reclassification')){
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("case_no LIKE '$like'");
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $fetchedData = $this->db->get($table)->result();

            // for getting total records
            if($selectCircle != '')
            {
                $cirCode = " AND cir_code = '$selectCircle'";
            }
            if($fromDate != '' && $toDate != '')
            {
                $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
            }
            $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                          WHERE dist_code=? AND case_no LIKE '$like' $cirCode $betweenDates",
                array($this->dist_code))->num_rows();
        }

        else if(($table == 't_legacyupdation')){
            $this->db->select('case_no, status_date as submission_date');
            $this->db->where("case_no LIKE '$like'");
            $this->db->where('suggested_dag_area_b is not null');
            $this->db->where('suggested_dag_area_k is not null');
            $this->db->where('suggested_dag_area_lc is not null');
            $this->db->where('suggested_dag_area_g is not null');
            if($selectCircle != '')
            {
                $this->db->where('cir_code', $selectCircle);
            }
            if($fromDate != '' && $toDate != '')
            {
                $this->db->where("date(date_entry) BETWEEN '$fromDate' AND '$toDate'");
            }
            $this->db->where('dist_code', $this->dist_code);
            $this->db->limit($length, $start);
            $fetchedData = $this->db->get($table)->result();

            // for getting total records
            if($selectCircle != '')
            {
                $cirCode = " AND cir_code = '$selectCircle'";
            }
            if($fromDate != '' && $toDate != '')
            {
                $betweenDates = " AND date(date_entry) BETWEEN '$fromDate' AND '$toDate'";
            }
            $total_records = $this->db->query("SELECT case_no, status_date as submission_date FROM $table
                          WHERE dist_code=? AND case_no LIKE '$like' 

                          AND suggested_dag_area_b is not null AND suggested_dag_area_k is not null
                          AND suggested_dag_area_lc is not null AND suggested_dag_area_g is not null

                          $cirCode $betweenDates",
                array($this->dist_code))->num_rows();
        }




        $finalArr = [
            'fetchedData'   => $fetchedData,
            'total_records' => $total_records
        ];
        return json_encode($finalArr);
    }

    public function getSlicingElementFromAnArray($arr, $offset, $length){
        return array_slice($arr, $offset, $length);
    }

    public function getRejectedRemarkByCaseNo($case_no)
    {
        $remarks = $this->db->query("SELECT rs.remark FROM rejected_remark rm join reject_master rs on rm.reject_code::int = rs.reject_code 
                        WHERE rm.case_no=?", array($case_no));
        log_message('error','^^^^^^^^^^^^^^^'.$this->db->last_query());
        if($remarks->num_rows() <= 0){
            return null;
        }
        else
        {
            return $remarks->row()->remark; 
        }

    }


}