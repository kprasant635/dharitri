<div class="row login">

    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold rasid'><?php echo $this->lang->line('list_of_plots_of_land_proposed_for_reclassification');?> </p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <ol class="progtrckr" data-progtrckr-steps="4">
                            <li class="progtrckr-done firsttick"><?php echo $this->lang->line('select_location');?></li>
                            <li class="progtrckr-done secondtick"><?php echo $this->lang->line('transfer_type');?></li>
                        </ol>
                        <hr>
                        <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LandReclassification/saveConvertionTrnsfrDetails' ?>">

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('dag_no');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" placeholder="Dag No" name="dag_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type');?></label>
                                <div class="col-sm-2">
                                    <select class="form-control patta-type_conv" name="patta_type">
                                        <option selected disabled>-- Select --</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_class');?></label>
                                <div class="col-sm-2">
                                    <select class="form-control patta-type_conv" name="land_class">
                                        <option selected disabled>-- Select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('present_land_revenue');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" placeholder="" name="p_land_rev">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('local_tax');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" placeholder="" name="loc_tax">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('total_revenue');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" placeholder="" name="tot_rev">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('year_in_which_the_land_is_used_for_other_purpose');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control applicantNam" id="applicantNam" placeholder="Patta No" name="patta_no">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group alert alert-success">
                                <label for="inputEmail3" class="col-sm-2 control-label"><span class="ass-btn"><?php echo $this->lang->line('full_part_of_the_dag');?><br><?php echo $this->lang->line('land_area');?></span></label>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('bigha');?></p>
                                    <input type="text" class="form-control" id='b' name='dag_area_b' placeholder="বিঘা" readonly>
                                </div>
                               
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('katha');?></p>
                                    <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="Katha" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('lesa');?></p>
                                    <input type="text" class="form-control"  id='l' name='dag_area_lc' placeholder="Lessa" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('ganda');?></p>
                                    <input type="text" class="form-control"  id='g' name='dag_area_g' placeholder="Ganda" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('krantik');?></p>
                                    <input type="text" class="form-control"  id='k' name='dag_area_kr' placeholder="Kranti" readonly>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('new_land_class');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control applicantNam" id="applicantNam" placeholder="Patta No" name="patta_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('proposed_land_revenue');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control applicantNam" id="applicantNam" placeholder="Patta No" name="patta_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('revenue_difference');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control applicantNam" id="applicantNam" placeholder="Patta No" name="patta_no">
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                    <a href='<?php echo base_url() . "index.php/AsistantMutationPartha/Conversion"; ?> '  class="btn btn-danger"><i class='fa fa-check'></i> <?php echo $this->lang->line('back');?></a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





