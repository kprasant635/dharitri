<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">LAC Mapping</li>
        <li class="breadcrumb-item">
            <a href="<?php echo base_url('index.php/LACControler/viewSubmited'); ?>" class="btn btn-info btn-sm text-white">View Previous Submissions</a>
        </li>
    </ol>
</nav>



<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
            <!-- Flash Messages -->

            <div class="form-group">
                <?php if ($this->session->flashdata('success')): ?>
                    <?php
                    echo '<div class="col-lg-12">
                                    <label style="color:green;">' . $this->session->flashdata('success') . '</label>
                                </div>';
                    ?>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <?php
                    echo '<div class="col-lg-12">
                                    <label style="color:red;">' . $this->session->flashdata('error') . '</label>
                                </div>';
                    ?>
                <?php endif; ?>
            </div>

            <form method="post" action="<?php echo base_url('index.php/LACControler/process'); ?>">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lac">LAC:</label>
                            <select class="form-control" id="lac" name="lac">
                                <option value="">Select LAC</option>
                                <?php foreach ($lacs as $lac): ?>
                                    <option value="<?php echo $lac['id']; ?>">
                                        <?php echo $lac['name'] . " (" . $lac['district_name'] . ")"; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="district">District:</label>
                            <select class="form-control" id="district" name="district">
                                <option value="">Select District</option>
                                <?php foreach ($districts as $district): ?>
                                    <option value="<?php echo $district['dist_code']; ?>">
                                        <?php echo $district['district_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-secondary mt-2" id="fetch-villages" style="display: none;">
                                Fetch All Villages
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="subdivision">Subdivision:</label>
                            <select class="form-control" id="subdivision" name="subdivision">
                                <option value="">Select Subdivision</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mt-4">
                            <button type="button" id="finalize" class="btn btn-success w-100" data-toggle="modal" data-target="#finalizeModal">Finalize All LAC</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="border p-4 mb-4" style="border: 2px solid #000;">
                            <h4 class="mb-3">Select Villages</h4>
                            <div id="village-container">
                                <!-- Villages will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this modal after the form -->
<div class="modal fade" id="finalizeModal" tabindex="-1" role="dialog" aria-labelledby="finalizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizeModalLabel">Finalize LAC Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="remarks">Remarks:</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter any remarks or comments"></textarea>
                </div>
                <div id="tempDataContainer" class="temp-data-container">
                    <!-- Temporary data will be populated here -->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="finalizeSubmit" class="btn btn-primary">Finalize and Submit</button>
            </div>
        </div>
    </div>
</div>

<style>
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 10px;
        max-height: 400px;
        overflow-y: auto;
    }

    .subdivision-section {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .subdivision-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 5px 0;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .subdivision-header.collapsed {
        background-color: #f8f9fa;
    }

    .subdivision-header.collapsed .subdivision-title {
        color: #6c757d;
    }

    .subdivision-title {
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .subdivision-title i {
        transition: transform 0.3s ease;
    }

    .subdivision-header.collapsed .subdivision-title i {
        transform: rotate(-90deg);
    }

    .select-all-btn {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    .village-column {
        flex: 1;
        min-width: 200px;
        max-width: 200px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 4px;
        background-color: #f8f9fa;
    }

    .checkbox-item {
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 8px;
    }

    .checkbox-item label {
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .village-column {
            min-width: 100%;
            max-width: 100%;
        }

        .checkbox-container {
            flex-direction: column;
        }
    }

    .temp-data-container {
        max-height: 600px;
        overflow-y: auto;
        padding: 15px;
    }

    .temp-data-container .table {
        margin-bottom: 0;
    }

    .loading-spinner {
        text-align: center;
        padding: 20px;
    }

    .loading-spinner .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>


<script>
    $(document).ready(function() {
        // When district changes, load subdivisions and show fetch villages button
        $('#district').change(function() {
            var dist_code = $(this).val();
            if (dist_code) {
                $('#fetch-villages').show();
                $.ajax({
                    url: '<?php echo base_url('index.php/LACControler/getSubdivisions'); ?>',
                    type: 'POST',
                    data: {
                        dist_code: dist_code
                    },
                    success: function(response) {
                        var subdivisions = JSON.parse(response);
                        var $subdivision = $('#subdivision');
                        $subdivision.empty().append('<option value="">Select Subdivision</option>');
                        $.each(subdivisions, function(index, subdivision) {
                            $subdivision.append(
                                $('<option></option>')
                                .attr('value', subdivision.subdiv_code)
                                .text(subdivision.subdivision_name)
                            );
                        });
                    }
                });
            } else {
                $('#subdivision').empty().append('<option value="">Select Subdivision</option>');
                $('#village-container').empty();
                $('#fetch-villages').hide();
            }
        });

        // When subdivision changes, load villages
        $('#subdivision').change(function() {
            var dist_code = $('#district').val();
            var subdiv_code = $(this).val();
            if (subdiv_code) {
                $.ajax({
                    url: '<?php echo base_url('index.php/LACControler/getVillages'); ?>',
                    type: 'POST',
                    data: {
                        dist_code: dist_code,
                        subdiv_code: subdiv_code
                    },
                    success: function(response) {
                        var villages = JSON.parse(response);
                        populateVillages(villages);
                    }
                });
            } else {
                $('#village-container').empty();
            }
        });

        // Handle fetch all villages button click
        $('#fetch-villages').click(function() {
            var dist_code = $('#district').val();
            if (dist_code) {
                $.ajax({
                    url: '<?php echo base_url('index.php/LACControler/getAllVillages'); ?>',
                    type: 'POST',
                    data: {
                        dist_code: dist_code
                    },
                    success: function(response) {
                        var villages = JSON.parse(response);
                        populateVillages(villages);
                    }
                });
            }
        });

        // Add validation before form submission
        $('form').on('submit', function(e) {
            var lac = $('#lac').val();
            var district = $('#district').val();
            var selectedVillages = $('input[name="villages[]"]:checked').length;

            if (!lac) {
                alert('Please select LAC');
                e.preventDefault();
                return false;
            }

            if (!district) {
                alert('Please select District');
                e.preventDefault();
                return false;
            }

            if (selectedVillages === 0) {
                alert('Please select at least one village');
                e.preventDefault();
                return false;
            }

            return true;
        });

        // Function to populate villages container
        function populateVillages(villages) {
            var $container = $('#village-container');
            $container.empty();

            if (villages.length > 0) {
                // Group villages by subdivision
                var groupedVillages = {};
                villages.forEach(function(village) {
                    if (!groupedVillages[village.subdiv_code]) {
                        groupedVillages[village.subdiv_code] = [];
                    }
                    groupedVillages[village.subdiv_code].push(village);
                });

                // Create sections for each subdivision
                Object.keys(groupedVillages).forEach(function(subdivCode) {
                    getSubdivisionName(subdivCode).then(function(subdivisionName) {
                        var $section = $('<div class="subdivision-section collapsed">');
                        var $header = $('<div class="subdivision-header">')
                            .append('<div class="subdivision-title">' +
                                '<i class="fas fa-chevron-right"></i>' +
                                ' ' + subdivisionName + '</div>')
                            .append('<div class="select-all-btn" data-subdiv="' + subdivCode + '">Select All</div>');

                        $section.append($header);

                        // Create checkbox container
                        var $checkboxContainer = $('<div class="checkbox-container">');
                        var villagesPerColumn = 20;
                        var totalColumns = Math.ceil(groupedVillages[subdivCode].length / villagesPerColumn);

                        // Create columns
                        var columns = [];
                        for (var i = 0; i < totalColumns; i++) {
                            columns.push($('<div class="village-column"></div>'));
                            $checkboxContainer.append(columns[i]);
                        }

                        // Distribute villages across columns
                        groupedVillages[subdivCode].forEach(function(village, index) {
                            var columnIndex = Math.floor(index / villagesPerColumn);
                            var fullCode = village.uuid + '_' + village.dist_code + '_' + village.subdiv_code + '_' + village.cir_code + '_' + village.mouza_pargona_code + '_' + village.lot_no + '_' + village.vill_townprt_code;
                            columns[columnIndex].append(
                                $('<div class="checkbox-item">').append(
                                    $('<input>', {
                                        type: 'checkbox',
                                        name: 'villages[]',
                                        value: fullCode,
                                        id: 'village-' + village.vill_townprt_code,
                                        class: 'village-checkbox-' + village.subdiv_code
                                    }),
                                    $('<label>', {
                                        'for': 'village-' + village.vill_townprt_code,
                                        text: village.village_name
                                    })
                                )
                            );
                        });

                        $section.append($checkboxContainer);
                        $container.append($section);

                        // Initially hide the checkbox container
                        $checkboxContainer.hide();
                    });
                });
            }
        }

        // Function to get subdivision name
        function getSubdivisionName(subdivCode) {
            return new Promise(function(resolve) {
                $.ajax({
                    url: '<?php echo base_url('index.php/LACControler/getSubdivisionName'); ?>',
                    type: 'POST',
                    data: {
                        dist_code: $('#district').val(),
                        subdiv_code: subdivCode
                    },
                    success: function(response) {
                        var subdivision = JSON.parse(response);
                        console.log(subdivision);
                        resolve(subdivision[0].subdivision_name || 'Subdivision ' + subdivCode);
                    }
                });
            });
        }

        // Function to get village names in bulk
        function getVillageNamesBulk(data) {
            return new Promise(function(resolve) {
                var villageCodes = data.map(function(item) {
                    return {
                        dist_code: item.dist_code,
                        subdiv_code: item.subdiv_code,
                        cir_code: item.cir_code,
                        mouza_code: item.mouza_pargona_code,
                        lot_no: item.lot_no,
                        vill_townprt_code: item.vill_townprt_code
                    };
                });

                $.ajax({
                    url: '<?php echo base_url('index.php/LACControler/getVillageNamesBulkFinalize'); ?>',
                    type: 'POST',
                    data: {
                        village_codes: JSON.stringify(villageCodes)
                    },
                    success: function(response) {
                        var villageNames = JSON.parse(response);
                        resolve(villageNames);
                    }
                });
            });
        }

        // Function to display temporary data
        function displayTempData(data) {
            var $container = $('#tempDataContainer');

            if (data.length === 0) {
                $container.html('<p class="text-center">No temporary data available</p>');
                return;
            }

            // Create a table structure
            var $table = $('<table class="table table-bordered table-striped">');
            var $thead = $('<thead class="bg-primary text-white">').append(
                $('<tr>').append(
                    $('<th>').text('LAC Name'),
                    $('<th>').text('District Name'),
                    $('<th>').text('Subdivision Name'),
                    $('<th>').text('Circle Name'),
                    $('<th>').text('Mouza Name'),
                    $('<th>').text('Village Name')
                )
            );
            var $tbody = $('<tbody>');

            // Create table rows directly from the data
            data.forEach(function(item) {
                var $row = $('<tr>').append(
                    $('<td>').text(item.lac_name || 'LAC ' + item.lac_id),
                    $('<td>').text(item.district_name || ''),
                    $('<td>').text(item.subdivision_name || ''),
                    $('<td>').text(item.circle_name || ''),
                    $('<td>').text(item.mouza_name || ''),
                    $('<td>').text(item.village_name || '')
                );
                $tbody.append($row);
            });

            $table.append($thead, $tbody);
            $container.html($table);
        }
        // Handle finalize button click
        $('#finalize').click(function() {
            var $container = $('#tempDataContainer');
            $container.html(`
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3">Loading village data...</p>
                </div>
            `);

            $.ajax({
                url: '<?php echo base_url('index.php/LACControler/getTempData'); ?>',
                type: 'POST',
                success: function(response) {
                    var tempData = JSON.parse(response);
                    displayTempData(tempData);
                }
            });
        });

        // Handle finalize submit button click
        $('#finalizeSubmit').click(function() {
            var remarks = $('#remarks').val();

            $.ajax({
                url: '<?php echo base_url('index.php/LACControler/finalizeMapping'); ?>',
                type: 'POST',
                data: {
                    remarks: remarks
                },
                success: function(response) {
                    if (response == 1) {
                        alert('LAC mapping finalized successfully!');
                        location.reload();
                    } else {
                        alert('Error finalizing LAC mapping');
                    }
                }
            });
        });

        // Handle subdivision header click to toggle visibility
        $(document).on('click', '.subdivision-header', function(e) {
            // If the click was on the select-all button, don't toggle the section
            if ($(e.target).closest('.select-all-btn').length) {
                return;
            }

            var $section = $(this).closest('.subdivision-section');
            var $checkboxContainer = $section.find('.checkbox-container');
            var $title = $(this).find('.subdivision-title i');

            $section.toggleClass('collapsed');
            $checkboxContainer.slideToggle();
            $title.toggleClass('fa-chevron-right fa-chevron-down');
        });

        // Handle select all button click
        $(document).on('click', '.select-all-btn', function(e) {
            e.stopPropagation(); // Prevent the click from bubbling up to the header
            var subdivCode = $(this).data('subdiv');
            var $checkboxes = $('.village-checkbox-' + subdivCode);
            var isChecked = $checkboxes.first().prop('checked');

            $checkboxes.prop('checked', !isChecked);
        });
    });
</script>