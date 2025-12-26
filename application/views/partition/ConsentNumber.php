<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 panel-form col-lg-offset-1" style="padding: 10px">
            <h2 class="text-center uni_text"><?php echo $this->lang->line('copattadar_consent_rpt'); ?>: <?php //echo $d['case_no'] ?></h2>
            
            <p class="red uni_text">Note :Please don't fill blank the Copattadar consent field. If pattadar consent not found type <span class="green">NIL</span> </p>
            <form action="<?php echo base_url()?>index.php/partition/SaveConsentF" method="POST">
            <table class="table table-striped">
                <tr class="info">
                    <th class="text-center">
                        <span class="text-danger" >Check All</span> <br><input type="checkbox" id="selectall" class="squaredTwo">
                    </th><th class="text-center">Copattadar's Name</th><th class="text-center">Copattadar's consent</th>
                </tr>
               
                <?php	
                //var_dump($values);
                $num=sizeof($values);
                if($num >='1')
                {
                foreach($values as $d)
                {
                    $i=1;
                ?>   
                <tr class="center">
                    <td><input type="checkbox" name="chekbox[]" value="Y" class="squaredTwo checkboxall"> </td> 
                    <td><?php echo $d['pdar_name'] ?> </td>
                    <td> 
                      <textarea class="form-control" name="copattadar_comment[]" rows="3"> <?php  echo $d['pdar_name'] ;?> ৰ সন্মতি দিয়া হল | </textarea>
                </td>
                <input type="hidden" value="<?php echo $d['pdar_name'] ?>" name='copattadar_name[]' >
                <input type="hidden" value="<?php echo $d['pdar_id'] ?>" name='copattadar_id[]' >
                <input type="hidden" value="<?php echo $d['case_no'] ?>" name='case_number' >
                <input type="hidden" value="<?php echo $d['patta_no'] ?>" name='patta_no' >
                <input type="hidden" value="<?php echo $d['dag_no'] ?>" name='dag_no' >
                <input type="hidden" value="<?php echo $d['vill_townprt_code'] ?>" name='vill_townprt_code' >
                <input type="hidden" value="<?php echo $d['patta_type_code'] ?>" name='patta_type_code' >    
                <input type="hidden" value="<?php echo $d['case_no'] ?>" name='case_no' >  
                </tr>  
               
                <?php
                }
                }
               else
                {
                    redirect(base_url() . 'index.php/partition/UpdatedAllConsent');
                }
                ?>
                
            </table>
                 <center> <button type="submit" class="btn btn-info" name='submit' value="Submit" />Submit</button></center>
                  </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
$("#selectall").click(function(){
        if(this.checked){
            $('.checkboxall').each(function(){
                this.checked = true;
            })
        }else{
            $('.checkboxall').each(function(){
                this.checked = false;
            })
        }
    });
});

</script>

