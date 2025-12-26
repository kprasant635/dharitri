<?php
$this->load->helper('html');
$this->load->helper('url');
?>

<!-- <div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h4>LAC Approval List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $key => $res): ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $res['remark']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success" role="alert">
    <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
    <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<table class="datatable table table-stripped" id="datatable">
    <thead style="font-size:7px">
        <tr>
            <th>Sl No</th>
            <th>Circle</th>
            <th>Mouza</th>
            <th>Lot No</th>
             <th>Village</th>
           <th>Patta Type</th>
            <th>Patta No</th> 
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url(); ?>index.php/JamaRemarks/updateRemarks">
                <div class="modal-body">
                    <input type="hidden" name="dist_code" id="dist_code">
                    <input type="hidden" name="subdiv_code" id="subdiv_code">
                    <input type="hidden" name="cir_code" id="cir_code">
                    <input type="hidden" name="mouza_pargona_code" id="mouza_pargona_code">
                    <input type="hidden" name="lot_no" id="lot_no">
                    <input type="hidden" name="vill_townport_code" id="vill_townport_code">
                    <input type="hidden" name="patta_type_code" id="patta_type_code">
                    <input type="hidden" name="patta_no" id="patta_no">
                    <input type="hidden" name="rmk_line_no" id="rmk_line_no">
                    <h6>Existing Remark</h6>
                    <div id="remark_input"></div>

                    <h6>Modified Remark</h6>
                    <div id="remark_input_up" style="background-color: #c1efc1;"></div>
                    <textarea id="remark_input_hidn" name="remark_input" class="form-control" rows="4" cols="50" hidden></textarea>

                    <div class="form-control">
                        <input type="checkbox" id="checkbox" name="checkbox" value="Yes" required>
                        <label for="checkbox"> I do hereby declare that all the details provided by me in this form are true to the best of my belief and knowledge.</label><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>

<script>
    $(document).ready(function() {
        load_data();

        function load_data() {
            var base_url = "<?= base_url(); ?>";


            
            $('#datatable').DataTable({
                pageLength: 5,
                processing: true,
                serverSide: true,
                ordering: false,
                destroy: true, // optional if reinitializing
                lengthMenu: [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                language: {
                    processing: '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                ajax: {
                    url: base_url + 'index.php/JamaRemarks/loadTableData',
                    type: 'POST',
                    data: function(d) {
                        d.service = null; // only if needed by backend
                    }
                },
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    className: "dt-center"
                }],
                order: [
                    [0, 'asc']
                ]
            });
        }
    });


    function openModel(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townport_code, patta_type_code, patta_no, rmk_line_no) {
        var base_url = "<?= base_url(); ?>";
        $.ajax({
            url: base_url + 'index.php/JamaRemarks/getRemark',
            type: 'GET', // or 'POST' based on your API requirement
            data: {
                dist_code: dist_code,
                subdiv_code: subdiv_code,
                cir_code: cir_code,
                mouza_pargona_code: mouza_pargona_code,
                lot_no: lot_no,
                vill_townport_code: vill_townport_code,
                patta_type_code: patta_type_code,
                patta_no: patta_no,
                rmk_line_no: rmk_line_no
            },
            success: function(response) {

                console.log(response);
                $('#dist_code').val(dist_code),
                    $('#subdiv_code').val(subdiv_code),
                    $('#cir_code').val(cir_code),
                    $('#mouza_pargona_code').val(mouza_pargona_code),
                    $('#lot_no').val(lot_no),
                    $('#vill_townport_code').val(vill_townport_code),
                    $('#patta_type_code').val(patta_type_code),
                    $('#patta_no').val(patta_no),
                    $('#rmk_line_no').val(rmk_line_no),
                    $('#remark_input').html(response.remark);
                    $('#remark_input_hidn').html(response.updated_remark);
                    $('#remark_input_up').html(response.updated_remark);
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            }
        });
    }
</script>