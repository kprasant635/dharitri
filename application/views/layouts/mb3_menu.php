<?php

  if(MB3_LIVE == OPEN)
  {
    $user_desig_code = $this->session->userdata('user_desig_code');
    $base_url        = base_url().'index.php/Home/';


    if($user_desig_code == 'LM')  // Menu list for LM starts here
    {
?>
      <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB3</a>
      <div class="dropdown-container">
        <a href="<?=$base_url.'SettlementSpecialCulCo?service='.TEA_PREFIX)?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;<?=TEA_SERVICE_MENU_NAME?></a>
      </div>


<?php
    }   // Menu list for LM ends here

  } // end of MB3_LIVE
?>


    