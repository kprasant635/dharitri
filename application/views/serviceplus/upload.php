<script src="<?php echo base_url(); ?>application/views/resources/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dsc-signer.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dscapi-conf.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/views/resources/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/views/resources/css/dsc-signer.css"> 
<div id="boxes">
    <div id="dialog" class="window">
        
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    
                    <?php //var_dump($users); ?>
                    <hr>
                    <p class='uni_text red center'>Please Upload the saved ror to deliver it directly to the customer.</p>
                    <div class="col-lg-12 update ">
                        <div class="alert alert-info">
                            <form id="pdfForm">
					<label for="data">Choose Local File : </label><br /> <input
						type="file" name="pdfFile" id="pdfFile" accept="application/pdf" />
					<label for="pdfData">Pdf Data(Base64):</label> <br />
					<textarea
					placeholder="Choose pdf file above to show pdf data..."
					id="pdfData" cols="60" rows="8" readonly="readonly"></textarea>
					<br />Reason : <input type="text" id="signingReason"
						name="signingReason" maxlength="20" /> <br />Location : <input
						type="text" id="signingLocation" name="signingLocation"
						maxlength="20" /> <br /> stampingX : <input type="text"
						id="stampingX" name="stampingX" maxlength="20" value="400" /> <br />stampingY
					: <input type="text" id="stampingY" name="stampingY" maxlength="20"
						value="50" /> <br /> scale : <input type="text" id="scale"
						name="scale" maxlength="20" value="0.3f" /> <br /> Select TSA
					URL : <select name="tsaurls" id="tsaurls" onchange="myFunction()">
						<option value="0">--------------------------SELECT---------------------------------</option>
						<option
							value="http://sha256timestamp.ws.symantec.com/sha256/timestamp">
							http://sha256timestamp.ws.symantec.com/sha256/timestamp</option>
						<option value="http://timestamp.comodoca.com/rfc3161">http://timestamp.comodoca.com/rfc3161</option>
						<option value="http://tsa.startssl.com/rfc3161">http://tsa.startssl.com/rfc3161</option>
						<option value="http://timestamp.digicert.com">http://timestamp.digicert.com</option>
						<option value="http://tsa.safecreative.org">http://tsa.safecreative.org</option>
					</select> <br /> TSA URL (Optional) : <input type="text" id="tsaURL"
						name="tsaURL" value="" maxlength="100" style="width: 400px;" /> <br />Time
					Server URL (Optional) : <input type="text" id="timeServerURL"
						name="timeServerURL"
						value="http://localhost:8080/dscapi/getServerTime" maxlength="100"
						style="width: 400px;" /><br /> <span style="color: red;">If
						the time server URL is not provided, the client time will be used
						for signing.</span>
				</form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
  <div id="mask" style="display: fixed !important; background-color: black !important;"></div>
</div>
