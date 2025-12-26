 <!-- land bank details update lm modal  -->
<div class="modal align-middle" id="lb_revert_modal_dc" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:50%">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-danger">                
                <h5 class="modal-title w-100">
                    <u>
                        Revert Remark Of Land Bank Details <br>                                               
                        <?php echo $this->lang->line('vill_town') ?> : 
                        <span id="lb_revert_modal_village_name"></span>,
                        <?php echo $this->lang->line('land_bank_table_header_dag_no')?> :
                        <span class="text-white" id="lb_revert_modal_dag_no"></span>
                    </u>                                     
                </h5>                                       
            </div>             
                <div class="modal-body">      
                    <form id="lb_revert_rmk_form_dc">
                        <div class="form-group mb-5">
                            <label class="col-sm-3 uni_text control-label text-right">
                                Remark :
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>                            
                            <div class="col-sm-8 mb-3">
                                <td>
                                    <textarea class="form-control" placeholder="--Revert-Remark--" rows="3" name="lb_revert_rmk" id="lb_revert_rmk"></textarea>
                                </td>
                            </div>
                        </div>  
                        <input type="hidden" id="lb_revert_rmk_lb_details_id" name="lb_revert_rmk_lb_details_id">
                    </form>                                                    
                </div>     
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="lb_revert_rmk_form_validation_error_div" style="display:none;">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="lb_revert_rmk_form_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->                           
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-success" onclick="lbRevertFormSubmitByDC()">
                            <i class="fa fa-check" aria-hidden="true"></i>
                                Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="lbRevertModalCloseByDC()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                                Close
                        </button>
                    </div>                          
                </div>                
            </form>
        </div>
    </div>
</div>