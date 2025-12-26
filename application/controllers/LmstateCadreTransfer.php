<?php
class LmstateCadreTransfer extends CI_Controller{
	public function __construct() {
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('file');
            $this->load->helper('download');
            $this->load->library('upload');
    }
    function applyTransfer(){
    	echo 'Apply time is over.';
    	return;
    	$this->form_validation->set_rules('full_name','Name Required','required');
		$this->form_validation->set_rules('mobile','Mobile Number','required|integer|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('pan_no','Pan No','required|max_length[10]|min_length[10]');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('doa','Appoitment Date','required');
		$this->form_validation->set_rules('dos','Superannuation Date','required');
		$this->form_validation->set_rules('pp_dist','District Name','required');
		$this->form_validation->set_rules('pp_circle','Circle Name','required');
		$this->form_validation->set_rules('p_address','Address','required');
		$this->form_validation->set_rules('prefernece_1','prefernece_1','required');
		$this->form_validation->set_rules('prefernece_2','prefernece_2','required');
		$this->form_validation->set_rules('prefernece_3','prefernece_3','required');
		// $this->form_validation->set_rules('appointment_copy','Appoitment Order Copy','required');

    	$params = [
          'select_cadre'=> $this->input->post('select_cadre'),
          'full_name'=> $this->input->post('full_name'),
          'mobile'=> $this->input->post('mobile'),
          'pan_no'=> $this->input->post('pan_no'),
          'email'=> $this->input->post('email'),
          'doa'=> date('Y-m-d',strtotime($this->input->post('doa'))),
          'dos'=> date('Y-m-d',strtotime($this->input->post('dos'))),
          'pp_dist'=> $this->input->post('pp_dist'),
          'pp_circle'=> $this->input->post('pp_circle'),
          'p_address'=> $this->input->post('p_address'),
          'prefernece_1'=> $this->input->post('prefernece_1'),
          'prefernece_2'=> $this->input->post('prefernece_2'),
          'prefernece_3'=> $this->input->post('prefernece_3'),
          'dist_code'=> $this->input->post('dist_code'),
          'user_code'=> $this->input->post('user_code'),
          // 'appointment_copy'=> $this->input->post('appointment_copy'),
          'date_entry'=> date('Y-m-d'),
        ];
        // var_dump($_POST);
        // var_dump($_FILES['appointment_copy']['name']);
        // var_dump($_FILES['appointment_copy']['tmp_name']);
        // die;
        $this->load->library('form_validation');
        if (!empty($_FILES['appointment_copy']['name']))
	    { 
          $filename =$_FILES['appointment_copy']['name'];
          $config['allowed_types']='pdf|PDF';
          $config['max_length']='3603630';
          $this->upload->initialize($config);
          $size = intval($_FILES['appointment_copy']['size']);
	      $fext = explode(".", $filename);
	      $mime = $_FILES['appointment_copy']['type'];
	      $tname = $_FILES['appointment_copy']['tmp_name'];
	      if ($size > 5000000) {
	          $error =$this->upload->display_errors();
              $msg='File Can not Upload ..Please upload PDF  type only and Maximum file size 5MB '.$error;
              $this->form_validation->set_rules('appointment_copy',$msg,'required');
	      }
        }
        if(($this->input->post('prefernece_1')==$this->input->post('prefernece_2')) || ($this->input->post('prefernece_1')==$this->input->post('prefernece_3')) || $this->input->post('prefernece_2')==$this->input->post('prefernece_3') ) 
        {
        	$msg='Same Prefernece Given. You are not allowed to choose same prefernece twice';
              $this->form_validation->set_rules('prefernece_1',$msg,'required');
        }
        if($this->form_validation->run()===TRUE)  
        {  
        	$this->dbb=$this->load->database('auth',true);
        	if ($fext[1] == "pdf") {
                $fdata = file_get_contents($_FILES['appointment_copy']['tmp_name']);
                $escaped = pg_escape_bytea($fdata);
                $mime = $_FILES['appointment_copy']['type'];
	        }
        	$ackno = $this->dbb->query("select nextval('lm_sk_cadre_apply_tid_seq') as count ")->row()->count;
        	$params['ack_no']=$ackno;
        	$params['date_entry']=date('Y-m-d');
        	$params['dist_code']=$this->session->userdata('dist_code');
        	$params['user_code']=$this->session->userdata('user_code');
        	$params['appointment_copy']=$escaped;
        	
        	$this->dbb->trans_begin();
        	$this->db->trans_begin();
        	$this->dbb->insert('lm_sk_cadre_apply',$params);
        	// echo $this->dbb->last_query();
        	// die;
        	$llid=$this->dbb->insert_id();
        	if($this->dbb->affected_rows()==1){
        		$users=[
	        		'dist_code'=>$this->session->userdata('dist_code'),
	        		'subdiv_code'=>$this->session->userdata('subdiv_code'),
	        		'cir_code'=>$this->session->userdata('cir_code'),
	        		'mouza_pargona_code'=>$this->session->userdata('mouza_pargona_code'),
	        		'lot_no'=>$this->session->userdata('lot_no'),
	        		'user_code'=>$this->session->userdata('user_code'),
	        		'ack_no'=>$ackno,
	        		'date_entry'=>date('Y-m-d'),
        		];
        		$this->db->insert('lm_sk_cadre_apply_hist',$users);
        		// echo $this->db->last_query();
        	}
        	if($this->dbb->affected_rows()==1 && $this->db->affected_rows()==1){
        		$this->db->trans_commit();
        		$this->dbb->trans_commit();
        		redirect('LmstateCadreTransfer/downloadAcknowledgement/'.$llid);
        	}else{
        		log_message('error','INSIDEDB'.$this->db->last_query());
        		log_message('error','AUTHDB'.$this->dbb->last_query());
        		$this->db->trans_rollback();
        		$this->dbb->trans_rollback();
        		redirect('LmstateCadreTransfer/applyTransfer');
        	}
        }
        else
        {
        	$user_desig_code = $this->session->userdata('user_desig_code');
	        $dist_code = $this->session->userdata('dist_code');
	        $subdiv_code = $this->session->userdata('subdiv_code');
	        $cir_code = $this->session->userdata('cir_code');
	        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
	        $lot_no = $this->session->userdata('lot_no');
	        $user_code = $this->session->userdata('user_code');
        	$sql="Select * from lm_sk_cadre_apply_hist where dist_code=? and subdiv_code=? and cir_code=?
        	and mouza_pargona_code=? and lot_no=? and user_code=?";
        	$data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code));
        	if($data->num_rows()==0){
        		$district['_view'] = 'lmtransfer/register';
        		$this->load->view('layouts/main',$district);
        	}else{
        		$ackno=$data->row();
        		$this->dbb=$this->load->database('auth',true);
        		$sql1="Select * from lm_sk_cadre_apply where ack_no=?";
        		$district['result']=$this->dbb->query($sql1,$ackno->ack_no)->row_array();
        		$district['_view'] = 'lmtransfer/registerddata';
        		$this->load->view('layouts/main',$district);
        	}
            
        }
    	
    }
    function checkPan(){
    	$pan=$this->input->post('pan');
    	$this->dbb=$this->load->database('auth',TRUE);
    	$sql="Select pan_no from lm_sk_cadre_apply where pan_no=?";
    	$data=$this->dbb->query($sql,$pan);
    	//log_message('error',$this->dbb->last_query());
    	echo json_encode(
    		array(
    			'response'=>1,
    			'data'=>$data->num_rows(),
    		)
    	);
    	return;
    }
    function checkMobile(){
    	$mobile=$this->input->post('mobile');
    	$this->dbb=$this->load->database('auth',TRUE);
    	$sql="Select mobile from lm_sk_cadre_apply where mobile=?";
    	$data=$this->dbb->query($sql,$mobile);
    	//log_message('error',$this->dbb->last_query());
    	echo json_encode(
    		array(
    			'response'=>1,
    			'data'=>$data->num_rows(),
    		)
    	);
    	return;
    }
    function downloadAppointment($id){
    	$this->dbb=$this->load->database('auth',true);
    	$sql="Select appointment_copy from lm_sk_cadre_apply where tid=?";
    	$data=$this->dbb->query($sql,array($id));
    	if($data->num_rows()==0){
    		echo json_encode(array('Error Found ! No Data Found'));
    		return;
    	}
    	$appointment_copy=$data->row()->appointment_copy;
    	//$output=base64_decode($output);
        header('Content-type: application/pdf');
        echo pg_unescape_bytea($appointment_copy);
    }
    function downloadAcknowledgement($id){
    	$dist_code=$this->session->userdata('dist_code');
    	$user_code=$this->session->userdata('user_code');
    	$this->dbb=$this->load->database('auth',true);
    	$sql="Select * from lm_sk_cadre_apply where tid=? and dist_code=? and user_code=?";
    	$data=$this->dbb->query($sql,array($id,$dist_code,$user_code));
    	if($data->num_rows()==0){
    		echo json_encode(array('Error Found ! No Data Found'));
    		return;
    	}
    	$result=$data->row();
    	// ob_start();
    	include 'vendor\mpdf\vendor\autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkText('DHARITREE');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        // $mpdf->alpha = 0.1;
        $mpdf->autoLangToFont = true;
        $html=null;
	    $html .='<h3 style="text-align: center"><u>APPLICATION INFORMATION</u></h3>';
	    $html .='<p>ACKNOWLEDGEMENT No. :'.$result->ack_no.'</p>';
	    $table='<table style="margin-top:100px">
	    	<tr>
	    		<td>Full Name of applicant	:</td>
	    		<td>'.$result->full_name.'</td>
	    	</tr>
	    	<tr>
	    		<td>District	:</td>
	    		<td>'.$result->pp_dist.'</td>
	    	</tr>
	    	<tr>
	    		<td>Circle	:</td>
	    		<td>'.$result->pp_circle.'</td>
	    	</tr>
	    	<tr>
	    		<td>Permanent Address	:</td>
	    		<td>'.$result->p_address.'</td>
	    	</tr>
	    	<tr>
	    		<td>Mobile No.	:</td>mobile
	    		<td>'.$result->mobile.'</td>
	    	</tr>
	    	<tr>
	    		<td>e-mail id	:</td>
	    		<td>'.$result->email.'</td>
	    	</tr>
	    	<tr>
	    		<td>PAN No.	:</td>
	    		<td>'.$result->pan_no.'
	    	<tr>
	    		<td colspan=1>Choice of District for transfer:</td>
	    	</tr>
	    	<tr>
	    		<td>Preference 1	:</td>
	    		<td>'.$result->prefernece_1.'</td>
	    	</tr>
	    	<tr>
	    		<td>Preference 2	:</td>
	    		<td>'.$result->prefernece_2.'</td>
	    	</tr>
	    	<tr>
	    		<td>Preference 3	:</td>
	    		<td>'.$result->prefernece_3.'</td>
	    	</tr>
	    </table>';

	    echo $html.=$table;
	    echo $html.='<p style="margin-top:50px">Acknowledgement		:	Your application with acknowledgment No. '.$result->ack_no.' has been successfully received.</p>';
	    echo $html.='<div style="margin-top:50px;margin-left:330px"><p style="text-align: center">Regards <br><br>
							                  Sd/- <br>
						Director of Land Records & Surveys etc., Assam<br>
							   Rupnagar, Guwahati-32 </p></div>';
	    // $html.=base64_decode($jsonobj->htmlString);	
	    $mpdf->writeHTML($html);
	    ob_end_clean();
	    echo $b64Doc = chunk_split(base64_encode($mpdf->Output('test.pdf','I')));
    }
}
