<style>
    .table_black tr td{
        color: #000;
        border: 1px solid #000 !important;
    }
    p{font-size: 1em !important;display: block;padding-bottom: 1em;
      margin-bottom: 10px;}
	table.center {
	  margin-left: auto; 
	  margin-right: auto;
	}

</style>

<div  id='printPage' class="container-fluid form-top">
    <div class="row">
							<table class="center">
								<tr>
									<td ><span class='center'>অসম চৰকাৰ</span></td>
								</tr>
								<tr>
									<td class='center'><span class='center'><center><img src="<?php echo base_url(); ?>application/views/images/goa.jpg" width='2%'></center></span></td>
								</tr>
								<tr>
									<td class='center'><span class='center'>GOVERNMENT OF ASSAM</span></td>
								</tr>
								<tr>
									<td class='center'><span class='center'>চক্র বিষয়াৰ কাৰ্য্যালয়  ::&nbsp;<?php echo $location['cirname']; ?>
                                ৰাজহ  চক্ৰ <span class="pull-right">মৌজা : <?php echo $location['mouza_pargona_code'] ?> </span></span></td>
								</tr>
								<tr>
									<td class='center'><span class='center'>আবেদন নং :<?php echo $certDtls->cert_no; ?> তাং :<?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($certDtls->apply_date))); ?></span></td>
								</tr>
								<tr>
									<td class='center'><span class='center'>RTPS আবেদন নং : <?php echo $location['application_ref_no'] ?> </span></td>
								</tr>
								<tr>
									<td class='center'><span class='center'> অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫  </span></td>
								</tr>
							</table>
                            
                            <div class="col-lg-12" >
                            <p class='center bold uni_text'><u>ORDER SHEET</u></p>
                            <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                            <br>
                    <table class="table table_black" border=1 style='border:black'>
                                    <tr >
                                        <td width='10%'>Serial No and Date of Order</td>
                                        <td width='60%'>Order and Signature of Officer</td>
                                        <td width='30%'>Note Of Action Taken on Order</td>
                                    </tr>
                                    <tr >
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($cases as $case):
                                        ?>
                                        <tr>
                                            <td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                            <td>
                                                <p style='display: block;padding-bottom: 1em;
												margin-bottom: 10px;'><?php echo strip_tags($case->co_order); ?> </p></td>
                                            <td>
                                                <p style='display: block;padding-bottom: 1em;
												margin-bottom: 10px;'><?php echo strip_tags($case->note_on_order); ?> </p>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </table>        
	</div>
</div>
</div>
<div class="dontshow">
    <div class="form-group" style="text-align: center">
        <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
            <a href="http://10.177.15.210/demo/index.php/serviceplus/AssttPrintPage?cert_no=<?=$this->session->userdata('case_no')?>&certtype=01" class="btn btn-success uni_text dontshow" onclick="myFunction()"><i class="fa fa-print"></i> Print this page</a>
            <button class="btn btn-danger" onclick="self.close()"><i class="fa fa-close"></i> Close this window</button>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>application/views/resources/js/jspdf.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/jquery-2.1.3.js"></script>

<script src="<?php echo base_url(); ?>application/views/js/jquery.base64.min.js"></script>
<script>

function myFunction() {
	$( ".dontshow" ).hide();
	window.print();
}

</script>