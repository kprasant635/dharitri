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

                <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
				
                <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay" id="field_mutation_conv_div">
                        
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                 <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">OFFICE MUTATION / CONV</td>
                                    <td></td>
                                </tr>
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
                                <tr>
                                    <td>Reverted From CO</td>
                                    <td><?php
                                        if ($revert_from_co != '0') {
                                            echo "<span class=\"badge badge-primary\">$revert_from_co</span>";
                                        }
                                        ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/lmmutation/getPendingCORevertCases" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								<tr class="hide">
                                    <td></td>
                                    <td><?php
                                        if ($freshreport != '0') {
                                            echo "<span class=\"badge badge-primary\">$freshreport</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="#" style="float:right">view</a></td>
                                </tr>
								<tr class="hide">
                                    <td></td>
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