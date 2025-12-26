<?php 
   date_default_timezone_set('Asia/Calcutta'); 
   ?>
<!DOCTYPE html>
<html class="no-js">
   <head>
      <script type="text/javascript">
         const baseUrl='<?=BASE_JS_LINK?>';
      </script>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>DHARITREE || Land Records Computerization Project</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="<?= $this->utilityclass->csrf__key() ?>" content="<?= $this->utilityclass->csrf__token() ?>" data-id="csrf-key" />

      <link rel="apple-touch-icon" href="apple-touch-icon.png">
      <!-- JS file starts here-->
      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/all.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
      <!-- Google Font: Source Sans Pro -->
      <!-- 		  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
      <!-- jQuery -->
      <script src="<?php echo base_url();?>homePage/js/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="<?php echo base_url();?>homePage/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="<?php echo base_url();?>homePage/js/adminlte.min.js"></script>
      <!------------------>
      <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
      <script src="<?php echo base_url(); ?>application/views/js/vendor/modernizr-2.8.3.min.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery-1.11.3.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>application/views/js/bootstrap.min_1.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>application/views/js/plugins.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.tablesorter.min.js"></script>
      <!-------------->
      <script src="<?php echo base_url();?>application/views/css/jquery-confirm.min.js"></script>
      <link rel="stylesheet" href="<?php echo base_url();?>application/views/css/jquery-confirm.min.css">

      <!-- <script src="<?php echo base_url(); ?>application/views/js/dharitreecore.js?v=1.1"></script> -->
      <!-- <script src="<?php echo base_url(); ?>application/views/js/ajax.js?v=1.1"></script> -->
      <script src="<?php echo base_url(); ?>application/views/js/inputmask.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.inputmask.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.validate.min.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/blowfish.js"></script>
      <!-- <script src="<?php echo base_url(); ?>application/views/js/jquery.dataTables.min.js"></script> -->
      <script src="<?php echo base_url(); ?>application/views/js/graph/jquery.jqplot.min.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/graph/jqplot.pieRenderer.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/graph/jqplot.enhancedLegendRenderer.min.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/verhoef.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/pramukhime.js"></script>
      <script type='text/javascript' src="<?php echo base_url(); ?>application/views/js/pramukhindic.js" ></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/pramukhime-common.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/convertchars.js"></script>
      <!-- JS file ends here-->
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.theme.fint.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.charts.js"></script>
      <!-- STyle sheet starts here-->
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/js/graph/jquery.jqplot.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/normalize.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/bootflat.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/font-awesome.min.css" type="text/css"/>
      <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/dataTables.jqueryui.css"> -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/app.css">
      <!-- STyle sheet ends here-->
      <!--links are added for jquery calendar-->
      <link type="text/css" href="<?php echo base_url(); ?>application/views/css/flora.datepick.css" rel="stylesheet">
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery.datepick.js"></script>
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/jquery.growl.css">
      </style>
      <link href="<?php echo base_url('css/styles.css');?>" rel="stylesheet" />
      <link rel="stylesheet" href="<?php echo base_url('fonts/css/font-awesome.css');?>">
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/jquery.growl.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/NotificationService.js"></script>
      <!--end calendar links-->

      
      
   </head>
   <body style="background: none !important;">
      <style type="text/css">
         .navbar {
         position: relative;
         min-height: 20px;
         margin-bottom: 0px !important; 
         border: 1px solid transparent;
         border-radius: 0px !important;
         } 
         /* table.dataTable tbody th, table.dataTable tbody td {
         font-size: 1.2em !important
         } */
      </style>
      <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="ilrms_nav_top">
         <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
               <div>
                  <a><img src="<?php echo base_url(); ?>assets/flag.png" alt="Flag" style="color:#fff;margin-right: 5px;">GOVERNMENT OF ASSAM</a>
                  <a><img src="<?php echo base_url(); ?>assets/vertical-line.png" alt="verticalline" style="color:#fff;margin-right: 5px;">Revenue &amp; Disaster Management </a>
               </div>
               <div>
                  <a href="govindex.html" target="_blank" class="gov_login_switch" style="text-decoration: none;"></a>
               </div>
            </div>
         </div>
      </nav>

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
               <div style="position: absolute; margin-right:100px; right:10px; margin-top: 15px;">
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


                     আৱেদন পৰীক্ষাৰ অন্তত <b><?=$date_of_sldc?></b> তাৰিখৰ ভূমি উপদেষ্টা সমিতিৰ বৈঠকৰ সিদ্ধান্ত অনুসৰি 

                     <?php if($dept_order_no!=null && $dept_order_date!=null){?>
                     আৰু ৰাজহ আৰু দুৰ্যোগ ব্যৱস্থাপনা বিভাগ, অসম চৰকাৰৰ অধিসূচনা No.<?=$dept_order_no?> dtd <?=$dept_order_date?> অনুযায়ী 
                     <?php }?>

                        চৰকাৰী মাটিৰ বন্দৱস্তীৰ/ ভূমি স্থানান্তৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে, অসম ভূমি ও ৰাজহ অধিনিয়ম ১৮৮৬ আৰু ভূমি নীতি/নিয়ম অনুসৰি ওপৰত উল্লেখ কৰা দাগত উল্লেখিত প্ৰতিষ্ঠানৰ নামত ভূমিৰ বন্দৱস্তী/ হস্তান্তৰ বাবে এই জাননীযোগে জনোৱা হল আৰু উল্লেখিত প্ৰতিষ্ঠানৰ কৰ্তৃপক্ষই উক্ত প্ৰস্তাৱ গ্ৰহন কৰিবলৈ সন্মত হলে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ জনোৱা হল। 

                    
                    <br>
                    সেই অনুসৰি, উক্ত ভূমিৰ প্ৰিমিয়াম আদায় ক্ৰমে আপোনাৰ প্ৰতিষ্ঠানৰ নামত ভূমিৰ বন্দৱস্তী/ হস্তান্তৰ বাবে কতৃপক্ষই বিবেচনা কৰিছে। 
                    <br>
                     আৱেদনকাৰী  প্ৰতিষ্ঠানৰ আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ- 



                    
                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">ক্ৰমিক নং</th>
                                <th class="text-center">বৰ্ণনা</th>
                                <th>প্ৰিমিয়াম (per bigha)</th>
                                <th>ভূমি ৰাজহ(per bigha)</th>
                                <th>দাগ</th>
                                <th class="text-center">কালি</th>
                                <th class="text-center">মুঠ মূল্য</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php echo $tbody; ?>
                        </tbody>
                    </table>

                    সেইমৰ্মে, আৱেদনকাৰী  প্ৰতিষ্ঠানক <b>₹ <?=$net_premium_payable?></b> টকা প্ৰিমিয়াম অহা ইং <b><?=date('d/m/Y', strtotime('+15 days'))?></b> তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হল। 
                    <br>
                    <br>

                    <u><b>চৰ্তাৱলী</b></u>
                    <br>
                    ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পিছতহে আৱেদনকাৰী  প্ৰতিষ্ঠানক ভূমিৰ বন্দৱস্তী/ হস্তান্তৰ প্ৰদান কৰা হব। 
                    


                 </div>
              </div>
              <div class="row mt-2">
              <!-- <div class="col-12 text-justify pl-5 pr-5">
               <b><u>চৰকাৰী অধিসূচনা</u></b> <br>
                  ১) Govt letter no.RSS.288/81/4 dated 02-04-1982,Govt OM no ECF.106184/2019/8 dated 20-05-2019,Govt OM no ECF.106184/2019/9 dated 07-07-2021 & Govt OM ECF no.106184/2019/11 dated 02-05-2022.<br>
                  ২) eCF No. 565802/ I/772761/2024 Dated Dispur, 15-10-2024<br>
                  ৩)eCF No.565802/I/776018/2024 Dated 19-10-2024<br>
                  8) eCF No.565802/I/777763/2024 Dated.20-10-2024 , No.ECF. 647652/2025/4 dated 10-06-2025<br>





              </div> -->
              </div>

              <div class="row mt-2">
              <div class="col-12 text-justify pl-5 pr-5 pb-5 pt-2 fw-bold">
              <!-- <b>ওপৰত উল্লেখ কৰা প্ৰিমিয়াম আপোনাৰ স্ব-ঘোষণাৰ লগতে সংশ্লিষ্ট চক্ৰ বিষয়াই কৰা (সম্ভাব্য) মূল্যায়নৰ ওপৰত নিৰ্ধাৰণ কৰি আপোনাৰ দখল/অধীনত থকা মাটিৰ ওপৰত নিৰ্ণয় কৰা হৈছে। আধুনিক পদ্ধতিৰে জৰীপৰ পিছত দখল/অধীনত থকা প্ৰকৃত মাটিৰ পৰিমাণ সাল-সলনি হ’লে আদায় দিবলগীয়া ভূমিৰ প্ৰিমিয়াম সংশোধন কৰা হ’ব পাৰে।    </b> -->
               <br><br>
               <b>আপোনাৰ প্রিমিয়াম Sewa Setu (https://sewasetu.assam.gov.in/) পৰ্টেলৰ পৰা পৰিশোধ কৰিব পাৰিব। </b>
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
        <div class="container">
           <div class="row mt-4 mb-5 justify-content-center text-center">
              <div class="col-6">
                 <button type="submit" id="print" class="btn btn-warning text-white">ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
              </div>
           </div>
        </div>
     </form>



      

      <footer class="footer-section spad dontshow">
      <div class="container">
      <div class="row">
      <div class="col-lg-3 col-md-6">
         <div class="footer-widget">
            <h2 class="fw-title">ILRMS</h2>
            <a href="">About ILRMS</a>
            <a href="">FAQs</a>
            <a href="">Contact Us</a>                   
         </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="footer-widget">
            <h2 class="fw-title">Website Links</h2>
            <a href="https://landrevenue.assam.gov.in/" target="_blank">Revenue &amp; Disaster Management</a>
            <a href="https://dlrs.assam.gov.in/" target="_blank">Directorate of Land Records</a>
            <a href="https://igr.assam.gov.in/" target="_blank">Inspector General of Registration</a>
         </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="footer-widget">
            <h2 class="fw-title">Important Links</h2>
            <a href="https://cm.assam.gov.in/" target="_blank">Assam CM Portal</a>
            <a href="https://assam.gov.in/" target="_blank">Assam State Portal</a>
            <a href="https://covid19.assam.gov.in/" target="_blank">Assam Covid-19 Portal</a>
         </div>
      </div>
      </div>
      </div>
      </footer>
      <style type="text/css">.blockUI { z-index: 1200 !important;}</style>
      <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
      <script src="<?php echo base_url('js/bootstrap.bundle.min.js');?>"></script>
      <!-- Core JS-->
      <script src="<?php echo base_url('js/scripts.js');?>"></script>
      <!-- Additional JS-->
      <script src="<?php echo base_url('js/ban.js');?>"></script>
      <script src="<?php echo base_url(); ?>application/views/resources/js/jquery-2.1.3.js"></script>
      <script src="<?php echo base_url(); ?>application/views/resources/js/jspdf.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.base64.min.js"></script>

      <?php
         include(APPPATH . 'views/layouts/ajax-setup.php');
      ?>

   </body>

</html>
<script>
   // -js- base64 conversion to save notice file
   $( "#print" ).click(function() {           
       var htmlString =$( "#printableArea" ).html();
       var htmlString = b64EncodeUnicode(htmlString);
   
           $( "#htmlstring_text" ).text( htmlString );
           $("#print").submit();
       //alert(htmlString);
       });
       function b64EncodeUnicode(str) {    
               return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                   function toSolidBytes(match, p1) {
                       return String.fromCharCode('0x' + p1);
               }));
       }
   
</script>

