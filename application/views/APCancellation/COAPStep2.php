<div class="container-fluid login form-top">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php echo $this->lang->line('co_1st_proceeding_on_ap_cancellation'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no'); ?> : <?php echo $_GET['case_no']; ?> <span
                                class="pull-right"><?php echo $this->lang->line('date'); ?> :
                                <?php echo date("d-m-Y", strtotime($_GET['submission_date'])); ?></span>
                        </h3>
                    </div>
                    <div class="panel-body" style='min-height:400px'>
                        <form class="form-horizontal" enctype="multipart/form-data" method='post'
                            action="<?php echo base_url() . "index.php/APCancellation/COAPStep2_11"; ?>">
                            <?php
                            $dist_code = $_GET['dist_code'];
                            $subdiv_code = $_GET['subdiv_code'];
                            $cir_code = $_GET['cir_code'];
                            $lot_no = $_GET['lot_no'];
                            $vill_townprt_code = $_GET['vill_townprt_code'];
                            $year_no = $_GET['year_no'];
                            $petition_no = $_GET['petition_no'];
                            $case_no = $_GET['case_no'];
                            $mouza_pargona_code = $_GET['mouza_pargona_code'];
                            $submission_date = $_GET['submission_date'];
                            ?>
                            <input type="hidden" name="dist_code" value="<?php echo $dist_code; ?>" />
                            <input type="hidden" name="subdiv_code" value="<?php echo $subdiv_code; ?>" />
                            <input type="hidden" name="cir_code" value="<?php echo $cir_code; ?>" />
                            <input type="hidden" name="lot_no" value="<?php echo $lot_no; ?>" />
                            <input type="hidden" name="vill_townprt_code" value="<?php echo $vill_townprt_code; ?>" />
                            <input type="hidden" name="year_no" value="<?php echo $year_no; ?>" />
                            <input type="hidden" name="petition_no" value="<?php echo $petition_no; ?>" />
                            <input type="hidden" name="case_no" value="<?php echo $case_no; ?>" />
                            <input type="hidden" name="mouza_pargona_code" value="<?php echo $mouza_pargona_code; ?>" />
                            <input type="hidden" name="submission_date" value="<?php echo $submission_date; ?>" />
                            <!--                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">CO's Note on Hearing(চক্ৰ বিষয়াৰ শুনানিৰ প্রতিবেদন)</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="co_order" rows="6" required></textarea>
                                </div> 
                            </div>-->

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1 uni_text">
                                    <p>
                                        আবেদনকাৰীৰ আবেদন চোৱা হ'ল । আবেদনকাৰীয়ে <?php echo $namedata[0]->district; ?>
                                        জিলাৰ <?php echo $namedata[3]->mouza; ?> মৌজাৰ
                                        <?php echo $namedata[5]->village; ?> গাঁওৰ
                                        <?php echo $this->utilityclass->cassnum($countAPCase->patta_no); ?> নং
                                        <?php echo $countAPCase->patta_type; ?> পট্টাৰ
                                        <?php echo $this->utilityclass->cassnum($countAPCase->dag_no); ?> নং দাগৰ <span
                                            class='text-danger'>পট্টা ৰদ</span> বিচাৰিছে ।
                                    </p>
                                    <p>
                                        সহায়কে জাননী জাৰি কৰাৰ ব্যৱস্হা ল'ব । </p>
                                    <input type="hidden" name="t1"
                                        value=" আবেদনকাৰীৰ আবেদন চোৱা হল । আবেদনকাৰীয়ে <?php echo $namedata[0]->district; ?> জিলাৰ    <?php echo $namedata[3]->mouza; ?> মৌজাৰ <?php echo $namedata[5]->village; ?> গাঁওৰ <?php echo $countAPCase->patta_no; ?> নং <?php echo $countAPCase->patta_type; ?> পট্টাৰ <?php echo $countAPCase->dag_no; ?> নং দাগৰ “পট্টা ৰদ” বিচাৰিছে । সহায়কে অসম ৰাজহ আইনৰ ৫২ নং  ধাৰা মতে উভয় পক্ষৰ ওপৰত জাননী জাৰি কৰাৰ ব্যৱস্হা ল'ব । " />


                                    <input type="hidden" name="t2"
                                        value="তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য কৰা হ'ল ।" />

                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-lg-2 col-lg-offset-1">
                                    <input type="text" class="form-control"
                                        value="<?php echo date("d-m-Y", strtotime(date("Y-m-d"))); ?>"
                                        name="date_hearing" readonly="readonly" required id="popupDatepicker" />
                                </div>
                                <div class="col-lg-8 uni_text">তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য কৰা হ'ল ।
                                </div>
                            </div>
                            <!-- 
                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">Hearing Date (শুনানিৰ তাৰিখ)</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" name="date_hearing" readonly="readonly" required id="popupDatepicker"/> 
                                </div> 
                                <div class="col-lg-6">This date will be given as note on hearing date(এইটো তাৰিখ শুনানিৰ বাবে দিয়া হব)</div>                            
                            </div>
                           -->
                            <hr>
                            <div class="form-group" style='margin-top:100px'>
                                <div class="col-lg-10 col-lg-offset-1">
                                    <button name="btnUploadDocument" class="btn btn-info"
                                        onclick="openAddDocumentModal()">
                                        <i class='fa fa-file'></i> Upload Documents
                                    </button>
                                    <button type="submit" name="FormSubmit" class="btn btn-primary"><i
                                            class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/SKViewPetition"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>"
                                        class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('view_petition'); ?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/LMNoteView_by_SK"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>"
                                        class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('lm_report'); ?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/SKNoteView_by_CO"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>"
                                        class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('sk_report'); ?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url(); ?>index.php/home/index"
                                        class="btn btn-md btn-danger">
                                        <i
                                            class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-10 col-lg-offset-1">
                                <input type="hidden" name="UploadDocumentData" id="UploadDocumentData" value="">
                                <div class="panel-body" id="documentList">

                                </div>
                            </div>


                        </form>
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