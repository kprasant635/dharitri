<!-- Sweet Alert Link -->
<link href="<?php echo base_url('css/sweetalert2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('js/sweetalert2.all.min.js'); ?>"></script>
<!-- Sweetalert Link End -->
<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }

    .form-control-1{
            font-size:14px;
        width:100%;

    }

    .reza-card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
    }

    .reza-title {
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }

    .reza-body {
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
    }

    .badge {
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }

    .rezaButt:hover {
        color: #0c0c0c;
    }

    .rezaButt {
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
    }

    .rezaText {
        font-size: 16px;
    }

    label {
        padding-bottom: 5px;
        font-weight: bold;
    }

    #searchBox {
        padding: 15px;
        border: 1px solid #00BCD4;
        margin: 0px;
    }

    #cases_wrapper {
        margin-top: 0px !important;
    }

    /*.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {*/
    /*display: none;*/
    /*}*/
</style>

<input type="hidden" value="<?php echo $dist_code ?>" id="selectDistrict">

<div class="row" style='padding: 40px 50px 40px 20px'>

<h2 class="text-center">Allotment Certificate</h2>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="reza-card">
            <div class="reza-body" id="showBody">
                <!-- DataTable starts-->
                <form method="POST">
                <table class='table table-striped table-bordered' id='dataTableDigitalPatta' width="100%">
                    <thead>
                        <tr>
                            <th class="center">All <input type="checkbox" name="check_list[]" class="checkBoxD caseCheckbox" value="all" id="checkedAll"> </th>

                             <th class="center">
                                <label class="control-label">Case No</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Application No</label>
                            </th>

                            <th class="center">
                                <label class="control-label">Service</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Date</label>
                            </th>
                            <th class="center">
                                <label class="control-label">District</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Circle</label>
                            </th>
                            <th class="center">
                                <label class="control-label">Village</label>
                            </th>
                            <th scope="col" class="center" >
                                <label class="control-label">Action</label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- DataTable ends -->
                <div class="row">
                    <div class="col-lg-12" align="left">
                    <?php if (ENABLE_DIGITAL_PATTA_BATCH_SIGN == 1) {?>
                        <button class="btn btn-success" type="button" id="bulkSentForDigitalSignModalOpen">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            Digital Sign Selected Application
                        </button>
                        <?php
                        } elseif (ENABLE_DIGITAL_PATTA_BATCH_SIGN == 2) {?>
                        <button class="btn btn-primary" type="button" id="bulkPrint">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            Approve Allotment Certifcate For Selected Application
                        </button>
                        <?php } else {?>
                            <button class="btn btn-danger" type="button" id="bulkPrint">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            Print Certificates
                        </button>
                            <?php }?>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" role="dialog" id="showAllotCetificateModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">

            </div>
            <div class="modal-body" id="digital-patta-div_modal">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="closeAllotCetificateModal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- digital patta view  starts -->
<!-- <div id="digital-patta-div_modal"></div> -->
<!-- digital patta view  ends -->
<!-- Modal for bulk send cases for digital patta starts -->
<div class="modal" role="dialog" id="sentForDigitalSignModalOpen" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title text-center" style="text-align:center" id="exampleModalLongTitle">
                    You Have Choosen the following cases:
                </h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="case_list">
                        <!-- dynamically populated case list -->
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check mt-3 ml-3">
                        <input type="checkbox" class="form-check-input" id="dataCheck">
                        <label class="form-check-label" for="dataCheck">
                        I hereby declare that I have thoroughly examined the data and found it to be correct
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="closeModalSentVerification">Cancel</button>

                        <!-- Your existing conditionally rendered buttons (one shown below as an example) -->
                        <button type="button" class="btn btn-danger btn-sm" id="print_certificate" disabled>
                            Print Certificates
                        </button>

                         <!-- <button type="button" class="btn btn-danger btn-sm" id="print_pdf_certificate" disabled>
                            Print PDF
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this script at the end or in your JS file -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById("dataCheck");
        const actionButton = document.getElementById("print_certificate");
        // const actionButton2 = document.getElementById("print_pdf_certificate");

        checkbox.addEventListener("change", function () {
            actionButton.disabled = !checkbox.checked;
            // actionButton2.disabled = !checkbox.checked;
        });
    });
