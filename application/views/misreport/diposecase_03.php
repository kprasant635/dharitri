<style type="text/css">
/*.headcol {
    background: #196f82 !important;
    color: #fff;
  position: absolute;
  width: 5em;
  left: 0;
  top: auto;
  border-top-width: 1px;
  /*only relevant for first row
  margin-top: -1px;
  /*compensate for top border*/
}
/*.headcol:before {
  content: 'Row ';
}*/

table {
  font-family: "Fraunces", serif;
  font-size: 125%;
  white-space: nowrap;
  margin: 0;
  border: none;
  border-collapse: separate;
  border-spacing: 0;
  table-layout: fixed;
  border: 1px solid black;
}
table td,
table th {
  border: 1px solid black;
  padding: 0.5rem 1rem;
}
table thead th {
  padding: 3px;
  position: sticky;
  top: 0;
  z-index: 1;
  width: 25vw;
  background: white;
}
table td {
  background: #fff;
  padding: 4px 5px;
  text-align: center;
}

table tbody th {
  font-weight: 100;
  font-style: italic;
  text-align: left;
  position: relative;
}
table thead th:first-child {
  position: sticky;
  left: 0;
  z-index: 2;
}
table tbody th {
  position: sticky;
  left: 0;
  background: white;
  z-index: 1;
}
</style>
<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12">  
            <?php
            //var_dump($this->session->all_userdata()); 
            //var_dump($locationData);
            ?>
            <div class="alert alert-warning"><h2 class="uni_text"><?php echo $this->lang->line('registered_disposed_pending_cases_of'); ?>  <font color="#0066FF"></font> At a Glance (<font color="#0066FF"><?php echo $this->lang->line('lot_wise'); ?></font>)</h2></div>
            <span class="label label-primary uni_text"><?php echo $this->lang->line('district'); ?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></span>
            <span class="label label-success uni_text"><?php echo $this->lang->line('subdivision'); ?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'), $locationData['subdiv_code']); ?></span>
            <span class="label label-warning uni_text"><?php echo $this->lang->line('circle'); ?> :  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'), $locationData['subdiv_code'], $locationData['cir_code']); ?></span>
            <span class="label label-info uni_text"><?php echo $this->lang->line('mouza'); ?> : <?php echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'), $locationData['subdiv_code'], $locationData['cir_code'], $locationData['mouza_pargona_code']); ?></span>
            <p><br></p>       
            <div class="table-responsive">
            <table width="100%" class="table table-bordered " style="background: #fff"  border="1">
                <tr>
                    <th width="40" rowspan="3" style="background:#196f82;color:#fff"><?php echo $this->lang->line('lot_no'); ?> / Lot Mondal's Name</th>
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
                    <td  rowspan="2" style="background:#FF6347; color: #fff; text-align: center"><?php echo $this->lang->line('village_wise_information'); ?></td>
                </tr>
                <tr>
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
                <tr class="alert-warning active" style="text-align: center">
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

                    <td  style="background:#FF6347; color: #fff; text-align: center"><?php echo $this->lang->line('village_wise_information'); ?></td>

                </tr>
                <tr style="text-align: center;background: #196f82;">
                    <th style="background:#196f82;color:#fff">1</th>
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
                    <td class="alert-new">46</td>
                </tr>
                <?php
                //var_dump($omut) ; 
                $i = 0;
                $tot_omut = 0; $tot_omutdev = 0; $tot_omutpen = 0; 
                $tot_opart = 0; $tot_opartdev = 0; $tot_opartpen = 0; 
                $tot_ocon = 0; $tot_ocondev = 0; $tot_oconpen = 0;
                $tot_fmut = 0; $tot_fmutdev = 0; $tot_fmutpen = 0;
                $tot_fpart = 0; $tot_fpartdev = 0; $tot_fpartpen = 0;
                $tot_omutfinal = 0; $tot_opartfinal = 0; $tot_oconvfinal = 0;
                $tot_fmut_final = 0; $tot_fpart_final = 0; $tot_nr = 0; $tot_nrdis = 0; $tot_nrpen = 0; 
                $tot_re = 0; $tot_redis = 0; $tot_repen = 0; $tot_mi = 0; $tot_midis = 0; $tot_mipen = 0; 
                $tot_nrfinal = 0; $tot_refinal = 0; $tot_mifinal = 0; $tot_acppfinal = 0; $tot_acpp = 0; 
                $tot_acppdis = 0; $tot_acpppen = 0; $tot_acppfinal=$totcomp=$totsettle=0;
                $tot_compdev=0;$tot_compdis=0;$tot_comppen=0;
                $tot_settledev=0;$tot_settledis=0;$tot_settlepen=0;
                foreach ($loc as $l) {
                    //var_dump($l);
                    ?>
                    <tr style="text-align: center">
                        <th style="background:#196f82;color:#fff"><small><kbd><?php
                                    echo "Lot-" . $l->lot_no . "</kbd></small>";
                                    $name = $this->utilityclass->EnabledMondalName($this->session->userdata('dist_code'), $l->subdiv_code, $l->cir_code, $l->mouza_pargona_code, $l->lot_no);
                                    echo "<br>";
                                    echo $name->lm_name;
                                    ?></th>
                                    <td><?php echo $omut[$i]->c; ?></td>
                                    <td><?php echo $omuttfinal[$i]->c; ?></td>
                                    <td><?php echo $omutdev[$i]->c ?></td>
                                    <td><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseOP_lot?sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>&mouza=<?php echo $l->mouza_pargona_code ?>&lot=<?php echo $l->lot_no; ?>&type=03" class="text-danger text-dec"><span class="badge  badge-danger"><?php echo $omutpen[$i]->c ?></span></a></td>
                                    <td><?php echo $opart[$i]->c; ?></td>
                                    <td><?php echo $opartfinal[$i]->c; ?></td>
                                    <td><?php echo $opartdev[$i]->c ?></td>
                                    <td><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseOP_lot?sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>&mouza=<?php echo $l->mouza_pargona_code ?>&lot=<?php echo $l->lot_no; ?>&type=04" class="text-danger text-dec"><span class="badge  badge-danger"><?php echo $opartpen[$i]->c ?></span></a></td>
                                    <td><?php echo $ocon[$i]->c; ?></td>
                                    <td><?php echo $oconfinal[$i]->c; ?></td>
                                    <td><?php echo $ocondev[$i]->c ?></td>
                                    <td><a href="<?php echo base_url() ?>index.php/MisReport/PendingCaseOP_lot?sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>&mouza=<?php echo $l->mouza_pargona_code ?>&lot=<?php echo $l->lot_no; ?>&type=01" class="text-danger text-dec"><span class="badge  badge-danger"><?php echo $oconpen[$i]->c ?></span></a></td>
                                    <td><?php echo $fmut[$i]->c; ?></td>
                                    <td><?php echo $fieldmuttfinal[$i]->c; ?></td>
                                    <td><?php echo $fmutdev[$i]->c ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/PendingcaseOfc_lot?sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>&mouza=<?php echo $l->mouza_pargona_code ?>&lot=<?php echo $l->lot_no; ?>&mtype=01" class="text-danger text-dec"><span class="badge  badge-danger"><?php echo $fmutpen[$i]->c ?></span></a></td>
                                    <td><?php echo $fpart[$i]->c; ?></td>
                                    <td><?php echo $fieldpartfinal[$i]->c; ?></td>
                                    <td><?php echo $fpartdev[$i]->c ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/PendingcaseOfc_lot?sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>&mouza=<?php echo $l->mouza_pargona_code ?>&lot=<?php echo $l->lot_no; ?>&mtype=02" class="text-danger text-dec"><span class="badge  badge-danger"><?php echo $fpartpen[$i]->c ?></span></a></td>

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
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeVillwise?sub=<?php echo $l->subdiv_code ?>&cir=<?php echo $l->cir_code ?>&mouza=<?php echo $l->mouza_pargona_code ?>&lot=<?php echo $l->lot_no; ?>" class="btn btn-warning"><?php echo $this->lang->line('view_details'); ?></a></td>
                                    </tr>
                                    <?php
                                    $tot_omutfinal = $tot_omutfinal + $omuttfinal[$i]->c;
                                    $tot_omut = $tot_omut + $omut[$i]->c;
                                    $tot_omutdev = $tot_omutdev + $omutdev[$i]->c;
                                    $tot_omutpen = $tot_omutpen + $omutpen[$i]->c;
                                    $tot_opart = $tot_opart + $opart[$i]->c;
                                    $tot_opartfinal = $tot_opartfinal + $opartfinal[$i]->c;
                                    $tot_opartdev = $tot_opartdev + $opartdev[$i]->c;
                                    $tot_opartpen = $tot_opartpen + $opartpen[$i]->c;

                                    $tot_ocon = $tot_ocon + $ocon[$i]->c;
                                    $tot_oconvfinal = $tot_oconvfinal + $oconfinal[$i]->c;
                                    $tot_ocondev = $tot_ocondev + $ocondev[$i]->c;
                                    $tot_oconpen = $tot_oconpen + $oconpen[$i]->c;

                                    $tot_fmut = $tot_fmut + $fmut[$i]->c;
                                    $tot_fmut_final = $tot_fmut_final + $fieldmuttfinal[$i]->c;
                                    $tot_fmutdev = $tot_fmutdev + $fmutdev[$i]->c;
                                    $tot_fmutpen = $tot_fmutpen + $fmutpen[$i]->c;

                                    $tot_fpart = $tot_fpart + $fpart[$i]->c;
                                    $tot_fpart_final = $tot_fpart_final + $fieldpartfinal[$i]->c;
                                    $tot_fpartdev = $tot_fpartdev + $fpartdev[$i]->c;
                                    $tot_fpartpen = $tot_fpartpen + $fpartpen[$i]->c;

                                    $tot_nrfinal = $tot_nrfinal + $nr_tot[$i]->c;
                                    $tot_nr = $tot_nr + $nr_dev[$i]->c;
                                    $tot_nrpen = $tot_nrpen + $nr_pen[$i]->c;
                                    $tot_nrdis = $tot_nrdis + $nr_dispose[$i]->c;

                                    $tot_refinal = $tot_refinal + $t_reclass_tot[$i]->c;
                                    $tot_re = $tot_re + $t_reclass_dev[$i]->c;
                                    $tot_repen = $tot_repen + $t_reclass_pen[$i]->c;
                                    $tot_redis = $tot_redis + $t_reclass_dispose[$i]->c;

                                    $tot_mifinal = $tot_mifinal + $misccase_tot[$i]->c;
                                    $tot_mi = $tot_mi + $misccase_dev[$i]->c;
                                    $tot_mipen = $tot_mipen + $misccase_pen[$i]->c;
                                    $tot_midis = $tot_midis + $misccase_dispose[$i]->c;


                                    $tot_refinal = $tot_refinal + $t_reclass_tot[$i]->c;
                                    $tot_re = $tot_re + $t_reclass_dev[$i]->c;
                                    $tot_repen = $tot_repen + $t_reclass_pen[$i]->c;
                                    $tot_redis = $tot_redis + $t_reclass_dispose[$i]->c;

                                    $tot_acppfinal = $tot_acppfinal + $actopp_tot[$i]->c;
                                    $tot_acpp = $tot_acpp + $actopp_dev[$i]->c;
                                    $tot_acpppen = $tot_acpppen + $actopp_pen[$i]->c;
                                    $tot_acppdis = $tot_acppdis + $actopp_dispose[$i]->c;

                                     $totcomp=$totcomp+$composite[$i]->total;
                                     $tot_compdev+=$composite[$i]->delivered;
                                     $tot_compdis+=$composite[$i]->disposed;
                                     $tot_comppen+=$composite[$i]->pending;

                                     $totsettle+=$settlement[$i]->total;
                                     $tot_settledev+=$settlement[$i]->passed;
                                     $tot_settledis+=$settlement[$i]->rejected;
                                     $tot_settlepen+=$settlement[$i]->pending;

                                    $i++;
                                }
                                ?>
                                <tr style="text-align: center;background: #196f82;">
                                    <th style="background:#196f82;color:#fff">Total </th>
                                    <td class="alert-new"><?php echo $tot_omut; ?></td>
                                    <td class="alert-new"><?php echo $tot_omutfinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_omutdev; ?></td>
                                    <td class="alert-new"><?php echo $tot_omutpen; ?></td>

                                    <td class="alert-new"><?php echo $tot_opart; ?></td>
                                    <td class="alert-new"><?php echo $tot_opartfinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_opartdev; ?></td>
                                    <td class="alert-new"><?php echo $tot_opartpen ?></td>

                                    <td class="alert-new"><?php echo $tot_ocon; ?></td>
                                    <td class="alert-new"><?php echo $tot_oconvfinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_ocondev; ?></td>

                                    <td class="alert-new"><?php echo $tot_oconpen; ?></td>

                                    <td class="alert-new"><?php echo $tot_fmut; ?></td>
                                    <td class="alert-new"><?php echo $tot_fmut_final; ?></td>
                                    <td class="alert-new"><?php echo $tot_fmutdev; ?></td>
                                    <td class="alert-new"><?php echo $tot_fmutpen; ?></td>

                                    <td class="alert-new"><?php echo $tot_fpart; ?></td>
                                    <td class="alert-new"><?php echo $tot_fpart_final; ?></td>
                                    <td class="alert-new"><?php echo $tot_fpartdev; ?></td>
                                    <td class="alert-new"><?php echo $tot_fpartpen; ?></td>

                                    <td class="alert-new"><?php echo $tot_nrfinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_nr; ?></td>
                                    <td class="alert-new"><?php echo $tot_nrdis; ?></td>
                                    <td class="alert-new"><?php echo $tot_nrpen; ?></td>

                                    <td class="alert-new"><?php echo $tot_mifinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_mi; ?></td>
                                    <td class="alert-new"><?php echo $tot_midis; ?></td>
                                    <td class="alert-new"><?php echo $tot_mipen; ?></td>


                                    <td class="alert-new"><?php echo $tot_refinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_re; ?></td>
                                    <td class="alert-new"><?php echo $tot_redis; ?></td>
                                    <td class="alert-new"><?php echo $tot_repen; ?></td>


                                    <td class="alert-new"><?php echo $tot_acppfinal; ?></td>
                                    <td class="alert-new"><?php echo $tot_acpp; ?></td>
                                    <td class="alert-new"><?php echo $tot_acppdis; ?></td>
                                    <td class="alert-new"><?php echo $tot_acpppen; ?></td>

                                    <td class="alert-new"><?php echo $totsettle ;?></td>
                                   <td class="alert-new"><?php echo $tot_settledev ;?></td>
                                   <td class="alert-new"><?php echo $tot_settledis ; ?></td>
                                   <td class="alert-new"><?php echo $tot_settlepen ; ?></td>
                                   
                                    <td class="alert-new"><?php echo $totcomp ;?></td>
                                   <td class="alert-new"><?php echo $tot_compdev ;?></td>
                                   <td class="alert-new"><?php echo $tot_compdis ; ?></td>
                                   <td class="alert-new"><?php echo $tot_comppen ; ?></td>
                                    <td class="alert-new">--</td>

                                </tr>
                                </table>
                            </div>
                                <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back'); ?></button></center>
                                </div>
                                </div>
                                </div>
                                <script type="text/javascript">
                                    function goBack() {
                                        window.history.back();
                                    }

                                </script>
