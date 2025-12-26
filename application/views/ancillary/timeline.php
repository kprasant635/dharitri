<div class="tree-timeline-container">
    <?php if (!empty($applicationWorkflowForTimeline)): ?>
        <!-- Simple HTML Table View -->
        <div class="workflow-table-wrapper">
            <table class="workflow-table">
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Case</th>
                        <th>Status</th>
                        <th>Started</th>
                        <th>Completed</th>
                        <th>Officer</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applicationWorkflowForTimeline as $wf): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($wf['step_id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($wf['case_no'] ?? ''); ?></td>
                            <td>
                                <?php 
                                    $st = strtolower($wf['status'] ?? '');
                                    $stClass = $st === 'completed' ? 'completed' : ($st === 'in-progress' ? 'in-progress' : 'pending');
                                ?>
                                <span class="status-pill <?php echo $stClass; ?>"><?php echo htmlspecialchars($wf['status'] ?? ''); ?></span>
                            </td>
                            <td><?php echo !empty($wf['started_at']) ? date('d M Y H:i', strtotime($wf['started_at'])) : ''; ?></td>
                            <td><?php echo !empty($wf['completed_at']) ? date('d M Y H:i', strtotime($wf['completed_at'])) : ''; ?></td>
                            <td><?php echo htmlspecialchars((string)($wf['assigned_officer_id'] ?? '')); ?></td>
                            <td class="wrap-text"><?php echo htmlspecialchars($wf['remarks'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php 
        // Use original array order (no reverse)
        $workflowTimeline = $applicationWorkflowForTimeline;

        // Group records by step_id so multiple records under the same step can branch
        $groupedByStep = [];
        foreach ($workflowTimeline as $wf) {
            $stepKey = $wf['step_id'];
            if (!isset($groupedByStep[$stepKey])) {
                $groupedByStep[$stepKey] = [];
            }
            $groupedByStep[$stepKey][] = $wf;
        }
        ?>
        
        <div class="horizontal-tree">
            <?php foreach ($groupedByStep as $stepIndex => $workflows): ?>
                <div class="tree-column" data-level="<?php echo $stepIndex; ?>">
                    <!-- Step Node -->
                    <div class="step-node">
                        <div class="node-circle">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div class="step-info">
                            <h3 class="step-title">Step: <?php echo htmlspecialchars($stepIndex); ?></h3>
                            <span class="step-count"><?php echo count($workflows); ?> record(s)</span>
                        </div>
                    </div>

                    <!-- Branch Container -->
                    <div class="branches-container">
                        <?php 
                            // Group this step's workflows by case_no to form branches
                            $workflowsByCase = [];
                            foreach ($workflows as $wfItem) {
                                $caseKey = $wfItem['case_no'];
                                if (!isset($workflowsByCase[$caseKey])) {
                                    $workflowsByCase[$caseKey] = [];
                                }
                                $workflowsByCase[$caseKey][] = $wfItem;
                            }

                            // Determine the anchor case for the connector to next step: prefer a case that has any completed item
                            $anchorCaseNo = null;
                            foreach ($workflowsByCase as $acCaseNo => $acItems) {
                                foreach ($acItems as $acItem) {
                                    if (strtolower($acItem['status']) === 'completed') {
                                        $anchorCaseNo = $acCaseNo;
                                        break 2; // stop as soon as we find a completed case
                                    }
                                }
                            }
                            // If none completed, fall back to the first case to avoid orphan connector positioning (optional)
                            if ($anchorCaseNo === null) {
                                $keys = array_keys($workflowsByCase);
                                $anchorCaseNo = $keys[0] ?? null;
                            }
                        ?>

                        <!-- Horizontal Branch Line from Step -->
                        <?php if (count($workflowsByCase) > 0): ?>
                            <div class="main-branch-line"></div>
                        <?php endif; ?>

                        <!-- Case Branches -->
                        <div class="case-branches">
                            <?php foreach ($workflowsByCase as $caseNo => $caseWorkflows): ?>
                                <div class="case-branch">
                                    <!-- Individual Branch Connector for this case -->
                                    <div class="individual-branch-connector"></div>
                                    
                                    <!-- Combined Case and Workflow Card -->
                                    <div class="case-workflow-card">
                                        <div class="case-header">
                                            <div class="case-circle">
                                                <i class="fas fa-folder"></i>
                                            </div>
                                            <div class="case-info">
                                                <h4 class="case-title">Case: <?php echo htmlspecialchars($caseNo); ?></h4>
                                                <span class="case-count"><?php echo count($caseWorkflows); ?> item(s)</span>
                                            </div>
                                        </div>

                                        <!-- Workflow Details -->
                                        <div class="workflow-details-container">
                                            <?php foreach ($caseWorkflows as $index => $workflow): ?>
                                                <div class="workflow-detail">
                                                    <div class="workflow-status">
                                                        <div class="workflow-circle status-<?php echo strtolower($workflow['status']); ?>">
                                                            <?php if (strtolower($workflow['status']) === 'completed'): ?>
                                                                <i class="fas fa-check"></i>
                                                            <?php elseif (strtolower($workflow['status']) === 'pending'): ?>
                                                                <i class="fas fa-clock"></i>
                                                            <?php elseif (strtolower($workflow['status']) === 'in-progress'): ?>
                                                                <i class="fas fa-spinner"></i>
                                                            <?php else: ?>
                                                                <i class="fas fa-circle"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <span class="status-badge status-<?php echo strtolower($workflow['status']); ?>">
                                                            <?php echo htmlspecialchars($workflow['status']); ?>
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="workflow-info">
                                                        <div class="info-item">
                                                            <i class="fas fa-clock"></i>
                                                            <span><strong>Started:</strong> <?php echo date('d M Y H:i', strtotime($workflow['started_at'])); ?></span>
                                                        </div>
                                                        
                                                        <div class="info-item">
                                                            <i class="fas fa-user"></i>
                                                            <span><strong>Officer:</strong> <?php echo htmlspecialchars($workflow['assigned_officer_id']); ?></span>
                                                        </div>
                                                        
                                                        <?php if (!empty($workflow['completed_at'])): ?>
                                                            <div class="info-item">
                                                                <i class="fas fa-calendar-check"></i>
                                                                <span><strong>Completed:</strong> <?php echo date('d M Y H:i', strtotime($workflow['completed_at'])); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($workflow['remarks'])): ?>
                                                            <div class="info-item remarks">
                                                                <i class="fas fa-comment"></i>
                                                                <div>
                                                                    <strong>Remarks:</strong>
                                                                    <p><?php echo htmlspecialchars($workflow['remarks']); ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php if ($index < count($caseWorkflows) - 1): ?>
                                                    <div class="workflow-separator"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php if ($stepIndex !== array_key_last($groupedByStep) && $anchorCaseNo !== null && $caseNo === $anchorCaseNo): ?>
                                        <!-- Connection to Next Column anchored to the completed case branch -->
                                        <div class="column-connector column-connector--from-branch"></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-tree">
            <div class="empty-icon">
                <i class="fas fa-sitemap"></i>
            </div>
            <p>There are no workflow records to display in the tree structure.</p>
        </div>
    <?php endif; ?>
</div>

 <!-- Add Font Awesome CDN in your HTML head -->
 <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> -->

<style>
  /* Simplified table view overrides */
  .horizontal-tree,
  .tree-column,
  .step-node,
  .branches-container,
  .main-branch-line,
  .case-branches,
  .case-branch,
  .case-workflow-card,
  .column-connector { display: none !important; }

  .workflow-table-wrapper { padding: 16px; background: #fff; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); margin-bottom: 16px; }
  .workflow-table { width: 100%; border-collapse: collapse; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; }
  .workflow-table thead th { background: #f3f4f6; color: #111827; text-align: left; padding: 10px 12px; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 1; }
  .workflow-table tbody td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; color: #374151; vertical-align: top; }
  .workflow-table tbody tr:nth-child(even) { background: #fafafa; }
  .status-pill { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
  .status-pill.completed { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
  .status-pill.pending { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
  .status-pill.in-progress { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
  .wrap-text { white-space: pre-wrap; word-break: break-word; }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

.tree-timeline-container {
    width: 100%;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    overflow-x: auto;
}

.horizontal-tree {
    display: flex;
    align-items: flex-start;
    gap: 0;
    min-width: max-content;
    padding: 40px 0;
    position: relative;
}

.tree-column {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 100px;
    animation: slideInLeft 0.8s ease-out forwards;
    opacity: 0;
    transform: translateX(-50px);
    min-height: 600px;
}

.tree-column:nth-child(1) { animation-delay: 0.2s; }
.tree-column:nth-child(2) { animation-delay: 0.4s; }
.tree-column:nth-child(3) { animation-delay: 0.6s; }
.tree-column:nth-child(4) { animation-delay: 0.8s; }
.tree-column:nth-child(5) { animation-delay: 1.0s; }

.tree-column:last-child {
    margin-right: 0;
}

.step-node {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    padding: 32px 24px;
    border-radius: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    margin-bottom: 40px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 10;
    min-width: 200px;
    text-align: center;
}

.step-node:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.2);
}

.node-circle {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
    animation: pulse 2s infinite;
}

.step-info {
    text-align: center;
}

.step-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    line-height: 1.2;
}

.step-count {
    background: linear-gradient(135deg, #e0e7ff, #ddd6fe);
    color: #4f46e5;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid rgba(79, 70, 229, 0.2);
}

.branches-container {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.main-branch-line {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 50px;
    background: linear-gradient(180deg, #4f46e5, #10b981);
    border-radius: 2px;
    z-index: 5;
}

.case-branches {
    display: flex;
    flex-direction: column;
    gap: 40px;
    position: relative;
    align-items: flex-start;
    width: 100%;
    margin-left: 50px;
}

.case-branch {
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;
    width: 100%;
}

.individual-branch-connector {
    position: absolute;
    left: -70px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #10b981, #06b6d4);
    border-radius: 2px;
    z-index: 2;
}

/* Individual vertical line connecting each case to main trunk */
.individual-branch-connector::before {
    content: '';
    position: absolute;
    left: -20px;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 200px; /* Adjust based on spacing between cases */
    background: linear-gradient(180deg, #10b981, #06b6d4);
    border-radius: 2px;
    z-index: 1;
}

.case-workflow-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(229, 231, 235, 0.3);
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    padding: 24px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 8;
    min-width: 350px;
    max-width: 500px;
    margin-left: 20px;
}

.case-workflow-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 45px rgba(0,0,0,0.15);
}

.case-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid rgba(229, 231, 235, 0.3);
}

.case-circle {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #10b981, #06b6d4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    flex-shrink: 0;
}

.case-info {
    text-align: left;
}

.case-title {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 6px;
    line-height: 1.2;
}

.case-count {
    background: rgba(16, 185, 129, 0.1);
    color: #047857;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.workflow-details-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.workflow-detail {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.workflow-status {
    display: flex;
    align-items: center;
    gap: 16px;
}

.workflow-separator {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
    margin: 10px 0;
}

.case-branch-line {
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #06b6d4, #8b5cf6);
    border-radius: 2px;
    z-index: 2;
}

.workflow-items {
    display: flex;
    flex-direction: column;
    gap: 25px;
    position: relative;
}

.workflow-item {
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;
}

.workflow-connector {
    position: absolute;
    left: -20px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 2px;
    background: linear-gradient(90deg, #8b5cf6, #06b6d4);
    border-radius: 1px;
}

.workflow-node {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    padding: 24px;
    border-radius: 18px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    position: relative;
    min-width: 350px;
    max-width: 400px;
}

.workflow-node:hover {
    transform: translateX(5px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}

.workflow-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}

.workflow-circle.status-completed {
    background: linear-gradient(135deg, #10b981, #059669);
    animation: successPulse 2s infinite;
}

.workflow-circle.status-pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    animation: pendingPulse 2s infinite;
}

.workflow-circle.status-in-progress {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    animation: progressSpin 2s linear infinite;
}

.workflow-details {
    flex: 1;
    min-width: 0;
}

.status-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 10px;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.status-completed {
    background: rgba(16, 185, 129, 0.15);
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-badge.status-pending {
    background: rgba(245, 158, 11, 0.15);
    color: #92400e;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-badge.status-in-progress {
    background: rgba(59, 130, 246, 0.15);
    color: #1d4ed8;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.start-time {
    font-size: 12px;
    color: #6b7280;
    background: rgba(249, 250, 251, 0.8);
    padding: 4px 10px;
    border-radius: 8px;
}

.workflow-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 14px;
}

.info-item i {
    color: #6b7280;
    width: 16px;
    margin-top: 2px;
    flex-shrink: 0;
}

.info-item strong {
    color: #374151;
    margin-right: 8px;
}

.info-item span {
    color: #4b5563;
}

.remarks {
    background: rgba(239, 246, 255, 0.8);
    padding: 16px;
    border-radius: 12px;
    border-left: 4px solid #3b82f6;
    margin-top: 8px;
}

.remarks i {
    color: #3b82f6;
}

.remarks p {
    margin-top: 8px;
    line-height: 1.5;
    color: #1f2937;
}

.column-connector {
    position: absolute;
    right: -50px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 4px;
    background: linear-gradient(90deg, #10b981, #4f46e5);
    border-radius: 2px;
    z-index: 1;
}

/* Position the per-branch connector relative to the branch so the arrow comes from that specific case */
.case-branch {
    position: relative;
}
.column-connector--from-branch {
    right: -70px; /* slightly further to clear branch connectors */
}

.empty-tree {
    text-align: center;
    padding: 80px 60px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 30px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    margin: 0 auto;
    max-width: 500px;
}

.empty-icon {
    font-size: 64px;
    color: #9ca3af;
    margin-bottom: 24px;
    opacity: 0.8;
}

.empty-tree h3 {
    font-size: 28px;
    color: #374151;
    margin-bottom: 16px;
    font-weight: 600;
}

.empty-tree p {
    color: #6b7280;
    font-size: 18px;
    line-height: 1.6;
}

/* Vertical connecting lines between case branches - now properly centered */
.case-branches::before {
    content: '';
    position: absolute;
    left: -70px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #10b981, #06b6d4, #8b5cf6);
    border-radius: 2px;
    z-index: 1;
}

/* Animations */
@keyframes slideInLeft {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes successPulse {
    0%, 100% { box-shadow: 0 6px 18px rgba(16, 185, 129, 0.3); }
    50% { box-shadow: 0 6px 18px rgba(16, 185, 129, 0.6); }
}

@keyframes pendingPulse {
    0%, 100% { box-shadow: 0 6px 18px rgba(245, 158, 11, 0.3); }
    50% { box-shadow: 0 6px 18px rgba(245, 158, 11, 0.6); }
}

@keyframes progressSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .tree-column {
        margin-right: 80px;
    }
    
    .case-workflow-card {
        min-width: 300px;
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .tree-timeline-container {
        padding: 20px 10px;
    }

    .horizontal-tree {
        flex-direction: column;
        align-items: center;
        gap: 60px;
    }

    .tree-column {
        margin-right: 0;
        margin-bottom: 40px;
        width: 100%;
        max-width: 500px;
    }

    .case-branches {
        align-items: center;
    }

    .case-branch {
        flex-direction: column;
        gap: 20px;
        align-items: center;
        width: auto;
    }

    .branch-connector {
        position: relative;
        left: auto;
        top: auto;
        transform: none;
        width: 3px;
        height: 30px;
    }

    .case-branch-line {
        width: 3px;
        height: 20px;
    }

    .workflow-items {
        align-items: center;
    }

    .workflow-item {
        flex-direction: column;
        gap: 15px;
    }

    .workflow-connector {
        position: relative;
        left: auto;
        top: auto;
        transform: none;
        width: 2px;
        height: 15px;
    }

    .case-workflow-card {
        min-width: 280px;
        max-width: 100%;
    }

    .column-connector {
        display: none;
    }

    .case-branches::before {
        display: none;
    }
}

@media (max-width: 480px) {
    .step-title {
        font-size: 16px;
    }

    .case-title {
        font-size: 14px;
    }

    .case-workflow-card {
        padding: 20px;
        min-width: 260px;
    }

    .node-circle {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }

    .case-circle {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }

    .workflow-circle {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .step-node {
        padding: 24px 20px;
        min-width: 180px;
    }

    .case-node {
        min-width: 220px;
        padding: 16px 20px;
    }
}

/* Custom scrollbar for horizontal scroll */
.tree-timeline-container::-webkit-scrollbar {
    height: 12px;
}

.tree-timeline-container::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
}

.tree-timeline-container::-webkit-scrollbar-thumb {
    background: rgba(79, 70, 229, 0.4);
    border-radius: 6px;
    border: 2px solid transparent;
    background-clip: content-box;
}

.tree-timeline-container::-webkit-scrollbar-thumb:hover {
    background: rgba(79, 70, 229, 0.6);
    background-clip: content-box;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced scroll-triggered animations
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px -100px 0px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                
                // Add staggered animation to workflow nodes
                const workflows = entry.target.querySelectorAll('.workflow-node');
                workflows.forEach((workflow, index) => {
                    setTimeout(() => {
                        workflow.style.transform = 'translateX(0)';
                        workflow.style.opacity = '1';
                    }, index * 150);
                });
            }
        });
    }, observerOptions);

    document.querySelectorAll('.tree-column').forEach(column => {
        observer.observe(column);
    });

    // Initialize workflow nodes for animation
    document.querySelectorAll('.workflow-node').forEach(node => {
        node.style.transform = 'translateX(-30px)';
        node.style.opacity = '0';
        node.style.transition = 'all 0.6s ease-out';
    });

    // Interactive hover effects for tree connections
    document.querySelectorAll('.case-node').forEach(node => {
        node.addEventListener('mouseenter', function() {
            const branch = this.closest('.case-branch');
            const connectors = branch.querySelectorAll('.branch-connector, .case-branch-line, .workflow-connector');
            connectors.forEach(connector => {
                connector.style.background = 'linear-gradient(90deg, #10b981, #3b82f6)';
                connector.style.boxShadow = '0 0 15px rgba(16, 185, 129, 0.5)';
                connector.style.transform = 'scaleX(1.1)';
            });
        });

        node.addEventListener('mouseleave', function() {
            const branch = this.closest('.case-branch');
            const connectors = branch.querySelectorAll('.branch-connector, .case-branch-line, .workflow-connector');
            connectors.forEach(connector => {
                connector.style.background = '';
                connector.style.boxShadow = '';
                connector.style.transform = '';
            });
        });
    });

    // Click to highlight entire workflow path
    document.querySelectorAll('.workflow-node').forEach(node => {
        node.addEventListener('click', function() {
            // Remove previous highlights
            document.querySelectorAll('.highlighted').forEach(el => {
                el.classList.remove('highlighted');
            });

            // Highlight current path
            const branch = this.closest('.case-branch');
            const stepNode = this.closest('.tree-column').querySelector('.step-node');
            
            stepNode.classList.add('highlighted');
            branch.querySelector('.case-node').classList.add('highlighted');
            this.classList.add('highlighted');

            // Highlight connecting lines
            const connectors = branch.querySelectorAll('.branch-connector, .case-branch-line');
            connectors.forEach(connector => {
                connector.classList.add('highlighted-line');
            });

            // Add temporary highlight styles
            const style = document.createElement('style');
            style.textContent = `
                .highlighted {
                    box-shadow: 0 0 30px rgba(79, 70, 229, 0.6) !important;
                    transform: scale(1.02) !important;
                    border-color: rgba(79, 70, 229, 0.5) !important;
                }
                .highlighted-line {
                    background: linear-gradient(90deg, #4f46e5, #10b981) !important;
                    box-shadow: 0 0 20px rgba(79, 70, 229, 0.8) !important;
                    transform: scaleY(1.5) !important;
                }
            `;
            document.head.appendChild(style);

            // Remove highlight after 3 seconds
            setTimeout(() => {
                document.querySelectorAll('.highlighted, .highlighted-line').forEach(el => {
                    el.classList.remove('highlighted', 'highlighted-line');
                });
                document.head.removeChild(style);
            }, 3000);
        });
    });

    // Smooth horizontal scrolling with arrow keys
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            e.preventDefault();
            const container = document.querySelector('.tree-timeline-container');
            const scrollAmount = 300;
            
            if (e.key === 'ArrowRight') {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            }
        }
    });

    // Auto-scroll hint for horizontal navigation
    const container = document.querySelector('.tree-timeline-container');
    let scrollHintShown = false;

    function showScrollHint() {
        if (!scrollHintShown && container.scrollWidth > container.clientWidth) {
            const hint = document.createElement('div');
            hint.innerHTML = `
                <div style="
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    background: rgba(79, 70, 229, 0.9);
                    color: white;
                    padding: 12px 20px;
                    border-radius: 25px;
                    font-size: 14px;
                    z-index: 1000;
                    animation: fadeInUp 0.5s ease;
                    backdrop-filter: blur(10px);
                    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                ">
                    <i class="fas fa-arrows-alt-h"></i> Use arrow keys or scroll horizontally →
                </div>
            `;
            document.body.appendChild(hint);
            
            setTimeout(() => {
                hint.style.opacity = '0';
                hint.style.transform = 'translateY(20px)';
                setTimeout(() => hint.remove(), 300);
            }, 4000);
            
            scrollHintShown = true;
        }
    }

    // Show hint after page loads
    setTimeout(showScrollHint, 2000);
});
</script>