<!-- land bank details update lm modal  -->
<div class="modal" id="lb_co_remarks_form" role="dialog" >
    <div class="modal-dialog" style="max-width:55%">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-secondary">                
                <h5 class="modal-title w-100">
                    <u>
                        Land Bank Details For -                                                      
                        <?php echo $this->lang->line('vill_town') ?> : 
                        <span id="lb_view_village_name_modal_dc"></span>,
                        <?php echo $this->lang->line('land_bank_table_header_dag_no'); ?> :
                        <span id="lb_lm_view_form_dag_no_header_dc"></span>                            
                    </u>                                     
                </h5>                                       
            </div>             
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Officer</td>
                                <td>Remark Date</td>
                                <td>Remarks</td>
                            </tr>
                            <tr>
                                <td>Circle Officer</td>
                                <td><span id="co_remarks_date"></span></td>
                                <td><span id="co_remarks"></span></td>
                            </tr>
                        </thead>
                        
                    </table>
                                   
                  
                   
                </div>                                
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="lbCORemarksModalClose()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>                          
                </div>                
            </form>
        </div>
    </div>
</div>
