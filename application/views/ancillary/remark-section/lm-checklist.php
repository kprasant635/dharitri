<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>LM Checklist</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <!-- 1) Possession Since -->
             <input type="hidden" name="case_no" value="<?= $land_details[0]['sub_case_no'] ?>" />
            <div class="col-12">
                <label class="form-label">Possession Since (dd-mm-yyyy)</label>
                <?php 
                $possessionDate = '';
                if (is_object($lmNote) && $lmNote->num_rows() > 0) {
                    $lmNoteData = $lmNote->row_array();
                    $possessionDate = !empty($lmNoteData['possession_date']) ? date('Y-m-d', strtotime($lmNoteData['possession_date'])) : '';
                } elseif (is_array($lmNote) && !empty($lmNote['possession_date'])) {
                    $possessionDate = date('Y-m-d', strtotime($lmNote['possession_date']));
                }
                ?>
                <input type="date" name="lm[possession_since]" class="form-control" value="<?= $possessionDate ?>" />
                <div class="form-text">Use the date picker.</div>
            </div>

            <!-- 2) Tribal Belt/Block -->
            <div class="col-12">
                <label class="form-label">Does the land fall under Tribal Belt/Block?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <?php 
                        $isTribalBelt = false;
                        if (is_object($lmNote) && $lmNote->num_rows() > 0) {
                            $lmNoteData = $lmNote->row_array();
                            $isTribalBelt = ($lmNoteData['is_tribal_belt'] ?? 'N') === 'Y';
                        } elseif (is_array($lmNote)) {
                            $isTribalBelt = ($lmNote['is_tribal_belt'] ?? 'N') === 'Y';
                        }
                        ?>
                        <input class="form-check-input" type="radio" name="lm[tribal_belt_block]" id="tribal_yes" value="Y" <?= $isTribalBelt ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tribal_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lm[tribal_belt_block]" id="tribal_no" value="N" <?= !$isTribalBelt ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tribal_no">No</label>
                    </div>
                </div>
            </div>

            <!-- 3) Landslide prone -->
            <div class="col-12">
                <label class="form-label">Is the land in a landslide prone area?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <?php 
                        $isLandslide = false;
                        if (is_object($lmNote) && $lmNote->num_rows() > 0) {
                            $lmNoteData = $lmNote->row_array();
                            $isLandslide = ($lmNoteData['is_landslide'] ?? 'N') === 'Y';
                        } elseif (is_array($lmNote)) {
                            $isLandslide = ($lmNote['is_landslide'] ?? 'N') === 'Y';
                        }
                        ?>
                        <input class="form-check-input" type="radio" name="lm[landslide_prone]" id="landslide_yes" value="Y" <?= $isLandslide ? 'checked' : '' ?>>
                        <label class="form-check-label" for="landslide_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lm[landslide_prone]" id="landslide_no" value="N" <?= !$isLandslide ? 'checked' : '' ?>>
                        <label class="form-check-label" for="landslide_no">No</label>
                    </div>
                </div>
            </div>

            <!-- 4) Wetland -->
            <div class="col-12">
                <label class="form-label">Is the land a wetland?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <?php 
                        $isWetland = false;
                        if (is_object($lmNote) && $lmNote->num_rows() > 0) {
                            $lmNoteData = $lmNote->row_array();
                            $isWetland = ($lmNoteData['is_wetland'] ?? 'N') === 'Y';
                        } elseif (is_array($lmNote)) {
                            $isWetland = ($lmNote['is_wetland'] ?? 'N') === 'Y';
                        }
                        ?>
                        <input class="form-check-input" type="radio" name="lm[wetland]" id="wetland_yes" value="Y" <?= $isWetland ? 'checked' : '' ?>>
                        <label class="form-check-label" for="wetland_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lm[wetland]" id="wetland_no" value="N" <?= !$isWetland ? 'checked' : '' ?>>
                        <label class="form-check-label" for="wetland_no">No</label>
                    </div>
                </div>
            </div>

            <!-- 5) Verify Schedule -->
            <div class="col-12">
                <label class="form-label">Verify Schedule of the land and area under occupation</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <?php 
                        $scheduleDetails = false;
                        if (is_object($lmNote) && $lmNote->num_rows() > 0) {
                            $lmNoteData = $lmNote->row_array();
                            $scheduleDetails = ($lmNoteData['schedule_details'] ?? 'N') === 'Y';
                        } elseif (is_array($lmNote)) {
                            $scheduleDetails = ($lmNote['schedule_details'] ?? 'N') === 'Y';
                        }
                        ?>
                        <input class="form-check-input" type="radio" name="lm[schedule_and_occupation]" id="schedule_occupation_yes" value="Y" <?= $scheduleDetails ? 'checked' : '' ?>>
                        <label class="form-check-label" for="schedule_occupation_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lm[schedule_and_occupation]" id="schedule_occupation_no" value="N" <?= !$scheduleDetails ? 'checked' : '' ?>>
                        <label class="form-check-label" for="schedule_occupation_no">No</label>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4" />

        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Dag-wise Details</h6>
        </div>

        
        <div id="dagItemsContainer" class="vstack gap-3">
            <?php if (!empty($dag_details) && is_array($dag_details)): ?>
                <?php foreach ($dag_details as $idx => $d): ?>
                    
                    <div class="card border dag-item p-3">
                        <div class="mb-2"><strong class="small">DAG Item</strong></div>

                        <div class="row g-3">
                            <input type="hidden" name="dag_items[<?= $idx ?>][district_code]" value="<?= htmlspecialchars($d['district_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="dag_items[<?= $idx ?>][subdiv_code]" value="<?= htmlspecialchars($d['subdiv_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="dag_items[<?= $idx ?>][circle_code]" value="<?= htmlspecialchars($d['circle_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="dag_items[<?= $idx ?>][mouza_code]" value="<?= htmlspecialchars($d['mouza_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="dag_items[<?= $idx ?>][lot_no]" value="<?= htmlspecialchars($d['lot_no'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="dag_items[<?= $idx ?>][village_code]" value="<?= htmlspecialchars($d['village_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                            
                            <div class="col-12">
                                <label class="form-label">DAG No</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-primary"><?= htmlspecialchars($d['dag_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <input type="hidden" name="dag_items[<?= $idx ?>][dag_no]" value="<?= htmlspecialchars($d['dag_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nature of possession (Dag-wise)</label>
                                <input type="text" class="form-control" name="dag_items[<?= $idx ?>][nature_of_possession]" value="<?= htmlspecialchars($d['nature_of_possession'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Enter nature of possession">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Specific comment on roadside/riverside reservation</label>
                                <textarea class="form-control" name="dag_items[<?= $idx ?>][reservation_comment]" rows="2" placeholder="Enter comments (provision kept for road/drain wherever necessary)"><?= htmlspecialchars($d['reservation_comment'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>

                            <!-- Reservation Fields -->
                            <?php if (!empty($application) && !empty($application['is_barak_valley']) && $application['is_barak_valley'] === 'Y'): ?>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Bigha)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_bigha]" value="<?= isset($d['bigha']) ? htmlspecialchars($d['bigha'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Katha)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_katha]" value="<?= isset($d['katha']) ? htmlspecialchars($d['katha'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Chatak)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_lessa]" value="<?= isset($d['lessa']) ? htmlspecialchars($d['lessa'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Ganda)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_ganda]" value="<?= isset($d['ganda']) ? htmlspecialchars($d['ganda'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                            <?php else: ?>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Bigha)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_bigha]" value="<?= isset($d['bigha']) ? htmlspecialchars($d['bigha'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Katha)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_katha]" value="<?= isset($d['katha']) ? htmlspecialchars($d['katha'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Reservation (Lessa)</label>
                                    <input type="number" step="any" min="0" class="form-control" name="dag_items[<?= $idx ?>][reservation_lessa]" value="<?= isset($d['lessa']) ? htmlspecialchars($d['lessa'], ENT_QUOTES, 'UTF-8') : '0' ?>" placeholder="0">
                                </div>
                            <?php endif; ?>

                            <!-- Uploads -->
                            <div class="col-12">
                                <label class="form-label">Field Visit Report (PDF/Doc)</label>
                                <input type="file" class="form-control" name="dag_items[<?= $d['dag_number'] ?>][visit_report]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Geo-tagged Photographs</label>
                                <input type="file" class="form-control" name="dag_items[<?= $d['dag_number'] ?>][photos][]" accept="image/*" multiple>
                                <div class="form-text">You can select multiple photos</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">No DAG details available to create entries.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
