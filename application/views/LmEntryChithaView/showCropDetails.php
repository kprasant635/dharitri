<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
			<div class="alert alert-dismissible alert-warning">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php if($this->session->flashdata('message')){?>
					  <div class="alert alert-success">      
						<?php echo $this->session->flashdata('message')?>
					  </div>
					<?php } ?>
			</div>

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('basic_details')?>(Column 1-6)</h2>

                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':' . $this->session->userdata('patta_no') . ',' . '&nbsp;' . $this->lang->line('patta_type').':' . $this->session->userdata('pattatype') . ',' . '&nbsp;' . $this->lang->line('dag_no').':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/modify' ?>">

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
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_serial_number')?>:</label>  
                                                <input type="text" name="crop_slno" readonly="true" value="<?php echo $cropinfo123['crop_sl_no'] ?>">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('year')?>:</label>  
                                                <input type="text" name="yearno" id="yy" maxLength="4" onfocus="this.value='';" value="<?php echo $cropinfo123['yearno'] ?>" required>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_name')?></label>
                                                    <div class="col-sm-4">

                                                        <select class="form-control cropnameselect" id="select" name="cropname" required>
                                                            <option value="<?php echo $cropcode ?>"><?php echo $cropname; ?></option>
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
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_category')?></label>
                                                    <div class="col-sm-4">

                                                        <select class="form-control cropselect" id="select" name="crop_category" required>
                                                            <option value="<?php echo $crpcateg_code ?>" selected><?php echo $crpcateg ?></option>
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
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_season')?></label>
                                                    <div class="col-sm-4">

                                                        <select class="form-control seasonselect" id="select" name="crp_season" required>
                                                            <option value="<?php echo $season_code ?>" selected><?php echo $season ?></option>
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
                                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('water_source')?></label>
                                                    <div class="col-sm-4">

                                                        <select class="form-control sourceselect" id="select" name="watersrc" required>
                                                            <option value="<?php echo $watersrc_code; ?>"><?php echo $watersrc; ?></option>
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
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_land_bigha')?>:</label>  
                                                <input type="text" name="bigha" id="bb" MAXLENGTH=5 onfocus="this.value='';"  value="<?php echo $cropinfo123['crop_land_area_b'] ?>" required>
                                             <input type="hidden"  id="bbcmp"  value="<?php echo $this->session->userdata('dag_area_b'); ?>" >
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_land_katha')?>:</label>  
                                                <input type="text" name="katha"  id="aa" onfocus="this.value='';" value="<?php echo $cropinfo123['crop_land_area_k'] ?>" required>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('crop_land_lessa')?>:</label>  
                                                <input type="text" name="lesa" id="ls" onfocus="this.value='';" value="<?php echo $cropinfo123['crop_land_area_lc'] ?>" required>
                                            </td>

                                        </tr>


                                </table>
                            </div>
                        </div>
                        <div class="form-group" align="center">
            <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                <button type="submit" name="modify" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('modify')?></button>


            </div>
        </div>
        </form>     
               <div class="form-group" align="center">
    <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
<!--        <form name="f1" method="post" action="<?//php echo base_url() . 'index.php/LmEntryChitha/SaveCropDetail' ?>">

           <button type="submit" id="back" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Save Record To Chitha</button> 

        </form>-->
<br>
        <button type="submit" id="viewButton" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('view_another_record')?></button>
     
 <button type="submit" id="backButton" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Return to Menu</button>
    </div>
</div>             
                </div>
            </div>
        </div>

        <hr>
        
  

                      </div>

</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
         location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };


    document.getElementById("viewButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/cropname' ?>";
    };

    $('#aa').keyup(function(){
        var val = $('#aa').val();
        console.log(val);
       
        var conv = parseInt(val);
        
        if(isNaN(conv)){
            alert("Please enter valid numeric number");
          
        }
        if(conv >= 5)
        {
            alert("Please enter range within 0-4");
       
        }
    });


 $('#ls').keyup(function(){
        var val = $('#ls').val();
        console.log(val);
       
        var conv = parseInt(val);
        
        if(isNaN(conv)){
            alert("Please enter valid numeric number");
           
        }
        if(conv > 19)
        {
            alert("The value entered must be within 0-19");
          
        }
        
      
    });
    
     $('#bb').keyup(function(){
        var val = $('#bb').val();
        console.log(val);
       
        var conv = parseInt(val);
        
        
        var cmp = $('#bbcmp').val();
        console.log(cmp);
       
        var conv2 = parseInt(cmp);
       
           if(conv > conv2)
           { alert("calculated area is more than available area");
           }
             if(isNaN(conv)){
            alert("Please enter valid numeric number");
          
        }
       });  
    
   
    
     $('#yy').keyup(function(){
        var val = $('#yy').val();
        console.log(val);
       
        var conv = parseInt(val);
        
        if(isNaN(conv)){
            alert("Please enter valid numeric number");
        }
       
    if(conv === "0000")
        {
            alert("The value entered cannot be zero");
        }
    });
    
</script>