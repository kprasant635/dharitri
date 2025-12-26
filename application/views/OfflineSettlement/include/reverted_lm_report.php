<?php $sl_count = 1?>

<form id="lmReportForm" method="POST" action="<?php echo base_url() ?>index.php/OfflineSettlementLMController/reReportOfRevertedOfflineSettlementLm" enctype="multipart/form-data">

    <input type="hidden" id="dist_code"   name="dist_code"   value="<?php echo $basic->dist_code; ?>">
    <input type="hidden" id="subdiv_code" name="subdiv_code" value="<?php echo $basic->subdiv_code; ?>">
    <input type="hidden" id="cir_code"    name="cir_code"    value="<?php echo $basic->cir_code; ?>">
    <input type="hidden" id="mouza_code"  name="mouza_code"  value="<?php echo $basic->mouza_pargona_code; ?>">
    <input type="hidden" id="lot_no"      name="lot_no"      value="<?php echo $basic->lot_no; ?>">
    <input type="hidden" id="vill_code"   name="vill_code"   value="<?php echo $basic->vill_townprt_code; ?>">
    <input type="hidden" id="service_code_lm" name="service_code" value="<?= $basic->service_code ?>">
    <input type="hidden" id ='case_no' name="case_no" value="<?=$case_no?>">
    <input type="hidden" id ='application_no' name="applid" value="<?=$case_no?>">
    <input type="hidden" name="uuid" id="uuid" value="<?=$basic->uuid ?>">
    <input type="hidden" name="lm_verification_date" id="lm_verification_date" value="<?= $geo_date ; ?>">
    <input type="hidden" name="occupation_applicant" id="occupation_applicant" value="<?= $basic->occupation_applicant ?>" class="form-control">


    <?php foreach($dags as $dagspremlm): ?>

        <input type="hidden" name='area_new<?=$dagspremlm->dag_no?>' id='area_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaCategory($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>

    <?php endforeach;?>

    <div class="tableCard lm-report" style="padding-bottom: 15px">
        <?php $i = 1;foreach ($lmnotes as $lmnote): ?>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                    <?=form_error('chitha_verified')?>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                               type="radio" name="chitha_verified" id="chiitha_verified1" value="YES"
                            <?php
                            if(isset($err_return))
                            {
                                if(set_value('chitha_verified') == "YES"){
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->chitha_verified) == "YES"){
                                    echo "checked";
                                }
                            }?>  required/>
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                               type="radio" name="chitha_verified" id="chiitha_verified2"  value="NO"
                            <?php
                            if(isset($err_return))
                            {
                                if(set_value('chitha_verified') == "NO"){
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->chitha_verified) == "NO"){
                                    echo "checked";
                                }
                            }?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php  foreach ($dags as $ddg) {
                        $patta_code = $this->utilityclass->getPattaTypeNo($ddg->dist_code,$ddg->subdiv_code,$ddg->cir_code,$ddg->mouza_pargona_code,$ddg->lot_no,$ddg->vill_townprt_code, $ddg->dag_no);
                        ?>
                        <i class="fa fa-link" aria-hidden="true"></i>
                        <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $ddg->dag_no . '&m=' . $ddg->mouza_pargona_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_townprt_code . '&p=' . $patta_code->patta_type_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>">
                            <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                        </a>
                        <br>
                    <?php }?>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> VLB Verified?</span>
                    <?=form_error('vlb_verified')?>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('vlb_verified')){echo 'lm_invalid';}?>"
                               type="radio"  name="vlb_verified" id="vlb_verified1" value="YES"
                            <?php
                            if(isset($err_return))
                            {
                                if(set_value('vlb_verified') == "YES"){
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->vlb_verified) == "YES"){
                                    echo "checked";
                                }
                            }?> required/>
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('vlb_verified')){echo 'lm_invalid';}?>"
                               type="radio" name="vlb_verified" id="vlb_verified2" value="NO"
                            <?php
                            if(isset($err_return))
                            {
                                if(set_value('vlb_verified') == "NO"){
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->vlb_verified) == "NO"){
                                    echo "checked";
                                }
                            }?>  />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php  foreach ($dags as $ddg) { ?>
                        <i class="fa fa-link" aria-hidden="true"></i>
                        <a target='VlbReport' href="<?php echo base_url() . 'index.php/SettlementTribal/vlbEncroacherDetails?dag=' . $ddg->dag_no . '&m=' . $ddg->mouza_pargona_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_townprt_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>" target="VlbReport">
                            <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (VLB)</span></u>
                        </a>
                        <br>
                    <?php }?>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span>
                    <?=form_error('bhumiputra_confirmation_lm')?>
                    <br>
                    <?php
                    if(trim($basic->bhumiputra_confirmation) == 'YES'){  ?>
                        <label for="" class="alert-warning">Certificate/Ack number : <b><?= $basic->bhumiputra_certificate_no ?></b></label>
                    <?php }else{ ?>
                        <label for="" class="alert-warning">Certificate Not Available!</b></label>
                    <?php } ?>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')){echo 'lm_invalid';}?>"
                               type="radio"  name="bhumiputra_confirmation_lm" id="bhumiputra_confirmation1" value="YES"
                            <?php if(isset($err_return))
                            {
                                if(set_value('bhumiputra_confirmation_lm') == YES)
                                {
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if(trim($lmnote->bhumiputra_confirmation) == YES)
                                {
                                    echo "checked";
                                }
                            }?> required/>
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')){echo 'lm_invalid';}?>"
                               type="radio" name="bhumiputra_confirmation_lm" id="bhumiputra_confirmation2" value="NO"
                            <?php if(isset($err_return))
                            {
                                if(set_value('bhumiputra_confirmation_lm') == NO)
                                {
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if(trim($lmnote->bhumiputra_confirmation) == NO)
                                {
                                    echo "checked";
                                }
                            }?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php if(trim($basic->bhumiputra_confirmation) == 'YES'){  ?>
                        <i class="fa fa-link" aria-hidden="true"></i>
                        <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                        if(trim($basic->bhumiputra_certificate_type) == 'CERT'){
                            echo "cer_number=".$basic->bhumiputra_certificate_no;
                        }else{
                            echo "ack_number=".$basic->bhumiputra_certificate_no;
                        }?>" target="BhumiPutra">
                            <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under Tribal Belt / Block.</span>
                    <?=form_error('is_tribal_belt')?>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">

                        <input class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                               type="radio" name="is_tribal_belt" id="whether_tribal1" value="YES"
                            <?php if(isset($err_return))
                            {
                                if(set_value('is_tribal_belt') == YES)
                                {
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->is_tribal_belt) == "YES")
                                {
                                    echo "checked";
                                }
                            }?> required/>
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                               type="radio"  name="is_tribal_belt" id="whether_tribal2" value="NO"
                            <?php if(isset($err_return))
                            {
                                if(set_value('is_tribal_belt') == NO)
                                {
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->is_tribal_belt) == NO)
                                {
                                    echo "checked";
                                }
                            }?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>

            <div class="row p-2">
                <div class="col-md-6 text-justify">
            <span><strong><?=$sl_count++?>.</strong>
                Does applicant falls under protected category?</span>
                    <?=form_error('protected_class_lm')?>
                </div>
                <div class="col-md-6 form-group">
                    <select name="protected_class_lm" id="protected_class_lm" class="form-control <?php if(form_error('protected_class_lm')){ echo 'lm_invalid';}?>" required>
                        <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                            <option value="<?php echo $class->CODE ?>" <?php
                            if(isset($err_return)){ if(set_value('protected_class_lm') == $class->CODE){ echo "selected"; }}else{ if(trim($lmnote->protected_class_lm) == $class->CODE){echo "selected";}}?>>
                                <?php echo $class->NAME ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
            <span>
                <strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ?
            </span>
                    <?=form_error('landslide')?>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input required class="form-check-input <?php if(form_error('landslide')){echo 'lm_invalid';}?>"
                               type="radio" name="landslide" id="landslide" value=<?=YES ?>
                               <?php if(isset($err_return))
                               {
                                   if(set_value('landslide') == YES)
                                   {
                                       echo "checked";
                                   }
                               }
                               else
                               {
                                   if (trim($lmnote->landslide) == "YES")
                                   {
                                       echo "checked";
                                   }
                               }
                               ?> >
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('landslide')){echo 'lm_invalid';}?>"
                               type="radio" name="landslide" id="landslide2" value=<?=NO ?>
                               <?php if(isset($err_return))
                               {
                                   if(set_value('landslide') == NO)
                                   {
                                       echo "checked";
                                   }
                               }
                               else
                               {
                                   if (trim($lmnote->landslide) == NO)
                                   {
                                       echo "checked";
                                   }
                               }
                               ?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
            <span>
                <strong><?=$sl_count++?>.</strong> Whether the land falls under erosion ?
            </span>
                    <?=form_error('erosion')?>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input required class="form-check-input <?php if(form_error('erosion')){echo 'lm_invalid';}?>"
                               type="radio" name="erosion" id="landslide" value=<?=YES?>
                               <?php if(isset($err_return))
                               {
                                   if(set_value('erosion') == YES)
                                   {
                                       echo "checked";
                                   }
                               }
                               else
                               {
                                   if (trim($lmnote->erosion) == YES)
                                   {
                                       echo "checked";
                                   }
                               }
                               ?> />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('erosion')){echo 'lm_invalid';}?>"
                               type="radio" name="erosion" id="landslide2" value=<?=NO?>
                               <?php if(isset($err_return))
                               {
                                   if(set_value('erosion') == NO)
                                   {
                                       echo "checked";
                                   }
                               }
                               else
                               {
                                   if (trim($lmnote->erosion) == NO)
                                   {
                                       echo "checked";
                                   }
                               }
                               ?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>

            <?php if($applicants_encroacher == true)
            {
                foreach($applicants_encroacher as $encroacher_ext){
                    ?>

                    <div class="row p-2" >
                        <div class="col-md-6">
                    <span>
                        <strong><?=$sl_count++?>.</strong>
                        Is Encroacher Exists in VLB for <strong><span class="alert-warning">Dag no <?=$encroacher_ext->dag_no?></span></strong>?
                    </span>
                            <?=form_error('encroacher_exist_vlb'.$encroacher_ext->id)?>

                        </div>
                        <div class="form-group col-md-6">
                            <select name="encroacher_exist_vlb<?=$encroacher_ext->id?>" id="encroacher_exist_vlb<?=$encroacher_ext->id?>"
                                    class="form-control clsencdata <?php if(form_error('encroacher_exist_vlb'.$encroacher_ext->id))
                                    {echo 'lm_invalid';}?>" required>

                                <?php
                                foreach(json_decode(ENC_VARIFICATION_LIST) as $enc_exist)
                                {
                                    ?>
                                    <option value="<?=$enc_exist->CODE?>" <?php if(isset($err_return)) {
                                        if(set_value('encroacher_exist_vlb'.$encroacher_ext->id) == $enc_exist->CODE){ echo "selected"; }}else{ if($encroacher_ext->encroacher_exist_vlb == $enc_exist->CODE){ echo "selected";}}?>>
                                        <?=$enc_exist->NAME?>
                                    </option>
                                    <?php
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <div class="row p-2">
                <div class="col-md-12 <?php if(form_error('encroacher_exist_vlb')){echo 'lm_invalid';}?>">
                    <strong><?=form_error('encroacher_exist_vlb')?></strong>
                </div>
            </div>

            <div class="row p-2">
                <div class="col-md-6">
            <span><strong><?=$sl_count++?>.</strong> Verify Schedule of the land and area under occupation
            </span>
                    <?=form_error('possession_verification')?>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('possession_verification')){echo 'lm_invalid';}?>"
                               type="radio" name="possession_verification" id="inlineRadio1" value="YES"
                            <?php if(isset($err_return))
                            {
                                if(set_value('possession_verification') == YES)
                                {
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->possession_verification) == YES)
                                {
                                    echo "checked";
                                }
                            }?> required/>
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('possession_verification')){echo 'lm_invalid';}?>"
                               type="radio" name="possession_verification" id="inlineRadio2" value="NO"
                            <?php if(isset($err_return))
                            {
                                if(set_value('possession_verification') == NO)
                                {
                                    echo "checked";
                                }
                            }
                            else
                            {
                                if (trim($lmnote->possession_verification) == NO)
                                {
                                    echo "checked";
                                }
                            }?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>

            <?php
            if ($display_old_nature_revert == 1)
            {
                foreach($dags as $nature_dag): ?>
                    <div class="row p-2 " >
                        <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Nature of possession for Dag no: <?=$nature_dag->dag_no?></span>
                            <?=form_error('nature_possession'.$nature_dag->dag_no)?>
                        </div>
                        <div class="form-group col-md-6">
                            <select name="nature_possession<?=$nature_dag->dag_no?>" id="nature_possession<?=$nature_dag->dag_no?>"
                                    class="form-control <?php if(form_error('nature_possession'.$nature_dag->dag_no)){ echo 'lm_invalid';}?>" >
                                <option value="Agricultural"
                                    <?php if(isset($err_return))
                                    {
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Agricultural"){
                                            echo "selected";
                                        }
                                    }
                                    else {
                                        if (trim($nature_dag->nature_possession) == "Agricultural") {
                                            echo "selected";
                                        }
                                    }?> > Agricultural
                                </option>

                                <option value="Residential"
                                    <?php if(isset($err_return))
                                    {
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Residential"){
                                            echo "selected";
                                        }
                                    }
                                    else {
                                        if (trim($nature_dag->nature_possession) == "Residential") {
                                            echo "selected";
                                        }
                                    }?> > Residential
                                </option>

                                <option value="Commercial"
                                    <?php if(isset($err_return))
                                    {
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Commercial"){
                                            echo "selected";
                                        }
                                    }
                                    else{
                                        if (trim($nature_dag->nature_possession) == "Commercial") {
                                            echo "selected";
                                        }
                                    }?> >Commercial
                                </option>

                                <option value="Others"
                                    <?php if(isset($err_return))
                                    {
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Others"){
                                            echo "selected";
                                        }
                                    }
                                    else{
                                        if (trim($nature_dag->nature_possession) == "Others") {
                                            echo "selected";
                                        }
                                    }?> > Others
                                </option>
                            </select>
                        </div>
                    </div>

                <?php
                endforeach;
            }
            else
            {
                foreach($dags as $nature_dag): ?>
                    <div class="row p-2 " >
                        <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Nature of possession for Dag no: <?=$nature_dag->dag_no?></span>
                            <?=form_error('nature_possession'.$nature_dag->dag_no)?>
                        </div>
                        <div class="form-group col-md-6">
                            <select name="nature_possession<?=$nature_dag->dag_no?>" id="nature_possession<?=$nature_dag->dag_no?>"
                                    class="form-control <?php if(form_error('nature_possession'.$nature_dag->dag_no)){ echo 'lm_invalid';}?>" >
                                <option value="Agricultural"
                                    <?php if(isset($err_return)){
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Agricultural"){
                                            echo "selected";
                                        }
                                    }else{
                                        if (trim($lmnote->nature_possession) == "Agricultural") {echo "selected";}
                                    }?>>
                                    Agricultural
                                </option>

                                <option value="Residential"
                                    <?php if(isset($err_return)){
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Residential"){
                                            echo "selected";
                                        }
                                    }else{
                                        if (trim($lmnote->nature_possession) == "Residential") {echo "selected";}
                                    }?>>
                                    Residential
                                </option>

                                <option value="Commercial"
                                    <?php if(isset($err_return)){
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Commercial"){
                                            echo "selected";
                                        }
                                    }else{
                                        if (trim($lmnote->nature_possession) == "Commercial") {echo "selected";}
                                    }?>>
                                    Commercial
                                </option>

                                <option value="Others"
                                    <?php if(isset($err_return)){
                                        if(set_value('nature_possession'.$nature_dag->dag_no) == "Others"){
                                            echo "selected";
                                        }
                                    }else{
                                        if (trim($lmnote->nature_possession) == "Others") {echo "selected";}
                                    }?>>
                                    Others
                                </option>
                            </select>
                        </div>
                    </div>

                <?php endforeach;
            }?>



            <?php
            include(APPPATH."views/OfflineSettlement/include/reverted_add_property_modal.php");
            ?>

            <?php if(ENABLE_CHECK_LAND != 0) {?>
                <!---// Land exist check modal --->
                <?php
                foreach ($applicants as $identity){
                    if($identity->is_applicant == 1){
                        $identity_type=$identity->identity_type;
                        $identity_ref_no=$identity->identity_ref_no;
                    }
                }
                ?>
                <div style="text-align: right">
                    <?php include(APPPATH."views/OfflineSettlement/include/land_check.php"); ?>
                </div>

                <!---// Land exist check modal end --->
            <?php } ?>

            <div class="row p-2">
                <div class="col-md-6 text-justify">
                <span>
                    <strong><?=$sl_count++?>.</strong> Category of the proposed land?
                </span>
                    <?=form_error('land_falls')?>
                </div>
                <div class="col-md-6 form-group">
                    <select required name="land_falls" id="land_falls" class="form-control <?php if(form_error('land_falls')){echo 'lm_invalid';}?>">
                        <option value="">Select...</option>
                        <?php foreach (json_decode(LB_NATURE_OF_RESERVATION) as $landCode): ?>
                            <option value="<?php echo $landCode->CODE ?>" <?php if(isset($err_return)){
                                if(set_value('land_falls') == $landCode->CODE){
                                    echo "selected";
                                }
                            }else{
                                if (trim($lmnote->land_falls) == $landCode->CODE) {echo "selected";}
                            }?>><?php echo $landCode->NAME ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
                <span>
                    <strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
                    15 KM radius from the periphery of GMC or within 5 KM periphery of other
                    town or within 3 KM periphery of Revenue town.
                </span>
                    <?=form_error('falls_und_gmc')?>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input required class="form-check-input <?php if(form_error('falls_und_gmc')){echo 'lm_invalid';}?>"
                               type="radio" name="falls_und_gmc" id="falls_und_gmc" value="YES"
                            <?php if(isset($err_return))
                            {
                                if(set_value('falls_und_gmc') == YES) {echo "checked";}
                            }
                            else
                            {
                                if (trim($lmnote->falls_und_gmc) == "YES") {echo "checked";}
                            }?> />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?php if(form_error('falls_und_gmc')){echo 'lm_invalid';}?>"
                               type="radio" name="falls_und_gmc" id="falls_und_gmc" value="NO"
                            <?php if(isset($err_return))
                            {
                                if(set_value('falls_und_gmc') == NO){echo "checked";}
                            }
                            else
                            {
                                if (trim($lmnote->falls_und_gmc) == "NO") {echo "checked";}
                            }?> />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                    <div id="forcedurban" style="display:none">
                        <div style="padding: 15px; background-color: #f44336; color: white;">
                            <strong>If you select Yes then this case is considered as Urban case.</strong>
                        </div>

                    </div>
                </div>
            </div>

            <?php if ($reservation == true) {?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <span>
                            <strong><?=$sl_count++?>.</strong>
                            Specific comment on roadside /riverside reservation (if any, along with provision kept for
                            road/drain wherever necessary)
                        </span>

                        <?=form_error('roadside_comment_check')?>
                        <!-- this only to display the error message in area validation -->
                        <span class="<?php if(form_error('reserveMoreThanAppArea')) {
                            echo 'lm_invalid';
                        }?>"></span>
                        <?=form_error('reserveMoreThanAppArea');?>
                        <?php
                        foreach($reservation as $dags_roaside)
                        {
                            echo form_error('reserved_bigha'.$dags_roaside->dag_no);
                            echo form_error('reserved_katha'.$dags_roaside->dag_no);
                            echo form_error('reserved_lessa'.$dags_roaside->dag_no);
                            echo form_error('reserved_ganda'.$dags_roaside->dag_no);
                            echo form_error('reserved_kranti'.$dags_roaside->dag_no);
                        }
                        ?>
                    </div>
                    <div class="col-md-6">

                        <div class="form-check form-check-inline">
                            <input type="radio" onclick="roadSideReservYes();" class="form-check-input roadside_comment_check1 <?php if(form_error('roadside_comment_check')) {
                                echo 'lm_invalid';
                            }?>" name="roadside_comment_check" id="roadside_comment_check1" value="YES"
                                <?php  if(isset($err_return)){
                                    if(set_value('roadside_comment_check') == 'YES') {
                                        echo "checked";
                                    }
                                }
                                else{
                                    if($reservation == true) {
                                        echo "checked";
                                    }
                                }?>>
                            <label for="roadside">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio"  onclick="roadSideReservNo();" class="form-check-input roadside_comment_check2 <?php if(form_error('roadside_comment_check')) {
                                echo 'lm_invalid';
                            }?>" name="roadside_comment_check" id="roadside_comment_check2" value="NO"
                                <?php if(isset($err_return)){
                                    if(set_value('roadside_comment_check') == 'NO') {
                                        echo "checked";
                                    }
                                }
                                else{
                                    if($reservation != true) {
                                        echo "checked";
                                    }
                                } ?>>
                            <label for="roadside">No</label>
                        </div>

                        <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                            <?php foreach ($reservation as $reserv_road) {
                                if ($reserv_road->type == "R") {?>

                                    <div class="form-group row mt-2">
                                        <input type="hidden" value="<?=$reserv_road->dag_no?>" class="form-control input-sm" name="reserved_dag_road<?=$reserv_road->dag_no?>" id="reserved_dag_road">
                                        <input type="hidden" value="<?=$reserv_road->patta_no?>" class="form-control input-sm" name="reserved_patta_road<?=$reserv_road->dag_no?>" >

                                        <input type="hidden" name="dag_no<?=$reserv_road->dag_no?>" value="<?=$reserv_road->dag_no?>">
                                        <label for="area-reserved" class="mb-2"><b>Enter road side reserve area in Dag No: <?=$reserv_road->dag_no?></b></label>
                                        <div class="col-4">
                                            <span class="input-group-addon">Bigha</span>
                                            <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;"
                                                   value="<?php if(isset($err_return)){ echo set_value('reserved_bigha'.$reserv_road->dag_no);}
                                                   else{ echo $reserv_road->bigha;}?>" class="form-control input-sm road_reserve_ifno_zero
                                                   <?php if(form_error('reserved_bigha')){ echo 'lm_invalid';}?>"
                                                   name="reserved_bigha<?=$reserv_road->dag_no?>" id="reserved_bigha<?=$reserv_road->dag_no?>">

                                            <?=form_error('reserved_bigha'.$reserv_road->dag_no)?>
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-addon">Katha</span>
                                            <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;"
                                                   value="<?php if(isset($err_return)){ echo set_value('reserved_katha'.$reserv_road->dag_no);}
                                                   else{ echo $reserv_road->katha;}?>" class="form-control input-sm road_reserve_ifno_zero
                                                   <?php if(form_error('reserved_katha')){ echo 'lm_invalid';}?>"
                                                   name="reserved_katha<?=$reserv_road->dag_no?>" id="reserved_katha<?=$reserv_road->dag_no?>" >

                                            <?=form_error('reserved_katha'.$reserv_road->dag_no)?>
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-addon">Lessa</span>
                                            <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;"
                                                   value="<?php if(isset($err_return)){ echo set_value('reserved_lessa'.$reserv_road->dag_no);}
                                                   else{ echo $reserv_road->lessa;}?>" class="form-control input-sm road_reserve_ifno_zero
                                                   <?php if(form_error('reserved_lessa')){ echo 'lm_invalid';}?>"
                                                   name="reserved_lessa<?=$reserv_road->dag_no?>" id="reserved_lessa<?=$reserv_road->dag_no?>" >

                                            <?=form_error('reserved_lessa'.$reserv_road->dag_no)?>
                                        </div>
                                    </div>
                                    <?php if ((in_array($dist_code, json_decode(BARAK_VALLEY)))): ?>
                                        <div class="form-group row mt-2">
                                            <div class="col-4">
                                                <span class="input-group-addon">Ganda</span>
                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;"
                                                       value="<?php if(isset($err_return)){ echo set_value('reserved_ganda'.$reserv_road->dag_no);}
                                                       else{ echo $reserv_road->ganda;}?>" class="form-control input-sm road_reserve_ifno_zero
                                                       <?php if(form_error('reserved_ganda')){ echo 'lm_invalid';}?>" name="reserved_ganda<?=$reserv_road->dag_no?>" id="reserved_ganda<?=$reserv_road->dag_no?>">

                                                <?=form_error('reserved_ganda'.$reserv_road->dag_no)?>
                                            </div>
                                            <div class="col-4 hide">
                                                <span class="input-group-addon">Kranti</span>
                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;"
                                                       value="<?php if(isset($err_return)){ echo set_value('reserved_kranti'.$reserv_road->dag_no);}
                                                       else{ echo $reserv_road->kranti;}?>" class="form-control input-sm road_reserve_ifno_zero
                                                       <?php if(form_error('reserved_kranti')){ echo 'lm_invalid';}?>" name="reserved_kranti<?=$reserv_road->dag_no?>" id="reserved_kranti<?=$reserv_road->dag_no?>">

                                                <?=form_error('reserved_kranti'.$reserv_road->dag_no)?>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                <?php }}?>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="roadside">Comment(if any)</label>
                                    <textarea name="roadside_reservation" id="roadside_reservation" class="form-control" rows="2">
                                        <?=$lmnote->roadside_reservation?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            else{ ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                                 <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                 /riverside reservation (if any, along with provision kept for road/drain
                                 wherever necessary)</span>
                        <?=form_error('roadside_comment_check')?>
                        <!-- this only to display the error message in area validation -->
                        <span class="<?php if(form_error('reserveMoreThanAppArea')) {
                            echo 'lm_invalid';
                        }?>"></span>
                        <?=form_error('reserveMoreThanAppArea');?>
                        <?php
                        foreach($dags as $dags_roaside) {
                            echo form_error('reserved_bigha'.$dags_roaside->dag_no);
                            echo form_error('reserved_katha'.$dags_roaside->dag_no);
                            echo form_error('reserved_lessa'.$dags_roaside->dag_no);
                            echo form_error('reserved_ganda'.$dags_roaside->dag_no);
                            echo form_error('reserved_kranti'.$dags_roaside->dag_no);
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="radio" onclick="roadSideReservYes();" class="form-check-input roadside_comment_check1 <?php if(form_error('roadside_comment_check')) {
                                echo 'lm_invalid';
                            }?>" name="roadside_comment_check" id="roadside_comment_check1" value="YES" <?php
                            if(isset($err_return)){
                                if(set_value('roadside_comment_check') == 'YES') {
                                    echo "checked";
                                }
                            }else{
                                if($reservation == true) {
                                    echo "checked";
                                }
                            }?>>
                            <label for="roadside">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio"  onclick="roadSideReservNo();" class="form-check-input roadside_comment_check2 <?php if(form_error('roadside_comment_check')) {
                                echo 'lm_invalid';
                            }?>" name="roadside_comment_check" id="roadside_comment_check2" value="NO" <?php
                            if(isset($err_return)){
                                if(set_value('roadside_comment_check') == 'NO') {
                                    echo "checked";
                                }
                            }else{
                                if($reservation != true) {
                                    echo "checked";
                                }
                            } ?>>
                            <label for="roadside">No</label>
                        </div>
                        <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                            <?php foreach($dags as $dags_roadside) { ?>
                                <div class="form-group row mt-2">
                                    <input type="hidden" value="<?=$dags_roadside->dag_no?>" class="form-control input-sm" name="reserved_dag_road<?=$dags_roadside->dag_no?>" id="reserved_dag_road">
                                    <input type="hidden" value="<?=$dags_roadside->patta_no?>" class="form-control input-sm" name="reserved_patta_road<?=$dags_roadside->dag_no?>" id="reserved_patta_road">
                                    <label for="area-reserved" class="mb-2"><b>Enter road side reserve area in Dag No: <?=$dags_roadside->dag_no?></b></label>
                                    <div class="col-4">
                                        <span class="input-group-addon">Bigha</span>
                                        <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                            echo set_value('reserved_bigha'.$dags_roadside->dag_no);
                                        } else {
                                            echo "0";
                                        }?>" class="road_reserve_ifno_zero form-control input-sm <?php if(form_error('reserved_bigha'.$dags_roadside->dag_no)) {
                                            echo 'lm_invalid';
                                        }?>" name="reserved_bigha<?=$dags_roadside->dag_no?>" id="reserved_bigha<?=$dags_roadside->dag_no?>">
                                    </div>
                                    <div class="col-4">
                                        <span class="input-group-addon">Katha</span>
                                        <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                            echo set_value('reserved_katha'.$dags_roadside->dag_no);
                                        } else {
                                            echo "0";
                                        }?>" class="road_reserve_ifno_zero form-control input-sm <?php if(form_error('reserved_katha'.$dags_roadside->dag_no)) {
                                            echo 'lm_invalid';
                                        }?>" name="reserved_katha<?=$dags_roadside->dag_no?>" id="reserved_katha<?=$dags_roadside->dag_no?>" >
                                    </div>
                                    <div class="col-4">
                                        <span class="input-group-addon"><?php if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))): ?>  Chatak <?php else :?> Lessa <?php endif ;?></span>
                                        <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                            echo set_value('reserved_lessa'.$dags_roadside->dag_no);
                                        } else {
                                            echo "0";
                                        }?>" class="road_reserve_ifno_zero form-control input-sm <?php if(form_error('reserved_lessa'.$dags_roadside->dag_no)) {
                                            echo 'lm_invalid';
                                        }?>" name="reserved_lessa<?=$dags_roadside->dag_no?>" id="reserved_lessa<?=$dags_roadside->dag_no?>" >
                                    </div>
                                </div>
                                <?php if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))): ?>
                                    <div class="form-group row mt-2">
                                        <div class="col-4">
                                            <span class="input-group-addon">Ganda</span>
                                            <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                echo set_value('reserved_ganda'.$dags_roadside->dag_no);
                                            } else {
                                                echo "0";
                                            }?>" class="road_reserve_ifno_zero form-control input-sm <?php if(form_error('reserved_ganda'.$dags_roadside->dag_no)) {
                                                echo 'lm_invalid';
                                            }?>" name="reserved_ganda<?=$dags_roadside->dag_no?>" id="reserved_ganda<?=$dags_roadside->dag_no?>">
                                        </div>
                                        <div class="col-4 hide">
                                            <span class="input-group-addon">Kranti</span>
                                            <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                echo set_value('reserved_kranti'.$dags_roadside->dag_no);
                                            } else {
                                                echo "0";
                                            }?>" class="road_reserve_ifno_zero form-control input-sm <?php if(form_error('reserved_kranti'.$dags_roadside->dag_no)) {
                                                echo 'lm_invalid';
                                            }?>" name="reserved_kranti<?=$dags_roadside->dag_no?>" id="reserved_kranti<?=$dags_roadside->dag_no?>">
                                        </div>
                                    </div>
                                <?php endif ;?>
                            <?php } ?>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="roadside">Reserved area remarks(if any)</label>
                                    <textarea
                                            name="roadside_reservation"
                                            id="roadside_reservation"
                                            class="form-control"
                                            rows="2"
                                    ><?php if(isset($err_return)) {
                                            echo set_value('roadside_reservation');
                                        }?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>



            <?php
            foreach($dags as $landmark_dag):
                if($landmark_dag->landmark != null)
                {
                    $landmark = json_decode($landmark_dag->landmark);
                    ?>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <label for="">
                                <strong><?=$sl_count++?>.</strong>
                                Landsmark
                                <span class="alert-warning">for Dag no. <?=$landmark_dag->dag_no?></span>
                            </label>
                            <?=form_error('landmark_east'.$landmark_dag->dag_no)?>
                            <?=form_error('landmark_west'.$landmark_dag->dag_no)?>
                            <?=form_error('landmark_north'.$landmark_dag->dag_no)?>
                            <?=form_error('landmark_south'.$landmark_dag->dag_no)?>
                        </div>
                        <div class="col-md-3">
                            <label for="">East side landmark</label>
                            <textarea name="landmark_east<?=$landmark_dag->dag_no?>" placeholder="Enter East Landmark" id="landmark_east<?=$landmark_dag->dag_no?>" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east')){ echo 'lm_invalid';}?>"><?php if(isset($err_return)){ echo set_value('landmark_east'.$landmark_dag->dag_no);}else{ echo $landmark->east;}?></textarea>
                            <label for="">West side landmark</label>
                            <textarea name="landmark_west<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_west')){ echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="landmark_west<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_west'.$landmark_dag->dag_no);}else{ echo $landmark->west;}?></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="">North side landmark</label>
                            <textarea name="landmark_north<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_north')){ echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="landmark_north<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_north'.$landmark_dag->dag_no);}else{ echo $landmark->north;}?></textarea>
                            <label for="">South side landmark</label>
                            <textarea name="landmark_south<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_south')){ echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="landmark_south<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_south'.$landmark_dag->dag_no);}else{ echo $landmark->south;}?></textarea>
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <label for="">
                                <strong><?=$sl_count++?>.</strong>
                                Landsmark
                                <span class="alert-warning">for Dag no. <?=$landmark_dag->dag_no?></span>
                            </label>
                            <?=form_error('landmark_east'.$landmark_dag->dag_no)?>
                            <?=form_error('landmark_west'.$landmark_dag->dag_no)?>
                            <?=form_error('landmark_north'.$landmark_dag->dag_no)?>
                            <?=form_error('landmark_south'.$landmark_dag->dag_no)?>
                        </div>
                        <div class="col-md-3">
                            <label for="">East side landmark</label>
                            <textarea name="landmark_east<?=$landmark_dag->dag_no?>" placeholder="Enter East Landmark" id="landmark_east<?=$landmark_dag->dag_no?>" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east')){ echo 'lm_invalid';}?>"><?php if(isset($err_return)){ echo set_value('landmark_east'.$landmark_dag->dag_no);}?></textarea>
                            <label for="">West side landmark</label>
                            <textarea name="landmark_west<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_west')){ echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="landmark_west<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_west'.$landmark_dag->dag_no);}?></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="">North side landmark</label>
                            <textarea name="landmark_north<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_north')){ echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="landmark_north<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_north'.$landmark_dag->dag_no);}?></textarea>
                            <label for="">South side landmark</label>
                            <textarea name="landmark_south<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_south')){ echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="landmark_south<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_south'.$landmark_dag->dag_no);}?></textarea>
                        </div>
                    </div>
                    <?php
                }
            endforeach;


            ?>
            <div class="row p-2 <?php if(form_error('land_exceed')){echo 'lm_invalid';}?>">
                <div class="col-md-6">
                    <?=form_error('land_exceed');?>
                    <span><strong><?=$sl_count++?>.</strong> LM remarks </span>
                </div>
                <div class="col-md-6">
                    <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>">
                        <?php
                        foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                            ?>
                            <option value="<?=$lm_remark_cat->CODE?>"
                                <?php if(isset($err_return)){
                                    if(set_value('lm_note') == $lm_remark_cat->CODE)
                                    {
                                        echo "selected";
                                    }
                                }
                                else
                                {
                                    if(trim($lmnote->lm_note) == $lm_remark_cat->CODE){
                                        echo 'selected';
                                    }
                                }?>>
                                <?=$lm_remark_cat->NAME?>
                            </option>
                            <?php
                        }?>
                    </select>
                </div>
            </div>

            <?php
            include(APPPATH."views/OfflineSettlement/include/rejected_reasons.php");
            ?>

            <div class="row p-2justify-content-end mt-2">
                <div class="col-md-12">
                    <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="13">
                        <?php if(isset($err_return))
                        {
                            echo set_value('lm_remark_text');
                        }
                        else
                        {

                        }?>
                    </textarea>
                </div>
            </div>
            <br>
        <?php endforeach;?>


        <div class="row p-2" id="sk_for_reject">
            <div class="col-md-6">
                <strong><?=$sl_count++?>.</strong>
                <?php
                echo "<label>Select Circle Officer (CO)</label>";

                ?>
                <?=form_error('co_code')?>
            </div>
            <div class="col-md-6">
                <select required class="form-control <?php if(form_error('co_code')) { echo 'lm_invalid';}?>" name='co_code'>
                    <option value="" selected disabled>Select Circle Officer...</option>
                    <?php foreach ($co_name as $coname)
                    {
                        $user_desig_code = $coname->user_desig_code;
                        $username = $coname->username." ( ".$user_desig_code." )";
                        $user_code = $coname->user_code;
                        ?>
                        <option value="<?=$user_code?>"
                            <?php if(isset($err_return))
                            {
                                if(set_value('co_code') == $user_code)
                                {
                                    echo "selected";
                                }
                            }?>>
                            <?=$username?>
                        </option>

                    <?php } ?>
                </select>
                <br>
            </div>
        </div>


        <div class="row p-2">
            <div class="col-md-6">
                <strong><?=$sl_count++?>.</strong> Premium</label>
                <?=form_error('co_code')?>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td width="50%" style="font-weight: bold"> Total Premium (Rs) </td>
                        <td width="50%" style="font-weight: bold"> Premium Due (Rs) </td>
                    </tr>
                    <tr>
                        <td><span id="lmfinalamountupdated"> <?=isset($premiumData->final_amount)? $premiumData->final_amount:0;?></span></td>
                        <td><span id="lmdueamountupdated"> <?=isset($premiumData->due_amount)? $premiumData->due_amount:0;?></span></td>
                    </tr>
                </table>
                <input id="validationcheck" type="hidden" class="validationcheck" value="<?php if(isset($err_return)){ echo set_value('validationcheck');}else{ echo "1"; } ?>" name="validationcheck"/>
            </div>
        </div>

        <div class="row p-2">
            <div class="col-md-6">
                <strong><?=$sl_count++?>.</strong>
                <label for="title">Do you want to change the premium?</label>
                <?=form_error('prem_update')?>
                <?=form_error('validationcheck')?>
            </div>
            <div class="col-md-6">
                <input type="radio" id="prem_update1" name="prem_update" class="prem_update <?php if(form_error('prem_update') || form_error('validationcheck')){ echo 'lm_invalid';}?>" value="YES">
                <label for="html">YES</label>
                &nbsp;
                <input type="radio" id="prem_update2" name="prem_update" class="prem_update <?php if(form_error('prem_update') || form_error('validationcheck')){ echo 'lm_invalid';}?>" value="NO">
                <label for="css">NO</label><br><br>
                <button id="chngPremButton" style="margin-top: 1px; display:none" type="button" class="rezaButt buttPrimary"
                        onclick="premiumModal()">
                    Change Premium
                </button>
            </div>
        </div>


        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-file-pdf-o"></i> Uploaded Documents
        </h5>

        <div class="tableCard">
            <table class="table table-bordered" >
                <tr>
                    <th style="width: 10%;">SL No.</th>
                    <th style="width: 60%;">File Name</th>
                    <th style="width: 30%;">Download</th>
                </tr>
                <tbody>
                <?php $j=1; foreach ($documentsLm as $document): ?>
                    <tr>
                        <td><?php echo $j ?></td>
                        <td><?php echo $document->file_name ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>index.php/OfflineSettlementCommonController/getViewSupportiveDocs/?fileId=<?php echo $document->id; ?>"
                               class="rezaButt buttCust btn-sm " target="ViewDocument">
                                <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download
                            </a>

                        </td>
                    </tr>
                    <?php $j=$j+1; endforeach;?>
                </tbody>
            </table>
        </div>

        <?php include(APPPATH."views/OfflineSettlement/include/add_more_document.php");  ?>



        <!--------------------khas lnd lm report end------>
    </div>

    <!-- new premium addition -->
    <?php
    include(APPPATH."views/OfflineSettlement/include/premium_calculation_modal.php");
    ?>


    <!-- LM template start -->
    <?php
    if($applicants_encroacher == true){
        foreach($applicants_encroacher as $riotee){
            $posdate=$riotee->period_possession;
        }
    }else{
        $posdate="";
    }
    $barak_ad_prop_total="";
    $aditional_prop_total="";
    if (isset($additional_property)){

        if(isset($total_aditional_area_g)){
            // var_dump($total_aditional_area_g[0]); die;
            if(isset($total_aditional_area)){
                $barak_ad_prop_1 =" আৰু ";
            }else{
                $barak_ad_prop_1 ="";
            }
            $barak_ad_prop=$total_aditional_area_g[0]." বি " .$total_aditional_area_g[1]. " ক " .$total_aditional_area_g[2]. " লে " .$total_aditional_area_g[3]. " গ ভূমি থকা";
            $barak_ad_prop_total = $barak_ad_prop_1. $barak_ad_prop;
        }


        if(isset($total_aditional_area)){
            $ad_area1=$total_aditional_area[0]."বি ,".$total_aditional_area[1]. "ক ,".$total_aditional_area[2]."লে ভূমি থকা";
            $aditional_prop_total = $aditional_prop_total.$ad_area1;
        }
        // var_dump($aditional_prop_total); die;

    }else{
        $aditional_prop_total="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
    }

    foreach ($dags as $dag_urban) {
        if($dag_urban->is_urban=="Y"){
            $lmtown="টাউনৰ অন্তৰ্গত ";
            $lmposession="ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ / আৰ চি চিঘৰ ) ";
            $lmposdate="২৮ জুন, ২০০১ চনৰ ";
        }else{
            $lmtown="";
            $lmposession="ঘৰবস্তী / খেতি-বাতি ";
            $lmposdate=$posdate;
        }
    }
    ?>
    <?php
    if((in_array($dist_code, json_decode(BARAK_VALLEY)))){
        if(isset($property) && !empty($property)) {
            $resultprop = array();
            foreach($property as $isproperty):
                $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে " .$isproperty->ganda. " গ";
            endforeach;
            $aditional_prop_temp=implode(",",$resultprop);
            $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
        }
        else {
            $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
        }
    }else{
        if(isset($property) && !empty($property)) {
            $resultprop = array();
            foreach($property as $isproperty):
                $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে";
            endforeach;
            $aditional_prop_temp=implode(",",$resultprop);
            $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
        }
        else {
            $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
        }
    }
    ?>
    <?php
    if((in_array($dist_code, json_decode(BARAK_VALLEY)))){
        $resultdags = array();
    foreach($applicants_encroacher as $dags_lmtemplate){
        $resultdags[] = $dags_lmtemplate->dag_no;
        foreach ($applicants as $settlement){
            if($settlement->is_applicant == 1){
                $app_name=$settlement->pdar_name;
            }
        }?>
    <input type="hidden" id="sbigha" name='sbigha'>
    <input type="hidden" id="skatha" name='skatha'>
    <input type="hidden" id="slessa" name='slessa'>
    <input type="hidden" id="sganda" name='sganda'>
    <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
    <input type="hidden" id="alloted_katha" name='alloted_katha'>
    <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
    <input type="hidden" id="alloted_ganda" name='alloted_ganda'>
        <script>
            function totalAppliedArea(){
                var total_area = 0;
                var mbigha = parseFloat($("#total_applied_home_bigha").val());
                var mkatha = parseFloat($("#total_applied_home_katha").val());
                var mlessa = parseFloat($("#total_applied_home_lessa").val());
                var mganda = parseFloat($("#total_applied_home_ganda").val());
                var abigha = parseFloat($("#total_applied_agri_bigha").val());
                var akatha = parseFloat($("#total_applied_agri_katha").val());
                var alessa = parseFloat($("#total_applied_agri_lessa").val());
                var aganda = parseFloat($("#total_applied_agri_ganda").val());
                var total_home = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
                var total_agri = ((abigha * 6400) + (akatha * 320) + (alessa * 20) + aganda);
                var total_area = total_home + total_agri;


                var bigha_r = Math.floor(total_area / 6400);
                var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
                var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
                var ganda_r = (total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20).toFixed(2);

                $("#sbigha").val(bigha_r);
                $("#skatha").val(katha_r);
                $("#slessa").val(lessa_r);
                $("#sganda").val(ganda_r);

                var total_road_reserved = 0;
                var total_lm_reserved = 0;
                var total_family_reserved = 0;
                var total_lm_family_reserved = 0;
                <?php foreach($applicants_encroacher as $dags_lmtemplate3){ ?>

                var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var road_ganda=$("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                total_lm_reserved = total_lm_reserved + total_road_reserved;

                var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var family_ganda=$("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                <?php } ?>

                var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                var alloted_bigha = Math.floor(total_alloted_area / 6400);
                var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 6400) / 320);
                var alloted_lessa = Math.floor((total_alloted_area - (alloted_bigha * 6400) - (alloted_katha * 320)) / 20);
                var alloted_ganda = (total_alloted_area - alloted_bigha * 6400 - alloted_katha * 320 - alloted_lessa * 20).toFixed(2);
                // alert(total_alloted_area);
                $("#alloted_bigha").val(alloted_bigha);
                $("#alloted_katha").val(alloted_katha);
                $("#alloted_lessa").val(alloted_lessa);
                $("#alloted_ganda").val(alloted_ganda);

            }
        </script>
    <?php }
    $all_dags=implode(",",$resultdags); ?>
    <?php } else{
    $resultdags = array();
    foreach($applicants_encroacher as $dags_lmtemplate){
    $resultdags[] = $dags_lmtemplate->dag_no;
    foreach ($applicants as $settlement){
        if($settlement->is_applicant == 1){
            $app_name=$settlement->pdar_name;
        }
    } ?>
    <input type="hidden" id="sbigha" name='sbigha'>
    <input type="hidden" id="skatha" name='skatha'>
    <input type="hidden" id="slessa" name='slessa'>
    <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
    <input type="hidden" id="alloted_katha" name='alloted_katha'>
    <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
        <script>
            function totalAppliedArea(){
                var total_area = 0;
                var mbigha = parseFloat($("#total_applied_home_bigha").val());
                var mkatha = parseFloat($("#total_applied_home_katha").val());
                var mlessa = parseFloat($("#total_applied_home_lessa").val());
                var abigha = parseFloat($("#total_applied_agri_bigha").val());
                var akatha = parseFloat($("#total_applied_agri_katha").val());
                var alessa = parseFloat($("#total_applied_agri_lessa").val());
                var total_home = ((mbigha * 100) + (mkatha * 20) + mlessa);
                var total_agri = ((abigha * 100) + (akatha * 20) + alessa);
                var total_area = total_home + total_agri;


                var bigha_r = Math.floor(total_area / 100);
                var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                $("#sbigha").val(bigha_r);
                $("#skatha").val(katha_r);
                $("#slessa").val(lessa_r);

                var total_road_reserved = 0;
                var total_lm_reserved = 0;
                var total_family_reserved = 0;
                var total_lm_family_reserved = 0;
                <?php foreach($applicants_encroacher as $dags_lmtemplate3){ ?>
                var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                total_lm_reserved = total_lm_reserved + total_road_reserved;

                var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                <?php } ?>
                // alert(total_lm_family_reserved);
                var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                var alloted_bigha = Math.floor(total_alloted_area / 100);
                var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 100) / 20);
                var alloted_lessa = total_alloted_area - alloted_bigha * 100 - alloted_katha * 20;
                // alert(total_alloted_area);
                $("#alloted_bigha").val(alloted_bigha);
                $("#alloted_katha").val(alloted_katha);
                $("#alloted_lessa").val(alloted_lessa);

            }
        </script>
    <?php }
        $all_dags=implode(",",$resultdags);
    }
    ?>

    <div class="row" style="margin-top: 40px">
        <div class="col-lg-12" align="right">
            <button type="button" class="rezaButt buttInfo"  id="applicationSubmit">
                <i class="fa fa-check-square-o" aria-hidden="true"></i> Save & Submit
            </button>
        </div>
    </div>


