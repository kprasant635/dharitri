<!-- Improvement in Land Share Details -->
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<style>
    body {
        padding-right: 0 !important
    }
</style>
<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Pending Land Share Details
        </h4>
    </div>
    <!-- New Select Field -->
    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url() . 'index.php/LandShareUpdation/getPendingLandShareDetails' ?>">
        <div class="form-group">
            <label for="select" class="col-lg-3 control-label">Select Dag Range</label>
            <div class="col-lg-4">
                <select class="form-control rangeselect" id="SelectRange" name="select_range">
                    <option selected disabled>Select Range</option>
                    <option value="0">0 To 500</option>
                    <option value="500">500 To 1000</option>
                    <option value="1000">1000 To 1500</option>
                    <option value="1500">1500 To 2000</option>
                    <option value="2000">2000 To 2500</option>
                    <option value="2500">2500 To 3000</option>
                    <option value="3000">3000 To 3500</option>
                    <option value="3500">3500 To 4000</option>
                    <option value="4000">4000 To 4500</option>
                    <option value="4500">4500 To 5000</option>
                </select>
            </div>
            <div class="col-lg-4">
                <button type="submit" name="ASTSTEP1Submit" class="btn btn-success"><i class='fa fa-eye'></i>&nbsp; View Dags</button>
            </div>
        </div>
        <hr style="border-bottom: 2px solid #000;">
    </form>
    <!-- //Select Field End -->
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>
<div class="col-lg-10 col-lg-offset-1">
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">Pending Land Share Details</h3>
        </div>
        <div class="panel-body">
            <?php if ($this->session->userdata('message')) : ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                            echo $this->session->userdata('message');
                            $this->session->unset_userdata('message');
                            ?>
                </div>
            <?php endif; ?>
            <?php echo form_open(base_url("index.php/LandShareUpdation/approveLandShareBulk"), array('method' => 'post')); ?>
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id="datatable" width="100%">
                <thead>
                    <th scope="col" class="center"><input type='button' class="btn btn-sm btn-success" id="toggle" value="select all" onClick="do_this()"></th>
                    <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                    <th scope="col" class="center" style="display:none;"><label class="control-label">Village UUID</label></th>
                    <th scope="col" class="center"><label class="control-label">Village</label></th>
                    <th scope="col" class="center"><label class="control-label">Details</label></th>
                    <th scope="col" class="center"><label class="control-label">Dag Area(Bigha)</label></th>
                    <th scope="col" class="center"><label class="control-label">Dag Area(Katha)</label></th>
                    <th scope="col" class="center"><label class="control-label">Dag Area(Lessa)</label></th>
                    <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                </thead>
                <tbody>
                    <?php foreach ($getpendingdetails as $details) :  ?>
                        <tr>
                            <td id="accept_dag" width="5%" class="center">
                                <input type='checkbox' id="dag_no_checkbox_<?= $details['dag_no'] ?>" name="dag_no[]" value="<?php echo  $details['dag_no'] ?>">
                            </td>
                            <td id="accept_vill" width="5%" class="center" style="display:none;">
                                <input type='checkbox' id="village_uuid_checkbox_<?= $details['village_uuid'] ?>" name="village_uuid[]" value="<?php echo  $details['village_uuid'] ?>">
                            </td>
                            <td width="5%" class="center"><?= $details['dag_no'] ?></td>
                            <td width="20%" class="center"> <?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_townprt_code']) ?>
                            </td>
                            <td width="5%" class="center">
                                <a class="btn btn-secondary btn-sm" onclick="viewLandShareDetailsFormCO('<?= $details['dag_no'] ?>','<?= $details['village_uuid'] ?>','<?= $details['share_area_b'] ?>','<?= $details['share_area_k'] ?>','<?= $details['share_area_lc'] ?>','<?= $this->utilityclass->getMouzaName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code']) ?>','<?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_townprt_code']) ?>','<?= $this->utilityclass->getLotName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no']) ?>')">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    View
                                </a>
                            </td>
                            <td width="5%" class="center"><?= $details['share_area_b'] ?></td>
                            <td width="5%" class="center"><?= $details['share_area_k'] ?></td>
                            <td width="5%" class="center"><?= $details['share_area_lc'] ?></td>
                            <td width="50%" class="center">
                                <button type="button" onclick="approveLandShareDetails('<?= $details['dag_no'] ?>', '<?= $details['village_uuid'] ?>')" value="<?= $details['dag_no'] ?>" class="btn btn-sm btn-success"> Approve <i class="fa fa-check"></i></button>
                                <button type="button" onclick="revertLandShareDetails('<?= $details['dag_no'] ?>', '<?= $details['village_uuid'] ?>')" value="<?= $details['dag_no'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Revert</button>
                                <!-- <a data-toggle='modal' data-target="#landShareRevertModal" data-villname="<?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_townprt_code']) ?>" data-dagno="<?= $details['dag_no'] ?>" data-villcode="<?= $details['vill_townprt_code'] ?>" ; class='btn btn-warning btn-sm landsharerevert'><i class='fa fa-undo'></i>Revert To LM</a> -->
                                <button type="button" onclick="rejectLandShareDetails('<?= $details['dag_no'] ?>', '<?= $details['village_uuid'] ?>')" value="<?= $details['dag_no'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <center>
                <?php if (!empty($getpendingdetails)) { ?>
                    <?php echo form_submit(['name' => 'landShareApprove', 'value' => 'Approve Selected Dag', 'class' => 'btn btn-success']); ?>
                <?php } ?>
            </center>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal for Land Share Details Revert Remarks by CO -->
