<center>
    
    <mark>
        Application Received in Basundhara 
    </mark>
        
    <br>
    <mark>
        <strong style="font-size: 20px;">
            <?php
                echo "Settlement Occupancy Tenant Notice Generated Cases";
            ?>
        </strong>
    </mark>
    
</center>
<style>
    #button{
        display:block;
        margin:20px auto;
        padding:10px 30px;
        background-color:#eee;
        border:solid #ccc 1px;
        cursor: pointer;
    }
    #overlay{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
    .is-hide{
        display:none;
    }
</style>
<style type="text/css">
    .checkBoxD{
        width: 20px;
        height: 20px;
    }
</style>
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<form id="co_bulk_notice" method="post">
    <table class="datatable table table-stripped" id='datatable'>
        <thead style="font-size:7px">
            <tr>
                <th>All <input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                <th></th>
                <th></th>
                <th>
                    Flagged in Chitha
                </th>
                <th>Name 
                    <select class="form-control input_search" name="category" id="category" data-column-index="4">
                        <option value="">select</option>
                        <?php if(isset($select_data)){ foreach($select_data as $vill){
                            ?>
                            <option value="<?=$vill->vill_townprt_code?>"><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_pargona_code, $vill->lot_no, $vill->vill_townprt_code)?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>
                    <!-- Action -->
                    <button type="button" class="search_button btn btn-sm btn-success form-control">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        Search
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


    <div class="row pt-2">
        <div class="form-group">

            <input type="hidden" class="form-control" autocomplete="off" name="remark" value="Forwarded to ADC for hearing" required>

            <label class="col-sm-7 text-left" style=" font-size: 18px; color:#ff681d"><i class="fa fa-hand-o-right"></i> Click on checkboxes to send multiple cases to ADC for Hearing</label>
            <hr>
            <select class="col-sm-3 pl-5 form-control" name="send_adc_to" id="send_adc_to">
                <option value="">Please select ADC...</option>
                <?php foreach($adcList as $list) 
                {
                ?>
                    <option value="<?=$list->user_code?>"><?=$list->username?></option>
                <?php 
                }
                ?>
            </select>

            <div class="col-sm-3 pl-5">
                <button type="submit" name="generate_notice" formtarget="GenerateNotice" class=" text-white btn btn-success btn-sm" onclick="return coForm()">Forwared to ADC</button>
            </div>
        </div>
        <div class="form-group">
            <span id="error_hear"></span>
            <ul class="caselist">
                
            </ul>
        </div>
        
    </div>
</form>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>

<script>
    $(document).ready(function ()
    {
        $('#rural, #category, #occupation').change(function(){
            var rural = $('#rural').val();
            var category = $('#category').val();
            var occupation = $('#occupation').val();
            $('#datatable').DataTable().destroy();

            load_data(category,rural,occupation);
    
        });

        load_data();

        function load_data(category,rural,occupation)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = <?=SETTLEMENT_TENANT_URBAN_ID?>;

            $('#datatable thead th:nth-of-type(2)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
                var title = 'Application No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
            });

            $('#datatable thead th:nth-of-type(3)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
                var title = 'Application Date';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
            });
            
            var table = $('#datatable').DataTable({
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
                    url: base_url+'index.php/SettlementTenantUrbanDc/hearingNoticeAdcPagination',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        rural:rural,
                        occupation:occupation,
                    },
                    deferLoading: 57,
                },
        
                columnDefs: [{
                  targets: 0,
                  checkboxes: {
                    'selectRow': true
                  },
                  data: "is_visible",
                  'render': function (data, type, row) {
                    let text = row[0];
                    const myArray = text.split("/");
                    var arr = myArray[3];
                    return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+arr+' name="selectMark[]">';
                  }
                }],
                    
            });



            var selectedCheckBoxArray = [];
            $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
              var checkBoxId = $(this).val();
              var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray); 
              if(this.checked && rowIndex === -1) {
                selectedCheckBoxArray.push(checkBoxId);
              }
              else if (!this.checked && rowIndex !== -1) {
                selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
              }
            });

            $("#checkedAll").click(function(){
                if(this.checked){
                    $('.selectMark').each(function(){
                        this.checked = true;
                        var id = $(this).val();
                        if($.inArray(id, selectedCheckBoxArray) !== -1){
                          // $('.selectMark').prop('checked', false);
                        }else{
                          selectedCheckBoxArray.push(id);
                          $('.selectMark').prop('checked', true);
                        }
                    })
                }else{
                    $('.selectMark').each(function(){
                        this.checked = false;
                        var id = $(this).val();
                        var rowIndex = $.inArray(id, selectedCheckBoxArray);
                        if(rowIndex == -1){

                        }else{
                          selectedCheckBoxArray.splice(rowIndex, 1);
                          $('.selectMark').prop('checked', false);
                        }                
                    })
                }
                console.log(selectedCheckBoxArray);
            });


            $("#datatable").on('draw.dt', function() {
              for (var i = 0; i < selectedCheckBoxArray.length; i++) {
                checkboxId = selectedCheckBoxArray[i];
                const myArray = checkboxId.split("/");
                var arr = myArray[3];
                $('#' + arr).attr('checked', true);
              }
            });
            // button search
            $('.search_button').on('click', function () {            
                $('table thead tr th .input_search').each(function(){ 
                    table.column($(this).data('columnIndex')).search(this.value);
                });
                table.draw();
            });
        }
        
    });

</script>

<script>
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
</script>

 <script type="text/javascript">
    function coForm(){

        var adc_code = $('#send_adc_to').val();

        if(adc_code == '')
        {
            alert("Please select ADC...");
            $('#send_adc_to').focus();
            return false;
        }
    }


    $('#co_bulk_notice').submit(function (e) {
    e.preventDefault();
    if(!confirm("Are you sure you want to forward this cases?"))
     {
         return false;
     }
        // $("#overlay").fadeIn(300);
        $.blockUI({
           message: $('#displayBox'),
           css: {
               border:'none',
               backgroundColor:'transparent'
           }
        });
        var ct = [];
  
        var checkboxes = $('input[type="checkbox"]');
        checkboxes.filter(':checked').each(function() {
            var name = this.value;
            ct.push(name);
        });
        if(ct.length  == 0){
             $.unblockUI();
            alert("Please select atleast one checkbox...");
            return false;
        }
        $.ajax({
            url: baseurl + "SettlementTenantUrbanDc/bulkFowardToAdcForHearing",
            type: 'POST',
            data: $("#co_bulk_notice").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
               

                if(data.responseType != 2)
                {
                    showErrorMessage(data.msg);
                    return false;
                }
                else
                {
                    Swal.fire({
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                               window.location.reload();
                        }
                    })
                }

            },
            error: function (error) {
                console.log(error);
                $.unblockUI();
                alert("Something went wrong");
            }

        })

    });
</script>