<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="color:green; font-weight: bold; margin-bottom: 25px;">
        Joint Applicant 1
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right" style="margin-bottom: 25px;">
        <button type="button" class="rezaButt buttInfo" id="addMorePattadarFun">Add More Applicant</button>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Name in English<span style="color: red;font-weight: bold;"> *</span></label>
        <input type="text" class="form-control" id='jointApplicantNameEng' name='jointApplicantNameEng' onkeydown="return /[a-z, ]/i.test(event.key)">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Name in Assamese<span style="color: red;font-weight: bold;"> *</span></label>
        <input type="text" class="form-control   search-box" id='jointApplicantNameAss' name='jointApplicantNameAss' >
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Guardian Name in English<span style="color: red;font-weight: bold;"> *</span></label>
        <input type="text" class="form-control" id='jointGuardianNameEng' name='jointGuardianNameEng' onkeydown="return /[a-z, ]/i.test(event.key)">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Guardian Name in Assamese<span style="color: red;font-weight: bold;"> *</span></label>
        <input type="text" class="form-control   search-box" id='jointGuardianNameAss' name='jointGuardianNameAss' >
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Guardian Relation<span style="color: red;font-weight: bold;"> *</span></label>
        <select name="jointGuardianRelation" id="jointGuardianRelation" class="form-control">
            <option selected value="">Select</option>
            <?php foreach(json_decode(RELATION_NEW_APPL) as $r) { ?>
                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Date of Birth (dd/mm/yyyy)<span style="color: red;font-weight: bold;"> *</span></label>
        <input type="date" class="form-control" id='jointDob' name='jointDob'  max="<?php echo date("Y-m-d");?>" >
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
        <label for="sel1" class="lab">Mobile No.<span style="color: red;font-weight: bold;"> *</span></label>
        <input type="text" class="form-control" id='jointMobileNo' name='jointMobileNo' oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv" >
        <label for="sel1" class="lab"> Occupation <span style="color: red;font-weight: bold;"> *</span></label>
        <select name="jointOccupation" class="form-control occupation" id='jointOccupation'>
            <option selected value="">Select</option>
            <?php foreach(json_decode(OCCUPATION_NEW_APPL) as $occ) { ?>
                <option value="<?=$occ->CODE?>"><?=$occ->NAME?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row" style="padding-left: 15px;padding-right: 15px">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
            <label for="sel1" class="lab">Gender<span style="color: red;font-weight: bold;"> *</span></label>
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input nnn " type="radio" name="jointGender"  id="jointGender1"  value="1" />
                <label class="form-check-label mmm " for="inlineRadio1"><?php echo $this->lang->line('m'); ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input nnn " type="radio" name="jointGender"  id="jointGender2" value="2"  />
                <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('f'); ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input nnn " type="radio" name="jointGender"  id="jointGender3" value="3"  />
                <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('o'); ?></label>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        <?php
        if(!isset($pattaCount)){
            $pattaCount = 1;
        }
        if(isset($err_return)){
        for($i = 0; $i < $pattaCount; $i++)
        {
        ?>

        <?php } } ?>

        var counterP = 1;
        $("#addMorePattadarFun").click(function (e)
        {

            counterP++;
            console.log(counterP);
            $('#pattadarCounter').val(counterP);
            e.preventDefault();
            $("#fieldList").append(
                ''
            );

        });

        $(document).on('click', '.deleteAddMore', function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });

    });

</script>