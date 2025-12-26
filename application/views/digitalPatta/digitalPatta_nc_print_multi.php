<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DHARITREE || Land Records Computerization Project</title>


    <style>
        .bg-cross{
            background-image:url('<?php echo base_url(); ?>application/views/images/crossword.png');
        }
        .bg-cross
        {
            padding-left: 150px;
            padding-right: 150px;
        }
        .himanxu-margin-top {
            margin-left: auto!important;   /* Pushes table to the right */
            margin-right: 0!important;     /* Aligns against right edge */
            width: auto!important;         /* Table width adjusts to content */
        }

        .reza-table {
            width: 100%!important;
            border-collapse: collapse!important;
        }


        .buttPrimary {
            color: #FFF;
            background-color: #673AB7;
        }
        .buttInfo {
            color: #FFF;
            background-color: #03a9f4;
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
        .reza-table th,
        .reza-table td {
            border: 1px solid black!important!important;
            padding: 6px!important;
            vertical-align: middle!important;
        }

        .reza-table th {
            text-align: center!important;
            font-weight: bold!important;
        }
        *{
            font-family: 'Arial', sans-serif!important;
        }

        body {
            font-family: 'Arial', sans-serif!important;
            font-size: 12px;
        }
        table {
            font-family: 'Arial', sans-serif!important;
            border-collapse: collapse;
        }

        th{
            font-family: 'Arial', sans-serif!important;
            padding: 4px 4px 2px 4px!important;
            vertical-align: middle!important;
        }
        td{
            font-family: 'Arial', sans-serif!important;
            padding: 3px 3px 1px 3px!important;
            vertical-align: middle!important;
        }
        .reza_header_red{
            text-align:center!important;
            border: 1px solid #263238!important;
            color: #D50000!important;
            font-size: 12px;!important;
        }
        .reza_table_text{
            font-size: 12px;!important;
        }
        .reza_1{
            font-size: 14px!important;
        }
        .reza_2{
            font-size: 15px!important;
        }
        .reza_3{
            font-size: 12px!important;
        }


    </style>

    <style>
        @media print
        {
            .bg-cross{
                background-image:url('<?php echo base_url(); ?>application/views/images/crossword.png');
            }
            .himanxu-margin-top {
                margin-left: auto!important;   /* Pushes table to the right */
                margin-right: 0!important;     /* Aligns against right edge */
                width: auto!important;         /* Table width adjusts to content */
            }

            .reza-table {
                width: 100%!important;
                border-collapse: collapse!important;
            }

            .reza-table th,
            .reza-table td {
                border: 1px solid black!important!important;
                vertical-align: middle!important;
            }

            .reza-table th {
                text-align: center!important;
                font-weight: bold!important;
            }
            *{
                font-family: 'Arial', sans-serif!important;
            }

            body {
                font-family: 'Arial', sans-serif!important;
            }
            table {
                font-family: 'Arial', sans-serif!important;
                border-collapse: collapse;
            }

            th{
                font-family: 'Arial', sans-serif!important;
                padding: 3px!important;
                vertical-align: middle!important;
            }
            td{
                font-family: 'Arial', sans-serif!important;
                padding: 3px!important;
                vertical-align: middle!important;

            }
            .reza_header_red{
                text-align:center!important;
                color: #D50000!important;
                font-size: 11px;!important;
            }
            .reza{
                border: 1px solid black!important!important;
                background-color: red!important;
            }
            .reza_table_text{
                font-size: 10px;!important;
            }
            .page-break {
                page-break-before: always;   /* For most browsers */
                break-before: page;          /* Modern browsers */
            }

            * {
                color-adjust: exact !important;
            }

            .reza_1{
                font-size: 12px!important;
            }
            .reza_2{
                font-size: 13px!important;
            }
            .reza_3{
                font-size: 10px!important;
            }

        }
    </style>
</head>
<body>

<div class="row">
    <div class="col-lg-10 offset-1">
        <div class="col-md-12 mt-3" style="text-align:center; background-color: white" >

            <button type="button" onclick="printDiv('print_div');" id="print" class="rezaButt buttInfo">
                <i class="fa fa-print" aria-hidden="true"></i>
                Print Property Card
            </button>
            <br><br>
        </div>


        <div class="bg-cross" id="print_div" style="font-size:10px;">
            <?php foreach ($cases as $case): ?>


                <div class="row" style="padding:7px 14px 7px 14px ;">
                    <div class="col-lg-12 col-md-12 col-sm-12"  style=" border: 1px solid #4CAF50!important; height: 100%!important;min-height: 99vh!important;">
                        <!-- heading row(logo) -->
                        <table style="width: 100%!important; margin-bottom: -10px!important;">
                            <tbody>
                            <tr>
                                <td class="logo logoBorder" style="text-align:left!important;" width="33%">
                                    <img src='<?php echo base_url(); ?>assets/digital_patta/panchayati_raj.png' height="60" width="60" style="margin-top: 0px!important;">
                                    <br>
                                    <img src='<?php echo base_url(); ?>assets/digital_patta/basundhara_white_logo.png' height="50" width="50" style="margin-top: -10px!important;">
                                </td>
                                <td class="logo logoBorder logoEmblem" style="text-align:center" width="33%">
                                    <img src='<?php echo base_url(); ?>assets/digital_patta/emblem.png' height="60" width="60" style=" margin-top: -30px!important;">
                                </td>
                                <td class="logo logoBorder" style="text-align:right!important;" width="33%">
                                    <img src="<?php echo $case['base_64_qr'] ?>" height="70px" width="70px" style="margin-top: 10px!important;">
                                    <br>
                                    <span style="align-items: right; padding-left: 10px; font-weight: bold; font-size: 10px!important;">
                                        DATE OF ISSUE: <?= date("d/m/Y") ?>
                                    </span>
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
                            <div class="col-lg-10 text-center " style="text-align:center!important;">
                            <span class="text-danger reza_1">
                                OFFICE OF THE DISTRICT COMMISSIONER,&nbsp;
                                <b><?=$this->digitalPattaLocationModel->getDistrictNameEng($case['patta_info']['settlement_basic_details']->dist_code)?></b>
                            </span>
                                <span class="reza_2">
                                <br><u><b>DIGITAL PATTA (SVAMITVA-Land & Property Card)</b></u>
                            </span>
                                <span class="reza_3" >
                                <br>(Issued under Section 40 of Assam Land and Revenue Regulation, 1886)
                            </span>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>


                        <div class="row" style="padding:0px 10px 1px 10px;!important;">

                            <!-- primary land holder details -->
                            <table class="table table-bordered reza-table-width-100">
                                <!-- primary land holder details -->
                                <tr style="background-color: #fcd9dd!important;border: 1px solid black!important;">
                                    <td colspan='9' class="reza_header_red" style="border: 1px solid black!important;">
                                        <b>PRIMARY LAND HOLDER DETAILS</b>
                                    </td>
                                </tr>
                                <tr style="background-color: #fcd9dd!important; border: 1px solid black!important;"  class="reza_table_text">
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Name</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Address</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Gender</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;!important;" >
                                        <b>Father/Mother Name</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Category</b>
                                    </td>
                                    <td style="border: 1px solid black!important;vertical-align: middle!important;">
                                        <b>Date of Birth</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Current Occupation</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Mobile No.</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle!important;">
                                        <b>Email Id</b>
                                    </td>
                                </tr>
                                <tbody>
                                <tr class="reza_table_text" style="border: 1px solid black!important;" >
                                    <td style="border: 1px solid black!important"><?=$case['patta_info']['chitha_pattadar_applicant_data']->pdar_name_eng?></td>
                                    <td style="border: 1px solid black!important"><?=$case['patta_info']['chitha_pattadar_applicant_data']->pdar_add1?></td>
                                    <td style="border: 1px solid black!important">
                                        <?php
                                        if($case['patta_info']['applicant_data']->settlement_gender == 1){
                                            $gender = "MALE";
                                        }elseif($case['patta_info']['applicant_data']->settlement_gender == 2){
                                            $gender = "FEMALE";
                                        }elseif($case['patta_info']['applicant_data']->settlement_gender == 3){
                                            $gender = "OTHERS";
                                        }else{
                                            $gender = "--";
                                        }
                                        ?>
                                        <?= $gender?>
                                    </td>
                                    <td style="border: 1px solid black!important"><?=$case['patta_info']['applicant_data']->settlement_guardian_eng?></td>
                                    <td style="border: 1px solid black!important">
                                        <?php
                                        $caste_arr = json_decode(CASTE);
                                        foreach($caste_arr as $caste){
                                            if($caste->CODE == $case['patta_info']['chitha_pattadar_applicant_data']->pdar_caste){
                                                $caste_str = $caste->NAME;
                                            }
                                        }
                                        ?>
                                        <?=$caste_str?>
                                    </td>
                                    <td style="border: 1px solid black!important"><?=date('d-m-Y',strtotime($case['patta_info']['applicant_data']->settlement_dob))?></td>
                                    <td style="border: 1px solid black!important"><?=$case['patta_info']['settlement_basic_details']->occupation_applicant?></td>

                                    <?php if(!isset($case['patta_info']['chitha_pattadar_applicant_data']->pdar_mobile) || $case['patta_info']['chitha_pattadar_applicant_data']->pdar_mobile == null): ?>
                                        <td style="border: 1px solid black!important">--</td>
                                    <?php else : ?>
                                        <td style="border: 1px solid black!important"><?=$case['patta_info']['chitha_pattadar_applicant_data']->pdar_mobile?></td>
                                    <?php endif ?>

                                    <td style="border: 1px solid black!important">--</td>
                                </tr>
                                </tbody>
                            </table>




                            <!-- joint land holder heading -->
                            <table class="table table-bordered reza-table-width-100" style="margin-top: -17px!important;">
                                <tr style="background-color: #fcd9dd;border: 1px solid black!important;">
                                    <td colspan='9'  class="reza_header_red" style="border: 1px solid black!important;">
                                        <b>JOINT LAND HOLDER DETAILS</b>
                                    </td>
                                </tr>
                                <tr style="background-color: #fcd9dd; border: 1px solid black!important;"  class="reza_table_text">
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Name</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Gender</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Father/Mother Name</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Category</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Date of Birth</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Current Occupation</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Relationship with
                                            primary land holder
                                        </b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Mobile No</b>
                                    </td>
                                    <td style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Email Id</b>
                                    </td>
                                </tr>
                                <tbody>
                                <?php foreach ($case['patta_info']['joint_applicant_data'] as $joint_applicant):?>
                                    <tr class="reza_table_text" >
                                        <td style="border: 1px solid black!important"><?=$joint_applicant->pdar_name_eng?></td>
                                        <td style="border: 1px solid black!important">
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
                                        <td style="border: 1px solid black!important"><?=$joint_applicant->pdar_guard_eng?></td>
                                        <td style="border: 1px solid black!important">
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
                                        <td style="border: 1px solid black!important"><?=date('d-m-Y',strtotime($joint_applicant->dob))?></td>

                                        <td style="border: 1px solid black!important">--</td>

                                        <td style="border: 1px solid black!important">
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
                                        <td style="border: 1px solid black!important"><?=DIGITAL_PATTA_AADHAAR_NO?></td>
                                        <td style="border: 1px solid black!important">--</td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>




                            <!-- family details -->
                            <table class="table table-bordered himanxu-table-width-100" style="margin-top: -17px!important;">
                                <!-- family heading -->
                                <tr style="background-color: #B9F6CA!important;">
                                    <td colspan='6' class="reza_header_red" >
                                        <b>FAMILY DETAILS</b>
                                    </td>
                                </tr>

                                <tr class="reza_table_text" style="background-color: #B9F6CA!important;">
                                    <td class="himanxu_color_blue"  style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Name</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>DOB</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Gender</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Relationship with primary land holder</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Mobile No.</b>
                                    </td>
                                    <td class="himanxu_color_blue"  style="border: 1px solid black!important; vertical-align: middle;">
                                        <b>Email Id</b>
                                    </td>
                                </tr>

                                <tbody>
                                <?php foreach ($case['patta_info']['family_details'] as $family_details):

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
                                    <tr class="reza_table_text">
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




                            <!-- LAND SCHEDULE DETAILS  -->
                            <table class="table table-bordered himanxu_body_color_purple himanxu-table-width-100" style="margin-top: -17px!important;">
                                <tr>
                                    <td colspan='6'  class="reza_header_red"  style="background-color: #fcd9dd;">
                                        <b>LAND DESCRIPTION</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='6'  class="reza_header_red"  style="background-color: #fcd9dd;">
                                        <b>LAND SCHEDULE DETAILS</b>
                                    </td>
                                </tr>
                                <tbody >
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important"><b>District</b></td>
                                    <td style="border: 1px solid black!important"><?=$this->digitalPattaLocationModel->getDistrictNameEng($case['patta_info']['chitha_pattadar_applicant_data']->dist_code)?></td>
                                    <td style="border: 1px solid black!important"><b>Sub-Division</b></td>
                                    <td style="border: 1px solid black!important">
                                        <?=$this->digitalPattaLocationModel->getSubDivNameEng($case['patta_info']['chitha_pattadar_applicant_data']->dist_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->subdiv_code)?>
                                    </td>
                                    <td style="border: 1px solid black!important"><b>Circle</b></td>
                                    <td style="border: 1px solid black!important">
                                        <?=$this->digitalPattaLocationModel->getCircleNameEng($case['patta_info']['chitha_pattadar_applicant_data']->dist_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->subdiv_code, $case['patta_info']['chitha_pattadar_applicant_data']->cir_code)?>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important"><b>Mouza</b></td>
                                    <td style="border: 1px solid black!important">
                                        <?=$this->digitalPattaLocationModel->getMouzaNameEng($case['patta_info']['chitha_pattadar_applicant_data']->dist_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->subdiv_code, $case['patta_info']['chitha_pattadar_applicant_data']->cir_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->mouza_pargona_code)?>
                                    </td>
                                    <td style="border: 1px solid black!important"><b>Lot</b></td>
                                    <td style="border: 1px solid black!important">
                                        <?=$this->digitalPattaLocationModel->getLotNameEng($case['patta_info']['chitha_pattadar_applicant_data']->dist_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->subdiv_code, $case['patta_info']['chitha_pattadar_applicant_data']->cir_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->mouza_pargona_code, $case['patta_info']['chitha_pattadar_applicant_data']->lot_no)?>
                                    </td>
                                    <td style="border: 1px solid black!important"><b>Village</b></td>
                                    <td style="border: 1px solid black!important">
                                        <?=$this->digitalPattaLocationModel->getVillageNameEng($case['patta_info']['chitha_pattadar_applicant_data']->dist_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->subdiv_code, $case['patta_info']['chitha_pattadar_applicant_data']->cir_code,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->mouza_pargona_code, $case['patta_info']['chitha_pattadar_applicant_data']->lot_no,
                                            $case['patta_info']['chitha_pattadar_applicant_data']->vill_townprt_code)?>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td rowspan="2" style="border: 1px solid black!important;vertical-align: middle;">
                                        <b>Dag No. (old)</b>
                                    </td>
                                    <td rowspan="2" style="border: 1px solid black!important;vertical-align: middle;">
                                        <b>Dag No. (New)</b>
                                    </td>
                                    <td rowspan="2" style="border: 1px solid black!important;vertical-align: middle;">
                                        <b>Land Class</b>
                                    </td>
                                    <td colspan="3" style="text-align:center; border: 1px solid black!important">
                                        <b>Area</b>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td   style="border: 1px solid black!important">
                                        <b>B-K-L /B-K-C-G</b>
                                    </td>
                                    <td style="border: 1px solid black!important">
                                        <b>Hectare</b>
                                    </td>
                                    <td style="border: 1px solid black!important">
                                        <b>Sq.Mtr</b>
                                    </td>
                                </tr>
                                <?php foreach ($case['patta_info']['chitha_basic'] as $chitha_basic):?>
                                    <tr class="reza_table_text">

                                        <td  style="border: 1px solid black!important">
                                            <?=$chitha_basic->old_dag_no?>
                                        </td>
                                        <td  style="border: 1px solid black!important">
                                            <?=$chitha_basic->dag_no?>
                                        </td>
                                        <td  style="border: 1px solid black!important">
                                            <?=$this->digitalPattaLocationModel->getLandClassCode($chitha_basic->land_class_code);?>
                                        </td>
                                        <?php
                                        $bigha = $chitha_basic->dag_area_b;
                                        $kotha = $chitha_basic->dag_area_k;
                                        $lessa = $chitha_basic->dag_area_lc;
                                        $ganda = $chitha_basic->dag_area_g;
                                        ?>
                                        <td  style="border: 1px solid black!important">
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
                                        <td style="border: 1px solid black!important"><?=$location_data['hec']?> Hec <?=$location_data['are']?> Are <?=$location_data['Care']?> Cen</td>
                                        <td style="border: 1px solid black!important"><?=$totalSqMtr['totalSqMtr']?></td>

                                    </tr>
                                <?php endforeach;?>


                                </tbody>
                            </table>




                            <!-- LAND ATTRIBUTES -->
                            <table class="table table-bordered himanxu-table-width-100" style="margin-top: -17px!important;">
                                <?php foreach ($case['patta_info']['chitha_basic'] as $chitha_basic): ?>
                                    <tr style="background-color: #fcd9dd" class="reza_header_red" >
                                        <td colspan='5'  class="reza_header_red">
                                            <b>LAND ATTRIBUTES</b>
                                        </td>
                                    </tr>
                                    <tr class="reza_table_text">
                                        <td rowspan="2" style="border: 1px solid black!important;vertical-align: middle;">Patta No</td>
                                        <td style="border: 1px solid black!important">Old</td>
                                        <td style="border: 1px solid black!important">New</td>
                                        <td style="border: 1px solid black!important">Land Revenue</td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_revenue?></td>
                                    </tr>
                                    <tr class="reza_table_text">
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->old_patta_no?></td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->patta_no?></td>
                                        <td style="border: 1px solid black!important">Local Rate</td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_local_tax?></td>
                                    </tr>
                                    <tr class="reza_table_text">
                                        <td style="border: 1px solid black!important">Patta Type</td>
                                        <td style="border: 1px solid black!important" colspan="2"><?=$this->digitalPattaLocationModel->getPattaType($chitha_basic->patta_type_code)?></td>
                                        <td style="border: 1px solid black!important">Total</td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_revenue + $chitha_basic->dag_local_tax?></td>
                                    </tr>
                                <?php endforeach;?>
                                <tr class="reza_table_text">
                                    <b><td style="border: 1px solid black!important;  color: #D50000 ">Tenure</td></b>
                                    <td colspan="4" style="border: 1px solid black!important; ">The terminal date of settlement will be <?=DIGITAL_PATTA_TERMINAL_DATE?>, or as modified by Govt. of Assam.</td>
                                </tr>
                            </table>




                            <!--  Area Details -->
                            <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100"  style="margin-top: -17px!important;">
                                <tr style="background-color: #B9F6CA"  class="reza_header_red" >
                                    <td colspan='6'  class="reza_header_red">
                                        <b>LAND LOCATION DETAILS</b>
                                    </td>
                                </tr>
                                <tbody>
                                <?php foreach ($case['patta_info']['chitha_basic'] as $chitha_basic):?>
                                    <tr class="reza_table_text">
                                        <td rowspan="3" style="border: 1px solid black!important; text-align:center;vertical-align: middle;">Boundary Description</td>
                                        <td rowspan="3" style="border: 1px solid black!important; text-align:center;vertical-align: middle;">Dag No (New) <?=$chitha_basic->dag_no?></td>
                                        <td style="border: 1px solid black!important">North</td>
                                        <td style="border: 1px solid black!important">South</td>
                                        <td style="border: 1px solid black!important">East</td>
                                        <td style="border: 1px solid black!important">West</td>
                                    </tr>
                                    <tr class="reza_table_text">
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_n_desc?></td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_s_desc?></td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_e_desc?></td>
                                        <td style="border: 1px solid black!important"><?=$chitha_basic->dag_w_desc?></td>
                                    </tr>
                                    <tr class="reza_table_text">
                                        <td style="border: 1px solid black!important">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_n_dag_no?></td>
                                        <td style="border: 1px solid black!important">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_s_dag_no?></td>
                                        <td style="border: 1px solid black!important">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_e_dag_no?></td>
                                        <td style="border: 1px solid black!important">ULPIN*/Dag No &nbsp;<?=$chitha_basic->dag_w_dag_no?></td>
                                    </tr>
                                <?php endforeach;?>

                                </tbody>
                            </table>
                            <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100" style="margin-top: -17px!important;">
                                <tr align="center" style="background-color: #B9F6CA" class="reza_table_text">

                                    <td colspan="3" width="25%" style="border: 1px solid black!important">
                                        ULPIN*/Geo-coordinates
                                    </td>
                                    <td colspan="3" width="25%" style="border: 1px solid black!important">
                                        Geo Tag Photos
                                    </td>
                                    <td colspan="3" width="25%" style="border: 1px solid black!important">
                                        Google Location
                                    </td>
                                    <td colspan="3" width="25%" style="border: 1px solid black!important">
                                        Land Schedule /Property Sketch
                                    </td>

                                </tr>

                                <tr align="center">
                                    <td colspan="3" style="text-align:center;vertical-align: middle; border: 1px solid black!important ">
                                        <img src=" <?php echo $case['base_64_qr_geo_cordinates'] ?>" alt="qr_code" height="70px" width="70px">
                                    </td>
                                    <td colspan="3" style="border: 1px solid black!important; vertical-align: middle;">
                                        <img src=" <?php echo $case['dag_sketch_qr_photos'] ?>" alt="qr_code" height="70px" width="70px">
                                    </td>
                                    <td colspan="3" style="text-align:center;vertical-align: middle; border: 1px solid black!important ">
                                        <img src=" <?php echo $case['base_64_qr_google'] ?>" alt="qr_code" height="70px" width="70px">
                                    </td>
                                    <td colspan="3" style="text-align:center; border: 1px solid black!important; vertical-align: middle; ">
                                        <img src=" <?php echo $case['base_64_qr_sketch'] ?>" alt="qr_code" height="70px" width="70px">

                                    </td>
                                </tr>
                            </table>




                            <!-- property Details -->
                            <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100" style="margin-top: -17px!important;">
                                <tr style="background-color: #fcd9dd"  class="reza_header_red" >
                                    <td colspan='6'  class="reza_header_red">
                                        <b>PROPERTY DETAILS</b>
                                    </td>
                                </tr>
                                <tr style="background-color: #fcd9dd" class="reza_table_text">
                                    <td style="border: 1px solid black!important">Property Type</td>
                                    <td style="border: 1px solid black!important">Dag No</td>
                                    <td style="border: 1px solid black!important">Built Up Area (Sq.Ft)</td>
                                    <td style="border: 1px solid black!important">Total Area (Sq.Ft)</td>
                                    <td style="border: 1px solid black!important">Property Value (Self Declared)</td>
                                    <td style="border: 1px solid black!important">Property/House Tax (if applicable)</td>
                                </tr>
                                <tbody>
                                <?php foreach ($case['patta_info']['propertyDetails'] as $property) : ?>
                                    <tr class="reza_table_text">
                                        <td style="border: 1px solid black!important"><?php echo $property->property_type ?></td>
                                        <td style="border: 1px solid black!important"><?php echo $property->new_dag_no ?></td>
                                        <td style="border: 1px solid black!important"><?php echo $property->build_up_area ?></td>
                                        <td style="border: 1px solid black!important"><?php echo $property->total_area ?></td>
                                        <td style="border: 1px solid black!important"><?php echo $property->property_value ?></td>
                                        <td style="border: 1px solid black!important"><?php echo $property->tax ?></td>
                                    </tr>
                                    <tr class="reza_table_text">
                                        <td style="border: 1px solid black!important">
                                            Encumbrance Details (If any)
                                        </td>
                                        <td colspan="5" style="border: 1px solid black!important">
                                            <?php echo $property->encumbrance_details ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>



                            <!-- Photo -->
                            <table class="table table-bordered himanxu-table-width-100 himanxu_body_color_maroon" style="margin-top: -17px!important;">
                                <tbody>
                                <tr style="text-align:center;background-color: #fcd9dd"  class="reza_header_red" >
                                    <th colspan="6"  style="border: 1px solid black!important">PHOTO</th>
                                </tr>
                                <?php
                                $all_photo_datas = [];
                                $primary_applicant_data = $case['patta_info']['chitha_pattadar_applicant_data'];
                                $join_applicants = $case['patta_info']['joint_applicant_data'];
                                if($case['patta_info']['applicant_data']->identity_type == 'AADHAAR'){
                                    $all_photo_datas[] = [
                                        'name' => $primary_applicant_data->pdar_name_eng,
                                        'case_no' => $primary_applicant_data->o1_case_no,
                                        //'photo' => $this->digitalPattaPhotoModel->getPrimaryLandHolderImg($case['patta_info']['settlement_applicant'],$case['patta_info']['applicant_data']->ord_no),
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
                                    <tr class="reza_table_text">
                                        <?php
                                        foreach($photoDatas as $photo):
                                            ?>

                                            <td style="border: 1px solid black!important">
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
                                <tr class="reza_table_text">
                                    <td colspan="6" class="text-center " style="text-align:left; border: 1px solid black!important">(Once AADHAR authentication is done, photo will be auto-fetched)</td>
                                </tr>
                                </tbody>
                            </table>



                            <!-- Issuing Authority-->
                            <div class="col-lg-12" style="text-align:right; font-size: 11px" align="right" >
                                <b>Issuing Authority : </b> <b>District Commissioner</b><br>
                                <?php
                                $this->load->model('digitalPatta/DigitalPattaCommonNcModel');
                                $iAName = $this->DigitalPattaCommonNcModel->getIssuingAuthNameNc();?>
                                <b><?=$iAName?></b>
                            </div>
                            <div class="col-lg-12" style="font-size:11px;text-align:center" align="center">
                                <br>
                                <span style="font-style: italic;">
                                Note: This is a system-generated document which does not require any physical signature. The authenticity of this document
                                can be verified by scanning the QR code provided herein
                            </span>
                            </div>

                        </div>
                    </div>
                    <!-- force new page here -->
                    <div class="page-break"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12"  style=" border: 1px solid #4CAF50!important; height: 100%!important;min-height: 99vh!important;">

                        <div class="row" style="padding:20px 10px 1px 10px;">
                            <span style="text-align:center; font-size: 15px!important;"><b><u>TERMS AND CONDITIONS</u></b></span>
                            <table class="table table-bordered himanxu-table-width-100">
                                <tr>
                                    <td align="center" style="text-align: center!important; border: 1px solid black!important">
                                        <b style="text-align:center!important;  vertical-align: middle; font-size: 13px!important;">Sl. No</b>
                                    </td>
                                    <td align="center" style="text-align: center!important; border: 1px solid black!important">
                                        <b style="text-align:center!important; vertical-align: middle; font-size: 13px!important;">Terms And Conditions</b>
                                    </td>
                                </tr>
                                <tbody>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">1</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        Any person who had held as owner, land which exceeds the permissible limit as per any law for time being in force
                                        the aggregate of land held individually by the members of a family or jointly by some or all the members of such a
                                        family, then excess land shall be acquired as per provision of the law
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">2</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        During the change in usage or class of land of the total land or any part thereof with due permission from authority
                                        on payment of premium or penalty as the case may be wherever applicable, the revenue and local taxes now assessed may
                                        be changed by the State Government in accordance with law or rules in force and that shall be payable by the Lease-holder
                                        in prescribed time
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">3</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        If upon the expiry of the lease, the lease-holder does not intend to extend or get issued a fresh lease the State Government
                                        may at any time after the lease period annul the lease or settle the land with any other person as the case may be.
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">4</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        In case of agricultural land, the lease-holder must cultivate the land by himself/themselves as a means of livelihood.
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">5</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        In case of any public path or Government. institutions found on any land held by the lease-holder, the authority will have the
                                        right to take action as per Section 10 of Assam Land Revenue Regulation 1886, treating the said land deemed to have been relinquished
                                        by the lease-holder
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">6</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        In case of new settlement of Government. land, the settlement shall be conferred as a joint title to the husband and wife, if the
                                        applicant is married and also familywise
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">7</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        The Lease- holder shall have a permanent, heritable and transferable right of use and occupancy in the land subject to the reservation in
                                        favour of the State Government of all quarries and of all mines, minerals and mineral oils, and of all buried treasure, with full liberty
                                        to search for and work the same, paying to the leaseholder only compensation for the surface damage as estimated by the District Commissioner.
                                        However, in case of land under Tribal Belt & Blocks, restrictions under Section 164 and Section 164(A) of Assam Land Revenue Regulation 1886
                                        will be also applicable. Further, violation of provisions of Section 164 will invite action as per Section 165 of Assam Land Revenue Regulation 1886.
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">8</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        The Lease-holder shall not transfer as defined under the Transfer of Property Act,1882, the agricultural land outside of town area to any non-agriculturist.
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">9</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        The Lease-holder shall conform to the timely payment of the land revenue from time to time assessed on the said land and of any local rates or cesses etc.
                                        payable from time to time under any law or rules for the time being in force.
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">10</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        The terms and conditions of this lease shall be binding on the heirs, assignees, successors or NOK, of the said lease-holder in the interest
                                        of the State Government and the Lease-holder in all cases
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">11</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        This settlement of land shall be cancelled if it is established at any later stage that such beneficiaries resorted to submission of fraudulent
                                        supporting documents & information including affidavits and in case of settlement of land on realization of premium, amount of premium shall be
                                        forfeited in addition to any other legal action for submission of fraudulent documents & information, false affidavits etc.
                                    </span>
                                    </td>
                                </tr>
                                <tr class="reza_table_text">
                                    <td style="border: 1px solid black!important">12</td>
                                    <td style="text-align: left!important;border: 1px solid black!important">
                                    <span>
                                        Violation of any of the above conditions may result in annulment of the settlement by cancellation of Patta.
                                    </span>
                                    </td>
                                </tr>
                                </tbody>



                            </table>

                        </div>
                        <div class="row" style="padding:0px 10px 1px 10px;">

                            <div class="col-lg-12" style="text-align:right; font-size: 11px" align="right" >
                                <b>Issuing Authority : </b> <b>District Commissioner</b><br>
                                <?php
                                $this->load->model('digitalPatta/DigitalPattaCommonNcModel');
                                $iAName = $this->DigitalPattaCommonNcModel->getIssuingAuthNameNc();?>
                                <b><?=$iAName?></b>
                            </div>

                        </div>
                        <br>
                    </div>
                </div>

                <div class="page-break"></div>

            <?php endforeach; ?>
        </div>

        <div class="col-md-12 mt-3" style="text-align:center; background-color: white" >

            <button type="button" onclick="printDiv('print_div');" id="print" class="rezaButt buttInfo">
                <i class="fa fa-print" aria-hidden="true"></i>
                Print Property Card
            </button>
        </div>

    </div>
</div>



<link href="<?php echo base_url('css/styles.css');?>" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/font-awesome.min.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url('fonts/css/font-awesome.css');?>">

<script>

    function printDiv(divName) {
        // get the div content
        var divContents = document.getElementById(divName).innerHTML;

        // open a new print window
        var printWindow = window.open('', '', 'height=800,width=1000');

        // write full HTML into the new window
        printWindow.document.write('<html><head><title>Print</title>');

        printWindow.document.write(`
            <style>
                @page {
                    size: A4;
                    margin: 5mm;   /* minimum margin */
                }
                body {
                    margin: 5mm;
                }
            </style>
        `);

        // copy all CSS from current document
        var styles = document.querySelectorAll('link[rel="stylesheet"], style');
        styles.forEach((node) => {
            printWindow.document.write(node.outerHTML);
    });

        // close head and open body
        printWindow.document.write('</head><body>');

        // insert the div contents
        printWindow.document.write(divContents);

        // close body
        printWindow.document.write('</body></html>');

        // important: wait until content is loaded
        printWindow.document.close();

        // give browser a tick before printing
        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    }
</script>

</body>
</html>