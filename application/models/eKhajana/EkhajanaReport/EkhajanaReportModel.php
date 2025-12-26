<?php
class EkhajanaReportModel extends CI_Model {

    //getting all the mouza list
    public function getMouzaList($dist_code,$subdiv_code,$cir_code){
        $mouza_codes_query = "select distinct mouza_pargona_code from current_doul_demand where dist_code=? and subdiv_code=? and cir_code=?";
        $query = $this->db->query($mouza_codes_query,array($dist_code,$subdiv_code,$cir_code));
        $mouza_codes = $query->result();
        $array = json_decode(json_encode($mouza_codes),true);
        $mouza_codes_arr = array_column($array, 'mouza_pargona_code');
        //return $mouza_codes_arr;
        $mouza_codes_str = "'" . implode ( "', '", $mouza_codes_arr ) . "'";
        //return $mouza_codes_str;
        //return $mouza_codes_str;
        $sql = "select locname_eng, loc_name, mouza_pargona_code from location where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code in (".$mouza_codes_str.") and lot_no =?";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00', '00'));        
        //return $this->db->last_query();
        return $query->result(); 
    }

     
    public function getJamaWasilTransactionData($posted_data, $offset){
        $sql = "select * from jama_wasil_transaction where status='offline'";
        //return $posted_data;
        $sql_common = "select * from jama_wasil_transaction offset $offset limit 10 where status=? and date(created_at) between ? and ? and ";         
        if($posted_data['ek_mouza_code'] != '00'){
            $sql = $sql_common." mouza_pargona_code=?";
            if($posted_data['village_uuid'] != '00'){
                $sql = $sql_common." mouza_pargona_code=? and village_uuid=?";
                if($posted_data['patta_type_code'] != '00'){
                    $sql = $sql_common." mouza_pargona_code=? and village_uuid=? and patta_type_code=?";
                    if($posted_data['patta_no'] != '00'){
                        $sql = $sql_common." mouza_pargona_code=? and village_uuid=? and patta_type_code=? and patta_no=?";
                    }
                }
            }
        }else{
            $sql = "select * from jama_wasil_transaction where status=? and date(created_at) between ? and ? offset $offset limit 10";
        }
        $query = $this->db->query($sql,array(JAMA_WASIL_STATUS_OFFLINE,$posted_data['start_date'],$posted_data['to_date'],$posted_data['ek_mouza_code'],$posted_data['village_uuid'],$posted_data['patta_type_code'],$posted_data['patta_no']));          
        if($query->num_rows != 0){
            return  $query->result();
        }else{
            return [];
        }  
    }

    //to count the no of cases
    public function getJamaWasilTransactionDataCount($posted_data){
        //return $posted_data;
        $sql_common = "select count (*) from jama_wasil_transaction where status=? and date(created_at) between ? and ? and ";         
        if($posted_data['ek_mouza_code'] != '00'){
            $sql = $sql_common." mouza_pargona_code=?";
            if($posted_data['village_uuid'] != '00'){
                $sql = $sql_common." mouza_pargona_code=? and village_uuid=?";
                if($posted_data['patta_type_code'] != '00'){
                    $sql = $sql_common." mouza_pargona_code=? and village_uuid=? and patta_type_code=?";
                    if($posted_data['patta_no'] != '00'){
                        $sql = $sql_common." mouza_pargona_code=? and village_uuid=? and patta_type_code=? and patta_no=?";
                    }
                }
            }
        }else{
            $sql = "select count (*) from jama_wasil_transaction where status=? and date(created_at) between ? and ? ";
        }
        $query = $this->db->query($sql,array(JAMA_WASIL_STATUS_OFFLINE,$posted_data['start_date'],$posted_data['to_date'],$posted_data['ek_mouza_code'],$posted_data['village_uuid'],$posted_data['patta_type_code'],$posted_data['patta_no']));
                                
        if($query->num_rows != 0){
            return $query->row()->count;
        }else{
            return 0;
        }  
    }


    //function to check the patta type
    public function getPattaInfo($patta_info){
        $query = $this->db->select('*')
                    ->where('type_code', $patta_info)
                    ->from('patta_code')
                    ->get(); 
            if($query->num_rows != 0){
                return  $query->result();
            }else{
                return [];
            }  
    }

