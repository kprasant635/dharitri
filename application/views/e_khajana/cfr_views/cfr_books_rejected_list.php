<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-danger text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(CFR Book Rejected List)</b><br>
            </u>                        
        </h3>
    </div>  
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_co_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                            <td>Circle</td>
                                <td>Mouza</td>
                                <td>Year No</td>
                                <td>Book No</td>
                                <td>No Of Pages</td>
                                <td>CFR page <br>Serial No Start</td>
                                <td>CFR page <br>Serial No End</td>
                                <td>TN Remark</td>                                
                                <td>ADC Remark</td>                                
                                <td>Entry Date</td>                                
                                <td>Rejected Date</td>  
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($allCfrBoooksDetails as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder text-dark">
                                        <?=$this->utilityclass->getCircleName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-dark">
                                            <?=$this->utilityclass->getMouzaName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code)?>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-dark">
                                            <?=$row->doul_year?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$row->cfr_book_number?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$row->no_of_cfr_pages_in_the_book?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$row->cfr_page_serial_no_start?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$row->cfr_page_serial_no_end?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$row->tn_remarks?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$row->adc_remarks?>
                                        <span>
                                    </td>
                                    <?php 
                                        $date = new DateTime($row->created_at); // Example date and time
                                        $created_at = $date->format('l, F j, Y, h:i A'); 
                                    ?>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$created_at?>
                                        <span>
                                    </td>
                                    <?php 
                                        $date = new DateTime($row->modified_at); // Example date and time
                                        //$modified_at = $date->format('l, h:i A');  
                                        $modified_at = $date->format('l, F j, Y, h:i A');
                                    ?>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            <?=$modified_at?>
                                        <span>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>
