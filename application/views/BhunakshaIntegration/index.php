<div class="row login">
    <div class="col-lg-12">
        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-success" role="alert">
                <?=$this->session->flashdata('message')?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?=$this->session->flashdata('error')?>
            </div>
        <?php endif; ?>

        <div class="well well-sm mis_report">
            <h3 style="text-align: center; font-size: 28px">List Of Pending Bhunaksha Pending Cases</h3>
            <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
        </div>

        <div class="panel panel-form">
            <div class="panel-body">
                <div class="form-group">
                    <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Case No.</label>
                            <input type="text" name="case_no" class="form-control" value="<?= $this->input->get('case_no') ?>">

                        </div>
                        <div class="col-md-3">
                            <label for="">Filter By Split Status</label>
                            <select name="split_filter" id="split_filter" class="form-control">
                                <option value="">--select--</option>
                                <option value="0" <?= ($this->input->get('split_filter') === '0') ? 'selected' : '' ?>>Pending For Split</option>
                                <option value="1" <?= ($this->input->get('split_filter') === '1') ? 'selected' : '' ?>>Forwarded For Split</option>
                                <option value="2" <?= ($this->input->get('split_filter') === '2') ? 'selected' : '' ?>>Completed Split</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Filter By Property Status</label>
                            <select name="property_filter" id="property_filter" class="form-control">
                                <option value="">--select--</option>
                                <option value="0" <?= ($this->input->get('property_filter') === '0') ? 'selected' : '' ?>>Pending for Add Property</option>
                                <option value="1" <?= ($this->input->get('property_filter') === '1') ? 'selected' : '' ?>>Added Property</option>
                                <option value="2" <?= ($this->input->get('property_filter') === '2') ? 'selected' : '' ?>>Complteted</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary btn-sm" style="margin-top: 24px;">Filter</button>
                        </div>
                    </div>
                    </form>
                </div>
                <table class="table table-striped tab1">
                    <thead>
                        <tr>
                            <th>Mouza</th>
                            <th>Lot No.</th>
                            <th>Village</th>
                            <th>Dag No.</th>
                            <th>New Dag No.</th>
                            <th>Case No.</th>
                            <th>Mutation Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $key => $rec): ?>
                            <tr>
                                <td><?= $this->utilityclass->getMouzaName($rec->dist_code, $rec->subdiv_code, $rec->cir_code, $rec->mouza_pargona_code) ?></td>
                                <td><?= $this->utilityclass->getLotName($rec->dist_code, $rec->subdiv_code, $rec->cir_code, $rec->mouza_pargona_code,$rec->lot_no) ?></td>
                                <td><?= $this->utilityclass->getVillageName($rec->dist_code, $rec->subdiv_code, $rec->cir_code, $rec->mouza_pargona_code, $rec->lot_no, $rec->vill_townprt_code) ?></td>
                                <td><?= $rec->dag_no ?></td>
                                <td><?= $rec->new_dag_no ?></td>
                                <td><?= $rec->case_no ?></td>
                                <td><?= !empty($rec->mutation_date) ? date('d-m-Y', strtotime($rec->mutation_date)) : '' ?></td>
                                <td>
                                    <?php if($rec->status==0 && $rec->is_full_dag == 0){ ?>
                                    <form action="<?= base_url('index.php/BhunakshaIntegrationController/splitDag') ?>" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $rec->id ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Split Case</button>
                                    </form>
                                    <?php }?>
                                    <?php if($rec->property_status==0){ ?>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="appendIDToFormData(<?=$rec->id;?>)">Add Property</button>
                                    <?php }?>
                                    <?php if($rec->property_status==1){ ?>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="appendIDToFormData(<?=$rec->id;?>)">Edit Property</button>
                                    <?php }?>
                                    <?php if($rec->property_status==2){ ?>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="appendIDToFormData(<?=$rec->id;?>)">Show Property</button>
                                    <?php }?>
                                    
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?php echo base_url()?>/index.php/BhunakshaIntegrationController/storePropertyDetails" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Property Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Case No:</label>
                            <input readonly id="case_no_fetched" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="">Dag No:</label>
                            <input readonly id="dag_no_fetched" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <label for="">Area B:</label>
                            <input readonly id="area_fetched_B" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <label for="">Area K:</label>
                            <input readonly id="area_fetched_K" class="form-control">
                        </div>
                        <div class="col-md-1">
                           <label for="">Area <?php echo ($is_barak_valley == true ? 'C' : 'LC'); ?>:</label>
                            <input readonly id="area_fetched_L" class="form-control">
                        </div>
                        <?php if($is_barak_valley){?>
                            <div class="col-md-1">
                                <label for="">Area G:</label>
                                <input readonly id="area_fetched_G" class="form-control">
                            </div>
                        <?php }?>
                    </div>
                    <input type="hidden" name="primary_key" id="primary_key">
                    <div id="properties" style="margin-top:10px;">

                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-2" id="add_new_btn">
                            
                        </div>        
                    </div>
                </div>
                <div class="modal-footer" id="submit_btn">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    const PROPERTY_TYPE_OPTIONS = <?php echo json_encode(PROPERTY_TYPE_OPTIONS); ?>;
    var prop_id = 1;
    $(document).ready(function() {
        $('.tab1').DataTable({
            pageLength: 100
        });
        // addMoreProperty();
    });

    var add_html = `<button type="button" class="btn btn-secondary" onclick="addMoreProperty()">Add New Property</button>`;
    var save_html = `<button type="submit" class="btn btn-primary">Save changes</button>`;

    function appendIDToFormData(id){
        $("#properties").empty();
        $("#add_new_btn").empty();
        $("#submit_btn").empty();
        $("#primary_key").val(id);
        $.ajax({
            url: "<?= base_url('index.php/BhunakshaIntegrationController/getPropertyList'); ?>", 
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function(response){
                console.log(response.case_details.case_no);
                $("#case_no_fetched").val(response.case_details.case_no);
                $("#dag_no_fetched").val(response.case_details.dag_no);
                $('#area_fetched_B').val(response.chitha_basic.dag_area_b);
                $('#area_fetched_K').val(response.chitha_basic.dag_area_k);
                $('#area_fetched_L').val(response.chitha_basic.dag_area_lc);
                $('#area_fetched_G').val(response.chitha_basic.dag_area_g);
                if (response.prop_details && response.prop_details.length > 0) {
                    if(response.case_details.property_status == 1){
                        $("#add_new_btn").append(add_html);
                        $("#submit_btn").append(save_html);
                    }
                    $.each(response.prop_details, function(index, item){
                        addMoreProperty(
                            item.id,
                            item.property_type,
                            item.build_up_area,
                            item.total_area,
                            item.tax,
                            item.property_value,
                            item.encumbrance_details
                        );
                    });
                } else {
                    addMoreProperty();
                    $("#add_new_btn").append(add_html);
                    $("#submit_btn").append(save_html);
                }
            },
            error: function(xhr, status, error){
                console.error("Error: " + error);
            }
        });
    }

    function addMoreProperty(p_d_id='',property_type='', build_up_area='', total_area='', tax='', property_value='', encumbrance_details='') {
        let optionsHtml = '<option value="">--select--</option>';
        PROPERTY_TYPE_OPTIONS.forEach(type => {
            let selected = (type === property_type) ? "selected" : "";
            optionsHtml += `<option value="${type}" ${selected}>${type}</option>`;
        });

        let html = `
        <div id="`+prop_id+`">
            <div class="row">
                <div class="col-md-5">
                    <label for="">Property Type<span style="color:red">*</span></label>
                    <input type="hidden" name="p_d_id[]" value="${p_d_id}">
                    <select class="form-control" name="property_type[]" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="">Built-up Area (In sq. feet)<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="build_up_area[]" value="${build_up_area}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="">Total Area (In sq. feet)<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="total_area[]" value="${total_area}" required>
                </div>
                <div class="col-md-5">
                    <label for="">Property or House Tax<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="tax[]" value="${tax}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="">Property Value<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="property_value[]" value="${property_value}" required>
                </div>
                <div class="col-md-5">
                    <label for="">Encumbrance Details<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="encumbrance_details[]" value="${encumbrance_details}" required>
                </div>
                <div class="col-md-2">
                    <button type="button" onclick="deleteProperty(`+prop_id+`,`+p_d_id+`)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
            <hr>
        </div>
        `;

        $("#properties").append(html);
        prop_id = prop_id + 1;
    }


    function deleteProperty(id, p_d_id) {
        if (p_d_id) {
            $.ajax({
                url: "<?= base_url('index.php/BhunakshaIntegrationController/deleteProperty'); ?>",
                type: "POST",
                data: { id: p_d_id },
                dataType: "json",
                success: function(response) {
                    // Show the message
                    alert(response.message);

                    // Remove element only if deletion was successful
                    if (response.status === 'success') {
                        $("#" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    alert("Error deleting property: " + error);
                }
            });
        }else{
            $("#" + id).remove();
        }
    }

</script>