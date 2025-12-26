<!-- Masud's CSS-->
<style>
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard {
        margin: 10px auto;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
        padding-top: 10px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }


    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005B96 !important;
        text-decoration: none;
    }
    .wizard li.active{
        background: #005B96;
        padding: 0px;
        box-shadow: 1px 0px 1px 1px;

    }

    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 45%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #ffffff;
    }

    .wizard .nav-tabs > li a {
        text-align: center;
        /* width: 90%; */
        margin-bottom: 10px;
        /* padding: 0; */
    }
    .wizard .nav-tabs > li a:hover {
        background-color: transparent !important;
    }


    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }



</style>

<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 15px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        padding-bottom: -1px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
</style>

<style>
    .timeline {
        max-width: 830px;
        margin: 0px auto;
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 15px 0px;
    }
    .timeline::after {
        content: "";
        position: absolute;
        width: 3px;
        background-color: #848892;
        height: 100%;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
    }
    .timeline__content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 18px 30px;
        background-color: white;
        border-radius: 5px;
        position: relative;
        width: 386px;
        box-shadow: 0 2px 8px 0 #242e4c59;
    }
    .timeline__content::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: white;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
    }
    .timeline__content::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        /*background-color: #848892;*/
        border-radius: 50%;
        transform: translateY(-50%);
    }
    .timeline__content:nth-child(odd) {
        margin-left: auto;
    }
    .timeline__content:nth-child(odd) .content_tag {
        right: 5px;
    }
    .timeline__content:nth-child(odd)::after {
        left: -10px;
    }
    .timeline__content:nth-child(odd)::before {
        top: 50%;
        left: -39px;
    }
    .timeline__content:nth-child(even) {
        align-items: flex-end;
    }
    .timeline__content:nth-child(even) .content_p {
        text-align: right;
    }
    .timeline__content:nth-child(even)::after {
        right: -10px;
    }
    .timeline__content:nth-child(even)::before {
        top: 50%;
        right: -39px;
    }
    .timeline__content:nth-child(even) .content_tag {
        left: 5px;
    }

    .content_tag {
        position: absolute;
        top: 5px;
        padding: 6px 10px;
        background-color: #66BB6A;
        border-radius: 3px;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
        text-transform: capitalize;
    }

    .content_date {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #848892;
    }
    .content_Name {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #673AB7;
    }
    .content_p {
        color: #242e4c;
        max-width: 230px;
        margin-bottom: 20px;
    }
    .content_link {
        display: inline-flex;
        text-decoration: none;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
    }
    .content_link svg {
        margin-left: 5px;
    }
    .content_link:hover {
        color: royalblue;
        transition-duration: 300ms;
    }
    .content_link:hover svg path {
        fill: royalblue;
    }



    @media screen and (max-width: 600px) {
        .timeline {
            gap: 15px;
            padding: 10px;
        }
        .timeline::after {
            display: none;
        }
        .timeline__content {
            width: 100%;
        }
        .timeline__content::after {
            display: none;
        }
        .timeline__content::before {
            display: none;
        }
    }
</style>

<style>
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
        border: 1px solid #999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative;
    }
    .tree li::before,
    .tree li::after {
        content: "";
        left: -20px;
        position: absolute;
        right: auto;
    }
    .tree li::before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px;
    }
    .tree li::after {
        border-top: 1px solid #999;
        height: 20px!important;
        top: 25px;
        width: 25px;
    }
    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #999;
        border-radius: 5px;
        display: inline-block;
        padding: 3px 8px;
        text-decoration: none;
    }
    .tree li.parent_li > span {
        cursor: pointer;
    }
    .tree > ul > li::before,
    .tree > ul > li::after {
        border: 0;
    }
    .tree li:last-child::before {
        height: 46px;
    }
    .tree li.parent_li > span:hover,
    .tree li.parent_li > span:hover + ul li span {
        background: #eee;
        border: 1px solid #94a0b4;
        color: #000;
    }


    .rezaSpan{
        min-width: 140px;
        padding-left: 15px;
    }
    .rezaSpanB{
        min-width: 100px;
        padding-left: 15px;
    }
    .rezaCaseSpan{
        min-width: 270px;
        padding-left: 15px;
    }
    .rezaCaseSpanTotal{
        min-width: 270px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanBTotal{
        min-width: 100px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanTotal{
        min-width: 140px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }



    .badge-reza1{
        background-color: #F44336;
    }
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #9C27B0;
    }


</style>

<script>
    $(document).ready(function () {
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);

            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);

        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }

