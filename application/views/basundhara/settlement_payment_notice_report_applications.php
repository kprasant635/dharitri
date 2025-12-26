
                    <h5 style="border-bottom:5px solid #ff681d">Application List for the District: <?=$dist_name?> ,Subdivision : <?=$subdiv_name;?>, Circle: <?=$circle_name?></h5>
                    <a href="<?=base_url().'index.php/basundhara2/downloadPaymentNoticeReport?paymentStatus=M&dist_code='.$dist_code.'&subdiv_code='.$subdiv_code.'&cir_code='.$cir_code?>" class="btn btn-primary" ><i class="fa fa-download"></i> Download Pending Payment Notice Report</a>
                    <a href="<?=base_url().'index.php/basundhara2/downloadPaymentNoticeReport?paymentStatus=N&dist_code='.$dist_code.'&subdiv_code='.$subdiv_code.'&cir_code='.$cir_code?>" class="btn btn-warning" ><i class="fa fa-download"></i> Download Payment Notice Generated Report</a>
                    <a href="<?=base_url().'index.php/basundhara2/downloadPaymentNoticeReport?paymentStatus=G&dist_code='.$dist_code.'&subdiv_code='.$subdiv_code.'&cir_code='.$cir_code?>" class="btn btn-success" ><i class="fa fa-download"></i> Download Payment Done Report</a>
                    <a href="<?=base_url().'index.php/basundhara2/downloadPaymentNoticeReport?paymentStatus=U&dist_code='.$dist_code.'&subdiv_code='.$subdiv_code.'&cir_code='.$cir_code?>" class="btn btn-danger" ><i class="fa fa-download"></i> Download Pending Payment Report</a>
              
                        <div class="table-responsive">
                            <input type="hidden" name="dist_code" id="dist_code" value="<?=$dist_code?>">
                            <input type="hidden" name="subdiv_code"  id="subdiv_code" value="<?=$subdiv_code?>">
                            <input type="hidden" name="cir_code" id="cir_code"  value="<?=$cir_code?>">
                            <div class="table-responsive">
                                <table id="datatable" class="datatable table table-stripped">  
                                    <thead>  
                                        <tr>  
                                 
                                            <th></th>
                                            <th></th>
                                            <th>Mouza</th>
                                            <th>Lot</th>
                                            <th>Village</th> 
                                            <th>Payment Notice Status
                                                <select class="form-select"  id="paymentStatus" name="paymentStatus">
                                                    <option value="">--SELECT--</option>
                                                    <option value="M">Pending</option>
                                                    <option value="N">Notice Generated</option>
                                                    <option value="G">Payment Done</option>
                                                </select>
                                            </th> 
                                            <th>Submission Date<button type="button" class="search_button btn btn-sm btn-success form-control">
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
                        </div>
                       

<script>
    $(document).ready(function ()
    {

        $(document).on('change', '#paymentStatus', function(){
            $('#datatable').DataTable().destroy();
            var paymentStatus = $('#paymentStatus').val();
            load_data(paymentStatus);

        });
        load_data();   

        function load_data(paymentStatus = null)
        {

            var base_url = "<?php echo base_url();?>";
            
            $('#datatable thead th:nth-of-type(1)').each(function () {

                var title = 'Case No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {

                var title = 'Application No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="2" />');
            });
            
            var table = $('#datatable').DataTable({
                dom: 'Bfrtip',
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
                    url: base_url+'index.php/Basundhara2/getListofPaymentNoticeCases',
                    type:'POST',
                    data: {
                        paymentStatus : paymentStatus,
                        dist_code : $('#dist_code').val(),
                        subdiv_code :  $('#subdiv_code').val(),
                        cir_code :  $('#cir_code').val(),
                    },
                    deferLoading: 57,
                },


                // order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5,6],
                }],
                // columnDefs: [{
                //   targets: 0,
                //   data: "is_visible",
                
                // }],
                
                    
            });

           
            $('.search_button').on('click', function () {            
                $('table thead tr th .input_search').each(function(){ 
                    table.column($(this).data('columnIndex')).search(this.value);
                });
                table.draw();
            });
        }
        
    });
            


