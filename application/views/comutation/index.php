<div class="container-fluid">
    <div class="row">
        <p>&nbsp;</p>
        <div class="col-lg-8 col-lg-offset-2">
            <table class='table' style="color:blue;">
                <tr><td width='5%' style='background: url(<?php echo base_url();?>application/views/img/3.png); background-size:100%'></td>
                    <td><label><?php echo $this->lang->line('sk_mutation_menu');?></label></td></tr>
            </table>
            
            <section class="ac-container">
                <div>
                    <input id="ac-1" name="accordion-1" type="checkbox" />
                    <label for="ac-1"><?php echo $this->lang->line('write_note_on_field_mutation_/_partition');?> <span class="pull-right"><a href="<?php echo base_url();?>index.php/lmmutation/mutation"><?php echo $this->lang->line('click');?></a></span></label>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="checkbox" />
                    <label for="ac-2"><?php echo $this->lang->line('consent_of_co-pattadar_for_aappooch_batowara');?> >> ( <span class="badge">0</span> no. of Pending Cases)<span class="pull-right"><?php echo $this->lang->line('click');?></span></label>
                    <article class="ac-medium">
                        <p></p>
                    </article>
                </div>
                <div>
                    <input id="ac-3" name="accordion-1" type="checkbox" />
                    <label for="ac-3"><?php echo $this->lang->line('istahar_for_field_partition_cases');?>>> ( <span class="badge">0</span> no. of Istahars )<span class="pull-right"><?php echo $this->lang->line('click');?></span></label>
                    <article class="ac-large">
                        <p></p>
                    </article>
                </div>
        </div>
    </div>
</div>






