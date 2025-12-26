<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm bg-info">
                    <h2 style="text-align: center;">
                        <?php 
                        if($this->session->userdata('ismultiple')==true){
                            $type_of_dag = "( Multiple Dag )";
                        }else{
                            $type_of_dag = "( Single Dag )";
                        }
                        
                        if($this->session->userdata('mut_type')==01){
                            echo "Field Mutation Transfer Type Form For ".$type_of_dag;
                        }else{
                            echo "Field Partition Transfer Type Form For ".$type_of_dag;
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text center">Applicant details Saved Successfully.</h6>
                        </div>
                        <div class="center col-lg-12">
                            <a href="<?php echo base_url() . "index.php/lmmutation/applicantdetails?next=true" ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;Click Here to Add More Applicant 
                            </a>
                            <a href="<?php echo base_url() . "index.php/lmmutation/mutationlandarea" ?>" class="btn btn-success">
                                <i class="fa fa-check"></i>&nbsp;Proceed To Next Stage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        })
    })
</script>