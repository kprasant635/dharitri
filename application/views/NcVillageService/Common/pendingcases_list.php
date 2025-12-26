<center><mark>Application Received in Basundhara </mark></center>
<table class="datatable table table-stripped" id='datatable'>
	<thead>
		<tr>
			<th>Application No</th>
			<th>Application Date</th>
			<th>Urban/Rural

                <select class="form-control" name="rural" id="rural">
                    <option value="">select</option>
                    <?php if(isset($selectList->urban_check)){ foreach($selectList->urban_check as $rural){
                        ?>
                        <option value="<?=$rural->is_urban?>"><?php if($rural->is_urban == 'Y'){echo 'Urban';}else{echo "Rural";}?></option>
                    <?php }}?>
                </select>
            </th>

			<th>Village Name 
                <select class="form-control" name="category" id="category">
                    <option value="">select</option>

                    <?php if(isset($selectList)){ foreach($selectList->vill_list as $vill){
                        ?>
                        <option value="<?=$vill->uuid?>"><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_code, $vill->lot_no, $vill->village_code)?></option>
                    <?php }}?>
                </select>
            </th>
            <th>Pending at
                <select class="form-control" name="pending_at" id="pending_at">
                    <option value="">select</option>
                    <?php if(isset($selectList->pending_with_officer)){ foreach($selectList->pending_with_officer as $pending){
                        ?>
                        <option value="<?=$pending->pending_with_officer?>"><?=$pending->pending_with_officer?></option>
                    <?php }}?>
                </select>
            </th>
            <th>Action</th>
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
        $('#rural, #category, #pending_at').change(function(){
            var rural = $('#rural').val();
            var category = $('#category').val();
            var pending_at = $('#pending_at').val();
            $('#datatable').DataTable().destroy();

            load_data(category,rural,pending_at);
    
        });

        load_data();

        function load_data(category,rural,pending_at)
        {

            var base_url = "<?php echo base_url();?>";

            var dist_code = "<?=$dist_code?>";
            var subdiv_code = "<?=$subdiv_code?>";
            var cir_code = "<?=$cir_code?>";
            var service_code = "<?=$service_code?>";


            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });
            
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
                    url: base_url+'index.php/SettlementCommon/viewPendingCasesAPI',
                    type:'POST',
                    data: {
                        dist_code: dist_code,
                        subdiv_code: subdiv_code,
                        cir_code: cir_code,
                        service_code: service_code,
                        is_category:category,
                        rural:rural,
                        pending_at:pending_at,
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
        }
        
    });

</script>
 