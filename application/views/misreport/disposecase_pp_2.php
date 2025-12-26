<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
            <div class="alert alert-dismissible alert-warning"><h2 class="uni_text"><?php echo $this->lang->line('no_of_application_registered_disposed_pending_cases_during_this_period');?> <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></h2> </div>
            <?php //echo var_dump($officepart); ?>
            <table width="100%" class="table table-bordered table-hover" border="1">
                <tr>
                    <td class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('mutation_type');?></div></td>
                    <td class="alert-teal" colspan="8"><div align="center"><?php echo $this->lang->line('total_no_of_application_registered_disposed_pending');?></div></td>
                </tr>
                <tr>
                    <td  style="background:#FF4500; color: #fff; text-align: center"   colspan="4"><div align="center"><?php echo $this->lang->line('to');?> <?php echo date('d-m-Y'); ?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center" colspan="4"><p align="center"><?php echo $this->lang->line('during_this_period');?></p>
                        <p align="center"><?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> ><?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></p></td>
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
                    <td><div align="center"><?php echo $fieldmut1['regomut1']  ; ?></div></td>
                      <td><div align="center"><?php echo $fieldmut1['deliverfmut1']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldmut1['disomut1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldmut1['penomut1']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/FieldPendingCase?type=01" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><?php echo $fieldmut['regomut']  ; ?></div></td>
                      <td><div align="center"><?php echo $fieldmut['deliverfmut']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $fieldmut['disomut']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldmut['penomut']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/FieldPendingCasePPEdate?type=01" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr>
                    <td><div align="center">2</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_partition');?></div></td>
                    <td><div align="center"><?php echo $fieldpart1['regopart1']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart1['deliverfpart1']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart1['disopart1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldpart1['penopart1']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/FieldPendingCase?type=02" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><?php echo $fieldpart['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart['deliverfpart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $fieldpart['disopart']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldpart['penopart']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/FieldPendingCasePPEdate?type=02" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">3</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_mutation');?></div></td>
                    <td><div align="center"><?php echo $officemut1['regomut1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut1['delivermut1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut1['disomut1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officemut1['penomut1']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCasePPEdate?type=03" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><?php echo $officemut['regomut']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut['delivermut']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officemut['disomut']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officemut['penomut']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCasePP?type=03" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr>
                    <td><div align="center">4</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_partition');?></div></td>
                    <td><div align="center"><?php echo $officepart1['regopart1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart1['deliverpart1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart1['disopart1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officepart1['penopart1']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCasePPEdate?type=04" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><?php echo $officepart['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart['deliverpart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officepart['disopart']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officepart['penopart']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCasePP?type=04" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">5</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_conversion');?></div></td>
                    <td><div align="center"><?php echo $officecon1['regocon1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon1['delivercon1']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon1['disocon1']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officecon1['penocon1']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCasePPEdate?type=01" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><?php echo $officecon['regocon']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon['delivercon']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-info"><?php echo $officecon['disocon']  ; ?></span></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officecon['penocon']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCasePP?type=01" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>

            </table>
			<center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/DisposeForPP'?>";
    };
</script>
