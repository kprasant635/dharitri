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
    <div class="row">
        <?php
        foreach($dag_list as $dagl_row){
        ?>
        <div class="col-md-2 text-center">
            <a href="javascript:void(0);" onclick="viewLandclassInDag('<?=$dagl_row->dist_code?>', '<?=$dagl_row->subdiv_code?>', '<?=$dagl_row->cir_code?>', '<?=$dagl_row->mouza_pargona_code?>', '<?=$dagl_row->lot_no?>', '<?=$dagl_row->vill_townprt_code?>', '<?=$dagl_row->dag_no?>')">
                <?=$dagl_row->dag_no?>
            </a>
            <div id="dag_view_div_<?=$dagl_row->dag_no?>"></div>
            
        </div>
        <?php
        }
        ?>
      
    </div>




<?php }?>