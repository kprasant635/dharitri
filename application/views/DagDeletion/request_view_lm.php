<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Masud's CSS-->
<style>
    .error
    {
        color: red;
    }
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard {
        margin: 10px auto;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
        padding-top: 10px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }


    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005B96 !important;
        text-decoration: none;
    }
    .wizard li.active{
        background: #005B96;
        padding: 0px;
        box-shadow: 1px 0px 1px 1px;

    }

    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 45%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #ffffff;
    }

    .wizard .nav-tabs > li a {
        text-align: center;
        /* width: 90%; */
        margin-bottom: 10px;
        /* padding: 0; */
    }
    .wizard .nav-tabs > li a:hover {
        background-color: transparent !important;
    }


    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }



</style>

<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
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

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
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
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }

    .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        text-transform: capitalize;
        margin-left: 25px;
    }
    .reza-body{
        padding-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 10px;
        margin: 10px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
    .labDiv{
        margin-bottom: 15px;
    }
    .lab{
        margin-bottom: 5px;
    }
    .landDetails{
        display: none;
    }
    td{
        font-size: 16px;
    }
    .rezaText{
        font-weight: bold;
        font-size: 14px;
        margin: 5px;
        margin-bottom: 20px;
        background: #248cf7 !important;
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }

    .checkBoxD{
        width: 20px;
        height: 20px;
    }
</style>


<div class="row" style='padding: 30px 40px 30px 10px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>
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
            <br>
        <?php } ?>


        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px; text-transform: uppercase">
            Pending Dag deletion request
        </h5>

        <div class="reza-card">
            <div class="reza-body">
                <form method="POST" action="" id="">
                    <div class="tableCard">
                        <input type="hidden" class="districtselect" name="dist_code" id="dist_code" value="<?php echo $datas['dist_code']; ?>">
                        <input type="hidden" class="subdivselect" name="subdiv_code" id="subdiv_code" value="<?php echo $datas['subdiv_code']; ?>">
                        <input type="hidden" class="circleselect" name="cir_code" id="cir_code" value="<?php echo $datas['cir_code']; ?>">
                        <input type="hidden" class="mouza_pargona_code" name="mouza_pargona_code" id="mouza_pargona_code" value="<?php echo $datas['mouza_pargona_code']; ?>">
                        <input type="hidden" class="lot_no" name="lot_no" id="lot_no" value="<?php echo $datas['lot_no']; ?>">
                        <div class="" role="alert" style="text-align:center">
                            <h5 style="font-size: 16px;!important;">
                                <?php echo $this->lang->line('district');?> : <span class="rezaText"><?php echo $datas['dist_name']; ?></span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php echo $this->lang->line('subdivision');?> : <span class="rezaText"><?php echo $datas['sub_div_name']; ?></span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php echo $this->lang->line('circle');?> : <span class="rezaText"><?php echo $datas['cir_name']; ?></span>
                                <?php echo $this->lang->line('mouza');?> : <span class="rezaText"><?php echo $datas['mouzaname']; ?></span>
                                <?php echo $this->lang->line('lot_no');?> : <span class="rezaText"><?php echo $datas['lot_name']; ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="tableCard">
                        <table class="datatable table table-stripped" id='datatable'>
                            <thead style="font-size:7px">
                            <tr>
                                <th>Request No.</th>
                                <th>Village Name</th>
                                <th>Dag Area</th>
                                <th>Land Class</th>
                                <th>Status</th>
                                <th>Pending With</th>
                                <th>Action
                                    <button type="button" class="search_button btn btn-sm btn-success">
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
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">


    function showErrorMessage(text) {
        Swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }

</script>
<script>
    var selectedCheckBoxArray = [];
    $(document).ready(function ()
    {
         load_data();

        function load_data()
        {

            var base_url = "<?php echo base_url();?>";

            $('#datatable thead th:nth-of-type(3)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
                var title = 'Dag No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search '+title+'" data-column-index="0">');
            });

            $('#datatable thead th:nth-of-type(1)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
                var title = 'Request No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search '+title+'" data-column-index="1">');
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
                    url: base_url+'index.php/DagDeletionController/getAllPendingDagDelRequest',
                    type:'POST',
                    data: {
                        // village_code:$("#vill_townprt_code").val()
                    },
                    deferLoading: 57,
                },



                order: [[2, 'asc']],

                columnDefs: [{
                    targets: 0,
                    // checkboxes: {
                    //   'selectRow': true
                    // },
                    // data: "is_visible",

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