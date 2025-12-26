<div class="container shadow bg-white p-5">
    <h5 class="p-3 bg-info text-center">CREATE NEW USER</h5>
    <div class="text-right fw-bold m-3"><a href="#">User list</a></div>
    <form class="m-4" id="save_data_form">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Name</label>
                <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">User name</label>
                <input type="text" class="form-control" placeholder="Enter username" id="user_name" name="user_name">
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Password</label>
                <input type="password" class="form-control" value="qwe@123" placeholder="Enter password" id="password" name="password">
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <button type="submit" class="btn btn-primary col-3 fw-bold">Create User</button>
        </div>
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
            url: baseurl + "EhrmsController/saveUser",
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