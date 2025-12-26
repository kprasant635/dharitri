<style>
    tr,td,th{
        font-size: 1em;
        font-weight: normal;
        text-align: center;
        vertical-align: middle;
        word-break: break-all;
		font-familt:serif;
    }
</style>
<div class='contanier-fluid'>
<div class="row form-top">
    <div class="col-lg-12">
        <div class="row">
            
            <div class="col-lg-12" style="text-align: center;">
                <div style="text-align: center;font-size: 1.2em;font-weight: bold;">
                   <span class='uni_text' style='font-size:2em; font-family:serif;font-weight: bold;'> Form No. 19</span> <br>
					ফৰ্ম নং ১৯ <br>
					[See Rule 31(I)]<br>
					[৩১ (১)  নং নিয়ম চাওক ]
                </div>
            </div>
        </div>

        <?php foreach ($all as $k=>$v):?>
            <div class="col-lg-3">
                <p class='red uni_text'>Khatian No: <?php echo $k;?>
            </div>
            <table class='table table_black'>
                <thead>
				<tr>
                    <td rowspan="4" style="text-align: center;width:10% !important">Name/Fathers Name and Residence of Tenant</td>
                    <td colspan="10" style="text-align: center;">Land in Possession of Tenants</td>
                    <td colspan="5" style="text-align: center;">Particulars of Pattadars</td>
                <tr>
                <tr>

                    <td rowspan="2">Old Dag</td>
                    <td rowspan="2">New Dag</td>
                    <td rowspan="2">Area</td>
                    <td rowspan="2">Class of Land</td>
                    <td rowspan="2">Revenue Payable</td>
                    <td rowspan="2">Length of Possession</td>
                    <td colspan="2">Rent</td>
                    <td rowspan="2">Status of Tenants</td>
                    <td rowspan="2">Special Conditions</td>
                    <td rowspan="2">Name/Fathers Name</td>
                    <td rowspan="2">Patta No and Nature</td>
                    <td rowspan="2">Remarks</td>
                    <td rowspan="2">Khatian Update Remarks(CO)</td>

                </tr>
                <tr>
                    <td>cash/kind</td>
                    <td>cash/kind</td>
                </tr>
				</thead>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>
                        <?php
						$samekhatian=$k;
						foreach($v as $key=>$value):
							if($samekhatian==$k):
							?>
                            <?php foreach($value['tenants'] as $t):
							//var_dump($t);
							?>
                            <?php
							if($t->status!=0)
							{
							echo "<s class='red'>".$t->tenant_name."<br> (".$t->tenants_father.")</br>";
							echo $t->tenants_add1."-".$t->tenants_add2."</s>";
							}else
							{
							echo "<p>".$t->tenant_name."<br> (".$t->tenants_father.")</br>";
							echo $t->tenants_add1."-".$t->tenants_add2."</p>";
							}
							?>
							
                            <?php
							endforeach;
							$samekhatian=0;
							endif;
							?>
                        <?php endforeach;?>
                    </td>
                     <td>
                         <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['cb'] as $c):?>
                            <?php echo "<p>".$c->old_dag_no."</p>";?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </td>
                    <td>
                         <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['cb'] as $c):?>
                            <?php echo "<p>".$c->dag_no."</p>";echo "-------";?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </td>
                    <td>
                         <?php foreach($v as $key=>$value):?>
                        <?php foreach($value['cb'] as $c):?>
                            <?php echo "<p>".$c->dag_area_b." B- ".$c->dag_area_k." K- ".$c->dag_area_lc." LC</p>"; echo "-------";?>
                            <?php  break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </td>
                    <td>
                         <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['cb'] as $c):?>
                            <?php echo "<p>".$this->utilityclass->getLandClassCode($c->land_class_code)."</p>";echo "-------";?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </td>
                    <td>
                     <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['cb'] as $t):?>
                            <?php echo "<p>".$t->dag_revenue."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                         <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->length_posession."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                        <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->paid_cash_kind."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                        <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->payable_cash_kind."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                        <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->tenant_status."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                        <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->special_conditions."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                        <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['pattadars'] as $c):?>
                            <?php echo "<p>".$c->pdar_name."<br>(". $c->pdar_father.")</p>";?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </td>
                    <td>
                         <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['cb'] as $c):?>
                            <?php echo "<p>".$c->patta_no."/".$this->utilityclass->getPattaType($c->patta_type_code)."</p>";echo "-------";?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </td>
                    <td>
                    <?php foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->remarks."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                    <td>
                    <?php 
                    foreach($v as $key=>$value):?>
                            <?php foreach($value['khatians'] as $t):?>
                            <?php echo "<p>".$t->co_remarks."</p>";echo "-------";?>
                            <?php break;?>
                            <?php endforeach;?>
                        <?php endforeach;?>   
                    </td>
                </tr>    
            </table>
        <hr>

        <table class="table table-striped table-bordered text-bold">
            <thead>
                <tr>
                    <th style="background-color:rgb(39, 171, 21); color: #fff" colspan="6">Uploaded Khatians</th>
                </tr>
            </thead>
            <tbody>   
                <?php foreach ($v as $k=>$vl):?>
                    <?php foreach ($vl['documents'] as $kk=>$document):?>
                        <?php 
                            $randomPrefix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5); 
                            $randomSuffix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);                                             
                            $fileLink = base_url('index.php/MultipleFileUpload/viewfile/' . $randomPrefix . $document['id'] . $randomSuffix);
                        ?>
                        <tr>
                            <td> <?php echo htmlspecialchars($document['file_name'])?></td>
                            <td colspan="5">
                                <a href="<?php echo $fileLink; ?>" target="_blank">VIEW FILE</a></b>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endforeach; ?>
    </div>
</div>
</div>