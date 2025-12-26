<style type="text/css">
    td {font-family:ms sans serif; font-size: 8pt}
    th {font-family:ms sans serif; font-size: 10pt}
</style>
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $("#foo1").show();
        $("#foo2").hide();
        
        $('#boo').click(function(){
        
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
       var circode = $('.circleselect').val();
        alert(subdivcode+" "+distcode+" "+circode);
       $("#foo1").hide();
        $("#foo2").show();
   });
    });
    
    
    
    function add_data($dist_c, $subdiv_code, $circ_code, $mouza_code, $lot_code, $village_code)
    {
        if(($dist_c.trim() == 'this') && ($('#dist').val().trim() != ''))
        {
            var dist_name = $('#dist').val();
            var dist_name = encodeURIComponent(dist_name);
            var code = prompt("Enter District Code (2 digits only)");
            if (isNaN(code))
            {
                alert("data is not an integer");
            }
            else
            {
                if ((code.length == 2))
                {
                    $.ajax({
                url: baseurl + "initialization/add_district/" + dist_name + '/' + code + '/' + $subdiv_code + '/' + $circ_code + '/' + $mouza_code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
                }
                else
                {
                    alert("Please Enter 2 Digit Integer");
                }
                
            }
        }
        else if(($subdiv_code.trim() == 'this') && ($('#sub_div').val().trim() != ''))
        {
            var subdiv_name = $('#sub_div').val();
            var subdiv_name = encodeURIComponent(subdiv_name);
            var code = prompt("Enter Sub Division Code (2 digits only)");
            if (isNaN(code))
            {
                alert("data is not an integer");
            }
            else
            {
                if ((code.length == 2))
                {
                    $.ajax({
                url: baseurl + "initialization/add_subdiv/" + $dist_c + '/' + subdiv_name + '/' + code + '/' + $circ_code + '/' + $mouza_code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
                }
                else
                {
                    alert("Please Enter 2 Digit Integer");
                }
                
            }
        }
        else if(($circ_code.trim() == 'this') && ($('#circle').val().trim() != ''))
        {
            var cir_name = $('#circle').val();
            var cir_name = encodeURIComponent(cir_name);
            var code = prompt("Enter Circle Code (2 digits only)");
            if (isNaN(code))
            {
                alert("data is not an integer");
            }
            else
            {
                if ((code.length == 2))
                {
                     $.ajax({
                url: baseurl + "initialization/add_circle/" + $dist_c + '/' + $subdiv_code + '/' + cir_name + '/' + code + '/' + $mouza_code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
                }
                else
                {
                    alert("Please Enter 2 Digit Integer");
                }
               
            }
        }
        else if(($mouza_code.trim() == 'this') && ($('#mouza').val().trim() != ''))
        {
            var mouza_name = $('#mouza').val();
            var mouza_name = encodeURIComponent(mouza_name);
            var code = prompt("Enter Mouza Paragona Code (2 digits only)");
            if (isNaN(code))
            {
                alert("data is not an integer");
            }
            else
            {
                if ((code.length == 2))
                {
                 $.ajax({
                url: baseurl + "initialization/add_mouza/" + $dist_c + '/' + $subdiv_code + '/' + $circ_code + '/' + mouza_name + '/' + code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
                }
                else
                {
                    alert("Please Enter 2 Digit Integer");
                }
            }
        }
        else if(($lot_code.trim() == 'this') && ($('#lot').val().trim() != ''))
        {
            var lot_name = $('#lot').val();
            var lot_name = encodeURIComponent(lot_name);
            var code = prompt("Enter Lot Number (2 digits only)");
            if (isNaN(code))
            {
                alert("data is not an integer");
            }
            else
            {
                if ((code.length == 2))
                {
                $.ajax({
                url: baseurl + "initialization/add_lot/" + $dist_c + '/' + $subdiv_code + '/' + $circ_code + '/' + $mouza_code + '/' + lot_name + '/' + code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
                }
                else
                {
                    alert("Please Enter 2 Digit Integer");
                }
            }
        }
        else if(($village_code.trim() == 'this') && ($('#village').val().trim() != ''))
        {
            var village_name = $('#village').val();
            var village_name = encodeURIComponent(village_name);
            var code = prompt("Enter Village Code (5 digits only)");
            if (isNaN(code))
            {
                alert("data is not an integer");
            }
            else
            {
                if ((code.length == 5))
                {
                $.ajax({
                url: baseurl + "initialization/add_village/" + $dist_c + '/' + $subdiv_code + '/' + $circ_code + '/' + $mouza_code + '/' + $lot_code + '/' + village_name + '/' + code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
                }
                else
                {
                    alert("Please Enter 5 Digit Integer");
                }
            }
        }
        else
        {
            alert("Cannot be Empty");
        }
    }

    function ModifyLocation($name, $code, $dist_c, $subdiv_code, $circ_code, $mouza_code, $lot_code, $village_code)
    {
        if(($dist_c.trim() == 'this'))
        {
            var dist_name = prompt("Update New District Name", $name);
            var dist_name = encodeURIComponent(dist_name);
            $.ajax({
                url: baseurl + "initialization/modify_district/" + dist_name + '/' + $code + '/' + $subdiv_code + '/' + $circ_code + '/' + $mouza_code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
        }
        else if(($subdiv_code.trim() == 'this'))
        {
            var subdiv_name = prompt("Update New Sub Division Name", $name);
            var subdiv_name = encodeURIComponent(subdiv_name);
            $.ajax({
                url: baseurl + "initialization/modify_subdiv/" + $dist_c + '/' + subdiv_name + '/' + $code + '/' + $circ_code + '/' + $mouza_code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
        }
        else if(($circ_code.trim() == 'this'))
        {
            var cir_name = prompt("Update New Circle Name", $name);
            var cir_name = encodeURIComponent(cir_name);
            $.ajax({
                url: baseurl + "initialization/modify_circle/" + $dist_c + '/' + $subdiv_code + '/' + cir_name + '/' + $code + '/' + $mouza_code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
        }
        else if(($mouza_code.trim() == 'this'))
        {
            var mouza_name = prompt("Update New Mouza Name", $name);
            var mouza_name = encodeURIComponent(mouza_name);
            $.ajax({
                url: baseurl + "initialization/modify_mouza/" + $dist_c + '/' + $subdiv_code + '/' + $circ_code + '/' + mouza_name + '/' + $code + '/' + $lot_code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
        }
        else if(($lot_code.trim() == 'this'))
        {
            var lot_name = prompt("Update New Lot No", $name);
            var lot_name = encodeURIComponent(lot_name);
            $.ajax({
                url: baseurl + "initialization/modify_lot/" + $dist_c + '/' + $subdiv_code + '/' + $circ_code + '/' + $mouza_code + '/' + lot_name + '/' + $code + '/' + $village_code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
        }
        else if(($village_code.trim() == 'this'))
        {
            var village_name = prompt("Update New Village Name", $name);
            var village_name = encodeURIComponent(village_name);
            $.ajax({
                url: baseurl + "initialization/modify_village/" + $dist_c + '/' + $subdiv_code + '/' + $circ_code + '/' + $mouza_code + '/' + $lot_code + '/' + village_name + '/' + $code,
                success: function (data) {
                    var code = JSON.parse(data);
                    for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                    }
                }
                });
        }
    }

    /* function ConfDel() { // disabled 7/11/19 
    if (!confirm('Really want to delete this location?'))
            return (false);
            return (true);
    } */
    
    

</script>
<?php
function drawconnector($level,$abspos,$totrec)
{
    if($level == 1)
    {
        if ($abspos<$totrec)
        {
            echo "<img border='0' src='".base_url()."application/views/images/subordinate-branch.gif' style='width:this.width' height='26' align='left' hspace='1'>";
        }
        else
        {
    	echo "<img border='0' src='".base_url()."application/views/images/subordinate-lower.gif' style='width:this.width' height='26' align='left' hspace='1'>";
        }
    }
    else
    {
        if ($abspos<$totrec)
        {
	echo"<img border='0' src='".base_url()."application/views/images/subordinate-continue.gif' style='width:this.width' height='26' align='left' hspace='1'>";
        }
    }
}
?>

<div class="row" style="min-height: 500px;">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('location_management');?></u></span></p>
                </div>
            </div>
            
            <div class="panel-body" onLoad = "return plugin_load();"  onUnload="return plugin_unload()" onclick="if_clicked_outside_modify_loc();">
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                        [ <a href="<?php echo base_url(); ?>index.php/home/"><?php echo $this->lang->line('home');?></a> ] || 
                        [ <a href="<?php echo base_url();?>index.php/initialization/view_location_codes"><?php echo $this->lang->line('view_location_code');?></a> ]
                        <br>
                        <br>
                        <table width='100%' bgcolor="#FFFFCC">
                                <tr>
                                    <td width="100%" colspan="7" bgcolor="#FFCF9F" style="border-top:1px solid #FF9933; border-right-color: #FF9933; border-right-width: 1; " height="24">
                                        <p class='bold'>
                                            <font color="#0000FF"><?php echo $this->lang->line('select');?></font>
                                            <font color="#0000FF">(<?php echo $this->lang->line('if_problem_exists_for_long_list');?>)</font>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%" align="left" style="border-right-style: none; border-right-width: medium; border-bottom-color: #FF9933; border-bottom-width: 1" height="20">
                                        <p style="margin-top: 0; margin-bottom: 0"><font face="ASBW-TTDurga" size="5"><?php echo $this->lang->line('district');?></font></p>
                                    </td>
                                    <td width="20%" align="right" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="19">
                                        <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                            <option disabled selected>Select District</option>
                                            <?php foreach ($names as $district): ?>
                                                <?php
                                                $distCode = $district->dist_code;
                                                $location = $district->loc_name;
                                                ?>
                                                <option value="<?php echo $distCode; ?>"><?php echo $location; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td width="10%" align="center" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="19">
                                        <p style="margin-top: 0; margin-bottom: 0">
                                            <font face="ASBW-TTDurga" size="5"><?php echo $this->lang->line('subdivision');?></font>
                                        </p>
                                    </td>
                                    <td width="20%" align="right" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="19">
                                        <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                            <option disabled selected>Select Sub-Division</option>
                                        </select>
                                    </td>
                                    <td width="10%" align="center" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="19">
                                        <p style="margin-top: 0; margin-bottom: 0">
                                            <font face="ASBW-TTDurga" size="5"><?php echo $this->lang->line('circle');?></font>
                                        </p>
                                    </td>
                                    <td width="20%" align="right" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="19">
                                        <select class="form-control circleselect" id="select" required name="circle_code">
                                            <option disabled selected>Select Circle</option>
                                        </select>
                                    </td>
                                    <td width="10%" align="right" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="19">
                                        <input type="button" id="boo" class='btn btn-md' value="SEARCH"/>
                                    </td>
                                </tr>
                            </table>
                        <hr>
                        <form name='frm1' style="display: none" id="foo1">
                            <table width="100%" class="table table-bordered">
                                <tr bgcolor=''>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('district');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('subdivision');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('circle');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('mouza');?></font></b>
                                    </td>
                                    <td align='center' width="20%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('lot_no');?></font></b>
                                    </td>
                                    <td align='center' width="20%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('vill_town');?></font></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="dist" name="dist" placeholder="Add District">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" onClick="add_data('this','00','00','00','00','00000')" type="button">Add</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="20%" height="1"></td>
                                    <td align='center' width="20%" height="1"></td>
                                </tr>
                                <?php 
                                $sql1 = "select distinct dist_code,loc_name from Location where Dist_code<>'00' and Subdiv_code='00' and Cir_code='00' and Mouza_Pargona_code='00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Dist_code desc";
                                $result1 = $this->db->query($sql1)->result();
                                foreach($result1 as $r1)
                                {
                                    ?>
                                    <tr>
                                    <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                        <font size="4" face="ASBW-TTDurga">
                                        <b><?php echo $r1->loc_name; ?></b>
                                        </font>
                                        <b>
                                            <font color="#009933" size="2" face="Verdana">
                                            <a onClick="return ConfDel()"  class='hide' href="<?php echo base_url(); ?>index.php/initialization/district_delete?dist_code=<?php echo $r1->dist_code; ?>">
                                               <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'>
                                            </a>
                                            <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r1->loc_name; ?>','<?php echo $r1->dist_code; ?>','this','00','00','00','00','00000');"></font></b><br/>
                                    </td>
                                    <td align='center' width="15%" height="1">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sub_div" name="sub_div" placeholder="Sub Division">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" onClick="add_data('<?php echo $r1->dist_code; ?>','this','00','00','00','00000')" type="button">Add</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="20%" height="1"></td>
                                    <td align='center' width="20%" height="1"></td>
                                    </tr>
                                    <?php
                                    $sql2 = "select distinct subdiv_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code<>'00' and Cir_code='00' and Mouza_Pargona_code='00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Subdiv_code desc";
                                    $result2 = $this->db->query($sql2)->result();
                                    $count = count($result2);
                                    $abspos_1 = 0;
                                    foreach($result2 as $r2)
                                    {
                                        $level_1 = 1;
                                        $totrec_1 = $count;
                                        $abspos_1++;
                                        ?>
                                        <tr>
                                        <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                            <?php drawconnector($level_1,$abspos_1,$totrec_1) ?>&nbsp;
                                        </td>
                                        <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                            <b><?php echo $r2->loc_name ?></b>
                                            </font>
                                            <b><font color="#009933" size="2" face="Verdana">
                                                <a onClick="return ConfDel()" class='hide' href="<?php echo base_url(); ?>index.php/initialization/subdivision_delete?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>">
                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r2->loc_name ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r1->dist_code ?>','this','00','00','00','00000');"></font></b><br/>
                                        </td>
                                        <td align='center' width="15%" height="1">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="circle" name="circle" placeholder="circle">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" onclick="add_data('<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','this','00','00','00000')" type="button">Add</button>
                                                </span>
                                            </div><!-- /input-group -->
                                        </td>
                                        <td align='center' width="15%" height="1"></td>
                                        <td align='center' width="20%" height="1"></td>
                                        <td align='center' width="20%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                        </tr>
                                        <?php
                                        //echo "&nbsp;".$r2->loc_name."------><br>";
                                        $sql3 = "select distinct cir_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code<>'00' and Mouza_Pargona_code='00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Cir_code desc";
                                        $result3 = $this->db->query($sql3)->result();
                                        $count1 = count($result3);
                                        $abspos_2 = 0;
                                        foreach($result3 as $r3)
                                        {
                                            $level_1 = 2;
                                            $level_2 = 1;
                                            $totrec_2 = $count1;
                                            $abspos_2++;
                                            ?>
                                            <tr>
                                            <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                                <?php drawconnector($level_1,$abspos_1,$totrec_1) ?>&nbsp;
                                            </td>
                                            <td align='center' width="15%" height="1">
                                                <?php drawconnector($level_2,$abspos_2,$totrec_2);?>&nbsp;
                                            </td>
                                            <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                                <b><?php echo $r3->loc_name ?></b></font><b><font color="#009933" size="2" face="Verdana">
                                                    <a onClick="return ConfDel()" class='hide' href="<?php echo base_url(); ?>index.php/initialization/circle_delete?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>">
                                                        <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                        <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r3->loc_name ?>','<?php echo $r3->cir_code ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','this','00','00','00000');"></font></b><br/>
                                            </td>
                                            <td align='center' width="15%" height="1">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="mouza" name="mouza" placeholder="mouza">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" onclick="add_data('<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','this','00','00000')" type="button">Add</button>
                                                    </span>
                                                </div><!-- /input-group -->
                                            </td>
                                            <td align='center' width="20%" height="1"></td>
                                            <td align='center' width="20%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                            </tr>
                                            <?php
                                            //echo "&nbsp;&nbsp;".$r3->loc_name."------><br>";
                                            $sql4 = "select distinct mouza_pargona_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code='".$r3->cir_code."' and Mouza_Pargona_code<>'00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Mouza_Pargona_code desc";
                                            $result4 = $this->db->query($sql4)->result();
                                            $count2 = count($result4);
                                            $abspos_3 = 0;
                                            foreach($result4 as $r4)
                                            {
                                                $level_2 = 2;
                                                $level_3 = 1;
                                                $totrec_3 = $count2;
                                                $abspos_3++;
                                                ?>
                                                <tr>
                                                <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                                    <?php drawconnector($level_1,$abspos_1,$totrec_1) ?>&nbsp;
                                                </td>
                                                <td align='center' width="15%" height="1">
                                                    <?php drawconnector($level_2,$abspos_2,$totrec_2) ?>&nbsp;
                                                </td>
                                                <td align='center' width="15%" height="1">
                                                    <?php drawconnector($level_3,$abspos_3,$totrec_3) ?>&nbsp;
                                                </td>
                                                <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                                    <b><?php echo $r4->loc_name ?></b></font><b><font color="#009933" size="2" face="Verdana">
                                                        <a onClick="return ConfDel()" class='hide' href="<?php echo base_url(); ?>index.php/initialization/mouza_delete?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>&Mouza_Pargona_code=<?php echo $r4->mouza_pargona_code ?>">
                                                           <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                        <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r4->loc_name ?>','<?php echo $r4->mouza_pargona_code ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','this','00','00000');"></font></b><br/>
                                                </td>
                                                <td align='center' width="20%" height="1">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="lot" name="lot" placeholder="lot_no">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" onclick="add_data('<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','this','00000')" type="button">Add</button>
                                                        </span>
                                                    </div><!-- /input-group -->
                                                </td>
                                                <td align='center' width="20%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                                </tr>
                                                <?php
                                                //echo "&nbsp;&nbsp;&nbsp;&nbsp;".$r4->loc_name."------><br>";
                                                $sql5 = "select distinct lot_no,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code='".$r3->cir_code."' and Mouza_Pargona_code='".$r4->mouza_pargona_code."' and  Lot_no<>'00' and  Vill_townprt_code='00000' ORDER BY Lot_no desc";
                                                $result5 = $this->db->query($sql5)->result();
                                                $count3 = count($result5);
                                                $abspos_4 = 0;
                                                foreach($result5 as $r5)
                                                {
                                                    $level_3 = 2;
                                                    $level_4 = 1;
                                                    $totrec_4 = $count3;
                                                    $abspos_4++;
                                                    ?>
                                                    <tr>
                                                    <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                                        <?php drawconnector($level_1,$abspos_1,$totrec_1) ?>&nbsp;
                                                    </td>
                                                    <td align='center' width="15%" height="1">
                                                        <?php drawconnector($level_2,$abspos_2,$totrec_2) ?>&nbsp;
                                                    </td>
                                                    <td align='center' width="15%" height="1">
                                                        <?php drawconnector($level_3,$abspos_3,$totrec_3) ?>&nbsp;
                                                    </td>
                                                    <td align='center' width="15%" height="1">
                                                        <?php drawconnector($level_4,$abspos_4,$totrec_4) ?>&nbsp;
                                                    </td>
                                                    <td align='center' width="20%" height="1"><font size="4" face="ASBW-TTDurga">
                                                        <b><?php echo $r5->loc_name ?></b>
                                                        </font><b><font color="#009933" size="2" face="Verdana">
                                                            <a onClick="return ConfDel()" class='hide' href="<?php echo base_url(); ?>index.php/initialization/lot_delete?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>&Mouza_Pargona_code=<?php echo $r4->mouza_pargona_code ?>&Lot_no=<?php echo $r5->lot_no ?>">
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r5->loc_name ?>','<?php echo $r5->lot_no ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','this','00000');"></font></b><br/>

                                                    </td>
                                                    <td align='center' width="20%" style="border-right-style: solid; border-right-width: 1" height="1">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="village" name="village" placeholder="village/Town">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" onclick="add_data('<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','<?php echo $r5->lot_no ?>','this')" type="button">Add</button>
                                                            </span>
                                                        </div><!-- /input-group -->
                                                    </td>
                                                    </tr>
                                                    <?php
                                                    //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r5->loc_name."------><br>";
                                                    $sql6 = "select distinct vill_townprt_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code='".$r3->cir_code."' and Mouza_Pargona_code='".$r4->mouza_pargona_code."' and  Lot_no='".$r5->lot_no."'  and  Vill_townprt_code<>'00000' ORDER BY Vill_townprt_code desc";
                                                    $result6 = $this->db->query($sql6)->result();
                                                    $count4 = count($result6);
                                                    $abspos_5 = 0;
                                                    foreach($result6 as $r6)
                                                    {
                                                        $level_4 = 2;
                                                        $level_5 = 1;
                                                        $totrec_5 = $count4;
                                                        $abspos_5++;
                                                        ?>
                                                        <tr>
                                                        <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                                            <?php drawconnector($level_1,$abspos_1,$totrec_1) ?>&nbsp;							
                                                        </td>
                                                        <td align='center' width="15%" height="1">
                                                            <?php drawconnector($level_2,$abspos_2,$totrec_2) ?>&nbsp;
                                                        </td>
                                                        <td align='center' width="15%" height="1">
                                                            <?php drawconnector($level_3,$abspos_3,$totrec_3) ?>&nbsp;
                                                        </td>
                                                        <td align='center' width="15%" height="1">
                                                            <?php drawconnector($level_4,$abspos_4,$totrec_4) ?>&nbsp;
                                                        </td>
                                                        <td align='center' width="20%" height="1">
                                                            <?php drawconnector($level_5,$abspos_5,$totrec_5) ?>&nbsp;
                                                        </td>
                                                        <td align='center' width="20%" style="border-right-style: solid; border-right-width: 1" height="1"><font size="4" face="ASBW-TTDurga">
                                                            <b><?php echo $r6->loc_name ?></b>
                                                            </font><b><font color="#009933" size="2" face="Verdana">
                                                                <a onClick="return ConfDel()" class='hide' href="<?php echo base_url(); ?>index.php/initialization/village_delete?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>&Mouza_Pargona_code=<?php echo $r4->mouza_pargona_code ?>&Lot_no=<?php echo $r5->lot_no ?>&Vill_townprt_code=<?php echo $r6->vill_townprt_code?>">
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify'  onclick="ModifyLocation('<?php echo $r6->loc_name ?>','<?php echo $r6->vill_townprt_code?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','<?php echo $r5->lot_no ?>','this');"></font></b><br/>
                                                        </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            </table>
                        </form>
                        
                      <form name='frm1' style="display: none" id="foo2">
                            <table width="100%" class="table">
                                <tr bgcolor=''>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('district');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('subdivision');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('circle');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('mouza');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('lot_no');?></font></b>
                                    </td>
                                    <td align='center' width="15%" style="background-color:  chocolate" height="22">
                                        <b><font size="2" color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('vill_town');?></font></b>
                                    </td>
                                </tr>
                                <?php 
                                $sql1 = "select distinct dist_code,loc_name from Location where Dist_code<>'00' and Subdiv_code='00' and Cir_code='00' and Mouza_Pargona_code='00' and  Lot_no='00' and  Vill_townprt_code='00000' and Dist_code like '".$datas['dist_code']."' ORDER BY Dist_code";
                                $result1 = $this->db->query($sql1)->result();
                                $count_r1 = count($result1);
                                //var_dump($result1);
                                foreach($result1 as $r1)
                                {
                                    $level_r1 = 1;
                                    ?>
                                    <tr>
                                    <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                        <font size="4" face="ASBW-TTDurga">
                                        <b><?php echo $r1->loc_name; ?></b>
                                        </font>
                                        <b>
                                            <font color="#009933" size="2" face="Verdana">
                                            
                                            <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r1->loc_name; ?>','<?php echo $r1->dist_code; ?>','00','00','00','00','00000');"></font></b><br/>
                                    </td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="15%" height="1"></td>
                                    <td align='center' width="25%" height="1"></td>
                                    </tr>
                                    <?php
                                    //echo $r1->loc_name."------><br>";
                                    $sql2 = "select distinct subdiv_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code<>'00' and Cir_code='00' and Mouza_Pargona_code='00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Subdiv_code";
                                    $result2 = $this->db->query($sql2)->result();
                                    $count_r2 = count($result2);
                                    foreach($result2 as $r2)
                                    {
                                        $level_r2 = 1;
                                        ?>
                                        <tr>
                                        <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1">
                                            <?php drawconnector($level_r1,0,$count_r1) ?>&nbsp;
                                        </td>
                                        <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                            <b><?php echo $r2->loc_name ?></b></font>
                                            <b><font color="#009933" size="2" face="Verdana">
                                                <a onClick="return ConfDel()" class='hide' href="location_delete.asp?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>">
                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r2->loc_name ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','00','00','00','00000');"></font></b><br/>
                                        </td>
                                        <td align='center' width="15%" height="1"></td>
                                        <td align='center' width="15%" height="1"></td>
                                        <td align='center' width="15%" height="1"></td>
                                        <td align='center' width="25%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                        </tr>
                                        <?php
                                        //echo "&nbsp;".$r2->loc_name."------><br>";
                                        $sql3 = "select distinct cir_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code<>'00' and Mouza_Pargona_code='00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Cir_code";
                                        $result3 = $this->db->query($sql3)->result();
                                        $count_r3 = count($result3);
                                        foreach($result3 as $r3)
                                        {
                                            ?>
                                            <tr>
                                            <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1"><?php drawconnector(0,0,$count_r1) //0,rs.AbsolutePosition,rs.RecordCount ?>&nbsp;</td>
                                            <td align='center' width="15%" height="1"><?php drawconnector($level_r2,0,$count_r2) // rsc.AbsolutePosition,rss.AbsolutePosition,rss.RecordCount ?>&nbsp;</td>
                                            <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                                <b><?php echo $r3->loc_name ?></b></font><b><font color="#009933" size="2" face="Verdana">
                                                    <a onClick="return ConfDel()" class='hide' href="location_delete.asp?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>">
                                                        <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                        <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r3->loc_name ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','00','00','00000');"></font></b><br/>
                                            </td>
                                            <td align='center' width="15%" height="1"></td>
                                            <td align='center' width="15%" height="1"></td>
                                            <td align='center' width="25%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                            </tr>
                                            <?php
                                            //echo "&nbsp;&nbsp;".$r3->loc_name."------><br>";
                                            $sql4 = "select distinct mouza_pargona_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code='".$r3->cir_code."' and Mouza_Pargona_code<>'00' and  Lot_no='00' and  Vill_townprt_code='00000' ORDER BY Mouza_Pargona_code";
                                            $result4 = $this->db->query($sql4)->result();
                                            $count_r4 = count($result4);
                                            foreach($result4 as $r4)
                                            {
                                                ?>
                                                <tr>
                                                <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1"><?php drawconnector(0,0,$count_r1) ?>&nbsp;</td>
                                                <td align='center' width="15%" height="1"><?php drawconnector(0,0,$count_r2) ?>&nbsp;</td>
                                                <td align='center' width="15%" height="1"><?php drawconnector(1,0,$count_r3) ?>&nbsp;</td>
                                                <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                                    <b><?php echo $r4->loc_name ?></b></font><b><font color="#009933" size="2" face="Verdana">
                                                        <a onClick="return ConfDel()" class='hide' href="location_delete.asp?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>&Mouza_Pargona_code=<?php echo $r4->mouza_pargona_code ?>">
                                                           <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                        <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r4->loc_name ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','00','00000');"></font></b><br/>
                                                </td>
                                                <td align='center' width="15%" height="1"></td>
                                                <td align='center' width="25%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                                </tr>
                                                <?php
                                                //echo "&nbsp;&nbsp;&nbsp;&nbsp;".$r4->loc_name."------><br>";
                                                $sql5 = "select distinct lot_no,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code='".$r3->cir_code."' and Mouza_Pargona_code='".$r4->mouza_pargona_code."' and  Lot_no<>'00' and  Vill_townprt_code='00000' ORDER BY Lot_no";
                                                $result5 = $this->db->query($sql5)->result();
                                                $count_r5 = count($result5);
                                                foreach($result5 as $r5)
                                                {
                                                    ?>
                                                    <tr>
                                                    <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1"><?php drawconnector(0,0,$count_r1) ?>&nbsp;</td>
                                                    <td align='center' width="15%" height="1"><?php drawconnector(0,0,$count_r2) ?>&nbsp;</td>
                                                    <td align='center' width="15%" height="1"><?php drawconnector(0,0,$count_r3) ?>&nbsp;</td>
                                                    <td align='center' width="15%" height="1"><?php drawconnector(1,0,$count_r4) ?>&nbsp;</td>
                                                    <td align='center' width="15%" height="1"><font size="4" face="ASBW-TTDurga">
                                                        <b><?php echo $r5->loc_name ?></b>
                                                        </font><b><font color="#009933" size="2" face="Verdana">
                                                            <a onClick="return ConfDel()" class='hide' href="location_delete.asp?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>&Mouza_Pargona_code=<?php echo $r4->mouza_pargona_code ?>&Lot_no=<?php echo $r5->lot_no ?>">
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify' onClick="ModifyLocation('<?php echo $r5->loc_name ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','<?php echo $r5->lot_no ?>','00000');"></font></b><br/>

                                                    </td>
                                                    <td align='center' width="25%" style="border-right-style: solid; border-right-width: 1" height="1"></td>
                                                    </tr>
                                                    <?php
                                                    //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r5->loc_name."------><br>";
                                                    $sql6 = "select distinct vill_townprt_code,loc_name from Location where Dist_code='".$r1->dist_code."' and Subdiv_code='".$r2->subdiv_code."' and Cir_code='".$r3->cir_code."' and Mouza_Pargona_code='".$r4->mouza_pargona_code."' and  Lot_no='".$r5->lot_no."'  and  Vill_townprt_code<>'00000' ORDER BY Vill_townprt_code";
                                                    $result6 = $this->db->query($sql6)->result();
                                                    $count_r6 = count($result6);
                                                    foreach($result6 as $r6)
                                                    {
                                                        ?>
                                                        <tr>
                                                        <td align='center' width="15%" style="border-left-style: solid; border-left-width: 1" height="1"><?php drawconnector(0,0,$count_r1) ?>&nbsp;								</td>
                                                        <td align='center' width="15%" height="1"><?php drawconnector(0,0,$count_r2) ?>&nbsp;</td>
                                                        <td align='center' width="15%" height="1"><?php drawconnector(0,0,$count_r3) ?>&nbsp;</td>
                                                        <td align='center' width="15%" height="1"><?php drawconnector(0,0,$count_r4) ?>&nbsp;</td>
                                                        <td align='center' width="15%" height="1"><?php drawconnector(1,0,$count_r5) ?>&nbsp;</td>
                                                        <td align='center' width="25%" style="border-right-style: solid; border-right-width: 1" height="1"><font size="4" face="ASBW-TTDurga">
                                                            <b><?php echo $r6->loc_name ?></b>
                                                            </font><b><font color="#009933" size="2" face="Verdana">
                                                                <a onClick="return ConfDel()" class='hide' href="location_delete.asp?dist_code=<?php echo $r1->dist_code ?>&Subdiv_code=<?php echo $r2->subdiv_code ?>&Cir_code=<?php echo $r3->cir_code ?>&Mouza_Pargona_code=<?php echo $r4->mouza_pargona_code ?>&Lot_no=<?php echo $r5->lot_no ?>&Vill_townprt_code=<?php echo $r6->vill_townprt_code?>;">
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/wrong.gif" title='Delete'></a>
                                                                <img border="0" src="<?php echo base_url(); ?>application/views/images/modify.gif" title='Modify'  onclick="ModifyLocation('<?php echo $r6->loc_name ?>','<?php echo $r1->dist_code ?>','<?php echo $r2->subdiv_code ?>','<?php echo $r3->cir_code ?>','<?php echo $r4->mouza_pargona_code ?>','<?php echo $r5->lot_no ?>','<?php echo $r6->vill_townprt_code?>');"></font></b><br/>
                                                        </td>
                                                        </tr>
                                                        <?php
                                                        //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r6->loc_name."------><br>";
                                                    }
                                                }
                                            }
                                        }
                                        $level_r2 = $level_r2+1;
                                    }
                                }
                                $level_r1 = $level_r1+1;
                                ?>
                            </table>
                        </form>
                        </center>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 



               













                        