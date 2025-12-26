<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link href="<?php echo base_url(); ?>application/views/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/select2/select2.js"></script>
<div class="row login">
    <?php if($flow_index==0){?>
    <div class="col-lg-12">
        <div class="panel panel-form">
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="hidden" class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" value="<?=$dist_code?>">
                            <input type="hidden" class="form-control subdivselect" id="select" name="subdiv_code" value="<?=$subdiv_code?>">
                            <label for="">Circle</label>
                            <?php
                            $d = $this->utilityclass->getAllCircleName($dist_code, $subdiv_code);
                            ?>
                            <select  class="form-control circleselect" id="select" required name="circle_code">
                                <!-- <option selected disabled>Select Circle</option> -->
                                <?php foreach ($d as $name) { 
                                    if($name->cir_code == $cir_code){
                                    ?>
                                    <option value="<?php echo $name->cir_code; ?>">
                                        <?php echo $name->loc_name; ?>
                                    </option>

                                <?php }} ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">Mouza</label>
                            <select class="form-control mouzaselect" id="mouza_code" required name="mouza_code">
                                <option value="<?=$this->session->userdata('mouza_pargona_code')?>"><?=$this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'))?></option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">Lot No</label>
                            <select class="form-control lotselect" id="lot_no" name="lot_no">
                                <option value="">Select Lot</option>
                                <option value="<?=$this->session->userdata('lot_no')?>"><?=$this->utilityclass->getLotName($dist_code,$subdiv_code,$cir_code,$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'))?></option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">Village</label>
                            <select class="form-control villageselect" id="vill_code" name="vill_code" onchange="loaddag()">
                                <option disabled selected>Select Village/Town</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Dag No</label>
                            <!-- <input type="text" class="form-control" name="dag_no" id="dag_no"> -->
                            <select class="form-control js-example-basic-single" id="dag_no" name="dag_no">
                            </select>
                        </div>
                        <div class="col-lg-3" style="margin-top:20px;">
                            <input type="button" class="btn btn-primary" value="Search" onclick="LoadData()">
                        </div>
                    </div>  
                </div>  
            </div>
        </div>
    </div>
    <?php } ?>

        
    <div class="col-lg-12 ">
        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        <div class="well well-sm mis_report">
            <?php if ($flow_index == 0) { ?>
                <h3 style="text-align: center; font-size: 28px;">List of Pattadar name change in Govt. Dag(s)</h3>
            <?php } else { ?>
                <h3 style="text-align: center; font-size: 28px;">Applications received for Pattadar name change in Govt. Dag(s)</h3>
            <?php } ?>
        </div>

                    
        <div class="panel panel-form">
            <div class="panel-body">
                <table class="table table-striped tab1" id="datatable">
                    <thead>
                        <tr>
                            <th>SL. No.</th>
                            <th>Village</th>
                            <th>Dag No</th>
                            <th>Pattadar Name</th>
                            <th>Guardian Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>


<div id="exampleModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change Pattadar Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col md-<?=$flow_index==0?12:6?>">
                        <input type="hidden" name="dist_code" id="dist_code">
                        <input type="hidden" name="subdiv_code" id="subdiv_code">
                        <input type="hidden" name="cir_code" id="cir_code">
                        <input type="hidden" name="mouza_pargona_code" id="mouza_pargona_code">
                        <input type="hidden" name="lot_no" id="lot_no">
                        <input type="hidden" name="dagg" id="dagg">
                        <input type="hidden" name="vill_townport_code" id="vill_townport_code">
                        <input type="hidden" name="patta_no" id="patta_no">
                        <input type="hidden" name="pdar_id" id="pdar_id">
                        <input type="hidden" name="patta_type_code" id="patta_type_code">
                        <input type="hidden" name="app_id" id="app_id">
                        <input type="hidden" name="random_no" id="random_no">
                        <label for="">Pattadar Name</label>
                        <input type="text" name="pdar_name" id="pdar_name" class="form-control" required>

                        <label for="">Guardian Name</label>
                        <input type="text" name="gua_name" id="gua_name" class="form-control" required>

                        <label for="">Comment</label>
                        <textarea id="comment" name="comment" class="form-control" rows="4" cols="50" required></textarea>
                        </br>
                        <?php include(APPPATH.'views/GovNameChange/multipleUpload.php')?>
                    </div>
                    <?php if($flow_index!=0){?>
                    <div class="col md-6" id="comments_sec">
                        
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
        $('.tab1').DataTable({
            pageLength: 100
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        var flow_index = <?php echo (int)$flow_index; ?>;
        if (flow_index !== 0) {
            LoadData();
        }
    });
    var base_url = "<?= base_url(); ?>";

    function loaddag(){
        var data = {
            mouza: $("#mouza_code").val(),
            lot: $("#lot_no").val(),
            village: $("#vill_code").val(),
            dag: $("#dag_no").val(),
        };
        var base_url = "<?= base_url(); ?>";
        $.ajax({
            url: base_url + 'index.php/GovNameChangeController/loadDag',
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
                $("#dag_no").empty();
                $("#dag_no").append(response);
            },
            error: function(xhr, status, error) {
                console.error("Error saving data:", error);
            }
        });
        
    }
    function LoadData() {
        var base_url = "<?= base_url(); ?>";
        $('#datatable').DataTable({
            pageLength: 5,
            processing: true,
            serverSide: true,
            ordering: false,
            destroy: true,
            lengthMenu: [
                [5, 10, 20, 50, 100],
                [5, 10, 20, 50, 100]
            ],
            language: {
                processing: '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            ajax: {
                url: base_url + 'index.php/GovNameChangeController/loadTableData',
                type: 'POST',
                data: function(d) {
                    d.dist_code = $("#dist_code").val();
                    d.subdiv_code = $("#subdiv_code").val();
                    d.cir_code = $("#cir_code").val();
                    d.mouza = $("#mouza_code").val();
                    d.lot = $("#lot_no").val();
                    d.village = $("#vill_code").val();
                    d.dag = $("#dag_no").val();
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




    function openModel(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, patta_no, pdar_id, patta_type_code,rand,pdar_name='',pdar_father='',id='') {
        var app_id = dist_code+subdiv_code+cir_code+mouza_pargona_code+lot_no+vill_townprt_code+dag_no+pdar_id+'-'+rand;
        // alert(app_id);
        $.ajax({
            url: base_url + 'index.php/GovNameChangeController/loadDoc',
            type: 'POST',
            data: { app_id: app_id, id: id },
            dataType: 'json',
            success: function(response) {
                $('#otherFiles').empty(); // clear previous rows if needed
                $('#comments_sec').empty();
                $('#otherFiles').show();
                $.each(response.document, function(index, data) {
                    // Use the correct keys from the response
                    var file_link = data.file_path; // or base_url + 'uploads/mb2/' + data.fetch_file_name if path is relative
                    var tr = '<tr id="tri' + data.id + '"><td>' +
                        data.file_name +
                        '</td><td><a href="' + file_link + '" target="_blank">VIEW FILE' +'</td></tr>';
                    console.log()
                    $('#otherFiles').append(tr);
                });
                var comment = '';
                let changes = JSON.parse(response.application.changes); // parse JSON string to object

                $.each(changes, function(index, data) {
                    comment += `
                        <label class="d-block">${index} ${data.date}</label>
                        <label class="d-block ms-4 text-muted">${data.comment}</label>
                    `;
                });

                $('#comments_sec').append(comment);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

        $("#dist_code").val(dist_code);
        $("#subdiv_code").val(subdiv_code);
        $("#cir_code").val(cir_code);
        $("#mouza_pargona_code").val(mouza_pargona_code);
        $("#lot_no").val(lot_no);
        $("#vill_townport_code").val(vill_townprt_code);
        $("#dagg").val(dag_no);
        $("#patta_no").val(patta_no);
        $("#pdar_id").val(pdar_id);
        $("#patta_type_code").val(patta_type_code);
        $("#app_id").val(app_id);
        $("#random_no").val(rand);
        $("#pdar_name").val(pdar_name);
        $("#gua_name").val(pdar_father);

        

    }


    function saveChanges() {
        var data = {
            dist_code: $("#dist_code").val(),
            subdiv_code: $("#subdiv_code").val(),
            cir_code: $("#cir_code").val(),
            mouza_pargona_code: $("#mouza_pargona_code").val(),
            lot_no: $("#lot_no").val(),
            vill_townport_code: $("#vill_townport_code").val(),
            dag_no: $("#dagg").val(),
            patta_no: $("#patta_no").val(),
            pdar_id: $("#pdar_id").val(),
            patta_type_code: $("#patta_type_code").val(),
            pdar_name: $("#pdar_name").val(),
            father_name: $("#gua_name").val(),
            random_no: $("#random_no").val(),
            comment: $('#comment').val(),

        };
        $.ajax({
            url: base_url + 'index.php/GovNameChangeController/saveChanges',
            type: 'POST',
            data: data,
            dataType: 'json', // Parse JSON automatically
            success: function(response) {
                if (response && response.status === 'success') {
                    LoadData();
                    $('#exampleModal .close').click();
                    $('.modal-backdrop').remove();
                    console.log(response.message);
                    alert(response.message); // Show actual message
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error saving data:", error);
                alert("An error occurred while saving data.");
            }
        });
    }

</script>
