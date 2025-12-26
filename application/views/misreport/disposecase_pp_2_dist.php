<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
            <div class="alert alert-dismissible alert-warning"><h2 class="uni_text"><?php echo $this->lang->line('no_of_application_registered_disposed_pending_cases_during_this_period');?> <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></h2> </div>
            <?php  //var_dump($loc); 
             $i=0;
            // foreach($loc as $l){
            ?>
            <h4 class="text-danger center">Dist Name : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></h4>
            <table width="100%" class="table table-bordered table-hover" border="1">
                <tr>
                    <td style='background-color:#09314F;color: #fff' rowspan="3"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td style='background-color:#09314F;color: #fff' class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('mutation_type');?></div></td>
                    <td style='background-color:#09314F;color: #fff' class="alert-teal" colspan="8"><div align="center"><?php echo $this->lang->line('total_no_of_application_registered_disposed_pending');?></div></td>
                </tr>
                <tr>
                    <td  style="background:#FF4500; color: #fff; text-align: center"   colspan="4"><div align="center"> Cummulative since beginning to date :  <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center" colspan="4"><p align="center"><?php echo $this->lang->line('during_this_period');?></p>
                        <p align="center"> From <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> to  <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></p></td>
                </tr>
                <tr>
                    <td  style="background:#FF4500; color: #fff; text-align: center" ><div align="center"><?php echo $this->lang->line('registration');?></div></td>
                    <td style="background:#FF4500; color: #fff; text-align: center" ><div align="center"><?php echo $this->lang->line('orderpassed');?></div></td>
                    <td style="background:#FF4500; color: #fff; text-align: center" ><div align="center"><?php echo $this->lang->line('disposed');?></div></td>
                    <td style="background:#FF4500; color: #fff; text-align: center" ><div align="center"><?php echo $this->lang->line('pending');?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?> </td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                </tr>
                <tr class="active">
                    <td><div align="center">1</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_mutation');?></div></td>
                    <td><div align="center"><?php echo $fieldmut1[$i]['regomut1']  ; ?></div></td>
                      <td><div align="center"><?php echo $fieldmut1[$i]['deliverfmut1']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldmut1[$i]['disomut1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldmut1[$i]['penomut1']  ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $fieldmut[$i]['regomut']  ; ?></div></td>
                      <td><div align="center"><?php echo $fieldmut[$i]['deliverfmut']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $fieldmut[$i]['disomut']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldmut[$i]['penomut']  ; ?></span><br></div></td>
                </tr>
                <tr>
                    <td><div align="center">2</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_partition');?></div></td>
                    <td><div align="center"><?php echo $fieldpart1[$i]['regopart1']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart1[$i]['deliverfpart1'] ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart1[$i]['disopart1']; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldpart1[$i]['penopart1'] ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $fieldpart[$i]['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart[$i]['deliverfpart'] ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $fieldpart[$i]['disopart'] ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldpart[$i]['penopart']  ; ?></span><br></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">3</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_mutation');?></div></td>
                    <td><div align="center"><?php echo $officemut1[$i]['regomut1'] ; ?></div></td>
                    <td><div align="center"><?php echo $officemut1[$i]['delivermut1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut1[$i]['disomut1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officemut1[$i]['penomut1']  ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officemut[$i]['regomut']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut[$i]['delivermut'] ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officemut[$i]['disomut'] ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officemut[$i]['penomut']  ; ?></span><br></div></td>
                </tr>
                <tr>
                    <td><div align="center">4</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_partition');?></div></td>
                    <td><div align="center"><?php echo $officepart1[$i]['regopart1'] ; ?></div></td>
                    <td><div align="center"><?php echo $officepart1[$i]['deliverpart1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart1[$i]['disopart1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officepart1[$i]['penopart1'] ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officepart[$i]['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart[$i]['deliverpart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officepart[$i]['disopart']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officepart[$i]['penopart']  ; ?></span><br></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">5</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_conversion');?></div></td>
                    <td><div align="center"><?php echo $officecon1[$i]['regocon1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon1[$i]['delivercon1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon1[$i]['disocon1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officecon1[$i]['penocon1']  ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officecon[$i]['regocon']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon[$i]['delivercon']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officecon[$i]['disocon']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officecon[$i]['penocon']  ; ?></span><br></div></td>
                </tr>
				<tr>
                    <td><div align="center">6</div></td>
                    <td><div align="center">NR Case </div></td>
                    <td><div align="center"><?php echo $officeAP[$i]['regap'] ; ?></div></td>
                    <td><div align="center"><?php echo $officeAP[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeAP[$i]['disap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeAP[$i]['penap'] ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officeAP1[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeAP1[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officeAP1[$i]['disap']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeAP1[$i]['penap']  ; ?></span><br></div></td>
                </tr>
				<tr class="active">
                    <td><div align="center">7</div></td>
                    <td><div align="center">Reclassification</div></td>
                    <td><div align="center"><?php echo $officeReclass[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeReclass[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeReclass[$i]['disap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeReclass[$i]['penap']  ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officeReclass1[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeReclass1[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officeReclass1[$i]['disap']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeReclass1[$i]['penap']  ; ?></span><br></div></td>
                </tr>
				<tr>
                    <td><div align="center">8</div></td>
                    <td><div align="center">Citizen Centric Services</div></td>
                    <td><div align="center"><?php echo $officeCert[$i]['regap'] ; ?></div></td>
                    <td><div align="center"><?php echo $officeCert[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeCert[$i]['disap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeCert[$i]['penap'] ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officeCert1[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeCert1[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officeCert1[$i]['disap']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeCert1[$i]['penap']  ; ?></span><br></div></td>
                </tr>
				<tr class="active">
                    <td><div align="center">9</div></td>
                    <td><div align="center">Misc Case(Name Correction)</div></td>
                    <td><div align="center"><?php echo $officeMiscN[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeMiscN[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeMiscN[$i]['disap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeMiscN[$i]['penap']  ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officeMiscN1[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeMiscN1[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officeMiscN1[$i]['disap']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeMiscN1[$i]['penap']  ; ?></span><br></div></td>
                </tr>
				<tr >
                    <td><div align="center">10</div></td>
                    <td><div align="center">Misc Case(Name Deletion)</div></td>
                    <td><div align="center"><?php echo $officeMiscD[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeMiscD[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeMiscD[$i]['disap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeMiscD[$i]['penap']  ; ?></span><br></div></td>
                    <td><div align="center"><?php echo $officeMiscD1[$i]['regap']  ; ?></div></td>
                    <td><div align="center"><?php echo $officeMiscD1[$i]['deliverap']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officeMiscD1[$i]['disap']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officeMiscD1[$i]['penap']  ; ?></span><br></div></td>
                </tr>
            </table>
            
            <center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
			<a href='<?php echo base_url() ?>index.php/MisReport/DisposeForPPSubmitDCLAO' class='btn btn-success'>Show Circle Wise Breakup</a></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/DisposeForPPDCLAO'?>";
    };
</script>
