<div class="tableCard">
    <?php $sl_count =1; $i = 1;foreach ($lmnotes as $lmnote): ?>
        <?php if($validation_bypass == 0):?>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span ><strong><?=$sl_count++?>.</strong> Chitha Verified?</span >
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="chiitha_verified"
                            id="chiitha_verified1"
                            value="YES" disabled <?php if ($lmnote->chitha_verified == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="chiitha_verified"
                            id="chiitha_verified2"
                            value="NO" disabled <?php if ($lmnote->chitha_verified == NO) {echo "checked";}?>
                        />
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
                    <span ><strong><?=$sl_count++?>.</strong> VLB Verified?</span>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="vlb_verified"
                            id="vlb_verified1"
                            value="YES" disabled <?php if ($lmnote->vlb_verified == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="vlb_verified"
                            id="vlb_verified2"
                            value="NO" disabled <?php if ($lmnote->vlb_verified == NO) {echo "checked";}?>
                        />
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
                    <span ><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                    <?php if($basic->bhumiputra_certificate_no){?>
                        <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic->bhumiputra_certificate_no?></b></label>
                    <?php }else{ ?>
                        <label for="" class="alert-warning">Certificate/Ack Not Available!</b></label>
                    <?php }?>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="bhumiputra_confirmation_lm"
                            id="bhumiputra_confirmation1"
                            value="YES"
                            disabled
                            <?php if($lmnote->bhumiputra_confirmation == YES){echo "checked";} ?>

                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="bhumiputra_confirmation_lm"
                            id="bhumiputra_confirmation2"
                            value="NO"
                            disabled
                            <?php if($lmnote->bhumiputra_confirmation == NO){echo "checked";} ?>
                        />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                    if($basic->bhumiputra_certificate_no){?>
                        <i class="fa fa-link" aria-hidden="true"></i>
                        <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php

                        if($basic->bhumiputra_certificate_no && $basic->bhumiputra_certificate_type == BHUMI_CERT){
                            echo "cer_number=".$basic->bhumiputra_certificate_no;
                        }elseif($basic->bhumiputra_certificate_no && $basic->bhumiputra_certificate_type == BHUMI_ACK){
                            echo "ack_number=".$basic->bhumiputra_certificate_no;
                        }?>" target="BhumiPutra">
                            <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <?php foreach($applicants_encroacher as $enc_exis_vlb)  { ?>

                <div class="row p-2 <?php if($enc_exis_vlb->encroacher_exist_vlb == 4){ echo "alert-danger"; }?>">
                    <div class="col-md-6">
                        <span><strong><?=$sl_count++?>.</strong> Is Encroacher Exists in VLB for <strong> Dag no <?=$enc_exis_vlb->dag_no?></strong>? </span>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="encroacher_exist_vlb" id="encroacher_exist_vlb" class="form-control" disabled>
                            <?php
                            foreach(json_decode(ENC_VARIFICATION_LIST) as $enc_list)
                            {
                                ?>
                                <option value="<?=$enc_list->CODE?>" <?php if($enc_list->CODE == $enc_exis_vlb->encroacher_exist_vlb){echo 'selected';}?>>
                                    <?=$enc_list->NAME?>
                                </option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>

            <?php } ?>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span ><strong><?=$sl_count++?>.</strong> Schedule of the land and area under occupation?</<span>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="possession_verified"
                            id="possession_verified1"
                            value="YES" disabled <?php if ($lmnote->possession_verification == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="possession_verified"
                            id="possession_verified2"
                            value="NO" disabled <?php if ($lmnote->possession_verification == NO) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under Tribal Belt/ Block.</span>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="whether_tribal"
                            id="whether_tribal1"
                            value="YES"
                            disabled
                            <?php if ($lmnote->is_tribal_belt == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="whether_tribal"
                            id="whether_tribal2"
                            value="NO"
                            disabled
                            <?php if ($lmnote->is_tribal_belt == NO) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-6 text-justify">
                    <span><strong><?=$sl_count++?>.</strong> Does applicant falls under protected category?</span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" name="" value="<?php
                    foreach(json_decode(PROTECTED_CLASS) as $class){


                        if($class->CODE == $lmnote->protected_class_lm){
                            echo $class->NAME;
                        }
                    }
                    ?>" class="form-control" disabled>
                </div>
            </div>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ? </span>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="landslide"
                            id="landslide"
                            value="YES"
                            disabled
                            <?php if ($lmnote->landslide == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="landslide"
                            id="landslide2"
                            value="NO"
                            disabled
                            <?php if ($lmnote->landslide == NO) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Whether the land falls under erosion?</span>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="erosion"
                            value="YES" disabled <?php if (trim($lmnote->erosion) == YES){ echo "checked"; } ?>
                        />
                        <label class="form-check-label" for="inlineRadio1">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="erosion"
                            value="NO" disabled <?php if (trim($lmnote->erosion) == NO){ echo "checked"; } ?>
                        />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>


            <?php
            $display_old_nature=0;
            foreach($dags as $naturedag):
                if (!is_null($naturedag->nature_possession)){
                    $display_old_nature=0;
                    ?>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong> Nature of possession <span class="alert-warning"><strong>for Dag No. <?=$naturedag->dag_no?></strong></span>
                        </div>
                        <div class="col-md-6">
                            <input name="nature_possession<?=$naturedag->dag_no?>" readonly class="form-control" id="nature_possession<?=$naturedag->dag_no?>" value="<?=$naturedag->nature_possession?>">
                        </div>
                    </div>
                <?php } else { $display_old_nature=1; } endforeach;?>

            <?php if ($display_old_nature == 1){ ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <span><strong><?=$sl_count++?>.</strong> Nature of possession –</span>
                    </div>
                    <div class="form-group col-md-6">

                        <input name="nature_possession" readonly class="form-control" id="nature_possession" value="<?=$lmnote->nature_possession?>">
                        <!-- <select
                                        name="nature_possession"
                                        id="nature_possession"
                                        class="form-control" disabled
                                >
                                    <option value="Agricultural" <?php if ($lmnote->nature_possession == "Agricultural") {echo "selected";}?>>Agricultural</option>
                                    <option value="Business" <?php if ($lmnote->nature_possession == "Business") {echo "selected";}?>>Business</option>
                                    <option value="Residential" <?php if ($lmnote->nature_possession == "Residential") {echo "selected";}?>>Residential</option>
                                </select> -->
                    </div>
                </div>
            <?php } ?>

            <div class="row p-2">
                <div class="col-md-6">
                    <span ><strong><?=$sl_count++?>.</strong> Whether applicant and his/her family has occupied any land in the state ?</span>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="is_landless"
                            id="is_landless"
                            value="YES" disabled <?php if ($lmnote->is_landless == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Completely Landless</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="is_landless"
                            id="is_landless"
                            value="NO" disabled <?php if ($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio2">Landless as per policy / Having Land</label>
                    </div>

                    <?php if($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') { ?>
                        <button class="btn btn-sm btn-warning viewModal" onclick="viewPropertyModal()" type="button"><i class="fa fa-university"></i>&nbsp;View Property</button>

                        <button class="btn btn-sm btn-danger closeModal" style="display:none" onclick="closePropertyModal()" type="button"><i class="fa fa-close"></i>&nbsp;Close Property</button>

                        <div class="addPropertyDetail" style="display:none" >
                            <div class="tableCard">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>District</th>
                                        <th>Circle</th>
                                        <th>Area</th>
                                    </tr>

                                    <?php

                                    if($additional_property != null) {

                                        foreach($additional_property as $area) {
                                            ?>
                                            <tr>
                                                <td><?=$area->dist_name?></td>
                                                <td><?=$area->cir_name?></td>
                                                <td>
                                                    <b>B:</b> <?=$area->bigha?>;
                                                    <b>K:</b> <?=$area->katha?>;
                                                    <b>L/C:</b> <?=$area->lessa?>;
                                                    <b>G:</b> <?=$area->ganda?>;
                                                    <b>Kr:</b> <?=$area->kranti?>
                                                </td>
                                            </tr>

                                        <?php }} ?>


                                </table>
                            </div>
                        </div>

                    <?php } ?>

                    <script>
                        function viewPropertyModal(){
                            $('.viewModal').hide('slow');
                            $('.closeModal').show('slow');
                            $('.addPropertyDetail').show('slow');
                        }

                        function closePropertyModal() {
                            $('.viewModal').show('slow');
                            $('.closeModal').hide('slow');
                            $('.addPropertyDetail').hide('slow');
                        }
                    </script>

                </div>
            </div>

            <div class="row p-2">
                <div class="col-md-6 text-justify">
                    <span><strong><?=$sl_count++?>.</strong> Category of the proposed land?</span>
                </div>
                <div class="col-md-6">
                    <select name="land_falls" id="land_falls" class="form-control" required disabled>
                        <option value="">Select...</option>
                        <?php foreach (json_decode(LB_NATURE_OF_RESERVATION) as $landCode): ?>
                            <option value="<?php echo $landCode->CODE ?>" <?php if ($lmnote->land_falls == $landCode->CODE) {echo "selected";}?>><?php echo $landCode->NAME ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="row p-2" >
                <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
                                    15 KM radius from the periphery of GMC or within 5 KM periphery of other
                                    town or within 3 KM periphery of Revenue town.</span>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="falls_und_gmc"
                            id="falls_und_gmc"
                            value="YES" disabled <?php if ($lmnote->falls_und_gmc == YES) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="falls_und_gmc"
                            id="falls_und_gmc"
                            value="NO" disabled <?php if ($lmnote->falls_und_gmc == NO) {echo "checked";}?>
                        />
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>
            <?php if ($reservation == true) {?>
                <div class="row p-2" >
                    <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                        /riverside reservation (if any, along with provision kept for road/drain
                                        wherever necessary)</span>
                    </div>
                    <div class="col-md-6">
                        <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                            <?php foreach ($reservation as $reserv_road) {
                                if ($reserv_road->type == "R") {?>
                                    <span>Dag No: <?=$reserv_road->dag_no?></span>
                                    <div class="form-group row mt-2">
                                        <input disabled type="hidden" name="dag_no<?=$reserv_road->dag_no?>" value="<?=$reserv_road->dag_no?>">
                                        <div class="col-4">
                                            <span class="input-group-addon">Bigha</span>
                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->bigha?>" class="form-control input-sm" name="reserved_bigha<?=$reserv_road->dag_no?>" id="reserved_bigha">
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-addon">Katha</span>
                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->katha?>" class="form-control input-sm" name="reserved_katha<?=$reserv_road->dag_no?>" id="reserved_katha" >
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-addon">Lessa</span>
                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->lessa?>" class="form-control input-sm" name="reserved_lessa<?=$reserv_road->dag_no?>" id="reserved_lessa" >
                                        </div>
                                    </div>
                                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                        <div class="form-group row mt-2">
                                            <div class="col-4">
                                                <span class="input-group-addon">Ganda</span>
                                                <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->ganda?>" class="form-control input-sm" name="reserved_ganda<?=$reserv_road->dag_no?>" >
                                            </div>
                                            <div class="col-4">
                                                <span class="input-group-addon">Kranti</span>
                                                <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->kranti?>" class="form-control input-sm" name="reserved_kranti<?=$reserv_road->dag_no?>" >
                                            </div>
                                        </div>
                                    <?php endif;?>
                                <?php }}?>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="roadside">Comment(if any)</label>
                                    <textarea
                                        name="roadside_reservation"
                                        id="roadside_reservation"
                                        class="form-control"
                                        rows="2"
                                        disabled
                                    ><?=$lmnote->roadside_reservation?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php if ($reservation == true) {?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <span ><strong><?=$sl_count++?>.</strong> Whether applicant family has occupied any land in the lot?</span>
                    </div>
                    <div class="col-md-6">
                        <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                            <?php foreach ($reservation as $reserv) {
                                if ($reserv->type == "F") {?>
                                    <span>Dag No: <?=$reserv->dag_no?></span>
                                    <div class="form-group row mt-2">
                                        <input disabled type="hidden" name="dag_no<?=$reserv->dag_no?>" value="<?=$reserv->dag_no?>">
                                        <div class="col-4">
                                            <span class="input-group-addon">Bigha</span>
                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv->bigha?>" class="form-control input-sm" name="reserved_bigha_family<?=$reserv->dag_no?>" id="reserved_bigha_family">
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-addon">Katha</span>
                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv->katha?>" class="form-control input-sm" name="reserved_katha_family<?=$reserv->dag_no?>" id="reserved_katha_family" >
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-addon">Lessa</span>
                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv->lessa?>" class="form-control input-sm" name="reserved_lessa_family<?=$reserv->dag_no?>" id="reserved_lessa_family" >
                                        </div>
                                    </div>
                                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                        <div class="form-group row mt-2">
                                            <div class="col-4">
                                                <span class="input-group-addon">Ganda</span>
                                                <input disabled type="text" style="text-align: center;" value="<?=$reserv->ganda?>" class="form-control input-sm" name="reserved_ganda_family<?=$reserv->dag_no?>" >
                                            </div>
                                            <div class="col-4">
                                                <span class="input-group-addon">Kranti</span>
                                                <input disabled type="text" style="text-align: center;" value="<?=$reserv->kranti?>" class="form-control input-sm" name="reserved_kranti_family<?=$reserv->dag_no?>" >
                                            </div>
                                        </div>
                                    <?php endif;?>
                                <?php }}?>
                        </div>
                    </div>
                </div>
            <?php }?>


            <?php foreach($dags as $landmark):
                $land_mark = json_decode($landmark->landmark);
                ?>
                <div class="row p-2">
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Landmark <span class="alert-warning"><strong>for Dag No. <?=$landmark->dag_no?></strong></span>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>East side</th>
                                <td><?=$land_mark->east?></td>
                                <th>West side</th>
                                <td><?=$land_mark->west?></td>
                            </tr>
                            <tr>
                                <th>North side</th>
                                <td><?=$land_mark->north?></td>
                                <th>South side</th>
                                <td><?=$land_mark->south?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php endforeach;?>

        <?php endif;?>


        <div class="row p-2">
            <div class="col-md-6">
                <strong><?=$sl_count++?>.</strong> LM remarks</label>
            </div>
            <div class="col-md-6">
                <input name="lm_remark" readonly class="form-control" id="lm_remark" value="<?php foreach(json_decode(LM_NOTE) as $lm_remark_cat){ if($lm_remark_cat->CODE == $lmnote->lm_note){ echo $lm_remark_cat->NAME;}}?>" cols="30" rows="2">
            </div>
        </div>

        <div class="row p-5 m-2" style="background:#FFF3CD;">
            <div class="col-md-12">

                <?php include(APPPATH."views/OfflineSettlement/include/co_rejected_remarks.php"); ?>
            </div>
        </div>

        <div class="row p-2 justify-content-end" style="padding-bottom: 15px!important;">
            <div class="col-md-12">
                <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="11" disabled><?=$lmnote->lm_remark_text?></textarea>
            </div>
        </div>


    <?php endforeach;?>

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