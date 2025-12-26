<style>
    .dt-button {
        background-color: #00e676 !important;
        padding: 5px 20px !important;
        border-radius: 5px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-8 offset-2 my-2 py-2 bg-white rounded">
            <div class="text-white bg-danger p-2 mt-2 mb-2 rounded text-center" style="font-size: 18px;">
                Login History (Last 30 Records)
            </div>
            <table class="table table-bordered dataTable">
                <thead>
                <tr class="alert alert-info">
                    <td>Sl No</td>
                    <td>Login IP</td>
                    <td>Date</td>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($history as $r) { ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $r['client_ip'] ?></td>
                        <td><?= $r['date_of_creation'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatable/buttons.html5.min.js"></script>

<script>
    $('.dataTable').DataTable({
        "pageLength": 30,
        dom: 'Bfrtip',
        buttons: [
            'excel',
        ]
    });
</script>