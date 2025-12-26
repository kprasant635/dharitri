<?php

class BulkPattaTypeUpdateModel extends CI_Model{

  public function __construct() {
    parent::__construct();
    $this->load->model('jamabandi/jamabandiAutoUpdateModel');
  }

  // get list of patta type code
  public function getListOfPattaTypeCode($db)
  {
    return $db->query("SELECT * FROM patta_code WHERE type_code != ?", array('0000'))->result();
  }

  // update jamabandi
  public function updateJamabandi($postData, $db)
  {
    $json               = array();
    $list_of_patta_type = $postData['list_of_patta_type'];
    $dist_code          = $postData['dist_code'];
    $subdiv_code        = $postData['subdiv_code'];
    $circle_code        = $postData['circle_code'];
    $mouza_code         = $postData['mouza_code'];
    $lot_no             = $postData['lot_no'];
    $vill_code          = $postData['vill_code'];
    $app_no             = null;

    // validation of post params
    if($dist_code == null || $dist_code == '' || $subdiv_code == null || $subdiv_code == '' || $circle_code == null || $circle_code == '' || $lot_no == null || $lot_no == '' || $vill_code == null || $vill_code == '')
    {
      $json = [
        'responseType' => 1,
        'message'      => "#ERR34: Location selection is mandatory",
      ];
      return $json;
    }
    if($list_of_patta_type == null || $list_of_patta_type == '')
    {
      $json = [
        'responseType' => 1,
        'message'      => "#ERR42: You have not selected any patta type(s)",
      ];
      return $json;
    }

    foreach($list_of_patta_type as $ptype)
    {      
      $pname[] = $this->getPattaNameEnglish($ptype, $db); // patta name in english

      $response = $this->getPendingPattaNo($postData, $db, $ptype);
      // log_message('error', "#ERR50: Patta_Nos ".json_encode($response));

      if(empty($response))
      {
        log_message('error', "#WARNING54: No data available to update Jamabandi for selected patta type(s) ".json_encode($list_of_patta_type));
        $json = [
          'responseType' => 1,
          'message'      => "#WARNING54: No data available to update Jamabandi for selected patta type(s)",
        ];
        return $json;
      }

      // get patta no
      foreach($response as $pno)
      {
        foreach($pno as $row)
        {
          // update jamabandi
          $resp = $this->jamabandiAutoUpdateModel->updateJamabandi($row->patta_no, $ptype, $dist_code, 
            $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $app_no);
          log_message('error', "#ERR70: Jamabandi_response ".json_encode($resp));

          if($resp == 1)
          {
            log_message('error', "#SUCC75: Jamabandi has updated for selected patta code(s) ".json_encode($list_of_patta_type));
            $json = [
              'responseType' => 3,
              'message'      => "#SUCC75: Jamabandi has updated for selected patta type(s) ". json_encode($pname),
            ];          
          }        
          else
          {
            log_message('error', "#ERR80: Jamabandi updation failed for selected patta code(s) ".json_encode($list_of_patta_type));
            $json = [
              'responseType' => 1,
              'message'      => "#ERR80: Jamabandi updation failed",
            ];
            return $json;
          }
        }          
      }
    }
    return $json;
  }

  // get pending patta no from chitha_basic
  public function getPendingPattaNo($postData, $db, $ptype)
  {
    $list_of_patta_no = array();

    // check for excluded patta no
    $patta_result = json_decode(EXCLUDE_PATTA_NO_BY_DIST);
    foreach($patta_result as $patta)
    {
      $loc = explode('_', $patta->LOCATION);

      $dist  = $loc[0];
      $sub   = $loc[1];
      $cir   = $loc[2];
      $mouza = $loc[3];
      $lot   = $loc[4];
      $vill  = $loc[5];

      $list_of_patta_no[] = $db->query("SELECT patta_no FROM chitha_basic WHERE jama_yn IS NULL 
                              AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_type_code=? 
                                  AND patta_no NOT IN ('".implode("','",$patta->PATTA_NO)."')", 
                                  array($dist, $sub, $cir, $mouza, $lot, $vill, $ptype))->result();
    }
    return $list_of_patta_no;
  }

  // get patta name in english
  public function getPattaNameEnglish($pcode, $db) 
  {
    return $db->query("SELECT pattatype_eng FROM patta_code WHERE type_code=?", array($pcode))->row()->pattatype_eng;
  }
}

