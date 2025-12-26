<div class="container-fluid">
  <div class="col-lg-12 mt-2" style="border:3px solid #96907e; border-radius:5px">
    <div class="row ">
      <h5 class="text-center bg-secondary shadow p-2 mt-3">Total No. of E-khajana Cases,
      Circle: <u><?=$this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code)?></u>
      </h5>
        <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                <h4></h4>
                  Application Received: <kbd id='circle'><?=$registered_app_count;?></kbd>   
                </div>
              </div>
            </div>

            <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Pending: <kbd id='circle'><?=$pending_app_count;?></kbd>   
                </div>
              </div>
            </div>
            <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Delivered: <kbd id='circle'><?=$delivered_app_count;?></kbd>  
                </div>
              </div>
            </div>
              <div class="col-lg-3">
              <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Rejected: <kbd id='circle'><?=$rejected_app_count;?></kbd>  
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="text-warning bg-dark p-1 shadow-lg col-lg-12 mt-2 text-center" style="border:3px solid #96907e; border-radius:5px">
  <h5>Total Amount Received Till Date Through e-Khajana For 
      Circle: <u><?=$this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code)?></u>
      is Rs <?=$this->EkhajanaReportModel->getAmountReceivedForCircle($dist_code,$subdiv_code,$cir_code)?> 
  </h5>
</div>
<hr>
<div class="col-lg-12">
    <div class="row">
        <div class="col-4" ></div>
        <div class="col-4" style="text-align:center">
        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/viewLotWiseCount">
        <button class="btn btn-success shadow-lg"> CLICK HERE TO VIEW LOT WISE DATA</button>
        </a>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<style type="text/css">
  .card-body{  background: #7b4397; /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #7b4397, #dc2430); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #7b4397, #dc2430); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */);}
  #circle {
    background: #0f546a;
    border-radius: 30%;
    padding: 7px !important;
    font-weight: bold;
    font-size: 2em;
    }
    .btn-success:hover{
        background-color:#086320;
        border-color:#086320;
    }
</style>

