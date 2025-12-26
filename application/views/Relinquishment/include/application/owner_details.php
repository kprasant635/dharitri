<?php $i = 1; foreach ($applicants_owners as $owner): ?>
    <?php  if($owner->is_applicant == 0): ?>
    <input type="hidden" name="pdar_type<?=$owner->id?>" value="<?=$owner->pdar_type;?>">
    <div class="tableCard" id='applicantData'>
        <table class="table table-bordered" id="appRow<?=$owner->id?>">
            <tr>
                <th rowspan="8" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                <th>Applicant Name (Assamese)</th>
                <td>
                    <input type="text" name="pdar_name<?=$owner->id?>" id="pdar_name<?=$owner->id?>" readonly value="<?=$owner->pdar_name;?>" class="form-control ">
                </td>
                <th>Guardian Name (Assamese)</th>
                <td>
                    <input type="text" name="pdar_guardian<?=$owner->id?>" id="pdar_guardian<?=$owner->id?>" readonly value="<?=$owner->pdar_guardian;?>" class="form-control ">
                </td>
            </tr>
            <tr>
                <th>Dag No</th>
                <td>
                    <input type="text" name="dag_no_owner<?=$owner->id?>" id="dag_no_owner<?=$owner->id?>" readonly class="form-control" value="<?=$owner->dag_no;?>" >
                </td>
                <th>In place/Along with</th>
                <td>
                    <select class="form-control" disabled>
                        <option value="">NA</option>
                        <option value="i" <?= ($owner->inplace_alongwith == 'i') ? 'selected' : '' ?>>In Place</option>
                        <option value="a" <?= ($owner->inplace_alongwith == 'a') ? 'selected' : '' ?>>Along with</option>
                    </select>
                </td>
            </tr>

        </table>
    </div>
    <?php endif;?>
    <?php $i++; ?>
<?php endforeach; ?>