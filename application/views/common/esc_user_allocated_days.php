<?php // echo "<pre>"; var_dump($escAllocateDays);?>



<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 col-lg-offset-2 col-md-offset-2">
  <table class="table table-striped table-hover text-center table-bordered table-responsive">

    <?php if(isset($escAllocateDays) && ($escAllocateDays->service_code == 1 || $escAllocateDays->service_code == 2)) { ?>

      <thead>
        <tr>
          <td colspan="6" style="font-size:21px">Escalation Information</td>
        </tr>      
        <tr>
          <td width="20%">Mutation</td>
          <td width="30%">Total Allocated Days</td>
          <td width="10%">DA</td>
          <td width="10%">LM</td>
          <td width="10%">SK</td>
          <td width="10%">CO</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=strtoupper($escAllocateDays->category == 'FMUT' ? "<b>Field</b>" : "<b>Office</b>")?></td>
          <td><?=$escAllocateDays->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDays->total_timeline."</b>"?></td>
          <td><?=$escAllocateDays->da_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->da_allocated_days." <br>(".$escAllocateDays->da_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->lm_allocated_days." <br>(".$escAllocateDays->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->sk_allocated_days." <br>(".$escAllocateDays->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->co_allocated_days." <br>(".$escAllocateDays->co_allocate_perc ." %)</b>"?></td>
        </tr>
        <tr>
          <td><?=strtoupper($escAllocateDaysDeed->category == 'FMUTD' ? "<b>Field(Deed)</b>" : "<b>Office (Deed)</b>")?></td>
          <td><?=$escAllocateDaysDeed->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDaysDeed->total_timeline."</b>"?></td>
          <td><?=$escAllocateDaysDeed->da_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysDeed->da_allocated_days." <br>(".$escAllocateDaysDeed->da_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysDeed->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysDeed->lm_allocated_days." <br>(".$escAllocateDaysDeed->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysDeed->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysDeed->sk_allocated_days." <br>(".$escAllocateDaysDeed->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysDeed->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysDeed->co_allocated_days." <br>(".$escAllocateDaysDeed->co_allocate_perc ." %)</b>"?></td>
        </tr>
      </tbody>    
    
    <?php } ?>

    <?php if(isset($escAllocateDays) && $escAllocateDays->service_code == 3) { ?>

      <thead>
        <tr>
          <td colspan="6" style="font-size:21px">Escalation Information</td>
        </tr>      
        <tr>
          <td width="20%">Partition</td>
          <td width="30%">Total Allocated Days</td>
          <td width="10%">DA</td>
          <td width="10%">LM</td>
          <td width="10%">SK</td>
          <td width="10%">CO</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=strtoupper($escAllocateDays->category == 'FPART' ? "<b>Field</b>" : "<b>Office</b>")?></td>
          <td><?=$escAllocateDays->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDays->total_timeline."</b>"?></td>
          <td><?=$escAllocateDays->da_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->da_allocated_days." <br>(".$escAllocateDays->da_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->lm_allocated_days." <br>(".$escAllocateDays->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->sk_allocated_days." <br>(".$escAllocateDays->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->co_allocated_days." <br>(".$escAllocateDays->co_allocate_perc ." %)</b>"?></td>
        </tr>
      </tbody>    
    
    <?php } ?>

    <?php if(isset($escAllocateDays) && $escAllocateDays->service_code == 8) { ?>

      <thead>
        <tr>
          <td colspan="7" style="font-size:21px">Escalation Information</td>
        </tr>      
        <tr>
          <td>MISCELLANEOUS</td>
          <td>Total Allocated Days</td>
          <td>DA</td>
          <td>LM</td>
          <td>SK</td>
          <td>CO</td>
          <td>ADC</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=strtoupper($escAllocateDays->category == 'NCAN' ? "<b>Name Cancellation</b>" : "<b></b>")?></td>
          <td><?=$escAllocateDays->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDays->total_timeline."</b>"?></td>
          <td><?=$escAllocateDays->da_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->da_allocated_days." <br>(".$escAllocateDays->da_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->lm_allocated_days." <br>(".$escAllocateDays->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->sk_allocated_days." <br>(".$escAllocateDays->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->co_allocated_days." <br>(".$escAllocateDays->co_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->adc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->adc_allocated_days." <br>(".$escAllocateDays->adc_allocate_perc ." %)</b>"?></td>
        </tr>
        <tr>
          <td><?=strtoupper($escAllocateDaysNCOR->category == 'NCOR' ? "<b>Name Correction</b>" : "<b></b>")?></td>
          <td><?=$escAllocateDaysNCOR->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDaysNCOR->total_timeline."</b>"?></td>
          <td><?=$escAllocateDaysNCOR->da_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysNCOR->da_allocated_days." <br>(".$escAllocateDaysNCOR->da_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysNCOR->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysNCOR->lm_allocated_days." <br>(".$escAllocateDaysNCOR->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysNCOR->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysNCOR->sk_allocated_days." <br>(".$escAllocateDaysNCOR->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysNCOR->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysNCOR->co_allocated_days." <br>(".$escAllocateDaysNCOR->co_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysNCOR->adc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysNCOR->adc_allocated_days." <br>(".$escAllocateDaysNCOR->adc_allocate_perc ." %)</b>"?></td>
        </tr>
      </tbody>    
    
    <?php } ?>

    <?php if(isset($escAllocateDays) && $escAllocateDays->service_code == 4) { ?>

      <thead>
        <tr>
          <td colspan="6" style="font-size:21px">Escalation Information</td>
        </tr>      
        <tr>
          <td>MISCELLANEOUS</td>
          <td>Total Allocated Days</td>
          <td>LM</td>
          <td>CO</td>
          <td>ADC</td>
          <td>DC</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=strtoupper($escAllocateDays->category == 'RECLASS' ? "<b>Reclassification</b>" : "<b></b>")?></td>
          <td><?=$escAllocateDays->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDays->total_timeline."</b>"?></td>
          <td><?=$escAllocateDays->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->lm_allocated_days." <br>(".$escAllocateDays->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->co_allocated_days." <br>(".$escAllocateDays->co_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->adc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->adc_allocated_days." <br>(".$escAllocateDays->adc_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->dc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->dc_allocated_days." <br>(".$escAllocateDays->dc_allocate_perc ." %)</b>"?></td>
        </tr>
      </tbody>    
    
    <?php } ?>

    <!-- conversion -->
    <?php if(isset($escAllocateDays) && $escAllocateDays->service_code == 9) { ?>

      <thead>
        <tr>
          <td colspan="7" style="font-size:21px">Escalation Information</td>
        </tr>      
        <tr>
          <td width="20%">Conversion</td>
          <td width="30%">Total Allocated Days</td>
          <td width="10%">LM</td>
          <td width="10%">SK</td>
          <td width="10%">CO</td>
          <td width="10%">ADC</td>
          <td width="10%">DC</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Rural, Agricultural & Residential class</td>
          <td><?=$escAllocateDays->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDays->total_timeline."</b>"?></td>
          <td><?=$escAllocateDays->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->lm_allocated_days." <br>(".$escAllocateDays->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->sk_allocated_days." <br>(".$escAllocateDays->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->co_allocated_days." <br>(".$escAllocateDays->co_allocate_perc ." %)</b>"?></td>
          <td>NA</td>
          <td>NA</td>
        </tr>

        <tr>
          <td>Periphery; Agricultural & Residential Class</td>
          <td><?=$escAllocateDaysP->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDaysP->total_timeline."</b>"?></td>
          <td><?=$escAllocateDaysP->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysP->lm_allocated_days." <br>(".$escAllocateDaysP->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysP->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysP->sk_allocated_days." <br>(".$escAllocateDaysP->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysP->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysP->co_allocated_days." <br>(".$escAllocateDaysP->co_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysP->adc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysP->adc_allocated_days." <br>(".$escAllocateDaysP->adc_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysP->dc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysP->dc_allocated_days." <br>(".$escAllocateDaysP->dc_allocate_perc ." %)</b>"?></td>
        </tr>

        <tr>
          <td>Urban & Trade sites of non-urban area</td>
          <td><?=$escAllocateDaysU->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDaysU->total_timeline."</b>"?></td>
          <td><?=$escAllocateDaysU->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysU->lm_allocated_days." <br>(".$escAllocateDaysU->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysU->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysU->sk_allocated_days." <br>(".$escAllocateDaysU->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysU->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysU->co_allocated_days." <br>(".$escAllocateDaysU->co_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysU->adc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysU->adc_allocated_days." <br>(".$escAllocateDaysU->adc_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDaysU->dc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDaysU->dc_allocated_days." <br>(".$escAllocateDaysU->dc_allocate_perc ." %)</b>"?></td>
        </tr>
      </tbody>    
    
    <?php } ?>

    <!-- ALLOTMENT  -->
    <?php if(isset($escAllocateDays) && $escAllocateDays->service_code == 5) { ?>

      <thead>
        <tr>
          <td colspan="7" style="font-size:21px">Escalation Information</td>
        </tr>      
        <tr>
          <td>AC To PP</td>
          <td>Total Allocated Days</td>
          <td>LM</td>
          <td>SK</td>
          <td>CO</td>
          <td>ADC</td>
          <td>DC</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=strtoupper($escAllocateDays->category == 'ACPP' ? "<b>AC to PP</b>" : "<b></b>")?></td>
          <td><?=$escAllocateDays->total_timeline==0 ? "0" : "<b style='color:red'>".$escAllocateDays->total_timeline."</b>"?></td>
          <td><?=$escAllocateDays->lm_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->lm_allocated_days." <br>(".$escAllocateDays->lm_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->sk_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->sk_allocated_days." <br>(".$escAllocateDays->sk_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->co_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->co_allocated_days." <br>(".$escAllocateDays->co_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->adc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->adc_allocated_days." <br>(".$escAllocateDays->adc_allocate_perc ." %)</b>"?></td>
          <td><?=$escAllocateDays->dc_allocated_days==0 ? "0" : "<b style='color:red'>".$escAllocateDays->dc_allocated_days." <br>(".$escAllocateDays->dc_allocate_perc ." %)</b>"?></td>
        </tr>
      </tbody>    
    
    <?php } ?>



  </table>
</div>    

<div class="col-lg-12">
<?php 
  if(ESCALATION_ENABLE == 1){
    include(APPPATH."views/common/escalated_pending_list.php");
  } 
?>
</div>