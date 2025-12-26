<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm text-center">
                    <h2>Legacy Data Updation / Rectification Menu</h2>
                </div>
            </div>

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Utility Menu</h3>
                    </div>

                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info">
                            <span class="glyphicon glyphicon-link" style="color: blue;"></span>&nbsp;&nbsp;
                            <a class="red" href="<?= base_url('application/views/img/SOP1-ILRMS-RectificationLegacyData.docx') ?>" download>
                                Download SOP for Legacy Updation
                            </a>
                        </div>

                        <h2><mark>Rectification Of</mark></h2>

                        <center>
                            <table class="table table-condensed">
                                <?php
                                $user_code = $this->session->userdata('user_desig_code');

                                // Helper function for badges
                                function showBadge($count) {
                                    return !empty($count) ? "<span class='badge badge-primary'>{$count}</span>" : '';
                                }

                                // Badge variables
                                $r_pen      = showBadge($remark->r ?? 0);
                                $p_pen      = showBadge($pattadar->p ?? 0);
                                $d_pen      = showBadge($dag->d ?? 0);
                                $legacy_pen = showBadge($legacy_data_update_fp->c ?? 0);
                                $legacy_dc  = showBadge($legacy_data_update_dc->f ?? 0);
                                ?>

                                <?php if ($user_code === 'LM'): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('index.php/LegacyDataUpdation/LMlocationSelect') ?>" class="text-danger">
                                                Basic Dag details in Chitha & Jamabandi (Like Patta Type, Patta Number, Land Area, Revenue, Local Tax, Land Class, Pattadar Strike/Unstrike)
                                                &nbsp;&nbsp;&nbsp;>> <?= $this->lang->line('go') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($user_code === 'LM'): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('index.php/LegacyDataUpdation/GoToRE?pro=3') ?>">
                                                Legacy Data Updation Revert Case from CO &nbsp;&nbsp;&nbsp;>> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($user_code === 'LM' || $user_code === 'CO'): ?>

                                    <tr>
                                        <td>
                                            Dag Numbers containing (ক, খ, Dot, Space, any unwanted characters etc.)
                                            &nbsp;&nbsp;&nbsp;>> <a href="<?= base_url('index.php/Utility/get_all_junk_dags') ?>" class="text-danger">
                                            <?= $this->lang->line('go') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($user_code === 'LM'): ?>

                                    <tr>
                                        <td>
                                            Chitha & Jamabandi Edit Entry Module &nbsp;&nbsp;&nbsp;>> 
                                            <a href="<?= base_url('index.php/JamaEditEntry') ?>" class="text-danger">
                                            <?= $this->lang->line('go') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            

                                <tr>
                                    <td>
                                        Chitha & Jamabandi Dag Compare for mismatch according to Patta
                                        &nbsp;&nbsp;&nbsp;>> 
                                        <a href="<?= base_url('index.php/Chithajama') ?>" class="text-danger"><?= $this->lang->line('go') ?></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Updation / Modification for Jamabandi Remark(s)
                                        &nbsp;&nbsp;&nbsp;>> <?= $r_pen ?> 
                                        <a href="<?= base_url('index.php/JamaEditEntry/editremark') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Updation / Modification for Chitha & Jamabandi Pattadar Edit
                                        &nbsp;&nbsp;&nbsp;>> <?= $p_pen ?> 
                                        <a href="<?= base_url('index.php/JamaEditEntry/editpattadar') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Removal of Dag(s) from Jamabandi &nbsp;&nbsp;&nbsp;>> <?= $d_pen ?>
                                        <a href="<?= base_url('index.php/JamaEditEntry/dageditlist') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                    </td>
                                </tr>

                                <?php if (in_array($user_code, ['LM', 'CO', 'ADC'])): ?>
                                    <tr>
                                        <td>
                                            Pattadar Guardian Name Correction &nbsp;&nbsp;&nbsp;>> 
                                            <a href="<?php
                                                if ($user_code === 'LM') echo base_url('index.php/CorrectionController/index');
                                                elseif ($user_code === 'CO') echo base_url('index.php/CorrectionController/listCOCorrections');
                                                else echo base_url('index.php/CorrectionController/listADCCorrections');
                                            ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($user_code === 'CO'): ?>
                                    <tr>
                                        <td>
                                            Pending Legacy Data Updation &nbsp;&nbsp;&nbsp;>> <?= $legacy_pen ?>
                                            <a href="<?= base_url('index.php/LegacyDataUpdation/coLegacy') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <sup><span class="badge badge-danger blink_me">New</span></sup>
                                            Updation of Serial Number in Jamabandi
                                            &nbsp;&nbsp;&nbsp;>>
                                            <a href="<?= base_url('index.php/utility/modifyserial') ?>" class="text-danger"><?= $this->lang->line('go') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if (in_array($user_code, ['DC', 'ADC'])): ?>
                                    <tr>
                                        <td>
                                            Pending Legacy Data Updation &nbsp;&nbsp;&nbsp;>> <?= $legacy_dc ?>
                                            <a href="<?= base_url('index.php/LegacyDataUpdation/GoToRE?pro=2') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>

                            <hr style="border-bottom: 2px solid #000;">

                            <table class="table table-condensed">
                                <?php if ($user_code === 'CO'): ?>
                                    <tr>
                                        <td>Report on changed Legacy data &nbsp;&nbsp;&nbsp;>>
                                            <a href="<?= base_url('index.php/LegacyDataUpdation/ReportCo') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                        </td>
                                    </tr>
                                <?php elseif ($user_code === 'LM'): ?>
                                    <tr>
                                        <td>Report on changed Legacy data &nbsp;&nbsp;&nbsp;>>
                                            <a href="<?= base_url('index.php/LegacyDataUpdation/ReportLm') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if (in_array($user_code, ['CO', 'LM'])): ?>
                                    <tr>
                                        <td><?= MENU_NAME_15YEARS_REMARKS ?> &nbsp;&nbsp;&nbsp;>>
                                            <a href="<?= base_url('index.php/JamaRemarks/getRemarks15years') ?>" class="text-danger"><?= $this->lang->line('view') ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </center>

                        <hr style="border-bottom: 2px solid #000;">

                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-5">
                                <a href="<?= base_url('index.php/home/index') ?>" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?= $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>

                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </div>
        </div>
    </div>
</div>
