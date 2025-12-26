<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Find Cases</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">                        
            <div class="panel-body">
                <div class="accordion-body">
                    <form action="<?php echo base_url();?>index.php/findCases/getApplicationDetails" method="POST">
                        <div class="col" style="text-align:center;background-color:grey">
                            <input type="radio" id="EKH" name="application_type" value="EKH">
                            <label>EKHAJANA</label>
                            <!-- <input type="radio" id="BASU1" name="application_type" value="BASU1" checked>
                            <label>BASUNDHARA-1 Services</label><br> -->
                        </div>
                        <label class="form-label mt-4" style="color:red">ENTER RTPS APPLICATION NO</label>
                        <input type="text" id="" class="form-control" autocomplete="off" name="application_no" required>
                        <div class="row">
                            <div class="col-4 text-center"></div>
                            <div class="col-4 text-center">
                                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                            </div>
                            <div class="col-4 text-center"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>               
</div>
