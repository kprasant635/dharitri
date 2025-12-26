<div class="row login form-top">
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
   <?php //var_dump($this->session->all_userdata()); ?>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center small'><?php echo $this->lang->line('mutated_land_area_for_field_mutation');
                                    if($this->session->userdata('mut_type') == '02')
                                    {
                                        $mut_part= "Field Partitioned";
                                       
                                    }else{
                                         $mut_part= " Mutated";   
                                    }
                                     echo $mut_part;
                                    ?>
                            
                            </p>
                        </div>
                    </div>
                    <div id="alerts"></div>
                    <div class='panel-body'>
                        <hr>
                        <form class='form-horizontal' id='' method="post" action="<?php echo base_url() . "index.php/mutationbacklog/saveMutationDagDetails"; ?>">
                           
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('dag_no')?></label>
                                <div class="col-sm-10">
                                     <select class="form-control dag_no" id='dag_no' name='dag_no' required>
                                         <option disabled selected><?php echo $this->lang->line('select_dag_no')?></option>
                                         <?php foreach($dags as $d):?>
                                         <option><?php echo $d->dag_no;?></option>
                                         <?php endforeach;?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('land_description')?> </label>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('bigha')?></span>
                                    <input type="text"  class="form-control" value="0" readonly="" id='b' name='dag_area_b' placeholder="বিঘা">
                                </div>
                               
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('katha')?></span>
                                    <input type="text"  class="form-control" value="0"  readonly="" id='katha' name='dag_area_k' placeholder="কঠা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('lessa')?></span>
                                    <input type="text"  class="form-control"  readonly="" id='l' name='dag_area_lc' placeholder="লেছা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('ganda')?></span>
                                    <input type="text"  class="form-control"  id='g' name='dag_area_g' placeholder="গন্ডা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('krantik')?></span>
                                    <input type="text" class="form-control"  id='k' name='dag_area_kr' placeholder="ক্ৰান্তি" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 required  uni_text control-label"><?php echo $this->lang->line('land_area_to_be_mutated');
                                echo $mut_part;
                                        
                                        ?></label>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('bigha')?></span>
                                    <input type="text" maxlength="6" class="form-control" value="<?php echo $b;?>"
                                           id='mb' name='m_dag_area_b' placeholder="বিঘা">
                                </div>
                               
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('katha')?></span>
                                    <input type="text" maxlength="2" class="form-control" value="<?php echo $k;?>"
                                           name='m_dag_area_k' id='mutatedk'  placeholder="কঠা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('lessa')?></span>
                                    <input type="text" maxlength="4" class="form-control" value="<?php echo $lc;?>"
                                           name='m_dag_area_lc' id='lm' placeholder="লেছা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('ganda')?></span>
                                    <input type="text" maxlength="2" class="form-control" name='m_dag_area_g' id='mg' placeholder="গন্ডা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('krantik')?></span>
                                    <input type="text" maxlength="2" class="form-control"  name='m_dag_area_kr' id='mk' placeholder="ক্ৰান্তি" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('land_area_left')?></label>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('bigha')?></span>
                                    <input type="text" class="form-control" readonly="" id="rb" placeholder="বিঘা" value="0">
                                </div>
                               
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('katha')?></span>
                                    <input type="text" class="form-control" readonly="" id="rkatha" placeholder="কঠা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('lessa')?></span>
                                    <input type="text" class="form-control" readonly="" id="rl" placeholder="লেছা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('ganda')?></span>
                                    <input type="text" class="form-control" readonly="" id="rg" placeholder="গন্ডা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('krantik')?></span>
                                    <input type="text" class="form-control" readonly="" id="rk" placeholder="ক্ৰান্তি" value="0">
                                </div>
                            </div>
                            
                            <?php if($type=='02'):?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('land_revenue')?></label>
                                <div class="col-sm-10">
                                    <input type="number" required maxlength="19" class="form-control" name='min_revenue' id="applicantNam" placeholder="ৰাজহ" value="0">
                                </div>
                            </div>
                            <?php endif;?>
                            <?php if($type=='01'):?>
                            <div class="form-group" style="display: none">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('revenue')?></label>
                                <div class="col-sm-10">
                                    <input type="number" required maxlength="19" class="form-control" name='min_revenue' id="applicantNam" value="1" placeholder="ৰাজহ" value="0">
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="form-group" style="display: none">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('land_valuation')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="11" class="form-control" name='land_valuation' id="applicantNam" placeholder="ৰাজহ" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 required  uni_text control-label"><?php echo $this->lang->line('remark')?></label>
                                <div class="col-sm-10">
                                    <textarea  type="text" id="lmdatefield00"  class="form-control editor1" required  name='remark' rows="5"  placeholder="মন্তৱ্য"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" id='submitpartitionland' class="fieldmutpart btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>
                                    <a href='<?php echo base_url() . "index.php/lmmutation/pattadardetails"; ?>' disabled class="btn btn-danger next"><i class='fa fa-check'></i><?php echo $this->lang->line('next')?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.fieldmutpart').prop('disabled', true);
        $("#lmdatefield00").click(function() {
        $('.fieldmutpart').prop('disabled', false);
    });
</script>




