<div class="bg-white p-5 shadow">
    <h5>
        <div class="row">
            <div class="col-6">
                EHRMS /
                <a href="<?php echo base_url() ?>index.php/Bhrms/downloadExcel">Download excel list</a>
            </div>
            <div class="col-6 text-right"><a href="<?php echo base_url() ?>index.php/Bhrms/index">Insert more data</a></div>
        </div>
    </h5>
    <hr>
    <?php
if ($has_list != true) {
    ?>
            <h5 class="alert-danger p-3">No data found....</h5>
            <?php
} else {
    ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name of Circle</th>
                        <th>Sl No</th>
                        <th>Name of Gaon Pradhan</th>
                        <th>Date of Birth</th>
                        <th>Date of Engagement</th>
                        <th>Date of Retirement</th>
                        <th>Education Qualification</th>
                        <th>Phone no</th>
                        <th>Remarks</th>
                        <th>Documents</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$sl_no = 1;
    $row_count = count($list_result);
    foreach ($list_result as $index => $res_row) {
        if ($index === 0) {
            ?>
                    <tr>
                        <td rowspan="<?=$row_count?>" class="text-center" style="vertical-align: middle;">
                            <?=$this->utilityclass->getCircleName($res_row->dist_code, $res_row->subdiv_code, $res_row->cir_code)?>
                        </td>
                        <td><?=$sl_no++?></td>
                        <td><?=$res_row->name_of_pradhan?></td>
                        <td><?=$res_row->dob?></td>
                        <td><?=$res_row->date_of_engagement?></td>
                        <td><?=$res_row->date_of_retirement?></td>
                        <td><?=$res_row->education_qualification?></td>
                        <td><?=$res_row->phone_no?></td>
                        <td><?=$res_row->remarks?></td>
                        <td><a target='download' href="<?php echo base_url(); ?>index.php/Bhrms/view/<?=$res_row->document_link;?>"><i class="fa fa-paperclip"></i>View document</a></td>
                        <td><button type="buttton" onclick="deleteID(<?=$res_row->id?>)" class="btn btn-sm btn-danger">Delete</button></td>
                    </tr>
                    <?php
} else {
            ?>
                    <tr>
                        <td><?=$sl_no++?></td>
                        <td><?=$res_row->name_of_pradhan?></td>
                        <td><?=$res_row->dob?></td>
                        <td><?=$res_row->date_of_engagement?></td>
                        <td><?=$res_row->date_of_retirement?></td>
                        <td><?=$res_row->education_qualification?></td>
                        <td><?=$res_row->phone_no?></td>
                        <td><?=$res_row->remarks?></td>
                        <td><a target='download' href="<?php echo base_url(); ?>index.php/Bhrms/view?doc_id=<?=$res_row->id;?>"><i class="fa fa-paperclip"></i>View document</a></td>
                        <td><button type="buttton" onclick="deleteID(<?=$res_row->id?>)" class="btn btn-sm btn-danger">Delete</button></td>

                    </tr>
                    <?php
}
    }
    ?>
                </tbody>
            </table>
            <?php
}

?>

</div>

<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success ml-2',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    function deleteID(id){
        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to delete this data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });

                $.ajax({
                    url: baseurl + "Bhrms/delete",
                    type: 'POST',
                    data: {'id':id},
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

            }
        })
    }
</script>