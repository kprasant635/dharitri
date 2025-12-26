
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
                                <p class="regular">Suomoto Reclassification Cases</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <!--dp--->
                                <tr>
                                    <td>Notice Generation for suomoto reclass cases</td>
                                    <td>
                                        <?php
                                        if ($reclassbo != '0') {
                                            echo "<span class=\"badge badge-primary\">$reclassbo</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green "  href="<?php echo base_url() . 'index.php/SuomotoReclassification/getPendingReclassNoticeGeneration'; ?>" ><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Action taken report for suomoto reclass cases</td>
                                    <td>
                                        <?php
                                        if ($reclassactiontaken != '0') {
                                            echo "<span class=\"badge badge-primary\">$reclassactiontaken</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/SuomotoReclassification/getPendingreclassactionTakenReport'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Payment Notice for suomoto reclass cases</td>
                                    <td>
                                        <?php
                                        if ($reclaspaymentNotice != '0') {
                                            echo "<span class=\"badge badge-primary\">$reclaspaymentNotice</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/SuomotoReclassification/reclasPayment'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Payment Confirmation for suomoto reclass cases</td>
                                    <td>
                                        <?php
                                        if ($reclaspaymentConfirm != '0') {
                                            echo "<span class=\"badge badge-primary\">$reclaspaymentConfirm</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/SuomotoReclassification/reclasPaymentConfirm'; ?>"><?php echo $this->lang->line('view') ?></a></td>
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