<?php
ini_set('memory_limit', '-1');
class DharitreeApiMbThree extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jamabandi/JamabandiModel');
        $this->load->model('misreport/MisModel');
        $this->load->helper('url');
    }
    public function dbswitch($dist_code)
    {
        if($dist_code == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($dist_code == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($dist_code == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($dist_code == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($dist_code == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($dist_code == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($dist_code == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($dist_code == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($dist_code == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($dist_code == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($dist_code == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($dist_code == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($dist_code == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($dist_code == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($dist_code == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($dist_code == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($dist_code == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($dist_code == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($dist_code == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($dist_code == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($dist_code == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($dist_code == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($dist_code == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        }  else if($dist_code == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        }else if($dist_code == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }else if($dist_code == "22"){
            $this->db=$this->load->database('dha41', TRUE);
        }else if($dist_code == "23"){
            $this->db=$this->load->database('dha40', TRUE);
        }
        return $this->db;
    }
    

    function checkPaymentRevivalMb3(){
        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code']))
            $error[]=(array('responseType' => 1,'message' => 'distcode is required'));
        $this->dbswitch($dist_code);
        $application_no=$_POST['application_no'];
        if(isset($_POST['application_no']) && $_POST['application_no'] == '' || !isset($_POST['application_no']))
            $error[]=(array('responseType' => 1,'message' => 'application no is required'));

        $service_code=$_POST['service_code'];
        if($service_code=='44')
        {
            $sql="Select * from basundhar_application where basundhara=?";
        }
        else if ($service_code=='40')
        {
            $sql="Select * from reclass_suite_basic where applid=?";
        }
        else
        {
            $sql="Select * from settlement_basic where applid=?";
        }
        

        $data=$this->db->query($sql,$application_no);
        if($data->num_rows()==0){
            echo json_encode(array('responseType'=>1,'msg'=>'No Case no found'));
            return;
        }
        echo json_encode(array('responseType'=>2,'status'=>2,'msg'=>'Successfull'));
        return;
    }

}
?>
