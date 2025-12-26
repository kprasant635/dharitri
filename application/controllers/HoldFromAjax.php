<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HoldFromAjax extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

   public function recvDeed(){
        //var_dump($_GET);
		
   }

	public function recvSeller(){
         if(!$this->session->userdata('fromSROSellers')){
         	$temp = array();
         	$fromSROSellers = array();
         	$fromSROSellers['address'] = $_POST['address'];
         	$fromSROSellers['fname'] = $_POST['fname'];
         	$fromSROSellers['nameparty'] = $_POST['nameparty'];
         	$fromSROSellers['srocode'] = $_POST['srocode'];
         	$fromSROSellers['state'] = $_POST['state'];
         	$temp[]=$fromSROSellers;
         	$this->session->set_userdata(array('fromSROSellers'=>$temp));

         }else{
         	$stored = $this->session->userdata('fromSROSellers');
         	$temp = array();
         	$temp['address'] = $_POST['address'];
         	$temp['fname'] = $_POST['fname'];
         	$temp['nameparty'] = $_POST['nameparty'];
         	$temp['srocode'] = $_POST['srocode'];
         	$temp['state'] = $_POST['state'];
         	$stored[]=$temp;
         	$this->session->set_userdata(array('fromSROSellers'=>$stored));
         }
         //var_dump($this->session->userdata('fromSROSellers'));
   }   

   public function recvPurchase(){
   		 if(!$this->session->userdata('fromSROPurchasers')){
         	$temp = array();
         	$fromSROSellers = array();
         	$fromSROSellers['address'] = $_POST['address'];
         	$fromSROSellers['fname'] = $_POST['fname'];
         	$fromSROSellers['nameparty'] = $_POST['nameparty'];
         	$fromSROSellers['srocode'] = $_POST['srocode'];
         	$fromSROSellers['state'] = $_POST['state'];
         	$temp[]=$fromSROSellers;
         	$this->session->set_userdata(array('fromSROPurchasers'=>$temp));

         }else{
         	$stored = $this->session->userdata('fromSROPurchasers');
         	$temp = array();
         	$temp['address'] = $_POST['address'];
         	$temp['fname'] = $_POST['fname'];
         	$temp['nameparty'] = $_POST['nameparty'];
         	$temp['srocode'] = $_POST['srocode'];
         	$temp['state'] = $_POST['state'];
         	$stored[]=$temp;
         	$this->session->set_userdata(array('fromSROPurchasers'=>$stored));
         }
        // var_dump($this->session->userdata('fromSROPurchasers'));
   }

   public function recvLand(){
   		 if(!$this->session->userdata('sroLandDetails')){
         	$temp = array();
         	$sroLandDetails = array();
         	$sroLandDetails['barea'] = $_POST['barea'];
         	$sroLandDetails['chatakarea'] = $_POST['chatakarea'];
         	$sroLandDetails['dagno'] = $_POST['dagno'];
         	$sroLandDetails['larea'] = $_POST['larea'];
         	$sroLandDetails['pattano'] = $_POST['pattano'];
         	$sroLandDetails['villcode'] = $_POST['villcode'];
         	$temp[]=$sroLandDetails;
         	$this->session->set_userdata(array('sroLandDetails'=>$temp));

         }else{
         	$stored = $this->session->userdata('sroLandDetails');
         	$temp = array();
         	$temp['barea'] = $_POST['barea'];
         	$temp['chatakarea'] = $_POST['chatakarea'];
         	$temp['dagno'] = $_POST['dagno'];
         	$temp['larea'] = $_POST['larea'];
         	$temp['pattano'] = $_POST['pattano'];
         	$temp['villcode'] = $_POST['villcode'];

         	$stored[]=$temp;
         	$this->session->set_userdata(array('sroLandDetails'=>$stored));
         }
         //var_dump($this->session->userdata('sroLandDetails'));
   }
}
