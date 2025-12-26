<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="well well-sm">
                <h2 style="text-align: center;"> Compare Pattadar's ( Chitha Vs Jamabandi ) </h2>
            </div>
            
            <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Location Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' method="post" action="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">District</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['dist']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Subdivision</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['sub']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Circle</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['cir']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Mouza</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['mouza']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Lot No</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['lot']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Village / Town</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['vill']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Patta Type</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['patta_type_name']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-2">
                                    &nbsp;
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Patta No</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['patta_no']; ?>" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                                
        </div>
        
        <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <h2 class="red">Pattadar's From Chitha</h2>
                            <table class="centertable table table-stripped table-compressed sml">
                            <thead>
                                <tr style="font-size: 12px;"><th>Id</th><th>Pattadar Name</th><th>Father Name</th><th>Action</th><th>Delete</th><th>Transfer</th></tr>
                            </thead>
                            <?php
                            foreach ($chitha_pattadar as $chithadetails) {
                                echo '<tr style="font-size: 12px;">'
                                        . '<td><input type="number" name="pdar_id" id="' . $chithadetails->pdar_id . 'new_pdar_id_c" value="' . $chithadetails->pdar_id . '" style="width: 40px;" /></td>'
                                        . '<td><input type="text" name="pdar_name" id="' . $chithadetails->pdar_id . 'new_pdar_name_c" value="' . $chithadetails->pdar_name . '" /></td>'
                                        . '<td><input type="text" name="pdar_father" id="' . $chithadetails->pdar_id . 'new_pdar_father_c" value="' . $chithadetails->pdar_father . '" /></td>';
                                echo'<td><button type="button" class="btn btn-link" onclick="updateforchitha('.$chithadetails->pdar_id.')"><span class="glyphicon glyphicon-save"></span></button></td>';
                                echo'<td><button type="button" class="btn btn-link" onclick="getIdforchitha('.$chithadetails->pdar_id.')"><span class="glyphicon glyphicon-trash"></span></button></td>';
                                echo'<td><button type="button" class="btn btn-link" onclick="transferPattadar('.$chithadetails->pdar_id.')"><span class="glyphicon glyphicon-transfer"></span></button></td></tr>';
                            }
                            ?>
                    </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <h2 class="red">Pattadar's From Jamabandi</h2>
                        <table class="centertable table table-stripped table-compressed sml">
                            <thead>
                                <tr  style="font-size: 12px;"><th>Id</th><th>Pattadar Name</th><th>Father Name</th><th>Action</th><th>Delete</th></tr>
                            </thead>
                            <?php
                            foreach ($jama_pattadar as $jamadetails) {
                                if ($jamadetails->p_flag == 1) {
                                    $style = 'color:#ff0000;text-decoration: line-through;';
                                    $class = 'danger';
                               } else {
                                   $style = '';
                                   $class = '';
                               }
                                echo '<tr style="font-size: 12px;" class="'.$class.'">'
                                        . '<td><input type="number" name="pdar_id" id="' . $jamadetails->pdar_id . 'new_pdar_id_j" value="' . $jamadetails->pdar_id . '" style="'.$style.'width: 40px;" /></td>'
                                        . '<td><input type="text" name="pdar_name" id="' . $jamadetails->pdar_id . 'new_pdar_name_j" value="' . $jamadetails->pdar_name . '" style="'.$style.'"/></td>'
                                        . '<td><input type="text" name="pdar_father" id="' . $jamadetails->pdar_id . 'new_pdar_father_j" value="' . $jamadetails->pdar_father . '" style="'.$style.'"/></td>';
                                 echo'<td><button type="button" class="btn btn-link" onclick="updateforjama('.$jamadetails->pdar_id.')"><span class="glyphicon glyphicon-edit"></span></button></td>';
                                echo'<td><button type="button" class="btn btn-link" onclick="getIdforjama('.$jamadetails->pdar_id.')"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
                            }
                            ?>
                    </table>
                    </div>
                </div>
            </div>
            <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $location['dist_code']; ?>" readonly>
            <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $location['subdiv_code']; ?>" readonly>
            <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $location['cir_code']; ?>" readonly>
            <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $location['mouza_code']; ?>" readonly>
            <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $location['lot_no']; ?>" readonly>
            <input type="hidden" class="form-control" id="village_new" value="<?php echo $location['vill_code']; ?>" readonly>
            <input type="hidden" class="form-control" id="patta_no" value="<?php echo $location['patta_no']; ?>" readonly>
            <input type="hidden" class="form-control" id="patta_type_code" value="<?php echo $location['patta_type_code']; ?>" readonly>
    </div>
</div>


