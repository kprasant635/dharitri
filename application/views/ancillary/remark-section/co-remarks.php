<!-- Forward Form -->
<div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-forward me-2"></i>Forward Application
        </h5>
    </div>
    
    <div class="card-body">
        <?php if ($step_id == 4 && !empty($adcList)): ?>
            <div class="mb-3">
                <label for="adcUser" class="form-label">Select ADC User</label>
                <select class="form-select" id="adcUser" name="adc_user" required>
                    <option value="">-- Select ADC --</option>
                    <?php foreach ($adcList as $adc): ?>
                        <option value="<?= htmlspecialchars($adc['user_code']) ?>">
                            <?= htmlspecialchars($adc['user_code']) ?> 
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="is_user_available" value="1">
            </div>
        <?php endif; ?>
        <?php include 'common/common-remarks.php'; ?>
    </div>
</div>