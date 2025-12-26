<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel">
            <h2 class="uni_text center"><?php echo $this->lang->line('co_order'); ?></h2>
            <hr style="border-bottom: 2px solid #000;">
            <div class="col-lg-5 uni_text"><?php echo $this->lang->line('case_no'); ?> :
                <?php echo $case_no; ?> </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('order_no'); ?> : <?php echo $orderNo + 1; ?>
            </div>
            <div class="col-lg-3 uni_text"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></div>
            <div class="col-lg-12">
                <form id="FormCOAPStep4_4" enctype="multipart/form-data" class="form-horizontal" style="margin-top:30px; margin-bottom: 10px"
                    method="POST" action="<?php echo base_url(); ?>index.php/APCancellation/COAPStep4_4">

                    <input type="hidden" name="mouza_pargona_code" value="<?php echo $mouza_pargona_code; ?>">
                    <input type="hidden" name="lot_no" value="<?php echo $lot_no; ?>">
                    <input type="hidden" name="vill_code" value="<?php echo $vill_code; ?>">
                    <input type="hidden" name="dag_no" value="<?php echo $dag_no; ?>">
                    <input type="hidden" name="year_no" value="<?php echo $year_no; ?>">
                    <input type="hidden" name="petition_no" value="<?php echo $petition_no; ?>">
                    <input type="hidden" name="case_no" value="<?php echo $case_no; ?>">

                    <h2><?php echo $this->lang->line('basic_order_details'); ?></h2>
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('order_no'); ?>*</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='ord_no' readonly
                                value="<?php echo $case_no ?>">
                        </div>

                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('order_date'); ?>*</label>
                        <div class="col-lg-4">
                            <input type="text" id="popupDatepicker" class="form-control" readonly name="ord_date"
                                value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('order_type'); ?>*</label>
                        <div class="col-lg-4">

                            <select class="form-control" name="ord_type_code">
                                <option value="05">পট্টা ৰদ (একচনা পট্টা)<?php //echo $this->lang->line('patta_rod'); 
                                                                            ?>
                                </option>
                            </select>
                        </div>

                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('order_passed_by_sign_yn'); ?>
                            *</label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="ord_passby_sign_yn" value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="ord_passby_sign_yn" value="N">
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly name='case_no'
                                value="<?php echo $case_no ?>">
                        </div>
                        <label for="inputEmail"
                            class="col-lg-2 control-label hide"><?php echo $this->lang->line('ref_letter_no'); ?></label>
                        <div class="col-lg-4 hide">
                            <input type="text" class="form-control" name="ord_ref_let_no">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('order_passed_by'); ?></label>
                        <div class="col-lg-4">
                            <select class="form-control" name="ord_passby_desig">
                                <option value="CO"><?php echo $this->lang->line('co'); ?></option>
                            </select>
                        </div>
                        <label for="inputEmail"
                            class="col-lg-2 control-label hide"><?php echo $this->lang->line('type_of_govt_land'); ?></label>
                        <div class="col-lg-4 hide">
                            <select class="form-control" name="ord_on_gl_type">
                                <?php foreach ($landtype as $land) { ?>
                                    <option value="<?php echo $land->type_code; ?>"><?php echo $land->type; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('lm_name'); ?> *</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="lm_code">
                                <option value="<?php echo $LMList->lm_code; ?>"><?php echo $LMList->lm_name; ?></option>
                            </select>
                        </div>
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('lm_sign_y_n'); ?></label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="lm_sign" value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lm_sign" value="N">
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo $this->lang->line('lm_sign_date'); ?> </label>
                        <div class="col-lg-4">
                            <input type="text" id="popup3Datepicker" readonly
                                value="<?php echo date("Y-m-d", strtotime($lmcodate->lm_note_date)); ?>"
                                class="form-control" name="lm_sign_date">
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('sk_name'); ?></label>
                        <div class="col-lg-4">
                            <select class="form-control" name="sk_code" id="sk_code">
                                <option value="">Select LRS</option>
                                <?php foreach ($SKList as $sk) { ?>
                                    <option value="<?php echo $sk->user_code; ?>"><?php echo $sk->username; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('sk_sign_y_n'); ?></label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="sk_sign" value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sk_sign" value="N">
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('sk_sign_date'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly id="popup2Datepicker"
                                value="<?php echo date("Y-m-d", strtotime($lmcodate->sk_note_date)); ?>"
                                name="sk_sign_date">
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('co_name'); ?></label>
                        <div class="col-lg-4">

                            <input type="text" class="form-control" readonly value="<?= $COName->username; ?>">

                            <input type="hidden" name="co_code" value="<?= $COName->user_code ?>">
                        </div>
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('cos_sign_y_n'); ?></label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="co_sign" value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="co_sign" value="N">
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail"
                            class="col-lg-2 control-label"><?php echo $this->lang->line('co_sign_date'); ?> </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly id="DatepickerCO"
                                value="<?php echo date("Y-m-d", strtotime($lmcodate->co_recommendation_date)); ?>"
                                name="co_sign_date">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Purpose </label>
                        <div class="col-lg-4">
                            <input type="text" value="" class="form-control" name="purpose"
                                fdprocessedid="jyi3w9">
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h2>Pattadar list</h2>
                        <?php $slno = 1; ?>
                        <?php foreach ($pattadars as $pattadar) { ?>
                            <hr>

                            <div class="row">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Sl No *</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="name_for_id"
                                            value="<?php echo ($slno++); ?>" fdprocessedid="udlqhb">
                                    </div>

                                    <label for="inputEmail" class="col-lg-2 control-label">Order No *</label>
                                    <div class="col-lg-4">
                                        <input type="text" readonly="" class="form-control" name="ord_no"
                                            value="<?php echo ($case_no); ?>" fdprocessedid="cbgd0o">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Name</label>
                                    <div class="col-lg-4">

                                        <input type="hidden" class="form-control" name="pdar_id[]" value="<?php echo ($pattadar->pdar_id); ?>">

                                        <input type="text" class="form-control" name="name_for[]"
                                            value="<?php echo ($pattadar->pdar_name); ?>" fdprocessedid="kdmpdt">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label hide">Ref Letter No</label>
                                    <div class="col-lg-4 hide">
                                        <input type="text" class="form-control" name="ord_ref_let_no" value="">
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputEmail" class="col-lg-2 control-label">Guardian Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="name_for_guardian[]"
                                            value="<?php echo ($pattadar->pdar_guardian); ?> " fdprocessedid="a1da7r">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label">Relation</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="name_for_guar_relation[]" fdprocessedid="v3znif">
                                            <?php foreach ($relation as $rel) { ?>
                                                <option value="<?php echo $rel->guard_rel; ?>"
                                                    <?php echo ($rel->guard_rel == $pattadar->pdar_rel_guar) ? "selected" : ""; ?>>
                                                    <?php echo $rel->guard_rel_desc; ?> [<?php echo $rel->guard_rel_desc_as; ?>]
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Case Type</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="case_type_code" fdprocessedid="7czos">
                                            <option value="04">পট্টা ৰদ (একচনা পট্টা)</option>
                                        </select>
                                    </div>



                                </div>
                                <div class="form-group hide">
                                    <label for="inputEmail" class="col-lg-2 control-label">Against Which Order</label>
                                    <div class="col-lg-4">
                                        <input type="text" value="" class="form-control" name="against_which_order">
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label for="inputEmail" class="col-lg-2 control-label">Conversion Type</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="conversation_type">
                                            <option value="0">Full </option>
                                            <option value="1">Partial</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label">Land Area (Bigha)</label>
                                    <div class="col-lg-4">
                                        <input type="text" value="0" class="form-control" name="name_for_land_b">
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label for="inputEmail" class="col-lg-2 control-label">Land Area (Katha)</label>
                                    <div class="col-lg-4">
                                        <input type="text" value="0" class="form-control" name="name_for_land_k">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label">Land Area (Lessa)</label>
                                    <div class="col-lg-4">
                                        <input type="text" value="0" class="form-control" name="name_for_land_lc">
                                    </div>
                                </div>


                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                    <div>
                        <h2 class='text-danger'><?php echo $this->lang->line('reference_of_court_order_no'); ?></h2>
                    </div>
                    <br />
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order1'); ?></p>
                        <input type="text" class="form-control" name="wrt1">
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order2'); ?></p>
                        <input type="text" class="form-control" name="wrt2">
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order3'); ?></p>
                        <input type="text" class="form-control" name="wrt3">
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order4'); ?></p>
                        <input type="text" class="form-control" name="wrt4">
                        <p class="center hide"><?php echo $this->lang->line('wrt_order5'); ?></p>
                        <input type="hidden" class="form-control" name="wrt5">
                    </div>
                    <br />
                    <br />
                    <center>
                        <button name="btnUploadDocument" class="btn btn-info" style="margin-top: 20px" onclick="openAddDocumentModal()">
                            <i class='fa fa-file'></i> Upload Documents
                        </button>
                        <button class="btn btn-primary" style="margin-top: 20px" type="submit"><i
                                class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                        <a href="javascript:history.back()" class="btn btn-md btn-danger" style="margin-top: 20px">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back'); ?>
                        </a>
                    </center>

                    <div class="col-lg-10 col-lg-offset-1">
                        <input type="hidden" name="UploadDocumentData" id="UploadDocumentData" value="">
                        <div class="panel-body" id="documentList">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- Upload document Modal -->
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

<script>
    document.getElementById("FormCOAPStep4_4").addEventListener("submit", function(e) {

        const sk_code = document.getElementById("sk_code");
        const value = sk_code.value.trim();
        if (value === "") {
            alert("Please select LRS .");
            sk_code.focus();
            e.preventDefault();
            return false;
        }
        return true;
    });
</script>

<script>
    function openAddDocumentModal() {
        event.preventDefault();
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
        displayDiv.className = "alert alert-success py-2 px-3 mb-2 d-flex justify-content-between align-items-center ";

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