<?php
$this->load->helper('html');
$this->load->helper('url');
?>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h4>LAC Approval List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>LAC ID</th>
                            <th>LAC Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($finalizeData as $lac): ?>
                            <tr>
                                <td><?php echo $lac['lac_id']; ?></td>
                                <td><?php echo $lac['lac_name']; ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm view-details"
                                        data-toggle="modal"
                                        data-target="#villageDetailsModal"
                                        data-lac-id="<?php echo $lac['lac_id']; ?>">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>
                                    <a href="<?php echo base_url('index.php/LACControler/downloadPdf/' . $lac['lac_id']); ?>" 
                                       class="btn btn-info btn-sm"
                                       target="_blank">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                    <button class="btn btn-success btn-sm finalize-lac" 
                                            data-toggle="modal" 
                                            data-target="#finalizeModal"
                                            data-lac-id="<?php echo $lac['lac_id']; ?>">
                                        <i class="fas fa-check"></i> Finalize
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Village Details Modal -->
    <div class="modal fade" id="villageDetailsModal" tabindex="-1" role="dialog" aria-labelledby="villageDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="villageDetailsModalLabel">Village Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="villageContainer" class="temp-data-container">
                        <!-- Village data will be populated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="" class="btn btn-primary edit-lac-link">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Finalize Modal -->
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
</div>

