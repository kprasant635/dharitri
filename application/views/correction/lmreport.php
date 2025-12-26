<script>
     $(function () {
        $('#vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });
            
        });
    });
</script>
<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
           
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p><?php echo $this->lang->line('lm_report')?>(<?php echo $this->lang->line('case_no')?> -<?php echo $case_no;?>)</p>
                    </div>
                </div>
                
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter' id='cases' style="text-align: center;">
                        <tr>
                            <th class=''><?php echo $this->lang->line('lm_report')?></th>
                        </tr>
                        <tr>
                            <td>
                                 <?php echo $note->remark;?>
                             </td>
                            
                        </tr>
                    </table>
                 
               
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            Modal
        </div>
    </div>
</div>