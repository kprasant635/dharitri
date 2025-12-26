<?php
$guard = "";
$count = 1;
foreach ($pattadars as $p):
    ?>
    <p class='regular uni_text'><?php $count++ . ") <span class='text-danger'>" . $p->pdar_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->pdar_rel_guar) . " : " . $p->pdar_guardian; ?></p>
    <?php
    $sellername = $p->pdar_name;
    $seller_father = $p->pdar_guardian;
    $seller_relation = $this->utilityclass->get_relation($p->pdar_rel_guar);
endforeach;
?>

<?php
$hide=null;
$guard = "";
$count = 1;
$appname = "";
foreach ($petitioner as $p):
    ?>
    <p class='regular uni_text'><?php
        $count++ . ") <span class='text-danger'>" . $p->pet_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->guard_rel) . " : " . $p->guard_name;
        $appname .=$p->pet_name . ",";
        $appname_father = $p->guard_name;
        $app_relation = $this->utilityclass->get_relation($p->guard_rel);
        ?></p>
    <?php
endforeach;
$appname = rtrim($appname, ",");
?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Office Mutation Order</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    
                    <div class="panel-body">
                    <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
                        <input type="hidden" name="dist_code" value="<?=$data->dist_code;?>">
                        <input type="hidden" name="subdiv_code"  value="<?=$data->subdiv_code;?>">
                        <input type="hidden" name="circle_code" value="<?=$data->cir_code;?>">
                        <input type="hidden" name="mouza_code" value="<?=$data->mouza_pargona_code;?>">
                        <input type="hidden" name="lot_no" value="<?=$data->lot_no;?>">
                        <input type="hidden" name="vill_code" value="<?=$data->vill_townprt_code;?>">
                        <input type="hidden" name="patta_type" value="<?=$data->patta_type_code?>">
                        <input type="hidden" name="patta_no" value="<?=$data->patta_no?>">
                    </form>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <b style="float:right;background: #fff57f;padding: 4px;">Chitha and Jamabandi Details</b>
                            <br>
                        
                            <div class="col-lg-12">
                            <a style="float:right" target="_blank" href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $data->dag_no. '&m=' . $data->mouza_pargona_code . '&l=' . $data->lot_no. '&v=' . $data->vill_townprt_code . '&p=' . $data->patta_type_code. '&dist=' . $data->dist_code . '&cir=' . $data->cir_code . '&sub_div=' . $data->subdiv_code ?>">
                                         <i class="fa fa-link" aria-hidden="true"></i><u><span class="text-primary" style="font-size:16px;">Dag No. <?=$data->dag_no?> (Chitha View)</span></u>
                                      </a>
                            </div>
                            <div class="col-lg-12">
                            <button style="float:right" id="seeJamaClick">
                                 <i class="fa fa-link" aria-hidden="true"></i>
                                 <span class="text-primary" style="font-size:16px;color:#ffb81d">Patta No. <?=$data->patta_no?> (Jamabandi View)</span>
                            </button>
                            </div>
                        </div>


                        <form method='post' id="finalOrderOfcMutationPassCO" enctype="multipart/form-data">
                            <div class="row">

                                <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                { ?>

                                    <!-- hidden fields -->
                                    <input type="hidden" name="ulpin" id="ulpin" value="<?= $ulpin ?>" />
                                    <input type="hidden" name="chain_revenue" id="chain_revenue" value="<?= $revenue ?>" />
                                    <input type="hidden" name="chain_local_tax" id="chain_local_tax" value="<?= $local_tax ?>" />
                                    <input type="hidden" name="ulpinCheckFlag" id="ulpinCheckFlag" value="<?= $ulpinCheckFlag ?>" />
                                    <input type="hidden" name="compareCheckFlag" id="compareCheckFlag" value="<?= $compareCheckFlag ?>" />
                                    <?php if (isset($old_ulpin)) { ?>
                                        <input type="hidden" name="old_ulpin" id="old_ulpin" value="<?= $old_ulpin ?>" />
                                    <?php } 

                                }?>
                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                    <?php if(ESCALATION_ENABLE == 1){ ?>
                                        <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">

                                  <?php include(APPPATH."views/escalation/remaining_time.php");
                                    ?>
                                    <?php } ?>
                                    

                            <?php
                            ////// BARAK VALLEY CODE START ////////////
                                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){

                                    $coname = $this->utilityclass->getSelectedCOName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $this->session->userdata('user_code'));
                                    //var_dump($coname);
                                    if ($trans_code == 03) {
                                        $message = "আবেদনকারী একটি আবেদন দায়ের করেছেন এবং মামলাটি |"
                                                . "আবেদনকারী " . " $appname " . "মধ্যে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজার অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী $dag->patta_no নং পট্টার "
                                                . "$dag->dag_no নং দাগর অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (ছটাক) " . $dag->m_dag_area_g . "  (গণ্ডা) মাটিত খ:দ: সূত্ৰে একটি নাম পেতে চান |"
                                                . "তারিখ অনুযায়ী নোটিশ জারি করা হয় এবং নোটিশের সময়কালের মধ্যে কোনও আপত্তি ইত্যাদি পাওয়া যায়নি । "
                                                . "আবেদনকারীর দায়ের করা " . date('d/m/Y', strtotime($data->date_entry)) . " ইং তারিখের $data->deed_no নম্বর: নথি দেখা হয়েছে | "
                                                . "একটি ডকুমেন্টের মাধ্যমে আবেদনকারী  " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজার অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী $dag->patta_no নং পট্টার $dag->dag_no নং "
                                                . "দাগের অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (ছটাক) " . $dag->m_dag_area_g . " (গণ্ডা) পাট্টাদারের $sellername থেকে মাটি নিষ্কাশন করা হয় | ভূমিলেখ্য সহায়ক এর রিপোর্ট অনুযায়ী আবেদনকারীর কাছে খারিদা জমির দখল রয়েছে | "

                                                . "তাই " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী $dag->patta_no নং পট্টার $dag->dag_no নং দাগের অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (ছটাক) " .$dag->m_dag_area_g . " (গণ্ডা) মাটিতে খারিদা "
                                                . "দখল সূত্র মধ্যে পাট্টাদার  $sellername এর আবেদনকারীদের সাথে  $appname এর নাম অনুদান সম্পন্ন হয়েছে |";
                                        
                                    } elseif ($trans_code == 01) {
                                        $message = " আবেদনকারী একটি আবেদন করেছেন এবং মামলাটি উপস্থাপন করা হয়েছে। | "
                                                . "আবেদনকারী " . " $appname " . "মধ্যে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজার অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী $dag->patta_no নং পাট্টার "
                                                .  "উত্তরসূরি সূত্রে মৃত পাট্টাদার $sellername স্থানে $dag->dag_no জন্য একটি নাম চাওয়া হয়েছে । "
                                                . " তারিখ অনুযায়ী বিজ্ঞপ্তি জারি করা হয় এবং নোটিশের সময়সীমার মধ্যে কোনও আপত্তি আসেনি।  ।  আবেদনকারীর দ্বারা জমা দেওয়া ডেথ সার্টিফিকেট , গ্রামের বৃদ্ধের সার্টিফিকেট, শপথ ও সংশ্লিস্ট ভূমিলেখ্য সহায়ক এর প্রতিবেদন দেখা হয়েছে ।  "
                                                . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজার অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী $dag->patta_no নং পাট্টার পাট্টাদার  $appname $app_relation $appname_father"
                                                . " এর ইতিমধ্যে মৃত এবং আবেদনকারী মৃত পাট্টাদারের প্রকৃত উত্তরাধিকারী । "
                                                . "তাই " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অধীনে " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " এর খে: ম্যাদী $dag->patta_no নং পাট্টার $dag->dag_no নং দাগের মৃত পাট্টাদারের স্থানে আবেদনকারী: দখল সূত্র "
                                                . "$appname এর নাম অনুদান সম্পন্ন হয়েছে |";
                                    } else {
                                        $message = "আবেদনকারীর নামের আবেদন টি দেখা হয় । আবেদনকারী " .
                                                $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                                                . " " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                                                " গ্রাম " . $dag->patta_no . " নং পাট্টার " . $dag->dag_no . " নং দাগের " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (ছটাক) " .$dag->m_dag_area_g. " (গণ্ডা) জমির নাম খুঁজছেন |"

                                                . "ভূমিলেখ্য সহায়ক এবং ভূমিলেখ্য পৰ্যবেক্ষক ই সরজমিন পরিমাপ করে চিঠা ও জমাবন্দীর এক কপি প্রো-লেটার দখল ও বিরোধ সম্বন্ধে বিস্তারিত প্রতিবেদন দাখিল করেছেন | তারিখ অনুযায়ী বিজ্ঞপ্তি জারি করা হয় এবং নোটিশের সময়সীমার মধ্যে কোনও আপত্তি আসেনি । নামজাৰী মঞ্জুর সম্পন্ন হয়েছে | ";
                                    }

                                }
                                else //other than barak valley
                                {
                                    $coname = $this->utilityclass->getSelectedCOName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $this->session->userdata('user_code'));
                                    //var_dump($coname);
                                    if ($trans_code == 03) {
                                        $message = "আবেদনকাৰীয়ে হাজিৰ দাখিল কৰিছে আৰু গোচৰ উপস্থাপিত হৈছে |"
                                                . "আবেদনকাৰী " . " $appname " . "য়ে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ "
                                                . "$dag->dag_no নং দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . " মাটিত খ:দ: সূত্ৰে নামজাৰী বিচাৰিছে | "
                                                . "জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি পোৱা নাই | "
                                                . "আবেদনকাৰীয়ে দাখিল কৰা " . date('d/m/Y', strtotime($data->date_entry)) . " ইং তাৰিখৰ $data->deed_no  নং ৰে: দলিল চোৱা হ’ল | "
                                                . "উত্ত দলিল যোগে আবেদনকাৰীয়ে  " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ $dag->dag_no নং "
                                                . "দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "মাটি পট্টাদাৰ $sellername পৰা খৰিদ কৰে | ভূমিলেখ্য সহায়কৰ প্রতিবেদন মতে খৰিদা জমিত আবেদনকাৰীৰ দখল-আবাদ আছে | "
                                                . "সেয়েহে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ $dag->dag_no নং দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "  মাটিত খৰিদা "
                                                . "দখল সূত্ৰে পট্টাদাৰ  $sellername ৰ লগত আবেদনকাৰী  $appname ৰ নামজাৰী মঞ্জুৰ কৰা হ’ল |";
                                        
                                    } elseif ($trans_code == 01) {
                                        $message = " আবেদনকাৰীয়ে হাজিৰ দাখিল কৰিছে আৰু গোচৰ উপস্থাপিত হৈছে | "
                                                . "আবেদনকাৰী " . " $appname " . "য়ে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ  "
                                                . "$dag->dag_no নং দাগৰ মৃত পট্টাদাৰ   $sellername    স্থলত উত্তৰাধিকাৰী সূত্ৰে নামজাৰী বিচাৰিছে  | "
                                                . " জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি অহা নাই|আবেদনকাৰীয়ে দাখিল কৰা মৃত্যুৰ প্রমাণ পত্ৰ , গাওঁ বুঢ়াৰ প্রমাণ পত্ৰ ,শপত নামা আৰু সংশ্লিস্ট ভূমিলেখ্য সহায়কৰ প্রতিবেদন চোৱা হ’ল |  "
                                                . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ পট্টাদাৰ  $appname $app_relation $appname_father"
                                                . " ৰ ইতিমধ্যে মৃত্যু হৈছে আৰু আবেদনকাৰীজন মৃত পট্টাদাৰৰ প্রকৃত উওৰাধিকাৰী হয় | "
                                                . "সেয়েহে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ $dag->dag_no নং দাগৰ মৃত পট্টাদাৰ স্থলত উ:দ: দখল সূত্ৰে আবেদনকাৰী "
                                                . "$appname ৰ নামজাৰী মঞ্জুৰ কৰা হ’ল |";
                                    } else {
                                        $message = "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল । আবেদনকাৰীয়ে " .
                                                $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                                                . " " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                                                " গাৱৰ " . $dag->patta_no . " নং পট্টাৰ " . $dag->dag_no . " নং দাগৰ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "মাটিৰ নামজাৰী বিচাৰিছে |"
                                                . "ভূমিলেখ্য সহায়ক আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি চিঠা আৰু জমাবন্দীৰ এক কপিকৈ প্র-পত্রমতে দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিছে | জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি অহা নাই| নামজাৰী মঞ্জুৰ কৰা হ’ল | ";
                                    }    
                                }
                                ////// BARAK VALLEY CODE END ////////////
                            ?>
                            
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Basic Order Details</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>LRA Name:</td>
                                            <td>
                                                <span class="text-danger">
                                                <?php $lmcode = $lm_code;
                                                    $lms = $this->utilityclass->getDefinedMondalsName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $lmcode);
                                                    echo $lms->lm_name;
                                                ?>
                                                </span>
                                            </td>
                                            <td>LRA Sign Date:</td>
                                            <td><span class="text-danger"><?=date('d-m-Y', strtotime($lm_note_date))?></span></td>       
                                        </tr>
                                        <?php if($data->es_flag == 0)
                                        { ?>
                                            <tr>
                                            <td>LRS Name:</td>
                                            <td>
                                                <span class="text-danger">
                                                <?php 
                                                    $skname = $this->utilityclass->getSKByCode($data->dist_code, $data->subdiv_code, $data->cir_code, $user_code);
                                                    echo $skname->username;
                                                ?>
                                                </span>
                                            </td>
                                            <td>LRS Sign Date:</td>
                                            <td><span class="text-danger"><?=date('d-m-Y', strtotime($sk_note_date))?></span></td>       
                                        </tr>
                                        <?php }else ?>
                                        
                                        <tr>
                                            <td>CO Name:</td>
                                            <td>
                                                <span class="text-danger">
                                                <?php $coname = $this->utilityclass->getCOCode($data->dist_code, $data->subdiv_code, $data->cir_code, $this->session->userdata('user_code'));
                                                    echo $coname->username;
                                                ?>
                                                </span>
                                            </td>
                                            <td>CO Sign Date:</td>
                                            <td><span class="text-danger"><?=date('d-m-Y')?></span></td>       
                                        </tr>
                                        <tr>
                                            <td>Patta Type:</td>
                                            <td>
                                                <span class="text-danger">
                                                <?=$this->utilityclass->getPattaName($data->patta_type_code)?>
                                                </span>
                                                <input type="hidden" class="form-control" name="patta_type_code" value="<?=$data->patta_type_code?>" readonly/>
                                            </td>
                                            <td>Patta No:</td>
                                            <td><span class="text-danger"><?=$data->patta_no ?></span></td>       
                                        </tr>
                                        <tr>
                                            <td>Dag No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$data->dag_no?>
                                                </span>
                                            </td>
                                            <td>Case No:</td>
                                            <td><span class="text-danger"><?=$case_no?></span></td>
                                            <input type="hidden" value="<?=$case_no?>" id="case_no" name="case_no">
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>

                                
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff">Change Deed Details</th>
                                    </thead>
                                </table>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <span class="text-bold text-danger">Deed No</span>
                                    <input type="text" value="<?=$data->deed_no?>" name="deed_no" class="form-control" placeholder="Enter Deed No">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <span class="text-bold text-danger">Deed Date</span>
                                    <input type="text" class="form-control dating"
                                    value="<?=$data->deed_date?>" placeholder="Enter Deed Date"
                                    name="deed_date"  readonly style="background-color: white" />
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <span class="text-bold text-danger">Deed Value</span>
                                    <input type="text" name="deed_value" value="<?=$data->deed_value?>" class="form-control" placeholder="Enter Deed Value">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>

                                
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff">Change Transfer Type Details</th>
                                    </thead>
                                </table>

                                <?php $a= explode('/',$basundhara->basundhara);
                                if($a[1]=='MUTI'){?>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    
                                    <table>
                                      <td><span class="text-bold text-danger">Transfer Type  : </span></td>
                                      <td>
                                      <select class="" id='mut_type' name="mut_type" required="">
                                       <option value="<?=$data->trans_code?>"><?=$this->utilityclass->getTransferType($data->trans_code)?></option>
                                          <?php foreach($mut_type_inherit as $mut){ ?>
                                            <option value="<?=$mut['trans_code']?>"><?=$mut['trans_desc_as']?></option>
                                          <?php } ?>   
                                          </select>
                                      </td>
                                    </table>
                                </div>
                            <?php }else{?>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    
                                    <table>
                                      <td><span class="text-bold text-danger">Transfer Type  : </span></td>
                                      <td>
                                      <select class="" id='mut_type' name="mut_type" required="">
                                       <option value="<?=$data->trans_code?>"><?=$this->utilityclass->getTransferType($data->trans_code)?></option>
                                          <?php foreach($mut_type_deed as $mut){ ?>
                                            <option value="<?=$mut['trans_code']?>"><?=$mut['trans_desc_as']?></option>
                                          <?php } ?>   
                                          </select>
                                      </td>
                                    </table>
                                </div>
                            <?php }?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                            
                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">Modify Mutated Land Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th></th>
                                            <th>B (বি :)</th>
                                            <th>K (ক :)</th>
                                            <th>L (লে :)</th>
                                            <th>G (গ :)</th>
                                            <th>Kr (ক্ৰা :)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?=$this->lang->line('total_land_area')?></td>
                                            <td>
                                                <span class="text-bold"><?=$data->dag_area_b?></span>
                                                <input type='hidden' id="b" 
                                                value="<?=$data->dag_area_b?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$data->dag_area_k?></span>
                                                <input type='hidden' maxlength="2" id="k"
                                                value="<?=$data->dag_area_k?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$data->dag_area_lc?></span>
                                                <input type='hidden' maxlength="5" id="lc" 
                                                value="<?=$data->dag_area_lc?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$data->dag_area_g?></span>
                                                <input type='hidden' maxlength="2" id="g" 
                                                value="<?=$data->dag_area_g=null?0:$data->dag_area_g?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$data->dag_area_kr?></span>
                                                <input type='hidden' maxlength="2" id="kr"
                                                value="<?=$data->dag_area_kr?>"/>
                                            </td>
                                        </tr>
                                         <?php
                            ////// BARAK VALLEY CODE START ////////////
                                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>

                                        <tr>
                                            <td class="text-red text-bold"><?=$this->lang->line('mutated_land_area')?></td>
                                            <td>
                                                <input type='number' maxlength="6" name="mut_b" id="mut_b_kr" value="<?=$data->m_dag_area_b?>" />
                                                <div id="err_lm_report_mut_b"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_k" id="mut_k_kr" value="<?=$data->m_dag_area_k?>"/>
                                                <div id="err_lm_report_mut_k"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="5" name="mut_lc" id="mut_lc_kr" value="<?=$data->m_dag_area_lc?>" />
                                                <div id="err_lm_report_mut_lc"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_g" id="mut_g_kr" value="<?=$data->m_dag_area_g==null?0:$data->m_dag_area_g?>" />
                                                <div id="err_lm_report_mut_g"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_kr" id="mut_kr_kr" value="0" readonly />
                                            </td>
                                        </tr>
                                        <?php }else{?>
                                            <tr>
                                            <td class="text-red text-bold"><?=$this->lang->line('mutated_land_area')?></td>
                                            <td>
                                                <input type='number' maxlength="6" name="mut_b" id="mut_b" value="<?=$data->m_dag_area_b?>" />
                                                <div id="err_lm_report_mut_b"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_k" id="mut_k" value="<?=$data->m_dag_area_k?>"/>
                                                <div id="err_lm_report_mut_k"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="5" name="mut_lc" id="mut_lc" value="<?=$data->m_dag_area_lc?>" />
                                                <div id="err_lm_report_mut_lc"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_g" id="mut_g" value="<?=$data->m_dag_area_g==null?0:$data->m_dag_area_g?>" />
                                                <div id="err_lm_report_mut_g"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_kr" id="mut_kr" value="0" readonly />
                                            </td>
                                        </tr>
                                        <?php }?>

                                    </tbody>
                                </table>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">&nbsp;</div>


                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="7">Applicant Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>#</th>
                                            <th>Applicant`s Name</th>
                                            <th>Guardian Name</th>
                                            <th>Mobile No</th>
                                            <th>Address</th>
                                            <th>Edit | Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicant_list">
                                        <?php 
                                            foreach($applicants as $appl): 

                                            $address = (($appl->add2 == '')?$appl->add1:$appl->add1.' / '.$appl->add2);
                                            $mobile = (($appl->pdar_mobile == '')?'-':$appl->pdar_mobile);
                                        ?>
                                            <tr>
                                                <td><?=$appl->pet_id?></td>
                                                <td><?=$appl->pet_name?></td>
                                                <td><?=$appl->guard_name?></td>
                                                <td><?=$mobile?></td>
                                                <td><?=$address?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info btnApplivantEditCO" id="<?=$appl->pet_id?>" title="Edit Applicant"><i class="fa fa-edit"></i></button>

                                                    <button type="button" class="btn btn-sm btn-danger btnApplivantDeleteCO" id="<?=$appl->pet_id?>" title="Delete Applicant"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>


                                
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="7">Along With / Inplace of Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>#</th>
                                            <th>Pattadar Name</th>
                                            <th>Guardian Name</th>
                                            <th>Relationship</th>
                                            <th>Address</th>
                                            <th>Mutation Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pattadarAlongwith_list">
                                        <?php 
                                            $i=1;
                                            foreach($pattadars as $row): 

                                            $address = (($row->pdar_add2 == '')?$row->pdar_add1:$row->pdar_add1.' / '.$row->pdar_add2);
                                            $status = (($row->striked_out==1)?'Inplace':'Alongwith');
                                        ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$row->pdar_name?></td>
                                                <td><?=$row->pdar_guardian?></td>
                                                <td><?=$this->utilityclass->get_relation($row->pdar_rel_guar)?></td>
                                                <td><?=$address?></td>
                                                <td><?=$status?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info btnPattadarEditCO" id="<?=$row->pdar_id?>" title="Edit Pattadar"><i class="fa fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger btnPattadarDeleteCO" id="<?=$row->pdar_id?>" title="Delete Pattadar"><i class="fa fa-trash"></i></button>

                                                </td>
                                            </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>

                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                                <textarea class='form-control' style="border: 10px solid #ccc;" cols="10" rows="10" name='co_order'><?php echo $message;?></textarea>
                                
                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                                    <input type="hidden" class="form-control" name="by_right_of" value="<?php echo $trans_code; ?>" readonly>
                                    <hr style="border-bottom: 2px solid #000;">
                                </div>
                                <?php
                                include(APPPATH."views/common/addMoreDocumentView.php");
                                ?>
                                  <!-- /////////ESCALATION REMARK///////////// -->
                                  <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $data->es_flag == 1 && $data->out_of_esc == 0) { ?>
                                    <div class="col-lg-12">
                                        <div class="form-group col-md-4 text-right">
                                            <label> Cause For the case has not been pass in the timeline : </label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                        </div>
                                    </div>
                                  <?php } ?>
                                <div class="col-lg-12">
                                    <center>

                                        <!-- <input type="hidden" name="infavor_of_id" value="<?=$data->pet_id?>" /> -->
                                         <input type="hidden" name="basundhara" id='basundhara' value="<?=$basundhara->basundhara?>">
                                         <input type="hidden" name="petition_no" id='petition_no' value="<?=$data->petition_no?>">
                                        <input type="hidden" name="co_code" value="<?=$this->session->userdata('user_code')?>">
                                        <input type="hidden" name="lm_code" value="<?=$lmcode?>">
                                        <input type="hidden" name="sk_code" value="<?=$user_code?>">
                                        <input type="hidden" name="dist_code" id="dist_code_lm" 
                                        value="<?=$data->dist_code?>">
                                        <input type="hidden" name="subdiv_code" 
                                        id="subdiv_code_lm" value="<?=$data->subdiv_code?>">
                                        <input type="hidden" name="cir_code" 
                                        value="<?=$data->cir_code?>" id="cir_code_lm">
                                        <input type="hidden" name="mouza_pargona_code" 
                                        value="<?=$data->mouza_pargona_code?>" id="mouza_pargona_code_lm">
                                        <input type="hidden" name="lot_no" 
                                        value="<?=$data->lot_no?>"id="lot_no_lm">
                                        <input type="hidden" name="vill_townprt_code"value="<?=$data->vill_townprt_code?>" id="vill_townprt_code_lm">
                                        <input type="hidden" id="patta_no" name="patta_no"
                                        value="<?=$data->patta_no?>"/>
                                        <input type="hidden" id="patta_type_code_lm" value="<?=$data->patta_type_code?>"/>

                                        <input type='hidden' name='dag_no' value='<?=$data->dag_no?>'/>


                                        <?php
                                            if($restriction){?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Is Original inhabitants <small class="text-success">(both parties, i.e. buyer and seller)</small></label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="radio" id="yes" name="original_inhabitants" value="1">
                                                    <label for="Yes">Yes</label><br>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="radio" id="no" name="original_inhabitants" value="0">
                                                    <label for="No">No</label><br>
                                                </div>
                                                <div class="col-md-2">
                                                        <a href="<?php echo base_url() ?>assets\Original_inhabitants.pdf" target="_blank">Officiel Notification</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <em style="text-align: left;">(“Original inhabitants” mean “a person along with his family, who have been residing in that area for three generations”)</em>
                                            </div>
                                        <?php } ?> 
                                        <?php if(($data->dist_code==$this->session->userdata('dist_code')) && ($data->subdiv_code==$this->session->userdata('subdiv_code')) && ($data->cir_code==$this->session->userdata('cir_code'))){?>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check'></i>&nbsp; Pass Final Order</button>
                                    <?php }?>
                                        <span id='loading'></span>
                                        <!-- <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;Proceed to In favour of Details</button> -->
                                        
                                        <a href="<?=base_url()?>index.php/serviceOfcMutationController/getPendingMutationCases?id=<?=OFC_PROCEED_ID_2?>" class="btn btn-sm btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
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




<!---// Edit Applicant --->
<div class="modal" id="editAppl" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #136a6f; color: white">
                        <span class="text-bold">Update Applicant : &nbsp;&nbsp;<span id="appl_name"></span></span>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold">Applicant`s Name</span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <input type="text" class="form-control" name="pet_name" 
                        id="applicantNam" placeholder="<?php echo $this->lang->line('applicants_name') ?>" value="">
                        <div id="alert_appl"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold"><?php echo $this->lang->line('gender') ?></span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <select class="form-control" name="pet_gender" id='pet_gender'>
                        </select>
                        <div id="alert_gen"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 applicant_guard_name main_guard">
                        <span class="text-bold"><?php echo $this->lang->line('guardian_name') ?></span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <input type="text" class="form-control guard_name" 
                        name="guard_name" id="guard_name" value="<?=$appl->guard_name?>"
                        placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                        <div id="alert_guard_name"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold">Guardian Relation</span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <select class="form-control" id="relation_guardian">
                        </select>
                        <div id="alert_relation_guardian"></div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold">Mother`s Name</span>
                        <input type="text" class="form-control" name="pet_mother" id="mother_name"
                        placeholder="<?php echo $this->lang->line('mothers_name') ?>"  value="<?=$appl->pet_mother?>">
                        <div id="alert_mother_name"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <div id='dobyn_lm'>
                            <span class="text-bold">Date of Birth</span>
                            <input type="text" class="form-control dating" id="minor_dob" placeholder="<?php echo $this->lang->line('date_of_birth') ?>" name="pet_minor_dob" readonly style="background-color: white"
                            value="<?=date('Y-m-d', strtotime($appl->pet_minor_dob))?>"/>
                        </div>
                        <div id="alert_dob"></div>
                    </div>
                    <style type="text/css">
                        .datepick-popup{
                            position: fixed;
                            left:0 px;
                            right:0 px;
                            z-index:10000;
                        }
                    </style>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <span class="text-bold"><?php echo $this->lang->line('address1') ?></span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <input type="text" maxlength="100" class="form-control" name="add1"
                        id="add1" placeholder=" <?php echo $this->lang->line('address1') ?>"
                        value="">
                        <div id="alert_add1"></div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <span class="text-bold"><?php echo $this->lang->line('address2') ?></span>
                        <input type="text" maxlength="100" class="form-control" name="add2"
                        id="add2" placeholder="<?php echo $this->lang->line('address2') ?>"
                        value="">
                        <div id="alert_add2"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-sm btn-info btnUpdateApplicantCOO" id="appl_id" type="button"><b>Update Applicant</b></button>
                        <button type="button" class="btn btn-sm btn-default btnApplicantCloseModal" id="">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!---// Edit Applicant --->

