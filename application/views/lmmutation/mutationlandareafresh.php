<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Select Location</li>
                <li class="progtrckr-done secondtick">Transfer Type</li>
                <li class="progtrckr-done thirdtick">Applicant Details</li>
                <li class="progtrckr-done fourthtick">Mutation Land Area</li>
            </ol>
        </div>
    </div>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('mutated_land_area_for_field_mutation')?></p>
                        </div>
                    </div>
                    <div id="alerts"></div>
                    <div class='panel-body'>
                        <hr>
                        <form class='form-horizontal' id='submitlandarea' method="post" action="<?php echo base_url() . "index.php/lmmutation/saveMutationDagDetails"; ?>">
                      
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('dag_no')?></label>
                                <div class="col-sm-10">
                                    <select class="form-control dag_no" id='dag_no' name='dag_no'>
                                        <?php var_dump($dag);?>
                                        <option><?php echo $dag->dag_no; ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('land_area')?></label>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('bigha')?></p>
                                    <input type="text" maxlength="6" class="form-control" id='b'
                                           name='dag_area_b' value="0" placeholder="<?php echo $this->lang->line('bigha')?>" value="<?php echo $dag->dag_area_b;?>">
                                </div>

                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('katha')?></p>
                                    <input type="text"  maxlength="2" class="form-control"  id='katha' 
                                           name='dag_area_k' value="0" placeholder="<?php echo $this->lang->line('katha')?>" value="<?php echo $dag->dag_area_k;?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('lessa')?></p>
                                    <input type="text"  maxlength="4" class="form-control"  id='l' name='dag_area_lc'  value="0"
                                           placeholder="<?php echo $this->lang->line('lessa')?>" value="<?php echo $dag->dag_area_lc;?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('ganda')?></p>
                                    <input type="text" maxlength="2" lass="form-control"  id='g' name='dag_area_g' value="0"
                                           placeholder="<?php echo $this->lang->line('ganda')?>" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('krantik')?></p>
                                    <input type="text"  maxlength="2" class="form-control"  id='k' name='dag_area_kr' value="0"
                                           placeholder="<?php echo $this->lang->line('krantik')?>" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('mutation_land_area')?></label>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('bigha')?></p>
                                    <input type="text" maxlength="6" class="form-control"  id='mb' name='m_dag_area_b'
                                           placeholder="<?php echo $this->lang->line('bigha')?>" value="<?php echo $dag->m_dag_area_b;?>">
                                </div>

                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('katha')?></p>
                                    <input type="text" maxlength="2" class="form-control"  name='m_dag_area_k' id='mutatedk' 
                                           placeholder="<?php echo $this->lang->line('katha')?>" value="<?php echo $dag->m_dag_area_k;?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('lessa')?></p>
                                    <input type="text" maxlength="4" class="form-control" name='m_dag_area_lc' 
                                           id='lm' placeholder="<?php echo $this->lang->line('lessa')?>" value="<?php echo $dag->m_dag_area_lc;?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('ganda')?></p>
                                    <input type="text" maxlength="2" class="form-control" name='m_dag_area_g' id='mg' 
                                           placeholder="<?php echo $this->lang->line('ganda')?>" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('krantik')?></p>
                                    <input type="text" maxlength="2" class="form-control"  name='m_dag_area_kr' id='mk'
                                           placeholder="<?php echo $this->lang->line('krantik')?>" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('remaining_land')?></label>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('bigha')?></p>
                                    <input type="text" maxlength="6" class="form-control" id="rb" placeholder="<?php echo $this->lang->line('bigha')?>">
                                </div>

                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('katha')?></p>
                                    <input type="text"  maxlength="2" class="form-control" id="rkatha" placeholder="<?php echo $this->lang->line('katha')?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('lessa')?></p>
                                    <input type="text" maxlength="4" class="form-control" id="rl" placeholder="<?php echo $this->lang->line('lessa')?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('ganda')?></p>
                                    <input type="text" maxlength="2" class="form-control" id="rg" placeholder="<?php echo $this->lang->line('ganda')?>">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <p class="center bold"><?php echo $this->lang->line('krantik')?></p>
                                    <input type="text" maxlength="2" class="form-control" id="rk" placeholder="<?php echo $this->lang->line('krantik')?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('valuation')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="11" class="form-control" name='land_valuation' id="applicantNam" placeholder="<?php echo $this->lang->line('land_value')?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('remark')?></label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control"  name='remark' rows="5" id="applicantNam" placeholder="<?php echo $this->lang->line('lm_remark') ?>">
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" id='submitlandarea' class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>
                                    <a href='<?php echo base_url() . "index.php/lmmutation/pattadarDetailsFresh"; ?>' disabled class="btn btn-danger next"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




