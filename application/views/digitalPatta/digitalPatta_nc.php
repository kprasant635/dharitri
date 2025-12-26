<style>
    .bg-cross{
        background-image:url('<?php echo base_url(); ?>application/views/images/crossword.png');
    }
    /*.logo{*/
    /*height : 15%!important;*/
    /*width : 14%!important;*/
    /*text-align :center!important;*/
    /*}*/
    /*.logoEmblem{*/
    /*margin-top: 0px!important;*/
    /*height:100%!important;*/
    /*width:50%!important;*/
    /*}*/
    /*.logoBorder{*/
    /*border:0px;*/
    /*}*/
    .himanxu-margin-top {
        margin-left: auto!important;   /* Pushes table to the right */
        margin-right: 0!important;     /* Aligns against right edge */
        width: auto!important;         /* Table width adjusts to content */
    }

    .himanxu-margin-top td {
        text-align: right!important;   /* Ensures text is right-aligned */
    }


    .reza-header-red {
        font-weight: bold!important;
        text-align: center!important;
    }

    .reza-table {
        width: 100%!important;
        border-collapse: collapse!important;
    }

    .reza-table th,
    .reza-table td {
        border: 1px solid black!important;
        vertical-align: middle!important;
    }

    .reza-table th {
        text-align: center!important;
        font-weight: bold!important;
    }
    *{
        font-family: 'Arial', sans-serif;
    }

    body {
        font-family: 'Arial', sans-serif;
    }
    table {
        font-family: 'Arial', sans-serif;
        border-collapse: collapse;
    }

    th{
        font-family: 'Arial', sans-serif;
        padding: 3px 3px 3px 3px!important;
        vertical-align: middle;
    }
    td{
        font-family: 'Arial', sans-serif;
        padding: 3px 3px 3px 3px!important;
        vertical-align: middle;
    }


</style>

