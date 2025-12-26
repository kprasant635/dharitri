<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/JamabandiControllerBondita/displayjamabandiByPattadarname' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-sm-4">
<!--                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select_district')?></option>
                                    <?php foreach ($names as $district): ?>
                                        <?php
                                        $distCode = $district->district;
                                        $location = $district->district_name;
                                        ?>
                                        <option value="<?php echo $distCode; ?>"><?php echo $location; ?></option>
                                    <?php endforeach; ?>
                                </select>-->
                                
                                       <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-sm-4">
                               	   <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>
                                </select>
                            </div>
                       </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-sm-4">
                                             <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('mouza')?></label>
                                <div class="col-sm-4">
                                  <select class="form-control mouzaselect" id="select" name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
                                    <?php foreach ($mouza as $moz): ?>
                                        <?php
                                        $mouza_code = $moz->mouza_pargona_code;
                                        $mouza_name = $moz->loc_name;
                                        ?>
                                        <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('lot_no')?></label>
                                <div class="col-sm-4">
                                     <select class="form-control lotselect" id="select" required name="lot_no">
                                    <option disabled selected><?php echo $this->lang->line('lot_no')?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('vill_town')?></label>
                                <div class="col-sm-4">
                                     <select class="form-control villageselect" id="select" required name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select_village')?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                            </div>
							<div class="form-group">
							    <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('pattadar_name')?></label>
								<div class="col-sm-4"><input type="text" class="form-control" name="pattadar_name" required ></div>
							</div>
							<hr>
							<div class="form-group">
								<div class="col-sm-8 col-lg-offset-4" >
									<button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button')?></button>
									<button id="MainIndex" class="btn uni_text btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_home')?></button>
								</div>
							</div>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
