<!-- Sweet Alert Link -->
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Sweetalert Link End -->
<style>
    body {
        padding-right: 0 !important
    }

    article {
        height: 200px;
        display: none;
    }

    article.on {
        display: block;
    }

    body {
        padding-right: 0 !important
    }
</style>


<div class="well well-sm mis_report">
    <h5 style="text-align: center;">
        VillageWise Zonal Information :: Circle <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code); ?>
    </h5>

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>

<center>
    <div class="panel-body mb-2">
        <input type="radio" id="radioTab1" name="tab" checked>
        <label for="radioTab1" class="mr-4" style="text-transform: uppercase;">Pending Zonal Info <i class="fa fa-clock-o" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab2" name="tab">
        <label for="radioTab2" class="mr-4" style="text-transform: uppercase;">Approved Zonal Info <i class="fas fa-check-double" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab3" name="tab">
        <label for="radioTab3" class="mr-4" style="text-transform: uppercase;">Revert Back to LM <i class="fa fa-undo" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab4" name="tab">
        <label for="radioTab4" class="mr-4" style="text-transform: uppercase;">Reverted by ADC <i class="fa fa-undo" aria-hidden="true"></i></label>
    </div>
</center>

<article>
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">VillageWise Pending Zonal Information</h3>
            </div>
            <div class="panel-body">
                <?php if ($this->session->userdata('message')) : ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><?php
                                echo $this->session->userdata('message');
                                $this->session->unset_userdata('message');
                                ?>
                    </div>
                <?php endif; ?>
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Village Name</label></th>
                        <th scope="col" class="center"><label class="control-label">View Details</label></th>
                        <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($getpendingdetails as $details) :  ?>
                            <tr>
                                <td class="center"><?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_code']) ?></td>
                                <td class="center">
                                    <button class="btn btn-secondary btn-sm" onclick="viewPendingZoneDetailsForm('<?= $details['unique_village_code'] ?>')">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        View Pending Details
                                    </button>
                                </td>

                                <td class="center">
                                    <button type="button" value="<?= $details['unique_village_code'] ?>" class="btn btn-sm btn-success confirm-approve"><i class="fa fa-check"></i> Approve</button>
                                    <a data-toggle='modal' data-target="#zonalReUpdateModal" data-villname="<?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_code']) ?>" data-villcode="<?= $details['unique_village_code'] ?>" ; class='btn btn-warning btn-sm zonaleditor'><i class='fa fa-undo'></i> Revert To LM</a>
                                    <button type="button" value="<?= $details['unique_village_code'] ?>" class="btn btn-sm btn-danger confirm-reject"><i class="fa fa-close"></i> Reject</button>
                                    <!-- New Edit Button for CO -->

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>

<!-- Approved  -->

<article>
    <div class="col-lg-12">
        <div class="panel panel-success panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">VillageWise Approved Zonal Information</h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableApprovedCo' width="100%">
                    <thead>
                        <th scope="col" class="center" width="20%"><label class="control-label">Village Name</label></th>
                        <th scope="col" class="center" width="20%"><label class="control-label">View Details</label></th>
                        <th scope="col" class="center" width="60%"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($getapproveddetails as $details) :  ?>
                            <tr>
                                <td class="center"><?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_code']) ?></td>
                                <td class="center">
                                    <button class="btn btn-secondary btn-sm" onclick="viewZoneDetailsForm('<?= $details['unique_village_code'] ?>')">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        View Approved Details
                                    </button>
                                </td>

                                <td class="center">
                                    <!-- New Edit Button for CO -->
                                    <button class="btn btn-primary btn-sm" onclick="editZonalDetailsCo('<?= $details['unique_village_code'] ?>' , '<?= $this->utilityclass->getMouzaName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code']) ?>', '<?= $this->utilityclass->getLotName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no']) ?>', '<?= $this->utilityclass->getVillageNameByUUIDEng($details['unique_village_code']) ?>')">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Edit & Reapprove <i class='fas fa-check-double'></i>
                                    </button>

                                    <button class="btn btn-success btn-sm" onclick="addMissingSubclassCo('<?= $details['unique_village_code'] ?>' , '<?= $this->utilityclass->getMouzaName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code']) ?>', '<?= $this->utilityclass->getLotName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no']) ?>', '<?= $this->utilityclass->getVillageNameByUUIDEng($details['unique_village_code']) ?>', '<?= $details['dist_code'] ?>', '<?= $details['subdiv_code'] ?>',  '<?= $details['cir_code'] ?>', '<?= $details['mouza_pargona_code'] ?>', '<?= $details['lot_no'] ?>','<?= $details['vill_code'] ?>')">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Validate Subclass
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>

