<!-- land bank details update lm modal  -->
<div class="modal" id="lb_dc_view_details_modal" role="dialog">
    <div class="modal-dialog" style="max-width:94%">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-secondary">                
                <h5 class="modal-title w-100">
                    <u>
                        Land Bank Details For -                                                      
                        <?php echo $this->lang->line('vill_town') ?> : 
                        <span id="lb_view_village_name_modal"></span>,
                        <?php echo $this->lang->line('land_bank_location_form_year') ?> : 
                        <span id="lb_view_modal_current_year"></span>,  
                        <?php echo $this->lang->line('land_bank_table_header_dag_no'); ?> :
                        <span class="text-white" id="lb_lm_view_form_dag_no_header"></span>                            
                    </u>                                     
                </h5>  

                <button type="button" class="btn btn-sm btn-danger" onclick="lbViewModalCloseByDC()">
                    <i class="glyphicon glyphicon-remove-sign"></i>
                    Close
                </button>                                
            </div>             
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <label class="col-sm-5 uni_text control-label text-right">
                            Type Of Govt Land : 
                            <!-- NOTE: NAME CHANGE FROM NATURE OF RESERVATION TO TYPE OF GOVT LAND -->
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <div class="col-sm-4 mb-3">
                            <select class="form-control" id="lb_view_modal_nature_of_reservation" disabled>
                                <option value="">---Select Type Of Govt Land---</option>
                                <?php foreach (json_decode(LB_NATURE_OF_RESERVATION) as $nor):?>
                                    <option value="<?=$nor->CODE?>"><?=$nor->NAME?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>                
                    <div class="form-group mb-5">
                        <label class="col-sm-5 uni_text control-label text-right">
                            Whether Encroached : 
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <div class="col-sm-4 mb-3">
                            <select class="form-control" id="lb_view_modal_whether_encroached" disabled>
                                <option value="">---Select Whether Encroached---</option>
                                <option value = "Y">Yes</option>
                                <option value = "N">No</option>
                                <option value = "I">Institution</option>
                            </select>
                        </div>
                    </div>
                    <div id="lb_view_modal_area_insert_div" style="display: none">  
                        <?php if ($dist_code != '21'): ?>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Bigha :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_b" type="text" placeholder="---Bigha---" class="form-control" disabled></input>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Katha :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_k" type="text" placeholder="---Katha---" class="form-control" disabled></input>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Lessa :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_l" type="text" placeholder="---Lessa---" class="form-control" disabled></input>
                                </div>
                            </div>
                        <!-- for dist code 21 -->
                        <!-- <?php elseif ($$dist_code === '21'): ?>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Bigha :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_b" type="text" placeholder="---Bigha---" class="form-control" disbled></input>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Katha :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_k" type="text" placeholder="---Katha---" class="form-control" disbled></input>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Lessa :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_l" type="text" placeholder="---Lessa---" class="form-control" disbled></input>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Gonda :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_g" type="text" placeholder="---Bigha---" class="form-control" disbled></input>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label class="col-sm-5 uni_text control-label text-right">
                                    (Encroach-Area)-Kranti :  
                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                </label>
                                <div class="col-sm-4 mb-3">
                                    <input id="lb_view_modal_en_area_kr" type="text" placeholder="---Bigha---" class="form-control" disbled></input>
                                </div>
                            </div>
                        <?php endif; ?>     -->
                        <!-- for dist code 21 -->
                    </div>       
                    <div class="form-group mb-5">
                        <label class="col-sm-5 uni_text control-label text-right">
                            Longitude :
                            <span style="color:red;font-weight:bold; font-size: 25px;"></span>
                        </label>                            
                        <div class="col-sm-4 mb-3">
                            <td><input placeholder = "---Longitude---" id="lb_view_modal_longitude" value = "" class="form-control" disabled/></td>
                        </div>
                    </div>
                    <div class="form-group mb-5">
                        <label class="col-sm-5 uni_text control-label text-right">
                            Latitude :
                            <span style="color:red;font-weight:bold; font-size: 25px;"></span>
                        </label>                            
                        <div class="col-sm-4 mb-3">
                            <td><input placeholder = "---Latitude---" id="lb_view_modal_latitude" type="text" value = "" class="form-control" disabled/></td>
                        </div>
                    </div>
                    
                    <div class="form-group col-lg-12 col-sm-12 col-md-12">
                        <div class="text-center bg-secondary text-white p-1">
                            <h5 class="mb-0">Encroacher details</h5>
                        </div>
                        <b style="color:red">Note : For remove/delete registered encroacher kindly select checkbox against encroacher. otherwise appoved through approved button below. </b>
                        <div class="table table-responsive" style="max-height: 32rem;">
                            <table class="table table-striped table-bordered" id="lb_view_modal_enc_table">
                            <thead> 
                                <tr>
                                    <th width="2%">Delete</th>
                                    <th width="15%">Name</th>
                                    <th width="15%">Father's<br>Name</th>
                                    <th width="8%">Gender</th>
                                    <th width="8%">Encroached<br>From</th>
                                    <th width="8%">Encroached<br>To</th>
                                    <th width="5%">Landless Indigenous</th>
                                    <th width="5%">Landless</th>
                                    <th width="7%">caste</th>
                                    <th width="7%">Erosion<br>Affected</th> 
                                    <th width="7%">Landslide<br>Prone</th>                   
                                    <th width="9%">Type Of<br>Land Use</th>
                                    <th width="8%">Type</th>
                                    <!-- <th width="8%">Action</th> -->
                                </tr>
                            </thead>
                            <tbody id="lb_view_modal_text_box_container"></tbody>
                            </table>
                        </div>


                    </div>
                    <!-- <form id="lb_approve_rmk_form_dc">
                        <div class="form-group mb-5">
                            <label class="col-sm-2 uni_text control-label text-right">
                                Approval Remark :
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>                            
                            <div id="approved" class="col-sm-10 mb-3">
                                <td>
                                    <input type="hidden" name="encroacher_id_dc" id="encroacher_id_dc">
                                    <textarea class="form-control" placeholder="--Approval-Remark--" rows="3" name="lb_approve_rmk" id="lb_approve_rmk"></textarea>
                                </td>
                            </div>
                        </div> 
                        <div class="form-group mb-5 deletion_remark_dc" style="display:none">
                            <label class="col-sm-2 uni_text control-label text-right">
                                Deletion Remark :
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>                            
                            <div id="deleted" class="col-sm-4 mb-3">
                                <td>
                                    <textarea class="form-control" placeholder="--Deletion-Remark--" rows="2" name="lb_delete_rmk_dc" id="lb_delete_rmk_dc"></textarea>
                                </td>
                            </div>
                        </div> 
                        <input type="hidden" id="lb_approve_rmk_lb_details_id" name="lb_approve_rmk_lb_details_id">
                    </form> -->
                    <!-- validation-errors-div -->
                    <!-- <div class="col-lg-12" id="lb_approval_rmk_form_validation_error_div" style="display:none;">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong class="text-center" style="color:red !important"
                                id="lb_approval_rmk_form_validation_error_msg">
                            </strong>
                        </div>
                    </div> -->
                    <!-- validation-error-div-end -->                           
                    <hr>
                    <div class="row" align="center" style="padding:10px;">
                        <div class="col-lg-12" align="center">
                            <!-- <button type="button" class="btn btn-sm btn-success" onclick="lbApproveFormSubmitDC()">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                    Final Approved
                            </button> -->
                            <!-- <button type="button" class="btn btn-sm btn-danger" onclick="lbApproveModalCloseDC()">
                                <i class="glyphicon glyphicon-remove-sign"></i>
                                    Close
                            </button> -->
                        </div>                          
                    </div> 
                </div>                                
                <hr>
                                
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
       
    });
    function checkboxes(){
        var inputs = document.getElementsByName('delete_enc_dc[]');
        var inputObj;
        var encIdArray = [];
        var selectedCount = 0;
            for(var count1 = 0;count1<inputs.length;count1++) {
                inputObj = inputs[count1];
                var type = inputObj.getAttribute("type");
                if (type == 'checkbox' && inputObj.checked) {
                    selectedCount++;
                    if(inputs.length == selectedCount){
                        alert('Minimum encroacher should be one...');
                        document.getElementById("delete_enc_dc"+[count1]).checked = false;
                        selectedCount--;
                    }else{
                        encIdArray.push(inputs[count1].value);
                    }
                }
            }
        if(selectedCount>=1){
            //for selecting more than one encraocher deletion remark enabled--------
            $(".deletion_remark_dc").show();
            $("#encroacher_id_dc").val(encIdArray);
            $( "#approved" ).removeClass( "col-sm-10" ).addClass( "col-sm-4" );
        }else{
            $("#lb_delete_rmk_dc").val('');
            $(".deletion_remark_dc").hide();
            $("#encroacher_id_dc").val('');
            $( "#approved" ).removeClass( "col-sm-4" ).addClass( "col-sm-10" );
        }
    }
</script>
