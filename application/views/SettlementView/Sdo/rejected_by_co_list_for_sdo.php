<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $service_name ?></span>
                <hr>
                <span>Rejected Application By CO</span>
            </div>

            <div class="reza-body">

                <?php if ($application == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table id="datatable" class="datatable table table-stripped">
                        <thead>
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
                            <th>
                                <select class="form-control" data-column-index="2" id="remark_cat"
                                        name="remark_cat">
                                    <option value="">LM Remark Category...</option>
                                    <option value="1">Recommended</option>
                                    <option value="2">Not Recommended</option>
                                </select>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                <?php endif; ?>

            </div>

        </div>





    </div>
</div>

<script>
    $(document).ready(function ()
    {
        $(document).on('change', '#category, #remark_cat', function(){
            var category = $('#category').val();
            var remark_cat = $('#remark_cat').val();

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

            load_data(category, remark_cat);

        });

        load_data();

        function load_data(is_category = null, remark_cat = null)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";
            var reverted = "<?php if(isset($_GET['reverted'])) {echo $_GET['reverted']; } else { echo "";}?>";

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
                    url: base_url+'index.php/SettlementCommonDc/paginationForRejectedApplicationByCoForSdo',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category,
                        reverted:reverted,
                        remark_cat:remark_cat
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

</script>