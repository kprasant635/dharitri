<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<style>
    /*  select {
        font-family: verdana;
        font-size: 8pt;
        width: 150px;
        height: 30vh;
    }*/
    select.form-control[multiple],
    select.form-control[size] {
        height: 250px !important;
        width: 450px !important;
    }

    .selectLabel1 {
        background-color: #ff681d;
        padding: 8px;
        color: #fff;
    }

    .selectLabel2 {
        background-color: #209924;
        padding: 8px;
        color: #fff;
    }

    .labelDag {
        background-color: #ffb81d;
        padding: 9px 16px;
        border-radius: 32px;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">Location Details for Update Chitha Flag (Other Flags)</h3>
                </div>
                <div class="panel-body">
                    <!-- <form method="POST" action="" id=""> -->
                    <input type="hidden" name="selectedDags" id="selectedDags">
                    <input type="hidden" class="districtselect" name="dist_code" id="dist_code" value="<?php echo $datas['dist_code']; ?>">
                    <input type="hidden" class="subdivselect" name="subdiv_code" id="subdiv_code" value="<?php echo $datas['subdiv_code']; ?>">
                    <input type="hidden" class="circleselect" name="cir_code" id="cir_code" value="<?php echo $datas['cir_code']; ?>">
                    <input type="hidden" class="mouza_pargona_code" name="mouza_pargona_code" id="mouza_pargona_code" value="<?php echo $datas['mouza_pargona_code']; ?>">
                    <input type="hidden" class="lot_no" name="lot_no" id="lot_no" value="<?php echo $datas['lot_no']; ?>">
                    <input type="hidden" class="vill_townprt_code" name="vill_townprt_code" id="vill_townprt_code" value="<?php echo $datas['vill_code']; ?>">
                    <div class="" role="alert" style="text-align:center">
                        <h4><?php echo $this->lang->line('district'); ?> : <kbd><?php echo $datas['dist_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision'); ?> : <kbd><?php echo $datas['sub_div_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle'); ?> : <kbd><?php echo $datas['cir_name']; ?></kbd> <?php echo $this->lang->line('vill_town'); ?> : <kbd><?php echo $datas['vill_name']; ?></kbd> </h4>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3 text-right"><label class="text-danger">CO Remarks : </label>
                        </div>
                        <div class="col-sm-9" style="margin-bottom: 34px;"><textarea class="form-control" name="remarks" id="remarks" placeholder="Approve/Reject Remarks"></textarea>
                        </div>


                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-success approveZonalDagFlag" id="<?php echo $datas['uuid']; ?>"><i class='fa fa-check'></i> Approve</button>
                        <button type="button" class="btn btn-danger revertZonalDagFlag" id="<?php echo $datas['uuid']; ?>"><i class='fa fa-times-circle'></i> Revert</button>
                    </div>
                </div>
                <div class="container">
                    <ul class="list-group">
                        <li style="background-color: #faffb1; border: 1px solid #ebebeb;padding: 14px;"><b>Dag No. with Flagging Category </b> <b style="text-align: right;">(Total Pending Dags : <?= count($daginfo) ?>)</b></li>
                    </ul>
                    <div style="max-height: 440px;overflow-y: scroll;">

                        <ul class="list-group">

                            <?php foreach ($daginfo as $dags) : ?>
                                <?php
                                $dag_no = $dags->dag_no;
                                $flag = $dags->flag_name;
                                ?>
                                <li style="border: 1px solid #ebebeb;padding: 10px;"><b><i class="fa fa-clock-o text-warning mx-2" style="font-size:20px"></i> <span class="labelDag"> <?php echo $dag_no; ?></span>&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-flag "></i> <?= $flag ?> </b></li>
                            <?php endforeach; ?>
                        </ul>


                    </div>


                    <!-- </form> -->

                </div>
            </div>
            <?php
            $backLink = 'Dagflag/locationDetailsCO';
            include 'commonButtons.php';
            ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
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

    $('.approveZonalDagFlag').click(function(e) {
        var id = $(this).attr("id");
        var uuid = id;
        var remarks = $('#remarks').val();
        if (!remarks) {
            showErrorMessage('Remarks field is mandatory...');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "All the Visible Dags with Flagging Category sent by LM will be Approved",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes Approve'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "Dagflag/ApproveZonalDagFlaggingCO",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        uuid: uuid,
                        user_code: 'co',
                        remarks: remarks
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

    $('.revertZonalDagFlag').click(function(e) {
        var idRevert = $(this).attr("id");
        var uuidRevert = idRevert;
        var remarksRevert = $('#remarks').val();

        if (!remarksRevert) {
            showErrorMessage('Remarks field is mandatory...');
            return;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: "All the Visible Dags with Flagging Category sent by LM will be Reverted",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes Revert'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "Dagflag/RevertZonalDagFlaggingCO",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        uuid: uuidRevert,
                        user_code: 'co',
                        remarks: remarksRevert
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