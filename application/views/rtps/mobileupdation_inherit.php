<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Application of <kbd>MOBILE NUMBER UPDATION  (<?=$_GET['app']?>)</kbd>
                        </h3>
                    </div>
                    <div class="panel-body">
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
                      <center class="uni_text">First Party Information</center>
                      <table class="table">
                      	 <tr class="bg-primary">
                      	 	<td>Sl No </td>
                            <td>Dag No </td>
                          <td>Name </td>
                          <td>Gurdian </td>
                          <td>Update Mobile </td>
                          <td>Old Mobile </td>
                      	 </tr>
                         <?php $i=1; foreach($firstParty as $fp): ?>
                         <tr class="bg-success">
                          <td><?=$i++?></td>
                          <td><?=$app->dag_no;?></td>
                          <td> <?=$fp->name_ass;?></td>
                          <td> <?=$fp->gurdian_name_ass;?></td>
                          <td> <?=$fp->new_mobile?></td>
                          <td><?=$fp->old_mobile?></td>
                         </tr>
                         <?php endforeach; ?>
                      </table>
                       <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group" style='margin-bottom: 10px'>
                          <?php foreach($document as $d): ?>
                           <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
                          <?php endforeach; ?>
                        </ul>
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
                          <!--  <center><button type="submit" class="btn btn-info">Submit</button></center> -->
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