<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
    }
</style>
<div class="row login panel-form">
    <div class="col-lg-12 center-col">
        <div class="panel " id="printdiv">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold uni_text'><u>NOTICE UNDER SECTION 105 OF THE ALRR ACT 1886</u></p>
                    <p class='center bold uni_text'><u>ভূমিলেখ্য নিয়মাৱলীৰ ১০৫ ধাৰা মতে দিয়া জাননী</u></p>
                </div>
            </div>
            <div class="panel-body form_1">
                <table class='rasid-t'>
                    <tr>
                        <td>যিহেতু <span style="color:#37BC9B"><?php echo $location['cir']; ?></span> ৰাজহ চক্রৰ, <span style="color:#37BC9B"><?php echo $location['mouza']; ?></span> মৌজাৰ, <span style="color:#37BC9B"><?php echo $location['vill']; ?></span> গাঁওৰ  নিবাসী শ্রী/শ্রীমতী <span style="color:#37BC9B"><?php 
                            foreach ($pattadar as $p): 
                            $pattadar=$p->pdar_name;
                            ?>
                            <?php echo $pattadar.", "; ?>
                            <?php endforeach; ?></span> ৰ দৰ্খাস্তৰপৰা উপায়ুক্ত/চক্ৰ বিষয়াই জানিৱ পাৰিছোঁ যে তলত বিবৰণ দিয়া মাটিত ম্যাদীকৰণ বিছাৰিছে ।</td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td>এতেকে এই জাননীৰ দ্বাৰা জ্ঞাত কৰোৱা যায় যে উক্ত দৰ্খাস্তকাৰীৰ স্বাৰ্থৰ প্রকাৰ, পৰিমাণ বা অন্য কোনো বিষয়ত যদি কাৰোবাৰ আপওি থাকে তেন্তে ইং <span style="color:#37BC9B"><?php echo date('d-m-Y',strtotime($location['next_date_of_hearing'])); ?></span> তাৰিখৰ দিনৰ ১০ বজাত এই আদালতত হাজিৰ হৈ লিখিত আপওি দাখিল কৰিব । তেতিয়া যথাবিহিত অনুসন্ধান কৰি আৱশ্যকীয় হুকুম দিয়া যাব ।</td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td>আজি ইং <span style="color:#37BC9B"><?php echo date('d-m-Y',strtotime($location['next_date_of_hearing'])); ?></span> তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ মাৰি দিয়া হ'ল ।</td>
                    </tr>
                </table>
                
                <table class="table table-bordered rasid unicode">
                    <tr style="color:#0000cc;">
                        <td><label class="control-label" >মৌজা আৰু গাঁওৰ বিবৰণ</label></td>
                        <td><label class="control-label" >কালেকটৰীত নামভুক্ত মালিক / ভূমাধিকাৰীৰ নাম আৰু ঠিকনা</label></td>
                        <td><label class="control-label" >আবেদনকাৰীৰ নাম আৰু ঠিকনা</label></td>
                        <td><label class="control-label" >স্বাৰ্থৰ বিৱৰণ <br>(পট্টা, দাগ, কালি)</label></td>
                        <td><label class="control-label" >বাকী থকা স্বাৰ্থৰ বিৱৰণ</label></td>
                    </tr>
                    <tr style="color:#0000cc;">
                        <td><label class="control-label" >১</label></td>
                        <td><label class="control-label" >২</label></td>
                        <td><label class="control-label" >৩</label></td>
                        <td><label class="control-label" >৪</label></td>
                        <td><label class="control-label" >৫</label></td>
                    </tr>
                    <tr>
                        <td><label class="control-label" ><?php echo $location['cir'] . ", " . $location['mouza']; ?></label></td>
                        <td><label class="control-label" >
                            <?php
                            foreach ($pattadar1 as $p1):
                                $pattadar = $p1->pdar_name;
                                ?>
                                <?php echo $pattadar . ", <br>"; ?>
                            <?php endforeach; ?></label>
                        </td>
                        <td><label class="control-label" >
                            <?php
                            foreach ($pattadar2 as $p2):
                                $pattadar = $p2->pdar_name;
                                ?>
                                <?php echo $pattadar . ", <br>"; ?>
                            <?php endforeach; ?></label>
                        </td>
                        <td><label class="control-label" ><?php echo $this->lang->line('patta_no'); ?> : <?php echo $land_details['patta_no']; ?><br> <?php echo $this->lang->line('dag_no'); ?> : <?php echo $land_details['dag']; ?><br> <?php echo $land_details['m_dag_area_b'] . " বিঘা " . $land_details['m_dag_area_k'] . " কঠা " . $land_details['m_dag_area_lc'] . " লেছা " ?></label></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                    <p class="rasid" style="float: right;"><?php echo $location['add_to']; ?><br>
                                         চক্র বিষয়া,&nbsp;<?php echo $location['cir']; ?></p>
                </div>
                <div class="col-sm-12 dontshow">
                <center>
                    <a onclick="return myFunction()" href="#" class="btn btn-danger uni_text" ><i class='fa fa-check'></i>&nbsp;Print this page & Complete Notice Generation</a>
                </center>
                </div>
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


