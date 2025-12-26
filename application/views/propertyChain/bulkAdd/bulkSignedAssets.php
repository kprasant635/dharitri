<div class="container-fluid form-top login" id="show-prop-report">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="bg-secondary text-white p-2 h4 text-center font-weight-bold shadow-lg">                
                PROPERTY CHAIN ASSETS STATUS
            </div>
            <div class="bg-dark text-white p-2 h6 text-center font-weight-bold shadow-lg" style="margin-top:-10px;">                
                DISTRICT:<?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?>, 
                SUB-DIVISION:<?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'))?>, 
                CIRCLE:<?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'))?>
            </div>
            <div class="bg-warning text-white p-2 h6 text-center font-weight-bold shadow-lg" style="margin-top:-10px;">                
                NOTE: EXCEPT ROR AND MAP CASES, OTHER PENDING AND FAILED ASSETS CAN BE RESEND TO PROPERTY CHAIN AFTER DIGITAL SIGNING
            </div>
            <div class="row" style="margin-top:-10px;">
                <div class="col-lg-12">
                    <div class="panel panel-info panel-form">
                        <div class="panel-body shadow-lg">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4 text-center">
                                    <form action="#" class="text-center" name="signed_assets_form" id="signed_assets_form">                                        
                                        <select class="form-control text-center" name="asset_status" id="asset_status">
                                            <option value="" selected>--SELECT-STATUS--</option>
                                            <option value="All">All</option>
                                            <option value="Y">Success</option>
                                            <option value="N">Pending</option>
                                            <option value="DSC">Pending Digital Signature</option>
                                            <option value="F">Failed</option>
                                        </select>
                                    </form>
                                    <button id="get_dag_btn" class="form-group mb-2 btn btn-sm btn-primary mt-2" onclick="return getSignedAssets();"><i class="fa fa-arrow-circle-right"></i> GET ASSETS</button>    
                                </div>
                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="dags_table">
                <div class="col-lg-12">
                    <div class="panel panel-info panel-form">
                        <div class="panel-body">
                            <table class="table table-bordered" id="signed_assets_table">
                                <thead>
                                    <tr style="background-color:#b59dff">
                                        <th>Sl No.</th>
                                        <th>Case No / Reference id</th>
                                        <th>Property Chain<br>Update Status</th>
                                        <th>Asset Creation Time</th>
                                        <th>Property Chain<br>Update Datetime</th>
                                        <th>Asset-Sign</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getSignedAssets() {
        if($('#asset_status').val() == ""){
            return;
        }

        var table2 = $('#signed_assets_table').DataTable({
            "destroy": true,
            "ordering": false,
            "processing": true,
            // bFilter: false,
            // bInfo: false,
            language: {
                processing: '<div class="spinner-border text-primary" role="status"></div>',
            },
            "pageLength": 10,
            lengthMenu: [
                [10, 20, 50, 100],
                [10, 20, 50, 100],
            ],
            // "serverSide": true,
            "columns": [
                // {
                //     "data": "select"
                // },
                {
                    "render": function(data, type, row, meta) {

                        // return meta.row + 1;
                        return meta.row + (meta.settings._iDisplayStart || 0) + 1
                    }
                },
                {
                    "data": "case_no"
                },
                {
                    "data": "status"
                },
                {
                    "data": "signed_datetime"
                },
                {
                    "data": "chain_update_time"
                },
                {
                    "data": "asset_sign_button"
                }
            ],
            "ajax": {
                url: "<?php echo site_url("PropChainReport/getSignedAssets") ?>",
                type: 'POST',
                data: function(d) {
                    d.status = $('#asset_status').val();
                },
                beforeSend: function() {},
                complete: function() {}
            },
        })
    }
</script>
<style>
    .disabled {
        cursor: not-allowed;
    }
</style>