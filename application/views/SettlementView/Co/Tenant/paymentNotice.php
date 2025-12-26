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
      <script type="text/javascript">
         $(function () {
             $('#popupDatepicker').datepick({dateFormat: 'dd-mm-yyyy'});
         });
         $(function () {
             $('#popupDatepicker1').datepick({dateFormat: 'dd-mm-yyyy'});
         });
         $(function () {
             $('#ddmmyy').datepick({dateFormat: 'dd/mm/yyyy', minDate: 0, maxDate: 0});
         });
         $(function () {
             $('#enable_next_date').datepick({dateFormat: 'dd/mm/yyyy', minDate: 0});
         });
         $(function () {
             $('#ddmmyy1').datepick({dateFormat: 'dd/mm/yyyy'});
         });
         $(function () {
             $('#popup1Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
         });
         $(function () {
             $('#popup2Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
         });
         $(function () {
             $('#popup3Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
         });
         $(function () {
             $('#DatepickerCO').datepick({dateFormat: 'yyyy-mm-dd'});
         });
         $(function () {
             $('#popup5Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
         });
         
         $(function () {
             $('input[type="date"]').datepick({dateFormat: 'dd-mm-yyyy'});
         });
         
         $(function () {
             $('.dating').datepick({dateFormat: 'dd-mm-yyyy'});
         });
         //////////Range select/////////
         $(function () {
             $('.stdate').datepick({dateFormat: 'dd-mm-yyyy'});
         });
         $(function () {
             $('.endate').datepick({dateFormat: 'dd-mm-yyyy'});
         });
         
      </script>
   </head>
   <body>
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
      <form action="<?php echo base_url()?>index.php/SettlementTenantCo/savePaymentNotice" method="post" enctype='multipart/form-data'>
         <input type="hidden" name="case_no" value="<?=$case_no?>">
         <input type="hidden" name="remark" value="<?=$remark?>">
         <input type="hidden" name="district" value="<?=$this->utilityclass->getDistrictName($get_settlement_basic->dist_code)?>">
         <input type="hidden" name="sub_division" value="<?=$this->utilityclass->getSubDivName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code)?>">
         <input type="hidden" name="circle" value="<?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>">
         <input type="hidden" name="lot_no" value="<?=$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)?>">
         <input type="hidden" name="mouza" value="<?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?>">
         <input type="hidden" name="village" value="<?=$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)?>">
         <input type="hidden" name="pay_notice_gn_date" value="<?=$pay_notice_date?>">
         <?php
            $total_payable_amount = 0;
            foreach($get_dag_details as $dags){
                // getting the total lessa conversion from utility class
                $total_lessa = $this->utilityclass->Total_Lessa($dags->s_dag_area_b, $dags->s_dag_area_k, $dags->s_dag_area_lc);
                // calculating total payable amount
                $total_amt = ($total_lessa/100) * $payment_amount;
                // converting total payable amount to 2 decimal format number format
                $total_payable_amount = number_format((float)($total_payable_amount + $total_amt), 2, '.', '');
            }
            ?>
         <input type="hidden" name="amount" value="<?=$total_payable_amount;?>">
         <div id="printableArea">
            <div class="container bg-white shadow" id="print_direct">
               <div class="row mt-5 text-center">
                  <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                     <u>ক্ষতিপূৰণ জমা দিয়াৰ বাবে আবেদনকাৰী ৰায়তীক জাননী</u>                
                  </div>
               </div>
               <div class="row mt-5 px-5">
                  <div class="col-2">
                     জাননী নং- 
                  </div>
                  <div class="col-3">
                     <b><?=$case_no?></b>
                  </div>
               </div>
               <div class="row mt-2 px-5">
                  <div class="col-2">
                     তাৰিখ- 
                  </div>
                  <div class="col-3">
                     <b><?=$pay_notice_date?></b>
                  </div>
               </div>
               <div class="row mt-4">
                  <div class="col-12 text-justify p-5">
                     অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী নিয়ম, ১৯৭২ৰ ১৭ নং নিয়ম অনুসৰি জাৰি কৰা এই জাননীৰ জৰিয়তে  
                     <b>'অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী আইন'</b>ৰ অধীনত পট্টাদাৰ শ্ৰী 
                     <b>
                     <?php 
                        $position = 0;
                        $length = count($get_buyers);
                        foreach($get_buyers as $app){
                                if($position == $length - 1){
                                    echo $app->pdar_name;
                                }elseif($position == $length - 2){
                                    echo $app->pdar_name.' আৰু ';
                                }else{
                                    echo $app->pdar_name.', ';
                                }
                                $position++;
                            }
                        ?></b> 
                     ৰ,  
                     <b><?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?></b> 
                     মৌজাৰ, 
                     <b><?=$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)?></b> নম্বৰ লাটৰ, <b><?=$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)?></b>
                     গাঁৱৰ, 
                     <?php
                        $dag_position = 0;
                        $dag_length = count($get_dag_details);
                        
                        foreach($get_dag_details as $dags){
                            if($dag_position == $dag_length - 1){
                                ?>
                     <b><?=$dags->patta_no?></b> 
                     নং পট্টাৰ, <b><?=$dags->dag_no?></b> 
                     দাগৰ, মুঠ <b><?=$dags->s_dag_area_b;?></b> 
                     বিঘা <b><?=$dags->s_dag_area_k;?></b> 
                     কঠা <b><?=$dags->s_dag_area_lc;?></b> 
                     লেচা 
                     <?php
                        }elseif($dag_position == ($dag_length - 2)){
                            ?>
                     <b><?=$dags->patta_no?></b> 
                     নং পট্টাৰ, <b><?=$dags->dag_no?></b> 
                     দাগৰ, মুঠ <b><?=$dags->s_dag_area_b;?></b> 
                     বিঘা <b><?=$dags->s_dag_area_k;?></b> 
                     কঠা <b><?=$dags->s_dag_area_lc;?></b> 
                     লেচা আৰু 
                     <?php
                        }else{
                            ?>
                     <b><?=$dags->patta_no?></b> 
                     নং পট্টাৰ, <b><?=$dags->dag_no?></b> 
                     দাগৰ, মুঠ <b><?=$dags->s_dag_area_b;?></b> 
                     বিঘা <b><?=$dags->s_dag_area_k;?></b> 
                     কঠা <b><?=$dags->s_dag_area_lc;?></b> 
                     লেচা,
                     <?php
                        }
                        $dag_position++;
                        }
                        ?>
                     জমিত <b>'অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী আইন'</b>ৰ অধীনত ২৩ নং ধাৰামতে মালিকীস্বত্ব লাভৰ বাবে আপোনাৰ আৱেদনৰ ভিত্তিত <b><?=$get_settlement_basic->co_hearing_date?></b> তাৰিখে হৈ যোৱা   শুনানিৰ সিদ্ধান্ত মৰ্মে আপোনাক <b><?=$total_payable_amount;?></b> টকাৰ মুঠ ক্ষতিপূৰণ অনলাইন পদ্ধতিৰে জমা কৰিবলৈ অনুৰোধ জনোৱা হ'ল।
                  </div>
               </div>
               <div class="row mt-5 justify-content-end mb-5">
                  <div class="col-5 text-center">
                     <b><?=$this->utilityclass->getSelectedCOName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code, $this->session->userdata('user_code'))->username?></b><br>
                     চক্ৰ বিষয়া <br> 
                     <?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>
                  </div>
               </div>
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