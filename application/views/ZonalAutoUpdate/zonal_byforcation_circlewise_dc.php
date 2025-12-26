
<style>
	.dt-button {
		background-color: #00e676 !important;
		padding: 5px 20px !important;
		border-radius: 5px;
	}
</style>

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
 
<div class="p-2 bg-success text-center text-white h5 shadow-sm border border-white rounded"><span style="text-transform:uppercase">Zonal Dag Info Circle Wise</span>
</div>

<div class="panel panel-info panel-form">
	<div class="tab-content">
		<div class="card-body">

        <!--Normal Table -->
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableNormal' width="100%">
				<thead>
					<th scope="col"><label class="control-label" style="text-transform:uppercase">Circle Name</label></th>				
					<th scope="col" class="center"><label class="control-label"  style="text-transform:uppercase">Total Dags(s) </label></th>
					<th scope="col" class="center"><label class="control-label"  style="text-transform:uppercase">Completed Dags(s) </label></th>
					<th scope="col" class="center"><label class="control-label"  style="text-transform:uppercase">Pending Dags(s)</label></th>
					<th scope="col" class="center"  style="text-transform:uppercase">Approved Dags</label>
					</th>
				</thead>
				<tbody>
				<?php $i =1; foreach($data_rows as $rows) : ?>
					<tr>
						<td class="text-center"><strong><?= $this->utilityclass->getCircleName($rows['dist_code'], $rows['subdiv_code'], $rows['cir_code']) ?></strong></td>
						<td class="text-right"><?= $rows["chitha_dags"] ?></td>
						<td class="text-right"><?= $rows["zonal_dags"] ?></td>
						<td class="text-right"><?= $rows["pending_dags"] ?></td>
						<td class="text-right"><?= $rows["approve_dags"] ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
                <tfoot>
                    <tr class="text-bold">
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
			</table>
        <!-- Normal Table End -->
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>application/views/js/zonal_details/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/zonal_details/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/zonal_details/buttons.html5.min.js"></script>



<script>
$(document).ready(function() {

  var table = $('#datatableNormal').DataTable( {
		pageLength: 50,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', footer: true,title: 'Zonal value Entry Status Circle Wise',
            text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i> Export to Excel',
            titleAttr: 'Export Excel' },

        ],
    initComplete: function(settings, json) {
      // calculate the sum when table is first created:
      doSum();
    }
  } );

  $('#datatableNormal').on( 'draw.dt', function () {
    // re-calculate the sum whenever the table is re-displayed:
    doSum();
  } );

  // This provides the sum of all records:
  function doSum() {
    // get the DataTables API object:
    var table = $('#datatableNormal').DataTable();
    // set up the initial (unsummed) data array for the footer row:
    var totals = ['Totals',0,0,0,0];
    // iterate all rows - use table.rows( {search: 'applied'} ).data()
    // if you want to sum only filtered (visible) rows:
    totals = table.rows( ).data()
      // sum the amounts:
      .reduce( function ( sum, record ) {
        for (let i = 1; i <= 4; i++) {
            console.log(sum);
            console.log(record);
          sum[i] = sum[i] + numberFromString(record[i]);
        } 
        return sum;
      }, totals ); 
    // place the sum in the relevant footer cell:
    for (let i = 1; i <= 4; i++) {
      var column = table.column( i );
      $( column.footer() ).html( formatNumber(totals[i]) );
    }
  }

  function numberFromString(s) {
    return typeof s === 'string' ?
      s.replace(/[\$,]/g, '') * 1 :
      typeof s === 'number' ?
      s : 0;
  }

  function formatNumber(n) {
     return n.toLocaleString(); // or whatever you prefer here
  }

} );
        
</script>


