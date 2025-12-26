
<style>
    .rank-cell {
        background-color: black;
        color: white;
        font-weight: bold;
    }

    .container {
        max-width: 95%;
        margin: auto;
    }

    .section-box {
        background: #ffffff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        border-left: 5px solid #007bff;
    }
    .section-title {
        background: linear-gradient(268deg, rgb(42 1 249) 0%, rgb(0, 0, 0) 50%, rgb(255 0 0) 100%);
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .box_color {
        background: linear-gradient(0deg, rgb(95 195 34) 0%, rgb(2 36 14) 100%);
        border-radius: 10px;
        height: 40px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        margin: 10px;
        box-shadow: 0px 4px 10px rgba(17, 114, 88, 0.82);
    }
</style>

<div class="container mb-5 mt-5 section-box" style="width: 95%; margin: 0 auto;">
    <div class="section-title shadow-lg mb-3">
        <?php 
            $dist_name = $this->utilityclass->getDistrictName($reconcil_details->mouza_wise_details[0]->dist_code);
        ?>
        <h5 style="text-align:center">Mouza Wise Reconciliation Dashboard For Distrct <?=$dist_name?></h5>
    </div>
    <!-- e-Khazana Reconciliation Summary -->
    <div class="section-box mt-3">
        <div class="section-title"><i class="fas fa-file-invoice-dollar me-2"></i> e-Khazana Reconciliation Summary</div>
        <div class="row">
            <div class="col-lg-6">
                <div class="box_color">
                    <i class="fas fa-check-circle me-2"></i> Total Offline CFR Pages Settled (Till Now): <kbd><?=$reconcil_details->total_no_of_offline_cfr_pages_settled?></kbd>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box_color">
                    <i class="fas fa-wallet me-2"></i> Total Amount Received: <kbd><?=$reconcil_details->total_amount_received_from_offline_cfr_payments?></kbd>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="box_color">
                    <i class="fas fa-book me-2"></i> Total No Of Manual CFR Books Issued <kbd><?=$reconcil_details->total_no_of_offline_cfr_books?></kbd>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box_color">
                    <i class="fas fa-file-alt me-2"></i> Total No Of Manual CFR Pages <kbd><?=$reconcil_details->total_no_of_offline_cfr_pages?></kbd>
                </div>
            </div>
        </div>
        <?php $total_left_to_settle = $reconcil_details->total_no_of_offline_cfr_pages - $reconcil_details->total_no_of_offline_cfr_pages_settled; ?>
        <div class="col-lg-6 offset-3 mt-4">
            <div class="box_color text-white">
                <i class="fas fa-exclamation-triangle me-2"></i> Total No Of Manual CFR's left (To Be Settled) <kbd><?=$total_left_to_settle?></kbd>
            </div>
        </div>
    </div>

    <table class="table table-bordered" style="border-color:black; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);" id="mouza_wise_details">
        <thead>
            <tr class="text-white" style="background: linear-gradient(to right, rgb(0 255 45), #ff0000);">
                <th scope="col" class="text-center">Rank</th> <!-- Rank Column -->
                <th scope="col" class="text-center">Mouza</th>
                <th scope="col" class="text-center">Books Issued</th>
                <th scope="col" class="text-center">Pages Issued</th>
                <th scope="col" class="text-center">Pages Settled</th>
                <th scope="col" class="text-center">Amount Received</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Create an array to hold pages settled and their respective mouza names
            $mouza_data = [];
            foreach ($reconcil_details->mouza_wise_details as $row) {
                $mouza_data[] = [
                    'mouza_name' => $row->mouza_name,
                    'total_no_of_cfr_books_issued' => $row->total_no_of_cfr_books_issued,
                    'total_no_of_cfr_pages_issued' => $row->total_no_of_cfr_pages_issued,
                    'total_no_of_offline_cfr_pages_settled' => $row->total_no_of_offline_cfr_pages_settled,
                    'total_amount_received_from_offline_cfr_payments' => $row->total_amount_received_from_offline_cfr_payments,
                ];
            }

            // Sort mouzas based on Pages Settled (descending)
            usort($mouza_data, function($a, $b) {
                return $b['total_no_of_offline_cfr_pages_settled'] <=> $a['total_no_of_offline_cfr_pages_settled'];
            });

            // Initialize rank and handle ties (same rank for 0 pages settled)
            $rank = 1;
            $previous_pages = -1; // For tie handling (especially for 0 pages settled)
            ?>
            
            <?php foreach ($mouza_data as $row): 
                $row_class = ($row['total_no_of_offline_cfr_pages_settled'] == 0) ? 'table-danger text-danger fw-bold' : ''; 

                // Determine rank
                if ($row['total_no_of_offline_cfr_pages_settled'] !== $previous_pages) {
                    // If current pages settled is different from previous, increment rank
                    $mouza_rank = $rank;
                    $previous_pages = $row['total_no_of_offline_cfr_pages_settled'];
                    $rank++; // Increment rank for the next mouza
                } else {
                    // Same rank for mouzas with the same pages settled
                    $mouza_rank = $rank - 1; // Same rank as previous mouza
                }
            ?>
                <tr class="text-center <?=$row_class?>">
                    <td class="rank-cell" style="background-color:black!important;border:1px solid white;"><?=$mouza_rank?></td> <!-- Rank with Style -->
                    <td class="<?=$row_class?>"><?=$row['mouza_name']?></td>
                    <td><?=$row['total_no_of_cfr_books_issued']?></td>
                    <td><?=$row['total_no_of_cfr_pages_issued']?></td>
                    
                    <?php if($row['total_no_of_offline_cfr_pages_settled'] == 0): ?>
                        <td class="text-black" style="background-color:#f57880">
                            <?=$row['total_no_of_offline_cfr_pages_settled']?>
                        </td>
                    <?php else: ?>
                        <td class="text-black">
                            <?=$row['total_no_of_offline_cfr_pages_settled']?>
                        </td>
                    <?php endif; ?>
                    
                    <td class="text-black">
                        <?=$row['total_amount_received_from_offline_cfr_payments']?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script> 
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_report.js"></script>




