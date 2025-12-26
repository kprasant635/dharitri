<div class="tableCard " style="padding: 25px!important;">
    <?php foreach ($premium_data as $dagsprem) {?>
        <div class="row">
            <div class="form-group col-md-6 ">
                <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

            </div>
            <div class="form-group col-md-6">

                <input type="number" name="zonal_<?=$dagsprem->dag_no?>" id="zonal_<?=$dagsprem->dag_no?>"
                       class="form-control"
                       value="<?=$dagsprem->zonal_valuation?>" readonly/>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6 ">
                <label>Selected Area</label>

            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="prem" name='a<?=$dagsprem->dag_no?>' value="<?=$dagsprem->area?>" readonly>

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 ">
                <label for="title">Purpose of Land</label>

            </div>
            <div class="form-group col-md-6 ">
                <input type="text" class="form-control" name='land<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_type?>" readonly>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 ">
                <label for="title">Encroached land type</label>

            </div>
            <div class="form-group col-md-6 ">
                <input type="text" class="form-control" id="prem" name='rate_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->house_type?>" readonly>

            </div>
        </div>
        <div class="row" id="p<?=$dagsprem->dag_no?>">
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
                <input id="f<?=$dagsprem->dag_no?>" type="hidden" class="f<?=$dagsprem->dag_no?>" value="" name="f<?=$dagsprem->dag_no?>" />
                <input id="t<?=$dagsprem->dag_no?>" type="hidden" class="t<?=$dagsprem->dag_no?>" value="" name="t<?=$dagsprem->dag_no?>" />
                <input type="text" class="form-control" value="<?=$dagsprem->amount_dag?>" name="a<?=$dagsprem->dag_no?>" readonly />
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
                <input type="text" class="form-control" name="f" id="f" value="<?=$dagsprem->final_amount?>" readonly>
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
                <input type="text" class="form-control " name="t" id="t"  value="<?=$dagsprem->due_amount?>" readonly>
            </div>

        </div>
    </div>
</div>