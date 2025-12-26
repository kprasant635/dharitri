<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-12">
            <div class="panel panel-info panel-form">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">Location Details for Dag Mapping / Flagging</h3>
                </div>
                <div class="panel-body">
                    <input type="hidden" class="districtselect" name="dist_code" id="dist_code" value="<?php echo $datas['dist_code']; ?>">
                    <input type="hidden" class="subdivselect" name="subdiv_code" id="subdiv_code" value="<?php echo $datas['subdiv_code']; ?>">
                    <input type="hidden" class="circleselect" name="cir_code" id="cir_code" value="<?php echo $datas['cir_code']; ?>">
                    <input type="hidden" class="mouza_pargona_code" name="mouza_pargona_code" id="mouza_pargona_code" value="<?php echo $datas['mouza_pargona_code']; ?>">
                    <input type="hidden" class="lot_no" name="lot_no" id="lot_no" value="<?php echo $datas['lot_no']; ?>">
                    <div class="" role="alert" style="text-align:center">
                        <h4><?php echo $this->lang->line('district'); ?> : <kbd><?php echo $datas['dist_name']; ?></kbd> &nbsp;&nbsp;<?php echo $this->lang->line('subdivision'); ?> : <kbd><?php echo $datas['sub_div_name']; ?></kbd> &nbsp;&nbsp;<?php echo $this->lang->line('circle'); ?> : <kbd><?php echo $datas['cir_name']; ?></kbd> &nbsp;&nbsp;<?php echo $this->lang->line('lot_no'); ?> : <kbd><?php echo $datas['lot_name']; ?></kbd> </h4>
                    </div>
                    <center>
                        <div class="panel-body mb-2">
                            <!-- <input type="radio" id="radioTab1" name="tab" value="" onclick="show1();">
                            <label for="radioTab1" class="mr-4" style="text-transform: uppercase;">Rural/ Urban Flagging <i class="fa fa-clock-o" aria-hidden="true"></i></label> -->
                            <input type="radio" id="radioTab2" name="tab" value="" onclick="show2();" checked>
                            <label for="radioTab2" class="mr-4" style="text-transform: uppercase;">Zonal Flagging<i class="fas fa-check-double" aria-hidden="true"></i></label>
                            <input type="radio" id="radioTab3" name="tab" value="" onclick="show3();">
                            <label for="radioTab2" class="mr-4" style="text-transform: uppercase;">Area Mapping<i class="fas fa-check-double" aria-hidden="true"></i></label>
                        </div>
                    </center>

                    <div class="table-responsive" id="zonalFlagDiv">

                        <div class="text-center mb-2">
                            <p class=" bg-primary" style="font-size: 18px;">*** <strong>N.B: </strong>Use Full Flagging only if all the Dags of the Village will fall under same Flagging Category ***</p>
                        </div>
                        <div class="panel-heading bg-yellow text-white col-lg-12">
                            <h3 class="panel-title text-center font-weight-bold" style="text-transform: uppercase;">Zonal Flagging</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="25%">Village</th>
                                    <th width="25%">Select</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($villagesZonal as $d) : ?>
                                    <tr>
                                        <td>
                                            <strong class="text-default" style="font-size: 15px;"><?php echo $d->loc_name; ?></strong>
                                        </td>
                                        <td>
                                            <select class="form-select" id="<?php echo $d->vill_townprt_code . "otherflagsel"; ?>" name="OtherFlag[]">
                                                <option value="">===SELECT FLAG TYPE===</option>
                                                <?php foreach ($flags as $flag) : ?>
                                                    <?php
                                                    $flagid = $flag->flagid;
                                                    $flagName = $flag->flag_name;
                                                    $flagabbr = $flag->flag_abbr;
                                                    ?>
                                                    <option value="<?php echo $flagid; ?>"><?php echo $flagName; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="error_msg" id="<?php echo $d->vill_townprt_code; ?>"></span>
                                        </td>
                                        <td>

                                            <button type="button" class="btn btn-primary btn-sm fullFlaggingOtherFlag" data-toggle="tooltip" title="N.B: Use Full Flagging if all the Dags of the Village will fall under same Flag" id="<?php echo $d->vill_townprt_code; ?>">Full Flagging</button>
                                            <a href="<?php echo base_url() . 'index.php/Dagflag/dagFlagCorrectionLM?no=' . $d->vill_townprt_code; ?>" class="btn btn-warning btn-sm" id="<?= $d->vill_townprt_code; ?>"><i class='fa fa-check'></i> Partial Flagging
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- Rural/Urban -->
                    <!-- <div class="table-responsive" id="ruralUrbanFlagDiv" style="display: none;">
                        <div class="panel-heading bg-yellow text-white col-lg-12">
                            <h3 class="panel-title text-center font-weight-bold" style="text-transform: uppercase;">Rural/ Urban Flagging</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="25%">Village</th>
                                    <th width="25%">Select</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($villagesRU as $d) : ?>
                                    <tr>
                                        <td><strong class="text-default" style="font-size: 15px;"><?php echo $d->loc_name; ?></strong></td>
                                        <td>
                                            <select class="form-select" id="<?php echo $d->vill_townprt_code . "ruflagsel"; ?>" name="RuralUrbanFlag[]">
                                                <option value="" selected disabled>===SELECT VILLAGE TYPE===</option>
                                                <option value="R">Rural</option>
                                                <option value="U">Urban</option>
                                            </select>
                                            <span class="error_msg" id="<?php echo $d->vill_townprt_code; ?>"></span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm fullFlaggingRuralUrban" id="<?php echo $d->vill_townprt_code; ?>">Full Flagging</button>
                                            <a href="<?php echo base_url() . 'index.php/Dagflag/ruralUrbanFlaggingPartialLM?no=' . $d->vill_townprt_code; ?>" class="btn btn-warning btn-sm" id="<?= $d->vill_townprt_code; ?>"><i class='fa fa-check'></i> Partial Flagging
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div> -->
                    <!-- Rural/Urban -->

                    <div class="table-responsive" id="areaMappingDiv" style="display: none;">
                        <div class="panel-heading bg-yellow text-white col-lg-12">
                            <h3 class="panel-title text-center font-weight-bold" style="text-transform: uppercase;">Dag Area Mapping</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="25%">Village</th>
                                    <th width="34%">Select</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($villages as $d) : ?>
                                    <tr>
                                        <td><b><?php echo $d->loc_name; ?></b></td>
                                        <td>
                                            <select class="form-select" id="<?php echo $d->vill_townprt_code . "areasel"; ?>" name="MappingCat[]">
                                                <option value="">===SELECT AREA TYPE===</option>
                                                <?php foreach ($area as $area1) : ?>
                                                    <?php
                                                    $paid = $area1->paid;
                                                    $area11 = $area1->area;
                                                    ?>
                                                    <option value="<?php echo $paid; ?>"><?php echo $area11; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="error_msg" id="<?php echo $d->vill_townprt_code; ?>"></span>

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary fullMapping" id="<?php echo $d->vill_townprt_code; ?>">Full Mapping</button>
                                            <a href="<?php echo base_url() . 'index.php/Dagflag/partialmapping?no=' . $d->vill_townprt_code; ?>" class="btn btn-warning" id="<?= $d->vill_townprt_code; ?>"><i class='fa fa-check'></i> Partial Mapping
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <?php
            $backLink = 'Dagflag/MappingIndexLM';
            include 'commonButtons.php';
            ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    // function show1() {
    //     document.getElementById('ruralUrbanFlagDiv').style.display = 'block';
    //     document.getElementById('zonalFlagDiv').style.display = 'none';
    //     document.getElementById('areaMappingDiv').style.display = 'none';
    // }

    function show2() {
        document.getElementById('zonalFlagDiv').style.display = 'block';
        // document.getElementById('ruralUrbanFlagDiv').style.display = 'none';
        document.getElementById('areaMappingDiv').style.display = 'none';
    }

    function show3() {
        document.getElementById('areaMappingDiv').style.display = 'block';
        // document.getElementById('ruralUrbanFlagDiv').style.display = 'none';
        document.getElementById('zonalFlagDiv').style.display = 'none';
    }

    function showSuccessMessage(text) {
        Swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        }).then(function() {
            window.location.href = baseurl + "Dagflag/locationDetails";
        });

    }

    function showErrorMessage(text) {
        Swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }


    $('.fullMapping').click(function(e) {
        var id = $(this).attr("id");
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var circle_code = $('#cir_code').val();
        var mouza_pargona_code = $('#mouza_pargona_code').val();
        var lot_no = $('#lot_no').val();
        var vill_townprt_code = id;
        var areasel = $('#' + id + 'areasel').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border: 'none',
                backgroundColor: 'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Dagflag/updateFullMapping/",
            type: 'post',
            dataType: 'json',
            data: {
                dist_code: dist_code,
                subdiv_code: subdiv_code,
                circle_code: circle_code,
                mouza_pargona_code: mouza_pargona_code,
                lot_no: lot_no,
                vill_townprt_code: vill_townprt_code,
                areasel: areasel
            },
            success: function(data) {
                $.unblockUI();
                if (data.status == 'success') {
                    showSuccessMessage(data.msg);
                } else {
                    showErrorMessage(data.msg);
                }
            },
            error: function(error) {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });



    //Full Flagging Zonal FLags
    $('.fullFlaggingOtherFlag').click(function(e) {
        var id1 = $(this).attr("id");
        var dist_code1 = $('#dist_code').val();
        var subdiv_code1 = $('#subdiv_code').val();
        var circle_code1 = $('#cir_code').val();
        var mouza_pargona_code1 = $('#mouza_pargona_code').val();
        var lot_no1 = $('#lot_no').val();
        var vill_townprt_code1 = id1;
        var otherflagsel = $('#' + id1 + 'otherflagsel').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "All The Dags of the Village will be sent to CO for Flagging Approval",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "Dagflag/updateFullFlaggingOtherFlag",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        dist_code: dist_code1,
                        subdiv_code: subdiv_code1,
                        circle_code: circle_code1,
                        mouza_pargona_code: mouza_pargona_code1,
                        lot_no: lot_no1,
                        vill_townprt_code: vill_townprt_code1,
                        otherflagsel: otherflagsel
                    },
                    success: function(data) {
                        $.unblockUI();
                        if (data.status == 'success') {
                            showSuccessMessage(data.msg);
                        } else {
                            showErrorMessage(data.msg);
                        }
                    },
                    error: function(error) {
                        $.unblockUI();
                        showErrorMessage('Something went wrong.');
                    }
                });
            }
        })
    });
</script>