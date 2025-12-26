<style>

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

    div.f-party-alternate > div:nth-of-type(odd) {
        background: #f2fdff;
    }
    div.co-report > form:nth-of-type(odd) {
        background: #f2fdff;
        padding-top: 3px;
        padding-bottom: 5px;
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

<script>

    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
        else{
            $('#myTab a[href="#step1"]').tab('show');
        }

        $('.nav-tabs > li a[title]').tooltip();
        $(".next-step").click(function (e) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

    });

</script>




<div class="container">
    <div class="row">
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                <span class="round-tab"><strong>Application</strong></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                <span class="round-tab"><strong>LM Report</strong></span>
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

                    </ul>
                </div>
                <?php
                $sl_count = 1;
                ?>
                <div class="tab-content">

                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement of  Occupancy Tenant (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card">
                            <div class="reza-body">
                                <h5 class="reza-title"  style="margin-top: 15px">
                                    <i class="fa fa-map-marker"></i> Address Information
                                </h5>
                                <div class="tableCard ">
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
                                                    <?=$this->utilityclass->getSubDivName($basic["dist_code"],$basic["subdiv_code"])?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Circle Name: </th>
                                            <td class="text-warning">
                                                <strong class="alert-warning">
                                                    <?=$this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?>
                                                </strong>
                                            </td>
                                            <th>Mouza Name: </th>
                                            <td class="text-warning">
                                                <strong class="alert-warning">
                                                    <?=$this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>

                                            <th>Village Name: </th>
                                            <td class="text-warning">
                                                <strong class="alert-warning">
                                                    <?=$this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?>
                                                </strong>
                                            </td>
                                        </tr>


                                    </table>
                                </div>

                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-pencil-square-o"></i> Self declaration details
                                </h5>
                                <div class="tableCard">
                                    <table class="table table-bordered">
                                        <?php
                                        foreach($selfDeclarationDetails[0] as $key=>$self){
                                            ?>
                                            <tr>
                                                <th><?=$self->name ?></th>
                                                <td class="text-center">
                                                    <strong>
                                                        <?php if ($self->status == "1"){ echo "Yes"; }?>
                                                        <?php if ($self->status == "0"){ echo "No"; } ?>
                                                    </strong>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    </table>
                                </div>

                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-user"></i>  Applicant details
                                </h5>
                                <?php $i=1; foreach($applicants_buyers as $settlement): ?>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                                                <th width="18%">Name</th>
                                                <td width="30%">
                                                    <strong class="alert-warning">
                                                        <?=$settlement->pdar_name;?>
                                                    </strong>
                                                </td>
                                                <th width="18%">Guardian name</th>
                                                <td width="30%">
                                                    <strong class="alert-warning">
                                                        <?=$settlement->pdar_guardian;?>
                                                    </strong>
                                                </td>
                                            </tr>

                                            <tr>

                                                <th>Relation</th>
                                                <td>
                                                    <strong class="alert-warning">
                                                        <?php
                                                        if($settlement->pdar_rel_guar == "1"){
                                                            echo "Mother";
                                                        }
                                                        if($settlement->pdar_rel_guar == "2"){
                                                            echo "Father";
                                                        }
                                                        if($settlement->pdar_rel_guar == "3"){
                                                            echo "Husband";
                                                        }
                                                        if($settlement->pdar_rel_guar == "4"){
                                                            echo "Wife";
                                                        }
                                                        if($settlement->pdar_rel_guar == "5"){
                                                            echo "Guardian";
                                                        }
                                                        if($settlement->pdar_rel_guar == "6"){
                                                            echo "Supdt.Mother";
                                                        }
                                                        ?>
                                                    </strong>
                                                </td>
                                                <th>Gender</th>
                                                <td>
                                                    <strong class="alert-warning">
                                                        <?php
                                                        if($settlement->pdar_gender == "1"){
                                                            echo "Male";
                                                        }
                                                        if($settlement->pdar_gender == "2"){
                                                            echo "Female";
                                                        }
                                                        if($settlement->pdar_gender == "3"){
                                                            echo "Others";
                                                        }
                                                        ?>
                                                    </strong>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th>Mobile</th>
                                                <td>
                                                    <strong class="alert-warning">
                                                        <?=$settlement->pdar_mobile?>
                                                    </strong>
                                                </td>
                                                <th>
                                                    Permanent address
                                                </th>
                                                <td>
                                                    <strong class="alert-warning">
                                                        <?=$settlement->pdar_add1?>
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Present address</th>
                                                <td>
                                                    <strong class="alert-warning">
                                                        <?=$settlement->pdar_add2?>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php $i++;?>
                                <?php endforeach;?>


                                <?php  if($applicants_owners == true){ ?>
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user-secret"></i>  Land Owner Details
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php
                                            $sl = 1;
                                            foreach($applicants_owners as $owners){
                                                ?>

                                                <tr>
                                                    <th width="5%" rowspan="3" style="vertical-align : middle;text-align:center;"><?=$sl++;?></th>
                                                    <th>Name</th>
                                                    <td >
                                                        <strong class="alert-warning">
                                                            <?=$owners->pdar_name;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Father's name</th>
                                                    <td >
                                                        <strong class="alert-warning">
                                                            <?=$owners->pdar_guardian;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        In place/Along with
                                                    </th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?php
                                                            if($owners->inplace_alongwith == 'i'){
                                                                echo "In Place";
                                                            }
                                                            if($owners->inplace_alongwith == 'a'){
                                                                echo "Along with";
                                                            }
                                                            ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                <?php } ?>

                                <?php  if($applicants_encroacher == true){
                                    ?>
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user-secret"></i>  Riotee Details
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php  $sl =1;  foreach($applicants_encroacher as $riotee){    ?>
                                                <tr>
                                                    <th width="5%" rowspan="3" style="vertical-align : middle;text-align:center;"><?=$sl++;?></th>
                                                    <th>Khatian Number</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?=$riotee->khatian_no;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?=$riotee->pdar_name;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Father's name</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?=$riotee->pdar_guardian;?>
                                                        </strong>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                <?php }?>

                                <?php  if($applicants_riotee_nok == true){  ?>
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user-plus"></i>  Riotee's NOK(This would be added to the Riotee khatian)
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php  $sl =1;  foreach($applicants_riotee_nok as $riotee_nok){  ?>
                                                <tr>
                                                    <th rowspan="4" width="5%" style="vertical-align : middle;text-align:center;"><?=$sl++;?></th>
                                                    <th >Khatian Number</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?=$riotee->khatian_no;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?=$riotee_nok->pdar_name;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Father's name</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?=$riotee_nok->pdar_guardian;?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Relationship with Riotee</th>
                                                    <td>
                                                        <strong class="alert-warning">
                                                            <?php
                                                            if($riotee_nok->pdar_type == 'GP'){
                                                                echo "Grand Son/ Daughter";
                                                            }
                                                            elseif($riotee_nok->pdar_type == 'GGP'){
                                                                echo "Great Grand Son";
                                                            }
                                                            ?>
                                                        </strong>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                <?php  } ?>


                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-file-text"></i>  Application Details
                                </h5>
                                <div class="tableCard">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Aadhaar Verified</th>
                                            <td>
                                                <strong class="alert-warning">
                                                    <?php if ($aadhar->is_aadhaar_verify == '1') { echo 'Yes';}?>
                                                </strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Period of Possession</th>
                                            <td>
                                                <strong class="alert-warning"><?=$basic["period_possession"] ?></strong>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Occupation or Profession of the applicant</th>
                                            <td>
                                                <strong class="alert-warning"><?=$basic["occupation_applicant"]?></strong>

                                            </td>
                                        </tr>

                                        <tr>
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
                                        </tr>

                                        <!-- <tr>
                                          <th>Nature of occupation over the land</th>
                                          <td>
                                            <input type="text" value="Agricultural" name="nature_occupation" class="form-control">
                                          </td>
                                        </tr> -->
                                    </table>
                                </div>

                                <?php if($nextKin){ ?>
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Family Details
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Next of KIN name</th>
                                                <th>Relation with Applicant</th>
                                                <th>Address of KIN</th>
                                                <th>Mobile number</th>
                                            </tr>
                                            <?php $i=1; foreach($nextKin as $kin): ?>
                                                <tr>
                                                    <td>
                                                        <?=$kin->next_of_kin_name?>
                                                    </td>
                                                    <td>
                                                        <?=$kin->relation_with_kin?>
                                                    </td>
                                                    <td>
                                                        <?=$kin->address?>
                                                    </td>
                                                    <td>
                                                        <?=$kin->mobile_no?>
                                                    </td>
                                                </tr>
                                                <?php $i++;?>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                <?php } ?>

                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-map"></i>  Area Details
                                </h5>
                                <div class="tableCard">
                                    <table class="table table-bordered">

                                        <tr>
                                            <th>Dag Number:</th>
                                            <td>
                                                <strong class="alert-warning">
                                                    <?=$dags["dag_no"]?>
                                                </strong>
                                            </td>

                                            <th>Patta Number:</th>
                                            <td>
                                                <strong class="alert-warning">
                                                    <?=$dags["patta_no"]?>
                                                </strong>
                                            </td>
                                            <th>Patta type:</th>
                                            <td>
                                                <strong class="alert-warning">
                                                    <?=$dags["patta_type_code"]?>
                                                </strong>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Total Land Area in Selected Dag</th>
                                            <td>
                                                <span class="input-group-addon">Bigha</span>
                                                <strong>
                                                    <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags["dag_area_b"]?>" readonly>
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="input-group-addon">Katha</span>
                                                <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags["dag_area_k"]?>" class="form-control input-sm" readonly>
                                            </td>
                                            <td>
                                                <span class="input-group-addon">Bigha</span>
                                                <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags["dag_area_lc"]?>" readonly>
                                            </td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <td>
                                                    <span class="input-group-addon">Ganda</span>
                                                    <input type="text" style="text-align: center;" value="<?=$dags["dag_area_g"]?>" class="form-control input-sm" name="dag_area_g" readonly>
                                                </td>
                                                <td>
                                                    <span class="input-group-addon">Kranti</span>
                                                    <input type="text" style="text-align: center;" value="<?=$dags["dag_area_kr"]?>" class="form-control input-sm" name="dag_area_kr" readonly>
                                                </td>
                                            <?php endif ; ?>
                                        </tr>

                                        <tr>
                                            <th>Total applied area</th>
                                            <td>
                                                <span class="input-group-addon">Bigha</span>
                                                <input type="text" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags["s_dag_area_b"]?>" >
                                            </td>
                                            <td>
                                                <span class="input-group-addon">Katha</span>
                                                <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?=$dags["s_dag_area_k"]?>" class="form-control input-sm s_dag_area_k" >
                                            </td>
                                            <td>
                                                <span class="input-group-addon">Lessa</span>
                                                <input type="text" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags["s_dag_area_lc"]?>" >
                                            </td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <td>
                                                    <span class="input-group-addon">Ganda</span>
                                                    <input type="text" style="text-align: center;" value="<?=$dags["s_dag_area_g"]?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                                                </td>
                                                <td>
                                                    <span class="input-group-addon">Kranti</span>
                                                    <input type="text" style="text-align: center;" value="<?=$dags["s_dag_area_kr"]?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                                                </td>
                                            <?php endif ; ?>
                                        </tr>

                                    </table>
                                </div>


                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-file-pdf-o"></i> Supporting Documents
                                </h5>
                                <div class="tableCard">
                                    <table class="table table-bordered">
                                        <?php foreach($document as $d): ?>
                                            <tr>
                                                <th>
                                                    <a target='download' href="<?php echo base_url(); ?>index.php/basundhara2/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                                    <!-- <input type="hidden" name="case_no" value="<?=$d->case_no;?>"> -->
                                                    <!-- <input type="hidden" name="user_code" value="<?=$d->user_code;?>"> -->
                                                    <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                                    <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                                    <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                                    <input type="hidden" name="file_details" value="<?=$d->file_details?>">

                                                    <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                                                </th>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>

                                <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
                            </div>
                        </div>


                        <ul class="list-inline pull-right"  style="margin-top: 20px">
                            <li>
                                <button type="button" class="btn btn-primary next-step">
                                    <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                                </button>
                            </li>
                        </ul>
                    </div>


                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement of  Occupancy Tenant (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card">
                            <div class="reza-body">
                                <h5  class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
                                </h5>
                                <div class="tableCard" style="padding-bottom: 15px">
                                    <?php $i=1; foreach($lmnotes as $lmnote): ?>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="chiitha_verified"
                                                            id="chiitha_verified1"
                                                            value="YES"
                                                        <?php if (trim($lmnote->chitha_verified) == YES){ echo "checked"; } ?>
                                                            disabled
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="chiitha_verified"
                                                            id="chiitha_verified2"
                                                            value="NO" disabled <?php if (trim($lmnote->chitha_verified) == NO){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                </a>
                                            </div>
                                            <div class="col-md-4">

                                                <i class="fa fa-link" aria-hidden="true"></i>
                                                <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $dags['dag_no'] . '&m=' . $basic["mouza_pargona_code"] . '&l=' . $basic['lot_no'] . '&v=' . $basic["vill_townprt_code"] . '&p=' . $dags['patta_type_code'] . '&dist=' . $basic["dist_code"] . '&cir=' . $basic["cir_code"] . '&sub_div=' . $basic["subdiv_code"] ?>">
                                                    <u><span class="text-primary" style="font-size:16px;">Dag - <?=$dags['dag_no']?> (Chitha)</span></u>
                                                </a>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                <span>
                                    <strong><?=$sl_count++?>.</strong> RK verified?
                                </span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="rk_verified"
                                                            id="rk_verified1"
                                                            value="YES"
                                                            disabled
                                                        <?php if (trim($lmnote->rk_verified) == YES){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="rk_verified"
                                                            id="rk_verified2"
                                                            value="NO"
                                                            disabled
                                                        <?php if (trim($lmnote->chitha_verified) == NO){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                foreach($applicants_encroacher as $en){
                                                    $khatian_no = $en->khatian_no;
                                                    break;
                                                }
                                                ?>
                                                <i class="fa fa-link" aria-hidden="true"></i>
                                                <a href="<?php echo base_url() . 'index.php/basundhara2/khatian?st='.$khatian_no.'&end='.$khatian_no.'&dist='.$basic['dist_code'].'&cir_code='.$basic['cir_code'].'&subdiv_code='.$basic['subdiv_code'].'&mouza_code='.$basic["mouza_pargona_code"].'&lot_no='.$basic['lot_no'].'&village_code='.$basic["vill_townprt_code"].'&patta_no='.$dags['patta_type_code'].'&dag_no='.$dags['dag_no']?>" target="view_riotee">

                                                    <u><span class="text-primary" style="font-size:16px;">Dag - <?=$dags['dag_no']?> (RK)</span></u>
                                                </a>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                                                <?php if($basic['bhumiputra_certificate_no']){?>
                                                    <label for="" class="alert-warning">Certificate number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>

                                                <?php }else{ ?>

                                                    <label for="" class="alert-warning">Certificate Not Available!</b></label>

                                                <?php }?>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="bhumiputra_confirmation_lm"
                                                            id="bhumiputra_confirmation1"
                                                            value="YES"
                                                            disabled
                                                        <?php if(trim($lmnote->bhumiputra_confirmation) == YES){echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="bhumiputra_confirmation_lm"
                                                            id="bhumiputra_confirmation2"
                                                            value="NO"
                                                            disabled
                                                        <?php if(trim($lmnote->bhumiputra_confirmation) == NO){echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <?php
                                            if($basic['bhumiputra_certificate_no']){

                                                ?>
                                                <div class="col-md-4">
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                                                    if($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT){
                                                        echo "cer_number=".$basic['bhumiputra_certificate_no'];
                                                    }elseif($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK){
                                                        echo "ack_number=".$basic['bhumiputra_certificate_no'];
                                                    }?>" target="BhumiPutra">
                                                        <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                                    </a>
                                                </div>

                                            <?php }?>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Verify Schedule of the land and area underb occupation?</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="possession_verified"
                                                            id="possession_verified1"
                                                            value="YES" disabled <?php if (trim($lmnote->possession_verification) == YES){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="possession_verified"
                                                            id="possession_verified2"
                                                            value="NO" disabled <?php if (trim($lmnote->possession_verification) == NO){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row p-2">
                                            <div class="col-md-6 text-justify">
                                                <span><strong><?=$sl_count++?>.</strong> Does applicant falls under protected category?</span>
                                                <?=form_error('protected_class_lm')?>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select name="protected_class_lm" id="protected_class_lm" class="form-control" required disabled>
                                                    <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                                                        <option value="<?php echo $class->CODE ?>"
                                                            <?php if($lmnote->protected_class_lm == $class->CODE){ echo "selected";} ?>>
                                                            <?php echo $class->NAME ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Whether proposed land is under litigation?</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="litigation"
                                                            id="landed_property1"
                                                            value="YES"
                                                            disabled
                                                        <?php if(trim($lmnote->litigation) == YES){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="litigation"
                                                            id="landed_property2"
                                                            value="NO"
                                                            disabled
                                                        <?php if(trim($lmnote->litigation) == NO){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                Tribal Belt/ Block.</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">

                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="whether_tribal"
                                                            id="whether_tribal1"
                                                            value="YES"
                                                            disabled
                                                        <?php if (trim($lmnote->is_tribal_belt) == YES){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="whether_tribal"
                                                            id="whether_tribal2"
                                                            value="NO"
                                                            disabled
                                                        <?php if (trim($lmnote->is_tribal_belt) == NO){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ? </span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="landslide"
                                                            id="landslide"
                                                            value="YES"
                                                            disabled
                                                        <?php if (trim($lmnote->landslide) == YES) {echo "checked";}?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="landslide"
                                                            id="landslide2"
                                                            value="NO"
                                                            disabled
                                                        <?php if (trim($lmnote->landslide) == NO) {echo "checked";}?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Whether the land falls under erosion?</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="erosion"
                                                            value="YES" disabled <?php if (trim($lmnote->erosion) == YES){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">YES</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="erosion"
                                                            value="NO" disabled <?php if (trim($lmnote->erosion) == NO){ echo "checked"; } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>




                                        <!-- <div class="row p-2">
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong>
                                    Possession of the land out of the total area present in that Dag, found during field visit
                                </span>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="inputEmail4">Total Bigha</label>
                                    </div>
                                    <div class="col-8">
                                        <input
                                                class="form-control"
                                                type="text"
                                                name="total_bigha"
                                                id="total_bigha"
                                                value="<?=$lmnote->total_bigha?>" readonly
                                        />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <label for="inputEmail4">Total Katha</label>
                                    </div>
                                    <div class="col-8">
                                        <input
                                                type="text"
                                                name="total_Katha"
                                                class="form-control"
                                                id="total_katha"
                                                value="<?=$lmnote->total_Katha?>" readonly
                                        />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <label for="inputEmail4">Total Lessa</label>
                                    </div>
                                    <div class="col-8">
                                        <input
                                                type="text"
                                                name="total_lessa"
                                                class="form-control"
                                                id="total_lessa"
                                                value="<?=$lmnote->total_lessa?>" readonly

                                        />
                                    </div>
                                </div>
                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <label for="inputEmail4">Total Ganda</label>
                                        </div>
                                        <div class="col-8">
                                            <input
                                                    type="text"
                                                    name="total_ganda"
                                                    class="form-control"
                                                    id="total_ganda"
                                                    value="<?=$lmnote->total_ganda?>" readonly

                                            />
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <label for="inputEmail4">Total Kranti</label>
                                        </div>
                                        <div class="col-8">
                                            <input
                                                    type="text"
                                                    name="total_kranti"
                                                    class="form-control"
                                                    id="total_kranti"
                                                    value="<?=$lmnote->total_kranti?>" readonly

                                            />
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div> -->

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Period of possession</span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="inputEmail4">From Date</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input
                                                                class="form-control"
                                                                type="date"
                                                                name="period_possession"
                                                                id="period_possession"
                                                                value="<?=$lmnote->period_possession?>" readonly
                                                        />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Nature of possession </span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select
                                                        name="nature_possession"
                                                        id="nature_possession"
                                                        class="form-control" disabled
                                                >
                                                    <option value="Agricultural" <?php if ($lmnote->nature_possession == "Agricultural"){ echo "selected"; }?>>Agricultural</option>
                                                    <option value="Business" <?php if ($lmnote->nature_possession == "Business"){ echo "selected"; }?>>Business</option>
                                                    <option value="Residential" <?php if ($lmnote->nature_possession == "Residential"){ echo "selected"; }?>>Residential</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong>
                                    Purpose of the land used by the occupants(if any other than pt.5)
                                </span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="land_used_by_occupants" value="<?=$lmnote->land_used_by_occupants?>" class="form-control" placeholder="Enter purpose of the land used by occupants" disabled>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong>
                                    Check the land revenue details as fetch from the E-Khajana Database or check the Khajana receipt uploaded by applicant
                                </span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="khajana_receipt"
                                                            id="khajana_receipt1"
                                                            value="YES"
                                                        <?php if(trim($lmnote->e_khajana_receipt_check) == YES){echo "checked";} ?>
                                                            disabled
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="khajana_receipt"
                                                            id="khajana_receipt2"
                                                            value="NO"
                                                        <?php if(trim($lmnote->e_khajana_receipt_check) == NO){echo "checked";} ?>
                                                            disabled
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span> <strong><?=$sl_count++?>.</strong> LM remarks</span>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="lm_note" value="<?php
                                                foreach(json_decode(CO_NOTE) as $co_note){
                                                    if($co_note->CODE == $lmnote->lm_note){
                                                        echo $co_note->NAME;
                                                    }
                                                }?>" class="form-control" readonly><br>
                                                <textarea name="lm_remark_text" class="form-control" id="lm_remark_text" cols="30" rows="2" readonly><?=$lmnote->lm_remark_text?></textarea>
                                            </div>
                                        </div>

                                        <!-- lm report ends here -->

                                    <?php endforeach;?>
                                </div>
                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-file-pdf-o"></i> Uploaded Documents
                                </h5>
                                <div class="tableCard">
                                    <table class="table table-bordered">
                                        <?php foreach($dhardocuments as $docs): ?>
                                            <tr>
                                                <th>
                                                    <a target='download' href="<?php echo base_url(); ?><?=$docs->file_path;?>"><i class="fa fa-paperclip"></i> <?=$docs->file_name;?></a>
                                                </th>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
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


                    <div class="tab-pane" role="tabpanel" id="proceedings">

                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement of  Occupancy Tenant (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>

                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                                </h5>
                                <?php if($proceedings){ ?>
                                    <div class="tableCard ">
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

                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement of  Occupancy Tenant (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>


                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title"  style="margin-top: 15px">
                                    <i class="fa fa-history" aria-hidden="true"></i> Case History
                                </h5>
                                <div class="tableCard ">
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

                        </ul>

                    </div>

                </div>
        </section>

    </div>
</div>
