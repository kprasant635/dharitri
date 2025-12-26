<!--////////////////////// edit for property chain ////////////-->


<input type="hidden" name="ulpinCheckFlag" id="ulpinCheckFlag" value="<?=isset($ulpinCheck) ? $ulpinCheck : "" ?>" />
<input type="hidden" name="compareCheckFlag" id="compareCheckFlag" value="<?=isset($chithaPropChainCmpFlag) ? $chithaPropChainCmpFlag : "" ?>" />
<input type="hidden" name="ulpin" id="ulpin" value="<?=isset($ulpin) ? $ulpin : "" ?>" />
<input type="hidden" name="chain_revenue" id="chain_revenue" value="<?=isset($revenue) ? $revenue : "" ?>" />
<input type="hidden" name="chain_local_tax" id="chain_local_tax" value="<?=isset($local_tax) ? $local_tax : "" ?>" />
<?php if (isset($old_ulpin)) { ?>
    <input type="hidden" name="old_ulpin" id="old_ulpin" value="<?=isset($old_ulpin) ? $old_ulpin : "" ?>" />
<?php } ?>

<div class="row">
    <div class="d-flex flex-column justify-content-center" style="margin-bottom:5px ;">
        <?php
        $redirectURLForNotValid = 'N';
        if ($chithaPropChainCmpFlag != 'Y' && $chithaPropChainCmpFlag != 'N' && $chithaPropChainCmpFlag != 'NE') {
            echo "<p><h6 class='text-center'>You will be redirected to pending field mutation cases page in 5 seconds</h6></p>";
            header("refresh:5;url=" . base_url() . "index.php/home");
            $redirectURLForNotValid = 'Y';
        }

        ?>
    </div>
</div>


    <?php if ($chithaPropChainCmpFlag == 'N') {
        echo $viewMisMatchBtn;
        $buttonEnabledFlag = 0;
    } ?>

<?php if (isset($ulpinCheck) && $ulpinCheck == 1 && $chithaPropChainCmpFlag == 'NE') { ?>
<div class="row ">
    <div class="justify-content-center" style="margin-bottom:5px ;">
        <div class="col-md-12" style="border: 2px solid #e5e5e5;border-radius: 9px;">
            <div class="col-md-9">
                <h5 style="border-bottom:3px solid #ff681d">NOTE : If you want to push the dag to BlockChain before order pass, click this button <i class="fa fa-arrow-circle-right"></i> </h5>
            </div>
            <div class="col-md-3 text-center" style="margin-top: 22px;">
                <?php foreach ($createPropChainBtn as $key => $btn) {?>

                    <?=isset($btn) ? $btn : "" ;
                    echo "<hr>";?>

                <?php }?>
                
                   
                
            </div>
        </div>
    </div>

</div>
<?php } ?>