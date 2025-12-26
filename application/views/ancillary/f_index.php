<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }

    .reza-card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
    }

    .reza-title {
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }

    .reza-body {
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }

    .badge {
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }

    .rezaButt:hover {
        color: #0c0c0c;
    }

    .rezaButt {
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }

    .rezaText {
        font-size: 16px;
    }

    .table>thead>tr>th {
        line-height: 2;

    }

    .table>tbody>tr>td {
        line-height: 2;

    }
</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span>Ancillary Applications</span>
                <hr>

                <div class="row">
                    <div class="col-12 text-center">
                        <span class="alert-success">
                            <?php echo $this->session->flashdata('message'); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Process Name</th>
                            <th>Total No. Case</th>
                            <th style="width: 200px; text-align:center!important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menuItems as $item): ?>
                            <tr>
                                <td class="rezaText"><?php echo $item['sl_no']; ?>.</td>

                                <td class="rezaText"><?php echo $item['label']; ?></td>

                                <td>
                                    <?php if ($item['count'] > 0): ?>
                                        <span class="badge badge-danger"><?php echo $item['count']; ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-success">0</span>
                                    <?php endif; ?>
                                </td>

                                <td style="width:200px; text-align:right;">
                                    <?php
                                    $url = 'index.php/AncillaryController/index';

                                    $params = [];
                                    if (!empty($item['step'])) $params['step'] = $item['step'];
                                    if (!empty($item['status'])) $params['status'] = $item['status'];
                                    if (!empty($item['rereport'])) $params['rereport'] = 1;

                                    $query = !empty($params) ? '?' . http_build_query($params) : '';
                                    ?>
                                    <a class="rezaButt" href="<?php echo base_url($url . $query); ?>">
                                        <i class="fa fa-eye"></i>&nbsp;View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>