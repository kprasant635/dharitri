<style>

@media (max-width: 480px) {
    .modal-dialog {
      max-width: 94%;
      margin: 1.75rem auto;
    }
  }
  @media (min-width: 576px){
    .modal-dialog {
      max-width: 850px;
      margin: 1.75rem auto;
    }
  }
</style>

<button type="button" class="rezaButt buttPrimary"
onclick="landModal('<?=$identity_type?>','<?=$identity_ref_no?>');" id="">
Check Existing Land
</button>

<!-- land check model -->
<div class="modal" role="dialog" id="landModal" style="padding-top: 25px!important;" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
            <div class="modal-header" style="color:#fff; background-color:#176d84; font-weight: bold; border: none">
            <!-- <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6"> -->
                <h5 class="modal-title text-center" id="exampleModal3Label">LAND FOUND IN BELOW MENTIONED DISTRICTS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container">
              <span style="font-weight: bold; color:red; font-size:15px">Note: This data is shown for those dags which are linked with AADHAAR or PAN of the pattadar in dharitree</span>
                <div class="row">
                  <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3 text-center">
                    
                    <table class="mt-2 table-responsive table table-striped table-bordered text-center" style="border:none!important">
                    <!-- <caption>Land Summary</caption> -->
                    <thead>
                      <tr class="text-bold table-success">
                        <!-- <th class="text-center">District Code</th> -->
                        <th><b>District Name</b></th>

                      </tr>
                    </thead>
                    <tbody class="landdist">
                      <!-- <tr class="landdist">
                        <td data-label="Account"></td>
                        <td class="landdist"></td>
                        
                      </tr> -->
                      
                      
                    </tbody>
                    </table>
                  </div>
            
                  <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9 text-center">
                    <div class="areadisplay" style="display: none;">
                    <table class="mt-2 table-responsive table table-striped table-bordered text-center" style="border:none!important">
                      
                      <thead>
                        <tr class="text-bold table-success">
                          
                          <th><b>District</b></th>
                          <th><b>Circle</b></th>
                          <th><b>Village</b></th>
                          <th><b>Dag</b></th>
                          <th><b>Pattadar Name</b></th>

                        </tr>
                      </thead>
                      <tbody class="distfound">
                      
                      </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
        </div>
        </div>
</div>
<!-- land check model end -->

<script>

function tdclick(i,identity_ref_no){ 
    // alert(i + ','+ identity_ref_no);
    // console.log(i);
    // $('.areadisplay').toggle("slide");

        var postData = {
            'dist_code' : i,
            'identity_ref_no' : identity_ref_no
        };

        $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
        });


        $.ajax({
            url: baseurl+'SettlementCommon/findLand',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                // alert(arr.appnData); return;
                console.log(arr.appnData);
                $.unblockUI();
                if(arr.responseType == 0){
                  showNotFoundMessage(arr.appnData);
                    $('.areadisplay').hide();
                }
                else{
                    
                    var array = arr.appnData;
                    console.log(array);
                    var details = "";

                    // for (var i = 0; i < array.length; i++) {
                    // var details += array[i];
                    // }
                    
                    $.each(array, function (i, val) {
                      // details +=  i+'-'+val.dist_name+'<br>';
                      details +=  '<tr><td>' +val.district+ '</td><td>' +val.circle+ '</td><td>' +val.village_name+ '</td><td>' +val.dag_no+ '</td><td>' +val.name+ '</td></tr>';
                    });
                    // alert(details);
                    details = details;
                    $(".distfound").html(details);
                    $('.areadisplay').show();

                    
                }
            }
        });
    

};

var landModalId = document.getElementById("landModal");
    function landModal(identity_type,identity_ref_no){
        
      // var applid = 'RTPS/SHLTC/2023/25463';
      // var identity_type = $.trim($('#identity_type').val());
      // var identity_ref_no = $.trim($('#identity_ref_no').val());

      var identity_type = identity_type;
      var identity_ref_no = identity_ref_no;

        var postData = {
            'identity_type' : identity_type,
            'identity_ref_no' : identity_ref_no
        };

        $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
        });


        $.ajax({
            url: baseurl+'SettlementCommon/landCheck',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                // alert(arr.appnData); return;
                $.unblockUI();
                if(arr.responseType == 0){
                    showErrorMessage(arr.appnData.message);
                }
                else{
                    // applicantModal.style.display = "none";
                    console.log(arr.appnData.dist_land_detail);
                    // var array = {07: 'কামৰূপ',02: 'নগাঁও'}; 
                    var array = arr.appnData.dist_land_detail;
                    console.log(array);
                    var details = "";
                    
                    $.each(array, function (i, val) {
                      //  details +=  i+'-'+val+'<br>';
                      details +=  '<tr><td id="show" onclick="tdclick('+i+',\''+identity_ref_no+'\')">' +val+ '&nbsp;<i class="fa fa-eye" style="font-size:18px"></i></td></tr>';
                    });
                    $(".landdist").html(details);

                    landModalId.style.display = "block";
                    //$("#landdist").html(arr.appnData.dist_land_detail[1][0].dist_name);

                    span.onclick = function() {
                        landModalId.style.display = "none";
                    }

                    window.onclick = function(event) {
                        if (event.target == landModalId) {
                            landModalId.style.display = "none";
                        }
                    }
                }
            }
        });

    }

    $(document).on('click','.closePremium',function ()
    {
        landModalId.style.display = "none";
    });

    function showNotFoundMessage(text) {
        swal.fire({
            title: "Land Not Found!!!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
</script>