<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">

            <div class='center'>
                <table class='table table-bordered text-center'>
                    <tr>
                        <td class="alert-new" rowspan="3">Circle</td>
                        <td class="alert-new" colspan="4">Kharif</td>
                        <td class="alert-new" colspan="4">Rabi</td>
                    </tr>
                    <tr>
                        <td class="alert-new" colspan="2">High Yielding</td>
                        <td class="alert-new" colspan="2">Normal</td>
                        <td class="alert-new" colspan="2">High Yielding</td>
                        <td class="alert-new" colspan="2">Normal</td>
                    </tr>
                    <tr>
                        <td class="alert-new">Irrigated</td>
                        <td class="alert-new">Rain-fed</td>
                        <td class="alert-new">Irrigated</td>
                        <td class="alert-new" >Rain-fed</td>
                        <td class="alert-new">Irrigated</td>
                        <td class="alert-new" >Rain-fed</td>
                        <td class="alert-new">Irrigated</td>
                        <td class="alert-new" >Rain-fed</td>  
                    </tr>
                    <?php
                    $tot_kharifrichirrg=0;
                    $tot_kharifrichnonirrg=0;
                    $tot_kharifnormalirrg=0;
                    $tot_kharifnormalnonirrg=0;
                    $tot_ravirichirrg=0;
                    $tot_ravirichnonirrg=0;
                    $tot_ravinormalirrg=0;
                    $tot_ravinormalnonirrg=0;
                    foreach ($circle as $key=>$val) {
                        ?>
                        <tr>
                    <td><?php echo $key; ?></td>
                    <td >
                        <?php 
                        $b=$val['kharifrichirrg']->b;
                        $k=$val['kharifrichirrg']->k;
                        $l=$val['kharifrichirrg']->l;
                        $totkha1=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_kharifrichirrg=$tot_kharifrichirrg+$totkha1;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($totkha1);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?>  
                    </td>
                    <td >
                    <?php 
                        $b=$val['kharifrichnonirrg']->b;
                        $k=$val['kharifrichnonirrg']->k;
                        $l=$val['kharifrichnonirrg']->l;
                        $totkha2=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_kharifrichnonirrg=$tot_kharifrichnonirrg+$totkha2;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($totkha2);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?>  
                    </td>
                    <td >
                    <?php 
                        $b=$val['kharifnormalirrg']->b;
                        $k=$val['kharifnormalirrg']->k;
                        $l=$val['kharifnormalirrg']->l;
                        $tot_kha3=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_kharifnormalirrg=$tot_kharifnormalirrg+$tot_kha3;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_kha3);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?>  
                    </td>
                    <td  >
                    <?php 
                        $b=$val['kharifnormalnonirrg']->b;
                        $k=$val['kharifnormalnonirrg']->k;
                        $l=$val['kharifnormalnonirrg']->l;
                        $tot_kha4=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_kharifnormalnonirrg=$tot_kharifnormalnonirrg+$tot_kha4;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_kha4);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?>
                    </td>
                    <td >
                        <?php 
                        $b=$val['ravirichirrg']->b;
                        $k=$val['ravirichirrg']->k;
                        $l=$val['ravirichirrg']->l;
                        $tot_ravi1=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_ravirichirrg=$tot_ravirichirrg+$tot_ravi1;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravi1);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?>
                    </td>
                    <td >
                         <?php 
                        $b=$val['ravirichnonirrg']->b;
                        $k=$val['ravirichnonirrg']->k;
                        $l=$val['ravirichnonirrg']->l;
                        $tot_ravi2=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_ravirichnonirrg=$tot_ravirichnonirrg+$tot_ravi2;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravi2);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?>
                    </td>
                    <td>
                        <?php 
                        $b=$val['ravinormalirrg']->b;
                        $k=$val['ravinormalirrg']->k;
                        $l=$val['ravinormalirrg']->l;
                        $tot_ravi3=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_ravinormalirrg=$tot_ravinormalirrg+$tot_ravi3;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravi3);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?></td>
                    <td><?php 
                        $b=$val['ravinormalnonirrg']->b;
                        $k=$val['ravinormalnonirrg']->k;
                        $l=$val['ravinormalnonirrg']->l;
                        $tot_ravi4=$this->utilityclass->Total_Lessa($b,$k,$l);
                        $tot_ravinormalnonirrg=$tot_ravinormalnonirrg+$tot_ravi4;
                        $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravi4);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                        ?></td>  
                </tr>
                        <?php
                    }
                    ?>
                        <tr>
                    <td class="alert-new">Total</td>
                    <td class="alert-new"><?php   $tot_kharifrichirrg;
                     $data_kha=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_kharifrichirrg);
                     echo $data_kha[0]." B -".$data_kha[1]." K -".$data_kha[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php  $tot_kharifrichnonirrg ;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_kharifrichnonirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php  $tot_kharifnormalirrg;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_kharifnormalirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php   $tot_kharifnormalnonirrg;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_kharifnormalnonirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php   $tot_ravirichirrg;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravirichirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php  $tot_ravirichnonirrg;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravirichnonirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php  $tot_ravinormalirrg;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravinormalirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    <td class="alert-new" ><?php  $tot_ravinormalnonirrg;
                     $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tot_ravinormalnonirrg);
                        echo $data[0]." B -".$data[1]." K -".$data[2]." L";
                    ?></td>
                    
                </tr>
                </table>  
            </div>

            <br>
        </div>
    </div>

</div>
