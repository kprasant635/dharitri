
  var areaModal = document.getElementById("editAreaDetails");
  var spanArea  = document.getElementsByClassName("close-edit-area-adc")[0];

  function editAreaTeaGrant(id, dag_no){
    //****to display the modal */
    areaModal.style.display = "block";
    //****to close the modal */
    spanArea.onclick = function() {
      Swal.fire({
        text              : 'Closing this modal without saving will erase any edited data ! Are you sure ?',
        icon              : 'warning',
        showCancelButton  : true,
        confirmButtonText : 'Yes',
        confirmButtonColor: "#B82929",
      }).then((result) => {
        if (result.isConfirmed) {
          // $('#paymentNoticeModal').modal('show');
          // $('#editAreaDetails').modal('hide');
          // areaModal.style.display = "none";
        }
      })
    }
  
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == areaModal) {
        Swal.fire({
          text              : 'Closing this modal without saving will erase any edited data ! Are you sure ?',
          icon              : 'warning',
          showCancelButton  : true,
          confirmButtonText : 'Yes',
          confirmButtonColor: "#B82929",
        }).then((result) => {
          if(result.isConfirmed) {
            // $('#paymentNoticeModal').modal('show');
            // $('#editAreaDetails').modal('hide');
            // areaModal.style.display = "none";
          }
        })
      }
    }

    $('#edit_area_span_dag_no').html(dag_no);
    $('#edit_area_span_patta_no').html(edit_area_span_patta_no);

    $('#area_update_id').val(id);
    $('#area_update_dag_no').val(dag_no);

    $('#area_update_case_no').val($.trim($('#case_no').val()));

    var postData = {
      'id' : id,
      'dag_no' : dag_no,
      'case_no' : $.trim($('#case_no').val()),
    };

    $.ajax({
      url  : baseurl+'TeaGrantController/selectDagArea',
      type : "POST",
      data : postData,
      success: function(data) {
        arr = JSON.parse(data);

        console.log(arr);

        $.unblockUI();
        if(arr.responseType == 0){
          Swal.fire({
            text              : arr.msg,
            icon              : 'error',
            confirmButtonText : 'OK',
          })
        }
        else{

          $('#total_bigha_in_dag').val(arr.appnData.dag_area_b);
          $('#total_katha_in_dag').val(arr.appnData.dag_area_k);
          $('#total_lessa_in_dag').val(arr.appnData.dag_area_lc);
          $('#total_ganda_in_dag').val(arr.appnData.dag_area_g);
          $('#total_kranti_in_dag').val(arr.appnData.dag_area_kr);

          $('#enc_bigha_home').val(arr.appnData.s_dag_area_b);
          $('#enc_katha_home').val(arr.appnData.s_dag_area_k);
          $('#enc_lessa_home').val(arr.appnData.s_dag_area_lc);
          $('#enc_ganda_home').val(arr.appnData.s_dag_area_g);
          $('#enc_kranti_home').val(arr.appnData.s_dag_area_kr);

          $('#area_update_urban_check').val(arr.appnData.is_urban);
        }
      }
    });
  }

  function updateTeaGrantArea()
  {
    const BARAK_VELLY           = ["21", "22", "23"];

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

    //validation for the update

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
      message: $('#displayBox'),
      css: {
        border          : 'none',
        backgroundColor : 'transparent'
      }
    });



    
    $.ajax({
      url     : baseurl+'TeaGrantController/updateAreaDetails',
      type    : "POST",
      data    : postData,
      success : function(data) 
      {
        arr = JSON.parse(data);
        $.unblockUI();
        if(arr.responseType == 0){
          Swal.fire({
            text: arr.msg,
            icon: 'error',
            confirmButtonText: 'OK',
          })
        }
        else
        {
          if(arr.responseType == 2)
          {
            Swal.fire({
              text              : arr.msg,
              icon              : 'success',
              confirmButtonText : 'OK',
            })
          }
          location.reload();
        }
      }
    });

  }

    
    


