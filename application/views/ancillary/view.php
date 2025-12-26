<div class="container-fluid px-4 py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Application Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('AncillaryController') ?>">Applications</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= site_url('AncillaryController') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
            <!-- <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Print
            </button> -->
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="ancillaryTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="app-details-tab" data-bs-toggle="tab" data-toggle="tab" href="#app-details" role="tab" aria-controls="app-details" aria-selected="true" onclick="switchTab('app-details'); return false;">Application Details</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="applicant-details-tab" data-bs-toggle="tab" data-toggle="tab" href="#applicant-details" role="tab" aria-controls="applicant-details" aria-selected="false" onclick="switchTab('applicant-details'); return false;">
                <i class=" me-1"></i>Applicant Details
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="lra-checklist-view-tab" data-bs-toggle="tab" data-toggle="tab" href="#lra-checklist-view" role="tab" aria-controls="lra-checklist-view" aria-selected="false" onclick="switchTab('lra-checklist-view'); return false;">LRA Checklist</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="premium-tab" data-bs-toggle="tab" data-toggle="tab" href="#premium" role="tab" aria-controls="premium" aria-selected="false" onclick="switchTab('premium'); return false;">
                <i class="fas text-warning me-1"></i>Premium
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="proceedings-tab" data-bs-toggle="tab" data-toggle="tab" href="#proceedings" role="tab" aria-controls="proceedings" aria-selected="false" onclick="switchTab('proceedings'); return false;">Proceedings</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="remarks-tab" data-bs-toggle="tab" data-toggle="tab" href="#remarks" role="tab" aria-controls="remarks" aria-selected="false" onclick="switchTab('remarks'); return false;">Remarks / Action</a>
        </li>
    </ul>
    <div class="tab-content" id="ancillaryTabsContent">
        <div class="tab-pane show active" id="app-details" role="tabpanel" aria-labelledby="app-details-tab">

            <!-- Application Details Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>Application Information
                    </h5>
                    <!-- <span class="badge bg-white text-primary"><?= strtoupper($application['application_status']) ?></span> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small mb-1">Application Number</h6>
                                <p class="mb-0 h5"><?= $application['application_no'] ?></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small mb-1">RTPS Reference</h6>
                                <p class="mb-0"><?= $application['rtps_ref_no'] ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small mb-1">Applicant Name</h6>
                                <p class="mb-0 h5"><?= $application['applicant_name'] ?></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small mb-1">Application Date</h6>
                                <p class="mb-0"><?= date('d M Y', strtotime($application['application_date'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 p-3 rounded">
                        <div class="col-12">
                            <h6 class="text-muted small mb-2">Total Land Area</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <?php 
                                // Get the values, defaulting to 0 if not set
                                $bigha = isset($application['total_bigha']) ? $application['total_bigha'] : 0;
                                $katha = isset($application['total_katha']) ? $application['total_katha'] : 0;
                                $lessa = isset($application['total_lessa']) ? $application['total_lessa'] : 0;
                                $ganda = isset($application['total_ganda']) ? $application['total_ganda'] : 0;
                                $is_barak_valley = !empty($application['is_barak_valley']) && $application['is_barak_valley'] === 'N';
                                
                                // Always show Bigha, Katha, and Lessa/Chatak
                                $area_parts = [];
                                $area_parts[] = '<div class="land-unit"><span class="land-value">' . $bigha . '</span><span class="land-label">Bigha</span></div>';
                                $area_parts[] = '<div class="land-unit"><span class="land-value">' . $katha . '</span><span class="land-label">Katha</span></div>';
                                $area_parts[] = '<div class="land-unit"><span class="land-value">' . $lessa . '</span><span class="land-label">' . ($is_barak_valley ? 'Lessa' : 'Chatak') . '</span></div>';
                                
                                // Add Ganda only if not Barak Valley
                                if (!$is_barak_valley) {
                                    $area_parts[] = '<div class="land-unit"><span class="land-value">' . $ganda . '</span><span class="land-label">Ganda</span></div>';
                                }
                                
                                // Output all area parts
                                echo implode("\n", $area_parts);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Land Details Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-map-marked-alt me-2"></i>Land Information
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#landDetailsCollapse" aria-expanded="true" aria-controls="landDetailsCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="landDetailsCollapse">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sub-Case No</th>
                                        <th>Estate</th>
                                        <th>District</th>
                                        <th>Circle</th>
                                        <th>Lot No</th>
                                        <th>Village</th>
                                        <th>Patta Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($land_details as $land): ?>
                                        <tr>
                                            <td><strong><?= $land['sub_case_no'] ?></strong></td>
                                            <td><strong><?= $land['estate'] ?></strong></td>
                                            <td><?= $land['district_name'] ?></td>
                                            <td><?= $land['circle_name'] ?></td>
                                            <td><span class="badge bg-primary"><?= $land['lot_no'] ?></span></td>
                                            <td><?= $land['village_name'] ?></td>
                                            <td><span class="badge bg-info text-dark"><?= $land['patta_type_name'] ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Land Status Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Land Status
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#landStatusCollapse" aria-expanded="true" aria-controls="landStatusCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="landStatusCollapse">
                    <div class="card-body p-0">
                        <?php if (!empty($land_status)): ?>
                            <?php $status = $land_status[0]; ?>
                            <div class="row g-3 p-3">
                                <?php
                                $statusTypes = [
                                    'cultivation' => ['icon' => 'seedling', 'title' => 'Cultivation', 'color' => 'success'],
                                    'encroachment' => ['icon' => 'exclamation-triangle', 'title' => 'Encroachment', 'color' => 'danger'],
                                    'unused' => ['icon' => 'ban', 'title' => 'Unused', 'color' => 'secondary'],
                                    'ancillary' => ['icon' => 'layer-group', 'title' => 'Ancillary', 'color' => 'info'],
                                    'transferred_land' => ['icon' => 'exchange-alt', 'title' => 'Transferred Land', 'color' => 'warning'],
                                    'ryotee_khatian' => ['icon' => 'file-alt', 'title' => 'Ryotee Khatian', 'color' => 'primary']
                                ];

                                foreach ($statusTypes as $key => $type):
                                    if (!empty($status["{$key}_bigha"]) || !empty($status["{$key}_katha"]) || !empty($status["{$key}_lessa"]) || !empty($status["{$key}_ganda"])):
                                ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-<?= $type['color'] ?>-light text-<?= $type['color'] ?> me-3">
                                                            <i class="fas fa-<?= $type['icon'] ?>"></i>
                                                        </div>
                                                        <h6 class="mb-0"><?= $type['title'] ?></h6>
                                                    </div>
                                                    <div class="land-measurement">
                                                        <?php
                                                        if (!empty($application['is_barak_valley']) && $application['is_barak_valley'] === 'Y'):
                                                            // For Barak Valley: Show Bigha, Katha, Chatak, Ganda
                                                            $units = [
                                                                'bigha' => $status["{$key}_bigha"],
                                                                'katha' => $status["{$key}_katha"],
                                                                'chatak' => $status["{$key}_lessa"], // Using lessa value as chatak for Barak Valley
                                                                'ganda' => $status["{$key}_ganda"]
                                                            ];
                                                        else:
                                                            // For other regions: Show Bigha, Katha, Lessa
                                                            $units = [
                                                                'bigha' => $status["{$key}_bigha"],
                                                                'katha' => $status["{$key}_katha"],
                                                                'lessa' => $status["{$key}_lessa"]
                                                            ];
                                                        endif;

                                                        foreach ($units as $unit => $value):
                                                            if (!empty($value) && $value > 0):
                                                        ?>
                                                                <div class="measurement-item">
                                                                    <span class="value"><?= $value ?></span>
                                                                    <span class="unit"><?= ucfirst($unit) ?></span>
                                                                </div>
                                                        <?php
                                                            endif;
                                                        endforeach;
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No land status information available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Patta Details -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-file-alt me-2"></i>Patta Details
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#pattaDetailsCollapse" aria-expanded="true" aria-controls="pattaDetailsCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="pattaDetailsCollapse">
                    <div class="card-body p-0">
                        <?php if (!empty($patta_details)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Patta Number</th>
                                            <th>District</th>
                                            <th>Circle</th>
                                            <th>Lot No</th>
                                            <th>Village</th>
                                            <th>Patta Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Create a mapping of land_detail_id to land details for quick lookup
                                        $land_details_map = [];
                                        foreach ($land_details as $land) {
                                            $land_details_map[$land['id']] = $land;
                                        }
                                        ?>
                                        <?php foreach ($patta_details as $patta): 
                                            $land = $land_details_map[$patta['land_detail_id']] ?? null;
                                            if (!$land) continue;
                                        ?>
                                            <tr>
                                                <td><span class="badge bg-primary"><?= $patta['patta_number'] ?></span></td>
                                                <td><?= $land['district_name'] ?></td>
                                                <td><?= $land['circle_name'] ?></td>
                                                <td><span class="badge bg-primary"><?= $land['lot_no'] ?></span></td>
                                                <td><?= $land['village_name'] ?></td>
                                                <td><span class="badge bg-info text-dark"><?= $land['patta_type_name'] ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No patta details available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- DAG Details Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-map-marked-alt me-2"></i>DAG Details
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#dagDetailsCollapse" aria-expanded="true" aria-controls="dagDetailsCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="dagDetailsCollapse">
                    <div class="card-body p-0">
                        <?php
                        // Group DAGs by both patta_number and land_detail_id
                        $grouped_dags = [];
                        foreach ($dag_details as $dag) {
                            $group_key = $dag['patta_number'] . '_' . ($dag['land_detail_id'] ?? '0');
                            $grouped_dags[$group_key] = $grouped_dags[$group_key] ?? [];
                            $grouped_dags[$group_key][] = $dag;
                        }

                        if (!empty($grouped_dags)):
                        ?>
                            <div class="accordion" id="pattaAccordion">
                                <?php foreach ($grouped_dags as $patta_number => $dags): ?>
                                    <div class="card border-0 mb-2">
                                        <div class="card-header  p-0" id="heading<?= $patta_number ?>">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left d-flex justify-content-between align-items-center py-2 px-3 w-100"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse<?= $patta_number ?>"
                                                    aria-expanded="true"
                                                    aria-controls="collapse<?= $patta_number ?>">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <i class="fas fa-file-alt text-primary me-2"></i>
                                                        <span class="fw-bold me-3">Patta No: <?= $dags[0]['patta_number'] ?></span>
                                                        <?php 
                                                        // Find the first patta with this patta_number to get land details
                                                        $first_dag = $dags[0];
                                                        $land = null;
                                                        if (isset($first_dag['land_detail_id']) && isset($land_details_map[$first_dag['land_detail_id']])) {
                                                            $land = $land_details_map[$first_dag['land_detail_id']];
                                                        }
                                                        if ($land): 
                                                        ?>
                                                            <span class="text-muted me-3">
                                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                                <?= $land['district_name'] ?>, <?= $land['circle_name'] ?>
                                                            </span>
                                                            <span class="text-muted me-3">
                                                                <i class="fas fa-hashtag me-1"></i>
                                                                Lot: <?= $land['lot_no'] ?>
                                                            </span>
                                                            <span class="text-muted">
                                                                <i class="fas fa-home me-1"></i>
                                                                <?= $land['village_name'] ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <i class="fas fa-chevron-down small"></i>
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse<?= $patta_number ?>" class="collapse show" aria-labelledby="heading<?= $patta_number ?>" data-bs-parent="#pattaAccordion">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th class="border-0">DAG No</th>
                                                                <th class="border-0">Class</th>
                                                                <th class="border-0">Purpose</th>
                                                                <th class="border-0">Area</th>
                                                                <th class="border-0">Pattadars</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($dags as $dag): ?>
                                                                <tr>
                                                                    <td>
                                                                        <span class="badge bg-primary"><?= $dag['dag_number'] ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class=""><?= $dag['land_class_name'] ?></span>
                                                                    </td>
                                                                    <td><?= $dag['purpose'] ? ucfirst($dag['purpose']) : 'N/A' ?></td>
                                                                    <td>
                                                                        <div class="d-flex flex-wrap gap-2">
                                                                            <?php
                                                                            // Get the values, defaulting to 0 if not set
                                                                            $bigha = $dag['ancillary_bigha'] ?? 0;
                                                                            $katha = $dag['ancillary_katha'] ?? 0;
                                                                            $is_barak_valley = !empty($application['is_barak_valley']) && $application['is_barak_valley'] === 'Y';
                                                                            
                                                                            // Always show Bigha
                                                                            echo '<div class="measurement-item">';
                                                                            echo '<span class="value">' . $bigha . '</span>';
                                                                            echo '<span class="unit">Bigha</span>';
                                                                            echo '</div>';
                                                                            
                                                                            // Always show Katha
                                                                            echo '<div class="measurement-item">';
                                                                            echo '<span class="value">' . $katha . '</span>';
                                                                            echo '<span class="unit">Katha</span>';
                                                                            echo '</div>';
                                                                            
                                                                            // Show Lessa/Chatak based on Barak Valley
                                                                            $lessa_chatak = $is_barak_valley ? ($dag['ancillary_chatak'] ?? 0) : ($dag['ancillary_lessa'] ?? 0);
                                                                            $unit_label = $is_barak_valley ? 'Chatak' : 'Lessa';
                                                                            
                                                                            echo '<div class="measurement-item">';
                                                                            echo '<span class="value">' . $lessa_chatak . '</span>';
                                                                            echo '<span class="unit">' . $unit_label . '</span>';
                                                                            echo '</div>';
                                                                            
                                                                            // Show Ganda only if Barak Valley
                                                                            if ($is_barak_valley) {
                                                                                $ganda = $dag['ancillary_ganda'] ?? 0;
                                                                                echo '<div class="measurement-item">';
                                                                                echo '<span class="value">' . $ganda . '</span>';
                                                                                echo '<span class="unit">Ganda</span>';
                                                                                echo '</div>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $pattadars = json_decode($dag['pattadars'], true);
                                                                        if (!empty($pattadars)) {
                                                                            echo "<div class='pattadars-list'>";
                                                                            echo "<div class='d-flex flex-wrap gap-2'>";
                                                                            foreach ($pattadars as $index => $p) {
                                                                                if ($index < 2) {
                                                                                    $name_safe = htmlspecialchars($p['name'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                    $father_safe = htmlspecialchars($p['father'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                    $title_attr = $name_safe . " (Father: " . $father_safe . ")";
                                                                                    echo "<span class=' border' title=\"{$title_attr}\">";
                                                                                    $label = (strlen($p['name']) > 15 ? substr($p['name'], 0, 15) . '...' : $p['name']);
                                                                                    echo "<i class='fas fa-user me-1 text-muted'></i>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
                                                                                    echo "</span>";
                                                                                }
                                                                            }
                                                                            if (count($pattadars) > 2) {
                                                                                echo "<span class='badge  text-muted border'>+ " . (count($pattadars) - 2) . " more</span>";
                                                                            }
                                                                            echo "</div>";

                                                                            // Full list in tooltip
                                                                            $tooltip_content = "<div class='text-start small'>";
                                                                            foreach ($pattadars as $p) {
                                                                                $name_safe = htmlspecialchars($p['name'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                $father_safe = htmlspecialchars($p['father'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                $tooltip_content .= "<div class='mb-1'><strong>{$name_safe}</strong><br>Father: {$father_safe}</div>";
                                                                            }
                                                                            $tooltip_content .= "</div>";

                                                                            // Escape only double quotes for attribute context so inner HTML remains intact
                                                                            $attr_tooltip = str_replace('"', '&quot;', $tooltip_content);

                                                                            echo "<button type=\"button\" class=\"btn btn-sm btn-link p-0 mt-1 small\" data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-title=\"{$attr_tooltip}\">";
                                                                            echo "<i class='fas fa-eye me-1'></i>View All";
                                                                            echo "</button>";

                                                                            echo "</div>";
                                                                        } else {
                                                                            echo '<span class="text-muted">N/A</span>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No DAG details available</p>
                            </div>
                        <?php endif; ?>



                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="remarks" role="tabpanel" aria-labelledby="remarks-tab">

            <form action="<?= site_url('AncillaryController/nextUser') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="rtps_no" value="<?= $application['rtps_ref_no'] ?>">
                <?php if ($current_user_desig == 'DC'): ?>
                    <?php include 'remark-section/dc-remarks.php'; ?>
                <?php endif; ?>

                <?php if ($current_user_desig == 'CO'): ?>
                    <?php include 'remark-section/co-remarks.php'; ?>
                <?php endif; ?>

                <?php if ($current_user_desig == 'LM'): ?>
                    <?php include 'remark-section/lm-remarks.php'; ?>
                <?php endif; ?>

                <?php if($current_user_desig == 'ADC'): ?>
                    <?php include 'remark-section/adc-remarks.php'; ?>
                <?php endif; ?>
            </form>

            <form action="<?= site_url('AncillaryController/previousUser') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="rtps_no" value="<?= $application['rtps_ref_no'] ?>">
                

                <?php if ($current_user_desig == 'CO'): ?>
                    <?php include 'remark-section/co-remarks-revert.php'; ?>
                <?php endif; ?>

                <?php if($current_user_desig == 'ADC'): ?>
                    <?php include 'remark-section/adc-remarks-revert.php'; ?>
                <?php endif; ?>

                <?php if($current_user_desig == 'DC' && $step_id == 6): ?>
                    <?php include 'remark-section/dc-remarks-revert.php'; ?>
                <?php endif; ?>

            </form>

        </div>
        
        <!-- Applicant Details Tab -->
        <div class="tab-pane fade" id="applicant-details" role="tabpanel" aria-labelledby="applicant-details-tab">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Applicant Information
                    </h5>
                </div>
                <div class="card-body">
                    <?php include 'applicant-details.php'; ?>
                </div>
            </div>
        </div>
        
        <div class="tab-pane" id="lra-checklist-view" role="tabpanel" aria-labelledby="lra-checklist-view-tab">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-list me-2"></i>LRA Checklist
                    </h5>
                </div>
                <div class="card-body">
                    <?php include 'lra-checklist-view.php'; ?>
                </div>
            </div>
        </div>
        
        <div class="tab-pane" id="premium" role="tabpanel" aria-labelledby="premium-tab">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-rupee-sign me-2"></i>Premium
                    </h5>
                </div>
                <div class="card-body">
                    <?php include 'premium.php'; ?>
                </div>
            </div>
        </div>
        
        <div class="tab-pane" id="proceedings" role="tabpanel" aria-labelledby="proceedings-tab">
            <!-- Ancillary Proceeding -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-history me-2"></i>Ancillary Proceeding
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#ancillaryProceedingCollapse" aria-expanded="true" aria-controls="ancillaryProceedingCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="ancillaryProceedingCollapse">
                    <div class="card-body p-0">
                        <div class="mt-4">
                            <?php include 'timeline.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Custom CSS -->
    <style>
        /* General Styles */
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        /* Tabs visibility fallback */
        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        /* Card Styles */
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
        }

        .card-header {
            font-weight: 600;
        }

        /* Land Measurement Styles */
        .land-measurement {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .measurement-item {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            background: #f8f9fa;
            border-radius: 0.25rem;
            padding: 0.5rem;
            min-width: 60px;
        }

        .measurement-item .value {
            font-weight: 600;
            color: #0d6efd;
        }

        .measurement-item .unit {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Icon Circle */
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* Accordion Styles */
        .accordion .card-header button {
            text-decoration: none;
            color: #495057;
            transition: all 0.2s ease;
        }

        .accordion .card-header button:not(.collapsed) {
            background-color: #f8f9fa;
        }

        .accordion .card-header button:hover {
            color: #0d6efd;
        }

        .accordion .card-header button::after {
            transition: transform 0.3s ease;
        }

        /* Custom Scrollbar */
        .pattadars-list {
            max-height: 120px;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .pattadars-list::-webkit-scrollbar {
            width: 4px;
        }

        .pattadars-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .pattadars-list::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .pattadars-list::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .land-measurement {
                justify-content: flex-start;
            }

            .measurement-item {
                min-width: 50px;
                padding: 0.25rem;
            }
        }

        /* Print Styles */
        @media print {

            .no-print,
            .card-header button {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
            }

            .card-header {
                background-color: #f8f9fa !important;
                color: #000 !important;
                border-bottom: 1px solid #dee2e6 !important;
            }

            .collapse {
                display: block !important;
                height: auto !important;
            }
        }
    </style>

    <!-- Initialize Tooltips -->
    <script>
        function switchTab(targetId) {
            try {
                var links = document.querySelectorAll('#ancillaryTabs a.nav-link');
                var panes = document.querySelectorAll('#ancillaryTabsContent .tab-pane');
                links.forEach(function(l) {
                    l.classList.remove('active');
                    l.setAttribute('aria-selected', 'false');
                });
                panes.forEach(function(p) {
                    p.classList.remove('active', 'show');
                });
                var link = document.querySelector('#ancillaryTabs a[href="#' + targetId + '"]');
                var pane = document.getElementById(targetId);
                if (link) {
                    link.classList.add('active');
                    link.setAttribute('aria-selected', 'true');
                }
                if (pane) {
                    pane.classList.add('active', 'show');
                }
            } catch (e) {
                /* no-op */ }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips (Bootstrap 5 or 4)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            if (window.bootstrap && bootstrap.Tooltip) {
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        html: true,
                        boundary: 'window',
                        customClass: 'custom-tooltip',
                        placement: 'top'
                    });
                });
            }

            // Tabs: enable via Bootstrap if available, else provide a simple fallback
            var tabLinks = document.querySelectorAll('#ancillaryTabs a.nav-link');
            tabLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // If Bootstrap's Tab is available, use it
                    if (window.bootstrap && bootstrap.Tab) {
                        var tab = new bootstrap.Tab(link);
                        tab.show();
                        return;
                    }
                    // Fallback
                    var href = link.getAttribute('href') || '';
                    if (href.startsWith('#')) {
                        switchTab(href.substring(1));
                    }
                });
            });
        });
    </script>
</div>
</div>

</div>