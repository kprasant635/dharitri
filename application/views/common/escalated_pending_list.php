<?php

  $user_desig_code = $this->session->userdata('user_desig_code');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');

  // var_dump($escAllocateDays); die;

  $service_code = $escAllocateDays->service_code;

  if ($this->session->userdata('user_desig_code') == 'AST') {
    $asstt = $this->utilityclass->getSelectedAssttName($dist_code, $subdiv_code, $cir_code, $user_code);
    $name = $asstt->username;
  }
  if ($user_desig_code == 'LM') {
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');
    $lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
    $name = $lm->lm_name;
  }
  if ($user_desig_code == 'SK') {
    $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
    $name = $sk->username;
  }
?>

<div class="row">        
  <div class="col-lg-5 col-lg-offset-2">
    <div class="panel" style="background: linear-gradient(to bottom right, rgba(255,0,0,0), #136a8a);">
      <div class="panel-body">
        <table class="table table-striped table-hover">
          <tr>
            <td><span class="regular"><b>Escalated List</b></span></td>
            <td>&nbsp;</td>
            <td>
              <a class="pull-right green" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase($service_type)?>">VIEW</a>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>                   
</div>