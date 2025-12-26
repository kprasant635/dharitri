<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
             <?php
                    $name=$this->session->userdata('mut_type');
                    if($name=='04')
                    {
                        $cnmae="Office Partition";
                    }
                    
            ?>
            <div class="alert alert-dismissible alert-warning text-center"><h2 class="uni_text">Central Diary - <?php echo $cnmae; ?> </h2>
                <p class="text-danger uni_text"><?php echo $this->lang->line('during_this_period');?> <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></p>
            </div>
            <p class="uni_text"> <?php echo $this->lang->line('district');?> : <u class="text-danger"><?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?></u>
                <?php echo $this->lang->line('subdivision');?> : <u class="text-danger"><?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ?></u>
                <?php echo $this->lang->line('circle');?> :<u class="text-danger"><?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?></u></p>
            <table id="example" width="100%" class="table table-bordered" border="1">
                <thead>
                <tr class="active text-danger">
                    <td ><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td >
                        <p align="center"><?php echo $this->lang->line('submission_date');?></p></td>
                    <td ><div align="center"><?php echo $this->lang->line('case_no');?></div></td>
                    <td ><p align="center"><?php echo $this->lang->line('applicant_name');?> <?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('father_name');?></p></td>
                    <td><?php echo $this->lang->line('pattadarname_fathername');?></td>
                    <td ><div align="center"><?php echo $this->lang->line('mouza');?></div></td>
                  
                    <td ><div align="center"><?php echo $this->lang->line('vill_town');?></div></td>
                      <td ><div align="center"><?php echo $this->lang->line('patta_no');?></div></td>
                   <td ><div align="center"><?php echo $this->lang->line('dag_no');?></div></td>
                   <td ><div align="center"><?php echo $this->lang->line('land_area_b_k_l');?></div></td>
                   <td ><div align="center"><?php echo $this->lang->line('first_order_date');?></div></td>
                   <td ><div align="center"><?php echo $this->lang->line('last_order');?></div></td>
                    <td ><div align="center"><?php echo $this->lang->line('time_taken_to_passorder');?></div></td>
                </tr>
                </thead>
                <tbody>
                
                <?php
                $i=0;
                foreach ($fb as $f) {
                    ?>
                <tr>
                        <td><?php echo $i + 1 ?></td>
                        <td><?php echo date('d/m/Y', strtotime($f->date_entry)); ?></td>
                        <td><?php
                            echo $f->case_no . "<br>";
                            echo "<span class='text-danger'>" . date('d/m/Y', strtotime($f->date_entry)) . "</span>";
                            ?></td>
                        <td><?php
                            $j = 1;
                            foreach ($petipart[$i] as $p) {
                                echo "$j) " . $p->n . "<br>";
                                $relation = $this->utilityclass->get_relation($p->r);
                                echo "<span class='text-danger'>(" . $relation . ":-" . $p->g . ")</span><br>";
                                echo "<p></p>";
                                $j++;
                            }
                            ?></td>
                        <td><?php
                            $k=1;
                            foreach ($pattadarname[$landarea[$i]->patta_no] as $pname) {
                                echo "$k) " . $pname['pdar_name'] . "<br>";
                                $relation = $this->utilityclass->get_relation($pname['pdar_guard_reln']);
                                echo "<span class='text-danger'>(" . $relation . ":-" . $pname['pdar_father'] . ")</span><br>";
                                echo "<p></p>";
                                $k++;
                            }
                            ?></td>
                         <td><?php echo $this->utilityclass->getMouzaName($f->dist_code,$f->subdiv_code,$f->cir_code,$f->mouza_pargona_code) ?></td>
                        <td><?php echo $this->utilityclass->getVillageName($f->dist_code,$f->subdiv_code,$f->cir_code,$f->mouza_pargona_code,$f->lot_no,$f->vill_townprt_code) ?></td>
                        <td><?php echo $landarea[$i]->patta_no ?></td>
                        <td><?php echo $landarea[$i]->dag_no ?></td>
                        <td><?php echo $landarea[$i]->m_dag_area_b."-".$landarea[$i]->m_dag_area_k."-".  round($landarea[$i]->m_dag_area_lc, 2);?></td>
                        <td><?php echo date('d/m/Y',  strtotime($f->date_entry
                                )) ?></td>
                        <td><?php if($f->date_of_order==null){
                             echo "";
                         }
                         else{
                        echo date('d/m/Y',  strtotime($f->date_of_order)) ;
                         } ?></td>
                        <td><?php echo $pendingDays[$i] ?></td>
                    </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        <?php
         //   var_dump($pattadarname);
       // var_dump($pendingDays); ?>
         <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back');?></button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    function goBack() {
    window.history.back();
}
</script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
	"bLengthChange": false,
	"showNEntries" : false,
	"bSort" :	false,
	"bInfo" :	false,
	"pageLength": 5
  });
  
});
</script> 
