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
        color: #37474F;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    .reza-body{
        padding-top: 25px;
        padding-left: 10px;
        padding-right: 10px;
        padding-bottom: 10px;
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
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                <span class="round-tab">
                                    <strong>Applications</strong>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-pane" role="tabpanel" id="history">
                    <br>
                    <h5 class="bg-info p-2 text-white shadow">
                        Total Applications
                    </h5>
                    <div class="row" style="padding: 12px">
                        <div class="reza-card ">
                            <div class="reza-body">

                                <table class="table table-bordered border-primary">
                                    <tr>
                                        <th rowspan="2" class="text-center" style=" vertical-align: middle">Application Number</th>
                                        <th rowspan="2" class="text-center" style=" vertical-align: middle">
                                            District / Circle / Village
                                        </th>
                                        <th rowspan="2" class="text-center" style=" vertical-align: middle">Dag No.</th>
                                        <th colspan="2" class="text-center">Applied Area</th>
                                        <th colspan="2" class="text-center">Modified/Corrected Area by LRA</th>
                                    </tr>

                                    <tr>
                                        <td align="center">Homestead</td>
                                        <td align="center">Agriculture</td>
                                        <td align="center">Homestead</td>
                                        <td align="center">Agriculture</td>
                                    </tr>

                                    <?php
                                    $appliedB = 0;
                                    $appliedK = 0;
                                    $appliedL = 0;
                                    $appliedG = 0;
                                    $appliedAgB = 0;
                                    $appliedAgK = 0;
                                    $appliedAgL = 0;
                                    $appliedAgG = 0;
                                    $totalGanda = 0;
                                    $totalLessa = 0;
                                    $totalAgGanda = 0;
                                    $totalAgLessa = 0;

                                    $lmAreaB = 0;
                                    $lmAreaK = 0;
                                    $lmAreaL = 0;
                                    $lmAreaG = 0;
                                    $lmAreaAgB = 0;
                                    $lmAreaAgK = 0;
                                    $lmAreaAgL = 0;
                                    $lmAreaAgG = 0;
                                    $totalLmGanda = 0;
                                    $totalLmLessa = 0;
                                    $totalLmAgGanda = 0;
                                    $totalLmAgLessa = 0;

                                    ?>

                                    <?php foreach ($applications as $applied_dag) { ?>
                                        <?php  $myArea = $this->utilityclass->getLmReportedAreaByDistCodeAppNo($applied_dag->dist_code,$applied_dag->application_no, $applied_dag->dag_no);?>

                                        <tr>
                                            <td>
                                                <a style="text-decoration: none; color: #0a53be; font-weight:400" data-toggle="tooltip" data-placement="top" title="View application details"  href="<?php echo base_url()?>index.php/SettlementCommon/viewBasundharaApplication?app=<?=$applied_dag->application_no?>" target="_blank">
                                                    <?=$applied_dag->application_no ?>
                                                    <br>
                                                    <span style="color: #F44336; font-size: 12px">
                                                        <?php echo $this->utilityclass->getCaseNoByApplId($applied_dag->dist_code,$applied_dag->application_no); ?>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $this->utilityclass->getDistrictName($applied_dag->dist_code) ?>
                                                /
                                                <?php echo $this->utilityclass->getCircleName($applied_dag->dist_code,$applied_dag->subdiv_code, $applied_dag->cir_code); ?>
                                                /
                                                <?php echo $this->utilityclass->getVillageName
                                                ($applied_dag->dist_code,$applied_dag->subdiv_code,$applied_dag->cir_code,$applied_dag->mouza_code,$applied_dag->lot_no, $applied_dag->vill_code) ?>
                                            </td>
                                            <td><?=$applied_dag->dag_no ?></td>
                                            <td>
                                                <?php if(isset($applied_dag->mbigha)): ?>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <?php $appliedB += $applied_dag->mbigha; echo $applied_dag->mbigha ?> -
                                                        <?php $appliedK += $applied_dag->mkatha; echo $applied_dag->mkatha ?> -
                                                        <?php $appliedL += $applied_dag->mlessa; echo $applied_dag->mlessa ?> -
                                                        <?php $appliedG += $applied_dag->mganda; echo $applied_dag->mganda ?>
                                                    <?php else: ?>
                                                        <?php $appliedB += $applied_dag->mbigha; echo $applied_dag->mbigha ?> -
                                                        <?php $appliedK += $applied_dag->mkatha; echo $applied_dag->mkatha ?> -
                                                        <?php $appliedL += $applied_dag->mlessa; echo $applied_dag->mlessa ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    NA
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($applied_dag->agri_bigha)): ?>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <?php $appliedAgB += $applied_dag->agri_bigha; echo $applied_dag->agri_bigha ?> -
                                                        <?php $appliedAgK += $applied_dag->agri_katha; echo $applied_dag->agri_katha ?> -
                                                        <?php $appliedAgL += $applied_dag->agri_lessa; echo $applied_dag->agri_lessa ?> -
                                                        <?php $appliedAgG += $applied_dag->agri_ganda; echo $applied_dag->agri_ganda ?>
                                                    <?php else: ?>
                                                        <?php $appliedAgB += $applied_dag->agri_bigha; echo $applied_dag->agri_bigha ?> -
                                                        <?php $appliedAgK += $applied_dag->agri_katha; echo $applied_dag->agri_katha ?> -
                                                        <?php $appliedAgL += $applied_dag->agri_lessa; echo $applied_dag->agri_lessa ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    NA
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($myArea =='NA') : ?>
                                                    NA
                                                <?php else: ?>
                                                    <?php foreach ($myArea as $singleArea): ?>

                                                        <?php if($singleArea->service_code == SETTLEMENT_TENANT_ID): ?>

                                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                <?php $lmAreaB += $singleArea->s_dag_area_b;  echo $singleArea->s_dag_area_b  ?> -
                                                                <?php $lmAreaK += $singleArea->s_dag_area_k;  echo $singleArea->s_dag_area_k  ?> -
                                                                <?php $lmAreaL += $singleArea->s_dag_area_lc; echo $singleArea->s_dag_area_lc ?> -
                                                                <?php $lmAreaG += $singleArea->s_dag_area_g;  echo $singleArea->s_dag_area_g  ?>
                                                            <?php else: ?>
                                                                <?php $lmAreaB += $singleArea->s_dag_area_b;  echo $singleArea->s_dag_area_b ?> -
                                                                <?php $lmAreaK += $singleArea->s_dag_area_k;  echo $singleArea->s_dag_area_k ?> -
                                                                <?php $lmAreaL += $singleArea->s_dag_area_lc; echo $singleArea->s_dag_area_lc ?>
                                                            <?php endif; ?>

                                                        <?php else: ?>

                                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                <?php $lmAreaB += $singleArea->home_b;  echo $singleArea->home_b ?> -
                                                                <?php $lmAreaK += $singleArea->home_k;  echo $singleArea->home_k ?> -
                                                                <?php $lmAreaL += $singleArea->home_lc; echo $singleArea->home_lc ?> -
                                                                <?php $lmAreaG += $singleArea->home_g;  echo $singleArea->home_g ?>
                                                            <?php else: ?>
                                                                <?php $lmAreaB += $singleArea->home_b;  echo $singleArea->home_b ?> -
                                                                <?php $lmAreaK += $singleArea->home_k;  echo $singleArea->home_k ?> -
                                                                <?php $lmAreaL += $singleArea->home_lc; echo $singleArea->home_lc ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($myArea =='NA') : ?>
                                                    NA
                                                <?php else: ?>
                                                    <?php foreach ($myArea as $singleArea): ?>
                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <?php $lmAreaAgB += $singleArea->agri_b;  echo $singleArea->agri_b ?> -
                                                            <?php $lmAreaAgK += $singleArea->agri_k;  echo $singleArea->agri_k ?> -
                                                            <?php $lmAreaAgL += $singleArea->agri_lc; echo $singleArea->agri_lc ?> -
                                                            <?php $lmAreaAgG += $singleArea->agri_g;  echo $singleArea->agri_g ?>
                                                        <?php else: ?>
                                                            <?php $lmAreaAgB += $singleArea->agri_b;  echo $singleArea->agri_b ?> -
                                                            <?php $lmAreaAgK += $singleArea->agri_k;  echo $singleArea->agri_k ?> -
                                                            <?php $lmAreaAgL += $singleArea->agri_lc; echo $singleArea->agri_lc ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                    <tr>
                                        <td colspan="7"></td>
                                    </tr>
                                    <tr style="background-color: #EF9A9A; font-weight: bold">
                                        <td colspan="3" align="center">Total Area</td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalGanda = $this->utilityclass->Total_ganda($appliedB,$appliedK,$appliedL,$appliedG); ?>
                                                <?php $totalLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalGanda); ?>
                                                <?= $totalLessaInBKCG[0] ?> -
                                                <?= $totalLessaInBKCG[1] ?> -
                                                <?= $totalLessaInBKCG[2] ?> -
                                                <?= $totalLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalLessa = $this->utilityclass->Total_Lessa($appliedB,$appliedK,$appliedL); ?>
                                                <?php $totalLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessa); ?>
                                                <?= $totalLessaInBKL[0] ?> -
                                                <?= $totalLessaInBKL[1] ?> -
                                                <?= $totalLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalAgGanda = $this->utilityclass->Total_ganda($appliedAgB,$appliedAgK,$appliedAgL,$appliedAgG); ?>
                                                <?php $totalAgLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAgGanda); ?>
                                                <?= $totalAgLessaInBKCG[0] ?> -
                                                <?= $totalAgLessaInBKCG[1] ?> -
                                                <?= $totalAgLessaInBKCG[2] ?> -
                                                <?= $totalAgLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalAgLessa = $this->utilityclass->Total_Lessa($appliedAgB,$appliedAgK,$appliedAgL); ?>
                                                <?php $totalAglLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAgLessa); ?>
                                                <?= $totalAglLessaInBKL[0] ?> -
                                                <?= $totalAglLessaInBKL[1] ?> -
                                                <?= $totalAglLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalLmGanda = $this->utilityclass->Total_ganda($lmAreaB,$lmAreaK,$lmAreaL,$lmAreaG); ?>
                                                <?php $totalLmLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLmGanda); ?>
                                                <?= $totalLmLessaInBKCG[0] ?> -
                                                <?= $totalLmLessaInBKCG[1] ?> -
                                                <?= $totalLmLessaInBKCG[2] ?> -
                                                <?= $totalLmLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalLmLessa = $this->utilityclass->Total_Lessa($lmAreaB,$lmAreaK,$lmAreaL); ?>
                                                <?php $totalLmlLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLmLessa); ?>
                                                <?= $totalLmlLessaInBKL[0] ?> -
                                                <?= $totalLmlLessaInBKL[1] ?> -
                                                <?= $totalLmlLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalLmAgGanda = $this->utilityclass->Total_ganda($lmAreaAgB,$lmAreaAgK,$lmAreaAgL,$lmAreaAgG); ?>
                                                <?php $totalLmAgLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLmAgGanda); ?>
                                                <?= $totalLmAgLessaInBKCG[0] ?> -
                                                <?= $totalLmAgLessaInBKCG[1] ?> -
                                                <?= $totalLmAgLessaInBKCG[2] ?> -
                                                <?= $totalLmAgLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalLmAgLessa = $this->utilityclass->Total_Lessa($lmAreaAgB,$lmAreaAgK,$lmAreaAgL); ?>
                                                <?php $totalLmlAgLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLmAgLessa); ?>
                                                <?= $totalLmlAgLessaInBKL[0] ?> -
                                                <?= $totalLmlAgLessaInBKL[1] ?> -
                                                <?= $totalLmlAgLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
