
    // var familyModal = document.getElementById("editFamilyDetails");
    var addFamilyModal = document.getElementById("addFamilyData");
    // Get the <span> element that closes the modal
    var spanFamily = document.getElementsByClassName("closefamily")[0];

    function addFamily(){
      //****to display the modal */
      addFamilyModal.style.display = "block";
      //****to close the modal */
      spanFamily.onclick = function() {
        addFamilyModal.style.display = "none";
      }
  
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == addFamilyModal) {
            addFamilyModal.style.display = "none";
          }
      }
    }

    function editFamily(id){
        //****to display the modal */
        familyModal.style.display = "block";
        //****to close the modal */
        spanFamily.onclick = function() {
            familyModal.style.display = "none";
        }
    
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == familyModal) {
                familyModal.style.display = "none";
            }
        }

        var pdar_name = $.trim($('#pdar_name'+id).val());
        var pdar_guardian = $.trim($('#pdar_guardian'+id).val());
        var eng_pdar_name = $.trim($('#eng_pdar_name'+id).val());
        var eng_pdar_guardian = $.trim($('#eng_pdar_guardian'+id).val());
        var pdar_rel_guar = $.trim($('#pdar_rel_guar'+id).val());
        var pdar_gender = $.trim($('#pdar_gender'+id).val());
        var dob = $.trim($('#dob'+id).val());
        var marital_status = $.trim($('#marital_status'+id).val());
        var pdar_mobile = $.trim($('#pdar_mobile'+id).val());
        var pdar_add1 = $.trim($('#pdar_add1'+id).val());
        var pdar_add2 = $.trim($('#pdar_add2'+id).val());
        
        $('#applicant_d_id').val(id);
        $('#applicant_d_applicant_name_ass').val(pdar_name);
        $('#applicant_d_applicant_name_eng').val(eng_pdar_name);
        $('#applicant_d_guardian_name_ass').val(pdar_guardian);
        $('#applicant_d_guardian_name_eng').val(eng_pdar_guardian);
        $('#applicant_d_relation').val(pdar_rel_guar);
        $('#applicant_d_gender').val(pdar_gender);
        $('#applicant_d_dob').val(dob);
        $('#applicant_d_marital_status').val(marital_status);
        $('#applicant_d_mobile').val(pdar_mobile);
        $('#applicant_d_per_address').val(pdar_add1);
        $('#applicant_d_pre_address').val(pdar_add2);
    }

    function addFamilyDetails(){
      var case_no = $.trim($('#case_no').val());
      var nominee_name = $.trim($('#add_kin_name').val());
      var address = $.trim($('#add_kin_address').val());
      var relation = $.trim($('#add_kin_relation').val());
      var mobile_no = $.trim($('#add_kin_contact_no').val());
      
      //validation for the update
      if(nominee_name == ''){
          alert('Name Field is required !');
          $('#add_kin_name').focus();
          return false;
      }
      if(address == ''){
          alert('Address Field is required !');
          $('#add_kin_address').focus();
          return false;
      }
      if(relation == ''){
          alert('Relation Field is required !');
          $('#add_kin_relation').focus();
          return false;
      }
      if(mobile_no == ''){
          alert('Mobile number Field is required !');
          $('#add_kin_contact_no').focus();
          return false;
      }
      if(mobile_no.length != 10){
        alert('Not a Valid Mobile number!');
        $('#add_kin_contact_no').focus();
        return false;
      }

      //prepare for updation
      var postData = {
          'case_no' : case_no,
          'nominee_name' : nominee_name,
          'address' : address,
          'relation' : relation,
          'mobile_no' : mobile_no
      };

      $.blockUI({
          message: $('#displayBox'),
          css: {
              border:'none',
              backgroundColor:'transparent'
          }
      });

      $.ajax({
          url: baseurl+'SettlementCommon/addFamilyDetails',
          type: "POST",
          data: postData,
          success: function(data) {
              arr = JSON.parse(data);
              $.unblockUI();
              if(arr.responseType == 0){
                  showErrorMessage(arr.msg);
              }
              else{
                  addFamilyModal.style.display = "none";
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
                          $('#add_kin_name').val('');
                          $('#add_kin_address').val('');
                          $('#add_kin_contact_no').val('');
                          $('#add_kin_relation').val('');
                          
                          addFamilyModal.style.display = "none";
                          // $("#listNextOfKin").append('<tr id="sp'+arr.appnData.id+'"><td>'+arr.appnData.nominee_name+'</td><td>'+arr.appnData.address+'</td><td>'+arr.appnData.relation+'</td><td>'+arr.appnData.mobile_no+'</td><td><a href="javascript:void(0)" onclick="confirmDeleteKin('+arr.appnData.id+')" class="btn btn-danger">Delete</a></tr>');
                          $("#listNextOfKin").append('<tr id="sp'+arr.appnData.id+'"><td><input type="text" readonly name="kin_name" value='+arr.appnData.nominee_name+' class="form-control"></td> '+
                          '<td><input type="text" readonly name="kin_relation" value="'+arr.appnData.relation_name+'" class="form-control"></td>'+
                          '<td><input type="text" readonly class="form-control" value="'+arr.appnData.address+'" name="kin_address"></td>'+
                          '<td><input type="text" readonly name="kin_contact_no" value="'+arr.appnData.mobile_no+'" class="form-control"></td>'+
                          '<td><button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add</button> <button type="button" onclick="confirmDeleteFamily('+arr.appnData.id+');" class="btn btn-sm btn-danger">Delete</button></tr>');
                      }
                  })
              }
          }
      });

  }


  // family delete
function confirmDeleteFamily(id)
{
  case_no = $('#case_no').val();

  if(confirm("Are you sure you want to delete this Record?")){
    $("#sp" + id).remove();
    $.ajax({
      type: "POST",
      url: baseurl+'SettlementCommon/delFamilyDetails',
      async: false,
      // dataType: 'json',
      data: { id: id, case_no:case_no },
      success: function (response) {
        const data = JSON.parse(response);
        // console.log(data);
        if(data.status == 0)
        {
          showErrorMessage("something went wrong!!");
        }
        else {
          $("#sp" + id).remove();                  
          showSuccessMessage("Nominee Deleted!!");
          $("#next_of_kin_count option[value="+data.count+"]").prop('selected', 'selected');
        }         
      }
    });
  }
  else {
    // loading.out();
  }
}
