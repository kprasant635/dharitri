<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: landscape; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }
</style>


<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">             

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Newly added area
                        </h3>
                    </div>
                    <div class="panel-body">


                      

                         <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' width="100%">
                                <thead>
                                <th><label class="control-label">Village</label></th>
                                
                                <th class="center"><label class="control-label">Area</label></th>
                               
                                </thead>
                                <?php foreach($result as $result){ ?>
                                    <tr>
                                        <td>
                                          <?php echo $result['village_name'] ;?>

                                        </td>
                                        <td>
                                            <?php 
                                        

                                            echo $result['bigha']." B-".$result['katha']." K-".$result['lessa']." L" ; 

                                         }
                                            ?>
                                        

                                        </td>
                                        
                                    </tr>
                                
                            </table>
                            <br>
                             <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label">Village</label></th>
                                
                                <th class="center"><label class="control-label">Area</label></th>
                               
                                </thead>
                                
                                    <tr>
                                        <td>
                                        </td>
                                   
                                        
                                    </tr>
                                
                            </table>

                             <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label">Village</label></th>
                                
                                <th class="center"><label class="control-label">Area</label></th>
                               
                                </thead>
                                
                                    <tr>
                                        <td>
                                        </td>

                                        
                                    </tr>
                                
                            </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/GenerateDoul/CircleWiseDoulGenerate' ?>";
        };
        
        function myFunction() {
            $(".dontshow").hide();
            window.print();
            $(".dontshow").show();
                document.getElementById("mainMenu").disabled = false;
        }
</script>