<div class="modal" role="dialog" id="premiumModal" style="padding-top: 25px!important;" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10">
                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                PREMIUM CALCULATION CULTIVATION
                                            </h5>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" align="right">
                                            <i class="fa fa-times-circle closePremium" aria-hidden="true" style="color: red; font-weight: bold; font-size: 28px"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body" align="">
                                        <?php  $areacount=1;
                                        foreach($dags as $dagsprem) { ?>


                                            <div class="tableCard " style="padding: 25px!important;">
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                                                    </div>
                                                    <div class="form-group col-md-6">

                                                        <input type="number" onkeyup="zonalValueChange<?=$dagsprem->dag_no?>()" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                                               class="zonal_valuation_prem form-control <?php if(form_error('zonal_valuation_prem'.$dagsprem->dag_no)) {
                                                                   echo 'lm_invalid';
                                                               }?>"
                                                               value="<?php if(isset($err_return)){ echo set_value('zonal_valuation_prem'.$dagsprem->dag_no);} else {echo $this->utilityclass->getZonalValue($dagsprem->dist_code,$basic['uuid'],$dagsprem->dag_no);} ?>" placeholder="Enter Amount"/>
                                                    </div>
                                                </div>


                                                <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label for="title">Check Premium</label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="radio" id="concession<?=$dagsprem->dag_no?>" name="concession<?=$dagsprem->dag_no?>" class="concession" value="YES">
                                                        <label for="html">YES</label>
                                                        <!-- <input type="radio" id="concession2" name="concession<?=$dagsprem->dag_no?>" class="concession<?=$dagsprem->dag_no?>" value="NO">
                                    <label for="css">NO</label><br> -->
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                        <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                        <input id="amount_<?=$dagsprem->dag_no?>" type="number"
                                                               class="totalamount form-control" value="" name="amount<?=$dagsprem->dag_no?>" readonly/>
                                                    </div>
                                                </div>
                                            </div>


                                            <script>
                                                //////// for premium

                                                function zonalValueChange<?=$dagsprem->dag_no?>(){
                                                    $('#amount_<?=$dagsprem->dag_no?>').val('');
                                                    $('#totaldue').val('');
                                                    $("#finalamount").val('');
                                                    $("#totaldue").val('');
                                                    $(".premhide").hide();
                                                    $("#finalsubmit").show();
                                                    $("#finalsave").hide();
                                                    $(".paymode").prop( "checked", false );

                                                }

                                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                $("input[name=concession<?=$dagsprem->dag_no?>]").on("click", function () {

                                                    var appbigha_total=parseFloat($("#total_applied_agri_bigha").val());
                                                    var appkatha_total=parseFloat($("#total_applied_agri_katha").val());
                                                    var applessa_total=parseFloat($("#total_applied_agri_lessa").val());
                                                    var appganda_total=parseFloat($("#total_applied_agri_ganda").val());
                                                    let total_app_ganda_org = parseFloat((appbigha_total * 6400) + (appkatha_total * 320) + (applessa_total * 20) + appganda_total);

                                                    var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                                    var selectedValue = $("input[name=concession<?=$dagsprem->dag_no?>]:checked").val();
                                                    var agribigha=parseFloat($("#agri_b<?=$dagsprem->dag_no?>").val());
                                                    var agrikatha=parseFloat($("#agri_k<?=$dagsprem->dag_no?>").val());
                                                    var agrilessa=parseFloat($("#agri_lc<?=$dagsprem->dag_no?>").val());
                                                    var agriganda=parseFloat($("#agri_g<?=$dagsprem->dag_no?>").val());

                                                    var appbigha=agribigha;
                                                    var appkatha=agrikatha;
                                                    var applessa=parseFloat(agrilessa);
                                                    var appganda=parseFloat(agriganda);
                                                    var total_ganda = parseFloat((appbigha * 6400) + (appkatha * 320) + (applessa * 20) + appganda);


                                                    var total_road_reserved = 0;
                                                    var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val()
                                                    if (road_reserved_yn == "YES") {
                                                        var road_bigha=parseFloat($("#reserved_bigha<?=$dagsprem->dag_no?>").val());
                                                        var road_katha=parseFloat($("#reserved_katha<?=$dagsprem->dag_no?>").val());
                                                        var road_lessa=parseFloat($("#reserved_lessa<?=$dagsprem->dag_no?>").val());
                                                        var road_ganda=parseFloat($("#reserved_ganda<?=$dagsprem->dag_no?>").val());
                                                        if(road_bigha == null || road_bigha=='' || road_bigha=='undefined'){road_bigha=0;}
                                                        if(road_katha == null || road_katha=='' || road_katha=='undefined'){road_katha=0;}
                                                        if(road_lessa == null || road_lessa=='' || road_lessa=='undefined'){road_lessa=0;}
                                                        if(road_ganda == null || road_ganda=='' || road_ganda=='undefined'){road_ganda=0;}
                                                        total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                                                    }else if(road_reserved_yn == "NO"){
                                                        total_road_reserved = 0;
                                                    }
                                                    var total_s_area = parseFloat(total_ganda - total_road_reserved);
                                                    var total_culti_area= parseFloat(total_app_ganda_org - total_road_reserved);
                                                    var rate_type = $("#amount_type<?=$dagsprem->dag_no?>").val();

                                                    if (selectedValue == "YES") {
                                                        $("#finalamount").val('');
                                                        $("#totaldue").val('');
                                                        $(".premhide").hide();
                                                        $("#finalsubmit").show();
                                                        $("#finalsave").hide();
                                                        $(".paymode").prop( "checked", false );

                                                        var cult_board = $('#cult_board').val();
                                                        if(cult_board == 'TEA') {
                                                            if(total_culti_area>192000){
                                                                var percentage =30;
                                                                var zonal_ganda = zonal / 6400;
                                                                var premium = total_s_area * zonal_ganda;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var per_ganda_rate = 1000/6400;
                                                                var final_amount = (total_s_area * per_ganda_rate);
                                                                var amount= Math.ceil(final_amount);

                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            // if(total_culti_area>192000){
                                                            //     var percentage =100;
                                                            //     var zonal_ganda = zonal / 6400;
                                                            //     var premium = total_s_area * zonal_ganda;
                                                            //     var amount = Math.ceil(premium * percentage / 100);

                                                            // }else{

                                                                var per_ganda_rate = 5000/6400;
                                                                var final_amount = (total_s_area * per_ganda_rate);
                                                                var amount= Math.ceil(final_amount);

                                                            // }
                                                        }

                                                        $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                                        $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                                        $('#validationcheck').val(1);

                                                        // alert(<?=$dagsprem->dag_no?>);

                                                    }


                                                });
                                                <?php else : ?>

                                                $("input[name=concession<?=$dagsprem->dag_no?>]").on("click", function () {

                                                    var appbigha_total=parseFloat($("#total_applied_agri_bigha").val());
                                                    var appkatha_total=parseFloat($("#total_applied_agri_katha").val());
                                                    var applessa_total=parseFloat($("#total_applied_agri_lessa").val());

                                                    var total_app_lessa_org = parseFloat((appbigha_total * 100) + (appkatha_total * 20) + applessa_total);

                                                    var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                                    var selectedValue = $("input[name=concession<?=$dagsprem->dag_no?>]:checked").val();

                                                    var agribigha=parseFloat($("#agri_b<?=$dagsprem->dag_no?>").val());
                                                    var agrikatha=parseFloat($("#agri_k<?=$dagsprem->dag_no?>").val());
                                                    var agrilessa=parseFloat($("#agri_lc<?=$dagsprem->dag_no?>").val());

                                                    var appbigha=agribigha;
                                                    var appkatha=agrikatha;
                                                    var applessa=parseFloat(agrilessa);

                                                    var total_lessa = parseFloat((appbigha * 100) + (appkatha * 20) + applessa);

                                                    var total_road_reserved = 0;
                                                    var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val()
                                                    if (road_reserved_yn == "YES") {
                                                        var road_bigha=parseFloat($("#reserved_bigha<?=$dagsprem->dag_no?>").val());
                                                        var road_katha=parseFloat($("#reserved_katha<?=$dagsprem->dag_no?>").val());
                                                        var road_lessa=parseFloat($("#reserved_lessa<?=$dagsprem->dag_no?>").val());
                                                        if(road_bigha == null || road_bigha=='' || road_bigha=='undefined'){road_bigha=0;}
                                                        if(road_katha == null || road_katha=='' || road_katha=='undefined'){road_katha=0;}
                                                        if(road_lessa == null || road_lessa=='' || road_lessa=='undefined'){road_lessa=0;}
                                                        total_road_reserved = parseFloat((road_bigha * 100) + (road_katha * 20) + road_lessa);
                                                    }else if(road_reserved_yn == "NO"){
                                                        total_road_reserved = 0;
                                                    }

                                                    var total_s_area = parseFloat(total_lessa - total_road_reserved);
                                                    var total_culti_area= parseFloat(total_app_lessa_org - total_road_reserved);


                                                    if (selectedValue == "YES") {
                                                        $("#finalamount").val('');
                                                        $("#totaldue").val('');
                                                        $(".premhide").hide();
                                                        $("#finalsubmit").show();
                                                        $("#finalsave").hide();
                                                        $(".paymode").prop( "checked", false );

                                                        var cult_board = $('#cult_board').val();

                                                        if(cult_board == 'TEA'){
                                                            if(total_culti_area>3000){
                                                                var percentage =30;
                                                                var zonal_lessa = zonal / 100;
                                                                var premium = total_s_area * zonal_lessa;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var per_lessa_rate = 1000/100;
                                                                var final_amount = (total_s_area * per_lessa_rate);
                                                                var amount= Math.ceil(final_amount);

                                                            }
                                                        } 
                                                        else 
                                                        { 
                                                            if(total_culti_area>3000){
                                                                var percentage =100;
                                                                var zonal_lessa = zonal / 100;
                                                                var premium = total_s_area * zonal_lessa;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var per_lessa_rate = 5000/100;
                                                                var final_amount = (total_s_area * per_lessa_rate);
                                                                var amount= Math.ceil(final_amount);

                                                                // alert(total_s_area);

                                                            }
                                                        }

                                                        $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                                        $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                                        $('#validationcheck').val(1);

                                                        // alert(<?=$dagsprem->dag_no?>);

                                                    }

                                                });
                                                <?php endif ;?>


                                                //////// premium end
                                            </script>
                                            <?php $areacount++;
                                        } ?>

                                        <div class="row"  align="center">
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-4">
                                    <span id="finalsubmit" class="rezaButt buttPrimary" style="margin-top: 20px">
                                        <i class="fa fa-check-square-o"> </i>  Submit
                                    </span>
                                            </div>
                                            <div class="col-lg-4"></div>
                                        </div>

                                        <br>
                                        <div class="tableCard premhide" style="padding: 25px!important; display:none">
                                            <div class="row premhide" style="display:none">
                                                <div class="form-group col-md-6  text-primary">
                                                    <label for="title">Final Amount</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" name="finalamount" id="finalamount" readonly>
                                                </div>

                                            </div>

                                            <div class="row premhide" style="display:none">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Payment Mode</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="radio" id="paymode1" name="paymode" class="paymode" value="YES">
                                                    <label for="html">Full Payment</label>
                                                    <!-- <input type="radio" id="paymode2" name="paymode" class="paymode" value="NO">
                                                    <label for="css">30% Down Payment</label> -->
                                                    <br>
                                                </div>

                                            </div>

                                            <div class="row premhide" style="display:none">
                                                <div class="form-group col-md-6 text-danger">
                                                    <label for="title">Total Due</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" value="" name="totaldue" id="totaldue" class="totaldue" readonly>
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="modal-footer prembutton">
                                        <div class="form-group text-right">
                            <span id="closePremium" class="rezaButt buttDanger closePremium" style="display:none">
                                <i class="fa fa-times" aria-hidden="true"></i>  Close
                            </span>

                                            <span id="finalsave" class="rezaButt buttPrimary" style="display:none">
                                <i class="fa fa-check-square-o"> </i>  Submit
                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


<script>
    $(document).on('change', '#cult_board', function(){
        reset();

        var board = $('#cult_board').val();
        
        if(board == 'TEA')
        {
            $('#messageDiv').html('<span><b>&nbsp; <br>(@Rs 1000/ per Bigha up to 30 bighas of land, If above 30 bighas then 30% of the Zonal valuation up till 75 bigha)</b></span>');
        }
        else
        {
          $('#messageDiv').html('<span><b>&nbsp; <br>(@Rs 5000/ per Bigha up to 30 bighas of land, If above 30 bighas then 100% of the Zonal valuation up till 75 bigha)</b></span>');
        }
    })

    $(document).ready( function (){
        var board = $('#cult_board').val();
        
        if(board == 'TEA')
        {
            $('#messageDiv').html('<span><b>&nbsp; <br>(@Rs 1000/ per Bigha up to 30 bighas of land, If above 30 bighas then 30% of the Zonal valuation up till 75 bigha)</b></span>');
        }
        else
        {
          $('#messageDiv').html('<span><b>&nbsp; <br>(@Rs 5000/ per Bigha up to 30 bighas of land, If above 30 bighas then 100% of the Zonal valuation up till 75 bigha)</b></span>');
        }
    })
</script>