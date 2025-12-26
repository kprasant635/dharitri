<div class="container-fluid form-top login ">
    <div class='row'>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
        </div>&nbsp;
        <div class='col-lg-12 panel panel-default' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                </div>
            <?php endif; ?>
            <table id="example" class="table table-hover panel-body" style="margin:auto; "  width="100%">
                <thead >
                    <tr >
                        <th class="alert-info"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('status') ?></th>

                    </tr>
                </thead>
                <tfoot >
                    <tr>
                        <th class="alert-info"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('status') ?></th>

                    </tr>
                </tfoot>

                <tbody>
                    <?php
                    //var_dump($cases);
                    foreach ($cases as $case):
                        ?>
                        <tr>
                            <td><?php echo $case->case_no ."<br><span class='small red'>"."<br><span class='small red'>". $case->basundhara ."</span>"; ?></td>
                            <td>Reclassification</td>
                            <td><?php echo date('d/m/Y', strtotime($case->submission_date)); ?></td>
                            <?php if ($case->notice_generated_yn == null) { ?>
                                <td>
                                    <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/ReclassSuiteControllerAst/NoticeSubmit?pid=<?php echo $case->petition_no; ?>&case=<?php echo $case->case_no ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                </td>
                                <?php
                            } else {
                                ?>
                                <td>
                                    <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/partition/NoticeSubmit?id=<?php echo $case->petition_no; ?>&case=<?php echo $case->c_no ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bInfo": false,
            "pageLength": 20
        });

    });



    $(document).ready( function () {

    $('#zone_status').change(function(){

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
                url: base_url+'index.php/EscalationController/searchByEscalationZoneForAstOfficePartitionNoticeGenerate',
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
        $('.search_button').on('click', function () {
            $('table thead tr th .input_search').each(function(){
                $(this).val('');
            });
            $('#cases').DataTable().destroy();
            load_data();
        });
    }
});
</script>  

