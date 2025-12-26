<div class="row <?php if(form_error('rejected_reasons')){echo 'lm_invalid';}?>">
    <?=form_error('rejected_reasons')?>
</div>
<div class="row p-5 m-2" style="background:#FFF3CD;" id="rejectDiv">
    <div class="col-md-12">
        <div>
            <h5 class="bg-warning p-2 text-center text-white">Select Reason for Rejection</h5>

            <?php if(isset($rejected_list))
            {
                echo $dagFlagCheckChitha;

                $dis_cout = 0;
                foreach(json_decode(REJECTED_REMARK_HEAD) as $r_head):
                    $count = 0;

                    foreach($rejected_list as $rej_list_key => $rej_list)
                    {
                        if($r_head->CODE == $rej_list->remark_head):

                            if($count == 0):
                                ?>
                                <br>
                                <h6>
                                    <span style="color:blue; cursor:pointer;" onclick="collapse('col<?=$rej_list->remark_head?>');" class="p-1"><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        <b><?=$r_head->NAME?> </b>
                                        <i class="fa fa-level-down text-red" aria-hidden="true"></i>
                                    </span>
                                </h6>
                            <?php
                            endif;
                            ?>

                            <?php

                            if($rej_list->chitha_flag != 0)
                            {

                                $dagsLoop = $dags;
                                foreach($dagsLoop as $remark_dag)
                                {
                                    ?>

                                    <div style="background:#F0F0F0;" class="col<?=$rej_list->remark_head?>" <?php if(!isset($err_return)) {if($dis_cout > 0){ echo "style='display:none'"; }}?>>
                                        <label class="ml-3 mb-2 mt-2">

                                            <input class="rr_reason_class" onclick="additionalSubRemark('<?=$rej_list->reject_code;?>', '<?=$remark_dag->dag_no?>');"
                                                   style="width: 16px; height: 16px;"
                                                   type="checkbox"
                                                   id="<?=$rej_list->reject_code?>_<?=$remark_dag->dag_no?>"
                                                   name="rejected_reasons[<?=$rej_list->reject_code?>_<?=$remark_dag->dag_no?>]"
                                                   value="<?=$rej_list->reject_code?>_<?=$remark_dag->dag_no?>" <?php if(isset($err_return)){ if(set_value('rejected_reasons['.$rej_list->reject_code.'_'.$remark_dag->dag_no.']') == $rej_list->reject_code.'_'.$remark_dag->dag_no){ echo "checked";} }else{ if($rej_list->chitha_flag != 0)
                                            {
                                                $chithaUuid = $this->utilityclass->getVillageUUID($remark_dag->dist_code, $remark_dag->subdiv_code, $remark_dag->cir_code, $remark_dag->mouza_pargona_code, $remark_dag->lot_no, $remark_dag->vill_townprt_code);

                                                $resp = $this->utilityclass->getChithaFlag((string)$chithaUuid, (string)$remark_dag->dag_no, $rej_list->chitha_flag);
                                                if($resp == true)
                                                {
                                                    echo "checked";
                                                }
                                            }
                                            }?>> &nbsp;<?=$rej_list->remark?>
                                            <span class="badge">Dag No : <?=$remark_dag->dag_no?></span>
                                        </label>

                                        <span class="<?php if(form_error('sub_rejected_reasons['.$rej_list->reject_code.'_'.$remark_dag->dag_no.']')){echo 'lm_invalid';}?>"></span>
                                        <?=form_error('sub_rejected_reasons['.$rej_list->reject_code.'_'.$remark_dag->dag_no.']')?>

                                        <span id="additional_input<?=$remark_dag->dag_no?>_<?=$rej_list->reject_code?>">
                                                </span>
                                    </div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <div class="col<?=$rej_list->remark_head?>" <?php if(!isset($err_return)) {if($dis_cout > 0){ echo "style='display:none'"; }}?>>
                                    <label class="ml-3 mb-2 mt-2">
                                        <input class="rr_reason_class" onclick="additionalSubRemark('<?=$rej_list->reject_code;?>');" style="width: 16px; height: 16px;" type="checkbox" id="<?=$rej_list->reject_code?>" name="rejected_reasons[<?=$rej_list->reject_code?>]" value="<?=$rej_list->reject_code?>" <?php if(isset($err_return)){ if(set_value('rejected_reasons['.$rej_list->reject_code.']') == $rej_list->reject_code){ echo "checked";} }else{ if($rej_list->chitha_flag != 0)
                                        {
                                            foreach($dags as $cd)
                                            {
                                                $chithaUuid = $this->utilityclass->getVillageUUID($cd->dist_code, $cd->subdiv_code, $cd->cir_code, $cd->mouza_pargona_code, $cd->lot_no, $cd->vill_townprt_code);

                                                $resp = $this->utilityclass->getChithaFlag((string)$chithaUuid, (string)$cd->dag_no, $rej_list->chitha_flag);
                                                if($resp == true)
                                                {
                                                    echo "checked";
                                                    break;
                                                }
                                            }

                                        }
                                        }?>> &nbsp;<?=$rej_list->remark?>
                                    </label>

                                    <span class="<?php if(form_error('sub_rejected_reasons['.$rej_list->reject_code.']')){echo 'lm_invalid';}?>"></span>
                                    <?=form_error('sub_rejected_reasons['.$rej_list->reject_code.']')?>

                                    <span id="additional_input<?=$rej_list->reject_code?>">
                                            </span>
                                </div>

                                <?php }  ?>
                            <?php
                            $count++;
                        endif;
                    }
                    $dis_cout++;
                endforeach;
            }
            else
            {
                echo "No Rejected list found !";
            }
            ?>
        </div>
    </div>

</div>


<script>
    $('#rejectDiv').hide();

    $(document).ready(function () {
        var selectedRemarkCode=$('#lm_remark').val();
        if(selectedRemarkCode == 2){
            $('#rejectDiv').show();
        }
    })

    $("#lm_remark").change(function (event)
    {
        var selectedRemarkReject=$(this).val();
        if (selectedRemarkReject == 2)
        {
            $('#rejectDiv').show();
        }

        if (selectedRemarkReject != 2)
        {
            $('#rejectDiv').hide();
        }

    });
</script>

<script>
    function collapse(classN)
    {
        $('.'+classN).toggle();
    }
</script>


<script>

    $(document).ready(function (){

        $('input:checkbox.rr_reason_class').each(function (item) {
            if(this.checked)
            {
                var reject_code = $(this).val();

                var res = reject_code.split("_");
                // console.log(res[1]);

                var dag_no_remark = $('#dag_no_remark').val();
                var reject_key = item;
                additionalSubRemark(res[0], res[1]);
            }
        });
    })

    function additionalSubRemark(reject_code, dag_no_remark)
    {
        var postData = {
            'reject_code' : reject_code,
            'dag_no_remark' : dag_no_remark
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'RelinquishmentCommonController/getAdditionalInputIfAny',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType == 0)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }

                if(arr.chithaFlag != 0)
                {
                    if($('#'+reject_code+'_'+dag_no_remark).is(':checked'))
                    {
                        $('#additional_input'+dag_no_remark+'_'+reject_code).html(arr.inputContent);
                    }
                    else
                    {
                        $('#additional_input'+dag_no_remark+'_'+reject_code).html('');
                    }
                }
                else
                {
                    if($('#'+reject_code).is(':checked'))
                    {
                        $('#additional_input'+reject_code).html(arr.inputContent);
                    }
                    else
                    {
                        $('#additional_input'+reject_code).html('');
                    }
                }
            }
        });

    }

</script>




