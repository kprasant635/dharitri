<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
            <div class="alert alert-dismissible alert-warning"><h2 class="uni_text">
                Case Diary for a particular period
                <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></h2> </div>
            <?php //echo var_dump($officepart); ?>
            <table width="100%" class="table table-bordered table-hover" border="1">
                <tr>
                    <td class="alert-teal" style="background:#6B8E23; color: #fff; text-align: center" rowspan="3"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td class="alert-teal" style="background:#6B8E23; color: #fff; text-align: center" rowspan="3"><div align="center"><?php echo $this->lang->line('mutation_type');?></div></td>
                    <td class="alert-teal" style="background:#6B8E23; color: #fff; text-align: center" colspan="8"><div align="center">Case Diary For a Particular Period</div></td>
                </tr>
                <tr>

                    <td style="background:#6B8E23; color: #fff; text-align: center" colspan="4"><p align="center"><?php echo $this->lang->line('during_this_period');?></p>
                        <p align="center"><span class="badge badge-danger"><?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?></span>  <?php echo $this->lang->line('to');?> <span class="badge badge-danger"><?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></span></p></td>
                </tr>
                <tr>
                  
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?> </td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                </tr>
                <tr class="active">
                    <td><div align="center">1</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_mutation');?></div></td>
                  
                    <td><div align="center"><?php echo $fieldmut['regomut']  ; ?></div></td>
                      <td><div align="center"><?php echo $fieldmut['deliverfmut']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldmut['disomut']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldmut['penomut']  ; ?></span></div></td>
                </tr>
                <tr>
                    <td><div align="center">2</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_partition');?></div></td>
                    
                    <td><div align="center"><?php echo $fieldpart['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart['deliverfpart']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart['disopart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldpart['penopart']  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">3</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_mutation');?></div></td>
                    <td><div align="center"><?php echo $officemut['regomut']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut['delivermut']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut['disomut']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officemut['penomut']  ; ?></span></div></td>
                </tr>
                <tr>
                    <td><div align="center">4</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_partition');?></div></td>
                    
                    <td><div align="center"><?php echo $officepart['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart['deliverpart']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart['disopart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officepart['penopart']  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">5</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_conversion');?></div></td>
                    
                    <td><div align="center"><?php echo $officecon['regocon']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon['delivercon']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon['disocon']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officecon['penocon']  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">6</div></td>
                    <td><div align="center">AC to PP</div></td>
                    
                    <td><div align="center"><?php echo $actopp_tot->c  ; ?></div></td>
                    <td><div align="center"><?php echo $actopp_dev->c  ; ?></div></td>
                    <td><div align="center"><?php echo $actopp_dispose->c ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $actopp_pen->c  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">7</div></td>
                    <td><div align="center">AP NR </div></td>
                    
                    <td><div align="center"><?php echo $nr_tot->c  ; ?></div></td>
                    <td><div align="center"><?php echo $nr_dev->c  ; ?></div></td>
                    <td><div align="center"><?php echo $nr_dispose->c ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $nr_pen->c  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">8</div></td>
                    <td><div align="center">Reclass </div></td>
                    
                    <td><div align="center"><?php echo $t_reclass_tot->c  ; ?></div></td>
                    <td><div align="center"><?php echo $t_reclass_dev->c  ; ?></div></td>
                    <td><div align="center"><?php echo $t_reclass_dispose->c ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $t_reclass_pen->c  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">9</div></td>
                    <td><div align="center">Settlement(MB2) </div></td>
                    
                    <td><div align="center"><?php echo $settlement->total  ; ?></div></td>
                    <td><div align="center"><?php echo $settlement->passed  ; ?></div></td>
                    <td><div align="center"><?php echo $settlement->rejected ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $settlement->pending  ; ?></span></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">10</div></td>
                    <td><div align="center">Composite Service </div></td>
                    
                    <td><div align="center"><?php echo $composite->total  ; ?></div></td>
                    <td><div align="center"><?php echo $composite->delivered  ; ?></div></td>
                    <td><div align="center"><?php echo $composite->disposed ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $composite->pending  ; ?></span></div></td>
                </tr>

            </table>
            <center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
       window.history.back();
    };
</script>
