

      <form action="<?php echo base_url()?>index.php/SettlementInstitutionCo/savePaymentNotice" method="post" enctype='multipart/form-data'>
         <input type="hidden" name="case_no" value="<?=$case_no?>">
         <input type="hidden" name="remark" value="<?=$remark?>">
         <input type="hidden" name="district" value="<?=$this->utilityclass->getDistrictName($get_settlement_basic->dist_code)?>">
         <input type="hidden" name="sub_division" value="<?=$this->utilityclass->getSubDivName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code)?>">
         <input type="hidden" name="circle" value="<?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>">
         <input type="hidden" name="lot_no" value="<?=$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)?>">
         <input type="hidden" name="mouza" value="<?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?>">
         <input type="hidden" name="village" value="<?=$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)?>">
         <input type="hidden" name="pay_notice_gn_date" value="<?=$pay_notice_date?>">

         <input type="hidden" name="amount" value="<?=$net_premium_payable;?>">
         <input type="hidden" name="settlement_amount" value="<?=$final_settlement_amount;?>">
         <input type="hidden" name="reclass_amount" value="<?=$final_reclass_amount;?>">
         <input type="hidden" name="land_revenue_amount" value="<?=$final_land_revenue_years;?>">
         <input type="hidden" name="ins_cat_type_co" value="<?=$instituteDetails->ins_cat_type_co;?>">

        

        <div id="printableArea">
        
           <div class="bg-white shadow" id="print_direct">
           <style>
            table {
                  width: 100%;
                  max-width: 100%;
                  margin-bottom: 1rem;
            }

            table th,
            table td {
            padding: 0.40rem;
            /* vertical-align: top; */
            border: 1px solid #191919;
            }

         </style>
               <div style="position: absolute; right:10px; margin-top: 15px;">
                    <?php 
      
                      $dataqr = explode(",", $qrcode);
                      $dataqr = $dataqr[1];
                      echo '<img class="img-fluid" src="data:image/png;base64,' . $dataqr . '" />';
                      ?>

                    
                
                 </div>
              <div class="row mt-5 text-center">
                 <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;text-align: center;">
                    অসম চৰকাৰ
                    <br>
                    চক্ৰ বিষয়াৰ কাৰ্যালয়, <?=$circle_name?> ৰাজহ চক্ৰ
                    <br>
                    জিলা- <?=$dist_name?>
                    <br>
                    <?php if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
                    { ?>
                      <br>
                    বন্দবস্তী প্ৰস্তাৱ পত্ৰ

                    <?php }else{ ?>
                      <br>
                    জাননী

                    <?php } ?>
                    <br> 
                    <?=$date?>
                 </div>

                 
                 
              </div>

            
              <div class="row mt-4">
                 <div class="col-12 text-justify p-5">
                    প্ৰতি: <b><?=$applicant_name?></b> (প্ৰতিষ্ঠানৰ বোৰ্ড/সমিতি/অনুমোদিত প্ৰতিনিধি)</b>
                    <br>
                    <br>
                    <br>

                    পিতা/ স্বামী : <b><?=$guardian_name;?></b>
                    <br>
                    <br>

                    প্ৰতিষ্ঠানৰ নাম আৰু ঠিকনা <br>
                    <b><?=$instituteDetails->ins_name_co;?></b><br>
                    <b><?=$dist_name?> , <?=$circle_name?>,<?=$village_name?></b>
                    
                    <br>
                    <br>
                    ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ৩.০ ৰ অধীনত <b><?=$service_name?></b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভূক্ত ভূমিৰ বাবে <b><?=$date_of_application?></b> তাৰিখে আৱেদন নং <b><?=$application_no?></b> দাখিল কৰিছে। 


                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th>জিলা</th>
                                <th>ৰাজহ চক্ৰ</th>
                                <th>মৌজা</th>
                                <th>লাট নং</th>
                                <th>গাওঁ</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$dist_name?></td>
                                <td><?=$circle_name?></td>
                                <td><?=$mouza_name?></td>
                                <td><?=$lot_name?></td>
                                <td><?=$village_name?></td>
                                <td><?=$first_dag_no?></td>
                                <td><?=$first_area?></td>
                            </tr>
                        </tbody>
                    </table>


                    আৱেদন পৰীক্ষাৰ অন্তত <b><?=$date_of_sldc?></b>  তাৰিখৰ ভূমি উপদেষ্টা সমিতিৰ বৈঠকৰ সিদ্ধান্ত অনুসৰি আৰু ৰাজহ আৰু দুৰ্যোগ ব্যৱস্থাপনা বিভাগ, অসম চৰকাৰৰ অধিসূচনা No. <?=$dept_order_no?> dtd <?=$dept_order_date?> অনুযায়ী চৰকাৰী মাটিৰ বন্দৱস্তীৰ  বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে, অসম ভূমি ও ৰাজহ অধিনিয়ম ১৮৮৬ আৰু  ভূমি নীতি/নিয়ম অনুসৰি ওপৰত উল্লেখ কৰা দাগত উল্লেখিত প্ৰতিষ্ঠানৰ দখলত থকা ভূমিৰ পট্টনৰ বাবে এই জাননীযোগে জনোৱা হল আৰু উল্লেখিত প্ৰতিষ্ঠানৰ ব’ৰ্ড/সমিতিয়ে উক্ত প্ৰস্তাৱ গ্ৰহন কৰিবলৈ সন্মত হলে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ জনোৱা হল। 
                    <br><br>

                     সেই অনুসৰি, উক্ত ভূমিৰ প্ৰিমিয়াম আদায় ক্ৰমে আপোনাৰ প্ৰতিষ্ঠানৰ নামত বন্দৱস্তীৰ  বাবে কতৃপক্ষই বিবেচনা কৰিছে। 
                     <br>

                     আৱেদনকাৰী  প্ৰতিষ্ঠানৰ বন্দৱস্তীৰ  সময়ত আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ - 


                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">ক্ৰমিক নং</th>
                                <th class="text-center">বৰ্ণনা</th>
                                <th>প্ৰিমিয়াম (per bigha)</th>
                                <th>দাগ</th>
                                <th class="text-center">কালি</th>
                                <th class="text-center">মুঠ মূল্য</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php echo $tbody; ?>
                        </tbody>
                    </table>


                    সেইমৰ্মে, আৱেদনকাৰী  প্ৰতিষ্ঠানক বন্দৱস্তীৰ লগতে শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ বাবে (যদি প্ৰযোজ্য) <b>₹ <?=$net_premium_payable?></b> টকা প্ৰিমিয়াম অহা ইং <b><?=date('d/m/Y', strtotime('+15 days'))?></b> তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হল। 
                    <br>
                    <br>

                    <u><b>চৰ্তাৱলী</b></u>
                    <br>

                    <?php if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
                    { ?>
                    ক) পঞ্জীয়ন প্ৰমাণপত্ৰ জমা দিয়াৰ লগতে দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পিছতহে আৱেদনকাৰী প্ৰতিষ্ঠানক ভূমিৰ বন্দৱস্তী প্ৰদান কৰা হ’ব।
                 <?php } else {?>
                    ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পাছতহে আৱেদনকাৰী  প্ৰতিষ্ঠানক ভূমিৰ বন্দৱস্তী প্ৰদান কৰা হ’ব। 
                 <?php } ?>
                     <br>
                     <br>


                 </div>
              </div>
              <div class="row mt-2">
              <!-- <div class="col-12 text-justify pl-5 pr-5">
               <b><u>চৰকাৰী অধিসূচনা</u></b> <br>
                  <br>
            
                  ১) E-430577/2024I/489202/2024  dated Dispur, 06-03-2024<br>
                  ২) eCF No. 565802/ I/772761/2024 Dated Dispur, 15-10-2024<br>
                  ৩)eCF No.565802/I/776018/2024 Dated 19-10-2024<br>
                   8) eCF No.565802/I/777763/2024 Dated.20-10-2024 , No.ECF. 647652/2025/4 dated 10-06-2025.
