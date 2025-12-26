<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Legacy Data Updation / Rectification	 Menu</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Utility Menu 
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <span class="glyphicon glyphicon-link" aria-hidden="true" style='color: blue;'></span>&nbsp;&nbsp;<a class="red" href="<?php echo base_url(); ?>application/views/img/SOP1-ILRMS-RectificationLegacyData.docx" download>Download SOP for Legacy Updation</a>
                        </div>
                        <h2><mark>Rectification Of</mark></h2>
                        <center>
                            <table class="table table-condensed">
                                <?php
                                $user_code = $this->session->userdata('user_desig_code');
                                if ($user_code == 'LM') {
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo base_url() . 'index.php/LegacyDataUpdation/LMlocationSelect' ?>" class="text-danger">Basic Dag details in Chitha & Jamabandi (Like Patta Type, Patta Number, Land Area, Revenue, Local Tax, Land Class,Pattadar Strike/Unstrike &nbsp;&nbsp;&nbsp;>> <?php echo $this->lang->line('go') ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>Dag Numbers containing (ক,খ, Dot, Space, any unwanted characters etc.) &nbsp;&nbsp;&nbsp;>> <a href="<?php echo base_url() . 'index.php/Utility/get_all_junk_dags' ?>" class="text-danger"><?php echo $this->lang->line('go') ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>Chitha & Jamabandi Edit Entry Module &nbsp;&nbsp;&nbsp;>> <a href="<?php echo base_url() . 'index.php/JamaEditEntry' ?>" class="text-danger"><?php echo $this->lang->line('go') ?></a></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>Chitha & Jamabandi  Dag Compare for mismatch according to Patta &nbsp;&nbsp;&nbsp;>> <a href="<?php echo base_url() . 'index.php/Chithajama' ?>" class="text-danger"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <?php
                                    $r_pen = '';
                                    $p_pen = '';
                                    $d_pen = '';
                                    $legacy_pen = '';
                                    if($remark->r){
                                        $r_pen = "<span class='badge badge-primary'>" . $remark->r . "</span>";
                                    }
                                    if($pattadar->p){
                                        $p_pen = "<span class='badge badge-primary'>" . $pattadar->p . "</span>";
                                    }
                                    if($dag->d){
                                        $d_pen = "<span class='badge badge-primary'>" . $dag->d . "</span>";
                                    }
                                    if($legacy_data_update_fp->c){
                                        $legacy_pen = "<span class='badge badge-primary'>" . $legacy_data_update_fp->c . "</span>";
                                    }
                                ?>

                                <tr>
                                    <td>Updation / Modification for Jamabandi Remark(s) &nbsp;&nbsp;&nbsp;>> <?php echo  $r_pen ?> <a href="<?php echo base_url() . 'index.php/JamaEditEntry/editremark' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Updation / Modification for Chitha & Jamabandi Pattadar Edit &nbsp;&nbsp;&nbsp;>> <?php echo  $p_pen ?> <a href="<?php echo base_url() . 'index.php/JamaEditEntry/editpattadar' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Removal of Dag(s) from Jamabandi &nbsp;&nbsp;&nbsp;>> <?php echo  $d_pen ?> <a href="<?php echo base_url() . 'index.php/JamaEditEntry/dageditlist' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <?php
                                if ($user_code == 'CO') {
                                    ?>
                                    <tr>
                                        <td>Pending Legacy Data Updation &nbsp;&nbsp;&nbsp;>> <?php echo  $legacy_pen ?> <a href="<?php echo base_url() . 'index.php/LegacyDataUpdation/GoToRE?pro=1' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                    </tr>
									<tr>
                                        <td><sup><span class="badge badge-danger blink_me">New</span></sup>  Updation of Serial Number in Jamabandi &nbsp;&nbsp;&nbsp;>>  <a href="<?php echo base_url() . 'index.php/utility/modifyserial' ?>" class="text-danger"> <?php echo $this->lang->line('go') ?></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($user_code == 'DC') || ($user_code == 'ADC')) {
                                    $legacy_data_update_dc = "<span class='badge badge-primary'>" . $legacy_data_update_dc->f . "</span>";
                                    ?>
                                    <tr>
                                        <td>Pending Legacy Data Updation &nbsp;&nbsp;&nbsp;>> <?php echo  $legacy_data_update_dc ?> <a href="<?php echo base_url() . 'index.php/LegacyDataUpdation/GoToRE?pro=2' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <table class="table table-condensed">
                                <?php
                                if ($user_code == 'CO') {
                                    ?>
                                    <tr>
                                        <td>Report on changed Legacy data &nbsp;&nbsp;&nbsp;>> <a href="<?php echo base_url() . 'index.php/LegacyDataUpdation/ReportCo' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                    </tr>
                                    <?php
                                } elseif($user_code == 'LM') {
                                    ?>
                                    <tr>
                                        <td>Report on changed Legacy data &nbsp;&nbsp;&nbsp;>> <a href="<?php echo base_url() . 'index.php/LegacyDataUpdation/ReportLm' ?>" class="text-danger"><?php echo $this->lang->line('view') ?></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                        </table>
                        </center>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-5">
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
