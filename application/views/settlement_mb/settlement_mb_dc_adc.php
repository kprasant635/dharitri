<div class="row" style='margin-top:40px'>

    <div class="col-lg-5 col-lg-offset-1">
        <div class="panel casedisplay">

            <div class="panel-body">
                <table class="table table-striped table-hover">

                    <tr class="">
                        <td>Reverted Back from CO</td>
                        <td><?php
                            if ($reverted != '0') {
                                echo "<span class=\"badge badge-danger\">$reverted</span>";
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementMbLm/revertedCases'; ?>" style="float:right">view</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>