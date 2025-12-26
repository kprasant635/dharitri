<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Disable this User?'))
            return (false);
        return (true);
    }
    function Confadd() {
        if (!confirm('Really want to Enable this User?'))
            return (false);
        return (true);
    }
    function mappedcircle(x){
        alert(x);
        console.log(x);
    }
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <?php 
                    $user_desig_code=$this->session->userdata('user_desig_code');

                    if($user_desig_code=='ADC'){
                        echo '<h2 style="text-align: center;">All Circle officers and Branch officers Enabled Accounts</h2>';
                    } 

                    elseif ($user_desig_code=='DC') {
                         echo '<h2 style="text-align: center;">All ADCs Enabled Accounts</h2>';
                    }

                    ?>

                    <!-- <h2 style="text-align: center;">All Circle officers and Branch officers Enabled Accounts</h2> -->
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('users'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE :Click on <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span> 
                                    button to Disable User Account and <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style='color: green;'></span> button to Enable User Accounts.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <table id="example" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td class="bold">Status</td>
                                    <td class="bold">Full Name</td>
                                    <td class="bold">Login Name</td>
                                    <td class="bold">Password</td>
                                    <td class="bold">Designation</td>
                                    <td class="bold">Edit</td>                                    
                                    <td class="bold"><?php echo $this->lang->line('action'); ?></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // var_dump($user_details);
                                if(empty($user_details))
                                {
                                    ?>
                                    <td colspan='7'>No Results Found. Select the location above.</td>
                                    <?php
                                }
                                else
                                {
                                    foreach ($user_details as $c) {
                                    if($c==null)
                                        continue;
                                    if ($c['lot_no'] == '00') {
                                        $lot = '';
                                    } else {
                                        $lot_name=$this->utilityclass->getLotLocationName($c['dist_code'], $c['subdiv_code'], $c['cir_code'],$c['mouza_pargona_code'],$c['lot_no']);
                                        $lot = ', Lot : ' . $lot_name;
                                    }
                                    if ($c['mouza_pargona_code'] == '00') {
                                        $mouza_pargona_code = '';
                                    } else {
                                        $mouza_pargona_code = $this->utilityclass->getMouzaName($c['dist_code'], $c['subdiv_code'], $c['cir_code'],$c['mouza_pargona_code']);
                                    }
                                    if ($c['status'] == 'E') {
                                        $status = "<span style='color:green;'>Enabled</span>";
                                    } else {
                                        $status = "<span style='color:red;'>Disabled</span>";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $status; ?></td>
                                        <td><?php echo $c['name'];
                                         
                                         ?></td>
                                        <td><?php echo $c['primary_login'];
                                                  echo "<br><kbd class='bg bg-primary'>";
                                                  echo  ($c['type']=='O') ? 'স্থায়ী' : (($c['type']=='A') ? '<i class = \'fa fa-edit bg-danger\'></i> সংলগ্ন' : 'আনৰ শ্হলত');
                                                  echo "</kbd>";
                                         ?></td>
                                        <td><?php echo "*****"//$c['password']; ?></td>
                                        <td><?php echo $c['desig'];
                                        echo "<hr>";
                                        echo $cirName= $this->utilityclass->getCircleName($c['dist_code'], $c['subdiv_code'], $c['cir_code']);

                                         ?></td>
                                        <td style="cursor:pointer;">
                                        <?php if($c['user_desig_code']=='SDLC'){  ?>
                                        <center><a href="#" data-id="<?=$c['primary_login']?>" class='confirm'><i class="fa fa-edit" title="Edit Account"></i></a></center>   
                                        <?php 
                                        }
                                        // else if($c['type']=='A' && $c['user_desig_code']=='ADC')
                                        // { 
                                           // echo "<center><code>". $result= $this->utilityclass->getAdcMapping($c['user_code']) ."</code></center>";
                                        else if($c['user_desig_code']=='CO'){
                                        ?>
                                            <code onclick='mappedcircleModal("<?=$c['user_code']?>","<?=$c['dist_code']?>","<?=$c['subdiv_code']?>","<?=$c['cir_code']?>")'>Assign Lot(s)</code>
                                            <!-- //update mobile no======= -->
                                            <?php if(MOBILENO_UPDATE_IN_SUPERIOR_LOGIN == 1 ){ ?>

                                                <a href="<?php echo base_url() . 'index.php/initialization/edit_mobile_details?user_code=' . $c['user_code'] . '&dist_code=' . $c['dist_code'] . '&subdiv_code=' . $c['subdiv_code'] . '&cir_code=' . $c['cir_code'] . '&mouza_pargona_code=' . $c['mouza_pargona_code'] . '&lot_no=' . $c['lot_no'] ?>" title="Disable User">Update mobile no</a>
                                            <?php } ?>
                                            <!-- //end mobile no update -->


                                        <?php }else if($c['user_desig_code']=='ADC' && CIRCLE_BIRFURCATE_ADC == 1){
                                        ?>
                                            <button class="btn btn-primary btn-sm" onclick="mappedADCModal('<?=$c['user_code']?>','<?=$c['dist_code']?>','<?=$c['subdiv_code']?>','<?=$c['cir_code']?>')">Assign Circle(s)</button>


                                        <?php } ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($c['status'] == 'E') {
                                                ?>
                                                <a onClick="return ConfDel()" href="<?php echo base_url() . 'index.php/initialization/disable_other_users_adc?user_code=' . $c['user_code'] . '&dist_code=' . $c['dist_code'] . '&subdiv_code=' . $c['subdiv_code'] . '&cir_code=' . $c['cir_code'] . '&mouza_pargona_code=' . $c['mouza_pargona_code'] . '&lot_no=' . $c['lot_no'] ?>" title="Disable User"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span></a>
                                                <?php
                                            } else {
                                                ?>		
                                                <a onClick="return Confadd()" href="<?php echo base_url() . 'index.php/initialization/enable_other_users?user_code=' . $c['user_code'] . '&dist_code=' . $c['dist_code'] . '&subdiv_code=' . $c['subdiv_code'] . '&cir_code=' . $c['cir_code'] . '&mouza_pargona_code=' . $c['mouza_pargona_code'] . '&lot_no=' . $c['lot_no'] ?>" title="Enable User"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style='color: green;'></span></a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- edit -->
<div id="myModal" class="modal modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
               <!--  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>  -->
               <span class="close">&times;</span>
            </div>
            <div class="modal-head alert alert-warning">
                <h6 style="text-align: center;" class="uni_text red">
                   Edit Member Information
                </h6>
            </div>
            <div class="modal-body">
                <?php echo form_open('initialization/updateInformation' ,array('id'=>'formAjaxPost')); ?>
                <div class="row" style='padding:20px'> 
                    <span id='msg'></span>           
                    <div class='col-lg-12'>
                        Name :<input type="text" readonly="" class='form-control profile' value="" name="name">
                    </div>
                    <div class='col-lg-12'>
                        Display Name :<input type="text" class='form-control display' name="dname">
                    </div>
                    <div class='col-lg-12'>
                        Email :<input type="text" readonly="" class='form-control email' name="email">
                    </div>
                    <div class='col-lg-12'>
                        Mobile :<input type="text" class='form-control mobile' name="mobile">
                    </div>
                    <div class='col-lg-12'>
                        User Type :
                        <select class='form-control utype' name="user_type"> 
                        </select>
                    </div>
                    <input type="hidden" name="dist_code" class="dist_code_post">
                    <input type="hidden" name="user_code" class="user_code_post">
                    <input type="hidden" name="unique_id_post" class="unique_id_post">
                    <hr class="border" style="border-bottom: 2px solid #000;">
                    <center><button type="submit" id='submitModal' class="btn btn-md btn-primary" ><i class='fa fa-check'></i>&nbsp;Update</button></center>
                </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<!---------------->
<!-- ///NEW MODAL ADD======== -->
<div id="myModalADC" class="modal modal-md">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header"> 
               <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <?php echo form_open('initialization/updatedCirclesAttached',array('id'=>'formAjaxPostAttched')); ?>
                <div class="row" style='padding:20px'>
                <div id="mappedDetails"></div> 
                    <hr class="border" style="border-bottom: 2px solid #000;">
                    <input type="hidden" name="adc_user" id='attachedadc'>
                    <center><button type="submit" id='submitAdcAttached' class="btn btn-md btn-primary" ><i class='fa fa-check'></i>&nbsp;Update</button></center>
                </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- /////NEW MODAL END -->
<!-- ///NEW MODAL ADD======== -->
<div id="myModalCO" class="modal bg bg-info" tabindex="-1" role="dialog">
<div class="modal-dialog modal-xl">
        <div class="modal-content"> 
            <div class="modal-header"> 
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
            <div class="modal-body">
                <?php echo form_open('initialization/updatedLotsAttached',array('id'=>'formAjaxPostCOAttched')); ?>
                <div class="row" style='padding:20px'>
                <span class="msg"></span> 
                <div id="mappedDetailslots"></div> 
                    <hr class="border" style="border-bottom: 2px solid #000;">
                    <input type="hidden" name="co_user" id='attachedco'>
                    <center><button type="submit" id='submitCOAttached' class="btn btn-md btn-primary" ><i class='fa fa-check'></i>&nbsp;Update</button></center>
                </div>
                </form>
            </div>  
        </div>
    </div>
</div>

<div id="myModalADCMapping" class="modal bg bg-info" tabindex="-1" role="dialog">
<div class="modal-dialog modal-xl">
        <div class="modal-content"> 
            <div class="modal-header"> 
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
            <div class="modal-body">
                <?php echo form_open('initialization/updatedCirclesAttached',array('id'=>'formAjaxPostADCAttched')); ?>
                <div class="row" style='padding:20px'>
                
                <div id="mappedDetailsCircleMaps"></div> 
                
                    <input type="hidden" name="adc_user" id='attachedadc_mapping'>
                    <span class="mapped_circle_msg"></span>
                    <span class="error_msg"></span> 
                    <center><button type="submit" id='submitADCMappedAttached' class="btn btn-md btn-primary" ><i class='fa fa-check'></i>&nbsp;Update</button></center>
                </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- /////NEW MODAL END -->
<script type="text/javascript">

var modal = document.getElementById("myModal");
var modal = document.getElementById("myModalADC");
var modal = document.getElementById("myModalADCMapping");
// Get the button that opens the modal
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<script type="text/javascript">
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
        $(".btn-close").on("click", function() {
            $('#myModal').modal('hide');
            $('#msg').hide('');
        });
        $(".close").on("click",function(e){
            e.preventDefault();
            // alert('close');
            $('#myModalCO').modal('hide');
            $('#myModalADCMapping').modal('hide');
            // $('#myModalCO').close();
        })
    });

    function mappedcircleModal(user_code,distcode,subdivcode,circode){        
        let userUniqueID = user_code;
        $('#myModalCO').modal('show');
        $.ajax({
            url: baseurl + "initialization/assginLotCO/" + userUniqueID +'/'+ distcode +'/'+ subdivcode +'/'+ circode,
            // dataType: 'json',
            success: function (data) {
                // console.log(data);
                $('#attachedco').val(user_code);
                $('#mappedDetailslots').html(data);
            },
            error: function (data) {
                   var r = jQuery.parseJSON(data.responseText);
                   alert("Message: " + r.Message);
                   alert("StackTrace: " + r.StackTrace);
                   alert("ExceptionType: " + r.ExceptionType);
            }
        });
    }

    function mappedADCModal(user_code,distcode,subdivcode,circode){        
        let userUniqueID = user_code;
        $('#myModalADCMapping').modal('show');
        $.ajax({
            url: baseurl + "initialization/assginCircleADC/" + userUniqueID +'/'+ distcode +'/'+ subdivcode +'/'+ circode,
            // dataType: 'json',
            success: function (data) {
                // console.log(data);
                $('#attachedadc_mapping').val(user_code);
                $('#mappedDetailsCircleMaps').html(data);
            },
            error: function (data) {
                   var r = jQuery.parseJSON(data.responseText);
                   alert("Message: " + r.Message);
                   alert("StackTrace: " + r.StackTrace);
                   alert("ExceptionType: " + r.ExceptionType);
            }
        });
    }
    $('#example').on('click', '.confirm', function () {
            let userUniqueID = $(this).data('id');
            //alert(userUniqueID);
            $.ajax({
            url: baseurl + "initialization/getUsersInfo/" + userUniqueID,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(data.response==2){
                    $('.profile').val(data.msg['username']);
                    $('.display').val(data.msg['display_name']);
                    $('.email').val(data.msg['emailid']);
                    $('.mobile').val(data.msg['phone_no']);
                    $('.dist_code_post').val(data.msg['dist_code']);
                    $('.user_code_post').val(data.msg['user_code']);
                    $('.unique_id_post').val(data.msg['use_name']);
                    let temporary=(data.msg['user_type']=='MEMBER')?'MEMBER':data.msg['user_type'];
                    var template = "<option>Select Option</option>"
                     template += "<option value='MP'>MP</option>"
                     template += "<option value='MLA'>MLA</option>"
                     template += "<option value='SDLC'>MEMBER</option>"
                     template += "<option selected value='"+temporary+"'>"+temporary+"</option>"
                    $('.utype').html(template);
                }
            }
        });
        $('#myModal').modal('show');
    });
    $('.district_wdb').change(function (e) {
        var distCode = $(this).val();
        //alert("aa" + baseurl);
        console.log("aa" + baseurl);
        $.ajax({
            url: baseurl + "Utility/getSubdivJson_wdb/" + distCode,
            success: function (data) {
                console.log(data);
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Sub Division</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].subdiv_code + "'>" + subdivcode[i].loc_name + "</option>"
                }
                console.log(template);
                $('.subdivselect_wdb').html(template);
            }
        });
    });
    $('.subdivselect_wdb').change(function (e) {
        var subdivcode = $(this).val();
        var distcode = $('.district_wdb').val();
        $.ajax({
            url: baseurl + "Utility/getCirCodeJson_wdb/" + distcode + '/' + subdivcode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var circode = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";

                for (var i = 0; i < circode.length; i++) {
                    template += "<option value='" + circode[i].cir_code + "'>" + circode[i].loc_name + "</option>";
                }
                console.log(template);
                $('.circleselect_wdb').html(template);
            }
        });
    });
    $("#submitModal").click(function(event)
    {
        //$("#formAjaxPost").submit();
        event.preventDefault();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'initialization/updateInformation', 
            data        : $('#formAjaxPost').serialize(),
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                $('#msg').hide();
            },
            success: function(data){
                console.log(data);
              if(data.response==1){
                alert(data.msg);
                $('#myModal').modal('hide');
              }else if(data.response==2){
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                $('#msg').show();
                $('#myModal').modal('show');
              }
            },
            error: function (data) {
                   var r = jQuery.parseJSON(data.responseText);
                   alert("Message: " + r.Message);
                   alert("StackTrace: " + r.StackTrace);
                   alert("ExceptionType: " + r.ExceptionType);
            }
        });
    });
    $("#submitCOAttached").click(function(event){
        event.preventDefault();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'initialization/updateattchedCO', 
            data        : $('#formAjaxPostCOAttched').serialize(),
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                $('#msg').hide();
            },
            success: function(data){
                console.log(data);
              if(data.response==1){
                alert(data.msg);
                $('#myModalCO').modal('hide');
              }else if(data.response==2){
                $('.msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                $('.msg').show();
                $('#myModalCO').modal('show');
              }
            },
            error: function (data) {
                   var r = jQuery.parseJSON(data.responseText);
                   alert("Message: " + r.Message);
                   alert("StackTrace: " + r.StackTrace);
                   alert("ExceptionType: " + r.ExceptionType);
            }
        });
    });

    $("#submitADCMappedAttached").click(function(event){
        event.preventDefault();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'initialization/updateattchedADC', 
            data        : $('#formAjaxPostADCAttched').serialize(),
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                $('#error_msg').hide();
            },
            success: function(data){
                console.log(data.response);
              if(data.response==2){
                alert(data.msg);
                $('#myModalADCMapping').modal('hide');
              }else if(data.response==1){
                alert(data.error);
                $('.error_msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                $('.error_msg').show();
                $('#myModalADCMapping').modal('show');
              }else if(data.response==3){
                alert(data.error);
                $('.error_msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                $('.mapped_circle_msg').html('<div class="alert alert-danger text-center"><b>These circles mapped with other ADC --' + data.circles + '</b></div>');
                $('.error_msg').show();
                $('#myModalADCMapping').modal('show');
              }
            },
            error: function (data) {
                   var r = jQuery.parseJSON(data.responseText);
                   alert("Message: " + r.Message);
                   alert("StackTrace: " + r.StackTrace);
                   alert("ExceptionType: " + r.ExceptionType);
            }
        });
    });


    // $("#submitAdcAttached").click(function(event){
    //     event.preventDefault();
    //     $.ajax({
    //         type        : 'POST', 
    //         url         : baseurl+'initialization/updateattchedCircle', 
    //         data        : $('#formAjaxPostAttched').serialize(),
    //         dataType    : 'json', 
    //         encode      : true,
    //         beforeSend: function(){
    //             $('#msg').hide();
    //         },
    //         success: function(data){
    //             console.log(data);
    //           if(data.response==1){
    //             alert(data.msg);
    //             $('#myModalADC').modal('hide');
    //           }else if(data.response==2){
    //             $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
    //             $('#msg').show();
    //             $('#myModalADC').modal('show');
    //           }
    //         },
    //         error: function (data) {
    //                var r = jQuery.parseJSON(data.responseText);
    //                alert("Message: " + r.Message);
    //                alert("StackTrace: " + r.StackTrace);
    //                alert("ExceptionType: " + r.ExceptionType);
    //         }
    //     });
    // });
</script>