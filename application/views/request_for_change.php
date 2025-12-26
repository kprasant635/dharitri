<style type="text/css">
	table {
    table-layout: fixed;
    width: 100%;
}
table th, table td {
    word-wrap: break-word; /* Allows text wrapping */
    white-space: normal;   /* Enables wrapping for all spaces */
}
</style>
<table class="table">
	<thead class="bg bg-info">
	<tr>
		<td>Sl No.</td>
		<td>Case No</td>
		<td>Attachement</td>
		<td>Location</td>
		<td>Action</td>
	</tr>
	</thead>
	<?php $i=1; foreach($datas as $row):?>
		<tr>
			<td><?=$i++?></td>
			<td><?=$row['case_no']?></td>
			<td><a href="<?=$row[attachment]?>" class='btn btn-primary btn-sm' download>Attachement</a></td>
			<td><?=$row['remark']?></td>
			<td><a href="<?php echo base_url()?>index.php/home/request_change_update/<?=$row['request_id']?>" class='btn btn-success btn-sm'>Update Records</a></td>
		</tr>
	<?php endforeach; ?>
</table>