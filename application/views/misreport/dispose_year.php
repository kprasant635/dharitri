<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" style="overflow-x: scroll;table-layout: fixed" >  
            <?php //var_dump($this->session->all_userdata()); ?>
            <div class="alert alert-warning"><h2 class="uni_text">Yearly Penedency List</h2></div>
            <span class="label label-primary uni_text"><?php echo $this->lang->line('district');?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ; ?></span>
            <span class="label label-success uni_text"><?php echo $this->lang->line('subdivision');?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ; ?></span>
             <span class="label label-warning uni_text"><?php echo $this->lang->line('circle');?> :  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ; ?></span>
            <p><br></p>   
            <table width="100%" class="table table-bordered table-hover"   border="1">
             <tr>
                 <td width="10" rowspan="3"><div align="center"><?php echo $this->lang->line('year');?></div></td>
                <td class="alert-info" style="background:#FF4500; color: #fff; text-align: center"  colspan="4"> <?php echo $this->lang->line('office_mutation'); ?></td>
                    <td class="alert-info" style="background:#6B8E23; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('office_partition'); ?></td>
                    <td class="alert-info" style="background:#4682B4; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('office_conversion'); ?></td>
                    <td class="alert-success" style="background:#B22222; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('field_mutation'); ?></td>
                    <td class="alert-success" style="background:#556B2F; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('field_partition'); ?></td>
               
             </tr>
             <tr>
              <td colspan="4" style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#4682B4; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#B22222; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#556B2F; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
             </tr>
             <tr class="alert-warning active">
               <td style="background:#FF4500; color: #fff; text-align: center" ><?php echo $this->lang->line('registration'); ?> </td>
                    <td  style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?> </td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
              <td style="background:#FF4500; color: #fff; text-align: center" ><?php echo $this->lang->line('registration'); ?> </td>
                    <td  style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?> </td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center" ><?php echo $this->lang->line('registration'); ?> </td>
                    <td  style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    
              
               
             </tr>
             <tr>
                 <td class="alert-new"><div align="center">1</div></td>
               <td class="alert-new">2</td>
               <td class="alert-new">3</td>
               <td class="alert-new">4</td>
               <td class="alert-new">5</td>
               <td class="alert-new">6</td>
               <td  class="alert-new">7</td>
               <td class="alert-new">8</td>
               <td class="alert-new">9</td>
               <td class="alert-new">10</td>
               <td class="alert-new">11</td>
               <td class="alert-new">12</td>
               <td class="alert-new">13</td>
               <td class="alert-new">14</td>
               <td class="alert-new">15</td>
               <td class="alert-new">16</td>
               <td class="alert-new">17</td>
               <td class="alert-new">18</td>
               <td class="alert-new">19</td>
               <td class="alert-new">20</td>
               <td class="alert-new">21</td>
             
               
             </tr>
             <?php //var_dump($loc) ; 
             $i=0;
             foreach($loc as $l)
             {
             ?>
              <tr>
               <td><div align="center"><?php echo $l;  ?></div></td>
               <td><?php echo $omut[$i]->c ;?></td>
               <td><?php echo $omutfinal[$i]->c ?></td>
               <td><?php echo $omutdev[$i]->c ?></td>
               <td><span class="badge badge-danger"><?php echo $omutpen[$i]->c ?></span><br><a href="<?php echo base_url(); ?>index.php/MisReport/YearwiseListPart?year=<?php echo $l; ?>&mtype=03" class="text-dec"><?php echo $this->lang->line('view');?></a></td>
               <td><?php echo $opart[$i]->c ;?></td>
               <td><?php echo $opartfinal[$i]->c ;?></td>
               <td><?php echo $opartdev[$i]->c ?></td>
               <td><span class="badge badge-danger"><?php echo $opartpen[$i]->c ?></span><br><a href="<?php echo base_url(); ?>index.php/MisReport/YearwiseListPart?year=<?php echo $l; ?>&mtype=04" class="text-dec"><?php echo $this->lang->line('view');?></a></td>
               <td><?php echo $ocon[$i]->c ;?></td>
               <td><?php echo $oconfinal[$i]->c ;?></td>
               <td><?php echo $ocondev[$i]->c ?></td>
               <td><span class="badge badge-danger"><?php echo $oconpen[$i]->c ?></span><br><a href="<?php echo base_url(); ?>index.php/MisReport/YearwiseListPart?year=<?php echo $l; ?>&mtype=01" class="text-dec"><?php echo $this->lang->line('view');?></a></td>
               <td><?php echo $fmut[$i]->c ;?></td>
               <td><?php echo $fieldmuttfinal[$i]->c ;?></td>
               <td><?php echo $fmutdev[$i]->c ?></td>
               <td><span class="badge badge-danger"><?php echo $fmutpen[$i]->c ?></span><br><a href="<?php echo base_url(); ?>index.php/MisReport/YearwiseListField?year=<?php echo $l; ?>&mtype=01" class="text-dec"><?php echo $this->lang->line('view');?></a></td>
               <td><?php echo $fpart[$i]->c ;?></td>
                <td><?php echo $fieldpartfinal[$i]->c ;?></td>
               <td><?php echo $fpartdev[$i]->c ?></td>
               <td><span class="badge badge-danger"><?php echo $fpartpen[$i]->c ?></span><br><a href="<?php echo base_url(); ?>index.php/MisReport/YearwiseListField?year=<?php echo $l; ?>&mtype=02" class="text-dec"><?php echo $this->lang->line('view');?></a></td>
               
             </tr>
             <?php
             $i++;
             } ?>
             
           </table>
        </div>
        
        <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back');?></button></center>
</div>
</div>
<script type="text/javascript">
    function goBack() {
    window.history.back();
}

</script>