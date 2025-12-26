<link href="<?= base_url().'css/bootstrap.min.css'?>">
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif"></div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<script>
    document.onreadystatechange = function(e)
    {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    };
    window.onload = function(){
        $.unblockUI();
    }
</script>

<div class="row">
    <nav aria-label="breadcrumb">
       
    </nav>
</div>


<div class="container">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 offset-2">
            <?php echo $this->session->flashdata('alert_msg');?>
            <div class="bg-white shadow-lg rounded p-2 card-info">
                <?php echo form_open(base_url("index.php/cabinetController/cabinetDetailsFormSave"), array('method' => 'post')); ?>
                <div class="card-header text-danger text-bold">
                    <h6>Minister Visit Details</h6>
                </div>
                <div class="card-body"> 
                    
                    <div class="row pt-2">
                        <div class="col-sm-4">
                            <label class="mb-0 mt-1 font-weight-normal">Date of  Visit:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control " 
                            value="<?=$this->input->post('cdate')?>" 
                                   name="cdate" id="popupDatepicker" autocomplete="off">
                            <span class="text-danger"><?=form_error('cdate')?></span>
                        </div>
                    </div>

                    
                    
                    <div class="row pt-2">
                        <div class="col-sm-4">
                            <label class="mb-0 mt-1 font-weight-normal">No of Cases Reviewed :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" value="<?=$this->input->post('review_case')?>" placeholder="Enter No of Cases Reviewed"
                                   name="review_case" id="review_case" maxlength="10" min="0" autocomplete="off">
                            <span class="text-danger"><?=form_error('review_case')?></span>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-sm-4">
                            <label class="mb-0 mt-1 font-weight-normal">No of Cases Found Genuine :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" value="<?=$this->input->post('genuine_case')?>" placeholder="Enter No of Cases Found Genuine"
                                   name="genuine_case" id="genuine_case" maxlength="10" min="0" autocomplete="off" >
                            <span class="text-danger"><?=form_error('genuine_case')?></span>
                        </div>
                    </div>


                    <div class="row pt-2">
                        <div class="col-sm-4">
                            <label class="mb-0 mt-1 font-weight-normal">No of Cases where further information sought :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" value="<?=$this->input->post('sought_case')?>" placeholder="Enter No of Cases where further information sought"
                                   name="sought_case" id="sought_case" maxlength="10" min="0" autocomplete="off" >
                            <span class="text-danger"><?=form_error('sought_case')?></span>
                        </div>
                    </div>

                    
        
                </div>
                <div class="card-footer text-center">
                    <button type="submit" id="update_user" 
                    class="btn btn-success"><i class="fa fa-check"></i>Update Details</button>
                </div>
                <?=form_close()?>
            </div>
        </div>


        <hr class="mt-3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <div class="bg-white shadow-lg rounded p-2 card-info">
                <div class="card-header text-danger text-bold">
                    <span>List of Minister Visit Details</span>
                    <?php
                        $link = base_url() . "index.php/cabinetController/downloadMinisterVisitReport";
                        ?>
                    <a class="btn btn-primary" href="<?php echo $link; ?>"><i class="fa fa-download"></i> Download Visit Details Report</a>
                </div>
                <div class=""> 
                    <table class="table" id='datatable'>
                        <thead>
                            <tr>
                                <th>Sl no.</th>
                                <th>Visit Date</th>
                                <th>Review Case</th>
                                <th>Genuine Case</th>
                                <th>Information Sought Case</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($cabinet_list as $key => $value) { ?>
                            
                                <tr>
                                    <td class="text-center"><?=$count++;?></td>
                                    <?php if($value->visit_date == NULL) : ?>
                                    <td class="text-center text-danger">Not Available</td>
                                    <?php else: ?>
                                    <td class="text-center"><i class='fa fa-calendar'></i> <?=date('d-M-Y',strtotime($value->visit_date)) ;?></td>
                                    <?php endif; ?>
                                    <td class="text-center"><span class="text-primary"><?=$value->review_case;?></span></td>
                                    <td class="text-center"><span class="text-success"><?=$value->genuine_case;?></span></td>
                                    <td class="text-center"><span class="text-danger"><?=$value->sought_case;?></span></td>

                                    <td><button type="button" id="deleteDetils" onclick="deleteMinisterDetails(<?=$value->id;?>)"  class="btn btn-sm btn-danger confirm-reject">Delete <i class='fa fa-trash'></i></button></td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
    
    $(document).ready(function() {
        $('#datatable').DataTable({
            
            "pageLength": 50,
            // "order": [1, "asc"],
            "autoWidth": false,
            "deferRender": true,
        });
    });


 // Success Message
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });
        location.reload();
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
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }



    function deleteMinisterDetails(id) {

        Swal.fire({
            title: 'Are you sure?',

            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/cabinetController/deleteCabinetDetails/" ?>' + id ,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                    if (data.responseType == 1) {
                        showErrorMessage(data.message);
                    } else if (data.responseType == 2) {
                        showSuccessMessage(data.message);
                        // location.reload();
                    } else if (data.responseType == 3) {
                        showWarningMessage(data.message);
                    } else {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }
</script>