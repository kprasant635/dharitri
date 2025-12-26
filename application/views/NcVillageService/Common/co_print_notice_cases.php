<style type="text/css">
    .table_responsive {
        overflow-x: scroll;
    }    
</style>

<?php
    // $_GET['notice'] ='';
    // $note_msg ='';
    if(isset($_GET['notice'])) { 

        if($_GET['notice'] == 30){
            $note_msg = 'Notice Period Already Completed';
        }
        else if($_GET['notice'] == 2){
            $note_msg = 'Notice Period to be completed in 2 days';
        }
        if($_GET['notice'] == 1){
            $note_msg = 'Notice Period to be completed in 1 day';
        }
?>
    <div class="alert alert-danger"> Your data filtered by : <?= $note_msg ?></div>
<?php } ?>

<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Print Notice Cases
        </h4>
    </div>
    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>



<div class="row px-5 table_responsive">
    <table id="datatable" class="datatable table table-stripped">

        <thead>  
            <tr>  
                <th>Case No</th> 
                <th>Application No</th> 
                <th>Mouza
                    <select class="form-control" name="mouza_cat" id="mouza_cat">
                        <option value="">select</option>
                        <?php if(isset($select_data)){ foreach($select_data as $select){?>
                            <option value="<?=$select->mouza_pargona_code?>"><?=$this->utilityclass->getMouzaName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code)?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>Lot
                    <select class="form-control" name="lot_cat" id="lot_cat">
                        <option value="">Select Lot</option>
                    </select>
                </th>
                <th>Village
                    <select class="form-control" name="category" id="category">
                        <option value="">select</option>
                    </select>
                </th>  
                <th>Submission Date</th>

                <th>Notice Date
                    <select class="form-control" name="notice_date" id="notice_date">
                        <option value="">Select</option>
                        <option value="already_completed">Notice Period Already Completed</option>
                        <option value="tobe_completed_2_days">Notice Period to be completed in 2 days</option>
                        <option value="tobe_completed_1_day">Notice Period to be completed in 1 days</option>
                    </select>
                </th>

                <th>
                    <select class="form-control" data-column-index="2" id="remark_cat"
                            name="remark_cat">
                        <option value="">LM Remark Category...</option>
                        <option value="1">Recommended</option>
                        <option value="2">Not Recommended</option>
                        <option value="3">LM Report Not Submitted</option>
                    </select>
                </th>
                <th>Action</th>
            </tr>  
        </thead>  


        <!-- <thead>
            <tr>
                <th>Case No</th>
                <th>Application No</th>
                <th>Location
                    <select class="form-control" name="category" id="category">
                        <option value="">select</option>
                        <?php if(isset($select_data)){ foreach($select_data as $select){?>
                            <option value="<?=$select->vill_townprt_code?>"><?=$this->utilityclass->getVillageName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code, $select->lot_no, $select->vill_townprt_code)?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>Submission Date</th>
                <th>Action</th>
            </tr>
        </thead> -->
        <tbody>

        </tbody>
    </table>
</div>

<style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>


<script>
    $(document).on('change', '#mouza_cat, #lot_cat', function(){
        var mouzaCode = $('#mouza_cat').val();
        var lot_no = $('#lot_cat').val();

        var postData = {
            'mouza_pargona_code' : mouzaCode,
            'lot_no' : lot_no,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementCommon/getLotsFromMouzaCo',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    var options = '<option value="">Select Lot</option>';
                    var options2 = '<option value="">Select Village</option>';

                    if(mouzaCode == '')
                    {
                        $('#lot_cat').html(options);
                        $('#category').html(options2);
                    }

                    if(arr.lot_details != '')
                    {
                        for(i=0; i<arr.lot_details.length; i ++)
                        {
                            options += "<option value='"+arr.lot_details[i].lot_no+"'>"+arr.lot_details[i].loc_name+"</option>";
                        }

                        $('#lot_cat').html(options);
                    }

                    if(arr.village_details != '')
                    {
                        for(i=0; i<arr.village_details.length; i ++)
                        {
                            options2 += "<option value='"+arr.village_details[i].vill_townprt_code+"'>"+arr.village_details[i].loc_name+"</option>";
                        }

                        $('#category').html(options2);
                        
                    }
                    else
                    {
                        $('#category').html(options2);
                    }
                }
            }
        });
    })

</script>


<script>
    $(document).ready(function ()
    {
        $(document).on('change', '#category, #remark_cat, #mouza_cat, #lot_cat, #notice_date', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();

            var notice_date = $('#notice_date').val();            

            $('#datatable').DataTable().destroy();
            if(category != '')
            {
                category = category;
            }
            else
            {
                category = '';
            }
            if(remark_cat != '')
            {
                remark_cat = remark_cat;
            }
            else
            {
                remark_cat = '';
            }

            if(mouza_cat != '')
            {
                mouza_cat = mouza_cat;
            }
            else
            {
                mouza_cat = '';
            }

            if(lot_cat != '')
            {
                lot_cat = lot_cat;
            }
            else
            {
                lot_cat = '';
            }

            if(notice_date != '')
            {
                notice_date = notice_date;
            }
            else
            {
                notice_date = '';
            }

            load_data(category, remark_cat, mouza_cat, lot_cat, notice_date);

        });
        load_data();

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null, notice_date=null)
        {

            var get_notice = "<?=isset($_GET['notice']) ? $_GET['notice'] : null?>";

            if(get_notice != null && notice_date == null)
            {

                if(get_notice == 30) {
                    notice_date = 'already_completed';
                }
                else if(get_notice == 2) {
                    notice_date = 'tobe_completed_2_days';
                }
                else if(get_notice == 1) {
                    notice_date = 'tobe_completed_1_day';
                }
            } 

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });
            // $('#datatable thead th:nth-of-type(4)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });
            
            var table = $('#datatable').DataTable({
                // "scrollX": true,
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/SettlementCommon/paginationForApSecondPreceding',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category,
                        remark_cat:remark_cat,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat,
                        notice_date: notice_date
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6, 7, 8],
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
</script>

<!-- <script>
    $(document).ready(function ()
    {
        $(document).on('change', '#category', function(){
            var category = $(this).val();
            $('#datatable').DataTable().destroy();
            if(category != '')
            {
                load_data(category);
            }
            else
            {
                load_data();
            }
        });

        load_data();

        function load_data(is_category)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });
            $('#datatable thead th:nth-of-type(4)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            var table = $('#datatable').DataTable({
                // "scrollX": true,
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax':{
                    url: base_url+'index.php/SettlementCommon/paginationForApSecondPreceding',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 3, 4],
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
