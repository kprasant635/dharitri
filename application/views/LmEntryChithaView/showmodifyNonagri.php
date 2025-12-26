
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
		
			  <?php if($this->session->flashdata('message')){?>
			  <div class="alert alert-success">      
				<?php echo $this->session->flashdata('message')?>
			  </div>
			<?php } ?>
			
       
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $this->lang->line('edit_non_agricultural_land_use_details')?></h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':' .$this->session->userdata('patta_no').','.'&nbsp;'.$this->lang->line('patta_type').':' .$this->session->userdata('pattatype').','.'&nbsp;'.$this->lang->line('dag_no').':' .$this->session->userdata('dagnum');
                                 ?></h2>
            </div>
            <div class="panel-body">
                <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/modifynonAgr' ?>">

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
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('non_agricultural_use_id')?>:</label>  
                                      <input type="text" name="noncrpid" readonly="true" value="<?php echo $nonAgri['noncrop_id'] ?>">
                                </td>
                                  
                                </tr>
                                <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('year')?>:</label>  
                                    <input type="text" name="year" id="yy" onfocus="this.value='';"  maxlength="4"value="<?php echo $nonAgri['year']  ?>">
                                </td>
                             
                                </tr>
                                <tr>
                                 <td width="50%">
                                       <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('type_of_usages')?></label>
                                <div class="col-sm-4">
                                 
                                    <select class="form-control cropnameselect" id="select" name="noncropname" >
                                        <option value="<?php echo $noncrpcode ?>"><?php echo $noncrptyp ; ?></option>
<?php foreach ($usednoncrp as $noncropname): ?>
    <?php
    $noncropcd = $noncropname->used_noncrop_type_code;
   $noncropnme = $noncropname->noncrop_type;
  
    ?>
                                            <option value="<?php echo $noncropcd; ?>"><?php echo $noncropnme; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                                          </td>
                                          
                              
                                  </tr>
                                 
                                 
                                      <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('non_agricultural_land_bigha')?>:</label>  
                                      <input type="text" name="bigha" id="bigha" onfocus="this.value='';" value="<?php echo $nonAgri['bigha']  ?>">
                                <input type="hidden" name="bigha1" id="bighacmp"  value="<?php echo $this->session->userdata('dag_area_b'); ?>" >
                                </td>
                                  
                                </tr>
                                    <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('non_agricultural_land_katha')?>:</label>  
                                      <input type="text" name="katha" id="katha" onfocus="this.value='';" value="<?php echo $nonAgri['katha'] ?>">
                                </td>
                                  
                                </tr>
                                    <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('non_agricultural_land_lessa')?>:</label>  
                                      <input type="text" name="lesa" id="lesa" onfocus="this.value='';" value="<?php echo  $nonAgri['lesa'] ?>">
                                </td>
                                  
                                </tr>
                                
                                  
                              </table>
                        </div>
                    </div>
                        
                  <div class="form-group" align="center">
        <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
            <button type="submit" name="modifynonAgri" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('modify')?></button>
       
        
        </div>
    </div>
</form>       
              <div class="form-group" align="center">
          <div class="col-sm-6" style="float: none;margin-top: 20px;margin-bottom: 20px;">
<!--              <form name="f1" method="post" action="<?php //echo base_url() . 'index.php/LmEntryChitha/SavenonagriCropDetail' ?>">
              
                    <button type="submit" id="back" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;Save Record To Chitha</button>
              
              </form><br>-->
             
                <button type="submit" id="backButton" class="btn btn-danger">&nbsp;<?php echo $this->lang->line('view_another_record')?> </button>
               <button type="submit" id="backButton1" name="next" class="btn btn-primary">&nbsp;<?php echo $this->lang->line('previous')?></button>
               <button type="submit" id="next" class="btn btn-info">&nbsp;Return to Menu</button>
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
          location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };
   document.getElementById("backButton1").onclick = function () {
       javascript:history.back();
    };

    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/nextNonAgri' ?>";
    };
   
   
    $('#bigha').keyup(function(){
        var val = $('#bigha').val();
        console.log(val);
       
        var conv = parseInt(val);
        
        
        var cmp = $('#bighacmp').val();
        console.log(cmp);
       
        var conv2 = parseInt(cmp);
       
           if(conv > conv2)
           { alert("calculated area is more than available area");
           }
             if(isNaN(conv)){
            alert("Please enter valid numeric number");
          
        }
       });
       
       
         $('#katha').keyup(function(){
        var val = $('#katha').val();
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
       
       $('#lesa').keyup(function(){
        var val = $('#lesa').val();
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