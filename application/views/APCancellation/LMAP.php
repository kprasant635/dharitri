<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('ap_cancellation');?></h2>
                </div>
            </div>

            <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="myForm" enctype="multipart/form-data">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php echo $this->lang->line('select_land_location');?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" >
                                <label for="dist_code" class="col-lg-4 control-label">
                                    <?php echo $this->lang->line('district');?></label>
                                <div class="col-lg-6">

                                    <input type="hidden" name="dist_code" class="districtselect"
                                        value="<?php echo $dist_code; ?>" />
                                    <input type="text" name="dist" class="form-control " readonly="readonly"
                                        value="<?php echo $dist[0]->district;?>" />

                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="subdiv_code" class="col-lg-4 control-label">
                                    <?php echo $this->lang->line('subdivision');?></label>
                                <div class="col-lg-6">
                                    <input type="hidden" name="subdiv_code" class="subdivselect"
                                        value="<?php echo $subdiv_code?>" />
                                    <input type="text" name="subd" class="form-control " readonly="readonly"
                                        value="<?php echo $subdiv[0]->subdiv; ?>" />

                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="cir_code" class="col-lg-4 control-label">
                                    <?php echo $this->lang->line('circle');?></label>
                                <div class="col-lg-6">
                                    <input type="hidden" name="circle_code" class="circleselect"
                                        value="<?php echo $cir_code?>" />

                                    <input type="text" name="cir" class="form-control " readonly="readonly"
                                        value="<?php echo $circle[0]->circle; ?>" />

                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="mouza_code" class="col-lg-4 control-label">
                                    <?php echo $this->lang->line('mouza');?></label>
                                <div class="col-lg-6">
                                    <input type="hidden" name="mouza_code" class="mouzaselect"
                                        value="<?php echo $mouza_pargona_code?>" />
                                    <input type="text" name="mouza" class="form-control " readonly="readonly"
                                        value="<?php echo $mouza[0]->mouza; ?>" />

                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="lot_no" class="col-sm-4 control-label">
                                    <?php echo $this->lang->line('lot_no');?></label>
                                <div class="col-sm-6">

                                    <input type="hidden" name="lot_no" class="lotselect"
                                        value="<?php echo $lot_no?>" />
                                    <input type="text" name="cir" class="form-control " readonly="readonly"
                                        value="<?php echo $lot[0]->lot_no; ?>" />

                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="vill_code" class="col-sm-4 control-label">
                                    <?php echo $this->lang->line('vill_town');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="vill_code" required name="vill_code">
                                        <option value=""><?php echo $this->lang->line('select_vill_town');?>
                                        </option>
                                        <?php foreach ($villagelist AS $v) { ?>
                                        <option value="<?php echo $v->vill_code; ?>"><?php echo $v->village; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('vill_code', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Patta Type<br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" >
                                <label for="mut_type"
                                    class="col-lg-4 control-label"><?php echo $this->lang->line('mutation_type');?></label>
                                <div class="col-lg-6">
                                    <select class="form-control " id="mut_type" name="mut_type" required>
                                        <option value="0504">পট্টা ৰদ (একচনা পট্টা)</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group" >
                                <label for="patta_type_code"
                                    class="col-sm-4 control-label"><?php echo $this->lang->line('patta_type');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control " id="patta_type_code" name="patta_type_code" required>
                                        <option value="">Select Patta type</option>
                                        <?php foreach ($eksonapatta AS $patta) { ?>
                                        <option value="<?php echo $patta->type_code; ?>">
                                            <?php echo $patta->patta_type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="patta_no"
                                    class="col-sm-4 control-label"><?php echo $this->lang->line('patta_no');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control" autocomplete="off" name="patta_no" id="patta_no"
                                        required></select>
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="APC_dag_no" class="col-sm-4 control-label">
                                    <?php echo $this->lang->line('dag_no');?></label>
                                <div class="col-lg-6">
                                    <select class="form-control " id="APC_dag_no" name="APC_dag_no" required>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                First Party<br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered" width="100%" id="PetitionerTable">
                                <thead>
                                    <th>Sl No</th>
                                    <th>Petitioner Name</th>
                                    <th>Guardian Name</th>
                                    <th>Relation</th>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>
                                        <button type="button" id="addPetitioner" class="btn btn-primary btn-sm"
                                            onclick="openPetitionerModal();">Add
                                            Petitioner</button>

                                    </th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="hidden" name="petitioners_data" id="petitioners_data" value="">


                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Second Party<br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered" width="100%" id="pdarTable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no');?></th>
                                        <th>
                                            <?php echo $this->lang->line('pattadar_name');?>
                                        </th>
                                        <th>
                                            <?php echo $this->lang->line('guardian_name');?>
                                        </th>
                                        <th>
                                            <?php echo $this->lang->line('relation');?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-heading d-flex justify-content-between align-items-center">
                            <h3 class="panel-title mb-0">
                                Upload supporting documents
                            </h3>
                            <input type="hidden" name="UploadDocumentData" id="UploadDocumentData" value="">
                            <button class="rezaButt btn btn-sm btn-warning" type="button" id="btnUploadDocument"
                                onclick="openAddDocumentModal()">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                Click to add
                            </button>
                        </div>
                        <div class="panel-body" id="documentList">

                        </div>
                    </div>
                </div>



                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Designation<br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" >
                                <label for="add_off_name"
                                    class="col-sm-4 control-label"><?php echo $this->lang->line('address_to_the_officer');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control " id="add_off_name" name="add_off_name" required>
                                        <option value=""><?php echo "-- ".$this->lang->line('select')." --";?>
                                        </option>
                                        <?php foreach ($coname AS $name) { ?>
                                        <option value="<?php echo $name->user_code; ?>"><?php echo $name->username; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label for="add_off_Desig"
                                    class="col-sm-4 control-label"><?php echo $this->lang->line('designation');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control " id="add_off_Desig" name="add_off_Desig" required>
                                        <option value="CO" selected><?php echo $this->lang->line('co');?></option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <div class="form-group" >
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="ASTSubmit" id="ASTSubmit" class="btn btn-primary"
                                        onclick="showForm()"><i
                                            class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index"
                                        class="btn btn-md btn-danger"> <i class="fa fa-arrow-left"></i>&nbsp;
                                        <?php echo $this->lang->line('back_to_main_menu');?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
        </div>
    </div>
</div>


<!-- Add Petitioner Modal -->
<div id="addPetitionerData" class="modal">
    <!-- Centered and responsive -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="modal-content p-4">
                    <div class="row text-right">
                        <span class="closefamily px-4">&times;</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5>Add Document</h5>
                        </div>
                    </div>

                    <table class="table">
                        <tr>
                            <th>Petitioner Name</th>
                            <td>
                                <input type="text" id="add_Petitioner_name" name="add_Petitioner_name"
                                    placeholder="Petitioner Name" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Guardian Name</th>
                            <td>
                                <input type="text" id="add_guardian_name" name="add_guardian_name"
                                    placeholder="Guardian Name" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Relation</th>
                            <td>
                                <select id="add_relation" class="form-control" name="add_relation">
                                    <option value="">Select</option>
                                    <?php foreach($relation AS $rel){?>
                                    <option value="<?php echo $rel->guard_rel;?>">
                                        <?php echo $rel->guard_rel_desc;?> [<?php echo $rel->guard_rel_desc_as;?>]
                                    </option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Address 1</th>
                            <td>
                                <textarea name="add_address1" id="add_address1" class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Address 2</th>
                            <td>
                                <textarea name="add_address1" id="add_address2" class="form-control"></textarea>
                            </td>
                        </tr>
                    </table>

                    <div class="row justify-content-center">
                        <button type="button" onclick="addPetitionerDetails();"
                            class="btn btn-sm btn-danger col-3">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload document Modal -->
<div id="UploadDocument" class="modal">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="modal-content p-4">
                    <div class="row text-right">
                        <span class="closefamily px-4">&times;</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5>Add Document</h5>
                        </div>
                    </div>

                    <table class="table">
                        <tr>
                            <th>Document Name</th>
                            <td>
                                <input type="text" id="add_document_name" name="add_document_name"
                                    placeholder="Document Name" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Document File</th>
                            <td>
                                <input type="file" id="add_document_file" name="add_document_file"
                                    placeholder="Document File" class="form-control">
                            </td>
                        </tr>
                    </table>
                    <div class="row justify-content-center mb-2">
                        <button type="button" class="btn btn-sm btn-danger col-3" onclick="addDocument()">Add</button>
                    </div>

                    <div class="row justify-content-center">
                        <button type="button" class="btn btn-sm btn-secondary col-3"
                            onclick="hideUploadDocument()">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Submitted for Modal -->
<div id="finalFormData" class="modal">
    <!-- Centered and responsive -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="modal-content p-4">
                    <div class="row text-right">
                        <span class="closefamily px-4">&times;</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5>Confirmation</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><b>District: </b></div>
                        <div class="col-md-9" id="form_dist"><?php echo $dist[0]->district;?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><b>Sub-div: </b></div>
                        <div class="col-md-9" id="form_subd"><?php echo $subdiv[0]->subdiv; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Circle: </b></div>
                        <div class="col-md-9" id="form_cir"><?php echo $circle[0]->circle; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Mouza: </b></div>
                        <div class="col-md-9" id="form_mouza"><?php echo $mouza[0]->mouza; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Lot No: </b></div>
                        <div class="col-md-9" id="form_lot_no"><?php echo $lot[0]->lot_no; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Village/Town: </b></div>
                        <div class="col-md-9" id="form_vill_code"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Mutation Type: </b></div>
                        <div class="col-md-9" id="form_mut_type"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Patta Type: </b></div>
                        <div class="col-md-9" id="form_patta_type"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Patta No: </b></div>
                        <div class="col-md-9" id="form_patta_no"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Dag No: </b></div>
                        <div class="col-md-9" id="form_dag_no"></div>
                    </div>
                    <div class="row">
                        <b>First party</b>
                    </div>


                    <table class="table table-striped table-bordered" width="100%" id="formPetitionerTable">
                        <thead>
                            <th>Sl No</th>
                            <th>Petitioner Name</th>
                            <th>Guardian Name</th>
                            <th>Relation</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="row">
                        <b>Second party</b>
                    </div>

                    <table class="table table-striped table-bordered" width="100%" id="formpdarTable">
                        <thead>
                            <th>Sl No</th>
                            <th>Pattadar Name</th>
                            <th>Guardian Name</th>
                            <th>Relation</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="row" id="formdocumentList">

                    </div>

                    <div class="row">
                        <div class="col-md-3"><b>Addressing Officer: </b></div>
                        <div class="col-md-9" id="form_add_off_name"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b>Designation: </b></div>
                        <div class="col-md-9" id="form_add_off_Desig"><?php echo $this->lang->line('co');?></div>
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <button type="button" class="btn btn-sm btn-secondary col-3" onclick="hideForm()">Back</button>
                    </div>
                    <div class="row justify-content-center">
                        <button type="button" class="btn btn-sm btn-danger col-3" onclick="submitForm()">Final
                            Submit</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const villageSelectElm = document.getElementById("vill_code");
    const pattaSelect = document.getElementById("patta_no");
    const pattaTypeCodeElem = document.getElementById("patta_type_code");
    const APC_dag_noSelect = document.getElementById("APC_dag_no");

    villageSelectElm.addEventListener("change", loadPattaNumber);
    pattaTypeCodeElem.addEventListener("change", loadPattaNumber);
    pattaSelect.addEventListener("change", loadDagNumber);
    APC_dag_noSelect.addEventListener("change", loadPdar);



    function loadPattaNumber() {
        const villageSelect = villageSelectElm.value;
        const pattaTypeCode = pattaTypeCodeElem.value;

        // Send POST request with selected values
        fetch("<?=BASE_JS_LINK?>APCancellation/getPatta_no", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `village_id=${encodeURIComponent(villageSelect)}&patta_type_code=${encodeURIComponent(pattaTypeCode)}`
            })
            .then(response => response.json())
            .then(data => {
                // Clear existing options
                pattaSelect.innerHTML = "";
                APC_dag_noSelect.innerHTML = "";
                const tableBody = document.querySelector("#pdarTable tbody");
                tableBody.innerHTML = "";

                // Add default option
                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Select Patta No";
                pattaSelect.appendChild(defaultOption);

                // Populate patta_no select with new options
                data.forEach(patta => {
                    const option = document.createElement("option");
                    option.value = patta;
                    option.text = patta;
                    pattaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Error fetching patta numbers:", error);
            });

    }

    function loadDagNumber() {
        const villageSelect = villageSelectElm.value;
        const pattaTypeCode = pattaTypeCodeElem.value;
        const patta_no = pattaSelect.value;

        // Send POST request with selected values
        fetch("<?=BASE_JS_LINK?>APCancellation/getAvailDags", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `village_id=${encodeURIComponent(villageSelect)}&patta_type_code=${encodeURIComponent(pattaTypeCode)}&patta_no=${encodeURIComponent(patta_no)}`
            })
            .then(response => response.json())
            .then(data => {
                // Clear existing options
                APC_dag_noSelect.innerHTML = "";
                const tableBody = document.querySelector("#pdarTable tbody");
                tableBody.innerHTML = "";

                // Add default option
                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Select Dag No";
                APC_dag_noSelect.appendChild(defaultOption);

                // Populate patta_no select with new options
                data.forEach(dag => {
                    const option = document.createElement("option");
                    option.value = dag;
                    option.text = dag;
                    APC_dag_noSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Error fetching dag numbers:", error);
            });

    }

    function loadPdar() {
        const villageSelect = document.getElementById("vill_code").value;
        const pattaTypeCode = document.getElementById("patta_type_code").value;
        const patta_no = document.getElementById("patta_no").value;
        const APC_dag_no = document.getElementById("APC_dag_no").value;

        fetch("<?=BASE_JS_LINK?>APCancellation/getPdarName", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `village_id=${encodeURIComponent(villageSelect)}&patta_type_code=${encodeURIComponent(pattaTypeCode)}&patta_no=${encodeURIComponent(patta_no)}&APC_dag_no=${encodeURIComponent(APC_dag_no)}`
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector("#pdarTable tbody");
                tableBody.innerHTML = ""; // only clears the table body, not other elements

                let spc = 1;

                data.forEach(item => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${spc++}</td>
                        <td>${item.pdar_name}</td>
                        <td>${item.pdar_father}</td>
                        <td>${item.pdar_guard_reln}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Error loading PDAR data:", error);
            });
    }

});
</script>

<script>
const modal = document.getElementById("addPetitionerData");
const closeBtn = document.querySelector(".closefamily");

// Show modal
function openPetitionerModal() {
    modal.style.display = "block";
}

// Close modal
closeBtn.onclick = function() {
    modal.style.display = "none";
};

// Close modal when clicking outside the modal-content
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};


let pdarRowCount = 1;
let editingRow = null;


function addPetitionerDetails() {
    const name = document.getElementById('add_Petitioner_name').value.trim();
    const guardian = document.getElementById('add_guardian_name').value.trim();
    const relation = document.getElementById('add_relation').value.trim();
    const address1 = document.getElementById('add_address1').value.trim();
    const address2 = document.getElementById('add_address2').value.trim();

    if (!name) {
        alert("Please Enter Petitioner Name.");
        document.getElementById('add_Petitioner_name').focus();
        return;
    }
    if (!guardian) {
        alert("Please Enter Guardian Name.");
        document.getElementById('add_guardian_name').focus();
        return;
    }
    if (!relation) {
        alert("Please select relation.");
        document.getElementById('add_relation').focus();
        return;
    }
    if (!address1) {
        alert("Please Enter Address 1.");
        document.getElementById('add_address1').focus();
        return;
    }

    const tableBody = document.querySelector('#PetitionerTable tbody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
                <td>${pdarRowCount}</td>
                <td>${name}</td>
                <td>${guardian}</td>
                <td>${relation}</td>
                <td>${address1}</td>
                <td>${address2}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="deletePetitioner(this)">Delete</button>
                </td>
            `;

    tableBody.appendChild(newRow);
    pdarRowCount++;

    // Update hidden inputs
    updateHiddenInputs();

    // Clear modal form and close
    clearModalForm();
}

function deletePetitioner(btn) {
    const row = btn.closest('tr');
    row.remove();

    // Recalculate Sl No
    const rows = document.querySelectorAll('#PetitionerTable tbody tr');
    rows.forEach((r, i) => {
        r.cells[0].textContent = i + 1;
    });
    pdarRowCount = rows.length + 1;

    // Update hidden inputs
    updateHiddenInputs();
}


function updateHiddenInputs() {
    const rows = document.querySelectorAll('#PetitionerTable tbody tr');
    const petitionersData = [];

    rows.forEach(row => {
        const cells = row.cells;
        petitionersData.push({
            name: cells[1].textContent,
            guardian: cells[2].textContent,
            relation: cells[3].textContent,
            address1: cells[4].textContent,
            address2: cells[5].textContent
        });
    });

    document.getElementById('petitioners_data').value = JSON.stringify(petitionersData);
}


function clearModalForm() {
    document.getElementById('add_Petitioner_name').value = '';
    document.getElementById('add_guardian_name').value = '';
    document.getElementById('add_relation').selectedIndex = 0;
    document.getElementById('add_address1').value = '';
    document.getElementById('add_address2').value = '';
    document.getElementById('addPetitionerData').style.display = 'none';
}




function deletePetitioner(btn) {
    const row = btn.closest('tr');
    row.remove();

    // Recalculate Sl No
    const rows = document.querySelectorAll('#PetitionerTable tbody tr');
    rows.forEach((r, i) => {
        r.cells[0].textContent = i + 1;
    });
    pdarRowCount = rows.length + 1;
}
</script>

<script>
function showForm() {
    const form = document.getElementById("myForm");
    event.preventDefault();

    const vill_code = document.getElementById("vill_code");
    if (!vill_code || vill_code.value.trim() === "") {
        alert("Please select a Village. 'Village code' cannot be empty.");
        vill_code.focus();
        event.preventDefault();
        return;
    }
    const patta_type_code = document.getElementById("patta_type_code");
    if (!patta_type_code || patta_type_code.value.trim() === "") {
        alert("Please select a Patta type. 'Patta type' cannot be empty.");
        patta_type_code.focus();
        event.preventDefault();
        return;
    }
    const patta_no = document.getElementById("patta_no");
    if (!patta_no || patta_no.value.trim() === "") {
        alert("Please select a Patta number. 'Patta number' cannot be empty.");
        patta_no.focus();
        event.preventDefault();
        return;
    }
    const APC_dag_no = document.getElementById("APC_dag_no");
    if (!APC_dag_no || APC_dag_no.value.trim() === "") {
        alert("Please select a Dag number. 'Dag number' cannot be empty.");
        APC_dag_no.focus();
        event.preventDefault();
        return;
    }
    const petitioners_data = document.getElementById("petitioners_data");
    if (!petitioners_data || petitioners_data.value.trim() === "") {
        alert("Please Enter at least one First Party.");
        event.preventDefault();
        openPetitionerModal();
        document.getElementById("add_Petitioner_name").focus();
        return;
    }
    const add_off_name = document.getElementById("add_off_name");
    if (!add_off_name || add_off_name.value.trim() === "") {
        alert("Please select a Addressing Officer. 'Addressing Officer' cannot be empty.");
        add_off_name.focus();
        event.preventDefault();
        return;
    }

    const modal = document.getElementById("finalFormData");
    const closeBtn1 = document.querySelector(".closefamily");

    modal.style.display = "block";

    const form_vill_code = document.getElementById("form_vill_code");
    form_vill_code.innerText = vill_code.options[vill_code.selectedIndex].text;

    const form_mut_type = document.getElementById("form_mut_type");
    const mut_type = document.getElementById("mut_type");
    form_mut_type.innerText = mut_type.options[mut_type.selectedIndex].text;



    const form_patta_type = document.getElementById("form_patta_type");
    form_patta_type.innerText = patta_type_code.options[patta_type_code.selectedIndex].text;

    const form_patta_no = document.getElementById("form_patta_no");
    form_patta_no.innerText = patta_no.options[patta_no.selectedIndex].text;

    const form_dag_no = document.getElementById("form_dag_no");
    const dag_no = document.getElementById("APC_dag_no");
    form_dag_no.innerText = dag_no.options[dag_no.selectedIndex].text;

    const PetitionerTableBody = document.querySelector("#PetitionerTable tbody");
    const formPetitionerTable = document.querySelector("#formPetitionerTable tbody");

    formPetitionerTable.innerHTML = "";

    const formdocumentList = document.getElementById("formdocumentList");
    const documentList = document.getElementById("documentList");

    formdocumentList.innerHTML = "";

    // Clone only visible document entries
    documentList.querySelectorAll("div.alert").forEach(entry => {
        const clone = entry.cloneNode(true);
        // Remove the remove button in preview
        const removeBtn = clone.querySelector("button");
        if (removeBtn) removeBtn.remove();

        formdocumentList.appendChild(clone);
    });

    PetitionerTableBody.querySelectorAll("tr").forEach(row => {
        const newRow = document.createElement("tr");
        const cells = row.querySelectorAll("td");
        for (let i = 0; i < cells.length - 1; i++) { // skip last cell (action)
            newRow.appendChild(cells[i].cloneNode(true));
        }
        formPetitionerTable.appendChild(newRow);
    });



    const pdarTableBody = document.querySelector("#pdarTable tbody");
    const formpdarTableBody = document.querySelector("#formpdarTable tbody");
    formpdarTableBody.innerHTML = pdarTableBody.innerHTML;

    const form_add_off_name = document.getElementById("form_add_off_name");
    form_add_off_name.innerText = add_off_name.options[add_off_name.selectedIndex].text;
}

function hideForm() {
    const modal = document.getElementById("finalFormData");
    const closeBtn1 = document.querySelector(".closefamily");

    modal.style.display = "none";
}
</script>



<script>
function submitForm() {
    const form = document.getElementById("myForm");


    form.submit();
}
</script>





<!-- JavaScript -->
<script>
function openAddDocumentModal() {
    document.getElementById("UploadDocument").style.display = "block";
}

function hideUploadDocument() {
    document.getElementById("UploadDocument").style.display = "none";
    document.getElementById("add_document_name").value = ""; // reset input
}
</script>



<script>
let documentIndex = 0;

function addDocument() {
    const docNameInput = document.getElementById("add_document_name");
    const fileInput = document.getElementById("add_document_file");

    const docName = docNameInput.value.trim();
    const file = fileInput.files[0];

    if (!docName || !file) {
        alert("Please enter both document name and file.");
        return;
    }

    // Display preview
    const listContainer = document.getElementById("documentList");

    const displayDiv = document.createElement("div");
    displayDiv.className = "alert alert-success py-2 px-3 mb-2 d-flex justify-content-between align-items-center";

    displayDiv.innerHTML = `
        <span><i class="fa fa-paperclip"></i> <strong>${docName}</strong> - ${file.name}</span>
        <button type="button" class="btn btn-xs btn-danger" onclick="removeDocument(this)">Remove</button>
    `;

    // Append display
    listContainer.appendChild(displayDiv);

    // Hidden wrapper inside the form to hold the inputs
    const hiddenWrapper = document.createElement("div");
    hiddenWrapper.className = "hidden-documents";
    hiddenWrapper.style.display = "none";

    // Document name input
    const nameInput = document.createElement("input");
    nameInput.type = "hidden";
    nameInput.name = `documents[${documentIndex}][name]`;
    nameInput.value = docName;

    // File input (new input to retain file binding)
    const newFileInput = document.createElement("input");
    newFileInput.type = "file";
    newFileInput.name = `documents[${documentIndex}][file]`;

    // Use DataTransfer to clone file (modern browsers only)
    const dt = new DataTransfer();
    dt.items.add(file);
    newFileInput.files = dt.files;

    // Append hidden inputs to wrapper
    hiddenWrapper.appendChild(nameInput);
    hiddenWrapper.appendChild(newFileInput);
    listContainer.appendChild(hiddenWrapper);

    // Reset modal
    docNameInput.value = "";
    fileInput.value = "";
    hideUploadDocument();
    documentIndex++;
}

function removeDocument(btn) {
    const docAlert = btn.closest("div.alert");
    const hiddenBlock = docAlert.nextElementSibling; // assumes wrapper is directly after

    if (hiddenBlock && hiddenBlock.classList.contains("hidden-documents")) {
        hiddenBlock.remove();
    }
    docAlert.remove();
}
</script>