<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
document.onreadystatechange = function(e)
{
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });    
};
window.onload = function(){   
    $.unblockUI();
}
</script>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankDC/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Pending-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Pending-List) : District - <?php echo $this->utilityclass->getDistrictName($dist_code,); ?>, 
            </u>                        
        </h3>
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="landBank_pending_list_dt" class="table table-hover text-center" style="width:100%">            
                        <thead>                            
                            <tr>
                                <th>Circle
                                    <select class="form-control input_search" name="circle_vlb" id="circle_vlb" data-column-index="3">
                                      <option value="">--SELECT--</option>
                                      <?php if(isset($circleList)){ foreach($circleList as $circle){ ?>
                                          <option value="<?=$circle['subdiv_code']."-".$circle['cir_code']?>"><?=$circle['circleName']?></option>
                                      <?php }}?>
                                  </select>
                                </th>
                                <th>Village
                                    <select class="form-control input_search" name="village_vlb" id="village_vlb" data-column-index="4">
                                      <option value="">--SELECT--</option>
                                      <?php if(isset($villageList)){ foreach($villageList as $villageList){ ?>
                                                        
                                          <option value="<?=$villageList->village_uuid?>"><?=$this->utilityclass->getVillageNameByUUID($villageList->village_uuid);?></option>
                                      <?php }}?>
                                  </select>
                                </th>
                                <th>Dag-No
                                    <select class="form-control input_search" name="dags_vlb" id="dags_vlb" data-column-index="5">
                                          <option value="">--SELECT--</option>
                                          <?php if(isset($circleSubDivDagsArray)){ foreach($circleSubDivDagsArray as $dag){ ?>
                                                            
                                              <option value="<?=$dag->dag_no?>"><?=$dag->dag_no;?></option>
                                          <?php }}?>
                                      </select>
                                  </th>
                                <th>Created-By</th>
                                <th>Created-At</th>
                                <th>Action</th>
                                <th><button type="button" class="search_button btn btn-sm btn-danger form-control"><i class="fa fa-refresh"></i>
                                        Reset
                                    </button>   
                                </th>
                                
                                <th></th>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function load_data(subdiv_code,cir_code,village,dags_vlb)
        {
            var base_url = "<?php echo base_url();?>";
            table = $('#landBank_pending_list_dt').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/LandBankDC/viewPendingCasesDC',
                    type:'POST',
                    data: {
                        subdiv_code: subdiv_code,
                        cir_code: cir_code,
                        village_code:village,
                        dags : dags_vlb
                    },
                    deferLoading: 57,
                },
                success: function (data) {
                    console.log(data.village);
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4,],
                    }]
            });
            table.columns().every(function () {
                var table = this;
                //console.log(this.header());
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
                $('#landBank_pending_list_dt').DataTable().destroy();
                load_data();
            });
           
        }
    $(document).ready( function () {

    $('#circle_vlb, #village_vlb, #dags_vlb').change(function(){
            var subdiv_code = null;
            var cir_code = null;
            var circle_vlb = $('#circle_vlb').val();
            if(circle_vlb){
                var string = circle_vlb.split("-");
                    subdiv_code = string[0];
                    cir_code = string[1];
            }

            var village = $('#village_vlb').val();
            var dags_vlb = $('#dags_vlb').val();
            $('#landBank_pending_list_dt').DataTable().destroy();
            load_data(subdiv_code,cir_code,village,dags_vlb);
        });
        load_data();
        var table;
        $('#circle_vlb').on( 'click',function () {
            var html='<option value="">--SELECT--</option>';                                       
                $('#village_vlb').html(html);
        });
        $('#circle_vlb').on( 'change',function () {
            // var index = table.column( this ).index();
            // alert(index);
            var circle_vlb = $('#circle_vlb').val();
            if(circle_vlb){
                var string = circle_vlb.split("-");
                    subdiv_code = string[0];
                    cir_code = string[1];
                    $.ajax({
                        url: "<?php echo base_url();?>"+'index.php/LandBankDC/villageListDc',
                        type:'POST',
                        dataType: 'json',
                        data: {
                            subdiv_code: subdiv_code,
                            cir_code: cir_code,
                        },
                      success: function (data) {
                            //console.log(data);
                            var html='<option value="">--SELECT--</option>';
                            data.forEach((val) => {
                              //console.log({ val });
                              html = html + '<option value="'+val.village_uuid+'">'+val.loc_name+'</option>';
                            });
                            $('#village_vlb').html(html);
                        },
                      error: function (jqXHR, exception) {
                        alert('Error [#OMCS101]: Could not Complete your Request (AJAX ERROR)..!');
                        },
                    });
            }
        });
});
</script>
<!-- land bank details add modal  -->
<?php include 'lb_view_form.php'; ?>
<!-- land bank details co_remarks modal  -->
<?php include 'lb_co_remarks_form.php'; ?>
<!-- land bank approve remark modal  -->
<?php //include 'lb_approve_rmk_modal.php'; ?>
<!-- land bank revert remark modal  -->
<?php include 'lb_revert_rmk_modal.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/land_bank/land_bank_dc.js?v=<?php echo date('YmdHis'); ?>"></script>