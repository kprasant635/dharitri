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
                    <button id="approveBtn" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve
                    </button>
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

    .village-row {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .village-row:last-child {
        border-bottom: none;
    }

    .village-info {
        flex: 1;
        padding: 0 15px;
    }

    .village-actions {
        min-width: 100px;
        text-align: right;
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
        $('.view-details').click(function() {
            const lacId = $(this).data('lac-id');

            // Show loading spinner
            $('#villageContainer').html(`
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3">Loading village data...</p>
            </div>
        `);

            
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/LACApprovalController/getVillageDetails',
                type: 'POST',
                data: {
                    lac_id: lacId,
                    status: 'f'
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
                )
            );
            var $tbody = $('<tbody>');

            // Add rows for each village
            data.villages.forEach(function(village) {
                $tbody.append(
                    $('<tr>').append(
                        $('<td>').text(village.district_name),
                        $('<td>').text(village.subdivision_name),
                        $('<td>').text(village.circle_name),
                        $('<td>').text(village.mouza_name),
                        $('<td>').text(village.village_name)
                    )
                );
            });

            $table.append($thead, $tbody);
            $container.html($table);

            $('#approveBtn').data('lac-id', data.lac_id);
        }

        $('#approveBtn').click(function() {
            const lacId = $(this).data('lac-id');

            if (!confirm('Are you sure you want to approve this LAC?')) {
                return;
            }

            $.post('<?php echo base_url(); ?>index.php/LACApprovalController/approveLAC', {
                lac_id: lacId
            }, function(response) {
                if (response == 1) {
                    alert('LAC approved successfully');
                    location.reload();
                } else {
                    alert('Error approving LAC');
                }
            });
        });
    });
</script>