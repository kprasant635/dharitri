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

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
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

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process > 
            Settlement MB3 > 
            <a href="<?= base_url()?>index.php/TeaGrantControllerDc/teaGrantDc">Tea Grant</a>


            <a href="<?= base_url()?>index.php/TeaGrantControllerDc/teaGrantDc">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>


        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span>Limited Conversion of Tea Grant Land to Periodic Patta</span>
                <?php if(CHITHA_DAG_FAG_KHAS_CASE_ADC_SDO == 1 && CHITHA_DAG_FLAG_DIST_CODE == trim($this->session->userdata("dist_code"))): ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 0px; margin-bottom: 10px">
                        <button class="rezaButt buttPrimary" id="chithaDagFlagUpdate">
                            <i class="fa fa-cog"></i> Update chitha dag flag
                        </button>
                    </div>
                <?php endif; ?>
                <hr>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Process Name</th>
                        <th>Total No. Case</th>
                        <th style="width: 200px; text-align:center!important;" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(DC_ADC_SDO_PRO_BUTTON == 0 OR DC_ADC_SDO_PRO_BUTTON == 1) { ?>
                        

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Report / Re-Report From ADC (Notice Generated)</td>
                            <td>
                                <?php
                                if ($generatedNoticeCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$generatedNoticeCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$generatedNoticeCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php //if(DISABLE_ALL_BUTTON == 0) { ?>
                                    <a class="rezaButt" href="<?php echo base_url() . 'index.php/TeaGrantControllerDc/viewAllGeneratedNoticeTeaGrantDcCaseList'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                <?php //} ?>
                            </td>
                        </tr>


                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Approved cases from Department</td>
                            <td>
                                <?php
                                if ($approveFromDept != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$approveFromDept</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$approveFromDept</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/TeaGrantControllerDc/viewAllDeptApprovalTeaGrantDcCaseList'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                        

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Reverted cases from Department</td>
                            <td>
                                <?php
                                if ($revertFromDept != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$revertFromDept</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$revertFromDept</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php //if(DISABLE_ALL_BUTTON == 0) { ?>
                                    <a class="rezaButt" href="<?php echo base_url() . 'index.php/TeaGrantControllerDc/viewAllDeptRevertToDcCaseList'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                <?php //} ?>
                            </td>
                        </tr>


                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Cases For Pull Back</td>
                            <td>

                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/TeaGrantControllerDc/pullBackCasesFromDepartmentForDCTea'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                        

                    <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- dag flag update  -->
<div class="modal" role="dialog" id="chithaDagFlagUpdateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to update chitha dag flag</h5>

                <input type="hidden" id="serviceType" value="><?php echo TEA_SERVICE_CODE ?>">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="chithaDagFlagUpdateModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="chithaDagFlagUpdateModalYes">Yes, Update</button>
            </div>
        </div>
    </div>
</div>

<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


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


    $(document).on('click','#chithaDagFlagUpdate',function ()
    {
        $('#chithaDagFlagUpdateModal').modal('show');
    });

    $(document).on('click','#chithaDagFlagUpdateModalNo',function ()
    {
        $('#chithaDagFlagUpdateModal').modal('hide');
    });

    $(document).on('click','#chithaDagFlagUpdateModalYes',function ()
    {
        var serviceCode   = $("#serviceType").val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        if(serviceCode != '')
        {
            const applicant = {
                serviceCode: serviceCode
            };

            $.ajax({
                url: BASE_URL + "/SettlementCommonDc/updateBulkChithaDagFlagCaseWise",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    $('#chithaDagFlagUpdateModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if (data.responseType == 2)
                    {
                        $('.buttPrimary').hide();
                        showSuccessMessage(data.message);
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
            $.unblockUI();
            showErrorMessage("SOMETHING WENT WRONG");
        }
    });

</script>


