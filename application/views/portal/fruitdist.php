<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">
              
        <div class='center'>
		<h3 class='text-primary text-center'>District Wise Details of Fruit Trees Report </h3>
            <table class='table table-bordered'>
                <tr>
                    <td class="alert alert-success">District</td>
                    <td class="alert alert-success">Name of Tree</td>
                    <td class="alert alert-success">No of Tree(s)</td>
                    <td class="alert alert-success hide">Area</td>
                </tr>
                <?php
                $tot_fruit=0;
                     foreach($name as $k=>$v){
                         foreach($dist as $d){
                             if($d[1]==$k){
                                foreach($v as $p=>$q){
                ?>
                <tr>
                    <td style="vertical-align: middle;" >
                        <a href="<?php echo base_url(); ?>index.php/Portal/fruitlistcircle?d=<?php echo $d[0]; ?>&c=<?php echo $d[1] ?>"><?php echo $d[0]; ?></a>
                    </td>
                    <td><?php echo $p; ?></td>
                    <td><?php echo $q->no_of_fruit_plants ;
                     $tot_fruit=$tot_fruit+$q->no_of_fruit_plants;
                    ?></td>
                    <td class="hide">Delivered in Two Month</td>
                </tr>
                             <?php   }}}} ?>
                <tr>
                    <td class="alert alert-info">---</td>
                    <td class="alert alert-info">Total </td>
                    <td class="alert alert-info"><?php echo $tot_fruit;     ?></td>
                </tr>
            </table>  
        </div>
        <br>
    </div>
    </div>
</div>
