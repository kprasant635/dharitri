<center><mark>Application Received in E-Khajana </mark></center>
<table class="datatable table table-stripped" id='datatable'>
	<thead>
		<tr>
			<th>Application No</th>
			<th>Application No (Sub cases)</th>
			<th>Payment status</th>
            <th>Dharitree Case Status
            <select class="form-control input_search" name="ekhajana-status" id="ekhajana-status" data-column-index="4">
                                <option value="">--SELECT--</option> 
                                <?php if (isset($getStatus)) {
                                    foreach ($getStatus as $status1) { ?>
                                        <?php if($status1->status =='COM_F'){
                                            $status3 ="Pending-with-CO(Mouzadari)";
                                        }elseif($status1->status =='R'){
                                            $status3 ="Rejected-by-CO";
                                        }elseif($status1->status =='MOU_F'){
                                            $status3 ="Pending-with-LM(Mouzadari)";
                                        }elseif($status1->status =='CO-F'){
                                            $status3 ="Pending-with-AST";
                                        }elseif($status1->status =='P'){
                                            $status3 ="Pending";
                                        }elseif($status1->status =='M_OBJ'){
                                            $status3 ="Objection-by-Mouzadar";
                                        }elseif($status1->status =='L'){
                                            $status3 ="Reverted to CO";
                                        }elseif($status1->status =='F'){
                                            $status3 ="Disposed";
                                        }elseif($status1->status =='MLM_F'){
                                            $status3 ="Pending-with-Mouzadar";
                                        }elseif($status1->status =='LM-F'){
                                            $status3 ="Pending-with-CO";
                                        }else{
                                            $status3="PENDING";
                                        }?>
                                            <option value="<?=$status1->status?>"><?=$status3?></option>
                                <?php }
                                } ?>
            </select>
            </th>
            <th>ACTION</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<style>
    /* .dataTables_filter, .dataTables_info { display: none; } */
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
 </style>

<script>
    $(document).ready(function ()
    {
        $('#ekhajana-status').change(function(event) {
            //console.log(event);
            var ekhajana_status = $('#ekhajana-status').val();
            // alert(ekhajana_status);
            $('#datatable').DataTable().destroy();
            load_data(ekhajana_status);
        });
       
        load_data();
        function load_data(ekhajana_status)
        {
            var base_url = "<?php echo base_url();?>";
            var dist_code = "<?=$dist_code?>";
            var subdiv_code = "<?=$subdiv_code?>";
            var cir_code = "<?=$cir_code?>";
            var mouza_code = "<?=$mouza_code?>";
            var lot_no = "<?=$lot_no?>";
           
           
            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            // $('#datatable thead th:nth-of-type(2)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });
            
            var table = $('#datatable').DataTable({
                // "scrollX": true,
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/EkhajanaReportController/viewCasesAPI',
                    type:'POST',
                    data: {
                        dist_code: dist_code,
                        subdiv_code: subdiv_code,
                        cir_code: cir_code,
                        mouza_code: mouza_code,
                        lot_no: lot_no,
                        ekhajana_status: ekhajana_status,
                    },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                        "className": "dt-center", "targets":[ 0, 1, 2, 3],
                    }]
            });

            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                        if (table.search() !== this.value) {
                                table.search(this.value).draw();
                        }
                    });
                }
            );
        }
        
    });

</script>
 