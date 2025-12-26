<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Occupation of the applicant</label
    >
  </div>
  <div class="col-md-6">
    <input
      type="text"
      name="occupantion"
      id="occupantion"
      class="form-control"
      value="Service"
      disabled
    />
  </div>
</div>
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
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Landed property of the petitioner and
      his family (if any) within the State</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="landed_property"
        id="landed_property1"
        value="option1"
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="landed_property"
        id="landed_property2"
        value="option2"
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
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
<div class="row p-2 px-5" >
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
      ><strong><?=$sl_count++?>.</strong> Chitha copy of the proposed
      land</label
    >
  </div>
  <div class="col-md-6">
    <input type="file" name="citha" id="citha" class="form-control" />
  </div>
</div>
<div class="row p-2 px-5" >
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
  <div class="col-md-6 text-justify">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
      VGR/PGR/Wet Land/ CS Land/Khas Govt Land/NR Govt Land/Green Belt
      area/reserved for Govt departments/ancient monuments/reserved for other
      purposes/RF/PRF/Un-classed Forest land/under Wild Life Sanctuary/or any
      land barred for allotment/settlement by a judicial pronouncement or any
      Central or State Legislation.</label
    >
  </div>
  <div class="col-md-6">
    <select class="form-control" name="settlement_type" id="settlement_type">
      <option value="#">Settlement PGR VGR land</option>
      <option value="#">Settlement Khasland</option>
      <option value="#">Settelment AP</option>
    </select>
  </div>
</div>
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
      15 KM radius from the periphery of GMC or within 5 KM periphery of other
      town or within 3 KM periphery of Revenue town.</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="falls_und_gmc"
        id="falls_und_gmc1"
        value="option1"
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="falls_und_gmc"
        id="falls_und_gmc2"
        value="option2"
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Specific comment on roadside
      /riverside reservation (if any, along with provision kept for road/drain
      wherever necessary)</label
    >
  </div>
  <div class="col-md-6">
    <textarea
      name="comment"
      id="comment"
      class="form-control"
      cols="30"
      rows="3"
    ></textarea>
  </div>
</div>
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether the petitioner is ST</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="whether_st"
        id="whether_st1"
        value="option1"
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="whether_st"
        id="whether_st2"
        value="option2"
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
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
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
      Tribal Belt/ Block.</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="whether_tribal"
        id="whether_tribal1"
        value="option1"
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="whether_tribal"
        id="whether_tribal2"
        value="option2"
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Comment with recommendation</label
    >
  </div>
  <div class="col-md-6">
    <textarea
      name="comment_with_recommen"
      id="comment_with_recommen"
      cols="30"
      rows="3"
      class="form-control"
    ></textarea>
  </div>
</div>
