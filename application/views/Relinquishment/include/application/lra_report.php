<div class="tableCard">
    <?php $sl_count = 1; ?>
    <?php $i=1; foreach($lmnotes as $lmnote):?>
        <?php if($validation_bypass == 0):?>
            <div class="row" style="padding-bottom: 15px">
            <div class="col-md-6">
                <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                <?=form_error('chitha_verified')?>
            </div>
            <div class="col-md-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="chiitha_verified" id="chiitha_verified1"
                           value="YES" disabled <?php if ($lmnote->chitha_verified == YES) {echo "checked";}?> />
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="chiitha_verified" id="chiitha_verified2"
                           value="NO" disabled <?php if ($lmnote->chitha_verified == NO) {echo "checked";}?> />
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-4">
                <?php foreach ($dags as $ddg): ?>
                    <i class="fa fa-link" aria-hidden="true"></i>
                    <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' .
                        $ddg->dag_no . '&m=' . $ddg->mouza_pargona_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_townprt_code . '&p=' .
                        $ddg->patta_type_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>">
                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                    </a>
                    <br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>

        <div class="row p-2">
            <div class="col-md-6">
                <strong><?=$sl_count++?>.</strong> LM remarks
            </div>
            <div class="col-md-6">
                <?php
                foreach(json_decode(LM_NOTE) as $lm_remark_cat)
                {
                    if($lm_remark_cat->CODE == $lmnote->lm_note)
                    {
                        $lraRec = $lm_remark_cat->NAME;
                    }
                } ?>
                <input name="lm_remark" class="form-control" id="lm_remark"  readonly value="<?php echo $lraRec; ?>">
            </div>
        </div>

        <?php if($lmnote->lm_note == 2 ): ?>
            <div class="row p-5 m-2" style="background:#FFF3CD;">
                <div class="col-md-12">
                    <?php
                    include(APPPATH."views/SettlementView/include/coRejectedRemarks.php");
                    ?>
                    <?php include(APPPATH."views/Relinquishment/include/application/co_rejection_remarks.php"); ?>
                </div>
            </div>
        <?php endif; ?>


        <?php if($validation_bypass == 0):?>
            <div class="row p-2">
                <div class="col-md-3">
                    <strong><?=$sl_count++?>.</strong> NR Note
                </div>
                <div class="col-md-9">
                    <textarea name="lm_remark_additional" class="form-control p-2" id="lm_remark_additional" cols="30" rows="8" readonly><?=$lmnote->lm_remark_additional?></textarea>

                </div>
            </div>
        <?php endif;?>

        <div class="row p-2">
            <div class="col-md-3">
                <strong><?=$sl_count++?>.</strong> Settlement Note
            </div>
            <div class="col-md-9">
                <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="14" readonly><?=$lmnote->lm_remark_text?></textarea>

            </div>
        </div>

    <?php endforeach; ?>


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
                                <span class="alert-danger"><small> &nbsp; for Dag no: <strong><?=$docs->dag_no?></strong></small></span>
                            <?php }?>
                        </a>
                    </th>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>