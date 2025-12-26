<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <?php if($this->session->flashdata('success')) { ?>

                <div class="success-msg">
                    <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                    </div>
                </div>

            <?php } ?>

            <?php if($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><?php echo $this->session->flashdata('error') ?></b>
                    <br>
                    <b><?php echo $this->session->flashdata('error_code') ?></b>
                </div>
            <?php } ?>


            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Case Transfer (Assign CO)</h2>
                </div>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="center panel-title">
                            Fill up application form
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p class='red center' style="font-weight: bold; font-size: 18px">
                            Once You submit the pulling request then all the case(s) will come to you
                        </p>
                        <br>
                        <?php
                        $attributes = array('CaseTransfer/casesAssigningToNewCo','class' => 'form-horizontal', 'id' => 'myform');
                        echo form_open_multipart('CaseTransfer/casesAssigningToNewCo',$attributes); ?>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                            <div class="col-lg-2">
                                <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                </select>
                            </div>
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <div class="col-lg-2">
                                <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>

                                </select>
                            </div>
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                            <div class="col-lg-2">
                                <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                </select>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for="select" class="col-lg-2 control-label">Cases Pull To </label>
                            <div class="col-lg-2">
                                <select class="form-control" name='user_code' id="select" required name="circle_code">
                                    <?php foreach($colist as $name){
                                        $data=$this->utilityclass->getSelectedCOName($name->dist_code,$name->subdiv_code,$name->cir_code,$name->user_code);
                                        ?>
                                        <option value='<?=$data->user_code?>'><?=$data->username?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <label for="select" class="col-lg-2 control-label">Cases Pull From </label>
                            <div class="col-lg-2">
                                <select class="form-control" id="select" required name="circle_code_from">
                                    <option selected disabled>Select</option>
                                    <?php foreach($coListTo as $name){
                                    $data=$this->utilityclass->getSelectedCOName($name->dist_code,$name->subdiv_code,$name->cir_code,$name->user_code);
                                    ?>
                                        <option value='<?=$data->user_code?>'><?= $data->username?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <hr style="margin-bottom: 25px; margin-top: 25px">
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