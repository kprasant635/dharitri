<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Details Of Patta No <kbd><?=$this->session->userdata('patta_no')?></kbd></h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger" href="<?php echo base_url();?>index.php/jamaeditentry/displaybasic/<?php echo $this->session->userdata('patta_no');?>/<?php echo $this->session->userdata('patta_type_code');?>">Jamabandi Home</a>
                    <hr>
                    <table class="table table-striped table-bordered table-dark">
                        <tr class='center'>
                            <td>Dag No</td>
                            <td>NLRG No</td>
                            <td>Land Class Code</td>
                            <td colspan="3">Area</td>
                            <td>Revenue</td>
                            <td>Local Tax</td>
                            <td>Action</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td >Bigha</td>
                            <td >Katha</td>
                            <td >Lessa</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php foreach ($dags as $key => $value): ?>

                            <tr class='center'>
                                <td class='active'><?php echo $value->dag_no; ?><br>
								<small class='red'>Not Changeable</small>
								</td>
                                <td><?php echo $value->dag_nlrg_no; ?></td>
                                <td>
                                    <?php echo $this->utilityclass->getLandClassCode($value->dag_class_code); ?>
                                </td>
                                <td><?php echo $value->dag_area_b; ?></td>
                                <td><?php echo $value->dag_area_k; ?></td>
                                <td><?php echo $value->dag_area_lc; ?></td>
                                <td><?php echo $value->dag_revenue; ?></td>
                                <td><?php echo $value->dag_localtax; ?></td>
                                <td>
									<?php if(($this->session->userdata('editid'))) 
									{
										$class='hide';
									}
									?>
                                    <a class='btn btn-small btn-danger <?=$class?>' href="<?php echo base_url();?>index.php/JamaEditEntry/dagEdit/<?php echo $value->dag_no;?>">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>