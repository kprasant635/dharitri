<!DOCTYPE html>
<html>
<head>
    <title>Village List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h4 class="mb-3">Villages</h4>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Village Name</th>
                <th>UUID</th>
                <th>Download PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($villages as $v): ?>
            <tr>
                <td><?= $v['village_name_asm'] ?></td>
                <td><?= $v['uuid'] ?></td>
                <td>
                    <button type="button" class="btn btn-primary" onclick="confirmDownload('<?= site_url('AgriPattadarsReport/download_excel/' . $v['uuid']) ?>')">
                        Download
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
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
