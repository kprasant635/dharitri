<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
        header { text-align: center; font-weight: bold; font-size: 16px; }
        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 11px;
        }
        .location-info { margin-bottom: 10px; }
    </style>
</head>
<body>

<header>
    Village Land Record Report
</header>

<div class="location-info">
    <strong>Village:</strong> <?= $village['loc_name'] ?? '' ?><br>
    <strong>Location:</strong> <?= "{$village['dist_code']}-{$village['subdiv_code']}-{$village['cir_code']}-{$village['mouza_pargona_code']}-{$village['lot_no']}-{$village['vill_townprt_code']}" ?>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Patta Type</th>
            <th>Patta No</th>
            <th>DAG No</th>
            <th>Pattadar Name</th>
            <th>Father's Name</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($records as $r):
        if ($i > 1 && $i % 500 == 0) {
            echo '</tbody></table><pagebreak /><table><thead><tr>
                    <th>#</th><th>Patta Type</th><th>Patta No</th><th>DAG No</th><th>Pattadar Name</th><th>Father\'s Name</th>
                  </tr></thead><tbody>';
        }
    ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($r['patta_type_code']) ?></td>
            <td><?= htmlspecialchars($r['patta_no']) ?></td>
            <td><?= htmlspecialchars($r['dag_no']) ?></td>
            <td><?= htmlspecialchars($r['pdar_name']) ?></td>
            <td><?= htmlspecialchars($r['pdar_father']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>

</table>

<footer>
    Printed by <?= $downloaded_by ?> (<?= $designation ?>) on <?= date('d-m-Y H:i:s') ?>
</footer>

</body>
</html>
