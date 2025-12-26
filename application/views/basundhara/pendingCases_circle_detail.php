<?php
	if($service == '1') {$service_name = 'MUTATION BY INHERITANCE';}
	else if($service == '2') {$service_name = 'MUTATION BY DEED';}
	else if($service == '3') {$service_name = 'CONCENSUS PARTITION';}
	else if($service == '4') {$service_name = 'RECLASSIFICATION';}
	else if($service == '5') {$service_name = 'ALLOTMENT';}
	else if($service == '6') {$service_name = 'NAME CORRECTION';}
	else if($service == '7') {$service_name = 'AREA CORRECTION';}
	else if($service == '8') {$service_name = 'STRICKING OUT NAME';}
	else if($service == '9') {$service_name = 'CONVERSION';}
	else if($service == '10') {$service_name = 'MOBILE NUMBER UPDATE';}
?>


<center><mark>Application Pending in Basundhara for Service: <?=$service_name?></mark></center>
<table class="table" id='dataTable'>
	<thead>
		<tr>
			<th>Application No</th>
			<th>Application Date</th>
			<th>Pending With/Status</th>
			<th>Mouza/Lat</th>
			<th>Pending With/Status</th>
		</tr>
	</thead>
	<tbody>

		
	<?php 
		foreach($pending->data as $pen):
	?>
		<tr>
			<td><?=$pen->application_no?></td>
			<td><?=$pen->date_submission?></td>
			<td>
				<?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?>
			</td>
			<td>
				<?=$this->utilityclass->getMouzaName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code)?>/<?=$this->utilityclass->getLotName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no)?>
			</td>
			<td><?=$pen->pending_with_officer?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
} );
</script>