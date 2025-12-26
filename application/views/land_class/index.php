<style>
    .more-content {
        display: none; /* Hidden part of the content */
    }
    .read-more-btn {
        cursor: pointer;
        color: #9300ff;
        /* text-decoration: underline; */
    }
    .read-less-btn {
        cursor: pointer;
        color: #E40675;
        /* text-decoration: underline; */
        display: none;
    }
</style>

<div class="row login">
        
    <div class="col-lg-12">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px"> Land Classes </h2>
            </div>
            <?php if($this->session->flashdata('message')): ?>    
                <div class="alert alert-warning">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>    
            
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"> Land Classes</h3>
                </div>

                <div class="panel-body">   
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Name (Ass)</th>
                                        <th>Name (Eng)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count((array) $land_classes) > 0): 
                                            foreach($land_classes as $key => $land_class):
                                    ?>
                                                <tr class="land_class_tr">
                                                    <td><?= ($key + 1); ?></td>
                                                    <td><?= $land_class->land_type; ?></td>
                                                    <td><?= $land_class->landtype_eng; ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="text-danger deleteLandClass" data-code="<?= $land_class->class_code ?>" data-toggle="modal" data-target="#deleteLandClassModal"><i class="fa fa-trash"></i></a>
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

<!-- Modal -->
<div class="modal fade" id="deleteLandClassModal" tabindex="-1" role="dialog" aria-labelledby="deleteLandClassModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteLandClassModalLabel">Are you sure? You want to delete!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="landClassForm" action="<?= base_url('index.php/land-class-delete') ?>" method="POST">
                <div class="form-group">
                    <input type="hidden" id="deleteable_landclass" name="landclass">
                    <label for="" class="form-label">Enter <span class="text-danger"><?= $land_cls_manage_security_code; ?></span> in order to delete</label>
                    <input class="form-control" type="text" placeholder="Enter the above code" required name="code">
                </div>
                <div class="form-group confirmation_block">
                    
                </div>
                <button type="submit" class="btn btn-success submit_btn">Submit</button>
            </form>
            <div class="error_data_section"></div>
            
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
        $('.table').dataTable({
            pageLength: 25
        });

        $(document).on('click', '.deleteLandClass', function(){
            const landclass = $(this).data('code');
            $('#deleteable_landclass').val(landclass);
            
        });

        $('#deleteLandClassModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('.confirmation_block, .error_data_section').html('');
        });

        $('#landClassForm').on('submit', function(e){
            e.preventDefault();
            $('.error_data_section').html('');
            $('.submit_btn').attr('disabled', true);
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.success){
                        Toast.fire({
                            title: response.message,
                            icon: 'success'
                        });
                        
                        setTimeout(() => {
                            location.reload(true);
                        }, 1500);
                    }else{
                        Toast.fire({
                            title: response.message,
                            icon: 'error'
                        });
                        
                        let errorData = response.data;
                        $('.submit_btn').attr('disabled', false);
                        if(errorData.length > 0){
                            let html = `<h3>Land class is present in the below dags</h3>
                                        <table class="table error_data_table">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Village Name (ASSAMESE)</th>
                                                    <th>Village Name (ENGLISH)</th>
                                                    <th>Dag No(s)</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
                            
                            $.each(errorData, function(index, error_ins){
                                const fullDags = error_ins.dag_no;
                                const numberArray = fullDags.split(', ');
                                const visibleCount = 10;
                                const visiblePart = numberArray.slice(0, visibleCount).join(', ');
                                const hiddenPart = numberArray.slice(visibleCount).join(', ');

                                html += `<tr>
                                            <td>${index + 1}</td>
                                            <td>${error_ins.village}</td>
                                            <td>${error_ins.village_eng}</td>
                                            <td>
                                                <span class="visiblePart">${visiblePart + (hiddenPart ? ', ' : '')}</span>
                                                ${hiddenPart ? `<span class="more-content hiddenPart">${hiddenPart}</span>
                                                                <span class="read-more-btn readMoreBtn"> ... [Read More]</span>
                                                                <span class="read-less-btn readLessBtn">[Read Less]</span>` 
                                                            : ``}

                                            </td>
                                        </tr>`;
                            });

                            html += `</tbody></table>`;

                            $('.error_data_section').html(html);
                            $('.confirmation_block').html('');

                            $('.error_data_table').dataTable({
                                                                pageLength: 25
                                                            });
                        }else if(response.need_another_confirmation){
                            let html = `<label for="isConfirmed" class="form-label text-warning">${response.confirmation_message}</label>
                                        <input type="checkbox" id="isConfirmed" name="is_confirmed">`;
                            $('.confirmation_block').html(html);
                        }
                    }
                },
                error: function(errors){
                    Toast.fire({
                        title: "Something went wrong. Please try again later",
                        icon: 'error'
                    });

                    $('.submit_btn').attr('disabled', false);
                }
            });

        });
        
    });

    $(document).on('click', '.readMoreBtn', function(){
        const closest = $(this).closest('td');
        $('.hiddenPart', closest).show();
        $('.readMoreBtn', closest).hide();
        $('.readLessBtn', closest).show();
    });

    $(document).on('click', '.readLessBtn', function(){
        const closest = $(this).closest('td');
        $('.hiddenPart', closest).hide();
        $('.readMoreBtn', closest).show();
        $('.readLessBtn', closest).hide();
    });

</script>