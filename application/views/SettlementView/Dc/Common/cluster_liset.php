<style>
        /* modal css */
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 70%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<!-- <style>
    .modal-vgr-test {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content-vgr-test {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 70%;
    }
</style> -->


<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
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
    .rezaButt{
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
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }
    #cases_wrapper {
         margin-top: 0px !important;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

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


        <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">

            <a href="// $_SERVER['HTTP_REFERER']?>">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>

        </div> -->


        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                        <span>Circle Cluster list</span>
                    </div>
                </div>

                <hr>

            </div>

            <div class="reza-body" >

                <?php if ($clusterListCount == 0) : ?>
                    <div class="rezaText">No Circle Cluster list found!</div>
                <?php else : ?>
                <form id="sdlac_member_update">
                    <table class='table table-striped' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">SL No.</th>
                            <th class="text-center">Circle Name</th>
                            <th class="text-center">Processed</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $j = 1; foreach ($clusterList as $cls):   ?>
                            <tr>
                                <td class="text-center"><?php echo $j; ?>
                                <input type="hidden" name="cluster_id" id="cluster_id" value="<?=$cls->cluster_id?>"> </td>
                                <td class="text-center"><?php echo $cls->cir_name; ?></td>
                                <td class="text-center"><?=$cls->clusterCaseCount.'/'.$cls->total_pending?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success " onclick="viewClusterCases('<?=$cls->cluster_id?>')">
                                        <i class="fa fa-eye"></i> view
                                    </button>
                                    <button type="button" onclick="recomentForSdlac('<?=$cls->cluster_id?>')" class="btn btn-primary ">
                                        <i class="fa fa-check-square-o"></i> Recommend this cluster for SDLAC
                                    </button>
                                </td>
                            </tr>
                        <?php $j++; endforeach; ?>
                        </tbody>

                    </table>
                </form>
                    
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>


<div id="caseModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
      <div class="row text-right">
         <span class="close px-4">&times;</span>
      </div>
      <p>
      <div class="container px-5" id="rel_id">
     
      </div>
      </p>
   </div>
</div>


<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    function viewClusterCases(cluster_id)
    {
        var modal = document.getElementById("caseModal");
        var span_close = document.getElementsByClassName("close")[0];

        span_close.onclick = function() {
            modal.style.display = "none";
            // table.destroy();
        }
    
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                // table.destroy();
            }
        }

        var postData = {
            'cluster_id' : cluster_id,
        };
    
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementCommonDc/viewClusterCases',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2){
                    showErrorMessage(arr.msg);
                }
                else
                {
                    modal.style.display = "block";

                    var thead = "<tr>"+
                                    "<th>Sl No</th>"+
                                    "<th>Case no</th>"+
                                    "<th>Case status</th>"+
                                    "<th>Pending at</th>"+
                                    "<th>Action</th>"+
                                "</tr>";

                    var tbody = '';

                    var sl_no = 1;
                    for(i=0; i<arr.content.length; i++)
                    {
                        if(arr.content[i].status == 'AE')
                        {
                            var re_generate_gn = "<button type=\"button\" onclick=\"generateNotice('"+arr.content[i].case_no+"')\" id=\"generateNotice\" class=\"m-1 btn btn-sm btn-danger\">Re-Generate De-Reservation Notice</button>";


                            var print_gn = '<a target="_blank" href="<?php echo base_url(); ?>index.php/SettlementVgrPgrADC/printNotice?case_no='+arr.content[i].case_no+'" class="btn btn-info btn-sm m-1"><i class="fa fa-check-square-o" aria-hidden="true"></i>Print De-Reservation Notice</a>';

                            var case_status = '<span class="alert-success">In circle cluster<span>';
                            var revert_to_co = "<button type=\"button\" onclick=\"revertModal('"+arr.content[i].case_no+"')\" class=\"btn btn-warning btn-sm\">Revert to CO</button>";


                            var print_reservation_notice = '<a target="_blank" href="<?php echo base_url(); ?>index.php/SettlementVgrPgrADC/printNoticeReservation?case_no='+arr.content[i].case_no+'" class="btn btn-sm btn-info m-1"><i class="fa fa-check-square-o" aria-hidden="true"></i>Print Reservation Notice</a>';

                            var re_generate_reservation_notice = "<button class=\"btn btn-sm btn-danger m-1\" onclick=\"generateNoticeReservation('"+arr.content[i].case_no+"')\" id=\"generateNoticeReservation\"><i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Re-Generate Reservation Notice</button>";
                        }
                        else if(arr.content[i].status == 'D')
                        {
                            var case_status = '<span class="alert-warning">Case Rejected.</span>';
                            var revert_to_co = "Already Rejected";
                            var re_generate_gn = '';
                            var print_gn = '';
                            var re_generate_reservation_notice = '';
                            var print_reservation_notice = '';

                        }
                        else
                        {
                            var case_status = '<span class="alert-danger">Case Reverted.</span>';
                            var revert_to_co = "Already Reverted";
                            var re_generate_gn = '';
                            var print_gn = '';
                            var re_generate_reservation_notice = '';
                            var print_reservation_notice = '';

                        }

                        var view_app = '<a target="'+arr.content[i].case_no+'" href="'+baseurl+'SettlementCommonDc/viewApplicationDetailsOnly?case='+arr.content[i].case_no+'" class="m-1 btn btn-sm btn-success">view application</a>';

                      

                        tbody += "<tr>"+
                                    "<td>"+ sl_no++ +"</td>"+
                                    "<td><b>"+arr.content[i].case_no+"</b></td>"+
                                    "<td>"+case_status+"</td>"+
                                    "<td>"+arr.content[i].pending_officer+"</td>"+
                                    "<td>"+print_gn+re_generate_gn+print_reservation_notice+ re_generate_reservation_notice+ view_app+ revert_to_co +"</td>"+
                                "</tr>";
                    }

                    $('#rel_id').html("<h5 class='text-center'>Circle Cluster list</h5><table class='table table-bordered'>"+thead+tbody+"</table>");

                }
            }
        });
    }
