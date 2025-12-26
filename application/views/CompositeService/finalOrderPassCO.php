<style>
    :root {
        --loader-size: 50px;
        --dot-size: 6px;
        --loader-bg: #e1e6e2;
        --dot-color: black;
    }

    .loader {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(1, 18, 64, 0.2);
        transition: opacity 0.3s ease-out, top 0.3s step-end;
        z-index: 99;
    }

    .loader.trans {
        transition: opacity 0.5s ease-out, top 0.5s step-start;
        opacity: 1;
        top: 0;
    }

    .loader .loaderview {
        position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        height: auto;
        padding: 10px 40px;
        border-radius: 5px;
        top: 0;
        left: 0;
        z-index: 100;
        flex-flow: column;
        background-color: var(--loader-bg);
    }

    h1 {
        color: var(--dot-color);
        font-size: 1.2em;
        animation: fading 1.5s ease-in-out infinite;
        font-family: "Comfortaa", cursive;
    }

    .Loader-box {
        margin: 20px;
        flex: 0 0 auto;
        height: var(--loader-size);
        width: var(--loader-size);
    }

    .box {
        position: absolute;
        height: var(--loader-size);
        width: var(--loader-size);
        animation: rotating 4s ease-in infinite;
        animation-delay: calc(var(--id) * 0.5s);
    }

    .dot {
        background-color: var(--dot-color);
        height: var(--dot-size);
        width: var(--dot-size);
        border-radius: 100%;
    }

    @keyframes rotating {
        0% {
            opacity: 0;
            transform: rotateZ(0);
        }
        25% {
            opacity: 100%;
            transform: rotateZ(160deg);
        }

        75% {
            opacity: 200%;
            opacity: 100;
        }
        80% {
            transform: rotateZ(300deg);
            opacity: 100;
        }
        100% {
            transform: rotateZ(350deg);
            opacity: 0;
        }
    }

    @keyframes fading {
        0% {
            opacity: 40%;
        }
        50% {
            opacity: 90%;
        }
        100% {
            opacity: 40%;
        }
    }

</style>
<div class="hide loader" id="loader">
    <div class="loaderview">
        <h1>Don't refresh the page until the process is completed...</h1>
        <div class="Loader-box">
            <div class="box" style="--id:1">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:2">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:3">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:4">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:5">
                <div class="dot"></div>
            </div>
        </div>
    </div>
</div>
<?php
$guard =$sellername= "";
$count = 1;
$sellername_inplace=null;
$sellername_along=null;
foreach ($pattadars as $p):
    ?>
    <p class='regular uni_text'><?php $count++ . ") <span class='text-danger'>" . $p->pdar_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->pdar_rel_guar) . " : " . $p->pdar_guardian; ?></p>
    <?php
    $sellername .= $p->pdar_name . ",";
    $seller_father = $p->pdar_guardian;
    $seller_relation = $this->utilityclass->get_relation($p->pdar_rel_guar);
    if($p->striked_out == 1){
        $sellername_inplace .=$p->pdar_name.',';
    }
    else{
        $sellername_along .=$p->pdar_name.',';
    }
endforeach;
?>

<?php
$hide = null;
$guard = "";
$count = 1;
$appname = "";
foreach ($petitioner as $p):
    ?>
    <p class='regular uni_text'><?php
        $count++ . ") <span class='text-danger'>" . $p->pet_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->guard_rel) . " : " . $p->guard_name;
        $appname .= $p->pet_name . ",";
        $appname_father = $p->guard_name;
        $app_relation = $this->utilityclass->get_relation($p->guard_rel);
        ?></p>
<?php
endforeach;
$appname = rtrim($appname, ",");
?>

    <?php 
    if($chitha_basic_data <= 0)
    {?>
    <script type="text/javascript">
        alert('Kindly check the chitha for the applied Dag before proceed!!');
    </script>
    
    <?php }?>


