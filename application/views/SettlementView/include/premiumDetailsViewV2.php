<style>
    .edited-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
    }
    .edited-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .edited-title{
        font-weight: bold;
        font-size: 18px;
        /* margin-bottom: 10px; */
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        /* padding: 8px; */
    }
    .edited-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        /* padding-bottom: 40px; */
    }
</style>

<?php if(!empty($premium_data)) { ?>                                   
    <div class="edited-body">
        <h5 class="bg-success text-center">
            <i class="fa fa-history" aria-hidden="true"></i> Premium Details
        </h5>

        <div class="tableCard " style="padding: 25px!important;">
        <?php foreach ($premium_data as $dagsprem) {?>
            <div class="row">
                <div class="form-group col-md-6 ">
                    <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                </div>
                    <div class="form-group col-md-6">

                        <input type="number" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                class="form-control"
                                value="<?=$dagsprem->zonal_valuation?>" readonly/>
                    </div>
                </div>
                <?php if(isset($dagsprem->area)){ ?>
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label>Selected Area</label>

                    </div>
                    <div class="form-group col-md-6">
                    <input type="text" id="premArea<?=$dagsprem->dag_no?>" class="form-control clspremdata" name='area<?=$dagsprem->dag_no?>' value="<?=$dagsprem->area?>" readonly>
                        
                    </div>
                </div>
                <?php } ?>
                <?php if(isset($dagsprem->land_type)){ ?>
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label for="title">Purpose of Land</label>

                    </div>
                    <div class="form-group col-md-6 ">
                    <input type="text" id="premLand<?=$dagsprem->dag_no?>" class="form-control clspremdata" name='land_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_type?>" readonly>
                    </div>
                </div>
                <?php } ?>
                <?php if(isset($dagsprem->house_type)){ ?>
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label for="title">Encroached land type</label>

                    </div>
                    <div class="form-group col-md-6 ">
                    <input type="text" class="form-control" name='rate_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->house_type?>" readonly>
                        
                    </div>
                </div>
                <?php } ?>
                <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                </div>
                <?php if(isset($dagsprem->concession)){ ?>
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label for="title">Is ST/SC/Widows/Person with disabilities?</label>
                    </div>
                    <div class="form-group col-md-6">
                        <?php if($dagsprem->concession =='YES') { ?>
                        <label for="html">YES</label>
                        <?php } else if ($dagsprem->concession =='NO') { ?>
                        <label for="css">NO</label>
                        <?php } ?>
                        <br>
                    </div>

                </div>
                <?php } ?>
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                    </div>
                    <div class="form-group col-md-6">
                        <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                        <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                        <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                    </div>
                </div>
                <hr>
            <?php }?>

                <div class="tableCard">
                    <div class="row">
                        <div class="form-group col-md-6  text-primary">
                            <label for="title">Final Amount</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->final_amount?>" readonly>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 ">
                            <label for="title">Payment Mode</label>
                        </div>
                        <div class="form-group col-md-6">
                            <?php if($dagsprem->is_full_pay =='YES') { ?>
                                <label for="html">Full Payment</label>
                            <?php } else if ($dagsprem->is_full_pay =='NO') { ?>
                                <label for="css">30% Down Payment</label>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 text-danger">
                            <label for="title">Total Due</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" id="premAmount" class="form-control" name="totaldue" id="totaldue"  value="<?=$dagsprem->due_amount?>" readonly>
                        </div>

                    </div>
                </div>
            </div>
    </div>

<?php } ?>