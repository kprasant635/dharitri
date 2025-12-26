<div class="alert alert-info">
	<blockquote>Basundhara : <kbd><?=$case['basundhara']?></kbd> Dharitree : <kbd><?=$case['dharitree']?></kbd></blockquote>
<table class="table table-bordered table-striped" border="1">
	<tr>
		<td><u>CO Note:</u><br> <?=$result['co_note']?></td>
		<td><u>LM Note:</u><br> <?=$result['lm_note']?></td>
		<td><u>SK Note:</u><br> <?=$result['sk_note']?></td>
	</tr>
	<tr><td colspan="3"><center>Petition Proceeding</center></td></tr>
	<?php foreach($proceeding as $p){ ?>
	<tr>
		<td colspan="2"><?=$p['co_order']?></td>
		<td><?=$p['note_on_order']?></td>
	</tr>
	<?php } ?>
</table>
</div>