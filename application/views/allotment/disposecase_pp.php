<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-10 col-lg-offset-2" >  
            <div class="well col-lg-10 well-sm"><h2 class="uni_text text-center">Registered / Order Passed / Disposed of AC to PP</h2>
				<p class='text-center uni_text'><?=$record['date']?></p>
			</div>
            <div class="col-lg-10">
                <div class="panel ">
                    <div class="panel-body">
                        <table class='table'>
							<tr class='center active'>
								<td></td>
								<td>Total No of Registration</td>
								<td>Delivered</td>
								<td>Reject/Disposed</td>
							</tr>
							<tr class='center'>
								<td></td>
								<td><?=$record['total']?></td>
								<td><?=$record['delivered']?></td>
								<td><?=$record['reject']?></td>
							</tr>
						</table>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/home' ?>";
    };
</script>

