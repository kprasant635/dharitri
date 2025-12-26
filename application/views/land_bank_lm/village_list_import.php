<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
    document.onreadystatechange = function(e) {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border: 'none',
                backgroundColor: 'transparent'
            }
        });
    };
    window.onload = function() {
        $.unblockUI();
    }
</script>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankLM/index' ?>">Village Land Bank</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Village-list)</li>
    </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-secondary text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Village-List) <br>
                <?php echo $this->lang->line('mouza') ?> :
                <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code); ?>,
                <?php echo $this->lang->line('lot_no') ?> :
                <?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no); ?>
            </u>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <select name="vill_code" id="vill_code" class="form-control form-control-sm">
                    <option value="">--Select Village--</option>
                    <?php foreach ($villages as $village): ?>
                        <option value="<?= $village->vill_townprt_code ?>"><?= $village->vill_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <!-- <input type="file" name="import_file" id="import_file" class="form-control form-control-sm"> -->
                <input type="file" name="import_file" id="import_file"
                    class="form-control form-control-sm"
                    accept=".xlsx">

            </div>
            <div class="col-md-2">
                <button type="button" onclick="importFile()" id="importBtn" class="btn btn-sm btn-success">Import & Save</button>
                <div id="spinnerBtn" class="spinner-border text-success" role="status" style="display:none; width:1.5rem; height:1.5rem;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="col-md-2">
                <a href="<?php echo base_url() . "application/possesor_format_nc.xlsx"; ?>" class="text-primary" style="float:right">DOWNLOAD FORMAT</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">

                <div id="existing_data" class="mt-3"></div>
            </div>
            <div class="col-md-6">
                <div id="excel_data" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    var occupiers = [];

    function importFile() {
        const villCode = $("#vill_code").val();
        if (!villCode) {
            alert("Please select a village before importing.");
            return;
        }
        if (occupiers.length === 0) {
            alert("No occupiers found. Please upload a valid Excel file first.");
            return;
        }
        if (!confirm("Are you sure you want to import these occupiers?")) {
            return;
        }

        $("#importBtn").hide();
        $("#spinnerBtn").show();

        // Collect file
        const fileInput = document.getElementById("import_file");
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append("dist_code", "<?= $dist_code ?>");
        formData.append("subdiv_code", "<?= $subdiv_code ?>");
        formData.append("cir_code", "<?= $circle_code ?>");
        formData.append("mouza_pargona_code", "<?= $mouza_code ?>");
        formData.append("lot_no", "<?= $lot_no ?>");
        formData.append("vill_code", villCode);
        formData.append("occupiers", JSON.stringify(occupiers));
        formData.append("import_file", file); // <-- Excel file

        $.ajax({
            url: "<?php echo base_url('index.php/LandBankLM/importOccupiers'); ?>",
            type: "POST",
            data: formData,
            processData: false, // prevent jQuery from processing data
            contentType: false, // prevent jQuery from setting contentType
            dataType: "json",
            success: function(response) {
                $("#spinnerBtn").hide();
                $("#importBtn").show();

                if (response.success) {
                    alert("Occupiers imported successfully.");
                    $("#vill_code").trigger("change");
                    $("#excel_data").html("");
                    occupiers = [];
                    $("#import_file").val(""); // reset file input
                } else {
                    alert(response.message || "Failed to import data.");
                }
            },
            error: function() {
                $("#spinnerBtn").hide();
                $("#importBtn").show();
                alert("Error occurred while saving data.");
            }
        });
    }




    document.getElementById('import_file').addEventListener('change', function(e) {
        occupiers = [];
        const file = e.target.files[0];
        if (!file) return;

        $("#displayBox").show();

        const reader = new FileReader();
        reader.onload = function(event) {
            const data = new Uint8Array(event.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });

            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];

            // Convert to JSON as array of arrays
            const jsonData = XLSX.utils.sheet_to_json(worksheet, {
                header: 1
            });

            occupiers = []; // reset

            if (jsonData.length > 1) {
                const headers = jsonData[0]; // first row = header
                const rows = jsonData.slice(1);

                // Build array of objects
                rows.forEach(row => {
                    let obj = {};
                    headers.forEach((header, i) => {
                        obj[header] = row[i] !== undefined ? row[i] : '';
                    });
                    occupiers.push(obj);
                });

                // Build preview table
                let table = `<h6 class="text-success text-center mb-2">New Occupiers to be imported</h6>
                         <table class="table table-bordered table-sm table-striped">
                            <thead class="thead-dark"><tr>`;

                headers.forEach(header => {
                    table += `<th>${header}</th>`;
                });

                table += `</tr></thead><tbody>`;

                occupiers.forEach(obj => {
                    table += `<tr>`;
                    headers.forEach(h => {
                        table += `<td>${obj[h]}</td>`;
                    });
                    table += `</tr>`;
                });

                table += `</tbody></table>`;
                document.getElementById('excel_data').innerHTML = table;
            } else {
                document.getElementById('excel_data').innerHTML = `<div class="alert alert-warning">No data found in file.</div>`;
            }

            $("#displayBox").hide();

        };
        reader.readAsArrayBuffer(file);
    });

    $("#vill_code").on("change", function() {
        const villCode = $(this).val();
        if (!villCode) {
            $("#existing_data").html("");
            return;
        }

        // Show loader
        $("#displayBox").show();

        $.ajax({
            url: "<?php echo base_url('index.php/LandBankLM/getLandBankVillageData'); ?>",
            type: "POST",
            data: {
                dist_code: "<?= $dist_code ?>",
                subdiv_code: "<?= $subdiv_code ?>",
                cir_code: "<?= $circle_code ?>",
                mouza_pargona_code: "<?= $mouza_code ?>",
                lot_no: "<?= $lot_no ?>",
                vill_code: villCode
            },
            dataType: "json",
            success: function(response) {
                if (response.length > 0) {
                    let table = `<h6 class="text-success text-center mb-2">Existing Occupier Details</h6><table class="table table-bordered table-sm table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Sl</th>
                                        <th>Dag No</th>
                                        <th>Occupiers</th>
                                    </tr>
                                </thead><tbody>`;

                    response.forEach((row, index) => {
                        table += `<tr>
                                <td>${index + 1}</td>
                                <td>${row.dag_no ?? ''}</td>
                                <td>${row.encroachers ?? ''}</td>
                              </tr>`;
                    });

                    table += `</tbody></table>`;
                    $("#existing_data").html(table);
                } else {
                    $("#existing_data").html(`<div class="alert alert-warning">No records found for this village.</div>`);
                }
                $("#displayBox").hide();
            },
            error: function() {
                $("#existing_data").html(`<div class="alert alert-danger">Failed to fetch data.</div>`);
                $("#displayBox").hide();
            }
        });
    });
</script>