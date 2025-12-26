<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" > 
            <table width="100%"  class="example table table-bordered table-hover" border="1">
                <thead>
				<tr>
                    <td class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td class="alert-teal" rowspan="3"><div align="center">
					District : <?=$this->utilityclass->getDistrictName($location['dist_code'])?> Circle : <?php echo $this->utilityclass->getCircleName($location['dist_code'],$location['subdiv_code'],$location['cir_code']); ?> <br>
					</div></td>
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
				
				</thead>
				<tbody>
                <?php $i=1; foreach($data as $row){ ?>
                <tr class="active">
                    <td><div align="center"><?=$i++?></div></td>
                    <td><div align="center"><?=$row['type']?></div></td>
                    <td><div align="center"><?=$row['certRegT']?></div></td>
                    <td><div align="center"><?=$row['certDelvT']?></div></td>
                    <td><div align="center"><?=$row['certRejT']?></div></td> 
                    <td><div align="center"><?=$row['certPenT']?></div></td>
                    <td><div align="center"><?=$row['certReg']?></div></td>
                    <td><div align="center"><?=$row['certDelv']?></div></td>
                    <td><div align="center"><?=$row['certRej']?></div></td> 
                    <td><div align="center"><?=$row['certPen']?></div></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;Back To Main Menu</button></center>
    </div>
</div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/DisposeForPPSubmitdist'?>"; //DisposeForPPSubmitdist
    };
</script>