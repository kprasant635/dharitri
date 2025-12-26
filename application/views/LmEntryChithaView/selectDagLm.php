<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">      
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->lang->line('select_dag')?></h3>
            </div>
            <div class="panel-body">
                <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>">

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
                                <td class='uni_text text-danger' align="center">
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
                                <td align="center">
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
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('select_dag')?></label>
                                <div class="col-sm-4">
                                    
                                    <select class="form-control dagselect" id="select" name="Dag_no" required>
                                        <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach ($lmDaginfo as $dagno): ?>
                                          <?php
                                                 $dnum = $dagno->dag_no;
                                                 $dnum2 = $dagno->dag_no;
                                                  // session_start();
                                                 // $_SESSION['DBname']= $location;
                                                 ?>
                                            <option value="<?php echo $dnum; ?>"><?php echo $dnum2; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                        </div>
                    </div>
                    
                     <div class="form-group" align="center">
						<div class="col-sm-4 col-lg-offset-1" style="float: none;margin-top: 20px;margin-bottom: 20px;">
							<button type="submit" name='submit' class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button')?></button>
							<button id="backButton" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_home')?></button>
					  </div>
					</div>
</form>
            </div>
        </div>
    </div>

    <hr>
   
                 
            </div>
</div>

<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        //location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menulm'  ?>";
		javascript:history.back();
    };
   function display(){
         alert('please select a village!');
//document.write("please select a village");
}
</script>



