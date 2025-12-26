<style>
   .vertical{
   writing-mode: vertical-rl;
   transform: scale(-1)
   }
   input[type=number]::-webkit-inner-spin-button,
   input[type=number]::-webkit-outer-spin-button {
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   margin: 0;
   }
   .tab-content .card:hover{
   left: 0;
   right: 0;
   top: 0;
   bottom: 0;
   /* box-shadow: none !important; */
   }
   .tab-content .card:active{
   /* left: 0;
   right: 0;
   top: 0;
   bottom: 0; */
   box-shadow: none !important;
   }
   .wizard {
   margin: 10px auto;
   }
   .wizard .nav-tabs {
   position: relative;
   margin: 0px auto;
   margin-bottom: 0;
   border-bottom-color: #e0e0e0;
   }
   .wizard > div.wizard-inner {
   position: relative;
   }
   .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
   color: #fff;
   cursor: default;
   border: 0;
   background-color: #005B96 !important;
   text-decoration: none;
   }
   .wizard li.active{
   background: #005B96;
   padding: 5px;
   box-shadow: 1px 0px 1px 1px;
   }
   .wizard .nav-tabs > li {
   width: 16%;
   border: none;
   }
   .wizard li:after {
   content: " ";
   position: absolute;
   left: 46%;
   opacity: 0;
   margin: 0 auto;
   bottom: 0px;
   border: 5px solid transparent;
   border-bottom-color: #5bc0de;
   transition: 0.1s ease-in-out;
   }
   .wizard li.active:after {
   content: " ";
   position: absolute;
   left: 45%;
   opacity: 1;
   margin: 0 auto;
   bottom: 0px;
   border: 10px solid transparent;
   border-bottom-color: #ffffff;
   }
   .wizard .nav-tabs > li a {
   text-align: center;
   /* width: 90%; */
   margin-bottom: 10px;
   /* padding: 0; */
   }
   .wizard .nav-tabs > li a:hover {
   background-color: transparent !important;
   }
   /* div alternate color */
   div.lm-report > div:nth-of-type(odd) {
   background: #f2fdff;
   }
</style>
<!-- Masud's CSS-->
<style>
   .buttInfo {
   color: #FFF;
   background-color: #03a9f4;
   }
   .buttPrimary {
   color: #FFF;
   background-color: #673AB7;
   }
   .buttDanger {
   color: #FFF;
   background-color: #EF5350;
   }
   .buttCust {
   color: #FFF;
   background-color: #795548;
   }
   .rezaButt:hover {
   color: #0c0c0c;
   }
   .rezaButt{
   display: inline-block;
   position: relative;
   cursor: pointer;
   height: 35px;
   min-width: 150px;
   line-height: 35px;
   padding: 0 1.5rem;
   font-size: 15px;
   font-weight: 600;
   font-family: "Roboto", sans-serif;
   letter-spacing: 0.8px;
   text-align: center;
   text-decoration: none;
   text-transform: uppercase;
   vertical-align: middle;
   white-space: nowrap;
   outline: none;
   border: none;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
   border-radius: 2px;
   transition: all 0.3s ease-out;
   /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
   }
   .reza-card {
   background: #fff;
   border-radius: 2px;
   display: inline-block;
   position: relative;
   width: 100%;
   }
   .reza-card {
   box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
   transition: all 0.3s cubic-bezier(.25,.8,.25,1);
   }
   .reza-title{
   font-weight: bold;
   font-size: 18px;
   margin-bottom: 10px;
   margin-top: 10px;
   background: linear-gradient(to right, #267871, #136a8a);
   color: white;
   text-transform: capitalize;
   text-align: center;
   padding: 8px;
   }
   .reza-body{
   padding-top: 10px;
   padding-left: 20px;
   padding-right: 20px;
   padding-bottom: 40px;
   }
   .bgheading{
   background-color: #248cf7 !important;
   }
   .tableCard{
   box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
   transition: all 0.3s cubic-bezier(.25,.8,.25,1);
   padding-top: 15px!important;
   padding-left: 15px!important;
   padding-right: 15px!important;
   padding-bottom: -1px!important;
   margin-bottom: 15px!important;
   border: 1px solid rgba(0,0,0,.2);
   border-radius: 4px;
   }
</style>
<style>
     /* modal css */
   /* The Modal (background) */
   .modal {
   display: none; /* Hidden by default */
   position: fixed; /* Stay in place */
   z-index: 1; /* Sit on top */
   padding-top: 100px; /* Location of the box */
   left: 0;
   top: 0;
   width: 100%; /* Full width */
   height: 100%; /* Full height */
   overflow: auto; /* Enable scroll if needed */
   background-color: rgb(0,0,0); /* Fallback color */
   background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
   }
   /* Modal Content */
   .modal-content {
   background-color: #fefefe;
   margin: auto;
   padding: 5px;
   border: 1px solid #888;
   width: 70%;
   }
   /* The Close Button */
   .close {
   color: #aaaaaa;
   float: right;
   font-size: 28px;
   font-weight: bold;
   }
   .close:hover,
   .close:focus {
   color: #000;
   text-decoration: none;
   cursor: pointer;
   }
   .element{
   margin-bottom: 10px;
   }
   .add,.remove{
   padding: 2px 10px;
   }
   .add:hover,.remove:hover{
   cursor: pointer;
   }
   .delete{
   padding: 2px 10px;
   }
   .reza-card {
   background: #fff;
   border-radius: 2px;
   display: inline-block;
   position: relative;
   width: 100%;
   }
   .reza-card {
   box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
   transition: all 0.3s cubic-bezier(.25,.8,.25,1);
   }
   .reza-body{
   padding-top: 10px;
   padding-left: 20px;
   padding-right: 20px;
   padding-bottom: 40px;
   }
   .timeline {
   max-width: 830px;
   margin: 0px auto;
   display: flex;
   flex-direction: column;
   position: relative;
   padding: 15px 0px;
   }
   .timeline::after {
   content: "";
   position: absolute;
   width: 3px;
   background-color: #848892;
   height: 100%;
   top: 0px;
   left: 50%;
   transform: translateX(-50%);
   }
   .timeline__content {
   display: flex;
   flex-direction: column;
   align-items: flex-start;
   padding: 18px 30px;
   background-color: white;
   border-radius: 5px;
   position: relative;
   width: 386px;
   box-shadow: 0 2px 8px 0 #242e4c59;
   }
   .timeline__content::after {
   content: "";
   position: absolute;
   width: 20px;
   height: 20px;
   background-color: white;
   top: 50%;
   transform: translateY(-50%) rotate(45deg);
   }
   .timeline__content::before {
   content: "";
   position: absolute;
   width: 20px;
   height: 20px;
   background-color: #848892;
   border-radius: 50%;
   transform: translateY(-50%);
   }
   .timeline__content:nth-child(odd) {
   margin-left: auto;
   }
   .timeline__content:nth-child(odd) .content_tag {
   right: 5px;
   }
   .timeline__content:nth-child(odd)::after {
   left: -10px;
   }
   .timeline__content:nth-child(odd)::before {
   top: 50%;
   left: -39px;
   }
   .timeline__content:nth-child(even) {
   align-items: flex-end;
   }
   .timeline__content:nth-child(even) .content_p {
   text-align: right;
   }
   .timeline__content:nth-child(even)::after {
   right: -10px;
   }
   .timeline__content:nth-child(even)::before {
   top: 50%;
   right: -39px;
   }
   .timeline__content:nth-child(even) .content_tag {
   left: 5px;
   }
   .content_tag {
   position: absolute;
   top: 5px;
   padding: 6px 10px;
   background-color: #66BB6A;
   border-radius: 3px;
   font-weight: bold;
   font-size: 14px;
   color: #1f1f1f;
   text-transform: capitalize;
   }
   .content_date {
   margin-bottom: 10px;
   font-weight: bold;
   font-size: 14px;
   color: #848892;
   }
   .content_Name {
   margin-bottom: 10px;
   font-weight: bold;
   font-size: 14px;
   color: #673AB7;
   }
   .content_p {
   color: #242e4c;
   max-width: 230px;
   margin-bottom: 20px;
   }
   .content_link {
   display: inline-flex;
   text-decoration: none;
   align-items: center;
   font-weight: bold;
   font-size: 14px;
   color: #1f1f1f;
   }
   .content_link svg {
   margin-left: 5px;
   }
   .content_link:hover {
   color: royalblue;
   transition-duration: 300ms;
   }
   .content_link:hover svg path {
   fill: royalblue;
   }
   @media screen and (max-width: 600px) {
   .timeline {
   gap: 15px;
   padding: 10px;
   }
   .timeline::after {
   display: none;
   }
   .timeline__content {
   width: 100%;
   }
   .timeline__content::after {
   display: none;
   }
   .timeline__content::before {
   display: none;
   }
   }
</style>
<style>
    .close-bene {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-bene:hover,
    .close-bene:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function(){
        
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();
        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    
            var $target = $(e.target);
    
            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });
    
        $(".next-step").click(function (e) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function (e) {
    
            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);
    
        });
    });
    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }

   $(function () {
       $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
   });

