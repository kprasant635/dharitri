<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-9 col-lg-offset-2">
            <ol class="progtrckr" data-progtrckr-steps="5">
                <li class="progtrckr-done firsttick">Select Location</li>
                <li class="progtrckr-done secondtick">Transfer Type</li>
				<li class="progtrckr-done thirdtick">Single/Multiple Dag</li>
                <li class="">Applicant Details</li>
                <li class="">Mutation Land Area</li>
            </ol>
        </div>
    </div>
    
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('ismultiple')?></p>
                        </div>
                    </div>
                    <div class='panel-body'>



                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/mutationbacklog/isMultiple"; ?>" method="post">
                           
                             <div class="form-group">
                                <div class="col-lg-6" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;text-align: center">
                                    <label class="radio-inline uni_text"><input type="radio" name="ismultiple" value="false" onclick="$('form').submit()"><?php echo $this->lang->line('single_dag')?></label>
									<?php if(!($this->session->userdata('mut_type')==='02')):?>

                                    <label class="radio-inline uni_text "><input type="radio" name="ismultiple" value="true" onclick="$('form').submit()"><?php echo $this->lang->line('multiple_dag')?></label>
									<?php endif;?>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




