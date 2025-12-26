<script>
    $(function () {
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modala .modal-body').html(data);
                    $('#modala').modal('show');
                    $('#modala .modal-body').addClass('bodytest');
                }
            });
        });
    })
</script>
<div id="modala" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
                
                <div class="well well-sm mis_report">
                    <h3 class="text-center">AC to PP CO`s Final order</h3>
                </div>
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
                <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Allotment/updatechithaallotment" ?>" method="POST"  >   
                    <input type='hidden' name='case_no' value='<?= $alm->case_no; ?>' >
                    <div class='panel-body'>

                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-3">
                                <?php if($dcnote->full_partial_conversion==0){ ?>
                                <input type="text" class="form-control numberonly" placeholder='Dag Number' value='<?php echo $newdag; ?>' name="new_dag" required="" value="" >
                                <?php }else{?>
                                <input type="text" readonly class="form-control numberonly" placeholder='Dag Number' value='<?php echo $alm->new_dag; ?>' name="new_dag" required="" value="" >
                                <span class="text-success text-small">As Per LM Report Full Dag Conversion</span>
                                <?php } ?>
                            </div>
                            <label for="inputEmail" class="col-lg-3 green control-label ">New Patta Type </label>
                            <div class="col-lg-2">
                                <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case_no'];?>'>
                                <select  class="form-control pattaselect" id="select" name="new_patta_type">
                                    <option selected value="<?=$selectedPattaType?>"><?=$this->utilityclass->getPattaName($selectedPattaType);?></option>
                                    <?php foreach ($mutpatta as $np) { ?>
                                        <option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
                                    <?php } ?>
                                </select>   
                            </div>   
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-3 red control-label ">Land class Code </label>
                            <div class="col-lg-2">
                                <?=$this->utilityclass->getLandClassCode($landclasscode);?>
                            </div>
                        </div>    
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Periodic Patta Proposed </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control numberonly" value='<?php echo $newpatta; ?>' placeholder='Patta Number' name="new_patta" id='new_patta' required="" value="" >
                            </div>
                            <span id='loading' class="text-danger" style="display:none">Please Wait ...Checking New Patta No</span>
                        </div>
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Check Existing Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($dag_patta as $d) { ?>
                                        <option><?php echo $d->dag_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label for="inputEmail" class="col-lg-4 control-label ">Check Existing Patta</label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($dag_patta as $d) { ?>
                                        <option><?php echo $d->patta_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                            <div class="col-lg-2">
                                <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue" required="" value="" >
                            </div>
                            <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                            <div class="col-lg-2">
                                <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax" required="" value="" >
                            </div>
                        </div>
                        <div class="form-group"> 
                       
                            <div class="col-lg-6 offset-md-3" style="background-color:#ffb81d;padding: 24px;box-shadow: 0px 0px 4px #000">
                                <b style="font-size: 19px;color: #cf0606;">Zonal Value for Existing Dag No :  <span style="font-size: 17px;">(<?=$old_dag?> )  &nbsp;&nbsp;&nbsp; <kbd> <?=$zonalValueOfDag == null ? "N/A" : $zonalValueOfDag ;?></kbd></span> </b>
                                <hr>
                                <?php
                                if($zonalValueOfDag != null){
                                    echo "<b>NOTE : Same will be updated in new dag after CO Final Order.</b>";
                                }else{
                                    echo "<b>NOTE: No updation will be done against the new dag no.</b>";
                                }
                                ?>
                                
                            </div>
                          
                        </div>
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">DC Order </label>
                            <div class="col-lg-9">
                                <textarea rows='5' readonly class="form-control"><?= $dcnote->dc_note; ?></textarea>
                            </div>
                        </div>
                        <?php
                            if($basundharaAttachment){
                            echo '<div class=\'col-lg-12\'><h2 class="red">Basundhara Attachments</h2>';
                            foreach ($basundharaAttachment  as $attachment):
                            ?>
                            <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                            <?php 

                            endforeach; 
                        } ?>
                        <div class="panel-footer">
                            <input type="hidden"  class="numberonly form-control" name="mouza_pargona_code" value="<?= $alm->mouza_pargona_code; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="lot_no" required="" value="<?= $alm->lot_no; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="vill_townprt_code" value="<?= $alm->vill_townprt_code; ?>" >
                           

                            <button type="submit" name="submit" class="col-lg-offset-4 btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                            <div class="btn btn-info  uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                            <?php
                                $url = base_url()."index.php/Allotment/COrevertToADC?case_no=".$dcnote->case_no."&dist_code=".$dcnote->dist_code."&subdiv_code=".$dcnote->subdiv_code."&cir_code=".$dcnote->circle_code."&mouza_pargona_code=".$dcnote->mouza_pargona_code."&lot_no=".$dcnote->lot_no."&vill_townprt_code=".$dcnote->vill_townprt_code;
                            ?>

                            <a class="btn btn-warning uni_text" href="<?=$url?>"><i class='fa fa-backward'></i>&nbsp; Revert to ADC</a>
                        </div>
                    </div>
                </form>
                <center><a class="btn btn-success btn-sm uni_text" id='pr' href='<?php echo base_url() . 'index.php/Allotment/viewpro?case_no=' . $dcnote->case_no ?>'>
                                <i class="fa fa-check-square-o "></i> &nbsp; View Proceeding Report
                            </a>
                <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$dcnote->case_no?>','<?=SERVICE_ALLOTMENT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                </center>
            </div>
        </div>

    </div>
</div>    
</div>

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
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
    $('#BackHome').click(function () {
        location.href = "<?php echo base_url(); ?>index.php/home";
    });
    $(document).ready(function () {
        $(".numberonly").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        $('.pattaselect').on('change', function(event){
            var name = $("#case_no").val();
            var dataString = 'case_no='+ name;
            var pattacode = $(this).val();
                $.ajax({
                    type        : 'POST', 
                    url         : baseurl+'Allotment/dagSelectOnPattachange', 
                    data        : {'case_no': name,'pattacode': pattacode}, 
                    dataType    : 'json', 
                    encode      : true,
                    beforeSend: function(){
                                $("#loading").show();
                                $('.btn-primary').hide();
                            },
                    success: function(data){
                      if(data.success!=null){
                        $("#loading").hide();
                        $('.btn-primary').show();
                        $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                        $("#new_patta").val(data.new_patta);
                      }
                    },
                    error:function(data){
                        alert('Something went wrong');
                    }
                });
        });
    });
</script>