    <?php $enAppNo = $this->utilityclass->encryptJwtCase($basic->case_no);?>
    <form>
        <input type="hidden" id="appNo" name="appNo" value="<?php echo $enAppNo ?>">
        <input type="hidden" id="forwardTo" name="forwardTo" value="NA">
        <input type="hidden" id="remarks" name="remarks" value="NA">
        <br>

        <?php if($areaCheck == 1): ?>
            <div class="row">
                <div style="font-weight: bold; font-size: 18px; color: #B71C1C; margin-bottom: 15px">
                    Applied Area more than Chitha Area !
                </div>
            </div>
        <?php elseif($areaCheck == 2): ?>
            <div class="row">
                <div style="font-weight: bold; font-size: 18px; color: #B71C1C; margin-bottom: 15px">
                    Applied Area Cannot be Zero !
                </div>
            </div>
        <?php elseif($areaCheck == 0): ?>
            <?php if($notice == 1 ): ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 40px; margin-bottom: 15px">

                        <a href="<?php echo base_url()?>index.php/RelinquishmentDcController/printRelinquishmentNotice?case=<?php echo $enAppNo; ?>"
                           target="_blank" class="rezaButt buttCust">
                            <i class="fa fa-print"></i> &nbsp;Print Notice
                        </a>

                        <button type="button" class="rezaButt buttInfo" id="reGenerateNotice">
                            <i class="fa fa-refresh"></i> &nbsp;Re-Generate Notice
                        </button>

                        <button type="button" class="rezaButt buttPrimary" id="forwardToFinalOrder">
                            <i class="fa fa-paper-plane-o"></i> &nbsp;Forward to Final Order
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </form>




<script>

    // Re Generate Notice
    $(document).on('click','#reGenerateNotice',function ()
    {
        $('#reGenerateNoticeModal').modal('show');
    });

    $(document).on('click','#reGenerateNoticeModalNo',function ()
    {
        $('#reGenerateNoticeModal').modal('hide');
    });
    $(document).on('click','#reGenerateNoticeModalYes',function ()
    {
        let x = $("#hearingDateRe").val();

        if (x === "")
        {
            alert("Hearing date needs to be selected.");
            $("#hearingDateRe").focus();
            return false;
        }
        else
        {
            $('#reGenerateNoticeModal').modal('hide');
            return true;
        }

    });



    // Forwarded to Final Order
    $(document).on('click','#forwardToFinalOrder',function ()
    {
        $('#forwardToFinalOrderModal').modal('show');
    });

    $(document).on('click','#forwardToFinalOrderModalNo',function ()
    {
        $('#forwardToFinalOrderModal').modal('hide');
    });

    $(document).on('click','#forwardToFinalOrderModalYes',function ()
    {
        let x = $("#signedNotice").val();
        let y = $("#finalRemarks").val();

        if (x === "")
        {
            alert("Hearing Document needs to be uploaded !");
            $("#signedNotice").focus();
            return false;
        }
        if (y === "")
        {
            alert("Hearing Remarks needs to be entered !");
            $("#finalRemarks").focus();
            return false;
        }
        else
        {
            if (confirm("Are you sure you want to forward this application to Final Order?"))
            {
                $('#forwardToFinalOrderForm').submit();
            }
        }

    });


</script>
