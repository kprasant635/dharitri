<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Add/Modify Pattadar</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post" >
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>PDAR ID</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_id; ?>" class="form-control"     name="pdar_id" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>PDAR Name</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_name; ?>" class="form-control"     name="pdar_name" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR FATHER</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_father; ?>" class="form-control"     name="pdar_father" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR Mother</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_mother; ?>" class="form-control"     name="pdar_mother" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR Address1</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_add1; ?>" class="form-control"     name="pdar_add1" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group" style="width: 100%;"> 

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>DAG POR B</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->dag_por_b; ?>" class="form-control"     name="dag_por_b" id="applicantNam" 
                                       placeholder="">
                            </div> 


                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>DAG POR K</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->dag_por_k; ?>" class="form-control"     name="dag_por_k" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>DAG POR LC</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->dag_por_lc; ?>" class="form-control"     name="dag_por_lc" id="applicantNam" 
                                       placeholder="">
                            </div> 


                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>DAG POR G</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->dag_por_g; ?>" class="form-control"     name="dag_por_g" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>DAG POR KR</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->dag_por_kr; ?>" class="form-control"     name="dag_por_kr" id="applicantNam" 
                                       placeholder="">
                            </div> 


                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND N</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_land_n; ?>" class="form-control"     name="pdar_land_n" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND S</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_land_s; ?>" class="form-control"     name="pdar_land_s" id="applicantNam" 
                                       placeholder="">
                            </div> 


                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND E</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_land_e; ?>" class="form-control"     name="pdar_land_e" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND MAP</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_add1; ?>" class="form-control"     name="pdar_land_map" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND ACRE</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_land_acre; ?>" class="form-control"     name="pdar_land_acre" id="applicantNam" 
                                       placeholder="">
                            </div> 


                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND REVENUE</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_land_revenue; ?>" class="form-control"     name="pdar_land_revenue" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>PDAR LAND LOCALTAX</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $pattadar->pdar_land_localtax; ?>" class="form-control"     name="pdar_land_localtax" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div style="text-align: center">
                            <input type="submit" name="next" value="Next" class="btn btn-danger"/>
                            <input type="submit" name="submit" value="Submit" class="btn btn-danger"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>