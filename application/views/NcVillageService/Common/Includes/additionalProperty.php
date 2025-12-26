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


<!-- Modal -->
<div class="modal" id="additionalPropertyModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header" style="color:#fff; background-color:#176d84; font-weight: bold; border: none">
        Citizen`s Property Availability
        <span class="px-4" style="cursor: pointer;" onclick="btnClosePropertyModal()">&times;</span>
      </div>

      <div class="modal-body">

        <div class="row">
          <input type="hidden" name="application_no" id="application_no" value="<?=$_GET['case']?>">
          <div class="table-responsive additionalPropertyView">
            <h5>Additional Property List</h5>
            <table class="table table-striped table-bordered">
              <thead>
              <tr class="text-bold table-success">
                <th>District</th>
                <th>Circle</th>
                <th>Bigha</th>
                <th>Katha</th>
                <th>Lessa/Chatak</th>
                <th>Ganda</th>
                <th>Kranti</th>
              </tr>
              </thead>
              <tbody id="propertyDetail">
              </tbody>
            </table>
            <button type="button" class="btn btn-warning" id="require_changes">Do you want to make changes ?</button>
          </div>
        </div>

        <hr>

        <div class="additional_property_add" style="display:none">

          <div class="row p-2" >
            <div class="col-md-6">
              <span>Whether applicant and his/her family has occupied any land in the state ?</span>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
              <span id="is_landless_propErr" class="__error__msg"></span>
              <select name="is_landless_prop" id="is_landless_prop" class="form-control" onchange="openSelectAdditionalPropertyModal()">
                <option value="">Select Land Category</option>              
                <option value="YES" class="completely_landless_prop">Completely Landless</option>
                <option value="NO">Landless as per land policy</option>
                <option value="OTHERS">Having Land</option>
              </select>
            </div>
          </div>
          <hr>


          <div class="row p-2 entry_of_additional_property_div" style="display:none;">

              <span style="font-size: 20px; font-weight:bold;">Add New Additional Property Detail</span>
              <br><br><br>
            
              <div id="additional_property" >
                <div id="message"></div>
                <div class="row">
                  <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                    <div id="additional_district_propErr"></div>
                    <div class="form__div">
                      <select name="additional_district_prop_code"
                        class="form-control  form_select ps-3 additional_mselect_prop property_add_reset"
                        id='additional_district_prop'
                        data-placeholder="<?php echo $this->lang->line('district');?>"
                        data-allow-clear="1">
                        <option disabled="" selected="" value="">Select District</option>
                        <option value="10">ছিৰাং ( Chirang )</option>
                        <option value="06">নলবাৰী ( Nalbari )</option>
                        <option value="08">দৰং ( Darrang )</option>
                        <option value="07">কামৰূপ ( Kamrup )</option>
                        <option value="33">নগাওঁ ( Nagaon )</option>
                        <option value="14">গোলাঘাট ( Golaghat )</option>
                        <option value="01">কোকৰাঝাৰ (Kokrajhar)</option>
                        <option value="02">ধুবুৰী ( Dhubri )</option>
                        <option value="03">গোৱালপাৰা ( Goalpara )</option>
                        <option value="05">বৰপেটা ( Barpeta )</option>
                        <option value="13">বঙাইগাঁও ( Bongaigaon )</option>
                        <option value="15">যোৰহাট ( Jorhat )</option>
                        <option value="17">ডিব্ৰুগড় ( Dibrugarh )</option>
                        <option value="21">করিমগঞ্জ ( Karimganj )</option>
                        <option value="24">কামৰূপ মহানগৰ ( Kamrup Metro )</option>
                        <option value="32">মৰিগাওঁ ( Morigaon )</option>
                        <option value="36">হোজাই ( Hojai )</option>
                        <option value="38">দক্ষিণ শালমাৰা ( South Salmara )</option>
                        <option value="39">বজালী ( Bajali )</option>
                        <option value="22">Hailakandi</option>
                        <option value="23">Cachar</option>
                        <option value="27">Udalguri</option>
                        <option value="12">লক্ষীমপূৰ ( Lakhimpur )</option>
                        <option value="16">শিৱসাগৰ ( Sibsagar )</option>
                        <option value="18">তিনিচুকীয়া ( Tinsukia )</option>
                        <option value="34">মাজুলী ( Majuli )</option>
                        <option value="37">চৰাইদেউ ( Charaideo )</option>
                        <option value="11">শোণিতপুৰ ( Sonitpur )</option>
                        <option value="25">ধেমাজি ( Dhemaji )</option>
                        <option value="35">বিশ্বনাথ ( Biswanath )</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                    <span id="additional_circle_propErr" class="__error__msg"></span>
                    <div class="form__div">
                      <select name="additional_circle_prop" class="form-control  ps-3 additional_mselect_prop property_add_reset" id="additional_circle_prop">
                        <option value="">Select Circle<span style="color: red;">*</span></option>
                      </select>
                    </div>

                  </div>
                  <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                    <span id="is_additional_urban_propErr" class="__error__msg"></span>
                    <div class="form__div">
                      <div class=" ps-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="is_additional_urban_prop" checked id="is_additional_urban_prop" value="N" checked>
                          <label class="form-check-label" for="inlineRadio3">Rural</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="is_additional_urban_prop" id="is_additional_urban_prop" value="Y">
                          <label class="form-check-label" for="inlineRadio4">Urban</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                    <div class="additional_village_propErr"></div>
                    <div class="form__div">
                      <select name="additional_village_prop" id="additional_village_prop"
                        class=" form-control ps-3 additional_mselect_prop">
                        <option value="">Select Village </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <span id="additional_dag_propErr" class="__error__msg"></span>
                    <div class="form__div">
                      <select name="additional_dag_prop" class=" form-control ps-3 additional_mselect_prop property_add_reset" id="additional_dag_prop" data-placeholder="<?php echo $this->lang->line('dag');?>" data-allow-clear="1">
                        <option value="">Select Dag<span style="color: red;">*</span></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <input type="text" name="additional_patta_prop" class="form-control property_add_reset"
                      id='additional_patta_prop' readonly placeholder="Patta No">
                  </div>
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>

                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <span id="additional_bigha_propErr" class="__error__msg"></span>
                    <input type="text" name="additional_bigha_prop" class=" form-control property_add_reset"
                    oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                    id='additional_bigha_prop' placeholder="Bigha">
                  </div>
                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <span id="additional_katha_propErr" class="__error__msg"></span>
                    <input type="text" name="additional_katha_prop" class=" form-control property_add_reset"
                    oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                    id='additional_katha_prop' placeholder="Katha">
                  </div>
                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <span id="additional_lessa_propErr" class="__error__msg"></span>
                    <input type="text" name="additional_lessa_prop" class="form-control property_add_reset"
                    oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                    id='additional_lessa_prop' placeholder="Lessa/Chatak">
                  </div>

                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 karimganj_div">&nbsp;</div>
                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 in_ganda_div" style="display:none">
                    <span id="additional_ganda_propErr" class="__error__msg"></span>
                    <input type="text" name="additional_ganda_prop" class="form-control property_add_reset"
                    oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                    id='additional_ganda_prop' placeholder="Ganda">
                  </div>
                  <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 in_kranti_div" style="display:none">
                    <span id="additional_kranti_propErr" class="__error__msg"></span>
                    <input type="text" name="additional_kranti_prop" class="form-control property_add_reset"
                    oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                    id='additional_kranti_prop' placeholder="Kranti">
                  </div>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 pull-left">
                  <button class="btn btn-sm btn-primary" type="button" id="submitAddProperty">Submit Area Detail</button>
                  <input type="hidden" id="service_code" value="">
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px; margin-bottom: 15px"><hr></div>

                <div class="table-responsive additionalPropertyTable">
                    <h5>Newly Added Additional Property List</h5>
                    <table class="table table-striped table-bordered" id="addProperty">
                        <thead>
                          <tr class="text-bold table-success">
                            <th>District</th>
                            <th>Circle</th>
                            <th>Bigha</th>
                            <th>Katha</th>
                            <th>Lessa/Chatak</th>
                            <th>Ganda</th>
                            <th>Kranti</th>
                            <th>Delete</th>
                          </tr>
                        </thead>

                        <tbody id="addPropData">
                            <?php   

                              if(isset($checkAdditionalProperty)) {
                                foreach ($checkAdditionalProperty as $key => $row) { ?>
                                  <tr id="prop<?php echo $row->id;?>" class="table_list">
                                    <td><?php echo $row->dist_name;?></td>
                                    <td><?php echo  $row->cir_name;?></td>
                                    <td><?php echo $row->bigha;?></td>
                                    <td><?php echo $row->katha;?></td>
                                    <td><?php echo $row->lessa;?></td>
                                    <td><?php echo $row->ganda;?></td>
                                    <td><?php echo $row->kranti;?></td>
                                    <td>
                                        <?php if($row->applied_flag != CITIZEN) { ?>
                                            <a href="javascript:void(0)" onclick="confirmDeleteModal(<?php echo $row->id;?>)" class="btn btn-danger" id="delProperty">Delete</a>
                                        <?php } ?>
                                    </td>
                                  </tr>
                            <?php }} ?>

                        </tbody>
                    </table>
                </div>



              <hr>

              <button type="button" class="btn btn-sm btn-success col-lg-6" id="saveChanges">
                <i class="fa fa-check">&nbsp;&nbsp;Save Changes</i></button>
          </div>

          

        </div>

        
      </div>
      
    </div>
    
  </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>


<script type="text/javascript">

  //$('#additionalPropertyModal').modal({backdrop: 'static', keyboard: false});

  BARAK_VALLEY = new Array('21','22','23');

  function viewAdditionalPropertyModal() {
    var ref_no = $("#application_no").val();
    $.ajax({
      url: baseurl + "SettlementCommon/viewAdditionalProperty",
      type: "post",
      data: {applid : ref_no},
      dataType: "json",
      success: function(data) {
        $('#propertyDetail').html('');
        $('#additionalPropertyModal').modal('show');
        // $('#additionalPropertyModal').modal({backdrop: 'static', keyboard: false}, 'show');
        var table = '';
        if(data.response == 1){
          $.each(data.property_details, function (key, val) {
            table +=
              '<tr style="font-size:16px">'+
                '<td>' + val['dist_name'] + '</td>' +
                '<td>' + val['cir_name'] + '</td>' +
                '<td>' + val['bigha'] + '</td>' +
                '<td>' + val['katha'] + '</td>' +
                '<td>' + val['lessa'] + '</td>' +
                '<td>' + val['ganda'] + '</td>' +
                '<td>' + val['kranti'] + '</td>' +              
              '</tr>'
          });
        }
        $('#propertyDetail').html(table);
      },
      error: function(data) {
        showErrorMessage('Something went wrong. No data found.');
      }
    });
  }

  function btnClosePropertyModal() {
    var ref_no = $("#application_no").val();
    Swal.fire({
      text: 'On closing this panel, all changes of additional property that has made by you will remain undone. Are you sure to proceed ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      backdrop: false,
      allowOutsideClick: false,
      customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1 right-gap',
        confirmButton: 'order-2',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseurl + "SettlementCommon/closeAdditionalProperty",
          type: "post",
          data: {applid : ref_no},
          dataType: "json",
          success: function(data) {
            if(data.response == 1){
              $('#additionalPropertyModal').modal('hide');
              $('#require_changes').prop('disabled', false);
              $('.additional_property_add').css('display', 'none');
              $("#is_landless_prop option[value='']").prop('selected', 'selected');
              $('.entry_of_additional_property_div').hide();
            }        
          },
          error: function(err) {
            showErrorMessage('Something went wrong');
          }
        });
      }
    });
  }

  function confirmDeleteModal(id) {
    var ref_no = $("#application_no").val();
    Swal.fire({
      text: 'Are you sure to delete this additional property ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      backdrop: false,
      allowOutsideClick: false,
      customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1 right-gap',
        confirmButton: 'order-2',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseurl + "SettlementCommon/deleteAdditionalProperty",
          type: "post",
          data: {id : id, case_no : ref_no},
          dataType: "json",
          success: function(data) {
            $('#additionalPropertyModal').modal('show');
            if(data.response == 1){
              var table = '';
              $.each(data.property_details, function (key, val) {

                if(val['applied_flag'] != 'CITIZEN') {
                  delButton = '<a href="javascript:void(0)" onclick="confirmDeleteModal('+val['id']+')" class="btn btn-danger" id="delProperty">Delete</a>';
                }
                else {
                  delButton = '';
                }

                table +=
                  '<tr style="font-size:16px">'+
                    '<td>' + val['dist_name'] + '</td>' +
                    '<td>' + val['cir_name'] + '</td>' +
                    '<td>' + val['bigha'] + '</td>' +
                    '<td>' + val['katha'] + '</td>' +
                    '<td>' + val['lessa'] + '</td>' +
                    '<td>' + val['ganda'] + '</td>' +
                    '<td>' + val['kranti'] + '</td>' +
                    '<td>' + delButton + '</td>' +                
                  '</tr>'
              });
            }
            $('#addPropData').html(table);
          },
          error: function(err) {
            showErrorMessage("Something went wrong !!!");
          }
        });
      }
    });
  }

  $(document).on('click', '#require_changes', function()
  {
    var ref_no = $("#application_no").val();
    Swal.fire({
      text: 'Are you sure to make any changes on additional property ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      backdrop: false,
      allowOutsideClick: false,
      customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1 right-gap',
        confirmButton: 'order-2',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseurl + "SettlementCommon/changesOnAdditionalProperty",
          type: "post",
          data: {applid : ref_no},
          dataType: "json",
          success: function(data) {
            $('#additionalPropertyModal').modal('show');
            $('#require_changes').prop('disabled', true);
            $('.additional_property_add').css('display', 'block');      
          }
        });
      }
    });
  });

  function openSelectAdditionalPropertyModal()
  {
    var ref_no = $("#application_no").val();
    $('.entry_of_additional_property_div').hide();

    if($('#is_landless_prop').val() == '' || $('#is_landless_prop').val() == null){
      $('.entry_of_additional_property_div').hide();
    }

    else if($('#is_landless_prop').val() == 'YES'){

      Swal.fire({
        text: 'All additional property detail entered by CITIZEN as well as LM will be removed once clicked on YES. Are you sure to proceed?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: baseurl + "SettlementCommon/deleteAllAdditionalProperty",
            type: "post",
            data: {case_no : ref_no},
            dataType: "json",
            success: function(data) {
              if(data.status == 0){
                $('#additionalPropertyModal').modal('hide');   
                $("#propertyDetail").remove();  
              }        
            }
          });
        } else {
          $("#is_landless_prop option[value='']").prop('selected', 'selected'); 
          return true;
        }
      })    
    }

    else {
      $.ajax({
        url: baseurl + "SettlementCommon/checkAdditionalProperty",
        type: "post",
        data: {applid : ref_no},
        dataType: "json",
        success: function(data) {
          $('.entry_of_additional_property_div').show();      
        }
      });
    }
  }

  // additional property entry
  $(document).on('change', '#additional_district_prop', function(){
      var district = $(this).val();
      if (district == '') {
          return;
      }
      // alert(district);
      if($.inArray(district, BARAK_VALLEY) == -1 ) { // other than barak valley
        $('.in_ganda_div').hide();
        $('.in_kranti_div').hide();
        $('.lessa_title').show();
        $('.karimganj_div').hide();
      }
      else { // for barak valley
        $('.in_ganda_div').show();
        $('.in_kranti_div').show();
        $('.lessa_title').hide();
        $('.karimganj_div').show();
      }
      $('.lessa_title').show();

      $("#additional_bigha_prop").attr("placeholder", "Bigha");
      $("#additional_katha_prop").attr("placeholder", "Katha");
      $("#additional_lessa_prop").attr("placeholder", "Lessa/Chatak");
      $("#additional_ganda_prop").attr("placeholder", "Ganda");
      $("#additional_kranti_prop").attr("placeholder", "Kranti");

      $.ajax({
        url: baseurl + "SettlementCommon/getCircle/" + district,
        success: function(data) {
          var Circle = JSON.parse(data);
          var template =
            "<option selected value='' disabled>-- Select Circle --</option>";
          for (var i = 0; i < Circle.length; i++) {
            template +=
              "<option value='" +
              Circle[i].cir_code +
              "'>" +
              Circle[i].loc_name +
              " (" +
              Circle[i].locname_eng +
              ")</option>";
          }
          $("#additional_circle_prop").html(template);
        },
        error: function(error) {
        },
      });
  });

  $("#additional_circle_prop").change(function(e) {
  // $(document).on('change', '#additional_circle_prop', function(){
      if ($(this).val() == null) {
        return;
      }

      var district = $("#additional_district_prop").val();
      var circle = $(this).val();
      var villcode = circle.split(",");
      // alert(circle);

      var circle = villcode[0];
      var subdiv = villcode[1];
      $("#additional_village_prop").empty();
      $("#additional_dag_prop").empty();
      $("#additional_bigha_prop").val("");
      $("#additional_katha_prop").val("");
      $("#additional_lessa_prop").val("");
      $("#additional_ganda_prop").val("");
      $("#additional_kranti_prop").val("");
      var rural = $("input[name='is_additional_urban_prop']:checked").val();

      // const loading = new Loading();
      $.ajax({
          url: baseurl +
              "SettlementCommon/getVillage/" +
              district +
              "/" +
              subdiv +
              "/" +
              circle +
              "/" +
              rural,
          success: function(data) {
              // loading.out();
              var village = JSON.parse(data);
              var template = "<option selected value='' disabled>-- Select Village --</option>";
              for (var i = 0; i < village.length; i++) {
                  template +=
                      "<option value='" +
                      village[i].vill_townprt_code +
                      "'>" +
                      village[i].loc_name +
                      "</option>";
              }
              //console.log(template);
              $("#additional_village_prop").html(template);
          },
          error: function(error) {
              // loading.out();
          },
      });
  });

  // $("input[type=radio][name=is_additional_urban_prop]").change(function() {
  $(document).on('click', 'input[type=radio][name=is_additional_urban_prop]', function(){
      var district = $("#additional_district_prop").val();
      var circle = $("#additional_circle_prop").val();
      var villcode = circle.split(",");
      // alert(villcode);

      var circle = villcode[0];
      var subdiv = villcode[1];

      $("#additional_village_prop").empty();
      $("#additional_dag_prop").empty();
      $("#additional_bigha_prop").attr("placeholder", "Bigha");
      $("#additional_katha_prop").attr("placeholder", "Katha");
      $("#additional_lessa_prop").attr("placeholder", "Lessa/Chatak");
      $("#additional_ganda_prop").attr("placeholder", "Ganda");
      $("#additional_kranti_prop").attr("placeholder", "Kranti");

      var rural = $("input[name='is_additional_urban_prop']:checked").val();
      // const loading = new Loading();
      $.ajax({
          url: baseurl +
              "SettlementCommon/getVillage/" +
              district +
              "/" +
              subdiv +
              "/" +
              circle +
              "/" +
              rural,
          success: function(data) {
              // loading.out();
              //console.log(data);
              var village = JSON.parse(data);

              var template = "<option selected value='' disabled>-- Select Village --</option>";
              for (var i = 0; i < village.length; i++) {
                  template +=
                      "<option value='" +
                      village[i].vill_townprt_code +
                      "'>" +
                      village[i].loc_name +
                      "</option>";
              }
              $("#additional_village_prop").html(template);
          },
          error: function(error) {
              // loading.out();
          },
      });
  });

  $(document).on('change', '#additional_village_prop', function(){
      if ($(this).val() == null) {
          return;
      }
      //alert("sddfghj"); return;
      var district = $("#additional_district_prop").val();
      var circle = $("#additional_circle_prop").val();
      var villcode = circle.split(",");

      var circle = villcode[0];
      var subdiv = villcode[1];
      var village = $(this).val();
      var villcode = village.split(",");
      // alert(villcode);

      if (villcode.length == 4) {
          var village = villcode[0];
          var mouza = villcode[2];
          var lot = villcode[3];
      } else {
          villcode = village.split(" ");
          var mouza = villcode[0];
          var lot = villcode[1];
          var village = villcode[2];
      }

      $("#additional_dag_prop").empty();
      $("#additional_bigha_prop").attr("placeholder", "Bigha");
      $("#additional_katha_prop").attr("placeholder", "Katha");
      $("#additional_lessa_prop").attr("placeholder", "Lessa/Chatak");
      $("#additional_ganda_prop").attr("placeholder", "Ganda");
      $("#additional_kranti_prop").attr("placeholder", "Kranti");

      // const loading = new Loading();
      $.ajax({
          url: baseurl +
              "SettlementCommon/getAllDags/" +
              district +
              "/" +
              subdiv +
              "/" +
              circle +
              "/" +
              mouza +
              "/" +
              lot +
              "/" +
              village,
          success: function(data) {
              // loading.out();
              //console.log(data);
              var dag = JSON.parse(data);
              var template =
                  "<option value='' selected disabled>-- Select Dag--</option>";
              for (var i = 0; i < dag.length; i++) {
                  template +=
                      "<option value='" +
                      dag[i].dag_no_int +
                      "'>" +
                      dag[i].dag_no +
                      "</option>";
              }
              //console.log(template);
              $("#additional_dag_prop").html(template);
          },
          error: function(error) {
              // loading.out();
          },
      });
  });

  $(document).on('change', '#additional_dag_prop', function(){
      if ($(this).val() == null) {
          return;
      }
      var district = $("#additional_district_prop").val();
      var circle = $("#additional_circle_prop").val();
      var villcode = circle.split(",");
      // alert(villcode);

      var circle = villcode[0];
      var subdiv = villcode[1];
      var village = $("#additional_village_prop").val();
      var villcode = village.split(",");
      // alert(villcode);

      if (villcode.length == 4) {
          var village = villcode[0];
          var mouza = villcode[2];
          var lot = villcode[3];
      } else {
          villcode = village.split(" ");
          var mouza = villcode[0];
          var lot = villcode[1];
          var village = villcode[2];
      }

      var dag = $(this).val();

      // const loading = new Loading();
      $.ajax({
          url: baseurl +
              "SettlementCommon/getArea/" +
              district +
              "/" +
              subdiv +
              "/" +
              circle +
              "/" +
              mouza +
              "/" +
              lot +
              "/" +
              village +
              "/" +
              dag,
          success: function(data) {
              // loading.out();
              var area = JSON.parse(data);
              $("#additional_patta_prop").val(area.patta_no);
          },
          error: function(error) {
              // loading.out();
          },
      });
  });


  $('#submitAddProperty').click(function(e)
  {
      e.preventDefault();
      var ref_no = $("#application_no").val();
      var additional_district = $("#additional_district_prop").val();
      var additional_circle = $("#additional_circle_prop").val();
      var additional_bigha = $("#additional_bigha_prop").val();
      var additional_katha = $("#additional_katha_prop").val();
      var additional_lessa = $("#additional_lessa_prop").val();

      var additional_ganda = $("#additional_ganda_prop").val();
      var additional_kranti = $("#additional_kranti_prop").val();

      var additional_district_name = $( "#additional_district_prop option:selected" ).text();
      var additional_circle_name = $( "#additional_circle_prop option:selected" ).text();
      var is_additional_urban = $("#is_additional_urban_prop").val();
      var additional_village_code = $("#additional_village_prop").val();
      var additional_dag = $("#additional_dag_prop").val();
      var additional_patta = $("#additional_patta_prop").val();
      var service_code = $("#service_code").val();
      var additional_village = $( "#additional_village_prop option:selected" ).text();

      var is_landless_prop = $("#is_landless_prop").val();

      if(is_landless_prop == '' || is_landless_prop == null){
          $('.is_landless_propErr').fadeIn();
          $('.is_landless_propErr').html('<span style="color: red">⚠️ The Circle is required</span>');
          $('#is_landless_prop').focus();
          return false;
      }

      if(additional_circle == '' || additional_circle == null)
      {
        $('.additional_circle_propErr').fadeIn();
        $('.additional_circle_propErr').html('<span style="color: red">⚠️ The Circle is required</span>');
        $('#additional_circle_prop').focus();
        return false;
      }

      if(additional_village_code == '' || additional_village_code == null)
      {
        $('.additional_village_propErr').fadeIn();
        $('.additional_village_propErr').html('<span style="color: red">⚠️ The Village is required</span>');
        $('#additional_village_prop').focus();
        return false;
      }

      var villcode = additional_circle.split(",");
      var circle = villcode[0];
      var subdiv2 = villcode[1];
      var add_villcode = additional_village_code.split(",");
      if (add_villcode.length >1) {
        if (add_villcode.length == 4) {
          var village2 = add_villcode[0];
          var mouza2 = add_villcode[2];
          var lot2 = add_villcode[3];
        } else {
          add_villcode = add_villcode.split(" ");
          var mouza2 = add_villcode[0];
          var lot2 = add_villcode[1];
          var village2 = add_villcode[2];
        }
      }

      $.ajax({
        type: "POST",
        url: baseurl + "SettlementCommon/insertAdditionalProperty",
        async: false,
        data: {
          ref_no                    : ref_no,
          additional_district       : additional_district,
          subdiv_code               : subdiv2,
          additional_circle         : circle,
          mouza_pargona_code        : mouza2,
          vill_townprt_code         : village2,
          lot_no                    : lot2,
          additional_bigha          : additional_bigha,
          additional_katha          : additional_katha,
          additional_lessa          : additional_lessa,
          additional_ganda          : additional_ganda,
          additional_kranti         : additional_kranti,
          additional_district_name  : additional_district_name,
          additional_circle_name    : additional_circle_name,
          is_additional_urban       : is_additional_urban,
          additional_village        : additional_village,
          additional_dag            : additional_dag,
          additional_patta          : additional_patta,
          additional_village_code   : additional_village_code,
          is_landless_prop          : is_landless_prop,
        },
        dataType: "json",
        success: function (data) {

          if (data.responseType == 1) { // validation error
            data.validation.forEach(function(validation) {
              var errMsg = "#" + validation.field + "Err";
              $(errMsg).text("⚠️ " + validation.message);
            });
          }
          else if(data.responseType==3) {
            alert(data.message);
          }
          else if(data.status == 0) {
            alert("Please select property before proceed!!");
          }
          else if(data.status == 200) {

            if(data.result.applied_flag != 'CITIZEN') {
              $("#addPropData").append('<tr id="prop'+data.result.id+'"><td>'+data.result.dist_name+'</td><td>'+data.result.cir_name+'</td><td>'+data.result.bigha+'</td><td>'+data.result.katha+'</td><td>'+data.result.lessa+'</td><td>'+data.result.ganda+'</td><td>'+data.result.kranti+'</td><td><a href="javascript:void(0)" onclick="confirmDeleteModal('+data.result.id+')" class="btn btn-danger" id="delProperty">Delete</a></td></tr>');
            }
            else {
              $("#addPropData").append('<tr id="prop'+data.result.id+'"><td>'+data.result.dist_name+'</td><td>'+data.result.cir_name+'</td><td>'+data.result.bigha+'</td><td>'+data.result.katha+'</td><td>'+data.result.lessa+'</td><td>'+data.result.ganda+'</td><td>'+data.result.kranti+'</td><td></td></tr>');
            }

            $('.property_add_reset').val('');

            $( "#additional_circle_prop option:selected" ).val(null);
            $( "#additional_village_prop option:selected" ).val(null);
            $( "#additional_circle_prop option:selected" ).text('-- Select Circle --');
            $( "#additional_village_prop option:selected" ).text('-- Select Village --');

            showSuccessMessage("Property added successfully !");
          }
        },
      });
  });
  

  $('#saveChanges').click(function(){
    var ref_no = $("#application_no").val();
    Swal.fire({
      text: 'Are you sure to Save the changes those are made ? Once changes save, this can not be undone.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1 right-gap',
        confirmButton: 'order-2',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseurl + "SettlementCommon/saveAdditionalPropertyDetail",
          type: "post",
          data: {case_no : ref_no},
          dataType: "json",
          success: function(data) {
            if(data.response == 1)
            {
              $('#additionalPropertyModal').modal('hide');
              $('#require_changes').prop('disabled', false);
              $('.additional_property_add').css('display', 'none');
              $("#is_landless_prop option[value='']").prop('selected', 'selected');
              $('.entry_of_additional_property_div').hide();

              Swal.fire({
                backdrop: true,
                allowOutsideClick: false,
                icon: 'success',
                text: 'Additional property detail has successfully saved !!!',
                confirmButtonText: 'OK',                
                customClass: {
                  actions: 'my-actions',
                  confirmButton: 'order-2',
                }
              })
              .then((result) => {
                if (result.isConfirmed) {
                  window.location.reload();
                }
              })             
            }        
          },
          error: function(err) {
            showErrorMessage('Something went wrong');
          }
        });
      }        
    }) 
  });
  

</script>

