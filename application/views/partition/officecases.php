
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
                
                <a href="<?php echo base_url(); ?>index.php/Backlogpartition/index" id='' class="hide btn btn-info" style="font-size: 1.2em;margin-bottom: 10px;">Correct Data.</a>
            </div>

        </div>

    </div>
</div>
<input type="hidden" id="mut_type" value="<?=$_GET['mut']?>">
<div class="container-fluid login form-top">
    <div class='row'>
        <div class='col-lg-12 panel panel-default'>
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php  echo $this->session->userdata('message');$this->session->unset_userdata('message');?>
                </div>
            <?php endif; ?>
            <table class='table panel-body table-striped table-bordered tablesorter pageshowpage' id='dataTable'>
                <thead>
                    <tr>
                        <?php if(ESCALATION_ENABLE==1){ include(APPPATH."views/common/esc_table_head.php");} ?>
                        <th class='alert-new'><?php echo $this->lang->line('case_no');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('case_type');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('submission_date');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cases as $case): ?>
                    <tr>
                        <?php if(ESCALATION_ENABLE==1){ ?>
                                <td class="center"><?=$case->escalation_zone;?></td>
                                <td class="center"><?=$case->escalation_date;?></td>
                            <?php } ?>
                        <td><a href="<?php echo base_url() . 'index.php/skmutation/viewcasedetails/?case=' . $case->case_no; ?>"><?php echo $case->case_no; ?></a>
                            <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                    <span class='small font-italic red'>
                                    <?php if($case->application_ref_no){ echo "RTPS:". $case->application_ref_no ;} ?></span>
                        </td>
                        <td>
                            <?php  echo $this->lang->line('office_partition'); ?>
                        </td>
                        <td><i class='glyphicon glyphicon-calendar'></i>  <?php echo date('d-m-Y',strtotime($case->submission_date)); ?></td>
                       
                          <td>
                            <?php 
                            if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                            {
                                echo "Escalated to Appellate Authority";
                            }
                            else
                            {
                            ?>
                            <a href='<?php echo base_url()?>index.php/partition/SKPartitionRedirect?case_no=<?php echo $case->case_no ?>&vill=<?php echo $case->vill_townprt_code;?>&m=<?php echo $case->mouza_pargona_code?>&l=<?php echo $case->lot_no?>&p=<?php echo $case->petition_no?>&y=<?php echo $case->year_no?>' class="btn msg btn-danger">
                                <?php echo $this->lang->line('write_report');?>
                            </a>
                        <?php } ?>
                            
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php // /echo ($this->pagination->create_links());?>
        </div>
    </div>
</div>

<script type="text/javascript">
<?php if(ESCALATION_ENABLE == 1){  ?>
    $(document).ready( function () {

        $('#zone_status').change(function(){

            var zone_status = $('#zone_status').val();
            $('#dataTable').DataTable().destroy();
            load_data(zone_status);
        });

        function load_data(zone_status)
        {
            var base_url = "<?php echo base_url();?>";
            mut_type = $('#mut_type').val();
            var table = $('#dataTable').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering"  : false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language'  : {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneForSKOfficePartition',
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