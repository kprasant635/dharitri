<div class="col-md-12 text-right text-cyan">
    Process > Settlement MB3 > <b>Tea Grant</b>
</div>
<div class="row justify-content-center" style='margin-top:40px'>

    <div class="col-lg-8">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                        <?php
                            if($_GET['service'] == TEA_SERVICE_CODE){
                                echo TEA_SERVICE_NAME;
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    
                    <tr class="">
                        <td>Forwarded By CO</td>
                        <td><?php
                            if ($forwarded_by_co != '0') {
                                echo "<span class=\"badge badge-danger\">$forwarded_by_co</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?=base_url().'index.php/TeaGrantControllerLm/forwardedByCo?service='.TEA_SERVICE_CODE ?>" style="float:right">view</a></td>
                    </tr>

                    <tr class="">
                        <td>Reverted Back from CO</td>
                        <td><?php
                            if ($reverted != '0') {
                                echo "<span class=\"badge badge-danger\">$reverted</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?=base_url().'index.php/TeaGrantControllerLm/revertedCases?service='.TEA_SERVICE_CODE ?>" style="float:right">view</a></td>
                    </tr>

                    <tr class="">
                        <td>Final verification before Patta Generation</td>
                        <td><?php
                            if ($final_verify_after_pn != '0') {
                                echo "<span class=\"badge badge-danger\">$final_verify_after_pn</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?=base_url().'index.php/TeaGrantControllerLm/pendingCaseListForFinalVerify'?>" style="float:right">view</a></td>
                    </tr>


                    
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>