<div class="container-fluid form-top">
    <div class="row login">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center; "><?php echo $this->lang->line('pattadar_showcause_notice'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">

                    <div class="panel-body uni_text" style='min-height:460px'>
                        <h4 class="text-center">অসম চৰকাৰ <br/>
                            চক্র বিষয়াৰ কাৰ্যালয়, <?php echo $circlename[0]->circle; ?>
                        </h4>
                        <p>প্ৰতি  মাননীয়,</p> 
                        <?php foreach ($APCaseShowCauseAST AS $pdar) { ?>
                            <p style="padding-left:40px;"><span class='green'><?php echo $pdar->pdar_name; ?></span>,

                                <?php echo $pdar->pdar_guardian; ?>
                                <br/>
                                <?php echo $pdar->pdar_add1; ?>
                            </p>
                            <?php
                            $dag_no = $pdar->dag_no;
                            $patta_no = $pdar->patta_no;
                        }
                        ?>
                        <p>
                            এই পাট্টাদ্বাৰৰ পাট্টা  <span class='red'>( দাগ নং :  <?php echo $this->utilityclass->cassnum($dag_no); ?>   / পাট্টা নং : <?php echo $this->utilityclass->cassnum($patta_no); ?>)  </span> বাতিল কৰা উচিত হয় নে নহয় সাপেক্ষে  <strong class='red'><b><?php echo $case_no; ?></b></strong> নং গোচৰৰ  মতে কাৰণ দৰ্শোৱাৰ জাননী জাৰী কৰা হ`ল | পৰবৰ্তী শুনানিৰ তাৰিখ <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($date_hearing))); ?> নিৰ্ধাৰিত কৰা হল |
                        </p>
                        <p>
                            <span class="pull-right" style="text-align: center;">
                                <br>
                                <?php echo $location['co_name']; ?> <br>
                                <?php echo $circlename[0]->circle; ?>, চক্র বিষয়া<?php //echo $this->lang->line('circle');  ?> <BR>
                            </span>
                        </p>
                        <br/>
                        
                        <h3>&nbsp;</h3>
                        <div>&nbsp;</div>
                        <br/>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">

                    <center class='dontshow'>
                        <button class='btn btn-danger' onclick="myFunction()">Print this page</button> 
                        <a href="<?php echo base_url(); ?>index.php/home/index" id='mainMenu'  class="btn btn-md btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;Complete Show Cause Notice & Printing
                        </a>
                    </center>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    p{ font-size:.8em !important}
</style>
<script>
    function myFunction() {
        $(".dontshow").hide();
        $(".well").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("mainMenu").disabled = false;
    }
</script>

