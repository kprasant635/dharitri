<?php
?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

       
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $this->lang->line('enter_modify_lm_note')?>(Column 31)</h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':'.$this->session->userdata('patta_no').','.'&nbsp;'.$this->lang->line('patta_type').':'.$this->session->userdata('pattatype').','.'&nbsp;'.$this->lang->line('dag_no').':'.$this->session->userdata('dagnum');
                                 ?></h2>
            </div>
            <div class="panel-body">
                <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/showlmnoteInfo' ?>">

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
                             <tr>
                                 <td colspan="12"><h2><?php echo $this->lang->line('select_lm_note_line_no_and_click_on_show_details_corresponding_to_that_line_number')?></h2>
                            </tr>
                        </table>               
                        <div> 
                              <table class="table table-bordered" align="center" width="50%" >
               
                                <tr>
                                 <td width="50%">
                              
                                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lm_note_line_no')?>:</label><?php echo $this->lang->line('history_no_line_no')?>
                                <div class="col-sm-4">
                                 
                                    <select class="form-control fruitselect" id="select" name="lmnote" required> 
                                        <option disabled selected><?php echo $this->lang->line('select')?></option>
<?php foreach ($lminfo as $Linf): ?>
    <?php
    $Hno = $Linf->rmk_type_hist_no;
    $lno = $Linf->lm_note_lno;
    // session_start();
    // $_SESSION['DBname']= $location;
    ?>
                                            <option value="<?php echo $Hno.'-'.$lno; ?>"><?php echo $Hno.'-'.$lno; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                      
                                </div>

                            </div>
                                   
                                          </td>
                                          
                                          
                                  </tr>
                                  <tr>
                                      <td>
                                             <div class="form-group">
        <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
            <button type="submit" name="show" class="btn btn-primary">&nbsp;<?php echo $this->lang->line('show_details')?></button>
          
                                     </div>
    </div>
                                      </td>
                                  </tr>
             </table>
                        </div>
                    </div>
                    
                    </form> 
					
                                               <div class="form-group" align="center">
        <div class="col-sm-6" style="float: none;margin-top: 20px;margin-bottom: 20px;">
<!--                  <button id="addlmnote" type="submit" name="add" class="btn btn-primary">&nbsp;<?php //echo $this->lang->line('want_to_enter_a_lm_note')?></button>-->
                  <button type="submit" id="next" class="btn btn-primary">&nbsp;Return to Menu</button>
                  <button type="submit" id="exit" name="exit" class="btn btn-danger">&nbsp;<?php echo $this->lang->line('exit')?></button>  
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
   

//    document.getElementById("addlmnote").onclick = function () {
//        location.href = "<?php //echo base_url() . 'index.php/LmEntryChitha/addAlmnote' ?>";
//    };
   
    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
</script>
  
                                  

