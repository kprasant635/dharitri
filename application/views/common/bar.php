
<div class="row login no-print"  >
<div class='col-lg-6 col-lg-offset-3' style="text-align:center">
	<?php if(isset($_SERVER['HTTP_REFERER'])):?>
		<a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class='btn btn-warning'><i class="fa fa-arrow-left"></i>&nbsp;Previous</a>
		<a href="<?php echo base_url().'index.php/home/index';?>" class='btn btn-danger'><i class="fa fa-arrow-left"></i>&nbsp;Back To Main Menu</a>
	<?php endif;?>
</div>
</div>
