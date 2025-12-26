<style>
	.dt-button {
		background-color: #00e676 !important;
		padding: 5px 20px !important;
		border-radius: 5px;
	}
</style>
<link href="<?= base_url(); ?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">

<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
	document.onreadystatechange = function(e) {
		$.blockUI({
			message: $('#displayBox'),
			css: {
				border: 'none',
				backgroundColor: 'transparent'
			}
		});
	};
	window.onload = function() {
		$.unblockUI();
	}
</script>

<div class="p-2 bg-danger text-center text-white h5 shadow-sm border border-white rounded"><b>Dags with Missing Zonal Value</b>
</div>

<div class="panel panel-danger panel-form">
	<div class="tab-content">
		<div class="card-body">
			<table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableZonal' width="100%">
				<thead>
					<!-- <th scope="col"><label class="control-label">Sl No.</label></th> -->
					<th scope="col" class="center"><label class="control-label">Dag No </label></th>
					<th scope="col"><label class="control-label">Circle</label></th>
					<th scope="col"><label class="control-label">Mouza</label></th>
					<th scope="col"><label class="control-label">Lot No</label></th>
					<th scope="col" class="center"><label class="control-label">Village </label></th>
					<th scope="col" class="center"><label class="control-label">Zone Name  </label></th>
					<th scope="col" class="center"><label class="control-label">Subclass Name  </label></th>
					</th>
				</thead>
				<tbody>
                    <?php $i = 1;
                        foreach ($getMissingDags as $dags) :
                        ?>
                            <tr>
                                <!-- <td class="center"><?php  echo $i ?></td> -->
                                <td class="center"><strong class="text-danger"><?php  echo $dags->dag_no ?></strong></td>
                                <td class="center"> <?php echo $dags->circle ?></td>
                                <td class="center"> <?php echo $dags->mouza ?></td>
                                <td class="center"> <?php echo $dags->lot ?></td>
                                <td class="center"><?php  echo $dags->village ?></td>
                                <td class="center"><strong class="text-success"><?php  echo $dags->zone_name ?></strong></td>
                                <td class="center"><strong class="text-primary"><?php  echo $dags->subclass_name ?></strong></td>
                        </tr>
                        <?php $i++;
                        endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>application/views/js/zonal_details/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/zonal_details/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/zonal_details/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
  var table = $('#datatableZonal').DataTable( {
		pageLength: 50,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', footer: true,title: 'Zonal Value Missing Report',
            text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i> Export to Excel',
            titleAttr: 'Export Excel' },

        ],
  } );
} );      
</script>