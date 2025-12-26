<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CaseView extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Caseview/CaseViewnmodel');
        $this->load->model('rtps/RtpsModel');
        $this->load->model('NameCancellation/NameCancellationModel');
    }


    public function caseDetails() {


        $allowed = ['ADC','CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
 
        // $case_no=$this->input->get('case_no');
        $case_no = dec_param($this->input->get('case_no'), 'case_no');
        
        if($case_no == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

       // $case_no='KAM/UTT/2023-24/6586/LDU';


        $case=explode('/',$case_no);
        // $type=($case[4]=='FMUT')?'FMUT':'FPART';
        if($case[4]=='FMUT'){
            $type='FMUT';
        }
        if($case[4]=='FPART'){
            $type='FPART';
        }

        if($case[4]=='OMUT'){
            $type='OMUT';
        }
        if($case[4]=='OPART'){
            $type='OPART';
        }

        if($case[4]=='MiNC'){
            $type='MiNC';
        }

        if($case[4]=='MiND'){
            $type='MiND';
        }

         if($case[4]=='LDU'){
            $type='ACOR';
        }

        if($case[4]=='ACPP'){
            $type='ACPP';
        }

        if($case[4]=='CONV'){
            $type='CONV';
        }


        if($case[4]=='FMUT' or $case[4]=='FPART'){
            $data['app']=$this->CaseViewnmodel->casedetailsforFmut($case_no,$type);

            $data['self']=json_decode($data['app']['aadhar']->self_declaration);
            $adhar_photo_link = null;
            $data['aadhaar_photo'] = null;
            $data['auth_type'] =  $data['app']['aadhar']->auth_type;
            if($data['app']['aadhar']->auth_type == 'AADHAAR'){
                $adhar_photo_link = $data['app']['aadhar']->photo;
                $data['aadhaar_photo'] = $this->getAadhaarPhoto($adhar_photo_link);
            }
        }

        if($case[4]=='OMUT' or $case[4]=='OPART' or $case[4]=='CONV' ){
           $data['app']=$this->CaseViewnmodel->casedetailsforOmut($case_no,$type);

           $data['self']=json_decode($data['app']['aadhar']->self_declaration);
            $adhar_photo_link = null;
            $data['aadhaar_photo'] = null;
            $data['auth_type'] =  $data['app']['aadhar']->auth_type;
            if($data['app']['aadhar']->auth_type == 'AADHAAR'){
                $adhar_photo_link = $data['app']['aadhar']->photo;
                $data['aadhaar_photo'] = $this->getAadhaarPhoto($adhar_photo_link);
            }
        }

        if($case[4]=='RECLASS'){
            $data['app']=$this->CaseViewnmodel->casedetailsforReclass($case_no);
            $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
            $data['self']=json_decode($data['app']['aadhar']->self_declaration);
            $adhar_photo_link = null;
            $data['aadhaar_photo'] = null;
            $data['auth_type'] =  $data['app']['aadhar']->auth_type;
            if($data['app']['aadhar']->auth_type == 'AADHAAR'){
                $adhar_photo_link = $data['app']['aadhar']->photo;
                $data['aadhaar_photo'] = $this->getAadhaarPhoto($adhar_photo_link);
            }

        }

        if($case[4]=='MiNC' or $case[4]=='MiND'){
           $data['app']=$this->CaseViewnmodel->casedetailsforMisc($case_no,$type);

          $data['self']=json_decode($data['app']['aadhar']->self_declaration);
            $adhar_photo_link = null;
            $data['aadhaar_photo'] = null;
            $data['auth_type'] =  $data['app']['aadhar']->auth_type;
            if($data['app']['aadhar']->auth_type == 'AADHAAR'){
                $adhar_photo_link = $data['app']['aadhar']->photo;
                $data['aadhaar_photo'] = $this->getAadhaarPhoto($adhar_photo_link);
            }

           $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($data['app']['basic']->dist_code, $data['app']['basic']->subdiv_code, $data['app']['basic']->cir_code, $data['app']['basic']->mouza_pargona_code, $data['app']['basic']->lot_no,$data['app']['basic']->vill_townprt_code, $data['app']['basic']->patta_no, $data['app']['basic']->dag_no, $data['app']['basic']->patta_type_code, $case_no);
        }

        if($case[4]=='LDU'){
            $data['app']=$this->CaseViewnmodel->casedetailsforLDU($case_no);
            $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
            $data['self']=json_decode($data['app']['aadhar']->self_declaration);
            $adhar_photo_link = null;
            $data['aadhaar_photo'] = null;
            $data['auth_type'] =  $data['app']['aadhar']->auth_type;
            if($data['app']['aadhar']->auth_type == 'AADHAAR'){
                $adhar_photo_link = $data['app']['aadhar']->photo;
                $data['aadhaar_photo'] = $this->getAadhaarPhoto($adhar_photo_link);
            }

        }

        if($case[4]=='ACPP'){
            $data['app']=$this->CaseViewnmodel->casedetailsforACPP($case_no);
            $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
            $data['self']=json_decode($data['app']['aadhar']->self_declaration);
            $adhar_photo_link = null;
            $data['aadhaar_photo'] = null;
            $data['auth_type'] =  $data['app']['aadhar']->auth_type;
            if($data['app']['aadhar']->auth_type == 'AADHAAR'){
                $adhar_photo_link = $data['app']['aadhar']->photo;
                $data['aadhaar_photo'] = $this->getAadhaarPhoto($adhar_photo_link);
            }

        }

        $this->load->model('basundhara/basundharamodel');
        $dharitree=null;
        $data['basundharaAttachment']=$data['sup_doc']=array();
        $data['service_name'] = null;
        $sql="Select * from basundhar_application where (dharitree=? or basundhara=?) ";
        $data2=$this->db->query($sql,array($case_no,$case_no));
        if($data2->num_rows()>0){
            $rtps=$data2->row()->basundhara;
            $dharitree=$data2->row()->dharitree;
            $sql32="SELECT basundhara FROM basundhar_application WHERE basundhara=? and (basundhara is not null or basundhara='') ";
            $dataFound=$this->db->query($sql32, $rtps)->row();
            if($dataFound){
                $data32 = $dataFound->basundhara;
                $var = explode('/', $data32);
                $service = $var['0'];
            }else{
                $service = null;
            }
            $data['service_name'] = $service;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($dharitree);
        }
        $data1=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($dharitree));
        if($data1->num_rows()>0){
            $data['sup_doc']=$data1->result();
        }
        ///////Old RTPS MUT/PART///////////
        $sqlOld="Select * from petition_basic where case_no=? and (application_ref_no is not null or application_ref_no=?) and applid is not null";
        $dataOld=$this->db->query($sqlOld,array($case_no,$case_no));
        if($dataOld->num_rows()>0){
            $application_ref_no= $dataOld->row()->application_ref_no;
            $applid= $dataOld->row()->applid;
            if($dataOld->row()->mut_type=='03'){
                $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
            }else if($dataOld->row()->mut_type=='04'){
                $url = RTPS_LINK."partition/partition_attachment_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
            //var_dump($output);
            $output = json_decode($output);
            // var_dump($output);
            $data['attachment'] = $output;
            $data['application_ref_no'] = $application_ref_no;
        }
        //////////////////
        $data['_view'] = 'caseview/casedetails';
        $this->load->view('layouts/main',$data);


    }

    public function decodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }

    public function getAadhaarPhoto($adhar_photo_link){
        //**********reopening the updated file */
        $open_adhar_file = fopen($adhar_photo_link, "r");
        $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
        fclose($open_adhar_file);
        // decoding the base64 encoding file variable
        $file = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Adhar Photo' width='170' height='200'>";
        return $file;
    }


}
