
 <!--#PLB0004:Improvement in MIS report-->

<?php
class Misreport extends CI_Model {

    function getPosts($dist_code, $subdiv_code, $circle_code, $mouza_code) {
		$db=  $this->session->userdata('db');
        $patta = $this->db->query("SELECT count(TRIM(patta_no)) as patta from    chitha_basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' and TRIM(patta_no) not in ('0','','.') and patta_type_code not in ('0209' , '0211')  ");

        $patta = $patta->result();
       
        $dag = $this->db->query("SELECT count(dag_no) as dag from    Chitha_Basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' ");
        $dag = $dag->result();
        $all_data = $this->db->query("SELECT sum(dag_area_b) as bigha,sum(dag_area_k) as ktha,sum(dag_area_lc) as lessa,sum(dag_revenue) as revenue,SUM(dag_local_tax) as localTax from    Chitha_Basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' ");
		
        $all_data = $all_data->result();
        $main = array_merge($dag, $patta, $all_data);
        return $main;
    }

    /*    end function
     * start Crop wise land area
     */

    function getCropLand($dist_code, $subdiv_code, $circle_code, $mouza_code, $start_year) {
		$db=  $this->session->userdata('db');
        $tot=0;
        $cropdata = $this->db->query("SELECT * from    crop_code ");
        $cropdata = $cropdata->result();
        foreach ($cropdata as $crop) {
            
            $sql="Select * from    crop_category_code";
            $result=$this->db->query($sql)->result();
            foreach($result as $r){
             $innerquery = "Select sum(crop_land_area_b) as crop_land_area_b,sum(crop_land_area_k) as crop_land_area_k,sum(crop_land_area_lc) as crop_land_area_lc  from    Chitha_MCrop WHERE dist_code='$dist_code' AND Subdiv_code='$subdiv_code' "
                    . "AND Cir_code='$circle_code' AND Mouza_Pargona_code='$mouza_code' and Crop_code='$crop->crop_code' and yearno='$start_year' and crop_categ_code='$r->crop_categ_code' ";
            $innerdata = $this->db->query($innerquery)->result();
           // echo "<br>";
            //var_dump($innerdata);
            foreach ($innerdata as $data) {
                $tot=($data->crop_land_area_b*100)+($data->crop_land_area_k*20)+($data->crop_land_area_lc);
                $main[$crop->crop_name][] = array
                    (
                    'bigha' => $data->crop_land_area_b,
                    'katha' => $data->crop_land_area_k,
                    'lessa' => $data->crop_land_area_lc,
                    'total'=>$tot,
                    'category'=>$r->crop_categ_desc 
                );
                $tot=0;
            }
            
            }
        }

        return $main;
    }

    /*    end function
     * Revenue of Direct paying tea estate
     */

    function RevenueTea($dist_code, $subdiv_code, $circle_code, $mouza_code) {
		$db=  $this->session->userdata('db');
        $cropdata = $this->db->query("SELECT * from    Chitha_Basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' and land_class_code = '0116' AND DP_flag_yn='y' ");
        $cropdata = $cropdata->result();
        $main = array();
        foreach ($cropdata as $crop) {
            $innerquery = "SELECT * from    Chitha_Pattadar WHERE dist_code='$dist_code' AND Subdiv_code='$subdiv_code' AND Cir_code='$circle_code' AND Mouza_Pargona_code='$mouza_code' AND TRIM(patta_no)=TRIM('$crop->patta_no') AND Patta_type_code<>'0209' ";
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data) {

                $main[] = array
                    (
                    'dag_no' => $crop->dag_no,
                    'patta_no' => trim($crop->patta_no),
                    'bigha' => $crop->dag_area_b,
                    'katha' => $crop->dag_area_k,
                    'lessa' => $crop->dag_area_lc,
                    'revenue' => $crop->dag_revenue,
                    'pattadar_name' => $data->pdar_name
                );
            }
        }
        //echo sizeof($main);

