
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="text-align: center;font-size: 1.8em;">Important Notice</h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <p style="font-size: 1.5em;">Please make sure that Offline and 
                    Online Dharitree Data is matching before Proceeding. If not, use backlog entry module to update data.</p>
                <a href="" id='proceed' class="btn btn-danger" style="font-size: 1.2em;margin-bottom: 10px;">I  have verified that offline and online data is matching.</a>
               
                <a href="<?php echo base_url(); ?>index.php/Backlogpartition/index" id='' class="btn btn-info hide" style="font-size: 1.2em;margin-bottom: 10px;">Correct Data.</a>
            </div>

        </div>

    </div>
</div>
<div class="container-fluid form-top login">
    <div class='row '>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                </div>
            <?php endif; ?>
            <table id="example" class="table table-hover  panel-body" width="100%">
                <thead >
                    <tr >
                        <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                        <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('status') ?></th>

                    </tr>
                </thead>
                <!-- <tfoot >
                    <tr>
                        <?php //if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                        <th class="alert-new"><?php //echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-new"><?php //echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-new"><?php //echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-new"><?php //echo $this->lang->line('status') ?></th>
                    </tr>
                </tfoot> -->

                <tbody>
                    <?php foreach ($revertedCase as $case): ?>
                        <tr>
                            <?php if(ESCALATION_ENABLE == 1){ ?>
                                <td class="center"><?=$case->escalation_zone;?></td>
                                <td class="center"><?=$case->escalation_date;?></td>
                            <?php } ?>
                            <td><?=$case->case_no?>
                                <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                            </td>
                            <td><?php echo $this->lang->line('office_partition'); ?></td>
                            <td><i class='glyphicon glyphicon-calendar'></i> <?=date('d/m/Y', strtotime($case->submission_date))?></td>
                            <td>

                                <?php if ($case->mut_type == '04'):

                                    if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                    {
                                        echo "Escalated to CO";

                                    }else
                                    {
                                        ?>
                                        <a class="btn btn-danger msg" href="<?=base_url()?>index.php/partition/revertReportOP?name=<?=$case->case_no?>"><?php echo $this->lang->line('write_report'); ?></a>
                                    <?php }
                                 ?>
                                    
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<script>

    <?php if(ESCALATION_ENABLE == 1){ ?>

        $(document).ready( function () 
        {
            $('#zone_status').change(function()
            {
                var zone_status = $('#zone_status').val();
                $('#example').DataTable().destroy();
                load_data(zone_status);
            });

            function load_data(zone_status)
            {
                var base_url = "<?php echo base_url();?>";
                var table = $('#example').DataTable({
                    'pageLength': 10,
                    "processing": true,
                    "serverSide": true,
                    "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/EscRevertController/searchByEscalationZoneRevertedForOffPartLm',
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
            }
        });

    <?php } ?>


    $(document).ready(function () {
        $('#example').DataTable({
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bInfo": false,
            "pageLength": 20
        });

    });
</script>  