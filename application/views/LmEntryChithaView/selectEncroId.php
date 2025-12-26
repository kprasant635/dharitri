<?php
?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

       
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $this->lang->line('enter_modify_encroacher_details')?>(Column 31)</h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':'.$this->session->userdata('patta_no').','.'&nbsp;'.$this->lang->line('patta_type').':'.$this->session->userdata('pattatype').','.'&nbsp;'.$this->lang->line('dag_no').':'.$this->session->userdata('dagnum');
                                 ?></h2>
            </div>
            <div class="panel-body">
                <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/Editencroacher' ?>">

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
                                <td colspan="12"><h2>Select Encroacher ID And Click On Show Details To Modify Encroacher Details Corresponding to ID </h2>
                            </tr>
                        </table>               
                        <div> 
                              <table class="table table-bordered" align="center" width="50%" >
               
                                <tr>
                                 <td width="50%">
                              
                                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('encroacher_id')?>:</label> 
                                <div class="col-sm-4">
                                 
                                    <select class="form-control fruitselect" id="select" name="encroid" required> 
                                        <option disabled selected><?php echo $this->lang->line('select')?></option>
<?php foreach ($encrodetails as $Einf): ?>
    <?php
    $E_id = $Einf->encro_id;
    $E_nme = $Einf->encro_name;
    // session_start();
    // $_SESSION['DBname']= $location;
    ?>
                                            <option value="<?php echo $E_id.'-'.$E_nme; ?>"><?php echo $E_id.$E_nme; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                      
                                </div>

                            </div>
                                   
                                          </td>
                                          
                                          
                                  </tr>
                                  <tr>
                                      <td>
                                             <div class="form-group" align="center">
        <div class="col-sm-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
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
                                 
                                 
            <button type="submit" name="exit" id="exit" class="btn btn-danger">&nbsp;<?php echo $this->lang->line('exit')?></button>  
       
                  <button id="addEncro" type="submit" name="add" class="btn btn-primary">&nbsp;<?php echo $this->lang->line('want_to_enter_encroacher_details')?></button>
               <button type="submit" id="next" class="btn btn-primary">&nbsp;<?php echo $this->lang->line('next')?></button>
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
   

    document.getElementById("addEncro").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addEncro' ?>";
    };
   
   document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
   
</script>
  
                                  


