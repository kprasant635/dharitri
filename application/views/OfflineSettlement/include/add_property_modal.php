<div class="row p-2" >
    <div class="col-md-6">
    <span><strong><?=$sl_count++?>.</strong>
    Whether applicant and his/her family has occupied any land in the state ?</span>
        <?=form_error('is_landless')?>
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
        <select name="is_landless" id="is_landless" class="form-control <?php if(form_error('is_landless')){echo 'lm_invalid';}?>" onchange="openSelectAddPropertyModal()">
            <option value="">Select Land Category</option>

            <option value="YES" <?php if(isset($err_return)){ if (set_value('is_landless') == 'YES') { echo "selected"; }}?> class="completely_landless">Completely Landless</option>

            <option value="NO" <?php if(isset($err_return)){ if (set_value('is_landless') == 'NO') { echo "selected"; }}?>>Landless as per land policy</option>

            <option value="OTHERS" <?php if(isset($err_return)){ if (set_value('is_landless') == 'OTHERS') { echo "selected"; }}?>>Having Land</option>
        </select>
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
        <?php if(!empty($additional_property)) { ?>
            <button class="btn btn-sm btn-warning btnServerAddProperty" onclick="openAddPropertyModal()" type="button"><i class="fa fa-university"></i>&nbsp;View Property</button>
        <?php } ?>

        <button class="btn btn-sm btn-warning btnJsAddProperty" onclick="openAddPropertyModal()" style="display:none" type="button"><i class="fa fa-university"></i>&nbsp;View Property</button>

    </div>
</div>


<style>

    @media (max-width: 480px) {
        .modal-dialog {
            max-width: 94%;
            margin: 1.75rem auto;
        }
    }
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 850px;
            margin: 1.75rem auto;
        }
    }

