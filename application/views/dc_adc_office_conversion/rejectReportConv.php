<div class="alert alert-info">
	<blockquote>Basundhara : <kbd><?=$case['basundhara']?></kbd> Dharitree : <kbd><?=$case['dharitree']?></kbd></blockquote>
<table class="table table-bordered table-striped" width="100%" border="1">
	<?php foreach($result as $r) { ?>
		<tr>
			<td><u><?=$r['date_of_hearing']?></u><br> <?=$r['co_order']?></td>
			<td><u><?=$r['date_of_hearing']?></u><br> <?=$r['note_on_order']?> </td>
		</tr>
	<?php } ?>
</table>
</div>