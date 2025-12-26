
<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm ">
                <h3 style="text-align: center; font-size: 28px"><?php echo $this->lang->line('land_area_for_office_conversion'); ?></h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Dag Information</h3>
                </div>
                
                <div class="panel-body">
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                        <p>1. For Partial Conversion, The Converted Land will have a New Dag and New Patta.</p>
                        <p>2. For Full Conversion, The Converted Land will have the Same Dag but New Patta.</p>
                        <p>3. Please Tick the square box after selecting the Dag incase you want a Full Conversion.</p>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <form class='form-horizontal unicode' method="POST" action="<?php echo base_url() . "index.php/AsistantMutationPartha/pattadarDetails"; ?>">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('select_dag_no'); ?></label>
                        <div class="col-sm-4">
                            <select class="form-control dag_no_sara" id='dag_no' name='dag_no'>
                                <option><?php echo $this->lang->line('select_dag_no'); ?></option>
                                <?php foreach ($dags as $d): ?>
                                    <option><?php echo $d->dag_no; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <label for="inputEmail3" class="control-label pull-left" style="color: #990000;"><?php echo $this->lang->line('tick_if_whole_land_conversion'); ?> </label>
                        </div>
                        <div class="col-sm-1" style="background-color: #990000">
                            <input type="checkbox" id="PartialOrFull" class="form-control" name="PartialOrFull" value="Y"/>
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">    
                    <!--during partial conversion-->
                    <div id="autoUpdate1" class="autoUpdate">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label" style="top: 32px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" id='b' name='dag_area_b' placeholder="বিঘা" readonly>
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="কঠা" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control"  id='l' name='dag_area_lc' placeholder="লেছা" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label" style="top: 32px;">Area To Convert</label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" maxlength="6" class="form-control" id='mb' name='m_dag_area_b_P' placeholder="বিঘা" required>
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" maxlength="6" class="form-control" name='m_dag_area_k_P' id='mutatedk'  placeholder="কঠা" required>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" maxlength="6" class="form-control check_empty" name='m_dag_area_lc_P' id='lm' placeholder="লেছা" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label" style="top: 32px;"><?php echo $this->lang->line('remaining_part_of_the_dag'); ?></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" id="rb" name='l_dag_area_b_P' placeholder="বিঘা" readonly>
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control" id="rkatha" name='l_dag_area_k_P' placeholder="কঠা" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control" id="rl" name='l_dag_area_lc_P' placeholder="লেছা" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group hide">
                            <label for="inputEmail3" class="col-sm-5 control-label"><?php echo "Revenue Amount"; ?><span style="color: red;">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="dag_rev" name='land_valuation' readonly>
                            </div>
                        </div>
                    </div>
                    <!--end of partial conversion-->
                    
                    
                    <!--during full conversion-->
                    <div id="autoUpdate2" class="autoUpdate" style="display: none;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label" style="top: 32px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" id='b1' name='dag_area_b' value="0" placeholder="বিঘা" readonly>
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control"  id='katha1' name='dag_area_k' value="0" placeholder="কঠা" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control"  id='l1' name='dag_area_lc' value="0" placeholder="লেছা" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label" style="top: 32px;"><?php echo $this->lang->line('petitioner_part_of_the_dag'); ?></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" id='b2' name='m_dag_area_b' value="0" placeholder="বিঘা" readonly>
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control"  id='katha2' name='m_dag_area_k' value="0" placeholder="কঠা" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control"  id='l2' name='m_dag_area_lc' value="0" placeholder="লেছা" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label" style="top: 32px;"><?php echo $this->lang->line('remaining_part_of_the_dag'); ?></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" name='l_dag_area_b' placeholder="বিঘা" readonly value="0">
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control"   name='l_dag_area_k' placeholder="কঠা" readonly value="0">
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control"   name='l_dag_area_lc' placeholder="লেছা" readonly value="0">
                            </div>
                        </div>
                    </div>
                    <!--end of full conversion-->
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                            <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                            <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/Conversion"; ?>" class="btn btn-danger">
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#PartialOrFull').change(function () {
            if (!this.checked)
            {
                //alert("not checked");
                $('#autoUpdate1').show();
                $('#autoUpdate2').hide();
            }
            else
            {
                //alert("clicked");
                $('#autoUpdate1').hide();
                $('#autoUpdate2').show();
            }
        });
        $(".check_empty").keyup(function(){
            var lessa_empty = $(this).val();
            var kotha_empty = $('#mutatedk').val();
            var bigha_empty = $('#mb').val();
            if ((lessa_empty == '0') && (kotha_empty == '0') && (bigha_empty == '0')) {
                alert('Bigha-Katha-lessa for conversion cannot be 0-0-0 !');
                return;
            }
        });

    
    });
    
    
</script>

