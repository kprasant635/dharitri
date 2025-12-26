<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">
                        <?php 
                        $type_of_dag = "( Single Dag )";
                        echo "Office Mutation Transfer Type Form For ".$type_of_dag;
						//var_dump($this->session->all_userdata());
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php
                            echo $this->lang->line('mutated_land_area_for_field_mutation');
                            $mut_part = "Office Mutation";
                            echo $mut_part;
                            ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' id='submitlandareaOM' method="post" action="<?php echo base_url() . "index.php/officemutation/saveMutationDagDetails"; ?>">
                            <input type='hidden' id='mut_type' value="<?php echo $this->session->userdata('transfer_type'); ?>"/>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('dag_no') ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control dag_no" id='dag_no' name='dag_no' required>
                                        <option disabled selected><?php echo $this->lang->line('select_dag_no') ?></option>
                                        <?php foreach ($dags as $d): ?>
                                            <option><?php echo $d->dag_no; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label" style="margin-top: 30px;"><?php echo $this->lang->line('land_description') ?> </label>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('bigha') ?></span>
                                    <input type="number"  class="form-control" value="0" readonly="" id='b' name='dag_area_b' placeholder="বিঘা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('katha') ?></span>
                                    <input type="number"  class="form-control" value="0"  readonly="" id='katha' name='dag_area_k' placeholder="কঠা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('lessa') ?></span>
                                    <input type="number"  class="form-control"  readonly="" id='l' name='dag_area_lc' placeholder="লেছা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('ganda') ?></span>
                                    <input type="number"  class="form-control"  id='g' name='dag_area_g' placeholder="গন্ডা" value="0">
                                </div>
                                <!--<div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('krantik') ?></span>
                                    <input type="number" class="form-control"  id='k' name='dag_area_kr' placeholder="ক্ৰান্তি" value="0">
                                </div>-->
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 required  uni_text control-label" style="margin-top: 30px;"><?php
                                    echo "Land Area For Mutation";
                                    ?></label>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('bigha') ?></span>
                                    <input type="number" maxlength="6" class="form-control" value="<?php echo $b; ?>"
                                           id='mb' name='m_dag_area_b' placeholder="বিঘা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('katha') ?></span>
                                    <input type="number" maxlength="2" class="form-control" value="<?php echo $k; ?>"
                                           name='m_dag_area_k' id='mutatedk'  placeholder="কঠা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('lessa') ?></span>
                                    <input type="number" maxlength="7" class="form-control" value="<?php echo $lc; ?>"
                                           name='m_dag_area_lc' id='lm' placeholder="লেছা">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('ganda') ?></span>
                                    <input type="number" maxlength="2" class="form-control" name='m_dag_area_g' id='mg' placeholder="গন্ডা" value="0">
                                </div>
                                <!--<div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('krantik') ?></span>
                                    <input type="number" maxlength="2" class="form-control"  name='m_dag_area_kr' id='mk' placeholder="ক্ৰান্তি" value="0">
                                </div>-->
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label" style="margin-top: 30px;"><?php echo $this->lang->line('land_area_left') ?></label>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('bigha') ?></span>
                                    <input type="number" class="form-control" readonly="" id="rb" placeholder="বিঘা" value="0">
                                </div>

                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('katha') ?></span>
                                    <input type="number" class="form-control" readonly="" id="rkatha" placeholder="কঠা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('lessa') ?></span>
                                    <input type="number" class="form-control" readonly="" id="rl" placeholder="লেছা" value="0">
                                </div>
                                <div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('ganda') ?></span>
                                    <input type="number" class="form-control" readonly="" id="rg" placeholder="গন্ডা" value="0">
                                </div>
                                <!--<div class="col-sm-2  uni_text">
                                    <span class="center small"><?php echo $this->lang->line('krantik') ?></span>
                                    <input type="number" class="form-control" readonly="" id="rk" placeholder="ক্ৰান্তি" value="0">
                                </div>-->
                            </div>
                            <?php if ($type == '02'): ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('land_revenue') ?></label>
                                    <div class="col-sm-8">
                                        <input type="number" required maxlength="19" class="form-control" name='min_revenue' id="applicantNam" placeholder="ৰাজহ" value="0">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($type == '01'): ?>
                                <div class="form-group" style="display: none">
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('revenue') ?></label>
                                    <div class="col-sm-8">
                                        <input type="number" required maxlength="19" class="form-control" name='min_revenue' id="applicantNam" value="1" placeholder="ৰাজহ" value="0">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group" style="display: none">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('land_valuation') ?></label>
                                <div class="col-sm-8">
                                    <input type="number" maxlength="11" class="form-control" name='land_valuation' id="applicantNam" placeholder="ৰাজহ" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 required  uni_text control-label"><?php echo $this->lang->line('remark') ?></label>
                                <div class="col-sm-8">
                                    <textarea  type="text" id="lmdatefield00"  class="form-control editor1" required  name='remark' rows="5"  placeholder="মন্তৱ্য"></textarea>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-3">
                                    <button type="submit" id='' class=" btn btn-success"><i class='fa fa-save'></i>&nbsp;Save Land Area</button>
                                    <a href="<?php echo base_url() . "index.php/officemutation/pattadarDetails"; ?>" class="btn btn-primary">
                                        <i class="fa fa-arrow-check"></i>&nbsp;Proceed To Next Stage sa
                                    </a>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('form#submitlandareaOM').submit(function (e) {
        e.preventDefault();
        if ((parseInt($('input[name="min_revenue"]').val()) === 0) || isNaN($('input[name="min_revenue"]').val())) {
            alert("Revenue Cannot be Zero.");
            return;
        }
        var b = $('dag_area_b').val();
        var k = $('dag_area_k').val();
        var lc = $('dag_area_lc').val();




        var bm = $('#mb').val();
        var km = $('#mutatedk').val();
        var lcm = $('#lm').val();

        var target = parseInt(bm) * 100 + parseInt(km) * 20 + parseFloat(lcm);
        var mut = $('#mut_type').val();
        if ((target === 0) && (mut!=='01') && (mut!=='11')) {
            alert("Error in entering mutation land area");
            return false;
        }

        $.ajax({
            url: baseurl + "officemutation/saveMutationDagDetails",
            data: $('form#submitlandareaOM').serialize(),
            method: 'post',
            success: function (d) {
                $.ajax({
                    url: baseurl + "officemutation/getDagsByPattaNoPattaTypeJSON/",
                    success: function (data) {
                        var obj = JSON.parse(data);
                        var template = "<option>Select Dag</option>";
                        console.log(obj);
                        for (var i = 0; i < obj.length; i++) {
                            template += "<option value='" + obj[i].dag_no + "'>" + obj[i].dag_no + "</option>";
                        }
                        console.log(template);
                        $('#dag_no').html(template);
                        alert("Data Successfully Saved !!");
                        $('form#submitlandareaOM').find("input[type=text], textarea").val("0");
                        $('.next').removeAttr('disabled');
                        
                    }
                });
                var response = JSON.parse(d);
                console.log(response);
                if(response === false){
                    window.location = baseurl + "officemutation/pattadarDetails"
                }
            }
        });
    });  
</script>



