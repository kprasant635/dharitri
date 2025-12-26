<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" style="overflow-x: scroll;table-layout: fixed" >  
            <?php //var_dump($locationData); ?>
            <div class="alert alert-warning"><h2 class="uni_text"><?php echo $this->lang->line('registered_disposed_pending_cases_of'); ?>   At a Glance (<font color="#0066FF"><?php echo $this->lang->line('village_wise'); ?></font>)</h2></div>
            <span class="label label-primary uni_text"><?php echo $this->lang->line('district'); ?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></span>
            <span class="label label-success uni_text"><?php echo $this->lang->line('subdivision'); ?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'), $locationData['subdiv_code']); ?></span>
            <span class="label label-warning uni_text"><?php echo $this->lang->line('circle'); ?> :  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'), $locationData['subdiv_code'], $locationData['cir_code']); ?></span>
            <span class="label label-info uni_text"><?php echo $this->lang->line('mouza'); ?> : <?php echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'), $locationData['subdiv_code'], $locationData['cir_code'], $locationData['mouza_code']); ?></span>
            <span class="label label-default uni_text"> <?php echo $this->lang->line('lot_no'); ?> : <?php echo $locationData['lot_no'] ?></span> 
            <p><br></p>     
            <table width="100%" class="table-bordered table" border="1" style="background: #fff">
                <tr>
                    <td width="63">&nbsp;</td>
                    <td class="alert-info" style="background:#FF4500; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('office_mutation'); ?></td>
                    <td class="alert-info" style="background:#6B8E23; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('office_partition'); ?></td>
                    <td class="alert-info" style="background:#4682B4; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('office_conversion'); ?></td>
                    <td class="alert-success" style="background:#B22222; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('field_mutation'); ?></td>
                    <td class="alert-success" style="background:#556B2F; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('field_partition'); ?></td>
                    <td class="alert-success" style="background:#1F618D; color: #fff; text-align: center" colspan="4">NR Case</td>
                     <td class="alert-success" style="background:#D4AC0D; color: #fff; text-align: center" colspan="4">Misc Case</td>
                     <td class="alert-success" style="background:#C0392B; color: #fff; text-align: center" colspan="4">Reclassification</td>

                     <td class="alert-success" style="background:#684597; color: #fff; text-align: center" colspan="4">AC to PP</td>
                     <td class="alert-success" style="background:#033E3E; color: #fff; text-align: center" colspan="4">Settlement</td>
                        <td class="alert-success" style="background:#9E4638; color: #fff; text-align: center" colspan="4">Composite</td>
               </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#4682B4; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#B22222; color: #fff; text-align: center"><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#556B2F; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                     <td colspan="4" style="background:#1F618D; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#D4AC0D; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#C0392B; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#684597; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#033E3E; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#9E4638; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                </tr>
                <tr class="">
                    <td ><div align="center"><?php echo $this->lang->line('vill_town'); ?></div></td>
                    <td style="background:#FF4500; color: #fff; text-align: center" > <?php echo $this->lang->line('registration'); ?> </td>
                    <td  style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#FF4500; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?> </td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                    <td style="background:#4682B4; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#4682B4; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                    <td style="background:#B22222; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                    <td style="background:#B22222; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#B22222; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#B22222; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                    <td style="background:#556B2F; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                    <td style="background:#556B2F; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#556B2F; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#556B2F; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    
                    <td style="background:#1F618D; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                 <td style="background:#1F618D; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                 <td style="background:#1F618D; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                 <td style="background:#1F618D; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                 <td style="background:#D4AC0D; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                 <td style="background:#D4AC0D; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                 <td style="background:#D4AC0D; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                 <td style="background:#D4AC0D; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                 <td style="background:#C0392B; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                 <td style="background:#C0392B; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                 <td style="background:#C0392B; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                 <td style="background:#C0392B; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                 <td style="background:#684597; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                 <td style="background:#684597; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                 <td style="background:#684597; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                 <td style="background:#684597; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                 <td style="background:#033E3E; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                <td style="background:#033E3E; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                <td style="background:#033E3E; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                <td style="background:#033E3E; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>

                <td style="background:#9E4638; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?></td>
                <td style="background:#9E4638; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                <td style="background:#9E4638; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                <td style="background:#9E4638; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                    
                </tr>

                <tr>
                    <td class="alert-new"><div align="center">1</div></td>
                    <td class="alert-new"><div align="center">2</div></td>
                    <td class="alert-new"><div align="center">3</div></td>
                    <td class="alert-new"><div align="center">4</div></td>
                    <td class="alert-new"><div align="center">5</div></td>
                    <td class="alert-new"><div align="center">6</div></td>
                    <td class="alert-new"><div align="center">7</div></td>
                    <td class="alert-new"><div align="center">8</div></td>
                    <td class="alert-new"><div align="center">9</div></td>
                    <td class="alert-new"><div align="center">10</div></td>
                    <td class="alert-new"><div align="center">11</div></td>
                    <td class="alert-new"><div align="center">12</div></td>
                    <td class="alert-new"><div align="center">13</div></td>
                    <td class="alert-new"><div align="center">14</div></td>
                    <td class="alert-new"><div align="center">15</div></td>
                    <td class="alert-new"><div align="center">16</div></td>
                    <td class="alert-new"><div align="center">17</div></td>
                    <td class="alert-new"><div align="center">18</div></td>
                    <td class="alert-new"><div align="center">19</div></td>
                    <td class="alert-new">20</td>
                    <td class="alert-new">21</td>
                    <td class="alert-new">22</td>
                    <td class="alert-new">23</td>
                    <td class="alert-new">24</td>
                    <td class="alert-new">25</td>
                    <td class="alert-new">26</td>
                    <td class="alert-new">27</td>
                    <td class="alert-new">28</td>
                    <td class="alert-new">29</td>
                    <td class="alert-new">30</td>
                    <td class="alert-new">31</td>
                    <td class="alert-new">32</td>
                    <td class="alert-new">33</td>
                    <td class="alert-new">34</td>
                    <td class="alert-new">35</td>
                    <td class="alert-new">36</td>
                    <td class="alert-new">37</td>
                    <td class="alert-new">38</td>
                    <td class="alert-new">39</td>
                    <td class="alert-new">40</td>
                    <td class="alert-new">41</td>
                    <td class="alert-new">42</td>
                    <td class="alert-new">43</td>
                    <td class="alert-new">44</td>
                    <td class="alert-new">45</td>
                </tr>
                    <?php //var_dump($omut) ; 
                        $i=0;
                        $j=1;
                        foreach($loc as $l)
                        {
                        ?>
                         <tr>
                             <td><div align="center"><?php echo $j.")&nbsp".$l->loc_name  ; ?></div></td>
                             <td><div align="center"><?php echo $omut[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $omutfinal[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $omutdev[$i]->c ?></div></td>
                             <td><div align="center"><a href="<?php echo base_url(); ?>index.php/MisReport/PendingCaseVill?sub=<?php echo $locationData['subdiv_code'] ?>&cir=<?php echo $locationData['cir_code'] ?>&mouza=<?php echo $locationData['mouza_code'] ?>&lot=<?php echo $locationData['lot_no'] ?>&vill=<?php echo $l->vill_townprt_code; ?>&type=03" ><span class="badge badge-danger"><?php echo $omutpen[$i]->c ?></a></span></div></td>
                             
                             <td><div align="center"><?php echo $opart[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $opartfinal[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $opartdev[$i]->c ?></div></td>
                             <td><div align="center"><a href="<?php echo base_url(); ?>index.php/MisReport/PendingCaseVill?sub=<?php echo $locationData['subdiv_code'] ?>&cir=<?php echo $locationData['cir_code'] ?>&mouza=<?php echo $locationData['mouza_code'] ?>&lot=<?php echo $locationData['lot_no'] ?>&vill=<?php echo $l->vill_townprt_code; ?>&type=04" class="text-danger"><span class="badge badge-danger"><?php echo $opartpen[$i]->c ?></span></a></div></td>
                             
                             <td><div align="center"><?php echo $ocon[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $oconfinal[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $ocondev[$i]->c ?></div></td>
                             <td><div align="center"><a href="<?php echo base_url(); ?>index.php/MisReport/PendingCaseVill?sub=<?php echo $locationData['subdiv_code'] ?>&cir=<?php echo $locationData['cir_code'] ?>&mouza=<?php echo $locationData['mouza_code'] ?>&lot=<?php echo $locationData['lot_no'] ?>&vill=<?php echo $l->vill_townprt_code; ?>&type=01" class="text-danger"><span class="badge badge-danger"><?php echo $oconpen[$i]->c ?></span></a></div></td>
                             
                             
                             <td><div align="center"><?php echo $fmut[$i]->c ;?></div></td>
                              <td><div align="center"><?php echo $fieldmutfinal[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $fmutdev[$i]->c ?></div></td>
                             <td><div align="center"><a href="<?php echo base_url(); ?>index.php/MisReport/PendingCaseVillField?sub=<?php echo $locationData['subdiv_code'] ?>&cir=<?php echo $locationData['cir_code'] ?>&mouza=<?php echo $locationData['mouza_code'] ?>&lot=<?php echo $locationData['lot_no'] ?>&vill=<?php echo $l->vill_townprt_code; ?>&type=01" class="text-danger"><span class="badge badge-danger"><?php echo $fmutpen[$i]->c ?></span></a></div></td>
                             
                             <td><div align="center"><?php echo $fpart[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $fieldpartfinal[$i]->c ;?></div></td>
                             <td><div align="center"><?php echo $fpartdev[$i]->c ?></div></td>
                             <td><div align="center"><a href="<?php echo base_url(); ?>index.php/MisReport/PendingCaseVillField?sub=<?php echo $locationData['subdiv_code'] ?>&cir=<?php echo $locationData['cir_code'] ?>&mouza=<?php echo $locationData['mouza_code'] ?>&lot=<?php echo $locationData['lot_no'] ?>&vill=<?php echo $l->vill_townprt_code; ?>&type=02" class="text-danger"><span class="badge badge-danger"><?php echo $fpartpen[$i]->c ?></span></a></div></td>
                             
                              <td><?php echo $nr_tot[$i]->c ?></td>
                                <td><?php echo $nr_dev[$i]->c ?></td>
                                <td><?php echo $nr_dispose[$i]->c ?></td>
                                <td><?php echo $nr_pen[$i]->c ?></td>

                                <td><?php echo $misccase_tot[$i]->c ?></td>
                                <td><?php echo $misccase_dev[$i]->c ?></td>
                                <td><?php echo $misccase_dispose[$i]->c ?></td>
                                <td><?php echo $misccase_pen[$i]->c ?></td>

                                <td><?php echo $t_reclass_tot[$i]->c ?></td>
                                <td><?php echo $t_reclass_dev[$i]->c ?></td>
                                <td><?php echo $t_reclass_dispose[$i]->c ?></td>
                                <td><?php echo $t_reclass_pen[$i]->c ?></td>

                                <td><?php echo $actopp_tot[$i]->c ?></td>
                                <td><?php echo $actopp_dev[$i]->c ?></td>
                                <td><?php echo $actopp_dispose[$i]->c ?></td>
                                <td><?php echo $actopp_pen[$i]->c ?></td>
                                
                                <td><?php echo $settlement[$i]->total ?></td>
                                <td><?php echo $settlement[$i]->passed ?></td>
                                <td><?php echo $settlement[$i]->rejected ?></td>
                                <td><?php echo $settlement[$i]->pending ?></td>
                                
                                <td><?php echo $composite[$i]->total ?></td>
                                <td><?php echo $composite[$i]->delivered ?></td>
                                <td><?php echo $composite[$i]->disposed ?></td>
                                <td><?php echo $composite[$i]->pending ?></td>
                             
                        </tr>
                        <?php
                         $i++;$j++;
                        } ?>
                </table>
             <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back');?></button></center>
        </div>
</div>
</div>
<script type="text/javascript">
    function goBack() {
    window.history.back();
}

</script>