<!-- Reverted -->

<article>
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-danger panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">VillageWise Reverted Zonal Information</h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableRevertedCo' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Village Name</label></th>
                        <th scope="col" class="center"><label class="control-label">Status</label></th>
                        <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($getreverteddetails as $details) :  ?>
                            <tr>
                                <td class="center"><?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_code']) ?></td>
                                <td class="center">
                                    <button class="btn btn-secondary btn-sm" onclick="viewRevertedZoneDetailsForm('<?= $details['unique_village_code'] ?>')">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        View Reverted Details
                                    </button>
                                </td>

                                <td class="center">
                                    <!-- New Edit Button for CO -->

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>

<!-- Zonal Value Details Reveerted by ADC to CO -->
<article>
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-danger panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">Reverted Zonal Details by ADC</h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableRevertedFromADC' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Village Name</label></th>
                        <th scope="col" class="center"><label class="control-label">View Details</label></th>
                        <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($revertedByAdc as $details) :  ?>
                            <tr>
                                <td class="center"><?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_code']) ?></td>
                                <td class="center">
                                    <span class="text-danger">Reverted by ADC</span>
                                </td>

                                <td class="center">
                                    <!-- New Edit Button for CO -->
                                    <button class="btn btn-primary btn-sm" onclick="editRevertedDetailsAdcCo('<?= $details['unique_village_code'] ?>' , '<?= $this->utilityclass->getMouzaName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code']) ?>', '<?= $this->utilityclass->getLotName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no']) ?>', '<?= $this->utilityclass->getVillageNameByUUIDEng($details['unique_village_code']) ?>')">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Edit & Sent to ADC <i class='fas fa-check-double'></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>


<!-- Modal for Zonal Details Revert Remarks by LM -->
<div class="modal fade" id="zonalReUpdateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-success">
                <h6 class="modal-title w-100">
                    Revert Back Zonal Information
                    Village Name:
                    <span id="zv_update_vill_name_header"></span>
                </h6>
            </div>
            <form id="zonalReUpdateForm" name="zonalReUpdateForm" method="POST" action="">
                <div class="modal-body">
                    <input type='hidden' name="vill_code_reverted" id='villReverted'>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Revert Remarks:</label>
                        <textarea class="form-control" rows="3" name="revert_remarks" id="revert_remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-revert_to_lm" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Zonal Details Revert Remarks by LM  End-->

<!-- Radio Button Alter Tab Function Start -->
<script>
    $('[name=tab]').each(function(i, d) {
        var p = $(this).prop('checked');
        //   console.log(p);
        if (p) {
            $('article').eq(i)
                .addClass('on');
        }
    });

    $('[name=tab]').on('change', function() {
        var p = $(this).prop('checked');
        var i = $('[name=tab]').index(this);

        $('article').removeClass('on');
        $('article').eq(i).addClass('on');
    });
</script>
<!-- Radio Button Alter Function End -->