<!---// Edit pattadar --->
<div class="modal" id="editPattadar" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #136a6f; color: white">
                        <span class="text-bold">Update Pattadar : &nbsp;&nbsp;<span id="pattadar_name"></span></span>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <span class="text-bold">Pattadar Name</span>
                        <input type="text" class="form-control" name="pdar_name" 
                        id="pdar_name" value="" readonly>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <span class="text-bold"><?=$this->lang->line('guardian_name')?></span>
                        <input type="text" class="form-control" name="guardian_name" 
                        id="guardian_name" value="" readonly>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <span class="text-bold"><?=$this->lang->line('relation') ?></span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <select class="form-control" name="guard_rel" id="guard_rel" disabled>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <span class="text-bold"><?=$this->lang->line('address1') ?></span>
                        <input type="text" class="form-control" readonly
                        name="pdar_add1" id="pdar_add1" value=""
                        placeholder="<?=$this->lang->line('address1') ?>">
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <span class="text-bold">Inplace/Alongwith</span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <select class="form-control" name="striked_out" id="striked_out">
                        </select>
                        <div id="alert_striked_out"></div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">&nbsp;</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-sm btn-info btnUpdatePattadarCO" id="p_id" type="button"><b>Update Pattadar</b></button>
                        <button type="button" class="btn btn-sm btn-default btnClosePattadarCO" id="">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!---// Edit pattadar --->


