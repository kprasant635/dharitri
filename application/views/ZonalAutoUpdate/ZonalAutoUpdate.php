<!-- Radio Navigation -->
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
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
    <?php
    if (($this->session->flashdata('message')))
        echo $this->session->flashdata('message');
    ?>
    <div class="well well-sm mis_report">
        <h5 style="text-align: center;">
            Dagwise Zonal Information (Village:
            <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>/
            <?php if ($this->utilityclass->getVillageType($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select) == 'U') : ?>
                Urban
            <?php elseif ($this->utilityclass->getVillageType($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select) == 'R') : ?>
                Rural
                <?php endif; ?>)
        </h5>
    </div>
    <!-- Newly Added Message -->
    <div class="alert alert-danger">
        <strong class="close" data-dismiss="alert" aria-label="close">&times;</strong>
        <p class="text-danger">After Selecting Land Class and Zone Combination for dags of a village, Please make sure that you are entering Land Rates of those Combinations in the Villagewise module. Land Rates are important, if rates are not submitted then Zonal value will not show up .</p>
    </div>
    <!-- Newly Added Message -->
    <div class="panel-body mb-2">
        <input type="radio" id="radioTab1" name="tab" checked>
        <label for="radioTab1" class="mr-4">Pending Zonal Info (Dag Wise)</label>
        <input type="radio" id="radioTab2" name="tab">
        <label for="radioTab2" class="mr-4">Sent to CO (Dag Wise)</label>
        <input type="radio" id="radioTab3" name="tab">
        <label for="radioTab3" class="mr-4">Revert Back from CO (Dag Wise)</label>
    </div>
</center>


