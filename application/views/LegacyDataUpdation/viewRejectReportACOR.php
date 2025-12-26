<div class="alert alert-info">
	<table class="table table-bordered table-striped" border="1">
		<tr><td colspan="3"><center style="font-size: 40px">Area Correction Report</center></td></tr>
		<tr style="background-color: #136a6f; color: white; font-size: 20px">
			<td width="20%">User</td>
			<td>Remarks</td>
		</tr>
		<!--CO Comment-->
		<?php if(isset($comments_co)) { foreach($comments_co as $p){?>
		<tr>
			<td style="background-color: #ccc">CO Comment</td>
			<td><?=$p->co_note?></td>
		</tr>
		<?php }} ?>

		<!--LM Comment-->
		<?php if(isset($comments_lm)) { foreach($comments_lm as $p){?>
		<tr>
			<td style="background-color: #28a745">LM Comment</td>
			<td><?=$p->lm_note?></td>
		</tr>
		<?php }} ?>
	</table>
</div>