</script>

<!-- Modal for bulk send cases for digital patta ends -->
<!-- BATCH SIGN STARTS-->
<div class="row">
    <div class="col-sm-4">
        <div class="well-sm" style="display:none">
            <input type="hidden" id="case_no_signed">
            <form id="pdfForm">
                Batch Size: <br/>
                <input type="hidden" id="txtBatchSize" value="" maxlength="3" />
                <input id="btnInitBatch" type="button" value="Initialize" class="btn btn-success"><br/>
                Batch Token: <br/>
                <textarea cols="30" rows="3" id="txtBatchToken" readonly="readonly"></textarea><br/>
                <label for="data">Choose Local File : </label><br />
                <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf" />
                <label for="pdfData">Pdf Data(Base64)):</label> <br />
                <textarea id="pdfData" placeholder="Choose pdf file above to show pdf data..."cols="60" rows="4" readonly="readonly">
                </textarea><br/>
                <label for="cert">Certificate for Signing:</label><br/>
                <textarea  id="cert"><?php echo $certificate; ?></textarea><br/>
                Reason : <input type="hidden" id="signingReason" name="signingReason" maxlength="20" /> <br />
                Location : <input type="hidden" id="signingLocation" name="signingLocation" maxlength="20" /> <br />
                stampingX : <input type="hidden" id="stampingX" name="stampingX" maxlength="20" value="150" /> <br />
                stampingY: <input type="hidden" id="stampingY" name="stampingY" maxlength="20" value="50" /><br />
                Select TSA URL :
                <select name="tsaurls" id="tsaurls" onchange="myFunction()">
                    <option value="0">--------------------------SELECT---------------------------------</option>
                    <option value="http://sha256timestamp.ws.symantec.com/sha256/timestamp"> http://sha256timestamp.ws.symantec.com/sha256/timestamp</option>
                    <option value="http://timestamp.comodoca.com/rfc3161">http://timestamp.comodoca.com/rfc3161</option>
                    <option value="http://tsa.startssl.com/rfc3161">http://tsa.startssl.com/rfc3161</option>
                    <option value="http://timestamp.digicert.com">http://timestamp.digicert.com</option>
                    <option value="http://tsa.safecreative.org">http://tsa.safecreative.org</option>
                </select> <br/>
                TSA URL (Optional) :
                <input type="hidden" id="tsaURL" name="tsaURL" value="" maxlength="100" style="width: 400px;" /> <br />
                Time Server URL (Optional) :
                <input type="hidden" id="timeServerURL" name="timeServerURL" value="<?php echo DIGITAL_SIGN_SERVER_TIME_URL ?>" maxlength="100" style="width: 400px;" /><br />
                <span style="color: red;">
                    If the time server URL is not provided, the client time will be used for signing.
                </span> <br/>
                <input id="signPdf" type="button" value=" Sign Pdf " class="btn btn-success">
                <input id="submitPdf" type="Submit" style="display: none;"><a id="downloadDiv" href='#' type="application/pdf" download="SignedPdf.pdf"></a>
                <input id="btnDecryptVerify" type="button" value=" Decrypt Verify " class="btn btn-danger" />
                <input id="btnDecryptVerifyWithCrt" type="button" value=" Decrypt & Verify " class="btn btn-danger" />
            </form>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="well-sm" style="display:none">
            <label for="signedPdfData">Signed Pdf Data(Base64):</label> <br />
            <textarea placeholder="After signing, the encrypted signature will be shown here..." id="signedPdfData" cols="60" rows="8" disabled></textarea> <br />
            <label>Encryption Key:</label>
            <textarea placeholder="The random key used for encrypting the signature will be shown here..." id="lblEncryptedKey" cols="60" rows="4" disabled></textarea> <br />
            <label>Verification Response:</label>
            <textarea placeholder="The signature verification result from DSCAPI server will be shown here..." id="verificationResponse" cols="60" rows="8" disabled></textarea>
        </div>
    </div>
