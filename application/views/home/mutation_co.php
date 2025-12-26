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
				<?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php"); } ?>
                   <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('co_field_mut_part') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_fmut'); ?> </td>
                                    <td>
                                        <?php
                                        if ($fmutation != '0') {
                                            echo "<span class=\"badge badge-primary\">$fmutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/cofieldmutation/getPendingFMCases";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_fpart'); ?> </td>
                                    <td>
                                        <?php
                                        if ($fpartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$fpartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/cofieldmutation/getPendingpartitionCases";
                                    ?>
                                    <td><a class="pull-right green"  href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class="">
                                    <td>Field Partition</td>
                                    <td>
                                        <?php
                                        echo "<span class=\"badge badge-primary\">$map_partition</span>";
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/cofieldmutation/pendingmaps' ?>" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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