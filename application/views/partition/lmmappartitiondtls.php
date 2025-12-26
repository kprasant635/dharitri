<div class="container-fluid form-top login">
    <div class='row '>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">
            <?php //var_dump($mappartdtls); ?>
            <div class="bs-callout bs-callout-info" id="callout-navs-tabs-plugin">
                <div class="page-header">
                    <h1 class="uni_text">Update Map on Bhunaksha for the case no #   <span class="red"><?php echo $mappartdtls->ord_no; ?></span></h1>
                    <h2 class="uni_text">Old Dag Number <span class="red"><?php echo  $mappartdtls->dag_no; ?></span></h2>
                    <h2 class="uni_text">New Dag Number <span class="red"><?php echo $mappartdtls->new_dag_no; ?></span> </h2>
                    <h2 class="uni_text">Dag Area to be Partition <span class="red"><?php echo $mappartdtls->m_dag_area_b . " B " . $mappartdtls->m_dag_area_k . " K" . $mappartdtls->m_dag_area_lc . " L" ?></span></h2>
                </div>
            </div>
        </div>
        <div class='col-lg-10 panel panel-danger' style="margin: 0 auto;float: none;">
            <div class="bs-callout bs-callout-danger" id="callout-navs-tabs-plugin">
                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/Partition/UpdateMapPartitionLM" method="POST">
                    <legend class="uni_text">If  Map Partition Has Been Done in Bhunaksha Please Click Here to Confirm !!</legend>
                    <div class="form-group">
                        <div class="col-lg-10">
                             <button type="submit" class="btn btn-primary">Map Partition Done</button>
                             <input type="hidden"  value="<?php  echo $mappartdtls->ord_no; ?>" name="ord_no" />
                             <input type="hidden" value="<?php  echo $mappartdtls->year_no; ?>" name="year_no" />
                        </div>
                    </div>
                </form>
            </div>

            </div>
        </div>
</div>

