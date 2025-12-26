<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('application_detail_description'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                            <table class='table table-bordered unicode'>
                                <tr>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                    <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $conv_type; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to_the_officer'); ?> : <?php echo $addressed_to; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($date_entry)); ?></label></td>
                                </tr>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                            <table class="table table-bordered  unicode">
                                <thead>
                                    <tr>
                                        <th><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td><label class="control-label"><?php echo $dag_no; ?></label></td>
                                    <td><label class="control-label"><?php echo $m_dag_area_b . " বিঘা " . $m_dag_area_k . " কঠা " . $m_dag_area_lc . " লেছা " ?></label></td>
                                    <td class="center"><label class="control-label"><?php echo $patta_no; ?></label></td>
                                    <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                                    <td class="center">
                                        <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=0"; ?>" target="_blank">
                                            <button type="submit" class="btn btn-md uni_text"><span class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></span></button>
                                        </a>
                                    </td>
                                    <td class="center">
                                        <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=0"; ?>" target="_blank">
                                            <button type="submit" class="btn btn-md uni_text"><span class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></span></button>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                            <table class='table table-bordered  unicode'>
                                <thead>
                                    <tr>
                                        <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                    </tr>
                                </thead>
                                <?php
                                foreach ($pattadarx as $p):
                                    ?>
                                    <tr>
                                        <td><label class="control-label"><?php echo $p['pdar_cron_no']; ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pdar_name']; ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pdar_guardian']; ?></label></td>
                                        <td><label class="control-label"><?php echo $this->ASTofficeConversionModel->getRelationName($p['pdar_rel_guar']); ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pdar_add1'] . " " . $p['pdar_add2']; ?></label></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-sm-6" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                <p class="uni_text" style="color: #990000;">পুৰণা দাগত আবেদনকাৰীৰ মাটি বাকী থাকিব নেকি ? : <?php echo $availibility; ?></p>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/save_create_rasidOnFullConv"; ?>" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;তথ্য গ্ৰহণ কৰক আৰ ৰচিদ জাৰি কৰক |</a>
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