</script>

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

    function revertModal(case_no)
    {
        var modal = document.getElementById("caseModal");
        var span_close = document.getElementsByClassName("close")[0];
        modal.style.display = "block";


        span_close.onclick = function() {
            modal.style.display = "none";
            // table.destroy();
        }
    
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                // table.destroy();
            }
        }

        var body = "<div class='container text-center'><label>Please enter remark</label>"+
                    "<textarea rows='5' id='remark' class='form-control p-2' placeholder='Please enter remark...'></textarea><br>"+
                    "<button type=\"button\" onclick=\"revert('"+case_no+"')\" class=\"btn btn-sm btn-danger\">Revet</button></div>";

        $('#rel_id').html(body);

    }

    function revert(case_no)
    {
        var remark = $('#remark').val();

        if(remark == '')
        {
            alert('Please enter remark...');
            return false;
        }

        var postData = {
            'case_no': case_no,
            'pending_officer': 'CO',
            'pending_office': 'CO',
            // 'from_office': 'ADC',
            'status': 'R',
            'remark_type': null,
            'remark': remark,
            'task': 'Reverted to CO.',
        };
    
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementCommon/revertCase',
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
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //    window.location.reload();
                            window.location.href = baseurl+"SettlementCommonDc/clusterList";
                        
                        }
                    })
                    
                }
            }
        })
    }
</script>

<script>
    function recomentForSdlac(cluster_id)
    {

        var user_desig_code = '<?php echo $this->session->userdata('user_desig_code');?>';

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to recommend this cluster to SDLAC',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ok',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                var postData = {
                    'cluster_id': cluster_id,
                };
            
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            
                $.ajax({
                    url: baseurl+'SettlementVgrPgrADC/forwardSdlac',
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
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    
                                    //    window.location.reload();
                                    if(user_desig_code == 'ADC')
                                    {
                                        window.location.href = baseurl+"SettlementVgrPgrADC/SettlementVgrPgrLandDc";
                                    }
                                    else
                                    {
                                        window.location.href = baseurl+"SettlementVgrPgrSdo/SettlementVgrPgrLandSdo";
                                    }
                                
                                }
                            })
                            
                        }
                    }
                })
            }
        })



       
    }
</script>

<?php include(APPPATH."views/SettlementView/Dc/VgrPgr/re_generate_notice.php"); ?>


