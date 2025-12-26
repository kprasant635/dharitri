
    var areaModal = document.getElementById("editAreaDetails");
    // Get the <span> element that closes the modal
    var spanArea = document.getElementsByClassName("close-edit-area")[0];

    function editArea(id, dag_no){
        //****to display the modal */
        areaModal.style.display = "block";
        //****to close the modal */
        spanArea.onclick = function() {
            Swal.fire({
                text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
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
                    text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: "#B82929",
                }).then((result) => {
                    if (result.isConfirmed) {
                        areaModal.style.display = "none";
                    }
                })
            }
        }

        // var edit_area_span_dag_no = $.trim($('#dag_no'+dag_no).val());
        // var edit_area_span_patta_no = $.trim($('#patta_no'+dag_no).val());
        $('#edit_area_span_dag_no').html(dag_no);
        $('#edit_area_span_patta_no').html(edit_area_span_patta_no);

        $('#area_update_id').val(id);
        $('#area_update_dag_no').val(dag_no);

        // var urbanCheck = $.trim($('#urbanCheck'+dag_no).val());
        // $('#area_update_urban_check').val(urbanCheck);

        $('#area_update_case_no').val($.trim($('#case_no').val()));

        var postData = {
          'id' : id,
          'dag_no' : dag_no,
          'case_no' : $.trim($('#case_no').val()),
      };




        $.ajax({
          url: baseurl+'NcCommonController/selectDagArea',
          type: "POST",
          data: postData,
          success: function(data) {
              arr = JSON.parse(data);
              $.unblockUI();
              if(arr.responseType == 0){
                  Swal.fire({
                          text: arr.msg,
                          icon: 'error',
                          confirmButtonText: 'OK',
                  })
              }
              else{


                $('#total_bigha_in_dag').val(arr.appnData.dag_area_b);
                $('#total_katha_in_dag').val(arr.appnData.dag_area_k);
                $('#total_lessa_in_dag').val(arr.appnData.dag_area_lc);
                $('#total_ganda_in_dag').val(arr.appnData.dag_area_g);
                $('#total_kranti_in_dag').val(arr.appnData.dag_area_kr);

                $('#enc_bigha_home').val(arr.appnData.home_b);
                $('#enc_katha_home').val(arr.appnData.home_k);
                $('#enc_lessa_home').val(arr.appnData.home_lc);
                $('#enc_ganda_home').val(arr.appnData.home_g);
                $('#enc_kranti_home').val(arr.appnData.home_kr);

                $('#enc_bigha_agriculture').val(arr.appnData.agri_b);
                $('#enc_katha_agriculture').val(arr.appnData.agri_k);
                $('#enc_lessa_agriculture').val(arr.appnData.agri_lc);
                $('#enc_ganda_agriculture').val(arr.appnData.agri_g);
                $('#enc_kranti_agriculture').val(arr.appnData.agri_kr);

                $('#settlement_bigha_home').val(arr.appnData.home_b);
                $('#settlement_katha_home').val(arr.appnData.home_k);
                $('#settlement_lessa_home').val(arr.appnData.home_lc);
                $('#settlement_ganda_home').val(arr.appnData.home_g);
                $('#settlement_kranti_home').val(arr.appnData.home_kr);

                $('#settlement_bigha_agriculture').val(arr.appnData.agri_b);
                $('#settlement_katha_agriculture').val(arr.appnData.agri_k);
                $('#settlement_lessa_agriculture').val(arr.appnData.agri_lc);
                $('#settlement_ganda_agriculture').val(arr.appnData.agri_g);
                $('#settlement_kranti_agriculture').val(arr.appnData.agri_kr);

                $('#area_update_urban_check').val(arr.appnData.is_urban);
              }
          }
      });


    }

    function updateAreaDetailsCommon(){
        const BARAK_VELLY = ["21", "22", "23"];

        var area_update_id = $.trim($('#area_update_id').val());
        var area_update_dag_no = $.trim($('#area_update_dag_no').val());
        var area_update_urban_check = $.trim($('#area_update_urban_check').val());

        var area_update_case_no = $.trim($('#area_update_case_no').val());

        var total_bigha_in_dag = $.trim($('#total_bigha_in_dag').val());
        var total_katha_in_dag = $.trim($('#total_katha_in_dag').val());
        var total_lessa_in_dag = $.trim($('#total_lessa_in_dag').val());
        var total_ganda_in_dag = $.trim($('#total_ganda_in_dag').val());
        var total_kranti_in_dag = $.trim($('#total_kranti_in_dag').val());

        var enc_bigha_home = $.trim($('#enc_bigha_home').val());
        var enc_katha_home = $.trim($('#enc_katha_home').val());
        var enc_lessa_home = $.trim($('#enc_lessa_home').val());
        var enc_ganda_home = $.trim($('#enc_ganda_home').val());
        var enc_kranti_home = $.trim($('#enc_kranti_home').val());
        var enc_bigha_agriculture = $.trim($('#enc_bigha_agriculture').val());
        var enc_katha_agriculture = $.trim($('#enc_katha_agriculture').val());
        var enc_lessa_agriculture = $.trim($('#enc_lessa_agriculture').val());
        var enc_ganda_agriculture = $.trim($('#enc_ganda_agriculture').val());
        var enc_kranti_agriculture = $.trim($('#enc_kranti_agriculture').val());
        var settlement_bigha_home = $.trim($('#settlement_bigha_home').val());
        var settlement_katha_home = $.trim($('#settlement_katha_home').val());
        var settlement_lessa_home = $.trim($('#settlement_lessa_home').val());
        var settlement_ganda_home = $.trim($('#settlement_ganda_home').val());
        var settlement_kranti_home = $.trim($('#settlement_kranti_home').val());
        var settlement_bigha_agriculture = $.trim($('#settlement_bigha_agriculture').val());
        var settlement_katha_agriculture = $.trim($('#settlement_katha_agriculture').val());
        var settlement_lessa_agriculture = $.trim($('#settlement_lessa_agriculture').val());
        var settlement_ganda_agriculture = $.trim($('#settlement_ganda_agriculture').val());
        var settlement_kranti_agriculture = $.trim($('#settlement_kranti_agriculture').val());

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

        if(enc_bigha_agriculture == ''){
            $("#enc_bigha_agriculture").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#enc_bigha_agriculture').focus();
            return false;
        }
        if(enc_katha_agriculture == ''){
            $("#enc_katha_agriculture").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#enc_katha_agriculture').focus();
            return false;
        }
        if(enc_lessa_agriculture == ''){
            $("#enc_lessa_agriculture").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#enc_lessa_agriculture').focus();
            return false;
        }

        if(BARAK_VELLY.includes($('#dist_code').val())){

            if(enc_ganda_agriculture == ''){
                $("#enc_ganda_agriculture").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
                );
                $('#enc_ganda_agriculture').focus();
                return false;
            }
            if(enc_kranti_agriculture == ''){
                $("#enc_kranti_agriculture").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
                );
                $('#enc_kranti_agriculture').focus();
                return false;
            }
        }
        if(settlement_bigha_home == ''){
            $("#settlement_bigha_home").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#settlement_bigha_home').focus();
            return false;
        }
        if(settlement_katha_home == ''){
            $("#settlement_katha_home").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#settlement_katha_home').focus();
            return false;
        }
        if(settlement_lessa_home == ''){
            $("#settlement_lessa_home").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#settlement_lessa_home').focus();
            return false;
        }
        if(BARAK_VELLY.includes($('#dist_code').val())){

            if(settlement_ganda_home == ''){
                $("#settlement_ganda_home").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
                );
                $('#settlement_ganda_home').focus();
                return false;
            }
            if(settlement_kranti_home == ''){
                $("#settlement_kranti_home").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
                );
                $('#settlement_kranti_home').focus();
                return false;
            }
        }
        if(settlement_bigha_agriculture == ''){
            $("#settlement_bigha_agriculture").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#settlement_bigha_agriculture').focus();
            return false;
        }
        if(settlement_katha_agriculture == ''){
            $("#settlement_katha_agriculture").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#settlement_katha_agriculture').focus();
            return false;
        }
        if(settlement_lessa_agriculture == ''){
            $("#settlement_lessa_agriculture").notify(
            "This field is required !", 
            { position:"bottom right", arrowSize: 10 }
            );
            $('#settlement_lessa_agriculture').focus();
            return false;
        }
        if(BARAK_VELLY.includes($('#dist_code').val())){

            if(settlement_ganda_agriculture == ''){
                $("#settlement_ganda_agriculture").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
                );
                $('#settlement_ganda_agriculture').focus();
                return false;
            }
            if(settlement_kranti_agriculture == ''){
                $("#settlement_kranti_agriculture").notify(
                "This field is required !", 
                { position:"bottom right", arrowSize: 10 }
                );
                $('#settlement_kranti_agriculture').focus();
                return false;
            }
        }

       
        // prepare for updation
        var postData = {
            'area_update_id' : area_update_id,
            'area_update_dag_no' : area_update_dag_no,
            'area_update_urban_check' : area_update_urban_check,
            'area_update_case_no' : area_update_case_no,
            'total_bigha_in_dag' : total_bigha_in_dag,
            'total_katha_in_dag' : total_katha_in_dag,
            'total_lessa_in_dag' : total_lessa_in_dag,
            'total_ganda_in_dag' : total_ganda_in_dag,
            'total_kranti_in_dag' : total_kranti_in_dag,
            'enc_bigha_home' : enc_bigha_home,
            'enc_katha_home' : enc_katha_home,
            'enc_lessa_home' : enc_lessa_home,
            'enc_ganda_home' : enc_ganda_home,
            'enc_kranti_home' : enc_kranti_home,
            'enc_bigha_agriculture' : enc_bigha_agriculture,
            'enc_katha_agriculture' : enc_katha_agriculture,
            'enc_lessa_agriculture' : enc_lessa_agriculture,
            'enc_ganda_agriculture' : enc_ganda_agriculture,
            'enc_kranti_agriculture' : enc_kranti_agriculture,
            'settlement_bigha_home' : settlement_bigha_home,
            'settlement_katha_home' : settlement_katha_home,
            'settlement_lessa_home' : settlement_lessa_home,
            'settlement_ganda_home' : settlement_ganda_home,
            'settlement_kranti_home' : settlement_kranti_home,
            'settlement_bigha_agriculture' : settlement_bigha_agriculture,
            'settlement_katha_agriculture' : settlement_katha_agriculture,
            'settlement_lessa_agriculture' : settlement_lessa_agriculture,
            'settlement_ganda_agriculture' : settlement_ganda_agriculture,
            'settlement_kranti_agriculture' : settlement_kranti_agriculture,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'NcCommonController/updateAreaDetailsCommon',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0){
                    Swal.fire({
                            text: arr.msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                    })
                }
                else{

                  if(arr.responseType == 2)
                  {
                      Swal.fire({
                              text: arr.msg,
                              icon: 'success',
                              confirmButtonText: 'OK',
                      })
                  }

                  location.reload();
                }
            }
        });

    }

    
    function deleteDag(id, dag_no) {

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
            url: baseurl+'NcCommonController/deleteDagArea',
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

    function insertDag(id, dag_no) {

        case_no = $('#case_no').val();
        if(confirm("Are you sure you want to insert this dag?")){
            // $("#sp" + id).remove();
            $.ajax({
                type: "POST",
                url: baseurl+'NcCommonController/insertDagArea',
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
                url: baseurl+'NcCommonController/insertDagAreaRevert',
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
            url: baseurl+'NcCommonController/deleteDagAreaRevert',
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


