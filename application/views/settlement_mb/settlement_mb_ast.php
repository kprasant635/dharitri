<style>

    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
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


    .road-map-main {
        margin: 50px 0 51px;
    }
    .road-map-main .road-map-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 175px;
    }
    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper {
            margin-bottom: 25px;
            height: auto;
            display: block;
        }
    }
    .road-map-main .road-map-wrapper::before {
        content: "";
        width: 100%;
        clear: both;
        display: block;
    }
    .road-map-main .road-map-wrapper::after {
        content: "";
        width: 100%;
        clear: both;
        display: block;
    }
    .road-map-main .road-map-wrapper .road-map-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 25px solid transparent;
        border-top-color: #7a7bd7;
        border-right-color: #7a7bd7;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        transform: rotate(45deg);
    }
    @media (max-width: 992px) {
        .road-map-main .road-map-wrapper .road-map-circle {
            position: unset;
            border: 25px solid #7a7bd7;
        }
    }
    .road-map-main .road-map-wrapper .road-map-circle .road-map-circle-text {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background-color: #eb0d0de0;
        font-size: 20px;
        font-weight: 600;
        line-height: 26px;
        text-transform: capitalize;
        color: #fff;
        box-shadow: 0px 0px 10px 5px #00000021;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        transform: rotate(-45deg);
    }
    .road-map-main .road-map-wrapper .road-map-card {
        width: 35%;
        background: #7a7bd7;
        padding: 20px 20px;
        z-index: 1;
        position: absolute;
        right: 0;
        border-radius: 5px;
    }
    .road-map-main .road-map-wrapper .road-map-card::before {
        content: "";
        width: 25%;
        height: 20px;
        background: #7a7bd7;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: -23%;
        z-index: -1;
    }
    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper .road-map-card {
            width: 100%;
            margin-top: 30px;
            position: unset;
        }
        .road-map-main .road-map-wrapper .road-map-card::before {
            content: "";
            width: 20px;
            height: 30%;
            top: 50%;
            transform: translateX(-50%);
            left: 50%;
        }
    }
    @media (max-width: 425px) {
        .road-map-main .road-map-wrapper .road-map-card {
            top: 45%;
        }
    }
    .road-map-main .road-map-wrapper .road-map-card .card-head {
        font-size: 20px;
        font-weight: 600;
        text-transform: capitalize;
        margin: 0 0 15px;
        color: #fff;
    }
    .road-map-main .road-map-wrapper .road-map-card .card-text {
        color: #fff;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @media (max-width: 1199px) {
        .road-map-main .road-map-wrapper .road-map-card .card-text {
            -webkit-line-clamp: 4;
        }
    }
    .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-circle {
        border-bottom-color: #7a7bd7;
        border-left-color: #7a7bd7;
        border-top-color: transparent;
        border-right-color: transparent;
    }
    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-circle {
            border-color: #7a7bd7;
        }
    }
    .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card {
        left: 0;
    }
    .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card::before {
        right: -23%;
        left: unset;
    }
    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card::before {
            content: "";
            width: 20px;
            height: 30%;
            top: 50%;
            transform: translateX(-50%);
            left: 50%;
        }
    }
    @media (max-width: 425px) {
        .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card::before {
            top: 45%;
        }
    }

</style>

<!--<div class="col-lg-12 col-md-12 col-sm-12" align="right" style="padding: 18px 20px 0px 0px">-->
<!--    <button class="rezaButt buttDanger" id="applicationProcessForCOModalMb2">-->
<!--        <i class="fa fa-arrows" aria-hidden="true"></i>-->
<!--        Application Process Flow-->
<!--    </button>-->
<!--</div>-->

