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
        padding-bottom: 20px;
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
    label{
        padding-bottom: 5px;
        font-weight: bold;
    }
    #searchBox{
        padding: 15px;
        border: 1px solid #00BCD4;
        margin: 0px;
    }
    #cases_wrapper {
        margin-top: 0px !important;
    }
</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php if($this->session->flashdata('message')):?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                </div>
            <?php endif;?>
        </div>



        <div class="reza-card">
            <div class="reza-title">
                <span>Rejected Data Report </span>
                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
                <hr style="margin-bottom: -5px">
            </div>
            <div class="reza-body">
                <div class="row" id="searchBox">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="serviceName">Rejected List of</label>
                            <select class="form-select" aria-label="Default select example" name="serviceName" id="serviceName" style="border-color: green;">
                                <option selected disabled>-- Select Service --</option>
                                <option disabled style="color:#999">============== MB1 ==============</option>
                                
                                <option value="FMUT" selected>Field Mutation</option>
                                <option value="OMUT" >Office Mutation</option>
                                <option value="FMUTD">Field Mutation Deed</option>
                                <option value="OMUTD">Office Mutation Deed</option>
                                <option value="OMUTC">Composite Land Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="fromDate"><?= $this->lang->line('fromDate') ?></label>
                            <input type="text" autocomplete="off" placeholder="yyyy-mm-dd"
                                   class="fromDate form-control date" id="popup1Datepicker" name="fromDate" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="toDate"><?= $this->lang->line('toDate') ?></label>
                            <input type="text" autocomplete="off" placeholder="yyyy-mm-dd"
                                   class="toDate form-control date" id="popup2Datepicker" name="toDate" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px" align="right">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="rezaButt buttInfo searchData" id="" style="width: 200px">Get Data
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                        <span><?php echo $this->lang->line('caseList') ?></span>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12" align="right">

                    </div>
                </div>

                <hr style="margin-bottom: -5px">
            </div>

            <div class="reza-body" id="showBody">

                <table class='table table-striped table-bordered' id='cases' width="100%">

                    <thead>
                    <tr>
                        <th>SL No.</th>
                        <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                        <th class="center"><label class="control-label"></label>Mouza</th>
                        <th class="center"><label class="control-label"></label>Lot</th>
                        <th class="center">Rejected Reason</th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });
    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true
        });
    }

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showConfirmButton: true,
        });
    }

    $(document).ready( function () {

        $('.searchData').click(function(){
            $('#cases').DataTable().destroy();
            load_data();
        });

        function load_data()
        {
            serviceName   = $('#serviceName').val();
            appStatus     = 'REJECT';
            fromDate      = $('.fromDate').val();
            toDate        = $('.toDate').val();

            var base_url = "<?php echo base_url();?>";
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
                    url: base_url+'index.php/RejectedController/getSearchedDataDetail',
                    type:'POST',
                    data: {
                        serviceName   : serviceName,
                        appStatus     : appStatus,
                        fromDate      : fromDate,
                        toDate        : toDate,
                    },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2],
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




