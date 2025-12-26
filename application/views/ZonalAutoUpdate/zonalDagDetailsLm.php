<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
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
</style>

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
<div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10 col-sm-10 col-lg-6 col-xs-12">
                            <span class="text-danger">Note: Click  All to select & Approve All the visible dag no in this page</span>
                        </div>
                        <div class="col-md-2 col-sm-2 col-lg-6 col-xs-12" align="right">
                            <button class="btn btn-primary" id="searchZonalValueDetails">
                                <i class="fa fa-search"></i> Search Zonal Value
                            </button>
                        </div>
                    </div>
                </div>

<center>
    <div class="panel-body mb-2">
        <input type="radio" id="radioTab1" name="tab" checked>
        <label for="radioTab1" class="mr-4" style="text-transform: uppercase;">Pending Zonal Info (Dagwise) <i class="fa fa-clock-o" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab2" name="tab">
        <label for="radioTab2" class="mr-4" style="text-transform: uppercase;">Sent to CO (Dagwise)<i class="fas fa-check-double" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab3" name="tab">
        <label for="radioTab3" class="mr-4" style="text-transform: uppercase;">Revert Back from CO (Dagwise)<i class="fa fa-undo" aria-hidden="true"></i></label>
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

<!-- Approved Dagwise Zonal Details CO  -->
<article>
    <div class="col-lg-12">
        <div class="panel panel-success panel-form">
            <div class="panel-heading">
                <span class="panel-title">Already Filled Zonal Information</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableDagwiseApprovedLm' width="100%">
                    <thead>
                        <th scope="col"><label class="control-label">Dag No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta No </label></th>
                        <th scope="col" class="center"><label class="control-label">Patta Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                        <th scope="col" class="center"><label class="control-label">Status</label></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</article>




<!-- Reverted Dagwise Zonal Details CO  -->
<article>
    <div class="col-lg-12">
        <div class="panel panel-danger panel-form">
            <div class="panel-heading">
                <span class="panel-title">Reverted Back Zonal Details By CO</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableDagwiseRevertedLm' width="100%">
                    <thead>
                        <th scope="col"><label class="control-label">Dag No</label></th>
                        <th scope="col" class="center"><label class="control-label">Patta No </label></th>
                        <th scope="col" class="center"><label class="control-label">Patta Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                        <th scope="col" class="center"><label class="control-label">Status</label></th>
                        <th scope="col" class="center"><label class="control-label">Action</label></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</article>


<?php include 'dag_details_edit_modal_lm.php'; ?>

<!-- Zonal Value Search Modal -->

<?php include 'zonal_value_search_form_co.php'; ?>

<!-- Data Table Configuration -->
<script>
    function editDagDetailsLM(dag_no, unique_village_code, mouza_name, lot_name, village_name_string, zone_name, subclass_name, chitha_class_name_string) {
        $('#dag_no_lm_reupdate').val(dag_no);
        $('#vill_code_lm_reupdate').val(unique_village_code);
        $('#zv_update_dag_no_header').text(dag_no);
        $('#mouza_name_header_lm').text(mouza_name);
        $('#lot_name_header_lm').text(lot_name);
        $('#village_name_header_lm').text(village_name_string);
        $('#zone_name_header_lm').text(zone_name);
        $('#subclass_name_header_lm').text(subclass_name);
        $('#chitha_class_name_header_lm').text(chitha_class_name_string);
        $('#dag_details_edit_modal_lm').modal('show');
    }


    function dag_edit_lm_reset_modal() {
        $('#dag_details_edit_modal_lm').fadeOut('slow').modal('hide');
        document.getElementById("dag_details_edit_form_lm").reset();
    }

    //ReUpdate Dag Detals by LM after Reverted by CO
    function reupdateDagDetailsLM() {

        var dag_no_lm_reupdate = $('#dag_no_lm_reupdate').val();
        var vill_code_lm_reupdate = $("#vill_code_lm_reupdate").val();
        var zone_name_reupdate_lm = $("#zone_name_reupdate_lm").val();
        var lclass_name_reupdate_lm = $("#lclass_name_reupdate_lm").val();

        const applicant = {
            dag_no_lm_reupdate: dag_no_lm_reupdate,
            vill_code_lm_reupdate: vill_code_lm_reupdate,
            zone_name_reupdate_lm: zone_name_reupdate_lm,
            lclass_name_reupdate_lm: lclass_name_reupdate_lm,
        };
        console.log(applicant);

        $.ajax({

            url: '<?php echo base_url() . "index.php/ZoneInformationController/reupdateDagDetailsByLM" ?>',
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {

                if (data.responseType == 1) {
                    showErrorMessage("There is some problem, Please try again");
                } else if (data.responseType == 2) {
                    alert(data.message);
                    location.reload();
                    // showSuccessMessage(data.message);
                } else if (data.responseType == 3) {
                    showWarningMessage(data.message);
                } else {
                    showErrorMessage("Failed.Kindly Contact System Administrator.");
                }
            },
            data: JSON.stringify(applicant)

        });
    };
