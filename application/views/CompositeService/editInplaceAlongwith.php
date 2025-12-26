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


<div id="editInplaceAlongDetails" class="modal">
<div class="modal-dialog modal-dialog-centered">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-add-applicant px-4">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>Change Inplace/Along with information</h5>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>Selected status</th>
                <td>
                    <input type="text" placeholder="Enter name in assamese" id="inplacealong" class="form-control" readonly>
                </td>
            </tr>
            <tr>
                <th>Select Inplace/Alongwith</th>
                <td>
                <select class="form-control inplace" name="striked_out" id="striked_out" required>
                <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith') ?></option>
                <option value="1"><?php echo $this->lang->line('inplace') ?></option>
                <option value="0"><?php echo $this->lang->line('alongwith') ?></option>
              </select> 
            </td>
                <input type="hidden" name="" id="dag_no_prop">
                <input type="hidden" name="" id="pdar_id">
            </tr>
        </table>

       <br><br><br>
        
        <div class="row justify-content-center">
            <button type="button" onclick="editInplaceAlongwithData();" class="btn btn-sm btn-danger col-3">UPDATE</button>
        </div>
    </p>
  </div>
</div>
</div>
