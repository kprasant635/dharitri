<?php //var_dump($locationData); ?>
<?php //echo validation_errors(); ?>
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-7 col-lg-offset-2">
            <ol class="progtrckr" data-progtrckr-steps="4">
               <li class="progtrckr-done firsttick"><?php echo $this->lang->line('select_location');?></li>
                <li class="progtrckr-done secondtick"><?php echo $this->lang->line('transfer_type');?></li>
                <li class="thirdtick"><?php echo $this->lang->line('mutation_land_area');?></li>
                <li class="fourthtick"><?php echo $this->lang->line('applicant_details');?></li>
            </ol>
        </div>
    </div>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'>
                              
                                <?php
                                //var_dump($this->session->all_userdata());
                                echo $this->lang->line('transfer_type');?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                       <?php if ($this->session->flashdata('message')): ?>
                        <?php include 'message.php'; ?>
                    <?php endif; ?>
                        <form class='form-horizontal form_1 unicode ' method="post" action="<?php echo base_url() . 'index.php/partition/savePartionCO' ?>">
                            <fieldset><legend><?php echo $this->lang->line('recieving_officer'); ?></legend>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('date'); ?></label>
                                <div class="col-sm-2">
                                    <div class="error"><?php echo form_error('report_date'); ?> </div>
                                    <input type="text" class="form-control dating" required="" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y'); ?>" id="ddmmyy" name="report_date" >
                                </div>
                                
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('recieving_officer'); ?><i class="fa fa-star red"></i></label>
                                <div class="col-sm-2">
                                    <select class="form-control applied_to" name="applied_to">
                                        <OPTION value = "0" selected>Select Option</OPTION>
                                        <OPTION value = "CO">CO</OPTION>
                                        <OPTION value="DC">DC</OPTION>
                                        <OPTION value="ADC">ADC</OPTION>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select id="ss" name="COName" class="form-control">
                                        <option>Select Name</option>
                                    </select>
                                </div>
                                
                            </div>
                            </fieldset>
                            <hr>
                            <?php //print_r($pattatype);?>
                            <fieldset><legend><?php echo $this->lang->line('select_patta_no');?> </legend>
							<div style='margin-bottom:10px'><span class='red center hide' >টোকা : যদিহে আবেদনকাৰীৰ উত্ত দাগ /পট্টা ত মাটিৰ অংশ বাকী নাথাকে তেতিয়া বাটোৱাৰাৰ প্রকাৰ সম্পূৰ্ণ দিয়ক অন্যথা অসম্পূৰ্ণ দিয়ক |</span></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_no'); ?>  <i class="fa fa-star red"></i></label>
                                <div class="col-sm-2">
                                    <div class="error"> <?php echo form_error('patta_no'); ?> </div>
                                    <input type="number" class="form-control transfer-type" required="" id="quantity" placeholder="Patta No" name="patta_no">
                                    <span id="errmsg"></span>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?> <i class="fa fa-star red"></i> </label>
                                <div class="col-sm-2">
                                    <select class="form-control patta-type" name="patta_type">
                                        <option selected disabled><?php echo $this->lang->line('patta_type'); ?> </option>
                                        <?php foreach($pattatype AS $patta){?>
                                        <option value="<?php echo $patta->type_code;?>"><?php echo $patta->patta_type;?></option>
                                    <?php }?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label hide"><?php echo $this->lang->line('partition_type'); ?><i class="fa fa-star red"></i></label>
                                <div class="col-sm-2">
								<input type='text' class='form-control hide' value='Y' name='patition_type' placeholder="সম্পূৰ্ণ" />
                                   <!----- <select class="form-control " required name="patition_type">
                                        <option value="0">Select Partition Type</option>
                                        <option select value="Y">সম্পূৰ্ণ<?php //echo $this->lang->line('full'); ?> </option>
                                        <option value="N">অসম্পূৰ্ণ<?php //echo $this->lang->line('partial'); ?> </option>
                                    </select>
									
									----->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('remark'); ?></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="topseal" rows="4" cols="5"> বাটোৱাৰা বিচাৰি আবেদন দাখিল  কৰিছে । </textarea>
                                </div>
                            </div>
                            <div class="checkbox  col-lg-offset-2">
                                <label>
                                    <input type="checkbox" class="squaredTwo" name="attachment" value="Y">   <?php echo $this->lang->line('required_doc');  ?>Submitted
                                </label>
                            </div>
                            </fieldset>
                            <hr>
                            
                            <div class="form-group" style="text-align: center">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




