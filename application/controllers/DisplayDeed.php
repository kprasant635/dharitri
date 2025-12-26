<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DisplayDeed extends CI_Controller {

    public function index() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dis = $this->session->userdata('dist_code');
        $sub = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $status='0';
		//WT
        $algorithm = 'HS256';
		$secret = 'D2E6857E5A9F835042FB6232CF08418437F13D15637DEAE4BFF236587B49AEA1';
		$time = time();
		$leeway = 60; // seconds
		$ttl = 60; // seconds
		$claims = array('dist'=>$dis,'sub'=>$sub,'cir'=>$cir_code, 'status'=>'0','iss'=>'ilrms');
		// test that the functions are working
		$token = $this->utilityclass->generateToken($claims,$time,$ttl,$algorithm,$secret);
        ///////END WT
		//$url = LINK_33."webservices/getsronote?val=".$token;
        $url = LINK_33."webservices/getsronote?dist=$dis&sub=$sub&cir=$cir_code&status=$status";
		//echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
	
        foreach ($output as $d) {
            if(isset($d->deed_no_actual)){
                     $deed_no_actual = $d->deed_no_actual;
                }
                else{
                    $deed_no_actual=null;
                }
            $data = array(
                'dist_code' => $d->distCode,
                'subdiv_code' => $d->subdivCode,
                'cir_code' => $d->cirCode,
                'mouza_pargona_code' => $d->mouzaPargonaCode,
                'lot_no' => $d->lotNo,
                'vill_townprt_code' => $d->villTownprtCode,
                'dag_no' => $d->dagNo,
                'deed_type' => $d->deedType,
                'patta_type_code' => $d->pattaTypeCode,
                'patta_no' => trim($d->pattaNo),
                'dag_area_b' => $d->dagAreaB,
                'dag_area_k' => $d->dagAreaK,
                'dag_area_lc' => $d->dagAreaLc,
                'dag_area_g' => $d->dagAreaG,
                'dag_area_kr' => $d->dagAreaKr,
                'reg_to_name' => $d->regToName,
                'reg_from_name' => $d->regFromName,
                'name_of_sro' => $d->nameOfSro,
                'deed_no' => $d->deedNo,
                'date_of_deed' => date('Y-m-d', strtotime($d->dateOfDeed)),
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'status' => 0,
                'sro_code' => $d->sroCode,
                'update_date' => date('Y-m-d G:i:s'),
                'nocno' => $d->nocno,
                'deed_no_actual' => $deed_no_actual
            );
            //var_dump($data);
            $deedNo = $d->deedNo;
            $count = $this->db->query("select count(deed_no) as c from  sro_note where deed_no='$deedNo' and dist_code='$d->distCode' and subdiv_code='$d->subdivCode' and cir_code='$d->cirCode' and sro_code='$d->sroCode'  ")->row()->c;
            if ($count == 0) {
                $this->db->insert('sro_note', $data);
				$claims = array('dist'=>$d->distCode,'sro'=>$d->sroCode,'deedno'=>$d->deedNo,'iss'=>'ilrms');
				// test that the functions are working
				$updatetoken = $this->utilityclass->generateToken($claims,$time,$ttl,$algorithm,$secret);
                // $url=LINK_33."webservices/updatesronote?val=".$updatetoken ;
                $url = LINK_33."webservices/updatesronote?dist=$dis&sro=$d->sroCode&deedno=$d->deedNo";
            }
        }
        //var_dump($data);
        $this->session->set_flashdata('message', 'Record(s) updated successfully !');
        redirect(base_url() . "index.php/home");
    }

    public function Updatestatus() {
        $main['_view'] = 'DisplayDeed/deedregistercase';
        $this->load->view('layouts/main',$main);
    }

    public function FinalUpdatestatus() {
		 $db=  $this->session->userdata('db');
        $deedno = $this->input->post('deedno');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $co_order = $this->input->post('co_order');
        $nature_of_land = $this->input->post('nature_of_land');
        $date = date('Y-m-d');
        $query = "update sro_note set status='1',co_order='$co_order',co_order_date='$date',nature_of_land='$nature_of_land' where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and deed_no='$deedno' ";
        $this->db->query($query);
        $this->session->set_flashdata('message', 'Case has Successfully Registered');
        redirect(base_url() . "index.php/home");
    }

    function noc() {
        $appno = $this->input->get('appno');
        $q = "Select mimetype,filesize,filedata from  nocuploadfile where appno='$appno' ";
        $data = $this->db->query($q)->row();
        
        if(!empty($data))
        {
            header("Content-type: $data->mimetype");
            header("Content-Length: $data->filesize");
            $data = pg_unescape_bytea($data->filedata);
            echo $data;
        }
        else
        {
            $main['_view'] = 'DisplayDeed/norecords';
            $this->load->view('layouts/main',$main);
            //echo "No Records Found";
        }
        
    }
	
	// function sro() {
	// 	/////WT Script
	// 	$slno=$this->input->get('slno');
	// 	$dist=$this->input->get('dist');
	// 	$sro=$this->input->get('sro');
	// 	$algorithm = 'HS256';
	// 	$secret = 'D2E6857E5A9F835042FB6232CF08418437F13D15637DEAE4BFF236587B49AEA1';
	// 	$time = time();
	// 	$leeway = 600; // seconds
	// 	$ttl = 600; // seconds
	// 	$claims = array('slno'=>$slno,'sro'=>$sro,'dist'=>$dist, 'iss'=>'ilrms');
	// 	// test that the functions are working
	// 	$token = $this->utilityclass->generateToken($claims,$time,$ttl,$algorithm,$secret);
	// 	//$this->session->set_userdata('token',$token);
    //     $data=array('slno'=>$slno,'sro'=>$sro,'dist'=>$dist);
    //     $this->session->set_userdata('token',$data);
	// 	redirect('DisplayDeed/displaysro');
	// }
	// function displaysro(){
	// 	$this->load->view('../views/DisplayDeed/displaysro');	
	// }
    function sro_old() 
    {
        $slno=$this->input->get('slno');
        $dist=$this->input->get('dist');
        $sro=$this->input->get('sro');
        // $data=array('slno'=>$slno,'sro'=>$sro,'dist'=>$dist);
        // $this->session->set_userdata('token',$data);
        // redirect('DisplayDeed/displaysro_landhub');
        $ch = curl_init();
        $url = LABDHUB_BASE."old_epanjeeyan/deedview.php";
        $dataArray = ['slno'=>$slno,'sro'=>$sro,'dist'=>$dist]; 
        $data = http_build_query($dataArray);
        $getUrl = $url."?".$data; 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
        $response = curl_exec($ch);       
        if(curl_error($ch)){
            echo 'Request Error:' . curl_error($ch);
        }else{
            $data=base64_decode($response);
            header('Content-type:application/pdf');
            echo $data;
        }   
        curl_close($ch);
    }
    ///////////////
    function displaysro_landhub()
    {
        $this->load->view('../views/DisplayDeed/displaysro_landhub');   
    }

    /////NGDRS deed///////
    // function sroNGDRS() {
    //     $doc_reg_no=$this->input->get('doc_reg_no');
    //     $username='ngdrs';
    //     $upassword='YXNzYW1uZ2Rycw==';

    //     $curl_handle = curl_init();
    //         curl_setopt($curl_handle, CURLOPT_URL, "https://landhub.assam.gov.in/nocApi/dhar_ngdrs/view_deed.php");
    //         curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //         curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    //         curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //             'doc_reg_no' => $doc_reg_no,
    //             'username'=>$username,
    //             'upassword'=>$upassword
    //         )));
    //         $output = curl_exec($curl_handle);
            
    //         // var_dump($curl_handle);
    //         // exit;
    //         if($output!='')
    //         {
    //          $pdf_decoded = base64_decode($output);
    //          header('Content-Type: application/pdf');
    //          echo $pdf_decoded;
    //         }

    // }

    

    /////NGDRS deed///////
    function sroNGDRS() 
    {
        $doc_reg_no=$this->input->get('doc_reg_no');
        $username='ngdrs';
        $upassword='YXNzYW1uZ2Rycw==';
        $url = NGDRS_SRO_NOTE."view_deed.php";
        $post_array = [
            'doc_reg_no' => $doc_reg_no,
            'username' => $username,
            'upassword' => $upassword
        ];

        $output = sendCurlRequest($url, 'POST', $post_array, null);

        if($output!='')
        {
         if($output=="Token number not found.")
            {
                    echo "Deed has not been uploaded yet!";
                    exit;

            }
            else
            {
                $pdf_decoded = base64_decode($output);
                header('Content-Type: application/pdf');
                echo $pdf_decoded;
            }
        }

    }

    function sro()
    {

        $slno=$this->input->get('slno');
        $dist=$this->input->get('dist');
        $sro=$this->input->get('sro');

        $url = "https://landhub.assam.gov.in/nocApi/old_epanjeeyan/view/deedview.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "district_code=" . $dist . "&sro_code=" . $sro . "&doc_no=" . $slno);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic 1wdAgjBRoxJ08Mv9YJBFCy351W3xh2k3'
          ,'Content-Type:application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        if(curl_error($ch))
        {
            echo 'Request Error:' . curl_error($ch);
        }
        else
        {
            if($output!='')
            {

            if($output=="Not found")
            {
                    echo "Deed has not been uploaded yet!";
                    exit;

            }
            else
            {
                $data=base64_decode($output);
                header('Content-type:application/pdf');
                echo $data;
            }
            }
        }   
        curl_close($ch);

    }

}
