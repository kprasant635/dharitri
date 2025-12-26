<form id='formAjaxPost'>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Reclassification (<?=$_GET['app']?>)</kbd>
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
                      <center class="uni_text">Applicant Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          
                          <td>Applicant Name : </td>
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
                      <center class="uni_text">Reclass Information</center>
                      <table class="table">
                      	 <tr class="bg-primary">
                          <td>Old Land Class: </td>
                          <td>Applied Land Class: </td>
                          <td>Land Used for other Purpose </td>
                      	 </tr>
                         <?php $i=1; foreach($firstParty as $fp): ?>
                         <tr class="bg-success">
                          <td> <?=$this->utilityclass->getLandClassCode($fp->old_classification);?></td>
                          <td> <?=$this->utilityclass->getLandClassCode($fp->new_classification);?></td>
                          <td> <?=$fp->year_of_use;?></td>
                         </tr>
                         <?php endforeach; ?>
                      </table>
                      
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
                         </tr>
                      </table>
                       <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group">
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/basundhara/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
                          <?php endforeach; ?>
                        </ul>
                      <hr>

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
                      <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
                          <input type="hidden" class="form-control" name='dag_revenue' value="<?=$pattaNo->dag_revenue?>">
                          <input type="hidden" class="form-control" name='dag_local_tax' value="<?=$pattaNo->dag_local_tax?>">
                          <input type="hidden" class="form-control" name='sum' value="<?=$pattaNo->sum?>">

                          <div class="row">
                          <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_land_revenue'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="P_land" placeholder="Revenue" name="P_land_rev">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="p_loc_tax" placeholder="" name="p_local_tax" readonly>
                                </div>
                            </div>
                          </div>



                          <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5"> মাটিৰ পুন শ্ৰেণী পৰিবৰ্ত্তনৰ  বাবে ভূমিলেখ্য সহায়কৰ প্রতিবেদন দাখিল কৰা হ'ল ।</textarea>
                                    <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $lm->lm_name.", ";?><?php echo "ভূমিলেখ্য সহায়ক, "; ?></textarea>
                                    <!-- <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" > -->
                                </div>
                            </div>

                          <!-- <input type="text" placeholder="Proposed land revenue" class="form-control" name='patta_no' value=""> -->
                          <!-- <textarea class="form-control" name='remark' placeholder="Enter your remark"></textarea> -->
                          
                          
                           <center>
                          <span id='loading'></span><span id='msg'></span>
                          <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</form>


<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/basundhara/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
            <div class="modal-body">
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#agri").click(function () {
            $(".agri").show();
            $(".nonagri").hide();
        });
        $("#nonagri").click(function () {
            $(".agri").hide();
            $(".nonagri").show();
        });
    });
   function generate_dag() {
     
     
        var dag_no = $('#g_from_d').val();
        if (dag_no == '')
        {
            alert("Please Enter a Dag No..");
            exit();
        }
        $.ajax({
            url: baseurl + "LandReclassification/getDagDetJSON/" + dag_no,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }

                var dag = JSON.parse(data);
                $('#patta').val(dag[0].patta_no);
                $('#b').val(dag[0].dag_area_b);
        var b = dag[0].dag_area_b;
        //alert(b);
        $('#katha').val(dag[0].dag_area_k);
        var k = dag[0].dag_area_k;
        
      
                $('#l').val(parseFloat(dag[0].dag_area_lc));
        var l = dag[0].dag_area_lc;
        
        var totallessa= (parseFloat(l) + (parseFloat(k) * 20) + (parseFloat(b) * 100));
        var land_class_code = dag[0].land_class_code;
        //alert(land_class_code);
          $.ajax({
                    url: baseurl + "LandReclassification/getLandClassNameAgriJSON/" + land_class_code,
                    success: function (data) {
                        // if (debug) {
                            // console.log(data);
                        // }
                        var lot = JSON.parse(data);
          var agri_nonagri = lot[0].class_code_cat;
        //alert(agri_nonagri);
        if((totallessa>100)&&(agri_nonagri=='01')){
          $(".subm").hide();
          alert("Reclassification cannot be done because land area is more than one bigha");
                    
        }
        
        else{
          $(".subm").show();
        }
        
          }
          });
        
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(parseFloat(dag[0].dag_area_lc));
                $('#g').val(parseFloat(dag[0].dag_area_g));
                $('#k').val(dag[0].dag_area_kr);
                //$('#Patta_type').val(dag[0].patta_type_code);
                //$('#land_class').val(dag[0].land_class_code);
                var land_rev = dag[0].dag_revenue;
                var l_tax = dag[0].dag_local_tax;
                var total = parseFloat(land_rev) + parseFloat(l_tax);
                $('#p_land_revv').val(parseFloat(land_rev).toFixed(2));
                $('#loc_tax').val(parseFloat(l_tax).toFixed(2));
                $('#tot_rev').val(parseFloat(total).toFixed(2));
                var patta_code = dag[0].patta_type_code;
                //alert(patta_code);
                $.ajax({
                    url: baseurl + "LandReclassification/getPattaNameJSON/" + patta_code,
                    success: function (data) {
                        // if (debug) {
                            // console.log(data);
                        // }
                        var lot = JSON.parse(data);
                        var template = "<option selected disabled>Select Patta Type</option>";

                        for (var i = 0; i < lot.length; i++) {
                            template += "<option value='" + lot[i].type_code + "' selected>" + lot[i].patta_type + "</option>";
                        }
                        console.log(template);
                        $('select[name="patta_type"]').html(template);
                    }
                });

                var land_class_code = dag[0].land_class_code;
                $.ajax({
                    url: baseurl + "LandReclassification/getLandClassNameJSON/" + land_class_code,
                    success: function (data) {
                        // if (debug) {
                            // console.log(data);
                        // }
                        var lot = JSON.parse(data);
                        var template = "<option selected disabled>Select Land Class</option>";

                        for (var i = 0; i < lot.length; i++) {
                            template += "<option value='" + lot[i].class_code + "' selected>" + lot[i].land_type + "</option>";
                        }
                        console.log(template);
                        $('select[name="land_class"]').html(template);
                    }
                });

            }
        });
    }

</script>

<script type="text/javascript">
  $(document).ready(function(){
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'basundhara/reclassPost', 
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