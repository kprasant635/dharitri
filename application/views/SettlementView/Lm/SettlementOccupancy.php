<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Schedule of the land and area under
      occupation</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="inlineRadioOptions"
        id="inlineRadio1"
        value="option1"
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="inlineRadioOptions"
        id="inlineRadio2"
        value="option2"
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Total area of the land under that
      Dag</label
    >
  </div>
  <div class="form-group col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">Total Bigha</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="text"
          name="total_bigha"
          id="total_bigha"
          value="445"
          disabled
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Katha</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_Katha"
          class="form-control"
          id="total_katha"
          value="33"
          disabled
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Lessa</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_lessa"
          class="form-control"
          id="total_lessa"
          value="12"
          disabled
        />
      </div>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Possession of the land out of the
      total area present in that Dag, found during field visit</label
    >
  </div>
  <div class="form-group col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">Total Bigha</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="text"
          name="total_bigha"
          id="total_bigha"
          placeholder="Enter Bigha"
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Katha</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_Katha"
          class="form-control"
          id="total_katha"
          placeholder="Enter Katha"
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Lessa</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_lessa"
          class="form-control"
          id="total_lessa"
          placeholder="Enter Lessa"
        />
      </div>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Period of possession</label
    >
  </div>
  <div class="form-group col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">Form Date</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="date"
          name="form_date"
          id="form_date"
          value="2021-03-21"
          disabled
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">To Date</label>
      </div>
      <div class="col-8">
        <input
          type="date"
          name="to_date"
          class="form-control"
          id="to_date"
          value="2021-03-21"
          disabled
        />
      </div>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Nature of possession –</label
    >
  </div>
  <div class="form-group col-md-6">
    <select
      name="possession_nature"
      id="possession_nature"
      disabled="disabled"
      class="form-control"
    >
      <option value="#">Agricultural</option>
    </select>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Purpose of the land used by the
      occupants(if any other than pt.5)</label
    >
  </div>
  <div class="form-group col-md-6">
    <input
      type="text"
      name="land_purpose_found"
      id="land_purpose_found"
      class="form-control"
      placeholder="Enter founded land purpose"
    />
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Check the land revenue details as
      fetch from the E-Khajana Database or check the Khajana receipt uploaded by
      applicant</label
    >
  </div>
  <div class="form-group col-md-6">
    <div class="row">
      <div class="col-6">
        <a href="#"><u>Land revenue details file</u></a>
      </div>
      <div class="col-6">
        <input
          type="file"
          name="lr_details"
          id="lr_details"
          class="form-control"
        />
      </div>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Copy of trace map of the proposed land
      clearly highlighting the propose land road/riverside reservation etc(if
      any)</label
    >
  </div>
  <div class="col-md-6">
    <input
      type="file"
      name="trace_map_file"
      id="trace_map_file"
      class="form-control"
    />
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Field visit report & geo tagged
      photograph of the land</label
    >
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">Field report</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="file"
          name="field_report"
          id="field_report"
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Geo tagged photo</label>
      </div>
      <div class="col-8">
        <input
          type="file"
          name="geo_tag_photo"
          class="form-control"
          id="geo_tag_photo"
        />
      </div>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Edit/correct errors in the
      application</label
    >
  </div>
  <div class="col-md-6">
    <input
      type="button"
      name="edit_application"
      id="edit_application"
      class="form-control btn btn-sm btn-primary text-white"
      value="Edit application"
    />
  </div>
</div>
