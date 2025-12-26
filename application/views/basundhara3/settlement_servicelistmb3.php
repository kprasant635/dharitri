<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row"> <!--Second Row Start-->
      <?php foreach($output as $row): ?>
      <div class="col-lg-4">
        <div class="card bg-info text-white">
          <div class="card-body text-white">
            <h4><?=$row->service;?></h4>
            Application Received: <kbd id='circle'><?=$row->count?></kbd>

            <?php
            if($row->service_code == 25){
              if(NC_LIVE !=0)
              {
                ?>
                <a href="<?php echo base_url() ?>index.php/NcVillageHomeController/request/<?=$row->service_code?>"><i class="fa fa-hand-o-right fa-3x pull-right" title="Please Click Here to Check Details" ></i></a>
                <?php
              }
            }else{
            ?>
              <a href="<?php echo base_url() ?>index.php/basundhara3/request/<?=$row->service_code?>"><i class="fa fa-hand-o-right fa-3x pull-right" title="Please Click Here to Check Details" ></i></a>
            <?php }?>
          
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    Click here to Download Settlement Sevices Case(s) List
        <ol type="I">
          
          <li><a href="<?php echo base_url()?>index.php/basundhara3/getCaseDetailsByServiceLot/<?=NC_KHAS_LAND_ID?>">SETTLEMENT OF KHAS LAND UNDER SVAMITRA<i class="fa fa-download" aria-hidden="true"></i></a></li>
          
        </ol>
  </div>
</div>
<style type="text/css">
  .card-body
  {  
    background: #7b4397; /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #7b4397, #dc2430);
    background: linear-gradient(to right, #7b4397, #dc2430);
  }  
  #circle {
    background: #0f546a;
    border-radius: 30%;
    padding: 7px !important;
    font-weight: bold;
    font-size: 2em;
  }
</style>

