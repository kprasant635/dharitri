<?php if(isset($isLmNote) && $isLmNote == 1 && isset($lmNote) && !empty($lmNote)): ?>
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Land Details</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <tbody>
                <tr>
                    <td width="40%"><strong>Case Number</strong></td>
                    <td><?= htmlspecialchars($lmNote['case_no'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <td><strong>Possession Date</strong></td>
                    <td><?= !empty($lmNote['possession_date']) ? date('d-m-Y', strtotime($lmNote['possession_date'])) : 'N/A' ?></td>
                </tr>
                <tr>
                    <td><strong>Does the land fall under Tribal Belt/Block?</strong></td>
                    <td><?= ($lmNote['is_tribal_belt'] ?? 'N') === 'Y' ? 'Yes' : 'No' ?></td>
                </tr>
                <tr>
                    <td><strong>Is the land in a landslide prone area?</strong></td>
                    <td><?= ($lmNote['is_landslide'] ?? 'N') === 'Y' ? 'Yes' : 'No' ?></td>
                </tr>
                <tr>
                    <td><strong>Is the land a wetland?</strong></td>
                    <td><?= ($lmNote['is_wetland'] ?? 'N') === 'Y' ? 'Yes' : 'No' ?></td>
                </tr>
                <tr>
                    <td><strong>Verify Schedule of the land and area under occupation</strong></td>
                    <td><?= ($lmNote['schedule_details'] ?? 'N') === 'Y' ? 'Yes' : 'No' ?></td>
                </tr>
                <tr>
                    <td><strong>Recommendation Remarks</strong></td>
                    <td><?= ucfirst(htmlspecialchars($lmNote['recommendation_remark'] ?? 'N/A')) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php if(!empty($reservation)): ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Reservation Details by DAG Number</h5>
    </div>
    <div class="card-body p-0">
        <?php foreach($reservationsView as $res): ?>
            <div class="border-bottom mb-3">
                <div class=" p-2">
                    <strong>DAG No:</strong> <?= htmlspecialchars($res['dag_no']) ?>
                </div>
                <table class="table table-bordered mb-0">
                    <tr>
                        <td width="30%"><strong>Area Details</strong></td>
                        <td>
                            <?php 
                            // Get area values from the reservation record
                            $bigha = $res['bigha'] ?? 0;
                            $katha = $res['katha'] ?? 0;
                            $lessa = $res['lessa'] ?? 0;
                            $ganda = $res['ganda'] ?? 0;
                            $is_barak_valley = isset($application['is_barak_valley']) && $application['is_barak_valley'] === 'N';
                            
                            // Always show all area values, including zeros
                            $area_parts = [];
                            $area_parts[] = $bigha . ' Bigha';
                            $area_parts[] = $katha . ' Katha';
                            $area_parts[] = $lessa . ' ' . ($is_barak_valley ? 'Lessa' : 'Chatak');
                            if (!$is_barak_valley) {
                                $area_parts[] = $ganda . ' Ganda';
                            }
                            
                            echo implode(' | ', $area_parts);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><strong>Nature of Possession</strong></td>
                        <td><?= htmlspecialchars($res['nature_of_possession'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Reservation Comment</strong></td>
                        <td><?= htmlspecialchars($res['reservation_comment'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated</strong></td>
                        <td><?= !empty($res['date_update']) ? date('d-m-Y H:i', strtotime($res['date_update'])) : 'N/A' ?></td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> No reservation data available.
    </div>
<?php endif; ?>

<?php elseif(isset($isLmNote) && $isLmNote != 1): ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i> LRA checklist Not available yet
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i> No LM Note data available.
    </div>
<?php endif; ?>
