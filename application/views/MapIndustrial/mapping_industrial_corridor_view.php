<style>
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
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
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
    .rezaText {
        font-size: 16px;
    }

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }

    .reza-title2{
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
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
    .labDiv{
        margin-bottom: 15px;
    }
    .lab{
        margin-bottom: 5px;
    }
    .landDetails{
        display: none;
    }

    .mmm{
        font-weight: bold;
        margin-top: 3px!important;
    }
    .nnn{
        margin-top: 5px!important;
    }
    .form-check-input {
        width: 20px!important;
        height: 20px!important;
    }


    .form__input{
        padding: 18px 15px!important;

    }
</style>

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
        margin-top: -10px;
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


    .rezaI{
        padding: 15px;
        min-width: 75px!important;
        max-width: 75px!important;
    }
    .reza{
        padding: 15px;
    }


</style>

<?php
$max_bigha_home = MAX_BIGHA;
$max_bigha_agri = MAX_BIGHA;
?>

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

<div class="row" style='padding-top: 15px; margin-bottom: 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <a href="<?= base_url()?>index.php/MapIndustrialCorridorController/firstLandingPageMappingInCorridor">
            Mapping of Industrial Corridor
        </a>
        / Mapping Dags

        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
        </a>

        <?php if($this->session->flashdata('success')) { ?>
            <br>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <br>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>
</div>

<div class="row">
    <form id="myForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url()?>index.php/MapIndustrialCorridorController/submitMappingDags">
        <h5 class="bg-info p-2 text-white shadow">
            <span> Mapping of Industrial Corridor</span>
        </h5>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="reza-card" style="margin-bottom: 25px; padding-top: 5px">
                    <div class="reza-body">
                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 5px">
                                <i class="fa fa-map-signs" aria-hidden="true"></i> Location Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label class="lab" for="sel1">District:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="dist_code" class="form-control districtselect" id="d" required>
                                        <?php $dist_code=$this->session->userdata('dist_code');?>
                                        <option value="<?php echo $dist_code;?>"  selected>
                                            <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                        </option>

                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label class="lab"  for="sel1">Sub-Div:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="subdiv_code"  class="form-control subdivselect"  id="sd" required>
                                        <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                        <option value="<?php echo $subdiv_code;?>"  selected>
                                            <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label class="lab"  for="sel1">Circle:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="cir_code"  class="form-control circleselect" id="c"  required>
                                        <?php $cir_code=$this->session->userdata('cir_code');?>
                                        <option value="<?php echo $cir_code;?>"  selected>
                                            <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                        </option>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label class="lab" for="sel1">Mouza/Porgona:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select class="form-control mouzaselect" id="m" required name="mouza_pargona_code">
                                        <option disabled selected>Select Mouza</option>
                                        <?php foreach ($mouzaList as $val) { ?>
                                            <option value="<?php echo $val->mouza_pargona_code; ?>"  >
                                                <?php echo $val->loc_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label class="lab" for="sel1">Lot :<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select class="form-control lotselect" id="l" name="lot_no" required>
                                        <option disabled selected>Select Lot No</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label class="lab" for="sel1">Village:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select class="form-control villageselect" id="v" name="vill_townprt_code" required>
                                        <option disabled selected>Select Village/Town</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-map" aria-hidden="true"></i> Dag Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Select Dags for Mapping of Industrial Corridor :<span style="color: red;font-weight: bold;"> *</span></label>
                                    <div class="col-lg-12 dag_list">
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" class="form-control" id='patta_no' name='patta_no' >
                            <input type="hidden" class="form-control" id='patta_type_code' name='patta_type_code'>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 40px">
                                <button type="button" class="rezaButt buttPrimary" id="applicationSubmit">
                                    <i class="fa fa-check-square-o"></i> SUBMIT
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal submit application -->
<div class="modal" role="dialog" id="submitApplicationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to submit this Dags </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="submitApplicationModalYes">Yes, Submit</button>
            </div>
        </div>
    </div>
</div>


<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }


    // get dag list
    $('#v').change(function ()
    {
        var dis = $('#d').val();
        var subdiv = $('#sd').val();
        var cir = $('#c').val();
        var mza = $('#m').val();
        var lot = $('#l').val();
        var vill=$('#v').val();
        var pattatype= $(this).val();
        $('.landDetails').hide();

        $.ajax({
            url: BASE_URL + "/OfflineSettlementRegisterController/getDagList",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#pattano').prop('selectedIndex', 0);

            },
            success: function (data)
            {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    var html = '';
                    var i;
                    // html += '<option value="">Please selects</option>';
                    var template = '';
                    for (i = 0; i < data['test'].length; i++)
                    {
                        var dagNo = data['test'][i].dag_no;
                        var dag_no_int = data['test'][i].dag_no_int;
                        // html += '<option value=' + dagNo + "@" +dag_no_int + '>' + dagNo + '</option>';

                        template += '<div class="form-check form-check-inline rezaI">'+
                            '<input class="form-check-input reza" type="checkbox" name="selectedDags[]" id="inlineCheckbox1'+dag_no_int+'" value="' + dagNo + "@"+dag_no_int + '">' + dagNo + '</div>';
                    }

                    $('.dag_list').html(template);

                }

            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                $('#dagno').prop('selectedIndex', 0);
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
        return false;
    });


    var district = $('#district').val();


    // application submit confirmation
    $(document).on('click','#applicationSubmit',function ()
    {
        $('#submitApplicationModal').modal('show');
    });

    $(document).on('click','#submitApplicationModalNo',function ()
    {
        $('#submitApplicationModal').modal('hide');
    });

    // application submit
    $(document).on('click','#submitApplicationModalYes',function ()
    {
        $('#myForm').submit();
        $('#submitApplicationModal').modal('hide');
    });



</script>


