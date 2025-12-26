<?php //echo '<pre>'; var_dump($co_details); die(); ?>

<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-12 col-lg-12">
            <?php
                // if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                // {
                //     include 'application/views/common/input_hidden_fields_and_func.php';
                // }
            ?>
            <div class="card card-success">
                <div class="card-header d-flex justify-content-between">
                    <p>Case No: <?php echo $petition_basic->case_no; ?></p>
                    <p>Second Proceeding Conversion Order</p>
                    <p>Date: <?php echo date('d-m-Y'); ?></p>
                </div>
                <div class="card-body">
                    <form action="" id="mainform">
                        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="case_no" id="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                                        <?php 
                                            $presence = $petition_lm_note_details->prem_pay_method;
                                            $p=round($petition_lm_note_details->prim_per_bigha, 2);
                                            $pt=round($petition_lm_note_details->prim_tot, 2);
                                            if($premium_rate_details->amount != 0 && $premium_rate_details->rate == 0) {
                                                $prem_percent = $premium_rate_details->amount . ' টকা ';
                                            }
                                            else if ($premium_rate_details->amount == 0 && $premium_rate_details->rate != 0) {
                                                $prem_percent = $premium_rate_details->rate . ' % ';
                                            }

                                        if (($petition_lm_note_details->jati_janajati_yn != 'Y') && ($petition_lm_note_details->freedom_fighter_yn != 'Y') && ($petition_lm_note_details->widow_yn != 'Y'))
                                        {
                                            $msg="";
                                        }
                                        else{
                                            $msg="আৰু ২৫% ৰেহাই পাচত";
                                        }
                                        if($premium_rate_details->approval_level == 'circle') {
                                            if($presence == '') {?>
                                                ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                জমী হয় | উক্ত মাটি পট্টাদাৰ আবেদনকাৰী এ হস্তান্তৰ কৰা নাই আৰু নিজে স্থায়ী ভাবে ভোগ দখল কৰি আছে আৰু ALRM ৰ ১০৫ ডফা মতে ম্যদীকৰনৰ উপযোগী বুলি প্রতিবেদনত প্ৰকাশ। জাননী ৰিতি মতে জাৰি হৈছে |<br><br>
                                                প্ৰতিবেদনৰ মতে 15-10-2024 তাৰিখৰ ৰাজহ বিভাগৰ অধিসূচনা eCF No. 565802/I/772771/2024 মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                সেয়েহে <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php 
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা'; 
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>
                                                
                                                <input type="hidden" name="co_notice" id="co_notice" class="form-control" value="ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                    
                                                ?> জমী হয় | উক্ত মাটি পট্টাদাৰ আবেদনকাৰী এ হস্তান্তৰ কৰা নাই আৰু নিজে স্থায়ী ভাবে ভোগ দখল কৰি আছে আৰু ALRM ৰ ১০৫ ডফা মতে ম্যদীকৰনৰ উপযোগী বুলি প্রতিবেদনত প্ৰকাশ। জাননী ৰিতি মতে জাৰি হৈছে |<br><br>
                                                প্ৰতিবেদনৰ মতে 15-10-2024 তাৰিখৰ ৰাজহ বিভাগৰ অধিসূচনা eCF No. 565802/I/772771/2024 মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                সেয়েহে <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা'; 
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                লেছা মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> টকা হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>"/>
                                            <?php }
                                            else { ?>
                                                <span style='color:red;'><?php echo $petition_basic->case_no; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location_details->cir_name; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <span style='color:red;'><?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা'; 
                                                    } 
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা'; 
                                                    }
                                                ?> 
                                                </span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>
                                                
                                                <input type="hidden" name="co_notice" id="co_notice" class="form-control" value="সহায়কে দাখিল কৰা <span style='color:red;'><?php echo $petition_basic->case_no; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location_details->cir_name; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <span style='color:red;'><?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }  
                                                ?> 
                                                </span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>"/>
                                            <?php
                                            }
                                        }
                                        else {
                                            $msg_report = $premium_area_details->ass_name;
                                            
                                            
                                            ?>
                                            <!-- ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                            <?php
                                                if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                    echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                }
                                                else {
                                                    echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                }
                                                
                                            ?> 
                                            জমী হয় | <br>
                                            প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> এলেকাৰ অন্তর্গত হয় | সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং বিধি অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণা অনুসৰি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম । <br> শুনানিৰ তথ্য ? <br> চক্ৰ বিষয়াৰ মন্তব্য ?
                                            <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>    -->
                                            
                                            <textarea name="co_notice" id="co_notice" class="form-control" cols="15" rows="15" required>ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা <?php
                                                if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                    echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                }
                                                else {
                                                    echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                } 
                                            ?> জমী হয় | উক্ত মাটি পট্টাদাৰ আবেদনকাৰী এ হস্তান্তৰ কৰা নাই আৰু নিজে স্থায়ী ভাবে ভোগ দখল কৰি আছে আৰু ALRM ৰ ১০৫ ডফা মতে ম্যদীকৰনৰ উপযোগী বুলি প্রতিবেদনত প্ৰকাশ। জাননী ৰিতি মতে জাৰি হৈছে |

