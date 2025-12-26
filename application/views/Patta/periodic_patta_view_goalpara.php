<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        /*margin: 0mm;  !* this affects the margin in the printer settings *!*/
        margin: 10mm 10mm 10mm 10mm;
        size: portrait; /* for page layout */
    }

    html {
        background-color: #FFFFFF;
        margin: 0px; /* this affects the margin on the html before sending to printer */
    }

    body {
    / / border: solid 1 px blue;
        /*margin: 10mm 15mm 10mm 15mm; !* margin you want for the content *!*/
        margin: 0px;

    }

    .unicode {
        font-size: 5px !important;
    }

    table.print-friendly tr td, table.print-friendly tr th {
        page-break-inside: avoid;
    }

    @media print {
        p {
            break-inside: avoid;
        }
    }
</style>
<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-12 panel-body ">
            <p class="uni_text hide" style="text-align: center;margin-top: 14px;">[কামৰূপ, শিৱসাগৰ, নগাওঁ, দৰং আৰু লক্ষীমপুৰ জিলাৰ ডেপুটি
                কমিচনাৰ চাহাব বাহাদুৰৰ ব্যৱহাৰৰ কাৰণে]</p>
            <h2 style="text-align: center;margin-top: 16px;">PERIODIC KHHIRAJ PATTA</h2>
            <p class="bold uni_text" style="text-align: center;margin-top: 16px;">মিয়াদি খেৰাজী পট্টা</p>
            <div style="line-height: 30px;margin-top: 30px;margin-bottom: 30px;">
                <p class='uni_text' style="font-size:1em; text-align:justify;">
                    <p style="float: right;" class="hide">তাৰিখঃ <?= $this->utilityclass->cassnum(date('d-m-y')) ?></p>                    
                    <div>
                        <div class='row'>
                            <div class='col-lg-4'>
                                জিলা:<b>গোৱালপাৰা</b>                     
                            </div>
                            <div class='col-lg-4'>
                                পট্টা নং: <b><?= $this->utilityclass->cassnum($patta_basic->patta_no) ?></b>
                            </div>                            
                        </div>
                        <div class='row'>
                            <div class='col-lg-4'>
                                চক্ৰ: <b><?= $this->utilityclass->getCircleName($patta_basic->dist_code, $patta_basic->subdiv_code,
                                    $patta_basic->cir_code) ?></b>
                            </div>
                            <div class='col-lg-4'>
                                মৌজা/তহচিল:
                                <b>
                                    <?php
                                    echo $this->utilityclass->getMouzaName($patta_basic->dist_code, $patta_basic->subdiv_code,
                                    $patta_basic->cir_code, $patta_basic->mouza_pargona_code) ?>
                                </b>                     
                            </div>
                            <div class='col-lg-4'>
                                গাওঁ: <b>
                                    <?php
                                    echo $this->utilityclass->getVillageName($patta_basic->dist_code, $patta_basic->subdiv_code, $patta_basic->cir_code,
                                    $patta_basic->mouza_pargona_code, $patta_basic->lot_no, $patta_basic->vill_townprt_code) ?>
                                </b>
                            </div>
                        </div>
                    </div>                    
                    <br><br>
                    (১) মই ওপৰোক্ত জিলাৰ উপায়ুক্ত/বন্দোবস্তী প্ৰাধিকাৰীয়ে ইয়াৰ দ্বাৰা ঘোষণা কৰো যে অসম ভূমি আৰু ৰাজহ অধিনিয়ম ১৮৮৬ আৰু এই আইনৰ অধীনত সময়ে সময়ে কৰা আৰু কৰিবলগীয়া নিয়ম সাপেক্ষে চৰকাৰৰ হকে নিম্নলিখিত পট্টাদাৰ, তেওঁৰ উত্তৰাধিকৰী, প্ৰতিনিধি, স্থলাভিষিক্ত সকলক, সিপিঠিত উল্লেখ কৰা তপচিলৰ মাটিত পৰা লৈ বছৰৰ বাবে খাজনা আৰু স্থানীয় কৰ নিৰ্দ্ধাৰিত কৰি, উত্তৰাধিকাৰীত্ব আৰু হস্তান্তৰ কৰিব পৰা ভোগ দখলৰ স্বত্ব দি পট্টা দিয়া হ'ল।
                    <br><br>
                    <b>পট্টাদাৰৰ নাম</b>- <?=$pattadar_name?>
                </p>

                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (২) এই মাটিৰ নিৰূপিত ৰাজহ আৰু স্থানীয় কৰ তথা অন্যান্য কৰ তলত দিয়া মতে বা চৰকাৰে সময়মতে ধাৰ্য্য কৰা নিৰিখ অনুযায়ী বছৰি শোধাব। চৰকাৰে ধাৰ্য্য কৰা নিৰিখ মতে পট্টাত লগোৱা ৰাজহ আৰু স্থানীয় কৰ সময়ে সময়ে পৰিবৰ্ত্তন কৰিব পাৰিব আৰু সেইমতে পৰিবৰ্ত্তন হোৱা ৰাজহ আৰু স্থানীয় কৰ পট্টাদাৰে নিয়মিতভাবে শোধাব লাগিব। 
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৩) বন্দোবস্তীৰ সময়সীমাৰ ভিতৰত পট্টাযুক্ত কৃষি শ্ৰেণীৰ অন্তৰ্গত মাটিৰ সম্পূৰ্ণ বা আংশিকভাবে অনা কৃশি কাম যেনে- বস্তি, বেপাৰ-বাণিজ্য, উদ্যোগ হিচাপে ব্যৱহাৰৰ ধৰণ পৰিবৰ্তন হ'লে বা বৰ্তমানৰ ব্যৱহাৰৰ ধৰণৰ ব্যতিৰেকে আন কোনো ধৰণে ব্যহাৰ হ'লে চৰকাৰে অসম ভূমি ও ৰাজহ অধিনিয়ম ১৮৮৬ আৰু অসম ভূমি ৰাজহ পুনঃনিৰ্ধাৰণ আইন ১৯৩৬ আৰু ইয়াৰ অধীনৰ নিয়মাৱলী অনুসৰি নতুনকৈ নিৰ্ধাৰণ কৰিব পাৰিব আৰু পট্টাদাৰ, তেওঁৰ উত্তৰাধিকৰী, প্ৰতিনিধি আৰু স্থলাভিষিক্ত সকলে এই মাটিৰ বাবে নিৰ্ধাৰিত ৰাজহ, স্থানীয় কৰ আৰু অন্যান্য কৰ জমা দিয়াৰ বাবে দায়ী থাকিব।
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৪) এই পট্টাৰ ম্যদ উকলি গ'লে পট্টাদাৰক বা তেওঁৰ উত্তৰাধিকৰী, প্ৰতিনিধি আৰু স্থলাভিষিক্ত সকলক এই মাটিৰ নতুন পট্টা ল'বলৈ প্ৰথমে সুবিধা দিয়া হ'ব আৰু তেওঁলোকে সেই সুবিধা ল'ব নিবিচাৰিলে পট্টাদাৰ, তেওঁৰ উত্তৰাধিকৰী, প্ৰতিনিধি, স্থলাভিষিক্ত সকলৰ স্বত্ব আৰু তেওঁৰ উত্তৰাধিকৰী, প্ৰতিনিধি, স্থলাভিষিক্ত সকলৰ হাতেদি বা তেওঁলোকৰ অধীনে সেই মাটিত কাৰোবাৰ ৰায়তী বা বন্ধক সূত্ৰে ভোগ কৰিব পৰা স্বত্ব থাকিলেও সেই স্বত্ব সম্পূৰ্ণৰূপে ৰহিত আৰু শেষ হ'ব।
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৫) এই মাটিত থকা শিলৰ খনি, খনিজ বস্তু, তেল বা মাটিৰ তলত পোত গৈ থকা বহুমূলীয়া বস্তু, পূৰাতাত্বিক গুৰুত্ব থকা সম্পদ আৰু চৰকাৰে বিবেচনা কৰা যিকোনো গুৰুত্বপূৰ্ণ সম্পদৰ ওপৰত চৰকাৰৰ স্বত্ব থাকিব। এই বিলাক বিচাৰিবলৈ বা খান্দি উলিয়াবলৈ যাওঁতে মাটিৰ উপৰিভাগত কোনো লোকচান হ'লে জিলাৰ উপায়ুক্তই হিচাপ কৰি ক্ষতিপূৰণৰ বাবে যি টকা ধাৰ্য কৰে সেই টকা পট্টাদাৰ বা উত্তৰাধিকৰী বা প্ৰতিনিধি স্থলাভিষিক্ত সকলক দি সেই সামগ্ৰী আহৰণ, সংস্থাপন আৰু স্থানান্তৰ কৰিবলৈ ৰাজ্য চৰকাৰৰ সম্পূৰ্ণ ক্ষমতা থাকিব।
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৬) আলি বা মথাউৰি মেৰামতি কৰাৰ বাবে চৰকাৰ তথা চৰকাৰৰ কাৰ্যকাৰকসকলে কোনো ক্ষতিপূৰণ নিদিয়াকৈ সকলো কেন্দ্ৰীয় বা ৰাজ্য চৰকাৰ বা পৌৰ নিকায়সমূহৰ অধীনৰ আলি আৰু মথাউৰিৰ নামনিৰ পৰা ৩৫ ফুটৰ ভিতৰত মাটি কটাব পাৰিব আৰু তাত থকা শষ্য বা লাগনী গছ বা ঘৰৰ মূল্যৰ বাহিৰে আন কোনো ক্ষতিপূৰণ নিদিয়াকৈ সেই মাটি বা তাৰ কোনো অংশ ল'ব পাৰিব।
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৭) এই মাটি জিলা উপায়ুক্তৰ আগতীয়া মঞ্জুৰী অবিহনে হস্তান্তৰ কৰিব পৰা নাযাব।    
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৮) পট্টাযুক্ত মাটি আংশিকভাবে বা সম্পূৰ্ণকৈ ইস্তফা দিব বিচাৰিলে নিৰ্ধাৰিত তাৰিখত বা তাৰ আগেয়ে ইস্তফা দিব খোজা জাননী দিব লাগিব। ইস্তফা দিয়া মাটিৰ খাজনা আৰু স্থানীয় কৰ পট্টাৰ মুঠ খাজনা আৰু স্থানীয় কৰৰ পৰা বাদ যাব।
                </p>
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (৯) চৰকাৰী জমিত নতুনকৈ পট্টন দিয়া মাটি ১০ বছৰৰ ভিতৰত হস্তান্তৰ যোগ্য নহ'ব, কিন্তু গৃহ নিৰ্মাণ, বেপাৰ-বাণিজ্য উদ্যোগ আদি স্থাপনৰ বাবে বেংক/বিত্তীয় প্ৰতিষ্ঠানৰপৰা ঋণ ল'বলৈ বন্ধক পাৰিব।
                </p>                
                <p class='uni_text' style="font-size:1em; text-align:justify; ">
                    (১০) ওপৰত উল্লেখ কৰা নিয়মৰ উপৰিও চৰকাৰে সময়ে সময়ে আন চৰ্ত নিৰ্ধাৰণ কৰিব পাৰিব আৰু এই নিয়মসমূহৰ কোনো এটা নিয়ম ভংগ কৰিলে এই পট্টা ৰদ হ'ব।
                </p>               
                <br>

                <?php $total_locat_tax = null;
                foreach ($patta_basic_dag as $d2) {
                    $total_locat_tax = $total_locat_tax + $d2->dag_local_tax;
                } ?>

                <table class="table table-bordered table_black print-friendly pt-2" style="font-size:1em;">
                    <tr>
                        <td>দাগৰ নম্বৰ</td>
                        <td>প্ৰত্যেক দাগৰ মাটিৰ শ্ৰেণী</td>
                        <td>প্ৰত্যেক দাগৰ মাটিৰ কালি</td>
                        <td>প্ৰত্যেক দাগৰ মাটিৰ ৰাজহ</td>
                        <td>মন্তব্য</td>
                    </tr>
                    <?php $total_revenue = null;
                    foreach ($patta_basic_dag as $d): ?>
                        <tr>
                            <td><?= $this->utilityclass->cassnum($d->dag_no) ?></td>
                            <td><?= $this->utilityclass->getLandClassCode($d->land_class_code) ?></td>
                            <?php if (in_array($d->dist_code, json_decode(BARAK_VALLEY))): ?>

                                <td><?= $this->utilityclass->cassnum($d->dag_area_b) . " বি: " .
                                    $this->utilityclass->cassnum($d->dag_area_k) . " ক: " .
                                    $this->utilityclass->cassnum(number_format($d->dag_area_lc, 2)) . " চ: " .
                                    $this->utilityclass->cassnum($d->dag_area_g) . " গ: " .
                                    $this->utilityclass->cassnum($d->dag_area_kr) . " কা: " ?>
                                </td>

                            <?php else: ?>
                                <td><?= $this->utilityclass->cassnum($d->dag_area_b) . " বি: " .
                                    $this->utilityclass->cassnum($d->dag_area_k) . " ক: " .
                                    $this->utilityclass->cassnum(number_format($d->dag_area_lc, 2)) . " লে: " ?>
                                </td>
                            <?php endif; ?>
                            <td><?= $this->utilityclass->cassnum(number_format($d->dag_revenue,2)) ?></td>
                            <td></td>
                        </tr>
                        <?php ?>
                        <?php $total_revenue = $total_revenue + $d->dag_revenue; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3">মুঠ</td>
                        <td><?= $this->utilityclass->cassnum(number_format($total_revenue,2)) ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">স্থানীয় কৰ যোগদিয়া</td>
                        <td><?= $this->utilityclass->cassnum(number_format($total_locat_tax, 2)) ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">সৰ্বমুঠ</td>
                        <td><?= $this->utilityclass->cassnum(number_format(($total_revenue + $total_locat_tax), 2)) ?></td>
                        <td></td>
                    </tr>
                </table>
                
                <br>

                <div> 
                    <div class="row">
                        <div class="col-lg-12">
                            তপচিল
                        </div>
                    </div>                  
                    <div class='row'>
                        <div class='col-lg-4'>
                            জিলা:<b>গোৱালপাৰা</b>                     
                        </div>
                        <div class='col-lg-4'>
                            পট্টা নং: <b><?= $this->utilityclass->cassnum($patta_basic->patta_no) ?></b>
                        </div>                            
                    </div>
                    <div class='row'>
                        <div class='col-lg-4'>
                            চক্ৰ: <b><?= $this->utilityclass->getCircleName($patta_basic->dist_code, $patta_basic->subdiv_code,
                                $patta_basic->cir_code) ?></b>
                        </div>
                        <div class='col-lg-4'>
                            মৌজা/তহচিল:
                            <b>
                                <?php
                                echo $this->utilityclass->getMouzaName($patta_basic->dist_code, $patta_basic->subdiv_code,
                                $patta_basic->cir_code, $patta_basic->mouza_pargona_code) ?>
                            </b>                     
                        </div>
                        <div class='col-lg-4'>
                            গাওঁ: <b>
                                <?php
                                echo $this->utilityclass->getVillageName($patta_basic->dist_code, $patta_basic->subdiv_code, $patta_basic->cir_code,
                                $patta_basic->mouza_pargona_code, $patta_basic->lot_no, $patta_basic->vill_townprt_code) ?>
                            </b>
                        </div>
                    </div>
                </div>   
                <br>স্বাক্ষৰ
                <br>উপায়ুক্ত/
                <br>বন্দোবস্তী প্ৰাধিকাৰী/
                <br>কৰ্তৃত্বপ্ৰাপ্ত বিষয়া,
                <br>জিলা : <b>গোৱালপাৰা</b>
                <br>পট্টাদাৰৰ চহী
            </div>
            <div class="form-group no-print" style="text-align: center;">
                <button type="submit" class="btn btn-primary" onclick="return myFunction()"><i class="fa fa-print"></i>&nbsp;Print
                    Patta
                </button>
                <a href="<?php echo base_url(); ?>index.php/Patta/selectPattaView" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;Back to Search Patta
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        $(".dontshow").hide();

        window.print();
        $(".dontshow").show();
        document.getElementById("mainMenu").disabled = false;
    }
</script>