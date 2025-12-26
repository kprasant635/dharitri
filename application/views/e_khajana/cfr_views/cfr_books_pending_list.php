<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-warning text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(CFR Book Pending List)</b><br>
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
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($allCfrBoooksDetails as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                        <?=$this->utilityclass->getCircleName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$this->utilityclass->getMouzaName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code)?>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$row->doul_year?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$row->cfr_book_number?>
                                        <span>
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/EkhajanaCFR/viewCFRBookDetails/'.$row->id?>" role="button" style="font-size: 14px;">
                                            View Details
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
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
