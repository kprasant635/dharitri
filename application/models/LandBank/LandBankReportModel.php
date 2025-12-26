<?php

class LandBankReportModel extends CI_Model {

    public function getUniqueLandBankVillageIds(){
        
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $cir_code = $_SESSION['credentials']["cir_code"];
        $query = $this->db->select('village_uuid')
                    ->distinct('village_uuid')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->from('c_land_bank_details')
                    ->get(); 
        return $query->result();
    }

    public function getLandBankReportDataFromVillageUUID($uniqueVillageIds){

        //final array
        $reportDataCompArr = array();
        foreach($uniqueVillageIds as $villageUUID){
            //array 
            $reportDataArr = array();
            // location
            $query = $this->db->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->limit(1)
                        ->get(); 
            $row = $query->result(); 
            // district name 
            $district_name = $this->utilityclass->getDistrictName($row[0]->dist_code); 
            $reportDataArr['district_name'] = $district_name;
            // subdiv name
            $subdiv_name = $this->utilityclass->getSubDivName($row[0]->dist_code, $row[0]->subdiv_code);
            $reportDataArr['subdiv_name'] = $subdiv_name;
            // circle name
            $circle_name = $this->utilityclass->getCircleName($row[0]->dist_code, $row[0]->subdiv_code, 
            $row[0]->cir_code);
            $reportDataArr['circle_name'] = $circle_name;
            // Mouza Name
            $mouza_name = $this->utilityclass->getMouzaName($row[0]->dist_code, $row[0]->subdiv_code, 
            $row[0]->cir_code, $row[0]->mouza_pargona_code);
            $reportDataArr['mouza_name'] = $mouza_name;
            // lot no
            $lot_no = $this->utilityclass->getLotName($row[0]->dist_code, $row[0]->subdiv_code, 
            $row[0]->cir_code, $row[0]->mouza_pargona_code, $row[0]->lot_no);
            $reportDataArr['lot_name'] = $lot_no;
            // village_name
            $village_name = $this->utilityclass->getVillageName($row[0]->dist_code, $row[0]->subdiv_code, 
            $row[0]->cir_code, $row[0]->mouza_pargona_code, $row[0]->lot_no, $row[0]->vill_townprt_code);
            $reportDataArr['village_name'] = $village_name;
            // encroached area Bigha 
            $query = $this->db->select_sum('en_area_b')
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $total_bigha = $query->result(); 
            if($total_bigha[0]->en_area_b == NULL){
                $reportDataArr['total_bigha'] = 0;
            }else{
                $reportDataArr['total_bigha'] = $total_bigha[0]->en_area_b;
            }
            // encroached area Katha
            $query = $this->db->select_sum('en_area_k')
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $total_katha = $query->result(); 
            if($total_katha[0]->en_area_k == NULL){
                $reportDataArr['total_katha'] = 0;    
            }else{
                $reportDataArr['total_katha'] = $total_katha[0]->en_area_k;
            }            
            // encroached area Lessa
            $query = $this->db->select_sum('en_area_lc')
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $total_lessa = $query->result(); 
            if($total_lessa[0]->en_area_lc == NULL){
                $reportDataArr['total_lessa'] = 0;    
            }else{
                $reportDataArr['total_lessa'] = $total_lessa[0]->en_area_lc;
            }            
            //vgr-count
            $query = $this->db->where('nature_of_reservation', 1)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $vgr_count = count($query->result());
            $reportDataArr['vgr_count'] = $vgr_count;
            //pgr-count
            $query = $this->db->where('nature_of_reservation', 2)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $pgr_count = count($query->result());
            $reportDataArr['pgr_count'] = $pgr_count;
            //ROAD-SIDE-RESERVE-COUNT
            $query = $this->db->where('nature_of_reservation', 3)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $road_side_reserve_count = count($query->result());
            $reportDataArr['road_side_reserve_count'] = $road_side_reserve_count;
            //RIVER-SIDE-RESERVE-COUNT
            $query = $this->db->where('nature_of_reservation', 4)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $river_side_reserve_count = count($query->result());
            $reportDataArr['river_side_reserve_count'] = $river_side_reserve_count;
            //WETLAND/JALATAN-COUNT
            $query = $this->db->where('nature_of_reservation', 5)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $wetland_count = count($query->result());
            $reportDataArr['wetland_count'] = $wetland_count;
            //GOVT-KHAS-LAND-COUNT
            $query = $this->db->where('nature_of_reservation', 7)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $wetland_count = count($query->result());
            $reportDataArr['govt_khas_land_count'] = $wetland_count;
            //GOVT-CEILING-LAND-COUNT
            $query = $this->db->where('nature_of_reservation', 8)
                        ->where('village_uuid', $villageUUID->village_uuid)
                        ->from('c_land_bank_details')
                        ->get(); 
            $wetland_count = count($query->result());
            $reportDataArr['govt_ceiling_land_count'] = $wetland_count;
            array_push($reportDataCompArr,$reportDataArr);
            // Total No Of Encroacher


        }
        return $reportDataCompArr;

    }

