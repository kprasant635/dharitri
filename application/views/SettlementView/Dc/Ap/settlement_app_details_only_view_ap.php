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
                      <strong>Lot Mondal</strong>
                      </span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="step 5">
                                <span class="round-tab"><strong>DC</strong></span>
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
                    </ul>
                </div>

                <div class="tab-content">
                    <?php
                    $sl_count = 1;
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <?php
                            //include(APPPATH."views/SettlementView/Dc/include/applicationview.php");
                            include(APPPATH."views/SettlementView/include/applicationApCoView.php");

                            ?>
                        </div>

                        <!-- LM reporting starts here -->

                        <div class="tab-pane" role="tabpanel" id="step2">
                            <?php  include(APPPATH."views/SettlementView/include/lmReportApView.php");  ?>

                        </div>

                        <div class="tab-pane" role="tabpanel" id="step5">

                            <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                                Registration of  Settlement AP Transfer (
                                <span class="bg-warning"><?=$_GET['case']?></span> )
                            </h5>
                            <div class="reza-card">
                                <div class="reza-body">
                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Approved Remarks Details
                                    </h5>
                                    <?php if($proceedings){ ?>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 200px">Remark Date</th>
                                                <th style="width: 200px">Remark Time</th>
                                                <th style="width: 200px">Remark from</th>
                                                <th>Remark</th>
                                            </tr>
                                            <?php $i=1; $length=count($proceedings);
                                            foreach($proceedings as $pro):if ($i==1){ ?>
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
                                            <?php } $i++; endforeach;?>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <!-- Masud's code-->

                                    <input type="hidden" id="caseNo" value="<?php echo $caseDetails->case_no ?>">
                                    <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">


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
                                Registration of  Settlement AP Transfer (
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
                                Registration of  Settlement AP Transfer (
                                <span class="bg-warning"><?=$_GET['case']?></span> )
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
                                <?php echo $this->lang->line('khasLand')?> (
                                <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$_GET['case']?></span> )
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
                                                <div class="form-group col-md-6 ">
                                                    <label>Selected Area</label>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" id="prem_area" name='area<?=$dagsprem->dag_no?>' value="<?=$dagsprem->area?>" readonly>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Purpose of Land</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" name='land_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_type?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Encroached land type</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" id="prem_landtype" name='rate_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->house_type?>" readonly>

                                                </div>
                                            </div>
                                            <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                                            </div>
                                            <div class="row">
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

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                    <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                    <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                                                    <?php if($dagsprem->ratetype=='R') { ?>
                                                    <span><b>(Amount: Rs @100/bigha based on above selected area)</b></span>
                                                    <?php }?>
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

                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Payment Mode</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php if($dagsprem->is_full_pay =='YES') { ?>
                                                        <label for="html">Full Payment</label>
                                                    <?php } else if ($dagsprem->is_full_pay =='NO') { ?>
                                                        <label for="css">30% Down Payment</label>
                                                    <?php } ?>

                                                    <br>
                                                </div>

                                            </div>

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

                    </div>

        </section>

    </div>
</div>


