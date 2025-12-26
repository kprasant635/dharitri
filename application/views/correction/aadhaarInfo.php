                        
                       
             
<style type="text/css">
  .mrl{
    margin-left: 47px;
  }
</style>
<?php if(isset($selfDecData) && ($selfDecData[0]!= null || !empty($selfDecData[0]))){
  ?>  
  <div class="row">
  <div class="col-lg-9"> 
    <table class="table_border table">
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
       </thead>
      </table>
    </div>

    <div class="col-lg-3"> 
      <div class="card text-center" >
          <p class="text-center" style="font-weight: bold;color:#ff681d">Aadhaar/PAN Information</p>

          <?=$base64_decoded_adhar_file?>
        <div class="card-body text-center">
          <h5><?=$engName?></h5>
          <p class="card-text"><b style="color:#2ea917"> <?=$status?></b></p>
        </div>
      </div>
    </div>
  </div>

    <?php  } ?>