<style>
    .card-content{
        background-color: #FFF;
    }
    .enc-area-color{
        background: #FDEBEA!important;
    }
    .settlement-area-color{
        background: #EAFFEA!important;
    }
    .final-area-color{
        background: #cfb5b5!important;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }
</style>
<?php 
if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
else{
    $lessa_chatak='Lessa';
}
?>
<h5 class="bg-info p-2 text-white shadow">Registration information for case: (<span class="bg-warning"><?=$_GET['case'];?>,<?=$applid;?></span> )</h5>
  <div class="card-content shadow-sm">
    <div class="card-body">
      <?php
        if ($this->session->flashdata('message')): ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
        <strong><?php echo $this->session->flashdata('message');?></strong>
      </div>
      <?php endif; ?>


      <div class="card-text mt-2 co-report">
        <form
          method="post"
          action="<?php echo base_url()?>index.php/SettlementInstitutionCo/saveRegistrationData"
          id="formNotice" enctype="multipart/form-data">
          <input type="hidden" name="ins_cat_type" value="<?=$instituteDetails->ins_cat_type_co;?>">
            <?php if($instituteDetails->ins_cat_type_co == 12 && empty($registration_document) && ($apLmnoteDetails->co_operative_registered ==null ||  $apLmnoteDetails->co_operative_registered == 'N') && $apLmnoteDetails->registration_no == null){?>
                <h5 style="color:#ff681d">Note : Registration information not submitted !!!</h5>
                <?php }else{ ?>
                <h5 style="color:green">Note : Registration information already submitted, now proceed for chitha update <i class="fa fa-check-square-o"></i></h5>
            <?php }?>
            
            <div class="row">
           

                <div class="row">
                    <div class="form-group col-md-6 ">
                        Whether the entity/organization/institution etc is registered under the Societies Registration Act,1860 or under the Assam Cooperative Societies Act,2007(as amended) or under relevant Central or State government Act/Law:
                    </div>
                    <div class="form-group col-md-6">
                        <select name="co_operative_registered" id="co_operative_registered" class="form-select">
                           <?php 
                            if(trim($apLmnoteDetails->co_operative_registered) == 'N')
                            {
                               echo '<option value="N">No</option><option value="Y">Yes</option>';
                            }else
                            {
                                echo '<option value="Y">Yes</option><option value="N">No</option>';
                            } ?>

                        </select>
                    </div>
                </div>

                <div class="row registration_no_details">
                    <div class="form-group col-md-6 ">
                        <span style="color:red">Registration No.  *</span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" autocomplete="off" class="form-control" id="registration_no" placeholder="" name="registration_no" value="<?php if(isset($err_return)){ echo set_value('registration_no');}else{ echo $apLmnoteDetails->registration_no;}?>" required="" style="margin-left: 20px;">
                    </div>

                    <div class="form-group col-md-6 ">
                          <span style="color:red">Registration Date. *</span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" autocomplete="off" class="form-control" id="registration_date" placeholder="" name="registration_date" value="<?php if(isset($err_return)){ echo set_value('registration_date');}else{ echo $apLmnoteDetails->registration_date;}?>" required="" style="margin-left: 20px;">
                    </div>
                </div>
                
                <?php if(!empty($registration_document)){ ?>
                    <div class="form-group col-md-6 ">
                          <span style="color:red">Registration Document. *</span>
                    </div>
                    <div class="form-group col-md-6">
                           <a target='download' href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$registration_document->id?>"><i class="fa fa-paperclip"></i> <?=$registration_document->file_name;?> <span style="color:red">(Submitted)</span>
                   
                            </a>
                        
                    </div>
                
                <?php } ?>
                    
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="inputEmail4" style="color:red;">Registration Document *</label>
                    </div>
                    <div class="col-8">
                        <input
                                class="form-control <?php if(form_error('registration_document')){echo 'lm_invalid';}?>"
                                type="file"
                                name="registration_document"
                                id="registration_document"
                                accept=".png, .jpg, .jpeg, .pdf"
                        />
                    </div>
                </div>
            </div>


     
            </div>
            <hr style="margin-top: 0;">


                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <label for="inputEmail4"><strong>Remarks(if any)</strong></label>
                    </div>
                    <div class="col-md-6">
                    <textarea
                        placeholder="Remarks  ..."
                        name="remark_co"
                        class="form-control"
                        id="remark_co"
                        cols="30"
                        rows="3"
                    required></textarea>
                    <input type="hidden" name="case_no" id="case_no_re_cal" value="<?=$_GET['case']?>" />
                    </div>
                </div>

                <div class="row mt-4 justify-content-center">
                    <button 
                        type="submit"
                        name="registration_document_submit"
                        type="button"
                        class="m-3 col-2 text-white btn btn-danger btn-sm"
                        id="btnNotice">
                        Save registration info
                    </button>
                 
                
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>



<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type='text/javascript'>

    $(function () {
        $('#registration_date').datepick({dateFormat: 'dd-mm-yyyy'});
    });
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
  //   $(document).ready(function() {
  //     $("form").submit(function(e){
  //       showErrorMessage('This features will be made available soon !!!');
  //         e.preventDefault(e);
  //     });
  // });


  $('#btnNotice').on('click',function(e){
        e.preventDefault();
        var form = $('#formNotice');
        var encData ='';
        var encDataAll =[];

        <?php
        if($premium_data == true)
        {
        foreach($premium_data as $prem){
        ?>
        // $(".clspremdata").each(function () {
            encData += 'Dag No:' + <?=$prem->dag_no?> + "<br> Purpose of Land : "+$( "#premLand<?=$prem->dag_no?>" ).val()+" <hr>";


        // });
        // alert( encData );
        // encDataAll.push(encData);

        <?php } } ?>


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {
                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                    $('#btnNotice').prop('disabled', false);
                    $('#btnNotice').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnNotice').prop('disabled', false);
                $('#btnNotice').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnNotice').prop('disabled', false);
            $('#btnNotice').val('Save and submit');
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                // 'error'
            )
        }
    })
    });
