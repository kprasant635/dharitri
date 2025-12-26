<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">

            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Village -Wise Tenant List</h2>
                </div>

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('select_location'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p class="red bold">Note: This process is entering data directly into the Chitha. Please make sure your are entering the correct data.You  are responsible for this entry.</p>
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/MisReport/back_step_one"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouza as $moz): ?>
                                            <?php
                                            $mouza_code = $moz->mouza_pargona_code;
                                            $mouza_name = $moz->loc_name;
                                            ?>
                                            <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected>Select Lot No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>

                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control villageselect" placeholder="Enter Dag Number"  required name="dag_no" />
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control villageselect" placeholder="Enter Patta Number"  required name="patta_no" />
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-2">
                                 <select class="form-control"  required name="patta_type">
                                    <?php
                                  foreach($pattatype as $p){
                                    ?>
                                       <option  value="<?php echo $p->type_code;?>"><?php echo $p->patta_type;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                 <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control villageselect" placeholder="Enter Case Number"  required name="case_no" />
                                </div>
                                 <label class="col-lg-2 control-label uni_text">Date of order </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup5Datepicker" required=""  name="order_date"  class="form-control"  >
                                </div>
                            </div>

                            <hr>
                            <h2 class="center red bold"><u>Please select the name who passes this order </u></h2>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('mondal_name') ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="lm_code">
                                    <?php
                                    foreach($lmname as $lm){
                                    ?>
                                       <option  value="<?php echo $lm->lm_code;?>"><?php echo $lm->lm_name;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup3Datepicker" required=""  name="lm_date"  class="form-control"  >
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sk_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="sk_code">
                                    <?php
                                    foreach($skname as $sk){
                                    ?>
                                       <option  value="<?php echo $sk->user_code;?>"><?php echo $sk->username;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup2Datepicker" required=""  name="sk_date"  class="form-control"  >
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('co_name'); ?> </label>
                                <div class="col-lg-2">
                                     <select class="form-control"  required name="co_code">
                                    <?php
                                    foreach($coname as $co){
                                    ?>
                                       <option value="<?php echo $co->user_code;?>"><?php echo $co->username;?></option>
                                    <?php
                                    }
                                    ?>
                                     </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup1Datepicker" required=""  name="co_date"  class="form-control"  >
                                </div>
                            </div>
                            <hr>
                            <h2 class="center red bold"><u>Land Area</u></h2>
                            <div class="form-group hide">
                                <p class="red bold"><u>Total Land Area</u></p>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="t_bigha" required="" value=""  >
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="t_katha" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2 ">
                                    <input type="text"  class="form-control" name="t_lessa" required="" value="" >
                                </div>  
                            </div>
                            <div class="form-group">
                                <p class="red bold"><u>To be Partition Land Area</u></p>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="p_bigha" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="p_katha" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="p_lessa" required="" value="" >
                                </div>  
                            </div>
                            <div class="form-group">
                               <label for="inputEmail" class="col-lg-2 control-label uni_text">Revenue per bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="rev_p_bigha" required="" value="" >
                                </div>
                            </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                            <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        window.location = "<?php echo base_url(); ?>index.php/MisReport/";
    };
</script>