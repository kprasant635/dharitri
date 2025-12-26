<style>
  .table_div_responsive {
    overflow-x: scroll;
  }
</style>

<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/loader1.gif" style="width: 100px;"></div> 

<input type="hidden" id="checkstatus" value="<?=$_GET['check']?>">

<br>

<!-- Service wise pending cases -->
<div class="container table_div_responsive">

  <h2>Total no of application(s) <b><?php echo ucwords($_GET['check']); ?></b>
    <a class="btn btn-sm btn-danger pull-right" href="<?=base_url().'BasundharaApi/getRtpsDataReview'?>"><< Go Back</a>
  </h2>   

  <table id="application_detail" class="table table-hover table-responsive table-bordered table_div_responsive">
    <thead>
      <tr style="background-color: #186d84; color:white;">
        <th>Sr No</th>
        <th>Application No</th>
        <!-- <th>Location</th> -->
        <th>Service</th>
        <th>Applied On(dd/mm/yyyy)</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <hr>
</div>

<?php include(APPPATH."views/SettlementView/include/rtpsApplicationDetailReview.php");?>

<script>

  baseurl = "https://basundhara.assam.gov.in/ilrms/BasundharaApi/";
  // baseurl = "http://localhost/ilrms_server/BasundharaApi/";

  $(document).ready(function(){
    
    $('#application_detail').DataTable();

    load_data();

    function load_data() {

      $('#application_detail').DataTable().destroy();
      var table = $('#application_detail').DataTable({

        'pageLength':10,
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
        'language': {
                      "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                    },
        'ajax':{
          url: baseurl+'getApplicationDetailsAppliedByApplicantsReview',
          type:'POST',
          deferLoading: 57,
          data: {
            checkstatus : $('#checkstatus').val(),
          },
        },

        columnDefs: [{
          targets: "_all",
          orderable: false,
          "className": "dt-center", "targets":[ 0, 1, 2, 3, 4],
        }]
              
      });
    }

  });

  function loader() {
    $.blockUI({
      message: $('#displayBox'),
      css: {
        border:'none',
        backgroundColor:'transparent',
      }
    });
  }

  function viewAppl(appl_no){

    $('#applicationModal').modal();

    $('.apl_no').html('');
    $('.submission_date').html('');
    $('.applicant_name').html('');
    $('.guardian_name').html('');
    $('.dob').html('');
    $('.mobile').html('');
    $('.present_add').html('');
    $('.per_add').html('');

    $('.owner_details').html('');
    $('.tenant_ap_area_details').html('');
    $('.area_details').html('');
    $('.occupier_details').html('');

    loader();

    $.ajax({
      url: baseurl+"getRtpsApplicationDetailsReview",
      dataType: "JSON",
      data: {appl_no:appl_no},
      type: "POST",
      success: function(res) {

        $.unblockUI();

        var present_add = res.settlements[0].pre_add+','+res.settlements[0].pre_city+','+res.settlements[0].pre_pin;

        var per_add = res.settlements[0].per_add+','+res.settlements[0].per_city+','+res.settlements[0].per_pin;

        var service_code = res.application.service_code;

        $.each(res.settlements, function (i, val) {
          if(val['is_applicant'] == 1){
            $('.applicant_name').html(val['name_eng']);
            $('.guardian_name').html(val['gurdian_name_eng']);
            $('.dob').html(val['dob']);
            $('.mobile').html(val['mobile']);
          }
        });

        $('.apl_no').html(res.application.application_no);
        $('.submission_date').html(res.application.date_submission);        
        $('.present_add').html(present_add);
        $('.per_add').html(per_add);

        //owner detail
        if(service_code == 13 || service_code == 14){

          $('.owner_detail_div').show();
          $('.tenant_ap_area_detail_div').show();
          $('.area_detail_div').hide();
          $('.occupier_detail_div').hide();

          // owner details
          var owner_detail = '';
          $.each(res.owners, function (i, val) { // if data available
            owner_detail +=
              '<tr>'+
                '<td>' + val["name_ass"] + '</td>' +
                '<td>' + val["gurdian_name_ass"] + '</td>' +
              '</tr>'
          });
          $('.owner_details').html(owner_detail);

          // area details
          var tenant_ap_area_details = '';
          $.each(res.settlements, function (i, val) { // if data available

            actual_area = 'B: '+val["applied_bigha"] +', K: '+ val["applied_katha"] +', L/Ch: '+ val["applied_lessa"] +', G: '+ val["applied_ganda"] +', Kr: '+ val["applied_kranti"];

            applied_area = 'B: '+val["mbigha"] +', K: '+ val["mkatha"] +', L/Ch: '+ val["mlessa"] +', G: '+ val["mganda"] +', Kr: '+ val["mkranti"];

            tenant_ap_area_details +=
              '<tr>'+
                '<td>' + val["dag_no"] + '</td>' +
                '<td>' + actual_area + '</td>' +
                '<td>' + applied_area + '</td>' +
              '</tr>'
          });
          $('.tenant_ap_area_details').html(tenant_ap_area_details);
        }

        
        if(service_code == 15 || service_code == 16 || service_code == 17 || service_code == 18){

          $('.owner_detail_div').hide();
          $('.tenant_ap_area_detail_div').hide();
          $('.area_detail_div').show();
          $('.occupier_detail_div').show(); 

          // area details
          var area_detail = '';
          $.each(res.encroachers, function (i, val) { // if data available

            actual_area = 'B: '+val["applied_bigha"] +', K: '+ val["applied_katha"] +', L/Ch: '+ val["applied_lessa"] +', G: '+ val["applied_ganda"] +', Kr: '+ val["applied_kranti"];

            home_area = 'B: '+val["mbigha"] +', K: '+ val["mkatha"] +', L/Ch: '+ val["mlessa"] +', G: '+ val["mganda"] +', Kr: '+ val["mkranti"];

            agri_area = 'B: '+val["agri_bigha"] +', K: '+ val["agri_katha"] +', L/Ch: '+ val["agri_lessa"] +', G: '+ val["agri_ganda"] +', Kr: '+ val["agri_kranti"];

            area_detail +=
              '<tr>'+
                '<td>' + val["dag_no"] + '</td>' +
                '<td>' + actual_area + '</td>' +
                '<td>' + home_area + '</td>' +
                '<td>' + agri_area + '</td>' +
              '</tr>'
          });
          $('.area_details').html(area_detail);


          // occupier details
          var occupier_detail = '';
          $.each(res.encroachers, function (i, val) { // if data available
            occupier_detail +=
              '<tr>'+
                '<td>' + val["dag_no"] + '</td>' +
                '<td>' + val["name_ass"] + '</td>' +
                '<td>' + val["gurdian_name_ass"] + '</td>' +
                '<td>' + val["possession_date"] + '</td>' +
              '</tr>'
          });
          $('.occupier_details').html(occupier_detail);
        }
      }, 
      error: function(error) { // runtime error message
        $.unblockUI();
        showWarningMessage("Something went wrong. Kindly contact system adminstrator");
      },
    });
  }


  



</script>