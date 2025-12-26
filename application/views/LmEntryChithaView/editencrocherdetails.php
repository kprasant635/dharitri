
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">


            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('edit_encroacher_details') ?>(column 30)</h2>

                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no') . ':' . $this->session->userdata('patta_no') . ',' . '&nbsp;' . $this->lang->line('patta_type') . ':' . $this->session->userdata('pattatype') . ',' . '&nbsp;' . $this->lang->line('dag_no') . ':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/encromodify' ?>">

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

                                    <div class="form-group">
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_id') ?>:</label>  
                                                <input type="text" name="encroid" readonly="true" value="<?php echo $encroid ?>">
                                            </td> 
												 <td>
                                                <label for="inputEmail3" class="col-sm-4 control-label">Enchroacher Since(dd/mm/yyyy):</label>  
												<?php  $encro_since123 = date("d/m/Y", strtotime($encro_since));?>
                                                <input type="text" name="encroachersince" id="ddmmyy" value="<?php echo $encro_since123;?>" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('remark_type_hist_no') ?>:</label>  
                                                <input type="text" name="RmktypHistno" readonly="true" id="rmkhistno" value="<?php echo $hist_no ?>">
                                            </td>
                                            <td width="50%">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_land_used_for') ?></label>
                                                    <div class="col-sm-4">

                                                        <select class="form-control placeselect" id="select" name="landusedfor"  required>
                                                            <option value="<?php echo $cd ?>"><?php echo $landused; ?></option>
<?php foreach ($landused_dd as $Lused): ?>
                                                                <?php
                                                                $lcd = $Lused->code;
                                                                $usedfr = $Lused->used_for;
                                                                ?>
                                                                <option value="<?php echo $lcd; ?>"><?php echo $usedfr; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_name') ?>:</label>  
                                                <input type="text" name="encroacherName" value="<?php echo $name ?>" required>
                                            </td>

                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('land_area_bigha') ?>:</label>  
                                                <input type="text" name="bigha" id="bigha" onfocus="this.value = '';" value="<?php echo $bigha ?>">
                                                <input type="hidden" name="bigha" id="bighacmp"  value="<?php echo $this->session->userdata('dag_area_b'); ?>" >

                                            </td>






                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_guardian_name') ?>:</label>  
                                                <input type="text" name="guardnme" value="<?php echo $encroguardian ?>" required>
                                            </td>


                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('land_area_katha') ?>:</label>  
                                                <input type="text" name="katha" id="katha" onfocus="this.value = '';" value="<?php echo $katha ?>" required>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('relation_with_guardian') ?>:</label>  
                                                <div class="col-sm-4">

                                                    <select class="form-control placeselect" id="select" name="rel" required >
                                                        <option value="<?php echo $relcode ?>"><?php echo $rel; ?></option>
<?php foreach ($relinfo as $relation): ?>
    <?php
    $relcd = $relation->guard_rel;
    $relname = $relation->guard_rel_desc_as;
    ?>
                                                            <option value="<?php echo $relcd; ?>"><?php echo $relname; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>


                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('land_area_lessa') ?>:</label>  
                                                <input type="text" name="lesa" id="lesa" onfocus="this.value = '';" value="<?php echo $lesa ?>">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_address') ?>:</label>  
                                                <input type="text" name="add" value="<?php echo $encro_addr ?>" required>
                                            </td>


                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_evicted') ?>:</label>  
                                                <div>

                                                    <input type="radio" name="evi" value="Y" > yes
                                                    <input type="radio" name="evi" value="N" checked> no
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('nature_of_encroached_land') ?>:</label>  
                                                <div class="col-sm-4">

                                                    <select class="form-control placeselect" id="select" name="natureland" required>
                                                        <option value="<?php echo $typeCd ?>"><?php echo $type; ?></option>
<?php foreach ($landNatureinfo as $nature): ?>
    <?php
    $typcd = $nature->type_code;
    $typ = $nature->type;
    ?>
                                                            <option value="<?php echo $typcd; ?>"><?php echo $typ; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>


                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_evic_date(dd/mm/yyyy)')?>:</label>  
                                                 <?php  $date123 = date("d/m/Y", strtotime($date));?>
												<input type="text" class='dating' name="date" value="<?php echo $date123 ?>" required>
                                            </td>

                                        </tr>

                                </table>
                            </div>
                        </div>

                        <div class="form-group" align="center">
                            <div class="col-sm-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" name="modifyenco" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('modify') ?></button>


                            </div>
                        </div>
                    </form>      
                    <div class="form-group" align="center">
                        <div class="col-sm-6" style="float: none;margin-top: 20px;margin-bottom: 20px;">
              <!--              <form name="f1" method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/savEncro' ?>">
                            
                                  <button type="submit" id="back" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;Save Record To Chitha</button>
                            
                            </form><br>-->

                           

                            <button type="submit" id="next" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('next') ?> </button>
                        </div>
                    </div>             
                </div>
            </div>
        </div>

        <hr>

    </div>

</div>

<script type="text/javascript">
    document.getElementById("next").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/nextLmselectOption' ?>";
    };


   


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

