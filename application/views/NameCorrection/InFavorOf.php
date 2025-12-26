<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 style="text-align: center;"><?php echo $this->lang->line('in_favor_of_details'); ?></h2>
            <hr style="border-bottom: 2px solid #000;">
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('case_no'); ?> : <?php echo $misc_case_no = $this->session->userdata('misc_case_no'); ?> </div>
            <div class="col-lg-4 uni_text center"></div>
            <div class="col-lg-4 uni_text"><span style="float:right;"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></span></div>
            <hr style="border-bottom: 2px solid #000;">
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-bottom: 10px" method="POST" action="<?php echo base_url(); ?>index.php/NameCorrection/InFavorOf_save">

                    <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php
                            }
                            ?>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label hide"><?php echo $this->lang->line('sl_no'); ?> *</label>
                        <div class="col-lg-4 hide">
                            <input type="text" class="form-control" name='infavor_of_id' readonly="readonly" value="<?php echo ($inFavID + 1); ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?> *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_no" readonly="readonly" value="<?php echo $miscCaseInfo->misc_case_no; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_date'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_ref_let_no" value="<?php echo date('d-m-Y'); ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                        <div class="col-lg-4">
                            <input type="hidden" name='patta_type_code' value="<?php echo $this->session->userdata('patta_type_code'); ?>" >
                            <input type="text" class="form-control" name='name_for' value="<?php echo $landType->patta_type; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                        <div class="col-lg-4" >
                            <input type="text" class="form-control" name='patta_no' value="<?php echo $miscCaseInfo->patta_no; ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infavor_of_name" value="<?php echo $miscCaseInfo->dag_no; ?>" />
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <h2><mark><?php echo $this->lang->line('petitioner_info'); ?></mark></h2>
                    <table class="table table-condensed">
                        <tr>
                            <td class="danger center" width='50%'>Existing Name</td>
                            <td class="success center" width='50%'>Corrected Name</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('pattadar_name'); ?> </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="infavor_of_name" value="<?php echo $pdarinfo->pdar_name; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-6 control-label"><?php echo $this->lang->line('corrected_name'); ?> </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="infavor_of_corrected_name" value="<?php echo $info->petition_pdar_name_new; ?>" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="form-group hide">
                        <label class="col-lg-2 control-label"><?php echo $this->lang->line('relation'); ?> </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infav_of_guar_relation" value="<?php echo $pdarinfo->pdar_guard_reln; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('in_favor_of_guardian_name'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infavor_of_guardian" value="<?php echo $pdarinfo->pdar_father; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('address1'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infavor_of_add1" value="<?php echo $pdarinfo->pdar_add1; ?>" />
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('address2'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infavor_of_add2" value="<?php echo $pdarinfo->pdar_add2; ?>" />
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <center>
                        <button type="formsubmit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button> 
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
