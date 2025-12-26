<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Field Partition Order Form
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="col-lg-12">
                                <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                                <label class="col-sm-4 rasid">Applicant Details</label>
                                <label class="col-sm-4 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y',strtotime(date('d-m-Y'))); ?></label>
                            </div>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <form class='form-horizontal unicode' id='myForm' action="<?php echo base_url() . 'index.php/cofieldmutation/saveOccupantPartitionOrder'; ?>" method="post">
                                <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>
                                <table class='table table-striped table-bordered tablesorter' id='cases'>
                                    <thead>
                                         <tr>
                                            <th class="center"><?php echo $this->lang->line('applicant_name'); ?></th>
                                            <th class="center"><?php echo $this->lang->line('guardian_name');?></th>
                                            <th class="center"><?php echo $this->lang->line('relation');?></th>
                                            <th class="center">Land Share ( individual )</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($petitioner as $pa):?>
                                        <tr>
                                        <td class="center"><?php echo $pa->pdar_name; ?></td>
                                        <td class="center"><?php echo $pa->pdar_guardian; ?></td>
                                        <td class="center"><?php echo $pa->pdar_guardian; ?></td>
                                        <td class="center"><?php echo $pa->pdar_dag_por_b . "-" . $pa->pdar_dag_por_k . "-" . $pa->pdar_dag_por_lc; ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </table>
                                <!-- Applied Partition Land -->
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label red"><?php echo "Applied Land For Partition";?> </label>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('bigha') ?></span>
                                        <input type="number" readonly=""  class="form-control" name="bigha_applied" value="<?php echo $dagapply->m_dag_area_b; ?>" placeholder="বিঘা">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('katha') ?></span>
                                        <input type="number" readonly="" class="form-control" name="katha_applied" value="<?php echo $dagapply->m_dag_area_k; ?>" placeholder="কঠা">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('lessa') ?></span>
                                        <input type="number" readonly="" class="form-control" name="lessa_applied" value="<?php echo $dagapply->m_dag_area_lc; ?>" placeholder="লেছা">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('ganda') ?></span>
                                        <input type="number" readonly="" class="form-control" placeholder="গন্ডা" value="0" readonly>
                                    </div>
                                </div>
                                <!-- Old Land Share -->
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label red"><?php echo $this->lang->line('land_description') ?> </label>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('bigha') ?></span>
                                        <input type="number"  class="form-control" name="bigha" value="<?php echo $areaFromChitha->dag_area_b; ?>" readonly>
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('katha') ?></span>
                                        <input type="number"  class="form-control" name="katha" value="<?php echo $areaFromChitha->dag_area_k; ?>" readonly>
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('lessa') ?></span>
                                        <input type="number"  class="form-control" name="lessa" value="<?php echo $areaFromChitha->dag_area_lc; ?>" readonly>
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <span class="center small"><?php echo $this->lang->line('ganda') ?></span>
                                        <input type="number"  class="form-control" placeholder="গন্ডা" value="0" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-3 uni_text uni_text control-label required"><?php echo $this->lang->line('dag_revenue'); ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="P_land" name="dag_revenue" value="<?php echo $revenue = null? $revenue: 10; ?>">
                                    </div>

                                    <label for="inputEmail" class="col-sm-2 uni_text uni_text control-label required"><?php echo $this->lang->line('dag_local_tax'); ?></label>
                                    <div class="col-sm-3">
                                       <input type="text" class="form-control" id="p_loc_tax" name="dag_local_tax" value="<?php echo $local_taxecho = 0?  $local_taxecho: 2; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-3 uni_text uni_text control-label required">Old Dag</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="P_land" name="old_dag" value="<?php echo $dagapply->dag_no; ?>" readonly>
                                    </div>

                                    <label for="inputEmail" class="col-sm-2 uni_text uni_text control-label required">Old Patta</label>
                                    <div class="col-sm-3">
                                       <input type="text" class="form-control" id="P_land" name="old_patta" value="<?php echo $dagapply->patta_no; ?>" readonly>
                                    </div>
                                </div>
                                
                                <table class='table table-striped'>
                                    <tr>
                                        <td colspan="2">
                                            <label for="inputEmail" class="col-sm-12 uni_text required">
                                                <?php
                                                if (($check[0]->count == '0') && ($land_area_check == '0')) {
                                                    echo "<span style='color:red;'>Since All the Pattadars are the Applicants for Partition so the dag no will remain same and patta no will be Changed.</span>";
                                                } else {
                                                    echo "<span style='color:red;'>This is a Partial Partition so the dag no and patta no will be Changed.</span>";
                                                }
                                                ?>
                                            </label>
                                            <?php
                                            echo "<label for='inputEmail' class='col-sm-12 uni_text required'><span style='color:red;'>Land Area (Enter New Dag/Patta Details Below).</span></label>";
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="patta_type" value="<?php echo $patta_type; ?>" readonly>
                                                <input type="hidden" class="form-control patta_code" name="patta_code" value="<?php echo $dagapply->patta_type_code; ?>" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="inputEmail3" class="col-sm-6 control-label red"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                            <div class="col-sm-6">
                                                <?php
                                                //if (($check[0]->count == '0') && ($land_area_check == '0')) {
                                                if (($land_area_check == '0')) {
                                                    ?>
                                                    <input type="text" class="form-control newDag" name="sugg_dag_no" value="<?php echo $dagapply->dag_no; ?>" readonly>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="text" class="form-control newDag" id="newDag" name="sugg_dag_no" value="<?php echo $new_dag; ?>">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                            <div class="col-sm-6">
                                                <select class="form-control">
                                                    <option disabled selected>-- Verify Old Dags --</option>
                                                    <?php foreach ($dags_all as $d): ?>
                                                    <option><?php echo $d->dag_no; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="inputEmail3" class="col-sm-6 control-label red"><?php echo $this->lang->line('suggested_new_patta_no'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="newPatta" name="sugg_patta_no" value="<?php echo $new_patta; ?>">
                                            </div>
                                            <div id="msg1"></div>
                                        </td>
                                        <td>
                                            <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Pattas</label>
                                            <div class="col-sm-6">
                                                <select class="form-control">
                                                    <option disabled selected>-- Verify Old Patta --</option>
                                                    <?php foreach ($patta_all as $p): ?>
                                                    <option><?php echo $p->patta_no; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="dist_code" class="form-control" id="dist_code_new" value="<?php echo $dagapply->dist_code; ?>" readonly>
                                    <input type="hidden" name="cir_code" class="form-control" id="subdiv_code_new" value="<?php echo $dagapply->subdiv_code; ?>" readonly>
                                    <input type="hidden" name="subdiv_code" class="form-control" id="circle_code_new" value="<?php echo $dagapply->cir_code; ?>" readonly>
                                    <input type="hidden" name="mouza_pargona_code" class="form-control" id="mouza_code_new" value="<?php echo $dagapply->mouza_pargona_code; ?>" readonly>
                                    <input type="hidden" name="lot_no" class="form-control" id="lot_no_new" value="<?php echo $dagapply->lot_no; ?>" readonly>
                                    <input type="hidden" name="vill_townprt_code" class="form-control" id="village" value="<?php echo $dagapply->vill_townprt_code; ?>" readonly>
                                </table>
                            </form>
                            <center>
                                <table style='margin-left:450px'>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" id='formsubmit' class="btn btn-primary uni_text toggle"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                            <button type="submit" id='directformsubmit' class="btn btn-danger uni_text" style="display: none"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#directformsubmit').click(function() {
        document.getElementById("myForm").submit();
    });
    $('#formsubmit').click(function() {
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village').val();
        var new_dag = $('.newDag').val();
        var new_patta = $('#newPatta').val();
        var new_patta_type = $('.patta_code').val();
        
        $.ajax({
            url: baseurl + "COFieldMutation/chech_dag_patta_exist/" + dist_code_new + '/' + subdiv_code_new + '/' + circle_code_new + '/' + mouza_code_new + '/' + lot_no_new + '/' + village_new + '/' +new_dag + '/' + new_patta + '/' + new_patta_type,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                if(result == '1')
                {
                    document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Patta Number Already Exists.<br> Are you sure you want to merge this dag with the existing patta.</p></label>";
                    $('.toggle').hide();
                    $('#directformsubmit').show();
                    return false;
                }
                else
                {
                    document.getElementById("myForm").submit();
                }
            }
        });
    });
    
</script>


