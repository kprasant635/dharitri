<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">List Of Pending Object Petition</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                       <h3 class="panel-title">
                            Pending objections
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no');?></label></th>
                            <th><label class="control-label"><?php echo $this->lang->line('registration_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('previous_case'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('registration_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            </thead>
                            <?php
                            $row = count($cases);
                            if ($row > 0) {
                            $c = 1;
                            foreach ($cases AS $case) 
                            {
                                //$type=$cases->mut_type;
                                ?>
                                <tr>
                                    <td class="center"><?php echo $case->objection_case_no; ?></td>
                                    <td><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($case->regist_date)); ?></td>
                                    <td><?php echo $case->prev_fm_ca_no; ?></td>
                                    <td><i class='fa fa-calendar'></i> Entry On <?php echo date('d/m/Y', strtotime($case->entry_date)); ?></td>
                                    <td>
                                        <a href="<?php echo base_url() . 'index.php/objection/FinalOrder' ?>?case_no=<?php echo $case->objection_case_no ?>" class="btn btn-primary"><?php echo $this->lang->line('write_report'); ?></a>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            }
                            } 
                            ?>
                        </table>
                        <center>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

