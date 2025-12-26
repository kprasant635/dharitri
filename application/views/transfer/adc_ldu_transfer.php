<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">LDU Case Transfer (Assign ADC)</h2>
                </div>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="center panel-title">
                            Fill up application form
                        </h3>
                    </div>
                    <div class="panel-body">
						<p class='red center'>Once You Changed ADC all the case(s) will be shifted to newly assigned ADC</p>
						<?php
						$attributes = array('CaseTransferLduAdc/Update','class' => 'form-horizontal', 'id' => 'myform');
						echo form_open_multipart('CaseTransferLduAdc/Update',$attributes); ?>
            <div class="form-group">
                    <label for="select" class="col-lg-1 control-label"><?php echo $this->lang->line('district'); ?></label>
                    <div class="col-lg-2">
                        <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                            <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                        </select>
                    </div>


                  <label for="select" class="col-lg-2 control-label">New Assign ADC</label>
                  <div class="col-lg-2">
                      <select class="form-control" name='user_code' id="select" required>
                        <?php foreach($adclist as $name){
                          $data=$this->utilityclass->getSelectedADCName($name->dist_code,$name->user_code);
                          ?>
                          <option value='<?=$data->user_code?>'><?=$data->username?></option>
                        <?php } ?>
                      </select>
                  </div>

                  <label for="select" class="col-lg-1 control-label">Circles</label>
                  <div class="col-lg-4">
                      <select class="form-control" name='circle_code[]' id="select_circle" multiple required>
                        <?php foreach($circle_list as $cir){
                          ?>
                          <option value='<?=$cir->subdiv_code?>_<?=$cir->cir_code?>'><?=$cir->circle?></option>
                        <?php } ?>
                      </select>
                  </div>

                                
								
            </div>
						
						
						<div class="form-group" style="margin-top: 30px">
							<div class="col-lg-5 col-lg-offset-4">
								<button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
								<button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>