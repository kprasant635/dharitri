<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ancillary Applications</h4>
        </div>
        <div class="card-body">
            <!-- Toast Container -->
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="toast toast-lg toast-success-card align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="6000" data-bs-autohide="true">
                        <div class="d-flex">
                            <div class="toast-body fw-semibold">
                                <i class="fas fa-check-circle me-2 toast-icon"></i>
                                <?php echo htmlspecialchars($this->session->flashdata('success')); ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="toast toast-lg toast-error-card align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="8000" data-bs-autohide="true">
                        <div class="d-flex">
                            <div class="toast-body fw-semibold">
                                <i class="fas fa-exclamation-triangle me-2 toast-icon"></i>
                                <?php echo htmlspecialchars($this->session->flashdata('error')); ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <style>
                .toast.toast-lg {
                    min-width: 420px;
                    min-height: 80px;
                    /* more height */
                    border-radius: 0.9rem;
                    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15) !important;
                }

                .toast.toast-lg .toast-body {
                    font-size: 1.1rem;
                    /* larger text */
                    line-height: 1.5;
                    padding: 1rem 1.1rem;
                    /* bigger padding */
                    color: #fff;
                    /* ensure contrast */
                }

                .toast-icon {
                    font-size: 1.2rem;
                }

                /* Full background colors for cards */
                .toast-success-card {
                    background-color: #198754;
                    /* Bootstrap success */
                    color: #fff;
                }

                .toast-error-card {
                    background-color: #dc3545;
                    /* Bootstrap danger */
                    color: #fff;
                }

                @media (max-width: 576px) {
                    .toast.toast-lg {
                        min-width: 280px;
                        min-height: 72px;
                    }
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                    toastElList.forEach(function(toastEl) {
                        try {
                            var t = new bootstrap.Toast(toastEl);
                            t.show();
                        } catch (e) {
                            // bootstrap not loaded; fail silently
                        }
                    });
                });
            </script>

            <?php
            // ✅ Check if any application has land details
            $hasLandDetails = false;
            if (!empty($applications)) {
                foreach ($applications as $app) {
                    if (!empty($app['land_details'])) {
                        $hasLandDetails = true;
                        break;
                    }
                }
            }
            ?>

            <?php if (!empty($applications)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Mastercase No.</th>
                                <th>RTPS App. No.</th>
                                <th>Applicant Name</th>
                                <th>Application Date</th>
                                <th>Status</th>

                                <?php if ($hasLandDetails): ?>
                                    <th>Sub Case No.</th>
                                    <th>Location</th>
                                <?php endif; ?>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($applications as $app): ?>
                                <?php
                                $lands = $app['land_details'] ?? [];
                                $landCount = count($lands);
                                ?>

                                <?php if (!empty($lands)): ?>
                                    <?php foreach ($lands as $index => $land): ?>
                                        <tr>
                                            <?php if ($index === 0): ?>
                                                <td rowspan="<?php echo $landCount; ?>"><?php echo $i++; ?></td>
                                                <td rowspan="<?php echo $landCount; ?>"><?php echo htmlspecialchars($app['dhar_application_no'] ?? 'N/A'); ?></td>
                                                <td rowspan="<?php echo $landCount; ?>"><?php echo htmlspecialchars($app['application_no'] ?? 'N/A'); ?></td>
                                                <td rowspan="<?php echo $landCount; ?>"><?php echo htmlspecialchars($app['applicant_name'] ?? 'N/A'); ?></td>
                                                <td rowspan="<?php echo $landCount; ?>">
                                                    <?php echo !empty($app['created_at']) ? date('d-m-Y', strtotime($app['created_at'])) : 'N/A'; ?>
                                                </td>
                                                <td rowspan="<?php echo $landCount; ?>">
                                                    <span class="badge badge-info">
                                                        <?php echo htmlspecialchars($app['status'] ?? 'Pending'); ?>
                                                    </span>
                                                </td>
                                            <?php endif; ?>

                                            <?php if ($hasLandDetails): ?>
                                                <td><?php echo htmlspecialchars($land['sub_case_no'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        ($land['circle_name'] ?? 'N/A') . ', ' .
                                                            ($land['village_name'] ?? 'N/A') . ', Lot No. ' .
                                                            ($land['lot_no'] ?? 'N/A')
                                                    );
                                                    ?>
                                                </td>
                                            <?php endif; ?>

                                            <?php if ($index === 0): ?>
                                                <td rowspan="<?php echo $landCount; ?>">
                                                    <a href="<?php echo site_url('ancillary/view/' . ($app['encrypted_id'] ?? '')); ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($app['dhar_application_no'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($app['application_no'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($app['applicant_name'] ?? 'N/A'); ?></td>
                                        <td><?php echo !empty($app['created_at']) ? date('d-m-Y', strtotime($app['created_at'])) : 'N/A'; ?></td>
                                        <td>
                                            <span class="badge badge-info">
                                                <?php echo htmlspecialchars($app['status'] ?? 'Pending'); ?>
                                            </span>
                                        </td>

                                        <?php if ($hasLandDetails): ?>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                        <?php endif; ?>

                                        <td>
                                            <a href="<?php echo site_url('ancillary/view/' . ($app['encrypted_id'] ?? '')); ?>"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if (isset($pagination_links)): ?>
                    <div class="mt-4">
                        <?php echo $pagination_links; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="alert alert-info">
                    No applications found.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>