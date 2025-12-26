<div class="container-fluid form-top">
    <div class="row">
        <p>&nbsp;</p>
        <div class="col-lg-8 col-lg-offset-2">
            <table class='table' style="color:blue;">
                <tr><td width='5%' style='background: url(<?php echo base_url();?>application/views/img/3.png); background-size:100%'></td>
                    <td><label> CO'S Partition MENU</label></td></tr>
            </table>
            <?php //print_r($case);?>
            <section class="ac-container">
                <div >
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1">Write 1st Proceeding for <span class="badge"><?php echo $case[0]->total_case; ?></span> Fresh Cases  <span class="pull-right" style="display: inline-block"><a href="<?php echo base_url();?>index.php/partition/FirstProceeding">Click</a></span></label>
                    <article class="ac-medium" style=" overflow-y: auto ">
                        <table class="table table-border" >
                            <tr class="fixed">
                                <th>Case No</th><th>Type</th><th>Submission Date</th>
                            </tr>
                            <?php
                            //print_r($result);
                            foreach ($result as $r)
                            {
                            ?>
                            <tr class="text-center"><td><a href="<?php echo base_url().'index.php/partition/FirstProceding' ?>?&dist_code=<?php echo $r->dist_code ?>&subdiv_code=<?php echo $r->subdiv_code?>&cir_code=<?php echo $r->cir_code?>&case_no=<?php echo $r->case_no ?>" class="btn btn-active" ><?php echo $r->case_no;?></a></td><td>Partition Case</td><td><?php echo $r->submission_date; ?></td></tr>
                            <?php } ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="checkbox" />
                    <label for="ac-2">Write Next Proceeding for <span class="badge"><?php echo $sec_total->sec_total; ?></span> Running Cases  (Also showing <span class="badge">0</span> Case(s) shortlisted for next week) <span class="pull-right" style="display: inline-block"><a href="<?php echo base_url();?>index.php/partition/COSecondProc">Click</a></span></label>
                    <article class="ac-medium">
<!--                        <a href="<?php //echo base_url();?>index.php/partition/COSecondProc">Click Here</a>-->
                        <table class="table table-border" >
                            <tr class="fixed">
                                <th>Case No</th><th>Type</th><th>Submission Date</th>
                            </tr>
                            <?php
                            //print_r($result);
                            foreach ($secondR as $r)
                            {
                            ?>
                            <tr class="text-center"><td><a href="<?php echo base_url().'index.php/partition/COSecondProc' ?>?&dist_code=<?php echo $r->dist_code ?>&subdiv_code=<?php echo $r->subdiv_code?>&cir_code=<?php echo $r->cir_code?>&case_no=<?php echo $r->case_no ?>" class="btn btn-active" ><?php echo $r->case_no;?></a></td><td>Partition Case</td><td><?php echo $r->submission_date; ?></td></tr>
                            <?php } ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-3" name="accordion-1" type="checkbox" />
                    <label for="ac-3">Resume Proceeding case(s) kept Pending by You   >> ( <span class="badge">0</span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-4" name="accordion-1" type="checkbox" />
                    <label for="ac-4">Generate Proceeding Report >> ( <span class="badge">0</span> no. of Istahars )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
               
            </section>
        </div>
    </div>
</div>
    <script>
    $("#submit").click(function(){
    alert("The paragraph was clicked.");
    });
    </script>






