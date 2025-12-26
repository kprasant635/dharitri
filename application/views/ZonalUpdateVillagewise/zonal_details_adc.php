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
        <label for="radioTab1" class="mr-4" style="text-transform: uppercase;">Pending Villagewise Zonal Details<i class="fa fa-clock-o" aria-hidden="true"></i></label>
        <input type="radio" id="radioTab2" name="tab">
        <label for="radioTab2" class="mr-4" style="text-transform: uppercase;">Updated Villagewise Zonal Details<i class="fas fa-check-double" aria-hidden="true"></i></label>
    </div>
</center>

<!-- Pending Zonal Info ADC  -->
<article>
    <div class="col-lg-12">
        <div class="panel panel-warning panel-form">
            <div class="panel-heading">
                <span class="panel-title">Pending Zonal Information</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableZonalValuePendingADC' width="100%">
                    <thead>
                        <th scope="col" style="width: 10%;" class="center"><label class="control-label">Circle </label>
                        <th scope="col" style="width: 10%;" class="center"><label class="control-label">Lot </label>
                        <th scope="col" style="width: 20%;" class="center"><label class="control-label">Village </label>
                            <select class="form-control input_search" name="zonal_pending_adc" id="zonal_pending_adc" data-column-index="4">
                                <option value="">--SELECT--</option>
                                <?php if (isset($villageListPending)) {
                                    foreach ($villageListPending as $villageList) { ?>
                                        <option value="<?= $villageList ?>"><?= $this->utilityclass->getVillageNameByUUID($villageList); ?></option>
                                <?php }
                                } ?>
                            </select>
                        </th>
                        <th scope="col" class="center"><label class="control-label">Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Subclass </label></th>
                        <th scope="col" class="center"><label class="control-label">Zonal Value(LM)</label></th>
                        <th scope="col" class="center"><label class="control-label">Zonal Value(CO)</label></th>
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

<!-- Approved Zonal Info ADC  -->
<article>
    <div class="col-lg-12">
        <div class="panel panel-success panel-form">
            <div class="panel-heading">
                <span class="panel-title">Approved Zonal Information</span>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableZonalValueApprovedADC' width="100%">
                    <thead>
                        <th scope="col" style="width: 10%;" class="center"><label class="control-label">Circle </label>
                        <th scope="col" style="width: 10%;" class="center"><label class="control-label">Lot </label>
                        <th scope="col" style="width: 20%;" class="center"><label class="control-label">Village </label>
                            <select class="form-control input_search" name="zonal_approved_adc" id="zonal_approved_adc" data-column-index="4">
                                <option value="">--SELECT--</option>
                                <?php if (isset($villageListApproved)) {
                                    foreach ($villageListApproved as $villageList) { ?>
                                        <option value="<?= $villageList ?>"><?= $this->utilityclass->getVillageNameByUUID($villageList); ?></option>
                                <?php }
                                } ?>
                            </select>
                        </th>
                        <th scope="col" class="center"><label class="control-label">Zone </label></th>
                        <th scope="col" class="center"><label class="control-label">Sub Class </label></th>
                        <th scope="col" class="center"><label class="control-label">Land Rate (Zonal Value)</label><button type="button" class="search_button btn btn-sm btn-danger form-control">
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



