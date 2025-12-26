<style>
.users {
  width: 100%;
  white-space: nowrap;
}
.users td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Column widths are based on these cells */
.row-ID {
  width: 5%;
}
.row-name {
  width: 5%;
}
.row-job {
  width: 45%;
}
.row-email {
  width: 45%;
}
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 table-responsive ">
				<table class="users table-bordered">
				  <thead>
					<tr>
					  <th class="row-1 row-ID">Sl no</th>
					  <th class="row-2 row-name">Patta No</th>
					  <th class="row-3 row-job">Chitha (Dags)</th>
					  <th class="row-4 row-email">Jamabandi(Dags)<th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					$i=1; 
					foreach($dagpatta as $k=>$val){ ?>
					<tr>
						<td><?=$i?></td>
						<td><?=$k?></td>
						<td><?=$val['chithaDag']?></td>
						<td><?=$val['jamaDag']?></td>
					</tr>
					<?php
					$i++;
					}
					?>
					</tbody>
					</table>
		</div>
	</div>
</div>
