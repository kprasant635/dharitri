<style>
.buttons-excel {
    left: 15%;
    background-color: green;
    color: white !important;
}

.buttons-csv {
    left: 15%;
    background-color: blue;
    color: white !important;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6 !important;
}

#mouzdar_view_doul_table {
    border: 2px solid #343a40;
    border-collapse: collapse;
}

#mouzdar_view_doul_table th,
#mouzdar_view_doul_table td {
    border: 1px solid #6c757d;
    padding: 10px;
    vertical-align: middle;
    font-size: 15px;
}

#mouzdar_view_doul_table thead {
    background-color: #343a40;
    color: #fff;
}

#mouzdar_view_doul_table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

#mouzdar_view_doul_table tbody tr:hover {
    background-color: rgb(91, 215, 247) !important;
    /* Light green */
    cursor: pointer;
}
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">DOUL</li>
    </ol>
</nav>
<div class="row container" style='margin-top:10px'>
    <div class="panel panel-info panel-form mt-5">
        <div class="panel-heading bg-primary text-center font-weight-bold p-1 text-white">
            <h4 class="panel-title font-weight-bold">
                Mouzadar Report Aganist The Current doul
            </h4>
        </div>
        <div class="card-body">
            <div class="card-body shadow-lg bg-white rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="mouzdar_view_doul_table" class="table table-hover" style="width:100%;">
                            <thead class="thead-dark">
                                <tr style="background-color: #515151; color: #fff;font-size:18px;">
                                    <td>লট নম্বৰ</td>
                                    <td>মৌজা</td>
                                    <td>গাঁও</td>
                                    <td>পট্টাৰ প্ৰকাৰ</td>
                                    <td>পট্টা নম্বৰ</td>
                                    <td>View Remarks</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mouzadar_report as $doul_detail):
                                     $unique_id = uniqid(); 
                                ?>
                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getLotName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code,$doul_detail->lot_no)?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-danger">
                                            <?=$this->utilityclass->getMouzaName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code)?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?= $this->utilityclass->getVillageName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code,$doul_detail->lot_no,$doul_detail->vill_townprt_code) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getPattaType($doul_detail->patta_type_code)?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$doul_detail->patta_no?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success openRemarksModal"
                                            data-toggle="modal"
                                            data-target="#remarksModal_<?= $unique_id ?>">
                                            <i class="fa fa-comments-o"></i> View Details
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary openCoRemarksModal"
                                            data-toggle="modal"
                                            data-target="#co_remarksModal_<?= $unique_id ?>">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> CO Remarks
                                        </button>
                                    </td>

                                </tr>
                                    <!-- Remarks View Modal -->
                                    <div class="modal fade" id="remarksModal_<?= $unique_id ?>" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="remarksModalLabel">
                                                Village: <span style="color:yellow"><?= $this->utilityclass->getVillageName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code,$doul_detail->lot_no,$doul_detail->vill_townprt_code) ?> </span>;
                                                Lot No: <span style="color:yellow"><?=$this->utilityclass->getLotName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code,$doul_detail->lot_no)?></span> ;
                                                Mouza : <span style="color:yellow"><?=$this->utilityclass->getMouzaName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code)?></span> ;
                                                Patta Type: <span style="color:yellow"><?=$this->utilityclass->getPattaType($doul_detail->patta_type_code)?> </span><br>
                                                Patta No: <span style="color:yellow"><?=$doul_detail->patta_no?> </span>
                                            </h5>
                                            <button type="button" class="close text-red" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times; CLOSE</span>
                                            </button>

                                        </div>
                                        <div class="modal-body">
                                            <label>Current Revenue</label>
                                            <input class="form-control text-red" style="color:red" type="text" readonly value="<?=$doul_detail->current_revenue?>">
                                            <label>Current Local tax</label>
                                            <input class="form-control text-red" style="color:red" type="text" readonly value="<?=$doul_detail->current_local_tax?>">
                                            <label>Suggested Revenue</label>
                                            <input class="form-control text-green" style="color:green" type="text" readonly value="<?=$doul_detail->suggested_revenue?>">
                                            <label>Suggested Local tax</label>
                                            <input class="form-control text-green" style="color:green" type="text" readonly value="<?=$doul_detail->suggested_local_tax?>">
                                            <label>Remarks</label>
                                            <input class="form-control" type="text" readonly value="<?=$doul_detail->mouzadar_remarks?>">
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- CO Remarks View Modal -->
                                    <div class="modal fade" id="co_remarksModal_<?= $unique_id ?>" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="remarksModalLabel">
                                                Village: <span style="color:yellow"><?= $this->utilityclass->getVillageName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code,$doul_detail->lot_no,$doul_detail->vill_townprt_code) ?> </span>;
                                                Lot No: <span style="color:yellow"><?=$this->utilityclass->getLotName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code,$doul_detail->lot_no)?></span> ;
                                                Mouza : <span style="color:yellow"><?=$this->utilityclass->getMouzaName($doul_detail->dist_code,$doul_detail->subdiv_code,$doul_detail->cir_code,$doul_detail->mouza_pargona_code)?></span> ;
                                                Patta Type: <span style="color:yellow"><?=$this->utilityclass->getPattaType($doul_detail->patta_type_code)?> </span><br>
                                                Patta No: <span style="color:yellow"><?=$doul_detail->patta_no?> </span>
                                            </h5>
                                            <button type="button" class="close text-red" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times; CLOSE</span>
                                            </button>

                                        </div>
                                        <form id="co_remarksForm_<?= $unique_id ?>">
                                        <input type="hidden" name="dist_code" id="dist_code" value="<?=$doul_detail->dist_code?>">
                                        <input type="hidden" name="subdiv_code" id="subdiv_code" value="<?=$doul_detail->subdiv_code?>">
                                        <input type="hidden" name="cir_code" id="cir_code" value="<?=$doul_detail->cir_code?>">
                                        <input type="hidden" name="mouza_pargona_code" id="mouza_pargona_code" value="<?=$doul_detail->mouza_pargona_code?>">
                                        <input type="hidden" name="lot_no" id="lot_no" value="<?=$doul_detail->lot_no?>">
                                        <input type="hidden" name="vill_townprt_code" id="vill_townprt_code" value="<?=$doul_detail->vill_townprt_code?>">
                                        <input type="hidden" name="patta_type_code" id="patta_type_code" value="<?=$doul_detail->patta_type_code?>">
                                        <input type="hidden" name="patta_no" id="patta_no" value="<?=$doul_detail->patta_no?>">
                                        <div class="modal-body">
                                            <label>Enter Circle Officer Remarks</label>
                                            <textarea class="form-control" rows="5" placeholder="Enter Remarks Here..." type="text" name="co_remarks" id="co_remarks"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="saveBtn('<?= $unique_id ?>')">Save Remarks</button>
                                        </div>
                                        </form>
                                        </div>
                                        
                                    </div>
                                    </div>
    
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-form p-1 mb-5">
        <div class="col-lg-12 mt-1 text-center">
            <a href="<?php echo base_url().'index.php/home/index'?>" class="btn btn-danger btn-sm text-white" role="button"
                style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                <i class="glyphicon glyphicon-remove-sign"></i>
                BACK TO HOME PAGE
            </a>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {
    $('#mouzdar_view_doul_table').DataTable({
        paging: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        language: {
            search: "Search:",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }
    });
});
</script>

<script>
function closeModal(modalId) {
    $('#' + modalId).modal('hide');
}
</script>

<script>
    function saveBtn(unique_id) {
        event.preventDefault();
        var unq_form = 'co_remarksForm_' + unique_id;
        var formdata = $('#' + unq_form).serialize();

        $.ajax({
            url: '<?= base_url("index.php/EkhajanaDoulVerify/saveCoRemarks") ?>',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            beforeSend: function () {
                console.log("Loader Code Display");
            },
            success: function (data) {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: data.msg,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); 
                        // $('#co_remarksModal_' + unique_id).modal('hide');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: data.msg || 'Something went wrong.',
                    });
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Could not complete your request. Please try again later.',
                });
            }
        });
    }
</script>




