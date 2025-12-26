<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12">
            <div class="well well-sm">
                <h2 style="text-align: center;"> Details Of the Dag in Chitha & Jamabandi </h2>
            </div>
        </div>

        <div class="col-lg-12 ">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Location Details <?php if ($index != 0) { ?>|| Case No : <?= $case_no ?> <?php } ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">District</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $location['dist_code']; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Subdivision</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $location['subdiv_code']; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Circle</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $location['cir_code']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Mouza</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $location['mouza_pargona_code']; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Lot No</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $location['lot_no']; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Village / Town</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $location['vill_townprt_code']; ?>" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form class='form-horizontal' id="f1" method="post" action="<?php echo base_url() . 'index.php/LegacyDataUpdation/updatedagno' ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Basic Dag details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="dag_no" value="<?php echo $basic_details->dag_no; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label">Subdivision</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="patta_no" value="<?php echo $basic_details->patta_no; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="<?php echo $location['patta_name']; ?>" readonly>
                            </div>

                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="<?php echo $location['land_class_name']; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Revenue</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="<?php echo round($basic_details->dag_revenue, 2); ?>" readonly>
                            </div>

                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="<?php echo round($basic_details->dag_local_tax, 2); ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Area</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="<?php echo $basic_details->dag_area_b; ?> বিঘা" readonly>
                            </div>
                            <div class="col-sm-3" style="margin-left: inherit;">
                                <input type="text" class="form-control" value="<?php echo $basic_details->dag_area_k; ?> কঠা" readonly>
                            </div>
                            <div class="col-sm-3" style="margin-left: inherit;">
                                <input type="text" class="form-control" value="<?php echo round($basic_details->dag_area_lc, 2); ?> লেছা" readonly>
                            </div>
                        </div>

                        <div class='form-group alert alert-success'>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Remarks</label>
                                <div class="col-sm-9">
                                    <textarea id="remarks" name="remarks" rows="4" cols="50" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Enter New Dag No</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" name="Update_dag" value="<?= $update_dag ?? null; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="hidden" name="app_id" id="app_id" value="<?= $case_no ?>">
                                    <?php include(APPPATH . 'views/LegacyDataUpdation/multipleUpload.php') ?>
                                </div>
                            </div>

                        
                            <input type='hidden' value='<?= $basic_details->dist_code ?>' name='dist_code' />
                            <input type='hidden' value='<?= $basic_details->subdiv_code ?>' name='subdiv_code' />
                            <input type='hidden' value='<?= $basic_details->cir_code ?>' name='cir_code' />
                            <input type='hidden' value='<?= $basic_details->mouza_pargona_code ?>' name='mouza_pargona_code' />
                            <input type='hidden' value='<?= $basic_details->lot_no ?>' name='lot_no' />
                            <input type='hidden' value='<?= $basic_details->vill_townprt_code ?>' name='vill_townprt_code' />
                            <input type='hidden' value='<?= $basic_details->dag_no ?>' name='dag_no' />
                            <input type='hidden' value='<?= $basic_details->patta_no ?>' name='patta_no' />
                            <input type='hidden' value='<?= $basic_details->patta_type_code ?>' name='patta_type_code' />

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-sm" name="button" value="approve">
                                    <?= $button_name; ?>
                                </button>
                                <?php if ($index != 0) { ?>
                                    <button type="submit" class="btn btn-danger btn-sm" name="button" value="revert"
                                        onclick="return confirm('Are you sure you want to Revert?');">Revert</button>
                                <?php } ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <?php if ($index != 0 || $reverted == 1) { ?>
                        <!-- <div class="panel-heading">
                            <h3 class="panel-title">
                                Pattadar Details
                            </h3>
                        </div> -->
                        <div class="panel-body" style="overflow-y:auto; overflow-x:hidden;">
                            <p class="uni_text">Attachments</p>
                            <table class="table table-bordered">
                                <tbody>
                                    <?php if (!empty($documents)): ?>
                                        <?php foreach ($documents as $doc): ?>
                                            <?php
                                            // Generate random prefix and suffix
                                            $randomPrefix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 5);
                                            $randomSuffix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 5);

                                            // File link
                                            $file_link = base_url("index.php/MultipleFileUpload/viewfile/" . $randomPrefix . $doc->id . $randomSuffix);
                                            ?>
                                            <tr id="tri<?= $doc->id ?>">
                                                <td><?= htmlspecialchars($doc->file_name) ?></td>
                                                <td><a href="<?= $file_link ?>" target="_blank">VIEW FILE</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No attachments found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <p class="uni_text">Remarks</p>
                            <?php if (!empty($remarks)): ?>
                                <?php foreach ($remarks as $re): ?>
                                    <label for=""><?= $re->user_desig_code ?> Date:<?= $re->date_entry ?></label>
                                    <p><?= $re->co_order ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">No Remarks found</td>
                                </tr>
                            <?php endif; ?>
                        </div>

                    <?php } ?>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Pattadar Details
                        </h3>
                    </div>
                    <div class="panel-body" style="<?= ($index == 0 && $reverted == 0) ? 'height:675px;' : '' ?> overflow-y:auto; overflow-x:hidden;">

                        <p class='uni_text'>Dag No. showing column are the Present Pattadar(s) of that Dag.</p>
                        <table class='table table-stripped'>
                            <thead>
                                <tr>
                                    <td class="center">Dag</td>
                                    <td>Name</td>
                                    <td>Gurdian Name</td>
                                </tr>
                            </thead>
                            <?php
                            foreach ($cp as $key => $val) {
                                $dag = "-----";
                                $class = "green";
                                $status = "---------";
                                $check = 'disabled';
                                $active = "";
                                foreach ($cdp as $r) {
                                    if ($r->pdar_id == $val->pdar_id) {
                                        $class = "red";
                                        $dag = "<kbd>" . $r->dag_no . "</kbd>";
                                        $check = "false checked";
                                        $active = "<span class='small'>Transfer to Allocated Patta </span>";
                                        if ($r->p_flag == '1') {
                                            $class = $class;
                                            //$status = "<strike class='red'>Strike Out</strike>";
                                            //echo "Hello";
                                        } else {
                                            $class = $class . ' green ';
                                            //$status = "Un-Strike Out";
                                        }
                                    }
                                }
                                echo "<tr>";
                                echo "<td class='center'>" . $dag . "</td>";
                                echo "<td class='$class'>" . $val->pdar_name . "</td>";
                                echo "<td class='$class'>" . $val->pdar_father . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>