<?php if(isset($isKyc) && $isKyc == 1 && !empty($kycDetails)): ?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Applicant Name</h6>
            <p class="mb-0"><?= htmlspecialchars($kycDetails['name_eng'] ?? 'N/A') ?></p>
        </div>
        <?php if(strtoupper($kycDetails['type'] ?? '') === 'AADHAAR'): ?>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Father's Name</h6>
            <p class="mb-0"><?= htmlspecialchars($kycDetails['f_name'] ?? 'N/A') ?></p>
        </div>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Date of Birth</h6>
            <p class="mb-0"><?= !empty($kycDetails['dob']) ? date('d M Y', strtotime($kycDetails['dob'])) : 'N/A' ?></p>
        </div>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Gender</h6>
            <p class="mb-0">
                <?php 
                $gender = $kycDetails['gender'] ?? '';
                echo $gender === 'M' ? 'Male' : ($gender === 'F' ? 'Female' : 'Other');
                ?>
            </p>
        </div>
        <?php endif; ?>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Mobile Number</h6>
            <p class="mb-0"><?= htmlspecialchars($kycDetails['mobile'] ?? 'N/A') ?></p>
        </div>
    </div>
    <div class="col-md-6">
        <?php if(strtoupper($kycDetails['type'] ?? '') === 'AADHAAR'): ?>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Aadhaar Number</h6>
            <p class="mb-0">
                <?php 
                $aadhaar = $kycDetails['aadhaar_no'] ?? '';
                if (!empty($aadhaar)) {
                    $masked = str_repeat('*', max(0, strlen($aadhaar) - 4)) . substr($aadhaar, -4);
                    echo wordwrap(htmlspecialchars($masked), 4, ' ', true);
                } else {
                    echo 'N/A';
                }
                ?>
            </p>
        </div>
        <?php elseif(isset($kycDetails['pan_no'])): ?>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">PAN Number</h6>
            <p class="mb-0"><?= htmlspecialchars($kycDetails['pan_no'] ?? 'N/A') ?></p>
        </div>
        <?php if(isset($kycDetails['pan_type'])): ?>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">PAN Type</h6>
            <p class="mb-0"><?= htmlspecialchars($kycDetails['pan_type']) ?></p>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Verification Status</h6>
            <p class="mb-0">
                <?php if(($kycDetails['is_aadhaar_verify'] ?? 0) == 1 || !empty($kycDetails['pan_no'])): ?>
                <span class="badge bg-success">
                    <i class="fas fa-check-circle me-1"></i>Verified
                </span>
                <?php else: ?>
                <span class="badge bg-warning">
                    <i class="fas fa-exclamation-circle me-1"></i>Not Verified
                </span>
                <?php endif; ?>
            </p>
        </div>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Verification Type</h6>
            <p class="mb-0">
                <?= strtoupper($kycDetails['type'] ?? 'N/A') ?>
            </p>
        </div>
        <?php if(!empty($kycDetails['created_at'])): ?>
        <div class="mb-3">
            <h6 class="text-muted small mb-1">Verification Date</h6>
            <p class="mb-0">
                <?= date('d M Y, h:i A', strtotime($kycDetails['created_at'])) ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if(strtoupper($kycDetails['type'] ?? '') === 'AADHAAR'): ?>
<div class="mt-4">
    <h6 class="border-bottom pb-2 mb-3">Address Details</h6>
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <h6 class="text-muted small mb-1">Full Address</h6>
                <p class="mb-0">
                    <?php
                    $addressParts = [
                        $kycDetails['address'] ?? '',
                        $kycDetails['land_mark'] ?? '',
                        $kycDetails['city'] ?? '',
                        $kycDetails['district'] ?? '',
                        $kycDetails['state'] ?? '',
                        $kycDetails['pin'] ?? ''
                    ];
                    $formattedAddress = implode(', ', array_filter($addressParts, function($part) {
                        return !empty(trim($part));
                    }));
                    echo $formattedAddress ? htmlspecialchars($formattedAddress) : 'N/A';
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php else: ?>
<div class="text-center py-5">
    <div class="mb-3">
        <i class="fas fa-user-lock fa-3x text-muted"></i>
    </div>
    <h5>KYC Verification Required</h5>
    <p class="text-muted">Please complete the KYC verification to view applicant details.</p>
</div>
<?php endif; ?>