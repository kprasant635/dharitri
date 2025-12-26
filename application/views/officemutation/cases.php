<style type="text/css">
  .table_div_responsive {
    overflow-y: scroll;
  }
</style>

<div class="container-fluid form-top login">

    <?php //include(APPPATH."views/common/audio.php"); ?>
    
    <div class="row">
        <div class="error_container">
                        <?php
                            if($this->session->flashdata('message')){
                        ?>
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($proceeding_id == '1') {
                            echo "Office Mutation Cases For First Proceeding";
                        } elseif ($proceeding_id == '2') {
                            echo "Office Mutation Cases For Second Proceeding";
                        }
                        ?>
                    </h2>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <a href="<?=base_url().'index.php/home/MutationCoOM'?>">
                <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
            </div>&nbsp;
            
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body table_div_responsive">
                        <?php
                        if ($proceeding_id == '1') {
                            ?>
                            <table class='table table-striped table-bordered' id='PendingOFMcases'>
                                <thead>                                  

                                  <?php if(ESCALATION_ENABLE==1){ include(APPPATH."views/common/esc_table_head.php");} ?>

                                  <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label>
                                  </th>
                                  
                                  <th class="center"><label class="control-label"> Mouza/Lot no</label>
                                    <select class="form-control input_search" name="mouza_lot" id="mouza_lot" data-column-index="2">
                                        <option value="">--SELECT--</option>
                                        <?php if(isset($newMouzaList)){ foreach($newMouzaList as $newMouzaList){ ?>
                                                          
                                           <option value="<?=$newMouzaList['mouza_code']."-".$newMouzaList['lot_no'];?>"><?=$newMouzaList['mouza_name']."-".$newMouzaList['lot_name'];?></option>
                                        <?php }}?>
                                    </select>
                                  </th>

                                  <th class="center"><label class="control-label"> Village </label>
                                      <select class="form-control input_search" name="village_om" id="village_om" data-column-index="3">
                                            <option value="">--SELECT--</option>
                                            <?php if(isset($villageListNew)){ foreach($villageListNew as $villageList){ ?>
                                                              
                                                 <option value="<?=$villageList['village_code']?>"><?=$villageList['vill_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </th>

                                  <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label>
                                  </th>
                                  
                                  <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label>
                                    <button type="button" class="search_button btn btn-sm btn-danger form-control"><i class="fa fa-refresh"></i>Reset Search</button> 
                                  </th>
                                </thead>

                                <tbody>                                    
                                </tbody>
                              
                            </table>
                            <?php
                        } elseif ($proceeding_id == '2') {
                            ?>

                            <div class="form-group">
                                <!-- <div class="row">
                                    <div class="col-md-4">
                                        <label for="status_type">Status Type</label>
                                        <select name="status_type" id="status_type" class="form-select">
                                            <?php
                                                $statuses = json_decode(MUTATION_STATUS_TYPES, true);
                                            ?>
                                            <?php foreach($statuses as $value => $label): ?>
                                                <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                            <table id="user_data" class="table table-bordered table-striped">  
                              <thead>  
                                <tr>
                                  <?php if(ESCALATION_ENABLE==1){ include(APPPATH."views/common/esc_table_head.php");} ?>
                                  <th><?php echo $this->lang->line('case_no'); ?></th>
                                  <th><?php echo $this->lang->line('location'); ?>
                                    <select class="form-control" name="mouza_lot" id="mouza_lot_second">
                                      <option value="">--SELECT--</option>
                                      <?php if(isset($newMouzaList)){ foreach($newMouzaList as $newMouzaList) { ?>                                     
                                        <option value="<?=$newMouzaList['mouza_code']."-".$newMouzaList['lot_no'];?>"><?=$newMouzaList['mouza_name']."-".$newMouzaList['lot_name'];?></option>
                                      <?php }} ?>
                                    </select>
                                  </th>
                                  <th><?php echo $this->lang->line('submission_date'); ?></th>
                                  <th><?php echo $this->lang->line('status'); ?>
                                    <select name="status_type" id="status_type" class="form-select">
                                        <?php
                                            $statuses = json_decode(MUTATION_STATUS_TYPES, true);
                                        ?>
                                        <?php foreach($statuses as $value => $label): ?>
                                            <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </th> 
                                </tr>  
                              </thead>  
                           </table>
                            <?php
                        }
                        ?>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="mut_type" id="mut_type" value="<?= MUT_TYPE_OFFMUT ?>">
<!-- modal for property chain report -->
<div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>
<!--  -->
<script type="text/javascript" language="javascript" >  

<?php if (ESCALATION_ENABLE == 1) { ?>
    $(document).ready(function(){
        $('#mouza_lot_second, #zone_status, #status_type').change(function(){
            var mouza_code = null;
            var lot_no = null;
            var mouzaLot = $('#mouza_lot_second').val();
            var zone_status = $('#zone_status').val();
            var status_type = $('#status_type').val();
            if(mouzaLot){
                var string = mouzaLot.split("-");
                mouza_code = string[0];
                    lot_no = string[1];
            }
            $('#user_data').DataTable().destroy();
            load_data_second(mouza_code,lot_no, zone_status, status_type);
        });  
        load_data_second();
        function load_data_second(mouza_code,lot_no, zone_status, status_type){
            $('#user_data thead th:nth-of-type(3)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
              var dataTable = $('#user_data').DataTable({  
                   "processing":true,  
                   "serverSide":true,  
                   // "order":[],  
                    "ordering": false,
                   "ajax":{  
                        url:"<?php echo base_url() . 'index.php/DataTableController/OmutCoSecondProceedingES'; ?>", 
                        type:"POST",
                        data: {
                            mouza_code:mouza_code,
                            lot_no:lot_no,
                            zone_status:zone_status,
                            status_type:status_type,
                        }, 
                   },  
                   "columnDefs":[  
                        {  
                             //"targets":[0, 3, 4],  
                             "orderable":false,  
                        },  
                   ],  
              });
              dataTable.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
        }  
      
    });  

    $(document).ready( function () {
        $('#mouza_lot, #village_om, #zone_status').change(function(){
            var mouza_code = null;
            var lot_no = null;
            var village_code = null;
            var vill_mouza_code = null;
            var vill_lot_no = null;
            var mouzaLot = $('#mouza_lot').val();
            var zone_status = $('#zone_status').val();
            if(mouzaLot){
                var string = mouzaLot.split("-");
                mouza_code = string[0];
                    lot_no = string[1];
            }
            var village = $('#village_om').val();
            if(village){
                var string1 = village.split("-");
                vill_mouza_code = string1[0];
                    vill_lot_no = string1[1];
                    village_code = string1[2];
            }

            $('#PendingOFMcases').DataTable().destroy();
            load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,zone_status);
        });
        load_data();
        function load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,zone_status)
        {
            $('#PendingOFMcases thead th:nth-of-type(3)').each(function () {
              var title = $(this).text();
              $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
            var base_url = "<?php echo base_url();?>";
            var table = $('#PendingOFMcases').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/coofficemutation/getPendingMutationCasesCOEnd',
                    type:'POST',
                    data: {
                        mouza_code:mouza_code,
                        lot_no:lot_no,
                        vill_mouza_code:vill_mouza_code,
                        vill_lot_no:vill_lot_no,
                        village_code:village_code,
                        zone_status:zone_status,
                    },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
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
            
            // button search
            $('.search_button').on('click', function () {
                $('table thead tr th .input_search').each(function(){
                    $(this).val('');
                     // table.column($(this).data('columnIndex')).search('');
                });
                // $('#dataTable1').DataTable().search().draw();
                //table.draw();
                $('#PendingOFMcases').DataTable().destroy();
                load_data();
            });
        }
    });
<?php } ?>

<?php if(ESCALATION_ENABLE == 0){ ?>
    $(document).ready(function(){
        $('#mouza_lot_second').change(function(){
            var mouza_code = null;
            var lot_no = null;
            var mouzaLot = $('#mouza_lot_second').val();
            if(mouzaLot){
                var string = mouzaLot.split("-");
                mouza_code = string[0];
                    lot_no = string[1];
            }
            $('#user_data').DataTable().destroy();
            load_data_second(mouza_code,lot_no);
        });  
        load_data_second();
        function load_data_second(mouza_code,lot_no){
            $('#user_data thead th:nth-of-type(1)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
              var dataTable = $('#user_data').DataTable({  
                   "processing":true,  
                   "serverSide":true,  
                   // "order":[],  
                    "ordering": false,
                   "ajax":{  
                        url:"<?php echo base_url() . 'index.php/DataTableController/OmutCoSecondProceeding'; ?>", 
                        type:"POST",
                        data: {
                            mouza_code:mouza_code,
                            lot_no:lot_no,
                            zone_status:null,
                        }, 
                   },  
                   "columnDefs":[  
                        {  
                             //"targets":[0, 3, 4],  
                             "orderable":false,  
                        },  
                   ],  
              });
              dataTable.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
        }  
      
    });  

    $(document).ready( function () {
        $('#mouza_lot, #village_om').change(function(){
            var mouza_code = null;
            var lot_no = null;
            var village_code = null;
            var vill_mouza_code = null;
            var vill_lot_no = null;
            var mouzaLot = $('#mouza_lot').val();
            // var zone_status = $('#zone_status').val();
            if(mouzaLot){
                var string = mouzaLot.split("-");
                mouza_code = string[0];
                    lot_no = string[1];
            }
            var village = $('#village_om').val();
            if(village){
                var string1 = village.split("-");
                vill_mouza_code = string1[0];
                    vill_lot_no = string1[1];
                    village_code = string1[2];
            }

            $('#PendingOFMcases').DataTable().destroy();
            load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code);
        });
        load_data();
        function load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code)
        {
            // $('#PendingOFMcases thead th:nth-of-type(3)').each(function () {
            //   var title = $(this).text();
            //   $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            // });
            var base_url = "<?php echo base_url();?>";
            var table = $('#PendingOFMcases').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/coofficemutation/getPendingMutationCasesCOEnd',
                    type:'POST',
                    data: {
                        mouza_code:mouza_code,
                        lot_no:lot_no,
                        vill_mouza_code:vill_mouza_code,
                        vill_lot_no:vill_lot_no,
                        village_code:village_code,
                        zone_status:null,
                    },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4],
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
            
            // button search
            $('.search_button').on('click', function () {
                $('table thead tr th .input_search').each(function(){
                    $(this).val('');
                     // table.column($(this).data('columnIndex')).search('');
                });
                // $('#dataTable1').DataTable().search().draw();
                //table.draw();
                $('#PendingOFMcases').DataTable().destroy();
                load_data();
            });
        }
    });
<?php } ?>



                // property chain modal

        $('.panel').on('click', '.chainReportOffice', function(e) {
            e.preventDefault();
            // console.log($(this).attr("case_no"))
            case_no = $(this).attr("case_no");
            dist_code = $(this).attr("dist_code");
            subdiv_code = $(this).attr("subdiv_code");
            circle_code = $(this).attr("cir_code");
            mouza_code = $(this).attr("mouza_pargona_code");
            lot_no = $(this).attr("lot_no");
            vill_code = $(this).attr("vill_townprt_code");
            $('#myModal .modal-content').empty().html(
                '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div><br><p class="text-primary text-center">....Fetching Data From Property Chain. Please Wait....</p>');
            $.ajax({
                url: baseurl + "PropChainReport/getCaseData",
                data: {
                    case_no: $(this).attr("case_no"),
                    vill_code: $(this).attr("vill_townprt_code"),
                    mut_type: $('#mut_type').val()
                },
                type: 'post',
                success: function(data1) {
                    console.log(data1)
                    var obj = JSON.parse(data1)
                    var dag_no = obj.dag_no;
                    var patta_code = obj.patta_no;
                    $.ajax({
                        url: baseurl + "PropChainReport/getPropChainData",
                        type: 'post',
                        data: {
                            case_no: case_no,
                            dist_code: dist_code,
                            subdiv_code: subdiv_code,
                            circle_code: circle_code,
                            mouza_code: mouza_code,
                            // mouza_code: '02',
                            lot_no: lot_no,
                            // lot_no: '01',
                            vill_code: vill_code,
                            // vill_code: '10004',
                            patta_code: patta_code,
                            // patta_code: '0201',
                            dag_no: dag_no,
                            // dag_no: '1',
                        },
                        success: function(data2) {
                            var object = JSON.parse(data2);
                            console.log(object);
                            if (object.result === 0) {
                                console.log('abc');
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center">' + object.error_msg + '</h1>');
                                $('#myModal').modal();
                            } else if (object.result === 1) {
                                var property_data = object.property_data
                                var transaction_data = object.transaction_data

                                console.log(property_data);
                                $.ajax({
                                    url: baseurl + "PropChainReport/generatePropertyChain",
                                    method: 'post',
                                    data: {
                                        property_data: property_data,
                                        transaction_data: transaction_data
                                    },
                                    dataType: 'html',
                                    success: function(data3) {
                                        $('#myModal .modal-content').html(data3);
                                        $('#myModal').modal();
                                    }
                                });
                            } else {
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center"><i class="fa fa-warning"></i>Unable to connect to property chain</h1>');
                                $('#myModal').modal();
                            }

                        }
                    });
                }
            })
        });

        $('#myModal').on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
            $('.modal-content').css('background-color', 'white');
            $('.modal-content').css('color', 'black');
        });

</script>
