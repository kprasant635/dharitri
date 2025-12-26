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

<div class="col-md-12 text-right text-cyan">
    Process > Settlement MB3 > <b>Reclass suite</b>
</div>
<div class="row p-4" style='margin-top:40px'>
    <div class="col-md-12">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                        <?php
                            if($_GET['service'] == RECLASS_ID){
                                echo RECLASS_SERVICE_NAME;
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-hover">
                
                    <?php if($user_desig_code == 'CO') { ?>
                        <tr>
                            <td>First Proceeding</td>    
                            <td>
                                <?php if($service_code == RECLASS_ID) { ?>
                                    <span class="badge badge-danger"><?=$first?></span>
                                <?php } ?>
                            </td>                            
                            <td>
                                <a href="<?php echo base_url() . 'index.php/ReclassSuiteControllerCO/FirstProceedingReclass?service='.$service_code.'&s='.MB_PENDING; ?>" style="float:right">VIEW</a>
                            </td>
                        </tr>

                        <tr>
                            <td>Re-Report By LRA/LRS</td>    
                            <td>
                                <?php if($service_code == RECLASS_ID) { ?>
                                    <span class="badge badge-danger"><?=$re_report_lm?></span>
                                <?php } ?>
                            </td>                  
                            <td>
                                <a href="<?php echo base_url() . 'index.php/ReclassSuiteControllerCO/coReSubmitLmCases?service='.$service_code.'&s='.MB_RE_REPORT; ?>" style="float:right">view</a>
                            </td>
                        </tr>

                         <tr>
                            <td>Pending Partition List(Notice Served by AST)</td>    
                            <td>
                                <?php if($service_code == RECLASS_ID) { ?>
                                    <span class="badge badge-danger"><?=$notice_report_ast?></span>
                                <?php } ?>
                            </td>                  
                            <td>
                                <a href="<?php echo base_url() . 'index.php/ReclassSuiteControllerCO/astNoticeGivenReclass?service='.$service_code.'&s='.MB_AST_REPORT; ?>" style="float:right">view</a>
                            </td>
                        </tr>
                    <?php } ?>

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

    var span = document.getElementsByClassName("close")[0];
    var apModal = document.getElementById("apModal");
    function apNoticeModal(){

        apModal.style.display = "block";

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            apModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == apModal) {
                apModal.style.display = "none";
            }
        }

    }
    $(document).on('click','.closeAp',function ()
    {
        apModal.style.display = "none";
    });

    <?php
    if($_GET['service'] == '14'){ ?>

    $(window).load(function(){        
        apNoticeModal();
    }); 
    <?php } ?>




</script>