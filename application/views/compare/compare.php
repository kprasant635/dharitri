<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<?php $errorFlag=FALSE;?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading bg-info">
                    <h3 class="panel-title bg-info">Information regarding chitha and jamabandi synchronization</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>Comparisons</h1>
                            <table class="table">
                                <tr>
                                    <td>Parameter</td>
                                    <td>Jamabandi</td>
                                    <td>Chitha</td>
                                    <td>Result</td>
                                </tr>
                                <tr>
                                    <td>NO Pattadars</td>
                                    <td><?php echo $jcount; ?></td>
                                    <td><?php echo $ccount; ?></td>
                                    <td>
                                        <?php if ($jcount == $ccount): ?>
                                            OK
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <form method="post">
                        <table class="table">
                            <tr>
                                <th colspan="2">Jama</th><th colspan="2">Chitha</th><th colspan="2">Result</th>
                            </tr>
                            <tr>
                                <td>ID</td>
                                <td>NAME</td>
                                <td>ID</td>
                                <td>NAME</td>
                                <td></td>
                            </tr>
                            <?php foreach($compares as $compare):?>
                            <tr>
                                <td><?php echo $compare->jpid;?></td>
                                <td><?php echo $compare->jpname;?></td>
                                <td><?php echo $compare->cpid;?></td>
                                <td><?php echo $compare->cpname;?></td>
                                <td>
                                    <?php 
                                        if(($compare->jpid == $compare->cpid) && ($compare->jpname == $compare->cpname)){
                                            echo "OK";
                                        }
                                        else{
                                            $errorFlag= TRUE;
                                            echo "Update and Correct Manually";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </table>
                        <?php if($errorFlag == TRUE):?>
                        <div class='alert alert-danger'>
                            <h2>
                                Dharitree has detected discrepancy between chitha and jamabandi due data discrepancy.
                                <p>Possible Solutions:-</p>
                                <ul>
                                    <li>Recreate or Edit Chitha & Jamabandi to be in sync</li>
                                    <li>Or</li>
                                    <li>Pass Order at your own risk & correct using Jamabandi Edit Utility.</li>
                                </ul>
                                 <?php if($this->session->userdata('user_desig_code')=='AST'):?>
                                    <a class="btn btn-danger" href='<?php echo base_url();?>index.php/officemutation/mutationapplicantDetails/'>Procced</a>
                                    <?php endif;?>
                                    <?php if($this->session->userdata('user_desig_code')=='LM'):?>
                                    <a class="btn btn-danger" href='<?php echo base_url();?>index.php/lmmutation/saveFieldMutatonBasic/1'>Procced</a>
                                    <?php endif;?>
                            </h2>
                        </div>
                        <?php else:?>
                             <div class='alert alert-success'>
                                <h2>
                                    Dharitree has detected sync between chitha and jamabandi. Can proceed with case.
                                    <?php if($this->session->userdata('user_desig_code')=='AST'):?>
                                    <a class="btn btn-danger" href='<?php echo base_url();?>index.php/officemutation/mutationapplicantDetails/'>Procced</a>
                                    <?php endif;?>
                                    <?php if($this->session->userdata('user_desig_code')=='LM'):?>
                                    <a class="btn btn-danger" href='<?php echo base_url();?>index.php/lmmutation/saveFieldMutatonBasic/1'>Procced</a>
                                    <?php endif;?>
                                </h2>
                            </div>
                        <?php endif;?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>