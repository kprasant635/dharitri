<?php if(isset($area_modified)){
if ($area_modified) {
    ?>
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
<h5 class="bg-warning p-2" style="margin-top: 50px">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> 
    Area Modified
</h5>
<div class="tree">
  <ul>

        <?php
    foreach ($area_modified as $areaMod) {
        ?>
                <li>
                <span><i class="icon-calendar"></i> <strong>Dag: <?=$areaMod->dag_no?></strong></span>
                <ul>
                    <li>
                    <span class="badge badge-warning"><i class="icon-minus-sign"></i> Actual applied area</span>
                    <ul>
                        <li>
                            <a href=""><span><i class="icon-time"></i> Project/Infrastructure</span> &ndash; B: <?=$areaMod->applied_area_home_bigha?> K: <?=$areaMod->applied_area_home_katha?> L: <?=$areaMod->applied_area_home_lessa?>
                        
                        <?php if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            ?>
                            G: <?=$areaMod->applied_area_home_ganda?> K: <?=$areaMod->applied_area_home_kranti?>
                            <?php
                        }
        ?>
                            </a>
                        </li>
                        <!-- <li>
                            <a href=""><span><i class="icon-time"></i> Agricultural</span> &ndash;  B: <?=$areaMod->applied_area_agri_bigha?> K: <?=$areaMod->applied_area_agri_katha?> L: <?=$areaMod->applied_area_agri_lessa?>
                            <?php if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                                ?>
                                G: <?=$areaMod->applied_area_agri_ganda?> K: <?=$areaMod->applied_area_agri_kranti?>
                                <?php
                            }
        ?>
                            </a>
                        </li> -->
                    </ul>
                    </li>
                    <li>
                    <span class="badge badge-important"><i class="icon-minus-sign"></i> Area Modified to</span>
                    <ul>
                        <li>
                        <a href=""><span><i class="icon-time"></i> Project/Infrastructure</span> &ndash; 
                            B: <?=$areaMod->settlement_area_home_bigha?> K: <?=$areaMod->settlement_area_home_katha?> L: <?=$areaMod->settlement_area_home_lessa?>
                            <?php if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                                ?>
                                G: <?=$areaMod->settlement_area_home_ganda?> K: <?=$areaMod->settlement_area_home_kranti?>
                                <?php
                            }
        ?>
                    
                        </a>
                        </li>
                        <!-- <li>
                            <a href=""><span><i class="icon-time"></i> Agricultural</span> &ndash;
                                B: <?=$areaMod->settlement_area_agri_bigha?> K: <?=$areaMod->settlement_area_agri_katha?> L: <?=$areaMod->settlement_area_agri_lessa?>
                                <?php if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                                    ?>
                                    G: <?=$areaMod->settlement_area_agri_ganda?> K: <?=$areaMod->settlement_area_agri_kranti?>
                                    <?php
                                }
        ?>
                            
                            </a>
                        </li> -->
                    </ul>
                    </li>
                </ul>
                </li>

            <?php
    }
    ?>

  </ul>
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

<?php }} ?>