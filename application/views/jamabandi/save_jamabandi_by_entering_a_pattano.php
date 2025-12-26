<style>
    td{
        font-size: .75em !important;
        background: #fff;
    }
    /*.onTopNotification{
        display:none;
    }
    @media print {
        body { font-size: 10pt }
    }
    @media screen {
        body { font-size: 13px }
    }
    @media screen, print {
        body { line-height: 1.2 }
    }*/
</style> 
        
        <div align="center" class="col-lg-12">
           <table align="center table_black" width="100%" >
                <tr>
                    <td align="center">জৰীপ হোৱা গাঁওৰ জমাবন্দী (Jamabandi for Surveyed Village)
                        <?php if($this->session->userdata('user_desig_code')=='CO' || $this->session->userdata('user_desig_code')=='LM') { ?>
                        <button class="btn btn-sm btn-warning pull-right btnViewNotes"
                        id="<?=$this->session->userdata('patta_no')?>,<?=$this->input->post('patta_type')?>,<?=$this->input->post('dist_code')?>,<?=$this->input->post('subdiv_code')?>,<?=$this->input->post('circle_code')?>,<?=$this->input->post('mouza_code')?>,<?=$this->input->post('lot_no')?>,<?=$this->input->post('vill_code')?>">
                            <i class="fa fa-eye"></i>&nbsp;Click Here to Check/Update Remark(s)</button>
                        <div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
                        <?php } ?>
                    </td> 
                </tr>
                <tr>
                    <td align="center"><?php echo $namedata[0]->district . "/" . $namedata[1]->subdiv . "/" . $namedata[2]->circle . "/" . $namedata[3]->mouza . "/" . $namedata[4]->lot_no . "/" . $namedata[5]->village . "/" . $namedata[6]->patta_type; ?></td> 
                </tr>
            </table>

            <table class="table table-striped table-bordered" width="100%" >
                <tr>
                    <td align="center" colspan="2" height="20">  পট্টা নং  </td>
                    <td align= "center" rowspan="3" height="78" width="150">   পট্টাদাৰৰ  নাম,পিতাৰ নাম/স্ৱামীৰ নাম আৰু ঠিকনা  </td>
                    <td align="center" colspan=5 height="34">  &nbsp;&nbsp;প্ৰত্যেক দাগৰ মাটিৰ &nbsp;  </td>
                    <td align="center" rowspan="3" height="73" width="30">  ৰাজহ<br> </td>
                    <td align="center" rowspan="3" height="73" width="30">  স্হানীয় কৰ<br>  </td>
                    <td align="center" rowspan="3" height="100" width="170">  মন্তব্য  </td>
                </tr>
                <tr>
                    <td align="center" rowspan="2" height="48"  width="30"> পুৰণি </td>
                    <td align="center" rowspan="2" height="48"  width="30"> নতুন </td>
                    <td align="center" rowspan="2" height="48"  width="30"> নং</td>
                    <td align="center" rowspan="2" height="48"  width="30"> কালি<br>(বি-ক-লে) </td>
                    <td align="center" height="48" colspan="2"  width="30"> শ্রেণী </td>
                    <td align="center" rowspan="2" height="48" width="50"> কালি<br>(হে-আৰ-ছে) </td>
                </tr>
                <tr>
                    <td align="middle"  width="15">
                        কৃষি
                    </td>
                    <td align="middle"  width="15">
                        অকৃষি
                    </td>

                </tr>
                <tr>
                    <td align="middle" height="24"> 1 </td>
                    <td  align="center" height="24"> 2 </td>
                    <td align="center" height="24"> 3</td>
                    <td align="center" height="24"> 4 </td>
                    <td  align="center" height="24"> 5 </td>
                    <td  align="center" height="24" colspan="2"> 6 </td>
                    <td  align="center" height="24"> 7 </td>
                    <td  align="center"  height="24"> 8 </td>
                    <td  align="center"  height="24"> 9 </td>
                    <td align="center"  height="24"> 10 </td>
                </tr>                      

                <tr>
                    <td align="middle">
                        <?php
                        $GrandlocaltaxTotal = '';
                        $GrandrevenueTotal = '';
                        $Grandbigha_total = '';
                        $Grandkatha_total = '';
                        $Grandlesa_total = '';
                        //  $details="";
                        $GrandtotalHAC1 = "";
                        $localtaxTotal = '';
                        $revenueTotal = '';
                        $bigha_total = '';
                        $katha_total = '';
                        $lesa_total = '';
                        $bigha_totall = '';
                        $katha_totall = '';
                        $lesa_totall = '';
                        foreach ($oldpno as $p):
                            ?>
                            <p><?php echo $this->utilityclass->cassnum($p->old_patta_no); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td align="middle">
                        <?php
                        $pp = $this->session->userdata('patta_no');
                        if (is_numeric($pp)) {
                            echo $this->utilityclass->cassnum($pp);
                        } else {
                            echo $pp;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($pattadarinf)) {
                            $i = 1;
                            foreach ($pattadarinf as $p):
                                ?>
                                <p><?php
                                    $pdarflag = $p->p_flag;
                                    $newpdar_name = $p->new_pdar_name;
                                    $sort_pdar_by=1;
                                    if ((($p->pdar_land_b) != '0') || (($p->pdar_land_k) != '0') || (($p->pdar_land_lc) != '0')) {
                                        $bkl = "(" . $p->pdar_land_b . "B-" . $p->pdar_land_k . "K-" . round($p->pdar_land_lc, 2) . "L) ";
                                    } else {
                                        $bkl = "";
                                    }
                                    if ($pdarflag == '1') {
                                        $pattadarName = '<span style="Color:#ff0000;text-decoration: line-through;">' . $p->pdar_name . '</span>';
                                    } elseif (($pdarflag == '1') and ( $newpdar_name == "N")) {
                                        $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                                    } elseif (($pdarflag == null) and ( $newpdar_name == "N")) {
                                        $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                                    } elseif ($newpdar_name == "N") {
                                        $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                                    } elseif ($newpdar_name != "N") {
                                        $pattadarName = '<span style="Color:black;">' . $p->pdar_name . '</span>';
                                    }

                                    $pdar_serial_no = $p->pdar_sl_no . ") ";

                                    if (($p->pdar_sl_no == '0') || ($p->pdar_sl_no == '') || ($p->pdar_sl_no == null)) {
                                        $pdar_serial_no = $p->pdar_id . ") ";
                                    }

                                    if (($p->pdar_add1 != '') || ($p->pdar_add2 != '') || ($p->pdar_add3 != '') || ($p->pdar_add1 != '0') || ($p->pdar_add2 != '0') || ($p->pdar_add3 != '0')) {
                                        if ($sort_pdar_by == '1') {
                                            // 1 means sort by serial no
                                            echo $pdar_serial_no . '' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "<br>" . $bkl;
                                        } else {
                                            echo $i++ . ') ' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "<br>" . $bkl;
                                        }
                                    } else {
                                        if ($sort_pdar_by == '1') {
                                            // 1 means sort by serial no
                                            echo $pdar_serial_no . '' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                                        } else {
                                            echo $i++ . ') ' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                                        }
                                    }
                                    ?></p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                ?>
                                <p><?php echo $this->utilityclass->cassnumfordags($p->dag_no); ?></p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td align="middle">  
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                ?>
                                <p><?php
                                    $les = round($p->dag_area_lc, 2);
                                    $bkl_ass = $p->dag_area_b . "-" . $p->dag_area_k . "-" . number_format($p->dag_area_lc, 2);
                                    echo $this->utilityclass->cassnum($bkl_ass);
                                    ?> </p>
                                <?php
                            endforeach;
                        } else {
                            echo "0-0-0";
                        }
                        ?>
                    </td>
                					
					<td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                ?>
                                <?php if ($p->class_code_cat == '01') { ?>
                                    <p><?php
                                        echo $p->land_type;
                                    }
									if($p->class_code_cat != '01'){
									print "-"; }
                                    ?> </p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
															
                    <td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                ?>
                                <?php if(in_array($p->class_code_cat , ['02','2','3','4','5','6','7','8','9','10'])) { ?>
                                    <p><?php
                                        echo $p->land_type;
                                    }
									if(!in_array($p->class_code_cat , ['02','2','3','4','5','6','7','8','9','10'])){
									   print "-"; }
                                    ?> </p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                //var_dump($p);
                                ?>
                                <?php
                                $bigha_total = (int)($bigha_total) + (int)($p->dag_area_b);
                                $katha_total = (int)($katha_total) + $p->dag_area_k;
                                $lesa_total = (int)($lesa_total) + $p->dag_area_lc;
                                //echo "<br>";
                                $bigha_totall = (int)($bigha_totall) + $p->dag_area_b;
                                $katha_totall = (int)($katha_totall) + $p->dag_area_k;
                                $lesa_totall = (int)($lesa_totall) + $p->dag_area_lc;
                                //echo "<br>";
                                if ($lesa_total > 20) {
                                    $lesa = ($lesa_total / 20);
                                    $lesa_whole = floor($lesa);
                                    $lesa_fraction = $lesa - $lesa_whole;
                                    $lesa_fraction = $lesa_fraction * 20;
                                    $katha_total = $katha_total + $lesa_whole;
                                } else {
                                    $lesa_fraction = $lesa_total;
                                }
                                if ($katha_total > 4) {
                                    $katha = ($katha_total / 5);
                                    $katha_whole = floor($katha);
                                    $katha_fraction = $katha - $katha_whole;
                                    $katha_fraction = $katha_fraction * 5;
                                    $bigha_total = $bigha_total + $katha_whole;
                                    //$to_be_added_to_bigha=($grand_katha/5);
                                    //$grand_bigha=$bigha_total+$to_be_added_to_bigha;
                                } else {
                                    $katha_fraction = $katha_total;
                                }

                                $GrandtotalHAC = $this->utilityclass->get_Hec_Are_CAre($bigha_total, $katha_fraction, $lesa_fraction);
                                ?>
                                <?php
                                $H_A_C = $this->utilityclass->get_Hec_Are_CAre($p->dag_area_b, $p->dag_area_k, $p->dag_area_lc);
                                echo $this->utilityclass->cassnum($H_A_C) . '<br>';
                                ?></p>
                                <?php
                            endforeach;
                        } else {
                            echo "0-0-0";
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                ?>
                                <?php $revenueTotal = (float)($revenueTotal) + $p->dag_revenue; ?>
                                <p><?php
                                    $rajah = number_format($p->dag_revenue, 2);
                                    echo $this->utilityclass->cassnum($rajah);
                                    ?> </p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                ?>
                                <?php $localtaxTotal = (float)($localtaxTotal) + $p->dag_localtax; ?>
                                <p><?php
                                    $local = number_format($p->dag_localtax, 2);
                                    echo $this->utilityclass->cassnum($local);
                                    ?> </p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($remarkinf as $p):
                            ?>
                            <p><?php 
                            $remark_text = $p->remark;

                            if (mb_strpos($remark_text, 'MiND') !== false) {
                                if ((mb_strpos($remark_text, 'ভূমিলেখ্য সহায়ক') !== false) || (mb_strpos($remark_text, 'লাট মণ৿ডল') !== false)) {

                                    if (preg_match('/তাৰিখৰ\s+([A-Za-z0-9\/-]+\/MiND)/u', $remark_text, $matches)) {

                                        $case_no = trim($matches[1]); 
                                        $lm_name = $this->utilityclass->lmNameforJB($case_no);

                                        //var_dump('hh'.$lm_name);
                                         if (!empty($lm_name)) {
                                            $remark_text = preg_replace(
                                                '/(ভূমিলেখ্য\s*সহায়ক\s*:?<\/?u[^>]*>\s*)\([^)]*\)/u',
                                                '$1' . $lm_name . '$2',
                                                $remark_text
                                            );

                                            $remark_text = preg_replace(
                                                '/(লাট\s*(?:মণ্ডল|মণ.?ডল)\s*:\s*(?:<\/u>)?\s*\()[^)]+(\))/u',
                                                '$1' . $lm_name . '$2',
                                                $remark_text
                                            );
                                        }
                                    }
                                }
                            }

                            echo strip_tags($remark_text, '<p><br><s>'); ?> </p>
                            <?php
                            if(isset($p->entry_mode) && $p->entry_mode=='O'){
                            ?>
                            <i class='small red'>Order(s) Manually Entered By CO:<?php $name=$this->utilityclass->getSelectedCOName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->user_code);
                            echo $name->username;
                            ?>
                             on dated <?=$p->entry_date?> </i>
                            <?php 
                            }
                            if(isset($p->entry_mode) && $p->entry_mode=='K'){
                            ?>
                            <i class='green red'>Above Remark(s) Edited By CO:<?php $name=$this->utilityclass->getSelectedCOName($p->dist_code,$p->subdiv_code,$p->cir_code,$p->user_code);
                            echo $name->username;
                            ?>
                             on dated <?=$p->entry_date?> </i>
                            <?php } ?>
                        <?php endforeach; ?>
                    </td>
                </tr>              
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="middle">
                        <?php
                        if (!empty($daginfo)) {
                            $bigha_totall;
                            $katha_totall;
                            $lesa_totall;
                            $total_lessa = $this->utilityclass->Total_Lessa($bigha_totall, $katha_totall, $lesa_totall);
                            $tbkl = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            echo $this->utilityclass->cassnum($tbkl[0] . "-" . $tbkl[1] . "-" . $tbkl[2]);
                            $Grandbigha_total = (int)($Grandbigha_total) + $bigha_total;
                            $Grandkatha_total = (int)($Grandkatha_total) + $katha_fraction;
                            $Grandlesa_total = (int)($Grandlesa_total) + $lesa_fraction;

                            if ($Grandlesa_total > 20) {
                                $lesa = ($Grandlesa_total / 20);
                                $lesa_whole = floor($lesa);
                                $lesa_fraction = $lesa - $lesa_whole;
                                $lesa_fraction = $lesa_fraction * 20;
                                $Grandkatha_total = $Grandkatha_total + $lesa_whole;
                            } else {
                                $lesa_fraction = $Grandlesa_total;
                            }
                            if ($Grandkatha_total > 4) {
                                $katha = ($Grandkatha_total / 5);
                                $katha_whole = floor($katha);
                                $katha_fraction = $katha - $katha_whole;
                                $katha_fraction = $katha_fraction * 5;
                                $Grandbigha_total = $Grandbigha_total + $katha_whole;
                            } else {
                                $katha_fraction = $Grandkatha_total;
                            }
                            $GrandtotalHAC1 = $this->utilityclass->get_Hec_Are_CAre($bigha_totall, $katha_totall, $lesa_totall);
                        } else {
                            echo "0-0-0";
                            $GrandtotalHAC1 = "0-0-0";
                        }
                        ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td align="middle">
                        <?php echo $this->utilityclass->cassnum($GrandtotalHAC1); ?>
                    </td>
                    <td align="middle">
                        <?php
                       
                        echo round($revenueTotal,2);
                        $GrandrevenueTotal = (float)($GrandrevenueTotal) + (float)$revenueTotal;
                        ?>
                    </td>
                    <td align="middle">
                        <?php
                        echo round($localtaxTotal, 2);
                        $GrandlocaltaxTotal = (float)($GrandlocaltaxTotal) + (float)$localtaxTotal;
                        ?>
                    </td>
                    <td></td>
                </tr>
            </table>
            <?php
                if(isset($oldpno[0]->entry_date)):
            ?>
                <span class='pull-right red'>Patta Last Updated on:<i class='fa fa-calendar'></i> <?php echo date('d/m/Y',strtotime($oldpno[0]->entry_date)); ?></span> 
            <?php
                endif;
            ?>
        </div>
     


        <div class='dontshow' >
            <div class="form-group" style="text-align: center">
                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                    <button class='btn btn-primary' onclick="myFunction()"><i class='fa fa-print'></i> Print this page</button>
                    <button class='btn btn-danger' onclick="self.close()"><i class='fa fa-close'></i> Close this window</button>
                </div>
            </div>
            <div>
                <script>
                    function myFunction() {
                        //document.getElementById("print").disabled = false;
                        //document.getElementById("close").disabled = false;
                        $(".dontshow").hide();
                        window.print();
                        $(".dontshow").show();

                    }
                    function windowClose() {
                        window.open('', '_parent', '');
                        window.close();
                    }

                </script>
            </div>
        </div>
