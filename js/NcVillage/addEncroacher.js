
    function addEncroacher(dag_no, riotee_id){

        var modal = document.getElementById("addOccModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-enc-modal")[0];
        modal.style.display = "block";

        $("#dag_label_add_occ").html(dag_no);
        $("#v_dag_no").val(dag_no);
        $('#add_riotee_id').val(riotee_id);

        span.onclick = function() {
            modal.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                // table.destroy();
            }
        }

    }

    function addEncSubmit(){
        //defining the barak velly constants
        const BARAK_VELLY = ["21", "22", "23"];

        var modal = document.getElementById("addOccModal");

        //input validation starts here
        var add_riotee_id = $('#add_riotee_id').val();

        if($('#add_riotee_id').val() == ''){
            alert('Riotee ID is required');
            return false;
        }

        if($('#dist_code').val() == ''){
            alert('dist_code field is required !');
            return false;
        }
        if($('#subdiv_code').val() == ''){
            alert('subdiv_code field is required !');
            return false;
        }
        if($('#circle_code').val() == ''){
            alert('circle_code field is required !');
            return false;
        }
        if($('#mouza_code').val() == ''){
            alert('mouza_code field is required !');
            return false;
        }
        if($('#lot_no').val() == ''){
            alert('lot_no field is required !');
            return false;
        }
        if($('#vill_code').val() == ''){
            alert('vill_code field is required !');
            return false;
        }
        if($('#v_uuid').val() == ''){
            alert('v_uuid field is required !');
            return false;
        }
        if($('#v_dag_no').val() == ''){
            alert('Dag No field is required !');
            $('#v_dag_no').focus();
            return false;
        }
        if($('#v_nature_of_reservation').val() == ''){
            alert('Type of Govt. land field is required !');
            $('#v_nature_of_reservation').focus();
            return false;
        }
        if($('#v_whether_encroached').val() == ''){
            alert('Whether encroached field is required !');
            $('#v_whether_encroached').focus();
            return false;
        }

        if($('#v_no_of_encroachers_lm_update_form').val() == ''){
            alert('No of encroacher field is required !');
            $('#v_no_of_encroachers_lm_update_form').focus();
            return false;
        }
        if($('#v_longitude').val() == ''){
            alert('Longitude field is required !');
            $('#v_longitude').focus();
            return false;
        }
        if($('#v_latitude').val() == ''){
            alert('Latitude field is required !');
            $('#v_latitude').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_name').val() == ''){
            alert('Encroacher Name field is required !');
            $('#lb_lm_update_form_en_name').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_father_name').val() == ''){
            alert('Encroacher father field is required !');
            $('#lb_lm_update_form_en_father_name').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_gender').val() == ''){
            alert('Gender field is required !');
            $('#lb_lm_update_form_en_gender').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_from_date').val() == ''){
            alert('Encroachment from field is required !');
            $('#lb_lm_update_form_en_from_date').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_to_date').val() == ''){
            alert('Encroachment field is required !');
            $('#lb_lm_update_form_en_to_date').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_landless_indigenuous').val() == ''){
            alert('Landless Indigenous field is required !');
            $('#lb_lm_update_form_en_landless_indigenuous').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_landless').val() == ''){
            alert('Landless field is required !');
            $('#lb_lm_update_form_en_landless').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_caste').val() == ''){
            alert('Caste field is required !');
            $('#lb_lm_update_form_en_caste').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_erosion').val() == ''){
            alert('Erosion field is required !');
            $('#lb_lm_update_form_en_erosion').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_landslide').val() == ''){
            alert('Landslide field is required !');
            $('#lb_lm_update_form_en_landslide').focus();
            return false;
        }
        if($('#lb_lm_update_form_type_of_land_use').val() == ''){
            alert('Type Of Land Use field is required !');
            $('#lb_lm_update_form_type_of_land_use').focus();
            return false;
        }
        if($('#lb_lm_update_form_type_of_encroacher').val() == ''){
            alert('Type field is required !');
            $('#lb_lm_update_form_type_of_encroacher').focus();
            return false;
        }


        var postData = {
                'application_no' : $.trim($('#application_no').val()),
                'dist_code' : $('#dist_code').val(),
                'subdiv_code' : $('#subdiv_code').val(),
                'circle_code' : $('#circle_code').val(),
                'mouza_code' : $('#mouza_code').val(),
                'lot_no' : $('#lot_no').val(),
                'vill_code' : $('#vill_code').val(),
                'v_uuid' : $('#v_uuid').val(),
                'v_dag_no' : $('#v_dag_no').val(),
                'v_nature_of_reservation' : $('#v_nature_of_reservation').val(),
                'v_whether_encroached' : $('#v_whether_encroached').val(),

                'v_no_of_encroachers_lm_update_form' : $('#v_no_of_encroachers_lm_update_form').val(),
                'v_longitude' : $('#v_longitude').val(),
                'v_latitude' : $('#v_latitude').val(),
                'lb_lm_update_form_en_name' : $('#lb_lm_update_form_en_name').val(),
                'lb_lm_update_form_en_father_name' : $('#lb_lm_update_form_en_father_name').val(),
                'lb_lm_update_form_en_gender' : $('#lb_lm_update_form_en_gender').val(),
                'lb_lm_update_form_en_from_date' : $('#lb_lm_update_form_en_from_date').val(),
                'lb_lm_update_form_en_to_date' : $('#lb_lm_update_form_en_to_date').val(),
                'lb_lm_update_form_en_landless_indigenuous' : $('#lb_lm_update_form_en_landless_indigenuous').val(),
                'lb_lm_update_form_en_landless' : $('#lb_lm_update_form_en_landless').val(),
                'lb_lm_update_form_en_caste' : $('#lb_lm_update_form_en_caste').val(),
                'lb_lm_update_form_en_erosion' : $('#lb_lm_update_form_en_erosion').val(),
                'lb_lm_update_form_en_landslide' : $('#lb_lm_update_form_en_landslide').val(),
                'lb_lm_update_form_type_of_land_use' : $('#lb_lm_update_form_type_of_land_use').val(),
                'lb_lm_update_form_type_of_encroacher' : $('#lb_lm_update_form_type_of_encroacher').val(),
            };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'NcCommonController/landBankInsert',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);
                if(arr.responseType == 2)
                {
                    showErrorMessage(arr.msg);
                }
                if(arr.responseType == 3)
                {

                    Swal.fire({
                        text: arr.msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                    modal.style.display = "none";

                    window.location.reload();
                    window.location = window.location;

                }
                })
                }
                else{
                    modal.style.display = "none";
                    // showSuccessMessage(arr.msg);
                    // window.location.reload();

                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                         //    window.location.reload();
                         $('#enc_name'+add_riotee_id).val(arr.appnData.enc_name);
                         $('#enc_gur_name'+add_riotee_id).val(arr.appnData.enc_fathers_name);
                         $('#enc_period_possession'+add_riotee_id).val(arr.appnData.enc_from_date);
                         $('#enc_id'+add_riotee_id).val(arr.encroacher_id);
                        //  $('.add_encroacher_button').hide();

                         window.location.reload();
                         window.location = window.location;
                       
                        }
                    })
                }
            }
        });

    }