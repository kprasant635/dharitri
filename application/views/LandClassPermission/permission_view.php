<hr>

    <?php
    if($error){
    ?>
        <div class="row justify-content-center">

            <div class="alert alert-warning col-10" role="alert">
                <?php echo $error;?>
            </div>
        </div>
    <?php
    }else{
    ?>
    <form id="form_sub">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"><i>Select Dag(s)</i></label>
                    <div class="col-sm-10">
                        <div class="list-group form__div p-2" id="dag_list" style="height:300px;overflow:auto;border: solid 3px #181842;">
                        
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-2">
                                        
                                        <div class="checkbox" style="display: inline-block;">
                                            <input type="checkbox" id="check_all" name="dag_list_all" aria-label="Checkbox for following text input">
                                        </div>
                                        <label style="display: inline-block; margin-left: 2px; margin-right:15px">
                                            All
                                        </label>
                                    </div>

                                    <?php
                                    foreach($dag_result as $dag_row) {
                                        ?>
                                        <div class="col-2">
                                    
                                            <div class="checkbox" style="display: inline-block;">
                                                <input type="checkbox" name="dag_no_arr[]" class="dag-checkbox" aria-label="Checkbox for following text input" value="<?=$dag_row->dist_code.'_'.$dag_row->subdiv_code.'_'.$dag_row->cir_code.'_'.$dag_row->mouza_pargona_code.'_'.$dag_row->lot_no.'_'.$dag_row->vill_townprt_code.'_'.$dag_row->dag_no?>">
                                            </div>
                                            <label style="display: inline-block; margin-left: 2px; margin-right:15px">
                                                <?=$dag_row->dag_no?>
                                            </label>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        
        <div class="row justify-content-center">
            <?php
            if($landclass_error){
                ?>
                <div class="alert alert-warning col-10" role="alert">
                    <?php echo $landclass_error;?>
                </div>
                <?php
            }else{
            ?>
            <div class="col-md-10">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"><i>Select landclass(s)</i></label>
                    <div class="col-sm-10">
                        <div class="list-group form__div p-2" id="landclass_list" style="height:300px;overflow:auto;border: solid 3px #181842;">
                        
                            <div class="form-inline">
                                <div class="row">
                                    <!-- <div class="col-6">
                                        
                                        <div class="checkbox" style="display: inline-block;">
                                            <input type="checkbox" id="check_all_lnd_class" name="landclass_all" aria-label="Checkbox for following text input">
                                        </div>
                                        <label style="display: inline-block; margin-left: 2px; margin-right:15px">
                                            All
                                        </label>
                                    </div>
                                    <hr> -->

                                    <?php
                                    $agri = 1;
                                    $home = 1;
                                    foreach($landclass_result as $lnd_row) {
                                        if($lnd_row->class_code_cat == '01' && $agri == 1){
                                            echo '<div class="col-6 pl-3 text-success"><b>Agriculture</b></div><hr>';
                                            $agri++;
                                        }
                                        if($lnd_row->class_code_cat == '02' && $home == 1){
                                            echo '<div class="col-6 pl-3 text-danger"><b>Homestead</b></div><hr>';
                                            $home++;
                                        }
                                        ?>
                                        <div class="col-6">
                                    
                                            <div class="checkbox" style="display: inline-block;">
                                                <input type="checkbox" name="landclass_arr[]" value="<?=$lnd_row->class_code?>" class="land-class-checkbox" aria-label="Checkbox for following text input">
                                            </div>
                                            <label style="display: inline-block; margin-left: 2px; margin-right:15px">
                                                <?=$lnd_row->land_type?>
                                            </label>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        
        <br>

        <div class="row justify-content-center">
            <button type="button" onclick="permissionSave()" class="btn btn-sm btn-primary col-4">Submit</button>
        </div>
    </form>


    <?php
    }
    ?>
</div>
