<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Transfer Lot Mondal To Another Lot</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Basic Details and Location Details Cannot be Updated.</b></h6>
                        </div>
                        <form class='form-horizontal'>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('basic_details'); ?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('name'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="<?php echo $info['name']; ?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group alert-success">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('role'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="role" value="<?php echo $info['role']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('status'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="status" value="<?php echo $info['status']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('designation'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="status" value="<?php echo $info['designation']; ?>" readonly>
                                    <input type="hidden" class="form-control" name="designation_code" id="designation_code" value="<?php echo $info['designation_code']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('type'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="type" value="<?php echo $info['type']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('date_of_joining'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="joining_name" value="<?php echo $info['joining_date']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 hide control-label"><?php echo $this->lang->line('date_of_release'); ?></label>
                                <div class="col-sm-4 hide">
                                    <input type="text" class="form-control" name="relese_date" value="<?php echo $info['relese_date']; ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('location_details'); ?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="dist_code" value="<?php echo $info['dist_name']; ?>" readonly>
                                </div>
                                <?php
                                if ($info['subdiv_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="subdiv_code" value="<?php echo $info['subdiv_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($info['cir_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="cir_code" value="<?php echo $info['cir_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                if ($info['mouza_pargona_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="mouza_pargona_code" value="<?php echo $info['mouza_pargona_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($info['lot_no'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="lot_no" value="<?php echo $info['lot_no']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($info['sk_name'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('sk_name'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="" value="<?php echo $info['sk_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                        </form>
						<form class='form-horizontal'  method="POST" action="<?php echo base_url(); ?>index.php/initialization/updatelotLM" >
							<h2><mark>Please Select the Lot to be transfered</mark></h2>
                            <hr>
							<label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                    <div class="col-sm-2">
                                        <select class='form-control' name='update_lot'>
											<?php foreach($lotlists as $r): ?>
											<option value='<?=$r->lot_no;?>'><?=$r->loc_name;?></option>
											<?php endforeach; ?>
										</select>
                                    </div>
									<div class='col-sm-2'>
										<button type='submit' class='btn btn-info'> <i class='fa fa-edit'></i> Update Lot</button>
									</div>
							<?php
								//var_dump($info);
							?>
							<input type='hidden' name='user_code' value='<?=$info['user_code']?>' />
							<input type='hidden' name='dist_code' value='<?=$info['dist_code']?>' />
							<input type='hidden' name='subdiv_code' value='<?=$info['subdiv_code']?>' />
							<input type='hidden' name='cir_code' value='<?=$info['cir_code']?>' />
							<input type='hidden' name='mouza_pargona_code' value='<?=$info['mouza_pargona_code']?>' />
							<input type='hidden' name='lot_no' value='<?=$info['lot_no_code']?>' />
						</form>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>