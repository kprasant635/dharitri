<?php

//this file is used by pranob//pranob//pranob//pranob
class JamabandiModel extends CI_Model {

    //function created for displaying the district name
    public function getDistrictName() {
        $CI = &get_instance();

        $this->db2 = $CI->load->database('db2', TRUE) or die();
        $district = $this->db2->query("select district_name,district_code AS district from   district_details ");
        return $district->result();
    }

    public function getpattadarinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattaype) {
        $district = $this->db->query("SELECT jp.pdar_name AS pdar_name, jp.p_flag AS p_flag,
                    jp.pdar_father AS pdar_father,jp.pdar_add1 AS pdar_add1,
                    jp.pdar_add2 AS pdar_add2,jp.pdar_add3 AS pdar_add3,
                    jd.dag_no AS dag_no,jd.dag_revenue AS dag_revenue,
                    jd.dag_localtax AS dag_localtax,jd.dag_area_b AS bigha,
                    jd.dag_area_k AS katha,jd.dag_area_lc AS lesa,jr.remark AS remark,lcc.land_type As land_type  
                  FROM jama_pattadar AS jp 
                  JOIN 
                   jama_dag AS jd 
                  ON jd.patta_no=jp.patta_no
                  JOIN 
                   jama_remark as jr 
                  on TRIM(jr.patta_no)=TRIM(jd.patta_no) 
                  JOIN
                  landclass_code as lcc
                 ON jd.dag_class_code=lcc.class_code
              AND jp.dist_code=jd.dist_code AND jp.subdiv_code=jd.subdiv_code  
             AND jp.cir_code=jd.cir_code AND jp.mouza_pargona_code=jd.mouza_pargona_code 
AND jp.lot_no=jd.lot_no AND jp.vill_townprt_code= jd.vill_townprt_code 
where jp.dist_code='$dist_code' and jp.subdiv_code='$subdiv_code' and jp.cir_code='$circle_code' and jp.mouza_pargona_code='$mouza_code' and jp.lot_no='$lot_no' and jp.vill_townprt_code='$vill_code' and TRIM(jp.patta_no)='$patta_no' and jp.patta_type_code='$pattaype'");
        return $district->result();
    }

    public function getRemarkinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattaype) {
        $remark = $this->db->query("Select remark from   Jama_Remark where dist_code = '$dist_code' and  subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and Lot_No='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattaype' and TRIM(patta_no)='$patta_no'");
        return $remark->result();
    }

    public function getjamainfoPattatype($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattaype) {
        $this->dbswitch();
		$district = $this->db->query("SELECT jp.pdar_name AS pdar_name, jp.p_flag AS p_flag,
                    jp.pdar_father AS pdar_father,jp.pdar_add1 AS pdar_add1,
                    jp.pdar_add2 AS pdar_add2,jp.pdar_add3 AS pdar_add3,TRIM(jp.patta_no) AS patta_no,jp.new_pdar_name AS new_pdar_name,
                    jd.dag_no AS dag_no,jd.dag_revenue AS dag_revenue,
                    jd.dag_localtax AS dag_localtax,jd.dag_area_b AS bigha,
                    jd.dag_area_k AS katha,jd.dag_area_lc AS lesa,jr.remark AS remark,lcc.land_type As land_type  
                  FROM jama_pattadar AS jp 
                  JOIN 
                   jama_dag AS jd 
                  ON TRIM(jd.patta_no)=TRIM(jp.patta_no)
                  JOIN 
                   jama_remark as jr 
                  ON TRIM(jr.patta_no)=TRIM(jd.patta_no) 
                  JOIN
                  landclass_code as lcc
                 ON jd.dag_class_code=lcc.class_code
              AND jp.dist_code=jd.dist_code AND jp.subdiv_code=jd.subdiv_code  
             AND jp.cir_code=jd.cir_code AND jp.mouza_pargona_code=jd.mouza_pargona_code 
AND jp.lot_no=jd.lot_no AND jp.vill_townprt_code= jd.vill_townprt_code 
where jp.dist_code='$dist_code' and jp.subdiv_code='$subdiv_code' and jp.cir_code='$circle_code' and jp.mouza_pargona_code='$mouza_code' and jp.lot_no='$lot_no' and jp.vill_townprt_code='$vill_code'  and jp.patta_type_code='$pattaype' limit 3000 ");

        return $district->result();
    }

    public function getjamainfoPattadarname($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattadar_name) {
        // var_dump($dist_code);
		$this->dbswitch();
        $district = $this->db->query("SELECT jp.pdar_name,jp.patta_no,jp.pdar_father,jp.pdar_add1,jp.pdar_add2,jp.pdar_add3, jd.dag_no AS dag_no,jd.dag_revenue AS dag_revenue,
                    jd.dag_localtax AS dag_localtax,jd.dag_area_b AS bigha,
                    jd.dag_area_k AS katha,jd.dag_area_lc AS lesa,jr.remark AS remark,lcc.land_type As land_type,lcc.class_code_cat As class_code_cat
                    from   jama_pattadar AS jp JOIN

                     jama_dag AS jd ON 
                    jd.dist_code=jp.dist_code and jd.subdiv_code=jp.subdiv_code and 
                    jd.cir_code = jp.cir_code and jd.mouza_pargona_code=jp.mouza_pargona_code and jd.lot_no = jd.lot_no 
                    and jd.vill_townprt_code = jp.vill_townprt_code and TRIM(jd.patta_no)=TRIM(jp.patta_no)  

                    JOIN  jama_remark as jr ON jr.dist_code = jd.dist_code
                    and jr.subdiv_code = jd.subdiv_code 
                    and jr.cir_code = jd.cir_code and jr.mouza_pargona_code = jd.mouza_pargona_code and jr.lot_no = jd.lot_no and 
                    jr.vill_townprt_code= jd.vill_townprt_code and  jr.patta_type_code=jd.patta_type_code  and TRIM(jr.patta_no)=TRIM(jd.patta_no)

                    JOIN
                     landclass_code as lcc
                    ON jd.dag_class_code=lcc.class_code
                 
                where jp.dist_code='$dist_code' and jp.subdiv_code='$subdiv_code' and jp.cir_code='$circle_code' and"
                . " jp.mouza_pargona_code='$mouza_code' and jp.lot_no='$lot_no' and jp.vill_townprt_code='$vill_code'"
                . " and jp.pdar_name LIKE '%$pattadar_name%' order by jr.rmk_line_no");

        return $district->result();
    }

    public function getPattaType() {
		$this->dbswitch();
        $patta = $this->db->query("Select type_code,patta_type from   patta_code order by type_code asc");
        return $patta->result();
    }

    public function getPattano() {
        //var_dump($this->session->all_userdata());
		$this->dbswitch();
        $pattano = $this->db->query("Select TRIM(patta_no) from   jama_patta ");
        return $pattano->result();
    }

    // <!----------------db swicth------------>


public function dbswitch(){       
     $CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$CI->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$CI->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$CI->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$CI->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$CI->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$CI->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$CI->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$CI->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$CI->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$CI->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$CI->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$CI->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$CI->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$CI->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$CI->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$CI->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$CI->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$CI->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$CI->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$CI->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$CI->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$CI->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$CI->load->database('dha23', TRUE);   
     }                                                                                                                                                                                                              
}

}

?>