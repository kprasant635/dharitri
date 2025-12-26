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
<script>
    $(function () {
        $('input[name="dag_no"]').change(function (e) {
            var dag_no = $(this).val();
            var dist = $('input[name="dist_code"]').val();
            var sub = $('input[name="subdiv_code"]').val();
            var cir = $('input[name="cir_code"]').val();
            var mouza = $('input[name="subdiv_code"]').val();
            var lot = $('input[name="lot_no"]').val();
            var vill = $('input[name="vill_townprt_code"]').val();
            $.ajax({
                url: baseurl + "ChithaEditEntry/getdagdetails/",
                data: $('form').serialize(),
                method: 'post',
                success: function (data) {
                    var object = JSON.parse(data);
                    console.log(object);
                    if (object.length >= 1) {
                        var ans = confirm("This Dag Exists. Are you sure you want to edit it?");
                        $('#edit').val('1');
                        for (var key in object[0]) {
                            console.log(key);
                            console.log(object[0][key]);
                            $("input[name='" + key + "']").val(object[0][key]);
                        }
                       $('select[name="patta_type_code"] option[value='+object[0].patta_type_code+']').attr('selected','selected');
                       $('select[name="land_class_code"] option[value='+object[0].land_class_code+']').attr('selected','selected');
                    } else {
                        $('input[name="dag_no_int"]').val(dag_no + "00");
                    }
                }
            });
        });
    });
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Basic Order Details</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline"  method="post" action="">
                        <input type='hidden' id='edit' name='edit' value=""/>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DIST CODE</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" value="<?php echo $d; ?>" class="form-control"  required   name="dist_code" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>SUBDIV CODE</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" value="<?php echo $s; ?>" class="form-control"  required   name="subdiv_code" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>CIR CODE</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" value="<?php echo $c; ?>" class="form-control"  required   name="cir_code" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>MOUZA PARGONA CODE</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" class="form-control" value="<?php echo $m; ?>" required   name="mouza_pargona_code" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LOT NO</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" class="form-control" value="<?php echo $l; ?>"  required   name="lot_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>VILL TOWNPRT CODE</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" class="form-control"  value="<?php echo $v; ?>" required   name="vill_townprt_code" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>OLD DAG NO</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="old_dag_no" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DAG NO</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  required  name="dag_no" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DAG NO INT</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" readonly=""  name="dag_no_int" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>PATTA TYPE CODE</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="patta_type_code" required>
                                        <option selected disabled>Patta Type</option>
                                        <?php foreach ($patta_types as $pt): ?>
                                            <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>PATTA NO</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  required   name="patta_no" id="applicantNam" required
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LAND CLASS CODE</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="land_class_code" required>
                                        <option selected disabled>Land Class</option>
                                        <?php foreach ($land_classes as $pt): ?>
                                            <option value="<?php echo $pt->class_code; ?>"><?php echo $pt->land_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"  id='applicant_name_label'>BIGHA</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"   required  name="dag_area_b" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required " id='applicant_name_label'>KATHA</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"   required  name="dag_area_k" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LESSA</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  required   name="dag_area_lc" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>GANDA</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="0"    name="dag_area_g" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>KRANTIK</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="0" required   name="dag_area_kr" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DAG AREA ARE</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required  value="0"  name="dag_area_are" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DAG REVENUE</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  required value="0"  name="dag_revenue" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DAG LOCAL TAX</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  required value="0"  name="dag_local_tax" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <!--<div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG NO MAP</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"   value="0"  name="dag_no_map" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG N DESC</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_n_desc" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG S DESC</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_s_desc" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG E DESC</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_e_desc" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG W DESC</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_w_desc" id="applicantNam" 
                                           placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG N DAG NO</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_n_dag_no" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG S DAG NO</label>
                                <div class="col-sm-4">
                                    ;     <input type="text" class="form-control"     name="dag_s_dag_no" id="applicantNam" 
                                                 placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG E DAG NO</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_e_dag_no" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" style="width: 100%;">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>DAG W DAG NO</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"     name="dag_w_dag_no" id="applicantNam" 
                                           placeholder="">
                                </div>
                            </div>-->
                            <hr>
                            <div style="text-align: center">
                                <a href="<?php echo base_url(); ?>index.php/chithaeditentry/pattadardetails" class="btn btn-danger">Next</a>
                                <input type="submit" name="submit" value="submit" class="btn btn-danger"/>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>