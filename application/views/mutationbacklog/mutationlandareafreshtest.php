<style type="text/css">
    label{
        width: 20%;
    }
    input{
        width: 75%;
        margin-bottom: 10px;    
    }
</style>
<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Select Location</li>
                <li class="progtrckr-done secondtick">Transfer Type</li>
                <li class="progtrckr-done thirdtick">Applicant Details</li>
                <li class="progtrckr-done fourthtick">Mutation Land Area</li>
            </ol>
        </div>
    </div>
    <div class="col-lg-12 ">
        <div class="col-lg-11" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('mutated_land_area_for_field_mutation')?></p>
                        </div>
                    </div>
                    <div id="alerts"></div>
                    <div class='panel-body'>
                        <hr>

                        <form method="post" action="<?php echo base_url() . "index.php/lmmutation/landAreaFresh"; ?>">
                                <table class="table">
                                <tr>
                                <th class='alert-new'>
                               <?php echo $this->lang->line('dag_no')?>
                                </th>
                                <th class='alert-new'>
                            <?php echo $this->lang->line('dag_area')?>
                                </th>
                                <th class='alert-new'>
                              <?php echo $this->lang->line('mutation_land_area')?>
                                </th>
                                <th class='alert-new'>
                                   <?php echo $this->lang->line('remaining_land_area')?>
                                </th>
                                </tr>
                                <tr>
                                    <td>
                                       <input type="text" name="dag_no" value="<?php echo $dag->dag_no;?>"></input>
                                    </td>
                                    <td>
                                       <label><?php echo $this->lang->line('bigha')?></label><input type="text" name='dag_area_b' value="<?php echo $dag->dag_area_b;?>"></input>
                                       <label><?php echo $this->lang->line('katha')?></label><input type="text"  name='dag_area_k' value="<?php echo $dag->dag_area_k;?>"></input>
                                       <label><?php echo $this->lang->line('lessa')?></label><input type="text" name='dag_area_lc' value="<?php echo $dag->dag_area_lc;?>"></input>
                                       <label><?php echo $this->lang->line('ganda')?></label><input type="text" name='dag_area_g' value="<?php echo $dag->dag_area_g;?>"></input>
                                       <label><?php echo $this->lang->line('krantik')?></label><input type="text" name='dag_area_kr' value="<?php echo $dag->dag_area_kr;?>"></input>
                                    </td>
                                    <td>
                                        <label><?php echo $this->lang->line('bigha')?></label><input type="text" name='m_dag_area_b' value="<?php echo $dag->m_dag_area_b;?>"></input>
                                       <label><?php echo $this->lang->line('katha')?></label><input type="text" name='m_dag_area_k' value="<?php echo $dag->m_dag_area_k;?>"></input>
                                       <label><?php echo $this->lang->line('lessa')?></label><input type="text" name='m_dag_area_lc' value="<?php echo $dag->m_dag_area_lc;?>"></input>
                                       <label><?php echo $this->lang->line('ganda')?></label><input type="text" name='m_dag_area_g' value="<?php echo $dag->m_dag_area_g;?>"></input>
                                       <label><?php echo $this->lang->line('krantik')?></label><input type="text" name='m_dag_area_kr'  value="<?php echo $dag->m_dag_area_kr;?>"></input>
                                    </td>
                                    <td>
                                        <label><?php echo $this->lang->line('bigha')?></label><input type="text"  value="<?php echo $dag->dag_area_b;?>"></input>
                                       <label><?php echo $this->lang->line('katha')?></label><input type="text"  value="<?php echo $dag->dag_area_k;?>"></input>
                                       <label><?php echo $this->lang->line('lessa')?></label><input type="text"  value="<?php echo $dag->dag_area_lc;?>"></input>
                                       <label><?php echo $this->lang->line('ganda')?></label><input type="text"  value="<?php echo $dag->dag_area_g;?>"></input>
                                       <label><?php echo $this->lang->line('krantik')?></label><input type="text"  value="<?php echo $dag->dag_area_kr;?>"></input>
                                    </td>

                                </tr>
                                </table>
                                <input type="Submit" class="btn btn-danger"><?php echo $this->lang->line('submit_button')?></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




