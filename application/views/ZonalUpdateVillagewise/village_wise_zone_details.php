<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Radio Navigation -->
<style>
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
<center>
    <div class="panel panel-success panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">
                Village Name :
                <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>
                ||
                Village Type :
                <?php if ($this->utilityclass->getVillageType($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select) == 'U') : ?>
                    Urban
                <?php elseif ($this->utilityclass->getVillageType($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select) == 'R') : ?>
                    Rural
                <?php endif; ?>
                <input type='hidden' name="village_selected" value="<?php echo $select ?>">
            </h3>
        </div>
    </div>
    <div class="panel-body mb-2">
        <input type="radio" id="radioTab1" name="tab" checked>
        <label for="radioTab1" class="mr-4">Zonal Details Pending List(Village Wise)</label>
        <input type="radio" id="radioTab2" name="tab" hidden>
        <label for="radioTab2" class="mr-4"></label>
        <input type="radio" id="radioTab3" name="tab">
        <label for="radioTab3" class="mr-4">Revert Back from CO</label>
    </div>
</center>


<article>
    <!-- Pending Zonal Details -->
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Pending Zonal Information
                    <input type='hidden' name="village_selected" value="<?php echo $select ?>">
                </h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' class="display nowrap" id='datatable-pending' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Zone Name</label></th>
                        <th scope="col" class="center"><label class="control-label">Zonal Value Details(Subclass Wise)</label></th>

                    </thead>
                    <tbody>
                        <?php foreach ($getpendingZone as $details) : ?>
                            <tr>
                                <td class="center"><?php echo  $details['zone_name'] ?></td>
                                <td class="center">
                                    <!-- ReUpdate Zonal Value after Revert by LM  Button -->
                                    <a data-toggle='modal' data-target="#zonalDetailsAddModal" data-zonecode="<?= $details['zone_code'] ?>" data-zonename="<?= $details['zone_name'] ?>" class='btn btn-success btn-sm addzonalinfo'><i class='fa fa-plus'></i>Add Zonal Information Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Pending Zonal Details End -->
</article>
<article>
    <!-- Already Filled Zonal Details -->

    <!-- Already Filed Zonal Details  End -->
