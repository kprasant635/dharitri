<div class="prop_chain_report container-fluid">
    <div class="prop_chain_header">
        <!-- <h3 class="bg-primary" style="padding: 3px;">Property Chain Id:&nbsp;&nbsp;&nbsp;&nbsp; <?= $property_id ?></h3> -->
        <h3 class="bg-primary" style="padding: 3px;">Property Chain Id:&nbsp;&nbsp;&nbsp;&nbsp; <?= $masked_property_id ?></h3>

    </div>
    <div class="old_prop_div" style="margin-top: 7px;">
        <?php if (isset($old_property_id) && $old_property_id != null) {
            echo $old_ulpin_btn;
            // var_dump($old_ulpin_btn);
        } ?>
    </div>
    <div class="prop_chain_location">
        <div class="row">
            <div class="d-flex justify-center-left">
                <!-- <h4>Property Id: <?= $property_id ?> </h4> -->
            </div>
        </div>
        <table class="table table-bordered prop-chain text-center loc_details text-dark" style="width: 100%; margin-top: 20px;">
            <tr>
                <td width="20%" style="text-align: center;">
                    <!--DISTRICT-->
                    <p>
                        &#2460;&#2495;&#2482;া<b>: <?php echo $location_data['dist_name']; ?></b>
                    </p>
                </td>
                <td width="20%" style="text-align: center;">
                    <!--SUB-DIVISION-->
                    <p>
                        &#2478;&#2489;&#2453;&#2497;&#2478;া<b>: <?php echo $location_data['subdiv_name']; ?> </b>
                    </p>
                </td>
                <td width="20%" style="text-align: center;">
                    <!--CIRCLE-->
                    <p>
                        &#2458;&#2453;&#2509;&#2544;<b>: <?php echo $location_data['circile_name']; ?></b>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="20%" style="text-align: center;">
                    <!--mouza-->
                    <p>
                        &#2478;&#2508;&#2460;া<b>: <?php echo $location_data['mouza_name']; ?> </b>
                    </p>
                </td>

                <td width="20%" style="text-align: center;">
                    <!--lot-->
                    <p>
                        &#2482;&#2494;&#2463;<b>: <?php echo $location_data['lot_name']; ?> </b>
                    </p>
                </td>
                <td width="20%" style="text-align: center;">
                    <!--vill-->
                    <p>
                        &#2455;&#2494;&#2451;&#2433;<span>/ </span>&#2458;&#2489;&#2544;<b>: <?php echo $location_data['vill_name']; ?> </b>
                    </p>
                </td>
            </tr>
        </table>

        <table class="table table-bordered prop-chain text-center area_details" style="margin-top: 20px ;">
            <tr>
                <th align=center rowspan="2" style="width:50px; ">
                    <!--DAG NUMBER COL. 1-->
                    দাগ নং
                </th>
                <th align=center colspan="2" style="width:110px; ">
                    <!--LAND CLASS COL. 2-->
                    মাটিৰ শ্ৰেণী
                </th>
                <th align=center rowspan="2" style="width:150px;">
                    <!--AREA COL. 3-->
                    কালি <br>( বি-ক-লে )
                </th>
                <th align=center rowspan="2" style="width:150px; "> &nbsp;পট্টাৰ
                    নং আৰু প্ৰকাৰ</th>

                <th align=center rowspan="2" style="width:75px; ">
                    <?php if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 1){ ?>
                        ৰাজহ(টকা)
                    <?php } ?>
                    <!-- REVENUE COL.5 -->
                    
                </th>
                <th align=center rowspan="2" style="width:75px;">
                    <?php if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 1){ ?>
                    <!-- LOCAL RATE COL. 6 -->
                    স্হানীয় কৰ(টকা)
                    <?php } ?>
                </th>
            </tr>

            <tr>
                <th>
                    কৃষি
                </th>
                <th>
                    অকৃষি
                </th>

            </tr>

            <tr>
                <td align='center'>১</td>
                <td align='center' colspan="2">২</td>
                <td align='center'>৩</td>
                <td align='center'>৪</td>
                <td align='center'>৫</td>
                <td align='center'>৬</td>
            </tr>

            <tr>
                <td>
                    <?php
                    //  echo $chithainf['dag_no'];
                    ?>
                    <?php
                    if ($location_data['old_dag_no'] != "") {
                        echo $this->utilityclass->cassnum($location_data['old_dag_no']) . '/' . $this->utilityclass->cassnum($location_data['dag_no']);
                    } else {
                        if (is_numeric($location_data['dag_no'])) {
                            echo $this->utilityclass->cassnum($location_data['dag_no']);
                        } else {
                            echo $location_data['dag_no'];
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($location_data['land_type'] == '01') {
                        echo $location_data['land_class_name'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($location_data['land_type'] == '02') {
                        echo $location_data['land_class_name'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($old_property_flag) {
                        // echo "old property";
                        $bi = $ror_area['bigha'];
                        $kt = $ror_area['katha'];
                        $lc = $ror_area['lessa'];
                    } elseif (!$old_property_flag) {
                        // echo "not old property";
                        $bi = $location_data['bigha'];
                        $kt = $location_data['katha'];
                        $lc = $location_data['lessa'];
                    }
                    echo $this->utilityclass->cassnum($bi) . '-' . $this->utilityclass->cassnum($kt) . '-' . $this->utilityclass->cassnum($lc);
                    ?>
                </td>
                <td>
                    <?php
                    if (is_numeric($location_data['patta_no'])) {
                        echo $this->utilityclass->cassnum($location_data['patta_no']) . '&nbsp;' . ',';
                    } else {
                        echo $location_data['patta_no'] . '&nbsp;' . ',';
                    }
                    echo  $location_data['patta_type_name']; //$location_data['patta_type'];
                    ?>
                </td>
                <td>
                    <?php if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 1){ ?>
                        <?php
                        echo $this->utilityclass->cassnum(number_format($location_data['revenue'], 2)) . '<br>';
                        ?>
                    <?php } ?>
                </td>
                <td>
                    <?php if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 1){ ?>
                        <?php
                        echo $this->utilityclass->cassnum(number_format($location_data['local_tax'], 2)) . '<br>';
                        ?>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <div class="pattadar_details">
            <?php $pattadar_count = sizeof($location_data['pattadar_details']); ?>

            <?php foreach ($location_data['pattadar_details'] as $key => $pattadar) {
                // if ($pattadar['striked_out'] == "1")
                //     $striked_class = 'text-danger';
                // elseif ($pattadar['striked_out'] == "0")
                //     $striked_class = 'text-success';
                $striked_class = 'text-dark'

            ?>
                <?php
                if ($key == 0) { ?>
                    <!-- starting row -->
                    <div class="row">
                    <?php
                } ?>
                    <!-- pattadar content -->
                    <?php if ($pattadar['striked_out'] == 0) { ?>
                        <div class="col-lg-4">
                            <div class="card bg-white">
                                <div class="card-body text-dark">
                                    <div class="row">
                                        <div class="col align-self-start">
                                            <span class="float-left"><i class="fa fa-user <?= $striked_class ?>" style="font-size:36px"></i></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>পট্টাদাৰৰ নাম:</label>
                                        </div>
                                        <div class="col-lg-6 font-weight-bold"><?= $pattadar['pdarname'] ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>পিতাৰ নাম:</label>
                                        </div>
                                        <div class="col-lg-6 font-weight-bold"><?= $pattadar['pdarfather'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- if more then 3 pattadars create new row -->
                    <?php
                    if ($key != 0 && $key + 1 % 3 == 0) { ?>
                    </div> <!-- close previous row -->
                    <!-- start new row -->
                    <div class="row">

                    <?php
                    } ?>
                <?php } ?>
                    </div>
                    <!--close row-->
        </div>
        <div class="transactionDetails">
            <h3 class="bg-success text-center">Transaction Details</h3>
            <table class="table table-bordered" id="prop_chain_transcations">
                <thead>
                    <?php echo "<pre>";
                    // var_dump($location_data['transaction_details']); 
                    ?>
                    <tr>
                        <th>Sl No.</th>
                        <th>Property Id / Reference Id</th>
						<th>Transaction Type</th>
                        <!-- <th>Transaction Id</th> -->
                        <th>Date Time</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody class="trans_body">
                    <?php foreach ($location_data['transaction_details'] as $key => $transaction) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $transaction['case_no'] ?></td>
							<td><?= CERTMNEMONIC_REF_LIST[$transaction['certmnemonic']]?></td>
                            <!-- <td><?= $transaction['transaction'] ?></td> -->
                            <td><?= $transaction['transaction_datetime'] ?></td>
                            <td><?= $transaction['view'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <!-- hidden fields -->
        <input type="hidden" name="gis_code" id="gis_code" value="<?= $gis_code ?>">
        <input type="hidden" name="dag_no" id="dag_no" value="<?= $location_data['dag_no'] ?>">
        <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>index.php/">
        <!-- <div class="col-md-4">
            <button class="btn btn-primary" id="view_trace_map" onclick="return getTraceMap();">View Trace Map</button>
        </div> -->
    </div>
    <div id="show_map">
        <iframe src="" name="trace_map_frame" id="trace_map_frame" frameborder="1" style="width:100%;height: 600px;display:none;"></iframe>
    </div>
</div>

<div id="show_map_bhunaksha">
    <!-- <iframe src="" id="trace_map_frame" frameborder="1" style="width:100%;height: 600px;display:none;"></iframe> -->
</div>

<!-- view transaction modal -->
<div class="modal" id="viewChainTransModal">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title-doc-upl" id="modal-title-doc-upl"></h4>
            </div>
            <div class="modal-body-prop-trans" id="modal-body-prop-trans" style=" overflow-y: auto;">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="loader" style="display:none;"></div>
<script>
    $(document).ready(function() {
        $('#prop_chain_transcations').DataTable({
            "ordering": false,
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
        });
    })


    // transaction modal code
    $(document).on("click", ".modal-show", function() {
        // $("#nonManDocDiv").hide();
        var office_code = $(this).attr("office-code");
        var user_code = $(this).attr("user-code");
        var propertyId = $(this).attr("property-id");
        var prop_data = $(this).attr("prop-data");
        var certmnemonic = $(this).attr("certmnemonic");
        var referenceId = $(this).attr("reference-id");
        $("#modal-title-doc-upl").empty().append('<h6 class="modal-title-prop-trans" id="modal-title-prop-trans">Fetching transaction details of : ' + certmnemonic + ':' + referenceId + '. Please Wait....</h6>');
        $('#modal-body-prop-trans').empty().html('<div class="text-center text-dark"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div>');
        $.ajax({
            url: "<?php echo site_url("PropChainReport/getPropTransData") ?>",
            type: 'POST',
            dataType: "html",
            data: {
                office_code: office_code,
                user_code: user_code,
                propertyId: propertyId,
                prop_data: prop_data,
                certmnemonic: certmnemonic,
                referenceId: referenceId
            },
            success: function(data) {
                $("#modal-title-doc-upl").empty().html('<h6>Transaction Report of ' + certmnemonic + ':' + referenceId + '</h6>')
                $('#modal-body-prop-trans').empty().html(data)
            }
        });
        $("#viewChainTransModal").modal("show");
    });
</script>

<style>
    .spinner-grow {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        margin-top: -50px !important;
        margin-left: -50px !important;
    }

    #loader {
        position: fixed;
        z-index: 10;
        background: black;
        left: 0;
        top: 0;
        /* display: block; */
        opacity: .75;
        /* filter: alpha(opacity=75); */
        width: 100%;
        height: 100%;
    }

    .card-body {
        /* background: linear-gradient(to right, #3eb8ad, #0e84b0); */
        /* background: linear-gradient(to right, #99ded8, #64cbf2); */
        box-shadow: 6px 6px 6px 5px #ccd0d2 !important;
    }

    table.table-bordered.prop-chain {
        border: 1px solid black;
        margin-top: 20px;
    }

    table.table-bordered.prop-chain>thead>tr>th {
        border: 1px solid black;
    }

    table.table-bordered.prop-chain>tbody>tr>th {
        border: 1px solid black;
    }

    table.table-bordered.prop-chain>tbody>tr>td {
        border: 1px solid black;
    }

    .pattadar_details {
        max-height: 320px;
        overflow-y: scroll;
    }

    #viewChainTransModal .modal-dialog-scrollable .modal-content {
        max-width: 70%;
        max-height: 100%;
        overflow: hidden;
    }
</style>