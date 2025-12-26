
<div class="modal" role="dialog" id="hearingRemarksModal">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <?php 
                            $dag   = '';
                            $patta = '';
                            foreach($dagList as $r)
                            {
                                $dag  .= $r->dag_no.',';
                                $patta = $r->patta_no;
                            }
                            $dag   = rtrim($dag, ',');
                            // $patta = $patta;
                            $hearing_date = date('d M, Y', strtotime($hearing_date->hearing_date));
                        ?>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Hearing Remarks <span class="text-red">(This is a system-generated remark and may be subject to revision for accuracy or clarity.)</span></label>
                            <textarea placeholder="Enter Hearing Remarks" rows="10" class="form-control" 
                            id="hearing_rem" required>
Perused the report submitted by CO regarding mutation/partition/conversion of tea grant land to pp applied by <?=$applicantDetail->pdar_name?> covered by Dag no <?=$dag?> of <?=$patta?> patta of <?=$village_name->loc_name?> village in <?=$mouza_name->loc_name?> Mouza. Notice is to be served to the recorded pattadars and any other person interested under section 55/56 and 97/99/102 of ALRR 1886, read with section 4(2) of Assam Fixation of Ceiling on Land Holdings Act,1956 as amended vide Assam Fixation of Ceiling on Land Holdings Act, 2024. Office is to take steps for generating notice and causing service and also submit the notice service report also by uploading both pages of served copy. Next date of hearing fixed on <?=$hearing_date?>.

                            </textarea>
                            <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        </div>

                        <div class="col-md-12 text-bold">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recommend" id="recommend"
                                value="<?=YES?>">
                                <label class="form-check-label" for="inlineRadio1">Can be Recommended</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recommend" id="notrecommend"
                                value="<?=NO?>">
                                <label class="form-check-label" for="inlineRadio1">Can not Recommended</label>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
                <button type="button" class="btn btn-primary" id="saveHearingRemark">Save Remarks</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    $(document).ready(function(){
        $('#hearingRemarksModal').modal('show');
    });

    $("#closeModal").on('click', function(){
        $('#hearingRemarksModal').modal('hide');
    });

    $('#saveHearingRemark').on('click', function()
    {
        var hearing_rem    = $('#hearing_rem').val();
        var case_no_notice = $('#case_no_notice').val();
        var recommend      = $("input[name='recommend']:checked").val();

        if(hearing_rem == null || hearing_rem == '')
        {
            alert("Remarks is mandatory !!! ");
            $('#hearing_rem').focus();
            return false;
        }
        else if(case_no_notice == null || case_no_notice == '')
        {
            alert("Manipulation done with case no !!! ");
            $('#case_no_notice').focus();
            return false;
        }
        else if(recommend == null || recommend == '')
        {
            alert("Please select recommend / not recommend !!! ");
            $('#recommend').focus();
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        
        const params = {
            hearing_rem    : hearing_rem,
            case_no_notice : case_no_notice ,
            recommend      : recommend,
        };

        $.ajax({
            url: baseurl + "TeaGrantControllerAdc/saveHearingRemarksByAdc",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {

                // hearing_rem_btn gen_payment_notice_btn forward_dept_btn
                $.unblockUI();
                $('#hearingRemarksModal').modal('hide');
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2)
                {             
                  Swal.fire({
                    backdrop          : true,
                    allowOutsideClick : false,
                    text              : data.message,
                    confirmButtonText : 'OK',
                    customClass : {
                      actions       : 'my-actions',
                      confirmButton : 'order-2',
                    }
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.reload();
                    }
                  });

                    // showSuccessMessage(data.message);
                    // window.location.reload();
                }
                else
                {
                    showErrorMessage("Something went wrong on submitting hearing remarks !!!");
                }
            },
            data: JSON.stringify(params)
        });
    });

</script>