<!-- Modal Application Approve by SDLAC -->
<div class="modal" role="dialog" id="applicationProcessModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <span style="color:red"> Application process flow for AST end</span>
                </h5>
                <i class="fa fa-close fa-2x text-red modalHide" style="cursor:pointer;"></i>
            </div>
            <div class="modal-body" align="">
                <div class="modal-body" align="center">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="road-map-main">
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 1
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">First Proceeding</h4>
                                        <p class="card-text">
                                            Check & verify LM report
                                            <br>
                                            if all ok then Generate general notice
                                            <br>
                                            if not then Revert back to LM
                                        </p>
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 2
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Second Proceeding</h4>
                                        <p class="card-text">
                                            After Generate general notice, Case forwarded to DC for NR
                                        </p>
                                    </div>
                                </div>

                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 3
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">NR to Settlement</h4>
                                        <p class="card-text">
                                            Check case proceedings, if DC approved as NR then forward the case to ADC/SDO for settlement
                                        </p>
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 4
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Payment Notice After approval from Department/DC</h4>
                                        <p class="card-text">
                                            Check & generate payment notice
                                        </p>
                                    </div>
                                </div>

                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 5
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Payment Notice Confirmation</h4>
                                        <p class="card-text">
                                            Check payment status if applicant paid the amount then update the Chitha Records
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 6
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Re-Report By LM/SK</h4>
                                        <p class="card-text">
                                            Check & verify LM re-report cases
                                            <br>
                                            if all ok then forward to ADC/SDO
                                            <br>
                                            if not then Revert back to LM
                                        </p>
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 7
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Reverted by DC/ADC</h4>
                                        <p class="card-text">
                                            Check reverted cases from DC/ADC/SDO

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" id="approveRemarksSDLAC" required minlength="1" readonly>
                <input type="hidden" id="minutesProposalId" required  readonly>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modalHide">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<div class="row p-4" style='margin-top:40px'>
    <div class="col-md-12">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                        <?php
                        if($_GET['service'] == '13'){
                            echo "SETTLEMENT TENANT";
                        }elseif($_GET['service'] == '14'){
                            echo "SETTLEMENT AP TRANSFER";
                        }elseif($_GET['service'] == '15'){
                            echo "SETTLEMENT TRIBAL COMMUNITY";
                        }elseif($_GET['service'] == '16'){
                            echo "SETTLEMENT KHAS LAND";
                        }elseif($_GET['service'] == '17'){
                            echo "SETTLEMENT PGR VGR LAND";
                        }elseif($_GET['service'] == '18'){
                            echo "SETTLEMENT SPECIAL CULTIVATORS";
                        }

                        //echo $this->lang->line('settlement_tenant')

                        ?>
                    </p>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-hover">
                    <?php if($_GET['service'] == '14')
                    {
                        if($user_desig_code == 'AST') {?>
                            <tr class="">
                                <td>AP cases pending for notice print</td>

                                <td><?php
                                    if ($apconotice != '0') {

                                        echo "<span class=\"badge badge-danger\">$apconotice</span>";
                                    }
                                    ?>
                                </td>
                                <td>

                                    <a href="<?php echo base_url() ?>index.php/SettlementAst/apNoticeGenertaedCases?service=14&s=V" style="float:right">view</a>
                                </td>
                            </tr>
                            <tr class="">
                                <td>AP notice printed cases</td>

                                <td><?php
                                    if ($apconotice_generated != '0') {

                                        echo "<span class=\"badge badge-danger\">$apconotice_generated</span>";
                                    }
                                    ?>
                                </td>
                                <td>

                                    <a href="<?php echo base_url() . 'index.php/SettlementMbCo/apNoticeGenertaedCases?service='.$service_code.'&s=v'; ?>" style="float:right">view</a>
                                </td>
                            </tr>
                        <?php  }?>
                    <?php  }?>

                    <tr class="">
                        <td>View prastavit pattan patra</td>

                        <td>
                            <?php if ($ppp != '0')
                            {
                                echo "<span class=\"badge badge-danger\">$ppp</span>";
                            }
                            ?>
                        </td>
                        <td>

                            <a href="<?php echo base_url() . 'index.php/SettlementMbCo/viewListPrastavitPattanPatra/?service='.$service_code.'&s=v'; ?>" style="float:right">view</a>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


    // application process flow





    $(document).on('click','#applicationProcessForCOModalMb2',function ()
    {
        $('#applicationProcessModal').modal('show');
    });
    $(document).on('click','.modalHide',function ()
    {
        $('#applicationProcessModal').modal('hide');
    });




</script>