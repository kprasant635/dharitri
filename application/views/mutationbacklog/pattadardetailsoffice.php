<script>
	$(function(){
                alert("Hi");
                <?php if($pattadar_cron_no==0):?>
                    $('#myModal').modal();
                <?php endif;?>
	})
</script>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header custom-modal" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title custom-modal-title">You Have Selected Office Mutation Mandal module </h4>
        </div>
          <hr>
        <div class="modal-body">
          <p>Select Pattadars Requesting Mutation from the Drop Down</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" >
                <li class="progtrckr-done ">Select Location</li>
                <li class="progtrckr-done ">Transfer Type</li>
                <li class="progtrckr-done ">Applicant Details</li>
                <li class="progtrckr-done ">Land Area</li>
                <li class="progtrckr-done ">Pattadar Details</li>
            </ol>
        </div>
    </div>

    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('pattadar_details_office')?></p>
                        </div>
                    </div>
                    <div class='panel-body'>

                        <form class='form-horizontal no-trigger preventAjax' id='pattadardetails' 
                              action="<?php  ?>"
                              method="post">
                            <input type="hidden" name="case_no"  id="case" value="<?php echo $case_no;?>"/>
                            <input type="hidden" name="case_no"  id="case" value="<?php echo $case_no;?>"/>
                            <div class="form-group " style="display: none;">
                                <label for="inputEmail3"  class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pattadar_no')?></label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" value= <?php echo $pattadar_cron_no; ?> name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                </div>
                            </div>
                            <div class="form-group">

                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('select_pattadar')?></label>

                                

                                <div class="col-sm-4">

                                    <select type="text" class="form-control pattadar_name_no_session" name="pdar_name" id="pdar_name" required>
                                        <option selected><?php echo $this->lang->line('select_pattadar')?></option>
                                        <?php foreach ($pattadars as $pattadar): ?>
                                            <option value='<?php echo $pattadar->pdar_id; ?>'><?php echo $pattadar->pdar_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('inplace_alongwith')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control inplace" name="striked_out" required>
                                        <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith')?></option>
                                        <option value="1"><?php echo $this->lang->line('inplace')?></option>
                                        <option value="0"><?php echo $this->lang->line('alongwith')?></option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_name')?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pdar_guardian" id="guardian_name" placeholder="<?php echo $this->lang->line('guardian_name')?>" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('relation')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control relation-type" name="pdar_rel_guar" required>
                                        <option selected disabled><?php echo $this->lang->line('select_relation')?></option>
                                        <?php foreach ($relation as $r): ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address1')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100"  class="form-control" name="pdar_add1" id="applicantNam" placeholder="<?php echo $this->lang->line('address1')?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address2')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100"  class="form-control" name="pdar_add2" id="applicantNam" placeholder="<?php echo $this->lang->line('address2')?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>

                                    <a href='<?php echo base_url(); ?>index.php/home'
                                       class="btn btn-danger"><i class='fa fa-home'></i><?php echo $this->lang->line('home')?></a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




