<style>
    /* The Close Button */
    .close-add-applicant {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-add-applicant:hover,
    .close-add-applicant:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    
    .modal-content {
        border: 2px solid #dee2e6; /* light grey border */
        background-color: #f9f9f9; /* mild background color */
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>


<div id="editPropClassDetails" class="modal">
<div class="modal-dialog modal-dialog-centered">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-add-applicant px-4">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>Add Proposed Details</h5>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>Applied Proposed Class</th>
                <td>
                    <input type="text" placeholder="Enter name in assamese" id="proc_lc_name_applicant" class="form-control" readonly>
                </td>
            </tr>
            <tr>
                <th>Proposed Class</th>
                <td>
                <select id="proc_lc_name_office" class="form-control">
                <option value="">-- Select Proposed Class --</option>
                </select>
            </td>
                <input type="hidden" name="" id="dag_no_prop">
            </tr>
        </table>

        <div class="row">
            <div class="" id="uploadDocument">
              <label class="form-label"><span style="color:red">Upload No Objection Document from Applicant *</span></label>
              <input type="file" class="form-control" name="nocDocument" id="nocDocument" accept="application/pdf,image/*">
            </div>
        </div><br><br><br>
        
        <div class="row justify-content-center">
            <button type="button" onclick="editPropClassData();" class="btn btn-sm btn-danger col-3">UPDATE</button>
        </div>
    </p>
  </div>
</div>
</div>
