
<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">

       
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $this->lang->line('lot_mondols_details')?>(column 30)</h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':'.$this->session->userdata('patta_no').','.'&nbsp;'.$this->lang->line('patta_type').':'.$this->session->userdata('pattatype').','.'&nbsp;'.$this->lang->line('dag_no').':'.$this->session->userdata('dagnum');
                                 ?></h2>
            </div>
            <div class="panel-body">
                <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/modifylmnote' ?>">

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
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lm_note_cron_no')?>:</label>  
                                    <input type="text" name="lmNOtecron" readonly="true" value="<?php echo $lmrecords['cronno'] ?>">
                                </td>
                            
                                </tr>
                             
                                 <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lm_note_line_no')?>:</label>  
                                    <input type="text" name="lmNotelinenum" readonly="true" value="<?php echo $lmrecords['lineno'] ?>">
                                </td>
                              
                                  
                                </tr>
                                
                                   <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('remark_type_hist_no')?>:</label>  
                                    <input type="text" name="lmNotehistnum" readonly="true" value="<?php echo $lmrecords['histno'] ?>">
                                </td>
                                  
                                </tr>
                                   <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lm_note')?>:</label>  
                                    <textarea  cols="40" rows="4" name="lmNOte" value="" required><?php echo $lmrecords['lm_note'] ?></textarea>
                                </td>
                                  
                                </tr>
                                
                                         <tr>
                                <td width="50%">
                                    <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('note_date_(dd/mm/yyyy)')?>:</label>  
                                      <?php  $newDate123 = date("d-m-Y", strtotime($lmrecords['dateentry']));?>
									  <input type="text" id="ddmmyy" name="lmNOteDate" value="<?php 
									  
									  
									  echo  $newDate123  ?>" required>
                                </td>
                                  
                                </tr>
                                
                                
                                <tr>
                                 <td width="50%">
                                       <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lm_name')?>:</label>
                                <div class="col-sm-4">
                                    <select class="form-control placeselect" id="select" name="lmname" >
                                    <?php
                                        if (($lmrecords['result'] <= '0'))
                                       {
                                        ?>
                                        <?php
                                        foreach ($lm_nme as $lname):
                                        ?>
                                        <option value="<?php echo $lname->lm_code; ?>"><?php echo $lname->lm_name; ?></option>
                                        <?php endforeach; ?>
                                        <?php
                                        }
                                       else
                                       {
                                        ?>
                                        <option value="<?php echo $lmrecords['lm_code'] ?>"><?php echo $lmrecords['lm_name']; ?></option>
                                        <?php
                                       }
                                    ?>
                                    
                    </select>
                                </div>

                            </div>
                                          </td>
                                          
                              
                                  </tr>
                                   <tr>
                                <td width="20%">
                                                     
                                               <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lm_sign_y_n')?>:</label>  
 <div>
  
     <input type="radio" name="s" value="y" checked> yes
<input type="radio" name="s" value="n"> no
 </div>

                                               
                                         
                                </td>
                                  
                                </tr>
                                          <tr>
                                <td width="50%">
                                                     
                                               <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('cos_approval')?>:</label>  
   <div>
    <input type="radio" name="f" value="y" > yes
<input type="radio" name="f" value="n" checked="checked"> no
 
</div>
                                               
                                         
                                </td>
                                  
                                </tr>
                      </table>
                        </div>
                    </div>
                        
                         <div class="form-group" align="center">
        <div class="col-sm-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
            <button type="submit" name="modifylmnote" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('modify')?></button>
       
        
        </div>
    </div>
</form>  
           <div class="form-group" align="center">
          <div class="col-sm-6" style="float: none;margin-top: 20px;margin-bottom: 20px;">
<!--              <form name="f1" method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/savelmnote' ?>">
              
                    <button type="submit" id="back" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Save Record To Chitha</button>
              
              </form><br>-->
           

                 <button type="submit" id="return" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Return to Menu </button>
              <button id="previous" align="center" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('previous');?></button>     
       <button type="submit" id="exit" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('exit')?> </button>
               </div>
     </div>             
            </div>
        </div>
    </div>

    <hr>
  
            </div>
      
</div>
     
     <script type="text/javascript">
   document.getElementById("previous").onclick = function () {
         javascript:history.back();
    };
   

       document.getElementById("return").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };
   
    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
</script>



