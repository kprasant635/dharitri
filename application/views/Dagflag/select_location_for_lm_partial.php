<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<style>
  /*  select {
        font-family: verdana;
        font-size: 8pt;
        width: 150px;
        height: 30vh;
    }*/
    select.form-control[multiple], select.form-control[size]{
        height: 250px !important;
        width: 450px !important;
    }
    .selectLabel1{
        background-color: #ff681d;
        padding: 8px;
        color: #fff;
    }
    .selectLabel2{
        background-color: #209924;
        padding: 8px;
        color: #fff;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">Location Details for Dag Mapping with area (Partial Mapping)</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="" id="PartialMappingForm">
                        <input type="hidden" name="selectedDags" id="selectedDags">
                        <input type="hidden" class="districtselect" name="dist_code" id="dist_code" value="<?php echo $datas['dist_code']; ?>">
                        <input type="hidden" class="subdivselect" name="subdiv_code" id="subdiv_code" value="<?php echo $datas['subdiv_code']; ?>">
                        <input type="hidden" class="circleselect" name="cir_code" id="cir_code" value="<?php echo $datas['cir_code']; ?>">
                        <input type="hidden" class="mouza_pargona_code" name="mouza_pargona_code" id="mouza_pargona_code" value="<?php echo $datas['mouza_pargona_code']; ?>">
                        <input type="hidden" class="lot_no" name="lot_no" id="lot_no" value="<?php echo $datas['lot_no']; ?>">
                        <input type="hidden" class="vill_townprt_code" name="vill_townprt_code" id="vill_townprt_code" value="<?php echo $datas['vill_code']; ?>">
                    <div class="" role="alert" style="text-align:center">
                        <h4><?php echo $this->lang->line('district');?> : <kbd><?php echo $datas['dist_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : <kbd><?php echo $datas['sub_div_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <kbd><?php echo $datas['cir_name']; ?></kbd> <?php echo $this->lang->line('vill_town');?> : <kbd><?php echo $datas['vill_name']; ?></kbd> </h4>
                    </div>
                    <div class="container">
                        <div class="form-group" style="margin-bottom: 80px;">
                            <div class="col-md-2">
                                <label>Select Category</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-select" id="MappingCat" name="MappingCat[]">
                                    <?php foreach ($area as $area1): ?>
                                        <?php
                                        $paid = $area1->paid;
                                        $area11 = $area1->area;
                                        ?>
                                        <option value="<?php echo $paid; ?>"><?php echo $area11; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <table>
                                <tr>
                                    <td width="20%">
                                        <label class="selectLabel1">Dag Selection</label>
                                        <select class="form-control" id='list1' size="200" multiple>
                                            <?php foreach ($daginfo as $dags): ?>
                                                <?php
                                                $dag_no = $dags->dag_no;
                                                $dag_no_int = $dags->dag_no_int;
                                                ?>
                                                <option value="<?php echo $dag_no; ?>"><?php echo $dag_no; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td width="20%" class="text-center">
                                        <a id='ltor' class="btn btn-primary" onclick='moveToRight();'> > </a><br>
                                        <a id='rtol' class="btn btn-danger" onclick='moveToLeft();'> < </a>
                                    </td>
                                    <td width="60%"><label class="selectLabel2">Selected Dags with Category</label>
                                        <select class="form-control" id='list2' name="list2"  size="200" multiple>

                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center" style="margin-top: 47px;">
                            <b class="text-red"><span style="font-size:20px">Note</span> : Update button will appear only in complete selection of all dags. </b>
                        </div>
                        <div class="text-center buttonDiv" style="margin-top: 47px;display: none;">

                            <button type="submit" class="btn btn-primary"><i class="fa fa-refresh "></i> Update Flag</button>
                        </div>
                    </div>

                </form>
                        <?php
                        $backLink = 'Dagflag/locationDetails';
                        include 'commonButtons.php';
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    function showSuccessMessage(text) {
        Swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        }).then(function(){
                window.location.href =  baseurl + "Dagflag/locationDetails";
            });

        }

    function showErrorMessage(text) {
        Swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }



    $('#PartialMappingForm').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to submit this mapping?"))
        {
            return false;
        }
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Dagflag/partialMappingSubmit",
            type: 'POST',
            data: $("#PartialMappingForm").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
                if(data.status == 'success'){
                    showSuccessMessage(data.msg);
                }else{
                    showErrorMessage(data.msg); 
                }
            },error: function (error) {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });


       
    function getSelValue()
    {
        var x=document.getElementById("list2");
        var result='';
        for (var i = 0; i < x.options.length; i++) {
            result=result+x.options[i].value+",";        
        }
        alert(result);
    }
        
        
        function moveToRight() {
            var sel = document.getElementById("list1");
            var listLength = sel.options.length;
            var cat = $("#MappingCat option:selected").text();
            var catVal = $("#MappingCat").val();
            var selectedValCat;
            for (var i = listLength - 1; i >= 0; i--) {
                if (sel.options[i].selected) {
                    selectedValCat = sel.options[i].text+"-"+cat;
                    document.getElementById("list2").add(new Option(selectedValCat, sel.options[i].value+"@"+catVal)); document.getElementById("list1").remove(i);

                }
                
            }
            sortSelectByValue("list2");
            // function is used for checking the length and button show for update=========
            countLength("First");
            //end=======
        }
        function countLength(str) {
            if(str){
                var sel = document.getElementById("list1");
            }
            let selectElement = document.querySelectorAll('[name=list2]');
            let optionValues = [...selectElement[0].options].map(o => o.value);
            $("#selectedDags").val(optionValues);
            var listLength = sel.options.length;
            if(listLength == 0){
                $('.buttonDiv').show();
                
            }else{
                $('.buttonDiv').hide();
            }
        }
        function moveToLeft() {
            var sel = document.getElementById("list2");
            var listLength = sel.options.length;
            for (var i = listLength - 1; i >= 0; i--) {
                if (sel.options[i].selected) {
                    // alert(sel.options[i].text);
                    var str = sel.options[i].value;
                    var strval = str.split("@");
                    document.getElementById("list1").add(new Option(strval[0],strval[0])); document.getElementById("list2").remove(i);
                }
            }
            sortSelectByValue("list1");
            countLength("Second");

        }
        
        // Sort options of a select element by value
        function sortSelectByValue(selectId) {
            var select = document.getElementById(selectId);
            var arr = toArray(select.options);

            arr.sort(function (a, b) { return a.value - b.value });
            // console.log(arr);
            arr.forEach(function (opt) {
                select.appendChild(opt);
            })

            // Optional - set first option as selected
            select.selectedIndex = 0;
        }
        // Convert a list like object to an Array
        function toArray(obj) {
            var arr = [];
            for (var i = 0, iLen = obj.length; i < iLen; i++) {
                if (i in obj) {
                    arr[i] = obj[i];
                }
            }
            return arr;
        }
        
    </script>