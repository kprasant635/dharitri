<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div class="container-fluid form-top login">
    <div class="col-lg-12">
        <div class="card mt-2">
            <div class="card-body">
                <h5 class="bg-secondary p-2 text-white shadow mt-2 text-center" style="margin-bottom:0px!important;">
                    SELECT LOCATION
                </h5>
                <h6 class="bg-success p-2 text-white shadow text-center">
                    <?php echo $this->lang->line('district')?>: <?= $dist_name?>,
                    <?php echo $this->lang->line('subdivision')?>: <?= $subdiv_name?>,
                    <?php echo $this->lang->line('circle')?>: <?= $cir_name?>,
                </h6>
                <div class="card-text mt-2 lm-report">
                    <form class="form-horizontal" id="khajanaForm">
                        <input type='hidden' name="dist_code" value="<?=$dist_code?>" id="dist_code">
                        <input type='hidden' name="subdiv_code" value="<?=$subdiv_code?>" id="subdiv_code">
                        <input type='hidden' name="cir_code" value="<?=$cir_code?>" id="cir_code">

                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-sm-4 text-end fw-bold">
                                    <?= 'Village' ?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control select2" required id="village" name="village">
                                        <option disabled selected>--SELECT-VILLAGE-NAME--</option>
                                        <?php foreach ($village_list as $vill): ?>
                                            <option value="<?= $vill->mouza_pargona_code . ',' . $vill->lot_no . ',' . $vill->vill_townprt_code ?>">
                                                <?= $vill->loc_name .','. $vill->locname_eng?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 text-end fw-bold">
                                    <?php echo 'Patta Type' ?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control pattatypeselect1 select2" required id="patta_type" name="patta_type">
                                        <option disabled selected>--SELECT-PATTA-TYPE--</option>
                                        <?php foreach ($patta as $p): ?>
                                            <option  value="<?= $p->type_code ?>"><?= $p->patta_type .','.$p->pattatype_eng ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 text-end fw-bold">
                                    <?php echo 'Patta No' ?>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="patta_no" name="patta_no" autocomplete = off placeholder="--ENTER-PATTA-NO--" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                               
                                <div class="text-center">
                                <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4"></div>
                                            <div class="col-4 text-center">
                                                <div class="col-sm-12 d-flex">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-check"></i>&nbsp;<?= "Get Khazana Receipt Details" ?>
                                                    </button>&nbsp;&nbsp;
                                                    <a href="<?= base_url('index.php/home/index'); ?>">
                                                    <button id="MainIndex" type="button" class="btn btn-danger">
                                                        <i class="fa fa-home"></i>&nbsp;<?= "BACK" ?>
                                                    </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Result Div -->
                    <div id="resultContainer" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Apply Select2 to all select elements
    $(".select2").select2({
        width: '100%', // Ensures it fits within the column width
        placeholder: "Select an option",
        allowClear: true
    });
    
    $("#khajanaForm").on("submit", function (event) {
        event.preventDefault(); 

        var village = $("#village").val();
        if (!village || village === null || village === '') { 
            $("#resultContainer").html('<div class="alert alert-danger">Error: Please select a Village...!</div>');
            return; 
        }

        var pattaType = $("#patta_type").val();
        if (!pattaType || pattaType === null || pattaType === '') { 
            $("#resultContainer").html('<div class="alert alert-danger">Error: Patta Type field is required!</div>');
            return; 
        }
        var pattaNo = $("#patta_no").val().trim();
        if (pattaNo === '') {
            $("#resultContainer").html('<div class="alert alert-danger">Error: Patta No field is required!</div>');
            return;
        }

        $.ajax({
            url: "<?= base_url() . 'index.php/EkhajanaCoController/getKhajanaReceipt' ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json", 
            success: function (response) {
                if (response.flag == 'N') {
                    $("#resultContainer").html('<div class="alert alert-danger">' + response.msg + '</div>');
                    if(response.registration_flag == 'Y'){
                        $("#resultContainer").html('<div class="alert alert-danger">' + response.msg + '</div>');
                        $("#resultContainer").append('<div class="alert alert-primary"> Registration Application Number: ' + response.app_nos + '</div>');
                    }
                } else if (response.flag === 'Y') {
                    $("#resultContainer").html('<div class="alert alert-success">' + response.msg + '</div>');
                    $("#resultContainer").append('<div class="alert alert-primary">There are total : ' + response.app_count + ' applications registered for this patta</div>');
                    $("#resultContainer").append('<div class="alert alert-primary">Registration Application Number:' + response.app_nos + '</div>');
                    var url = "<?= base_url('index.php/EkhajanaCoController/viewKhajanaReceiptByCo?ld_application_no='); ?>" + response.ld_application_no;
                    var button = '<button class="btn btn-success btn-sm" onclick="window.open(\'' + url + '\', \'_blank\')">'
                            + '<i class="fa fa-eye" aria-hidden="true"></i> View Khajana Receipt'
                            + '</button>';

                    $("#resultContainer").append(button);

                }
            },
            error: function () {
                $("#resultContainer").html('<div class="alert alert-danger">Error fetching data.</div>');
            }
        });
    });
});
</script>


