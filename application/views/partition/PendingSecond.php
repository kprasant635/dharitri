<div class="container-fluid form-top login">
    <div class='row'>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <a href="<?=base_url().'index.php/home/PartitionCoOP'?>">
            <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
        </div>&nbsp;


        <div class='col-lg-12 panel panel-default' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                </div>
                <?php
            endif;

            if ($chithaupdatepending != 0) {
                $url = base_url() . "index.php/partition/MapPartitionUpdate";
                echo "<span class='red uni_text'>Important Note : You have " . $chithaupdatepending . " number(s) pending case for Chitha Updation. Please Complete chitha update process before proceeding next case(s). </span>";
                echo "<a href='$url' class='green btn btn-danger uni_text'>Please Clck Here to update chitha. </a>";
            }
            ?>

            <!-- <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="status_type">Status Type</label>
                        <select name="status_type" id="status_type" class="form-select">
                            <?php
                                $statuses = json_decode(PARTION_STATUS_TYPES, true);
                            ?>
                            <?php foreach($statuses as $value => $label): ?>
                                <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div> -->

            <table id="example" class="table table-striped" width="100%">
                <thead >

                    <tr >
                        <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                        <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                        <th><?php echo $this->lang->line('location'); ?>
                            <select class="form-control" name="mouza_lot" id="mouza_lot_second">
                                <option value="">--SELECT--</option>
                                <?php if(isset($newMouzaList)){ foreach($newMouzaList as $newMouzaList){ ?>
                                    
                                <option value="<?=$newMouzaList['mouza_code']."-".$newMouzaList['lot_no'];?>"><?=$newMouzaList['mouza_name']."-".$newMouzaList['lot_name'];?></option>
                                <?php }}?>
                            </select>
                        </th>
                        <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('status') ?>
                            <select name="status_type" id="status_type" class="form-select">
                                <?php
                                    $statuses = json_decode(PARTION_STATUS_TYPES, true);
                                ?>
                                <?php foreach($statuses as $value => $label): ?>
                                    <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </th>

                    </tr>
                </thead>
                

                <tbody>
                   
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php if(ESCALATION_ENABLE == 1){?>
<script type="text/javascript">
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
            $('#example').DataTable().destroy();
            load_data_second(mouza_code,lot_no,zone_status,status_type);
        });  
        load_data_second();
        function load_data_second(mouza_code,lot_no,zone_status,status_type){
            $('#example thead th:nth-of-type(3)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
              var dataTable = $('#example').DataTable({  
                   "processing":true,  
                   "serverSide":true,  
                   // "order":[],  
                    "ordering": false,
                   "ajax":{  
                        url:"<?php echo base_url() . 'index.php/DataTableController/OfficePartSecondProceeding'; ?>", 
                        type:"POST",
                        data: {
                            mouza_code  : mouza_code,
                            lot_no      : lot_no,
                            zone_status : zone_status,
                            status_type : status_type,

                        }, 
                   },  
                   "columnDefs":[  
                        {  
                             "targets":[0, 3, 4],  
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
 </script>
<?php }else { ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mouza_lot_second, #status_type').change(function(){
            var mouza_code = null;
            var lot_no = null;
            var mouzaLot = $('#mouza_lot_second').val();
            var status_type = $('#status_type').val();
            if(mouzaLot){
                var string = mouzaLot.split("-");
                mouza_code = string[0];
                    lot_no = string[1];
            }
            $('#example').DataTable().destroy();
            load_data_second(mouza_code,lot_no,status_type);
        });  
        load_data_second();
        function load_data_second(mouza_code,lot_no,status_type){
            $('#example thead th:nth-of-type(1)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
            });
              var dataTable = $('#example').DataTable({  
                   "processing":true,  
                   "serverSide":true,  
                   // "order":[],  
                    "ordering": false,
                   "ajax":{  
                        url:"<?php echo base_url() . 'index.php/DataTableController/OfficePartSecondProceeding'; ?>", 
                        type:"POST",
                        data: {
                            mouza_code  : mouza_code,
                            lot_no      : lot_no,
                            zone_status : null,
                            status_type : status_type,
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
 </script>
 	<?php } ?>
