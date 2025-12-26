<?php 

class SmsApiController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    function sendOTP(){
        $mobile_no = $this->input->post('mobile_no');
        $random_no = random_int(100000, 999999);
        $this->session->set_userdata('session_otp', $random_no);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => SMS_PROD_LINK,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
                "key"       : "login_otp",
                "variables" : "'.$random_no.'",
                "mobilenos" : "'.$mobile_no.'" 
            }',
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        return;
    }

    public function sendOTPDemo()
    {
        $otp = '123456';
        $this->session->set_userdata('session_otp', $otp);
        echo json_encode(array('responseType' => 1,'code' => '402'));
        return;
    }

    public function verifyOTP()
    {
        $respose = array('responseType' => 1 ,'msg' => 'OTP verification failed');
        $otp = $this->input->post('otp');
        $session_otp = $this->session->userdata('session_otp');
        if($otp == $session_otp){
          $respose['responseType'] = 2;
          $respose['msg'] = 'OTP has been successfully verified';
        }
        echo json_encode($respose);
        return;
     }

}