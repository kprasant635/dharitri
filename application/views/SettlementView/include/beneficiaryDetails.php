<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }

</style>

<!-- css for the tree design -->
<style>
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #FBFBFB;
        border: 1px solid #999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative;
    }
    .tree li::before,
    .tree li::after {
        content: "";
        left: -20px;
        position: absolute;
        right: auto;
    }
    .tree li::before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px;
    }
    .tree li::after {
        border-top: 1px solid #999;
        height: 20px!important;
        top: 25px;
        width: 25px;
    }
    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #999;
        border-radius: 5px;
        display: inline-block;
        padding: 3px 8px;
        text-decoration: none;
    }
    .tree li.parent_li > span {
        cursor: pointer;
    }
    .tree > ul > li::before,
    .tree > ul > li::after {
        border: 0;
    }
    .tree li:last-child::before {
        height: 46px;
    }
    .tree li.parent_li > span:hover,
    .tree li.parent_li > span:hover + ul li span {
        background: #eee;
        border: 1px solid #94A0B4;
        color: #000;
    }
    .rezaSpan{
        min-width: 140px;
        padding-left: 15px;
    }
    .rezaSpanB{
        min-width: 100px;
        padding-left: 15px;
    }
    .rezaCaseSpan{
        min-width: 270px;
        padding-left: 15px;
    }
    .badge-reza1{
        background-color: #F44336;
    }
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #9C27B0;
    }
</style>

