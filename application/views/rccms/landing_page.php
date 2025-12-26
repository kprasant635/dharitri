<style>
    /* Card look */
    .case-table-card {
        border: 1px solid #d9dee3;
        border-radius: 8px;
        overflow: hidden;
    }

    /* Table base */
    #CasesTable {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 14px;
    }

    /* Header styling */
    #CasesTable thead th {
        background: #f1f5f9;
        color: #0f172a;
        font-weight: 600;
        border-bottom: 2px solid #2563eb;
        border-top: 1px solid #d9dee3;
        border-right: 1px solid #d9dee3;
        white-space: nowrap;
    }

    /* First & last header borders */
    #CasesTable thead th:first-child {
        border-left: 1px solid #d9dee3;
    }

    #CasesTable thead th:last-child {
        border-right: 1px solid #d9dee3;
    }

    /* Body cells */
    #CasesTable tbody td {
        border-right: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    /* First column left border */
    #CasesTable tbody tr td:first-child {
        border-left: 1px solid #e5e7eb;
    }

    /* Zebra effect */
    #CasesTable tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    /* Hover effect */
    #CasesTable tbody tr:hover {
        background-color: #e0f2fe;
    }

    /* Action button */
    #CasesTable .btn-success {
        background-color: #16a34a;
        border-color: #15803d;
        font-size: 13px;
        padding: 4px 10px;
    }
</style>

<div class="container mt-5">
    <h3 class="text-center mb-4">RCCMS Case Search</h3>

    <!-- <form action="<?php echo site_url('rccms/search_case'); ?>" method="post">
        <div class="input-group mb-3">
            <input type="text" name="case_number" class="form-control form-control-lg"
                placeholder="Enter RCCMS case number here"
                value="<?php echo isset($_POST['case_number']) ? htmlspecialchars($_POST['case_number']) : ''; ?>"
                required>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </form> -->

    <?php



    // Demo cases table - shows when controller doesn't supply demo_cases
    // if (!isset($demo_cases) || empty($demo_cases)) {
    //     $demo_cases = [
    //         [
    //             'applicationId' => 'RCMS2025101500458',
    //             'district' => 'Kamrup',
    //             'village_name' => 'Sonapur',
    //             'circle' => 'Dispur'
    //         ],
    //         [
    //             'applicationId' => 'RCMS2025020300001',
    //             'district' => 'Nagaon',
    //             'village_name' => 'Kampur',
    //             'circle' => 'Raha'
    //         ],
    //         [
    //             'applicationId' => 'RCMS2025101500459',
    //             'district' => 'Jorhat',
    //             'village_name' => 'Titabor',
    //             'circle' => 'Jorhat'
    //         ],
    //     ];

    // }
    // ?>

    <div class="card mt-4">
        <div class="card-header bg-primary">
            <strong style="color:#fffefe">Cases Lists</strong>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="CasesTable" class="table table-sm table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Application ID</th>
                            <th>District</th>
                            <th>Village Name</th>
                            <th>Circle</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cases)): ?>
                            <?php foreach ($cases as $dc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($dc['applicationId'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($dc['district'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($dc['village_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($dc['circle'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <a href="<?= site_url('rccms/show_rccms_details/' . $dc['applicationId']); ?>"
                                            class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center"
                                            style="min-width: 70px; color: #fff;">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No records found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>






    <!-- <?php if (!empty($api_response) && isset($api_response['status'])): ?>
        <?php if ($api_response['status'] === 'success'): ?>
            <div class="mt-3">
                <p><?php echo htmlspecialchars($api_response['message'] ?? 'Success', ENT_QUOTES, 'UTF-8'); ?></p>

                <form action="<?php echo base_url('index.php/rccms/show_rccms_details'); ?>" method="post">
                    <input type="hidden" name="applicationId"
                        value="<?php echo htmlspecialchars($api_response['data']['applicationId'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="api_data" value='<?php echo json_encode($api_response); ?>'>
                    <button type="submit" class="btn btn-success btn-sm">Show Details</button>

                </form>
            </div>




        <?php else: ?>
            <div class="mt-3">
                <p><?php echo htmlspecialchars($api_response['message'] ?? 'Error in fetching data', ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="mt-3">
            <p><?php echo "No response received from API."; ?></p>
        </div>
    <?php endif; ?> -->

</div>


<script>
    $(function () {
        $('#CasesTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true
        });
    });
</script>