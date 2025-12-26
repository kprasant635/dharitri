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
                    <form action="<?php echo base_url();?>index.php/EkhajanaCoController/updateCasesCo" method="POST">
                        <div class="col" style="text-align:center;background-color:grey">
                            <strong>UPDATE CASES</strong>
                        </div>
                        <label class="form-label text-center mt-4" style="color:red;text-align:center">ENTER RTPS APPLICATION NO</label>
                        <input type="text" id="" class="form-control" autocomplete="off" name="application_no" required>
                        <div class="row">
                            <div class="col-4 text-center"></div>
                            <div class="col-4 text-center">
                                <button type="submit" class="btn btn-success mt-2">Submit</button>
                            </div>
                            <div class="col-4 text-center"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>               
</div>
