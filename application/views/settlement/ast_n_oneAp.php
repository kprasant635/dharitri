<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">AP to PP Conversion</h2>
                </div>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="center panel-title">
                            Fill up application form
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php echo validation_errors(); ?>
						<?php
						$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
						echo form_open_multipart('Settlement/indexAP',$attributes); ?>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>

                                    </select>
                                </div>
								<label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control  mouzaselect" id="select" required name="mouza_code">
                                        <option><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouza as $moz): ?>
                                            <?php
                                            $mouza_code = $moz->mouza_pargona_code;
                                            $mouza_name = $moz->loc_name;
                                            ?>
                                            <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control  lotselect" id="select" required name="lot_no">
                                        <option disabled selected>Select Lot No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control villageselect" id="villageselect_allot" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>
                                    </select>
                                </div>
                            </div>  
							<hr>
							<div class="form-group" style="margin-top: 10px">
								<div class="col-lg-5 col-lg-offset-5">
									<button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
									<button id="MainIndex" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
								</div>
							</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
