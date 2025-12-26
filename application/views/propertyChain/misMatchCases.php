<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <b>
                        <h1 style="text-align: center;">
                            Property Chain and Chitha Data Mismatch Cases (<?= $mutation_name ?>)
                        </h1>
                    </b>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <!-- <?php echo $this->lang->line('mismatch_cases'); ?> -->
                            Mismatch Cases
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered' id='cases' width="100%">
                            <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            </thead>
                            <?php foreach ($mismatchCases as $case) : ?>
                                <tr>
                                    <td><?php echo $case->case_no; ?><br>
                                    </td>
                                    <td class="center">
                                        <?php //echo ($case->mut_type == 01) ? 'Mutation' : 'Partition'; 
                                        ?>
                                        <?php
                                        echo "Mouza : " . $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                        echo "<br>Lot : " . $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                        echo "<br>Village : " . $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td class="center">
                                        <p class='text-success'> <i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->date_entry)); ?></p>
                                    </td>
                                    <td>
                                        <br>
                                        <a href="<?php echo base_url() . "index.php/PropChainReport/viewMismatchCase?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='viewMismatch btn-sm btn btn-primary '>
                                            <!-- <?php echo $this->lang->line('lm_report'); ?> -->
                                            <i class="fa fa-eye"></i> View Case
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
    <div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
        <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
            <div class="modal-content" style=" overflow-y: auto;">

            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        $('.panel').on('click', '.skreport', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function(data) {
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });

        });


        $('.panel').on('click', '.lmreportpart', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function(data) {
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });

        });

        // property chain modal

        $('.panel').on('click', '.chainReport', function(e) {
            e.preventDefault();
            // console.log($(this).attr("case_no"))
            case_no = $(this).attr("case_no");
            dist_code = $(this).attr("dist_code");
            subdiv_code = $(this).attr("subdiv_code");
            circle_code = $(this).attr("cir_code");
            mouza_code = $(this).attr("mouza_pargona_code");
            lot_no = $(this).attr("lot_no");
            vill_code = $(this).attr("vill_townprt_code");
            $('#myModal .modal-content').empty().html(
                '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div><br><p class="text-primary text-center">....Fetching Data From Property Chain. Please Wait....</p>');
            $.ajax({
                url: baseurl + "PropChainReport/getCaseData",
                data: {
                    case_no: $(this).attr("case_no"),
                    vill_code: $(this).attr("vill_townprt_code"),
                },
                type: 'post',
                success: function(data1) {
                    console.log(data1)
                    var obj = JSON.parse(data1)
                    var dag_no = obj.dag_no;
                    var patta_code = obj.patta_no;
                    $.ajax({
                        url: baseurl + "PropChainReport/getPropChainData",
                        type: 'post',
                        data: {
                            case_no: case_no,
                            dist_code: dist_code,
                            subdiv_code: subdiv_code,
                            circle_code: circle_code,
                            mouza_code: mouza_code,
                            // mouza_code: '02',
                            lot_no: lot_no,
                            // lot_no: '01',
                            vill_code: vill_code,
                            // vill_code: '10004',
                            patta_code: patta_code,
                            // patta_code: '0201',
                            dag_no: dag_no,
                            // dag_no: '1',
                        },
                        success: function(data2) {
                            var object = JSON.parse(data2);
                            console.log(object);
                            if (object.result === 0) {
                                console.log('abc');
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center">' + object.error_msg + '</h1>');
                                $('#myModal').modal();
                            } else if (object.result === 1) {
                                var property_data = object.property_data
                                var transaction_data = object.transaction_data

                                console.log(property_data);
                                $.ajax({
                                    url: baseurl + "PropChainReport/generatePropertyChain",
                                    method: 'post',
                                    data: {
                                        property_data: property_data,
                                        transaction_data: transaction_data
                                    },
                                    dataType: 'html',
                                    success: function(data3) {
                                        $('#myModal .modal-content').html(data3);
                                        $('#myModal').modal();
                                    }
                                });
                            }

                        }
                    });
                }
            })
        });

        $('#myModal').on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
        })
    });
</script>