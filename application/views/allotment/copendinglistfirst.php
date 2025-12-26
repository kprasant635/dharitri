<style>
    #datatable {
        font-size: 14px!important; /* Adjust the font size as needed */
    }

    #datatable th,
    #datatable td {
        font-size: 14px!important; /* Adjust the font size as needed */
    }
</style>

<div class="container-fluid form-top login">

    <table id="example" class="datatable table table-stripped">
        <thead >
            <tr >
                <th>Zone</th>
                <th>Escalate On</th>
                <th><?php echo $this->lang->line('case_no'); ?></th>
                <th><?php echo $this->lang->line('certificate_type'); ?></th>
                <th><?php echo $this->lang->line('submission_date') ?></th>
                <th><?php echo $this->lang->line('status') ?></th>
            </tr>
        </thead>
        <tbody>
                    <?php
                    foreach ($cases as $case): ?>
                        <tr>
                            <td><?=$case->escalation_zone?></td>
                            <td><?=$case->escalation_date?></td>
                            <td><?php echo $case->case_no; ?>
                                <br><span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                            </td>
                            <td>Allotment to PP</td>
                            <td><i class="fa fa-calendar"></i> <?php  echo   date('d/m/Y',  strtotime($case->date_entry)) ; ?></td>
                            <td>
                                <?php 
                                    if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1){
                                        echo "Escalated to Appellate Authority";
                                    }
                                    else
                                    {
                                        ?>
                                        <a class='btn btn-danger' href='<?php echo base_url() . 'index.php/Allotment/cofirstproceeding' ?>?case_no=<?php echo enc_param('case_no', $case->case_no, 600) ?>'>PROCESS</a>
                              <?php } ?>
                                
                                
                            </td>
                        
                        </tr>
                    <?php endforeach; ?>
        </tbody>
    </table>
           
</div>
<script>
$(document).ready(function() {
    $('#example').DataTable({
	"bLengthChange": false,
	"showNEntries" : false,
	"bSort" :	false,
	"bnew" :	false,
	"pageLength": 20
  });
  
});
</script> 


<!-- 
<script>
    $(document).ready(function (){
        $(document).on('change', '#category', function(){
            var category = $('#category').val();

            $('#datatable').DataTable().destroy();
            if(category != ''){
                category = category;
            }
            else{
                category = '';
            }

            load_data(category);

        });

        load_data();

        function load_data(is_category = null){

            var base_url = "<?php echo base_url();?>";

            $('#datatable thead th:nth-of-type(3)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });
            
            var table = $('#datatable').DataTable({
                // "scrollX": true,
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                // "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/Allotment/coFirstProceedingList',
                    type:'POST',
                    data: {

                    },
                    deferLoading: 57,
                },


                // order: [[2, 'asc']],
                // columnDefs: [{
                //     targets: "_all",
                //     orderable: false,
                //     "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6, 7],
                //     }]
                    
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