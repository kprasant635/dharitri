<h5 class="reza-title" style="margin-top: 35px">
    <i class="fa fa-map" aria-hidden="true"></i> Area Details Village Wise

</h5>
<div class="tableCard" id="applicationArea">
    <div class="tree" >
        <table class="table table-bordered" style="font-weight: bold">
            <thead>
            <tr>
                <td style="width: 55%">Description</td>
                <td>Bigha</td>
                <td>Katha</td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>Chatak</td>
                    <td>Ganda</td>
                <?php else : ?>
                    <td>Lessa</td>
                <?php endif;?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Total Govt. area in this village </td>
                <td id="chithaBigha"></td>
                <td id="chithaKatha"></td>
                <td id="chithaLessa"></td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td id="chithaGanda"></td>
                <?php endif;?>
            </tr>
            <tr>
                <td>Total area in approved application </td>
                <td id="approveBigha"></td>
                <td id="approveKatha"></td>
                <td id="approveLessa"></td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td id="approveGanda"></td>
                <?php endif;?>
            </tr>
            <tr>
                <td>Total area in pending application (LM report submitted)</td>
                <td id="pendingBigha"></td>
                <td id="pendingKatha"></td>
                <td id="pendingLessa"></td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td id="pendingGanda"></td>
                <?php endif;?>
            </tr>
            <tr>
                <td>Total area in pending application (LM report not submitted)</td>
                <td id="lmPendingApiBigha"></td>
                <td id="lmPendingApiKatha"></td>
                <td id="lmPendingApiLessa"></td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td id="lmPendingApiGanda"></td>
                <?php endif;?>
            </tr>
            <tr style="color: #F44336; font-weight: bold">
                <td>Total minimum reserve area</td>
                <td><?php echo AREA_RESERVE_VILLAGE_WISE ?></td>
                <td>0</td>
                <td>0</td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>0</td>
                <?php endif;?>
            </tr>
            <tr style="color: #1B5E20; font-weight: bold">
                <td>Total remaining area in this village (If all the cases settled)</td>
                <td id="reamingBigha"></td>
                <td id="reamingKatha"></td>
                <td id="reamingLessa"></td>
                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td id="reamingGanda"></td>
                <?php endif;?>
            </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="row" style="display: none" id="messageShow">
    <br>
    <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
        Total minimum Reserve area could not less than  <?= AREA_RESERVE_VILLAGE_WISE ?> Bigha !
    </h5>
    <br>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12" align="right">
        <br>
        <button type="button" class="rezaButt viewVillageAreaDetails" id="viewVillageAreaDetails" style="background-color: #F44336; color: white">
            <i class="fa fa-spinner fa-spin"></i> Verify Area & Proceed
        </button>

    </div>
</div>

<!--<button type="button" class="rezaButt viewVillageAreaDetails" id="verifiedVillageAreaDetails" style="background-color: #4CAF50; display: none">-->
<!--    <i class="fa fa-check-square-o"></i> Verified-->
<!--</button>-->


<script>
    // Chitha/Approve/Applied area 15 bigha reaming calculation  for DC/ADC/SDO/CO/SK/LM

    $(document).ready(function ()
    {
        $('.rezaButt').hide();
        $('#viewVillageAreaDetails').show();
    });


    $(document).on('click','.viewVillageAreaDetails',function ()
    {
        $('.rezaButt').hide();

        var caseNo = $("#caseNo").val();
        if(caseNo == '')
        {
            showErrorMessage("There is some problem ! Kindly contact system administrator  !");
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        const applicant = {
            caseNo: caseNo
        };

        $.ajax({
            url: BASE_URL + "/SettlementCommonDc/getChithaApproveAppliedAppAreaCalculation",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2)
                {

                    $("#chithaBigha").html(data.chithaBigha);
                    $("#chithaKatha").html(data.chithaKatha);
                    $("#chithaLessa").html(data.chithaLessa);
                    $("#chithaGanda").html(data.chithaGanda);

                    $("#approveBigha").html(data.approveBigha);
                    $("#approveKatha").html(data.approveKatha);
                    $("#approveLessa").html(data.approveLessa);
                    $("#approveGanda").html(data.approveGanda);

                    $("#pendingBigha").html(data.pendingBigha);
                    $("#pendingKatha").html(data.pendingKatha);
                    $("#pendingLessa").html(data.pendingLessa);
                    $("#pendingGanda").html(data.pendingGanda);

                    $("#lmPendingApiBigha").html(data.lmPendingApiBigha);
                    $("#lmPendingApiKatha").html(data.lmPendingApiKatha);
                    $("#lmPendingApiLessa").html(data.lmPendingApiLessa);
                    $("#lmPendingApiGanda").html(data.lmPendingApiGanda);

                    $("#reamingBigha").html(data.reamingBigha);
                    $("#reamingKatha").html(data.reamingKatha);
                    $("#reamingLessa").html(data.reamingLessa);
                    $("#reamingGanda").html(data.reamingGanda);

                    if (data.process == 1)
                    {
                        $('.rezaButt').show();
                        $('#messageShow').hide();
                        $('#markAsSDLAC').show();
                        $('.generalNotice').show();
                        $('#viewVillageAreaDetails').hide();
                    }
                    else
                    {
                        $('#revertFromDcToCo').show();
                        $('#putUnderConsider').show();
                        $('.buttDanger').show();
                        $('#messageShow').show();
                        $('#markAsSDLAC').hide();
                        $('#approveByDc').hide();
                        $('#viewVillageAreaDetails').hide();
                        $('.generalNotice').hide();
                    }

                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            error: function(jqXHR, textStatus,errorThrown)
            {
                $.unblockUI();
                alert(textStatus);
            },
            data: JSON.stringify(applicant)

        });

    });
</script>