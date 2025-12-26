<style type="text/css">
  .card-body{  background: #7b4397; /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #7b4397, #dc2430); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #7b4397, #dc2430); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */);}
  #circle {
    background: #0f546a;
    border-radius: 30%;
    padding: 7px !important;
    font-weight: bold;
    font-size: 2em;
    }
    .btn-success:hover{
        background-color:#086320;
        border-color:#086320;
    }
</style>
<div>
<div class="container-fluid mb-5">
    <!-- total payments calculations -->
    <div class="col-lg-12 mt-3 mb-3" style="border:3px solid #96907e; border-radius:5px">
        <div class="text-warning bg-dark p-1 shadow-lg col-lg-12 text-center" 
        style="border:3px solid #96907e; border-radius:5px;background: linear-gradient(268deg, rgb(119 255 0) 0%, rgb(0 0 0) 50%, rgb(0 102 255) 100%);">
            <h6>e-CFR Summary</h6>
        </div>
        <div class="row ">
            <div class="col-lg-6">
                <div class="card">
                    <div class=" card-body text-white">
                        <i class="fa fa-calculator"></i> Total No Of e-CFR Generated <kbd id=''>Rs <?=$ecfr_details->total_ecfr_generated_count?></kbd>   
                    </div>                    
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-white">
                        <i class="fa fa-calculator"></i> Total No Of e-CFR Generated Mouza <kbd id=''>Rs <?=$ecfr_details->total_no_of_mouza?></kbd>   
                    </div> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-white">                
                        <i class="fa fa-inr" aria-hidden="true"></i> Total Amount Received From e-CFR <kbd id=''>Rs <?=$ecfr_details->total_ecfr_amount?></kbd>  
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-white">
                        <i class="fa fa-inr" aria-hidden="true"></i> Total Digital Amount Received From e-CFR <kbd id=''><?=$ecfr_details->digital_payment_amount?></kbd>  
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin-bottom:2px;margin-top:2px;">
        <div class="col-lg-12 mb-3 mt-3">
            <div class="row">
                <div class="col-2" ></div>
               
                <div class="col-8 text-white p-1 font-weight-bold shadow-lg mb-2" style="text-align:center;background: linear-gradient(268deg, rgb(163 163 163) 0%, rgb(0 0 0) 50%, rgb(0 220 255) 100%);">
                    <i class="fa fa-inr" aria-hidden="true"></i> Total Cash In Hand With Mouzadars : <?=$ecfr_details->total_ecfr_amount - $ecfr_details->digital_payment_amount?>
                    
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-5 mt-5">
    <div class="container bg-dark text-white p-1 shadow-lg ">
        <h5 style="text-align:center">Mouza Wise e-CFR Breakdown</h5>
    </div>
    <table class="table table-hover table-bordered" style="border-color:black" id="mouz_dist_wise_table">
        <thead>
        <tr style="background-color:#b67eff;">
            <th scope="col" class="text-center">District</th>
            <th scope="col" class="text-center">Circle</th>
            <th scope="col" class="text-center">Mouza</th>
            <th scope="col" class="text-center">No Of e-CFR Genereted</th>
            <th scope="col" class="text-center">Total Amount From e-CFR</th>
            <th scope="col" class="text-center">Total Digital Amount From e-CFR</th>        
            <th scope="col" class="text-center">Total Cash In Hand</th>      
        </tr>
        </thead>
        <tbody>    
            <?php foreach ($ecfr_details->ecfr_data as $row):?>
                <tr class="text-center">
                    <td class=" text-black">
                        <?=$row->district?>
                    </td>
                    <td class=" text-black">
                        <?=$row->circle?>
                    </td>
                    <td class=" text-black">
                        <?=$row->mouza?>
                    </td>
                    <td class=" text-black">
                        <?=$row->generated_ecfr_count?>
                    </td>
                    <td class=" text-black">
                        <?=$row->total_ecfr_amount?>
                    </td>
                    <td class=" text-black">
                        <?=$row->digital_payment_received?>
                    </td>
                    <td class=" text-black">
                        <?=$row->total_ecfr_amount - $row->digital_payment_received?>
                    </td>
                </tr>
            <?php endforeach; ?> 
        </tbody>
    </table>
    </div>
</div>
<link href="<?=base_url();?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/js/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.html5.min.js"></script>

<script>
    $('#mouz_dist_wise_table').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
</script>

