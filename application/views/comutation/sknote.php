<div class='container-fluid'>
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
            <table class="table table-bordered" style='overflow:auto;'>
                <tr>
                    <td class="center red"><?php echo $this->lang->line('district');?> : <?php echo $location['d']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('subdivision');?> : <?php echo $location['sd']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('circle');?> : <?php echo $location['c']; ?></td>
                </tr>
                <tr>
                    <td class="center red"><?php echo $this->lang->line('mouza');?> : <?php echo $location['m']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('lot_no');?> : <?php echo $location['l']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('vill_town');?> : <?php echo $location['v']; ?></td>
                </tr>
            </table>
            <div class="row">
                <div class="col-lg-12">
                    <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                    <label class="col-sm-4 rasid">&nbsp;</label>
                    <label class="col-sm-4 rasid"><?php echo $this->lang->line('report_date');?> : <?php echo date('d-m-Y',strtotime($location['report_date'])); ?></label>
                </div>
            </div>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('dag_no');?></th>
                        <th><?php echo $this->lang->line('sk_note');?></th>
                    </tr>
                </thead>
                <?php foreach($sknote as $sk):?>
                <tr>
                    <td><?php echo $sk->dag_no; ?></td>
                    <td><?php echo $sk->sk_note; ?></td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>

