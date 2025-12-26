  <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->
  <div class="container-fluid">
  <div class="col-lg-12">
      
    <div class="row">
      <p class="uni_text">Total No. of Basundhara Case(s) in your District </p>

        <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Received: <kbd id='circle'><?=$output->data1->submitted;?></kbd>   
                </div>
              </div>
            </div>

            <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Pending: <kbd id='circle'><?=$output->data1->pending;?></kbd>   
                </div>
              </div>
            </div>
            <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Delivered: <kbd id='circle'><?=$output->data1->delivered;?></kbd>  
                </div>
              </div>
            </div>
              <div class="col-lg-3">
              <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Rejected: <kbd id='circle'><?=$output->data1->rejected;?></kbd>  
                </div>
              </div>
            </div>
      <!--Second Row Start-->
      <hr>
      <p class="uni_text">Registraion of Total Case(s) Basundhara in your District </p>
      <?php foreach($output->data as $row): ?>
      <div class="col-lg-4">
          <div class="card bg-info text-white">
                <div class="card-body text-white">
                  <h4><?=$row->service;?></h4>
                  Application Received: <kbd id='circle'><?=$row->count?></kbd>
                   <a href="<?php echo base_url() ?>index.php/basundhara/requestDistrict/<?=$row->service_code?>"><i class="fa fa-hand-o-right fa-3x pull-right" title="Please Click Here to Check Details" ></i></a> 

                 <!--  <a href="<?php echo base_url() ?>index.php/basundhara/requestServicestatus/<?=$row->service_code?>"><i class="fa fa-hand-o-right fa-3x pull-right" title="Please Click Here to Check Details" ></i></a> -->
                        
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        </div>
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
</style>

