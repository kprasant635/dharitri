<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
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
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
</style>
<div class="container">

    <div class="reza-card">
        <div class="reza-body">
            <h5 class="reza-title" style="margin-top: 20px">
                <i class="fa fa-pencil-square-o"></i> VGR/PGR Reservation
            </h5>

            <?php
                $sl_count = 1;
            ?>

            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> View case</span>
                </div>

                <div class="col-md-6">
                    <a target="_blank" href="<?php echo base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case='.$case_no; ?>" ><b>view</b></a>

                </div>
                           
            </div>
            
            <div class="row p-2 mt-2">
                <div class="col-md-6 bg-danger text-white">
                    <span>
                        <strong><?=$sl_count++?>.</strong>
                        Filling of Reservation / De Reservation Proposal
                    </span>
                    <?=form_error('re_dereservation')?>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input
                                class="form-check-input"
                                type="radio"
                                name="re_dereservation"
                                id="reservation_vgr"
                                onclick="vgrReservation('<?=$dist_code?>','<?=$subdiv_code?>','<?=$cir_code?>','<?=$mouza_pargona_code?>','<?=$lot_no?>')"
                                value="RESERVATION"
                        />
                        <label for="inlineRadio1">Reserve area</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="re_dereservation" onclick="dereserve();" value="n">
                        <label for="">Dag not available for reservation</label>
                    </div>
                </div>
            </div>

            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong><?=$sl_count++?>.</strong> Remarks</span>
                </div>

                <div class="col-md-6">
                    <textarea name="remarks_lm_assing_vgr" class="form-control p-2" id="remarks_lm_assing_vgr" rows="5" placeholder="Please enter remark..."></textarea>
                </div>               
            </div>


            <div class="row p-2 justify-content-center">
                <hr>
                <button type="button" onclick="submitVgrReservProp('<?=$case_no?>')" class="btn btn-warning btn-sm col-2">Submit</button>
            </div>



        </div>
    </div>

    <input type="hidden" id="case_no" value="<?=$_GET['case']?>">


    <?php
        include(APPPATH."views/SettlementView/include/reserveDereserveVgrPgr.php");
    ?>


</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
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
    function submitVgrReservProp(case_no)
    {
        var remark = $('#remarks_lm_assing_vgr').val();
        var reservation = $("input[name='re_dereservation']:checked").val();

        if(!reservation)
        {
            alert('Please select reservation details!');
            return false;
        }

        if(remark == '')
        {
            alert('Please enter remarks!');
            return false;
        }

        var postData = {
            'case_no' : case_no,
            'remark' : remark,
            'reservation' : reservation,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementVgr/reSubmitVgrProposal',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    // showSuccessMessage(arr.msg);
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success ml-2',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: arr.msg,
                        icon: 'success',
                        // showCancelButton: true,
                        confirmButtonText: 'Ok',
                        // reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = baseurl+"home/SettlementVgrPgrLm?service=17";
                        }
                    })
                   
                }

            }
        })

        
    }
</script>