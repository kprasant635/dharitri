<style>
    /* The Close Button */
    .closefamily {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .closefamily:hover,
    .closefamily:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div id="addLegalHeirData" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="closefamily px-4">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>Add / View Legal Heir</h5>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>English Name <span class="text-red">*</span></th>
                <td>
                  <input type="text" id="add_eng_name" name="add_eng_name" placeholder="Name in English" class="form-control">
                </td>

                <th>Assamese Name <span class="text-red">*</span></th>
                <td>
                  <input type="text" id="add_asm_name" name="add_asm_name" placeholder="Name in Assamese" class="form-control search-box-nok" value="">
                </td>
            </tr>

            <tr>
                <th>Guardian Name (English) <span class="text-red">*</span></th>
                <td>
                  <input type="text" id="add_eng_gname" name="add_eng_gname" placeholder="Guardian Name in English" class="form-control">
                </td>

                <th>Guardian Name (Assamese) <span class="text-red">*</span></th>
                <td>
                  <input type="text" id="add_asm_gname" name="add_asm_gname" placeholder="Guardian Name in Assamese" class="form-control search-box-nok" value="">
                </td>
            </tr>
            <tr>
                <th>Relation <span class="text-red">*</span></th>
                <td>
                    <select id="add_lh_relation" class="form-control" name="add_lh_relation">
                        <option value="">Select</option>
                        <?php foreach ($guar_rel as $guar_rel_list) {
                            ?>
                            <option value="<?=$guar_rel_list->id?>">
                                <?=$guar_rel_list->guard_rel_desc_as?>
                            </option>
                        <?php }?>
                    </select>
                </td>
                <th>Mobile <span class="text-red">*</span></th>
                <td>
                    <input type="text" maxlength="10" id="add_lh_contact_no" class="form-control" name="add_lh_contact_no" placeholder="Mobile Number" oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                </td>                
            </tr>
            <tr>
                <th>Gender <span class="text-red">*</span></th>
                <td>
                  <select id="add_lh_gender" name="add_lh_gender" class="form-control">
                    <option value=''>-- Select Gender --</option>
                    <option value='1'>Male</option>
                    <option value='2'>Female</option>
                    <option value='3'>Other</option>
                  </select>
                </td>    
                <th>Life Status of the Individual <span class="text-red">*</span></th>
                <td>
                  <select id="add_lh_life_status" name="add_lh_life_status" class="form-control">
                    <option value=''>-- Select --</option>
                    <option value='A'>Alive</option>
                    <option value='D'>Deceased</option>
                    <option value='U'>Unknown</option>
                  </select>
                </td>               
            </tr>
            <tr>
                <th>Address <span class="text-red">*</span></th>
                <td colspan="3">
                    <input type="text" id="add_lh_address" name="add_lh_address" placeholder="Address" class="form-control">
                </td>                
            </tr>
        </table>
        
        <div class="row justify-content-center">
            <button type="button" onclick="addLegalHeirDetails();" class="btn btn-sm btn-danger col-3">Add</button>
        </div>

        <br>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Name</th>
              <th>Guardian</th>
              <th>Gender</th>
              <th>Relation</th>            
              <th>Contact</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody id="listLegalHeir">      
          </tbody>
            
        </table>

    </p>
  </div>

</div>

<?php include(APPPATH.'/views/TeaGrant/common/assamese_keyboard.php');?>


<script type="text/javascript">
    

  // var familyModal = document.getElementById("editFamilyDetails");
  var addLegalHeirModal = document.getElementById("addLegalHeirData");
  // Get the <span> element that closes the modal
  var spanFamily = document.getElementsByClassName("closefamily")[0];

  function addLegalHeir()
  {
    var case_no = $.trim($('#case_no').val());

    $.blockUI({
      message: $('#displayBox'),
      css: {
        border:'none',
        backgroundColor:'transparent'
      }
    });

    $.ajax({
      type        : "POST",
      url         : baseurl+'TeaGrantController/getLegalHeirList',
      // async       : false,
      data        : { case_no:case_no },
      dataType    : "json",

      success: function (data) 
      {  
        $.unblockUI();
        addLegalHeirModal.style.display = "block";
        spanFamily.onclick = function() {
          addLegalHeirModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == addLegalHeirModal) {
            addLegalHeirModal.style.display = "block";
          }
        }

        console.log(data.appnData);

        var tableKin = '';
        $.each(data.appnData, function (i, val)
        {
          if(val.pdar_gender == 1) { gender = 'Male';}
          if(val.pdar_gender == 2) { gender = 'Female';}
          if(val.pdar_gender == 3) { gender = 'Other';}

          if(val.pdar_rel_guar == 1) { relation = 'মাতৃ';}
          if(val.pdar_rel_guar == 2) { relation = 'পিতৃ';}
          if(val.pdar_rel_guar == 3) { relation = 'পতি';}
          if(val.pdar_rel_guar == 4) { relation = 'পত্নী';}
          if(val.pdar_rel_guar == 7) { relation = 'অভিভাৱক';}

          // console.log(val);
          tableKin +=
            '<tr id="sp'+val.id +'">'+
              '<td>' + val.pdar_name  + '</td>' +
              '<td>' + val.pdar_guardian  + '</td>' +
              '<td>' + gender  + '</td>' +
              '<td>' + relation  + '</td>' +
              '<td>' + val.pdar_mobile  + '</td>' +
              '<td><button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteFamily('+val.id+');">Remove</button></td>' +
            '</tr>'
        });
        $('#listLegalHeir').html(tableKin);
      }
    });



        
  }

  function addLegalHeirDetails()
  {
    var case_no            = $.trim($('#case_no').val());
    var add_eng_name       = $.trim($('#add_eng_name').val());
    var add_asm_name       = $.trim($('#add_asm_name').val());
    var add_eng_gname      = $.trim($('#add_eng_gname').val());
    var add_asm_gname      = $.trim($('#add_asm_gname').val());
    var add_lh_relation    = $.trim($('#add_lh_relation').val());
    var add_lh_contact_no  = $.trim($('#add_lh_contact_no').val());
    var add_lh_address     = $.trim($('#add_lh_address').val());
    var add_lh_gender      = $.trim($('#add_lh_gender').val());
    var add_lh_life_status = $.trim($('#add_lh_life_status').val());



    //validation for the update
    if(add_eng_name == ''){
      alert('Name in English is required !');
      $('#add_eng_name').focus();
      return false;
    }
    if(add_asm_name == ''){
      alert('Name in Assamese is required !');
      $('#add_asm_name').focus();
      return false;
    }
    if(add_eng_gname == ''){
      alert('Guardian name in English is required !');
      $('#add_eng_gname').focus();
      return false;
    }
    if(add_asm_gname == ''){
      alert('Guardian name in Assamese is required !');
      $('#add_asm_gname').focus();
      return false;
    }
    if(add_lh_relation == ''){
      alert('Relation with guardian is required !');
      $('#add_lh_relation').focus();
      return false;
    }
    if(add_lh_contact_no == ''){
      alert('Contact No is required !');
      $('#add_lh_contact_no').focus();
      return false;
    }
    if(add_lh_address == ''){
      alert('Address is required !');
      $('#add_lh_address').focus();
      return false;
    }
    if(add_lh_contact_no.length != 10){
      alert('Not a Valid Mobile number!');
      $('#add_lh_contact_no').focus();
      return false;
    }
    if(add_lh_gender == '' || add_lh_gender == null){
      alert('Select Gender');
      $('#add_lh_gender').focus();
      return false;
    }
    if(add_lh_life_status == '' || add_lh_life_status == null){
      alert('Select Life status of the individual');
      $('#add_lh_life_status').focus();
      return false;
    }

    

    //prepare for updation
    var postData = {
      'case_no'           : case_no,
      'add_eng_name'      : add_eng_name,
      'add_asm_name'      : add_asm_name,
      'add_eng_gname'     : add_eng_gname,
      'add_asm_gname'     : add_asm_gname,
      'add_lh_relation'   : add_lh_relation,
      'add_lh_contact_no' : add_lh_contact_no,
      'add_lh_address'    : add_lh_address,
      'add_lh_gender'     : add_lh_gender,
      'add_lh_life_status': add_lh_life_status,
    };

    $.blockUI({
      message: $('#displayBox'),
      css: {
        border:'none',
        backgroundColor:'transparent'
      }
    });

    $.ajax({
      url: baseurl+'TeaGrantController/addLegalHeirDetails',
      type: "POST",
      data: postData,
      success: function(data) {
        arr = JSON.parse(data);

        $.unblockUI();
        if(arr.responseType == 0){
          showErrorMessage(arr.msg);
        }
        else
        {
          addLegalHeirModal.style.display = "block";
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
              console.log(arr.appnData);
              $('#add_eng_name').val('');
              $('#add_asm_name').val('');
              $('#add_eng_gname').val('');
              $('#add_asm_gname').val('');
              $('#add_lh_relation').val('');
              $('#add_lh_contact_no').val('');
              $('#add_lh_address').val('');
              $('#add_lh_gender').val('-- Select Gender --');

              // console.log(arr.appnData);
                
              addLegalHeirModal.style.display = "block";
              var tableKin = '';
              $.each(arr.appnData, function (i, val)
              {
                if(val.pdar_gender == 1) { gender = 'Male';}
                if(val.pdar_gender == 2) { gender = 'Female';}
                if(val.pdar_gender == 3) { gender = 'Other';}

                if(val.pdar_rel_guar == 1) { relation = 'মাতৃ';}
                if(val.pdar_rel_guar == 2) { relation = 'পিতৃ';}
                if(val.pdar_rel_guar == 3) { relation = 'পতি';}
                if(val.pdar_rel_guar == 4) { relation = 'পত্নী';}
                if(val.pdar_rel_guar == 7) { relation = 'অভিভাৱক';}

                // console.log(val);
                tableKin +=
                  '<tr id="sp'+val.id +'">'+
                    '<td>' + val.pdar_name  + '</td>' +
                    '<td>' + val.pdar_guardian  + '</td>' +
                    '<td>' + gender  + '</td>' +
                    '<td>' + relation  + '</td>' +
                    '<td>' + val.pdar_mobile  + '</td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteFamily('+val.id+');">Remove</button></td>' +
                  '</tr>'
              });
              $('#listLegalHeir').html(tableKin);
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
        url: baseurl+'TeaGrantController/delLegalHeir',
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
            showSuccessMessage("Record has been successfully deleted !!!");
            $("#next_of_kin_count option[value="+data.count+"]").prop('selected', 'selected');
          }         
        }
      });
    }
    else {
      // loading.out();
    }
  }

  $('.closefamily').click(function(){
    addLegalHeirModal.style.display = "none";
  });


</script>
