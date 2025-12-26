<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaReportController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Reports)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(UnRegistered Patta List)</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="unregistered_patta_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Village</td>
                                <td>Patta Type</td>
                                <td>Patta No</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($all_pattas as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->Village?>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$row->Patta_Type?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->Patta_No?>
                                        <span>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>

<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script> 

<script>
var table = $('#unregistered_patta_list').dataTable({
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
            title: "Unregistered Patta List Ekhajana ",
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