</form>


<!-- Modal submit application -->
<div class="modal" role="dialog" id="reportSubmitApplicationModal" style="z-index: 999999999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to submit report & Forward to CO </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="reportSubmitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="reportSubmitApplicationModalYes">Yes, Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


    // application submit confirmation
    $(document).on('click','#applicationSubmit',function ()
    {
        $('#reportSubmitApplicationModal').modal('show');
    });

    $(document).on('click','#reportSubmitApplicationModalNo',function ()
    {
        $('#reportSubmitApplicationModal').modal('hide');
    });

    // application submit
    $(document).on('click','#reportSubmitApplicationModalYes',function ()
    {
        $('#lmReportForm').submit();
        $('#reportSubmitApplicationModal').modal('hide');
    });


    $(document).ready(function () {
        var selectedRemarkCode=$('#lm_remark').val();
        if(selectedRemarkCode == 1){
            <?php
            if(isset($err_return)){
            ?>
            $('#lm_remark_text_id').show();
            <?php
            }
            ?>
        }
        if(selectedRemarkCode == 2){
            <?php
            if(isset($err_return)){
            ?>
            $('#lm_remark_text_id').show();
            <?php
            }
            ?>
        }
    });

    $("#lm_remark").change(function (event) {


        var selectedRemark=$(this).val();

        if(selectedRemark==1)
        {
            $('#lm_remark_text_id').show();

            // alert("You have Selected  :: "+selectedRemark);
            totalAppliedArea();
            $('#lm_remark_text').text('');
            <?php if((in_array($dist_code, json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code)?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?>ৰ <?php echo $this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা যায়।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code)?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?>ৰ <?php echo $this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে পট্টন দিব পৰা যায়।");
            <?php endif ;?>

        }
        else if(selectedRemark==2)
        {
            $('#lm_remark_text_id').show();
            totalAppliedArea();
            $('#lm_remark_text').text('');
            <?php if((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code)?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?>ৰ <?php echo $this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক নহয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা নাযায়।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code)?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?>ৰ <?php echo $this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক নহয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে পট্টন দিব পৰা নাযায়।");
            <?php endif ;?>

        }else{
            $('#lm_remark_text').text('');
            $('#lm_remark_text_id').hide();

        }
    });


</script>
<!-- Encroacher modal -->
<script src="<?php echo base_url();?>js/jAlert-v3.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jAlert-v3.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- css for datatable -->
<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>



<script>
    <?php
    if((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))){
    ?>
    function totalAreaCal(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseFloat($("#mbigha"+i).val());
            var mkatha = parseFloat($("#mkatha"+i).val());
            var mlessa = parseFloat($("#mlessa"+i).val());
            var mganda = parseFloat($("#mganda"+i).val());

            var total_area = total_area + ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
        }

        var bigha_r = Math.floor(total_area / 6400);
        var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
        var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
        var ganda_r = total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);
        $("#total_applied_home_ganda").val(ganda_r);
    }

    function agriArea(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
            var mkatha_agri = parseFloat($("#agri_katha"+i).val());
            var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
            var mganda_agri = parseFloat($("#agri_ganda"+i).val());

            var total_agri_area = total_agri_area + ((mbigha_agri * 6400) + (mkatha_agri * 320) + (mlessa_agri * 20) + mganda_agri);
        }

        var bigha_agri = Math.floor(total_agri_area / 6400);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 6400) / 320);
        var lessa_agri = Math.floor((total_agri_area - (bigha_agri * 6400) - (katha_agri * 320)) / 20);
        var ganda_agri = total_agri_area - bigha_agri * 6400 - katha_agri * 320 - lessa_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
        $("#total_applied_agri_ganda").val(ganda_agri);
    }

    function fisheryArea(){
        // for agri
        var bigha_fish = 0;
        var katha_fish = 0;
        var lessa_fish = 0;
        var length_fish = <?=$total_area_fbigha?>;
        var total_fish_area = 0;
        for(i=1; i<length_fish; i++){
            var mbigha_fish = parseFloat($("#fbigha"+i).val());
            var mkatha_fish = parseFloat($("#fkatha"+i).val());
            var mlessa_fish = parseFloat($("#flessa"+i).val());
            var mganda_fish = parseFloat($("#fganda"+i).val());

            var total_fish_area = total_fish_area + ((mbigha_fish * 6400) + (mkatha_fish * 320) + (mlessa_fish * 20) + mganda_fish);
        }

        var bigha_fish = Math.floor(total_fish_area / 6400);
        var katha_fish = Math.floor((total_fish_area - bigha_fish * 6400) / 320);
        var lessa_fish = Math.floor((total_fish_area - (bigha_fish * 6400) - (katha_fish * 320)) / 20);
        var ganda_fish = total_fish_area - bigha_fish * 6400 - katha_fish * 320 - lessa_fish * 20;

        $("#total_applied_fbigha").val(bigha_fish);
        $("#total_applied_fkatha").val(katha_fish);
        $("#total_applied_flessa").val(lessa_fish);
        $("#total_applied_fganda").val(ganda_fish);
    }

    <?php
    }else{?>
    function totalAreaCal(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseFloat($("#mbigha"+i).val());
            var mkatha = parseFloat($("#mkatha"+i).val());
            var mlessa = parseFloat($("#mlessa"+i).val());
            var total_area = total_area + ((mbigha * 100) + (mkatha * 20) + mlessa);
        }

        var bigha_r = Math.floor(total_area / 100);
        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);

    }

    function agriArea(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
            var mkatha_agri = parseFloat($("#agri_katha"+i).val());
            var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
            var total_agri_area = total_agri_area + ((mbigha_agri * 100) + (mkatha_agri * 20) + mlessa_agri);
        }
        // alert(total_agri_area);
        var bigha_agri = Math.floor(total_agri_area / 100);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 100) / 20);
        var lessa_agri = total_agri_area - bigha_agri * 100 - katha_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
    }

    function fisheryArea(){
        // for agri
        var bigha_fish = 0;
        var katha_fish = 0;
        var lessa_fish = 0;
        var length_fish = <?=$total_area_fbigha?>;
        var total_fish_area = 0;
        for(i=1; i<length_fish; i++){
            var mbigha_fish = parseFloat($("#fbigha"+i).val());
            var mkatha_fish = parseFloat($("#fkatha"+i).val());
            var mlessa_fish = parseFloat($("#flessa"+i).val());
            var total_fish_area = total_fish_area + ((mbigha_fish * 100) + (mkatha_fish * 20) + mlessa_fish);
        }
        // alert(total_fish_area);
        var bigha_fish = Math.floor(total_fish_area / 100);
        var katha_fish = Math.floor((total_fish_area - bigha_fish * 100) / 20);
        var lessa_fish = total_fish_area - bigha_fish * 100 - katha_fish * 20;

        $("#total_applied_fbigha").val(bigha_fish);
        $("#total_applied_fkatha").val(katha_fish);
        $("#total_applied_flessa").val(lessa_fish);
    }

    <?php }?>

    // zonal value validation
    $("#zonal_valuation").keyup(function(){
        var nodir_kaijo_b = $('#reserved_bigha').val();
        var nodir_kaijo_k = $('#reserved_katha').val();
        var nodir_kaijo_lc = $('#reserved_lessa').val();
        window.nodirkakhorlessa = parseFloat(nodir_kaijo_b) * 100 + parseFloat(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
        console.log(window.nodirkakhorlessa);
        var mbigha = $('.s_dag_area_b').val();
        var mkatha = $('.s_dag_area_k').val();
        var mlessa = $('.s_dag_area_lc').val();
        //window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
        window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
        console.log(window.originallessa);
        // alert(originallessa);
        window.occupiedlessa = nodirkakhorlessa;
        window.remaininglessa = originallessa - occupiedlessa;
        if(originallessa <= nodirkakhorlessa){
            alert("Road/River side reservation can't be greater then original land");
            $('#reserved_bigha').val("0");
            $('#reserved_katha').val("0");
            $('#reserved_lessa').val("0");
            window.nodirkakhorlessa=0;
            window.occupiedlessa = nodirkakhorlessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= occupiedlessa){
            alert("Total Reservation land can't be greater then original land");
            $('#reserved_bigha').val("0");
            $('#reserved_katha').val("0");
            $('#reserved_lessa').val("0");
            window.nodirkakhorlessa=0;
            window.occupiedlessa = nodirkakhorlessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        //alert(remaininglessa);
        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2);
    });


    $(document).ready(function(){

        var roadside_comment_check1 = $("input[name='roadside_comment_check']:checked").val();
        var roadside_reservation = document.getElementById("road_side_reservation_hide");

        if(roadside_comment_check1 == 'YES'){
            roadside_reservation.style.display = "block";
        }

        // // Add new element
        $(".add").click(function(){

            // Finding total number of elements added
            var total_element = $(".element").length;

            // last <div> with element class id
            var lastid = $(".element:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 35;
            // Check total number elements
            if(total_element < max ){
                // Adding new div container after last occurance of element class
                $(".element:last").after("<div class='element' id='div_"+ nextindex +"'></div>");

                // Adding element to <div>
                $("#div_" + nextindex).append("<table class='table table-bordered' id='applicantrow_"+ nextindex +"'> <tr> <th rowspan='5' style='vertical-align : middle;text-align:center;'>1</th> <th>Name of the applicant</th> <td> <input type='text' placeholder='Enter name' name='pdar_name2[]' required class='form-control input-sm'> </td> <th>Guardian name</th> <td> <input placeholder='Enter guardian' type='text' name='pdar_guardian2[]' required class='form-control input-sm' > </td> <th>DOB</th><td><input type='date' class='form-control' name='dob2[]'></td> </tr> <tr> <th>Relation</th> <td> <select name='pdar_rel_guar2[]' id='pdar_rel_guar"+ nextindex +"' class='form-control' required> <option value='1' >Mother</option> <option value='2' selected>Father</option> <option value='3' >Husband</option> <option value='4' >Wife</option> <option value='5' >Guardian</option> <option value='6' >Supdt.Mother</option> <option value='7' >Guardian</option> </select> </td> <th>Gender</th> <td> <select name='pdar_gender2[]' id='pdar_gender"+ nextindex +"' class='form-control' > <option value='1' selected>Male</option> <option value='2' >Female</option> <option value='3' >Others</option> </select> </td> <th>Mobile</th> <td> <input type='text' placeholder='Enter mobile no' name='pdar_mobile2[]' class='form-control input-sm' > </td> </tr> <tr> <th> Permanent address </th> <td colspan='2'> <input type='text' placeholder='Enter permanent address' name='pdar_add12[]' class='form-control input-sm'> </td> <th>Present address</th> <td colspan='2'> <input placeholder='Enter present address' type='text' name='pdar_add22[]' class='form-control input-sm' > </td> </tr><tr><td><span id='remove_" + nextindex + "' class='remove'><i class='fa fa-trash-o' style='font-size:32px;color:red'></i></span></td></tr> </table>&nbsp;");

            }

        });

        // Remove element
        $('.container').on('click','.remove',function(){

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
            // Remove <div> with id
            $("#div_" + deleteindex).remove();
        });

        $(document).on('click', '.delete', function()
        {
            id = $(this).attr('id');
            if($('#del_fpart_appl').val()=='')
            {
                $('#del_fpart_appl').val(id);
            }
            else
            {
                $('#del_fpart_appl').val($('#del_fpart_appl').val()+', '+id);
            }
        });


        // Remove element
        $('.delete').on('click',function(){
            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
            // Remove <div> with id
            $("#applicantrow_" + deleteindex).remove();
        });

    });



    //// premium code

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    var premModal = document.getElementById("premiumModal");
    function premiumModal(){
        premModal.style.display = "block";

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            premModal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == premModal) {
                premModal.style.display = "none";
            }
        }

    }

    $(document).on('click','.closePremium',function ()
    {
        premModal.style.display = "none";
    });


    $("input[name=paymode]").on("click", function () {
        var modeValue = $("input[name=paymode]:checked").val();
        if (modeValue == "YES") {
            $('#totaldue').val('');
            var totaldue= $("#finalamount").val();
            $("#totaldue").val(totaldue);
            $("#lmfinalamount").text(totaldue);
            $("#lmdueamount").text(totaldue);
        }
        else {
            if (modeValue == "NO") {
                var totaldue= $("#finalamount").val();
                var discount = 30;
                var finaldue = Math.ceil(totaldue * discount / 100);
                $("#totaldue").val(finaldue);
                $("#lmfinalamount").text(totaldue);
                $("#lmdueamount").text(finaldue);
            }
        }

    });

    $("#finalsubmit").click(function(){
        if ($('.zonal_valuation_prem').val().length === 0) {
            // alert('Please Enter Zonal Value!!');
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Please Enter Zonal Value!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.zonal_valuation_prem').focus();
            return false;
        }

        if ($('.totalamount').val().length === 0) {
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Total Dag Amount can not be blank!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.totalamount').focus();
            return false;
        }

        var sum = 0;
        $("input[class *= 'totalamount']").each(function(){
            if ($(this).val().length === 0) {
                theme = "blue";
                $.jAlert({
                    'title': 'Error: Field Required',
                    'content': 'Total Dag Amount can not be blank!!!',
                    'theme': theme,
                    'backgroundColor': 'white',
                    'btns': [
                        {'text':'OK', 'theme':theme}
                    ]
                });
                $('.totalamount').focus();
                sum = '';
                return false;
            }else{
                sum += +$(this).val();
            }

        });
        $(".premhide").show();
        $("#finalsubmit").hide();
        $("#finalsave").show();
        $("#closePremium").show();

        $("#finalamount").val(sum);
        $("#totaldue").val(sum);
        $("#paymode1").prop( "checked", true );
        // premModal.style.display = "none";
        $("#premrow").show();
        $("#lmfinalamount").text(sum);
        $("#lmdueamount").text(sum);
    });

    $("#finalsave").click(function(){
        if (!$('#finalamount').val()) {
            alert("Final Amount Can't be blak !!!");
            return;
        }
        $("#premrow").show();
        premModal.style.display = "none";
    });

    $("input[name=prem_update").on("click", function () {

        var selectedValue3 = $("input[name=prem_update]:checked").val();
        if (selectedValue3 == "YES")
        {
            $("#chngPremButton").show();
        }
        else
        {
            if (selectedValue3 == "NO")
            {
                $("#chngPremButton").hide();
            }
        }

    });

    function reset(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        $("#lmfinalamount").text('');
        $("#lmdueamount").text('');

    }

    function roadAreaCheck(){
        reset();

    }

    function familyAreaCheck(){
        reset();
    }

    //// premium code end


