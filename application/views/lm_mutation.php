
<div class="container-fluid">
    <div class="row">
        <p>&nbsp;</p>
        <div class="col-lg-8 col-lg-offset-2">
            <table class='table' style="color:blue;">
                <tr><td width='5%' style='background: url(<?php echo base_url();?>application/views/img/3.png); background-size:100%'></td>
                    <td><label> LOT MANDAL'S MUTATION MENU</label></td></tr>
            </table>
            
            <section class="ac-container">
                <div>
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1">Write Report on Field Mutation / Partition <span class="pull-right" style="display: inline-block"><a href="<?php echo base_url();?>index.php/lmmutation/mutation">Click</a></span></label>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="checkbox" />
                    <label for="ac-2">Consent of Co-pattadar for Aappooch Batowara >> ( <span class="badge">0</span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-3" name="accordion-1" type="checkbox" />
                    <label for="ac-3">Istahar for field partition cases >> ( <span class="badge">0</span> no. of Istahars )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-4" name="accordion-1" type="checkbox" />
                    <label for="ac-4">CO's order for giving fresh report on Field Mutation >> ( <span class="badge">0</span> no. of petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-5" name="accordion-1" type="checkbox" />
                    <label for="ac-5">Write Byay Prak Kalan for Partition Cases >> ( <span class="badge">0</span> no. of Petitions)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-6" name="accordion-1" type="checkbox" />
                    <label for="ac-6">Write Report on Office Mutation/Partition/Conversion >> 
                        ( <span class="badge alert-danger"> <?php echo count($Pcases); ?></span> no. of Petitions )
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
                            <td><a href="<?php echo base_url();?>index.php/LMconversionPartha?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php echo $case->mut_type;?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-7" name="accordion-1" type="checkbox" />
                    <label for="ac-7">Consent of Co-pattadar for Office Partition >> ( <span class="badge">0</span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-8" name="accordion-1" type="checkbox" />
                    <label for="ac-8">Write Report for Miscellaneous Cases >> ( <span class="badge">0</span> no. of petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-9" name="accordion-1" type="checkbox" />
                    <label for="ac-9">Write Proposal for land Reclassification<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-10" name="accordion-1" type="checkbox" />
                    <label for="ac-10">Modification of Chitha<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
            </section>
            <label>ANNUAL PATTA CANCELLATION (NR CASES)</label>
            <section class="ac-container">
                <div>
                    <input id="ac-11" name="accordion-1" type="checkbox" />
                    <label for="ac-11">Write Report on NR Cases (Regd. by Assistant) >> ( <span class="badge">0</span> no. Pending )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-12" name="accordion-1" type="checkbox" />
                    <label for="ac-12">Write Suo-Moto report on Annual Patta Cancllation (NR Cases) <span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
            </section>
            <label>ANNUAL PATTA CANCELLATION (NR CASES)</label>
            <section class="ac-container">
                <div>
                    <input id="ac-13" name="accordion-1" type="checkbox" />
                    <label for="ac-13">Verify Pending Application & Forward to CO >> ( <span class="badge">0</span> no. Application )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
            </section>
        </div>
    </div>
</div>






