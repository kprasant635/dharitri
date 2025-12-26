<div class="row login">
        <div class="col-lg-12 center-col">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class='center bold'>Select The Controller For Authorizing Users</p>
                    </div>
                </div>
                <hr>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
						<center>
                            <form name="" method='post' action="<?php echo base_url();?>index.php/login/set_Permission_users" >
                                <table border="0" cellpadding="1" cellspacing="1" width="700px" style="VISIBILITY: visible"> 
                                    <tr>
                                        <td width="30%"><b>Controller Name :</b></td>
                                        <td>
                                            <select class="form-control col-lg-6" name='Controller'>
											<?php 
											
											foreach ($results as $r=>$v):
											{
												echo "<option value=".$v.">".$v."</option>";
											}
											endforeach;
											?>
											</select>
                                        </td>			
                                    </tr>
                                </table>
                                <P align = center>
                                    <button type="submit" id='submit' name='submit' value="Submit" class="btn btn-danger" title="Click on Submit to post the entered data"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                </P>
                                <p><hr width = 700px color = silver></hr></p>
                                <font color=red>Note : After Selecting the controller from the drop down you will be redirected to the page consisting all the functions of that particular controller.</font>	
                                <p><hr width = 700px color = silver></hr></p>
                            </form>
                            [ <a href="<?php echo base_url(); ?>index.php/login">Move To Login Page</a> ]
                        </center>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>



                    