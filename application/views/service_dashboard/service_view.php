<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/loader1.gif" style="width: 100px;"></div> 
<style>

  .btn-circle {
    width: 300px;
    height: 300px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
  }
  .btn-circle.btn-lg {
    width: 300px;
    height: 300px;
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 25px;
  }
  .btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    font-size: 24px;
    line-height: 1.33;
    border-radius: 35px;
  }


  :root {
    --loader-size: 50px;
    --dot-size: 6px;
    --loader-bg: #e1e6e2;
    --dot-color: black;
  }

  .loader {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba(1, 18, 64, 0.2);
    transition: opacity 0.3s ease-out, top 0.3s step-end;
    z-index: 99;
  }

  .loader.trans {
    transition: opacity 0.5s ease-out, top 0.5s step-start;
    opacity: 1;
    top: 0;
  }

  .loader .loaderview {
    position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    width: auto;
    height: auto;
    padding: 10px 40px;
    border-radius: 5px;
    top: 0;
    left: 0;
    z-index: 100;
    flex-flow: column;
    background-color: var(--loader-bg);
  }

  h1 {
    color: var(--dot-color);
    font-size: 1.2em;
    animation: fading 1.5s ease-in-out infinite;
    font-family: "Comfortaa", cursive;
  }

  .Loader-box {
    margin: 20px;
    flex: 0 0 auto;
    height: var(--loader-size);
    width: var(--loader-size);
  }

  .box {
    position: absolute;
    height: var(--loader-size);
    width: var(--loader-size);
    animation: rotating 4s ease-in infinite;
    animation-delay: calc(var(--id) * 0.5s);
  }

  .dot {
    background-color: var(--dot-color);
    height: var(--dot-size);
    width: var(--dot-size);
    border-radius: 100%;
  }

  @keyframes rotating {
    0% {
      opacity: 0;
      transform: rotateZ(0);
    }
    25% {
      opacity: 100%;
      transform: rotateZ(160deg);
    }

    75% {
      opacity: 200%;
      opacity: 100;
    }
    80% {
      transform: rotateZ(300deg);
      opacity: 100;
    }
    100% {
      transform: rotateZ(350deg);
      opacity: 0;
    }
  }

  @keyframes fading {
    0% {
      opacity: 40%;
    }
    50% {
      opacity: 90%;
    }
    100% {
      opacity: 40%;
    }
  }
</style>

<div class="hide loader" id="loader" style="display:none">
  <div class="loaderview">
    <h1>Don't refresh the page until the process is completed...</h1>
    <div class="Loader-box">
      <div class="box" style="--id:1">
        <div class="dot"></div>
      </div>
      <div class="box" style="--id:2">
        <div class="dot"></div>
      </div>
      <div class="box" style="--id:3">
        <div class="dot"></div>
      </div>
      <div class="box" style="--id:4">
        <div class="dot"></div>
      </div>
      <div class="box" style="--id:5">
        <div class="dot"></div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <h2>Total No. of Basundhara 2.0 Case(s) in District</h2>
</div><hr>

