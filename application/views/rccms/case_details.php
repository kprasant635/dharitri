<style>
    /* Ensure colored pills keep text visible on hover and active */
    .nav-pills .nav-link {
        color: #ce2525ff;
        /* default text color for all tabs */
    }

    .nav-pills .nav-link.active,
    .nav-pills .nav-link:hover {
        color: #1a5309ff !important;
        /* text stays white */
        opacity: 0.85;
        /* optional subtle hover effect */
        background-color: inherit !important;
        /* keep original background */
    }

    /* Optional: slight brightness change on hover */
    .nav-pills .nav-link:hover {
        filter: brightness(1.1);
    }

    .bg-lightdag {
        background-color: #80e69c;
    }

    .bg-white {
        color: #fafafaff;
    }

    .status-circle {
        display: inline-block;
        width: 15px;
        /* slightly larger for better visibility */
        height: 15px;
        border-radius: 50%;
        /* makes it a perfect circle */
        background-color: #fff;
        /* black fill */
        border: 2px solid #000;
        /* white border outline */
        vertical-align: middle;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }


    .status-circle.active {
        background-color: #28a745;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .areaheight {
        height: 34px;
    }

    .card-header .removeBtn {
        margin-top: -2px;
        /* fine-tune vertical centering */
        padding: 3px 10px;
        font-size: 0.875rem;
    }

    .judgment-box {
        background: #fcfcfc;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px;
    }

    .judgment-title {
        font-weight: 600;
        color: #0d6efd;
    }

    .judgment-item {
        padding: 6px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .judgment-item:last-child {
        border-bottom: none;
    }

    .judgment-icon {
        width: 20px;
    }

    .badge-soft {
        background: #eef4ff;
        color: #0d6efd;
        font-weight: 500;
    }

    .table-inner {
        background: #fff;
    }
</style>

<?php
// Demo data for pattadars (used only if controller didn't provide $pattadars)
if (!isset($pattadars) || empty($pattadars)) {
    $pattadars = [];
    if (!empty($land_details) && is_array($land_details)) {
        foreach ($land_details as $ld) {
            $dag = isset($ld['dagNo']) ? $ld['dagNo'] : 'demo';
            // sample entries
            $pattadars[$dag] = [
                [
                    'id' => 1,
                    'name' => 'Ram Prasad',     
                    'guardianName' => 'Shyam Lal',
                    'relation' => 'S/O',
                    'gender' => 'M',
                    'address' => 'Village Road, House 12'
                ],
                [
                    'id' => 2,
                    'name' => 'Sita Devi',
                    'guardianName' => 'Ram Prasad',
                    'relation' => 'D/O',
                    'gender' => 'F',
                    'address' => 'Village Road, House 13'
                ],
                [
                    'id' => 3,
                    'name' => 'Gopal Das',
                    'guardianName' => 'Ramesh',
                    'relation' => 'S/O',
                    'gender' => 'M',
                    'address' => 'Near Temple'
                ]
            ];
        }
    } else {
        // fallback single demo DAG
        $pattadars['demo'] = [
            ['id' => 'demo_1', 'name' => 'Ram Prasad', 'guardianName' => 'Shyam Lal', 'relation' => 'S/O', 'gender' => 'M', 'address' => 'Village Road'],
        ];
    }
}

if (!isset($pattadars) || empty($pattadars)) {
    $pattadars = [];
    if (!empty($land_details) && is_array($land_details)) {
        foreach ($land_details as $ld) {
            $dag = isset($ld['dagNo']) ? $ld['dagNo'] : 'demo';
            // sample entries
            $unsstikrepattadars[$dag] = [
                [
                    'id' => 1,
                    'name' => 'Ram Prasad test 1',
                    'guardianName' => 'Shyam Lal',
                    'relation' => 'S/O',
                    'gender' => 'M',
                    'address' => 'Village Road, House 12'
                ],
                [
                    'id' => 2,
                    'name' => 'Sita Devi test 2',
                    'guardianName' => 'Ram Prasad',
                    'relation' => 'D/O',
                    'gender' => 'F',
                    'address' => 'Village Road, House 13'
                ],
                [
                    'id' => 3,
                    'name' => 'Gopal Das test 3',
                    'guardianName' => 'Ramesh',
                    'relation' => 'S/O',
                    'gender' => 'M',
                    'address' => 'Near Temple'
                ]
            ];
        }
    } else {
        // fallback single demo DAG
        $pattadars['demo'] = [
            ['id' => 'demo_1', 'name' => 'Ram Prasad', 'guardianName' => 'Shyam Lal', 'relation' => 'S/O', 'gender' => 'M', 'address' => 'Village Road'],
        ];
    }
}
?>
<div class="container my-1">



    <!-- RCCMS Application No -->
    <?php if (!empty($all_data['applicationId'])): ?>
        <input type="hidden" id="rccms_application_id" value="<?= htmlspecialchars(trim($all_data['applicationId'])); ?>">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body text-center bg-primary py-2">
                <h4 class=" mb-0 text-white">
                    <i class="fa-solid fa-file-signature me-2 text-warning"></i>
                    RCCMS Application No:
                    <span style="color: yellow;"><?= htmlspecialchars(trim($all_data['applicationId'])); ?></span>
                </h4>
            </div>
        </div>
    <?php else: ?>
        <p class="text-muted text-center mt-4">
            <i class="fa-solid fa-circle-exclamation me-2"></i> Application ID not found.
        </p>
    <?php endif; ?>

    <h6 class="text-center text-uppercase font-weight-bold mb-2" style="color: #0056b3; letter-spacing: 1px;">
        <i class="fa fa-balance-scale mr-2 text-primary"></i>
        RCCMS Case Details
    </h6>
    <?php if (!empty($caseNature) || !empty($all_data['caseDescription']) || !empty($caseHistory) || !empty($caseStatus)): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pb-0">
                <!-- Tabs -->
                <ul class="nav nav-tabs card-header-tabs" id="caseTabs" role="tablist">
                    <?php if (!empty($caseNature)): ?>
                        <li class="nav-item">
                            <a class="nav-link active text-success font-weight-bold" id="nature-tab" data-toggle="tab"
                                href="#nature" role="tab" aria-controls="nature" aria-selected="true">
                                <i class="fa fa-scroll mr-1 text-success"></i> Case Nature
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($all_data['caseDescription'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger font-weight-bold" id="description-tab" data-toggle="tab"
                                href="#description" role="tab" aria-controls="description" aria-selected="false">
                                <i class="fa fa-scroll mr-1 text-danger"></i> Case Description
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($caseHistory)): ?>
                        <li class="nav-item">
                            <a class="nav-link text-primary font-weight-bold" id="history-tab" data-toggle="tab" href="#history"
                                role="tab" aria-controls="history" aria-selected="false">
                                <i class="fa fa-history mr-1 text-primary"></i> Case History
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($caseStatus)): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning font-weight-bold" id="status-tab" data-toggle="tab" href="#status"
                                role="tab" aria-controls="status" aria-selected="false">
                                <i class="fa fa-flag-checkered mr-1 text-warning"></i> Case Status
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="card-body tab-content mt-3 p-3" id="caseTabsContent" style="max-height: 400px; overflow-y: auto;">
                <!-- Case Nature -->
                <?php if (!empty($caseNature)): ?>
                    <div class="tab-pane fade show active" id="nature" role="tabpanel" aria-labelledby="nature-tab">
                        <p class="text-dark p-2 mb-0"><?= htmlspecialchars(trim($caseNature)); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Case Description -->
                <?php if (!empty($all_data['caseDescription'])): ?>
                    <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <p class="text-dark p-2 mb-0"><?= htmlspecialchars(trim($all_data['caseDescription'])); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Case History -->
                <?php if (!empty($caseHistory)): ?>
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <div style="max-height: 250px; overflow-y: auto;">
                            <?php foreach ($caseHistory as $history): ?>
                                <div class="border-bottom pb-2 mb-2">
                                    <p class="mb-1 text-dark">
                                        <i class="fa fa-comment-dots p-2 mr-2 text-info"></i>
                                        <?= htmlspecialchars(trim($history['remark'])); ?>
                                    </p>
                                    <small class="text-muted">
                                        <i class="fa fa-calendar p-2 mr-1"></i>
                                        <?= htmlspecialchars($history['date']); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Case Status -->
                <?php if (!empty($caseStatus)): ?>
                    <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="status-tab">
                        <p class="text-dark p-2 mb-0"><?= htmlspecialchars(trim($caseStatus)); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <h6 class="text-center text-uppercase font-weight-bold mb-2" style="color: #28a745; letter-spacing: 1px;">
        <i class="fa fa-edit mr-2 text-success"></i>
        Correction of Records
    </h6>

    <input type="hidden" id="dist_code" value="<?= $dist_code ?>">
    <input type="hidden" id="subdiv_code" value="<?= $subdiv_code ?>">
    <input type="hidden" id="cir_code" value="<?= $cir_code ?>">

    <!-- Land Details -->
    <?php if (!empty($land_details)): ?>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header text-white text-center py-2"
                style="background: linear-gradient(135deg, #007bff, #00c6ff);">
                <h5 class="mb-0">
                    <i class="fa fa-map-marker-alt mr-2"></i>
                    Land Location Details
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fa fa-city text-primary mr-1"></i> District</th>
                                <th><i class="fa fa-compass text-success mr-1"></i> Circle</th>
                                <th><i class="fa fa-tree text-warning mr-1"></i> Village</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><?= htmlspecialchars(trim($land_details[0]['districtNameEng'])); ?></strong>
                                </td>
                                <td><strong><?= htmlspecialchars(trim($land_details[0]['cirNameEng'])); ?></strong></td>
                                <td><strong><?= htmlspecialchars(trim($land_details[0]['villNameEng'])); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-muted text-center mt-4">
            <i class="fa fa-exclamation-circle mr-1"></i> No Land Details found.
        </p>
    <?php endif; ?>


    <!-- validate the village -->
    <div class="container my-1">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="card-header bg-gradient text-black mb-1"
                style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h5 class="mb-0">
                    <i class="fa-solid fa-map-location-dot me-2"></i> Validate Village
                </h5>
            </div>

            <div class="card-body">
                <form id="validateVillageForm" class="d-flex flex-wrap align-items-end gap-3">
                    <input type="hidden" name="rccms_vill_code"
                        value="<?= htmlspecialchars($land_details[0]['village']); ?>">

                    <div class="flex-grow-1">
                        <label for="mouza" class="form-label fw-bold">Mouza</label>
                        <select id="mouza" name="mouza" class="form-select" required>
                            <option value="">-- Select Mouza --</option>
                            <?php foreach ($mouza_list as $mouza): ?>
                                <option value="<?= htmlspecialchars($mouza->mouza_pargona_code); ?>">
                                    <?= htmlspecialchars(trim($mouza->loc_name)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <label for="lot" class="form-label fw-bold">Lot</label>
                        <select id="lot" name="lot" class="form-select" disabled required>
                            <option value="">-- Select Lot --</option>
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <label for="village" class="form-label fw-bold">Village</label>
                        <select id="village" name="village" class="form-select" disabled required>
                            <option value="">-- Select Village --</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-sm btn-success" style="height: 40px;">
                            <i class="fa-solid fa-check me-2"></i>Validate &nbsp;
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Failure message -->
<div id="validationFailedDiv" class="alert alert-danger mt-1 py-2 px-1 d-none rounded-3">
    <i class="fa-solid fa-triangle-exclamation me-2"></i>
    Sorry, village validation failed. Please check.
</div>
<div id="validationSuccessDiv" class="mt-0" style="display:none;">
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check me-2"></i>
        Village validated successfully!
    </div>

    <!-- Main DAG Tabs -->
    <ul class="nav nav-tabs" id="landTab" role="tablist">
        <?php foreach ($land_details as $index => $row): ?>
            <li class="nav-item">
                <a class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $index ?>" data-toggle="tab"
                    href="#tab-pane-<?= $index ?>" role="tab" aria-controls="tab-pane-<?= $index ?>"
                    aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                    <i class="fa fa-map mr-2 text-primary"></i>
                    DAG: <?= htmlspecialchars($row['dagNo']) ?> |
                    Patta: <?= htmlspecialchars($row['pattaNo']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Main Tab Content -->
    <div class="tab-content border border-top-0 p-4 shadow-sm rounded-bottom" id="landTabContent">
        <?php foreach ($land_details as $index => $row): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="tab-pane-<?= $index ?>" role="tabpanel"
                aria-labelledby="tab-<?= $index ?>">

                <!-- Sub-Tabs for Each DAG -->
                <ul class="nav nav-pills mb-3" id="subTab-<?= $index ?>" role="tablist">
                    <?php if (RCCMS_ADD_PATTADAR_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link active" id="addPattadar-tab-<?= $index ?>" data-toggle="pill"
                                href="#addPattadar-pane-<?= $index ?>" role="tab" aria-controls="addPattadar-pane-<?= $index ?>"
                                aria-selected="true">
                                <i class="fa fa-user-plus me-2 text-success"></i>
                                Add Pattadar
                                <span class="status-circle ms-2" id="pattadarStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (RCCMS_STRIKE_PATTADAR_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="strikePattadar-tab-<?= $index ?>" data-toggle="pill"
                                href="#strikePattadar-pane-<?= $index ?>" role="tab"
                                aria-controls="strikePattadar-pane-<?= $index ?>" aria-selected="false">
                                <i class="fa fa-user-times me-2 text-danger"></i>
                                Strike Pattadar
                                <span class="status-circle ms-2" id="strikeStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (RCCMS_UNSTRIKE_PATTADAR_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="unstrikePattadar-tab-<?= $index ?>" data-toggle="pill"
                                href="#unstrikePattadar-pane-<?= $index ?>" role="tab"
                                aria-controls="unstrikePattadar-pane-<?= $index ?>" aria-selected="false">
                                <i class="fa fa-user-slash me-1 text-danger"></i>
                                UN-Strike Pattadar
                                <span class="status-circle ms-2" id="unstrikeStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (RCCMS_AREA_CHANGE_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="areaChange-tab-<?= $index ?>" data-toggle="pill"
                                href="#areaChange-pane-<?= $index ?>" role="tab" aria-controls="areaChange-pane-<?= $index ?>"
                                aria-selected="false">
                                <i class="fa fa-ruler-combined me-2 text-warning"></i>
                                Area Change
                                <span class="status-circle ms-2" id="areaStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (RCCMS_LANDCLASS_CHANGE_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="LandClassChange-tab-<?= $index ?>" data-toggle="pill"
                                href="#LandClassChange-pane-<?= $index ?>" role="tab"
                                aria-controls="LandClassChange-pane-<?= $index ?>" aria-selected="false">
                                <i class="fa fa-sticky-note me-2 text-info"></i>
                                Land Class Change
                                <span class="status-circle ms-2" id="landclassStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (RCCMS_PATTATYPE_CHANGE_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pattaTypeChange-tab-<?= $index ?>" data-toggle="pill"
                                href="#pattaTypeChange-pane-<?= $index ?>" role="tab"
                                aria-controls="pattaTypeChange-pane-<?= $index ?>" aria-selected="false">
                                <i class="fa fa-file-signature me-2 text-info"></i>
                                Patta Type Change
                                <span class="status-circle ms-2" id="pattaStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (RCCMS_OTHER_REMARKS_SECTION == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="otherRemarks-tab-<?= $index ?>" data-toggle="pill"
                                href="#otherRemarks-pane-<?= $index ?>" role="tab"
                                aria-controls="otherRemarks-pane-<?= $index ?>" aria-selected="false">
                                <i class="fa fa-sticky-note me-2 text-secondary"></i>
                                Other Remarks
                                <span class="status-circle ms-2" id="remarksStatus-<?= $index ?>"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>


                <!-- Sub-Tab Contents -->
                <div class="tab-content" id="subTabContent-<?= $index ?>">
                    <div class="tab-pane fade show active" id="addPattadar-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="addPattadar-tab-<?= $index ?>">


                        <!-- TABLE OF ADDED PATTADARS -->
                        <div class="card mb-3" id="pattadarTableCard-<?= $index ?>" style="display: none;">
                            <div class="card-header fw-bold">Added Pattadars</div>
                            <div class="card-body p-0">
                                <table class="table table-sm mb-0" id="pattadarTable-<?= $index ?>">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Guardian</th>
                                            <th>Gender</th>
                                            <th>Relation</th>
                                            <th>Address</th>
                                            <th width="80">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>



                        <div id="pattadarContainer">

                            <div class="card pattadar-form">
                                <div class="card-header bg-success text-white fw-bold py-2 px-3">
                                    <i class="fa fa-user-plus me-2"></i>Add Pattadar
                                </div>

                                <div class="card-body">
                                    <form id="pattadarForm-<?= $index ?>" class="needs-validation" novalidate>

                                        <div class="row g-3">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" required>
                                                <div class="invalid-feedback">Please enter the name.</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Guardian Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="guardianName" required>
                                                <div class="invalid-feedback">Please enter the guardian name.</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Gender <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <?php foreach ($gender as $g): ?>
                                                        <option value="<?= $g->short_name ?>">
                                                            <?= $g->gen_name_ass ?>-(<?= $g->gen_name_eng ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">Please select gender.</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Relation <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="relation" required>
                                                    <option value="">Select Relation</option>
                                                    <?php foreach ($relation as $r): ?>
                                                        <option value="<?= $r->id ?>">
                                                            <?= $r->guard_rel_desc_as ?>-(<?= $r->guard_rel_desc ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">Please select relation.</div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Address <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" name="address" rows="3" required></textarea>
                                                <div class="invalid-feedback">Please enter the address.</div>
                                            </div>

                                        </div>
                                        <button type="button" id="addMorePattadar-<?= $index ?>"
                                            class="btn btn-primary mt-3 float-right">
                                            <i class="fa fa-plus me-1"></i> Add Pattadar
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>



                    </div>


                    <div class="tab-pane fade" id="strikePattadar-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="strikePattadar-tab-<?= $index ?>">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-header bg-danger text-white fw-bold">
                                <i class="fa fa-user-times me-2"></i>Strike Pattadar
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <p><strong>DAG No:</strong> <?= htmlspecialchars($row['dagNo']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Patta No:</strong> <?= htmlspecialchars($row['pattaNo']) ?></p>
                                    </div>
                                </div>
                                <form id="strikePattadarForm-<?= $index ?>" class="needs-validation" novalidate>
                                    <input type="hidden" name="dagNo" value="<?= htmlspecialchars($row['dagNo']) ?>">
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input select-all-pattadar"
                                                                id="selectAll-<?= $index ?>">
                                                            <label class="form-check-label"
                                                                for="selectAll-<?= $index ?>"></label>
                                                        </div>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Relation</th>
                                                    <th>Gender</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($pattadars[$row['dagNo']])): ?>
                                                    <?php foreach ($pattadars[$row['dagNo']] as $pattadar): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input pattadar-checkbox"
                                                                        name="selected_pattadars[]"
                                                                        value="<?= htmlspecialchars($pattadar['id']) ?>"
                                                                        id="pattadar-<?= $index ?>-<?= htmlspecialchars($pattadar['id']) ?>">
                                                                    <label class="form-check-label"
                                                                        for="pattadar-<?= $index ?>-<?= htmlspecialchars($pattadar['id']) ?>">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td><?= htmlspecialchars($pattadar['name']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['guardianName']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['relation']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['gender']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['address']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            <i class="fa fa-info-circle me-2"></i>No pattadars found for this
                                                            DAG
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mb-3">
                                        <label for="strikeReason-<?= $index ?>" class="form-label fw-bold">Reason for
                                            Striking <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="strikeReason-<?= $index ?>" name="strikeReason"
                                            rows="3" required
                                            placeholder="Enter reason for striking selected pattadar(s)..."></textarea>
                                        <div class="invalid-feedback">Please provide a reason for striking.</div>
                                    </div>

                                    <!-- <button type="submit" class="btn btn-danger" id="strikePattadarBtn-<?= $index ?>">
                                    <i class="fa fa-user-times me-2"></i>Strike Selected Pattadar(s)
                                </button> -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="unstrikePattadar-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="unstrikePattadar-tab-<?= $index ?>">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-header bg-danger text-white fw-bold">
                                <i class="fa fa-user-times me-2"></i>Un-Strike Pattadar
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <p><strong>DAG No:</strong> <?= htmlspecialchars($row['dagNo']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Patta No:</strong> <?= htmlspecialchars($row['pattaNo']) ?></p>
                                    </div>
                                </div>
                                <form id="unstrikePattadarForm-<?= $index ?>" class="needs-validation" novalidate>
                                    <input type="hidden" name="dagNo" value="<?= htmlspecialchars($row['dagNo']) ?>">
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input select-all-pattadar-unstrike"
                                                                id="selectAll-<?= $index ?>">
                                                            <label class="form-check-label"
                                                                for="selectAll-<?= $index ?>"></label>
                                                        </div>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Relation</th>
                                                    <th>Gender</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($pattadars[$row['dagNo']])): ?>
                                                    <?php foreach ($pattadars[$row['dagNo']] as $pattadar): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input unpattadar-checkbox"
                                                                        name="selected_pattadars[]"
                                                                        value="<?= htmlspecialchars($pattadar['id']) ?>"
                                                                        id="pattadar-<?= $index ?>-<?= htmlspecialchars($pattadar['id']) ?>">
                                                                    <label class="form-check-label"
                                                                        for="pattadar-<?= $index ?>-<?= htmlspecialchars($pattadar['id']) ?>">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td><?= htmlspecialchars($pattadar['name']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['guardianName']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['relation']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['gender']) ?></td>
                                                            <td><?= htmlspecialchars($pattadar['address']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            <i class="fa fa-info-circle me-2"></i>No pattadars found for this
                                                            DAG
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mb-3">
                                        <label for="unstrikeReason-<?= $index ?>" class="form-label fw-bold">Reason<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="unstrikeReason-<?= $index ?>"
                                            name="unstrikeReason" rows="3" required
                                            placeholder="Enter reason for UN-Striking selected pattadar(s)..."></textarea>
                                        <div class="invalid-feedback">Please provide a reason for striking.</div>
                                    </div>

                                    <!-- <button type="submit" class="btn btn-danger" id="strikePattadarBtn-<?= $index ?>">
                                    <i class="fa fa-user-times me-2"></i>Strike Selected Pattadar(s)
                                </button> -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="areaChange-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="areaChange-tab-<?= $index ?>">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-header bg-warning text-white fw-bold">
                                <i class="fa fa-ruler-combined me-2"></i>Area Change
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <p><strong>DAG No:</strong> <?= htmlspecialchars($row['dagNo']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Patta No:</strong> <?= htmlspecialchars($row['pattaNo']) ?></p>
                                    </div>
                                </div>

                                <?php
                                // Try to show current area if available in $row
                                if ($districtCode == 20) {
                                    $currentArea = '0 bigha 1 katha 10 lessa 20 gonda 30 chatak';
                                    $md = 12;
                                } else {
                                    $currentArea = '0 bigha 1 katha 10 lessa';
                                    $md = 06;
                                }


                                if (!empty($row['area'])) {
                                    $currentArea = htmlspecialchars($row['area']);
                                } elseif (!empty($row['dagArea'])) {
                                    $currentArea = htmlspecialchars($row['dagArea']);
                                }
                                ?>

                                <form id="areaChangeForm-<?= $index ?>" class="needs-validation" novalidate>
                                    <input type="hidden" name="dagNo" value="<?= htmlspecialchars($row['dagNo']) ?>">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Current Area</label>
                                        <div class="form-control-plaintext"><?= $currentArea ?></div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-<?= $md ?> mb-3">
                                            <label for="areaGroup-<?= $index ?>" class="form-label fw-bold">
                                                Correction Area <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <!-- Bigha -->

                                                <input type="number" class="form-control" name="bigha"
                                                    id="bigha-<?= $index ?>" min="0" placeholder="Bigha"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text areaheight">Bigha</span>
                                                </div>
                                                <!-- Katha -->

                                                <input type="number" class="form-control" name="katha"
                                                    id="katha-<?= $index ?>" min="0" max="19" placeholder="Katha"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text areaheight">Katha</span>
                                                </div>
                                                <!-- Lessa -->

                                                <input type="number" class="form-control" name="lessa"
                                                    id="lessa-<?= $index ?>" min="0" max="19" placeholder="Lessa"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text areaheight">Lessa</span>
                                                </div>

                                                <?php if ($districtCode == 20): ?>
                                                    <!-- Gonda (hidden by default) -->
                                                    <input type="number" class="form-control extra-area " name="gonda"
                                                        id="gonda-<?= $index ?>" min="0" placeholder="Gonda"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    <div class="input-group-prepend extra-area">
                                                        <span class="input-group-text areaheight">Gonda</span>
                                                    </div>

                                                    <!-- Chatak (hidden by default) -->
                                                    <input type="number" class="form-control extra-area" name="chatak"
                                                        id="chatak-<?= $index ?>" min="0" placeholder="Chatak"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    <div class="input-group-prepend extra-area">
                                                        <span class="input-group-text areaheight">Chatak</span>
                                                    </div>


                                                <?php endif; ?>
                                            </div>

                                            <?php if ($districtCode == 20): ?>
                                                <div class="form-text text-muted mt-1">
                                                    Enter area values (e.g., 0 Bigha 1 Katha 5 Lessa 10 Gonda 15 Chatak)
                                                </div>

                                            <?php else: ?>
                                                <div class="form-text text-muted mt-1">
                                                    Enter area values (e.g., 0 Bigha 1 Katha 5 Lessa)
                                                </div>

                                            <?php endif; ?>




                                            <div class="invalid-feedback">Please enter valid area values.</div>
                                        </div>



                                        <div class="col-12 mb-3">
                                            <label for="areaReason-<?= $index ?>" class="form-label fw-bold">Reason for
                                                Change <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="areaReason-<?= $index ?>" name="areaReason"
                                                rows="3" required
                                                placeholder="Describe why area needs to be changed..."></textarea>
                                            <div class="invalid-feedback">Please provide a reason for the area change.</div>
                                        </div>

                                        <!-- <div class="col-12">
                                        <button type="submit" class="btn btn-warning" id="areaChangeBtn-<?= $index ?>">
                                            <i class="fa fa-ruler-combined me-2"></i>Submit Area Change
                                        </button>
                                    </div> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="LandClassChange-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="LandClassChange-tab-<?= $index ?>">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-header bg-info text-white fw-bold">
                                <i class="fa fa-sticky-note me-2"></i>Land Class Change
                            </div>
                            <div class="card-body">
                                <form id="LandClassChangeForm-<?= $index ?>" class="needs-validation" novalidate>

                                    <p><strong>DAG No:</strong> <?= htmlspecialchars($row['dagNo']) ?></p>
                                    <p><strong>Patta No:</strong> <?= htmlspecialchars($row['pattaNo']) ?></p>

                                    <div class="row">

                                        <!-- Change Patta No -->


                                        <!-- Present Patta Type -->
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Land Class Type</label>
                                            <select name="landClassChange" class="form-control landClassChange-select"
                                                id="landClassChange-<?= $index ?>" required>
                                                <option value="">Select Type</option>
                                                <?php foreach ($landclass as $p): ?>
                                                    <option value="<?= $p->class_code ?>">
                                                        <?= $p->land_type ?>-(<?= $p->landtype_eng ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>



                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Reason for Change</label>
                                        <textarea name="reasonChangelandclass" class="form-control" rows="3"
                                            placeholder="Write the reason"></textarea>
                                    </div>


                                </form>
                            </div>
                        </div>

                    </div>



                    <div class="tab-pane fade" id="pattaTypeChange-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="pattaTypeChange-tab-<?= $index ?>">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-header bg-info text-white fw-bold">
                                <i class="fa fa-file-signature me-2"></i>Patta Type Change
                            </div>
                            <div class="card-body">
                                <form id="pattaTypeChangeForm-<?= $index ?>" class="needs-validation" novalidate>

                                    <p><strong>DAG No:</strong> <?= htmlspecialchars($row['dagNo']) ?></p>
                                    <p><strong>Patta No:</strong> <?= htmlspecialchars($row['pattaNo']) ?></p>

                                    <div class="row">

                                        <!-- Change Patta No -->
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Change Patta No</label>
                                            <input type="text" name="changePattaNo" class="form-control"
                                                placeholder="Enter new Patta No"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>

                                        <!-- Present Patta Type -->
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Present Patta Type</label>
                                            <?php $patta_name = get_pattatype_patta_id($row['pattaType']); 
                                            ?>
                                            <select name="presentPattaType" class="form-control"
                                                id="presentPattaType-<?= $index ?>" required>
                                                <option value="<?= $row['pattaType'] ?>" selected>
                                                        <?= $patta_name ?>
                                                    </option>
                                                
                                            </select>
                                        </div>

                                        <!-- Requested Patta Type -->
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Requested Patta Type</label>
                                            <select name="requestedPattaType" class="form-control requestedPattaType-select"
                                                required>
                                                <option value="">Select Type</option>
                                                <?php foreach ($pattatype as $p): ?>
                                                    <option value="<?= $p->type_code ?>">
                                                        <?= $p->patta_type ?>-(<?= $p->pattatype_eng ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Reason for Change</label>
                                        <textarea name="reasonChange" class="form-control" rows="3"
                                            placeholder="Write the reason"></textarea>
                                    </div>

                                    <!-- <div class="mb-3">
                                    <label class="form-label fw-bold">Supporting Document</label>
                                    <input type="file" name="support_doc" class="form-control">
                                    <small class="text-muted">Upload PDF, JPG, or PNG only</small>
                                </div> -->

                                    <!-- <button type="submit" class="btn btn-info text-white fw-bold">
                                    Submit Request
                                </button> -->

                                </form>
                            </div>
                        </div>

                    </div>


                    <!-- New Other Remarks Pane -->

                    <div class="tab-pane fade" id="otherRemarks-pane-<?= $index ?>" role="tabpanel"
                        aria-labelledby="otherRemarks-tab-<?= $index ?>">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-header bg-secondary text-white fw-bold">
                                <i class="fa fa-sticky-note me-2"></i>Other Remarks
                            </div>
                            <div class="card-body">
                                <form id="otherRemarksForm-<?= $index ?>">
                                    <div class="mb-3">
                                        <label for="remarks-<?= $index ?>" class="form-label fw-bold">Enter Remarks</label>
                                        <textarea class="form-control" id="remarks-<?= $index ?>" name="remarks" rows="4"
                                            placeholder="Write your remarks here..." required></textarea>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>



    <div class="d-flex justify-content-end mt-3 mb-5">
        <button type="button" id="previewAllData" class="btn btn-info me-2">
            <i class="fa fa-eye me-2"></i>Preview
        </button>
        <!-- <button type="submit" id="submitAllData" class="btn btn-success">
            <i class="fa fa-paper-plane me-2"></i>Submit All
        </button> -->
    </div>

</div>
</div>

<!-- Preview Modal -->
<div class="modal" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="previewModalLabel">
                    <i class="fa fa-eye me-2"></i>Preview Case Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="previewModalBody">
                <!-- All collected data will be injected here -->
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i>Close
                </button>
                <button type="button" id="saveCaseBtn" class="btn btn-success">
                    <i class="fa fa-paper-plane me-1"></i>Confirm & Submit
                </button>
            </div>

        </div>
    </div>
</div>


<pre id="jsonOutput" style="background:#f4f4f4; padding:15px; border-radius:8px;"></pre>

<!-- Script -->
<script>
    const base_url = "<?= base_url(); ?>";
    const districtCode = "<?= $districtCode ?>";
    const Barak_Vally_Distcode = "<?= Barak_Vally_Distcode ?>";
    const landDetails = <?= !empty($land_details) ? json_encode($land_details) : '[]'; ?>;
</script>

<script src="<?= base_url('application/views/rccms/script/rccms_script.js'); ?>"></script>