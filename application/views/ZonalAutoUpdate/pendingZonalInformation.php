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

<center>
    <div class="panel-body mb-2">
        <input type="radio" id="radioTab1" name="tab" checked>
        <label for="radioTab1" class="mr-4" style="text-transform: uppercase;">Pending Zonal Info (Dagwise) <i class="fa fa-clock-o" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab2" name="tab">
        <label for="radioTab2" class="mr-4" style="text-transform: uppercase;">Approved Zonal Info (Dagwise)<i class="fas fa-check-double" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab3" name="tab">
        <label for="radioTab3" class="mr-4" style="text-transform: uppercase;">Revert Back to LM (Dagwise)<i class="fa fa-undo" aria-hidden="true"></i></label>
    </div>
</center>





<!-- Pending Dagwise Zonal Details CO  -->
<article>
    <div class="col-lg-12 ">
        <!-- Newly Added Message -->
        <div class="alert alert-danger">
            <strong class="close" data-dismiss="alert" aria-label="close">&times;</strong>
            <p class="text-danger">After Approving zonal Infomation for selected Dag, You have to Approve the Land Rates for respected village in Villagewise Zonalinfo module. Land Rates are important, if rates are not approved in Villagewise module then Zonal value will not show up .</p>
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

        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success">
                <strong class="close" data-dismiss="alert" aria-label="close">&times;</strong>
                <strong class="text-success"><?= $this->session->flashdata('message'); ?></strong>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <span class="panel-title">Dagwise Pending Zonal Information</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableDagwisePendingCo' width="100%">
                    <thead>
                        <th>All <input type="checkbox" class="checkBoxD" value="all" id="checkedAll"> </th>
                        <th scope="col"><label class="control-label">Dag No</label></th>
                        <th scope="col" class="center"><label class="control-label">Village </label>
                            <select class="form-control input_search" name="village_zonal_pending" id="village_zonal_pending" data-column-index="4">
                                <option value="">--SELECT--</option>
                                <?php if (isset($villageListPending)) {
                                    foreach ($villageListPending as $villageList) { ?>

                                        <option value="<?= $villageList->village_uuid ?>"><?= $this->utilityclass->getVillageNameByUUID($villageList->village_uuid); ?></option>
                                <?php }
                                } ?>
                            </select>
                        </th>
                        <th scope="col" class="center"><label class="control-label">Land Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                        <th scope="col" class="center" style="width: 231px;"><label class="control-label"><?php echo $this->lang->line('action'); ?></label>
                            <button type="button" class="search_button btn btn-sm btn-danger form-control">
                                <i class="fa fa-refresh"></i>
                                Reset
                            </button>
                        </th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="mt-3">
                    <center>
                        <?php if (!empty($getpendingdetails)) { ?>
                            <button class="btn btn-success" id="bulkApproveByCO">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                Approve Zonal Info
                            </button>

                            <!-- Bulk Reject -->
                            <button class="btn btn-danger" id="bulkRejectByCO">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                Reject Zonal Info
                            </button>
                            <!-- Bulk Reject Btn-->

                        <?php }  ?>
                    </center>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Approved Dagwise Zonal Details CO  -->
<article>
    <div class="col-lg-12">
        <div class="panel panel-success panel-form">
            <div class="panel-heading">
                <span class="panel-title">Dagwise Approved Zonal Information</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableDagwiseApprovedCo' width="100%">
                    <thead>
                        <!-- <th></th> -->
                        <th scope="col" style="width: 10%;"><label class="control-label">Dag No</label></th>
                        <th scope="col" style="width: 30%;" class="center"><label class="control-label">Village </label>
                            <select class="form-control input_search" name="village_zonal_approved" id="village_zonal_approved" data-column-index="4">
                                <option value="">--SELECT--</option>
                                <?php if (isset($villageListApproved)) {
                                    foreach ($villageListApproved as $villageList) { ?>

                                        <option value="<?= $villageList->village_uuid ?>"><?= $this->utilityclass->getVillageNameByUUID($villageList->village_uuid); ?></option>
                                <?php }
                                } ?>
                            </select>
                        </th>
                        <th scope="col" class="center"><label class="control-label">Land Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label></th>
                        <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label>
                            <button type="button" class="search_button btn btn-sm btn-danger form-control">
                                <i class="fa fa-refresh"></i>
                                Reset
                            </button>
                        </th>
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
                <span class="panel-title">Dagwise Reverted Zonal Information</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableDagwiseRevertedCo' width="100%">
                    <thead>
                        <th scope="col" style="width: 10%;"><label class="control-label">Dag No</label></th>
                        <th scope="col" style="width: 20%;" class="center"><label class="control-label">Village </label>
                            <select class="form-control input_search" name="village_zonal_reverted" id="village_zonal_reverted" data-column-index="4">
                                <option value="">--SELECT--</option>
                                <?php if (isset($villageListReverted)) {
                                    foreach ($villageListReverted as $villageList) { ?>

                                        <option value="<?= $villageList->village_uuid ?>"><?= $this->utilityclass->getVillageNameByUUID($villageList->village_uuid); ?></option>
                                <?php }
                                } ?>
                            </select>
                        </th>
                        <th scope="col" class="center"><label class="control-label">Land Type </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Class</label><button type="button" class="search_button btn btn-sm btn-danger form-control">
                                <i class="fa fa-refresh"></i>
                                Reset
                            </button></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</article>




