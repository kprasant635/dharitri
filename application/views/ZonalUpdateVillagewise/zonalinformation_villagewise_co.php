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
				
                   <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Villagewise Zonal Value Information/Updation</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Villagewise Pending Zonal Value Information </td>
                                    <td>
                                        <?php  if ($pendingcount != '0') {
                                            echo "<span class=\"badge badge-danger\">$pendingcount</span>";
                                        } ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/ZoneInformationController/getVillagewisePendingZonalInformation";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <!-- Newly Added -->

                                <tr>
                                    <td>Viilagewise Report </td>
                                    <td>

                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/ZonalByforcationController/zonalVillageVillageWise";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td> Zonal Details Missing Report <sup class="red">New</sup></td>
                                    <td>

                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/ZonalByforcationController/zonalDetailsVillageWiseReport";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
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