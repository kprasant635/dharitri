
<div class="modal" role="dialog" id="paymentNoticeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="w3review" style="font-weight: bold">Final Amount(Rs.)</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span id="html_final_amt"><?=$prem->final_amount?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="w3review" style="font-weight: bold">Due Amount(Rs.)</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span id="html_final_amt"><?=$prem->due_amount?></span>
                            </div>

                            <input type="hidden" class="form-control" id="due_amount" value="<?=$prem->due_amount?>">
                            <input type="hidden" class="form-control" id="final_amount" value="<?=$prem->final_amount?>">
                            <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm" id="closePremModal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="generatePaymentNotice">Generate Payment Notice</button>
            </div>
        </div>
    </div>
</div>

<div id="payment_notice_render"></div>

<script type="text/javascript">

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

    $(document).ready(function(){
        $('#paymentNoticeModal').modal('show');
    });

    $("#closePremModal").on('click', function(){
        $('#paymentNoticeModal').modal('hide');
    });

    $('#generatePaymentNotice').on('click', function()
    {
        var final_amount   = $('#final_amount').val();
        var due_amount     = $('#due_amount').val();
        var case_no_notice = $('#case_no_notice').val();

        if(final_amount == null || final_amount == '')
        {
            alert("Final Amount can not be empty !!! ");
            return false;
        }
        if(due_amount == null || due_amount == '')
        {
            alert("Due Amount can not be empty !!! ");
            return false;
        }
        else if(case_no_notice == null || case_no_notice == '')
        {
            alert("Manipulation done with case no !!! ");
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        
        const params = {
            final_amount   : final_amount,
            due_amount     : due_amount,
            case_no_notice : case_no_notice,
        };

        $.ajax({
            url  : baseurl + "ReclassSuiteControllerCO/generatePaymentNotice",
            type : "post",
            data : params,
            success: function (data) {
                $.unblockUI();
                $('#paymentNoticeModal').modal('hide');
                $('#payment_notice_render').html(data);
            },
        });
    });

</script>