</script>

<script>
    $(document).ready(function(){
        var roadside_val = $("input[name='roadside_comment_check']:checked").val();
        if(roadside_val == 'YES')
        {
            $('#road_side_reservation_hide').show();
        }

        if(roadside_val == 'NO'){
            $('#road_side_reservation_hide').hide();
        }
    });

    function roadSideReservYes() {
        $('#road_side_reservation_hide').show();
        $('.reserved_road_value').val(0);
    }

    function roadSideReservNo() {
        $('#road_side_reservation_hide').hide();
        $('.road_reserve_ifno_zero').val(0);
        $('.reserved_road_value').val(0);
        reset();
    }



    function forcedUrban(val) {
        if (val == "YES") {
            $("#forcedurban").show();
        } else {
            $("#forcedurban").hide();
        }
    }
</script>
<script>
    $('#road_side_reservation_hide').hide();
    $('#family_reservation_hide').hide();
    const classExists = document.getElementsByClassName(
        'is-invalid'
    ).length > 0;

    const classExistsLm = document.getElementsByClassName(
        'lm_invalid'
    ).length > 0;

    if(classExists)
    {
        $('html, body').animate({
            scrollTop: ($('.is-invalid').offset().top - 300),
        }, 100);
    }
    else if(classExistsLm)
    {
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
        $('html, body').animate({
            scrollTop: ($('.lm_invalid').offset().top - 300),
        }, 100);
    }

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }

