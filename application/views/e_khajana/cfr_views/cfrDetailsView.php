<div id="displayBoxLB" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
    document.onreadystatechange = function(e)
    {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });    
    };
    window.onload = function(){   
        $.unblockUI();
    }
</script>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCFR/tnIndex'?>">INDEX</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">CFR-VIEW-LIST</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-danger text-center">
        <h3 class="panel-title">
            <u>
                CFR DETAILS<br>
            </u>                        
        </h3>
    </div>
    <div class="panel-heading bg-secondary text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            NOTE : DATA CAN BE ENTERED AGAIN IF ADC REJECTS A CFR RECORD
        </h6>
    </div>
    <div class="card-body">
        <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                <table id="cfr_details_view_table" class="table table-hover text-center" style="width:100%">            
                    <thead class="thead-dark">                            
                        <tr style="background-color: black; color: #fff;">
                            <td>Circle</td>
                            <td>Mouza</td>
                            <td>CFR-Book-No</td>
                            <td>No-Of-CFR-Pages</td>
                            <td>CFR-Page<br>Serial-No(Start)</td>
                            <td>CFR-Page<br>Serial-No(End)</td>
                            <td>Status</td>
                            <!-- <td>Action</td> -->
                        </tr>                                                        
                    </thead>
                    <tbody>
                        <?php foreach ($cfrDetails as $cfr_detail):?>                                    
                            <tr>
                                <td>
                                    <span class="text-dark font-weight-bold">
                                        <?= $cfr_detail->circle_name?>
                                    </span>                                     
                                </td>
                                <td>
                                    <span class="text-dark font-weight-bold">
                                        <?= $cfr_detail->mouza_name?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark font-weight-bold">
                                        <?= $cfr_detail->cfr_book_number?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark font-weight-bold font-weight-bold">
                                        <?= $cfr_detail->no_of_cfr_pages_in_the_book?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark font-weight-bold font-weight-bold">
                                        <?= $cfr_detail->cfr_page_serial_no_start?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark font-weight-bold font-weight-bold">
                                        <?= $cfr_detail->cfr_page_serial_no_end?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark font-weight-bold font-weight-bold">
                                        <?= $cfr_detail->status?>
                                    </span>
                                </td>
                                <!-- <td>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="">
                                        <i class="fa fa-edit"></i>
                                        EDIT
                                    </button>
                                </td>                                 -->
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    // land bank datatable initialisation 
$(document).ready( function () {
    $('#cfr_details_view_table').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    }); 
});
</script>
