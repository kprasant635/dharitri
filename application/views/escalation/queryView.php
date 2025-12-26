<style type="text/css">
    table, td, th {
  border: 1px solid red;
  text-align: center;
}

#table1 {
  border-collapse: collapse;
  border-color: blue;
}
#table2 {
  border-collapse: collapse;
  border-color: blue;
}
#table3 {
  border-collapse: collapse;
  border-color: blue;
}
#table4 {
  border-collapse: collapse;
  border-color: blue;
}
#table5 {
  border-collapse: collapse;
  border-color: blue;
}
#table2 {
  border-collapse: collapse;
  border-color: blue;
}
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <h3>Escalation Details</h3>
            <table id="table1">
                <tr>
                    <td>sl_no</td>
                    <td>taskid</td>
                    <td>petition_no</td>
                    <td>case_no</td>
                    <td>service_code</td>
                    <td>registerd_on</td>
                    <td>case_type</td>
                    <td>total_days</td>
                    <td>status</td>
                    <td>assignment_type</td>
                    <td>assigned_from</td>
                    <td>assigned_from_code</td>
                    <td>assigned_to</td>
                    <td>assigned_to_code</td>
                    <td>assigned_date</td>
                    <td>escalated_date</td>
                    <td>history_id</td>
                </tr>
                <?php foreach ($escData['escalationDetails'] as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->sl_no;?></td>
                        <td><?php echo $value->taskid;?></td>
                        <td><?php echo $value->petition_no;?></td>
                        <td><?php echo $value->case_no;?></td>
                        <td><?php echo $value->service_code;?></td>
                        <td><?php echo $value->registerd_on;?></td>
                        <td><?php echo $value->case_type;?></td>
                        <td><?php echo $value->total_days;?></td>
                        <td><?php echo $value->status;?></td>
                        <td><?php echo $value->assignment_type;?></td>
                        <td><?php echo $value->assigned_from;?></td>
                        <td><?php echo $value->assigned_from_code;?></td>
                        <td><?php echo $value->assigned_to;?></td>
                        <td><?php echo $value->assigned_to_code;?></td>
                        <td><?php echo $value->assigned_date;?></td>
                        <td><?php echo $value->escalated_date;?></td>
                        <td><?php echo $value->history_id;?></td>
                    </tr>
                <?php }?>

            </table>
            <br><br>
            <table id="table3">
                <tr>
                    <td>to_be_completed_within_days</td>
                    <td>assignment_type_other</td>
                    <td>assigned_other</td>
                    <td>assigned_other_date</td>
                    <td>assigned_other_es_date</td>
                    <td>to_be_other_completed_within_days</td>
                    <td>da_target_days</td>
                    <td>da_allocate_days</td>
                    <td>da_completed_days</td>
                    <td>da_date_code_list</td>
                    <td>da_escalate_status</td>
                    <td>lm_target_days</td>
                    <td>lm_allocate_days</td>
                    <td>lm_completed_days</td>
                    <td>lm_date_code_list</td>
                    <td>lm_escalate_status</td>
                    <td>sk_target_days</td>
                </tr>
                <?php foreach ($escData['escalationDetails'] as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->to_be_completed_within_days;?></td>
                        <td><?php echo $value->assignment_type_other;?></td>
                        <td><?php echo $value->assigned_other;?></td>
                        <td><?php echo $value->assigned_other_date;?></td>
                        <td><?php echo $value->assigned_other_es_date;?></td>
                        <td><?php echo $value->to_be_other_completed_within_days;?></td>
                        <td><?php echo $value->da_target_days;?></td>
                        <td><?php echo $value->da_allocate_days;?></td>
                        <td><?php echo $value->da_completed_days;?></td>
                        <td><?php echo $value->da_date_code_list;?></td>
                        <td><?php echo $value->da_escalate_status;?></td>
                        <td><?php echo $value->lm_target_days;?></td>
                        <td><?php echo $value->lm_allocate_days;?></td>
                        <td><?php echo $value->lm_completed_days;?></td>
                        <td><?php echo $value->lm_date_code_list;?></td>
                        <td><?php echo $value->lm_escalate_status;?></td>
                        <td><?php echo $value->sk_target_days;?></td>
                    </tr>
                <?php } ?>
            </table>
            <br><br>
            <table id="table4">
                <tr>
                  <td>sk_allocate_days</td>
                  <td>sk_completed_days</td>
                  <td>sk_date_code_list</td>
                  <td>sk_escalate_status</td>
                  <td>co_target_days</td>
                  <td>co_allocate_days</td>
                  <td>co_completed_days</td>
                  <td>co_date_code_list</td>
                    <td>co_escalate_status</td>
                    <td>bo_target_days</td>
                  <td>bo_allocate_days</td>
                  <td>bo_completed_days</td>
                  <td>bo_date_code_list</td>
                  <td>bo_escalate_status</td>
                  <td>adc_target_days</td>
                  <td>adc_allocate_days</td>
                  <td>adc_completed_days</td>
                  
                </tr>
              
                    <?php foreach ($escData['escalationDetails'] as $key => $value) { ?>
                    <tr>
                       
                      <td><?php echo $value->sk_allocate_days;?></td>
                      <td><?php echo $value->sk_completed_days;?></td>
                      <td><?php echo $value->sk_date_code_list;?></td>
                      <td><?php echo $value->sk_escalate_status;?></td>
                      <td><?php echo $value->co_target_days;?></td>
                      <td><?php echo $value->co_allocate_days;?></td>
                      <td><?php echo $value->co_completed_days;?></td>
                      <td><?php echo $value->co_date_code_list;?></td>
                        <td><?php echo $value->co_escalate_status;?></td>
                        <td><?php echo $value->bo_target_days;?></td>
                      <td><?php echo $value->bo_allocate_days;?></td>
                      <td><?php echo $value->bo_completed_days;?></td>
                      <td><?php echo $value->bo_date_code_list;?></td>
                      <td><?php echo $value->bo_escalate_status;?></td>
                      <td><?php echo $value->adc_target_days;?></td>
                      <td><?php echo $value->adc_allocate_days;?></td>
                      <td><?php echo $value->adc_completed_days;?></td>
                      
                    </tr>
                    <?php } ?>
                </table>
                <br><br>
                <table id="table5">
                    <tr>
                        <td>adc_date_code_list</td>
                          <td>adc_escalate_status</td>
                          <td>dc_target_days</td>
                          <td>dc_allocate_days</td>
                          <td>dc_completed_days</td>
                          <td>dc_date_code_list</td>
                          <td>dc_escalate_status</td>
                          <td>history_id_others</td>
                          <td>assigned_other_code</td>
                          <td>final_completion_date</td>
                    </tr>
                    <?php foreach ($escData['escalationDetails'] as $key => $value) { ?>
                        <td><?php echo $value->adc_date_code_list;?></td>
                      <td><?php echo $value->adc_escalate_status;?></td>
                      <td><?php echo $value->dc_target_days;?></td>
                      <td><?php echo $value->dc_allocate_days;?></td>
                      <td><?php echo $value->dc_completed_days;?></td>
                      <td><?php echo $value->dc_date_code_list;?></td>
                      <td><?php echo $value->dc_escalate_status;?></td>
                      <td><?php echo $value->history_id_others;?></td>
                      <td><?php echo $value->assigned_other_code;?></td>
                      <td><?php echo $value->final_completion_date;?></td>

                    <?php } ?>
               
            </table>
        </div>
        <div class="col-lg-12 ">
            <h3>Escalation Dates Details</h3>
            <table id="table2">
                <tr>
                    <td>sr_no</td>
                    <td>date_code</td>
                    <td>petition_no</td>
                    <td>service_code</td>
                    <td>taskid</td>
                    <td>action_type</td>
                    <td>pending_officer</td>
                    <td>assigned_user</td>
                    <td>assigned_user_code</td>
                    <td>assigned_to</td>
                    <td>assigned_to_code</td>
                    <td>registerd_on</td>
                    <td>allocation_date</td>
                    <td>target_completion_date</td>
                    <td>completion_date</td>
                    <td>date_diff</td>
                    <td>escalated_status</td>
                    <td>created_date</td>
                    <td>updated_date</td>
                    <td>completion_days</td>
                </tr>
                
                    <?php foreach ($escData['escalationDatesDetails'] as $key => $val) { ?>
                        <tr>
                            <td><?php echo $val->sr_no ;?></td>
                            <td><?php echo $val->date_code ;?></td>
                            <td><?php echo $val->petition_no ;?></td>
                            <td><?php echo $val->service_code ;?></td>
                            <td><?php echo $val->taskid ;?></td>
                            <td><?php echo $val->action_type ;?></td>
                            <td><?php echo $val->pending_officer ;?></td>
                            <td><?php echo $val->assigned_user ;?></td>
                            <td><?php echo $val->assigned_user_code ;?></td>
                            <td><?php echo $val->assigned_to ;?></td>
                            <td><?php echo $val->assigned_to_code ;?></td>
                            <td><?php echo $val->registerd_on ;?></td>
                            <td><?php echo $val->allocation_date ;?></td>
                            <td><?php echo $val->target_completion_date ;?></td>
                            <td><?php echo $val->completion_date ;?></td>
                            <td><?php echo $val->date_diff ;?></td>
                            <td><?php echo $val->escalated_status ;?></td>
                            <td><?php echo $val->created_date ;?></td>
                            <td><?php echo $val->updated_date ;?></td>
                            <td><?php echo $val->completion_days ;?></td>
                        </tr>
                    <?php } ?>
            </table>
        </div>
    </div>
</div>