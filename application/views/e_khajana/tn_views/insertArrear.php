<style>
    .arrear{display:flex;gap:8px;}
    .showTotalRevenue{width:100%;padding:10px;box-sizing:border-box;display:flex;justify-content:space-between;
        gap: 10px;font-size: 18px;font-weight: bold;color: green;text-align: center;}
    .showTotalRevenue div{flex:1 1;background:#f7e9e9;padding:7px;border-radius:5px;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;}
    .showTotalRevenue div p{margin-bottom:4px;}
    .showTotalRevenue div span{color:red;}
</style>
<?php $arrear_year = EKHAJANA_PRE_ARREAR_YEARS ?>
<div class="align-middle" id="Ek_Arrear_Pre_Update" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:100%">
        <div class="modal-content">
            <u class="modal-header text-center text-white text-bold text-center bg-primary" style="text-align:center">
                Arrear Pre Updation
            </u>
            <div class="modal-header text-white text-bold text-center bg-success">
                <h5 class="modal-title w-100">
                    
                    <u>
                        <?php echo $this->lang->line('district')?>: <span style="color:yellow"><?=$this->utilityclass->getDistrictName($dist_code)?></span>,<br>
                        <?php echo $this->lang->line('subdivision')?>: <span style="color:yellow"><?=$this->utilityclass->getSubDivName($dist_code, $subdiv_code)?></span>,&nbsp;&nbsp;&nbsp;
                        <?php echo $this->lang->line('circle')?>:<span style="color:yellow"> <?=$this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code)?></span>,&nbsp;&nbsp;&nbsp;
                        <?php echo $this->lang->line('mouza')?>:<span style="color:yellow"> <?=$this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code)?></span>,&nbsp;&nbsp;&nbsp;
                        <?php echo "Lot"?>:<span style="color:yellow"> <?=$this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,$lot_no)?></span>,&nbsp;&nbsp;&nbsp;
                        <?php echo "Village"?>:<span style="color:yellow"> <?=$this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,$lot_no,$vill_townprt_code)?></span>,&nbsp;&nbsp;&nbsp;
                    </u>
                    <br>
                    <u>
                        Patta No : <span style="color:yellow"><?=$patta_no?></span>,&nbsp;&nbsp;&nbsp;
                        Patta Type : <span style="color:yellow"><?=$this->utilityclass->getPattaType($patta_type_code)?></span>
                    </u>
                </h5>
            </div>
           
            <!-- <form id="ek_arrear_pre_updatipn_form"> -->
                <form method="POST" id="arrear_pre_updation_form_fillup">
                <input type="hidden" name ="dist_code" value="<?=$dist_code?>"></input>
                <input type="hidden" name ="subdiv_code" value="<?=$subdiv_code?>"></input>
                <input type="hidden" name ="cir_code" value="<?=$cir_code?>"></input>
                <input type="hidden" name ="mouza_pargona_code" value="<?=$mouza_pargona_code?>"></input>
                <input type="hidden" name ="lot_no" value="<?=$lot_no?>"></input>
                <input type="hidden" name ="vill_townprt_code" value="<?=$vill_townprt_code?>"></input>
                <input type="hidden" name ="patta_type_code" value="<?=$patta_type_code?>"></input>
                <input type="hidden" name ="patta_no" value="<?=$patta_no?>"></input>
                <div class="modal-body" >
                    <div class="form-group mb-5">
                        <div class="row">
                            <div class="col-2 text-center">
                                <span style="font-weight:bolder">Revenue-Year-(ভাস্কৰাব্দ)</span>                                                                
                            </div>                                                            
                            <div class="col-2 text-center">
                                <span style="font-weight:bolder">Revenue</span>
                            </div>
                            <div class="col-2 text-center">
                                <span style="font-weight:bolder">Local-Tax</span>
                            </div>
                            <div class="col-2 text-center">
                                <span style="font-weight:bolder">Surcharge</span>
                            </div>
                            <!-- <div class="col-2 text-center">
                                <span style="font-weight:bolder">Miran</span>
                            </div> -->
                            <div class="col-2 text-center">
                                <span style="font-weight:bolder">Arrear</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-3 text-center p-1 text-primary">
                                <span style="font-weight:bolder">Prior to 2000</span> 
                                <input type="hidden" name ='years[]' value='0000-2000'  readonly class="form-control">
                            </div>
                            <div class="col-9 text-center p-1">
                                
                                <div class="arrear cal_row" >
                                    <input onkeyup = "plus_a(this)" type ="number" min='0' required class="form-control sec_a" placeholder="Revenue Amount" rows="3" name="revenue[]" id="revenue_prior">
                                    </input>
                                    <input onkeyup = "plus_a(this)" type ="number" min='0' required class="form-control sec_b" placeholder="Local Tax Amount" rows="3" name="tax[]" id="tax_prior">
                                    </input>
                                    <input onkeyup = "plus_a(this)" type ="number" min='0' required class="form-control sec_c" placeholder="Surcharge Amount" rows="3" name="surcharge[]" id="surcharge_prior">
                                    </input>
                                    <input readonly type ="number" required class="form-control cal_sum" placeholder="Arrear Amount" rows="3" name="arrear[]" id="arrear_prior">
                                    </input>
                                </div>
                                
                            </div>
                            <?php foreach ($arrear_year as $year):?>    
                                <div class="col-3 text-center p-1 text-primary">
                                    <span style="font-weight:bolder"><?=$year.'-'.($year+1)?>(ভাস্কৰাব্দ-<?=$year-593?>)</span> 
                                    <input type="hidden" name ='years[]' value='<?=$year.'-'.($year+1)?>'  readonly class="form-control">
                                </div>
                                <div class="col-9 text-center p-1">
                                    
                                    <div class="arrear cal_row" >
                                        <input  type ="number" min='0' required class="form-control sec_a" placeholder="Revenue Amount" rows="3" name="revenue[]" id="revenue_<?=$year?>">
                                        </input>
                                        <input  type ="number" min='0' required class="form-control sec_b" placeholder="Local Tax Amount" rows="3" name="tax[]" id="tax_<?=$year?>">
                                        </input>
                                        <input  type ="number" min='0' required class="form-control sec_c" placeholder="Surcharge Amount" rows="3" name="surcharge[]" id="surcharge_<?=$year?>">
                                        </input>
                                        <!-- <input  type ="number" required class="form-control sec_d" placeholder="Miran" rows="3" name="miran[]" id="miran_<?=$year?>">
                                        </input> -->
                                        <input readonly type ="number" required class="form-control cal_sum" placeholder="Arrear Amount" rows="3" name="arrear[]" id="arrear_<?=$year?>">
                                        </input>
                                    </div>
                                    
                                </div>
                            <?php endforeach;?>
                            <?php if($is_auto_year == 'Y'):?>
                                <?php foreach ($archive_doul_rates as $year):?> 
                                    <span style="color:red">* Auto Fetched From Previous Doul</span>   
                                    <div class="col-3 text-center p-1 text-danger">
                                        <span style="font-weight:bolder"><?=$year.'-'.($year+1)?>(ভাস্কৰাব্দ-<?=$year-593?>)</span> 
                                        <input type="hidden" name ='years[]' value='<?=$year.'-'.($year+1)?>'  readonly class="form-control">
                                    </div>
                                    <div class="col-9 text-center p-1">
                                    
                                        <div class="arrear cal_row" >
                                            <input onkeyup = "plus_a(this)"  type ="number" min='0' required class="form-control sec_a" placeholder="Revenue Amount" rows="3" name="revenue[]" id="revenue_<?=$year?>" value="<?= isset($arch_doul_2025->dag_revenue) ? number_format($arch_doul_2025->dag_revenue, 2) : '' ?>">
                                            </input>
                                            <input onkeyup = "plus_a(this)"  type ="number" min='0' required class="form-control sec_b" placeholder="Local Tax Amount" rows="3" name="tax[]" id="tax_<?=$year?>" value="<?= isset($arch_doul_2025->dag_local_tax) ? number_format($arch_doul_2025->dag_local_tax, 2) : '' ?>">
                                            </input>
                                            <input readonly type ="number" required class="form-control cal_sum" placeholder="Arrear Amount" rows="3" name="arrear[]" id="arrear_<?=$year?>">
                                            </input>
                                        </div>
                                        
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                            <!-- ********* auto calculate from archive douls ends-->
                            <br><br><br>
                            <hr>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">                                                                                                                                                                                                           
                                    <div class="showTotalRevenue">
                                        <div>
                                            <span style="font-weight:bolder;margin-top:10px;text-align:center">Total:</span> 
                                        </div>
                                        <div>
                                            <p>Revenue</p>
                                            <span type="text" id="testss"></span>
                                            <input type="hidden" id="testssi" class="form-control mt-2"  name="total_revenue"></input>
                                        </div>
                                        <div>
                                            <p>Local Tax</p>
                                            <span type="text" id="testsb"></span>
                                            <input type="hidden" id="testsbi" class="form-control mt-2"  name="total_tax"></input> 
                                        </div>
                                        <div>
                                            <p>Surcharge</p>
                                            <span type="text" id="testsd"></span>
                                            <input type="hidden" id="testsdi" class="form-control mt-2"  name="total_surcharge"></input> 
                                        </div>
                                        <!-- <div>
                                            <p>Miran</p>
                                            <span type="text" id="testse"></span>
                                            <input type="hidden" id="testsei" class="form-control mt-2"  name="total_miran"></input> 
                                        </div> -->
                                        <div>
                                            <p>Arrear</p>
                                            <span type="text" id="testsc"></span>
                                            <input type="hidden" id="testsci" class="form-control mt-2"  name="total_arrear"></input> 
                                        </div>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="ek_arrear_pre_updation_validation_error_div" style="display:none;">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="ek_arrear_pre_updation_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-success" onclick="EkArearPreUpdationSubmit()">
                            <i class="fa fa-check" aria-hidden="true"></i>
                                Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="EkArearPreUpdationClose()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                                Close
                        </button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_tn.js"></script>
