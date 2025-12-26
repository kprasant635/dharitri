<style type="text/css">
table {
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
    <div class="row">
        <div class="col-lg-12" >
            <div class="alert alert-warning"><h2 class="uni_text center"><?php echo $this->lang->line('registered_disposed_pending_cases_of'); ?>
                    <font color="#0066FF"><?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></font> 
                    District- At a Glance(<font color="#0066FF"><?php echo $this->lang->line('circle_wise'); ?></font>)</h2></div>
            <div class="col-lg-12" >
                <div class="row" id="piegraph">
                    <div class="col-lg-4"  id="OMut" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="Opart" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="Ocon" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="FMut" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="FPart" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="Reclass" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="NRCase" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="MiscCase" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="ACtoPP" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="settlement" style="min-height: 300px;margin: 0;padding: 0"></div>
                    <div class="col-lg-4"  id="composite" style="min-height: 300px;margin: 0;padding: 0"></div>
                </div>
            </div>
        </div>
    </div>
    <center><div class="btn btn-primary " id="show"><?php echo $this->lang->line('click_here_to_view_the_report'); ?></div></center>
    <div class="btn btn-danger" id="showpie" style="display: none"><?php echo $this->lang->line('show_pie_chart'); ?></div>
    <div class="row" style="margin-top: 20px; overflow-x: scroll;table-layout: fixed; display: none" id="data" >
        <div class="col-lg-12" >  
            <span class="label label-primary uni_text"><?php echo $this->lang->line('district'); ?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></span>
            <span class="label label-success uni_text"><?php echo $this->lang->line('subdivision'); ?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code')); ?></span>
            <p><br></p>   
            <table class="table table-responsive table-bordered" style="overflow-x: scroll; background: #fff"   border="1">
                <tr>
                    <th style="background:#196f82;color:#fff" rowspan="3"><?php echo $this->lang->line('circle'); ?></th>
                    <td class="alert-info" style="background:#FF4500; color: #fff; text-align: center"  colspan="4"> <?php echo $this->lang->line('office_mutation'); ?></td>
                    <td class="alert-info" style="background:#6B8E23; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('office_partition'); ?></td>
                    <td class="alert-info" style="background:#4682B4; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('office_conversion'); ?></td>
                    <td class="alert-success" style="background:#B22222; color: #fff; text-align: center"  colspan="4"><?php echo $this->lang->line('field_mutation'); ?></td>
                    <td class="alert-success" style="background:#556B2F; color: #fff; text-align: center" colspan="4"><?php echo $this->lang->line('field_partition'); ?></td>
                    <td class="alert-success" style="background:#1F618D; color: #fff; text-align: center" colspan="4">NR Case</td>
                    <td class="alert-success" style="background:#D4AC0D; color: #fff; text-align: center" colspan="4">Misc Case</td>
                    <td class="alert-success" style="background:#C0392B; color: #fff; text-align: center" colspan="4">Reclassification</td>
                    <td class="alert-success" style="background:#684597; color: #fff; text-align: center" colspan="4">AC to PP</td>
                    <td class="alert-success" style="background:#033E3E; color: #fff; text-align: center" colspan="4">Settlement</td>
                    <td class="alert-success" style="background:#9E4638; color: #fff; text-align: center" colspan="4">Composite</td>
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
                    <td colspan="4" style="background:#684597; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#033E3E; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
                    <td colspan="4" style="background:#9E4638; color: #fff; text-align: center" ><?php echo $this->lang->line('no_of_cases'); ?></td>
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

                    <td style="background:#FF6347; color: #fff; text-align: center"><?php echo $this->lang->line('mouza_wise'); ?></td>
                    <td style="background:#FF6347; color: #fff; text-align: center"><?php echo $this->lang->line('year_wise'); ?></td>
                </tr>
                <tr style="text-align: center;background: #196f82;">
                    <th style="background:#196f82;color:#fff" class="alert-new">1</th>
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
                    <td class="alert-new">47</td>
                    
                </tr>
                
                <?php //var_dump($loc) ; ?>
                <tr style="text-align: center">
                    <th style="background:#196f82;color:#fff"><?php echo $loc->loc_name ; ?></th>
                    <td><?php echo $omut->c; ?></td>
                    <td><?php echo $omutfinal->c ?></td>
                    <td><?php echo $omutdev->c ?></td>
                    <td><?php echo $omutpen->c ?></td>
                    
                    <td ><?php echo $opart->c; ?></td>
                    <td ><?php echo $opartfinal->c ?></td>
                    <td ><?php echo $opartdev->c ?></td>
                     <td ><?php echo $opartpen->c ?></td>
                    
                    <td><?php echo $ocon->c; ?></td>
                    <td><?php echo $oconfinal->c ?></td>
                    <td><?php echo $ocondev->c ?></td>
                    <td><?php echo $oconpen->c ?></td>
                    
                    
                    <td><?php echo $ofcmut->c; ?></td>
                    <td><?php echo $ofcmutfinal->c ?></td>
                     <td><?php echo $ofcmutdev->c; ?></td>
                    <td><?php echo $ofcmutpen->c ?></td>
                   
                    
                    <td><?php echo $fpart->c ?></td>
                    <td><?php echo $fpartfinal->c ?></td>
                    <td><?php echo $fpartdev->c ?></td>
                    <td><?php echo $fpartpen->c ?></td>
                    
                    <td><?php echo $nr_tot->c ?></td>
                    <td><?php echo $nr_dev->c ?></td>
                    <td><?php echo $nr_dispose->c ?></td>
                    <td><?php echo $nr_pen->c ?></td>
                    
                    <td><?php echo $misccase_tot->c ?></td>
                    <td><?php echo $misccase_dev->c ?></td>
                    <td><?php echo $misccase_dispose->c ?></td>
                    <td><?php echo $misccase_pen->c ?></td>
                    
                    <td><?php echo $t_reclass_tot->c ?></td>
                    <td><?php echo $t_reclass_dev->c ?></td>
                    <td><?php echo $t_reclass_dispose->c ?></td>
                    <td><?php echo $t_reclass_pen->c ?></td>
                    

                    <td><?php echo $acpp_tot->c ?></td>
                    <td><?php echo $acpp_dev->c ?></td>
                    <td><?php echo $acpp_dispose->c ?></td>
                    <td><?php echo $acpp_pen->c ?></td>

                    <td><?php echo $settlement->total ?></td>
                    <td><?php echo $settlement->passed ?></td>
                    <td><?php echo $settlement->rejected ?></td>
                    <td><?php echo $settlement->pending ?></td>
                    
                    <td><?php echo $composite->total ?></td>
                    <td><?php echo $composite->delivered ?></td>
                    <td><?php echo $composite->disposed ?></td>
                    <td><?php echo $composite->pending ?></td>

                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeMouzawise?cir_code=<?php echo $loc->cir_code; ?>" class="btn btn-warning"><?php echo $this->lang->line('view'); ?></a></td>
                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeYearwise?cir_code=<?php echo $loc->cir_code; ?>" class="btn btn-danger"><?php echo $this->lang->line('view'); ?></a></td>
                </tr>
                <tr style="text-align: center;background: #196f82;">
                    <th style="background:#196f82;color:#fff" class="alert-new">Total </th>
                    <td class="alert-new"><?php echo $omut->c; ?></td>
                    <td class="alert-new"><?php echo $omutfinal->c ?></td>
                    <td class="alert-new"><?php echo $omutdev->c ?></td>
                    <td class="alert-new"><?php echo $omutpen->c ?></td>
                    
                    <td class="alert-new"><?php echo $opart->c; ?></td>
                    <td class="alert-new"><?php echo $opartfinal->c ?></td>
                    <td class="alert-new"><?php echo $opartdev->c ?></td>
                    <td class="alert-new"><?php echo $opartpen->c ?></td>
                    
                    
                    <td class="alert-new"><?php echo $ocon->c; ?></td>
                    <td class="alert-new"><?php echo $oconfinal->c ?></td>
                    <td class="alert-new"><?php echo $ocondev->c ?></td>
                    <td class="alert-new"><?php echo $oconpen->c ?></td>
                    
                    <td class="alert-new"><?php echo $ofcmut->c; ?></td>
                    <td class="alert-new"><?php echo $ofcmutfinal->c ?></td>
                    <td class="alert-new"><?php echo $ofcmutdev->c; ?></td>
                    <td class="alert-new"><?php echo $ofcmutpen->c ?></td>
                    
                    <td class="alert-new"><?php echo $fpart->c ?></td>
                    <td class="alert-new"><?php echo $fpartfinal->c ?></td>
                    <td class="alert-new"><?php echo $fpartdev->c ?></td>
                    <td class="alert-new"><?php echo $fpartpen->c ?></td>
                    
                    <td class="alert-new"><?php echo $nr_tot->c ?></td>
                    <td class="alert-new"><?php echo $nr_dev->c ?></td>
                    <td class="alert-new"><?php echo $nr_dispose->c ?></td>
                    <td class="alert-new"><?php echo $nr_pen->c ?></td>
                    
                    <td class="alert-new"><?php echo $misccase_tot->c ?></td>
                    <td class="alert-new"><?php echo $misccase_dev->c ?></td>
                    <td class="alert-new"><?php echo $misccase_dispose->c ?></td>
                    <td class="alert-new"><?php echo $misccase_pen->c ?></td>
                    
                    <td class="alert-new"><?php echo $t_reclass_tot->c ?></td>
                    <td class="alert-new"><?php echo $t_reclass_dev->c ?></td>
                    <td class="alert-new"><?php echo $t_reclass_dispose->c ?></td>
                    <td class="alert-new"><?php echo $t_reclass_pen->c ?></td>

                    <td class="alert-new"><?php echo $acpp_tot->c ?></td>
                    <td class="alert-new"><?php echo $acpp_dev->c ?></td>
                    <td class="alert-new"><?php echo $acpp_dispose->c ?></td>
                    <td class="alert-new"><?php echo $acpp_pen->c ?></td>

                    <td class="alert-new"><?php echo $settlement->total ?></td>
                    <td class="alert-new"><?php echo $settlement->passed ?></td>
                    <td class="alert-new"><?php echo $settlement->rejected ?></td>
                    <td class="alert-new"><?php echo $settlement->pending ?></td>
                    
                    <td class="alert-new"><?php echo $composite->total ?></td>
                    <td class="alert-new"><?php echo $composite->delivered ?></td>
                    <td class="alert-new"><?php echo $composite->disposed ?></td>
                    <td class="alert-new"><?php echo $composite->pending ?></td>
                    

                    
                    <td class="alert-new">--</td>
                    <td class="alert-new">--</td>
                </tr>
            </table>
        </div>
    </div>

</div>
<script class="code" type="text/javascript">
    $(document).ready(function () {
        jQuery.jqplot.config.enablePlugins = true;
        plot1 = jQuery.jqplot('OMut',
                [[['Pending', <?php echo $omutpen->c; ?>], ['Rejected',<?php echo $omutdev->c; ?>],['Delivered',<?php echo $omutfinal->c; ?>]]],
                {
                    title: 'Office Mutation -- Registered case(s) <?php echo  $omut->c; ?> ',
                    seriesDefaults: {
	  seriesColors:['#D011ED', '#E80422', '#1A668C'],
                        shadow: false,
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );

        plot2 = jQuery.jqplot('Opart',
                [[['Pending', <?php echo $opartpen->c; ?>], ['Rejected',<?php echo $opartdev->c; ?>],['Delivered',<?php echo $opartfinal->c; ?>]]],
                {
                    title: 'Office Partition -- Registered case(s) <?php echo $opart->c; ?>',
                    seriesDefaults: {
	  seriesColors:['#FAF445', '#17A617', '#958c12'],
                        shadow: false,
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true, startAngle: 290}
                    },
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );

        plot3 = jQuery.jqplot('Ocon',
                [[['Pending', <?php echo $oconpen->c; ?>], ['Rejected',<?php echo $ocondev->c; ?>],['Delivered',<?php echo $oconfinal->c; ?>]]],
                {
                    title: 'Office Conversion -- Registered case(s) <?php echo $ocon->c; ?>',
                    seriesDefaults: {
						seriesColors:['#953579', '#4b5de4', '#d8b83f', '#ff5800', '#0085cc', '#c747a3', '#cddf54', '#FBD178', '#26B4E3', '#bd70c7'],
                        shadow: false,
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true, startAngle: 180}
                    },
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );

        plot4 = jQuery.jqplot('FMut',
                [[['Pending', <?php echo $ofcmutpen->c; ?>], ['Rejected',<?php echo $ofcmutdev->c; ?>],['Delivered',<?php echo $ofcmutfinal->c; ?>]]],
                {
                    title: 'Field Mutation  -- Registered case(s) <?php echo $ofcmut->c; ?>',
                    seriesDefaults: {
	 seriesColors:['#9E0B06', '#26B4E3', '#bd70c7'],
                        shadow: false,
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true, startAngle: 360}
                    },
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );

        plot5 = jQuery.jqplot('FPart',
                [[['Pending', <?php echo $fpartpen->c; ?>], ['Rejected',<?php echo $fpartdev->c; ?>],['Delivered',<?php echo $fpartfinal->c; ?>]]],
                {
                    title: 'Field Partition -- Registered case(s) <?php echo $fpart->c; ?>',
                    seriesDefaults: {
                        shadow: false,
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },	
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );
        plot6 = jQuery.jqplot('Reclass',
                [[['Pending', <?php echo $t_reclass_pen->c; ?>], ['Rejected',<?php echo $t_reclass_dispose->c; ?>],['Delivered',<?php echo $t_reclass_dev->c; ?>]]],
                {
                    title: 'Reclassification  -- Registered case(s) <?php echo $t_reclass_tot->c; ?>',
                    seriesDefaults: {
                        shadow: false,
                        seriesColors:['#FFBB33', '#339FFF', '#FF5733'],
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },	
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );
        plot7 = jQuery.jqplot('NRCase',
                [[['Pending', <?php echo $nr_pen->c; ?>], ['Rejected',<?php echo $nr_dispose->c; ?>],['Delivered',<?php echo $nr_dev->c; ?>]]],
                {
                    title: 'NR Case  -- Registered case(s) <?php echo $nr_tot->c; ?>',
                    seriesDefaults: {
                        shadow: false,
                        seriesColors:['#33FF5B', '#333FFF', '#FF33DA'],
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },	
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );
        plot7 = jQuery.jqplot('MiscCase',
                [[['Pending', <?php echo $misccase_pen->c; ?>], ['Rejected',<?php echo $misccase_dispose->c; ?>],['Delivered',<?php echo $misccase_dev->c; ?>]]],
                {
                    title: 'Misc Case  -- Registered case(s) <?php echo $misccase_tot->c; ?>',
                    seriesDefaults: {
                        shadow: false,
                        seriesColors:['#D84D1D', '#D8D81D', '#EAA908'],
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },	
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );
        plot8 = jQuery.jqplot('ACtoPP',
                [[['Pending', <?php echo $acpp_pen->c; ?>], ['Rejected',<?php echo $acpp_dispose->c; ?>],['Delivered',<?php echo $acpp_dev->c; ?>]]],
                {
                    title: 'AC TO PP Case  -- Registered case(s) <?php echo $acpp_tot->c; ?>',
                    seriesDefaults: {
                        shadow: false,
                        seriesColors:['#ff681d','#EAA908','#55ab15'],
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },  
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );
        plot9 = jQuery.jqplot('settlement',
                [[['Pending', <?php echo $settlement->pending; ?>], ['Rejected',<?php echo $settlement->rejected; ?>],['Delivered',<?php echo $settlement->passed; ?>]]],
                {
                    title: 'Settlement(MB2)  -- Registered case(s) <?php echo $settlement->total; ?>',
                    seriesDefaults: {
                        shadow: false,
                        seriesColors:['#08A04B','#FF0000','#4C4646'],
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },  
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );
        plot10 = jQuery.jqplot('composite',
                [[['Pending', <?php echo $composite->pending; ?>], ['Rejected',<?php echo $composite->disposed; ?>],['Delivered',<?php echo $composite->delivered; ?>]]],
                {
                    title: 'Composite Service-- Registered case(s) <?php echo $composite->total; ?>',
                    seriesDefaults: {
                        shadow: false,
                        seriesColors:['#2B547E','#FF0000','#008080'],
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {padding: 10, sliceMargin: 2, showDataLabels: true}
                    },  
                    legend: {renderer: jQuery.jqplot.EnhancedLegendRenderer, show: true, location: 's', rendererOptions: {numberRows: '1', numberColumns: '3', seriesToggle: 'normal'}}
                }
        );

        $("#show").click(function () {
            $("#data").fadeToggle();
            $("#showpie").show();
            $("#piegraph").hide();
            $("#show").hide();
        });
        $("#showpie").click(function () {
            $("#piegraph").fadeToggle();
            $("#showpie").hide();
            $("#show").show();
            $("#data").hide();
        });

    });
</script>




