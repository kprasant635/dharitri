
<div class="row login">
        
    <div class="col-lg-12">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px"> Manage Mater Land Class </h2>
            </div>
            <?php if($this->session->flashdata('message')): ?>    
                <div class="alert alert-warning">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>    
            
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Manage Mater Land Class</h3>
                </div>

                <div class="panel-body">   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4 form-group">
                                <form action="" id="changeDistForm">
                                    <label for="dist_code">Select District</label>
                                    <select name="dist_code" id="dist_code" class="form-control" onchange="document.getElementById('changeDistForm').submit();">
                                        <option value="" >Select District</option>
                                        <?php
                                            if(count((array) $district_codes)):
                                                foreach($district_codes as $district_code):
                                        ?>
                                                    <?php
                                                        if(in_array($district_code->dist_code, ['07', '08'])):
                                                    ?>
                                                            <option value="<?= $district_code->dist_code ?>" <?= $default_dist_code == $district_code->dist_code ? 'selected' : '' ?> >
                                                                    <?= $this->utilityclass->getDistrictName($district_code->dist_code); ?>
                                                            </option>
                                                    <?php
                                                        endif;
                                                    ?>
                                        <?php
                                                endforeach;
                                            endif;
                                        ?>
                                        <!-- <option value="07" <?= $default_dist_code == '07' ? 'selected' : '' ?> >Kamrup</option>
                                        <option value="08" <?= $default_dist_code == '08' ? 'selected' : '' ?> >Darrang</option> -->
                                    </select>
                                </form> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Name (Ass)</th>
                                        <th>Name (Eng)</th>
                                        <th>Group</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count((array) $land_classes) > 0): 
                                            foreach($land_classes as $key => $land_class):
                                    ?>
                                                <tr class="land_class_tr">
                                                    <input type="hidden" value="<?= $land_class->class_code ?>" class="land_class_code">
                                                    <td><?= ($key + 1); ?></td>
                                                    <td><?= $land_class->land_type; ?></td>
                                                    <td><?= $land_class->landtype_eng; ?></td>
                                                    <td>
                                                        <select name="group_id" id="" class="form-control land_group">
                                                            <option value="">-- Select Group --</option>
                                                            <?php
                                                                if(count((array) $land_class_groups) > 0):
                                                                    foreach($land_class_groups as $land_class_group):
                                                            ?>
                                                                        <option value="<?= $land_class_group->id ?>" <?= $land_class_group->id == $land_class->land_class_group_id ? 'selected' : ''; ?> ><?= $land_class_group->name; ?></option>
                                                            <?php
                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>

                                    <?php 
                                            endforeach;
                                        endif; 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                    
                </div>
            </div>
        </div>
    </div>
    
</div>


<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });


    $(document).ready(function() {
        $('.table').dataTable();

        $(document).on('change', '.land_group', function(){
            const closestTr = $(this).closest('.land_class_tr');
            const distCode = $('#dist_code').val();
            const groupId = $(this).val();
            const classCode = $('.land_class_code', closestTr).val();
            if(groupId == ''){
                Toast.fire({
                    icon: 'error',
                    title: "Please choose the group"
                });

                return false;
            }
            
            let formData = new FormData();
            formData.append('dist_code', distCode);
            formData.append('group_id', groupId);
            formData.append('class_code', classCode);

            $.ajax({
                type: 'POST',
                url: "<?= base_url('index.php/land-class-group/class-map/master-setup/save'); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.success){
                        Toast.fire({
                            title: response.message,
                            icon: 'success'
                        });

                        
                    }else{
                        Toast.fire({
                            title: response.message,
                            icon: 'error'
                        });
                        
                        setTimeout(() => {
                            location.reload(true);
                        }, 1500);
                    }
                },
                error: function(errors){
                    Toast.fire({
                        title: "Something went wrong. Please try again later",
                        icon: 'error'
                    });
                }
            });

        });
        
    });

</script>