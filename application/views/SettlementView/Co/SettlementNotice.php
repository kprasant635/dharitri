

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

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/jquery.growl.css"></style>


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

    <form action="<?php echo base_url()?>index.php/SettlementApCo/saveNotice" method="post" enctype='multipart/form-data'>
        
        
    
        <div class="container bg-white shadow" id="print_direct"> 
            <div class="row mt-5 text-center">
            <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                <u>(Case No: <?=$case_no?> ) for settlement report</u>
                <input type="hidden" name="case_no" value="<?=$case_no?>">
                <input type="hidden" name="remark_co" value="<?=$remark_co?>">
                <input type="hidden" name="hearing_date" value="<?=$hearing_date?>">
                <input type="hidden" name="district" value="<?=$this->utilityclass->getDistrictName($get_settlement_basic->dist_code)?>">
                <input type="hidden" name="sub_division" value="<?=$this->utilityclass->getSubDivName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code)?>">
                <input type="hidden" name="circle" value="<?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>">
                <input type="hidden" name="lot_no" value="<?=$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)?>">
                <input type="hidden" name="mouza" value="<?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?>">
                <input type="hidden" name="village" value="<?=$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)?>">
                
                
            </div>
            </div>
            <div class="row mt-4 text-center">
            <div class="col-4 text-center">
                District: 
                <?=$this->utilityclass->getDistrictName($get_settlement_basic->dist_code)?>
                </div>
            <div class="col-4 text-center">
                Sub-Division: <?=$this->utilityclass->getSubDivName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code)?>
                </div>
            <div class="col-4 text-center">
                Circle: 
                <?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>
                </div>
            </div>
            <div class="row mt-3 text-center">
                <div class="col-4 text-center">
                    Lot No: <?=$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)?>
                </div>
                <div class="col-4 text-center">
                    Mouza: 
                    <?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?>
                </div>
                <div class="col-4 text-center">
                    Village/Town: 
                    <?=$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque, natus laboriosam aut, tempore numquam ducimus, a culpa consequuntur eligendi unde ut quasi. Ducimus animi ipsam neque. Atque tenetur assumenda dolorum?
                </div>
            </div>
            <table class="table mt-5">
                <tr>
                    <th><strong>Petitioners Name</strong></th>
                    <th><strong>Guardian Name</strong></th>
                    <th><strong>Dag No</strong></th>
                </tr>

                <?php foreach($get_settlement_applicant as $app) ?>
                <input type="hidden" name="petitioner_name" value="<?=$app->pdar_name?>">
                <input type="hidden" name="g_name" value="<?=$app->pdar_guardian?>">
                <input type="hidden" name="dag_name" value="<?=$app->dag_no?>">
                
                <tr>
                    <td><?=$app->pdar_name?></td>
                    <td><?=$app->pdar_guardian?></td>
                    <td><?=$app->dag_no?></td>
                </tr>
            </table>
            <div class="row mt-5">
                <div class="col-12 text-right">
                    Circle Officer, <?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>
                </div>
            </div>

        </div>
    
    


        <div id="printableArea">
            
        </div>



    <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>

            
        
        <div class="container">
                <div class="row mt-4 mb-5 justify-content-center text-center">
                    <div class="col-6">
                            <button type="submit" id="print" class="btn btn-danger text-white">Save Notice</button>
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
<a href="">Contact Us</a>                   </div>
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