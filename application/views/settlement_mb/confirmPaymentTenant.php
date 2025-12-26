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

<form
  action="<?php echo base_url()?>index.php/SettlementMbCo/chithaUpdateTenant"
  method="post"
>
  <input type="hidden" name="total_premium" value="<?php if($total_premium){ echo $total_premium;}?>"> 
  <input type="hidden" name="paid_amount" value="<?php if($paid_amount){ echo $paid_amount;}?>"> 
  <input type="hidden" name="remaining_amount" value="<?php if($remaining_amount){ echo $remaining_amount;}?>"> 
  <input type="hidden" name="tenure" value="<?php if($tenure){ echo $tenure;}?>"> 
  <input type="hidden" name="installment_amount" value="<?php if($installment_amount){ echo $installment_amount;}?>"> 
  <input type="hidden" name="payment_date" value="<?php if($payment_date){ echo $payment_date;}?>"> 
  <div class="container shadow bg-white">
    <div class="row mb-3">
      <h5 class="p-4 shadow" style="background: #1b707f">
        <span class="text-white p-2 shadow-sm">
          <i class="fa fa-hand-o-right" aria-hidden="true"></i>
          Payment confirmation for the case (<?=$case_no;?>)
        </span>
      </h5>

      <?php if ($this->session->flashdata('message')) : ?>
      <div class="alert alert-success">
        <strong><?= $this->session->flashdata('message'); ?></strong>
      </div>
      <?php endif; ?>
    </div>
    <!-- <input type="text" name="case_no" id='case_no' value="<?=$case_no;?>" />
 -->
    <div class="row px-4 justify-content-center">
      <div class="col-md-5 shadow m-2 border">
        <div class="row p-2 m-1" style="background: #1a6f81">
          <div class="col-12 text-white">
            <h5>Applicantion Details</h5>
            <small>
              <strong>
                Case No:
                <?=$case_no;?>
              </strong>
            </small>
          </div>
        </div>
        <div class="row bg-white p-3">
          <div class="col-12 text-center">
            <h6>
              APPLICANT CASE NUMBER
              <i class="fa fa-level-down" aria-hidden="true"></i>
            </h6>
            <h5><?=$case_no_rtps;?></h5>
          </div>
        </div>
      </div>

      <div class="col-md-5 shadow m-2 border">
        <div class="row p-2 m-1" style="background: #1a6f81">
          <div class="col-12 text-white">
            <h5>Payment Status</h5>
            <small>
              <strong>
                Date of Payment:
                <?=$payment_date;?>
              </strong>
            </small>
          </div>
        </div>

        <div class="row p-3">
          <div class="row">
          <?php
            if(trim($payment_status) == 'y'){
            ?>

              <span><strong>Total Premium Amount : <?php if($total_premium){ echo $total_premium;}?></strong></span><br>
              <span><strong>Amount Paid : <?php if($paid_amount){ echo $paid_amount." (".$percentage."%)";}?></strong></span><br>

              <?php
              if((int)$percentage != 100){
                ?>
                <span><strong>Remaining Amount : <?php if($remaining_amount){ echo $remaining_amount;}?></strong></span><br>
                <span><strong>Tenure : <?php if($tenure){ echo $tenure;}?></strong></span><br>
                <span><strong>Installment Amount : <?php if($installment_amount){ echo $installment_amount;}?></strong></span><br>
              <?php
              }
              ?>
          
            <?php
            }
            ?>
          </div>
          <div class="col-12 text-center">
            <?php
            if(trim($payment_status) == 'y'){
            ?>                          
            <i class="fa fa-check fa-4x text-success" aria-hidden="true"></i>
            <h6>PAYMENT RECEIVED</h6>

            <?php
            }else{
            ?>
            <i
              class="fa fa-times-circle-o fa-4x text-danger"
              aria-hidden="true"
            ></i>
            <h6>PAYMENT NOT RECEIVED</h6>

            <?php } ?>
          </div>
        </div>
      </div>
    </div>

<hr><br>
    <!-- chitha upadte start -->
    <div class="row">
    <div class="col-md-12 text-center">
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
                                <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case'];?>'>
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
                        
                        
                        <div class="panel-footer">
                            <input type="hidden"  class="numberonly form-control" name="mouza_pargona_code" value="<?= $alm->mouza_pargona_code; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="lot_no" required="" value="<?= $alm->lot_no; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="vill_townprt_code" value="<?= $alm->vill_townprt_code; ?>" >
                            
                            
            </div>
            </div>
    </div>
    </div>
    


    <!-- chitha update end -->


    <div class="row justify-content-center mb-5 mt-4">
      <div class="col-md-6 text-center">
        <?php 
            if($payment_status==null){
        ?>
        <button type="submit" name="payment_confirmed" class="btn btn-danger">
          Confirm Payment
        </button>
        <?php }else{ ?>
        <button
          type="submit"
          name="payment_confirmed"
          class="btn btn-danger"
          disabled
        >
          Confirm Payment NO
        </button>

        <?php }?>
      </div>
    </div>
  </div>
</form>
<!-- <form action="<?php //echo base_url()?>index.php/SettlementMbCo/redirectForPatta" method="POST">
    <input type="text" name="case_no" value="<?=$case_no?>">
    <input type="submit" name="submit">
</form> -->
<script type="text/javascript">
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
</script>