    public function getLotWiseReport(){
        //getting all the mouza list
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $cir_code = $_SESSION['credentials']["cir_code"];
        $mouza_code_query = $this->db->query("select mouza_pargona_code from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' and lot_no='00'");
        $mouza_codes =  $mouza_code_query->result();
        $lot_details = array();
        foreach ($mouza_codes as $row){
            $lot_detail_query = $this->db->query("select loc_name, locname_eng, dist_code,subdiv_code,cir_code,mouza_pargona_code, lot_no
                from location where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
                mouza_pargona_code='$row->mouza_pargona_code'  and lot_no !='00' and vill_townprt_code='00000'");
            $lot_details_in_mouza =  $lot_detail_query->result();
            array_push($lot_details, $lot_details_in_mouza);
        }
        $total_govt_dag_in_circle = 0;
        $total_updated_by_lm_dag = 0;
        $total_approved_by_co_dag = 0;
        $lot_details = call_user_func_array("array_merge", $lot_details);
        $lot_wise_details = array();
        //return $lot_details;
        foreach($lot_details as $lot_details){
            //approved count
            $query = $this->db->select('count(*)')
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subdiv_code)
                        ->where('cir_code', $cir_code)
                        ->where('mouza_pargona_code', $lot_details->mouza_pargona_code)
                        ->where('lot_no', $lot_details->lot_no)
                        ->from('c_land_bank_details');
            $query = $this->db->get(); 
            $approved_count = $query->row()->count;
            //rejected count
            $query = $this->db->select('count(*)')
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subdiv_code)
                        ->where('cir_code', $cir_code)
                        ->where('mouza_pargona_code', $lot_details->mouza_pargona_code)
                        ->where('lot_no', $lot_details->lot_no)
                        ->where('status', LAND_BANK_STATUS_REVERT_BACK)
                        ->from('land_bank_details');
            $query = $this->db->get(); 
            $rejected_count = $query->row()->count;
            //pending count
            $query = $this->db->select('count(*)')
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subdiv_code)
                        ->where('cir_code', $cir_code)
                        ->where('mouza_pargona_code', $lot_details->mouza_pargona_code)
                        ->where('lot_no', $lot_details->lot_no)
                        ->where('status', LAND_BANK_STATUS_PENDING)
                        ->from('land_bank_details');
            $query = $this->db->get(); 
            $pending_with_co_count = $query->row()->count;
            //chitha govt dags
            $sqlVlb5 = "Select count(*) as c from chitha_basic where 
                    subdiv_code=? and cir_code=? and mouza_pargona_code=?
                    and lot_no=? and vill_townprt_code!=? and patta_type_code 
                    in (select type_code from patta_code where jamabandi='n') 
                    and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0 and 
                    (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                    in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                    location where nc_btad is null or TRIM(nc_btad) = '') ";         
            $countVlb5 = $this->db->query($sqlVlb5,array($subdiv_code,$cir_code,$lot_details->mouza_pargona_code,$lot_details->lot_no,'00000'))->row()->c;
            //*********************************/
            //circle wise count
            $total_govt_dag_in_circle =  $total_govt_dag_in_circle + $countVlb5;
            $total_updated_by_lm_dag = $total_updated_by_lm_dag + $approved_count + $rejected_count + $pending_with_co_count;
            $total_approved_by_co_dag = $total_approved_by_co_dag + $approved_count;
            //***********************************************************/
            // $total_dag_pending = $countVlb5-$approved_count;
            // if($total_dag_pending < 0){
            //     $total_dag_pending = 0;
            // }else{
            //     $total_dag_pending = $total_dag_pending;
            // }
            //***********************************************************/
            $sql2= "select count(*) as c from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? 
			    and mouza_pargona_code=? and lot_no=? and  patta_type_code in (select type_code from patta_code 
                where jamabandi='n') and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0
			    and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(dag_no)) 
                not in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
                trim(dag_no) from c_land_bank_details where dist_code=? and subdiv_code=? and cir_code=? 
			    and mouza_pargona_code=? and lot_no=?) and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code) in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code from location where nc_btad is null)";		
            $overallpending=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code,$lot_details->mouza_pargona_code,$lot_details->lot_no,
            $dist_code,$subdiv_code,$cir_code,$lot_details->mouza_pargona_code,$lot_details->lot_no));
            if($overallpending->num_rows()>0){
                $total_dag_pending=$overallpending->row()->c;
            }else{
                $total_dag_pending=0;
            }
            //*********************************/
            array_push($lot_wise_details, [
                "dist_code" => $dist_code, 
                "subdiv_code" => $subdiv_code,
                "cir_code" => $cir_code,
                "mouza_pargona_code" => $lot_details->mouza_pargona_code,
                "lot_no" => $lot_details->lot_no,
                "approved_count" => $approved_count,
                "rejected_count" => $rejected_count,
                "pending_with_co_count" => $pending_with_co_count,
                "total_govt_dags" => $countVlb5,
                "overall_pending" => $total_dag_pending,
            ]);
        }
        
        return [
            $lot_wise_details, 
            ['total_govt_dag_in_circle' => $total_govt_dag_in_circle],
            ['total_updated_by_lm_dag' => $total_updated_by_lm_dag],
            ['total_approved_by_co_dag' => $total_approved_by_co_dag],
        ];
    }

    public function getVillageWiseReport($mouza_code, $lot_no){
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $cir_code = $_SESSION['credentials']["cir_code"];
        $village_list_query = $this->db->query("select loc_name, locname_eng, dist_code,subdiv_code,cir_code,mouza_pargona_code, lot_no, 
        vill_townprt_code from location where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
        mouza_pargona_code='$mouza_code'  and lot_no ='$lot_no' and vill_townprt_code!='00000'");
        $village_list =  $village_list_query->result();
        $village_wise_details = array();
        foreach($village_list as $village_details){
            //approved count
            $query = $this->db->select('count(*)')
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subdiv_code)
                        ->where('cir_code', $cir_code)
                        ->where('mouza_pargona_code', $village_details->mouza_pargona_code)
                        ->where('lot_no', $village_details->lot_no)
                        ->where('vill_townprt_code', $village_details->vill_townprt_code)
                        ->from('c_land_bank_details');
            $query = $this->db->get(); 
            $approved_count = $query->row()->count;
            //rejected count
            $query = $this->db->select('count(*)')
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subdiv_code)
                        ->where('cir_code', $cir_code)
                        ->where('mouza_pargona_code', $village_details->mouza_pargona_code)
                        ->where('lot_no', $village_details->lot_no)
                        ->where('vill_townprt_code', $village_details->vill_townprt_code)
                        ->where('status', LAND_BANK_STATUS_REVERT_BACK)
                        ->from('land_bank_details');
            $query = $this->db->get(); 
            $rejected_count = $query->row()->count;
            //pending count
            $query = $this->db->select('count(*)')
                        ->where('dist_code', $dist_code)
                        ->where('subdiv_code', $subdiv_code)
                        ->where('cir_code', $cir_code)
                        ->where('mouza_pargona_code', $village_details->mouza_pargona_code)
                        ->where('lot_no', $village_details->lot_no)
                        ->where('vill_townprt_code', $village_details->vill_townprt_code)
                        ->where('status', LAND_BANK_STATUS_PENDING)
                        ->from('land_bank_details');
            $query = $this->db->get(); 
            $pending_with_co_count = $query->row()->count;
            //chitha govt dags
            $sqlVlb5 = "Select count(*) as c from chitha_basic where 
                    subdiv_code=? and cir_code=? and mouza_pargona_code=?
                    and lot_no=? and vill_townprt_code=? and patta_type_code 
                    in (select type_code from patta_code where jamabandi='n') 
                    and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0 and 
                    (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                    in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                    location where nc_btad is null or TRIM(nc_btad) = '') ";         
            $countVlb5 = $this->db->query($sqlVlb5,array($subdiv_code,$cir_code,$village_details->mouza_pargona_code,$village_details->lot_no,$village_details->vill_townprt_code))->row()->c;
            //************************************************************/
            // $total_dag_pending = $countVlb5-$approved_count;
            // if($total_dag_pending < 0){
            //     $total_dag_pending = 0;
            // }else{
            //     $total_dag_pending = $total_dag_pending;
            // }
            //************************************************************/
            $sql2= "select count(*) as c from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? 
			    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code in (select type_code from patta_code 
                where jamabandi='n') and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0
			    and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(dag_no)) 
                not in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
                trim(dag_no) from c_land_bank_details where dist_code=? and subdiv_code=? and cir_code=? 
			    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?) and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code) in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                vill_townprt_code from location where nc_btad is null)";		
            $overallpending=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code,
                            $village_details->mouza_pargona_code,$village_details->lot_no,
                            $village_details->vill_townprt_code, $dist_code,$subdiv_code,$cir_code,
                            $village_details->mouza_pargona_code,$village_details->lot_no,
                            $village_details->vill_townprt_code));
            if($overallpending->num_rows()>0){
                $total_dag_pending=$overallpending->row()->c;
            }else{
                $total_dag_pending=0;
            }
            //************************************************************/
            array_push($village_wise_details, [
                "dist_code" => $dist_code, 
                "subdiv_code" => $subdiv_code,
                "cir_code" => $cir_code,
                "mouza_pargona_code" => $village_details->mouza_pargona_code,
                "lot_no" => $village_details->lot_no,
                "vill_townprt_code" => $village_details->vill_townprt_code,
                "approved_count" => $approved_count,
                "rejected_count" => $rejected_count,
                "pending_with_co_count" => $pending_with_co_count,
                "total_govt_dags" => $countVlb5,
                "overall_pending" => $total_dag_pending,
            ]);
        }
        return $village_wise_details;
    }

    public function getCircleWiseReport(){
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code_query = $this->db->query("select subdiv_code from location where dist_code ='$dist_code'  
        and subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and lot_no='00' and vill_townprt_code='00000'");
        $subdiv_codes =  $subdiv_code_query->result_array();
        $location_array = array();
        foreach ($subdiv_codes as $subdiv_code){
            $subdiv_code = $subdiv_code['subdiv_code'];
            $circle_query = $this->db->query("select cir_code from location where dist_code ='$dist_code'  
            and subdiv_code='$subdiv_code' and cir_code!='00' and mouza_pargona_code='00' and lot_no='00' and vill_townprt_code='00000'");
            $circle_codes =  $circle_query->result();
            array_push($location_array, [
                'dist_code' => $dist_code, 
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_codes
            ]);
        }

        //return $location_array;
        $circle_wise_arr = array();
        $total_govt_dag_in_district = 0;
        $total_updated_by_lm_dag = 0;
        $total_approved_by_co_dag = 0;
        foreach ($location_array as $location){
            $dist_code = $location['dist_code'];
            $subdiv_code = $location['subdiv_code'];
            $cir_codes = $location['cir_code'];
            foreach ($cir_codes as $cir_code){
                $cir_code = $cir_code->cir_code;
                //approved count
                $query = $this->db->select('count(*)')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->from('c_land_bank_details');
                $query = $this->db->get(); 
                $approved_count = $query->row()->count;
                // //rejected count
                $query = $this->db->select('count(*)')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('status', LAND_BANK_STATUS_REVERT_BACK)
                            ->from('land_bank_details');
                $query = $this->db->get(); 
                $rejected_count = $query->row()->count;
                // //pending count
                $query = $this->db->select('count(*)')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('status', LAND_BANK_STATUS_PENDING)
                            ->from('land_bank_details');
                $query = $this->db->get(); 
                $pending_with_co_count = $query->row()->count;
                // //chitha govt dags
                $sqlVlb5 = "Select count(*) as c from chitha_basic where 
                        subdiv_code=? and cir_code=? and patta_type_code 
                        in (select type_code from patta_code where jamabandi='n') 
                        and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0 and 
                        (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                        in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                        location where nc_btad is null or TRIM(nc_btad) = '')";         
                $countVlb5 = $this->db->query($sqlVlb5,array($subdiv_code,$cir_code))->row()->c;
                // echo $this->db->last_query();
                // echo $countVlb5->num_rows();
                // die;
                //*********************************/
                //circle wise count
                $total_govt_dag_in_district =  $total_govt_dag_in_district + $countVlb5;
                $total_updated_by_lm_dag = $total_updated_by_lm_dag + $approved_count + $rejected_count + $pending_with_co_count;
                $total_approved_by_co_dag = $total_approved_by_co_dag + $approved_count;
                //************************************************************/
                // $total_dag_pending = $countVlb5-$approved_count;
                // if($total_dag_pending < 0){
                //     $total_dag_pending = 0;
                // }else{
                //     $total_dag_pending = $total_dag_pending;
                // }
                //************************************************************/
                $sql2= "select count(*) as c from chitha_basic where dist_code=? and subdiv_code=? and 
                    cir_code=? and patta_type_code in (select type_code from patta_code 
                    where jamabandi='n') and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0
                    and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(dag_no)) 
                    not in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
                    trim(dag_no) from c_land_bank_details where dist_code=? and subdiv_code=? and 
                    cir_code=?) and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                    vill_townprt_code) in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                    vill_townprt_code from location where nc_btad is null)";		
                $overallpending=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code,$dist_code,
                $subdiv_code,$cir_code));
                if($overallpending->num_rows()>0){
                    $total_dag_pending=$overallpending->row()->c;
                }else{
                    $total_dag_pending=0;
                }
                //************************************************************/
                //*********************************/
                array_push($circle_wise_arr, [
                    "dist_code" => $dist_code, 
                    "subdiv_code" => $subdiv_code,
                    "cir_code" => $cir_code,
                    "approved_count" => $approved_count,
                    "rejected_count" => $rejected_count,
                    "pending_with_co_count" => $pending_with_co_count,
                    "total_govt_dags" => $countVlb5,
                    "overall_pending" => $total_dag_pending,
                ]);
            }
        }
        return [
            $circle_wise_arr, 
            ['total_govt_dag_in_district' => $total_govt_dag_in_district],
            ['total_updated_by_lm_dag' => $total_updated_by_lm_dag],
            ['total_approved_by_co_dag' => $total_approved_by_co_dag],
        ];
    }

    public function getVillageWiseReportFromCircle($dist_code, $subdiv_code, $cir_code){
        
        //getting the mouza codes 
        $mouza_code_query = $this->db->query("select mouza_pargona_code from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' and lot_no='00'");
        $mouza_codes =  $mouza_code_query->result();
        //getting the lot nos from the mouza codes
        $lot_details = array();        
        foreach ($mouza_codes as $row){
            $lot_detail_query = $this->db->query("select lot_no from location where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
                mouza_pargona_code='$row->mouza_pargona_code'  and lot_no !='00' and vill_townprt_code='00000'");
            $lot_details_in_mouza =  $lot_detail_query->result();
            foreach ($lot_details_in_mouza as $lot_row){
                array_push($lot_details, [
                    'mouza_code' => $row->mouza_pargona_code,
                    'lot_no' => $lot_row->lot_no
                ]);
            }
        }
        // getting the village wise query
        $village_wise_details = array();   
        foreach ($lot_details as $row){
            $mouza_code = $row['mouza_code'];
            $lot_no = $row['lot_no'];
            $village_list_query = $this->db->query("select loc_name, locname_eng, dist_code,subdiv_code,cir_code,mouza_pargona_code, lot_no, 
            vill_townprt_code from location where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
            mouza_pargona_code='$mouza_code'  and lot_no ='$lot_no' and vill_townprt_code!='00000'");
            $village_list =  $village_list_query->result();
            
            foreach ($village_list as $village_details){
                //approved count
                $query = $this->db->select('count(*)')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('mouza_pargona_code', $village_details->mouza_pargona_code)
                            ->where('lot_no', $village_details->lot_no)
                            ->where('vill_townprt_code', $village_details->vill_townprt_code)
                            ->from('c_land_bank_details');
                $query = $this->db->get(); 
                $approved_count = $query->row()->count;
                //rejected count
                $query = $this->db->select('count(*)')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('mouza_pargona_code', $village_details->mouza_pargona_code)
                            ->where('lot_no', $village_details->lot_no)
                            ->where('vill_townprt_code', $village_details->vill_townprt_code)
                            ->where('status', LAND_BANK_STATUS_REVERT_BACK)
                            ->from('land_bank_details');
                $query = $this->db->get(); 
                $rejected_count = $query->row()->count;
                //pending count
                $query = $this->db->select('count(*)')
                            ->where('dist_code', $dist_code)
                            ->where('subdiv_code', $subdiv_code)
                            ->where('cir_code', $cir_code)
                            ->where('mouza_pargona_code', $village_details->mouza_pargona_code)
                            ->where('lot_no', $village_details->lot_no)
                            ->where('vill_townprt_code', $village_details->vill_townprt_code)
                            ->where('status', LAND_BANK_STATUS_PENDING)
                            ->from('land_bank_details');
                $query = $this->db->get(); 
                $pending_with_co_count = $query->row()->count;
                //chitha govt dags
                $sqlVlb5 = "Select count(*) as c from chitha_basic where 
                        subdiv_code=? and cir_code=? and mouza_pargona_code=?
                        and lot_no=? and vill_townprt_code=? and patta_type_code 
                        in (select type_code from patta_code where jamabandi='n') 
                        and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0 and 
                        (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                        in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                        location where nc_btad is null or TRIM(nc_btad) = '')";         
                $countVlb5 = $this->db->query($sqlVlb5,array($subdiv_code,$cir_code,$village_details->mouza_pargona_code,$village_details->lot_no,$village_details->vill_townprt_code))->row()->c;

                // $total_dag_pending = $countVlb5-$approved_count;
                // if($total_dag_pending < 0){
                //     $total_dag_pending = 0;
                // }else{
                //     $total_dag_pending = $total_dag_pending;
                // }

                $sql2= "select count(*) as c from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? 
                    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code in (select type_code from patta_code 
                    where jamabandi='n') and (dag_area_b*100+dag_area_k*20+dag_area_lc::int) > 0
                    and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(dag_no)) 
                    not in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
                    trim(dag_no) from c_land_bank_details where dist_code=? and subdiv_code=? and cir_code=? 
                    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?) and (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                    vill_townprt_code) in (select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                    vill_townprt_code from location where nc_btad is null)";		
                $overallpending=$this->db->query($sql2,array($dist_code,$subdiv_code,$cir_code,
                                $village_details->mouza_pargona_code,$village_details->lot_no,
                                $village_details->vill_townprt_code, $dist_code,$subdiv_code,$cir_code,
                                $village_details->mouza_pargona_code,$village_details->lot_no,
                                $village_details->vill_townprt_code));
                if($overallpending->num_rows()>0){
                    $total_dag_pending=$overallpending->row()->c;
                }else{
                    $total_dag_pending=0;
                }
                //************************************************************/

                array_push($village_wise_details, [
                    "dist_code" => $dist_code, 
                    "subdiv_code" => $subdiv_code,
                    "cir_code" => $cir_code,
                    "mouza_pargona_code" => $village_details->mouza_pargona_code,
                    "lot_no" => $village_details->lot_no,
                    "vill_townprt_code" => $village_details->vill_townprt_code,
                    "approved_count" => $approved_count,
                    "rejected_count" => $rejected_count,
                    "pending_with_co_count" => $pending_with_co_count,
                    "total_govt_dags" => $countVlb5,
                    "overall_pending" => $total_dag_pending,
                ]);

            }
        }
        return $village_wise_details;
    }

    public function getLotWiseVgrPgrReport(){
        //getting all the mouza list
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $cir_code = $_SESSION['credentials']["cir_code"];
        $mouza_code_query = $this->db->query("select mouza_pargona_code from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' and lot_no='00'");
        $mouza_codes =  $mouza_code_query->result();        
        $lot_details = array();
        foreach ($mouza_codes as $row){
            $lot_detail_query = $this->db->query("select loc_name, locname_eng, dist_code,subdiv_code,cir_code,mouza_pargona_code, lot_no
                from location where dist_code ='$dist_code'  and  subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
                mouza_pargona_code='$row->mouza_pargona_code'  and lot_no !='00' and vill_townprt_code='00000'");
            $lot_details_in_mouza =  $lot_detail_query->result();
            array_push($lot_details, $lot_details_in_mouza);
        }
        $lot_details = call_user_func_array("array_merge", $lot_details);
        $lot_wise_details = array();
        $total_vgr_dags_with_encroacher_in_circle = 0;
        $total_pgr_dags_with_encroacher_in_circle = 0;
        //return $lot_details;
        foreach($lot_details as $lot_details){
            //*************************************************/
            //total vgr dags with encroacher 
            $sql = "select count(*) from 
            (select distinct (lbd.id) from c_land_bank_details lbd 
            join c_land_bank_encroacher_details lbed on lbd.id = lbed.c_land_bank_details_id 
            join location l on lbd.subdiv_code=l.subdiv_code and lbd.cir_code=l.cir_code and
            lbd.mouza_pargona_code=l.mouza_pargona_code and lbd.lot_no = l.lot_no and 
            lbd.vill_townprt_code=l.vill_townprt_code  
            where lbd.nature_of_reservation=1 and lbd.subdiv_code=? 
            and lbd.cir_code=? and lbd.mouza_pargona_code=? and lbd.lot_no=? and 
            l.nc_btad is null) 
            as count";
            $query = $this->db->query($sql,array($subdiv_code,$cir_code,
            $lot_details->mouza_pargona_code,$lot_details->lot_no));
            $totalVgrDagsCountWithEncoracher= $query->row()->count; 
            $total_vgr_dags_with_encroacher_in_circle =  $total_vgr_dags_with_encroacher_in_circle + $totalVgrDagsCountWithEncoracher;
            //total vgr dags updated by lm 
            $sql = "select count(*) from 
            (select distinct (lbd.id) from land_bank_details lbd 
            join land_bank_encroacher_details lbed on lbd.id = lbed.land_bank_details_id 
            join location l on lbd.subdiv_code=l.subdiv_code and lbd.cir_code=l.cir_code and
            lbd.mouza_pargona_code=l.mouza_pargona_code and lbd.lot_no = l.lot_no and 
            lbd.vill_townprt_code=l.vill_townprt_code  
            where lbd.status ='P' and lbed.type_of_encroacher is not null and 
            lbd.nature_of_reservation=1 and lbd.subdiv_code=? 
            and lbd.cir_code=? and lbd.mouza_pargona_code=? and lbd.lot_no=? and 
            l.nc_btad is null) 
            as count";
            $query = $this->db->query($sql,array($subdiv_code,$cir_code,
            $lot_details->mouza_pargona_code,$lot_details->lot_no));
            $totalVgrDagsUpdatedByLm= $query->row()->count; 
            //total vgr dags pending
            $sql = "select count(*) from 
            (select distinct (lbd.id) from c_land_bank_details lbd 
            join c_land_bank_encroacher_details lbed on lbd.id = lbed.c_land_bank_details_id 
            join location l on lbd.subdiv_code=l.subdiv_code and lbd.cir_code=l.cir_code and
            lbd.mouza_pargona_code=l.mouza_pargona_code and lbd.lot_no = l.lot_no and 
            lbd.vill_townprt_code=l.vill_townprt_code  
            where lbd.nature_of_reservation=1 and lbed.type_of_encroacher is null and 
            lbd.subdiv_code=? and lbd.cir_code=? and lbd.mouza_pargona_code=? and lbd.lot_no=? and 
            l.nc_btad is null) 
            as count";
            $query = $this->db->query($sql,array($subdiv_code,$cir_code,
            $lot_details->mouza_pargona_code,$lot_details->lot_no));
            $totalVgrDagsPending= $query->row()->count; 
            //*************************************************/
            // total pgr dag's with encroacher 
            $sql = "select count(*) from 
            (select distinct (lbd.id) from c_land_bank_details lbd 
            join c_land_bank_encroacher_details lbed on lbd.id = lbed.c_land_bank_details_id 
            join location l on lbd.subdiv_code=l.subdiv_code and lbd.cir_code=l.cir_code and
            lbd.mouza_pargona_code=l.mouza_pargona_code and lbd.lot_no = l.lot_no and 
            lbd.vill_townprt_code=l.vill_townprt_code  
            where lbd.nature_of_reservation=2 and lbd.subdiv_code=? 
            and lbd.cir_code=? and lbd.mouza_pargona_code=? and lbd.lot_no=? and 
            l.nc_btad is null) 
            as count";
            $query = $this->db->query($sql,array($subdiv_code,$cir_code,
            $lot_details->mouza_pargona_code,$lot_details->lot_no));
            $totalPgrDagsCountWithEncoracher= $query->row()->count; 
            $total_pgr_dags_with_encroacher_in_circle = $total_pgr_dags_with_encroacher_in_circle+$totalPgrDagsCountWithEncoracher;
            //total pgr dags updated by lm 
            $sql = "select count(*) from 
            (select distinct (lbd.id) from land_bank_details lbd 
            join land_bank_encroacher_details lbed on lbd.id = lbed.land_bank_details_id 
            join location l on lbd.subdiv_code=l.subdiv_code and lbd.cir_code=l.cir_code and
            lbd.mouza_pargona_code=l.mouza_pargona_code and lbd.lot_no = l.lot_no and 
            lbd.vill_townprt_code=l.vill_townprt_code  
            where lbd.status ='P' and lbed.type_of_encroacher is not null and 
            lbd.nature_of_reservation=2 and lbd.subdiv_code=? 
            and lbd.cir_code=? and lbd.mouza_pargona_code=? and lbd.lot_no=? and 
            l.nc_btad is null) 
            as count";
            $query = $this->db->query($sql,array($subdiv_code,$cir_code,
            $lot_details->mouza_pargona_code,$lot_details->lot_no));
            $totalPgrDagsUpdatedByLm= $query->row()->count; 
            //total pgr dags pending
            $sql = "select count(*) from 
            (select distinct (lbd.id) from c_land_bank_details lbd 
            join c_land_bank_encroacher_details lbed on lbd.id = lbed.c_land_bank_details_id 
            join location l on lbd.subdiv_code=l.subdiv_code and lbd.cir_code=l.cir_code and
            lbd.mouza_pargona_code=l.mouza_pargona_code and lbd.lot_no = l.lot_no and 
            lbd.vill_townprt_code=l.vill_townprt_code  
            where lbd.nature_of_reservation=2 and lbed.type_of_encroacher is null and 
            lbd.subdiv_code=? and lbd.cir_code=? and lbd.mouza_pargona_code=? and lbd.lot_no=? and 
            l.nc_btad is null) 
            as count";
            $query = $this->db->query($sql,array($subdiv_code,$cir_code,
            $lot_details->mouza_pargona_code,$lot_details->lot_no));
            $totalPgrDagsPending= $query->row()->count; 
            //*********************************/
            array_push($lot_wise_details, [
                "dist_code" => $dist_code, 
                "subdiv_code" => $subdiv_code,
                "cir_code" => $cir_code,
                "mouza_pargona_code" => $lot_details->mouza_pargona_code,
                "lot_no" => $lot_details->lot_no,
                "totalVgrDagsCountWithEncoracher" => $totalVgrDagsCountWithEncoracher,
                "totalVgrDagsUpdatedByLm" => $totalVgrDagsUpdatedByLm,
                "totalVgrDagsPending" => $totalVgrDagsPending,
                "totalPgrDagsCountWithEncoracher" => $totalPgrDagsCountWithEncoracher,
                "totalPgrDagsUpdatedByLm" => $totalPgrDagsUpdatedByLm,
                "totalPgrDagsPending" =>$totalPgrDagsPending
            ]);
        }
        return [
            "lot_wise_details" => $lot_wise_details,
            "total_vgr_dags_with_encroacher_in_circle" => $total_vgr_dags_with_encroacher_in_circle,
            "total_pgr_dags_with_encroacher_in_circle" => $total_pgr_dags_with_encroacher_in_circle
        ];
    }
    function getAllReport()
    {
        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $sql="Select (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code='00') distName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') circleName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code) villName,
                t.dag_no,sum(t.no_of_encroacher) no_of_encroacher,
                            COALESCE(sum(t.en_area_b*6400+t.en_area_k*320+t.en_area_lc*20),0) area_in_enc_gonda,
                            (Select COALESCE(sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20),0) from chitha_basic where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code and dag_no=t.dag_no) as area_in_chitha_gonda,
                            CASE
                              WHEN (t.nature_of_reservation = '1') THEN 'VGR'
                              WHEN (t.nature_of_reservation = '2') THEN 'PGR'
                              WHEN (t.nature_of_reservation = '3') THEN 'ROAD-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '4') THEN 'RIVER-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '7') THEN 'GOVT-KHAS-LAND'
                              WHEN (t.nature_of_reservation = '8') THEN 'GOVT-CEILING-LAND'
                              WHEN (t.nature_of_reservation = '6') THEN 'NONE'
                             END AS LandType
                              from c_land_bank_details t
                              group by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation,t.dag_no
                              order by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation 
                ";
        }else{
            $sql="Select (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code='00') distName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') circleName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code) villName,
                t.dag_no,sum(t.no_of_encroacher) no_of_encroacher,
                            COALESCE(sum(t.en_area_b*100+t.en_area_k*20+t.en_area_lc),0) area_in_Lessa,
                            (Select COALESCE(sum(dag_area_b*100+dag_area_k*20+dag_area_lc),0) from chitha_basic where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code and dag_no=t.dag_no) as area_in_chitha_lessa,
                            CASE
                              WHEN (t.nature_of_reservation = '1') THEN 'VGR'
                              WHEN (t.nature_of_reservation = '2') THEN 'PGR'
                              WHEN (t.nature_of_reservation = '3') THEN 'ROAD-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '4') THEN 'RIVER-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '7') THEN 'GOVT-KHAS-LAND'
                              WHEN (t.nature_of_reservation = '8') THEN 'GOVT-CEILING-LAND'
                              WHEN (t.nature_of_reservation = '6') THEN 'NONE'
                             END AS LandType
                              from c_land_bank_details t
                              group by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation,t.dag_no
                              order by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation 
                ";
        }
        $data=$this->db->query($sql)->result_array();
        log_message('error',"VLBDC#####".$this->db->last_query());
        return $data;

    }
    function VillageNoVlbEntry()
    {
        $sql="select  (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code='00') distName,
            (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') circleName,
            (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code) villName from location t where t.uuid not in (
        select village_uuid from c_land_bank_details where whether_encroached='Y' 
        group by village_uuid 
        ) and t.vill_townprt_code<>'00000' and t.nc_btad is null
            ";
        $data=$this->db->query($sql)->result_array();
        log_message('error',"VLBDC#####".$this->db->last_query());
        return $data;
    }
    function getPenAllReport()
    {
        $sql="Select (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code='00') distName,
            (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') circleName,
            (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code) villName,
            t.dag_no,sum(t.no_of_encroacher) no_of_encroacher,
                        COALESCE(sum(t.en_area_b*100+t.en_area_k*20+t.en_area_lc),0) area_in_Lessa,
                        CASE
                          WHEN (t.nature_of_reservation = '1') THEN 'VGR'
                          WHEN (t.nature_of_reservation = '2') THEN 'PGR'
                          WHEN (t.nature_of_reservation = '3') THEN 'ROAD-SIDE-RESERVE'
                          WHEN (t.nature_of_reservation = '4') THEN 'RIVER-SIDE-RESERVE'
                          WHEN (t.nature_of_reservation = '7') THEN 'GOVT-KHAS-LAND'
                          WHEN (t.nature_of_reservation = '8') THEN 'GOVT-CEILING-LAND'
                          WHEN (t.nature_of_reservation = '6') THEN 'NONE'
                         END AS LandType
                          from land_bank_details t
                          where t.status='C'
                          group by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation,t.dag_no
                          order by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation 
            ";
        $data=$this->db->query($sql)->result_array();
        log_message('error',"VLBDC#####".$this->db->last_query());
        return $data;
    }
    function getCircleReport()
    {
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $sql="Select (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code='00') distName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') circleName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code) villName,
                t.dag_no,sum(t.no_of_encroacher) no_of_encroacher,
                            COALESCE(sum(t.en_area_b*6400+t.en_area_k*320+t.en_area_lc*20),0) area_in_enc_gonda,
                            (Select COALESCE(sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20),0) from chitha_basic where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code and dag_no=t.dag_no) as area_in_chitha_gonda,
                            CASE
                              WHEN (t.nature_of_reservation = '1') THEN 'VGR'
                              WHEN (t.nature_of_reservation = '2') THEN 'PGR'
                              WHEN (t.nature_of_reservation = '3') THEN 'ROAD-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '4') THEN 'RIVER-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '7') THEN 'GOVT-KHAS-LAND'
                              WHEN (t.nature_of_reservation = '8') THEN 'GOVT-CEILING-LAND'
                              WHEN (t.nature_of_reservation = '6') THEN 'NONE'
                             END AS LandType
                            from c_land_bank_details t
                              where t.dist_code='$dist_code' and t.subdiv_code='$subdiv_code' and t.cir_code='$cir_code'
                              group by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation,t.dag_no
                              order by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation 
                ";
        }else{
            $sql="Select (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code='00') distName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') circleName,
                (select locname_eng as name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code) villName,
                t.dag_no,sum(t.no_of_encroacher) no_of_encroacher,
                            COALESCE(sum(t.en_area_b*100+t.en_area_k*20+t.en_area_lc),0) area_in_Lessa,
                            (Select COALESCE(sum(dag_area_b*100+dag_area_k*20+dag_area_lc),0) from chitha_basic where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code=t.vill_townprt_code and dag_no=t.dag_no) as area_in_chitha,
                            CASE
                              WHEN (t.nature_of_reservation = '1') THEN 'VGR'
                              WHEN (t.nature_of_reservation = '2') THEN 'PGR'
                              WHEN (t.nature_of_reservation = '3') THEN 'ROAD-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '4') THEN 'RIVER-SIDE-RESERVE'
                              WHEN (t.nature_of_reservation = '7') THEN 'GOVT-KHAS-LAND'
                              WHEN (t.nature_of_reservation = '8') THEN 'GOVT-CEILING-LAND'
                              WHEN (t.nature_of_reservation = '6') THEN 'NONE'
                             END AS LandType
                            from c_land_bank_details t
                              where t.dist_code='$dist_code' and t.subdiv_code='$subdiv_code' and t.cir_code='$cir_code'
                              group by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation,t.dag_no
                              order by t.dist_code,t.subdiv_code,t.cir_code,t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.nature_of_reservation 
                ";
        }
        $data=$this->db->query($sql)->result_array();
        log_message('error',"VLBDC#####".$this->db->last_query());
        return $data;
    }
}