<style>
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
        // Store the current LAC ID for print functionality
        var currentLacId = null;

        // View details button click handler
        $('.view-details').click(function() {
            const lacId = $(this).data('lac-id');
            currentLacId = lacId; // Store the current LAC ID
            $('#villageDetailsModal').data('current-lac-id', lacId); // Set the data attribute on modal
            
            // Update the print button href
            $('#printTableBtn').attr('href', '<?php echo base_url('index.php/LACControler/downloadPdf'); ?>' + '/' + lacId);
            
            // Update the edit link href
            $('.edit-lac-link').attr('href', '<?php echo base_url('index.php/LACControler/index'); ?>' + '/' + lacId);
            
            $('#villageContainer').html(`
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3">Loading village data...</p>
                </div>
            `);

            // Get village details
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/LACApprovalController/getVillageDetails',
                type: 'POST',
                data: {
                    lac_id: lacId,
                    status: 't'
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Full Response:', response);
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    displayVillageData(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Error fetching village details');
                }
            });
        });

        // Print button click handler
        $('#printTableBtn').click(function(e) {
            e.preventDefault();

            // Get the current LAC ID
            const lacId = currentLacId;

            // Send AJAX request to print
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/LACControler/printPdf',
                type: 'POST',
                data: {
                    lac_id: lacId
                },
                success: function(response) {
                    console.log('Print Response:', response);
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    // Handle print response
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Error printing');
                }
            });
        });

        // Finalize button click handler
        $('.finalize-lac').click(function() {
            const lacId = $(this).data('lac-id');
            $('#finalizeModal').data('current-lac-id', lacId);
            
            // Get village details for finalize
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/LACControler/getTempData',
                type: 'POST',
                data: {
                    lac_id: lacId
                },
                dataType: 'json',
                success: function(response) {
                    displayTempData(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching village details:', error);
                    alert('Error fetching village details');
                }
            });
        });

        // Finalize submit handler
        $('#finalizeSubmit').click(function() {
            const lacId = $('#finalizeModal').data('current-lac-id');
            const remarks = $('#remarks').val();
            
            if (!lacId) {
                alert('No LAC selected');
                return;
            }

            $.ajax({
                url: '<?php echo base_url(); ?>index.php/LACControler/finalizeMapping',
                type: 'POST',
                data: {
                    lac_id: lacId,
                    remarks: remarks
                },
                success: function(response) {
                    if (response == 1) {
                        alert('LAC mapping finalized successfully');
                        location.reload();
                    } else {
                        alert('Failed to finalize LAC mapping');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error finalizing mapping:', error);
                    alert('Error finalizing mapping');
                }
            });
        });

        function displayVillageData(data) {
            var $container = $('#villageContainer');
            $container.empty();

            // Create a table structure
            var $table = $('<table class="table table-bordered table-striped">');
            var $thead = $('<thead class="bg-primary text-white">').append(
                $('<tr>').append(
                    $('<th>').text('District Name'),
                    $('<th>').text('Subdivision Name'),
                    $('<th>').text('Circle Name'),
                    $('<th>').text('Mouza Name'),
                    $('<th>').text('Village Name'),
                    $('<th>').text('Action')
                )
            );
            var $tbody = $('<tbody>');

            // Add rows for each village
            data.villages.forEach(function(village) {
                console.log(village);
                $tbody.append(
                    $('<tr>').append(
                        $('<td>').text(village.district_name || 'N/A'),
                        $('<td>').text(village.subdivision_name || 'N/A'),
                        $('<td>').text(village.circle_name || 'N/A'),
                        $('<td>').text(village.mouza_name || 'N/A'),
                        $('<td>').text(village.village_name || 'N/A'),
                        $('<td>').append(
                            $('<button>').addClass('btn btn-danger btn-sm delete-row').text('Delete').data('id', village.id)
                        )
                    )
                );
            });

            $table.append($thead, $tbody);
            $container.html($table);

            // Add click handler for delete buttons
            $('.delete-row').click(function() {
                if (!confirm('Are you sure you want to delete this transaction?')) {
                    return false;
                }

                const $button = $(this);
                const transactionId = $button.data('id');
                const $row = $button.closest('tr');
                const $modal = $('#villageDetailsModal');
                const lacId = $modal.data('current-lac-id');
                
                // Show loading state
                $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
                
                // Make AJAX call to delete the transaction
                $.ajax({
                    url: '<?php echo base_url('index.php/LACControler/deleteTransaction'); ?>' + '/' + transactionId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response == 1) {
                            // Show success message
                            alert('Transaction deleted successfully');
                            showAlert('Transaction deleted successfully', 'success');
                            
                            // Remove the row from the table with animation
                            $row.fadeOut(400, function() {
                                $(this).remove();
                                // If no more rows left, show a message
                                if ($tbody.find('tr').length === 0) {
                                    $container.html('<div class="alert alert-info">No villages found</div>');
                                    // Close the modal after a delay
                                    setTimeout(function() {
                                        $modal.modal('hide');
                                    }, 1500);
                                } else {
                                    // If there are still rows, reload the modal content
                                    reloadModalContent(lacId);
                                }
                            });
                        } else {
                            alert('Failed to delete transaction. Data Already Approved of Finalized');
                            showAlert('Failed to delete transaction', 'danger');
                            $button.prop('disabled', false).html('<i class="fas fa-trash"></i> Delete');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting transaction:', error);
                        showAlert('An error occurred while deleting the transaction', 'danger');
                        $button.prop('disabled', false).html('<i class="fas fa-trash"></i> Delete');
                    }
                });
            });

            // Function to reload modal content
            function reloadModalContent(lacId) {
                // Show loading spinner
                $('#villageContainer').html(`
                    <div class="loading-spinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-3">Refreshing data...</p>
                    </div>
                `);

                // Get updated village details
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/LACApprovalController/getVillageDetails',
                    type: 'POST',
                    data: {
                        lac_id: lacId,
                        status: 't'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            showAlert(response.error, 'danger');
                            return;
                        }
                        displayVillageData(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        showAlert('Error refreshing village details', 'danger');
                    }
                });
            }

            // Function to show alert messages
            function showAlert(message, type) {
                // Remove any existing alerts
                $('.alert-dismissible').alert('close');
                
                const $alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                    message +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button></div>');
                
                // Insert alert before the container
                $alert.insertBefore($('#villageContainer'));
                
                // Auto-remove alert after 5 seconds
                setTimeout(function() {
                    $alert.alert('close');
                }, 5000);
            }
        }

        function displayTempData(data) {
            var $container = $('#tempDataContainer');
            $container.empty();

            // Create a table structure
            var $table = $('<table class="table table-bordered table-striped">');
            var $thead = $('<thead class="bg-primary text-white">').append(
                $('<tr>').append(
                    $('<th>').text('LAC Name'),
                    $('<th>').text('District'),
                    $('<th>').text('Subdivision'),
                    $('<th>').text('Circle'),
                    $('<th>').text('Mouza'),
                    $('<th>').text('Village')
                )
            );
            var $tbody = $('<tbody>');

            // Add rows for each village
            data.forEach(function(village) {
                $tbody.append(
                    $('<tr>').append(
                        $('<td>').text(village.lac_name || 'N/A'),
                        $('<td>').text(village.district_name || 'N/A'),
                        $('<td>').text(village.subdivision_name || 'N/A'),
                        $('<td>').text(village.circle_name || 'N/A'),
                        $('<td>').text(village.mouza_name || 'N/A'),
                        $('<td>').text(village.village_name || 'N/A')
                    )
                );
            });

            $table.append($thead, $tbody);
            $container.html($table);
        }
    });
</script>