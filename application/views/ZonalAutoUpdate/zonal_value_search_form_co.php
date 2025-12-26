
<div class="modal" role="dialog" id="searchZonalDetailsModal">
    <div class="modal-dialog" style="max-width: 50%;" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-center" id="exampleModalLongTitle">Search Zonal Value by Dag No. </h5>
            </div>
            <div class="modal-body" align="center">
                <form id="zonalValueSearchForm">
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="recipient-name" class="col-form-label">Dag No : </label>
                            <input class="form-control" name=""  id="dag_no_search" placeholder=" Eneter Dag No" />
                        </div>
                    </div>

                    <div class="row" id="searchData">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center">
                            <!-- <hr> -->
                            <div class="col-lg-12 col-md-12" id="zonalValueDetailsDiv">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="searchZonalDetailsModalNo">Close</button>
                <button type="button" class="btn btn-primary" id="searchZonalDetailsModalYes">Search</button>
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

        $.ajax({
            url: '<?php echo base_url() . "index.php/ZoneInformationController/searchZonalValueByDag" ?>',
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                if (data.responseType == 1) {

                    var zonalDiv = '';
                   zonalDiv +=
                         '<div class ="container bg-yellow">' +
                            '<div class ="">' +
                            '<strong class="" style="font-size: 20px">' +  data.message + '</strong>' +
                            '</div>' +
                        '</div>' ;

                    $('#zonalValueDetailsDiv').html(zonalDiv);

                    showWarningMessage(data.message);
                } else if (data.responseType == 2) {
                    $('#searchProIdModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    var villagename = data.villagename;
                    // var editReapproveBtn =  '<a target="_blank"  href="getVillagewisePendingZonalInformation" class="approve-list-co">Edit and Reapprove</a> ';
                    var zonalDiv = '';
                    $.each(data.zonaldetails, function(i, val) {
                    var landRate = val.land_rate;
                    if($.isEmptyObject(landRate) || landRate ==null || landRate ==''){
                     zonalDiv +=
                         '<div class ="container">' +
                            '<div class ="">' +
                            '<span class=" mr-2 bg-yellow" style="font-size: 20px">' + 'Zone: ' +  val.zone_name + '</span>' +
                             '<span class=" ml-2  bg-yellow" style="font-size: 20px">' + 'Subclass: ' +  val.subclass_name + '</span>' +
                            '</div>' +
                            '<div class ="">' +
                            '<span style="font-size: 20px; color: blue">' + 'Zonal Value entered Blank by LM '+'</span><br>' +
                            '<span style="font-size: 18px; color: red">' + '(*** Enter Zonal Value for ' + '<b>'+  val.zone_name +'</b>' + ' and ' +'<b>' +  val.subclass_name + '</b>' +  ' combination for ' +villagename+ ' at CO End by go to edit and Reapprove option)'+'</span>' +
                            '</div>' +
                        '</div>' ;
                        }else{
                        zonalDiv +=
                            '<div class ="container">' +
                                '<div class ="">' +
                                '<span class=" mr-2 bg-yellow" style="font-size: 20px">' + 'Zone: ' +  val.zone_name + '</span>' +
                                '<span class=" ml-2  bg-yellow" style="font-size: 20px">' + 'Subclass: ' +  val.subclass_name + '</span>' +
                                '</div>' +
                                '<div class ="">' +
                                '<span style="font-size: 25px; color: blue">' + 'Zonal Value : '  +'Rs. '+ landRate + '</span>' +
                                '</div>' +
                            '</div>' ;
                        }                    
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