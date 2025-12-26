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
        $('.partition').css('display', 'none');
        $('#ord_type').change(function (e) {
            var what = $(this).val();
            if (what === '02') {
                alert("You have selected partiton. Enter New Dag & New Patta No.")
                $('.partition').show();
            }
            if (what === '01') {
                $('.partition').hide();
            }
        });
        var removed = [];
        var count=1;
        $('#addapplicant').click(function (e) {
            
            e.preventDefault();
            var newField = $('.occupant').last().clone();
            var lastid = newField.find('.occupid').val();
            if (lastid === undefined) {
                alert("No Applicants");
                var template = "<tr><td><input name='occup["+count+"][occupant_id]' type='text' style='width:50px;' value='"+count+"'/></td>"
                        + "<td><input name='occup["+count+"][occupant_name]' type='text'/></td>"
                        + "<td><input name='occup["+count+"][occupant_fmh_name]' type='text'/></td>"
                        + "<td><input name='occup["+count+"][occupant_add1]' type='text'/></td>"
                        + "<td><input name='occup["+count+"][land_area_b]' type='text' style='width:50px;' value='0'/></td>"
                        + "<td><input name='occup["+count+"][land_area_k]' type='text' style='width:50px;' value='0'/></td>"
                        + "<td><input name='occup["+count+"][land_area_lc]' type='text' style='width:50px;' value='0'/></td>"
                        ;

                $('#occupants').append(unescape(template));
            } else {

                newField.find('input').val("");
                var newId = parseInt(lastid) + 1;
                newField.find('.occupid').val(parseInt(lastid) + 1);
                newField.find('.occupid').attr('name', "occup[" + newId + "][occupant_id]");
                newField.find('.name').attr('name', "occup[" + newId + "][occupant_name]");
                newField.find('.fmh').attr('name', "occup[" + newId + "][occupant_fmh_name]");
                newField.find('.add').attr('name', "occup[" + newId + "][occupant_add1]");
                newField.find('.b').attr('name', "occup[" + newId + "][land_area_b]");
                newField.find('.k').attr('name', "occup[" + newId + "][land_area_k]");
                newField.find('.l').attr('name', "occup[" + newId + "][land_area_lc]");
                $('#occupants').append(newField);
            }

            count++;
        });
        $('.rem').click(function (e) {
            var saveObj = $(this);
            if (confirm("Remove This Applicant?")) {
                $.ajax({
                    url: baseurl + "chithaeditentry/removeApplicant/" + $(this).attr('data-attr'),
                    method: 'post',
                    data: {
                        'id': $(this).attr('data-attr')
                    },
                    success: function (data) {
                        saveObj.parent().parent().remove();
                    },
                    error: function () {
                        alert("Could Not Remove Applicant.");
                    }
                })
            }

        });
    })
</script>    

