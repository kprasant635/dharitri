<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('basic_details') ?>(Column 1-6)</h2>

                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no') . ':' . $this->session->userdata('patta_no') . ',' . '&nbsp;' . $this->lang->line('patta_type') . ':' . $this->session->userdata('pattatype') . ',' . '&nbsp;' . $this->lang->line('dag_no') . ':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/addcropinfo' ?>">

                        <?php
                        $dist_name = $this->session->userdata('distname');
                        $subdiv_name = $this->session->userdata('sub_divname');
                        $cir_name = $this->session->userdata('cir_codename');
                        $mouza_name = $this->session->userdata('mouza_codename');
                        $lot_name = $this->session->userdata('lot_noname');
                        $villname = $this->session->userdata('villname');
                        // echo  $dist_name.'<br>'.$subdiv_code.'<br>'.$cir_code.'<br>'.$mouza_code.'<br>'.$lot_no.'<br>'.$villname;                             
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
                            <div> 
                                <table class="table table-bordered" align="center" width="50%" >
                                    <tr>

                                    <div class="form-group">
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_serial_number') ?>:</label>  
                                                <input type="text" name="crop_slno" readonly="true" value="<?php echo $cropslno['crop_sl_no'] ?>">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('year') ?>:</label>  
                                                <input type="text" name="yearno" value='2016' maxLength="4" id="yy" value="" required><font color=red>*</font>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_name') ?></label><font color=red>*</font>
                                                    <div class="col-sm-4">

                                                        <select class="form-control cropnameselect" id="select" name="cropname" required>
                                                            <option  ><?php echo $this->lang->line('select') ?></option>
															 
<?php foreach ($crpnme as $cropname): ?>
                                                                <?php
                                                                $cropcd = $cropname->crop_code;
                                                                $cropnme = $cropname->crop_name;
                                                                ?>
                                                                <option value="<?php echo $cropcd; ?>"><?php echo $cropnme; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>


                                        </tr>

                                        <tr>
                                            <td width="50%">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_category') ?></label><font color=red>*</font>
                                                    <div class="col-sm-4">

                                                        <select class="form-control cropselect" id="select" name="crop_category" required>
                                                            <option  selected><?php echo $this->lang->line('select') ?></option>
                                                            <?php foreach ($crop_category_info as $crp_category): ?>
                                                                <?php
                                                                $crop_category_code = $crp_category->crop_categ_code;
                                                                $crop_categ_desc = $crp_category->crop_categ_desc;
                                                                ?>
                                                                <option value="<?php echo $crop_category_code; ?>"><?php echo $crop_categ_desc; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>   

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_season') ?></label><font color=red>*</font>
                                                    <div class="col-sm-4">

                                                        <select class="form-control seasonselect" id="select" name="crp_season" required>
                                                            <option disabled selected><?php echo $this->lang->line('select_crop_season') ?></option>

                                                            <?php foreach ($ss as $season): ?>
                                                                <?php
                                                                $seasoncd = $season->season_code;
                                                                $crpseason = $season->crop_season;
                                                                ?>
                                                                <option value="<?php echo $seasoncd; ?>"><?php echo $crpseason; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td width="50%">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('water_source') ?></label><font color=red>*</font>
                                                    <div class="col-sm-4">

                                                        <select class="form-control sourceselect" id="select" name="watersrc" required>
                                                            <option disabled selected><?php echo $this->lang->line('select_water_source') ?></option>

                                                            <?php foreach ($watersource as $ws): ?>
                                                                <?php
                                                                $watersrc_cd = $ws->water_source_code;
                                                                $src = $ws->source;
                                                                ?>
                                                                <option value="<?php echo $watersrc_cd; ?>"><?php echo $src; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_land_bigha') ?>:</label>  
                                                <input type="text" name="bigha1" id="bighanum" value="" maxLength=5 required>
                                                <input type="hidden" name="bigha" id="bighacmp" value="<?php echo $this->session->userdata('dag_area_b'); ?>" maxLength=5 required>

                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_land_katha') ?>:</label>  
                                                <input  type="text" name="katha" id="ktha" value="" required>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_land_lessa') ?>:</label>  
                                                <input   type="text" name="lesa" value="" id="lsa" required>
                                            </td>

                                        </tr>


                                </table>
                            </div>
                        </div>

                        <div class="form-group" >
                            <div class="col-sm-4 col-lg-offset-4 " style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" name="modify" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                            </div>
                        </div>
                    </form>     
                    <center>
                        <button id="backButton" align="center" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('previous'); ?></button>
                        <button id="exit" class="btn btn-success"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('exit') ?></button>
                        <button id="next" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp; Return to Menu</button>
                    </center>    
                </div>
            </div>
        </div>

        <hr>

    </div>
</div>   
</div>

<script type="text/javascript">
    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
    document.getElementById("backButton").onclick = function () {
        javascript:history.back();
    };
    document.getElementById("next").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };

    $('#yy').keyup(function () {
        var val = $('#yy').val();
        console.log(val);

        var conv = parseInt(val);

        if (isNaN(conv)) {
            alert("Please enter valid numeric number");
        }
    });

    $('#ktha').keyup(function () {
        var val = $('#ktha').val();
        console.log(val);

        var conv = parseInt(val);

        if (conv >= 5)
        {
            alert("Please enter range within 0-4");
        }
    });

    $('#lsa').keyup(function () {
        var val = $('#lsa').val();
        console.log(val);

        var conv = parseInt(val);

        if (conv > 19)
        {
            alert("Please enter range within 0-19");
        }
    });
    $('#bighanum').keyup(function () {
        var val = $('#bighanum').val();
        console.log(val);

        var conv = parseInt(val);


        var cmp = $('#bighacmp').val();
        console.log(cmp);

        var conv2 = parseInt(cmp);

        if (conv > conv2)
        {
            alert("calculated area is more than available area");
        }
    });



    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
</script>