<script type="text/javascript">
    $(document).ready(function() {

        // Load Pending  Zonal Details ADC
        $('#zonal_pending_adc').change(function(event) {
            var village_uuid_pending = $('#zonal_pending_adc').val();
            $('#datatableZonalValuePendingADC').DataTable().destroy();
            load_datatable_adc_pending(village_uuid_pending);
        });

        load_datatable_adc_pending();

        function load_datatable_adc_pending(village_uuid_pending) {

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_pending = "<?= $dist_code ?>";
            var table = $('#datatableZonalValuePendingADC').DataTable({
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
                    url: base_url + 'index.php/ZoneInformationController/viewPendingCasesZonalADC',
                    type: 'POST',
                    data: {
                        dist_code_pending: dist_code_pending,
                        village_uuid_pending: village_uuid_pending,
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
                $('#datatableZonalValuePendingADC').DataTable().destroy();
                load_datatable_adc_pending();
            });
        }
        // Load Pending Zonal Details ADC end


        // Load  Approved Zonal Details ADC
        $('#zonal_approved_adc').change(function(event) {
            var village_uuid_approved = $('#zonal_approved_adc').val();
            $('#datatableZonalValueApprovedADC').DataTable().destroy();
            load_datatable_adc_approved(village_uuid_approved);
        });

        load_datatable_adc_approved();

        function load_datatable_adc_approved(village_uuid_approved) {

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_approved = "<?= $dist_code ?>";
            var table = $('#datatableZonalValueApprovedADC').DataTable({
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
                    url: base_url + 'index.php/ZoneInformationController/viewApprovedCasesZonalADC',
                    type: 'POST',
                    data: {
                        dist_code_approved: dist_code_approved,
                        village_uuid_approved: village_uuid_approved,
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
                $('#datatableZonalValueApprovedADC').DataTable().destroy();
                load_datatable_adc_approved();
            });
        }
        // Load Zonal Details Approved ADC end

    });
</script>




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
    //Bulk Approved by  CO
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
    // Approve Villagewise Zonal Details by ADC sent by CO
    function approveByAdc(zone_code, subclass_code, unique_village_code) {

        var zone_code_pending = zone_code;
        var subclass_code_pending = subclass_code;
        var uuid_pending = unique_village_code;

        const zonal_data = {
            zone_code_pending: zone_code_pending,
            subclass_code_pending: subclass_code_pending,
            uuid_pending: uuid_pending,
        };

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal value sent by CO will be Approve for the the Zone and Subclass combination",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/approveZonaldetailsADC/" ?>',
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            // showSuccessMessage(data.message);
                            Swal.fire({
                                backdrop:true,
                                allowOutsideClick: false,
                                text: data.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    actions: 'my-actions',
                                    confirmButton: 'order-2',
                                }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    location.reload(true);
                                }
                                });
                            // location.reload();
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    data: JSON.stringify(zonal_data)
                });
            }
        })
    }





    // Reject Villagewise Zonal Details by ADC sent by CO
    function rejectByAdc(zone_code, subclass_code, unique_village_code) {

        var zone_code_pending = zone_code;
        var subclass_code_pending = subclass_code;
        var uuid_pending = unique_village_code;

        const zonal_data = {
            zone_code_pending: zone_code_pending,
            subclass_code_pending: subclass_code_pending,
            uuid_pending: uuid_pending,
        };

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal value enetered by LM for the the Zone and Subclass combination will be approved!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve LM Value!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/approveLMValueZonaldetailsADC/" ?>',
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            // showSuccessMessage(data.message);
                                Swal.fire({
                                backdrop:true,
                                allowOutsideClick: false,
                                text: data.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    actions: 'my-actions',
                                    confirmButton: 'order-2',
                                }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    location.reload(true);
                                }
                                });
                            // location.reload();
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    data: JSON.stringify(zonal_data)
                });
            }
        })
    }



    // Revert Villagewise Zonal Details by ADC sent by CO
    function revertByAdc(zone_code, subclass_code, unique_village_code) {

        var zone_code_pending = zone_code;
        var subclass_code_pending = subclass_code;
        var uuid_pending = unique_village_code;

        const zonal_data = {
            zone_code_pending: zone_code_pending,
            subclass_code_pending: subclass_code_pending,
            uuid_pending: uuid_pending,
        };

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal value Details will be Reverted to CO!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Revert!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/revertZonaldetailsADC/" ?>',
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            // showSuccessMessage(data.message);
                                Swal.fire({
                                backdrop:true,
                                allowOutsideClick: false,
                                text: data.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    actions: 'my-actions',
                                    confirmButton: 'order-2',
                                }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    location.reload(true);
                                }
                                });
                            // location.reload();
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    data: JSON.stringify(zonal_data)
                });
            }
        })
    }
</script>