<!-- Data Table Configuration -->
<script>
    $(document).on('click', '.zonaleditor', function() {
        $('#zv_update_vill_name_header').text($(this).data('villname'))
        $('#zv_update_dag_no_header').text($(this).data('villcode'))
        $('#villReverted').val($(this).data('villcode'))
    });
    $(document).ready(function() {

        $('#datatableApprovedCo').DataTable({
            "pageLength": 10,
            "order": [0, "asc"]
        });
        $('#datatableRevertedCo').DataTable({
            "pageLength": 10,
            "order": [0, "asc"]
        });

        $('#datatableRevertedFromADC').DataTable({
            "pageLength": 10,
            "order": [0, "asc"]
        });

        $('#datatable').DataTable({
            "pageLength": 20,
            "order": [1, "asc"],
            "autoWidth": false,
            "deferRender": true,
            "drawCallback": function() {

                // Reert Back to LM  by CO

                // Revert to LM

                $('#btn-revert_to_lm').on('click', function(e) {
                    e.preventDefault();
                    var form = $('form');
                    Swal.fire({
                        title: "Do you want to Revert the Zonal Information to LM?",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Save",
                        denyButtonText: `Don't save`,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            // var vill_code = $(this).val();
                            var vill_code = $("#villReverted").val();
                            var revert_remarks = $("#revert_remarks").val();
                            $.ajax({
                                url: '<?php echo base_url() . "index.php/ZoneInformationController/VillageWiseRevert/" ?>' + vill_code,
                                type: "POST",
                                dataType: "json",
                                data: {
                                    revert_remarks: revert_remarks,
                                },
                                success: function(data) {
                                    if (data.responseType == 1) {
                                        showErrorMessage(data.message);
                                    } else if (data.responseType == 2) {
                                        showSuccessMessage(data.message);
                                        // location.reload();
                                    } else if (data.responseType == 3) {
                                        showWarningMessage(data.message);
                                    } else {
                                        showErrorMessage("SOMETHING WENT WRONG");
                                    }
                                },
                            });
                        } else if (result.isDenied) {
                            Swal.fire("Changes are not saved", "", "info");
                        }
                    });
                });

                // Approve Village Zonal Details  by CO
                $(".confirm-approve").click(function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Approve!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // var revert_remarks = $("#revert_remarks").val();
                            var vill_code = $(this).val();
                            $.ajax({
                                url: '<?php echo base_url() . "index.php/ZoneInformationController/approve_Villagewise_zonaldetails/" ?>' + vill_code,
                                type: "POST",

                                error: function() {
                                    Swal.fire({
                                        title: "Failed",
                                        text: "Zonal Information Not Updated..",
                                        type: "warning",
                                        timer: 50000
                                    });
                                },
                                success: function(data) {
                                    window.location.reload(true);
                                    console.log(data.success);
                                    Swal.fire(
                                        "Approved",
                                        "Zonal Information Approved  successfully",
                                        "success",
                                    );
                                },

                            });
                        }
                    })
                });

                // Reject Village Zonal Details  by CO
                $(".confirm-reject").click(function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Reject!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var vill_code = $(this).val();
                            $.ajax({
                                url: '<?php echo base_url() . "index.php/ZoneInformationController/reject_Villagewise_zonaldetails/" ?>' + vill_code,
                                type: "POST",
                                dataType: "json",
                                success: function(data) {
                                    if (data.responseType == 1) {
                                        showErrorMessage(data.message);
                                    } else if (data.responseType == 2) {
                                        showSuccessMessage(data.message);
                                        // location.reload();
                                    } else if (data.responseType == 3) {
                                        showWarningMessage(data.message);
                                    } else {
                                        showErrorMessage("SOMETHING WENT WRONG");
                                    }
                                },
                                error: function() {
                                    Swal.fire('Changes are not saved', '', 'warning')
                                },
                            });
                        }
                    })
                });
            }
        });
    });
</script>


<script>
    // Fetch Zonal Details Data in Modal 
    $(document).on('click', '.viewZonalinfo', function() {
        $('#vill_name_header').text($(this).data('villname'))
        $('#villCodeview').val($(this).data('villcode'))
    })
