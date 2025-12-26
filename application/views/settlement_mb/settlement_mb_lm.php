<div class="row justify-content-center" style='margin-top:40px'>

    <div class="col-lg-8">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                    <?php 
                        if($_GET['service'] == '13'){
                            echo "SETTLEMENT TENANT";
                        }elseif($_GET['service'] == '14'){
                            echo "SETTLEMENT AP TRANSFER";
                        }elseif($_GET['service'] == '15'){
                            echo "SETTLEMENT TRIBAL COMMUNITY";
                        }elseif($_GET['service'] == '16'){
                            echo "SETTLEMENT KHAS LAND";
                        }elseif($_GET['service'] == '17'){
                            echo "SETTLEMENT PGR VGR LAND";
                        }elseif($_GET['service'] == '18'){
                            echo "SETTLEMENT SPECIAL CULTIVATORS";
                        }
                    ?>
                    
                    <!-- <?php echo $this->lang->line('settlement_tenant') ?> -->
                
                    </p>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <?php if($service_code==14) { ?>
                    <tr class="">
                        <td>General Notice Generated cases (Pending LM Report)</td>
                        <td><?php
                            if ($notice_generated != '0') {
                                echo "<span class=\"badge badge-danger\">$notice_generated</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementMbLm/apNoticeGeneratedCaseForLmReport?service='.$service_code; ?>" style="float:right">view</a></td>
                    </tr>
                    <tr class="">
                        <td>NR to Settlement Cases</td>
                        <td><?php
                            if ($nrcase != '0') {
                                echo "<span class=\"badge badge-danger\">$nrcase</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementMbLm/nrCases?service='.$service_code; ?>" style="float:right">view</a></td>
                    </tr>
                    <?php } ?>

                    <?php
                    if($service_code == SETTLEMENT_TENANT_URBAN_ID){
                    ?>
                        <tr class="">
                            <td>Forwarded by CO</td>
                            <td><?php
                                if ($forwarded_by_co != '0') {
                                    echo "<span class=\"badge badge-danger\">$forwarded_by_co</span>";
                                }
                                ?>
                            </td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbLm/forwardedCasesByCo?service='.$service_code; ?>" style="float:right">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                    <tr class="">
                        <td>Reverted Back from CO</td>
                        <td><?php
                            if ($reverted != '0') {
                                echo "<span class=\"badge badge-danger\">$reverted</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementMbLm/revertedCases?service='.$service_code; ?>" style="float:right">view</a></td>
                    </tr>

                    <?php
                    if($service_code == '17')
                    {
                        ?>
                        <tr class="">
                            <td>PGR/VGR reservation inquiry from CO</td>
                            <td><?php
                                if ($reservation_req != '0') {
                                    echo "<span class=\"badge badge-danger\">$reservation_req</span>";
                                }
                                ?>
                            </td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementVgr/vgrReservationInquiryList?service='.$service_code; ?>" style="float:right">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                    <?php 
                        if($service_code != '13' && $service_code != SETTLEMENT_TENANT_URBAN_ID)
                        {
                            ?>
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
                                    <a href="<?php echo base_url() . 'index.php/SettlementMbLm/noticeGeneratedCases?service='.$service_code; ?>" style="float:right">view</a>
                                </td>
                            </tr>
                            <?php
                        }
                    
                    ?>


                    
                </table>
            </div>


        

            <?php
            if($service_code != SETTLEMENT_TENANT_URBAN_ID){
            ?>
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular font-weight-bold">
                        <?php 
                            echo "Review Case(s)";
                        ?>
                    
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tr class="">
                            <td class="font-weight-bold">Review applications forwarded by CO</td>
                            <td><?php
                                if ($reverted_review != '0') {
                                    echo "<span class=\"badge badge-danger\">$reverted_review</span>";
                                }else{
                                    echo "<span class=\"badge badge-danger\">0</span>";
                                }
                                ?>
                            </td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbLm/revertedCasesReview?service='.$service_code; ?>" style="float:right">view</a></td>
                        </tr>                    
                    </table>
                </div>

            <?php }?>
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