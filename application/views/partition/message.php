<div class="col-lg-10 col-lg-offset-1">
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
    </div>
    <?php if($this->session->flashdata('message2')):?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message2');?></strong>
    </div>
    <?php endif;?>
</div>
