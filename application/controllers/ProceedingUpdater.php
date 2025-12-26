<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProceedingUpdater extends CI_Controller {

    var $user_code;
    var $base_query;
    var $query;

    public function __construct() {
        parent::__construct();
    }

    public function proceeding1() {
			$db=  $this->session->userdata('db');
       // ;
        $define_date = define_date;
        $year_no = '2017';
        $this->query = "dist_code = '17' and date(date_entry)>='$define_date' and year_no='$year_no' ";
        $appenq = $this->query;
        $query = "select * from    petition_basic where $appenq";
		echo $query;
        $pbs = $this->db->query($query)->result();
        $count = 1;
        foreach ($pbs as $pb) {

            $query = "select * from    petitioner where $appenq and year_no='$year_no' and petition_no=$pb->petition_no" . " ";
            //echo $query;
            $petitioner = $this->db->query($query)->result();
            ////var_dump($data['petitioner']);
            $dag = $this->db->query("select * from    petition_dag_details where $appenq and year_no='$year_no' and  petition_no=$pb->petition_no")->row();
            $query = "select co_order from    petition_proceeding where case_no='$pb->case_no' and proceeding_id=1 and dist_code='$pb->dist_code' and cir_code='$pb->cir_code' and "
                    . " subdiv_code='$pb->subdiv_code' ";
            echo $query;
            $old = $this->db->query($query)->row()->co_order;
           
                $message = "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল । আবেদনকাৰীয়ে " .
                        $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                        . " " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                        " গাৱৰ " . $dag->patta_no . " নং পট্টাৰ " . $dag->dag_no . " নং দাগৰ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "মাটিৰ নামজাৰী বিচাৰিছে |"
                        . "ভূমিলেখ্য সহায়ক আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি চিঠা আৰু জমাবন্দীৰ এক কপিকৈ প্র-পত্রমতে দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব পাৰে |";

                $query = "update petition_proceeding set co_order='$message' where case_no='$pb->case_no' and proceeding_id=1 and dist_code='$pb->dist_code' and cir_code='$pb->cir_code' and "
                        . " subdiv_code='$pb->subdiv_code' ";
                echo $old."<br>";
               // echo $query . "<br>";
                echo "<hr>";
          

            $count++;
        }
        echo $count;
    }

}
