<?php
  // get the dag_no and id count
  $comboCount = [];
  foreach ($mutatedApplList as $item) {
    $key = $item->dag_no . '_' . $item->id;
    if (!isset($comboCount[$key])) {
      $comboCount[$key] = 0;
    }
    $comboCount[$key]++;
  }
  $comboCountJson = htmlspecialchars(json_encode($comboCount), ENT_QUOTES, 'UTF-8');

?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-red" style="font-size:25px; font-style: italic;">

  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    Is/Are the applicant(s) of this application already mutated ?
  </div>
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <div class="form-check form-check-inline">
        <input class="form-check-input is_mutated" type="radio" name="is_mutated" id="is_mutated1" value="YES"/>
        <label class="form-check-label" for="inlineRadio1">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input is_mutated" type="radio" name="is_mutated" id="is_mutated2" value="NO"/>
        <label class="form-check-label" for="inlineRadio2">No</label>
      </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displaySubmitButton" style="display:none;">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">&nbsp;</div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <span style="background-color: yellow;" id="no_joint_appl"></span>
      <button class="btn btn-sm btn-danger" type="button" id="btnIsMutatedWithNo">Submit</button>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">&nbsp;</div>    
  </div>

</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-success mutated_status" style="font-size:20px;"></div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

<div class="modal" role="dialog" id="isMutatedModal">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <span class="text-danger"><?=$caseDetails->case_no?></span><br>
                    <span style="background-color: yellow;">NOTE: Kindly be informed that the modifications entered in this form shall be treated as the final resolution of this case, and the Chitha records will be updated accordingly</span>
                </h5>
            </div>
            <div class="modal-body">
              <table class="table table-bordered ">
                <tr class="text-danger">
                  <th width="5%">Sr No</th>
                  <th width="8%">Dag No</th>
                  <th width="12%">Applicant Name</th>
                  <th width="12%">Guardian Name</th>
                  <th width="12%">Category</th>
                  <th width="10%">Check if Already Partitioned</th>
                  <th width="31%">Select Pattadar (if already mutated)</th>
                  <th width="10%">Remove Applicant</th>
                </tr>

                <?php $i=1; foreach($mutatedApplList as $r) { 
                  $unique_id1 = '0_'.$r->dag_no.'_'.$r->id; // for no pattadar selection
                ?>

                  <tr>
                    <th><?=$i?></th>
                    <th><?=$r->dag_no?></th>
                    <th><?=$r->pdar_name?></th>
                    <th><?=$r->pdar_guardian?></th>
                    <th><?=$r->is_applicant == 1 ? 'Primary Applicant' : 'Joint Applicant' ?></th>

                    <th>                      
                      <input class="form-check-input already_partitioned" type="checkbox" name="already_partitioned_<?=$r->dag_no.'_'.$r->id?>"
                        style="width: 15px;  height: 15px;" id="already_partitioned_<?=$r->dag_no.'_'.$r->id?>" value="<?=$r->dag_no.'_'.$r->id?>" >
                    </th>

                    <th>

                      <div class="list-group" style="height:100px;overflow:auto;border: solid 3px #181842;">

                        <label class="list-group-item">
                          <div class="col-lg-1">
                            <input class="form-check-input pattadar_default pattadar_<?=$unique_id1?>" checked type="checkbox" 
                            style="width: 15px;  height: 15px;" id="pattadar_<?=$unique_id1?>" name="pattadar_<?=$unique_id1?>"
                            value="<?=$unique_id1?>" >
                          </div>
                          <label>উপলব্ধ নহয়</label>
                        </label> 

                        <?php foreach($listOfChithaOwners as $ep) { 

                          $unique_id = $ep->pdar_id.'_'.$r->dag_no.'_'.$r->id;
                        ?>
                          
                          <label class="list-group-item">
                            <div class="col-lg-1">
                              <input class="form-check-input pattadar_owner" type="checkbox" 
                              style="width: 15px;  height: 15px;" id="pattadar_<?=$ep->pdar_id?>" name="pattadar_<?=$ep->pdar_id?>"
                              value="<?=$unique_id?>" >
                            </div>
                            <label><?=$ep->pdar_name?> (<?=$ep->pdar_father?>)</label>
                          </label>                          
                                                      
                        <?php } ?>

                      </div>

                    </th>

                    <?php if($r->is_applicant == 0) { ?>
                      <th>                      
                        <input class="form-check-input joint_appl_remove" type="checkbox" name="joint_appl_remove_<?=$r->dag_no.'_'.$r->id?>"
                          style="width: 15px;  height: 15px;" id="joint_appl_remove_<?=$r->dag_no.'_'.$r->id?>" value="<?=$r->dag_no.'_'.$r->id?>" >
                      </th>
                    <?php } ?>

                   

                  </tr>

                <?php $i++; } ?>

              </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
                <button type="button" class="btn btn-primary" id="saveMutationStatus">Save Mutation Status</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" role="dialog" id="isMutatedModalSaysNo" style="display:none;">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <span class="text-danger"><?=$caseDetails->case_no?></span><br>
                    <span style="background-color: yellow;" class="note"></span>
                </h5>
            </div>
            <div class="modal-body">
              <table class="table table-bordered ">
                <thead>                  
                  <tr class="text-danger">
                    <th width="5%">Sr No</th>
                    <th width="8%">Dag No</th>
                    <th width="12%">Applicant Name</th>
                    <th width="12%">Guardian Name</th>
                    <th width="12%">Category</th>
                    <th width="10%">Remove Applicant</th>
                  </tr>
                </thead>
                <tbody id="joint_appl_list"></tbody>

              </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalNo">Close</button>
                <button type="button" class="btn btn-primary" id="saveMutationStatusNo">Verify & Save</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="mut_case_no" value="<?=$caseDetails->case_no?>">                
