<input type="hidden" value="<?php echo $dist_code ?>" id="selectDistrict">

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="reza-card">
            <div class="reza-body" id="showBody">
                <!-- DataTable starts-->
                <form method="POST">
                    <table class='table table-striped table-bordered' id='dataTableDigitalPatta' width="100%">
                        <thead>
                        <tr>
                            <th class="center">
                                <label class="control-label">Sl No</label>
                            </th>

                            <th class="center">
                                <label class="control-label">Case No</label>
                            </th>
                            <th class="center">
                                <label class="control-label">RTPS No</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Service</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Date</label>
                            </th>
                            <th class="center">
                                <label class="control-label">District</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Circle</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Village</label>
                                <select class="form-control input_search" name="village_list_dp" id="village_list_dp" data-column-index="4">
                                    <option value="">--SELECT--</option>
                                    <?php if (isset($locationCo)) {
                                        foreach ($locationCo as $villageList) { ?>
                                            <option value="<?= $this->utilityclass->getVillageUUID($villageList->dist_code,$villageList->subdiv_code,$villageList->cir_code,$villageList->mouza_pargona_code,$villageList->lot_no,$villageList->vill_townprt_code); ?>"><?= $this->utilityclass->getVillageName($villageList->dist_code,$villageList->subdiv_code,$villageList->cir_code,$villageList->mouza_pargona_code,$villageList->lot_no,$villageList->vill_townprt_code); ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </th>
                            <th scope="col" class="center" >
                                <label class="control-label">Action</label>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- DataTable ends -->
                    <div class="row">
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Datatable


    $(document).ready(function() {

        $('#village_list_dp').change(function(event) {
            var village_list_dp = $('#village_list_dp').val();
            $('#dataTableDigitalPatta').DataTable().destroy();
            load_data_digital_patta_view_list(village_list_dp);
        });
        let count = 1;
        load_data_digital_patta_view_list();
        //Load Datatable
        function load_data_digital_patta_view_list(village_list_dp = null) {

            $('#dataTableDigitalPatta thead th:nth-of-type(2)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder=" ' + title + '" />');
            });
            $('#dataTableDigitalPatta thead th:nth-of-type(3)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder=" ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var table = $('#dataTableDigitalPatta').DataTable({
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
                    url: base_url+'index.php/DigitalPatta/getAllDigitalPattaInCoLogin',
                    type: 'POST',
                    data: {
                        village_list_dp: village_list_dp
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],

                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0],
                    checkboxes: {
                        'selectRow': true
                    },
                    data: "is_visible",
                    'render': function(data, type, row) {
                        let text = row[0];

                        const myArray = text.split("/");
                        var arr = myArray[3];
                        //return '<input type="checkbox" class="checkBoxD selectMark" value=' + row[0] + ' id=' + arr + ' name="selectMark[]">';
                        return count++;
                    }
                }],
            });

            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });

        }

        $('.search_button').on('click', function() {
            $('table thead tr th .input_search').each(function() {
                $(this).val('');
            });
            $('#dataTableDigitalPatta').DataTable().destroy();
            load_data_digital_patta_view_list();
        });


        var selectedCheckBoxArray = [];
        maxCheckboxes = <?=DIGITAL_PATTA_CHECK_LIMIT?>;
        $('#dataTableDigitalPatta tbody').on('click', 'input[type="checkbox"]', function(e) {

            var checkBoxId = $(this).val();

            var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
            if (this.checked && rowIndex === -1) {
                selectedCheckBoxArray.push(checkBoxId);
            } else if (!this.checked && rowIndex !== -1) {
                selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
            }

            $('#txtBatchSize').val(selectedCheckBoxArray.length);

            if (selectedCheckBoxArray.length > maxCheckboxes) {
                $(this).prop('checked', false);
                alert('Only <?=DIGITAL_PATTA_CHECK_LIMIT?> cases can be selected at a time');
                location.reload(true);
                return;
            }
        });

        var alertShown = false;
        $("#checkedAll").click(function() {
            if (this.checked) {
                $('.selectMark').each(function() {
                    this.checked = true;
                    var id = $(this).val();
                    if (selectedCheckBoxArray.length > maxCheckboxes && !alertShown) {
                        alertShown = true;
                        $(this).prop('checked', false);
                        alert('Only <?=DIGITAL_PATTA_CHECK_LIMIT?> cases can be selected at a time');
                        location.reload(true);
                        return;
                    }
                    $('#txtBatchSize').val(selectedCheckBoxArray.length);
                    if ($.inArray(id, selectedCheckBoxArray) !== -1) {
                        // $('.selectMark').prop('checked', false);
                    } else {
                        selectedCheckBoxArray.push(id);
                        $('.selectMark').prop('checked', true);
                    }
                });
            } else {
                $('.selectMark').each(function() {
                    this.checked = false;
                    var id = $(this).val();
                    var rowIndex = $.inArray(id, selectedCheckBoxArray);
                    if (rowIndex !== -1) {
                        selectedCheckBoxArray.splice(rowIndex, 1);
                        $('.selectMark').prop('checked', false);
                    }
                });
                alertShown = false;
            }
        });



        $("#dataTableDigitalPatta").on('draw.dt', function() {
            for (var i = 0; i < selectedCheckBoxArray.length; i++) {
                checkboxId = selectedCheckBoxArray[i];
                const myArray = checkboxId.split("/");
                var arr = myArray[3];
                $('#' + arr).attr('checked', true);
            }
        });
    });


</script>