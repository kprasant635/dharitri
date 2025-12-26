<center><mark>VGR/PGR Reverted Cases </mark></center>
<table class="table" id='dataTable'>
	<thead>
	<tr>
		<th>#</th>
		<th>Case No</th>
		<th>Lot Name</th>
		<th>Village Name</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php $count = 1; foreach($revertedResult as $pen): ?>
	<tr>
        <td>
            <?=$count++?>
        </td>
		<td>
            <?=$pen->case_no?>
        </td>
		<td>
            <?=$this->utilityclass->getLotName($pen->dist_code, $pen->subdiv_code, $pen->cir_code, $pen->mouza_pargona_code, $pen->lot_no)?>
        </td>
		<td>
            <?=$this->utilityclass->getVillageName($pen->dist_code, $pen->subdiv_code, $pen->cir_code, $pen->mouza_pargona_code, $pen->lot_no, $pen->vill_townprt_code)?>
        </td>
		<td>
			<a href='<?php echo base_url() ?>index.php/SettlementVgrCo/settlementVgrCo?case=<?=$pen->case_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Write Report</a>
	    </td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
    });
</script>