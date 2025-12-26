<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Query Result
                        </h3>
                    </div>
                    <div class="panel-body" style=' overflow-y: scroll;'>
                        <table class='table table-sm table-bordered unicode'  id='cases' width="100%">
                                <thead>
								<?php 
									foreach($field as $l){
									?>
									<th><label class="control-label"><?=$l?></label></th>
									<?php
								}
                                ?>
                                </thead>
								
                                <?php 
								foreach($data as $val){
									echo "<tr>";
									foreach($val as $k=>$l){
									?>	
										<td class="center"><?php echo $val->$k; ?></td>
										
									<?php
									} 
									echo "</tr>";
                                }
                                ?>
								
                            </table>
                            
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 