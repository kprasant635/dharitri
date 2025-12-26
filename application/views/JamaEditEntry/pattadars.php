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
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Jamabandi Pattadar Edit / view Module </h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Update Utility
                        </h3>
                    </div>
                    <div class="panel-body">
                        <!--<h2 class="red">Update Revenue & Local Tax of Particular Village Dag</h2>-->
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $location['dist']; ?></td>
                                <td colspan="2">Subdivision : <?php echo $location['sub']; ?></td>
                                <td colspan="2">Circle : <?php echo $location['cir']; ?></td>
                                <td colspan="2">Mouza Pargona : <?php echo $location['mouza']; ?></td>
                            </tr>
                            <tr class="hope">
                                <td colspan="2">Lot : <?php echo $location['lot']; ?></td>
                                <td colspan="2">Town / Village : <?php echo $location['vill']; ?></td>
                                <td colspan="2">Patta No : <?php echo $location['patta_no']; ?></td>
                                <td colspan="2">Patta Type : <?php echo $this->utilityclass->getPattaName($location['patta_type_code']); ?></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="col-lg-12 pull-right">
                            <a href="<?php echo base_url(); ?>index.php/jamaeditentry/transferpattadars" class="btn btn-primary"><i class='fa fa-edit'></i> Transfer Pattadar's</a>
                            <a href="<?php echo base_url(); ?>index.php/jamaeditentry/pdaradd" class="btn btn-success"><i class='fa fa-edit'></i> Add New Pattadar</a>
                            <a href="<?php echo base_url(); ?>index.php/jamaeditentry/modifypdarbothways" class="btn btn-primary"><i class='fa fa-edit'></i> Modification Pattadar Name</a>
                            <a href="<?php echo base_url(); ?>index.php/jamaeditentry/deopdarremove" class="btn hide btn-warning"><i class='fa fa-edit'></i> Remove Pattadar</a>
                            <a href="<?php echo base_url(); ?>index.php/jamaeditentry/deopdarstrikebothways" class="btn btn-active"><i class='fa fa-edit'></i> Strike Pattadar</a>
                            <a href="<?php echo base_url(); ?>index.php/jamaeditentry/deopdarustrikebothways" class="btn btn-info"><i class='fa fa-edit'></i> Unstrike Pattadar</a>
                            <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/jamaeditentry/displaybasic/<?php echo $this->session->userdata('patta_no'); ?>/<?php echo $this->session->userdata('patta_type_code'); ?>"><i class='fa fa-arrow-left'></i> Back To Home</a>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2 class="red">Jamabandi't thoka Pattadar Name : </h2>
                        <div class="col-sm-12">
                            <form id="form" method="post">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>ID</th>
                                        <th>Pattadar Name</th>
                                        <th>Pattadar Guardian Name</th>
                                        <th class='hide'>SL NO</th>
                                        <th class="center hide">STRIKED OUT</th>
                                        <th class="center hide">DELETE</th>
                                    </tr>
                                    <?php foreach ($pattadars as $p): ?>
                                        <?php
                                        if ($p->p_flag == 1) {
                                            $class = 'danger';
                                            $style = 'Color:#ff0000;text-decoration: line-through';
                                        } else {
                                            $class = '';
                                            $style = '';
                                        }
                                        ?>
                                        <tr class="<?php echo $class; ?>">
                                            <td class="id">
                                                <?php echo $p->pdar_id; ?>
        <!--                                        <input style="width:50px;" readonly class='small' type="hidden" name="pattadar[<?php echo $p->pdar_id; ?>][pdar_id]" value="<?php echo trim($p->pdar_id); ?>"/>
                                                <input style="width:50px;" readonly class='small' type="text" name="pattadar[<?php echo $p->pdar_id; ?>][new_pdar_id]" value="<?php echo trim($p->pdar_id); ?>"/>-->
                                            </td>
                                            <td> 
                                                <span style="<?php echo $style; ?>"><?php echo $p->pdar_name; ?></span>
        <!--                                        <input type="text" readonly name="pattadar[<?php echo $p->pdar_id; ?>][pdar_name]" value="<?php echo $p->pdar_name; ?>"/>-->
                                            </td>
                                            <td> 
                                                <span style="<?php echo $style; ?>"><?php echo $p->pdar_father; ?></span>
        <!--                                        <input type="text" readonly name="pattadar[<?php echo $p->pdar_id; ?>][pdar_father]" value="<?php echo $p->pdar_father; ?>"/>-->
                                            </td>
                                            <td class='hide'> <input type="text" class='small hide disable' readonly style="width:50px;" name="pattadar[<?php echo $p->pdar_id; ?>][pdar_sl_no]" value="<?php echo $p->pdar_sl_no; ?>"/></td>    
                                            <td class="center hide">
                                                <?php
                                                if ($p->p_flag == 1) {
                                                    ?>
                                                    <label class="checkbox-inline"><input type="radio" checked name="pattadar[<?php echo $p->pdar_id; ?>][strike]" value="1">Yes</label>
                                                    <label class="checkbox-inline"><input type="radio" name="pattadar[<?php echo $p->pdar_id; ?>][strike]" value="0">No</label>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <label class="checkbox-inline"><input type="radio" name="pattadar[<?php echo $p->pdar_id; ?>][strike]" value="1">Yes</label>
                                                    <label class="checkbox-inline"><input type="radio"checked name="pattadar[<?php echo $p->pdar_id; ?>][strike]" value="0">No</label>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td class=" hide center">
                                                <label class="checkbox-inline"><input type="radio"  name="pattadar[<?php echo $p->pdar_id; ?>][delete]" value="1">Yes</label>
                                                <label class="checkbox-inline"><input type="radio" checked name="pattadar[<?php echo $p->pdar_id; ?>][delete]" value="0">No</label>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <div class="" style="text-align: center">
                                    <input type='Submit' value="Save" class="btn hide btn-danger btn-lg"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("form").submit(function (e) {
        e.preventDefault();
        var arr = [];
        $('input:checked[name="checkbox"]').each(function () {
            arr.push($(this).val());
        });
        var myData = arr.join(',');
        console.log(myData);
        alert(myData);
        $.ajax({
            'url': '<?php echo base_url(); ?>index.php/jamaeditentry/pattadarlist',
            'type': 'POST',
            'data': {options: myData},
        });
        e.preventDefault();
        return false;
    });

</script>

