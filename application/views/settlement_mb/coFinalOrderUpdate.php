<script>
    $(function () {
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });
        });
    })
</script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
                <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/SettlementMbCo/chithaUpdate" ?>" method="POST"  >   
                    <input type='hidden' name='case_no' value='<?= $alm->case_no; ?>' >
                    <div class='panel-body'>

                        <div class="form-group ">
                            <?php $dag_count=false;$i=1;
                            foreach($dagDetails as $dags){
                             ?>
                            <?php if($dags->land_type==3){ 
                                $dag_count=true;
                                ?>
                            <span class="badge badge-danger">Old Dag: <?=$dags->dag_no?></span>  
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-3">
                                <input type="hidden" name="old_dag[<?=$i?>]" value="<?=$dags->dag_no?>">
                                <input type="hidden" name="partitionType[<?=$i?>]" value="1">
                                <input type="text" class="form-control numberonly" value='<?php echo $newdag; ?>' placeholder='Dag Number' name="new_dag[<?=$i?>]" required="" value="" >
                                <span class=" badge badge-success">Homestate Area: <?=$dags->home_b ." B -" .$dags->home_k ." K -" .$dags->home_lc ."LC" ?></span>
                            </div>
                            <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Land Class of New Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control" required name="land_class[<?=$i?>]">
                                    <option value="">Select Land Class</option>
                                    <?php foreach ($land_class_code as $lccode) { ?>
                                        <option value="<?=$lccode->class_code?>"><?php echo $lccode->land_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                            <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue[<?=$i?>]" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax[<?=$i?>]" required="" value="" >
                                </div>
                            </div>
                            <hr>
                            <?php $i=$i+1;?>
                            <span class="badge badge-danger">Old Dag: <?=$dags->dag_no?></span>
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-3">
                                <input type="hidden" name="old_dag[<?=$i?>]" value="<?=$dags->dag_no?>">
                                <input type="hidden" name="partitionType[<?=$i?>]" value="2">
                                <input type="text" class="form-control numberonly" value='<?php echo $newdag=$newdag+1; ?>' placeholder='Dag Number' name="new_dag[<?=$i?>]" required="" value="" >
                                <span class=" badge badge-success">Agricultural Area: <?=$dags->agri_b ." B -" .$dags->agri_k ." K -" .$dags->agri_lc ." LC" ?></span>
                            </div>
                            <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Land Class of New Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control" required name="land_class[<?=$i?>]">
                                    <option value="">Select Land Class</option>
                                    <?php foreach ($land_class_code as $lccode) { ?>
                                        <option value="<?=$lccode->class_code?>"><?php echo $lccode->land_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue[<?=$i?>]" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax[<?=$i?>]" required="" value="" >
                                </div>
                            </div>
                        <hr>
                        <?php } ?>
                        <?php if($dags->land_type==2){ 
                            $dag_count=true;
                            $i=$i+1;
                            ?>
                            <span class="badge badge-danger">Old Dag: <?=$dags->dag_no?></span>  
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-3">
                                <input type="hidden" name="old_dag[<?=$i?>]" value="<?=$dags->dag_no?>">
                                <input type="hidden" name="partitionType[<?=$i?>]" value="2">
                                <input type="text" class="form-control numberonly" value='<?= $dag_count==false? $newdag:($newdag=$newdag+1) ?>' placeholder='Dag Number' name="new_dag[<?=$i?>]" required="" value="" >
                                <span class=" badge badge-success">Agricultural Area: <?=$dags->agri_b ." B -" .$dags->agri_k ." K -" .$dags->agri_lc ."LC" ?></span>
                            </div>
                            <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Land Class of New Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control" required name="land_class[<?=$i?>]">
                                    <option value="">Select Land Class</option>
                                    <?php foreach ($land_class_code as $lccode) { ?>
                                        <option value="<?=$lccode->class_code?>"><?php echo $lccode->land_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                            <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue[<?=$i?>]" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax[<?=$i?>]" required="" value="" >
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($dags->land_type==1){
                            $dag_count=true;
                            $i=$i+1;
                         ?>  
                            <span class="badge badge-danger">Old Dag: <?=$dags->dag_no?></span>  
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-3">
                                <input type="hidden" name="old_dag[<?=$i?>]" value="<?=$dags->dag_no?>">
                                <input type="hidden" name="partitionType[<?=$i?>]" value="1">
                                <input type="text" class="form-control numberonly" value='<?= $dag_count==false? $newdag:($newdag=$newdag+1) ?>' placeholder='Dag Number' name="new_dag[<?=$i?>]" required="" value="" >
                                <span class=" badge badge-success">Homestate Area: <?=$dags->home_b ." B -" .$dags->home_k ." K -" .$dags->home_lc ."LC" ?></span>
                            </div>
                            <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Land Class of New Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control" required name="land_class[<?=$i?>]">
                                    <option value="">Select Land Class</option>
                                    <?php foreach ($land_class_code as $lccode) { ?>
                                        <option value="<?=$lccode->class_code?>"><?php echo $lccode->land_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                            <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue[<?=$i?>]" required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax[<?=$i?>]" required="" value="" >
                                </div>
                            </div>
                        <?php } ?>

                        <?php     }?>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-3 green control-label ">New Patta Type </label>
                            <div class="col-lg-3">
                                <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case_no'];?>'>
                                <select  class="form-control pattaselect" id="select" name="new_patta_type">
                                    <option>Select Patta Type</option>
                                    <?php foreach ($mutpatta as $np) { ?>
                                        <option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
                                    <?php } ?>
                                </select>   
                            </div>   
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Periodic Patta Proposed </label>
                            <div class="col-lg-3">
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
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">DC Order </label>
                            <div class="col-lg-9">
                                <textarea rows='5' readonly class="form-control"><?= $dcnote; ?></textarea>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input type="hidden"  class="numberonly form-control" name="mouza_pargona_code" value="<?= $alm->mouza_pargona_code; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="lot_no" required="" value="<?= $alm->lot_no; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="vill_townprt_code" value="<?= $alm->vill_townprt_code; ?>" >
                            
                            
                            <!-- -js- view proceeding report 30-08-22 -->
                            <!-- <a class="btn btn-danger uni_text" id='pr' href='<?php //echo base_url() . 'index.php/SettlementMbCo/viewProceeding?case_no=' . $dcnote->case_no ?>'>
                                <i class="fa fa-check-square-o "></i> &nbsp; View Proceeding Report
                            </a> -->


                            <button type="submit" name="submit" class="col-lg-offset-4 btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                            <div class="btn btn-info  uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                            <!-- <?php
                                $url = base_url()."index.php/Allotment/COrevertToADC?case_no=".$alm->case_no."&dist_code=".$alm->dist_code."&subdiv_code=".$alm->subdiv_code."&cir_code=".$alm->cir_code."&mouza_pargona_code=".$alm->mouza_pargona_code."&lot_no=".$alm->lot_no."&vill_townprt_code=".$alm->vill_townprt_code;
                            ?>

                            <a class="btn btn-warning uni_text" href="<?=$url?>"><i class='fa fa-backward'></i>&nbsp; Revert to ADC</a> -->
                        </div>
                </form>

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
                    url         : baseurl+'SettlementMbCo/dagSelectOnPattachange', 
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