<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">
        INSTALLMENT-PAYMENT-UPDATION
    </li>
  </ol>
</nav>

<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-secondary text-center">
        <h3 class="panel-title">
            CASE LIST OF MANUAL INSTALLMENT PAYMENT UPDATION FOR MB2 SERVICES 
        </h3>
    </div>
    <div class="panel-heading bg-warning text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            NOTE : GO TO THE DETAILS SECTION OF EACH CASES FOR UPDATION 
        </h6>
    </div>
    <div class="card-body">
        <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                <table id="installmtn_due_case_list_table" class="table table-hover text-center" style="width:100%">     
                    <thead>
                        <tr style="background: #d3d3d3!important;">
                            <th>
                                APPLICATION-NO
                            </th>
                            <th>
                                CASE-NO
                            </th>
                            <th>
                                ACTION
                            </th>
                        </tr>                        
                    </thead>                           
                    <tbody>
                        <?php foreach ($caseListForDueInstallmentPayment as $row):?>
                            <tr>
                                <td class="font-weight-bold">
                                    <?=$row->applid?>
                                </td>
                                <td class="font-weight-bold">
                                    <?=$row->case_no?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() . 'index.php/SettlementInstallmentController/installmentPaymentUpdateForm?case_no='.$row->case_no?>"
                                        class="btn btn-success btn-sm text-white" role="button" target="_insPaymentUpdateForm"
                                        style="padding: 7px !important;font-size: 12px;font-weight: bold;">
                                        <i class="fa fa-credit-card"></i>
                                        UPDATE-PAYMENT
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>    
    $(document).ready( function () {
        $('#installmtn_due_case_list_table').dataTable({
            "scrollX": true,
            "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
            "pageLength": 4,
            //"autoWidth":false,
            responsive: true
        });
    });
</script>