<div class="container">
    <div class="reza-card">
        <div class="reza-body">

            <div class="tree">
                <ul>
                    <li>
                        <span><i class="icon-calendar"></i> <?=$_GET['case']?></span>
                        <ul>
                            <?php foreach($data as $bene_details):?>
                            <li>
                                <span class="badge badge-info">
                                    <i class="icon-minus-sign"></i>
                                        OWNER &ndash; 
                                    <?php
                                        if($bene_details->owner_living_status == 'NO'){
                                            echo $bene_details->owner_name;
                                        }else{
                                            echo $bene_details->owner_name;
                                        } 
                                    ?>
                                </span>

                                <?php if(trim($bene_details->owner_living_status) == 'YES'):?>
                                <span class="badge badge-success">
                                    <i class="icon-minus-sign"></i>
                                    Alive
                                </span>
                                <?php endif;?>

                                <?php if(trim($bene_details->owner_living_status) == 'NO'):?>
                                <span class="badge badge-danger">
                                    <i class="icon-minus-sign"></i>
                                    Dead
                                </span>
                                <?php endif; ?>

                                <?php if(trim($bene_details->owner_living_status) == 'UNT'):?>
                                    <span class="badge badge-danger">
                                        <i class="icon-minus-sign"></i>
                                        Untraceable
                                    </span>
                                <?php endif;

                                if(trim($bene_details->owner_living_status) == 'CCA'):?>
                                    <span class="badge badge-danger">
                                        <i class="icon-minus-sign"></i>
                                        Could not capture account details
                                    </span>
                                <?php endif;

                                if($bene_details->owner_living_status == 'YES'):
                                ?>
                                <ul>
                                    <?php 
                                        foreach($data_alive as $alive_data): 
                                            if($alive_data->pdar_id == $bene_details->pdar_id):
                                        ?>
                                    <li>
                                        <span class="badge badge-primary"><i class="icon-calendar"></i> 
                                            Personal Information
                                        </span>
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <span>
                                                        <i class="icon-time"></i> 
                                                        <strong>Bank-</strong> 
                                                        <?=$alive_data->owner_father?>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    <span class="badge badge-primary">
                                        <i class="icon-calendar"></i> 
                                        Banking Details
                                    </span>
                                    <ul>
                                        <li>
                                            <a href="">
                                                <span>
                                                    <i class="icon-time"></i> 
                                                    <strong>Bank-</strong> 
                                                    <?=$alive_data->bene_bank_name?>
                                                </span>
                                                <span>
                                                    <i class="icon-time"></i> 
                                                    <strong>A/C-</strong> 
                                                    <?=$alive_data->bene_account_no?>
                                                </span>
                                                <span>
                                                    <i class="icon-time"></i> 
                                                    <strong>IFSC-</strong> 
                                                    <?=$alive_data->bene_ifsc?>
                                                </span>
                                                <span>
                                                    <i class="icon-time"></i> 
                                                    <strong>Compensation amount-</strong> 
                                                    <?=$alive_data->amount?>(<?=$alive_data->bene_percentage?>%)

                                                </span>
                                                &ndash; 
                                                <?php
                                                    if($alive_data->payment_status == 0){
                                                        echo "Payment Status - <strong class='text-danger'>Pending</strong>";
                                                    }else{
                                                        echo "Payment Status - <strong class='text-success'>Paid</strong>";
                                                    }
                                                ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php 
                                endif; 
                            endforeach;
                            ?>
                            </ul>


                             
                                <?php endif; ?>

                                <ul>
                                <?php 
                                if($bene_details->owner_living_status == 'NO'):
                                    if(isset($data_dead)):
                                        foreach($data_dead as $dead_data):
                                            if($dead_data->pdar_id == $bene_details->pdar_id):
                                            ?>
                                                <li>
                                                <span class="badge badge-success">
                                                    <i class="icon-minus-sign"></i> 
                                                    NOK &ndash; <?=$dead_data->bene_name?>
                                                </span>
                                                
                                                <ul>
                                                    <li>
                                                    <span class="badge badge-primary"><i class="icon-calendar"></i>Personal Information</span>
                                                        <ul>
                                                            <li>
                                                                <a href="">
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Guardian Name &ndash;</strong> 
                                                                        <?=$dead_data->bene_guardian?>
                                                                    </span> 
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>DOB &ndash;</strong> 
                                                                        <?=$dead_data->bene_dob?>
                                                                    </span> 
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Relation &ndash;</strong> 
                                                                        <?php
                                                                            foreach($guar_rel as $rel):
                                                                                if($rel->id == $dead_data->bene_relation):
                                                                                    echo $rel->guard_rel_desc_as;
                                                                                endif;
                                                                            endforeach;
                                                                        ?>
                                                                    </span>
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Gender &ndash;</strong> 
                                                                        <?php if($dead_data->bene_gender == 1){
                                                                                    echo "Male";
                                                                                }else{
                                                                                    "Female";
                                                                                }
                                                                        ?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="">
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Mobile &ndash;</strong> 
                                                                        <?=$dead_data->bene_mobile?>
                                                                    </span>
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Eligibility for compensation &ndash;</strong> 
                                                                        <?=$dead_data->bene_compensation_eligibility?>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="">
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Present Address &ndash;</strong> 
                                                                        <?=$dead_data->bene_present_address?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="">
                                                                    <span>
                                                                        <i class="icon-time"></i>
                                                                        <strong>Permanent Address &ndash;</strong> 
                                                                        <?=$dead_data->bene_permanent_address?>
                                                                    </span>
                                                            
                                                                    <!-- &ndash; 
                                                                    Changed CSS to accomodate... -->
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>

                                                    <?php if($dead_data->bene_compensation_eligibility == 'YES'):?>
                                                    <li>
                                                    <span class="badge badge-primary"><i class="icon-calendar"></i>Banking Details</span>
                                                        <ul>
                                                            <li>
                                                                <a href="">
                                                                <span>
                                                                    <i class="icon-time"></i> 
                                                                    <strong>Bank-</strong> 
                                                                    <?=$dead_data->bene_bank_name?>
                                                                </span>
                                                                <span>
                                                                    <i class="icon-time"></i> 
                                                                    <strong>A/C-</strong> 
                                                                    <?=$dead_data->bene_account_no?>
                                                                </span>
                                                                <span>
                                                                    <i class="icon-time"></i> 
                                                                    <strong>IFSC-</strong> 
                                                                    <?=$dead_data->bene_ifsc?>
                                                                </span>
                                                                <span>
                                                                    <i class="icon-time"></i> 
                                                                    <strong>Compensation amount-</strong> 
                                                                    <?=$dead_data->amount?>(<?=$dead_data->bene_percentage?>%)

                                                                </span>
                                                                &ndash; 
                                                                <?php
                                                                    if($dead_data->payment_status == 0){
                                                                        echo "Payment Status - <strong class='text-danger'>Pending</strong>";
                                                                    }else{
                                                                        echo "Payment Status - <strong class='text-success'>Paid</strong>";
                                                                    }
                                                                ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <?php endif; ?>

                                                </ul>
                                             
                                                </li>
                                            <?php 
                                            endif;
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                                </ul>

                            

                            </li>             
                            <?php endforeach; ?>
                
                        </ul>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>


<!-- script for the tree design -->
<script>
     $(function () {
        $(".tree li:has(ul)")
            .addClass("parent_li")
            .find(" > span")
            .attr("title", "Collapse this branch");
        $(".tree li.parent_li > span").on("click", function (e) {
            var children = $(this).parent("li.parent_li").find(" > ul > li");
            if (children.is(":visible")) {
                children.hide("fast");
                $(this)
                    .attr("title", "Expand this branch")
                    .find(" > i")
                    .addClass("icon-plus-sign")
                    .removeClass("icon-minus-sign");
            } else {
                children.show("fast");
                $(this)
                    .attr("title", "Collapse this branch")
                    .find(" > i")
                    .addClass("icon-minus-sign")
                    .removeClass("icon-plus-sign");
            }
            e.stopPropagation();
        });
    });
</script>