<div class="container">
  <div class="form-group">
    <div class="row">    
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 my-2">
        <div class="card-body">
          <h5 class="card-text">Received</h5><hr>
          <h4 class="num-card-title"><?= $total_array[0]["received"]?></h4><hr>
          <?php if($total_array[0]["received"] != 0) { ?>
            <!-- <a href="<?=base_url().'index.php/BasundharaApi/loadViewPage?check=received'?>" >
              <span class="more_details">More details >></span></a> -->
          <?php } ?>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 my-2">
        <div class="card-body">
          <h5 class="card-text">Pending</h5><hr>
          <h4 class="num-card-title"><?= $total_array[0]["pending"]?></h4><hr>
          <?php if($total_array[0]["pending"] != 0) { ?>
            <!-- <a href="<?=base_url().'index.php/BasundharaApi/loadViewPage?check=pending'?>" >
              <span class="more_details">More details >></span></a> -->
          <?php } ?>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 my-2">
        <div class="card-body">
          <h5 class="card-text">Delivered</h5><hr>
          <h4 class="num-card-title"><?= $total_array[0]["delivered"]?></h4><hr>
          <?php if($total_array[0]["delivered"] != 0) { ?>
            <!-- <a href="<?=base_url().'index.php/BasundharaApi/loadViewPage?check=delivered'?>" >
              <span class="more_details">More details >></span></a> -->
          <?php } ?>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 my-2">
        <div class="card-body">
          <h5 class="card-text">Rejected</h5><hr>
          <h4 class="num-card-title"><?= $total_array[0]["rejected"]?></h4><hr>
          <?php if($total_array[0]["rejected"] != 0) { ?>
            <!-- <a href="<?=base_url().'index.php/BasundharaApi/loadViewPage?check=rejected'?>" >
              <span class="more_details">More details >></span></a> -->
          <?php } ?>          
        </div>
      </div>
    </div>
  </div>
  <hr>
</div>


