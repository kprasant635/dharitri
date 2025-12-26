<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('max_execution_time', 0);

class JamaBandi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('AES');
    }

    public function index() {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['LM', 'CO', 'ADC', 'DC'])){
            show_error('You are not authorize to perform this action.', 401);
            // $this->session->set_flashdata('message', 'You are not authorize to perform this action.');
            // return redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            
            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            
            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            
            
            $dist_code = $_POST['dist_code'];
            $subdiv_code = $_POST['subdiv_code'];
            $circle_code = $_POST['circle_code'];
            $mouza_code = $_POST['mouza_code'];
            $lot_no = $_POST['lot_no'];
            $vill_code = $_POST['vill_code'];

            $location = array(
                'd' => $dist_code,
                'c' => $circle_code,
                's' => $subdiv_code,
                'm' => $mouza_code,
                'l' => $lot_no,
                'v' => $vill_code
            );

            $this->session->set_userdata(array('loc' => $location));

            $q = "select distinct cast(patta_no as int) as patta_no from chitha_basic where"
                    . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'"
                    . " and (lower(jama_yn)!='y' or jama_yn is null)  "
                    . " ";


            $invalids = $this->db->query("select distinct TRIM(patta_no) as patta_no from chitha_basic where"
                            . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                            . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'"
                            . " and (lower(jama_yn)!='y' or jama_yn is null) and TRIM(patta_no)!='' and TRIM(patta_no)!='0' and TRIM(patta_no)!='.'  "
                            . " ")->result();

            $valids = array();

            foreach ($invalids as $invalid) {

                if (gettype((double) trim($invalid->patta_no)) == 'double') {
                    $pattaObject = new stdClass();
                    $pattaObject->patta_no = trim($invalid->patta_no);
                    $valids[] = $pattaObject;
                }
            }


            sort($valids);

            $data['pattas'] = $valids;

            $headtitle = array(
                'title' => 'Home Page'
            );
            $data['_view'] = 'jamaupdate/step2';
            $this->load->view('layouts/main',$data);
            //$this->load->view('header', $headtitle);
           // $this->load->view('jamaupdate/step2', $data);
           // $this->load->view('footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $headtitle = array(
                'title' => 'Home Page'
            );

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $dist_name = $this->utilityclass->getDistrictName($dist_code);
            $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
            $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

            $district['datas'] = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'dist_name' => $dist_name,
                'sub_div_name' => $sub_div_name,
                'cir_name' => $cir_name
            );
            $district['_view'] = 'jamaupdate/step1';
            $this->load->view('layouts/main',$district);
            // $this->load->view('header', $headtitle);
            // $this->load->view('jamaupdate/step1', $district);
            // $this->load->view('footer');
        }
    }

    public function step2() {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['LM', 'CO', 'ADC', 'DC'])){
            show_error('You are not authorize to perform this action.', 401);
            // $this->session->set_flashdata('message', 'You are not authorize to perform this action.');
            // return redirect(base_url('index.php/chithareport/jamadistrictDetails_dc_lao'));
            // return redirect($_SERVER['HTTP_REFERER']);
        }
        $l = $this->session->userdata('loc');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            
            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            
            if($errorMessageStr != ''){
                show_error($errorMessageStr, 401);
                // $this->session->set_flashdata('message', $errorMessageStr);
                // return redirect(base_url('index.php/chithareport/jamadistrictDetails_dc_lao'));
                // return redirect($_SERVER['HTTP_REFERER']);
            }
            
            
            // $l = $this->session->userdata('loc');

            // $data['datasession']= base64_encode(json_encode($l));
            $aesloc = new AES(json_encode($l), '1234556789100123456');
            $baseloc = $aesloc->encrypt();
            $data['datasession'] =base64_encode($baseloc);

            if ((trim($_POST['patta_no'])) && ( isset($_POST['patta_type']))) {
                // $l=json_decode(base64_decode($_POST['locationsess']));
                
                $responsebase          = base64_decode($_POST['locationsess']);
                $res_aes_loc       = new AES($responsebase, '1234556789100123456');
                $responseaes       = $res_aes_loc->decrypt();
                $l                 = json_decode($responseaes);
                $this->step3(trim($_POST['patta_no']), $_POST['patta_type'], null, $l);
            }

            if ((trim($_POST['patta_no'])) && (!isset($_POST['patta_type']))) {

                $dist_code = $l['d'];
                $subdiv_code = $l['s'];
                $circle_code = $l['c'];
                $mouza_code = $l['m'];
                $lot_no = $l['l'];
                $vill_code = $l['v'];

                $query = "select patta_type,type_code from chitha_basic,patta_code where chitha_basic.patta_type_code"
                        . " = patta_code.type_code and TRIM(chitha_basic.patta_no)=trim('$_POST[patta_no]') and"
                        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                        . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' group by type_code";

                $type = $this->db->query($query)->result();

                $data['type'] = $type;
                $data['pattas'] = $this->db->query("select distinct TRIM(patta_no) as patta_no from chitha_basic where"
                                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'")->result();

                $data['patta_no'] = trim($_POST['patta_no']);

                $headtitle = array(
                    'title' => 'Home Page'
                );
                $data['_view'] = 'jamaupdate/step2';
                $this->load->view('layouts/main',$data);
                // $this->load->view('header', $headtitle);
                // $this->load->view('jamaupdate/step2', $data);
                // $this->load->view('footer');
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $headtitle = array(
                'title' => 'Home Page'
            );
            $district['_view'] = 'jamaupdate/step2';
            $this->load->view('layouts/main',$district);
            // $this->load->view('header', $headtitle);
            // $this->load->view('jamaupdate/step2');
            // $this->load->view('footer');
        }
    }
    
    
    
            public function step31($patta_no, $patta_type,$did,$subd,$circ,$moza,$lt,$vlz) {
            
            
            //echo $patta_no.'jjjjjjjj'.$patta_type.'hhhhhhhhh'.$did.'hhhhhhhhhh'.$subd.$circ.$moza.$lt.$vlz;
            
//echo'vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv';
        //exit();
        $headtitle = array(
            'title' => 'Home Page'
        );
       // $l = $this->session->userdata('loc');
        $get_old_patta_type_code='';
        $dist_code = $did;
        $subdiv_code = $subd;
        $circle_code = $circ;
        $mouza_code = $moza;
        $lot_no = $lt;
        $vill_code = $vlz;

        $query_dags = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . " and  (lower(jama_yn)!='y' or jama_yn is null)";
            


        $dags = $this->db->query($query_dags)->result();
        $pendingMap = false;
        $defined = define_date;
        foreach ($dags as $d) {
            //This part is to check for mutation cases.
            $queryCheck = "select count(*) as c from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                    . "and dag_no='$d->dag_no' and map_partition is null and order_type_code='02' and date(co_ord_date)>='$defined'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        foreach ($dags as $d) {
            //This part is to check for partition cases if map pending.
            $queryCheck = "select count(*) as c from chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                    . "and dag_no='$d->dag_no' and map_partition='P'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        if ($pendingMap) {
            //$this->load->view('header', $headtitle);
            $data1['dag_no'] = $pedingDag;
            $data1['patta_no'] = $patta_no;
            $this->session->set_flashdata('message',"Map not updated");
            redirect('/home');
            // $this->load->view('message', $data1);
            // $this->load->view('footer');
            return;
        }

        $query = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " and (lower(jama_yn)!='y' or jama_yn is null)";
                
                
        
                

        $data = $this->db->query($query)->result();

        $countDag = 1;

        foreach ($data as $d) {
            $data = array(
                'dist_code' => $d->dist_code,
                'subdiv_code' => $d->subdiv_code,
                'cir_code' => $d->cir_code,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'lot_no' => $d->lot_no,
                'vill_townprt_code' => $d->vill_townprt_code,
                'patta_no' => trim($d->patta_no),
                'old_patta_no' => $d->old_patta_no,
                'patta_type_code' => $d->patta_type_code,
                'user_code' => $d->user_code,
                'entry_date' => $d->date_entry,
                //'dag_class_code' => $d->land_class_code,
                'entry_mode' => 'U'
            );

            unset($data['dag_class_code']);
            //Checks if new patta exists or not
            $q = "select count(*) as count from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                    . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";

            $count = $this->db->query($q)->row()->count;

            if ($count == 0) {
                $this->db->insert('jama_patta', $data); //.......................
            }
            ///////////
            $entry_date=date('Y-m-d');
            $g = "Update jama_patta set entry_date='$entry_date' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                    . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
            $this->db->query($g);
            ///////////////
        }

        echo "<br>";
        $query_dags = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . " and  (lower(jama_yn)!='y' or jama_yn is null)";

        $dags = $this->db->query($query_dags)->result();

        foreach ($dags as $d) {
            $old_patta_no = $d->old_patta_no;
            $d->dag_class_code = $d->land_class_code;

            unset($d->old_dag_no);
            unset($d->dag_no_int);
            unset($d->land_class_code);
            unset($d->dag_area_are);
            unset($d->dag_local_tax);
            unset($d->dag_no_map);
            unset($d->dag_n_dag_no);
            unset($d->dag_e_dag_no);
            unset($d->dag_s_dag_no);
            unset($d->dag_e_dag_no);
            unset($d->dag_w_dag_no);
            unset($d->dp_flag_yn);
            unset($d->dag_w_dag_no);

            $d->entry_date = $d->date_entry;

            unset($d->date_entry);
            unset($d->operation);
            unset($d->jama_yn);
            unset($d->status);
            unset($d->old_patta_no);
            unset($d->dag_name);
            unset($d->dag_dept_name);
            unset($d->alpha_dag);
            unset($d->alpha_patta);
            unset($d->rs_data);
            unset($d->old_patta_no);
            unset($d->old_patta_no);
            unset($d->uuid);

            $d->entry_mode = 'U';

            $qe = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and"
                    . " patta_type_code='$d->patta_type_code'";

            $count = $this->db->query($qe)->row()->count;

            if ($count == 0) {
                //Inserts if new patta & new dag does not exists
                $this->db->insert('jama_dag', $d); //.......................
                //Checks if old patta & new dag exists(basically done because of full partition and full conversion)
                $check = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                        . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                $check_existance = $this->db->query($check)->row()->count;
                if ($check_existance == '1') {
                    //before deleting get the old_patta_type_code from inserting remarks in the old patta 
                    $get_old_patta_type_code = "select patta_type_code as patta_type_code from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                            . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";
                    $get_old_patta_type_code = $this->db->query($get_old_patta_type_code)->row()->patta_type_code;

                    //Delete old patta & dag that exists(basically done because of full partition and full conversion) 
                    $delete = "Delete from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                            . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                    $this->db->query($delete); //.......................
                }
            } else {
                if($d->dag_revenue){
                    $d->dag_revenue = $d->dag_revenue;
                    $d->dag_localtax = $d->dag_revenue/4;
                }
                if ($d->dag_revenue == null) {
                    $d->dag_revenue = 15;
                }
                if($d->dag_localtax == null) {
                    $d->dag_localtax = 4;
                }
                $query = "update jama_dag set dag_class_code='$d->dag_class_code', dag_area_b='$d->dag_area_b', dag_area_k='$d->dag_area_k' ,dag_area_lc='$d->dag_area_lc',dag_revenue='$d->dag_revenue',dag_localtax='$d->dag_localtax' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and"
                        . " dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

                $this->db->query($query); //.......................
            }

            $g = "select * from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

            //This part is to check for mutation case Orders.
            $q = "select * from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and"
                    . " (lower(jama_updated)!='y' or jama_updated is null)";

            /* start of generating remarks for col8 related orders */
            $col8Remark = $this->getCol8Remark($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            $remarkText = $this->generate8Remark($d->dag_no, $col8Remark);
            
        
            
            /* end of generating remarks for col8 related orders */

            /* Inserting remarks of all col8 orders */
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no'";

            $line_no = $this->db->query($lineNo)->row()->max;

            if ($line_no == null) {
                $line_no = 1;
            }
            for ($j = 0; $j < sizeof($remarkText); $j++) {

                $remarkData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type,
                    'rmk_line_no' => $line_no++,
                    'remark' => $remarkText[$j],
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
                if ($remarkText != null) {
                    $this->db->insert('jama_remark', $remarkData); //.......................
                }
            }
            /* end of inserting new remarks of all col8 orders */


            /* start of generating remarks for col31 related orders */
            $col31Remark = $this->getCol31($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            
            
            //var_dump($col31Remark);
            $remark3c = $this->generateCol31Remark($d->dag_no, $col31Remark);

            /* end of generating remarks for col31 related orders */

            /* start of inserting new remarks of all col31 orders in old patta */
            if ($get_old_patta_type_code) {
                $update_patta_no = $old_patta_no;
                $update_patta_type_code = $get_old_patta_type_code;

                $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                        . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                        . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$update_patta_type_code' and "
                        . " TRIM(patta_no)='$update_patta_no'";

                $line_no1 = $this->db->query($lineNoq)->row()->max;

                if ($line_no1 == null) {
                    $line_no1 = 1;
                }

                $remarkData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $update_patta_no,
                    'patta_type_code' => $update_patta_type_code,
                    'rmk_line_no' => $line_no1++,
                    'remark' => $remark3c,
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
                $this->db->insert('jama_remark', $remarkData); //.......................
            }
            $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no'";
            $lineNoq . "<br>";
            $line_no1 = $this->db->query($lineNo)->row()->max;
            if ($line_no1 == null) {
                $line_no1 = 1;
            }
            $remarkData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type,
                'rmk_line_no' => $line_no1++,
                'remark' => $remark3c,
                'user_code' => $d->user_code,
                'entry_date' => date('Y-m-d'),
                'entry_mode' => 'U'
            );
            if ($remark3c != null) {
                $this->db->insert('jama_remark', $remarkData); //.......................
            }
            $orders = $this->db->query($q)->result();
        }
        $query_pattadars = "select * from chitha_pattadar as cp where"
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and "
                . "  (lower(cp.jama_yn)!='y' or lower(cp.jama_yn)!='y')";

        $deleteQuery = "delete from jama_pattadar cp where "
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)=trim('$patta_no') and cp.patta_type_code='$patta_type' and entry_mode='U' and pdar_id not in "
                . " (select pdar_id from chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . " and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type' ) ";

        $pattadars = $this->db->query($query_pattadars)->result();
        foreach ($pattadars as $p) {
            $pflag = 0;
            $pdar_id = $p->pdar_id;
            $p->pdar_name = str_replace("'", "", $p->pdar_name);
            $p->pdar_father = str_replace("'", "", $p->pdar_father);
            $update_name_in_jama = "Update jama_pattadar set pdar_name='$p->pdar_name',pdar_father='$p->pdar_father' where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id' ";

            $this->db->query($update_name_in_jama);

            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id=$pdar_id and p_flag='1'";

            $p_flagCount = $this->db->query($count_q)->row()->count;

            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id = $pdar_id";

            $count_dag_q;

            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;


            $p->pdar_land_b = 0;
            $p->pdar_land_k = 0;
            $p->pdar_land_lc = 0;
            $p->pdar_land_g = 0;
            $p->pdar_land_kr = 0;

            if ($p_flagCount == $dag_presentCount) {
                $p->p_flag = '1';
            } else {
                $p->p_flag = '0';
            }

            $p->entry_date = $p->date_entry;
            $p->entry_mode = 'U';
            $p->pdar_id = $p->pdar_id;
            //$p->pdar_father=$p->pdar_father;
            unset($p->dag_por_b);
            unset($p->dag_por_k);
            unset($p->dag_por_lc);
            unset($p->dag_por_g);
            unset($p->dag_por_kr);
            unset($p->date_entry);
            unset($p->operation);
            unset($p->jama_yn);
            unset($p->pdar_guard_reln);
            unset($p->f1_case_no);
            unset($p->f2_case_no);
            unset($p->o1_case_no);
            unset($p->o2_case_no);
            unset($p->dag_no);
            $query = "select count(*) as count from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";

            $pdar_id_query = "select max(cast (pdar_id as int)) as new_pdar_id from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' ";
            $pdar_id_new = $this->db->query($pdar_id_query)->row()->new_pdar_id;
            if ($pdar_id_new == null) {
                $pdar_id_new = 1;
            } else {
                $pdar_id_new +=1;
            }
            $count = $this->db->query($query)->row()->count;
            if ($count == 0) {
                $this->db->insert('jama_pattadar', $p); //......................
            }
            $count++;
        }
        $query_pattadars_pflag = "select * from chitha_dag_pattadar as cp where"
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' ";
        $toRemove = $this->db->query($query_pattadars_pflag)->result();
        foreach ($toRemove as $remove) {
            ///////////////////////////////////////
            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id=$remove->pdar_id and p_flag='1'";

            $p_flagCount = $this->db->query($count_q)->row()->count;
            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id = $remove->pdar_id";
            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;
            if ($p_flagCount == $dag_presentCount) {
                $remove->p_flag = '1';
            } else {
                $remove->p_flag = '0';
            }
            /////////////////////////////
            $this->db->query("update jama_pattadar cp set p_flag='$remove->p_flag' where "
                    . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                    . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                    . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and pdar_id = '$remove->pdar_id' ");
        }

        // $update_chitha = "update chitha_basic set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";
        // $this->db->query($update_chitha); //..............................

        $table = 'chitha_basic';
        $params = [
            'jama_yn' => 'y',
        ];
        $where = [
            'patta_no'           => trim($patta_no),
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];
        $this->Chitha_basic_model->update_table($table, $params, $where);


        // $update_pattadar = "update chitha_pattadar set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";

        $table = 'chitha_pattadar';
        $params = [
            'jama_yn' => 'y',
        ];
        $where = [
            'patta_no'           => trim($patta_no), // TRIM in SQL is handled by PHP trim()
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];
        $this->Chitha_basic_model->update_table($table, $params, $where);


        // $update_dag_pattadar = "update chitha_dag_pattadar set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";
        // // $this->db->query($update_pattadar); //..............................
        // $this->db->query($update_dag_pattadar); //..............................

        $table = 'chitha_dag_pattadar';
        $params = [
            'jama_yn' => 'y',
        ];
        $where = [
            'patta_no'           => trim($patta_no), // Apply trim in PHP
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];
        $this->Chitha_basic_model->update_table($table, $params, $where);

        $this->session->set_flashdata('message', 
                "  Record updated in JamaBandi for Patta # $patta_no. In case "
                . " of any discrepancy between and chitha"
                . " and Jamabandi, Kindly use the Jamabandi Edit Entry Module to correct the Jamabandi.");
        redirect(base_url() . 'index.php/home/'); //..............................
    }
    
    
    
    
    
    

    public function step3($patta_no, $patta_type,$case_no=null, $l=null) {
        
        $headtitle = array(
            'title' => 'Home Page'
        );

        // $l = $this->session->userdata('loc');
        $loc_session = (array) $this->session->userdata('loc');
        if (empty($loc_session) || (isset($loc_session[0]) && $loc_session[0] === false)) {
                $l = (array)$l;
        }else{
                $l = $loc_session;
        }

        // var_dump($l); die;
        $get_old_patta_type_code='';
        $dist_code = $l['d'];
        $subdiv_code = $l['s'];
        $circle_code = $l['c'];
        $mouza_code = $l['m'];
        $lot_no = $l['l'];
        $vill_code = $l['v'];

     $query_dags = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . " and  (lower(jama_yn)!='y' or jama_yn is null)";


        $dags = $this->db->query($query_dags)->result();
        $pendingMap = false;
        $defined = define_date;
        // var_dump("ok");
        foreach ($dags as $d) {
            //This part is to check for mutation cases.
            $queryCheck = "select count(*) as c from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                    . "and dag_no='$d->dag_no' and map_partition is null and order_type_code='02' and date(co_ord_date)>='$defined'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }
        foreach ($dags as $d) {
            //This part is to check for partition cases if map pending.
            $queryCheck = "select count(*) as c from chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                    . "and dag_no='$d->dag_no' and map_partition='P'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        // if ($pendingMap) {
        //     $this->load->view('header', $headtitle);
        //     $data1['dag_no'] = $pedingDag;
        //     $data1['patta_no'] = $patta_no;
        //     $this->load->view('message', $data1);
        //     $this->load->view('footer');
        //     return;
        // }

        $query = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " and (lower(jama_yn)!='y' or jama_yn is null)";

        $data = $this->db->query($query)->result();

        $countDag = 1;

        foreach ($data as $d) {
            $data = array(
                'dist_code' => $d->dist_code,
                'subdiv_code' => $d->subdiv_code,
                'cir_code' => $d->cir_code,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'lot_no' => $d->lot_no,
                'vill_townprt_code' => $d->vill_townprt_code,
                'patta_no' => trim($d->patta_no),
                'old_patta_no' => $d->old_patta_no,
                'patta_type_code' => $d->patta_type_code,
                'user_code' => $d->user_code,
                'entry_date' => $d->date_entry,
                //'dag_class_code' => $d->land_class_code,
                'entry_mode' => 'U'
            );

            unset($data['dag_class_code']);
            //Checks if new patta exists or not
            $q = "select count(*) as count from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                    . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";

            $count = $this->db->query($q)->row()->count;

            if ($count == 0) {
                $this->db->insert('jama_patta', $data); //.......................
            }
            // log_message('error',"asnbdasd####".$this->db->last_query());
            //die;
            ///////////
            $entry_date=date('Y-m-d');
            $g = "Update jama_patta set entry_date='$entry_date' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                    . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
            $this->db->query($g);
            ///////////////
        }

        echo "<br>";
        $query_dags = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,patta_type_code,patta_no,land_class_code as dag_class_code,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_area_are as dag_area_acre,dag_revenue,dag_local_tax as dag_localtax,dag_n_desc,dag_s_desc,dag_e_desc,dag_w_desc,dag_n_dag_no as dag_n_dagno,dag_s_dag_no as dag_s_dagno,dag_e_dag_no as dag_e_dagno,dag_w_dag_no as dag_w_dagno,dag_nlrg_no,dp_flag_yn,user_code,date_entry as entry_date,operation as entry_mode,dag_flag_type,dag_rural_urban_type,dag_area_type,possession_from,old_patta_no
        from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . " and  (lower(jama_yn)!='y' or jama_yn is null)";

        $dags = $this->db->query($query_dags)->result();

        foreach ($dags as $d) {
             $old_patta_no = $d->old_patta_no;
            // $d->dag_class_code = $d->land_class_code;

            // unset($d->old_dag_no);
            // unset($d->dag_no_int);
            // unset($d->land_class_code);
            // unset($d->dag_area_are);
            // unset($d->dag_local_tax);
            // unset($d->dag_no_map);
            // unset($d->dag_n_dag_no);
            // unset($d->dag_e_dag_no);
            // unset($d->dag_s_dag_no);
            // unset($d->dag_e_dag_no);
            // unset($d->dag_w_dag_no);
            // unset($d->dp_flag_yn);
            // unset($d->dag_w_dag_no);

            // $d->entry_date = $d->date_entry;

            // unset($d->date_entry);
            // unset($d->operation);
            // unset($d->jama_yn);
            // unset($d->status);
            // unset($d->old_patta_no);
            // unset($d->dag_name);
            // unset($d->dag_dept_name);
            // unset($d->alpha_dag);
            // unset($d->alpha_patta);
            // unset($d->rs_data);
            unset($d->old_patta_no);
            // unset($d->uuid);

            // $d->entry_mode = 'U';

             $qe = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and"
                    . " patta_type_code='$d->patta_type_code'";

            $count = $this->db->query($qe)->row()->count;
            // var_dump($count);die;
            if ($count == 0) {
                //Inserts if new patta & new dag does not exists
                $test = $this->db->insert('jama_dag', $d); //.......................
                // var_dump($test);
                // die;
                //Checks if old patta & new dag exists(basically done because of full partition and full conversion)
                $check = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                        . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                $check_existance = $this->db->query($check)->row()->count;
                if ($check_existance == '1') {
                    //before deleting get the old_patta_type_code from inserting remarks in the old patta 
                    $get_old_patta_type_code = "select patta_type_code as patta_type_code from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                            . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";
                    $get_old_patta_type_code = $this->db->query($get_old_patta_type_code)->row()->patta_type_code;

                    //Delete old patta & dag that exists(basically done because of full partition and full conversion) 
                    $delete = "Delete from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                            . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                    $this->db->query($delete); //.......................
                }
            } else {
                if($d->dag_revenue){
                    $d->dag_revenue = $d->dag_revenue;
                    $d->dag_localtax = $d->dag_revenue/4;
                }
                if ($d->dag_revenue == null) {
                    $d->dag_revenue = 15;
                }
                if($d->dag_localtax == null) {
                    $d->dag_localtax = 4;
                }
                $query = "update jama_dag set dag_class_code='$d->dag_class_code', dag_area_b='$d->dag_area_b', dag_area_k='$d->dag_area_k' ,dag_area_lc='$d->dag_area_lc',dag_area_g='$d->dag_area_g',dag_revenue='$d->dag_revenue' ,dag_localtax='$d->dag_localtax' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and"
                        . " dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

                $this->db->query($query); //.......................
            }
            
            $g = "select * from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

            //This part is to check for mutation case Orders.
            $q = "select * from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and"
                    . " (lower(jama_updated)!='y' or jama_updated is null)";


            /* start of generating remarks for col8 related orders */
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){

            $col8Remark = $this->getCol8Remark_kar($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            $remarkText = $this->generate8Remark_kar($d->dag_no, $col8Remark);
            }

            else{
            $col8Remark = $this->getCol8Remark($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            $remarkText = $this->generate8Remark($d->dag_no, $col8Remark);
            }
            // log_message('error','jama###'.$remarkText);
            /* end of generating remarks for col8 related orders */

            /* Inserting remarks of all col8 orders */
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no'";

            $line_no = $this->db->query($lineNo)->row()->max;

            if ($line_no == null) {
                $line_no = 1;
            }
            for ($j = 0; $j < sizeof($remarkText); $j++) {

                $remarkData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type,
                    'rmk_line_no' => $line_no++,
                    'remark' => $remarkText[$j],
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
                if ($remarkData != null) {
                    $this->db->insert('jama_remark', $remarkData); //.......................
                }
            }
            /* end of inserting new remarks of all col8 orders */


            /* start of generating remarks for col31 related orders */
            // $col31Remark = $this->getCol31($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            //var_dump($col31Remark);
            // $remark3c = $this->generateCol31Remark($d->dag_no, $col31Remark);

            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){

            $col31Remark = $this->getCol31kar($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            //var_dump($col31Remark);
            $remark3c= $this->remarkGenerateCol31kar($d->dag_no, $col31Remark);
            }
            else{
            $col31Remark = $this->getCol31($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            //var_dump($col31Remark);
            $remark3c= $this->remarkGenerateCol31($d->dag_no, $col31Remark);
            }

            /* end of generating remarks for col31 related orders */

            /* start of inserting new remarks of all col31 orders in old patta */
            if ($get_old_patta_type_code) {
                $update_patta_no = $old_patta_no;
                $update_patta_type_code = $get_old_patta_type_code;

                $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                        . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                        . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$update_patta_type_code' and "
                        . " TRIM(patta_no)='$update_patta_no'";

                $line_no1 = $this->db->query($lineNoq)->row()->max;

                if ($line_no1 == null) {
                    $line_no1 = 1;
                }

                $remarkData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $update_patta_no,
                    'patta_type_code' => $update_patta_type_code,
                    'rmk_line_no' => $line_no1++,
                    'remark' => $remark3c,
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
                $this->db->insert('jama_remark', $remarkData); //.......................
            }
            $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no'";
            $line_no1 = $this->db->query($lineNo)->row()->max;
            if ($line_no1 == null) {
                $line_no1 = 1;
            }
            $remarkData1=null;
            foreach($remark3c as $tmprmk)
            {
                if ($tmprmk == null || empty($tmprmk))
                {
                    continue;
                }
                $remarkData1[] = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type,
                    'rmk_line_no' => $line_no1++,
                    'remark' => $tmprmk,
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
            }
            if ($remarkData1 != null) {
                $this->db->insert_batch('jama_remark', $remarkData1);
            } 
        }
        
        $query_pattadars = "select * from chitha_pattadar as cp where"
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and "
                . "  (lower(cp.jama_yn)!='y' or lower(cp.jama_yn)!='y')";

        $deleteQuery = "delete from jama_pattadar cp where "
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)=trim('$patta_no') and cp.patta_type_code='$patta_type' and entry_mode='U' and pdar_id not in "
                . " (select pdar_id from chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . " and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type' ) ";

        $pattadars = $this->db->query($query_pattadars)->result();
        foreach ($pattadars as $p) {
            $pflag = 0;
            $pdar_id = $p->pdar_id;
            $p->pdar_name = str_replace("'", "", $p->pdar_name);
            $p->pdar_father = str_replace("'", "", $p->pdar_father);
            $update_name_in_jama = "Update jama_pattadar set pdar_name='$p->pdar_name',pdar_father='$p->pdar_father' where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id' ";

            $this->db->query($update_name_in_jama);

            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id=$pdar_id and p_flag='1'";

            $p_flagCount = $this->db->query($count_q)->row()->count;

            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id = $pdar_id";

            $count_dag_q;

            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;


            $p->pdar_land_b = 0;
            $p->pdar_land_k = 0;
            $p->pdar_land_lc = 0;
            $p->pdar_land_g = 0;
            $p->pdar_land_kr = 0;

            if ($p_flagCount == $dag_presentCount) {
                $p->p_flag = '1';
            } else {
                $p->p_flag = '0';
            }

            $p->entry_date = $p->date_entry;
            $p->entry_mode = 'U';
            $p->pdar_id = $p->pdar_id;
            //$p->pdar_father=$p->pdar_father;
            unset($p->dag_por_b);
            unset($p->dag_por_k);
            unset($p->dag_por_lc);
            unset($p->dag_por_g);
            unset($p->dag_por_kr);
            unset($p->date_entry);
            unset($p->operation);
            unset($p->jama_yn);
            unset($p->pdar_guard_reln);
            unset($p->f1_case_no);
            unset($p->f2_case_no);
            unset($p->o1_case_no);
            unset($p->o2_case_no);
            unset($p->dag_no);
            unset($p->uuid);
            $query = "select count(*) as count from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";

            $pdar_id_query = "select max(cast (pdar_id as int)) as new_pdar_id from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' ";
            $pdar_id_new = $this->db->query($pdar_id_query)->row()->new_pdar_id;
            if ($pdar_id_new == null) {
                $pdar_id_new = 1;
            } else {
                $pdar_id_new +=1;
            }
            $count = $this->db->query($query)->row()->count;
            if ($count == 0) {
                $this->db->insert('jama_pattadar', $p); //......................
            }
            $count++;
        }
        $query_pattadars_pflag = "select * from chitha_dag_pattadar as cp where"
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' ";
        $toRemove = $this->db->query($query_pattadars_pflag)->result();
        // var_dump($d);
        // die;
        foreach ($toRemove as $remove) {
            ///////////////////////////////////////
            // var_dump()
            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id=$remove->pdar_id and p_flag='1'";
            // echo $count_q;
            // die;
            $p_flagCount = $this->db->query($count_q)->row()->count;
            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id = $remove->pdar_id";
            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;
            if ($p_flagCount == $dag_presentCount) {
                $remove->p_flag = '1';
            } else {
                $remove->p_flag = '0';
            }
            /////////////////////////////
            $this->db->query("update jama_pattadar cp set p_flag='$remove->p_flag' where "
                    . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                    . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                    . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and pdar_id = '$remove->pdar_id' ");
        }

        // $update_chitha = "update chitha_basic set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";

        $table = 'chitha_basic';
        $params = [
            'jama_yn' => 'y',
        ];
        $where = [
            'patta_no'           => trim($patta_no),         // Equivalent to TRIM(patta_no)
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];
        $tstatus = $this->Chitha_basic_model->update_table($table, $params, $where);


        // $update_pattadar = "update chitha_pattadar set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";

        $table = 'chitha_pattadar';
        $params = [
            'jama_yn' => 'y',
        ];
        $where = [
            'patta_no'           => trim($patta_no), // Equivalent to TRIM(patta_no)
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];
        // Execute the update
        $tstatus = $this->Chitha_basic_model->update_table($table, $params, $where);


        // $update_dag_pattadar = "update chitha_dag_pattadar set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";

        $table = 'chitha_dag_pattadar';

        $params = [
            'jama_yn' => 'y',
        ];

        $where = [
            'patta_no'           => trim($patta_no), // TRIM equivalent
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];

        // Execute the update
        $tstatus = $this->Chitha_basic_model->update_table($table, $params, $where);


        // $this->db->query($update_chitha); //..............................
        // $this->db->query($update_pattadar); //..............................
        // $this->db->query($update_dag_pattadar); //..............................

        if($case_no != null && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . $case_no);
        }

        $url="<a href='".base_url()."index.php/chithareport/jamadistrictDetails_dc_lao' class='text-primary' > Please click here to update another Jamabandi" ."</a>";
        $this->session->set_flashdata('message', sizeof($dags) .
                " updated in JamaBandi for Patta # $patta_no. In case "
                . " of any discrepancy between and chitha"
                . " and Jamabandi, Kindly use the Jamabandi Edit Entry Module to correct the Jamabandi. $url");
        redirect(base_url() . 'index.php/home/'); //..............................
    }

    public function getCol8Remark($patta_no, $district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $data1[$dag_no] = array();
        $innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,"
                . "ord.user_code,rajah_adalat,lm_code,case_no,co_ord_date,deed_reg_no,deed_value,deed_date,ord.operation,ord.co_code from "
                . "Chitha_col8_order ord,chitha_basic cb where ord.dist_code=cb.dist_code and ord.subdiv_code=cb.subdiv_code and "
                . "cb.cir_code=ord.cir_code and cb.mouza_pargona_code=ord.mouza_pargona_code and cb.lot_no=ord.lot_no and "
                . "cb.vill_townprt_code=ord.vill_townprt_code and cb.dag_no=ord.dag_no and TRIM(cb.patta_no)='$patta_no' and "
                . "ord.dist_code='$district_code' and ord.subdiv_code='$subdivision_code' and ord.cir_code='$circlecode' and "
                . "ord.mouza_pargona_code='$mouzacode' and  ord.lot_no='$lot_code' and ord.vill_townprt_code='$village_code' and "
                . "(ord.dag_no='$dag_no' or ord.new_dag_no='$dag_no') and (lower(ord.jama_updated)!='y' or ord.jama_updated is null)";
        $innerdata4 = $this->db->query($innerquery4)->result();
        foreach ($innerdata4 as $col8OrderDetails) {
            $col8order_cron_no = $col8OrderDetails->col8order_cron_no;
            $order_type_code = $col8OrderDetails->order_type_code;
            $nature_trans_code = $col8OrderDetails->nature_trans_code;
            $mut_land_area_b = $col8OrderDetails->mut_land_area_b;
            $mut_land_area_k = $col8OrderDetails->mut_land_area_k;
            $mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
            $user_code = $col8OrderDetails->user_code;
            $rajah_adalat = $col8OrderDetails->rajah_adalat;
            $lm_code = $col8OrderDetails->lm_code;
            $case_no = $col8OrderDetails->case_no;
            $co_ord_date = $col8OrderDetails->co_ord_date;
            $deed_value = $col8OrderDetails->deed_value;
            $deed_reg_no = $col8OrderDetails->deed_reg_no;
            $deed_date = $col8OrderDetails->deed_date;
            $operation = $col8OrderDetails->operation;
            $co_code = $col8OrderDetails->co_code;

            $inplace_of_name = "";
            $inplaceof_alongwith = "";
            $occupant_name = "";
            $occupant_fmh_name = "";
            $occupant_fmh_flag = "";
            $new_patta_no = "";
            $new_dag_no = "";
            $old_dag = "";
            $hus_wife = "";
            $nature_trans_desc = "";
            $lm_name = "";
            $objection = "";
            $applicant = "";
            $objection53=null;
            $innerquery5 = "select order_type from master_field_mut_type where order_type_code = '$order_type_code'";
            $innerdata5 = $this->db->query($innerquery5)->row();
            $ordertype = $innerdata5->order_type;
            $innerquery6 = "select inplace_of_name,inplaceof_alongwith from chitha_col8_inplace where dist_code='$district_code' and"
                    . " subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and"
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no'"
                    . " ORDER BY inplace_of_id";
            $innerdata6 = $this->db->query($innerquery6)->result();
            $inplace_data = array();
            $innerquery7 = "select trans_desc_as from nature_trans_code where trans_code = '$nature_trans_code'";
            $nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
            foreach ($innerdata6 as $inplace) {
                $inplace_data[] = array(
                    'inplace_of_name' => $inplace->inplace_of_name,
                    'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
                );
            }
            $occup_data = array();
            $innerquery8 = "select occupant_name,occupant_fmh_name,dag_no,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from "
                    . " chitha_col8_occup where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                    . " and (dag_no='$dag_no' or new_dag_no='$dag_no') and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code' ORDER BY occupant_id";
            $innerdata8 = $this->db->query($innerquery8)->result();
            foreach ($innerdata8 as $occupant) {
                $occupant_name = $occupant->occupant_name;
                $occupant_fmh_name = $occupant->occupant_fmh_name;
                $occupant_fmh_flag = $occupant->occupant_fmh_flag;
                $new_patta_no = $occupant->new_patta_no;
                $new_dag_no = $occupant->new_dag_no;
                $old_dag = $occupant->dag_no;
                $hus_wife = $occupant->hus_wife;
                $innerquery9 = "select guard_rel_desc_as from master_guard_rel where guard_rel = '$occupant_fmh_flag'";
                $innerdata9 = $this->db->query($innerquery9)->result();
                $guard_rel_desc_as = "";
                foreach ($innerdata9 as $guard_rel) {
                    $guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
                }
                $occup_data[] = array(
                    'occupant_name' => $occupant->occupant_name,
                    'occupant_fmh_name' => $occupant->occupant_fmh_name,
                    'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
                    'new_patta_no' => $occupant->new_patta_no,
                    'new_dag_no' => $occupant->new_dag_no,
                    'old_dag' => $occupant->dag_no,
                    'hus_wife' => $occupant->hus_wife,
                    'guard_rel_desc_as' => $guard_rel_desc_as
                );
            }
            $innerquery10 = "select lm_name from lm_code  where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
            $innerdata10 = $this->db->query($innerquery10)->result();

            foreach ($innerdata10 as $lm) {
                $lm_name = $lm->lm_name;
            }
            $innerquery11 = "select username,status from users where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
            $innerdata11 = $this->db->query($innerquery11)->result();
            foreach ($innerdata11 as $users) {
                $username = $users->username;
                $status = $users->status;
            }
            $innerquery12 = "select * from field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' and jama_yn='0' ";
            $innerdata12 = $this->db->query($innerquery12)->result();
            $innerquery13 = "select * from field_mut_petitioner where case_no='$case_no' ";
            $innerdata13 = $this->db->query($innerquery13)->result();
            if ($order_type_code == '01') {
                $innerquery14 = " select deed_reg_no,deed_value,deed_date from chitha_col8_order
                      where Order_type_code='$order_type_code' and case_no='$case_no' ";
                $innerdata14 = $this->db->query($innerquery14)->result();
                foreach ($innerdata14 as $deedinf) {
                    $deed_reg_no = $deedinf->deed_reg_no;
                    $deed_value = $deedinf->deed_value;
                    $deed_date = $deedinf->deed_date;
                }
            }
            if ($order_type_code == '03') {
                $innerquery14 = "select * from field_mut_objection where objection_case_no='$case_no' and 
                obj_flag is not null and chitha_correct_yn='1' and jama_yn='0' ";
                $objection = $this->db->query($innerquery14)->result();
                foreach ($objection as $obj) {
                    $q = "select col8order_cron_no,dag_no from chitha_col8_order where case_no='$obj->prev_fm_ca_no' ";
                    $col8_cronNo = $this->db->query($q)->row();
                    $q = "select occupant_name from chitha_col8_occup where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and 
                                col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
                    $result = $this->db->query($q)->result();
                    $fname = " ";
                    foreach ($result as $name) {
                        $fname = $fname . $name->occupant_name . ",";
                    }
                    $objection53[] = array(
                        'strikeoutObjection' => $fname,
                        'applicant' => $obj->obj_name,
                        'regist_date' => $obj->regist_date,
                        'submission_date' => $obj->submission_date,
                        'submission_date' => $obj->submission_date,
                        'case_no' => $obj->objection_case_no,
                        'prev_fm_ca_no' => $obj->prev_fm_ca_no,
                        'dag_no' => $obj->dag_no,
                    );
                }
            }
            
            $co_name = "select username from users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$co_code'";
            $co_name = $this->db->query($co_name)->result();
            foreach ($co_name as $co) {
                    $co_username = $co->username;
            }
            
            $data1[$dag_no]['col8'][] = array(
                'co_ord_date' => $col8OrderDetails->co_ord_date,
                'order_type_code' => $col8OrderDetails->order_type_code,
                'case_no' => $col8OrderDetails->case_no,
                'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
                'order_type' => $ordertype,
                'nature_trans_code' => $col8OrderDetails->nature_trans_code,
                'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
                'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
                'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
                'inplace' => $inplace_data,
                'occup' => $occup_data,
                'rajah' => $rajah_adalat,
                'deed_value' => $deed_value,
                'deed_reg_no' => $deed_reg_no,
                'deed_date' => $deed_date,
                'lm_name' => $lm_name,
                'username' => $username,
                'objection' => $objection53,
                'operation' => $operation,
                'co_name' => $co_username
            );
            $q = "update chitha_col8_order set jama_updated='y' where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and"
                    . " vill_townprt_code='$village_code' and (dag_no='$dag_no') and col8order_cron_no='$col8order_cron_no'";
            $this->db->query($q); //..............................
        }
        return $data1;
    }


    public function getCol8Remark_kar($patta_no, $district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $data1[$dag_no] = array();
        $innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,mut_land_area_g,mut_land_area_kr,"
                . "ord.user_code,rajah_adalat,lm_code,case_no,co_ord_date,deed_reg_no,deed_value,deed_date,ord.operation,ord.co_code from "
                . "Chitha_col8_order ord,chitha_basic cb where ord.dist_code=cb.dist_code and ord.subdiv_code=cb.subdiv_code and "
                . "cb.cir_code=ord.cir_code and cb.mouza_pargona_code=ord.mouza_pargona_code and cb.lot_no=ord.lot_no and "
                . "cb.vill_townprt_code=ord.vill_townprt_code and cb.dag_no=ord.dag_no and TRIM(cb.patta_no)='$patta_no' and "
                . "ord.dist_code='$district_code' and ord.subdiv_code='$subdivision_code' and ord.cir_code='$circlecode' and "
                . "ord.mouza_pargona_code='$mouzacode' and  ord.lot_no='$lot_code' and ord.vill_townprt_code='$village_code' and "
                . "(ord.dag_no='$dag_no' or ord.new_dag_no='$dag_no') and (lower(ord.jama_updated)!='y' or ord.jama_updated is null)";
        $innerdata4 = $this->db->query($innerquery4)->result();
        foreach ($innerdata4 as $col8OrderDetails) {
            $col8order_cron_no = $col8OrderDetails->col8order_cron_no;
            $order_type_code = $col8OrderDetails->order_type_code;
            $nature_trans_code = $col8OrderDetails->nature_trans_code;
            $mut_land_area_b = $col8OrderDetails->mut_land_area_b;
            $mut_land_area_k = $col8OrderDetails->mut_land_area_k;
            $mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
            $mut_land_area_g = $col8OrderDetails->mut_land_area_g;
            $mut_land_area_kr = $col8OrderDetails->mut_land_area_kr;
            $user_code = $col8OrderDetails->user_code;
            $rajah_adalat = $col8OrderDetails->rajah_adalat;
            $lm_code = $col8OrderDetails->lm_code;
            $case_no = $col8OrderDetails->case_no;
            $co_ord_date = $col8OrderDetails->co_ord_date;
            $deed_value = $col8OrderDetails->deed_value;
            $deed_reg_no = $col8OrderDetails->deed_reg_no;
            $deed_date = $col8OrderDetails->deed_date;
            $operation = $col8OrderDetails->operation;
            $co_code = $col8OrderDetails->co_code;

            $inplace_of_name = "";
            $inplaceof_alongwith = "";
            $occupant_name = "";
            $occupant_fmh_name = "";
            $occupant_fmh_flag = "";
            $new_patta_no = "";
            $new_dag_no = "";
            $old_dag = "";
            $hus_wife = "";
            $nature_trans_desc = "";
            $lm_name = "";
            $objection = "";
            $applicant = "";
            $innerquery5 = "select order_type from master_field_mut_type where order_type_code = '$order_type_code'";
            $innerdata5 = $this->db->query($innerquery5)->row();
            $ordertype = $innerdata5->order_type;
            $innerquery6 = "select inplace_of_name,inplaceof_alongwith from chitha_col8_inplace where dist_code='$district_code' and"
                    . " subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and"
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no'"
                    . " ORDER BY inplace_of_id";
            $innerdata6 = $this->db->query($innerquery6)->result();
            $inplace_data = array();
            $innerquery7 = "select trans_desc_as from nature_trans_code where trans_code = '$nature_trans_code'";
            $nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
            foreach ($innerdata6 as $inplace) {
                $inplace_data[] = array(
                    'inplace_of_name' => $inplace->inplace_of_name,
                    'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
                );
            }
            $occup_data = array();
            $innerquery8 = "select occupant_name,occupant_fmh_name,dag_no,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from "
                    . " chitha_col8_occup where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                    . " and (dag_no='$dag_no' or new_dag_no='$dag_no') and Col8Order_cron_no='$col8order_cron_no' ORDER BY occupant_id";
            $innerdata8 = $this->db->query($innerquery8)->result();
            foreach ($innerdata8 as $occupant) {
                $occupant_name = $occupant->occupant_name;
                $occupant_fmh_name = $occupant->occupant_fmh_name;
                $occupant_fmh_flag = $occupant->occupant_fmh_flag;
                $new_patta_no = $occupant->new_patta_no;
                $new_dag_no = $occupant->new_dag_no;
                $old_dag = $occupant->dag_no;
                $hus_wife = $occupant->hus_wife;
                $innerquery9 = "select guard_rel_desc_as from master_guard_rel where guard_rel = '$occupant_fmh_flag'";
                $innerdata9 = $this->db->query($innerquery9)->result();
                $guard_rel_desc_as = "";
                foreach ($innerdata9 as $guard_rel) {
                    $guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
                }
                $occup_data[] = array(
                    'occupant_name' => $occupant->occupant_name,
                    'occupant_fmh_name' => $occupant->occupant_fmh_name,
                    'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
                    'new_patta_no' => $occupant->new_patta_no,
                    'new_dag_no' => $occupant->new_dag_no,
                    'old_dag' => $occupant->dag_no,
                    'hus_wife' => $occupant->hus_wife,
                    'guard_rel_desc_as' => $guard_rel_desc_as
                );
            }
            $innerquery10 = "select lm_name from lm_code  where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
            $innerdata10 = $this->db->query($innerquery10)->result();

            foreach ($innerdata10 as $lm) {
                $lm_name = $lm->lm_name;
            }
            $innerquery11 = "select username,status from users where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
            $innerdata11 = $this->db->query($innerquery11)->result();
            foreach ($innerdata11 as $users) {
                $username = $users->username;
                $status = $users->status;
            }
            $innerquery12 = "select * from field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' and jama_yn='0' ";
            $innerdata12 = $this->db->query($innerquery12)->result();
            $innerquery13 = "select * from field_mut_petitioner where case_no='$case_no' ";
            $innerdata13 = $this->db->query($innerquery13)->result();
            if ($order_type_code == '01') {
                $innerquery14 = " select deed_reg_no,deed_value,deed_date from chitha_col8_order
                      where Order_type_code='$order_type_code' and case_no='$case_no' ";
                $innerdata14 = $this->db->query($innerquery14)->result();
                foreach ($innerdata14 as $deedinf) {
                    $deed_reg_no = $deedinf->deed_reg_no;
                    $deed_value = $deedinf->deed_value;
                    $deed_date = $deedinf->deed_date;
                }
            }
            if ($order_type_code == '03') {
                $innerquery14 = "select * from field_mut_objection where objection_case_no='$case_no' and 
                obj_flag is not null and chitha_correct_yn='1' and jama_yn='0' ";
                $objection = $this->db->query($innerquery14)->result();
                foreach ($objection as $obj) {
                    $q = "select col8order_cron_no,dag_no from chitha_col8_order where case_no='$obj->prev_fm_ca_no' ";
                    $col8_cronNo = $this->db->query($q)->row();
                    $q = "select occupant_name from chitha_col8_occup where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and 
                                col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
                    $result = $this->db->query($q)->result();
                    $fname = " ";
                    foreach ($result as $name) {
                        $fname = $fname . $name->occupant_name . ",";
                    }
                    $objection53[] = array(
                        'strikeoutObjection' => $fname,
                        'applicant' => $obj->obj_name,
                        'regist_date' => $obj->regist_date,
                        'submission_date' => $obj->submission_date,
                        'submission_date' => $obj->submission_date,
                        'case_no' => $obj->objection_case_no,
                        'prev_fm_ca_no' => $obj->prev_fm_ca_no,
                        'dag_no' => $obj->dag_no,
                    );
                }
            }
            
            $co_name = "select username from users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$co_code'";
            $co_name = $this->db->query($co_name)->result();
            foreach ($co_name as $co) {
                    $co_username = $co->username;
            }
            
            $data1[$dag_no]['col8'][] = array(
                'co_ord_date' => $col8OrderDetails->co_ord_date,
                'order_type_code' => $col8OrderDetails->order_type_code,
                'case_no' => $col8OrderDetails->case_no,
                'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
                'order_type' => $ordertype,
                'nature_trans_code' => $col8OrderDetails->nature_trans_code,
                'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
                'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
                'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
                'mut_land_area_g' => $col8OrderDetails->mut_land_area_g,
                'mut_land_area_kr' => $col8OrderDetails->mut_land_area_kr,
                'inplace' => $inplace_data,
                'occup' => $occup_data,
                'rajah' => $rajah_adalat,
                'deed_value' => $deed_value,
                'deed_reg_no' => $deed_reg_no,
                'deed_date' => $deed_date,
                'lm_name' => $lm_name,
                'username' => $username,
                'objection' => $objection53,
                'operation' => $operation,
                'co_name' => $co_username
            );
            $q = "update chitha_col8_order set jama_updated='y' where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and"
                    . " vill_townprt_code='$village_code' and (dag_no='$dag_no') and col8order_cron_no='$col8order_cron_no'";
            $this->db->query($q); //..............................
        }
        return $data1;
    }

    public function generate8Remark_kar($dag_no, $chithainf) {
        $index = 1;
        $remAll = array();
        
        if (sizeof($chithainf[$dag_no]) > 0) {
            foreach ($chithainf[$dag_no]['col8'] as $clmn8) {
                //var_dump($clmn8);
                $remarkCreate = "";
                $co_order_date1 = $clmn8['co_ord_date'];
                $case_no = $clmn8['case_no'];
                $col8order_cron_no = $clmn8['col8order_cron_no'];
                $order_type = $clmn8['order_type'];
                $co_order_date = strtotime($co_order_date1);
                $formatDate = date("d/m/Y", $co_order_date);
                $order_type_code  = $clmn8['order_type_code'];
                $nature_trans_code = $clmn8['nature_trans_code'];
                $mut_land_area_b = $clmn8['mut_land_area_b'];
                $mut_land_area_k = $clmn8['mut_land_area_k'];
                $mut_land_area_lc = $clmn8['mut_land_area_lc'];
                $mut_land_area_g = $clmn8['mut_land_area_g'];
                $remarkCreate = "চক্র আধিকারিকের <br>" . $formatDate . " তারিখের ";
                if ($order_type_code == "01") {
                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . ' বিঘা ';
                    } else {
                        $bigha = "";
                    }
                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . ' কাঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . ' ছটাক ';
                    } else {
                        $lesa = "";
                    }
                     if ($mut_land_area_g != '0') {
                        $gonda = $mut_land_area_g . ' গণ্ডা ';
                    } else {
                        $gonda = "";
                    }
                }else if ($order_type_code == "02") {
                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . ' বিঘা ';
                    } else {
                        $bigha = "";
                    }
                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . ' কাঠা ';
                    }else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . ' ছটাক ';
                    }else {
                        $lesa = "";
                    }
                     if ($mut_land_area_g != '0') {
                        $gonda = $mut_land_area_g . ' গণ্ডা ';
                    }else {
                        $gonda = "";
                    }
                }
                //var_dump($clmn8['objection']);
                foreach($clmn8['objection'] as $obj53){
                    $strikeoutObjection=$obj53['strikeoutObjection'];
                    $applicant=$obj53['applicant'];
                    $dagNo=$obj53['dag_no'];
                    $reg_date= date('d/m/Y',strtotime($obj53['regist_date']));
                    $submission_date= date('d/m/Y',strtotime($obj53['submission_date']));
                    $oldcase_no= $obj53['prev_fm_ca_no'];
                }
                $remarkCreate .= $order_type . ' নং ' . $case_no . '-এর' . ' হুকুমমর্মে '  ;
                if($order_type_code!='03'){
                    $remarkCreate .= $clmn8['occup'][0]['old_dag'] . '  নং  দাগের '. $bigha . $katha . $lesa . $gonda . ' মাটি  ';
                }
                if ($order_type_code == "01") {
                    $remarkCreate .= " " . $this->utilityclass->getTransferType($clmn8['nature_trans_code']) . " ";
                }
                if ($order_type_code == "03") {
                    $remarkCreate .= $dagNo . ' নং  দাগের'. $applicant ." য়ে দিয়া চিঠি অভিযোগ সাপেক্ষে  ";
                    $remarkCreate .= $oldcase_no . " নং ". date('d-m-y', strtotime($submission_date)) ." তারিখের হুকুম নাকচ করা হয় এবং ". $strikeoutObjection ." নাম  কর্তন করা  হয়  । ";
                }
                foreach ($clmn8['inplace'] as $in) {
                    $remarkCreate .= $in['inplace_of_name'] . " এর ";
                    switch ($in['inplaceof_alongwith']) {
                        case 'i':
                            $remarkCreate .= " স্থলে ";
                            break;
                        case 'a':
                            $remarkCreate .= " সামিলে  ";
                            break;
                    }
                }
                $count = 0;
                $howmany = sizeof($clmn8['occup']) - 1;
                foreach ($clmn8['occup'] as $in) {
                    $r = "";
                    switch ($in['occupant_fmh_flag']) {
                        case 'm':
                            $r = " মাতা ";
                            break;
                        case 'f':
                            $r = " পিং ";
                            break;
                        case 'h':
                            $r = " পতি ";
                            break;
                        case 'w':
                            $r = " পত্নী ";
                            break;
                        case 'a':
                            $r = " অধ্যক্ষ মাতা ";
                            break;
                        default:
                            $r = " অভিভাৱক ";
                    }
                    $remarkCreate .= $in['occupant_name'] . " ($r " . $in['occupant_fmh_name'] . ")";
                    if ($count < sizeof($clmn8['occup']) - 1) {
                        $remarkCreate .= " এবং ";
                        $count++;
                    }
                }

                if ($clmn8['order_type_code'] == '01') {
                    $remarkCreate .= " নামে নামজারী করা হইল |<br>";
                } else if ($clmn8['order_type_code'] == '02') {
                    $remarkCreate .= " র নামে " . $clmn8['occup'][0]['new_dag_no'] . " নং দাগে এবং " . $clmn8['occup'][0]['new_patta_no'] . " নং ম্যাদী পাট্টা  করা হইল । <br>";
                }
                
                if (($clmn8['rajah'] != 0) || ($clmn8['rajah'] == 'y')) {
                    $remarkCreate .= "<p><span style='color:blue'>( রাজস্ব আদালত )</span></p>";
                }
                if($clmn8['order_type_code'] !='03'){
                $remarkCreate .= "Registration Deed No:" . $clmn8['deed_reg_no'] . "<br>";

                $remarkCreate .= "Deed Value:" . $clmn8['deed_value'] . "<br>";

                $interval = date_diff(date_create('01-01-1970'), date_create($clmn8['deed_date']));

                if ($interval->days > 0)
                    $remarkCreate .= "Deed Date:" . date('d-m-y', strtotime($clmn8['deed_date'])) . ") ";

                $remarkCreate .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u>($clmn8[lm_name])</p>";
                }
                $remarkCreate .= "<p><u class='text-danger'>চক্র আধিকারিক :</u>($clmn8[username])</p>";

                $remAll[] = $remarkCreate;
            }
            //var_dump($remAll);
            //exit;
            return $remAll;
        }
    }

    public function generate8Remark($dag_no, $chithainf) {
        $index = 1;
        $remAll = array();

        if (sizeof($chithainf[$dag_no]) > 0) {
            foreach ($chithainf[$dag_no]['col8'] as $clmn8) {
                //var_dump($clmn8);
                $remarkCreate = "";
                $co_order_date1 = $clmn8['co_ord_date'];
                $case_no = $clmn8['case_no'];
                $col8order_cron_no = $clmn8['col8order_cron_no'];
                $order_type = $clmn8['order_type'];
                $co_order_date = strtotime($co_order_date1);
                $formatDate = date("d/m/Y", $co_order_date);
                $order_type_code = $clmn8['order_type_code'];
                $nature_trans_code = $clmn8['nature_trans_code'];
                $mut_land_area_b = $clmn8['mut_land_area_b'];
                $mut_land_area_k = $clmn8['mut_land_area_k'];
                $mut_land_area_lc = $clmn8['mut_land_area_lc'];
                $remarkCreate = "চক্ৰ বিষয়াৰ <br>" . $formatDate . " তাৰিখৰ ";
                if ($order_type_code == "01") {
                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . ' বিঘা ';
                    } else {
                        $bigha = "";
                    }
                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . ' কঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . ' লেছা ';
                    } else {
                        $lesa = "";
                    }
                } else if ($order_type_code == "02") {
                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . ' বিঘা ';
                    } else {
                        $bigha = "";
                    }
                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . ' কঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . ' লেছা ';
                    } else {
                        $lesa = "";
                    }
                }
                //var_dump($clmn8['objection']);
                foreach ((array)($clmn8['objection'] ?? []) as $obj53) {
                    $strikeoutObjection = $obj53['strikeoutObjection'];
                    $applicant = $obj53['applicant'];
                    $dagNo = $obj53['dag_no'];
                    $reg_date = date('d/m/Y', strtotime($obj53['regist_date']));
                    $submission_date = date('d/m/Y', strtotime($obj53['submission_date']));
                    $oldcase_no = $obj53['prev_fm_ca_no'];
                }
                $remarkCreate .= $order_type . ' নং ' . $case_no . '-ৰ ' . ' হুকুমমৰ্মে ';
                if ($order_type_code != '03') {
                    $remarkCreate .= $clmn8['occup'][0]['old_dag'] . '  নং  দাগৰ ' . $bigha . $katha . $lesa . ' মাটি  ';
                }
                if ($order_type_code == "01") {
                    $remarkCreate .= " " . $this->utilityclass->getTransferType($clmn8['nature_trans_code']) . " ";
                }
                if ($order_type_code == "03") {
                    $remarkCreate .= $dagNo . ' নং  দাগৰ ' . $applicant . " য়ে দিয়া চিঠি অভিযোগ সাপেক্ষে  ";
                    $remarkCreate .= $oldcase_no . " নং " . date('d-m-y', strtotime($submission_date)) . " তাৰিখৰ হুকুম নাকচ কৰা হয় আৰু " . $strikeoutObjection . " নাম  কৰ্তন কৰা  হয়  । ";
                }
                foreach ($clmn8['inplace'] as $in) {
                    $remarkCreate .= $in['inplace_of_name'] . " ৰ ";
                    switch ($in['inplaceof_alongwith']) {
                        case 'i':
                            $remarkCreate .= " স্হলত ";
                            break;
                        case 'a':
                            $remarkCreate .= " লগত  ";
                            break;
                    }
                }
                $count = 0;
                $howmany = sizeof($clmn8['occup']) - 1;
                foreach ($clmn8['occup'] as $in) {
                    $r = "";
                    switch ($in['occupant_fmh_flag']) {
                        case 'm':
                            $r = " মাতৃ ";
                            break;
                        case 'f':
                            $r = " পিতৃ ";
                            break;
                        case 'h':
                            $r = " পতি ";
                            break;
                        case 'w':
                            $r = " পত্নী ";
                            break;
                        case 'a':
                            $r = " অধ্যক্ষ মাতা ";
                            break;
                        default:
                            $r = " অভিভাৱক ";
                    }
                    $remarkCreate .= $in['occupant_name'] . " ($r " . $in['occupant_fmh_name'] . ")";
                    if ($count < sizeof($clmn8['occup']) - 1) {
                        $remarkCreate .= " আৰু ";
                        $count++;
                    }
                }

                if ($clmn8['order_type_code'] == '01') {
                    $remarkCreate .= " নামত নামজাৰী কৰা হ’ল |<br>";
                } else if ($clmn8['order_type_code'] == '02') {
                    $remarkCreate .= " ৰ নামত " . $clmn8['occup'][0]['new_dag_no'] . " নং দাগ আৰু " . $clmn8['occup'][0]['new_patta_no'] . " নং ম্যাদী পট্টা  কৰা হল । <br>";
                }

                if (($clmn8['rajah'] != 0) || ($clmn8['rajah'] == 'y')) {
                    $remarkCreate .= "<p><span style='color:blue'>( ৰাজহ আদলত )</span></p>";
                }
                if ($clmn8['order_type_code'] != '03') {
                    if($clmn8['deed_reg_no']){
                        $remarkCreate .= "Registration Deed No:" . $clmn8['deed_reg_no'] . "<br>";
                        $remarkCreate .= "Deed Value:" . $clmn8['deed_value'] . "<br>";
                        $interval = date_diff(date_create('01-01-1970'), date_create($clmn8['deed_date']));
                        if ($interval->days > 0)
                            $remarkCreate .= "Deed Date:" . date('d-m-y', strtotime($clmn8['deed_date'])) . ") ";
                    }
                }
                $remarkCreate .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u>($clmn8[lm_name])</p>";
                $remarkCreate .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u>($clmn8[username])</p>";
                if ($clmn8['order_type_code'] == '01' and  $clmn8['operation'] == 'B') {
                    $remarkCreate .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                    $remarkCreate .= "<br><u class='text-danger'> চঃ বিঃ –  ".$clmn8['co_name']."</u>";
                }elseif ($clmn8['order_type_code'] == '02' and  $clmn8['operation'] == 'B') {
                    $remarkCreate .= " ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত আপোচ বাটোৱাৰা ও নথি সংশোধন কৰা হ’ল ।   ";
                    $remarkCreate .= "<br><u class='text-danger'> চঃ বিঃ –  ".$clmn8['co_name']."</u>";
                }
                $remAll[] = $remarkCreate;
            }
            //var_dump($remAll);
            //exit;
            return $remAll;
        }
    }

    public function getCol31Other($patta_no, $district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $data[] = array();

        $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from chitha_rmk_gen where  "
                . "dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'  and"
                . " (dag_no ='$dag_no' ) and (lower(jama_updated)!='y' or jama_updated is null)  order by rmk_type_hist_no";

        $innerdata26 = $this->db->query($innerquery26)->result();

        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;

            if ($rmk_type_code == "01") {

                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                        . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc  "
                        . " from chitha_rmk_ordbasic where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                        . " and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";

                $innerdata27 = $this->db->query($innerquery27)->result();

                foreach ($innerdata27 as $chitharmk_ord_basic) {
                    $dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
                    $order_date = $chitharmk_ord_basic->ord_date;
                    $ord_no = $chitharmk_ord_basic->ord_no;
                    $case_no = $chitharmk_ord_basic->case_no;
                    $ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
                    $lm_code = $chitharmk_ord_basic->lm_code;
                    $co_code = $chitharmk_ord_basic->co_code;
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;

                    if ($ord_type_code == '01') {

                        $innerquery28 = " select patta_no,patta_type_code FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                                . "rmk_type_hist_no='$rmk_type_hist_no' ";

                        $innerdata28 = $this->db->query($innerquery28)->result();

                        $patta_no = "";
                        $patta_type_code = "";
                        $patta_type = "";
                        $premium = "";
                        $premi_chal_recpt_no = "";
                        $premi_chal_recpt = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $land_area_b = "";
                        $land_area_k = "";
                        $land_area_lc = "";
                        $username = "";
                        $lm_name = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $chalan_name = "";

                        foreach ($innerdata28 as $rmkconvorder) {
                            $patta_no = trim($rmkconvorder->patta_no);
                            $patta_type_code = $rmkconvorder->patta_type_code;
                            $innerquery29 = "select patta_type from patta_code where type_code=' $patta_type_code' ";
                            $innerdata29 = $this->db->query($innerquery29)->result();

                            foreach ($innerdata29 as $pattatype) {
                                $patta_type = $pattatype->patta_type;
                            }
                        }

                        if ($ord_type_code === '01') {

                            $innerquery30 = "select  distinct premium as premium,premi_chal_recpt_no "
                                    . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                    . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                    . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null";

                            //echo $innerquery30;   
                        } else {
                            $innerquery30 = "select  distinct sum(premium) as premium,premi_chal_recpt_no "
                                    . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                    . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                    . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null group by premi_chal_recpt_no";
                        }

                        $innerdata30 = $this->db->query($innerquery30)->result();
                        foreach ($innerdata30 as $premiuminfo) {
                            $premium = $premiuminfo->premium;
                            $premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;

                            $innerquery31 = "select chalan_name from premium_chalan_receipt where code='$premi_chal_recpt'";
                            $innerdata31 = $this->db->query($innerquery31)->result();
                            foreach ($innerdata31 as $premiumchalanrecpt) {
                                $chalan_name = $premiumchalanrecpt->chalan_name;
                            }
                        }

                        $innerquery32 = "select  dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
                                . " dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                                . " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                                . " rmk_type_hist_no='$rmk_type_hist_no'  ";
                        $innerdata32 = $this->db->query($innerquery32)->result();
                        $applicants = array();
                        foreach ($innerdata32 as $rmk_conv) {

                            $dag_no = $rmk_conv->dag_no;
                            $new_patta_no = $rmk_conv->new_patta_no;
                            $new_dag_no = $rmk_conv->new_dag_no;
                            $ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;
                            if ($ord_type_code === '01') {
                                $innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
                                        . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                        . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            } else {
                                $innerquery33 = "select sum(land_area_b) as land_area_b,sum(land_area_k) as land_area_k,sum(land_area_lc) as "
                                        . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                        . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            }

                            $innerdata33 = $this->db->query($innerquery33)->result();
                            foreach ($innerdata33 as $bklconvorder) {
                                $land_area_b = $bklconvorder->land_area_b;
                                $land_area_k = $bklconvorder->land_area_k;
                                $land_area_lc = $bklconvorder->land_area_lc;
                            }
                            $applicants[] = array(
                                'app_name' => $ord_onbehalf_of,
                                'dag_no' => $dag_no,
                                'new_dag_no' => $new_dag_no,
                                'new_patta_no' => $new_patta_no,
                            );
                        }

                        $innerquery34 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata34 = $this->db->query($innerquery34)->result();

                        foreach ($innerdata34 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata35 = $this->db->query($innerquery35)->result();
                        foreach ($innerdata35 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'patta_no' => "$patta_no",
                            'patta_type_code' => "$patta_type_code",
                            'patta_type' => "$patta_type",
                            'premium' => "$premium",
                            'premi_chal_recpt_no' => "$premi_chal_recpt_no",
                            'premi_chal_recpt' => "$premi_chal_recpt",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'ord_onbehalf_of' => $applicants,
                            'land_area_b' => "$land_area_b",
                            'land_area_k' => "$land_area_k",
                            'land_area_lc' => "$land_area_lc",
                            'username' => "$username",
                            'lm_name' => "$lm_name",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'chalan_name' => "$chalan_name",
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => '01',
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code
                        );
                    }

                    if ($ord_type_code == "02") {

                        $innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from chitha_rmk_allottee  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata36 = $this->db->query($innerquery36)->result();
                        $ord_date = "";
                        $dag_no = "";
                        $ord_ref_let_no = "";
                        $allottee_name = "";
                        $allottee_land_code = "";
                        $allottee_land_b = "";
                        $allottee_land_k = "";
                        $allottee_land_lc = "";
                        $type = "";
                        $lm_name = "";
                        $status = "";
                        foreach ($innerdata36 as $allotee) {
                            $ord_date = $allotee->ord_date;
                            $dag_no = $allotee->dag_no;
                            $ord_ref_let_no = $allotee->ord_ref_let_no;
                            $allottee_name = $allotee->allottee_name;
                            $allottee_land_code = $allotee->allottee_land_code;
                            $allottee_land_b = $allotee->allottee_land_b;
                            $allottee_land_k = $allotee->allottee_land_k;
                            $allottee_land_lc = $allotee->allottee_land_lc;

                            $innerquery37 = "select  type from  ord_on_gl_type_code where type_code='$allottee_land_code'";
                            $innerdata37 = $this->db->query($innerquery37)->result();
                            foreach ($innerdata37 as $ord_on_typ) {
                                $type = $ord_on_typ->type;
                            }
                        }


                        $innerquery38 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata38 = $this->db->query($innerquery38)->result();
                        foreach ($innerdata38 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery39 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata39 = $this->db->query($innerquery39)->result();
                        foreach ($innerdata39 as $userinfo) {
                            $username = $userinfo->username;
                        }
                        $data[] = array(
                            'ord_date' => $ord_date,
                            'dag_no' => $dag_no,
                            'ord_ref_let_no' => $ord_ref_let_no,
                            'allottee_name' => $allottee_name,
                            'allottee_land_code' => $allottee_land_code,
                            'allottee_land_b' => $allottee_land_b,
                            'allottee_land_k' => $allottee_land_k,
                            'allottee_land_lc' => $allottee_land_lc,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name
                        );
                    }

                    if ($ord_type_code == "03") {

                        $innerquery40 = "SELECT inplace_of_name FROM chitha_rmk_inplace_of  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                        $innerdata40 = $this->db->query($innerquery40)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $inplace_of_name = "";
                        $alongwithname = "";
                        $lm_name = "";
                        $status = "";
                        $username = "";
                        foreach ($innerdata40 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                        }

                        $innerquery41 = "select alongwith_name  FROM chitha_rmk_alongwith where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata41 = $this->db->query($innerquery41)->result();
                        $alongwitharray = array();
                        foreach ($innerdata41 as $alongwith) {

                            $alongwithname = $alongwith->alongwith_name;
                            $alongwitharray[] = array(
                                'alongwithname' => $alongwithname
                            );
                        }

                        $innerquery41 = "select inplace_of_name  FROM chitha_rmk_inplace_of where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata46 = $this->db->query($innerquery41)->result();
                        $inplaceofarray = array();
                        foreach ($innerdata46 as $inplace) {

                            $inplace_of_name = $inplace->inplace_of_name;
                            $inplaceofarray[] = array(
                                'inplace_of_name' => $inplace_of_name
                            );
                        }


                        $innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
                                . " new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
                                . " and rmk_type_hist_no='$rmk_type_hist_no'"
                                . " and ord_no= '$ord_no' ";

                        $innerdata42 = $this->db->query($innerquery42)->result();
                        $infav = array();
                        foreach ($innerdata42 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;

                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;
                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }

                        $innerquery43 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata43 = $this->db->query($innerquery43)->result();

                        foreach ($innerdata43 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery44 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata44 = $this->db->query($innerquery44)->result();
                        foreach ($innerdata44 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc from chitha_rmk_ordbasic "
                                . " where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no'";
                        $m_area = $this->db->query($innerquery45)->row();
                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'alongwith_name' => $alongwitharray,
                            'inplace_of_name' => $inplaceofarray,
                            'bigha' => $m_area_b,
                            'katha' => $m_area_k,
                            'lessa' => $m_area_lc,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'order_date' => $order_date
                        );
                    }


                    if ($ord_type_code == "04") {

                        $innerquery45 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata45 = $this->db->query($innerquery45)->result();
                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $infav = array();
                        foreach ($innerdata45 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;

                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;
                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        } //infav query bracket

                        $innerquery46 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata46 = $this->db->query($innerquery46)->result();
                        $lm_name = "";
                        foreach ($innerdata46 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery47 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata47 = $this->db->query($innerquery47)->result();
                        $username = "";
                        $status = "";
                        foreach ($innerdata47 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }
                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'bigha' => $m_dag_area_b,
                            'katha' => $m_dag_area_k,
                            'lessa' => $m_dag_area_lc
                        );
                    }

                    if ($ord_type_code == "05") {
                        $innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,case_type_code from chitha_rmk_other_opp_party where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";
                        $name_for = "";
                        $name_for_land_b = "";
                        $name_for_land_k = "";
                        $name_for_land_lc = "";
                        $case_type_code = "";
                        $case_type_name = "";
                        $lm_name = "";
                        $username = "";
                        $status = "";
                        $innerdata48 = $this->db->query($innerquery48)->result();
                        foreach ($innerdata48 as $opp_party) {
                            $name_for = $opp_party->name_for;
                            $name_for_land_b = $opp_party->name_for_land_b;
                            $name_for_land_k = $opp_party->name_for_land_k;
                            $name_for_land_lc = $opp_party->name_for_land_lc;
                            $case_type_code = $opp_party->case_type_code;

                            $innerquery49 = "select case_type_name from case_type_code where case_type_code='$case_type_code'";
                            $innerdata49 = $this->db->query($innerquery49)->result();
                            foreach ($innerdata49 as $casename) {
                                $case_type_name = $casename->case_type_name;
                            }
                        }

                        $innerquery50 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata50 = $this->db->query($innerquery50)->result();
                        foreach ($innerdata50 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery51 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata51 = $this->db->query($innerquery51)->result();
                        foreach ($innerdata51 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }
                        $data[] = array(
                            'name_for' => $name_for,
                            'name_for_land_b' => $name_for_land_b,
                            'name_for_land_k' => $name_for_land_k,
                            'name_for_land_lc' => $name_for_land_lc,
                            'case_type_code' => $case_type_code,
                            'case_type_name' => $case_type_name,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'order_type_code' => $ord_type_code,
                        );
                    }
                }
            }

            if ($rmk_type_code == '02') {

                $innerquery56 = "select  lm_note,lm_note_date,lm_code FROM chitha_rmk_lmnote where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";

                $innerdata56 = $this->db->query($innerquery56)->result();
                foreach ($innerdata as $lmnote) {
                    $lm_note = $lmnote->lm_note;
                    $lm_note_date = $lmnote->lm_note_date;
                    $lm_code = $lmnote->lm_code;
                }
            }

            if ($rmk_type_code == '03') {

                $innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";


                $innerdata57 = $this->db->query($innerquery57)->result();

                foreach ($innerdata57 as $sknoteinf) {

                    $sk_note = $sknoteinf->sk_note;
                    $sk_note_date = $sknoteinf->sk_note_date;
                }
            }

            if ($rmk_type_code == '04') {

                $innerquery58 = "SELECT encro_evicted_yn,encro_name FROM chitha_rmk_encro dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";

                $innerdata58 = $this->db->query($innerquery58)->result();
                foreach ($innerdata58 as $encro) {
                    $encro_evicted_yn = $encro->encro_evicted_yn;
                    $encro_name = $encro->encro_name;
                }
            }
            //for reclassfication
            if ($rmk_type_code == '08') {
                $check = $this->db->query("SELECT * FROM t_reclassification where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ")->row()->c;

                if ($check <= '0') {
                    $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                } else {
                    $innerquery59 = "SELECT * FROM t_reclassification where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                }
                
                $get_user_designation = "Select user_code as order_designation from chitha_rmk_gen where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
                        
                $str = $this->db->query($get_user_designation)->row()->order_designation;
                
                $order_designation = preg_replace('#\d.*$#', '', $str);
                
                $get_designation_name = $this->db->query("Select user_desig_as as user_desig_as from master_user_designation where user_desig_code = '$order_designation'")->row()->user_desig_as;

                $innerdata59 = $this->db->query($innerquery59)->result();
                foreach ($innerdata59 as $encro) {
                    $reclass_case_no = $encro->case_no;
                    $present_land_class = $encro->present_land_class;
                    $proposed_land_class = $encro->proposed_land_class;
                    $dag = $encro->dag_no;
                    $patta = trim($encro->patta_no);
                    $orderpass = $encro->co_chitha_updated_date;
                    $present_land_class = $encro->present_land_class;
                }
                $data[] = array(
                    'reclass_case_no' => $reclass_case_no,
                    'present_land_class' => $present_land_class,
                    'proposed_land_class' => $proposed_land_class,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '00',
                    'dag_no' => $dag_no,
                    'patta_no' => $patta,
                    'date' => $orderpass,
                    'presentclass' => $present_land_class,
                    'order_passed_designation' => $get_designation_name,
                );
            }

            $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                    . "dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'  and"
                    . " (dag_no ='$dag_no' )";
            $this->db->query($q); //..............................
        }

        return $data;
    }

    public function getCol31($patta_no, $district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $data[] = array();
        $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from chitha_rmk_gen where  "
                . "dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                . " (dag_no ='$dag_no') and (lower(jama_updated)!='y' or jama_updated is null)  order by rmk_type_hist_no";

        $innerdata26 = $this->db->query($innerquery26)->result();
        
        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;

            //remark type 01 is for all office case হুকুম
            if ($rmk_type_code == "01") {
                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                        . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,user_code,operation  "
                        . " from chitha_rmk_ordbasic where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                        . " and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";

                $innerdata27 = $this->db->query($innerquery27)->result();
                foreach ($innerdata27 as $chitharmk_ord_basic) {
                    $dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
                    $order_date = $chitharmk_ord_basic->ord_date;
                    $ord_no = $chitharmk_ord_basic->ord_no;
                    $case_no = $chitharmk_ord_basic->case_no;
                    $ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
                    $lm_code = $chitharmk_ord_basic->lm_code;
                    $co_code = $chitharmk_ord_basic->co_code;
                    $user_code = $chitharmk_ord_basic->user_code;
                    $operation = $chitharmk_ord_basic->operation;
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;

                    $get_designation = $this->db->query("select user_desig_as as designation from master_user_designation "
                                    . "where user_desig_code = '$ord_passby_desig'")->row()->designation;

                    //Order type 01 is for Conversion case(ম্যাদীকৰণ)
                    if ($ord_type_code == '01') {
                        $innerquery28 = " select patta_no,patta_type_code FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                                . "rmk_type_hist_no='$rmk_type_hist_no' ";

                        $innerdata28 = $this->db->query($innerquery28)->result();

                        $patta_no = "";
                        $patta_type_code = "";
                        $patta_type = "";
                        $premium = "";
                        $premi_chal_recpt_no = "";
                        $premi_chal_recpt = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $land_area_b = "";
                        $land_area_k = "";
                        $land_area_lc = "";
                        $username = "";
                        $lm_name = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $chalan_name = "";

                        foreach ($innerdata28 as $rmkconvorder) {
                            $patta_no = trim($rmkconvorder->patta_no);
                            $patta_type_code = $rmkconvorder->patta_type_code;

                            $innerquery29 = "select patta_type from patta_code where type_code=' $patta_type_code' ";
                            $innerdata29 = $this->db->query($innerquery29)->result();

                            foreach ($innerdata29 as $pattatype) {
                                $patta_type = $pattatype->patta_type;
                            }
                        }

                        if ($ord_type_code === '01') {
                            $innerquery30 = "select  distinct premium as premium,premi_chal_recpt_no "
                                    . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                    . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                    . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null"; // group by premi_chal_recpt_no";
                            //echo $innerquery30;
                        } else {
                            $innerquery30 = "select  distinct sum(premium) as premium,premi_chal_recpt_no "
                                    . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                    . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                    . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null group by premi_chal_recpt_no";
                        }
                        $innerdata30 = $this->db->query($innerquery30)->result();

                        foreach ($innerdata30 as $premiuminfo) {
                            $premium = $premiuminfo->premium;
                            $premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;
                            //$premi_chal_recpt = $premiuminfo->premium;

                            $innerquery31 = "select chalan_name from premium_chalan_receipt where code='$premi_chal_recpt'";
                            $innerdata31 = $this->db->query($innerquery31)->result();

                            foreach ($innerdata31 as $premiumchalanrecpt) {
                                $chalan_name = $premiumchalanrecpt->chalan_name;
                            }
                        }

                        $innerquery32 = "select dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
                                . " dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                                . " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                                . " rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata32 = $this->db->query($innerquery32)->result();

                        $applicants = array();

                        foreach ($innerdata32 as $rmk_conv) {
                            $dag_no = $rmk_conv->dag_no;
                            $new_patta_no = $rmk_conv->new_patta_no;
                            $new_dag_no = $rmk_conv->new_dag_no;
                            $ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;

                            if ($ord_type_code === '01') {
                                $innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
                                        . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                        . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            } else {
                                $innerquery33 = "select sum(land_area_b) as land_area_b,sum(land_area_k) as land_area_k,sum(land_area_lc) as "
                                        . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                        . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            }
                            $innerdata33 = $this->db->query($innerquery33)->result();

                            foreach ($innerdata33 as $bklconvorder) {
                                $land_area_b = $bklconvorder->land_area_b;
                                $land_area_k = $bklconvorder->land_area_k;
                                $land_area_lc = $bklconvorder->land_area_lc;
                            }

                            $applicants[] = array(
                                'app_name' => $ord_onbehalf_of,
                                'dag_no' => $dag_no,
                                'new_dag_no' => $new_dag_no,
                                'new_patta_no' => $new_patta_no,
                            );
                        }

                        $innerquery34 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata34 = $this->db->query($innerquery34)->result();

                        foreach ($innerdata34 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        if (($ord_passby_desig == 'DC') || ($ord_passby_desig == 'ADC')) {
                            $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                    . " and subdiv_code='00' and cir_code='00' and user_code ='$co_code'";
                        } else {
                            $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        }
                        $innerdata35 = $this->db->query($innerquery35)->result();

                        foreach ($innerdata35 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'patta_no' => "$patta_no",
                            'patta_type_code' => "$patta_type_code",
                            'patta_type' => "$patta_type",
                            'premium' => "$premium",
                            'premi_chal_recpt_no' => "$premi_chal_recpt_no",
                            'premi_chal_recpt' => "$premi_chal_recpt",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'ord_onbehalf_of' => $applicants,
                            'land_area_b' => "$land_area_b",
                            'land_area_k' => "$land_area_k",
                            'land_area_lc' => "$land_area_lc",
                            'username' => "$username",
                            'lm_name' => "$lm_name",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'chalan_name' => "$chalan_name",
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => '01',
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'ord_passby_desig' => $get_designation
                        );

                        $remove = "select dag_no as old_dag_no,patta_type_code as old_patta_type,patta_no as old_patta_no FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' 
                        and (dag_no ='$dag_no' or new_dag_no='$dag_no') and rmk_type_hist_no='$rmk_type_hist_no'";

                        $remove = $this->db->query($remove)->row();

                        // now delete the old from the jama_dag and jama_patta // removing the pattader needs to be checked again
                        $delete2 = "delete from jama_dag where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no') and dag_no='$remove->old_dag_no'";

                        $this->db->query($delete2); //***************************

                        $check = "select count(*) as c from jama_dag where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no')";
                        $check = $this->db->query($check)->row()->c;


                        if ($check == '0') {
                            $delete1 = "delete from jama_patta where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                    . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no')";

                            //$this->db->query($delete1); //***************************
                        }
                    }

                    //Order type 02 is for Allotment case(আবন্টন)
                    if ($ord_type_code == "02") {
                        $innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from chitha_rmk_allottee  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";


                        $innerdata36 = $this->db->query($innerquery36)->result();

                        $ord_date = "";
                        $dag_no = "";
                        $ord_ref_let_no = "";
                        $allottee_name = "";
                        $allottee_land_code = "";
                        $allottee_land_b = "";
                        $allottee_land_k = "";
                        $allottee_land_lc = "";
                        $type = "";
                        $lm_name = "";
                        $status = "";

                        foreach ($innerdata36 as $allotee) {
                            $ord_date = $allotee->ord_date;
                            $dag_no = $allotee->dag_no;
                            $ord_ref_let_no = $allotee->ord_ref_let_no;
                            $allottee_name = $allotee->allottee_name;
                            $allottee_land_code = $allotee->allottee_land_code;
                            $allottee_land_b = $allotee->allottee_land_b;
                            $allottee_land_k = $allotee->allottee_land_k;
                            $allottee_land_lc = $allotee->allottee_land_lc;

                            $innerquery37 = "select  type from  ord_on_gl_type_code where type_code='$allottee_land_code'";
                            $innerdata37 = $this->db->query($innerquery37)->result();

                            foreach ($innerdata37 as $ord_on_typ) {
                                $type = $ord_on_typ->type;
                            }
                        }


                        $innerquery38 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata38 = $this->db->query($innerquery38)->result();

                        foreach ($innerdata38 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery39 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata39 = $this->db->query($innerquery39)->result();

                        foreach ($innerdata39 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'ord_date' => $ord_date,
                            'dag_no' => $dag_no,
                            'ord_ref_let_no' => $ord_ref_let_no,
                            'allottee_name' => $allottee_name,
                            'allottee_land_code' => $allottee_land_code,
                            'allottee_land_b' => $allottee_land_b,
                            'allottee_land_k' => $allottee_land_k,
                            'allottee_land_lc' => $allottee_land_lc,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name
                        );
                    }

                    //Order type 03 is for Office Mutation case(নামজাৰী)
                    if ($ord_type_code == "03") {
                        $innerquery40 = "SELECT inplace_of_name FROM chitha_rmk_inplace_of  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata40 = $this->db->query($innerquery40)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $inplace_of_name = "";
                        $alongwithname = "";
                        $lm_name = "";
                        $status = "";
                        $username = "";

                        foreach ($innerdata40 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                        }


                        $innerquery41 = "select alongwith_name  FROM chitha_rmk_alongwith where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata41 = $this->db->query($innerquery41)->result();

                        $alongwitharray = array();

                        foreach ($innerdata41 as $alongwith) {
                            $alongwithname = $alongwith->alongwith_name;
                            $alongwitharray[] = array(
                                'alongwithname' => $alongwithname
                            );
                        }

                        $innerquery41 = "select inplace_of_name  FROM chitha_rmk_inplace_of where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata46 = $this->db->query($innerquery41)->result();

                        $inplaceofarray = array();

                        foreach ($innerdata46 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                            $inplaceofarray[] = array(
                                'inplace_of_name' => $inplace_of_name
                            );
                        }
                        //var_dump($inplaceofarray);
                        $innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
                                . " new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
                                . " and rmk_type_hist_no='$rmk_type_hist_no'"
                                . " and ord_no= '$ord_no' ";

                        $innerdata42 = $this->db->query($innerquery42)->result();

                        $infav = array();

                        foreach ($innerdata42 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;

                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }
                        //var_dump($infav);
                        $innerquery43 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata43 = $this->db->query($innerquery43)->result();

                        foreach ($innerdata43 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }


                        $innerquery44 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata44 = $this->db->query($innerquery44)->result();

                        foreach ($innerdata44 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc from chitha_rmk_ordbasic "
                                . " where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no' and (dag_no ='$dagnoRemarkgen')";

                        $m_area = $this->db->query($innerquery45)->row();

                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;

                        $co_name = "select username from users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
                        $co_name = $this->db->query($co_name)->result();
                        foreach ($co_name as $co) {
                                $co_username = $co->username;
                        }
                        
                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'alongwith_name' => $alongwitharray,
                            'inplace_of_name' => $inplaceofarray,
                            'bigha' => $m_area_b,
                            'katha' => $m_area_k,
                            'lessa' => $m_area_lc,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'order_date' => $order_date,
                            'co_name' => $co_username,
                            'operation' => $operation
                        );
                        //var_dump($data);
                        //exit();
                    }

                    //Order type 04 is for Office Partition case(বাটোৱাৰা)
                    if ($ord_type_code == "04") {
                        $innerquery45 = "select by_right_of,dag_no,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata45 = $this->db->query($innerquery45)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $old_dag = "";
                        $new_dag_no = "";
                        $new_patta_no = "";

                        $infav = array();

                        foreach ($innerdata45 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $old_dag = $infav_of->dag_no;
                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;

                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }

                        $innerquery46 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata46 = $this->db->query($innerquery46)->result();

                        $lm_name = "";

                        foreach ($innerdata46 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery47 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata47 = $this->db->query($innerquery47)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata47 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'old_dag' => $old_dag,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'bigha' => $m_dag_area_b,
                            'katha' => $m_dag_area_k,
                            'lessa' => $m_dag_area_lc
                        );
                    }

                    //Order type 05 is for Other Party case(অন্যান্য)
                    if ($ord_type_code == "05") {
                        $innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,case_type_code from chitha_rmk_other_opp_party where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";

                        $name_for = "";
                        $name_for_land_b = "";
                        $name_for_land_k = "";
                        $name_for_land_lc = "";
                        $case_type_code = "";
                        $case_type_name = "";
                        $lm_name = "";
                        $username = "";
                        $status = "";

                        $innerdata48 = $this->db->query($innerquery48)->result();

                        foreach ($innerdata48 as $opp_party) {
                            $name_for = $opp_party->name_for;
                            $name_for_land_b = $opp_party->name_for_land_b;
                            $name_for_land_k = $opp_party->name_for_land_k;
                            $name_for_land_lc = $opp_party->name_for_land_lc;
                            $case_type_code = $opp_party->case_type_code;

                            $innerquery49 = "select case_type_name from case_type_code where case_type_code='$case_type_code'";

                            $innerdata49 = $this->db->query($innerquery49)->result();

                            foreach ($innerdata49 as $casename) {
                                $case_type_name = $casename->case_type_name;
                            }
                        }

                        $innerquery50 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata50 = $this->db->query($innerquery50)->result();

                        foreach ($innerdata50 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery51 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata51 = $this->db->query($innerquery51)->result();

                        foreach ($innerdata51 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'name_for' => $name_for,
                            'name_for_land_b' => $name_for_land_b,
                            'name_for_land_k' => $name_for_land_k,
                            'name_for_land_lc' => $name_for_land_lc,
                            'case_type_code' => $case_type_code,
                            'case_type_name' => $case_type_name,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'order_type_code' => $ord_type_code,
                        );
                    }

                    //Order type 06 is for Name Correction case(নাম সংশোধন)
                    if ($ord_type_code == "06") {
                        $innerdata52 = "";
                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $innerquery52 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no,ord_date,ord_no,user_code,dag_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata52 = $this->db->query($innerquery52)->result();



                        foreach ($innerdata52 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $order_type_code = $infav_of->by_right_of;
                            $dag_no = $infav_of->dag_no;
                            $new_patta_no = $infav_of->new_patta_no;
                            $ord_date = $infav_of->ord_date;
                            $ord_no = $infav_of->ord_no;
                            $co_code = $infav_of->user_code;
                        } //infav query bracket

                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata54 = $this->db->query($innerquery54)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infavor_of_corrected_name' => $infavor_of_corrected_name,
                            'infavor_of_name' => $infavor_of_name,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'dag_no' => $dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'order_date' => $ord_date,
                            'ord_no' => $ord_no,
                        );
                        //var_dump($data);
                        //exit;
                        $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                                . "dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                                . " (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' ";

                        //$this->db->query($q);
                    }

                    //Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
                    if ($ord_type_code == "07") {
                        $innerquery55 = "select * from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata55 = $this->db->query($innerquery55)->result();

                        $infavor_of_name = "";
                        $name_delete = '';
                        $dag_no = "";

                        foreach ($innerdata55 as $infav_of) {
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $co_code = $infav_of->user_code;
                            $ord_date = $infav_of->ord_date;
                            $dag_no = $infav_of->dag_no;
                        } //infav query bracket

                        $ordparty = "Select string_agg(name_for,',') as name_delete from chitha_rmk_other_opp_party where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
                                " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  and ord_no= '$ord_no' ";

                        $innerdata59 = $this->db->query($ordparty);
                        if($innerdata59->num_rows()>0){
                            $name_delete = $innerdata59->row()->name_delete;
                        }else{
                            $name_delete =null;
                        }
                        // foreach ($innerdata59 as $ordparty) {
                        //     $name_delete = $ordparty->name_for;
                        // } //infav query bracket

                        $innerquery53 = "select lm_name FROM LM_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code'  ";

                        $lm_name = $this->db->query($innerquery53)->row()->lm_name;

                        

                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata54 = $this->db->query($innerquery54)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'order_no' => $ord_no,
                            'name_delete' => $name_delete,
                            'infavor_of_name' => $infavor_of_name,
                            'username' => $username,
                            'dag_no' => $dag_no,
                            'status' => $status,
                            'lmname' => $lm_name ?? '',
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'username' => $username,
                            'orderdate' => $ord_date
                        );
                    }
                }
            }
            //remark type 02 is for মণ্ডলৰ টোকা
            if ($rmk_type_code == '02') {
                $innerquery56 = "select  lm_note,lm_note_date,lm_code FROM chitha_rmk_lmnote where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";

                $innerdata56 = $this->db->query($innerquery56)->result();

                foreach ($innerdata as $lmnote) {
                    $lm_note = $lmnote->lm_note;
                    $lm_note_date = $lmnote->lm_note_date;
                    $lm_code = $lmnote->lm_code;
                }
            }

            //remark type 03 is for কাননগুহৰ টোকা
            if ($rmk_type_code == '03') {
                $innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";

                $innerdata57 = $this->db->query($innerquery57)->result();

                foreach ($innerdata57 as $sknoteinf) {
                    $sk_note = $sknoteinf->sk_note;
                    $sk_note_date = $sknoteinf->sk_note_date;
                }
            }

            //remark type 04 is for বেদখলকাৰীৰ বিৱৰণ
            if ($rmk_type_code == '04') {
                $innerquery58 = "SELECT encro_evicted_yn,encro_name FROM chitha_rmk_encro where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";

                $innerdata58 = $this->db->query($innerquery58)->result();

                foreach ($innerdata58 as $encro) {
                    $encro_evicted_yn = $encro->encro_evicted_yn;
                    $encro_name = $encro->encro_name;
                }
            }

            //remark type 08 is for land Reclassification
            if ($rmk_type_code == '08') {

                // $check = $this->db->query("SELECT count(*) as c FROM t_reclassification where dist_code='$district_code' "
                //                 . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //                 . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and co_chitha_updated_yn = 'Y' and rkg_chitha_updated_yn = 'Y' ")->row()->c;

                // if ($check <= '0') {
                //     $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                //             . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //             . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                // } else {
                //     $innerquery59 = "SELECT * FROM t_reclassification where dist_code='$district_code' "
                //             . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //             . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                // }
                $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                            . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";

                $get_user_designation = "Select user_code as order_designation from chitha_rmk_gen where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
                        
                $str = $this->db->query($get_user_designation)->row()->order_designation;
                
                $order_designation = preg_replace('#\d.*$#', '', $str);
                
                $get_designation_name = $this->db->query("Select user_desig_as as user_desig_as from master_user_designation where user_desig_code = '$order_designation'")->row()->user_desig_as;

                
                $innerdata59 = $this->db->query($innerquery59)->result();
                
                foreach ($innerdata59 as $encro) {
                    $reclass_case_no = $encro->case_no;
                    $present_land_class = $encro->present_land_class;
                    $proposed_land_class = $encro->proposed_land_class;
                    $dag = $encro->dag_no;
                    $patta = trim($encro->patta_no);
                    $orderpass = $encro->co_chitha_updated_date;
                    $present_land_class = $encro->present_land_class;
                }

                $data[] = array(
                    'reclass_case_no' => $reclass_case_no,
                    'present_land_class' => $present_land_class,
                    'proposed_land_class' => $proposed_land_class,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '00',
                    'dag_no' => $dag_no,
                    'patta_no' => $patta,
                    'date' => $orderpass,
                    'presentclass' => $present_land_class,
                    'order_passed_designation' => $get_designation_name,
                );
            }

            //remark type 10 is Allotments
            if ($rmk_type_code == '10') {
                $innerquery59 = "SELECT * FROM chitha_rmk_allottee where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";

                $innerdata59 = $this->db->query($innerquery59)->result();

                $q = "Select lm_code,user_code as co_code from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();

                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);

                foreach ($innerdata59 as $encro) {
                    $case_no = $encro->ord_no;
                    $ord_date = $encro->ord_date;
                    $patta_no = $encro->patta_no;
                    $old_dag = $encro->old_dag;
                    $dag_no = $encro->dag_no;
                    $rmk_type_hist_no = $encro->rmk_type_hist_no;
                    $b = $encro->allottee_land_b;
                    $k = $encro->allottee_land_k;
                    $lc = $encro->allottee_land_lc;
                    $doulyear = year_no;
                }

                $data[] = array(
                    'case_no' => $case_no,
                    'ord_date' => $ord_date,
                    'patta_no' => $patta_no,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '10',
                    'old_dag' => $old_dag,
                    'dag_no' => $dag_no,
                    'historyno' => $rmk_type_hist_no,
                    'bigha' => $b,
                    'katha' => $k,
                    'lesaa' => $lc,
                    'doulyear' => $doulyear,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                );
            }
            
            // Modified on 19/06/2020 for settlement process
            
            if (($rmk_type_code == '11')or($rmk_type_code=='12')) {
                $innerquery59 = "SELECT * FROM chitha_rmk_allottee where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";

                $innerdata59 = $this->db->query($innerquery59)->result();

                $q = "Select lm_code,co_code,ord_no from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();

                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);

                $premiumquery ="select premium from allotment_pet_dag where case_no='$lmco->ord_no'";
                
                //echo "select premium from allotment_pet_dag where case_no='$lmco->ord_no'";
                
                $premiumdata= $this->db->query($premiumquery)->row();
                
                 $premiumdata->premium;
                
                
                
                foreach ($innerdata59 as $encro) {
                    $case_no = $encro->ord_no;
                    $ord_date = $encro->ord_date;
                    $patta_no = $encro->patta_no;
                    $old_dag = $encro->old_dag;
                    $dag_no = $encro->dag_no;
                    $rmk_type_hist_no = $encro->rmk_type_hist_no;
                    $b = $encro->allottee_land_b;
                    $k = $encro->allottee_land_k;
                    $lc = $encro->allottee_land_lc;
                    $doulyear = $encro->doul_year;
                }
                
                
                

                $data[] = array(
                    'case_no' => $case_no,
                    'ord_date' => $ord_date,
                    'patta_no' => $patta_no,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '10',
                    'old_dag' => $old_dag,
                    'dag_no' => $dag_no,
                    'historyno' => $rmk_type_hist_no,
                    'bigha' => $b,
                    'katha' => $k,
                    'lesaa' => $lc,
                    'doulyear' => $doulyear,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                    'premium' =>$premiumdata->premium,
                );
            }
            
            
            // End Modified on 19/06/2020 for settlement process

            $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                    . "dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                    . " (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' ";

            $this->db->query($q); //..............................
        }
        //var_dump($data);
        return $data;
    }

    public function generateCol31Remark($dag_no, $q) {
        $count = 1;
        $remark31 = "";
        $order_count = 1;

        if (sizeof($q) > 1) {
            $r = $q[1];

            //remark type 01 is for all office case হুকুম   and Order type 03 is for Office Mutation case(নামজাৰী)
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '03')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "<br></u>";

                $remark31 .= "চক্ৰ বিষয়া'ৰ ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " ";
                echo $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে   $dag_no  দাগৰ ";
                if ($r['by_right_of'] == '11' || $r['by_right_of'] == '01' || $r['by_right_of'] == '02') {
                    $remark31.=" অংশৰ জমিত ";
                }else{
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " লেছা মাটি ";
                }
                $remark31 .= $this->utilityclass->getTransferType($r['by_right_of']) ."  " ;
                $count = 0;


                $howmany = sizeof($r['alongwith_name']) - 1;
                foreach ($r['alongwith_name'] as $al) {
                    $remark31 .= $al['alongwithname'];
                    if ($count < (sizeof($r['alongwith_name']) - 2)) {
                        $remark31 .= " , ";
                    } elseif ($count == (sizeof($r['alongwith_name']) - 2)) {
                        $count;
                        $remark31 .= " আৰু ";
                    } else {
                        $remark31 .= " ";
                    }
                    $count++;
                }
                if (sizeof($r['alongwith_name']) != '0') {
                    $remark31 .= " ৰ লগত ";
                }
                $count = 0;

                $howmany = sizeof($r['inplace_of_name']) - 1;
                if ($howmany >= 0) {
                    foreach ($r['inplace_of_name'] as $al) {
                        $remark31 .= $al['inplace_of_name'];
                        if ($count < sizeof($r['inplace_of_name']) - 1) {
                            $remark31 .= " আৰু ";
                            $count++;
                        }
                    }
                    $remark31 .= " ৰ  স্হলত ";
                }

                $count = 0;
                $howmany = sizeof($r['infav']) - 1;

                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .= " আৰু ";
                        $count++;
                    }
                }
                if ($r['ord_type_code'] == '03') {
                    $remark31 .= " ৰ নামত নামজাৰী কৰা হ’ল | <br>";
                }
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক:</u>(" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u>(" . $r['username'] . ")</p>";
                
                if ($r['by_right_of'] != '11' || $r['by_right_of'] != '01' || $r['by_right_of'] != '02') {
                    $remark31 .= "<p>Reg No (" . $r['reg_deal_no'] . ")</p>";
                    $remark31 .="Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")";
                    //$remark31 .= "<p>Reg Date (" . date('d-m-Y', strtotime($r['reg_date'])) . ")</p>";
                }
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                }
                return $remark31;
            }

            //Order type 01 is for Conversion case(ম্যাদীকৰণ)
            if ($r['ord_type_code'] == '01') {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= $r['ord_passby_desig'] . "'ৰ <br>";
                $remark31 .= $r['ord_no'] . "  নং  ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " গোচৰৰ  ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " তাৰিখৰ হুকুমমৰ্মে ";
                $remark31 .= $r['patta_no'] . " নং একচনা পট্টাৰ " . $r['dag_no'] . " নং দাগৰ  " . $r['premium'] . " টকা প্ৰিমিয়ামত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        echo " আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ পৰা আদায় হোৱাত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        $remark31 .=" আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ নামত ";
                if (($r['land_area_b'] != '0') || ($r['land_area_k'] != '0') || ( $r['land_area_lc']) != '0') {
                    $remark31 .= $r['land_area_b'] . " বিঘা  " . $r['land_area_k'] . " কঠা  " . $r['land_area_lc'] . " লেছা " . "মাটি  পৃঠক ";
                } else {
                    
                }

                $remark31 .= $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " নং দাগে ম্যাদীকৰণ কৰা হ'ল | <br>";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . " </p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . "</p>";
                return $remark31;
            }

            //remark type 01 is for all office case হুকুম   and Order type 04 is for Office Partition case(বাটোৱাৰা)
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '04')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";
                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $dag_no = $r['old_dag'];

                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে  $dag_no দাগৰ ";
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " লেছা মাটি   ";

                $count = 0;

                $howmany = sizeof($r['infav']) - 1;
                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .=" আৰু ";
                        $count++;
                    }
                }

                $remark31 .= " নামত " . $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " দাগ কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক:</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বাটোৱাৰা ও নথি সংশোধন কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                }
                return $remark31;
            }

            //remark type 08 is for land Reclassification
            if (($r['remark_type_code'] == '08') && ($r['ord_type_code'] == '00')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং :</u><br>";
                $remark31 .= $r['reclass_case_no'];
                $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  " . $r['order_passed_designation']. " মহোদয়ে  " . $r['date'];
                $remark31 .= "  তাৰিখে দিয়া অনুমোদন মৰ্মে  " . $r['patta_no'];
                $remark31 .= "  নং পট্টাৰ  " . $r['dag_no'] . "  নং দাগৰ শ্রেণী  " . $this->utilityclass->getLandClassCode($r['presentclass']) . "'ৰ  পৰা  " . $this->utilityclass->getLandClassCode($r['proposed_land_class']);
                $remark31 .= "  লৈ পৰিবৰ্তন কৰা হ'ল । ";

                return $remark31;
            }

            //Order type 06 is for Name Correction case(নাম সংশোধন)
            if ($r['ord_type_code'] == '06') {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['ord_no'] . " -ৰ হুকুম মৰ্মে " . $r['dag_no'] . " দাগৰ ";

                $count = 0;
                $remark31 .= $r['infavor_of_name'] . " ৰ  নাম   " . $r['infavor_of_corrected_name'] . "  কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //echo $remark31;
                return $remark31;
            }

            //remark type 01 is for all office case হুকুম   and Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '07')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['orderdate']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['order_no'] . " -ৰ হুকুম মৰ্মে  " . $r['dag_no'] . "  দাগৰ পটাদাৰ ";
                $count = 0;
                $remark31 .= $r['infavor_of_name'] . "  ৰ আবেদন মৰ্মে পটাদাৰ   " . $r['name_delete'] . " ৰ নাম কৰ্তন কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";

                return $remark31;
            }

            //remark type 10 is Allotments
            if (($r['remark_type_code'] == '10') and ( $r['ord_type_code'] == '10')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " . $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । " ;
                $remark31 .= " অসম চৰকাৰৰ 03-03-2024  তাৰিখৰ  ECF 200418  নং অধিসূচনা অনুসৰি বিধি ২৬- A মৰ্মে উক্ত মাটি হস্তান্তৰ কৰিলে উক্ত বন্দবস্তিকাৰী ভুমিহীন হলেও ভৱিষ্যতে পুনৰ চৰকাৰী মাটি বন্দোবস্তিৰ যোগ্য নহব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                return $remark31;
            }
            
            // Modified on 19/06/2020 STPP
            
             if (($r['remark_type_code'] == '11') and ( $r['ord_type_code'] == '10')) {
                  
                  $case_no=$r['case_no'];

                  
                  $allotment_certificate123 = $this->db->query("Select * from allotment_doc_details where case_no='$case_no'")->row();
                   //var_dump($allotment_certificate123);
                  $dist_name = $this->utilityclass->getDistrictName($allotment_certificate123->dist_code);
                  $dag_details = $this->db->query("Select * from allotment_pet_dag where case_no='$case_no'")->row();
                  
                
                  $q = "Select * from allotment_petitioner where case_no='$case_no' ";
        
               $applicant = $this->db->query($q)->row();
                
                
                
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .=  "অসম চৰকাৰৰ  " .date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue))." ইং তাৰিখৰ ".$allotment_certificate123->govtcertificate_no. " নং চিঠি আৰু " . $dist_name. " জিলাৰ উপায়ুক্ত মহোদয়ৰ ".date('d/m/Y',strtotime($allotment_certificate123->date_of_issue))." ইং তাৰিখৰ ".$allotment_certificate123->certficate_no." নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ ".date("d/m/Y"). " ইং তাৰিখৰ ".$case_no."  নং গোচৰৰ নিদেৰ্শ মৰ্মে " .$dag_details->dag_no. " নং দাগৰ জমিৰ " .$dag_details->alot_area_b." বিঘা ".$dag_details->alot_area_k." কঠা ".$dag_details->alot_area_lc." লেছা  মাটি ".$dag_details->premium." টকা প্ৰিমিয়াম আদায় ক্রমে ".$applicant->alotee_name." পিতা ".$applicant->alotee_gurdian." নামত  নতুন ".$r[dag_no]." নং দাগ আৰু নতুন ".$r[patta_no]." নং খেৰাজ ম্যাদী পট্টা ভুক্ত কৰা হল।";
              
 
              return $remark31;
                
                
                
                
                //$case_no=$r['case_no'];
                
                
                //$premium123 ="select premium from allotment_pet_dag where case_no='$case_no'"
                //$premiumdata= $this->db->query($premium123)->row->premium;
                
                  
                  /*  $innerquery5911 = "select ord_no FROM chitha_rmk_allottee where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' ";
                
                
                  $innerdata5911 = $this->db->query($innerquery5911)->row(); */
            
              /*    $qcomment = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " circle_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and case_no='$innerdata5911->ord_no' ";
                        
                



                                    
               $innerdatacomment = $this->db->query($qcomment)->row(); 
                  
                 $comment= $innerdatacomment->lm_comment; */
                  
                  
                  
              /*  $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ ".$r[premium]."  টকা প্ৰিমিয়াম আদায় ক্রমে  ". $r[dag_no] . "   নং দাগ আৰু  " . $r[patta_no] . "  নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । " . $r[doulyear] . " চনত দৌল ভূক্ত হব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক:</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //$remark31 .= $comment;
                return $remark31; */
            }
            
            
            
            
            
              if (($r['remark_type_code'] == '12') and ( $r['ord_type_code'] == '10')) {
                  
                
                 /*   $innerquery5911 = "select ord_no FROM chitha_rmk_allottee where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' ";
                
                
                  $innerdata5911 = $this->db->query($innerquery5911)->row(); */
            
                /*  $qcomment = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " circle_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and case_no='$innerdata5911->ord_no' ";
                        
                



                                    
               $innerdatacomment = $this->db->query($qcomment)->row(); 
                  
                 $comment= $innerdatacomment->lm_comment; */
                  
                  
                  
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " .$r[premium]."  টকা প্ৰিমিয়াম আদায় ক্রমে   ". $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । " . year_no . " চনত দৌল ভূক্ত হব । ";
                $remark31 .= " ২০১৯ চনৰ নতুন ভূমিনিতিৰ ১৪.১৩ নং দফা অনুসৰি নতুনকৈ পট্টন হোৱা এই জমিন পট্টনৰ তাৰিখৰ     পৰা ১৫ বছৰলৈ হস্তান্তৰ কৰিব নোৱাৰিব ।";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //$remark31 .= $comment;
                return $remark31;
            }
            
            
            // End  
            
            
            echo $remark31;
        }
    }
    ////////////////////////////////////////////////////
    /////view all notes to update in jama 10-05-22
    public function viewAllNotes()
    {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data = [
                'success' => false,
                'orderList' => $errorMessageStr,
            ];
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $json = null;
        $dist_code = $this->input->post('dist');
        $subdiv_code = $this->input->post('sub');
        $circle_code = $this->input->post('cir');
        $mouza_code = $this->input->post('mouza');
        $lot_no = $this->input->post('lot');
        $vill_code = $this->input->post('vill');
        $patta_no = trim($this->input->post('pno'));
        $patta_type = trim($this->input->post('ptype'));
        $dags = $this->input->post('dag');
        $date=CHANGE_DATE;
        if(!empty($dags)){
            //get order nos and jama status by dag no
            $detail = $this->db->query("SELECT distinct(ord_no) AS order_no, jama_yn AS jama_status 
                FROM chitha_rmk_ordbasic 
                WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
                AND dag_no IN ($dags) and ord_date>=? 
                UNION
                SELECT distinct(case_no) AS order_no, jama_updated AS jama_status FROM 
                chitha_col8_order WHERE dist_code=? AND subdiv_code=? AND 
                cir_code=? AND mouza_pargona_code=? AND lot_no=? AND 
                vill_townprt_code=? AND dag_no IN ($dags) AND co_ord_date>=? ", 
                    array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                        $vill_code,$date, $dist_code, $subdiv_code, $circle_code, $mouza_code, 
                        $lot_no, $vill_code,$date));
            //echo $this->db->last_query(); return;
            $json = [
                'success' => true,
                'orderList' => $detail->result(),
                'dagList' => $dags,
            ];
        }
        else {
            $json = [
                'success' => false,
                'orderList' => 'No Detail Found',
            ];
        }
        echo json_encode($json);
        return;
    }

    /////Update Jamabandi 
    public function updateJamabandi()
    {        
         //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message',  $errorMessageStr);
            redirect(base_url() . 'index.php/home/');
         }
        //xss & security validation ends 
        $update = array();
        $time_start = microtime(true);
        $patta_no = $this->input->post('pno');
        $patta_type = $this->input->post('ptype');
        $dist_code = $this->input->post('dist');
        $subdiv_code = $this->input->post('sub');
        $circle_code = $this->input->post('cir');
        $mouza_code = $this->input->post('mouza');
        $lot_no = $this->input->post('lot');
        $vill_code = $this->input->post('vill');
        $case_no = $this->input->post('selected_box');

        if($case_no == '' || $case_no == null){  //if no case selected
            
            //update chitha_basic against a dag for selected case no
            $chB = $this->db->query("UPDATE chitha_basic SET jama_yn=null 
            WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND 
            patta_type_code=? ", 
            array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                $vill_code, $patta_no, $patta_type));

            //update chitha_dag_pattadar against a dag no for selected case no
            // $this->db->query("UPDATE chitha_dag_pattadar SET jama_yn=null 
            // WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            // AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND 
            // patta_type_code=?", 
            // array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
            //     $vill_code, $patta_no, $patta_type));

            $table = 'chitha_dag_pattadar';

            $params = [
                'jama_yn' => null,  // Setting jama_yn to null as in your original query
            ];

            $where = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_code,
                'patta_no'           => trim($patta_no),  // Trim applied in PHP
                'patta_type_code'    => $patta_type,
            ];

            // Execute the update using your model function
            $result = $this->Chitha_basic_model->update_table($table, $params, $where);


            //update chitha_pattadar against a patta no
            // $this->db->query("UPDATE chitha_pattadar SET jama_yn='' 
            // WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            // AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=?", 
            // array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
            //     $vill_code, $patta_no, $patta_type));

            $table = 'chitha_pattadar';
            $params = [
                'jama_yn' => '',
            ];
            $where = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_code,
                'patta_no'           => $patta_no,
                'patta_type_code'    => $patta_type,
            ];
            // Call update method
            $result = $this->Chitha_basic_model->update_table($table, $params, $where);

        }

        else //if case selected
        {
            $case_arr = explode(",", $case_no);
            $dag_arr=array();
            foreach ($case_arr as $case_str) {
                $app_no = ltrim(rtrim($case_str,"'"),"'");            
                $checkInJamaRemarks = $this->db->query("SELECT patta_no FROM jama_remark
                    WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=?
                    AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=?
                    AND remark LIKE '%".$app_no."%' ", array($dist_code, $subdiv_code,
                        $circle_code, $mouza_code, $lot_no, 
                        $vill_code, $patta_no, $patta_type));
                // log_message('error',"1st".$this->db->last_query());
                if($checkInJamaRemarks->num_rows() == 0){
                    //get dag nos for the selected cases
                    $date=CHANGE_DATE;
                    $dag_nos = $this->db->query("SELECT dag_no, rmk_type_hist_no as history_no 
                        FROM chitha_rmk_ordbasic 
                        WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                        AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?
                        AND ord_no = ? AND ord_date >=? 
                        UNION
                        SELECT dag_no, col8order_cron_no as history_no 
                        FROM chitha_col8_order 
                        WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                        AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?
                        AND case_no=? AND co_ord_date >=? ", 
                        array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                            $vill_code, $app_no,$date,$dist_code, $subdiv_code, $circle_code, $mouza_code, 
                            $lot_no, $vill_code,$app_no,$date));
                    // log_message('error',"2nd".$this->db->last_query());
                    //fetch all dag details
                    foreach($dag_nos->result() as $dag){                   
                        //var_dump($dag);
                        //update chitha_rmk_gen against a dag no for selected case no
                        $this->db->query("UPDATE chitha_rmk_gen SET jama_updated=null 
                        WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                        AND lot_no=? AND vill_townprt_code=? AND dag_no=? AND rmk_type_hist_no=? AND date_entry>=? ", 
                        array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                            $vill_code, $dag->dag_no, $dag->history_no, $date));
                        // log_message('error',"3rd".$this->db->last_query());
                        //update chitha_rmk_ordbasic for selected case no
                        $this->db->query("UPDATE chitha_rmk_ordbasic SET jama_yn=null 
                        WHERE dist_code=? AND subdiv_code=? AND cir_code=?
                        AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?
                        AND ord_no = ? AND dag_no=? AND rmk_type_hist_no=? AND ord_date>= ? ", 
                        array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                            $vill_code, $app_no, $dag->dag_no, $dag->history_no, $date));

                        // //update chitha_col8_order against a dag for selected case no
                        $this->db->query("UPDATE chitha_col8_order SET jama_updated=null 
                        WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                        AND lot_no=? AND vill_townprt_code=? AND dag_no=? AND case_no = ? AND col8order_cron_no=? AND co_ord_date>=? ",
                        array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                            $vill_code, $dag->dag_no, $app_no,$dag->history_no, $date));

                        //update chitha_basic against a dag for selected case no
                        $chB = $this->db->query("UPDATE chitha_basic SET jama_yn=null 
                        WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                        AND lot_no=? AND vill_townprt_code=? AND dag_no=? AND patta_no=? AND 
                        patta_type_code=? ", 
                        array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                            $vill_code, $dag->dag_no, $patta_no, $patta_type));

                        //update chitha_dag_pattadar against a dag no for selected case no
                        // $this->db->query("UPDATE chitha_dag_pattadar SET jama_yn=null 
                        // WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                        // AND lot_no=? AND vill_townprt_code=? AND dag_no=? AND patta_no=? AND 
                        // patta_type_code=?", 
                        // array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                        //     $vill_code, $dag->dag_no, $patta_no, $patta_type));

                        $table = 'chitha_dag_pattadar';

                        $params = [
                            'jama_yn' => null,  // setting jama_yn to NULL as in your query
                        ];

                        $where = [
                            'dist_code'          => $dist_code,
                            'subdiv_code'        => $subdiv_code,
                            'cir_code'           => $circle_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no'             => $lot_no,
                            'vill_townprt_code'  => $vill_code,
                            'dag_no'             => $dag->dag_no,
                            'patta_no'           => trim($patta_no),  // trim applied in PHP
                            'patta_type_code'    => $patta_type,
                        ];

                        // Execute update via your model
                        $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    }
                    //update chitha_pattadar against a patta no
                    // $this->db->query("UPDATE chitha_pattadar SET jama_yn='' 
                    // WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                    // AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=?", 
                    // array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, 
                    //     $vill_code, $patta_no, $patta_type));

                    $table = 'chitha_pattadar';

                    $params = [
                        'jama_yn' => '',
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no'             => $lot_no,
                        'vill_townprt_code'  => $vill_code,
                        'patta_no'           => $patta_no,
                        'patta_type_code'    => $patta_type,
                    ];

                    // Then call your model update function, e.g.:
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }            
            }
        }
        /////////////////////Deletion of Dag from Jamabandi if not exists in chitha///////////////////////
        $sql="Delete from jama_dag p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$circle_code' and p.mouza_pargona_code='$mouza_code' and p.lot_no='$lot_no' 
            and p.vill_townprt_code='$vill_code' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='$patta_type' and dag_no not in 
            (select dag_no from chitha_basic p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$circle_code' and p.mouza_pargona_code='$mouza_code' and p.lot_no='$lot_no'
            and p.vill_townprt_code='$vill_code'  and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='$patta_type') ";
        $this->db->query($sql);
        //////////////////////////////////////////////////////////////////
        $returnData = $this->jamaUpdateStep($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $patta_type);
        array_push($update, $returnData);
        $time_end = microtime(true);
        $updateTime = ($time_end - $time_start)." Millisecond";

        if(sizeof($update) != 0){
            $url="<a href='".base_url()."index.php/chithareport/jamadistrictDetails_dc_lao' class='text-primary' > Please click here to update another Jamabandi" ."</a>";
            log_message('error', 'Total time taken to Update Jamabandi : '.$updateTime);
            $this->session->set_flashdata('message', sizeof($update) .
                    " updated in JamaBandi for Patta # $patta_no. In case "
                    . " of any discrepancy between and chitha"
                    . " and Jamabandi, Kindly use the Jamabandi Edit Entry Module to correct the Jamabandi. $url");
            redirect(base_url() . 'index.php/home/'); //..............................
        }
        else
        {
            log_message('error', 'Total time taken to Update Jamabandi : '.$updateTime);
            $this->session->set_flashdata('message', "Jamabandi might have already updated for selected case(s). Kindly check Jamabandi.");
            redirect(base_url() . 'index.php/home/'); //..............................
        }        
    }
    public function jamaUpdateStep($dist_code, $subdiv_code, $circle_code, $mouza_code, 
        $lot_no, $vill_code, $patta_no, $patta_type) 
    {
        $time_start = microtime(true);
        //$this->db->trans_begin();

        $headtitle = array(
            'title' => 'Home Page'
        );
        $get_old_patta_type_code='';
        $patta_no = $patta_no;
        $patta_type = $patta_type;
        $dist_code = $dist_code;
        $subdiv_code = $subdiv_code;
        $circle_code = $circle_code;
        $mouza_code = $mouza_code;
        $lot_no = $lot_no;
        $vill_code = $vill_code;

        $query_dags = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . " and  (lower(jama_yn)!='y' or jama_yn is null)";

        $dags = $this->db->query($query_dags)->result();
        $pendingMap = false;
        $defined = define_date;
        foreach ($dags as $d) {
            //This part is to check for mutation cases.
            $queryCheck = "select count(*) as c from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                    . "and dag_no='$d->dag_no' and map_partition is null and order_type_code='02' and date(co_ord_date)>='$defined'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        foreach ($dags as $d) {
            //This part is to check for partition cases if map pending.
            $queryCheck = "select count(*) as c from chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                    . "and dag_no='$d->dag_no' and map_partition='P'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        $query = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " and (lower(jama_yn)!='y' or jama_yn is null)";

        $data = $this->db->query($query)->result();

        $countDag = 1;

        foreach ($data as $d) {
            $data = array(
                'dist_code' => $d->dist_code,
                'subdiv_code' => $d->subdiv_code,
                'cir_code' => $d->cir_code,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'lot_no' => $d->lot_no,
                'vill_townprt_code' => $d->vill_townprt_code,
                'patta_no' => trim($d->patta_no),
                'old_patta_no' => $d->old_patta_no,
                'patta_type_code' => $d->patta_type_code,
                'user_code' => $d->user_code,
                'entry_date' => $d->date_entry,
                'entry_mode' => 'U'
            );

            unset($data['dag_class_code']);
            //Checks if new patta exists or not
            $q = "select count(*) as count from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                    . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";

            $count = $this->db->query($q)->row()->count;

            if ($count == 0) {
                $this->db->insert('jama_patta', $data); //.......................
            }
            ///////////
            $entry_date=date('Y-m-d');
            $g = "Update jama_patta set entry_date='$entry_date' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                    . " and trim(patta_type_code)=trim('$d->patta_type_code') and TRIM(patta_no)=trim('$d->patta_no')";
            $this->db->query($g);
            ///////////////
        }
        $columnMap = [
            'dist_code' => 'dist_code',
            'subdiv_code' => 'subdiv_code', 
            'cir_code' => 'cir_code',
            'mouza_pargona_code' => 'mouza_pargona_code',
            'lot_no' => 'lot_no',
            'vill_townprt_code' => 'vill_townprt_code',
            'dag_no' => 'dag_no',
            'patta_type_code' => 'patta_type_code',
            'patta_no' => 'patta_no',
            'land_class_code' => 'dag_class_code', // renamed
            'dag_area_b' => 'dag_area_b',
            'dag_area_k' => 'dag_area_k',
            'dag_area_lc' => 'dag_area_lc',
            'dag_area_g' => 'dag_area_g',
            'dag_area_kr' => 'dag_area_kr',
            'dag_area_are' => 'dag_area_acre',
            'dag_revenue' => 'dag_revenue',
            'dag_n_desc' => 'dag_n_desc',
            'dag_s_desc' => 'dag_s_desc',
            'dag_e_desc' => 'dag_e_desc',
            'dag_w_desc' => 'dag_w_desc',
            'user_code' => 'user_code',
            'date_entry' => 'entry_date', // renamed
            'dag_nlrg_no' => 'dag_nlrg_no',
            'dag_status' => 'dag_status',
            'created_on' => 'created_on',
            'updated_on' => 'updated_on',
            'dag_flag_type' => 'dag_flag_type',
            'dag_rural_urban_type' => 'dag_rural_urban_type',
            'dag_area_type' => 'dag_area_type',
            'possession_from' => 'possession_from',
            'police_station' => 'police_station',
            'block_code' => 'block_code',
            'gp_code' => 'gp_code',
            'revenue_paid_upto' => 'revenue_paid_upto',
            'zonal_value' => 'zonal_value',
            'category_id' => 'category_id',
            'map_for_property' => 'map_for_property',
            'old_ulpin' => 'old_ulpin',
            'ulpin' => 'ulpin',
            'old_patta_no' => 'old_patta_no'
        ];

        // Build SELECT columns
        $selectColumns = [];
        foreach ($columnMap as $sourceCol => $targetCol) {
            if ($sourceCol === $targetCol) {
                $selectColumns[] = $sourceCol;
            } else {
                $selectColumns[] = "$sourceCol as $targetCol";
            }
        }

        // Add hardcoded values
        $selectColumns[] = "'U' as entry_mode";

        $selectClause = implode(', ', $selectColumns);
        //echo "<br>";
        $query_dags = "select $selectClause from chitha_basic where TRIM(chitha_basic.patta_no)=trim('$patta_no') and trim(patta_type_code)=trim('$patta_type')"
                . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . " and  (lower(jama_yn)!='y' or jama_yn is null)";

        $dags = $this->db->query($query_dags)->result();

        foreach ($dags as $d) {
            $old_patta_no = $d->old_patta_no;
            $qe = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and"
                    . " patta_type_code='$d->patta_type_code'";

            $count = $this->db->query($qe)->row()->count;

            if ($count == 0) {
                //Inserts if new patta & new dag does not exists
                $this->db->insert('jama_dag', $d); //.......................
                //Checks if old patta & new dag exists(basically done because of full partition and full conversion)
                $check = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                        . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                $check_existance = $this->db->query($check)->row()->count;
                if ($check_existance == '1') {
                    //before deleting get the old_patta_type_code from inserting remarks in the old patta 
                    $get_old_patta_type_code = "select patta_type_code as patta_type_code from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                            . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";
                    $get_old_patta_type_code = $this->db->query($get_old_patta_type_code)->row()->patta_type_code;

                    //Delete old patta & dag that exists(basically done because of full partition and full conversion) 
                    $delete = "Delete from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                            . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                    $this->db->query($delete); //.......................
                }
            } else {
                if($d->dag_revenue){
                    $d->dag_revenue = $d->dag_revenue;
                    $d->dag_localtax = $d->dag_revenue/4;
                }
                if ($d->dag_revenue == null) {
                    $d->dag_revenue = 15;
                }
                if($d->dag_localtax == null) {
                    $d->dag_localtax = 4;
                }
                $query = "update jama_dag set dag_class_code='$d->dag_class_code', dag_area_b='$d->dag_area_b', dag_area_k='$d->dag_area_k' ,dag_area_lc='$d->dag_area_lc',dag_revenue='$d->dag_revenue',dag_localtax='$d->dag_localtax' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and"
                        . " dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

                $this->db->query($query); //.......................
            }

            $g = "select * from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

            //This part is to check for mutation case Orders.
            $q = "select * from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                    . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and"
                    . " (lower(jama_updated)!='y' or jama_updated is null)";

            /* start of generating remarks for col8 related orders */
            // $col8Remark = $this->getCol8Remark($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            //var_dump($col8Remark);
            // $remarkText= $this->generate8Remark($d->dag_no, $col8Remark);

            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){

            $col8Remark = $this->getCol8Remark_kar($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            $remarkText = $this->generate8Remark_kar($d->dag_no, $col8Remark);
            }

            else{
            $col8Remark = $this->getCol8Remark($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            $remarkText = $this->generate8Remark($d->dag_no, $col8Remark);
            }

            //echo $remarkText; return;
            // var_dump($remarkText); 
            // die();
            /* end of generating remarks for col8 related orders */

            /* Inserting remarks of all col8 orders */
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no'";

            $line_no = $this->db->query($lineNo)->row()->max;

            if ($line_no == null) {
                $line_no = 1;
            }

            if($remarkText != '' || $remarkText != null){
                for ($j = 0; $j < sizeof($remarkText); $j++) {
                    $remarkData = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type,
                        'rmk_line_no' => $line_no++,
                        'remark' => $remarkText[$j],
                        'user_code' => $d->user_code,
                        'entry_date' => date('Y-m-d'),
                        'entry_mode' => 'U'
                    );

                    //var_dump($remarkData);
                    if ($remarkText != null) {
                        $this->db->insert('jama_remark', $remarkData); //.......................
                    }
                }
            }
            /* end of inserting new remarks of all col8 orders */

            /* start of generating remarks for col31 related orders */

            $remark3c = array();
            // $col31Remark = $this->getCol31($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            //var_dump($col31Remark);
            // $remark3c= $this->remarkGenerateCol31($d->dag_no, $col31Remark);

            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){

            $col31Remark = $this->getCol31kar($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            //var_dump($col31Remark);
            $remark3c= $this->remarkGenerateCol31kar($d->dag_no, $col31Remark);
            }
            else{
            // echo "<pre>";
            $col31Remark = $this->getCol31($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);
            $remark3c= $this->remarkGenerateCol31($d->dag_no, $col31Remark);
            }
            //echo "<br>***************<br>";
            /* end of generating remarks for col31 related orders */

            /* start of inserting new remarks of all col31 orders in old patta */
            if ($get_old_patta_type_code) {
                $update_patta_no = $old_patta_no;
                $update_patta_type_code = $get_old_patta_type_code;

                $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                        . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                        . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$update_patta_type_code' and "
                        . " TRIM(patta_no)='$update_patta_no'";

                $line_no1 = $this->db->query($lineNoq)->row()->max;

                if ($line_no1 == null) {
                    $line_no1 = 1;
                }

                $remarkData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $update_patta_no,
                    'patta_type_code' => $update_patta_type_code,
                    'rmk_line_no' => $line_no1++,
                    'remark' => $remark3c,
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
                ////var_dump($remarkData);
                $this->db->insert('jama_remark', $remarkData); //.......................
            }

            //die();
            $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                    . " TRIM(patta_no)='$patta_no'";
            $lineNoq . "<br>";
            $line_no1 = $this->db->query($lineNo)->row()->max;
            if ($line_no1 == null) {
                $line_no1 = 1;
            }
            $remarkData1=null;
            foreach($remark3c as $tmprmk)
            {
                if ($tmprmk == null || empty($tmprmk))
                {
                    continue;
                }
                $remarkData1[] = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type,
                    'rmk_line_no' => $line_no1++,
                    'remark' => $tmprmk,
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
            }
            if ($remarkData1 != null) {
                //$this->db->insert('jama_remark', $remarkData); //.......................
                $this->db->insert_batch('jama_remark', $remarkData1);
            }
            
            //$orders = $this->db->query($q)->result();
        }
        //$this->db->trans_rollback();
        $query_pattadars = "select * from chitha_pattadar as cp where"
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' ";

        $deleteQuery = "delete from jama_pattadar cp where "
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)=trim('$patta_no') and cp.patta_type_code='$patta_type' and entry_mode='U' and pdar_id not in "
                . " (select pdar_id from chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . " and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type' ) ";

        $pattadars = $this->db->query($query_pattadars)->result();
        // log_message('error',"QUERY###1:".$this->db->last_query());
        foreach ($pattadars as $p) {
            $pflag = 0;
            $pdar_id = $p->pdar_id;
            $p->pdar_name = str_replace("'", "", $p->pdar_name);
            $p->pdar_father = str_replace("'", "", $p->pdar_father);
            $update_name_in_jama = "Update jama_pattadar set pdar_name='$p->pdar_name',pdar_father='$p->pdar_father' where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$patta_type' and pdar_id='$p->pdar_id' ";

            $this->db->query($update_name_in_jama);
            // log_message('error',"QUERY###2:".$this->db->last_query());
            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id=$pdar_id and p_flag='1'";

            $p_flagCount = $this->db->query($count_q)->row()->count;
            // log_message('error',"QUERY###4:".$this->db->last_query());
            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id = $pdar_id";
            $count_dag_q;

            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;
            // log_message('error',"QUERY###3:".$this->db->last_query());
            $p->pdar_land_b = 0;
            $p->pdar_land_k = 0;
            $p->pdar_land_lc = 0;
            $p->pdar_land_g = 0;
            $p->pdar_land_kr = 0;

            if ($p_flagCount == $dag_presentCount) {
                $p->p_flag = '1';
            } else {
                $p->p_flag = '0';
            }

            $p->entry_date = $p->date_entry;
            $p->entry_mode = 'U';
            $p->pdar_id = $p->pdar_id;
            //$p->pdar_father=$p->pdar_father;
            unset($p->dag_por_b);
            unset($p->dag_por_k);
            unset($p->dag_por_lc);
            unset($p->dag_por_g);
            unset($p->dag_por_kr);
            unset($p->date_entry);
            unset($p->operation);
            unset($p->jama_yn);
            unset($p->pdar_guard_reln);
            unset($p->f1_case_no);
            unset($p->f2_case_no);
            unset($p->o1_case_no);
            unset($p->o2_case_no);
            unset($p->dag_no);
            unset($p->uuid);
            $query = "select count(*) as count from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$patta_type' and pdar_id='$p->pdar_id'";

            $pdar_id_query = "select max(cast (pdar_id as int)) as new_pdar_id from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$patta_type' ";
            $pdar_id_new = $this->db->query($pdar_id_query)->row()->new_pdar_id;
            if ($pdar_id_new == null) {
                $pdar_id_new = 1;
            } else {
                $pdar_id_new +=1;
            }
            $count = $this->db->query($query)->row()->count;
            if ($count == 0) {
                $this->db->insert('jama_pattadar', $p); //......................
            }
            $count++;
        }
        $query_pattadars_pflag = "select * from chitha_dag_pattadar as cp where"
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' ";
        $toRemove = $this->db->query($query_pattadars_pflag)->result();
        foreach ($toRemove as $remove) {
            ///////////////////////////////////////
            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id=$remove->pdar_id and p_flag='1'";

            $p_flagCount = $this->db->query($count_q)->row()->count;
            // log_message('error',"QUERY###.5".$this->db->last_query());
            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type' and "
                    . " TRIM(patta_no)='$patta_no' and pdar_id = $remove->pdar_id";
            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;
            // log_message('error',"QUERY###.6".$this->db->last_query());
            if ($p_flagCount == $dag_presentCount) {
                $remove->p_flag = '1';
            } else {
                $remove->p_flag = '0';
            }
            /////////////////////////////
            $this->db->query("update jama_pattadar cp set p_flag='$remove->p_flag' where "
                    . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                    . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                    . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and pdar_id = '$remove->pdar_id' ");
        }

        // $update_chitha = "update chitha_basic set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";
        // $this->db->query($update_chitha); //..............................
       $table = 'chitha_basic';

        $params = [
            'jama_yn' => 'y',
        ];

        $where = [
            'patta_no'           => trim($patta_no), // Equivalent to TRIM(patta_no)
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];

        // Execute the update
        $tstatus = $this->Chitha_basic_model->update_table($table, $params, $where);

       
        // $update_pattadar = "update chitha_pattadar set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";

        $table = 'chitha_pattadar';
        $params = [
            'jama_yn' => '',   // set jama_yn to empty string
        ];
        $where = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
            'patta_no'           => trim($patta_no), // trim here since SQL uses TRIM()
            'patta_type_code'    => $patta_type,
        ];
        $update_pattadar = $this->Chitha_basic_model->update_table($table, $params, $where);


        // $update_dag_pattadar = "update chitha_dag_pattadar set jama_yn='y' where " .
        //         " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //         . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //         . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //         . "";

        $table = 'chitha_dag_pattadar';

        $params = [
            'jama_yn' => 'y',
        ];

        $where = [
            'patta_no'           => trim($patta_no),  // trim applied in PHP instead of SQL TRIM
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];

        // Call your update function
        $update_dag_pattadar = $this->Chitha_basic_model->update_table($table, $params, $where);


        
        // $this->db->query($update_pattadar); //..............................
        // $this->db->query($update_dag_pattadar); //..............................

        return $dags;
    }
    public function remarkGenerateCol31($dag_no, $q) {
        //var_dump($q);
        $count = 1;
        $remark31 = "";
        $remarks=array();
        $order_count = 1;

       // if (sizeof($q) > 1) {
        foreach($q as $r){
            if($r==null){
                continue;
            }
            if ((($r['remark_type_code']) == '01') && (($r['ord_type_code']) == '03')) {
                //echo "hi";
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "<br></u>";

                $remark31 .= "চক্ৰ বিষয়া'ৰ ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে   $dag_no  দাগৰ ";
                if ($r['by_right_of'] == '11') {
                    $remark31.=" অংশৰ জমিত ";
                }else{
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " লেছা মাটি ";
                }
                $remark31 .= $this->utilityclass->getTransferType($r['by_right_of']) ."  " ;
                $count = 0;
                $howmany = sizeof($r['alongwith_name']) - 1;
                foreach ($r['alongwith_name'] as $al) {
                    $remark31 .= $al['alongwithname'];
                    if ($count < (sizeof($r['alongwith_name']) - 2)) {
                        $remark31 .= " , ";
                    } elseif ($count == (sizeof($r['alongwith_name']) - 2)) {
                        $count;
                        $remark31 .= " আৰু ";
                    } else {
                        $remark31 .= " ";
                    }
                    $count++;
                }
                if (sizeof($r['alongwith_name']) != '0') {
                    $remark31 .= " ৰ লগত ";
                }
                $count = 0;

                $howmany = sizeof($r['inplace_of_name']) - 1;
                if ($howmany >= 0) {
                    foreach ($r['inplace_of_name'] as $al) {
                        $remark31 .= $al['inplace_of_name'];
                        if ($count < sizeof($r['inplace_of_name']) - 1) {
                            $remark31 .= " আৰু ";
                            $count++;
                        }
                    }
                    $remark31 .= " ৰ  স্হলত ";
                }

                $count = 0;
                $howmany = sizeof($r['infav']) - 1;

                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .= " আৰু ";
                        $count++;
                    }
                }
                if ($r['ord_type_code'] == '03') {
                    $remark31 .= " ৰ নামত নামজাৰী কৰা হ’ল | <br>";
                }
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u>(" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u>(" . $r['username'] . ")</p>";
                $remark31 .= "<p>Reg No (" . $r['reg_deal_no'] . ")</p>";
                if ($r['reg_date'] != "") {
                    $remark31 .="Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")";
                    //$remark31 .= "<p>Reg Date (" . date('d-m-Y', strtotime($r['reg_date'])) . ")</p>";
                }
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                }
                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }

            //Order type 01 is for Conversion case(ম্যাদীকৰণ)
            if (($r['ord_type_code']) == '01') {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= $r['ord_passby_desig'] . "'ৰ <br>";
                $remark31 .= $r['ord_no'] . "  নং  ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " গোচৰৰ  ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " তাৰিখৰ হুকুমমৰ্মে ";
                $remark31 .= $r['patta_no'] . " নং একচনা পট্টাৰ " . $r['dag_no'] . " নং দাগৰ  " . $r['premium'] . " টকা প্ৰিমিয়ামত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        echo " আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ পৰা আদায় হোৱাত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        $remark31 .=" আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ নামত ";
                if (($r['land_area_b'] != '0') || ($r['land_area_k'] != '0') || ( $r['land_area_lc']) != '0') {
                    $remark31 .= $r['land_area_b'] . " বিঘা  " . $r['land_area_k'] . " কঠা  " . $r['land_area_lc'] . " লেছা " . "মাটি  পৃঠক ";
                } else {
                    
                }

                $remark31 .= $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " নং দাগে ম্যাদীকৰণ কৰা হ'ল | <br>";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . " </p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . "</p>";

                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }

            //remark type 01 is for all office case হুকুম   and Order type 04 is for Office Partition case(বাটোৱাৰা)
            if ((($r['remark_type_code']) == '01') && (($r['ord_type_code']) == '04')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";
                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $dag_no = $r['old_dag'];

                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে  $dag_no দাগৰ ";
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " লেছা মাটি   ";

                $count = 0;

                $howmany = sizeof($r['infav']) - 1;
                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .=" আৰু ";
                        $count++;
                    }
                }

                $remark31 .= " নামত " . $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " দাগ কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বাটোৱাৰা ও নথি সংশোধন কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                }

                $remarks[] = $remark31;
                $remark31 = null;

                continue;
            }

            //remark type 08 is for land Reclassification
            if ((($r['remark_type_code']) == '08') && (($r['ord_type_code']) == '00')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং :</u><br>";
                $remark31 .= $r['reclass_case_no'];
                $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  " . $r['order_passed_designation']. " মহোদয়ে  " . $r['date'];
                $remark31 .= "  তাৰিখে দিয়া অনুমোদন মৰ্মে  " . $r['patta_no'];
                $remark31 .= "  নং পট্টাৰ  " . $r['dag_no'] . "  নং দাগৰ শ্রেণী  " . $this->utilityclass->getLandClassCode($r['presentclass']) . "'ৰ  পৰা  " . $this->utilityclass->getLandClassCode($r['proposed_land_class']);
                $remark31 .= "  লৈ পৰিবৰ্তন কৰা হ'ল । ";
                
                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }

            //Order type 06 is for Name Correction case(নাম সংশোধন)
            if (($r['ord_type_code']) == '06') {
                //echo "hi";
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['ord_no'] . " -ৰ হুকুম মৰ্মে " . $r['dag_no'] . " দাগৰ ";

                $count = 0;
                $remark31 .= $r['infavor_of_name'] . " ৰ  নাম   " . $r['infavor_of_corrected_name'] . "  কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //return;

                $remarks[] = $remark31;
                $remark31 = null;
                
                continue;
                //echo $remark31;
                //eturn $remark31;
            }

            //remark type 01 is for all office case হুকুম   and Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
            if ((($r['remark_type_code']) == '01') && (($r['ord_type_code']) == '07')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['orderdate']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['order_no'] . " -ৰ হুকুম মৰ্মে  " . $r['dag_no'] . "  দাগৰ পটাদাৰ ";
                $count = 0;
                $remark31 .= $r['infavor_of_name'] . "  ৰ আবেদন মৰ্মে পটাদাৰ   " . $r['name_delete'] . " ৰ নাম কৰ্তন কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";

                $remarks[] = $remark31;
                $remark31 = null;

                continue;
            }

            //remark type 10 is Allotments
            if ((($r['remark_type_code']) == '10') and ( ($r['ord_type_code']) == '10')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " . $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । ";
                $remark31 .= " অসম চৰকাৰৰ 03-03-2024  তাৰিখৰ  ECF 200418  নং অধিসূচনা অনুসৰি বিধি ২৬- A মৰ্মে উক্ত মাটি হস্তান্তৰ কৰিলে উক্ত বন্দবস্তিকাৰী ভুমিহীন হলেও ভৱিষ্যতে পুনৰ চৰকাৰী মাটি বন্দোবস্তিৰ যোগ্য নহব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";

                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }            
            // Modified on 19/06/2020 STPP           
            if ((($r['remark_type_code']) == '11') and ( ($r['ord_type_code']) == '10')) {                  
                  $case_no=$r['case_no'];
                  $allotment_certificate123 = $this->db->query("Select * from allotment_doc_details where case_no='$case_no'")->row();
                   //var_dump($allotment_certificate123);
                  $dist_name = $this->utilityclass->getDistrictName($allotment_certificate123->dist_code);
                  $dag_details = $this->db->query("Select * from allotment_pet_dag where case_no='$case_no'")->row();
                  $q = "Select * from allotment_petitioner where case_no='$case_no' ";       
                  $applicant = $this->db->query($q)->row();
                  $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                  $remark31 .=  "অসম চৰকাৰৰ  " .date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue))." ইং তাৰিখৰ ".$allotment_certificate123->govtcertificate_no. " নং চিঠি আৰু " . $dist_name. " জিলাৰ উপায়ুক্ত মহোদয়ৰ ".date('d/m/Y',strtotime($allotment_certificate123->date_of_issue))." ইং তাৰিখৰ ".$allotment_certificate123->certficate_no." নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ ".date("d/m/Y"). " ইং তাৰিখৰ ".$case_no."  নং গোচৰৰ নিদেৰ্শ মৰ্মে " .$dag_details->dag_no. " নং দাগৰ জমিৰ " .$dag_details->alot_area_b." বিঘা ".$dag_details->alot_area_k." কঠা ".$dag_details->alot_area_lc." লেছা  মাটি ".$dag_details->premium." টকা প্ৰিমিয়াম আদায় ক্রমে ".$applicant->alotee_name." পিতা ".$applicant->alotee_gurdian." নামত  নতুন ".$r[dag_no]." নং দাগ আৰু নতুন ".$r[patta_no]." নং খেৰাজ ম্যাদী পট্টা ভুক্ত কৰা হল।";
                $remarks[] = $remark31;
                $remark31 = null;
              continue;
            }
            if ((($r['remark_type_code']) == '12') and ( ($r['ord_type_code']) == '10')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " .$r[premium]."  টকা প্ৰিমিয়াম আদায় ক্রমে   ". $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । ";
                $remark31 .= " অসম চৰকাৰৰ 03-03-2024  তাৰিখৰ  ECF 200418  নং অধিসূচনা অনুসৰি বিধি ২৬- A মৰ্মে উক্ত মাটি হস্তান্তৰ কৰিলে উক্ত বন্দবস্তিকাৰী ভুমিহীন হলেও ভৱিষ্যতে পুনৰ চৰকাৰী মাটি বন্দোবস্তিৰ যোগ্য নহব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>"; 

                $remarks[] = $remark31;
                $remark31 = null;  
                continue;
            }
           //return $remark31;    
        }
        return $remarks;
    }


    public function getCol31kar($patta_no, $district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $data[] = array();
        $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from chitha_rmk_gen where  "
                . "dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                . " (dag_no ='$dag_no') and (lower(jama_updated)!='y' or jama_updated is null)  order by rmk_type_hist_no";

        $innerdata26 = $this->db->query($innerquery26)->result();

        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;

            //remark type 01 is for all office case হুকুম
            if ($rmk_type_code == "01") {
                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                        . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g,user_code,operation  "
                        . " from chitha_rmk_ordbasic where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                        . " and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";

                $innerdata27 = $this->db->query($innerquery27)->result();

                foreach ($innerdata27 as $chitharmk_ord_basic) {
                    $dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
                    $order_date = $chitharmk_ord_basic->ord_date;
                    $ord_no = $chitharmk_ord_basic->ord_no;
                    $case_no = $chitharmk_ord_basic->case_no;
                    $ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
                    $lm_code = $chitharmk_ord_basic->lm_code;
                    $co_code = $chitharmk_ord_basic->co_code;
                    $user_code = $chitharmk_ord_basic->user_code;
                    $operation = $chitharmk_ord_basic->operation;
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;
                    $m_dag_area_g = $chitharmk_ord_basic->m_dag_area_g;

                    $get_designation = $this->db->query("select user_desig_as as designation from master_user_designation "
                                    . "where user_desig_code = '$ord_passby_desig'")->row()->designation;

                    //Order type 01 is for Conversion case(ম্যাদীকৰণ)
                    if ($ord_type_code == '01') {
                        $innerquery28 = " select patta_no,patta_type_code FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                                . "rmk_type_hist_no='$rmk_type_hist_no' ";

                        $innerdata28 = $this->db->query($innerquery28)->result();

                        $patta_no = "";
                        $patta_type_code = "";
                        $patta_type = "";
                        $premium = "";
                        $premi_chal_recpt_no = "";
                        $premi_chal_recpt = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $land_area_b = "";
                        $land_area_k = "";
                        $land_area_lc = "";
                        $username = "";
                        $lm_name = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $chalan_name = "";

                        foreach ($innerdata28 as $rmkconvorder) {
                            $patta_no = trim($rmkconvorder->patta_no);
                            $patta_type_code = $rmkconvorder->patta_type_code;

                            $innerquery29 = "select patta_type from patta_code where type_code=' $patta_type_code' ";
                            $innerdata29 = $this->db->query($innerquery29)->result();

                            foreach ($innerdata29 as $pattatype) {
                                $patta_type = $pattatype->patta_type;
                            }
                        }

                        if ($ord_type_code === '01') {
                            $innerquery30 = "select  distinct premium as premium,premi_chal_recpt_no "
                                    . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                    . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                    . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null"; // group by premi_chal_recpt_no";
                            //echo $innerquery30;
                        } else {
                            $innerquery30 = "select  distinct sum(premium) as premium,premi_chal_recpt_no "
                                    . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                    . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                    . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null group by premi_chal_recpt_no";
                        }
                        $innerdata30 = $this->db->query($innerquery30)->result();

                        foreach ($innerdata30 as $premiuminfo) {
                            $premium = $premiuminfo->premium;
                            $premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;
                            //$premi_chal_recpt = $premiuminfo->premium;

                            $innerquery31 = "select chalan_name from premium_chalan_receipt where code='$premi_chal_recpt'";
                            $innerdata31 = $this->db->query($innerquery31)->result();

                            foreach ($innerdata31 as $premiumchalanrecpt) {
                                $chalan_name = $premiumchalanrecpt->chalan_name;
                            }
                        }

                        $innerquery32 = "select dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
                                . " dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                                . " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                                . " rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata32 = $this->db->query($innerquery32)->result();

                        $applicants = array();

                        foreach ($innerdata32 as $rmk_conv) {
                            $dag_no = $rmk_conv->dag_no;
                            $new_patta_no = $rmk_conv->new_patta_no;
                            $new_dag_no = $rmk_conv->new_dag_no;
                            $ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;

                            if ($ord_type_code === '01') {
                                $innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
                                        . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                        . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            } else {
                                $innerquery33 = "select sum(land_area_b) as land_area_b,sum(land_area_k) as land_area_k,sum(land_area_lc) as "
                                        . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                        . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            }
                            $innerdata33 = $this->db->query($innerquery33)->result();

                            foreach ($innerdata33 as $bklconvorder) {
                                $land_area_b = $bklconvorder->land_area_b;
                                $land_area_k = $bklconvorder->land_area_k;
                                $land_area_lc = $bklconvorder->land_area_lc;
                            }

                            $applicants[] = array(
                                'app_name' => $ord_onbehalf_of,
                                'dag_no' => $dag_no,
                                'new_dag_no' => $new_dag_no,
                                'new_patta_no' => $new_patta_no,
                            );
                        }

                        $innerquery34 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata34 = $this->db->query($innerquery34)->result();

                        foreach ($innerdata34 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        if (($ord_passby_desig == 'DC') || ($ord_passby_desig == 'ADC')) {
                            $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                    . " and subdiv_code='00' and cir_code='00' and user_code ='$co_code'";
                        } else {
                            $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        }
                        $innerdata35 = $this->db->query($innerquery35)->result();

                        foreach ($innerdata35 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'patta_no' => "$patta_no",
                            'patta_type_code' => "$patta_type_code",
                            'patta_type' => "$patta_type",
                            'premium' => "$premium",
                            'premi_chal_recpt_no' => "$premi_chal_recpt_no",
                            'premi_chal_recpt' => "$premi_chal_recpt",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'ord_onbehalf_of' => $applicants,
                            'land_area_b' => "$land_area_b",
                            'land_area_k' => "$land_area_k",
                            'land_area_lc' => "$land_area_lc",
                            'username' => "$username",
                            'lm_name' => "$lm_name",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'chalan_name' => "$chalan_name",
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => '01',
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'ord_passby_desig' => $get_designation
                        );

                        $remove = "select dag_no as old_dag_no,patta_type_code as old_patta_type,patta_no as old_patta_no FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' 
                        and (dag_no ='$dag_no' or new_dag_no='$dag_no') and rmk_type_hist_no='$rmk_type_hist_no'";

                        $remove = $this->db->query($remove)->row();

                        // now delete the old from the jama_dag and jama_patta // removing the pattader needs to be checked again
                        $delete2 = "delete from jama_dag where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no') and dag_no='$remove->old_dag_no'";

                        $this->db->query($delete2); //***************************

                        $check = "select count(*) as c from jama_dag where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no')";
                        $check = $this->db->query($check)->row()->c;


                        if ($check == '0') {
                            $delete1 = "delete from jama_patta where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                    . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no')";

                            //$this->db->query($delete1); //***************************
                        }
                    }

                    //Order type 02 is for Allotment case(আবন্টন)
                    if ($ord_type_code == "02") {
                        $innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from chitha_rmk_allottee  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";


                        $innerdata36 = $this->db->query($innerquery36)->result();

                        $ord_date = "";
                        $dag_no = "";
                        $ord_ref_let_no = "";
                        $allottee_name = "";
                        $allottee_land_code = "";
                        $allottee_land_b = "";
                        $allottee_land_k = "";
                        $allottee_land_lc = "";
                        $type = "";
                        $lm_name = "";
                        $status = "";

                        foreach ($innerdata36 as $allotee) {
                            $ord_date = $allotee->ord_date;
                            $dag_no = $allotee->dag_no;
                            $ord_ref_let_no = $allotee->ord_ref_let_no;
                            $allottee_name = $allotee->allottee_name;
                            $allottee_land_code = $allotee->allottee_land_code;
                            $allottee_land_b = $allotee->allottee_land_b;
                            $allottee_land_k = $allotee->allottee_land_k;
                            $allottee_land_lc = $allotee->allottee_land_lc;

                            $innerquery37 = "select  type from  ord_on_gl_type_code where type_code='$allottee_land_code'";
                            $innerdata37 = $this->db->query($innerquery37)->result();

                            foreach ($innerdata37 as $ord_on_typ) {
                                $type = $ord_on_typ->type;
                            }
                        }


                        $innerquery38 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata38 = $this->db->query($innerquery38)->result();

                        foreach ($innerdata38 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery39 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata39 = $this->db->query($innerquery39)->result();

                        foreach ($innerdata39 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'ord_date' => $ord_date,
                            'dag_no' => $dag_no,
                            'ord_ref_let_no' => $ord_ref_let_no,
                            'allottee_name' => $allottee_name,
                            'allottee_land_code' => $allottee_land_code,
                            'allottee_land_b' => $allottee_land_b,
                            'allottee_land_k' => $allottee_land_k,
                            'allottee_land_lc' => $allottee_land_lc,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name
                        );
                    }

                    //Order type 03 is for Office Mutation case(নামজাৰী)
                    if ($ord_type_code == "03") {
                        $innerquery40 = "SELECT inplace_of_name FROM chitha_rmk_inplace_of  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata40 = $this->db->query($innerquery40)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $inplace_of_name = "";
                        $alongwithname = "";
                        $lm_name = "";
                        $status = "";
                        $username = "";

                        foreach ($innerdata40 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                        }


                        $innerquery41 = "select alongwith_name  FROM chitha_rmk_alongwith where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata41 = $this->db->query($innerquery41)->result();

                        $alongwitharray = array();

                        foreach ($innerdata41 as $alongwith) {
                            $alongwithname = $alongwith->alongwith_name;
                            $alongwitharray[] = array(
                                'alongwithname' => $alongwithname
                            );
                        }

                        $innerquery41 = "select inplace_of_name  FROM chitha_rmk_inplace_of where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata46 = $this->db->query($innerquery41)->result();

                        $inplaceofarray = array();

                        foreach ($innerdata46 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                            $inplaceofarray[] = array(
                                'inplace_of_name' => $inplace_of_name
                            );
                        }
                        //var_dump($inplaceofarray);
                        $innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
                                . " new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
                                . " and rmk_type_hist_no='$rmk_type_hist_no'"
                                . " and ord_no= '$ord_no' ";

                        $innerdata42 = $this->db->query($innerquery42)->result();

                        $infav = array();

                        foreach ($innerdata42 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;

                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }
                        //var_dump($infav);
                        $innerquery43 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata43 = $this->db->query($innerquery43)->result();

                        foreach ($innerdata43 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }


                        $innerquery44 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata44 = $this->db->query($innerquery44)->result();

                        foreach ($innerdata44 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g from chitha_rmk_ordbasic "
                                . " where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no' and dag_no ='$dagnoRemarkgen'";
                        log_message("error",$dagnoRemarkgen."chitha_rmk_ordbasic#####".$this->db->last_query());
                        $m_area = $this->db->query($innerquery45)->row();

                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;
                        $m_area_g = $m_area->m_dag_area_g;

                        $co_name = "select username from users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
                        $co_name = $this->db->query($co_name)->result();
                        foreach ($co_name as $co) {
                                $co_username = $co->username;
                        }
                        
                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'alongwith_name' => $alongwitharray,
                            'inplace_of_name' => $inplaceofarray,
                            'bigha' => $m_area_b,
                            'katha' => $m_area_k,
                            'lessa' => $m_area_lc,
                            'ganda' =>$m_area_g,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'order_date' => $order_date,
                            'co_name' => $co_username,
                            'operation' => $operation
                        );
                        //var_dump($data);
                        //exit();
                    }

                    //Order type 04 is for Office Partition case(বাটোৱাৰা)
                    if ($ord_type_code == "04") {
                        $innerquery45 = "select by_right_of,dag_no,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata45 = $this->db->query($innerquery45)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $old_dag = "";
                        $new_dag_no = "";
                        $new_patta_no = "";

                        $infav = array();

                        foreach ($innerdata45 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $old_dag = $infav_of->dag_no;
                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;

                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }

                        $innerquery46 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata46 = $this->db->query($innerquery46)->result();

                        $lm_name = "";

                        foreach ($innerdata46 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery47 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata47 = $this->db->query($innerquery47)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata47 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'old_dag' => $old_dag,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'bigha' => $m_dag_area_b,
                            'katha' => $m_dag_area_k,
                            'lessa' => $m_dag_area_lc,
                            'ganda' => $m_dag_area_g
                        );
                    }

                    //Order type 05 is for Other Party case(অন্যান্য)
                    if ($ord_type_code == "05") {
                        $innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,case_type_code from chitha_rmk_other_opp_party where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";

                        $name_for = "";
                        $name_for_land_b = "";
                        $name_for_land_k = "";
                        $name_for_land_lc = "";
                        $case_type_code = "";
                        $case_type_name = "";
                        $lm_name = "";
                        $username = "";
                        $status = "";

                        $innerdata48 = $this->db->query($innerquery48)->result();

                        foreach ($innerdata48 as $opp_party) {
                            $name_for = $opp_party->name_for;
                            $name_for_land_b = $opp_party->name_for_land_b;
                            $name_for_land_k = $opp_party->name_for_land_k;
                            $name_for_land_lc = $opp_party->name_for_land_lc;
                            $case_type_code = $opp_party->case_type_code;

                            $innerquery49 = "select case_type_name from case_type_code where case_type_code='$case_type_code'";

                            $innerdata49 = $this->db->query($innerquery49)->result();

                            foreach ($innerdata49 as $casename) {
                                $case_type_name = $casename->case_type_name;
                            }
                        }

                        $innerquery50 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata50 = $this->db->query($innerquery50)->result();

                        foreach ($innerdata50 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery51 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata51 = $this->db->query($innerquery51)->result();

                        foreach ($innerdata51 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'name_for' => $name_for,
                            'name_for_land_b' => $name_for_land_b,
                            'name_for_land_k' => $name_for_land_k,
                            'name_for_land_lc' => $name_for_land_lc,
                            'case_type_code' => $case_type_code,
                            'case_type_name' => $case_type_name,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'order_type_code' => $ord_type_code,
                        );
                    }

                    //Order type 06 is for Name Correction case(নাম সংশোধন)
                    if ($ord_type_code == "06") {
                        $innerdata52 = "";
                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $innerquery52 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no,ord_date,ord_no,user_code,dag_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata52 = $this->db->query($innerquery52)->result();



                        foreach ($innerdata52 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $order_type_code = $infav_of->by_right_of;
                            $dag_no = $infav_of->dag_no;
                            $new_patta_no = $infav_of->new_patta_no;
                            $ord_date = $infav_of->ord_date;
                            $ord_no = $infav_of->ord_no;
                            $co_code = $infav_of->user_code;
                        } //infav query bracket

                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata54 = $this->db->query($innerquery54)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infavor_of_corrected_name' => $infavor_of_corrected_name,
                            'infavor_of_name' => $infavor_of_name,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'dag_no' => $dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'order_date' => $ord_date,
                            'ord_no' => $ord_no,
                        );
                        //var_dump($data);
                        //exit;
                        $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                                . "dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                                . " (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' ";

                        //$this->db->query($q);
                    }

                    //Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
                    if ($ord_type_code == "07") {
                        $innerquery55 = "select * from chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata55 = $this->db->query($innerquery55)->result();

                        $infavor_of_name = "";
                        $name_delete = '';
                        $dag_no = "";

                        foreach ($innerdata55 as $infav_of) {
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $co_code = $infav_of->user_code;
                            $ord_date = $infav_of->ord_date;
                            $dag_no = $infav_of->dag_no;
                        } //infav query bracket

                        $ordparty = "Select name_for from chitha_rmk_other_opp_party where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
                                " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  and ord_no= '$ord_no' ";

                        $innerdata59 = $this->db->query($ordparty)->result();

                        foreach ($innerdata59 as $ordparty) {
                            $name_delete = $ordparty->name_for;
                        } //infav query bracket

                        $innerquery53 = "select lm_name FROM LM_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code'  ";

                        $lm_name = $this->db->query($innerquery53)->row()->lm_name;

                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata54 = $this->db->query($innerquery54)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'order_no' => $ord_no,
                            'name_delete' => $name_delete,
                            'infavor_of_name' => $infavor_of_name,
                            'username' => $username,
                            'dag_no' => $dag_no,
                            'status' => $status,
                            'lmname' => $lm_name ?? '',
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'username' => $username,
                            'orderdate' => $ord_date
                        );
                    }
                }
            }

            //remark type 02 is for মণ্ডলৰ টোকা
            if ($rmk_type_code == '02') {
                $innerquery56 = "select  lm_note,lm_note_date,lm_code FROM chitha_rmk_lmnote where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";

                $innerdata56 = $this->db->query($innerquery56)->result();

                foreach ($innerdata as $lmnote) {
                    $lm_note = $lmnote->lm_note;
                    $lm_note_date = $lmnote->lm_note_date;
                    $lm_code = $lmnote->lm_code;
                }
            }

            //remark type 03 is for কাননগুহৰ টোকা
            if ($rmk_type_code == '03') {
                $innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";

                $innerdata57 = $this->db->query($innerquery57)->result();

                foreach ($innerdata57 as $sknoteinf) {
                    $sk_note = $sknoteinf->sk_note;
                    $sk_note_date = $sknoteinf->sk_note_date;
                }
            }

            //remark type 04 is for বেদখলকাৰীৰ বিৱৰণ
            if ($rmk_type_code == '04') {
                $innerquery58 = "SELECT encro_evicted_yn,encro_name FROM chitha_rmk_encro where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";

                $innerdata58 = $this->db->query($innerquery58)->result();

                foreach ($innerdata58 as $encro) {
                    $encro_evicted_yn = $encro->encro_evicted_yn;
                    $encro_name = $encro->encro_name;
                }
            }

            //remark type 08 is for land Reclassification
            if ($rmk_type_code == '08') {

                // $check = $this->db->query("SELECT count(*) as c FROM t_reclassification where dist_code='$district_code' "
                //                 . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //                 . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and co_chitha_updated_yn = 'Y' and rkg_chitha_updated_yn = 'Y' ")->row()->c;

                // if ($check <= '0') {
                //     $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                //             . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //             . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                // } else {
                //     $innerquery59 = "SELECT * FROM t_reclassification where dist_code='$district_code' "
                //             . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //             . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                // }
                $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                            . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";

                $get_user_designation = "Select user_code as order_designation from chitha_rmk_gen where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
                        
                $str = $this->db->query($get_user_designation)->row()->order_designation;
                
                $order_designation = preg_replace('#\d.*$#', '', $str);
                
                $get_designation_name = $this->db->query("Select user_desig_as as user_desig_as from master_user_designation where user_desig_code = '$order_designation'")->row()->user_desig_as;

                
                $innerdata59 = $this->db->query($innerquery59)->result();
                
                foreach ($innerdata59 as $encro) {
                    $reclass_case_no = $encro->case_no;
                    $present_land_class = $encro->present_land_class;
                    $proposed_land_class = $encro->proposed_land_class;
                    $dag = $encro->dag_no;
                    $patta = trim($encro->patta_no);
                    $orderpass = $encro->co_chitha_updated_date;
                    $present_land_class = $encro->present_land_class;
                }

                $data[] = array(
                    'reclass_case_no' => $reclass_case_no,
                    'present_land_class' => $present_land_class,
                    'proposed_land_class' => $proposed_land_class,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '00',
                    'dag_no' => $dag_no,
                    'patta_no' => $patta,
                    'date' => $orderpass,
                    'presentclass' => $present_land_class,
                    'order_passed_designation' => $get_designation_name,
                );
            }

            //remark type 10 is Allotments
            if ($rmk_type_code == '10') {
                $innerquery59 = "SELECT * FROM chitha_rmk_allottee where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";

                $innerdata59 = $this->db->query($innerquery59)->result();

                $q = "Select lm_code,user_code as co_code from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();

                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);

                foreach ($innerdata59 as $encro) {
                    $case_no = $encro->ord_no;
                    $ord_date = $encro->ord_date;
                    $patta_no = $encro->patta_no;
                    $old_dag = $encro->old_dag;
                    $dag_no = $encro->dag_no;
                    $rmk_type_hist_no = $encro->rmk_type_hist_no;
                    $b = $encro->allottee_land_b;
                    $k = $encro->allottee_land_k;
                    $lc = $encro->allottee_land_lc;
                    $doulyear = year_no;
                }

                $data[] = array(
                    'case_no' => $case_no,
                    'ord_date' => $ord_date,
                    'patta_no' => $patta_no,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '10',
                    'old_dag' => $old_dag,
                    'dag_no' => $dag_no,
                    'historyno' => $rmk_type_hist_no,
                    'bigha' => $b,
                    'katha' => $k,
                    'lesaa' => $lc,
                    'doulyear' => $doulyear,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                );
            }
            
            // Modified on 19/06/2020 for settlement process
            
            if (($rmk_type_code == '11')or($rmk_type_code=='12')) {
                $innerquery59 = "SELECT * FROM chitha_rmk_allottee where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";

                $innerdata59 = $this->db->query($innerquery59)->result();

                $q = "Select lm_code,co_code,ord_no from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                        . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();

                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);

                $premiumquery ="select premium from allotment_pet_dag where case_no='$lmco->ord_no'";
                
                //echo "select premium from allotment_pet_dag where case_no='$lmco->ord_no'";
                
                $premiumdata= $this->db->query($premiumquery)->row();
                
                 $premiumdata->premium;
                
                
                
                foreach ($innerdata59 as $encro) {
                    $case_no = $encro->ord_no;
                    $ord_date = $encro->ord_date;
                    $patta_no = $encro->patta_no;
                    $old_dag = $encro->old_dag;
                    $dag_no = $encro->dag_no;
                    $rmk_type_hist_no = $encro->rmk_type_hist_no;
                    $b = $encro->allottee_land_b;
                    $k = $encro->allottee_land_k;
                    $lc = $encro->allottee_land_lc;
                    $doulyear = $encro->doul_year;
                }
                
                
                

                $data[] = array(
                    'case_no' => $case_no,
                    'ord_date' => $ord_date,
                    'patta_no' => $patta_no,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '10',
                    'old_dag' => $old_dag,
                    'dag_no' => $dag_no,
                    'historyno' => $rmk_type_hist_no,
                    'bigha' => $b,
                    'katha' => $k,
                    'lesaa' => $lc,
                    'doulyear' => $doulyear,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                    'premium' =>$premiumdata->premium,
                );
            }
            
            
            // End Modified on 19/06/2020 for settlement process

            $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                    . "dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                    . " (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' ";

            $this->db->query($q); //..............................
        }
        //var_dump($data);
        return $data;
    }

    public function remarkGenerateCol31kar($dag_no, $q) {
        //var_dump($q);
        $count = 1;
        $remark31 = "";
        $remarks=array();
        $order_count = 1;

       // if (sizeof($q) > 1) {
        foreach($q as $r){
            if($r==null){
                continue;
            }
            if ((($r['remark_type_code']) == '01') && (($r['ord_type_code']) == '03')) {
                //echo "hi";
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "<br></u>";

                $remark31 .= "চক্র আধিকারিকের ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                $remark31 .= $r['ord_no'] . " -র হুকুমমর্মে   $dag_no  দাগের ";
                if ($r['by_right_of'] == '11') {
                    $remark31.=" অংশৰ জমিত ";
                }else{
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " ছটাক ";
                $remark31 .= $r['ganda'] . " গণ্ডা মাটি ";
                }
                $remark31 .= $this->utilityclass->getTransferType($r['by_right_of']) ."  " ;
                $count = 0;
                $howmany = sizeof($r['alongwith_name']) - 1;
                foreach ($r['alongwith_name'] as $al) {
                    $remark31 .= $al['alongwithname'];
                    if ($count < (sizeof($r['alongwith_name']) - 2)) {
                        $remark31 .= " , ";
                    } elseif ($count == (sizeof($r['alongwith_name']) - 2)) {
                        $count;
                        $remark31 .= " এবং ";
                    } else {
                        $remark31 .= " ";
                    }
                    $count++;
                }
                if (sizeof($r['alongwith_name']) != '0') {
                    $remark31 .= " র সামিলে ";
                }
                $count = 0;

                $howmany = sizeof($r['inplace_of_name']) - 1;
                if ($howmany >= 0) {
                    foreach ($r['inplace_of_name'] as $al) {
                        $remark31 .= $al['inplace_of_name'];
                        if ($count < sizeof($r['inplace_of_name']) - 1) {
                            $remark31 .= " আৰু ";
                            $count++;
                        }
                    }
                    $remark31 .= " র  স্হলে ";
                }

                $count = 0;
                $howmany = sizeof($r['infav']) - 1;

                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .= " আৰু ";
                        $count++;
                    }
                }
                if ($r['ord_type_code'] == '03') {
                    $remark31 .= " নামে নামজারী করা হইল | <br>";
                }
                $remark31 .= "<p><u class='text-danger'>লট আমিন :</u>(" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্র আধিকারিক :</u>(" . $r['username'] . ")</p>";
                $remark31 .= "<p>Reg No (" . $r['reg_deal_no'] . ")</p>";
                if ($r['reg_date'] != "") {
                    $remark31 .="Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")";
                    //$remark31 .= "<p>Reg Date (" . date('d-m-Y', strtotime($r['reg_date'])) . ")</p>";
                }
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                }
                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }

            //Order type 01 is for Conversion case(ম্যাদীকৰণ)
            if (($r['ord_type_code']) == '01') {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= $r['ord_passby_desig'] . "'ৰ <br>";
                $remark31 .= $r['ord_no'] . "  নং  ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " গোচৰৰ  ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " তাৰিখৰ হুকুমমৰ্মে ";
                $remark31 .= $r['patta_no'] . " নং একচনা পট্টাৰ " . $r['dag_no'] . " নং দাগৰ  " . $r['premium'] . " টকা প্ৰিমিয়ামত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        echo " আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ পৰা আদায় হোৱাত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        $remark31 .=" আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ নামত ";
                if (($r['land_area_b'] != '0') || ($r['land_area_k'] != '0') || ( $r['land_area_lc']) != '0') {
                    $remark31 .= $r['land_area_b'] . " বিঘা  " . $r['land_area_k'] . " কঠা  " . $r['land_area_lc'] . " লেছা " . "মাটি  পৃঠক ";
                } else {
                    
                }

                $remark31 .= $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " নং দাগে ম্যাদীকৰণ কৰা হ'ল | <br>";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . " </p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . "</p>";

                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }

            //remark type 01 is for all office case হুকুম   and Order type 04 is for Office Partition case(বাটোৱাৰা)
            if ((($r['remark_type_code']) == '01') && (($r['ord_type_code']) == '04')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";
                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $dag_no = $r['old_dag'];

                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে  $dag_no দাগৰ ";
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " লেছা মাটি   ";

                $count = 0;

                $howmany = sizeof($r['infav']) - 1;
                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .=" আৰু ";
                        $count++;
                    }
                }

                $remark31 .= " নামত " . $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " দাগ কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বাটোৱাৰা ও নথি সংশোধন কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                }

                $remarks[] = $remark31;
                $remark31 = null;

                continue;
            }

            //remark type 08 is for land Reclassification
            if ((($r['remark_type_code']) == '08') && (($r['ord_type_code']) == '00')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং :</u><br>";
                $remark31 .= $r['reclass_case_no'];
                $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  " . $r['order_passed_designation']. " মহোদয়ে  " . $r['date'];
                $remark31 .= "  তাৰিখে দিয়া অনুমোদন মৰ্মে  " . $r['patta_no'];
                $remark31 .= "  নং পট্টাৰ  " . $r['dag_no'] . "  নং দাগৰ শ্রেণী  " . $this->utilityclass->getLandClassCode($r['presentclass']) . "'ৰ  পৰা  " . $this->utilityclass->getLandClassCode($r['proposed_land_class']);
                $remark31 .= "  লৈ পৰিবৰ্তন কৰা হ'ল । ";
                
                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }

            //Order type 06 is for Name Correction case(নাম সংশোধন)
            if (($r['ord_type_code']) == '06') {
                //echo "hi";
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['ord_no'] . " -ৰ হুকুম মৰ্মে " . $r['dag_no'] . " দাগৰ ";

                $count = 0;
                $remark31 .= $r['infavor_of_name'] . " ৰ  নাম   " . $r['infavor_of_corrected_name'] . "  কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //return;

                $remarks[] = $remark31;
                $remark31 = null;
                
                continue;
                //echo $remark31;
                //eturn $remark31;
            }

            //remark type 01 is for all office case হুকুম   and Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
            if ((($r['remark_type_code']) == '01') && (($r['ord_type_code']) == '07')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['orderdate']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['order_no'] . " -ৰ হুকুম মৰ্মে  " . $r['dag_no'] . "  দাগৰ পটাদাৰ ";
                $count = 0;
                $remark31 .= $r['infavor_of_name'] . "  ৰ আবেদন মৰ্মে পটাদাৰ   " . $r['name_delete'] . " ৰ নাম কৰ্তন কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";

                $remarks[] = $remark31;
                $remark31 = null;

                continue;
            }

            //remark type 10 is Allotments
            if ((($r['remark_type_code']) == '10') and ( ($r['ord_type_code']) == '10')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " . $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । ";
                $remark31 .= " অসম চৰকাৰৰ 03-03-2024  তাৰিখৰ  ECF 200418  নং অধিসূচনা অনুসৰি বিধি ২৬- A মৰ্মে উক্ত মাটি হস্তান্তৰ কৰিলে উক্ত বন্দবস্তিকাৰী ভুমিহীন হলেও ভৱিষ্যতে পুনৰ চৰকাৰী মাটি বন্দোবস্তিৰ যোগ্য নহব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";

                $remarks[] = $remark31;
                $remark31 = null;
                continue;
            }            
            // Modified on 19/06/2020 STPP           
            if ((($r['remark_type_code']) == '11') and ( ($r['ord_type_code']) == '10')) {                  
                  $case_no=$r['case_no'];
                  $allotment_certificate123 = $this->db->query("Select * from allotment_doc_details where case_no='$case_no'")->row();
                   //var_dump($allotment_certificate123);
                  $dist_name = $this->utilityclass->getDistrictName($allotment_certificate123->dist_code);
                  $dag_details = $this->db->query("Select * from allotment_pet_dag where case_no='$case_no'")->row();
                  $q = "Select * from allotment_petitioner where case_no='$case_no' ";       
                  $applicant = $this->db->query($q)->row();
                  $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                  $remark31 .=  "অসম চৰকাৰৰ  " .date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue))." ইং তাৰিখৰ ".$allotment_certificate123->govtcertificate_no. " নং চিঠি আৰু " . $dist_name. " জিলাৰ উপায়ুক্ত মহোদয়ৰ ".date('d/m/Y',strtotime($allotment_certificate123->date_of_issue))." ইং তাৰিখৰ ".$allotment_certificate123->certficate_no." নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ ".date("d/m/Y"). " ইং তাৰিখৰ ".$case_no."  নং গোচৰৰ নিদেৰ্শ মৰ্মে " .$dag_details->dag_no. " নং দাগৰ জমিৰ " .$dag_details->alot_area_b." বিঘা ".$dag_details->alot_area_k." কঠা ".$dag_details->alot_area_lc." লেছা  মাটি ".$dag_details->premium." টকা প্ৰিমিয়াম আদায় ক্রমে ".$applicant->alotee_name." পিতা ".$applicant->alotee_gurdian." নামত  নতুন ".$r[dag_no]." নং দাগ আৰু নতুন ".$r[patta_no]." নং খেৰাজ ম্যাদী পট্টা ভুক্ত কৰা হল।";
                $remarks[] = $remark31;
                $remark31 = null;
              continue;
            }
            if ((($r['remark_type_code']) == '12') and ( ($r['ord_type_code']) == '10')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " .$r[premium]."  টকা প্ৰিমিয়াম আদায় ক্রমে   ". $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । ";
                $remark31 .= " অসম চৰকাৰৰ 03-03-2024  তাৰিখৰ  ECF 200418  নং অধিসূচনা অনুসৰি বিধি ২৬- A মৰ্মে উক্ত মাটি হস্তান্তৰ কৰিলে উক্ত বন্দবস্তিকাৰী ভুমিহীন হলেও ভৱিষ্যতে পুনৰ চৰকাৰী মাটি বন্দোবস্তিৰ যোগ্য নহব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>"; 

                $remarks[] = $remark31;
                $remark31 = null;  
                continue;
            }
           //return $remark31;    
        }
        return $remarks;
    }

    

}
