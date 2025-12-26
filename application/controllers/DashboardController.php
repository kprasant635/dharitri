<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
	    $this->load->helper('cookie');
        $this->load->helper('security');
		$this->load->helper('captcha');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('dashboard');
	
    }
	public function index()
	{
		
		
	}

	public function dashAll() {
        //$this->dbswitch();
       // var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        // $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        
        $data['all_field']=$this->dashboard->allMutationCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['pen_field']=$this->dashboard->penMutationCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['del_field']=$this->dashboard->delMutationCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);


        $data['o_mut']=$this->dashboard->ofcMutationCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);
        
        $data['field_mut']=$this->dashboard->fieldMutationCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);


        $data['o_part']=$this->dashboard->ofcPartitionCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['field_part']=$this->dashboard->fieldPartitionCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['conversion']=$this->dashboard->conversionCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['reclassification']=$this->dashboard->reclassificationCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['certificate']=$this->dashboard->certificateCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['apcases']=$this->dashboard->apcasesCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['acpp']=$this->dashboard->alotCertificateCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['settlement']=$this->dashboard->settlementCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);

        $data['misccases']=$this->dashboard->misccasesCircle($user_desig_code,$dist_code,$subdiv_code,$cir_code);
       

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        // if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
        //     $this->updatepasswordnow($user_code, $user_desig_code);
        // }
       // var_dump($data);
        // $this->load->view('header', $headtitle);
        // $this->load->view('dashboard/co', $data);
        // $this->load->view('footer');
        $data['_view'] = 'dashboard/dashall';
        $this->load->view('layouts/main',$data);
    }





