<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">  Transfer Pattadar Name from Jamabandi to Chitha Dags  </h2>
                    <h2 class="red" style="text-align: center;">Please select the pattadar name as well their corresponding dag where the pattadar's name is to be transfered.</h2>
                </div>
            </div>  
            <form class='form-horizontal' name="form" method="POST" action="<?php echo base_url() . "index.php/JamaeditEntry/transferpattadars"; ?>" enctype="multipart/form-data">
                <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Pattadar Name in Jamabandi
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <label><font color=blue size=4>Sequence to be followed for Transferring Pattadar :</font></label><br>
                                <label>1) First select a pattadar from the drop down below . </label><br>
                                <label>2) Note : The drop down contains all the pattadar name from jamabandi.</label>&nbsp;&nbsp;
                                <label>3) The Result will display all the dags assigned and not assigned. </label>&nbsp;&nbsp;
                                <label>3) Tick the check box to assign the pattadar to that particular dag. </label>
                                <hr style="border-bottom: 2px solid #000;">
                                <br>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 red control-label">Select Pattadar</label>
                                    <div class="col-sm-8">
                                        <select class='form-control pdar_dag' required name='pdar'>
                                            <option selected>Select Name Of Pattadar</option>
                                                <?php
                                                foreach($pattadars as $p):
                                                    if ($p->p_flag == 1) {
                                                        echo '<option value='.$p->pdar_id.' style="color:#ff0000;text-decoration: line-through;">'.$p->pdar_name .' ( '. $p->pdar_father .' )</option>';
                                                    } else {
                                                        echo '<option value='.$p->pdar_id.'>'.$p->pdar_name .' ( '. $p->pdar_father .' )</option>';
                                                    }
                                                endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-12 center">
                                    <button type="submit" class="btn btn-success submit" disabled><i class='fa fa-check'></i>&nbsp; Submit</button>
                                    <a class="btn btn-danger" href="<?php echo base_url();?>index.php/jamaeditentry/pattadarlist/"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Pattadar Name in Chitha Based on Dags
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                    <label>Note : <span style="Color:#ff0000;text-decoration: line-through">stricked through</span> means the pattadar is stricked out in that dag. </label><br>
                                    <table class='table table-stripped table-hover dag'>

                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".pdar_dag").change(function () {
            var selectedVal = $(".pdar_dag option:selected").val();

            $.ajax({
                url: baseurl + "jamaeditentry/getPdarAllocatedDagDetails/" + selectedVal,
                success: function (data) {
                    var result = JSON.parse(data);
                    var template = "<tr><td>Dag No</td><td colspan='2'>Pattadar Name ( Gurdian Name )</td><td>Assign</td></tr>"
                    if ( result.length == 0 ) {
                        template += '<tr class="danger"><td colspan="4"><span style="Color:#ff0000;">This Pattadar Doesnot Exists in any Dag..!</span></td></tr>';
                    } else {
                        for (var i = 0; i < result.length; i++) {
                            if (result[i].p_flag == 1) {
                                var classa = 'danger';
                                var stylea = 'Color:#ff0000;text-decoration: line-through';
                            } 
                            if (result[i].pdar_id =='') {
                                var classa = 'danger';
                                var stylea = 'Color:#ff0000;';
                                template += '<tr class="'+classa+'"><td><span style="'+stylea+'">' + result[i].dag + '</span></td><td colspan="2"><span style="'+stylea+'">' + result[i].pdar_name + '</span></td><td><label><input type="checkbox" name="dag_dag_no[]" value="'+ result[i].dag +'" required  id="myCheck" onclick="myFunction()">&nbsp;</label></td></tr>';
                            } else {
                                template += '<tr class="'+classa+'"><td><span style="'+stylea+'">' + result[i].dag + '</span></td><td><span style="'+stylea+'">' + result[i].pdar_name + '</span></td><td><span style="'+stylea+'">' + result[i].pdar_father + '</span></td><td><label><i class="fa fa-check"></i>&nbsp;</label></td></tr>';
                            }
                            
                        }
                    }
                    //console.log(template);
                    $('.dag').html(template);
                }
            })
        });
    });
    
    
    function myFunction() {
        $('.submit:button').prop('disabled', $('input:checkbox:checked').length == 0)
    }
</script>