<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/> -->
<link href="<?php echo base_url(); ?>application/views/css/datepickerNew.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/datepickerNew.js"></script>
<div class="text-warning bg-dark p-1 shadow-lg col-lg-12 mt-2 text-center" style="border:3px solid #96907e; border-radius:5px">
  <h5>Total Amount Received Till Date Through e-Khajana For 
      Circle: <u><?=$this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code)?></u>
      is Rs <?=$this->EkhajanaReportModel->getAmountReceivedForCircle($dist_code,$subdiv_code,$cir_code)?> 
  </h5>
</div>

<div class="col-md-6 offset-3 mt-5 shadow-lg" style="border:3px solid grey;padding:10px">
<h5 class="mt-5 text-center">Please select month</h5>
  <!-- <label for="date">Select A date:</label> -->
  <form id="daily_report" onsubmit="return generateReport(event);" action="<?php echo base_url();?>index.php/EkhajanaReportController/monthlyReport" method="POST">
    <div class="row">
        <div class="col-12 text-center">
            <input class="form-control mt-3 select_date" placeholder="Please Select Month" type="text" id="datepicker123" name="select_date_from" autocomplete="off">
        </div>
        <!-- <div class="col-6 text-center">
            <input class="form-control mt-3 select_date" placeholder="Please Select To Month" type="text" id="datepicker1234" name="select_date_to" autocomplete="off">
        </div> -->
    </div>
  <center><button type="submit" class="btn btn-success btn-sm mt-2 mb-4 text-center">Search Payment Details</button></center>
  </form>
</div>

<script>
    var today;
    today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    console.log(today)
    $("#datepicker123").datepicker( {
        maxDate: new Date(2024, 3, 22),
        minDate: '-0',
        format: "yyyy-mm",
        // format: "dd-mm-yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });
    $("#datepicker1234").datepicker( {
        maxDate: new Date(2024, 3, 22),
        minDate: '-0',
        format: "yyyy-mm",
        // format: "dd-mm-yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });
</script>
<script>
    const generateReport = () => 
            {
              var select_date = $('.select_date').val();
              console.log(select_date);
              var today = new Date();
              var inputDate = new Date(select_date);
              if(select_date == "" || select_date == null){
                  alert("Please Select A Year And Month");
                  return false;
              }else if(inputDate > today){
                alert("Future date is not allowed.");
                return false;
              }
              $("#daily_report").submit();
            }
</script>


