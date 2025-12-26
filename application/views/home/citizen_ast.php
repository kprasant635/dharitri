 <div class="col-lg-6 col-lg-offset-2">
 <div class="panel casedisplay">
        <div class="panel-heading">
            <div class="panel-title">
                <p class="regular"><?php echo $this->lang->line('asstt_citizen_centric') ?> </p>
            </div>

        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <tr>
                    <td>Register New Application
                        <p class="text-info hide small">(Register a new Application for Citizen Centric Certificate and issue Money Receipt)</p>
                    </td>
                    <td> </td>
                    <td> <a href="<?php echo base_url() . 'index.php/CitizenController/RegisterApplicant'; ?>" class="pull-right text-danger"><?php echo $this->lang->line('go') ?></a></td>
                </tr>

                <tr>
                    <td>Print Certificate for CO's Signature
                        <p class="text-info hide small">(Take Printouts of Certificate already issued by CO , and get them signed by the CO)</p>
                    </td>
                    <td>
                        <?php
                        if ($citizenpending != '0') {
                            echo "<span class=\"badge badge-primary\">$citizenpending</span>";
                        }
                        ?>
                    </td>
                    <td>  <a href="<?php echo base_url() . 'index.php/CitizenController/SecondAssttStep1'; ?>"  class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
                </tr>

                <tr>
                    <td>Re-generate Jamabandi Copy <sup class='red'>New</sup></td>
                        
                    <td> </td>
                    <td> <a href="<?php echo base_url() . 'index.php/serviceplus/regenratejbCopy'; ?>" class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
                    </td>
                </tr>
                <tr>
                    <td>RTPS application - Print and Upload</td>
                    <td>
                        <?php
                        if ($printR != '0') {
                            echo "<span class=\"badge badge-primary\">$printR</span>";
                        }
                        ?>
                    </td>
                    <td> <a href="<?php echo base_url() . 'index.php/serviceplus/tot_file'; ?>" class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
                    </td>
                </tr>
                <tr>
                    <td>Check Certificate Status
                        <p class="text-info hide small">(Check the Status of Certificate - e.g. Pending, Delivered etc)</p>
                    <td> </td>
                    <td> <a href="<?php echo base_url() . 'index.php/CitizenController/CheckStatus'; ?>" class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
                    </td>
                </tr>
				<tr>
                    <td>Register New Application from Online Services (OS)</td>
					<td>
						<?php
                        if ($CountOsOnline != '0') {
                            echo "<span class=\"badge badge-primary\">$CountOsOnline</span>";
                        }
                        ?>
					</td>
                    <td> <a href="<?php echo base_url() . 'index.php/serviceplus/os_cases'; ?>" class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
                    </td>
                </tr>
				<tr>
                    <td>Register New Application from Online Services (ROR)</td>
					<td>
						<?php
                        if ($CountJamaNakalOnline != '0') {
                            echo "<span class=\"badge badge-primary\">$CountJamaNakalOnline</span>";
                        }
                        ?>
					</td>
                    <td> <a href="<?php echo base_url() . 'index.php/serviceplus/ror_cases'; ?>" class="pull-right green"><?php echo $this->lang->line('view') ?></a></td>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>