<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Allotment Pending Revert Cases
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?> / Refference No</label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label">Next Date Of Hearing</label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            </thead>

                            <?php 

                            foreach ($cases as $case): ?>
                                <tr>
                                    <td>
                                        <?=$case->case_no?><br>
                                        <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                    </td>
                                    <td class="center">
                                        <?=$this->utilityclass->getDistrictName($case->dist_code)?>
                                    </td>
                                    <td class="center">
                                        <p class='text-success'> <i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->next_date_hearing)); ?></p>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-block btn-primary" 
                                        href="<?=base_url()?>index.php/Allotment/writeRevertReport?case_no=<?=enc_param('case_no', $case->case_no, 600)?>"><i class="fa fa-pencil"></i>&nbsp;Write Report</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" 
                                class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

