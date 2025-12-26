<form id='formAjaxPost'>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Name Correction (<?=$_GET['app']?>)</kbd>
                        </h3>
                    </div>
                    <div class="panel-body">

                      <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
                          <input type="hidden" class="form-control" name='dag_revenue' value="<?=$pattaNo->dag_revenue?>">
                          <input type="hidden" class="form-control" name='dag_local_tax' value="<?=$pattaNo->dag_local_tax?>">
                       <!--    <input type="hidden" class="form-control" name='land_class_code' value="<?=$pattaNo->land_class_code?>"> -->

                      <table class="table table-striped table-bordered">
                        <tr>
                          <td>District Name: <?=$this->utilityclass->getDistrictName($app->dist_code)?></td>
                          <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?></td>
                          <td>Circle Name: <?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?></td>
                        </tr>
                        <tr>
                          <td>Mouza Name: <?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?></td>
                          <td>Lot Name: <?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no)?></td>
                          <td>Village Name: <?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?></td>
                        </tr>
                      </table>
                      <div class="container">
                        <!-- Aadhaar consent Self--- -->
                                <?php include 'application/views/common/aadhar_details_dhar_end.php'; ?>
                    
                      </div>
                      <center class="uni_text">Land Area Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No:  </td>
                          <td>Patta Type: </td>
                          <td>Patta No: </td>
                          <td>Total Area: </td>
                          <td>Revenue </td>                          
                         </tr>
                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code)?> </td>
                          <td><?=$pattaNo->patta_no?> </td>
                          <td><?=$app->area_b;?>B-<?=$app->area_k;?>K-<?=$app->area_l;?>L </td>
                          <td><i class="fa fa-rupee"></i> <?=number_format($pattaNo->dag_revenue,2);?>+<?=number_format($pattaNo->dag_local_tax,2)?> = <?=number_format($pattaNo->sum,2);?> </td>
                          
                      </table>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Original Land Area: </td>
                          <td>Bigha: <?=$app->area_b ;?></td>
                          <td>Katha: <?=$app->area_k ;?></td>
                          <td>Lessa: <?=$app->area_l ;?></td>
                         </tr>                         
                      </table>
                      <center class="uni_text">Name correction</center>
                      <table class="table">
                         <tr class="bg-primary">                         
                          <td>Old Name : </td>
                           <td>Guardian Name: </td>
                           <td>Guardian Relation</td>
                           <td>Mobile</td>
                         </tr>                        
                         <tr class="bg-success">
                          <?php $i=1; foreach($secParty as $sp): ?>
                          <td> <?=$sp->name_ass ;?></td>
                          <td> <?=$sp->gurdian_name_ass ;?></td>
                          <td> <?=$sp->guard_rel_desc_as."(".$sp->guard_rel_desc.")";?></td>
                          <td><?=$sp->mobile ;?></td>
                         </tr>
                        <?php endforeach; ?> 
                      </table>
                      <table class="table">
                         <tr class="bg-primary">                         
                          <td>Applied Name in English: </td>
                           <td>Applied Name in Assamese: </td>
                         </tr>
                         <tr class="bg-success">
                          <?php $i=1; foreach($firstParty as $fp): ?>
                          <td> <?=$fp->pat_name_eng ;?></td>
                          <td> <?=$fp->pat_name_ass ;?></td>                        
                         </tr>
                         <?php endforeach; ?>
                      </table>
                      <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group">
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
                          <?php endforeach; ?>
                        </ul>
                      <hr>
                       <!-- <div class="col-lg-3">
                                    <select class="form-control" name="official" required="" >
                                        <option selected disabled>Address to officer</option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u['user_code']; ?>"><?php echo $u['co_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                        </div> -->


                        <?php if($query){
                          echo "<center class='uni_text text-danger'>All Query</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                          foreach($query as $q){
                            ?>
                              <tr>
                                <td><?=$q->date_of_query?></td>
                                <td><?=$q->query_text?></td>
                                <td><?=$q->date_of_reply?></td>
                                <td><?=$q->reply_text;
                                  if($q->app_doc_id){ 
                                echo "<br>";
                                echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                              }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                        <input type="hidden" class="form-control" name='app_id' value="<?=$app->id?>">
                        <div class="form-group row">
                            <span class="col-lg-6 uni_text red">Do you want to allow re-apply for the rejected application ? </span>
                            <div class="col-lg-6">
                            <label class="checkbox-inline"><input type="radio" checked name='allow_reapply' value="Y"> Yes </label>
                            <label class="checkbox-inline"><input type="radio" name='allow_reapply' value="N"> No</label>
                            </div>
                        </div>
                        <div class="form-group ">
                        <span class="col-lg-3 uni_text">Enter your Remark</span>
                        <textarea class="form-control col-lg-9" rows="5" id='reapply_remark' name='reapply_remark'></textarea>
                        </div>
                        <br>
                        <hr>   
                        <span id='loading'></span><span id='msg'></span>
                        <center>
                          <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Submit</button>&nbsp;
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script type="text/javascript">
  $(document).ready(function(){
  
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    if($("#reapply_remark").val().trim().length < 1)
    {
      alert("Please Enter Your Remark");
      return; 
    }
    var formData = $(this).serialize();

        $.ajax({
            type        : 'POST', 
            url         : baseurl+'rtps/adcApproveReject', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                    },
            success: function(data){
              console.log(data);
              if(data.success!=null){
                //alert('hai');
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
              }else if(data.error!=null){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
              }
            },
        });
    });
});
</script>