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
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_mutation') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_fresh_order') ?></td>
                                    <td>
                                        <?php
                                        if ($mfirst_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$mfirst_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="pull-right green " href="<?php echo base_url() . 'index.php/coofficemutation/getPendingMutationCases?id=1'; ?>"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo $this->lang->line('co_next_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($msecond_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$msecond_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="pull-right green " href="<?php echo base_url() . 'index.php/coofficemutation/getPendingMutationCases?id=2'; ?>"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_resume_case') ?></td>
                                    <td></td>
                                    <td><a  class="pull-right green " href="#"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($proceedingMutRpt != '0') {
                                            echo "<span class=\"badge badge-primary\">$proceedingMutRpt</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right text-danger" href="<?php echo base_url() . 'index.php/coofficemutation/ActionTakenRpt'; ?>"><?php echo $this->lang->line('report') ?></a></td>
                                </tr>
                                <tr class="">
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <?php if(REVIVE_PARTICULAR_OMUT_CASE_ENABLE ==1 && $on == true){ ?>

                                    <tr>
                                        <td>Revive case list</td>
                                        <td>
                                            
                                        </td>
                                        <td><a class="pull-right text-danger" href="<?php echo base_url() . 'index.php/coofficemutation/ViewReviveList?id=2'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="3">&nbsp;</td>
                                    </tr>

                                <?php } ?>
                                
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