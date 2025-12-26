<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('notice_generated_by_asst_misc_cases_name_correction');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr>
                                <th><?php echo $this->lang->line('sl_no');?></th>
                                <th>
                                   <?php echo $this->lang->line('case_no');?>)
                                </th>
                                <th>
                                    <?php echo $this->lang->line('type');?>
                                </th>
                                <th>
                                    <?php echo $this->lang->line('submission_date');?>
                                </th>
                                <th>
                                    <?php echo $this->lang->line('notice_generate');?>
                                </th>
                            </tr>
                            <?php
                            $row = count($MisCases);
                            if ($row > 0) {
                                $c = 1;
                                foreach ($MisCases AS $cases) {
                                    ?>
                                    <tr class="text-center">
                                        <td><?php echo $c; ?></td>
                                        <td><?php echo $cases->misc_case_no; ?></td>
                                        <td><?php $type=$cases->misc_case_type;
                                        if($type==06){
                                            echo "নাম সংশোধন";
                                        }
                                        elseif ($type==07) {
                                            echo "নাম কৰ্ত্তন";
                                        }
                                        ?>
                                        </td>
                                        <td><?php echo date("d-m-Y", strtotime($cases->submission_date)); ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . "index.php/NameCancellation/ASTNoticeGenerate1"; ?>?misc_case_no=<?php echo $cases->misc_case_no; ?>&p=<?=$cases->misc_case_petition_no;?>" class="btn btn-primary">
                                                <?php echo $this->lang->line('notice_generate');?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $c++;
                                }
                            } else {
                                ?>
                                <tr class="text-center">
                                    <td colspan="5" style="color: red;">No Cases<br/>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                            <i class="fa fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

