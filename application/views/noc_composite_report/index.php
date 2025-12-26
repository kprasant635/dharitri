<style>      
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
</style>
<div class="container-fluid">
    <div class="col-lg-12 mt-5" style="border: 2px solid; padding: 5px;">      
      <div class="row">
        </br></br></br>
        <div class="container-fluid"> 
          <div class="card-header text-center text-bold bg-secondary text-white">
            <?=$header?>
          </div>
        </div>
        </br></br></br>     
        <div class="col-lg-3">
            <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/registered">
            <div class="card">
                  <div class="card-body text-white">
                    <h4></h4>
                      Application Received: <kbd id='circle'><?=$registered_count?></kbd>   
                  </div>
              </div>
              </a>
        </div>
        <div class="col-lg-3">
          <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/pending">
            <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Pending: <kbd id='circle'><?=$pending_count?></kbd>   
                </div>
            </div>
          </a>
        </div>     
        <div class="col-lg-3">
            <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/delivered">
            <div class="card">
                  <div class="card-body text-white">
                    <h4></h4>
                    Application Delivered: <kbd id='circle'><?=$delivered_count?></kbd>  
                  </div>
              </div>
              </a>
          </div>     
          <div class="col-lg-3">
              <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/rejected">
              <div class="card">
                  <div class="card-body text-white">
                    <h4></h4>
                    Application Rejected: <kbd id='circle'><?=$reject_count?></kbd>  
                  </div>
              </div>
              </a>
          </div>
      
      </div>
    </div>
</div>
</br></br>      
<div class="container-fluid mb-3" style="border: 2px solid; padding: 5px;"> 
  <div class="card-header text-center text-bold bg-secondary text-white">
      Detailed Breakdown Of Services(<?=$flag?> cases)
  </div>

  <div class="col-lg-12 mt-3">      
      <div class="row">
        <div class="col-lg-3"></div>
          <div class="col-lg-3">
              <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/circle_am?flag=<?=$flag?>">
                <div class="card">
                    <div class="card-body text-white">
                      <h4></h4>
                      Auto Mutation: <kbd id='circle'><?=$am_registered_count?></kbd>   
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3">
                <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/circle_amp?flag=<?=$flag?>">
                  <div class="card">
                      <div class="card-body text-white">
                        <h4></h4>
                        Auto Mutation Partition: <kbd id='circle'><?=$amp_registered_count?></kbd>   
                      </div>
                  </div>
                </a>
            </div>
            <div class="col-lg-3"></div>
          </div>
      </div>
  </div>
</div>


        

   


   