<div class="container-fluid form-top login">
    <?php
            $buttonEnabledFlag =1;
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                include 'application/views/common/input_hidden_fields_and_func.php';
            }
            ?>
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Auto Mutation Order (Composite Service)</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">

                    <div class="panel-body">
                        <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">

                            <input type="hidden" name="dist_code" value="<?=$data->dist_code?>">
                            <input type="hidden" name="subdiv_code"  value="<?=$data->subdiv_code?>">
                            <input type="hidden" name="circle_code" value="<?=$data->cir_code?>">
                            <input type="hidden" name="mouza_code" value="<?=$data->mouza_pargona_code?>">
                            <input type="hidden" name="lot_no" value="<?=$data->lot_no?>">
                            <input type="hidden" name="vill_code" value="<?=$data->vill_townprt_code?>">
                            <input type="hidden" name="patta_type" value="">
                            <input type="hidden" name="patta_no" value="">
                            <div class="col-lg-12">
                            <button style="float:right" id="seeJamaClick">
                                 <i class="fa fa-link" aria-hidden="true"></i>
                                 <span class="text-primary" style="font-size:16px;color:#ffb81d">Patta No. (Jamabandi View)</span>
                            </button>
                            </div>
                        </form>
                        <form method='post' id="finalOrderOfcMutationPassCO">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">

                                <input type="hidden" name="ENABLED_BLOCKCHAIN" id="ENABLED_BLOCKCHAIN" value="<?= ENABLED_BLOCKCHAIN ?>" />
                                
                                <?php 
                                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                {
                                    if($propChainEnableFlag)
                                    {
                                        include 'application/views/common/propertyCheckDetailsFormultidags.php';
                                    }
                                    
                                ?>
                                    <input type="hidden" name="ENABLED_BLOCKCHAIN_FOR_DIST" id="ENABLED_BLOCKCHAIN_FOR_DIST" value="<?= $this->session->userdata('dist_code') ?>" />
                                    
                                <?php
                                }else{
                                ?>
                                    <input type="hidden" name="ENABLED_BLOCKCHAIN_FOR_DIST" id="ENABLED_BLOCKCHAIN_FOR_DIST" value="NA" />
                                <?php
                                }
                                ?>

                                <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                {?>
                                <!-- property chain hidden fields -->
                                <input type="hidden" name="ulpin" id="ulpin" value="<?= $ulpin ?>" />
                                <input type="hidden" name="chain_revenue" id="chain_revenue" value="<?= $revenue ?>" />
                                <input type="hidden" name="chain_local_tax" id="chain_local_tax" value="<?= $local_tax ?>" />
                                <input type="hidden" name="encoded_case_no" id="encoded_case_no" value="<?= $encoded_case_no ?>" />
                                
                                <?php if (isset($old_ulpin)) { ?>
                                <input type="hidden" name="old_ulpin" id="old_ulpin" value="<?= $old_ulpin ?>" />

                                <!--  -->
                                <?php }}?>

                                    <?php
                                    //var_dump($data);
                                    $coname = $this->utilityclass->getSelectedCOName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $this->session->userdata('user_code'));
                                    //var_dump($coname);
                                    if ($trans_code == 03) {
                                        $area_message = null;

                                        ////// BARAK VALLEY CODE START ////////////
                                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                        foreach ($dags as $dag) {
                                            $area_message .= "$dag->patta_no নং পট্টাৰ "
                                                . "$dag->dag_no নং দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (ছটাক)".$dag->m_dag_area_g . " (গণ্ডা),";
                                        }
                                        $seller_as=$sellername_inplace? $sellername_inplace."ৰ স্হলত":$sellername_along."ৰ সাথে";

                                        $message = "আবেদনকারী একটি আবেদন দায়ের করেছেন এবং মামলাটি |"
                                                . "আবেদনকারী " . " $appname " . "মধ্যে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজার অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী "
                                            . $area_message . " মাটিত খ:দ: সূত্ৰে একটি নাম পেতে চান |"
                                                . "তারিখ অনুযায়ী নোটিশ জারি করা হয় এবং নোটিশের সময়কালের মধ্যে কোনও আপত্তি ইত্যাদি পাওয়া যায়নি । "
                                                . "আবেদনকারীর দায়ের করা " . date('d/m/Y', strtotime($data->date_entry)) . " ইং তারিখের $data->deed_no নম্বর: নথি দেখা হয়েছে | "
                                                . "একটি ডকুমেন্টের মাধ্যমে আবেদনকারী  " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজার অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী "
                                            . $area_message . " পাট্টাদারের $sellername থেকে মাটি নিষ্কাশন করা হয় | লা:ম: এর রিপোর্ট অনুযায়ী আবেদনকারীর কাছে খারিদা জমির দখল রয়েছে | "

                                                . "তাই " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী ". $area_message . "মাটিতে খারিদা "
                                                . "দখল সূত্র মধ্যে পাট্টাদার  ". $seller_as." আবেদনকারীদের  $appname এর নাম অনুদান সম্পন্ন হয়েছে |";
                                    }
                                    else{
                                        foreach ($dags as $dag) {
                                            $area_message .= "$dag->patta_no নং পট্টাৰ "
                                                . "$dag->dag_no নং দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা), ";
                                    ?>
                                    <a style="float:right" target="_blank" href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $dag->dag_no . '&m=' . $dag->mouza_pargona_code . '&l=' . $dag->lot_no . '&v=' . $dag->vill_townprt_code . '&p=' . $dag->patta_type_code . '&dist=' . $dag->dist_code . '&cir=' . $dag->cir_code . '&sub_div=' . $dag->subdiv_code ?>">
                                         <i class="fa fa-link" aria-hidden="true"></i><u><span class="text-primary" style="font-size:16px;">Dag No. <?=$dag->dag_no?> (Chitha View)</span></u>
                                    </a>
                                    <input type="hidden" id="patta_type" value="<?=$dag->patta_type_code?>">
                                    <input type="hidden" id="patta_no" value="<?=$dag->patta_no?>">
                                    <?php    }

                                    $seller_as=$sellername_inplace? $sellername_inplace."ৰ স্থলত":$sellername_along."ৰ লগত";
                                        $message = "আবেদনকাৰীয়ে হাজিৰ দাখিল কৰিছে আৰু গোচৰ উপস্থাপিত হৈছে |"
                                            . "আবেদনকাৰী " . " $appname " . "য়ে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী "
                                            . $area_message . " মাটিত খ:দ: সূত্ৰে নামজাৰী বিচাৰিছে | "
                                            . "জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি পোৱা নাই | "
                                            . "আবেদনকাৰীয়ে দাখিল কৰা " . date('d/m/Y', strtotime($data->date_entry)) . " ইং তাৰিখৰ $data->deed_no  নং ৰে: দলিল চোবা হ’ল | "
                                            . "উত্ত দলিল যোগে আবেদনকাৰীয়ে  " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী "
                                            . $area_message . "  মাটি পট্টাদাৰ $sellername পৰা খৰিদ কৰে | লা:ম: ৰ প্রতিবেদন মতে খৰিদা জমিত আবেদনকাৰীৰ দখল-আবাদ আছে | "
                                            . "সেয়েহে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী " . $area_message . "  মাটিত খৰিদা "
                                            . "দখল সূত্ৰে পট্টাদাৰ  ". $seller_as." আবেদনকাৰী  $appname ৰ নামজাৰী মঞ্জুৰ কৰা হ’ল |";

                                    }

                                    }
                                    ?>

                                    <div class="col-lg-12 center">
                                        <div class="form-group" style="text-align: center">
                                            <!--                                            <a class="btn btn-info uni_text lmreportmut"  href="-->
                                            <?php //echo base_url() . "index.php/officemutation/lmreport?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?><!--"><i class='fa fa-list-alt'></i>&nbsp; View LM Report</a>-->
                                            <a class="btn btn-success uni_text astreport"
                                               href="<?php echo base_url() . "index.php/officemutation/asstReport1?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i
                                                        class='fa fa-list-alt'></i>&nbsp; View Assistant Report</a>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                    <?php if(($noc_data->appissuedt != null) and ($noc_data->nocupload == 'Y') and (empty($sro)) ){?>
                                    <button type="button" class="btn btn-lg btn-primary" id="verify_button"><i class='fa fa-check'></i>&nbsp;Verify Deed
                                    </button>
                                    <?php }?>
                                    </div>
                                        <br>

                                    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                         id='skmodal'>
                                        <div class="modal-dialog modal-lg" style=" overflow-y: auto;">
                                            <div class="modal-content" style=" overflow-y: auto;">
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <th colspan="6" style="background-color: #136a6f; color: #fff">Location
                                            Details
                                        </th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>District</td>
                                            <td class="text-red">
                                                <?php echo $this->utilityclass->getDistrictName($data->dist_code); ?>
                                            </td>
                                            <td>Subdivision</td>
                                            <td class="text-red">
                                                <?php echo $this->utilityclass->getSubDivName($data->dist_code,
                                                    $data->subdiv_code); ?>
                                            </td>
                                            <td>Circle</td>
                                            <td class="text-red">
                                                <?php echo $this->utilityclass->getCircleName($data->dist_code,
                                                    $data->subdiv_code, $data->cir_code); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mouza</td>
                                            <td class="text-red"><?php echo $this->utilityclass->getMouzaName($data->dist_code,
                                                    $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code) ?>
                                            </td>
                                            <td>Lot No</td>
                                            <td class="text-red"><?php echo $this->utilityclass->getLotName($data->dist_code,
                                                    $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code,
                                                    $data->lot_no); ?>
                                            </td>
                                            <td>Village / Town</td>
                                            <td class="text-red"><?php echo $this->utilityclass->getVillageName($data->dist_code,
                                                    $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code,
                                                    $data->lot_no, $data->vill_townprt_code); ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>

                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Basic Order
                                            Details
                                        </th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Case No:</td>
                                            <td><span class="text-danger"><?= $case_no ?></span></td>
                                            <input type="hidden" value="<?= enc_param('case_no', $case_no, 600) ?>" id="case_no" name="case_no">
                                            <td>NOC No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?= $data->noc_no ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mutation</td>
                                            <td class="text-danger">YES</td>
                                            <td>Partition</td>
                                            <td class="text-danger"><?= ($noc_case->automut == 'P')? 'YES': 'NO'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Mutation Type:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?= $this->utilityclass->getOfficeMutType($data->mut_type) ?>
                                                </span>
                                            </td>
                                            <td>Transfer Type:</td>
                                            <td><span class="text-danger"><?= $this->utilityclass->getTransferType($data->trans_code) ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>LRA Name:</td>
                                            <?php $lmcode = $lm_code;
                                            if(!empty($lmcode)){?>
                                            <td>
                                                <span class="text-danger">
                                                <?php $lmcode = $lm_code;
                                                $lms = $this->utilityclass->getDefinedMondalsName($data->dist_code,
                                                    $data->subdiv_code, $data->cir_code,
                                                    $data->mouza_pargona_code, $data->lot_no, $lmcode);
                                                echo $lms->lm_name ?? '';
                                                ?>
                                                </span>
                                            </td>
                                            <?php }
                                            else{?>
                                            <td>
                                            <?php $lms_arr = $this->utilityclass->EnabledMondalNameAll($data->dist_code,
                                                    $data->subdiv_code, $data->cir_code,
                                                    $data->mouza_pargona_code, $data->lot_no);
                                           // var_dump($lms_arr);

                                                    ?>
                                            <label class="btn btn-success">
                                            <select class="form-control" name="lm_code_assign" id="lm_code_assign" required>
                                                <?php
                                                echo"<option disabled selected> -- Select --</option>";
                                                foreach ($lms_arr as $dcadc) {
                                                    $username = $dcadc->lm_name;
                                                    $user_code = $dcadc->lm_code;
                                                    echo"<option value='$user_code'>$username</option>";
                                                }
                                                ?>
                                            </select>
                                            </label>
                                            </td>

                                            <?php }?>
                                            <td>LRA Sign Date:</td>
                                            <td>
                                                <span class="text-danger"><?= date('d-m-Y', strtotime($lm_note_date)) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CO Name:</td>
                                            <td>
                                                <span class="text-danger">
                                                <?php $coname = $this->utilityclass->getCOCode($data->dist_code, $data->subdiv_code, $data->cir_code, $this->session->userdata('user_code'));
                                                echo $coname->username;
                                                ?>
                                                </span>
                                            </td>
                                            <td>NOC issue Date</td>
                                            <?php $appissuedt=$noc_data->appissuedt;?>
                                            <td><span class="text-danger">
                                                <?= (($noc_data->appissuedt != null) and ($noc_data->nocupload == 'Y')) ? $appissuedt  : 'NOC not issued yet'; ?>
                                                </span></td>
                                        </tr>

                                        </tbody>
                                    </table>

                                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>

                                    <?php if ($data->trans_code == '03'): ?>
                                        <?php if(empty($sro)){?>
                                           <span class="text-danger bold"><?php  echo "* Probably Deed has not been registered/Uploaded in e-Panjeeyan";?>
                                       </span>
                                       <?php } ?>
                                        <?php if(!empty($sro)){ foreach($sro as $s):?>
                                        <table class="table table-striped table-bordered text-bold">
                                            <thead>
                                            <th colspan="3" style="background-color: #136a6f; color: #fff">Deed
                                                Details
                                            </th>
                                            </thead>
                                            <tbody>

                                            <tr>

                                                <?php if(($s->ngdrs)=='Y'){ ?>

                                                    <td>
                                                    <span class="text-bold text-danger">Deed. No. : <?= $s->deed_no ?> &nbsp;
                                                    </span><br>
                                                    <a target='_blank' href='<?php echo base_url() ?>index.php/DisplayDeed/sroNGDRS?doc_reg_no=<?php echo $s->deed_no ?>' ><i class="fa fa-file-image-o" aria-hidden="true"></i> Click Here to View NDeed </a>
                                                </td>

                                                <?php } else{ ?>

                                                <td>
                                                    <span class="text-bold text-danger">Sl. No. : <?= $s->deed_no ?> &nbsp;&nbsp;
                                                    <?php if(isset($s->deed_no_actual))
                                                    echo "Deed No. : ".$s->deed_no_actual ?>
                                                    </span><br>
                                                    <a target='_blank' href='<?php echo base_url() ?>index.php/DisplayDeed/sro?slno=<?php echo $s->deed_no ?>&dist=<?php echo $data->dist_code ?>&sro=<?php echo $s->sro_code ?>' ><i class="fa fa-file-image-o" aria-hidden="true"></i> Click Here to View Deed </a>
                                                </td>
                                            <?php } ?>
                                                <td>
                                                    <span class="text-bold text-danger">Deed Date : <?= 
                                                    date('d-m-Y', strtotime($s->date_of_deed))?></span>
                                                </td>
                                                <td>
                                                    <span class="text-bold text-danger">Deed Value :<?= $s->deed_value ?></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                          <?php endforeach; }?>
                                    <?php endif; ?>

                                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">Dag Details
                                        </th>
                                        <tbody class="border">

                                        <?php foreach ($dags as $d): ?>
                                            <tr class="text-bold bg-primary">
                                                <td>Dag No.:</td>
                                                <td><?= $d->dag_no ?></td>
                                                <td>Patta No.:</td>
                                                <td><?= $d->patta_no ?></td>
                                                <td>Patta Type</td>
                                                <td><?php echo $this->utilityclass->getPattaName($d->patta_type_code); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold"><?= $this->lang->line('total_land_area') ?></td>
                                                <td colspan="2">
                                                <span class="text-bold">
                                                    <?= isset($d->c_bigha)?$d->c_bigha:''?>B-
                                                    <?= isset($d->c_katha)?$d->c_katha:''?>K-
                                                    <?= isset($d->c_lessa)?$d->c_lessa:'' ?>L-
                                                    <?= isset($d->c_ganda)?$d->c_ganda:'' ?>G-
                                                    <?= isset($d->c_kranti)?$d->c_kranti:'' ?>Kr
                                                </span>
                                                </td>
                                                <td class="text-red text-bold"><?= $this->lang->line('mutated_land_area') ?></td>
                                                <td colspan="2" class="text-bold text-red">
                                                    <?= $d->m_dag_area_b ?>B-
                                                    <?= $d->m_dag_area_k ?>K-
                                                    <?= $d->m_dag_area_lc ?>L-
                                                    <?= $d->m_dag_area_g ?>G-
                                                    0Kr
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>


                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">&nbsp;</div>


                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="7">Applicant
                                            Details
                                        </th>
                                        </thead>
                                        <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>#</th>
                                            <th>Applicant`s Name</th>
                                            <th>Guardian Name</th>
                                            <th>Mobile No</th>
                                            <th>Address</th>
                                        </tr>
                                        </thead>
                                        <tbody id="applicant_list">
                                        <?php
                                        foreach ($applicants as $appl):

                                            $address = (($appl->add2 == '') ? $appl->add1 : $appl->add1 . ' / ' . $appl->add2);
                                            $mobile = (($appl->pdar_mobile == '') ? '-' : $appl->pdar_mobile);
                                            ?>
                                            <tr>
                                                <td><?= $appl->pet_id ?></td>
                                                <td><?= $appl->pet_name ?></td>
                                                <td><?= $appl->guard_name ?></td>
                                                <td><?= $mobile ?></td>
                                                <td><?= $address ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="100%">Pattadars Details
                                        </th>
                                        </thead>
                                        <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>#</th>
                                            <th>Dag No.</th>
                                            <th>Patta No.</th>
                                            <th>Pattadar Name</th>
                                            <th>Guardian Name</th>
                                            <th>Relationship</th>
                                            <th>Mobile No</th>
                                            <th>Address</th>
                                            <th>Inplace/Alongwith</th>
                                        </tr>
                                        </thead>
                                        <tbody id="pattadarAlongwith_list">
                                        <?php
                                        $i = 1;
                                        foreach ($pattadars as $row):

                                            $address = (($row->pdar_add2 == '') ? $row->pdar_add1 : $row->pdar_add1 . ' / ' . $row->pdar_add2);
                                            $status = (($row->striked_out == 1) ? 'Inplace' : 'Alongwith');
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row->dag_no ?></td>
                                                <td><?= $row->patta_no ?></td>
                                                <td><?= $row->pdar_name ?></td>
                                                <td><?= $row->pdar_guardian ?></td>
                                                <td><?= $this->utilityclass->get_relation($row->pdar_rel_guar) ?></td>
                                                <td><?= $row->pdar_mobile ?></td>
                                                <td><?= $address ?></td>
                                                <td id="inplacealong<?=$row->dag_no?>">
                                                <strong><?=$status?></strong><br>
                                                <button type="button" onclick="editInplaceAlongwith(<?=$row->dag_no?>);" class="btn btn-sm btn-primary mt-1">
                                                <strong>Change Inplace/Along with information</strong>
                                                </button>
                                                </td>
                                                <input type="hidden" name="" id="pdar_id<?=$row->dag_no?>" value="<?=$row->pdar_id?>">
                                            </tr>
                                            <?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">&nbsp;</div>

                                   <?php  if(!empty($sro)): ?>
                                   <?php foreach($sro as $s):?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="7">Data fetched from Panjeeyan
                                        </th>
                                        </thead>
                                        <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>Pattadar Name</th>
                                            <th>Applicant`s Name</th>
                                        </tr>
                                        </thead>
                                        <tbody id="applicant_list">
                    
                                            <tr>
                                                <td>
                                                <?php 
                                                $check = str_replace("&",",",$s->reg_from_name);
                                                $arr = explode(',', $check);
                                               
                                                echo "<ul>";
                                                $count =1;
                                                foreach($arr as $key => $value) {
                                                    if($value != null && $value!=' '){
                                                        echo "<li>".$count++.") ".$value."</li>";
                                                    }
                                                    
                                                }
                                                echo "</ul>";
                                                ?>
                                                    
                                                </td>
                                                <td> 
                                            <?php 
                                                $check2 = str_replace("&",",",$s->reg_to_name);
                                                $arr = explode(',', $check2);
                                               
                                                echo "<ul>";
                                                $count =1;
                                                foreach($arr as $key => $value) {
                                                    if($value != null && $value!=' '){
                                                        echo "<li>".$count++.") ".$value."</li>";
                                                    }
                                                    
                                                }
                                                echo "</ul>";
                                                ?>


                                        </td>
                                                
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                                <?php endforeach; ?>
                                    <?php endif; ?>

                                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                                    <textarea class='form-control' style="border: 10px solid #ccc;" cols="10" rows="8"
                                              name='co_order'><?php echo $message; ?></textarea>

                                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                                    <input type="hidden" class="form-control" name="by_right_of"
                                           value="<?php echo $trans_code; ?>" readonly>

                                    <?php if($data->status == 'H'):?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <th style="background-color: #136a6f; color: #fff">Auto Mutation Stop Reason
                                            </th>
                                            <th style="background-color: #136a6f; color: #fff">Date
                                            </th>
                                            </thead>
                                            <thead style="white-space:nowrap; width:100%">
                                            </thead>
                                            <tbody>
                                            <tr class="text-bold table-success">
                                                <th> <?= $hold_reason ?></th>
                                                <th> <?= $hold_date ?></th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                    <!--/////////////upload docs///////////-->



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
<div class="col-lg-12 text-bold text-red" id="alert_message"></div>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
<label><u>Upload Additional Document</u></label>
                &nbsp;
