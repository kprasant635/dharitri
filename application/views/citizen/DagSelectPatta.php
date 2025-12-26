
        <div class="col-md-12">
            <h2>Select Dag for this Patta</h2>
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/ChithaReport/generateChithaCitizen">
                    <fieldset>
                     <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 col-sm-3 control-label">Select Dag</label>
                        <div class="col-lg-3 col-sm-3 ">
                            <select class="form-control" name="dag_no">
                                <option>Select Option</option>
                                <?php
                                    foreach($dag as $d)
                                    {
                                 ?>
                                <option value="<?php echo $d->dag_no ?>"><?php echo $d->dag_no ?></option>
                                <?php        
                                    }
                                ?>
                            </select>
                        </div>
                      </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-info col-lg-offset-3 col-sm-offset-3" name="">See Chitha</button>
                        </div>
                   </fieldset>
            </form>
            
       </div>
  
<script type="text/javascript">
        document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home";
    };
</script>