</script>
<?php
if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) {
    $lessa_chatak = 'Chatak';} else {
    $lessa_chatak = 'Lessa';
}
?>
<div class="container">
   <?php if(ENABLE_MODIFY_MAIN_APPLICANT == 1)
    { ?>
        <form id="ekyc_form" method="POST" action="https://basundhara.assam.gov.in/rtpsmb/AadhaarAuthentication/verifyAadhaar" target="ekyc_form">
            <input type="hidden" id="enc_data" name="enc_data" value="<?=$enc_case?>">
        </form> 
    <?php } ?>
   <div class="row">
      <?php if ($this->session->flashdata('success')) {?>
      <div class="success-msg">
         <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
         </div>
      </div>
      <?php }?>
      <?php if ($this->session->flashdata('error')) {?>
      <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <b><?php echo $this->session->flashdata('error') ?></b>
         <br>
         <b><?php echo $this->session->flashdata('error_code') ?></b>
      </div>
      <?php }?>

      <?php
        if($basic['old_case_no'] != null){
        ?>
        <div class="row text-right">
        <a href="<?=base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $basic['old_case_no'])?>" target="Old Application" class="text-danger">
            <span class="round-tab">
            <strong>View Old Application</strong>
            </span>
        </a>
        </div>
  
        <?php }?>

      <section>
         <div class="wizard">
            <div class="wizard-inner">
               <div class="connecting-line"></div>
               <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                  <li role="presentation" class="active">
                     <a
                        class="test"
                        href="#step1"
                        data-toggle="tab"
                        aria-controls="step1"
                        role="tab"
                        title="Step 1"
                        >
                     <span class="round-tab">
                     <strong>Application</strong>
                     </span>
                     </a>
                  </li>
                  <li role="presentation">
                     <a
                        href="#step2"
                        data-toggle="tab"
                        aria-controls="step2"
                        role="tab"
                        title="Step 2"
                        >
                     <span class="round-tab">
                     <strong>LRA</strong>
                     </span>
                     </a>
                  </li>
                  <li role="presentation">
                     <a
                        href="#step3"
                        data-toggle="tab"
                        aria-controls="step3"
                        role="tab"
                        title="Step 3"
                        >
                     <span class="round-tab">
                     <strong>Proceedings</strong>
                     </span>
                     </a>
                  </li>
                  <li role="presentation">
                     <a href="#history" data-toggle="tab" aria-controls="history" role="tab" title="history">
                     <span class="round-tab"><strong>History</strong></span>
                     </a>
                  </li>
               </ul>
            </div>
            <form role="form" method="post" action="<?php echo base_url() ?>index.php/SettlementTenantUrban/secondProceeding?case=<?=$_GET['case']?>" enctype="multipart/form-data">

                <?php
                    $case_no = $this->utilityclass->decryptJwtCase($_GET['case']);
                ?>
               <input type="hidden" name="service_code" value="<?=$basic["service_code"]?>">
               <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
               <input type="hidden" id="application_no" name="application_no" value="<?=$case_no?>">
               <?php
                    $sl_count = 1;
                ?>
               <div class="tab-content">
                  <div class="tab-pane active" role="tabpanel" id="step1">
                     <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$case_no?></span> )
                     </h5>
                     <div class="reza-card">
                     <div id="additionalErrors" class="text-right px-4 mt-2" style="cursor:pointer;">
                        <?php
                           if(isset($all_errors)){?>
                        <span class="text-danger">
                        <i id="blink" class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>
                        Check errors
                        </span>
                        <?php }?>
                     </div>
                     <div id="additional_errors_collapse" style="display: none;">
                        <?php
                           if(isset($all_errors)){?>
                        <div class="alert alert-warning">
                           <b>
                           <?=$all_errors;?>
                           </b>
                        </div>
                        <?php
                           }
                           ?>
                     </div>
                        <div class="reza-body">
                           <!--- Application Details starts here --->
                           <?=$dagFlagCheckChitha?>
                           <h5 class="reza-title" style="margin-top: 7px">
                              <i class="fa fa-file-text"></i>  Application Details
                           </h5>
                           <div class="tableCard">
                              <div class="row justify-content-center">
                                 <?php if (isset($base64_decoded_adhar_file)) {?>
                                 <div class="col-md-2">
                                    <?=$base64_decoded_adhar_file;?>
                                 </div>
                                 <?php }?>
                                 <div class="col-md-10">
                                    <table class="table table-bordered">
                                       <tr>
                                          <th>
                                             Name in <?=$aadhar[0]->identity_type?>
                                          </th>
                                          <td>
                                             <input type="text" value="<?=$aadhar[0]->eng_pdar_name?>" class="form-control" readonly>
                                          </td>
                                       </tr>
                                       <tr>
                                          <th><?=$aadhar[0]->identity_type?> Verified</th>
                                          <td>
                                             <input type="text" name="aadhar_verified" value="<?php if ($aadhar[0]->identity_type != null) {echo 'Yes';}?>" class="form-control" disabled>
                                          </td>
                                       </tr>
                                       <?php
                                            if ($basic == true) {?>
                                       <tr>
                                          <th>Occupation or Profession of the applicant</th>
                                          <td>
                                             <input type="text" readonly name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" id="occupation_applicant" class="form-control">
                                          </td>
                                       </tr>
                                       <tr>
                                          <th>Caste</th>
                                          <td>
                                             <input type="hidden" name="caste" value="<?=$basic['caste']?>" class="form-control">
                                             <input readonly type="text" name="" id="caste_name" value="<?php
                                                foreach (json_decode(CASTE) as $caste) {
                                                    if ($caste->CODE == $basic['caste']) {
                                                        echo $caste->NAME;
                                                    }
                                                }
                                                    ?>" class="form-control">
                                          </td>
                                       </tr>
                                       <?php
                                        if ($basic['protected_class']):
                                            ?>
                                       <tr>
                                          <th>Select if you fall under protected category?</th>
                                          <td>
                                             <select name="protected_class" id="protected_class" class="form-control">
                                                <?php
                                                foreach (json_decode(PROTECTED_CLASS) as $class) {
                                                        ?>
                                                <option value="<?=$class->CODE?>" <?php if ($class->CODE == $basic['protected_class']) {echo "selected";}?>><?=$class->NAME?></option>
                                                <?php }?>
                                             </select>
                                          </td>
                                       </tr>
                                       <?php endif;?>
                                       <tr>
                                          <th>Whether land prayed for is within tribal belt/block ?</th>
                                          <td>
                                             <select name="tribal_belt" id="" class="form-control" disabled>
                                                <option value="YES" <?php if ($basic['tribal_belt'] == 'YES') {echo "selected";}?>>Yes</option>
                                                <option value="NO" <?php if ($basic['tribal_belt'] == 'NO') {echo "selected";}?>>No</option>
                                             </select>
                                          </td>
                                       </tr>
                                       <?php }?>
                                       <tr>
                                          <th>Possession Since</th>
                                          <td>
                                             <input type="text" readonly name="period_possession" class="form-control" value="<?=$basic["period_possession"]?>">
                                          </td>
                                       </tr>
                                       <tr>
                                          <th>Total Applications applied by this applicant</th>
                                          <td>
                                             <span>
                                             <a type="button" target="_blank" class="btn buttInfo"
                                                href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$application_no?>">
                                             <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View now</small>
                                             </a>
                                             </span>
                                          </td>
                                       </tr>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <!--- Location Details starts here --->
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-map-marker"></i> Location Details
                           </h5>
                           <div class="tableCard ">
                              <table class="table table-bordered">
                                 <tr>
                                    <th>District Name:</th>
                                    <td class="text-warning">
                                       <strong class="alert-warning">
                                       <input type="text" name="dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($basic["dist_code"])?>' readonly>
                                       <input type="hidden" name="dist_code" value="<?=$basic["dist_code"];?>">
                                       </strong>
                                    </td>
                                    <th>Subdivision Name:</th>
                                    <td class="text-warning">
                                       <strong class="alert-warning">
                                       <input type="text" name="subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($basic["dist_code"], $basic["subdiv_code"])?>' readonly>
                                       <input type="hidden" name="subdiv_code" value="<?=$basic["subdiv_code"];?>">
                                       </strong>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Circle Name: </th>
                                    <td class="text-warning">
                                       <strong class="alert-warning">
                                       <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?>' class="form-control input-sm" readonly>
                                       <input type="hidden" name="cir_code" value="<?=$basic["cir_code"];?>">
                                       </strong>
                                    </td>
                                    <th>Mouza Name: </th>
                                    <td class="text-warning">
                                       <strong class="alert-warning">
                                       <input type="text" name="mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?>' readonly>
                                       <input type="hidden" name="mouza_pargona_code" value="<?=$basic["mouza_pargona_code"];?>">
                                       </strong>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Village Name: </th>
                                    <td class="text-warning">
                                       <strong class="alert-warning">
                                       <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?>' class="form-control input-sm" readonly>
                                       <input type="hidden" name="vill_townprt_code" value="<?=$basic["vill_townprt_code"];?>">
                                       </strong>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                           <!--- Location Details ends here //////////////////////////////--->
                           <!--- Self declaration Details starts here --->
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-pencil-square-o"></i> Self declaration details
                           </h5>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <?php
                                    foreach ($selfDeclarationDetails[0] as $key => $self) {
                                        //echo "<tr><th>". $self->name ."</th><td>:". $key=='0'?'No':'Yes' ."</td></tr>";
                                        ?>
                                 <tr>
                                    <th><?=$self->name?></th>
                                    <td>
                                       <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="Yes" <?php if ($self->status == "1") {echo "checked";}?> readonly>
                                       <label for="Yes">Yes</label>
                                       <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="No" <?php if ($self->status == "0") {echo "checked";}?> readonly>
                                       <label for="Yes">No</label>
                                    </td>
                                 </tr>
                                 <?php }?>
                              </table>
                           </div>
                           <!--- Self declaration Details starts here //////////////////////////////--->
                           <!--- Applicant starts here --->
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-user"></i>  Applicant details
                           </h5>

                           <?php if(ENABLE_TENANT_ADD_APPLICANT_BUTTON != 0) { ?>

                              <button type="button" onclick="openTenantApplicant();" class="btn btn-sm btn-danger"><strong>Click to Add New Applicant Detail</strong></button>

                            <?php }  ?>

                           <?php if(ENABLE_MODIFY_MAIN_APPLICANT==1 && !(isset($ekyc_data)) && isset($deceased) && $deceased != 0) { ?>

                               <button type="button" class="btn btn-sm btn-danger btnChangeMainApplicant"><i class="fa fa-user"></i>&nbsp;Change to Main Applicant</button>

                               <input type="hidden" value="<?=base_url()?>" id="baseurl">

                               <input type="hidden" value="<?=$basic["service_code"]?>" id="scode">

                               <script src="<?php echo base_url().'js/mb2/changeApplicant.js'?>"></script>

                           <?php } ?>

                           
                           <?php if (ENABLE_APPLICANT_BUTTON != 0) {?>
                           <button type="button" onclick="openApplicant();" class="btn btn-sm btn-danger"><strong>Click to Add New Applicant Detail</strong></button>
                           <?php }
                            $i = 1;foreach ($applicants_buyers as $settlement): ?>
                           <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
                           <div class="tableCard" id='applicantData'>
                              <table class="table" id="appRow<?=$settlement->id?>">
                                 <tr>
                                    <th rowspan="6" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                                    <th>Applicant Name (Assamese)</th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" id="pdar_name<?=$settlement->id?>" value="<?=$settlement->pdar_name?>">
                                    </td>
                                    <th>Guardian Name (Assamese)</th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" id="pdar_guardian<?=$settlement->id?>" value="<?=$settlement->pdar_guardian?>">
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Applicant Name (English)</th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" value="<?=$settlement->eng_pdar_name?>" id="eng_pdar_name<?=$settlement->id?>">
                                    </td>
                                    <th>Guardian Name (English)</th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" id="eng_pdar_guardian<?=$settlement->id?>" value="<?=$settlement->eng_pdar_guardian?>">
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Relation</th>
                                    <td>
                                       <select id="pdar_rel_guar<?=$settlement->id?>" class="form-control select-sm" disabled>
                                          <option value="">Select</option>
                                          <?php foreach ($guar_rel as $guar_rel_list) {
                                                ?>
                                          <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $settlement->pdar_rel_guar) {echo "selected";}?>>
                                             <?=$guar_rel_list->guard_rel_desc_as?>
                                          </option>
                                          <?php }?>
                                       </select>
                                    </td>
                                    <th>Gender</th>
                                    <td>
                                       <select disabled class="form-control" id="pdar_gender<?=$settlement->id?>">
                                          <option value="">Select...</option>
                                          <option value="1" <?php if ($settlement->pdar_gender == "1") {echo "selected";}?>>Male</option>
                                          <option value="2" <?php if ($settlement->pdar_gender == "2") {echo "selected";}?>>Female</option>
                                          <option value="3" <?php if ($settlement->pdar_gender == "3") {echo "selected";}?>>Others</option>
                                       </select>
                                    </td>
                                 <tr>
                                    <th>DOB</th>
                                    <td>
                                       <input type="text" readonly id="dob<?=$settlement->id?>" name="dob<?=$settlement->id?>" value="<?=$settlement->dob;?>" class="form-control input-sm hasDatepick" >
                                    </td>
                                    <?php if ($settlement->is_applicant == 1): ?>
                                    <th>Marital Status</th>
                                    <td>
                                       <select class="form-control" disabled id="marital_status<?=$settlement->id?>">
                                          <option value="">Select...</option>
                                          <?php
                                            foreach (json_decode(MARITAL_STATUS) as $marital_stat) {
                                                ?>
                                          <option value="<?=$marital_stat->CODE?>" <?php if ($marital_stat->CODE == $settlement->marital_status) {echo "selected";}?>>
                                             <?=$marital_stat->NAME?>
                                          </option>
                                          <?php
                                            }
                                            ?>
                                       </select>
                                    </td>
                                    <?php endif;?>
                                 </tr>
                                 <tr>
                                    <th>Mobile</th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile?>">
                                    </td>
                                    <th>
                                       Permanent address
                                    </th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" id="pdar_add1<?=$settlement->id?>" value="<?=$settlement->pdar_add1?>">
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Present address</th>
                                    <td>
                                       <input type="text" readonly class="form-control input-sm" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2?>">
                                    </td>

                                    
                                    <th>Select if this applicant is eligible for patta?</th>
                                    <td>
                                        <select name="applicant_eligibility<?=$settlement->id?>" class="form-control <?php if(form_error('applicant_eligibility'.$settlement->id)){echo 'is-invalid';}?>" id="">
                                        <?php
                                        if($settlement->is_applicant == 1)
                                        {
                                            ?>
                                                <option value="1">Eligible</option>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <option value="">Select...</option>
                                                <option value="1" <?php if(isset($err_return)){ if(set_value('applicant_eligibility'.$settlement->id) == '1'){ echo 'selected';} }else { if($settlement->applicant_eligibility == '1'){ echo 'selected';} } ?>>Eligible</option>
                                                <option value="2" <?php if(isset($err_return)){ if(set_value('applicant_eligibility'.$settlement->id) == '2'){ echo 'selected';} }else{ if($settlement->applicant_eligibility == '2'){ echo 'selected';} } ?>>Not Eligible</option>
                                            <?php
                                        }
                                        ?>

                                        </select>
                                        <?=form_error('applicant_eligibility'.$settlement->id)?>
                                    </td>
                                   
                                 </tr>
                                 <tr>
                                    <td colspan="2" style="vertical-align : middle;text-align:center;">
                                       <?php if (ENABLE_APPLICANT_BUTTON != 0) {?>
                                       <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>
                                       <?php if ($settlement->is_applicant != 1) {?>
                                       <button type="button" onclick="confirmDeleteApplicant(<?=$settlement->id?>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i><strong>Delete</strong></button>
                                       <?php }}?>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                           <?php $i++;endforeach;?>
                           <!--- Land Owner Details starts here --->
                           <?php if (!empty($owners)) {?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-user-secret"></i> Land Owner Details
                           </h5>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <?php
                                    $i = 1;foreach ($owners as $owners_details) {?>
                                 <tr>
                                    <th rowspan="2"><?=$i?></th>
                                    <th>Name</th>
                                    <td colspan="2">
                                       <input type="text" readonly name="owners_name<?=$owners_details->id?>" value="<?php echo $owners_details->pdar_name; ?>" class="form-control input-sm <?php if (form_error('owners_name' . $owners_details->id)) {echo 'is-invalid';}?>">
                                       <?=form_error('owners_name' . $owners_details->id)?>
                                    </td>
                                    <th>Father's name</th>
                                    <td colspan="2">
                                       <input type="text" readonly name="owners_guardian<?=$owners_details->id?>" value="<?php echo $owners_details->pdar_guardian; ?>" class="form-control input-sm <?php if (form_error('owners_guardian' . $owners_details->id)) {echo 'is-invalid';}?>" >
                                       <?=form_error('owners_guardian' . $owners_details->id)?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th> Mobile No.</th>
                                    <td colspan="2">
                                       <input type="text" readonly class="form-control <?php if (form_error('owners_mobile_number' . $owners_details->id)) {echo 'is-invalid';}?>" name="owners_mobile_number<?=$owners_details->id?>" value="<?php if ($owners_details->pdar_mobile == '' || $owners_details->pdar_mobile == null || $owners_details->pdar_mobile == 'NA' || $owners_details->pdar_mobile == 'na' || $owners_details->pdar_mobile == '-1') {echo 'NA';} else {echo $owners_details->pdar_mobile;}?>">
                                       <?=form_error('owners_mobile_number' . $owners_details->id)?>
                                    </td>
                                    <th>In place/Along with</th>
                                    <input type="hidden" name="owners_pdar_id<?=$owners_details->id?>" value="<?php echo $owners_details->id; ?>">
                                    <input type="hidden" name="owners_pdar_type<?=$owners_details->id?>" value="O">
                                    <td colspan="2">
                                       <select name="owners_in_place<?=$owners_details->id?>" id="" class="inplace-along input_editable_background form-control <?php if (form_error('owners_in_place' . $owners_details->id)) {echo 'is-invalid';}?>" required>
                                          <option value="">Select...</option>
                                          <option value="i" <?php if (isset($err_return)) {if (set_value('owners_in_place' . $owners_details->id) == "i") {echo "selected";}}else{ if(trim($owners_details->inplace_alongwith) == "i"){echo "selected";}}?>>In Place</option>
                                          <option value="a" <?php if (isset($err_return)) {if (set_value('owners_in_place' . $owners_details->id) == "a") {echo "selected";}}else{ if(trim($owners_details->inplace_alongwith) == "a"){echo "selected";}}?>>Along with</option>
                                       </select>
                                       <?=form_error('owners_in_place' . $owners_details->id)?>
                                    </td>
                                 </tr>
                                 <?php $i++;}?>
                              </table>
                           </div>
                           <?php }?>
                           <!--- Land Owner Details ends here  //////////////////////////////--->
                           <!--- Bhumiputra Details starts here --->
                           <?php if ($basic["bhumiputra_certificate_no"]) {?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                           </h5>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <tr>
                                    <th>Bhumiputra Certificate/Ack verified?</th>
                                    <td align="center">
                                       <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="YES" <?php if (trim($basic['bhumiputra_confirmation']) == YES) {echo "checked";}?>>
                                       <label for="bhumi_confirmation">Yes</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="NO" <?php if (trim($basic['bhumiputra_confirmation']) == NO) {echo "checked";}?>>
                                       <label for="bhumi_confirmation">No</label>
                                    </td>
                                    <td>
                                       <input type="hidden" name="bhumiputra_certificate_type" value="<?php
                                        if ($basic["bhumiputra_certificate_no"] == BHUMI_CERT) {
                                            echo BHUMI_CERT;
                                        } elseif ($basic["bhumiputra_certificate_no"] == BHUMI_ACK) {
                                            echo BHUMI_ACK;
                                        }
                                            ?>">
                                       <input type="hidden" name="bhumiputra_certificate_no" value="<?=$basic["bhumiputra_certificate_no"]?>">
                                       Certificate/Ack number : <b><?=$basic["bhumiputra_certificate_no"]?></b>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                           <?php }?>
                           <!--- Bhumiputra Details ends here  //////////////////////////////--->
                           <?php if ($applicants_encroacher == true) {?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-user-secret"></i>  Rayytee Details
                           </h5>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <?php
                                    foreach ($applicants_encroacher as $riotee) {
                                        ?>
                                 <tr>
                                    <th>Khatian Number</th>
                                    <td colspan="2">
                                       <input type="text" name="khatian_no" id="khatian_no_id" value="<?php if(isset($err_return)){echo set_value('khatian_no');}else{ echo $riotee->khatian_no; }?>" class="form-control input-sm <?php if(form_error('khatian_no')){echo 'is-invalid';}?>" readonly>
                                       <?=form_error('khatian_no')?>
                                    </td>
                                    <th>Name</th>
                                    <td colspan="2">
                                       <input type="text" name="riotee_name" value="<?php if(isset($err_return)){ echo set_value('riotee_name'); }else{ echo $riotee->pdar_name;}?>" class="form-control input-sm <?php if(form_error('riotee_name')){echo 'is-invalid';}?>" id="tenant_name_id" readonly>
                                       <?=form_error('riotee_name')?>
                                    </td>
                                    <th>Father's name</th>
                                    <td colspan="2">
                                       <input type="text" name="riotee_guardian" value="<?php if(isset($err_return)){ echo set_value('riotee_guardian');}else{ echo $riotee->pdar_guardian;}?>" class="form-control input-sm <?php if(form_error('riotee_guardian')){echo 'is-invalid';}?>" id="tenants_father_id" readonly>
                                       <?=form_error('riotee_guardian')?>
                                    </td>
                                    <?php if(ENABLE_BUTTON_CHANGE_ENCROACHER != 0){?>
                                    <td rowspan="2" style="vertical-align : middle;text-align:center;">
                                        <button type="button" class="rezaButt btn-warning" id="<?=$riotee->dag_no;?>"
                                        onclick="encroacherModal(<?=$riotee->riotee_id;?>, <?=$riotee->dag_no?>, '<?=$riotee->dist_code?>', '<?=$riotee->subdiv_code?>', '<?=$riotee->cir_code?>', '<?=$riotee->mouza_pargona_code?>', '<?=$riotee->lot_no?>', '<?=$riotee->vill_townprt_code?>');" > Change Rayyatee </button>
                                    </td>
                                    <?php } ?>
                                 </tr>
                                 <?php
                                    }
                                        ?>
                              </table>
                           </div>
                           <?php }?>
                           <?php if ($applicants_riotee_nok == true) {?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-user-plus"></i>  Riotee's NOK(This would be added to the Riotee khatian)
                           </h5>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <?php
                                    foreach ($applicants_riotee_nok as $riotee_nok) {
                                        ?>
                                 <tr>
                                    <th>Khatian Number</th>
                                    <td colspan="2">
                                       <input type="text" readonly name="riotee_nok_khatian_no<?=$riotee_nok->id?>" value="<?php if(isset($err_return)){echo set_value('riotee_nok_khatian_no'.$riotee_nok->id);}else{echo $riotee->khatian_no;}?>" class="riotee_nok_khatian_no form-control input-sm">
                                    </td>
                                    <th>Name</th>
                                    <td colspan="2">
                                       <input type="text" readonly name="riotee_nok_name<?=$riotee_nok->id?>" value="<?php 
                                       if(isset($err_return)){ echo set_value('riotee_nok_name'.$riotee_nok->id);}else{echo $riotee_nok->pdar_name;}?>" class="form-control input-sm">
                                    </td>
                                    <th>Father's name</th>
                                    <td colspan="2">
                                       <input type="text" readonly name="riotee_nok_guardian<?=$riotee_nok->id?>" value="<?php if(isset($err_return)){echo set_value('riotee_nok_guardian'.$riotee_nok->id);}else{ echo $riotee_nok->pdar_guardian;}?>" class="form-control input-sm" >
                                    </td>
                                    <th>Relationship with Riotee</th>
                                    <td colspan="2">
                                       <?php
                                        if ($riotee_nok->pdar_type == 'P') {
                                                ?>
                                       <input type="hidden" name="riotee_nok_relation<?=$riotee_nok->id?>" value="#">
                                       <input type="text" readonly name="pdar_riotee_nok<?=$riotee_nok->id?>" value="Son" class="form-control input-sm" >
                                       <?php
                                        } elseif ($riotee_nok->pdar_type == 'GP') {
                                                ?>
                                       <input type="hidden" name="riotee_nok_relation<?=$riotee_nok->id?>" value="#">
                                       <input type="text" readonly name="pdar_riotee_nok<?=$riotee_nok->id?>" value="Grand Son/ Daughter" class="form-control input-sm" >
                                       <?php
                                        } elseif ($riotee_nok->pdar_type == 'GGP') {
                                                ?>
                                       <input type="hidden" name="riotee_nok_relation<?=$riotee_nok->id?>" value="#">
                                       <input type="text" readonly name="pdar_riotee_nok<?=$riotee_nok->id?>" value="Great Grand Son/ Daughter" class="form-control input-sm" >
                                       <?php
                                        }
                                            ?>
                                    </td>
                                 </tr>
                                 <?php
                                    }
                                        ?>
                              </table>
                           </div>
                           <?php }?>
                           <!--- Area Details starts here --->
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-map"></i>  Area Details
                           </h5>
                           <div class="tableCard">
                              <div class="card-text alternate-table-color">
                                 <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                                    class="<?php if (form_error('totalAppliedAdditionalArea')) {echo 'is-invalid';}?>">
                                    <?=form_error('totalAppliedAdditionalArea');?>
                                 </div>
                                 <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                                    class="<?php if (form_error('totalAppliedAreaInUrban')) {echo 'is-invalid';}?>">
                                    <?=form_error('totalAppliedAreaInUrban');?>
                                 </div>
                                 <table class="table">
                                    <thead class="thead-warning">
                                       <tr>
                                          <th>#</th>
                                          <th>Description</th>
                                          <th class="text-center">Bigha</th>
                                          <th class="text-center">Katha</th>
                                          <th class="text-center"><?=$lessa_chatak?></th>
                                          <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                          <th class="text-center">Ganda</th>
                                          <th class="text-center">Kranti</th>
                                          <?php endif;?>
                                       </tr>
                                       <?php
                                        $i = 1;
                                        foreach ($dags as $dags_details) {

                                            $applId = $this->utilityclass->getApplidFromCaseNo($dags_details->case_no);
                                            ?>
                                       <input type="hidden" name="is_urban" id="urbanCheck<?=$dags_details->dag_no?>" value="<?=$dags_details->is_urban?>">
                                       <tr class="bg-white">
                                          <th rowspan="6" style="vertical-align : middle;">
                                             <div class="vertical">
                                                DAG : <span class="text-danger"><?=$dags_details->dag_no?></span> |
                                                PATTA : <span class="text-danger"><?=$dags_details->patta_no?> | <?=$this->utilityclass->getPattaType($dags_details->patta_type_code)?></span>
                                                <input type="hidden" name="dag_no" value='<?=$dags_details->dag_no?>' class="form-control input-sm" readonly>
                                                <input type="hidden" name="patta_no" id="patta_no" class="form-control input-sm" value='<?=$dags_details->patta_no;?>' readonly>
                                                <input type="hidden" name="patta_type_code" value='<?=$dags_details->patta_type_code?>' class="form-control input-sm" >
                                                <input type="hidden" name="patta_type_code_display" value='<?=$this->utilityclass->getPattaType($dags_details->patta_type_code)?>' class="form-control input-sm" readonly>
                                             </div>
                                          </th>
                                          <td><strong>Total Land Area in Selected Dag</strong></td>
                                          <td style="text-align: center;">
                                             <strong>
                                             <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags_details->dag_area_b?>" readonly id="dag_area_b">
                                             </strong>
                                          </td>
                                          <td style="text-align: center;">
                                             <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags_details->dag_area_k?>" class="form-control input-sm" readonly id="dag_area_k">
                                          </td>
                                          <td style="text-align: center;">
                                             <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags_details->dag_area_lc?>" readonly id="dag_area_lc">
                                          </td>
                                          <?php if ((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                          <td style="text-align: center;">
                                             <input type="text" style="text-align: center;" value="<?=$dags_details->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly id="dag_area_g">
                                          </td>
                                          <td style="text-align: center;">
                                             <input type="text" style="text-align: center;" value="<?=$dags_details->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly id="dag_area_kr">
                                          </td>
                                          <?php endif;?>
                                       </tr>
                                       <!-- Area for Settlement -->
                                       <tr class="bg-white">
                                          <td class="settlement-area-color">
                                             <strong class="text-danger">Area for Settlement</strong>
                                             <span class="<?php if (form_error('appAreaLessaValidation') || form_error('appAreaMoreThanDagA')) {echo 'is-invalid';}?>"></span>
                                             <?=form_error('appAreaLessaValidation');?>
                                             <?=form_error('appAreaMoreThanDagA');?>
                                          </td>
                                          <td class="settlement-area-color" style="text-align: center;">
                                             <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_b" id="s_dag_area_b" class="form-control input_editable_background input-sm s_dag_area_b <?php if (form_error('s_dag_area_b')) {echo 'is-invalid';}?>" value="<?php if (isset($err_return)) {echo set_value('s_dag_area_b');} else {echo $dags_details->s_dag_area_b;}?>" >
                                             <?=form_error('s_dag_area_b')?>
                                          </td>
                                          <td class="settlement-area-color" style="text-align: center;">
                                             <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_k" id="s_dag_area_k" value="<?php if (isset($err_return)) {echo set_value('s_dag_area_k');} else {echo $dags_details->s_dag_area_k;}?>" class="form-control input_editable_background input-sm s_dag_area_k <?php if (form_error('s_dag_area_k')) {echo 'is-invalid';}?>" >
                                             <?=form_error('s_dag_area_k')?>
                                          </td>
                                          <td class="settlement-area-color" style="text-align: center;">
                                             <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_lc" id="s_dag_area_lc" class="form-control input_editable_background input-sm s_dag_area_lc <?php if (form_error('s_dag_area_lc')) {echo 'is-invalid';}?>" value="<?php if (isset($err_return)) {echo set_value('s_dag_area_lc');} else {echo $dags_details->s_dag_area_lc;}?>" >
                                             <?=form_error('s_dag_area_lc')?>
                                          </td>
                                          <?php if ((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                          <td class="settlement-area-color" style="text-align: center;">
                                             <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if (isset($err_return)) {echo set_value('s_dag_area_g');} else {echo $dags_details->s_dag_area_g;}?>" class="form-control input_editable_background input-sm s_dag_area_g <?php if (form_error('s_dag_area_g')) {echo 'is-invalid';}?>" name="s_dag_area_g" id="s_dag_area_g" >
                                             <?=form_error('s_dag_area_g')?>
                                          </td>
                                          <td class="settlement-area-color" style="text-align: center;">
                                             <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if (isset($err_return)) {echo set_value('s_dag_area_kr');} else {echo $dags_details->s_dag_area_kr;}?>" class="form-control input_editable_background input-sm s_dag_area_kr <?php if (form_error('s_dag_area_kr')) {echo 'is-invalid';}?>" name="s_dag_area_kr"  id="s_dag_area_kr">
                                             <?=form_error('s_dag_area_kr')?>
                                          </td>
                                          <?php endif;?>
                                          <?php if ((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))) {?>
                                          <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
                                          <?php } else {?>
                                          <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
                                          <?php }?>
                                       </tr>
                                       <?php if ((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))) {?>
                                       <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
                                       <?php } else {?>
                                       <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
                                       <?php }?>
                                       <tr class="bg-white">
                                          <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                                             <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$applId;?>&dag=<?=$dags_details->dag_no;?>">
                                             <small style="font-size:14px; color:white; font-weight:bold"><i class="fa fa-eye"></i> View Total Applications in this Dag</small>
                                             </a>
                                          </td>
                                       </tr>
                                       <?php $i++;}?>
                                    </thead>
                                 </table>
                              </div>
                           </div>
                           <!--- Area Details ends here  //////////////////////////////--->
                           <?php if ($nextKin) {?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-users"></i>  Family Details
                           </h5>
                           <div class="tableCard">
                              <table class="table  table-bordered">
                                 <tr>
                                    <th>Nominee name</th>
                                    <th>Relation with Applicant</th>
                                    <th>Address of nominee</th>
                                    <th>Mobile number</th>
                                 </tr>
                                 <?php $i = 1;foreach ($nextKin as $kin): ?>
                                 <tr>
                                    <td>
                                       <input type="text" id="kin_name" name="kin_name" value="<?=$kin->next_of_kin_name?>" class="form-control">
                                    </td>
                                    <td>
                                       <input type="text" name="kin_relation" value="<?=$kin->relation_with_kin?>" class="form-control">
                                    </td>
                                    <td>
                                       <input type="text" class="form-control" value="<?=$kin->address?>" name="kin_address">
                                    </td>
                                    <td>
                                       <input type="text" name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control">
                                    </td>
                                 </tr>
                                 <?php $i++;?>
                                 <?php endforeach;?>
                              </table>
                           </div>
                           <?php }?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-file-pdf-o"></i> Supporting Documents
                           </h5>
                           <div class="tableCard">
                              <table class="table  table-bordered">
                                 <?php foreach ($document as $d): ?>
                                 <tr>
                                    <th>
                                       <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                       <input type="hidden" name="case_no" id="case_no" value="<?=$case_no;?>">
                                       <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                       <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                       <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                       <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                       <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                                    </th>
                                 </tr>
                                 <?php endforeach;?>
                              </table>
                           </div>
                           <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->

                           <?php
                              include(APPPATH."views/SettlementView/include/nrcFileUpload.php");
                           ?>

                        </div>
                     </div>
                     <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                           <button type="button" class="btn btn-primary next-step">
                           <i class="fa fa-arrow-circle-right"> </i>  Next
                           </button>
                        </li>
                     </ul>
                  </div>
                  <!-- LM reporting starts here -->
                  <div class="tab-pane" role="tabpanel" id="step2">
                     <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$case_no?></span> )
                     </h5>
                     <div class="card">
                        <div class="card-body ">
                            <?=$dagFlagCheckChitha?>
                           <h5  class="reza-title">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Previous Remark
                           </h5>
                           <?php if ($proceedings) {?>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <tr>
                                    <th>Date of remark</th>
                                    <th>Remark from</th>
                                    <th>Remark</th>
                                 </tr>
                                 <?php
                                    $i = 1;
                                        foreach ($proceedings as $pro):
                                            if ($i == 1) {
                                                ?>
	                                 <tr>
                                     <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
	                                    <td><?=$pro->office_from;?></td>
	                                    <td><span><?=$pro->note_on_order;?></span></td>
	                                 </tr>
	                                 <?php }
                                     $i++;endforeach;?>
                              </table>
                           </div>
                           <?php }?>
                           <?php $i = 1;foreach ($lmnotes as $lmnote): ?>
                           <h5  class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
                           </h5>
                           <div class="tableCard">
                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong>Chitha verified and found the applicant as a pattadar ?</span>
                                        <?=form_error('chitha_verified')?>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if (form_error('chitha_verified')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="chitha_verified"
                                            id="chiitha_verified1"
                                            value="YES" 
                                            <?php 
                                            if(isset($err_return)){ if(set_value('chitha_verified') == YES){echo "checked";}}else{if ($lmnote->chitha_verified == "YES") {echo "checked";}}
                                            ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if (form_error('chitha_verified')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="chitha_verified"
                                            id="chiitha_verified2"
                                            value="NO" 
                                            <?php 
                                            if(isset($err_return)){ if(set_value('chitha_verified') == NO){echo "checked";}}else{if ($lmnote->chitha_verified == "NO") {echo "checked";}}
                                            ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fa fa-link" aria-hidden="true"></i>
                                        <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $aadhar[0]->dag_no . '&m=' . $app['mouza_pargona_code'] . '&l=' . $app['lot_no'] . '&v=' . $app['vill_townprt_code'] . '&p=' . $aadhar[0]->patta_type_code . '&dist=' . $app['dist_code'] . '&cir=' . $app['cir_code'] . '&sub_div=' . $app['subdiv_code'] ?>">
                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$aadhar[0]->dag_no?> (Chitha)</span></u>
                                        </a>
                                        <br>
                                    </div>
                                </div>
                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span>
                                        <strong><?=$sl_count++?>.</strong> RAIOTEE KHATIAN verified and found applicant predecessors is a recorded occupancy tenant?
                                        </span>
                                        <?=form_error('rk_verified')?>

                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if (form_error('rk_verified')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="rk_verified"
                                            id="rk_verified1"
                                            onclick="rk_already_exist();"
                                            value="YES" 
                                            <?php 
                                            if(isset($err_return)){ if(set_value('rk_verified') == YES){echo "checked";}}else{if ($lmnote->rk_verified == "YES") {echo "checked";}}
                                            ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if (form_error('rk_verified')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="rk_verified"
                                            onclick="rk_to_be_added();"
                                            id="rk_verified2"
                                            value="NO" 
                                            <?php 
                                            if(isset($err_return)){ if(set_value('rk_verified') == NO){echo "checked";}}else{ if ($lmnote->rk_verified == "NO") {echo "checked";}}
                                            ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fa fa-link" aria-hidden="true"></i>
                                        <a href="<?php echo base_url() . 'index.php/basundhara2/khatian?st=' . $chitha_tenant->khatian_no . '&end=' . $chitha_tenant->khatian_no . '&dist=' . $app['dist_code'] . '&cir_code=' . $app['cir_code'] . '&subdiv_code=' . $app['subdiv_code'] . '&mouza_code=' . $app['mouza_pargona_code'] . '&lot_no=' . $app['lot_no'] . '&village_code=' . $app['vill_townprt_code'] . '&patta_no=' . $aadhar[0]->patta_no . '&dag_no=' . $aadhar[0]->dag_no ?>" target="view_riotee">
                                        <button type="button" class="btn btn-sm btn-info text-white col-4">View</button>
                                        </a>
                                        <br>
                                    </div>
                                </div>
                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                                        <?=form_error('bhumiputra_confirmation_lm')?>

                                        <?php if ($basic['bhumiputra_certificate_no']) {?>
                                        <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>
                                        <?php } else {?>
                                        <label for="" class="alert-warning">Certificate Not Available!</b></label>
                                        <?php }?>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if (form_error('bhumiputra_confirmation_lm')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="bhumiputra_confirmation_lm"
                                            id="bhumiputra_confirmation1"
                                            value="YES"
                                            <?php 
                                            if(isset($err_return)){ if(set_value('bhumiputra_confirmation_lm') == YES){echo "checked";}}else{ if ($lmnote->bhumiputra_confirmation == "YES") {echo "checked";}}
                                            ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if (form_error('bhumiputra_confirmation_lm')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="bhumiputra_confirmation_lm"
                                            id="bhumiputra_confirmation2"
                                            value="NO"
                                            <?php 
                                            if(isset($err_return)){ if(set_value('bhumiputra_confirmation_lm') == NO){echo "checked";}}else{ if ($lmnote->bhumiputra_confirmation == "NO") {echo "checked";}}
                                            ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if ($basic['bhumiputra_certificate_no']) {?>

                                            <i class="fa fa-link" aria-hidden="true"></i>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommon/bhumiPutra?<?php
                                                if ($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT) {
                                                    echo "cer_number=" . $basic['bhumiputra_certificate_no'];
                                                } elseif ($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK) {
                                                    echo "ack_number=" . $basic['bhumiputra_certificate_no'];
                                                }?>" target="BhumiPutra">
                                            <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                            </a>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <span>
                                            <strong><?=$sl_count++?>.</strong> Verified schedule of the land and area under possession and found correct?
                                        </span>
                                        <?=form_error('possession_verification')?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if (form_error('possession_verification')) {echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="possession_verification"
                                                    id="inlineRadio1"
                                                    value="YES"
                                                    <?php
                                                    if(isset($err_return)){
                                                        if(set_value('possession_verification') == YES){
                                                            echo "checked";
                                                        }
                                                    }else{
                                                        if (trim($lmnote->possession_verification) == YES) {echo "checked";}
                                                    }?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if (form_error('possession_verification')) {echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="possession_verification"
                                                    id="inlineRadio2"
                                                    value="NO"
                                                    <?php
                                                    if(isset($err_return)){
                                                        if(set_value('possession_verification') == NO){
                                                            echo "checked";
                                                        }
                                                    }else{
                                                        if (trim($lmnote->possession_verification) == NO) {echo "checked";}
                                                    }?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2 " >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                        Tribal Belt/ Block.</span>
                                        <?=form_error('is_tribal_belt')?>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                            <input
                                            class="form-check-input <?php if(form_error('is_tribal_belt')){ echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="is_tribal_belt"
                                            id="whether_tribal1"
                                            onclick="handleTribalClick(this)"
                                            value="YES" <?php 
                                                if(isset($err_return)){
                                                    if(set_value('is_tribal_belt') == YES){
                                                        echo "checked";
                                                    }
                                                }else{
                                                    if (trim($lmnote->is_tribal_belt) == "YES") {echo "checked";}
                                                }?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                            class="form-check-input <?php if(form_error('is_tribal_belt')){ echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="is_tribal_belt"
                                            id="whether_tribal2"
                                            value="NO"
                                            onclick="handleTribalClick(this)"
                                            <?php 
                                                if(isset($err_return)){
                                                    if(set_value('is_tribal_belt') == NO){
                                                        echo "checked";
                                                    }
                                                }else{
                                                    if (trim($lmnote->is_tribal_belt) == NO) {echo "checked";}
                                                }?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="tribal_belt_input_id" style="display: none;">
                                        <input type="text" class="form-control <?php if(form_error('tribal_belt_name')){echo 'lm_invalid';}?>" name="tribal_belt_name" placeholder="Enter name of the Tribal belt block">

                                    </div>
                                </div>

                                <div class="row p-2 " id="protected_class_id" style="display: none;">
                                    <div class="col-md-6 text-justify">
                                        <span><strong><?=$sl_count++?>.</strong> Does the applicant falls under protected category as mentioned in that particular tribal belt/block and eligible under section 163(2)(a), 163(2)(b)</span>
                                        <?=form_error('protected_class_lm')?>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <select name="protected_class_lm" id="protected_class_lm" class="form-control <?php if(form_error('protected_class_lm')){ echo 'lm_invalid';}?>" required>
                                            <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                                            <option value="<?php echo $class->CODE ?>" <?php 
                                            if(isset($err_return)){ if(set_value('protected_class_lm') == $class->CODE){ echo "selected"; }}else{ if(trim($lmnote->protected_class_lm) == $class->CODE){echo "selected";}}?>>
                                            <?php echo $class->NAME ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row p-2" id="contravention" style="display: none;">
                                  <div class="col-md-6">
                                    <span><strong>-></strong>
                                    Whether the occupancy tenant right has been conferred in contravention of provisions of chapter 10?</span>
                                    <?=form_error('contravention')?>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                             type="radio"
                                             name="contravention"
                                             id="landed_property1"
                                             value="YES"
                                             <?php
                                                if(isset($err_return)){
                                                    if(set_value('contravention') == YES){
                                                        echo "checked";
                                                    }
                                                }else{
                                                    if (trim($lmnote->contravention) == YES) {echo "checked";}
                                                }?>
                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="contravention"
                                              id="landed_property2"
                                              value="NO"
                                              <?php
                                                if(isset($err_return)){
                                                    if(set_value('contravention') == NO){
                                                        echo "checked";
                                                    }
                                                }else{
                                                    if (trim($lmnote->contravention) == NO) {echo "checked";}
                                                }?>
                                      />
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong>
                                        Whether proposed land is under litigation?
                                    </span>
                                    <?=form_error('litigation')?>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input <?php if(form_error('litigation')){echo 'lm_invalid';}?>"
                                                type="radio"
                                                name="litigation"
                                                id="landed_property1"
                                                value="YES"
                                                <?php
                                                if(isset($err_return)){
                                                    if(set_value('litigation') == YES){
                                                        echo "checked";
                                                    }
                                                }else{
                                                    if (trim($lmnote->litigation) == YES) {echo "checked";}
                                                }?>
                                        />
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                                class="form-check-input <?php if(form_error('litigation')){echo 'lm_invalid';}?>"
                                                type="radio"
                                                name="litigation"
                                                id="landed_property2"
                                                value="NO"
                                                <?php
                                                if(isset($err_return)){
                                                    if(set_value('litigation') == NO){
                                                        echo "checked";
                                                    }
                                                }else{
                                                    if (trim($lmnote->litigation) == NO) {echo "checked";}
                                                }?>
                                        />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong> Whether applicant / applicant's predecessors continuosuly possessing the land since creation of occupancy tenant while the area is in rural area?
                                    </span>
                                        <?=form_error('cont_possessing')?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('cont_possessing')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="cont_possessing"
                                                    id="cont_possessing"
                                                    value=<?=YES?>
                                                    <?php
                                                    if(isset($err_return)){
                                                        if(set_value('cont_possessing') == YES){
                                                            echo "checked";
                                                        }
                                                    }else{
                                                        if (trim($lmnote->cont_possessing) == YES) {echo "checked";}
                                                    }?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('cont_possessing')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="cont_possessing"
                                                    id="cont_possessing"
                                                    value=<?=NO?>
                                                    <?php
                                                    if(isset($err_return)){
                                                        if(set_value('cont_possessing') == NO){
                                                            echo "checked";
                                                        }
                                                    }else{
                                                        if (trim($lmnote->cont_possessing) == NO) {echo "checked";}
                                                    }?>

                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row p-2">
                                    <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> Period of possession</span>
                                    <?=form_error('period_possession')?>

                                    </div>
                                    <div class="form-group col-md-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="inputEmail4">From Date</label>
                                        </div>
                                        <div class="col-8">
                                            <input
                                                class="form-control ymd <?php if(form_error('period_possession')){ echo 'lm_invalid';}?>"
                                                type="text"
                                                readonly
                                                name="period_possession_lm"
                                                id="period_possession"
                                                value="<?php 
                                                if(isset($err_return))
                                                {
                                                    echo set_value('period_possession');
                                                }
                                                else
                                                {
                                                    echo $lmnote->period_possession;
                                                }?>"
                                                />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Nature of possession </span>
                                        <?=form_error('nature_possession')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select name="nature_possession" onchange="naturePossessionOther(this)"  id="nature_possession" class="form-control <?php if(form_error('nature_possession')){echo 'lm_invalid';}?>">
                                                <option value="Agricultural" <?php if(isset($err_return)){ if (set_value('nature_possession') == "Agricultural") { echo "selected"; }}else{ if ($lmnote->nature_possession == "Agricultural") {echo "selected";} }?>>
                                                    Agricultural
                                                </option>
                                                <option value="Residential" <?php if(isset($err_return)){ if (set_value('nature_possession') == "Residential") { echo "selected"; }}else{ if ($lmnote->nature_possession == "Residential") {echo "selected";} }?>>
                                                    Residential
                                                </option>
                                                
                                                <option value="Commercial" <?php if(isset($err_return)){ if (set_value('nature_possession') == 'Commercial') { echo "selected"; }}else{ if ($lmnote->nature_possession == "Commercial") {echo "selected";} }?>>Commercial</option>

                                                <option value="Others" <?php if(isset($err_return)){ if (set_value('nature_possession') == "Others") { echo "selected"; }}else{ if ($lmnote->nature_possession == "Others") {echo "selected";} }?>>
                                                    Others
                                                </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row p-2"  style="display: none;" id="nature_possession_div_other">
                                    <div class="col-md-6">
                                        <span><strong>-></strong>
                                        Purpose of the land used by the occupants(if any other) </span>
                                        <?=form_error('land_used_by_occupants')?>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" name="land_used_by_occupants" id="nature_of_pos_id" value="<?php if(isset($err_return)){ echo set_value('land_used_by_occupants');}else{ echo $lmnote->land_used_by_occupants;}?>" class="form-control <?php if(form_error('land_used_by_occupants')){ echo 'lm_invalid';}?>" placeholder="Enter purpose of the land used by occupants">
                                    </div>
                                </div>
                                <div class="row p-2" >
                                    <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong>
                                    Check the land revenue details as fetch from the E-Khajana
                                    Database or check the Khajana receipt uploaded by applicant</span>
                                    <?=form_error('khajana_receipt')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if(form_error('khajana_receipt')){ echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="khajana_receipt"
                                            id="khajana_receipt1"
                                            value="YES"
                                            <?php if(isset($err_return)){ if(set_value('khajana_receipt') == YES){echo 'checked';} }else { if (trim($lmnote->e_khajana_receipt_check) == YES) {echo "checked";}} ?>

                                            />
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php if(form_error('khajana_receipt')){ echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="khajana_receipt"
                                            id="khajana_receipt2"
                                            value="NO"
                                            <?php if(isset($err_return)){ if(set_value('khajana_receipt') == NO){echo 'checked';} }else { if (trim($lmnote->e_khajana_receipt_check) == NO) {echo "checked";}} ?>
                                            />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                    </div>
                                </div>


                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          Date of notification vide which the area was included in town lands
                                      </span>
                                      <?=form_error('date_notification')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <input type="text" class="form-control <?php if(form_error('tenancy_record')){echo 'lm_invalid';}?>" name="date_notification" id="date_notification" readonly placeholder="Date of Notification"
                                       value="<?php if(isset($err_return)){ echo set_value('date_notification');}else{ echo $lmnote->date_notification;}?>" >
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          The year in which the tenancy records were created
                                      </span>
                                      <?=form_error('tenancy_record')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <input type="text" class="form-control <?php if(form_error('tenancy_record')){echo 'lm_invalid';}?>" name="tenancy_record" id="tenancy_record" placeholder="The year in which the tenancy records were created" value="<?php if(isset($err_return)){ echo set_value('tenancy_record');}else{ echo $lmnote->tenancy_record;}?>" readonly>
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          Whether applicant(s) have been in continuous possession from the year of creation of the tenancy records ?
                                      </span>
                                      <?=form_error('cont_possession')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-check form-check-inline">
                                             <input
                                                class="form-check-input <?php if(form_error('cont_possession')){echo 'lm_invalid';}?>"
                                                type="radio"
                                                name="cont_possession"
                                                id="cont_possession1"
                                                value="YES"
                                                <?php
                                                   if(isset($err_return)) {
                                                      if(set_value('cont_possession') == YES) { echo "checked"; }
                                                   } else {
                                                      if (trim($lmnote->cont_possession) == YES) {echo "checked";}
                                                   }
                                                ?>
                                             />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                             <input
                                                class="form-check-input <?php if(form_error('cont_possession')){echo 'lm_invalid';}?>"
                                                type="radio"
                                                name="cont_possession"
                                                id="cont_possession2"
                                                value="NO"
                                                <?php
                                                   if(isset($err_return)) {
                                                      if(set_value('cont_possession') == NO) { echo "checked"; }
                                                   } else {
                                                      if (trim($lmnote->cont_possession) == NO) {echo "checked";}
                                                   }
                                                ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>


                            
                                <?php
                                    include(APPPATH."views/SettlementView/include/settlementPropertyModalRevert.php");
                                ?>

                                <?php
                                foreach($dags as $landmark_dag):
                                    if($landmark_dag->landmark != null)
                                    {
                                        $landmark = json_decode($landmark_dag->landmark);
                                        ?>
                                        <div class="row p-2">
                                        <div class="col-md-6">
                                            <label for="">
                                            <strong><?=$sl_count++?>.</strong> 
                                            Landsmark 
                                            <span class="alert-warning">for Dag no. <?=$landmark_dag->dag_no?></span>
                                            </label>
                                                <?=form_error('landmark_east')?>
                                                <?=form_error('landmark_west')?>
                                                <?=form_error('landmark_north')?>
                                                <?=form_error('landmark_south')?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">East side landmark</label>
                                            <textarea name="landmark_east" placeholder="Enter East Landmark" id="landmark_east" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east')){ echo 'lm_invalid';}?>"><?php if(isset($err_return)){ echo set_value('landmark_east');}else{ echo $landmark->east;}?></textarea>
                                            <label for="">West side landmark</label>
                                            <textarea name="landmark_west" class="form-control <?php if(form_error('landmark_west')){ echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="landmark_west" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_west');}else{ echo $landmark->west;}?></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">North side landmark</label>
                                            <textarea name="landmark_north" class="form-control <?php if(form_error('landmark_north')){ echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="landmark_north" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_north');}else{ echo $landmark->north;}?></textarea>
                                            <label for="">South side landmark</label>
                                            <textarea name="landmark_south" class="form-control <?php if(form_error('landmark_south')){ echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="landmark_south" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_south');}else{ echo $landmark->south;}?></textarea>
                                        </div>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="row p-2">
                                        <div class="col-md-6">
                                            <label for="">
                                            <strong><?=$sl_count++?>.</strong> 
                                            Landsmark 
                                            <span class="alert-warning">for Dag no. <?=$landmark_dag->dag_no?></span>
                                            </label>
                                            <?=form_error('landmark_east')?>
                                            <?=form_error('landmark_west')?>
                                            <?=form_error('landmark_north')?>
                                            <?=form_error('landmark_south')?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">East side landmark</label>
                                            <textarea name="landmark_east" placeholder="Enter East Landmark" id="landmark_east" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east')){ echo 'lm_invalid';}?>"><?php if(isset($err_return)){ echo set_value('landmark_east');}?></textarea>
                                            <label for="">West side landmark</label>
                                            <textarea name="landmark_west" class="form-control <?php if(form_error('landmark_west')){ echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="landmark_west" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_west');}?></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">North side landmark</label>
                                            <textarea name="landmark_north" class="form-control <?php if(form_error('landmark_north')){ echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="landmark_north" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_north');}?></textarea>
                                            <label for="">South side landmark</label>
                                            <textarea name="landmark_south" class="form-control <?php if(form_error('landmark_south')){ echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="landmark_south" cols="30" rows="3"><?php if(isset($err_return)){ echo set_value('landmark_south');}?></textarea>
                                        </div>
                                        </div>
                                        <?php
                                    }
                                endforeach;
                                ?>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> LRA remarks </span>
                                        <?=form_error('lm_note')?>
                                        <?=form_error('lm_remark_text')?>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>">
                                            <?php
                                            foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                                                ?>
                                                <option value="<?=$lm_remark_cat->CODE?>">
                                                <?=$lm_remark_cat->NAME?>
                                                <?php } ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                    include(APPPATH."views/SettlementView/include/rejectedReasons.php");
                                ?>
                                
                                <div id="lm_remark_text_id" class="row p-2" style="display: none;">
                                        <div class="col-md-12">
                                        <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control <?php if(form_error('lm_remark_text')){echo 'lm_invalid';}?>" id="lm_remark_text" rows="10" cols="60"><?php echo set_value('lm_remark_text');?></textarea>
                                            
                                        </div>
                                    </div>
                                <br>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                    <strong><?=$sl_count++?>.</strong> Premium <span><b>[ Dag No: <?=$dags[0]->dag_no?> Revenue Rs -  <?=$revenue->dag_revenue?> (B-K-L : <?=$revenue->dag_area_b?>-<?=$revenue->dag_area_k?>-<?=$revenue->dag_area_lc?> )]</b></span></label>
                                    <?=form_error('total_due_amount')?>
                                    <?=form_error('prem_update')?>
                                    <span><b>&nbsp; <br>(10% of the current zonal value + 50 Times of Dag Revenue Value / Bigha)</b></span>
                                    </div>
                                    <div class="col-md-6">
                                    <input id="validationcheck" type="hidden" class="validationcheck" value="<?php if(isset($err_return)){ echo set_value('validationcheck');}else{ echo "1"; } ?>" name="validationcheck"/>
                                    <label for="title">Do you want to chnage the premium?</label>
                                    <input type="radio" id="prem_update1" name="prem_update" class="prem_update <?php if(form_error('prem_update')){echo 'lm_invalid';}?>" value="YES">
                                    <label for="html">YES</label>
                                    <input type="radio" id="prem_update2" name="prem_update" class="prem_update <?php if(form_error('prem_update')){echo 'lm_invalid';}?>" value="NO">
                                    <label for="css">NO</label><br>
                                    <button id="chngPremButton" type="button" style="display:none" class="rezaButt buttPrimary <?php if (form_error('total_due_amount')) {echo 'lm_invalid';}?>"
                                        onclick="premiumModal();">
                                    Calculate Premium
                                    </button>
                                    <input type="hidden" name="dag_revenue" class="form-control dag_revenue" value=<?=$revenue->dag_revenue?>  id="dag_revenue" />
                                    <input type="hidden" name="total_s_lessa" class="form-control total_s_lessa" value=""  id="total_s_lessa" />
                                    <input type="hidden" name="total_dag_lessa" class="form-control total_dag_lessa" value=""  id="total_dag_lessa" />
                                    </div>
                                </div>
                                <div class="row p-2" style="display:none" id="total_due_row">
                                    <div class="col-md-6">
                                    <strong><?=$sl_count++?>.</strong> Total due amount (Rs) </label>
                                    </div>
                                    <div class="col-md-6">
                                    <input readonly type="text" name="total_due_amount" class="form-control total_due_amount"  id="total_due_amount" />
                                    </div>
                                </div>

                                <!-- new premium addition -->
                                <?php
                                    include(APPPATH."views/SettlementView/include/premium_calculation_modal_tenant_mb3.php");
                                ?>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <strong><?=$sl_count++?>.</strong> Compensation Beneficiary </label>
                                        <?=form_error('beneficiary_err')?>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" onclick="compenBene();" class="btn btn-sm btn-warning <?php if(form_error('beneficiary_err')){echo 'lm_invalid';}?>"><strong>Click to select/add Beneficiary</strong></button>
                                        
                                    </div>
                                </div>

                                <?php
                                    include(APPPATH."views/SettlementView/include/addMoreDocumentView.php");
                                ?>
                                <br>
                           </div>
                           <?php endforeach;?>
                           <h5 class="reza-title" style="margin-top: 50px">
                              <i class="fa fa-file-pdf-o"></i> Uploaded Documents
                           </h5>
                           <div class="tableCard">
                              <table class="table table-bordered">
                                 <?php foreach ($dhardocuments as $docs): ?>
                                 <tr>
                                    <th>
                                       <a target='download' href="<?php echo base_url() ?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$docs->id?>"><i class="fa fa-paperclip"></i> <?=$docs->file_name;?>
                                       <?php if (isset($docs->dag_no)) {?>
                                       <span class="alert-danger"><small> for Dag no: <strong><?=$docs->dag_no?></strong></small></span>
                                       <?php }?>
                                       </a>
                                    </th>
                                    <td>
                                       <input type="file" name="<?=$docs->dag_no?>_<?=$docs->id?>"  style="font-size: 1em!important;">
                                    </td>
                                 </tr>
                                 <?php endforeach;

                                 if(NRC_FILE_UPLOAD_ENABLED == 1)
                                 {
                                    include(APPPATH."views/SettlementView/include/nrcFileUpload.php");
                                 }


                                 ?>
                              </table>
                           </div>
                        </div>
                     </div>
                     <ul class="list-inline pull-right">
                        <li>
                           <button type="button" class="btn btn-default prev-step">
                           <i class="fa fa-arrow-circle-left"> </i>
                           <?php echo $this->lang->line('previous'); ?>
                           </button>
                        </li>
                        <li>
                           <button type="submit" onclick="submitSecond()" id="submit_seconproc" class="btn btn-primary">
                           <i class="fa fa-check-square-o" aria-hidden="true"></i>
                           <?php echo $this->lang->line('update_records'); ?>
                           </button>
                        </li>
                     </ul>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step3">
                     <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$case_no?></span> )
                     </h5>
                     <div class="reza-card ">
                        <div class="reza-body">
                           <h5 class="reza-title" style="margin-top: 15px">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                           </h5>
                           <div class="tableCard ">
                              <table class="table table-bordered">
                                 <tr>
                                    <th>Date of remark</th>
                                    <th>Remark from</th>
                                    <th>Remark</th>
                                 </tr>
                                 <?php $i = 1;foreach ($proceedings as $pro): ?>
                                 <tr>
                                 <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                    <td><?=$pro->office_from;?></td>
                                    <td><span><?=$pro->note_on_order;?></span></td>
                                 </tr>
                                 <?php endforeach;?>
                              </table>
                           </div>
                        </div>
                     </div>
                     <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                           <button type="button" class="btn btn-default prev-step">
                           <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                           </button>
                        </li>
                        <li>
                           <button type="button" class="btn btn-primary next-step">
                           <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                           </button>
                        </li>
                     </ul>
                     <!-- proceeding end -->
                  </div>
                  <div class="tab-pane" role="tabpanel" id="history">
                     <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$case_no?></span> )
                     </h5>
                     <div class="reza-card ">
                        <div class="reza-body">
                           <h5 class="reza-title"  style="margin-top: 15px">
                              <i class="fa fa-history" aria-hidden="true"></i> Case History
                           </h5>
                           <div class="tableCard">
                              <div class="timeline" style="margin-bottom: 15px">
                                 <?php foreach ($proceedings as $pro): ?>
                                 <?php if ($pro->status == MB_FINAL): ?>
                                 <div class="timeline__content" style="background-color: #4CAF50">
                                    <span class="content_tag" style="margin-top: 15px; background-color: white; color: #4CAF50">
                                    Application Approved
                                    </span>
                                    <span class="content_date" style="color: white; margin-top: 7px">
                                    <?=date("F j, Y", strtotime($pro->date_entry))?>
                                    <br>
                                    By <?=$pro->office_from;?>
                                    </span>
                                 </div>
                                 <?php elseif ($pro->status == MB_DISMISS): ?>
                                 <div class="timeline__content" style="background-color: #EF5350">
                                    <span class="content_tag" style="margin-top: 15px; background-color: white; color: #EF5350">
                                    Application Rejected
                                    </span>
                                    <span class="content_date" style="color: white; margin-top: 7px">
                                    <?=date("F j, Y", strtotime($pro->date_entry))?>
                                    <br>
                                    By <?=$pro->office_from;?>
                                    </span>
                                 </div>
                                 <?php else: ?>
                                 <div class="timeline__content" >
                                    <span class="content_tag" style="background-color: #AB47BC; color: white">
                                    <?php if ($pro->task != ''): ?>
                                    <?=$pro->task;?>
                                    <?php else: ?>
                                    Not Defined
                                    <?php endif?>
                                    </span>
                                    <span style="margin-top: 30px"></span>
                                    <span class="content_date" >
                                    On <?=date("F j, Y", strtotime($pro->date_entry))?>
                                    </span>
                                    <span class="content_Name" >
                                    By&nbsp;
                                    <?php if ($pro->office_from != ''): ?>
                                    <?=$pro->office_from;?>
                                    <?php else: ?>
                                    Not Defined
                                    <?php endif?>
                                    </span>
                                 </div>
                                 <?php endif;?>
                                 <?php endforeach;?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                           <button type="button" class="btn btn-default prev-step">
                           <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                           </button>
                        </li>
                     </ul>
                  </div>
               </div>

                <!-- LM template start -->
                <?php
                if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))){
                    if(isset($property) && !empty($property)) {
                        $resultprop = array();
                        foreach($property as $isproperty):
                            $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে " .$isproperty->ganda. " গ";
                        endforeach;
                        $aditional_prop_temp=implode(",",$resultprop);
                        $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
                    } 
                    else { 
                        $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                    }
                }else{
                    if(isset($property) && !empty($property)) {
                        $resultprop = array();
                        foreach($property as $isproperty):
                            $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে";
                        endforeach;
                        $aditional_prop_temp=implode(",",$resultprop);
                        $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
                    } 
                    else { 
                        $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                    }
                }
                ?>

                <?php
                if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))){
                    $resultdags = array();
                    foreach($applicants as $dags_lmtemplate){ 
                        $resultdags[] = $dags_lmtemplate->dag_no;
                            if($dags_lmtemplate->is_applicant == 1){
                                $app_name=$dags_lmtemplate->name_ass;
                            }
                            ?>


                    <input type="hidden" id="sbigha" name='sbigha'>
                    <input type="hidden" id="skatha" name='skatha'>
                    <input type="hidden" id="slessa" name='slessa'>
                    <input type="hidden" id="sganda" name='sganda'>

                    <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                    <input type="hidden" id="alloted_katha" name='alloted_katha'>
                    <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
                    <input type="hidden" id="alloted_ganda" name='alloted_ganda'>

                    <script>
                        function totalAppliedArea(){
                            var total_area = 0;
                            var mbigha = parseFloat($("#s_dag_area_b").val());
                            var mkatha = parseFloat($("#s_dag_area_k").val());
                            var mlessa = parseFloat($("#s_dag_area_lc").val());
                            var mganda = parseFloat($("#s_dag_area_g").val());
                            var total_area = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
                            

                            var bigha_r = Math.floor(total_area / 100);
                            var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                            var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                            var bigha_r = Math.floor(total_area / 6400);
                            var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
                            var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
                            var ganda_r = (total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20).toFixed(2);

                            $("#sbigha").val(bigha_r);
                            $("#skatha").val(katha_r);
                            $("#slessa").val(lessa_r);
                            $("#sganda").val(ganda_r);

                            var total_road_reserved = 0;
                            var total_lm_reserved = 0;
                            var total_family_reserved = 0;
                            var total_lm_family_reserved = 0;
                            <?php foreach($applicants as $dags_lmtemplate3){ ?>

                                var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;                
                                var road_ganda=$("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                                total_lm_reserved = total_lm_reserved + total_road_reserved;

                                var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                var family_ganda=$("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                                total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                            <?php } ?>

                            var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                            var alloted_bigha = Math.floor(total_alloted_area / 6400);
                            var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 6400) / 320);
                            var alloted_lessa = Math.floor((total_alloted_area - (alloted_bigha * 6400) - (alloted_katha * 320)) / 20);
                            var alloted_ganda = (total_alloted_area - alloted_bigha * 6400 - alloted_katha * 320 - alloted_lessa * 20).toFixed(2);
                            // alert(total_alloted_area);
                            $("#alloted_bigha").val(alloted_bigha);
                            $("#alloted_katha").val(alloted_katha);
                            $("#alloted_lessa").val(alloted_lessa);
                            $("#alloted_ganda").val(alloted_ganda);

                        }
                    </script>

                <?php } 
                    $all_dags=implode(",",$resultdags); ?>

                <?php } else{

                    $resultdags = array();

                    //echo "<pre>";var_dump($applicants);
                    foreach($applicants as $dags_lmtemplate){ 
                        $resultdags[] = $dags_lmtemplate->dag_no;
                            if($dags_lmtemplate->is_applicant == 1){
                                $app_name=$dags_lmtemplate->pdar_name;
                            }
                            ?>

                        <input type="hidden" id="sbigha" name='sbigha'>
                        <input type="hidden" id="skatha" name='skatha'>
                        <input type="hidden" id="slessa" name='slessa'>

                        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                        <input type="hidden" id="alloted_katha" name='alloted_katha'>
                        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>

                        <script>
                            function totalAppliedArea(){
                                var total_area = 0;
                                var mbigha = parseFloat($("#s_dag_area_b").val());
                                var mkatha = parseFloat($("#s_dag_area_k").val());
                                var mlessa = parseFloat($("#s_dag_area_lc").val());
                                var total_area = ((mbigha * 100) + (mkatha * 20) + mlessa);
                                

                                var bigha_r = Math.floor(total_area / 100);
                                var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                                var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                                $("#sbigha").val(bigha_r);
                                $("#skatha").val(katha_r);
                                $("#slessa").val(lessa_r);

                                var total_road_reserved = 0;
                                var total_lm_reserved = 0;
                                var total_family_reserved = 0;
                                var total_lm_family_reserved = 0;
                                <?php foreach($applicants as $dags_lmtemplate3){ ?>
                                    var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;                
                                    total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                                    total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                                <?php } ?>

                                var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                                var alloted_bigha = Math.floor(total_alloted_area / 100);
                                var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 100) / 20);
                                var alloted_lessa = total_alloted_area - alloted_bigha * 100 - alloted_katha * 20;
                                // alert(total_alloted_area);
                                $("#alloted_bigha").val(alloted_bigha);
                                $("#alloted_katha").val(alloted_katha);
                                $("#alloted_lessa").val(alloted_lessa);

                            }
                        </script>

                    <?php }
                    $all_dags=implode(",",$resultdags);
                }
                ?>
            <!-- LM template end -->


            </form>
            <div class="clearfix"></div>
         </div>
      </section>
   </div>
</div>

<!-- Beneficary modal starts here -->
<div id="beneModal" class="modal">
  <div class="modal-content">
    <div class="row text-right">
      <span class="close-bene px-4">&times;</span>
    </div>
    <p>
      <div class="row">
        <div class="col-md-12 text-center">
          <h5>Beneficiary details <strong><span id="dag_label"></span></strong></h5>
        
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 pl-5 pb-2">
            <span class="alert-warning">
                <i class="fa fa-star" aria-hidden="true"></i> Note : Beneficiary compensation should be total of <b>100%</b> by adding all Beneficiaries. <b>(Total compensation SUM now: <span id="totalCompensation"></span>)</b>
            </span>
        </div>
      </div>
      <div class="container">
  
        <div id="ownerList">
        </div>

        <!-- add beneficiary details -->
        <div class="row justify-content-center mt-2" id="bene_submit" style="display: none;">
          <button type="button" id="save" class="col-4 btn btn-sm btn-primary">SAVE</button>
        </div>
      </div>
    </p>
  </div>
</div>

<!-- Rayyatee modal starts here  -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="row text-right">
      <span class="close px-4">&times;</span>
    </div>
    <p>
      <div class="row">
        <div class="col-md-12 text-center">
          <h5>Available Rayyatee in Dag <strong><span id="dag_label"></span></strong></h5>
        </div>
      </div>
      <table class="table table-bordered datatable" id='datatable'>
        <thead>
          <th>#</th>
          <th>Khatian No</th>
          <th>Riotee Name</th>
          <th>Father's Name</th>
          <th>Address</th>
          <th>Action<button type="button" class="search_button btn btn-sm btn-success form-control">
                  <i class="fa fa-search" aria-hidden="true"></i>Search</button>
          </th>
        </thead>
        <tbody></tbody>
      </table>
    </p>
  </div>
</div>
<!-- Rayyatee modal ends here  -->
<!-- Beneficary modal ends here -->
<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
<style>
   .dataTables_wrapper .dataTables_filter {
   float: right;
   text-align: right;
   visibility: hidden;
   }
</style>
<script>
   function roadSideReservYes() {
       var x = document.getElementById("road_side_reservation_hide");
       if (x.style.display === "none") {
           x.style.display = "block";
       }
   }
   //  else {
   //   x.style.display = "none";
   // }
   function roadSideReservNo() {
       var x = document.getElementById("road_side_reservation_hide");
       if (x.style.display === "block") {
           x.style.display = "none";
       }
   }

   // zonal value validation
   $("#zonal_valuation").keyup(function(){
       var nodir_kaijo_b = $('#reserved_bigha').val();
       var nodir_kaijo_k = $('#reserved_katha').val();
       var nodir_kaijo_lc = $('#reserved_lessa').val();
       window.nodirkakhorlessa = parseFloat(nodir_kaijo_b) * 100 + parseFloat(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
       console.log(window.nodirkakhorlessa);
       var mbigha = $('.s_dag_area_b').val();
       var mkatha = $('.s_dag_area_k').val();
       var mlessa = $('.s_dag_area_lc').val();
       //window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
       window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
       console.log(window.originallessa);
       // alert(originallessa);
       window.occupiedlessa = nodirkakhorlessa;
       window.remaininglessa = originallessa - occupiedlessa;
       if(originallessa <= nodirkakhorlessa){
           alert("Road/River side reservation can't be greater then original land");
           $('#reserved_bigha').val("0");
           $('#reserved_katha').val("0");
           $('#reserved_lessa').val("0");
           window.nodirkakhorlessa=0;
           window.occupiedlessa = nodirkakhorlessa;
           window.remaininglessa = originallessa - occupiedlessa;
       }
       if(originallessa <= occupiedlessa){
           alert("Total Reservation land can't be greater then original land");
           $('#reserved_bigha').val("0");
           $('#reserved_katha').val("0");
           $('#reserved_lessa').val("0");
           window.nodirkakhorlessa=0;
           window.occupiedlessa = nodirkakhorlessa;
           window.remaininglessa = originallessa - occupiedlessa;
       }
       //alert(remaininglessa);
       var bigha_r = Math.floor(remaininglessa / 100);
       var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
       var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2);
   });

   // jS Masud Reza & Muzammil Da

   $(document).ready(function(){

       // // Add new element
       $(".add").click(function(){

           // Finding total number of elements added
           var total_element = $(".element").length;

           // last <div> with element class id
           var lastid = $(".element:last").attr("id");
           var split_id = lastid.split("_");
           var nextindex = Number(split_id[1]) + 1;

           var max = 35;
           // Check total number elements
           if(total_element < max ){
               // Adding new div container after last occurance of element class
               $(".element:last").after("<div class='element' id='div_"+ nextindex +"'></div>");

               // Adding element to <div>
               $("#div_" + nextindex).append("<table class='table table-bordered' id='applicantrow_"+ nextindex +"'> <tr> <th rowspan='5' style='vertical-align : middle;text-align:center;'>1</th> <th>Name of the applicant</th> <td colspan='2'> <input type='text' name='pdar_name2[]' required class='form-control input-sm'> </td> <th>Guardian name</th> <td colspan='2'> <input type='text' name='pdar_guardian2[]' required class='form-control input-sm' > </td> </tr> <tr> <th>Relation</th> <td> <select name='pdar_rel_guar2[]' id='pdar_rel_guar"+ nextindex +"' class='form-control' required> <option value='1' >Mother</option> <option value='2' selected>Father</option> <option value='3' >Husband</option> <option value='4' >Wife</option> <option value='5' >Guardian</option> <option value='6' >Supdt.Mother</option> <option value='7' >Guardian</option> </select> </td> <th>Gender</th> <td> <select name='pdar_gender2[]' id='pdar_gender"+ nextindex +"' class='form-control' > <option value='1' selected>Male</option> <option value='2' >Female</option> <option value='3' >Others</option> </select> </td> <th>Mobile</th> <td> <input type='text' name='pdar_mobile2[]' class='form-control input-sm' > </td> </tr> <tr> <th> Permanent address </th> <td colspan='2'> <input type='text' name='pdar_add12[]' class='form-control input-sm'> </td> <th>Present address</th> <td colspan='2'> <input type='text' name='pdar_add22[]' class='form-control input-sm' > </td> </tr><tr><td><span id='remove_" + nextindex + "' class='remove'><i class='fa fa-trash-o' style='font-size:32px;color:red'></i></span></td></tr> </table>&nbsp;");

           }

       });

       // Remove element
       $('.container').on('click','.remove',function(){

           var id = this.id;
           var split_id = id.split("_");
           var deleteindex = split_id[1];
           // Remove <div> with id
           $("#div_" + deleteindex).remove();
       });

       $(document).on('click', '.delete', function()
       {
           id = $(this).attr('id');
           if($('#del_fpart_appl').val()=='')
           {
               $('#del_fpart_appl').val(id);
           }
           else
           {
               $('#del_fpart_appl').val($('#del_fpart_appl').val()+', '+id);
           }
       });


       // Remove element
       $('.delete').on('click',function(){
           var id = this.id;
           var split_id = id.split("_");
           var deleteindex = split_id[1];
           // Remove <div> with id
           $("#applicantrow_" + deleteindex).remove();
       });

   });


   var premModal = document.getElementById("premiumModal");

function premiumModal()
{
    premModal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        premModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == premModal) {
            premModal.style.display = "none";
        }
    }

}

