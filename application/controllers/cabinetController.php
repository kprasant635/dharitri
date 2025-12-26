<?php

class cabinetController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'date', 'file'));
        $this->load->model('UtilsModel');
		

    }

    public function cabinetForm(){

        $user_desig_code = $this->session->userdata('user_desig_code');
		
		if($user_desig_code == "ADC"){
		$data = array();
		$data['cabinet_list'] = $this->db->query("SELECT * FROM minister_visit_details order by id asc")->result();
		$data['_view'] = 'cabinet_form';
		$this->load->view('layouts/main',$data);
		}else
		{
			echo "User Not Authorized";
		}
		
	}




	public function cabinetDetailsFormSave(){


        // $this->form_validation->set_rules('cdate', 'Visit Date', 'required|xss_clean');
        $this->form_validation->set_rules('review_case', 'No of Review Cases', 'required|xss_clean');
        $this->form_validation->set_rules('genuine_case', 'No of Genuine Cases', 'required|xss_clean');
        $this->form_validation->set_rules('sought_case', 'No of Information SoughtCases', 'required|xss_clean');

        $dist_code = $this->session->userdata('dist_code');
		$date = $this->input->post('cdate');
		$review_case = $this->input->post('review_case');
		$genuine_case = $this->input->post('genuine_case');
		$sought_case = $this->input->post('sought_case');

		if($date == "" OR $date == NULL){
			$visit_date = NULL;
		}else{
			$visit_date = $date;
		}

		$params = [
            'dist_code'=>$dist_code,
			'visit_date'=> $visit_date,
			'review_case'=> $review_case,
			'genuine_case'=> $genuine_case,
			'sought_case'=> $sought_case,
            'created_at' => date('Y-m-d H:i:s'),

		];

	

		if($this->form_validation->run() == true) 
		{
				$statusInsert1 = $this->db->insert('minister_visit_details', $params);

                
				if($statusInsert1 == 1){
					$this->session->set_flashdata('alert_msg','<div class="alert alert-success">Details Added Successfully.</div>');
                	redirect(base_url() . "index.php/cabinetController/cabinetForm");

				}
                else{
					$this->session->set_flashdata('alert_msg','<div class="alert alert-danger">#ERROR-01 - Something went wrong...</div>');

				}

		}
		else { 
			$this->cabinetForm();
		}
	}


	public function deleteCabinetDetails($id)
    {

		 $where = [
            'id' => $id,
        ];

        $status = $this->db->where($where)->delete('minister_visit_details');

        if ($status === true) {
            echo json_encode(array(
                        'responseType' => 2,
                        'message' => 'Details Deleted Successfully ',

            ));
        }
		else
		{
		 echo json_encode(array(
                        'responseType' => 1,
                        'message' => 'Details not Deleted ! Please Contact System Admin',

            ));
		}

    }

	public function downloadMinisterVisitReport()
	{

		$sql = "SELECT visit_date,review_case,genuine_case,sought_case as Info_sought_case FROM minister_visit_details order by id asc";

		$data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows <= 0) {
            $this->session->set_flashdata('message', 'No Details Found');
            redirect(base_url() . "index.php/Home");
        } else {
            $time_format = "%d-%M-%Y-%h-%i-%s-%A";
            $time = mdate($time_format);
            $data = $this->db->query($sql)->result_array();
            $file_name = "Minister_Visit_Report_" . $time . '.xlsx';
            $this->load->model('UtilsModel');
            $this->UtilsModel->downloadExcelReport($file_name, $data);
        }

	}

}