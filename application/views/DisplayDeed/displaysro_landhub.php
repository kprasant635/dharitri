<head>
<script>
function autoClick(){
document.getElementById('linkToClick').click();
}
</script>
</head>
<body onload="setTimeout('autoClick();',5);">
<center><img src="<?php echo base_url(); ?>application/views/images/load.gif" style='margin-top:100px; padding:20px' />
<?php
$token=$this->session->userdata('token');
$slno=$token['slno'];
$sro=$token['sro'];
$dist=$token['dist'];
// var_dump($slno);
// exit;
?>
<a id="linkToClick" href="<?=LABDHUB_BASE?>old_epanjeeyan/deedview.php?slno=<?=$slno?>&sro=<?=$sro?>&dist=<?=$dist?>">Click Here to View Deed</a>
<!-- <a id="linkToClick" href="<?=LINK_33?>webservices/deedview?val=<?=$token?>">Click Here to View Deed</a> -->
</center>
</body>