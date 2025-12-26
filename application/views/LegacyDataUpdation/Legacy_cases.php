<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <?php if(ESCALATION_ENABLE==1){ ?>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <?php } else { ?>
                <div class="col-lg-10 col-lg-offset-1">
            <?php } ?>
            
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                            $user_code = $this->session->userdata('user_desig_code');
                            //if($user_code == 'CO'){
                                echo 'Pending Cases For Legacy Data modification / Updation';
                            //}
                            // if ($process == '1') {
                            //     echo 'Pending Cases For Legacy Data modification / Updation';
                            // } elseif ($process == '2') {
                            //     echo 'Pending Cases For Legacy Data modification / Updation';
                            // }
                        ?>
                    </h2>
                </div>
            </div>

            <?php if(ESCALATION_ENABLE==1){ ?>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <?php } else { ?>
                <div class="col-lg-10 col-lg-offset-1">
            <?php } ?>

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <form method="post">
                            <div class="input-group">
                                <input type="text" name="searchKeyword" class="form-control col-sm-6 pull-right" placeholder="Search by keyword..." value="<?php echo @$searchKeyword; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                            </div>
                        </form>


                        <?php
                        //if ($process == '1') {
                        if($user_code == 'CO'){
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='casess' width="100%">
                                <thead>

                                    <!-- <?php //if(ESCALATION_ENABLE==1){ include(APPPATH."views/common/esc_table_head.php");} ?> -->

                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                    <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?> / <?php echo $this->lang->line('patta_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>

                                        <!-- <td><?=$case->escalation_zone?></td>
                                        <td><?=$case->escalation_date?></td> -->

                                        <td><?php echo $case->case_no; ?><br>
                                        <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>


                                        <td>
                                            <!-- <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstCoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>">
                                                <?php echo "Proposal no : " . $case->proposal_no; ?></a> -->
                                            <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstCoProcess?case_no=<?php echo enc_param('case_no', $case->case_no, 600); ?>&proposal_no=<?php echo $case->proposal_no; ?>">
                                                <?php echo "Proposal no : " . $case->proposal_no; ?>
                                            </a>

                                        </td>
                                        <td class="center"><?php echo $case->dag_no; ?> / <?php echo $case->patta_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                            <!-- <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstCoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success"><?php echo $this->lang->line('give_order'); ?></a> -->
                                             <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstCoProcess?case_no=<?php echo enc_param('case_no', $case->case_no, 600); ?>&proposal_no=<?php echo $case->proposal_no; ?>" class="btn btn-success">
                                                <?php echo $this->lang->line('give_order'); ?>
                                            </a>


                                        <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){?>

                                          <!-- property chain report -->
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReportAC btn btn-primary'>View Property Chain</button>

                                            <!--  -->
                                        <?php }?>
                                              
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php
                        }
                        elseif (in_array($user_code, ['ADC', 'DC']) && $process == '2') {
                        ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='' width="100%">
                                <thead>
                                    <!-- <?php //if(ESCALATION_ENABLE==1){ include(APPPATH."views/common/esc_table_head.php");} ?> -->
                                    <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?> / <?php echo $this->lang->line('patta_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>

                                        <!-- <td><?=$case->escalation_zone?></td>
                                        <td><?=$case->escalation_date?></td> -->

                                        <td>
                                            <!-- <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>">
                                                <?php echo "Proposal no : " . $case->proposal_no; ?></a> -->
                                                <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstDCProcess?case_no=<?php echo enc_param('case_no', $case->case_no, 600); ?>&proposal_no=<?php echo $case->proposal_no; ?>">
                                                    <?php echo "Proposal no : " . $case->proposal_no; ?>
                                                </a>
                                            </td>
                                    <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?> / <?php echo $case->patta_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                            <!-- <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success"><?php echo $this->lang->line('give_order'); ?></a> -->
                                             <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/FirstDCProcess?case_no=<?php echo enc_param('case_no', $case->case_no, 600); ?>&proposal_no=<?php echo $case->proposal_no; ?>" class="btn btn-success">
                                                <?php echo $this->lang->line('give_order'); ?>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php
                        }elseif (in_array($user_code, ['LM']) && $process == '3') {
                        ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?> / <?php echo $this->lang->line('patta_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <!-- <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/LmRevertProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>">
                                                <?php echo "Proposal no : " . $case->proposal_no; ?></a> -->
                                            
                                            <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/LmRevertProcess?case_no=<?php echo enc_param('case_no', $case->case_no, 600); ?>&proposal_no=<?php echo $case->proposal_no; ?>">
                                                <?php echo "Proposal no : " . $case->proposal_no; ?>
                                            </a>
                                        </td>
                                    <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?> / <?php echo $case->patta_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                            <!-- <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/LmRevertProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success"><?php echo $this->lang->line('give_order'); ?></a> -->
                                             <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/LmRevertProcess?case_no=<?php echo enc_param('case_no', $case->case_no, 600); ?>&proposal_no=<?php echo $case->proposal_no; ?>" class="btn btn-success">
                                                <?php echo $this->lang->line('give_order'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php
                        }
                        ?>
                        <div class="pagination_links"><?=@$links?></div>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $("a").tooltip();
    });
</script>

<?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){?>
<!-- property chain modal -->
<div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>
<!--  -->
<input type="hidden" name="mut_type" id="mut_type" value="<?= MUT_TYPE_LEGACY ?>">
<?php }?>