<i class="fa fa-info-circle text-red" 
title="1. Uploaded file types should be jpeg|jpg|png|pdf only.
2. Uploaded file size should not be more than 4MB"></i>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
<table class="table table-striped table-bordered">
                    <tbody id='certi_tab'>
                        
                        <tr>
                            <td><span class="text-bold"> <input type="text" required="" id="doc1" name="doc1" placeholder="Enter document name"  value=""/></span>
                            </td>
                            <td><input type='file' name="doc1_file" id="doc1_file"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadOMutDocumentCO" id='1'>Upload &nbsp;<i class='fa fa-upload'></i></button>
                            </td>
                            <td>
                                <?php if(!empty($doc1_id)) { if($doc1_id->id!='' || $doc1_id->id!=null) { ?>
                                <div id="div_death">
                                    <button class="btn btn-sm btn-info" type="button"><a  style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc1_id->id?>" target="_blank">VIEW <?=$doc1_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO removeDeath" id='1'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_1"></div>
                            </td>
                        </tr>

                        <tr>
                            <td><span class="text-bold"> <input type="text" required="" id="doc2" name="doc2" placeholder="Enter document name"  value=""/></span>
                            </td>
                            <td><input type='file' name="doc2_file" id="doc2_file"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadOMutDocumentCO" id='2'>Upload &nbsp;<i class='fa fa-upload'></i></button>
                                </a>
                            </td>
                            <td>

                                <?php if(!empty($doc2_id)) { if($doc2_id->id!='' || $doc2_id->id!=null) { ?>
                                <div id="div_noc">
                                    <button class="btn btn-sm btn-info" type="button"><a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc2_id->id?>" target="_blank">VIEW <?=$doc2_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO removeNOC" id='2'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_2"></div>
                            </td>
                        </tr>

                        

                    </tbody>
                </table>
            </div>

 <!----------------->
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="100%">CO Order
                                        </th>
                                        </thead>
                                        <thead style="white-space:nowrap; width:100%">
                                        </thead>
                                        <tbody>
                                        <tr class="text-bold table-success">
                                            <th>Pass Auto Mutation :
                                                <input type="radio" style="width: 15px; height: 15px" name="order" value="P" class="order checkthis" checked required>
                                            </th>
                                            <th>Stop Auto Mutation :
                                                <input type="radio" style="width: 15px; height: 15px" name="order" value="H" class="order" required>
                                            </th>
                                        </tr>
                                        <tr id="hold_reason" class="hidden">
                                            <th colspan="100%">Reason of stop auto mutation <sapn class="red">*</sapn> :
                                                <textarea name="holding_reason" class="form-control" placeholder="Reason of stop auto mutation..!"></textarea>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr style="border-bottom: 2px solid #000;">

                                </div>


                                <div class="col-lg-12">
                                    <center>
                                        <input type="hidden" name="petition_no" id='petition_no'
                                               value="<?= $data->petition_no ?>">
                                        <input type="hidden" name="co_code"
                                               value="<?= $this->session->userdata('user_code') ?>">
                                        <input type="hidden" name="lm_code" value="<?= $lmcode ?>">
                                        <input type="hidden" name="sk_code" value="<?= $user_code ?>">
                                        <input type="hidden" name="dist_code" id="dist_code_lm"
                                               value="<?= $data->dist_code ?>">
                                        <input type="hidden" name="subdiv_code"
                                               id="subdiv_code_lm" value="<?= $data->subdiv_code ?>">
                                        <input type="hidden" name="cir_code"
                                               value="<?= $data->cir_code ?>" id="cir_code_lm">
                                        <input type="hidden" name="mouza_pargona_code"
                                               value="<?= $data->mouza_pargona_code ?>" id="mouza_pargona_code_lm">
                                        <input type="hidden" name="lot_no"
                                               value="<?= $data->lot_no ?>" id="lot_no_lm">
                                        <input type="hidden" name="vill_townprt_code"
                                               value="<?= $data->vill_townprt_code ?>" id="vill_townprt_code_lm">
                                        <div id="error_u_message"></div>
                                        <div id="submit_btn">
                                            <?php 
                                            $allowedCases = json_decode(AUTOMUT_ALLOW_BEFORE_NOTICE_PERIOD, true);
                                            $allowBypass = in_array($data->noc_no, $allowedCases);

                                            $date_for_notice_check = date('Y-m-d g:i:s', strtotime('-'.AUTOMUTATION_NOTICE_PERIOD));
                                            if($allowBypass || $data->notice_generated_date<$date_for_notice_check):
                                             if ($data->trans_code == '03' && $deed != null):
                                                if(sizeof($sro)==1){?>
                                                <?php if ($buttonEnabledFlag == 1) { 
                                                if(($data->dist_code==$this->session->userdata('dist_code')) && ($data->subdiv_code==$this->session->userdata('subdiv_code')) && ($data->cir_code==$this->session->userdata('cir_code'))){?>
                                                <button type="submit" class="btn btn-sm btn-primary" id="submit_button"><i
                                                            class='fa fa-check'></i>&nbsp;
                                                    Pass Auto Mutation
                                                </button>
                                            <?php }}}?>

                                           <!--  <?php //if($mutation_no){?>
                                            <button type="button" class="btn rejectCO btn-sm btn-warning">
                                            <i class='fa fa-backward'></i>&nbsp;<b>Dispose without Reject</b>
                                            </button>
                                             <?php //}?> -->
                                                <button type="submit" class="btn btn-sm btn-success hidden" id="hold_button"><i
                                                            class='fa fa-hand-grab-o'></i>&nbsp;
                                                    Stop Auto Mutation
                                                </button>
                                            <?php elseif ($data->trans_code == '03' && $deed == null): ?>
                                            <span class="red bold">DEED DETAILS NOT FOUND..!</span> <br>
                                            <?php endif; ?>
                                            <?php else: ?>
                                                <span class="red bold">
                                                Notice have been generated for this case on <?php echo date('Y-m-d',strtotime($data->notice_generated_date))?>.
                                                The case can be delivered on or after  <?php echo date('Y-m-d', strtotime(AUTOMUTATION_NOTICE_PERIOD,strtotime($data->notice_generated_date)));?> .</span> <br>
                                            <?php endif; ?>
                                            <!-- <?php //if ($data->trans_code != '03'): ?>
                                                <button type="submit" class="btn btn-sm btn-primary" id="submit_button"><i
                                                            class='fa fa-check'></i>&nbsp;
                                                    Pass Auto Mutation
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-success hidden" id="hold_button"><i
                                                            class='fa fa-hand-grab-o'></i>&nbsp;
                                                    Stop Auto Mutation
                                                </button>
                                            <?php //endif; ?> -->
                                            <?php if(ENABLE_RJCT_COMPOSITE == 1){ ?>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$case_no?>','<?=SERVICE_AUTO_MUTATION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                            <?php } ?>
                                            <a href="<?= base_url() ?>index.php/CompositeService/getPendingCasesCO"
                                               class="btn btn-sm btn-danger">
                                                <i class="fa fa-arrow-left"></i> Back To Pending Cases
                                            </a>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.onload = function() {
        $('.checkthis').prop("checked", true);
        $('#submit_button').show();
        $('#hold_button').addClass('hidden');
        $('#hold_reason').addClass('hidden');
    }

    $('input[type=radio][name=order]').change(function() {
        if (this.value == 'P') {
            $('#submit_button').show();
            $('#hold_button').addClass('hidden')
            $('#hold_reason').addClass('hidden');
        }
        else if (this.value == 'H') {
            $('#submit_button').hide();
            $('#hold_button').removeClass('hidden')
            $('#hold_reason').removeClass('hidden');
        }
    });


    $('#finalOrderOfcMutationPassCO').submit(function (e) {
       

        var ENABLED_BLOCKCHAIN= $('#ENABLED_BLOCKCHAIN').val();
        var ENABLED_BLOCKCHAIN_FOR_DIST= $('#ENABLED_BLOCKCHAIN_FOR_DIST').val();

        var ulpinflag = null;
        var compareCheckFlag = null;

        if(ENABLED_BLOCKCHAIN == 1 && ENABLED_BLOCKCHAIN_FOR_DIST != 'NA')
        {
            var ulpinCheckFlag = $('#ulpinCheckFlag').val();
            var compareCheckFlag = $('#compareCheckFlag').val();
            var encoded_case_no = $('#encoded_case_no').val();
        }


        $('#doc1, #doc2').attr('disabled', true);
        let formData = $('#finalOrderOfcMutationPassCO').serialize();
        $('#doc1, #doc2').attr('disabled', false);

        e.preventDefault();
        if (!confirm(" Are you sure want to submit?")) {
            return;
        }

        

        $.ajax({
            url: baseurl + "CompositeService/finalOrderOfcMutationPassCO",
            type: 'POST',
            // data: $('#finalOrderOfcMutationPassCO').serialize(),
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                $('.loader').addClass('trans');
                $('.loader').removeClass('hide');
                $('#submit_btn').hide();
            },
            success: function (data) {
                // console.log(data);
                $('.loader').addClass('hide');
                $('.loader').removeClass('trans');

                if (data.error === false) {
                    $('#error_u_message').html('');
                    $('#error_u_message')
                        .html('<div class="green bold p-2 center">' + data.msg +
                            '<br><br>' +
                            '<a href="' + baseurl + 'home/index"> <button type="button" class="btn btn-primary">' +
                            '<i class="fa fa-view"></i> Go to Dashboard</button></a>' +
                            '</div>');
                    // window.location.href = baseurl + "home/index";
                     swal.fire({
                        icon: 'warning',
                        title: 'Sign and Pass Case',
                        html: data.msg
                    }).then(function() {

                        if(ENABLED_BLOCKCHAIN == 1 && ENABLED_BLOCKCHAIN_FOR_DIST != 'NA')
                        {
                            if(compareCheckFlag == 'Y' && ulpinCheckFlag ==1)
                            {
                                window.location.href = baseurl + "PropChainReport/sendPropChain/" + encoded_case_no
                                return;
                            }
                        }
                        
                    })
                    // return;
                }

                if (data.error === true) {
                    $('#submit_btn').show();
                    $('#error_u_message').html('');
                    $('#error_u_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">' + data.msg +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    return;
                }
            },
            error: function (jqXHR, exception) {
                $('#submit_btn').show();
                $('.loader').addClass('hide');
                if(jqXHR.status == 403){
                    let err_msg = jqXHR.responseJSON.errors;
                    $('#error_u_message')
                        .html(`<div class="bg-gradient-danger p-2 rounded"> ${err_msg} <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>`);
                }else{
                    alert('Error [#OMCS101]: Could not Complete your Request (AJAX ERROR)..!');
                }
            }
        });
    });
</script>

<script>
    $("#seeJamaClick").click(function(event){
        $("input[name='patta_type']").val($('#patta_type').val());
        $("input[name='patta_no']").val($('#patta_no').val());
        $('#seeJama').submit();
    });
    $(function () {
        $('.panel').on('click', '.astreport', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
        });

        $('#skmodal').on('hidden.bs.modal', function () {
            $('body').css('padding-right', 0);
        })
    });

    ////////
$('.uploadOMutDocumentCO').click(function(){
        $('#alert_message').html('');
        $('#alert_message').hide();
        flag = $(this).attr('id');
    
        var formdata = new FormData();

        if(flag == 1){
            formdata.append("doc1_file", $('#doc1_file')[0].files[0]);
            formdata.append("doc1", $('#doc1').val());
        }
        if(flag == 2){
            formdata.append("doc2_file", $('#doc2_file')[0].files[0]);
            formdata.append("doc2", $('#doc2').val());
        }

        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        // formdata.append("dist_code", $('#dist_code').val());

        // console.log(formdata);

        $.ajax({
            url: baseurl + "CompositeService/uploadSupportiveDocs/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                }

                if(data.flag_set == '1'){
                     $('#div_death').html('');
                     $('#file_1').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO" id="1">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '2'){
                    $('#div_noc').html('');
                    $('#file_2').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO" id="2">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
            
                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);

                    return false;
                }

            },error: function(errors){
                $('#alert_message').html('');
                $('#alert_message').fadeIn();
                if(errors.status == 403){
                    let err_msg = errors.responseJSON.errors;
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">${err_msg}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }else{
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong. Please try again later.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
            }
        });
    });

$(document).on('click','.removeOMutReportDocumentCO', function(){
        $('#alert_message').html('');
        $('#alert_message').hide();
        flag = $(this).attr('id');

        case_no = $('#case_no').val();
    //     doc1 = $('#doc1').val();
    //     doc2 = $('#doc2').val();
    //    //alert(flag);
    //     data = {flag:flag, case_no:case_no, doc1:doc1, doc2:doc2}

    //     if(flag==1){certificate = 'Document 1';}
    //     if(flag==2){certificate = 'Document 2';}

        data = {flag:flag, case_no:case_no}

        if(flag==1){
            certificate = 'Document 1';
            doc1 = $('#doc1').val();
            data = {...data,  doc1:doc1};
        }
        if(flag==2){
            certificate = 'Document 2';
            doc2 = $('#doc2').val();
            data = {...data,  doc2:doc2};
        }

        if(confirm("Are you sure to delete " +certificate+ " ?")){

            $.ajax({
                url: baseurl + "CompositeService/removeSupportiveDocs/",
                type: 'POST',
                data: data,
                dataType: "json",

                success: function (data) 
                {
                    console.log(data);
                    if(data.flag == '1'){
                        $('#file_1').html('');
                        $('#div_death').html('');
                    }
                    if(data.flag == '2'){
                        $('#file_2').html('');
                        $('#div_noc').html('');
                    }
                    if(data.flag == '3'){
                        $('#file_3').html('');
                        $('#div_nok').html('');
                    }
                },error: function(errors){
                    $('#alert_message').html('');
                    $('#alert_message').fadeIn();
                    if(errors.status == 403){
                        let err_msg = errors.responseJSON.errors;
                        $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">${err_msg}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    }else{
                        $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong. Please try again later.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    }
                }
            });
        }  
    });

$(".rejectCO").click(function(event){
              event.preventDefault();
              $("#rejectCO").modal('show');
      });

$(document).on('click','.btnRevertClose', function(){
        $('#rejectCO').modal('hide');
    });

</script>

<div id="rejectCO" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dispose reason</h5>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/CompositeService/rejectCO" method="post" >
                <div class="modal-body">
                    <input type="hidden" class="form-control" id='noc_no' name='noc_no' 
                    value="<?=$data->noc_no?>">
                    <input type="hidden" class="form-control" name='case_no' 
                    value="<?=$case_no?>">
                    <input type="hidden" name="dist_code" value="<?=$data->dist_code?>">
                    <input type="hidden" name="subdiv_code"  value="<?=$data->subdiv_code?>">
                    <input type="hidden" name="cir_code" value="<?=$data->cir_code?>">
                    <div>
                       <kbd> Cases already disposed against the NOC : <?=$data->noc_no?></kbd>
                        <ul>
                        <?php foreach ($mutation_no as $row):?>
                        <li>
                          <input type="checkbox" id="mutation" name="mutation[]" value="<?= $row->case_no ?>">
                          <label for="mutation"><?= $row->case_no ?></label>
                        </li>
                    <?php endforeach; ?>
                      </ul>
              
                    </div>
                    <textarea name='co_report' id="co_report" class="form-control" placeholder="Remark" required></textarea> 
                    <textarea name="co_report_suffix" class="form-control hide" 
                    rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"  onclick="return validateForm();">Save</button>
                    <button type="button" class="btn btn-sm btn-default btnRevertClose" id="">Close</button>
                </div>
            </form> 
        </div>
    </div>
</div>
<script type="text/javascript">
    function validateForm() {
    var coReport = document.getElementById("co_report").value;
    var mutation = document.getElementById("mutation");

    if (mutation.checked) {
        var mutationNo=mutation.value;
        if (mutationNo.trim() < 1) {
          alert("Please select the checkboxhb!");
          return false; // Prevent form submission
        }
        if (coReport.trim() < 1) {
        alert("Please enter a remark.");
        return false; // Prevent form submission
    }
   
    }

    else{
         alert("Please select checkbox!");
         return false;
    }
   
  }



$('#verify_button').click(function(){
        $('#alert_message').html('');
        $('#alert_message').hide();

        $('.loader').show();

        //var noc_no = $('#noc_no').val();
        //console.log(noc_no);return;

        var formdata = new FormData();
        formdata.append("noc_no", $('#noc_no').val());

        $.ajax({
            url: baseurl + "CompositeService/getSronotebyNOC_ajax/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",
            beforeSend: function () {
                $('.loader').addClass('trans');
                $('.loader').removeClass('hide');
                $('#submit_btn').hide();
            },

            success: function (data) 
            {
                //console.log(data.msg);
                $('.loader').addClass('hide');
                $('.loader').removeClass('trans');
        
                if(data.error != null)
                {
                  alert(data.msg);
                
                }

                else if(data.success != null)
                {
                  alert(data.msg);
                  location.reload();
                
                }

                else
                {
                    alert(data.msg);
                }

            },error: function(errors){
                $('#alert_message').html('');
                $('#alert_message').fadeIn();
                if(errors.status == 403){
                    let err_msg = errors.responseJSON.errors;
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">${err_msg}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }else{
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong. Please try again later.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
            }
        });
    });

</script>

<?php include(APPPATH."views/CompositeService/editInplaceAlongwith.php"); ?>
<script src="<?php echo base_url();?>js/CompositeService/editInplaceAlongwith.js"></script>