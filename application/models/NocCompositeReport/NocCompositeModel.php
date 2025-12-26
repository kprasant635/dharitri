<?php

class NocCompositeModel extends CI_Model {

  public function getRegisteredCountDistrictWise(){
      
      $this->db->select('count(*)');
      $this->db->where('compserv','Y');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      return $query->row()->count;
      // $sql = "select count(*) from landsale where compserv=? and epay=?";
      // $query = $this->db->query($sql,array('Y', 'Y'));
      // return $query->row()->count; 

  }
  public function getPendingCountDistrictWise(){
      $this->db->select('count(*)');
      $this->db->where('compserv','Y');
      $this->db->where('automut','P');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      return $query->row()->count;
  }
  public function getDeliveredCountDistrictWise(){
    $sql = $this->db->query("Select count(slno) from ( (select slno from landsale where compserv = 'Y' and automut = 'M'
    and nocupload = 'Y' and mutcomp = 'Y' and epay ='Y') union (select slno from landsale where 
    compserv = 'Y' and automut = 'M' and nocupload = 'Y' and partcomp = 'Y' and epay ='Y')) as rt");
    return $sql->row()->count;    
  }
  public function getRejectedCountDistrictWise(){
      $this->db->select('count(*)');
      $this->db->where('compserv','Y');
      $this->db->where('boallowed', 'Reject');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      return $query->row()->count;
  }
  public function getAmRegisteredCountDistrictWise(){
     $this->db->select('count(*)');
     $this->db->where('compserv','Y');
     $this->db->where('automut','M');
     $this->db->where('epay','Y');
     $this->db->from('landsale');
     $query = $this->db->get(); 
     return $query->row()->count;
  }
  public function getAmpRegisteredCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('compserv','Y');
    $this->db->where('automut','P');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get(); 
    return $query->row()->count;
  }
  public function getAmPendingCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('automut','M');
    $this->db->where('compserv','Y');
    $this->db->where('boallowed', 'Reject');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get();
    return $query->row()->count;
  }
  public function getAmpPendingCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('automut','M');
    $this->db->where('compserv','Y');
    $this->db->where('boallowed', 'Reject');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get(); 
    return $query->row()->count;
  }
  public function getAmDeliveredCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('compserv','Y');
    $this->db->where('automut','M');
    $this->db->where('nocupload', 'Y');
    $this->db->where('mutcomp', 'Y');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get(); 
    return $query->row()->count;
  }
  public function getAmpDeliveredCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('compserv','Y');
    $this->db->where('automut','P');
    $this->db->where('nocupload', 'Y');
    $this->db->where('partcomp', 'Y');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get(); 
    return $query->row()->count;
  }
  public function getAmRejectedCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('compserv','Y');
    $this->db->where('automut','M');
    $this->db->where('boallowed', 'Reject');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get(); 
    return $query->row()->count;
  }
  public function getAmpRejectedCountDistrictWise(){
    $this->db->select('count(*)');
    $this->db->where('compserv','Y');
    $this->db->where('automut','P');
    $this->db->where('boallowed', 'Reject');
    $this->db->where('epay','Y');
    $this->db->from('landsale');
    $query = $this->db->get(); 
    return $query->row()->count;
  }
  public function getCircleWiseAmRegisteredCount(){
      $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
      $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
      //return $this->db->last_query();
      $circle_list= $query->result(); 
      $circle_wise_report_arr = array();
      foreach($circle_list as $circle_detail){        
        $this->db->select("count(*)");
        $this->db->where('compserv','Y');
        $this->db->where('circode',$circle_detail->cir_code);
        $this->db->where('subcode',$circle_detail->subdiv_code);
        $this->db->where('automut','M');
        $this->db->where('epay','Y');
        $this->db->from('landsale');
        $query = $this->db->get();
        $circleAmRegisteredCases = $query->row()->count;
        array_push($circle_wise_report_arr, [
          "circle_name" => $circle_detail->loc_name."(".$circle_detail->locname_eng.")", 
          "dist_code" => $circle_detail->dist_code,
          "subdiv_code" => $circle_detail->subdiv_code,
          "cir_code" => $circle_detail->cir_code,
          "mouza_pargona_code" => $circle_detail->mouza_pargona_code,
          "lot_no" => $circle_detail->lot_no, 
          "vill_townprt_code" => $circle_detail->vill_townprt_code, 
          "registered_am_count" => $circleAmRegisteredCases
        ]);
      }
      return $circle_wise_report_arr;
  }
  public function getCircleWiseAmDeliveredCount(){
    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle_detail){
      $this->db->select("count(*)");        
      $this->db->where('compserv','Y');
      $this->db->where('circode',$circle_detail->cir_code);
      $this->db->where('subcode',$circle_detail->subdiv_code);
      $this->db->where('automut','M');
      $this->db->where('nocupload', 'Y');
      $this->db->where('mutcomp', 'Y');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      $circleAmDeliveredCases = $query->row()->count;
      array_push($circle_wise_report_arr, [
        "circle_name" => $circle_detail->loc_name."(".$circle_detail->locname_eng.")", 
        "dist_code" => $circle_detail->dist_code,
        "subdiv_code" => $circle_detail->subdiv_code,
        "cir_code" => $circle_detail->cir_code,
        "mouza_pargona_code" => $circle_detail->mouza_pargona_code,
        "lot_no" => $circle_detail->lot_no, 
        "vill_townprt_code" => $circle_detail->vill_townprt_code, 
        "registered_am_count" => $circleAmDeliveredCases
      ]);
    }
    return $circle_wise_report_arr;
  }
  public function getCircleWiseAmRejectedCount(){
    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle_detail){
      $this->db->select("count(*)");        
      $this->db->where('compserv','Y');
      $this->db->where('circode',$circle_detail->cir_code);
      $this->db->where('subcode',$circle_detail->subdiv_code);
      $this->db->where('automut','M');
      $this->db->where('boallowed', 'Reject');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      $circleAmRejectedCase = $query->row()->count;
      array_push($circle_wise_report_arr, [
        "circle_name" => $circle_detail->loc_name."(".$circle_detail->locname_eng.")", 
        "dist_code" => $circle_detail->dist_code,
        "subdiv_code" => $circle_detail->subdiv_code,
        "cir_code" => $circle_detail->cir_code,
        "mouza_pargona_code" => $circle_detail->mouza_pargona_code,
        "lot_no" => $circle_detail->lot_no, 
        "vill_townprt_code" => $circle_detail->vill_townprt_code, 
        "registered_am_count" => $circleAmRejectedCase
      ]);
    }
    return $circle_wise_report_arr;
  }
  public function getCircleWiseAmpRegisteredCount(){
    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle_detail){
      $this->db->select("count(*)");        
      $this->db->where('compserv','Y');
      $this->db->where('circode',$circle_detail->cir_code);
      $this->db->where('subcode',$circle_detail->subdiv_code);
      $this->db->where('automut','P');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get();
      $circleAmpRegisteredCases = $query->row()->count;
      array_push($circle_wise_report_arr, [
        "circle_name" => $circle_detail->loc_name."(".$circle_detail->locname_eng.")", 
        "dist_code" => $circle_detail->dist_code,
        "subdiv_code" => $circle_detail->subdiv_code,
        "cir_code" => $circle_detail->cir_code,
        "mouza_pargona_code" => $circle_detail->mouza_pargona_code,
        "lot_no" => $circle_detail->lot_no, 
        "vill_townprt_code" => $circle_detail->vill_townprt_code, 
        "registered_am_count" => $circleAmpRegisteredCases
      ]);
    }
    return $circle_wise_report_arr;
  }
  public function getCircleWiseAmpDeliveredCount(){
    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle_detail){
      $this->db->select("count(*)");        
      $this->db->where('compserv','Y');
      $this->db->where('circode',$circle_detail->cir_code);
      $this->db->where('subcode',$circle_detail->subdiv_code);
      $this->db->where('automut','P');
      $this->db->where('nocupload', 'Y');
      $this->db->where('partcomp', 'Y');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      $circleAmpDeliveredCases = $query->row()->count;
      array_push($circle_wise_report_arr, [
        "circle_name" => $circle_detail->loc_name."(".$circle_detail->locname_eng.")", 
        "dist_code" => $circle_detail->dist_code,
        "subdiv_code" => $circle_detail->subdiv_code,
        "cir_code" => $circle_detail->cir_code,
        "mouza_pargona_code" => $circle_detail->mouza_pargona_code,
        "lot_no" => $circle_detail->lot_no, 
        "vill_townprt_code" => $circle_detail->vill_townprt_code, 
        "registered_am_count" => $circleAmpDeliveredCases
      ]);
    }
    return $circle_wise_report_arr;
  }
  public function getCircleWiseAmpRejectedCount(){
    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle_detail){
      $this->db->select("count(*)");        
      $this->db->where('compserv','Y');
      $this->db->where('circode',$circle_detail->cir_code);
      $this->db->where('subcode',$circle_detail->subdiv_code);
      $this->db->where('automut','P');
      $this->db->where('boallowed', 'Reject');
      $this->db->where('epay','Y');
      $this->db->from('landsale');
      $query = $this->db->get(); 
      $circleAmRejectedCase = $query->row()->count;
      array_push($circle_wise_report_arr, [
        "circle_name" => $circle_detail->loc_name."(".$circle_detail->locname_eng.")", 
        "dist_code" => $circle_detail->dist_code,
        "subdiv_code" => $circle_detail->subdiv_code,
        "cir_code" => $circle_detail->cir_code,
        "mouza_pargona_code" => $circle_detail->mouza_pargona_code,
        "lot_no" => $circle_detail->lot_no, 
        "vill_townprt_code" => $circle_detail->vill_townprt_code, 
        "registered_am_count" => $circleAmRejectedCase
      ]);
    }
    return $circle_wise_report_arr;
  }
  public function getCircleWiseAmPendingCount(){

    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle){
      
      //auto-mutation
      $pendingLmQueryAm = $this->db->query("SELECT count(1) FROM landsale where circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and automut = 'M'  and compserv = 'Y' and lmforward ='Y' and lmreturn = 'N'  and epay='Y'");
      $pendingWithLmCountAm = $pendingLmQueryAm->row()->count;
      
      $pendingCoQueryAm = $this->db->query("SELECT (SELECT count(1) FROM landsale where epay='Y' and automut = 'M'
      and coforward is NULL and passbybo='N' and lmforward='Y' and circode ='".$circle->cir_code."' 
      and subcode='$circle->subdiv_code' and lmreturn='Y' and coreturn='N' and compserv='Y' and hearingdt is null) +
      (SELECT count(1) FROM landsale where circode ='".$circle->cir_code."' 
      and subcode='$circle->subdiv_code' and automut = 'M' and
      lmforward='Y' and lmreturn='Y' and coreturn='N' and coforward is NULL 
      and compserv='Y' and noticeserv='Y') as count");
      $pendingWithCoCountAm = $pendingCoQueryAm->row()->count;
      
      $pendingAdcQueryAm = $this->db->query("SELECT count(1) FROM landsale where epay='Y' and circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and automut = 'M'  and coforward is NULL and coreturn='Y' and passbybo='N' and (boallowed='New' or boallowed='Objection') and compserv='Y' ");
      $pendingWithAdcCountAm = $pendingAdcQueryAm->row()->count;

      $pendingDcQueryAm = $this->db->query("SELECT count(1) FROM landsale where epay='Y' and circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and automut = 'M' and batchno > 0 and dcsmfor='Y' and dcsmback='N' and compserv='Y' ");
      $pendingWithDcCountAm = $pendingDcQueryAm->row()->count;

      //*****************************************************************//
      //pending with assistant
      $am_pending_with_assistant_q = $this->db->query("SELECT count(1) from landsale where epay='Y' and 
          circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and compserv='Y' and automut = 'M' and coforward is NULL and passbybo='N' and lmforward='Y' and lmreturn='Y' and coreturn='N' and hearingdt is not NULL and noticeserv is NULL and boallowed!='Reject'");
      $am_pending_with_assistant_count = $am_pending_with_assistant_q->row()->count;
      //pending with sro
      $am_pending_with_sro_q = $this->db->query("SELECT count(1) from landsale where epay='Y' and circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and compserv='Y' and automut = 'M' and appissue = 'Y' and boallowed = 'Allowed' and nocupload= 'Y' and mutcomp is NULL and nocexec is null");
      $am_pending_with_sro_count = $am_pending_with_sro_q->row()->count;
      //*****************************************************************//
      //completion of deed auto mutation partition circle wise
      $am_completion_of_deed_q = $this->db->query("SELECT count(1) from landsale where epay='Y' and 
          circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and compserv='Y' and automut = 'M' and nocexec='Y' and nocupload='Y' and mutcomp is null");
      $am_completion_of_deed_count = $am_completion_of_deed_q->row()->count;

      array_push($circle_wise_report_arr, [
        "circle_name" => $circle->loc_name."(".$circle->locname_eng.")", 
        "dist_code" => $circle->dist_code,
        "subdiv_code" => $circle->subdiv_code,
        "cir_code" => $circle->cir_code,
        "mouza_pargona_code" => $circle->mouza_pargona_code,
        "lot_no" => $circle->lot_no, 
        "vill_townprt_code" => $circle->vill_townprt_code, 
        "total_pending_count" => $pendingWithLmCountAm+$pendingWithCoCountAm+$pendingWithAdcCountAm+$pendingWithDcCountAm+$am_pending_with_sro_count+$am_completion_of_deed_count,
        "pendingWithLmCount" => $pendingWithLmCountAm,
        "pendingWithCoCount" => $pendingWithCoCountAm, 
        "pendingWithAdcCount" => $pendingWithAdcCountAm,
        "pendingWithDcCount" => $pendingWithDcCountAm,
        "pending_with_sro_count" => $am_pending_with_sro_count, 
        "completion_of_deed_count" => $am_completion_of_deed_count
      ]);
    }
    return $circle_wise_report_arr;


    
  }
  public function getCircleWiseAmpPendingCount(){

    $sql = "select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name, locname_eng from location where dist_code != ? and subdiv_code!=? and cir_code !=? and mouza_pargona_code=? and lot_no=?";
    $query = $this->db->query($sql,array('00', '00', '00', '00', '00'));
    //return $this->db->last_query();
    $circle_list= $query->result(); 
    $circle_wise_report_arr = array();
    foreach($circle_list as $circle){
      
      //auto-mutation
      $pendingLmQueryAm = $this->db->query("SELECT count(1) FROM landsale where circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and automut = 'M'  and compserv = 'Y' and lmforward ='Y' and lmreturn = 'N'  and epay='Y'");
      $pendingWithLmCountAm = $pendingLmQueryAm->row()->count;
      
      $pendingCoQueryAm = $this->db->query("SELECT (SELECT count(1) FROM landsale where epay='Y' and automut = 'P'
      and coforward is NULL and passbybo='N' and lmforward='Y' and circode ='".$circle->cir_code."' 
      and subcode='$circle->subdiv_code' and lmreturn='Y' and coreturn='N' and compserv='Y' and hearingdt is null) +
      (SELECT count(1) FROM landsale where circode ='".$circle->cir_code."' 
      and subcode='$circle->subdiv_code' and automut = 'P' and
      lmforward='Y' and lmreturn='Y' and coreturn='N' and coforward is NULL 
      and compserv='Y' and noticeserv='Y') as count");
      $pendingWithCoCountAm = $pendingCoQueryAm->row()->count;
      
      $pendingAdcQueryAm = $this->db->query("SELECT count(1) FROM landsale where epay='Y' and circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and automut = 'P'  and coforward is NULL and coreturn='Y' and passbybo='N' and (boallowed='New' or boallowed='Objection') and compserv='Y' ");
      $pendingWithAdcCountAm = $pendingAdcQueryAm->row()->count;

      $pendingDcQueryAm = $this->db->query("SELECT count(1) FROM landsale where epay='Y' and circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and automut = 'P' and batchno > 0 and dcsmfor='Y' and dcsmback='N' and compserv='Y' ");
      $pendingWithDcCountAm = $pendingDcQueryAm->row()->count;

      //*****************************************************************//
      //pending with assistant
      $am_pending_with_assistant_q = $this->db->query("SELECT count(1) from landsale where epay='Y' and 
          circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and compserv='Y' and automut = 'P' and coforward is NULL and passbybo='N' and lmforward='Y' and lmreturn='Y' and coreturn='N' and hearingdt is not NULL and noticeserv is NULL and boallowed!='Reject'");
      $am_pending_with_assistant_count = $am_pending_with_assistant_q->row()->count;
      //pending with sro
      $am_pending_with_sro_q = $this->db->query("SELECT count(1) from landsale where epay='Y' and circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and compserv='Y' and automut = 'P' and appissue = 'Y' and boallowed = 'Allowed' and nocupload= 'Y' and mutcomp is NULL and nocexec is null");
      $am_pending_with_sro_count = $am_pending_with_sro_q->row()->count;
      //*****************************************************************//
      //completion of deed auto mutation partition circle wise
      $am_completion_of_deed_q = $this->db->query("SELECT count(1) from landsale where epay='Y' and 
          circode ='".$circle->cir_code."' and subcode='$circle->subdiv_code' and compserv='Y' and automut = 'P' and nocexec='Y' and nocupload='Y' and mutcomp is null");
      $am_completion_of_deed_count = $am_completion_of_deed_q->row()->count;

      array_push($circle_wise_report_arr, [
        "circle_name" => $circle->loc_name."(".$circle->locname_eng.")", 
        "dist_code" => $circle->dist_code,
        "subdiv_code" => $circle->subdiv_code,
        "cir_code" => $circle->cir_code,
        "mouza_pargona_code" => $circle->mouza_pargona_code,
        "lot_no" => $circle->lot_no, 
        "vill_townprt_code" => $circle->vill_townprt_code, 
        "total_pending_count" => $pendingWithLmCountAm+$pendingWithCoCountAm+$pendingWithAdcCountAm+$pendingWithDcCountAm+$am_pending_with_sro_count+$am_completion_of_deed_count,
        "pendingWithLmCount" => $pendingWithLmCountAm,
        "pendingWithCoCount" => $pendingWithCoCountAm, 
        "pendingWithAdcCount" => $pendingWithAdcCountAm,
        "pendingWithDcCount" => $pendingWithDcCountAm,
        "pending_with_sro_count" => $am_pending_with_sro_count, 
        "completion_of_deed_count" => $am_completion_of_deed_count
      ]);
    }
    return $circle_wise_report_arr;


    
  }
  public function getAmLotWisePendingCount($dist_code, $subdiv_code,$cir_code){
    $sql = "SELECT u.nameoff,count(ls.lmcode) as case_count,
            (select loc_name as lot_name from location l where l.dist_code=u.distcode and l.subdiv_code=u.subdivcode
            and l.cir_code=u.circlecode and l.mouza_pargona_code=u.mouzacode and l.lot_no=u.lotno and l.vill_townprt_code='00000' ) as lot
            FROM landsale ls join user1 u on ls.lmcode=u.usnm where ls.circode =? and ls.subcode=? and ls.automut = 'M' and 
            ls.compserv = 'Y' and ls.lmforward ='Y' and ls.lmreturn = 'N' and ls.epay='Y'
            group by u.distcode,u.subdivcode,u.circlecode,u.mouzacode,u.lotno,u.nameoff";    
    $query = $this->db->query($sql,array($cir_code,$subdiv_code));
    //return $this->db->last_query();
    return $query->result(); 
  }
  public function getAmpLotWisePendingCount($dist_code, $subdiv_code,$cir_code){    
    $sql = "SELECT u.nameoff,count(ls.lmcode) as case_count,
            (select loc_name as lot_name from location l where l.dist_code=u.distcode and l.subdiv_code=u.subdivcode
            and l.cir_code=u.circlecode and l.mouza_pargona_code=u.mouzacode and l.lot_no=u.lotno and l.vill_townprt_code='00000' ) as lot
            FROM landsale ls join user1 u on ls.lmcode=u.usnm where ls.circode =? and ls.subcode=? and ls.automut = 'P' and 
            ls.compserv = 'Y' and ls.lmforward ='Y' and ls.lmreturn = 'N' and ls.epay='Y'
            group by u.distcode,u.subdivcode,u.circlecode,u.mouzacode,u.lotno,u.nameoff";    
    $query = $this->db->query($sql,array($cir_code,$subdiv_code));
    //return $this->db->last_query();
    return $query->result(); 
  }
}
?>
