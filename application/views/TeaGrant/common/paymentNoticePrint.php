<style type="text/css">
   /* Target the modal's content */
   .modal-content {
     width: 500%; /* Adjust this value as needed */
     max-width: 100%; /* Prevents it from exceeding the viewport width */
     margin: auto; /* Centers the modal horizontally */
   }

   /* Optional: Adjust padding or borders to fit the new width */
   .modal-body {
     padding: 20px;
   }

</style>

<div class="modal" role="dialog" id="paymentNoticeGenModal">
    <div class="modal-dialog" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >                

                <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">

                <input type="hidden" name="district" id="district" value="<?=$this->utilityclass->getDistrictName($get_settlement_basic['dist_code'])?>">

                <input type="hidden" name="sub_division" id="sub_division" value="<?=$this->utilityclass->getSubDivName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'])?>">

                <input type="hidden" name="circle" id="circle" value="<?=$this->utilityclass->getCircleName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'])?>">

                <input type="hidden" name="lot_no" id="lot_no" value="<?=$this->utilityclass->getLotName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'],$get_settlement_basic['mouza_pargona_code'],$get_settlement_basic['lot_no'])?>">

                <input type="hidden" name="mouza" id="mouza" value="<?=$this->utilityclass->getMouzaName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'],$get_settlement_basic['mouza_pargona_code'])?>">

                <input type="hidden" name="village" id="village" value="<?=$this->utilityclass->getVillageName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'],$get_settlement_basic['mouza_pargona_code'],$get_settlement_basic['lot_no'],$get_settlement_basic['vill_townprt_code'])?>">

                <input type="hidden" name="pay_notice_gn_date" id="pay_notice_gn_date" value="<?=$pay_notice_date?>">

                <input type="hidden" name="amount" id="amount" value="<?=$premium_data[0]->due_amount?>">

                <div id="printableArea">
                   <div class="container bg-white shadow" id="print_direct">

                      <div class="row mt-5 text-center">
                        <div class="col-12">
                          <div class="text-center" style="font-size: 18px; font-weight:bold;">
                            অসম চৰকাৰ<br>                              
                            অতিৰিক্ত জিলা উপায়ুক্তৰ কাৰ্যালয়<br>
                            জিলা- <?=$this->utilityclass->getDistrictName($get_settlement_basic['dist_code'])?>
                          </div>
                          <br>
                          <div class="text-center" style="font-size: 15px;">
                            প্ৰিমিয়ামৰ  জাননী <br>
                            <span style="font-weight:bold;"><?=date('d/m/Y')?></span>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-12 text-justify p-5">
                          প্ৰতি: <b><?php 
                            $position = 0;
                            $length = count($get_buyers);
                            foreach($get_buyers as $app){
                                  if($position == $length - 1){
                                        echo $app->pdar_name;
                                  }elseif($position == $length - 2){
                                        echo $app->pdar_name.' আৰু ';
                                  }else{
                                        echo $app->pdar_name.', ';
                                  }
                                  $position++;
                               }
                            ?> </b> <br>পিতা/ স্বামী 
                            <b>
                              <?php 
                                $position = 0;
                                $length = count($get_buyers);

                                foreach($get_buyers as $app){
                                  if($position == $length - 1){
                                    echo $app->pdar_guardian;
                                  }elseif($position == $length - 2){
                                    echo $app->pdar_guardian.' আৰু ';
                                  }else{
                                    echo $app->pdar_guardian.', ';
                                  }
                                  $position++;
                                }
                              ?> 
                            </b>

                            <br><br>

                            ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ৩. ০ ৰ অধীনত Limited Conversion of Tea Grant Land to Periodic Patta সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভূক্ত ভূমিৰ বাবে  <b><?=$date_of_application?></b> তাৰিখে আবেদন নং <b><?=$get_settlement_basic['applid']?> (<?=$case_no?>)</b> দাখিল কৰিছে।
                            <br><br>


                            <table class="table table-bordered">
                              <tr>
                                <th>জিলা</th>
                                <th>ৰাজহ চক্ৰ</th>
                                <th>মৌজা</th>
                                <th>লাট নং</th>
                                <th>গাওঁ</th>
                                <th class="text-center">পট্টা নং</th>
                                <th class="text-center">পট্টা প্ৰকাৰ</th>
                                <th>দাগ নং</th>
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

                            আৱেদন পৰীক্ষাৰ অন্তত  

                            <?php if($get_dag_details[0]->is_urban == 'Y') { ?>
                                আৰু ৰাজহ আৰু দুৰ্যোগ ব্যৱস্থাপনা বিভাগ, অসম চৰকাৰৰ অধিসূচনা No. <b><?=$get_settlement_basic['dept_order_no']?></b> dtd <b><?=date('d/m/Y', strtotime($get_settlement_basic['dept_order_date']))?></b> অনুযায়ী 
                            <?php } ?>

                            চাহ অনুদান/ চাহ ম্যাদী পট্টা ভূমি ম্যাদী পট্টালৈ পৰিৱৰ্তনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে ওপৰত উল্লেখ কৰা আপোনাৰ দখলত থকা তপচিলভূক্ত ভূমিৰ ম্যাদী পট্টালৈ পৰিৱৰ্তনৰ বাবে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ এই জাননীযোগে জনোৱা হল । 

                            <br><br>

                            আপুনি আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ-

                            <br><br>

                            <table class="table table-bordered">
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

                               <tr>
                                  <th colspan="5">মুঠ দিবলগীয়া প্ৰিমিয়াম</th>
                                  <th class="text-right"><?=$premium_data[0]->due_amount?></th>
                               </tr>
                            </table>

                            সেইমৰ্মে আপোনাক সৰ্বমুঠ <b><?=$premium_data[0]->due_amount?></b> টকাৰ প্ৰিমিয়াম অহা <b><?=date('d/m/Y', strtotime('+15 days'))?></b> ইং তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হ’ল। 
                            <br><br>

                            

                            <u>প্ৰযোজ্য চৰ্তাৱলী </u><br>
                            ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পাছতহে আৱেদনকাৰীক ভূমি ম্যাদী পট্টালৈ পৰিৱৰ্তন কৰা হ’ব। 
                            <br><br>

                            <u>চৰকাৰী অধিসূচনা </u><br>
                            ১) eCF No.565802/I/777761/2024 Dated Dispur, the 20-10-2024<br>
                            ২) eCFNo.565802/I/777772/2024 Dated Dispur, the 20-10-2024

                            <br><br>

                            <b>আপোনাৰ প্রিমিয়াম Sewa Setu (https://sewasetu.assam.gov.in/) পৰ্টেলৰ পৰা পৰিশোধ কৰিব পাৰিব।</b>

                        </div>
                      </div>


                      <div class="row mt-5 justify-content-end mb-5">
                         <div class="col-5 text-center">
                            <b><?=$this->utilityclass->dcname($get_settlement_basic['dist_code'], $this->session->userdata('user_code'))?></b><br>
                            অতিৰিক্ত জিলা উপায়ুক্ত <br> 
                            <?=$this->utilityclass->getDistrictName($get_settlement_basic['dist_code'])?>
                         </div>
                      </div>
                   </div>
                </div>
                <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>
                <input type="hidden" id="appl_applied_area" value="<?=$appl_applied_area?>">
                <input type="hidden" id="re_cal_prem" value="<?=$re_cal_prem?>">

            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
              <button type="type" id="print" class="btn btn-warning text-white" >ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক</button>                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   
   $(document).ready(function(){
        $('#paymentNoticeGenModal').modal('show');
    });

    $("#closeModal").on('click', function(){
        $('#paymentNoticeGenModal').modal('hide');
    });

    function savePaymentNotice()
    {
      var case_no            = $('#case_no').val();
      var district           = $('#district').val();
      var sub_division       = $('#sub_division').val();
      var circle             = $('#circle').val();
      var lot_no             = $('#lot_no').val();
      var mouza              = $('#mouza').val();
      var village            = $('#village').val();
      var pay_notice_gn_date = $('#pay_notice_gn_date').val();
      var amount             = $('#amount').val();
      var htmlstring_text    = $('#htmlstring_text').val();
      var appl_applied_area  = $('#appl_applied_area').val();
      var re_cal_prem        = $('#re_cal_prem').val();      
      
      const params = {
        case_no            : case_no,
        district           : district,
        sub_division       : sub_division,
        circle             : circle,
        lot_no             : lot_no,
        mouza              : mouza,
        village            : village,
        pay_notice_gn_date : pay_notice_gn_date,
        amount             : amount,
        htmlstring_text    : htmlstring_text,
      };

      Swal.fire({
        icon              : 'warning',
        backdrop          : true,
        allowOutsideClick : false,
        text              : 'Please ensure all details are thoroughly verified before proceeding. Once the ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক button is clicked, the action cannot be undone. Do you confirm saving this Payment Notice?',
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
          $.blockUI({
            message: $('#displayBox'),
            css: {
              border:'none',
              backgroundColor:'transparent'
            }
          });
          $.ajax({
            url         : baseurl + "TeaGrantControllerAdc/savePaymentNotice",
            type        : "post",
            dataType    : "json",
            contentType : "application/json",
            success: function (data) {

              $.unblockUI();
              $('#paymentNoticeGenModal').modal('hide');
              if (data.responseType == 1)
              {
                showErrorMessage(data.message);
              }
              else if (data.responseType == 2)
              { 
                Swal.fire({
                  backdrop          : true,
                  allowOutsideClick : false,
                  text              : data.message,
                  confirmButtonText : 'OK',
                  customClass       : {
                    actions         : 'my-actions',
                    confirmButton   : 'order-2',
                  }
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload(true);
                    // showSuccessMessage(data.message);
                    // load_data();
                  }
                });
              }
              else
              {
                $.unblockUI();
                showErrorMessage("#497: Failed to Save Payment Notice. Kindly contant system administrator !!!");
              }
            },        
            error: function(error) { // runtime error message
              $.unblockUI();
              showErrorMessage("#501: Failed to Save Payment Notice. Kindly contant system administrator !!!");
            },
            data: JSON.stringify(params)
          });
        }
      });
    }

    // -js- base64 conversion to save notice file
    $( "#print" ).click(function() {           
      var htmlString =$( "#printableArea" ).html();
      var htmlString = b64EncodeUnicode(htmlString);   
      $( "#htmlstring_text" ).text( htmlString );
      savePaymentNotice();
    });

    function b64EncodeUnicode(str) {    
      return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
          return String.fromCharCode('0x' + p1);
      }));
    }
   
</script>














