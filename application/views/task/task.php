<div class='contanier'>
<div class='row'>
	<div class='col-lg-12' style="margin-bottom:20px">
		
		<?php foreach($table as $t=>$v): ?>
				<div class='col-lg-3' style="height:150px; overflow-y: scroll; margin-bottom:10px" >
					<p class='uni_text green'><?=$t?><p>
					<?php echo var_dump($v);?>
				</div>
				
		<?php endforeach; ?>
		
		
	</div>
</div>
</div>