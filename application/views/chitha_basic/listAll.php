<div class="container-fluid form-top login">
    <div class="row">
		<div class="col-lg-4 ">
			<a href="<?php echo base_url() . 'index.php/chitha_basic_deo/coIndex'?>" class="btn btn-primary">Click here to view Already Approved Digitized Records</a>
		</div>
        <div class="col-lg-12 ">
		<div class="panel panel-info">
				
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
						<th class='hide'>Check all <br> <center><input type="checkbox" id="ckbCheckAll" /></center></th>
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
							<td><a class='btn btn-xs btn-danger acb' href='<?php echo base_url() . 'index.php/chitha_basic_deo/coview?d='. $b->dist_code .'&s='.$b->subdiv_code .'&c='.$b->cir_code .'&m='.$b->mouza_pargona_code .'&l='.$b->lot_no .'&v='.$b->vill_townprt_code .'&dg='.$b->dag_no .'&p='.$b->patta_no .'&pc='.$b->patta_type_code.'&cn=1'   ?>'>Details</a></td>
							<td class='hide'><center><input type="checkbox" class="checkBoxClass" ></center></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>
		</div>
	</div>
</div>
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<style type="text/css">
    .modal{
        overflow-y:auto;
        overflow-x: hidden;
    }
    .bodytest{
        position: relative;
        padding: 0px !important;
    }
</style>
<script>
$(document).off('click', '.acb').on('click', '.acb', function(e) {
    e.preventDefault();
    var modal = $('.bs-example-modal-lg');
    
    modal.find('.modal-content').html('<img src="' + baseUrl + 'application/views/images/load.gif">');

    $.ajax({
        url: $(this).attr('href'),
        success: function (data) {
            modal.find('.modal-content').html(data);
            modal.modal('show');
        }
    });
});
</script>
