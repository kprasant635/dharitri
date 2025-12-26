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
    .th .td {
        width:100%;
    }
</style>
<div>
<div class="container mb-5 mt-5 table-responsive">
    <div class="container bg-dark text-white p-1 shadow-lg ">
        <h5 style="text-align:center">Mouza Wise e-Khajana Breakdown</h5>
    </div>
    <table class="table table-bordered" id="mouz_dist_wise_table">
        <thead>
            <tr>
            <th scope="col" style="width:50%">District</th>
            <th scope="col" style="width:50%">Circle</th>
            <th scope="col" style="width:50%">Mouza</th>
            <th scope="col" style="width:50%">Total Doul Demand</th>
            <th scope="col" style="width:50%">Total Patta</th>
            <th scope="col" style="width:50%">Total Application Received</th>
            <th scope="col" style="width:50%">Pending At LM</th>
            <th scope="col" style="width:50%">Pending At Mouzadar</th>
            <th scope="col" style="width:50%">Pending At Circle Officer</th>
            <th scope="col" style="width:50%">Rejected Application</th>
            <th scope="col" style="width:50%">Disposed</th>
            <th scope="col" style="width:50%">Pending for payment(Citizen)</th>
            <th scope="col" style="width:50%">Total No of Patta Paid</th>
            <th scope="col" style="width:50%">Total Amount received</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mouzadari_details as $row):?>
                <tr class="text-center">
                    <td scope="col" class=" text-black">
                        <?=$row->district?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->circle?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->mouza?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->doul_demand?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->total_patta?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->application_received?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->pending_at_lm?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->pending_at_mouzadar?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->pending_at_co?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->rejected_count?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->disposed?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->disposed - $row->no_of_patta_payments?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->no_of_patta_payments?>
                    </td>
                    <td scope="col" class=" text-black">
                        <?=$row->amount_received?>
                    </td>
                </tr>
            <?php endforeach; ?> 
        </tbody>
    </table>
</div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_adc.js"></script>
<link href="<?=base_url();?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/js/datatables/jquery.dataTables.min.js'); ?>"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.html5.min.js"></script> -->


<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script> 
<script>
var table = $('#mouz_dist_wise_table').dataTable({
    "scrollX": true,
    "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
    "pageLength": 8,
    "autoWidth":false,
    //responsive: true,
    "scrollX": true,
    "sScrollXInner": "100%",
    dom: 'Bfrtip',
    buttons: [
        {
            extend:    'excelHtml5',
            text:      '<i class="fa fa-download text-white"></i> <span class="text-white">Download As Excel</span>',
            titleAttr: 'Excel',
            title: "Mouzadari Report ",
        }, 
    ],
    initComplete: function () {
        var btns = $('.dt-button');
        btns.addClass('btn btn-success btn-sm');
        btns.removeClass('dt-button');
    }
});
table.columns.adjust().draw();
</script>


