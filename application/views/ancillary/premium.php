<div class="card-body">
    <?php if(isset($isLmNote) && $isLmNote == 1): ?>
        <?php if (!empty($premium)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>DAG No</th>
                            <th>User Code</th>
                            <th>Zonal Valuation (₹)</th>
                            <th>Amount per DAG (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($premium as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['dag_no']) ?></td>
                                <td><?= htmlspecialchars($item['user_code'] ?? 'N/A') ?></td>
                                <td class="text-end"><?= number_format($item['zonal_valuation'], 2) ?></td>
                                <td class="text-end"><?= number_format($item['amount_dag'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 p-3  rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Total Premium</h5>
                    <h3 class="mb-0 fw-bold text-primary">₹<?= number_format($premium[0]['total_premium'] ?? 0, 2) ?></h3>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                <h4>No Premium Data Available</h4>
                <p class="text-muted">There is no premium data to display for this application.</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h4>Premium Data Not Available Yet</h4>
            <p class="text-muted">The premium data will be available after the LRA checklist is completed.</p>
        </div>
    <?php endif; ?>
</div>