</script>

<!-- additional errors check  -->
<script>
    $('#additionalErrors').on('click',function(){
        $(this).next('#additional_errors_collapse').slideToggle();
    });


    $('#btnLmSubmit').on('click',function(e){
        e.preventDefault();
        var form = $('.lmForm');
        var encData;
        var encDataAll =[];

        <?php
        if($applicants_encroacher == true)
        {
        foreach($applicants_encroacher as $encroacher_ext){
        ?>
        $(".clsencdata").each(function () {
            encData = "Dag No: "+'<?=$encroacher_ext->dag_no?>'+ " : " + $('#encroacher_exist_vlb<?=$encroacher_ext->id?> option:selected').text();
            // var encDagno= $(this).attr("data-id");
            // var encDagno =  $(this).attr("data-id");
            // var enchDataAll="Dag No: "+encDagno+ "; Encroacher Exists in VLB: " +encData;
            // alert( encData );


        })
        // alert( encData );
        encDataAll.push(encData);

        <?php } } ?>


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {
                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                    $('#btnLmSubmit').prop('disabled', false);
                    $('#btnLmSubmit').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnLmSubmit').prop('disabled', false);
                $('#btnLmSubmit').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnLmSubmit').prop('disabled', false);
            $('#btnLmSubmit').val('Save and submit');
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
            )
        }
    })
    });

