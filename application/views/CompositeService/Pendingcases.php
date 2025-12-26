<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Composite Service
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
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases'
                               width="100%">
                            <thead>
                            <th><label class="control-label">NOC No</label></th>
                            <th class="center"><label
                                        class="control-label">
                                    Location</label></th>
                            <th class="center"><label
                                        class="control-label">Due Date</label>
                            </th>
                            <th class="center"><label
                                        class="control-label">View</label>
                            </th>
                            </thead>

                            <?php foreach ($cases as $case): ?>
                            <?php $date=date('Y-m-d');
                            if($case->noc_no == null and $case->hearingdt>=$date){ ?>
                            <tr>
                                <td><?= $case->appno ?></td>
                                <td class="center">
                                    Circle Name: <?=  $this->utilityclass->getCircleName($case->distcode,$case->subcode,$case->circode); ?>
                                </td>
                                <td class="center">
                                    <p class='text-success'>
                                        <i class='fa fa-calendar'></i>
                                        Hearing Date: <?= $case->hearingdt ?>
                                    </p>
                                </td>
                                <td class="center">
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/CompositeService/viewPendingCase?noc_no=<?php echo enc_param('case_no', $case->appno, 600); ?>">
                                        View</a>
                                </td>
                            </tr>
                            <?php }else if($case->noc_no != null and ($case->notice_generated_yn == null || $case->notice_served_yn==null)){?>

                                <tr>
                                <td><?= $case->appno ?></td>
                                <td class="center">
                                    Circle Name: <?=  $this->utilityclass->getCircleName($case->distcode,$case->subcode,$case->circode); ?>
                                </td>
                                <td class="center">
                                    <p class='text-success'>
                                        <i class='fa fa-calendar'></i>
                                        Hearing Date: <?= $case->hearingdt ?>
                                    </p>
                                </td>
                                <td class="center">
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/CompositeService/issueNotice?case_no=<?php echo enc_param('case_no', $case->case_no, 600)?>&dist_code=<?php echo $case->dist_code;?>&subdiv_code=<?php echo $case->subdiv_code?>&cir_code=<?php echo $case->cir_code?>&mouza_pargona_code=<?php echo $case->mouza_pargona_code?>&lot_no=<?php echo $case->lot_no?>&vill_townprt_code=<?php echo $case->vill_townprt_code;?>">
                                        Print Notice</a>
                                </td>
                               
                            </tr>
                                <?php }else if($case->noc_no == null and $case->hearingdt<$date){?>
                                    <tr>
                                <td><?= $case->appno ?></td>
                                <td class="center">
                                    Circle Name: <?=  $this->utilityclass->getCircleName($case->distcode,$case->subcode,$case->circode); ?>
                                </td>
                                <td class="center">
                                    <p class='text-success'>
                                        <i class='fa fa-calendar'></i>
                                        Hearing Date: <?= $case->hearingdt ?>
                                    </p>
                                </td>
                                <td class="center">
                                    <p class='text-danger'>
                                        Notice Hearing date is over.Send to CO for new hearing date.It would be available in NOC
                                    </p>
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/CompositeService/sendCO?appno=<?php echo $case->appno?>&distcode=<?php echo $case->distcode;?>&subcode=<?php echo $case->subcode?>&circode=<?php echo $case->circode?>&hearingdt=<?php echo $case->hearingdt?>">
                                        Send to CO</a>
                                </td>
                               
                            </tr>
                                <?php }else{?>
                            

                            <?php }?>
                            <?php endforeach; ?>
                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
