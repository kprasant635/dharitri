<div class="container-fluid login">
    <div class="row">
        <div class="col-lg-12" >
            <div class="alert alert-warning"><h2 class="uni_text center"><?php echo $this->lang->line('registered_disposed_pending_cases_of'); ?>
                    <font color="#0066FF"><?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></font> 
                    District- At a Glance (<font color="#0066FF"><?php echo $this->lang->line('circle_wise'); ?></font>)</h2></div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px; overflow-x: scroll;table-layout: fixed;" id="data" >
        <div class="col-lg-12" >  
            <span class="label label-primary uni_text"><?php echo $this->lang->line('district'); ?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></span>
            <span class="label label-success uni_text hide"><?php echo $this->lang->line('subdivision'); ?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code')); ?></span>
            <p><br></p>   
            <table class="table table-responsive table-bordered" style="overflow-x: scroll;background: #fff"   border="1">
                <tr>
                    <td rowspan="3"><?php echo $this->lang->line('circle'); ?></td>
                    <td class="alert-info" style="background:#FF4500; color: #fff; text-align: center"  colspan="4"> <?php echo $this->lang->line('office_mutation'); ?></td>
                    <td class="alert-info" style="background:#6B8E23; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('office_partition'); ?></td>
                    <td class="alert-info" style="background:#4682B4; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('office_conversion'); ?></td>
                    <td class="alert-success" style="background:#B22222; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('field_mutation'); ?></td>
                    <td class="alert-success" style="background:#556B2F; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('field_partition'); ?></td>
                    <td class="alert-success" style="background:#1F618D; color: #fff; text-align: center" colspan="4">NR Case</td>
                    <td class="alert-success" style="background:#D4AC0D; color: #fff; text-align: center" colspan="4">Misc Case</td>
                    <td class="alert-success" style="background:#C0392B; color: #fff; text-align: center" colspan="4">Reclassification</td>
                    <td colspan="2" style="background:#FF6347; color: #fff; text-align: center"  rowspan="2"><?php echo $this->lang->line('get_information'); ?></td>
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

                    <td style="background:#FF6347; color: #fff; text-align: center"><?php echo $this->lang->line('mouza_wise'); ?></td>
                    <td style="background:#FF6347; color: #fff; text-align: center"><?php echo $this->lang->line('year_wise'); ?></td>
                </tr>
                <tr style="text-align: center">
                    <td class="alert-new">1</td>
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
                </tr>
                <?php
                //var_dump($loc) ;
                $omut_tot = 0;
                $omutfinal_tot = 0;
                $omutdev_tot = 0;
                $omutpen_tot = 0;
                $opart_tot = 0;
                $opartfinal_tot = 0;
                $opartdev_tot = 0;
                $opartpen_tot = 0;
                $ocon_tot = 0;
                $oconfinal_tot = 0;
                $ocondev_tot = 0;
                $oconpen_tot = 0;
                $ofcmut_tot = 0;
                $ofcmutfinal_tot = 0;
                $ofcmutdev_tot = 0;
                $ofcmutpen_tot = 0;
                $fpart_tot = 0;
                $fpartfinal_tot = 0;
                $fpartdev_tot = 0;
                $fpartpen_tot = 0;
                $nr_tot_tot = 0;
                $nr_dev_tot = 0;
                $nr_dispose_tot = 0;
                $nr_pen_tot = 0;
                $misccase_tot_tot = 0;
                $misccase_dev_tot = 0;
                $misccase_dispose_tot = 0;
                $misccase_pen_tot = 0;
                $t_reclass_tot_tot = 0;
                $t_reclass_dev_tot = 0;
                $t_reclass_dispose_tot = 0;
                $t_reclass_pen_tot = 0;
                $i = 0;
                foreach ($loc as $l) {
                    ?>
                    <tr style="text-align: center">
                        <td><?php echo $loc[$i]->loc_name; ?></td>
                        <td><?php
                            echo $omut[$i]->c;
                            $omut_tot = $omut_tot + $omut[$i]->c;
                            ?></td>
                        <td><?php
                            echo $omutfinal[$i]->c;
                            $omutfinal_tot = $omutfinal_tot + $omutfinal[$i]->c;
                            ?></td>
                        <td><?php
                        echo $omutdev[$i]->c;
                        $omutdev_tot = $omutdev_tot + $omutdev[$i]->c;
                            ?></td>
                        <td><?php
                        echo $omutpen[$i]->c;
                        $omutpen_tot = $omutpen_tot + $omutpen[$i]->c;
                            ?></td>
                        <td ><?php
                        echo $opart[$i]->c;
                        $opart_tot = $opart_tot + $opart[$i]->c;
                            ?></td>
                        <td ><?php
                            echo $opartfinal[$i]->c;
                            $opartfinal_tot = $opartfinal_tot + $opartfinal[$i]->c;
                            ?></td>
                        <td ><?php
                            echo $opartdev[$i]->c;
                            $opartdev_tot = $opartdev_tot + $opartdev[$i]->c;
                            ?></td>
                        <td ><?php
                            echo $opartpen[$i]->c;
                            $opartpen_tot = $opartpen_tot + $opartpen[$i]->c;
                            ?></td>

                        <td><?php
                            echo $ocon[$i]->c;
                            $ocon_tot = $ocon_tot + $ocon[$i]->c;
                            ?></td>
                        <td><?php
                            echo $oconfinal[$i]->c;
                            $oconfinal_tot = $oconfinal_tot + $oconfinal[$i]->c;
                            ?></td>
                        <td><?php
                            echo $ocondev[$i]->c;
                            $ocondev_tot = $ocondev_tot + $ocondev[$i]->c;
                            ?></td>
                        <td><?php
                            echo $oconpen[$i]->c;
                            $oconpen_tot = $oconpen_tot + $oconpen[$i]->c;
                            ?></td>


                        <td><?php
                            echo $ofcmut[$i]->c;
                            $ofcmut_tot = $ofcmut_tot + $ofcmut[$i]->c;
                            ?></td>
                        <td><?php
                            echo $ofcmutfinal[$i]->c;
                            $ofcmutfinal_tot = $ofcmutfinal_tot + $ofcmutfinal[$i]->c;
                            ?></td>
                        <td><?php
                        echo $ofcmutdev[$i]->c;
                        $ofcmutdev_tot = $ofcmutdev_tot + $ofcmutdev[$i]->c;
                            ?></td>
                        <td><?php
                            echo $ofcmutpen[$i]->c;
                            $ofcmutpen_tot = $ofcmutpen_tot + $ofcmutpen[$i]->c;
                            ?></td>


                        <td><?php
                            echo $fpart[$i]->c;
                            $fpart_tot = $fpart_tot + $fpart[$i]->c;
                            ?></td>
                        <td><?php
                            echo $fpartfinal[$i]->c;
                            $fpartfinal_tot = $fpartfinal_tot + $fpartfinal[$i]->c;
                            ?></td>
                        <td><?php
                            echo $fpartdev[$i]->c;
                            $fpartdev_tot = $fpartdev_tot + $fpartdev[$i]->c;
                            ?></td>
                        <td><?php
                            echo $fpartpen[$i]->c;
                            $fpartpen_tot = $fpartpen_tot + $fpartpen[$i]->c;
                            ?></td>

                        <td><?php
                echo $nr_tot[$i]->c;
                $nr_tot_tot = $nr_tot_tot + $nr_tot[$i]->c;
                ?></td>
                        <td><?php
                echo $nr_dev[$i]->c;
                $nr_dev_tot = $nr_dev_tot + $nr_dev[$i]->c;
                ?></td>
                        <td><?php
                echo $nr_dispose[$i]->c;
                $nr_dispose_tot = $nr_dispose_tot + $nr_dispose[$i]->c;
                ?></td>
                        <td><?php
                echo $nr_pen[$i]->c;
                $nr_pen_tot = $nr_pen_tot + $nr_pen[$i]->c;
                ?></td>

                        <td><?php
                echo $misccase_tot[$i]->c;
                $misccase_tot_tot = $misccase_tot_tot + $misccase_tot[$i]->c;
                ?></td>
                        <td><?php
                echo $misccase_dev[$i]->c;
                $misccase_dev_tot = $misccase_dev_tot + $misccase_dev[$i]->c;
                ?></td>
                        <td><?php
                echo $misccase_dispose[$i]->c;
                $misccase_dispose_tot = $misccase_dispose_tot + $misccase_dispose[$i]->c;
                ?></td>
                        <td><?php
                echo $misccase_pen[$i]->c;
                $misccase_pen_tot = $misccase_pen_tot + $misccase_pen[$i]->c;
                ?></td>

                        <td><?php
                echo $t_reclass_tot[$i]->c;
                $t_reclass_tot_tot = $t_reclass_tot_tot + $t_reclass_tot[$i]->c;
                ?></td>
                        <td><?php
                echo $t_reclass_dev[$i]->c;
                $t_reclass_dev_tot = $t_reclass_dev_tot + $t_reclass_dev[$i]->c;
                ?></td>
                        <td><?php
                echo $t_reclass_dispose[$i]->c;
                $t_reclass_dispose_tot = $t_reclass_dispose_tot + $t_reclass_dispose[$i]->c;
                ?></td>
                        <td><?php
                echo $t_reclass_pen[$i]->c;
                $t_reclass_pen_tot = $t_reclass_pen_tot + $t_reclass_pen[$i]->c;
                ?></td>

                        <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeMouzawise_dclao?subdiv_code=<?php echo $loc[$i]->subdiv_code ?>&cir_code=<?php echo $loc[$i]->cir_code; ?>" class="btn btn-warning"><?php echo $this->lang->line('view'); ?></a></td>
                        <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeYearwise_dclao?subdiv_code=<?php echo $loc[$i]->subdiv_code ?>&cir_code=<?php echo $loc[$i]->cir_code; ?>" class="btn btn-danger"><?php echo $this->lang->line('view'); ?></a></td>
                    </tr>
    <?php
    $i++;
}
?>
                <tr style="text-align: center">
                    <td class="alert-new">Total </td>
                    <td class="alert-new"><?php echo $omut_tot; ?></td>
                    <td class="alert-new"><?php echo $omutfinal_tot ?></td>
                    <td class="alert-new"><?php echo $omutdev_tot ?></td>
                    <td class="alert-new"><?php echo $omutpen_tot ?></td>

                    <td class="alert-new"><?php echo $opart_tot; ?></td>
                    <td class="alert-new"><?php echo $opartfinal_tot ?></td>
                    <td class="alert-new"><?php echo $opartdev_tot ?></td>
                    <td class="alert-new"><?php echo $opartpen_tot ?></td>


                    <td class="alert-new"><?php echo $ocon_tot; ?></td>
                    <td class="alert-new"><?php echo $oconfinal_tot ?></td>
                    <td class="alert-new"><?php echo $ocondev_tot ?></td>
                    <td class="alert-new"><?php echo $oconpen_tot ?></td>

                    <td class="alert-new"><?php echo $ofcmut_tot; ?></td>
                    <td class="alert-new"><?php echo $ofcmutfinal_tot ?></td>
                    <td class="alert-new"><?php echo $ofcmutdev_tot; ?></td>
                    <td class="alert-new"><?php echo $ofcmutpen_tot ?></td>

                    <td class="alert-new"><?php echo $fpart_tot ?></td>
                    <td class="alert-new"><?php echo $fpartfinal_tot ?></td>
                    <td class="alert-new"><?php echo $fpartdev_tot ?></td>
                    <td class="alert-new"><?php echo $fpartpen_tot ?></td>

                    <td class="alert-new"><?php echo $nr_tot_tot ?></td>
                    <td class="alert-new"><?php echo $nr_dev_tot ?></td>
                    <td class="alert-new"><?php echo $nr_dispose_tot ?></td>
                    <td class="alert-new"><?php echo $nr_pen_tot ?></td>

                    <td class="alert-new"><?php echo $misccase_tot_tot ?></td>
                    <td class="alert-new"><?php echo $misccase_dev_tot ?></td>
                    <td class="alert-new"><?php echo $misccase_dispose_tot ?></td>
                    <td class="alert-new"><?php echo $misccase_pen_tot ?></td>

                    <td class="alert-new"><?php echo $t_reclass_tot_tot ?></td>
                    <td class="alert-new"><?php echo $t_reclass_dev_tot ?></td>
                    <td class="alert-new"><?php echo $t_reclass_dispose_tot ?></td>
                    <td class="alert-new"><?php echo $t_reclass_pen_tot ?></td>

                    <td class="alert-new">--</td>
                    <td class="alert-new">--</td>
                </tr>
            </table>
        </div>
    </div>
</div>





