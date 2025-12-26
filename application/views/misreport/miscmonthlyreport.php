<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
             <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Monthly Application Received  Report On Miscelleneous Cases </h2>
               
            </div>  
            <div class="alert alert-success" role="alert">
                <h4><?php echo $this->lang->line('district');?> : <kbd><kbd><?php echo $datas['dist_name']; ?></kbd></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : 
                    <kbd><?php echo $datas['sub_div_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <kbd><?php echo $datas['cir_name']; ?></kbd> 
                        <?php echo $this->lang->line('year');?> : <code><?php echo $datas['year'] ?></code> <?php echo $this->lang->line('month');?> : 
                        <code> <?php echo $this->utilityclass->getMonth($datas['month']);  ?></code></h4>
            </div>
            
            <table class="table">
                <thead class="">
                    <tr >
                        <td class="text-center alert-teal">Miscelleneous Case Details</td>
                        <td class="text-center alert-teal">No. of  Miscelleneous Case Application Received </td>
                    
                    </tr>
                </thead>
                <tr>
                    <td class="text-center">Miscelleneous Case Details</td>
                        <td class="text-center"><?php echo  $MiscNamechange->count ?></td>
                    
                    </tr><tr>
                        <td class="text-center">Miscelleneous Case Details</td>
                        <td class="text-center"><?php echo  $MiscDeletepattadar->count ?> </td>
                    
                    </tr>
                    
            </table>
        
        </div>
    </div>
</div>