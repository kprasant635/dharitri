

<table>
	<thead>
	<tr>
		<th>Application No</th>
		<th>Institute Name</th>
		<th>Village</th>
	</tr>
    </thead>
    <tbody>
        <tr>
            
        </tr>
    </tbody>
<tbody>

</tbody>
</table>
<div class="center">
<div class="pagination">
            <?php //echo $this->pagination->create_links(); ?>
</div></div>

<script>
    $(document).ready(function ()
    {
        $('#mouzaLot, #pending_at, #vill_name').change(function(){
        	  var mouza_code = null;
        		var lot_no = null;
        		var village_code = null;
        		var vill_mouza_code = null;
        		var vill_lot_no = null;
        		var pendingOff =null;
        		var pendingSts =null;
            var mouzaLot = $('#mouzaLot').val();
            if(mouzaLot){
            	var string = mouzaLot.split("-");
	            mouza_code = string[0];
	        		lot_no = string[1];
            }
        		var village = $('#vill_name').val();
        		if(village){
            	var string1 = village.split("-");
	            vill_mouza_code = string1[0];
	        		vill_lot_no = string1[1];
	        		village_code = string1[2];
            }
          //   if(vill_name){
          //   	var string1 = vill_name.split("-");
	         //    var village_code = string1[0];
	        	// 	var rurban = string1[1];
	        	// 	if(rurban == 'Rural'){
	        	// 		rurban = 'N';
	        	// 	}else{
	        	// 		rurban = 'Y';
	        	// 	}
          //   }else{
          // 		var village_code = null;
        		// 	var rurban = null;
        		// }
            var pending_at = $('#pending_at').val();
        		if(pending_at){
            	var string2 = pending_at.split("-");
	            pendingOff = string2[0];
	            pendingSts = string2[1];
	        		
            }
            $('#dataTable1').DataTable().destroy();
            load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,pendingOff,pendingSts);
        });
        load_data();
        function load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,pendingOff,pendingSts)
        {
        		$('#dataTable1 thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
            $('#dataTable1 thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
            var base_url = "<?php echo base_url();?>";
            var dist_code = "<?=$dist_code?>";
            var subdiv_code = "<?=$subdiv_code?>";
            var cir_code = "<?=$cir_code?>";
            var service_code = "<?=$service_code?>";
            var table = $('#dataTable1').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/Rtps/viewPendingCasesAPI',
                    type:'POST',
                    data: {
                        dist_code: dist_code,
                        subdiv_code: subdiv_code,
                        cir_code: cir_code,
                        service_code: service_code,
                        pending_at:pendingOff,
                        pendingSts:pendingSts,
                        mouza_code:mouza_code,
                        lot_no:lot_no,
                        vill_mouza_code:vill_mouza_code,
                        vill_lot_no:vill_lot_no,
                        village_code:village_code,
                        // rural:rurban
                    },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4],
                    }]
            });
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
            // button search
            $('.search_button').on('click', function () {
                $('table thead tr th .input_search').each(function(){
                   
                    $(this).val('');
                     // table.column($(this).data('columnIndex')).search('');

                });
                // $('#dataTable1').DataTable().search().draw();
                //table.draw();
                $('#dataTable1').DataTable().destroy();
                load_data();
            });
        }
    });
</script>
</script>