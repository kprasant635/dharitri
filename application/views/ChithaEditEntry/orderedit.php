dat<style>
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
        var removed = [];
        $('#addapplicant').click(function (e) {

            e.preventDefault();
            var newField = $('.occupant').last().clone();
            var lastid = newField.find('.occupid').val();
            if (lastid === undefined) {
                alert("No Applicants");
                var template = "<tr><td><input name='occup[1][occupant_id]' type='text' style='width:50px;' value='1'/></td>"
                        + "<td><input name='occup[1][occupant_name]' type='text'/></td>"
                        + "<td><input name='occup[1][occupant_fmh_name]' type='text'/></td>"
                        + "<td><input name='occup[1][occupant_add1]' type='text'/></td>"
                        + "<td><input name='occup[1][land_area_b]' type='text' style='width:50px;' value='0'/></td>"
                        + "<td><input name='occup[1][land_area_k]' type='text' style='width:50px;' value='0'/></td>"
                        + "<td><input name='occup[1][land_area_lc]' type='text' style='width:50px;' value='0'/></td>"
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
                        <input type="hidden" name="finalorder[col8order_cron_no]"  value="<?php echo $order->col8order_cron_no; ?>"/>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>Order Passed (Y/N)</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="finalorder[order_pass_yn]" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="order_pass_yn" value="">No</label>

                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>Case No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" readonly="" checked="" value="<?php echo $order->case_no;?>" name="finalorder[case_no]" value="Y">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>Order Type</label>
                            <div class="col-sm-4">
                                <select name='finalorder[order_type_code]' class="form-control">
                                    <option>Select Order Type</option>

                                    <?php foreach ($ord_types as $type): ?>
                                        <?php if ($order->order_type_code == $type->order_type_code): ?>
                                            <option selected value="<?php echo $type->order_type_code; ?>"><?php echo $type->order_type; ?></option>
                                        <?php else: ?>
                                            <option  value="<?php echo $type->order_type_code; ?>"><?php echo $type->order_type; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Transfer Type</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="finalorder[nature_trans_code]">
                                    <option>Select Transfer Type</option>
                                    <?php foreach ($trans_codes as $type): ?>
                                        <?php if ($order->nature_trans_code == $type->trans_code): ?>
                                            <option selected value="<?php echo $type->trans_code; ?>"><?php echo $type->trans_desc_as; ?></option>
                                        <?php else: ?>
                                            <option  value="<?php echo $type->trans_code; ?>"><?php echo $type->trans_desc_as; ?></option>
                                        <?php endif; ?>
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
                                        <?php if ($order->lm_code == $type->user_code): ?>
                                            <option selected value="<?php echo $type->lm_code; ?>"><?php echo $type->lm_name; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $type->lm_code; ?>"><?php echo $type->lm_name; ?></option>
                                        <?php endif; ?>
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
                                       value="<?php echo date('d-m-Y', strtotime($order->lm_note_date)); ?>" class="form-control dating calendar"      id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>Circle Office Name</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="finalorder[co_code]">
                                    <option>Select CO</option>
                                    <?php foreach ($cos as $type): ?>
                                        <?php if ($order->co_code == $type->user_code): ?>
                                            <option selected value="<?php echo $type->user_code; ?>"><?php echo $type->username; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $type->user_code; ?>"><?php echo $type->username; ?></option>
                                        <?php endif; ?>
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
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;"> 
                            <label for="inputEmail3" class="col-sm-2  control-label " id='applicant_name_label'>CO Order Date</label>
                            <div class="col-sm-4">
                                <input type="text" name="finalorder[co_ord_date]" value="<?php echo date('d-m-Y', strtotime($order->co_ord_date)); ?>" class="form-control dating calendar"     name="co_ord_date" id="applicantNam" 
                                       placeholder="">
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
                                <?php foreach ($occupants as $occupant): ?>
                                    <tr class='occupant'>
                                        <?php $id = $occupant->occupant_id; ?>
                                        <td ><input name="occup[<?php echo $id; ?>][occupant_id]" class="occupid"  value="<?php echo $occupant->occupant_id; ?>"/></td>
                                        <td><input name="occup[<?php echo $id; ?>][occupant_name]"  class="name" value="<?php echo $occupant->occupant_name; ?>"/></td>
                                        <td><input name="occup[<?php echo $id; ?>][occupant_fmh_name]" class="fmh" value="<?php echo $occupant->occupant_fmh_name; ?>"/></td>
                                        <td><input name="occup[<?php echo $id; ?>][occupant_add1]" class="add" value="<?php echo $occupant->occupant_add1; ?>"/></td>
                                        <td><input  style="width:50px !important" name="occup[<?php echo $id; ?>][land_area_b]" class="b" value="<?php echo $occupant->land_area_b; ?>"/></td>
                                        <td><input style="width:50px !important" name="occup[<?php echo $id; ?>][land_area_k]" class="k" value="<?php echo $occupant->land_area_k; ?>"/></td>
                                        <td><input style="width:50px !important" name="occup[<?php echo $id; ?>][land_area_lc]" class="l" value="<?php echo $occupant->land_area_lc; ?>"/></td>
                                        <td><a class='rem' data-attr='<?php echo $occupant->occupant_id; ?>'><i class="fa fa-times"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
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
                                <?php foreach ($inplaces as $occupant): ?>
                                    <tr>
                                        <?php $id = $occupant->inplace_of_id; ?>
                                        <td><input name="inplace[<?php echo $id; ?>][inplace_of_id]"  value="<?php echo $occupant->inplace_of_id; ?>"/></td>
                                        <td><input name="inplace[<?php echo $id; ?>][inplace_of_name]" value="<?php echo $occupant->inplace_of_name; ?>"/></td>
                                        <td><input name="inplace[<?php echo $id; ?>][inplace_of_father]" value="<?php echo $occupant->inplace_of_father; ?>"/></td>

                                        <td>
                                            <select name="inplace[<?php echo $id; ?>][inplaceof_alongwith]">
                                                <?php if ($occupant->inplaceof_alongwith == 'i'): ?>
                                                    <option selected value="i">Inplace</option>
                                                    <option  value="a">Alongwith</option>
                                                <?php endif; ?>
                                                <?php if ($occupant->inplaceof_alongwith == 'a'): ?>
                                                    <option selected value="a">Alongwith</option>
                                                    <option  value="i">Inplace</option>
                                                <?php endif; ?>    



                                            </select>
                                        </td>
                                        <td><i class="fa fa-times"></i></td>
                                    </tr>
                                <?php endforeach; ?>
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