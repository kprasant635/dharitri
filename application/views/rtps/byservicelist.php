  <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->
    <div class="container-fluid">
	<div class="col-lg-12">
		<?php if (isset($message)): ?>
			<div class="alert alert-warning" role="alert" style="text-align: center;" >
				<?= $message; ?>
			</div>
		<?php endif; ?>
		<?php if(count($output)): ?>
			<div class="row"> <!--Second Row Start-->
				<?php foreach($output as $row): 
					if($row->service_code !='6'): ?>
					<div class="col-lg-4">
						<div class="card bg-info text-white">
							<div class="card-body text-white">
								<h4><?=$row->service;?></h4>
								Application Received: <kbd id='circle'><?=$row->count?></kbd>
								<a href="<?php echo base_url() ?>index.php/rtps/request/<?=$row->service_code?>"><i class="fa fa-eye fa-3x pull-right" title="Please Click Here to Check Details" ></i></a>
							</div>
						</div>
				</div>
				<?php endif; endforeach; ?>
			</div>
		<?php else: ?>
			<div class="text-center mt-4">No data found</div>
		<?php endif; ?>
    </div>
</div>
<style type="text/css">
  .card-body{background: rgb(13,11,116);
background: linear-gradient(137deg, rgba(13,11,116,1) 8%, rgba(66,81,142,1) 30%, rgba(80,113,195,1) 56%, rgba(46,113,178,1) 79%, rgba(37,7,83,1) 97%);}
  #circle {
    background: #0f546a;
    border-radius: 30%;
    padding: 7px !important;
    font-weight: bold;
    font-size: 2em;
    }
</style>