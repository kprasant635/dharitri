<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1') {
                            echo "LOT MONDAL'S OFFICE LAND CONVERSION CASES";
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="col-lg-10 col-lg-offset-1">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if ($process == '1') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>

                       
                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                       

                                        <td><a href="<?php echo base_url(); ?>index.php/LMconversionPartha?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center"><?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center"><a class="btn btn-success" href="<?php echo base_url(); ?>index.php/LMconversionPartha?case_no=<?php echo $case->case_no; ?>"><?php echo $this->lang->line('write_report'); ?></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } 
                        ?>
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
<!--

<div class="row panel-form" >

    <div class="col-lg-12">
        <div class="" style="min-height: 500px;">
            <div class='panel-body col-lg-10 col-lg-offset-1'>
                <div class="panel-title">
                    <table class='table' style="color:blue;">
                        <tr>
                            <td width='5%' style='background: url(<?php echo base_url(); ?>application/views/img/3.png); background-size:100%'></td>
                            <td><label>LOT MONDAL'S OFFICE LAND CONVERSION CASES</label></td>
                        </tr>
                    </table>
                </div>
            </div>

            <?php
            if ($process == '1') {
                ?>
                <div class='panel-body col-lg-10 col-lg-offset-1'>
                    <label class="rasid"><?php echo $this->lang->line('conversion_write_report_on_pending_conversion_cases'); ?></label>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('due_date'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                        </thead>
                        <?php foreach ($cases as $case): ?>
                            <tr>
                                <td><a href="<?php echo base_url(); ?>index.php/LMconversionPartha?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                                <td class="center"><?php
                                    if ($case->mut_type == '01') {
                                        echo "Convertion Case";
                                    }
                                    ?>
                                </td>
                                <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                <td class="center"><?php echo "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($case->next_date_of_hearing)) . "</p>"; ?></td>
                                <td class="center">
                                    <?php
                                    $datetime1 = new DateTime();
                                    $datetime2 = new DateTime(date('d-m-Y', strtotime($case->next_date_of_hearing)));
                                    $interval = $datetime1->diff($datetime2);
                                    $days = $interval->format('%R%a');
                                    if ($days <= -1) {
                                        echo "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                                    }
                                    ?>
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/LMconversionPartha?case_no=<?php echo $case->case_no; ?>"><?php echo $this->lang->line('write_report'); ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <?php
            } elseif ($process == '2') {
                ?>
                <div class='panel-body col-lg-10 col-lg-offset-1'>
                    <label class="rasid">Write Next Proceeding for Running Cases (also showing cases shortlisted for next week)</label>

                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <?php
            }
            ?>

        </div>
    </div>

</div>-->

<script type="text/javascript">
    $(document).ready(function () {
        $('#conversionData').DataTable({
            "pageLength": 50,
            "lengthChange": false
        })
    });
</script>

<?php if(ESCALATION_ENABLE == 1) { ?>
   <!--  <script type="text/javascript">
        $(document).ready( function () {
            $('#zone_status').change(function(){
                var zone_status = $('#zone_status').val();
                $('#cases').DataTable().destroy();
                load_data(zone_status);
            });
            function load_data(zone_status)
            {
                var base_url = "<?php echo base_url();?>";
                var table = $('#cases').DataTable({
                    'pageLength': 10,
                    "processing": true,
                    "serverSide": true,
                    "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/ConversionEscalationController/searchByEscalationZoneConversionForLm',
                        type:'POST',
                        data: { zone_status:zone_status },
                        deferLoading: 57,
                    },
                    order: [[2, 'asc']],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false,
                        "className": "dt-left", "targets":[ 0, 1, 2, 3, 4, 5],
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
            }
        });
    </script> -->
<?php } ?>