</script>


<div class="container">
    <div class="row">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>

        

        <section>

            
                <?php
                $sl_count = 1;
                ?>
                <div class="tab-content">

                    <?php
                      include(APPPATH."views/reclass_suite/common/applicationreclassSuiteViewApi.php");
                    ?>

                        <div class="reza-card">
                            <div class="reza-body">
                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> Proceeding Details
                                </h5>

                                <div class="tableCard ">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Date of remark</th>
                                            <th>From</th>
                                            <th>Remark</th>
                                        </tr>
                                        <?php $i = 1;foreach ($proceedings as $pro): ?>
                                            <tr>
                                            <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                                <td><?=$pro->office_from;?></td>
                                                <td><span class="text-success"><?=$pro->note_on_order;?></span></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </table>
                                </div>
                        

     

        
                    <div class="clearfix"></div>
                    <?php if(!empty($premium_data)) { ?>
                
                            <div class="reza-card ">
                                <div class="reza-body">

                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-money" aria-hidden="true"></i> Premium Calculation
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


                                </div>
                            </div>


                
                    <?php } ?>


                </div>
      
        </section>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    function skForward()
    {
        let remark_co = document.forms["sk_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text_sk").val();


        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }
        if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
    }


    function lm_Revert(){
        let remark_co = document.forms["co_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text").val();


        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            // $('#lm_revert_btn').prop('disabled', false);
            // $('#lm_revert_btn').val('Revert Back to LM');
            $("#remark_co").focus();
            return false;
        }
        else if (remark_co_text == "") {
            alert("Enter remark.");
            // $('#lm_revert_btn').prop('disabled', false);
            // $('#lm_revert_btn').val('Revert Back to LM');
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();
            // $('#lm_revert_btn').prop('disabled', true);
            // $('#lm_revert_btn').val('Reverting...');
        }
        
    }

    function dc_forward(){
        let remark_co = document.forms["co_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text").val();

        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }else if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();

            // $('#frwrd_dc_btn').val('Forwarding...');
        }
    }

    $(document).ready(function(){
        $("#reverttolm").click(function() {
            $("#lm_revert_btn").removeAttr("disabled");
            $("#frwrd_dc_btn").attr("disabled", true);
        });

        $("#frwrdtodc").click(function() {
            $("#frwrd_dc_btn").removeAttr("disabled");
            $("#lm_revert_btn").attr("disabled", true);
        });
    });

</script>


