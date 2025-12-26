<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">
              
        <div class='center'>
            <table class='table table-bordered'>
                <tr  >
                    <td class="alert-new">District</td>
                    <td class="alert-new">Name of Tree</td>
                    <td class="alert-new">No of Tree(s)</td>
                    <td class="alert-new hide">Area</td>
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
                        <a href="<?php echo base_url(); ?>index.php/MisReport/fruitlistcircle?d=<?php echo $d[0]; ?>&c=<?php echo $d[1] ?>"><?php echo $d[0]; ?></a>
                    </td>
                    <td><?php $name= $this->utilityclass->fruitname($p); 
                    echo $name->fruit_name; ?></td>
                    <td><?php echo $q->no_of_fruit_plants ;
                     $tot_fruit=$tot_fruit+$q->no_of_fruit_plants;
                    ?></td>
                    <td class="hide">Delivered in Two Month</td>
                </tr>
                             <?php   }}}} ?>
                <tr  >
                    <td class="alert-new">---</td>
                    <td class="alert-new">Total </td>
                    <td class="alert-new"><?php echo $tot_fruit;     ?></td>
                </tr>
            </table>  
        </div>
        <br>
    </div>
    </div>
</div>
