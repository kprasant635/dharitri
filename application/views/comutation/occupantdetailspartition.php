<script>
    $(function () {
<?php if ($occupant_id == 1): ?>
            $('#myModal').modal();
<?php endif; ?>
<?php if ($occupant_id > 1): ?>
            $('#myModal .modal-body p').html("You have already entered new dag/patta in previous screen. You cannot alter again here.");
            $('#myModal').modal();
<?php endif; ?>
        var dagNo = "" +<?php echo $new_dag; ?>;
        var pattaNo = "" +<?php echo $new_patta; ?>;
        $("input[name='new_dag_no']").change(function (e) {
            if ($(this).val() < parseInt(dagNo)) {
				$('#btn-hide').hide();
                alert("Your entered Dag cannot be less than suggested by Dharitree");
                $('#msgModal .modal-body p').html("The New Dag You Entered Already Exists in Dhartitree. Consult offline documents");
                $('#msgModal').modal();
            }else{
				$('#btn-hide').show();
			}
        });

        $("input[name='new_patta_no']").change(function (e) {
            if ($(this).val() < parseInt(pattaNo)) {
				$('#btn-hide').hide();
                alert("Your entered Patta No cannot be less than suggested by Dharitree");
                $('#msgModal .modal-body p').html("The New Patta You Entered Already Exists in Dhartitree. Consult offline documents");
                $('#msgModal').modal();
            }else{
				$('#btn-hide').show();
			}
        });
    })
