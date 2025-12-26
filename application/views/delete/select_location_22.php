<div class="row login">       
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Delete A dag from Patta<br>( Complete or Selective Columns )</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">                   
                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url()."index.php/Deletefromchitha/delete_a_dag_action";?>">
                        <div class="form-group">
                        <lavel class="col-lg-12" style="color: red; text-align: center"><?php echo validation_errors(); ?></lavel>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
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
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="select" name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-3 control-label">Patta Type</label>
                            <div class="col-lg-9">
                                <select class="form-control pattatype_nmae" id="select" name="patta_type">
									<?php foreach($patta as $pc): ?>
                                    <option value='<?php echo $pc->type_code; ?>' ><?=$pc->patta_type?></option>
									<?php endforeach; ?>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-3 control-label">Patta Number</label>
                            <div class="col-lg-9">
                                <select class="form-control pattanoselect" name="patta_number">	
                                </select>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-3 control-label">Dag Number</label>
                            <div class="col-lg-9">
                                <select class="form-control dagnoselect" size="3" multiple="multiple" tabindex="1" name="dag_number[]">	
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>
<script>
$('.pattanoselect').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_no = $(this).val();
        var patta_type = $('.pattatype_nmae').val();
        $.ajax({
            url: baseurl + "deletefromchitha/getJamadag/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type + "/" +patta_no,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                 console.log(data);
               var lot = JSON.parse(data);
                var template = "<option>Select Dag Number</option>";
                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].dag_no + "'>" + lot[i].dag_no + "</option>";
                }
                console.log(template);
                $('.dagnoselect').html(template);
            }
        });
    });
</script>