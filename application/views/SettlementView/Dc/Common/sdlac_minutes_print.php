<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
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
        padding: 20px;
        color: #37474F;
    }
    .reza-title-2{
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }


    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }

    .rezaText {
        font-size: 16px;
        padding: 20px;
    }


</style>

<div class="row" style='padding: 15px 30px 15px 0px' id="print_direct">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px">

        <div class="reza-card">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                    <img src="<?php echo base_url();?>application/views/images/emblem.png">
                </div>
            </div>
            <div class="reza-title-2" style="text-align: center;">
                <span style="font-weight: bold">
                    GOVERNMENT OF ASSAM
                    <br>
                    OFFICE OF THE DISTRICT COMMISSIONER: <?php echo $districtName->locname_eng ?>
                </span>
            </div>
            <br><br>
            <div class="reza-title" style="text-align: center;">
                Minutes of the meeting of SDLAC/CDLAC held on
                <?php echo date("d-M-Y", strtotime($proDetails->meeting_date)) ?>
                at <?php echo date("h:i A", strtotime($proDetails->meeting_date)) ?>
                in the
                <?php echo $proDetails->meeting_venue ?>
                ( <?php echo $districtName->locname_eng ?>)
            </div>
            <br>

            <div class="reza-title" style="margin-bottom: 20px">
                Members present:
                <br>
                <table width="100%" style="margin-left: 20px; margin-bottom: 15px">
                    <?php $j = 0; foreach ($sdlacMembers as $member):  $j++ ?>
                        <tr >
                            <td><?php echo $j .'.'  ?></td>
                            <td><?php echo $member->username .'. &nbsp; '. $member->display_name   ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <br><br>

            <div class="rezaText">
                The meeting was presided over by  <b><?php echo $dcName->username ?> </b> District Commissioner
                & Chairman, SDLAC/CDLAC,
                <b> <?php echo $districtName->locname_eng ?> </b>.
                He welcomed all the members present in the meeting and apprised the house about the objectives of the meeting.
                Initiating the meeting, the Chairman placed the settlement proposals of the individuals for each Revenue Circle
                of the district before the SDLAC/CDLAC for discussion and consideration.

                <br>
                &nbsp; &nbsp; &nbsp; &nbsp;

                After threadbare discussion, following settlement proposals submitted by the
                Revenue Circle Officers under …………………………………….
                Sub-Division are recommended unanimously by the SDLAC/CDLAC subject to fulfillment of
                extant guidelines laid down in Mission Basundhara, Land Policy, 2019 and verification of
                all related records/documents.
            </div>

            <div class="rezaText">
                ………………/……..……… Revenue Circle:
            </div>

            <br><br>
            <div class="reza-title" style="margin-bottom: 20px">
                Proposal for
                <?php
                if($proDetails->service_code == 13)
                {
                    echo 'Settlement of Occupancy Tenant';
                }
                else if($proDetails->service_code == 14)
                {
                    echo 'Settlement of AP Transferred ';
                }
                else if($proDetails->service_code == 15)
                {
                    echo 'Settlement of hereditary land of Tribal Communities';
                }
                else if($proDetails->service_code == 16)
                {
                    echo 'Settlement of Khas & Ceiling Surplus Land';
                }
                else if($proDetails->service_code == 17)
                {
                    echo 'Settlement of PGR VGR Land';
                }
                else if($proDetails->service_code == 18)
                {
                    echo 'Settlement of Land for Indigenous Special Cultivators (Tea/Coffee/Rubber)';
                }
                else
                {
                    echo 'Not Mention';
                }
                ?>
            </div>
            <br>

            <div class="reza-body">
                <?php if ($caseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table'  width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name of the Settlement holder</th>
                            <th>Area of the proposed land</th>
                            <th>Dag No</th>
                            <th>Area</th>
                            <th>Proposal No </th>
                            <th>Remarks</th>

                        </tr>
                        </thead>

                        <?php $i=0; $ss=1; foreach ($cases as $case  ): ?>

                            <tr  style="background-color: white; ">
                                <td><?php echo $ss .'. ' ?></td>
                                <td><?php echo $case[$i]->name ." (".$case[$i]->gurdian.")"?></td>
                                <td>
                                    <?php echo "Settlement Proposal for ".
                                        " of village ".$case[$i]->village." under ".$case[$i]->mouza." Mouza ".
                                        $case[$i]->cirname ." Circle"?>
                                </td>
                                <td>
                                    <?php

                                    $reza = (explode(",",$case[$i]->dags));
                                    for($k=0; $k<count($reza); $k++)
                                    {
                                        echo $reza[$k].'<br>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $bkl = (explode(",",$case[$i]->area));
                                    for($n=0; $n<count($bkl); $n++)
                                    {
                                        $BKLData = $this->utilityclass->Total_Bigha_Katha_Lessa($bkl[$n]);

                                        echo $BKLData[0]."B-".$BKLData[1]."K-".$BKLData[2]."L".'<br>';
                                    }

                                    ?>
                                </td>
                                <!--                                <td>-->
                                <!--                                    --><?php
                                //                                    $mm = (explode(",",$case[$i]->ladtype));
                                //                                    for($k=0; $k<count($mm); $k++){
                                //                                        if($mm[$k]== '1')
                                //                                        {
                                //                                            echo 'Homestate<br>';
                                //                                        }
                                //                                        else if($mm[$k]== '2')
                                //                                        {
                                //                                            echo 'Agriculture<br>';
                                //                                        }
                                //                                        else if($mm[$k]== '3')
                                //                                        {
                                //                                            echo 'Both<br>';
                                //                                        }
                                //                                    }
                                //                                    ?>
                                <!--                                </td>-->
                                <td><?php echo $proposal_no ?></td>
                                <td><?php echo $case[$i]->remark ?></td>

                            </tr>

                            <?php $ss++; endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>



            <div class="reza-body" style="margin-bottom: 20px">
                The meeting ended with vote of thanks from the chair.
            </div>
            <br>
            <div class="reza-body">
                <div class="row mt-5 justify-content-end mb-5">
                    <div class="col-5 text-center">
                        District Commissioner &
                        Chairman, SDLAC/CDLAC
                        <br>
                        <b><?php echo $districtName->locname_eng ?></b><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        Memo No. M<?php echo date("dm", strtotime($proDetails->meeting_date)).$proDetails->id ?>
                    </div>
                    <div class="col-md-5" align="center">
                        Date  <?php echo date("d-M-Y", strtotime($proDetails->meeting_date)) ?>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <br>
                        Copy for information to:
                    </div>

                </div>
                <div style="margin-bottom: 20px; padding-left: 15px">
                    <br>
                    1.	The Principal Secretary to the Govt. of Assam, Revenue & DM Department, Dispur, Guwahati-06, Assam for kind information
                    <br>
                    2.	The Commissioner, Lower Assam Division, Guwahati-1 for kind information.
                    <br>
                    3.	…………………………………………, Hon’ble MP , …………………… H.P.C.
                    <br>
                    4.	…………………………………………, Hon’ble MLA, ……………….LAC.
                    <br>
                    5.	The Chairman, ………………………………………… Zilla Parishad.
                    <br>
                    6.	The Chairman, …………………………………………/………………/ Municipal Board.
                    <br>
                    7.	All Circle Officers of ………………………………………… District.
                    <br>
                    8.	…………………………………………/…………………………………………, Social Worker
                    <br>
                    9.	Office file.

                    <br>


                </div>
                <br>
            </div>


            <div class="row mt-5 justify-content-end mb-5">
                <div class="col-5 text-center">
                    District Commissioner &
                    Chairman, SDLAC/CDLAC
                    <br>
                    <b><?php echo $districtName->locname_eng ?></b><br>
                </div>
            </div>
        </div>

    </div>
</div>




<div class="container">
    <div class="row mt-4 mb-5 justify-content-center text-center">
        <div class="col-6">
            <button type="button" onclick="printDiv('print_direct');" id="print" class="rezaButt">
                <i class="fa fa-print"></i>
                Print Minute
            </button>
        </div>
    </div>
</div>

<script>
    // -js-to print notice
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents
    }
</script>