    //function to get the status
    public function getStatusOfCases(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_API_FOR_DETAIL_CASE_STATUS,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array( 
          
            )));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $results = json_decode($response);
            return $results;
            // $status = array();
            // foreach($results as $row):
            //     $status[]=$row->ld_status;
            // endforeach;
            // $results['status']=$status;
            // return $results;
    }

    //getting amount received from the circle 
    public function getAmountReceivedForCircle($dist_code,$subdiv_code,$cir_code){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_GET_PAYMENT_AMOUNT_FOR_CIRCLE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            //var_dump($response);
            if(trim($response) == ''){
                return 0;
            }else{
                return $response;
            }                 
            
        }else{
            log_message("error", "#EKCORCRLD0012365, Curl Error(200) In Api ".EKHAJANA_GET_PAYMENT_AMOUNT_FOR_CIRCLE);
            return "NOT FOUND";
        }
       
    }

    public function getRevenueAmount($dist_code,$subdiv_code,$cir_code,$date)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_GET_PAYMENT_AMOUNT_DATE_WISE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'date' => $date,
                
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        // var_dump($response);
        // exit;
        if($httpcode == 200){
            
            if(trim($response) == ''){
                return 0;
            }else{
                return $response;
            }                 
            
        }else{
            log_message("error", "#EKCORCRLD0012365, Curl Error(200) In Api ".EKHAJANA_GET_PAYMENT_AMOUNT_DATE_WISE);
            return "NOT FOUND";
        } 
    }

    public function getUnpaidPattadarList($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select jw.application_no,jw.due_payment,eb.* from jama_wasil jw join ekhajana_basic eb on jw.ld_application_no = eb.ld_application_no
                                    where jw.dist_code=? and jw.subdiv_code=? and jw.cir_code=? and jw.pay_status=? ",array($dist_code,$subdiv_code,$cir_code,'UNPAID'));

        if($query->num_rows() == 0)
        {
            return "NOT-FOUND";
        }
        else{
            return $query->result();
        }
    }

    public function getAllRejectList($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select * from ekhajana_basic where status =? and dist_code=? and subdiv_code=? and cir_code=?",array('R',$dist_code,$subdiv_code,$cir_code));
        if($query->num_rows()==0)
        {
            return "NOT-FOUND";
        }else{
            return $query->result();
        }
       
    }

    public function getMonthlyKhajanaReport($dist_code,$subdiv_code,$cir_code,$date)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_MONTHLY_KHAJANA_AMOUNT_CIRCLE_WISE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code'     => $dist_code,
                'subdiv_code'   => $subdiv_code,
                'cir_code'      => $cir_code,
                'date'          => $date,
                
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            
            if(trim($response) == ''){
                return 0;
            }else{
                return $response;
            }                 
            
        }else{
            log_message("error", "#EKCORCRLD7821123, Curl Error(200) In Api ".EKHAJANA_MONTHLY_KHAJANA_AMOUNT_CIRCLE_WISE);
            return "NOT FOUND";
        } 
    }

    public function getYearlyKhajanaReport($dist_code,$subdiv_code,$cir_code,$year)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_YEARLY_KHAJANA_AMOUNT_CIRCLE_WISE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code'     => $dist_code,
                'subdiv_code'   => $subdiv_code,
                'cir_code'      => $cir_code,
                'year'          => $year,
                
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            
            if(trim($response) == ''){
                return 0;
            }else{
                return json_decode($response);
            }                 
            
        }else{
            log_message("error", "#EKCORCRLD7821123, Curl Error(200) In Api ".EKHAJANA_YEARLY_KHAJANA_AMOUNT_CIRCLE_WISE);
            return "NOT FOUND";
        } 
    }

    public function getEcfrDetails($dist_code,$subdiv_code,$cir_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_ECFR_DETAILS_MOUZA_WISE_CIRCLE_OFFICER,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_ECFR_DETAILS_MOUZA_WISE_CIRCLE_OFFICER);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    public function getUnRegisteredPattaList($dist_code,$subdiv_code,$cir_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_UNREGISTERED_PATTA_LIST_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_UNREGISTERED_PATTA_LIST_API);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    public function getMouzaWiseReconciliationDetails($dist_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_RECONCILIATION_REPORT_BREAKDOWN . '/' . $dist_code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_RECONCILIATION_REPORT_BREAKDOWN);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    public function getCircleWiseReconciliationDetails($dist_code,$subdiv_code,$cir_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_RECONCILIATION_REPORT_CIRCLE_WISE_BREAKDOWN . '/' . $dist_code. '/' . $subdiv_code. '/' . $cir_code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL006, Curl Error(200) In Api ".EKHAJANA_RECONCILIATION_REPORT_CIRCLE_WISE_BREAKDOWN);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    public function MouzaWiseCFRBooksData($dist_code)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_MOUZA_WISE_CFR_BOOKS_DETAILS . '/' . $dist_code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            return ['msg' =>$response_obj, 'flag'=>'SUCCESS'];
        }else{
            log_message("error", "#EKHADCDCDPEWICRLL0078, Curl Error(200) In Api ".EKHAJANA_MOUZA_WISE_CFR_BOOKS_DETAILS);
            return ['msg' =>"", 'flag'=>'ERROR'];
        }
    }

    public function getUnpaidPattadarListDcn($dist_code)
    {
        $query = $this->db->query("select jw.application_no,jw.due_payment,eb.* from jama_wasil jw join ekhajana_basic eb on jw.ld_application_no = eb.ld_application_no
                                    where jw.dist_code=? and jw.pay_status=? ",array($dist_code,'UNPAID'));

        if($query->num_rows() == 0)
        {
            return "NOT-FOUND";
        }
        else{
            return $query->result();
        }
    }
    
}



