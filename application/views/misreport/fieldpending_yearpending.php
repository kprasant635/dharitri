<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
            <?php //var_dump($this->session->all_userdata()); ?>
            <div class="alert alert-warning"><h2 class="uni_text"><?php echo $this->lang->line('yearwise_pendency_list_for_the_year');?> <?php echo $this->session->userdata('year_no') ?></h2></div>
                <span class="label label-primary uni_text"><?php echo $this->lang->line('district');?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ; ?></span>
            <span class="label label-success uni_text"><?php echo $this->lang->line('subdivision');?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ; ?></span>
             <span class="label label-warning uni_text"><?php echo $this->lang->line('circle');?> :  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ; ?></span>
            <span class="label label-info uni_text"> <?php echo $this->lang->line('year');?> :  <?php echo $this->session->userdata('year_no'); ?></span>
            <p><br></p>
                <table width="100%" class="table table-bordered" border="1">
                    <tr>
                      <td class="alert-success"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                      <td  class="alert-success"><div align="center"><?php echo $this->lang->line('case_no');?></div></td>
                      <td  class="alert-success"><div align="center"><?php echo $this->lang->line('petitioner_name');?></div></td>
                      <td  class="alert-success"><div align="center"><?php echo $this->lang->line('guardian_name');?></div></td>
                      <td  class="alert-success"><div align="center"><?php echo $this->lang->line('submission_date');?></div></td>
                      <td  class="alert-success"><div align="center"><?php echo $this->lang->line('petition_no');?></div></td>
                      <td  class="alert-success"><div align="center"><?php echo $this->lang->line('status');?></div></td>
                    </tr>
                    <tr>
                      <td class="alert-paleturquoise"><div align="center">1</div></td>
                      <td class="alert-paleturquoise"><div align="center">2</div></td>
                      <td class="alert-paleturquoise"><div align="center">3</div></td>
                      <td class="alert-paleturquoise"><div align="center">4</div></td>
                      <td class="alert-paleturquoise"><div align="center">5</div></td>
                      <td class="alert-paleturquoise"><div align="center">6</div></td>
                      <td class="alert-paleturquoise"><div align="center">7</div></td>
                    </tr>
                    <?php 
                    $i=1;
                    $j=0;
                    foreach($pb as $d)
                    {
                    ?>
                    <tr>
                      <td><div align="center"><?php echo $i; ?></div></td>
                      <td><div align="center"><?php echo $d->case_no; ?></div></td>
                      <td><div align="center">
                          <?php
                          foreach( $petipart[$j] as $p)
                            {
                                echo $p->n."<br>";
                            }
                          ?>
                          </div></td>
                          <td><div align="center">
                              <?php
                              foreach( $petipart[$j] as $p)
                                {
                                    echo $p->g."<br>";
                                }
                              ?>
                              </div></td>
                      <td><div align="center"><?php echo date('d/m/Y',  strtotime($d->report_date)) ; ?></div></td>
                      <td><div align="center"><?php echo $d->petition_no; ?></div></td>
                      <td><div align="left">
                              <?php 
                                    if ($d->sk_note == null) {
                                             echo "<p class='text-info'>**    SK Note Pending</p>";
                                         }
                                     if($d->is_dispose==null and $d->order_passed==null)
                                        {
                                           $desc=$this->utilityclass->GetCaseStatus('02'); 
                                           echo "<p class='text-warning'>$desc</p>";
                                        }
                             ?>
                         </div></td>
                    </tr>
                    <?php
                    $i++;$j++;
                    }
                    ?>
                  </table>
             <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back');?></button></center>
        </div>
</div>
</div>
<script type="text/javascript">
    function goBack() {
    window.history.back();
}
</script>