<script>
$(document).on('click', '.btnApplivantEditCO', function(){
    id = $(this).attr('id');
    var petition_no=$('#petition_no').val();
    //alert(id);
    $('#editAppl').modal('show');
    $.ajax({
        url: baseurl + "coofficemutation/getEditApplicantOmutCODetail",
        type:'POST',
        data:{id:id,petition_no:petition_no},
        dataType:'json',
        success: function (data) {
            console.log(data.petitioners);
            if(data.petitioners)
            {   
                $('#appl_name').html(data.petitioners.pet_name);

                var template = '';
                for (var i = 0; i < data.genders.length; i++) {
                    template += "<option value='" + data.genders[i].short_name + "' "+ ((data.genders[i].short_name == data.petitioners.pet_gender)?'selected':'') +">" + data.genders[i].gen_name_ass + "</option>";
                }
                $('#pet_gender').html(template);

                var template_rel = '';
                for (var j = 0; j < data.relation.length; j++) {
                    template_rel += "<option value='" + data.relation[j].guard_rel + "' "+ ((data.relation[j].guard_rel == data.petitioners.guard_rel)?'selected':'') +">" + data.relation[j].guard_rel_desc_as + "</option>";
                }
                $('#relation_guardian').html(template_rel);
                $('#applicantNam').val(data.petitioners.pet_name);
                $('#guard_name').val(data.petitioners.guard_name);
                $('#mother_name').val(data.petitioners.pet_mother);
                $('#minor_dob').val(data.petitioners.pet_minor_dob);
                $('#add1').val(data.petitioners.add1);
                $('#add2').val(data.petitioners.add2);
                $('#appl_id').val(data.petitioners.pet_id);
            }
        }
    });
});
$(document).on('click','.btnApplicantCloseModal', function(){
    $('#editAppl').modal('hide');
});
$(document).on('click', '.btnUpdateApplicantCOO', function(){
    id = $('#appl_id').val();
    gen = $('#pet_gender').val();
    rel = $('#relation_guardian').val();
    appl = $('#applicantNam').val();
    guard_name = $('#guard_name').val();
    mother = $('#mother_name').val();
    dob = $('#minor_dob').val();
    add1 = $('#add1').val();
    add2 = $('#add2').val();
    petition_no = $('#petition_no').val();
    $.ajax({
        url: baseurl + "coofficemutation/updateFinalOrderApplicantOmutCO",
        type:'POST',
        data:{id:id, gen:gen, rel:rel, appl:appl, guard_name:guard_name, mother:mother, dob:dob, add1:add1, add2:add2,petition_no:petition_no},
        dataType:'json',
        success: function (data) {
            console.log(data);
            if(data.success === false){
                alert("Updation Failed");
                return false;
            }
            if(data.basundhara === false){
                alert("Data Updation Failed");
                return false;
            }
            if(data.success === true)
            {
                alert("Applicant detail has successfully updated");
                $('#editAppl').modal('hide');
                var table = '';
                $.each(data.details, function (i, val) { 
                i++;

                address = ((val['add2'] == '')?val['add1']:val['add1']+' / '+val['add2']);
                mobile = ((val['pdar_mobile'] == '')?'-':val['pdar_mobile']);

                table +=                     
                    '<tr>'+
                        '<td>' + val["pet_id"] + '</td>' +
                        '<td>' + val["pet_name"] + '</td>' +
                        '<td>' + val["guard_name"] + '</td>' +
                        '<td>' + mobile + '</td>' +
                        '<td>' + address + '</td>' +
                        '<td> '+ 
                            '<button type="button" class="btn btn-sm btn-info btnApplivantEditCO" id="'+val['pet_id']+'" title="Edit Applicant"><i class="fa fa-edit"></i></button>'+ ' ' +
                            '<button type="button" class="btn btn-sm btn-danger btnApplivantDeleteCO" id="'+val['pet_id']+'" title="Delete Applicant"><i class="fa fa-trash"></i></button>'+
                        '</td>'+
                    '</tr>'
                });
                $('#applicant_list').html(table);
            }
            if(data.error)
            {
                $.each(data.error, function (index, value) {
                    $('#alert_'+value['field']).fadeIn();
                    $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                    setTimeout(function(){
                        $('#alert_'+value['field']).fadeOut();
                    }, 5000);
                });    
            }
        }
    });
});
$(document).on('click', '.btnApplivantDeleteCO', function(){
    id = $(this).attr('id');
    petition_no=$('#petition_no').val();
    $.ajax({
        url: baseurl + "coofficemutation/deleteFinalOrderApplicantOmutCO",
        type:'POST',
        data:{id:id,petition_no:petition_no},
        dataType:'json',
        success: function (data) {
            console.log(data);

            if(data.delete === false){
                alert("Deletion Failed: All petitioners cannot be deleted");
                return false;
            }
            if(data.details)
            {
                if(confirm("Are you sure to delete this applicant ?"))
                {
                    alert("Applicant has successfully Deleted");
                    var table = '';
                    $.each(data.details, function (i, val) { 
                    i++;

                    address = ((val['add2'] == '')?val['add1']:val['add1']+' / '+val['add2']);
                    mobile = ((val['pdar_mobile'] == '')?'-':val['pdar_mobile']);

                    table +=                     
                        '<tr>'+
                            '<td>' + val["pet_id"] + '</td>' +
                            '<td>' + val["pet_name"] + '</td>' +
                            '<td>' + val["guard_name"] + '</td>' +
                            '<td>' + mobile + '</td>' +
                            '<td>' + address + '</td>' +
                            '<td> '+ 
                                '<button type="button" class="btn btn-sm btn-info btnApplivantEditCO" id="'+val['pet_id']+'" title="Edit Applicant"><i class="fa fa-edit"></i></button>'+ ' ' +
                                '<button type="button" class="btn btn-sm btn-danger btnApplivantDeleteCO" id="'+val['pet_id']+'" title="Delete Applicant"><i class="fa fa-trash"></i></button>'+
                            '</td>'+
                        '</tr>'
                    });
                    $('#applicant_list').html(table);       
                }
            }
        }
    });
});
$(document).on("click", ".btnPattadarEditCO", function(){
    id = $(this).attr('id');
    petition_no = $('#petition_no').val();

    //alert(petition_no);
    $('#editPattadar').modal('show');
    $.ajax({
        url: baseurl + "coofficemutation/getEditPattadarOmutCODetail",
        type:'POST',
        data:{id:id, petition_no:petition_no},
        dataType:'json',
        success: function (data) {
            console.log(data.pattadars);
            if(data.pattadars)
            {   
                trans_code = data.pattadars.trans_code;
                console.log(trans_code);
                striked_out = data.pattadars.striked_out;
                $('#pattadar_name').html(data.pattadars.pdar_name);

                var template = '';
                template += "<option value='1' "+((striked_out==1)?'selected':'')+">Inplace</option>";
                template += "<option value='0'" +((striked_out==0)?'selected':'')+" "+((trans_code=='01' || trans_code=='11')?'disabled':'')+">Alongwith</option>";
                $('#striked_out').html(template);

                var template_rel = '';
                for (var j = 0; j < data.relation.length; j++) {
                    template_rel += "<option value='" + data.relation[j].guard_rel + "' "+ ((data.relation[j].guard_rel == data.pattadars.pdar_rel_guar)?'selected':'') +">" + data.relation[j].guard_rel_desc_as + "</option>";
                }
                $('#guard_rel').html(template_rel);
                $('#pdar_name').val(data.pattadars.pdar_name);
                $('#guardian_name').val(data.pattadars.pdar_guardian);
                $('#pdar_add1').val(data.pattadars.pdar_add1);
                $('#p_id').val(data.pattadars.pdar_id);
                $('#petition_no').val(data.pattadars.petition_no);
            }
        }
    });
});
$(document).on('click','.btnClosePattadarCO', function(){
    $('#editPattadar').modal('hide');
});
$(document).on('click', '.btnUpdatePattadarCO', function(){
    id = $('#p_id').val();
    petition_no = $('#petition_no').val();
    striked_out = $('#striked_out').val();
    $.ajax({
        url: baseurl + "coofficemutation/updateFinalOrderPattadarOmutCO",
        type:'POST',
        data:{id:id, striked_out:striked_out,petition_no:petition_no},
        dataType:'json',
        success: function (data) {
            console.log(data);
            if(data.type === 'audit'){
                alert(data.msg);
                return false;
            }
            if(data.alongwith === false){
                alert("Alongwith cannot be selected");
                return false;
            }
            if(data.basundhara === false){
                alert("Data Updation Failed");
                return false;
            }
            if(data.success === false){
                alert("Data Updation Failed");
                return false;
            }
            if(data.success === true)
            {
                alert("Pattadar detail has successfully updated");
                $('#editPattadar').modal('hide');
                var table = '';
                $.each(data.details, function (i, val) { 
                i++;
                address = ((val['pdar_add2'] == '')?val['pdar_add1']:val['pdar_add1']+' / '+val['pdar_add2']);
                status = ((val['striked_out']==1)?'Inplace':'Alongwith');
                table +=                     
                    '<tr>'+
                        '<td>' + val["pdar_cron_no"] + '</td>' +
                        '<td>' + val["pdar_name"] + '</td>' +
                        '<td>' + val["pdar_guardian"] + '</td>' +
                        '<td>' + val["pdar_rel_guar"] + '</td>' +
                        '<td>' + address + '</td>' +
                        '<td>' + status + '</td>' +

                        '<td> '+ 
                            '<button type="button" class="btn btn-sm btn-info btnPattadarEditCO" id="'+val['pdar_id']+'" title="Edit Pattadar"><i class="fa fa-edit"></i></button>'+ ' ' +
                            '<button type="button" class="btn btn-sm btn-danger btnPattadarDeleteCO" id="'+val['pdar_id']+'" title="Delete Pattadar"><i class="fa fa-trash"></i></button>'+
                        '</td>'+
                    '</tr>'
                });
                $('#pattadarAlongwith_list').html(table);
            }
        }
    });
});
$(document).on('click', '.btnPattadarDeleteCO', function(){
    id = $(this).attr('id');
    petition_no = $('#petition_no').val();
    $.ajax({
        url: baseurl + "coofficemutation/deleteFinalOrderPattadarOmutCO",
        type:'POST',
        data:{id:id,petition_no:petition_no},
        dataType:'json',
        success: function (data) {
            console.log(data);
            if(data.type == 'audit'){
                alert(data.details);
                return false;
            }

            if(data.delete === false){
                alert("Deletion Failed: All pattadars cannot be deleted");
                return false;
            }
            if(data.details)
            {
                if(confirm("Are you sure to delete this pattadar ?"))
                {
                    alert("Pattadar has successfully Deleted");
                    var table = '';
                    $.each(data.details, function (i, val) { 
                    i++;
                    address = ((val['pdar_add2'] == '')?val['pdar_add1']:val['pdar_add1']+' / '+val['pdar_add2']);
                    status = ((val['striked_out']==1)?'Inplace':'Alongwith');
                    table +=                     
                        '<tr>'+
                            '<td>' + val["pdar_cron_no"] + '</td>' +
                            '<td>' + val["pdar_name"] + '</td>' +
                            '<td>' + val["pdar_guardian"] + '</td>' +
                            '<td>' + val["pdar_rel_guar"] + '</td>' +
                            '<td>' + address + '</td>' +
                            '<td>' + status + '</td>' +

                            '<td> '+ 
                                '<button type="button" class="btn btn-sm btn-info btnPattadarEditCO" id="'+val['pdar_id']+'" title="Edit Pattadar"><i class="fa fa-edit"></i></button>'+ ' ' +
                                '<button type="button" class="btn btn-sm btn-danger btnPattadarDeleteCO" id="'+val['pdar_id']+'" title="Delete Pattadar"><i class="fa fa-trash"></i></button>'+
                            '</td>'+
                        '</tr>'
                    });
                    $('#pattadarAlongwith_list').html(table);
                }
            }
        }
    });
});
$('#finalOrderOfcMutationPassCO').submit(function(e){
    e.preventDefault();
    var form = $('#finalOrderOfcMutationPassCO')[0];
    var data = new FormData(form);
    
    var inps = document.getElementsByName('fileText[]');
    var uploads = document.getElementsByName('fileUpload[]');
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var file_name="fileText["+i+"].value="+inp.value;
        var file_upload = uploads[i].files[0];
        data.append(file_name, file_upload);
    }
    $.ajax({
        url: baseurl + "coofficemutation/finalOrderOfcMutationPassCO",
        type:'POST',
        enctype: 'multipart/form-data',
        data:data,
        //data:$('#finalOrderOfcMutationPassCO').serialize(),
        dataType:'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(){
                $("#loading").removeAttr("style");
                $("#loading").html("Validating ...Please wait...");
                $('.btn-sm').hide();
            },
        success: function (data) {
            console.log(data);
            if(data.lm_sk_note == '1122' )
            {
                alert("LM/SK report is missing. Please check LM/SK report");
                return false;
            }
            if(data.attachment == 'audit' )
            {
                $("#loading").css("color","red");
                $("#loading").html(data.error);
                $('.disable_forward').show();
                return false;
            }
            if(data.deed_updation == '101' )
            {
                alert("Deed detail updation failed");
                return false;
            }
            if(data.land_updation == '102' )
            {
                alert("Land updation failed");
                return false;
            }
            if(data.t_chitha_infavor == '103' )
            {
                alert("Insertion failed in t_chitha infavor of");
                return false;
            }
            if(data.inplace == '104' )
            {
                alert("Insertion failed in t_chitha iplace");
                return false;
            }
            if(data.pet_status == '105' )
            {
                alert("Updation failed in petition basic");
                return false;
            }
            if(data.sro_note == '106' )
            {
                alert("Updation failed in sro note");
                return false;
            }
            if(data.chitha_order_basic == '107' )
            {
                alert("Insertion failed in chitha order basic");
                return false;
            }
            if(data.trans_code == '4468' )
            {
                alert("Not a Valid Transfer Type or Transfer Type empty");
                return false;
            }
            if(data.pet_proceed == '108' )
            {
                alert("Insertion failed in petition proceeding");
                return false;
            }
            if(data.petitioner_nok == '109' )
            {
                alert("NOK insertion failed in petitioner.");
                return false;
            }if(data.attachment == '1001' )
            {
                alert("Error in File Uploading.. May be file not supported or File size is greater than 2MB");
                return false;
            }
            // edit for property chain
            if (data.success == true) {
                alert("Order Passed successful . Please check Chitha and Jamabandi Copy");
                window.location.href = data.redirect_url;
                return false;
            }

            if (data.chain_status == 0) {
                alert("Order Not Passed and Property Chain updation failed.");
                return false;
            } else if (data.chain_status == null) {
                alert("Error Occured. Order Not Passed and Unable to connect to property chain.");
                return false;
            }
        },
        error: function (e) {
            $("#loading").html("Error in proceessing");
            $('.disable_forward').show();
            console.log("ERROR :", e);
            return false;
        } 
    });
});

