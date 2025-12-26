
   function editEncroacher(dag_no, riotee_id, enc_id, land_bank_details_id){
       var modal = document.getElementById("editOccModal");
       // Get the button that opens the modal
       var btn = document.getElementById("myBtn");
       // Get the <span> element that closes the modal
       var span_close = document.getElementsByClassName("edit-enc-close")[0];
       modal.style.display = "block";
   
       var uuid = $('#uuid').val();
       var case_no = $('#case_no').val();
   
       $('#edit_dag_label_add_occ').html(dag_no);

       $('#edit_enc_case_no').val(case_no);
       $('#edit_enc_uuid').val(uuid);
       $('#edit_enc_dag_no').val(dag_no);
       $('#edit_riotee_id').val(riotee_id);

       var postData = {
               'enc_id' : enc_id,
               'dag_no' : dag_no,
               'uuid' : uuid,
               'case_no' : case_no,
               'land_bank_details_id' :land_bank_details_id,
           };
   
       $.blockUI({
           message: $('#displayBox'),
           css: {
               border:'none',
               backgroundColor:'transparent'
           }
       });
   
       $.ajax({
           url: baseurl+'SettlementCommon/fetchLandBankEncData',
           type: "POST",
           data: postData,
           success: function(data) {
               arr = JSON.parse(data);

               $('#edit_enc_id_land_bank').val(arr.id);
               $('#edit_enc_application_no').val(arr.application_no);
               $('#edit_enc_land_bank_details_id').val(arr.land_bank_details_id);
               $('#edit_lb_lm_update_form_en_name').val(arr.name);
               $('#edit_lb_lm_update_form_en_father_name').val(arr.fathers_name);
   
               $("#edit_lb_lm_update_form_en_gender option[value="+arr.gender+"]").prop('selected', 'selected');            
   
               $('#edit_lb_lm_update_form_en_from_date').val(arr.encroachment_from);
               $('#edit_lb_lm_update_form_en_to_date').val(arr.encroachment_to);
               $('#edit_lb_lm_update_form_en_landless_indigenuous').val(arr.landless_indigenous);
               $('#edit_lb_lm_update_form_en_landless').val(arr.landless);
               // $('#lb_lm_update_form_en_caste').val(arr.caste);
   
               $("#edit_lb_lm_update_form_en_caste option[value="+arr.caste+"]").prop('selected', 'selected');  
   
               $('#edit_lb_lm_update_form_en_erosion').val(arr.erosion);
               $('#edit_lb_lm_update_form_en_landslide').val(arr.landslide);
               $('#edit_lb_lm_update_form_type_of_land_use').val(arr.type_of_land_use);
               $('#edit_lb_lm_update_form_type_of_encroacher').val(arr.type_of_encroacher);
               
               $.unblockUI();
           }
       });
   
       span_close.onclick = function() {
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
   
   function updateEncDetails(){
       var modal = document.getElementById("editOccModal");
   
       var edit_riotee_id = $.trim($('#edit_riotee_id').val());
       var enc_uuid = $.trim($('#edit_enc_uuid').val());
       var enc_dag_no = $.trim($('#edit_enc_dag_no').val());
       var enc_case_no  = $.trim($('#edit_enc_case_no').val());    
       var enc_id_land_bank = $.trim($('#edit_enc_id_land_bank').val());           
       var enc_application_no =  $.trim($('#edit_enc_application_no').val());
       var enc_land_bank_details_id =  $.trim($('#edit_enc_land_bank_details_id').val());
       var lb_lm_update_form_en_name =  $.trim($('#edit_lb_lm_update_form_en_name').val());
       var lb_lm_update_form_en_father_name =  $.trim($('#edit_lb_lm_update_form_en_father_name').val());
       var lb_lm_update_form_en_gender =  $.trim($("#edit_lb_lm_update_form_en_gender").val());            
       var lb_lm_update_form_en_from_date =  $.trim($('#edit_lb_lm_update_form_en_from_date').val());
       var lb_lm_update_form_en_to_date =  $.trim($('#edit_lb_lm_update_form_en_to_date').val());
       var lb_lm_update_form_en_landless_indigenuous =  $.trim($('#edit_lb_lm_update_form_en_landless_indigenuous').val());
       var lb_lm_update_form_en_landless =  $.trim($('#edit_lb_lm_update_form_en_landless').val());
       var lb_lm_update_form_en_caste =  $.trim($("#edit_lb_lm_update_form_en_caste").val());  
       var lb_lm_update_form_en_erosion =  $.trim($('#edit_lb_lm_update_form_en_erosion').val());
       var lb_lm_update_form_en_landslide =  $.trim($('#edit_lb_lm_update_form_en_landslide').val());
       var lb_lm_update_form_type_of_land_use =  $.trim($('#edit_lb_lm_update_form_type_of_land_use').val());
       var lb_lm_update_form_type_of_encroacher =  $.trim($('#edit_lb_lm_update_form_type_of_encroacher').val());
      

       if(edit_riotee_id == ''){
          alert("Riotee ID field is required !");
          $('#edit_riotee_id').focus();
          return false;
       }
       if(enc_uuid == ''){
           alert("enc_uuid field is required !");
           $('#edit_enc_uuid').focus();
           return false;
       }
       if(enc_dag_no == ''){
           alert("enc_dag_no field is required !");
           $('#edit_enc_uuid').focus();
           return false;
       }
       if(enc_case_no == ''){
           alert('Case No field is required !');
           $('#edit_enc_case_no').focus();
           return false;
       }
       if(enc_id_land_bank == ''){
           alert('Enc ID field is required !');
           $('#edit_enc_application_no').focus();
           return false;
       }
       if(enc_application_no == ''){
           alert('Application no field is required !');
           $('#edit_enc_application_no').focus();
           return false;
       }
       if(enc_land_bank_details_id == ''){
           alert('Encroacher land bank details ID is required !');
           $('#edit_enc_land_bank_details_id').focus();
           return false;
       }
       if(lb_lm_update_form_en_name == ''){
           alert('Encroacher Name is required !');
           $('#edit_lb_lm_update_form_en_name').focus();
           return false;
       }
       if(lb_lm_update_form_en_father_name == ''){
           alert('Father name field is required !');
           $('#edit_lb_lm_update_form_en_father_name').focus();
           return false;
       }
       if(lb_lm_update_form_en_gender == ''){
           alert('Gender is required !');
           $('#edit_lb_lm_update_form_en_gender').focus();
           return false;
       }
       if(lb_lm_update_form_en_from_date == ''){
           alert('From date is required !');
           $('#edit_lb_lm_update_form_en_from_date').focus();
           return false;
       }
       if(lb_lm_update_form_en_to_date == ''){
           alert('To Date is required !');
           $('#edit_lb_lm_update_form_en_to_date').focus();
           return false;
       }
       if(lb_lm_update_form_en_landless_indigenuous == ''){
           alert('Landless Indigenous is required !');
           $('#edit_lb_lm_update_form_en_landless_indigenuous').focus();
           return false;
       }
       if(lb_lm_update_form_en_landless == ''){
           alert('Landless is required !');
           $('#edit_lb_lm_update_form_en_landless').focus();
           return false;
       }
       if(lb_lm_update_form_en_caste == ''){
           alert('Caste is required !');
           $('#edit_lb_lm_update_form_en_caste').focus();
           return false;
       }
       if(lb_lm_update_form_en_erosion == ''){
           alert('Erosion effected is required !');
           $('#edit_lb_lm_update_form_en_erosion').focus();
           return false;
       }
       if(lb_lm_update_form_en_landslide == ''){
           alert('Landslide prone area field is required !');
           $('#edit_lb_lm_update_form_en_landslide').focus();
           return false;
       }
       if(lb_lm_update_form_type_of_land_use == ''){
           alert('Type Of Land Use field required !');
           $('#edit_lb_lm_update_form_type_of_land_use').focus();
           return false;
       }
       if(lb_lm_update_form_type_of_encroacher == ''){
           alert('Encroacher type field is required !');
           $('#edit_lb_lm_update_form_type_of_encroacher').focus();
           return false;
       }
   
       var postData = {
           'edit_riotee_id' : edit_riotee_id,
           'enc_uuid' : enc_uuid,
           'enc_dag_no' : enc_dag_no,
           'enc_case_no' : enc_case_no,
           'encroacher_id' : enc_id_land_bank,
           'enc_application_no' : enc_application_no,
           'enc_land_bank_details_id' : enc_land_bank_details_id,
           'lb_lm_update_form_en_name' : lb_lm_update_form_en_name,
           'lb_lm_update_form_en_father_name' : lb_lm_update_form_en_father_name,
           'lb_lm_update_form_en_gender' : lb_lm_update_form_en_gender,
           'lb_lm_update_form_en_from_date' : lb_lm_update_form_en_from_date,
           'lb_lm_update_form_en_to_date' : lb_lm_update_form_en_to_date,
           'lb_lm_update_form_en_landless_indigenuous' : lb_lm_update_form_en_landless_indigenuous,
           'lb_lm_update_form_en_landless' : lb_lm_update_form_en_landless,
           'lb_lm_update_form_en_caste' : lb_lm_update_form_en_caste,
           'lb_lm_update_form_en_erosion' : lb_lm_update_form_en_erosion,
           'lb_lm_update_form_en_landslide' : lb_lm_update_form_en_landslide,
           'lb_lm_update_form_type_of_land_use' : lb_lm_update_form_type_of_land_use,
           'lb_lm_update_form_type_of_encroacher' : lb_lm_update_form_type_of_encroacher,
       };
   
       $.blockUI({
           message: $('#displayBox'),
           css: {
               border:'none',
               backgroundColor:'transparent'
           }
       });
   
       $.ajax({
           url: baseurl+'SettlementCommon/updateLandBankEncData',
           type: "POST",
           data: postData,
           success: function(data) {
               arr = JSON.parse(data);
               $.unblockUI();
               if(arr.responseType == 2){
                   showErrorMessage(arr.msg);
               }
               else{
                   modal.style.display = "none";
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
                        $('#enc_name'+arr.edit_riotee_id).val(arr.appnData.pdar_name);
                        $('#enc_gur_name'+arr.edit_riotee_id).val(arr.appnData.pdar_guardian);
                        $('#enc_period_possession'+arr.edit_riotee_id).val(arr.appnData.period_possession);
                        $('#enc_id'+arr.edit_riotee_id).val(arr.encroacher_id);

                       }
                   })
               }
           }
       });
   
   }
   