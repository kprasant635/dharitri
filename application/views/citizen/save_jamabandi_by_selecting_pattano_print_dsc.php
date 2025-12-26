<style>
    .table_black tr td{
        color: #000;
        border: 1px solid #000 !important;
    }
    p{font-size: 1em !important;display: block;padding-bottom: 1em;
      margin-bottom: 10px;}

</style>

<div  id='printPage' class="container-fluid form-top">
    <div class="row">
        <div align="center" style="display:inline-block; width: 100%;" class="col-lg-12">
            <p align ="center">জৰীপ হোৱা গাঁওৰ জমাবন্দী (Jamabandi for Surveyed Village)</p>
            <p>Case Number : <?php echo $application_ref_no; ?>   Printed Dated : <?php echo date('d/m/Y'); ?> </p>
            <input type="hidden" name="application_ref_no" id="application_ref_no" value="<?=$application_ref_no?>">
            <table class="table table_black" border='1' style='color:black' align="center" width="100%;" style="margin-bottom: 10px; padding: 2px" >
                <tr>
                    <td align="center"><?php echo "District :" . $namedata[0]->district; ?></td> 
                    <td align="center"><?php echo "Subdivision :" . $namedata[1]->subdiv; ?></td> 
                    <td align="center"><?php echo "Circle :" . $namedata[2]->circle; ?></td> 
                    <td align="center"><?php echo "Mouza :" . $namedata[3]->mouza; ?></td> 
                </tr>
                <tr>
                    <td align="center"><?php echo "Lot Number:" . $namedata[4]->lot_no; ?></td> 
                    <td align="center"><?php echo "Village/Town :" . $namedata[5]->village; ?></td> 
                    <td align="center"><?php echo"Pattatype:" . $namedata[6]->patta_type; ?></td> 
                </tr>
            </table>
            <table class="table table_black" border='1' style='color:black' width="100%" >

                <tr>
                    <td align="center" colspan="2" height="24">  পট্টা নং </td>
                    <td align= "center" width=80 rowspan="2" height="78"> পট্টাদাৰৰ  নাম,পিতাৰ নাম/স্ৱামীৰ নাম আৰু ঠিকনা  </td>
                    <td align="center" colspan="4" height="34">  &nbsp;&nbsp;প্ৰত্যেক দাগৰ মাটিৰ &nbsp;  </td>
                    <td align="center" rowspan="2" height="73">  ৰাজহ<br> </td>
                    <td align="center" rowspan="2" height="73">  স্হানীয় কৰ<br> </td>
                    <td align="center" rowspan="2" height="100">  মন্তব্য </td>

                </tr>
                <tr>
                    <td align="center" height="48"> পুৰণি </td>
                    <td align="center" height="48"> নতুন </td>

                    <td align="center" height="48"> নং</td>
                    <td align="center" height="48"> কালি<br>(বি-ক-লে) </td>
                    <td align="center" height="48"> শ্রেণী </td>
                    <td align="center" height="48"> কালি<br>(হে-আৰ-ছে) </td>

                </tr>
                <tr>
                    <td align="middle" height="24"> 1 </td>
                    <td  align="center" height="24"> 2 </td>
                    <td align="center" height="24"> 3</td>
                    <td align="center" height="24"> 4 </td>
                    <td  align="center" height="24"> 5 </td>
                    <td  align="center" height="24"> 6 </td>
                    <td  align="center" height="24"> 7 </td>
                    <td  align="center"  height="24"> 8 </td>
                    <td  align="center"  height="24"> 9 </td>
                    <td align="center"  height="24"> 10 </td>
                </tr>
                <?php
                $GrandlocaltaxTotal = '';
                $GrandrevenueTotal = '';
                $Grandbigha_total = '';
                $Grandkatha_total = '';
                $Grandlesa_total = '';
                //  $details="";
                $GrandtotalHAC1 = "";
                ?>
                <?php
                //var_dump($details);



                $localtaxTotal = '';
                $revenueTotal = '';
                $bigha_total = '';
                $katha_total = '';
                $lesa_total = '';
                $bigha_totall = '';
                $katha_totall = '';
                $lesa_totall = '';
                ?>
                <tr>
                    <td><?php foreach ($oldpno as $p): ?> 
                            <p><?php echo $p->old_patta_no; ?> </p>
                        <?php endforeach; ?></td>
                    <td><?php
                        $pp = $this->session->userdata('patta_no');
                        echo $this->utilityclass->cassnum($pp);
                        ?></td>
                    <td>
                        <?php
                        if (!empty($pattadarinf)) {
                            $i = 1;
                            foreach ($pattadarinf as $p):
                                //var_dump($p);
                                $pdarflag = $p->p_flag;
                                $newpdar_name = $p->new_pdar_name;
                                ?>
                                <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php
                                    if ((($p->pdar_land_b) != '0') || (($p->pdar_land_k) != '0') || (($p->pdar_land_lc) != '0')) {
                                        $bkl = "(" . $p->pdar_land_b . "B-" . $p->pdar_land_k . "K-" . round($p->pdar_land_lc, 2) . "L) ";
                                    } else {
                                        $bkl = "";
                                    }
                                    if ($pdarflag == '1') {
                                        $pattadarName = '<span style="Color:#ff0000;text-decoration: line-through;">' . $p->pdar_name . '</span>';
                                    } elseif (($pdarflag == '1') and ( $newpdar_name == "N")) {
                                        $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                                    } elseif (($pdarflag == null) and ( $newpdar_name == "N")) {
                                        $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                                    } elseif ($newpdar_name == "N") {
                                        $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                                    } elseif ($newpdar_name != "N") {
                                        $pattadarName = '<span style="Color:black;">' . $p->pdar_name . '</span>';
                                    }

                                    $pdar_serial_no = $p->pdar_sl_no . ") ";

                                    if (($p->pdar_sl_no == '0') || ($p->pdar_sl_no == '') || ($p->pdar_sl_no == null)) {
                                        $pdar_serial_no = $p->pdar_id . ") ";
                                    }

                                    if (($p->pdar_add1 != '') || ($p->pdar_add2 != '') || ($p->pdar_add3 != '') || ($p->pdar_add1 != '0') || ($p->pdar_add2 != '0') || ($p->pdar_add3 != '0')) {
                                        if ($sort_pdar_by == '1') {
                                            // 1 means sort by serial no
                                            echo $pdar_serial_no . '' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "," . $p->pdar_add3 . "<br>" . $bkl;
                                        } else {
                                            echo $i++ . ') ' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "," . $p->pdar_add3 . "<br>" . $bkl;
                                        }
                                    } else {
                                        if ($sort_pdar_by == '1') {
                                            // 1 means sort by serial no
                                            echo $pdar_serial_no . '' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                                        } else {
                                            echo $i++ . ') ' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                                        }
                                    }
                                    ?></p>
                                <?php
                            endforeach;
                        }
                        ?>

                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnumfordags($p->dag_no); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td>  
                        <?php foreach ($daginfo as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnum($p->dag_area_b) . "-" . $this->utilityclass->cassnum($p->dag_area_k) . "-" . $this->utilityclass->cassnum($p->dag_area_lc, 2); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $p->land_type; ?> </p>
                        <?php endforeach; ?>


                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <?php
                            $bigha_total = (int)$bigha_total + (int)$p->dag_area_b;
                            $katha_total = (int)$katha_total + (int)$p->dag_area_k;
                            $lesa_total = (float)$lesa_total + (float)$p->dag_area_lc;


                            $bigha_totall = (int)$bigha_totall + (int)$p->dag_area_b;
                            $katha_totall = (int)$katha_totall + (int)$p->dag_area_k;
                            $lesa_totall = (float)$lesa_totall + (float)$p->dag_area_lc;
                            if ($lesa_total > 20) {
                                $lesa = ($lesa_total / 20);

                                //$whole = floor($hectar);      // 1
                                //$fraction1 = $hectar - $whole; // .25
                                $lesa_whole = floor($lesa);
                                $lesa_fraction = $lesa - $lesa_whole;
                                $lesa_fraction = $lesa_fraction * 20;
                                $katha_total = $katha_total + $lesa_whole;

                                // $grand_katha=$katha_total+$to_be_added_to_katha;
                            } else {
                                $lesa_fraction = $lesa_total;
                            }
                            if ($katha_total > 4) {
                                $katha = ($katha_total / 5);
                                $katha_whole = floor($katha);
                                $katha_fraction = $katha - $katha_whole;
                                $katha_fraction = $katha_fraction * 5;
                                $bigha_total = $bigha_total + $katha_whole;
                                //$to_be_added_to_bigha=($grand_katha/5);
                                //$grand_bigha=$bigha_total+$to_be_added_to_bigha;
                            } else {
                                $katha_fraction = $katha_total;
                            }

                            $GrandtotalHAC = $this->utilityclass->get_Hec_Are_CAre($bigha_total, $katha_fraction, $lesa_fraction);
                            ?>
                            <?php
                            $H_A_C = $this->utilityclass->get_Hec_Are_CAre($p->dag_area_b, $p->dag_area_k, $p->dag_area_lc);
                            echo $this->utilityclass->cassnum($H_A_C) . '<br>';
                            ?>
                        <?php endforeach; ?>



                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <?php $revenueTotal = (float)$revenueTotal + (float)$p->dag_revenue; ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnum(number_format($p->dag_revenue, 2)); ?> </p>
                        <?php endforeach; ?>

                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <?php $localtaxTotal = (float)$localtaxTotal + (float)$p->dag_localtax; ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnum(number_format($p->dag_localtax, 2)); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td style='margin-bottom:10px;'>
                        <?php foreach ($remarkinf as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo strip_tags($p->remark); ?> </p>

                        <?php endforeach; ?>
                    </td>

                </tr>                    <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>
                        <?php
                        $total_lessa = $this->utilityclass->Total_Lessa($bigha_totall, $katha_totall, $lesa_totall);
                        $tbkl = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        echo $this->utilityclass->cassnum($tbkl[0]) . "-" . $this->utilityclass->cassnum($tbkl[1]) . "-" . $this->utilityclass->cassnum($tbkl[2]);

                        //echo $this->utilityclass->cassnum(number_format($bigha_total)) . '-' . $this->utilityclass->cassnum(number_format($katha_fraction)) . '-' . $this->utilityclass->cassnum(number_format($lesa_fraction,2));
                        $Grandbigha_total = (int)$Grandbigha_total + (int)$bigha_total;
                        $Grandkatha_total = (int)$Grandkatha_total + (int)$katha_fraction;
                        $Grandlesa_total = (float)$Grandlesa_total + (float)$lesa_fraction;

                        if ($Grandlesa_total > 20) {
                            $lesa = ($Grandlesa_total / 20);

                            //$whole = floor($hectar);      // 1
                            //$fraction1 = $hectar - $whole; // .25
                            $lesa_whole = floor($lesa);
                            $lesa_fraction = $lesa - $lesa_whole;
                            $lesa_fraction = $lesa_fraction * 20;
                            $Grandkatha_total = $Grandkatha_total + $lesa_whole;

                            // $grand_katha=$katha_total+$to_be_added_to_katha;
                        } else {
                            $lesa_fraction = $Grandlesa_total;
                        }
                        if ($Grandkatha_total > 4) {
                            $katha = ($Grandkatha_total / 5);
                            $katha_whole = floor($katha);
                            $katha_fraction = $katha - $katha_whole;
                            $katha_fraction = $katha_fraction * 5;
                            $Grandbigha_total = $Grandbigha_total + $katha_whole;
                            //$to_be_added_to_bigha=($grand_katha/5);
                            //$grand_bigha=$bigha_total+$to_be_added_to_bigha;
                        } else {
                            $katha_fraction = $Grandkatha_total;
                        }

                        $GrandtotalHAC1 = $this->utilityclass->get_Hec_Are_CAre($bigha_totall, $katha_totall, $lesa_totall);
                        ?>



                    </td>
                    <td>

                    </td>
                    <td>
                        <?php echo $this->utilityclass->cassnum($GrandtotalHAC1) ?>
                    </td>
                    <td>
                        <?php
                        echo $this->utilityclass->cassnum($revenueTotal);
                        $GrandrevenueTotal = (float)$GrandrevenueTotal + (float)$revenueTotal;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->utilityclass->cassnum($localtaxTotal);
                        $GrandlocaltaxTotal = (float)$GrandlocaltaxTotal + (float)$localtaxTotal;
                        ?>
                    </td>
                    <td>

                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div class="col-lg-9 col-md-10 col-sm-12">
        <p class='red uni_text center'>** Please note this is a system generated certificate and does not need any signature **</p>
        <div class="row">
            <?php
            $data = explode(",", $qrcode)[1];
            echo '<img class="col-lg-2" src="data:image/png;base64,' . $data . '" />';
            ?>
            <?php
            $data = explode(",", $qrBasic)[1];
            echo '<img class="col-lg-2" src="data:image/png;base64,' . $data . '" />';
            ?><?php
            $data = explode(",", $qrCONAME)[1];
            echo '<img class="col-lg-2" src="data:image/png;base64,' . $data . '" />';
            ?>
            <p class="uni_text pull-right"> কতৃত্বপ্রাপ্ত বিষয়া   :  <?php echo $username->username; ?> <br>
                Designation :   চক্ৰ বিষয়া<br>
                Generated Date :  <?php echo date('d/m/Y'); ?>
            </p>

        </div>

    </div>
    <div class="col-lg-3 col-sm-12">

    </div>


</div>


<div class='' >
    <div class="form-group" style="text-align: center">
        <div class="col-sm-10" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">                     
            <br>
           <?php
           
            if(!empty($application_ref_no)){?>

            <button class='btn btn-success' id="print"><i class='fa fa-file'></i> Click to Generate Jamabandi for Digital Signature</button>

           <?php }?>
           <input id="signPdf" type="button" value="Apply digital signature" class="btn btn-warning" style="display:none"> 
           <input id="submitPdf" type="Submit" value="fffffffffffffffffff" style="display: none;"> 

              
        </div>
    </div>
</div>

 <form action="<?php echo base_url(); ?>index.php/serviceplus/mpdf" id="pdf_certificate" enctype='multipart/form-data'  style="display:none" method="post">                    
        <textarea id="htmlstring_text" name="htmlstring_text"></textarea>
</form>

<!-- ///////////////////DIGITAL SIGN START HERE////////////////// -->
<div class="row">
    <div class="col-sm-4">
        <div class="well-sm">
            <form id="pdfForm">
               
                <textarea id="pdfData" cols="60" rows="8" readonly="readonly"  style="display:none;" ></textarea>
                <input type="text" id="signingReason"name="signingReason" maxlength="20"  style="display:none;"  />
                <input type="text" id="signingLocation" name="signingLocation" maxlength="20"  style="display:none;"  />
                <input type="text" id="stampingX" name="stampingX" maxlength="20" value="200"  style="display:none;"  />
                <input type="text" id="stampingY" name="stampingY" maxlength="20" value="200"  style="display:none;"  />
                <select name="tsaurls" id="tsaurls" onchange="myFunction()"  style="display:none;" >
                    <option value="0">--------------------------SELECT---------------------------------</option>
                    <option
                        value="http://sha256timestamp.ws.symantec.com/sha256/timestamp">
                        http://sha256timestamp.ws.symantec.com/sha256/timestamp</option>
                    <option value="http://timestamp.comodoca.com/rfc3161">http://timestamp.comodoca.com/rfc3161</option>
                    <option value="http://tsa.startssl.com/rfc3161">http://tsa.startssl.com/rfc3161</option>
                    <option value="http://timestamp.digicert.com">http://timestamp.digicert.com</option>
                    <option value="http://tsa.safecreative.org">http://tsa.safecreative.org</option>
                </select>
                <input type="text" id="tsaURL"  name="tsaURL" value="" maxlength="100" style="width: 400px;display: none;" />
                <input type="text" id="timeServerURL"
                    name="timeServerURL"
                    value="https://basundhara.assam.gov.in/dscapi/getServerTime"
                    maxlength="100" style="width: 400px;display: none;" /><br /> <span
                    style="color: red;"></span>

                          
                    <a id="downloadDiv"  style="display:none;"   href='#' type="application/pdf" download="SignedPdf.pdf"></a> 
                    <input id="verifyPdfBtn"  style="display:none;"  type="button" value=" Verify Pdf " class="btn btn-danger">
            </form>
        </div>
    </div>
    <div class="col-sm-4"  style="display:none;" >
        <div class="well-sm">
            <textarea id="signedPdfData" cols="60" rows="8" style="display:none;" ></textarea>
            <textarea id="sdfsdPdfData" cols="60" rows="8"></textarea>
            <textarea id="lblEncryptedKey" cols="60" rows="4" disabled  style="display:none;" ></textarea>
            <textarea id="verificationResponse" cols="60" rows="8" disabled  style="display:none;" ></textarea>
        </div>
    </div>
</div>
<div id="panel"></div>

<script src="<?php echo base_url(); ?>application/views/resources/js/jspdf.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/jquery-2.1.3.js"></script>

<script src="<?php echo base_url(); ?>application/views/js/jquery.base64.min.js"></script>
<script>
$( "#print" ).click(function(e) {
    e.preventDefault();
    
    var htmlString = $( "#printPage" ).html();
    var encodedHtmlString = b64EncodeUnicode(htmlString);

   //console.log("Base URL:", baseurl);  // Debugging baseurl
    $('#signPdf').hide();
    $.ajax({
        type: 'POST', 
        url: baseurl + 'citizencontroller/dscbaseencode', 
        contentType: 'application/json',  // Explicitly set JSON
        data: JSON.stringify({ post: encodedHtmlString }), 
        dataType: 'json', 
        beforeSend: function(){
            $("#loading").html("Validating ...Please wait...");
            $('.alert').hide();
            $('.disable_forward').hide();
        },
        success: function(data){
            $("#loading").hide();
            if(data.success)
            {
               $('#pdfData').val(data.data); 
               $('#signPdf').show();
               $('#print').hide();
            } 
            else if(data.error) 
            {
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                $('.disable_forward').show();
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            console.log(xhr.responseText);  // Log server response
        }
    });   
});
         
function b64EncodeUnicode(str) {    
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}
</script>

<script type="text/javascript">
        function myFunction() {
            var x = document.getElementById("tsaurls").value;
            if (x != 0) {
                document.getElementById("tsaURL").value = x;
            } else {
                document.getElementById("tsaURL").value = "";
            }
        }
        $(document).ready(
                function() {

                    $('#verifyPdfBtn').hide();

                    var initConfig = {
                        "preSignCallback" : function() {
                            // do something 
                            // based on the return sign will be invoked
                            return true;
                        },
                        "postSignCallback" : function(alias, sign, key) {
                            $('#signedPdfData').val(sign);
                            $('#lblEncryptedKey').val(key);
                            // Implement signed pdf upload and pdf Download here
                            var requestData = {
                                action : "DECRYPT",
                                en_sig : sign,
                                ek : key
                            };
                            $.ajax(
                                    {
                                        url : dscapibaseurl+ "/pdfsignature",
                                        type : "post",
                                        dataType : "json",
                                        contentType : 'application/json',
                                        data : JSON.stringify(requestData),
                                        async : false
                                    })
                                    .done(
                                    function(data) {
                                        if (data.status_cd == 1) {
                                            //get data.data -> decode base64 -> get json->check status == SUCCESS
                                            //get data.data.sig -> add pdf header and append to link
                                            var jsonData = JSON.parse(atob(data.data));
                                            console.log(jsonData);
                                            if (jsonData.status === "SUCCESS") {
                                                // $('#verifyPdfBtn').show();
                                                
                                                //Set Class to download link
                                                $('#downloadDiv').addClass('btn btn-info');
                                                var dlnk = document.getElementById('downloadDiv');
                                                //get pdf data
                                                var pdfData = jsonData.sig;
                                                $('#sdfsdPdfData').val(pdfData);
                                                //alert(pdfData);
                                                //var dlnk = document.getElementById('downloadDiv');
                                                //dlnk.href = 'data:application/pdf;base64,'+ pdfData;
                                                //$("#downloadDiv").text("Download Signed PDF File");
                                                application_ref_no = $('#application_ref_no').val();
                                                savePushSignFiletoRtps(application_ref_no,pdfData);

                                            }

                                        } else {
                                            if (data.error.error_cd == 1002) {
                                                alert(data.error.message);
                                                return false;
                                            } else {
                                                alert("Decryption Failed for Signed PDF File");
                                                return false;
                                            }

                                        }
                                    }).fail(
                                    function(jqXHR, textStatus,
                                            errorThrown) {
                                        alert(textStatus);
                                    });
                        },
                        signType : 'pdf',
                        mode : 'nostampingv2'
                    //"certificateSno" : 13705892,
                    };
                    dscSigner.configure(initConfig);

                    $('#signPdf').click(function() {
                        var data = $("#pdfData").val();

                        if (data != null || data != '') {
                            dscSigner.sign(data);
                        }
                    });

                    $('#verifyPdfBtn').click(function() {
                                var signedPdfData = $('#signedPdfData').val();
                                var key = $('#lblEncryptedKey').val();

                                // Implement Verify here
                                var requestData = {
                                    action : "VERIFY",
                                    en_sig : signedPdfData,
                                    ek : key
                                };
                                $.ajax(
                                        {
                                            url : dscapibaseurl+ "/pdfsignature",
                                            type : "post",
                                            dataType : "json",
                                            contentType : 'application/json',
                                            data : JSON.stringify(requestData),
                                            async : false
                                        })
                                        .done(
                                                function(data) {
                                                    if (data.status_cd == 1) {$(
                                                        '#verificationResponse').val(atob(data.data));
                                                    } else {
                                                        alert("Verification Failed");
                                                    }

                                                })
                                        .fail(
                                                function(
                                                        jqXHR,
                                                        textStatus,
                                                        errorThrown) {
                                                    alert(textStatus);
                                                });
                            });

                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                var data = e.target.result;
                                var base64 = data
                                        .replace(/^[^,]*,/, '');
                                $("#pdfData").val(base64);
                            }

                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $("#pdfFile").change(function() {
                        readURL(this);
                    });

                });

function savePushSignFiletoRtps(pdfData,application_ref_no)
{
    var requestData = {
        pdfData : pdfData,
        application_ref_no : application_ref_no,
    };

    $.ajax({
        url: baseurl + "citizencontroller/savePushSignFiletoRtps",
        type : "post",
        dataType : "json",
        contentType : 'application/json',
        data : JSON.stringify(requestData),
        // async : false,
        success:function(response) {
            console.log(response);
            if(response)
            {
                alert("Save and push successfully...");
                window.location.href = baseurl + "index.php/home/CitizenCo";

            }
            else
            {
                alert('Save and push to RTPS Failed...kindly contact administrator!!!');
                location.reload();
            }
        },
        error: function (error) {
        $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
            location.reload();
        }
    }); 
}
    </script>