<script type="text/javascript">
    $(document).ready(function() {
        $("a").tooltip();
    });

    // property chain modal

    $('.panel').on('click', '.chainReportAC', function(e) {
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
                mut_type: $('#mut_type').val()
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
                        } else {
                            $('#myModal .modal-content').css('background-color', 'red');
                            $('#myModal .modal-content').css('color', 'white');
                            $('#myModal .modal-content').html('<h1 class="text-center"><i class="fa fa-warning"></i>Unable to connect to property chain</h1>');
                            $('#myModal').modal();
                        }

                    }
                });
            }
        })
    });

    $('#myModal').on('hidden.bs.modal', function() {
        $('body').css('padding-right', 0);
        $('#myModal .modal-content').css('background-color', 'white');
        $('#myModal .modal-content').css('color', 'black');

    })
</script>

<?php if(ESCALATION_ENABLE == 1) { ?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#zone_status').change(function(){
            var zone_status = $('#zone_status').val();
            $('#casess').DataTable().destroy();

            <?php if($user_code == 'CO') { ?>
                load_data(zone_status);
            <?php } else if($user_code != 'CO' && $process == 2) { ?>
                load_adc_data(zone_status);
            <?php } ?>
        });

        // load data for CO
        function load_data(zone_status)
        {
            var base_url = "<?php echo base_url();?>";
            var table = $('#casess').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering"  : false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language'  : {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneAreaCorrectionCo',
                    type:'POST',
                    data: { zone_status:zone_status },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                    }]
            });
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
            
            // button search
            // $('.search_button').on('click', function () {
            //     $('table thead tr th .input_search').each(function(){
            //         $(this).val('');
            //     });
            //     $('#cases').DataTable().destroy();
            //     load_data();
            // });
        }

        // load data for adc
        function load_adc_data(zone_status)
        {
            var base_url = "<?php echo base_url();?>";
            var table = $('#casess').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering"  : false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language'  : {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneAreaCorrectionAdc',
                    type:'POST',
                    data: { zone_status:zone_status },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                    }]
            });
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
            
            // button search
            // $('.search_button').on('click', function () {
            //     $('table thead tr th .input_search').each(function(){
            //         $(this).val('');
            //     });
            //     $('#cases').DataTable().destroy();
            //     load_data();
            // });
        }
    });
</script>
<?php } ?>