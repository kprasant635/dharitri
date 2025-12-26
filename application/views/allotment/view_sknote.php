<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info panel-form">
                <form class="form-horizontal  unicode" method="POST" >              
                <div class='panel-body'>
				<br>
                    <h2 class="text-center" style="top:20px;">SK Report</h2>
					<hr>
					<?php //var_dump($aloteesk);?>
					<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows=5 placeholder='Type here' name="lm_comment" required="" value="" ><?php echo $aloteesk->sk_comment; ?></textarea>
                                </div>			
                    </div>
                
                </form>
              </div>  
            </div>
         </div>
        
    </div>
    </div>    
</div>


<script>
    $('#BackHome').click(function(){
	location.href = "<?php echo base_url(); ?>index.php/home";
    });
    var dateToday = new Date(); 
    $(function() {
        $( "#ddmmyy" ).datepicker({
            numberOfMonths: 3,
            showButtonPanel: true,
            minDate: dateToday
        });
    });
    </script>