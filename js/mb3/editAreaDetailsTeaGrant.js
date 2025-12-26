


  var areaModal = document.getElementById("editAreaDetailsTea");
  // Get the <span> element that closes the modal
  var spanArea = document.getElementsByClassName("close-edit-area")[0];

  function editAreaTeaGrant(id, dag_no){
    //****to display the modal */
    areaModal.style.display = "block";
    //****to close the modal */
    spanArea.onclick = function() {
      Swal.fire({
        text               : 'Closing this modal without saving will erase any edited data ! Are you sure ?',
        icon               : 'warning',
        showCancelButton   : true,
        confirmButtonText  : 'Yes',
        confirmButtonColor : "#B82929",
      }).then((result) => {
        if (result.isConfirmed) {
          areaModal.style.display = "none";
        }
      })
    }
  
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == areaModal) {
        Swal.fire({
          text               : 'Closing this modal without saving will erase any edited data ! Are you sure ?',
          icon               : 'warning',
          showCancelButton   : true,
          confirmButtonText  : 'Yes',
          confirmButtonColor : "#B82929",
        }).then((result) => {
          if (result.isConfirmed) {
            areaModal.style.display = "none";
          }
        })
      }
    }

    var edit_area_span_dag_no   = $.trim($('#dag_no'+dag_no).val());
    var edit_area_span_patta_no = $.trim($('#patta_no'+dag_no).val());
    $('#edit_area_span_dag_no').html(edit_area_span_dag_no);
    $('#edit_area_span_patta_no').html(edit_area_span_patta_no);

    $('#area_update_id').val(id);
    $('#area_update_dag_no').val(dag_no);
    $('#area_service_code').val($.trim($('#service_code_lm').val()));
    // alert($.trim($('#area_new'+dag_no).val()));

    var urbanCheck = $.trim($('#urbanCheck'+dag_no).val());

    $('#area_update_urban_check').val(urbanCheck);
    $('#area_update_case_no').val($.trim($('#case_no').val()));

    //****getting the total area in the land */
    var total_bigha_in_dag  = $.trim($('#dag_area_b'+dag_no).val());
    var total_katha_in_dag  = $.trim($('#dag_area_k'+dag_no).val());
    var total_lessa_in_dag  = $.trim($('#dag_area_lc'+dag_no).val());
    var total_ganda_in_dag  = $.trim($('#dag_area_g'+dag_no).val());
    var total_kranti_in_dag = $.trim($('#dag_area_kr'+dag_no).val());
    $('#total_bigha_in_dag').val(total_bigha_in_dag);
    $('#total_katha_in_dag').val(total_katha_in_dag);
    $('#total_lessa_in_dag').val(total_lessa_in_dag);
    $('#total_ganda_in_dag').val(total_ganda_in_dag);
    $('#total_kranti_in_dag').val(total_kranti_in_dag);

    //****encroachment area homestead */
    var enc_home_b  = $.trim($('#enc_home_b'+dag_no).val());
    var enc_home_k  = $.trim($('#enc_home_k'+dag_no).val());
    var enc_home_lc = $.trim($('#enc_home_lc'+dag_no).val());
    var enc_home_g  = $.trim($('#enc_home_g'+dag_no).val());
    var enc_home_kr = $.trim($('#enc_home_kr'+dag_no).val());
    $('#enc_bigha_home').val(enc_home_b);
    $('#enc_katha_home').val(enc_home_k);
    $('#enc_lessa_home').val(enc_home_lc);
    $('#enc_ganda_home').val(enc_home_g);
    $('#enc_kranti_home').val(enc_home_kr);
  }

  function updateAreaDetailsTeaGrant()
  {
    const BARAK_VELLY           = ["21", "22", "23"];
    area_service_code           = $.trim($('#area_service_code').val());
    var area_update_id          = $.trim($('#area_update_id').val());
    var area_update_dag_no      = $.trim($('#area_update_dag_no').val());
    var area_update_urban_check = $.trim($('#area_update_urban_check').val());
    var area_update_case_no     = $.trim($('#area_update_case_no').val());
    var total_bigha_in_dag      = $.trim($('#total_bigha_in_dag').val());
    var total_katha_in_dag      = $.trim($('#total_katha_in_dag').val());
    var total_lessa_in_dag      = $.trim($('#total_lessa_in_dag').val());
    var total_ganda_in_dag      = $.trim($('#total_ganda_in_dag').val());
    var total_kranti_in_dag     = $.trim($('#total_kranti_in_dag').val());
    var enc_bigha_home          = $.trim($('#enc_bigha_home').val());
    var enc_katha_home          = $.trim($('#enc_katha_home').val());
    var enc_lessa_home          = $.trim($('#enc_lessa_home').val());
    var enc_ganda_home          = $.trim($('#enc_ganda_home').val());
    var enc_kranti_home         = $.trim($('#enc_kranti_home').val());

    if(area_update_id == ''){
      $("#area_update_id").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#area_update_id').focus();
      return false;
    }
    if(area_update_dag_no == ''){
      $("#area_update_dag_no").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#area_update_dag_no').focus();
      return false;
    }

    if(area_update_urban_check == ''){
      $("#area_update_urban_check").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#area_update_urban_check').focus();
      return false;
    }

    if(area_update_case_no == ''){
      $("#area_update_case_no").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#area_update_case_no').focus();
      return false;
    }

    if(total_bigha_in_dag == ''){
      $("#total_bigha_in_dag").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#total_bigha_in_dag').focus();
      return false;
    };
    if(total_katha_in_dag == ''){
      $("#total_katha_in_dag").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#total_katha_in_dag').focus();
      return false;
    };
    if(total_lessa_in_dag == ''){
      $("#total_lessa_in_dag").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#total_lessa_in_dag').focus();
      return false;
    };
    if(BARAK_VELLY.includes($('#dist_code').val())){
      if(total_ganda_in_dag == ''){
        $("#total_ganda_in_dag").notify(
          "This field is required !", 
          { position:"bottom right", arrowSize: 10 }
        );
        $('#total_ganda_in_dag').focus();
        return false;
      };
      if(total_kranti_in_dag == ''){
        $("#total_kranti_in_dag").notify(
          "This field is required !", 
          { position:"bottom right", arrowSize: 10 }
        );
        $('#total_kranti_in_dag').focus();
        return false;
      };
    }

    if(enc_bigha_home == ''){

      $("#enc_bigha_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#enc_bigha_home').focus();
      return false;
    }
    if(enc_katha_home == ''){
      $("#enc_katha_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#enc_katha_home').focus();
      return false;
    }
    if(enc_lessa_home == ''){
      $("#enc_lessa_home").notify(
        "This field is required !", 
        { position:"bottom right", arrowSize: 10 }
      );
      $('#enc_lessa_home').focus();
      return false;
    }

    if(BARAK_VELLY.includes($('#dist_code').val())){
      if(enc_ganda_home == ''){
        $("#enc_ganda_home").notify(
          "This field is required !", 
          { position:"bottom right", arrowSize: 10 }
        );
        $('#enc_ganda_home').focus();
        return false;
      }
      if(enc_kranti_home == ''){
        $("#enc_kranti_home").notify(
          "This field is required !", 
          { position:"bottom right", arrowSize: 10 }
        );
        $('#enc_kranti_home').focus();
        return false;
      }
    }

    // prepare for updation
    var postData = {
      'area_update_id'          : area_update_id,
      'area_update_dag_no'      : area_update_dag_no,
      'area_update_urban_check' : area_update_urban_check,
      'area_update_case_no'     : area_update_case_no,
      'total_bigha_in_dag'      : total_bigha_in_dag,
      'total_katha_in_dag'      : total_katha_in_dag,
      'total_lessa_in_dag'      : total_lessa_in_dag,
      'total_ganda_in_dag'      : total_ganda_in_dag,
      'total_kranti_in_dag'     : total_kranti_in_dag,
      'enc_bigha_home'          : enc_bigha_home,
      'enc_katha_home'          : enc_katha_home,
      'enc_lessa_home'          : enc_lessa_home,
      'enc_ganda_home'          : enc_ganda_home,
      'enc_kranti_home'         : enc_kranti_home,
    };

    $.blockUI({
      message           : $('#displayBox'),
      css               : {
        border          :'none',
        backgroundColor :'transparent'
      }
    });

    $.ajax({
      url  : baseurl+'TeaGrantController/updateTeaGrantAreaDetails',
      type : "POST",
      data : postData,
      success: function(data) {
        arr = JSON.parse(data);
        $.unblockUI();
        if(arr.responseType == 0){
          Swal.fire({
            text              : arr.msg,
            icon              : 'error',
            confirmButtonText : 'OK',
          })
        }
        else
        {
          //***to reset the premium on edit area */
          // reset();

          areaModal.style.display = "none";
          Swal.fire({
            text              : arr.msg,
            icon              : 'success',
            confirmButtonText : 'OK',
            customClass       : {
              actions         : 'my-actions',
              confirmButton   : 'order-2',
            }
          }).then((result) => {
            if (result.isConfirmed) 
            {
              areaModal.style.display = "none";
              //*****parsing the encroachment_area data */
              enc_area = JSON.parse(arr.appnData.encroachement_area);

              $('#enc_home_b'+area_update_dag_no).val(enc_area.homestead.bigha);
              $('#enc_home_k'+area_update_dag_no).val(enc_area.homestead.katha);
              $('#enc_home_lc'+area_update_dag_no).val(enc_area.homestead.lessa);
              $('#enc_home_g'+area_update_dag_no).val(enc_area.homestead.ganda);
              $('#enc_home_kr'+area_update_dag_no).val(enc_area.homestead.kranti);             

              //*****append total settlement area */
              //*****homestead */
              $('#total_applied_home_bigha').val(arr.totalSettlementAreaHome[0]);
              $('#total_applied_home_katha').val(arr.totalSettlementAreaHome[1]);
              $('#total_applied_home_lessa').val(arr.totalSettlementAreaHome[2]);
              $('#total_applied_home_ganda').val(arr.totalSettlementAreaHome[3]);
              $('#total_applied_home_kranti').val(0);

              window.location.reload();
            }
          })
        }
      }
    });
  }

  
  function deleteDagTea(id, dag_no) {

      case_no = $('#case_no').val();

      if(confirm("Are you sure you want to delete this Dag?")){

          $.blockUI({
              message: $('#displayBox'),
              css: {
                  border:'none',
                  backgroundColor:'transparent'
              }
          });
          // $("#sp" + id).remove();
          $.ajax({
          type: "POST",
          url: baseurl+'SettlementCommon/deleteDagArea',
          async: false,
          // dataType: 'json',
          data: { id: id, case_no:case_no, dag_no:dag_no },
          success: function (response) {
              $.unblockUI();
              const data = JSON.parse(response);
              // console.log(data);
              if(data.status == 0)
              {
              showErrorMessage(data.message+": something went wrong!!");
              }
              else {
              //   $("#sp" + id).remove();
                  $("#insdag" + id).show();
                  $("#deldag" + id).hide();
                  $("#editarea" + id).hide();
                  $("#dageligiblemsg" + id).show();
                  $("#dageligiblemsg" + id).text("This dag was Removed by LM!!!");
                  $("#total_applied_home_bigha").val(data.total_home_bigha);
                  $("#total_applied_home_katha").val(data.total_home_katha);
                  $("#total_applied_home_lessa").val(data.total_home_lessa);
                  $("#total_applied_home_ganda").val(data.total_home_ganda);
                  $("#total_applied_home_kranti").val(data.total_home_kranti);

                  $("#total_applied_agri_bigha").val(data.total_agri_bigha);
                  $("#total_applied_agri_katha").val(data.total_agri_katha);
                  $("#total_applied_agri_lessa").val(data.total_agri_lessa);
                  $("#total_applied_agri_ganda").val(data.total_agri_ganda);
                  $("#total_applied_agri_kranti").val(data.total_agri_kranti);
                  showSuccessMessage("Dag Deleted!!");
                  // location.reload(true);
                  window.location = window.location;
              }         
          }
          });
      }
      else {
          // loading.out();
      }

  }

  function insertDagTea(id, dag_no) {

      case_no = $('#case_no').val();
      if(confirm("Are you sure you want to insert this dag?")){
          // $("#sp" + id).remove();
          $.ajax({
              type: "POST",
              url: baseurl+'SettlementCommon/insertDagArea',
              async: false,
              // dataType: 'json',
              data: { id: id, case_no:case_no, dag_no:dag_no },
              success: function (response) {
              const data = JSON.parse(response);
              // console.log(data);
              if(data.status == 0)
              {
                  showErrorMessage("something went wrong!!");
              }
              else {
              //   $("#sp" + id).remove();
                  $("#insdag" + id).hide();
                  $("#deldag" + id).show();
                  $("#editarea" + id).show();
                  $("#dageligiblemsg" + id).hide();
                  $("#total_applied_home_bigha").val(data.total_home_bigha);
                  $("#total_applied_home_katha").val(data.total_home_katha);
                  $("#total_applied_home_lessa").val(data.total_home_lessa);
                  $("#total_applied_home_ganda").val(data.total_home_ganda);
                  $("#total_applied_home_kranti").val(data.total_home_kranti);

                  $("#total_applied_agri_bigha").val(data.total_agri_bigha);
                  $("#total_applied_agri_katha").val(data.total_agri_katha);
                  $("#total_applied_agri_lessa").val(data.total_agri_lessa);
                  $("#total_applied_agri_ganda").val(data.total_agri_ganda);
                  $("#total_applied_agri_kranti").val(data.total_agri_kranti);
                  showSuccessMessage("Dag Inserted!!");
                  window.location = window.location;
              }         
              }
          });
      }
      else {
      // loading.out();
      }

  }


  function insertDagRevert(id, dag_no)
  {
      case_no = $('#case_no').val();
      if(confirm("Are you sure you want to insert this dag?")){
          $.blockUI({
              message: $('#displayBox'),
              css: {
                  border:'none',
                  backgroundColor:'transparent'
              }
          });
          // $("#sp" + id).remove();
          $.ajax({
              type: "POST",
              url: baseurl+'SettlementCommon/insertDagAreaRevert',
              async: false,
              // dataType: 'json',
              data: { id: id, case_no:case_no, dag_no:dag_no },
              success: function (response) {
                  const data = JSON.parse(response);
                  $.unblockUI();

                  // console.log(data);
                  if(data.status == 0)
                  {
                      showErrorMessage(data.message+" :something went wrong!!");
                  }
                  else {
                  //   $("#sp" + id).remove();
                      $("#insdag" + id).hide();
                      $("#deldag" + id).show();
                      $("#editarea" + id).show();
                      $("#dageligiblemsg" + id).hide();
                      $("#total_applied_home_bigha").val(data.total_home_bigha);
                      $("#total_applied_home_katha").val(data.total_home_katha);
                      $("#total_applied_home_lessa").val(data.total_home_lessa);
                      $("#total_applied_home_ganda").val(data.total_home_ganda);
                      $("#total_applied_home_kranti").val(data.total_home_kranti);

                      $("#total_applied_agri_bigha").val(data.total_agri_bigha);
                      $("#total_applied_agri_katha").val(data.total_agri_katha);
                      $("#total_applied_agri_lessa").val(data.total_agri_lessa);
                      $("#total_applied_agri_ganda").val(data.total_agri_ganda);
                      $("#total_applied_agri_kranti").val(data.total_agri_kranti);
                      showSuccessMessage("Dag Inserted!!");

                      window.location = window.location;


                  }         
              }
          });
      }
      else {
      // loading.out();
      }
  }

  function deleteDagRevert(id, dag_no) {

      case_no = $('#case_no').val();

      if(confirm("Are you sure you want to delete this Dag?")){

          $.blockUI({
              message: $('#displayBox'),
              css: {
                  border:'none',
                  backgroundColor:'transparent'
              }
          });
          // $("#sp" + id).remove();
          $.ajax({
          type: "POST",
          url: baseurl+'SettlementCommon/deleteDagAreaRevert',
          async: false,
          // dataType: 'json',
          data: { id: id, case_no:case_no, dag_no:dag_no },
          success: function (response) {
              $.unblockUI();
              const data = JSON.parse(response);
              // console.log(data);
              if(data.status == 0)
              {
              showErrorMessage(data.message+": something went wrong!!");
              }
              else {
              //   $("#sp" + id).remove();
                  $("#insdag" + id).show();
                  $("#deldag" + id).hide();
                  $("#editarea" + id).hide();
                  $("#dageligiblemsg" + id).show();
                  $("#dageligiblemsg" + id).text("This dag was Removed by LM!!!");
                  $("#total_applied_home_bigha").val(data.total_home_bigha);
                  $("#total_applied_home_katha").val(data.total_home_katha);
                  $("#total_applied_home_lessa").val(data.total_home_lessa);
                  $("#total_applied_home_ganda").val(data.total_home_ganda);
                  $("#total_applied_home_kranti").val(data.total_home_kranti);

                  $("#total_applied_agri_bigha").val(data.total_agri_bigha);
                  $("#total_applied_agri_katha").val(data.total_agri_katha);
                  $("#total_applied_agri_lessa").val(data.total_agri_lessa);
                  $("#total_applied_agri_ganda").val(data.total_agri_ganda);
                  $("#total_applied_agri_kranti").val(data.total_agri_kranti);
                  showSuccessMessage("Dag Deleted!!");
                  // location.reload(true);
                  window.location = window.location;
              }         
          }
          });
      }
      else {
          // loading.out();
      }

  }