<div class="container-fluid form-top">
    <div class="col-lg-12" id="printdiv">
        <p class="uni_text">Assam Schedule XXXVII, Form No.21 </p>
        <h1 class="text-center uni_text">ANNUAL KHIRAJ PATTA</h1>
        <p class="uni_text text-center">
            <?php
            //var_dump($this->session->all_userdata());
             //var_dump($dagDtls);
            //var_dump($certDtls);
            echo $this->utilityclass->getCertName($certDtls->cert_type);
            echo " নং " . $dagDtls[0]->patta_no;
            ?> 

        </p>
        <hr>
        <div class="col-lg-4">জিলা :<?php echo $location['distname'] ?></div>
        <div class="col-lg-4">মৌজা :<?php echo $location['mouza_pargona_code'] ?></div>
        <div class="col-lg-4">গাঁও :<?php echo $location['vill_townprt_code'] ?></div>

        <hr style="border: 1px dotted #000">
        <p class="uni_text">
            প্রতি , <?php echo $certDtls->appln_name; ?> <br>

            যিহেতু অসমৰ ভূমি আৰু ৰাজহ  বিধি ব্যৱস্থা সময়ে সময়ে কৰা তাৰ নিয়মৰ বশৱৰ্তী হৈ ইয়াৰ লগত দিয়া তপচিলত লিখা মাটি আপুনি দখল কৰিছে , 
            তলত লিখা স্বৰ্তমতে আপোনাক ইং <?php echo $certDtls->year_no; ?> ৰাজহ বছৰৰ এই পাট্টা দিয়া হ’ল –
        </p>
        <p class="uni_text">
            1) ইয়াৰ লগত দিয়া তপচিলত দেখুৱা পুৰা খজনা আৰু স্থানীয় কৰ আপুনি নিৰ্ধাৰিত তাৰিখত কিস্তিমতে আদায় কৰিৱ | 
        </p>
        <p class="uni_text">
            2) এই বছৰৰ কাৰণে তপচিলত লিখিত মাটিত আপোনাৰ ব্যৱহাৰ ও দখলীস্বত্ত থাকিব কিণ্তু হস্তান্তৰ কৰিবৰ কোনো ক্ষমতা নাথাকিৱ |
        </p>
        <p class="uni_text">
            3)	কথিত  বছৰৰ বাহিৰে তপচিলত লিখা মাটিত আপোনাৰ কোনো প্রকাৰৰ স্বত্ত বা হক নাথাকিব আৰু এই প্রকাৰৰ ম্যাদ
            উকলি যোবাৰ সময়ত এই মাটিৰ ওপৰত থকা বাঢ়ি অহা শষ্য , গুটিলগা গছ নাইবা ঘৰৰ বাবে , ৫ দফাত উল্লেখ কৰা ব্যৱস্থাৰ 
            বাহিৰে আপুনি কোনো লোকচানি দাবী কৰিৱ নোবাৰিৱ | কিণ্তু আপুনি নাইবা গভৰ্ণমেন্টে <?php echo date('d/m/Y', strtotime($certDtls->to_date)); ?> তাৰিখে বা তাৰ পূৰ্বে ,
            অৰ্থৰ / চৰকাৰী পক্ষক লিখিত নটিচৰ দ্বাৰা  তপচিলত লিখিত নাইবা কোনো মাটিৰ পুনৰ পাট্টা দিৱ নালাগে বুলি নজনালে , 
            চৰকাৰে যি ৰাজহ ধাৰ্য্য কৰে সেই ৰাজহত এই পাট্টা পুনৰ এবছৰৰ কাৰণে আপুনাক দিয়া হৱ |
        </p>
        <p class="uni_text">
            4)	তিনি দফাত কোৱা লিখা নটিচ আপুনি দিবলৈ হলে নটিচৰ আগেয়ে সমুদায় ৰাজহ ও স্থানীয় কৰ আদায় কৰিব লাগিব 
            আৰু যদি কথিত তাৰিখৰ কিম্বা তাৰ পূৰ্ব্বে আপুনি ৰাজহ স্থানীয় কৰ আদায় কৰি এনে নটিচ নিদিয়ে তেনেহলে 
            ( ওপৰত কোৱা মতে যদি চৰকাৰে আপোনাৰ ওচৰত নটিচ নিদিয়ে ) আপুনি তপচিলত লিখা  মাটিত ৰাজহ আৰু স্থানীয় 
            কৰ পুনৰ এবছৰৰ কাৰণে দিবলৈ দায়ী থাকিব |
        </p>
        <p class="uni_text">
            5)	এই পাট্টাৰ ম্যাদ চলি থাকোতেই যদি তপচিলত লিখা সমুদায় মাটি নাইবা তাৰ কোনো অংশ চৰকাৰী কামৰ 
            কাৰণে প্রয়োজন হয় তেনেহলে সেই মাটি আপোনাৰ পৰা এৰোৱাই লোবা হব | এইদৰে মাটি এৰোৱাই ললে এৰোৱাই 
            লোবা মাটিৰ বাঢ়ি অহা শষ্য , গুটি লগা গছ আৰু ঘৰৰ বাবে হে আপুনি গভৰ্ণমেন্টৰ পৰা লোকচানি পাৱ | কিণ্তু 
            মাটি দোখৰৰ বাবে আপুনি কোনো লোকচানি নাপাব কিয়নো মাটি দোখৰ অকল চৰকাৰহে সম্পওি – আপোনাৰ নহয় |
        </p>
        <p class="uni_text">
            6) তপচিলত লিখিত  মাটিৰ খেতিৰ নিমিওে উপযোগী কৰিবলৈ আপুনি তাত থকা জঙ্গল চাফা কৰিব পাৰিব ,কিণ্তু 
            বেৰে এফুটতকৈ ডাঙৰ শিমলু গছ কিম্বা তাৰ ডাল কাটিব নোবাৰিৱ আৰু পুৰা কাঠৰ মাচুল আগেয়ে আদায় নকৰাকৈ 
            কোনো কাঠ বিক্ৰী ৰ কাৰণে স্থান্তাতৰ কৰিব নোবাৰিৱ |
        </p>
        <p class="uni_text">
            7) আপোনাৰ ঘৰৰ বাহিৰৰ অতিৰক্ত যি খেৰ তপচিলত দেখুওবা মাটিৰ পৰা কাটি আনিব , সেই খেৰৰ বহুতে সময়ে 
            ডিভিচনেল ফৰেস্ট অফিচাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত  হোবা মূল্যত তপচিলৰ যি মাটি থাকে সেই ঠাইৰ খেৰ মহলদাৰৰ ওচৰত বিক্ৰী কৰিব লাগিৱ |
        </p>
        <p class="uni_text">
            8)	এই পাট্টাৰ ম্যাদ চলি থাকোতেই যদি আপোনাৰ মৃত্যু হয় আপোনাৰ উওৰাধিকাৰী বিলাকে সেই বছৰৰ আৰু সেই সময়ৰ কাৰণে স্বত্ব পাৱ |
        </p>

        <hr>
        <p class="pull-left">
            তাৰিখ : <?php echo date('d/m/Y'); ?>
        </p>
        <p class="pull-right">
            ডেপুটি কমিচনাৰ,<br><br> চেটেলমেণ্ট অফিচাৰ 
        </p>

        <hr>
        <p class="uni_text">* টোকা ১৯৩১ চনৰ অসমৰ ভূমি আৰু ৰাজহ আইনৰ বিষয়ৰ মেনুবেলৰ ৬৭ পৃস্ঠাত থকা বন্দোবস্ত সম্পৰ্কীয় নিয়মাবলীৰ ২১ (চ) 
            নিয়মৰ অধীনত বিজ্ঞাপিত ঠাইত যি পট্টা দিয়া হৱ কেৱল সেই ঠাইৰ শিমলু গছৰ ক্ষেএসম্বেন্ধেহে ব্যৱস্তা খাটিব |</p>
        <p class="uni_text">** ৭ম দফা ৰাজহুবা খেৰ বছৰৰ ভিতৰত থকা মাটিৰ বাৱেহে খাটিৱ অথৱা কাটি পেলাৱ |</p>
        <hr>
        <table class="table-bordered table " width="100%" border="1">
            <tr>
                <td>দাগৰ ক্ৰমিক নং </td>
                <td>প্রত্যেক দাগৰ শ্রেণী  </td>
                <td>বিঘামতে প্রত্যেক দাগৰ মাটিৰ পৰিমাণ </td>
                <td>প্রত্যেক দাগৰ  ৰাজহ </td>
                <td>মন্তব্য </td>
            </tr>
            <tr>
                <td><?php echo $dagDtls[0]->dag_no; ?></td>
                <td><?php echo $this->utilityclass->getLandClassCode($dagDtls[0]->land_class_code); ?></td>
                <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                <td><?php echo $dagDtls[0]->a_dag_area_b . "B-" . $dagDtls[0]->a_dag_area_k . "K-" . $dagDtls[0]->a_dag_area_lc . "C-".$dagDtls[0]->a_dag_area_g . "G"; ?></td>
                <?php }else{?>
                <td><?php echo $dagDtls[0]->a_dag_area_b . "B-" . $dagDtls[0]->a_dag_area_k . "K-" . $dagDtls[0]->a_dag_area_lc . "L"; ?></td>
            <?php }?>
                <td>0</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <p class="uni_text text-center">মুঠ : .......................</p>
                    <p class="uni_text text-center">স্থানীয় কৰ যোগ দিয়া : ...................</p>
                    <p class="uni_text text-center">সৰ্ব্বমুঠ :......................</p>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <p>DLR & Survey (XXXVII)F No.21- 14/05-06</p>
        <hr>   
        <?php
        $data = explode(",", $qrcode)[1];
        echo '<img src="data:image/png;base64,' . $data . '" />';
        ?> 
    </div>
    <div class="row dontshow">
        <div class="col-lg-12 col-lg-offset-4">
            <form action="<?php echo base_url(); ?>index.php/CitizenController/CaseDelivered" method="POST">
                <div class="btn btn-primary uni_text" id="openBtn"><i class="fa fa-arrow-circle-down"></i> Keep Pending</div>
                <div class="btn btn-sm btn-danger uni_text printlink" onclick="myFunction()" ><i class="fa fa-print"></i> &nbsp;Print Report</div>
                <button class="btn btn-info" disabled type="submit" id='close'>Certificate is Delivered</button>
                <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="case_no" >
            </form>
        </div>
    </div>

</div>
<style>
    p{
        font-size:1em !important;
    }
</style>
<script>
    function myFunction() {
        //document.getElementById("print").disabled = false;
        //document.getElementById("close").disabled = false;
        $(".dontshow").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("close").disabled = false;
    }
</script>



