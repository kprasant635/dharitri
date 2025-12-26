<div class="container-fluid login">
    <div class="row">
        <div class="col-lg-12" >
            <div class="alert alert-warning"><h2 class="uni_text center">District Wise Application Received, Disposed and Pending</h2></div>
        </div>
    </div>
    <?php //var_dump($mis); ?>
    <div class="row" style="margin-top: 20px; overflow-x: scroll;table-layout: fixed;" id="data" >
        <div class="col-lg-12" >  
           

            <table class="table table-responsive table-bordered" style="overflow-x: scroll"   border="1">
                <tr>
                    <td rowspan="3">District</td>
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

                    <td style="background:#FF6347; color: #fff; text-align: center">Circle</td>
                   
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
                  
                </tr>
                <?php
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
                foreach($mis as $key=>$v)
                {
                ?>
                    <tr style="text-align: center">
                        <td><?php echo $key; ?></td>
                        <td><?php
                            echo $v['omut']->c;
                            $omut_tot = $omut_tot + $v['omut']->c;
                            ?></td>
                        <td><?php
                            echo $v['omutfinal']->c;
                            $omutfinal_tot = $omutfinal_tot + $v['omutfinal']->c;
                            ?></td>
                        <td><?php
                        echo $v['omutdev']->c;
                        $omutdev_tot = $omutdev_tot + $v['omutdev']->c;
                            ?></td>
                        <td><?php
                        echo $v['omutpen']->c;
                        $omutpen_tot = $omutpen_tot + $v['omutpen']->c;
                            ?></td>
                        <td ><?php
                        echo $v['opart']->c;
                        $opart_tot = $opart_tot + $v['opart']->c;
                            ?></td>
                        <td ><?php
                            echo $v['opartfinal']->c;
                            $opartfinal_tot = $opartfinal_tot + $v['opartfinal']->c;
                            ?></td>
                        <td ><?php
                            echo $v['opartdev']->c;
                            $opartdev_tot = $opartdev_tot + $v['opartdev']->c;
                            ?></td>
                        <td ><?php
                            echo $v['opartpen']->c;
                            $opartpen_tot = $opartpen_tot + $v['opartpen']->c;
                            ?></td>

                        <td><?php
                            echo $v['ocon']->c;
                            $ocon_tot = $ocon_tot + $v['ocon']->c;
                            ?></td>
                        <td><?php
                            echo $v['oconfinal']->c;
                            $oconfinal_tot = $oconfinal_tot + $v['oconfinal']->c;
                            ?></td>
                        <td><?php
                            echo $v['ocondev']->c;
                            $ocondev_tot = $ocondev_tot + $v['ocondev']->c;
                            ?></td>
                        <td><?php
                            echo $v['oconpen']->c;
                            $oconpen_tot = $oconpen_tot + $v['oconpen']->c;
                            ?></td>


                        <td><?php
                            echo $v['ofcmut']->c;
                            $ofcmut_tot = $ofcmut_tot + $v['ofcmut']->c;
                            ?></td>
                        <td><?php
                            echo $v['ofcmutfinal']->c;
                            $ofcmutfinal_tot = $ofcmutfinal_tot +$v['ofcmutfinal']->c;
                            ?></td>
                        <td><?php
                        echo $v['ofcmutdev']->c;
                        $ofcmutdev_tot = $ofcmutdev_tot +$v['ofcmutdev']->c;
                            ?></td>
                        <td><?php
                            echo $v['ofcmutpen']->c;
                            $ofcmutpen_tot = $ofcmutpen_tot + $v['ofcmutpen']->c;
                            ?></td>


                        <td><?php
                            echo $v['fpart']->c;
                            $fpart_tot = $fpart_tot + $v['fpart']->c;
                            ?></td>
                        <td><?php
                            echo $v['fpartfinal']->c;
                            $fpartfinal_tot = $fpartfinal_tot + $v['fpartfinal']->c;
                            ?></td>
                        <td><?php
                            echo $v['fpartdev']->c;
                            $fpartdev_tot = $fpartdev_tot + $v['fpartdev']->c;
                            ?></td>
                        <td><?php
                            echo $v['fpartpen']->c;
                            $fpartpen_tot = $fpartpen_tot + $v['fpartpen']->c;
                            ?></td>

                        <td><?php
                echo $v['nr_tot']->c;
                $nr_tot_tot = $nr_tot_tot + $v['nr_tot']->c;
                ?></td>
                        <td><?php
                echo $v['nr_dev']->c;
                $nr_dev_tot = $nr_dev_tot + $v['nr_dev']->c;
                ?></td>
                        <td><?php
                echo $v['nr_dispose']->c;
                $nr_dispose_tot = $nr_dispose_tot + $v['nr_dispose']->c;
                ?></td>
                        <td><?php
                echo $v['nr_pen']->c;
                $nr_pen_tot = $nr_pen_tot + $v['nr_pen']->c;
                ?></td>

                        <td><?php
                echo $v['misccase_tot']->c;
                $misccase_tot_tot = $misccase_tot_tot + $v['misccase_tot']->c;
                ?></td>
                        <td><?php
                echo $v['misccase_dev']->c;
                $misccase_dev_tot = $misccase_dev_tot + $v['misccase_dev']->c;
                ?></td>
                        <td><?php
                echo $v['misccase_dispose']->c;
                $misccase_dispose_tot = $misccase_dispose_tot + $v['misccase_dispose']->c;
                ?></td>
                        <td><?php
                echo $v['misccase_pen']->c;
                $misccase_pen_tot = $misccase_pen_tot + $v['misccase_pen']->c;
                ?></td>

                        <td><?php
                echo $v['t_reclass_tot']->c;
                $t_reclass_tot_tot = $t_reclass_tot_tot + $v['t_reclass_tot']->c;
                ?></td>
                        <td><?php
                echo $v['t_reclass_dev']->c;
                $t_reclass_dev_tot = $t_reclass_dev_tot + $v['t_reclass_dev']->c;
                ?></td>
                        <td><?php
                echo $v['t_reclass_dispose']->c;
                $t_reclass_dispose_tot = $t_reclass_dispose_tot + $v['t_reclass_dispose']->c;
                ?></td>
                        <td><?php
                echo $v['t_reclass_pen']->c;
                $t_reclass_pen_tot = $t_reclass_pen_tot + $v['t_reclass_pen']->c;
                ?></td>

                        <td><a href="<?php echo base_url(); ?>index.php/Portal/DisposeGalanceCircle?d=<?php echo $key; ?>" class="btn btn-warning"><?php echo $this->lang->line('view'); ?></a></td>
                        
                    </tr>
    
                <?php } ?>
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
                  
                </tr>
            </table>
        </div>
    </div>
</div>





