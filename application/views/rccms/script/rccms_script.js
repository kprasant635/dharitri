
$(document).ready(function () {
    // Initialize Select2 for all presentPattaType selects
    $('select.presentPattaType-select').select2({
        width: '100%',
        height: '40px',
        placeholder: 'Select Type',
        allowClear: true
    });
});
$(document).ready(function () {
    // Initialize Select2 for all presentPattaType selects
    $('select.requestedPattaType-select').select2({
        width: '100%',
        height: '40px',
        placeholder: 'Select Type',
        allowClear: true
    });
});
$(document).ready(function () {
    // Initialize Select2 for all presentPattaType selects
    $('select.landClassChange-select').select2({
        width: '100%',
        height: '40px',
        placeholder: 'Select Type',
        allowClear: true
    });
});


$(function () {
    // Insert status-circle CSS once
    if (!$('head').find('#status-circle-style').length) {
        $('<style id="status-circle-style">')
            .prop('type', 'text/css')
            .html(`
                .status-circle { display:inline-block; width:10px; height:10px; border-radius:50%; background:#6c757d; }
                .pattadar-form { margin-bottom: 1rem; }
            `).appendTo('head');
    }

    // Helper: find tab index from an input inside a tab-pane
    function paneIndexFromElement(el) {
        const pane = $(el).closest('[id^="tab-pane-"]');
        if (!pane.length) return null;
        return pane.attr('id').split('-').pop();
    }



    $(document).ready(function () {

        // ADD ROW (for each tab)
        $(document).on("click", "[id^='addMorePattadar-']", function () {

            let index = this.id.split("-").pop();

            let form = $("#pattadarForm-" + index)[0];

            // Validation
            if (!form.checkValidity()) {
                form.classList.add("was-validated");
                return;
            }

            // Values (IMPORTANT: read from form inside index)
            let container = $("#pattadarForm-" + index);

            let name = container.find("[name='name']").val();
            let guardian = container.find("[name='guardianName']").val();
            let address = container.find("[name='address']").val();

            // Gender
            let genderVal = container.find("[name='gender']").val();
            let genderText = "";

            if (genderVal) {
                genderText = container
                    .find("[name='gender'] option[value='" + genderVal + "']")
                    .text()
                    .trim()
                    .replace(/\s+/g, " ")
                    .split(" ")[0];
            }

            // Relation
            let relationVal = container.find("[name='relation']").val();
            let relationText = "";

            if (relationVal) {
                relationText = container
                    .find("[name='relation'] option[value='" + relationVal + "']")
                    .text()
                    .trim()
                    .replace(/\s+/g, " ")
                    .split(" ")[0];
            }

            // Append row to table for this index only
            let table = $("#pattadarTable-" + index);
            let tableCard = $("#pattadarTableCard-" + index);

            table.find("tbody").append(`
            <tr>
                <td class="rowIndex"></td>
                <td>${name}</td>
                <td>${guardian}</td>
                <td>${genderText}</td>
                <td>${relationText}</td>
                <td>${address}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeRow" data-index="${index}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);

            // Show table
            tableCard.show();

            // Renumber rows for this index only
            renumberRows(index);
            updateTabStatus(index);

            // Reset form
            form.reset();
            form.classList.remove("was-validated");
        });

        // REMOVE ROW
        // delegated remove handler — robust to missing data-index
        $(document).on("click", ".removeRow", function () {
            const $btn = $(this);
            const $tr = $btn.closest('tr');

            // Find the table that contains this row
            const $table = $tr.closest('table');
            if (!$table.length) return;

            // Extract index from table id like "pattadarTable-2"
            const tableId = $table.attr('id') || '';
            const match = tableId.match(/pattadarTable-(\d+)$/);
            // fallback: try data-index on button
            let index = match ? match[1] : $btn.data('index');

            // remove the row
            $tr.remove();

            // renumber rows for this index (only if we have a valid index)
            if (index !== undefined && index !== null) {
                renumberRows(index);

                const $tableCard = $(`#pattadarTableCard-${index}`);

                // hide the table card if no rows left
                if ($table.find('tbody tr').length === 0) {
                    $tableCard.hide();
                }

                // update tab status so status-circle turns gray when empty
                if (typeof updateTabStatus === 'function') {
                    updateTabStatus(index);
                }
            } else {
                // If index not found, still try to renumber & hide globally for safety
                $table.find('tbody tr').each(function (i) {
                    $(this).find('.rowIndex').text(i + 1);
                });
                if ($table.find('tbody tr').length === 0) {
                    // hide nearest card wrapper (best effort)
                    $table.closest('.card').hide();
                }
            }
        });


        // RENUMBER FUNCTION (per index)
        function renumberRows(index) {
            $("#pattadarTable-" + index + " tbody tr").each(function (i) {
                $(this).find(".rowIndex").text(i + 1);
            });
        }

    });




    // ---------- Update tab status ----------
    function updateTabStatus(index) {

        // Main parent pane
        const pane = $(`#tab-pane-${index}`);


        if (!pane.length) return;

        /* ---------------------------------------------------------
           1️⃣  PATTADAR STATUS  (Based on Table Rows)
        --------------------------------------------------------- */
        const pattadarRows = $(`#pattadarTable-${index} tbody tr`);
        const hasPattadars = pattadarRows.length > 0;

        $(`#addPattadar-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(hasPattadars ? 'bg-success' : 'bg-secondary');


        /* ---------------------------------------------------------
           2️⃣  STRIKE PATTADAR
        --------------------------------------------------------- */
        const strikeForm = $(`#strikePattadarForm-${index}`);
        const hasStrike = strikeForm.find('.pattadar-checkbox:checked').length > 0;

        $(`#strikePattadar-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(hasStrike ? 'bg-success' : 'bg-secondary');

        /* ---------------------------------------------------------
           2️⃣  STRIKE PATTADAR
        --------------------------------------------------------- */
        const unstrikeForm = $(`#unstrikePattadarForm-${index}`);
        const hasunStrike = unstrikeForm.find('.unpattadar-checkbox:checked').length > 0;

        $(`#unstrikePattadar-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(hasunStrike ? 'bg-success' : 'bg-secondary');


        /* ---------------------------------------------------------
           3️⃣  AREA CHANGE
        --------------------------------------------------------- */
        const areaForm = $(`#areaChangeForm-${index}`);
        const bigha = parseFloat(areaForm.find('[name="bigha"]').val() || 0);
        const katha = parseFloat(areaForm.find('[name="katha"]').val() || 0);
        const lessa = parseFloat(areaForm.find('[name="lessa"]').val() || 0);

        // Optional districtCode logic
        let gonda = 0, chatak = 0;
        if (typeof districtCode !== 'undefined' && districtCode == Barak_Vally_Distcode) {
            gonda = parseFloat(areaForm.find('[name="gonda"]').val() || 0);
            chatak = parseFloat(areaForm.find('[name="chatak"]').val() || 0);
        }

        const hasAreaChange = (bigha || katha || lessa || gonda || chatak);

        $(`#areaChange-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(hasAreaChange ? 'bg-success' : 'bg-secondary');





        /* ---------------------------------------------------------
       4️⃣  LAND Class TYPE CHANGE
    --------------------------------------------------------- */
        const landclassForm = $(`#LandClassChangeForm-${index}`);
        const landClassChange = landclassForm.find('[name="landClassChange"]').val();
        const reasonChangelandclass = landclassForm.find('[name="reasonChangelandclass"]').val()?.trim();

        const hasLandClassChange =
            landClassChange ||
            reasonChangelandclass;

        $(`#LandClassChange-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(hasLandClassChange ? 'bg-success' : 'bg-secondary');


        /* ---------------------------------------------------------
           4️⃣  PATTA TYPE CHANGE
        --------------------------------------------------------- */
        const pattaForm = $(`#pattaTypeChangeForm-${index}`);
        const presentType = pattaForm.find('[name="presentPattaType"]').val();
        const requestedType = pattaForm.find('[name="requestedPattaType"]').val();
        const reasonChange = pattaForm.find('[name="reasonChange"]').val()?.trim();

        const changePattaNo = pattaForm.find('[name="changePattaNo"]').val()?.trim();

        const hasPattaChange =
          
            requestedType ||
            reasonChange ||
            changePattaNo;

        $(`#pattaTypeChange-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(hasPattaChange ? 'bg-success' : 'bg-secondary');


        /* ---------------------------------------------------------
           5️⃣  OTHER REMARKS
        --------------------------------------------------------- */
        const remarkForm = $(`#otherRemarksForm-${index}`);
        const remarks = remarkForm.find('[name="remarks"]').val()?.trim();

        $(`#otherRemarks-tab-${index} .status-circle`)
            .removeClass('bg-success bg-secondary')
            .addClass(remarks ? 'bg-success' : 'bg-secondary');


        /* ---------------------------------------------------------
           Debug Output
        --------------------------------------------------------- */
        // console.log(
        //     `Status Updated → Index: ${index}`,
        //     {
        //         pattadars: hasPattadars,
        //         strike: hasStrike,
        //         area: hasAreaChange,
        //         pattaChange: hasPattaChange,
        //         remarks: !!remarks
        //     }
        // );
    }



    // Recompute status when anything changes inside forms or dynamic elements
    $(document).on('input change', '[id^="tab-pane-"] input, [id^="tab-pane-"] select, [id^="tab-pane-"] textarea, .pattadar-checkbox', function () {
        const index = paneIndexFromElement(this);
        if (index !== null) updateTabStatus(index);
    });

    // Initial run for existing panes
    $('[id^="tab-pane-"]').each(function () {
        const index = $(this).attr('id').split('-').pop();
        updateTabStatus(index);
    });

    // ---------- Preview logic ----------
    $('#previewAllData').on('click', function () {

        let previewHtml = `
        <h5 class="text-center text-primary mb-4">
            <i class="fa fa-eye me-2"></i>Preview of All Entered Data
        </h5>`;

        $('[id^="tab-pane-"]').each(function () {

            const pane = $(this);
            const index = pane.attr('id').split('-').pop();

            // DAG & PATTA
            const dagText = pane.find('p strong:contains("DAG No")')
                .first().parent().contents().filter(function () {
                    return this.nodeType === 3;
                }).text().trim();

            const pattaText = pane.find('p strong:contains("Patta No")')
                .first().parent().contents().filter(function () {
                    return this.nodeType === 3;
                }).text().trim();

            // Forms
            const strikeForm = $(`#strikePattadarForm-${index}`);
            const unstrikeForm = $(`#unstrikePattadarForm-${index}`);
            const areaForm = $(`#areaChangeForm-${index}`);
            const landclassForm = $(`#LandClassChangeForm-${index}`);
            const pattaForm = $(`#pattaTypeChangeForm-${index}`);

            // ===============================
            // COLLECT ALL REASONS (ONCE)
            // ===============================
            const strikeReason = strikeForm.find('[name="strikeReason"]').val()?.trim();
            const unstrikeReason = unstrikeForm.find('[name="unstrikeReason"]').val()?.trim();
            const areaReason = areaForm.find('[name="areaReason"]').val()?.trim();
            const landClassReason = landclassForm.find('[name="reasonChangelandclass"]').val()?.trim();
            const pattaReason = pattaForm.find('[name="reasonChange"]').val()?.trim();

            const hasAnyReason =
                strikeReason || unstrikeReason || areaReason || landClassReason || pattaReason;

            previewHtml += `
        <div class="card mb-4 border-dark shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border border-dark text-primary">
                <i class="fa fa-map me-2"></i>
                DAG No: ${escapeHtml(dagText || '-')} | Patta No: ${escapeHtml(pattaText || '-')}
            </div>
            <div class="card-body row g-4">
        `;

            /* =================================================
               📝 REASONS SECTION (FIRST – AS YOU WANT)
            ================================================= */

            const strikeNames = strikeForm.find('.pattadar-checkbox:checked')
                .map(function () {
                    return $(this).closest('tr').find('td:nth-child(2)').text().trim();
                }).get();
            const unstrikeNames = unstrikeForm.find('.unpattadar-checkbox:checked')
                .map(function () {
                    return $(this).closest('tr').find('td:nth-child(2)').text().trim();
                }).get();

            let hasAreaChange = false;
            let areaText = '';   // ✅ define first

            const bigha = areaForm.find('[name="bigha"]').val() || 0;
            const katha = areaForm.find('[name="katha"]').val() || 0;
            const lessa = areaForm.find('[name="lessa"]').val() || 0;

            let gonda = 0, chatak = 0;
            if (districtCode == Barak_Vally_Distcode) {
                gonda = areaForm.find('[name="gonda"]').val() || 0;
                chatak = areaForm.find('[name="chatak"]').val() || 0;
            }

            if (
                parseFloat(bigha) || parseFloat(katha) || parseFloat(lessa) ||
                (districtCode == Barak_Vally_Distcode && (parseFloat(gonda) || parseFloat(chatak)))
            ) {
                hasAreaChange = true;

                areaText = `
                ${escapeHtml(bigha)} Bigha
                ${escapeHtml(katha)} Katha
                ${escapeHtml(lessa)} Lessa
            `;

                if (districtCode == Barak_Vally_Distcode) {
                    areaText += `
            ${escapeHtml(gonda)} Gonda
            ${escapeHtml(chatak)} Chatak
        `;
                }
            }

            const areaName = areaText;

            const landclassValue = landclassForm.find('[name="landClassChange"]').val();
            const landclassName = landclassForm.find('[name="landClassChange"] option:selected').text();

            const presentPattaValue = pattaForm.find('[name="presentPattaType"]').val();
            const requestedPattaValue = pattaForm.find('[name="requestedPattaType"]').val();

            const presentPatta_typeName = pattaForm
                .find('[name="presentPattaType"] option:selected').text();

            const requestedPatta_typeName = pattaForm
                .find('[name="requestedPattaType"] option:selected').text();

            const changePattaNo = pattaForm.find('[name="changePattaNo"]').val()?.trim();

            const pattadarRows = $(`#pattadarTable-${index} tbody tr`);

            const pattadarNames = pattadarRows.length
                ? pattadarRows.map(function () {
                    return $(this).find("td:nth-child(2)").text().trim();
                }).get()
                : [];



            previewHtml += `
<div class="col-md-12">
    <div class="judgment-box">

        <h6 class="judgment-title border-bottom pb-2 mb-3 text-center">
            <i class="fa fa-gavel me-2"></i>
            RCCMS Case No:
            <b>${escapeHtml($("#rccms_application_id").val())}</b>
            <span class="badge badge-soft ms-2">As per Judgment</span>
        </h6>

        <!-- Pattadar List -->
       

         ${pattadarNames.length ? `
        <div class="judgment-item">
            <i class="fa fa-exclamation-circle text-danger judgment-icon me-2"></i>
            Add new Pattadar(s):
            <b>${escapeHtml(pattadarNames.join(', '))}</b> in
            <b>Dag No. ${escapeHtml(dagText || '-')}</b>.
        </div>` : ''}

        <!-- Strike -->
        ${strikeNames.length ? `
        <div class="judgment-item">
            <i class="fa fa-exclamation-circle text-danger judgment-icon me-2"></i>
            Strike of Pattadar(s):
            <b>${escapeHtml(strikeNames.join(', '))}</b>
            from the land record in
            <b>Dag No. ${escapeHtml(dagText || '-')}</b>.
        </div>` : ''}

        <!-- Un-Strike -->
        ${unstrikeNames.length ? `
        <div class="judgment-item">
            <i class="fa fa-exclamation-circle text-danger judgment-icon me-2"></i>
            Un-striking of Pattadar(s):
            <b>${escapeHtml(unstrikeNames.join(', '))}</b>
            from the land record in
            <b>Dag No. ${escapeHtml(dagText || '-')}</b>.
        </div>` : ''}

        <!-- Area -->
        ${hasAreaChange ? `
        <div class="judgment-item">
            <i class="fa fa-exclamation-circle text-danger judgment-icon me-2"></i>
            Area updated to
            <b>${escapeHtml(areaName)}</b>
            in
            <b>Dag No. ${escapeHtml(dagText || '-')}</b>.
        </div>` : ''}

        <!-- Land Class -->
        ${(landclassValue && landclassValue !== "0") ? `
        <div class="judgment-item">
            <i class="fa fa-exclamation-circle text-danger judgment-icon me-2"></i>
            Land class changed to
            <b>${escapeHtml(landclassName)}</b>
            in
            <b>Dag No. ${escapeHtml(dagText || '-')}</b>.
        </div>` : ''}

        <!-- Patta Type -->
        ${(presentPattaValue && presentPattaValue !== "0") ? `
        <div class="judgment-item">
            <i class="fa fa-exclamation-circle text-danger judgment-icon me-2"></i>
            Patta type changed from
            <b>${escapeHtml(presentPatta_typeName)} → ${escapeHtml(requestedPatta_typeName)}</b>
            ${changePattaNo ? `, New Patta No: <b>${escapeHtml(changePattaNo)}</b>` : ''} in
            <b>Dag No. ${escapeHtml(dagText || '-')}</b>.
        </div>` : ''}

    </div>
</div>`;




            /* =================================================
               👥 PATTADAR LIST (NOW COMES AFTER REASONS)
            ================================================= */
            const tableRows = $(`#pattadarTable-${index} tbody tr`);

            if (tableRows.length > 0) {
                previewHtml += `
            <div class="col-md-12 mt-3">
                <h6 class="text-success border-bottom pb-1">
                    <i class="fa fa-users me-2"></i>
                    Pattadar List
                    <span class="status-circle bg-success ms-2"></span>
                </h6>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Guardian</th>
                                <th>Gender</th>
                                <th>Relation</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

                tableRows.each(function (i) {
                    previewHtml += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${escapeHtml($(this).find("td:nth-child(2)").text())}</td>
                    <td>${escapeHtml($(this).find("td:nth-child(3)").text())}</td>
                    <td>${escapeHtml($(this).find("td:nth-child(4)").text())}</td>
                    <td>${escapeHtml($(this).find("td:nth-child(5)").text())}</td>
                    <td>${escapeHtml($(this).find("td:nth-child(6)").text())}</td>
                </tr>`;
                });

                previewHtml += `
                        </tbody>
                    </table>
                </div>
            </div>`;
            }


            // Other sections: strike, area, patta type, remarks — reuse your existing code logic
            // Strike
            //  <p><b>Reason:</b> ${escapeHtml(strikeForm.find('[name="strikeReason"]').val() || '-')}</p>

            // const strikeForm = $(`#strikePattadarForm-${index}`);
            if (strikeForm.length) {
                const checked = strikeForm.find('.pattadar-checkbox:checked')
                    .map(function () {
                        return $(this).closest('tr').find('td:nth-child(2)').text().trim();
                    }).get();

                if (checked.length) {
                    previewHtml += `
        <div class="col-md-6">
            <h6 class="text-danger border-bottom pb-1">
                <i class="fa fa-user-times me-2"></i>
                Strike Pattadar
                <span class="status-circle bg-success ms-2"></span>
            </h6>

            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Strike Pattadar Name</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                
                                <td>Selected Pattadars: <b>${escapeHtml(checked.join(', '))}</b></td>
                            </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>`;
                }
            }


            //Unstrike
            // <p><b>Reason:</b> ${escapeHtml(unstrikeForm.find('[name="unstrikeReason"]').val() || '-')}</p>
            // const unstrikeForm = $(`#unstrikePattadarForm-${index}`);
            if (unstrikeForm.length) {

                const checked = unstrikeForm.find('.unpattadar-checkbox:checked')
                    .map(function () {
                        return $(this).closest('tr').find('td:nth-child(2)').text().trim();
                    }).get();

                if (checked.length) {
                    previewHtml += `
        <div class="col-md-6">
            <h6 class="text-danger border-bottom pb-1">
               <i class="fa fa-user-check me-2"></i>
                Un-Strike Pattadar
                <span class="status-circle bg-success ms-2"></span>
            </h6>

            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Un-Strike Pattadar Name</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                
                                <td>Selected Pattadars: <b>${escapeHtml(checked.join(', '))}</b></td>
                            </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>`;

                }
            }

            // Area change
            // const areaForm = $(`#areaChangeForm-${index}`);
            if (areaForm.length) {

                const bigha = areaForm.find('[name="bigha"]').val() || 0;
                const katha = areaForm.find('[name="katha"]').val() || 0;
                const lessa = areaForm.find('[name="lessa"]').val() || 0;

                // Only for districtCode 20
                let gonda = '';
                let chatak = '';

                if (districtCode == Barak_Vally_Distcode) {
                    gonda = areaForm.find('[name="gonda"]').val() || 0;
                    chatak = areaForm.find('[name="chatak"]').val() || 0;
                }

                // Check if ANY area value is filled
                if (parseFloat(bigha) || parseFloat(katha) || parseFloat(lessa) || (districtCode == Barak_Vally_Distcode && (parseFloat(gonda) || parseFloat(chatak)))) {

                    // Build area text
                    let areaText = `
                                        ${escapeHtml(bigha)} Bigha 
                                        ${escapeHtml(katha)} Katha 
                                        ${escapeHtml(lessa)} Lessa
                                    `;

                    // Add Gonda & Chatak ONLY for districtCode == 20
                    if (districtCode == Barak_Vally_Distcode) {
                        areaText += `
                ${escapeHtml(gonda)} Gonda 
                ${escapeHtml(chatak)} Chatak
            `;
                    }

                    previewHtml += `
            <div class="col-md-6">
                <h6 class="text-warning border-bottom pb-1">
                    <i class="fa fa-ruler-combined me-2"></i>Area Change
                    <span class="status-circle bg-success ms-2"></span>
                </h6>
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th>Correction Area</th>
                        <td>${areaText}</td>
                    </tr>
                    
                       
                </table>
            </div>
        `;
                }
            }



            // Patta Type Change
            // const landclassForm = $(`#LandClassChangeForm-${index}`);

            if (landclassForm.length) {

                const presentVal = landclassForm.find('[name="landClassChange"]').val();
                const reasonVal = landclassForm.find('[name="reasonChangelandclass"]').val().trim();

                // Show section ONLY if any field contains real data
                const showSection =
                    (presentVal && presentVal !== "") ||
                    (reasonVal && reasonVal !== "");

                if (showSection) {

                    const presentText = landclassForm.find('[name="landClassChange"] option:selected').text();

                    previewHtml += `
            <div class="col-md-6">
                <h6 class="text-info border-bottom pb-1">
                    <i class="fa fa-sticky-note me-2"></i>
                    Land Class Change <span class="status-circle bg-success ms-2"></span>
                </h6>
                <table class="table table-sm table-bordered mb-0">
                    <tr><th>Land Class Type</th><td>${escapeHtml(presentText)}</td></tr>
        `;



                    previewHtml += `
                   
                </table>
            </div>
        `;
                }
            }


            // Patta Type Change
            // const pattaForm = $(`#pattaTypeChangeForm-${index}`);

            if (pattaForm.length) {

                const presentVal = pattaForm.find('[name="presentPattaType"]').val();
                const requestedVal = pattaForm.find('[name="requestedPattaType"]').val();
                const changePattaNo = pattaForm.find('[name="changePattaNo"]').val().trim();
                const reasonVal = pattaForm.find('[name="reasonChange"]').val().trim();

                // Show section ONLY if any field contains real data
                const showSection =
                    (presentVal && presentVal !== "") ||
                    (requestedVal && requestedVal !== "") ||
                    (changePattaNo && changePattaNo !== "") ||
                    (reasonVal && reasonVal !== "");

                if (showSection) {

                    const presentText = pattaForm.find('[name="presentPattaType"] option:selected').text();
                    const requestedText = pattaForm.find('[name="requestedPattaType"] option:selected').text();

                    previewHtml += `
            <div class="col-md-6">
                <h6 class="text-info border-bottom pb-1">
                    <i class="fa fa-file-signature me-2"></i>
                    Patta Type Change <span class="status-circle bg-success ms-2"></span>
                </h6>
                <table class="table table-sm table-bordered mb-0">
                    <tr><th>Present Type</th><td>${escapeHtml(presentText)}</td></tr>
                    <tr><th>Requested Type</th><td>${escapeHtml(requestedText)}</td></tr>
        `;

                    if (changePattaNo !== "") {
                        previewHtml += `
                <tr><th>Change Patta No</th><td>${escapeHtml(changePattaNo)}</td></tr>
            `;
                    }

                    previewHtml += `
                    
                </table>
            </div>
        `;
                }
            }


            // Other remarks
            // const remarkForm = $(`#otherRemarksForm-${index}`);
            // if (remarkForm.length) {
            //     const remarks = remarkForm.find('[name="remarks"]').val() || '';
            //     previewHtml += `<div class="col-md-12">
            //         <h6 class="text-secondary border-bottom pb-1"><i class="fa fa-sticky-note me-2"></i>Other Remarks <span class="status-circle ${remarks ? 'bg-success' : 'bg-secondary'} ms-2"></span></h6>
            //         <p class="mb-0">${escapeHtml(remarks || '-')}</p>
            //     </div>`;
            // }

            previewHtml += `</div></div>`;
        });

        $('#previewModalBody').html(previewHtml);
        $('#previewModal').modal('show');
    });

    /* ===============================
       SAFE HTML ESCAPE
    ================================ */
    function escapeHtml(text) {
        return String(text || '')
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

});

$(document).ready(function () {
    $('#mouza').change(function () {
        var mouza_code = $(this).val();
        $('#lot').html('<option value="">-- Loading Lots --</option>').prop('disabled', true);

        if (mouza_code !== '') {
            $.ajax({


                url: base_url + 'index.php/Rccms/get_lots_by_mouza',
                type: 'POST',
                data: {
                    mouza_pargona_code: mouza_code
                },
                dataType: 'json',
                success: function (response) {
                    var options = '<option value="">-- Select Lot --</option>';
                    $.each(response, function (index, lot) {
                        options += '<option value="' + lot.lot_no + '">' + lot
                            .loc_name + '</option>';
                    });
                    $('#lot').html(options).prop('disabled', false);
                },
                error: function () {
                    alert('Failed to fetch lots. Please try again.');
                }
            });
        } else {
            $('#lot').html('<option value="">-- Select Lot --</option>').prop('disabled', true);
        }
    });


    // Lot -> Village
    $('#lot').change(function () {
        var mouza_code = $('#mouza').val();
        var lot_no = $(this).val();
        $('#village').html('<option>-- Loading Villages --</option>').prop('disabled', true);

        if (lot_no !== '') {
            $.ajax({
                url: base_url + 'index.php/Rccms/get_villages_by_lot',
                type: 'POST',
                data: {
                    mouza_pargona_code: mouza_code,
                    lot_no: lot_no
                },
                dataType: 'json',
                success: function (response) {
                    var options = '<option value="">-- Select Village --</option>';
                    $.each(response, function (i, village) {
                        options += '<option value="' + village.vill_townprt_code +
                            '">' + village.loc_name + '</option>';
                    });
                    $('#village').html(options).prop('disabled', false);
                }
            });
        }
    });


    $('#validateVillageForm').submit(function (e) {
        e.preventDefault(); // prevent form submit

        $.ajax({
            url: base_url + 'index.php/rccms/validate_village',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#validationFailedDiv').hide();
                    $('#validationSuccessDiv').removeClass('d-none').show();
                } else {
                    $('#validationSuccessDiv').hide();
                    $('#validationFailedDiv').removeClass('d-none').show();
                }
            },
            error: function () {
                alert('Something went wrong. Please try again.');
            }
        });
    });

});

// Select-all checkbox and strike form handling
$(document).on('change', '.select-all-pattadar', function () {
    // id format: selectAll-<index>
    var parts = $(this).attr('id').split('-');
    var idx = parts.length > 1 ? parts[1] : '';
    var checked = $(this).is(':checked');
    // find checkboxes in the same tab pane
    $('#tab-pane-' + idx).find('.pattadar-checkbox').prop('checked', checked);
});
$(document).on('change', '.select-all-pattadar-unstrike', function () {
    // id format: selectAll-<index>
    var parts = $(this).attr('id').split('-');
    var idx = parts.length > 1 ? parts[1] : '';
    var checked = $(this).is(':checked');
    // find checkboxes in the same tab pane
    $('#tab-pane-' + idx).find('.unpattadar-checkbox').prop('checked', checked);
});





$('#previewAllData').on('click', function () {
    let previewHtml = '';
    let subTabs = ['addPattadar', 'strikePattadar', 'areaChange', 'pattaTypeChange', 'otherRemarks'];

    landDetails.forEach(function (row, index) {
        previewHtml += '<h5>DAG: ' + row.dagNo + ' | Patta: ' + row.pattaNo + '</h5>';

        subTabs.forEach(function (tab) {
            let pane = $('#' + tab + '-pane-' + index);
            let value = pane.find('textarea').val() || pane.text().trim() || 'No data';
            previewHtml += '<div class="mb-2"><strong>' + tab.replace(/([A-Z])/g, ' $1') + ':</strong> ' + value + '</div>';
        });
    });

    // Overall remarks
    let overall = $('#overallRemarks').val() || 'No data';
    previewHtml += '<hr><h5>Overall Remarks:</h5><p>' + overall + '</p>';

    $('#previewModalBody').html(previewHtml);
    $('#previewModal').modal('show');
});


function getNumberAfterStrong(pane, label) {
    return pane
        .find(`strong:contains("${label}")`)
        .first()                      // FIX: take only the first <strong>
        .parent()
        .contents()
        .filter(function () {
            return this.nodeType === 3; // TEXT node only
        })
        .text()
        .trim();
}


$("#saveCaseBtn").on("click", function () {

    let case_id = $("#rccms_application_id").val();
    if (!case_id) {
        alert("Case ID is required!");
        return;
    }

    let payload = {
        application_id: case_id,
        location: {
            dist_code: $("#dist_code").val(),
            subdiv_code: $("#subdiv_code").val(),
            cir_code: $("#cir_code").val()
        },
        data: {}
    };

    // Loop through land tabs
    $("[id^='tab-pane-']").each(function () {

        let index = parseInt($(this).attr("id").split("-").pop());

        // =====================
        // LAND BASIC DATA
        // =====================
        let dag = getNumberAfterStrong($(this), "DAG No:");
        let patta = getNumberAfterStrong($(this), "Patta No:");

        payload.data[index] = {
            dag_no: dag,
            patta_no: patta
        };

        // =====================
        // PATTADARS
        // =====================
        let pattadarRows = $("#pattadarTable-" + index + " tbody tr");
        payload.data[index].pattadars = [];

        pattadarRows.each(function () {
            payload.data[index].pattadars.push({
                name: $(this).find("td:nth-child(2)").text().trim(),
                guardian: $(this).find("td:nth-child(3)").text().trim(),
                gender: $(this).find("td:nth-child(4)").text().trim(),
                relation: $(this).find("td:nth-child(5)").text().trim(),
                address: $(this).find("td:nth-child(6)").text().trim()
            });
        });

        // =====================
        // STRIKE
        // =====================
        let strikeForm = $("#strikePattadarForm-" + index);
        let selectedStrike = [];

        strikeForm.find(".pattadar-checkbox:checked").each(function () {
            selectedStrike.push(Number($(this).val()));
        });

        payload.data[index].strike = {
            selected: selectedStrike,
            reason: strikeForm.find("[name='strikeReason']").val()?.trim() || null
        };

        // =====================
        // UNSTRIKE
        // =====================
        let unstrikeForm = $("#unstrikePattadarForm-" + index);
        let selectedUnstrike = [];

        unstrikeForm.find(".unpattadar-checkbox:checked").each(function () {
            selectedUnstrike.push(Number($(this).val()));
        });

        payload.data[index].unstrike = {
            selected: selectedUnstrike,
            reason: unstrikeForm.find("[name='unstrikeReason']").val()?.trim() || null
        };

        // =====================
        // AREA CHANGE
        // =====================
        let areaForm = $("#areaChangeForm-" + index);
        payload.data[index].area_change = {
            bigha: areaForm.find("[name='bigha']").val(),
            katha: areaForm.find("[name='katha']").val(),
            lessa: areaForm.find("[name='lessa']").val(),
            gonda: areaForm.find("[name='gonda']").val(),
            chatak: areaForm.find("[name='chatak']").val(),
            reason: areaForm.find("[name='areaReason']").val()
        };

        // =====================
        // LAND CLASS CHANGE
        // =====================
        let landClassForm = $("#LandClassChangeForm-" + index);
        payload.data[index].land_class_change = {
            present: landClassForm.find("[name='landClassChange']").val(),
            reason: landClassForm.find("[name='reasonChangelandclass']").val()
        };

        // =====================
        // PATTA TYPE CHANGE
        // =====================
        let pattaForm = $("#pattaTypeChangeForm-" + index);
        payload.data[index].patta_type_change = {
            present: pattaForm.find("[name='presentPattaType']").val(),
            requested: pattaForm.find("[name='requestedPattaType']").val(),
            new_patta_no: pattaForm.find("[name='changePattaNo']").val(),
            reason: pattaForm.find("[name='reasonChange']").val()
        };

    });

    console.log("Sending payload:", payload);
    return;

    // =====================
    // AJAX SUBMIT
    // =====================
    $.ajax({
        url: base_url + 'index.php/Rccms/save_case',
        // url: baseurl + "EkhajanaCoController/forwardToAssistant",
        type: "POST",
        data: JSON.stringify(payload),
        dataType: "json",
        contentType: "application/json; charset=utf-8",

        success: function (res) {
            // console.log(res +"response from server");
            if (res.status) {
                // alert(res.msg);
                Swal.fire({
                    title: 'Submitted Successfully!',
                    text: "All the data has been saved.Please proceed to the next step.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#previewModal').modal('hide');
                    }
                })

            } else {
                Swal.fire({
                    title: 'Submitted SuccessfullyElse!',
                    text: "All the data has been saved.Please proceed to the next step.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm!'
                }).then((result) => {
                    if (result.isConfirmed) {

                    }
                })
            }
        },

        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Server Error!");
        }
    });
});




