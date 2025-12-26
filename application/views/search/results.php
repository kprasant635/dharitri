<div class="container-fluid login">
    <div class='row col-lg-10  col-lg-offset-1' >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Case Status Search Result</h3>
            </div>
            <div class="panel-body">
                <div class='col-lg-12 col-lg-offset-0'>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Case No</th>
                            <th>Date Registered</th>
                            <th>Petitioner Name</th>
                            <th>Current Status</th>
                            <th>Remarks(Any)</th>
                        </tr>
                        <?php
                        if(($fieldoffice =='1') || ($fieldoffice=='2')):?>
                            <?php 
                        if(count($results)>0)
                        {
								//	var_dump($results);
                            foreach ($results as $r): ?>
                                <tr>
                                    <td><?php echo $r['case_no']; ?></td>
                                    <td><?php echo date('d-M-Y',strtotime($r['date_registered'])); ?></td>
                                    <td width="40%">
                                        <?php
                                        foreach($r['patta_name'] as $pet_name){
                                            echo $pet_name->pet_name.", ";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $r['current_status'];?></td>
                                    <td><?php echo $r['remarks'];?></td>
                                </tr>
                                <?php 
                            endforeach;
                        }
                        else {echo "<tr><td colspan='5' class='center'>No Records Found</td></tr>";}
                        ?>
                    <?php endif;?>
                    <?php
                   // echo $fieldoffice;
                    if(($fieldoffice =='8') or ($fieldoffice =='6')):?>
                       <?php 
                   if(count($results)>0)
                   {
								//var_dump($results);
                    ?>
                    <tr>
                        <td><?php echo $results['case_no']; ?></td>
                        <td><?php echo date('d-M-Y',strtotime($results['date_registered'])); ?></td>
                        <td width="40%"><?php echo $results['patta_name'];  ?></td>
                        <td><?php echo $results['current_status'];?></td>
                        <td><?php echo $results['remarks'];?></td>
                    </tr>
                    <?php 
                }
                else {echo "<tr><td colspan='5' class='center'>No Records Found</td></tr>";}
                ?>
                <?php endif;?>
                    <?php
                    
                if(($fieldoffice =='3') or ($fieldoffice =='4')):?>
                    
                       <?php 
                       if(count($results)>0)
                       {
                        foreach ($results as $r): ?>
                            <tr>
                                <td><?php echo $r['case_no']; ?></td>
                                <td><?php echo date('d-M-Y',strtotime($r['date_registered'])); ?></td>
                                <td width="40%">
                                    <?php
                                    foreach($r['patta_name'] as $pet_name){
                                        echo $pet_name->pet_name.", ";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $r['current_status'];?></td>
                                <td><?php echo $r['remarks'];?></td>
                            </tr>
                            <?php 
                        endforeach;
                    }
                    else {echo "<tr><td colspan='5' class='center'>No Records Found</td></tr>";}
                    ?>
                <?php endif;?>
                <?php
                        if(($fieldoffice =='10')):?>
                            <?php 
                        if(count($results)>0)
                        {
                                 //var_dump($results);
                            foreach ($results as $r): ?>
                                <tr>
                                    <td><?php echo $r['case_no']; ?></td>
                                    <td><?php echo date('d-M-Y',strtotime($r['date_registered'])); ?></td>
                                    <td width="40%">
                                        <?php echo $r['patta_name']->pet_name; ?>
                                    </td>
                                    <td><?php echo $r['current_status'];?></td>
                                    <td><?php echo $r['remarks'];?></td>
                                </tr>
                                <?php 
                            endforeach;
                        }
                        else {echo "<tr><td colspan='5' class='center'>No Records Found</td></tr>";}
                        ?>
                    <?php endif;?>
                    <?php
                    
                if($fieldoffice =='9'):?>
                    
                       <?php 
                       if(count($results)>0)
                       {
                        foreach ($results as $r): ?>
                            <tr>
                                <td><?php echo $r['case_no']; ?></td>
                                <td><?php echo date('d-M-Y',strtotime($r['date_registered'])); ?></td>
                                <td width="40%">
                                    <?php
                                    foreach($r['patta_name'] as $pet_name){
                                        echo $pet_name->pet_name.", ";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $r['current_status'];?></td>
                                <td><?php echo $r['remarks'];?></td>
                            </tr>
                            <?php 
                        endforeach;
                    }
                    else {echo "<tr><td colspan='5' class='center'>No Records Found</td></tr>";}
                    ?>
                <?php endif;?>


        </table>
    </div>

</div>
</div>
</div>
</div>       