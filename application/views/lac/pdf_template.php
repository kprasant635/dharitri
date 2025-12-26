<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>LAC Approval - <?php echo $lac_name; ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            font-weight: normal;
           
            font-family: 'freesans';
            /* Force Assamese support */
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .footer {
            text-align: right;
            font-size: 9pt;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body style="">
    <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px;">
        <h1 style="margin: 0; font-size: 18pt;">LAC Approval Details</h1>
    </div>
    
    <div style="margin-bottom: 20px;">
        <p style="margin: 5px 0;"><strong>LAC ID:</strong> <?php echo $lac_id; ?></p>
        <p style="margin: 5px 0;"><strong>LAC Name:</strong> <?php echo $lac_name; ?></p>
    </div>
    
    <h3>Assigned Villages</h3>
    <table style="">
        <thead>
            <tr>
                <th style="">#</th>
                <th style="">District</th>
                <th style="">Subdivision</th>
                <th style="">Circle</th>
                <th style="">Mouza</th>
                <th style="">Village</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($villages as $village): ?>
            <tr style="">
                <td style=""><?php echo $i++; ?></td>
                <td style=""><?php echo $village['district_name'] ?? 'N/A'; ?></td>
                <td style=""><?php echo $village['subdivision_name'] ?? 'N/A'; ?></td>
                <td style=""><?php echo $village['circle_name'] ?? 'N/A'; ?></td>
                <td style=""><?php echo $village['mouza_name'] ?? 'N/A'; ?></td>
                <td style=""><?php echo $village['village_name'] ?? 'N/A'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Generated on: <?php echo $generated_date; ?></p>
        <p>Total Villages: <?php echo count($villages); ?></p>
    </div>
</body>
</html>