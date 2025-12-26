<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
		<div class="panel panel-info">
				<div class="pull-left">
					<a href="<?php echo site_url('chitha_basic_deo/'); ?>" class="btn pull-left btn-success">Click Here Add Records</a> 
				</div>
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<th>Mouza</th>
						<th>Village</th>
						<th>Dag No</th>
						<th>Patta</th>
						<th>Patta No</th>
						<th>Land Class</th>
						<th>Area<br>(B-K-L)</th>
						<th>Revenue</th>
						<th>Date</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php  foreach($basic as $b): ?>
						 <tr>
							<td><?=$this->utilityclass->getMouzaName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code);?></td>
							<td><?=$this->utilityclass->getVillageName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code,$b->lot_no,$b->vill_townprt_code);?></td>
							<td><kbd><?=$b->dag_no;?><kbd></td>
							<td><?=$this->utilityclass->getPattaName($b->patta_type_code);?></td>
							<td><?=$b->patta_no;?></td>
							<td><?=$this->utilityclass->getLandClassCode($b->land_class_code);?></td>
							<td><?=$b->dag_area_b."-".$b->dag_area_k."-".$b->dag_area_lc;?></td>
							<td><?=$b->dag_revenue;?></td>
							<td><?=date('d/m/Y',strtotime($b->date_entry))?></td>
							<td>
							<?php
								if($b->status=='F'){
									$Status="Approve";
									$btn="btn-success";
								}elseif($b->status=='R'){
									$Status="Reject";
									$btn="btn-warning";
								}else{
									$Status="Pending";
									$btn="btn-danger";
								}
							?>
							<button class='btn btn-xs <?=$btn?>'><?=$Status?></button></td>
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
    $('#example').DataTable();
} );
</script>
