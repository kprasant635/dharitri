<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Disable this User?'))
            return (false);
        return (true);
    }
    function Confadd() {
        if (!confirm('Really want to Enable this User?'))
            return (false);
        return (true);
    }
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Manual Doul backup</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Manual Doul backup
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text">
                                <b><img src="<?php echo base_url(); ?>application/views/images/Exclamation.gif" width="5%"> : Execute the following script first </b><br>
                                <label>insert into chitha_pattadar_doul(select * from chitha_pattadar);</label><br>
                                <label>update chitha_pattadar_doul set year_no = '2017'</label>
                                <label>insert into chitha_dag_pattadar_doul(select * from chitha_dag_pattadar);</label><br>
                                <label>update chitha_dag_pattadar_doul set year_no = '2017'</label>
                            </h6>
                        </div>
                        
                        <table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td class="bold">District</td>
                                    <td class="bold">Sub Division</td>
                                    <td class="bold">Circle</td>
                                    <td class="bold">Chitha Records</td>
                                    <td class="bold">Total  Updated</td>
                                    <td class="bold">Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($circle as $c) {
                                    ?>
                                    <tr>
                                        <td><?php echo $c['dist_name']; ?></td>
                                        <td><?php echo $c['subdiv_name']; ?></td>
                                        <td><?php echo $c['cir_name']; ?></td>
                                        <td><?php echo $c['chitha_basic_record']; ?></td>
                                        <td><?php echo $c['chitha_basic_doul_record']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'index.php/initialization/start_the_backup?dist_code='. $c['dist_code'].'&subdiv_code='. $c['subdiv_code'].'&cir_code='. $c['cir_code']?>" title="Backup Data">
                                            <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
    });
    
    $('.district_wdb').change(function (e) {
        var distCode = $(this).val();
        //alert("aa" + baseurl);
        console.log("aa" + baseurl);
        $.ajax({
            url: baseurl + "Utility/getSubdivJson_wdb/" + distCode,
            success: function (data) {
                console.log(data);
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Sub Division</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].subdiv_code + "'>" + subdivcode[i].loc_name + "</option>"
                }
                console.log(template);
                $('.subdivselect_wdb').html(template);
            }
        });
    });
    $('.subdivselect_wdb').change(function (e) {
        var subdivcode = $(this).val();
        var distcode = $('.district_wdb').val();
        $.ajax({
            url: baseurl + "Utility/getCirCodeJson_wdb/" + distcode + '/' + subdivcode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var circode = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";

                for (var i = 0; i < circode.length; i++) {
                    template += "<option value='" + circode[i].cir_code + "'>" + circode[i].loc_name + "</option>";
                }
                console.log(template);
                $('.circleselect_wdb').html(template);
            }
        });
    });
</script>