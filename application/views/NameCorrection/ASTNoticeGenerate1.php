<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
    }
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info ">
                    <div class="panel-body" id="printdiv">
                        <p class='center bold uni_text' style="font-size: 28px; font-weight: bold;"><u>অসম চৰকাৰ</u></p>
                        <p class='center bold uni_text' style="color: #990000;"><u>চক্র্ বিষয়াৰ কাৰ্য্যালয়, <?php echo $namedata[2]->circle; ?></u></p>
                        <h5 class="text-center bold"><?php echo $this->lang->line('case_no'); ?> : <?php echo $_GET['misc_case_no']; ?></h5>
                        <table class='table table-condensed'>
                            <tr>
                                <td width='50%'><h5><mark><?php echo $this->lang->line('petitioner_name'); ?></mark></h5></td>
                               <!--  <td width='50%'><h5><mark><span class="pull-right"><?php echo $this->lang->line('second_party'); ?></span></mark></h5></td> -->

                            <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php
                            }
                            ?>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $i = 1;
                                    $pet1=null;
                                    //var_dump($Petitioner);
                                    $r1 = count($Petitioner);
                                    foreach ($Petitioner AS $ss) {
                                        if ($r1 > 1) {
                                            if ($i == 1) {
                                                echo $pet1 = $ss->petition_pdar_name_old . " and others ";
                                            }
                                        } else {
                                            echo $pet1 = $ss->petition_pdar_name_old;
                                        }
                                        $i++;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $i1 = 1;
                                    $r2 = count($secondparty);
                                    foreach ($secondparty AS $ss) {
                                        if ($r2 > 1) {
                                            if ($i1 == 1) {
                                                echo $ss->pdar_name . " and others ";
                                            }
                                        } else {
                                            echo "<span class='pull-right red'>".$ss->pdar_name."</span>";
                                        }
                                        $i1++;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <center>
                        <table class='unicode' width='100%' style="margin-left:5px;">
                            <tr>
                                <td>To,<br>
                                    <?php
                                    $r = count($secondparty);
                                    $c = 1;
                                    foreach ($secondparty AS $ss) {
                                        if ($c < $r) {
                                            echo $ss->pdar_name . ", ";
                                        } else {
                                            echo "<span class='red'>".$ss->pdar_name."</span>";
                                        }
                                        $c++;
                                    }
                                    ?>
                                    <p style="text-indent: 100px;">(Notice of the Opposite party No .................................................. ...............................to be served upon the Opposite Party No ...........................................................................)</p>
                                    <p style="text-indent: 100px;">
                                        Whereas the petitioner <span class='green'><?php echo $pet1; ?>
                                        </span> 

                                        (<?php echo $namedata[5]->village; ?>, <?php echo 'Dag no :'. $miscCaseInfo->dag_no; ?>,<?php echo 'Patta no :'. $miscCaseInfo->patta_no; 
                                         if($basundharaApp){ 

                                            echo '  Mobile :'.$basundharaApp->applicants[0]->mobile; 

                                         }?>)

                                        has filed the petition in my court for Name Correction your name from the record.
                                    </p><br/>
                                    <p>
                                        You are hereby given the notice to present in my court at <?php echo $miscCaseInfo->time_to_present; ?>  on <?php echo date("d-m-Y", strtotime($miscCaseInfo->next_date_of_hearing)); ?>
                                    </p>
                                    <p>
                                        Given under my hand and seal of this court on <?php echo date("d-m-Y"); ?> at <?php echo $namedata[2]->circle; ?>.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 40px;"><?php echo $user_name->username; ?><br>
                                    চক্র বিষয়া,&nbsp;<?php echo $namedata[2]->circle; ?></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class='dontshow'>

                        <a onclick="return myFunction()" href="<?php echo base_url();?>index.php/NameCorrection/notice_generation_save?case_no=<?php echo $_GET['misc_case_no']."&petition_no=".$_GET['petition_no']; ?>" class="btn btn-danger uni_text" >
                            <i class='fa fa-check'></i>&nbsp;Print this page & Complete Notice Generation
                        </a>

                         <?php if(!empty($app->basundhara)){ ?>
                        <a onclick="return myFunction()" href="<?php echo base_url();?>index.php/NameCorrection/notice_generation_save?case_no=<?php echo $_GET['misc_case_no']."&petition_no=".$_GET['petition_no']."&application_no=".$app->basundhara; ?>" class="btn btn-danger uni_text" >
                            <i class='fa fa-check'></i>&nbsp;Print this page & Complete Notice Generation
                        </a>
                    <?php }?>
                        </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
		$(".dontshow").hide();
        //$('#application_no').val();
		
        window.print();
		$(".dontshow").show();
		document.getElementById("mainMenu").disabled = false;
		}
 </script>
    

