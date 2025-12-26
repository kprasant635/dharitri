<?php $i = 1;  foreach ($owners as $owner): ?>
    <?php  if($owner->is_applicant == 0): ?>
        <input type="hidden" name="pdar_type<?=$owner->id?>" value="<?=$owner->pdar_type;?>">
        <div class="tableCard" id='applicantData'>
            <table class="table table-bordered" id="appRow<?=$owner->id?>">
                <tr>
                    <th rowspan="8" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_name<?=$owner->id?>" id="pdar_name<?=$owner->id?>" readonly value="<?=$owner->name_ass;?>" class="form-control ">
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_guardian<?=$owner->id?>" id="pdar_guardian<?=$owner->id?>" readonly value="<?=$owner->gurdian_name_ass;?>" class="form-control ">
                    </td>

                </tr>
                <tr>
                    <th>Dag No</th>
                    <td>
                        <input type="text" name="dag_no_owner<?=$owner->id?>" id="dag_no_owner<?=$owner->id?>" readonly class="form-control" value="<?=$owner->dag_no;?>" >
                    </td>
                    <th>In place/Along with</th>

                    <input type="hidden" name="owners_pdar_id<?=$owner->id?>" value="<?php if(isset($err_return)){ echo set_value('owners_pdar_id'.$owner->id);}else{ echo $owner->id;}?>">
                    <input type="hidden" name="owners_pdar_type<?=$owner->id?>" value="O">

                    <td colspan="2">
                        <select name="owners_in_place<?=$owner->id?>" id="" class="inplace-along input_editable_background form-control <?php if(form_error('owners_in_place'.$owner->id)){echo 'is-invalid';}?>" required>
                            <option value="">Select...</option>
                            <option value="i" <?php if(isset($err_return)){ if (set_value('owners_in_place'.$owner->id) == "i") { echo "selected"; }}?>>In Place</option>
                            <option value="a" <?php if(isset($err_return)){ if (set_value('owners_in_place'.$owner->id) == "a") { echo "selected"; }}?>>Along with</option>
                        </select>
                        <?=form_error('owners_in_place'.$owner->id)?>
                    </td>
                </tr>


            </table>
        </div>

    <?php endif;?>
    <?php $i++; ?>
<?php endforeach; ?>