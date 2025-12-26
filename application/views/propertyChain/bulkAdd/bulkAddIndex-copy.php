<!-- Nav pills -->
<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#home">Sign Assets</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#menu1" onclick="return getSignedAssets();">Signed Assets</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#menu2"></a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane container active" id="home"><?php $this->load->view('propertyChain/bulkAdd/bulkAddAsset') ?></div>
    <div class="tab-pane container fade" id="menu1"><?php $this->load->view('propertyChain/bulkAdd/bulkSignedAssets') ?></div>
    <div class="tab-pane container fade" id="menu2">...</div>
</div>

<style>
    .nav-link.active:hover {
        color: black;
    }
</style>