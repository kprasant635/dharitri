<style>
    .checkBoxD{
        width: 20px;
        height: 20px;
    }
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
    .buttInfo {
        color: #FFF;
        background-color: #4CAF50;
    }
    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
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


</style>

<div class="row"  style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <h5 class="alert-warning text-center"><?=$this->session->flashdata('message')?></h5>
                    <div class="col-md-6">
                        <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>

                    </div>
                    <div class="col-md-6 text-right">
                        <?php if(isset($ind_list)): foreach ($ind_list as $case) : 
                            
                            if($case->status == MB_ORDER_FOR_CHITHA_UPDATE)
                            {
                                ?>
                                <span class="alert-success"><strong>Cases forwarded to CO...</strong></span>
                                <?php
                            }
                            else
                            {
                                ?>
                                <button type="button" onclick="cofirmPaymentForward();" class="btn btn-sm btn-primary">Confirm payment and Forward to CO for Chitha update</button>
                                <?php
                            }
                            ?>
                        <?php break; endforeach; endif;?>
                      
                    </div>
                </div>
                <hr>
                <span>Confirm payement/Forward to CO</span>
            </div>
            <?php if ($this->session->flashdata('message')) : ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
            <?php endif; ?>

            <div class="reza-body">
                <?php if ($this->session->userdata('message')) : ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>
                            <?php
                            // echo $this->session->userdata('message');
                            // $this->session->unset_userdata('message');
                            ?>
                    </div>
                <?php endif; ?>
                <?php //echo form_open(base_url("index.php/ZoneInformationController/approveZonalInformationCO"), array('method' => 'post')); ?>

                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable' width="100%">
                    <thead>
                        <tr>
                            <th>All <br> <input  type="checkbox" class="checkBoxD" value="all" id="checkedAll" > </th>
                            <th>Excel Report No</th>
                            <th class="center">Excel Created at</th>
                            <!-- <th class="center"><?php echo $this->lang->line('action'); ?></th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($ind_list)): foreach ($ind_list as $case) : ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkBoxD selectMark" name="checked_case_no[]" value="<?=$case->case_no?>">
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php/SettlementTenantDc/getSettlementApApplicationDetails?case=<?php echo $case->case_no; ?>">
                                    <?php echo $case->case_no; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?php echo $case->date_created; ?>
                            </td>
                            <!-- <td class="text-center">
                                <?php
                                if(trim($case->status) == 'F')
                                {
                                    ?>
                                    <a href="#" class='lmreportmut rezaButt buttPrimary'>
                                       Payment Confirmed and forwarded to CO
                                    </a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo base_url() . 'index.php/SettlementMbCo/coFinalOrderUpdate?case_no='.$case->case_no.'&dist_code='.$dist_code.'&subdiv_code='.$subdiv_code.'&cir_code='.$cir_code; ?>" class='lmreportmut rezaButt '>
                                        Confirm payment and Forward to CO for Chitha update
                                    </a>
                                    <?php
                                }
                                ?>
                            </td> -->
                        </tr>
                    <?php endforeach; endif;?>
                    </tbody>
                </table>
                <?php //echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
<script>
    $("#checkedAll").click(function(){  
        if(this.checked){
            $('.selectMark').each(function(){
                this.checked = true;
                $('.selectMark').prop('checked', true);
            })
        }else{
            $('.selectMark').each(function(){
                this.checked = false;
                $('.selectMark').prop('checked', false);
            })
        }
    });
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

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showCancelButton: true
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
    function cofirmPaymentForward()
    {
        var selectedList = [];

        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        Swal.fire({
            text: 'Are you sure you want to confirm payment and forward to CO',
            icon: 'warning',
            confirmButtonText: 'CONFIRM',
            showCancelButton: true,
            customClass: {
                actions: 'my-actions',
                confirmButton: 'order-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('<form action="'+baseurl+'SettlementTenantDc/confirmPaymentForwardToCo" method="POST"/>')
                    .append($('<input type="hidden" name="selectedData">').val(JSON.stringify(selectedList)))
                    .appendTo($(document.body)) //it has to be added somewhere into the <body>
                    .submit();

                // setTimeout(function() {
                //     location.reload();
                // }, 1000);
            }
        })
    }
</script>