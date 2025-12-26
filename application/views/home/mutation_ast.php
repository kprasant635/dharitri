<div class="row" style='margin-top:40px'>
<!-- <!-- <?php
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
	 -->			

 
                <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
           
                <div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"> <?php echo $this->lang->line('asstt_ofc_mutation'); ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <?php if(RTPS_CERT_ON_OFF!='1'){ ?>
                                <tr>
                                    <td colspan="2"><?php echo $this->lang->line('astt_ofc_mutation_reg'); ?></td>
                                    <td><a href="<?php echo base_url() . 'index.php/officemutation/registermutation' ?>" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_noticegeneration_concerparty'); ?></td>
                                    <td>
                                        <?php
                                        if ($pnotice != '0') {
                                            echo "<span class=\"badge badge-primary\">$pnotice</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green "  href="<?php echo base_url() . 'index.php/officemutation/getPendingNoticeGeneration'; ?>" ><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt'); ?></td>
                                    <td>
                                        <?php
                                        if ($pactiontaken != '0') {
                                            echo "<span class=\"badge badge-primary\">$pactiontaken</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/officemutation/getPendingactionTakenReport'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Suo-Moto Registration of Mutation Case(s)</td>
                                    <td>
                                        <?php
                                        if ($sronotepen != '0') {
                                            echo "<span class=\"badge badge-primary\">$sronotepen</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/officemutation/Suomotodeed'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Regenerate Old Notice's</td>
                                    <td>    
                                    </td>
                                    <td><a class="pull-right text-danger" href="<?php echo base_url() . 'index.php/partition/mut_old_notice'; ?>">Regenerate</a></td>
                                </tr>
                                <tr>
                                    <td>Register New Office Mutation Application from Online Services</td>
                                    <td>
                                        <?php
                                        if ($CountMutationOnline != '0') {
                                            echo "<span class=\"badge badge-primary\">$CountMutationOnline</span>";
                                        }
                                        ?>
                                    </td>
                                    <td> <a href="<?php echo base_url() . 'index.php/serviceplus/office_mutation_cases'; ?>" class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
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