
    
        <div class="col-lg-8 col-lg-offset-2">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px"><?php echo $this->lang->line('display_jamabandi_by_selecting_a_pattanumber')?></h2>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
            </div>  
            <div class="col-lg-8 col-lg-offset-2">          
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    
                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url() . 'index.php/JamabandiControllerBondita/saveJamabandiByPattano' ?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="dist" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="subdiv" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="circ" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="mouza" name="mouza_code">
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
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="lot" name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="vill" name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type')?></label>
                            <div class="col-lg-9">
                                <select class="form-control pattatype_nmae" id="patta_type" required name="patta_type">
                                    <option disabled selected><?php echo $this->lang->line('select_patta_type')?></option>
                                    <option value='0000'>All</option>
                                    <?php
                                    foreach ($patta as $p):
                                        $type_code = $p->type_code;
                                        $patta_type = $p->patta_type;
                                        ?>
                                        <option value="<?php echo $type_code; ?>"><?php echo $patta_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="panel-heading"><span class="panel-title">Select Multiple Patta</span></div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('from') ?> :</label>
                            <div class="col-lg-4">
                                <select class="form-control pattanoselect" id="selectlwPatta" name="patta_no_lower">
                                    <option>Select Patta From</option>
                                </select>
                            </div>
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('to') ?> :</label>
                            <div class="col-lg-4">
                                <select class="form-control" id="selectlwPatta" name="patta_no_upper">
                                    <option>Select Patta To</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Order By</label>
                            <div class="col-lg-9">
                                <div class="radio col-lg-4">
                                    <label>&nbsp;<input type="radio" name="pdaralign" checked value="0">By ID</label>	
                                </div>
                                <div class="radio col-lg-4">
                                    <label><input type="radio" name="pdaralign"  value="1" checked="">By Slno</label>
                                </div>
                            </div>
                        </div>
			<hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   

<script>
    $("#selectlwPatta").change(function (e) {
        var patta_type_code = $('#patta_type').val();
        var dist_code_new = $('#dist').val();
        var subdiv_code_new = $('#subdiv').val();
        var circle_code_new = $('#circ').val();
        var mouza_code_new = $('#mouza').val();
        var lot_no_new = $('#lot').val();
        var village_new = $('#vill').val();
        var selectlwPatta = $(this).val();
        
        $.ajax({
            url: baseurl + "chithareport/getPattalower/" + selectlwPatta + "/" + patta_type_code + "/" + dist_code_new + "/" + subdiv_code_new + "/" + circle_code_new + "/" + mouza_code_new + "/" + lot_no_new + "/" + village_new,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].patta_no + "'>" + object[i].patta_no + "</option>";
                }
                $("select[name='patta_no_upper']").html(template);
            }
        });
    });
</script>