</script>
<?php include(APPPATH."views/Juridical/editAreaJuridicalPn.php"); ?>

<script>
    // function reCalculatePremiumWithOutConcession(case_no, is_concession)
    // {
    //     if(!confirm("Are you sure you want to recalculate premium without concession?"))
    //     {
    //         return false;
    //     }
    //     // $("#overlay").fadeIn(300);
    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });

    //     $.ajax({
    //         url: baseurl + "SettlementCommon/premiumReCalculateCaste",
    //         type: 'POST',
    //         data: {'case_no':case_no, 'is_concession':is_concession},
    //         success: function (data) {
    //             $.unblockUI();
                
    //             arr = JSON.parse(data);

    //             if(arr.responseType != 2)
    //             {
    //                 showErrorMessage(arr.msg);
    //                 return false;
    //             }
    //             else
    //             {
    //                 Swal.fire({
    //                     text: arr.msg,
    //                     icon: 'success',
    //                     confirmButtonText: 'OK',
    //                     customClass: {
    //                         actions: 'my-actions',
    //                         confirmButton: 'order-2',
    //                     }
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         window.location.reload();
    //                     }
    //                     else
    //                     {
    //                         window.location.reload();
    //                     }
    //                 })
    //             }

    //         },
    //         error: function (error) {
    //             console.log(error);
    //             $.unblockUI();
    //             alert("Something went wrong");
    //         }

    //     })
    // }
</script>
<script>
function showModal(val) {
    if(val == 'YES')
    {
        $('#infoModal').modal('show');
        document.getElementById('infoModalLabel').innerText = title;
        document.getElementById('modalContent').innerText = content;
        // var areaModal = document.getElementById("infoModal");
        // areaModal.style.display = "block";
    }
    else
    {
        $('#infoModal').modal('hide');
    }

}
</script>

<script>
$('#recalculate').on('click',function(e){
    alert('Failed to fetch old premium!!!');
    return false;
    if(!confirm("Are you sure you want to recalculate the premium? The recalculated amount may differ from the existing premium !!!"))
    {
        return false;
    }
    var case_no_re_cal = $('#case_no_re_cal').val();
    var reason_for_recalculate  = $('#reason_for_recalculate').val();
    if(!reason_for_recalculate)
    {
        alert('Please specify the reason !');
        return false;
    }
    // $("#overlay").fadeIn(300);
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl + "SettlementInstitutionCo/premiumReCalculateForApproveCases",
        type: 'POST',
        data: {'case_no':case_no_re_cal,'reason_for_recalculate' : reason_for_recalculate},
        success: function (data) {
            $('#infoModal').modal('hide');
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2)
            {
                showErrorMessage(arr.msg);
                return false;
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
                        window.location.reload();
                    }
                    else
                    {
                        window.location.reload();
                    }
                })
            }

        },
        error: function (error) {
            $('#infoModal').modal('hide');
            console.log(error);
            $.unblockUI();
            alert("Something went wrong");
        }

    })
});
</script>
