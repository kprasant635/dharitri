<table border="1" width="100%">
    <tr>
		<th>Dag No Int</th>
		<th>Dist Code</th>
		<th>Subdiv Code</th>
		<th>Cir Code</th>
		<th>Mouza Pargona Code</th>
		<th>Lot No</th>
		<th>Vill Townprt Code</th>
		<th>Old Dag No</th>
		<th>Dag No</th>
		<th>Patta Type Code</th>
		<th>Patta No</th>
		<th>Land Class Code</th>
		<th>Dag Area B</th>
		<th>Dag Area K</th>
		<th>Dag Area Lc</th>
		<th>Dag Area G</th>
		<th>Dag Area Kr</th>
		<th>Dag Area Are</th>
		<th>Dag Revenue</th>
		<th>Dag Local Tax</th>
		<th>Dag No Map</th>
		<th>Dag N Desc</th>
		<th>Dag S Desc</th>
		<th>Dag E Desc</th>
		<th>Dag W Desc</th>
		<th>Dag N Dag No</th>
		<th>Dag S Dag No</th>
		<th>Dag E Dag No</th>
		<th>Dag W Dag No</th>
		<th>Dag Nlrg No</th>
		<th>Dp Flag Yn</th>
		<th>User Code</th>
		<th>Date Entry</th>
		<th>Operation</th>
		<th>Jama Yn</th>
		<th>Status</th>
		<th>Old Patta No</th>
		<th>Dag Name</th>
		<th>Dag Dept Name</th>
		<th>Actions</th>
    </tr>
	<?php foreach($chitha_basic as $c){ ?>
    <tr>
		<td><?php echo $c['dag_no_int']; ?></td>
		<td><?php echo $c['dist_code']; ?></td>
		<td><?php echo $c['subdiv_code']; ?></td>
		<td><?php echo $c['cir_code']; ?></td>
		<td><?php echo $c['mouza_pargona_code']; ?></td>
		<td><?php echo $c['lot_no']; ?></td>
		<td><?php echo $c['vill_townprt_code']; ?></td>
		<td><?php echo $c['old_dag_no']; ?></td>
		<td><?php echo $c['dag_no']; ?></td>
		<td><?php echo $c['patta_type_code']; ?></td>
		<td><?php echo $c['patta_no']; ?></td>
		<td><?php echo $c['land_class_code']; ?></td>
		<td><?php echo $c['dag_area_b']; ?></td>
		<td><?php echo $c['dag_area_k']; ?></td>
		<td><?php echo $c['dag_area_lc']; ?></td>
		<td><?php echo $c['dag_area_g']; ?></td>
		<td><?php echo $c['dag_area_kr']; ?></td>
		<td><?php echo $c['dag_area_are']; ?></td>
		<td><?php echo $c['dag_revenue']; ?></td>
		<td><?php echo $c['dag_local_tax']; ?></td>
		<td><?php echo $c['dag_no_map']; ?></td>
		<td><?php echo $c['dag_n_desc']; ?></td>
		<td><?php echo $c['dag_s_desc']; ?></td>
		<td><?php echo $c['dag_e_desc']; ?></td>
		<td><?php echo $c['dag_w_desc']; ?></td>
		<td><?php echo $c['dag_n_dag_no']; ?></td>
		<td><?php echo $c['dag_s_dag_no']; ?></td>
		<td><?php echo $c['dag_e_dag_no']; ?></td>
		<td><?php echo $c['dag_w_dag_no']; ?></td>
		<td><?php echo $c['dag_nlrg_no']; ?></td>
		<td><?php echo $c['dp_flag_yn']; ?></td>
		<td><?php echo $c['user_code']; ?></td>
		<td><?php echo $c['date_entry']; ?></td>
		<td><?php echo $c['operation']; ?></td>
		<td><?php echo $c['jama_yn']; ?></td>
		<td><?php echo $c['status']; ?></td>
		<td><?php echo $c['old_patta_no']; ?></td>
		<td><?php echo $c['dag_name']; ?></td>
		<td><?php echo $c['dag_dept_name']; ?></td>
		<td>
            <a href="<?php echo site_url('chitha_basic/edit/'.$c['dag_no_int']); ?>">Edit</a> | 
            <a href="<?php echo site_url('chitha_basic/remove/'.$c['dag_no_int']); ?>">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>
