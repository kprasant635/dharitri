<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: landscape; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">    
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoArrearUpdateController/index'?>">ARREAR-UPDATE</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">DOUL</li>
  </ol>
</nav>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">

                    <div class="panel-heading text-center mt-1 bg-danger">
                        <h3 class="panel-title text-white">
                            DOUL IS NOT GENERATED..! PLEASE GENERATE DOUL..!
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>