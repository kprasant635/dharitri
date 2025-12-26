<style>
    .casedisplay {
        min-height: 220px;
    }
    .casedisplay1 {
        min-height: 330px;
    }
    .casedisplay:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    .casedisplay1:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    td{
        font-size: .9em;
    }
</style>
<?php
$user_desig_code = $this->session->userdata('user_desig_code');
$dist_code = $this->session->userdata('dist_code');
$subdiv_code = $this->session->userdata('subdiv_code');
$cir_code = $this->session->userdata('cir_code');
$user_code = $this->session->userdata('user_code');
if ($this->session->userdata('user_desig_code') == 'AST') {
    $asstt = $this->utilityclass->getSelectedAssttName($dist_code, $subdiv_code, $cir_code, $user_code);
    $name = $asstt->username;
}
if ($user_desig_code == 'LM') {
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');
    $lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
    $name = $lm->lm_name;
    //var_dump($lm);
    $this->session->set_userdata('nocuser',$lm->lmuser);
    //$this->session->set_userdata('nocuser','LM0502013');
}
if ($user_desig_code == 'SK') {
    $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
    $name = $sk->username;
}
?>


            

        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        <?php
        $corres_sk_code = $my_info->corres_sk_code;
        $check_maping_sk = $this->utilityclass->getsk_mapping($corres_sk_code);
        if ($check_maping_sk == '0') {
            include 'sk_mapping_alert.php';
        }
        ?>
        <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> DASHBOARD</label></td>
                    <td><?php include 'login_alert.php'; ?></td>
                </tr>
            </table>

            <div class="container">
              <div class="row" id="dashboard_dv">
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>100</h3>

                <p>New Case As on <?=date('d/m/Y')?></p>
              </div>
              <div class="icon">
                
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>43</h3>

                <p>Pending Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>1004</h3>

                <p>Registration during this month</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>165</h3>

                <p>Certificate Delivered</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
</div>
<div class="container-fluid login home hide">
            <div class="row">
                <div class="col-lg-4" >
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">FIELD MUTATION / PARTITION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td colspan="2">Write Report on Field Mutation/Partition</td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/mutation/' ?>" class="text-danger " style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Co-Pattadar Consent </td>
                                    <td><?php
                                        if ($fconsent != '0') {
                                            echo "<span class=\"badge badge-primary\">$fconsent</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/copattaddarConsent' ?>" class="green " style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending Cases for Map Parition </td>
                                    <td>
                                        <?php
                                        if ($map_partition != '0') {
                                            echo "<span class=\"badge badge-primary\">$map_partition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/pendingmaps' ?>" class="green" style="float:right">view</a></td>
                                </tr>
                                <tr>
                                    <td>Suo-Moto Mutation Case(s)</td>
                                    <td>
                                        <?php
                                        if ($sronotepen != '0') {
                                            echo "<span class=\"badge badge-primary\">$sronotepen</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/lmmutation/Suomotodeed'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class="hide">
                                    <td>Request for Fresh Report By CO</td>
                                    <td><?php
                                        if ($freshreport != '0') {
                                            echo "<span class=\"badge badge-primary\">$freshreport</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="#" style="float:right">view</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">OFFICE MUTATION / CONV</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on Office Mutation</td>
                                    <td><?php
                                        if ($omutation != '0') {
                                            echo "<span class=\"badge badge-primary\">$omutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/getPendingOfficeMutationCases' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report On Office Conversion </td>
                                    <td><?php
                                        if ($oconv != '0') {
                                            echo "<span class=\"badge badge-primary\">$oconv</span>";
                                        }
                                        ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LMconversionPartha/GoToLM?pro=1" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">OFFICE PARTITION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on Office Partition</td>
                                    <td><?php
                                        if ($ofcPartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$ofcPartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/getPendingOfficePartitionCases' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Byay Prak Kalan (Office Partition)</td>
                                    <td><?php
                                        if ($ofcByayPrak != '0') {
                                            echo "<span class=\"badge badge-primary\">$ofcByayPrak</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/getPendingOfficeByayPrakCases' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Co-Pattadar Consent (Partition)</td>
                                    <td><?php
                                        if ($ConsentPattadar != '0') {
                                            echo "<span class=\"badge badge-primary\">$ConsentPattadar</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/partition/ConsentPendingCase" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending Case(s) for Map Partition</td>
                                    <td><?php
                                        if ($mappartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$mappartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/partition/MapPartPendingCase" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">ANNUAL PATTA CANCELLATION</p>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on NR Cases</td>
                                    <td><?php
                                        $countAPCase = count($countAPCase);
                                        if ($countAPCase != '0') {
                                            echo "<span class=\"badge badge-primary\">$countAPCase</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/LMAPRStep1";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Write suo-Moto Report on NR Cases</td>

                                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/LMAPStep1" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>

                            </table>
                        </div>


                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">CITIZEN CENTRIC CERTIFICATE</p>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Verify Pending Application & Forward to CO</td>
                                    <td><?php
                                        if ($CitizenCentric != '0') {
                                            echo "<span class=\"badge badge-primary\">$CitizenCentric</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/CitizenController/LMStep1" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td>Write Report on AC to PP cases</td>
                                    <td><?php
                                        if ($allotment_lm != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_lm</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/Allotment/lmpending";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                
                                <tr>
                                    <td>Report on Correction Of Land Records as per Civil Court</td>
                                    <td><?php
//                                        if ($civil_appeal_basic != '0') {
//                                            echo "<span class=\"badge badge-primary\">$civil_appeal_basic</span>";
//                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/RecordCorrectionCivilCourt/LMFirstOrder";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>


                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Appeal Case U/S 147</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report U/S 147 Case</td>
                                    <td><?php
                                        if ($allotment_lm != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_lm</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/AppealCase/lmpending";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                        
                        
                    </div>
                </div>
                
                        
                         <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Government Land Updation</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                  <tr>
                                    <td>Write Report on Settlement to PP cases</td>
                                    <td><?php
                                        $settlement_first=0;
                                        if ($settlement_first != '0') {
                                           echo "<span class=\"badge badge-primary\">$settlement_first</span>";
                                       }
                                        ?>
                                    </td>
                                    <?php
                                   $link = base_url() . "index.php/Settlement/lmpending";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                               
                                <tr>
                                    <td>Write Report on AP to PP cases</td>
                                    <td><?php
                                        $ap_first=0;
                                        if ($ap_first != '0') {
                                            echo "<span class=\"badge badge-primary\">$ap_first</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/Settlement/lmpendingAp";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            
                              <tr>
                                    <td colspan="2">Grant to PP</td>
                                    <td><a href="<?php echo base_url() . 'index.php/Settlement/indexGrant' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                              
                            </table>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">MISCELLANEOUS & FIELD VISITS DATA</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on Miscellaneous Cases</td>
                                    <td><?php
                                        $countMiscCase = count($countMiscCase);
                                        if ($countMiscCase != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCase</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/LMStep1' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                

                                <tr>
                                    <td>Write Proposal for Land Reclassification </td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/LandReclassification/LMlocationSelect' ?>" class="text-danger msg_reclass" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Modification of Chitha Report</td>
                                    <td>&nbsp;</td>
                                    <td><a href="<?php echo base_url() . 'index.php/LmEntryChitha/menulm' ?>" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
       </div> 
        <?php
        $change_password = $my_info->first_login;
        if ($change_password == 'N'):
            ?> 
            <?php include 'first_login.php'; ?>
        <?php endif; ?>
<script>
    $(function () {
        $('.msg').click(function (e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function (e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>

