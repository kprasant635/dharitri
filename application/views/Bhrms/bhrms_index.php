<script>
    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>
<div class="bg-white p-5 shadow">
    <h5>
        <div class="row">
            <div class="col-6">EHRMS</div>
            <div class="col-6 text-right"><a href="<?php echo base_url() ?>index.php/Bhrms/viewList">view inserted list</a></div>
        </div>
    </h5>
    <hr>
    <form name="save_data" id="save_data_form" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputEmail4">Mouza Name</label>
            <select class="form-control" name="mouza_pargona_code" id="mouza_cat">
                <option value="">--select--</option>
                <?php
foreach ($mouza_result as $lr) {
    ?>
                        <option value="<?=$lr->mouza_pargona_code?>"><?=$lr->loc_name?></option>
                        <?php
}
?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="inputEmail4">Lot Name</label>
            <select class="form-control" name="lot_no" id="lot_cat">
                <option value="">--select--</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="inputPassword4">Village Name</label>
            <select class="form-control" name="vill_townprt_code" id="village_cat">
                <option value="">--select--</option>
                <?php
foreach ($lots_result as $lr) {
    ?>
                        <option value="<?=$lr->lot_no?>"><?=$lr->loc_name?></option>

                        <?php
}
?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputAddress">Name of Gaon Pradhan</label>
            <input type="text" class="form-control" name="pradhan_name" id="pradhan_name" placeholder="Enter pradhan name">
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Date of Birth</label>
            <input type="text" class="form-control ymd" name="dob" id="dob" placeholder="DOB" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputAddress">Date of Engagement</label>
            <input type="text" class="form-control ymd" name="date_of_eng" id="date_of_end" placeholder="Enter date of engagement" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Date of Retirement</label>
            <input type="text" class="form-control ymd" name="date_of_retirement" id="date_of_retirement" placeholder="Date of retirement" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputAddress">Education Qualification</label>
            <textarea type="text" class="form-control" name="edu_qualification" id="edu_qualification" placeholder="Enter education qualification"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Phone No</label>
            <input type="number" class="form-control" name="phone_no" id="phone_no" placeholder="Enter phone no" min="9" max="10">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputAddress">Remarks</label>
            <textarea type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter remarks"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress">Upload document</label>
            <input type="file" class="form-control" name="file_upload" id="file_upload">
        </div>
    </div>


    <button type="submit" class="btn col-12 btn-primary">Save</button>
    </form>
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
    $(document).on('change', '#mouza_cat, #lot_cat', function(){
        var mouzaCode = $('#mouza_cat').val();
        var lot_no = $('#lot_cat').val();

        var postData = {
            'mouza_pargona_code' : mouzaCode,
            'lot_no' : lot_no,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementCommon/getLotsFromMouzaCo',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    var options = '<option value="">Select Lot</option>';
                    var options2 = '<option value="">Select Village</option>';

                    if(mouzaCode == '')
                    {
                        $('#lot_cat').html(options);
                        $('#village_cat').html(options2);
                    }

                    if(arr.lot_details != '')
                    {
                        for(i=0; i<arr.lot_details.length; i ++)
                        {
                            options += "<option value='"+arr.lot_details[i].lot_no+"'>"+arr.lot_details[i].loc_name+"</option>";
                        }

                        $('#lot_cat').html(options);
                    }

                    if(arr.village_details != '')
                    {
                        for(i=0; i<arr.village_details.length; i ++)
                        {
                            options2 += "<option value='"+arr.village_details[i].vill_townprt_code+"'>"+arr.village_details[i].loc_name+"</option>";
                        }

                        $('#village_cat').html(options2);

                    }
                    else
                    {
                        $('#village_cat').html(options2);
                    }
                }
            }
        });
    })


    $('#save_data_form').submit(function (e) {
        e.preventDefault();
        if(!confirm("Are you sure you want to save the filled data?"))
        {
            return false;
        }
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var formData = new FormData($('#save_data_form')[0]);

        $.ajax({
            url: baseurl + "Bhrms/save",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $.unblockUI();
                if(data.responseType != 2)
                {
                    showErrorMessage(data.msg);
                    return false;
                }
                else
                {
                    Swal.fire({
                        text: data.msg,
                        // html: data.msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }

            },
            error: function (error) {
                console.log(error);
                $.unblockUI();
                alert("Something went wrong");
            }

        })

    });

</script>