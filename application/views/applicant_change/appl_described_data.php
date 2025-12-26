<style type="text/css">
    input[type=text] {
        border: 1px solid #000;
    }
</style>

<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="<?=base_url().'index.php/ApplicantChangeController/dashboard'?>">
                <button type="button" class="btn btn-sm btn-danger pull-right go_back">Go Back</button>
            </a><br><hr>
        </div>

        
        <div class="col-lg-12 ">
            
            <div class="panel panel-info">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <!----- General Information ----->
                            <table class="table table-striped table-bordered text-bold">
                                <thead>
                                    <th style="background-color: #136a6f; color: #fff" colspan="4">General Information</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="15%">Service Name:</td>
                                        <td width="20%" class="text-red">
                                            <?=$this->utilityclass->getServiceName($basic->service_code)?>
                                        </td>
                                        <td width="15%">Case No:</td>
                                        <td width="20%" class="text-red">
                                            <?=$case_no?>
                                        </td>    
                                        <input type="hidden" value="<?=$this->ApplicantChangeModel->getBasuApplIdFromCaseNo($case_no)?>" id="appl_no">   
                                    </tr>

                                    <tr>
                                        <td>Submission Date:</td>
                                        <td class="text-red">
                                            <?=date('Y-m-d',strtotime($basic->submission_date))?>
                                        </td>
                                        <td>Patta No:</td>
                                        <td class="text-red">
                                            <?=$enc->patta_no?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Patta Type:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getPattaType($enc->patta_type_code)?>
                                        </td>
                                        <td>Dag No:</td>
                                        <td class="text-red">     
                                            <?=$enc->dag_no?>              
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>District:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getDistrictName($basic->dist_code)?>
                                        </td>
                                        <td>Subdivision:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getSubDivName($basic->dist_code, $basic->subdiv_code)?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Circle:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getCircleName($basic->dist_code, $basic->subdiv_code, $basic->cir_code)?>
                                        </td>
                                        <td>Mouza:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getMouzaName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code)?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lot:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getLotName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no)?>
                                        </td>
                                        <td>Village:</td>
                                        <td class="text-red">
                                            <?=$this->utilityclass->getVillageName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code)?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Applicant Address:</td>
                                        <td colspan="3" class="text-red">
                                            <?=$mainAppl->pdar_add1?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!----- Main Applicant Details ----->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th style="background-color: #136a6f; color: #fff" colspan="9">Applicant Details</th>
                                </thead>
                                <thead style="white-space:nowrap; width:100%">
                                    <tr class="text-bold table-success">
                                        <th>Applicant Name</th>
                                        <th>Guardian Name</th>
                                        <th>Relation</th>
                                        <th>Applied Area(B-K-L)</th>
                                        <th>Verified With</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-red">
                                        <td><?=$mainAppl->pdar_name?></td>
                                        <td><?=$mainAppl->pdar_guardian?></td>
                                        <td><?=$this->utilityclass->getrelationByID($mainAppl->pdar_rel_guar)?></td>
                                        <td><?=$enc->i_area_b.'-'.$enc->i_area_k.'-'.$enc->i_area_lc?></td>
                                        
                                        <td><?=$mainAppl->identity_type?></td>
                                        
                                    </tr>           
                                </tbody>
                            </table>


                            <!----- Joint Applicant Details ----->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th style="background-color: #136a6f; color: #fff" colspan="9">Joint Applicant Details</th>
                                </thead>
                                <thead style="white-space:nowrap; width:100%">
                                    <tr class="text-bold table-success">
                                        <th>#</th>
                                        <th>Applicant Name</th>
                                        <th>Guardian Name</th>
                                        <th>Relation</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    <?php 
                                        foreach($appl as $k=>$r) { 
                                            if($r->is_applicant==0) {
                                    ?>
                                        <tr class="text-red">
                                            <td><?=$k++?></td>
                                            <td><?=$r->pdar_name?></td>
                                            <td><?=$r->pdar_guardian?></td>
                                            <td><?=$this->utilityclass->getrelationByID($mainAppl->pdar_rel_guar)?></td>
                                        </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>

                            <hr>

                            

                            


                        </div>

                    </div>


                    <div class="row">
                        <div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label>Do you want to change the <span class="text-red">Main Applicant</span> ?</label> 
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input changes_required_yes" 
                                    type="radio" name="changes_required" value="1">
                                    <label class="form-check-label">YES</label>                  
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input changes_required_no" 
                                    type="radio" name="changes_required" value="0">
                                    <label class="form-check-label">NO</label>
                                </div>
                            </div> 
                        </div>                 

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                        <div class="div_is_main_appl" style="display:none">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label>Is Main Applicant from added Joint Applicant ? </label> 
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input is_joint_main_yes" 
                                    type="radio" name="is_joint_main" value="1">
                                    <label class="form-check-label">YES</label>                  
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input is_joint_main_no" 
                                    type="radio" name="is_joint_main" value="0">
                                    <label class="form-check-label">NO</label>
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <hr><button type="button" style="display:none;" class="btn btn-sm btn-info add_new_joint_applicant"><b>Add New Joint Applicant</b></button>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- <form method="post" action="<?php //base_url().'ApplicantChangedController/eKycVerification'?>" id="ekyc_form"> -->

<form method="post" action="https://basundhara.assam.gov.in/rtpsmb2demo/ApplicantChangedController/eKycVerification" id="ekyc_form">
    <input type="text" id="ekyc_enc" name="ekyc_enc" value="<?=$enc_case?>">
</form>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

    var base_url = "<?php echo base_url();?>";

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
            showCancelButton: true

        });
    }

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showCancelButton: true
        });
    }
    
    $('.changes_required_no').click(function()
    {
        Swal.fire({
            icon : 'warning',
            backdrop:true,
            allowOutsideClick: false,
            text: 'Are you sure, you don`t want to modify the main applicant detail ?',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {
                $('.div_is_main_appl').css('display','none');
                $("input[name='is_joint_main']").prop("checked", false);
                $('.add_new_joint_applicant').css('display','none');
                window.location = base_url+'index.php/ApplicantChangeController/dashboard';
            }
            else {
                $('.changes_required_yes').prop('checked', true);
                $('.changes_required_no').prop('checked', false);
                $('.div_is_main_appl').css('display','block');
                $("input[name='is_joint_main']").prop("checked", false);
                $('.add_new_joint_applicant').css('display','none');
            }
        });        
    });

    $('.changes_required_yes').click(function()
    {
        $('.div_is_main_appl').css('display','block');
        $("input[name='is_joint_main']").prop("checked", false);
        $('.add_new_joint_applicant').css('display','none');
    });

    $('.is_joint_main_yes').click(function()
    {                
        $('.add_new_joint_applicant').css('display','none');
    });

    $('.is_joint_main_no').click(function()
    {
        $('.add_new_joint_applicant').css('display','block');        
    });

    $('.add_new_joint_applicant').click(function()
    {
        const params = {
            appl_no : $('#appl_no').val(),
        };

        Swal.fire({
            icon : 'warning',
            backdrop:true,
            allowOutsideClick: false,
            text: 'You will be redirected for e-kyc verification of AADHAAR/PAN/DL. Are you sure to modify the main applicant detail ?',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) 
            {
                $('#ekyc_form').submit();
                // $.ajax({
                //     url: base_url+"index.php/ApplicantChangeController/eKycVerification",
                //     type: "post",
                //     dataType: "json",
                //     contentType: "application/json",
                //     success: function (data) {
                //         console.log(data);                        
                //     },error: function (err) {
                //         showErrorMessage("Some error occured for eKyc verification");
                //     },
                //     data: JSON.stringify(params)
                // });
            }
        });
    });

</script>

