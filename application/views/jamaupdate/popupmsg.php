<script>
	$(document).ready(function(){
		$("#myModal").modal(
		{
			backdrop: 'static', 
			keyboard: false,
			show: true
		});
	});
</script>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chitha has been updated  for Case Number <?=$this->session->userdata('case_no');?> </h5>
            </div>
            <div class="modal-body">
				<p>Update Jamabandi for Patta Number <?=$this->session->userdata('patta_no');?></p>
				<center><a href='<?php echo base_url();?>index.php/Jamabandi/step3/<?=$this->session->userdata('patta_no');?>/<?=$this->session->userdata('patta_type_code');?>' class='btn btn-sm btn-danger'>Update Jamabandi Now</a></center><br>
            </div>
        </div>
    </div>
</div>