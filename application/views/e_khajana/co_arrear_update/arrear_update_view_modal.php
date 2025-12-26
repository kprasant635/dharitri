<div class="modal" id="arrear_update_view_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:60%">
        <div class="modal-content">
            <form is = "mouzdar_arrear_update_form">
                <div class="modal-header text-white text-bold text-center bg-success">                
                    <h5 class="modal-title w-100">
                        <u>
                            ARREAR DETAILS                    
                        </u>                                     
                    </h5>                                       
                </div>     
                    <hr>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Mouza-Name</td>
                                    <td>
                                        <span id="arrear_update_view_modal_mouza_name" class="font-weight-bold text-primary"></span>
                                    </td>
                                    <td>Village-Name</td>
                                    <td>
                                        <span id="arrear_update_view_modal_villgae_name" class="font-weight-bold text-primary"></span>
                                    </td>                    
                                </tr>
                                <tr>
                                    <td>Patta-No</td>
                                    <td>
                                        <span id="arrear_update_view_modal_patta_no" class="font-weight-bold text-primary"></span>
                                    </td>
                                    <td>Financial-Year</td>
                                    <td>
                                        <span id="arrear_update_view_modal_financial_year" class="font-weight-bold text-primary"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Revenue-(RS)</td>
                                    <td>
                                        <span id="arrear_update_view_modal_revenue" class="font-weight-bold text-primary"></span>
                                    </td>
                                    <td>Local-Tax-(RS)</td>
                                    <td>
                                        <span id="arrear_update_view_modal_local_tax" class="font-weight-bold text-primary"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Opening-Balance-(RS)</td>
                                    <td>
                                        <span id="arrear_update_view_modal_opening_balance" class="font-weight-bold text-primary"></span>
                                    </td>
                                    <td>Due-Payment-(RS)</td>
                                    <td>
                                        <span id="arrear_update_view_modal_due_payment" class="font-weight-bold text-primary"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last-Revenue-Payment-(RS)</td>
                                    <td>
                                        <span id="arrear_update_view_modal_lrpm" class="font-weight-bold text-primary"></span>
                                    </td>
                                    <td>Last-Local-Tax-Payment-(RS):</td>
                                    <td>
                                        <span id="arrear_update_view_modal_lltpa" class="font-weight-bold text-primary"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                                                          
                    <hr>
                    <div class="row" align="center" style="padding:10px;">
                        <div class="col-lg-12" align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="arrearUpdateModalClose()">
                                <i class="glyphicon glyphicon-remove-sign"></i>
                                Close
                            </button>
                        </div>                          
                    </div>                
            </form>
        </div>
    </div>
</div>