public function dashAllDistrict() {
        //$this->dbswitch();
       // var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        // $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        
        $data['all_field']=$this->dashboard->allMutationDistrict($user_desig_code,$dist_code);

        $data['pen_field']=$this->dashboard->penMutationDistrict($user_desig_code,$dist_code);

        $data['del_field']=$this->dashboard->delMutationDistrict($user_desig_code,$dist_code);


        $data['o_mut']=$this->dashboard->ofcMutationDistrict($user_desig_code,$dist_code);
        
        $data['field_mut']=$this->dashboard->fieldMutationDistrict($user_desig_code,$dist_code);


        $data['o_part']=$this->dashboard->ofcPartitionDistrict($user_desig_code,$dist_code);

        $data['field_part']=$this->dashboard->fieldPartitionDistrict($user_desig_code,$dist_code);

        //$data['conversion']=$this->dashboard->conversionDistrict($user_desig_code,$dist_code);

        if($user_desig_code=='DC')
        {
             $data['conversion']=$this->dashboard->conversionDistrictDC($user_desig_code,$dist_code);
        }
        else {
           $data['conversion']=$this->dashboard->conversionDistrict($user_desig_code,$dist_code);
        }

        if($user_desig_code=='DC')
        {
             $data['reclassification']=$this->dashboard->reclassificationDistrictDC($user_desig_code,$dist_code);
        }
        else {
           $data['reclassification']=$this->dashboard->reclassificationDistrict($user_desig_code,$dist_code);
        }

         if($user_desig_code=='DC')
        {
             $data['apcases']=$this->dashboard->apcasesDistrictDC($user_desig_code,$dist_code);
        }
        else {
          $data['apcases']=$this->dashboard->apcasesDistrict($user_desig_code,$dist_code);
        }

        if($user_desig_code=='DC')
        {
             $data['acpp']=$this->dashboard->alotCertificateDistrictDC($user_desig_code,$dist_code);
        }
        else {
          $data['acpp']=$this->dashboard->alotCertificateDistrict($user_desig_code,$dist_code);
        }
        

        $data['certificate']=$this->dashboard->certificateDistrict($user_desig_code,$dist_code);

        // $data['apcases']=$this->dashboard->apcasesDistrict($user_desig_code,$dist_code);

        //$data['acpp']=$this->dashboard->alotCertificateDistrict($user_desig_code,$dist_code);

        $data['settlement']=$this->dashboard->settlementDistrict($user_desig_code,$dist_code);

        $data['misccases']=$this->dashboard->misccasesDistrict($user_desig_code,$dist_code);
       

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        // if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
        //     $this->updatepasswordnow($user_code, $user_desig_code);
        // }
       // var_dump($data);
        // $this->load->view('header', $headtitle);
        // $this->load->view('dashboard/co', $data);
        // $this->load->view('footer');
        $data['_view'] = 'dashboard/dashalldistrict';
        $this->load->view('layouts/main',$data);
    }

	
	function pending(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['type']='mutation';

		$data['mut']=$this->dashboard->allMutationuser_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmmut']=$this->dashboard->allMutationuser_lm($dist_code,$subdiv_code,$cir_code);
		$data['skmut']=$this->dashboard->allMutationuser_sk($dist_code,$subdiv_code,$cir_code);
		$data['astmut']=$this->dashboard->allMutationuser_ast($dist_code,$subdiv_code,$cir_code);

		$data['fmut']=$this->dashboard->allMutationuser_cowiseFM($dist_code,$subdiv_code,$cir_code);
		$data['omut']=$this->dashboard->allMutationuser_cowiseOM($dist_code,$subdiv_code,$cir_code);

		$data['lmfmut']=$this->dashboard->allMutationuser_lmwiseFM($dist_code,$subdiv_code,$cir_code);
		$data['lmomut']=$this->dashboard->allMutationuser_lmwiseOM($dist_code,$subdiv_code,$cir_code);

		$data['skfmut']=$this->dashboard->allMutationuser_skwiseFM($dist_code,$subdiv_code,$cir_code);
		$data['skomut']=$this->dashboard->allMutationuser_skwiseOM($dist_code,$subdiv_code,$cir_code);

		$data['astfmut']=$this->dashboard->allMutationuser_astwiseFM($dist_code,$subdiv_code,$cir_code);
		$data['astomut']=$this->dashboard->allMutationuser_astwiseOM($dist_code,$subdiv_code,$cir_code);




		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}

	function pendingDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['mut']=$this->dashboard->allMutationuser_dc($dist_code);
		$data['lmmut']=$this->dashboard->allMutationuser_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allMutationuser_skdc($dist_code);
		$data['astmut']=$this->dashboard->allMutationuser_astdc($dist_code);
		$data['dcmut']=0;
		$data['adcmut']=0;


		$data['fmut']=$this->dashboard->allMutationuser_coFM($dist_code);
		$data['omut']=$this->dashboard->allMutationuser_coOM($dist_code);

		$data['lmfmut']=$this->dashboard->allMutationuser_lmFM($dist_code);
		$data['lmomut']=$this->dashboard->allMutationuser_lmOM($dist_code);

		$data['skfmut']=$this->dashboard->allMutationuser_skFM($dist_code);
		$data['skomut']=$this->dashboard->allMutationuser_skOM($dist_code);

		$data['astfmut']=$this->dashboard->allMutationuser_astFM($dist_code);
		$data['astomut']=$this->dashboard->allMutationuser_astOM($dist_code);
		

		$data['type']='mutation';



		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}


	function pendingPart(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['type']='partition';

		$data['part']=$this->dashboard->allPartitionuser_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmpart']=$this->dashboard->allPartitionuser_lm($dist_code,$subdiv_code,$cir_code);
		$data['skpart']=$this->dashboard->allPartitionuser_sk($dist_code,$subdiv_code,$cir_code);
		$data['astpart']=$this->dashboard->allPartitionuser_ast($dist_code,$subdiv_code,$cir_code);

		$data['fmut']=$this->dashboard->allPartitionuser_cowiseFP($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['omut']=$this->dashboard->allPartitionuser_cowiseOP($user_desig_code,$dist_code,$subdiv_code,$cir_code);

		$data['lmfmut']=$this->dashboard->allPartitionuser_lmwiseFP($dist_code,$subdiv_code,$cir_code);
		$data['lmomut']=$this->dashboard->allPartitionuser_lmwiseOP($dist_code,$subdiv_code,$cir_code);

		$data['skfmut']=$this->dashboard->allPartitionuser_skwiseFP($dist_code,$subdiv_code,$cir_code);
		$data['skomut']=$this->dashboard->allPartitionuser_skwiseOP($dist_code,$subdiv_code,$cir_code);

		$data['astfmut']=$this->dashboard->allPartitionuser_astwiseFP($dist_code,$subdiv_code,$cir_code);
		$data['astomut']=$this->dashboard->allPartitionuser_astwiseOP($dist_code,$subdiv_code,$cir_code);



		
		$data['_view'] = 'dashboard/penpartition';
		$this->load->view('layouts/main',$data);

	}

		function pendingPartDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['mut']=$this->dashboard->allPartitionuser_dc($dist_code);
		$data['lmmut']=$this->dashboard->allPartitionuser_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allPartitionuser_skdc($dist_code);
		$data['astmut']=$this->dashboard->allPartitionuser_astdc($dist_code);
		$data['dcmut']=0;
		$data['adcmut']=0;

		$data['type']='partition';


		$data['fmut']=$this->dashboard->allPartitionuser_coFP($dist_code);
		$data['omut']=$this->dashboard->allPartitionuser_coOP($dist_code);

		$data['lmfmut']=$this->dashboard->allPartitionuser_lmFP($dist_code);
		$data['lmomut']=$this->dashboard->allPartitionuser_lmOP($dist_code);

		$data['skfmut']=$this->dashboard->allPartitionuser_skFP($dist_code);
		$data['skomut']=$this->dashboard->allPartitionuser_skOP($dist_code);

		$data['astfmut']=$this->dashboard->allPartitionuser_astFP($dist_code);
		$data['astomut']=$this->dashboard->allPartitionuser_astOP($dist_code);
		


		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}

	function pendingConvDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['mut']=$this->dashboard->allConversion_dc($dist_code);
		$data['lmmut']=$this->dashboard->allConversion_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allConversion_skdc($dist_code);
		$data['astmut']=$this->dashboard->allConversion_astdc($dist_code);
		$data['dcmut']=$this->dashboard->allConversion_dcp($dist_code);;
		$data['adcmut']=$this->dashboard->allConversion_adcpen($dist_code);;

		$data['type']='conversion';


		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}


	function pendingConv(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['conv']=$this->dashboard->allConversion_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmconv']=$this->dashboard->allConversion_lm($dist_code,$subdiv_code,$cir_code);
		$data['skconv']=$this->dashboard->allConversion_sk($dist_code,$subdiv_code,$cir_code);
		$data['astconv']=$this->dashboard->allConversion_ast($dist_code,$subdiv_code,$cir_code);



		
		$data['_view'] = 'dashboard/penconv';
		$this->load->view('layouts/main',$data);

	}


