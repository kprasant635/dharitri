<!-- Forward Form -->
<form action="<?= base_url('your-submit-url') ?>" method="POST" id="forwardForm">
<div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-forward me-2"></i>Forward Application
        </h5>
    </div>
    <div class="card-body">
        <?php include 'lm-checklist.php'; ?>

        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#premiumModal">
                <i class="fas fa-calculator me-2"></i>Calculate Premium
            </button>
        </div>

        <div class="mt-2" id="total-premium-outside-wrap">
            <label for="total-premium-outside" class="mb-1">Total premium</label>
            <input type="text" id="total-premium-outside" class="form-control" value="0" disabled>
        </div>

        <!-- Hidden inputs that will mirror modal data -->
        <div id="premium-post-data" class="d-none">
            <input type="hidden" name="premium_total" id="premium_total" value="0">
        </div>

        <div class="row g-3 align-items-start p-3"></div>

        <div class="row g-3 align-items-start p-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="lm_recommendation" class="form-label">Recommendation</label>
                    <select class="form-select" id="lm_recommendation" name="lm[recommendation]">
                        <option value="" selected disabled>-- Select --</option>
                        <option value="can">Can be recommended</option>
                        <option value="cannot">Can not be recommended</option>
                    </select>
                    <div class="form-text">Selecting an option will prefill the remarks on the right. You can edit it.</div>
                </div>
            </div>
            <div class="col-md-8">
                <?php include 'common/common-remarks.php'; ?>
            </div>
        </div>
    </div>
</div>
</form>


