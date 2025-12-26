<!-- land bank details update lm modal  -->
<div class="modal" id="lb_rejected_rmk_display_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:50%">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-danger">                
                <h5 class="modal-title w-100">
                    <u>
                        Rejected Remark <br>
                        Village :
                        <span class="text-white" id="lb_rejected_rmk_display_modal_village"></span>,                            
                        Dag-No : 
                        <span class="text-white" id="lb_rejected_rmk_display_modal_dag_no"></span>                            
                    </u>                                     
                </h5>                                       
            </div>             
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <label class="col-sm-3 uni_text control-label text-right">
                            Remark :
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>                            
                        <div class="col-sm-8 mb-3">
                            <td>
                                <textarea class="form-control" placeholder="--Revert-Remark--" rows="3" id="lb_rejected_rmk_display_modal_rmk"></textarea>
                            </td>
                        </div>
                    </div>                

                </div>                                
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="lbRejecteRmkDisplaydModalClose()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>                          
                </div>                
            </form>
        </div>
    </div>
</div>
