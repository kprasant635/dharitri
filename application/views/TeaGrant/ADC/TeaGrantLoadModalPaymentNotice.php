
<div class="modal" role="dialog" id="paymentNoticeModal" >
    <div class="modal-dialog" role="document"  style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <?=$case_no?>
                </h5>
                <button type="button" class="btn btn-warning btn-sm" id="closePremModal">Close</button>
            </div>
            <div class="modal-body" >
                <form action="">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <table class="table">
                            <tr>
                              <th>জিলা</th>
                              <th>ৰাজহ চক্ৰ</th>
                              <th>মৌজা</th>
                              <th>লাট নং</th>
                              <th>গাওঁ</th>
                              <th class="text-center">পট্টা নং</th>
                              <th class="text-center">পট্টা প্ৰকাৰ</th>
                              <th>দাগ নং</th>
                              <th>পূৰ্ব ভূমি শ্ৰেণী</th>
                              <th>কালি</th>
                            </tr>

                            <tr>
                              <td>
                                <?=$this->utilityclass->getDistrictName($get_settlement_basic['dist_code'])?>
                              </td>
                              <td>
                                <?=$this->utilityclass->getCircleName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'])?>
                              </td>
                              <td>
                                <?=$this->utilityclass->getMouzaName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'],$get_settlement_basic['mouza_pargona_code'])?>
                              </td>
                              <td>
                                <?=$this->utilityclass->getLotName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'],$get_settlement_basic['mouza_pargona_code'],$get_settlement_basic['lot_no'])?>
                              </td>
                              <td>
                                <?=$this->utilityclass->getVillageName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'],$get_settlement_basic['mouza_pargona_code'],$get_settlement_basic['lot_no'],$get_settlement_basic['vill_townprt_code'])?>
                              </td>
                              <td class="text-center"><?=$get_dag_details[0]->patta_no?></td>
                              <td class="text-center"><?=$this->utilityclass->getPattaName($get_dag_details[0]->patta_type_code)?></td>

                              <td>
                                <?php 

                                  $dag_position = 0;
                                  $dag_length   = count($premium_data);

                                  foreach($premium_data as $r) { 

                                    if((in_array($get_settlement_basic['dist_code'], json_decode(BARAK_VALLEY)))){

                                      echo $r->dag_no;

                                      if($dag_position == $dag_length - 1) { echo ""; } 
                                      else { echo "<br>"; }
                                      $dag_position++;
                                    }
                                    else
                                    {
                                      echo $r->dag_no;

                                      if($dag_position == $dag_length - 1) { echo ""; } 
                                      else { echo "<br>"; }
                                      $dag_position++;
                                    }
                                  }

                                ?>
                              </td>

                              <td>
                                <?php 

                                  $dag_position = 0;
                                  $dag_length   = count($all_dags);

                                  foreach($all_dags as $r) { 

                                    $sreni = $this->TeaGrantAdcModel->getLandClassDetail($get_settlement_basic['dist_code'], $get_settlement_basic['subdiv_code'], $get_settlement_basic['cir_code'], $get_settlement_basic['mouza_pargona_code'], $get_settlement_basic['lot_no'], $get_settlement_basic['vill_townprt_code'], $r->patta_no, $r->patta_type_code, trim($r->dag_no))->num_rows();

                                    if($sreni > 0) {
                                      echo $this->TeaGrantAdcModel->getLandClassDetail($get_settlement_basic['dist_code'], $get_settlement_basic['subdiv_code'], $get_settlement_basic['cir_code'], $get_settlement_basic['mouza_pargona_code'], $get_settlement_basic['lot_no'], $get_settlement_basic['vill_townprt_code'], $r->patta_no, $r->patta_type_code, trim($r->dag_no))->row()->land_type;
                                    }

                                    if($dag_position == $dag_length - 1) { echo ""; } 
                                    else { echo "<br>"; }
                                    $dag_position++;
                                  }

                                ?>
                              </td>

                              <td>
                                <?php 

                                  $position = 0;
                                  $length   = count($premium_data);

                                  foreach($premium_data as $r) { 

                                    if((in_array($get_settlement_basic['dist_code'], json_decode(BARAK_VALLEY)))){

                                      $total_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($r->total_lessa);
                                      $bigha = $total_area[0];
                                      $katha = $total_area[1];
                                      $lessa = $total_area[2];
                                      $ganda = $total_area[3];

                                      echo "বি: $bigha ক: $katha লে: $lessa";

                                      if($position == $length - 1) { echo ""; } 
                                      else { echo "<br>"; }
                                      $position++;
                                    }
                                    else
                                    {
                                      $total_area = $this->utilityclass->Total_Bigha_Katha_Lessa($r->total_lessa); 
                                      $bigha = $total_area[0];
                                      $katha = $total_area[1];
                                      $lessa = $total_area[2];

                                      echo "বি: $bigha ক: $katha লে: $lessa";

                                      if($position == $length - 1) { echo ""; } 
                                      else { echo "<br>"; }
                                      $position++;
                                    }
                                  }

                                ?>
                              </td>
                            </tr>
                          </table>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <table class="table">
                               <tr>
                                  <th></th>
                                  <th>বৰ্ণনা</th>
                                  <th>প্ৰিমিয়াম (per bigha)</th>
                                  <th>দাগ</th>
                                  <th>কালি</th>
                                  <th class="text-right">মুঠ মূল্য</th>
                               </tr>

                               <tr>
                                  <th>১</th>
                                  <th>ম্যাদী পট্টালৈ পৰিৱৰ্তনৰ বাবে প্ৰিমিয়াম মূল্য<br>(মাণ্ডলিক মূল্যৰ ১০%)</th>
                                  <th>
                                    
                                    <?php 

                                      $pos = 0;
                                      $len = count($premium_data);

                                      foreach($premium_data as $r) { 

                                        if((in_array($get_settlement_basic['dist_code'], json_decode(BARAK_VALLEY)))){

                                          echo $r->zonal_valuation;

                                          if($pos == $len - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $pos++;
                                        }
                                        else
                                        {
                                          echo $r->zonal_valuation;

                                          if($pos == $len - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $pos++;
                                        }
                                      }

                                    ?>
                                  </th>

                                  <th>
                                    <?php 

                                      $dag_position = 0;
                                      $dag_length   = count($premium_data);

                                      foreach($premium_data as $r) { 

                                        if((in_array($get_settlement_basic['dist_code'], json_decode(BARAK_VALLEY)))){

                                          echo $r->dag_no;

                                          if($dag_position == $dag_length - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $dag_position++;
                                        }
                                        else
                                        {
                                          echo $r->dag_no;

                                          if($dag_position == $dag_length - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $dag_position++;
                                        }
                                      }

                                    ?>
                                  </th>

                                  <th>
                                    <?php 

                                      $position = 0;
                                      $length   = count($premium_data);

                                      foreach($premium_data as $r) { 

                                        if((in_array($get_settlement_basic['dist_code'], json_decode(BARAK_VALLEY)))){

                                          $total_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($r->total_lessa);
                                          $bigha = $total_area[0];
                                          $katha = $total_area[1];
                                          $lessa = $total_area[2];
                                          $ganda = $total_area[3];

                                          echo "বি: $bigha ক: $katha লে: $lessa";

                                          if($position == $length - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $position++;
                                        }
                                        else
                                        {
                                          $total_area = $this->utilityclass->Total_Bigha_Katha_Lessa($r->total_lessa); 
                                          $bigha = $total_area[0];
                                          $katha = $total_area[1];
                                          $lessa = $total_area[2];

                                          echo "বি: $bigha ক: $katha লে: $lessa";

                                          if($position == $length - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $position++;
                                        }
                                      }

                                    ?>
                                  </th>

                                  <th class="text-right">
                                    <?php 

                                      $pos = 0;
                                      $len = count($premium_data);

                                      foreach($premium_data as $r) { 

                                        if((in_array($get_settlement_basic['dist_code'], json_decode(BARAK_VALLEY)))){

                                          echo $r->amount_dag;

                                          if($pos == $len - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $pos++;
                                        }
                                        else
                                        {
                                          echo $r->amount_dag;

                                          if($pos == $len - 1) { echo ""; } 
                                          else { echo "<br>"; }
                                          $pos++;
                                        }
                                      }

                                    ?>
                                  </th>
                               </tr>
                            </table>
                        </div>



                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="w3review" style="font-weight: bold">Final Amount(Rs.)</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span id="html_final_amt"><?=$prem->final_amount?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="w3review" style="font-weight: bold">Due Amount(Rs.)</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <span id="html_final_amt"><?=$prem->due_amount?></span>
                            </div>

                            <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                <label for="w3review" style="font-weight: bold">Hearing Date and Time</label>
                            </div> -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                            <input type="datetime-local" hidden class="form-control" name="hearing_date_input" id="hearing_date_input" 
                            value=<?=date('Y-m-d H:i:s')?>>
                            </div>

                            <input type="hidden" class="form-control" id="due_amount" value="<?=$prem->due_amount?>">
                            <input type="hidden" class="form-control" id="final_amount" value="<?=$prem->final_amount?>">
                            <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        </div>


                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="w3review" style="font-weight: bold; background-color: yellow; color: red;">Kindly note that in certain cases, the area applied for by the applicant exceeds the area registered in deed. Therefore, you are requested to kindly verify the deed and reconcile the area details as per the process outlined below before generating the Payment Notice.</label>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-red">
                              (1) Has the applicant applied for an area greater than the area in registered deed?
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-red">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input appl_applied_area" type="radio" name="appl_applied_area" id="appl_applied_area1" value="YES" <?=$checkEditedArea > 0 ? 'checked' : '' ?>/>
                                  <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input appl_applied_area" type="radio" name="appl_applied_area" id="appl_applied_area2" value="NO" <?=$checkEditedArea > 0 ? 'disabled' : '' ?>/>
                                  <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dag_table" style="display:<?=$checkEditedArea > 0 ? 'block' : 'none' ?>;">
                                <table class="datatable table table-stripped" id='datatable'>
                                    <thead>
                                        <tr style="font-size: 12px;">
                                            <th>#</th>
                                            <th>Dag No</th>
                                            <th>Bigha</th>
                                            <th>Katha</th>
                                            <th>Lessa/Chathak</th>
                                            <th>Ganda</th>
                                            <th>Kranti</th>
                                            <th>Edit Area</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i=1; foreach ($all_dags as $val) { ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$val->dag_no?></td>
                                                <td><?=$val->applied_b?></td>
                                                <td><?=$val->applied_k?></td>
                                                <td><?=$val->applied_lc?></td>
                                                <td><?=$val->applied_g?></td>
                                                <td>0</td>
                                                <td>
                                                    <!-- <button type="button" class="btn btn-sm btn-success">Edit Area</button> -->
                                                    <button type="button" id="editarea<?=$val->id?>" onclick="editAreaTeaGrantAtAdc(<?=$val->id?>, <?=$val->dag_no?>);" class="btn btn-sm btn-warning">Edit Area</button>
                                                </td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-red">
                              (2) Would you like to recalculate the premium ?
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-red">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input re_cal_prem" type="radio" name="re_cal_prem" id="re_cal_prem1" value="YES"/>
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input re_cal_prem" type="radio" name="re_cal_prem" id="re_cal_prem2" value="NO"/>
                                <label class="form-check-label" for="inlineRadio2">No</label>
                              </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div_zonal_calculation" style="display:none;">

                              <?php foreach($premium_data as $r) { ?>
                                <div class="row">
                                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Prev Zonal Value of Dag <?=$r->dag_no?>: 
                                    <input type="text" class="form-control" placeholder="Prev Zonal Value" readonly
                                    value="<?=$r->zonal_valuation?>" id="prev_zonal_value_<?=$r->dag_no?>">
                                  </div>

                                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    New Zonal Value of Dag <?=$r->dag_no?>
                                    <input type="text" class="form-control" placeholder="New Zonal Value" readonly
                                    value="<?=$this->utilityclass->getZonalValue($basic['dist_code'], $basic['uuid'], $r->dag_no)?>" 
                                     id="new_zonal_value_<?=$r->dag_no?>">
                                  </div>

                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <br>
                                    <button type="button" onclick="fetchFinalAMount('<?=$r->dag_no?>')" class="btn btn-sm btn-danger">Fetch</button>
                                  </div>

                                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    Total Amount of Dag <?=$r->dag_no?>
                                    <input type="text" class="form-control" id="total_amount<?=$r->dag_no?>" value="" readonly placeholder="Total Amount">
                                  </div>
                                </div>

                              <?php } ?>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div_zonal_calculation" style="display:none;">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">&nbsp;</div>

                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <br>
                                <button type="button" onclick="getFinalAMount()" class="btn btn-sm btn-danger">Get Total</button>
                              </div>

                              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                Final Amount
                                <input type="text" class="form-control" id="final_total_amount" value="" readonly placeholder="Final Total Amount">
                              </div>
                            </div>

                            

                        </div>
                    </div>
                </form>
            </div>

            <?php if($areaCheck == 1) { ?>

                <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
                    Total Area Recommended for Settlement can’t exceed available Area in Chitha !
                </h5>
                <br>
                
            <?php } else { ?>

                <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center">
                  <span id="error_message"></span>
                </h5>
                <br>
                <div class="modal-footer payment_cal_details" style="display:none;">
                  <button type="button" class="btn btn-primary btn-sm" id="generatePaymentNoticeTeaGrant">Generate Payment Notice</button>
                </div>
            <?php } ?>
            
        </div>
    </div>
</div>

<?php include(APPPATH."views/TeaGrant/common/editAreaTeaGrantAtAdcBeforePN.php"); ?>

<div id="payment_notice_render"></div>

<script type="text/javascript">

    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    $(document).ready(function(){
        $('#paymentNoticeModal').modal('show');
    });

    $("#closePremModal").on('click', function(){
        $('#paymentNoticeModal').modal('hide');
    });

    $(document).ready(function(){
      if($("input[name='appl_applied_area']:checked").length > 0 && $("input[name='re_cal_prem']:checked").length > 0) {
        $('.payment_cal_details').show();
      } else {
        $('.payment_cal_details').hide();
      }
    });

    $('#generatePaymentNoticeTeaGrant').on('click', function()
    {
      var final_amount       = $('#final_amount').val();
      var due_amount         = $('#due_amount').val();
      var case_no_notice     = $('#case_no_notice').val();
      var hearing_date_input = $('#hearing_date_input').val();
      var appl_applied_area  = $("input[name=appl_applied_area]:checked").val();
      var re_cal_prem        = $("input[name=re_cal_prem]:checked").val();
      var final_total_amount = $("#final_total_amount").val();

      if(re_cal_prem == 'YES')
      {
        if(final_total_amount == null || final_total_amount == '')
        {
          showErrorMessage("Click on get total button for final amount view of premium recalculation !!! ");
          return false;
        }
      }

      
      if(final_amount == null || final_amount == '')
      {
        showErrorMessage("Final Amount can not be empty !!! ");
        return false;
      }
      if(due_amount == null || due_amount == '')
      {
        showErrorMessage("Due Amount can not be empty !!! ");
        return false;
      }
      else if(case_no_notice == null || case_no_notice == '')
      {
        showErrorMessage("Manipulation done with case no !!! ");
        return false;
      }
      else if($("input[name='appl_applied_area']:checked").length == 0)
      {
        showErrorMessage("Please check the question 1: if area greater than the area alloted in Deed !!! ");
        return false;
      }
      else if($("input[name='re_cal_prem']:checked").length == 0)
      {
        showErrorMessage("Please check the question 2: if like to recalculate premium !!! ");
        return false;
      }

      $.blockUI({
        message: $('#displayBox'),
        css: {
          border:'none',
          backgroundColor:'transparent'
        }
      });
      
      const params = {
        final_amount       : final_amount,
        due_amount         : due_amount,
        case_no_notice     : case_no_notice,
        hearing_date_input : hearing_date_input,
        appl_applied_area  : appl_applied_area,
        re_cal_prem        : re_cal_prem,
        final_total_amount : final_total_amount,
      };

      $.ajax({
        url         : baseurl + "TeaGrantControllerAdc/generatePaymentNoticeTeaGrant",
        type        : "post",
        dataType    : "json",
        contentType : "application/json",
        success: function (data) 
        {
          $.unblockUI();

          if(data.responseType == 0) {
            $('#error_message').html(data.message);
            return;
          }
          else if(data.responseType == 2)
          {
            Swal.fire({
              icon              : 'warning',
              backdrop          : true,
              allowOutsideClick : false,
              text              : 'Kindly re-verify all details before proceeding. Once the Payment Notice is generated, you will have the option to save it. Please confirm if you wish to proceed with generating the Payment Notice.',
              showDenyButton    : true,
              confirmButtonText : 'Confirm',
              denyButtonText    : 'Cancel',
              customClass       : {
                actions         : 'my-actions',
                confirmButton   : 'order-2',
                denyButton      : 'order-3',
              },
            }).then((result) => {
              if (result.isConfirmed) {
                $('#paymentNoticeModal').modal('hide');
                $('#payment_notice_render').html(data.load_view);
              }
            });                        
          }
        },
        error: function(error) { // runtime error message
          showErrorMessage("Failed to generate Payment Notice. Kindly contant system administrator !!!");
        },
        data: JSON.stringify(params)
      });
    });

</script>

<script>
  function getDefaultDate() {
    let date = new Date();
    // Add 15 days
    date.setDate(date.getDate() + 15);

    // Keep adding 1 day if it's Sunday
    while (date.getDay() === 0) { // 0 = Sunday
      date.setDate(date.getDate() + 1);
    }

    // Set time to 10:00 AM
    date.setHours(10, 0, 0, 0);

    // Format to 'YYYY-MM-DDTHH:MM' (required for datetime-local input)
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');
    let hours = String(date.getHours()).padStart(2, '0');
    let minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

  // Set default value
  document.getElementById('hearing_date_input').value = getDefaultDate();

  var areaModal = document.getElementById("editAreaDetails");
  var spanArea  = document.getElementsByClassName("close-edit-area-adc")[0];

  function editAreaTeaGrantAtAdc(id, dag_no){

    $('#paymentNoticeModal').modal('hide');
    $('#editAreaDetails').modal('show');

    //****to display the modal */
    // areaModal.style.display = "block";
    //****to close the modal */
    spanArea.onclick = function() {
      Swal.fire({
        text              : 'Closing this modal without saving will erase any edited data ! Are you sure ?',
        icon              : 'warning',
        showCancelButton  : true,
        confirmButtonText : 'Yes',
        confirmButtonColor: "#B82929",
      }).then((result) => {
        if (result.isConfirmed) {
          $('#paymentNoticeModal').modal('show');
          $('#editAreaDetails').modal('hide');
        }
      })
    }
  
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == areaModal) {
        Swal.fire({
          text              : 'Closing this modal without saving will erase any edited data ! Are you sure ?',
          icon              : 'warning',
          showCancelButton  : true,
          confirmButtonText : 'Yes',
          confirmButtonColor: "#B82929",
        }).then((result) => {
          if(result.isConfirmed) {
            areaModal.style.display = "none";
          }
        })
      }
    }

    $('#edit_area_span_dag_no').html(dag_no);
    // $('#edit_area_span_patta_no').html(edit_area_span_patta_no);

    $('#area_update_id').val(id);
    $('#area_update_dag_no').val(dag_no);

    $('#area_update_case_no').val($.trim($('#case_no_notice').val()));

    var postData = {
      'id'      : id,
      'dag_no'  : dag_no,
      'case_no' : $.trim($('#case_no_notice').val()),
    };

    $.ajax({
      url  : baseurl+'TeaGrantControllerAdc/selectDagArea',
      type : "POST",
      data : postData,
      success: function(data) {
        arr = JSON.parse(data);

        // console.log(arr);

        $.unblockUI();
        if(arr.responseType == 0){
          Swal.fire({
            text              : arr.msg,
            icon              : 'error',
            confirmButtonText : 'OK',
          })
        }
        else{

          $('#total_bigha_in_dag').val(arr.appnData.dag_area_b);
          $('#total_katha_in_dag').val(arr.appnData.dag_area_k);
          $('#total_lessa_in_dag').val(arr.appnData.dag_area_lc);
          $('#total_ganda_in_dag').val(arr.appnData.dag_area_g);
          $('#total_kranti_in_dag').val(arr.appnData.dag_area_kr);

          $('#enc_bigha_home').val(arr.appnData.s_dag_area_b);
          $('#enc_katha_home').val(arr.appnData.s_dag_area_k);
          $('#enc_lessa_home').val(arr.appnData.s_dag_area_lc);
          $('#enc_ganda_home').val(arr.appnData.s_dag_area_g);
          $('#enc_kranti_home').val(arr.appnData.s_dag_area_kr);

          $('#area_update_urban_check').val(arr.appnData.is_urban);
        }
      }
    });
  }

  function updateTeaGrantAreaAtAdc()
  {
    const BARAK_VELLY           = ["21", "22", "23"];

    var area_update_id          = $.trim($('#area_update_id').val());
    var area_update_dag_no      = $.trim($('#area_update_dag_no').val());
    var area_update_urban_check = $.trim($('#area_update_urban_check').val());
    var area_update_case_no     = $.trim($('#area_update_case_no').val());
    var total_bigha_in_dag      = $.trim($('#total_bigha_in_dag').val());
    var total_katha_in_dag      = $.trim($('#total_katha_in_dag').val());
    var total_lessa_in_dag      = $.trim($('#total_lessa_in_dag').val());
    var total_ganda_in_dag      = $.trim($('#total_ganda_in_dag').val());
    var total_kranti_in_dag     = $.trim($('#total_kranti_in_dag').val());
    var enc_bigha_home          = $.trim($('#enc_bigha_home').val());
    var enc_katha_home          = $.trim($('#enc_katha_home').val());
    var enc_lessa_home          = $.trim($('#enc_lessa_home').val());
    var enc_ganda_home          = $.trim($('#enc_ganda_home').val());
    var enc_kranti_home         = $.trim($('#enc_kranti_home').val());

    //validation for the update

    if(area_update_id == ''){
        $("#area_update_id").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#area_update_id').focus();
        return false;
    }
    if(area_update_dag_no == ''){
        $("#area_update_dag_no").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#area_update_dag_no').focus();
        return false;
    }

    if(area_update_urban_check == ''){
        $("#area_update_urban_check").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#area_update_urban_check').focus();
        return false;
    }

    if(area_update_case_no == ''){
        $("#area_update_case_no").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#area_update_case_no').focus();
        return false;
    }

    if(total_bigha_in_dag == ''){
        $("#total_bigha_in_dag").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#total_bigha_in_dag').focus();
        return false;
    };
    if(total_katha_in_dag == ''){
        $("#total_katha_in_dag").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#total_katha_in_dag').focus();
        return false;
    };
    if(total_lessa_in_dag == ''){
        $("#total_lessa_in_dag").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#total_lessa_in_dag').focus();
        return false;
    };
    
    if(BARAK_VELLY.includes($('#dist_code').val())){
        if(total_ganda_in_dag == ''){
            $("#total_ganda_in_dag").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
              );
            $('#total_ganda_in_dag').focus();
            return false;
        };
        if(total_kranti_in_dag == ''){
            $("#total_kranti_in_dag").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
              );
            $('#total_kranti_in_dag').focus();
            return false;
        };
    }

    if(enc_bigha_home == ''){

        $("#enc_bigha_home").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
          );
        $('#enc_bigha_home').focus();
        return false;
    }
    if(enc_katha_home == ''){
        $("#enc_katha_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
        );
        $('#enc_katha_home').focus();
        return false;
    }
    if(enc_lessa_home == ''){
        $("#enc_lessa_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
        );
        $('#enc_lessa_home').focus();
        return false;
    }

    if(BARAK_VELLY.includes($('#dist_code').val())){
      if(enc_ganda_home == ''){
        $("#enc_ganda_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
        );
        $('#enc_ganda_home').focus();
        return false;
      }
      if(enc_kranti_home == ''){
        $("#enc_kranti_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
        );
        $('#enc_kranti_home').focus();
        return false;
      }
    }
 
    // prepare for updation
    var postData = {
      'area_update_id'          : area_update_id,
      'area_update_dag_no'      : area_update_dag_no,
      'area_update_urban_check' : area_update_urban_check,
      'area_update_case_no'     : area_update_case_no,
      'total_bigha_in_dag'      : total_bigha_in_dag,
      'total_katha_in_dag'      : total_katha_in_dag,
      'total_lessa_in_dag'      : total_lessa_in_dag,
      'total_ganda_in_dag'      : total_ganda_in_dag,
      'total_kranti_in_dag'     : total_kranti_in_dag,
      'enc_bigha_home'          : enc_bigha_home,
      'enc_katha_home'          : enc_katha_home,
      'enc_lessa_home'          : enc_lessa_home,
      'enc_ganda_home'          : enc_ganda_home,
      'enc_kranti_home'         : enc_kranti_home,
    };

    $.blockUI({
      message: $('#displayBox'),
      css: {
        border          : 'none',
        backgroundColor : 'transparent'
      }
    });
    
    $.ajax({
      url     : baseurl+'TeaGrantControllerAdc/updateAreaDetails',
      type    : "POST",
      data    : postData,
      success : function(data) 
      {
        arr = JSON.parse(data);
        $.unblockUI();
        if(arr.responseType == 0){
          Swal.fire({
            text: arr.msg,
            icon: 'error',
            confirmButtonText: 'OK',
          })
        }
        else
        {
          if(arr.responseType == 2)
          {
            Swal.fire({
              text              : arr.msg,
              icon              : 'success',
              confirmButtonText : 'OK',
            })
          }
          location.reload();
        }
      }
    });
  }

  $("input[name=appl_applied_area]").on("click", function () 
  {
    if($("input[name='re_cal_prem']:checked").length > 0) {
      $('.payment_cal_details').show();
    }
    else {
      $('.payment_cal_details').hide();
    }

    var appl_applied_area = $("input[name=appl_applied_area]:checked").val();
    if (appl_applied_area == "YES") {
      $('.dag_table').show();
    }
    else if (appl_applied_area == "NO") {
      $('.dag_table').hide();   
    }
  });


  $("input[name=re_cal_prem]").on("click", function () 
  {
    if( $("input[name=re_cal_prem]:checked").val() == 'YES')
    {
      $('.div_zonal_calculation').show();
      $('.payment_cal_details').show();
    }
    else
    {
      $('.div_zonal_calculation').hide();
      $('.change_prem_btn').hide();
      if($("input[name='appl_applied_area']:checked").val() == '') {
        $('.payment_cal_details').hide();
      }
      else {
        $('.payment_cal_details').show();
      }
    }
  });

  var premModal = document.getElementById("premiumModalAdc");

  function premiumModal(){
    premModal.style.display = "block";
  }

  $('.closePremium').click(function(){
    premModal.style.display = "none";
  })


  function fetchFinalAMount(dag_no)
  {
    case_no_notice   = $('#case_no_notice').val();
    new_zonal_value  = $('#new_zonal_value_'+dag_no).val();
    prev_zonal_value = $('#prev_zonal_value_'+dag_no).val();


    const params = {
      case_no_notice   : case_no_notice,
      new_zonal_value  : new_zonal_value,
      dag_no           : dag_no,
      prev_zonal_value : prev_zonal_value,
    };

    $.ajax({
      url         : baseurl + "TeaGrantControllerAdc/fetchTotalPayment",
      type        : "post",
      dataType    : "json",
      contentType : "application/json",
      success: function (data) 
      {
        if(data.responseType == 2)
        {
          $('#total_amount'+dag_no).val(data.finalamount);
          // $('#final_total_amount').val(data.totalAmount);
        }
        else
        {
          showErrorMessage("#1002: Failed to fetch data. Kindly contant system administrator !!!");
        }        
      },
      error: function(error) { // runtime error message
        showErrorMessage("#1006: Failed to fetch data. Kindly contant system administrator !!!");
      },
      data: JSON.stringify(params)
    });

  }


  function getFinalAMount()
  {
    const params = {
      case_no : $('#case_no_notice').val(),
    };

    $.ajax({
      url         : baseurl + "TeaGrantControllerAdc/getTotalPayment",
      type        : "post",
      dataType    : "json",
      contentType : "application/json",
      success: function (data) 
      {
        if(data.responseType == 2)
        {
          $('#final_total_amount').val(data.totalFinalAmount);
        }
        else
        {
          showErrorMessage("#1053: Failed to fetch data. Kindly contant system administrator !!!");
        }        
      },
      error: function(error) { // runtime error message
        showErrorMessage("#1057: Failed to fetch data. Kindly contant system administrator !!!");
      },
      data: JSON.stringify(params)
    });

  }


</script>