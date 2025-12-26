<?php //var_dump($names);?>
<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
<!--            <div class="well well-sm mis_report">
                <h2 style="text-align: center; color: #fff"> Select District</h2>
            </div>-->
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . '' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('district')?> </label>
                            <div class="col-sm-4">
                                <select class="form-control districtselect" id="select" name="dist_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select_district')?></option>
                                    <?php foreach ($names as $district): ?>
                                        <?php
                                        $distCode = $district->district;
                                        $location = $district->district_name;
                                          // session_start();
                                          // $_SESSION['DBname']= $location;
                                        ?>
                                        <option value="<?php echo $distCode; ?>"><?php echo $location; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        
                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-sm-4">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select_subdivision')?></option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('circle')?> </label>
                            <div class="col-sm-4">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option disabled selected><?php echo $this->lang->line('select_circle')?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>

                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>

  <hr>
                        <div class="form-group">
                            <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button')?></button>
                                <button id="backButton" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_home')?></button>
                            </div>
                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/JamabandiControllerBondita/menu' ?>";
    };
   
</script>

