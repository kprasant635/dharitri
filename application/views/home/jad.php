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
                    <td><label class="regular"><i class="fa fa-tachometer"></i> JUNIOR ASSISTANT OF REVENUE DASHBOARD</label></td>
                    <td><?php include 'login_alert.php'; ?></td>
                </tr>
            </table>
            
            <div class="row">
                <div class="col-lg-4 ">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">MIS REPORTS</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Dispose and Pending Cases - At a Glance</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeGalanceDCLAO" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Dispose and  Pending Cases - For a Particular Period</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForPPDCLAO" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Cases Pending more than 2-3 months</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForMonthsDCLAO" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Monthly Account of - Mutation / Partition / Conversion Cases </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReportController1/MonthlyAccMutPartConv_REV" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