function landCalculation() 
{
    var bigha = $('#b').val();
    var katha = $('#k').val();
    var lessa = $('#lc').val();  
    var ganda = $('#g').val();
    var krantik = $('#kr').val();
    window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
    console.log(window.sourcelessa);

    var mbigha = $('#mut_b').val();
    var mkatha = $('#mut_k').val();
    var mlessa = $('#mut_lc').val();
    var mg = $('#mut_g').val();
    var mk = $('#mut_kr').val();
    window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
    
    if (window.sourcelessa < window.targetlessa) {
        alert('Mutated Land Area should be less than the area available in Chitha..');

        $('#mut_b').val(0);
        $('#mut_k').val(0);
        $('#mut_lc').val(0);
        $('#mut_g').val(0);
        $('#mut_kr').val(0);
    }

    if(parseInt(mkatha) >= 5)
    {
        bigha_cal = Math.floor((mkatha*20)/100);
        bigha_value = (mkatha*20)/100;
        bigha1 = bigha_value.toFixed(2);

        decimalbigha = bigha1 - Math.floor(bigha1);
        kathareminder = decimalbigha.toFixed(2);

        katha_cal = (kathareminder*100)/20;

        $('#mut_b').val(bigha_cal);
        $('#mut_k').val(katha_cal);
        $('#mut_lc').val(0);
        $('#mut_g').val(0);
        $('#mut_kr').val(0);
    }

    //lessa katha calculation
    if(parseInt(mlessa) >= 20)
    {   
        katha_cal = Math.floor((mlessa)/20);
        katha_value = (mlessa)/20;
        katha1 = katha_value.toFixed(2);

        decimalkatha = katha1 - Math.floor(katha1);
        lessa_cal = decimalkatha.toFixed(2);

        $('#mut_b').val(0);
        $('#mut_k').val(katha_cal);
        $('#mut_lc').val(lessa_cal);
        $('#mut_g').val(0);
        $('#mut_kr').val(0);
     }

    //lessa bigha calculation
    if(parseInt(mlessa) >= 100)
    {   
        bigha_cal = Math.floor((mlessa)/100);
        bigha_value = (mlessa)/100;
        bigha1 = bigha_value.toFixed(2);

        decimalbigha = bigha1 - Math.floor(bigha1);
        kathareminder = decimalbigha.toFixed(2);

        katha_cal = Math.floor((kathareminder*20)/100);
        katha_value = (kathareminder*20)/100;
        katha1 = katha_value.toFixed(2);

        decimalkatha = katha1 - Math.floor(katha1);
        lessa_cal = decimalkatha.toFixed(2);

        $('#mut_b').val(bigha_cal);
        $('#mut_k').val(katha_cal);
        $('#mut_lc').val(lessa_cal);
        $('#mut_g').val(0);
        $('#mut_kr').val(0);
    }
}

