<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 70%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<!-- Encroacher modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="close px-4" style="">&times;</span>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <h5>AVAILABLE OCCUPIERS IN DAG <strong><span id="dag_label"></span></strong></h5>
            </div>
        </div>
        <table class="table table-bordered datatable" id='datatable'>
            <thead>
            <tr>
                <th>#</th>
                <th>
                    Occupier's Name
                </th>
                <th>Father's Name</th>
                <th>
                    Occupied From
                </th>
                <th>Type of land use</th>
                <th>
                    Action
                    <button type="button" class="search_button btn btn-sm btn-success form-control">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        Search
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>