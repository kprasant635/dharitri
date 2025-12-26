
  var areaModal = document.getElementById("editAreaDetails");
  var areaModal = document.getElementById("editAreaDetails");
  var spanArea  = document.getElementsByClassName("close-edit-area")[0];

  function editAreaJuridical(id, dag_no,patta_no)
  {
    if (!confirm("Changing the dag area can significantly affect the premium if premium exist in this application, kindly ensure the premium, once area have been changed.")) {
        return false;
    }
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
          areaModal.style.display = "none";
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
            areaModal.style.display = "none";
          }
        })
      }

    }

    $('#edit_area_span_dag_no').html(dag_no);
    $('#edit_area_span_patta_no').html(patta_no);

    $('#area_update_id').val(id);
    $('#area_update_dag_no').val(dag_no);

    $('#area_update_case_no').val($.trim($('#case_no').val()));

    var postData = {
      'id' : id,
      'dag_no' : dag_no,
      'case_no' : $.trim($('#case_no').val()),
    };

    $.ajax({
      url  : baseurl+'SettlementInstitutionCo/selectDagArea',
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

  function updateJuridicalArea()
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

    var justification_area_change = $('#justification_area_change').val();
    if(!justification_area_change)
    {

        alert('Justification for area change is mandatory!!!');
        $('#justification_area_change').focus();
        return false;
    }



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
 
    //prepare for updation
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
      'justification_area_change' : justification_area_change
    };

    $.blockUI({
      message: $('#displayBox'),
      css: {
        border          : 'none',
        backgroundColor : 'transparent'
      }
    });

    $.ajax({
      url     : baseurl+'SettlementInstitutionCo/updateAreaDetails',
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

    function deleteDagIns(id, dag_no) {

        case_no = $('#case_no').val();

        if(confirm("Are you sure you want to delete this DAG? Once deleted, this action cannot be undone and may impact premium features in the applications.")){

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
            url: baseurl+'SettlementCommonIns/deleteDagArea',
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

                    $("#total_applied_agri_bigha").val(0);
                    $("#total_applied_agri_katha").val(0);
                    $("#total_applied_agri_lessa").val(0);
                    $("#total_applied_agri_ganda").val(0);
                    $("#total_applied_agri_kranti").val(0);
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

    function insertDagIns(id, dag_no) {

        case_no = $('#case_no').val();
        if(confirm("Are you sure you want to insert this dag?")){
            // $("#sp" + id).remove();
            $.ajax({
                type: "POST",
                url: baseurl+'SettlementCommonIns/insertDagArea',
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

    function insertDagRevertIns(id, dag_no)
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
                url: baseurl+'SettlementCommonIns/insertDagAreaRevert',
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


    function deleteDagRevertIns(id, dag_no) {

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
            url: baseurl+'SettlementCommonIns/deleteDagAreaRevert',
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

    
    