$('#mut_b').change(function(){
    landCalculation();
});
$('#mut_b_kr').change(function(){
    landCalculationKar();
});

$('#mut_k').change(function(){
    var mbigha = $('#mut_b').val();
    var mkatha = $('#mut_k').val();
    var mlessa = $('#mut_lc').val();

    landCalculation();
    
    if(parseInt(mkatha) >= 5)
    {
        bigha_cal = Math.floor((mkatha*20)/100);
        bigha_value = (mkatha*20)/100;
        bigha1 = bigha_value.toFixed(2);

        decimalbigha = bigha1 - Math.floor(bigha1);
        kathareminder = decimalbigha.toFixed(2);

        katha_cal = (kathareminder*100)/20;

        $('#mut_b').val(bigha_cal);
        $('#mut_k').val(katha_cal);
        $('#mut_lc').val(0);
    }
});
$('#mut_k_kr').change(function(){
    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    var mg = $('#mut_g_kr').val();

    landCalculationKar();
    
});

$('#mut_lc').change(function(){
    var mbigha = $('#mut_b').val();
    var mkatha = $('#mut_k').val();
    var mlessa = $('#mut_lc').val();
    landCalculation();
    //lessa katha calculation
    if(parseInt(mlessa) >= 20)
    {   
        katha_cal = Math.floor((mlessa)/20);
        katha_value = (mlessa)/20;
        katha1 = katha_value.toFixed(2);

        decimalkatha = katha1 - Math.floor(katha1);
        lessa_cal = decimalkatha.toFixed(2);

        $('#mut_b').val(0);
        $('#mut_k').val(katha_cal);
        $('#mut_lc').val(lessa_cal);
    }

    //lessa bigha calculation
    if(parseInt(mlessa) >= 100)
    {   
        bigha_cal = Math.floor((mlessa)/100);
        bigha_value = (mlessa)/100;
        bigha1 = bigha_value.toFixed(2);

        decimalbigha = bigha1 - Math.floor(bigha1);
        kathareminder = decimalbigha.toFixed(2);

        katha_cal = Math.floor((kathareminder*20)/100);
        katha_value = (kathareminder*20)/100;
        katha1 = katha_value.toFixed(2);

        decimalkatha = katha1 - Math.floor(katha1);
        lessa_cal = decimalkatha.toFixed(2);

        $('#mut_b').val(bigha_cal);
        $('#mut_k').val(katha_cal);
        $('#mut_lc').val(lessa_cal);
    }    
});

