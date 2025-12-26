<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login" id="show-prop-report">
    <div class="row">
        <div class="col-lg-12">
            <div class="bg-secondary text-white p-2 h4 text-center font-weight-bold shadow-lg">                
                DIGITAL SIGNING OF PROPERTY CHAIN ASSETS
            </div>
            <div class="bg-dark text-white p-2 h6 text-center font-weight-bold shadow-lg" style="margin-top:-10px;">                
                DISTRICT:<?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?>, 
                SUB-DIVISION:<?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'))?>, 
                CIRCLE:<?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'))?>
            </div>
            <div class="row">
                <div class="col-lg-12" style="margin-top:-10px;">
                    <div class="panel panel-info panel-form">
                        <div class="panel-body shadow-lg">                            
                            <form action="#" class="form-inline" name="village_form" id="village_form">                                
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="village">Select Mouza:</label>
                                        </div>
                                        <div class="form-group mb-2">
                                            <select name="" id="mouza_code" class="form-control" onchange=getLot()>
                                                <option value="">--SELECT-MOUZA--</option>
                                                <?php foreach ($mouza_list as $mouza):?>
                                                    <option value=<?=$mouza->mouza_pargona_code?>><?=$mouza->loc_name?></option>
                                                <?php endforeach;?>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="village">Select Lot:</label>
                                        </div><br>
                                        <div class="form-group mb-2">
                                            <select name="" id="lot_no" class="form-control" onchange=getVillageList()>
                                                <option value="">--SELECT-LOT--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="village">Select Village:</label>
                                        </div>
                                        <div class="form-group mb-2">
                                            <select name="" id="village" class="form-control" onchange=getPattaType()>
                                                <option value="">--SELECT-VILLAGE--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="village">Select Patta-Type:</label>
                                        </div>
                                        <div class="form-group mb-2">
                                            <select name="" id="patta_type" class="form-control">
                                                <option value="">--SELECT-PATTA-TYPE--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                            </form>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-md-4 text-center"></div>
                                <div class="col-md-4" align="center">
                                    <button id="get_dag_btn" class="btn btn-sm btn-primary" onclick="return getDags();" style="display:block;"><i class="fa fa-arrow-circle-right"></i> Fetch Dags</button>
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
                            <div id="location_details"></div>
                            <table class="table table-bordered" id="asset_create_table">
                                <thead>
                                    <tr style="background-color:#b59dff">
                                        <!-- <th><input type="checkbox" name="check_all" id="check_all"> Select all</th> -->
                                        <th>Sl No.</th>
                                        <th>Dag No</th>
                                        <th>Ulpin Found</th>
                                        <th>Action</th>
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

    function getPattaType(){
        $('#patta_type').empty();
        $('#patta_type').append('<option value="">--SELECT-PATTA-TYPE--</option>');        
        $.ajax({
            url: baseurl + "PropChainReport/getPattaTypes",
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBoxEK'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {      
                $.unblockUI();
                console.log(data);
                for(var i=0; i<data.length; i++) {
                    $('#patta_type').append('<option value="'+data[i].type_code+'">'+data[i].patta_type+'</option>');
                }        
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });
    }

    function getVillageList(){
        $('#patta_type').empty();
        $('#patta_type').append('<option value="">--SELECT-PATTA-TYPE--</option>');
        $('#village').empty();
        $('#village').append('<option value="">--SELECT-VILLAGE--</option>');
        var mouza_code = $('#mouza_code').val();
        var lot_no = $('#lot_no').val();
        $.ajax({
            url: baseurl + "PropChainReport/getVillageList",
            type: 'POST',
            data: {'mouza_code' : mouza_code, 'lot_no' : lot_no},
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBoxEK'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {      
                $.unblockUI();
                console.log(data);
                for(var i=0; i<data.length; i++) {
                    $('#village').append('<option value="'+data[i].vill_townprt_code+'">'+data[i].loc_name+'</option>');
                }        
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });
    }                                               

    function getLot(){
        $('#patta_type').empty();
        $('#patta_type').append('<option value="">--SELECT-PATTA-TYPE--</option>');
        $('#lot_no').empty();
        $('#lot_no').append('<option value="">--SELECT-LOT--</option>');
        $('#village').empty();
        $('#village').append('<option value="">--SELECT-VILLAGE--</option>');
        var mouza_code = $('#mouza_code').val();
        $.ajax({
            url: baseurl + "PropChainReport/getLotList",
            type: 'POST',
            data: {'mouza_code' : mouza_code},
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBoxEK'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {      
                $.unblockUI();
                console.log(data);
                for(var i=0; i<data.length; i++) {
                    $('#lot_no').append('<option value="'+data[i].lot_no+'">'+data[i].loc_name+'</option>');
                }        
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });
    }

    function getDags() {
        var mouza_code = $('#mouza_code').val();
        var lot_no = $('#lot_no').val();
        var village_code = $('#village').val();;
        var patta_type = $('#patta_type').val();

        if(mouza_code=="" || lot_no=="" || village_code=="" || patta_type == ""){
            alert("Please Select The Location Properly..!!");
            return;
        }

        var table = $('#asset_create_table').DataTable({
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
                [10, 20],
                [10, 20],
            ],
            "serverSide": true,
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
                    "data": "dag_no"
                },
                {
                    "data": "ulpin_status"
                },
                {
                    "data": "btn"
                }
            ],
            "ajax": {
                url: "<?php echo site_url("PropChainReport/getAssetToPc") ?>",
                type: 'POST',
                data: {'mouza_code':mouza_code, 'lot_no':lot_no, 'village_code':village_code, 'patta_type':patta_type},
                beforeSend: function() {},
                complete: function(data) {                    
                    // var html;
                    // html = '<h4 class="text-dark">Dags for location: ' + mouza_name + ', ' + lot + ', ' + village_name + '</h4>';
                    // $("#location_details").empty().append(html);
                    locationName();
                }
            },
        })
    }

    function locationName() {
        // var location_name = $('#village').attr('data-location');
        var element = document.getElementById('village');
        var location_name = element.options[element.selectedIndex].getAttribute("data-location")

        var html;
        if (location_name == null)
            $("#location_details").empty()
        else
            html = '<h4 class="text-dark">Dags for location: ' + location_name + '</h4>';
        $("#location_details").empty().append(html);
    }
</script>
<style>
    .disabled {
        cursor: not-allowed;
    }
</style>