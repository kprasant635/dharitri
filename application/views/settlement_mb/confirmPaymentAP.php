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
  action="<?php echo base_url()?>index.php/SettlementMbCo/updateChithaAPNR"
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
            <div class="panel panel-body row">
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-3 red control-label uni_text ">Dag No</label>
                            <div class="col-lg-3">
                            <?php if($createdag==true){ ?>
                              <input type="text" class="form-control" name="dag_no" value="<?=$newdag?>">
                            <?php } else { ?>
                              <input type="text" class="form-control" readonly name="dag_no" value="<?=$dagDetails[0]->new_dag_no?>">
                            <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-3 red control-label uni_text ">New Patta Type </label>
                            <div class="col-lg-3">
                                <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case'];?>'>
                                <select  class="form-control pattaselect" id="select" name="new_patta_type">
                                    <option>Select Patta Type</option>
                                    <?php foreach ($mutpatta as $np) { ?>
                                        <option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
                                    <?php } ?>
                                </select>   
                            </div>   
                            <label for="inputEmail" class="col-lg-3 red control-label uni_text ">New Periodic Patta Proposed </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control numberonly" value='<?php echo $newpatta; ?>' placeholder='Patta Number' name="new_patta" id='new_patta' required="" value="" >
                            </div>
                            <span id='loading' class="text-danger" style="display:none">Please Wait ...Checking New Patta No</span>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-3 red control-label uni_text uni_text ">Revenue (Rs./-)</label>
                            <div class="col-lg-3">
                            <input type="number" required="" class="form-control"  name="revenue" value="">
                            </div>
                            <label for="inputEmail" class="col-lg-3 red control-label uni_text ">Local Tax (Rs./-)</label>
                            <div class="col-lg-3">
                            <input type="number" required="" class="form-control"  name="local_tax" value="">
                            </div>
                        </div>

                        <div>
                            <input type="hidden" name="payment_date" value="<?=$payment_status!=null?$payment_date:null ?>">
                            <input type="hidden"  class="numberonly form-control" name="mouza_pargona_code" value="<?= $alm->mouza_pargona_code; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="lot_no" required="" value="<?= $alm->lot_no; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="vill_townprt_code" value="<?= $alm->vill_townprt_code; ?>" >

                        </div>
            </div>
    </div>
    </div>
    


    <!-- chitha update end -->

    <?php if(ENABLE_CHITHA_UPDATE != 0){ ?>
    <div class="row justify-content-center mb-5 mt-4">
      <div class="col-md-6 text-center">
        <?php 
            if($payment_status){
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
    <?php }?>
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