<!-- Modal Mark and Bulk Approve by CO -->
<div class="modal" role="dialog" id="bulkApproveModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header  bg-success">
                <h5 class="text-center" id="exampleModalLongTitle">
                    Zonal Info to Be Approve by CO
                </h5>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row">

                        <h4 class="text-center">Do you Realy want to Approve these Dags..?</h4>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="bulkApproveModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary" id="bulkApproveModalYes">SUBMIT</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Mark and Bulk Approve by CO End -->



<!-- Modal Mark and Bulk Reject by CO -->
<div class="modal" role="dialog" id="bulkRejectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header  bg-danger">
                <h6 class="text-center" id="exampleModalLongTitle">
                  <i class="fa fa-ban"></i>  Reject Zonal Information
                </h6>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row">

                        <strong class="text-center">Do you Realy want to Reject these Dags..?</strong>
                        <span class="text-center">Changes can't be undone</span>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="bulkRejectModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary" id="bulkRejectModalYes">SUBMIT</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Mark and Bulk Reject by CO End -->

<?php include 'dag_details_edit_form_co.php'; ?>

<!-- Zonal Value Search Modal -->

<?php include 'zonal_value_search_form_co.php'; ?>


<!-- Data Table Configuration -->
<script>
    $(document).on('click', '#bulkApproveByCO', function() {
        $('#bulkApproveModal').modal('show');
    });

        $(document).on('click', '#bulkRejectByCO', function() {
        $('#bulkRejectModal').modal('show');
    });

    $(document).on('click', '#bulkApproveModalNo', function() {
        $('#bulkApproveModal').modal('hide');
    });

        $(document).on('click', '#bulkRejectModalNo', function() {
        $('#bulkRejectModal').modal('hide');
    });
    // Revert Back to LM By CO
    function revertToLm(dag_no, village_uuid) {
        //e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Revert to LM!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/revert_zonaldetails/" ?>' + dag_no + '/' + village_uuid,
                    type: "POST",
                    success: function(data) {
                        // // alert(data);
                        // return;
                        window.location.reload(true);
                        console.log(data.success);
                        Swal.fire(
                            "Revert",
                            "Zonal Information Reverted Back to LM ",
                            "success"
                        );
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }

    // Reject Zonal Value By CO
    function rejectZonal(dag_no, village_uuid) {
        //e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            // text: "You won't be able to reject this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Rejected'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/reject_zonaldetails/" ?>' + dag_no + '/' + village_uuid,
                    type: "POST",
                    success: function(data) {
                        window.location.reload(true);
                        console.log(data.success);
                        Swal.fire(
                            "Rejected",
                            "Zonal Information Rejected By CO successfully",
                            "success",
                        );
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }
</script>

<script>
    function do_this() {
        var checkboxes1 = document.getElementsByName('dag_no[]');
        var checkboxes2 = document.getElementsByName('village_uuid[]');
        var button = document.getElementById('toggle');

        if (button.value == 'select all') {
            for (var i in checkboxes1) {
                checkboxes1[i].checked = 'FALSE';
            }
            for (var i in checkboxes2) {
                checkboxes2[i].checked = 'FALSE';
            }
            button.value = 'Deselect all'
        } else {
            for (var i in checkboxes1) {
                checkboxes1[i].checked = '';
            }
            for (var i in checkboxes2) {
                checkboxes2[i].checked = '';
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

            $('#datatableDagwisePendingCo').DataTable().destroy();
            load_data_dagwise_pending(village_uuid_pending);
        });
        load_data_dagwise_pending();

        // Load Dagwise Pending
        function load_data_dagwise_pending(village_uuid_pending) {
            $('#datatableDagwisePendingCo thead th:nth-of-type(2)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_pending = "<?= $dist_code ?>";
            var subdiv_code_pending = "<?= $subdiv_code ?>";
            var cir_code_pending = "<?= $cir_code ?>";
            var table = $('#datatableDagwisePendingCo').DataTable({
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
                    url: base_url + 'index.php/ZoneInformationController/viewPendingCasesZonalDagCO',
                    type: 'POST',
                    data: {
                        dist_code_pending: dist_code_pending,
                        subdiv_code_pending: subdiv_code_pending,
                        cir_code_pending: cir_code_pending,
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
                $('#datatableDagwisePendingCo').DataTable().destroy();
                load_data_dagwise_pending();
            });
        }


        // Load Dagwise Approved Zonal Details
        $('#village_zonal_approved').change(function(event) {
            var village_uuid_approved = $('#village_zonal_approved').val();
            $('#datatableDagwiseApprovedCo').DataTable().destroy();
            load_data_dagwise_approved(village_uuid_approved);
        });

        load_data_dagwise_approved();

        function load_data_dagwise_approved(village_uuid_approved) {
            $('#datatableDagwiseApprovedCo thead th:nth-of-type(1)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_approved = "<?= $dist_code ?>";
            var subdiv_code_approved = "<?= $subdiv_code ?>";
            var cir_code_approved = "<?= $cir_code ?>";
            var table = $('#datatableDagwiseApprovedCo').DataTable({
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
                    url: base_url + 'index.php/ZoneInformationController/viewApprovedCasesZonalDagCO',
                    type: 'POST',
                    data: {
                        dist_code_approved: dist_code_approved,
                        subdiv_code_approved: subdiv_code_approved,
                        cir_code_approved: cir_code_approved,
                        village_code_approved: village_uuid_approved,
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
                $('#datatableDagwiseApprovedCo').DataTable().destroy();
                load_data_dagwise_approved();
            });
        }
        // Load Dagwise Approved Zonal Details CO end


        // Load Reverted Approved Zonal Details
        $('#village_zonal_reverted').change(function(event) {
            var village_uuid_reverted = $('#village_zonal_reverted').val();
            $('#datatableDagwiseRevertedCo').DataTable().destroy();
            load_data_dagwise_reverted(village_uuid_reverted);
        });

        load_data_dagwise_reverted();

        function load_data_dagwise_reverted(village_uuid_reverted) {
            $('#datatableDagwiseRevertedCo thead th:nth-of-type(1)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_reverted = "<?= $dist_code ?>";
            var subdiv_code_reverted = "<?= $subdiv_code ?>";
            var cir_code_reverted = "<?= $cir_code ?>";
            var table = $('#datatableDagwiseRevertedCo').DataTable({
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
                    url: base_url + 'index.php/ZoneInformationController/viewRevertedCasesZonalDagCO',
                    type: 'POST',
                    data: {
                        dist_code_reverted: dist_code_reverted,
                        subdiv_code_reverted: subdiv_code_reverted,
                        cir_code_reverted: cir_code_reverted,
                        village_code_reverted: village_uuid_reverted,
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
                $('#datatableDagwiseRevertedCo').DataTable().destroy();
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



    // Bulk Reject by CO
        $(document).on('click', '#bulkRejectModalYes', function() {
        $('#bulkRejectModal').modal('hide');

        var dag_no_selected = [];
        $('.selectMark:checked').each(function(i) {

            dag_no_selected[i] = $(this).val();

        });

        if (dag_no_selected.length > 0) {
            const applicant = {
                dag_no_selected: dag_no_selected,
            };

            $.ajax({
                url: '<?php echo base_url() . "index.php/ZoneInformationController/bulkRejectByCO" ?>',
                type: "POST",
                dataType: "json",
                contentType: "application/json",
                success: function(data) {
                    if (data.responseType == 1) {
                        showErrorMessage("Zonal info Rejection Failed..!");
                    } else if (data.responseType == 2) {
                        alert(data.message);
                        location.reload();
                    } else if (data.responseType == 3) {
                        showWarningMessage("Please Select Dag No Before Reject !");
                    } else {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });

        } else {
            showWarningMessage("Please Select Dag No Before Reject!");
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
    function editDagDetailsCo(dag_no, unique_village_code, mouza_name, lot_name, village_name_string, zone_name, subclass_name, chitha_class_name_string) {

        $('#dag_no_co_update').val(dag_no);
        $('#vill_code_co_update').val(unique_village_code);

        $('#zv_update_dag_no_header').text(dag_no);
        $('#mouza_name_header_co').text(mouza_name);
        $('#lot_name_header_co').text(lot_name);
        $('#village_name_header_co').text(village_name_string);
        $('#zone_name_header_co').text(zone_name);
        $('#subclass_name_header_co').text(subclass_name);
        $('#chitha_class_name_header_co').text(chitha_class_name_string);



        $('#dag_details_edit_modal_co').modal('show');
    }

    function dag_edit_co_reset_modal() {
        $('#dag_details_edit_modal_co').fadeOut('slow').modal('hide');
        document.getElementById("dag_details_edit_form_co").reset();
    }


    //Update Dag Detals by CO wth New Zone and Subclass
    function updateDagDetailsCo() {

        var dag_no_co_update = $('#dag_no_co_update').val();
        var vill_code_co_update = $("#vill_code_co_update").val();
        var zone_name_update_co = $("#zone_name_update_co").val();
        var lclass_name_update_co = $("#lclass_name_update_co").val();

        const applicant = {
            dag_no_co_update: dag_no_co_update,
            vill_code_co_update: vill_code_co_update,
            zone_name_update_co: zone_name_update_co,
            lclass_name_update_co: lclass_name_update_co,
        };
        console.log(applicant);

        $.ajax({

            url: '<?php echo base_url() . "index.php/ZoneInformationController/updateDagDetailsByCo" ?>',
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