<div class="col-md-12 text-right text-cyan">
    Process > Settlement MB3 > <b>Reclass Suite</b>
</div>
<div class="row justify-content-center" style='margin-top:40px'>

    <div class="col-lg-8">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                        <?php
                            if($_GET['service'] == RECLASS_ID){
                                echo RECLASS_SERVICE_NAME;
                            }
                        ?>
                    </p>
                </div>
            </div>
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
                        <td><a href="<?=base_url().'index.php/ReclassSuiteControllerLm/revertedCases?service='.RECLASS_ID ?>" style="float:right">view</a></td>
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