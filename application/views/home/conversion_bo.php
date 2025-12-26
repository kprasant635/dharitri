
<!-- <?php
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
?> -->
				
                <div class="col-lg-6 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_conversion') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Branch Officer Report On Conversion Cases</td>
                                    <td><?php
                                        if ($bo_notice != '0') {
                                            echo "<span class=\"badge badge-primary\">$bo_notice</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/GoToBo?pro=5"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_clear') ?></td>
                                    <td><?php
                                        if ($premium != '0') {
                                            echo "<span class=\"badge badge-primary\">$premium</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/GoToBo?pro=3"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_confirm') ?></td>
                                    <td><?php
                                        if ($payment != '0') {
                                            echo "<span class=\"badge badge-primary\">$payment</span>";
                                        }
                                        ?>
                                    </td>
                                    <td ><a class="pull-right green " href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/GoToBo?pro=4"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <!--<tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt') ?></td>
                                    <td><?php
                                        if ($cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$cases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/GoToBo?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>-->
                                <tr>
                                    <td colspan="2">Regenerate Old Notice's</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/regenerate_notice" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                            </table>
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