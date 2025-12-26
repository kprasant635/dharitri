<!DOCTYPE html>
<html lang="as">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body {
            font-family: freesans;
            margin: 10px;
            padding: 10px;
            border: 1px solid #000;
        }

        .content {
            margin-top: 10px;
        }

        .bottom {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            font-weight: normal;
            /* Disable bold if font lacks bold support */
            font-family: 'freesans';
            /* Force Assamese support */
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
    </style>
    <title>অসম চৰকাৰ নোটিশ</title>
</head>

<body>
    <div class="content">
        <div class="text-center" style="text-align: center;">
            উপায়ুক্তৰ কাৰ্যালয়, <?= $this->utilityclass->getCircleName($data['dist_code'], $data['subdiv_code'], $data['cir_code']) ?>
            <br>
            ডিমান্দ জাননী
            <br>
            (Assam Schedule XXIV (Part-1) Form No. 10)
        </div>

        <p>
        <div class="spacebetween">
            <div>নং 1011</div>
            <div>তাৰিখঃ ইং: <?= date('Y-m-d') ?></div>
        </div>
        </p>
        <p>প্ৰতি,</p>
        <p> <?= $data['pattadar_names'] ?> </p>

        <?php

        $total_year_revenue = 0;
        $total_year_tax = 0;
        foreach ($data['arrear_details'] as $arrear) {
            $total_year_revenue += $arrear->year_revenue;
            $total_year_tax += $arrear->year_tax;

            $total_amount = $total_year_revenue + $total_year_tax;
        }
        ?>

        <p>ইয়াৰ দ্বাৰা আপোনাক/আপোনালোকক জনোৱা যায় যে <?= $this->utilityclass->getVillageName($data['dist_code'], $data['subdiv_code'], $data['cir_code'], $data['mouza_pargona_code'], $data['lot_no'], $data['vill_townprt_code']) ?> গাওঁৰ <?=$data['patta_no']?> নং ম্যাদী পট্টা ভুক্ত মাটিৰ তলত উল্লেখ মতে মুঠ ৰাজহ <?= $total_amount ?> টকা আপুনি/আপোনালোকে আদায় দিয়া নাই। সেয়েহে উক্ত ৰাজহ অহা 15 দিনৰ সময়সীমাৰ ভিতৰত ভিতৰত সম্পূর্ণ ৰপে পৰিশোধ
            কৰিবৰ বাবে আপোনালোকক এই জাননী যোগে জনোরা হল। অন্যথা আইনমতে খাজনা আদায় নিদিয়াৰ বাবে আপোনাৰ আপোনালোকৰ অস্থাৱৰ সম্পত্তি কুক কৰ্মে নিলাম দি অথবা পট্টা মাটি নিলাম বিক্ৰী মৰ্মে বিধি মতে খাজনা আদায় ব্যৱস্থা লোৱা হব পাৰে।</p>

        <div>
            <table class="table">
                <tr>
                    <th rowspan="2" style="width: 10%;">SL. No.</th>
                    <!-- <th rowspan="2" style="width: 25%;">Name of Settlement holders to whom their notice as issued</th> -->
                    <th colspan="6" style="width: 70%;">বকেয়া পাবলগীয়া ধন</th>
                </tr>
                <tr>

                    <th style="width: 15%;">বছৰ</th>
                    <th style="width: 15%;">ভূমি ৰাজহ</th>
                    <th style="width: 15%;">স্থানীয় হাৰ</th>
                    <th style="width: 10%;">খৰচ</th>
                    <th style="width: 15%;">মুঠ</th>
                    <th style="width: 15%;">মন্তব্য</th>
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
        </div>
        <br>

        <p class="text-right">Circle Office: <?= $this->utilityclass->getCircleName($data['dist_code'], $data['subdiv_code'], $data['cir_code']) ?></p>
        
        <p>
        <div class="font-size: medium">ভূমি ৰাজহ পৰিশোধৰ বাবে:</div>
        <img src="<?= base_url('assets/e_khajana/qr.jpg') ?>" alt="Logo" style="width: 100px; height: 100px;">
        <ol>
            <li>
                সেৱা সতু প'ৰ্টেল
                (<a href="https://sewasetu.assam.gov.in/site/service-apply/e-khajana" target="_blank">https://sewasetu.assam.gov.in/site/service-apply/e-khajana</a>)
                বা e-Khazana প'ৰ্টেল
                (<a href="https://basundhara.assam.gov.in/ekhazana" target="_blank">https://basundhara.assam.gov.in/ekhazana</a>)
                ভ্ৰমণ কৰক আৰু e-Khazana প্ৰণালীত আপোনাৰ পট্টা অনলাইনত পঞ্জীয়ন কৰক বা ওপৰৰ QR ক'ডটো স্কেন কৰক।
            </li>
            <li>
                পৰিশোধ কৰিবলৈ, সেৱা সতু প'ৰ্টেল বা e-Khazana প'ৰ্টেল ব্যৱহাৰ কৰক:
                <ul>
                    <li>
                        যদি সেৱা সতু প'ৰ্টেল ব্যৱহাৰ কৰে, তেন্তে Apply button ক্লিক কৰি
                        খজনা পৰিশোধ বিকল্পত যাওক।
                    </li>
                    <li>
                        যদি e-Khazana প'ৰ্টেল ব্যৱহাৰ কৰে, তেন্তে Pay/Verify button ক্লিক কৰি
                        পৰিশোধ প্ৰক্ৰিয়াত আগবাঢ়ক।
                    </li>
                </ul>
            </li>
        </ol>
        </p>
        <p class="text-center">এইটো এটা স্বচালিত জাননী, সেয়ে কোনো স্বাক্ষৰ প্ৰয়োজন নাই।</p>
</body>

</html>