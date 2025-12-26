
<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        padding: 15px;
        position: relative;
        width: 100%;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
    .btn-primary{
        font-weight: bold;
        color: white!important;
        text-transform: capitalize;
    }

</style>
<center>
    <mark>
        Application Received in Svamitva
    </mark>
    <br>
    <mark>
        <strong style="font-size: 20px;">
            <?php
            if($service == NC_TRIBAL_ID)
            {
                echo $this->lang->line('ncTribalTitle');
            }
            if($service == NC_KHAS_LAND_ID)
            {
                echo $this->lang->line('ncKhasLandTitle');
            }
            if($service == NC_CULTIVATOR_ID)
            {
                echo $this->lang->line('ncCultivatorTitle');
            }
            ?>
        </strong>
    </mark>

</center>



<?php if($this->session->flashdata('success')) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 reza-card ">
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if($this->session->flashdata('error')) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 reza-card ">
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        </div>
    </div>
<?php } ?>




<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 reza-card ">
        <table class="datatable table table-stripped" id='datatable'>
            <thead style="font-size:7px">
            <tr>
                <th></th>
                <th></th>
                <th>Occupation
                    <select name="occupation" id="occupation" class="form-control input_search" data-column-index="2">
                        <option value="">Select</option>
                        <option value="SERVICE">SERVICE</option>
                        <option value="PRIVSERV">PRIVSERV</option>
                        <option value="BUSINESS">BUSINESS</option>
                        <option value="PENSIONER">PENSIONER</option>
                        <option value="AGRICULTURE">AGRICULTURE</option>
                        <option value="HOUSEWIFE">HOUSEWIFE</option>
                        <option value="UNEMPLOYED">UNEMPLOYED</option>
                    </select>
                </th>
                <th>
                    Applied for
                </th>
                <th>
                    Flagged in Chitha
                </th>
                <th>Urban/Rural

                    <select class="form-control input_search" name="rural" id="rural" data-column-index="3">
                        <option value="">select</option>
                        <?php if(isset($selectList->urban_check)){ foreach($selectList->urban_check as $rural){
                            ?>
                            <option value="<?=$rural->is_urban?>"><?php if($rural->is_urban == 'Y'){echo 'Urban';}else{echo "Rural";}?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>Name
                    <select class="form-control input_search" name="category" id="category" data-column-index="4">
                        <option value="">select</option>
                        <?php if(isset($selectList->vill_list)){ foreach($selectList->vill_list as $vill){
                            ?>
                            <option value="<?=$vill->village_code?>"><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_code, $vill->lot_no, $vill->village_code)?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>
                    <!-- Action -->
                    <button type="button" class="search_button btn btn-sm btn-success form-control">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        Search
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function ()
    {
        $('#rural, #category, #occupation').change(function(){
            var rural = $('#rural').val();
            var category = $('#category').val();
            var occupation = $('#occupation').val();
            $('#datatable').DataTable().destroy();

            load_data(category,rural,occupation);

        });

        load_data();

        function load_data(category,rural,occupation)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = <?=$service?>;

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = 'Application No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = 'Application Date';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
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
                    url: base_url+'index.php/NcCommonController/paginationAPI',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        rural:rural,
                        occupation:occupation,
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
                }],

            });


            // button search
            $('.search_button').on('click', function () {
                $('table thead tr th .input_search').each(function(){
                    table.column($(this).data('columnIndex')).search(this.value);
                });
                table.draw();
            });
        }

    });

</script>

<script src="<?php echo base_url();?>js/NcVillage/lm/register_init.js"></script>
 