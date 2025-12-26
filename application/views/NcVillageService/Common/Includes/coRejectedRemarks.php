<?php
    if(isset($lmnote->lm_rejected_remarks))
    {
        $rejected_list_json = json_decode($lmnote->lm_rejected_remarks);
        
        if(isset($rejected_list)):
            
            if($rejected_list_json){
            ?>
            <h5 class="bg-warning p-2 text-center text-white">Selected Reason for Rejection</h5>
            <?php
            }

            if($reject_list_type == 'old')
            {
                foreach($rejected_list as $rej_master_tb):
                    if($rej_master_tb->remark_head == null){

                        ?>
                        <label>
                            <input disabled style="width: 16px; height: 16px;" type="checkbox" value="<?=$rej_master_tb->reject_code?>" 
                            
                            <?php 
                                foreach($rejected_list_json as $re_list)
                                {
                                    if($rej_master_tb->reject_code == $re_list){echo "checked";} 
                                }
                            ?>> &nbsp;<?=$rej_master_tb->remark?>
                            <hr>
                        </label>
                        <br>
                        <?php
                    }
                endforeach;
            }
            
            if($reject_list_type == 'new')
            {
                foreach(json_decode(REJECTED_REMARK_HEAD) as $r_head)
                {
                    $count = 0;
                    foreach($rejected_list as $rej_master_tb)
                    {
                        if($rej_master_tb->chitha_flag != 0)
                        {
                            if($rej_master_tb->remark_head != null)
                            {
                                if($r_head->CODE == $rej_master_tb->remark_head):

                                    if($count == 0):
                                        ?> 
                                            <br>
                                            <h6>
                                                <span style="color:blue; cursor:pointer;" onclick="collapse('col<?=$rej_master_tb->remark_head?>');" class="p-1">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                    <b><?=$r_head->NAME?> </b>
                                                    <i class="fa fa-level-down text-red" aria-hidden="true"></i>
                                                </span>
                                            </h6>
                                        
                                        <?php
                                    endif;
                                    ?>

                                <?php
                                if($basic['service_code'] == '14')
                                {
                                    $rejectDag = $dags;
                                }
                                else if($basic['service_code'] == '13')
                                {
                                    $rejectDag = $dagsResult;
                                }
                                else
                                {
                                    $rejectDag = $dags;
                                }

                                foreach($rejectDag as $remark_dag)
                                {
                                    ?>
                                    <div class="col<?=$rej_master_tb->remark_head?>">
                                        <label class="ml-3 mb-2 mt-2">
                                            <input disabled style="width: 16px; height: 16px;" type="checkbox" value="<?=$rej_master_tb->reject_code?>"  
                                            
                                            <?php 
                                                foreach($rejected_list_json as $re_list)
                                                {
                                                    if(isset($rej_master_tb->dag_no))
                                                    {
                                                        if(($rej_master_tb->reject_code == $re_list->reject_code) && ($re_list->dag_no == $remark_dag->dag_no))
                                                        {
                                                            echo "checked";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(($rej_master_tb->reject_code == $re_list->reject_code))
                                                        {
                                                            echo "checked";
                                                        }
                                                    }
                                                }
                                            ?>> &nbsp;<?=$rej_master_tb->remark?> 
                                            <span class="badge">for Dag No: <?=$remark_dag->dag_no?></span>
                                            
                                            <?php
                                                foreach($rejected_list_json as $re_list)
                                                {

                                                    if(isset($rej_master_tb->dag_no))
                                                    {
                                                        if(($rej_master_tb->reject_code == $re_list->reject_code) && ($re_list->dag_no == $remark_dag->dag_no))
                                                        {
                                                            if(trim($re_list->sub_rejected_remark))
                                                            {
                                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input readonly class="form-control mt-2" value="'.$re_list->sub_rejected_remark.'">';
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(($rej_master_tb->reject_code == $re_list->reject_code))
                                                        {
                                                            if(trim($re_list->sub_rejected_remark))
                                                            {
                                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input readonly class="form-control mt-2" value="'.$re_list->sub_rejected_remark.'">';
                                                            }
                                                        }
                                                    }
                                                  
                                                }
                                            ?>
                                        </label>
                                        
                                        <span id="additional_input<?=$rej_master_tb->reject_code?>">
                                        </span>
                                    </div>
                                    <?php }?>

                            <?php
                                $count++;
                                endif;
                            }
                        }
                        else
                        {
                            if($rej_master_tb->remark_head != null)
                            {
                                if($r_head->CODE == $rej_master_tb->remark_head):

                                    if($count == 0):
                                        ?> 
                                            <br>
                                            <h6>
                                                <span style="color:blue; cursor:pointer;" onclick="collapse('col<?=$rej_master_tb->remark_head?>');" class="p-1">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                    <b><?=$r_head->NAME?> </b>
                                                    <i class="fa fa-level-down text-red" aria-hidden="true"></i>
                                                </span>
                                            </h6>
                                        
                                        <?php
                                    endif;
                                    ?>

                                    <div class="col<?=$rej_master_tb->remark_head?>">
                                        <label class="ml-3 mb-2 mt-2">
                                            <input disabled style="width: 16px; height: 16px;" type="checkbox" value="<?=$rej_master_tb->reject_code?>"  
                                            
                                            <?php 
                                                foreach($rejected_list_json as $re_list)
                                                {
                                                    if($rej_master_tb->reject_code == $re_list->reject_code)
                                                    {
                                                        echo "checked";
                                                    }
                                                }
                                            ?>> &nbsp;<?=$rej_master_tb->remark?>
                                            <?php
                                                foreach($rejected_list_json as $re_list)
                                                {
                                                    if($rej_master_tb->reject_code == $re_list->reject_code)
                                                    {
                                                        if(trim($re_list->sub_rejected_remark))
                                                        {
                                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input readonly class="form-control" value="'.$re_list->sub_rejected_remark.'">';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </label>
                                        
                                        <span id="additional_input<?=$rej_master_tb->reject_code?>">
                                        </span>
                                    </div>

                            <?php
                                $count++;
                                endif;
                            }
                        }
                        
                    }
                }
            }                                    
        endif;
    }
?>