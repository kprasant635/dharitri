<div class="container-fluid">
    <div class="row mt-3 bg-danger p-2 shadow">
        <h5 class="text-center">
            CASE TRANSFER(CO)
        </h5>
    </div>
    <div class="container bg-white shadow">
		<p class='red center mt-2'>Once You Changed CO for selected service, all cases of that service will be shifted to newly assigned CO</p>

        <form id="transferForm">
            <div class="row justify-content-center">
                <div class="col-8">
                    <table class="table">

                        <tr>
                            <th>Select Circle</th>
                            <td>
                                <select name="location" id="location" class="form-control">
                                    <option value="">--select circle--</option>
                                    <?php
                                    foreach($circle_list as $cir){
                                        ?>
                                        <option value="<?=$cir->dist_code?>_<?=$cir->subdiv_code?>_<?=$cir->cir_code?>"><?=$cir->loc_name?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Select Service</th>
                            <td>
                                <select name="service_code_name" id="service_code_name" onchange="changeService(this)" class="form-control">
                                    <option value="">--select service--</option>

                                    <?php
                                    foreach(json_decode(CO_CASE_TRANSFER_SERVICES) as $service_list){
                                        if($service_list->STATUS == 1){
                                    ?>
                                        <option value="<?=$service_list->SERVICE_CODE?>"><?=$service_list->SERVICE_NAME?></option>
                                    <?php
                                        }
                                    }   
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Transfer from officer</th>
                            <td id="from_officer">
                                &mdash;
                            </td>
                        </tr>

                        <tr>
                            <th>Transfer to officer</th>
                            <td id="officer_to">
                                &mdash;
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
<script>
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
</script>

<script>
    function changeService(service){

        var location = $('#location').val();

        if(location == ''){
            alert('Please select circle name!');
            let options = document.getElementById("service_code_name").options;
            for (let option of options) {
                if (option.value === "") {
                    option.selected = true;
                    break;
                }
            }
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'CaseTransferCo/getFromOfficers',
            type: "POST",
            data: {
                service_code: service.value,
                location: location
            },
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.data == null){
                    $('#from_officer').html('&mdash;');
                    $('#officer_to').html('&mdash;');
                    let options = document.getElementById("service_code_name").options;
                    for (let option of options) {
                        if (option.value === "") {
                            option.selected = true;
                            break;
                        }
                    }
                    showErrorMessage('No data found!');
                    return false;
                }

                if(arr.responseType != 2){
                    $('#from_officer').html('&mdash;');
                    $('#officer_to').html('&mdash;');
                    let options = document.getElementById("service_code_name").options;
                    for (let option of options) {
                        if (option.value === "") {
                            option.selected = true;
                            break;
                        }
                    }
                    showErrorMessage(arr.msg);
                    return false;
                }
                else{

                    var checkboxes = '';
                    for(i=0; i<arr.data.length; i++){
                        checkboxes += '<input type="checkbox" name="from_user_code[]" value="'+arr.data[i].user_code+'" style="transform: scale(1.2); margin-right: 8px;"> <label>'+arr.data[i].username+'</label><br>';
                    }
                    $('#from_officer').html(checkboxes);


                    var options_to = '<option value="">--select--</option>';

                    for(j=0; j<arr.data1.length; j++){
                        options_to += '<option value="'+arr.data1[j].user_code+'">'+arr.data1[j].username+'</option>' 
                    }

                    $('#officer_to').html('<select name="to_user_code" class="form-control">'+options_to+'</select>');
                }
            }
        });
    }

</script>

<script>
    $('#transferForm').on('submit', function(e){
        e.preventDefault();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'CaseTransferCo/transferCase',
            type: "POST",
            data: $('#transferForm').serialize(),
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);
                if(arr.responseType != 2){
                    $('#from_officer').html('&mdash;');
                    $('#officer_to').html('&mdash;');
                    let options = document.getElementById("service_code_name").options;
                    for (let option of options) {
                        if (option.value === "") {
                            option.selected = true;
                            break;
                        }
                    }
                    showErrorMessage(arr.msg);
                    return false;
                }else{
                    $('#from_officer').html('&mdash;');
                    $('#officer_to').html('&mdash;');
                    let options = document.getElementById("service_code_name").options;
                    for (let option of options) {
                        if (option.value === "") {
                            option.selected = true;
                            break;
                        }
                    }
                    showSuccessMessage(arr.msg)
                }
            }
        });
        

    })
</script>