$(document).on('click','.closePremium',function ()
{
    premModal.style.display = "none";
});

$("input[name=paymode]").on("click", function () {
    var modeValue = $("input[name=paymode]:checked").val();
    if (modeValue == "YES") {
        $('#totaldue').val('');
        var totaldue= $("#finalamount").val();
        $("#totaldue").val(totaldue);
        $("#lmfinalamount").text(totaldue);
        $("#lmdueamount").text(totaldue);
    }
    else {
        if (modeValue == "NO") {
            var totaldue= $("#finalamount").val();
            var discount = 30;
            var finaldue = Math.ceil(totaldue * discount / 100);
            $("#totaldue").val(finaldue);
            $("#lmfinalamount").text(totaldue);
            $("#lmdueamount").text(finaldue);
        }
    }

});

$("#finalsubmit").click(function(){
    if ($('.zonal_valuation_prem').val().length === 0) {
        // alert('Please Enter Zonal Value!!');
        theme = "blue";
        $.jAlert({
            'title': 'Error: Field Required',
            'content': 'Please Enter Zonal Value!!!',
            'theme': theme,
            'backgroundColor': 'white',
            'btns': [
                {'text':'OK', 'theme':theme}
            ]
        });
        $('.zonal_valuation_prem').focus();
        return false;
    }

    if ($('.totalamount').val().length === 0) {
        theme = "blue";
        $.jAlert({
            'title': 'Error: Field Required',
            'content': 'Total Dag Amount can not be blank!!!',
            'theme': theme,
            'backgroundColor': 'white',
            'btns': [
                {'text':'OK', 'theme':theme}
            ]
        });
        $('.totalamount').focus();
        return false;
    }

    var sum = 0;
    $("input[class *= 'totalamount']").each(function(){
        if ($(this).val().length === 0) {
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Total Dag Amount can not be blank!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.totalamount').focus();
            sum = '';
            return false;
        }else{
            sum += +$(this).val();
        }
        
    });
    $(".premhide").show();
    $("#finalsubmit").hide();
    $("#finalsave").show();
    $("#closePremium").show();

    $("#finalamount").val(sum);
    $("#totaldue").val(sum);
    $("#paymode1").prop( "checked", true );
    // premModal.style.display = "none";
    $("#premrow").show();
    $("#lmfinalamount").text(sum);
    $("#lmdueamount").text(sum);
});