</script>

<?php include 'village_wise_zonal_details_view_form.php'; ?>

<?php include 'zonal_details_edit_form_co.php';
?>

<?php include 'zonal_details_missing_form_co.php'; ?>

<?php include 'zonal_details_reverted_edit_form_co.php'; ?>


<script src="<?php echo base_url(); ?>application/views/js/zonal_details/zonal_details.js"></script>

<script>
    // Success Message
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });
        location.reload();
    }

    // Error Message
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

    // Warning Message
    function showWarningMessage(text) {
        swal.fire({
            // title: "Error!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    // view Pending Zonal Details
    function viewPendingZoneDetailsForm(unique_village_code) {
        $('#zd_view_form_vill_code').val(unique_village_code);
        var formdata = $('#zone_details_view_form').serialize();
        $.ajax({
            url: baseurl + "ZoneInformationController/getPendingVillageZoneDetails",
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(data) {
                // $.unblockUI();   
                $('#zd_view_viill_code_header').text(unique_village_code);
                $('#indivisual_view_details_table tbody').empty();
                for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                    var div = $("<tr />");
                    div.html(GetDynamicTextBoxForView(i));
                    $("#TextBoxContainerViewForm").append(div);
                    $('#view_zone_name_' + i).val(data.villagewise_zone_info[i].zone_name);
                    $('#view_subclass_name_' + i).val(data.villagewise_zone_info[i].subclass_name);
                    $('#view_land_rate_' + i).val(data.villagewise_zone_info[i].land_rate);
                }
                const modal = $('#zone_details_view_modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                modal.fadeIn('slow').modal('show')
            },
            error: function(jqXHR, exception) {
                // $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }


    // view Reverted Zonal Details

    function viewRevertedZoneDetailsForm(unique_village_code) {
        $('#zd_view_form_vill_code').val(unique_village_code);
        var formdata = $('#zone_details_view_form').serialize();
        $.ajax({
            url: baseurl + "ZoneInformationController/getRevertedVillageZoneDetails",
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(data) {
                // $.unblockUI();   
                $('#zd_view_viill_code_header').text(unique_village_code);
                $('#indivisual_view_details_table tbody').empty();
                for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                    var div = $("<tr />");
                    div.html(GetDynamicTextBoxForView(i));
                    $("#TextBoxContainerViewForm").append(div);
                    $('#view_zone_name_' + i).val(data.villagewise_zone_info[i].zone_name);
                    $('#view_subclass_name_' + i).val(data.villagewise_zone_info[i].subclass_name);
                    $('#view_land_rate_' + i).val(data.villagewise_zone_info[i].land_rate);
                }
                const modal = $('#zone_details_view_modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                modal.fadeIn('slow').modal('show')
            },
            error: function(jqXHR, exception) {
                // $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }


    //Missing

    function addMissingSubclassCo(unique_village_code, mouza_name_co, lot_name_co, unique_village_name, dist_code_co, subdiv_code_co, cir_code_co, mouza_code_co, lot_no_co, vill_code_co) {
        $('#zd_missing_form_vill_code_co').val(unique_village_code);
        var formdata = $('#zonal_details_missing_form_co').serialize();
        $.ajax({
            url: baseurl + "ZoneInformationController/getMissingZoneDetailsCo",
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(data) {
                // $.unblockUI();   
                $('#zd_missing_form_dist_code_co').val(dist_code_co);
                $('#zd_missing_form_subdiv_code_co').val(subdiv_code_co);
                $('#zd_missing_form_cir_code_co').val(cir_code_co);
                $('#zd_missing_form_mouza_code_co').val(mouza_code_co);
                $('#zd_missing_form_lot_no_co').val(lot_no_co);
                $('#zd_missing_form_vill_townprt_co').val(vill_code_co);
                $('#village_name_header_co').text(unique_village_name);
                $('#mouza_name_header_co_1').text(mouza_name_co);
                $('#lot_name_header_co_1').text(lot_name_co);
                $('#village_name_header_co_1').text(unique_village_name);

                $('#zonal_details_missing_table tbody').empty();
                for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                    var div = $("<tr />");
                    div.html(GetDynamicTextBoxForMissingCo(i));
                    $("#TextBoxContainerMissingFormCo").append(div);
                    $('#missing_zone_code_co_' + i).val(data.villagewise_zone_info[i].zone_code);
                    $('#missing_subclass_code_co_' + i).val(data.villagewise_zone_info[i].subclass_code);
                    $('#missing_zone_name_co_' + i).val(data.villagewise_zone_info[i].zone_name);
                    $('#missing_subclass_name_co_' + i).val(data.villagewise_zone_info[i].subclass_name);

                    $('#missing_zone_name_title_' + i).val(data.villagewise_zone_info[i].zone_name);
                    $('#missing_subclass_name_title_' + i).val(data.villagewise_zone_info[i].subclass_name);
                    $('#missing_land_rate_co_' + i).val(data.villagewise_zone_info[i].land_rate);
                }
                const modal = $('#zonal_details_missing_modal_co').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                modal.fadeIn('slow').modal('show')
            },
            error: function(jqXHR, exception) {
                // $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }

    //dynamic text fileds for zonal Details Edit view 
    function GetDynamicTextBoxForMissingCo(count) {
        var row =
            '<input id ="missing_zone_code_co_' + count + '" name = "missing_zone_code_co[]"   type="hidden" value = "" class="form-control text-primary" />' +
            '<input id ="missing_subclass_code_co_' + count + '" name = "missing_subclass_code_co[]"   type="hidden" value = "" class="form-control text-primary" />' +
            '<input id ="missing_zone_name_co_' + count + '" name = "missing_zone_name_co[]"   type="hidden" value = "" class="form-control text-primary" />' +
            '<input id ="missing_subclass_name_co_' + count + '" name = "missing_subclass_name_co[]"  type="hidden" value = "" class="form-control text-primary" />' +

            '<td><input id ="missing_zone_name_title_' + count + '" name = "missing_zone_name_title_[]"   type="text" disabled value = "" class="form-control text-primary" /></td>' +
            '<td><input id ="missing_subclass_name_title_' + count + '" name = "missing_subclass_name_title_[]"  type="text" disabled value = "" class="form-control text-primary" /></td>' +
            '<td><input id ="missing_land_rate_co_' + count + '" name = "missing_land_rate_co[]"  type="number" min ="0" value = "" maxlength="15" class="form-control numberonly" placeholder="Enter Zonal Value" /></td>'
        return row;
    }


    function zonal_details_missing_modal_co_close() {
        $('#zonal_details_missing_modal_co').fadeOut('slow').modal('hide');
        document.getElementById("zonal_details_missing_form_co").reset();
    }


    // Update by CO Method
    function zonal_details_missing_form_co_submit() {
        event.preventDefault();
        var rowCount = $('#zonal_details_missing_table tr').length - 1;
        $('#no_of_rows_missing_form').val(rowCount);
        var formdata = $('#zonal_details_missing_form_co').serialize();
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to Add Thsese Zone Subclass Combination!",
            icon: 'info',
            // html: '<p class="text-danger">*** Zonal Value Sent for </p>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Add!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "ZoneInformationController/addMissingZonalCombinationCO",
                    type: "POST",
                    data: formdata,
                    dataType: "json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            showSuccessMessage(data.message);
                            $('#zonal_details_missing_modal_co').fadeOut('slow').modal('hide');
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })


    }


    // Zonal Details Edit Modal CO End
    function editRevertedDetailsAdcCo(unique_village_code, mouza_name_co, lot_name_co, unique_village_name) {
        $('#zd_edit_form_vill_code_co_reverted').val(unique_village_code);
        var formdata = $('#zonal_details_edit_form_co_reverted').serialize();
        $.ajax({
            url: baseurl + "ZoneInformationController/getRevertedDetailsForEditAdcCo",
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(data) {
                // $.unblockUI();   
                $('#mouza_name_header_co_reverted').text(mouza_name_co);
                $('#lot_name_header_co_reverted').text(lot_name_co);
                $('#village_name_header_co_reverted').text(unique_village_name);

                $('#zonal_details_edit_table_reverted tbody').empty();
                for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                    var div = $("<tr />");
                    div.html(GetDynamicTextBoxForEditCoReverted(i));
                    $("#TextBoxContainerEditFormCoReverted").append(div);
                    $('#edit_villagewise_zonal_id_reverted_' + i).val(data.villagewise_zone_info[i].id);
                    $('#edit_zone_name_co_reverted_' + i).val(data.villagewise_zone_info[i].zone_name);
                    $('#edit_subclass_name_co_reverted_' + i).val(data.villagewise_zone_info[i].subclass_name);
                    $('#edit_land_rate_lm_reverted_' + i).val(data.villagewise_zone_info[i].land_rate);
                    $('#edit_land_rate_co_reverted_' + i).val(data.villagewise_zone_info[i].temp_land_rate);
                }
                const modal = $('#zonal_details_edit_modal_co_reverted').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                modal.fadeIn('slow').modal('show')
            },
            error: function(jqXHR, exception) {
                // $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }



    //dynamic text fileds for zonal Details Edit view 
    function GetDynamicTextBoxForEditCoReverted(count) {
        var row = '<input id ="edit_villagewise_zonal_id_reverted_' + count + '" name = "edit_villagewise_zonal_id_reverted[]"   type="hidden" value = "" class="form-control text-danger" style="font-weight: bold;" />' +
            '<td><input id ="edit_zone_name_co_reverted_' + count + '" name = "edit_zone_name_co_reverted[]"  disabled type="text" value = "" class="form-control text-danger" style="font-weight: bold;" /></td>' +
            '<td><input id ="edit_subclass_name_co_reverted_' + count + '" name = "edit_subclass_name_co_reverted[]" disabled type="text" value = "" class="form-control text-danger" style="font-weight: bold;" /></td>' +
            '<td><input id ="edit_land_rate_lm_reverted_' + count + '" name = "edit_land_rate_lm_reverted[]" disabled  type="number" value = "" maxlength="15" class="form-control numberonly" placeholder="Enter Zonal Value" /></td>' +
            '<td><input id ="edit_land_rate_co_reverted_' + count + '" name = "edit_land_rate_co_reverted[]"   type="number" value = "" maxlength="15" min="0" class="form-control numberonly" placeholder="Enter Zonal Value" /></td>'
        return row;
    }


    function zonal_details_edit_modal_co_reverted_close() {
        $('#zonal_details_edit_modal_co_reverted').fadeOut('slow').modal('hide');
        document.getElementById("zonal_details_edit_form_co_reverted").reset();
    }


    //Submit 
    function zonal_details_update_form_co_reverted_submit() {
        event.preventDefault();
        var rowCountReverted = $('#zonal_details_edit_table_reverted tr').length - 1;
        $('#no_of_rows_update_form_reverted').val(rowCountReverted);
        var formdataReverted = $('#zonal_details_edit_form_co_reverted').serialize();
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to Update these Zonal Value!",
            icon: 'info',
            // html: '<p class="text-danger">*** Zonal Value edited by CO will be sent to ADC for approval</p>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "ZoneInformationController/zonalInformationUpdateRevertedADCCO",
                    type: "POST",
                    data: formdataReverted,
                    dataType: "json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            showSuccessMessage(data.message);
                            $('#zonal_details_edit_modal_co_reverted').fadeOut('slow').modal('hide');
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }
</script>