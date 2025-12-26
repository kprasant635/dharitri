<?php

class ChithaJama extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Chitha_basic_model');
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->dbswitch();
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
    function index() {
          $db=  $this->session->userdata('db');
         $q = "Select type_code,patta_type from    patta_code";
         $district['patta'] = $this->db->query($q)->result();

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
        $this->form_validation->set_rules('mouza_code', 'Mouza Code', 'trim|required|numeric');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'trim|required|numeric');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/select_location', $district);
            // $this->load->view('../views/footer');
            $district['_view'] = 'chitha_basic/select_location';
            $this->load->view('layouts/main',$district);
        } else {
            //var_dump($_POST);
            set_time_limit(0);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $patta_type = $this->input->post('patta_type');
            ///////
            $dist_name = $this->utilityclass->getDistrictName($dist_code);
            $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
            $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_code);
            $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
            $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code);
            $pattaType = $this->utilityclass->getPattaName($patta_type);

            $data['location'] = array(
                'dist' => $dist_name,
                'sub' => $sub_div_name,
                'cir' => $cir_name,
                'mouza' => $mouza_name,
                'lot' => $lot_name,
                'village' => $vill_name,
                'patta' => $pattaType,
            );
            
           $sql = "
               SELECT DISTINCT(patta_no)
               FROM jama_dag
               WHERE subdiv_code = ?
                  AND cir_code = ?
                  AND mouza_pargona_code = ?
                  AND lot_no = ?
                  AND vill_townprt_code = ?
                  AND patta_type_code = ?
               ORDER BY patta_no
            ";

            $params = [
               $subdiv_code,
               $cir_code,
               $mouza_code,
               $lot_no,
               $vill_code,
               $patta_type
            ];

            $dagpatta = $this->db->query($sql, $params)->result();

            foreach ($dagpatta as $row) {
                
               $sql1 = "
                  SELECT COUNT(dag_no) AS count
                  FROM jama_dag
                  WHERE subdiv_code = ?
                     AND cir_code = ?
                     AND mouza_pargona_code = ?
                     AND lot_no = ?
                     AND vill_townprt_code = ?
                     AND patta_type_code = ?
                     AND patta_no = ?
               ";

               $params1 = [
                  $subdiv_code,
                  $cir_code,
                  $mouza_code,
                  $lot_no,
                  $vill_code,
                  $patta_type,
                  $row->patta_no
               ];

               $count1 = $this->db->query($sql1, $params1)->row()->count;

                
               $sql2 = "
                  SELECT COUNT(dag_no) AS count
                  FROM chitha_basic
                  WHERE subdiv_code = ?
                     AND cir_code = ?
                     AND mouza_pargona_code = ?
                     AND lot_no = ?
                     AND vill_townprt_code = ?
                     AND patta_type_code = ?
                     AND patta_no = ?
               ";

               $params2 = [
                  $subdiv_code,
                  $cir_code,
                  $mouza_code,
                  $lot_no,
                  $vill_code,
                  $patta_type,
                  $row->patta_no
               ];

               $count2 = $this->db->query($sql2, $params2)->row()->count;

                
                if($count1 != $count2){
                     $sql1 = "
                        SELECT dag_no
                        FROM jama_dag
                        WHERE subdiv_code = ?
                           AND cir_code = ?
                           AND mouza_pargona_code = ?
                           AND lot_no = ?
                           AND vill_townprt_code = ?
                           AND patta_type_code = ?
                           AND patta_no = ?
                        ORDER BY dag_no
                     ";

                     $params1 = [
                        $subdiv_code,
                        $cir_code,
                        $mouza_code,
                        $lot_no,
                        $vill_code,
                        $patta_type,
                        $row->patta_no
                     ];

                     $jama['jama'] = $this->db->query($sql1, $params1)->result();


                     $sql2 = "
                        SELECT dag_no
                        FROM chitha_basic
                        WHERE subdiv_code = ?
                           AND cir_code = ?
                           AND mouza_pargona_code = ?
                           AND lot_no = ?
                           AND vill_townprt_code = ?
                           AND patta_type_code = ?
                           AND patta_no = ?
                        ORDER BY dag_no
                     ";

                     $params2 = [
                        $subdiv_code,
                        $cir_code,
                        $mouza_code,
                        $lot_no,
                        $vill_code,
                        $patta_type,
                        $row->patta_no
                     ];

                     $chitha['chitha'] = $this->db->query($sql2, $params2)->result();


                     $main[]= array(
                        'patta_no' => $row->patta_no,
                        'dag_in_jama' => $jama['jama'],
                        'dag_in_chitha' => $chitha['chitha'],
                     );
                 }
            }
            // var_dump($main);die;
            $data['results'] = $main;
            
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/chithajamacopy', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'chitha_basic/chithajamacopy';
            $this->load->view('layouts/main',$data);
        }
    }

    function index1() {
  $db=  $this->session->userdata('db');
        $q = "Select type_code,patta_type from    patta_code";
        $district['patta'] = $this->db->query($q)->result();

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
        $this->form_validation->set_rules('mouza_code', 'Mouza Code', 'trim|required|numeric');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'trim|required|numeric');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/select_location', $district);
            // $this->load->view('../views/footer');
            $district['_view'] = 'chitha_basic/select_location';
            $this->load->view('layouts/main',$district);
        } else {
            //var_dump($_POST);
            set_time_limit(0);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $patta_type = $this->input->post('patta_type');
            ///////
            $dist_name = $this->utilityclass->getDistrictName($dist_code);
            $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
            $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_code);
            $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
            $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code);
            $pattaType = $this->utilityclass->getPattaName($patta_type);

            $data['location'] = array(
                'dist' => $dist_name,
                'sub' => $sub_div_name,
                'cir' => $cir_name,
                'mouza' => $mouza_name,
                'lot' => $lot_name,
                'village' => $vill_name,
                'patta' => $pattaType,
            );
            ///////
            $sql = "SElect distinct(patta_no) from    jama_dag where subdiv_code='$subdiv_code' and  cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no'
					and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' order by patta_no  offset 80 limit 10";
            $dagpatta = $data['patta'] = $this->db->query($sql)->result();
            foreach ($dagpatta as $row) {
                $d = '';
                $sql = "SElect dag_no from    jama_dag where subdiv_code='$subdiv_code' and  cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no'
					and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and patta_no='$row->patta_no' order by dag_no ";
                $data['jama'][$row->patta_no] = $this->db->query($sql)->result();

                $sql = "SElect dag_no from    chitha_basic where subdiv_code='$subdiv_code' and  cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no'
					and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and patta_no='$row->patta_no' order by dag_no ";
                $data['chitha'][$row->patta_no] = $this->db->query($sql)->result();
            }
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/chithajamacopy', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'chitha_basic/chithajamacopy';
            $this->load->view('layouts/main',$data);
        }
    }

    // function chithajamapatta()
    // { 
    // set_time_limit(0);
    // $sql="SElect distinct(patta_no) from    jama_dag where subdiv_code='01' and  cir_code='01' and mouza_pargona_code='01' and lot_no='01'
    // and vill_townprt_code='10001' and patta_type_code='0201' order by patta_no ";
    // $dagpatta=$data['patta']=$this->db->query($sql)->result();
    // foreach($dagpatta as $row){
    // $d='';
    // $sql="SElect dag_no from    jama_dag where subdiv_code='01' and  cir_code='01' and mouza_pargona_code='01' and lot_no='01'
    // and vill_townprt_code='10001' and patta_type_code='0201' and patta_no='$row->patta_no' order by dag_no ";
    // $data['jama'][$row->patta_no]=$this->db->query($sql)->result();
    // $sql="SElect dag_no from    chitha_basic where subdiv_code='01' and  cir_code='01' and mouza_pargona_code='01' and lot_no='01'
    // and vill_townprt_code='10001' and patta_no='$row->patta_no' and patta_type_code='0201' order by dag_no ";
    // $data['chitha'][$row->patta_no]=$this->db->query($sql)->result();	
    // }
    // $this->load->view('../views/header');
    // $this->load->view('../views/chitha_basic/chithajamacopy',$data);
    // $this->load->view('../views/footer');	
    // }
}

?>