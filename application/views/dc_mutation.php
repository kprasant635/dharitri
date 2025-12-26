
<div class="container-fluid">
    <div class="row">
        <p>&nbsp;</p>
        <div class="col-lg-8 col-lg-offset-2">
            <table class='table' style="color:blue;">
                <tr><td width='5%' style='background: url(<?php echo base_url(); ?>application/views/img/3.png); background-size:100%'></td>
                    <td><label> Deputy Commissioner's (DC) MUTATION MENU</label></td></tr>
            </table>
            
            <section class="ac-container">
                <div>
                    <input id="ac-6" name="accordion-1" type="checkbox" />
                    <label for="ac-6" style="text-transform: uppercase;">RECLASSIFICATION</label>
                </div>
                <div>
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1">Recommend Reclassification Proposals( <span class="badge"><?php //echo count($countAPCaseforCO); ?>0</span> no. of Proposals) <span class="pull-right">Click</span></label>
                     <article class="ac-medium"></article>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="checkbox" />
                    <label for="ac-2">Generate Transmission files for recommended Reclassification Proposals<span class="pull-right">Click</span></label>
                     <article class="ac-medium"></article>
                </div>

                <div>
                    <input id="ac-3" name="accordion-1" type="checkbox" />
                    <label for="ac-3" style="text-transform: uppercase;">Give approval on AP Cancellation (NR Case)</label>
                </div>
                
                <div>
                    <input id="ac-4" name="accordion-1" type="checkbox" />
                    <label for="ac-4">Write report on Cancellation Matter ( <span class="badge"><?php echo count($getDCAPCancellation);?></span> no. of Petitions)
                    <a href="<?php echo base_url(); ?>index.php/APCancellation/DCAPStep1">
                                <span class="pull-right">Click</span>
                    </a>
                    </label>
                    
                </div>
                <div>
                    <input id="ac-5" name="accordion-1" type="checkbox" />
                    <label for="ac-5">Generate Transmission files for Approved AP Cancellation Cases<span class="pull-right">Click</span></label>
                     <article class="ac-medium"></article>
                </div>
                
                
            </section>
        </div>
    </div>
</div>