<!-- Service wise pending cases -->
<div class="container table_div_responsive">
  <h2>Service Wise Pending Application(s)</h2>
  <p style="color:red">List of count of pending application(s) to users of a specific service</p>            
  <table class="table table-hover table-responsive table-bordered" style="width:100%">
    <thead>

      <tr style="background-color: #186d84;">
        <th rowspan='2' style="color: white; vertical-align: middle;">Service</th>
        <th class="td-align-title text-center" colspan="2">LM Geo Tag</th>
        <th rowspan='2' class="td-align-title">SK</th>
        <th rowspan='2' class="td-align-title">CO</th>
        <th rowspan='2' class="td-align-title">ADC</th>
        <th rowspan='2' class="td-align-title">SDO</th>
        <th rowspan='2' class="td-align-title">BO</th>
        <th rowspan='2' class="td-align-title">DC</th>
        <th rowspan='2' class="td-align-title">SRO</th>
        <th rowspan='2' class="td-align-title">DPT</th>
      </tr>
      <tr style="background-color: #186d84;">
        <th class="td-align-title">Done</th>
        <th class="td-align-title">Not Done</th>
      </tr>

    </thead>
    <tbody>
      <?php foreach ($overall_services as $serviceObj):
        // var_dump($serviceObj);
       ?>
        <tr>
          <td><?= $serviceObj["service_name"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["lm_geo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["lm_no_geo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["sk"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["co"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["adc"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["sdo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["bo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["dc"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["sro"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["dpt"]?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <hr>
</div>


<!-- District wise pending cases of a service -->
<div class="container table_div_responsive">
  <h2>District Wise Pending Application(s)</h2>
  <p style="color:red">List of count of District wise pending application(s) to users of a selected service</p>            
  <table class="table table-hover table-responsive table-bordered">
    <thead>
      <tr style="background-color: #186d84;">
        <th rowspan='2'style="color: white; vertical-align: middle; width: 30%;">
          <select class="form-select" id="services1" onchange="filterOverAllService()">
            <option value="">Select Service</option>
            <?php foreach ($services as $serviceObj): ?>
              <?php if ((int)$serviceObj["service_code"]>12) {?>
                <option value="<?= $serviceObj["service_code"]?>" 
                  <?= ((int)$serviceObj["service_code"] == 16)?'selected':'' ?>><?= $serviceObj["service_name"]?></option>
              <?php }?>
            <?php endforeach ?>
          </select>
        </th>
        <th style="color: white; vertical-align: middle;" rowspan='2'>District</th>
        <th class="td-align-title text-center" colspan="2">LM Geo Tag</th>
        <th rowspan='2' class="td-align-title">SK</th>
        <th rowspan='2' class="td-align-title">CO</th>
        <th rowspan='2' class="td-align-title">ADC</th>
        <th rowspan='2' class="td-align-title">SDO</th>
        <th rowspan='2' class="td-align-title">BO</th>
        <th rowspan='2' class="td-align-title">DC</th>
        <th rowspan='2' class="td-align-title">SRO</th>
      </tr>
      <tr style="background-color: #186d84;">
        <th class="td-align-title">Done</th>
        <th class="td-align-title">Not Done</th>
      </tr>

    </thead>
    <tbody id="appended_data">
      <?php foreach ($district_service_array as $key => $serviceObj): ?>
        <tr>
          <?php if ($key == 0): ?>
            <td rowspan="<?=count($district_service_array)?>" valign="middle"><span style="font-size: 30px; font-weight: bold;"><?= $serviceObj["service_name"]?></span></td>
          <?php endif ?>
          <td>
            <?php echo "<a style='color:blue; cursor:pointer' onClick='return loadDistrictDataByCode(\"".$serviceObj["district_code"]."\", \"".$serviceObj["service_code"]."\", \"".$serviceObj["district_name"]."\", \"".$serviceObj["service_name"]."\")'>".$serviceObj["district_name"]."</a>";?>
          </td>
          <td class="td-align"><?= $serviceObj["data"]["lm_geo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["lm_no_geo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["sk"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["co"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["adc"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["sdo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["bo"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["dc"]?></td>
          <td class="td-align"><?= $serviceObj["data"]["sro"]?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table><hr>
</div>


<!-- Circle wise pending cases of a service -->
<input type="text" id="circle_wise_input" value="" class="input_field">
<div class="container table_div_responsive overall_circle_table_div" style="display:none;">
  <h3>Circle Wise Pending Application(s)</h3>
  <p style="color:red">List of count of Circle wise pending application(s) to users for the service <b><span id="service_name_circle"></span></b></p>
  <table class="table table-hover table-responsive table-bordered" id="overall_circle_table">
    <thead>
      <tr style="background-color: #186d84;">
        <th rowspan='2' style="color: white; vertical-align: middle;">Circle</th>
        <th class="td-align-title text-center" colspan="2">LM Geo Tag</th>
        <th rowspan='2' class="td-align-title">SK</th>
        <th rowspan='2' class="td-align-title">CO</th>
        <th rowspan='2' class="td-align-title">ADC</th>
        <th rowspan='2' class="td-align-title">SDO</th>
        <th rowspan='2' class="td-align-title">BO</th>
        <th rowspan='2' class="td-align-title">DC</th>
        <th rowspan='2' class="td-align-title">SRO</th>
      </tr>
      <tr style="background-color: #186d84;">
        <th class="td-align-title">Done</th>
        <th class="td-align-title">Not Done</th>
      </tr>

    </thead>
    <tbody>
    </tbody>
  </table><hr>
</div>


<!-- Lot wise pending cases of a service -->
<input type="text" id="lot_wise_input" value="" class="input_field">
<div class="container table_div_responsive overall_lot_table_div" style="display:none;">
  <h3>Lot Wise Pending Application(s)</h3>
  <p style="color:red">List of count of Lot wise pending application(s) to users of Circle <b><span id="lot_name_circle"></span></b> for service <b><span id="service_name_lot"></span></b></p>
  <table class="table table-hover table-responsive table-bordered" id="overall_lot_table">

    <thead>

      <tr style="background-color: #186d84;">
        <th rowspan='2' style="color: white; vertical-align: middle;">Mouza</th>
        <th rowspan='2' style="color: white; vertical-align: middle;">Lot</th>
        <th class="td-align-title text-center" colspan="2">LM Geo Tag</th>
        <th rowspan='2' class="td-align-title">SK</th>
        <th rowspan='2' class="td-align-title">CO</th>
        <th rowspan='2' class="td-align-title">ADC</th>
        <th rowspan='2' class="td-align-title">SDO</th>
        <th rowspan='2' class="td-align-title">BO</th>
        <th rowspan='2' class="td-align-title">DC</th>
        <th rowspan='2' class="td-align-title">SRO</th>
      </tr>
      <tr style="background-color: #186d84;">
        <th class="td-align-title">Done</th>
        <th class="td-align-title">Not Done</th>
      </tr>

    </thead>

    <tbody>
    </tbody>
  </table><hr>
</div>


<!-- Village wise pending cases of a service -->
<input type="text" id="vill_wise_input" value="" class="input_field">
<div class="container table_div_responsive overall_village_table_div" style="display:none;">
  <h3>Village Wise Pending Application(s) </h3>
  <p style="color:red">List of count of Village wise pending application(s) to users of Lot <b><span id="village_name_lot"></span></b> for service <b><span id="service_name_village"></span></b></p>
  <table class="table table-hover table-responsive table-bordered" id="overall_village_table">
    
    <thead>

      <tr style="background-color: #186d84;">
        <th rowspan='2' style="color: white; vertical-align: middle;">Village</th>
        <th class="td-align-title text-center" colspan="2">LM Geo Tag</th>
        <th rowspan='2' class="td-align-title">SK</th>
        <th rowspan='2' class="td-align-title">CO</th>
        <th rowspan='2' class="td-align-title">ADC</th>
        <th rowspan='2' class="td-align-title">SDO</th>
        <th rowspan='2' class="td-align-title">BO</th>
        <th rowspan='2' class="td-align-title">DC</th>
        <th rowspan='2' class="td-align-title">SRO</th>
      </tr>
      <tr style="background-color: #186d84;">
        <th class="td-align-title">Done</th>
        <th class="td-align-title">Not Done</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table><hr>
</div>

<!-- Application Details -->
<input type="text" id="appl_input" value="" class="input_field">
<div class="container application_detail_div table_div_responsive" style="display:none">
  <hr>
  <h3>Application Details </h3>
  <p style="color:red">List of Application Details for District <b><span id="appl_district"></span></b>, Circle <b><span id="appl_cirlce"></span></b>, Lot <b><span id="appl_lot"></span></b>, Village <b><span id="appl_village"></span></b> for service <b><span id="appl_service_nm"></span></b></p>

  <table class="table table-hover table-responsive table-bordered" id="application_table11">
    <thead>
      <tr style="background-color: #186d84;">
        <th class="td-align-title">Sr No</th>
        <th class="td-align-title">Application No</th>
        <th class="td-align-title">Submission Date</th>
        <th class="td-align-title">Action</th>
      </tr>
    </thead>
    <tbody id="list_of_application_detail">
    </tbody>
  </table>
</div>

<div class="container no_application_detail_div" style="display:none">
  <div class="alert alert-warning" role="alert">
    <span style="color:red"> <span class="no_application_detail"></span> for selected District: <b><span id="appl_district1"></span></b>, Circle: <b><span id="appl_cirlce1"></span></b>, Lot: <b><span id="appl_lot1"></span></b>, Village: <b><span id="appl_village1"></span></b> of Service: <b><span id="appl_service_nm1"></span></b></span>    
  </div>
</div>

<?php include(APPPATH."views/SettlementView/include/rtpsApplicationDetail.php");?>

<script>

  apiurl=baseurl+'BasundharaApi/';

  // baseurl = "http://localhost/dharitreemb2/index.php/BasundharaApi/";

  $(document).ready(function(){
    $("#services").change(function(){
      var service = $(this).val();
      if (service == "") {
        console.log("Empty Selected");
      }
      console.log($(this).val());

      $('.application_detail_div').hide();
      $('.no_application_detail_div').hide();

    });
  })

  filterOverAllService = function(){
    var service = $("#services1").val();

    var url = apiurl+"getRtpsAjax";
    if (service == "") {
      alert("Atleast one service needs to be selected.");
      return;
    }
    url += "?service_code=" + service;
       
    $('.loader').addClass('trans');
    $('.loader').removeClass('hide');
    $('.loader').show();
    //alert(url);return;
    $.getJSON(url)
    .done(function(data){

      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();
      var tableData = generateTableData(data.data);
      // $("#overall_services_table tbody").empty();
      $("#overall_services_table tbody").html(tableData);
      $(".overall_circle_table_div").hide();//class . id #
      $(".overall_lot_table_div").hide();
      $(".overall_village_table_div").hide();

      $('.application_detail_div').hide();
      $('.no_application_detail_div').hide();
    })
    .fail(function(){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();
      alert("Oops! something went wrong.");
    });
  }

  // ********************* district table ********************* 

  generateTableData = function (jsonData) {

    var html =  "";

    jsonData = JSON.parse(jsonData).district_service_array;
    
    $(jsonData).each(function(index, serviceObj){

      html +="<tr>";

      if(index == 0){
        html +="<td rowspan='30' valign='middle'><span style='font-size: 30px; font-weight: bold;'>"+ serviceObj["service_name"] +"</span></td>";
      }      

      html +=`<td><a style='color:blue; cursor:pointer' onClick="return loadDistrictDataByCode('${serviceObj["district_code"]}', ${serviceObj["service_code"]}, '${serviceObj["district_name"]}', '${serviceObj["service_name"]}')">${serviceObj["district_name"]}</a></td>`;
      html +="<td class='td-align'>"+ serviceObj.data.lm_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.lm_no_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sk +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.co +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.adc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sdo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.bo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.dc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sro +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.citi +"</td>";
      html +="</tr>";
    });
    $('#appended_data').html(html);
  }


  // ********************* circle table ********************* 
  loadDistrictDataByCode = function (district_code, service_code, district_name, service_name) {
    var url = apiurl+"getRtpsCircleAjax";
    $('.loader').addClass('trans');
    $('.loader').removeClass('hide');
    $('.loader').show();

    $.getJSON(url, {"service_code" : service_code, "district_code" : district_code})
    .done(function(data){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();

      $('#circle_wise_input').focus();

      var tableData = generateCircleTableData(data.data);
      $("#overall_circle_table tbody").html(tableData);
      $("#district_name_circle").text(district_name);
      $("#service_name_circle").text(service_name);
      $(".overall_circle_table_div").show();
      $(".overall_lot_table_div").hide();
      $(".overall_village_table_div").hide();

      $('.application_detail_div').hide();
      $('.no_application_detail_div').hide();

    })
    .fail(function(){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();
      alert("Oops! something went wrong.");
    });
    return false;
  }
  generateCircleTableData = function (jsonData, service_name){
    //console.log(jsonData);
    var html =  "";
     jsonData = JSON.parse(jsonData).circle_service_array ;
    //console.log(jsonData);
    $(jsonData).each(function(index, serviceObj){
      html +="<tr>";
      
      html +=`<td><a style='color:blue; cursor:pointer' onClick="return loadLotDataByCode('${serviceObj["district_code"]}','${serviceObj["subdiv_code"]}', ${serviceObj["service_code"]},'${serviceObj["circle_code"]}', '${serviceObj["district_name"]}', '${serviceObj["service_name"]}','${serviceObj["circle_name"]}')">${serviceObj["circle_name"]}</a></td>`;
      html +="<td class='td-align'>"+ serviceObj.data.lm_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.lm_no_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sk +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.co +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.adc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sdo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.bo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.dc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sro +"</td>";
      html +="</tr>";
    });
    return html;
  }
     
  // ********************* lot table ********************* 
  loadLotDataByCode = function (district_code,subdiv_code, service_code, circle_code, district_name, service_name, circle_name) {
       
    var url = apiurl+"getRtpsLotData";
    $('.loader').addClass('trans');
    $('.loader').removeClass('hide');
    $('.loader').show();

    $.getJSON(url, {"district_code" : district_code, "subdiv_code" : subdiv_code, "service_code" : service_code,  "circle_code" : circle_code })
    .done(function(data){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();

      $('#lot_wise_input').focus();

      var tableData = generateLotTableData(data.data);
      $("#overall_lot_table tbody").html(tableData);
      $("#lot_name_circle").text(circle_name);
      $("#service_name_lot").text(service_name);
      $(".overall_lot_table_div").show();
      $(".overall_village_table_div").hide();

      $('.application_detail_div').hide();
      $('.no_application_detail_div').hide();
    })
    .fail(function(){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();
      alert("Oops! something went wrong.");
    });
    return false;
    }
  generateLotTableData = function (jsonData, service_name){
    var html =  "";
    jsonData = JSON.parse(jsonData).lat_service_array ;
    console.log(jsonData);
    $(jsonData).each(function(index, serviceObj){
      html +="<tr>";
      html +=`<td><a>${serviceObj["mouza_name"]}</a></td>`;
      html +=`<td><a style='color:blue; cursor:pointer' onClick="return loadVillageDataByCode('${serviceObj["district_code"]}', '${serviceObj["subdiv_code"]}', '${serviceObj["service_code"]}', '${serviceObj["circle_code"]}','${serviceObj["mouza_code"]}', '${serviceObj["lat_code"]}', '${serviceObj["district_name"]}', '${serviceObj["service_name"]}','${serviceObj["circle_name"]}','${serviceObj["lat_name"]}')">${serviceObj["lat_name"]}</a></td>`;
      html +="<td class='td-align'>"+ serviceObj.data.lm_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.lm_no_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sk +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.co +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.adc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sdo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.bo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.dc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sro +"</td>";
      html +="</tr>";
    });
    return html;
  }


  // ********************* village table ********************* 

  loadVillageDataByCode = function (district_code, subdiv_code, service_code, circle_code, mouza_code, lat_code, district_name, service_name, circle_name,lat_name) {
    var url = apiurl+"getRtpsVillageData";
    $('.loader').addClass('trans');
    $('.loader').removeClass('hide');
    $('.loader').show();

    $.getJSON(url, {"district_code" : district_code,"subdiv_code" : subdiv_code, "service_code" : service_code, "circle_code" : circle_code, "mouza_code" : mouza_code, "lat_code" : lat_code})
    .done(function(data){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();

      $('#vill_wise_input').focus();

      var tableData = generateVillageTableData(data.data);
      $("#overall_village_table tbody").html(tableData);
      $("#village_name_lot").text(lat_name);
      $("#service_name_village").text(service_name);
      $(".overall_village_table_div").show();

      $('.application_detail_div').hide();
      $('.no_application_detail_div').hide();
    })
    .fail(function(){
      $('.loader').addClass('hide');
      $('.loader').removeClass('trans');
      $('.loader').hide();
      alert("Oops! something went wrong.");
    });
    return false;
  }
  generateVillageTableData = function (jsonData, service_name){
    var html =  "";
    jsonData = JSON.parse(jsonData).village_service_array ;
    // console.log(jsonData);
    $(jsonData).each(function(index, serviceObj){

      d = serviceObj["district_code"];
      s = serviceObj["subdiv_code"];
      c = serviceObj["circle_code"];
      m = serviceObj["mouza_code"];
      l = serviceObj["lat_code"];
      v = serviceObj["village_code"];
      scode = serviceObj["service_code"];

      html +="<tr>";

      html +="<td><a style='color:blue; cursor:pointer' onclick=\"villageWiseDetail('"+d+"','"+s+"','"+c+"','"+m+"','"+l+"','"+v+"','"+scode+"')\">"+ serviceObj["village_name"] +"</a></td>";

      // html +=`<td><a>${serviceObj["village_name"]}</a></td>`;
      html +="<td class='td-align'>"+ serviceObj.data.lm_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.lm_no_geo+"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sk +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.co +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.adc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sdo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.bo +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.dc +"</td>";
      html +="<td class='td-align'>"+ serviceObj.data.sro +"</td>";
      html +="</tr>";
    });
    return html;
  }
    // ********************* end of village table ********************* 


  function loader() {
    $.blockUI({
      message: $('#displayBox'),
      css: {
        border:'none',
        backgroundColor:'transparent',
      }
    });
  }

  function villageWiseDetail(dist, sub, cir, mouza, lot, vill, scode) 
  {
    loader();
    $.ajax({
      url: apiurl+"getApplicationDetailsByVillageMbTwo",
      dataType: "JSON",
      data: {dist:dist, sub:sub, cir:cir, mouza:mouza, lot:lot, vill:vill, scode:scode},
      type: "POST",
      success: function(res) {

        $.unblockUI();
        $('#appl_input').focus();
        
        if(res.responseType == 2)
        {
          $('.application_detail_div').show();
          $('.no_application_detail_div').hide();

          $('#appl_district').html(res.location.dist_name);
          $('#appl_cirlce').html(res.location.cir_name);
          $('#appl_lot').html(res.location.lot_name);
          $('#appl_village').html(res.location.vill_name);
          $('#appl_service_nm').html(res.location.service_name);

          $('#list_of_application_detail').html('');
          $('#application_table11').DataTable().destroy();

          var application_detail = '';
          $.each(res.data, function (i, val) { // if data available
          application_detail +=
            '<tr>'+
              '<td align="center">' + (i+1) + '</td>' +
              '<td align="center">' + val["application_no"] + '</td>' +
              '<td align="center">' + val["date_submission"] + '</td>' +
              '<td align="center"><button class="btn btn-sm btn-warning" onclick="view_application_detail(' +"'"+ val["application_no"] +"'"+ ')" type="button">View Detail</button></td>' +
              // '<td align="center"><a href="" >View Detail</a></td>' +           
            '</tr>'
          });
          $('#list_of_application_detail').html(application_detail);
          $('#application_table11').DataTable();
        }

        if(res.responseType == 1) { // if no data available
          $('#appl_district1').html(res.location.dist_name);
          $('#appl_cirlce1').html(res.location.cir_name);
          $('#appl_lot1').html(res.location.lot_name);
          $('#appl_village1').html(res.location.vill_name);
          $('#appl_service_nm1').html(res.location.service_name);

          $('.application_detail_div').hide();
          $('.no_application_detail_div').show();          
          $('.no_application_detail').html(res.data);
          $('#application_table11').DataTable().destroy();
          $('#application_table11').DataTable();
        }

      }, 
      error: function(error) { // runtime error message
        $.unblockUI();
        $('#list_of_application_detail').html('');
        $('.application_detail_div').hide();
        showWarningMessage("Something went wrong. Kindly contact system adminstrator");
      },
    });      
  }


  function view_application_detail(appl_no){
    // $('#applicationModal').modal();
    $('#applicationModal').modal('show');

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
      url: apiurl+"getRtpsApplicationDetails",
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
            if(val["is_applicant"] == 1) {
               tenant_ap_area_details +=
                 '<tr>'+
                   '<td>' + val["dag_no"] + '</td>' +
                   '<td>' + actual_area + '</td>' +
                   '<td>' + applied_area + '</td>' +
                 '</tr>'
            }
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
<style type="text/css">

  .card-body {
    width: 200px;
    height: 200px;
    background-color: #e4e4e4;
    border-radius: 50%;
  }

  .num-card-title {
    font-style: normal;
    font-size: 32px;
    text-align: center;
    font-weight: bold;
  }

  /*.card-text:last-child {
    margin-bottom: 0;
    text-align: center;
    font-size: 20px;
  }*/

  .card-text {
    margin-top: 2px;
    text-align: center;
    font-size: 20px;
  }

  .td-align-title {
    text-align:right;
    color: white;
    vertical-align: middle;
    text-align: center;

  }
  .td-align {
    text-align:right;
  }

  .table_div_responsive {
    overflow-x: scroll;
  }

  .input_field{
    opacity:0;
  }

  .more_details {
    color: red;
    font-size:15px; 
    margin-left: 30px;
    cursor: pointer;
  }

</style>
