<?php /* Author: Partha Sarathi, Dated-29/08/2018 */ ?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Generate Jamawasil for Multiple Pattas
                        </h3>
                    </div>
                    <div class="panel-body">
                            <form class='form-horizontal' method="post" action="<?php echo base_url()."index.php/MisReportControllerForJamawasil/GetPattas";?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('district') ?> </label>
                                <div class="col-sm-4">
                                    <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('subdivision') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('circle') ?> </label>
                                <div class="col-sm-4">
                                    <select class="form-control circleselect" id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('mouza') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control mouzaselect" id="select" name="mouza_code" required>
                                        <option disabled selected><?php echo $this->lang->line('select_mouza'); ?></option>
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
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('lot_no') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected><?php echo $this->lang->line('select_lot') ?></option>
                                    </select>
                                </div>  
                            </div>   
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text  control-label"><?php echo $this->lang->line('vill_town') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected><?php echo $this->lang->line('select_village') ?></option>
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label required" id='pattatype'>Patta Type Code:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="patta_type" required>
                                        <option value="" selected disabled> -- Select Patta Type -- </option>
                                        <?php foreach ($patta_type as $pt): ?>
                                            <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                            
                            </div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 uni_text control-label">No of Pattadar Per Page:</label>
							 	<div class="col-sm-4">   
					  				<input type="text" class="form-control" name="rows" required value="12" ></div><font color=red size=4><b>(12 sugegsted for best fit)</b></font>
                            	</div>
							</div>
							<div class="form-group" align="center">
								<label for="inputEmail3"><font color=red size=5>Recommended browser::Mozila Firefox.</font><font color=blue size=4><a href="<?php echo base_url(); ?>index.php/MisReportControllerForJamawasil/HelpForPgSetup" target="_blank"> READ ME for Page Setup</font></label>
							</div>
                            <hr style="border-bottom: 2px solid #000;">   
                            <div class="form-group">
                                <div class="col-sm-12 center" >
                                    <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-check'></i>&nbsp;Proceede>></button> &nbsp;&nbsp; | &nbsp;&nbsp;
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

