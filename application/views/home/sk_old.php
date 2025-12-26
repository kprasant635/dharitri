<style>
    .casedisplay {
        min-height: 220px;
    }
    .casedisplay:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    td{
        font-size: .9em;
    }
</style>
<div class="container-fluid login home">
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        
        <div class="col-lg-12 ">
            <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> SUPERVISOR KANANGO (SK)'S DASHBOARD</label></td>
                    <td><?php include 'login_alert.php'; ?></td>
                </tr>
            </table>
            
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">FIELD MUTATION / PARTITION</p>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Note on Field Mutation</td>
                                    <td>
                                        <?php
                                        if ($fmutation != '0') {
                                            echo "<span class=\"badge badge-primary\">$fmutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingFMCases?mut=01' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Note on Field Partition</td>
                                    <td><?php
                                        if ($fpartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$fpartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingFMCases?mut=02' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">OFFICE MUT / PART / CONV</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on Office Mutation</td>
                                    <td>
                                        <?php
                                        if ($omutation != '0') {
                                            echo "<span class=\"badge badge-primary\" >$omutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=03' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Partition</td>
                                    <td>
                                        <?php
                                        if ($opartition != '0') {
                                            echo "<span class=\"badge badge-primary\" >$opartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=04' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Conversion </td>
                                    <td>
                                        <?php
                                        if ($cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$cases</span>";
                                        }
                                        ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/SKconversionPartha/GoToSK?pro=1" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">A.P CANCELLATION & MISC CASES</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write NOTE on NR Cases</td>
                                    <td><?php
                                        $countAPCaseforSK = count($countAPCaseforSK);
                                        if ($countAPCaseforSK != '0') {
                                            echo "<span class=\"badge badge-primary\">$countAPCaseforSK</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/SKAPStep1" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Misc Cases</td>
                                    <td>
                                        <?php
                                        $countMissCaseforSK = count($countMiscCaseSK);
                                        if ($countMissCaseforSK != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMissCaseforSK</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/SKStep1' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
				<div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Allotment Certificate to PP</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write NOTE on Case(s)</td>
                                    <td><?php
                                       // $allotment_sk = count($allotment_sk);
                                        if ($allotment_sk != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_sk</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/Allotment/skfirst" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $change_password = $my_info->first_login;
        if($change_password == 'Y'): ?> 
            <?php include 'first_login.php'; ?>
        <?php endif; ?>
    </div>
</div>
