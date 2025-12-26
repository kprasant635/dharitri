<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info panel-form">
                <form class="form-horizontal  unicode" method="POST" >              
                <div class='panel-body'>
				<h2 class="center">ORDER SHEET</h2>
					<p class="center">See Rule of 129 Records Manual 1911</p>
					<div style="margin-top: 10px">
					<p class="center">Order Sheet,  Dated From <?php echo date('d-m-Y', strtotime($pb->date_entry)); ?> to 
					<?php 
						echo date('d-m-Y', strtotime($pb->next_date_of_hearing));
				; ?> 
				</p>
					<p class="center">Case No : <?php echo $pb->case_no; ?></p>
					</div>
					
						<form>
						<div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
							<table class="table table-bordered" style="font-size: 16px;">
								<tr style="color:#0000cc; text-align: center;">
									<td>Serial No and Date of Order</td>
									<td width="40%">Order and Signature of Officer</td>
									<td width="40%">Note Of Action Taken on Order</td>
								</tr>
								<tr style="color:#0000cc; text-align: center;">
									<td>১</td>
									<td>২</td>
									<td>৩</td>
								</tr>
								<?php
								$i = 1;
								foreach ($pd as $case):
									?>
									<tr>
										<td><?php echo "(" . $i . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
										<td><?php echo $case->co_order; ?></td>
										<td><?php echo $case->note_on_order; ?></td>
									</tr>
									<?php
									$i++;
								endforeach;
								?>
							</table>
						</div>
						
					</form>
						   
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