</article>
<article>
    <!-- Table Data of Reverted Back by CO -->
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Reverted Back Zonal Details By CO
                </h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' class="display nowrap" id='datatable-reverted' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Zone Name</label></th>
                        <th scope="col" class="center"><label class="control-label">Zonal Value Details(Subclass Wise)</label></th>
                        <th scope="col" class="center"><label class="control-label">Revert Remarks</label></th>

                    </thead>
                    <tbody>
                        <?php foreach ($getRevertedZone as $details) : ?>
                            <tr>
                                <td class="center"><?= $this->utilityclass->getZoneName($details['zone_code']) ?></td>
                                <td class="center">
                                    <!-- ReUpdate Zonal Value after Revert by LM  Button -->
                                    <button class="btn btn-primary btn-sm" onclick="getZoneDetailsEditFormModal('<?= $details['zone_code'] ?>')">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Edit
                                    </button>
                                    <!-- <a data-toggle='modal' data-target="#zonalDetailsReupdateModal" data-zonecodereverted="<?= $details['zone_code'] ?>" data-zonenamereverted="<?= $this->utilityclass->getZoneName($details['zone_code']) ?>" class='btn btn-warning btn-sm reupdatezonalinfo'><i class='fa fa-edit'></i> Reupdate Zonal Details
                                    </a> -->
                                </td>
                                <td class="center"><?= $details['revert_remarks'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Table Data of Reverted back by CO -->
</article>
<!-- Modal for Zonal Details Add by LM -->
<div class="modal fade" id="zonalDetailsAddModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:40%" role="document">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-success">
                <h5 class="modal-title w-100">
                    
                    Add Village WIse Zonal Information<br>
                    <?php echo $this->lang->line('vill_town') ?> :
                    <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>,
                    Zone Name :
                    <span class="text-danger" id="zone_name_header"></span>
                </h5>
            </div>
            <?php echo form_open(base_url("index.php/ZoneInformationController/addVillageWiseZonalDetails"), array('method' => 'post', 'id' => 'villageZonalAddForm')); ?>
            <div class="modal-body">
                <div class="modal-header text-center mb-3 p-0">
                    <h6 class="modal-title w-100 text-danger mb-1">
                        <strong>NOTE:</strong>If VALUES are not available, then keep the textfield as empty.
                    </h6>
                </div>
                <input type='hidden' name="zone_code" id='zoneCode'>
                <input type='hidden' name="zone_name" id='zoneName'>
                <!-- Newly Added -->
                <input type='hidden' name="village_selected" value="<?php echo $select ?>">
                <input type="hidden" value="<?= $dist_code ?>" name="dist_code">
                <input type="hidden" value="<?= $subdiv_code ?>" name="subdiv_code">
                <input type="hidden" value="<?= $cir_code ?>" name="cir_code">
                <input type="hidden" value="<?= $mouza_pargona_code ?>" name="mouza_pargona_code">
                <input type="hidden" value="<?= $lot_no ?>" name="lot_no">
                <input type='hidden' name="unique_vill_code" value="<?php echo $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>">

                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' class="display nowrap" id='datatable-pending' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Subclass Name</label></th>
                        <th scope="col" class="center"><label class="control-label">Zonal Value</label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($getSubclass as $details) : ?>
                            <tr>
                                <input type='hidden' name="subclass_code[]" value="<?php echo  $details['subclass_code'] ?>">
                                <input type='hidden' name="subclass_name[]" value="<?php echo  $details['subclass_name'] ?>">
                                <td width="50%" class="center"><?php echo  $details['subclass_name'] ?></td>
                                <td width="50%" class="center">
                                    <input type="text" class="form-control land_rate numberonly" id="land_rate" name="land_rate[]" minlength="1" maxlength="10">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php echo form_submit(['name' => 'villagezonalsubmit', 'value' => 'Submit', 'class' => 'btn btn-success', 'id' => 'submit']); ?>
            </div>
            <?php echo form_close(); ?>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Zonal Details Reupdate by LM  End-->
<div class="modal fade" id="zonalDetailsReupdateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%" role="document">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-primary">
                <h5 class="modal-title w-100">
                    
                    Add Village WIse Zonal Information<br>
                    <?php echo $this->lang->line('vill_town') ?> :
                    <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>,
                    Zone Name :
                    <span class="text-danger" id="zone_name_header_reverted"></span>
                </h5>
            </div>
            <?php echo form_open(base_url("index.php/ZoneInformationController/reupdateVillageWiseZonalDetails"), array('method' => 'post', 'id' => 'villageZonalReupdateForm')); ?>
            <div class="modal-body">
                <div class="modal-header text-center mb-3 p-0">
                    <h6 class="modal-title w-100 text-danger mb-1">
                        <u><strong>NOTE:</strong> Fileds marks with (*) are mandatory</u>
                    </h6>
                </div>
                <input type='hidden' name="zone_code_reverted" id='zoneCode_reverted'>
                <input type='hidden' name="zone_name_reverted" id='zoneNameReverted'>
                <input type='hidden' name="village_selected" value="<?php echo $select ?>">
                <input type='hidden' name="unique_vill_code" value="<?php echo $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' class="display nowrap" id='datatable-pending' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Subclass Name</label></th>
                        <th scope="col" class="center"><label class="control-label">Zonal Value</label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($getSubclass as $details) : ?>
                            <tr>
                                <input type='hidden' name="subclass_code[]" value="<?php echo  $details['subclass_code'] ?>">
                                <input type='hidden' name="subclass_name[]" value="<?php echo  $details['subclass_name'] ?>">
                                <td width="50%" class="center"><?php echo  $details['subclass_name'] ?></td>
                                <td width="50%" class="center">
                                    <input type="text" class="form-control land_rate" id="land_rate" name="land_rate_reverted[]">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php echo form_submit(['name' => 'villagezonalsubmit', 'value' => 'Submit', 'class' => 'btn btn-success', 'id' => 'submit']); ?>
            </div>
            <?php echo form_close(); ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Zonal Details Reupdate by LM -->

<!-- Modal for Zonal Details Reupdate by LM  End-->
<!-- Radio Nav End -->

<!-- Datatable Script -->
<script>
    $(document).ready(function() {

        $('#datatable-pending').DataTable({
            "pageLength": 20,
            "order": [1, "asc"],

        });
        $('#datatable-filled').DataTable({
            "pageLength": 20,
            "order": [0, "asc"]
        });
        $('#datatable-reverted').DataTable({
            "pageLength": 20,
            "order": [0, "asc"]
        });

        $('#zonalDetailsAddModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })
        $('#zonalDetailsReupdateModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })
    });
</script>

<script>
    $('.numberonly').keypress(function(event) {
        if (event.which != 46 && (event.which < 47 || event.which > 59)) {
            event.preventDefault();
            if ((event.which == 46) && ($(this).indexOf('.') != -1)) {
                event.preventDefault();
            }
        }
    });
</script>
<!-- Datatable Script End -->
<!-- Radio Button Alter Tab Function Start -->
<script>
    function validateForm() {

        var z = document.forms["villageZonalAddForm"]["land_rate"].value;

        if (!/^[0-9]+$/.test(z)) {
            alert("Please only enter numeric characters only for Zonal Value (Allowed input:0-9)")
        }

    }
</script>
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
<script>
    // Fetch Zonal Details Data in Modal 
    $(document).on('click', '.addzonalinfo', function() {
        $('#zoneCode').val($(this).data('zonecode'))
        $('#zoneName').val($(this).data('zonename'))
        $('#zone_name_header').text($(this).data('zonename'))
        $('#villCodeAdd').val($(this).data('villcode'))
    });
    $(document).on('click', '.reupdatezonalinfo', function() {
        $('#zoneCode_reverted').val($(this).data('zonecodereverted'))
        $('#zone_name_header_reverted').text($(this).data('zonenamereverted'))
        $('#villCode_reverted').val($(this).data('villcode'))
    });

    $('#btn-submit').on('click', function(e) {
        e.preventDefault();
        var form = $('form');
        Swal.fire({
            title: "Do you want to Re Update the Zonal Information?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,

        }).then((result) => {
            if (result.isConfirmed) {
                // var zoneCode = $("#zoneCode").val();
                // var villCodeAdd = $("#villCodeAdd").val();
                // var lclass_name_reverted = $("#lclass_name_reverted").val();
                // var zone_name_reverted = $("#zone_name_reverted").val();
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/addVillageWiseZonalDetails" ?>',
                    type: "POST",
                    // dataType: "json",
                    // data: {
                    //     lclass_name_reverted: lclass_name_reverted,
                    //     zone_name_reverted: zone_name_reverted,
                    // },
                    error: function() {
                        Swal.fire({
                            title: "Failed",
                            text: "Zonal Information Not Updated. Please Select Zone Information.",
                            type: "warning",
                            timer: 50000
                        });
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.statusCode == 200) {
                            Swal.fire({
                                title: "Submitted",
                                text: "Zonal Information ReUpdated  successfully and sent for CO Approval",
                                type: "success",
                                timer: 50000
                            });
                            window.location.reload(true);
                        } else {
                            Swal.fire({
                                title: "Failed",
                                text: "Zonal Information Not Updated. Please Select Zone Information.",
                                type: "error",
                                timer: 50000
                            });
                        }
                    },
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });
</script>

<?php include 'village_wise_zonal_details_update_form.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/zonal_details/zonal_details.js"></script>