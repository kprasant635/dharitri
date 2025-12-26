<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1  panel panel-default panel-body ">
				<table id="data" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Case Number</th>
						<th>Mouza</th>
						<th>Lot</th>
						<th>Village</th>
						<th>Passed Year</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($field as $p):?>
					<tr>
						<td><?=$p->case_no?></td>
						<td><?=$this->utilityclass->getMouzaName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code);?></td>
						<td><?=$this->utilityclass->getLotLocationName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code,$p->lot_no)?></td>
						<td><?=$this->utilityclass->getVillageName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code,$p->lot_no,$p->vill_townprt_code)?></td>
						<td><?=$p->year_no?></td>
						<td><a href='<?php echo base_url() ?>index.php/backlogpartition/viewcase?type=1&case=<?=$p->case_no;?>&p=<?=$p->petition_no;?>' class='btn btn-primary'>Check Order</td>
					</tr>
					<?php endforeach; ?>
					<?php foreach($office as $p):?>
					<tr>
						<td><?=$p->case_no?></td>
						<td><?=$this->utilityclass->getMouzaName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code);?></td>
						<td><?=$this->utilityclass->getLotLocationName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code,$p->lot_no)?></td>
						<td><?=$this->utilityclass->getVillageName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code,$p->lot_no,$p->vill_townprt_code)?></td>
						<td><?=$p->year_no?></td>
						<td><a href='<?php echo base_url() ?>index.php/backlogpartition/viewcase?type=2&case=<?=$p->case_no;?>&p=<?=$p->petition_no;?>' class='btn btn-primary'>Check Order</td>
					</tr>
					<?php endforeach; ?>
				</tbody>	
			</table>
				
			</div>	
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#data').DataTable();
} );
</script>