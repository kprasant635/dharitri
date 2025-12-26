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
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
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

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }


</style>

<div class="row" style='padding: 10px 20px 20px 0px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Relinquishment /
            <a href="<?= base_url()?>index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment">
                Process
            </a>
            / First Proceeding
            <a href="<?= base_url()?>index.php/Home/index">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>

        <div class="reza-card">
            <div class="reza-title">
                <span> Relinquishment Application Received in Basundhara </span>
                <hr>
            </div>
            <div class="reza-body">

                <table class="datatable table table-stripped" id='datatable'>
                    <thead style="font-size:7px">
                    <tr>
                        <th></th>
                        <th></th>
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
                    url: base_url+'index.php/RelinquishmentRegisterController/apiForUnRegisterRelinquishmentApp',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        rural:rural,
                        occupation:occupation
                    },
                    deferLoading: 57
                },


                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                }]

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
