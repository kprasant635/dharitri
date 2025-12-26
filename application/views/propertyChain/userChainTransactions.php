<div class="container-fluid form-top login" id="show-prop-report">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">                
                <div class="bg-secondary text-white p-2 h4 text-center font-weight-bold shadow-lg">                
                    PROPERTY CHAIN TRANSACTIONS
                </div>
                <div class="bg-dark text-white p-2 h6 text-center font-weight-bold shadow-lg" style="margin-top:-10px;">                
                    DISTRICT:<?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?>, 
                    SUB-DIVISION:<?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'))?>, 
                    CIRCLE:<?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'))?>
                </div>
            </div>
            <div class="col-lg-12" style="margin-top:-6px;">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <table class="table table-bordered" id="chain_transactions_table">
                            <thead>
                                <tr style="background-color:#b59dff">
                                    <th>Sl No.</th>
                                    <!-- <th>Reference Id</th> -->
                                    <th>Property Id</th>
                                    <th>Location</th>
                                    <th>Dag</th>
                                    <th>Date Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="loader" style="display:none;"></div>
    </div>
</div>
<div id="back_btn" class="row text-center" style="display:none;margin: 5px;">
    <div class="col-sm-12">
        <a href="" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back</a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#chain_transactions_table').DataTable({
            "ordering": false,
            "processing": true,
            language: {
                processing: '<div class="spinner-border text-primary" role="status"></div>',
            },
            "columns": [{
                    "render": function(data, type, row, meta) {

                        return meta.row + 1;
                    }
                },
                // {
                //     "data": "reference_id"
                // },
                {
                    "data": "property_id"
                },
                {
                    "data": "location",
                },
                {
                    "data": "dag",
                },
                {
                    "data": "datetime"
                },
                {
                    "data": "btns"
                }
            ],
            "ajax": {
                url: "<?php echo site_url("PropChainReport/getUserChainTransactions") ?>",
                type: 'POST',
                data: function(d) {},
                beforeSend: function() {},
                complete: function() {}
            },
        })
    })
</script>
<style>
    .spinner-grow {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        margin-top: -50px !important;
        margin-left: -50px !important;
    }

    #loader {
        position: fixed;
        z-index: 10;
        background: black;
        left: 0;
        top: 0;
        /* display: block; */
        opacity: .75;
        /* filter: alpha(opacity=75); */
        width: 100%;
        height: 100%;
    }
</style>