<script>
    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
    function autoRemark(){

        var remark_val = $.trim($('#remark_co').val());
        var case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no': case_no,
        };

        if(remark_val == 1){

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            $.ajax({
                url: baseurl+'ReclassSuiteControllerCO/checkRuralUrban',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                    if(arr.responseType == 0){
                        showErrorMessage(arr.msg);
                    }else{
                        //append auto remark in the text area
                        const areaDeatils = [];
                        for(i=0; i<arr.area.length; i++){
                            var areaData = "covered by Dag no " +arr.area[i].dag_no+ " from " + arr.area[i].exist_land_class_name
             + " to " + arr.area[i].proposed_land_class_name;

                            areaDeatils.push(areaData);
                        }

                        var finalArea = areaDeatils.toString();
                        var circleName = arr.circleName;
                        var villageName = arr.villageName;
                        var mouzaName = arr.mouzaName;
                        var khasmaxrural = "<?=KHAS_RURAL_MAX?>";

                        if(arr.isUrban == 'Y'){
                            $('#remark_co_text').val("Perused LRA report.  Checked all the documents submitted by the applicant along with report/certificate from line dept and are found in order as per provision of the Act . The land is in undisputed possession, without any ongoing litigation. The application for reclassification of land "+ finalArea +" is recommended for approval, subject to the conditions mentioned above. The necessary premium as per the mentioned notification should be realized before the reclassification is finalized.");
                        }
                        else if(arr.isUrban == 'N')
                        {
                            $('#remark_co_text').val("Perused LRA report.  Checked all the documents submitted by the applicant along with report/certificate from line dept and are found in order as per provision of the Act . The land is in undisputed possession, without any ongoing litigation. The application for reclassification of land "+ finalArea +" is recommended for approval, subject to the conditions mentioned above. The necessary premium as per the mentioned notification should be realized before the reclassification is finalized.");
                        }
                    }
                }
            });


        }

        if(remark_val != 1){
            $('#remark_co_text').val('');
        }

    }
</script>

<script>

    function rejectSubAlert()
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to Reject this case?',
            html: 'You wont be able to undo this once done',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

        var case_no = $('#case_no').val();
        showNewDirectRejectModalMb2(''+case_no+'','<?php echo SETTLEMENT_KHAS_LAND_ID ?>');

        // $('#co_rejection_agree').val('co_rejection_agree');
        // $('#co_form_sub').submit();

    }
    })

    }

    function revertSubAlert()
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you disagree with LM rejection and want revert to LM to reverify?',
            html: 'You wont be able to undo this once done',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, revert it',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                afterSubmitSanitization();
                $('#co_rejection_disagree').val('co_rejection_disagree');
                $('#co_form_sub').submit();
            }
    })
    }
</script>


<script>
    // Function to show lm report using AJAX
    function showLmReport(popupId) {

        var case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no': case_no,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementCommon/getLmReport',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);
                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }else{
                    // alert(arr.lmnotes.chitha_verified); return;

                    if(arr.lmnotes.chitha_verified == 'YES'){
                        $("#chiitha_verified1").attr('checked', 'checked');
                    }else{
                        $("#chiitha_verified2").attr('checked', 'checked');
                    }

                    if(arr.lmnotes.vlb_verified == 'YES'){
                        $("#vlb_verified1").attr('checked', 'checked');
                    }else{
                        $("#vlb_verified2").attr('checked', 'checked');
                    }


                    const linkContainer = $('#vlbdag');
                    for(var i = 0; i < arr.dags.length; i++)
                    {

                        const link = $('<a>', {
                            href: baseurl+'SettlementTribal/vlbEncroacherDetails?dag='+arr.dags[i].dag_no+'&m='+arr.basic.mouza_pargona_code+'&l='+arr.basic.lot_no+'&v='+arr.basic.vill_townprt_code+'&dist='+arr.basic.dist_code+'&cir='+arr.basic.cir_code+'&sub_div='+arr.basic.subdiv_code+'',
                            text: 'Dag ' + (arr.dags[i].dag_no) + '(VLB)',
                            target:'_blank'
                        });

                        linkContainer.append(link).append('<br>');
                    }


                }
            }
        });
    }

</script>

<script>
        // Get today's date in the format YYYY-MM-DD
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(today.getDate()).padStart(2, '0');
        const currentDate = `${year}-${month}-${day}`;
        
        // Set the minimum date to today
        const datePickernew = document.getElementById('datePickernew');
        datePickernew.min = currentDate;
        datePickernew.value = currentDate; // Optionally pre-fill with the current date
    </script>

    <!-- <script type="text/javascript">
    $(document).ready(function () 
    {
        $(".hearingshow").hide();
        $("#frwrd_ast_btn").click(function () 
        {
            $(".hearingshow").show();
        });
    });
    </script> -->

