<?php 


class BulkPattaTypeUpdateController extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('DataBaseSwitchModel');
    $this->load->model('BulkPattaTypeUpdateModel');
  }

  // view page
  public function landingPage()
  {
    $data['_view'] = 'bulkJamaUpdate/bulk_jama_patta_type_update';
    $this->load->view('layouts/main',$data);
  }

  // get list of patta type code
  public function getListOfPattaTypeCode($dist_code)
  {
    try
    {
      $db = $this->DataBaseSwitchModel->dharDbSwitch($dist_code, $refDb=null);
      $response = $this->BulkPattaTypeUpdateModel->getListOfPattaTypeCode($db);
      echo json_encode($response);
      return;
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->getListOfPattaTypeCode();
    }
  }

  // update jamabandi
  public function updateJamabandi()
  {
    try
    {
      $_POST = json_decode(file_get_contents("php://input"), true);
      $db = $this->DataBaseSwitchModel->dharDbSwitch($_POST['dist_code'], $refDb=null);
      $response = $this->BulkPattaTypeUpdateModel->updateJamabandi($_POST, $db);
      echo json_encode($response);
      return;
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->updateJamabandi();
    }
  }

}
