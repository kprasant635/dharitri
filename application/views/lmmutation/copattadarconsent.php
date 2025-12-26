<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Co-Pattadar Consent For Partition
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            </thead>
                            <?php foreach($cases as $case):?>
                                <tr>
                                    <td><?php echo $case->case_no;?></td>
                                    <td class="center"><?php echo "Partition Case"; ?></td>
                                    <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                    <td class="center">
                                        <?php 
                                            $link = base_url()."index.php"."/lmmutation/takeconsent?case_no=".$case->case_no;
                                        ?>
                                        <a href='<?php echo $link;?>' class="btn btn-sm btn-success">
                                            <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('take_consent')?></a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index/" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>