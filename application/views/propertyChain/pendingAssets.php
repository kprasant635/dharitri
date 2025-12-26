<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/dataTableButtonHtml.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>


<link href="<?php echo base_url(); ?>application/views/css/dataTableButton.css" rel="stylesheet" />
<?php $user_desig = $this->session->userdata('user_desig_code');  ?>
<div class="container-fluid form-top login" id="show-prop-report">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php if ($user_desig == 'CO') { ?>
                            Properties pending asset creation in property chain
                        <?php } elseif ($user_desig == 'LM') { ?>
                            Properties pending map generation at Bhunaksha
                        <?php } ?>

                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <table class="table table-bordered" id="pending_assets_table">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Case No.</th>
                                    <th>Location</th>
                                    <th>Dag</th>
                                    <?php if ($user_desig == 'LM') { ?>
                                        <th>Area to partition (B-K-L)</th>
                                    <?php } ?>
                                    <th>Old Dag</th>
                                    <th>Map Status</th>
                                    <th>Old Ulpin</th>
                                    <?php //if ($user_desig == 'LM') { ?>
                                    <th>Action</th>
                                    <?php //} ?>

                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="loader" style="display:none;"></div>
        <input type="hidden" name='user_desig' id='user_desig' value="<?= $user_desig ?>">
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var user_desig = $('#user_desig').val();
        if (user_desig == 'CO') {
            var table = $('#pending_assets_table').DataTable({
                "ordering": false,
                "processing": true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                },
                dom: 'Bfrtip',
                "pageLength": 10,
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Dags pending asset creation in property chain',
                    text: '<i class="fa fa-file-excel-o bg-success text-dark"></i> Excel',
                    titleAttr: 'Export to Excel',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                }],
                "columns": [{
                        "render": function(data, type, row, meta) {

                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "case_no"
                    },
                    {
                        "data": "location"
                    },
                    {
                        "data": "dag",
                    },
                    {
                        "data": "old_dag",
                    },
                    {
                        "data": "map_status",
                    },
                    {
                        "data": "old_ulpin"
                    },
                    {
                        "data": "btns"
                    }
                ],
                "ajax": {
                    url: "<?php echo site_url("PropChainReport/getPendingAssets") ?>",
                    type: 'POST',
                    data: function(d) {},
                    beforeSend: function() {},
                    complete: function() {}
                },
            })
        } else if (user_desig == 'LM') {
            var table = $('#pending_assets_table').DataTable({
                "ordering": false,
                "processing": true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                },
                dom: 'Bfrtip',
                "pageLength": 10,
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Dags pending map creation',
                    text: '<i class="fa fa-file-excel-o bg-success text-dark"></i> Excel',
                    titleAttr: 'Export to Excel',
                }],
                "columns": [{
                        "render": function(data, type, row, meta) {

                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "case_no"
                    },
                    {
                        "data": "location"
                    },
                    {
                        "data": "dag",
                    },
                    {
                        "data": "partition_area",
                    },
                    {
                        "data": "old_dag",
                    },
                    {
                        "data": "map_status",
                    },
                    {
                        "data": "old_ulpin"
                    },
                    {
                        "data": "split_btn"
                    }
                ],
                "ajax": {
                    url: "<?php echo site_url("PropChainReport/getPendingAssets") ?>",
                    type: 'POST',
                    data: function(d) {},
                    beforeSend: function() {},
                    complete: function() {}
                },
            })
        }
    })
</script>
<style>
    .spinner-grow {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        margin-top: -50px !important;
        margin-left: -50px !important;
    }

    #loader {
        position: fixed;
        z-index: 10;
        background: black;
        left: 0;
        top: 0;
        /* display: block; */
        opacity: .75;
        /* filter: alpha(opacity=75); */
        width: 100%;
        height: 100%;
    }
</style>