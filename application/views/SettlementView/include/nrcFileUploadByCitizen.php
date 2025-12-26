<?php if(isset($rejected_cat) && $rejected_cat > 0 && isset($getFromBasicNotD) && $getFromBasicNotD > 0) { ?>

<!-- file uploaded by citizen -->

<?php if(NRC_FILE_UPLOAD_ENABLED==1 && isset($citizen_nrc_doc) && $citizen_nrc_doc->docs_avail!=0){ ?>

    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-file-pdf-o"></i> Inconvertible Hereditary Linkage With 1951 NRC Data
    </h5>

    <div class="tableCard">
        <table class="table table-bordered">
            <tr>
                <th>Relation</th>
                <th>Document Holder Name : </th>
                <th>File Name : </th>
                <th>Identity</th>
                <th>Status</th>
            </tr>
            <?php 
                foreach ($citizen_nrc_doc->master_array as $k=>$v) 
                { 
                    $type = 'VOTER CARD';
                    $relation = 'APPLICANT';
                    if($v->rel_identity == 'A'){
                        $type = 'AADHAAR CARD';
                    }
                    else if($v->rel_identity == 'P'){
                        $type = 'PAN CARD';
                    }

                    if($v->relation == 4){
                        $relation = 'Great Great Grand Parent';
                    }
                    else if($v->relation == 3){
                        $relation = 'Great Grand Parent';
                    }
                    else if($v->relation == 2){
                        $relation = 'Grand Parent';
                    }
                    $title = '';
                    if($v->parentName != 'Owner')
                    {
                        $title = " [ Son/Daughter of (".$v->parentName.") ]";
                    }
            ?>
                <tr>
                    <td><?=$relation;?></td>
                    <td><?=$v->doc_holder_name . $title;?></td>
                    <td><?=$v->file_details;?></td>
                    <td><?=$type;?></td>
                    <td><a target='download' href="<?=$v->path?>"><i class="fa fa-paperclip"></i> <?=$v->name;?></a> </td>          
                </tr>  
            <?php } // end of foreach ?>
        </table>
    </div>

<?php } // end of if ?>
<?php } // end of rejected category ?>


