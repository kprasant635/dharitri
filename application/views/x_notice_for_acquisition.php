
   <body style="background: none !important;">
      <style type="text/css">
         .navbar {
         position: relative;
         min-height: 20px;
         margin-bottom: 0px !important; 
         border: 1px solid transparent;
         border-radius: 0px !important;
         } 
         /* table.dataTable tbody th, table.dataTable tbody td {
         font-size: 1.2em !important
         } */
      </style>


      <form action="<?php echo base_url()?>index.php/SettlementInstitutionCo/savePaymentNotice" method="post" enctype='multipart/form-data'>

         <input type="hidden" name="case_no" value="<?=$case_no?>">
         <input type="hidden" name="remark" value="<?=$remark?>">
         <input type="hidden" name="district" value="<?=$this->utilityclass->getDistrictName($get_settlement_basic->dist_code)?>">
         <input type="hidden" name="sub_division" value="<?=$this->utilityclass->getSubDivName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code)?>">
         <input type="hidden" name="circle" value="<?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>">
         <input type="hidden" name="lot_no" value="<?=$this->utilityclass->getLotName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no)?>">
         <input type="hidden" name="mouza" value="<?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?>">
         <input type="hidden" name="village" value="<?=$this->utilityclass->getVillageName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code,$get_settlement_basic->lot_no,$get_settlement_basic->vill_townprt_code)?>">
         <input type="hidden" name="pay_notice_gn_date" value="<?=$pay_notice_date?>">

        
        

        <div id="printableArea">
        
           <div class="bg-white shadow" id="print_direct">
           <style>
            table {
                  width: 100%;
                  max-width: 100%;
                  margin-bottom: 1rem;
            }

            table th,
            table td {
            padding: 0.40rem;
            /* vertical-align: top; */
            border: 1px solid #191919;
            }

         </style>
               <div style="position: absolute;right:10px; margin-top: 15px;">
                    <?php 
      
                      // $dataqr = explode(",", $qrcode);
                      // $dataqr = $dataqr[1];
                      // echo '<img class="img-fluid" src="data:image/png;base64,' . $dataqr . '" />';
                      ?>
               </div>
               <div class="row mt-5 text-center">
                 <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;text-align: center;">
                    ANNEXURE - I
                    <br>
                     <br>
                   FORM X <br>
                   (See Section 7-A of the Assam Fixation of Ceiling on Land Holdings Act, 1956)
                    <br> <br>
                    জিলা- <?=$dist_name?>
                    <br> <br>
                    **NOTICE OF ACQUISITION**<br>
                     <br>
                      <br>
                    <?=$date?>
                  </div>
               </div>
               <div class="row mt-4">
                 <div class="col-12 text-justify p-5">
                   Whereas the land described in the Schedule below situated within the labour lines of the tea estate specified is required to be acquired under Section 7-A of the Assam Fixation of Ceiling on Land Holdings Act, 1956 (as amended), notice is hereby given that the said land with schedule as shown below is proposed to be acquired.
                    <br>
                    <br>
                    <br>

                    All persons interested in the said land may submit claims and objections in writing to the undersigned within fifteen (15) days from the date of this notice.
                    <br>
                    <br>

                    Schedule:
                    1. Name of Tea Estate: <?=$get_settlement_basic->tea_estate_name;?>
                    <br>
                    2. Revenue Circle and Mauza: <?=$this->utilityclass->getCircleName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code)?>, <?=$this->utilityclass->getMouzaName($get_settlement_basic->dist_code,$get_settlement_basic->subdiv_code,$get_settlement_basic->cir_code,$get_settlement_basic->mouza_pargona_code)?>
                    <br>
                   
                    <table>
                        <tr>
                           <td colspan="3" style="text-align:center;"><b>Area Information</b></td>
                        </tr>
                        <tr>
                           <th>Patta No.</th>
                           <th>Patta Type</th>
                           <th>Dag No.</th>
                           <th>Proposed Area</th>
                        </tr>
                       
                        <?php
                        foreach ($dags as $key => $value) { ?>
                        <tr>
                           <td><?=$value->patta_no?></td>
                           <td><?=$this->utilityclass->getPattaName($value->patta_type_code); ?></td>
                           <td><?=$value->dag_no?></td>
                           <td><?=$value->bigha."B-".$value->katha."K-".$value->lessa."L";?></td>
                        </tr>
                          <?php }
                       ?>
                       </table>
                    <br>
                    
                    <br>
                    Name of Owner/Lessee:  <?=$get_settlement_basic->tea_estate_name;?>

                    <br>
                    <br>
                    <br>
                    <br>
                 </div>
              </div>
              <div class="row mt-5 justify-content-end mb-5" style="text-align: right;">
                 <div class="col-2 text-center">
                 <b><?=$this->utilityclass->dcname($get_settlement_basic->dist_code, $this->session->userdata('user_code'));?></b><br>District Commissioner<br> 
                     <?=$this->utilityclass->getDistrictName($get_settlement_basic->dist_code)?>
                 </div>
              </div>
              <br>
              
           </div>
        </div>
        <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>

     </form>



      

      