শুনানিৰ তথ্য ?

চক্ৰ বিষয়াৰ মন্তব্য ?

প্ৰতিবেদনৰ মতে এই মাটি 15-10-2024 তাৰিখৰ ৰাজহ বিভাগৰ অধিসূচনা eCF No. 565802/I/772771/2024 মতে <?php echo $msg_report; ?> এলেকাৰ অন্তর্গত হয় | সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং বিধি অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণা অনুসৰি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা প্ৰিমিয়াম ।


<?php echo $co_details->username; ?>

চক্র বিষয়া, <?php echo $location_details->cir_name; ?></textarea>
                                            
                                            
                                        
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                               
                        
                            </tbody>
                        </table>
                      
                        <!--new addition for final order pass -->

                        <div class="row login panel-form">
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="panel">
                                    
                                    <div class="panel-body">
                                  

                                            <?php 
                                            $buttonEnabledFlag =1;
                                            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                            {
                                                if($propChainEnableFlag)
                                                {
                                                include 'application/views/common/propertyCheckDetails.php';
                                                }

                                            }?>
                                            <table class='table table-striped'>
                                                <tr class="hide">
                                                    <td width="50%">
                                                        <label for="inputEmail3"  class="col-sm-6 control-label"><?php echo $this->lang->line('sl_no'); ?></label>
                                                        <div class="col-sm-2">
                                                            <input type="text" readonly class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr> 
                                                <tr>
                                                    <td width="50%">
                                                        <label for="inputEmail3"  class="col-sm-6 control-label"><?php echo $this->lang->line('on_behalf_of_name'); ?></label>
                                                        <div class="col-sm-6"><label class="control-label" >
                                                                <?php
                                                                $count = 1;
                                                                $howmany = sizeof($pattadar_details) - 1;
                                                                foreach ($pattadar_details as $pa): {
                                                                        echo $pa->pdar_name;
                                                                        if ($count < sizeof($pattadar_details) - 1) {
                                                                            echo "<span style='color:red;'> , </span>";
                                                                            $count++;
                                                                        } elseif ($count == sizeof($pattadar_details) - 1) {
                                                                            echo "<span style='color:red;'> আৰু </span>";
                                                                            $count++;
                                                                        } else {
                                                                            echo " ";
                                                                        }
                                                                    }
                                                                endforeach;
                                                                ?></label>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('type_of_premium'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="prem_type" value="<?php echo $payment_type['chalan_name']; ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <?php
                                                if ($payment_type['type_of_premium'] != '003') {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('chalan_receipt_no'); ?></label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" name="chalan_no" value="<?php echo $payment_type['premium_reciept']; ?>" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('premium'); ?></label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" name="prem_amt" value="<?php echo $payment_type['premium_amount']; ?>" readonly>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="center">
                                                        <label><?php echo $this->lang->line('applicant_individual_land_portion'); ?></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="alert-danger center danger">
                                                        <?php echo $petition_dag_details->m_dag_area_b; ?>&nbsp;Bigha
                                                        <?php echo $petition_dag_details->m_dag_area_k; ?>&nbsp;Kotha 
                                                        <?php echo $petition_dag_details->m_dag_area_lc; ?>&nbsp;Lessa
                                                    </td>
                                                </tr>
                                                <tr class="hide">
                                                    <td colspan="2">
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="c_bigha" value="<?php echo $petition_dag_details->m_dag_area_b; ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr class="hide">
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_katha'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="c_kotha" value="<?php echo $petition_dag_details->m_dag_area_k; ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr class="hide">
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_lessa'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="c_lessa" value="<?php echo $petition_dag_details->m_dag_area_lc; ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="patta_type" value="<?php echo $patta_type_details->patta_type; ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="patta_no" value="<?php echo $petition_dag_details->patta_no; ?>" readonly>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php
                                                        if ($petition_basic->trans_code == 'F') {
                                                            echo "<span style='color:red;'>Since This is a Full Conversion the dag no will remain same and patta no will be Changed. Please select the new patta type from the drop down below.</span>";
                                                        } else {
                                                            echo "<span style='color:red;'>This is a Partial Conversion the dag no and patta no will be Changed. Please select the new patta type from the drop down below.</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('new_patta_type'); ?></label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control new_patta_type_by_dc" name="new_patta_type" required>
                                                                <option disabled selected>-- Select --</option>
                                                                <?php foreach($type as $r){ ?>
                                                                    <option value="<?=$r->type_code;?>"><?=$r->patta_type?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td><div id="msgfornotselectingpattatype" class="pull-left"></div></td>
                                                </tr>
                                                <?php
                                                if ($petition_basic->trans_code == 'F') {
                                                    ?>
                                                    <!-- <tr>
                                                        <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control newDag" id="" name="sugg_dag_no" value="<?php echo $petition_dag_details->dag_no; ?>" readonly>
                                                            </div>
                                                            <div id="msg1"></div>
                                                        </td>
                                                        <td>
                                                            <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control">
                                                                    <option disabled selected>-- Verify Old Dags --</option>
                                                                    <?php foreach($check_dag_no as $odag) {?>
                                                                    <option> <?php echo $odag->dag_no ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <label for="inputEmail3" class="col-sm-6 control-label hide"><?php echo $this->lang->line('existing_old_dag_no'); ?></label>
                                                            <div class="col-sm-6 hide">
                                                                <input type="text" class="form-control" name="old_dag_no" value="<?php echo $petition_dag_details->dag_no; ?>">
                                                            </div>
                                                        </td>
                                                    </tr> -->
                                                    <?php
                                                } else {
                                                    ?>
                                                    <!-- <tr>
                                                        <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control newDag" id="newDag" name="sugg_dag_no" value="<?php echo $datas['new_dag']; ?>">
                                                            </div>
                                                            <div id="msg1"></div>
                                                        </td>
                                                        <td>
                                                            <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control">
                                                                    <option disabled selected>-- Verify Old Dags --</option>
                                                                    <?php foreach($check_dag_no as $odag) {?>
                                                                    <option> <?php echo $odag->dag_no ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <label for="inputEmail3" class="col-sm-6 control-label hide"><?php echo $this->lang->line('existing_old_dag_no'); ?></label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control hide" name="old_dag_no" value="<?php echo $petition_dag_details->dag_no; ?>">
                                                            </div>
                                                        </td>
                                                    </tr> -->
                                                    <?php
                                                }
                                                ?>
                                                <!-- <tr>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_patta_no'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="newPatta" name="sugg_patta_no" value="<?php echo $datas['newpatta']; ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Pattas</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control">
                                                                <option disabled selected>-- Verify Old Patta --</option>
                                                                <?php foreach($check_patta_no as $odag) {?>
                                                                <option><?php echo $odag->patta_no ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-6 control-label hide"><?php echo $this->lang->line('existing_old_patta_no'); ?></label>
                                                        <div class="col-sm-6 hide">
                                                            <input type="text" class="form-control" name="old_patta_no" value="<?php echo $petition_dag_details->patta_no; ?>">
                                                        </div>
                                                    </td>
                                                </tr> -->
                                                <tr>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('dag_revenue'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="P_land" name="dag_revenue" value="<?php echo $datas['revenue']; ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('dag_local_tax'); ?></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="p_loc_tax" name="dag_local_tax" value="<?php echo $datas['local_tax']; ?>">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="hide">
                                                    <td colspan="2">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('pattadar_whole_land_will_be_converted'); ?></label>
                                                        <div class="col-sm-4">
                                                            <select name="land_portion_status" class="form-control">
                                                                <option value="N" selected><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="Y"><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $petition_basic->dist_code; ?>" readonly>
                                                <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $petition_basic->subdiv_code; ?>" readonly>
                                                <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $petition_basic->cir_code; ?>" readonly>
                                                <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $petition_basic->mouza_pargona_code; ?>" readonly>
                                                <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $petition_basic->lot_no; ?>" readonly>
                                                <input type="hidden" class="form-control" id="village" value="<?php echo $petition_basic->vill_townprt_code; ?>" readonly>
                                            </table>
                                    
                                        <center>
                                            <table>
                                                <tr>
                                                    <td colspan="2">
                                                        <!-- //property chain check -->
                                                    

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <?php if($this->session->flashdata('message')): ?>
                                                            <?php 
                                                                echo '
                                                                    <p style="color:red;">'.$this->session->flashdata('message').'</p>
                                                                ';
                                                            ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>  
                                </div>
                            </div>
                        </div>


                        <!--new addition for final order pass end -->



                        <div class="row" id="show_div">
                            <div class="col-sm-12">
                                <label class="rasid col-sm-4">
                                    <?php
                                    // foreach ($premium as $p) {
                                    //     $presence = $p->prem_pay_method;
                                    // }
                                    if($premium_rate_details->approval_level == 'circle')
                                    {
                                        if ($presence == '') {
                                            ?>
                                            <input type="radio" name="order_type" id="inlineRadio1" value="finalhukum" disabled> <?php echo $this->lang->line('final_order'); ?>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                </label>
                                
                            </div>
                            <div class="col-lg-12">
                               
                            </div>
                        </div>     
                    </form>
                    <hr style="border-bottom: 2px solid #000;">
                    <?php
                        // if($basundhar_application){
                        //     echo '<h6 class="red">Other Attachments</h6>';
                        //     foreach ($basundhara_attachment  as $attachment):
                        //     ?>
                        <!--         <p><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red fs-6" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></p> -->
                             <?php 
                        //     endforeach; 
                        // }
                        // else{
                        //     echo '<h6 class="red">Other Attachments</h6>';
                        //     foreach($supportive_documents as $docs):
                        //     ?>
                        <!-- //         <p><a class="red fs-6" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></p> -->
                             <?php
                        //     endforeach;
                        // }
                    ?>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <?php $buttonEnabledFlag =1; 
                    if($buttonEnabledFlag) { ?>
                        <?php if($petition_lm_note_details->land_trans_yn != 'N') { ?>
                            <?php if(ENABLE_BUTTON_CO_ACTION_AP != 0){?>
                            <!-- <button type="button" name="submit" id="mainFormSubmit" class="btn btn-success uni_text btnSubmit mr-2 ml-2"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button> -->
                            <?php if($buttonEnabledFlag == 1){ ?>
                                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Update Chitha</button>
                            <?php } ?>
                        <?php } } else { ?>
                            <?php if($patta_type_details->type_code == '0208') { ?>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$petition_basic->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <p style="color:red;">Nisfi Kheraz with non transferred land</p>
                            <?php } else { ?>
                                <?php if(ENABLE_BUTTON_CO_ACTION_AP != 0){?>
                                <button type="button" name="submit" id="mainFormSubmit" class="btn btn-success uni_text btnSubmit mr-2 ml-2"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                            <?php } } ?>
                        <?php } ?>
                        <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                        <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#formsubmit').click(function(){
        var case_no = $('#case_no').val();
        var co_notice = $('#co_notice').val();
        var hearing_date = $('#hearing_date').val();
        var order_type = $('input[name="order_type"]:checked').val();
        if(case_no == '' || co_notice == '' || hearing_date == '' || order_type == '') {
            swal.fire("", "Required Parameters are empty", "error")
            .then((value) => {
                
            });
            return false;
        }
        var new_patta_type = $('.new_patta_type_by_dc').val();
        if(new_patta_type == null)
        {
            document.getElementById("msgfornotselectingpattatype").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Please Select the New Patta Type</p></label>";
            return false;
        }

        var form = document.getElementById("mainform");
        console.log(form);
        var formData = new FormData(form);
        var baseurl = $('#baseurl').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + 'index.php/conversion/CoConversionController/coFinalOrderPostNew',
            method: 'POST',
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.unblockUI();
                if(response.responseType == 2) {
                    swal.fire("", response.success, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                else if (response.responseType == 1) {
                    swal.fire("", response.error, "error;")
                    .then((value) => {
                        
                    });
                }
            },
            error: function(err) {
                $.unblockUI();
                console.log(err);
            }
        });

        
        console.log(order_type);
    })
    $(document).on('click', '#mainFormSubmit', (e) => {
        var case_no = $('#case_no').val();
        var co_notice = $('#co_notice').val();
        var hearing_date = $('#hearing_date').val();
        var order_type = $('input[name="order_type"]:checked').val();
        if(case_no == '' || co_notice == '' || hearing_date == '' || order_type == '' || co_notice == undefined || hearing_date == undefined || order_type == undefined) {
            swal.fire("", "Required Parameters are empty", "error")
            .then((value) => {
                
            });
            return false;
        }
        if(order_type == "re_lm_note") {
            var co_reason_note = $('#co_reason_note').val();
            var re_hearing_date = $('#re_hearing_date').val();
            if(co_reason_note == '' || re_hearing_date == '' || co_reason_note == undefined || re_hearing_date == undefined) {
                swal.fire("", "All fields with (*) mark are mandatory", "error")
                .then((value) => {
                    
                });
                return false;
            }
        }
        else if (order_type == "forwardtodc") {
            var adc_dc_code = $('#adc_dc_code').val();
            if(adc_dc_code == '' || adc_dc_code == undefined) {
                swal.fire("", "All fields with (*) mark are mandatory", "error")
                .then((value) => {
                    
                });
                return false;
            }
        }

        var new_patta_type = $('.new_patta_type_by_dc').val();
        if(new_patta_type == null)
        {
            document.getElementById("msgfornotselectingpattatype").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Please Select the New Patta Type</p></label>";
            return false;
        }

        var form = document.getElementById("mainform");
        console.log(form);
        var formData = new FormData(form);
        var baseurl = $('#baseurl').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + 'index.php/co_final_order_post3333',
            method: 'POST',
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.unblockUI();
                if(response.status == 'SUCCESS') {
                    swal.fire("", response.msg, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                else if (response.status == 'FAILED') {
                    swal.fire("", response.msg, "error;")
                    .then((value) => {
                        
                    });
                }
            },
            error: function(err) {
                $.unblockUI();
                console.log(err);
            }
        });

        
        console.log(order_type);
    });

    $("input[name='order_type']").click(function() {
        if($(this).val() == 're_lm_note') {
            if(confirm('Are you sure you want Lot Mondol to rewrite report?')) {
                $('#show_div').hide();
                $('#re_lm_note').show();
                // $('#re_lm_note1').show();
            }
            else{
                $(this).prop('checked', false);
                $('#re_lm_note').hide();
                // $('#re_lm_note1').hide();
                $('#show_div').show();
                $('#co_reason_note').val('');
                $('#re_hearing_date').val('');
            }
        }
        else{
            $('#re_lm_note').hide();
            // $('#re_lm_note1').hide();
            $('#show_div').show();
            $('#co_reason_note').val('');
            $('#re_hearing_date').val('');
        }
    });



    // $('.btn-file').on('click', (e)=>{
    //     console.log(e.currentTarget.id);
    // });
</script>

<script type="text/javascript">
$('.new_patta_type_by_dc').change(function (e) {
        var case_no = $('#case_no').val();
        var type_code = $(this).val();
        if(type_code != null)
        {
            document.getElementById("msgfornotselectingpattatype").style.display='none';
        }
        console.log("Changer");
      
        $.ajax({
            url: baseurl + "index.php/get_new_dag_patta",
            type: 'GET',
            data: {
                case_no: case_no,
                type_code:type_code

            },
            success: function(data) {
                console.log(data);
                var lot = JSON.parse(data);
                $('#newDag').val(lot[0].new_dag);
                $('#newPatta').val(lot[0].new_patta);
            }
        });
    });    
</script>