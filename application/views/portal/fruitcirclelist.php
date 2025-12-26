<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">
             
        <div class='center'>
		<h3 class='text-primary text-center'>Circle Wise Details of Fruit Trees Report </h3>
            <table class='table table-bordered'>
                <tr>
                    <td class="alert alert-success">Circle</td>
                    <td class="alert alert-success">Name of Tree</td>
                    <td class="alert alert-success">No of Tree(s)</td>
                    <td class="alert alert-success hide">Area</td>
                </tr>
                <?php
                $tot_fruit=0;
                  foreach($loc as $v) {
                  $cir_code = $v->cir_code;
                  foreach ($circle as $p => $q) { 
                  if ($cir_code == $p) {
                     foreach($q as $k=>$r){
                ?>
                <tr>
                    <td style="vertical-align: middle;" ><?php echo $v->loc_name; ?>
                    </td>
                    <td><?php echo $k; ?></td>
                    <td><?php echo $r->no_of_fruit_plants ;
                    $tot_fruit=$tot_fruit+$r->no_of_fruit_plants;
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