function pendingReclass(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['recl']=$this->dashboard->allReclass_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmrecl']=$this->dashboard->allReclass_lm($dist_code,$subdiv_code,$cir_code);
		$data['skrecl']=$this->dashboard->allReclass_sk($dist_code,$subdiv_code,$cir_code);
		$data['astrecl']=$this->dashboard->allReclass_ast($dist_code,$subdiv_code,$cir_code);

		$data['dcrecl']=$this->dashboard->allReclass_dc($dist_code,$subdiv_code,$cir_code);

		
		$data['_view'] = 'dashboard/penrecl';
		$this->load->view('layouts/main',$data);

	}


function pendingReclassDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['dcrecl']=$this->dashboard->allReclass_dc($dist_code,$subdiv_code,$cir_code);


		$data['mut']=$this->dashboard->allReclass_district($dist_code);
		$data['lmmut']=$this->dashboard->allReclass_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allReclass_skdc($dist_code);
		$data['astmut']=$this->dashboard->allReclass_astdc($dist_code);
		$data['dcmut']=$this->dashboard->allReclass_dcp($dist_code);
		$data['adcmut']=$this->dashboard->allReclass_adcpending($dist_code);

		$data['type']='reclassification';


		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}

	function pendingCitizen(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['citizen']=$this->dashboard->allCitizen_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmctzn']=$this->dashboard->allCitizen_lm($dist_code,$subdiv_code,$cir_code);
		$data['skctzn']=$this->dashboard->allCitizen_sk($dist_code,$subdiv_code,$cir_code);
		$data['astctzn']=$this->dashboard->allCitizen_ast($dist_code,$subdiv_code,$cir_code);

		

		
		$data['_view'] = 'dashboard/pencitizen';
		$this->load->view('layouts/main',$data);

	}

	function pendingCitizenDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['dcrecl']=$this->dashboard->allReclass_dc($dist_code,$subdiv_code,$cir_code);


		$data['mut']=$this->dashboard->allCitizen_codc($dist_code);
		$data['lmmut']=$this->dashboard->allCitizen_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allCitizen_skdc($dist_code);
		$data['astmut']=$this->dashboard->allCitizen_astdc($dist_code);

		$data['dcmut']=0;
		$data['adcmut']=0;
	
		$data['type']='citizen certificate';


		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}

	function pendingApcancel(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['citizen']=$this->dashboard->allApcancel_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmctzn']=$this->dashboard->allApcancel_lm($dist_code,$subdiv_code,$cir_code);
		$data['skctzn']=$this->dashboard->allApcancel_sk($dist_code,$subdiv_code,$cir_code);
		$data['astctzn']=$this->dashboard->allApcancel_ast($dist_code,$subdiv_code,$cir_code);

		

		
		$data['_view'] = 'dashboard/penapcancel';
		$this->load->view('layouts/main',$data);

	}

	function pendingApcancelDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		
        $data['mut']=$this->dashboard->allApcancel_codc($dist_code);
		$data['lmmut']=$this->dashboard->allApcancel_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allApcancel_skdc($dist_code);
		$data['astmut']=$this->dashboard->allApcancel_astdc($dist_code);
		$data['dcmut']=$this->dashboard->allApcancel_dcp($dist_code);
		$data['adcmut']=$this->dashboard->allApcancel_adcpen($dist_code);

		$data['type']='AP cancellation';

		

		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}

	function pendingAcPp(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['citizen']=$this->dashboard->allAcpp_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmctzn']=$this->dashboard->allAcPp_lm($dist_code,$subdiv_code,$cir_code);
		$data['skctzn']=$this->dashboard->allAcPp_sk($dist_code,$subdiv_code,$cir_code);
		$data['astctzn']=$this->dashboard->allAcPp_ast($dist_code,$subdiv_code,$cir_code);


		

		
		$data['_view'] = 'dashboard/penacpp';
		$this->load->view('layouts/main',$data);

	}

	function pendingAcPpDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		
        $data['mut']=$this->dashboard->allAcpp_codc($dist_code);
		$data['lmmut']=$this->dashboard->allAcPp_lmdc($dist_code);
		$data['skmut']=$this->dashboard->allAcPp_skdc($dist_code);
		$data['astmut']=$this->dashboard->allAcPp_astdc($dist_code);
		$data['dcmut']=$this->dashboard->allAcPp_dcp($dist_code);
		$data['adcmut']=$this->dashboard->allAcPp_adcpen($dist_code);

		$data['type']='Allotment';

		

		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}

	function pendingSettle(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['citizen']=$this->dashboard->settle_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmctzn']=$this->dashboard->settle_lm($dist_code,$subdiv_code,$cir_code);
		$data['skctzn']=$this->dashboard->settle_sk($dist_code,$subdiv_code,$cir_code);
		$data['astctzn']=$this->dashboard->settle_ast($dist_code,$subdiv_code,$cir_code);

		

		
		$data['_view'] = 'dashboard/pensettle';
		$this->load->view('layouts/main',$data);

	}

	function pendingSettleDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['mut']=$this->dashboard->settle_codc($dist_code);
		$data['lmmut']=$this->dashboard->settle_lmdc($dist_code);
		$data['skmut']=$this->dashboard->settle_skdc($dist_code);
		$data['astmut']=$this->dashboard->settle_astdc($dist_code);
		$data['dcmut']=0;
		$data['adcmut']=0;

		$data['type']='settlement';

		

		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}



	function pendingMisc(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['citizen']=$this->dashboard->misc_co($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['lmctzn']=$this->dashboard->misc_lm($dist_code,$subdiv_code,$cir_code);
		$data['skctzn']=$this->dashboard->misc_sk($dist_code,$subdiv_code,$cir_code);
		$data['astctzn']=$this->dashboard->misc_ast($dist_code,$subdiv_code,$cir_code);

		

		
		$data['_view'] = 'dashboard/penmisc';
		$this->load->view('layouts/main',$data);

	}




function pendingMiscDistrict(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['mut']=$this->dashboard->misc_codc($dist_code);
		$data['lmmut']=$this->dashboard->misc_lmdc($dist_code);
		$data['skmut']=$this->dashboard->misc_skdc($dist_code);
		$data['astmut']=$this->dashboard->misc_astdc($dist_code);
		$data['dcmut']=0;
		$data['adcmut']=0;

		$data['type']='misccases';

		

		
		$data['_view'] = 'dashboard/penmutation';
		$this->load->view('layouts/main',$data);

	}




	function pendingLM(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOom(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOom($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOfm(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOfm($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOfp(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOfp($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOop(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOop($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

		function pendingCOconv(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOconv($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOreclass(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOreclass($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOcert(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOcert($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}


	function pendingCOapcancel(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOapcancel($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOalot(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOalot($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOsettle(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOsettle($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}

	function pendingCOmisc(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allMutationCOmisc($dist_code);


			
		$data['_view'] = 'dashboard/penco';
		$this->load->view('layouts/main',$data);

	}



	function pendingLMPart(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';



		$data['citizen']=$this->dashboard->allPartitionLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}


	

	function pendingLMCR(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

  

		$data['citizen']=$this->dashboard->allCitizenLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}


	function pendingLMApcancel(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

  

		$data['citizen']=$this->dashboard->allApcancelLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}

	function pendingLMAcpp(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

  

		$data['citizen']=$this->dashboard->allAcppLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}

function pendingLMSettle(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

  

		$data['citizen']=$this->dashboard->allSettleLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}


function pendingLMConv(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

  

		$data['citizen']=$this->dashboard->allConvLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}

	function pendingReclassLM(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

		$data['citizen']=$this->dashboard->allReclassLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}




function pendingLMmisc(){
		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

  

		$data['citizen']=$this->dashboard->allMiscLM($user_desig_code,$dist_code,$subdiv_code,$cir_code);


			
		$data['_view'] = 'dashboard/penlm';
		$this->load->view('layouts/main',$data);

	}



	function applicationTime(){

		$user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
       
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';
		$data['citizen']=$this->dashboard->applTime($user_desig_code,$dist_code,$subdiv_code,$cir_code);
		$data['_view'] = 'dashboard/applicationtime';
		$this->load->view('layouts/main',$data);



	}


	
	

}
