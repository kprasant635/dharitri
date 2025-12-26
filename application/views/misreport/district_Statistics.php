<div class="row login" style="min-height: 500px;">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('district_Statistics');?></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                            <table id="anchor" width="50%" style="text-align: center; border: 1px dashed #0F5CA9">
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_district');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['total_dist']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_subdivision');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['total_subdivs']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_circle');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totalcir']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_mouza');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totalmouza']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_lot_no');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totallot']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_vill_town');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totalvillage']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_dag_entry');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['total_dags_entry']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('total_remarks_entry');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['total_dags_remark']; ?></td></tr>
                            </table>
                            <br>
                            [ <a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('back_to_mis_report_menu');?></a> ]
                        </center>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
