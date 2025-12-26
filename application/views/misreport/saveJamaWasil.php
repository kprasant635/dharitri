<html>
    <body>
        <p align=left><font size="4">Assam Schedule XXIV (Part-I) Form No.6</font></p>
        <table width="100%">
            <tr><td align=center colspan="2"><font size="7">জমা ওৱাছিল</font></td></tr>

            <tr><td align=center><font size="5">গাওঁৰ নাম :<?php echo $namedata[5]->village ?></font></td><td></td></tr>
        </table>
    </body>

<div class="container-fluid form-top">

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered" width="100%" >
                <tr>
                    <td rowspan="2" align="center">পাট্টা-নং</td>
                    <td rowspan="2" align="center">ৰায়তৰ নিজ নাম আৰু পিতাৰ নাম</td>
                    <td colspan="2" align="center">পাব লগা ধন</td>
                    <td colspan="4" align="center">আদায়</td>
                    <td rowspan="2" align="center">মন্তব্য</td>
                </tr>
                <tr>
                    <td align="center">ৰাজহ</td>
                    <td align="center">স্হানীয় কৰ</td>
                    <td align="center">তাৰিখ</td>
                    <td align="center">ৰাজহ</td>
                    <td align="center">স্হানীয় কৰ</td>
                    <td align="center">ক্ৰমিক নম্বৰ দৈনিক আমদানিৰ </td>
                </tr>
                <tr>
                    <td align="center">1</td>
                    <td align="center">2</td>
                    <td align="center">3</td>
                    <td align="center">4</td>
                    <td align="center">5</td>
                    <td align="center">6</td>
                    <td align="center">7</td>
                    <td align="center">8</td>
                    <td align="center">9</td>
                </tr>

                <?php
              
                $pattaArr = array();
                $c=0;
                $dagArr = array();
                $revenueArr = array();
                $localtaxArr = array();
                foreach ($patta_numbr as $pattano):
                    $patta_no = $pattano->patta_no;
                    $key = in_array($patta_no, $pattaArr);
                    $i=0;
                    if ($key == "") {
                        $i++;
                        $pattaArr[].=$patta_no;
                        $p=$patta_no;
                    }else {
                        $i=0;
                        $p="";
                    }
                      $dag_no = $pattano->dag_no;
                      $key1 = in_array($dag_no, $dagArr);
                      $i1 = 0;
                        if ($key1 == "") {
                        $i1++;
                        $dagArr[].=$dag_no;
                        $p1 = 'DNO :' . '&nbsp;' . $dag_no;
                    } else {
                        $i1=0;
                        //$i++;
                        $p1="";
                    }
                    //for revenue
                    $dag_revenues = $pattano->dag_revenue;
                    $key2 = in_array($dag_revenues, $revenueArr);
                    $i2 = 0;
                    if ($key2 == "") {
                        $i2++;
                        //$i=0;
                        $revenueArr[].=$dag_revenues;
                        $p2 = 'Rs :' . $dag_revenues;
                    } else {
                        $i2=0;
                        //$i++;
                        $p2="";
                    }
                    
                    //for local tax
                     $dag_localtaxes=$pattano->dag_localtax;
                        $key3 = in_array($dag_localtaxes, $localtaxArr);
                    $i3=0;
                    if ($key3 == "") {
                        $i3++;
                        //$i=0;
                        $localtaxArr[].=$dag_localtaxes;
                        $p3='Rs :'.$dag_localtaxes;
                    }
                    else {
                        $i3=0;
                        //$i++;
                        $p3="";
                    }
                            
                    ?>
               
          
                
                
                    <tr>
                        <td align="center"align="center" rowspan="<?php echo $i;?>">
                            <?php
                            echo $p;
                            ?>
                        </td>
                        <?php
                        if($pattano->p_flag =='1'){
                           $pattadarname = $pattano->pdar_name;
                       ?>
                        <td align="center"><?php echo '<div style="Color:#ff0000">'. $pattadarname.'</div>' ?><br/>
                             <?php echo $pattano->pdar_father; ?>
                           </td>
                    <?php } 
                        elseif($pattano->p_flag =='0')
                        {
                                  $pattadarname = $pattano->pdar_name;
                         ?>
                           <td align="center"><?php echo  '<div style="Color:black">'. $pattadarname.'</div>' ?><br/>
                            <?php echo $pattano->pdar_father; ?>
                           </td>
                        <?php }
                        
                        ?>
                           
                        
                           
                           
                        
                 <td align="center" rowspan="<?php echo $i1;?>">
                            <?php
                            echo $p1;
                            ?>
                        <br/>
                               <?php
                            echo $p2;
                            ?></td>
                         <td align="center" rowspan="<?php echo $i3;?>">
                            <?php
                            echo $p3;
                            ?>
                        </td>
                            <td align="center">&nbsp;</td>
                     <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                       <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                        <?php endforeach; 
        
                        ?>
                <tr>
                    <td class="text-center" colspan="9">
                        <button id="backButton" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;Back to Main Meu</button>
                        <button id="backButton" class="btn btn-sm btn-success"><i class="fa fa-print"></i>&nbsp;Print</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</div>   
</html>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() .  'index.php/MisReportControllerBondita/JamaWasil'  ?>";
    };
</script>
