
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">


            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('edit_fruit_details') ?>(column 30)</h2>

                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no') . ':' . $this->session->userdata('patta_no') . ',' . '&nbsp;' . $this->lang->line('patta_type') . ':' . $this->session->userdata('pattatype') . ',' . '&nbsp;' . $this->lang->line('dag_no') . ':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/modifyfruit' ?>">

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
                                    <td align="center">
<?php echo $dist_name; ?> 
                                    </td>
                                    <td align="center">
<?php echo $this->lang->line('subdivision'); ?>
                                    </td>
                                    <td align="center">
<?php echo $subdiv_name; ?> 
                                    </td>
                                    <td align="center">
<?php echo $this->lang->line('circle'); ?>  
                                    </td>
                                    <td align="center">
<?php echo $cir_name; ?> 
                                    </td>
                                    <td align="center">
<?php echo $this->lang->line('mouza'); ?> 
                                    </td>
                                    <td align="center">
<?php echo $mouza_name; ?> 
                                    </td>
                                    <td align="center">
<?php echo $this->lang->line('lot_no'); ?>
                                    </td>
                                    <td align="center">
<?php echo $lot_name; ?> 
                                    </td>
                                    <td align="center">
<?php echo $this->lang->line('vill_town'); ?>
                                    </td>
                                    <td align="center">
<?php echo $villname; ?> 
                                    </td>

                                </tr>
                            </table>               
                            <div> 
                                <table class="table table-bordered" align="center" width="50%" >
                                    <tr>

                                        <!--                            <div class="form-group">-->
                                    <tr>
                                        <td width="50%">
                                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('fruit_plant_id') ?>:</label>  
                                            <input type="text" name="fruitid"  readonly="true" value="<?php echo $fruitdetails['fruit_plant_id'] ?>">
                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="50%">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('fruit_plant_name') ?>:</label>
                                                <div class="col-sm-4">

                                                    <select class="form-control cropnameselect" id="select" name="fruitname" required >
                                                        <option value="<?php echo $fruitcode ?>"><?php echo $fruitname; ?></option>
                                                             <?php foreach ($fruitlist as $fruit): ?>
                                                            <?php
                                                            $fruitcd = $fruit->fruit_code;
                                                            $fruitnme = $fruit->fruit_name;
                                                            ?>
                                                            <option value="<?php echo $fruitcd; ?>"><?php echo $fruitnme; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('number_of_plants') ?>:</label>  
                                            <input type="text" name="numbrplant"  id="plntnumbr" onfocus="this.value = '';" value="<?php echo $fruitdetails['no_of_plants'] ?>" required>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="50%">
                                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('fruit_land_bigha') ?>:</label>  
                                            <input type="text" name="bigha" onfocus="this.value = '';" id="bigha" value="<?php echo $fruitdetails['bigha'] ?>">
                                            <input type="hidden" name="bigha1" id="bighacmp"  value="<?php echo $this->session->userdata('dag_area_b'); ?>" >
                                        </td>

                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('fruit_land_katha') ?>:</label>  
                                            <input type="text" name="katha" onfocus="this.value = '';"  id="katha" value="<?php echo $fruitdetails['katha'] ?>">
                                        </td>

                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('fruit_land_lessa') ?>:</label>  
                                            <input type="text" name="lesa" onfocus="this.value = '';" id="lesa" value="<?php echo $fruitdetails['lesa'] ?>">
                                        </td>

                                    </tr>


                                </table>
                            </div>
                        </div>

                        <div class="form-group" >
                            <div class="col-sm-4 col-lg-offset-4" >
                                <button type="submit" name="modifyfruit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('modify') ?></button>


                            </div>
                        </div>
                    </form>   
                    <center>
                        <button type="submit" id="backButton" class="btn btn-success"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('view_another_record') ?></button>
                        <button type="submit" id="next" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;Return to Menu </button>
                        <button type="submit" id="exit" class="btn btn-info"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('exit') ?></button>
                    </center>
                </div>
            </div>
        </div>

        <hr>

    </div>

</div>

<script type="text/javascript">
    document.getElementById("next").onclick = function () {
  location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };


    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/nextfruitplantselect' ?>";
    };

    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };

    $('#plntnumbr').keyup(function () {
        var val = $('#plntnumbr').val();
        console.log(val);

        var conv = parseInt(val);

        if (isNaN(conv)) {
            alert("Please enter valid numeric number");

        }

    });

    $('#bigha').keyup(function () {
        var val = $('#bigha').val();
        console.log(val);

        var conv = parseInt(val);


        var cmp = $('#bighacmp').val();
        console.log(cmp);

        var conv2 = parseInt(cmp);

        if (conv > conv2)
        {
            alert("calculated area is more than available area");
        }
        if (isNaN(conv)) {
            alert("Please enter valid numeric number");

        }
    });


    $('#katha').keyup(function () {
        var val = $('#katha').val();
        console.log(val);

        var conv = parseInt(val);

        if (isNaN(conv)) {
            alert("Please enter valid numeric number");

        }
        if (conv >= 5)
        {
            alert("Please enter range within 0-4");

        }
    });

    $('#lesa').keyup(function () {
        var val = $('#lesa').val();
        console.log(val);

        var conv = parseInt(val);

        if (isNaN(conv)) {
            alert("Please enter valid numeric number");

        }
        if (conv > 19)
        {
            alert("The value entered must be within 0-19");

        }
    });

</script>

