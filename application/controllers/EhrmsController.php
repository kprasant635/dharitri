<?php

class EhrmsController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }


    public function CreateUserIndex(){
        $data['_view'] = 'Ehrms/create_user';
        $this->load->view('layouts/main',$data);
    }

    public function saveUser(){
        $name = $this->input->post('name');
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');

        $dist_code = $this->session->userdata('dist_code'); 
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code'); 

        if(empty($name) || empty($user_name) || empty($password)){
            echo json_encode([
                'responseType' => 0,
                'msg'   => '#ERR23: Please enter all the details...'
            ]);
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, ILRMS_API_BASE.'DepartmentApi/createGaonBura');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'name' => $name,
            'user_name' => $user_name,
            'password' => $password,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
        )));
        $output = curl_exec($curl_handle);
        curl_close($curl_handle);

        echo $output;

    }
}