</script>

<script>
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
</script>

<!-- Disable/ Enable Submit Button based on Selected Dag Details -->
<script>
    $('#approve-dag').prop("disabled", true);
    $('input:checkbox').click(function() {
        if ($(this).is(':checked')) {
            $('#approve-dag').prop("disabled", false);
        } else {
            if ($('.chkdag').filter(':checked').length < 1) {
                $('#approve-dag').attr('disabled', true);
            }
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#village_zonal_pending').change(function(event) {
            // console.log(event);
            var village_uuid_pending = $('#village_zonal_pending').val();

            $('#datatableDagwisePendingLm').DataTable().destroy();
            load_data_dagwise_pending(village_uuid_pending);
        });
        load_data_dagwise_pending();

        // Load Dagwise Pending
        function load_data_dagwise_pending(village_uuid_pending) {
            $('#datatableDagwisePendingLm thead th:nth-of-type(2)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_pending = "<?= $dist_code ?>";
            var subdiv_code_pending = "<?= $subdiv_code ?>";
            var cir_code_pending = "<?= $cir_code ?>";
            var mouza_pargona_code_pending = "<?= $mouza_pargona_code ?>";
            var lot_no_pending = "<?= $lot_no ?>";

            var table = $('#datatableDagwisePendingLm').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url + 'index.php/ZoneInformationController/viewPendingZonalDagLM',
                    type: 'POST',
                    data: {
                        dist_code_pending: dist_code_pending,
                        subdiv_code_pending: subdiv_code_pending,
                        cir_code_pending: cir_code_pending,
                        mouza_pargona_code_pending: mouza_pargona_code_pending,
                        lot_no_pending: lot_no_pending,
                        village_code_pending: village_uuid_pending,
                        // rural:rurban
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0, 1, 2, 3, 4],
                }]
            });
            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
            // button search
            $('.search_button').on('click', function() {
                $('table thead tr th .input_search').each(function() {
                    $(this).val('');
                    // table.column($(this).data('columnIndex')).search('');
                });
                $('#datatableDagwisePendingLm').DataTable().destroy();
                load_data_dagwise_pending();
            });
        }


        // Load Dagwise Approved Zonal Details

        load_data_dagwise_approved();

        function load_data_dagwise_approved() {
            $('#datatableDagwiseApprovedLm thead th:nth-of-type(1)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_approved = "<?= $dist_code ?>";
            var subdiv_code_approved = "<?= $subdiv_code ?>";
            var cir_code_approved = "<?= $cir_code ?>";
            var mouza_pargona_code_approved = "<?= $mouza_pargona_code ?>";
            var lot_no_approved = "<?= $lot_no ?>";
            var vill_code_selected = "<?= $select ?>";
            var table = $('#datatableDagwiseApprovedLm').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url + 'index.php/ZoneInformationController/viewUpdatedZonalDagLM',
                    type: 'POST',
                    data: {
                        dist_code_approved: dist_code_approved,
                        subdiv_code_approved: subdiv_code_approved,
                        cir_code_approved: cir_code_approved,
                        mouza_pargona_code_approved: mouza_pargona_code_approved,
                        lot_no_approved: lot_no_approved,
                        vill_code_selected: vill_code_selected,
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0, 1, 2, 3, 4],
                }]
            });
            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
            // button search
            $('.search_button').on('click', function() {
                $('table thead tr th .input_search').each(function() {
                    $(this).val('');
                    // table.column($(this).data('columnIndex')).search('');
                });
                $('#datatableDagwiseApprovedLm').DataTable().destroy();
                load_data_dagwise_approved();
            });
        }
        // Load Dagwise Approved Zonal Details CO end


        // Load Reverted Approved Zonal Details

        load_data_dagwise_reverted();

        function load_data_dagwise_reverted() {
            $('#datatableDagwiseRevertedLm thead th:nth-of-type(1)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_reverted = "<?= $dist_code ?>";
            var subdiv_code_reverted = "<?= $subdiv_code ?>";
            var cir_code_reverted = "<?= $cir_code ?>";
            var mouza_pargona_code_reverted = "<?= $mouza_pargona_code ?>";
            var lot_no_reverted = "<?= $lot_no ?>";
            var vill_code_selected = "<?= $select ?>";
            var table = $('#datatableDagwiseRevertedLm').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url + 'index.php/ZoneInformationController/viewRevertedZonalDagLM',
                    type: 'POST',
                    data: {
                        dist_code_reverted: dist_code_reverted,
                        subdiv_code_reverted: subdiv_code_reverted,
                        cir_code_reverted: cir_code_reverted,
                        mouza_pargona_code_reverted: mouza_pargona_code_reverted,
                        lot_no_reverted: lot_no_reverted,
                        vill_code_selected: vill_code_selected,
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0, 1, 2, 3, 4],
                }]
            });
            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
            // button search
            $('.search_button').on('click', function() {
                $('table thead tr th .input_search').each(function() {
                    $(this).val('');
                    // table.column($(this).data('columnIndex')).search('');
                });
                $('#datatableDagwiseRevertedLm').DataTable().destroy();
                load_data_dagwise_reverted();
            });
        }
        // Load Dagwise Reverted Zonal Details CO end

    });
