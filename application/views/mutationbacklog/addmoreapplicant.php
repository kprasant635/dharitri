<div class="row form-top login">
    <div class="center col-lg-12  " style="margin-top: 50px">
        <a class="btn btn-danger " href="<?php echo base_url() . "index.php/mutationbacklog/applicantdetails?next=true" ?>">Click Here to Add More Applicant </a>
        <a class="btn btn-info " href="<?php echo base_url() . "index.php/mutationbacklog/mutationlandarea" ?>">Click For Next</a>
    </div>
</div>

<script>
	$(function(){
                    $('#myModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
	})
</script>