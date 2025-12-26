<style>
.container_zonal {
  height: 200px;
  position: relative;
  border: 1px solid black;
}

.vertical-center {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
</style>

<div class="container" role="dialog" id="searchZonalDetailsModal">
    <div class="">
        <div class="">
            <div class="bg-success mt-2">
                <h4 class="modal-title text-center" id="exampleModalLongTitle">Search Zonal Value by Dag No. </h4>
            </div>
            <div class="mt-2" align="center">
                <form id="zonalValueSearchForm">
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="recipient-name" class="col-form-label">Select Village : </label>
                            <select class="form-control" id="village_name_search" name="">
                            <option selected disabled>----------------------Select Village----------------------</option>
                                <?php foreach ($getvillageList as $village) : ?>
                                <option value="<?php echo  $village['uuid'] ?>"><?php echo  $village['loc_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="recipient-name" class="col-form-label">Dag No : </label>
                            <input class="form-control" name=""  id="dag_no_search" placeholder=" Eneter Dag No" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
                    <button type="button" class="btn btn-primary" id="searchZonalDetailsModalYes" style="float: right;">Search Zonal Details</button>
                </div>
            </div>


        <div class="row mt-2" id="searchData">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center">
                <div class="col-lg-12 col-md-12" id="zonalValueDetailsDiv">
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


<script>

    $(document).on('click', '#searchZonalValueDetails', function() {
        $('#searchZonalDetailsModal').modal('show');
    });

       $(document).on('click', '#searchZonalDetailsModalYes', function() {

        const applicant = {
            villageName: $("#village_name_search").val(),
            dagNo: $("#dag_no_search").val(),
        };

        console.log(applicant);

        $.ajax({
            url: '<?php echo base_url() . "index.php/ZoneInformationController/searchZonalValueByDag" ?>',
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                if (data.responseType == 1) {

                    var zonalDiv = '';
                   zonalDiv +=
                         '<div class ="container_zonal bg-yellow">' +
                            '<div class ="">' +
                            '<strong class="" style="font-size: 18px">' +  data.message + '</strong>' +
                            '</div>' +
                        '</div>' ;

                    $('#zonalValueDetailsDiv').html(zonalDiv);

                    showWarningMessage(data.message);
                } else if (data.responseType == 2) {
                    $('#searchProIdModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    var zonalDiv = '';
                    $.each(data.zonaldetails, function(i, val) {
                        zonalDiv +=
                         '<div class ="container_zonal">' +

                         '<p class="" style="font-size: 18px">' + 'Zonal Value Details: ' + '</p>' +
                            '<div class ="">' +
                            '<span class="" style="font-size: 20px">' + 'Zone: ' + '</span>' +
                            '<span class=" mr-2 bg-yellow" style="font-size: 20px">' +  val.zone_name + '</span>' +
                            '<span class="" style="font-size: 20px">' + 'Subclass: ' + '</span>' +
                             '<span class=" ml-2  bg-yellow" style="font-size: 20px">' +  val.subclass_name + '</span>' +
                            '</div>' +
                            '<div class ="">' +
                            '<span style="font-size: 25px; color: blue">' + 'Zonal Value : '  +'Rs. '+ val.land_rate + '</span>' +
                            '</div>' +
                        '</div>' ;
                    });
                    $('#zonalValueDetailsDiv').html(zonalDiv);
                } else if (data.responseType == 3) {
                    $('#searchProIdModal').modal('hide');
                    showErrorMessage("Data not found !");
                } else {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });

    });

    $(document).on('click', '#searchZonalDetailsModalNo', function() {
        $('#searchZonalDetailsModal').modal('hide');
        // $('#searchData').empty();
    });

</script>