<div class="container-fluid login form-top">


    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Add/Modify Order</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post" >
                        <input type="hidden" name="finalorder[col8order_cron_no]"  value=""/>
                        <input type="hidden" readonly="" name="finalorder[col8order_cron_no]" value="<?php echo $max_number; ?>">
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>Order Passed (Y/N)</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="finalorder[order_pass_yn]" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="order_pass_yn" value="">No</label>

                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>Case</label>
                            <div class="col-sm-4">
                                <input type="text" name="finalorder[case_no]" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>Order Type</label>
                            <div class="col-sm-4">
                                <select name='finalorder[order_type_code]' id='ord_type' class="form-control">
                                    <option>Select Order Type</option>

                                    <?php foreach ($ord_types as $type): ?>
                                        <option  value="<?php echo $type->order_type_code; ?>"><?php echo $type->order_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Transfer Type</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="finalorder[nature_trans_code]">
                                    <option>Select Transfer Type</option>
                                    <?php foreach ($trans_codes as $type): ?>
                                        <option  value="<?php echo $type->trans_code; ?>"><?php echo $type->trans_desc_as; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Mondals Name</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="finalorder[lm_code]">
                                    <option>Select Mondal</option>
                                    <?php foreach ($mandals as $type): ?>
                                        <option value="<?php echo $type->user_code; ?>"><?php echo $type->use_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Mondals Sign</label>
                            <div class="col-sm-4">

                                <label class="checkbox-inline"><input type="radio" checked="" name="finalorder[lm_sign_yn]" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="finalorder[lm_sign_yn]" value="">No</label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 


                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>LM Note Date</label>
                            <div class="col-sm-4">
                                <input type="text" name="finalorder[lm_note_date]" 
                                       value="" class="form-control calendar"      id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Circle Office Name</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="finalorder[co_code]">
                                    <option>Select CO</option>
                                    <?php foreach ($cos as $type): ?>
                                        <option value="<?php echo $type->user_code; ?>"><?php echo $type->use_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>CO's Sign</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="finalorder[co_sign_yn]" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="finalorder[co_sign_yn]" value="">No</label>
                            </div>

                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>CO Order Date</label>
                            <div class="col-sm-4">
                                <input type="text" name="finalorder[co_ord_date]" value="" class="form-control"     name="co_ord_date" id="applicantNam" 
                                       placeholder="">

                            </div>
                        </div>
                        <hr>
                        <div class="form-group partition" style="width: 100%;background: #378CE1;padding: 10px;border-radius: 5px;color:#fff"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Old Dag</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" value="<?php echo $this->session->userdata('dag_no'); ?>" name="finalorder[dag_no]" value="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Old Patta</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $this->session->userdata('patta_no'); ?>" name="finalorder[old_patta]" value="">
                            </div>
                        </div>

                        <div class="form-group partition" style="width: 100%;background: #378CE1;padding: 10px;border-radius: 5px;color:#fff"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Dag</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="finalorder[new_dag]" value="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Patta</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="finalorder[new_patta]" value="">
                            </div>
                        </div>
                        <div class="form-group partition" style="width: 100%;background: #378CE1;padding: 10px;border-radius: 5px;color:#fff"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Bigha</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="finalorder[dag_area_b]" value="0">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Katha</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="finalorder[dag_area_k]" value="0">
                            </div>
                        </div>
                        <div class="form-group partition" style="width: 100%;background: #378CE1;padding: 10px;border-radius: 5px;color:#fff"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Lessa</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="finalorder[dag_area_lc]" value="0">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Ganda</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="finalorder[dag_area_g]" value="0">
                            </div>
                        </div>
                        <div class="form-group partition" style="width: 100%;background: #378CE1;padding: 10px;border-radius: 5px;color:#fff"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>New Krantik</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="finalorder[dag_area_kr]" value="0">
                            </div>
                            
                        </div>

                        <hr>
                        <fieldset>
                            <legend>Applicants</legend>
                            <div class="row">
                                <div class="col-lg-3 pull-right">
                                    <button id="addapplicant" class="btn btn-danger">Add New Applicant</button>
                                    <hr>
                                </div>
                            </div>
                            <table class="table" id='occupants'>
                                <tr>
                                    <th>ID</th>
                                    <th>Applicants Name</th>
                                    <th>Guardian Name</th>
                                    <th>Address</th>
                                    <th>B</th>
                                    <th>K</th>
                                    <th>L</th>
                                    <th>Action</th>
                                </tr>

                            </table>
                        </fieldset>
                        <hr>
                        <fieldset>
                            <legend>Inplace/Alongwith</legend>
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>Pattadar Name</th>
                                    <th>Guardian Name</th>

                                    <th>Inplace/Alongwith</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $j = 0;
                                foreach ($inplaces as $occupant):
                                    ?>
                                    <tr>
                                        <td><input name="inplace[<?php echo $j; ?>][inplace_of_id]"  value="<?php echo $occupant->pdar_id; ?>"/></td>
                                        <td><input name="inplace[<?php echo $j; ?>][inplace_of_name]" value="<?php echo $occupant->pdar_name; ?>"/></td>
                                        <td><input name="inplace[<?php echo $j; ?>][inplace_of_father]" value="<?php echo $occupant->pdar_father; ?>"/></td>

                                        <td>
                                            <select name="inplace[<?php echo $j; ?>][inplaceof_alongwith]">
                                                <option selected value="a">Alongwith</option>
                                                <option  value="i">Inplace</option>
                                            </select>
                                        </td>
                                        <td><input type="checkbox" name="inplace[<?php echo $j; ?>][include]"/></td>
                                    </tr>
                                    <?php
                                    $j++;
                                endforeach;
                                ?>
                            </table>
                        </fieldset>
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