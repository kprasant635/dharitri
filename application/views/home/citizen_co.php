 <div class="col-lg-6 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_citizen_centric') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_verify_citizen') ?></td>
                                    <td>
                                        <?php
                                        if ($citizenPendingCO != '0') {
                                            echo "<span class=\"badge badge-primary\">$citizenPendingCO</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/CitizenController/COStep1";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_citizen_check_status') ?></td>
                                    <td></td>
                                    <td><a class="pull-right green" href="<?php echo base_url() . "index.php/CitizenController/CheckStatus" ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                 <tr>
                                    <td>Digital Sign and deliver ROR</td>
                                   <td>
                                        <?php
                                        if ($count_dsc_ror != '0') {
                                            echo "<span class=\"badge badge-primary\">$count_dsc_ror</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green" href="<?php echo base_url() . "index.php/CitizenController/requestCircle/$service_code" ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <!-- <tr>
                                    <td>Final Order for Correction Of Land Records as per Civil Court</td>
                                    <td>
                                        <?php
//                                        if ($civil_appeal_basic != '0') {
//                                            echo "<span class=\"badge badge-primary\">$civil_appeal_basic</span>";
//                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/RecordCorrectionCivilCourt/copendingcaselist";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								<tr>
                                    <td>Final Order for Correction Of Land Records as per Civil Court</td>
                                    <td>
                                        <?php
//                                        if ($civil_appeal_basic != '0') {
//                                            echo "<span class=\"badge badge-primary\">$civil_appeal_basic</span>";
//                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/RecordCorrectionCivilCourt/copendingcaselist";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr> -->
                            </table>
                        </div>
                    </div>
                </div>