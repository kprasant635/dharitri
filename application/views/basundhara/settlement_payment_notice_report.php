<style>
    .btnReza{
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 15px;
        line-height: 1;
        color: #fff!important;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        background-color: #9C27B0;
    }
    .btnRezaNo{
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 15px;
        line-height: 1;
        color: black!important;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        background-color: #B0BEC5;
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <p class="uni_text">Total No. of Basundhara 2.0 Case(s) For Payment Notice in the District </p>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Circle</th>
                            <th>Total cases for payment notice</th>
                            <th>Payment Notice Pending </th>
                            <th>Payment Notice Generated</th>
                            <th>Payment Done</th>
                            <th>Swikriti Patra</th>
                            <th>Patta Delivered</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $ct=1; $tot=$tot_payment_notice=$tot_payment_notice_generated=$tot_payment_done=0;
                        foreach ($output as $key => $value) {
                            $tot += $value->total;
                            $tot_payment_notice += $value->payment_notice;
                            $tot_payment_notice_generated += $value->payment_notice_generated;
                            $tot_payment_done += $value->payment_done;
                            ?>
                            <tr>
                                <input type="hidden" name="dist_code" id="dist_code<?=$ct?>" value="<?=$value->dist_code;?>">
                                <input type="hidden" name="subdiv_code" id="subdiv_code<?=$ct?>" value="<?=$value->subdiv_code;?>">
                                <input type="hidden" name="cir_code" id="cir_code<?=$ct?>" value="<?=$value->cir_code;?>">
                                <td><?=$value->circle_name;?></td>
                                <td  class="text-right">
                                    <?php if($value->total == 0){
                                        echo $value->total;
                                    } else{ ?>
                                        <button type="button" onclick="find_applications('<?=$ct?>')" class="btn btn-primary btn-sm"><?=$value->total;?></button>
                                    <?php } ?>
                                </td>
                                <td  class="text-right"><?=$value->payment_notice;?></td>
                                <td  class="text-right"><?=$value->payment_notice_generated;?></td>
                                <td  class="text-right"><?=$value->payment_done;?></td>
                                <td  class="text-right">0</td>
                                <td  class="text-right">0</td>
                            </tr>
                            <?php $ct++;} ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th  class="text-right"><?=$tot;?></th>
                            <th  class="text-right"><?=$tot_payment_notice;?></th>
                            <th  class="text-right"><?=$tot_payment_notice_generated;?></th>
                            <th  class="text-right"><?=$tot_payment_done;?></th>
                            <th  class="text-right">0</th>
                            <th  class="text-right">0</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if($this->session->userdata('user_desig_code') == 'CO') : ?>
        <div class="col-lg-12" style="margin-top: 25px">
            <div class="row">
                <div class="card-body" style="background-color: white">
                    <p style="font-size: 18px;font-weight: bold">Total No. of Basundhara 2.0 Offer of Settlement  </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Circle</th>
                                <th>Village </th>
                                <th>Offer of Settlement</th>
                                <th>Total Paid</th>
                                <th>Fully Paid</th>
                                <th>Partial Paid</th>
                                <th>Chitha Update</th>
                                <th>Chitha Update (Full Payment)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td><?php echo $report->circle ?></td>
                                    <td><?php echo $report->village ?></td>
                                    <td><a type="button" class="btnRezaNo" ><?php echo $report->oos ?> </a></td>
                                    <td><a type="button" class="btnRezaNo" ><?php echo $report->premium_paid ?> </a></td>
                                    <td>
                                        <a type="button" target="report" class="btnReza" href="<?php echo base_url(); ?>index.php/basundhara2/villageWiseFullPaymentAppList/<?php echo $report->mouza_pargona_code; ?>/<?php echo $report->lot_no; ?>/<?php echo $report->vill_townprt_code; ?>">
                                            <?php echo $report->premium_paid_full ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a type="button" target="report" class="btnReza" href="<?php echo base_url(); ?>index.php/basundhara2/villageWisePartialPaymentAppList/<?php echo $report->mouza_pargona_code; ?>/<?php echo $report->lot_no; ?>/<?php echo $report->vill_townprt_code; ?>">
                                            <?php echo $report->premium_paid_partial ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a type="button" target="report" class="btnReza" href="<?php echo base_url(); ?>index.php/basundhara2/villageWiseChithaUpdateAppList/<?php echo $report->mouza_pargona_code; ?>/<?php echo $report->lot_no; ?>/<?php echo $report->vill_townprt_code; ?>">
                                            <?php echo $report->chitha_update ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a type="button" target="report" class="btnReza" href="<?php echo base_url(); ?>index.php/basundhara2/villageWiseChithaUpdateFullPayAppList/<?php echo $report->mouza_pargona_code; ?>/<?php echo $report->lot_no; ?>/<?php echo $report->vill_townprt_code; ?>">
                                            <?php echo $report->chitha_update_full ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>

<div class="modal  bs-example-modal-lg" id='myLargeModalLabelCaseList' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelCaseList">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            <div class="row text-right">
                <span class="edit-enc-close-new px-4"><button onclick="closeModalNew()" class="btn btn-danger"><i class="fa fa-times"></i></button></span>
            </div>
            <div class="modal-body">
                <div id="applicationList"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function closeModalNew(){
        $('#myLargeModalLabelCaseList').hide();
    }

</script>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    function find_applications(str){
        var dist_code = $("#dist_code"+str).val();
        var subdiv_code = $("#subdiv_code"+str).val();
        var cir_code = $("#cir_code"+str).val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: '<?= base_url()?>'+ "index.php/Basundhara2/getApplicationList",
            type: "POST",
            data : {dist_code : dist_code , subdiv_code : subdiv_code,cir_code : cir_code},
            error: function() {
                $.unblockUI();
                Swal.fire({
                    title: "Failed",
                    text: "Error",
                    icon: "warning",
                    timer: 50000
                });
            },

            success: function(data) {
                $.unblockUI();
                $('#myLargeModalLabelCaseList').show();
                $('#applicationList').html(data);
            }
        });
    }
</script>

