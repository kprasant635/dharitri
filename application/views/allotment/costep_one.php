<?php
    ///////////// BARAK VALLEY CODE START HERE ////////////////
    $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
?>


<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalACPP .modal-content').html(data);
                    $('#modalACPP ').modal('show');
                    //$('body').addClass('bodytest');
                }
            });

        });
        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalACPP .modal-content').html(data);
                    $('#modalACPP ').modal('show');
                    //$('body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalACPP .modal-content').html(data);
                    $('#modalACPP').modal('show');
                    //$('body').addClass('bodytest');
                }
            });

        });

        $('#cbsic').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalACPP .modal-content').html(data);
                    $('#modalACPP').modal('show');
                    //$('body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
        <?php //var_dump($allotment_certificate);
        //var_dump($allotment_cb);
        //echo $base_path;
                        $link="./Certificate/".$allotment_certificate->name_of_certificate;
                        //$link=force_download('./Certificate/to/photo.jpg', NULL);
                ?>
            <div class="panel panel-info panel-form">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Allotment/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
                    <a class="btn btn-success uni_text" id='lm' href='<?php echo base_url() . 'index.php/Allotment/viewlmnote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View LM Report
                    </a>
                    <?php if($basuCase==null){ ?>
                    <a class="btn btn-success uni_text" target='_blank' href='<?php echo base_url() . 'index.php/Allotment/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Allotment Certificate
                    </a>
                    <?php } ?>
                    <a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>
                </div>
                <form class=" unicode" action="<?php echo base_url()."index.php/Allotment/savecofirstorder" ?>" method="POST"  >              
                <div class='panel-body'>
                <?php
                    if($this->session->flashdata('message')){
                  ?> <br> <br> <br>
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
                <br>
                <?php
                        ///////////// BARAK VALLEY CODE START HERE ////////////////
                        if($barak) {
                    ?>
                        <h2 class="text-center" style="top:20px;">সার্কেল অফিসারের আদেশ </h2>
                        <table class="table_border">
                            <tr>
                                <td class="uni_text">কেস নং : <?php echo $allotment_cb->case_no ;?></td>
                                <td class="uni_text">রুলিং সিরিয়াল নং : 1 </td>
                                <td class="uni_text">তাং : <?php echo date('d-m-Y',strtotime($allotment_cb->date_entry)) ; ?></td>
                            </tr>
                        </table>
                        <hr>
                        <p class='uni_text'>
                            আবেদনকারীর দ্বারা বরাদ্দকৃত জমি বরাদ্দের জন্য আবেদনটি খতিয়ে দেখা হয় । ভূমিলেখ্য সহায়ক এবং ভূমিলেখ্য পৰ্যবেক্ষক এটি সারজামিন পরিমাপ করবে এবং একটি বিস্তারিত প্রতিবেদন জমা দেবে । প্রতিবেদন জমা দেওয়ার পরবর্তী তারিখ <input type="text" name="next_date" required  id="popupDatepicker" placeholder="DD/MM/YYYY" autocomplete="off" class="form-control " style="width: 250px" > নির্ধারণ করা হয়েছে ।
                        </p>
                        <input type='text' class='hide' name='proceeding1' value="আবেদনকারীর দ্বারা বরাদ্দকৃত জমি বরাদ্দের জন্য আবেদনটি খতিয়ে দেখা হয় । ভূমিলেখ্য সহায়ক এবং ভূমিলেখ্য পৰ্যবেক্ষক এটি সারজামিন পরিমাপ করবে এবং একটি বিস্তারিত প্রতিবেদন জমা দেবে । প্রতিবেদন জমা দেওয়ার পরবর্তী তারিখ  ">
                        <input type='text' class='hide' name='proceeding2' 
                        value="  নির্ধারণ করা হয়েছে । ">
                        <input type='text' class='hide' name='case_no' value='<?php echo $allotment_cb->case_no ?>'>
                       
                        <p class="pull-right hide uni_text"><br>সার্কেল অফিসার ,</p> 
                        <hr> 
                        <label class="radio-inline hide uni-text col-lg-offset-2">
                            <input type="radio" name="next_hearing" disabled=""  value="F"> 
                            চূড়ান্ত হুকুম দিন
                        </label>
                        <label class="radio-inline uni-text">
                            <input type="radio" name="next_hearing"  value="P" checked=""> প্রক্রিয়া চালিয়ে যান 
                        </label>
                    <?php } 
                    else{?>
                    <h2 class="text-center" style="top:20px;">চক্র বিষয়াৰ হুকুম </h2>
                    <table class="table_border">
                        <tr>
                            <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no ;?></td>
                            <td class="uni_text">হুকুম  ক্রমিক নং : 1 </td>
                            <td class="uni_text">তাং : <?php echo date('d-m-Y',strtotime($allotment_cb->date_entry)) ; ?></td>
                        </tr>
                    </table>
                   
                    <hr>
                    <p class='uni_text'>
                        আবেদনকাৰীয়ে আবন্টন পোৱা মাটিৰ পট্টন বিচাৰি কৰা  আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক  আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি  বিতং প্রতিবেদন দাখিল কৰিব  |
                         প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ <input type="text" name="next_date" required  id="popupDatepicker" placeholder="DD/MM/YYYY" autocomplete="off" class="form-control " style="width: 250px" >   ধাৰ্য্য কৰা হল |
                    </p>
                    <input type='text' class='hide' name='proceeding1' value="আবেদনকাৰীয়ে আবন্টন পোৱা মাটিৰ পট্টন বিচাৰি কৰা  আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক  আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি  বিতং প্রতিবেদন দাখিল কৰিব  | প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ  ">
                    <input type='text' class='hide' name='proceeding2' value="  ধাৰ্য্য কৰা হল | ">
                    <input type='text' class='hide' name='case_no' value='<?php echo $allotment_cb->case_no ?>'>
                   
                     <p class="pull-right hide uni_text">
                        <?php // echo $coname->username; ?><br>
                                                   চক্র বিষয়া ,
                                                   <?php //echo $location['cir']?>
                    </p> 
                    <hr> 
                    <label class="radio-inline hide uni-text col-lg-offset-2">
                        <input type="radio" name="next_hearing" disabled=""  value="F"> অন্তিম হকুম দিয়ক 
                    </label>
                    <!-- <label class="radio-inline col-lg-offset-2 uni-text">
                        <input type="radio" name="next_hearing"  value="D"> প্রস্তাৱ খাৰিজ কৰক 
                    </label> -->
                    <label class="radio-inline uni-text">
                        <input type="radio" name="next_hearing"  value="P" checked=""> প্রক্রিয়া জাৰি ৰাখক 
                    </label>
                    <?php } ///////////// BARAK VALLEY CODE START HERE //////////////// ?>
                    <div>
                    <?php if($basuCase){ ?>
                    <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                    <?php } ?>
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

                            <?php
                             if($query){
                          echo "<center class='uni_text text-danger'>All Query</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                          foreach($query as $q){
                            ?>
                              <tr>
                                <td><?=$q->date_of_query?></td>
                                <td><?=$q->query_text?></td>
                                <td><?=$q->date_of_reply?></td>
                                <td><?=$q->reply_text;
                                  if($q->app_doc_id){ 
                                    echo "<br>";
                                    echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>                            
                        <?php } echo "</table>"; } ?>
                        <?php if(isset($noc_cert) and !empty($noc_cert)) { ?>
                <div class="col-lg-12"><h2 class="red">View NOC (For Changing Dag)</h2>
                <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$noc_cert->id?>" class="red" download target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo NOC;?> (Click to see the attachment)</a></h6>
                </div>  
                <?php } ?>

                <?php if(isset($allot_cert) and !empty($allot_cert)) { ?>
                <div class="col-lg-12"><h2 class="red">View <?=ALLOT_CERT?></h2>
                <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$allot_cert->id?>" class="red" download target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo ALLOT_CERT;?> (Click to see the attachment)</a></h6>
                </div>  
                <?php } ?>
                </div>
                </div>

                <div class="panel-footer">    

                    <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                    <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$allotment_cb->case_no?>','<?=SERVICE_ALLOTMENT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                     <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>                  
<!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
                </div>
                </form>               
            </div>
         </div>       
    </div>        
</div>
<div class="modal" id='modalACPP' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<!-- Modal HTML -->
<!-- <div id="myModal1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div> -->

<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
                <?php
                    if($this->session->flashdata('query_mdl_message')){
                ?>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('query_mdl_message'); ?>
                            </strong>
                          </div>
                        </div>
                <?php
                    }
                ?>
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<style type="text/css">
    .modal{
        overflow-y:auto;
        overflow-x: hidden;
    }
    .bodytest{
        position: relative;
        padding: 0px !important;
    }
</style>
<script>
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
    $('#BackHome').click(function(){
    location.href = "<?php echo base_url(); ?>index.php/home";
    });
</script>