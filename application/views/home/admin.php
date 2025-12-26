<style>
    .casedisplay {
        min-height: 0px;
    }

    .casedisplay-small {
        min-height: 120px;
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
<div class="container-fluid login home" style="min-height:500px;">
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        
        <div class="col-lg-12">
            <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> NATIONAL INFORMATICS CENTRE ( MASTER ADMIN ) DASHBOARD</label></td>
                    <td><?php //include 'login_alert.php'; ?></td>
                </tr>
            </table>
            
            <div class="row hide">
                <div class="col-lg-5">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">APPROVAL ON A. P. CANCELLATION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write report on Cancellation Matter</td>
                                    <td>
                                        <?php
                                        $getDCAP = count($getDCAPCancellation);
                                        if ($getDCAP != '0') {
                                            echo "<span class=\"badge badge-primary\">$getDCAP</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/DCAPStep1" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">RECLASSIFICATION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Approve Recommend Reclassification Proposals.</td>
                                    <td>
                                        <?php
                                        if ($recommended_reclassification_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$recommended_reclassification_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=3" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Reclassification Proposals Pending for Final Chitha Update</td>
                                    <td>
                                        <?php
                                        if ($g_trans_for_Co != '0') {
                                            echo "<span class=\"badge badge-primary\">$g_trans_for_Co</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=5" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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
            <?php //include 'first_login.php'; ?>
        <?php endif; ?>
    </div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