$("#finalsave").click(function(){
    if (!$('#finalamount').val()) {
        alert("Final Amount Can't be blak !!!");
        return;
    }
    $("#premrow").show();
    premModal.style.display = "none";
});

$("input[name=prem_update").on("click", function () {

    var selectedValue3 = $("input[name=prem_update]:checked").val();
    if (selectedValue3 == "YES") {

        $("#chngPremButton").show();
        // if($("#textField").val()==null){
        //     alert("Please select premium before proceed!!!");
        //     return false;
        // }

    }
    else {
        if (selectedValue3 == "NO") {
            $("#chngPremButton").hide();

        }
    }

});

   function totalAreaCheck(){
       $('#total_due_amount').val('');
   }
</script>
<script>
   function showSuccessMessage(text) {
       swal.fire({
           title: "Success !",
           text: text,
           icon: 'success',
           position: 'top',
           showConfirmButton: true,
           timer: 5000,
       });

   }

   function showErrorMessage(text) {
       swal.fire({
           title: "Error!",
           text: text,
           icon: 'error',
           position: 'top',
           timer: 5000,
           showCancelButton: true

       });
   }
</script>
<script>
   const classExists = document.getElementsByClassName(
       'is-invalid'
   ).length > 0;

   const classExistsLm = document.getElementsByClassName(
       'lm_invalid'
   ).length > 0;

   if(classExists){
       $('html, body').animate({
           scrollTop: ($('.is-invalid').offset().top - 300),
       }, 200);
   }else if(classExistsLm)
   {
       var $active = $('.wizard .nav-tabs li.active');
       $active.next().removeClass('disabled');
       nextTab($active);
       $('html, body').animate({
           scrollTop: ($('.lm_invalid').offset().top - 300),
       }, 200);
   };

   function nextTab(elem) {
       $(elem).next().find('a[data-toggle="tab"]').click();
   }
