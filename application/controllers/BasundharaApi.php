<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BasundharaApi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url','security'));
		// $this->db = $this->load->database('db2',TRUE);
		// $this->dbb = $this->load->database('auth', true);
	}

	

	public function getRtpsData()
	{
    $dist_code = $this->session->userdata('dist_code');
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsDataDc/'.$dist_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=hpkd2bf01mng81usjtblj35a9tdp8q50'

		  ),
		));

		$data = curl_exec($curl);
        $data = json_decode($data, true);
		$data['_view'] = 'service_dashboard/service_view';
		$this->load->view('layouts/main', $data);

	}
	
	public function getRtpsAjax(){
		//$district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
		$service_code = $_GET["service_code"];
    $dist_code = $this->session->userdata('dist_code');

		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsAjaxDc/'.$service_code.'/'.$dist_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=22agrv6q3o784onhg0krfhp607k61igf'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		return;
		
	}
	public function getRtpsCircleAjax() {
		$district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
		$service_code = isset($_GET["service_code"]) ? $_GET["service_code"] : "";
		if ($district_code == "" || $service_code == "") {
			echo json_encode([]);
			return;
		}
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsCircleAjax/'.$service_code.'/'.$district_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=65ovpsglv4hkerq4potdh815sjq37i2j'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		//echo json_encode($data, true);


		return;

	}
	public function getRtpsLotData(){
		//var_dump($_GET);
        $service_code = isset($_GET["service_code"]) ? $_GET["service_code"] : "";
        $district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
        $subdiv_code = isset($_GET["subdiv_code"]) ? $_GET["subdiv_code"] : "";
		$circle_code = isset($_GET["circle_code"]) ? $_GET["circle_code"] : "";
		if ($district_code == "" || $service_code == ""|| $circle_code == "") {
			echo json_encode([]);
			return;
		}
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsLotData/'.$service_code.'/'.$district_code.'/'.$subdiv_code.'/'.$circle_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=gg8apm46bughqgj8kn0riio7n656gi51'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		return;
	}

	public function getRtpsVillageData(){
		// var_dump($_GET);
        $service_code = isset($_GET["service_code"]) ? $_GET["service_code"] : "";
        $district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
        $subdiv_code = isset($_GET["subdiv_code"]) ? $_GET["subdiv_code"] : "";
		$circle_code = isset($_GET["circle_code"]) ? $_GET["circle_code"] : "";
		$mouza_code = isset($_GET["mouza_code"]) ? $_GET["mouza_code"] : "";
		$lat_code = isset($_GET["lat_code"]) ? $_GET["lat_code"] : "";
		if ($district_code == "" || $service_code == ""|| $circle_code == ""|| $mouza_code == ""|| $lat_code == "") {
			echo json_encode([]);
			return;
		}
		 $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsVillageData/'.$service_code.'/'.$district_code.'/'.$subdiv_code.'/'.$circle_code.'/'.$mouza_code.'/'.$lat_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=j8p4te0it7ns4ahvra7poth5s5dij3d8'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		return;
		
	}
  public function getApplicationDetailsByVillageMbTwo() 
  {
    $scode      = $this->input->post('scode');
    $dist       = $this->input->post('dist');
    $sub        = $this->input->post('sub');
    $cir        = $this->input->post('cir');
    $mouza      = $this->input->post('mouza');
    $lot        = $this->input->post('lot');
    $vill       = $this->input->post('vill');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsApplicationDetailVillageWiseMbTwo',
      
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'scode'      => $scode,
        'dist'       => $dist,
        'sub'        => $sub,
        'cir'        => $cir,
        'mouza'      => $mouza,
        'lot'        => $lot,
        'vill'       => $vill,
      ),
      CURLOPT_HTTPHEADER => array(
        'Cookie: ci_session=j9io4b9vkiu4h7ps78o9b68umm0n9iot'
      ),
    ));
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($httpcode != 200) {
      $data = [
        'status'   => 1,
        'msg'      => "Something went wrong on getting data. Kindly contact system administrator !!",
      ];
    }
    echo $response;
    return;
  }

  public function getRtpsApplicationDetails() 
  {
    $appl_no = $this->input->post('appl_no');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getAppDetails',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'application_no' => $appl_no,
        'api_key'        => API_KEY,
        'token'          => $this->utilityclass->createTokenJwt(),
      ),
      CURLOPT_HTTPHEADER => array(
        'Cookie: ci_session=j9io4b9vkiu4h7ps78o9b68umm0n9iot'
      ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($httpcode != 200) {
      $data = [
        'status'   => 1,
        'msg'      => "Something went wrong on getting data. Kindly contact system administrator !!",
      ];
    }
    echo $response;
    return;
  }



  public function loadViewPage() {
    $data['_view'] = 'service_dashboard/application_details';
    $this->load->view('layouts/main', $data);
  }


  public function getApplicationDetailsAppliedByApplicants() {

    $checkStatus = $this->input->post('checkstatus');    
    $draw        = $this->input->post('draw');
    $start       = $this->input->post('start');
    $length      = $this->input->post('length');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getTotalApplicationsAppliedByApplicants',
      
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING       => '',
      CURLOPT_MAXREDIRS      => 10,
      CURLOPT_TIMEOUT        => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST  => 'POST',
      CURLOPT_POSTFIELDS     => array(
        'checkStatus' => $checkStatus,
        'start'       => $start,
        'length'      => $length,
      ),
    ));

    $data = curl_exec($curl);
    $data = json_decode($data, true);
    curl_close($curl);

    $i = 1;

    foreach($data['result'] as $row)
    {
      $appl_no = $row['application_no'];

      /*$dist  = $this->utilityclass->dist_name($row['dist_code']);
      $sub   = $this->utilityclass->subdiv_name($row['dist_code'],$row['subdiv_code']);
      $cir   = $this->utilityclass->cir_name($row['dist_code'],$row['subdiv_code'],$row['cir_code']);
      $mouza = $this->utilityclass->mouza_name($row['dist_code'],$row['subdiv_code'],$row['cir_code'],$row['mouza_code']);
      $lot   = $this->utilityclass->lot_name($row['dist_code'],$row['subdiv_code'],$row['cir_code'],$row['mouza_code'],$row['lot_no']);
      $vill  = $this->utilityclass->village_name($row['dist_code'],$row['subdiv_code'],$row['cir_code'],$row['mouza_code'],$row['lot_no'],$row['village_code']);

      $location = $dist.' / '.$sub.' / '.$cir.' / '.$mouza.' / '.$lot.' / '.$vill;
      */
      $json[] = array(
        '<span class="px-3"><strong>' . $i . '</strong></span>',

        $appl_no,

        //$location,

        $this->utilclass->getServiceName($row['service_code']),

        date('d/m/Y', strtotime($row['date_submission'])),

        '<button class="btn btn-sm btn-warning" onclick="viewAppl('."'".$appl_no."'".')" type="button">View Detail</button>'
      );
      $i++;
    }

    $response = array(
      'draw'            => $draw,
      'data'            => $json,
      'recordsTotal'    => $data['total_rec'],
      'recordsFiltered' => $data['total_rec'],
    );
    echo json_encode($response);
    return;
  }

  public function getRtpsDataReview()
	{
    $dist_code = $this->session->userdata('dist_code');
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsDataDcReview/'.$dist_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=hpkd2bf01mng81usjtblj35a9tdp8q50'

		  ),
		));

		$data = curl_exec($curl);
        $data = json_decode($data, true);
		$data['_view'] = 'service_dashboard/service_view_review';
		$this->load->view('layouts/main', $data);

	}

  public function getRtpsAjaxReview(){
		//$district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
		$service_code = $_GET["service_code"];
    $dist_code = $this->session->userdata('dist_code');

		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsAjaxDcReview/'.$service_code.'/'.$dist_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=22agrv6q3o784onhg0krfhp607k61igf'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		return;
		
	}

  public function loadViewPageReview() {
    $data['_view'] = 'service_dashboard/application_details_review';
    $this->load->view('layouts/main', $data);
  }

  public function getApplicationDetailsAppliedByApplicantsReview() {

    $checkStatus = $this->input->post('checkstatus');    
    $draw        = $this->input->post('draw');
    $start       = $this->input->post('start');
    $length      = $this->input->post('length');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getTotalApplicationsAppliedByApplicantsReview',
      
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING       => '',
      CURLOPT_MAXREDIRS      => 10,
      CURLOPT_TIMEOUT        => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST  => 'POST',
      CURLOPT_POSTFIELDS     => array(
        'checkStatus' => $checkStatus,
        'start'       => $start,
        'length'      => $length,
      ),
    ));

    $data = curl_exec($curl);
    $data = json_decode($data, true);
    curl_close($curl);

    $i = 1;

    foreach($data['result'] as $row)
    {
      $appl_no = $row['application_no'];
      $json[] = array(
        '<span class="px-3"><strong>' . $i . '</strong></span>',

        $appl_no,

        //$location,

        $this->utilclass->getServiceName($row['service_code']),

        date('d/m/Y', strtotime($row['date_submission'])),

        '<button class="btn btn-sm btn-warning" onclick="viewAppl('."'".$appl_no."'".')" type="button">View Detail</button>'
      );
      $i++;
    }

    $response = array(
      'draw'            => $draw,
      'data'            => $json,
      'recordsTotal'    => $data['total_rec'],
      'recordsFiltered' => $data['total_rec'],
    );
    echo json_encode($response);
    return;
  }

  public function getRtpsApplicationDetailsReview() 
  {
    $appl_no = $this->input->post('appl_no');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getAppDetails',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'application_no' => $appl_no,
        'api_key'        => API_KEY,
        'token'          => $this->utilityclass->createTokenJwt(),
      ),
      CURLOPT_HTTPHEADER => array(
        'Cookie: ci_session=j9io4b9vkiu4h7ps78o9b68umm0n9iot'
      ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($httpcode != 200) {
      $data = [
        'status'   => 1,
        'msg'      => "Something went wrong on getting data. Kindly contact system administrator !!",
      ];
    }
    echo $response;
    return;
  }

  public function getRtpsCircleAjaxReview() {
		$district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
		$service_code = isset($_GET["service_code"]) ? $_GET["service_code"] : "";
		if ($district_code == "" || $service_code == "") {
			echo json_encode([]);
			return;
		}
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsCircleAjaxReview/'.$service_code.'/'.$district_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=65ovpsglv4hkerq4potdh815sjq37i2j'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		//echo json_encode($data, true);


		return;

	}

  public function getRtpsLotDataReview(){
		//var_dump($_GET);
        $service_code = isset($_GET["service_code"]) ? $_GET["service_code"] : "";
        $district_code = isset($_GET["district_code"]) ? $_GET["district_code"] : "";
        $subdiv_code = isset($_GET["subdiv_code"]) ? $_GET["subdiv_code"] : "";
		$circle_code = isset($_GET["circle_code"]) ? $_GET["circle_code"] : "";
		if ($district_code == "" || $service_code == ""|| $circle_code == "") {
			echo json_encode([]);
			return;
		}
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsLotDataReview/'.$service_code.'/'.$district_code.'/'.$subdiv_code.'/'.$circle_code,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ci_session=gg8apm46bughqgj8kn0riio7n656gi51'
		  ),
		));

		$data = curl_exec($curl);
		echo json_encode(array('data'=>$data));
		return;
	}

  public function getApplicationDetailsByVillageMbTwoReview() 
  {
    $scode      = $this->input->post('scode');
    $dist       = $this->input->post('dist');
    $sub        = $this->input->post('sub');
    $cir        = $this->input->post('cir');
    $mouza      = $this->input->post('mouza');
    $lot        = $this->input->post('lot');
    $vill       = $this->input->post('vill');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASUNDHARA_PRODUCTION_API.'getRtpsApplicationDetailVillageWiseMbTwoReview',
      
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'scode'      => $scode,
        'dist'       => $dist,
        'sub'        => $sub,
        'cir'        => $cir,
        'mouza'      => $mouza,
        'lot'        => $lot,
        'vill'       => $vill,
      ),
      CURLOPT_HTTPHEADER => array(
        'Cookie: ci_session=j9io4b9vkiu4h7ps78o9b68umm0n9iot'
      ),
    ));
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($httpcode != 200) {
      $data = [
        'status'   => 1,
        'msg'      => "Something went wrong on getting data. Kindly contact system administrator !!",
      ];
    }
    echo $response;
    return;
  }

}
?>
