<?php $i = 1; foreach ($applicants as $settlement): ?>
    <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
    <div class="tableCard" id='applicantData'>
        <table class="table table-bordered" id="appRow<?=$settlement->id?>">

            <?php if(trim($caseDetails->applied_for) == 'individual') : ?>

                <tr>
                    <th rowspan="8" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_name<?=$settlement->id?>" id="pdar_name<?=$settlement->id?>" readonly value="<?=$settlement->pdar_name;?>" class="form-control ">
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_guardian<?=$settlement->id?>" id="pdar_guardian<?=$settlement->id?>" readonly value="<?=$settlement->pdar_guardian;?>" class="form-control ">
                    </td>
                </tr>
                <tr>
                    <th>Applicant Name (English)</th>
                    <td>
                        <input type="text" name="eng_pdar_name<?=$settlement->id?>" id="eng_pdar_name<?=$settlement->id?>" readonly class="form-control" value="<?=$settlement->eng_pdar_name;?>" readonly>
                    </td>
                    <th>Guardian Name (English)</th>
                    <td>
                        <input type="text" readonly name="eng_pdar_guardian<?=$settlement->id?>" id="eng_pdar_guardian<?=$settlement->id?>" class="form-control" value="<?=$settlement->eng_pdar_guardian;?>">
                    </td>
                </tr>
                <tr>
                    <th>Relation</th>
                    <td>
                        <select disabled name="pdar_rel_guar<?=$settlement->id?>" id="pdar_rel_guar<?=$settlement->id?>" class="form-control">
                            <option value="">Select...</option>
                            <?php foreach ($guar_rel as $guar_rel_list) {
                                ?>
                                <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $settlement->pdar_rel_guar) { echo "selected";}?>>
                                    <?=$guar_rel_list->guard_rel_desc_as?>
                                </option>
                            <?php }?>
                        </select>
                    </td>

                    <th>Gender</th>
                    <td>
                        <select disabled name="pdar_gender<?=$settlement->id?>" id="pdar_gender<?=$settlement->id?>" class="form-control input_editable_background">
                            <option value="">Select gender...</option>
                            <option value="1" <?php if ($settlement->pdar_gender == "1") {echo "selected";}?>>Male</option>
                            <option value="2" <?php if ($settlement->pdar_gender == "2") {echo "selected";}?>>Female</option>
                            <option value="3" <?php if ($settlement->pdar_gender == "3") {echo "selected";}?>>Others</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>DOB</th>
                    <td>
                        <input type="text" readonly id="dob<?=$settlement->id?>" name="dob<?=$settlement->id?>" value="<?=$settlement->dob;?>" class="form-control " >
                    </td>
                    <?php if($settlement->is_applicant == 1): ?>
                        <th>Marital Status</th>
                        <td>
                            <strong class="alert-warning">
                                <select class="form-control" disabled id="marital_status<?=$settlement->id?>">
                                    <option value="">Select...</option>
                                    <?php
                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                        ?>
                                        <option value="<?=$marital_stat->CODE?>" <?php if($marital_stat->CODE == $settlement->marital_status){ echo "selected";}?>>
                                            <?=$marital_stat->NAME?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </strong>
                        </td>
                    <?php else:?>
                        <th>Applicant Type </th>
                        <td>
                            <input type="text" readonly  value="Joint Applicant" class="form-control" >
                        </td>
                    <?php endif;?>
                </tr>
                <?php if($settlement->is_applicant == 1): ?>
                    <tr>
                        <th>Caste</th>
                        <td>
                            <input type="hidden" name="caste" value="<?= $basic->caste ?>" class="form-control">
                            <input readonly type="text" name="caste_name" id="caste_name" value="<?php
                            foreach (json_decode(CASTE) as $caste)
                            {
                                if ($caste->CODE == $basic->caste)
                                {
                                    echo $caste->NAME;
                                }
                            }
                            ?>" class="form-control">
                        </td>
                        <th>Fall Under Protected Category</th>
                        <td>
                            <input type="text" readonly value="<?php
                            foreach(json_decode(PROTECTED_CLASS) as $p) {
                                if ($p->CODE == $settlement->protected_category) {
                                    echo $p->NAME;
                                }
                            }?>" class="form-control">
                        </td>
                    </tr>
                <?php endif;?>
                <tr>
                    <th>Mobile</th>
                    <td>
                        <input type="text" readonly name="pdar_mobile<?=$settlement->id?>" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile;?>" class="form-control" >
                    </td>
                    <th>Occupation</th>
                    <td>
                        <input type="hidden" name="occupation_applicant" value="<?=$settlement->a_occupation;?>" class="form-control">
                        <input type="text" readonly name="pdar_occupation<?=$settlement->id?>" id="pdar_occupation<?=$settlement->id?>" value="<?=$settlement->a_occupation;?>" class="form-control" >
                    </td>
                </tr>
                <?php if($settlement->is_applicant == 1): ?>
                    <tr>
                        <th>Permanent Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add1<?=$settlement->id?>" id="pdar_add1<?=$settlement->id?>" value="<?=$settlement->pdar_add1;?>" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Present Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add2<?=$settlement->id?>" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2;?>" class="form-control" >
                        </td>
                    </tr>
                <?php endif;?>

            <?php else: ?>
                <tr>
                    <th rowspan="8" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_name<?=$settlement->id?>" id="pdar_name<?=$settlement->id?>" readonly value="<?=$settlement->pdar_name;?>" class="form-control ">
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_guardian<?=$settlement->id?>" id="pdar_guardian<?=$settlement->id?>" readonly value="<?=$settlement->pdar_guardian;?>" class="form-control ">
                    </td>
                </tr>
                <tr>
                    <th>Applicant Name (English)</th>
                    <td>
                        <input type="text" name="eng_pdar_name<?=$settlement->id?>" id="eng_pdar_name<?=$settlement->id?>" readonly class="form-control" value="<?=$settlement->eng_pdar_name;?>" readonly>
                    </td>
                    <th>Guardian Name (English)</th>
                    <td>
                        <input type="text" readonly name="eng_pdar_guardian<?=$settlement->id?>" id="eng_pdar_guardian<?=$settlement->id?>" class="form-control" value="<?=$settlement->eng_pdar_guardian;?>">
                    </td>
                </tr>
                <tr>
                    <th>Relation</th>
                    <td>
                        <select disabled name="pdar_rel_guar<?=$settlement->id?>" id="pdar_rel_guar<?=$settlement->id?>" class="form-control">
                            <option value="">Select...</option>
                            <?php foreach ($guar_rel as $guar_rel_list) {
                                ?>
                                <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $settlement->pdar_rel_guar) { echo "selected";}?>>
                                    <?=$guar_rel_list->guard_rel_desc_as?>
                                </option>
                            <?php }?>
                        </select>
                    </td>

                    <th>Gender</th>
                    <td>
                        <select disabled name="pdar_gender<?=$settlement->id?>" id="pdar_gender<?=$settlement->id?>" class="form-control input_editable_background">
                            <option value="">Select gender...</option>
                            <option value="1" <?php if ($settlement->pdar_gender == "1") {echo "selected";}?>>Male</option>
                            <option value="2" <?php if ($settlement->pdar_gender == "2") {echo "selected";}?>>Female</option>
                            <option value="3" <?php if ($settlement->pdar_gender == "3") {echo "selected";}?>>Others</option>
                        </select>
                    </td>
                </tr>


                <tr>
                    <th>Mobile</th>
                    <td>
                        <input type="text" readonly name="pdar_mobile<?=$settlement->id?>" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile;?>" class="form-control" >
                    </td>

                </tr>
                <?php if($settlement->is_applicant == 1): ?>
                    <tr>
                        <th>Permanent Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add1<?=$settlement->id?>" id="pdar_add1<?=$settlement->id?>" value="<?=$settlement->pdar_add1;?>" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Present Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add2<?=$settlement->id?>" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2;?>" class="form-control" >
                        </td>
                    </tr>
                <?php endif;?>
            <?php endif;?>
        </table>
    </div>

    <?php $i++; ?>
<?php endforeach; ?>