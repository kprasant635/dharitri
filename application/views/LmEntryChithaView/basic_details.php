<?php
$bigha = $pattatyps['dag_area_b'];
$katha = $pattatyps['dag_area_k'];
$lessa = $pattatyps['dag_area_lc'];
$totallesa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
//echo 'totallesa'.$totallesa;
$totalare123 = $this->utilityclass->TotalAre($totallesa);
$totalare = round($totalare123, 2);
//echo 'totalare'.$totalare;
?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">


            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('basic_details') ?>(<?php echo $this->lang->line('column') ?> 1-6)</h2>

                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no') . ':' . $pattatyps['patta_no'] . ',' . '&nbsp;' . $this->lang->line('patta_type') . ':' . $pattatyps['pattatype'] . ',' . '&nbsp;' . $this->lang->line('dag_no') . ':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">


                    <?php
                    $dist_name = $this->session->userdata('distname');
                    $subdiv_name = $this->session->userdata('sub_divname');
                    $cir_name = $this->session->userdata('cir_codename');
                    $mouza_name = $this->session->userdata('mouza_codename');
                    $lot_name = $this->session->userdata('lot_noname');
                    $villname = $this->session->userdata('villname');
                    //echo  $dist_name.'<br>'.$subdiv_code.'<br>'.$cir_code.'<br>'.$mouza_code.'<br>'.$lot_no.'<br>'.$villname;                             
                    ?>
                    <div align="center">
                        <br>
                        <table class="table table-bordered" align="center" width="100%" >
                            <tr>
                                <td align="center">
                                    <?php echo $this->lang->line('district'); ?> 
                                </td>
                                <td class='uni_text text-danger'align="center">
                                    <?php echo $dist_name; ?> 
                                </td>
                                <td align="center">
                                    <?php echo $this->lang->line('subdivision'); ?> 
                                </td>
                                <td class='uni_text text-danger' align="center">
                                    <?php echo $subdiv_name; ?> 
                                </td>
                                <td align="center">
                                    <?php echo $this->lang->line('circle'); ?> 
                                </td>
                                <td class='uni_text text-danger' align="center">
                                    <?php echo $cir_name; ?> 
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <?php echo $this->lang->line('mouza'); ?> 
                                </td>
                                <td class='uni_text text-danger' align="center">
                                    <?php echo $mouza_name; ?> 
                                </td>
                                <td  align="center">
                                    <?php echo $this->lang->line('lot_no'); ?> 
                                </td>
                                <td class='uni_text text-danger' align="center">
                                    <?php echo $lot_name; ?> 
                                </td>
                                <td align="center">
                                    <?php echo $this->lang->line('vill_town'); ?> 
                                </td>
                                <td class='uni_text text-danger' align="center">
                                    <?php echo $villname; ?> 
                                </td>
                            </tr>
                        </table>               




                    </div>
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/add_basic_info' ?>">
                        <div class="form-group">						  
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('old_dag_number') ?>:</label>         
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' maxlength="12" name="olddagno" value="">
                            </div>

                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('direct_paying') ?>:</label>  
                            <div class="col-lg-3">
                                <div class="radio">
                                    <input type="radio" name="s" value="Y" > yes
                                </div>
                                <div class="radio">
                                    <input type="radio" name="s" value="N" checked> no
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_no') ?>:</label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' maxlength="12" name="dagno"  value="<?php echo $this->session->userdata('dagnum') ?> ">						
                            </div>

                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_land_revenue') ?>:</label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class="form-control"  maxlength="19" name="dagrev" value="<?php echo round($pattatyps['dag_revenue'], 2) ?>">  
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('patta_type'); ?> </label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control'   maxlength="19" name="pattatype" value="<?php echo $pattatyps['pattatype'] ?>">

                            </div>

                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_local_rate') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class="form-control" maxlength="19" name="daglocal" value="<?php echo round($pattatyps['dag_local_tax'], 2); ?>"> 

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('patta_no') ?></label>  
                            <div class="col-lg-3">

                                <input type="text" readonly class='form-control'  maxlength="20" name="pattano" value="<?php echo $pattatyps['patta_no'] ?>"> 
                            </div>

                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('north_description') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class="form-control" maxlength="50"  name="northdesc" value="">  

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('grant_no_(if_any)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control'  maxlength="" name="grantno" value="">   

                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('south_description') ?></label> 
                            <div class="col-lg-3">
                                <input class="form-control" readonly type="text" name="southdesc" value="">  
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_type') ?></label>  
                            <div class="col-lg-4">
                                <select class="form-control landselect" id="select" name="land_code">
                                    <option value="<?php echo $pattatyps['land_class_code'] ?>"><?php echo $pattatyps['land_type']; ?></option>
                                    <?php //foreach ($landclass_info as $landclass): ?>
                                        <?php
                                        //$landclass_code = $landclass->class_code;
                                       // $land_type = $landclass->land_type;
                                        // session_start();
                                        // $_SESSION['DBname']= $location;
                                        ?>
                                        <option value="<?php// echo $landclass_code; ?>"><?php// echo $land_type; ?></option>
                                    <?php //endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('east_description') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class="form-control"  name="eastdesc" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_area_(in_acre)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="dag_area_are" value="<?php echo $totalare ?>" required > 
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('west_description') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly  class='form-control' name="westdesc" value="" >  
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_area_(in_bigha)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="bigha" value="<?php echo $pattatyps['dag_area_b'] ?>" > 
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('Dag_no_(north_side)') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="northdesc_dag" value="">  
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_area_(in_katha)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="katha" value="<?php echo $pattatyps['dag_area_k'] ?>"> 
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('Dag_no_(south_side)') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="southdesc_dag" value=""> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_area_(in_chatak_lessa)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="chatak" value="<?php $lessa_basic = round($pattatyps['dag_area_lc'], 2);
                                    echo $lessa_basic
                                    ?>">  
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('Dag_no_(east_side)') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="eastdesc_dag" value=""> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_area_(in_ganda)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="ganda" value="0"> 
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('Dag_no_(west_side)') ?></label> 
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control' name="westdesc_dag" value=""> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_area_(in_krantik)') ?></label>  
                            <div class="col-lg-3">
                                <input type="text" readonly class='form-control'  name="krantik" value="0"> 
                            </div>
                        </div>

                        <div align="center">
                            <div class="form-group">
                                <div class="col-sm-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" name="submit_crop" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('modify') ?></button>

                                </div>
                            </div>
                        </div>
                    </form> 
                    <div  align="center">
                        <button id="backButton" align="center" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('previous'); ?></button>

                        <button id="next123" align="center" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;Return to Menu</button>
                        <button type="submit" id="exit" class="btn btn-danger">&nbsp;<?php echo $this->lang->line('exit') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            // location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/locationSelection' ?>";
            javascript:history.back();
        };

        document.getElementById("next123").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";

        };

        document.getElementById("exit").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
        }
    </script>