        return $main;
    }

    /*    end function
     * start Cityzen centric report Monthly and Yearly
     */

    function getMonthlyCityzenRpt($dist_code, $subdiv_code, $circle_code, $select_year, $month_name) {
		$db=  $this->session->userdata('db');
        $cdata = $this->db->query("Select * from    Cert_Type order by Cert_Code");
        $cdata = $cdata->result();
        foreach ($cdata as $c) {
            $innerquery = "Select coalesce(SUM(fee_amount),0) AS fee_amount ,COUNT(Cert_no),count(Cert_no) as no_of_caeses  from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no WHERE dist_code='$dist_code' AND Subdiv_code='$subdiv_code' AND Cir_code='$circle_code' AND Year_no='$select_year' and date_part('month',apply_date)='$month_name' and Cert_type='$c->cert_code'  and  ca.application_ref_no is null and ba.dharitree is null ";
            //echo $innerquery;
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data) {
                $main[] = array
                    (
                    'cert_name' => $c->cert_type,
                    'cases' => $data->no_of_caeses,
                    'fee' => $c->cert_fees,
                    't_amt' => $data->fee_amount
                );
            }
        }
        return $main;
    }

    /*
      Yearly Report
     */

    function getYearlyCityzenRpt($dist_code, $subdiv_code, $circle_code, $select_year) {
		$db=  $this->session->userdata('db');
        $cdata = $this->db->query("Select * from    Cert_Type order by Cert_Code");
        $cdata = $cdata->result();
        $main = array();
        foreach ($cdata as $c) {
            $innerquery = "Select coalesce(SUM(fee_amount),0) AS fee_amount ,COUNT(Cert_no),count(Cert_no) as no_of_caeses  from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no  WHERE dist_code='$dist_code' AND Subdiv_code='$subdiv_code' AND Cir_code='$circle_code' AND Year_no='$select_year' and Cert_type='$c->cert_code' and  ca.application_ref_no is null and ba.dharitree is null ";
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data) {
                $main[] = array
                    (
                    'cert_name' => $c->cert_type,
                    'cases' => $data->no_of_caeses,
                    'fee' => $c->cert_fees,
                    't_amt' => $data->fee_amount
                );
            }
        }
        return $main;
    }

    /*
      end function
      Start Nisfi Kheraj
     */

    function RevenueNisFi($dist_code, $subdiv_code, $circle_code, $mouza_code) {
		$db=  $this->session->userdata('db');
        $cropdata = $this->db->query("SELECT count(TRIM(patta_no)) as patta_no from    Chitha_Basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' and patta_type_code='0208' ");

        $cropdata = $cropdata->result();
        $main = array();
        foreach ($cropdata as $crop) {
            $innerquery = "SELECT * from    Chitha_Basic WHERE dist_code='$dist_code' AND Subdiv_code='$subdiv_code' AND Cir_code='$circle_code' AND Mouza_Pargona_code='$mouza_code' AND patta_type_code='0208' ";
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data) {
                $main[] = array
                    (
                    'dag_no' => $data->dag_no,
                    'patta_no' => trim($crop->patta_no),
                    'bigha' => $data->dag_area_b,
                    'katha' => $data->dag_area_k,
                    'lessa' => $data->dag_area_lc,
                    'revenue' => $data->dag_revenue
                );
            }
        }
        return $main;
    }

    /*
     * End Function
     * Start La Kheraj
     */

    function RevenueLaKheraj($dist_code, $subdiv_code, $circle_code, $mouza_code) {
		$db=  $this->session->userdata('db');
        $cropdata = $this->db->query("SELECT count(TRIM(patta_no)) as patta_no from    Chitha_Basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' and patta_type_code='0205' ");

        $cropdata = $cropdata->result();
        $main = array();
        foreach ($cropdata as $crop) {
            $innerquery = "SELECT * from    Chitha_Basic WHERE dist_code='$dist_code' AND Subdiv_code='$subdiv_code' AND Cir_code='$circle_code' AND Mouza_Pargona_code='$mouza_code' AND Patta_type_code='0205' ";
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data) {
                $main[] = array
                    (
                    'dag_no' => $data->dag_no,
                    'patta_no' => trim($crop->patta_no),
                    'bigha' => $data->dag_area_b,
                    'katha' => $data->dag_area_k,
                    'lessa' => $data->dag_area_lc,
                    'revenue' => $data->dag_revenue
                );
            }
        }
        return $main;
    }
    /*
     *  Finshed ;--------Start For Doul Report------------
     */
    public function DoulReport($dist_code, $subdiv_code, $circle_code,$mouza_code,$lot_no,$patta_type,$previousYear,$currentYear)
    {
		
		$db=  $this->session->userdata('db');
       $cropdata = $this->db->query("SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
               . "and mouza_pargona_code='$mouza_code'and lot_no='$lot_no' and Vill_townprt_code <> '00000' ");
        $cropdata = $cropdata->result();
        $q=$this->db->query("Select patta_type as patta from    patta_code where type_code='$patta_type' ");
        $q=$q->result();
        $main = array();
        foreach($q as $q)
        {
        foreach ($cropdata as $crop) {
             $date=$previousYear."-06-30";
            $curdate1=$previousYear.'-07-01';
            $curdate2=$currentYear.'-06-30';
//           $innerquery = "select sum(Dag_area_B) as bigha,sum(Dag_area_K) as ktha,sum(Dag_area_LC) as lessa,sum(round(Dag_revenue, 2)) as total,sum(round(dag_local_tax, 2)) as total_lc,count(patta_no) as total_patta from    Chitha_Basic "
//                    . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code'and lot_no='$lot_no' and Vill_townprt_code='$crop->vill_townprt_code' and Patta_type_code='$patta_type' and  Date_entry >=   '$curdate1' and Date_entry <=   '$curdate2' ";
//           echo $innerquery;
//           
//           exit;
            $innerquery = "select sum(Dag_area_B) as bigha,sum(Dag_area_K) as ktha,sum(Dag_area_LC) as lessa,sum(round(Dag_revenue, 2)) as total,sum(round(dag_local_tax, 2)) as total_lc,count(patta_no) as total_patta from    Chitha_Basic "
                    . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code'and lot_no='$lot_no' and Vill_townprt_code='$crop->vill_townprt_code' and Patta_type_code='$patta_type' and Date_entry <=   '$date' ";
           //echo $innerquery;
           $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data)
                {
                $main[] = array
                    (
                    'bigha' => $data->bigha,
                    'ktha'=> $data->ktha,
                    'lessa' => $data->lessa,
                    'total' => $data->total,
                    'village' =>$crop->loc_name,
                    'patta' =>$q->patta,
                    'patta_type'=>$patta_type,
                    'local_tax' =>$data->total_lc,
                    'total_patta' =>$data->total_patta,
                    'dist_code'=>$dist_code,
                    'subdiv_code'=>$subdiv_code,
                    'cir_code'=>$circle_code,
                    'mouza_pargona_code'=>$mouza_code,
                    'lot_no'=>$lot_no,
                    'vill_townprt_code'=>$crop->vill_townprt_code,
                    'preYear'=>$curdate1,
                    'curYear'=>$curdate2
                );
            }
            
            
            
            
            
            
            
            
            
        }
        }
        //print_r($main);
        return $main; 
    }
    ///////////Direct Paying Estate ///////////
     public function DoulReportDPE($dist_code, $subdiv_code, $circle_code,$mouza_code,$lot_no,$year)
    {
		
		$db=  $this->session->userdata('db');
       $cropdata = $this->db->query("SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code'and lot_no='$lot_no' and Vill_townprt_code <> '00000' ");
        //print_r("SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code'and lot_no='$lot_no' and Vill_townprt_code <> '00000'");
        $cropdata = $cropdata->result();
        
        //print_r($q);
        $main = array();
        
        foreach ($cropdata as $crop) {
            
            $innerquery = "select sum(Dag_area_B) as bigha,sum(Dag_area_K) as ktha,sum(Dag_area_LC) as lessa,sum(round(Dag_revenue, 2)) as total,sum(round(dag_local_tax, 2)) as total_lc,count(patta_no) as total_patta from    Chitha_Basic where dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code'and lot_no='$lot_no' and Vill_townprt_code='$crop->vill_townprt_code' "
                    . "and ( Patta_type_code='0203' or Patta_type_code='0206' or Patta_type_code='0207' or  Patta_type_code='0210' or  Patta_type_code='0216')"
                    . "and date_part('year',Date_entry) <=   '$year' ";
           // echo $innerquery;
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data)
                {
                $main[] = array
                    (
                    'bigha' => $data->bigha,
                    'ktha'=> $data->ktha,
                    'lessa' => $data->lessa,
                    'total' => $data->total,
                    'village' =>$crop->loc_name,
                    'local_tax' =>$data->total_lc,
                    'total_patta' =>$data->total_patta
                );
           
        }
        }
        //print_r($main);
        return $main; 
    }
    
    
    /*
     * End Function--------------
     * Start New Function For NLR Grant
     */
    
    function LandAreaNLR($dist_code, $subdiv_code, $circle_code, $mouza_code) {
		$db=  $this->session->userdata('db');
            $cropdata=$this->db->query("SELECT * from    Chitha_Basic WHERE dist_code='$dist_code' "
                . "AND Subdiv_code='$subdiv_code' "
                . "AND Cir_code='$circle_code' "
                . "AND Mouza_Pargona_code='$mouza_code' AND patta_type_code='0206' and Dag_nlrg_no <> ' '" );
        $cropdata = $cropdata->result();
        return $cropdata;
    }
}
