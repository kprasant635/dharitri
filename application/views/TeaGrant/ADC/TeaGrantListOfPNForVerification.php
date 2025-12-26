<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <?php if ($this->session->flashdata('message')): ?>
          <?php include 'message.php'; ?>
        <?php endif; ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process > 
            Settlement MB3 > 
            <a href="<?= base_url()?>index.php/TeaGrantControllerAdc/teaGrantAdc">Tea Grant</a> >
            <a href="<?= base_url()?>index.php/TeaGrantControllerAdc/viewAllPendingCasesAtAdcForDocUpload">Re-Generate Payment Notice</a>

            <a href="<?= base_url()?>index.php/TeaGrantControllerAdc/teaGrantAdc">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>


        <div class="reza-card col-lg-12">
            <div class="reza-title" style="font-style: italic;">
                <span>Limited Conversion of Tea Grant Land to Periodic Patta - Re-Generate Payment Notice</span>
                <br>
                <span style="background-color:yellow">On regenerating the below notice(s), it/these will supercedes earlier issued notice(s) dtd before 08 Aug, 2025</span>
                <hr>
                <button class="btn btn-sm btn-success"></button> - <span style="font-size: 13px;">View Application</span> |
                <button class="btn btn-sm btn-info"></button> - <span style="font-size: 13px;">Re Generate Payment Notice</span>
            </div>

            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>

                    <table class="datatable table table-stripped" id='datatable'>
                        <thead>
                        <tr style="font-size: 12px;">
                            <th>SL No.</th>
                            <th>Circle Name
                                <select class="form-control input_search" name="cir_id" id="cir_id" data-column-index="0">
                                    <option value="">Select Circle</option>
                                    <?php
                                        if(isset($location)){ foreach($location as $cir){
                                        ?>
                                        <option value="<?=$cir['cir_code'].",".$cir['subdiv_code']?>"><?=$cir['cir_name']?></option>
                                    <?php }}?>
                                </select>
                            </th>

                            <th>Village Name
                                <select name="vill_id" class="form-control input_search" id="vill_id" 
                                data-column-index="1">
                                    <option value="">Select Village </option>
                                </select>
                            </th>

                            <th class="center"><?php echo $this->lang->line('submission_date'); ?> <br> Area Type
                            </th>

                            <th><?php echo $this->lang->line('case_no'); ?>
                                <input type="text" id="by_case_no" name="by_case_no"
                                class="form-control" placeholder="Search by Case No">
                            </th>
                            
                            <th class="center">Action

                                <button type="button" class="search_button btn btn-sm btn-success form-control"><i class="fa fa-search" aria-hidden="true"></i>
                                    Search</button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>                        
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<div id="render_data"></div>

<script>

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

  $('#datatable').DataTable();

  $('#cir_id').change(function()
  {
      var base_url = "<?php echo base_url();?>";
      cir_id       = $('#cir_id').val();
      var villcode = cir_id.split(",");
      var circle   = villcode[0];
      var subdiv   = villcode[1];

      $.ajax({
          url: base_url+'index.php/SettlementCommonDc/villageListCommon',
          dataType: 'json',
          data: {
              subdiv_code: subdiv,
              cir_code: circle,
          },
          type: "POST",
          success: function(data) {

              if(data.responseType == 1){

                  var village_detail = "<option value=''>Select Village</option>";

                  $.each(data.location, function (i, val) {
                  village_detail +=
                      "<option value='"+ val["cir_code"] +","+ val["subdiv_code"] +","+ val["mouza_pargona_code"] +","+ val["lot_no"] +","+ val["vill_townprt_code"] +"'>"+val["loc_name"]+"</option>";
                  });
                  $('#vill_id').html(village_detail);
              }
          }, 
          error: function(error) { // runtime error message
            var village_detail = "<option value=''>Select Village</option>";
            $('#vill_id').html(village_detail);
          },
      });
  });

  load_data();

  function load_data(){
      var base_url       = "<?php echo base_url();?>";
      var service_code   = <?= TEA_SERVICE_CODE?>;

      cir_code           = $('#cir_id').val();
      var newcircle      = cir_code.split(",");
      cir_id             = $('#vill_id').val();
      var villcode       = cir_id.split(",");
      var circle         = newcircle[0];
      var subdiv         = newcircle[1];
      var mouza          = villcode[2];
      var lot            = villcode[3];
      var vill_id        = villcode[4];
      var case_no        = $('#by_case_no').val();
      var rem_cat        = $('#remark_cat').val();
      var remark_cat_lm  = $('#remark_cat_lm').val();

      $('#datatable').DataTable().destroy();
      var table = $('#datatable').DataTable({

        'pageLength':10,
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
        'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
        'ajax':{
            url: base_url+'index.php/TeaGrantControllerAdc/listOfAlreadyGeneratedPN',
            type:'POST',
            data: {
              service       : service_code,
              circle        : circle,
              subdiv        : subdiv,
              mouza         : mouza,
              lot           : lot,
              vill_id       : vill_id,
              case_no       : case_no,
              remark_cat    : rem_cat,
              remark_cat_lm : remark_cat_lm
            },
            deferLoading: 57,
        },

        order: [[2, 'asc']],

        columnDefs: [{
          targets: "_all",
          orderable: false,
          "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
        }]              
      });
  }

  $('.search_button').click(function(){
      load_data();
  });

  var selectedCheckBoxArray = [];
  $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
    var checkBoxId = $(this).val();
    var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
    if(this.checked && rowIndex === -1) {
      selectedCheckBoxArray.push(checkBoxId);
    }
    else if (!this.checked && rowIndex !== -1) {
      selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
    }
  });


  $("#checkedAll").click(function(){
    if(this.checked){
      $('.selectMark').each(function(){
        this.checked = true;
        var id = $(this).val();
        if($.inArray(id, selectedCheckBoxArray) !== -1){
            // $('.selectMark').prop('checked', false);
        }
        else{
          selectedCheckBoxArray.push(id);
          $('.selectMark').prop('checked', true);
        }
      })
    }
    else
    {
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


  $("#datatable").on('draw.dt', function() 
  {
    for (var i = 0; i < selectedCheckBoxArray.length; i++) {
      checkboxId    = selectedCheckBoxArray[i];
      const myArray = checkboxId.split("/");
      var arr       = myArray[3];
      $('#' + arr).attr('checked', true);
    }
  });

  // function re_gen_payment_notice_btn_tea_grant(case_no)
  // {
  //   // alert("sdfghj");
  //   $.blockUI({
  //      message: $('#displayBox'),
  //      css: {
  //        border:'none',
  //        backgroundColor:'transparent'
  //      }
  //   });
  //   $.ajax({
  //      url: baseurl+'TeaGrantControllerAdc/loadViewForPaymentGeneration',
  //      type: "POST",
  //      data: { case_no: case_no },
  //      success: function(data) { 
  //        $.unblockUI();
  //        $('#render_data').html(data);
  //        load_data();
  //      }
  //   });
  // }

</script>