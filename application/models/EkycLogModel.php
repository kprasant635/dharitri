<?php
class EkycLogModel extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  public function insertEkycAccessedBy($db, $param)
  {
    // check if already exist
    $recordExist = $this->getRecordExist($db, $param);

    if($recordExist == 0)
    {
      $insertLog = [
        'case_no'          => $param['case_no'],
        'proceeding_no'    => $this->getSerialNo($db, $param['case_no']),
        'service_code'     => $param['service_code'],
        'type'             => 'AADHAAR',
        'accessed_by_desg' => $this->session->userdata('user_desig_code'),
        'accessed_by_code' => $this->session->userdata('user_code'),
        'accessed_entity'  => $param['accessed_entity'],
        'status'           => 'y',
        'ip'               => $_SERVER['SERVER_ADDR'],
        'remarks'          => $param['remarks'],
        'created_at'       => date('Y-m-d H:i:s'),
      ];
      $ins = $db->insert('ekyc_accessed_by', $insertLog);
      if($ins != 1)
      {
        return array(
          'responseType' => 1,
          'message'      => '#33 Something went wrong, Logged failed !!!',
        );
      }
    }    
    return array(
      'responseType' => 2,
      'message'      => 'Logged Successfully !!!',
    );
  }

  protected function getSerialNo($db, $case_no)
  {
    $sr_no = $db->query("SELECT max(proceeding_no)+1 as c FROM ekyc_accessed_by WHERE case_no=?", array($case_no))->row()->c;
    if ($sr_no == null) {
      $sr_no = 1;
    }
    return $sr_no;
  }

  protected function getRecordExist($db, $param)
  {
    return $db->query("SELECT * FROM ekyc_accessed_by WHERE case_no=? AND accessed_by_code=? AND accessed_by_desg=? 
              AND type=?", array($param['case_no'], $this->session->userdata('user_code'), 
                $this->session->userdata('user_desig_code'), 'AADHAAR'))->num_rows();
  }   

}
?>