<div class="modal fade" id="landShareRevertModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-warning">
                <h6 class="modal-title w-100">
                    Revert Back Land Share Details</br>
                    <?php echo $this->lang->line('mouza') ?> :
                    <?php echo $this->utilityclass->getMouzaName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code']); ?>,
                    <?php echo $this->lang->line('lot_no') ?> :
                    <?php echo $this->utilityclass->getLotName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no']); ?>,
                    <?php echo $this->lang->line('vill_town') ?> :
                    <?= $this->utilityclass->getVillageName($details['dist_code'], $details['subdiv_code'], $details['cir_code'], $details['mouza_pargona_code'], $details['lot_no'], $details['vill_townprt_code']) ?>
                    ; Dag No: <span id="land_share_revert_dag_no"></span>
                </h6>
            </div>
            <form id="landShareRevertForm" name="landShareRevertForm" method="POST" action="">
                <div class="modal-body">
                    <input type='hidden' name="dag_no_reverted" id='dagReverted'>
                    <input type='hidden' name="vill_code_reverted" id='villReverted'>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Land Share Revert Remarks:</label>
                        <textarea class="form-control" rows="3" name="revert_remarks" id="revert_remarks" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-revert_to_lm" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Land Share Details Revert Remarks by CO  End-->

<!-- Data Table Configuration -->
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pageLength": 20,
            "order": [1, "asc"],
            "autoWidth": false,
            "deferRender": true,
            "drawCallback": function() {}
        });
    });
    $(document).on('click', '.landsharerevert', function() {
        $('#land_share_revert_dag_no').text($(this).data('dagno'))
        $('#dagReverted').val($(this).data('dagno'))
        $('#villReverted').val($(this).data('villcode'))
    });
</script>

<script>
    // Approve Land Share Detals By CO
    function approveLandShareDetails(dag_no, village_uuid) {
        Swal.fire({
            title: 'Are you sure to Approve?',
            text: "You won't be able to undo it!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Approve!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/LandShareUpdation/approve_LandShare_details/" ?>' + dag_no + '/' + village_uuid,
                    type: "POST",
                    success: function(data) {
                        window.location.reload(true);
                        console.log(data.success);
                        Swal.fire(
                            "Approved",
                            "Land Share Details  Approved  successfully",
                            "success",
                        );
                    },
                    error: function() {
                        Swal.fire({
                            title: "Failed",
                            text: "Land Share Details Not Updated..",
                            type: "warning",
                            timer: 50000
                        });
                    },
                });
            }
        })
    }
    // Reject Land Share Details By CO
    function rejectLandShareDetails(dag_no, village_uuid) {
        //e.preventDefault();
        Swal.fire({
            title: 'Are you sure to Reject?',
            text: "You won't be able to undo it!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/LandShareUpdation/reject_LandShare_details/" ?>' + dag_no + '/' + village_uuid,
                    type: "POST",
                    success: function(data) {
                        window.location.reload(true);
                        console.log(data.success);
                        Swal.fire(
                            "Rejected",
                            "Land Share Details for Dag No" + dag_no + "Rejected By CO successfully",
                            "success",
                        );
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }

    // Revert Land Share Details By CO
    function revertLandShareDetails(dag_no, village_uuid) {
        //e.preventDefault();
        Swal.fire({
            title: 'Are you sure to Revert?',
            text: "You won't be able to undo it!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Revert to LM!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/LandShareUpdation/revert_LandShare_details/" ?>' + dag_no + '/' + village_uuid,
                    type: "POST",
                    success: function(data) {
                        window.location.reload(true);
                        console.log(data.success);
                        Swal.fire(
                            "Reverted",
                            "Land Share Details for Dag No" + dag_no + "Reverted By CO successfully",
                            "success",
                        );
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }
</script>
<script>
    function do_this() {
        var checkboxes1 = document.getElementsByName('dag_no[]');
        var checkboxes2 = document.getElementsByName('village_uuid[]');
        var button = document.getElementById('toggle');

        if (button.value == 'select all') {
            for (var i in checkboxes1) {
                checkboxes1[i].checked = 'FALSE';
            }
            for (var i in checkboxes2) {
                checkboxes2[i].checked = 'FALSE';
            }
            button.value = 'Deselect all'
        } else {
            for (var i in checkboxes1) {
                checkboxes1[i].checked = '';
            }
            for (var i in checkboxes2) {
                checkboxes2[i].checked = '';
            }
            button.value = 'select all'
        }
    }
</script>

<script>
    // Get the Accept checkboxes.
    var acceptCheckboxes = $('#dag_no_checkbox_').find('input:checkbox');

    // Get the Reject checkboxes.
    var rejectCheckboxes = $('#village_uuid_checkbox_').find('input:checkbox');

    acceptCheckboxes.click(function() {
        // Find the index of cheked or unchecked Accept checkbox.
        var selectedIndex = acceptCheckboxes.index($(this));

        // If current Accept checkbox is clicked, then uncheck the Reject one on the     
        // same index using the selected index of Accept checkbox and vise versa.
        if (this.checked) {
            $('#accept_vill (' + selectedIndex + ') input[type=checkbox]').prop('checked', true);
        } else {
            $('#accept_vill (' + selectedIndex + ') input[type=checkbox]').prop('checked', false);
        }
    });
</script>
<!-- land share view modal  -->
<!-- land share Details view modal at CO End -->
<?php include 'land_share_details_co_view.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/land_share/land_share.js"></script>