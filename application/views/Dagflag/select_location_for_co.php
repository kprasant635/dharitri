<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-12">
            <div class="panel panel-info panel-form">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">Mapping Details Village Wise</h3>
                </div>
                <div class="panel-body">
                    <input type="hidden" class="districtselect" name="dist_code" id="dist_code" value="<?php echo $datas['dist_code']; ?>">
                    <input type="hidden" class="subdivselect" name="subdiv_code" id="subdiv_code" value="<?php echo $datas['subdiv_code']; ?>">
                    <input type="hidden" class="circleselect" name="cir_code" id="cir_code" value="<?php echo $datas['cir_code']; ?>">

                    <div class="" role="alert" style="text-align:center">
                        <h4><?php echo $this->lang->line('district'); ?> : <kbd><?php echo $datas['dist_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision'); ?> : <kbd><?php echo $datas['sub_div_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle'); ?> : <kbd><?php echo $datas['cir_name']; ?></kbd> </h4>
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

                    <div class="table-responsive" id="dagFlagPendingListCO">
                        <div class="panel-heading bg-yellow text-white  my-2">
                            <h3 class="panel-title text-center font-weight-bold">Dag Flagging Details Village Wise (Pending List)</h3>
                        </div>
                        <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Mouza</th>
                                    <th>Lot no.</th>
                                    <th>Village </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($villagesDagFlag as $d) : ?>

                                    <tr>
                                        <td><?php echo $d->mouza_name; ?></td>
                                        <td><?php echo $d->lot_name; ?></td>
                                        <td><?php echo $d->village_name; ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'index.php/Dagflag/viewOtherDagFlaggingDetailsPendingCO?no=' . $d->uuid; ?>" class="btn btn-warning" id="<?= $d->vill_townprt_code; ?>"><i class='fa fa-check'></i> View Flagging Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- Rural/Urban -->
                    <!-- <div class="table-responsive" id="ruralUrbanFlagPendingListCO" style="display: none;">
                        <div class="panel-heading bg-yellow text-white  my-2">
                            <h3 class="panel-title text-center font-weight-bold">Rural/Urban Flagging Details Village Wise (Pending List)</h3>
                        </div>
                        <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Mouza</th>
                                    <th>Lot no.</th>
                                    <th>Village </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($villagesRU as $d) : ?>

                                    <tr>
                                        <td><?php echo $d->mouza_name; ?></td>
                                        <td><?php echo $d->lot_name; ?></td>
                                        <td><?php echo $d->village_name; ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'index.php/Dagflag/viewRuralUrbanFlaggingDetailsPendingCO?no=' . $d->uuid; ?>" class="btn btn-warning" id="<?= $d->vill_townprt_code; ?>"><i class='fa fa-check'></i> View Rural/Urban Flagging Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div> -->
                    <!-- Rural/Urban -->

                    <div class="table-responsive" id="areaMappingPendingListCO" style="display: none;">
                        <div class="panel-heading bg-yellow text-white  my-2">
                            <h3 class="panel-title text-center font-weight-bold">Area Mapping Details Village Wise (Pending List)</h3>
                        </div>
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Mouza</th>
                                    <th>Lot no.</th>
                                    <th>Village </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($villages as $d) : ?>

                                    <tr>
                                        <td><?php echo $d->mouza_name; ?></td>
                                        <td><?php echo $d->lot_name; ?></td>
                                        <td><?php echo $d->village_name; ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'index.php/Dagflag/viewMappingDetails?no=' . $d->uuid; ?>" class="btn btn-warning" id="<?= $d->vill_townprt_code; ?>"><i class='fa fa-check'></i> View Mapping Details
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
            $backLink = 'Dagflag/MappingIndex';
            include 'commonButtons.php';
            ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example1').DataTable();
        $('#example2').DataTable();
    });



    // function show1() {
    //     document.getElementById('ruralUrbanFlagPendingListCO').style.display = 'block';
    //     document.getElementById('dagFlagPendingListCO').style.display = 'none';
    //     // document.getElementById('areaMappingPendingListCO').style.display = 'none';
    // }

    function show2() {
        document.getElementById('dagFlagPendingListCO').style.display = 'block';
        // document.getElementById('ruralUrbanFlagPendingListCO').style.display = 'none';
        document.getElementById('areaMappingPendingListCO').style.display = 'none';
    }

    function show3() {
        document.getElementById('areaMappingPendingListCO').style.display = 'block';
        // document.getElementById('ruralUrbanFlagPendingListCO').style.display = 'none';
        document.getElementById('dagFlagPendingListCO').style.display = 'none';
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
            window.location.href = baseurl + "Dagflag/locationDetailsCO";
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


    // $('.approveDagFlag').click(function (e) {
    //     var id = $(this).attr("id");
    //     var uuid = id;

    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });
    //     $.ajax({
    //         url: baseurl + "Dagflag/ApproveMapping",
    //         type: 'post',
    //         dataType: 'json',
    //         data: {
    //             uuid: uuid,
    //             user_code : 'co'
    //             },
    //         success: function (data) {
    //             $.unblockUI();
    //             if(data.status == 'success'){
    //                 showSuccessMessage(data.msg);
    //             }else{
    //                 showErrorMessage(data.msg); 
    //             }
    //         },error: function (error) {
    //             $.unblockUI();
    //             showErrorMessage('Something went wrong.');
    //         }
    //     });
    // });
</script>