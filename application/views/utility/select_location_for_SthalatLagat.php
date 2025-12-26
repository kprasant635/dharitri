<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?php echo $this->lang->line('select_location')?></h3>
                </div>
<style>
input[type='radio']:checked:after 
    {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #ffa500;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }
</style>
<style type="text/css">
	option.white {font-color: white;font-size: 16px}
</style>


<script Language="JavaScript">
    function opt1()
    {
        Form1.txtopt.value = 1;      
    }
    function opt2() 
	{
        Form1.txtopt.value = 2;
    }   
	function ValidField(form)
	{
	if (Form1.dag_no.value == "" || Form1.dag_no.value=='0') 
	 {
            alert("SORRY!!!Dag No Cant be Blank..")
            Form1.dag_no.focus();
            return;
        }
	  form.submit();
	}
</script>
                <div class="panel-body">
             	<form name="Form1" class='form-horizontal' method="post" action="">
				 <input type="hidden" name="txtopt" value="1"/>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('district')?> </label>
                            <div class="col-sm-4">
							<select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                            <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div>
                        </div>                       
                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-sm-4">
                              <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('circle')?> </label>
                            <div class="col-sm-4">
                            <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('mouza')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control mouzaselect" id="select" name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
                                    <?php foreach ($mouza as $moz): ?>
                                        <?php
                                        $mouza_code = $moz->mouza_pargona_code;
                                        $mouza_name = $moz->loc_name;
                                        ?>
                                        <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('lot_no')?></label>
                                <div class="col-sm-4">
                                     <select class="form-control lotselect" id="select" required name="lot_no">
                                    <option disabled selected><?php echo $this->lang->line('select_lot')?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                                
                            </div>
               
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text  control-label"><?php echo $this->lang->line('vill_town')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select_village')?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                </div>
                                
                            </div>                        
                     
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('dag_no')?></label>
                                <div class="col-sm-2"> 
                				<input type="text" class="form-control" name="dag_no" required value="0">
                                </div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 uni_text control-label">Case No.</label>
							 	<div class="col-sm-4">   
								<input type="text" class="form-control" name="caseno" required >
								<span class='small red'>Case Sensitive : like BON/BIT/2016-17/7/FMUT etc. </span>
							</div></div>
							
							<div class="form-group" align="right">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label">Select an Option</label>
                                <div class="col-sm-4" align="left">
                                    <select id="sl" class='form-control' required name="sl">
									<option >Select option Here</option>
                                    <option class="white" value="1">Sthalat TO Lagat</option>
                                    <option class="white" value="2">Lagat TO Sthalat</option>
                                   </select>
                                </div>
                            </div>        
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 uni_text control-label">Field/Office Mutation</label>
							 	<div class="col-sm-4">   
					  		 <input type="radio" name="m" value="1" onClick="opt1()" checked="checked"> <label style="font-size: 16px;color:blue;">Field Mutation</label>
							 <input type="radio" name="m" value="2" onClick="opt2()"> <label style="font-size: 16px;color:blue;">Office Mutation</label>						 
							</div>	
							<hr>
                        <div class="form-group">
                            <div class="col-sm-8 col-lg-offset-4" >
                                <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button')?></button>
                                <button id="MainIndex" class="btn uni_text btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_home')?></button>
                            </div>
                        </div>
						<?php if ($this->input->server('REQUEST_METHOD') == 'POST') 
								 { //First Braket
           							//$cdt=date("Y/m/d");
									//$cyr=date("Y");
									$dist_code = $this->input->post('dist_code');
									$subdiv_code = $this->input->post('subdiv_code');
									$circle_code = $this->input->post('circle_code');
									$mouza_code = $this->input->post('mouza_code');
									$lot_no = $this->input->post('lot_no');
									$vill_code = $this->input->post('vill_code');
									$OptValue=$this->input->post("txtopt");
									$DagNo=$this->input->post("dag_no");
									$CaseNo=$this->input->post("caseno");
									$SL=$this->input->post("sl"); //Sthalat-1 and Lagat-2
									if (is_numeric($OptValue)==FALSE) 
									{ 
									 echo "<p align=center><u><font size=4 color=red>ERROR...Found.</u></p>";
									}
									if (is_numeric($DagNo)==FALSE)
									{
									   echo "<p align=center><u><font size=4 color=red>DAG no should be Numeric.</font></u></p>";
									}
									/*if (is_numeric($OrderSlNo)==FALSE)
									{
									   echo "<p align=center><u><font size=4 color=red>Order Sl No should be Numeric.</font></u></p>";
									}*/
									if (is_numeric($SL)==FALSE || ($SL < 0 || $SL > 2))
									{
									  echo "<p align=center><u><font size=4 color=red>ERROR Found.</font></u></p>";
									}
									/* $culpritStrings = array("delete","insert","select","update","drop");
        $retStr = $str;
        for($i = 0; $i < count($culpritStrings);$i++) {
            if(strstr($culpritStrings[$i],$str))
                { 
					$Flag=0;
				}
				else
				{
					$Flag=1;
				}
        }
        return $Flag;*/
			//FOR FIELD MUTATION PART.............
			$q1 = "update chitha_col8_inplace SET inplaceof_alongwith= ? where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and   vill_townprt_code=? and dag_no= ? and col8order_cron_no=?  ";	
	$ch_q=	"update chitha_basic SET jama_yn =? where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and   vill_townprt_code=? and dag_no= ? ";				
			if ($OptValue==1) //First
			{ //For Filed Mutation
	$q2 = "select count(*) as c from chitha_col8_order where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no= ? and case_no=? ";
	$q22=$this->db->query("select col8order_cron_no from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no= '$DagNo' and case_no='$CaseNo' ");
			 $count = $this->db->query($q2, array($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo,$CaseNo))->row()->c;
			 if ($count < 1) //2nd if loop
			 {
			 	echo "<p align=center><u><font size=4 color=red>Record Not Found.</font></u></p>";
			 }
			 else
			 {
			     foreach ($q22->result() as $row)
					{  
						$orderslno=$row->col8order_cron_no;
						//echo "Order No" . $orderslno;
					}
			    if ($SL==1)
				    {
						$this->db->query($q1, array('a',$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo,$orderslno));
						$this->db->query($ch_q, array('',$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo));
					}
					else
					{
						$this->db->query($q1, array('i',$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo,$orderslno));
						$this->db->query($ch_q, array('',$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo));
					}
					echo "<p align=center><u><font size=4 color=red>RECORD UPDATED...</font></u></p>";
			 }
			}	 //end of 2nd IF loop    
			else  //Else for Office Mutation
			{
			$qOM = "select count(*) as c from chitha_rmk_ordbasic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no= ? and ord_no=? ";
			  $cnt = $this->db->query($qOM, array($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo,$CaseNo))->row()->c;
			  if ($cnt < 1) 
			 {
			 	echo "<p align=center><u><font size=4 color=red>Record Not Found.</font></u></p>";
			 }
			else
			 {
			      if ($SL==1) //Sthalat To Lagat
				    {
				$qOM1=$this->db->query("insert into chitha_rmk_alongwith(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,vill_townprt_code,dag_no,rmk_type_hist_no, ord_no, ord_date, ord_cron_no, alongwith_id , alongwith_name, alongwith_guardian, alongwith_rel_gur, user_code, date_entry, operation, alongwith_gender, alongwith_mother , pdar_id, striked_out) SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,vill_townprt_code,dag_no,rmk_type_hist_no, ord_no, ord_date, ord_cron_no, inplace_of_id, inplace_of_name, inplace_of_guardian, inplace_of_relation, user_code, date_entry, operation, inplace_of_gender, inplace_of_mother, pdar_id, striked_out FROM chitha_rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no= '$DagNo' and ord_no='$CaseNo' ");
				$qDel1=$this->db->query("DELETE FROM chitha_rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no= '$DagNo' and ord_no='$CaseNo' ");
				$this->db->query($ch_q, array('',$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo));
						
					}
					else //Lagat To Sthalat
					{
					$qOM2=$this->db->query("INSERT INTO chitha_rmk_inplace_of(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,vill_townprt_code,dag_no,rmk_type_hist_no, ord_no, ord_date, ord_cron_no, inplace_of_id , inplace_of_name, inplace_of_guardian, inplace_of_relation, user_code, date_entry, operation, inplace_of_gender, inplace_of_mother, pdar_id, striked_out) SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,vill_townprt_code,dag_no,rmk_type_hist_no, ord_no, ord_date, ord_cron_no, alongwith_id , alongwith_name, alongwith_guardian, alongwith_rel_gur, user_code, date_entry, operation, alongwith_gender, alongwith_mother , pdar_id, striked_out FROM chitha_rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no= '$DagNo' and ord_no='$CaseNo' ");
				$qDel2=$this->db->query("DELETE FROM chitha_rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no= '$DagNo' and ord_no='$CaseNo' ");
				$this->db->query($ch_q, array('',$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$DagNo));
				
					}
					echo "<p align=center><u><font size=4 color=red>RECORD UPDATED...</font></u></p>";
			   
			 }
			}  
          }	
		  //END OF FIELD MUTATION PART.								
		?>		
                        
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

