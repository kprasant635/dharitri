<hr>

<?php
if($error){
?>
    <div class="row justify-content-center">

        <div class="alert alert-warning col-10" role="alert">
            <?php echo $error;?>
        </div>
    </div>
<?php
}else{
?>
    <div class="row justify-content-center">
       <div class="col-md-12">
           <button type="button" onclick="deleteDag('<?=$dist_code?>','<?=$subdiv_code?>','<?=$cir_code?>','<?=$mouza_pargona_code?>','<?=$lot_no?>','<?=$vill_townprt_code?>','<?=$dag_no?>','<?=$master_id?>')" class="btn btn-sm btn-danger mb-2">Delete</button>
        <div class="row">

            <?php
            foreach($landclass_result as $lndcls_row){
            ?>
                <div class="col-6 border-top">
                    <?=$this->utilityclass->getLandClassCode($lndcls_row->landclass_code)?>
                </div>
            <?php
            }
            ?>
        </div>
       </div>
      
    </div>
<?php }?>
<hr>