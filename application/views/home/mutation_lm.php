<div class="row" style='margin-top:40px'>
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
}
if ($user_desig_code == 'SK') {
    $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
    $name = $sk->username;
}
?>  
				<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
                
                <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">FIELD MUTATION / PARTITION</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <?php if(RTPS_CERT_ON_OFF!='1'){ ?>
                                    <td colspan="2">Write Report on Field Mutation/Partition</td>
                                    <td>
                                    <a href="<?php echo base_url() . 'index.php/lmmutation/mutation' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                                    </td>
                                <?php }?>
                                </tr>
                                <?php if(ESCALATION_ENABLE == 1){ ?>
                                    <tr>
                                    <td>Field Mutation Cases First Proceeding</td>
                                    <td><?php
                                        if ($fmutation_case != '0') {
                                            echo "<span class=\"badge badge-primary\">$fmutation_case</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/cofieldmutation/getPendingFieldMutationCases' ?>" class="green " style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Field Partition Cases First Proceeding</td>
                                    <td><?php
                                        if ($fpartition_case != '0') {
                                            echo "<span class=\"badge badge-primary\">$fpartition_case</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/cofieldmutation/getPendingPartitionCasesLMend' ?>" class="green " style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <?php } ?>
                                
                     
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
                                <tr class="">
                                    <td>Reverted Back from CO <sup class="red">New</sup></td>
                                    <td><?php
                                        if ($reverted != '0') {
                                            echo "<span class=\"badge badge-primary\">$reverted</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/revertedcases'; ?>" style="float:right">view</a></td>
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
               
</div>

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