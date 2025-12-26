<?php $sl_count = 1 ?>
<h5 class="reza-title" style="margin-top: 15px">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
</h5>
<div class="reza-card ">
    <div class="reza-body">
        <div class="row" style="padding-bottom: 15px">
            <div class="col-md-6">
                <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                <?=form_error('chitha_verified')?>
            </div>
            <div class="col-md-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                           type="radio" name="chitha_verified" id="chiitha_verified1" value="YES"
                        <?php if(set_value('chitha_verified') == 'YES'){ echo "checked";} ?> />
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                           type="radio" name="chitha_verified" id="chiitha_verified2" value="NO"
                        <?php if(set_value('chitha_verified') == 'NO'){ echo "checked";} ?> />
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-4">
                <?php foreach ($rel_dag as $ddg): ?>
                    <i class="fa fa-link" aria-hidden="true"></i>
                    <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' .
                        $ddg->dag_no . '&m=' . $ddg->mouza_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_code . '&p=' .
                        $ddg->patta_type_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>">
                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                    </a>
                    <br>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row" style="padding-bottom: 15px">
            <div class="col-md-6">
                <span><strong><?=$sl_count++?>.</strong>
                    Copy of trace map of the proposed land clearly highlighting the propose land road/riverside reservation etc(if any)</span>
                <?php echo form_error('trace_map_copy'.$rel_dag[0]->id); ?>
            </div>
            <div class="col-md-6">
                <?php foreach ($rel_dag as $ddg): ?>
                    <span class="alert-warning">For Dag no. : <strong><?=$ddg->dag_no?></strong></span>
                    <input type="hidden" name="dag_no_doc<?=$ddg->id?>" value="<?=$ddg->dag_no?>">
                    <input type="file" name="trace_map_copy<?=$ddg->id?>" id="trace_map_copy" accept=".png, .jpg, .jpeg, .pdf"
                           class="form-control <?php if(form_error('trace_map_copy'.$ddg->id)){echo 'lm_invalid';}?>" />
                    <br>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="row" style="padding-bottom: 15px">
            <div class="col-md-6">
                <span><strong><?=$sl_count++?>.</strong> Field visit report & geo tagged photograph of the land</span>
                <?=form_error('field_report')?>
                <span class="<?php if(form_error('geo_tag_photo')){echo 'lm_invalid';}?>"></span>
                <?php
                if(isset($geo_tag_doc)){
                    echo form_error('geo_tag_photo');
                }else{
                    echo form_error('geo_tag_photo');
                }?>
            </div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="inputEmail4">Field report</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control <?php if(form_error('field_report')){echo 'lm_invalid';}?>"
                               type="file" name="field_report" id="field_report" accept=".png, .jpg, .jpeg, .pdf" />
                    </div>
                </div>

            </div>
        </div>



        <div class="row <?php if(form_error('land_exceed')){echo 'lm_invalid';}?>" style="padding-bottom: 15px">
            <div class="col-md-6">
                <?=form_error('land_exceed');?>
                <strong><?=$sl_count++?>.</strong> <span> LM remarks </span>
                <?=form_error('lm_note')?>
                <?=form_error('lm_remark_text')?>
            </div>
            <div class="col-md-6">
                <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>">
                    <?php  foreach(json_decode(LM_NOTE) as $lm_remark_cat): ?>
                        <option value="<?=$lm_remark_cat->CODE?>"><?=$lm_remark_cat->NAME?></option>
                    <?php  endforeach;  ?>
                </select>
                <br>
            </div>
        </div>

        <?php include(APPPATH."views/Relinquishment/include/unRegister/rejected_reasons.php"); ?>


        <div id="lm_remark_text_additional" class="row" style="padding-bottom: 15px; display: none;">
            <div class="col-md-3">
                <strong><?=$sl_count++?>.</strong> <span> NR remarks </span>
            </div>
            <div class="col-md-9">
                <textarea name="lm_remark_additional" placeholder="Enter remark..." class="form-control p-2 <?php if(form_error('lm_remark_additional')){echo 'lm_invalid';}?>" id="lm_remark_additional" rows="6" cols="40"><?php echo set_value('lm_remark_additional');?></textarea>
            </div>
        </div>

        <div id="lm_remark_text_id" class="row" style="padding-bottom: 15px; display: none;">
            <div class="col-md-3">
                <strong><?=$sl_count++?>.</strong> <span> Settlement remarks</span>
            </div>
            <div class="col-md-9">
                <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control p-2 <?php if(form_error('lm_remark_text')){echo 'lm_invalid';}?>" id="lm_remark_text" rows="12" cols="80"><?php echo set_value('lm_remark_text');?></textarea>
                <input id="validationcheck" type="hidden" class="validationcheck" value="" name="validationcheck" required/>
            </div>
        </div>


        <?php include(APPPATH."views/Relinquishment/include/unRegister/additional_file.php");  ?>
    </div>

</div>


<h5 class="reza-title" style="margin-top: 50px">
    <i class="fa fa-cog" aria-hidden="true"></i> Process Details
</h5>
<div class="reza-card ">
    <div class="reza-body">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12 labDiv" style="margin-bottom: 20px">
                <label for="sel1" class="lab" style="margin-bottom: 10px">
                    Application Register & Forward To<span style="color: red;font-weight: bold;"> *</span>
                </label>
                <select name="forwardTo"  class="form-control" id="forwardTo" required>
                    <option value="<?php echo RELINQUISHMENT_REGISTER_AND_FORWARD_TO ?>" >
                        <?php echo RELINQUISHMENT_REGISTER_AND_FORWARD_TO ?>
                    </option>
                </select>
            </div>


            <div class="col-lg-6 col-md-6 col-sm-12 labDiv" style="margin-bottom: 20px">
                <label for="sel1" class="lab" style="margin-bottom: 10px">
                    Select Circle Officer (CO)<span style="color: red;font-weight: bold;"> *</span>
                </label>
                <select class="form-control" name='co_code' required>
                    <option disabled selected>Select</option>
                    <?php foreach ($co_name as $coname) : ?>
                        <?php
                        $user_desig_code = $coname->user_desig_code;
                        $username        = $coname->username." ( ".$user_desig_code." )";
                        $user_code       = $coname->user_code;
                        ?>
                        <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                            if(set_value('co_code') == $user_code) {
                                echo "selected";
                            }
                        }?>>
                            <?=$username?>
                        </option>

                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv" style="margin-bottom: 20px">
                <label for="sel1" class="lab" style="margin-bottom: 10px">Remarks<span style="color: red;font-weight: bold;"> *</span></label>
                <textarea name="remarks" id="remarks" class="form-control" rows="4" required> </textarea>
            </div>
        </div>
    </div>
</div>







