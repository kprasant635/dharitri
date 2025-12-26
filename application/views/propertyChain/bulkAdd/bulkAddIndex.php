<style>
    .nav-pills .nav-link {
        color: red!important;
    }
</style>


<!-- Nav pills -->
<div class="text-center mt-3 bg-dark mx-4 row d-flex">
    <ul class="nav nav-pills text-center mx-auto justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="pill" href="#home">Sign Assets</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#menu1" onclick="return getSignedAssets();">Signed Assets</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#menu2">Bulk Asset Push</a>
        </li>
    </ul>
</div>


<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane container active" id="home"><?php $this->load->view('propertyChain/bulkAdd/bulkAddAsset') ?></div>
    <div class="tab-pane container fade" id="menu1"><?php $this->load->view('propertyChain/bulkAdd/bulkSignedAssets') ?></div>
    <div class="tab-pane container fade" id="menu2"><?php $this->load->view('propertyChain/bulkAdd/manualPushAssets') ?></div>
    <div class="tab-pane container fade" id="menu2">...</div>
</div>

<style>
    .nav-link.active:hover {
        color: black;
    }
</style>