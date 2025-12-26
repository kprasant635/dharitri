<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            PGR/VGR reservation inquiry list from CO	
        </h4>
    </div>
</div>
<div class="col-lg-12 ">
    <table id="dTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Case No</th>
                <th>Query date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php
            foreach($res as $r)
            {
                ?>
                    <tr>
                        <td><?=$r->case_no?></td>
                        <td><?=$r->date_entry?></td>
                        <td>
                            <a href="<?php echo base_url() . "index.php/SettlementVgr/vgrAssignedReservation?case=" . $r->case_no; ?>">
                                <button type="button" class="btn btn-primary btn-sm">write report</button>
                            </a>
                        </td>
                    </tr>
                <?php
            }
        ?>
            </tbody>
        </table>
</div>

<script>
	$(document).ready( function () {
        $('#dTable').DataTable();
    });
</script>