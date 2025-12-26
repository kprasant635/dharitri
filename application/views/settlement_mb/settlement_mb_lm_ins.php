<div class="row justify-content-center" style='margin-top:40px'>

    <div class="col-lg-8">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                    <?php 
                        if($_GET['service'] == '45'){
                            echo NJS_TAGLINE;
                        }
                    ?>
                    </p>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                 
                    <tr class="">
                        <td>Forwarded by CO</td>
                        <td><?php
                            if ($forwarded_by_co != '0') {
                                echo "<span class=\"badge badge-danger\">$forwarded_by_co</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementInstitutionLm/forwardedCasesByCo?service='.$service_code; ?>" style="float:right">view</a></td>
                    </tr>
              

                    <tr class="">
                        <td>Reverted Back from CO</td>
                        <td><?php
                            if ($reverted != '0') {
                                echo "<span class=\"badge badge-danger\">$reverted</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementInstitutionLm/revertedCases?service='.$service_code; ?>" style="float:right">view</a></td>
                    </tr>

                    <tr class="">
                        <td>Final Verification before patta generation</td>
                        <td><?php
                            if ($notice_generated_count != '0') 
                            {
                                echo "<span class=\"badge badge-danger\">$notice_generated_count</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/SettlementInstitutionLm/noticeGeneratedCases?service='.$service_code; ?>" style="float:right">view</a>
                        </td>
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