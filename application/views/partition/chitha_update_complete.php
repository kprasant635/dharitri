<div class="row login">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class='center bold'><span class="rasid"><u>Thank you...!!!!</u></span></p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="rasid table">
                                <tr>
                                    <td style="text-align: center;">Final Order Process for Land Partition has passed and After <span class='red'> Map Partition by Lot Mondal</span> Chitha has to be update By Circle Officer </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-size: 30px;">বাটোবাৰা প্রক্ৰিয়াৰ হুকুম দিয়া হ'ল </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
							<?php 
							$this->session->set_flashdata('message', 'Order Has Been Passed to the Lot Mondal For Map Partition !');
							?>
                            <a href="<?php echo base_url();?>index.php/Partition/updateChithaPartition" class="btn btn-danger" id=""><span class="ass-btn">Click Here to Update Chitha Now</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>