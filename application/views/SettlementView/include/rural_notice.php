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
      <?php 
         $bhulink=BHUNAKSHA_LINK;
         if($_SESSION['credentials']['noc']){
             $noc_link=NOC_LINK;
         }
         else{
             $noc_link='hide';
         }
         ?>
      <script>
         $(document).ready(function () {
             console.log("Ready");
             $('.example2').on('click', function(e){
                 e.preventDefault();
             $.confirm({
                 title: '',
                 content: 'You are going to redirect to NOC Application! Do you want to proceed ? ',
                 buttons: {
                     confirm: function(){
                         $.alert('Confirmed!');
                         window.location = "<?=$noc_link;?>index.php/login/SingleSign/<?=$_SESSION['credentials']['noc']?>";
                     },
                     cancel: function(){
                         $.alert('Canceled!');
                     },
                 }
             });
         });
         $('.example3').on('click', function(e){
                 e.preventDefault();
             $.confirm({
                 title: '',
                 content: 'You are going to redirect to Bhunaksha Application! Do you want to proceed ? ',
                 buttons: {
                     confirm: function(){
                         $.alert('Confirmed!');
                         //window.location = "<?=$bhulink?>";
         window.open("<?=$bhulink?>", 'bhunaksha');
                     },
                     cancel: function(){
                         $.alert('Canceled!');
                     },
                 }
             });
         });
         
         });
      </script>
      <!--------------->
      <script src="<?php echo base_url(); ?>application/views/js/dharitreecore.js?v=1.1"></script>
      <script src="<?php echo base_url(); ?>application/views/js/ajax.js?v=1.1"></script>
      <script src="<?php echo base_url(); ?>application/views/js/inputmask.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.inputmask.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.validate.min.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/blowfish.js"></script>
      <script src="<?php echo base_url(); ?>application/views/js/jquery.dataTables.min.js"></script>
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
      <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/dataTables.jqueryui.css">
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
         table.dataTable tbody th, table.dataTable tbody td {
         font-size: 1.2em !important
         }
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

      <form action="<?php echo base_url()?>index.php/SettlementCommon/savePaymentNotice" method="post" enctype='multipart/form-data'>
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

        <div id="printableArea">
        
           <div class="container bg-white shadow" id="print_direct">
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

                      <?php
                        $due_date = date('d/m/Y', strtotime('+15 days'));

                     ?>

                    
                
                 </div>
              <div class="row mt-5 text-center">
                 <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                    অসম চৰকাৰ
                    <br>
                    চক্ৰ বিষয়াৰ কাৰ্যালয়, <?=$circle_name?> ৰাজহ চক্ৰ
                    <br>
                    জিলা- <?=$dist_name?>
                    <br>
                    <br>
                    জাননী
                    <br> 
                    <?=$date?>
                 </div>

                 
                 
              </div>

              <div class="row mt-4">
                 <div class="col-12 text-justify p-5">
                    প্ৰতি: <b><?=$applicant_name?></b> পিতা/ স্বামী <b><?=$guardian_name?></b>
                    <br>
                    <br>
                    ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰাৰ অধীনত <b><?=$service_name?></b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভূক্ত ভূমিৰ বাবে <b><?=$date_of_application?></b> তাৰিখে আৱেদন নং  <b><?=$application_no?></b>. দাখিল কৰিছে।
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
                                <td><?=$dag_no?></td>
                                <td><?=$area?></td>
                            </tr>
                        </tbody>
                    </table>
                    আৱেদন পৰীক্ষাৰ অন্তত  <b><?=$date_of_sldc?></b> তাৰিখৰ ভূমি উপদেষ্টা সমিতিৰ বৈঠকৰ সিদ্ধান্ত অনুসৰি চৰকাৰী মাটিৰ পট্টনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে অসম ভূমি ও ৰাজহ অধিনিয়ম ১৮৮৬ অন্তর্গত ৩২(১) ধাৰা অনুসৰি ওপৰত উল্লেখ কৰা দাগত আপোনাৰ দখলত থকা ভূমিৰ পট্টনৰ বাবে এই জাননীযোগে জনোৱা হ'ল
                    আৰু আপুনি উক্ত পট্টন গ্ৰহন কৰিবলৈ সন্মত হলে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ জনোৱা হল ।
                    <br><br>
                    সেই অনুসৰি উক্ত ভূমিৰ প্ৰিমিয়াম আদায় ক্ৰমে আপোনাৰ নামত পট্টনৰ বাবে কতৃপক্ষই বিবেচনা কৰিছে।
                    <br><br>
                    আপুনি আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ-
                    
                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th></th>
                                <th>বৰ্ণনা</th>
                                <th>প্ৰিমিয়াম (per bigha)</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                                <th>মুঠ মূল্য</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>১</td>
                                <td><b>প্ৰিমিয়াম মূল্য</b></td>
                                <td><?=$premium_per_bigha?></td>
                                <td><?=$dag_no?></td>
                                <td><?=$area?></td>
                                <td><?=$actual_premium?></td>
                            </tr>
                            <!-- <tr>
                                <td>২</td>
                                <td><b>মিছন বসুন্ধৰা ৰেহাই মূল্য</b></td>
                                <td><?=$mission_per_bigha?></td>
                                <td><?=$dag_no?></td>
                                <td><?=$area?></td>
                                <td><?=$premium_payable_without_concession?></td>
                            </tr> -->
                            <tr>
                                <td>৩</td>
                                <td><b>বিশেষ শ্ৰেণীৰ বাবে ৰেহাই (২৫%)</b></td>
                                <td><?=$type_of_concession?></td>
                                <td><?=$concession_dag_no?></td>
                                <td><?=$concession_area?></td>
                                <td><?=$concession_amount?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center"><b>শুদ্ধ/চূড়ান্ত দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td><b><?=$net_premium_payable?></b></td>
                            </tr>
                        </tbody>
                    </table>
                    সেইমৰ্মে আপোনাক সৰ্বমুঠ <b><?=$net_premium_payable?></b> টকাৰ  প্ৰিমিয়াম অহা ইং <?=$due_date?> তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হ’ল।
                    <br>
                    <br>
                    <u>চৰ্তাৱলী</u>
                    <br>
                    ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পাছতহে আৱেদনকাৰীক ভূমিৰ পট্টা প্ৰদান কৰা হ'ব। 
                    <br>
                    <!-- খ) প্ৰিমিয়াম আদায়ৰ অন্তিম তাৰিখ <b><?=$payment_date?></b> -->
                    খ) আবেদনকাৰীয়ে দিবলগীয়া প্ৰিমিয়াম আদায় দিলে লগে লগে পট্টন দিয়া হ’ব। <br>
                    <!-- গ) আবেদকাৰীয়ে যদি প্ৰিমিয়াম কিস্তি হিচাপে আদায় দিব বিচাৰে তোনেক্ষেত্ৰত প্ৰথমতে ৩০ শতাংশ আৰু বাকী প্ৰিমিয়ামৰ ধনখিনি ৫ বছৰৰ ভিতৰত আদায় দিব লাগিব। <br>
                    ঘ) কিস্তি হিচাপে আদায় দিব বিচৰা আবেদনকাৰীৰ ক্ষেত্ৰত প্ৰথম ৩০ শতাংশ আদায় দিয়াৰ পাছত ৫ বছৰৰ ভিতৰত যদি আবেদনকাৰীৰ মৃত্যু ঘটে তেন্তে বাকী প্ৰিমিয়ামৰ ধনখিনি আবেদনকাৰীৰ উত্তৰাধিকাৰীয়ে আদায় দিব লাগিব। <br> -->

                 </div>
              </div>
              <div class="row mt-4">
              <div class="col-12 text-justify p-5 fw-bold">
                <!-- <u>চৰকাৰী অধিসূচনা</u> <br>
                ১) RSS.502/2019/Pt/2(ECF No.130241/2020) dated Dispur,24-08-2021 <br>
                ২) eCFNo.565802/I/772778/2024 dated Dispur,the 15-10-2024 -->

                <!-- ১) No. RSR.9/88/Pt.II/64 Dtd. 25-May-1999 <br>
                   No. RSS.532/2011/Pt/152    Dtd. 21-Feb-2014 <br>
                ২) No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)  <br>
                ৩) No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)   -->
              </div>
              </div>

              <div class="row mt-4">
              <div class="col-12 text-justify p-5 fw-bold">
              <!-- <b>ওপৰত উল্লেখ কৰা প্ৰিমিয়াম আপোনাৰ স্ব-ঘোষণাৰ লগতে সংশ্লিষ্ট চক্ৰ বিষয়াই কৰা  (সম্ভাব্য) মূল্যায়নৰ ওপৰত নিৰ্ধাৰণ কৰি আপোনাৰ দখল/অধীনত থকা মাটিৰ ওপৰত নিৰ্ণয় কৰা হৈছে। আধুনিক পদ্ধতিৰে জৰীপৰ পিছত দখল/অধীনত থকা প্ৰকৃত মাটিৰ পৰিমাণ সাল-সলনি হ’লে আদায় দিবলগীয়া ভূমিৰ প্ৰিমিয়াম সংশোধন কৰা হ’ব পাৰে। </b> -->
               <br><br>
               <b>*পৰিৱৰ্তিত প্ৰিমিয়াম দখল অনুসৰি সংশোধনযোগ্য হ’ব।  </b>
               <br><br>
               <b>আপোনাৰ প্রিমিয়াম Sewa Setu (https://sewasetu.assam.gov.in/) পৰ্টেলৰ পৰা পৰিশোধ কৰিব পাৰিব।  </b>
              </div>
              </div>

              <div class="row mt-5 justify-content-end mb-5">
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