<script type="text/javascript">
    function getIdforchitha($e) {
        var patta_type_code = $('#patta_type_code').val();
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village_new').val();
        var patta_no = $('#patta_no').val();
        var pdar_id = $e;
        var template;
        var merge_id = prompt("Please enter the id to merge in chitha dag pattadar :");
      if (merge_id == null || merge_id == "") {
            template = "User cancelled the prompt.";
            alert(template);
      } else {
          $.ajax({
            url: baseurl + "Maintenance/DeletePattadarChitha/" + merge_id + "/" + pdar_id + "/" + patta_no + "/" + patta_type_code + "/" + dist_code_new + "/" + subdiv_code_new + "/" + circle_code_new + "/" + mouza_code_new + "/" + lot_no_new + "/" + village_new,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var data = JSON.parse(data);
                if (data['val'] == 'True') {
                    var template = "Update Complete";
                    alert(template);
                    location.reload();
                }
                if (data['val'] == 'False') {
                    var template = "Somthing is Wrong..!!";
                    alert(template);
                }

            }
        });
      }
    }
    
    function getIdforjama($e) {
        var patta_type_code = $('#patta_type_code').val();
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village_new').val();
        var patta_no = $('#patta_no').val();
        var pdar_id = $e;
        var template;
        $.ajax({
            url: baseurl + "Maintenance/DeletePattadarJama/" + pdar_id + "/" + patta_no + "/" + patta_type_code + "/" + dist_code_new + "/" + subdiv_code_new + "/" + circle_code_new + "/" + mouza_code_new + "/" + lot_no_new + "/" + village_new,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var data = JSON.parse(data);
                if (data['val'] == 'True') {
                    var template = "Update Complete";
                    alert(template);
                    location.reload();
                }
                if (data['val'] == 'False') {
                    var template = "Somthing is Wrong..!!";
                    alert(template);
                }

            }
        });
      
    }
    
    function updateforchitha($e) {
        var pdar_id = $e;
        var patta_type_code = $('#patta_type_code').val();
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village_new').val();
        var patta_no = $('#patta_no').val();
        var new_pdar_id = $('#'+pdar_id+'new_pdar_id_c').val();
        var new_pdar_name = $('#'+pdar_id+'new_pdar_name_c').val();
        var new_pdar_father = $('#'+pdar_id+'new_pdar_father_c').val();
        
        //alert(new_pdar_id +' '+new_pdar_name+' '+new_pdar_father);
        var saveData = $.ajax({
            type: 'GET',
            url: baseurl + "Maintenance/UpdatePattadarChitha/",
            data: {pdar_id : pdar_id, patta_no : patta_no, patta_type_code :  patta_type_code, dist_code_new : dist_code_new, subdiv_code_new : subdiv_code_new, circle_code_new : circle_code_new, mouza_code_new : mouza_code_new , lot_no_new : lot_no_new , village_new : village_new , new_pdar_id : new_pdar_id , new_pdar_name : new_pdar_name , new_pdar_father : new_pdar_father},
            dataType: "text",
            success: function(resultData) { alert("Save Complete"); location.reload(); }
      });
      saveData.error(function() { alert("Something went wrong"); });
    }
    
    function updateforjama($e) {
        var pdar_id = $e;
        var patta_type_code = $('#patta_type_code').val();
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village_new').val();
        var patta_no = $('#patta_no').val();
        var new_pdar_id = $('#'+pdar_id+'new_pdar_id_j').val();
        var new_pdar_name = $('#'+pdar_id+'new_pdar_name_j').val();
        var new_pdar_father = $('#'+pdar_id+'new_pdar_father_j').val();
        
        //alert(new_pdar_id +' '+new_pdar_name+' '+new_pdar_father);
        var saveData = $.ajax({
            type: 'GET',
            url: baseurl + "Maintenance/UpdatePattadarJama/",
            data: {pdar_id : pdar_id, patta_no : patta_no, patta_type_code :  patta_type_code, dist_code_new : dist_code_new, subdiv_code_new : subdiv_code_new, circle_code_new : circle_code_new, mouza_code_new : mouza_code_new , lot_no_new : lot_no_new , village_new : village_new , new_pdar_id : new_pdar_id , new_pdar_name : new_pdar_name , new_pdar_father : new_pdar_father},
            dataType: "text",
            success: function(resultData) { alert("Save Complete"); location.reload(); }
      });
      saveData.error(function() { alert("Something went wrong"); });
    }
    
    function transferPattadar($e) {
        var pdar_id = $e;
        var patta_type_code = $('#patta_type_code').val();
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village_new').val();
        var patta_no = $('#patta_no').val();
        
        //alert(new_pdar_id +' '+new_pdar_name+' '+new_pdar_father);
        var merge_id = prompt("Please enter the id for pattadar in jamabandi:");
        if (merge_id == null || merge_id == "") {
              template = "User cancelled the prompt.";
              alert(template);
        } else {
            var saveData = $.ajax({
                type: 'GET',
                url: baseurl + "Maintenance/TransferPattadarToJama/",
                data: {new_pdar_id : merge_id, pdar_id : pdar_id, patta_no : patta_no, patta_type_code :  patta_type_code, dist_code_new : dist_code_new, subdiv_code_new : subdiv_code_new, circle_code_new : circle_code_new, mouza_code_new : mouza_code_new , lot_no_new : lot_no_new , village_new : village_new},
                dataType: "text",
                success: function(resultData) { alert("Save Complete"); location.reload(); }
            });
            saveData.error(function() { alert("Something went wrong"); });
        }
        
    }
</script>