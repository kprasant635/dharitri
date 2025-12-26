<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<div class="container-fluid">
    <div class="row mt-3 bg-danger p-2 shadow">
        <h5 class="text-center">
            CASE TRANSFER(ADC)
        </h5>
    </div>
    <div class="container bg-white shadow">
        <p class='red center mt-2'>Once You Changed ADC for selected service, all cases of that service will be shifted to newly assigned ADC</p>

        <form id="transferForm">
            <input type="hidden" id="district" value="<?php echo $this->session->userdata('dist_code'); ?>">
            <div class="row justify-content-center">
                <div class="col-8">
                    <table class="table">
                        <tr>
                            <th>Select Service</th>
                            <td>
                                <select name="service_code_name" id="service_code_name" class="form-control select2">
                                    <option value="">--select service--</option>
                                    <?php
                                        foreach ($services as $service_list) {
                                            if ($service_list->status == true) {
                                            ?>
                                        <option value="<?php echo $service_list->id; ?>"><?php echo $service_list->service_name; ?></option>
                                    <?php
                                        }
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Transfer from officer</th>
                            <td>
                                <select name="from_officer" id="from_officer" class="form-control select2">
                                    <option value="">--Select From Officer--</option>
                                    <?php
                                        foreach ($disbaled_adc as $adc) {
                                        ?>
                                        <option value="<?php echo $adc->user_code; ?>"><?php echo $adc->selected_adc_name; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Transfer to officer</th>
                            <td>
                                <select name="officer_to" id="officer_to" class="form-control select2">
                                    <option value="">--Select From Officer--</option>
                                    <?php
                                        foreach ($adcs as $adc) {
                                        ?>
                                        <option value="<?php echo $adc->user_code; ?>"><?php echo $adc->selected_adc_name; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-4 text-center">
                    <button type="submit" class="btn btn-danger">Transfer Case(s)</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2 for all select elements with class "select2"
        $('.select2').select2();

        // Hide the original select elements after Select2 initialization
        $('.select2').each(function() {
            $(this).siblings('select').hide();  // Hide the original select
        });

        // Handle form submission with AJAX
        $('#transferForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // add validation cannot be null
            if ($('#service_code_name').val() == '') {
                alert('Please select service');
                return false;
            }
            if ($('#from_officer').val() == '') {
                alert('Please select from officer');
                return false;
            }
            if ($('#officer_to').val() == '') {
                alert('Please select to officer');
                return false;
            }
            // Get form data
            var formData = {
                service_code_name: $('#service_code_name').val(),
                from_officer: $('#from_officer').val(),
                officer_to: $('#officer_to').val(),
                district: $('#district').val(),
            };

            // Perform AJAX request
            $.ajax({
                url: "<?php echo site_url('ADCCaseTransfer/transferCase'); ?>", // Change the URL as per your route
                type: "POST",
                data: formData,
                dataType: "json", // Expect JSON response
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        alert(response.message+"Total Cases Transferred: "+ response.total_transfer_case_number);
                    } else {
                        alert('Transfer Failed: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });
    });
</script>
