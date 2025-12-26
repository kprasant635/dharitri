<?php
// BRD005: Improvment in Revenue Updation in Doul
// BRD0012: Improvment in Doul modified the date
class GenerateDoul extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('misreport/MisModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('eKhajana/EkhajanaCO/EkhajanaCoModel');
        $this->load->model('eKhajana/EkhajanaAdc/EkhajanaAdcModel');
        $this->load->model('eKhajana/EkhajanaTn/EkhajanaTnModel');
        $this->load->helper(array('form', 'url'));
        $this->dbswitch();
        $this->doul_date=DOUL_LAST_DATE;      
    }
    public function dbswitch(){       
     //$CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$this->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$this->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$this->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$this->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$this->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$this->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$this->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$this->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$this->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$this->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$this->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$this->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$this->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$this->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$this->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$this->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$this->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$this->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$this->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$this->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$this->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$this->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$this->load->database('dha23', TRUE);   
     }                                                                                                                                                                                                            
    }
    public function CircleWiseDoulGenerate() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $postyear = doul_year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);


        $re = array(
            'dist_code'   => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code'    => $circle_code,
            'dist_name'   => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name'    => $circledata,
            'year'        => $postyear
        );
        $re['FinalStatus'] = null;
        $re['remarks'] = null;
        $sqlForCheck = "SELECT status,dc_adc_remark FROM
                            current_doul_approve ca
                            where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
        if(!empty($array) && $array != null){
            $re['FinalStatus'] = $array->status;
            $re['remarks'] = $array->dc_adc_remark;
        }

        $re['FinalStatusDp'] = null;
        $re['remarksDp'] = null;
        $sqlForCheckDp = "SELECT status,dc_adc_remark FROM
                            current_dp_doul_approve ca
                            where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        $arrayDp = $this->db->query($sqlForCheckDp,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
        if(!empty($arrayDp) && $arrayDp != null){
            $re['FinalStatusDp'] = $arrayDp->status;
            $re['remarksDp'] = $arrayDp->dc_adc_remark;
        }
        //sql check for doul generated or not=============

        $sqlForExistDoul = "SELECT count(*) as total FROM
                            current_doul_demand cd
                            where cd.year_no = ? and cd.dist_code = ? and cd.subdiv_code=? and cd.cir_code = ?";
        $array1 = $this->db->query($sqlForExistDoul,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();

        if(isset($array1->total) && $array1->total > 0 && ($array->status == 'P' || $array->status == 'A')){
        //fetch doul details from current doul demand ======================

        $this->circleWiseDoulView();

        }else{
        $location = $this->db->query("SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
            . "and mouza_pargona_code != '00' and lot_no='00' and Vill_townprt_code = '00000'");
        $location = $location->result();

        $c = '';
        $sql="Select type_code from patta_code where jamabandi='y' ";
        $p_type_code = $this->db->query($sql)->result();
        foreach ($location as $loc) {
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $loc->mouza_pargona_code);
            $t_bigha = $t_katha=$t_lessa=$t_dag_revenue=$t_dag_localtax=$t_patta_no_count=0;
            $st_time = microtime(true);
           // foreach($p_type_code as $p_code)
           // {
            
               // $innerquery1 = "Select sum(dag_area_b) as t_bigha,sum(dag_area_k) as t_katha,sum(dag_area_lc) 
               //                   as t_lessa,sum(dag_area_g) 
               //                   as t_gonda,sum(round(dag_revenue, 2)) as t_dag_revenue,
               //                   sum(round(dag_localtax, 2)) as t_dag_localtax,
               //                   count(distinct(     
               //                      lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no))) as t_patta_no_count 
               //                 from jama_dag
               //                      join patta_code  on jama_dag.patta_type_code=patta_code.type_code
               //                 where dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' 
               //                       and mouza_pargona_code='$loc->mouza_pargona_code'
               //                       and patta_code.jamabandi='y' and patta_code.type_code != '0000'
               //                       and patta_no not in ('0','00','000','','.','..') and entry_date <= '$this->doul_date'  
               //                       and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
               //                       and 
                                     
               //                       (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                                       
               //                         (
               //                            select jama_patta.lot_no,jama_patta.mouza_pargona_code,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no) 
               //                            from jama_patta join location l 
               //                               on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
               //                                  l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
               //                                  l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code

               //                           where jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code'
               //                               and jama_patta.mouza_pargona_code='$loc->mouza_pargona_code'  and entry_date <= '$this->doul_date' 
               //                               and patta_no not in ('0','00','000','','.','..') 
               //                               and (l.nc_btad is null or l.nc_btad='e')
               //                               group by  jama_patta.lot_no, jama_patta.mouza_pargona_code, jama_patta.vill_townprt_code,
               //                                            patta_type_code,patta_no
               //                         )
                                                                       
               //                  ";
            $comma = ",";
            $innerquery1 = "select sum(t.t_bigha) as t_bigha,sum(t.t_katha) as t_katha,sum(t.t_lessa) as t_lessa,
                              sum(t.t_gonda) as t_gonda,sum(t.t_dag_revenue) as t_dag_revenue,
                              sum(t.t_dag_localtax) as t_dag_localtax,sum(t.t_patta_no_count) as t_patta_no_count
                              from
                              (
                                 select
                                 t_bigha, t_katha, 
                                 t_lessa,t_gonda,t_dag_revenue,
                                 t_dag_localtax,t_patta_no_count from  
                                 (
                                       select sum(dag_area_b) as t_bigha,sum(dag_area_k) as t_katha,sum(dag_area_lc) 
                                       as t_lessa,sum(dag_area_g) 
                                       as t_gonda,sum(round(dag_revenue, 2)) as t_dag_revenue,
                                       sum(round(dag_localtax, 2)) as t_dag_localtax,
                                       count(distinct(     
                                       lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no))) as t_patta_no_count,lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no) as patta_no 
                                       from jama_dag
                                    join patta_code  on jama_dag.patta_type_code=patta_code.type_code
                                    where dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' 
                                    and mouza_pargona_code='$loc->mouza_pargona_code' and entry_date <= '$this->doul_date' 
                                    and patta_code.jamabandi='y' and patta_code.type_code != '0000'
                                    and patta_no not in ('0','00','000','','.','..','$comma')  
                                    and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                                    group by lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)
                                    ) as t1
                              join 
                              (
                                    select jama_patta.lot_no,jama_patta.mouza_pargona_code,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no) as patta_no 
                                    from jama_patta join location l 
                                    on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                                    l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                                    l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code
                                    where jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code'
                                    and jama_patta.mouza_pargona_code='$loc->mouza_pargona_code' and entry_date <= '$this->doul_date' 
                                    and patta_no not in ('0','00','000','','.','..','$comma') 
                                    and (l.nc_btad is null or l.nc_btad='e')
                                    group by  jama_patta.lot_no, jama_patta.mouza_pargona_code, jama_patta.vill_townprt_code,
                                    patta_type_code,patta_no
                              ) t2 
                              on t1.lot_no = t2.lot_no and
                              t1.mouza_pargona_code = t2.mouza_pargona_code and
                              t1.vill_townprt_code = t2.vill_townprt_code and
                              t1.patta_type_code = t2.patta_type_code and
                              trim(t1.patta_no) = t2.patta_no
                              ) t";
              
               
                //echo "<br>";
                $data = $this->db->query($innerquery1)->row();
                //log_message('error', 'last_queryCircleWiseDoulGenerate===: '.$this->db->last_query());
                log_message('error', 'MB : CircleWiseDoulGenerate Doul Query Time taken: '.(microtime(true) - $st_time));
                //log_message('error',"*************".$this->db->last_query() .'*************<br>');
                $t_bigha= $data->t_bigha;
                $t_katha= $data->t_katha;
                $t_lessa= $data->t_lessa;
                $t_gonda= $data->t_gonda;
                $t_dag_revenue=$t_dag_revenue + $data->t_dag_revenue;
                $t_dag_localtax=$t_dag_localtax + $data->t_dag_localtax;
                $t_patta_no_count=$t_patta_no_count + $data->t_patta_no_count;
            //}
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
               $get_total_lessa = $this->utilityclass->Total_ganda($t_bigha, $t_katha, $t_lessa,$t_gonda);
               //echo "<br>";
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
               //var_dump($Total_Bigha_Katha_Lessa);
            }else{
               $get_total_lessa = $this->utilityclass->Total_Lessa($t_bigha, $t_katha, $t_lessa);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
            }
            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_code' => $loc->mouza_pargona_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'mouza_name' => $mouza_name,
                'year' => $postyear,
                'bigha' => $Total_Bigha_Katha_Lessa[0],
                'ktha' => $Total_Bigha_Katha_Lessa[1],
                'lessa' => $Total_Bigha_Katha_Lessa[2],
                'gonda' => $Total_Bigha_Katha_Lessa[3],
                'total_lessa' => $get_total_lessa,
                'dag_revenue' => $t_dag_revenue,
                'local_tax'   => $t_dag_localtax,
                'total_patta' => $t_patta_no_count,
            );
            $result[] = $main;
        }
        $re['result'] = $result;
        $re['_view'] = 'GenerateDoul/GenerateCircleWiseDoul';
        $this->load->view('layouts/main',$re);
      }
        
    }
    public function MouzaWiseDoulGenerate() {
       //var_dump($this->session->all_userdata());
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code  = $this->input->get('mouza_code');
        $postyear    = doul_year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata  = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata  = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name  = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear
        );



         $re['FinalStatus'] = null;
         $re['remarks'] = null;
         $sqlForCheck = "SELECT status,dc_adc_remark FROM
                              current_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
         //sql check for doul generated or not=============

         $sqlForExistDoul = "SELECT count(*) as total FROM
                              current_doul_demand cd
                              where cd.year_no = ? and cd.dist_code = ? and cd.subdiv_code=? and cd.cir_code = ?";
         $array1 = $this->db->query($sqlForExistDoul,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();

         if(isset($array1->total) && $array1->total > 0 && ($array->status == 'P' || $array->status == 'A')){
            //fetch doul details from current doul demand ======================
            $this->MouzaWiseDoulGeneratedView();

         }else{

            // $this->autoRedirectPage('development');
            // return;


              $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();
               $comma = ",";
              foreach ($patta_type as $pt) {
                  //echo "<pre>" . $pt->type_code ;
                  $patta_name = $this->utilityclass->getPattaType($pt->type_code);            
                  $innerquery = "Select distinct(jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no))
                                 from jama_patta
                                 join location l 
                                                   on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                                                      l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                                                      l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code



                                  where (l.nc_btad is null or l.nc_btad='e') and jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code' and jama_patta.mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date' and 
                                      (jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no)) in 
                                        (select lot_no,vill_townprt_code,patta_type_code,trim(patta_no) from jama_dag where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date'
                                           group by lot_no,vill_townprt_code,trim(patta_no),patta_type_code
                                        )
                                  ";
                  $total_patta_no = $this->db->query($innerquery)->result();
                  $patta_no_count = count($total_patta_no);
                  
                  $innerquery1 = "Select sum(dag_area_b) as bigha,sum(dag_area_k) as ktha,
                                     sum(dag_area_lc) as lessa,sum(dag_area_g) as gonda,sum(round(dag_revenue, 2)) as dag_revenue,
                                     sum(round(dag_localtax, 2)) as dag_localtax 
                                  from jama_dag where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date'
                                  and (lot_no,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                                        (select jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no) from jama_patta 

                                        join location l 
                                                   on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                                                      l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                                                      l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code



                                        where jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code' and jama_patta.mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date' and (l.nc_btad is null or l.nc_btad='e') 
                                           group by jama_patta.lot_no,jama_patta.vill_townprt_code,trim(patta_no),patta_type_code
                                        )
                                  ";
                  $data = $this->db->query($innerquery1)->row();
                  //log_message('error',"*************".$this->db->last_query() .'*************<br>');
                  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                     $get_total_lessa = $this->utilityclass->Total_ganda($data->bigha, $data->ktha, $data->lessa,$data->gonda);
                     $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
                  }else{
                     $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
                     $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                  }
                  if ($total_patta_no > 0) {
                      $status = '';
                      if (($data->bigha == null) && ($data->ktha == null) && ($data->lessa == null)) {
                          $status = 'False';
                      } else {
                          $main = array
                              (
                              'dist_code' => $dist_code,
                              'subdiv_code' => $subdiv_code,
                              'cir_code' => $circle_code,
                              'mouza_code' => $mouza_code,
                              'dist_name' => $districtdata,
                              'subdiv_name' => $subdivdata,
                              'cir_name' => $circledata,
                              'mouza_name' => $mouza_name,
                              'year' => $postyear,
                              'bigha' => $Total_Bigha_Katha_Lessa[0],
                              'ktha' => $Total_Bigha_Katha_Lessa[1],
                              'lessa' => $Total_Bigha_Katha_Lessa[2],
                              'gonda' => $Total_Bigha_Katha_Lessa[3],
                              'total_lessa' => $get_total_lessa,
                              'dag_revenue' => $data->dag_revenue,
                              'local_tax' => $data->dag_localtax,
                              'total_patta' => $patta_no_count,
                              'patta_name' => $patta_name,
                              'patta_type_code' => $pt->type_code,
                              'status' => $status,
                          );
                          $result[] = $main;
                      }
                  }
                 
              }

            $re['result'] = $result;
            $re['_view'] = 'GenerateDoul/GenerateMouzaWiseDoul';
            $this->load->view('layouts/main',$re);
           }
        
    }

    public function MouzaWiseDoulGenerateOld() {
       //var_dump($this->session->all_userdata());
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code  = $this->input->get('mouza_code');
        $postyear    = year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata  = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata  = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name  = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear
        );



         $re['FinalStatus'] = null;
         $re['remarks'] = null;
         $sqlForCheck = "SELECT status,dc_adc_remark FROM
                              current_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
         //sql check for doul generated or not=============

         $sqlForExistDoul = "SELECT count(*) as total FROM
                              current_doul_demand cd
                              where cd.year_no = ? and cd.dist_code = ? and cd.subdiv_code=? and cd.cir_code = ?";
         $array1 = $this->db->query($sqlForExistDoul,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();

         if(isset($array1->total) && $array1->total > 0 && ($array->status == 'P' || $array->status == 'A')){
            //fetch doul details from current doul demand ======================
            $this->MouzaWiseDoulGeneratedView();

         }else{


              // $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();
            $patta_type = [
               (object)[
                  'type_code' => '0201'
               ]
            ];
          

       
              $st_time = microtime(true);
              $comma = ",";
              foreach ($patta_type as $pt) {
                  $patta_name = $this->utilityclass->getPattaType($pt->type_code);  
                  
                  $innerquery_new = "Select distinct on (jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no)) 
                                       jama_patta.lot_no ||'_' || jama_patta.vill_townprt_code ||'_' || patta_type_code ||'_'|| trim(patta_no) as patta
                                     
                                     from jama_patta join 
                                     
                                     (select * from location where subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code') l 
                                        on l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code
                                     
                                     where (l.nc_btad is null or l.nc_btad='e') 
                                     and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code' and jama_patta.mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' 
                                        and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date' ";
                  $inner_data = $this->db->query($innerquery_new)->result();

                  // log_message("error","Patta count===========".json_encode($inner_data));
             


                  $check_query = "select  array_agg(t.lot_no ||'_' || t.vill_townprt_code || '_' || t.patta_type_code || '_' || trim(t.patta_no)) as pattas
                                  from ( 
                                          select distinct on (lot_no,vill_townprt_code,patta_type_code,trim(patta_no)) lot_no,vill_townprt_code,patta_type_code,trim(patta_no) as patta_no 
                                              from jama_dag where (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and dp_flag_yn is null 
                                              and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date'
                                              group by lot_no,vill_townprt_code,trim(patta_no),patta_type_code
                                       ) t";
                  $check_data = $this->db->query($check_query)->row()->pattas;
                  $result_check =  str_replace("{","",$check_data);
                  $result_check =  str_replace("}","",$result_check);
            
                  $str_arr=explode(",",$result_check);

                  // var_dump($str_arr);
                  // die;



    
                  $final_array = array();
                  $count = 1;
                  foreach($inner_data as $t)
                  {
                     if (in_array($t->patta,$str_arr))
                     {
                         $final_array[$t->patta] = $t->patta;
                     }
                     else
                     {
                        $count++;
                        log_message('error',  $t->patta.', count='.$count);
                     }
                  }


                  $str = '';
                  foreach($final_array as $t=>$val)
                  {
                      $str=$str."'".$val."',";
                    
                  }

                  log_message("error","Patta count===========".count($final_array));
                  //log_message("error","Patta count String===========".json_encode($str));
                  if (!isset($final_array) or $final_array == null or empty($final_array))
                     $patta_no_count = 0;
                  else
                     $patta_no_count = sizeof($final_array);


      
                  

                  $innerquery1 = "Select sum(dag_area_b) as bigha,sum(dag_area_k) as ktha,
                                     sum(dag_area_lc) as lessa,sum(dag_area_g) as gonda,sum(round(dag_revenue, 2)) as dag_revenue,
                                     sum(round(dag_localtax, 2)) as dag_localtax 
                                  from jama_dag where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..') and entry_date <= '$this->doul_date'
                                  and (lot_no,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                                        (select jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no) from jama_patta 

                                        join location l 
                                                   on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                                                      l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                                                      l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code



                                        where jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code' and jama_patta.mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date' and (l.nc_btad is null or l.nc_btad='e') 
                                           group by jama_patta.lot_no,jama_patta.vill_townprt_code,trim(patta_no),patta_type_code
                                        )
                                  ";
                  $data = $this->db->query($innerquery1)->row();
                  //log_message('error',"*************".$this->db->last_query() .'*************<br>');
                  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                     $get_total_lessa = $this->utilityclass->Total_ganda($data->bigha, $data->ktha, $data->lessa,$data->gonda);
                     $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
                  }else{
                     $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
                     $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                  }
                  if ($patta_no_count > 0) {
                      $status = '';
                      if (($data->bigha == null) && ($data->ktha == null) && ($data->lessa == null)) {
                          $status = 'False';
                      } else {
                          $main = array
                              (
                              'dist_code' => $dist_code,
                              'subdiv_code' => $subdiv_code,
                              'cir_code' => $circle_code,
                              'mouza_code' => $mouza_code,
                              'dist_name' => $districtdata,
                              'subdiv_name' => $subdivdata,
                              'cir_name' => $circledata,
                              'mouza_name' => $mouza_name,
                              'year' => $postyear,
                              'bigha' => $Total_Bigha_Katha_Lessa[0],
                              'ktha' => $Total_Bigha_Katha_Lessa[1],
                              'lessa' => $Total_Bigha_Katha_Lessa[2],
                              'gonda' => $Total_Bigha_Katha_Lessa[3],
                              'total_lessa' => $get_total_lessa,
                              'dag_revenue' => $data->dag_revenue,
                              'local_tax' => $data->dag_localtax,
                              'total_patta' => $patta_no_count,
                              'patta_name' => $patta_name,
                              'patta_type_code' => $pt->type_code,
                              'status' => $status,
                          );
                          $result[] = $main;
                      }
                  }
              }
            log_message('error', 'MouzaWiseDoulGenerate: time taken: '.(microtime(true)-$st_time));
            $re['result'] = $result;
            $re['_view'] = 'GenerateDoul/GenerateMouzaWiseDoul';
            $this->load->view('layouts/main',$re);
           }
        
    }
    /////
    public function ChangeInLand() {
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->get('mouza_code');
        $postyear = year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
           'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear
        );
        $location = $this->db->query("SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and mouza_pargona_code = '$mouza_code' and lot_no='00' and Vill_townprt_code = '00000' ");
        $location = $location->result();
        $c = '';
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $innerquery1 = "Select sum(dag_area_b) as bigha,sum(dag_area_k) as katha,sum(dag_area_lc) as lessa,sum(dag_revenue) as revenue,sum(dag_local_tax) as localtax from chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code='$mouza_code' and chitha_update='Y' and date_entry >'2020-07-31' and date_entry <='$this->doul_date' ";
        $data = $this->db->query($innerquery1)->row();  
        $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->katha, $data->lessa);
        $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
        $main = array
            (
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear,
            'bigha' => $Total_Bigha_Katha_Lessa[0],
            'katha' => $Total_Bigha_Katha_Lessa[1],
            'lessa' => $Total_Bigha_Katha_Lessa[2],
            'revenue'=>$data->revenue,
            'localtax'=>$data->localtax
        );
        $result[] = $main;
        $innerquery2= "Select sum(CAST(alot_area_b AS double precision)) as bigha, sum(CAST(alot_area_k AS double precision)) as katha,sum(CAST(alot_area_lc AS double precision)) as lessa,sum(round(dag_revenue, 2)) as revenue,sum(round(dag_local_tax, 2)) as localtax from allotment_cert_basic acb left join allotment_pet_dag apd on acb.case_no=apd.case_no and acb.dist_code=apd.dist_code and acb.subdiv_code=apd.subdiv_code and acb.circle_code=apd.circle_code and acb.mouza_pargona_code=apd.mouza_pargona_code join chitha_basic cb on apd.dag_no=cb.dag_no and apd.dist_code=cb.dist_code and apd.subdiv_code=cb.subdiv_code and 
            apd.circle_code=cb.cir_code and apd.mouza_pargona_code=cb.mouza_pargona_code and apd.lot_no = cb.lot_no and apd.mouza_pargona_code = cb.mouza_pargona_code and apd.vill_townprt_code = cb.vill_townprt_code  where acb.status='F' and acb.dist_code='$dist_code' and acb.subdiv_code='$subdiv_code' and acb.circle_code='$circle_code' and acb.mouza_pargona_code='$mouza_code'  and acb.date_entry >'2019-07-31' and acb.date_entry <='2020-07-31'";
        $data1 = $this->db->query($innerquery2)->row();        
        $get_total_lessa = $this->utilityclass->Total_Lessa($data1->bigha, $data1->katha, $data1->lessa);
        $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
        $main1 = array
            (
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear,
            'bigha' => $Total_Bigha_Katha_Lessa[0],
            'katha' => $Total_Bigha_Katha_Lessa[1],
            'lessa' => $Total_Bigha_Katha_Lessa[2],
            'revenue'=>$data1->revenue,
            'localtax'=>$data1->localtax,    
        );        
        $result1[] = $main1;
        $innerquery3="select sum(m_dag_area_b) as bigha,sum(m_dag_area_k) as katha,sum(m_dag_area_lc) as lessa,sum(round(dag_revenue, 2)) as revenue,sum(round(dag_local_tax, 2)) as localtax from chitha_rmk_ordbasic cro 
            join chitha_basic cb on cro.dag_no=cb.dag_no and cro.dist_code=cb.dist_code 
            and cro.subdiv_code=cb.subdiv_code 
            and cro.cir_code=cb.cir_code and cro.mouza_pargona_code=cb.mouza_pargona_code and cro.lot_no = cb.lot_no 
            and cro.mouza_pargona_code = cb.mouza_pargona_code and cro.vill_townprt_code = cb.vill_townprt_code
            where ord_type_code='01' and cro.dist_code='$dist_code' and cro.subdiv_code='$subdiv_code' and cro.cir_code='$circle_code' and  cro.mouza_pargona_code='$mouza_code' and cro.date_entry<='$this->doul_date' and cro.date_entry>'2020-07-31'";
        $data2 = $this->db->query($innerquery3)->row();
        $get_total_lessa = $this->utilityclass->Total_Lessa($data2->bigha, $data2->katha, $data2->lessa);
        $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
        $main2 = array
            (
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear,
            'bigha' => $Total_Bigha_Katha_Lessa[0],
            'katha' => $Total_Bigha_Katha_Lessa[1],
            'lessa' => $Total_Bigha_Katha_Lessa[2],
            'revenue'=>$data2->revenue,
            'localtax'=>$data2->localtax,
            );
            $result2[] = $main2;
            $innerquery4="select sum(dag_area_b) as bigha,sum(dag_area_k) as katha,sum(dag_area_lc) as lessa,sum(round(dag_revenue, 2)) as revenue,sum(round(dag_local_tax, 2)) as localtax from apcancel_dag_details 
                apd join chitha_basic cb on apd.dag_no=cb.dag_no and apd.dist_code=cb.dist_code and apd.subdiv_code=cb.subdiv_code and 
                apd.cir_code=cb.cir_code and apd.mouza_pargona_code=cb.mouza_pargona_code and apd.lot_no = cb.lot_no 
                and apd.mouza_pargona_code = cb.mouza_pargona_code and apd.vill_townprt_code = cb.vill_townprt_code join  apcancel_petition_basic apb on apd.case_no= apb.case_no 
                where apd.date_entry>'2019-07-31' and apd.date_entry<='2020-07-31' and apb.co_chitha_corrected_yn='Y' and apd.dist_code='$dist_code' and apd.subdiv_code='$subdiv_code' and apd.cir_code='$circle_code' and apd.mouza_pargona_code='$mouza_code'" ;
        $data3 = $this->db->query($innerquery4)->row();
        $get_total_lessa = $this->utilityclass->Total_Lessa($data3->bigha, $data3->katha, $data3->lessa);
        $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
        $main3 = array
            (
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear,
            'bigha' => $Total_Bigha_Katha_Lessa[0],
            'katha' => $Total_Bigha_Katha_Lessa[1],
            'lessa' => $Total_Bigha_Katha_Lessa[2],
            'revenue'=>$data3->revenue,
            'localtax'=>$data3->localtax,
            );
            $result3[] = $main3;
        $innerquery5="select present_land_class,proposed_land_class,sum(dag_area_b) as bigha,sum(dag_area_k) as katha,sum(dag_area_lc) as lessa,sum(round(present_land_revenue, 2)) as preRev,sum(round(present_land_localtax, 2)) as preLocaltax,sum(round(proposed_land_revenue, 2)) as proRev,sum(round(proposed_land_localtax, 2)) as proLocaltax from t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lm_date>'2020-07-31' and lm_date<='$this->doul_date' group by present_land_class,proposed_land_class " ;

            $data4 = $this->db->query($innerquery5)->result();
            foreach ($data4 as $dt) 
            {
                $land_typePresent= $this->utilityclass->getLandClassCode($dt->present_land_class); 
                $land_typeProposed= $this->utilityclass->getLandClassCode($dt->proposed_land_class); 
                $get_total_lessa = $this->utilityclass->Total_Lessa($dt->bigha, $dt->katha, $dt->lessa);
                $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                $main4 = array
                            (
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $circle_code,
                            'mouza_code' => $mouza_code,
                            'dist_name' => $districtdata,
                            'subdiv_name' => $subdivdata,
                            'cir_name' => $circledata,
                            'mouza_name' => $mouza_name,
                            'year' => $postyear,
                            'bigha' => $Total_Bigha_Katha_Lessa[0],
                            'katha' => $Total_Bigha_Katha_Lessa[1],
                            'lessa' => $Total_Bigha_Katha_Lessa[2],
                            'land_typePresent'=>$land_typePresent,
                            'land_typeProposed'=>$land_typeProposed,
                            'preRev'=>$dt->prerev,
                            'preLocaltax'=>$dt->prelocaltax,
                            'proRev'=>$dt->prorev,
                            'proLocaltax'=>$dt->prolocaltax,
                        );
                        $result4[] = $main4; 
            }
        $re['result'] = $result;
        $re['result1'] = $result1;
        $re['result2'] = $result2;
        $re['result3'] = $result3;
        $re['result4'] = $result4;
        $re['_view'] = 'GenerateDoul/ChangeInLand';
        $this->load->view('layouts/main',$re);
    }
    public function VillagePattaWiseDoulGenerate() {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->get('mouza_code');
        $patta_type_code = $this->input->get('patta_type');
        $postyear = year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear
        );




         $sqlForCheck = "SELECT status,dc_adc_remark FROM
                              current_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
         //sql check for doul generated or not=============

         $sqlForExistDoul = "SELECT count(*) as total FROM
                              current_doul_demand cd
                              where cd.year_no = ? and cd.dist_code = ? and cd.subdiv_code=? and cd.cir_code = ?";
         $array1 = $this->db->query($sqlForExistDoul,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();

         if(isset($array1->total) && $array1->total > 0 && ($array->status == 'P' || $array->status == 'A')){
            //fetch doul details from current doul demand ======================
            $this->VillagePattaWiseDoulGeneratedView();

         }else{


               $comma = ",";
                $innerquery = "Select jama_patta.mouza_pargona_code,jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code from jama_patta 

                join location l 
                     on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                     l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                     l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code

                where (l.nc_btad is null or l.nc_btad='e') and jama_patta.dist_code='$dist_code' and "
                         . "jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code' and jama_patta.mouza_pargona_code='$mouza_code' and patta_type_code='$patta_type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date'"
                         . " GROUP BY jama_patta.dist_code,jama_patta.subdiv_code,jama_patta.cir_code,jama_patta.mouza_pargona_code,jama_patta.lot_no,jama_patta.vill_townprt_code,patta_type_code ";
                 $jama_patta = $this->db->query($innerquery)->result();     
                 foreach ($jama_patta as $jp) {
                     $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $jp->mouza_pargona_code, $jp->lot_no, $jp->vill_townprt_code);
                     $patta_name = $this->utilityclass->getPattaType($patta_type_code);
                    $innerquery1 = "Select sum(dag_area_b) as bigha,sum(dag_area_k) as ktha,sum(dag_area_lc) as lessa,sum(dag_area_g) as gonda,sum(round(dag_revenue, 2)) as dag_revenue,"
                             . "sum(round(dag_localtax, 2)) as dag_localtax,count(distinct(trim(patta_no))) as patta_no from jama_dag where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and  dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                             . "mouza_pargona_code='$mouza_code' and lot_no = '$jp->lot_no' and Vill_townprt_code = '$jp->vill_townprt_code' and patta_type_code='$patta_type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date' and trim(patta_no) in 
                             (Select trim(patta_no) from jama_patta 

                             join location l 
                                    on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                                    l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                                    l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code


                             where jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code' and "
                             . "jama_patta.mouza_pargona_code='$mouza_code' and jama_patta.lot_no = '$jp->lot_no' and jama_patta.Vill_townprt_code = '$jp->vill_townprt_code' and patta_type_code='$patta_type_code' and (l.nc_btad is null or l.nc_btad='e') and trim(patta_no) not in ('0','00','000','','.','..','$comma') and entry_date <= '$this->doul_date') ";
                     //echo "<br>";
                     $data = $this->db->query($innerquery1)->row();
                     //echo "==============================<br>";
                     if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                        $get_total_lessa = $this->utilityclass->Total_ganda($data->bigha, $data->ktha, $data->lessa,$data->gonda);
                        $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
                     }else{
                        $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
                        $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                     }
                     // $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
                     // $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                     $status = '';
                     if (($data->bigha == null) && ($data->ktha == null) && ($data->lessa == null)) {
                         $status = 'False';
                     }
                     $main = array
                         (
                         'dist_code' => $dist_code,
                         'subdiv_code' => $subdiv_code,
                         'cir_code' => $circle_code,
                         'mouza_code' => $mouza_code,
                         'lot_no' => $jp->lot_no,
                         'vill_townprt_code' => $jp->vill_townprt_code,
                         'dist_name' => $districtdata,
                         'subdiv_name' => $subdivdata,
                         'cir_name' => $circledata,
                         'mouza_name' => $mouza_name,
                         'village_name' => $village_name,
                         'year' => $postyear,
                         'bigha' => $Total_Bigha_Katha_Lessa[0],
                         'ktha' => $Total_Bigha_Katha_Lessa[1],
                         'lessa' => $Total_Bigha_Katha_Lessa[2],
                         'total_lessa' => $get_total_lessa,
                         'dag_revenue' => $data->dag_revenue,
                         'local_tax' => $data->dag_localtax,
                         'patta_no' => $data->patta_no,
                         'patta_type_code' => $patta_type_code,
                         'patta_name' => $patta_name,
                         'status' => $status,
                     );
                     //var_dump($main);
                     $result[] = $main;
                 }
                 $re['result'] = $result;
                 $re['_view'] = 'GenerateDoul/GenerateVillagePattaWiseDoul';
                 $this->load->view('layouts/main',$re);
         }
    }  
    public function DagWiseDoulGenerate() {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->get('mouza_code');
        $lot_no = $this->input->get('lot_no');
        $village_code = $this->input->get('village_code');
        $patta_type_code = $this->input->get('patta_type');
        $postyear = year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code);
        $patta_name = $this->utilityclass->getPattaType($patta_type_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'lot_name' => $lot_name,
            'village_name' => $vill_name,
            'patta_type' => $patta_name,
            'patta_code' => $patta_type_code,
            'year' => $postyear
        );
        $patta_no = $this->db->query("Select distinct(trim(patta_no)) as patta_no, lot_no as lot_no, vill_townprt_code as vill_townprt_code, "
                . "patta_type_code as type_code from jama_dag where dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$village_code' and "
                . "patta_type_code = '$patta_type_code' and entry_date <= '$this->doul_date'
                and patta_no in (select trim(patta_no) from jama_patta 

                join location l 
                           on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and 
                           l.mouza_pargona_code=jama_patta.mouza_pargona_code and 
                           l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code

                where (l.nc_btad is null or l.nc_btad='e') and jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and "
                . "jama_patta.cir_code='$circle_code' and jama_patta.mouza_pargona_code='$mouza_code' and jama_patta.lot_no = '$lot_no' and jama_patta.vill_townprt_code='$village_code' and "
                . "patta_type_code = '$patta_type_code' and entry_date <= '$this->doul_date' and trim(patta_no) not in ('0','00','000','','.','..','$comma') )
                ")->result();
        
        foreach ($patta_no as $pt) {
            $result=null;
            $innerquery = "Select * from jama_dag where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$village_code' and "
                . "patta_type_code = '$patta_type_code' and trim(patta_no) = '$pt->patta_no' and entry_date <= '$this->doul_date'";           
            $dag_no = $this->db->query($innerquery)->result();            
            foreach ($dag_no as $dg) {
                $innerquery1 = "Select dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,round(dag_revenue, 2) as dag_revenue,"
                        . "round(dag_localtax, 2) as dag_localtax, dag_class_code as land_class_code from    jama_dag where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$village_code' and "
                        . "patta_type_code = '$patta_type_code' and dag_no = '$dg->dag_no' and trim(patta_no) = '$pt->patta_no' and entry_date <= '$this->doul_date'";
                $data = $this->db->query($innerquery1)->row();
                $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
                $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                $land_class_name = $this->utilityclass->getLandClassCode($data->land_class_code);
                $main = array
                    (
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $village_code,
                    'dag_no' => $dg->dag_no,
                    //'dag_no_int' => $dg->dag_no_int,
                    'patta_no' => $pt->patta_no,
                    'land_class' => $data->land_class_code,
                    'year' => $postyear,
                    'bigha' => $data->bigha,
                    'ktha' =>  $data->ktha,
                    'lessa' =>  $data->lessa,
                    'total_lessa' => $get_total_lessa,
                    'dag_revenue' => $data->dag_revenue,
                    'local_tax' => $data->dag_localtax,
                    'land_class_name' => $land_class_name,
                    'patta_name' => $patta_name,
                    'patta_type_code' => $pt->type_code,
                );
                $result[] = $main;
            }
            $re['result'][$pt->patta_no] = $result;
        }
        $re['_view'] = 'GenerateDoul/GenerateDagWiseDoul';
        $this->load->view('layouts/main',$re);
    }

    /*public function UpdateDagRevenue() {
        // $dist_code,$subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$village_code,$patta_type_code,$patta_no,$dag_no,$RevenuePerBigha,$minRevenue
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_pargona_code=$this->input->post('mouza_pargona_code');
        $lot_no=$this->input->post('lot_no');
        $village_code=$this->input->post('vill_townprt_code');
        $patta_type_code=$this->input->post('patta_type_code');
        $patta_no=$this->input->post('patta_no');
        $dag_no=$this->input->post('dag_no');
        $RevenuePerBigha=$this->input->post('dag_revenue');
        $minRevenue=$this->input->post('local_tax');
        $cdt = date("Y/m/d");
        $cyr = date("Y");
        $usercode = $this->session->userdata('user_code');
        if (is_numeric($RevenuePerBigha) === FALSE && is_numeric($minRevenue) === FALSE) {
            $data=array('success'=>'Please type more than 0');
            echo json_encode($data);
            return;
        } else {
            if ($minRevenue <= 0 && $RevenuePerBigha<=0) {
                    $data=array('success'=>'Please type revenue more than Zero');
                    echo json_encode($data);
                    return;
                } else { 
                     if ($minRevenue <= 0) {
                          $data=array('success'=>'Please type local tax more than Zero');
                          echo json_encode($data);
                          return;
                      } else { 
                        $this->db->query("UPDATE chitha_basic set dag_revenue='$RevenuePerBigha', dag_local_tax = '$minRevenue' where dist_code='$dist_code' and "
                                . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and "
                                . "vill_townprt_code='$village_code' and dag_no = '$dag_no' and patta_no = '$patta_no' and patta_type_code='$patta_type_code'");
                        // log_message("error","DAG_RevenueUpdateChitha".$this->db->last_query());
                        if($this->db->affected_rows()==true){
                            $this->db->query("UPDATE jama_dag set dag_revenue='$RevenuePerBigha', dag_localtax = '$minRevenue' where dist_code='$dist_code' and "
                                . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and "
                                . "vill_townprt_code='$village_code' and dag_no = '$dag_no' and patta_no = '$patta_no' and patta_type_code='$patta_type_code'");
                            //echo $this->db->last_query();
                            // log_message("error","DAG_RevenueUpdateJama".$this->db->last_query());
                            if($this->db->affected_rows()==true){
                                $data=array('success'=>'Updated Successfully');
                                echo json_encode($data);
                                return;
                            }else{
                              log_message("error","DAG_RevenueUpdateJama".$this->db->last_query());
                                 /* ------------------------------------------------------- */
                               /*$data=array('success'=>'Error in Updation11');
                               echo json_encode($data);
                               return;
                            }
                        }else{
                           log_message("error","DAG_RevenueUpdateChitha".$this->db->last_query());
                           $data=array('success'=>'Above Mentioned dag may not be present in Chitha.<br> Please Check JB copy of this Patta whether exists or not .');
                           echo json_encode($data);
                           return;
                        }
                        
                     }
                }
                
        }
        $data=array('success'=>'Use numeric values');
        echo json_encode($data);
        return;
    } */*/  
    /* Save Doul is for saving after generating the doul */
    public function SaveDoul() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $postyear = year_no; //$this->input->post('year_no');
        $mouza_code = $this->input->post('mouza_code');
        $patta_type = $this->input->post('patta_type');
        $total_patta = $this->input->post('total_patta');
        $total = $this->input->post('total');
        $local_tax = $this->input->post('local_tax');
        $bigha = $this->input->post('bigha');
        $ktha = $this->input->post('ktha');
        $lessa = $this->input->post('lessa');
        $count = count($total_patta);
        //exit();
        for ($i = 0; $i < $count; $i++) {
            $yeardoul = array(
                'rcolyear' => $postyear,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code[$i],
                'noofpatta' => $total_patta[$i],
                'revenuedemand' => $total[$i],
                'revenueltax' => $local_tax[$i],
                'dagb' => $bigha[$i],
                'dagk' => $ktha[$i],
                'daglc' => $lessa[$i],
                'pattatype' => $patta_type[$i],
                'year_no' => $postyear,
                'status' => 'P'
            );
            $this->db->insert('yeardoul', $yeardoul);
        }
    }
    public function locationSelect() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $district['_view'] = 'GenerateDoul/locationSelect';
        $this->load->view('layouts/main',$district);
    }
    public function DoulReport() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $postyear = $this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $result = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'year' => $postyear
        );
        $location = $this->db->query("SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and mouza_pargona_code !='00'and lot_no='00' and Vill_townprt_code = '00000'");
        $location = $location->result();
        foreach ($location as $loc) {
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $loc->mouza_pargona_code);
            $for_mouza = "SELECT sum(dagb) as bigha,sum(dagk) as ktha,sum(daglc) as lessa,sum(round(revenuedemand, 2)) as total, "
                    . "sum(round(revenueltax, 2)) as total_lc,sum(noofpatta) as total_patta from    yeardoul where dist_code='$dist_code' and "
                    . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$loc->mouza_pargona_code'";
            $for_mouza_data = $this->db->query($for_mouza)->row();
            $mouzadata = array
                (
                'bigha' => $for_mouza_data->bigha,
                'ktha' => $for_mouza_data->ktha,
                'lessa' => $for_mouza_data->lessa,
                'total' => $for_mouza_data->total,
                'local_tax' => $for_mouza_data->total_lc,
                'total_patta' => $for_mouza_data->total_patta,
                'mouza_name' => $mouza_name,
                'mouza_code' => $loc->mouza_pargona_code
            );
            $main = array();
            $innerquery = "select * from    yeardoul where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code='$loc->mouza_pargona_code' ";
            $innerdata = $this->db->query($innerquery)->result();
            foreach ($innerdata as $data) {
                $patta_name = $this->utilityclass->getPattaType($data->pattatype);

                $main[$mouza_name][] = array
                    (
                    'bigha' => $data->dagb,
                    'ktha' => $data->dagk,
                    'lessa' => $data->daglc,
                    'total' => $data->revenuedemand,
                    'patta_type' => $data->pattatype,
                    'patta_name' => $patta_name,
                    'local_tax' => $data->revenueltax,
                    'total_patta' => $data->noofpatta,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                );
            }

            $result['result'][$mouza_name] = array_merge($mouzadata, $main);
        }
        $result['_view'] = 'GenerateDoul/DoulReport';
        $this->load->view('layouts/main',$result);
    }
    public function DoulReportPTVillage() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_code = $this->input->get('mouza_pargona_code');
        $patta_type = $this->input->get('patta_type');
        $postyear = $this->input->get('year_no');
        $year = explode('-', $postyear);
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $patta_name = $this->utilityclass->getPattaType($patta_type);
        $result = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear,
            'patta_name' => $patta_name
        );
        $location = $this->db->query("SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and mouza_pargona_code = '$mouza_code'and lot_no != '00' and Vill_townprt_code != '00000' limit 2");
        $location = $location->result();
        $main = array();
        foreach ($location as $loc) {
            $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $loc->lot_no, $loc->vill_townprt_code);

            $for_village = "select sum(Dag_area_B) as bigha,sum(Dag_area_K) as ktha,sum(Dag_area_LC) as lessa,sum(round(Dag_revenue, 2)) as total,"
                    . "sum(round(dag_local_tax, 2)) as total_lc,count(distinct(patta_no)) as total_patta, count(dag_no) as total_dag from    Chitha_Basic "
                    . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no = '$loc->lot_no' "
                    . "and vill_townprt_code = '$loc->vill_townprt_code' and patta_type_code = '$patta_type' ";
            $for_village_data = $this->db->query($for_village)->row();

            $main[] = array
                (
                'bigha' => $for_village_data->bigha,
                'ktha' => $for_village_data->ktha,
                'lessa' => $for_village_data->lessa,
                'total' => $for_village_data->total,
                'patta_type' => $patta_type,
                'patta_name' => $patta_name,
                'local_tax' => $for_village_data->total_lc,
                'total_patta' => $for_village_data->total_patta,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'village_code' => $loc->vill_townprt_code,
                'village_name' => $village_name
            );
        }
        $result['result'] = $main;
        $result['_view'] = 'GenerateDoul/DoulReportPTVillage';
        $this->load->view('layouts/main',$result);
    }
    public function saveJamabandiByPattano() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('vill_townprt_code');
        $pattatypeCode = $this->input->get('patta_type');
        $patta_no = trim($this->input->get('patta_no'));
        $main = array();
        $jamainfo = array();

        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no
        );
        $this->session->set_userdata($pattatype);
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;

        $pno = trim($patta_no);
        $main['daginfo'] = array();

        $get_patta_info = "select count(*) as count from    jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno'";

        $get_patta_info = $this->db->query($get_patta_info)->row()->count;

        $pdar_alignment = '0'; //serialize by id
        if ($get_patta_info != "") {
            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
                    . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                    . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                    . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by dag_no";

            $main['daginfo'] = $this->db->query($query)->result();
            $daginfo_counted = count($main['daginfo']);

            $main['sort_pdar_by'] = $pdar_alignment;
            if ($daginfo_counted != "") {
                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by pdar_sl_no asc";
                }
                $main['pattadarinf'] = $this->db->query($query)->result();
            } else {
                //If dag and patta for old patta does not exist.
                $main['pattadarinf'] = null;
                $main['daginfo'] = null;
            }
            $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' order by rmk_line_no ";
            $main['remarkinf'] = $this->db->query($query)->result();

            $query = "select old_patta_no from    jama_patta WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' ";
            $main['oldpno'] = $this->db->query($query)->result();
            $main = array_merge($maindata, $main);
            $main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano';
            $this->load->view('layouts/main',$main);
        } else {
            $data['_view'] = 'jamabandi/no_jamabandi';
            $this->load->view('layouts/main',$data);
        }
    }

    ///////////
    public function ChangeInLandVil() {
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->get('mouza_code');      
        $postyear = year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
           'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,  
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,  
            'year' => $postyear
        );
        $location = $this->db->query("SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and mouza_pargona_code = '$mouza_code' and lot_no!='00' and Vill_townprt_code != '00000' ");    
        $location = $location->result();
        $c = '';
        foreach ($location as $loc) {
        $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $loc->lot_no, $loc->vill_townprt_code);

        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $innerquery1 = "Select dag_area_b as bigha,dag_area_k as katha,dag_area_lc as lessa from chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code='$mouza_code' and vill_townprt_code='$loc->vill_townprt_code' and chitha_update='Y' and date_entry >='2019-07-31' and date_entry <='2022-08-01' ";
            $data = $this->db->query($innerquery1)->result();
            $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->katha, $data->lessa);
            $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);

            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_code' => $loc->mouza_pargona_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'mouza_name' => $mouza_name,
                'year' => $postyear,
                'bigha' => $Total_Bigha_Katha_Lessa[0],
                'katha' => $Total_Bigha_Katha_Lessa[1],
                'lessa' => $Total_Bigha_Katha_Lessa[2],
                'village_name'=>$village_name,
            );
            $result[] = $main;
        }
        $re['result'] = $result;
        $re['_view'] = 'GenerateDoul/ChangeInLandVil';
        $this->load->view('layouts/main',$re);
    }
    function portDoul(){
        //patta_type_code!='0209' and patta_no !='0'
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
        $date=date('Y-m-d H:i:s');
        $year= doul_year_no;
        $current_year = doul_year_no;
        $this->db->trans_begin();
        $ekhajanaAction = $this->EkhajanaCoModel->updateEkhajanaBeforeDoulChange($dist_code,$subdiv_code,$cir_code,$current_year);
        if($ekhajanaAction['result'] == 'SERVER-ERROR'){
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>$ekhajanaAction['msg']));
            exit;
        }
       
        $sqlForCheck = "SELECT status FROM
                            current_doul_approve ca
                            where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        $array = $this->db->query($sqlForCheck,array($year,$dist_code,$subdiv_code,$cir_code))->row();
        if(!empty($array) && $array != null){
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'The doul data might already been submitted'));
            return;
        }
            //Revenue with 0
        // $sqlrev   = "select trim(cdp.patta_no),cdp.dag_revenue,cdp.patta_type_code from jama_dag cdp join jama_patta ct on
        //   cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code and cdp.mouza_pargona_code=ct.mouza_pargona_code
        //   and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
        //   join patta_code pp on cdp.patta_type_code=pp.type_code
        //   where pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0' and 
        // (cdp.dag_area_b*100+cdp.dag_area_k*20+cdp.dag_area_lc)>0 
        // and cdp.subdiv_code=? and cdp.cir_code=? 
        // group by trim(cdp.patta_no),cdp.patta_type_code,cdp.dist_code,
        // cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
        //  cdp.vill_townprt_code,cdp.dag_no,cdp.dag_revenue";
      $sqlrev = "select t.*,uuid from
                      (
                          Select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
         from jama_dag cdp join jama_patta ct on
                      cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                   and cdp.mouza_pargona_code=ct.mouza_pargona_code
                      and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                      join patta_code pp on cdp.patta_type_code=pp.type_code
               where cdp.dp_flag_yn is null and  pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0'  and
                 cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                   group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.cir_code,cdp.patta_type_code,cdp.dag_revenue,
         bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no) 
                    ) t join location l on 
                      t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
        $count=$this->db->query($sqlrev,array($subdiv_code,$cir_code));
        $count->num_rows();
        if($count->num_rows()>0){
                $this->db->trans_rollback();
                echo json_encode(array('val'=>1,'msg'=>'Error(#009) A Few Dag(s) may be present with revenue zero. Please check and update'));
                return;
        }
        //////////////exit from loop//////////////////
        $ip = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
        $sql="Select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?";
        $sqlResult=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00','00'))->result_array();
        $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();
       
        foreach($sqlResult as $m){
            $mouza_code=$m['mouza_pargona_code'];
            $sql="Select  * from current_doul_demand where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and year_no = ?";
            $num_rows=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$year))->num_rows();
            if($num_rows==0){
                foreach($patta_type as $p_type)
                {  
                $comma = ",";                  
                     $sqlPatta="select t.*,uuid from
                      (
                          Select dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                            vill_townprt_code,trim(patta_no) as patta_no,patta_type_code,sum(round(dag_revenue,2)) as dag_revenue,
                            sum(round(dag_localtax,2)) as dag_local_tax,
                            sum(dag_area_b) as dag_area_b,
                            sum(dag_area_k) as dag_area_k,
                            sum(dag_area_lc) as dag_area_lc,
                            '$date' as date_of_creation , 
                            '$year' as year_no,'$user_code' as port_by_user,'$ip' as port_ip
                          from jama_dag where dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and patta_type_code='$p_type->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and mouza_pargona_code='$mouza_code' 
                              and entry_date <= '$this->doul_date' and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0  
                              and (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                                (
                                  select lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,
                                     trim(patta_no) from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and entry_date <= '$this->doul_date' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and patta_type_code='$p_type->type_code' group by lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)
                               )
                               
                          group by dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(patta_no),patta_type_code
                      ) 
                      t join location l on 
                      t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
               
                $result= $this->db->query($sqlPatta);
                if ($result==null || $result->num_rows()<=0)
                    continue;
                $resultt = $result->result_array();
                $tstaus=$this->db->insert_batch('current_doul_demand',$resultt);
                //log_message('error',' ptype='.$p_type->type_code);
                if($tstaus!=1){
                    $this->db->trans_rollback();
                    //log_message('error',$this->db->last_query());
                    echo json_encode(array('success'=>false,'msg'=>'Error(#001) in doul submission'));
                    return;
                }
              }
            }else{     
                $this->db->trans_rollback();      
                echo json_encode(array('success'=>false,'msg'=>'The doul data might already been submitted'));
                return;
            }
        }
        $this->db->where('dag_local_tax',null);
        $this->db->update('current_doul_demand',array('dag_local_tax'=>0));
        ////////////18-03-23///////////////
        $params=[
            'dist_code'         =>$dist_code,
            'subdiv_code'       =>$subdiv_code,
            'cir_code'          =>$cir_code,
            'co_code'           =>$user_code,
            'co_submission_date'=>date('Y-m-d'),
            'status'            =>'P',  
            'yeardoul'          =>doul_year_no
        ];
        $this->db->insert('current_doul_approve',$params);
        if($this->db->affected_rows() !=1){
            log_message('error',$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'Error(#003) in doul submission'));
            return;
        }
        if($this->db->trans_status() == true){
           $this->db->trans_commit();
            echo json_encode(array('success'=>true));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>' Error(#002) in doul submission'));
            return;
        }
       
    }

    function portDpDoul(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
        $date=date('Y-m-d H:i:s');
        $year=  doul_year_no;
        $current_year = doul_year_no;
        $this->db->trans_begin();
        $ekhajanaAction = $this->EkhajanaAdcModel->updateEkhajanaBeforeDoulChange($dist_code,$subdiv_code,$cir_code,$current_year);
        if($ekhajanaAction['result'] == 'SERVER-ERROR'){
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>$ekhajanaAction['msg']));
            exit;
        }
        $sqlForCheck = "SELECT status FROM
                            current_dp_doul_approve ca
                            where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        $array = $this->db->query($sqlForCheck,array($year,$dist_code,$subdiv_code,$cir_code))->row();
        if(!empty($array) && $array != null){
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'The DP doul data might already been submitted'));
            return;
        }
        $sqlrev = "select t.*,uuid from
                      (
                          Select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
         from jama_dag cdp join jama_patta ct on
                      cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                   and cdp.mouza_pargona_code=ct.mouza_pargona_code
                      and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                      join patta_code pp on cdp.patta_type_code=pp.type_code
               where cdp.dp_flag_yn='Y' and  pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0'  and
                 cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                   group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.cir_code,cdp.patta_type_code,cdp.dag_revenue,
         bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no) 
                    ) t join location l on 
                      t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
        $count=$this->db->query($sqlrev,array($subdiv_code,$cir_code));
        // log_message('error',$this->db->last_query());
        $count->num_rows();
        if($count->num_rows()>0){
                $this->db->trans_rollback();
                echo json_encode(array('val'=>1,'msg'=>'Error(#009) A Few Dag(s) may be present with revenue zero. Please check and update'));
                return;
        }
        //////////////exit from loop//////////////////
        $ip = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
        $sql="Select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?";
        $sqlResult=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00','00'))->result_array();
        $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();
       
        foreach($sqlResult as $m){
            $mouza_code=$m['mouza_pargona_code'];
            $sql="Select  * from current_dp_doul_demand where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and year_no = ?";
            $num_rows=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$year))->num_rows();
            if($num_rows==0){
                foreach($patta_type as $p_type)
                {  
                $comma = ",";                  
                $sqlPatta="select t.*,uuid,case 
                when t.dag_area_b >= 10 then (t.dag_revenue*.3)
                else 0 
                end as surcharge 
            from 
            (
                Select dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                  vill_townprt_code,trim(patta_no) as patta_no,patta_type_code,sum(round(dag_revenue,2)) as dag_revenue,
                  sum(round(dag_localtax,2)) as dag_local_tax,
                  sum(dag_area_b) as dag_area_b,
                  sum(dag_area_k) as dag_area_k,
                  sum(dag_area_lc) as dag_area_lc,
                  '$date' as date_of_creation , 
                  '$year' as year_no,'$user_code' as port_by_user,'$ip' as port_ip
                from jama_dag where dp_flag_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and patta_type_code='$p_type->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and mouza_pargona_code='$mouza_code' 
                    and entry_date <= '$this->doul_date' and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0  
                    and (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                      (
                        select lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,
                           trim(patta_no) from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and entry_date <= '$this->doul_date' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and patta_type_code='$p_type->type_code' group by lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)
                     )
                     
                group by dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(patta_no),patta_type_code
            ) 
            t join location l on 
            t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
              and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
               
                $result= $this->db->query($sqlPatta);
                if ($result==null || $result->num_rows()<=0)
                    continue;
                $resultt = $result->result_array();
                $tstaus=$this->db->insert_batch('current_dp_doul_demand',$resultt);
                //log_message('error',' ptype='.$p_type->type_code);
                if($tstaus!=1){
                    $this->db->trans_rollback();
                    log_message('error',$this->db->last_query());
                    echo json_encode(array('success'=>false,'msg'=>'Error(#001) in DP doul submission'));
                    return;
                }
              }
            }else{     
                $this->db->trans_rollback();      
                echo json_encode(array('success'=>false,'msg'=>'The DP doul data might already been submitted'));
                return;
            }
        }
        ///////////////
        $this->db->where('dag_local_tax',null);
        $this->db->update('current_dp_doul_demand',array('dag_local_tax'=>0));
        ////////////18-03-23///////////////
         $params=[
            'dist_code'         =>$dist_code,
            'subdiv_code'       =>$subdiv_code,
            'cir_code'          =>$this->session->userdata('cir_code'),
            'co_code'           =>$user_code,
            'co_submission_date'=>date('Y-m-d'),
            'status'            =>'P',
            'yeardoul'          =>$year
         ];
         $this->db->insert('current_dp_doul_approve',$params);
         if($this->db->affected_rows() !=1){
           log_message('error',$this->db->last_query());
           $this->db->trans_rollback();
           echo json_encode(array('success'=>false,'msg'=>'Error(#003) in DP doul submission'));
           return;
         }
        //**************************************//
        if($this->db->trans_status() == true){
            $this->db->trans_commit();
             echo json_encode(array('success'=>true));
             return;
         }else{
             $this->db->trans_rollback();
             echo json_encode(array('success'=>false, 'msg'=>' Error(#002) in DP doul submission'));
             return;
         }
    }


      public function updateDagRevenueZero()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        
        $data['villages'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['_view'] = 'GenerateDoul/updateDagRevenueZero';
        $this->load->view('layouts/main',$data);
    }
       public function getAllDagsVillage()
    {
         $dist_code = $this->input->post('dist_code');
         $subdiv_code = $this->input->post('subdiv_code');
         $cir_code = $this->input->post('cir_code');
         $mouza_pargona_code = $this->input->post('mouza_pargona_code');
         $lot_no = $this->input->post('lot_no');
         $vill_townprt_code = $this->input->post('vill_townprt_code');
         $data['_view'] = 'GenerateDoul/updateDagRevenueZero';
         $this->load->view('layouts/main',$data);
    }
    public function getAllZeroDags(){
      $dist_code = $this->session->userdata('dist_code');
      $subdiv_code = $this->session->userdata('subdiv_code');
      $cir_code = $this->session->userdata('cir_code');
      // $sqlDagsDetails="select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
      //    cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
      //    dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
      //                   dag_localtax,dag_class_code 
      //    from jama_dag cdp join jama_patta ct on
      //                 cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
      //              and cdp.mouza_pargona_code=ct.mouza_pargona_code
      //                 and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
      //                 join patta_code pp on cdp.patta_type_code=pp.type_code
      //                 where pp.jamabandi='y' and (cdp.dag_revenue='0' or cdp.dag_localtax='0')  and cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
      //              group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
      //    cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
      //    bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no)";

      $sqlDagsDetails = "select t.*,uuid from
                      (select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
         from jama_dag cdp join jama_patta ct on
                      cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                   and cdp.mouza_pargona_code=ct.mouza_pargona_code
                      and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                      join patta_code pp on cdp.patta_type_code=pp.type_code
                      where cdp.dp_flag_yn is null and pp.jamabandi='y' and (cdp.dag_revenue='0' or cdp.dag_localtax='0')  and cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                   group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no)) t join location l on 
                      t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
       $zero_revenue_dags=$this->db->query($sqlDagsDetails,array($subdiv_code,$cir_code))->result();
       $result=array();
       foreach ($zero_revenue_dags as $key => $value) {
               // if($value->patta_type_code == '0205' || $value->patta_type_code =='0208'){
               //    continue;
               // }
                $get_total_lessa = $this->utilityclass->Total_Lessa($value->bigha, $value->ktha, $value->lessa);
                $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                $land_class_name = $this->utilityclass->getLandClassCode($value->dag_class_code);
                $patta_name = $this->utilityclass->getPattaType($value->patta_type_code); 
                $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
                $village_name = $this->utilityclass->getVillageNameByruralUrban($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code);
                $Type = ( $village_name->rural_urban=='R') ? 'Rural' : 'Urban';
                $main = array
                    (
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_name' => $mouza_name,
                    'mouza_code' => $value->mouza_pargona_code,
                    'lot_no' => $value->lot_no,
                    'village_name' => $village_name->village,
                    'village_type' => $Type,
                    'vill_townprt_code' => $value->vill_townprt_code,
                    'dag_no' => $value->dag_no,
                    'patta_no' => $value->patta_no,
                    'land_class' => $value->dag_class_code,
                    'bigha' =>  $value->bigha,
                    'ktha' =>   $value->ktha,
                    'lessa' =>   $value->lessa,
                    'total_lessa' => $get_total_lessa,
                    'dag_revenue' =>  $value->dag_revenue,
                    'local_tax' =>  $value->dag_localtax,
                    'land_class_name' => $land_class_name,
                    'patta_name' => $patta_name,
                    'patta_type_code' => $value->patta_type_code,
                );
                $result[] = $main;
            }
            $data['zero_revenue_dags'] = $result;
       
       $data['_view'] = 'GenerateDoul/updateDagRevenueZero';
       $this->load->view('layouts/main',$data);
    }
   // public function doulapprove(){
   //    $year=year_no;
   //    $sql="SELECT cd.subdiv_code,cd.cir_code,cd.mouza_pargona_code,sum(dag_revenue),sum(dag_local_tax) 
   //    FROM current_doul_demand cd join 
   //    current_doul_approve ca on cd.dist_code=ca.dist_code and cd.subdiv_code=ca.subdiv_code and cd.cir_code=ca.cir_code
   //    where ca.status ='P'
   //    group by cd.subdiv_code,cd.cir_code,cd.mouza_pargona_code";
   //    $data['_view'] = 'GenerateDoul/updateDagRevenueZero';
   //    $this->load->view('layouts/main',$data);
   //  }
    public function viewDoulInDC(){
      if($this->session->userdata('user_desig_code')!='DC'){
         echo "<p class='text-danger'>Error. You are not authorized</p>";
         return;
      }
      $year=doul_year_no;
      $sql="select dc_adc_remark,dc_adc_approve_date,status,yeardoul, dist_code,subdiv_code,cir_code,(select loc_name from location where dist_code=cda.dist_code and subdiv_code=cda.subdiv_code and 
            cir_code=cda.cir_code 
                and mouza_pargona_code ='00'and lot_no='00' and Vill_townprt_code = '00000')
            from current_doul_approve cda where yeardoul = ?";
      $data['doulData'] = $doulData = $this->db->query($sql,array($year))->result();
    //   var_dump($data['doulData']);exit;
      $data['_view'] = 'GenerateDoul/viewDoulDC';
      $this->load->view('layouts/main',$data);

    }

    public function viewDpDoulInDC(){
        if($this->session->userdata('user_desig_code')!='DC'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $year=doul_year_no;
        $sql="select dc_adc_remark,dc_adc_approve_date,status,yeardoul, dist_code,subdiv_code,cir_code,(select loc_name from location where dist_code=cda.dist_code and subdiv_code=cda.subdiv_code and 
            cir_code=cda.cir_code 
                and mouza_pargona_code ='00'and lot_no='00' and Vill_townprt_code = '00000')
            from current_dp_doul_approve cda where yeardoul = ?";
        $data['doulData'] = $doulData = $this->db->query($sql,array($year))->result();

        echo "<pre>";
        echo "</pre>";
        
        $data['_view'] = 'GenerateDoul/viewDpDoulDC';
        $this->load->view('layouts/main',$data);
    }

    public function CircleWiseDoulViewDC() {
        if($this->session->userdata('user_desig_code')!='DC'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $dist_code = $this->session->userdata('dist_code');
        $postyear = doul_year_no;
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $re = array(
            'dist_code'     => $dist_code,
            'subdiv_code'   => $subdiv_code,
            'cir_code'      => $circle_code,
            'dist_name'     => $districtdata,
            'subdiv_name'   => $subdivdata,
            'cir_name'      => $circledata,
            'year'          => $postyear
        );
        $result =array();
        $re['FinalStatus'] = null;
        $sqlForCheck = "SELECT status FROM
                            current_doul_approve ca
                            where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->result();
         
        if(!empty($array) && $array != null){
        $re['FinalStatus'] = $array[0]->status;
        }
        if(sizeof($array) > 0){
            $t_bigha = $t_katha=$t_lessa=$t_dag_revenue=$t_dag_localtax=$t_patta_no_count=0;
            $innerquery1 = "SELECT sum(dag_area_b) as t_bigha,sum(dag_area_k) as t_katha,sum(dag_area_lc) 
                                as t_lessa,sum(dag_area_g) 
                                as t_gonda,cd.subdiv_code,cd.cir_code,cd.mouza_pargona_code,sum(dag_revenue) as dag_revenue ,sum(dag_local_tax)  as dag_local_tax
                            FROM current_doul_demand cd join 
                            current_doul_approve ca on 
                            cd.dist_code=ca.dist_code and 
                            cd.subdiv_code=ca.subdiv_code and 
                            cd.cir_code=ca.cir_code
                            where ca.status in('P','A') and ca.yeardoul = ?  and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?
                            group by cd.subdiv_code,cd.cir_code,cd.mouza_pargona_code";
                $data = $this->db->query($innerquery1,array($postyear,$dist_code,$subdiv_code,$circle_code))->result();
                foreach ($data  as $key => $data) {
                   $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $data->mouza_pargona_code);
                   $t_bigha= $data->t_bigha;
                   $t_katha= $data->t_katha;
                   $t_lessa= $data->t_lessa;
                   $t_gonda= $data->t_gonda;
                  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                     $get_total_lessa = $this->utilityclass->Total_ganda($t_bigha, $t_katha, $t_lessa,$t_gonda);
                     $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
                  }else{
                     $get_total_lessa = $this->utilityclass->Total_Lessa($t_bigha, $t_katha, $t_lessa);
                     $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                  }

                  $main = array
                      (
                      'dist_code' => $dist_code,
                      'subdiv_code' => $subdiv_code,
                      'cir_code' => $circle_code,
                      'mouza_code' => $data->mouza_pargona_code,
                      'dist_name' => $districtdata,
                      'subdiv_name' => $subdivdata,
                      'cir_name' => $circledata,
                      'mouza_name' => $mouza_name,
                      'year' => $postyear,
                      'bigha' => $Total_Bigha_Katha_Lessa[0],
                      'ktha' => $Total_Bigha_Katha_Lessa[1],
                      'lessa' => $Total_Bigha_Katha_Lessa[2],
                      'gonda' => $Total_Bigha_Katha_Lessa[3],
                      'total_lessa' => $get_total_lessa,
                      'dag_revenue' => $data->dag_revenue,
                      'local_tax' => $data->dag_local_tax,
                  );
                  $result[] = $main;
                }

             }else{
               $result= null;
             }
        $re['result'] = $result;
        $re['_view'] = 'GenerateDoul/CircleWiseDoulDC';
        $this->load->view('layouts/main',$re);
    }

    public function CircleWiseDpDoulViewDC() {
        
        if($this->session->userdata('user_desig_code')!='DC'){
           echo "<p class='text-danger'>Error. You are not authorized</p>";
           return;
        }
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $dist_code = $this->session->userdata('dist_code');
        $postyear = doul_year_no;
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'year' => $postyear
        );
       
        $result =array();
        $re['FinalStatus'] = null;
        $sqlForCheck = "SELECT status FROM
                             current_dp_doul_approve ca
                             where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->result();
        if(!empty($array) && $array != null){
           $re['FinalStatus'] = $array[0]->status;
        }
        
        if(sizeof($array) > 0){
              $t_bigha = $t_katha=$t_lessa=$t_dag_revenue=$t_dag_localtax=$t_patta_no_count=0;
              $innerquery1 = "SELECT sum(dag_area_b) as t_bigha,sum(dag_area_k) as t_katha,sum(dag_area_lc) 
                                as t_lessa,sum(dag_area_g) 
                                as t_gonda,cd.subdiv_code,cd.cir_code,cd.mouza_pargona_code,sum(dag_revenue) as dag_revenue ,sum(dag_local_tax)  as dag_local_tax,sum(surcharge) as surcharge
                             FROM current_dp_doul_demand cd join 
                             current_dp_doul_approve ca on 
                             cd.dist_code=ca.dist_code and 
                             cd.subdiv_code=ca.subdiv_code and 
                             cd.cir_code=ca.cir_code
                             where ca.status in('P','A') and ca.yeardoul = ?  and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?
                             group by cd.subdiv_code,cd.cir_code,cd.mouza_pargona_code";
               $data = $this->db->query($innerquery1,array($postyear,$dist_code,$subdiv_code,$circle_code))->result();
              // var_dump($this->db->last_query());exit;
               foreach ($data  as $key => $data) {
                  $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $data->mouza_pargona_code);
                  $t_bigha= $data->t_bigha;
                  $t_katha= $data->t_katha;
                  $t_lessa= $data->t_lessa;
                  $t_gonda= $data->t_gonda;
                 if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $get_total_lessa = $this->utilityclass->Total_ganda($t_bigha, $t_katha, $t_lessa,$t_gonda);
                    $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
                 }else{
                    $get_total_lessa = $this->utilityclass->Total_Lessa($t_bigha, $t_katha, $t_lessa);
                    $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                 }

                 $main = array
                     (
                     'dist_code' => $dist_code,
                     'subdiv_code' => $subdiv_code,
                     'cir_code' => $circle_code,
                     'mouza_code' => $data->mouza_pargona_code,
                     'dist_name' => $districtdata,
                     'subdiv_name' => $subdivdata,
                     'cir_name' => $circledata,
                     'mouza_name' => $mouza_name,
                     'year' => $postyear,
                     'bigha' => $Total_Bigha_Katha_Lessa[0],
                     'ktha' => $Total_Bigha_Katha_Lessa[1],
                     'lessa' => $Total_Bigha_Katha_Lessa[2],
                     'gonda' => $Total_Bigha_Katha_Lessa[3],
                     'total_lessa' => $get_total_lessa,
                     'dag_revenue' => $data->dag_revenue,
                     'local_tax' => $data->dag_local_tax,
                     'surcharge' => $data->surcharge,
                 );
                 $result[] = $main;
               }

            }else{
              $result= null;
            }
       $re['result'] = $result;
       $re['_view'] = 'GenerateDoul/CircleWiseDpDoulDC';
       $this->load->view('layouts/main',$re);
    }

    public function doulApproveByDC(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
         
        $first_year = (doul_year_no -1) ;
        $second_year = doul_year_no ;

        $year = doul_year_no;
        $prevous_year1 = strval($year -2);
        $previous_year = strval($year -1);
        $revenue_year = $prevous_year1.'-'. $previous_year;
       
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $dist_code   = $this->input->post('dist_code');
        $remark      = $this->input->post('remark');
        if($remark == null){
        echo json_encode(array('success'=>false, 'msg'=>' Error(#087) Remark field is mandatory'));
        return;
        }
        $this->db->trans_begin();
        $doulCase = "DOUL/".$dist_code."/".$subdiv_code."/".$circle_code."/".$year;
        $where = " case_no = '".$doulCase."'";
        $maxid = $this->max_id('petition_proceeding_dc_adc', $where,'proceeding_id');
        $params = array(
            'case_no'         => $doulCase,
            'proceeding_id'   => $maxid,
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'co_order'        => $remark,
            'status'          => 'A',
            'user_code'       => $this->session->userdata('user_code'),
            'date_entry'      => date('Y-m-d H:i:s'),
            'operation'       => 'E',
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $circle_code
        );
        $insertStatus = $this->db->insert('petition_proceeding_dc_adc',$params);
        if($insertStatus != 1){
            log_message('error',$this->db->last_query());
            log_message('error',"Error(#00101) INSERTION FAILED IN petition_proceeding_dc_adc TABLE");
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'Error(#00101) in doul Approval'));
            return;
        }

        //**************************************//
        $updateEkhajana = $this->EkhajanaCoModel->updateEkhajanaAfterDoulChange($dist_code,$subdiv_code,$circle_code,$year);
        if($updateEkhajana['result'] == 'SERVER-ERROR'){
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'msg' => $updateEkhajana['msg']));
            exit;
        }
        //checking all the rows updated or not in jama wasil before commm;it 
        $sql = "select count(*) from jama_wasil where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
        and cir_code='$circle_code' and (dol_year_no= '$previous_year' or financial_year= '$revenue_year' )";
        $jama_wasil_updated_count = $this->db->query($sql)->row()->count;
        log_message('error','updated jama wasil count'.$jama_wasil_updated_count);
        if($jama_wasil_updated_count != 0){
            $this->db->trans_rollback();
            log_message('error', '#EKHDOULNU001, all the rows in jama wasil not updated for '.$dist_code.$subdiv_code.$circle_code);
            echo json_encode(array('success'=>false, 'msg'=>' Error(#003) in doul submission'));
            exit;
        }

        $this->db->where('dist_code',$dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('cir_code',$circle_code);
        $this->db->where('yeardoul',$year);
        $this->db->update('current_doul_approve',
        array(
            'status'              =>'A',
            'dc_adc_approve_date' => date('Y-m-d'),
            'dc_adc_code'         => $this->session->userdata('user_code'),
            'dc_adc_remark'       => $remark
        )
        );
        if($this->db->affected_rows() != 1){
            log_message('error',$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'Error(#0098) in doul Approval'));
            return;
        }
        if($this->db->trans_status()===true){
            $this->db->trans_commit();
            echo json_encode(array('success'=>true,'msg'=> "RES(#001) Doul approved for the session ".$first_year.'-'.$second_year));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>' Error(#099) Something went wrong!!!'));
            return;
        }

    }


    public function dpDoulApproveByDC(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $first_year = (doul_year_no -1) ;
        $second_year = doul_year_no ;

        $year=doul_year_no;
        $prevous_year1 = strval($year -2);
        $previous_year = strval($year -1);
        $revenue_year = $prevous_year1.'-'. $previous_year;

        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $dist_code   = $this->input->post('dist_code');
        $remark      = $this->input->post('remark');
        if($remark == null){
           echo json_encode(array('success'=>false, 'msg'=>' Error(#087) Remark field is mandatory'));
           return;
        }
        $this->db->trans_begin();
        $doulCase = "DP-DOUL/".$dist_code."/".$subdiv_code."/".$circle_code."/".$year;
        $where = " case_no = '".$doulCase."'";
        $maxid = $this->max_id('petition_proceeding_dc_adc', $where,'proceeding_id');
        $params = array(
           'case_no'         => $doulCase,
           'proceeding_id'   => $maxid,
           'date_of_hearing' => date('Y-m-d H:i:s'),
           'co_order'        => $remark,
           'status'          => 'A',
           'user_code'       => $this->session->userdata('user_code'),
           'date_entry'      => date('Y-m-d H:i:s'),
           'operation'       => 'E',
           'dist_code'       => $dist_code,
           'subdiv_code'     => $subdiv_code,
           'cir_code'        => $circle_code
        );
        $insertStatus = $this->db->insert('petition_proceeding_dc_adc',$params);
        if($insertStatus != 1){
           log_message('error',$this->db->last_query());
           log_message('error',"Error(#00101) INSERTION FAILED IN petition_proceeding_dc_adc TABLE");
           $this->db->trans_rollback();
           echo json_encode(array('success'=>false,'msg'=>'Error(#00101) in doul Approval'));
           return;
        }

        //**************************************//
        $updateEkhajana = $this->EkhajanaAdcModel->updateEkhajanaAfterDoulChange($dist_code,$subdiv_code,$circle_code,$year);
        if($updateEkhajana['result'] == 'SERVER-ERROR'){
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'msg' => $updateEkhajana['msg']));
            exit;
        }
        //checking all the rows updated or not in jama wasil before commm;it 
        $sql = "select count(*) from jama_wasil where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
        and cir_code='$circle_code' and (dol_year_no= '$previous_year' or financial_year= '$revenue_year' )";
        $jama_wasil_updated_count = $this->db->query($sql)->row()->count;
        log_message('error','updated jama wasil count'.$jama_wasil_updated_count);
        if($jama_wasil_updated_count != 0){
            $this->db->trans_rollback();
            log_message('error', '#EKHDOULNU001, all the rows in jama wasil not updated for '.$dist_code.$subdiv_code.$circle_code);
            echo json_encode(array('success'=>false, 'msg'=>' Error(#003) in doul submission'));
            exit;
        }

        $this->db->where('dist_code',$dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('cir_code',$circle_code);
        $this->db->where('yeardoul',$year);
        $this->db->update('current_dp_doul_approve',
           array(
              'status'=>'A',
              'dc_adc_approve_date' => date('Y-m-d'),
              'dc_adc_code'         => $this->session->userdata('user_code'),
              'dc_adc_remark'       => $remark
           )
        );
        if($this->db->affected_rows() != 1){
          log_message('error',$this->db->last_query());
          $this->db->trans_rollback();
          echo json_encode(array('success'=>false,'msg'=>'Error(#0098) in doul Approval'));
          return;
        }
       if($this->db->trans_status()===true){
           $this->db->trans_commit();
           echo json_encode(array('success'=>true,'msg'=> "RES(#001) Doul approved for the session ".$year . '-' . (date('Y') + 1)));
           return;
       }else{
           $this->db->trans_rollback();
           echo json_encode(array('success'=>false, 'msg'=>' Error(#099) Something went wrong!!!'));
           return;
       }

   }


    public function doulRejectByDC(){
         $year=doul_year_no;
         $first_year = (doul_year_no -1) ;
         $second_year = doul_year_no ;
         $subdiv_code = $this->input->post('subdiv_code');
         $circle_code = $this->input->post('cir_code');
         $dist_code   = $this->input->post('dist_code');
         $remark      = $this->input->post('remark');
         if($remark == null){
            echo json_encode(array('success'=>false, 'msg'=>' Error(#087) Remark field is mandatory'));
            return;
         }
         $doulCase = "DOUL/".$dist_code."/".$subdiv_code."/".$circle_code."/".$year;
         $where = " case_no = '".$doulCase."'";
         $maxid = $this->max_id('petition_proceeding_dc_adc', $where,'proceeding_id');
         $params = array(
            'case_no'         => $doulCase,
            'proceeding_id'   => $maxid,
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'co_order'        => $remark,
            'status'          => 'R',
            'user_code'       => $this->session->userdata('user_code'),
            'date_entry'      => date('Y-m-d H:i:s'),
            'operation'       => 'E',
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $circle_code
         );
         $insertStatus = $this->db->insert('petition_proceeding_dc_adc',$params);
         if($insertStatus != 1){
            log_message('error',$this->db->last_query());
            log_message('error',"Error(#00101) INSERTION FAILED IN petition_proceeding_dc_adc TABLE");
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'Error(#00101) in doul Rejection'));
            return;
         }


         $this->db->trans_begin();
         $this->db->where('dist_code',$dist_code);
         $this->db->where('subdiv_code',$subdiv_code);
         $this->db->where('cir_code',$circle_code);
         $this->db->where('yeardoul',$year);
         $this->db->update('current_doul_approve',
            array(
               'status'=>'R',
               'dc_adc_approve_date' => date('Y-m-d'),
               'dc_adc_code'         => $this->session->userdata('user_code'),
               'dc_adc_remark'       => $remark
            )
         );
         if($this->db->affected_rows() != 1){
           log_message('error',$this->db->last_query());
           $this->db->trans_rollback();
           echo json_encode(array('success'=>false,'msg'=>'Error(#0098) in doul Revert'));
           return;
         }
        if($this->db->trans_status()===true){
            $this->db->trans_commit();
            echo json_encode(array('success'=>true,'msg'=> "RES(#001) Doul Reverted for the session ". $first_year . '-' . $second_year));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>' Error(#099) Something went wrong!!!'));
            return;
        }

    }

    public function dpDoulRejectByDC(){
        $year=doul_year_no;
         $subdiv_code = $this->input->post('subdiv_code');
         $circle_code = $this->input->post('cir_code');
         $dist_code   = $this->input->post('dist_code');
         $remark      = $this->input->post('remark');
         if($remark == null){
            echo json_encode(array('success'=>false, 'msg'=>' Error(#087) Remark field is mandatory'));
            return;
         }
         $doulCase = "DP-DOUL/".$dist_code."/".$subdiv_code."/".$circle_code."/".$year;
         $where = " case_no = '".$doulCase."'";
         $maxid = $this->max_id('petition_proceeding_dc_adc', $where,'proceeding_id');
         $params = array(
            'case_no'         => $doulCase,
            'proceeding_id'   => $maxid,
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'co_order'        => $remark,
            'status'          => 'R',
            'user_code'       => $this->session->userdata('user_code'),
            'date_entry'      => date('Y-m-d H:i:s'),
            'operation'       => 'E',
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $circle_code
         );
         $insertStatus = $this->db->insert('petition_proceeding_dc_adc',$params);
         if($insertStatus != 1){
            log_message('error',$this->db->last_query());
            log_message('error',"Error(#00101) INSERTION FAILED IN petition_proceeding_dc_adc TABLE");
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'Error(#00101) in doul Rejection'));
            return;
         }


         $this->db->trans_begin();
         $this->db->where('dist_code',$dist_code);
         $this->db->where('subdiv_code',$subdiv_code);
         $this->db->where('cir_code',$circle_code);
         $this->db->where('yeardoul',$year);
         $this->db->update('current_dp_doul_approve',
            array(
               'status'=>'R',
               'dc_adc_approve_date' => date('Y-m-d'),
               'dc_adc_code'         => $this->session->userdata('user_code'),
               'dc_adc_remark'       => $remark
            )
         );
         if($this->db->affected_rows() != 1){
           log_message('error',$this->db->last_query());
           $this->db->trans_rollback();
           echo json_encode(array('success'=>false,'msg'=>'Error(#0098) in doul Revert'));
           return;
         }
        if($this->db->trans_status()===true){
            $this->db->trans_commit();
            echo json_encode(array('success'=>true,'msg'=> "RES(#001) Doul Reverted for the session ".$year . '-' . (date('Y') + 1)));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>' Error(#099) Something went wrong!!!'));
            return;
        }
    }

    function regenerateDoul(){
        //patta_type_code!='0209' and patta_no !='0'
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        // $mouza_code=$this->input->get('mouza_code');
        $user_code=$this->session->userdata('user_code');
        $date=date('Y-m-d H:i:s');
        $year=doul_year_no;

        $sqlForCheck = "SELECT status FROM
                              current_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $array = $this->db->query($sqlForCheck,array($year,$dist_code,$subdiv_code,$cir_code))->row();
         if(isset($array->status) && $array->status == 'R'){

            //FIRST DELETE FROM TWO TABLES-----current doul approve and current doul demand----
            $this->db->trans_begin();
            $deletecurrentapprove="delete from current_doul_approve where dist_code = ? and subdiv_code=? and cir_code=? and yeardoul = ?";
            $DeleteStatus1=$this->db->query($deletecurrentapprove,array($dist_code,$subdiv_code,$cir_code,$year));
            if($this->db->affected_rows() != 1){ 
              $this->db->trans_rollback();
              log_message("error", "#Error(#0025), Error in delete, table 'current_doul_approve'");
              echo json_encode(array('success'=>false,'msg'=>'Error(#0025) in doul regeneration'));
                    return;
            }



            $deletecurrentdemand="delete from current_doul_demand where dist_code = ? and subdiv_code=? and cir_code=? and year_no = ?";
            $DeleteStatus2=$this->db->query($deletecurrentdemand,array($dist_code,$subdiv_code,$cir_code,$year));
            if($this->db->affected_rows() <= 0){ 
              $this->db->trans_rollback();
              log_message("error", "#Error(#0026), Error in delete, table 'current_doul_demand'");
              echo json_encode(array('success'=>false,'msg'=>'Error(#0026) in doul regeneration'));
                    return;
            }


           // $sqlrev="select cdp.patta_no,sum(cdp.dag_revenue) from jama_dag cdp join jama_patta ct on
           //   cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code and cdp.mouza_pargona_code=ct.mouza_pargona_code
           //   and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
           //   join patta_code pp on cdp.patta_type_code=pp.type_code
           //   where pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0' and (cdp.dag_area_b*100+cdp.dag_area_k*20+cdp.dag_area_lc)>0 and cdp.subdiv_code=? and cdp.cir_code=? group by cdp.patta_no";

         $sqlrev   = "select t.*,uuid from
                      (
                          Select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
         from jama_dag cdp join jama_patta ct on
                      cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                   and cdp.mouza_pargona_code=ct.mouza_pargona_code
                      and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                      join patta_code pp on cdp.patta_type_code=pp.type_code
                      where cdp.dp_flag_yn is null and  pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0'  and
                 cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                   group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.cir_code,cdp.patta_type_code,cdp.dag_revenue,
         bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no) 
                    ) t join location l on 
                      t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
           $count=$this->db->query($sqlrev,array($subdiv_code,$cir_code));
           // log_message('error',$this->db->last_query());
           $count->num_rows();
           if($count->num_rows()>0){
                   echo json_encode(array('val'=>1,'msg'=>'Error(#0020) A Few Dag(s) may be present with revenue zero. Please check and update'));
                   return;
           }
           //////////////exit from loop//////////////////
           $ip = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
           $sql="Select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=? and (nc_btad is null or nc_btad='e') ";
           $sqlResult=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00','00'))->result_array();
           $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();
           
           foreach($sqlResult as $m){
               $mouza_code=$m['mouza_pargona_code'];
               $sql="Select  * from current_doul_demand where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and year_no = ? ";
               $num_rows=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$year))->num_rows();
               if($num_rows==0){
                   foreach($patta_type as $p_type)
                   {          
                   $comma = ",";            
                        $sqlPatta="select t.*,uuid from
                         (
                             Select dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                               vill_townprt_code,trim(patta_no) as patta_no,patta_type_code,sum(round(dag_revenue,2)) as dag_revenue,
                               sum(round(dag_localtax,2)) as dag_local_tax,
                               sum(dag_area_b) as dag_area_b,
                               sum(dag_area_k) as dag_area_k,
                               sum(dag_area_lc) as dag_area_lc,
                               '$date' as date_of_creation , 
                               '$year' as year_no,'$user_code' as port_by_user,'$ip' as port_ip
                               from jama_dag where dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and patta_type_code='$p_type->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and mouza_pargona_code='$mouza_code' 
                                 and entry_date <= '$this->doul_date' and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0  
                                 and (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                                   (
                                     select lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,
                                        trim(patta_no) from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and entry_date <= '$this->doul_date' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and patta_type_code='$p_type->type_code' group by lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)
                                  )
                                  
                             group by dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(patta_no),patta_type_code
                         ) 
                         t join location l on 
                         t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                           and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
                   $result= $this->db->query($sqlPatta);
                   if ($result==null || $result->num_rows()<=0)
                       continue;
                   $resultt = $result->result_array();
                   $tstaus=$this->db->insert_batch('current_doul_demand',$resultt);
                   //log_message('error',' ptype='.$p_type->type_code);
                   if($tstaus!=1){
                       $this->db->trans_rollback();
                       log_message('error',$this->db->last_query());
                       echo json_encode(array('success'=>false,'msg'=>'Error(#0021) in doul submission'));
                       return;
                   }
                 }
               }else{                
                   echo json_encode(array('success'=>false,'msg'=>'The doul data might already been submitted'));
                   return;
               }
           }
           ///////////////
           $this->db->where('dag_local_tax',null);
           $this->db->update('current_doul_demand',array('dag_local_tax'=>0));
           ////////////18-03-23///////////////
            $params=[
            'dist_code'=>$dist_code,
            'subdiv_code'=>$subdiv_code,
            'cir_code'=>$this->session->userdata('cir_code'),
            'co_code'=>$user_code,
            'co_submission_date'=>date('Y-m-d'),
            'status'=>'P',
            'yeardoul' =>$year
            ];
            $this->db->insert('current_doul_approve',$params);
            if($this->db->affected_rows() !=1){
              log_message('error',$this->db->last_query());
              $this->db->trans_rollback();
              echo json_encode(array('success'=>false,'msg'=>'Error(#0022) in doul submission'));
              return;
            }
           //////////////
            if($this->db->trans_status()===true){
               $this->db->trans_commit();
               echo json_encode(array('success'=>true));
               return;
            }else{
               $this->db->trans_rollback();
               echo json_encode(array('success'=>false, 'msg'=>' Error(#0023) in doul submission'));
               return;
            }
         }else{
            if($array->status == 'A'){
               echo json_encode(array('success'=>false, 'msg'=>' Error(#0024) Doul already approved'));
               return;
            }elseif($array->status == 'P'){
               echo json_encode(array('success'=>false, 'msg'=>' Error(#0025) Doul pending in DC end'));
               return;
            }
            
         }
    }

    function regenerateDpDoul(){
        //patta_type_code!='0209' and patta_no !='0'
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        // $mouza_code=$this->input->get('mouza_code');
        $user_code=$this->session->userdata('user_code');
        $date=date('Y-m-d H:i:s');
        $year=year_no;

        $sqlForCheck = "SELECT status FROM
                              current_dp_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $array = $this->db->query($sqlForCheck,array($year,$dist_code,$subdiv_code,$cir_code))->row();
         if(isset($array->status) && $array->status == 'R'){
            //FIRST DELETE FROM TWO TABLES-----current doul approve and current doul demand----
            $this->db->trans_begin();
            $deletecurrentapprove="delete from current_dp_doul_approve where dist_code = ? and subdiv_code=? and cir_code=? and yeardoul = ?";
            $DeleteStatus1=$this->db->query($deletecurrentapprove,array($dist_code,$subdiv_code,$cir_code,$year));
            if($this->db->affected_rows() != 1){ 
              $this->db->trans_rollback();
              log_message("error", "#Error(#0025), Error in delete, table 'current_dp_doul_approve'");
              echo json_encode(array('success'=>false,'msg'=>'Error(#0025) in dp doul regeneration'));
                    return;
            }

            $count_dp_doul_patta = $this->db->query("select * from current_dp_doul_demand where dist_code = ? and subdiv_code=? and cir_code=? and year_no = ?",array($dist_code,$subdiv_code,$cir_code,$year));
            if($count_dp_doul_patta->num_rows()!= 0)
            {
                $deletecurrentdemand="delete from current_dp_doul_demand where dist_code = ? and subdiv_code=? and cir_code=? and year_no = ?";
                $DeleteStatus2=$this->db->query($deletecurrentdemand,array($dist_code,$subdiv_code,$cir_code,$year));
                if($this->db->affected_rows() <= 0){ 
                  $this->db->trans_rollback();
                  log_message("error", "#Error(#0026), Error in delete, table 'current_dp_doul_demand'");
                  echo json_encode(array('success'=>false,'msg'=>'Error(#0026) in dp doul regeneration'));
                        return;
                }
            }


           // $sqlrev="select cdp.patta_no,sum(cdp.dag_revenue) from jama_dag cdp join jama_patta ct on
           //   cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code and cdp.mouza_pargona_code=ct.mouza_pargona_code
           //   and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
           //   join patta_code pp on cdp.patta_type_code=pp.type_code
           //   where pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0' and (cdp.dag_area_b*100+cdp.dag_area_k*20+cdp.dag_area_lc)>0 and cdp.subdiv_code=? and cdp.cir_code=? group by cdp.patta_no";

         $sqlrev   = "select t.*,uuid from
                      (
                          Select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
         from jama_dag cdp join jama_patta ct on
                      cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                   and cdp.mouza_pargona_code=ct.mouza_pargona_code
                      and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                      join patta_code pp on cdp.patta_type_code=pp.type_code
                      where cdp.dp_flag_yn='Y' and  pp.jamabandi='y' and (cdp.dag_revenue+cdp.dag_localtax)='0'  and
                 cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                   group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.cir_code,cdp.patta_type_code,cdp.dag_revenue,
         bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no) 
                    ) t join location l on 
                      t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
           $count=$this->db->query($sqlrev,array($subdiv_code,$cir_code));
           // log_message('error',$this->db->last_query());
           $count->num_rows();
           if($count->num_rows()>0){
                   echo json_encode(array('val'=>1,'msg'=>'Error(#0020) A Few Dag(s) may be present with revenue zero. Please check and update'));
                   return;
           }
           //////////////exit from loop//////////////////
           $ip = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
           $sql="Select * from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=? and (nc_btad is null or nc_btad='e') ";
           $sqlResult=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00','00'))->result_array();
           $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();
           
           foreach($sqlResult as $m){
               $mouza_code=$m['mouza_pargona_code'];
               $sql="Select  * from current_dp_doul_demand where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and year_no = ? ";
               $num_rows=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$year))->num_rows();
               if($num_rows==0){
                   foreach($patta_type as $p_type)
                   {          
                   $comma = ",";            
                        // $sqlPatta="select t.*,uuid from
                        //  (
                        //      Select dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                        //        vill_townprt_code,trim(patta_no) as patta_no,patta_type_code,sum(round(dag_revenue,2)) as dag_revenue,
                        //        sum(round(dag_localtax,2)) as dag_local_tax,
                        //        sum(dag_area_b) as dag_area_b,
                        //        sum(dag_area_k) as dag_area_k,
                        //        sum(dag_area_lc) as dag_area_lc,
                        //        '$date' as date_of_creation , 
                        //        '$year' as year_no,'$user_code' as port_by_user,'$ip' as port_ip
                        //        from jama_dag where dp_flag_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and patta_type_code='$p_type->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and mouza_pargona_code='$mouza_code' 
                        //          and entry_date <= '$this->doul_date' and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0  
                        //          and (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                        //            (
                        //              select lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,
                        //                 trim(patta_no) from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and entry_date <= '$this->doul_date' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and patta_type_code='$p_type->type_code' group by lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)
                        //           )
                                  
                        //      group by dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(patta_no),patta_type_code
                        //  ) 
                        //  t join location l on 
                        //  t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        //    and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
                        $sqlPatta="select t.*,uuid,case 
                        when t.dag_area_b*100+t.dag_area_k*20+t.dag_area_lc>20 then (t.dag_revenue*.3)
                        else 0 
                        end as surcharge 
                    from 
                    (
                        Select dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,
                          vill_townprt_code,trim(patta_no) as patta_no,patta_type_code,sum(round(dag_revenue,2)) as dag_revenue,
                          sum(round(dag_localtax,2)) as dag_local_tax,
                          sum(dag_area_b) as dag_area_b,
                          sum(dag_area_k) as dag_area_k,
                          sum(dag_area_lc) as dag_area_lc,
                          '$date' as date_of_creation , 
                          '$year' as year_no,'$user_code' as port_by_user,'$ip' as port_ip
                        from jama_dag where dp_flag_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and patta_type_code='$p_type->type_code' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and mouza_pargona_code='$mouza_code' 
                            and entry_date <= '$this->doul_date' and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0  
                            and (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in 
                              (
                                select lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,
                                   trim(patta_no) from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and entry_date <= '$this->doul_date' and trim(patta_no) not in ('0','00','000','','.','..','$comma') and patta_type_code='$p_type->type_code' group by lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)
                             )
                             
                        group by dist_code ,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,trim(patta_no),patta_type_code
                    ) 
                    t join location l on 
                    t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                      and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";   
                   $result= $this->db->query($sqlPatta);
                   if ($result==null || $result->num_rows()<=0)
                       continue;
                   $resultt = $result->result_array();
                   $tstaus=$this->db->insert_batch('current_dp_doul_demand',$resultt);
                   //log_message('error',' ptype='.$p_type->type_code);
                   if($tstaus!=1){
                       $this->db->trans_rollback();
                       log_message('error',$this->db->last_query());
                       echo json_encode(array('success'=>false,'msg'=>'Error(#0021) in dp doul submission'));
                       return;
                   }
                 }
               }else{                
                   echo json_encode(array('success'=>false,'msg'=>'The dp doul data might already been submitted'));
                   return;
               }
           }
           ///////////////
           $this->db->where('dag_local_tax',null);
           $this->db->update('current_dp_doul_demand',array('dag_local_tax'=>0));
           ////////////18-03-23///////////////
            $params=[
            'dist_code'=>$dist_code,
            'subdiv_code'=>$subdiv_code,
            'cir_code'=>$this->session->userdata('cir_code'),
            'co_code'=>$user_code,
            'co_submission_date'=>date('Y-m-d'),
            'status'=>'P',
            'yeardoul' =>$year
            ];
            $this->db->insert('current_dp_doul_approve',$params);
            if($this->db->affected_rows() !=1){
              log_message('error',$this->db->last_query());
              $this->db->trans_rollback();
              echo json_encode(array('success'=>false,'msg'=>'Error(#0022) in DP doul submission'));
              return;
            }
           //////////////
            if($this->db->trans_status()===true){
               $this->db->trans_commit();
               echo json_encode(array('success'=>true));
               return;
            }else{
               $this->db->trans_rollback();
               echo json_encode(array('success'=>false, 'msg'=>' Error(#0023) in dp doul submission'));
               return;
            }
         }else{
            if($array->status == 'A'){
               echo json_encode(array('success'=>false, 'msg'=>' Error(#0024) DP Doul already approved'));
               return;
            }elseif($array->status == 'P'){
               echo json_encode(array('success'=>false, 'msg'=>' Error(#0025) DP Doul pending in DC end'));
               return;
            }
            
         }
    }

   public function directPayTaxUpdate() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
         $data['_view'] = 'GenerateDoul/directtaxupdate';
        $this->load->view('layouts/main',$data);
    }



    public function findPattaVillageWise(){
      $subdiv_code = $this->input->post('subdiv_code');
      $circle_code = $this->input->post('cir_code');
      $dist_code   = $this->input->post('dist_code');
      $mouza_pargona_code   = $this->input->post('mouza_pargona_code');
      $lot_no   = $this->input->post('lot_no');
      $vill_code   = $this->input->post('vill_code');
      $data = array();
      $data['subdiv_code'] =$subdiv_code;
      $data['cir_code'] =$circle_code;
      $data['dist_code'] =$dist_code;
      $data['mouza_pargona_code'] =$mouza_pargona_code;
      $data['lot_no'] =$lot_no;
      $data['vill_code'] =$vill_code;
      $data['mouza_name'] = 'N/A';
      $data['lot_name'] = 'N/A';
      $data['vill_name'] = 'N/A';
      if($subdiv_code != null && $circle_code != null && $dist_code !=null && $mouza_pargona_code !=null && 
         $lot_no != null && $vill_code !=null){
         $data['mouza_name'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code);
         $data['lot_name'] = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no);
         $data['vill_name'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no,$vill_code);
      }
      
      
      $patta = $this->db->query("select distinct(patta_no::int),jd.patta_type_code,(select patta_type from patta_code where type_code=jd.patta_type_code ) as patta_type_name,string_agg(trim(dag_no),',') as dags from jama_dag jd where  dp_flag_yn is null and dist_code =? 
               and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
               lot_no=? and vill_townprt_code=? and patta_no ~ '^\d+$' 
         group by  jd.patta_type_code,patta_no::int order by patta_no::int"
            , array($dist_code,$subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$vill_code));
      $pattaInt = $patta->result();

      $pattaChar = $this->db->query("select distinct(patta_no),jd.patta_type_code,(select patta_type from patta_code where type_code=jd.patta_type_code ) as patta_type_name,string_agg(trim(dag_no),',') as dags from jama_dag jd where dp_flag_yn is null and dist_code =? 
               and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
               lot_no=? and vill_townprt_code=? and patta_no !~ '^\d+$' 
         group by  jd.patta_type_code,patta_no order by patta_no"
            , array($dist_code,$subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$vill_code));
      $pattaChar = $pattaChar->result();
      $data['allPatta'] = array_merge($pattaInt,$pattaChar);
      $this->load->view('GenerateDoul/directtaxupdatepattalist', $data);
    }


    public function updatePattaNo(){
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $dist_code   = $this->input->post('dist_code');
        $mouza_pargona_code   = $this->input->post('mouza_code');
        $lot_no   = $this->input->post('lot_no');
        $vill_code   = $this->input->post('vill_code');
        $pattaDetails = $this->input->post('checkPattaNo');
        $ErrorPattaList = array();
        foreach ($pattaDetails as $key => $value) {
            $this->db->trans_begin();
            $pattaNonCode = preg_split ("/\,/",  $value);
            $this->db->query("UPDATE chitha_basic set dp_flag_yn='Y' where dist_code='$dist_code' and "
                        . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and "
                        . "vill_townprt_code='$vill_code' and trim(patta_no) = '$pattaNonCode[0]' and patta_type_code='$pattaNonCode[1]'");

            $affectedRowsChitha = $this->db->affected_rows();
            if($this->db->affected_rows()>0){
                $this->db->query("UPDATE jama_dag set dp_flag_yn='Y' where dist_code='$dist_code' and "
                        . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and "
                        . "vill_townprt_code='$vill_code' and trim(patta_no) = '$pattaNonCode[0]'  and patta_type_code='$pattaNonCode[1]'");
                $affectedRowsJama = $this->db->affected_rows();
            }

            if($affectedRowsChitha != $affectedRowsJama){
                $ErrorPattaList[] = $pattaNonCode[0];
                log_message('error',"#ERRORDOUL002 --- PATTA NO : ".json_encode($ErrorPattaList));
                $this->db->trans_rollback();

            }else{

                $insertData = array(
                    'patta_no'     => $pattaNonCode[0],
                    'patta_type_code' => $pattaNonCode[1],
                    'dist_code'    => $dist_code,
                    'subdiv_code'  => $subdiv_code,
                    'cir_code'     => $circle_code,
                    'mouza_code'   => $mouza_pargona_code,
                    'lot_no'       => $lot_no,
                    'village_code' => $vill_code,
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'flag'         => 'FIRST'
                );
                $this->db->insert('updated_direct_paying_data', $insertData);
                $this->db->trans_commit();
            }
        }
        
        if(!empty($ErrorPattaList)){
            echo json_encode(array('success'=>false, 'msg'=>'Some of seleted patta might be updated but below mentioned patta no. Direct Paying Estate Tax has not been updated, kindly update Jamabandi for Particular Patta ','patta' => json_encode($ErrorPattaList)));
            return;
        }else{
            echo json_encode(array('success'=>true, 'msg'=>' Successfully updated','patta' => null));
            return;
        }
        
        
    }

    public function findPattaVillageWiseDPTUpdated(){
      
      $subdiv_code = $this->input->post('subdiv_code');
      $circle_code = $this->input->post('cir_code');
      $dist_code   = $this->input->post('dist_code');
      $mouza_pargona_code   = $this->input->post('mouza_pargona_code');
      $lot_no   = $this->input->post('lot_no');
      $vill_code   = $this->input->post('vill_code');
      $data = array();
      $data['subdiv_code'] =$subdiv_code;
      $data['cir_code'] =$circle_code;
      $data['dist_code'] =$dist_code;
      $data['mouza_pargona_code'] =$mouza_pargona_code;
      $data['lot_no'] =$lot_no;
      $data['vill_code'] =$vill_code;
      $data['mouza_name'] = 'N/A';
      $data['lot_name'] = 'N/A';
      $data['vill_name'] = 'N/A';
      if($subdiv_code != null && $circle_code != null && $dist_code !=null && $mouza_pargona_code !=null && 
         $lot_no != null && $vill_code !=null){
         $data['mouza_name'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code);
         $data['lot_name'] = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no);
         $data['vill_name'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no,$vill_code);
      }
      
      
      $patta = $this->db->query("select distinct(patta_no::int),jd.dp_flag_yn as flag,jd.patta_type_code,(select patta_type from patta_code where type_code=jd.patta_type_code ) as patta_type_name,string_agg(trim(dag_no),',') as dags from jama_dag jd where  dp_flag_yn is not null and dist_code =? 
               and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
               lot_no=? and vill_townprt_code=? and patta_no ~ '^\d+$' 
         group by  jd.dp_flag_yn,jd.patta_type_code,patta_no::int order by patta_no::int"
            , array($dist_code,$subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$vill_code));
      $pattaInt = $patta->result();

      $pattaChar = $this->db->query("select distinct(patta_no),jd.dp_flag_yn as flag,jd.patta_type_code,(select patta_type from patta_code where type_code=jd.patta_type_code ) as patta_type_name,string_agg(trim(dag_no),',') as dags from jama_dag jd where dp_flag_yn is not null and dist_code =? 
               and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
               lot_no=? and vill_townprt_code=? and patta_no !~ '^\d+$' 
         group by jd.dp_flag_yn,jd.patta_type_code,patta_no order by patta_no"
            , array($dist_code,$subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$vill_code));
      $pattaChar = $pattaChar->result();
      $data['allPatta'] = array_merge($pattaInt,$pattaChar);
      $this->load->view('GenerateDoul/directtaxupdatepattalistdata', $data);
    }


    public function updatePattaNoRevert(){
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $dist_code   = $this->input->post('dist_code');
        $mouza_pargona_code   = $this->input->post('mouza_code');
        $lot_no   = $this->input->post('lot_no');
        $vill_code   = $this->input->post('vill_code');
        $pattaDetails = $this->input->post('checkPattaNo');
        $ErrorPattaList = array();
        foreach ($pattaDetails as $key => $value) {
            $this->db->trans_begin();
            $pattaNonCode = preg_split ("/\,/",  $value);
            $this->db->where([
                'dist_code'         => $dist_code,
                'subdiv_code'       => $subdiv_code,
                'cir_code'          => $circle_code,
                'mouza_pargona_code'=> $mouza_pargona_code,
                'lot_no'            => $lot_no,
                'vill_townprt_code' => $vill_code,
                'patta_no'          => $pattaNonCode[0],
                'patta_type_code'   => $pattaNonCode[1],
            ]);
            $this->db->update('chitha_basic', ['dp_flag_yn' => null]);
            // $this->db->query("UPDATE chitha_basic set dp_flag_yn=null where dist_code='$dist_code' and "
            //             . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and "
            //             . "vill_townprt_code='$vill_code' and patta_no = '$pattaNonCode[0]' and patta_type_code='$pattaNonCode[1]'");

            $affectedRowsChitha = $this->db->affected_rows();
            if($this->db->affected_rows()>0){
               $this->db->where($where)->update('jama_dag', ['dp_flag_yn' => null]);
                // $this->db->query("UPDATE jama_dag set dp_flag_yn=null where dist_code='$dist_code' and "
                //         . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and "
                //         . "vill_townprt_code='$vill_code' and patta_no = '$pattaNonCode[0]'  and patta_type_code='$pattaNonCode[1]'");
                $affectedRowsJama = $this->db->affected_rows();
            }
            if($affectedRowsChitha != $affectedRowsJama){
                $ErrorPattaList[] = $pattaNonCode[0];
                log_message('error',"#ERRORDOUL002 --- PATTA NO : ".json_encode($ErrorPattaList));
                $this->db->trans_rollback();
            }else{
                $insertData = array(
                    'patta_no'     => $pattaNonCode[0],
                    'patta_type_code' => $pattaNonCode[1],
                    'dist_code'    => $dist_code,
                    'subdiv_code'  => $subdiv_code,
                    'cir_code'     => $circle_code,
                    'mouza_code'   => $mouza_pargona_code,
                    'lot_no'       => $lot_no,
                    'village_code' => $vill_code,
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'flag'         => 'SECOND'
                );
                $this->db->insert('updated_direct_paying_data', $insertData);
                $this->db->trans_commit();
            }
        }
        
        if(!empty($ErrorPattaList)){
            echo json_encode(array('success'=>false, 'msg'=>'Some of seleted patta might be updated but below mentioned patta no. Direct Paying Estate Tax has not been updated, kindly update Jamabandi for Particular Patta ','patta' => json_encode($ErrorPattaList)));
            return;
        }else{
            echo json_encode(array('success'=>true, 'msg'=>' Successfully updated','patta' => null));
            return;
        }
            
         
    }

    public function specialPattaRevenue() {

         $dist_code = $this->session->userdata('dist_code');
         $subdiv_code = $this->session->userdata('subdiv_code');
         $cir_code = $this->session->userdata('cir_code');
         $dist_name = $this->utilityclass->getDistrictName($dist_code);
         $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
         $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
         $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        
         $patta = $this->db->query("select type_code, patta_type, pattatype_eng from patta_code where jamabandi='y'");

         $pattaDetails = $patta->result();
         $data['pattas'] = $pattaDetails;
         $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
         );
         $data['_view'] = 'GenerateDoul/specialPattaRevenue';
         $this->load->view('layouts/main',$data);
    }

   public function findDagsVillageWise(){
      $subdiv_code = $this->input->post('subdiv_code');
      $circle_code = $this->input->post('cir_code');
      $dist_code   = $this->input->post('dist_code');
      $mouza_pargona_code   = $this->input->post('mouza_pargona_code');
      $lot_no   = $this->input->post('lot_no');
      $vill_code   = $this->input->post('vill_code');
      $patta_no   = $this->input->post('patta_no');
      $patta_code   = $this->input->post('patta_code');
      $data = array();
      $data['subdiv_code'] =$subdiv_code;
      $data['cir_code'] =$circle_code;
      $data['dist_code'] =$dist_code;
      $data['mouza_pargona_code'] =$mouza_pargona_code;
      $data['lot_no'] =$lot_no;
      $data['vill_code'] =$vill_code;
      $data['mouza_name'] = 'N/A';
      $data['lot_name'] = 'N/A';
      $data['vill_name'] = 'N/A';
      $data['patta_name'] = 'N/A';
      $data['patta_no'] = 'N/A';
      $data['patta_code'] = null;
      if($subdiv_code != null && $circle_code != null && $dist_code !=null && $mouza_pargona_code !=null && 
         $lot_no != null && $vill_code !=null && $patta_no != null && $patta_code != null){
         $data['mouza_name'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code);
         $data['lot_name'] = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no);
         $data['vill_name'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no,$vill_code);
         $data['patta_name'] = $this->utilityclass->getPattaName($patta_code);
         $data['patta_no'] = $patta_no;
         $data['patta_code'] = $patta_code;
      }
      $sqlDagsDetails="select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
         from jama_dag cdp join jama_patta ct on
                      cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                   and cdp.mouza_pargona_code=ct.mouza_pargona_code
                      and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                      join patta_code pp on cdp.patta_type_code=pp.type_code
                      where pp.jamabandi='y'  and cdp.subdiv_code=? and cdp.cir_code=? and cdp.mouza_pargona_code=? and 
               cdp.lot_no=? and cdp.vill_townprt_code=? and cdp.patta_type_code = ? and cdp.patta_no = ? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                   group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
         cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
         bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no)";
         $zero_revenue_dags=$this->db->query($sqlDagsDetails,array($subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$vill_code,$patta_code,$patta_no))->result();
         $result=array();
         foreach ($zero_revenue_dags as $key => $value) {
                $get_total_lessa = $this->utilityclass->Total_Lessa($value->bigha, $value->ktha, $value->lessa);
                $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                $land_class_name = $this->utilityclass->getLandClassCode($value->dag_class_code);
                $village_name = $this->utilityclass->getVillageNameByruralUrban($dist_code, $subdiv_code, $circle_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code);
                $Type = ( $village_name->rural_urban=='R') ? 'Rural' : 'Urban';
                $main = array(
                    'dag_no'     => $value->dag_no,
                    'patta_no'   => $value->patta_no,
                    'land_class' => $value->dag_class_code,
                    'bigha'      =>  $value->bigha,
                    'ktha'       =>   $value->ktha,
                    'lessa'      =>   $value->lessa,
                    'total_lessa' => $get_total_lessa,
                    'dag_revenue' =>  $value->dag_revenue,
                    'local_tax'  =>  $value->dag_localtax,
                    'land_class_name' => $land_class_name,
                    'patta_type_code' => $value->patta_type_code,
                  );
               $result[] = $main;
            }
      $data['zero_revenue_dags'] = $result;
      $this->load->view('GenerateDoul/PattaWiseDagsDetails', $data);
   }

    public function UpdateDagRevenueSpecialPatta() {

        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_pargona_code=$this->input->post('mouza_pargona_code');
        $lot_no=$this->input->post('lot_no');
        $village_code=$this->input->post('vill_townprt_code');
        $patta_type_code=$this->input->post('patta_type_code');
        $patta_no=$this->input->post('patta_no');
        $dag_no=$this->input->post('dag_no');
        $RevenuePerBigha=$this->input->post('dag_revenue');
        $minRevenue=$this->input->post('local_tax');
        $cdt = date("Y/m/d");
        $cyr = date("Y");
        $usercode = $this->session->userdata('user_code');
        if (is_numeric($RevenuePerBigha) === FALSE && is_numeric($minRevenue) === FALSE) {
            $data=array('success'=>'Please type more than 0');
            echo json_encode($data);
            return;
        } else {
            if ($minRevenue <= 0 && $RevenuePerBigha<=0) {
                    $data=array('success'=>'Please type revenue more than Zero');
                    echo json_encode($data);
                    return;
                } else { 
                     if ($minRevenue <= 0) {
                          $data=array('success'=>'Please type local tax more than Zero');
                          echo json_encode($data);
                          return;
                      } else {                     
                           $this->db->trans_start(); // Begin transaction
                           // 1. Update chitha_basic
                           $where_basic = [
                               'dist_code'          => $dist_code,
                               'subdiv_code'        => $subdiv_code,
                               'cir_code'           => $circle_code,
                               'mouza_pargona_code' => $mouza_pargona_code,
                               'lot_no'             => $lot_no,
                               'vill_townprt_code'  => $village_code,
                               'dag_no'             => $dag_no,
                               'patta_no'           => $patta_no,
                               'patta_type_code'    => $patta_type_code,
                           ];
                           $data_basic = [
                               'dag_revenue'   => $RevenuePerBigha,
                               'dag_local_tax' => $minRevenue
                           ];
                           $this->db->where($where_basic)->update('chitha_basic', $data_basic);
                           // 2. Update jama_dag
                           $where_jama = $where_basic; // same conditions
                           $data_jama = [
                               'dag_revenue'  => $RevenuePerBigha,
                               'dag_localtax' => $minRevenue
                           ];
                           $this->db->where($where_jama)->update('jama_dag', $data_jama);
                           $this->db->trans_complete(); // Commit or Rollback automatically
                           // ✅ Check status
                           if ($this->db->trans_status() === FALSE) {
                               // Transaction failed → rolled back
                               log_message('error', 'Failed to update dag_revenue & local tax for DAG '.$dag_no);
                               $data=array('success'=>'Error in Updation11');
                               return ;
                           } else {
                               // Transaction success → committed
                              $data=array('success'=>'Successfully Updated');
                               return ;
                           }
                        }else{
                           log_message("error","DAG_RevenueUpdateChitha".$this->db->last_query());
                           $data=array('success'=>'Above Mentioned dag may not be present in Chitha.<br> Please Check JB copy of this Patta whether exists or not .');
                           echo json_encode($data);
                           return;
                        }
                        
                     }
                }
                
        }
        $data=array('success'=>'Use numeric values');
        echo json_encode($data);
        return;
    }  

   public function max_id($tablename,$where, $id) {
        $query = $this->db->query("select (" . $id . "+1) AS id from " . $tablename . " where " . $where . " order by " . $id . " DESC LIMIT 1");
        $id = $query->row();
        log_message("error",$this->db->last_query());
        if ($id == null || $id == '') {
            $id = 1;
        } else {
            $id = $query->row()->id;
        }
        return $id;
   }

   public function doulGenerationView()
   {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $postyear = year_no;
        $re = array
        (
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'dist_name' => $this->utilityclass->getDistrictName($dist_code),
            'subdiv_name' => $this->utilityclass->getSubDivName($dist_code, $subdiv_code),
            'cir_name' => $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code),
            'year' => $postyear,
        );
        $re['_view'] = 'GenerateDoul/GenerateCircleWiseDoul';
        $this->load->view('layouts/main',$re);
   }

   public function viewPreviousDoul()
    {
        $for_year = $this->input->post('year_for');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $postyear = $for_year; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'year' => $postyear
        );
        // $re['FinalStatus'] = null;
        // $re['remarks'] = null;
        // $sqlForCheck = "SELECT status,dc_adc_remark FROM current_doul_approve ca where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
        // $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
        // if(!empty($array) && $array != null){
        //     $re['FinalStatus'] = $array->status;
        //     $re['remarks'] = $array->dc_adc_remark;
        // }
        $location = $this->db->query("SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code != '00' and lot_no='00' and Vill_townprt_code = '00000'");
        $location = $location->result();
        $c = '';
        $sql="Select type_code from patta_code where jamabandi='y' ";
        $p_type_code = $this->db->query($sql)->result();
        foreach ($location as $loc) {
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $loc->mouza_pargona_code);
            $t_bigha = $t_katha=$t_lessa=$t_dag_revenue=$t_dag_localtax=$t_patta_no_count=0;
            $st_time = microtime(true);
           // foreach($p_type_code as $p_code)
           // {
              $innerquery1 = "Select sum(dag_area_b) as t_bigha,sum(dag_area_k) as t_katha,sum(dag_area_lc)
                                 as t_lessa,sum(dag_area_g)
                                 as t_gonda,sum(round(dag_revenue, 2)) as t_dag_revenue,
                                 sum(round(dag_localtax, 2)) as t_dag_localtax,
                                 count(distinct(
                                    lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no))) as t_patta_no_count
                               from jama_dag
                                    join patta_code  on jama_dag.patta_type_code=patta_code.type_code
                               where dp_flag_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code'
                                     and mouza_pargona_code='$loc->mouza_pargona_code'
                                     and patta_code.jamabandi='y' and patta_code.type_code != '0000'
                                     and patta_no not in ('0','00','000','','.','..') and entry_date <= '$this->doul_date'
                                     and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                                     and
                                     (lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no)) in
                                       (
                                          select jama_patta.lot_no,jama_patta.mouza_pargona_code,jama_patta.vill_townprt_code,patta_type_code,trim(patta_no)
                                          from jama_patta join location l
                                             on l.subdiv_code=jama_patta.subdiv_code and l.cir_code=jama_patta.cir_code and
                                                l.mouza_pargona_code=jama_patta.mouza_pargona_code and
                                                l.lot_no=jama_patta.lot_no and l.vill_townprt_code=jama_patta.vill_townprt_code
                                         where jama_patta.dist_code='$dist_code' and jama_patta.subdiv_code='$subdiv_code' and jama_patta.cir_code='$circle_code'
                                             and jama_patta.mouza_pargona_code='$loc->mouza_pargona_code'  and entry_date <= '$this->doul_date'
                                             and patta_no not in ('0','00','000','','.','..')
                                             and (l.nc_btad is null or l.nc_btad='e')
                                             group by  jama_patta.lot_no, jama_patta.mouza_pargona_code, jama_patta.vill_townprt_code,
                                                          patta_type_code,patta_no
                                       )
                                ";
                //echo "<br>";
                $data = $this->db->query($innerquery1)->row();
                //log_message('error', 'last_query: '.$this->db->last_query());
                log_message('error', 'Doul Query Time taken: '.(microtime(true) - $st_time));
                //log_message('error',"*************".$this->db->last_query() .'*************<br>');
                $t_bigha= $data->t_bigha;
                $t_katha= $data->t_katha;
                $t_lessa= $data->t_lessa;
                $t_gonda= $data->t_gonda;
                $t_dag_revenue=$t_dag_revenue + $data->t_dag_revenue;
                $t_dag_localtax=$t_dag_localtax + $data->t_dag_localtax;
                $t_patta_no_count=$t_patta_no_count + $data->t_patta_no_count;
            //}
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
               $get_total_lessa = $this->utilityclass->Total_ganda($t_bigha, $t_katha, $t_lessa,$t_gonda);
               //echo "<br>";
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
               //var_dump($Total_Bigha_Katha_Lessa);
            }else{
               $get_total_lessa = $this->utilityclass->Total_Lessa($t_bigha, $t_katha, $t_lessa);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
            }
            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_code' => $loc->mouza_pargona_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'mouza_name' => $mouza_name,
                'year' => $postyear,
                'bigha' => $Total_Bigha_Katha_Lessa[0],
                'ktha' => $Total_Bigha_Katha_Lessa[1],
                'lessa' => $Total_Bigha_Katha_Lessa[2],
                'gonda' => $Total_Bigha_Katha_Lessa[3],
                'total_lessa' => $get_total_lessa,
                'dag_revenue' => $t_dag_revenue,
                'local_tax'   => $t_dag_localtax,
                'total_patta' => $t_patta_no_count,
            );
            $result[] = $main;
        }
        $re['result'] = $result;
        echo json_encode([
            'responseType' => 2,
            'content'      => $re['result']
        ]);
   }



   public function circleWiseDoulView() {

         $dist_code = $this->session->userdata('dist_code');
         $subdiv_code = $this->session->userdata('subdiv_code');
         $circle_code = $this->session->userdata('cir_code');
         $postyear = doul_year_no; //$this->input->post('year_no');
         $districtdata = $this->utilityclass->getDistrictName($dist_code);
         $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
         $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);


         $re = array(
            'dist_code'   => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code'    => $circle_code,
            'dist_name'   => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name'    => $circledata,
            'year'        => $postyear
         );
         $re['FinalStatus'] = null;
         $re['remarks'] = null;
         $sqlForCheck = "SELECT status,dc_adc_remark FROM
                              current_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $array = $this->db->query($sqlForCheck,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
         if(!empty($array) && $array != null){
            $re['FinalStatus'] = $array->status;
            $re['remarks'] = $array->dc_adc_remark;
         }

         $re['FinalStatusDp'] = null;
         $re['remarksDp'] = null;
         $sqlForCheckDp = "SELECT status,dc_adc_remark FROM
                              current_dp_doul_approve ca
                              where ca.yeardoul = ? and ca.dist_code = ? and ca.subdiv_code=? and ca.cir_code = ?";
         $arrayDp = $this->db->query($sqlForCheckDp,array($postyear,$dist_code,$subdiv_code,$circle_code))->row();
         if(!empty($arrayDp) && $arrayDp != null){
            $re['FinalStatusDp'] = $arrayDp->status;
            $re['remarksDp'] = $arrayDp->dc_adc_remark;
         }

        $location = $this->db->query("SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and mouza_pargona_code != '00' and lot_no='00' and Vill_townprt_code = '00000'");
        $location = $location->result();

        $c = '';
        $sql="Select type_code from patta_code where jamabandi='y' ";
        $p_type_code = $this->db->query($sql)->result();
        foreach ($location as $loc) {
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $loc->mouza_pargona_code);
            $t_bigha = $t_katha=$t_lessa=$t_dag_revenue=$t_dag_localtax=$t_patta_no_count=0;
            $st_time = microtime(true);
           // foreach($p_type_code as $p_code)
           // {

               $innerquery1 = "Select sum(dag_area_b) as t_bigha,sum(dag_area_k) as t_katha,sum(dag_area_lc) 
                                 as t_lessa,sum(dag_area_g) 
                                 as t_gonda,sum(round(dag_revenue, 2)) as t_dag_revenue,
                                 sum(round(dag_local_tax, 2)) as t_dag_localtax,
                                 count(distinct(     
                                    lot_no,mouza_pargona_code,vill_townprt_code,patta_type_code,trim(patta_no))) as t_patta_no_count 
                               from current_doul_demand
                                    
                               where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' 
                                     and mouza_pargona_code='$loc->mouza_pargona_code'
                                     and  patta_type_code != '0000'
                                     and patta_no not in ('0','00','000','','.','..') 
                                     and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0";
                //echo "<br>";
                $data = $this->db->query($innerquery1)->row();
                //log_message('error', 'last_query: '.$this->db->last_query());
                log_message('error', 'Doul Query Time taken: '.(microtime(true) - $st_time));
                //log_message('error',"*************".$this->db->last_query() .'*************<br>');
                $t_bigha= $data->t_bigha;
                $t_katha= $data->t_katha;
                $t_lessa= $data->t_lessa;
                $t_gonda= $data->t_gonda;
                $t_dag_revenue=$t_dag_revenue + $data->t_dag_revenue;
                $t_dag_localtax=$t_dag_localtax + $data->t_dag_localtax;
                $t_patta_no_count=$t_patta_no_count + $data->t_patta_no_count;
            //}
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
               $get_total_lessa = $this->utilityclass->Total_ganda($t_bigha, $t_katha, $t_lessa,$t_gonda);
               //echo "<br>";
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
               //var_dump($Total_Bigha_Katha_Lessa);
            }else{
               $get_total_lessa = $this->utilityclass->Total_Lessa($t_bigha, $t_katha, $t_lessa);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
            }
            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_code' => $loc->mouza_pargona_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'mouza_name' => $mouza_name,
                'year' => $postyear,
                'bigha' => $Total_Bigha_Katha_Lessa[0],
                'ktha' => $Total_Bigha_Katha_Lessa[1],
                'lessa' => $Total_Bigha_Katha_Lessa[2],
                'gonda' => $Total_Bigha_Katha_Lessa[3],
                'total_lessa' => $get_total_lessa,
                'dag_revenue' => $t_dag_revenue,
                'local_tax'   => $t_dag_localtax,
                'total_patta' => $t_patta_no_count,
            );
            $result[] = $main;
        }
        $re['result'] = $result;
        $re['_view'] = 'GenerateDoul/GenerateCircleWiseDoul';
        $this->load->view('layouts/main',$re);
   }



   // fetch mouza wise doul from current doul demand=================
   public function MouzaWiseDoulGeneratedView() {

       //var_dump($this->session->all_userdata());
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code  = $this->input->get('mouza_code');
        $postyear    = doul_year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata  = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata  = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name  = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear
        );
        $patta_type = $this->db->query("Select * from patta_code where type_code != '0000' and jamabandi='y' ")->result();

        foreach ($patta_type as $pt) {
            //echo "<pre>" . $pt->type_code ;
            $patta_name = $this->utilityclass->getPattaType($pt->type_code);            
            $innerquery = "Select distinct(lot_no,vill_townprt_code,patta_type_code,trim(patta_no))
                           from current_doul_demand
                            where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..') 
                            ";
            $total_patta_no = $this->db->query($innerquery)->result();
            $patta_no_count = count($total_patta_no);
            $innerquery1 = "Select sum(dag_area_b) as bigha,sum(dag_area_k) as ktha,
                               sum(dag_area_lc) as lessa,sum(dag_area_g) as gonda,sum(round(dag_revenue, 2)) as dag_revenue,
                               sum(round(dag_local_tax, 2)) as dag_localtax 
                            from current_doul_demand where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and Patta_type_code='$pt->type_code' and trim(patta_no) not in ('0','00','000','','.','..') ";


            $data = $this->db->query($innerquery1)->row();
            //log_message('error',"*************".$this->db->last_query() .'*************<br>');
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
               $get_total_lessa = $this->utilityclass->Total_ganda($data->bigha, $data->ktha, $data->lessa,$data->gonda);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
            }else{
               $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
            }
            if ($total_patta_no > 0) {
                $status = '';
                if (($data->bigha == null) && ($data->ktha == null) && ($data->lessa == null)) {
                    $status = 'False';
                } else {
                    $main = array
                        (
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $circle_code,
                        'mouza_code' => $mouza_code,
                        'dist_name' => $districtdata,
                        'subdiv_name' => $subdivdata,
                        'cir_name' => $circledata,
                        'mouza_name' => $mouza_name,
                        'year' => $postyear,
                        'bigha' => $Total_Bigha_Katha_Lessa[0],
                        'ktha' => $Total_Bigha_Katha_Lessa[1],
                        'lessa' => $Total_Bigha_Katha_Lessa[2],
                        'gonda' => $Total_Bigha_Katha_Lessa[3],
                        'total_lessa' => $get_total_lessa,
                        'dag_revenue' => $data->dag_revenue,
                        'local_tax' => $data->dag_localtax,
                        'total_patta' => $patta_no_count,
                        'patta_name' => $patta_name,
                        'patta_type_code' => $pt->type_code,
                        'status' => $status,
                    );
                    $result[] = $main;
                }
            }
        }
        $re['result'] = $result;
        $re['_view'] = 'GenerateDoul/GenerateMouzaWiseDoul';
        $this->load->view('layouts/main',$re);
   }



       public function VillagePattaWiseDoulGeneratedView() {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->get('mouza_code');
        $patta_type_code = $this->input->get('patta_type');
        $postyear = year_no; //$this->input->post('year_no');
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $re = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'year' => $postyear
        );
       $innerquery = "Select mouza_pargona_code,lot_no,vill_townprt_code,patta_type_code from 
       current_doul_demand
       where dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and patta_type_code='$patta_type_code' and trim(patta_no) not in ('0','00','000','','.','..')"
                . " GROUP BY dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,patta_type_code ";
        $jama_patta = $this->db->query($innerquery)->result();     
        foreach ($jama_patta as $jp) {
            $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $jp->mouza_pargona_code, $jp->lot_no, $jp->vill_townprt_code);
            $patta_name = $this->utilityclass->getPattaType($patta_type_code);
           $innerquery1 = "Select sum(dag_area_b) as bigha,sum(dag_area_k) as ktha,sum(dag_area_lc) as lessa,sum(dag_area_g) as gonda,sum(round(dag_revenue, 2)) as dag_revenue,"
                    . "sum(round(dag_local_tax, 2)) as dag_localtax,count(distinct(trim(patta_no))) as patta_no from current_doul_demand where  (dag_area_b*100+dag_area_k*20+dag_area_lc)>0 and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code='$mouza_code' and lot_no = '$jp->lot_no' and vill_townprt_code = '$jp->vill_townprt_code' and patta_type_code='$patta_type_code' and trim(patta_no) not in ('0','00','000','','.','..')";
            //echo "<br>";
            $data = $this->db->query($innerquery1)->row();
            //echo "==============================<br>";
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
               $get_total_lessa = $this->utilityclass->Total_ganda($data->bigha, $data->ktha, $data->lessa,$data->gonda);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa2($get_total_lessa);
            }else{
               $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
               $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
            }
            // $get_total_lessa = $this->utilityclass->Total_Lessa($data->bigha, $data->ktha, $data->lessa);
            // $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
            $status = '';
            if (($data->bigha == null) && ($data->ktha == null) && ($data->lessa == null)) {
                $status = 'False';
            }
            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_code' => $mouza_code,
                'lot_no' => $jp->lot_no,
                'vill_townprt_code' => $jp->vill_townprt_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'mouza_name' => $mouza_name,
                'village_name' => $village_name,
                'year' => $postyear,
                'bigha' => $Total_Bigha_Katha_Lessa[0],
                'ktha' => $Total_Bigha_Katha_Lessa[1],
                'lessa' => $Total_Bigha_Katha_Lessa[2],
                'total_lessa' => $get_total_lessa,
                'dag_revenue' => $data->dag_revenue,
                'local_tax' => $data->dag_localtax,
                'patta_no' => $data->patta_no,
                'patta_type_code' => $patta_type_code,
                'patta_name' => $patta_name,
                'status' => $status,
            );
            //var_dump($main);
            $result[] = $main;
        }
        $re['result'] = $result;
        $re['_view'] = 'GenerateDoul/GenerateVillagePattaWiseDoulView';
        $this->load->view('layouts/main',$re);
    }  

   public function autoRedirectPage($param){

      if($param == 'development')
      {
         $this->session->set_flashdata('message', "#ERROR3474 : Page is under maintenance, kindly wait some time");
         
      }
      redirect(base_url() . "index.php/home");

    }



    public function getAllZeroDagsDpEstate(){
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    // $sqlDagsDetails="select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
    //    cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
    //    dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
    //                   dag_localtax,dag_class_code 
    //    from jama_dag cdp join jama_patta ct on
    //                 cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
    //              and cdp.mouza_pargona_code=ct.mouza_pargona_code
    //                 and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
    //                 join patta_code pp on cdp.patta_type_code=pp.type_code
    //                 where pp.jamabandi='y' and (cdp.dag_revenue='0' or cdp.dag_localtax='0')  and cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
    //              group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.lot_no,
    //    cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
    //    bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no)";

    $sqlDagsDetails = "select t.*,uuid from
                    (select cdp.dag_no,trim(cdp.patta_no) as patta_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
        cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
        dag_area_b as bigha,dag_area_k as ktha,dag_area_lc as lessa,
                        dag_localtax,dag_class_code 
        from jama_dag cdp join jama_patta ct on
                    cdp.dist_code=ct.dist_code and cdp.subdiv_code=ct.subdiv_code and cdp.cir_code=ct.cir_code 
                    and cdp.mouza_pargona_code=ct.mouza_pargona_code
                    and cdp.lot_no=ct.lot_no and cdp.vill_townprt_code=ct.vill_townprt_code
                    join patta_code pp on cdp.patta_type_code=pp.type_code
                    where cdp.dp_flag_yn ='Y' and pp.jamabandi='y' and (cdp.dag_revenue='0' or cdp.dag_localtax='0')  and cdp.subdiv_code=? and cdp.cir_code=? and (dag_area_b*100+dag_area_k*20+dag_area_lc)>0
                    group by cdp.dag_no,cdp.dist_code,cdp.subdiv_code,cdp.mouza_pargona_code,cdp.cir_code,cdp.lot_no,
        cdp.vill_townprt_code,cdp.patta_type_code,cdp.dag_revenue,
        bigha,ktha,lessa,dag_localtax,dag_class_code,trim(cdp.patta_no)) t join location l on 
                    t.dist_code=l.dist_code and t.subdiv_code=l.subdiv_code and t.cir_code=l.cir_code 
                        and t.mouza_pargona_code=l.mouza_pargona_code and t.lot_no=l.lot_no and t.vill_townprt_code=l.vill_townprt_code where (l.nc_btad is null or l.nc_btad='e')";
        $zero_revenue_dags=$this->db->query($sqlDagsDetails,array($subdiv_code,$cir_code))->result();
        $result=array();
        foreach ($zero_revenue_dags as $key => $value) {
                // if($value->patta_type_code == '0205' || $value->patta_type_code =='0208'){
                //    continue;
                // }
                $get_total_lessa = $this->utilityclass->Total_Lessa($value->bigha, $value->ktha, $value->lessa);
                $Total_Bigha_Katha_Lessa = $this->utilityclass->Total_Bigha_Katha_Lessa($get_total_lessa);
                $land_class_name = $this->utilityclass->getLandClassCode($value->dag_class_code);
                $patta_name = $this->utilityclass->getPattaType($value->patta_type_code); 
                $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
                $village_name = $this->utilityclass->getVillageNameByruralUrban($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code);
                $Type = ( $village_name->rural_urban=='R') ? 'Rural' : 'Urban';
                $main = array
                    (
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_name' => $mouza_name,
                    'mouza_code' => $value->mouza_pargona_code,
                    'lot_no' => $value->lot_no,
                    'village_name' => $village_name->village,
                    'village_type' => $Type,
                    'vill_townprt_code' => $value->vill_townprt_code,
                    'dag_no' => $value->dag_no,
                    'patta_no' => $value->patta_no,
                    'land_class' => $value->dag_class_code,
                    'bigha' =>  $value->bigha,
                    'ktha' =>   $value->ktha,
                    'lessa' =>   $value->lessa,
                    'total_lessa' => $get_total_lessa,
                    'dag_revenue' =>  $value->dag_revenue,
                    'local_tax' =>  $value->dag_localtax,
                    'land_class_name' => $land_class_name,
                    'patta_name' => $patta_name,
                    'patta_type_code' => $value->patta_type_code,
                );
                $result[] = $main;
            }
            $data['zero_revenue_dags'] = $result;
        
        $data['_view'] = 'GenerateDoul/updateDagRevenueZero';
        $this->load->view('layouts/main',$data);
    }

    public function ApproveDpDoulWitZeroRevenue()
    {
        $year=doul_year_no;
        // var_dump($_POST);exit;
        $dist_code   = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $remark      = $this->input->post('approval_remark');
        if($remark == null){
           echo json_encode(array('success'=>false, 'msg'=>' Error(#087) Remark field is mandatory'));
           return;
        }
        $this->db->trans_begin();
        $doulCase = "DP-DOUL/".$dist_code."/".$subdiv_code."/".$circle_code."/".$year;
        $where = " case_no = '".$doulCase."'";
        $maxid = $this->max_id('petition_proceeding_dc_adc', $where,'proceeding_id');
        $params = array(
           'case_no'         => $doulCase,
           'proceeding_id'   => $maxid,
           'date_of_hearing' => date('Y-m-d H:i:s'),
           'co_order'        => $remark,
           'status'          => 'A',
           'user_code'       => $this->session->userdata('user_code'),
           'date_entry'      => date('Y-m-d H:i:s'),
           'operation'       => 'E',
           'dist_code'       => $dist_code,
           'subdiv_code'     => $subdiv_code,
           'cir_code'        => $circle_code
        );
        $insertStatus = $this->db->insert('petition_proceeding_dc_adc',$params);
        if($insertStatus != 1){
           log_message('error',$this->db->last_query());
           log_message('error',"Error(#00101) INSERTION FAILED IN petition_proceeding_dc_adc TABLE");
           $this->db->trans_rollback();
           echo json_encode(array('success'=>false,'msg'=>'Error(#00101) in doul Approval'));
           return;
        }

        $this->db->where('dist_code',$dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('cir_code',$circle_code);
        $this->db->where('yeardoul',$year);
        $this->db->update('current_dp_doul_approve',
            array(
                'status'              =>'A',
                'dc_adc_approve_date' => date('Y-m-d'),
                'dc_adc_code'         => $this->session->userdata('user_code'),
                'dc_adc_remark'       => $remark
            )
        );
        if($this->db->affected_rows() != 1){
          log_message('error',$this->db->last_query());
          $this->db->trans_rollback();
          echo json_encode(array('success'=>false,'msg'=>'Error(#0098) in doul Approval'));
          return;
        }
        if($this->db->trans_status()===true){
            $this->db->trans_commit();
            echo json_encode(array('success'=>true,'msg'=> "RES(#001) Doul approved for the session ".$year . '-' . (date('Y') + 1)));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>' Error(#099) Something went wrong!!!'));
            return;
        }
    }

    public function dpDoulRejectByDCWithZeroRevenue()
    {
        $year=doul_year_no;
        $dist_code   = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $remark      = $this->input->post('approval_remark');
        if($remark == null){
        echo json_encode(array('success'=>false, 'msg'=>' Error(#087) Remark field is mandatory'));
        return;
        }
        $doulCase = "DP-DOUL/".$dist_code."/".$subdiv_code."/".$circle_code."/".$year;
        $where = " case_no = '".$doulCase."'";
        $maxid = $this->max_id('petition_proceeding_dc_adc', $where,'proceeding_id');
        $params = array(
            'case_no'         => $doulCase,
            'proceeding_id'   => $maxid,
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'co_order'        => $remark,
            'status'          => 'R',
            'user_code'       => $this->session->userdata('user_code'),
            'date_entry'      => date('Y-m-d H:i:s'),
            'operation'       => 'E',
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $circle_code
        );
        $insertStatus = $this->db->insert('petition_proceeding_dc_adc',$params);
        if($insertStatus != 1){
            log_message('error',$this->db->last_query());
            log_message('error',"Error(#00101) INSERTION FAILED IN petition_proceeding_dc_adc TABLE");
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false,'msg'=>'Error(#00101) in doul Rejection'));
            return;
        }

        $this->db->trans_begin();
        $this->db->where('dist_code',$dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('cir_code',$circle_code);
        $this->db->where('yeardoul',$year);
        $this->db->update('current_dp_doul_approve',
        array(
            'status'              =>'R',
            'dc_adc_approve_date' => date('Y-m-d'),
            'dc_adc_code'         => $this->session->userdata('user_code'),
            'dc_adc_remark'       => $remark
        )
        );
        if($this->db->affected_rows() != 1){
        log_message('error',$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode(array('success'=>false,'msg'=>'Error(#0098) in doul Revert'));
        return;
        }
        if($this->db->trans_status()===true){
            $this->db->trans_commit();
            echo json_encode(array('success'=>true,'msg'=> "RES(#001) Doul Reverted for the session ".$year . '-' . (date('Y') + 1)));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('success'=>false, 'msg'=>' Error(#099) Something went wrong!!!'));
            return;
        }
    }

    
}
