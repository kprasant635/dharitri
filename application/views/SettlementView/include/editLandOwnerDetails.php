<style>
  /* The Close Button */
  .closeOwnerModal {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .closeOwnerModal:hover,
  .closeOwnerModal:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
</style>

<div id="editLandOwner" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
      <span class="closeOwnerModal px-4">&times;</span>
    </div>
    <p>
    <div class="row">
      <div class="col-md-12 text-center">
        <h5>Edit Land Owner Detail(s) for <span id="dag_land_owner"></span></h5>
      </div>
    </div>

    <div class="tableCard">
      <table class="table table-bordered" id='datatable'>
        <thead>
          <th>All <input type="checkbox" value="all" id="checkedAll"> </th>
          <th>Owner`s Name</th>
          <th>Guardian Name</th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    
    <div class="row justify-content-center">
      <button type="button" class="btn btn-sm btn-danger col-3" id="saveLandOwner">Edit Land Owner Detail(s)</button>

      <input type="hidden" id="district_code" value="">
      <input type="hidden" id="subdiv_code" value="">
      <input type="hidden" id="circle_code" value="">
      <input type="hidden" id="mouza_code" value="">
      <input type="hidden" id="lot_no_code" value="">
      <input type="hidden" id="village_code" value="">
      <input type="hidden" id="dag_no_code" value="">
      <input type="hidden" id="pattatype_code" value="">
      <input type="hidden" id="pattano_code" value="">
      <input type="hidden" id="case_no_code" value="">

    </div>
    </p>
  </div>

</div>

<script type="text/javascript">

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

  function showErrorMessage(text) {
    swal.fire({
      title: "Error!",
      text: text,
      icon: 'error',
      position: 'top',
      timer: 5000,
      showCancelButton: true
    });
  }

  function showWarningMessage(text) {
    swal.fire({
      title: "Warning!",
      text: text,
      icon: 'warning',
      position: 'top',
      timer: 5000,
      showCancelButton: true
    });
  }
    
  var editLandOwnerModal = document.getElementById("editLandOwner");
  var spanOwner = document.getElementsByClassName("closeOwnerModal")[0];

  function popUpLandOwnerModal(dist, sub, cir, mouza, lot, vill, dag, pcode, pno, caseno){
    
    $('#dag_land_owner').html(dag);
    $('#district_code').val(dist);
    $('#subdiv_code').val(sub);
    $('#circle_code').val(cir);
    $('#mouza_code').val(mouza);
    $('#lot_no_code').val(lot);
    $('#village_code').val(vill);
    $('#dag_no_code').val(dag);
    $('#pattatype_code').val(pcode);
    $('#pattano_code').val(pno);
    $('#case_no_code').val(caseno);

    editLandOwnerModal.style.display = "block"; // to display the modal    
    spanOwner.onclick = function() { // to close the modal
      editLandOwnerModal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == editLandOwnerModal) {
        editLandOwnerModal.style.display = "block";
      }
    }

    $('#datatable').DataTable().destroy();

    var table = $('#datatable').DataTable({
      'pageLength': 25,
      "processing": true,
      "serverSide": true,
      "ordering"  : false,
      "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
      'language'  : {
        "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
      },
      'ajax':{
        url: baseurl+'SettlementAp/getlistOfLandOwnerDetailsByDagNo',
        type:'POST',
        data: {
          dist  : dist,
          sub   : sub,
          cir   : cir,
          mouza : mouza,
          lot   : lot,
          vill  : vill,
          dag   : dag,
          pcode : pcode,
          pno   : pno,
        },
        deferLoading: 57,
      },
      order: [[2, 'asc']],
      columnDefs: [{
        targets: 0,
        checkboxes: {
          'selectRow': true
        },
        data: "is_visible",
        'render': function (data, type, row) {
          let text = row[0];
          return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+row[0]+' name="selectMark[]">';
        }
      }],
    });
  }

  var selectedCheckBoxArray = [];
  $('#dataTable tbody').on('click', 'input[type="checkbox"]', function(e) {
    var checkBoxId = $(this).val();
    var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray); 
    if(this.checked && rowIndex === -1) {
      selectedCheckBoxArray.push(checkBoxId);
    }
    else if (!this.checked && rowIndex !== -1) {
      selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
    }
  });

  $("#dataTable").on('draw.dt', function() {
    for (var i = 0; i < selectedCheckBoxArray.length; i++) {
      checkboxId = selectedCheckBoxArray[i];
      const myArray = checkboxId.split("/");
      var arr = myArray[3];
      $('#' + arr).attr('checked', true);
    }
  });

  $("#checkedAll").click(function(){
    if(this.checked){
      $('.selectMark').each(function(){
        this.checked = true;
        var id = $(this).val();
        if($.inArray(id, selectedCheckBoxArray) !== -1){
          // $('.selectMark').prop('checked', false);
        }else{
          selectedCheckBoxArray.push(id);
          $('.selectMark').prop('checked', true);
        }
      })
    }else{
      $('.selectMark').each(function(){
        this.checked = false;
        var id = $(this).val();
        var rowIndex = $.inArray(id, selectedCheckBoxArray);
        if(rowIndex == -1){

        }else{
          selectedCheckBoxArray.splice(rowIndex, 1);
          $('.selectMark').prop('checked', false);
        }                
      })
    }
  });

  $('#saveLandOwner').click(function(){

    Swal.fire({
      backdrop:true,
      allowOutsideClick: false,
      text: '"All previous Land Owner detail(s) for this application will be removed. It cannot be undone once changes. Are you sure to edit Land Owner Detail(s) ?"',
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
        var selectedList = [];
        $('.selectMark:checked').each(function(i){
          selectedList[i] = $(this).val();
        });

        if (selectedList.length > 0)
        {
          const list = {
            selectedList   : selectedList,
            district_code  : $('#district_code').val(),
            subdiv_code    : $('#subdiv_code').val(),
            circle_code    : $('#circle_code').val(),
            mouza_code     : $('#mouza_code').val(),
            lot_no_code    : $('#lot_no_code').val(),
            village_code   : $('#village_code').val(),
            dag_no_code    : $('#dag_no_code').val(),
            pattatype_code : $('#pattatype_code').val(),
            pattano_code   : $('#pattano_code').val(),
            case_no        : $('#case_no_code').val(),
          };

          $.ajax({
            url: baseurl+'SettlementAp/saveLandOwnerDetail',
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
              if(data.responseType == 1){
                showErrorMessage(data.message);
              }
              else if(data.responseType == 2){
                Swal.fire({
                  backdrop:true,
                  allowOutsideClick: false,
                  text: data.message,
                  confirmButtonText: 'OK',
                  customClass: {
                    actions: 'my-actions',
                    confirmButton: 'order-2',
                  }
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#saveLandOwner').prop('disabled', true);
                    $('.closeOwnerModal').hide();
                    location.reload(true);
                  }
                });
              }
            },
            data: JSON.stringify(list)
          });
        }
        else {
          showErrorMessage("Select at least one owner to process");
        }
      }
    })
  });

</script>
