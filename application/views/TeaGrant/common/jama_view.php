<?php foreach ($dags as $ddg) { ?>

  <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
    <input type="hidden" name="dist_code" value="<?=$ddg->dist_code;?>">
    <input type="hidden" name="subdiv_code"  value="<?=$ddg->subdiv_code;?>">
    <input type="hidden" name="circle_code" value="<?=$ddg->cir_code;?>">
    <input type="hidden" name="mouza_code" value="<?=$ddg->mouza_pargona_code;?>">
    <input type="hidden" name="lot_no" value="<?=$ddg->lot_no;?>">
    <input type="hidden" name="vill_code" value="<?=$ddg->vill_townprt_code;?>">
    <input type="hidden" name="patta_type" value="<?=$ddg->patta_type_code?>">
    <input type="hidden" name="patta_no" value="<?=$ddg->patta_no?>">
  </form>

  <div style="cursor:pointer; text-decoration: underline; text-align: right; " id="seeJamaClick">
    <i class="fa fa-link" aria-hidden="true"></i>
    <span class="text-danger" style="font-size:16px;color:#ffb81d">Patta No. <?=$ddg->patta_no?> (Jamabandi View)</span>
  </div>

<?php } ?>

<script type="text/javascript">
   $("#seeJamaClick").click(function(event){
    $('#seeJama').submit();
  });
</script>

