<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Appeals extends CI_Controller {

    public function index() {
  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $case_no = $this->input->post('case_no');
            $query = "select * from    petition_basic pb ,petitioner pt,petition_pattadar pd where
                pb.petition_no = pt.petition_no and pb.petition_no = pd.petition_no and 
                pb.case_no = '$case_no'";
           
            $data = $this->db->query($query,array($case_no))->row();
            $petitionNoQuery = "select petition_no from    petition_basic where case_no=?";
            $pNo = $this->db->query($petitionNoQuery,array($case_no))->row()->petition_no;
            $lmCodeQuery = "select lm_code from    petition_lm_note where petition_no=$pNo ";
         
            $lmcode = $this->db->query($lmCodeQuery,array($pNo))->row()->lm_code;
            $firstPartyQuery = "select * from    petitioner where petition_no=?";
            $firstparty = $this->db->query($firstPartyQuery,array($pNo))->result();
            $secondPartyQuery = "select * from    petition_pattadar where petition_no=?";
            $secondparty = $this->db->query($secondPartyQuery,array($pNo))->result();
            $case_details['data']=$data;
            $case_details['case_no']=$case_no;
            $case_details['lmcode']=$lmcode;
            $case_details['first']=$firstparty;
            $case_details['second']=$secondparty;
            $this->load->view('../views/header');
            $this->load->view('../views/appeals/case_details',$case_details);
            $this->load->view('../views/footer');
        } else {
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/appeals/index');
            $this->load->view('../views/footer');
        }
    }

    public function saveAppeal(){
		  $db=  $this->session->userdata('db');
       var_dump($this->input->post());
       $appeal = array(
                'case_no'=>$this->input->post('case_no'),
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                'co_name'=>$this->input->post('co_name'),
                'sk_name'=>$this->input->post('sk_name'),
                'lm_name'=>$this->input->post('lm_name'),
                'date_of_appeal'=>date('Y-m-d'),
                'ast_code'=>$this->session->userdata('user_code')
        );
       
        
        $this->db->insert('appeals',$appeal);
        $appeals_id = $this->db->query("select max(id) as max from    appeals")->row()->max;
        echo $appeals_id;
		
        $case_no = $this->input->post('case_no');
        $query = "select * from    petition_basic pb ,petitioner pt,petition_pattadar pd where
                pb.petition_no = pt.petition_no and pb.petition_no = pd.petition_no and 
                pb.case_no = '$case_no'";
              
        $petitionNoQuery = "select petition_no from    petition_basic where case_no=?";
       
        $pNo = $this->db->query($petitionNoQuery,array($case_no))->row()->petition_no;
	
        $firstPartyQuery = "select * from    petitioner where petition_no=$pNo";
        echo $firstPartyQuery;
        $firstparty = $this->db->query($firstPartyQuery,array($pNo))->result();
        $secondPartyQuery = "select * from    petition_pattadar where petition_no=?";
        $secondparty = $this->db->query($secondPartyQuery,array($pNo))->result();
       
        $case_no = $this->input->post('case_no');
        $date_of_order = $this->input->post('date_of_order');
        $co_name  = $this->input->post('case_no');
        $sdo_name = $this->input->post('sdo_name');
        $lm_name = $this->input->post('lm_name');
        $docs  = $this->input->post('docs');
        $types = $this->input->post('types');

        foreach($firstparty as $fp){
                $dist_code= $fp->dist_code;
                $subdiv_code= $fp->subdiv_code;
                $cir_code= $fp->cir_code;
                $mouza_pargona_code= $fp->mouza_pargona_code;
                $lot_no= $fp->lot_no;
                $vill_townprt_code = $fp->vill_townprt_code;
                $fpData = array(
                'dist_code'=>$fp->dist_code,
                'subdiv_code'=>$fp->subdiv_code,
                'cir_code'=>$fp->cir_code,
                'mouza_pargona_code'=>$fp->mouza_pargona_code,
                'lot_no'=>$fp->lot_no,
                'vill_townprt_code'=>$fp->vill_townprt_code,
                'case_no'=>$case_no,
                'name'=>$fp->pet_name,
                'guardian_name'=>$fp->guard_name,
                'isPattadar'=>1,
                'isFirst'=>1,
                'appeals_id'=>$appeals_id
            );
        }
        $this->db->insert('appeal_petitioner',$fpData);

        foreach($secondparty as $fp){
              $fpData = array(
                'dist_code'=>$fp->dist_code,
                'subdiv_code'=>$fp->subdiv_code,
                'cir_code'=>$fp->cir_code,
                'mouza_pargona_code'=>$fp->mouza_pargona_code,
                'lot_no'=>$fp->lot_no,
                'vill_townprt_code'=>$fp->vill_townprt_code,
                'case_no'=>$case_no,
                'name'=>$fp->pdar_name,
                'guardian_name'=>$fp->pdar_guardian,
                'isPattadar'=>1,
                'isSecond'=>1,
                'appeals_id'=>$appeals_id
                
            );
        }
        $this->db->insert('appeal_petitioner',$fpData);

        $other = array(
                'dist_code'=>$this->input->post('otherDistrict'),
                'subdiv_code'=>$this->input->post('otherSubdivision'),
                'cir_code'=>$this->input->post('otherCircle'),
                'mouza_pargona_code'=>$this->input->post('otherMouza'),
                'lot_no'=>$this->input->post('otherLot'),
                'vill_townprt_code'=>$this->input->post('otherVillage'),
                'case_no'=>$this->input->post('case_no'),
                'name'=>$this->input->post('otherAppName'),
                'guardian_name'=>$this->input->post('otherGuardianName'),
                'isOther'=>1,
                'appeals_id'=>$appeals_id
        );
        $this->db->insert('appeal_petitioner',$other);

        
        foreach ($_FILES as $value) {
            print_r($value);
            $name = date('Y-m-d').rand(10000,getrandmax());
            $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
            move_uploaded_file($value['tmp_name'], UPLOAD_BASE . $name.".$ext");
            $docs = array(
                'category_id'=>1,
                'path'=> UPLOAD_BASE . $name.".$ext",
                'case_no'=>$this->input->post('case_no'),
                'dist_code'=>$dist_code,
                'subdiv_code'=>$subdiv_code,
                'cir_code'=>$cir_code,
                'mouza_pargona_code'=>$mouza_pargona_code,
                'lot_no'=>$lot_no,
                'vill_townprt_code'=>$vill_townprt_code,
                'appeals_id'=>$appeals_id
            );
            $this->db->insert('appeal_docs',$docs);
        }

    }

}
