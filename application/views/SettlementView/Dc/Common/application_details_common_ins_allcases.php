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

<!-- Masud's CSS-->
<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttSuccess {
        color: #FFF;
        background-color: #388E3C;
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
        padding: 2px 1rem;
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

<script>
    $(document).ready(function () {
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

</script>

<div class="container">
    <div class="row">
        <section>
            <input type="hidden" id="caseNoHidden" name="caseNoHidden" value="<?php echo $basic['case_no']?>" >
            <input type="hidden" id="case_no" value="<?php echo $basic['case_no']?>" >
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" role="tablist">
                        <li role="presentation" class="active">
                            <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                <span class="round-tab"><strong>Application</strong></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                <span class="round-tab"><strong>LRA Report</strong></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#proceedings" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                <span class="round-tab"><strong>Proceedings</strong></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#history" data-toggle="tab" aria-controls="history" role="tab" title="history">
                                <span class="round-tab"><strong>History</strong></span>
                            </a>
                        </li>
                        <?php if(!empty($premium_data)) { ?>
                            <li role="premium">
                                <a href="#premium" data-toggle="tab" aria-controls="premium" role="tab" title="premium">
                                    <span class="round-tab"><strong>Premium</strong></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($newDagCount == 1): ?>
                            <li role="newDag">
                                <a href="#newDag" data-toggle="tab" aria-controls="newDag" role="tab" title="newDag">
                                    <span class="round-tab"><strong>New Dag</strong></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="tab-content">
                    <?php
                    include(APPPATH."views/SettlementView/include/applicationInsViewallcases.php");
                    ?>

                    <div class="tab-pane" role="tabpanel" id="proceedings">


                        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            <?php echo NJS_TAGLINE ?> (
                                <span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title" style="margin-top: 15px"><i class="fa fa-check"></i> Primary Information Entered by CO (চক্ৰ বিষয়া.-ৰ দ্বাৰা প্ৰবিষ্ট কৰা প্ৰাথমিক তথ্য)</h5>
                                <div class="row p-2">
                                    
                                    <div class="col-md-6">
                                       <i class="fa fa-arrow-circle-right"></i> Category
                                    </div>
                                    <div class="col-md-6">
                                        <b><?php if(isset($instituteDetails->category_name))
                                        {
                                            echo $instituteDetails->category_name;
                                        } 
                                        ?></b>
                                    </div>
                                        
                                </div>
                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <i class="fa fa-arrow-circle-right"></i>Name of the institution (English)
                                    </div>
                                    <div class="col-md-6">
                                        <b><?php if(isset($instituteDetails->ins_name_co))
                                        {
                                            echo $instituteDetails->ins_name_co;
                                        } 
                                        ?>
                                    </b>
                                    </div>
                                        
                                </div>
                                <div class="row p-2">
                                    <div class="col-md-6">
                                       <i class="fa fa-arrow-circle-right"></i> Name of the institution (অসমীয়া)
                                    </div>
                                    <div class="col-md-6">
                                        <b><?php if(isset($instituteDetails->ins_name_assamese))
                                        {
                                            echo $instituteDetails->ins_name_assamese;
                                        } 

                                        ?>
                                    </b>
                                    </div>
                                        
                                </div>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <i class="fa fa-arrow-circle-right"></i> Purpose of which land applied for
                                    </div>
                                    <div class="col-md-6">
                                        <b><?php if(isset($instituteDetails->purpose_land_allot_co))
                                        {
                                            echo $instituteDetails->purpose_land_allot_co;
                                        } 
                                        else
                                        {
                                            echo "NA";
                                        }
                                        ?>
                                        </b>
                                    </div>
                               
                                        
                                </div>
                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <i class="fa fa-arrow-circle-right"></i> Sub type details
                                    </div>
                                    <div class="col-md-6">
                                        <b><?php if(isset($instituteDetails->other_subtype_details_co) && $instituteDetails->other_subtype_details_co != null)
                                        {
                                            echo $this->utilityclass->ins_sub_type($instituteDetails->other_subtype_details_co);
                                        } 
                                        else
                                        {
                                            echo "NA";
                                        }
                                        ?>
                                        </b>
                                    </div>
                               
                                        
                                </div>
                                <?php 
                                    $stName = '';
                                    $stNameShowHide = "show";
                                    if($instituteDetails->ins_cat_type_co == 8 || $instituteDetails->ins_cat_type_co == 9)
                                    {
                                        $stName = "State";
                                        $stNameShowHide = "show";
                                    }
                                    else if($instituteDetails->ins_cat_type_co == 10 || $instituteDetails->ins_cat_type_co == 11)
                                    {
                                        $stName = "Central";
                                        $stNameShowHide = "show";
                                    }
                                    else
                                    {
                                        $stNameShowHide = "hide";
                                    }
                                    ?>

                                    <?php if(isset($instituteDetails->ministry_of_co) && $instituteDetails->ministry_of_co != null) {?>
                                    <div class="row p-2 <?=$stNameShowHide?>">
                                        <div class="col-md-6">
                                            
                                            <i class="fa fa-arrow-circle-right"></i> Ministry
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if(isset($instituteDetails->ministry_of_co) && $instituteDetails->ministry_of_co != null)
                                            {
                                                echo $instituteDetails->ministry_of_co;
                                            }
                                            else
                                            {
                                                echo "N/A";
                                            }
                                            ?>
                                        </b>
                                        </div>
                                            
                                    </div>
                                <?php } ?>
                                    <div class="row p-2 <?=$stNameShowHide?>">
                                        <div class="col-md-6">
                                            
                                            <i class="fa fa-arrow-circle-right"></i><?=$stName?> Department (English)
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if(isset($instituteDetails->dept_of_co) && $instituteDetails->dept_of_co != null)
                                            {
                                                echo $instituteDetails->dept_of_co;
                                            }
                                            else
                                            {
                                                echo "N/A";
                                            }
                                            ?>
                                        </b>
                                        </div>
                                            
                                    </div>
                                    <div class="row p-2 <?=$stNameShowHide?>">
                                        <div class="col-md-6">
                                           <i class="fa fa-arrow-circle-right"></i> <?=$stName?> Department (অসমীয়া)
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if(isset($instituteDetails->dept_of_co_assamese) && $instituteDetails->dept_of_co_assamese != null)
                                            {
                                                echo $instituteDetails->dept_of_co_assamese;
                                            }
                                            else
                                            {
                                                echo "N/A";
                                            }
                                            ?>
                                        </b>
                                        </div>
                                            
                                    </div>

                                    <div class="row p-2 <?=$stNameShowHide?>">
                                        <div class="col-md-6">
                                           <i class="fa fa-arrow-circle-right"></i> <?=$stName?> Directorate Name
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if(isset($instituteDetails->directorate_name) && $instituteDetails->directorate_name != null)
                                            {
                                                echo $instituteDetails->directorate_name;
                                            }
                                            else
                                            {
                                                echo "N/A";
                                            }
                                            ?>
                                        </b>
                                        </div>
                                            
                                    </div>
                                    <div class="row p-2 <?=$stNameShowHide?>">
                                        <div class="col-md-6">
                                           <i class="fa fa-arrow-circle-right"></i> <?=$stName?> Undertaking Board/Corporation Name
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if(isset($instituteDetails->undertaking_board_co) && $instituteDetails->undertaking_board_co != null)
                                            {
                                                echo $instituteDetails->undertaking_board_co;
                                            }
                                            else
                                            {
                                                echo "N/A";
                                            }
                                            ?>
                                        </b>
                                        </div>
                                            
                                    </div>
                                
                                <?php if($instituteDetails->purpose_land_allot_co == 'others')
                                { ?>
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            Others details
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if(isset($instituteDetails->other_purpose_land_allot_co))
                                            {
                                                echo $instituteDetails->other_purpose_land_allot_co;
                                            } 
                                            else
                                            {
                                                echo "NA";
                                            }
                                            ?>
                                            </b>
                                        </div>  
                                    </div>
                                <?php } ?>

                                <?php if(isset($instituteDetails->state_warehousing_corporation) && ($instituteDetails->state_warehousing_corporation =='N' || $instituteDetails->state_warehousing_corporation == 'Y')){ ?>
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            <i class="fa fa-arrow-circle-right"></i> Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals etc. like State Warehousing corporation(SWHC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if($instituteDetails->state_warehousing_corporation == 'Y')
                                            {
                                                echo "Yes";
                                            } 
                                            else
                                            {
                                                echo "No";
                                            }
                                            ?>
                                            </b>
                                        </div>  
                                    </div>
                                    <?php } ?>

                                    <?php if(isset($instituteDetails->central_health_education_skill_sector) && ($instituteDetails->central_health_education_skill_sector =='N' || $instituteDetails->central_health_education_skill_sector == 'Y')){ ?>
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            <i class="fa fa-arrow-circle-right"></i> Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development, within the meaning of DoR&DM Office Memorandum  No.ECF.106184/2019/9 dated 07-07-2021
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if($instituteDetails->central_health_education_skill_sector == 'Y')
                                            {
                                                echo "Yes";
                                            } 
                                            else
                                            {
                                                echo "No";
                                            }
                                            ?>
                                            </b>
                                        </div>  
                                    </div>
                                    <?php } ?>

                                    <?php if(isset($instituteDetails->central_cwc_sector) && ($instituteDetails->central_cwc_sector =='N' || $instituteDetails->central_cwc_sector == 'Y')){ ?>
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            <i class="fa fa-arrow-circle-right"></i> Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals etc. like Food Corporation of India(FCI),Central Warehousing Corporation(CWC) etc which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if($instituteDetails->central_cwc_sector == 'Y')
                                            {
                                                echo "Yes";
                                            } 
                                            else
                                            {
                                                echo "No";
                                            }
                                            ?>
                                            </b>
                                        </div>  
                                    </div>
                                    <?php } ?>


                                    <?php if(isset($instituteDetails->non_govt_profit_making_yes_no) && ($instituteDetails->non_govt_profit_making_yes_no =='N' || $instituteDetails->non_govt_profit_making_yes_no == 'Y')){ ?>
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            <i class="fa fa-arrow-circle-right"></i> Is the Non Govt. Educational Institution of public nature which is devoted to public purposes and which yield no return to private individuals (non profit making) within the meaning of DoR&DM letter No RSR.9/88/Pt.II/64 dated 25-05-1999.
                                        </div>
                                        <div class="col-md-6">
                                            <b><?php if($instituteDetails->non_govt_profit_making_yes_no == 'Y')
                                            {
                                                echo "Yes";
                                            } 
                                            else
                                            {
                                                echo "No";
                                            }
                                            ?>
                                            </b>
                                        </div>  
                                    </div>
                                    <?php } ?>

                                    <?php if( $instituteDetails->ins_cat_type_co == 12 && ($instituteDetails->commercial_purpose_non_govt =='N' || $instituteDetails->commercial_purpose_non_govt == 'Y' || $instituteDetails->commercial_purpose_non_govt == null)){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <i class="fa fa-arrow-circle-right"></i> Is the Land applied for used for religious or charitable purposes and other public utilities or amenities - please refer to section 16(e) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->commercial_purpose_non_govt == 'Y')
                                                {
                                                    echo "Yes";
                                                } 
                                                else
                                                {
                                                    echo "No";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->ins_cat_type_co != 12 && ($instituteDetails->commercial_purpose_govt =='N' || $instituteDetails->commercial_purpose_govt == 'Y' || $instituteDetails->commercial_purpose_govt ==null)){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <i class="fa fa-arrow-circle-right"></i> Is the  land applied for, is or will be used or  transferred for commercial purposes- please refer to section 16(b) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015 
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->commercial_purpose_govt == 'Y')
                                                {
                                                    echo "Yes";
                                                } 
                                                else
                                                {
                                                    echo "No";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>
                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                                </h5>

                                <?php if($proceedings){ ?>
                                    <div class="tableCard" style="margin-top: 20px">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 200px">Remark Date</th>
                                                <th style="width: 200px">Remark Time</th>
                                                <th style="width: 200px">Remark from</th>
                                                <th>Remark</th>
                                            </tr>
                                            <?php foreach($proceedings as $pro):  ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                                                        <?= date ("d-M-Y",strtotime($pro->date_entry)) ?>
                                                    </td>
                                                    <td style="text-transform: uppercase">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;
                                                        <?= date ("h:i a",strtotime($pro->date_entry)) ?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                        <?=$pro->office_from;?>
                                                    </td>
                                                    <td><?=$pro->note_on_order;?></span></td>
                                                </tr>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                    <br><br>

                                <?php } ?>


                            </div>
                        </div>
                        <ul class="list-inline pull-right"  style="margin-top: 20px">
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
                    </div>
                    <div class="tab-pane" role="tabpanel" id="history">
                        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            <?php echo NJS_TAGLINE ?> (
                                <span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title"  style="margin-top: 15px">
                                    <i class="fa fa-history" aria-hidden="true"></i> Case History
                                </h5>
                                <div class="tableCard">

                                    <div class="timeline" style="margin-bottom: 15px">

                                        <?php foreach($proceedings as $pro): ?>

                                            <?php if($pro->status == MB_FINAL): ?>

                                                <div class="timeline__content" style="background-color: #4CAF50">
                                                    <span class="content_tag" style="margin-top: 15px; background-color: white; color: #4CAF50">
                                                        Application Approved
                                                    </span>
                                                    <span class="content_date" style="color: white; margin-top: 7px">
                                                        <?= date ("F j, Y",strtotime($pro->date_entry)) ?>
                                                        <br>
                                                        By <?=$pro->office_from;?>
                                                    </span>
                                                </div>

                                            <?php elseif($pro->status == MB_DISMISS): ?>

                                                <div class="timeline__content" style="background-color: #EF5350">
                                                    <span class="content_tag" style="margin-top: 15px; background-color: white; color: #EF5350">
                                                        Application Rejected
                                                    </span>
                                                    <span class="content_date" style="color: white; margin-top: 7px">
                                                       <?= date ("F j, Y",strtotime($pro->date_entry)) ?>
                                                        <br>
                                                         By <?=$pro->office_from;?>
                                                    </span>
                                                </div>

                                            <?php else : ?>

                                                <div class="timeline__content" >

                                                    <span class="content_tag" style="background-color: #AB47BC; color: white">
                                                        <?php if($pro->task != ''): ?>
                                                            <?=$pro->task ;?>
                                                        <?php else: ?>
                                                            Not Defined
                                                        <?php endif ?>
                                                    </span>
                                                    <span style="margin-top: 30px"></span>
                                                    <span class="content_date" >
                                                        On <?= date ("F j, Y",strtotime($pro->date_entry)) ?>
                                                    </span>
                                                    <span class="content_Name" >
                                                        By&nbsp;
                                                        <?php if($pro->office_from != ''): ?>
                                                            <?=$pro->office_from;?>
                                                        <?php else: ?>
                                                            Not Defined
                                                        <?php endif ?>
                                                    </span>
                                                </div>

                                            <?php endif; ?>

                                        <?php endforeach; ?>


                                    </div>

                                </div>

                            </div>
                        </div>
                        <ul class="list-inline pull-right"  style="margin-top: 20px">
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
                    </div>
                    <?php if(!empty($premium_data)) { ?>
                        <div class="tab-pane" role="tabpanel" id="premium">

                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                <?php echo NJS_TAGLINE ?> 
                                (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                            </h5>
                            <div class="reza-card ">
                                <div class="reza-body">

                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-money" aria-hidden="true"></i> Premium Calculation
                                    </h5>
                                

                                    <div class="tableCard " style="padding: 25px!important;">
                                        <?php foreach ($premium_data as $dagsprem) {?>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <input type="number" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                                           class="form-control"
                                                           value="<?=$dagsprem->zonal_valuation?>" readonly/>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <?php if($dagsprem->ins_reclass_proposed != null){ ?>
                                                
                                                    <div class="form-group col-md-6 ">
                                                        <label>Reclassification Premium for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control" id="reclass_prem" name='reclass_prem<?=$dagsprem->dag_no?>' value="<?=$dagsprem->ins_reclass_amount?>" readonly>

                                                    </div>
                                                 
                                            <?php } ?>
                                            </div> 
                                            <div class="row">
                                            <?php if($instituteDetails->ins_cat_type_co == 10 || $instituteDetails->ins_cat_type_co == 11){ ?>
                                                
                                                    <div class="form-group col-md-6 ">
                                                        <label>Land revenue for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control" id="landrevenue_prem" name='landrevenue_prem<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_revenue_years?>" readonly>

                                                    </div>
                                                 
                                            <?php } ?>
                                            </div> 
                                            

                                            <!-- <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label>Selected Area</label>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" id="prem_area" name='area<?=$dagsprem->dag_no?>' value="<?=$dagsprem->area?>" readonly>

                                                </div>
                                            </div> -->
                                            <!-- <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Purpose of Land</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" name='land_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_type?>" readonly>
                                                </div>
                                            </div> -->
                                            <!-- <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Encroached land type</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" id="prem_landtype" name='rate_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->house_type?>" readonly>

                                                </div>
                                            </div> -->
                                            <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                                            </div>
                                            <!-- <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Is ST/SC/Widows/Person with disabilities?</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php if($dagsprem->concession =='YES') { ?>
                                                        <label for="html">YES</label>
                                                    <?php } else if ($dagsprem->concession =='NO') { ?>
                                                        <label for="css">NO</label>
                                                    <?php } ?>
                                                    <br>
                                                </div>

                                            </div> -->
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                    <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                    <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                                                    
                                                </div>
                                            </div>
                                        <?php }?>

                                        <div class="tableCard" style="padding: 25px!important;">
                                            <div class="row">
                                                <div class="form-group col-md-6  text-primary">
                                                    <label for="title">Final Amount</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->final_amount?>" readonly>
                                                </div>

                                            </div>

                                           <!--  <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Payment Mode</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                             
                                                        <label for="html">Full Payment</label>
                                                   

                                                    <br>
                                                </div>

                                            </div> -->

                                            <div class="row">
                                                <div class="form-group col-md-6 text-danger">
                                                    <label for="title">Total Due</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control " name="totaldue" id="totaldue"  value="<?=$dagsprem->due_amount?>" readonly>
                                                </div>

                                            </div>
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
                    <?php } ?>

                    <?php if($newDagCount == 1): ?>
                        <div class="tab-pane" role="tabpanel" id="newDag">
                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                <?php echo NJS_TAGLINE ?> (
                                    <span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                            </h5>
                            <div class="reza-card ">
                                <div class="reza-body">
                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-money" aria-hidden="true"></i> New Settlement Dags
                                    </h5>

                                    <div class="tableCard " style="padding: 25px!important;">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Old Dag No.</th>
                                                <th>New Dag No.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; foreach ($newDags as $newDag) :?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $newDag->old_dag ?></td>
                                                    <td><?php echo $newDag->new_dag ?></td>
                                                </tr>
                                                <?php $i = $i + 1; endforeach;?>
                                            </tbody>
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
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
        </section>
    </div>
</div>





