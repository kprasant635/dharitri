<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">Reclassification Cases For First Proceeding
                    </h2>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <a href="<?=base_url().'index.php/home/LandReLm'?>">
                <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
            </div>&nbsp;
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                       
                            <table class='table table-striped table-bordered' id='PendingReclassCases' width="100%">
                                <thead>

                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                   
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


                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label>
                                <button type="button" class="search_button btn btn-sm btn-danger form-control"><i class="fa fa-refresh"></i>
                                        Reset Search
                                    </button> 
                                </th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                              
                            </table>
                            
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

 <script type="text/javascript">
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

            $('#PendingReclassCases').DataTable().destroy();
            load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,zone_status);
        });
        load_data();
        function load_data(mouza_code,lot_no,vill_mouza_code,vill_lot_no,village_code,zone_status)
        {
            $('#PendingReclassCases thead th:nth-of-type(3)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
            var base_url = "<?php echo base_url();?>";
            var table = $('#PendingReclassCases').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/LandReclassification/getPendingReclassLMend',
                    type:'POST',
                    data: {
                        // mouza_code:mouza_code,
                        // lot_no:lot_no,
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
                $('#PendingReclassCases').DataTable().destroy();
                load_data();
            });
        }
});

</script>
