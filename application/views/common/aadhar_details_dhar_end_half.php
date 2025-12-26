<div class="row d-flex justify-content-center"> 
<?php if(isset($selfDecData) && ($selfDecData[0]!= null || !empty($selfDecData[0]))){
  ?>   
    <!-- <table class="table_border table">
      <thead>
        <tr>
          <th colspan="4" style="text-align:center;">Self Declaration Details</th>
        </tr>
         <?php foreach($selfDecData[0] as $val){ ?>
            <tr>
              <td><?=$val->name?></td>
              <td><?=$val->status == 1 ? 'Yes' : 'No';?></td>
            </tr>

         <?php } ?>
      </table> -->

    <?php  } if(isset($aadhaarData) && isset($aadhaarData->auth_type) && isset($aadhaarData->is_applicant) && $aadhaarData->auth_type != null && $aadhaarData->is_applicant == 1): ?>
              <table class="table_border table">
                <thead>
                  <tr>
                    <th colspan="4" style="text-align:center;">Aadhaar / PAN Information</th>
                  </tr>
                  <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Verified/Not Verified</th>
                  </tr>
                  <tr>
                    <td><?php
              $state = '';
               if($aadhaarData->auth_type == "PAN"){ 
                  $state = 'PAN'; 
                  $alert = "green";
                  $title ="PAN Verified <i class='fa fa-check'></i>";?>
                  
                  <img src="<?php echo  base_url().'application/views/img/no-image.png' ?>" alt="Aadhar Image" class="img-fluid" style="width: 128px; border-radius: 10px;">
                  
              <?php }else if($aadhaarData->auth_type == "AADHAAR"){
                  $state = 'Aadhaar';
                  $alert = "green"; 
                  $title ="Aadhaar Verified <i class='fa fa-check'></i>";?>
                  
                  <?php if(AADHAAR == 1) :?>
                    <?php echo "<img src='data:image/jpeg;base64," . $aadhaarPhoto . "' class='img-thumbnail' alt='Aadhaar Photo' width='170' height='200'>"; ?>
                  <?php else :?>
                      <img src="<?php echo  base_url().'img/dummy.png' ?>" alt="Aadhar Image" class="img-fluid" style="width: 128px; border-radius: 10px;">
                    <?php endif;?>
                      
              <?php }else{
                  $state = "Aadhaar/PAN";
                  $alert = "red";
                  $title = "Aadhaar/PAN Not Verified  <i class='fa fa-times'></i>";?>
                  <!-- <input type="hidden" name="aadhaar_no" value="">
                  <input type="hidden" name="dob" value=""> -->
              <?php } ?></td>
              <td><?php 
            if(isset($aadhaarData->pat_name_eng)){
              echo $aadhaarData->pat_name_eng; 
            } ?></td>
            <td><?php 
            if(isset($aadhaarData->dob)){
              echo date("d-m-Y", strtotime($aadhaarData->dob) );
            } ?></td>
            <td>
              <div class="d-flex pt-1" style="font-size: 19px;">
              <b style="color:<?=$alert?>"><?=$title;?> </b>
            </div>
            </td>
                  </tr>
                </thead>
              </table>
             <?php endif; ?> 
            
        
</div>