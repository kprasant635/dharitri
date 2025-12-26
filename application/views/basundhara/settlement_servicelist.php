  <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->
    <div class="container-fluid">
	<div class="col-lg-12">
		<div class="row"> <!--Second Row Start-->
			<?php foreach($output as $row): ?>
 		 	<div class="col-lg-4">
    			<div class="card bg-info text-white">
            		<div class="card-body text-white">
            			<h4><?=$row->service;?></h4>
            			Application Received: <kbd id='circle'><?=$row->count?></kbd>
                        <a href="<?php echo base_url() ?>index.php/basundhara2/request/<?=$row->service_code?>"><i class="fa fa-hand-o-right fa-3x pull-right" title="Please Click Here to Check Details" ></i></a>
            		</div>
            	</div>
            </div>
            <?php endforeach; ?>
        </div>
        Click here to Download Settlement Sevices Case(s) List
        <ol type="I">
          <li><a href="<?php echo base_url()?>index.php/basundhara2/getCaseDetailsByServiceLot/<?=SETTLEMENT_TENANT_ID?>"><?=SETTLEMENT_TENANT_ASS?><i class="fa fa-download" aria-hidden="true"></i></a></li>
          <li><a href="<?php echo base_url()?>index.php/basundhara2/getCaseDetailsByServiceLot/<?=SETTLEMENT_AP_TRANSFER_ID?>"><?=SETTLEMENT_AP_TRANSFER_ASS?><i class="fa fa-download" aria-hidden="true"></i></a></li>
          <li><a href="<?php echo base_url()?>index.php/basundhara2/getCaseDetailsByServiceLot/<?=SETTLEMENT_TRIBAL_COMMUNITY_ID?>"><?=SETTLEMENT_TRIBAL_ASS?><i class="fa fa-download" aria-hidden="true"></i></a></li>
          <li><a href="<?php echo base_url()?>index.php/basundhara2/getCaseDetailsByServiceLot/<?=SETTLEMENT_KHAS_LAND_ID?>"><?=SETTLEMENT_KHAS_ASS?><i class="fa fa-download" aria-hidden="true"></i></a></li>
          <li><a href="<?php echo base_url()?>index.php/basundhara2/getCaseDetailsByServiceLot/<?=SETTLEMENT_PGR_VGR_LAND_ID?>"><?=SETTLEMENT_PGR_ASS?><i class="fa fa-download" aria-hidden="true"></i></a></li>
          <li><a href="<?php echo base_url()?>index.php/basundhara2/getCaseDetailsByServiceLot/<?=SETTLEMENT_SPECIAL_CULTIVATORS_ID?>"><?=SETTLEMENT_SPECIAL_ASS?><i class="fa fa-download" aria-hidden="true"></i></a></li>
        </ol>
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

