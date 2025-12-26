<?php
class ToBeAutoEscController extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->model('ToBeAutoEscModel');
  }

}