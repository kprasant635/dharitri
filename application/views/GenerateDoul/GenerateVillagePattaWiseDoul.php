<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: landscape; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Generate Doul / Year Wise Doul For Villages's </h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Auto Generated Doul of each Villages's
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h2 class="red center">চনৰ আদায় হবলগীয়া ৰাজহ কম বেছি ডোল</h2>
                        <table class="table table-bordered">
                            <tr class="hope info">
                                <td colspan="2">District : <?php echo $dist_name; ?></td>
                                <td colspan="2">Subdivision : <?php echo $subdiv_name; ?></td>
                                <td colspan="2">Circle : <?php echo $cir_name; ?></td>
                                <td colspan="2">Mouza : <?php echo $mouza_name; ?></td>
                                 <!-- <td class="dontshow">
                                        <a href="<?php echo base_url(); ?>index.php/GenerateDoul/ChangeInLandVil?mouza_code=<?php echo $mouza_code;?>" class="btn btn-success">
                                            &nbsp;View Change in Land&nbsp;<i class=""></i>
                                        </a>
                                    </td> -->
                            </tr>
                        </table>
                        <?php $sum_patta_no=0;?>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="col-lg-12 panel panel-default panel-body" style="overflow-y: scroll">
                        <table class="table table-bordered">
                                <tr class="center info text-center">
                                    <th class="dontshow">&nbsp;</th>
                                    <th  rowspan="2">ঠাইৰ নাম</th>
                                    <th  rowspan="2"> কোন শ্রেণী পাট্টা </th>
                                    <th style="background: #000033" class="alert-teal text-center" colspan="16">বেছি হোৱাৰ কাৰণ </th>
                                    <th style="background: #003333" class="text-center alert-teal" colspan="16">কম হোৱাৰ কাৰণ </th>
                                    <th class="text-center" colspan="2" rowspan="2">মোট  কমি </th>
                                    <th class="text-center" colspan="2" rowspan="2">প্রকৃত কম বা বেছি </th>
                                    <th class="text-center" colspan="4" rowspan="2">চনৰ শেষত বন্দোবস্ত থকা </th>
                                </tr>
                                <tr class="center info">
                                    <th class="dontshow">&nbsp;</th>
                                    <th colspan="2">চনৰ আৰম্ভ ও বন্দোবস্ত থকা </th>
                                    <th colspan="2">নতুন বন্দবস্ত বা ইস্তাফা মজ্ঞুৰ </th>
                                    <th colspan="2">নিস্কৰ বা বিশেষ নিৰিখত বন্দোবস্ত মাটিৰ পুনৰ গ্রহণ </th>
                                    <th colspan="2">নিৰিখৰ সলনি নতুন পিয়লি বা শ্রেণী সলনি </th>
                                    <th colspan="2">পাট্টাৰ শ্রেণী পৰিবৰ্ওন</th>
                                    <th colspan="2">ৰাজহৰ ক্ৰমিক বৃদ্ধি</th>
                                    <th colspan="2">অইন অইন  কাৰণ </th>
                                    <th colspan="2">মোট বেছি </th>
                                    <th colspan="2">ইস্তাফা  </th>
                                    <th colspan="2">ফৌত , ফেৰাৰ বা  যোত্ৰহীন </th>
                                    <th colspan="2">বন্দোবস্ত ৰহিত হোৱা</th>
                                    <th colspan="2">বাকী খাজানাৰ নিমিওে চৰকাৰে নিলামত কিনা </th>
                                    <th colspan="2">নয়ে হৰীয়া </th>
                                    <th colspan="2">নিৰিখৰ সলনি নতুন পিয়লি বা শ্রেণী সলনি  </th>
                                    <th colspan="2">পাট্টাৰ শ্রেণী পৰিবৰ্ওন</th>
                                    <th colspan="2">অইন অইন  কাৰণ </th>
                                </tr>
                                <tr  class="center ">
                                    <th style="background: #993300; " class="dontshow">&nbsp;</th>
                                    <th style="background: #993300; ">&nbsp;</th>
                                    <th style="background: #993300; ">&nbsp;</th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ  </th>
                                    <th style="background: #993300; color: #fff"> ৰাজহ (টকা) </th>
                                    <th style="background: #993300; color: #fff"> মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff"> মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ</th>
                                    <th  style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ</th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">মাটিৰ পৰিমাণ </th>
                                    <th style="background: #993300; color: #fff">ৰাজহ </th>
                                    <th style="background: #993300; color: #fff">স্থানীয় কৰ </th>
                                    <th style="background: #993300; color: #fff">মুঠ পাট্টা </th>
                                </tr>
                                <tr class="center danger">
                                    <th class="dontshow">&nbsp;</th>
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
                                $sum_patta_no = '';
                                $sum_dag_revenue = '';
                                $sum_local_tax = '';
                                $sum_total_lessa = '';
                                foreach ($result as  $value) {
                                    //var_dump($value);
                                ?>
                                <tr>
                                    <td class="dontshow">
                                        <a href="<?php echo base_url(); ?>index.php/GenerateDoul/DagWiseDoulGenerate?mouza_code=<?php echo $value['mouza_code']."&lot_no=".$value['lot_no']."&village_code=".$value['vill_townprt_code']."&patta_type=".$value['patta_type_code'];?>" class="btn btn-success">
                                            &nbsp;View Dags&nbsp;<i class="fa fa-arrow-right"></i>
                                        </a>
                                    </td>
                                    <td class="text-success"><?php echo $value['village_name']; ?></td>
                                    <td class="text-success"><?php echo $value['patta_name']; ?></td>
                                    <td>
                                        <?php 
                                            echo round($value['bigha'], 2)." বিঃ ".round($value['ktha'], 2)." কঃ ".round($value['lessa'], 2)." লেঃ "; 
                                            $sum_total_lessa = (float)$sum_total_lessa+(float)$value['total_lessa'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo $value['dag_revenue']; 
                                            $sum_dag_revenue = (float)$sum_dag_revenue+(float)$value['dag_revenue'];
                                        ?>
                                    </td>
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
                                    <td><?php //echo $measure[0] . "&nbsp;B&nbsp;" . "-" . $measure[1] . "&nbsp;K&nbsp;" . "-" . $measure[2] . "&nbsp;L&nbsp;"; ?></td>
                                    <td>
                                        <?php 
                                            echo $value['local_tax']; 
                                            $sum_local_tax = (float)$sum_local_tax+(float)$value['local_tax'];
                                        ?>
                                    </td>
                                    <td><?php //echo $row['local_tax']; ?></td>
                                    <td>
                                        <?php 
                                        echo $value['patta_no']; 
                                        $sum_patta_no = (integer)$sum_patta_no+(integer)($value['patta_no']);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr class="success">
                                <th class="dontshow">&nbsp;</th>
                                <th class="text-danger uni_text"><?php echo "মুঠ &nbsp;"; ?> </th>
                                <td>&nbsp;</td>
                                <th class="text-danger uni_text">
                                    <?php 
                                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                           $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa2($sum_total_lessa);
                                           echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." চা ".round($total_b_k_l[3], 2)." গো ";
                                        }else{
                                           $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                           echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." লেঃ ";
                                        }
                                        // $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                         
                                    ?>
                                </th>
                                <th class="text-danger uni_text"><?php echo (float)$sum_dag_revenue; ?></th>
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
                                <th class="text-danger uni_text" ><?php //echo $m[0] . "&nbsp;B&nbsp;" . "-" . $m[1] . "&nbsp;K&nbsp;" . "-" . $m[2] . "&nbsp;L&nbsp;"; ?></th>
                                <th class="text-danger uni_text"><?php echo (float)$sum_local_tax; ?></th>
                                <th class="text-danger uni_text"><?php //echo $tot_revenue; ?></th>
                                <th class="text-danger uni_text"><?php echo $sum_patta_no; ?></th>
                            </tr>
                        </table>
                        
                            
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <center>
                            <button id="backButton" class="btn btn-danger dontshow"><i class="fa fa-arrow-left"></i>&nbsp;Back To Mouza Wise Doul</button>
                            <a onclick="return myFunction()" href="#" class="btn btn-success uni_text dontshow" ><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/GenerateDoul/MouzaWiseDoulGenerate?mouza_code='.$mouza_code; ?>";
        };
        
        function myFunction() {
            $(".dontshow").hide();
            window.print();
            $(".dontshow").show();
                document.getElementById("mainMenu").disabled = false;
        }
</script>