<script>
    $('.sec_a, .sec_b, .sec_c, .sec_d').on('keyup', function(){
        const closest = $(this).closest('.cal_row');
        cal_sum(closest);
    });

    function cal_sum(closestEl){
        let a = $('.sec_a', closestEl).val(); 
        let b = $('.sec_b', closestEl).val();
        let c = $('.sec_c', closestEl).val();
        let d = $('.sec_d', closestEl).val();
        if(a === NaN){
            a = 0;
        }
        if(b === NaN){
            b = 0;
        }
        if(c === NaN){
            c = 0;
        }
        // if(d === NaN){
        //     d = 0;
        // }
        let total = parseFloat(a) + parseFloat(b) + parseFloat(c);
        $('.cal_sum', closestEl).val(total);
        get_total();
    }

    function get_total(){
        let totalSecA = 0;
        let totalSecB = 0;
        let totalSecD = 0;
        let totalSecE = 0;
        let totalSecC = 0;
        let total = 0;
        $('.sec_a').each(function() {
            // console.log($(this).val());
            if($(this).val() != '' && $(this).val() !== NaN){
                totalSecA = totalSecA + parseFloat($(this).val());
            }
        });
        $('.sec_b').each(function() {
            if($(this).val() != '' && $(this).val() !== NaN){
                totalSecB = totalSecB + parseFloat($(this).val());
            }
        }); 
        $('.sec_c').each(function() {
            if($(this).val() != '' && $(this).val() !== NaN){
                totalSecD = totalSecD + parseFloat($(this).val());
            }
        }); 
        $('.sec_d').each(function() {
            if($(this).val() != '' && $(this).val() !== NaN){
                totalSecE = totalSecE + parseFloat($(this).val());
            }
        });
        $('.cal_sum').each(function() {  
            if($(this).val() != '' && $(this).val() !== NaN){
                totalSecC = totalSecC + parseFloat($(this).val());
            }
        });

        $('#testss').text(totalSecA);
        $('#testsb').text(totalSecB);
        $('#testsc').text(totalSecC);
        $('#testsd').text(totalSecD);
        $('#testse').text(totalSecE);
        $('#testssi').val(totalSecA);
        $('#testsbi').val(totalSecB);
        $('#testsdi').val(totalSecD);
        $('#testsei').val(totalSecE);
        $('#testsci').val(totalSecC);
    }

   
</script>

