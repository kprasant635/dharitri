<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notice of Demand</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .notice {
            margin: 5px;
            padding: 5px;
            border: 1px solid #000;
            background-color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .mb-20 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="notice">
            <!-- Fix malformed paragraph tag -->

            <p class="text-center" style="font-size: medium;">Office of the Circle Officer, <?= $this->utilityclass->getCircleName($data['dist_code'], $data['subdiv_code'], $data['cir_code']) ?></p>
            <h6 class="text-center">NOTICE OF DEMAND</h6>
            <p class="text-center">(Assam Schedule XXIV (Part-1) Form No. 10)</p>
            
            <p><strong>District</strong> <?= $this->utilityclass->getDistrictName($data['dist_code']) ?> <strong>Circle</strong> <?= $this->utilityclass->getCircleName($data['dist_code'], $data['subdiv_code'], $data['cir_code']) ?> <strong>Mouza</strong> <?= $this->utilityclass->getMouzaName($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code']) ?></p>
            <p><strong>To</strong> <?= $data['pattadar_names'] ?> <strong>Resident Of </strong><?= $this->utilityclass->getVillageName($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code']) ?></p>

            <?php

            $total_year_revenue = 0;
            $total_year_tax = 0;
            foreach ($data['arrear_details'] as $arrear) {
                $total_year_revenue += $arrear->year_revenue;
                $total_year_tax += $arrear->year_tax;

                $total_amount = $total_year_revenue + $total_year_tax;
            }
            ?>

            <p style="font-size: small;">Whereas as the total arrear due Rs <?= $total_amount ?> against patta no: <?= $data['patta_no'] ?> , <?= $this->utilityclass->getPattaType($data['patta_type_code']) ?> of <?= $this->utilityclass->getVillageName($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code']) ?>

                on account of Land Revenue and Local Rate as mentioned in detailed below have not yet been paid by you, this is to inform you that unless the same demands be paid within 15 days from the date of the notice you will be treated as a defaulter and proceeded against according to the law.
            </p>

            <table>
                <tr>
                    <th rowspan="2" style="width: 5%;">SL. No.</th>
                    <!-- <th rowspan="2" style="width: 25%;">Name of Settlement holders to whom their notice as issued</th> -->
                    <th colspan="6" style="width: 70%;">Arrears due</th>
                </tr>
                <tr>

                    <th style="width: 15%;">Year</th>
                    <th style="width: 15%;">Land Revenue</th>
                    <th style="width: 15%;">Local Rate</th>
                    <th style="width: 10%;">Costs</th>
                    <th style="width: 15%;">Total</th>
                    <th style="width: 15%;">Remarks</th>
                </tr>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($data['arrear_details'] as $arrear): ?>
                        <?php if ($arrear->year_revenue > 0 || $arrear->year_tax > 0): ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $arrear->financial_year ?></td>
                                <td><?= $arrear->year_revenue ?></td>
                                <td><?= $arrear->year_tax ?></td>
                                <td>0</td>
                                <td><?= $arrear->year_revenue + $arrear->year_tax ?></td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="text-right">Circle Office: <?= $this->utilityclass->getCircleName($data['dist_code'], $data['subdiv_code'], $data['cir_code']) ?></p>
            
            <p>
            <h6>For Payment of Land Revenue:</h6>
            <img src="<?= base_url('assets/e_khajana/qr.jpg') ?>" alt="Logo" style="width: 100px; height: 100px;">
            <ol>
                <li>
                    Visit the <strong>Sewa Setu Portal</strong>
                    (<a href="https://sewasetu.assam.gov.in/site/service-apply/e-khajana" target="_blank">https://sewasetu.assam.gov.in/site/service-apply/e-khajana</a>)
                    or the <strong>e-Khazana Portal</strong>
                    (<a href="https://basundhara.assam.gov.in/ekhazana" target="_blank">https://basundhara.assam.gov.in/ekhazana</a>)
                    and register your <strong>patta</strong> online in the e-Khazana system or scan the QR code above.
                </li>
                <li>
                    To make the payment, go to either the <strong>Sewa Setu Portal</strong> or the <strong>e-Khazana Portal</strong>:
                    <ul>
                        <li>
                            If using the <strong>Sewa Setu Portal</strong>, click the <strong>Apply</strong> button and navigate to the
                            <strong>Khajana Payment</strong> option.
                        </li>
                        <li>
                            If using the <strong>e-Khazana Portal</strong>, click the <strong>Pay/Verify</strong> button to proceed with the payment.
                        </li>
                    </ul>
                </li>
            </ol>
            </p>
            <h6 class="text-center">This is a system generated notice, hence no signature is required</h6>
        </div>
    </div>


</body>

</html>