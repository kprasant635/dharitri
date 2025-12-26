
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
        <div class="col-lg-7 col-lg-offset-2">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Changes in Land in Mouza :<?php echo $mouza_name ;?> (2020-21) </h2>
                </div>
            </div>           

            <div class="col-lg-10 col-lg-offset-2">
                <div class="panel panel-info center" style="width:70%;">
                    <!-- <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Newly added area
                        </h3>
                    </div> -->
                    <div class="panel-body">

                         <table class='table table-bordered' width="100%">
                                <thead>
                                <th><label class="control-label">Case Type</label></th>
                                
                                <th class="center"><label class="control-label">Area</label></th>

                                <th class="center"><label class="control-label">Revenue</label></th>
                                <th class="center"><label class="control-label">Local Tax</label></th>
                               
                                </thead>
                                <?php 
                                
                                foreach($result as $result){ ?>
                                    <tr>
                                        <td>
                                          
                                         <span class='pull-left'>Newly added area(+)</span>
                                        </td>
                                        <td>
                                           
                                        <?php

                                            echo $result['bigha']." B-".$result['katha']." K-".$result['lessa']." L" ; 

                                         
                                            ?>
                                        

                                        </td>

                                        <td>
                                            <?php 
                            
                                            echo $result['revenue']; 
                                            
                                            
                                            ?>
                                        

                                        </td>

                                        <td>
                                            <?php 
                                        

                                            echo $result['localtax'];

                                        

                                         
                                            ?>
                                        

                                        </td>
                                        
                                    </tr>
                                    <?php 
                                }

                                    ?>
                                    

                                    <?php 
                                        foreach($result1 as $result1){ ?>
                                    <tr>
                                        <td >
                                        <span class='pull-left'>Allotment (+)</span>
                                        </td>
                                       <td>
                                            
                                        <?php 
                                            echo $result1['bigha']." B-".$result1['katha']." K-".$result1['lessa']." L" ; 

                                         
                                            ?>
                                        

                                        </td>

                                        <td>
                                            <?php 
                            
                                            echo $result1['revenue']; 
                                            
                                            
                                            ?>
                                        

                                        </td>

                                        <td>
                                            <?php 
                            
                                            echo $result1['localtax']; 
                                            
                                            
                                            ?>
                                        

                                        </td>


                                        
                                    </tr>
                                    <?php 
                                }

                                    ?>
                                
                            </table>
                            <br>
                             
                        
                    </div>
                </div>


                <div class="panel panel-info" style="width:70%" >
                   <!--  <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            NR Cases
                        </h3>
                    </div> -->
                    <div class="panel-body">


                      

                         <table class='table table-striped table-bordered' width="100%">
                                
                                
                               <!--<thead>
                                // <th><label class="control-label">Case Type</label></th>
                                
                                // <th class="center"><label class="control-label">Area</label></th>
                               
                                // </thead>-->
                                 <?php 
                                        foreach($result3 as $result3){ ?>
                                    <tr>
                                        <td>
                                          <label class="control-label">NR Cases(-) &nbsp;&nbsp;</label>

                                        </td>
                                         <td class="center">

                                        <?php 
                                           

                                            echo $result3['bigha']." B-".$result3['katha']." K-".$result3['lessa']." L" ; 

                                         
                                        ?>

                                        </td>

                                        </td>

                                        <td>
                                            <?php 
                            
                                            echo $result3['revenue']; 
                                            
                                            
                                            ?>
                                        

                                        </td>
                                        </td>

                                        <td>
                                            <?php 
                            
                                            echo $result3['localtax']; 
                                            
                                            
                                            ?>
                                        

                                        </td>


                                        
                                    </tr>

                                  <?php   }
                                            ?>
                                
                            </table>
                            
                            
                        
                    </div>
                </div>



                <div class="panel panel-info"style="width:70%" >
                    <!-- <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Conversion
                        </h3>
                    </div> -->
                    <div class="panel-body">

                   <table class='table table-striped table-bordered' width="100%">
                                <!--<thead>
                                <th><label class="control-label">Case Type</label></th>
                                
                                <th class="center"><label class="control-label">Area</label></th>
                               
                                </thead>-->

                                <?php 
                                        foreach($result2 as $result2)
                                        { 
                                            ?>
                                      <tr> 
                                        <td>
                                           <label class="control-label">Conversion(+)&nbsp;&nbsp;</label>

                                        </td>
                                         <td class="center">
                                            <?php 
                                            
                                            echo $result2['bigha']." B-".$result2['katha']." K-".$result2['lessa']." L" ; 

                                         
                                            ?>
                                        

                                        </td>

                                        <td>
                                            <?php 
                            
                                            echo $result2['revenue']; 
                                            
                                            
                                            ?>
                                        

                                        </td>
                                    

                                        <td>
                                            <?php 
                            
                                            echo $result2['localtax']; 
                                            
                                            
                                            ?>
                                        

                                        </td>
                                        <?php 

                                    }
                                    ?>
                                        
                                    </tr>
                                
                            </table>
                            
                            
                        
                    </div>
                </div>

                 <div class="panel panel-info" style="width:70%" >
                    <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Reclassification
                        </h3>
                    </div>
                    <div class="panel-body">

                         <table class='table table-striped table-bordered' width="100%">
                                <thead>
                                <th><label class="control-label">Old Land Type</label></th>
                                
                                <th class="center"><label class="control-label">New Land Type</label></th>

                                <th class="center"><label class="control-label">Area</label></th>

                                <th class="center"><label class="control-label">Old revenue</label></th>

                               
                                <th class="center"><label class="control-label">Old Land tax</label></th>

                                 <th class="center"><label class="control-label">New revenue</label></th>

                                <th class="center"><label class="control-label">New Land tax</label></th>
                               
                                </thead>
                                
                                    
                                        
                            <?php 
                                foreach($result4 as $result4){
                                    ?>

                                    <tr>
                                        <td>

                                           <?php  echo $result4['land_typePresent'];?> 
                                            </td>
                                     

                                         <td class="center">
                                          
                                            <?php echo $result4['land_typeProposed'];

                                         
                                            ?>

                                        </td>
                                        <td class="center">

                                          <?php   echo $result4['bigha']." B-".$result4['katha']." K-".$result4['lessa']." L" ; 

                                         
                                            ?>
                                        </td>

                                        <td class="center">
                                            
            

                                            <?php echo $result4['preRev'];

                                         
                                            ?>

                                        </td>

                                        <td class="center">
                                            
            

                                            <?php echo $result4['preLocaltax'];

                                         
                                            ?>

                                        </td>
                                        <td class="center">
                                            
            

                                            <?php echo $result4['proRev'];

                                         
                                            ?>

                                        </td>
                                        <td class="center">
                                            
            

                                            <?php echo $result4['proLocaltax'];

                                         
                                            ?>

                                        </td>
                                        
                                    </tr>
                                <?php } ?>
                                
                            </table>
                            
                            
                        
                    </div>
                </div>


                        
                <center>
                  <button id="backButton" class="btn btn-danger  dontshow"><i class="fa fa-arrow-left"></i>&nbsp;Back To Mouza Wise Doul</button>
                            <a onclick="return myFunction()" href="#" class="btn btn-success uni_text dontshow" ><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</a>
                        </center>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/GenerateDoul/MouzaWiseDoulGenerate?mouza_code='.$mouza_code; ?>";
        };
        
        function myFunction() {
            $(".dontshow").hide();
            window.print();
            $(".dontshow").show();
                document.getElementById("mainMenu").disabled = false;
        }
</script>