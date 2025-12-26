<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-6  panel panel-default panel-body ">
				<h4><u>Please Select the Name of Pattadar</u></h4>
				<span class='small uni_text red float-right'>Please select check the checkbox </span>
				<form method='post' class='form-inline' >
					<div style='height:250px; overflow-y:scroll; '>
					<?php
					if($this->session->flashdata('message'))
					echo "<p class='red uni_text'> ". $this->session->flashdata('message') ." </p> ";
					//var_dump($part);
					foreach($part as $p): ?>
						<p class='uni_text'>
						<input type='text' name='pdar_name[<?=$p->pdar_id?>]' value='<?=$p->pdar_name;?>' />
						<input type='text' name='pdar_father[<?=$p->pdar_id?>]' value='<?=$p->pdar_father;?>' />
						<input type='hide' class='hide' name='pdar_guard_reln[<?=$p->pdar_id?>]' value='<?=$p->pdar_guard_reln;?>' />
						<input type='checkbox' class='squaredTwo' name='pdar_id[<?=$p->pdar_id?>]' value='<?=$p->pdar_id?>'  /> </p>
					<?php endforeach; ?>
					</div>
					<hr>
					
					<center><button type='submit' class='btn btn-primary' value='Submit' >Submit</button></center>
				</form>
				
			</div>
			<div class='col-lg-1'></div>
			<div class="col-lg-5 panel panel-default panel-body ">
			<h4><u>Already Exist(s) Pattadar(s) Name on the Patta <kbd><?=$this->session->userdata['basic']['new_patta_no']?></kbd></u></h4>	
				<div style='height:342px; overflow-y:scroll; '>
				<?php
				if($oldpart==null){
				 echo	$msg="<i class='uni_text red'> This is a fresh patta. Pattadar isn't available in this patta </i>";
				}
				foreach($oldpart as $p): ?>
						<p class='uni_text'><?=$p->pdar_name;?> G:<?=$p->pdar_father?> </p>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>