$('#mut_lc_kr').change(function(){
    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    landCalculationKar();
    //lessa katha calculation

});

$('#mut_g_kr').change(function(){
    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    var mg = $('#mut_g_kr').val();
    landCalculationKar();
    //lessa katha calculation

});

function landCalculationKar() 
{
    var bigha = $('#b').val();
    var katha = $('#k').val();
    var lessa = $('#lc').val();  
    var ganda = $('#g').val();
    var krantik = $('#kr').val();
    window.sourcelessa = parseFloat(bigha)*6400 + parseFloat(katha)*320 + parseFloat(lessa)*20+parseFloat(ganda);
    console.log(window.sourcelessa);

    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    var mg = $('#mut_g_kr').val();
    var mk = $('#mut_kr_kr').val();
    window.targetlessa = parseFloat(mbigha)*6400 + parseFloat(mkatha)*320 + parseFloat(mlessa)*20+parseFloat(mg);
    
    if (window.sourcelessa < window.targetlessa) {
        alert('Mutated Land Area should be less than the area available in Chitha..');

        $('#mut_b_kr').val(0);
        $('#mut_k_kr').val(0);
        $('#mut_lc_kr').val(0);
        $('#mut_g_kr').val(0);
        $('#mut_kr_kr').val(0);
    }

     if(parseInt(mkatha) >= 20)
        {
            alert("Maximum allowed size is 19");
            $('#mut_b_kr').val(0);
            $('#mut_k_kr').val(0);
            $('#mut_lc_kr').val(0);
            $('#mut_g_kr').val(0);
        }

        if(parseFloat(mlessa) >= 16)
        {
            alert("Maximum allowed size is 16");
            $('#mut_b_kr').val(0);
            $('#mut_k_kr').val(0);
            $('#mut_lc_kr').val(0);
            $('#mut_g_kr').val(0);
        }

        if(parseFloat(mg) >= 20)
        {   
            alert("Maximum allowed size is 20");
            $('#mut_b_kr').val(0);
            $('#mut_k_kr').val(0);
            $('#mut_lc_kr').val(0);
            $('#mut_g_kr').val(0);
        }
}
$("#seeJamaClick").click(function(event){
    $('#seeJama').submit();
});
</script>