<br>
              </div> -->
              </div>

              <div class="row mt-2">
              <div class="col-12 text-justify pl-5 pr-5 pb-5 pt-2 fw-bold">
              <!-- <b> ওপৰত উল্লেখ কৰা প্ৰিমিয়াম আপোনাৰ স্ব-ঘোষণাৰ লগতে সংশ্লিষ্ট চক্ৰ বিষয়াই কৰা (সম্ভাব্য) মূল্যায়নৰ ওপৰত নিৰ্ধাৰণ কৰি আপোনাৰ দখল/অধীনত থকা মাটিৰ ওপৰত নিৰ্ণয় কৰা হৈছে। আধুনিক পদ্ধতিৰে জৰীপৰ পিছত দখল/অধীনত থকা প্ৰকৃত মাটিৰ পৰিমাণ সাল-সলনি হ’লে আদায় দিবলগীয়া ভূমিৰ প্ৰিমিয়াম সংশোধন কৰা হ’ব পাৰে।   </b> -->
               <br><br>
               <b>আপোনাৰ প্রিমিয়াম Sewa Setu (https://sewasetu.assam.gov.in/) পৰ্টেলৰ পৰা পৰিশোধ কৰিব পাৰিব।   </b>
              </div>
              </div>

              <div class="row mt-5 justify-content-end mb-5" style="text-align:right;">
                 <div class="col-2 text-center">
                 <b><?=$this->utilityclass->getSelectedCOName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code, $this->session->userdata('user_code'))->username?></b><br>
                     চক্ৰ বিষয়া <br> 
                     <?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>
                 </div>
              </div>
              <br>
              
           </div>
        </div>
        <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>
     </form>



      

      