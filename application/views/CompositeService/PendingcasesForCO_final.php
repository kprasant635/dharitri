<style>
    :root {
        --loader-size: 50px;
        --dot-size: 6px;
        --loader-bg: #e1e6e2;
        --dot-color: black;
    }

    .loader {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(1, 18, 64, 0.2);
        transition: opacity 0.3s ease-out, top 0.3s step-end;
        z-index: 99;
    }

    .loader.trans {
        transition: opacity 0.5s ease-out, top 0.5s step-start;
        opacity: 1;
        top: 0;
    }

    .loader .loaderview {
        position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        height: auto;
        padding: 10px 40px;
        border-radius: 5px;
        top: 0;
        left: 0;
        z-index: 100;
        flex-flow: column;
        background-color: var(--loader-bg);
    }

    h1 {
        color: var(--dot-color);
        font-size: 1.2em;
        animation: fading 1.5s ease-in-out infinite;
        font-family: "Comfortaa", cursive;
    }

    .Loader-box {
        margin: 20px;
        flex: 0 0 auto;
        height: var(--loader-size);
        width: var(--loader-size);
    }

    .box {
        position: absolute;
        height: var(--loader-size);
        width: var(--loader-size);
        animation: rotating 4s ease-in infinite;
        animation-delay: calc(var(--id) * 0.5s);
    }

    .dot {
        background-color: var(--dot-color);
        height: var(--dot-size);
        width: var(--dot-size);
        border-radius: 100%;
    }

    @keyframes rotating {
        0% {
            opacity: 0;
            transform: rotateZ(0);
        }
        25% {
            opacity: 100%;
            transform: rotateZ(160deg);
        }

        75% {
            opacity: 200%;
            opacity: 100;
        }
        80% {
            transform: rotateZ(300deg);
            opacity: 100;
        }
        100% {
            transform: rotateZ(350deg);
            opacity: 0;
        }
    }

    @keyframes fading {
        0% {
            opacity: 40%;
        }
        50% {
            opacity: 90%;
        }
        100% {
            opacity: 40%;
        }
    }

</style>
<div class="hide loader" id="loader">
    <div class="loaderview">
        <h1>Don't refresh the page until the process is completed...</h1>
        <div class="Loader-box">
            <div class="box" style="--id:1">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:2">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:3">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:4">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:5">
                <div class="dot"></div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Composite Service Cases ( OMUT / OPART )
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-bordered table-striped' id='user_data1'
                               width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label
                                    class="control-label">
                                    Location</label></th>
                            <th class="center"><label
                                    class="control-label">Entry Date</label>
                            </th>
                            <th class="center"><label
                                    class="control-label">View</label>
                            </th>
                            </thead>

                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- property chain modal -->
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>

<script type="text/javascript" language="javascript" >
    $(document).ready(function(){
        var dataTable = $('#user_data1').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"<?php echo base_url() . 'index.php/CompositeService/OmutCoProceedingFinal'; ?>",
                type:"POST",
            },
            "columnDefs":[
                {
                    "orderable":false,
                },
            ],
        });
    });

     // property chain modal

     $('.panel').on('click', '.chainReportC', function(e) {
        e.preventDefault();
        // console.log($(this).attr("case_no"))
        // call modal function
        case_no = $(this).attr("case_no");
        dist_code = $(this).attr("dist_code");
        subdiv_code = $(this).attr("subdiv_code");
        circle_code = $(this).attr("cir_code");
        mouza_code = $(this).attr("mouza_pargona_code");
        lot_no = $(this).attr("lot_no");
        vill_code = $(this).attr("vill_townprt_code");
        propChainModal(case_no, dist_code, subdiv_code, circle_code, mouza_code, lot_no, vill_code);
    });
</script>