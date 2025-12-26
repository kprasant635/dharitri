<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12"> 
		
        <div class='center'>
		<h3 class='text-primary text-center'>District Wise Sale Deed for which Mutation Done Report </h3>
            <table class='table table-bordered'>
                <tr >
                    <td class="alert alert-success">District</td>
                    <td class="alert alert-success">Total No. for Mutation Registered</td>
                    <td class="alert alert-success">Total Deed process by CO for Reg.</td>
                    <td class="alert alert-success">Delivered in One Month</td>
                    <td class="alert alert-success">Delivered in Two Month</td>
                </tr>
                <?php
                 $tot_sro_note=0;
                 $tot_sro_note_co=0;
                foreach($reg as $key=>$v){
                ?>
                <tr>
                    <td><a href="<?php echo base_url(); ?>index.php/Portal/saledeedcircle?d=<?php echo $key; ?>"><?php echo $key; ?></a></td>
                    <td><?php echo $v['sro_note']->c;
                        $tot_sro_note=$tot_sro_note+$v['sro_note']->c;
                    ?></td>
                    <td><?php echo $v['sro_note_co']->co;
                    $tot_sro_note_co=$tot_sro_note_co+$v['sro_note_co']->co;
                    ?></td>
                    <td>Delivered in One Month</td>
                    <td>Delivered in Two Month</td>
                </tr>
                <?php } ?>
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