</script>

<script>
    // LM remark template start
    $("#lm_remark").change(function (event) {

    var selectedRemark=$(this).val();

    if(selectedRemark==1){
        $('#lm_remark_text_id').show();

        // alert("You have Selected  :: "+selectedRemark);
        totalAppliedArea();
        $('#lm_remark_text').text('');
        <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))): ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('#khatian_no_id1').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ ত ভূমি দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php else : ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('#khatian_no_id1').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে ত ভূমি দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php endif ;?>

    }else if(selectedRemark==2){
        $('#lm_remark_text_id').show();

        totalAppliedArea();
        $('#lm_remark_text').text('');
        <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))): ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('#khatian_no_id1').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ ত ভূমি দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পৰা নাযায়।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php else : ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('#khatian_no_id1').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে ত ভূমি দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পৰা নাযায়।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php endif ;?>
    }else{
        $('#lm_remark_text').text('');
        $('#lm_remark_text_id').hide();

    }
    });

    // LM remark template end
</script>

<script>
    function compenBene(){
        var modal = document.getElementById("beneModal");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-bene")[0];
        var save = document.getElementById('save');
        modal.style.display = "block";

        //*****When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            if (confirm("Closing this panel without saving the data will result in lost of inserted data!") == true) 
            {
                $("#ownerList").html("");
                modal.style.display = "none";
            } 
            else 
            {
                return false;
            }
        }

        //******* */ When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                if (confirm("Closing this panel without saving the data will result in lost of inserted data!") == true) 
                {
                    $("#ownerList").html("");
                    modal.style.display = "none";
                } 
                else 
                {
                    return false;
                }
            }
        }

        //****check if beneficiary already added, if so append */
        var case_no = $('#case_no').val();
            
        var postData = {
            'case_no' : case_no
        };
    
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementTenant/checkAddedBeneficiary',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 2)
                {
                    for(i = 0; i < arr.data.length; i++)
                    {
                        $('#ownerList').append("<div class=\"row wrapper p-1\">"+
                            "<div class=\"col-md-6\">"+
                                "<span class=\"alert-warning\">"+
                                    arr.data[i].pdar_name+
                                "</span>"+
                                "<small>"+
                                    "<strong>&nbsp; for Dag no : <?=$dags[0]->dag_no;?></strong>"+
                                "</small>"+
                                "<br>"+
                                "Is the mentioned owner of the land alive?"+
                                "<input type=\"hidden\" id=\"pdar_name_bene"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_name+"\">"+
                                "<input type=\"hidden\" id=\"pdar_id"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_id+"\">"+
                                "<input type=\"hidden\" id=\"owner_name"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_name+"\">"+
                                "<input type=\"hidden\" id=\"owner_father"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_guardian+"\">"+
                            "</div>"+
                            "<div class=\"col-md-6 text-center\">"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerAlive"+arr.data[i].pdar_id+"\" onclick=\"ownerAlive('"+arr.data[i].pdar_id+"', '"+case_no+"');\" value=\"YES\">"+
                                "&nbsp;<label>Yes</label> &nbsp;"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerDead"+arr.data[i].pdar_id+"\" onclick=\"ownerDead('"+arr.data[i].pdar_id+"', '"+case_no+"');\" value=\"NO\">"+
                                "&nbsp;<label>No</label> &nbsp;"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerUnt"+arr.data[i].pdar_id+"\" onclick=\"ownerUntraceable('"+arr.data[i].pdar_id+"', '"+case_no+"');\" class=\"owner_living_status_class\" value=\"UNT\">"+
                                "&nbsp;<label>Untraceable</label> &nbsp;"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerCca"+arr.data[i].pdar_id+"\" onclick=\"ownerCca('"+arr.data[i].pdar_id+"', '"+case_no+"');\" class=\"owner_living_status_class\" value=\"CCA\">"+
                                "&nbsp;<label>Could not capture account details</label>"+
                            "</div>"+
                        "</div>");

                        $('#ownerList').append("<div id=\"beneList"+arr.data[i].pdar_id+"\"></div>");

                        var postDataC = {
                                'pdar_id' : arr.data[i].pdar_id,
                                'case_no' : case_no
                            };
                                                    
                        $.ajax({
                            url: baseurl+'SettlementTenant/checkOwnerLivingStatus',
                            type: "POST",
                            data: postDataC,
                            success: function(data) {
                                arrOwnLiv = JSON.parse(data);
                                $.unblockUI();

                                // console.log(arrOwnLiv.data.owner_living_status);
                                if(arrOwnLiv.responseType == 2)
                                {
                                    if(arrOwnLiv.data.owner_living_status == 'YES')
                                    {
                                        $("#ownerAlive"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                        "<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Beneficiary Name</th>"+
                                                    "<th>Compensation Percentage</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append(
                                                           "<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_name+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_percentage+"</td>"+
                                                                "<td>"+arrBen.data[i].amount+"</td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });
                                    }
                                    if(arrOwnLiv.data.owner_living_status == 'NO')
                                    {
                                        $("#ownerDead"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                            "<div class=\"row justify-content-end pl-3 pr-3\">"+
                                                "<button onclick=\"ownerDead('"+arrOwnLiv.pdar_id+"', '"+case_no+"')\" class=\"col-1 btn btn-sm btn-info\" type=\"button\">Add more</button>"+
                                                "&nbsp; &nbsp; <button onclick=\"closeForm('"+arrOwnLiv.pdar_id+"')\" class=\"col-1 btn btn-sm btn-warning\" type=\"button\">Close</button>"+
                                            "</div>"
                                        );

                                        $('#beneList'+arrOwnLiv.pdar_id).append("<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Beneficiary Name</th>"+
                                                    "<th>Compensation Percentage</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append("<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_name+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_percentage+"</td>"+
                                                                "<td>"+arrBen.data[i].amount+"</td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });
                                    }
                                    if(arrOwnLiv.data.owner_living_status == 'UNT')
                                    {
                                        $("#ownerUnt"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                        "<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Owner Name</th>"+
                                                    "<th>Owner Guardian Name</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append(
                                                           "<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_name+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_father+"</td>"+
                                                                "<td><span class=\"alert-danger\">Untraceable</span></td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });


                                    }

                                    if(arrOwnLiv.data.owner_living_status == 'CCA')
                                    {
                                        $("#ownerCca"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerCca'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                        "<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Owner Name</th>"+
                                                    "<th>Owner Guardian Name</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append(
                                                           "<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_name+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_father+"</td>"+
                                                                "<td><span class=\"alert-danger\">Could not capture account details</span></td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });


                                    }

                                }
                            }
                        });

                        $('#ownerList').append("<table class=\"table table-bordered\" id=\"ownerInputForm"+arr.data[i].pdar_id+"\"></table>");
                        $('#ownerList').append("<hr>");

                    }
                }
            }
        });
    }

    $(document).ready(function() {
        $('#totalCompensation').html('');
        totalCompensationSum();
    });

    function totalCompensationSum()
    {
        case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no' : case_no
        };
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementTenant/totalCompensationSum',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }
                else{
                    $('#totalCompensation').html(arr.data);
                }
            }
        });
    }

    function closeForm(pdar_id)
    {
        $('#ownerInputForm'+pdar_id).html('');
    }

    function ownerAlive(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();
        var total_due_amount = $.trim($('#total_due_amount').val());

        if(total_due_amount == '')
        {
            alert('Please calculate premium before enter Beneficiary data !');
            $("#ownerAlive"+pdar_id).prop( "checked", false );
            return false;
        }

        var postData = {
            'pdar_id' : pdar_id,
            'case_no' : case_no
        };
    
        // $.unblockUI();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementTenant/checkIfAreadlyBeneExist',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 1)
                {
                    //*******if data doesnot exist then enter option */
                    $('#ownerInputForm'+pdar_id).html('');
                    $('#ownerInputForm'+pdar_id).append("<thead>"+
                            "<tr class=\"bg-success\">"+
                                "<th class=\"text-center\" colspan=\"4\">Enter Owner Details</th>"+
                            "</tr>"+
                        "</thead>"+
                        "<tr>"+
                            "<input type=\"hidden\" id=\"original_owner_father"+pdar_id+"\" value=\""+owner_father+"\">"+
                            "<input type=\"hidden\" id=\"original_owner_name"+pdar_id+"\" value=\""+owner_name+"\">"+
                            "<input type=\"hidden\" id=\"total_due_amount"+pdar_id+"\" value=\""+total_due_amount+"\">"+
                            "<td>"+
                                "<label>Enter owners PAN number</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter PAN number\" class=\"form-control\" id=\"pan_number"+pdar_id+"\">"+
                            "</td>"+
                            "<td>"+
                                "<label>Name of the Bank</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter Bank name\" class=\"form-control\" id=\"bank_name"+pdar_id+"\">"+
                            "</td>"+
                    
                        "</tr>"+

                        "<tr>"+
                            "<td>"+
                                "<label>Enter Bank Account Number</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter Account name\" class=\"form-control\" id=\"acc_number"+pdar_id+"\">"+
                            "</td>"+
                            "<td>"+
                                "<label>Enter Bank IFSC</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter IFSC\" class=\"form-control\" id=\"bank_ifsc"+pdar_id+"\">"+
                            "</td>"+
                        "</tr>"+

                        "<tr>"+
                            "<td>"+
                                "<label>Percentage of Compensation</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"number\" placeholder=\"Enter compensation percentage\" class=\"form-control\" id=\"percentage_compensation"+pdar_id+"\">"+
                            "</td>"+
                            "<td>"+
                                "<label>Bank passbook/Cancelled Cheque copy</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"file\" class=\"form-control\" id=\"bank_photo"+pdar_id+"\">"+
                            "</td>"+
                        "</tr>"+

                        "<tr>"+
                            "<td class=\"text-center\" colspan=\"4\">"+
                                "<button type=\"button\" onclick=\"insertOwnerData('"+pdar_id+"', '"+case_no+"')\" class=\"btn btn-primary btn-sm pl-3 pr-3\">Save</button>"+
                            "</td>"+
                        "</tr>");
                }
            }
        });
    }

    function insertOwnerData(pdar_id, case_no)
    {
        var owner_pan_no = $.trim($('#pan_number'+pdar_id).val());
        var owner_bank_name = $.trim($('#bank_name'+pdar_id).val());
        var owner_acc_no = $.trim($('#acc_number'+pdar_id).val());
        var owner_ifsc = $.trim($('#bank_ifsc'+pdar_id).val());
        var original_owner_father = $.trim($('#original_owner_father'+pdar_id).val());
        var original_owner_name = $.trim($('#original_owner_name'+pdar_id).val()); 
        var total_due_amount = $.trim($('#total_due_amount'+pdar_id).val()); 
        var bene_percentage = $.trim($('#percentage_compensation'+pdar_id).val());

        if(owner_pan_no == '')
        {
            alert('Please enter owner_pan_no!');
            $('#pan_number'+pdar_id).focus();
            return false;
        }
        if(owner_bank_name == '')
        {
            alert('Please enter owner_bank_name!');
            $('#bank_name'+pdar_id).focus();
            return false;
        }
        if(owner_acc_no == '')
        {
            alert('Please enter owner_acc_no!');
            $('#acc_number'+pdar_id).focus();
            return false;
        }
        if(owner_ifsc == '')
        {
            alert('Please enter owner_ifsc!');
            $('#bank_ifsc'+pdar_id).focus();
            return false;
        }
        if(original_owner_father == '')
        {
            alert('Please enter original_owner_father!');
            $('#original_owner_father'+pdar_id).focus();
            return false;
        }
        if(original_owner_name == '')
        {
            alert('Please enter original_owner_name!');
            $('#original_owner_name'+pdar_id).focus();
            return false;
        }
        if(total_due_amount == '')
        {
            alert('Please enter total_due_amount!');
            $('#total_due_amount'+pdar_id).focus();
            return false;
        }
        if(bene_percentage == '')
        {
            alert('Please enter bene_percentage!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if(bene_percentage > 100)
        {
            alert('The Percentage of compensation should not be greater then 100!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if($('#bank_photo'+pdar_id).val() == '')
        {
            alert('Please upload Bank/cheque copy!');
            $('#bank_photo'+pdar_id).focus();
            return false;
        }

        var postData = new FormData();
        postData.append("owner_pan_no", owner_pan_no);
        postData.append("owner_bank_name", owner_bank_name);
        postData.append("owner_acc_no", owner_acc_no);
        postData.append("owner_ifsc", owner_ifsc);
        postData.append("bank_photo", $("#bank_photo"+pdar_id)[0].files[0]);
        postData.append("original_pdar_id", pdar_id);
        postData.append("original_owner_father", original_owner_father);
        postData.append("original_owner_name", original_owner_name);
        postData.append("owner_living_stats", 'YES');
        postData.append("case_no", case_no);
        postData.append("total_due_amount", total_due_amount);
        postData.append("bene_percentage", bene_percentage);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
           url: baseurl+'SettlementTenant/insertOwnerData',
           type: "POST",
           data: postData,
           enctype: 'multipart/form-data',
           contentType: false,
           cache: false,
           processData:false,
           success: function(data) {
               arr = JSON.parse(data);               
               $.unblockUI();

               if(arr.responseType == 0)
               {
                   showErrorMessage(arr.msg);
               }
               else
               {
                   Swal.fire({
                           text: arr.msg,
                           icon: 'success',
                           confirmButtonText: 'OK',
                           customClass: {
                               actions: 'my-actions',
                               confirmButton: 'order-2',
                           }
                   }).then((result) => {
                       if (result.isConfirmed) {
                            $("#ownerList").html("");
                            compenBene();
                            $('#totalCompensation').html('');
                            totalCompensationSum();
                       }
                   })
               }
           }
       });
    }

    function deleteBeneficiary(id, pdar_id, case_no)
    {
        var postData = {
            'id' : id,
            'pdar_id' : pdar_id,
            'case_no' : case_no
        };

        Swal.fire({
            title: 'Do you want to delete this data?',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
        
                $.ajax({
                    url: baseurl+'SettlementTenant/deleteBeneficiary',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        $.unblockUI();
                        if(arr.responseType == 0){
                            showErrorMessage(arr.msg);
                        }
                        else{
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#ownerList").html("");
                                    compenBene();
                                    $('#totalCompensation').html('');
                                    totalCompensationSum();
                                }
                            })
                        }
                    }
                });
            }
        })
    }

    function ownerDead(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();
        var total_due_amount = $.trim($('#total_due_amount').val());

        if(total_due_amount == '')
        {
            alert('Please calculate premium before enter Beneficiary data !');
            $("#ownerAlive"+pdar_id).prop( "checked", false );
            return false;
        }

        var postData = {
            'pdar_id' : pdar_id,
            'case_no' : case_no
        };
    
        // $.unblockUI();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementTenant/checkIfAreadlyBeneExist',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 1 || arr.responseType == 2)
                {

                    //*******if data doesnot exist then enter option */
                    $('#ownerInputForm'+pdar_id).html('');
                    $('#ownerInputForm'+pdar_id).append("<thead>"+
                        "<tr class=\"bg-success\">"+
                            "<th class=\"text-center\" colspan=\"4\">Enter NOK (Beneficiary) Details</th>"+
                        "</tr>"+
                    "</thead>"+
                    "<tr>"+
                        "<input type=\"hidden\" id=\"original_owner_father"+pdar_id+"\" value=\""+owner_father+"\">"+
                        "<input type=\"hidden\" id=\"original_owner_name"+pdar_id+"\" value=\""+owner_name+"\">"+
                        "<input type=\"hidden\" id=\"total_due_amount"+pdar_id+"\" value=\""+total_due_amount+"\">"+

                        "<td>"+
                            "<label>Enter Name</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter Name\" class=\"form-control\" id=\"bene_name"+pdar_id+"\">"+
                        "</td>"+

                        "<td>"+
                            "<label>Guardian Name</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter Guardian Name\" class=\"form-control\" id=\"bene_guardian_name"+pdar_id+"\">"+
                        "</td>"+

                    "</tr>"+

                    "<tr>"+
                        "<td>"+
                            "<label>Relation With Owner</label>"+
                        "</td>"+
                        "<td>"+
                            "<select class=\"form-control\" id=\"bene_relation"+pdar_id+"\">"+
                                "<?php foreach ($guar_rel as $guar_rel_list) {?>"+
                                    "<option value=\"<?=$guar_rel_list->id?>\"><?=$guar_rel_list->guard_rel_desc_as?></option>"+
                                "<?php }?>"+
                            "</select>"+
                        "</td>"+

                        "<td>"+
                            "<label>Gender</label>"+
                        "</td>"+
                        "<td>"+
                            "<select class=\"form-control\" id=\"bene_gender"+pdar_id+"\">"+
                                "<option value=\"1\">Male</option>"+
                                "<option value=\"2\">Female</option>"+
                                "<option value=\"3\">Female</option>"+
                            "</select>"+
                        "</td>"+
                    "</tr>"+

                    "<tr>"+

                        "<td>"+
                            "<label>DOB</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"date\" placeholder=\"Enter DOB\" class=\"form-control ymd\" id=\"bene_dob"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Mobile</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"number\" maxlength=\"10\" placeholder=\"Enter Mobile number\" class=\"form-control\" id=\"bene_mobile"+pdar_id+"\">"+
                        "</td>"+

                    "</tr>"+

                    
                    "<tr>"+

                        "<td>"+
                            "<label>Present Address</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter present address\" class=\"form-control\" id=\"bene_present_add"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Permanent Address</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter permanent address\" class=\"form-control\" id=\"bene_permanent"+pdar_id+"\">"+
                        "</td>"+

                    "</tr>"+

                    "<tr>"+

                        "<td>"+
                            "<label>Enter owners PAN number</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter PAN number\" class=\"form-control\" id=\"pan_number"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Name of the Bank</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter Bank name\" class=\"form-control\" id=\"bank_name"+pdar_id+"\">"+
                        "</td>"+
                
                    "</tr>"+

                    "<tr>"+
                        "<td>"+
                            "<label>Enter Bank Account Number</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"number\" placeholder=\"Enter Account name\" class=\"form-control\" id=\"acc_number"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Enter Bank IFSC</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter IFSC\" class=\"form-control\" id=\"bank_ifsc"+pdar_id+"\">"+
                        "</td>"+
                    "</tr>"+

                    "<tr>"+
                        "<td>"+
                            "<label>Percentage of Compensation</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"number\" placeholder=\"Enter compensation percentage\" class=\"form-control\" id=\"percentage_compensation"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Bank passbook/Cancelled Cheque copy</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"file\" class=\"form-control\" id=\"bank_photo"+pdar_id+"\">"+
                        "</td>"+
                    "</tr>"+

                    "<tr>"+
                        "<td class=\"text-center\" colspan=\"4\">"+
                            "<button type=\"button\" onclick=\"insertBeneficiaryData('"+pdar_id+"', '"+case_no+"')\" class=\"btn btn-primary btn-sm pl-3 pr-3\">Save</button>"+
                        "</td>"+
                    "</tr>");
                }
            }
        });
    }

    function insertBeneficiaryData(pdar_id, case_no)
    {
        var owner_pan_no = $.trim($('#pan_number'+pdar_id).val());
        var owner_bank_name = $.trim($('#bank_name'+pdar_id).val());
        var owner_acc_no = $.trim($('#acc_number'+pdar_id).val());
        var owner_ifsc = $.trim($('#bank_ifsc'+pdar_id).val());
        var original_owner_father = $.trim($('#original_owner_father'+pdar_id).val());
        var original_owner_name = $.trim($('#original_owner_name'+pdar_id).val()); 
        var total_due_amount = $.trim($('#total_due_amount'+pdar_id).val()); 
        var bene_percentage = $.trim($('#percentage_compensation'+pdar_id).val());

        var bene_name = $.trim($('#bene_name'+pdar_id).val());
        var bene_guardian_name = $.trim($('#bene_guardian_name'+pdar_id).val());
        var bene_relation = $.trim($('#bene_relation'+pdar_id).val());
        var bene_gender = $.trim($('#bene_gender'+pdar_id).val());
        var bene_dob = $.trim($('#bene_dob'+pdar_id).val());
        var bene_mobile = $.trim($('#bene_mobile'+pdar_id).val());
        var bene_present_add = $.trim($('#bene_present_add'+pdar_id).val());
        var bene_permanent = $.trim($('#bene_permanent'+pdar_id).val());

        if(bene_name == '')
        {
            alert('Please enter bene_name');
            $('#bene_name'+pdar_id).focus();
            return false;
        }
        if(bene_guardian_name == '')
        {
            alert('Please enter bene_guardian_name');
            $('#bene_guardian_name'+pdar_id).focus();
            return false;
        }
        if(bene_relation == '')
        {
            alert('Please enter bene_relation');
            $('#bene_relation'+pdar_id).focus();
            return false;
        }
        if(bene_gender == '')
        {
            alert('Please enter bene_gender');
            $('#bene_gender'+pdar_id).focus();
            return false;
        }
        if(bene_dob == '')
        {
            alert('Please enter bene_dob');
            $('#bene_dob'+pdar_id).focus();
            return false;
        }
        if(bene_mobile == '')
        {
            alert('Please enter bene_mobile');
            $('#bene_mobile'+pdar_id).focus();
            return false;
        }
        if(bene_present_add == '')
        {
            alert('Please enter bene_present_add');
            $('#bene_present_add'+pdar_id).focus();
            return false;
        }
        if(bene_permanent == '')
        {
            alert('Please enter bene_permanent');
            $('#bene_permanent'+pdar_id).focus();
            return false;
        }

        if(owner_pan_no == '')
        {
            alert('Please enter owner_pan_no!');
            $('#pan_number'+pdar_id).focus();
            return false;
        }
        if(owner_bank_name == '')
        {
            alert('Please enter owner_bank_name!');
            $('#bank_name'+pdar_id).focus();
            return false;
        }
        if(owner_acc_no == '')
        {
            alert('Please enter owner_acc_no!');
            $('#acc_number'+pdar_id).focus();
            return false;
        }
        if(owner_ifsc == '')
        {
            alert('Please enter owner_ifsc!');
            $('#bank_ifsc'+pdar_id).focus();
            return false;
        }
        if(original_owner_father == '')
        {
            alert('Please enter original_owner_father!');
            $('#original_owner_father'+pdar_id).focus();
            return false;
        }
        if(original_owner_name == '')
        {
            alert('Please enter original_owner_name!');
            $('#original_owner_name'+pdar_id).focus();
            return false;
        }
        if(total_due_amount == '')
        {
            alert('Please enter total_due_amount!');
            $('#total_due_amount'+pdar_id).focus();
            return false;
        }
        if(bene_percentage == '')
        {
            alert('Please enter bene_percentage!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if(bene_percentage > 100)
        {
            alert('The Percentage of compensation should not be greater then 100!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if($('#bank_photo'+pdar_id).val() == '')
        {
            alert('Please upload Bank/cheque copy!');
            $('#bank_photo'+pdar_id).focus();
            return false;
        }

        var postData = new FormData();
        postData.append("owner_pan_no", owner_pan_no);
        postData.append("owner_bank_name", owner_bank_name);
        postData.append("owner_acc_no", owner_acc_no);
        postData.append("owner_ifsc", owner_ifsc);
        postData.append("bank_photo", $("#bank_photo"+pdar_id)[0].files[0]);
        postData.append("original_pdar_id", pdar_id);
        postData.append("original_owner_father", original_owner_father);
        postData.append("original_owner_name", original_owner_name);
        postData.append("owner_living_stats", 'NO');
        postData.append("case_no", case_no);
        postData.append("total_due_amount", total_due_amount);
        postData.append("bene_percentage", bene_percentage);

        postData.append('bene_name', bene_name);
        postData.append('bene_guardian_name', bene_guardian_name);
        postData.append('bene_relation', bene_relation);
        postData.append('bene_gender', bene_gender);
        postData.append('bene_dob', bene_dob);
        postData.append('bene_mobile', bene_mobile);
        postData.append('bene_present_add', bene_present_add);
        postData.append('bene_permanent', bene_permanent);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
           url: baseurl+'SettlementTenant/insertBeneficiaryData',
           type: "POST",
           data: postData,
           enctype: 'multipart/form-data',
           contentType: false,
           cache: false,
           processData:false,
           success: function(data) {
               arr = JSON.parse(data);               
               $.unblockUI();

               if(arr.responseType == 0)
               {
                   showErrorMessage(arr.msg);
               }
               else
               {
                   Swal.fire({
                           text: arr.msg,
                           icon: 'success',
                           confirmButtonText: 'OK',
                           customClass: {
                               actions: 'my-actions',
                               confirmButton: 'order-2',
                           }
                   }).then((result) => {
                       if (result.isConfirmed) {
                            $("#ownerList").html("");
                            compenBene();
                            $('#totalCompensation').html('');
                            totalCompensationSum();
                       }
                   })
               }
           }
       });
    }

    function ownerUntraceable(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();

        var postData = {
            'owner_living_status' : 'UNT',
            'owner_name' : owner_name,
            'owner_father' : owner_father,
            'pdar_id' : pdar_id,
            'case_no' : case_no,
        };

        Swal.fire({
            title: 'This option will save the owner as untraceable...',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
        
                $.ajax({
                    url: baseurl+'SettlementTenant/ownerUntraceble',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        $.unblockUI();
                        if(arr.responseType == 0){
                            showErrorMessage(arr.msg);
                        }
                        else{
                            // modal.style.display = "none";
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#ownerList").html("");
                                    compenBene();
                                    $('#totalCompensation').html('');
                                    totalCompensationSum();
                                }
                            })
                        }
                    }
                });
            }
            else
            {
                $("#ownerUnt"+pdar_id).prop( "checked", false );
            }
            
        })

    }

    function ownerCca(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();

        var postData = {
            'owner_living_status' : 'CCA',
            'owner_name' : owner_name,
            'owner_father' : owner_father,
            'pdar_id' : pdar_id,
            'case_no' : case_no,
        };

        Swal.fire({
            title: 'This option will save as account details could not be captured...',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
        
                $.ajax({
                    url: baseurl+'SettlementTenant/ownerUntraceble',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        $.unblockUI();
                        if(arr.responseType == 0){
                            showErrorMessage(arr.msg);
                        }
                        else{
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#ownerList").html("");
                                    compenBene();
                                    $('#totalCompensation').html('');
                                    totalCompensationSum();
                                }
                            })
                        }
                    }
                });
            }
            else
            {
                $("#ownerCca"+pdar_id).prop( "checked", false );
            }
            
        })

    }
