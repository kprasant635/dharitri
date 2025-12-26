<style>
    .bg-cross{
        background-image:url('<?php echo base_url(); ?>application/views/images/crossword.png');
    }
    .logo{
        height : 15%!important; 
        width : 15%!important;
        text-align :center!important;
    }
    .logoEmblem{
        height:100%!important;
        width:100%!important;
    }
    .logoBorder{
        border:0px;
    }
</style>

<div class="modal" id="digital_patta_modal">
<div class="col-lg-10 offset-1">
    
    <div class="bg-cross" id="print_div" style="font-size:10px">                        
        <div class="panel-body mt-5">  
            
            <!-- heading row(logo) -->
            <table>
                <tbody>
                    <tr>                            
                        <td class="logo logoBorder" style="text-align:center">
                            <img src='<?php echo base_url(); ?>assets/digital_patta/basundhara_white_logo.png'height="100" width="100">
                        </td>
                        <td class="logoBorder logoEmblem" style="text-align:center">
                            <img src='<?php echo base_url(); ?>assets/digital_patta/emblem.png' height="100" width="100"> 
                        </td>
                        <td class="logo logoBorder" style="text-align:center">
                            <!-- <img src='<?php echo base_url(); ?>assets/digital_patta/dummy_qr.png' height="100" width="100"> -->
                            <img src="<?php echo $base_64_qr ?>" height="100px" width="100px">                    
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="himanxu-margin-top" style="width:100%">
                <tbody style="table-width:100%;text-align:right;">
                    <tr class="logoBorder" style="table-width:100%;text-align:right"> 
                        <td style="text-align:right;" class="logoBorder">DATE OF ISSUE: <?=DIGITAL_PATTA_PATTA_INFO_DATE_OF_ISSUE?></td>
                    </tr>
                <tbody>
            </table>

             <!-- header 1  -->
             <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 text-center " style="text-align:center">
                    <span class="text-danger" style="font-size:20px;font-weight:bold">
                        OFFICE OF THE DISTRICT COMMISSIONER,&nbsp; <?php echo $district_name_eng?>
                        <b></b>
                    </span>
                </div>                
                <div class="col-lg-2"></div>
            </div>
            <!-- header 2  -->
            <div class="row mt-3 ">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div class="text-black p-1 text-center " style="text-align:center;font-size:16px;font-weight:bold">
                        <span class="font-weight-bold digital_patta_heading">DIGITAL ALLOTMENT CERTIFICATE
                        </span>
                        <br>(As per Land policy)
                    </div>                    
                </div>                
            </div>  
            
            <!-- primary land holder details -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">

                <table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th>Land Advisory Committee Proposal No & Date</strong></td>
                        <td> <?php echo $certificate_data->land_advisiory_proposal_no.  ', '. $certificate_data->lapn_date?> </td>
                    </tr>
                    <tr>
                        <td><strong>Allotment Certificate No & Date</strong></td>
                        <td> <?php echo $certificate_data->certificate_no.  ', '. $certificate_data->certificate_date?> </td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center">INSTITUTION DETAILS</th>
                    </tr>
                    <tr>
                        <td><strong>Institution/Entity Name</strong> </td>
                        <td><?php echo $certificate_data->institute_name?></td>
                    </tr>
                    <tr>
                        <td><strong>Category</strong></td>
                        <td><?php echo $certificate_data->ins_category?></td>
                    </tr>
                    <tr>
                        <td><strong>Address & Other Details</strong></td>
                        <td></td>
                    </tr>
                </table>

                    <table class="table table-bordered himanxu-table-width-100  himanxu-heading-weight">
                    <thead>
                            <td colspan='9' style="text-align:center " class="himanxu_header_red himanxu_font_bold_heading" >
                                <b>Land Description</b>  
                            </td>
                        </tr>  
                        <tr>
                            <td colspan='9' style="text-align:center " class="himanxu_header_red himanxu_font_bold_heading" >
                                <b>LAND SCHEDULE DETAILS</b>  
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td><b>District</b></td>
                            <td><?php echo $certificate_data->district_name?></td>
                            <td><b>Sub-Division</b></td>
                            <td><?php echo $certificate_data->subdivision_name?></td>
                            <td><b>Circle</b></td>
                            <td><?php echo $certificate_data->circle_name?></td>
                        </tr>
                        <tr>
                            <td><b>Mouza</b></td>
                            <td><?php echo $certificate_data->mouza_pargona_name?></td>
                            <td><b>Lot</b></td>
                            <td><?php echo $certificate_data->lot_name?></td>
                            <td><b>Village</b></td>
                            <td><?php echo $certificate_data->village_name?></td>
                        </tr>
                        <tr>
                            <td><b>Dag No. (old)</b></td>
                            <td><b>Dag No. (new)</b></td>
                            <td><b>Land Class</b></td>
                            <td colspan="4" class="text-center"><b>Total Area (sq.ft)</b></td>
                        </tr>
                        <tr>
                            <td rowspan=2><?php echo $certificate_data->dag_no_old?></td>
                            <td rowspan=2></td>

                            <td rowspan=2><?php echo $certificate_data->land_class_name?></td>
                            <td colspan="2" style="width: 50%; text-align: center;"><strong>B-K-L / B-K-C-G</strong></td>
                            <td colspan="2" style="width: 50%; text-align: center;"><strong>Hec-Are-Cen</strong></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width: 50%; text-align: center;"><?php echo $dag_details->dag_area_b .'-'.$dag_details->dag_area_k .'-'.$dag_details->dag_area_lc ?></td>
                            <td colspan="2" style="width: 50%; text-align: center;"> <?php echo $hec_are_car ?></php></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered himanxu-table-width-100  himanxu-heading-weight">
                    <thead>


                        <tr>
                            <td colspan='9' style="text-align:center " class="himanxu_header_red himanxu_font_bold_heading" >
                                <b>LAND SCHEDULE DETAILS</b>  
                            </td>
                        </tr>

                        
                        <tr>
                            <td colspan="2"><b> Boundary Description</b></td>
                            <td colspan="2"><b>Dag No. (new)</b></td>
                            <td><b>North</b></td>
                            <td><b>South</b></td>
                            <td><b>East</b></td>
                            <td><b>West</b></td>
                        </tr>

                        <tr rowspan="14">
                            <td colspan="2">&nbsp;<br/>&nbsp;</td>
                            <td colspan="2"></td>
                            <td><?php echo $certificate_data->north?></td>
                            <td><?php echo $certificate_data->south?></td>
                            <td><?php echo $certificate_data->east?></td>
                            <td><?php echo $certificate_data->west?></td>


                        </tr>

                        <tr>
                            <td colspan="4"></td>
                            <td>ULPIN*/Dag No</td>
                            <td>ULPIN*/Dag No</td>
                            <td>ULPIN*/Dag No</td>
                            <td>ULPIN*/Dag No</td>                         
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="5">ULPIN*/Geo-coordinates </td>
                            <td colspan="5">Land Schedule Sketch (Link) </td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td colspan="5"> <img src="<?php echo $base_64_qr ?>" height="100px" width="100px">   </td>
                        </tr>
                        



                        
                            
                           
                    </tbody>
                </table>                  
            </div>
        </div>




            
           
    
</div>
<div class="col-md-12 mt-3" style="text-align:center">
    <button type="button" class="btn btn-danger himanxuNotShowButton" id="modal-close">Close &times; </button>
</div>

<script>

    // onload
    $(document).ready(function () {
        var district_id = $("#selectDistrict").val();

        // get districtName 

        // console.log(district_id,"zxczx");

    });
    //function to close modal 
    $(document).on('click', '#modal-close', function () {
        $('#digital_patta_modal').hide('300');
    });
</script>




