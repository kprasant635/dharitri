
<style>
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

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
        padding-top: 10px;
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
        padding: 0px;
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
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
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
    .IamReza{
        background-image: linear-gradient(to right, #ed6ea0, #f7186a, #FBB03B);
        box-shadow: 0 4px 15px 0 rgba(252, 104, 110, 0.75);
        border: none;
        font-weight: bolder;
        font-size: 16px;
        color: white;
        padding: 8px;
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
        /*background-color: #848892;*/
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
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
        border: 1px solid #999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative;
    }
    .tree li::before,
    .tree li::after {
        content: "";
        left: -20px;
        position: absolute;
        right: auto;
    }
    .tree li::before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px;
    }
    .tree li::after {
        border-top: 1px solid #999;
        height: 20px!important;
        top: 25px;
        width: 25px;
    }
    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #999;
        border-radius: 5px;
        display: inline-block;
        padding: 3px 8px;
        text-decoration: none;
    }
    .tree li.parent_li > span {
        cursor: pointer;
    }
    .tree > ul > li::before,
    .tree > ul > li::after {
        border: 0;
    }
    .tree li:last-child::before {
        height: 46px;
    }
    .tree li.parent_li > span:hover,
    .tree li.parent_li > span:hover + ul li span {
        background: #eee;
        border: 1px solid #94a0b4;
        color: #000;
    }


    .rezaSpan{
        min-width: 140px;
        padding-left: 15px;
    }
    .rezaSpanB{
        min-width: 100px;
        padding-left: 15px;
    }
    .rezaCaseSpan{
        min-width: 270px;
        padding-left: 15px;
    }
    .rezaCaseSpanTotal{
        min-width: 270px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanBTotal{
        min-width: 100px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanTotal{
        min-width: 140px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }



    .badge-reza1{
        background-color: #F44336;
    }
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #9C27B0;
    }


</style>

<style>
    .tooltip-th {
        position: relative;
        display: inline-block;
        cursor: help;
    }

    .tooltip-th .tooltip-text {
        visibility: hidden;
        width: 180px;
        background-color: #f44336;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 6px;
        position: absolute;
        z-index: 1;
        top: -35px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip-th:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
</style>

<div class="container">
<div class="row">

<h5 class="bgheading p-2 text-white shadow" style="background: #248cf7 !important; margin-top: 10px">
        Offering Reclassification Suite (
        <small><span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span></small> )
    </h5>
    <div class="reza-card">
        <div class="reza-body">
            <h5 class="reza-title" style="margin-top: 15px">
                <i class="fa fa-file-text"></i>  Application Details
            </h5>

            <input type="hidden" id="case_no" name="case_no" value="<?=$basic['case_no']?>">
            <div class="tableCard">
                <div class="row justify-content-center">
                    <?php
                    if(isset($base64_decoded_adhar_file)){
                        ?>
                        <div class="col-md-2">
                            <?=$base64_decoded_adhar_file;?>
                        </div>

                    <?php }?>
                    <div class="col-md-10">
                        <table class="table table-bordered">

                            <?php
                            foreach ($applicants_buyers as $identity):
                                if($identity->is_applicant == 1){
                                    ?>
                                    <tr>
                                        <th>
                                            Name in <?=$identity->identity_type?>
                                        </th>
                                        <td>
                                            <strong class="alert-warning"><?=$identity->eng_pdar_name?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?=$identity->identity_type?> Verified</th>
                                        <td>
                                            <strong class="alert-warning"> <?php if(!empty($identity->identity_ref_no)) {echo 'Yes';}?></strong>
                                        </td>
                                    </tr>
                                <?php }
                            endforeach;
                            ?>


                            <tr>
                                <th>Occupation or Profession of the applicant</th>
                                <td>
                                    <strong class="alert-warning"><?=$basic["occupation_applicant"]?></strong>
                                </td>
                            </tr>
                            <?php
                            //if($basic['protected_class']):
                            ?>
                            <!-- <tr>
                                <th>Select if you fall under protected category?</th>
                                <td>
                                    <input type="hidden" name="protected_class" value="<?=$basic['protected_class']?>" class="form-control">
                                    <strong class="alert-warning">
                                        <?php
                            foreach(json_decode(PROTECTED_CLASS) as $class12){


                                if($class12->CODE == $basic['protected_class']){
                                    echo $class12->NAME;
                                }
                            }
                            ?>
                                    </strong>
                                </td>
                            </tr> -->
                            <?php //endif;?>
                            
                            <?php if (isset($backup_under_tribe_belts)) { ?>
                                <tr>
                                    <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                                    <td>
                                        <strong class="alert-warning"><?php
                                            if($backup_under_tribe_belts == '1'){
                                                ?>
                                                YES
                                                <?php
                                            }else{
                                                ?>
                                                NO
                                                <?php
                                            }
                                            ?></strong>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-map-marker"></i> Address Information
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <tr>
                        <th>District Name:</th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getDistrictName($basic["dist_code"])?>
                            </strong>
                        </td>
                        <th>Subdivision Name:</th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getSubDivName($basic["dist_code"], $basic["subdiv_code"])?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Circle Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?>
                            </strong>
                        </td>
                        <th>Mouza Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Village Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?>
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>

            <h5 class="reza-title" style="margin-top: 50px">

                <i class="fa fa-pencil-square-o"></i> Self declaration details
                <button class="btn btn-sm btn-warning btn-api-call" onclick="showSelfAndDocument()" type="button"><i class="fa fa-university"></i>&nbsp;View Self declaration</button>
            </h5>
            <div class="tableCard">
                <table class="table table-bordered" id="selfdeclaration">
                    <!-- <?php
                    foreach ($selfDeclarationDetails[0] as $key => $self) {
                        ?>
                        <tr>
                            <th><?=$self->name?></th>
                            <td class="text-center">
                                <strong>
                                    <?php if ($self->status == "1") {echo "Yes";}?>
                                    <?php if ($self->status == "0") {echo "No";}?>
                                </strong>
                            </td>
                        </tr>
                    <?php }?> -->
                </table>
            </div>



            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user"></i>  Applicant details
            </h5>
            <?php $i = 1;foreach ($applicants_buyers as $settlement): ?>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr >
                            <th rowspan="6" style="vertical-align : middle;text-align:center; min-width: 4%!important; max-width: 4%!important; width: 4%">
                                <?=$i;?>
                            </th>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Applicant Name ( Assamese)</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_name;?>
                                </strong>
                            </td>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Guardian name (Assamese)</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_guardian;?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Applicant Name (English)</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->eng_pdar_name;?>
                                </strong>
                            </td>
                            <th>Guardian Name (English)</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->eng_pdar_guardian;?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Relation</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    foreach ($guar_rel as $guar_rel_list) {
                                        if ($guar_rel_list->id == $settlement->pdar_rel_guar) {
                                            echo $guar_rel_list->guard_rel_desc_as;
                                        }
                                    }
                                    ?>
                                </strong>
                            </td>
                            
                        </tr>

                        <tr>
                            <?php if($settlement->is_applicant == 1): ?>
                                <th>Marital Status</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php
                                        foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                            if($marital_stat->CODE == $settlement->marital_status){
                                                ?>
                                                <?=$marital_stat->NAME?>
                                                <?php
                                            } }
                                        ?>
                                    </strong>
                                </td>
                            <?php endif;?>
                            <th>Mobile</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_mobile?>
                                </strong>
                            </td>

                        </tr>

                        <tr>
                            <th>DOB</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->dob?>
                                </strong>
                            </td>
                        </tr>

                        <?php

                        $pre_addr = json_decode($settlement->pdar_add1);
                        $per_addr = json_decode($settlement->pdar_add2);
                        ?>


                        <tr>
                            <th>Present address</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$pre_addr?>
                                </strong>
                            </td>
                            <th>
                                Permanent address
                            </th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$per_addr?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php $i++;?>
            <?php endforeach;?>


            <?php if(isset($basic["bhumiputra_certificate_no"])){?>

                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bhumiputra certificate/Ack verified?</th>
                            <td>
                                <?php if(trim($basic['bhumiputra_confirmation']) == YES) : ?>
                                    <b>Yes </b>
                                <?php else: ?>
                                    <b>No </b>
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="hidden" name="bhumiputra_certificate_no" value="<?=$basic["bhumiputra_certificate_no"]?>">
                                Certificate/Ack number : <b><?=$basic["bhumiputra_certificate_no"]?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php }?>


            <?php if (!empty($nominee)) {?>
                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-users"></i>  Family Details
                </h5>
                <div class="tableCard">
                    <table class="table  table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Relation</th>
                            <th>Address</th>
                            <th>Mobile number</th>
                        </tr>
                        <?php $i = 1;foreach ($nominee as $kin): ?>
                            <tr id="sp<?=$kin->id?>">
                                <td>
                                    <input type="text" readonly name="kin_name" value="<?=$kin->nominee_name?>" class="form-control">
                                </td>
                                <td>
                                    <input type="text" readonly name="kin_relation" value="<?=$this->utilityclass->appRelationbyIDMB2($kin->relation)?>" class="form-control">
                                </td>
                                <td>
                                    <input type="text" readonly class="form-control" value="<?=$kin->address?>" name="kin_address">
                                </td>
                                <td>
                                    <input type="text" readonly name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control">
                                </td>

                            </tr>
                            <?php $i++;?>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php }?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-map"></i>  Area Details
            </h5>
            <div class="tableCard">
                <table class="table">
                    <thead class="thead-warning">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th class="text-center">Bigha</th>
                        <th class="text-center">Katha</th>
                        <th class="text-center">Lessa</th>
                        <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <th class="text-center">Ganda</th>
                            <th class="text-center">Kranti</th>
                        <?php endif; ?>
                    </tr>

                    <?php foreach ($dags as $all_dags) {?>

                        <tr class="bg-white">
                            <th>
                                <div >
                                    DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> |
                                    PATTA : <span class="text-danger"><?=$all_dags->patta_no?> </span> |
                                    <span class="text-danger">
                                        <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?>
                                    </span>
                                </div>
                            </th>
                            <td><strong>Total Land Area in Selected Dag</strong></td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_k" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" >
                            </td>
                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" >
                                </td>
                                <td class="hide" style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_kr?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" >
                                </td>
                            <?php endif ; ?>
                        </tr>



                        <!-- area settlement homestead -->
                        <?php $hide = 'area_show';
                        if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                            $hide = 'area_show';
                        } else {
                            $hide = 'area_hide';
                        }
                        ?>
                        <!-- <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Applied Area</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->s_dag_area_b?></strong>
                                <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_dags->s_dag_area_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->s_dag_area_k?></strong>
                                <input type="hidden" style="text-align: center;" name="home_k" value="<?=$all_dags->s_dag_area_k?>" class="form-control input-sm home_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->s_dag_area_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$all_dags->s_dag_area_lc?>" class="form-control input-sm home_lc" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->s_dag_area_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->s_dag_area_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->s_dag_area_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->s_dag_area_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr> -->



                    <?php } ?>

                    <?php
                    // for dag not eligible
                    //include(APPPATH."views/SettlementView/include/dagNotEligibleCoView.php");
                    ?>

                    </thead>
                </table>

            </div>


            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-map"></i>  Reclassification Details
            </h5>
            <div class="tableCard">
                <!-- new premium addition -->


                <table class="table mb-0">
                    <thead class="thead-warning">
                    <tr>
                        <th>#</th>
                        <th>Dag No</th>
                        <th class="text-center">Reclass Type</th>
                        <th class="text-center">OLd Land Class</th>
                        <th class="text-center">Proposed Land Class</th>
                        <th class="text-center">Purpose of Reclass</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($dags as $dagspremlm){ ?>
                    <tr>
                        <td></td>
                        <td class="bg-white">
                            <strong><?=$dagspremlm->dag_no?></strong>
                        </td>
                        <td class="bg-white text-center">
                            <strong style="color:red"><?=($dagspremlm->is_full_partial=='N')?'FULL DAG':'PARTIAL DAG'?></strong>
                        </td>
                        <td class="bg-white text-center">
                            <strong>
                                <?=$dagspremlm->exist_land_class_name?>
                            </strong>
                        </td>

                        <td id="proc_lc_name<?=$dagspremlm->dag_no?>" class="bg-white text-center">
                        <strong><?=$dagspremlm->proposed_land_class_name?></strong><br>
                        </td>
                        <td class="bg-white text-center">
                        <strong>
                        <?php 
                            $reclass_purpose = json_decode($dagspremlm->reclass_purpose, true);

                            // If decode gives a string, try decoding again
                            if (is_string($reclass_purpose)) {
                                $reclass_purpose = json_decode($reclass_purpose, true);
                            }

                            if (is_array($reclass_purpose)) {
                                echo implode(', ', $reclass_purpose);
                            }
                            ?>
                        </strong><br>
                        </td>
                        <?php }?>
                    </tbody>
                </table>
                <br>
                <?php foreach($dags as $dagspremlm){ ?>
                <?php if($dagspremlm->is_full_partial=='Y'){?>
                <table class="table mb-0">
                    <thead class="thead-warning">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Dag</th>
                        <th class="text-center">Bigha</th>
                        <th class="text-center">Katha</th>
                        <th class="text-center"><?=$lessa_chatak?></th>

                    </tr>
                    </thead>
                    <tr>
                        <th rowspan="6" style="vertical-align : middle;">

                        </th>
                        <th class="bg-white">Applied Land Area in Selected Dag</th>
                        <td class="bg-white">
                            <strong>
                                <?=$dagspremlm->dag_no?>
                            </strong>
                        </td>
                        <td class="bg-white">
                            <strong>
                                <input type="text" style="text-align: center;" name="dag_area_b<?=$dagspremlm->dag_no?>" id="dag_area_b<?=$dagspremlm->dag_no?>" class="form-control input-sm" value="<?=$dagspremlm->s_dag_area_b;?>" readonly>
                            </strong>
                        </td>
                        <td class="bg-white">
                            <input type="text" style="text-align: center;" name="dag_area_k<?=$dagspremlm->dag_no?>" id="dag_area_k<?=$dagspremlm->dag_no?>" value="<?=$dagspremlm->s_dag_area_k;?>" class="form-control input-sm" readonly>
                        </td>
                        <td class="bg-white">
                            <input type="text" style="text-align: center;" name="dag_area_lc<?=$dagspremlm->dag_no?>" id="dag_area_lc<?=$dagspremlm->dag_no?>" class="form-control input-sm" value="<?= $dagspremlm->s_dag_area_lc;?>" readonly>
                        </td>
                        <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                            <td class="bg-white">
                                <input type="text" style="text-align: center;" value="<?=$dagspremlm->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$dagspremlm->dag_no?>" id="dag_area_g<?=$dagspremlm->s_dag_area_g?>" readonly>
                            </td>
                            <td class="bg-white hide">
                                <input type="text" style="text-align: center;" value="<?=$dagspremlm->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$dagspremlm->dag_no?>" id="dag_area_kr<?=$dagspremlm->s_dag_area_kr?>" readonly>
                            </td>
                        <?php endif;?>
                    </tr>
                    <?php }}?>


                </table>
                <!-- this only to display the error message in area validation -->
                <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                <br>
            </div>

            <?php if($basic['is_partition_done']=='Y'){?>

                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-map"></i>  Partition Details
                </h5>
                <div class="tableCard">
                    <!-- new premium addition -->


                    <table class="table mb-0">
                        <thead class="thead-warning">
                        <tr>
                            <th>#</th>
                            <th>Old Dag No</th>
                            <th>Old Patta No</th>
                            <th class="text-center">New Dag No</th>
                            <th class="text-center">New Patta No</th>
                            <th class="text-center">Partition Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dags as $dagspremlm){
                        if($dagspremlm->is_full_partition=='Y' || $dagspremlm->is_partition=='Y'){?>
                        <tr>
                            <td></td>
                            <td class="bg-white">
                                <strong><?=$dagspremlm->dag_no?></strong>
                            </td>
                            <td class="bg-white text-center">
                                <strong>
                                    <?=$dagspremlm->patta_no?>
                                </strong>
                            </td>
                            <td class="bg-white text-center">
                                <strong>
                                    <?=$dagspremlm->new_dag?>
                                </strong>
                            </td>
                            <td class="bg-white text-center">
                                <strong>
                                    <?=$dagspremlm->new_patta?>
                                </strong>
                            </td>
                            <td class="bg-white text-center">
                                <strong style="color:red"><?=($dagspremlm->is_full_partition=='Y' && $dagspremlm->is_partition=='Y')?'FULL DAG PARTITION':'PARTIAL PARTITION'?></strong>
                            </td>


                            <?php }}?>
                        </tbody>
                    </table>
                    <br>



                    </table>
                    <!-- this only to display the error message in area validation -->
                    <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                    <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                    <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                    <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                    <br>
                </div>
            <?php }?>


             <table class="table mb-0 mx-auto" style="width: 100%;">
    <thead class="thead-warning">
        <tr>
            <th>#</th>
            <th>Zonal Value</th>
            <th>Dag No</th>
            <th>Reclass Type</th>
            <th>Rate</th>
            <th>Premium</th>
            <th>Waiver</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($premium_data as $index => $dagspremco) { ?>
            <tr>
                <td><?= $index + 1; ?></td>
                <td>
                    <span style="color:blue; font-weight:bold;">
                        <?= $dagspremco->zonal_valuation; ?>
                    </span>
                </td>
                <td><?= $dagspremco->dag_no ?></td>
                <td>
                    <span style="color:red; font-weight:bold;">
                        Full DAG Reclass
                    </span>
                </td>
                <td>10%</td>
                <td><?= $dagspremco->amount_dag ?></td>
                <td>
                   <?php
                    $reclass_purpose = json_decode($dagspremco->reclass_purpose, true);

                    // Handle double-encoded case
                    if (is_string($reclass_purpose)) {
                        $reclass_purpose = json_decode($reclass_purpose, true);
                    }

                    if (is_array($reclass_purpose) && in_array("Others", $reclass_purpose) && count($reclass_purpose) == 1) {
                        echo 'Nill';
                    } else {
                        echo '50%';
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right; font-weight:bold;">Total Premium</td>
            <td colspan="2" style="font-weight:bold; color:green;">
                <?= number_format($dagspremco->final_amount, 2); ?>
            </td>
        </tr>
    </tfoot>
</table>



            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Supporting Documents
                <button class="btn btn-sm btn-warning btn-api-call" onclick="showSelfAndDocument()" type="button"><i class="fa fa-university"></i>&nbsp;View Supporting Documents</button>
            </h5>
            <div class="tableCard">
                <table class="table table-bordered" id="apidoc">
                    <?php //foreach ($document as $d): ?>
                    <!-- <tr>
                            <th>
                                <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                            </th>
                        </tr> -->
                    <?php //endforeach;?>
                </table>
            </div>
            <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
        </div>
    </div>
</div>
</div>

<script>

    function showSelfAndDocument(popupId) {

        var case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no': case_no,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'Mb3CommonController/getSelfDocApi',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);

                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }else{

                    const selfContainer = $('#selfdeclaration');
                    for(var i = 0; i < arr.selfDeclarationDetails[0].length; i++)
                    {
                        if(arr.selfDeclarationDetails[0][i].id==10)
                        {
                            if(arr.selfDeclarationDetails[0][i].status == '1'){
                                $yesno='SC/ST';
                            }else if(arr.selfDeclarationDetails[0][i].status == '0'){
                                $yesno='GEN';
                            }else{
                                $yesno='';
                            }
                        }

                        else if(arr.selfDeclarationDetails[0][i].id==11)
                        {
                            if(arr.selfDeclarationDetails[0][i].status == '1'){
                                $yesno='Agricultural';
                            }else if(arr.selfDeclarationDetails[0][i].status == '0'){
                                $yesno='Non Agricultural';
                            }else if(arr.selfDeclarationDetails[0][i].status == '0'){
                                $yesno='Barren land';
                            }
                        }

                        else{
                            if(arr.selfDeclarationDetails[0][i].status == '1'){
                                $yesno='YES';
                            }else if(arr.selfDeclarationDetails[0][i].status == '0'){
                                $yesno='NO';
                            }else{
                                $yesno='';
                            }
                        }

                        const selfd = $('<tr><th>'+arr.selfDeclarationDetails[0][i].name+'</th><td class="text-center"><strong>'+$yesno+'</strong></td></tr>');

                        selfContainer.append(selfd);
                    }

                    const docContainer = $('#apidoc');
                    for(var x = 0; x < arr.document.length; x++)
                    {
                        const doclink = $('<a>', {
                            href: baseurl+'SettlementCommon/documentmb3/'+arr.document[x].name,
                            text: '' + arr.document[x].file_details,
                            target:'_blank'
                        });

                        docContainer.append(doclink).append('<br>');
                    }

                    // $("#aadhartype").show();
                    // $("#aadhartype").append("in " + arr.aadhar.type);
                    $(".btn-api-call").hide();


                }
            }
        });
    }
</script>