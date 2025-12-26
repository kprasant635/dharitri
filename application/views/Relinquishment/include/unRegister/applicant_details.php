<?php $i = 1; foreach ($settlements as $applicant): ?>
    <?php if($applicant->is_applicant == 1) :?>
        <input type="hidden" name="pdar_type<?=$applicant->id?>" value="<?=$applicant->pdar_type;?>">
        <input type="hidden" name="is_urban" id="urbanCheck" value="<?=$applicant->is_rural_urban?>">
        <div class="tableCard" id='applicantData'>
            <table class="table table-bordered" id="appRow<?=$applicant->id?>">
                <tr>
                    <th rowspan="8" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_name<?=$applicant->id?>" id="pdar_name<?=$applicant->id?>" readonly value="<?=$applicant->name_ass;?>" class="form-control ">
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_guardian<?=$applicant->id?>" id="pdar_guardian<?=$applicant->id?>" readonly value="<?=$applicant->gurdian_name_ass;?>" class="form-control ">
                    </td>
                </tr>
                <tr>
                    <th>Applicant Name (English)</th>
                    <td>
                        <input type="text" name="eng_pdar_name<?=$applicant->id?>" id="eng_pdar_name<?=$applicant->id?>" readonly class="form-control" value="<?=$applicant->name_eng;?>" >
                    </td>
                    <th>Guardian Name (English)</th>
                    <td>
                        <input type="text" readonly name="eng_pdar_guardian<?=$applicant->id?>" id="eng_pdar_guardian<?=$applicant->id?>" class="form-control" value="<?=$applicant->gurdian_name_eng;?>">
                    </td>
                </tr>
                <tr>
                    <th>Relation</th>
                    <td>
                        <select disabled name="pdar_rel_guar<?=$applicant->id?>" id="pdar_rel_guar<?=$applicant->id?>" class="form-control">
                            <option value="">Select...</option>
                            <?php foreach ($guar_rel as $guar_rel_list) {
                                ?>
                                <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $applicant->gurdian_relation_id) { echo "selected";}?>>
                                    <?=$guar_rel_list->guard_rel_desc_as?>
                                </option>
                            <?php }?>
                        </select>
                    </td>
                    <th>Gender</th>
                    <td>
                        <select disabled name="pdar_gender<?=$applicant->id?>" id="pdar_gender<?=$applicant->id?>" class="form-control input_editable_background">
                            <option value="">Select gender...</option>
                            <option value="1" <?php if ($applicant->gender == "1") {echo "selected";}?>>Male</option>
                            <option value="2" <?php if ($applicant->gender == "2") {echo "selected";}?>>Female</option>
                            <option value="3" <?php if ($applicant->gender == "3") {echo "selected";}?>>Others</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>DOB</th>
                    <td>
                        <input type="text" readonly id="dob<?=$applicant->id?>" name="dob<?=$applicant->id?>" value="<?=$applicant->dob;?>" class="form-control " >
                    </td>
                    <?php if($applicant->is_applicant == 1): ?>
                        <th>Marital Status</th>
                        <td>
                            <strong class="alert-warning">
                                <select class="form-control" disabled id="marital_status<?=$applicant->id?>">
                                    <option value="">.....</option>
                                    <?php
                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                        ?>
                                        <option value="<?=$marital_stat->CODE?>" <?php if($marital_stat->CODE == $applicant->marital_status){ echo "--";}?>>
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
                <tr>
                    <th>Mobile</th>
                    <td>
                        <input type="text" readonly name="pdar_mobile<?=$applicant->id?>" id="pdar_mobile<?=$applicant->id?>" value="<?=$applicant->mobile;?>" class="form-control" >
                    </td>
                    <th>Verified By</th>
                    <td>
                        <input type="text" readonly  value="<?=$applicant->auth_type;?>" class="form-control" >
                    </td>
                </tr>
                <?php if($applicant->is_applicant == 1): ?>
                    <tr>
                        <th>Permanent Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add1<?=$applicant->id?>" id="pdar_add1<?=$applicant->id?>" value="<?php echo $applicant->per_add.', City - '.$applicant->per_city.', Pin - '.$applicant->per_pin; ?>" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Present Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add2<?=$applicant->id?>" id="pdar_add2<?=$applicant->id?>" value="<?php echo $applicant->pre_add.', City - '.$applicant->pre_city.', Pin - '.$applicant->pre_pin ?>" class="form-control" >
                        </td>
                    </tr>
                <?php endif;?>
            </table>
        </div>

        
    <?php endif;?>

    <?php if($applicant->is_applicant == 0 && $applicant->pdar_type =='B') :?>
        <input type="hidden" name="pdar_type<?=$applicant->id?>" value="<?=$applicant->pdar_type;?>">
        <div class="tableCard" id='applicantData'>
            <table class="table table-bordered" id="appRow<?=$applicant->id?>">
                <tr>
                    <th rowspan="8" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_name<?=$applicant->id?>" id="pdar_name<?=$applicant->id?>" readonly value="<?=$applicant->name_ass;?>" class="form-control ">
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td>
                        <input type="text" name="pdar_guardian<?=$applicant->id?>" id="pdar_guardian<?=$applicant->id?>" readonly value="<?=$applicant->gurdian_name_ass;?>" class="form-control ">
                    </td>
                </tr>
                <tr>
                    <th>Applicant Name (English)</th>
                    <td>
                        <input type="text" name="eng_pdar_name<?=$applicant->id?>" id="eng_pdar_name<?=$applicant->id?>" readonly class="form-control" value="<?=$applicant->name_eng;?>" >
                    </td>
                    <th>Guardian Name (English)</th>
                    <td>
                        <input type="text" readonly name="eng_pdar_guardian<?=$applicant->id?>" id="eng_pdar_guardian<?=$applicant->id?>" class="form-control" value="<?=$applicant->gurdian_name_eng;?>">
                    </td>
                </tr>
                <tr>
                    <th>Relation</th>
                    <td>
                        <select disabled name="pdar_rel_guar<?=$applicant->id?>" id="pdar_rel_guar<?=$applicant->id?>" class="form-control">
                            <option value="">Select...</option>
                            <?php foreach ($guar_rel as $guar_rel_list) {
                                ?>
                                <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $applicant->gurdian_relation_id) { echo "selected";}?>>
                                    <?=$guar_rel_list->guard_rel_desc_as?>
                                </option>
                            <?php }?>
                        </select>
                    </td>
                    <th>Gender</th>
                    <td>
                        <select disabled name="pdar_gender<?=$applicant->id?>" id="pdar_gender<?=$applicant->id?>" class="form-control input_editable_background">
                            <option value="">Select gender...</option>
                            <option value="1" <?php if ($applicant->gender == "1") {echo "selected";}?>>Male</option>
                            <option value="2" <?php if ($applicant->gender == "2") {echo "selected";}?>>Female</option>
                            <option value="3" <?php if ($applicant->gender == "3") {echo "selected";}?>>Others</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>DOB</th>
                    <td>
                        <input type="text" readonly id="dob<?=$applicant->id?>" name="dob<?=$applicant->id?>" value="<?=$applicant->dob;?>" class="form-control " >
                    </td>
                    <?php if($applicant->is_applicant == 1): ?>
                        <th>Marital Status</th>
                        <td>
                            <strong class="alert-warning">
                                <select class="form-control" disabled id="marital_status<?=$applicant->id?>">
                                    <option value="">Select...</option>
                                    <?php
                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                        ?>
                                        <option value="<?=$marital_stat->CODE?>" <?php if($marital_stat->CODE == $applicant->marital_status){ echo "selected";}?>>
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
                <tr>
                    <th>Mobile</th>
                    <td>
                        <input type="text" readonly name="pdar_mobile<?=$applicant->id?>" id="pdar_mobile<?=$applicant->id?>" value="<?=$applicant->mobile;?>" class="form-control" >
                    </td>
                    <th>Verified By</th>
                    <td>
                        <input type="text" readonly  value="<?=$applicant->auth_type;?>" class="form-control" >
                    </td>
                </tr>
                <?php if($applicant->is_applicant == 1): ?>
                    <tr>
                        <th>Permanent Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add1<?=$applicant->id?>" id="pdar_add1<?=$applicant->id?>" value="<?php echo $applicant->per_add.', City - '.$applicant->per_city.', Pin - '.$applicant->per_pin; ?>" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Present Address</th>
                        <td colspan="3">
                            <input type="text" readonly name="pdar_add2<?=$applicant->id?>" id="pdar_add2<?=$applicant->id?>" value="<?php echo $applicant->pre_add.', City - '.$applicant->pre_city.', Pin - '.$applicant->pre_pin ?>" class="form-control" >
                        </td>
                    </tr>
                <?php endif;?>
            </table>
        </div>
    <?php endif;?>
    <?php $i++; ?>
<?php endforeach; ?>