<!------ view all notes ----->
<div class="modal" id="viewAllNotesModal" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <form class="form-horizontal" action="<?=base_url().'index.php/Jamabandi/updateJamabandi'?>" method="post" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-red text-bold">View All Notes</div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><hr></div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered">
                                <thead style="white-space:nowrap; width:100%">
                                    <tr class="text-bold table-success">
                                        <th width="5%" style="text-align: center">#</th>
                                        <th width="15%">Case No</th>
                                        <th width="20%">Note</th>
                                        <th width="10%" style="text-align: center">
                                            Check All&nbsp;
                                            <input type="checkbox" class="checkAll" value="1">
                                        </th>     
                                    </tr>
                                </thead>
                                <tbody id="jamabandi_update_note_list">
                                    <div id="no_detail"></div>
                                </tbody>
                            </table>                        
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><hr></div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <button type="submit" class="btn btn-sm btn-info 
                        btnUpdateJamabandi"><i class="fa fa-refresh"></i>
                        &nbsp;Update Jamabandi</button>

                    <button type="button" class="btn btn-sm btn-default 
                        btnClose"><i class="fa fa-close"></i>&nbsp;Close</button>
                    <input type="hidden" value="" id="selected_box" name="selected_box">
                    <input value="<?=$this->session->userdata('patta_no')?>" type="hidden" name="pno">
                    <input value="<?=$this->input->post('patta_type')?>" type="hidden" name="ptype">
                    <input value="<?=$this->input->post('dist_code')?>" type="hidden" name="dist">
                    <input value="<?=$this->input->post('subdiv_code')?>" type="hidden" name="sub">
                    <input value="<?=$this->input->post('circle_code')?>" type="hidden" name="cir">
                    <input value="<?=$this->input->post('mouza_code')?>" type="hidden" name="mouza">
                    <input value="<?=$this->input->post('lot_no')?>" type="hidden" name="lot">
                    <input value="<?=$this->input->post('vill_code')?>" type="hidden" name="vill">
                    <?php
                        $dag_nos = ''; 
                        if (!empty($daginfo)) {
                            foreach ($daginfo as $p):
                                $dag_nos .= "'".trim($p->dag_no)."',";
                            endforeach;
                            $dags = rtrim($dag_nos, ',');
                        }
                    ?>
                    <input type="hidden" value="<?=$dags?>" id="dag">
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div id='err_msg' class="text-red text-left pull-left"></div>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    
    $('.btnViewNotes').click(function() 
    {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        id = $(this).attr('id');
        arr = id.split(',');
        pno = arr['0'];
        ptype = arr['1'];
        dist = arr['2'];
        sub = arr['3'];
        cir = arr['4'];
        mouza = arr['5'];
        lot = arr['6'];
        vill = arr['7'];
        dag = $('#dag').val();
        data = {pno:pno, ptype:ptype, dist:dist, sub:sub, cir:cir, mouza:mouza, lot:lot, vill:vill, dag:dag}
        $.ajax({
            url: baseurl + "Jamabandi/viewAllNotes",
            type: 'POST',
            data: data,
            dataType: "json",
            success: function (data) {
                $.unblockUI();
                $('#add_notes_on_jamabandi').trigger('reset');
                $('#viewAllNotesModal').modal('show');
                if(data.success === true){
                    table = '';
                    message = '';
                    msg = '';
                    button = '';
                    $.each(data.orderList, function (i, val) {
                        if(val['jama_status'] == null || val['jama_status'] == '') {
                            message = "May be Not Updated in JAMABANDI. Please check the checkbox to update if needed ...";
                            msg = '<span style="color:red">'+message+'</span>';
                        }
                        else { 
                            message = "May be, this case detail is already updated in JAMABANDI.";
                            msg = '<span style="color:blue">'+message+'</span>';
                        }
                        button = '<input type="checkbox" value="'+val['order_no']+'" '+
                                'class="btnChecked" id="'+val['order_no']+'"';
                        table +=
                        '<tr style="font-size:20px">'+
                            '<td align="center">' + ++i + '</td>' +
                            '<td>' + val["order_no"] + '</td>' +
                            '<td>' + msg + '</td>' +
                            '<td align="center">' + button + '</td>' +
                        '</tr>'
                    });
                    $('#jamabandi_update_note_list').html(table);
                    $('#dag').val(data.dagList);
                }
                if(data.success === false){
                    $('#no_detail').html('<span style="color:red; font-size:20px">'+data.orderList+'</span>');   
                }
            }, error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });
    $(document).on('click','.btnClose', function(){
        $('#viewAllNotesModal').modal('hide');
    });

    $(document).on('click', '.btnChecked', function(){
        var selected = new Array();
        $("#jamabandi_update_note_list input[type=checkbox]:checked").each(function () {
            selected.push("'"+this.value+"'");
        });
        $('#selected_box').val(selected.join(","));  
    });

    $(".checkAll").click(function(){
        if(this.checked){
            $('.btnChecked').each(function(){
                this.checked = true;
                var selected = new Array();
                $("#jamabandi_update_note_list input[type=checkbox]:checked").each(function(){
                    selected.push("'"+this.value+"'");
                });
                $('#selected_box').val(selected.join(","));
            })

        }else{
            $('.btnChecked').each(function(){
                this.checked = false;
                var selected = new Array();
                $("#jamabandi_update_note_list input[type=checkbox]:checked").each(function(){
                    selected.push("'"+this.value+"'");
                });
                $('#selected_box').val(selected.join(","));
            })
        }
    });

    // $('.btnUpdateJamabandi').on('click', function(){
    //     if($('#selected_box').val() == ''){
    //         $('#err_msg').fadeIn();
    //         $('#err_msg').html("<hr>You have not select any checkbox to update Jamabandi !!!<hr>");
    //         setTimeout(function(){
    //             $('#err_msg').fadeOut();
    //         }, 50000);
    //         return false;
    //     }
    // });
</script>