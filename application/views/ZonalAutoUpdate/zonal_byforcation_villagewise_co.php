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

<div class="p-2 bg-success text-center text-white h5 shadow-sm border border-white rounded"><b>Zonal Village Info Village Wise</b>
</div>

<div class="panel panel-info panel-form">
    <div class="tab-content">
        <div class="card-body">
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatablePending' width="80%">
                <thead>
                    <th scope="col" style="width: 25%"><label class="control-label">Circle</label></th>
                    <th scope="col" class="center" style="width: 25%"><label class="control-label">Village </label></th>
                    <th scope="col" class="center" style="width: 25%"><label class="control-label">Updated Status(s) (<i class='fa fa-check' style='color:green'></i>/<i class='fa fa-close red' style='color:red'></i>)</label></th>
                    <th scope="col" class="center" style="width: 25px;">Approved Status (<i class='fa fa-check' style='color:green'></i>/<i class='fa fa-close red' style='color:red'></i>)</label>
                    </th>

                </thead>
                <tbody>

                </tbody>
            </table>


        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        // $('#village_zonal').change(function(event) {
        // 	// console.log(event);
        // 	var village_uuid = $('#village_zonal').val();

        // 	$('#datatablePending').DataTable().destroy();
        // 	load_data(village_uuid);
        // });

        load_data_pending();

        function load_data_pending(village_uuid) {
            // $('#datatablePending thead th:nth-of-type(2)').each(function() {
            // 	var title = $(this).text();
            // 	$(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            // });

            var base_url = "<?php echo base_url(); ?>";
            var dist_code = "<?= $dist_code ?>";
            var subdiv_code = "<?= $subdiv_code ?>";
            var cir_code = "<?= $cir_code ?>";
            var table = $('#datatablePending').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url + 'index.php/ZonalByforcationController/viewVillageZonalDetailsVillWise',
                    type: 'POST',
                    data: {
                        dist_code: dist_code,
                        subdiv_code: subdiv_code,
                        cir_code: cir_code,
                        village_code: village_uuid,
                        // rural:rurban
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0, 1, 2, 3],
                }]
            });
            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
            // button search
            $('.search_button').on('click', function() {
                $('table thead tr th .input_search').each(function() {
                    $(this).val('');
                    // table.column($(this).data('columnIndex')).search('');
                });
                $('#datatablePending').DataTable().destroy();
                load_data_pending();
            });
        }
    });
</script>