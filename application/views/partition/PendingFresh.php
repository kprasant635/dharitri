<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-12 panel panel-default' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                </div>
            <?php endif; ?>
            <table id="example" class="table table-hover  panel-body" width="100%">
                <thead >

                    <tr >
                        <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                        <th class="alert-info"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="center"><label class="control-label"> Mouza/Lot no</label>
                            <select class="form-control input_search" name="mouza_lot" id="mouza_lot" data-column-index="2">
                              <option value="">--SELECT--</option>
                              <?php if(isset($newMouzaList)){ foreach($newMouzaList as $newMouzaList){ ?>
                                                
                                 <option value="<?=$newMouzaList['mouza_code']."-".$newMouzaList['lot_no'];?>"><?=$newMouzaList['mouza_name']."-".$newMouzaList['lot_name'];?></option>
                              <?php }}?>
                          </select></th>
                        <th class="center"><label class="control-label"> Village </label>
                            <select class="form-control input_search" name="village_om" id="village_om" data-column-index="3">
                                  <option value="">--SELECT--</option>
                                  <?php if(isset($villageListNew)){ foreach($villageListNew as $villageList){ ?>
                                                    
                                       <option value="<?=$villageList['village_code']?>"><?=$villageList['vill_name'];?></option>
                                  <?php }}?>
                              </select>
                          </th>
                        <th class="alert-info"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('status') ?></th>

                    </tr>
                </thead>

                <tbody>
                    
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- property chain modal -->
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>
<!--  -->
<script>
// $(document).ready(function() {
//     $('#example').DataTable({
// 	"bLengthChange": false,
// 	"showNEntries" : false,
// 	"bSort" :	false,
// 	"bInfo" :	false,
// 	"pageLength": 20
//   });
  
// });
	<?php if(ESCALATION_ENABLE == 1){ ?>
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

            $('#example').DataTable().destroy();
            load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,zone_status);
        });
        load_data();
        function load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,zone_status)
        {
            $('#example thead th:nth-of-type(3)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
            var base_url = "<?php echo base_url();?>";
            var table = $('#example').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/Partition/getPendingOfficePartCaseCOend',
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
                $('#example').DataTable().destroy();
                load_data();
            });
        }
    });
	<?php } else {?>
   $(document).ready( function () {
    $('#mouza_lot, #village_om').change(function(){
            var mouza_code = null;
            var lot_no = null;
            var village_code = null;
            var vill_mouza_code = null;
            var vill_lot_no = null;
            var mouzaLot = $('#mouza_lot').val();
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

            $('#example').DataTable().destroy();
            load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code);
        });
        load_data();
        function load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code)
        {
            $('#example thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
            var base_url = "<?php echo base_url();?>";
            var table = $('#example').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/Partition/getPendingOfficePartCaseCOend',
                    type:'POST',
                    data: {
                        mouza_code:mouza_code,
                        lot_no:lot_no,
                        vill_mouza_code:vill_mouza_code,
                        vill_lot_no:vill_lot_no,
                        village_code:village_code,
                        zone_status : null
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
                $('#example').DataTable().destroy();
                load_data();
            });
        }
});

	<?php } ?>
    </script> 