</script>




<script>
    $("#checkedAll").click(function() {
        if (this.checked) {
            $('.selectMark').each(function() {
                this.checked = true;
                $('.selectMark').prop('checked', true);
            })
        } else {
            $('.selectMark').each(function() {
                this.checked = false;
                $('.selectMark').prop('checked', false);
            })
        }
    });

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
    //Bulk Approved by  CO
    $(document).on('click', '#bulkApproveModalYes', function() {
        $('#bulkApproveModal').modal('hide');

        var dag_no_selected = [];


        $('.selectMark:checked').each(function(i) {

            dag_no_selected[i] = $(this).val();

        });

        // alert(dag_no_selected);

        if (dag_no_selected.length > 0) {

            const applicant = {
                dag_no_selected: dag_no_selected,

            };

            $.ajax({
                url: '<?php echo base_url() . "index.php/ZoneInformationController/bulkApproveByCO" ?>',
                type: "POST",
                dataType: "json",
                contentType: "application/json",
                success: function(data) {
                    if (data.responseType == 1) {
                        showErrorMessage("Zonal info Approval Failed..!");
                    } else if (data.responseType == 2) {
                        alert(data.message);
                        location.reload();
                        // showSuccessMessage("Application successfully Approved");
                    } else if (data.responseType == 3) {
                        showWarningMessage("Please Select Dag No Before Approve !");
                    } else {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });

        } else {
            showWarningMessage("Please Select Dag No Before Approve!");
        }

    });
</script>



<!-- Newly Added 18/03/2023 -->
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
    $('#datatable-pending').DataTable({
        "pageLength": 10,
        "order": [1, "asc"],
    });
</script>

