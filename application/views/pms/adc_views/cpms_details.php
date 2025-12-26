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
        <div class="panel-heading" style="background-color:#632385">
            <h3 class="panel-title text-center">CONSULTANT PERFORMACE MONITORING SYSTEM</h3>
        </div>
        <div class="panel-body">            
            <table class="table table-bordered" id="datatable">
                <tr style="background-color: #fff0a4;">
                    <th>CONSULTANT-NAME</th>
                    <th>TOTAL-CONSULTANT-FORMS</th>
                    <th>NO-OF-FORMS-FILLED</th> 
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
                <tr style="background-color: #ffffff;font-weight:bold; font-size: 16px;">
                    <td><?=$consultant_name?></td>
                    <td>10</td>
                    <td><?=$no_of_forms_completed?></td> 
                    <td><?=$status?></td>
                    <?php if($status == "PENDING-FOR-APPROVAL"): ?>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/CPMSAdcController/evaluate'?>"
                                class="btn btn-success btn-sm text-white" role="button" 
                                style="font-weight: bold;">
                                <i class="fa fa-check" aria-hidden="true"></i> EVALUATE
                            </a>
                        </td>
                    <?php elseif($status == "EVALUATION-COMPLETED") :?>  
                        <td>
                            <a href="<?php echo base_url() . 'index.php/CPMSAdcController/getCPMSreport/'.$year?>"                        
                                class="btn btn-danger btn-sm text-white" role="button" target="_blank"
                                style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                VIEW-REPORT
                            </a>
                        </td>
                    <?php else:?>  
                        <td>
                            <button class="btn btn-secondary btn-sm" disabled><i class="fa fa-check" aria-hidden="true"></i> EVALUATE</button>
                        </td>
                    <?php endif ?> 
                </tr>
            </table>
        </div>
    </div>
</div>







