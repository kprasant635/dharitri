<div class="container-fluid">
    <div class="row">
        <p>&nbsp;</p>
        <div class="col-lg-8 col-lg-offset-2">
            <table class='table' style="color:blue;">
                <tr><td width='5%' style='background: url(<?php echo base_url();?>application/views/img/3.png); background-size:100%'></td>
                    <td><label> ASSISTANT (CO'S) MUTATION MENU</label></td></tr>
            </table>
            
            <section class="ac-container">
                <div>
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1">Register Mutation / Partition / Conversion Petition  <span class="pull-right" style="display: inline-block"><a href="<?php echo base_url();?>index.php/lmmutation/mutation">Click</a></span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1">Register Conversion Petition  <span class="pull-right" style="display: inline-block"><a href="<?php echo base_url();?>index.php/AsistantMutationPartha/Conversion">Click</a></span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="checkbox" />
                    <label for="ac-2">Register Miscellaneous Cases  >> ( <span class="badge">0</span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-3" name="accordion-1" type="checkbox" />
                    <label for="ac-3">Register Objection Petition Under Rule 53A(2) >> ( <span class="badge">0</span> no. of Istahars )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-4" name="accordion-1" type="checkbox" />
                    <label for="ac-4">Objection Cancellation order from CO [Under Rule 53A(2)]  >> ( <span class="badge">0</span> no. of petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-5" name="accordion-1" type="checkbox" />
                    <label for="ac-5">Register Land Reclassification Petition  >> ( <span class="badge">0</span> no. of Petitions)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-6" name="accordion-1" type="checkbox" />
                    <label for="ac-6">Notice Generation for Petitioners and concerned parties >> ( <span class="badge badge-danger"><?php echo count($Pcases); ?></span> no. of Petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <table class="table table-striped">
                            <thead>
                                <th>Case No</th>
                                <th>Type</th>
                                <th>Submition Date</th>
                                <th>Due Date</th>
                            </thead>
                            <?php foreach ($Pcases as $case): ?>
                            <tr>
                            <td><a href="<?php echo base_url();?>index.php/AsistantMutationPartha/notice_generation?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php 
                                    if ($case->mut_type == '01')
                                    {
                                        echo "Convertion Case";
                                    }
                                ?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->next_date_of_hearing));?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-7" name="accordion-1" type="checkbox" />
                    <label for="ac-7">Note of Action Taken on Proceeeding Order  >> ( <span class="badge badge-danger"><?php echo count($cases); ?></span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <table class="table table-striped">
                            <thead>
                                <th>Case No</th>
                                <th>Type</th>
                                <th>Submition Date</th>
                                <th>Due Date</th>
                            </thead>
                            <?php foreach ($cases as $case): ?>
                            <tr>
                            <td><a href="<?php echo base_url();?>index.php/AsistantMutationPartha/notice_action_taken?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php 
                                    if ($case->mut_type == '01')
                                    {
                                        echo "Convertion Case";
                                    }
                                ?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->next_date_of_hearing));?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-8" name="accordion-1" type="checkbox" />
                    <label for="ac-8">Confirmation of payment by parties(Partition Case)  >> ( <span class="badge">0</span> no. of petitions )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-9" name="accordion-1" type="checkbox" />
                    <label for="ac-9">Notice Generation for clearing Premium(Conversion Case) >> ( <span class="badge badge-danger"><?php echo count($premium); ?></span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <table class="table table-striped">
                            <thead>
                                <th>Case No</th>
                                <th>Type</th>
                                <th>Submition Date</th>
                                <th>Due Date</th>
                            </thead>
                            <?php foreach ($premium as $case): ?>
                            <tr>
                            <td><a href="<?php echo base_url();?>index.php/AsistantMutationPartha/notice_premium?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php 
                                    if ($case->mut_type == '01')
                                    {
                                        echo "Convertion Case";
                                    }
                                ?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->next_date_of_hearing));?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-10" name="accordion-1" type="checkbox" />
                    <label for="ac-10">Confirmation of payment of Premium(Conversion Case) >> ( <span class="badge badge-danger"><?php echo count($payment); ?></span> no. of Pending Cases)<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <table class="table table-striped">
                            <thead>
                                <th>Case No</th>
                                <th>Type</th>
                                <th>Submition Date</th>
                                <th>Due Date</th>
                            </thead>
                            <?php foreach ($payment as $case): ?>
                            <tr>
                            <td><a href="<?php echo base_url();?>index.php/AsistantMutationPartha/confirmation_premium?case_no=<?php echo $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php 
                                    if ($case->mut_type == '01')
                                    {
                                        echo "Convertion Case";
                                    }
                                ?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                            <td><?php echo date('d-m-Y',strtotime($case->next_date_of_hearing));?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </article>
                </div>
                <div>
                    <input id="ac-11" name="accordion-1" type="checkbox" />
                    <label for="ac-11">Istahar for office partition case >> ( <span class="badge">0</span> no. Pending )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-12" name="accordion-1" type="checkbox" />
                    <label for="ac-12">Write Petition for Annual Patta Cancellation (NR Case) <span class="pull-right">Click</span>
                    </label>
                </div>
                <div>
                    <input id="ac-13" name="accordion-1" type="checkbox" />
                    <label for="ac-13">Issue Show Cause Notice (NR Case)  >> ( <span class="badge">0</span> no. Application )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-13" name="accordion-1" type="checkbox" />
                    <label for="ac-13">Go for Citizen Centric Certificate   >> ( <span class="badge">0</span> no. Application )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-13" name="accordion-1" type="checkbox" />
                    <label for="ac-13">Go for Citizen Centric Certificate   >> ( <span class="badge">0</span> no. Application )<span class="pull-right">Click</span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
            </section>
        </div>
    </div>
</div>