</script>



<script src="<?php echo base_url();?>js/OfflineSettlement/notify.js"></script>

<?php include(APPPATH."views/OfflineSettlement/Common/Includes/addEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/addEncroacher.js"></script>

<?php include(APPPATH."views/OfflineSettlement/Common/Includes/editEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/editEncroacher.js"></script>

<?php include(APPPATH."views/OfflineSettlement/Common/Includes/changeEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/changeEncroacher.js"></script>

<?php include(APPPATH."views/OfflineSettlement/Common/Includes/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/editApplicantDetails.js"></script>


<?php include(APPPATH."views/OfflineSettlement/Common/Includes/editAreaDetails.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/editAreaDetails.js"></script>

<?php include(APPPATH."views/OfflineSettlement/Common/Includes/editFamilyDetails.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/editFamilyDetails.js"></script>

<?php include(APPPATH."views/OfflineSettlement/Common/Includes/addApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/OfflineSettlement/addApplicantDetails.js"></script>



<script>

    $(document).ready(function()
    {
        var selection = $('#lm_remark').val();
        if(selection == 2)
        {
            $('#sk_for_reject').hide();
            $('#co_for_reject').show();
        }
        else
        {
            $('#sk_for_reject').show();
        }

    });

    $(document).on('change', '#lm_remark', function(){

        var selection = $(this).val();

        if(selection == 2)
        {
            $('#sk_for_reject').hide();
            $('#co_for_reject').show();
        }
        else
        {
            $('#sk_for_reject').show();
            $('#co_for_reject').hide();
        }

    });



</script>