</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<div id="myModalAdditionalProperty" class="modal">

    <div class="modal-content">

        <div class="modal-header" style="color:#fff; background-color:#176d84; font-weight: bold; border: none">
            Enter Property Availability Detail in other District
            <span class="px-4" style="cursor: pointer;" onclick="btnCloseProperty()">&times;</span>
        </div>

        <div class="modal-body">
            <div class="row">
                <div id="additional_property" >
                    <input type="hidden" name="application_no" id="application_no" value="<?php if($basic->service_code == '14')
                    { echo $_GET['app']; }else{ echo $this->utilityclass->decryptJwtCase($_GET['app']); }?>">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <!-- <span id="additional_districtErr" class="__error__msg"></span> -->
                            <div id="additional_districtErr"></div>
                            <div class="form__div">
                                <select name="additional_district_code" class="form-control  form_select ps-3 additional_mselect property_add_reset"
                                        id='additional_district' data-placeholder="<?php echo $this->lang->line('district');?>" data-allow-clear="1">
                                    <option selected value=""><?php echo $this->lang->line('district');?></option>
                                    <?php foreach ($district_all as $key => $dist) { ?>
                                        <option value="<?php echo $dist->district_code; ?>">
                                            <?php echo $dist->district_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span id="additional_circleErr" class="__error__msg"></span>
                            <div class="form__div">
                                <select name="additional_circle" class="form-control  ps-3 additional_mselect property_add_reset" id="additional_circle">
                                    <option value="">Select Circle<span style="color: red;">*</span></option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span id="is_additional_urbanErr" class="__error__msg"></span>
                            <div class="form__div">
                                <div class=" ps-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_additional_urban" checked id="is_additional_urban" value="N" checked>
                                        <label class="form-check-label" for="inlineRadio3">Rural</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_additional_urban" id="is_additional_urban" value="Y">
                                        <label class="form-check-label" for="inlineRadio4">Urban</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <div class="additional_villageErr"></div>
                            <div class="form__div">
                                <select name="additional_village" id="additional_village"
                                        class=" form-control ps-3 additional_mselect">
                                    <option value="">Select Village </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                            <span id="additional_dagErr" class="__error__msg"></span>
                            <div class="form__div">
                                <select name="additional_dag" class=" form-control ps-3 additional_mselect property_add_reset" id="additional_dag" data-placeholder="<?php echo $this->lang->line('dag');?>" data-allow-clear="1">
                                    <option value="">Select Dag<span style="color: red;">*</span></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                            <input type="text" name="additional_patta" class="form-control property_add_reset"
                                   id='additional_patta' readonly placeholder="Patta No">
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>

                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                            <span id="additional_bighaErr" class="__error__msg"></span>
                            <input type="text" name="additional_bigha" class=" form-control property_add_reset"
                                   oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                                   id='additional_bigha' placeholder="Bigha">
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                            <span id="additional_kathaErr" class="__error__msg"></span>
                            <input type="text" name="additional_katha" class=" form-control property_add_reset"
                                   oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                                   id='additional_katha' placeholder="Katha">
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                            <span id="additional_lessaErr" class="__error__msg"></span>
                            <input type="text" name="additional_lessa" class="form-control property_add_reset"
                                   oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                                   id='additional_lessa' placeholder="Lessa/Chatak">
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 karimganj_div">&nbsp;</div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 in_ganda_div" style="display:none">
                            <span id="additional_gandaErr" class="__error__msg"></span>
                            <input type="text" name="additional_ganda" class="form-control property_add_reset"
                                   oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                                   id='additional_ganda' placeholder="Ganda">
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 in_kranti_div" style="display:none">
                            <span id="additional_krantiErr" class="__error__msg"></span>
                            <input type="text" name="additional_kranti" class="form-control property_add_reset"
                                   oninput="this.value = this.value.replace(/[^0-9\.]/g,'')"
                                   id='additional_kranti' placeholder="Kranti">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 pull-right">
                        <button class="btn btn-sm btn-primary" type="button" id="submitproperty">Submit</button>
                        <input type="hidden" id="service_code" value="">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px; margin-bottom: 15px"><hr></div>

                <div class="table-responsive additionalPropertyTable">
                    <h5>Additional Property List</h5>
                    <table class="table table-striped table-bordered" id="addProperty">
                        <thead>
                        <tr class="text-bold table-success">
                            <th>District</th>
                            <th>Circle</th>
                            <th>Bigha</th>
                            <th>Katha</th>
                            <th>Lessa/Chatak</th>
                            <th>Ganda</th>
                            <th>Kranti</th>
                            <th>Delete</th>
                        </tr>
                        </thead>

                        <tbody id="propertyDetail">
                        <?php if(isset($additional_property)) {
                            foreach ($additional_property as $key => $row) { ?>
                                <tr id="prop<?php echo $row->id;?>" class="table_list">
                                    <td><?php echo $row->dist_name;?></td>
                                    <td><?php echo  $row->cir_name;?></td>
                                    <td><?php echo $row->bigha;?></td>
                                    <td><?php echo $row->katha;?></td>
                                    <td><?php echo $row->lessa;?></td>
                                    <td><?php echo $row->ganda;?></td>
                                    <td><?php echo $row->kranti;?></td>
                                    <td>
                                        <?php if($row->applied_flag != CITIZEN) { ?>
                                            <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $row->id;?>)" class="btn btn-danger" id="delProperty">Delete</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    BARAK_VALLEY = new Array('21','22','23');

    // Get the modal
    var modal_additional_property = document.getElementById("myModalAdditionalProperty");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];


    window.onclick = function(event) {
        if (event.target == modal_additional_property) {
            modal_additional_property.style.display = "none";
        }
    };

    $('.chatak_title').hide();

    // additional property entry
    $(document).on('change', '#additional_district', function(){
        var district = $(this).val();
        if (district == '') {
            return;
        }
        // alert(district);
        if($.inArray(district, BARAK_VALLEY) == -1 ) { // other than barak valley
            $('.in_ganda_div').hide();
            $('.in_kranti_div').hide();
            $('.lessa_title').show();
            $('.chatak_title').hide();
            $('.karimganj_div').hide();
        }
        else { // for barak valley
            $('.in_ganda_div').show();
            $('.in_kranti_div').show();
            $('.lessa_title').hide();
            $('.chatak_title').show();
            $('.karimganj_div').show();
        }
        $('.lessa_title').show();

        $("#additional_bigha").attr("placeholder", "Bigha");
        $("#additional_katha").attr("placeholder", "Katha");
        $("#additional_lessa").attr("placeholder", "Lessa/Chatak");
        $("#additional_ganda").attr("placeholder", "Ganda");
        $("#additional_kranti").attr("placeholder", "Kranti");

        $.ajax({
            url: baseurl + "OfflineSettlementCommonController/getCircleOffline/" + district,
            success: function(data) {
                var Circle = JSON.parse(data);
                var template =
                    "<option selected value='' disabled>-- Select Circle --</option>";
                for (var i = 0; i < Circle.length; i++) {
                    template +=
                        "<option value='" +
                        Circle[i].cir_code +
                        "'>" +
                        Circle[i].loc_name +
                        " (" +
                        Circle[i].locname_eng +
                        ")</option>";
                }
                $("#additional_circle").html(template);
            },
            error: function(error) {
            }
        });
    });

    $("#additional_circle").change(function(e) {
// $(document).on('change', '#additional_circle', function(){
        if ($(this).val() == null) {
            return;
        }

        var district = $("#additional_district").val();
        var circle = $(this).val();
        var villcode = circle.split(",");
        // alert(circle);

        var circle = villcode[0];
        var subdiv = villcode[1];
        $("#additional_village").empty();
        $("#additional_dag").empty();
        $("#additional_bigha").val("");
        $("#additional_katha").val("");
        $("#additional_lessa").val("");
        $("#additional_ganda").val("");
        $("#additional_kranti").val("");
        var rural = $("input[name='is_additional_urban']:checked").val();

        // const loading = new Loading();
        $.ajax({
            url: baseurl +
            "OfflineSettlementCommonController/getVillageOffline/" +
            district +
            "/" +
            subdiv +
            "/" +
            circle +
            "/" +
            rural,
            success: function(data) {
                // loading.out();
                var village = JSON.parse(data);
                var template = "<option selected value='' disabled>-- Select Village --</option>";
                for (var i = 0; i < village.length; i++) {
                    template +=
                        "<option value='" +
                        village[i].vill_townprt_code +
                        "'>" +
                        village[i].loc_name +
                        "</option>";
                }
                //console.log(template);
                $("#additional_village").html(template);
            },
            error: function(error) {
                // loading.out();
            }
        });
    });

    // $("input[type=radio][name=is_additional_urban]").change(function() {
    $(document).on('click', 'input[type=radio][name=is_additional_urban]', function(){
        var district = $("#additional_district").val();
        var circle = $("#additional_circle").val();
        var villcode = circle.split(",");
        // alert(villcode);

        var circle = villcode[0];
        var subdiv = villcode[1];

        $("#additional_village").empty();
        $("#additional_dag").empty();
        $("#additional_bigha").attr("placeholder", "Bigha");
        $("#additional_katha").attr("placeholder", "Katha");
        $("#additional_lessa").attr("placeholder", "Lessa/Chatak");
        $("#additional_ganda").attr("placeholder", "Ganda");
        $("#additional_kranti").attr("placeholder", "Kranti");

        var rural = $("input[name='is_additional_urban']:checked").val();
        // const loading = new Loading();
        $.ajax({
            url: baseurl +
            "OfflineSettlementCommonController/getVillageOffline/" +
            district +
            "/" +
            subdiv +
            "/" +
            circle +
            "/" +
            rural,
            success: function(data) {
                // loading.out();
                //console.log(data);
                var village = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Village --</option>";
                for (var i = 0; i < village.length; i++) {
                    template +=
                        "<option value='" +
                        village[i].vill_townprt_code +
                        "'>" +
                        village[i].loc_name +
                        "</option>";
                }
                $("#additional_village").html(template);
            },
            error: function(error) {
                // loading.out();
            }
        });
    });

    $(document).on('change', '#additional_village', function(){
        if ($(this).val() == null) {
            return;
        }
        //alert("sddfghj"); return;
        var district = $("#additional_district").val();
        var circle = $("#additional_circle").val();
        var villcode = circle.split(",");

        var circle = villcode[0];
        var subdiv = villcode[1];
        var village = $(this).val();
        var villcode = village.split(",");
        // alert(villcode);

        if (villcode.length == 4) {
            var village = villcode[0];
            var mouza = villcode[2];
            var lot = villcode[3];
        } else {
            villcode = village.split(" ");
            var mouza = villcode[0];
            var lot = villcode[1];
            var village = villcode[2];
        }

        $("#additional_dag").empty();
        $("#additional_bigha").attr("placeholder", "Bigha");
        $("#additional_katha").attr("placeholder", "Katha");
        $("#additional_lessa").attr("placeholder", "Lessa/Chatak");
        $("#additional_ganda").attr("placeholder", "Ganda");
        $("#additional_kranti").attr("placeholder", "Kranti");

        // const loading = new Loading();
        $.ajax({
            url: baseurl +
            "OfflineSettlementCommonController/getAllDagsOffline/" +
            district +
            "/" +
            subdiv +
            "/" +
            circle +
            "/" +
            mouza +
            "/" +
            lot +
            "/" +
            village,
            success: function(data) {
                // loading.out();
                //console.log(data);
                var dag = JSON.parse(data);
                var template =
                    "<option value='' selected disabled>-- Select Dag--</option>";
                for (var i = 0; i < dag.length; i++) {
                    template +=
                        "<option value='" +
                        dag[i].dag_no_int +
                        "'>" +
                        dag[i].dag_no +
                        "</option>";
                }
                //console.log(template);
                $("#additional_dag").html(template);
            },
            error: function(error) {
                // loading.out();
            }
        });
    });

    $(document).on('change', '#additional_dag', function(){
        if ($(this).val() == null) {
            return;
        }
        var district = $("#additional_district").val();
        var circle = $("#additional_circle").val();
        var villcode = circle.split(",");
        // alert(villcode);

        var circle = villcode[0];
        var subdiv = villcode[1];
        var village = $("#additional_village").val();
        var villcode = village.split(",");
        // alert(villcode);

        if (villcode.length == 4) {
            var village = villcode[0];
            var mouza = villcode[2];
            var lot = villcode[3];
        } else {
            villcode = village.split(" ");
            var mouza = villcode[0];
            var lot = villcode[1];
            var village = villcode[2];
        }

        var dag = $(this).val();

        // const loading = new Loading();
        $.ajax({
            url: baseurl +
            "OfflineSettlementCommonController/getAreaAdditionalPro/" +
            district +
            "/" +
            subdiv +
            "/" +
            circle +
            "/" +
            mouza +
            "/" +
            lot +
            "/" +
            village +
            "/" +
            dag,
            success: function(data) {
                // loading.out();
                var area = JSON.parse(data);
                $("#additional_patta").val(area.patta_no);
            },
            error: function(error) {
                // loading.out();
            }
        });
    });

    function confirmDelete(id)
    {
        if(confirm("Are you sure you want to delete this Record?")){
            $.ajax({
                type: "POST",
                url: baseurl + "OfflineSettlementCommonController/additionalProDelete",
                async: false,
                data: {
                    property_id: id
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    if(data.status == 0) {
                        alert("something went wrong !");
                    }
                    else if(data.responseType == 3) {
                        alert(data.message);
                        $("#prop" + id).closest("tr").remove();
                    }
                    else {
                        alert("Property Successfully Deleted  !");
                        $("#prop" + id).closest("tr").remove();
                        $('.property_add_reset').val('');
                        $( "#additional_circle option:selected" ).val(null);
                        $( "#additional_village option:selected" ).val(null);
                        $( "#additional_circle option:selected" ).text('-- Select Circle --');
                        $( "#additional_village option:selected" ).text('-- Select Village --');

                        if(data.count == 0){
                            $('.btnServerAddProperty').hide();
                            $('.btnJsAddProperty').hide();
                        }

                    }
                }
            });
        }
    }

    $('#submitproperty').click(function(e){
        e.preventDefault();
        var ref_no = $("#application_no").val();
        var additional_district = $("#additional_district").val();
        var additional_circle = $("#additional_circle").val();
        var additional_bigha = $("#additional_bigha").val();
        var additional_katha = $("#additional_katha").val();
        var additional_lessa = $("#additional_lessa").val();

        var additional_ganda = $("#additional_ganda").val();
        var additional_kranti = $("#additional_kranti").val();

        var additional_district_name = $( "#additional_district option:selected" ).text();
        var additional_circle_name = $( "#additional_circle option:selected" ).text();
        var is_additional_urban = $("#is_additional_urban").val();
        var additional_village_code = $("#additional_village").val();
        var additional_dag = $("#additional_dag").val();
        var additional_patta = $("#additional_patta").val();
        var service_code = $("#service_code").val();
        var additional_village = $( "#additional_village option:selected" ).text();

        if(additional_circle == '' || additional_circle == null)
        {
            $('.additional_circleErr').fadeIn();
            $('.additional_circleErr').html('<span style="color: red">⚠️ The Circle is required</span>');
            $('#additional_circle').focus();
            return false;
        }

        if(additional_village_code == '' || additional_village_code == null)
        {
            $('.additional_villageErr').fadeIn();
            $('.additional_villageErr').html('<span style="color: red">⚠️ The Village is required</span>');
            $('#additional_village').focus();
            return false;
        }

        var villcode = additional_circle.split(",");
        var circle = villcode[0];
        var subdiv2 = villcode[1];
        var add_villcode = additional_village_code.split(",");
        if (add_villcode.length >1) {
            if (add_villcode.length == 4) {
                var village2 = add_villcode[0];
                var mouza2 = add_villcode[2];
                var lot2 = add_villcode[3];
            } else {
                add_villcode = add_villcode.split(" ");
                var mouza2 = add_villcode[0];
                var lot2 = add_villcode[1];
                var village2 = add_villcode[2];
            }
        }

        $.ajax({
            type: "POST",
            url: baseurl + "OfflineSettlementCommonController/addPropertyOffline",
            async: false,
            data: {
                ref_no                    : ref_no,
                additional_district       : additional_district,
                subdiv_code               : subdiv2,
                additional_circle         : circle,
                mouza_pargona_code        : mouza2,
                vill_townprt_code         : village2,
                lot_no                    : lot2,
                additional_bigha          : additional_bigha,
                additional_katha          : additional_katha,
                additional_lessa          : additional_lessa,
                additional_ganda          : additional_ganda,
                additional_kranti         : additional_kranti,
                additional_district_name  : additional_district_name,
                additional_circle_name    : additional_circle_name,
                is_additional_urban       : is_additional_urban,
                additional_village        : additional_village,
                additional_dag            : additional_dag,
                additional_patta          : additional_patta,
                additional_village_code   : additional_village_code
            },
            dataType: "json",
            success: function (data) {

                if (data.responseType == 1) { // validation error
                    data.validation.forEach(function(validation) {
                        var errMsg = "#" + validation.field + "Err";
                        $(errMsg).text("⚠️ " + validation.message);
                    });
                }
                else if(data.responseType==3) {
                    alert(data.message);
                }
                else if(data.status == 0) {
                    alert("Please select property before proceed!!");
                }
                else {
                    //$('#showPropertyButton').show();

                    if(data.result.applied_flag != 'CITIZEN') {
                        $("#addProperty").append('<tr id="prop'+data.result.id+'"><td>'+data.result.dist_name+'</td><td>'+data.result.cir_name+'</td><td>'+data.result.bigha+'</td><td>'+data.result.katha+'</td><td>'+data.result.lessa+'</td><td>'+data.result.ganda+'</td><td>'+data.result.kranti+'</td><td><a href="javascript:void(0)" onclick="confirmDelete('+data.result.id+')" class="btn btn-danger">Delete</a></td></tr>');
                    }
                    else {
                        $("#addProperty").append('<tr id="prop'+data.result.id+'"><td>'+data.result.dist_name+'</td><td>'+data.result.cir_name+'</td><td>'+data.result.bigha+'</td><td>'+data.result.katha+'</td><td>'+data.result.lessa+'</td><td>'+data.result.ganda+'</td><td>'+data.result.kranti+'</td><td></td></tr>');
                    }

                    $('.property_add_reset').val('');

                    $( "#additional_circle option:selected" ).val(null);
                    $( "#additional_village option:selected" ).val(null);
                    $( "#additional_circle option:selected" ).text('-- Select Circle --');
                    $( "#additional_village option:selected" ).text('-- Select Village --');

                    alert("Property added successfully !");
                }
            }
        });
    });

    function openAddPropertyModal(){
        modal_additional_property.style.display = "block";
    }

    // for closing modal_additional_property
    function btnCloseProperty() {

        var ref_no = $("#application_no").val();

        Swal.fire({
            title: 'Have you entered all your properties ?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {

            $.ajax({
                url: baseurl + "SettlementCommon/switchDb",
                type: "post",
                dataType: "json",
                data : {applid: ref_no},
                success: function(data) {

                    console.log(data);
                    modal_additional_property.style.display = "none";
                    if(data.count > 0){
                        $('.btnJsAddProperty').show();
                        $('.btnServerAddProperty').hide();
                    }
                    if(data.count == 0){
                        $('.btnServerAddProperty').hide();
                        $('.btnJsAddProperty').hide();
                        $('.completely_landless').prop('disabled', false);
                        $("#is_landless option[value='']").prop('selected', 'selected');
                    }
                }
            });
        } else if (result.isDenied) {
            modal_additional_property.style.display = "block";
        }
    })
    }

    function openSelectAddPropertyModal()
    {
        var ref_no = $("#application_no").val();

        if($('#is_landless').val() == '' || $('#is_landless').val() == null){
            modal_additional_property.style.display = "none";
        }

        else if($('#is_landless').val() == 'YES'){


            Swal.fire({
                text: 'All additional property detail entered by CITIZEN as well as LM will be removed once clicked on YES. Are you sure to proceed?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "SettlementCommon/deleteAllFromProperty",
                    type: "post",
                    data: {applid : ref_no},
                    dataType: "json",
                    success: function(data) {
                        if(data.status == 0){
                            $('.btnServerAddProperty').hide();
                            $('.btnJsAddProperty').hide();
                            modal_additional_property.style.display = "none";
                            $("#propertyDetail").remove();
                        }
                    }
                });
            } else {
                $("#is_landless option[value='']").prop('selected', 'selected');
                return true;
            }
        })
        }


        else {
            $.ajax({
                url: baseurl + "SettlementCommon/checkAdditionalProperty",
                type: "post",
                data: {applid : ref_no},
                dataType: "json",
                success: function(data) {
                    modal_additional_property.style.display = "block";

                    if(data.status > 0){
                        $('.btnServerAddProperty').hide();
                        $('.btnJsAddProperty').show();
                    }
                    else {
                        $('.btnServerAddProperty').hide();
                        $('.btnJsAddProperty').hide();
                    }
                }
            });
        }
    }


</script>
