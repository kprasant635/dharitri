<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">List Of Agriculture Pattadars</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="form-group">
                        <!-- <a class="btn btn-primary" 
                            href="<?= base_url('index.php/AgricultureCountController/downloadExcelNew' . $parm) ?>">
                            <i class="fa fa-download"></i> Download Excel
                        </a> -->

                        <button type="button" class="btn btn-primary" onclick="confirmDownload('<?= site_url('AgriPattadarsReport/download_excel/' . $uuid) ?>')">
                            Download
                        </button>

                    </div>
                    <table class="table table-striped tab1">
                        <thead>
                            <tr>
                                <th>SL. No.</th>
                                <th>Dag No.</th>
                                <th>Patta No.</th>
                                <th>Patta Type</th>
                                <th>Pdar. Name</th>
                                <th>Father Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($records as $key=>$rec): ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $rec->dag_no ?></td>
                                    <td><?= $rec->patta_no ?></td>
                                    <td><?= $rec->patta_type ?></td>
                                    <td><?= $rec->pdar_name ?></td>
                                    <td><?= $rec->father_name ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.tab1').DataTable({
            pageLength: 100
        });
    });
</script>

<script>
function confirmDownload(downloadUrl) {
    Swal.fire({
        title: 'Sensitive Information Warning',
        icon: 'warning',
        html: `
            <p style="text-align:left;">
                This contains <strong>sensitive land ownership information</strong>. It is intended for <strong>official use only</strong>.<br><br>
                <strong>Do not share</strong> this document publicly or with unauthorized persons.<br><br>
                <span style="color:red;">Unauthorized distribution may lead to disciplinary or legal action.</span>
            </p>
        `,
        showCancelButton: true,
        confirmButtonText: 'Yes, I Understand',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with download
            window.location.href = downloadUrl;
        }
    });
}
</script>



