<style>
    body{
        padding-right: 0 !important;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold">
            <a href="<?php echo base_url() . 'index.php/CPMSAdcController/getCPMSDetails'?>">
                CPMS
            </a>
        </li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">CPMS-Form</li>
    </ol>
</nav>
<div class="col-lg-12">
    <div class="panel panel-info">                
        <div class="panel-heading" style="background-color:#4d8523">
            <h3 class="panel-title text-center">REPORT OF CONSULTANT PERFORMACE MONITORING SYSTEM</h3>
        </div>
        <div class="panel-body">                        
            <table id="cpms_rpt_dt" class="table table-hover text-left" style="width:100%!important">            
                <thead class="thead-dark">                            
                    <tr>  
                        <th>SR-NO</th>                              
                        <th>FIELD-NAME</th>
                        <th>VALUE</th>
                    </tr>                                                        
                </thead>
                <tbody>                              
                    <tr class="table-light">
                        <td>1</td>
                        <td>CONSULTANT-NAME</td>
                        <td><?=$consultant_name?></td>
                    </tr>
                    <tr class="table-info">
                        <td>2</td>
                        <td>YEAR</td>
                        <td><?=$reportData->year?></td>
                    </tr>
                    <tr class="table-warning">
                        <td>3</td>
                        <td>OVERALL-PERCENTAGE</td>
                        <td><?=$reportData->overall_percentage?>%</td>
                    </tr>
                    <tr class="table-danger">
                        <td>4</td>
                        <td>GRADE</td>
                        <td><?=$reportData->grade?></td>
                    </tr>
                    <tr class="table-success">
                        <td>5</td>
                        <td>INCREMENT</td>
                        <td><?=$reportData->increment?>%</td>
                    </tr>
                    <tr class="table-secondary">
                        <td>6</td>
                        <td>ACTION</td>
                        <td><?=$reportData->action?></td>
                    </tr>
                    <tr class="table-primary font-weight-bolder">
                        <td>7</td>
                        <td>CURRENT-SALARY</td>
                        <td><?=$baseSalary?></td>
                    </tr>
                    <tr class="table-primary font-weight-bolder">
                        <td>7</td>
                        <td>REVEISED-SALARY</td>
                        <td><?=$reportData->reveised_salary?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script>
<script type="text/javascript">  
$(document).ready( function () {
    $('#cpms_rpt_dt').dataTable({
        "scrollX": true,
        //"lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        //"pageLength": 20,
        "paging": false,
        "searching" : false,
        //"autoWidth":false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download"></i> Download As Excel',
                titleAttr: 'Excel',
                title: "CPMS-REPORT",
            }, 
        ],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-info btn-sm');
            btns.removeClass('dt-button');
        }
    });
});
</script>


