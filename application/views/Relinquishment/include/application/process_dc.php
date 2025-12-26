<div class="tableCard">
    <?php $enAppNo = $this->utilityclass->encryptJwtCase($basic->case_no);?>
    <form id="myForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url()?>index.php/RelinquishmentDcController/relinquishmentApplicationForwardToCo">
        <input type="hidden" id="appNo" name="appNo" value="<?php echo $enAppNo ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 labDiv" style="margin-bottom: 20px">
                <label for="sel1" class="lab" style="margin-bottom: 10px">
                    Application Forward To CO for Chitha Update <span style="color: red;font-weight: bold;"> *</span>
                </label>
                <select name="forwardTo"  class="form-control" id="forwardTo" required>
                    <option disabled selected>Select</option>
                    <option value="CO">
                        CO
                    </option>
                </select>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv" style="margin-bottom: 20px">
                <label for="sel1" class="lab" style="margin-bottom: 10px">Remarks<span style="color: red;font-weight: bold;"> *</span></label>
                <textarea name="remarks" id="remarks" class="form-control" rows="4" required> </textarea>
            </div>
        </div>
        <?php if($areaCheck == 1): ?>
            Applied Area more than chitha
        <?php elseif($areaCheck == 2): ?>
            Applied Area Cannot be Zero
        <?php elseif($areaCheck == 0): ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 40px; margin-bottom: 15px">
                    <button type="button" class="rezaButt buttPrimary" id="applicationSubmit">
                        <i class="fa fa-check-square-o"></i> Forward, APPLICATION
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>