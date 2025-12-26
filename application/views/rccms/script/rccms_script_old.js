$("#saveCaseBtn").on("click", function () {

    // alert($("#dist_code").val());
    // return;
    let case_id = $("#rccms_application_id").val();
    // let applicant_name = $("#applicant_name").val();

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
        lands_details: {},
        pattadars: {},
        strike: {},
        unstrike: {},
        area_change: {},
        land_class_change: {},
        patta_type_change: {},
        // remarks: {}  
    };

    // Loop through all tab-pane indexes (0,1,2,...)
    $("[id^='tab-pane-']").each(function () {

        let index = $(this).attr("id").split("-").pop();
        index = parseInt(index);

        // ================
        // LAND DATA
        // ================
        let dag = getNumberAfterStrong($(this), "DAG No:");
        let patta = getNumberAfterStrong($(this), "Patta No:");

        payload.lands_details[index] = {
            dag_no: dag,
            patta_no: patta
        };

        // ==========================
        // PATTADARS (TABLE ROW DATA)
        // ==========================
        let pattadarRows = $("#pattadarTable-" + index + " tbody tr");
        payload.pattadars[index] = [];

        pattadarRows.each(function () {
            payload.pattadars[index].push({
                name: $(this).find("td:nth-child(2)").text().trim(),
                guardian: $(this).find("td:nth-child(3)").text().trim(),
                gender: $(this).find("td:nth-child(4)").text().trim(),
                relation: $(this).find("td:nth-child(5)").text().trim(),
                address: $(this).find("td:nth-child(6)").text().trim()
            });
        });

        // ==========================
        // STRIKE PATTADAR
        // ==========================
        // Ensure object exists
        payload.strike = payload.strike || {};
        payload.unstrike = payload.unstrike || {};

        // ==========================
        // STRIKE PATTADAR
        // ==========================
        let strikeForm = $("#strikePattadarForm-" + index);
        let selectedStrike = [];

        strikeForm.find(".pattadar-checkbox:checked").each(function () {
            selectedStrike.push(Number($(this).val())); // Convert to integer
        });

        payload.strike[index] = {
            selected: selectedStrike,
            reason: strikeForm.find("[name='strikeReason']").val()?.trim() || null
        };

        // ==========================
        // UN-STRIKE PATTADAR
        // ==========================
        let unstrikeForm = $("#unstrikePattadarForm-" + index);
        let selectedUnstrike = [];

        unstrikeForm.find(".unpattadar-checkbox:checked").each(function () {
            selectedUnstrike.push(Number($(this).val())); // Convert to integer
        });

        // Optional: Prevent conflict — same ID cannot be in both actions
        // selectedUnstrike = selectedUnstrike.filter(id => !selectedStrike.includes(id));

        payload.unstrike[index] = {
            selected: selectedUnstrike,
            reason: unstrikeForm.find("[name='unstrikeReason']").val()?.trim() || null
        };


        // ==========================
        // AREA CHANGE
        // ==========================
        let areaForm = $("#areaChangeForm-" + index);
        payload.area_change[index] = {
            bigha: areaForm.find("[name='bigha']").val(),
            katha: areaForm.find("[name='katha']").val(),
            lessa: areaForm.find("[name='lessa']").val(),
            gonda: areaForm.find("[name='gonda']").val(),
            chatak: areaForm.find("[name='chatak']").val(),
            reason: areaForm.find("[name='areaReason']").val()
        };

        // ==========================
        // PATTA TYPE CHANGE
        // ==========================
        let pattaForm = $("#pattaTypeChangeForm-" + index);
        payload.patta_type_change[index] = {
            present: pattaForm.find("[name='presentPattaType']").val(),
            requested: pattaForm.find("[name='requestedPattaType']").val(),
            new_patta_no: pattaForm.find("[name='changePattaNo']").val(),
            reason: pattaForm.find("[name='reasonChange']").val()
        };
        // ==========================
            // Land Class TYPE CHANGE
        // ==========================
        let LandClassForm = $("#LandClassChangeForm-" + index);
        payload.land_class_change[index] = {
            present: LandClassForm.find("[name='landClassChange']").val(),
            reason: LandClassForm.find("[name='reasonChangelandclass']").val()
        };

        // ==========================
        // OTHER REMARKS
        // ==========================
        // let remarkForm = $("#otherRemarksForm-" + index);
        // payload.remarks[index] = remarkForm.find("[name='remarks']").val();
    });


    // console.log("Sending payload:", payload);
    // return;

    // ==========================
    // SEND AJAX REQUEST
    // ==========================
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


let hasAreaChange = false;
let areaText = '';



    const bigha  = areaForm.find('[name="bigha"]').val() || 0;
    const katha  = areaForm.find('[name="katha"]').val() || 0;
    const lessa  = areaForm.find('[name="lessa"]').val() || 0;

    let gonda = 0, chatak = 0;
    if (districtCode == Barak_Vally_Distcode) {
        gonda  = areaForm.find('[name="gonda"]').val() || 0;
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

