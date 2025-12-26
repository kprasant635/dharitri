<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Second Proceeding
        </h4>
    </div>
    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>

<div class="row px-5">
    <table id="datatable" class="datatable table table-stripped">
        <thead>
        <tr>
            <th>Case No</th>
            <th>Application No</th>
            <th>Location
                <select class="form-control" name="category" id="category">
                    <option value="">select</option>
                    <?php if(isset($select_data)){ foreach($select_data as $select){?>
                        <option value="<?=$select->vill_townprt_code?>"><?=$this->utilityclass->getVillageName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code, $select->lot_no, $select->vill_townprt_code)?></option>
                    <?php }}?>
                </select>
            </th>
            <th>Submission Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

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
        $(document).on('change', '#category', function(){
            var category = $(this).val();
            $('#datatable').DataTable().destroy();
            if(category != '')
            {
                load_data(category);
            }
            else
            {
                load_data();
            }
        });

        load_data();

        function load_data(is_category)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });
            $('#datatable thead th:nth-of-type(4)').each(function () {
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
                    url: base_url+'index.php/SettlementCommon/paginationForApSecondPreceding',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 3, 4],
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
