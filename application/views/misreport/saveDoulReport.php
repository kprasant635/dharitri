<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="alert alert-success" >
                <h4 class="center">  চনৰ আদায় হবলগীয়া ৰাজহ কম বেছি ডোল  </h4>
            </div>
            <div class="alert alert-success" role="alert">
                <h4><?php echo $this->lang->line('district');?> : <kbd><kbd><?php echo $namedata[0]->district; ?></kbd></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : 
                    <kbd><?php echo $namedata[1]->subdiv; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <kbd><?php echo $namedata[2]->circle; ?></kbd> 
                        <?php echo $this->lang->line('year');?> : <code><?php echo $namedata['year'] ?></code> <?php echo $this->lang->line('lot_no');?> : <code><?php echo $namedata['lot'] ?></code></h4>
            </div>
        </div>
        <hr>
        <?php //print_r($query);
        // print_r($namedata);
        ?>

        <div class="col-lg-12 panel panel-default panel-body" style="overflow-y: scroll">
            <h4>Assam Schedule XXXVII Form No. 11</h4>
            <table class="table table-bordered">
                <tr class="center info text-center">
                    <th  rowspan="2">গাঁওৰ নাম</th>
                    <th  rowspan="2">কোন শ্রেণীৰ পাট্টা </th>
                    <th style="background: #000033; color: #fff" class="text-center" colspan="16">বেছি হোৱাৰ কাৰণ </th>
                    <th style="background: #003333; color: #fff"  class="text-center" colspan="16">কম হোৱাৰ কাৰণ </th>
                    <th class="text-center" colspan="2" rowspan="2">যোট  কমি </th>
                    <th class="text-center" colspan="2" rowspan="2">প্রকৃত কম বা বেছি </th>
                    <th class="text-center" colspan="4" rowspan="2">চনৰ শেষত বন্দোবস্ত থকা </th>
                </tr>
                <tr class="center info">
                    <th colspan="2">চনৰ আৰম্ভ ও বন্দোবস্ত থকা </th>
                    <th colspan="2">নতুন বন্দবস্ত বা ইস্তাফা মজ্ঞুৰ </th>
                    <th colspan="2">নিস্কৰ বা বিশেষ নিৰিখত বন্দোবস্ত মাটিৰ পুনৰ গ্রহণ </th>
                    <th colspan="2">নিৰিখৰ সলনি নতুন পিয়লি বা শ্রেণী সলনি </th>
                    <th colspan="2">পাট্টাৰ শ্রেণী পৰিবৰ্ওন</th>
                    <th colspan="2">ৰাজহৰ ক্ৰমিক বৃদ্ধি</th>
                    <th colspan="2">অইন অইন  কাৰণ </th>
                    <th colspan="2">মুঠ বেছি </th>
                    
                    <th colspan="2">ইস্তাফা  </th>
                    <th colspan="2">ফৌত , ফেৰাৰ বা  যোত্ৰহীন </th>
                    <th colspan="2">বন্দোবস্ত ৰহিত হোৱা</th>
                    <th colspan="2">বাকী খাজানাৰ নিমিওে চৰকাৰে নিলামত কিনা </th>
                    <th colspan="2">নয়ে হৰীয়া </th>
                    <th colspan="2">নিৰিখৰ সলনি নতুন পিয়লি বা শ্রেণী সলনি  </th>
                    <th colspan="2">পাট্টাৰ শ্রেণী পৰিবৰ্ওন</th>
                 <th colspan="2">অইন অইন  কাৰণ </th>
                </tr>
                <tr class="center success">
                    <th style="background: #993300; color: #fff">&nbsp;</th>
                    <th style="background: #993300; color: #fff">&nbsp;</th>
                    <th style="background: #993300; color: #fff" >মাটিৰ পৰিমাণ  </th>
                     <th style="background: #993300; color: #fff" > ৰাজহ (টকা) </th>
                    <th style="background: #993300; color: #fff"> মাটিৰ পৰিমাণ </th>
                     <th style="background: #993300; color: #fff" >ৰাজহ </th>
                     <th style="background: #993300; color: #fff" > মাটিৰ পৰিমাণ </th>
                     <th style="background: #993300; color: #fff" >ৰাজহ </th>
                     <th style="background: #993300; color: #fff" >মাটিৰ পৰিমাণ </th>
                     <th style="background: #993300; color: #fff" >ৰাজহ </th>
                     <th style="background: #993300; color: #fff" >মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                     <th style="background: #993300; color: #fff" >মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                     <th style="background: #993300; color: #fff" >মাটিৰ পৰিমাণ </th>
                     <th style="background: #993300; color: #fff" >ৰাজহ </th>
                     <th style="background: #993300; color: #fff" >মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                   
                    <th style="background: #993300; color: #fff" width="16">মাটিৰ পৰিমাণ</th>
                    <th style="background: #993300; color: #fff" width="27">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="18">মাটিৰ পৰিমাণ</th>
                    <th style="background: #993300; color: #fff" width="43">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="24">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="63">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="38">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="51">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="31">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="26">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="41">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="36">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="63">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="58">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="44">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="37">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="30">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="26">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="39">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="42">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="13">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="22">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="28">স্থানীয় কৰ </th>
                    <th style="background: #993300; color: #fff" width="54">মুঠ পাট্টা </th>
                </tr>
                <tr class="center danger">
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                    <th>14</th>
                    <th>15</th>
                    <th>16</th>
                    <th>17</th>
                    <th>18</th>
                    <th>19</th>
                    <th>20</th>
                    <th>21</th>
                    <th>22</th>
                    <th>23</th>
                    <th>24</th>
                    <th>25</th>
                    <th>26</th>
                    <th>27</th>
                    <th>28</th>
                    <th>29</th>
                    <th>30</th>
                    <th>31</th>
                    <th>32</th>
                    <th>33</th>
                    <th>34</th>
                    <th>35</th>
                    <th>36</th>
                    <th>37</th>
                    <th>38</th>
                    <th>39</th>
                    <th>40</th>
                    <th>41</th>
                    <th>42</th>
                </tr>
                <?php
                $tot_b = 0;
                $tot_k = 0;
                $tot_l = 0;
                $tot_revenue = 0;
                $tot_patta = 0;
                $tot_local = 0;
                $b=0;$k=0;$l=0;$rev17_18=0;
                $nr_b=0;$nr_k=0; $nr_l=0;$nr_rev=0;$col23_24=0;$rev23_24=0;$totnr_lessa=0;$tot_40_column_bottom=0;
                $col_39_bottom=0;$col_36_bottom=0;$tot_rev_37_bottom=0;
               //var_dump($query);
                foreach ($query as $row):
                    $bigha = $row['bigha'];
                    $ktha = $row['ktha'];
                    $lessa = round($row['lessa'],2);
                    
                    $total_lessa_col3 = $this->utilityclass->Total_Lessa($bigha, $ktha, $lessa);
                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $ktha, $lessa);
                    $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa_col3);

                    $tot_b = $tot_b + $measure[0];
                    $tot_k = $tot_k + $measure[1];
                    $tot_l = $tot_l + $measure[2];
                    
                    $tlessa = $this->utilityclass->Total_Lessa($tot_b, $tot_k, $tot_l); 
					
                    $m = $this->utilityclass->Total_Bigha_Katha_Lessa($tlessa);
                    
                    $tot_revenue = $tot_revenue + $row['total'];
                    $tot_local = $tot_local + $row['local_tax'];
                    $tot_patta = $tot_patta + $row['total_patta'];
                    ?>
                    <tr>
                        <td class="text-success"><?php echo $row['village']; ?></td>
                        <td ><?php echo $row['patta']; ?></td>
                        <td ><?php echo $measure[0] . "&nbsp;B&nbsp;" . "-" . $measure[1] . "&nbsp;K&nbsp;" . "-" . $measure[2] . "&nbsp;L&nbsp;"; ?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>
                            <?php
                           
                             $sql="Select sum(dag_area_b) as bigha,sum(dag_area_K) as ktha,sum(dag_area_LC) as lessa,sum(round(proposed_land_revenue, 2)) as total from   chitha_rmk_reclassification where dist_code='$row[dist_code]'  and subdiv_code='$row[subdiv_code]' and cir_code='$row[cir_code]' " 
                                   . "and mouza_pargona_code='$row[mouza_pargona_code]' and lot_no='$row[lot_no]' and Vill_townprt_code='$row[vill_townprt_code]' "
                                . "and Patta_type_code='$row[patta_type]' and rkg_chitha_updated_date between '$row[preYear]' and '$row[curYear]' ";
                            $reclassification=$this->db->query($sql)->row();
                            $total_lessa = $this->utilityclass->Total_Lessa($reclassification->bigha,$reclassification->ktha, $reclassification->lessa);
                            $reclassBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            //$t_lessa = 0;   
                            $b=$b+$reclassBKL[0];
                            $k=$k+$reclassBKL[1];
                            $l=$l+$reclassBKL[2];

                            $t_lessa = $this->utilityclass->Total_Lessa($b,$k, $l);
                           
                            $col17_18 = $this->utilityclass->Total_Bigha_Katha_Lessa($t_lessa);
                            $rev17_18=$rev17_18+$reclassification->total;
                          
                            echo $reclassBKL[0]." B-".$reclassBKL[1]." K-".$reclassBKL[2]." L";
              
                            ?>
                        </td>
                        <td><?php echo $reclassification->total; ?></td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td><?php
                         if($total_lessa>0){
                            echo $reclassBKL[0]." B-".$reclassBKL[1]." K-".$reclassBKL[2]." L";
                           }else{
                               echo "--";
                           }
                        ?></td>
                        <td><?php echo $reclassification->total; ?></td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>
                            <?php
                       
                        $sql="select distinct(dag_no) from apt_chitha_rmk_other where dist_code ='$row[dist_code]'  and "
                    . " subdiv_code='$row[subdiv_code]' and cir_code='$row[cir_code]' and "
                    . " mouza_pargona_code='$row[mouza_pargona_code]' and "
                    . " lot_no='$row[lot_no]' and vill_townprt_code='$row[vill_townprt_code]'  "
                . " and ord_date between '$row[preYear]' and '$row[curYear]' ";
                         $dag_all= $this->db->query($sql)->result();  
                         foreach($dag_all as $dag_no){
                             $q="Select sum(dag_area_b) as bigha,sum(dag_area_K) as ktha,sum(dag_area_LC) as lessa,sum(round(dag_revenue, 2)) as trev from Chitha_basic where dist_code ='$row[dist_code]' and subdiv_code='$row[subdiv_code]' and cir_code='$row[cir_code]' and "
                                     . "mouza_pargona_code='$row[mouza_pargona_code]' and lot_no='$row[lot_no]' and vill_townprt_code='$row[vill_townprt_code]' and dag_no='$dag_no->dag_no'";
                             $nrcase=$this->db->query($q)->row();
                            //       var_dump($nrcase);
                            $nr_b=$nr_b+$nrcase->bigha;
                            $nr_k=$nr_k+$nrcase->ktha;
                            $nr_l=$nr_l+$nrcase->lessa;
                            $nr_rev=$nr_rev+$nrcase->trev;
                                 }
                            $tot_lessa = $this->utilityclass->Total_Lessa($nr_b,$nr_k, $nr_l);
                            $NrCaseBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($tot_lessa);
                            if($tot_lessa>0){
                            echo $NrCaseBKL[0]." B-".$NrCaseBKL[1]." K-".$NrCaseBKL[2]." L";
                            }
                          
                            $tot_nr_lessa = $this->utilityclass->Total_Lessa($NrCaseBKL[0],$NrCaseBKL[1], $NrCaseBKL[2]);
                            $totnr_lessa=$totnr_lessa+$tot_nr_lessa;
                            $col23_24 = $this->utilityclass->Total_Bigha_Katha_Lessa($totnr_lessa);
                            $rev23_24=$rev23_24+$nr_rev;
                            ?>
                        </td>
                        <td>
                        <?php
                         echo $nr_rev;
                         
                        ?>
                        </td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td><?php
                        echo "(-)<br>";
                        if($totnr_lessa>0){
                        echo $NrCaseBKL[0]." B-".$NrCaseBKL[1]." K-".$NrCaseBKL[2]." L";
                        }
                        ?></td>
                        <td> <?php
                         echo $nr_rev;
                        ?></td>
                        <td>
                            <?php
                          
                       $col_36=$total_lessa-$tot_lessa;
                       
                       $col_36_39=$col_36;
                       $col_36_bottom=$col_36_bottom+$col_36;
                       if($col_36<0)
                       {
                           $col_36=(-1)*$col_36;
                           echo "(-)<br>";
                       }
                        $col36_result = $this->utilityclass->Total_Bigha_Katha_Lessa($col_36);
                        echo $col36_result[0]." B-".$col36_result[1]." K-".$col36_result[2]." L";
                       // echo "check";
                        //  var_dump($col36_result);
                            ?>
                        </td>
                        <td>
                        <?php 
                           echo  $tot_rev_37=  $reclassification->total-$nr_rev;
                           $tot_rev_37_bottom=$tot_rev_37_bottom+$tot_rev_37;
                        ?>
                        </td>
                        <td><?php 

                       $col_39=$total_lessa_col3+$col_36_39;
                       $col_39_bottom=$col_39_bottom+$col_39;
                       if($col_39<0)
                       {
                           $col_39=(-1)*$col_39;
                       }
                       $col39_result = $this->utilityclass->Total_Bigha_Katha_Lessa($col_39);
                        echo $col39_result[0]." B-".$col39_result[1]." K-".$col39_result[2]." L";
                        
                        ?></td>
                        <td><?php
                        echo $tot_40_column=$row['total']+$tot_rev_37;
                        $tot_40_column_bottom=$tot_40_column_bottom+$tot_40_column;
                        ?></td>
                        <td><?php echo $row['local_tax']; ?></td>
                        <td><?php echo $row['total_patta']; ?></td>
                    </tr>
                    <?php
                       $nr_b=0;$nr_k=0; $nr_l=0;$nr_rev=0;
                    endforeach; ?>
                <tr class="success">
                    <td>&nbsp;</td>
                    <th class="text-danger uni_text"><?php echo "মুঠ &nbsp;<br>" . $namedata['year'] ."<br>". $row['patta']; ?> </th>
                    <th class="text-danger uni_text"><?php echo $m[0] . "&nbsp;B&nbsp;" . "-" . $m[1] . "&nbsp;K&nbsp;" . "-" . $m[2] . "&nbsp;L&nbsp;"; ?></th>
                    <th class="text-danger uni_text"><?php echo number_format($tot_revenue,2) ; ?></th>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                    <?php
                    if($t_lessa>0){   
                        echo $col17_18[0]." B-".$col17_18[1]." K-".$col17_18[2]." L";    
                    }
                     ?>
                    </td>
                    <td><?php echo $rev17_18; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>
                        <?php
                      //  var_dump($col23_24);
                    if($totnr_lessa>0){   
                        echo $col23_24[0]." B-".$col23_24[1]." K-".$col23_24[2]." L";    
                    }
                     ?>
                    </td>
                    <td><?php echo $rev23_24; ?></td>
                    <td></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>
                        <?php
                    if($totnr_lessa>0){   
                        echo $col23_24[0]." B-".$col23_24[1]." K-".$col23_24[2]." L";    
                    }
                     ?>
                    </td>
                    <td><?php echo $rev23_24; ?></td>
                    <td><?php 
                   //  echo $col_36_bottom;
                    if($col_36_bottom<0)
                    {
                        $col_36_bottom=(-1)*$col_36_bottom;
                        echo " (-) ";
                    }
                    $m36 = $this->utilityclass->Total_Bigha_Katha_Lessa($col_36_bottom);
                    echo $m36[0] . "&nbsp;B&nbsp;" . "-" . $m36[1] . "&nbsp;K&nbsp;" . "-" . $m36[2] . "&nbsp;L&nbsp;"; 
                    
                    ?></td>
                    <td><?php 
                   echo $tot_rev_37_bottom;
                    ?></td>
                    <th class="text-danger uni_text" ><?php
                    //var_dump($col_39_bottom);
                     if($col_39_bottom<0)
                    {
                        $col_39_bottom=(-1)*$col_39_bottom;
                        echo " (-) ";
                    }
                    $m = $this->utilityclass->Total_Bigha_Katha_Lessa($col_39_bottom);
                    echo $m[0] . "&nbsp;B&nbsp;" . "-" . $m[1] . "&nbsp;K&nbsp;" . "-" . $m[2] . "&nbsp;L&nbsp;"; ?></th>
                    <th class="text-danger uni_text"><?php echo $tot_40_column_bottom; ?></th>
                    <th class="text-danger uni_text"><?php echo $tot_local; ?></th>
                    <th class="text-danger uni_text"><?php echo $tot_patta; ?></th>
                </tr>
                <tr>
                    <td class="text-center" colspan="15">
                        <button id="backButton" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/DoulReport' ?>";
    };
</script>

