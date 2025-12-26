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
                         <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                         অসম চৰকাৰ <br>
                         চক্ৰ বিষয়াৰ কাৰ্যালয়, <?=$this->utilityclass->getCircleName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'])?> ৰাজহ চক্ৰ <br> 
                         জিলা - <?=$this->utilityclass->getDistrictName($get_settlement_basic['dist_code'])?> <br><br>

                         প্ৰিমিয়ামৰ  জাননী<br>
                         <?=$pay_notice_date?>             
                         </div>
                      </div>
                     
                      <div class="row mt-4">
                         <div class="col-12 text-justify p-5">
                            প্ৰতি 
                            <b>
                               <?php 
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
                                  ?>
                               </b>  
                               পিতা/ স্বামী 
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
                            <br>
                            <br>

                           <?php $sentences = [];

                                foreach ($get_dag_details as $row) {
                                    $exist = trim($row->exist_land_class_name);
                                    $proposed = trim($row->proposed_land_class_name);

                                    $sentences[] = "{$exist} শ্ৰেণীৰ পৰা {$proposed}";
                                }

                                $final_text = implode(', ', $sentences);

                                $submission_date = date('Y-m-d', strtotime($get_settlement_basic['submission_date']));
                                $applid = $get_settlement_basic['applid'];
                                ?>


                            <p>
                                ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ৩.০ ৰ অধীনত 
                                <b>Reclassification Suite</b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভুক্ত ভূমি
                                <b><?= $final_text ?></b> 
                                শ্ৰেনীলৈ পৰিৱৰ্তনৰ বাবে <b><?= $submission_date ?></b> তাৰিখে আবেদন নং 
                                <b><?= $applid ?></b> দাখিল কৰিছে।
                            </p>
                            <br>
                            <br>

                            <table class="table table-bordered">
                               <tr>
                                  <th>জিলা</th>
                                  <th>ৰাজহ চক্ৰ</th>
                                  <th>মৌজা</th>
                                  <th>লাট</th>
                                  <th>গাওঁ</th>
                                  <th class="text-center">পট্টা নং</th>
                                  <th class="text-center">দাগ নং</th>
                                  <th>কালি</th>
                               </tr>

                            <?php

                               foreach($get_dag_details as $dags)
                               {
                                  $area_det = '';

                                  if($dags->co_is_partition=='Y' && $dags->co_is_full_partition=='N'){

                                  if (in_array($dags->dist_code, json_decode(BARAK_VALLEY)))
                                  {
                                     $area_det .= 'বি: '.$dags->co_area_b.' ক: '.$dags->co_area_k.' চ: '.$dags->co_area_lc.' গ: '.$dags->co_area_g;
                                  }
                                  else
                                  {
                                     $area_det .= 'বি: '.$dags->co_area_b.' ক: '.$dags->co_area_k.' লে: '.$dags->co_area_lc;
                                  }
                                  }
                                  else
                                  {
                                    if (in_array($dags->dist_code, json_decode(BARAK_VALLEY)))
                                      {
                                         $area_det .= 'বি: '.$dags->dag_area_b.' ক: '.$dags->dag_area_k.' চ: '.$dags->dag_area_lc.' গ: '.$dags->dag_area_g;
                                      }
                                      else
                                      {
                                         $area_det .= 'বি: '.$dags->dag_area_b.' ক: '.$dags->dag_area_k.' লে: '.$dags->dag_area_lc;
                                      }
                                  }
                                  ?>
                                  
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
                                     <td class="text-center"><?=$dags->patta_no?></td>
                                     <td class="text-center"><?=$dags->dag_no?></td>
                                     <td><?=$area_det?></td>
                                  </tr>
                                  
                                  <?php
                               }
                               ?>
                            </table>

                            <br>

                            আৱেদন পৰীক্ষাৰ অন্তত <?= date('Y-m-d', strtotime($get_settlement_basic['sdlac_date'])) ?> তাৰিখৰ জিলা পৰ্যায়ৰ সমিতি বৈঠকৰ সিদ্ধান্ত অনুসৰি  
                            <?php if($get_settlement_basic['dept_order_no']!=null && $get_settlement_basic['dept_order_date']!=null){?>
                            আৰু ৰাজহ আৰু দুৰ্যোগ ব্যৱস্থাপনা বিভাগ, অসম চৰকাৰৰ অধিসূচনা No.<?=$get_settlement_basic['dept_order_no']?> dtd <?=$get_settlement_basic['dept_order_date']?> অনুযায়ী 
                        <?php }?>
                             ভূমিৰ শ্ৰেণী পৰিৱৰ্তনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে ওপৰত উল্লেখ কৰা আপোনাৰ দখলত থকা তপচিলভূক্ত ভূমিৰ শ্ৰেণী পৰিৱৰ্তনৰ বাবে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ এই জাননীযোগে জনোৱা হল । 

                            <br><br>আপুনি আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ- <br><br><br>

                        <table class="table table-bordered" border="1" cellspacing="0" cellpadding="5">
                        
                            <tr>
                                <th>#</th>
                                <th>বৰ্ণনা</th>
                                <th>Zonal Value (per bigha)</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                                <th>মুঠ মূল্য</th>
                            </tr>
                            <!-- <tr>
                                <th> </th>
                            </tr> -->
                    
                        <tbody>
                            <?php
                            $i = 1;
                            $total_premium = 0;

                            foreach ($premium_data as $dags) {
                                $area_det = '';

                                if ($dags->co_is_partition == 'Y' && $dags->co_is_full_partition == 'N') {
                                    if (in_array($dags->dist_code, json_decode(BARAK_VALLEY))) {
                                        $area_det .= 'বি: ' . $dags->co_area_b . ' ক: ' . $dags->co_area_k . ' চ: ' . $dags->co_area_lc . ' গ: ' . $dags->co_area_g;
                                    } else {
                                        $area_det .= 'বি: ' . $dags->co_area_b . ' ক: ' . $dags->co_area_k . ' লে: ' . $dags->co_area_lc;
                                    }
                                } else {
                                    if (in_array($dags->dist_code, json_decode(BARAK_VALLEY))) {
                                        $area_det .= 'বি: ' . $dags->dag_area_b . ' ক: ' . $dags->dag_area_k . ' চ: ' . $dags->dag_area_lc . ' গ: ' . $dags->dag_area_g;
                                    } else {
                                        $area_det .= 'বি: ' . $dags->dag_area_b . ' ক: ' . $dags->dag_area_k . ' লে: ' . $dags->dag_area_lc;
                                    }
                                }

                                $total_premium += $dags->amount_dag;
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td>শ্ৰেণী পৰিৱৰ্তনৰ বাবে প্ৰিমিয়াম মূল্য (<?= $dags->rate ?>% of Zonal Value)</td>
                                    <td><?= $dags->zonal_valuation ?></td>
                                    <td class="text-center"><?= $dags->dag_no ?></td>
                                    <td class="text-center"><?= $area_det ?></td>
                                    <?php if(($dags->pr!=null) or ($dags->pr!=0)){?>
                                    <td class="text-center"><?= $dags->premium_without_penalty ?></td>
                                    <?php }else{?>
                                        <td class="text-center"><?= $dags->amount_dag ?></td>
                                    <?php }?>
                                </tr>
                                <?php if(($dags->pr!=null) or ($dags->pr!=0)){?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td rowspan="1">শ্ৰেণী পৰিৱৰ্তন জৰিমনা মূল্য</td>
                                    <td colspan="3">শ্ৰেণী পৰিৱৰ্তন প্ৰিমিয়ামৰ (<?= $dags->pr ?>X)</td>
                                    <td class="text-center bold"><?= $dags->amount_dag ?></td>
                                </tr>
                            <?php }?>
                            <?php } ?>
                            <tr>
                                <td colspan="5"><strong>মুঠ দিবলগীয়া প্ৰিমিয়াম</strong></td>
                                <td class="text-center"><strong><?= $premium_data[0]->due_amount ?></strong></td>
                            </tr>
                        </tbody>
                    </table>

                            <br>
                            <br>
                            <?php
                            $due_date = date('d/m/Y', strtotime('+15 days'));
                            ?>
                            সেইমৰ্মে আপোনাক সৰ্বমুঠ <?= $premium_data[0]->final_amount ?> টকাৰ প্ৰিমিয়াম অহা <?=$due_date?> ইং তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হ’ল।
                            <br>
                            <br>
                            চৰ্তাৱলী <br>
                            ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পিছতহে আৱেদনকাৰীৰ ভূমিৰ শ্ৰেণী পৰিৱৰ্তন কৰা হ’ব। 

                            
                            <br>
                            <br>
                            <b>আপোনাৰ প্রিমিয়াম Sewa Setu (https://sewasetu.assam.gov.in/) পৰ্টেলৰ পৰা পৰিশোধ কৰিব পাৰিব।</b>

                         </div>
                      </div>
                      <div class="row mt-5 justify-content-end mb-5">
                         <div class="col-5 text-center">
                            <b><?=$this->utilityclass->dcname($get_settlement_basic['dist_code'], $this->session->userdata('user_code'))?></b><br>
                            চক্ৰ বিষয়া <br> 
                            <?=$this->utilityclass->getCircleName($get_settlement_basic['dist_code'],$get_settlement_basic['subdiv_code'],$get_settlement_basic['cir_code'])?> ৰাজহ চক্ৰ
                         </div>
                      </div>
                   </div>
                </div>
                <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
                <?php if($premium_data[0]->final_amount!=0) {?>
                <button type="submit" id="print" class="btn btn-warning text-white">ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
                <?php }?>                
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

      $.blockUI({
        message: $('#displayBox'),
        css: {
          border:'none',
          backgroundColor:'transparent'
        }
      });
      
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

      $.ajax({
        url         : baseurl + "ReclassSuiteControllerCO/savePaymentNotice",
        type        : "post",
        dataType    : "json",
        contentType : "application/json",
        success: function (data) {

            // console.log(data);return;

          $.unblockUI();
          $('#paymentNoticeGenModal').modal('hide');
          if (data.responseType == 1)
          {
            showErrorMessage(data.message);
          }
          else if (data.responseType == 2)
          {                    
            showSuccessMessage(data.message);
            location.reload();
          }
          else
          {
            showErrorMessage("Something went wrong on submitting Payment Notice !!!");
          }
        },
        data: JSON.stringify(params)
      });
    }

    // $('#savePaymentNotice').on('click', function()
    // {
    //   var case_no            = $('#case_no').val();
    //   var district           = $('#district').val();
    //   var sub_division       = $('#sub_division').val();
    //   var circle             = $('#circle').val();
    //   var lot_no             = $('#lot_no').val();
    //   var mouza              = $('#mouza').val();
    //   var village            = $('#village').val();
    //   var pay_notice_gn_date = $('#pay_notice_gn_date').val();
    //   var amount             = $('#amount').val();
    //   var htmlstring_text    = $('#htmlstring_text').val();


    //   $.blockUI({
    //     message: $('#displayBox'),
    //     css: {
    //       border:'none',
    //       backgroundColor:'transparent'
    //     }
    //   });
      
    //   const params = {
    //     case_no            : case_no,
    //     district           : district,
    //     sub_division       : sub_division,
    //     circle             : circle,
    //     lot_no             : lot_no,
    //     mouza              : mouza,
    //     village            : village,
    //     pay_notice_gn_date : pay_notice_gn_date,
    //     amount             : amount,
    //     htmlstring_text    : htmlstring_text,
    //   };

    //   $.ajax({
    //     url         : baseurl + "TeaGrantControllerAdc/savePaymentNotice",
    //     type        : "post",
    //     dataType    : "json",
    //     contentType : "application/json",
    //     success: function (data) {

    //       $.unblockUI();
    //       $('#paymentNoticeGenModal').modal('hide');
    //       if (data.responseType == 1)
    //       {
    //         showErrorMessage(data.message);
    //       }
    //       else if (data.responseType == 2)
    //       {                    
    //         showSuccessMessage(data.message);
    //         load_data();
    //       }
    //       else
    //       {
    //         showErrorMessage("Something went wrong on submitting Payment Notice !!!");
    //       }
    //     },
    //     data: JSON.stringify(params)
    //   });
    // });

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














