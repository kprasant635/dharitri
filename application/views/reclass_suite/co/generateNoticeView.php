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
        <form
          method="post"
          action="<?php echo base_url()?>index.php/SettlementTenantCo/generatePaymentNoticeCo"
        >
        <div class="mt-4 row px-5 justify-content-center">
            <div class="col-md-2">
                <label for="inputEmail4"><strong>Amount</strong></label>
            </div>
            <div class="col-md-6">
                
                <input type="number" placeholder="Enter amount..." name="payment_amount" class="form-control" required>
            </div>
        </div>
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
          </div>
          <div class="row mt-4 justify-content-center">
       
       <?php
            if($basic->pay_notice_gen_yn == 'Y'){ ?>

            <button
            type="submit"
            name="generate_notice"
            type="button"
            class="m-1 col-2 text-white btn btn-danger btn-sm"
            disabled
          >
            Generate Notice
          </button>

          <?php }else{ ?>
            <button
            type="submit"
            name="generate_notice"
            type="button"
            class="m-1 col-2 text-white btn btn-danger btn-sm"
          >
            Generate Notice
          </button>
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
