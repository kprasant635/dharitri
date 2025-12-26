<style>
    .rccms-container {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        border-radius: 12px;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        color: white;
        text-align: center;
        background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);
    }

    .rccms-title {
        font-size: 24px;
        font-weight: bold;
        padding-bottom: 10px;
        border-bottom: 2px solid white;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .rccms-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .rccms-table th, .rccms-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }

    .rccms-table th {
        background: rgba(0, 0, 0, 0.3);
        text-transform: uppercase;
    }

    .rccms-table tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.2);
    }

    .rccms-table tr:hover {
        background: rgba(0, 0, 0, 0.4);
        transition: 0.3s;
    }
</style>
<div class="rccms-container">
    <h3 class="rccms-title">RCCMS Case Has been Registered</h3>
    <table border="1" cellpadding="5" cellspacing="0" class="rccms-table">
        <tr>
            <th>Case No</th>
            <th>Dag No</th>
            <th>Registered Date</th>
            <th>Type</th>
        </tr>
        <?php foreach ($records as $row): ?>
            <tr>
                <td><?= $row['rccms_case_no']; ?></td>
                <td><?= $row['dag_no']; ?></td>
                <td><?= date('Y-m-d',strtotime($row['date_entry'])); ?></td>
                <td><?= $row['case_type']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>