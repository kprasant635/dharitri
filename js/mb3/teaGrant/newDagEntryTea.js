
  var newTeaGrantDagEntryModal = document.getElementById("newTeaGrantDagEntryDetails");
  var scode                    = $('#code_service').val();  
  var dist                     = $('#code_dist').val();
  var subdiv                   = $('#code_sub').val();
  var cir                      = $('#code_cir').val();
  var mouza                    = $('#code_mouza').val();
  var lot                      = $('#code_lot').val();
  var vill                     = $('#code_vill').val();
  var rural_urban              = $('#code_rural_urban').val();
  var case_no                  = $('#case_no').val();

   // Success Message
  function showSuccessMessage(text) {
    swal.fire({
      title: "Success !",
      text: text,
      icon: 'success',
      position: 'top',
      showConfirmButton: true,
      timer: 5000,
    });
  }

  // Success Message
  function showErrorMessage(text) {
    swal.fire({
      title: "Error !",
      text: text,
      icon: 'error',
      position: 'top',
      showConfirmButton: true,
      timer: 5000,
    });
  }

  barak_valley = new Array('21','22','23');

  function loader() {
    $.blockUI({
      message: $('#displayBox'),
      css: {
        border:'none',
        backgroundColor:'transparent'
      }
    });
  }

  // list of patta types
  function addTeaGrantPattaDetail(res) {
    loader();
    newTeaGrantDagEntryModal.style.display = "block";
    var location_detail = {
      dist        : dist,
      subdiv      : subdiv,
      cir         : cir,
      mouza       : mouza,
      lot         : lot,
      vill        : vill,
    };
    $.ajax({
      url      : baseurl + "TeaGrantControllerLm/getTeaGrantPattaTypeList",
      type     : "post",
      dataType : "json",
      success: function(data) 
      {        
        $.unblockUI();
        $('#clicked_from').val(res);
        var template = "<option value='' disabled selected>-- Select Patta Type --</option>";
        for(i=0; i<data.length; i++){
          template += "<option value='" + data[i].patta_type_code + "'>" + data[i].patta_name + "</option>";
        }
        $('#new_patta_type').html(template);
      }, error: (error) => {
        $.unblockUI();
        showErrorMessage("#ERR80: Error in fetching Dag detail. Kindly contact system administrator!!!");
      },
      data: JSON.stringify(location_detail)
    });
  }

  $('#new_patta_type').change(function(e)
  {
    e.preventDefault();
    loader();
    var location_detail = {
      dist      : dist,
      subdiv    : subdiv,
      cir       : cir,
      mouza     : mouza,
      lot       : lot,
      vill      : vill,
      ptypecode : $('#new_patta_type').val(),
      case_no   : case_no,
    };
    $.ajax({
      url      : baseurl + "TeaGrantControllerLm/getTeaGrantPattaNoList",
      type     : "post",
      dataType : "json",
      success: function(data) 
      {        
        $.unblockUI();
        reset_modal_data();
        no_list = data.patta_no_list;

        if(data.data_exist == 0) // if no data found then newly patta applied
        {
          Swal.fire({
            icon              : 'warning',
            backdrop          : true,
            allowOutsideClick : false,
            text              : 'You have selected a different Patta type. Submitting this change, will remove all previously entered details for this application, including existing pattadar(s), owner(s), and deed applicant(s). Are you sure you want to proceed?',
            showDenyButton    : true,
            confirmButtonText : 'Yes',
            customClass       : {
              actions         : 'my-actions',
              confirmButton   : 'order-2',
            },
          }).then((result) => {
            if(result.isConfirmed) // for updation of new application
            {
              $('#applied_detail').val(1);
              var template = "<option value='' disabled selected>-- Select Patta No --</option>";
              for(i=0; i < no_list.length; i++)
              {
                template +="<option value='" + no_list[i].patta_no + "'>" + no_list[i].patta_no + "</option>";
              }
              $('#new_patta_no').html(template);
            }
            else
            {
              $('#applied_detail').val(0);
              addTeaGrantPattaDetail();
              reset_modal_data();
            }
          });
        }
        else
        {
          $('#applied_detail').val(0);
          var template = "<option value='' disabled selected>-- Select Patta No --</option>";
          for(i=0; i < no_list.length; i++)
          {
            template +="<option value='" + no_list[i].patta_no + "'>" + no_list[i].patta_no + "</option>";
          }
          $('#new_patta_no').html(template);
        }        
      }, error: (error) => {
        $.unblockUI();
        showErrorMessage("#ERR80: Error in fetching Dag detail. Kindly contact system administrator!!!");
      },
      data: JSON.stringify(location_detail)
    });
  })

  $('#new_patta_no').change(function(e)
  {
    e.preventDefault();
    loader();
    var location_detail = {
      dist      : dist,
      subdiv    : subdiv,
      cir       : cir,
      mouza     : mouza,
      lot       : lot,
      vill      : vill,
      ptypecode : $('#new_patta_type').val(),
      pno       : $('#new_patta_no').val(),
      case_no   : case_no,
    };
    $.ajax({
      url      : baseurl + "TeaGrantControllerLm/getTeaGrantDagList",
      type     : "post",
      dataType : "json",
      success: function(data) 
      {        
        $.unblockUI();
        reset_modal_data();
        dag_list = data.dag_list;

        if(data.data_exist == 0) // if 0 then new patta no selected
        {
          Swal.fire({
            icon              : 'warning',
            backdrop          : true,
            allowOutsideClick : false,
            text              : 'You have selected a different Patta No. Submitting this change, will remove all previously entered details for this application, including existing pattadar(s), owner(s), and deed applicant(s). Are you sure you want to proceed?',
            showDenyButton    : true,
            confirmButtonText : 'Yes',
            customClass       : {
              actions         : 'my-actions',
              confirmButton   : 'order-2',
            },
          }).then((result) => {
            if(result.isConfirmed) // for updation of new application
            {
              $('#applied_detail').val(1);
              
              var template = "<option value='' selected disabled>-- Select Dag --</option>";
              if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
                for (var i = 0; i < dag_list.length; i++) {
                  template += "<option value='"+dag_list[i].dag_no_int+"/"+dag_list[i].bigha+"/"+dag_list[i].katha+"/"+dag_list[i].lessa+"'>" + dag_list[i].dag_no + " (B/K/L): " + dag_list[i].bigha + "/"+ dag_list[i].katha + "/"+ dag_list[i].lessa +"</option>";
                }
              }
              else { // for barak valley
                for (var i = 0; i < dag_list.length; i++) {
                  template += "<option value='"+dag_list[i].dag_no_int+"/"+dag_list[i].bigha+"/"+dag_list[i].katha+"/"+dag_list[i].lessa+"/"+dag_list[i].ganda+"'>" + dag_list[i].dag_no + " (B/K/C/G): " + dag_list[i].bigha + "/"+ dag_list[i].katha + "/"+ dag_list[i].lessa + "/"+ dag_list[i].ganda +"</option>";
                }
              }
              $("#dag_list").html(template);
            }
            else
            {
              $('#applied_detail').val(0);
              addTeaGrantPattaDetail();
              var template = "<option value='' disabled selected>-- Select Patta No --</option>";
              $('#new_patta_no').html(template);
            }
          });
        }
        else
        {
          $('#applied_detail').val(0);
          
          var template = "<option value='' selected disabled>-- Select Dag --</option>";
          if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
            for (var i = 0; i < dag_list.length; i++) {
              template += "<option value='"+dag_list[i].dag_no_int+"/"+dag_list[i].bigha+"/"+dag_list[i].katha+"/"+dag_list[i].lessa+"'>" + dag_list[i].dag_no + " (B/K/L): " + dag_list[i].bigha + "/"+ dag_list[i].katha + "/"+ dag_list[i].lessa +"</option>";
            }
          }
          else { // for barak valley
            for (var i = 0; i < dag_list.length; i++) {
              template += "<option value='"+dag_list[i].dag_no_int+"/"+dag_list[i].bigha+"/"+dag_list[i].katha+"/"+dag_list[i].lessa+"/"+dag_list[i].ganda+"'>" + dag_list[i].dag_no + " (B/K/C/G): " + dag_list[i].bigha + "/"+ dag_list[i].katha + "/"+ dag_list[i].lessa + "/"+ dag_list[i].ganda +"</option>";
            }
          }
          $("#dag_list").html(template);
        }        
      }, error: (error) => {
        $.unblockUI();
        showErrorMessage("#ERR80: Error in fetching Dag detail. Kindly contact system administrator!!!");
      },
      data: JSON.stringify(location_detail)
    });
  });

  //closing modal
  $('.close-new-dag-entry').click(function()
  {
    newTeaGrantDagEntryModal.style.display = "none";
    reset_modal_data();
  });

  function reset_modal_data()
  {
    $('#pattadar_list_details').html('');
    $('#pattadar_not_exist_id').html('');
    $('#area_details').html('');
    $('.pattadar_detail').hide();

    var dag_list = "<option value='' selected disabled>-- Select Dag --</option>";
    $("#dag_list").html(dag_list);
  }

  //on change dag
  $("#dag_list").change(function()
  {
    loader();

    dag_no_int    = $("#dag_list").val();
    const myArray = dag_no_int.split("/");
    dag           = myArray[0];

    var dag_detail = {
      dist           : dist,
      subdiv         : subdiv,
      cir            : cir,
      mouza          : mouza,
      lot            : lot,
      vill           : vill,
      scode          : scode,
      case_no        : case_no,
      dag            : dag,
      new_patta_no   : $('#new_patta_no').val(),
      new_patta_type : $('#new_patta_type').val(),
    };

    $.ajax({
      url      : baseurl + "TeaGrantControllerLm/getTeaGrantPattadarsList",
      type     : "post",
      dataType : "json",
      success: function(data) {

        $.unblockUI();
        $('.pattadar_detail').show();
        if(data.responseType != 2){
          showErrorMessage('No Pattadar(s) detail found !!! ');
          return false;
        }
  
        var template  = "";
        var template1 = "";
        for(i=0; i < data.pattadar_list.length; i++) {

          template += '<label class="list-group-item">'+
                        '<div class="col-lg-1"><input class="form-check-input pattadar" type="checkbox" id="pattadar'+data.pattadar_list[i].pdar_id+'" value="'+data.pattadar_list[i].pdar_id+'" name="pattadar['+data.pattadar_list[i].pdar_id+']"></div>'+
                        '<label>'+
                          '<b>Name</b>: <span style="color:red">' + data.pattadar_list[i].pdar_name + '</span>&nbsp;&nbsp;&nbsp;'+
                          '<b>Guardian</b>: <span style="color:red">' + data.pattadar_list[i].pdar_father + '</span>'+
                        '</label>'+
                      '</label>';
        }

        $('#pattadar_list_details').html(template);
  
        if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
          
          template1 = '<div class="row">'+
                        '<div class="col-md-3">'+
                          '<label>Bigha</label>'+
                          '<input type="numeric" class="form-control" name="bigha" id="bigha" value="0"  min="0" max="50">'+
                        '</div>'+
                        '<div class="col-md-3">'+
                          '<label>Katha</label>'+
                          '<select class="form-control" name="katha" id="katha">'+
                            '<option value="0">0</option>'+
                            '<option value="1">1</option>'+
                            '<option value="2">2</option>'+
                            '<option value="3">3</option>'+
                            '<option value="4">4</option>'+
                          '</select>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                          '<label>Lessa</label>'+
                          '<input type="numeric" class="form-control" name="lessa" id="lessa" value="0"  min="0">'+
                        '</div>'+
                        '<div class="col-md-3" style="display:none">'+
                          '<label>Ganda</label>'+
                          '<input type="hidden" class="form-control" name="ganda" id="ganda" value="0"  min="0">'+
                        '</div>'+
                      '</div>';
        }
        else
        {
          template1 = '<div class="row">'+
                        '<div class="col-md-3">'+
                          '<label>Bigha</label>'+
                          '<input type="numeric" class="form-control" name="bigha" id="bigha" value="0"  min="0" max="50">'+
                        '</div>'+
                        '<div class="col-md-3">'+
                          '<label>Katha</label>'+
                          '<select class="form-control" name="katha" id="katha">'+
                            '<option value="0">0</option>'+
                            '<option value="1">1</option>'+
                            '<option value="2">2</option>'+
                            '<option value="3">3</option>'+
                            '<option value="4">4</option>'+
                            '<option value="5">5</option>'+
                            '<option value="6">6</option>'+
                            '<option value="7">7</option>'+
                            '<option value="8">8</option>'+
                            '<option value="9">9</option>'+
                            '<option value="10">10</option>'+
                            '<option value="11">11</option>'+
                            '<option value="12">12</option>'+
                            '<option value="13">13</option>'+
                            '<option value="14">14</option>'+
                            '<option value="15">15</option>'+
                            '<option value="16">16</option>'+
                            '<option value="17">17</option>'+
                            '<option value="18">18</option>'+
                            '<option value="19">19</option>'+
                            '<option value="20">20</option>'+
                          '</select>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                          '<label>Chatak</label>'+
                          '<input type="numeric" class="form-control" name="lessa" id="lessa" value="0"  min="0">'+
                        '</div>'+
                        '<div class="col-md-3">'+
                          '<label>Ganda</label>'+
                          '<input type="numeric" class="form-control" name="ganda" id="ganda" value="0"  min="0">'+
                        '</div>'+
                      '</div>';
        }
        $('#area_details').html(template1);

        if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
          chitha_bigha = myArray[1];
          chitha_katha = myArray[2];
          chitha_lessa = myArray[3];
          chitha_ganda = 0;
          chitha_krant = 0;
        }
        else { // for barak valley
          chitha_bigha = myArray[1];
          chitha_katha = myArray[2];
          chitha_lessa = myArray[3];
          chitha_ganda = myArray[4];
          chitha_krant = 0;
        }
  
        var pdar_not_exist = '<label class="list-group-item">'+
                                '<div class="col-lg-1"><input class="form-check-input me-1 form_input ps-3 pattadar_not_exist" type="checkbox" id="pattadar_not_exist" name="pattadar_not_exist" value="-1" onclick="pattadar_not_existFunc()"></div>'+
                                '<label>'+
                                  '<b><span style="color:red"> Click if Pattadar doesn\'t exist in the above list!</span></b>'+
                                '</label>'+
                              '</label>'+

                              '<input type="hidden" name="rural_urban"        value="'+rural_urban+'">'+
                              '<input type="hidden" name="dist_code"          value="'+dist+'">'+
                              '<input type="hidden" name="subdiv_code"        value="'+subdiv+'">'+
                              '<input type="hidden" name="cir_code"           value="'+cir+'">'+
                              '<input type="hidden" name="mouza_pargona_code" value="'+mouza+'">'+
                              '<input type="hidden" name="lot_no"             value="'+lot+'">'+
                              '<input type="hidden" name="vill_townprt_code"  value="'+vill+'">'+

                              '<input type="hidden" name="chitha_bigha"       value="'+chitha_bigha+'"  >'+
                              '<input type="hidden" name="chitha_katha"       value="'+chitha_katha+'"  >'+
                              '<input type="hidden" name="chitha_lessa"       value="'+chitha_lessa+'"  >'+
                              '<input type="hidden" name="chitha_ganda"       value="'+chitha_ganda+'"  >'+
                              '<input type="hidden" name="chitha_kranti"      value="'+chitha_krant+'"  >'+
                              '<input type="hidden" name="dag_no" id="dag_no" value="'+myArray[0]+'"    >'+

                              '<input type="hidden" name="get_dag" class="get_dag'+myArray[0]+'" value="'+myArray[0]+'">';

        $('#pattadar_not_exist_id').html(pdar_not_exist);

      }, 
      error: (error) => {
        $.unblockUI();
        showErrorMessage("SOMETHING WENT WRONG !!!!");
      },
      data: JSON.stringify(dag_detail)
    });
  });

  //on save dag/occupier detail
  $('#saveTeaGrantNewDag').click(function()
  {
    let selectedPattadarIds = [];
    $('.pattadar:checked').each(function () {
      selectedPattadarIds.push($(this).val());
    });

    var case_no              = $('#case_no').val();
    var application_no       = $('#basu_appl_no').val();
    var new_dag_int          = $('#dag_list').val();
    var chitha_bigha         = $('#chitha_bigha').val();
    var chitha_katha         = $('#chitha_katha').val();
    var chitha_lessa         = $('#chitha_lessa').val();
    var chitha_ganda         = $('#chitha_ganda').val();
    var chitha_kranti        = $('#chitha_kranti').val();
    var pattadar_not_exist   = $('.pattadar_not_exist').prop('checked') == true ? $('#pattadar_not_exist').val() : null;
    var applied_bigha        = $('#bigha').val();
    var applied_katha        = $('#katha').val();
    var applied_lessa        = $('#lessa').val();
    var applied_ganda        = $('#ganda').val();
    var pattadar             = selectedPattadarIds;
    var land_owner_id        = $('#land_owner_list').val();
    var new_dag_deed_no      = $('#new_dag_deed_no').val();
    var new_dag_name_in_asm  = $('#new_dag_name_in_asm').val();
    var new_dag_name_in_eng  = $('#new_dag_name_in_eng').val();
    var new_dag_gname_in_asm = $('#new_dag_gname_in_asm').val();
    var new_dag_gname_in_eng = $('#new_dag_gname_in_eng').val();
    var new_dag_relation     = $('#new_dag_relation').val();
    var new_dag_gender       = $('#new_dag_gender').val();
    var new_dag_mobile       = $('#new_dag_mobile').val();
    var new_dag_dob          = $('#new_dag_dob').val();
    var applied_detail       = $('#applied_detail').val();
    var new_patta_type       = $('#new_patta_type').val();
    var new_patta_no         = $('#new_patta_no').val();
    var clicked_from         = $('#clicked_from').val();

    const parameters = {
      case_no              : case_no,
      application_no       : application_no,
      district             : dist,
      subdiv_code          : subdiv,
      circle               : cir,
      mouza_code           : mouza,
      lot_no               : lot,
      village              : vill,
      service_code         : '43',
      dag                  : new_dag_int,
      chitha_bigha         : chitha_bigha,
      chitha_katha         : chitha_katha,
      chitha_lessa         : chitha_lessa,
      chitha_ganda         : chitha_ganda,
      chitha_kranti        : chitha_kranti,  
      pattadar_not_exist   : pattadar_not_exist,
      applied_bigha        : applied_bigha,
      applied_katha        : applied_katha,
      applied_lessa        : applied_lessa,
      applied_ganda        : applied_ganda,
      pattadar             : pattadar,
      rural_urban          : rural_urban,
      land_owner_id        : land_owner_id,
      new_dag_deed_no      : new_dag_deed_no,
      new_dag_name_in_asm  : new_dag_name_in_asm,
      new_dag_name_in_eng  : new_dag_name_in_eng,
      new_dag_gname_in_asm : new_dag_gname_in_asm,
      new_dag_gname_in_eng : new_dag_gname_in_eng,
      new_dag_relation     : new_dag_relation,
      new_dag_gender       : new_dag_gender,
      new_dag_mobile       : new_dag_mobile,
      new_dag_dob          : new_dag_dob,
      applied_detail       : applied_detail,
      new_patta_type       : new_patta_type,
      new_patta_no         : new_patta_no,
      clicked_from         : clicked_from,
    };

    if(applied_detail == 1)
    {
      var msg = 'You have selected a different Patta No. Submitting this change, the case will land on `FORWARDED BY CO` and all previously entered details of this application, including existing pattadar(s), owner(s), and deed applicant(s) will be removed. Are you sure you want to proceed?';
    }
    else
    {
      var msg = 'Are you sure to proceed with the changes?';
    }

    Swal.fire({
      icon             : 'warning',
      backdrop          : true,
      allowOutsideClick : false,
      text              : msg,
      showDenyButton    : true,
      confirmButtonText : 'Yes',
      customClass       : {
        actions         : 'my-actions',
        confirmButton   : 'order-2',
      },
    }).then((result) => {
      if(result.isConfirmed) // for updation of new application
      {
        loader();
        $.ajax({
          url      : baseurl + "TeaGrantControllerLm/saveTeaGrantDagDetail",
          type: "post",
          dataType: "json",
          success: function(data) {
            
            $.unblockUI();
            if(data.responseType == 0)
            {
              showErrorMessage(data.msg);
              return;
            }
            else if (data.responseType == 2) {
              newTeaGrantDagEntryModal.style.display = "none";
              Swal.fire({
                backdrop:true,
                allowOutsideClick: false,
                text: data.msg,
                confirmButtonText: 'OK',
                customClass: {
                  actions: 'my-actions',
                  confirmButton: 'order-2',
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload(true);
                }
              });
            }
            else { //error messages
              showErrorMessage(data.msg);
            }        
          }, error: (error) => {
            $.unblockUI();
            showErrorMessage("SOMETHING WENT WRONG !!!!");
          },
          data: JSON.stringify(parameters)
        });
      }
    });

    
  });

  function pattadar_not_existFunc() 
  {
    loader();
    new_ded_data_reset();

    if($('.pattadar_not_exist').prop('checked') === true) 
    {
      $('.pattadar').prop('checked', false).prop('disabled', true);
      $('.new_dag_div_deed_detail').show();
      $('#pattadar_list_details').hide();
    }
    else
    {
      $('.pattadar').prop('disabled', false);
      $('.new_dag_div_deed_detail').hide();
      $('#pattadar_list_details').show();
    }

    var location_detail = {
      dist           : dist,
      subdiv         : subdiv,
      cir            : cir,
      mouza          : mouza,
      lot            : lot,
      vill           : vill,
      scode          : scode,
      case_no        : case_no,
      dag            : $('#dag_no').val(),
      new_patta_no   : $('#new_patta_no').val(),
      new_patta_type : $('#new_patta_type').val(),
    };

    $.ajax({
      url      : baseurl + "TeaGrantControllerLm/getTeaGrantPattadarsList",
      type     : "post",
      dataType : "json",
      success: function(data) {

        $.unblockUI();  
        var land_template = "<option value='' disabled selected>-- Select Land Owner --</option>";
        for(i=0; i < data.pattadar_list.length; i++) {
          land_template += '<option value="'+data.pattadar_list[i].pdar_id+'">'+data.pattadar_list[i].pdar_name + '</option>';
        }
        $('#land_owner_list').html(land_template);


        var gender_template = "<option value='' disabled selected>-- Select Gender --</option>"+
                        "<option value='1'>Male</option>"+
                        "<option value='2'>Female</option>"+
                        "<option value='3'>Others</option>";
        $('#new_dag_gender').html(gender_template);


        var relation_template = "<option value='' disabled selected>-- Select Relation --</option>"+
                        "<option value='1'>মাতৃ (Mother)</option>"+
                        "<option value='2'>পিতৃ (Father)</option>"+
                        "<option value='3'>পতি (Husband)</option>"+
                        "<option value='4'>পত্নী (Wife)</option>"+
                        "<option value='7'>অভিভাৱক (Guardian)</option>";
        $('#new_dag_relation').html(relation_template);
      }, 
      error: (error) => {
        $.unblockUI();
        showErrorMessage("SOMETHING WENT WRONG !!!!");
      },
      data: JSON.stringify(location_detail)
    });

  }


  function new_ded_data_reset()
  {
    $('.new_dag_data').val('');
  }

  $(function () {
    $('#new_dag_dob').datepick({dateFormat: 'dd-mm-yyyy'});
  });

  