<style>
    @media print {
        body { 
            font-size: 8pt;
        }
        @page 
        {
            size:  auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }
        .uni_text{
            font-size: 10px
        }
        p{
            font-size: 10px
        }
        td{
            font-size: 10px !important;
        }
        .onTopNotification{
            display:none;
        }
    }
</style>
<div class="container-fluid form-top login">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-body">
                <!--div 3-->            
                <div id="notice3">
                    <div class="panel-heading">
                        <p align="left" class="uni_text"> অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ </p><br>
                        <p align="right" class="uni_text" style="margin-top: 0; margin-bottom: 0">
                            <?php echo $this->lang->line('name'); ?> : 
                            <?php
                            foreach ($p_in_order as $pop):
                                $relation = $this->utilityclass->get_relation($pop->guard_rel);
                                echo $pop->pet_name . ", " . $relation . "-" . $pop->guard_name . "<br>";
                            endforeach;
                            ?>
                        </p>
                        <div class="panel-title">
                            <p class='center bold uni_text'><u>ORDER SHEET</u></p>
                            <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                            <br>
                            <p class='center bold uni_text'><span class="">Order Sheet, dated from <span style="color: #0093ff;"><?php echo date('d-m-Y', strtotime($location['date'])); ?></span> To <span style="color: #0093ff;"><?php echo date('d-m-Y', strtotime($location['next_date'])); ?></span> District <?php echo $location['dist']; ?> <br>
                                    Case No <?php echo $location['case_no']; ?></span></p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                <table class="table table-bordered" style="font-size: 16px;">
                                    <tr style="color:#0000cc; text-align: center;">
                                        <td>Serial No and Date of Order</td>
                                        <td width="40%">Order and Signature of Officer</td>
                                        <td width="40%">Note Of Action Taken on Order</td>
                                    </tr>
                                    <tr style="color:#0000cc; text-align: center;">
                                        <td>১</td>
                                        <td>২</td>
                                        <td>৩</td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($cases as $case):
                                        ?>
                                        <tr>
                                            <td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                            <td>
                                                <?php echo $case->co_order; ?></td>
                                            <td>
                                                <?php echo $case->note_on_order; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </table>
                                <div class="col-lg-12 center dontshow">
                                    <button class='btn btn-primary' onclick="myFunction()"><i class='fa fa-print'></i> Print this page</button>
                                    <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenRpt"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                                    <div>
                                        <script>
                                            function myFunction() {
                                                $(".dontshow").hide();
                                                window.print();
                                                $(".dontshow").show();

                                            }
                                            function windowClose() {
                                                window.open('', '_parent', '');
                                                window.close();
                                            }

                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--div 4-->   

            </div>
        </div>
    </div>
</div>   