</script>
<div class="modal fade" id="msgModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#ccc;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">You are in the process of Field Partition</h4>
            </div>
            <hr>
            <div class="modal-body">
                <p class="alert alert-info">You can edit the Suggested Dag No and Patta No in this Page From the Right Hand Side Red Colored Boxes.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog" style="margin-top:15%">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header custom-modal" style="background:#ccc;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title custom-modal-title">You are in the process of Field Partition</h4>
            </div>
            <hr>
            <div class="modal-body">
                <p alert alert-info>You can edit the Suggested Dag No and Patta No in this Page From the Right Hand Side Red Colored Boxes.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class='container-fluid form-top login'>
    <div class='row'>
        <div class='col-lg-12 center-col'>
            <div class='panel panel-info panel-form'>
                <div class='panel-heading'>
                    <div class='panel-title '>
                        <p><?php echo $this->lang->line('chitha_col8:_enter_occupant/applicant_of_details'); ?></p>
                    </div>
                </div>
                <div class='panel-body'>
                    <div class='row'>

                        <form class="form-horizontal" method="post"
                              action="<?php echo base_url() . 'index.php/cofieldmutation/saveOccupantPartition'; ?>"
                              >
                            <div class='col-lg-6'>
                                <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('occupant_id'); ?></label>
                                    <div class="col-sm-8">
                                        <?php
                                        ?>
                                        <input type="text" class="form-control" readonly="" name="occupant_id"
                                               value="<?php echo $occupant_id; ?>"
                                               />

                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('occupant_name'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" readonly="" name='occupant_name'
                                               value="<?php echo $petitioner->pdar_name; ?>"
                                               />

                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('guardian_name'); ?></label>
                                    <div class="col-sm-8">

                                        <input type="text" class="form-control" readonly="" name="occupant_fmh_name"
                                               value="<?php echo $petitioner->pdar_guardian; ?>"
                                               />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('relation'); ?></label>
                                    <div class="col-sm-8">
                                        <?php
                                        $relation = 'unknown';
                                        $r_code = '';
                                        switch ($petitioner->pdar_rel_guar) {
                                            case 'f':
                                                $relation = 'পিতৃ';
                                                $r_code = 'f';
                                                break;
                                            case 'm':
                                                $relation = 'মাতৃ';
                                                $r_code = 'm';
                                                break;
                                            case 'h':
                                                $relation = 'পতি';
                                                $r_code = 'h';
                                                break;
                                            case 'w':
                                                $relation = 'পত্নী';
                                                $r_code = 'w';
                                                break;
                                            case 'a':
                                                $relation = 'অধ্যক্ষ মাতা';
                                                $r_code = 'a';
                                                break;

                                            default:
                                                $relation = 'অভিভাৱক';
                                                $r_code = 'u';
                                                break;
                                        }
                                        ?>
                                        <input type="hidden" class="form-control" name="occupant_fmh_flag"
                                               value="<?php echo $r_code; ?>"
                                               readonly=""/>
                                        <input type="text" class="form-control" name=""
                                               value="<?php echo $relation; ?>"
                                               readonly=""/>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('address1'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" 
                                               value="<?php echo $petitioner->pdar_add1; ?>" name="occupant_add1"
                                               readonly=""/>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('address2'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" 
                                               value="<?php echo $petitioner->pdar_add2; ?>" name="occupant_add2"
                                               readonly=""/>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('address3'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control"
                                               value="" name="occupant_add3"
                                               readonly=""/>
                                    </div>
                                </div>



                            </div>
                            <div class='col-lg-6'>
                                <div class='alert alert-danger' style="color:#fff;font-weight: bold !important;font-size: 1.1em;">Land Area (Enter New Dag/Patta Details Below)</div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('bigha'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="land_area_b"
                                               value="<?php echo $petitioner->pdar_dag_por_b; ?>"
                                               readonly=""/>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('katha'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="land_area_k"
                                               value="<?php echo $petitioner->pdar_dag_por_k; ?>"
                                               readonly=""/>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('lessa'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="land_area_lc"
                                               value="<?php echo $petitioner->pdar_dag_por_lc; ?>"
                                               readonly=""/>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label"><?php echo $this->lang->line('revenue'); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="revenue"
                                               value="<?php echo $revenue->min_revenue; ?>"
                                               readonly=""/>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label">Old Dag</label>
                                    <?php if ($occupant_id > 1): ?>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="" style="border-color:red" readonly=""
                                                   value="<?php echo $dagapply->dag_no; ?>"
                                                   />
                                        </div>
                                    <?php else: ?>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="" style="border-color:red"
                                                   value="<?php echo $dagapply->dag_no; ?>"
                                                   />
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label">New Dag No</label>
                                    <?php if ($occupant_id > 1): ?>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="new_dag_no" style="border-color:red" readonly=""
                                                   value="<?php echo $new_dag; ?>"
                                                   />
                                        </div>
                                    <?php else: ?>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="new_dag_no" style="border-color:red"
                                                   value="<?php echo $new_dag; ?>"
                                                   />
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label">Existing Dags</label>
                                    <?php if ($occupant_id > 1): ?>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <?php foreach ($dags_all as $d): ?>
                                                    <option><?php echo $d->dag_no; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <?php foreach ($dags_all as $d): ?>
                                                    <option><?php echo $d->dag_no; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
								<div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label">Existing Pattas</label>
                                    <?php if ($occupant_id > 1): ?>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <?php foreach ($patta_all as $p): ?>
                                                    <option><?php echo $p->patta_no; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <?php foreach ($patta_all as $p): ?>
                                                    <option><?php echo $p->patta_no; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label">Old Patta</label>
                                    <?php if ($occupant_id > 1): ?>
                                        <div class="col-sm-7">

                                            <input type="text" class="form-control" name="" style="border-color:red" readonly=""
                                                   value="<?php echo $dagapply->patta_no; ?>"
                                                   />
                                        </div>
                                    <?php else: ?>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="" style="border-color:red"
                                                   value="<?php echo $dagapply->patta_no; ?>"
                                                   />
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputEmail3" class="col-sm-3   control-label">New Patta</label>
                                    <?php if ($occupant_id > 1): ?>
                                        <div class="col-sm-7">

                                            <input type="text" class="form-control" name="new_patta_no" style="border-color:red" readonly=""
                                                   value="<?php echo $new_patta; ?>" 
                                                   />
                                        </div>
                                    <?php else: ?>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="new_patta_no" style="border-color:red"
                                                   value="<?php echo $new_patta; ?>" 
                                                   />
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>


                            </div>
                            <hr>
                            <div class="col-lg-12 panel panel-body ">

                                <h2 class="red text-center">Land Area Of The New Dag</h2>
                                <!-- <div class="form-group form-group-sm">
                                     <label for="inputEmail3" class="col-sm-2   control-label"><?php echo $this->lang->line('bigha'); ?></label>
                                     <div class="col-sm-2">
                                         <input type="text" class="form-control" name="land_area_lc"
                                                value="<?php echo $dagapply->m_dag_area_b; ?>"
                                                readonly=""/>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2   control-label"><?php echo $this->lang->line('katha'); ?></label>
                                     <div class="col-sm-2">
                                         <input type="text" class="form-control" name="land_area_lc"
                                                value="<?php echo $dagapply->m_dag_area_k; ?>"
                                                readonly=""/>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2   control-label"><?php echo $this->lang->line('lessa'); ?></label>
                                     <div class="col-sm-2">
                                         <input type="text" class="form-control" name="land_area_lc"
                                                value="<?php echo $dagapply->m_dag_area_lc; ?>"
                                                readonly=""/>
                                     </div>
                                 </div>-->

                            </div>
                            <div class="clearfix"></div>
                            <div class="form-actions" style="text-align:center">
                                <button type="submit" id='btn-hide' class="btn btn-md btn-info"><i class="fa fa-floppy-o"></i> <?php echo $this->lang->line('submit'); ?></button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
