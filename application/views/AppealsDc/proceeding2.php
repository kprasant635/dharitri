
<script>
    $(function () {
        $('#vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });
            
        });

        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });
            
        });
        
        $('#ar').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });
            
        });
        
        $('#sk').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });
            
        });

    })

</script>
<div class="container-fluid login form-top">
    <div class='row'>
        <div class='col-lg-10 col-lg-offset-1'>
            <div class='panel panel-info'>
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('cos_order') ?>
                            <span class='pull-right'>
                                <?php echo $this->lang->line('case_no') ?><?php echo $case_no . "  <span class='badge'>Date:" . date('d-m-y') . "</span>"; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class='panel-body'>
                    <div class='row regular'>
                        <div class='col-lg-6' >
                            <p class="bold uni_text"><?php echo $this->lang->line('first_party') ?></p>
							<?php $guard="";$count=1;foreach($petitioner as $p):?>
                            <p class='regular uni_text'><?php echo $count++.") <span class='text-danger'>".$p->pet_name."</span>,&nbsp;".$this->utilityclass->get_relation($p->guard_rel)." : ".$p->guard_name;?></p>
                            <?php endforeach;?>
                        </div>
                        <div class='col-lg-6'>
                            <p class="bold uni_text"><?php echo $this->lang->line('second_party') ?></p>
                           
                            <?php $guard="";$count=1;foreach($pattadar as $p):?>
                            
                                <p class='regular uni_text'><?php echo $count++.") <span class='text-danger'>".$p->pdar_name."</span>,&nbsp;".$this->utilityclass->get_relation($p->pdar_rel_guar)." : ".$p->pdar_guardian;?></p>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group" style="text-align: center">
                        <a href="<?php echo base_url() . 'index.php/officemutation/viewPetition?case_no=' . $case_no ?>"
                           class="btn btn-danger regular" class="btn btn-danger regular" id='vp'>View Petition</a>
						   <!--these are all coming in i frame --->
                        <a href="<?php echo base_url() . 'index.php/officemutation/lmreport1?case_no=' . $case_no ?>"
                           class="btn btn-danger regular" class="btn btn-danger regular"  id='lm'>Lm Report</a>
                        <a href="<?php echo base_url() . 'index.php/officemutation/asstReport1?case_no=' . $case_no ?>"
                           class="btn btn-danger regular" class="btn btn-danger regular"  id='ar'>Asst Report</a>
                        <a href="<?php echo base_url() . 'index.php/officemutation/skreport1?case_no=' . $case_no ?>"
                           class="btn btn-danger regular" class="btn btn-danger regular"  id='sk'>SK Report</a>
							<!--these are all coming in i frame --->
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6 alert alert-warning" style="color:#0000;margin: 0 auto;float: none;text-align: center">
                            <label class="checkbox-inline uni_text regular">
                                <input type="checkbox" id="inlineCheckbox1" name='reissue_notice' value="y"><?php echo $this->lang->line('reissue_notice') ?> 
                            </label>
                            <label class="checkbox-inline uni_text regular">
                                <input type="checkbox" id="inlineCheckbox2" name="lm_petition_re" value="y"><?php echo $this->lang->line('lot_mondols_petition') ?> 
                            </label>
                        </div>

                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-lg-12 center-col'>
							<?php $action = base_url() . "index.php/coofficemutation/proceeding2"; ?>
                            <form class='form-horizontal' action="<?php echo $action; ?>" method="post">
                                <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('order') ?></label>
                                    <div class="col-sm-10">
                                        <textarea class='form-control' rows="10" name='co_order'></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('next_date_of_hearing') ?></label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="next_hearing_date" id="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8 alert alert-success" style="color:#0000;margin: 0 auto;float: none;text-align: center">
                                        <label class="radio-inline  uni_text regular">
                                            <input type="radio" id="inlineCheckbox2" name="case_status" value="final"><?php echo $this->lang->line('final_order') ?>
                                        </label>
                                        <label class="radio-inline uni_text regular">
                                            <input type="radio" id="inlineCheckbox2" name="case_status" value="dispose"><?php echo $this->lang->line('reject') ?>
                                        </label>
                                        <label class="radio-inline uni_text regular">
                                            <input type="radio" id="inlineCheckbox2" name="case_status" value="pending" checked>Continue Hearing
                                        </label>
                                    </div>
								</div>
								<hr>
                                <div class='form-group' style="text-align: center;">
                                    <button type="submit" class="btn btn-info btn-md regular" style="margin: 0 auto;"><?php echo $this->lang->line('submit_button') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Large modal -->


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            Modal
        </div>
    </div>
</div>
</div>