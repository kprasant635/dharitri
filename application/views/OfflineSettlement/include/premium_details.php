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

        <div class="row">
            <div class="form-group col-md-6 ">
                <label>Selected Area</label>

            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="prem_area" name='area<?=$dagsprem->dag_no?>' value="<?=$dagsprem->area?>" readonly>

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 ">
                <label for="title">Purpose of Land</label>

            </div>
            <div class="form-group col-md-6 ">
                <input type="text" class="form-control" name='land_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_type?>" readonly>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 ">
                <label for="title">Encroached land type</label>

            </div>
            <div class="form-group col-md-6 ">
                <input type="text" class="form-control" id="prem_landtype" name='rate_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->house_type?>" readonly>

            </div>
        </div>
        <div class="row" id="percentage<?=$dagsprem->dag_no?>">
        </div>
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
        <div class="row">
            <div class="form-group col-md-6 ">
                <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
            </div>
            <div class="form-group col-md-6">
                <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                <?php if($dagsprem->ratetype=='R') { ?>
                    <span><b>(Amount: Rs @100/bigha based on above selected area)</b></span>
                <?php }?>
            </div>
        </div>
    <?php }?>

    <div class="tableCard" style="padding: 25px!important;">
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

                <br>
            </div>

        </div>

        <div class="row">
            <div class="form-group col-md-6 text-danger">
                <label for="title">Total Due</label>
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control " name="totaldue" id="totaldue"  value="<?=$dagsprem->due_amount?>" readonly>
            </div>

        </div>
    </div>
</div>