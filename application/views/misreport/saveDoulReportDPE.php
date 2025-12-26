<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="alert alert-success" >
                <h4 class="center"> চনৰ আদায় হবলগীয়া ৰাজহ কম বেছি ডোল  </h4>
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
            <table class="table table-bordered">
                <tr class="center info text-center">
                    <th  rowspan="2">গাঁওৰ নাম</th>
                    <th style="background: #000033" class="alert-teal text-center" colspan="16">বেছি হোৱাৰ কাৰণ </th>
                    <th style="background: #003333" class="text-center alert-teal" colspan="16">কম হোৱাৰ কাৰণ </th>
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
                    <th colspan="2">বেছি হোৱাৰ কাৰণ </th>
                    
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
                   
                    <th style="background: #993300; color: #fff" width="16">মাটিৰ পৰিমাণ</th>
                    <th  style="background: #993300; color: #fff" width="27">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="18">মাটিৰ পৰিমাণ</th>
                    <th style="background: #993300; color: #fff"v width="43">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="24">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="63">ৰাজহ </th>
                    <th style="background: #993300; color: #fff"  width="38">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="51">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="31">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="26">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="41">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="36">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="63">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="58">ৰাজহ </th>
                    <th style="background: #993300; color: #fff" width="44">মাটিৰ পৰিমাণ </th>
                    <th style="background: #993300; color: #fff" width="37">ৰাজহ </th>
                    <th style="background: #993300; color: #fff"  width="30">মাটিৰ পৰিমাণ </th>
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
                  
                </tr>
                <?php
                $tot_b = 0;
                $tot_k = 0;
                $tot_l = 0;
                $tot_revenue = 0;
                $tot_patta = 0;
                $tot_local = 0;
                foreach ($query as $row):
                    $bigha = $row['bigha'];
                    $ktha = $row['ktha'];
                    $lessa = $row['lessa'];

                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $ktha, $lessa);
                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $ktha, $lessa);
                    $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);

                    $tot_b = $tot_b + $measure[0];
                    $tot_k = $tot_k + $measure[1];
                    $tot_l = $tot_l + $measure[2];
                    //$tlessa = $tot_b + $tot_k + $tot_l;
                    $tlessa = $this->utilityclass->Total_Lessa($tot_b, $tot_k, $tot_l);
                    $m = $this->utilityclass->Total_Bigha_Katha_Lessa($tlessa);
                    
                    $tot_revenue = $tot_revenue + $row['total'];
                    $tot_local = $tot_local + $row['local_tax'];
                    $tot_patta = $tot_patta + $row['total_patta'];
                    ?>
                    <tr>
                        <td class="text-success"><?php echo $row['village']; ?></td>
                       
                        <td ><?php echo $measure[0] . "&nbsp;B&nbsp;" . "-" . $measure[1] . "&nbsp;K&nbsp;" . "-" . $measure[2] . "&nbsp;L&nbsp;"; ?></td>
                        <td><?php echo $row['total']; ?></td>
                       
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
                        <td><?php echo $measure[0] . "&nbsp;B&nbsp;" . "-" . $measure[1] . "&nbsp;K&nbsp;" . "-" . $measure[2] . "&nbsp;L&nbsp;"; ?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td><?php echo $row['local_tax']; ?></td>
                        <td><?php echo $row['total_patta']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                <tr class="success">
                   
                    <th class="text-danger uni_text"><?php echo "মুঠ &nbsp;<br>" . $namedata['year'] ."<br>"; ?> </th>
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
                    <th class="text-danger uni_text" ><?php echo $m[0] . "&nbsp;B&nbsp;" . "-" . $m[1] . "&nbsp;K&nbsp;" . "-" . $m[2] . "&nbsp;L&nbsp;"; ?></th>
                    <th class="text-danger uni_text"><?php echo $tot_revenue; ?></th>
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

