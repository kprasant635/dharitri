<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/RTPSCaseDetails/SummaryExcel" id="myForm"
    enctype="multipart/form-data">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $this->lang->line('select_land_location'); ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="dist_code" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('district'); ?></label>
                    <div class="col-lg-4">
                        <input type="hidden" name="dist_code" class="districtselect"
                            value="<?php echo $dist_code; ?>" />
                        <input type="text" name="dist" class="form-control " readonly="readonly"
                            value="<?php echo $dist[0]->district; ?>" />
                    </div>
                    <label for="subdiv_code" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('subdivision'); ?></label>
                    <div class="col-lg-4">
                        <input type="hidden" name="subdiv_code" class="subdivselect"
                            value="<?php echo $subdiv_code ?>" />
                        <input type="text" name="subd" class="form-control " readonly="readonly"
                            value="<?php echo $subdiv[0]->subdiv; ?>" />

                    </div>
                </div>

                <div class="form-group">
                    <label for="cir_code" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('circle'); ?></label>
                    <div class="col-lg-4">
                        <input type="hidden" name="circle_code" class="circleselect"
                            value="<?php echo $cir_code ?>" />

                        <input type="text" name="cir" class="form-control " readonly="readonly"
                            value="<?php echo $circle[0]->circle; ?>" />

                    </div>
                    
                <?php /* ?>
                    <label for="mouza_code" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('mouza'); ?></label>
                    <div class="col-lg-4">
                        <select class="form-control mouzaselect" id="mouza_code" required name="mouza_code">
                            <option value=""><?php echo $this->lang->line('select_mouza'); ?>
                            </option>
                            <?php foreach ($mouzalist as $m) { ?>
                                <option value="<?php echo $m->mouza_code; ?>"><?php echo $m->mouza; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                <?php */ ?>
                </div>
                <?php /* ?>
                <div class="form-group">
                    <label for="lot_no" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('lot_no'); ?></label>
                    <div class="col-lg-4">
                        <select class="form-control lotselect" id="lot_no" required name="lot_no">
                            <option value=""><?php echo $this->lang->line('select_lot_no'); ?>
                            </option>
                        </select>

                    </div>
                    <label for="vill_code" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('vill_town'); ?></label>
                    <div class="col-lg-4">
                        <select class="form-control villageselect" id="vill_code" required name="vill_code">
                            <option value=""><?php echo $this->lang->line('select_vill_town'); ?>
                            </option>
                        </select>
                        <?php echo form_error('vill_code', '<p class="red">', '</p>'); ?>
                    </div>
                </div>
                <?php */ ?>
            </div>
        </div>
    </div>

    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Date Range<br>
                </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <!-- Date From -->
                    <label for="date_from" class="col-lg-2 control-label">Date From</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control" name="date_from" id="date_from">
                    </div>

                    <!-- Date To -->
                    <label for="date_to" class="col-lg-2 control-label">Date To</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control" name="date_to" id="date_to">
                    </div>
                </div>
            </div>

        </div>
    </div>




    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-footer">
                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-4">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary"
                            onclick="showForm()"><i
                                class='fa fa-check'></i>Download</button>
                        <a href="<?php echo base_url(); ?>index.php/home/index"
                            class="btn btn-md btn-danger"> <i class="fa fa-arrow-left"></i>&nbsp;
                            <?php echo $this->lang->line('back_to_main_menu'); ?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
/* 
?>
<div class="col-lg-10 col-lg-offset-1">
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">
                Total number of cases<br>
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered" width="100%" id="CaseCOuntTable">
                <thead>
                    <th>Received</th>
                    <th>Pending</th>
                    <th>Delivered</th>
                    <th>Rejected</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
*/
?>


