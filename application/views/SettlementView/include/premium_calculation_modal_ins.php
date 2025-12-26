<div class="modal" role="dialog" id="premiumModal" style="padding-top: 25px!important;" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            PREMIUM CALCULATION
                        </h5>
                        <h6 style="color: red;">NOTE: (This premium calculation tool generates results based on the selected data. Please review and verify amount details before approval)</h6>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" align="right">
                        <i class="fa fa-times-circle closePremium" aria-hidden="true" style="color: red; font-weight: bold; font-size: 28px"></i>
                    </div>
                </div>
                <div class="modal-body" align="">
                    <div>
                        <input type="hidden" name="reclassification_amount_used_or_not" id="reclassification_amount_used_or_not">
                    </div>
                    <?php  $areacount=1;  foreach($dags as $dagsprem){ ?>

                        <div class="tableCard " style="padding: 25px!important;">
                            <div class="row">
                                <input type='hidden' id='approval<?=$dagsprem->dag_no?>' class='form-group' name='approval<?=$dagsprem->dag_no?>'>
                                <div class="form-group col-md-6 ">
                                    <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                </div>
                                <div class="form-group col-md-6">

                                    <input type="number" readonly onkeyup="zonalValueChange<?=$dagsprem->dag_no?>()" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                            class="zonal_valuation_prem form-control <?php if(form_error('zonal_valuation_prem')){echo 'lm_invalid';}?>"
                                            value="<?php if(isset($err_return)){ echo set_value('zonal_valuation_prem'.$dagsprem->dag_no);} else {echo $this->utilityclass->getZonalValue($dagsprem->dist_code,$basic['uuid'],$dagsprem->dag_no);} ?>" placeholder="Enter Amount"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label>Selected Area Type (Chitha Dag Flag)</label>

                                </div>
                                <div class="form-group col-md-6">
                                    <select readonly class="form-control"  name='area<?=$dagsprem->dag_no?>' id='area<?=$dagsprem->dag_no?>' >
                                        <option value="">First select Area type in Area details section</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row reclass_prem">
                                <div class="form-group col-md-6 ">
                                    <label>Existing Land  Class (As per Chitha Record)</label>

                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="exit_land_class<?=$dagsprem->dag_no?>" id="exit_land_class<?=$dagsprem->dag_no?>" value="<?=$this->utilityclass->getLandClassCode($dagsprem->new_land_class_code);?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row reclass_prem">
                                <div class="form-group col-md-6">
                                    <label for="title">Select Land Type for Existing land class: (As per Chitha Record)</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select onchange="textfieldChange1<?=$dagsprem->dag_no?>()" name="rate_type<?=$dagsprem->dag_no?>" id="rate_type<?=$dagsprem->dag_no?>" class="form-select">
                                        <option value="">Select Land Type</option>
                                        <option value="1">Agriculture</option>
                                        <option value="2">Residential</option>
                                        <option value="4">Trade</option>
                                        <option value="3">Industrial</option>
                                        <option value="10">Institution</option>
                                        <option value="6">Plantation</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row reclass_prem">
                                <div class="form-group col-md-6 ">
                                    <label for="title">Selected Proposed Land Class:</label>

                                </div>
                                <div class="form-group col-md-6 ">
                                    <select onchange="textfieldChange2<?=$dagsprem->dag_no?>()" name="prop_land_class<?=$dagsprem->dag_no?>" class="form-select" id="prop_land_class<?=$dagsprem->dag_no?>">
                                        <option value="">--SELECT PROPOSED LAND CLASS--</option>
                                        <?php 
                                        foreach ($land_class_groups as $key => $value) { ?>
                                            <option value="<?=$value->id?>"><?=$value->name;?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    

                                </div>
                            </div>

                            <div class="row reclass_prem_used">
                                <div class="form-group col-md-6 ">
                                    <label for="title">Reclassfication Premium (<span id="percentage<?=$dagsprem->dag_no?>"></span>)</label>

                                </div>
                                <div class="form-group col-md-6 ">
                                    <input type="text" class="form-control" name="reclassification_amount<?=$dagsprem->dag_no?>" id="reclassification_amount<?=$dagsprem->dag_no?>" readonly>
                                    

                                </div>
                                <input type="hidden" name="percentage_val<?=$dagsprem->dag_no?>" id="percentage_val<?=$dagsprem->dag_no?>">
                            </div>
                           
                
                        
                            
                            <!-- <div class="row" id="percentage<?=$dagsprem->dag_no?>"></div> -->
                            <input type="hidden" name="is_urban_prem<?=$dagsprem->dag_no?>" id="is_urban_prem<?=$dagsprem->dag_no?>" value="<?=$dagsprem->is_urban?>">
                            <input type="hidden" name="ins_cat_prem<?=$dagsprem->dag_no?>" id="ins_cat_prem<?=$dagsprem->dag_no?>" value="<?=$instituteDetails->ins_cat_type_co?>">
                            <?php if($instituteDetails->ins_cat_type_co == 10 || $instituteDetails->ins_cat_type_co == 11){ ?>
                                <div class="row">
                                    <div class="form-group col-md-6 ">
                                        <label style="color:#ff5200">Land revenue amount (25 years land revenue) </label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" name="land_revenue_years<?=$dagsprem->dag_no?>" class="form-control" id="land_revenue_years<?=$dagsprem->dag_no?>" readonly value="<?=$this->utilityclass->getlandRevenue25years($dagsprem->dist_code,$dagsprem->subdiv_code,$dagsprem->cir_code,$dagsprem->mouza_pargona_code,$dagsprem->lot_no,$dagsprem->vill_townprt_code,$dagsprem->dag_no)?>">
                                    </div>
                                </div>
                            
                            <?php } ?>

                           
                            
                            

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
                            <div class="row">
                                <span id="fetch_premium<?=$dagsprem->dag_no?>" class="btn btn-sm btn-warning">Fetch premium</span>
                            </div>
                        </div>


                        <script>

                            $(document).ready(function(){
                                // ajax for getting land list starts here
                                var area_id = $("#area_new<?=$dagsprem->dag_no?>").val();
                                var area_category = $("#area_cat_new<?=$dagsprem->dag_no?>").val();
                                var land_area_name_new ="<option value='" +
                                                    area_id +
                                                    "'>" +
                                                    area_category +
                                                    "</option>";
                                $("#area<?=$dagsprem->dag_no?>").html(land_area_name_new);

                                
                            });
                            // $(document).on('change','#already_alloted<?=$dagsprem->dag_no?>',function (e)
                            // {
                            //     e.preventDefault();
                            //     var already_alloted = $("#already_alloted<?=$dagsprem->dag_no?>").val();
                            //     $('.already_premium_paid_div<?=$dagsprem->dag_no?>').hide();
                            //     if(already_alloted == 'Y')
                            //     {
                            //         $('.already_premium_paid_div<?=$dagsprem->dag_no?>').show();
                            //     }

                            // });

                            // $(document).on('change','#already_premium_paid<?=$dagsprem->dag_no?>',function (e)
                            // {
                            //     e.preventDefault();
                            //     var already_premium_paid = $("#already_premium_paid<?=$dagsprem->dag_no?>").val();
                            //     $('.already_premium_amount_div<?=$dagsprem->dag_no?>').hide();
                            //     if(already_premium_paid == 'Y')
                            //     {
                            //         $('.already_premium_amount_div<?=$dagsprem->dag_no?>').show();
                            //     }

                            // });
                            $( "select[name='rate_type<?=$dagsprem->dag_no?>']" ).change(function () {
                                $('#prop_land_class<?=$dagsprem->dag_no?>').val('');
                                $("#reclassification_amount<?=$dagsprem->dag_no?>").val('');
                                $("#percentage<?=$dagsprem->dag_no?>").html('');
                                $("#percentage_val<?=$dagsprem->dag_no?>").val('');
                            });

                            $( "select[name='prop_land_class<?=$dagsprem->dag_no?>']" ).change(function () {
                                var typeID = $(this).val();
                                var dag_no = $('#dag_no<?=$dagsprem->dag_no?>').val();
                                var prop_land_class= $('#prop_land_class<?=$dagsprem->dag_no?>').val();
                                var exit_class= $('#rate_type<?=$dagsprem->dag_no?>').val();
                                var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                var reclassification_amount_used_or_not = $('#reclassification_amount_used_or_not').val();

                                
          

                                // ajax for getting land list starts here
                                $.ajax({
                                    url: "<?=base_url()?>index.php/SettlementInstitutionLm/getRateWithTransfer/" + prop_land_class +'/'+ exit_class,
                                        success: function(data) {
                                  
                                        var landpercentage = JSON.parse(data);
                                        for (var i = 0; i < landpercentage.length; i++) {
                                            var ratetype=landpercentage[i].rate+'%';
                                            var percentageVal = landpercentage[i].rate;
                                            var template =
                                                "<div class='form-group col-md-6'><label> Rate ('"+ratetype+"')</label></div>";

                                            // var template2 =
                                            //     "<div class='form-group col-md-6'><label style='color: red;'> Remark :"+landpercentage[i].msg+"</label></div>";
                                            var reclassification_amount = (zonal * landpercentage[i].rate) / 100;

                                            
                                        }
                                        var reclassification_amount_new = 0;
                                        <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                            var mbigha=parseFloat($("#home_b<?=$dagsprem->dag_no?>").val());
                                            var mkatha=parseFloat($("#home_k<?=$dagsprem->dag_no?>").val());
                                            var mlessa=parseFloat($("#home_lc<?=$dagsprem->dag_no?>").val());
                                            var mganda=parseFloat($("#home_g<?=$dagsprem->dag_no?>").val());
                                            var appbigha=mbigha;
                                            var appkatha=mkatha;
                                            var applessa=parseFloat(mlessa);
                                            var appganda=parseFloat(mganda);
                                            var total_ganda = parseFloat((appbigha * 6400) + (appkatha * 320) + (applessa * 20) + appganda);
                                            var total_road_reserved = 0;
                                            var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val();
                                            //if(land_revenue_years == null || land_revenue_years=='' || land_revenue_years=='undefined'){land_revenue_years=0;}
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
                                            var total_s_area = parseFloat(total_ganda - total_road_reserved - total_family_reserved);
                                            var per_ganda_rate = reclassification_amount / 6400;
                                            reclassification_amount_new = total_s_area * per_ganda_rate;
                                            // if(reclassification_amount_used_or_not == 'N')
                                            // {
                                            //     $("#reclassification_amount<?=$dagsprem->dag_no?>").val(0);
                                            // }
                                            // else
                                            // {
                                            //     $("#reclassification_amount<?=$dagsprem->dag_no?>").val(reclassification_amount_new);
                                            // }

                                        <?php else : ?>

                                            var mbigha=parseFloat($("#home_b<?=$dagsprem->dag_no?>").val());
                                            var mkatha=parseFloat($("#home_k<?=$dagsprem->dag_no?>").val());
                                            var mlessa=parseFloat($("#home_lc<?=$dagsprem->dag_no?>").val());
                                            var ins_cat_prem=$("#ins_cat_prem<?=$dagsprem->dag_no?>").val();
                                            var is_urban_prem=$("#is_urban_prem<?=$dagsprem->dag_no?>").val();


                                            var appbigha=mbigha;
                                            var appkatha=mkatha;
                                            var applessa=parseFloat(mlessa);

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
                                            var total_s_area = 0;
                                     
                                            total_s_area = parseFloat(total_lessa - total_road_reserved - total_family_reserved);
                                            console.log(total_s_area);
                                            var per_lessa_rate = reclassification_amount / 100;
                                            reclassification_amount_new = total_s_area * per_lessa_rate;

                                        <?php endif ;?>

                                        //console.log(template);


                                        $("#percentage_val<?=$dagsprem->dag_no?>").val(percentageVal);
                                        $("#percentage<?=$dagsprem->dag_no?>").html(template);
                                        if(reclassification_amount_used_or_not == 'N')
                                        {
                                            $("#reclassification_amount<?=$dagsprem->dag_no?>").val(0);
                                        }
                                        else
                                        {
                                            $("#reclassification_amount<?=$dagsprem->dag_no?>").val(reclassification_amount_new);
                                        }
                                        
                                        // $("#msg<?=$dagsprem->dag_no?>").html(template2);
                
                                    },
                                    error: function(error) {
                                        // loading.out();
                                    },
                                });
                                // ajax for getting land list ends here
                            });

                            $(document).on('click','#fetch_premium<?=$dagsprem->dag_no?>',function (e)
                            {
                                e.preventDefault();
                                <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                    var already_paid_amount = 0;
                                    var reclassification_amount_paid = 0;
                                    var already_alloted = 'N';
                                    premium_for_settlement_on = $("#premium_for_settlement_on").val();
                                    var area_flag = $("#area<?=$dagsprem->dag_no?>").val();

                                    if(area_flag == null || area_flag == '')
                                    {
                                        alert('#ERR 594 :Chitha dag flag missing!!! please flag it first from Utility->Chitha Dag Mapping(LRA->CO)');
                                        return false;
                                    }
                                    if(premium_for_settlement_on == 1)
                                    {
                                        // already_paid_amount = parseFloat($("#premium_amount_paid").val());
                                        already_alloted = $("#already_alloted").val();
                                    }
                                    var state_warehousing_corporation = $("#state_warehousing_corporation").val();
                                    var central_cwc_sector = $("#central_cwc_sector").val();
                                    var central_health_education_skill_sector = $("#central_health_education_skill_sector").val();

                                    var reclassification_amount_used_or_not = $('#reclassification_amount_used_or_not').val();
                                    var non_govt_profit_making_yes_no_val = $("#non_govt_profit_making_yes_no_val").val();
                                    var under_venture_school = $("#under_venture_school").val();
                                    var venture_type = $("#venture_type").val();


                                    var purpose_land_allot_co_val = $("#purpose_land_allot_co_val").val();

                                    var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                    var land_revenue_years = $("#land_revenue_years<?=$dagsprem->dag_no?>").val();
                                    var ins_cat_prem=$("#ins_cat_prem<?=$dagsprem->dag_no?>").val();
                                    var is_urban_prem=$("#is_urban_prem<?=$dagsprem->dag_no?>").val();
                                    var mbigha=parseFloat($("#home_b<?=$dagsprem->dag_no?>").val());
                                    var mkatha=parseFloat($("#home_k<?=$dagsprem->dag_no?>").val());
                                    var mlessa=parseFloat($("#home_lc<?=$dagsprem->dag_no?>").val());
                                    var mganda=parseFloat($("#home_g<?=$dagsprem->dag_no?>").val());

                                    var exit_class= $('#rate_type<?=$dagsprem->dag_no?>').val();
                                    var prop_land_class= $('#prop_land_class<?=$dagsprem->dag_no?>').val();
                                    if(exit_class == null || exit_class == '')
                                    {
                                        alert('#ERR 594 :Please select existing land class...');
                                        return false;
                                    }
                                    if(prop_land_class == null || prop_land_class == '')
                                    {
                                        alert('#ERR 594 :Please select proposed land class...');
                                        return false;
                                    }
                         


                                    var commercial_purpose_non_govt = null;
                                    var commercial_purpose_govt = null;
                                    // alert($('#commercial_purpose_non_govt').val());
                                    if(ins_cat_prem == 12)
                                    {
                                        commercial_purpose_non_govt = $('#commercial_purpose_non_govt').val();
                                        if(commercial_purpose_non_govt == null || commercial_purpose_non_govt == '')
                                        {
                                            
                                            var commercial_purpose_non_govt_new = $('input:radio[name=religious_or_charitable_purposes_reclassification]:checked').val();
                                           
                                            if(commercial_purpose_non_govt_new == null || commercial_purpose_non_govt_new == '')
                                            {
                                                alert('#ERR 3772 :Is the Land applied for used for religious or charitable purposes and other public utilities or amenities ...');
                                                return false;
                                            }
                                            else
                                            {
                                                commercial_purpose_non_govt = commercial_purpose_non_govt_new;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        commercial_purpose_govt = $('#commercial_purpose_govt').val();
                                        if(commercial_purpose_govt == null || commercial_purpose_govt == '')
                                        {
                                            
                                            var commercial_purpose_govt_new = $('input:radio[name=transferred_for_commercial_purposes_reclassification_govt]:checked').val();
                                            if(commercial_purpose_govt_new == null || commercial_purpose_govt_new == '')
                                            {
                                                alert('#ERR 3772 : Is the  land applied for, is or will be used or  transferred for commercial purposes...');
                                                return false;
                                            }
                                            else
                                            {
                                                commercial_purpose_govt = commercial_purpose_govt_new;
                                            }
                                        }
                                    }

                                    var appbigha=mbigha;
                                    var appkatha=mkatha;
                                    var applessa=parseFloat(mlessa);
                                    var appganda=parseFloat(mganda);
                                    var total_ganda = parseFloat((appbigha * 6400) + (appkatha * 320) + (applessa * 20) + appganda);
                                    var total_road_reserved = 0;
                                    var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val();
                                    if(land_revenue_years == null || land_revenue_years=='' || land_revenue_years=='undefined'){land_revenue_years=0;}
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
                                    // var family_reserved_yn = $("input[name=family_comment_check]:checked").val();
                                    // if (family_reserved_yn == "YES") {
                                    //     var family_bigha=parseFloat($("#reserved_bigha_family<?=$dagsprem->dag_no?>").val());
                                    //     var family_katha=parseFloat($("#reserved_katha_family<?=$dagsprem->dag_no?>").val());
                                    //     var family_lessa=parseFloat($("#reserved_lessa_family<?=$dagsprem->dag_no?>").val());
                                    //     var family_ganda=parseFloat($("#reserved_ganda_family<?=$dagsprem->dag_no?>").val());
                                    //     if(family_bigha == null || family_bigha=='' || family_bigha=='undefined'){family_bigha=0;}
                                    //     if(family_katha == null || family_katha=='' || family_katha=='undefined'){family_katha=0;}
                                    //     if(family_lessa == null || family_lessa=='' || family_lessa=='undefined'){family_lessa=0;}
                                    //     if(family_ganda == null || family_ganda=='' || family_ganda=='undefined'){family_ganda=0;}
                                    //     total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                                    // }else if(family_reserved_yn == "NO"){
                                    //     total_family_reserved = 0;
                                    // }

                                    var total_s_area = parseFloat(total_ganda - total_road_reserved - total_family_reserved);
                                    // var rate_type = $("#amount_type<?=$dagsprem->dag_no?>").val();
                                    var amount = 0;
                                    $("#finalamount").val('');
                                    $("#totaldue").val('');
                                    $(".premhide").hide();
                                    $("#finalsubmit").show();
                                    $("#finalsave").hide();
                                    $(".paymode").prop( "checked", false );
                                    $("#lmfinalamount").text('');
                                    $("#lmdueamount").text('');
                                    var rate = parseFloat($("#rate<?=$dagsprem->dag_no?>").val());
                                    var rate_per_bigha = 0; 

                                    if(already_alloted == 'Y' && ins_cat_prem == 9 && commercial_purpose_govt == 'Y' && reclassification_amount_used_or_not =='Y')
                                    {
                                        reclassification_amount_paid = Math.ceil($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                    }
                                    else if(commercial_purpose_govt == 'Y' && (ins_cat_prem == 10 || ins_cat_prem == 11) && reclassification_amount_used_or_not == 'Y')
                                    {
                                        reclassification_amount_paid = Math.ceil($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                    }
                                    else if(reclassification_amount_used_or_not == 'Y' && commercial_purpose_non_govt == 'N' && already_alloted == 'Y' && ins_cat_prem == 12 && (purpose_land_allot_co_val == 'socioculture' || purpose_land_allot_co_val == 'education' || purpose_land_allot_co_val == 'religious'))
                                    {
                                        reclassification_amount_paid = Math.ceil($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                    }
                                    else
                                    {
                                        if(ins_cat_prem != 9 &&  prop_land_class != 20 && prop_land_class != 21)
                                        {
                                            alert('#ERR 59421 : You can not choose land class other than Institution');
                                            return false;
                                        }
                                        reclassification_amount_paid = 0;
                                    }

                                    if(ins_cat_prem == 12  && (purpose_land_allot_co_val == 'socioculture' || purpose_land_allot_co_val == 'religious'))
                                    {
                                        if(is_urban_prem == 'Y')
                                        {
                                            if(already_alloted == 'Y')
                                            {
                                                rate_per_bigha = 50000;
                                            }
                                            else
                                            {
                                                rate_per_bigha = 25000;
                                            }
                                        }
                                        else if(is_urban_prem == 'N' && area_flag == 10)
                                        {
                                            if(already_alloted == 'Y')
                                            {
                                                rate_per_bigha = 500;
                                            }
                                            else
                                            {
                                                rate_per_bigha = 250;
                                            }
                                        }
                                        else if(is_urban_prem == 'N' && area_flag != 10)
                                        {
                                            if(already_alloted == 'Y')
                                            {
                                                rate_per_bigha = 50000;
                                            }
                                            else
                                            {
                                                rate_per_bigha = 25000;
                                            }
                                        }
                                        var per_ganda_rate = rate_per_bigha / 6400;
                                        // var amount = (premium * rate / 100).toFixed(2);
                                        amount = Math.ceil(per_ganda_rate * total_s_area);
                                    }
                                    else if(ins_cat_prem == 12 && non_govt_profit_making_yes_no_val == 'N' && purpose_land_allot_co_val == 'education' && (under_venture_school == null || under_venture_school == '' || under_venture_school == 'NO'))
                                    {
                                       
                                        amount = total_s_area * zonal / 6400;
                                        if(already_alloted == 'Y')
                                        {   
                                            amount = amount;
                                        }
                                        else
                                        {
                                            amount = amount / 2;
                                        }

                                    }
                                    else if(ins_cat_prem == 12 && non_govt_profit_making_yes_no_val == 'Y' && purpose_land_allot_co_val == 'education'&& (under_venture_school == null || under_venture_school == '' || under_venture_school == 'NO'))
                                    {
                                       
                                        amount = total_s_area * zonal / 6400;
                                        amount = Math.ceil(amount * 30 / 100);
                                        if(already_alloted == 'Y')
                                        {   
                                            amount = amount;
                                        }
                                        else
                                        {
                                            amount = amount / 2;
                                        }

                                    }
                                    else if(ins_cat_prem == 12 && purpose_land_allot_co_val == 'education' && under_venture_school == 'YES' && venture_type == 'govt_aided_venture')
                                    {
                                        ////////////rationalised premium per bigha concept///////////
                                        if(is_urban_prem == 'Y')
                                        {
                                            if(already_alloted == 'Y')
                                            {
                                                rate_per_bigha = 50000;
                                            }
                                            else
                                            {
                                                rate_per_bigha = 25000;
                                            }
                                        }
                                        else if(is_urban_prem == 'N' && area_flag == 10)
                                        {
                                            if(already_alloted == 'Y')
                                            {
                                                rate_per_bigha = 500;
                                            }
                                            else
                                            {
                                                rate_per_bigha = 250;
                                            }
                                        }
                                        else if(is_urban_prem == 'N' && area_flag != 10)
                                        {
                                            if(already_alloted == 'Y')
                                            {
                                                rate_per_bigha = 50000;
                                            }
                                            else
                                            {
                                                rate_per_bigha = 25000;
                                            }
                                        }
                                        var per_ganda_rate = rate_per_bigha / 6400;
                                        // var amount = (premium * rate / 100).toFixed(2);
                                        amount = Math.ceil(per_ganda_rate * total_s_area);

                                    }

                                    else if(ins_cat_prem == 12 && purpose_land_allot_co_val == 'education' && under_venture_school == 'YES' && venture_type == 'unrecognised_venture')
                                    {
                                        ////////in unrecognise venture school////////100% premium
                                        amount = total_s_area * zonal / 6400;
                                        if(already_alloted == 'Y')
                                        {   
                                            amount = amount;
                                        }
                                        else
                                        {
                                            amount = amount / 2;
                                        }

                                    }
                                    else if(ins_cat_prem == 8 && already_alloted =='N')
                                    {
                                        amount = 0;
                                    }
                                    else if(ins_cat_prem == 9  && already_alloted =='N')
                                    {
                                        amount = total_s_area * zonal / 6400;
                                        amount = amount / 2;
                                    }
                                    else if(ins_cat_prem == 9 && already_alloted =='Y')
                                    {
                                        amount = total_s_area * zonal / 6400;
                                    }
                                    else if(ins_cat_prem == 8 && already_alloted =='Y')
                                    {
                                        amount = 0;
                                    }
                                    else if(ins_cat_prem == 10 || ins_cat_prem == 11)
                                    {
                                        if(land_revenue_years == null || land_revenue_years == undefined || land_revenue_years == '' )
                                        {
                                             alert('#ERR : Enter the 25 years capitalized land revenue amount');
                                            return;
                                        }
                                        if(land_revenue_years == '0' || land_revenue_years =='0.00' || land_revenue_years == "0.0000")
                                        {
                                            alert('#ERR : Revenue should not be Zero');
                                            return false; 
                                        }
                                        
                                        var new_amount = total_s_area * zonal / 6400;
                                        amount = new_amount + Math.ceil(land_revenue_years);
                                    }
                                    else
                                    {
                                        alert('#ERR648 : Required data missing for the application...kindly check the required data!!!');
                                        return;
                                    }


                                    if(isNaN(reclassification_amount_paid))
                                    {
                                        alert('#ERR : Invalid Amount, can not proceed...');
                                        return;
                                    }    

                  
                                    amount = amount + reclassification_amount_paid;
                                    $(".downpay").hide();
                                    if(ins_cat_prem == 8 && area_flag == 10)
                                    {
                                        approve_by = 'DC';
                                    }
                                    else if(ins_cat_prem == 9 && area_flag == 10 && state_warehousing_corporation == 'Y' && already_alloted == 'N')
                                    {
                                        approve_by = 'DC';
                                    }
                                    else if(ins_cat_prem == 11 && area_flag == 10 && central_cwc_sector == 'Y')
                                    {
                                        approve_by = 'DC';
                                    }
                                    else if(ins_cat_prem == 10 && area_flag == 10 && central_health_education_skill_sector == 'Y')
                                    {
                                        approve_by = 'DC';
                                    }
                                    else
                                    {
                                        approve_by = 'GOVT';
                                    }
                                    // alert(amount);
                                    $('#approval<?=$dagsprem->dag_no?>').val(approve_by);
                                    $('#finalper<?=$dagsprem->dag_no?>').val(rate);
                                    $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                    $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                    $('#validationcheck').val(1);
                                    $('#finalsubmit').show();
                                
                            <?php else : ?>
                                var already_paid_amount = 0;
                                var reclassification_amount_paid = 0;
                                var already_alloted = 'N';
                                premium_for_settlement_on = $("#premium_for_settlement_on").val();
                                var area_flag = $("#area<?=$dagsprem->dag_no?>").val();

                                if(area_flag == null || area_flag == '')
                                {
                                    alert('#ERR 594 :Chitha dag flag missing!!! please flag it first from Utility->Chitha Dag Mapping(LRA->CO)');
                                    return false;
                                }
                                if(premium_for_settlement_on == 1)
                                {
                                    // already_paid_amount = parseFloat($("#premium_amount_paid").val());
                                    already_alloted = $("#already_alloted").val();
                                }

                                // reclassification_amount_paid = parseFloat($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                
                                var state_warehousing_corporation = $("#state_warehousing_corporation").val();
                                var central_cwc_sector = $("#central_cwc_sector").val();
                                var central_health_education_skill_sector = $("#central_health_education_skill_sector").val();

                                var non_govt_profit_making_yes_no_val = $("#non_govt_profit_making_yes_no_val").val();
                                var purpose_land_allot_co_val = $("#purpose_land_allot_co_val").val();

                                var reclassification_amount_used_or_not = $('#reclassification_amount_used_or_not').val();

                                var under_venture_school = $("#under_venture_school").val();
                                var venture_type = $("#venture_type").val();
                                // alert(under_venture_school);

                                var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                var land_revenue_years = $("#land_revenue_years<?=$dagsprem->dag_no?>").val();
                                var mbigha=parseFloat($("#home_b<?=$dagsprem->dag_no?>").val());
                                var mkatha=parseFloat($("#home_k<?=$dagsprem->dag_no?>").val());
                                var mlessa=parseFloat($("#home_lc<?=$dagsprem->dag_no?>").val());
                                var ins_cat_prem=$("#ins_cat_prem<?=$dagsprem->dag_no?>").val();
                                var is_urban_prem=$("#is_urban_prem<?=$dagsprem->dag_no?>").val();

                                var exit_class= $('#rate_type<?=$dagsprem->dag_no?>').val();
                                var prop_land_class= $('#prop_land_class<?=$dagsprem->dag_no?>').val();
                                if(exit_class == null || exit_class == '')
                                {
                                    alert('#ERR 594 :Please select existing land class...');
                                    return false;
                                }
                                if(prop_land_class == null || prop_land_class == '')
                                {
                                    alert('#ERR 594 :Please select proposed land class...');
                                    return false;
                                }



                                var commercial_purpose_non_govt = null;
                                var commercial_purpose_govt = null;
                                // alert($('#commercial_purpose_non_govt').val());
                                if(ins_cat_prem == 12)
                                {
                                    commercial_purpose_non_govt = $('#commercial_purpose_non_govt').val();
                                    if(commercial_purpose_non_govt == null || commercial_purpose_non_govt == '')
                                    {
                                        
                                        var commercial_purpose_non_govt_new = $('input:radio[name=religious_or_charitable_purposes_reclassification]:checked').val();
                                       
                                        if(commercial_purpose_non_govt_new == null || commercial_purpose_non_govt_new == '')
                                        {
                                            alert('#ERR 3772 :Is the Land applied for used for religious or charitable purposes and other public utilities or amenities ...');
                                            return false;
                                        }
                                        else
                                        {
                                            commercial_purpose_non_govt = commercial_purpose_non_govt_new;
                                        }
                                    }
                                }
                                else
                                {
                                    commercial_purpose_govt = $('#commercial_purpose_govt').val();
                                    if(commercial_purpose_govt == null || commercial_purpose_govt == '')
                                    {
                                        
                                        var commercial_purpose_govt_new = $('input:radio[name=transferred_for_commercial_purposes_reclassification_govt]:checked').val();
                                        if(commercial_purpose_govt_new == null || commercial_purpose_govt_new == '')
                                        {
                                            alert('#ERR 3772 : Is the  land applied for, is or will be used or  transferred for commercial purposes...');
                                            return false;
                                        }
                                        else
                                        {
                                            commercial_purpose_govt = commercial_purpose_govt_new;
                                        }
                                    }
                                }
                                if(ins_cat_prem != 12 && (commercial_purpose_govt == null || commercial_purpose_govt == ''))
                                {
                                    alert('Some data missing, kindly reload this page...');
                                    return false;
                                }

                                if(ins_cat_prem == 12 && (commercial_purpose_non_govt == null || commercial_purpose_non_govt == ''))
                                {
                                    alert('Some data missing, kindly reload this page...');
                                    return false;
                                }


                                var appbigha=mbigha;
                                var appkatha=mkatha;
                                var applessa=parseFloat(mlessa);

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
                                // var family_reserved_yn = $("input[name=family_comment_check]:checked").val();
                                // if (family_reserved_yn == "YES") {
                                //     var family_bigha=parseFloat($("#reserved_bigha_family<?=$dagsprem->dag_no?>").val());
                                //     var family_katha=parseFloat($("#reserved_katha_family<?=$dagsprem->dag_no?>").val());
                                //     var family_lessa=parseFloat($("#reserved_lessa_family<?=$dagsprem->dag_no?>").val());
                                //     if(family_bigha == null || family_bigha=='' || family_bigha=='undefined'){family_bigha=0;}
                                //     if(family_katha == null || family_katha=='' || family_katha=='undefined'){family_katha=0;}
                                //     if(family_lessa == null || family_lessa=='' || family_lessa=='undefined'){family_lessa=0;}
                                //     total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                                // }else if(family_reserved_yn == "NO"){
                                //     total_family_reserved = 0;
                                // }

                                var total_s_area = 0;
                         
                                total_s_area = parseFloat(total_lessa - total_road_reserved - total_family_reserved);

                                // var rate_type = $("#amount_type<?=$dagsprem->dag_no?>").val();

                                
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
                                var rate_per_bigha = 0; 
                                var amount = 0;

                                if(already_alloted == 'Y' && ins_cat_prem == 9 && commercial_purpose_govt=='Y' && reclassification_amount_used_or_not == 'Y')
                                {
                                    reclassification_amount_paid = Math.ceil($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                }
                                else if(commercial_purpose_govt =='Y' && (ins_cat_prem == 10 || ins_cat_prem == 11) && reclassification_amount_used_or_not == 'Y')
                                {
                                    reclassification_amount_paid = Math.ceil($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                }
                                else if(reclassification_amount_used_or_not == 'Y' && commercial_purpose_non_govt == 'N' && already_alloted == 'Y' && ins_cat_prem == 12 && (purpose_land_allot_co_val == 'socioculture' || purpose_land_allot_co_val == 'education' || purpose_land_allot_co_val == 'religious'))
                                {
                                    reclassification_amount_paid = Math.ceil($("#reclassification_amount<?=$dagsprem->dag_no?>").val());
                                }
                                else
                                {
                                    if(ins_cat_prem != 9 && prop_land_class != 20 && prop_land_class != 21)
                                    {
                                        alert('#ERR 59421 : You can not choose land class other than Institution');
                                        return false;
                                    }
                                    reclassification_amount_paid = 0;
                                }


                                if(ins_cat_prem == 12 && (purpose_land_allot_co_val == 'socioculture' || purpose_land_allot_co_val == 'religious'))
                                {
                                    if(is_urban_prem == 'Y')
                                    {
                                        if(already_alloted == 'Y')
                                        {
                                            rate_per_bigha = 50000;
                                        }
                                        else
                                        {
                                            rate_per_bigha = 25000;
                                        }
                                    }
                                    else if(is_urban_prem == 'N' && area_flag == 10)
                                    {
                                        if(already_alloted == 'Y')
                                        {
                                            rate_per_bigha = 500;
                                        }
                                        else
                                        {
                                            rate_per_bigha = 250;
                                        }
                                    }
                                    else if(is_urban_prem == 'N' && area_flag != 10)
                                    {
                                        console.log('=========dasdas===========');
                                        if(already_alloted == 'Y')
                                        {
                                            rate_per_bigha = 50000;
                                        }
                                        else
                                        {
                                            rate_per_bigha = 25000;
                                        }
                                    }
                                    var per_lessa_rate = rate_per_bigha / 100;
                                    // var amount = (premium * rate / 100).toFixed(2);
                                    amount = Math.ceil(per_lessa_rate * total_s_area);

                                }
                                else if(ins_cat_prem == 12 && non_govt_profit_making_yes_no_val == 'N' && purpose_land_allot_co_val == 'education' && (under_venture_school == null || under_venture_school == '' || under_venture_school == 'NO'))
                                {
                                   
                                    amount = total_s_area * zonal / 100;
                                    if(already_alloted == 'Y')
                                    {   
                                        amount = amount;
                                    }
                                    else
                                    {
                                        amount = amount / 2;
                                    }

                                }
                                else if(ins_cat_prem == 12 && non_govt_profit_making_yes_no_val == 'Y' && purpose_land_allot_co_val == 'education' && (under_venture_school == null || under_venture_school == '' || under_venture_school == 'NO'))
                                {
                                   
                                    amount = total_s_area * zonal / 100;
                                    amount = Math.ceil(amount * 30 / 100);
                                    if(already_alloted == 'Y')
                                    {   
                                        amount = amount;
                                    }
                                    else
                                    {
                                        amount = amount / 2;
                                    }

                                }
                                else if(ins_cat_prem == 12 && purpose_land_allot_co_val == 'education' && under_venture_school == 'YES' && venture_type == 'govt_aided_venture')
                                {
                                    ////////////rationalised premium per bigha concept///////////
                                    if(is_urban_prem == 'Y')
                                    {
                                        if(already_alloted == 'Y')
                                        {
                                            rate_per_bigha = 50000;
                                        }
                                        else
                                        {
                                            rate_per_bigha = 25000;
                                        }
                                    }
                                    else if(is_urban_prem == 'N' && area_flag == 10)
                                    {
                                        if(already_alloted == 'Y')
                                        {
                                            rate_per_bigha = 500;
                                        }
                                        else
                                        {
                                            rate_per_bigha = 250;
                                        }
                                    }
                                    else if(is_urban_prem == 'N' && area_flag != 10)
                                    {
                                        console.log('=========dasdas===========');
                                        if(already_alloted == 'Y')
                                        {
                                            rate_per_bigha = 50000;
                                        }
                                        else
                                        {
                                            rate_per_bigha = 25000;
                                        }
                                    }
                                    var per_lessa_rate = rate_per_bigha / 100;
                                    // var amount = (premium * rate / 100).toFixed(2);
                                    amount = Math.ceil(per_lessa_rate * total_s_area);

                                }

                                else if(ins_cat_prem == 12 && purpose_land_allot_co_val == 'education' && under_venture_school == 'YES' && venture_type == 'unrecognised_venture')
                                {
                                    ////////in unrecognise venture school////////100% premium
                                    amount = total_s_area * zonal / 100;
                                    if(already_alloted == 'Y')
                                    {   
                                        amount = amount;
                                    }
                                    else
                                    {
                                        amount = amount / 2;
                                    }

                                }
                                else if(ins_cat_prem == 8 && already_alloted =='N')
                                {
                                    amount = 0;
                                }
                                else if(ins_cat_prem == 9  && already_alloted =='N')
                                {
                                    amount = total_s_area * zonal / 100;
                                    amount = amount / 2;
                                }
                                else if(ins_cat_prem == 9 && already_alloted =='Y')
                                {
                                    amount = total_s_area * zonal / 100;
                                }
                                else if(ins_cat_prem == 8 && already_alloted =='Y')
                                {
                                    amount = 0;
                                }
                                else if(ins_cat_prem == 10 || ins_cat_prem ==11 )
                                {
                                    if(land_revenue_years == null || land_revenue_years == undefined || land_revenue_years == '' )
                                    {
                                        alert('#ERR : Enter the 25 years capitalized land revenue amount');
                                        return false;
                                    }
                                    if(land_revenue_years == '0' || land_revenue_years =='0.00' || land_revenue_years == "0.0000")
                                    {
                                        alert('#ERR : Revenue should not be Zero');
                                        return false; 
                                    }
                                    var new_amount = total_s_area * zonal / 100;
                                    amount = new_amount + Math.ceil(land_revenue_years);
                                }
                                else
                                {
                                    alert('#ERR648 : Required data missing for the application...kindly check the required data!!!');
                                    return;
                                }
 
                                if(isNaN(reclassification_amount_paid))
                                {
                                    alert('#ERR : Invalid Amount, can not proceed...');
                                    return;
                                }   

                                amount = amount + reclassification_amount_paid;
                                if(ins_cat_prem == 8 && area_flag == 10)
                                {
                                    approve_by = 'DC';
                                }
                                else if(ins_cat_prem == 9 && area_flag == 10 && state_warehousing_corporation == 'Y' && already_alloted == 'N')
                                {
                                    approve_by = 'DC';
                                }
                                else if(ins_cat_prem == 11 && area_flag == 10 && central_cwc_sector == 'Y')
                                {
                                    approve_by = 'DC';
                                }
                                else if(ins_cat_prem == 10 && area_flag == 10 && central_health_education_skill_sector == 'Y')
                                {
                                    approve_by = 'DC';
                                }
                                else
                                {
                                    approve_by = 'GOVT';
                                }
                                // alert(amount);
                                $('#approval<?=$dagsprem->dag_no?>').val(approve_by);
                                $('#finalper<?=$dagsprem->dag_no?>').val(rate);
                                $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                $('#validationcheck').val(1);
                                $('#finalsubmit').show();
                                
                            <?php endif ;?>
                            });


                            function textfieldChange1<?=$dagsprem->dag_no?>(){
                                $("#prop_land_class<?=$dagsprem->dag_no?>").val('');
                                $("#reclassification_amount<?=$dagsprem->dag_no?>").val('');
                                $("#amount_<?=$dagsprem->dag_no?>").val('');
                                
                                $(".premhide").hide();
                                $("#finalsubmit").show();
                                $("#finalsave").hide();
                                $('#totaldue').val('');
                                $('#finalamount').val('');

                            }

                            function textfieldChange2<?=$dagsprem->dag_no?>(){
                   
                                $("#reclassification_amount<?=$dagsprem->dag_no?>").val('');
                                $("#amount_<?=$dagsprem->dag_no?>").val('');
                                
                                $(".premhide").hide();
                                $("#finalsubmit").show();
                                $("#finalsave").hide();
                                $('#totaldue').val('');
                                $('#finalamount').val('');

                            }

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

                            
                            // new premium addition end 
                            /// this function not in use after new premium addition
                            


                            //////// premium end
                        </script>
                        <?php $areacount++; } ?>
                    <div class="row"  align="center">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                        <span id="finalsubmit" class="rezaButt buttPrimary" style="margin-top: 20px;display: none;">
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