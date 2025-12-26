<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .buttSuccess {
        color: #FFF;
        background-color: #4CAF50;
    }

    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right">
                        <a class="rezaButt buttSuccess" href="<?php echo base_url(); ?>index.php/SettlementTenantDc/downloadBeneficiaryList/?case=<?php echo $case_no; ?>">
                            <i class="fa fa-download"></i> Download
                        </a>
                        <button class="rezaButt buttPrimary" id="updatePaymentStatus">
                            <i class="fa fa-inr"></i> Update Payment Status
                        </button>
                    </div>
                </div>
                <hr>
                <span>
                    <?php echo $this->lang->line('beneficiaryList') ?>
                    Under Case No - <?php echo $case_no; ?>
                </span>
            </div>

            <div class="reza-body">

                <?php if ($beneficiaryCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Name</th>
                            <th>PAN</th>
                            <th>Account No.</th>
                            <th>IFSC Code</th>
                            <th>Bank Name</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($beneficiary as $singleB):  $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td><?php echo $singleB->bene_name; ?></td>
                                <td><?php echo $singleB->bene_pan_no; ?></td>
                                <td><?php echo $singleB->bene_account_no; ?></td>
                                <td><?php echo $singleB->bene_ifsc; ?></td>
                                <td><?php echo $singleB->bene_bank_name; ?></td>
                                <td><?php echo $singleB->amount; ?></td>
                                <td>
                                    <?php if($singleB->payment_status == 1): ?>
                                        <i class="fa fa-check" style="color: #2E7D32"></i> <b style="color: #2E7D32">Paid</b>
                                    <?php else: ?>
                                        <i class="fa fa-spinner fa-spin"></i> <b style="color: #F44336">Pending</b>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>



        <!-- Modal Revert to co -->
        <div class="modal" role="dialog" id="updatePaymentStatusModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Update Payment Status</h5>
                    </div>
                    <div class="modal-body" align="center">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                                    <label class="form-group" style="font-weight: bold">Select Payment Status</label>
                                    <select name="payStatus" id="payStatus" class="form-select">
                                        <option value="1" selected>Paid</option>
                                        <option value="0">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  id="updatePaymentStatusModalNo">CLOSE</button>
                        <button type="button" class="btn btn-primary"   id="updatePaymentStatusModalYes">UPDATE</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<input type="hidden" id="caseNo" value="<?php echo $case_no; ?>">
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>


    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }


    // ****************************************************************
    // Revert Application From DC TO CO
    $(document).on('click','#updatePaymentStatus',function ()
    {
        $('#updatePaymentStatusModal').modal('show');
    });

    $(document).on('click','#updatePaymentStatusModalNo',function ()
    {
        $('#updatePaymentStatusModal').modal('hide');
    });

    $(document).on('click','#updatePaymentStatusModalYes',function ()
    {
        var case_no = $("#caseNo").val();
        var payStatus = $("#payStatus").val();

        if(caseNo != '')
        {
            const applicant = {
                case_no: case_no,
                payStatus: payStatus
            };

            $.ajax({
                url: BASE_URL + "/SettlementTenantDc/updateBeneficiaryPaymentStatus",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $('#updatePaymentStatusModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        showSuccessMessage("Application Successfully Reverted to CO");

                        window.location.reload();
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("SOMETHING WENT WRONG !");
        }
    });




</script>