<!-- Modal: Premium Calculation -->
<div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="premiumModalLabel">Premium Calculation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php if (!empty($dag_details) && is_array($dag_details)): ?>
                    <div class="vstack gap-3">
                        <?php foreach ($dag_details as $d): ?>
                            <?php $safeDn = htmlspecialchars($d['dag_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            <div class="card border">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <strong>DAG <?= $safeDn ?></strong>
                                </div>

                                <div class="card-body">
                                    <form class="premium-form" data-dag="<?= $safeDn ?>">
                                        <div class="row g-3">

                                            <!-- Zonal Value -->
                                            <div class="col-12">
                                                <label class="form-label">Zonal Value</label>
                                                <input type="text" class="form-control" name="zonal_value"
                                                    value="<?= htmlspecialchars((string)$this->utilityclass->getZonalValue($d['district_code'], $d['uuid'], ($d['dag_number'] ?? '')), ENT_QUOTES, 'UTF-8') ?>">
                                            </div>

                                            <!-- Selected Area Type -->
                                            <div class="col-12">
                                                <label class="form-label">Selected Area Type (Chitha Dag Flag)</label>
                                                <input type="hidden" id="area_new<?= $safeDn ?>"
                                                    value="<?= $this->utilityclass->getAreaCategory($d['district_code'], $d['subdiv_code'], $d['circle_code'], $d['mouza_code'], $d['lot_no'], $d['village_code'], ($d['dag_number'] ?? '')) ?>">
                                                <input type="hidden" id="area_cat_new<?= $safeDn ?>"
                                                    value="<?= $this->utilityclass->getAreaName($d['district_code'], $d['subdiv_code'], $d['circle_code'], $d['mouza_code'], $d['lot_no'], $d['village_code'], ($d['dag_number'] ?? '')) ?>">
                                                <select class="form-select" name="area<?= $safeDn ?>" id="area<?= $safeDn ?>" readonly>
                                                    <option value="">First select Area type in Area details section</option>
                                                </select>
                                            </div>

                                            <!-- Existing Land Class -->
                                            <div class="col-12">
                                                <label class="form-label">Existing Land Class (As Per Chitha Record)</label>
                                                <input type="text" class="form-control"
                                                    value="<?= htmlspecialchars($d['land_class_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" disabled>
                                                <input type="hidden" name="land_class_code"
                                                    value="<?= htmlspecialchars($d['land_class_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                            </div>

                                            <!-- Proposed Land Class -->
                                            <div class="col-12">
                                                <label class="form-label">Proposed Land Class</label>
                                                <select class="form-select" name="proposed_class_code" id="proposed_class_code<?= $safeDn ?>">
                                                    <option value="">--SELECT PROPOSED LAND CLASS--</option>
                                                    <?php if (!empty($land_class_groups)): ?>
                                                        <?php foreach ($land_class_groups as $value): ?>
                                                            <?php
                                                            $selected = ((string)$value->id === (string)($d['proposed_class_code'] ?? ($d['proposed_class'] ?? ''))) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?= $value->id ?>" <?= $selected ?>><?= $value->name; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <!-- Select Land Type -->
                                            <div class="col-12">
                                                <label class="form-label">Select Land Type for Existing Land Class (As per Chitha Record)</label>
                                                <select class="form-select" name="rate_type">
                                                    <option value="">Select Land Type</option>
                                                    <option value="1">Agriculture</option>
                                                    <option value="2">Residential</option>
                                                    <option value="4">Trade</option>
                                                    <option value="3">Industrial</option>
                                                    <option value="10">Institution</option>
                                                    <option value="6">Plantation</option>
                                                </select>
                                            </div>

                                            <!-- Hidden area units -->
                                            <input type="hidden" id="is_barak_valley<?= $safeDn ?>"
                                                value="<?= isset($application['is_barak_valley']) ? $application['is_barak_valley'] : 'N' ?>">
                                            <input type="hidden" id="home_b<?= $safeDn ?>"
                                                value="<?= htmlspecialchars($d['ancillary_bigha'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" id="home_k<?= $safeDn ?>"
                                                value="<?= htmlspecialchars($d['ancillary_katha'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" id="home_lc<?= $safeDn ?>"
                                                value="<?= htmlspecialchars($d['ancillary_lessa'] ?? ($d['ancillary_chatak'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" id="home_g<?= $safeDn ?>"
                                                value="<?= htmlspecialchars($d['ancillary_ganda'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                                        </div>
                                    </form>

                                    <!-- Inline JS for Area Type -->
                                    <script>
                                        (function() {
                                            try {
                                                var dag = '<?= $safeDn ?>';
                                                var areaIdEl = document.getElementById('area_new' + dag);
                                                var areaCatEl = document.getElementById('area_cat_new' + dag);
                                                var selectEl = document.getElementById('area' + dag);
                                                if (areaIdEl && areaCatEl && selectEl) {
                                                    var area_id = areaIdEl.value || '';
                                                    var area_category = areaCatEl.value || '';
                                                    var opt = document.createElement('option');
                                                    opt.value = area_id;
                                                    opt.textContent = area_category;
                                                    selectEl.innerHTML = '';
                                                    selectEl.appendChild(opt);
                                                }
                                            } catch (e) {}
                                        })();
                                    </script>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary btn-fetch-premium mt-2"
                                            data-dag="<?= $safeDn ?>">Fetch Premium</button>
                                    </div>

                                    <div id="premium-result-<?= $safeDn ?>" class="premium-result small text-muted mt-2">
                                        No data fetched yet.
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-0">No DAG details available to calculate premium.</div>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <div class="form-group w-100 mb-0">
                    <label for="total-premium" class="mb-1">Total Premium</label>
                    <input type="text" id="total-premium" class="form-control" value="0" disabled>
                </div>
                <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script>
(function() {
    // Ensure modal stays outside nested DOM
    if (window.jQuery) {
        try { $('#premiumModal').appendTo('body'); } catch (e) {}
    }

    // Utility: create or update a hidden input in #premium-post-data
    function upsertHidden(name, value) {
        var container = document.getElementById('premium-post-data');
        if (!container) return;
        var safeId = 'hidden_' + name.replace(/[^a-z0-9_]+/gi, '_');
        var el = document.getElementById(safeId);
        if (!el) {
            el = document.createElement('input');
            el.type = 'hidden';
            el.name = name;
            el.id = safeId;
            container.appendChild(el);
        }
        el.value = String(value == null ? '' : value);
    }

    // Prefill remarks when recommendation changes
    const sel = document.getElementById('lm_recommendation');
    const remarks = document.getElementById('remarks');
    if (sel && remarks) {
        sel.addEventListener('change', function() {
            const canText = 'Recommendation: The case can be recommended based on field verification and documentary evidence.';
            const cannotText = 'Recommendation: The case cannot be recommended at this stage. Reasons: [please specify].';
            let prefill = '';
            if (this.value === 'can') prefill = canText;
            if (this.value === 'cannot') prefill = cannotText;
            if (!remarks.value?.trim()) {
                remarks.value = prefill;
            } else {
                remarks.value = remarks.value?.trim() + '\n\n' + prefill;
            }
        });
    }

    const modalEl = document.getElementById('premiumModal');
    if (modalEl) {
        modalEl.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-fetch-premium');
            if (!btn) return;
            const dag = btn.getAttribute('data-dag');
            let form = btn.closest('form');
            const card = btn.closest('.card');
            const target = document.getElementById('premium-result-' + dag);
            const scope = form || card || document;

            const zonalVal = parseFloat(((scope.querySelector('input[name="zonal_value"]')) || {}).value || '0');
            const exit_class = (scope.querySelector('select[name="rate_type"]') || {}).value || '';
            const prop_land_class = (scope.querySelector('select[name="proposed_class_code"]') || {}).value || '';

            if (!exit_class) { alert('#ERR: Please select existing land class type.'); return; }
            if (!prop_land_class) { alert('#ERR: Proposed land class not found.'); return; }

            const isBarak = ((document.getElementById('is_barak_valley' + dag)) || {}).value === 'Y';
            const b = parseFloat(((document.getElementById('home_b' + dag)) || {}).value || '0');
            const k = parseFloat(((document.getElementById('home_k' + dag)) || {}).value || '0');
            const lc = parseFloat(((document.getElementById('home_lc' + dag)) || {}).value || '0');
            const g = parseFloat(((document.getElementById('home_g' + dag)) || {}).value || '0');

            if (target) target.textContent = 'Fetching premium for DAG ' + dag + '...';

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url() ?>index.php/SettlementInstitutionLm/getRateWithTransfer/' + encodeURIComponent(prop_land_class) + '/' + encodeURIComponent(exit_class));
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            var landpercentage = JSON.parse(xhr.responseText);
                            var perc = landpercentage && landpercentage[0] ? parseFloat(landpercentage[0].rate) : 0;
                            var reclassBase = (zonalVal * perc) / 100;
                            var amount = 0;
                            if (isBarak) {
                                var total_ganda = (b * 6400) + (k * 320) + (lc * 20) + g;
                                var per_ganda_rate = reclassBase / 6400;
                                amount = total_ganda * per_ganda_rate;
                            } else {
                                var total_lessa = (b * 100) + (k * 20) + lc;
                                var per_lessa_rate = reclassBase / 100;
                                amount = total_lessa * per_lessa_rate;
                            }
                            var amt = Math.ceil(amount);
                            var msg = 'Rate: ' + perc + '% | Zonal: ' + zonalVal + ' | Amount: ' + amt;
                            if (target) {
                                target.textContent = msg;
                                target.dataset.amount = String(amt);
                            }

                            // Update total premium fields
                            var totalBox = modalEl.querySelector('#total-premium');
                            if (totalBox) {
                                var sum = 0;
                                var results = modalEl.querySelectorAll('.premium-result');
                                results.forEach(function(el) {
                                    var v = el.dataset && el.dataset.amount ? parseFloat(el.dataset.amount) : NaN;
                                    if (isNaN(v)) {
                                        var m = (el.textContent || '').match(/Amount:\s*(\d+)/i);
                                        if (m) v = parseFloat(m[1]);
                                    }
                                    if (!isNaN(v)) sum += v;
                                });
                                var totalVal = String(Math.ceil(sum));
                                totalBox.value = totalVal;
                                var totalOutside = document.getElementById('total-premium-outside');
                                if (totalOutside) totalOutside.value = totalVal;
                                upsertHidden('premium_total', totalVal);

                                // Save all per-DAG values
                                var dagName = btn.getAttribute('data-dag') || '';
                                if (dagName) {
                                    upsertHidden('premium[' + dagName + '][zonal_value]', zonalVal);
                                    upsertHidden('premium[' + dagName + '][rate_type]', exit_class);
                                    upsertHidden('premium[' + dagName + '][proposed_class_code]', prop_land_class);
                                    upsertHidden('premium[' + dagName + '][amount]', amt);

                                    // ✅ NEW: include area and land class details
                                    var areaIdEl = document.getElementById('area_new' + dagName);
                                    var areaCatEl = document.getElementById('area_cat_new' + dagName);
                                    var landClassInput = (scope.querySelector('input[name="land_class_code"]') || {});
                                    upsertHidden('premium[' + dagName + '][area_id]', areaIdEl ? areaIdEl.value || '' : '');
                                    upsertHidden('premium[' + dagName + '][area_cat]', areaCatEl ? areaCatEl.value || '' : '');
                                    upsertHidden('premium[' + dagName + '][land_class_code]', landClassInput.value || '');
                                }
                            }
                        } catch (e) {
                            if (target) target.textContent = 'Error parsing rate response';
                        }
                    } else {
                        if (target) target.textContent = 'Error fetching rate (' + xhr.status + ')';
                    }
                }
            };
            xhr.send();
        });
    }

    // ✅ Mirror all modal fields when modal closes
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('premiumModal');
        if (!modal) return;

        modal.addEventListener('hidden.bs.modal', function () {
            try {
                const container = document.getElementById('premium-post-data');
                if (!container) return;

                // Mirror all named modal-level fields
                const modalNamed = modal.querySelectorAll('input[name], select[name], textarea[name]');
                modalNamed.forEach(function(field) {
                    if (field.disabled) return;
                    const name = field.name;
                    const value = field.type === 'checkbox' ? (field.checked ? field.value : '') : field.value;
                    const safeId = 'hidden_' + name.replace(/[^a-z0-9_]+/gi, '_');
                    let hidden = document.getElementById(safeId);
                    if (!hidden) {
                        hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = name;
                        hidden.id = safeId;
                        container.appendChild(hidden);
                    }
                    hidden.value = value;
                });

                // Mirror per-DAG premium-form fields
                const forms = modal.querySelectorAll('.premium-form');
                forms.forEach(function(f) {
                    const dag = f.getAttribute('data-dag') || '';
                    if (!dag) return;

                    function setPremiumHidden(key, val) {
                        const n = 'premium[' + dag + '][' + key + ']';
                        const safeId = 'hidden_' + n.replace(/[^a-z0-9_]+/gi, '_');
                        let hidden = document.getElementById(safeId);
                        if (!hidden) {
                            hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = n;
                            hidden.id = safeId;
                            container.appendChild(hidden);
                        }
                        hidden.value = String(val == null ? '' : val);
                    }

                    // Mirror key fields
                    setPremiumHidden('zonal_value', (f.querySelector('input[name="zonal_value"]') || {}).value || '');
                    setPremiumHidden('rate_type', (f.querySelector('select[name="rate_type"]') || {}).value || '');
                    setPremiumHidden('proposed_class_code', (f.querySelector('select[name="proposed_class_code"]') || {}).value || '');

                    var resultEl = document.getElementById('premium-result-' + dag);
                    var amountVal = '';
                    if (resultEl && resultEl.dataset && resultEl.dataset.amount) {
                        amountVal = resultEl.dataset.amount;
                    } else {
                        var m = (resultEl ? resultEl.textContent || '' : '').match(/Amount:\s*(\d+)/i);
                        if (m) amountVal = m[1];
                    }
                    setPremiumHidden('amount', amountVal);

                    // ✅ Also mirror area and land class
                    const areaIdEl = document.getElementById('area_new' + dag);
                    const areaCatEl = document.getElementById('area_cat_new' + dag);
                    setPremiumHidden('area_id', areaIdEl ? (areaIdEl.value || '') : '');
                    setPremiumHidden('area_cat', areaCatEl ? (areaCatEl.value || '') : '');
                    const lcInput = f.querySelector('input[name="land_class_code"]');
                    setPremiumHidden('land_class_code', lcInput ? (lcInput.value || '') : '');
                });

            } catch (err) {
                console.error('Error mirroring modal fields:', err);
            }
        });
    });
})();
</script>
