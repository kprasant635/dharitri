<?php //echo $villageinfo['distname']; ?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="">
          
                 <table class='table'  height="70px" border=2 bordercolor=lightblue>
		<tr>
			<td border=2 bordercolor=Blue width=100 class='uni_text' align=center style="FONT-FAMILY:ASBW-TTdurga; FONT-SIZE:25;color:red;">
				গাওঁৰনাম
			</td>
			<td  width=120 align=center style="FONT-FAMILY:ASBW-TTdurga; FONT-SIZE:25;">
				নামজাৰীৰ প্ৰকাৰ
			</td>
			<td  width=140 align=center style="FONT-FAMILY:ASBW-TTdurga; FONT-SIZE:25;">
				আবেদনকাৰীৰ বিবৰণ
			</td>
			<td  width=100 align=center style="FONT-FAMILY:ASBW-TTdurga; FONT-SIZE:25;">
				মাটিৰ পৰিমান
			</td>
			<td  width=130 align=center style="FONT-FAMILY:ASBW-TTdurga; FONT-SIZE:25;">
			 পট্টাদাৰৰ বিবৰণ
			</td>
			<td  width=80 align=center style="FONT-FAMILY:Arial; cursor:hand; FONT-SIZE:14"; onClick="display()">
				
				Help
			</td>
		</tr>
	</table>
              
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/locationSelection' ?>">
               
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('district')?></label>
                                <div class="col-sm-4"> 
                                    <input type="text" class='form-control' name="dist_name" value="<?php echo $name['distname'] ?>" required ></div>
                         </div>
                        
                
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('subdivision')?></label>
                                <div class="col-sm-4"> 
                                    <input type="text" class='form-control' name="subdiv_name" value="<?php echo $name['sub_divname'] ?>" required ></div>
                         </div>
                  
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('circle')?></label>
                                <div class="col-sm-4"> 
                                    
                                     
                                    <input type="text" class='form-control' name="cir_name" value="<?php echo $name['cir_codename'] ?>" required ></div>
                         
                            </div>
           
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('mouza')?></label>
                                <div class="col-sm-4"> 
                                   
                                    <input type="text" class='form-control' name="mouza_name" value="<?php echo $name['mouza_codename'] ?>" required ></div>
                           
                            </div>
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lot_no')?></label>
                                <div class="col-sm-4"> 
                                   
                                     
                                    <input type="text" class='form-control' name="lot_name" value="<?php echo $name['lot_noname'] ?>" required ></div>
                          
                            </div>
               
                          
                         
                  
                           <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-sm-4">
                                <select class="form-control villageselect" id="select" name="vill_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php 
                                    
                                    foreach ($lmVillageinfo as $villname): ?>
                                        <?php
                                        $villCode = $villname->vill_townprt_code;
                                        $location = $villname->loc_name;
                                        // session_start();
                                        // $_SESSION['DBname']= $location;
                                        ?>
                                        <option value="<?php echo $villCode; ?>"><?php echo $location; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
 
                        </div>
                          <div class="form-group">
                            <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button')?></button>
                               <button type="button" id="backButton" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_home')?></button>
                            </div>
							</form>
                        </div>
                    
                      <div class="col-sm-4 col-lg-offset-4">
                            <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                              
                               
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

  <hr>
                      
                    
 
     <script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
   function display(){
         alert('please select a village!');
//document.write("please select a village");
}
</script>



