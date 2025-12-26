<center><mark>Application Received in RTPS </mark></center>
<?php if ($this->session->flashdata('message')): ?>
	<?php 
		echo '<p style="color:red;">'.$this->session->flashdata('message').'</p>';
	?>
<?php endif; ?>
<table class="table" id='dataTable'>
	<thead>
	<tr>
		<th>Application No</th>
		<th>Application Date</th>
		<th>Request Type</th>
		<th>Urban/Rural</th>
		<th>Village Name</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php foreach($pending as $pen): ?>
	<tr>
		<td><?=$pen->application_no?></td>
		<td><?=$pen->date_submission?></td>
		<td><?=$pen->service?> 
		<?php
			if(MULTIGENERATION_ACTIVE == 1){ ?>
				<?=($pen->is_multigeneration == "M") ? "<span class='badge badge-danger'>Multi-Generation</span>" : null ?>
		<?php } ?></td>
		<td><?=$pen->rurban?></td>
		<td><?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?></td>
		<td>

			<?php 
			if(MULTIGENERATION_ACTIVE == 1){ ?>
				<?php if($pen->service_code=='1' && ($pen->is_multigeneration == 'M' || $pen->is_multigeneration == 'S')){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/inheritanceBasuMultiSingleGen?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Forward</a>
				<?php }else if($pen->service_code=='1') { ?>
				<a href='<?php echo base_url() ?>index.php/rtps/inheritanceBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Forward</a>
				<?php } ?>

			<?php }else{ ?>

			
				<?php if($pen->service_code=='1'){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/inheritanceBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Forward</a>
					</td>
				<?php } ?>
			<?php } 
			?>

			<?php
				// Added by Abhijit Start -- 2024-04-09
				// if(MULTI_DAG_MUTATION_DEED_ACTIVE == 1):
				// 	if($pen->service_code == '27'):
			?>
						<!-- <a href='<?php echo base_url() ?>index.php/rtps/deedBasuMultiDag?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td> -->
			<?php
					// elseif($pen->service_code == '2'):
			?>
						<!-- <a href='<?php echo base_url() ?>index.php/rtps/deedBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td> -->
			<?php
				// 	endif;
				// else:
					// if($pen->service_code == '2'):
			?>
						<!-- <a href='<?php echo base_url() ?>index.php/rtps/deedBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td> -->
			<?php
				// 	endif;	
				// endif;	
				// Added by Abhijit End -- 2024-04-09
			?>
			
			<?php 
			if($pen->service_code=='2'){ 
				// Added by Abhijit -- 2024-05-13
				if(isset($pen->is_multidag) && $pen->is_multidag == 'Y'):
			?>
					<a href='<?php echo base_url() ?>index.php/rtps/deedBasuMultiDag?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php 
				else:
			?>
					<a href='<?php echo base_url() ?>index.php/rtps/deedBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php 
				endif;
			?>
			<?php 
			}elseif($pen->service_code=='5'){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/allotmentBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }else if($pen->service_code=='3'){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/partitionBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }else if($pen->service_code=='9'){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/conversionBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }else if($pen->service_code=='4'){  ?>
				<a href='<?php echo base_url() ?>index.php/rtps/reclassBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			
			<?php }else if($pen->service_code=='7'){  ?>
				<a href='<?php echo base_url() ?>index.php/rtps/areaCorrectionbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }
			else if($pen->service_code=='6'){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/nameCorrectionbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }
			else if($pen->service_code=='8'){ ?>
			<a href='<?php echo base_url() ?>index.php/rtps/nameCancelbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			
			<?php }else if($pen->service_code=='10'){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/mobileUpdationBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }
			else if($pen->service_code=='11'){ ?>
				<a href='<?php echo base_url() ?>index.php/rtps/rorJamabandi?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }
			else if($pen->service_code=='12'){ ?>
				<a href='<?php echo base_url() ?>index.php/Tracemap/tracemapRTPS?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }
			else if($pen->service_code=='20'){ ?>

			<a href='<?php echo base_url() ?>index.php/rtps/legacyNMA?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php } ?>

	</tr>
<?php endforeach; ?>
</tbody>
</table>
<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
} );
</script>