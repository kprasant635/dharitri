<?php

class Landdetails extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
		//$this->dbswitch();
	}



	 public function dbswitch(){    
   
     //$CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$this->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$this->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$this->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$this->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$this->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$this->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$this->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$this->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$this->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$this->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$this->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$this->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$this->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$this->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$this->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$this->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$this->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$this->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$this->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$this->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$this->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$this->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$this->load->database('dha23', TRUE);   
     }  else if($this->session->userdata('dist_code') == "39"){
      $this->db=$this->load->database('dha39', TRUE);   
     }  else if($this->session->userdata('dist_code') == "38"){
      $this->db=$this->load->database('dha25', TRUE);   
     }    
     return $this->db;
}

	function allDistrict(){
	
		$db = $this->load->database('default', TRUE);
		$sql = "select * from district_details where state_code is not null";
		return $fm =$db->query($sql)->result();
	}

    function allLandclass(){
    
         $this->session->set_userdata('dist_code', "07");
         $db = $this->landdetails->dbswitch();
         $sql = "select * from landclass_code";
         return $fm =$db->query($sql)->result();
    }

    
    function pattaType(){
        $this->session->set_userdata('dist_code', "07");
        $db = $this->landdetails->dbswitch();
        $sql = "select type_code,patta_type from patta_code where jamabandi='y' ";
        return $fm =$db->query($sql)->result();
    }

    function activeUser($ru,$d,$s,$c,$m,$l){
      //echo $d;
      $this->session->set_userdata('dist_code',$d);
      $this->dbswitch();
      //var_dump($this->db);
      if($ru=='Y'){
          $sql="Select user_code,use_name from loginuser_table where user_code like 'AS%' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' and dis_enb_option='E' ";
          $data=$this->db->query($sql)->row_array();
          $query="Select username,phone_no from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$data[user_code]' ";
          $result=$this->db->query($query)->row_array();
          $data=array(
              'name'=>$result['username'],
              'phone'=>$result['phone_no']
          );
      }else{
          $sql="Select user_code,use_name from loginuser_table where user_code like 'M%' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and dis_enb_option='E' ";
          $data=$this->db->query($sql)->row_array();
          if($data){
              $query="Select lm_name  as username from lm_code where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and lm_code='$data[user_code]' and mouza_pargona_code='$m' and lot_no='$l' ";
              $result=$this->db->query($query)->row_array();
              $data=array(
                  'name'=>$result['username'],
                  'phone'=>'na'
              );
          }else{
              $data= array('name' =>'NOT FOUND' ,
                  'phone'=>'NA'
               );
          }
      }
      echo json_encode($data);
  }
  public function getLandclass($district){
   $this->session->set_userdata('dist_code', $district);
   $this->db = $this->landdetails->dbswitch();
   $lc = $this->db->query("select * from landclass_code where class_code_cat='02' ");

   $data = $lc->result();
   $json = array();
   foreach ($data as $object) {
     $json[] = array('class_code' => trim($object->class_code), 'land_type' => trim($object->land_type));
   }
   return $json;
 }

 function getTPattadars($ref_no)
   {     
      $db = $this->load->database('default', TRUE);
      $sql = "select * from t_property_pattadar where ref_no=? order by pid";
      return $db->query($sql,array($ref_no))->result(); 

   }

   function getTPattadar($ref_no)
   {    
      $db = $this->load->database('default', TRUE);
      $sql = "select * from t_property_pattadar where ref_no=? order by pid";
      return $db->query($sql,array($ref_no))->result(); 

   }

   function getRow($id){
      $row = $this->db->select('*')->from('t_property_pattadar')->where('pid',(int)$id )->get()->row_array();
      return $row;
    }

    function getLand($id){
      $row = $this->db->select('*')->from('t_property_land')->where('lid',(int)$id )->get()->row_array();
      return $row;
    }

    function getHouse($id){
      $row = $this->db->select('*')->from('t_property_house')->where('hid',(int)$id )->get()->row_array();
      return $row;
    }

    //get max id from t_property_land table
   function getMaxIdFromLand() {
      $this->db->select_max('lid');
      $res1 = $this->db->get('t_property_land');
      return $res1;

   }

   //get max id from property_land table
   function getMaxIdFromLandCentral() {
      $this->db->select_max('lid');
      $res1 = $this->db->get('property_land');
      return $res1;

   }

   //check ref_no already exists in t_property_land table
   function isrefno($ref_no) {
      $row = $this->db->select('ref_no')->from('t_property_land')->where('ref_no',(int)$ref_no )->get()->row_array();
      return $row;

      $this->db->select('ref_no');
      $res1 = $this->db->get('t_property_land');
      return $res1;

   }

   //get all records for property card
   function getPropertyCard($lid) {
      $this->db->select('*'); 
      $this->db->from('t_property_land');
      $this->db->where('t_property_land.lid', $lid);
      $this->db->join('t_property_pattadar', 't_property_land.lid = t_property_pattadar.lid', 'left outer');
      $this->db->join('t_property_house', 't_property_land.lid = t_property_house.lid', 'left outer');
      $query = $this->db->get();
      return $query->result();

      // $this->db->select('*')
      // ->from('t_property_land')
      // ->where('users.u_id',1)
      // ->join('comments','comments.user_id = users.u_id')
      // ->join('city','city.user_id = users.u_id')
      // ->get();

   }

   //get all property card data for CO
   function getPropertyCardCo($lid) {
      $this->db->select('t_property_land.*,t_property_pattadar.*,t_property_house.*,t_property_land.status'); 
      $this->db->from('t_property_land');
      $this->db->where('t_property_land.lid', $lid);
      $this->db->join('t_property_pattadar', 't_property_land.lid = t_property_pattadar.lid', 'left outer');
      $this->db->join('t_property_house', 't_property_land.lid = t_property_house.lid', 'left outer');
      $query = $this->db->get();
      return $query->result();

      // $this->db->select('*')
      // ->from('t_property_land')
      // ->where('users.u_id',1)
      // ->join('comments','comments.user_id = users.u_id')
      // ->join('city','city.user_id = users.u_id')
      // ->get();

   }

	
}
?>
