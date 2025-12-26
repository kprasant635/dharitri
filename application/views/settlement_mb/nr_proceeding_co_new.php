<style type="text/css">
    .checkBoxD{
        width: 20px;
        height: 20px;
    }
</style>
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            NR to Settlement
        </h4>
    </div>
</div>
<form id="bulk_nr_revert_form" method="post">
<div class="row px-5">
    <table id="datatable" class="datatable table table-stripped">  
            <thead>  
                <tr>  
                    <th>All <input  type="checkbox" class="checkBoxD " value="all" id="checkedAll1" > </th>
                    <th></th>
                    <th></th>
                    <th>Mouza<select class="form-control" name="mouza_cat" id="mouza_cat" data-column-index="2">
                            <option value="">select</option>
                            <?php if(isset($select_data)){ foreach($select_data as $select){?>
                                <option value="<?=$select->mouza_pargona_code?>"><?=$this->utilityclass->getMouzaName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code)?></option>
                            <?php }}?>
                        </select>
                    </th>
                    <th>Lot
                        <select class="form-control" name="lot_cat" id="lot_cat">
                            <option value="">Select Lot</option>
                        </select>
                    </th>
                    <th>Village
                        <select class="form-control" name="category" id="category">
                            <option value="">select</option>
                        </select>
                    </th>  
                    <th>
                        NR or Settlement(Yes/No)
                        <select class="form-control" name="nr_cat" id="nr_cat">
                            <option value="">select</option>
                            <option value="nr">NR</option>
                            <option value="nrwithsettlement">NR with Settlement</option>
                        </select>
                    </th>  
                    <th>Submission Date</th>
                   
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


        <div class="card pt-2">
            <div class="col-lg-12">
                <div class="mt-4 row px-5">
                    

                    <div class="col-md-9">
                        <b style="color:red">Are you want to revert multiple cases to LM at one go ? please select remark category with remarks and proceed...</b>
                        <hr>

                            <label for="inputEmail4">Select remark type</label>

                            <select name="remark_co_type" id="remark_co_type" onchange="autoRemark();" class="form-control">
                                <?php
                                foreach(json_decode(CO_NOTE) as $co_remark_cat){
                                    if($co_remark_cat->CODE !=3){
                                        ?>
                                        <option value="<?=$co_remark_cat->CODE?>"><?=$co_remark_cat->NAME?></option>
                                        <?php
                                    }
                                }
                                ?>
                           

                            </select> <br>
                            <textarea placeholder="Remarks  ..." name="remark_co" id="remark_co_text" class="form-control p-2" cols="30" rows="10"></textarea>
                            <div class="text-center">
                                <button type="submit" name="bulk_nr_revert" formtarget="bulk_nr_revert_form" class=" text-white btn btn-warning btn-sm" onclick="return coForm()">Revert to LM</button>
                            </div>
         

                       
                    </div>
                </div>
            </div>
        <div class="form-group">
            <span id="error_hear"></span>
            <ul class="caselist">
                
            </ul>
        </div>
        
    </div>
</form>


</div>

 <style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>


<script>
    $(document).on('change', '#mouza_cat, #lot_cat', function(){
        var mouzaCode = $('#mouza_cat').val();
        var lot_no = $('#lot_cat').val();

        var postData = {
            'mouza_pargona_code' : mouzaCode,
            'lot_no' : lot_no,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementCommon/getLotsFromMouzaCo',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    var options = '<option value="">Select Lot</option>';
                    var options2 = '<option value="">Select Village</option>';

                    if(mouzaCode == '')
                    {
                        $('#lot_cat').html(options);
                        $('#category').html(options2);
                    }

                    if(arr.lot_details != '')
                    {
                        for(i=0; i<arr.lot_details.length; i ++)
                        {
                            options += "<option value='"+arr.lot_details[i].lot_no+"'>"+arr.lot_details[i].loc_name+"</option>";
                        }

                        $('#lot_cat').html(options);
                    }

                    if(arr.village_details != '')
                    {
                        for(i=0; i<arr.village_details.length; i ++)
                        {
                            options2 += "<option value='"+arr.village_details[i].vill_townprt_code+"'>"+arr.village_details[i].loc_name+"</option>";
                        }

                        $('#category').html(options2);
                        
                    }
                    else
                    {
                        $('#category').html(options2);
                    }
                }
            }
        });
    })

</script>

<script>
    $(document).ready(function ()
    {
        $(document).on('change', '#category, #mouza_cat, #lot_cat, #nr_cat', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();
            var nr_cat = $('#nr_cat').val();

            $('#datatable').DataTable().destroy();
            if(category != '')
            {
                category = category;
            }
            else
            {
                category = '';
            }
            if(nr_cat != '')
            {
                nr_cat = nr_cat;
            }
            else
            {
                nr_cat = '';
            }
            

            if(mouza_cat != '')
            {
                mouza_cat = mouza_cat;
            }
            else
            {
                mouza_cat = '';
            }

            if(lot_cat != '')
            {
                lot_cat = lot_cat;
            }
            else
            {
                lot_cat = '';
            }

            load_data(category, mouza_cat, lot_cat, nr_cat);

        });

        load_data();

        function load_data(is_category = null,  mouza_cat=null, lot_cat=null, nr_cat=null)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var status = 'Y';
            // $('#datatable thead th:nth-of-type(1)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });

            // $('#datatable thead th:nth-of-type(2)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });
            // $('#datatable thead th:nth-of-type(4)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });

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
                    url: base_url+'index.php/SettlementApCo/getListofcasesNR',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:status,
                        is_category:is_category,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat,
                        nr_cat : nr_cat
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                // columnDefs: [{
                //     targets: "_all",
                //     orderable: false,
                //     "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
                // }]
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
              // console.log(selectedCheckBoxArray);
            });

            $("#checkedAll1").click(function(){
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

            // table.columns().every(function () {
            //     var table = this;
            //     $('input', this.header()).on('keyup change', function () {
            //         if (table.search() !== this.value) {
            //                 table.search(this.value).draw();
            //         }
            //     });
            // });
            $('.search_button').on('click', function () {            
                $('table thead tr th .input_search').each(function(){ 
                    table.column($(this).data('columnIndex')).search(this.value);
                });
                table.draw();
            });
        }
        
    });
function coForm(){
        let x = document.forms["bulk_nr_revert_form"]["remark_co_text"].value;
        let y = document.forms["bulk_nr_revert_form"]['remark_co_type'].value;
        //let z = document.forms['co_form_sub']['remark_co'].value;
        //let z =  $("#remark_co_text").val();
        if (x == "") {
            alert("Remarks field can not be empty");
            $(".remark_co_text").focus();
            return false;
        }
        if (y == "") {
            alert("Select remark type.");
            $("#remark_co_type").focus();
            return false;
        }
        // if (z == "") {
        //     alert("Enter remark.");
        //     $("#remark_co_text").focus();
        //     return false;
        // }
    }


$('#bulk_nr_revert_form').submit(function (e) {
    e.preventDefault();
    if(!confirm("Are you sure you want to forward this selected cases?"))
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
            url: baseurl + "SettlementApCo/coBulkForwardNR",
            type: 'POST',
            data: $("#bulk_nr_revert_form").serialize(),
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