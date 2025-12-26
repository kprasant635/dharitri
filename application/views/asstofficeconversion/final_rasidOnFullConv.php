<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        //border: solid 1px black;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
    }
</style>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <p class='center bold uni_text' style="font-size: 28px; font-weight: bold;"><u>অসম চৰকাৰ</u></p>
                    <p class='center bold uni_text' style="color: #990000;"><u>চক্র্ বিষয়াৰ কাৰ্য্যালয়, <?php echo $location['cir']; ?></u></p>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <table class='rasid-t' width="100%">
                            <tr>
                                <td>এই আবেদন 
                                    <?php
                                    $count = 1;
                                    $howmany = sizeof($pattadar) - 1;
                                    //echo $howmany;
                                    foreach ($pattadar as $p):
                                        ?>
                                        <span style="color:red;">
                                            <?php echo $p['pdar_cron_no'] . ") "; ?>
                                            <?php echo $p['pdar_name']; ?>
                                        </span>
                                        <?php //echo $p['pdar_rel_guar']; ?>
                                        <?php
                                        echo "( " . $p['pdar_guardian'] . " )";
                                        if ($count < sizeof($pattadar) - 1) {
                                            echo " , ";
                                            $count++;
                                        } elseif ($count == sizeof($pattadar) - 1) {
                                            echo " আৰু ";
                                            $count++;
                                        } else {
                                            echo " ";
                                        }
                                        ?>
                                    <?php endforeach; ?>ৰ পৰা গ্রহন কৰা হ'ল ।
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($date)); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 40px;"><?php echo $location['user_name']; ?><br>
                                    চক্র বিষয়া,&nbsp;<?php echo $location['cir']; ?></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;" class="dontshow">
                        <div class="row">
                            <center>
                                <h4 class="bold dontshow">Note : Click the button below to Print and Proceed.</h4>
                                <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/save_all_dataOnFullConv"; ?>" class="btn btn-success uni_text dontshow" onclick="myFunction()"><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        $(".dontshow").hide();

        window.print();
        $(".dontshow").show();
        document.getElementById("mainMenu").disabled = false;
    }
</script>

