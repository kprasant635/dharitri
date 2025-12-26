<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2E4D8E"><?php echo $this->lang->line('village_wise_tenant_list');?></h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_land_location');?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/MisReport/saveJamaWasil' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('district');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select_district');?></option>
                                    <?php foreach ($names as $district): ?>
                                        <?php
                                        $distCode = $district->dist_code;
                                        $location = $district->loc_name;
                                        ?>
                                        <option value="<?php echo $distCode; ?>"><?php echo $location; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-sm-4">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select_subdivision');?></option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('circle');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option disabled selected><?php echo $this->lang->line('select_circle');?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('mouza');?></label>
                                <div class="col-sm-4">
                                     <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lot_no');?></label>
                                <div class="col-sm-4">
                                     <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_lot_no');?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                                
                            </div>
               
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('vill_town');?></label>
                                <div class="col-sm-4">
                                     <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_vill_town');?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                                
                            </div>
                      
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <button id="backButton" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                            </div>
                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-transparent" style="margin-top: 250px" id='myModal' >
    <div class="" role="document"> 

        <center>
            <img id="loading-image" style="" width="100px" src= "http://10.177.15.210:8080/dharitreecode/application/views/images/load.gif" alt="Loading..." />
            <h2 style="color:#fff" >Please Wait ! </h2>
            <h5 style="color: #fff">Generating Land Class Wise Village Land Scenario. </h5>
        </center>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/MonthlyCitizenCentricService' ?>";
    };
   
</script>
