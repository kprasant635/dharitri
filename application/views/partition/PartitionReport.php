<div class="form-top login">
    <div class="container"> 
    <div class="row">
			
        <div class="col-lg-12 panel-form " style="padding: 10px">
            <div class="btn btn-info col-lg-offset-1 uni_text" id="backMain"><i class="fa fa-reply "></i> &nbsp; <?php echo $this->lang->line('previous_menu') ?></div>
            <div class="btn btn-warning uni_text" ><a href="<?php echo base_url()."index.php/Partition/ModalPartitionRpt" ?>?case_no=<?php echo $this->session->userdata('case_no') ?>&petition_no=<?php echo $this->session->userdata('petition_no') ?>" class='vp'><i class="fa fa-book "></i> &nbsp; <?php echo $this->lang->line('see_application_rpt') ?></a></div>
            <div class="btn btn-danger uni_text"><a class='vp'  href="<?php echo base_url()."index.php/ChithaReport/modalgenerateChitha" ?>?case_no=<?php echo $this->session->userdata('case_no') ?>" href='#' style="color: #fff" target="_blank"><i class="fa fa-book "></i> &nbsp; <?php echo $this->lang->line('show_chitha') ?></a></div>
            <div class="btn btn-primary uni_text"><a class="vp"  href="<?php echo base_url()."index.php/Partition/LMreportBasuView" ?>?case_no=<?php echo $this->session->userdata('case_no') ?>" style="color: #fff" target="_blank" ><i class="fa fa-book "></i> &nbsp; LM Previous Report (if Exists)</a></div>
            <div class="btn btn-primary hide uni_text"><a class="vp"  href="<?php echo base_url()."index.php/Partition/saveJamabandiByPattano" ?>?case_no=<?php echo $this->session->userdata('case_no') ?>" style="color: #fff" target="_blank" ><i class="fa fa-book "></i> &nbsp; <?php echo $this->lang->line('show_jamabandi') ?></a></div>
			
            <h2 class="text-center"><?php echo $this->lang->line('mondal_report') ?> (<?php echo $this->lang->line('case_no') ?> <?php echo $this->session->userdata('case_no') ?>)</h2>
                <?php
                    if($this->session->flashdata('message')){
                  ?>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>
            <hr>
            <form class="form-horizontal unicode" method="POST" action="<?php echo base_url(); ?>index.php/partition/saveLMReportOC">
                <?php if(ESCALATION_ENABLE == 1){ ?>
                        <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                        <?php 
                            include(APPPATH."views/escalation/remaining_time.php");
                        ?>
                <?php } ?>
                
                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('mutation_is_not')?></label>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo" checked="" name="partition_yn" value="Y"> <span class="uni_text">Yes </span> 
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo" name="partition_yn" value="N"> <span class="uni_text">No</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-6 required control-label"><?php echo $this->lang->line('mutation_year')?></label>
                    <div class="col-sm-3">
                        <select id='year' class="form-control" required="" name="partition_year"></select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-6 required control-label"><?php echo $this->lang->line('partition_how')?></label>
                    <div class="col-sm-3">
                        <select class="form-control" name="trans_code">
                            <option> Select Option</option>
                            <?php
                            foreach ($data as $r) {
                                echo "<option required value='$r->trans_code'>$r->trans_desc_as</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_other_case')?></label>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo" name="other_cases_yn" value="Y">  <span class="uni_text">Yes </span> 
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" checked="" class="squaredTwo" name="other_cases_yn" value="N">  <span class="uni_text">No </span> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="select" class="col-lg-6 required control-label"><?php echo $this->lang->line('partition_revenue_year')?> </label>
                    <div class="col-sm-3">
                        <select id="upyear" class="form-control" required="" name="revenue_paid_year"></select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('consent_yes_no')?></label>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo"  name="copdar_yn" value="Y">  <span class="uni_text">Yes </span> 
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo" checked="" name="copdar_yn" value="N">  <span class="uni_text">No </span> 
                    </div>
                </div>


                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('trace_map_show')?></label>
                    <div class="col-sm-1">
                        <input type="radio" checked="" class="squaredTwo" name="trace_map_yn" value="Y">  <span class="uni_text">Yes </span> 
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo" name="trace_map_yn" value="N">  <span class="uni_text">No </span> 
                    </div>
                </div>          
                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('tracemap_byayprak')?></label>
                    <div class="col-sm-1">
                        <input type="radio" checked="" class="squaredTwo" name="ror_byayprak_yn" value="Y"> <span class="uni_text">Yes </span> 
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" class="squaredTwo" name="ror_byayprak_yn" value="N"> <span class="uni_text">No </span> 
                    </div>

                </div>

                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('short_notes')?> </label>
                    <div class="col-lg-6">
                        <textarea class="form-control" name="lm_note" rows="3" > লাট  মন্ডলৰ দ্বাৰা  প্রতিবেদন দাখিল  কৰা হল | </textarea>
                    </div>

                </div>

                <div class="form-group">
                    <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('min_revenue')?> </label>
                    <div class="col-sm-3">
                        <input type="number" required="" id="quantity" maxlength="4" class="form-control" name="min_revenue" value="<?php echo round($dags->revenue) ; ?>" >
                        <span id="errmsg"></span>
                    </div>
                </div>
                <div class="form-group hidden">
                    <label for="select" class="col-lg-6 control-label" style="color: #cc0000"><?php echo $this->lang->line('merge_old_patta')?></label>
                    <div class="col-sm-3">
                        <input type="checkbox" class="squaredTwo"  name="IspattaSelect" id="Ispatta" value="Y">
                    </div>
                </div>
                <div class="form-group" id="OldPatta">
                    <label for="select" class="col-lg-6 control-label" style="color: #cc0000"><?php echo $this->lang->line('type_patta_number')?></label>
                    <div class="col-sm-3">
                        
                        <select class="form-control" name="sugg_patta_no">
                            <?php
                            foreach ($oldPatta as $old):
                            ?>
                            <option value="<?php echo $old->patta_no ?>"><?php echo $old->patta_no ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
<!--                        <input type="text" class="form-control" id="old_patta_no" name="sugg_patta_no">-->
                    </div>
                </div>
                <?php include(APPPATH.'views/multipleUpload.php')?>
                <?php if(!empty($sup_doc)): ?>
                 <div class="row col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <label><span class="pull-left">View Document Uploaded</span></label>
                    <table class="table table-striped table-bordered">
                    <tbody> 
                        <?php foreach($sup_doc as $jama): ?>
                        <tr>
                            <td width="20%"><span class="text-bold"><?=$jama->file_name?$jama->file_name:JAMABANDI?></span>
                            </td>
                            <td width="20%">
                                <button class="btn btn-sm btn-info"><a href="<?=base_url()?>index.php/uploadDocuments/downloadDocuments/<?=$jama->id?>" target="_blank">View Jamabandi&nbsp;<i class="fa fa-plus-square"></i></a></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
                <?php endif;?>
                <?php if($pb->application_ref_no){ ?>
                    <div class="bs-callout bs-callout-danger alert alert-info" >
                        <code><span class='font-italic'>Mobile Number of the Applicant: <?= $mobile_no ?></span></code>
                        <h4>ByayPrak Report will be automatically submited as  <code>&lt;NIL or Rs./ 0 &gt;</code> for RTPS case(s)</h4>
                        <p>There is no need to submit Byay-Prak report again.</p>
                    </div>
                <?php } ?>

                    <!-- /////////ESCALATION REMARK///////////// -->
                    <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $pb->es_flag == 1 && $pb->out_of_esc == 0) { ?>
                    <div class="col-lg-12">
                        <div class="form-group col-md-4 text-right">
                            <label class="red"> Cause For the case has not been pass in the timeline : </label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                        </div>
                    </div>
                    <?php } ?>

                <?php
                    if($attachment){
                    echo '<h2 class="red">Other Attachments</h2>';
                    foreach ($attachment  as $attachment):
                    //var_dump($attachment);
                    ?>
                    <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $pb->application_ref_no .'&type='. 2 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                    <?php 
                    endforeach; 
                    }
                ?>
                <?php
                    if($basundharaAttachment){
                    echo '<h2 class="red">Other Attachments</h2>';
                    foreach ($basundharaAttachment  as $attachment):
                    ?>
                    <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                    <?php 
                    endforeach; 
                    }
                ?>
                <input type="hidden" name="application_ref_no" value="<?=$pb->application_ref_no?>">
                <button type="submit" name="submit" class="btn btn-primary uni_text col-lg-offset-5"><i class="fa fa-share "></i> &nbsp; প্রতিবেদন দাখিল কৰক</button>    

            </form>


        </div>
    </div>
    </div>
</div>
<script>
        var elem = document.getElementById('OldPatta'),
        checkBox = document.getElementById('Ispatta');
        checkBox.checked = false;
        checkBox.onchange = function() {
        elem.style.display = this.checked ? 'block' : 'none';
        };
        checkBox.onchange();
</script>
<script>
var select = document.getElementById('year'),
year = new Date().getFullYear()+1,
html = '<option value="0">Select Option</option>';
for(i = year; i >= year-90; i--) {
  html += '<option value="' + i + '">' + i + '</option>';
}
select.innerHTML = html;
</script>
<script>
var select = document.getElementById('upyear'),
    year = new Date().getFullYear()+1,
    html = '<option value="0">Select Option</option>';
for(i = year; i >= year-90; i--) {
  html += '<option value="' + i + '">' + i + '</option>';
}
select.innerHTML = html;
</script>
<script type="text/javascript">
        document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home";
    };
</script>
<script>
     $(function () {
        $('.vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-body').html(data);
                    $('#myModal').modal('show');
                    $('body').addClass('bodytest');
                }
            });
            
        });
    });
</script>
<div class="modal"  id='myModal' >
    <div class="modal-dialog modal-lg " >
        <div class="modal-content  modal-lg ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" >
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
    </div>
    </div>
</div>
<style type="text/css">
    .modal{
         overflow-y:auto;
         overflow-x: hidden;
    }
     .bodytest{
         //display: inline-block;
         position: relative;
         padding: 0px !important;
    }
    
</style>
