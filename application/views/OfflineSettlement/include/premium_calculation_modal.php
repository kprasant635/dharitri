<div class="modal" role="dialog" id="premiumModal" style="padding-top: 25px!important;" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        PREMIUM CALCULATION
                    </h5>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" align="right">
                    <i class="fa fa-times-circle closePremium" aria-hidden="true" style="color: red; font-weight: bold; font-size: 28px"></i>
                </div>
            </div>
            <div class="modal-body" align="">
                <?php  $areacount=1;  foreach($dags as $dagsprem){ ?>


                    <div class="tableCard " style="padding: 25px!important;">
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                            </div>
                            <div class="form-group col-md-6">

                                <input type="number" readonly onkeyup="zonalValueChange<?=$dagsprem->dag_no?>()" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                       class="zonal_valuation_prem form-control <?php if(form_error('zonal_valuation_prem')){echo 'lm_invalid';}?>"
                                       value="<?php if(isset($err_return)){ echo set_value('zonal_valuation_prem'.$dagsprem->dag_no);} else {echo $this->utilityclass->getZonalValue($dagsprem->dist_code,$basic->uuid,$dagsprem->dag_no);} ?>" placeholder="Enter Amount"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label>Selected Area Type</label>

                            </div>
                            <div class="form-group col-md-6">
                                <select readonly class="form-control"  name='area<?=$dagsprem->dag_no?>' id='area<?=$dagsprem->dag_no?>' >
                                    <option value="">First select Area type in Area details section...</option>


                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label for="title">Select Purpose of Land:</label>

                            </div>
                            <div class="form-group col-md-6 ">
                                <select name="land_type<?=$dagsprem->dag_no?>" id="landtypes<?=$dagsprem->dag_no?>" class="form-control" >
                                    <option value="">First Select Area Type in Area Details </option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label for="title">Select Premium for Encroached land:</label>

                            </div>
                            <div class="form-group col-md-6 ">
                                <select name="rate_type<?=$dagsprem->dag_no?>" id="ratetypes<?=$dagsprem->dag_no?>" class="form-control">
                                    <option value="">Select Premium </option>
                                </select>

                            </div>
                        </div>
                        <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label for="title">Is ST/SC/Widows/Person with disabilities?</label>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="radio" id="concession1" name="concession<?=$dagsprem->dag_no?>" class="concession<?=$dagsprem->dag_no?>" value="YES">
                                <label for="html">YES</label>
                                <input type="radio" id="concession2" name="concession<?=$dagsprem->dag_no?>" class="concession<?=$dagsprem->dag_no?>" value="NO">
                                <label for="css">NO</label><br>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                            </div>
                            <div class="form-group col-md-6">
                                <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?> dag_total_lessa" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                <input id="amount_<?=$dagsprem->dag_no?>" type="number"
                                       class="totalamount form-control" value="" name="amount<?=$dagsprem->dag_no?>" readonly />
                            </div>
                        </div>
                    </div>


                    <script>

                        $(document).ready(function(){
                            // ajax for getting land list starts here
                            var area_id = $("#area_new<?=$dagsprem->dag_no?>").val();
                            var area_category = $("#area_cat_new<?=$dagsprem->dag_no?>").val();
                            var land_area_name_new =
                                "<option value='" +
                                area_id +
                                "'>" +
                                area_category +
                                "</option>";
                            $("#area<?=$dagsprem->dag_no?>").html(land_area_name_new);
                            // alert(area_id);
                            $.ajax({


                                url: baseurl + "SettlementPremium/getLand/" + area_id,
                                success: function(data) {
                                    // loading.out();
                                    var landtype = JSON.parse(data);
                                    var template =
                                        "<option selected value='' disabled>-- Select Purpose of Land --</option>";
                                    for (var i = 0; i < landtype.length; i++) {
                                        template +=
                                            "<option value='" +
                                            landtype[i].plid +
                                            "'>" +
                                            landtype[i].land_type +
                                            "</option>";
                                    }
                                    //console.log(template);
                                    $("#landtypes<?=$dagsprem->dag_no?>").html(template);
                                    // $("#display_area_type<?=$dagsprem->dag_no?>").html(areaType);
                                    clear();

                                },
                                error: function(error) {
                                    // loading.out();
                                }
                            });

                            // clear();
                        });
                        //////// for premium
                        function zonalValueChange<?=$dagsprem->dag_no?>(){
                            $("#area<?=$dagsprem->dag_no?>").val('');
                            $("#landtypes<?=$dagsprem->dag_no?>").val('');
                            $("#rate_type<?=$dagsprem->dag_no?>").val('');
                            $("#ratetypes<?=$dagsprem->dag_no?>").val('');
                            $('#amount_<?=$dagsprem->dag_no?>').val('');
                            $('#rate<?=$dagsprem->dag_no?>').val('');
                            $(".premhide").hide();
                            $("#finalsubmit").show();
                            $("#finalsave").hide();
                            $('#totaldue').val('');
                            $('#finalamount').val('');
                            $(".concession<?=$dagsprem->dag_no?>").prop( "checked", false );
                            $(".paymode").prop( "checked", false );
                            $("#lmfinalamount").text('');
                            $("#lmdueamount").text('');

                        }
                        function clear(){
                            $("#rate_type<?=$dagsprem->dag_no?>").val('');
                            $("#ratetypes<?=$dagsprem->dag_no?>").val('');
                            $('#amount_<?=$dagsprem->dag_no?>').val('');
                            $('#rate<?=$dagsprem->dag_no?>').val('');
                            $(".premhide").hide();
                            $("#finalsubmit").show();
                            $("#finalsave").hide();
                            $('#totaldue').val('');
                            $('#finalamount').val('');
                            $(".concession<?=$dagsprem->dag_no?>").prop( "checked", false );
                            $(".paymode").prop( "checked", false );
                            $("#lmfinalamount").text('');
                            $("#lmdueamount").text('');

                        }

                        // new premium addition
                        $( "select[name='area_cat<?=$dagsprem->dag_no?>']" ).change(function () {
                            var areaID = $(this).val();
                            var land_under = '';

                            // ajax for getting land list starts here
                            $.ajax({
                                url: baseurl + "SettlementPremium/getLandCat/" + areaID,
                                success: function(data) {
                                    // loading.out();
                                    var landtype = JSON.parse(data);
                                    land_under =
                                        "<option selected value='' disabled>-- Select Land Under --</option>";
                                    for (var i = 0; i < landtype.length; i++) {
                                        land_under +=
                                            "<option value='" +
                                            landtype[i].scid +
                                            "'>" +
                                            landtype[i].sub_category +
                                            "</option>";
                                    }
                                    // console.log(land_under);
                                    $("#area_subcat<?=$dagsprem->dag_no?>").html(land_under);
                                    clear();

                                },
                                error: function(error) {
                                    // loading.out();
                                }
                            });
                            // ajax for getting land list ends here
                        });

                        $( "select[name='area_subcat<?=$dagsprem->dag_no?>']" ).change(function () {
                            var subAreaID = $(this).val();
                            var land_area_name ='';

                            // ajax for getting land list starts here
                            $.ajax({
                                url: baseurl + "SettlementPremium/getLandSubCat/" + subAreaID,
                                success: function(data) {
                                    // loading.out();
                                    var sub_cat_data = JSON.parse(data);

                                    land_area_name =
                                        "<option value='" +
                                        sub_cat_data.area_id +
                                        "'>" +
                                        sub_cat_data.area +
                                        "</option>";

                                    //console.log(land_area_name);
                                    $("#area<?=$dagsprem->dag_no?>").html(land_area_name);


                                    // ajax for getting land list starts here
                                    $.ajax({

                                        url: baseurl + "SettlementPremium/getLand/" + sub_cat_data.area_id,
                                        success: function(data) {
                                            // loading.out();
                                            var landtype = JSON.parse(data);
                                            var template =
                                                "<option selected value='' disabled>-- Select Purpose of Land --</option>";
                                            for (var i = 0; i < landtype.length; i++) {
                                                template +=
                                                    "<option value='" +
                                                    landtype[i].plid +
                                                    "'>" +
                                                    landtype[i].land_type +
                                                    "</option>";
                                            }
                                            //console.log(template);
                                            $("#landtypes<?=$dagsprem->dag_no?>").html(template);
                                            // $("#display_area_type<?=$dagsprem->dag_no?>").html(areaType);
                                            clear();

                                        },
                                        error: function(error) {
                                            // loading.out();
                                        },
                                    });

                                    clear();

                                },
                                error: function(error) {
                                    // loading.out();
                                }
                            });
                            // ajax for getting land list ends here
                        });

                        // new premium addition end

                        /// this function not in use after new premium addition
                        $( "select[name='area<?=$dagsprem->dag_no?>']" ).change(function () {
                            var areaID = $(this).val();
                            var areaType = $("#area<?=$dagsprem->dag_no?> option:selected").text();

                            // ajax for getting land list starts here
                            $.ajax({
                                url: baseurl + "SettlementPremium/getLand/" + areaID,
                                success: function(data) {
                                    // loading.out();
                                    var landtype = JSON.parse(data);
                                    var template =
                                        "<option selected value='' disabled>-- Select Purpose of Land --</option>";
                                    for (var i = 0; i < landtype.length; i++) {
                                        template +=
                                            "<option value='" +
                                            landtype[i].plid +
                                            "'>" +
                                            landtype[i].land_type +
                                            "</option>";
                                    }
                                    //console.log(template);
                                    $("#landtypes<?=$dagsprem->dag_no?>").html(template);
                                    $("#display_area_type<?=$dagsprem->dag_no?>").html(areaType);
                                    clear();

                                },
                                error: function(error) {
                                    // loading.out();
                                }
                            });
                            // ajax for getting land list ends here
                        });

                        /// this function not in use after new premium addition end

                        $( "select[name='land_type<?=$dagsprem->dag_no?>']" ).change(function () {
                            var landID = $(this).val();
                            // alert(landID); return;

                            // ajax for getting land list starts here
                            $.ajax({
                                url: baseurl + "SettlementPremium/getType/" + landID,
                                success: function(data) {
                                    // loading.out();
                                    var landrate = JSON.parse(data);
                                    var template =
                                        "<option selected value='' disabled>-- Select Premium Type --</option>";
                                    for (var i = 0; i < landrate.length; i++) {
                                        template +=
                                            "<option value='" +
                                            landrate[i].prid +
                                            "'>" +
                                            landrate[i].house_type +
                                            "</option>";
                                    }
                                    //console.log(template);
                                    $("#ratetypes<?=$dagsprem->dag_no?>").html(template);
                                    clear();
                                },
                                error: function(error) {
                                    // loading.out();
                                }
                            });
                            // ajax for getting land list ends here
                        });

                        $( "select[name='rate_type<?=$dagsprem->dag_no?>']" ).change(function () {
                            var typeID = $(this).val();
                            // alert(typeID); return;

                            // ajax for getting land list starts here
                            $.ajax({
                                url: baseurl + "SettlementPremium/getRate/" + typeID,
                                success: function(data) {
                                    // loading.out();
                                    var landpercentage = JSON.parse(data);
                                    for (var i = 0; i < landpercentage.length; i++) {
                                        if(landpercentage[i].rate_type=='P'){var ratetype='%'} else if (landpercentage[i].rate_type=='R'){var ratetype='Rs -@100/bigha'}
                                        var template =
                                            "<div class='form-group col-md-6'><label> Rate ('"+ratetype+"')</label></div>";
                                        template +=
                                            "<div class='form-group col-md-6'><input type='text' readonly id='rate<?=$dagsprem->dag_no?>' class='form-control' name='rate<?=$dagsprem->dag_no?>' value='" +
                                            landpercentage[i].rate +
                                            "'><input type='hidden' readonly id='amount_type<?=$dagsprem->dag_no?>' class='form-group' name='amount_type<?=$dagsprem->dag_no?>' value='" +
                                            landpercentage[i].rate_type +
                                            "'><input type='hidden' readonly id='mb_land<?=$dagsprem->dag_no?>' class='form-group' name='mb_land<?=$dagsprem->dag_no?>' value='" +
                                            landpercentage[i].mb_land +
                                            "'><input type='hidden' readonly id='max_land<?=$dagsprem->dag_no?>' class='form-group' name='max_land<?=$dagsprem->dag_no?>' value='" +
                                            landpercentage[i].max_land +
                                            "'><input type='hidden' readonly id='approval<?=$dagsprem->dag_no?>' class='form-group' name='approval<?=$dagsprem->dag_no?>' value='" +
                                            landpercentage[i].approval +
                                            "'></div>";
                                    }
                                    //console.log(template);
                                    $("#percentage<?=$dagsprem->dag_no?>").html(template);
                                    $('#amount_<?=$dagsprem->dag_no?>').val('');
                                    $('#totaldue').val('');
                                    $('#finalamount').val('');
                                    $(".premhide").hide();
                                    $("#finalsubmit").show();
                                    $("#finalsave").hide();
                                    $(".concession<?=$dagsprem->dag_no?>").prop( "checked", false );
                                    $(".paymode").prop( "checked", false );
                                    $("#lmfinalamount").text('');
                                    $("#lmdueamount").text('');
                                },
                                error: function(error) {
                                    // loading.out();
                                }
                            });
                            // ajax for getting land list ends here
                        });

                        <?php if((in_array($dist_code, json_decode(BARAK_VALLEY)))): ?>
                        $("input[name=concession<?=$dagsprem->dag_no?>]").on("click", function () {

                            var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                            var selectedValue = $("input[name=concession<?=$dagsprem->dag_no?>]:checked").val();
                            var agribigha=parseFloat($("#agri_b<?=$dagsprem->dag_no?>").val());
                            var agrikatha=parseFloat($("#agri_k<?=$dagsprem->dag_no?>").val());
                            var agrilessa=parseFloat($("#agri_lc<?=$dagsprem->dag_no?>").val());
                            var agriganda=parseFloat($("#agri_g<?=$dagsprem->dag_no?>").val());

                            var mbigha=parseFloat($("#home_b<?=$dagsprem->dag_no?>").val());
                            var mkatha=parseFloat($("#home_k<?=$dagsprem->dag_no?>").val());
                            var mlessa=parseFloat($("#home_lc<?=$dagsprem->dag_no?>").val());
                            var mganda=parseFloat($("#home_g<?=$dagsprem->dag_no?>").val());

                            var appbigha=agribigha+mbigha;
                            var appkatha=agrikatha+mkatha;
                            var applessa=parseFloat(agrilessa+mlessa);
                            var appganda=parseFloat(agriganda+mganda);
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

                            var total_family_reserved = 0;
                            var family_reserved_yn = $("input[name=family_comment_check]:checked").val();
                            if (family_reserved_yn == "YES") {
                                var family_bigha=parseFloat($("#reserved_bigha_family<?=$dagsprem->dag_no?>").val());
                                var family_katha=parseFloat($("#reserved_katha_family<?=$dagsprem->dag_no?>").val());
                                var family_lessa=parseFloat($("#reserved_lessa_family<?=$dagsprem->dag_no?>").val());
                                var family_ganda=parseFloat($("#reserved_ganda_family<?=$dagsprem->dag_no?>").val());
                                if(family_bigha == null || family_bigha=='' || family_bigha=='undefined'){family_bigha=0;}
                                if(family_katha == null || family_katha=='' || family_katha=='undefined'){family_katha=0;}
                                if(family_lessa == null || family_lessa=='' || family_lessa=='undefined'){family_lessa=0;}
                                if(family_ganda == null || family_ganda=='' || family_ganda=='undefined'){family_ganda=0;}
                                total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                            }else if(family_reserved_yn == "NO"){
                                total_family_reserved = 0;
                            }

                            var total_s_area = parseFloat(total_ganda - total_road_reserved - total_family_reserved);
                            var rate_type = $("#amount_type<?=$dagsprem->dag_no?>").val();
                            var mb_land = 0;
                            mb_land = $("#mb_land<?=$dagsprem->dag_no?>").val();
                            if(mb_land==25){
                                mb_land =1600;
                            } else if(mb_land==30){
                                mb_land =1920;
                            }else if(mb_land==40){
                                mb_land =2560;
                            }

                            if (selectedValue == "YES") {
                                $("#finalamount").val('');
                                $("#totaldue").val('');
                                $(".premhide").hide();
                                $("#finalsubmit").show();
                                $("#finalsave").hide();
                                $(".paymode").prop( "checked", false );
                                $("#lmfinalamount").text('');
                                $("#lmdueamount").text('');

                                var rate = parseFloat($("#rate<?=$dagsprem->dag_no?>").val());
                                var getPrice = 25;
                                if(rate_type=='P'){

                                    if(total_s_area>mb_land){
                                        var premium = mb_land * zonal / 6400;
                                        var discount = rate-(rate * getPrice / 100);
                                        var amount1 = Math.ceil(premium * discount / 100);

                                        var access_area = total_s_area - mb_land;
                                        var premium2 = (access_area * (zonal*1.5)) / 6400;
                                        var amount2 = Math.ceil(premium2 * discount / 100);

                                        var amount = Math.ceil(amount1 + amount2);

                                        $(".downpay").show();
                                    }else{
                                        var premium = total_s_area * zonal / 6400;
                                        var discount = rate-(rate * getPrice / 100);
                                        // var amount = (premium * discount / 100).toFixed(2);
                                        var amount = Math.ceil(premium * discount / 100);
                                        $(".downpay").show();
                                    }

                                }else if(rate_type=='R'){
                                    var premium = total_s_area * rate / 6400;
                                    var discount = rate - getPrice;
                                    // var amount = (premium * discount / 100).toFixed(2);
                                    var amount = Math.ceil(premium * discount / 100);
                                    $(".downpay").hide();
                                }

                                $('#finalper<?=$dagsprem->dag_no?>').val(discount);
                                $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                $('#validationcheck').val(1);

                                // alert(<?=$dagsprem->dag_no?>);

                            }else {
                                if (selectedValue == "NO") {
                                    // alert(selectedValue);
                                    $("#finalamount").val('');
                                    $("#totaldue").val('');
                                    $(".premhide").hide();
                                    $("#finalsubmit").show();
                                    $("#finalsave").hide();
                                    $(".paymode").prop( "checked", false );
                                    $("#lmfinalamount").text('');
                                    $("#lmdueamount").text('');
                                    var rate = parseFloat($("#rate<?=$dagsprem->dag_no?>").val());
                                    if(rate_type =='P'){
                                        if(total_s_area>mb_land){

                                            var premium = mb_land * zonal / 6400;
                                            var amount1 = Math.ceil(premium * rate / 100);

                                            var access_area = total_s_area - mb_land;
                                            var premium2 = (access_area * (zonal * 1.5)) / 6400;
                                            var amount2 = Math.ceil(premium2 * rate / 100);

                                            var amount = Math.ceil(amount1 + amount2);

                                            $(".downpay").show();
                                        }else{
                                            var premium = total_s_area * zonal / 6400;
                                            // var amount = (premium * rate / 100).toFixed(2);
                                            var amount = Math.ceil(premium * rate / 100);
                                            $(".downpay").show();
                                        }
                                    }else if(rate_type =='R'){
                                        var premium = total_s_area * rate / 6400;
                                        // var amount = (premium * rate / 100).toFixed(2);
                                        var amount = Math.ceil(premium * rate / 100);
                                        $(".downpay").hide();
                                    }

                                    $('#finalper<?=$dagsprem->dag_no?>').val(rate);
                                    $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                    $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                    $('#validationcheck').val(1);
                                }
                            }


                        });
                        <?php else : ?>

                        $("input[name=concession<?=$dagsprem->dag_no?>]").on("click", function () {
                            var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                            var selectedValue = $("input[name=concession<?=$dagsprem->dag_no?>]:checked").val();

                            var agribigha=parseFloat($("#agri_b<?=$dagsprem->dag_no?>").val());
                            var agrikatha=parseFloat($("#agri_k<?=$dagsprem->dag_no?>").val());
                            var agrilessa=parseFloat($("#agri_lc<?=$dagsprem->dag_no?>").val());

                            var mbigha=parseFloat($("#home_b<?=$dagsprem->dag_no?>").val());
                            var mkatha=parseFloat($("#home_k<?=$dagsprem->dag_no?>").val());
                            var mlessa=parseFloat($("#home_lc<?=$dagsprem->dag_no?>").val());


                            var appbigha=agribigha+mbigha;
                            var appkatha=agrikatha+mkatha;
                            var applessa=parseFloat(agrilessa+mlessa);

                            var total_lessa = parseFloat((appbigha * 100) + (appkatha * 20) + applessa);

                            var total_road_reserved = 0;
                            var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val();
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

                            var total_family_reserved = 0;
                            var family_reserved_yn = $("input[name=family_comment_check]:checked").val();
                            if (family_reserved_yn == "YES") {
                                var family_bigha=parseFloat($("#reserved_bigha_family<?=$dagsprem->dag_no?>").val());
                                var family_katha=parseFloat($("#reserved_katha_family<?=$dagsprem->dag_no?>").val());
                                var family_lessa=parseFloat($("#reserved_lessa_family<?=$dagsprem->dag_no?>").val());
                                if(family_bigha == null || family_bigha=='' || family_bigha=='undefined'){family_bigha=0;}
                                if(family_katha == null || family_katha=='' || family_katha=='undefined'){family_katha=0;}
                                if(family_lessa == null || family_lessa=='' || family_lessa=='undefined'){family_lessa=0;}
                                total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                            }else if(family_reserved_yn == "NO"){
                                total_family_reserved = 0;
                            }

                            var total_s_area = 0;
                            var mb_land = 0;
                            total_s_area = parseFloat(total_lessa - total_road_reserved - total_family_reserved);

                            var rate_type = $("#amount_type<?=$dagsprem->dag_no?>").val();
                            mb_land = $("#mb_land<?=$dagsprem->dag_no?>").val();

                            if (selectedValue == "YES") {
                                $("#finalamount").val('');
                                $("#totaldue").val('');
                                $(".premhide").hide();
                                $("#finalsubmit").show();
                                $("#finalsave").hide();
                                $(".paymode").prop( "checked", false );
                                $("#lmfinalamount").text('');
                                $("#lmdueamount").text('');


                                var rate = parseFloat($("#rate<?=$dagsprem->dag_no?>").val());
                                var getPrice = 25;
                                if(rate_type=='P'){
                                    if(total_s_area>mb_land){
                                        var premium = mb_land * zonal / 100;
                                        var discount = rate-(rate * getPrice / 100);
                                        var amount1 = Math.ceil(premium * discount / 100);

                                        var access_area = total_s_area - mb_land;
                                        var premium2 = (access_area * (zonal*1.5)) / 100;
                                        var amount2 = Math.ceil(premium2 * discount / 100);

                                        var amount = Math.ceil(amount1 + amount2);



                                        $(".downpay").show();
                                    }else{
                                        var premium = total_s_area * zonal / 100;
                                        var discount = rate-(rate * getPrice / 100);
                                        // var amount = zonal+(zonal * discount / 100);
                                        // var amount = (premium * discount / 100).toFixed(2);
                                        var amount = Math.ceil(premium * discount / 100);
                                        $(".downpay").show();
                                    }
                                }else if(rate_type=='R'){
                                    var premium = total_s_area * rate / 100;
                                    var discount = rate - getPrice;
                                    // var amount = (premium * discount / 100).toFixed(2);
                                    var amount = Math.ceil(premium * discount / 100);
                                    $(".downpay").hide();
                                }

                                $('#finalper<?=$dagsprem->dag_no?>').val(discount);
                                $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                $('#validationcheck').val(1);

                                // alert(<?=$dagsprem->dag_no?>);

                            }
                            else {
                                if (selectedValue == "NO") {
                                    // alert(selectedValue);
                                    $("#finalamount").val('');
                                    $("#totaldue").val('');
                                    $(".premhide").hide();
                                    $("#finalsubmit").show();
                                    $("#finalsave").hide();
                                    $(".paymode").prop( "checked", false );
                                    $("#lmfinalamount").text('');
                                    $("#lmdueamount").text('');
                                    var rate = parseFloat($("#rate<?=$dagsprem->dag_no?>").val());
                                    if(rate_type =='P'){

                                        if(total_s_area>mb_land){
                                            var premium = mb_land * zonal / 100;
                                            var amount1 = Math.ceil(premium * rate / 100);

                                            var access_area = total_s_area - mb_land;
                                            var premium2 = (access_area * (zonal * 1.5)) / 100;
                                            var amount2 = Math.ceil(premium2 * rate / 100);

                                            var amount = Math.ceil(amount1 + amount2);


                                            $(".downpay").show();
                                        }else{
                                            var premium = total_s_area * zonal / 100;
                                            // var amount = (premium * rate / 100).toFixed(2);
                                            var amount = Math.ceil(premium * rate / 100);
                                            $(".downpay").show();
                                        }
                                    }else if(rate_type =='R'){
                                        var premium = total_s_area * rate / 100;
                                        // var amount = (premium * rate / 100).toFixed(2);
                                        var amount = Math.ceil(premium * rate / 100);
                                        $(".downpay").hide();
                                    }

                                    $('#finalper<?=$dagsprem->dag_no?>').val(rate);
                                    $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                    $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                    $('#validationcheck').val(1);
                                }
                            }

                        });
                        <?php endif ;?>


                        //////// premium end
                    </script>
                    <?php $areacount++; } ?>
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

                    <div class="row premhide hide" style="display:none">
                        <div class="form-group col-md-6 ">
                            <label for="title">Payment Mode</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="radio" id="paymode1" name="paymode" class="paymode" value="YES" checked>
                            <label for="html">Full Payment</label>
                            <input type="radio" id="paymode2" name="paymode" class="paymode downpay" value="NO">
                            <label for="css" class="downpay">30% Down Payment</label><br>
                        </div>

                    </div>

                    <div class="row premhide" style="display:none">
                        <div class="form-group col-md-6 text-danger">
                            <label for="title">Total Due</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control " name="totaldue" id="totaldue" readonly>
                        </div>

                    </div>
                </div>


            </div>

            <div class="modal-footer prembutton">
                <div class="form-group text-right">
                    <!-- <span id="closePremium" class="rezaButt buttDanger closePremium" style="display:none">
                        <i class="fa fa-times" aria-hidden="true"></i>  Close
                    </span> -->

                    <span id="finalsave" class="rezaButt buttPrimary" style="display:none">
            <i class="fa fa-check-square-o"> </i>  Submit
        </span>
                </div>
            </div>

        </div>
    </div>
</div>