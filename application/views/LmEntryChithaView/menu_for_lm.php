<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">

            <table  id="example" class="table table-hover panel-body" style="margin:auto; ">
                <thead align="center" >
                    <tr align="center" >
                        <th class="alert-info" style="text-align: center">Select options</th>
                        <th class="alert-info" style="text-align: center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>
                            Basic Details:
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/LmEntryChitha/getPattano' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u></a>
<!--                            <button type="submit" class="btn btn-success" id="basicinfo" name="basicdetails"><i class='fa fa-home'></i>Edit</button>-->
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            Crop Details:
                        </td>
                        <td>
                            <?php
                            if ($rowMcrop != "") {
                                ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addcrop' ?>"><i class='fa fa-check'></i><u> Add</u> </a>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/cropname' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u></a>
                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addcrop' ?>"> <i class='fa fa-check'></i><u> Add</u></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            Non Crop Details:
                        </td>
                        <td>
                            <?php
                            if ($rownoncrop != 0) {
                                ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addnonagri' ?>"><i class='fa fa-check'></i><u> Add</u> </a>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/nextNonAgri' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u> </a>
    <!--                             <button type="submit" class="btn btn-success" id="addnoncrop" name=""><i class='fa fa-home'></i>Add</button>
                                <button type="submit" class="btn btn-success" id="noncrop" name=""><i class='fa fa-home'></i>Edit</button>-->

                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addnonagri' ?>"><i class='fa fa-check'></i><u> Add</u> </a>
    <!--              <button type="submit" class="btn btn-success" id="addnoncrop" name=""><i class='fa fa-home'></i>Add</button>                -->
                            <?php } ?>

                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            Fruit Details:
                        </td>
                        <td>
                            <?php
                            if ($rowfruit != 0) {
                                ?>

                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addfruit' ?>"><i class='fa fa-check'></i><u> Add</u></a>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/nextfruitplantselect' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u></a>
    <!--                           <button type="submit" class="btn btn-success" id="addfruit" name=""><i class='fa fa-home'></i>Add</button>
                               <button type="submit" class="btn btn-success" id="fruit" name=""><i class='fa fa-home'></i>Edit</button>-->


                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addfruit' ?>"><i class='fa fa-check'></i><u> Add</u></a>
    <!--                                       <button type="submit" class="btn btn-success" id="addfruit" name=""><i class='fa fa-home'></i>Add</button>-->

                            <?php } ?>

                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            Archaeological Details:
                        </td>
                        <td>
                            <?php
                            if ($rowacho != 0) {
                                ?>

                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addarcheo' ?>"><i class='fa fa-check'></i><u> Add</u></a>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/nextarcheoname' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u></a>
    <!--                              <button type="submit" class="btn btn-success" id="addarchaeo" name=""><i class='fa fa-home'></i>Add</button>
                                  <button type="submit" class="btn btn-success" id="archaeo" name=""><i class='fa fa-home'></i>Edit</button>-->
                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addarcheo' ?>"><i class='fa fa-check'></i><u> Add</u></a>
    <!--                         <button type="submit" class="btn btn-success" id="addarchaeo" name=""><i class='fa fa-home'></i>Add</button>-->
                            <?php } ?>

                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            Lot Mondol Note:
                        </td>
                        <td>
                            <?php
                            if ($rowlmnote != 0) {
                                ?> 

                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addAlmnote' ?>"><i class='fa fa-check'></i><u> Add</u></a>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/LMnote' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u></a>

                    <!--                            <button type="submit" class="btn btn-success" id="lotmondal" name=""><i class='fa fa-home'></i>Edit</button>  
                     <button type="submit" class="btn btn-success" id="addlotmondal" name=""><i class='fa fa-home'></i>Add</button>-->

                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addAlmnote' ?>"><i class='fa fa-check'></i><u> Add</u></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if(( $this->session->userdata('pattatype_code') =='0209')||($this->session->userdata('pattatype_code') =='0212')||($this->session->userdata('pattatype_code') =='0213')||($this->session->userdata('pattatype_code') =='0214')||($this->session->userdata('pattatype_code') =='0218')||($this->session->userdata('pattatype_code') =='0219')){?>  
                    <tr align="center">
                        <td>
                            Encroacher Details:
                        </td>
                        <td>
  <?php //if(( $this->session->userdata('pattatype_code') =='0209')||($this->session->userdata('pattatype_code') =='0212')||($this->session->userdata('pattatype_code') =='0213')||($this->session->userdata('pattatype_code') =='0214')||($this->session->userdata('pattatype_code') =='0218')||($this->session->userdata('pattatype_code') =='0219')){?>  
                            <?php
                            
                            if ($rowencro != 0) {
                                ?> 

                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addEncro' ?>"><i class='fa fa-check'></i><u> Add</u></a>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/Encrocherdetails' ?>"><i class='fa fa-pencil fa-fw'></i><u> Edit</u></a>

                    <!--                            <button type="submit"  class="btn btn-success" id="enchro" name=""><i class='fa fa-home'></i>Edit</button>
                     <button type="submit"  class="btn btn-success" id="addenchro" name=""><i class='fa fa-home'></i>Add</button>-->
                            <?php } else { ?>
                                <a href="<?php echo base_url() . 'index.php/LmEntryChitha/addEncro' ?>"><i class='fa fa-check'></i><u> Add</u></a>
                            <?php }
  //}
                            ?>


                        </td>
                    </tr>
<?php }
                            ?>
                </tbody>
            </table>
            <center>
                <button type="submit"  id="exit" class="btn btn-md btn-danger"><i class='fa fa-arrow-left'></i>&nbsp;<?php echo $this->lang->line('back') ?></button>
            </center>
            <br>
        </div>
    </div>
</div>
<script type="text/javascript">

    document.getElementById("exit").onclick = function () {
        javascript:history.back();
    };
    document.getElementById("basicinfo").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/getPattano' ?>";
    };
    document.getElementById("addcrop").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addcrop' ?>";
    };

    document.getElementById("cropinfo").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/cropname' ?>";
    };
    document.getElementById("noncrop").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/nextNonAgri' ?>";
    };

    document.getElementById("addnoncrop").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addnonagri' ?>";
    };
    document.getElementById("fruit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/nextfruitplantselect' ?>";
    };

    document.getElementById("addfruit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addfruit' ?>";
    };
    document.getElementById("archaeo").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/nextarcheoname' ?>";
    };
    document.getElementById("addarchaeo").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addarcheo' ?>";
    };
    document.getElementById("lotmondal").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/LMnote' ?>";
    };

    document.getElementById("addlotmondal").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addAlmnote' ?>";
    };
    document.getElementById("enchro").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/Encrocherdetails' ?>";
    };
    document.getElementById("addenchro").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addEncro' ?>";
    };
</script>