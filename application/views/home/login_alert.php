<?php
$date_of_last_password_changed = $my_info->date_password_changed;
if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
	//$this->utilityClass->updatepasswordnow($this->session->userdata('user_code'),$this->utilityClass->userdata(''));
	
    ?>
    <?php
        echo '<strong class="pull-right" style="color:red !important">Your Password is More Than a Month Older. Please Make Sure You Change it as soon as Possible.</strong>';
    ?>
    <?php
}
?>