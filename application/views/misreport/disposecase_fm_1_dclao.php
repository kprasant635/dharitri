<div class="container-fluid login">
    <div class="row" >
        <div class="col-lg-12">
            <div class="alert alert-warning">
                <h2 class="uni_text"><?php echo $this->lang->line('no_of_disposed_and_pending_cases_for_more_tha_2_3_months'); ?></h2>
            </div>
        </div>
          
         <div class="col-sm-12" id ="data" >  
           
            <?php //var_dump($Fmut); 
            $i=0;
            foreach($loc  as $l){
            ?>
          <h4 class="text-danger center">Circle Name : <?php echo $l->loc_name; ?></h4>
            <table width="100%" class="table table-bordered" border="1">
                <tr>
                    <td class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td class="alert-teal"  rowspan="3"><div align="center"><?php echo $this->lang->line('mutation_type');?></div></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"  colspan="2"><div align="center"><?php echo $this->lang->line('orderpassed');?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center" colspan="2"><div align="center"><?php echo $this->lang->line('dispose_case');?></div></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"  colspan="2"><div align="center"><?php echo $this->lang->line('pending_case');?></div></td>
                    
                </tr>
                <tr>
                    <td style="background:#FF4500; color: #fff; text-align: center"  colspan="2"><div align="center"><?php echo $this->lang->line('time_taken_more_than');?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center" colspan="2"><div align="center"><?php echo $this->lang->line('time_taken_more_than');?></div></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"  colspan="2"><div align="center"><?php echo $this->lang->line('pending_more_than');?></div></td>
                </tr>
                <tr>
                    <td style="background:#FF4500; color: #fff; text-align: center"><div align="center">2 <?php echo $this->lang->line('month');?></div></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><div align="center">3 <?php echo $this->lang->line('month');?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><div align="center">2 <?php echo $this->lang->line('month');?></div></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><div align="center">3 <?php echo $this->lang->line('month');?></div></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"><div align="center">2 <?php echo $this->lang->line('month');?></div></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"><div align="center">3 <?php echo $this->lang->line('month');?></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">1</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_mutation');?></div></td>
                    <td><div align="center"><?php echo $Fmut[$i]['deliver_2'];?></div></td>
                     <td><div align="center"><?php echo $Fmut[$i]['deliver_3'];?></div></td>
                    <td><div align="center"><?php echo $Fmut[$i]['dispo_2'] ?></div></td>
                    <td><div align="center"><?php echo $Fmut[$i]['dispo_3'] ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Fmut[$i]['pen_2'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingcaseFieldPartTWO?type=01&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Fmut[$i]['pen_3'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingcaseFieldPart?type=01&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    
                </tr>
                <tr>
                    <td><div align="center">2</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_partition');?></div></td>
                    <td><div align="center"><?php echo $Fpart[$i]['deliver_2'] ?></div></td>
                    <td><div align="center"><?php echo $Fpart[$i]['deliver_3'] ?></div></td>
                    <td><div align="center"><?php echo $Fpart[$i]['dispo_2'] ?></div></td>
                    <td><div align="center"><?php echo $Fpart[$i]['dispo_3'] ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Fpart[$i]['pen_2'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingcaseFieldPartTWO?type=02&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Fpart[$i]['pen_3'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingcaseFieldPart?type=02&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">3</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_mutation');?></div></td>
                    <td><div align="center"><?php echo $Omut[$i]['deliver_2'] ?></div></td>
                    <td><div align="center"><?php echo $Omut[$i]['deliver_3'] ?></div></td>
                    <td><div align="center"><?php echo $Omut[$i]['dispo_2'] ?></div></td>
                    <td><div align="center"><?php echo $Omut[$i]['dispo_3'] ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Omut[$i]['pen_2'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseMnthtwo?type=03&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Omut[$i]['pen_3'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseMnththree?type=03&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr>
                    <td><div align="center">4</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_partition');?></div></td>
                     <td><div align="center"><?php echo $Opart[$i]['deliver_2'] ?></div></td>
                      <td><div align="center"><?php echo $Opart[$i]['deliver_3'] ?></div></td>
                    <td><div align="center"><?php echo $Opart[$i]['dispo_2'] ?></div></td>
                    <td><div align="center"><?php echo $Opart[$i]['dispo_3'] ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Opart[$i]['pen_2'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseMnthtwo?type=04&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $Opart[$i]['pen_3'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseMnththree?type=04&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">5</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_conversion');?></div></td>
                    <td><div align="center"><?php echo  $Ocon[$i]['deliver_2'] ?></div></td>
                    <td><div align="center"><?php echo  $Ocon[$i]['deliver_3'] ?></div></td>
                     <td><div align="center"><?php echo  $Ocon[$i]['dispo_2'] ?></div></td>
                    <td><div align="center"><?php echo  $Ocon[$i]['dispo_3'] ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo  $Ocon[$i]['pen_2'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseMnthtwo?type=01&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo  $Ocon[$i]['pen_3'] ?></span><br><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseMnththree?type=01&sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>" class="text-dec"><?php echo $this->lang->line('view');?></a></div></td>
                    </tr>
            </table>
            <?php 
            $i++;
            } ?>
          <center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button></center>
        </div>
    </div>
      
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/'?>";
    };
</script>
                        
