<script>
    $(function () {
        $('.msg').click(function (e) {
            e.preventDefault();
            $('#myModal').modal();
                console.log($(this));
                $('#proceed').attr('href', $(this).attr('href'));
        });


    });
</script>

<input type="hidden" id="mut_type" value="<?=$_GET['mut']?>">
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
                <!--<p>Or</p>
                <a href="<?php echo base_url(); ?>index.php/mutationbacklog/mutation" id='' class="btn btn-info" style="font-size: 1.2em;margin-bottom: 10px;">Correct Data.</a>-->
            </div>

        </div>

    </div>
</div>
<div class="container-fluid login form-top">
    <div class='row'>
        <div class='col-lg-12 panel panel-default'>
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php echo $this->session->userdata('message');
						$this->session->unset_userdata('message'); ?>
                </div>
            <?php endif; ?>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="<?=base_url().'index.php/home/PartitionSk'?>">
                <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
            </div>&nbsp;

            <table class='table table-striped table-bordered' id='cases'>
                <thead>
                    <tr>
                
                        <th class='alert-new'><?php echo $this->lang->line('case_no'); ?></th>
                        <th class='alert-new'><?php echo $this->lang->line('case_type'); ?></th>
                        <th class='alert-new'><?php echo $this->lang->line('submission_type'); ?></th>
                        <th class='alert-new'><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cases as $case): ?>
                        <tr>
                            
                          
                            <td><a href="<?php echo base_url() . 'index.php/skmutation/viewcasedetails/?case=' . $case->case_no; ?>"><?php echo $case->case_no; ?></a>
                                <br>
                                <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                <span class='small font-italic red'>
                                    <?php if($case->application_ref_no){ echo "RTPS:". $case->application_ref_no ;} ?></span>
                            </td>
                          
                            <td>
                                <?php
                                if ($case->mut_type == '01') {
                                    echo $this->lang->line('conversion');
                                } else if ($case->mut_type == '03') {
                                    echo $this->lang->line('mutation');
                                } else if ($case->mut_type == '04') {
                                    echo $this->lang->line('partition');
                                }
                                ?>
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($case->submission_date)); ?></td>

                            <td>
                                <a  href='<?php echo base_url() . "index.php/officemutation/lmreport?case_no=" . $case->case_no; ?>' class="btn btn-danger btn-xs" target='_blank'>
                                   <i class="fa fa-eye"></i> LM Report
                                </a>

                                   <?php if ($case->mut_type == '01' or $case->mut_type == '03') { 

                                    if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                    {
                                        echo "Escalated to Appellate Authority";
                                    }
                                    else
                                    {
                                    ?>
                                        <a href='<?php echo base_url() . "index.php/skmutation/writeOfficeReport?case_no=" . $case->case_no; ?>' class="btn btn-danger btn-xs">
                                        <i class="fa fa-pencil"></i> <?php echo $this->lang->line('write_report'); ?>
                                        </a>
                                    <?php } ?>
                                <?php
                                } else {

                                    if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                    {
                                        echo "Escalated to Appellate Authority";
                                    }
                                    else
                                    {
                                    ?>
                                    <a href='<?php echo base_url() ?>index.php/partition/SKPartitionRedirect?case_no=<?php echo $case->case_no ?>&vill=<?php echo $case->vill_townprt_code; ?>&m=<?php echo $case->mouza_pargona_code ?>&l=<?php echo $case->lot_no ?>&p=<?php echo $case->petition_no ?>&y=<?php echo $case->year_no ?>' class="msg btn btn-danger btn-xs">
                                   <i class="fa fa-pencil"></i> <?php echo $this->lang->line('write_report'); ?>
                                    </a>
                                <?php } ?>
                                    <?php }
                                ?>
                            </td>

                        </tr>
<?php endforeach; ?>
                </tbody>
            </table>
<?php // /echo ($this->pagination->create_links()); ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bInfo": false,
            "pageLength": 20
        });

    });
</script> 


<script type="text/javascript">
<?php if(ESCALATION_ENABLE == 1){  ?>
    $(document).ready( function () {

        $('#zone_status').change(function(){

            var zone_status = $('#zone_status').val();
            $('#cases').DataTable().destroy();
            load_data(zone_status);
        });

        function load_data(zone_status)
        {
            var base_url = "<?php echo base_url();?>";
            mut_type = $('#mut_type').val();
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
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneForSK',
                    type:'POST',
                    data: { zone_status:zone_status, mut_type:mut_type },
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
<?php } ?>
</script>
