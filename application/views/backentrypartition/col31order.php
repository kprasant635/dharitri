<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 " style="margin: 0 auto;float: none;">
            <div class='row' style='min-height:400px'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'>Order Direct Entry in Col-31</p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal'  action="<?php echo base_url(); ?>index.php/Backlogpartition/Col31entry" method="post">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
									<?php echo form_error('dist_code', '<p class="red">', '</p>'); ?>
                                </div> 
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
									<?php echo form_error('subdiv_code', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
									<?php echo form_error('circle_code', '<p class="red">', '</p>'); ?>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouza as $moz): ?>
                                            <?php
                                            $mouza_code = $moz->mouza_pargona_code;
                                            $mouza_name = $moz->loc_name;
                                            ?>
                                            <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
									<?php echo form_error('mouza_code', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected>Select Lot No</option>
                                    </select>
									<?php echo form_error('lot_no', '<p class="red">', '</p>'); ?>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>
                                    </select>
									<?php echo form_error('vill_code', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
								<label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-2">
                                 <select class="form-control pattatype_nmae"  required name="patta_type">
                                    <?php
									foreach($pattatype as $p){
                                    ?>
                                       <option  value="<?php echo $p->type_code;?>"><?php echo $p->patta_type;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
									<?php echo form_error('patta_type', '<p class="red">', '</p>'); ?>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control pattanoselect" id="backlog_patta_type" required name="patta_no">
                                    <option>Select Patta</option>
                                </select>
								<?php echo form_error('patta_no', '<p class="red">', '</p>'); ?>
                                </div>
								<label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                        <option><?php echo $this->lang->line('select_dag_no'); ?></option>
                                    </select>
									<?php echo form_error('dag_no', '<p class="red">', '</p>'); ?>
                                </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                 <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control villageselect" placeholder="Enter Case Number"  required name="case_no" />
									<?php echo form_error('case_no', '<p class="red">', '</p>'); ?>
                                </div>
                                 <label class="col-lg-2 control-label uni_text">Date of order </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup5Datepicker" required=""  name="order_date" placeholder='Date'  class="form-control"  >
									<?php echo form_error('order_date', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
								<label for="select" class="col-lg-2 control-label">Order</label>
                                <div class="col-lg-10">
									<textarea class='col-lg-10 form-control' placeholder='Please type Here' name='rmk' cols=5 rows=7></textarea>
									<?php echo form_error('rmk', '<p class="red">', '</p>'); ?>
								</div>
							</div>
							<hr>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?></button>   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#backlog_patta_type").change(function (e) {
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $(this).val();
        $.ajax({
            url: baseurl + "Utility/getDagsbacklog/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no']").html(template);
            }
        });
    });
</script>




