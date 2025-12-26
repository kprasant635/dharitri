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
    small, .small {
        font-size: 15px;
    }

    .badge {
        padding: 10px;
        font-size: 15px;
    }

    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 100px;
        line-height: 35px;
        padding: 0 .8rem;
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
        margin-bottom: 15px;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
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


</style>
<input type="hidden" value="<?php echo $dist_code ?>" id="selectDistrict">

<div class="row" style='margin: 10px 10px 10px 0px'>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left reza-title" style="padding: 5px 10px 10px 25px;">
        Process / <?php echo $this->lang->line('ncSidebar') ?> / View Property Card
    </div>


    <?php if($this->session->flashdata('success')) { ?>

        <div class="success-msg">
            <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
            </div>
        </div>

    <?php } ?>

    <?php if($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <b><?php echo $this->session->flashdata('error') ?></b>
            <br>
            <b><?php echo $this->session->flashdata('error_code') ?></b>
        </div>
    <?php } ?>



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="reza-card">
            <div class="reza-body" id="showBody" style="padding-top: 20px">
                <!-- DataTable starts-->
                <form method="POST">
                    <table class='table table-striped table-bordered' id='dataTableDigitalPatta' width="100%">
                        <thead>
                        <tr>
                            <th class="center">All
                                <input type="checkbox" name="check_list[]" class="checkBoxD caseCheckbox" value="all" id="checkedAll">
                            </th>
                            <th class="center">
                                <label class="control-label">Case No</label>
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
                            <br>
                            <button class="rezaButt buttInfo" type="button" id="bulkSentForApproveWithoutSignModalOpen">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                &nbsp;Print Property Card For Selected Application
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal for bulk send cases for digital patta starts -->
<div class="modal" role="dialog" id="sentForDigitalSignModalOpen" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header  bg-success">
                <h6 class="modal-title text-center" style="text-align:center" id="exampleModalLongTitle">
                    You have chosen the following cases:
                </h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="case_list" style="margin-bottom: 35px">


                    </div>
                    <br><br>
                    <div class="modal-footer">
                        <button type="button" class="rezaButt buttDanger" id="closeModalSentVerification">
                            <i class="fa fa-times"></i>&nbsp;Cancel
                        </button>
                        <button type="button" class="rezaButt buttPrimary" id="bulkCasesApproveSubmitWithoutPdf">
                            <i class="fa fa-print"></i>&nbsp;Print Property Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

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
        let count = 1;
        load_data_digital_patta_view_list();
        //Load Datatable
        function load_data_digital_patta_view_list() {

            $('#dataTableDigitalPatta thead th:nth-of-type(2)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder=" ' + title + '" />');
            });
            $('#dataTableDigitalPatta thead th:nth-of-type(3)').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="form-control input_search form-control-sm" placeholder=" ' + title + '" />');
            });

            var base_url = "<?php echo base_url(); ?>";
            var table = $('#dataTableDigitalPatta').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url+'index.php/DigitalPattaNC/getAllDigitalPattaViewDetails',
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
                        return count++;
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
            load_data_digital_patta_view_list();
        });


        var selectedCheckBoxArray = [];
        maxCheckboxes = <?=DIGITAL_PATTA_CHECK_LIMIT?>;
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
                alert('Only <?=DIGITAL_PATTA_CHECK_LIMIT?> cases can be selected at a time');
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
                        alert('Only <?=DIGITAL_PATTA_CHECK_LIMIT?> cases can be selected at a time');
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
        //                 alert('Only <?=DIGITAL_PATTA_CHECK_LIMIT?> cases can be selected at a time');
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

    //function to open modal for bulk sent of digital sign
    $(document).on('click', '#bulkSentForApproveWithoutSignModalOpen', function() {
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
            showWarningMessage("Please Select at-least one case for digital Signing...!");
        }

    });

    //close modal print the Property card MR
    $(document).on('click', '#closeModalSentVerification', function () {
        $('#sentForDigitalSignModalOpen').modal('hide');
        location.reload(true);
    });

    // view the Property card MR
    function viewDigitalPatta(case_no,dist_code)
    {
        var base_url = "<?php echo base_url(); ?>";
        var url = base_url + "index.php/DigitalPattaNC/getDigitalPattaDetailsForPrint?case_no=" + case_no;
        // Open in new tab
        window.open(url, "_blank");
    }


    //sent for digital sign of multiple cases
    $(document).on('click', '#bulkCasesApproveSubmitWithoutPdf', function() {
        // $.blockUI({
        //     message: $('#displayBox'),
        //     css: {
        //         border:'none',
        //         backgroundColor:'transparent'
        //     }
        // });
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
            url: base_url +'index.php/DigitalPattaNC/bulkPropertyCardViewOrPrintNc',
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            success: function(data)
            {
                if(data.responseType == 2)
                {
                    window.open(data.url, "_blank");
                }
                else if(data.responseType == 3)
                {
                    showErrorMessage(data.msg);
                    $('#sentForDigitalSignModalOpen').modal('hide');
                    return;
                }
                else
                {
                    showErrorMessage(data.msg);
                    $('#sentForDigitalSignModalOpen').modal('hide');
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




</script>
