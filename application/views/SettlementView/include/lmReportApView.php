<h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
    <?php echo $this->lang->line('settlementAP')?> (
    <span class="bg-warning"><?=$_GET['case']?></span> )
</h5>

<div class="reza-card">
    <div class="reza-body">
        <h5  class="reza-title" style="margin-top: 15px">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
        </h5>
        <div class="tableCard" style="padding-bottom: 15px">
            <?php $i=1; foreach($lmnotes as $lmnote):?>
            <?php if($validation_bypass == 0):?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Chitha verified?
                    </div>
                    <div class="col-md-2">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="chitha_verified"
                                    id="chitha_verified1"
                                    disabled
                                    value="YES" <?php if ($lmnote->chitha_verified == YES){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="chitha_verified"
                                    id="chitha_verified2"
                                    disabled
                                    value="NO" <?php if ($lmnote->chitha_verified == NO){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php
                        foreach($dags as $chitha_view):
                            if ($chitha_view->new_dag_no==$chitha_view->dag_no){$patta_code='0209';} else{$patta_code=$chitha_view->patta_type_code;}
                            ?>
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $chitha_view->dag_no . '&m=' . $basic["mouza_pargona_code"] . '&l=' . $basic["lot_no"] . '&v=' . $basic["vill_townprt_code"] . '&p=' . $patta_code . '&dist=' . $basic["dist_code"] . '&cir=' . $basic["cir_code"] . '&sub_div=' . $basic["subdiv_code"] ?>">
                                <u><span class="text-primary" style="font-size:16px;">Dag - <?=$chitha_view->dag_no?> (Chitha)</span></u>
                            </a>
                            <br>
                        <?php endforeach;?>
                    </div>
                </div>

                <?php if(!empty($lmnote->bhumiputra_confirmation)) { ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Bhumiputra Verified? <br>
                        <?php if($basic['bhumiputra_certificate_no']){?>
                            <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>

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
                        <i class="fa fa-link" aria-hidden="true"></i>
                        <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                        if($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT){
                            echo "cer_number=".$basic['bhumiputra_certificate_no'];
                        }elseif($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK){
                            echo "ack_number=".$basic['bhumiputra_certificate_no'];
                        }?>" target="BhumiPutra">
                            <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                        </a>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($lmnote->possession_verification)) { ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Possession verified ?
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="possession_verified"
                                    id="possession_verified1"
                                    disabled
                                    value="YES" <?php if ($lmnote->possession_verification == YES){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">YES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="possession_verified"
                                    id="possession_verified2"
                                    disabled
                                    value="NO" <?php if ($lmnote->possession_verification == NO){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($lmnote->is_tribal_belt)) { ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Whether the proposed land falls under Tribal Belt/ Block?
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="is_tribal_belt"
                                    disabled
                                    value="YES" <?php if ($lmnote->is_tribal_belt == YES){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">YES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="is_tribal_belt"
                                    disabled
                                    value="NO" <?php if ($lmnote->is_tribal_belt == NO){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($lmnote->protected_class_lm)) { ?>
                
                <div class="row p-2">
                    <div class="col-md-6 text-justify">
                        <strong><?=$sl_count++?>.</strong> Does applicant falls under protected category?
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
                <?php } ?>

                <?php if(!empty($lmnote->landslide)) { ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone?
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="landslide"
                                    disabled
                                    value="YES" <?php if ($lmnote->landslide == YES){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">YES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="landslide"
                                    disabled
                                    value="NO" <?php if ($lmnote->landslide == NO){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($lmnote->is_landless)) { ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Whether the land falls under erosion?
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="erosion"
                                    disabled
                                    value="YES" <?php if (trim($lmnote->erosion) == YES){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">YES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="erosion"
                                    disabled
                                    value="NO" <?php if (trim($lmnote->erosion) == NO){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($lmnote->nature_possession)) { ?>
                <div class="row p-2">
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Nature of possession
                    </div>
                    <div class="col-md-6">
                        <input
                                type="text"
                                name="nature_possession"
                                id="nature_possession"
                                class="form-control" value="<?=$lmnote->nature_possession?>" readonly
                        />
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($lmnote->is_landless)) { ?>
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
                            <label class="form-check-label" for="inlineRadio2">Landless as per policy/Having Land</label>
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
                <?php } ?>

                <?php if(!empty($lmnote->land_falls)) { ?>
                <div class="row p-2">
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong>
                        Category of the proposed land?

                    </div>
                    <div class="col-md-6">
                        <input
                                type="text"
                                name="land_falls"
                                id="land_falls"
                                class="form-control" value="<?php
                        foreach(json_decode(LB_NATURE_OF_RESERVATION) as $land){
                            if($land->CODE == $lmnote->land_falls){
                                echo $land->NAME;
                            }
                        }
                        ?>" readonly
                        />
                    </div>
                </div>
                <?php } ?>
                <?php if(!empty($lmnote->eksona_type)) { ?>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong>
                            Whether applied land falls under Eksona /Gramdan  /Bhudan?

                        </div>
                        <div class="col-md-6">
                            <input
                                    type="text"
                                    name="eksona_type"
                                    id="eksona_type"
                                    class="form-control" value="<?php
                            foreach(json_decode(GRAMDAN_BHUDAN) as $landGb){
                                if($landGb->CODE == $lmnote->eksona_type){
                                    echo $landGb->NAME;
                                }
                            }
                            ?>" readonly
                            />
                        </div>
                    </div>
                <?php } ?>

                <?php if(!empty($lmnote->eksona_transfered)) { ?>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong>
                            Is Eksona Land Transferred?

                        </div>
                        <div class="col-md-6">
                            <input
                                    type="text"
                                    name="eksona_transfered"
                                    id="eksona_transfered"
                                    class="form-control" value="<?php
                            foreach(json_decode(EKSONA_TRANSFERRED) as $landEt){
                                if($landEt->CODE == $lmnote->eksona_transfered){
                                    echo $landEt->NAME;
                                }
                            }
                            ?>" readonly
                            />
                        </div>
                    </div>
                <?php } ?>

                <?php if(!empty($lmnote->falls_und_gmc)) { ?>
                <div class="row p-2" >
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Whether the proposed land falls within 15 KM radius from
                        the periphery of GMC or within 5 KM periphery of other town or within 3 KM periphery
                        of Revenue town. ?
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="falls_und_gmc"
                                    disabled
                                    value="YES" <?php if ($lmnote->falls_und_gmc == YES){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">YES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input"
                                    type="radio"
                                    name="falls_und_gmc"
                                    disabled
                                    value="NO" <?php if ($lmnote->falls_und_gmc == NO){ echo "checked"; } ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($reservation == true) {?>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong> Specific comment on roadside
                            /riverside reservation (if any, along with provision kept for road/drain
                            wherever necessary)
                        </div>
                        <div class="col-md-6">
                            <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                                <?php foreach ($reservation as $reserv_road) {

                                    if ($reserv_road->type == "R") {?>
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
                                        <?php endif;?>
                                    <?php }}?>

                            </div>
                        </div>
                    </div>
                <?php }?>

                <?php if ($reservation == true) {?>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong> Whether applicant family has occupied any land in the lot?
                        </div>
                        <div class="col-md-6">
                            <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                                <?php foreach ($reservation as $reserv) {
                                    if ($reserv->type == "F") {?>
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
                    if($land_mark != null || $land_mark != '' || !empty($land_mark)){
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
                <?php } endforeach;?>
            <?php endif;?>

            <?php if($validation_bypass == 1) {?>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <span ><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                            <?php if($basic['bhumiputra_certificate_no']){?>
                                <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>
                            <?php }else{ ?>
                                <label for="" class="alert-warning">Certificate/Ack Not Available!</b></label>
                            <?php }?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if($basic['bhumiputra_certificate_no']){?>
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                            
                            if($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT){
                                echo "cer_number=".$basic['bhumiputra_certificate_no'];
                            }elseif($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK){
                                echo "ack_number=".$basic['bhumiputra_certificate_no'];
                            }?>" target="BhumiPutra">
                                <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                            </a>
                            <?php 
                            }
                            else
                            {
                                ?>
                                    <span class="text-primary" style="font-size:16px;">Certificate not available</span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
            <?php }?>

            <?php if($validation_bypass == 0):?>

                <div class="row p-2">
                    <div class="col-md-6">
                        <strong><?=$sl_count++?>.</strong> Whether appliacnt eligible for NR or NR with Settlement ?
                    </div>
                    <div class="col-md-6">
                        <input
                                type="text"
                                name="is_nr_settlement"
                                id="is_nr_settlement" readonly
                                class="form-control" value="<?=$lmnote->is_nr_settlement?>"
                        />
                    </div>
                </div>
            <?php endif;?>
            <div class="row p-2">
                <div class="col-md-6">
                    <strong><?=$sl_count++?>.</strong> LM remarks
                </div>
                <div class="col-md-6">
                    <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2" readonly><?php
                        foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                            if($lm_remark_cat->CODE == $lmnote->lm_note){
                                echo $lm_remark_cat->NAME;
                            }
                        } ?>
                    </textarea>
                </div>
            </div>

            <div class="row p-5 m-2" style="background:#FFF3CD;">
                <div class="col-md-12">
                    <?php 
                        include(APPPATH."views/SettlementView/include/coRejectedRemarks.php");
                    ?>
                </div>
            </div>

            <?php if($validation_bypass == 0):?>
                <div class="row p-2">
                    <div class="col-md-3">
                        <strong><?=$sl_count++?>.</strong> NR Note
                    </div>
                    <div class="col-md-9">
                        <textarea name="lm_remark_additional" class="form-control p-2" id="lm_remark_additional" cols="30" rows="6" readonly><?=$lmnote->lm_remark_additional?></textarea>

                    </div>
                </div>
            <?php endif;?>

            <div class="row p-2">
                <div class="col-md-3">
                    <strong><?=$sl_count++?>.</strong> Settlement Note
                </div>
                <div class="col-md-9">
                    <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="12" readonly><?=$lmnote->lm_remark_text?></textarea>

                </div>
            </div>
        </div>
        <!-- lm report ends here -->

        <?php endforeach;?>


        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-file-pdf-o"></i> Uploaded Documents
        </h5>
        <div class="tableCard">
            <table class="table table-bordered">
                <?php foreach($dhardocuments as $docs): ?>
                    <tr>
                        <th>
                            <a target='download'
                               href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$docs->id?>"><i class="fa fa-paperclip"></i> <?=$docs->file_name;?>
                                <?php if(isset($docs->dag_no)){ ?>
                                    <span class="alert-danger"><small> for Dag no: <strong><?=$docs->dag_no?></strong></small></span>
                                <?php }?>
                            </a>
                        </th>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>
</div>

<!-- //for correcting the wrong possseion from date starts-->
    <?php if(isset($wrong_possession_from_flag) && $wrong_possession_from_flag =='yes'):?>
        <!-- //view for LRA STARTS-->
        <?php if($this->session->userdata('user_desig_code') == "LM"):?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-check" aria-hidden="true"></i> For Correction Of Wrong Possession From Date
            </h5>
            <hr>
            <?php 
                $this->load->model('SettlementPossessionFrom/SettlementPossesionFromModel');
            ?>
            <div class="container-fluid reza-body reza-card">
                <form id="wrong_posssession_from_date_correction_form" name='wrong_posssession_from_date_correction_form' action="<?php echo base_url()?>index.php/SettlementPossesionFrom/formSubmitFromLra">
                <div class="row">
                    <?php $existing_possession_from = $this->SettlementPossesionFromModel->getPossessionFromData($_GET['case']);?>
                    <label>
                        Exisiting Possession From date:<span style="color:red"> <?=$existing_possession_from?></span>
                    </label>
                    <div class="col-md-6">
                        <label for="date_of_possession_modified">Please Select The Correct Date Of Possession <span style="color: red;">*</span></label>
                        <input type="text" class="form-control mt-2" placeholder="-DATE OF POSSESSION-" 
                            id="date_of_possession_modified" name="date_of_possession_modified">
                    </div>
                    <div class="col-md-6">
                        <label for="supporting_document_wrong_possession_document">Upload Supporting Document(if any)</label>
                        <input type="file" class="form-control mt-2"  
                            id="supporting_document_wrong_possession_document" name="supporting_document_wrong_possession_document">
                    </div>
                    <div class="col-md-6">
                        <label for="wrong_poseesion_from_remarks">Please Enter Remarks Here <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="wrong_poseesion_from_remarks" id="wrong_poseesion_from_remarks" placeholder="Please Enter Remarks Here"></textarea>
                    </div>
                </div>
                <!-- hidden fields -->
                <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
                <input type="hidden" name="existing_possession_from_date" value="<?=$existing_possession_from?>">
                <!-- hidden fields -->
                
                </form>
                <center>
                    <button class="btn btn-sm btn-success mt-2"  onclick="wrong_poss_forward_lra_to_co()">
                        <i class="fa fa-forward" aria-hidden="true"></i> FORWARD TO CO
                    </button>
                </center>
            </div>
        <?php endif;?>
        <!-- //view for LRA ends-->

        <!-- //view for CO STARTS-->
        <?php if($this->session->userdata('user_desig_code') == "CO"):?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-check" aria-hidden="true"></i> For Correction Of Wrong Possession From Date
            </h5>
            <hr>
            <?php 
                $this->load->model('SettlementPossessionFrom/SettlementPossesionFromModel');
            ?>
            <div class="container-fluid reza-body reza-card">
                <form id="wrong_posssession_from_date_correction_form_co" name='wrong_posssession_from_date_correction_form_co' action="<?php echo base_url()?>index.php/SettlementPossesionFrom/formSubmitFromLra">
                <div class="row">
                    <?php 
                        $existing_possession_from = $this->SettlementPossesionFromModel->getPossessionFromData($_GET['case']);
                        $corrected_possession_from = $this->SettlementPossesionFromModel->getCorrectedPossessionFromData($_GET['case']);
                    ?>
                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <td><strong>Existing Possession From Date</strong></td>
                            <td style="color: red;"><?=$existing_possession_from?></td>
                        </tr>
                        <tr>
                            <td><strong>Corrected Possession From Date</strong></td>
                            <td style="color: green;"><?=$corrected_possession_from->possesion_from_correct_date?></td>
                        </tr>
                        <tr>
                            <td><strong>Remarks From LRA</strong></td>
                            <td style="color: black;"><?=$corrected_possession_from->lra_remark?></td>
                        </tr>
                        <tr>
                            <td><strong> View Supporting Document</strong></td>
                            <?php if($corrected_possession_from->attachment_url =='NA'):?>
                                <td><span style="background-color:yellow">Not Uploaded</span></td>
                            <?php else:?>
                                <td>
                                    <a class="btn btn-sm btn-success" 
                                    href="<?= base_url('index.php/SettlementPossesionFrom/viewSupportingDocument?case_no=' . urlencode($_GET['case'])) ?>" 
                                    target="_blank">
                                        View Document
                                    </a>
                                </td>
                            <?php endif;?>
                        </tr>
                    </table> 
                    <!-- New Div for Chitha Remarks starts-->
                    <div class="col-md-12 mt-3">
                        <h6><strong>Chitha Remarks</strong></h6>
                        <textarea required readonly name="chitha_remarks_correction" id="chitha_remarks_correction"
                            class="form-control p-2 border rounded"
                            style="background-color: #f9f9f9; font-size: 14px; line-height: 1.6;" rows="5">১ নং হুকুম মতে বন্দৱস্তী হোৱা ভূমি ভুলক্ৰমে <?=$existing_possession_from?> চনৰ পৰা দখল থকা বুলি উল্লেখ কৰা হৈছিল, কিন্তু প্ৰকৃততে <?=$corrected_possession_from->possesion_from_correct_date?> চনৰ পৰা দখল থকা বুলি হ'ব লাগিছিল। সেয়েহে <?=$corrected_possession_from->possesion_from_correct_date?> চনৰ পৰা দখল থকা বুলি সংশোধনী কৰি ৰাজহ নিৰ্ধাৰণ কৰিবলৈ নথি সংশোধন কৰা হল।
                        </textarea>
                    </div>
                    <!-- New Div for Chitha Remarks ends--> 
                    <div class="col-md-6">
                        <label for="wrong_poseesion_from_remarks_co">Please Enter Remarks Here <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="wrong_poseesion_from_remarks_co" id="wrong_poseesion_from_remarks_co" placeholder="Please Enter Remarks Here"></textarea>
                    </div>
                </div>
                <!-- hidden fields -->
                <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
                <!-- hidden fields -->
                
                </form>
                <center>
                    <button class="btn btn-sm btn-success mt-2"  onclick="wrong_poss_co_update()">
                        <i class="fa fa-refresh" aria-hidden="true"></i> UPDATE THE DATE IN CHITHA
                    </button>
                </center>
            </div>
        <?php endif;?>
         <!-- //view for CO ends-->

    <?php endif;?>
    <!-- //for correcting the wrong possseion from date ends-->

<ul class="list-inline pull-right"  style="margin-top: 20px">
    <li>
        <button type="button" class="btn btn-default prev-step">
            <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
        </button>
    </li>
    <li>
        <button type="button" class="btn btn-primary next-step">
            <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
        </button>
    </li>
</ul>



<script>
$(document).ready( function () {
    //date field initialisation
    $('#date_of_possession_modified').datepick({dateFormat: 'yyyy-mm-dd'});
});

function wrong_poss_forward_lra_to_co() {
    var formdata = new FormData(document.getElementById('wrong_posssession_from_date_correction_form'));
    let remarks = $('#wrong_poseesion_from_remarks').val().trim();
    let dateModified = $('#date_of_possession_modified').val().trim();

    if (remarks === '' || dateModified === '') {
        alert("Remarks and Date of Possession are required!");
        return;
    }

    $.ajax({
        url: baseurl + "SettlementPossesionFrom/formSubmitFromLra",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (response) {
            $.unblockUI();
            if (response.result === 'SUCCESS') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.msg,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = baseurl + "SettlementPossesionFrom/index";
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: response.result,
                    text: response.msg
                });
            }
        },
        error: function (xhr, status, error) {
            $.unblockUI();
            alert("An error occurred while submitting the form.");
            console.error(error);
        }
    });
}

function wrong_poss_co_update() {
    var formdata = new FormData(document.getElementById('wrong_posssession_from_date_correction_form_co'));
    let remarks = $('#wrong_poseesion_from_remarks_co').val().trim();
    let chitha_remarks_correction = $('#chitha_remarks_correction').val().trim();
    
    if (remarks === '' ) {
        alert("Remarks field is required!");
        return;
    }
    if (chitha_remarks_correction === '' ) {
        alert("Chitha Remarks field is required!");
        return;
    }

    $.ajax({
        url: baseurl + "SettlementPossesionFrom/formSubmitFromCo",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (response) {
            $.unblockUI();
            if (response.result === 'SUCCESS') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.msg,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = baseurl + "SettlementPossesionFrom/coLanding";
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: response.result,
                    text: response.msg
                });
            }
        },
        error: function (xhr, status, error) {
            $.unblockUI();
            alert("An error occurred while submitting the form.");
            console.error(error);
        }
    });
}
</script>