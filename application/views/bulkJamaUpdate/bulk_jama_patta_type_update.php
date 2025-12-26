<div class="container-fluid login form-top">
  <div class="row">
    <div class="col-lg-12 ">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="well well-sm mis_report">
          <h2 class='uni_text' style="text-align: center; color:#2e4d8e">Select multiple patta type to update Jamabandi</h2>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-info panel-form">
          <div class="panel-heading">
            <h3 class="panel-title"><?=$this->lang->line('select_land_location')?></h3>
          </div>
          <div class="panel-body">
            
            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label"><?=$this->lang->line('district')?></label>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <select  class="form-control districtSelectBulk" name="dist_code" required>
                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                    <option value="<?=$dist_code?>" selected>
                      <?=$this->utilityclass->getDistrictName($dist_code)?>
                    </option>
                  </select>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label"><?=$this->lang->line('subdivision')?></label>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <select  class="form-control subdivSelectBulk" id="select" name="subdiv_code" required>
                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                    <option value="<?=$subdiv_code?>" selected>
                      <?=$this->utilityclass->getSubDivName($dist_code, $subdiv_code)?>
                    </option>
                  </select>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label"><?=$this->lang->line('circle')?></label>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <select  class="form-control circleSelectBulk" id="select" name="circle_code" required>
                    <?php $cir_code = $this->session->userdata('cir_code'); ?>
                    <option value="<?=$cir_code?>" selected>                      
                      <?=$this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code)?>
                    </option>
                  </select>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label"><?=$this->lang->line('mouza')?></label>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <select class="form-control mouzaSelectBulk" id="select" required name="mouza_code">
                    <option disabled selected>Select Mouza</option>
                  </select>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label"><?=$this->lang->line('lot_no')?></label>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <select class="form-control lotSelectBulk" id="select" name="lot_no">
                    <option disabled selected>Select Lot No</option>
                  </select>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label"><?=$this->lang->line('vill_town')?></label>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <select class="form-control villageSelectBulk" id="select" name="vill_code">
                    <option disabled selected>Select Village</option>
                  </select>
                </div> 
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label">Patta Type <br><span style="color:red; font-size: 14px; font-size:italic;">(You can select multiple patta type)</span></label>

                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                  <div class="row" id="list_of_patta_type">
                  </div>
                </div>
              </div>
            </div>              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
            
            <div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 pull-right">
              <button type="button" id="btnFinalSubmit" class="btn btn-primary col-lg-7 col-md-7 col-xs-12 col-sm-7"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
            </div>            

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function showSuccessMessage(text) {
    swal.fire({
      title             : "Success !",
      text              : text,
      icon              : 'success',
      position          : 'top',
      showConfirmButton : true,
      timer             : 5000,
    });
  }

  function showErrorMessage(text) {
    swal.fire({
      title             : "Error !",
      text              : text,
      icon              : 'error',
      position          : 'top',
      showConfirmButton : true,
      timer             : 5000,
    });
  }

  function showWarningMessage(text) {
    swal.fire({
      title             : "Warning !",
      text              : text,
      icon              : 'warning',
      position          : 'top',
      showConfirmButton : true,
      timer             : 5000,
    });
  }

  // get list of lot mouza
  $(document).ready(function()
  {
    var distcode   = $('.districtSelectBulk').val();
    var subdivcode = $('.subdivSelectBulk').val();
    var circode    = $('.circleSelectBulk').val();

    $.ajax({
      url: baseurl + "lmmutation/getMouzaJson/" + distcode + '/' + subdivcode + '/' + circode,
      success: function (data) {
        
        var mouza = JSON.parse(data);
        // console.log(mouza);

        var template = "<option selected disabled>Select Mouza</option>";

        for (var i = 0; i < mouza.length; i++) {
            template += "<option value='" + mouza[i].mouza_pargona_code + "'>" + mouza[i].loc_name + "</option>";
        }
        // console.log(template);
        $('.mouzaSelectBulk').html(template);
      }
    });
  });

  // get list of lot nos
  $('.mouzaSelectBulk').change(function (e) 
  {
    var subdivcode = $('.subdivSelectBulk').val();
    var distcode   = $('.districtSelectBulk').val();
    var circode    = $('.circleSelectBulk').val();
    var mouzacode  = $('.mouzaSelectBulk').val();
    $.ajax({
      url: baseurl + "lmmutation/getLotNoJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode,
      success: function (data) {
        
        var lot = JSON.parse(data);
        var template = "<option selected disabled>Select Lot</option>";

        for (var i = 0; i < lot.length; i++) {
          template += "<option value='" + lot[i].lot_no + "'>" + lot[i].loc_name + "</option>";
        }
        // console.log(template);
        $('.lotSelectBulk').html(template);
      }
    });
  });

  // get list of villages
  $('.lotSelectBulk').change(function (e) 
  {
    var distcode   = $('.districtSelectBulk').val();
    var subdivcode = $('.subdivSelectBulk').val();    
    var circode    = $('.circleSelectBulk').val();
    var mouzacode  = $('.mouzaSelectBulk').val();
    var lotcode    = $('.lotSelectBulk').val();

    $.ajax({
      url: baseurl + "lmmutation/getVillageCodeFlaggedJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode,
      success: function (data) {
        var lot = JSON.parse(data);
        var template = "<option selected disabled>Select Village</option>";

        for (var i = 0; i < lot.length; i++) {
          template += "<option value='" + lot[i].vill_townprt_code + "'>" + lot[i].loc_name+" " +lot[i].villtype +"</option>";
        }
        $('.villageSelectBulk').html(template);
      }
    });
  });

  // get list of patta types
  $(document).ready(function()
  {
    var distcode   = $('.districtSelectBulk').val();

    $.ajax({
      url: baseurl + "BulkPattaTypeUpdateController/getListOfPattaTypeCode/" + distcode ,
      success: function (data) {

        var patta = JSON.parse(data);
        var html_list = '';
        for (var i = 0; i < patta.length; i++) 
        { 

          html_list +=

            '<div class="col-lg-1 col-md-1 col-sm-6 col-xs-6">'+
              '<input class="form-check-input me-1 form_input ps-3 list-group-flush list_of_patta_type" type="checkbox" value="'+patta[i].type_code+'" name="list_of_patta_type[]">'+
            '</div>'+
            '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">'+
              '<span style="color:red">'+patta[i].patta_type+'</span>'+
            '</div>'        
        }
        $('#list_of_patta_type').html(html_list);
      }
    });
  });

  // final submit
  $('#btnFinalSubmit').click(function()
  {
    var dist_code   = $('.districtSelectBulk').val();
    var subdiv_code = $('.subdivSelectBulk').val();    
    var circle_code = $('.circleSelectBulk').val();
    var mouza_code  = $('.mouzaSelectBulk').val();
    var lot_no      = $('.lotSelectBulk').val();
    var vill_code   = $('.villageSelectBulk').val();
    var patta_type  = $('#list_of_patta_type').val();

    var selectedList = [];
    $('.list_of_patta_type:checked').each(function(i){
      selectedList[i] = $(this).val();
    });

    const params = {
      dist_code          : dist_code,
      subdiv_code        : subdiv_code,
      circle_code        : circle_code,
      mouza_code         : mouza_code,
      lot_no             : lot_no,
      vill_code          : vill_code,
      list_of_patta_type : selectedList,
    }

    $.ajax({
      url      : baseurl + "BulkPattaTypeUpdateController/updateJamabandi",
      type     : "post",
      dataType : "json",
      success: function (data) 
      {
        if(data.responseType == 1)
        {
          showErrorMessage(data.message);
        }
        else if(data.responseType == 3)
        {
          showSuccessMessage(data.message);
        }
        else
        {
          showErrorMessage("Something went wrong on updating jamanabandi !!!");
        }
      }, error: (error) => {
        alert("Something went wrong to update Jamabandi");
      },
      data: JSON.stringify(params),
    });

  });



</script>