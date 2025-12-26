<center><mark>Application Received in Basundhara </mark></center>
<table class="table" id='dataTable'>
	<thead>
	<tr>
		<th>Application No</th>
		<th>Application Date</th>
		<th>Request Type</th>
		<th>Urban/Rural+Village Name</th>
		<th>Mouza/Lat</th>
		<th>Pending With/Status</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php foreach($pending as $pen): ?>
	<tr>
		<td><?=$pen->application_no?></td>
		<td><?=$pen->date_submission?></td>
		<td><?=$pen->service?></td>
		<td><?=$pen->rurban?>/<?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?></td>
		<!-- <td><?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?></td> -->
		<td><?=$this->utilityclass->getMouzaName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code)?>/<?=$this->utilityclass->getLotName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no)?></td>
		<td><?=($pen->pending_with_officer=='NA') or <?=($pen->pending_with_officer=='F')  ?  'Disposed': $pen->pending_with_officer ;?>
			<?php if($pen->status=='Q'){
				echo "<br><kbd>Query Sent</kbd>";
			} ?>

		</td>
		<td>
			<?php if($pen->service_code=='1'){ ?>
			<a href='<?php echo base_url() ?>index.php/basundhara/inheritanceBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> View</a>
			</td>
			<?php }else if($pen->service_code=='2'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/deedBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='5'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/allotmentBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='3'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/partitionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='9'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/conversionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='4'){  ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/reclassBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			
			<?php }else if($pen->service_code=='7'){  ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/areaCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }
			else if($pen->service_code=='6'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/nameCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }
			else if($pen->service_code=='8'){ ?>
			<a href='<?php echo base_url() ?>index.php/basundhara/nameCancelbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			
			<?php }else if(($pen->service_code=='10') and ($pen->pending_with_officer=='CO')){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/mobileUpdationBasu?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }?>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
} );
</script>