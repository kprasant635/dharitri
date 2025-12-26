<style>
input[type=checkbox]:checked+span{
    background-color: #5fb361 !important;
}
input[type=checkbox]+span{
    background-color: #af6666 !important;
}
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Modify Menu Access</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-6 rasid">Note : Please Check the boxes you want to Permit.</label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        
                        <form method='post'>
                            <table class='table'>
                                <tr style="border-bottom: 2px solid #000;">
                                    <th>Menu Item Name</th>
                                    <th>User Designation<span class="red"> (check <i class='fa fa-check'></i> the box you want to update)</span></th>
                                </tr>
                                <?php foreach ($result_menu as $p): ?>
                                <tr style="border-bottom: 2px solid #000;">
                                    <td width="30%">
                                        <?php echo  $p->controller_name; ?>
                                    </td>
                                    <td>
                                            <?php foreach ($result_designation as $d): 
                                                $function_permission = $this->utilityclass->getBacklogPermission($p->function_name);
                                                if (strpos($function_permission, TRIM($d->user_desig_code)) !== false) {
                                                    echo '<div style="float:left;"><input type="checkbox" class="form grant_permission" id="'.$p->id.'"  value="'.$d->user_desig_code.'" checked>';
                                                    echo '<span class="badge badge-secondary" style="margin-bottom: 10px; background-color: #5fb361; font-size: 18px;margin-right: 5px;">
                                                <i class="fa fa-arrow-left"></i>  '.$d->user_desig_as.'
                                                </span></div>';
                                                } else {
                                                    echo '<div style="float:left;"><input type="checkbox" class="form grant_permission" id="'.$p->id.'"  value="'.$d->user_desig_code.'">';
                                                    echo '<span class="badge badge-secondary" style="margin-bottom: 10px; background-color: #af6666; font-size: 18px;margin-right: 5px;">
                                                <i class="fa fa-arrow-left"></i>  '.$d->user_desig_as.'
                                                </span></div>';
                                                }
                                            endforeach; ?>
<!--                                            <button type="submit" name="submit" class="btn btn-success uni_text"><i class="fa fa-check"></i>&nbsp;Grant Permission</button>-->
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.grant_permission').click(function (e) {
        var id = $(this).attr("id");
        var favorite = [];
        $("input:checkbox[id='" + id + "']:checked").each(function () {
            favorite.push($(this).val());
        });
        var users = favorite.join(", ");
        var formData = { 'users':users, 'id':id};
        $.ajax({
            type: "POST",
            url: baseurl + "initialization/Update_user_permission",
            data: formData,
            success: function (data) {
                var result = JSON.parse(data);
                //console.log(data);
                if(data == 'true'){
                    alert("Update not successfull. There must be some problem.</p></label>");
                }
            }
        });
    });
</script>