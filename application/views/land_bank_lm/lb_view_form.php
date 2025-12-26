<!-- land bank details update lm modal  -->
<div class="modal" id="lb_lm_view_details_modal" role="dialog">
    <div class="modal-dialog" style="max-width:94%">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-secondary">                
                <h5 class="modal-title w-100">
                    <u>
                        <?php echo $this->lang->line('land_bank_header') ?> <br>
                        <?php echo $this->lang->line('mouza') ?> :
                        <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$circle_code,$mouza_code); ?>, 
                        <?php echo $this->lang->line('lot_no') ?> : 
                        <?php echo $this->utilityclass->getLotName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no); ?>, 
                        <?php echo $this->lang->line('vill_town') ?> : 
                        <span id="lb_view_village_name_modal"></span>,
                        <?php echo $this->lang->line('land_bank_location_form_year') ?> : 
                        <span id="lb_view_modal_current_year"></span><br>
                        <?php echo $this->lang->line('land_bank_table_header_dag_no'); ?> :
                        <span class="text-white" id="lb_lm_view_form_dag_no_header"></span>                            
                    </u>                                     
                </h5>                                       
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
                                <option value="">---Select Type Of Govt Land :---</option>
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
                    <div class="form-group mb-5" id="lb_lm_update_form_Is_Institute_flag_div" >
                        <label class="col-sm-5 uni_text control-label text-right">
                            Whether the dag flag for Institute:
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <div class="col-sm-4 mb-3 d-flex">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="institute_yes"
                                    name="lb_lm_update_form_Is_Institute_flag" value="Y" disabled>
                                <label class="form-check-label" for="institute_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="institute_no"
                                    name="lb_lm_update_form_Is_Institute_flag" value="N" disabled>
                                <label class="form-check-label" for="institute_no">No</label>
                            </div>
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
                        <div class="table table-responsive">
                            <table class="table table-striped table-bordered" id="lb_view_modal_enc_table">
                            <thead>
                                <tr>
                                    <td width="9%">Name</td>
                                    <td width="9%">Father's<br>Name</td>
                                    <td width="9%">Gender</td>
                                    <td width="9%">Encroached<br>From</td>
                                    <td width="8%">Encroached<br>To</td>
                                    <td width="8%">Landless Indigenous</td>
                                    <td width="8%">Landless</td>
                                    <td width="8%">caste</td>
                                    <td width="8%">Erosion<br>Affected</td> 
                                    <td width="8%">Landslide<br>Prone</td>                         
                                    <td width="10%">Type Of<br>Land Use</td>
                                    <td width="10%">Type</td>
                                    <td width="8%">Action</td>
                                </tr>
                            </thead>
                            <tbody id="lb_view_modal_text_box_container"></tbody>
                            </table>
                        </div>
                    </div>
                </div>                                
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="lbViewModalClose()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>                          
                </div>                
            </form>
        </div>
    </div>
</div>
