
<head>
    <title>Pending Cases - Hydrocarbon Reclassification</title>
    <style>
        
/* Panel container */
.panel {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.panel-heading {
    background: #007bff;
    color: #fff;
    padding: 15px;
    font-size: 20px;
    font-weight: bold;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.panel-body {
    padding: 20px;
}

/* Pending cases table specific */
.table-pending-cases table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    font-size: 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Table headers */
.table-pending-cases th {
    background: #d6e4f5; /* medium blue-gray, stronger than #f0f4fa */
    color: #222;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 17px;
    letter-spacing: 0.4px;
    padding: 16px 14px;
}

/* Table cells */
.table-pending-cases td {
    padding: 16px 14px;
    color: #222;
    border-bottom: 1px solid #e6e9f0;
    vertical-align: middle;
    font-size: 17px;
}

/* Row striping */
.table-pending-cases tr:nth-child(even) {
    background: #f9fbff;
}
.table-pending-cases tr:nth-child(odd) {
    background: #ffffff;
}

/* Hover effect */
.table-pending-cases tr:hover {
    background: #eef5ff;
    transition: background 0.25s;
}

/* Status badge */
.table-pending-cases td span {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 14px;
    background: #e6f0ff;
    color: #0056b3;
    font-weight: 600;
    font-size: 15px !important;
}

/* View Application button */
.table-pending-cases .btn {
    padding: 10px 20px;
    background: linear-gradient(135deg, #28a745, #218838);
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.table-pending-cases .btn:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

/* Pending cases pagination */
.table-pending-cases .pagination {
    margin-top: 20px;
    text-align: center;
}

.table-pending-cases .pagination span,
.table-pending-cases .pagination a {
    display: inline-block;
    padding: 7px 14px;
    margin: 2px;
    border-radius: 6px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #007bff;
    font-size: 15px;
    transition: all 0.2s;
}

.table-pending-cases .pagination a:hover {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}

.table-pending-cases .pagination .current {
    background: #007bff;
    color: #fff;
    border: 1px solid #007bff;
    font-weight: 600;
}

/* Pending cases no-records */
.table-pending-cases .no-records {
    padding: 22px;
    text-align: center;
    color: #888;
    font-style: italic;
    font-size: 16px;
}
/* Panel container */
.panel {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.panel-heading {
    background: #007bff;
    color: #fff;
    padding: 15px;
    font-size: 20px;
    font-weight: bold;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.panel-body {
    padding: 20px;
}

/* Pending cases table specific */
.table-pending-cases table {
    border-collapse: collapse;
    width: 100%;
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    font-size: 16px; /* increased font size */
}

.table-pending-cases th,
.table-pending-cases td {
    padding: 14px 12px;
    text-align: left;
}

.table-pending-cases th {
    background: #e3e8f0; /* header background */
    font-weight: bold;
    font-size: 16px;
}

.table-pending-cases tr:nth-child(even) {
    background: #f9f9f9; /* light grey */
}

.table-pending-cases tr:nth-child(odd) {
    background: #ffffff; /* white */
}

.table-pending-cases tr:hover {
    background: #f1f7ff; /* hover effect */
}

/* Pending cases pagination */
.table-pending-cases .pagination {
    margin-top: 20px;
    text-align: center;
}

.table-pending-cases .pagination span,
.table-pending-cases .pagination a {
    display: inline-block;
    padding: 6px 12px;
    margin: 2px;
    border-radius: 4px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #007bff;
    font-size: 14px;
}

.table-pending-cases .pagination .current {
    background: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

/* Pending cases no-records */
.table-pending-cases .no-records {
    padding: 20px;
    text-align: center;
    color: #666;
    font-style: italic;
}


/* Table container */
.table-pending-cases table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Table headers */
.table-pending-cases th {
    background: linear-gradient(135deg, #007bff, #ff3600d9);
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 0.5px;
    padding: 14px 12px;
}

/* Table cells */
.table-pending-cases td {
    padding: 14px 12px;
    color: #333;
    border-bottom: 1px solid #e6e9f0;
    vertical-align: middle;
}

/* Row striping */
.table-pending-cases tr:nth-child(even) {
    background: #f8faff;
}
.table-pending-cases tr:nth-child(odd) {
    background: #ffffff;
}

/* Hover effect */
.table-pending-cases tr:hover {
    background: #eef5ff;
    transition: background 0.25s;
}

/* Status text */
.table-pending-cases td span {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    background: #e6f0ff;
    color: #0056b3;
    font-weight: 600;
    font-size: 13px;
}

/* View Application button */
.table-pending-cases .btn {
    padding: 8px 16px;
    background: linear-gradient(135deg, #28a745, #218838);
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.table-pending-cases .btn:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

    </style>
</head>
<body>

<div class="panel">
    <div class="panel-heading ">
        Pending Cases - Hydrocarbon Reclassification
    </div>
    <div class="panel-body table-pending-cases">

        <?php if (!empty($pending_cases)) : ?>
            <table>
                <tr>
                    <th>Case No</th>
                    <th>Applicant Name</th>
                    <th>Date of Application</th>
                    <th>Status</th>
                    <th style="text-align:center;">Action</th>
                </tr>
                <?php foreach ($pending_cases as $case) : ?>
                    <tr>
                        <td><?php echo $case['case_no']; ?></td>
                        <td><?php echo $case['applicant_name']; ?></td>
                        <td><?php echo $case['date_entry']; ?></td>
                        <td><span style="color:#007bff;font-weight:bold;">Partition</span></td>
                        <td style="text-align:center;">
                            <a href="<?php echo site_url('HydrocarbonReclass/viewPartition/'.urlencode(base64_encode($case['case_no']))); ?>" 
   class="btn">View Application</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="pagination">
                <?php echo $pagination; ?>
            </div>

        <?php else : ?>
            <div class="no-records">No pending cases found.</div>
        <?php endif; ?>

    </div>
</div>


<!-- Trigger button (hidden, or you can trigger via JS every 3 months) -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pendingCasesModal">
  Show Pending Cases
</button>

<!-- Modal -->
<div class="modal fade" id="pendingCasesModal" tabindex="-1" role="dialog" aria-labelledby="pendingCasesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"><!-- modal-lg for wide table -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pendingCasesModalLabel">Pending Cases (Quarterly Review)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-pending-cases">
        <table>
          <thead>
            <tr>
              
              <th>Case No</th>
              <th>Applicant Name</th>
              <th>Date</th>
              <th>Status</th>
            
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pending_cases as $case) : ?>
            <tr>
                <td><?php echo $case['case_no']; ?></td>
                <td><?php echo $case['applicant_name']; ?></td>
                <td><?php echo $case['date_entry']; ?></td>
                <td><span style="color:#007bff;font-weight:bold;">Auto-Reclassified</span></td>
                
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function showQuarterlyModal() {
        $('#pendingCasesModal').modal('show');
    }

    // Example: check date difference in localStorage
    const lastShown = localStorage.getItem('pendingCasesLastShown');
    const now = new Date().getTime();
    const threeMonths = 90 * 24 * 60 * 60 * 1000; // 90 days

    if (!lastShown || now - lastShown > threeMonths) {
      showQuarterlyModal();
      localStorage.setItem('pendingCasesLastShown', now);
    }
</script>