</script>

<!-- additional errors check  -->
<script>
   $('#additionalErrors').on('click',function(){
       $(this).next('#additional_errors_collapse').slideToggle();
   });
   
</script>

<script>
   function totalAreaCal(){
       $('#validationcheck').val('');
       $('#lm_remark_text').text('');
       $('#lm_remark').val('');
       var case_no = $('#case_no').val();

        $.ajax({
            url: baseurl+'SettlementTenant/deleteBeneficiaryData',
            type: 'post',
            data: {'case_no': case_no},
        })
   }
</script>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    function encroacherModal(tenant_id, dag_no, dist, subdiv, cir, mouza, lot, vill){

        modal.style.display = "block";

        // $("#khatian_label").html(khatian_no);
        $("#dag_label").html(dag_no);

        var base_url = "<?php echo base_url();?>";

        $('#datatable thead th:nth-of-type(3)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" value="" class="input_search form-control form-control-sm" placeholder="Search riotee" data-column-index="1" />');
        });

        var table = $('#datatable').DataTable({
            // "scrollX": true,
            'pageLength':10,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language': {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax':{
                url: base_url+'index.php/SettlementTenant/rioteePagination',
                type:'POST',
                data: {
                    tenant_id  : tenant_id,
                    // khatian_no : khatian_no,
                    dag_no     : dag_no,
                    dist       : dist,
                    subdiv     : subdiv,
                    cir        : cir,
                    mouza      : mouza,
                    lot        : lot,
                    vill       : vill,
                },
                deferLoading: 57,
            },


            order: [[2, 'asc']],
            columnDefs: [{
                targets: "_all",
                orderable: false,
                "className": "dt-center", "targets":[ 0, 4],
            }]

        });

        // button search
        $('.search_button').on('click', function () {
            $('table thead tr th .input_search').each(function(){
                table.column($(this).data('columnIndex')).search(this.value);
            });
            table.draw();
        });

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            table.destroy();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                table.destroy();
            }
        }

    }

    // change encroacher name to selected encroacher
    function changeEncroacher(tenant_db_id, tenant_id){
        var tenant_name = $("#tenant_name"+tenant_db_id).val();
        var tenants_father = $("#tenants_father"+tenant_db_id).val();
        var khatian_no = $("#khatian_no"+tenant_db_id).val();

        $("#tenant_name_id").val(tenant_name);
        $("#tenants_father_id").val(tenants_father);
        $("#khatian_no_id").val(khatian_no);
        $('.riotee_nok_khatian_no').val(khatian_no);

        var dist_code = '<?=$app['dist_code']?>';
        var cir_code = '<?=$app['cir_code']?>';
        var subdiv_code = '<?=$app['subdiv_code']?>';
        var mouza_pargona_code = '<?=$app['mouza_pargona_code']?>';
        var lot_no = '<?=$app['lot_no']?>';
        var vill_townprt_code = '<?=$app['vill_townprt_code']?>';
        var patta_no = '<?=$aadhar[0]->patta_no?>';
        var dag_no = '<?=$aadhar[0]->dag_no?>';

        $('#khatian_link').remove();
        $('#rk_view').append("<a href=\"<?php echo base_url()?>index.php/basundhara2/khatian?st="+khatian_no+"&end="+khatian_no+"&dist="+dist_code+"&cir_code="+cir_code+"&subdiv_code="+subdiv_code+"&mouza_code="+mouza_pargona_code+"&lot_no="+lot_no+"&village_code="+vill_townprt_code+"&patta_no="+patta_no+"&dag_no="+dag_no+" target=\"view_riotee_khatian\"><button type=\"button\" class=\"btn btn-sm btn-info text-white col-4\">View</button></a>");

        showSuccessMessage('Riotee changed successfully...');
        modal.style.display = "none";
        $('#datatable').DataTable().destroy();
    }