<div class="modal" id="digital_patta_modal">
    <div class="col-lg-10 offset-1">

        <div class="bg-cross" id="print_div" style="font-size:10px;">
            <div class="panel-body">
                <div class="row" style="padding:10px 20px 10px 20px ;">
                    <div class="col-lg-12 col-md-12 col-sm-12"  style=" border: 2px solid #263238;">
                        <!-- heading row(logo) -->
                        <table style="width: 100%!important;">
                            <tbody>
                            <tr>
                                <td class="logo logoBorder" style="text-align:left!important;" width="33%">
                                    <img src='<?php echo base_url(); ?>assets/digital_patta/panchayati_raj.png' height="80" width="80" style="margin-bottom: -15px!important;">
                                    <br>
                                    <img src='<?php echo base_url(); ?>assets/digital_patta/basundhara_white_logo.png' height="70" width="70">
                                </td>
                                <td class="logo logoBorder logoEmblem" style="text-align:center" width="33%">
                                    <img src='<?php echo base_url(); ?>assets/digital_patta/emblem.png' height="90" width="90" style=" margin-top: -40px!important;">
                                </td>
                                <td class="logo logoBorder" style="text-align:right!important;" width="33%">
                                    <!-- <img src='<?php echo base_url(); ?>assets/digital_patta/dummy_qr.png' height="100" width="100"> -->
                                    <img src="<?php echo $base_64_qr ?>" height="90px" width="90px" style="margin-top: 25px!important;">
                                    <br>
                                    <span style="align-items: right; padding-left: 10px; font-weight: bold">DATE OF ISSUE: <?= date("d/m/Y") ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right" class="logoBorder"></td>
                            </tr>
                            </tbody>
                        </table>


                        <!-- header 1  -->
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10 text-center " style="text-align:center">
                                <span class="text-danger" style="font-size: 17px">
                                    OFFICE OF THE DISTRICT COMMISSIONER,&nbsp;<b><?=$this->digitalPattaLocationModel->getDistrictNameEng($patta_info['settlement_basic_details']->dist_code)?></b>
                                </span>
                                <span style="font-size: 19px">
                                    <br><u><b>DIGITAL PATTA (SVAMITVA-Land & Property Card)</b></u>
                                </span>
                                <span style="font-size: 15px">
                                     <br>(Issued under Section 40 of Assam Land and Revenue Regulation, 1886)
                                </span>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>



                        <!-- primary land holder details -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered reza-table-width-100  reza-heading-weight">
                                <tr style="background-color: #fcd9dd">
                                    <td colspan='9' style="text-align:center; border: 1px solid #263238; color: #D50000; " class="reza_header_red reza_font_bold_heading" >
                                        <b>PRIMARY LAND HOLDER DETAILS</b>
                                    </td>
                                </tr>

                                <tr style="background-color: #fcd9dd">
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Name</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Address</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Gender</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; width: 100px!important;; vertical-align: middle;" >
                                        <b>Father/Mother Name</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Category</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A ; width: 100px; vertical-align: middle;">
                                        <b>Date of Birth</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Current Occupation</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Mobile No.</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Email Id</b>
                                    </td>
                                </tr>

                                <tbody>

                                <tr>
                                    <td style="border: 1px solid #546E7A"><?=$patta_info['chitha_pattadar_applicant_data']->pdar_name_eng?></td>
                                    <td style="border: 1px solid #546E7A"><?=$patta_info['chitha_pattadar_applicant_data']->pdar_add1?></td>
                                    <td style="border: 1px solid #546E7A">
                                        <?php
                                        if($patta_info['applicant_data']->settlement_gender == 1){
                                            $gender = "MALE";
                                        }elseif($patta_info['applicant_data']->settlement_gender == 2){
                                            $gender = "FEMALE";
                                        }elseif($patta_info['applicant_data']->settlement_gender == 3){
                                            $gender = "OTHERS";
                                        }else{
                                            $gender = "--";
                                        }
                                        ?>
                                        <?= $gender?>
                                    </td>
                                    <td style="border: 1px solid #546E7A"><?=$patta_info['applicant_data']->settlement_guardian_eng?></td>
                                    <!-- <td>
                                    <?php
                                    $maritial_status_arr = json_decode(MARITAL_STATUS);
                                    foreach($maritial_status_arr as $maritial_status){
                                        if($maritial_status->CODE == $patta_info['settlement_applicant']->marital_status){
                                            $maritial_status_str = $maritial_status->NAME;
                                        }
                                    }
                                    ?>
                                    <?=$maritial_status_str?>
                                </td> -->

                                    <td style="border: 1px solid #546E7A">
                                        <?php
                                        $caste_arr = json_decode(CASTE);
                                        foreach($caste_arr as $caste){
                                            if($caste->CODE == $patta_info['chitha_pattadar_applicant_data']->pdar_caste){
                                                $caste_str = $caste->NAME;
                                            }
                                        }
                                        ?>
                                        <?=$caste_str?>
                                    </td>
                                    <td style="border: 1px solid #546E7A"><?=date('d-m-Y',strtotime($patta_info['applicant_data']->settlement_dob))?></td>
                                    <td style="border: 1px solid #546E7A"><?=$patta_info['settlement_basic_details']->occupation_applicant?></td>

                                    <?php if(!isset($patta_info['chitha_pattadar_applicant_data']->pdar_mobile) || $patta_info['chitha_pattadar_applicant_data']->pdar_mobile == null): ?>
                                        <td style="border: 1px solid #546E7A">--</td>
                                    <?php else : ?>
                                        <td style="border: 1px solid #546E7A"><?=$patta_info['chitha_pattadar_applicant_data']->pdar_mobile?></td>
                                    <?php endif ?>

                                    <td style="border: 1px solid #546E7A">--</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>



                        <!-- joint land holder heading -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered  himanxu-heading-weight himanxu-table-width-100">
                                <tr style="background-color: #fcd9dd">
                                    <td colspan='9' style="text-align:center; border: 1px solid #546E7A; color: #D50000" class="himanxu_header_red">
                                        <b>JOINT LAND HOLDER DETAILS</b>
                                    </td>
                                </tr>

                                <tr style="background-color: #fcd9dd">
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Name</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Gender</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; width: 100px!important;; vertical-align: middle;">
                                        <b>Father/Mother Name</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Category</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; width: 100px; vertical-align: middle;">
                                        <b>Date of Birth</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Current Occupation</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Relationship with <br>
                                            primary land holder <br>
                                        </b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Mobile No</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Email Id</b>
                                    </td>
                                </tr>

                                <tbody>
                                <?php foreach ($patta_info['joint_applicant_data'] as $joint_applicant):?>
                                    <tr>
                                        <td style="border: 1px solid #546E7A"><?=$joint_applicant->pdar_name_eng?></td>
                                        <td style="border: 1px solid #546E7A">
                                            <?php
                                            if(trim($joint_applicant->pdar_gender) == 'm'){
                                                $gender = "MALE";
                                            }elseif(trim($joint_applicant->pdar_gender) == 'f'){
                                                $gender = "FEMALE";
                                            }else{
                                                $gender = "--";
                                            }
                                            ?>
                                            <?= $gender?>
                                        </td>
                                        <td style="border: 1px solid #546E7A"><?=$joint_applicant->pdar_guard_eng?></td>
                                        <td style="border: 1px solid #546E7A">
                                            <?php
                                            if(isset($joint_applicant->pdar_caste) && trim($joint_applicant->pdar_caste) !=""){
                                                $caste_arr = json_decode(CASTE);
                                                foreach($caste_arr as $caste){
                                                    if($caste->CODE == $joint_applicant->pdar_caste){
                                                        $caste_str = $caste->NAME;
                                                    }
                                                }
                                            }else{
                                                $caste_str = "--";
                                            }
                                            ?>
                                            <?=$caste_str;?>
                                        </td>
                                        <td style="border: 1px solid #546E7A"><?=date('d-m-Y',strtotime($joint_applicant->dob))?></td>

                                        <td style="border: 1px solid #546E7A">--</td>

                                        <td style="border: 1px solid #546E7A">
                                            <?php
                                            $relation ='';
                                            if($joint_applicant->pdar_guard_reln == 'h'){
                                                $relation = "SPOUSE";
                                            }elseif($joint_applicant->pdar_guard_reln == 'm'){
                                                $relation = "MOTHER";
                                            }elseif($joint_applicant->pdar_guard_reln == 'f'){
                                                $relation = "FATHER";
                                            }elseif($joint_applicant->pdar_guard_reln == 'w'){
                                                $relation = "SPOUSE";
                                            }elseif($joint_applicant->pdar_guard_reln == 'a'){
                                                $relation = "SUPDT. MOTHER";
                                            }else{
                                                $relation = "GUARDIAN";
                                            }
                                            ?>
                                            <?=$relation?>
                                        </td>
                                        <td style="border: 1px solid #546E7A"><?=DIGITAL_PATTA_AADHAAR_NO?></td>
                                        <td style="border: 1px solid #546E7A">--</td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>



                        <!-- family details -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered himanxu-table-width-100  himanxu-heading-weight himanxu_body_color_green">
                                <!-- family heading -->
                                <tr style="background-color: #B9F6CA!important;">
                                    <td colspan='6' style="text-align:center; border: 1px solid #546E7A; color: #D50000" class="himanxu_header_red">
                                        <b>FAMILY DETAILS</b>
                                    </td>
                                </tr>

                                <tr class="himanxu_color_blue" style="background-color: #B9F6CA!important;">
                                    <td class="himanxu_color_blue"  style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Name</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>DOB</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Gender</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Relationship with <br>
                                            primary land holder <br>
                                        </b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Mobile No.</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid #546E7A; vertical-align: middle;">
                                        <b>Email Id</b>
                                    </td>
                                </tr>

                                <tbody>
                                <?php foreach ($patta_info['family_details'] as $family_details):

                                    $rel = $family_details->nominee_relation;
                                    if($rel == 1){
                                        $relation = 'Mother';
                                    }else if($rel == 2){
                                        $relation = 'Father';
                                    }else if($rel == 3){
                                        $relation = 'Husband';
                                    }else if($rel == 4){
                                        $relation = 'Wife';
                                    }else if($rel == 5){
                                        $relation = 'Guardian';
                                    }else if($rel == 6){
                                        $relation = 'Supdt.Mother';
                                    }else if($rel == 7){
                                        $relation = 'Guardian';
                                    }
                                    ?>
                                    <tr>
                                        <td><?=$family_details->nominee_name?></td>
                                        <td><?='--'?></td>
                                        <td><?='--'?></td>
                                        <td><?=$relation?></td>
                                        <td><?=DIGITAL_PATTA_AADHAAR_NO?></td>
                                        <td>--</td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>



                        <!-- LAND SCHEDULE DETAILS  -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered himanxu_body_color_purple himanxu-table-width-100">
                                <tr>
                                    <td colspan='6' style="text-align:center; border: 1px solid #546E7A; background-color: #fcd9dd; color: #D50000" class="himanxu_header_red">
                                        <b>LAND DESCRIPTION</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='6' style="text-align:center; border: 1px solid #546E7A; background-color: #fcd9dd; color: #D50000 " class="himanxu_header_red">
                                        <b>LAND SCHEDULE DETAILS</b>
                                    </td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td style="border: 1px solid #546E7A"><b>District</b></td>
                                    <td style="border: 1px solid #546E7A"><?=$this->digitalPattaLocationModel->getDistrictNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code)?></td>
                                    <td style="border: 1px solid #546E7A"><b>Sub-Division</b></td>
                                    <td style="border: 1px solid #546E7A">
                                        <?=$this->digitalPattaLocationModel->getSubDivNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                            $patta_info['chitha_pattadar_applicant_data']->subdiv_code)?>
                                    </td>
                                    <td style="border: 1px solid #546E7A"><b>Circle</b></td>
                                    <td style="border: 1px solid #546E7A">
                                        <?=$this->digitalPattaLocationModel->getCircleNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                            $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code)?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A"><b>Mouza</b></td>
                                    <td style="border: 1px solid #546E7A">
                                        <?=$this->digitalPattaLocationModel->getMouzaNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                            $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code,
                                            $patta_info['chitha_pattadar_applicant_data']->mouza_pargona_code)?>
                                    </td>
                                    <td style="border: 1px solid #546E7A"><b>Lot</b></td>
                                    <td style="border: 1px solid #546E7A">
                                        <?=$this->digitalPattaLocationModel->getLotNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                            $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code,
                                            $patta_info['chitha_pattadar_applicant_data']->mouza_pargona_code, $patta_info['chitha_pattadar_applicant_data']->lot_no)?>
                                    </td>
                                    <td style="border: 1px solid #546E7A"><b>Village</b></td>
                                    <td style="border: 1px solid #546E7A">
                                        <?=$this->digitalPattaLocationModel->getVillageNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                            $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code,
                                            $patta_info['chitha_pattadar_applicant_data']->mouza_pargona_code, $patta_info['chitha_pattadar_applicant_data']->lot_no,
                                            $patta_info['chitha_pattadar_applicant_data']->vill_townprt_code)?>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="border: 1px solid #546E7A;vertical-align: middle;">
                                        <b>Dag No. (old)</b>
                                    </td>
                                    <td rowspan="2" style="border: 1px solid #546E7A;vertical-align: middle;">
                                        <b>Dag No. (New)</b>
                                    </td>
                                    <td rowspan="2" style="border: 1px solid #546E7A;vertical-align: middle;">
                                        <b>Land Class</b>
                                    </td>
                                    <td colspan="3" style="text-align:center; border: 1px solid #546E7A">
                                        <b>Area</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td   style="border: 1px solid #546E7A">
                                        <b>B-K-L /B-K-C-G</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A">
                                        <b>Hectare</b>
                                    </td>
                                    <td style="border: 1px solid #546E7A">
                                        <b>Sq.Mtr</b>
                                    </td>
                                </tr>
                                <?php foreach ($patta_info['chitha_basic'] as $chitha_basic):?>
                                    <tr>

                                        <td  style="border: 1px solid #546E7A">
                                            <?=$chitha_basic->old_dag_no?>
                                        </td>
                                        <td  style="border: 1px solid #546E7A">
                                            <?=$chitha_basic->dag_no?>
                                        </td>
                                        <td  style="border: 1px solid #546E7A">
                                            <?=$this->digitalPattaLocationModel->getLandClassCode($chitha_basic->land_class_code);?>
                                        </td>
                                        <?php
                                        $bigha = $chitha_basic->dag_area_b;
                                        $kotha = $chitha_basic->dag_area_k;
                                        $lessa = $chitha_basic->dag_area_lc;
                                        $ganda = $chitha_basic->dag_area_g;
                                        ?>
                                        <td  style="border: 1px solid #546E7A">
                                            <?php if (in_array($chitha_basic->dist_code, json_decode(BARAK_VALLEY))): ?>
                                                <?=$bigha?> Bigha <?=$kotha?> Katha <?=$lessa?> Chatak <?=$ganda?> Ganda
                                            <?php else: ?>
                                                <?=$bigha?> Bigha <?=$kotha?> Katha <?=$lessa?> lessa
                                            <?php endif; ?>
                                        </td>
                                        <?php
                                        if (in_array($chitha_basic->dist_code, json_decode(BARAK_VALLEY)))
                                        {
                                            $location_data = $this->digitalPattaLocationModel->get_Hec_Are_CAre2($bigha,$kotha,$lessa,$ganda);
                                        }
                                        else
                                        {
                                            $location_data = $this->digitalPattaLocationModel->get_Hec_Are_CAre($bigha,$kotha,$lessa);
                                        }
                                        $totalSqMtr = $this->digitalPattaLocationModel->getSqMtrHectorFromAreaNC($bigha,$kotha,$lessa,$ganda,$chitha_basic->dist_code)
                                        ?>
                                        <td style="border: 1px solid #546E7A"><?=$location_data['hec']?> Hec <?=$location_data['are']?> Are <?=$location_data['Care']?> Cen</td>
                                        <td style="border: 1px solid #546E7A"><?=$totalSqMtr['totalSqMtr']?></td>

                                    </tr>
                                <?php endforeach;?>


                                </tbody>
                            </table>
                        </div>



                        <!-- LAND ATTRIBUTES -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered himanxu-table-width-100 himanxu_body_color_purple">
                                <?php foreach ($patta_info['chitha_basic'] as $chitha_basic): ?>
                                    <tr style="background-color: #fcd9dd">
                                        <td colspan='5' style="text-align:center; border: 1px solid #546E7A; color: #D50000 " class="himanxu_header_red">
                                            <b>LAND ATTRIBUTES</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="border: 1px solid #546E7A;vertical-align: middle;">Patta No</td>
                                        <td style="border: 1px solid #546E7A">Old</td>
                                        <td style="border: 1px solid #546E7A">New</td>
                                        <td style="border: 1px solid #546E7A">Land Revenue</td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_revenue?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->old_patta_no?></td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->patta_no?></td>
                                        <td style="border: 1px solid #546E7A">Local Rate</td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_local_tax?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #546E7A">Patta Type</td>
                                        <td style="border: 1px solid #546E7A" colspan="2"><?=$this->digitalPattaLocationModel->getPattaType($chitha_basic->patta_type_code)?></td>
                                        <td style="border: 1px solid #546E7A">Total</td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_revenue + $chitha_basic->dag_local_tax?></td>
                                    </tr>
                                <?php endforeach;?>
                                <tr>
                                    <b><td class="himanxu_header_red"  style="border: 1px solid #546E7A;  color: #D50000 ">Tenure</td></b>
                                    <td colspan="4" style="border: 1px solid #546E7A; ">The terminal date of settlement will be <?=DIGITAL_PATTA_TERMINAL_DATE?>, or as modified by Govt. of Assam.</td>
                                </tr>
                            </table>
                        </div>



                        <!--  Area Details -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100">
                                <tr style="background-color: #B9F6CA">
                                    <td colspan='6' style="text-align:center; border: 1px solid #546E7A; color: #D50000" class="himanxu_header_red">
                                        <b>LAND LOCATION DETAILS</b>
                                    </td>
                                </tr>
                                <tbody>
                                <?php foreach ($patta_info['chitha_basic'] as $chitha_basic):?>
                                    <tr>

                                        <td rowspan="3" style="border: 1px solid #546E7A; text-align:center;vertical-align: middle;">Boundary Description</td>
                                        <td rowspan="3" style="border: 1px solid #546E7A; text-align:center;vertical-align: middle;">Dag No (New) <?=$chitha_basic->dag_no?></td>
                                        <td style="border: 1px solid #546E7A">North</td>
                                        <td style="border: 1px solid #546E7A">South</td>
                                        <td style="border: 1px solid #546E7A">East</td>
                                        <td style="border: 1px solid #546E7A">West</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_n_desc?></td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_s_desc?></td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_e_desc?></td>
                                        <td style="border: 1px solid #546E7A"><?=$chitha_basic->dag_w_desc?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #546E7A">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_n_dag_no?></td>
                                        <td style="border: 1px solid #546E7A">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_s_dag_no?></td>
                                        <td style="border: 1px solid #546E7A">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_e_dag_no?></td>
                                        <td style="border: 1px solid #546E7A">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_w_dag_no?></td>
                                    </tr>
                                <?php endforeach;?>

                                </tbody>
                            </table>

                            <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100" style="margin-top: -17px!important;">
                                <tr align="center" style="background-color: #B9F6CA">
                                    <td colspan="3" width="25%" style="border: 1px solid #546E7A">
                                        ULPIN*/Geo-coordinates
                                    </td>
                                    <td colspan="3" width="25%" style="border: 1px solid #546E7A">
                                        Geo Tag Photos
                                    </td>
                                    <td colspan="3" width="25%" style="border: 1px solid #546E7A">
                                        Google Location
                                    </td>
                                    <td colspan="3" width="25%" style="border: 1px solid #546E7A">
                                        Land Schedule /Property Sketch
                                    </td>
                                </tr>

                                <tr align="center">
                                    <td colspan="3" style="text-align:center;vertical-align: middle; border: 1px solid black!important ">
                                        <img src=" <?php echo $base_64_qr_geo_cordinates ?>" alt="qr_code" height="100px" width="100px">
                                    </td>
                                    <td colspan="3" style="border: 1px solid black!important; vertical-align: middle;">
                                        <img src=" <?php echo $dag_sketch_qr_photos ?>" alt="qr_code" height="100px" width="100px">
                                    </td>
                                    <td colspan="3" style="text-align:center;vertical-align: middle; border: 1px solid black!important ">
                                        <img src=" <?php echo $base_64_qr_google ?>" alt="qr_code" height="100px" width="100px">
                                    </td>
                                    <td colspan="3" style="text-align:center; border: 1px solid black!important; vertical-align: middle; ">
                                        <img src=" <?php echo $base_64_qr_sketch ?>" alt="qr_code" height="100px" width="100px">
                                    </td>
                                </tr>
                            </table>
                        </div>



                        <!-- property Details -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100">
                                <tr style="background-color: #fcd9dd">
                                    <td colspan='6' style="text-align:center; border: 1px solid #546E7A; color: #D50000" class="himanxu_header_red">
                                        <b>PROPERTY DETAILS</b>
                                    </td>
                                </tr>
                                <tr style="background-color: #fcd9dd">
                                    <td style="border: 1px solid #546E7A">Property Type</td>
                                    <td style="border: 1px solid #546E7A">Dag No</td>
                                    <td style="border: 1px solid #546E7A">Built Up Area (Sq.Ft)</td>
                                    <td style="border: 1px solid #546E7A">Total Area (Sq.Ft)</td>
                                    <td style="border: 1px solid #546E7A">Property Value (Self Declared)</td>
                                    <td style="border: 1px solid #546E7A">Property/House Tax (if applicable)</td>
                                </tr>
                                <tbody>
                                <?php foreach ($patta_info['propertyDetails'] as $property) : ?>
                                    <tr>
                                        <td style="border: 1px solid #546E7A"><?php echo $property->property_type ?></td>
                                        <td style="border: 1px solid #546E7A"><?php echo $property->new_dag_no ?></td>
                                        <td style="border: 1px solid #546E7A"><?php echo $property->build_up_area ?></td>
                                        <td style="border: 1px solid #546E7A"><?php echo $property->total_area ?></td>
                                        <td style="border: 1px solid #546E7A"><?php echo $property->property_value ?></td>
                                        <td style="border: 1px solid #546E7A"><?php echo $property->tax ?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #546E7A">
                                            Encumbrance Details (If any)
                                        </td>
                                        <td colspan="5" style="border: 1px solid #546E7A">
                                            <?php echo $property->encumbrance_details ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>



                        <!-- Photo -->
                        <div class="row" style="padding:0px 20px 1px 20px;">
                            <table class="table table-bordered himanxu-table-width-100 himanxu_body_color_maroon">
                                <tbody>
                                <tr class="text-center " style="text-align:center;background-color: #fcd9dd">
                                    <th colspan="6"  style="border: 1px solid #546E7A">Photo</th>
                                </tr>
                                <?php
                                $all_photo_datas = [];
                                $primary_applicant_data = $patta_info['chitha_pattadar_applicant_data'];
                                $join_applicants = $patta_info['joint_applicant_data'];
                                if($patta_info['applicant_data']->identity_type == 'AADHAAR'){
                                    $all_photo_datas[] = [
                                        'name' => $primary_applicant_data->pdar_name_eng,
                                        'case_no' => $primary_applicant_data->o1_case_no,
                                        //'photo' => $this->digitalPattaPhotoModel->getPrimaryLandHolderImg($patta_info['settlement_applicant'],$patta_info['applicant_data']->ord_no),
                                        'photo' => 'Photo will be available only through AADHAAR authentication',
                                        'is_primary_applicant' => true
                                    ];
                                }else{
                                    $all_photo_datas[] = [
                                        'name' => $primary_applicant_data->pdar_name_eng,
                                        'case_no' => $primary_applicant_data->o1_case_no,
                                        'photo' => 'Photo will be available only through AADHAAR authentication',
                                        'is_primary_applicant' => true
                                    ];
                                }


                                if(count($join_applicants) > 0){
                                    foreach($join_applicants as $join_applicant){
                                        $all_photo_datas[] = [
                                            'name' => $join_applicant->pdar_name_eng,
                                            'case_no' => $primary_applicant_data->o1_case_no,
                                            'photo' => '<img src="'. base_url('assets/digital_patta/dummy.png') .'" class="img-thumbnail" width="90" height="70">',
                                            'is_primary_applicant' => false
                                        ];
                                    }
                                }

                                $photosByGroup =[];
                                $array_key = 0;
                                foreach($all_photo_datas as $key => $photo){
                                    if($key != 0 && $key % 5 == 0){
                                        $array_key++;
                                    }
                                    $photosByGroup[$array_key][] = $photo;
                                }
                                ?>
                                <?php
                                foreach($photosByGroup as $photoDatas):
                                    ?>
                                    <tr>
                                        <?php
                                        foreach($photoDatas as $photo):
                                            ?>

                                            <td style="border: 1px solid #546E7A">
                                                <?=$photo['name']?> <br>
                                                <?php if($photo['is_primary_applicant']):?>
                                                    (Primary Land Holder)
                                                <?php else: ?>
                                                    (Joint Land Holder)
                                                <?php endif; ?>
                                                <?=$photo['photo']?>
                                            </td>

                                        <?php
                                        endforeach;
                                        ?>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center " style="text-align:left; border: 1px solid #546E7A">(Once AADHAR authentication is done, photo will be auto-fetched)</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>



                        <!-- Issuing Authority-->
                        <div class="row" style="padding:0px 20px 1px 20px;">

                            <div class="col-lg-12" style="text-align:right; font-size: 15px" align="right" >
                                <br><br>
                                <b>Issuing Authority : </b> <b>District Commissioner</b><br>
                                <?php
                                $this->load->model('digitalPatta/DigitalPattaCommonNcModel');
                                $iAName = $this->DigitalPattaCommonNcModel->getIssuingAuthNameNc();?>
                                <b><?=$iAName?></b>
                            </div>

                            <div class="col-lg-12" style="font-size:14px;text-align:center" align="center">
                                <br><br>
                                <span style="font-style: italic;">
                                    Note: This is a system-generated document which does not require any physical signature. The authenticity of this document
                                    can be verified by scanning the QR code provided herein
                                </span>
                            </div>
                        </div>


                        <div class="row" style="padding:20px 20px 1px 20px;">
                            <h3 style="text-align:center"><b>TERMS AND CONDITIONS</b></h3>
                            <table class="table table-bordered himanxu-table-width-100">
                                <tr>
                                    <td align="center" style="text-align: center!important; border: 1px solid #546E7A">
                                        <b style="text-align:center!important;  vertical-align: middle;">Sl. No</b>
                                    </td>
                                    <td align="center" style="text-align: center!important; border: 1px solid #546E7A">
                                        <b style="text-align:center!important; vertical-align: middle;">Terms And Conditions</b>
                                    </td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td style="border: 1px solid #546E7A">1</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        Any person who had held as owner, land which exceeds the permissible limit as per any law for time being in force
                                        the aggregate of land held individually by the members of a family or jointly by some or all the members of such a
                                        family, then excess land shall be acquired as per provision of the law
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">2</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        During the change in usage or class of land of the total land or any part thereof with due permission from authority
                                        on payment of premium or penalty as the case may be wherever applicable, the revenue and local taxes now assessed may
                                        be changed by the State Government in accordance with law or rules in force and that shall be payable by the Lease-holder
                                        in prescribed time
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">3</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        If upon the expiry of the lease, the lease-holder does not intend to extend or get issued a fresh lease the State Government
                                        may at any time after the lease period annul the lease or settle the land with any other person as the case may be.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">4</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        In case of agricultural land, the lease-holder must cultivate the land by himself/themselves as a means of livelihood.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">5</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        In case of any public path or Government. institutions found on any land held by the lease-holder, the authority will have the
                                        right to take action as per Section 10 of Assam Land Revenue Regulation 1886, treating the said land deemed to have been relinquished
                                        by the lease-holder
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">6</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        In case of new settlement of Government. land, the settlement shall be conferred as a joint title to the husband and wife, if the
                                        applicant is married and also familywise
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">7</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        The Lease- holder shall have a permanent, heritable and transferable right of use and occupancy in the land subject to the reservation in
                                        favour of the State Government of all quarries and of all mines, minerals and mineral oils, and of all buried treasure, with full liberty
                                        to search for and work the same, paying to the leaseholder only compensation for the surface damage as estimated by the District Commissioner.
                                        However, in case of land under Tribal Belt & Blocks, restrictions under Section 164 and Section 164(A) of Assam Land Revenue Regulation 1886
                                        will be also applicable. Further, violation of provisions of Section 164 will invite action as per Section 165 of Assam Land Revenue Regulation 1886.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">8</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        The Lease-holder shall not transfer as defined under the Transfer of Property Act,1882, the agricultural land outside of town area to any non-agriculturist.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">9</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        The Lease-holder shall conform to the timely payment of the land revenue from time to time assessed on the said land and of any local rates or cesses etc.
                                        payable from time to time under any law or rules for the time being in force.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">10</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        The terms and conditions of this lease shall be binding on the heirs, assignees, successors or NOK, of the said lease-holder in the interest
                                        of the State Government and the Lease-holder in all cases
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">11</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        This settlement of land shall be cancelled if it is established at any later stage that such beneficiaries resorted to submission of fraudulent
                                        supporting documents & information including affidavits and in case of settlement of land on realization of premium, amount of premium shall be
                                        forfeited in addition to any other legal action for submission of fraudulent documents & information, false affidavits etc.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #546E7A">12</td>
                                    <td style="text-align: left!important;border: 1px solid #546E7A">
                                    <span>
                                        Violation of any of the above conditions may result in annulment of the settlement by cancellation of Patta.
                                    </span>
                                    </td>
                                </tr>
                                </tbody>



                            </table>
                            <div class="row" style="padding:0px 20px 1px 20px;">

                                <div class="col-lg-12" style="text-align:right; font-size: 15px" align="right" >
                                    <br><br>
                                    <b>Issuing Authority : </b> <b>District Commissioner</b><br>
                                    <?php
                                    $this->load->model('digitalPatta/DigitalPattaCommonNcModel');
                                    $iAName = $this->DigitalPattaCommonNcModel->getIssuingAuthNameNc();?>
                                    <b>
                                        <?=$iAName?>
                                    </b>
                                </div>

                            </div>
                            <br>
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <div class="col-md-12 mt-3" style="text-align:center; background-color: white" >
            <button type="button" class="btn btn-danger himanxuNotShowButton" id="modal-close">Close &times; </button>
        </div>


        <script>
            //function to close modal
            $(document).on('click', '#modal-close', function () {
                $('#digital_patta_modal').hide('300');
            });

        </script>





