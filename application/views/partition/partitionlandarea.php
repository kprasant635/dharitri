<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div id="alerts"></div>
                    <div class='panel-body'>
                        <form class='form-horizontal form_1' id='submitlandarea1' method="post" action="<?php echo base_url() . "index.php/partition/partland"; ?>">
                            <fieldset><legend><?php echo $this->lang->line('total_dag_area'); ?> </legend>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('dag_no'); ?><i class="fa fa-star red"></i> </label>
                                    <div class="col-sm-5">
                                        <select class="form-control dag_no" id='dag_no' name='dag_no'>
                                            <option value=''><?php echo $this->lang->line('select_dag'); ?></option>
                                            <?php foreach ($dags as $d): ?>
                                                <option><?php echo $d->dag_no; ?></option>
                                            <?php endforeach; ?>
                                        </select>
										<?php echo form_error('dag_no', '<p class="red">', '</p>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('land_details'); ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control " id='b' readonly="" name='dag_area_b' placeholder="<?php echo $this->lang->line('bigha'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('bigha'); ?></p>
										<?php echo form_error('dag_area_b', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control"  id='katha' readonly="" name='dag_area_k' placeholder="<?php echo $this->lang->line('katha') ?>">
                                        <p class="center  lower_text lower_text"><?php echo $this->lang->line('katha') ?></p>
										<?php echo form_error('dag_area_k', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control"  id='l' readonly="" name='dag_area_lc' placeholder="<?php echo $this->lang->line('lesa') ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('lesa') ?></p>
										<?php echo form_error('dag_area_lc', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <div class="col-sm-2 hide"> 
                                        <input type="text" class="form-control"  id='g' readonly="" name='dag_area_g' placeholder="<?php echo $this->lang->line('ganda') ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('ganda') ?></p>
                                    </div>
                                    <div class="col-sm-2 hide">

                                        <input type="text" class="form-control"  id='k' readonly="" name='dag_area_kr' placeholder="<?php echo $this->lang->line('kranti'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('kranti'); ?></p>
                                    </div>
                                </div>
                            </fieldset>
                            <hr>
                            <fieldset><legend><?php echo $this->lang->line('land_for_partition'); ?></legend>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('type_here'); ?><i class="fa fa-star red"></i></label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control landNumB" required data-inputmask="'mask': '9{1,3}'"  id='mb' name='m_dag_area_b' value='0' placeholder="<?php echo $this->lang->line('bigha'); ?>">
                                        <span class="errmsgB"></span>
                                        <p class="center  lower_text"><?php echo $this->lang->line('bigha'); ?></p>
										<?php echo form_error('m_dag_area_b', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control landNumK" required data-inputmask="'mask': '9'"  name='m_dag_area_k' id='mutatedk' value='0'  placeholder="<?php echo $this->lang->line('katha'); ?>">
                                        <span class="errmsgK"></span> 
                                        <p class="center  lower_text"><?php echo $this->lang->line('katha'); ?></p>
										<?php echo form_error('m_dag_area_k', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="number" maxlength='7' class="form-control" required name='m_dag_area_lc' value='0.0' placeholder="<?php echo $this->lang->line('lesa'); ?>">
                                        <span class="errmsgL"></span>  
                                        <p class="center  lower_text"><?php echo $this->lang->line('lesa'); ?></p>
										<?php echo form_error('m_dag_area_lc', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <div class="col-sm-2 hide">
                                        <input type="text" class="form-control landNum" name='m_dag_area_g' id='mg' value='0' placeholder="<?php echo $this->lang->line('ganda'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('ganda'); ?></p>
                                    </div>
                                    <div class="col-sm-2 hide">
                                        <input type="text" class="form-control landNum"  name='m_dag_area_kr' id='mk' value='0' placeholder="<?php echo $this->lang->line('kranti'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('kranti'); ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('revenue'); ?><i class="fa fa-star red"></i></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name='land_valuation' id="quantity" required="" maxlength="4"  placeholder="<?php echo $this->lang->line('revenue'); ?>">
                                        <span id="errmsg"></span>
										<span class='small uni_text red'>Revenue per Bigha</span>
										<?php echo form_error('land_valuation', '<p class="red">', '</p>'); ?>
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control"  name='remark' rows="4" cols="5" placeholder="Lm Remark"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <hr>
                            <fieldset class="hide"><legend><?php echo $this->lang->line('remaining_land_area'); ?> </legend>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3">

                                        <input type="text" class="form-control" readonly="" id="rb" placeholder="<?php echo $this->lang->line('bigha'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('bigha'); ?></p>
                                    </div>

                                    <div class="col-sm-3">

                                        <input type="text" class="form-control" readonly="" id="rkatha" placeholder="<?php echo $this->lang->line('katha'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('katha'); ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" readonly="" id="rl" placeholder="<?php echo $this->lang->line('lesa'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('lesa'); ?></p>
                                    </div>
                                    <div class="col-sm-2 hide">

                                        <input type="text" class="form-control" readonly="" id="rg" placeholder="<?php echo $this->lang->line('ganda'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('ganda'); ?></p>
                                    </div>
                                    <div class="col-sm-2 hide">
                                        <input type="text" class="form-control" readonly="" id="rk" placeholder="<?php echo $this->lang->line('kranti'); ?>">
                                        <p class="center  lower_text"><?php echo $this->lang->line('kranti'); ?></p>
                                    </div>
                                </div>
                            </fieldset>


                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" id='submit' class="btn btn-primary uni_text"><i class='fa fa-check'></i>&nbsp;
                                        <?php echo $this->lang->line('submit_button'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