<input type="hidden" id="mutatedApplList_array" name="mutatedApplList_array" value="<?= $comboCountJson ?>" >
<input type="hidden" id="mutatedApplList_count" name="mutatedApplList_count" value="<?=count($comboCount)?>" >

<script type="text/javascript">

  function showErrorMessage1(text) {
    swal.fire({
      title: "Error!",
      text: text,
      icon: 'error',
      position: 'top',
      showConfirmButton: false,
      timer: 15000,
      showCancelButton: true
    });
  }  

  $(document).ready(function(){
    const mutatedCount    = '<?=$mutatedCount?>';
    const mutatedStatusNo = '<?=$mutatedStatusNo?>';    

    if(mutatedCount > 0 && mutatedStatusNo == 'NO')
    {
      $("#is_mutated2").prop('checked', true);     
      $(".is_mutated").prop('disabled', true); 
    }
    else if(mutatedCount > 0 && (mutatedStatusNo == '' ||  mutatedStatusNo == null))
    {
      $("#is_mutated1").prop('checked', true);
      $(".is_mutated").prop('disabled', true);
    }
  });

  let selectedPattadars1 = [];

  $(document).on('change', '.pattadar_owner', function () 
  {
    const isChecked = $(this).is(':checked');
    const uniqueId = $(this).val(); // Format: pdar_id_dag_no_rowId

    var res = uniqueId.split('_');
    const no_pattadar = $('.pattadar_0_'+res[1]+'_'+res[2]).val(); // default checkbox id

    const data = {
      unique_id : uniqueId
    };

    if (isChecked) {

      $('.pattadar_0_'+res[1]+'_'+res[2]).prop('checked', false);

      // Add only if not already present
      if (!selectedPattadars1.find(item => item.unique_id === uniqueId)) {
        selectedPattadars1.push(data);
      }
    } else {
      // Remove from array if unchecked
      selectedPattadars1 = selectedPattadars1.filter(item => item.unique_id !== uniqueId);
    }
    console.log(selectedPattadars1); // View current selected items
  });

  $("input[name=is_mutated]").on("click", function () 
  {
    var is_mutated = $("input[name=is_mutated]:checked").val();
    if (is_mutated == "YES") {
      $('#isMutatedModal').modal('show');
      $('.displaySubmitButton').hide();
    }
    else if (is_mutated == "NO") {
      $('#isMutatedModal').modal('hide'); 
      // $('.displaySubmitButton').show();    

      isMuatedNo();
    }
  });

  $('#closeModal').click(function(){
    $('#isMutatedModal').modal('hide');
    $("input[name=is_mutated]:checked").prop('checked', false);
    $('.pattadar_owner').prop('checked', false);
    $('.pattadar_default').prop('checked', true);
  });

  $('#closeModalNo').click(function(){
    $('#isMutatedModalSaysNo').hide();
    $("input[name=is_mutated]:checked").prop('checked', false);
    $('.joint_appl_remove_for_no').prop('checked', false);
  });

  $('#saveMutationStatus').click(function()
  {
    let selectedPattadars = [];
    $('.pattadar_owner:checked').each(function () {
      selectedPattadars.push($(this).val());
    });

    if(selectedPattadars.length == 0)
    {
      showErrorMessage1("No pattadar selected !!! ");
      return;
    }

    let selectedDefaultPattadars = [];
    $('.pattadar_default:checked').each(function () {
      selectedDefaultPattadars.push($(this).val());
    });

    let selectedPartitionedPattadars = [];
    $('.already_partitioned:checked').each(function () {
      selectedPartitionedPattadars.push($(this).val());
    });

    let selectedJointRemovePattadars = [];
    $('.joint_appl_remove:checked').each(function () {
      selectedJointRemovePattadars.push($(this).val());
    });

    const parameters = {
      case_no               : $('#mut_case_no').val(),
      pattadar              : selectedPattadars,
      service_code          : '43',
      mutatedApplList_array : $('#mutatedApplList_array').val(),
      mutatedApplList_count : $('#mutatedApplList_count').val(),
      no_pattadar           : selectedDefaultPattadars,
      already_partitioned   : selectedPartitionedPattadars,
      joint_appl_remove     : selectedJointRemovePattadars,
    };

    if(selectedJointRemovePattadars.length == 0)
    {
      var text = 'Please note that these changes are irreversible. The process applicable to this case will be determined based on the changes made here. Are you sure to proceed with the changes?';
    }
    else {
      var text = 'Please note that these changes are irreversible. You have selected joint applicant(s) also to REMOVE from this application. The process applicable to this case will be determined based on the changes made here. Are you sure to proceed with the changes?';
    }

    Swal.fire({
      icon             : 'warning',
      backdrop          : true,
      allowOutsideClick : false,
      text              : text,
      showDenyButton    : true,
      confirmButtonText : 'Yes',
      customClass       : {
        actions         : 'my-actions',
        confirmButton   : 'order-2',
      },
    }).then((result) => {
      if(result.isConfirmed) // for updation of new application
      {
        $.ajax({
          url      : baseurl + "TeaGrantControllerAdc/saveMutationStatus",
          type: "post",
          dataType: "json",
          success: function(data) {
            
            if(data.responseType == 0)
            {
              showErrorMessage1(data.msg);
              return;
            }
            else if (data.responseType == 2) {
              Swal.fire({
                icon: 'success',
                backdrop:true,
                allowOutsideClick: false,
                text: data.msg,
                confirmButtonText: 'OK',
                customClass: {
                  actions: 'my-actions',
                  confirmButton: 'order-2',
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  $('#isMutatedModal').modal('hide');
                  $(".is_mutated").prop('disabled', true);
                  $('.mutated_status').html(data.status_msg);
                }
              });
            }
            else { //error messages
              showErrorMessage1(data.msg);
            }        
          }, error: (error) => {
            showErrorMessage1("SOMETHING WENT WRONG !!!!");
          },
          data: JSON.stringify(parameters)
        });
      }
    });
  });

  $('#btnIsMutatedWithNo').click(function(){
    Swal.fire({
      icon             : 'warning',
      backdrop          : true,
      allowOutsideClick : false,
      text              : "You have selected 'No'. As a result, the outcome of this case will be Mutation with Partition, followed by a Conversion process. Please note that these changes are irreversible. Do you wish to proceed?",
      showDenyButton    : true,
      confirmButtonText : 'Yes',
      customClass       : {
        actions         : 'my-actions',
        confirmButton   : 'order-2',
      },
    }).then((result) => {
      if(result.isConfirmed) // for updation of new application
      {
        const parameters = {
          case_no      : $('#mut_case_no').val(),
          service_code : '43',
          is_mutated2  : $('#is_mutated2').val(),
        };

        $.ajax({
          url      : baseurl + "TeaGrantControllerAdc/saveMutationStatusWithNo",
          type: "post",
          dataType: "json",
          success: function(data) {

            $('.displaySubmitButton').hide();
            
            if(data.responseType == 0)
            {
              showErrorMessage1(data.msg);
              return;
            }
            else if (data.responseType == 2) {
              Swal.fire({
                icon: 'success',
                backdrop:true,
                allowOutsideClick: false,
                text: data.msg,
                confirmButtonText: 'OK',
                customClass: {
                  actions: 'my-actions',
                  confirmButton: 'order-2',
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  $('#isMutatedModal').modal('hide');
                  $(".is_mutated").prop('disabled', true);
                  $('.mutated_status').html(data.status_msg);
                }
              });
            }
            else { //error messages
              showErrorMessage1(data.msg);
            }        
          }, error: (error) => {
            showErrorMessage1("SOMETHING WENT WRONG !!!!");
          },
          data: JSON.stringify(parameters)
        });
      }
    });
  });


  function isMuatedNo()
  {
    const parameters = {
      case_no      : $('#mut_case_no').val(),
      service_code : '43',
      is_mutated2  : $('#is_mutated2').val(),
    };

    $.ajax({
      url      : baseurl + "TeaGrantControllerAdc/checkIfJointApplExist",
      type: "post",
      dataType: "json",
      success: function(data) {        
        
        if(data.responseType == 0)
        {
          showErrorMessage1(data.msg);
          return;
        }
        else if(data.responseType == 1) // if no joint applicant found
        {
          $('#no_joint_appl').html(data.msg);
          $('.displaySubmitButton').show();
        }
        else if (data.responseType == 2) {
          
          $("#isMutatedModalSaysNo").show();
          $('.note').html(data.msg);

          var tableJointAppl = '';
          $.each(data.result, function (i, val)
          {
            tableJointAppl +=
              '<tr>'+
                '<td>' + (i + 1) + '</td>' +
                '<td>' + val["dag_no"] + '</td>' +
                '<td>' + val["pdar_name"] + '</td>' +
                '<td>' + val["pdar_guardian"] + '</td>' +
                '<td>' + val["is_applicant"] + '</td>' +
                '<td><input class="form-check-input joint_appl_remove_for_no" type="checkbox" name="joint_appl_remove_for_no'+val["dag_no"]+'_'+val["id"]+'" style="width: 15px;  height: 15px;" id="joint_appl_remove_for_no'+val["dag_no"]+'_'+val["id"]+'" value="'+val["dag_no"]+'_'+val["id"]+'" ></td>' +
              '</tr>'
          });

          $('#joint_appl_list').html(tableJointAppl);
        }
        else { //error messages
          showErrorMessage1(data.msg);
        }        
      }, error: (error) => {
        showErrorMessage1("SOMETHING WENT WRONG !!!!");
      },
      data: JSON.stringify(parameters)
    });
  }


  $('#saveMutationStatusNo').click(function(){

    let selectedJointAppl = [];
    $('.joint_appl_remove_for_no:checked').each(function () {
      selectedJointAppl.push($(this).val());
    });

    if(selectedJointAppl.length == 0){
      // showErrorMessage1("No applicant selected to remove !!! ");
      // return;
      msg = "No joint applicant has been selected. In this case, the application will proceed with Mutation and Partition, followed by Conversion, for all listed applicant(s). Are you sure to proceed ? ";
    }
    else
    {
      msg = "The selected joint applicant will be removed from this application, and this action cannot be undone. Do you want to proceed ?";
    }

    Swal.fire({
      icon              : 'warning',
      backdrop          : true,
      allowOutsideClick : false,
      text              : msg,
      showDenyButton    : true,
      confirmButtonText : 'Yes',
      customClass       : {
        actions         : 'my-actions',
        confirmButton   : 'order-2',
      },
    }).then((result) => {
      if(result.isConfirmed) // for updation of new application
      {
        const parameters = {
          case_no           : $('#mut_case_no').val(),
          service_code      : '43',
          joint_appl_remove : selectedJointAppl,
          is_mutated2       : $('#is_mutated2').val(),
        };

        $.ajax({
          url      : baseurl + "TeaGrantControllerAdc/removeJointApplicantWithNoStatus",
          type: "post",
          dataType: "json",
          success: function(data) {
            
            if(data.responseType == 0)
            {
              showErrorMessage1(data.msg);
              return;
            }
            else if (data.responseType == 2) {
              Swal.fire({
                icon: 'success',
                backdrop:true,
                allowOutsideClick: false,
                text: data.msg,
                confirmButtonText: 'OK',
                customClass: {
                  actions: 'my-actions',
                  confirmButton: 'order-2',
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  $('#isMutatedModalSaysNo').modal('hide');
                  $(".is_mutated").prop('disabled', true);
                  $('.mutated_status').html(data.status_msg);
                }
              });
            }
            else { //error messages
              showErrorMessage1(data.msg);
            }        
          }, error: (error) => {
            showErrorMessage1("SOMETHING WENT WRONG !!!!");
          },
          data: JSON.stringify(parameters)
        });
      }
    });




  });

  


</script>