<div class="container-fluid form-top login">
    <div class="row">
        <div class="modal fade" id="myModalSave" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: #ccc">
                        <h1 class="modal-title">Please wait... We are saving the new case. Dont press any button or case will not be registered.</h1>
                    </div>
                    <hr>
                    <div class="modal-body">
                        <div id="spinner">
                            <img width="100%" src='<?php echo base_url() ?>application/views/images/ajax-loader.gif' alt="Loading" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
	<div id="savingcase"></div>
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Office Mutation Registration Form Details</h2>
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
                                    <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('transfer_type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $tranfer_type; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to'); ?>:<?php echo $addressed_to->username; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y'); ?></label></td>
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
                                    </tr>
                                </thead>
                                <?php foreach ($dags as $d): ?>
                                <tr>
                                    <td><label class="control-label"><?php echo $d['dag_no']; ?></label></td>
                                    <td><label class="control-label"><?php echo $d['m_dag_area_b'] . " বিঘা " . $d['m_dag_area_k'] . " কঠা " . $d['m_dag_area_lc'] . " লেছা " ?></label></td>
                                    <td class="center"><label class="control-label"><?php echo $patta_no; ?></label></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>                            
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                            <table class='table table-bordered  unicode'>
                                <thead>
                                    <tr>
                                        <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('applicants_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                    </tr>
                                </thead>
                                <?php $count = 1; ?>
                                <?php foreach ($petitioner as $p): ?>
                                    <tr>
                                        <td><label class="control-label"><?php echo $count++; ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pet_name']; ?></label></td>
                                        <td><label class="control-label"><?php echo $p['guard_name']; ?></label></td>
                                        <td><label class="control-label"><?php echo $this->utilityclass->get_relation($p['guard_rel']); ?></label></td>
                                        <td><label class="control-label"><?php echo $p['add1'] . " " . $p['add2']; ?></label></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <a href="<?php echo base_url() ?>index.php/officemutation/savePetition" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;তথ্য গ্ৰহণ কৰক আৰ ৰচিদ জাৰি কৰক |</a>
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