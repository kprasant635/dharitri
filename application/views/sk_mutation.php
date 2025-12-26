<div class="container-fluid" style="min-height: 430px;">
    <div class="row">
        <p>&nbsp;</p>
        <div class="col-lg-8 col-lg-offset-2">
            <table class='table' style="color:blue;">
                <tr><td width='5%' style='background: url(<?php echo base_url();?>application/views/img/3.png); background-size:100%'></td>
                    <td><label> SUPERVISOR KANANGO (SK)'S MUTATION MENU</label></td></tr>
            </table>
            <section class="ac-container">
                <div>
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1">Write notes on OFFICE Mutation, Partition & Conversion >> 
                        ( <span class="badge badge-danger"><?php echo count($Pcases); ?></span> no. of petitions)
                        <span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <table class="table table-striped">
                            <thead>
                                <th>Case No</th>
                                <th>Type</th>
                                <th>Submition Date</th>
                            </thead>
                            <?php foreach ($Pcases as $case): ?>
                            <tr>
                            <td><a href="<?php echo base_url();?>index.php/SKconversionPartha?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php echo $case->mut_type;?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="checkbox" />
                    <label for="ac-2">Write notes on FIELD Mutation & Partition >> ( <span class="badge">0</span> no. of petitions)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-3" name="accordion-1" type="checkbox" />
                    <label for="ac-3">Write notes on Miscellaneous Cases >> ( <span class="badge">0</span> no. of petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-4" name="accordion-1" type="checkbox" />
                    <label for="ac-4">Write notes on Annual Patta Cancellation (NR Cases) >> ( <span class="badge">0</span> no. of petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
            </section>
        </div>
    </div>
</div>