</div>
<div id="panel"></div>

<!-- BATCH SIGN  ENDS -->
<script>
    
    var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function () {



        $(document).on('click', '#bulkSentForDigitalSignModalOpen', function(){
            $('.case_list').html('');
            var batch_size = $("#txtBatchSize").val();
            $("#txtBatchToken").val(dscSigner.initbatch(batch_size));
            $("#txtBatchSize").attr("disabled", "disabled");
            $("#btnInitBatch").attr("disabled", "disabled");
            let trCases = [];
            $('.selectMark').each(function(){
                if($(this).is(":checked")){
                    trCases = [...trCases, $(this).val()];
                }
            });

            trCases.map(function(value){
                $('.case_list').append(`<span class="badge badge-success mx-3 mt-2">${value}</span>`);
            });
        });

    });
</script>

<script>
$(document).ready(function () {
    $('#closeAllotCetificateModal').on('click', function () {
        $('#showAllotCetificateModal').modal('hide');
    });
});

    // Success Message
    function showSuccessMessage(data) {
        Swal.fire({
        backdrop:true,
        allowOutsideClick: false,
        title: data,
        confirmButtonText: 'OK',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
        }
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(true);
            }
        });
    }

    // Error Message
    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    // Warning Message
    function showWarningMessage(text) {
        swal.fire({
            // title: "Error!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
            confirmButtonText: 'OK',
            //timer: 5000,
            showCancelButton: false,
            customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
        }
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(true);
            }
        });

    }

    // Datatable
    $(document).ready(function() {

        load_data_digital_patta_list();
        //Load Datatable
        function load_data_digital_patta_list() {

            $('#dataTableDigitalPatta thead th:nth-of-type(2)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder=" ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var table = $('#dataTableDigitalPatta').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "responsive": true,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url+'index.php/AllotmentCertificate/getAllDigitalPattaDetailsIssuedv2',
                    type: 'POST',
                    data: {
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],

                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0],
                    checkboxes: {
                        'selectRow': true
                    },
                    data: "is_visible",
                    'render': function(data, type, row) {
                        let text = row[0];
                        const myArray = text.split("/");
                        var arr = myArray[3];
                        return '<input type="checkbox" class="checkBoxD selectMark" value=' + row[0] + ' id=' + arr + ' name="selectMark[]">';
                    }
                }],
            });

                table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });

        }

        $('.search_button').on('click', function() {
            $('table thead tr th .input_search').each(function() {
                $(this).val('');
            });
            $('#dataTableDigitalPatta').DataTable().destroy();
            load_data_digital_patta_list();
        });


            var selectedCheckBoxArray = [];
            maxCheckboxes =                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo DIGITAL_PATTA_CHECK_LIMIT ?>;
            $('#dataTableDigitalPatta tbody').on('click', 'input[type="checkbox"]', function(e) {

            var checkBoxId = $(this).val();

            var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
            if (this.checked && rowIndex === -1) {
                selectedCheckBoxArray.push(checkBoxId);
            } else if (!this.checked && rowIndex !== -1) {
                selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
            }

            $('#txtBatchSize').val(selectedCheckBoxArray.length);

            if (selectedCheckBoxArray.length > maxCheckboxes) {
                $(this).prop('checked', false);
                alert('Only                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo DIGITAL_PATTA_CHECK_LIMIT ?> cases can be selected at a time');
                location.reload(true);
                return;
            }
        });

        var alertShown = false;
        $("#checkedAll").click(function() {
            if (this.checked) {
                $('.selectMark').each(function() {
                    this.checked = true;
                    var id = $(this).val();
                    if (selectedCheckBoxArray.length > maxCheckboxes && !alertShown) {
                        alertShown = true;
                        $(this).prop('checked', false);
                        alert('Only                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo DIGITAL_PATTA_CHECK_LIMIT ?> cases can be selected at a time');
                        location.reload(true);
                        return;
                    }
                    $('#txtBatchSize').val(selectedCheckBoxArray.length);
                    if ($.inArray(id, selectedCheckBoxArray) !== -1) {
                        // $('.selectMark').prop('checked', false);
                    } else {
                        selectedCheckBoxArray.push(id);
                        $('.selectMark').prop('checked', true);
                    }
                });
            } else {
                $('.selectMark').each(function() {
                    this.checked = false;
                    var id = $(this).val();
                    var rowIndex = $.inArray(id, selectedCheckBoxArray);
                    if (rowIndex !== -1) {
                        selectedCheckBoxArray.splice(rowIndex, 1);
                        $('.selectMark').prop('checked', false);
                    }
                });
                alertShown = false;
            }
        });

        // $("#checkedAll").click(function() {
        //     if (this.checked) {
        //         $('.selectMark').each(function() {
        //             this.checked = true;
        //             var id = $(this).val();
        //             if(selectedCheckBoxArray.length > maxCheckboxes){
        //                 $(this).prop('checked', false);
        //                 alert('Only                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo DIGITAL_PATTA_CHECK_LIMIT ?> cases can be selected at a time');
        //                 location.reload(true);
        //                 return;
        //             }
        //             $('#txtBatchSize').val(selectedCheckBoxArray.length);
        //             if ($.inArray(id, selectedCheckBoxArray) !== -1) {
        //                 // $('.selectMark').prop('checked', false);
        //             } else {
        //                 selectedCheckBoxArray.push(id);
        //                 $('.selectMark').prop('checked', true);
        //             }
        //         })
        //     } else {
        //         $('.selectMark').each(function() {
        //             this.checked = false;
        //             var id = $(this).val();
        //             var rowIndex = $.inArray(id, selectedCheckBoxArray);
        //             if (rowIndex == -1) {

        //             } else {
        //                 selectedCheckBoxArray.splice(rowIndex, 1);
        //                 $('.selectMark').prop('checked', false);
        //             }
        //         })
        //     }
        // });

        $("#dataTableDigitalPatta").on('draw.dt', function() {
            for (var i = 0; i < selectedCheckBoxArray.length; i++) {
                checkboxId = selectedCheckBoxArray[i];
                const myArray = checkboxId.split("/");
                var arr = myArray[3];
                $('#' + arr).attr('checked', true);
            }
        });
    });

    //sent for digital sign of multiple cases
    $(document).on('click', '#bulkSentForDigitalSign', function() {

        var base_url = "<?php echo base_url(); ?>";
        var district_id = $("#selectDistrict").val();
        var selectedList = [];
        $('.selectMark:checked').each(function(i) {
            selectedList[i] = $(this).val();
        });

            const applicant = {
                selectedList: selectedList,
                district_id: district_id,

            };
            $.ajax({
                url: base_url +'index.php/DigitalPatta/bulkSignOfDigitalPatta',
                type: "POST",
                dataType: "json",
                contentType: "application/json",
                success: function(data) {

                    if(data.responseType == 3){
                        showWarningMessage(data.msg);
                        $('#sentForDigitalSignModalOpen').modal('hide');
                        //location.reload(true);
                        return;
                    }else{
                            for (let index = 0; index < data.length; index++)
                            {
                                $("#case_no_signed").val(data[index].case_no);
                                autoBatchSign(data[index].base64);
                            }
                    }

                },
                data: JSON.stringify(applicant)

            });

    });

    //converting into base 64 method
    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
        }));
    }

    //function to close modal
    $(document).on('click', '#closeModalSentVerification', function () {
        $('#sentForDigitalSignModalOpen').modal('hide');
        $('#showAllotmentCertificateModal').modal('hide');
        location.reload(true);
    });

    //function to open modal for bulk sent of digital sign
    $(document).on('click', '#bulkSentForDigitalSignModalOpen', function() {

        var district_id = $("#selectDistrict").val();
        var selectedList = [];
        $('.selectMark:checked').each(function(i) {
            selectedList[i] = $(this).val();
        });
        $('#txtBatchSize').val(selectedList.length);
        // alert(selectedList.length);
        if (selectedList.length > 0) {
            $('#selectedCasesList').val(selectedList);
            $('#selectDistrictModal').val(district_id);
            $('#sentForDigitalSignModalOpen').modal('show');
            $('#selectedCases').show();

        } else {
            showWarningMessage("Please Select atleast one case for digital Signing...!");
        }

    });

    //function to open modal for bulk sent of digital sign
    $(document).on('click', '#bulkPrint', function() {
        $('.case_list').html('');
        var district_id = $("#selectDistrict").val();
        var selectedList = [];
        $('.selectMark:checked').each(function(i) {
            selectedList[i] = $(this).val();
        });
        // $('#txtBatchSize').val(selectedList.length);
        // alert(selectedList.length);
        if (selectedList.length > 0) {
            $('#selectedCasesList').val(selectedList);
            $('#selectDistrictModal').val(district_id);
            $('#sentForDigitalSignModalOpen').modal('show');
            $('#selectedCases').show();
            selectedList.map(function(value){
                $('.case_list').append(`<span class="badge badge-success mx-3 mt-2">${value}</span>`);
            });

        } else {
            showWarningMessage("Please Select atleast one case for Allotment Certificate...!");
        }

    });




    //function after digital sign button click
    function viewIssuedDigitalPatta(case_no,dist_code){
      


        // const datas = {
        //     case_no: case_no,
        //     dist_code: dist_code,
        // };

        // $.ajax({
        //     url: base_url +'index.php/AllotmentCertificate/getAllotmentCertificateIssued',
        //     type: "POST",
        //     dataType: "json",
        //     contentType: "application/json",
        //     success: function(data) {
        //         //console.log(data);

        //         if (data.responseType == 3) {
        //             showWarningMessage(data.msg);
        //             return;
        //         } else {
        //             $("#digital-patta-div_modal").html(data);
        //             $('#showAllotCetificateModal').modal('show'); // Correct way
        //             return;
        //         }

        //         Swal.fire({
        //             backdrop:true,
        //             allowOutsideClick: false,
        //             text: data.message,
        //             confirmButtonText: 'OK',
        //             customClass: {
        //                 actions: 'my-actions',
        //                 confirmButton: 'order-2',
        //                 }
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                 location.reload(true);
        //             }
        //         });

        //     },

        //     data: JSON.stringify(datas)

        // });
    }

