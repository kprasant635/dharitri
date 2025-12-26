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
                <h2 class="panel-title"><?php echo $this->lang->line('enter_modify_crop_details')?>(Column 14-17 & 20-23 & 26-29)</h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':'.$this->session->userdata('patta_no').','.'&nbsp;'.$this->lang->line('patta_type').':'.$this->session->userdata('pattatype').','.'&nbsp;'. $this->lang->line('dag_no').':'.$this->session->userdata('dagnum');
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
                    // echo  $dist_name.'<br>'.$subdiv_code.'<br>'.$cir_code.'<br>'.$mouza_code.'<br>'.$lot_no.'<br>'.$villname;                             
                    ?>
                    <div align="center">
					<form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/showAndAddcrp' ?>">
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
                                 <td width="50%">
                              
                                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('select_crop')?> </label>
                                <div class="col-sm-4">
                                 
                                    <select class="form-control cropselect" id="select" name="crop_name" required>
                                        <option disabled selected><?php echo $this->lang->line('select')?></option>
                                      
											<?php  foreach ($cropinfo as $crpinf): ?>
												<?php
												$crpcd = $crpinf->crop_code;
                                                                                                $crpslno = $crpinf->crop_sl_no;
												$cropname = $crpinf->crop_name;
												// session_start();
												// $_SESSION['DBname']= $location;
												?>
                                            <option value="<?php echo $crpslno; ?>"><?php echo $cropname; ?></option>
                                           
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
				  </form> 
                        </div>
                    </div>
                    
                    
					<center>
					<button id="backButton" align="center" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('previous');?></button>
<!--					<button id="addCrop" type="submit" name="add" class="btn btn-success">&nbsp;<?php //echo $this->lang->line('add_a_crop_detail')?></button>-->
					<button type="submit" id="next" class="btn btn-warning">&nbsp; Return to Menu </button>
                                                                        <button type="submit" id="exit" class="btn btn-danger">&nbsp;<?php echo $this->lang->line('exit')?></button>  <center>
                    
            </div>
        </div>
    </div>
                            
            </div>
</div>
                  
                
                   <div class="form-group">
      
                                              </div>
    
       <script type="text/javascript">
    document.getElementById("next").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };
   document.getElementById("backButton").onclick = function () {
       javascript:history.back();
    };

//    document.getElementById("addCrop").onclick = function () {
//        location.href = "<?php //echo base_url() . 'index.php/LmEntryChitha/addcrop' ?>";
//    };
   
   document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    }; 
   
</script>
  
                                  