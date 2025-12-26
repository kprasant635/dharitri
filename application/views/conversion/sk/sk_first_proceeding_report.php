<div class="row mt-2">
    <div class="col-md-12 col-lg-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-between">
                <h5><?php echo $this->lang->line('case_no'); ?> : <?php echo $petition_basic->case_no; ?></h5>
                <h5>( দাগ নং  : <?php echo $petition_dag_details->dag_no; ?> )</h5>
                <h5><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="mainform">
                            <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                            <input type="hidden" id="case_no" name="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                            <input type="hidden" id="dag_no" name="dag_no" value="<?php echo $petition_dag_details->dag_no; ?>"/>
                            <input type="hidden" id="note_no" name="note_no" value="<?php echo $petition_lm_note_details->note_no; ?>"/>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td><label class="control-label" >১) ভূমিলেখ্য পৰ্যবেক্ষকৰ অন্যান্য তথ্য ও মন্তব্য <span class="red">*</span></label></td>
                                        <td width="50%"><textarea name="sk_notice" id="sk_notice" class="form-control" cols="8" rows="8" required placeholder="ভূমিলেখ্য সহায়কৰ প্রতিবেদন আৰু নথি পৰীক্ষা কৰা হ'ল । আবেদন কৰা ভূমি অসম ভূমিলক্ষ্য নিয়মাৱলী ১০৫ ধাৰা মতে মিয়াদীৰ উপযোগী পোৱা হয়।. প্ৰিমিয়াম আদায় মৰ্মে ম্যদীকৰনৰ হুকুম দিব পাৰে ।">ভূমিলেখ্য সহায়কৰ প্রতিবেদন আৰু নথি পৰীক্ষা কৰা হ'ল । আবেদন কৰা ভূমি অসম ভূমিলক্ষ্য নিয়মাৱলী ১০৫ ধাৰা মতে মিয়াদীৰ উপযোগী পোৱা হয়।. প্ৰিমিয়াম আদায় মৰ্মে ম্যদীকৰনৰ হুকুম দিব পাৰে ।</textarea></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td colspan="2">
                                            <label class="control-label" >২) ভূমিলেখ্য পৰ্যবেক্ষকৰ চহী &nbsp;<span class="red">*</span></label>
                                            <label>
                                                <input type="radio" name="sk_sign" id="inlineRadio1" value="Y" checked> আছে  
                                            </label>
                                            <label>
                                                <input type="radio" name="sk_sign" id="inlineRadio2" value="N"> নাই
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" >২) ভূমিলেখ্য পৰ্যবেক্ষকৰ নাম &nbsp;<span class="red">*</span></label>
                                            <input type="hidden" id="sk_code" name="sk_code" value="<?php echo $sk_details->user_code; ?>"/>
                                            <input type="text" id="sk_name" name="sk_name" style="width: 200px;" value="<?php echo $sk_details->username; ?>">
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="2">
                                            <label class="control-label" >৪) ভূমিলেখ্য পৰ্যবেক্ষকৰ টোকা লিখাৰ তাৰিখ &nbsp;<span class="red">*</span></label>
                                            <input type="date" id="sk_date_of_entry" name="sk_date_of_entry" id="popupDatepicker" style="width: 200px;" required>
                                            <label class="control-label" >&nbsp; (dd/mm/yyyy)</label>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </form>
                        <?php
                            // if($basundhar_application){
                            //     echo '<h6 class="red">Other Attachments</h6>';
                            //     foreach ($basundhara_attachment  as $attachment):
                            //     ?>
                            <!--          <p><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red fs-6" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></p> -->
                                 <?php 
                            //     endforeach; 
                            // }
                            // else{
                            //     echo '<h6 class="red">Other Attachments</h6>';
                            //     foreach($supportive_documents as $docs):
                            //     ?>
                            <!--          <p><a class="red fs-6" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></p> -->
                                 <?php
                            //     endforeach;
                            // }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <button type="button" name="submit" id="mainFormSubmit" class="btn btn-success uni_text btnSubmit mr-2 ml-2"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                <?php if($basundhar_application): ?>
                    <!-- <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i> Query to Applicant(s)</button> -->
                <?php endif; ?>
                <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url(); ?>index.php/go_to_sk?pro=1"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#mainFormSubmit', (e) => {
        var baseurl = $('#baseurl').val();
        var case_no = $('#case_no').val();
        var dag_no = $('#dag_no').val();
        var note_no = $('#note_no').val();
        var sk_notice = $('#sk_notice').val();
        var sk_code = $('#sk_code').val();
        var sk_name = $('#sk_name').val();
        var sk_date_of_entry = $('#sk_date_of_entry').val();
        var sk_sign = $('input[name="sk_sign"]:checked').val();

        if(case_no == '' || dag_no == '' || note_no == '' || sk_notice == '' || sk_code == '' || sk_name == '' || sk_date_of_entry == '' || sk_sign == '') {
            swal.fire("", "All fields with (*) mark are mandatory", "error")
            .then((value) => {
                
            });
            return false;
        }

        var mainform = document.getElementById("mainform");
        console.log(mainform);
        const formData = new FormData(mainform);
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + 'index.php/sk_first_proceeding_post',
            method: 'POST',
            dataType: 'JSON',
            data:formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.unblockUI();
                if(response.status == 'SUCCESS') {
                    swal.fire("", response.msg, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                else if(response.status == 'FAILED') {
                    swal.fire("", response.msg, "error")
                    .then((value) => {
                        
                    });
                }
            },
            error: function(err) {
                $.unblockUI();
                console.log(err);
            }
        });
    });
</script>