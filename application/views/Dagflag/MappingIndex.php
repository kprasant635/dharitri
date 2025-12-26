<div class="row" style='margin-top:40px'>

				
                   <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Dag Mapping</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Pending Approval </td>
                                    
                                    <?php
                                    $link = base_url() . "index.php/Dagflag/locationDetailsCO";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Approve Village List </td>
                                    
                                  
                                    <?php
                                    $link = base_url() . "index.php/Dagflag/approvedListMapping";
                                    ?>
                                    <td><a class="pull-right green"  href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
</div>

<script>
    $(function () {
        $('.msg').click(function (e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function (e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>