</script>

<script>
    function submitSecond()
    {
        $('#submit_seconproc').hide();
    }
</script>

<?php include(APPPATH."views/SettlementView/include/ekyc_new_appl_modal.php"); ?>
<?php include(APPPATH."views/SettlementView/include/multiple_appl_ekyc.php"); ?>

<script>

    $(document).ready(function(){
        var nature_pos_val = $('#nature_possession').val();
        if(nature_pos_val == 'Others'){
            $('#nature_possession_div_other').show();
        }else{
            $('#nature_possession_div_other').hide();
        }
        
        var is_tribal_belt = $('[name="is_tribal_belt"]:checked').val();

        if(is_tribal_belt == 'YES'){
            $('#tribal_belt_input_id').show();
            $('#protected_class_id').show();
            $('#contravention').hide();
        }else if (is_tribal_belt == 'NO'){
            $('#tribal_belt_input_id').hide();
            $('#protected_class_id').hide();
            $('#contravention').show();
        }

    });

    function naturePossessionOther(elm){
        if(elm.value == 'Others'){
            $('#nature_possession_div_other').show();
        }else{
            $('#nature_possession_div_other').hide();
        }
    }

    function handleTribalClick(elmt){
        if (elmt.value === "YES") {
            $('#tribal_belt_input_id').show();
            $('#protected_class_id').show();
            $('#contravention').hide();
        } else if (elmt.value === "NO") {
            $('#tribal_belt_input_id').hide();
            $('#protected_class_id').hide();
            $('#contravention').show();
        }
    }


</script>

<?php include(APPPATH."views/Tenant/addTenantApplicantDetails.php"); ?>