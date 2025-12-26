<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Back Log Entry Module</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Utility Module
                        </h3>
                    </div>
		    <div class="panel-body">
                    <?php if ($this->session->flashdata('message')): ?>
                         <?php include 'message.php'; ?>
                    <?php endif; ?>

                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <span class="glyphicon glyphicon-link" aria-hidden="true" style='color: blue;'></span>&nbsp;&nbsp;<a class="red" href="<?php echo base_url(); ?>application/views/img/SOP2-ILRMS-BacklogEntry.docx" download>Download SOP for Backlog Entry Module</a>
                        </div>
						<?php
                        $user_desig = $this->session->userdata('user_desig_code');
                        if ($user_desig == 'CO') {
                            $attribute = 'hide';
                            ?>
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <?php
                                        $req = $this->utilityclass->getCountBacklogPermission($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
                                        $request_count = '';
                                        if ($req->count) {
                                            $request_count = "<span class='badge badge-primary'>" . $req->count . "</span>";
                                        }
                                        ?>
                                        Lot Mondal's Pending Request For Enabling Backlog Modules &nbsp;&nbsp;&nbsp;>> <?php echo  $request_count ?> <a href="<?php echo base_url(); ?>index.php/Request/PendingRequest" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        $mob = $this->utilityclass->getCountBacklogMutation($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
                                        $mut_count = '';
                                        if ($mob) {
                                            $mut_count = "<span class='badge badge-primary'>" . $mob . "</span>";
                                        }
                                        ?>
                                        Pending Office / Field Mutation Cases ( Back Log) &nbsp;&nbsp;&nbsp;>> <?php echo  $mut_count ?> <a href="<?php echo base_url(); ?>index.php/backLogMutation/PendingCases" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        $mob = $this->utilityclass->getCountBacklogPartition($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
                                        $mut_count = '';
                                        if ($mob) {
                                            $mut_count = "<span class='badge badge-primary'>" . $mob . "</span>";
                                        }
                                        ?>
                                        Pending Office / Field Partition Cases ( Back Log) &nbsp;&nbsp;&nbsp;>> <?php echo  $mut_count; ?>  <a href="<?php echo base_url(); ?>index.php/backlogpartition/copending" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        $mob = $this->utilityclass->getCountBacklogConversion($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
                                        $mut_count = '';
                                        if ($mob) {
                                            $mut_count = "<span class='badge badge-primary'>" . $mob . "</span>";
                                        }
                                        ?>
                                        Pending Office Conversion Cases ( Back Log) &nbsp;&nbsp;&nbsp;>> <?php echo  $mut_count; ?> <a href="<?php echo base_url(); ?>index.php/backLogConversion/PendingCases" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr class='hide'>
                                    <td>
                                        Pending Land Reclassification Cases ( Back Log) &nbsp;&nbsp;&nbsp;>>  <a href="#" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        Report on changed data (Mutation Back Log) &nbsp;&nbsp;&nbsp;>>  <a href="<?php echo base_url(); ?>index.php/backLogMutation/Report" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Report on changed data (Conversion Back Log) &nbsp;&nbsp;&nbsp;>>  <a href="<?php echo base_url(); ?>index.php/backLogConversion/Report" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                            </table>
                            <?php
                        } elseif (($user_desig == 'DC') || ($user_desig == 'ADC') || ($user_desig == 'LAO') || ($user_desig == 'SCN') || ($user_desig == 'DCN')) {
                            $attribute = '';
                            ?>
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        District Report on changed data (Mutation Back Log) &nbsp;&nbsp;&nbsp;>>  <a href="<?php echo base_url(); ?>index.php/backLogMutation/MaxReport" class="text-danger"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                            </table>
                            <?php
                        } else {
                            $attribute = '';
                            ?>
                            <label><font color=blue size=4>Sequence to be followed for using backlog Modules :</font></label><br>
                            <label>1) To Activate any of the below listed back log module.</label>&nbsp;&nbsp;
                            <a href="<?php echo base_url(); ?>index.php/Request/BackLog" class="green"> <label>[ Click Here to Send Request For Backlog ]</label> </a><br>
                            <label>2) Use Any Of the Backlog Module links Activated by the Circle Officer to register Backlog Cases that are already Passed Offline.</label><br>
                            <label><font color=red size=4>User must follow the above mentioned sequences to update Chitha & Jamabandi.</font></label>
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <table class="table table-condensed">
                                    <tr>
                                        <td>&gt;&gt;
                                            <?php
                                            $type = 'M'; // M for Mutation, P for Partition, C for converion and R reclassification
                                            $MutationPermission = $this->utilityclass->getBacklogPermission($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $type);
                                            if ($MutationPermission == 'A') {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/BackLogMutation/BackEntryMutation">Back Log Entry For Field / Office Mutation</a> <span class="badge badge-info">Activated</span>
                                                <?php
                                            } elseif ($MutationPermission == 'P') {
                                                ?>
                                                <a href="#">Back Log Entry For Field / Office Mutation</a> <span class="badge badge-warning">Request Sent</span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#" >Back Log Entry For Field / Office Mutation</a> <span class="badge badge-danger">Locked</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td>&gt;&gt;
                                            <?php
                                            $type = 'P'; // M for Mutation, P for Partition, C for converion and R reclassification
                                            $MutationPermission = $this->utilityclass->getBacklogPermission($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $type);
                                            if ($MutationPermission == 'A') {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/Backlogpartition/backlog_f_part">Back Log Entry For Field / Office Partition</a> <span class="badge badge-info">Activated</span>
                                                <?php
                                            } elseif ($MutationPermission == 'P') {
                                                ?>
                                                <a href="#">Back Log Entry For Field / Office Partition</a> <span class="badge badge-warning">Request Sent</span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#" >Back Log Entry For Field / Office Partition</a> <span class="badge badge-danger">Locked</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&gt;&gt;
                                            <?php
                                            $type = 'C'; // M for Mutation, P for Partition, C for converion and R reclassification
                                            $ConversionPermission = $this->utilityclass->getBacklogPermission($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $type);
                                            if ($ConversionPermission == 'A') {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/BackLogConversion/BackEntryConversion">Back Log Entry For Land Conversion</a> <span class="badge badge-info">Activated</span>
                                                <?php
                                            } elseif ($ConversionPermission == 'P') {
                                                ?>
                                                <a href="#">Back Log Entry For Land Conversion</a> <span class="badge badge-warning">Request Sent</span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#" >Back Log Entry For Land Conversion</a> <span class="badge badge-danger">Locked</span>
                                                <?php
                                            }
                                            ?>
                                        </td>        
                                    </tr>
                                </table>
                            </center>
                            <?php
                        }
                        ?>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-12 center">
                                <a href="<?php echo base_url(); ?>index.php/Request/BackLog" class="btn btn-success <?php echo $attribute; ?>">
                                    <i class="fa fa-check"></i>&nbsp;Send Request For Backlog
                                </a>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
