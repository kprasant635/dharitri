<div class="row" style='margin-top:40px'>
    <?php
    $user_desig_code = $this->session->userdata('user_desig_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $user_code = $this->session->userdata('user_code');
    if ($user_desig_code == 'LM') {
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
        $name = $lm->lm_name;
    }
    ?>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="col-lg-12 ">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
            </div>
            <?php if($this->session->flashdata('message2')):?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message2');?></strong>
                </div>
            <?php endif;?>
        </div>

    <?php endif; ?>
    <div class="col-lg-5 col-lg-offset-1">
        <div class="panel casedisplay">

            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="2">KHATIAN</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">Pending Khatian
                         <badge class='badge badge-danger'>   <?= $count!=null?$count:0; ?></badge>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/Khatian/khatianListForCo' ?>" class="red" style="float:right">VIEW
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">View Khatian <sup class="red">New</sup></td>
                        <td><a href="<?php echo base_url() . 'index.php/Khatian/khatianViewForCo'; ?>" style="float:right">VIEW</a></td>
                    </tr>
                    <tr>
                        <td colspan="2">Update Khatian No. <sup class="red">New</sup></td>
                        <td><a href="<?php echo base_url() . 'index.php/Khatian/khatianSelectLocationForLmUpdt'; ?>" style="float:right">VIEW</a></td>
                    </tr>
                 
                    <tr>
                        <td colspan="2">Report</td>
                        <td><a href="<?php echo base_url() . 'index.php/Khatian/reportView'; ?>" style="float:right">VIEW</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>