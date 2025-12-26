<center>
    
    <mark>
        Application Received in Basundhara 
    </mark>
        
    <br>
    <mark>
        <strong style="font-size: 20px;">
            <?php
                if($service == '13')
                {
                    echo "Settlement Occupancy Tenant";
                }
                if($service == '14')
                {
                    echo "Settlement AP Transfer";

                }
                if($service == '15')
                {
                    echo "Settlement Tribal Community";
                }
                if($service == '16')
                {
                    echo "Settlement Khasland";

                }
                if($service == '17')
                {
                    echo "Settlement VGR/PGR";

                }
                if($service == '18')
                {
                    echo "Settlement Cultivation";

                }

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
			<th>Occupation
                <select name="occupation" id="occupation" class="form-control input_search" data-column-index="2">
                    <option value="">Select</option>
                    <option value="SERVICE">SERVICE</option>
                    <option value="PRIVSERV">PRIVSERV</option>
                    <option value="BUSINESS">BUSINESS</option>
                    <option value="PENSIONER">PENSIONER</option>
                    <option value="AGRICULTURE">AGRICULTURE</option>
                    <option value="HOUSEWIFE">HOUSEWIFE</option>
                    <option value="UNEMPLOYED">UNEMPLOYED</option>
                </select>
            </th>
            <th>
                Applied for
            </th>
            <th>
                Flagged in Chitha
            </th>
			<th>Urban/Rural

                <select class="form-control input_search" name="rural" id="rural" data-column-index="3">
                    <option value="">select</option>
                    <?php if(isset($selectList->urban_check)){ foreach($selectList->urban_check as $rural){
                        ?>
                        <option value="<?=$rural->is_urban?>"><?php if($rural->is_urban == 'Y'){echo 'Urban';}else{echo "Rural";}?></option>
                    <?php }}?>
                </select>
            </th>
			<th>Name 
                <select class="form-control input_search" name="category" id="category" data-column-index="4">
                    <option value="">select</option>
                    <?php if(isset($selectList->vill_list)){ foreach($selectList->vill_list as $vill){
                        ?>
                        <option value="<?=$vill->village_code?>"><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_code, $vill->lot_no, $vill->village_code)?></option>
                    <?php }}?>
                </select>
            </th>
            <th>Mouza</th>
            <th>Lot</th>
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
        <div class="col-sm-2 pl-0">
            <input type="text" class="form-control" autocomplete="off" id="popupDatepicker"
                   placeholder="Select Date" name="hearing_date" required>
        </div>
        <label class="col-sm-7 uni_text" style=" font-size: 18px;">তাৰিখ শুনানি আৰু আপত্তি
            দাখিলৰ বাবে ধাৰ্য্য হ'ল ।</label>
            <div class="col-sm-3 pl-0">
                <button type="submit" name="generate_notice" formtarget="GenerateNotice" class=" text-white btn btn-warning btn-sm" onclick="return coForm()">Generate Notice</button>
            
        </div>
    </div>
    <div class="form-group">
        <span id="error_hear"></span>
        <ul class="caselist">
            
        </ul>
    </div>
    
</div>
</form>
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
            var service_code = <?=$service?>;

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
                    url: base_url+'index.php/SettlementApCo/apPaginationAPI',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        rural:rural,
                        occupation:occupation,
                    },
                    deferLoading: 57,
                },


                // order: [[2, 'asc']],
                // columnDefs: [{
                //     targets: "_all",
                //     orderable: false,
                //     "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
                //     }],

                order: [[2, 'asc']],
        
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



            // on keypree search automatically
            // table.columns().every(function () {
            //     var table = this;
            //     $('input', this.header()).on('keyup change', function () {
            //         if (table.search() !== this.value) {
            //                 table.search(this.value).draw();
            //         }
            //     });
            // });

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
 <script type="text/javascript">
    function coForm(){
        let x = document.forms["co_bulk_notice"]["hearing_date"].value;
        // let y = document.forms["co_form_sub"]['remark_co_type'].value;
        //let z = document.forms['co_form_sub']['remark_co'].value;
        //let z =  $("#remark_co_text").val();
        if (x == "") {
            alert("Hearing date needs to be selected.");
            $(".hearing_date").focus();
            $("#error_hear").html('<b style="color:red">Hearing date needs to be selected.</b>')
            return false;
        }
        // if (y == "") {
        //     alert("Select remark type.");
        //     $("#remark_co").focus();
        //     return false;
        // }
        // if (z == "") {
        //     alert("Enter remark.");
        //     $("#remark_co_text").focus();
        //     return false;
        // }
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
            url: baseurl + "SettlementApCo/coBulkNoticeGenerateAndForward",
            type: 'POST',
            data: $("#co_bulk_notice").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
                // $("#overlay").fadeOut(300);
          
                // $('#error_a_message').html('');
                // data = JSON.parse(data);
                var list = null; 
                var listing = "";
                if(data.responseType == 2)
                {
                 
                    list = JSON.parse(data.list);
                    
                    for (var i=0; i<list.length; i++) {
                       listing +=list[i] +"\n";
                    }
                    alert(data.message + "\n Completed Cases==\n" + listing);
                    window.location.reload();
                }
                else if(data.responseType == 3)
                {
                    if(data.list){
                        list = JSON.parse(data.list);
                 
                        for (var i=0; i<list.length; i++) {
                           listing +=list[i] +"\n";
                        }
                    }
                    
                    alert(data.message + "\n Completed Cases==\n" + listing);
                    window.location.reload();
                    
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