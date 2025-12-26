<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">
            <?php //var_dump($sro_note);?>
            <div class='center'>
			<h3 class='text-primary text-center'>Circle Wise Sale Deed for which Mutation Done Report </h3>
                <table class='table table-bordered'>
                    <tr  >
                        <td class="alert alert-success">District</td>
                        <td class="alert alert-success">Total No. for Mutation Registered</td>
                        <td class="alert alert-success">Total Deed process by CO for Reg.</td>
                        <td class="alert alert-success">Delivered in One Month</td>
                        <td class="alert alert-success">Delivered in Two Month</td>
                    </tr>
                    <?php
                    $i = 0;
                     $tot_sro_note=0;
                    $tot_sro_note_co=0;
                    foreach ($circle as $key=>$val) {
                        ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $val['sro_note']->c;
                             $tot_sro_note= $tot_sro_note+$val['sro_note']->c;
                            ?></td>
                            <td><?php echo $val['sro_note_co']->co;
                            $tot_sro_note_co=$tot_sro_note_co+$val['sro_note_co']->co;
                            ?></td>
                            <td>Delivered in One Month</td>
                            <td>Delivered in Two Month</td>
                        </tr>
                        <?php $i++;
                    } ?>
                        <tr  >
                    <td class="alert alert-info">Total</td>
                    <td class="alert alert-info"><?php echo $tot_sro_note ?></td>
                    <td class="alert alert-info"><?php echo $tot_sro_note_co ?></td>
                    <td class="alert alert-info">Delivered in One Month</td>
                    <td class="alert alert-info">Delivered in Two Month</td>
                </tr>
                </table>  
            </div>

            <br>
        </div>
    </div>

</div>
