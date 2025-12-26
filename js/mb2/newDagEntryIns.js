
  var newDagEntryModal = document.getElementById("newDagEntryDetails");
  var scode = $('#code_service').val();
  
  var dist = $('#code_dist').val();
  var subdiv = $('#code_sub').val();
  var cir = $('#code_cir').val();
  var mouza = $('#code_mouza').val();
  var lot = $('#code_lot').val();
  var vill = $('#code_vill').val();
  var rural_urban = $('#code_rural_urban').val();

   // Success Message
   function showSuccessMessage(text) {
    swal.fire({
        title: "Success !",
        text: text,
        icon: 'success',
        position: 'top',
        showConfirmButton: true,
        timer: 5000,
    });
    // location.reload();
}

  barak_valley = new Array('21','22','23');

  function loader() {
    $.blockUI({
      message: $('#displayBox'),
      css: {
        border:'none',
        backgroundColor:'transparent'
      }
    });
  }

  if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley

    $(".div_other_valley").show();
    $(".div_barak_valley").hide();
    $('.in_ganda_div').hide();
    $('.in_kranti_div').hide();
    $('.lessa_title').show();
    $('.chatak_title').hide();
    $('#home_katha').show();
    $('#home_katha_barak').hide();
    $('#agri_katha').show();
    $('#agri_katha_barak').hide();
  }
  else { // for barak valley

    $(".div_other_valley").hide();
    $(".div_barak_valley").show();
    $('.in_ganda_div').show();
    $('.in_kranti_div').show();
    $('.lessa_title').hide();
    $('.chatak_title').show();
    $('#home_katha').hide();
    $('#home_katha_barak').show();
    $('#agri_katha').hide();
    $('#agri_katha_barak').show();
  }

  $('.na_possessionFromDate').hide();
  $('.na_encroacher').prop("checked", false);


  $('.na_encroacher').click(function(){
    if($("input[name='na_encroacher']:checked").val() == '-1'){
      $('.na_possessionFromDate').show();
      $("input[name='select_encroacher']").prop("checked", false);
      $('#encroacher_id_available').val('0');
      $('#encroacher_id').val('-1');
    }
    else{
      $('.na_possessionFromDate').hide();
      $('.na_encroacher').prop("checked", false);
      $('#encroacher_id_available').val('1');
    }
  });


  //closing modal
  $('.close-new-dag-entry').click(function()
  {
    newDagEntryModal.style.display = "none";
    $('.na_encroacher').prop('checked', false);
    $('#na_possessionFrom').val('');
    $('.na_possessionFromDate').hide();
    
    $('#encroacher_list').DataTable().destroy();
    $('.appendEncroacherDetail').find('tbody').empty().append(data);
    $('#encroacher_list').dataTable({bSort: false});

    $('.for_homestead').show();
    $('.for_agriculture').hide();
    $("input[name='natureof_land']").prop("checked", false);

    $('#hbigha').val('0');
    $('#hkatha').val('0');
    $('#hlessa').val('0');
    $('#hganda').val('0');
    $('#hkranti').val('0');

    $('#abigha').val('0');
    $('#akatha').val('0');
    $('#alessa').val('0');
    $('#aganda').val('0');
    $('#akranti').val('0');
  });


  //entry of new dag
  $('#add_new_dag').click(function(){

    loader();

    $('.for_homestead').hide();
    $('.for_agriculture').hide();
    $('#hbigha').val('0');
    $('#hkatha').val('0');
    $('#hlessa').val('0');
    $('#hganda').val('0');
    $('#hkranti').val('0');

    $('#abigha').val('0');
    $('#akatha').val('0');
    $('#alessa').val('0');
    $('#aganda').val('0');
    $('#akranti').val('0');
    $("input[name='natureof_land']").prop("checked", false);

    newDagEntryModal.style.display = "block";

    var location_detail = {
      dist        : dist,
      subdiv      : subdiv,
      cir         : cir,
      mouza       : mouza,
      lot         : lot,
      vill        : vill,
      rural_urban : rural_urban,
      scode       : scode,
    };

    $.ajax({
      url      : baseurl + "SettlementCommonIns/getDagList",
      type     : "post",
      dataType : "json",
      success: function(data) {
        
        $.unblockUI();

        var template = "<option value='' selected disabled>-- Select Dag --</option>";

        if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
          for (var i = 0; i < data.length; i++) {
            template += "<option value='"+data[i].dag_no_int+"/"+data[i].bigha+"/"+data[i].katha+"/"+data[i].lessa+"'>" + data[i].dag_no + " (B/K/L): " + data[i].bigha + "/"+ data[i].katha + "/"+ data[i].lessa +"</option>";
          }
        }
        else { // for barak valley
          for (var i = 0; i < data.length; i++) {
            template += "<option value='"+data[i].dag_no_int+"/"+data[i].bigha+"/"+data[i].katha+"/"+data[i].lessa+"/"+data[i].ganda+"'>" + data[i].dag_no + " (B/K/C/G): " + data[i].bigha + "/"+ data[i].katha + "/"+ data[i].lessa + "/"+ data[i].ganda +"</option>";
          }
        }

        $("#dag_list").html(template); 

      }, error: (error) => {
        $.unblockUI();
        showErrorMessage("#ERR110: Error in fetching Dag detail. Kindly contact system administrator!!!");
      },
      data: JSON.stringify(location_detail)
    });
  });


  //on change nature of land
  $('.natureof_land').change(function()
  {
    if($(this).val()==1){ //homestead
      $('.for_homestead').show();
      $('.for_agriculture').hide();
    }
    else if($(this).val()==2){ //agriculture
      $('.for_homestead').hide();
      $('.for_agriculture').show();
    }
    else if($(this).val()==3){ //both
      $('.for_homestead').show();
      $('.for_agriculture').show();
    }
  });


  //on change dag
  $("#dag_list").change(function()
  {
    loader();

    dag_no = $("#dag_list").val();
    const myArray = dag_no.split("/");

    if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
      $("#new_dag_int").val(myArray[0]);
      $("#tot_bigha").val(myArray[1]);
      $("#tot_katha").val(myArray[2]);
      $("#tot_lessa").val(myArray[3]);
      $("#tot_ganda").val(0);
      $("#tot_kranti").val(0);
    }
    else { // for barak valley
      $("#new_dag_int").val(myArray[0]);
      $("#tot_bigha").val(myArray[1]);
      $("#tot_katha").val(myArray[2]);
      $("#tot_lessa").val(myArray[3]);
      $("#tot_ganda").val(myArray[4]);
      $("#tot_kranti").val(0);
    }

    var dag_detail = {
      dist        : dist,
      subdiv      : subdiv,
      cir         : cir,
      mouza       : mouza,
      lot         : lot,
      vill        : vill,
      rural_urban : rural_urban,
      scode       : scode,
      dag         : myArray[0],
    };

    $.ajax({
      url      : baseurl + "SettlementCommonIns/getOccupierList",
      type     : "post",
      dataType : "json",
      success: function(data) {

        $.unblockUI();

        $('.for_homestead').hide();
        $('.for_agriculture').hide();
        $("input[name='natureof_land']").prop("checked", false);

        $('#hbigha').val('0');
        $('#hkatha').val('0');
        $('#hlessa').val('0');
        $('#hganda').val('0');
        $('#hkranti').val('0');

        $('#abigha').val('0');
        $('#akatha').val('0');
        $('#alessa').val('0');
        $('#aganda').val('0');
        $('#akranti').val('0');

        $('#encroacher_list').DataTable().destroy();
        $('.appendEncroacherDetail').find('tbody').empty().append(data);
        $('#encroacher_list').dataTable({bSort: false});

      }, error: (error) => {
        $.unblockUI();
        showErrorMessage("SOMETHING WENT WRONG !!!!");
      },
      data: JSON.stringify(dag_detail)
    });
  });


  //on select encroacher from table
  function getEncroacherDetail(enId){
    $('#encroacher_id').val(enId);
    $('.na_possessionFromDate').hide();
    $('.na_encroacher').prop("checked", false); 
    $('#encroacher_id_available').val('1');
  }


  //on save dag/occupier detail
  $('#saveDag').click(function()
  {
    loader();

    var case_no                 = $('#case_no').val();
    var application_no          = $('#application_no').val();
    var encroacher_id           = $('#encroacher_id').val();
    var encroacher_id_available = $('#encroacher_id_available').val();
    var new_dag_int             = $('#new_dag_int').val();
    var tot_bigha               = $('#tot_bigha').val();
    var tot_katha               = $('#tot_katha').val();
    var tot_lessa               = $('#tot_lessa').val();
    var tot_ganda               = $('#tot_ganda').val();
    var tot_kranti              = $('#tot_kranti').val();
    var nature_of_land          = $("input[name='natureof_land']:checked").val();
    var dist                    = $('#code_dist').val();;

    if(encroacher_id_available == '0'){
      var na_possessionFrom = $('#na_possessionFrom').val();
    }
    else {
      var na_possessionFrom = '';
    }    

    if(nature_of_land == 'undefined' || nature_of_land == null || nature_of_land == ''){
      showErrorMessage("Nature of Land is required");
      return true;
    }

    var hbigha  = $('#hbigha').val();    
    var hlessa  = $('#hlessa').val();
    var hganda  = $('#hganda').val();
    var hkranti = $('#hkranti').val();

    var abigha  = $('#abigha').val();    
    var alessa  = $('#alessa').val();
    var aganda  = $('#aganda').val();
    var akranti = $('#akranti').val();
    barak_valley = new Array('21','22','23');

    if($.inArray(dist, barak_valley) == -1 ) { // other than barak valley
      var hkatha = $('#hkatha').val();
      var akatha = $('#akatha').val();
    }
    else {
      var hkatha = $('#hkatha_barak').val();
      var akatha = $('#akatha_barak').val();
    }

    const parameters = {

      case_no                 : case_no,
      application_no          : application_no,
      district                : dist,
      subdiv_code             : subdiv,
      circle                  : cir,
      mouza_code              : mouza,
      lot_no                  : lot,
      village                 : vill,
      service_code            : scode,
      encroacher_id           : encroacher_id,
      encroacher_id_available : encroacher_id_available,
      possession_period       : na_possessionFrom,
      dag                     : new_dag_int,
      tot_bigha               : tot_bigha,
      tot_katha               : tot_katha,
      tot_lessa               : tot_lessa,
      tot_ganda               : tot_ganda,
      tot_kranti              : tot_kranti,      
      hbigha                  : hbigha,
      hkatha                  : hkatha,
      hlessa                  : hlessa,
      hganda                  : hganda,
      hkranti                 : hkranti,
      abigha                  : abigha,
      akatha                  : akatha,
      alessa                  : alessa,
      aganda                  : aganda,
      akranti                 : akranti,
      nature_of_land          : nature_of_land,
      
    };

    $.ajax({
      url      : baseurl + "SettlementCommonIns/saveDagDetail",
      type: "post",
      dataType: "json",
      success: function(data) {
        
        $.unblockUI();
        // data: JSON.stringify(getChithaDag);
        
        
        // $('#dagEntryModal').trigger('reset');

        if (data.responseType == 1) { //validation
          data.validation.forEach(function(validation) {
            var errMsg = "#" + validation.field + "Err";
            $(errMsg).text("⚠️ " + validation.message);
          });
        }

        if (data.responseType == 2) { //successfully added
          showSuccessMessage(data.message);
          newDagEntryModal.style.display = "none";
          location.reload();
          $('#newDagEntryDetails').modal('hide');
          $('#newDagEntryDetails').trigger('reset');
        }

        if (data.responseType == 3) { //error messages
          showErrorMessage(data.message);
        }
        
      }, error: (error) => {
        $.unblockUI();
        showErrorMessage("SOMETHING WENT WRONG !!!!");
      },
      data: JSON.stringify(parameters)
    });
  });