<article>
    <!-- Pending Zonal Details -->
    <div class="col-lg-12">
        <?php echo form_open(base_url("index.php/ZoneInformationController/updateZonalInformationLM"), array('method' => 'post', 'id' => 'myform')); ?>
        <div class="panel panel-warning panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Pending Zonal Information
                    <input type='hidden' name="village_selected" value="<?php echo $select ?>">
                    <!-- Newly Added -->
                    <input type="hidden" value="<?= $dist_code ?>" name="dist_code">
                    <input type="hidden" value="<?= $subdiv_code ?>" name="subdiv_code">
                    <input type="hidden" value="<?= $cir_code ?>" name="cir_code">
                    <input type="hidden" value="<?= $mouza_pargona_code ?>" name="mouza_pargona_code">
                    <input type="hidden" value="<?= $lot_no ?>" name="lot_no">
                    <input type='hidden' name="unique_vill_code" value="<?php echo $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>">
                </h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' class="display nowrap" id='datatable-pending' width="100%">
                    <thead>
                        <th scope="col" class="center"><input type='button' name class="btn btn-sm btn-primary" id="toggle" value="select all" onClick="select_pending()"></th>
                        <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta Type</label></th>
                        <th scope="col" class="center"><label class="control-label">Land Type</label></th>
                        <th scope="col" class="center"><label class="control-label">Zone</label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($getdagdetails as $details) :
                        ?>
                            <tr>
                                <td class="center"><input type='checkbox' class="chkdag" id="" name="dag_no[<?= $i ?>]" value="<?php echo  $details['dag_no'] ?>"></td>
                                <td class="center"><?php echo  $details['dag_no'] ?></td>
                                <td class="center"><?php echo $details['patta_no'] ?></td>
                                <td class="center"><?= $this->utilityclass->getPattaName($details['patta_type_code']) ?></td>
                                <td class="center"><?= $this->utilityclass->getLandClassCode($details['land_class_code']) ?></td>
                                <td width="20%" class="center">
                                    <select id="" class="form-control center villageselect" name="zone_name[<?= $i ?>]">
                                        <option value="0000">Select Land Zone</option>
                                        <?php foreach ($getZone as $zone) : ?>
                                            <option value='<?php echo  $zone['zone_code'] ?>'><?php echo  $zone['zone_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td width="20%" class="center">
                                    <select class="form-control center villageselect" name="lclass_name[<?= $i ?>]">
                                        <option value="0000">Select Land Class</option>
                                        <?php foreach ($getSubclass as $subclass) : ?>
                                            <option value='<?php echo  $subclass['subclass_code'] ?>'><?php echo  $subclass['subclass_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
                <center>
                    <?php echo form_submit(['name' => 'zonalsubmit', 'value' => 'Update Selected Dag', 'class' => 'btn btn-success', 'id' => 'submit']); ?>
                </center>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- Pending Zonal Details End -->
</article>
<article>
    <!-- Already Filled Zonal Details -->
    <div class="col-lg-12">
        <div class="panel panel-success panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Already Filled Zonal Information
                    <input type='hidden' name="village_selected" value="<?php echo $select ?>">
                </h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable-filled' width="100%">
                    <thead>
                        <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta Type</label></th>
                        <th scope="col" class="center"><label class="control-label">Land Type</label></th>
                        <th scope="col" class="center"><label class="control-label">Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                        <th scope="col" class="center"><label class="control-label">Status</label></th>
                    </thead>
                    <tbody>
                        <?php foreach ($updateddagdetails as $details) : ?>
                            <tr>
                                <td class="center"><?php echo  $details['dag_no'] ?></td>
                                <td class="center"><?php echo $details['patta_no'] ?></td>
                                <td class="center"><?= $this->utilityclass->getPattaName($details['patta_type_code']) ?></td>
                                <td class="center"><?= $this->utilityclass->getLandClassCode($details['land_class_code']) ?></td>
                                <td class="center"><?= $this->utilityclass->getZoneName($details['zone_id']) ?></td>
                                <td class="center" width="20%"><?= $this->utilityclass->getSubclassName($details['subclass_id']) ?></td>
                                <?php if ($details['flag'] == 0) : ?>
                                    <td class="center text-primary">Sent For CO Approval</td>
                                <?php elseif ($details['flag'] == 1) : ?>
                                    <td class="center text-success">Approved</td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Already Filed Zonal Details  End -->
</article>
<article>
    <!-- Table Data of Reverted Back by CO -->
    <div class="col-lg-12">
        <div class="panel panel-danger panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Reverted Back Zonal Details By CO
                </h3>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable-reverted' width="100%">
                    <thead>

                        <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta Type</label></th>
                        <th scope="col" class="center"><label class="control-label">Land Type</label></th>
                        <th scope="col" class="center"><label class="control-label">Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                        <th scope="col" class="center"><label class="control-label">Status</label></th>
                        <th scope="col" class="center"><label class="control-label">Action</label></th>
                    </thead>
                    <tbody>
                        <?php if (!empty($reverteddagdetails)) {
                            foreach ($reverteddagdetails as $details) {
                        ?>
                                <tr>
                                    <td class="center"><?php echo  $details['dag_no'] ?></td>
                                    <td class="center"><?php echo $details['patta_no'] ?></td>
                                    <td class="center" width="20%"><?= $this->utilityclass->getPattaName($details['patta_type_code']) ?></td>
                                    <td class="center"><?= $this->utilityclass->getLandClassCode($details['land_class_code']) ?></td>
                                    <td class="center"><?= $this->utilityclass->getZoneName($details['zone_id']) ?></td>
                                    <td class="center"><?= $this->utilityclass->getSubclassName($details['subclass_id']) ?></td>
                                    <td class="center text-danger" width="20%">Revert from CO</td>
                                    <td class="center">
                                        <!-- ReUpdate Zonal Value after Revert by LM  Button -->
                                        <a data-toggle='modal' data-target="#zonalReUpdateModal" data-dagno="<?= $details['dag_no'] ?>" ; data-villcode="<?= $details['unique_village_code'] ?>" ; class='btn btn-warning btn-sm zonaleditor'><i class='fa fa-edit'></i>Reupdate Zonal Information
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else { ?> <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Table Data of Reverted back by CO -->
</article>
<!-- Modal for Zonal Details ReUpdate by LM -->
<div class="modal fade" id="zonalReUpdateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-success">
                <h6 class="modal-title w-100">
                    <?php echo $this->lang->line('land_bank_header') ?>
                    Reupdate Zonal Information<br>
                    <?php echo $this->lang->line('mouza') ?> :
                    <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?>,
                    <?php echo $this->lang->line('lot_no') ?> :
                    <?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); ?>,
                    <?php echo $this->lang->line('vill_town') ?> :
                    <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>,
                    Dag No :
                    <span class="text-white" id="zv_update_dag_no_header"></span>
                </h6>
            </div>
            <form id="zonalReUpdateForm" name="zonalReUpdateForm" method="POST" action="">
                <div class="modal-body">
                    <input type='hidden' name="dag_no_reverted" id='dagReverted'>
                    <input type='hidden' name="vill_code_reverted" id='villReverted'>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Zone Type:</label>
                        <select class="form-control chosen-select" id="zone_name_reverted" name="zone_name_reverted" required>
                            <option value="">Select Land Zone</option>
                            <?php foreach ($getZone as $zone) : ?>
                                <option value='<?php echo  $zone['zone_code'] ?>'><?php echo  $zone['zone_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Land Class Type:</label>
                        <select class="form-control" id="lclass_name_reverted" name="lclass_name_reverted" required>
                            <option disabled selected>Select Land Class</option>
                            <?php foreach ($getSubclass as $subclass) : ?>
                                <option value='<?php echo  $subclass['subclass_code'] ?>'><?php echo  $subclass['subclass_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Zonal Details ReUpdate by LM  End-->
<!-- test code -->

<!-- test code end -->
<!-- Radio Nav End -->
<!-- Datatable Script -->
<script>
    $(document).ready(function() {

        $('#datatable-pending').DataTable({
            "pageLength": 10,
            "order": [1, "asc"],
        });
        $('#datatable-filled').DataTable({
            "pageLength": 10,
            "order": [0, "asc"]
        });
        $('#datatable-reverted').DataTable({
            "pageLength": 10,
            "order": [0, "asc"]
        });

    });
</script>
<!-- Datatable Script End -->
<!-- Modal Validation -->

<!-- Modal Validation End -->
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

<script>
    // Select/Deselect Multiple Dag No by Checkbox
    function select_pending() {
        Swal.fire({
            // title: '<span class="text-danger">N.B.</span>',
            icon: 'info',
            html: '<p class="text-danger">** After Selecting Land Class and Zone Combination for dags of a village, Please make sure that you are entering Land Rates of those Combinations in the Villagewise module.</p>' +
                '<p class="text-danger">** Land Rates are important, if rates are not submitted then Zonal value will not show up</p> ',
            // showCloseButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Ok I Understood',
        });
        var checkboxes = document.getElementsByClassName('chkdag');
        var button = document.getElementById('toggle');

        if (button.value == 'select all') {
            for (var i in checkboxes) {
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'Deselect all'
        } else {
            for (var i in checkboxes) {
                checkboxes[i].checked = '';
            }
            button.value = 'select all'
        }
    }

    // Select/Deselect Multiple Reverted Dag No by Checkbox
    function select_reverted() {
        var checkboxes = document.getElementsByName('dag_no_revert[]');
        var button = document.getElementById('revert');

        if (button.value == 'select all') {
            for (var i in checkboxes) {
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'Deselect all'
        } else {
            for (var i in checkboxes) {
                checkboxes[i].checked = '';
            }
            button.value = 'select all'
        }
    }
</script>


<!-- Re Update  Zonal Value Details in Modal by LM after CO Revert-->
<script>
    // Fetch Zonal Details Data in Modal 
    $(document).on('click', '.zonaleditor', function() {
        $('#dagReverted').val($(this).data('dagno'))
        $('#zv_update_dag_no_header').text($(this).data('dagno'))
        $('#villReverted').val($(this).data('villcode'))
    });

    // Reupdate Zone Information by LM of Dag after revert by CO 
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
                var dagReverted = $("#dagReverted").val();
                var villReverted = $("#villReverted").val();
                var lclass_name_reverted = $("#lclass_name_reverted").val();
                var zone_name_reverted = $("#zone_name_reverted").val();
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/ZonalReUpdate/" ?>' + dagReverted + '/' + villReverted,
                    type: "POST",
                    dataType: 'json',
                    data: {
                        lclass_name_reverted: lclass_name_reverted,
                        zone_name_reverted: zone_name_reverted,
                    },
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

<!-- Disable Submit Button when No dag is selected -->
<script>
    $('#update-dag').prop("disabled", true);
    $('input:checkbox').click(function() {
        if ($(this).is(':checked')) {
            $('#update-dag').prop("disabled", false);
        } else {
            if ($('.chkdag').filter(':checked').length < 1) {
                $('#update-dag').attr('disabled', true);
            }
        }
    });
</script>