<div class="tableCard">
    <?php $enAppNo = $this->utilityclass->encryptJwtCase($basic->case_no);?>
    <form id="myForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url()?>index.php/RelinquishmentDcController/relinquishmentApplicationGenerateNotice">
        <input type="hidden" id="appNo" name="appNo" value="<?php echo $enAppNo ?>">
        <input type="hidden" id="forwardTo" name="forwardTo" value="NA">
        <input type="hidden" id="remarks" name="remarks" value="NA">
        <br>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv" style="margin-bottom: 20px">
            <label for="sel1" class="lab" style="margin-bottom: 10px">Hearing Date <span style="color: red;font-weight: bold;"> *</span></label>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv" style="margin-bottom: 20px">
            <input type="date" name="hearingDate" id="hearingDate" class="form-control" required >
        </div>
        <?php if($areaCheck == 1): ?>
            <div style="font-weight: bold; font-size: 18px; color: #B71C1C; margin-bottom: 15px">
                Applied Area more than chitha Area
            </div>
        <?php elseif($areaCheck == 2): ?>
            <div style="font-weight: bold; font-size: 18px; color: #B71C1C; margin-bottom: 15px">
                Applied Area Cannot be Zero
            </div>
        <?php elseif($areaCheck == 0): ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 40px; margin-bottom: 15px">
                    <button type="button" class="rezaButt buttPrimary" id="applicationSubmit">
                        <i class="fa fa-file-pdf-o"></i> &nbsp;Notice Generate
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>