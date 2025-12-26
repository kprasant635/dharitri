<!-- land bank details update lm modal  -->
<div class="modal" id="lb_lm_update_details_modal" role="dialog">
    <form method="post" id="lb_lm_update_details_form" enctype='multipart/form-data'>
        <input type="hidden" value="<?=$dist_code?>" name="dist_code">
        <input type="hidden" value="<?=$subdiv_code?>" name="subdiv_code">
        <input type="hidden" value="<?=$circle_code?>" name="circle_code">
        <input type="hidden" value="<?=$mouza_code?>" name="mouza_code">
        <input type="hidden" value="<?=$lot_no?>" name="lot_no">
        <input type="hidden" value="<?=$vill_code?>" name="vill_code">
        <input type="hidden" value="" id="lb_lm_update_form_dag_no" name="lb_lm_update_form_dag_no">
        <input type="hidden" value="" id="lb_lm_update_details_form_no_of_encroacher" name="lb_lm_update_details_form_no_of_encroacher">
        <input type="hidden" value="" id="lb_lm_update_form_prev_data_exists_flag" name="lb_lm_update_form_prev_data_exists_flag">
        <div class="modal-dialog" style="max-width:94%">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-info">                
                    <h5 class="modal-title w-100">
                        <u>
                            <?php echo $this->lang->line('land_bank_header') ?> -
                            <?php echo $this->lang->line('land_bank_add_details_modal_header'); ?><br>                                                       
                            <?php echo $this->lang->line('mouza') ?> :
                            <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$circle_code,$mouza_code); ?>, 
                            <?php echo $this->lang->line('lot_no') ?> : 
                            <?php echo $this->utilityclass->getLotName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no); ?>, 
                            <?php echo $this->lang->line('vill_town') ?> : 
                            <?php echo $this->utilityclass->getVillageName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code); ?>, 
                            <?php echo $this->lang->line('land_bank_table_header_dag_no'); ?> :
                            <span class="text-white" id="lb_lm_update_form_dag_no_header"></span>                            
                        </u>                                     
                    </h5>                                       
                </div>             
                    <div class="modal-body" style="padding:0px">                        
                        <div class="modal-header text-center p-1 bg-dark text-danger" 
                        id="enc_excel_file_msg_div" style="display:none;">  
                            <h6 class="modal-title w-100 text-danger mb-1 font-weight-bolder text-uppercase" id="enc_excel_file_msg_text">
                            </h6>
                        </div>
                        <div class="modal-header text-center mb-3 p-0">  
                            <h6 class="modal-title w-100 text-danger mb-1">
                                <u><strong>NOTE:</strong>  Fileds marks with (*) are mandatory</u>
                            </h6>
                        </div>                        
                        <div class="form-group mb-5">
                            <label class="col-sm-5 uni_text control-label text-right">
                                Type Of Govt Land : 
                                <!-- NOTE: NAME CHANGE FROM NATURE OF RESERVATION TO TYPE OF GOVT LAND -->
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>
                            <div class="col-sm-4 mb-3">
                                <select class="form-control" name="lb_lm_update_nature_of_reservation" id="lb_lm_update_nature_of_reservation">
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
                                <select class="form-control" id="lb_lm_update_form_area_select_id" name="lb_lm_update_form_whether_encroached">
                                    <option value="">---Select Whether Encroached---</option>
                                    <option value = "Y">Yes</option>
                                    <option value = "N">No</option>
                                    <!-- <option value = "I">Institution</option> -->
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-5" id="lb_lm_update_form_Is_Institute_flag_div">
                            <label class="col-sm-5 uni_text control-label text-right">
                                Whether the dag flag for Institute:
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>
                            <div class="col-sm-4 mb-3 d-flex">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="institute_yes"
                                        name="lb_lm_update_form_Is_Institute_flag" value="Y">
                                    <label class="form-check-label" for="institute_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="institute_no"
                                        name="lb_lm_update_form_Is_Institute_flag" value="N">
                                    <label class="form-check-label" for="institute_no">No</label>
                                </div>
                            </div>
                        </div>

                        
                        <div id="lb_lm_update_form_area_insert_div" style="display: none">  
                            <?php if ($dist_code != '21'): ?>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Bigha :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_b" name='lb_lm_update_form_en_area_b' type="text" placeholder="---Bigha---" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Katha :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_k" name='lb_lm_update_form_en_area_k' type="text" placeholder="---Katha---" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Lessa :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_l" name='lb_lm_update_form_en_area_l' type="text" placeholder="---Lessa---" class="form-control"></input>
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
                                        <input id="lb_lm_update_form_en_area_b" name='lb_lm_update_form_en_area_b' type="text" placeholder="---Bigha---" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Katha :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_k" name='lb_lm_update_form_en_area_k' type="text" placeholder="---Katha---" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Lessa :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_l" name='lb_lm_update_form_en_area_l' type="text" placeholder="---Lessa---" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Gonda :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_g" name='lb_lm_update_form_en_area_g' type="text" placeholder="---Bigha---" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-sm-5 uni_text control-label text-right">
                                        (Encroach-Area)-Kranti :  
                                        <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                    </label>
                                    <div class="col-sm-4 mb-3">
                                        <input id="lb_lm_update_form_en_area_kr" name='lb_lm_update_form_en_area_kr' type="text" placeholder="---Bigha---" class="form-control"></input>
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
                                <td><input placeholder = "---Longitude---" id="lb_lm_update_form_longitude" name="lb_lm_update_form_longitude" type="text" value = "" class="form-control"/></td>
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <label class="col-sm-5 uni_text control-label text-right">
                                Latitude :
                                <span style="color:red;font-weight:bold; font-size: 25px;"></span>
                            </label>                            
                            <div class="col-sm-4 mb-3">
                                <td><input placeholder = "---Latitude---" id="lb_lm_update_form_latitude" name="lb_lm_update_form_latitude" type="text" value = "" class="form-control"/></td>
                            </div>
                        </div>
                        <input type="hidden" name="lb_lm_update_form_existing_year" id="lb_lm_update_form_existing_year">
                        <input type="hidden" name="lb_lm_update_form_last_approval_time" id="lb_lm_update_form_last_approval_time">                        
                        <!-- bulk uploading of encroacher list -->
                        <div class="form-group mb-5">
                            <label class="col-sm-5 uni_text control-label text-right text-primary">
                                Upload Encroacher's With File :
                                <span style="color:red;font-weight:bold; font-size: 25px;"></span>
                            </label>                            
                            <div class="col-sm-4 mb-3">
                                <td><input id="encoracher_list_file" name="encoracher_list_file" type="file" value = "" class="form-control" disabled/></td>
                            </div>
                        </div>
                        <!-- No of encroacher in encroacher list -->
                        <div class="form-group mb-5">
                            <label class="col-sm-5 uni_text control-label text-right text-primary">
                                No Of Encroacher In Excel File :
                                <span style="color:red;font-weight:bold; font-size: 25px;"></span>
                            </label>                            
                            <div class="col-sm-4 mb-3">
                                <td><input placeholder = "---No-Of-Encraocher-In-Excel-File---" id="no_of_encoracher_in_file" name="no_of_encoracher_in_file" type="number" value = "" class="form-control" disabled min="1" max="5999"/></td>
                            </div>
                        </div>
                        <!-- bulk uploading of encroacher list -->
                        <div class="form-group col-lg-12 col-sm-12 col-md-12">
                            <div class="text-center bg-secondary text-white p-1">
                                <h5 class="mb-0">Encroacher details</h5>
                            </div>
                            <div class="table table-responsive" style="padding: 0px;overflow: auto; height: 300px;"> 
                            <!-- <div class="table table-responsive"> -->
                                <table class="table table-striped table-bordered" id="lb_lm_update_details_form_enc_table">
                                <thead>
                                    <tr style="position: sticky; top:0; z-index:10;"> 
                                    <!-- <tr> -->
                                        <td width="15%">Name</td>
                                        <td width="15%">Father's<br>Name</td>
                                        <td width="8%">Gender</td>
                                        <td width="8%">Encroached<br>From</td>
                                        <td width="8%">Encroached<br>To</td>
                                        <td width="5%">Landless Indigenous</td>
                                        <td width="5%">Landless</td>
                                        <td width="7%">caste</td>
                                        <td width="7%">Erosion<br>Affected</td> 
                                        <td width="7%">Landslide<br>Prone</td>                   
                                        <td width="9%">Type Of<br>Land Use</td>
                                        <td width="8%">Type</td>
                                        <td width="8%">Action</td>
                                    </tr>
                                </thead>
                                <tbody id="lb_lm_update_form_text_box_container"></tbody>
                                <tfoot>
                                    <tr>
                                    <th colspan="13" class="text-center">
                                        <button id="lbLmUpdateFormEncAddbtn" disabled type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add more controls"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp; Add Encroacher's Details&nbsp;</button>
                                    </th>
                                    </tr>
                                </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- validation-errors-div -->
                        <div class="col-lg-12" id="lb_lm_update_form_validation_error_div" style="display:none;">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <strong class="text-center" style="color:red !important"
                                    id="lb_lm_update_form_validation_error_msg">
                                </strong>
                            </div>
                        </div>
                        <!-- validation-error-div-end -->
                    </div>                                
                    <hr>
                    <div class="row" align="center" style="padding:10px;">
                        <div class="col-lg-12" align="center">
                            <button type="button" class="btn btn-sm btn-success" onclick="lbLmUpdateFormSubmit()" 
                                id="lb_lm_update_form_submit_button">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Submit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="lbLmUpdateModalClose()">
                                <i class="glyphicon glyphicon-remove-sign"></i>
                                Close
                            </button>
                        </div>                          
                    </div>                
                </form>
            </div>
        </div>
    </form>
</div>