</script>

<!-- BATCH SIGN SCRIPT STARTS -->



<script>

        $(document).on('click', '#print_certificate', function() {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        var base_url = "<?php echo base_url(); ?>";
        var district_id = $("#selectDistrict").val();
        var selectedList = [];

        $('.selectMark:checked').each(function(i) {
            selectedList[i] = $(this).val();
        });
        const applicant = {
            selectedList: selectedList,
            district_id: district_id,
        };
        //console.log(applicant);
        $.ajax({
            url: base_url +'index.php/AllotmentCertificate/print_certificates_without_sign',
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                $.unblockUI();
                if(data.flag == 'Y'){
                    // Open a new window and write the HTML
                    var printWindow = window.open('', '_blank');
                    printWindow.document.write(data.html);
                    printWindow.document.close();
                    printWindow.focus();
                    // printWindow.print();
                    // printWindow.close();
                    return;
                } else if(data.flag == 'N'){
                    showErrorMessage(data.msg);
                    return;
                }
            },

            data: JSON.stringify(applicant),
            error: function (error) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    });


    $(document).on('click', '#print_pdf_certificate', function() {
   
        $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    var base_url = "<?php echo base_url(); ?>";
    var district_id = $("#selectDistrict").val();
    var selectedList = [];

    $('.selectMark:checked').each(function(i) {
        selectedList[i] = $(this).val();
    });

    const applicant = {
        selectedList: selectedList,
        district_id: district_id,
    };

    // Create a temporary form to send POST data
    var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", base_url + 'index.php/AllotmentCertificate/print_certificates_as_pdf');
    form.setAttribute("target", "_blank");

    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "data");
    input.setAttribute("value", JSON.stringify(applicant));
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    // Unblock UI after a short delay to ensure PDF generation starts
    setTimeout(function() {
        $.unblockUI();
    }, 1000);
});

</script>