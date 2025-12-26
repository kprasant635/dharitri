<script>
     $(function () {
        $('#vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });
            
        });
    });
</script>
<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
           
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('lm_report')?>(<?php echo $this->lang->line('case_no')?> -<?php echo $case_no;?>)</p>
                    </div>
                </div>
                
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter' id='cases' style="text-align: center;">
                        <tr>
                            <th class='alert-new center'><?php echo $this->lang->line('lm_report')?></th>
                            <th class='alert-new center'><?php echo $this->lang->line('dispute')?></th>
                        </tr>
                        <tr>
                            <td>
                                 <?php echo $note->report_on_possession;?>
                             </td>
                             <td>
                                <?php 
                                    if($note->dispute){
                                      echo $this->lang->line('yes');
                                    }
                                    else{
                                           echo $this->lang->line('no');
                                    }
                                ?>
                             </td>
                        </tr>
                    </table>
                    <div class="col-lg-12">
                        <center>
                            <a id='vp' href='<?php echo base_url();?>index.php/officemutation/viewPetition?case_no=<?php echo $case_no;?>' href='#' class="btn btn-danger mb-2">View Peition</a> 
                        </center>
                    </div>
                    <?php foreach ($dag as $key => $dag) 
                        { 
                    ?>
                            <table class='table table-striped table-bordered tablesorter' id='cases' style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class='alert-new'>Dag No: <?= $dag->dag_no; ?></th>
                                    
                                        <th class='alert-new center'><?php echo $this->lang->line('bigha')?></th>
                                        <th class='alert-new center'><?php echo $this->lang->line('katha')?></th>
                                        <th class='alert-new center'><?php echo $this->lang->line('lesa')?></th>
                                        <th class='alert-new center'>Ganda</th>
                                        <th class='alert-new center'>Krantik</th>
                                        
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr>
                                        <td><?php echo $this->lang->line('dag_area_for_mutation')?></td>
                                        <td>
                                            <?php echo $dag->m_dag_area_b;?>
                                        </td>
                                        <td>
                                            <?php echo $dag->m_dag_area_k;?>
                                        </td>    
                                        <td>
                                            <?php echo $dag->m_dag_area_lc;?>
                                        </td>
                                        <td>
                                            <?php echo $dag->m_dag_area_g;?>
                                        </td>    
                                        <td>
                                            <?php echo $dag->m_dag_area_kr;?> 
                                        </td>
                                    </tr>
                                    <tr>         
                                        <td><?php echo $this->lang->line('total_dag_area')?></td>
                                        <td><?php echo $dag->dag_area_b;?></td>
                                        <td><?php echo $dag->dag_area_k;?></td>
                                        <td><?php echo $dag->dag_area_lc;?></td>
                                        <td><?php echo $dag->dag_area_g;?></td>
                                        <td><?php echo $dag->dag_area_kr;?> </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                            <div class="col-lg-12">
                                <center>
                                    <a target="__blank" href='<?php echo base_url();?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no;?>&dag_no=<?= $dag->dag_no; ?>' class="btn btn-danger mb-2">View Chitha</a>
                                </center>
                            </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            Modal
        </div>
    </div>
</div>