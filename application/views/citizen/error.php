<div class="container form-top">
    <div class="col-lg-12">
        <div class="col-lg-8 col-lg-offset-2 text-center">
	  <div class="logo"> <h1>OPPS, Error 400 !</h1></div>
             <div class="clearfix"></div>            
             <div class="col-lg-8  col-lg-offset-2">
             
                 </div>
            <div class="clearfix"></div>
            <br /><br />
          <p class="text-muted">There is some error here in data processing, Please check your entry data again and go for it. </p>
          <div class="clearfix"></div>
             <br /><br />
               
            <div class="clearfix"></div>
            <br />
            <div class="btn btn-primary" id="GoBack">Go Back To Home</div>    
            
        </div>
	      
    </div>
</div>
<script>
$('#GoBack').click(function(){
     location.href="<?php echo base_url(); ?>index.php/home";
})</script>
