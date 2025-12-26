<style>
    .card-content{
        background-color: #FFF;
    }
</style>
  <h5 class="bg-info p-2 text-white shadow">
    Generate Payment Notice for case: (
    <span class="bg-warning"><?=$_GET['case']?></span> )
  </h5>
  <div class="card-content shadow-sm">
    <div class="card-body">
      <?php
        if ($this->session->flashdata('message')): ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
        <strong><?php echo $this->session->flashdata('message');?></strong>
      </div>
      <?php endif; ?>
      <?php
      if($basic->pay_notice_gen_yn == 'Y'){ ?>
      <div class="text-right">
        <a href="<?php echo base_url()?>index.php/SettlementTenantCo/printNotice?case_no=<?=$_GET['case']?>" target="GenerateNotice"><button type="button" name="print_notice" type="button" class="m-1 col-1 text-white btn btn-warning btn-sm">Print Notice</button>
        </a>
      </div>
    
    <?php } ?>
      <!-- <h5 class="card-title">
        <u>CO Report</u>
      </h5> -->
      <div class="card-text mt-2 co-report">
        <form method="post" action="<?php echo base_url()?>index.php/SettlementTenantDc/generatePaymentNotice">
        <!-- <div class="mt-4 row px-5 justify-content-center">
            <div class="col-md-2">
                <label for="inputEmail4"><strong>Amount</strong></label>
            </div>
            <div class="col-md-6">
                
                <input type="number" placeholder="Enter amount..." name="payment_amount" class="form-control" required>
            </div>
        </div> -->
        
        
        
<!--         
        <div class="mt-2 row px-5 justify-content-center">
          <div class="col-md-2">
              <label for="inputEmail4"><strong>Remarks(if any)</strong></label>
          </div>
          <div class="col-md-6">
            
            <textarea
              placeholder="Remarks  ..."
              name="remark_co"
              class="form-control"
              id="remark_co"
              cols="30"
              rows="3"
            required></textarea>
            <input type="hidden" name="case_no" value="<?=$_GET['case']?>" />
          </div>
        </div> -->

        <input type="hidden" name="case_no" value="<?=$case_no?>">
        <div class="reza-card ">
            <div class="reza-body">

                <h5 class="reza-title bg-danger p-2" style="margin-top: 15px">
                    <i class="fa fa-money" aria-hidden="true"></i> Premium Calculation
                    <label>(Premium: 50 Times of Dag Revenue Value / Bigha)</label>
                </h5>

                <div class="tableCard " style="padding: 25px!important;">
                    <?php foreach ($premium_data as $dagsprem) {?>
                        <?php if(!empty($dagsprem->zonal_valuation)) { ?>
                            <div class="row justify-content-center">
                                <div class="col-md-6 ">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Land Revenue Rate for Dag : <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>" class="form-control" value="<?=$dagsprem->zonal_valuation?>" readonly/>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        <?php } ?>

                        <?php if(!empty($dagsprem->amount_dag)) { ?>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                      </div>
                                      <div class="col-md-6">
                                          <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                          <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                          <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                                      </div>
                                    </div>
                                </div>
                            </div>
                        <?php } }?>

                        <div class="row mt-3 justify-content-center">
                          <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6  text-primary">
                                    <label for="title">Final Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->final_amount?>" readonly>
                                </div>
                            </div>
                          </div>
                        </div>

                        <?php if(!empty($dagsprem->is_full_pay)) { ?>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-6 ">
                                            <label for="title">Payment Mode</label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php if($dagsprem->is_full_pay =='YES') { ?>
                                                <label for="html">Full Payment</label>
                                            <?php } else if ($dagsprem->is_full_pay =='NO') { ?>
                                                <label for="css">30% Down Payment</label>
                                            <?php } ?>

                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6">
                                  <div class="row">
                                      <div class="form-group col-md-6 text-danger">
                                          <label for="title">Total Due</label>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <input type="text" class="form-control " name="totaldue" id="totaldue"  value="<?=$dagsprem->due_amount?>" readonly>
                                      </div>
                                  </div>
                            </div>
                        </div>
                </div>


            </div>
        </div>



          <div class="row mt-4 justify-content-center">


           
       
            <?php if($basic->pay_notice_gen_yn == 'Y'){ ?>

              <button type="submit" name="generate_notice" type="button" class="m-1 col-2 text-white btn btn-danger btn-sm" disabled>Generate Notice</button>

            <?php }else{ 
              
              echo $tenant_multiple_applicant;
              ?>

              <button type="submit" name="generate_notice" type="button" class="m-1 col-2 text-white btn btn-danger btn-sm"> Generate Notice</button>

            <?php }?>

          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <ul class="list-inline pull-right">
    <li>
      <button type="button" class="btn btn-default prev-step">
        Previous
      </button>
    </li>
    <li>
      <button type="button" class="btn btn-default next-step">
        Skip
      </button>
    </li>
    <li>
 
    </li>
  </ul> -->
</div>
